<?php

class Order extends Model
{
    public function createPending($data)
    {
        $this->db->execute("INSERT INTO orders (user_id, event_ticket_id, snaptoken, barcode, created_by,order_id) VALUES (:user_id, :event_ticket_id, :snaptoken, :barcode, :created_by,:order_id)", $data);
    }

    public function createSuccess($data)
    {
        $this->db->execute("INSERT INTO orders (user_id, event_ticket_id, snaptoken, barcode, created_by,order_id,status) VALUES (:user_id, :event_ticket_id, :snaptoken, :barcode, :created_by,:order_id,:status)", $data);
    }

    public function getOrderByUserId($user_id)
    {
        return $this->db->fetchAll("SELECT * FROM orders WHERE user_id = :user_id", ['user_id' => $user_id]);
    }

    public function getOrderDetailWithTicket($order_id)
    {
        return $this->db->fetchAll("SELECT orders.*, event_tickets.*, events.* FROM orders JOIN event_tickets ON orders.event_ticket_id = event_tickets.id JOIN events ON event_tickets.event_id = events.id WHERE orders.user_id = :user_id", ['user_id' => $order_id]);
    }

    public function getOrderByOrderId($order_id)
    {
        return $this->db->fetch("SELECT * FROM orders WHERE order_id = :order_id", ['order_id' => $order_id]);
    }

    public function updateStatusSuccess($order_id)
    {
        $this->db->execute("UPDATE orders SET status = 'success' WHERE order_id = :order_id", ['order_id' => $order_id]);
    }

    public function updateStatusPending($order_id)
    {
        $this->db->execute("UPDATE orders SET status = 'pending' WHERE order_id = :order_id", ['order_id' => $order_id]);
    }

    public function totalSalesTicketThisMonth()
    {
        return $this->db->fetch("SELECT COUNT(*) as total FROM orders WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");
    }

    public function redeem($order_id)
    {
        $order = $this->db->fetch("SELECT * FROM orders WHERE order_id = :order_id AND status = 'success' LIMIT 1", ['order_id' => $order_id]);

        if ($order) {
            $this->db->execute("UPDATE orders SET status = 'used' WHERE order_id = :order_id", ['order_id' => $order_id]);
            return true;
        } else {
            return false;
        }
    }

    public function getOrderByTiketId($tiket_id)
    {

        $orders = $this->db->fetchAll(
            "SELECT * FROM orders WHERE event_ticket_id IN (" . implode(',', array_map('intval', $tiket_id)) . ") AND (status = 'success' OR status = 'used')"
        );


        $tickets = $this->db->fetchAll("SELECT * FROM event_tickets WHERE id IN (" . implode(',', array_map('intval', $tiket_id)) . ")");


        $groupedOrders = [];
        foreach ($orders as $order) {
            $ticketId = $order['event_ticket_id'];
            if (!isset($groupedOrders[$ticketId])) {
                $ticket = $tickets[array_search($ticketId, array_column($tickets, 'id'))];
                $groupedOrders[$ticketId] = [
                    'ticket' => $ticket,
                    'orders' => [],
                    'total_qty' => 0,
                    'total_sold' => 0,
                ];
            }
            $groupedOrders[$ticketId]['orders'][] = $order;
            if ($order['status'] == 'success' || $order['status'] == 'used') {
                $groupedOrders[$ticketId]['total_sold'] += 1;
            }
        }

        return $groupedOrders;
    }
}
