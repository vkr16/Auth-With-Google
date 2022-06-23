<?php

namespace App\Controllers;

class Auth extends SessionController
{
    function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        if ($this->session->has('AO_user')) {
            if ($this->session->get('level') == 'user') {
                return redirect()->to(HOST_URL . '/user');
            } else {
                return redirect()->to(HOST_URL . '/admin');
            }
        } else {
            // TOP
            return view('auth/login');
            // BOTTOM
        }
    }


    public function authUser()
    {
        $email = $_POST['email'];
        $action = $_POST['action'];

        $userModel = model('UserModel', true, $db);
        if ($action == 'google') {
            if ($userModel->isExist($email)) {
                $user = $userModel->getUser($email);
                $sessionData = [
                    'AO_user' => $email,
                    'level' => $user['level']
                ];
                $this->session->set($sessionData);
                return '200';
            }
        }
    }

    public function register()
    {
        if ($this->session->has('AO_user')) {
            if ($this->session->get('level') == 'user') {
                return redirect()->to(HOST_URL . '/user');
            } else {
                return redirect()->to(HOST_URL . '/admin');
            }
        } else {
            // TOP
            $this->pending();
            return view('auth/register');
            // BOTTOM
        }
    }

    public function setup()
    {
        if ($this->session->has('pending') && !empty($this->session->get('pending'))) {
            $data = ['pending' => $this->session->get('pending')];

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
                $sessionData = [
                    'uid'   => $_POST['uid'],
                    'name'  => $_POST['name'],
                    'email' => $_POST['email']
                ];

                $this->session->set('pending', $sessionData);
                return "200";
            }
        } else {
            $this->session->remove('pending');
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
            // $this->setSession('AO_user', $email);
            $sessionData = [
                'AO_user' => $email,
                'level' => 'user'
            ];
            $this->session->set($sessionData);
            $this->pending();
        }
    }

    public function logout()
    {
        $this->session->remove('AO_user');
        $this->session->remove('level');
        return redirect()->to(HOST_URL . '/login');
    }
}
