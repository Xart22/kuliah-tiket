<?php


namespace App;

require 'assets\vendor\autoload.php';

use Controller;
use Picqer\Barcode\BarcodeGeneratorPNG;


class PaymentController extends Controller
{

    public function __construct()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-8hJsOOXioT0WYYVE5U-GNVKs';
    }
    public function index()
    {

        $event = new \Event();
        $events = $event->getEventUpcoming();

        $this->view('app/index', ['events' => $events]);
    }

    public function createTransaction()
    {
        try {
            $ticketId = $_POST['ticket_id'];
            $user_id = $_POST['user_id'];
            $ticket = new \Ticket();
            $event = $ticket->getEventByTicketId($ticketId);

            $tiket_price = $this->convertCurrencyToInt($event['ticket'][0]['price']);
            $user = new \User();
            $user = $user->getUserById($user_id);

            $params = [
                'transaction_details' => [
                    'order_id' => rand(),
                    'gross_amount' => $tiket_price,
                ],
                'customer_details' => [
                    'first_name' => $user['full_name'],
                    'last_name' => "",
                    'email' => $user['email'],
                    'phone' => ""
                ],
                'item_details' => [
                    [
                        'id' => $event['ticket'][0]['id'],
                        'price' => $tiket_price,
                        'quantity' => 1,
                        'name' => "Tiket " . $event['ticket'][0]['ticket_name']
                    ]
                ]
            ];


            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $this->response($snapToken);
        } catch (\Exception $e) {
            echo $e->getMessage();
            //$this->redirectWithMessage('/payment/error', 'error', $e->getMessage());
        }
    }

    public function pendingTransaction()
    {
        $data = $_POST;
        $tiket = new \Ticket();
        $tiket->updateSoldTicket([
            'id' => $data['ticket_id'],
            'sold' => 1
        ]);
        $barcode = $this->generateBarcode($data['ticket_id'] . '-' . $data['user_id']);
        file_put_contents('storage/barcode/' . $data['snaptoken'] . '.png', $barcode);
        $order = new \Order();
        $order->createPending([
            'order_id' => $data['order_id'],
            'user_id' => $data['user_id'],
            'event_ticket_id' => $data['ticket_id'],
            'snaptoken' => $data['snaptoken'],
            'barcode' => 'storage/barcode/' . $data['snaptoken'] . '.png',
            'created_by' => $data['user_id'],
        ]);
        $this->response('success');
    }

    public function successTransaction()
    {
        try {
            $data = $_POST;
            $tiket = new \Ticket();
            $tiket->updateSoldTicket([
                'id' => $data['ticket_id'],
                'sold' => 1
            ]);
            $barcode = $this->generateBarcode($data['ticket_id'] . '-' . $data['user_id']);
            file_put_contents('storage/barcode/' . $data['snaptoken'] . '.png', $barcode);
            $order = new \Order();
            $order->createSuccess([
                'order_id' => $data['order_id'],
                'user_id' => $data['user_id'],
                'event_ticket_id' => $data['ticket_id'],
                'snaptoken' => $data['snaptoken'],
                'barcode' => 'storage/barcode/' . $data['snaptoken'] . '.png',
                'created_by' => $data['user_id'],
                'status' => 'success'
            ]);
            $this->response('success');
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }

    public function updataStatusTransaction($id)
    {
        $order = new \Order();
        $order->updateStatusSuccess($id);
        $this->response('success');
    }


    public function generateBarcode($data)
    {

        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($data, $generator::TYPE_CODE_128);
        return $barcode;
    }



    function convertCurrencyToInt($currencyString)
    {
        // Hapus karakter yang tidak diperlukan
        $cleanedString = str_replace(['Rp.', ' ', '.'], '', $currencyString);

        // Konversi string menjadi integer
        $intValue = (int) $cleanedString;

        return $intValue;
    }
}
