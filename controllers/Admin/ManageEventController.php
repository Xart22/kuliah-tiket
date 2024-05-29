<?php

namespace Admin;

use Controller;


class ManageEventController extends Controller
{
    public function __construct()
    {
        \Middleware::auth();
    }

    public function index()
    {
        $event = new \Event();
        $events = $event->getEventsWithTiketDetail();
        $this->view('admin/manage-event/index', ['title' => 'Manage Event', 'events' => $events]);
    }

    public function create()
    {

        $this->view('admin/manage-event/create', ['title' => 'Manage Event',]);
    }

    public function store()
    {
        // Validasi input
        $requiredFields = ['event_name', 'event_date', 'event_time', 'kota', 'description', 'terms'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $this->redirectWithMessage('/admin/manage-event/create', 'error', 'All fields are required');
                return;
            }
        }

        // Sanitasi data
        $data = [
            'event_name' => htmlspecialchars($_POST['event_name']),
            'event_date' => htmlspecialchars($_POST['event_date']),
            'event_time' => htmlspecialchars($_POST['event_time']),
            'kota' => htmlspecialchars($_POST['kota']),
            'description' => htmlspecialchars($_POST['description']),
            'terms' => htmlspecialchars($_POST['terms']),
            'created_by' => $_SESSION['user']['id']
        ];
        // Validasi dan upload poster
        if (!isset($_FILES['event_images']) || $_FILES['event_images']['error'] != UPLOAD_ERR_OK) {
            $this->redirectWithMessage('/admin/manage-event/create', 'error', 'Failed to upload image');
            return;
        }

        $poster = $_FILES['event_images'];
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $posterExt = strtolower(pathinfo($poster['name'], PATHINFO_EXTENSION));

        if (!in_array($posterExt, $allowedExts)) {
            $this->back();
            return;
        }

        $posterName = time() . '_' . basename($poster['name']);
        $posterTmp = $poster['tmp_name'];
        $posterPath = 'storage/uploads/' . $posterName;

        if (!move_uploaded_file($posterTmp, $posterPath)) {
            $this->redirectWithMessage('/admin/manage-event/create', 'error', 'Failed to upload image');
            return;
        }

        $data['event_images'] = $posterPath;

        // Simpan data event
        $event = new \Event();
        try {
            $event->create($data);
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name'] . ' created event ' . $data['event_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'success', 'Event created successfully');
        } catch (\Throwable $th) {

            unlink($posterPath);
            if ($th->errorInfo[1] == 1062) {
                $this->redirectWithMessage('/admin/manage-event/create', 'error', 'Event name already exists');
            } else {
                $this->redirectWithMessage('/admin/manage-event/create', 'error', 'Failed to create event');
            }
        }
    }

    public function edit($id)
    {
        $event = new \Event();
        $event = $event->getEventById($id);
        $this->view('admin/manage-event/edit', ['title' => 'Edit Event', 'event' => $event]);
    }

    public function update($id)
    {
        try {
            // Validasi input
            $requiredFields = ['event_name', 'event_date', 'event_time', 'kota', 'description', 'terms'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    $this->redirectWithMessage('/admin/manage-event/edit/' . $id, 'error', 'All fields are required');
                    return;
                }
            }

            // Sanitasi data
            $data = [
                'event_name' => htmlspecialchars($_POST['event_name']),
                'event_date' => htmlspecialchars($_POST['event_date']),
                'event_time' => htmlspecialchars($_POST['event_time']),
                'kota' => htmlspecialchars($_POST['kota']),
                'description' => htmlspecialchars($_POST['description']),
                'terms' => htmlspecialchars($_POST['terms']),
                'id' => $id,
                'updated_by' => $_SESSION['user']['id'],
            ];

            // Validasi dan upload poster
            if (isset($_FILES['event_images']) && $_FILES['event_images']['error'] == UPLOAD_ERR_OK) {
                $poster = $_FILES['event_images'];
                $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
                $posterExt = strtolower(pathinfo($poster['name'], PATHINFO_EXTENSION));

                if (!in_array($posterExt, $allowedExts)) {
                    $this->back();
                    return;
                }

                $posterName = time() . '_' . basename($poster['name']);
                $posterTmp = $poster['tmp_name'];
                $posterPath = 'storage/uploads/' . $posterName;

                if (!move_uploaded_file($posterTmp, $posterPath)) {
                    $this->redirectWithMessage('/admin/manage-event/edit/' . $id, 'error', 'Failed to upload image');
                    return;
                }

                $data['event_images'] = $posterPath;
            }

            // Simpan data event
            $event = new \Event();

            $event->update($data);
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' updated event ' . $data['event_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'success', 'Event updated successfully');
        } catch (\Throwable $th) {
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' failed to update event ' . $data['event_name']]);
            if ($th->errorInfo[1] == 1062) {
                $this->redirectWithMessage('/admin/manage-event/edit/' . $id, 'error', 'Event name already exists');
            } else {
                $this->redirectWithMessage('/admin/manage-event/edit/' . $id, 'error', 'Failed to update event');
            }
        }
    }

    public function delete($id)
    {
        $event = new \Event();
        $event = $event->getEventById($id);
        if ($event) {
            $event = new \Event();
            $event->delete($id);
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' deleted event ' . $event['event_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'success', 'Event deleted successfully');
        } else {
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' failed to delete event ' . $event['event_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'error', 'Event not found');
        }
    }

    public function createTiketForm($id)
    {
        $event = new \Event();
        $event = $event->getEventById($id);

        $this->view('admin/manage-event/ticket/create', ['title' => 'Create Tiket', 'event' => $event]);
    }

    public function createTiket($id)
    {
        $event = new \Event();
        $event = $event->getEventById($id);
        $ticket = new \Ticket();

        if (!$event) {
            $this->redirectWithMessage('/admin/manage-event/list', 'error', 'Event not found');
            return;
        }

        // Validasi input
        $requiredFields = ['ticket_name', 'price', 'qty'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $this->redirectWithMessage('/admin/manage-event/create-ticket/' . $id, 'error', 'All fields are required');
                return;
            }
        }

        // Sanitasi data
        $data = [
            'event_id' => $id,
            'ticket_name' => htmlspecialchars($_POST['ticket_name']),
            'price' => htmlspecialchars($_POST['price']),
            'qty' => htmlspecialchars($_POST['qty']),
            'created_by' => $_SESSION['user']['id']
        ];

        // Simpan data tiket

        try {
            $ticket->create($data);
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' created ticket ' . $data['ticket_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'success', 'Ticket created successfully');
        } catch (\Throwable $th) {
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' failed to create ticket ' . $data['ticket_name']]);
            if ($th->errorInfo[1] == 1062) {
                $this->redirectWithMessage('/admin/manage-event/create-ticket/' . $id, 'error', 'Ticket name already exists');
            } else {
                $this->redirectWithMessage('/admin/manage-event/create-ticket/' . $id, 'error', 'Failed to create ticket');
            }
        }
    }

    public function tiketDetail($id)
    {
        $event = new \Event();
        $event = $event->getEventById($id);
        if (!$event) {
            $this->redirectWithMessage('/admin/manage-event/list', 'error', 'Event not found');
            return;
        }

        $ticket = new \Ticket();
        $tickets = $ticket->getTicketsByEventId($id);
        $this->view('admin/manage-event/ticket/index', ['event' => $event, 'tickets' => $tickets]);
    }

    public function editTiket($id)
    {
        $ticket = new \Ticket();
        $ticket = $ticket->getTicketById($id);
        $event = new \Event();
        $event = $event->getEventById($ticket['event_id']);
        if (!$ticket) {
            $this->redirectWithMessage('/admin/manage-event/list', 'error', 'Ticket not found');
            return;
        }
        $this->view('admin/manage-event/ticket/edit', ['ticket' => $ticket, 'event' => $event]);
    }

    public function updateTiket($id)
    {
        // Validasi input
        $requiredFields = ['ticket_name', 'price', 'qty'];
        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                $this->redirectWithMessage('/admin/manage-event/edit-ticket/' . $id, 'error', 'All fields are required');
                return;
            }
        }

        // Sanitasi data
        $data = [
            'ticket_name' => htmlspecialchars($_POST['ticket_name']),
            'price' => htmlspecialchars($_POST['price']),
            'qty' => htmlspecialchars($_POST['qty']),
            'id' => $id,
            'updated_by' => $_SESSION['user']['id']
        ];
        // Simpan data tiket
        try {
            $ticket = new \Ticket;
            $ticket->update($data);
            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' updated ticket ' . $data['ticket_name']]);
            $this->redirectWithMessage('/admin/manage-event/list', 'success', 'Ticket updated successfully');
        } catch (\Throwable $th) {

            $log = new \Log();
            $log->create(['activity' => 'User ' . $_SESSION['user']['full_name'] . ' failed to update ticket ' . $data['ticket_name']]);
            $this->redirectWithMessage('/admin/manage-event/edit-ticket/' . $id, 'error', 'Failed to update ticket');
        }
    }
}
