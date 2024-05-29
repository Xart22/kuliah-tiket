<?php

namespace App;

use Controller;

class HomeController extends Controller
{
    public function index()
    {

        $event = new \Event();
        $events = $event->getEventUpcoming();

        $ticket = new \Ticket();
        foreach ($events as $key => $event) {
            $tickets = $ticket->getTicketsByEventId($event['id']);
            if ($tickets) {
                $events[$key]['tickets'] = $tickets;
            } else {
                $events[$key]['tickets'] = [];
            }
        }


        $this->view('app/index', ['events' => $events, 'title' => 'Beli Tiket Event Terbaru']);
    }

    public function profil()
    {

        $this->view('app/profil/index', ['title' => 'Profil']);
    }

    public function updateProfil()
    {
        $user = new \User();
        $user->update([
            'full_name' => $_POST['full_name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ]);

        $_SESSION['user']['full_name'] = $_POST['full_name'];
        $_SESSION['user']['email'] = $_POST['email'];
        $this->redirectWithMessage('/profil', 'Profil berhasil diupdate', 'success');
    }

    public function tiketSaya()
    {
        $order = new \Order();
        $orders = $order->getOrderDetailWithTicket($_SESSION['user']['id']);
        $this->view('app/tiket/index', ['orders' => $orders, 'title' => 'Tiket Saya']);
    }

    public function detailTiketSaya($id)
    {
        $order = new \Order();
        $order = $order->getOrderByOrderId($id);
        $this->view('app/tiket/detail', ['order' => $order, 'title' => 'Detail Tiket']);
    }
}
