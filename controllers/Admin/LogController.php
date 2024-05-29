<?php

namespace Admin;

use Controller;


class LogController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $this->view('admin/log/index', ['title' => 'Log']);
    }
}
