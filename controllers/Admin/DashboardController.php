<?php

namespace Admin;

use Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $event = new \Event();
        $user = new \User();
        $log = new \Log();
        $order = new \Order();
        $events = $event->thisMonth();
        $eventCount = count($events);
        $totalSalesTicketThisMont = $order->totalSalesTicketThisMonth();
        $totalSalesTicket = $order->totalSalesTicketThisMonth();
        $totalUsers = $user->totalUsers();
        $log = $log->getLog();
        $this->view('admin/dashboard/index', ['title' => 'Dashboard', 'events' => $events, 'eventCount' => $eventCount, 'totalSalesTicketThisMont' => $totalSalesTicketThisMont, 'totalSalesTicket' => $totalSalesTicket, 'totalUsers' => $totalUsers, 'logs' => $log]);
    }
}
