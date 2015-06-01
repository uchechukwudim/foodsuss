<?php

class Database extends PDO {
      private $host = "localhost"; //
      private $username = "root";//root
      private $password = ""; // known
      private $database = "enri_users"; //enri_users
      private $database2 = "enri"; //enri
      public $Sdb;
    function __construct() {
        parent::__construct('mysql:host='.$this->host.';dbname='.$this->database.'', $this->username, $this->password);
       $this->Sdb = new PDO('mysql:host='.$this->host.';dbname='.$this->database2.'', $this->username, $this->password);
     
    }

   
    
}