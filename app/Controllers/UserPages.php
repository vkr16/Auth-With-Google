<?php

namespace App\Controllers;

class UserPages extends SessionController
{

    public function privCheckUser()
    {
        if ($this->sessionCheck() == 'admin') {
            return redirect()->to(HOST_URL . '/admin');
        } else if ($this->sessionCheck() == 'NoSession') {
            return redirect()->to(HOST_URL . '/login');
        }
    }

    public function index()
    {
        return view('pages/user/dashboard');
    }
}
