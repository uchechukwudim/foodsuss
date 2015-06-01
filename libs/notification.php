<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification
 *
 * @author Uche
 */
class notification extends Model {
    //put your code here
   
    function __construct() {
        $this->notification_id = '';
        $this->from_user_id = '';
        $this->to_user_id = '';
        $this->notification_message='';
        $this->status = 'UNSEEN';
        $this->type = '';
    }
    
    public function sendNotification($from_user_id, $to_user_id, $notification_massage, $status, $type)
    {
        
        $sql = "INSERT INTO notification VALUES (:notification_id, :from_user_id, :to_user_id, :notif_message, :status, :type, :time)";
        $sth = $this->db->prepare($sql);
        
        if($sth->execute(array(':notification_id'=>EMPTYSTRING,
                               ':from_user_id'=>$from_user_id,
                               ':to_user_id'=>$to_user_id,
                               ':notif_message'=>$notification_massage,
                               ':status'=>$status,
                               ':type'=>$type,
                               ':time'=>time())))
        {
            echo true;
        }
        else
        {
            echo $sth->errorInfo();
        }
    }
    
    public function getNotfication($reciver_user_id)
    {
        $notification = '';
        $sql = "SELECT from_user_id, notification_message, type, time FROM notification WHERE to_user_id = :to_user_id"
                . "AND status = :status ORDER BY time LIMIT 0,6";
        
        $sth = $this->db->prapare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':to_user_id'=>$reciver_user_id, ':status'=>$this->status));
        
        $notification = $sth->fetchAll();
        
        return $notification;
    }
    
    public function getNotificationCount($reciever_user_id)
    {
         $sql = "SELECT * time FROM notification WHERE to_user_id = :to_user_id"
                . "AND status = :status";
        
        $sth = $this->db->prapare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':to_user_id'=>$reciver_user_id, ':status'=>$this->status));
        
        $notification = $sth->fetchAll();
        
        return count($notification);
    }
    
    public function set_Notification_message($message)
    {
        $this->notification_message = $message;
    }
    
     public function get_Notification_message()
    {
        return $this->notification_message;
    }
}
