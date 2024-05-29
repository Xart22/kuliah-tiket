<?php
class Payment extends Model
{
    public function create($data)
    {
        $this->db->execute("INSERT INTO payments (order_id, transaction_status, payment_type, fraud_status, transaction_time, transaction_id, status_message, gross_amount, user_id) VALUES (:order_id, :transaction_status, :payment_type, :fraud_status, :transaction_time, :transaction_id, :status_message, :gross_amount, :user_id)", $data);
    }
}
