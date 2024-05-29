<?php

namespace Admin;

use Controller;


class RedeemTicketController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $this->view('admin/redeem/index', ['title' => 'Redeem Ticket']);
    }

    public function redeem()
    {
        if (isset($_POST['barcode'])) {
            $order = new \Order();
            $result = $order->redeem($_POST['barcode']);
            if ($result) {
                $this->view('admin/redeem/index', ['title' => 'Redeem Ticket', 'success' => 'Tiket berhasil digunakan']);
            } else {
                $this->view('admin/redeem/index', ['title' => 'Redeem Ticket', 'error' => 'Tiket tidak ditemukan atau sudah digunakan']);
            }
        }
    }
}
