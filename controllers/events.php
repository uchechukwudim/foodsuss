<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventsAndStuffs
 *
 * @author Uche
 */
class events extends Controller{
    //put your code here
    function __construct() {
          parent::__construct();
          $this->sessionCheck();
          
          
    }
    
    public function index()
    {
        $this->model->index();
    }
    
    public function eventsForYou()
    {
        $this->model->eventsForyou();
    }
    
    public function eventsBoard()
    {
        $this->model->eventsBoard();
    }
    
    public function attendEvent()
    {
        $user_id = $_POST['user_id'];
        $event_id = $_POST['event_id'];
        $privacy = $_POST['privacy'];
        $this->model->attendEvent($user_id, $event_id, $privacy);
    }
    
    public function declineEvent()
    {
         $user_id = $_POST['user_id'];
        $event_id = $_POST['event_id'];
     
        $this->model->declineEvent($user_id, $event_id);
    }
    
    public function processEvent()
    {
       
        
         if(isset($_FILES))
         {
              $exploadWith = '.';
             $file_name = $_FILES['file']['name'];
             $exp_name = explode($exploadWith , $file_name);
             $ext = end($exp_name);
             $file_ext = strtolower($ext);
             $file_size = $_FILES['file']['size'];
             $file_temp = $_FILES['file']['tmp_name'];
           
             
             if($this->processImage($file_name, $file_ext, $file_size, $file_temp))
             {
                 $imageData = file_get_contents( $_FILES['file']['tmp_name']);
                 $imageName = $file_name;
                 $eventName = $_POST['eventName'];
                 $eventDesc = $_POST['eventDes'];
                 $eventLocation = $_POST['location'];
                 $eventDate = $_POST['date'];
                 $eventTime = $_POST['time'];
                 $eventType = $_POST['eventType'];
                 $privacy = $_POST['privacy'];
                 $invitedFriends = json_decode($_POST['invitedFriends']);
                 $friendsCount = $_POST['friendsCount'];
                 
               // var_dump($invitedFriends );
                 $this->model->processEvent($eventName, $eventDesc, $imageName , $imageData, $eventLocation, $eventDate, $eventTime, $eventType, $privacy, $invitedFriends,$friendsCount);
                
             }
         }
    }
    
        function getFriends()
        {
            $this->model->getFriends();
        }
 }
