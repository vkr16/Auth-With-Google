<?php

namespace App\Controllers;

class UserPages extends SessionController
{

    public function index()
    {
        if ($this->session->has('AO_user')) {
            if ($this->session->get('level') == 'admin') {
                return redirect()->to(HOST_URL . '/admin');
            } else {
                // TOP
                return view('pages/user/dashboard');
                // BOTTOM
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
    }
}
