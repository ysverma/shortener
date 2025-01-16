<?php

namespace App\Controllers;

use App\Models\UserModel;
use Google_Client;
use Google\Service\Oauth2;

class AuthController extends BaseController
{
    protected $viewTitle = 'Authentication';
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Helper function for handling session data
    private function setSessionData($user)
    {
        session()->set([
            'user_id' => $user['id'],
            'username' => $user['username'],
            'isLoggedIn' => true
        ]);
    }

    // Display registration form
    public function register()
    {
        return view('auth/register', ['title' => $this->viewTitle . ' - Register']);
    }

    // Handle registration form submission
    public function registerSubmit()
    {
        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'matches[password]'
        ])) {
            return redirect()->to('/auth/register')->withInput()->with('errors', service('validation')->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
        ];

        // Save user data
        $this->userModel->save($userData);

        return redirect()->to('/auth/login')->with('success', 'Registration successful!');
    }

    // Display login form
    public function login()
    {
        return view('auth/login', ['title' => $this->viewTitle . ' - Login']);
    }

    // Handle login form submission
    public function loginSubmit()
    {

        if (!$this->validate([
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ])) {
            return redirect()->to('/auth/login')->withInput()->with('errors', service('validation')->getErrors());
        }

        try {
            $user = $this->userModel->where('email', $this->request->getPost('email'))->first();
        } catch (\Exception $e) {
            log_message('error', 'Database error while fetching user: ' . $e->getMessage());
            return redirect()->to('/auth/login')->with('error', 'An unexpected error occurred. Please try again later.');
        }

        if (!$user) {
            return redirect()->to('/auth/login')->with('error', 'The email address is not registered.Please enter correct email');
        }

        if (!password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->to('/auth/login')->with('error', 'The password is incorrect.');
        }

        $this->setSessionData($user);
        return redirect()->to('/url_shortener');
    }



    // Gmail login process
    public function gmailLogin()
    {
        $googleClient = $this->getGoogleClient();
        $googleClient->setPrompt('login');
        return redirect()->to($googleClient->createAuthUrl());
    }

    // Gmail login callback
    public function gmailCallback()
    {
        $googleClient = $this->getGoogleClient();
        if ($this->request->getGet('code')) {
            $token = $googleClient->fetchAccessTokenWithAuthCode($this->request->getGet('code'));

            if (isset($token['error'])) {
                return redirect()->to('/auth/login')->with('error', 'Failed to authenticate with Google: ' . $token['error']);
            }

            $googleClient->setAccessToken($token['access_token']);
            session()->set('access_token', $token['access_token']);

            $googleService = new Oauth2($googleClient);
            $userInfo = $googleService->userinfo->get();

            // Check if the user already exists
            $existingUser = $this->userModel->isUserAlreadyRegisteredByEmail($userInfo['email']);

            if ($existingUser) {
                $this->userModel->updateUserDetails([
                    'username' => $userInfo['given_name'] . ' ' . $userInfo['family_name'],
                    'updated_at' => date('Y-m-d H:i:s')
                ], $existingUser['id']);

                $this->setSessionData($existingUser);
            } else {
                $newUserId = $this->userModel->insertUserDetails([
                    'username' => $userInfo['given_name'] . ' ' . $userInfo['family_name'],
                    'email' => $userInfo['email'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $newUser = $this->userModel->find($newUserId);
                $this->setSessionData($newUser);
            }

            return redirect()->to('/url_shortener');
        }

        return redirect()->to('/auth/login');
    }

    // Logout and clear session
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }

    // Helper function to get Google Client instance
    private function getGoogleClient()
    {
        require_once APPPATH . 'ThirdParty/google-api-php-client--PHP8.3/vendor/autoload.php';

        $googleClient = new Google_Client();
        $googleClient->setClientId(getenv('GOOGLE_CLIENT_ID'));
        $googleClient->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
        $googleClient->setRedirectUri(base_url('auth/gmailCallback'));
        $googleClient->addScope('email');
        $googleClient->addScope('profile');

        return $googleClient;
    }

    // Display settings form
    public function settings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $userId = session()->get('user_id');
        if (!$userId || !($user = $this->userModel->find($userId))) {
            return redirect()->to('/auth/login')->with('error', 'User not found or session expired');
        }

        return view(
            'auth/settings',
            [
                'title' => $this->viewTitle . ' - Settings',
                'current_page' => 'settings',
                'user' => $user
            ]
        );
    }

    // Handle settings update form submission
    public function updateSettings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth/login');
        }

        $validation = service('validation');
        if (!$this->validate([
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'password' => 'permit_empty|min_length[8]',
            'confirm_password' => 'matches[password]'
        ])) {
            return redirect()->to('/auth/settings')->withInput()->with('errors', $validation->getErrors());
        }

        $userId = session()->get('user_id');
        $updatedData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
        ];

        if ($password = $this->request->getPost('password')) {
            $updatedData['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($userId, $updatedData);
        session()->set(['username' => $this->request->getPost('username'), 'email' => $this->request->getPost('email')]);

        return redirect()->to('/auth/settings')->with('success', 'Settings updated successfully!');
    }
}
