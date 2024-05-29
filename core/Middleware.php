<?php
class Middleware
{
    public static function auth()
    {

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit();
        }
    }

    public static function OnlyOneTicket($ticket_id)
    {
        // $db = new Database;
        // $ticket = $db->fetchOne("SELECT * FROM tickets WHERE id = :id", ['id' => $ticket_id]);
        // if ($ticket['status'] == 'pending') {
        //     return true;
        // } else {
        //     return false;
        // }
    }
}
