<?php

namespace App\Controllers;

class SessionController extends BaseController
{

    protected $session;

    function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function sessionCheck()
    {
        if ($this->session->has('AO_user')) {
            $userModel = model('UserModel', true, $db);
            $userData = $userModel->getUser($this->session->get('AO_user'));
            return $userData['level'];
        } else {
            return 'NoSession';
        }
    }
}
