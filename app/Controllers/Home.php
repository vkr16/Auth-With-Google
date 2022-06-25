<?php

namespace App\Controllers;

class Home extends SessionController
{
    public function index()
    {
        return redirect()->to(HOST_URL . '/login');
    }
}
