<?php

namespace Admin;

use Controller;


class ManageUserController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $user = new \User();
        $users = $user->all();
        $this->view('admin/manage-user/index', ['title' => 'Manage User', 'users' => $users]);
    }

    public function store()
    {
        $user = new \User();
        $data = [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role' => $_POST['role']
        ];
        $user->createUserAdmin($data);
        $log = new \Log();
        $log->create(['activity' => 'Admin created user ' . $data['full_name']]);
        header('Location: /admin/manage-user');
    }

    public function delete()
    {
        $user = new \User();
        $user->delete($_POST['id']);
        $log = new \Log();
        $log->create(['activity' => 'Admin deleted user ' . $_POST['full_name']]);
        header('Location: /admin/manage-user');
    }

    public function update()
    {
        $user = new \User();
        $data = [
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $user->update($data);
        $log = new \Log();
        $log->create(['activity' => 'Admin updated user ' . $data['full_name']]);
        header('Location: /admin/manage-user');
    }
}
