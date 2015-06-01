<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
        
 require 'Database.php';
 class image {

     function __construct() {
         if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            
           $tableName = $_REQUEST['tableName'];
           $imageColumName = $_REQUEST['imageColumName'];
           $imageIdName = $_REQUEST['imageIdName'];
            $this->d = new Database();
            $sql = "SELECT ". $imageColumName ." FROM ". $tableName ." WHERE ". $imageIdName ." = :id";
            $sth = $this->d->Sdb->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            if($sth->execute(array(
                ':id' => $id
            )))
            {
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);

              header("content-type: image/jpeg");
              echo $data[0][$imageColumName];
            }
            else{
                $sth = $this->d->prepare($sql);
              $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                  ':id' => $id
              ));
                
                 $data = $sth->fetchAll(PDO::FETCH_ASSOC);

              header("content-type: image/jpeg");
              echo $data[0][$imageColumName];
            }
         }
         
         if(isset($_REQUEST['recieved_image']))
         {
             $image = $_REQUEST['recieved_image'];
             
              header("content-type: image/jpeg");
              echo $image;
             
         }
    }

}

$image = new image();
?>
