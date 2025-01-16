<?php

namespace App\Controllers;

use App\Models\UrlModel;

class UrlShortenerController extends BaseController
{
    protected $urlModel;

    public function __construct()
    {
        $this->urlModel = new UrlModel();
    }

    public function index()
    {
        return view('url_shortener/index');
    }

    public function fetchMetadata()
    {
        $input = $this->request->getJSON();
        $url = $input->url;

        $metadata = $this->getUrlMetadata($url);

        return $this->response->setJSON($metadata);
    }

    private function getUrlMetadata($url)
    {
        $metadata = [
            'success' => false,
            'title' => 'No title found',
            'description' => 'No description found',
            'image' => '',
            'domain' => '',
            'link' => $url,
        ];

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            $html = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception('cURL error: ' . curl_error($ch));
            }

            curl_close($ch);

            // Extract metadata using regex
            if (
                preg_match('/<meta property="og:title" content="(.*?)"/', $html, $matches) ||
                preg_match('/<title>(.*?)<\/title>/', $html, $matches)
            ) {
                $metadata['title'] = $matches[1];
            }

            if (
                preg_match('/<meta property="og:description" content="(.*?)"/', $html, $matches) ||
                preg_match('/<meta name="description" content="(.*?)"/', $html, $matches)
            ) {
                $metadata['description'] = $matches[1];
            }

            if (
                preg_match('/<meta property="og:image" content="(.*?)"/', $html, $matches) ||
                preg_match('/<img[^>]+src=["\'](.*?)["\']/i', $html, $matches)
            ) {
                $metadata['image'] = $matches[1];
            }

            $parsedUrl = parse_url($url);
            $metadata['domain'] = $parsedUrl['host'] ?? '';

            $metadata['success'] = true;
        } catch (\Exception $e) {
            $metadata['success'] = false;
            $metadata['error'] = $e->getMessage();
        }

        return $metadata;
    }


    public function shorten()
    {
        if (!$this->validate([
            'url' => 'required|valid_url',
        ])) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => \Config\Services::validation()->getErrors(),
            ]);
        }

        $originalUrl = $this->request->getPost('url');
        $customAlias = $this->request->getPost('alias');
        $shortUrl = $this->generateShortUrl($customAlias);

        if ($customAlias && $this->urlModel->where('short_url', $customAlias)->first()) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => ['Alias already taken. Please choose a different alias.']
            ]);
        }

        while ($this->urlModel->where('short_url', $shortUrl)->first()) {
            $shortUrl = $this->generateShortUrl();
        }

        $userId = session()->get('user_id');
        $this->urlModel->save([
            'original_url' => $originalUrl,
            'short_url' => $shortUrl,
            'user_id' => $userId,
        ]);

        $parsedUrl = parse_url($originalUrl);
        $domain = $parsedUrl['host'] ?? '';

        return $this->response->setJSON([
            'success' => true,
            'shortened_url' => base_url($shortUrl),
            'domain' => $domain,
            'original_url' => $originalUrl,
        ]);
    }

    private function generateShortUrl($customAlias = null)
    {
        if ($customAlias) {
            return $customAlias;
        }

        return substr(md5(uniqid('', true)), 0, 6);
    }

    public function analytics()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');

        if (!$userId) {
            return redirect()->to('/auth/login')->with('error', 'User session is invalid.');
        }

        $urls = $this->urlModel->where('user_id', $userId)->findAll();

        $clicks24h = $this->urlModel->getClicksLast24Hours($userId);
        $clicksWeek = $this->urlModel->getClicksLastWeek($userId);
        $clicksMonth = $this->urlModel->getClicksLastMonth($userId);

        return view('url_shortener/analytics', [
            'title' => 'Analytics',
            'current_page' => 'analytics',
            'urls' => $urls,
            'clickData24h' => $clicks24h,
            'clickDataWeek' => $clicksWeek,
            'clickDataMonth' => $clicksMonth,
            'totalClicks' => array_sum(array_column($urls, 'clicks')),
        ]);
    }

    public function redirect($shortUrl)
    {
        $url = $this->urlModel->where('short_url', $shortUrl)->first();

        if ($url) {

            $this->urlModel->update($url['id'], [
                'clicks' => $url['clicks'] + 1
            ]);

            return redirect()->to($url['original_url']);
        } else {
            return redirect()->to('/url_shortener')->with('error', 'URL not found!');
        }
    }
}
