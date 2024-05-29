<?php

namespace Auth;

use Controller;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        $this->view('auth/register');
    }

    public function register()
    {
        $fields = ['first_name', 'last_name', 'email', 'password'];
        $data = [];
        foreach ($fields as $field) {
            $data[$field] = $_POST[$field];
        }

        try {
            $userModel = new \User();
            $userModel->createUser($data);
            $user = $userModel->getUserByEmail($data['email']);
            $_SESSION['user'] = $user;

            $log = new \Log();
            $log->create(['activity' => 'User' . $user['first_name'] . ' ' . $user['last_name'] . ' registered']);

            if ($user['role'] == 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
        } catch (\Throwable $th) {
            if (isset($th->errorInfo) && $th->errorInfo[1] == 1062) {
                $error = 'Email already registered';
            } else {
                $error = $th->getMessage();
            }
            $this->view('auth/register', ['error' => $error]);
        }
    }

    public function showLoginForm()
    {
        if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['role'] == 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
            exit();
        }
        $this->view('auth/login');
    }

    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = 'Email and Password are required';
            $this->view('auth/login', ['error' => $error]);
            return;
        }

        $userModel = new \User();
        $user = $userModel->getUserByEmail($email);

        if ($user && isset($user['password']) && password_verify($password, $user['password'])) {
            unset($user['password']);
            $_SESSION['user'] = $user;
            $log = new \Log();
            $log->create(['activity' => 'User' . $user['full_name'] . ' logged in']);
            if ($user['role'] == 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
        } else {
            $error = 'Invalid email or password';
            $this->view('auth/login', ['error' => $error]);
        }
    }

    public function logout()
    {

        $log = new \Log();
        $log->create(['activity' => 'User' . $_SESSION['user']['full_name'] . 'logged out']);
        unset($_SESSION['user']);
        session_destroy();
        header('Location: /');
    }
}
