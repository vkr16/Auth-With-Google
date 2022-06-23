<?php

namespace App\Controllers;

class Home extends SessionController
{
    public function index()
    {
        return view('welcome_message');
    }
}
