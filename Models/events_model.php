<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eventsAndStuffs_model
 *
 * @author Uche
 */
class events_model extends Model{
    //put your code here
     function __construct()
     {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
     }
     
     public function index()
     {
        $public = 'Public';
        $guest_friends = 'Guest and Friends';
        $this->view->id = $this->id;
        $this->view->js = array('events/js/uploadImage.js',
                                'events/js/event.js',
                                'events/js/eventInvites.js',
                                'profile/js/friendsFollowers.js');
      
        $this->view->css = array('css/events/eventssheet.css',
                                  'css/events/EventLogDialogBox.css',
                                  'css/profile/followfriendssheet.css',
                                    'css/foodfinder/food/errorDialgBoxSheet.css',
                                   'css/events/eventInvitesDialogBox.css',
                                   'css/events/errorDialgBoxSheet.css');
        
         $sql0 = "SELECT FirstName, LastName, picture FROM user_details WHERE user_id = :user_id";
        $sth0 = $this->db->prepare($sql0);
        $sth0->setFetchMode(PDO::FETCH_ASSOC);
        $sth0->execute(array(':user_id'=>  $this->id));
        $userDetails = $sth0->fetchAll();
        
        $sql = 'SELECT E.event_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type
                FROM EVENTS AS E
                INNER JOIN user_details AS UD ON E.city = UD.city
                WHERE UD.user_id = :user_id AND E.privacy = :public  AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION 
                
                SELECT E.event_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type
                FROM EVENTS AS E
                INNER JOIN user_details AS UD ON E.country = UD.country
                WHERE UD.user_id = :user_id AND E.privacy = :public  AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY DATE DESC
                LIMIT 0 , 5';
         $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id'=> $this->id, ':public'=>$public));
        $events = $sth->fetchAll();
        
        $eventAttendCount = $this->getAttendingCount($events);
        $myPublicAttendingEvent = $this->getMyAttendingPublicEvent($events);
        $eventInvited = $this->getInvitedCount($events);
       
       $this->view->rendereEvents("events/index", $userDetails, $events, $eventAttendCount, $eventInvited, $myPublicAttendingEvent);
     
     }
     
     function eventsForYou(){
         $invite_stat = 'Invited';
         $notInvited = 'Not Invited';
         $accept = 'Accept';
         $sql = 'SELECT E.event_id, E.user_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type, IV.status
                 FROM events AS E
                 INNER JOIN event_invites AS IV ON E.event_id = IV.event_id
                 AND IV.user_id =:user_id AND IV.invite_status = :invite_status AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                 UNION

                 SELECT E.event_id, E.user_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type, IV.status FROM events AS E
                 INNER JOIN event_invites AS IV ON E.event_id = IV.event_id
                 AND IV.user_id =1 AND IV.invite_status = :Not_Invited AND date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND IV.status = :accept

                 ORDER BY date DESC 
                 LIMIT 0 , 5';
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id'=> $this->id, 
                            ':invite_status'=>$invite_stat,
                            ':Not_Invited'=> $notInvited,
                            ':accept'=> $accept));
        $events = $sth->fetchAll();
        
        $eventAttendCount = $this->getAttendingCount($events);
        $eventInvited = $this->getInvitedCount($events);
        
        echo json_encode($this->LoadEvents4U($events, $eventAttendCount, $eventInvited));
     }
     
     function eventsBoard()
     {
          $public = 'Public';
     
         $sql = 'SELECT E.event_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type
                FROM events AS E
                INNER JOIN user_details AS UD ON E.city = UD.city
                WHERE UD.user_id = :user_id AND E.privacy = :public  AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION 
                
                SELECT E.event_id, E.user_id, E.event_name, E.event_details, E.where, E.date, E.time, E.event_pictureCover, E.event_type
                FROM events AS E
                INNER JOIN user_details AS UD ON E.country = UD.country
                WHERE UD.user_id = :user_id AND E.privacy = :public  AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY date DESC
                LIMIT 0 , 5';
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id'=> $this->id, ':public'=>$public));
        $events = $sth->fetchAll();
        
        $eventAttendCount = $this->getAttendingCount($events);
      $myPublicAttendingEvent = $this->getMyAttendingPublicEvent($events);
        $eventInvited = $this->getInvitedCount($events);
        
        echo json_encode($this->LoadEventB($events, $eventAttendCount, $eventInvited,  $myPublicAttendingEvent));
     }
     private function getAttendingCount($events)
     {
          $eventAttendCounts = array();
             $Inv_status = 'Invited';
               $Inv_stat = 'Not Invited';
             $status = 'Accept';
          for($i =0; $i< count($events); $i++)
          {
                $sql = "SELECT * FROM event_invites WHERE event_id = :event_id AND (invite_status = :invite_status || invite_status = :invite_stat ) AND status =:status";
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                    ':event_id'=>$events[$i]['event_id'],
                    ':invite_status'=>$Inv_status,
                    ':invite_stat'=>$Inv_stat,
                    ':status'=>$status
                     ));
                $tempEvent = $sth->fetchAll();
                
                $eventAttendCounts[$i] = count($tempEvent);
          }
        
          return $eventAttendCounts;
     }
     

     
     private function getInvitedCount($events)
     {
          $eventInvitedCounts = array();
          $Inv_status = 'Invited';
          for($i =0; $i< count($events); $i++)
          {
                $sql = "SELECT * FROM event_invites WHERE event_id = :event_id AND invite_status = :status";
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(':event_id'=>$events[$i]['event_id'], ':status'=>$Inv_status));
                $tempEvent = $sth->fetchAll();
                
                 $eventInvitedCounts[$i] = count($tempEvent);
          }
        
          return  $eventInvitedCounts;
     }
     
     private function getMyAttendingPublicEvent($events)
     {
         $myPubliceventInvitedCounts = array();
          $Inv_status = 'Not Invited';
          $status = 'Accept';
          for($i =0; $i< count($events); $i++)
          {
                $sql = "SELECT * FROM event_invites WHERE event_id = :event_id AND user_id = :user_id AND invite_status = :invite_status AND status = :status";
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(':event_id'=>$events[$i]['event_id'], 
                                    ':user_id'=> $this->id, 
                                    ':invite_status'=>$Inv_status,
                                    ':status' => $status));
                $tempEvent = $sth->fetchAll();
                
                 $myPubliceventInvitedCounts[$i] = count($tempEvent);
          }
        
          return  $myPubliceventInvitedCounts;
     }

     private function LoadEvents4U($events, $eventAttendCount, $eventInvited)
     {
         $output ='';
         $privacy = 'private';
         for($looper = 0; $looper < count($events); $looper++)
         {
             $output .= '<div class="anEvent">
                <div class="eventImage"><img src="data:image/jpeg;base64,'.base64_encode($events[$looper]['event_pictureCover']).'" width="150" height="120" alt=""></div>
                <div class="eventName">'.$events[$looper]['event_name'].'</div><br>
                <div class="eventDateTime">'.$events[$looper]['date']." At ".$events[$looper]['time'].'</div>
                <div class="eventWhere">'.$events[$looper]['where'].'</div>
                <div class="yourInvited">'.$this->getUserFirstName($events[$looper]['user_id'])." ".$this->getUserLastName($events[$looper]['user_id']).' invited you to this event</div>
                
                <div class="eventAccept" onclick="attendEvent(\''.$this->id.'\', \''.$events[$looper]['event_id'].'\', \''.$privacy.'\',  \''.$looper.'\')">'.$this->getAttendingText($events[$looper]['status']).'</div><div class="Decline Df4"  onclick="declineEvent(\''.$this->id.'\', \''.$events[$looper]['event_id'].'\', \''.$looper.'\')">'.$this->getDeclineText($events[$looper]['status']).'</div>
                <div class="eventInfo" ><span class="eventAttending">'.$eventAttendCount[$looper].' attending</span> <span class="eventInvited">'.$eventInvited[$looper].' invited</span></div>
            </div>';
         }
         
         return $output;
     }
     
    private function LoadEventB($events, $eventAttendCount, $eventInvited, $myPublicAttendingEvent)
     {
         $output ='';
         $privacy = 'Public';
         for($looper = 0; $looper < count($events); $looper++)
         {
             $output .= '<div class="anEvent">
                <div class="eventImage"><img src="data:image/jpeg;base64,'.base64_encode($events[$looper]['event_pictureCover']).'" width="150" height="120" alt=""></div>
                <div class="eventName">'.$events[$looper]['event_name'].'</div><br>
                <div class="eventDateTime">'.$events[$looper]['date']." At ".$events[$looper]['time'].'</div>
                <div class="eventWhere">'.$events[$looper]['where'].'</div>
                <div class="yourInvited"></div>
                
                <div class="eventAccept" onclick="attendEvent(\''.$events[$looper]['user_id'].'\', \''.$events[$looper]['event_id'].'\', \''.$privacy.'\',  \''.$looper.'\')">'.$this->geteventBAttendText($myPublicAttendingEvent[$looper]).'</div><div class="Decline">Decline</div>
                <div class="eventInfo"><span class="eventAttending">'.$eventAttendCount[$looper].' attending</span> <span class="eventInvited">'.$eventInvited[$looper].' invited</span></div>
            </div>';
         }
         
         return $output;
     }
     
     function attendEvent($user_id, $event_id, $privacy)
     {
        $pub = 'Public';
        
        if($privacy == $pub)
        {
            $this->runPublicAttending($user_id, $event_id);
        }
        else{
            $this->runPrivateAttending($user_id, $event_id);
        }
     }
         
   private function runPublicAttending($user_id, $event_id)
   {
              $sql1 = "SELECT * FROM event_invites WHERE user_id = :user_id AND event_id = :event_id";
                $sth1 = $this->db->prepare($sql1);
                $sth1->setFetchMode(PDO::FETCH_ASSOC);
                $sth1->execute(array(':user_id'=>$user_id, ':event_id'=>$event_id));
                $data = $sth1->fetchAll();
                if(count($data) == 0)
                {
                       $sql = "INSERT INTO event_invites VALUES ('', :event_id, :user_id, :invite_status, :status)";
                       $sth = $this->db->prepare($sql);
                       if($sth->execute(array(
                          ':status' => "Accept",
                           ':event_id' => $event_id,
                           ':user_id' => $user_id,
                            ':invite_status'=>"Not Invited"
                       )))
                       {
                            echo json_encode(true);
                       }
                       else
                       {
                            echo json_encode($sth->errorInfo());
                       }
                }
                else{
                    $sqlu= "UPDATE event_invites SET status = :status WHERE event_id = :event_id AND user_id = :user_id ";
                       $sthu = $this->db->prepare($sqlu);
                       if($sthu->execute(array(
                          ':status' => "Accept",
                           ':event_id' => $event_id,
                           ':user_id' => $user_id
                       )))
                       {
                            echo json_encode(true);
                       }
                       else
                       {
                            echo json_encode($sthu->errorInfo());
                       }
                }
   }
  private function runPrivateAttending($user_id, $event_id)
   {
       $sqlu= "UPDATE event_invites SET status = :status WHERE event_id = :event_id AND user_id = :user_id ";
                       $sthu = $this->db->prepare($sqlu);
                       if($sthu->execute(array(
                          ':status' => "Accept",
                           ':event_id' => $event_id,
                           ':user_id' => $user_id
                       )))
                       {
                            echo json_encode(true);
                       }
                       else
                       {
                            echo json_encode($sthu->errorInfo());
                       }
   }
   
    function declineEvent($user_id, $event_id)
     {
        
             $sqlu= "UPDATE event_invites SET status = :status WHERE event_id = :event_id AND user_id = :user_id ";
                $sthu = $this->db->prepare($sqlu);
                if($sthu->execute(array(
                   ':status' => "Decline",
                    ':event_id' => $event_id,
                    ':user_id' => $user_id
                )))
                {
                     echo json_encode(true);
                }
                else
                {
                     echo json_encode($sthu->errorInfo());
                }
    }
     
    private function getAttendingText($status)
    {
        $text = '';
        $accepted = 'Accept';
        $decline = 'decline';
        $attend = 'attend';
        $attending = 'attending';
        
        if($status === ''){
            $text = $attend;
        }
        else if($status == $accepted)
        {
           $text =  $attending;
        }
        else if($status == $decline)
        {
            $text = $attend;
        }

        return $text;
    }
     private function getDeclineText($status)
    {
        $text = 'Decline';
        $accepted = 'Accept';
        $decline = 'decline';
        $declined = 'declined';
        if($status == $accepted){
           $text =  $decline;
        }
        else if($status == $decline){
            $text =   $declined ;
        }

        return $text;
    }
    
    public function geteventBAttendText($statusCount)
    {
        $text = '';
        $attend = 'Attend';
        $attending = 'Attending';
        if($statusCount == ZERO){
            $text = $attend;
        }
        else if($statusCount == 1){
            $text = $attending;
        }
        
        return $text;
    }
    
    
    
    
    
    
    public function processEvent($eventName, $eventDesc, $imageName , $imageData, $eventLocation, $eventDate, $eventTime, $eventType,$privacy, $invitedFriends, $friendCount)
    {
        
        $sql = "SELECT * FROM events WHERE event_name = :eventName AND user_id = :user_id AND date = :date AND city =:city";
        $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
               
               
                $sth->execute(array( ':eventName'=>$eventName, ':user_id'=>  $this->id, ':date'=>$eventDate, ':city'=>$this->getUserCity($this->id)));
                $data = $sth->fetchAll();
       
                if(count($data) == 0)
                {
                    $Sql1 = "INSERT INTO events VALUES (:event_id, :user_id, :eventName, :eventDes, :location, :city, :country, :date, :time, :eventImage, :privacy, :eventType)";
                    $sth1 = $this->db->prepare($Sql1);
                    if($sth1->execute(array(
                        ':event_id'=>"",
                         ':user_id'=>  $this->id,
                         ':eventName'=> $eventName,
                         ':eventDes'=>$eventDesc,
                         ':location'=>$eventLocation,
                         ':city'=>  $this->getUserCity($this->id),
                         ':country'=>  $this->getUserCountry($this->id),
                         ':date'=>$eventDate,
                         ':time'=>$eventTime,
                         ':eventImage'=>$imageData,
                         ':privacy'=>$privacy,
                         ':eventType'=>$eventType)))
                     {
                        //insert invited ppl here
                        if(!empty($invitedFriends))
                        {
                            $this->insertInvites($eventName, $eventDate, $this->getUserCity($this->id), $invitedFriends, $friendCount);
                        }
                        else{
                          echo json_encode(true);
                        }
                     }
                     else
                     {
                         echo json_encode($sth->errorInfo());
                     }
                }
                else
                {
                    echo json_encode(false);
                }
                
    }
    
    private function insertInvites($eventName, $eventDate, $city, $InvitedFriends, $friendCount)
    {
        $invited = "Invited";
        $empty = "";
        $result ='';
        $sql = "SELECT event_id FROM events WHERE event_name = :eventName AND user_id = :user_id AND date = :date AND city =:city";
        $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(':user_id'=>  $this->id, ':eventName'=>$eventName, ':date'=>$eventDate, ':city'=>$city));
                $event_id = $sth->fetchAll();
               
                for($looper =0; $looper < $friendCount; $looper++)
                {
              
                    $SQL = "INSERT INTO event_invites VALUES (:event_invites_id, :event_id, :user_id, :invite_status, :status)";
                    $STH = $this->db->prepare($SQL);
                    if($STH->execute(array(':event_invites_id'=>"",
                                            ':event_id'=>$event_id[ZERO]['event_id'],
                                            ':user_id'=>$InvitedFriends[$looper],
                                            ':invite_status'=>$invited,
                                             ':status'=>$empty)))
                    {
                        $result = true;
                        $this->sendInventNotification($InvitedFriends[$looper], $eventName);
                    }
                    else{
                        echo json_encode($STH->errorInfo());
                    }
                            
               }
               
               echo json_encode($result);
                
    }
    public function getFriends()
    {
        $sql = "SELECT UD.FirstName, UD.LastName, UD.picture, UD.user_id FROM user_details AS UD 
                INNER JOIN friends AS FF ON UD.user_id = FF.user_friend_id
                WHERE FF.user_id = :user_id

                UNION

                SELECT UD.FirstName, UD.LastName, UD.picture, UD.user_id FROM user_details AS UD 
                INNER JOIN friends AS FF ON UD.user_id = FF.user_id
                WHERE FF.user_friend_id = :user_id";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id'=>  $this->id));
        $Friends = $sth->fetchAll();
        
        $this->loadFriends($Friends);
        
    }
    
    
    function  loadFriends($friends)
    {
        $output = '';  
        
        for($looper =0; $looper < count($friends); $looper++)
        {
            $output .= '<div class="aFriend">
                        <div class="userChecker"><input type="checkbox" name ="'.$friends[$looper]['user_id'].'"class="inviteCheckBox"></div>
                        <div class="userImage">'.$this->view->checkUserPicture($friends[$looper]['picture'], 50, 50).'
                        </div><div class="userName">'.$this->getUserFLNameOrRestNameOrEstName($friends[$looper]['user_id']).'</div>
                      </div>';
        }
        $output .= '<div id="cancelInvite">Cancel</div> <div id="submitInvites" onclick="invite(\''.count($friends).'\')">Invite</div>';
        echo json_encode($output);
    }
    
    
    private function sendInventNotification($reciever_user_id, $eventName){
        $notify = 'inventNotify';
        $message = $this->getInvitewNotificationMessage($this->id, $eventName);
        $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
    }
    
     private function getInvitewNotificationMessage($user_id, $eventName)
     {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> Invited you to <a href='".URL."events'>".$eventName."</a> invent";
         return $message;
     }
     private function InsertIntoNotificationtable($reciever_user_id, $message, $notify)
     {
          if((int)$this->id !== (int)$reciever_user_id){
                $sql = "INSERT INTO notification VALUES (:notification_id, :from_user_id, :to_user_id, :notification_message, :status, :type, :view_counter, :time)";
                $sth = $this->db->prepare($sql);
                if(!$sth->execute(array(':notification_id'=>EMPTYSTRING,
                                    ':from_user_id'=>  $this->id,
                                    ':to_user_id'=> $reciever_user_id,
                                    ':notification_message'=>$message,
                                    ':status'=>  $this->notification->status,
                                    ':type'=> $notify,
                                    ':view_counter'=>ZERO,
                                    ':time'=> time()))){
                                        echo json_encode($sth->errorInfo());
                                    }
          }
     }
     
    

}


