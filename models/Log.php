<?php
class Log extends Model
{
    public function create($data)
    {
        $this->db->execute("INSERT INTO logs (activity, created_at) VALUES (:activity, NOW())", $data);
    }
    function getLog()
    {
        return $this->db->fetchAll("SELECT * FROM logs");
    }
}
