<?php

namespace App\Controllers;

class Auth extends SessionController
{
    function __construct()
    {
        parent::__construct();
    }

    public function privCheck()
    {
        if ($this->sessionCheck() == 'admin') {
            return redirect()->to(HOST_URL . '/admin');
        } else if ($this->sessionCheck() == 'user') {
            return redirect()->to(HOST_URL . '/user');
        }
    }

    public function login()
    {
        // return $this->privCheck();
        return view('auth/login');
    }


    public function authUser()
    {
        $email = $_POST['email'];
        $action = $_POST['action'];

        $userModel = model('UserModel', true, $db);
        if ($action == 'google') {
            if ($userModel->isExist($email)) {
                $this->setSession('AO_user', $email);
                return '200';
                // return "Session : " . $_SESSION['AO_user'];
            }
        }
    }

    public function register()
    {
        $this->pending();
        return view('auth/register');
    }

    public function setup()
    {
        if (isset($_SESSION['pending']) && !empty($_SESSION['pending'])) {

            $data = [
                'pending' => $_SESSION['pending']
            ];

            return view('auth/setup', $data);
        } else {
            return redirect()->to(HOST_URL . '/register');
        }
    }

    public function pending()
    {
        $userModel = model('UserModel', true, $db);
        if (isset($_POST['action']) && $_POST['action'] == "set") {
            $isExist = $userModel->isExist($_POST['email']);
            if ($isExist == true) {
                return "409";
            } else {
                $_SESSION['pending'] = [
                    'uid'   => $_POST['uid'],
                    'name'  => $_POST['name'],
                    'email' => $_POST['email']
                ];
                return "200";
            }
        } else {
            unset($_SESSION['pending']);
        }
    }

    public function addNewUser()
    {
        $name = esc($_POST['name']);
        $email = esc($_POST['email']);
        $surname = esc($_POST['surname']);
        $password = esc($_POST['password']);
        $uid = esc($_POST['uid']);

        $password = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'name' => $name,
            'email' => $email,
            'alias' => $surname,
            'password' => $password,
            'uid' => $uid,
        ];
        $userModel = model('UserModel', true, $db);
        $result = $userModel->insertUser($data);

        if ($result == true) {
            $this->setSession('AO_user', $email);
            $this->pending();
        }
    }

    public function logout()
    {
        unset($_SESSION['AO_user']);
        return redirect()->to(HOST_URL . '/login');
    }
}
