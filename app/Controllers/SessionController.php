<?php

namespace App\Controllers;

class SessionController extends BaseController
{
    function __construct()
    {
        session_start();
        // $session = \Config\Services::session();
    }

    public function setSession($sessName, $sessData)
    {
        $_SESSION[$sessName] = $sessData;
    }

    public function sessionCheck()
    {
        if (isset($_SESSION['AO_user'])) {
            $userModel = model('UserModel', true, $db);
            $userData = $userModel->getUserByEmail($_SESSION['AO_user']);
            return $userData['level'];
        } else {
            return 'NoSession';
        }
    }
}
