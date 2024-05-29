<?php

namespace App;

use Controller;

class EventController extends Controller
{
    public function index($id)
    {

        $event = new \Event();
        $events = $event->getEventByIdWithTiketDetail($id);

        $this->view('app/event/detail', ['title' => 'Tiket ' . $events['event_name'], 'events' => $events]);
    }

    public function order($id)
    {
        $ticket = new \Ticket();
        $event = $ticket->getEventByTicketId($id);


        $this->view('app/event/order/index', ['title' => 'Pembilian Tiket ' . $event['event_name'], 'event' => $event]);
    }
}
