<?php
class Ticket extends Model
{
    public function create($data)
    {
        $this->db->execute("INSERT INTO event_tickets (event_id, ticket_name, price, qty, created_by) VALUES (:event_id, :ticket_name, :price, :qty, :created_by)", $data);
    }

    public function getTicketsByEventId($eventId)
    {
        return $this->db->fetchAll("SELECT * FROM event_tickets WHERE event_id = ?", [$eventId]);
    }

    public function getTicketById($id)
    {
        return $this->db->fetch("SELECT * FROM event_tickets WHERE id = ?", [$id]);
    }

    public function update($data)
    {
        $this->db->execute("UPDATE event_tickets SET ticket_name = :ticket_name, price = :price, qty = :qty, updated_at = NOW(), updated_by = :updated_by WHERE id = :id", $data);
    }

    public function delete($id)
    {
        $this->db->execute("DELETE FROM event_tickets WHERE id = ?", [$id]);
    }

    public function updateSoldTicket($data)
    {
        $this->db->execute("UPDATE event_tickets SET sold = sold + :sold WHERE id = :id", $data);
    }

    public function getEventByTicketId($id)
    {
        $event = $this->db->fetch("SELECT * FROM events WHERE id = (SELECT event_id FROM event_tickets WHERE id = ?)", [$id]);
        $event['ticket'] = $this->getTicketsByEventId($event['id']);
        return $event;
    }
}
