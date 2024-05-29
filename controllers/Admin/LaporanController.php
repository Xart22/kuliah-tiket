<?php

namespace Admin;

use Controller;


class LaporanController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $events = new \Event;
        $events = $events->getEventsWithTiketDetail();

        $this->view('admin/laporan/index', ['title' => 'Report', 'events' => $events]);
    }

    public function report()
    {
        $event_id = $_POST['event'];
        $event = new \Event;
        $event = $event->getEventByIdWithTiketDetail($event_id);

        $tiket_id = [];

        foreach ($event['tickets'] as $ticket) {

            $tiket_id[] = $ticket['id'];
        }
        $order = new \Order;
        $order = $order->getOrderByTiketId($tiket_id);

        $this->view('admin/laporan/index', ['title' => 'Report', 'event' => $event, 'orders' => $order]);
    }
}
