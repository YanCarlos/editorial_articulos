<?php

class Connection {

    private $userbd;
    private $passworddb;
    private $database;    
    private $host;
    private $connect;

    public function connect() {
        //MYSQL
        $this->userbd = "root";        
        $this->passworddb = "";

        $this->database = "editorial";        
        $this->host = "localhost";
        
        try {
            //MYSQL
            $this->connect = new PDO("mysql:host=$this->host;dbname=$this->database", $this->userbd, $this->passworddb);
                        
            // set the PDO error mode to exception
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnect() {
        return $this->connect;
    }

}
