<?php

class Base
{
    protected $conn;

    public function __construct($db){
        $this->conn = $db;
    }
    //Get users
    public function get_items($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    //Get one single user using GET method and id as a parameter
    public function get_item($query)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}