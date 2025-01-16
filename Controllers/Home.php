<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function Home()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/url_shortener');
        }
        return view('landing_page');
    }
}
