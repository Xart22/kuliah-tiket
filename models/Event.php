<?php
class Event extends Model
{
    public function create($data)
    {
        $this->db->execute("INSERT INTO events (event_name, event_images, event_date, event_time, kota, description, terms,created_by) VALUES (:event_name, :event_images, :event_date, :event_time, :kota, :description, :terms,:created_by)", $data);
    }

    public function getEventsWithTiketDetail()
    {
        $events = $this->db->fetchAll("SELECT * FROM events");
        $eventTickets = $this->db->fetchAll("SELECT * FROM event_tickets WHERE event_id IN (SELECT id FROM events)");

        foreach ($events as $key => $event) {
            $events[$key]['tickets'] = [];
            foreach ($eventTickets as $ticket) {
                if ($ticket['event_id'] == $event['id']) {
                    $events[$key]['tickets'][] = $ticket;
                }
            }
        }

        return $events;
    }


    public function getEventById($id)
    {
        return $this->db->fetch("SELECT * FROM events WHERE id = ?", [$id]);
    }

    public function getEventByIdWithTiketDetail($id)
    {
        $event = $this->db->fetch("SELECT * FROM events WHERE id = ?", [$id]);
        $eventTickets = $this->db->fetchAll("SELECT * FROM event_tickets WHERE event_id = ?", [$id]);
        $event['tickets'] = $eventTickets;
        return $event;
    }


    public function update($data)
    {
        if (isset($data['event_images'])) {
            $this->db->execute("UPDATE events SET event_name = :event_name, event_images = :event_images, event_date = :event_date, event_time = :event_time, kota = :kota, description = :description, terms = :terms, updated_at = NOW() , updated_by = :updated_by WHERE id = :id", $data);
        } else {
            $this->db->execute("UPDATE events SET event_name = :event_name, event_date = :event_date, event_time = :event_time, kota = :kota, description = :description, terms = :terms, updated_at = NOW() , updated_by = :updated_by WHERE id = :id", $data);
        }
    }

    public function delete($id)
    {
        $this->db->execute("DELETE FROM events WHERE id = ?", [$id]);
    }

    public function getEventUpcoming()
    {
        return $this->db->fetchAll("SELECT * FROM events WHERE event_date >= CURDATE()");
    }

    public function getEventPast()
    {
        $event =  $this->db->fetchAll("SELECT * FROM events WHERE event_date < CURDATE()");

        return $event;
    }

    public function thisMonth()
    {
        return $this->db->fetchAll("SELECT * FROM events WHERE MONTH(event_date) = MONTH(CURDATE())");
    }
}
