<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Sugestusers_model
 *
 * @author Uche
 */
class Suggestusers_model extends Model{
    //put your code here
     function __construct()
     {
         parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
         $this->FirstName = $this->getUserFirstName($this->id);
     }
     
     public function index(){
         $friends = $this->getAllFriends();
          $sugFriends = $this->getFriend_friends($friends);
       
         echo json_encode($this->loadSuggesteFriends($sugFriends));
     }

     private function getAllFriends(){
         $sql = "SELECT user_friend_id FROM friends WHERE user_id = :user_id
                 UNION 
                 SELECT user_id FROM friends WHERE user_friend_id = :user_friend_id 
                 ORDER BY RAND()";
         
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':user_id' => $this->id, ":user_friend_id"=>  $this->id));
         $friends = $sth->fetchAll();
         
         return $friends;
     }
     private function getFriend_friends($friends){
         $sugFriends = array();
         $impFriends = $this->implodFriends($friends);
         $counter = 0; if(count($friends) > 6){$counter = 6;}else{$counter = count($friends);}
         for($looper =0; $looper < $counter; $looper++){
             $userFriend = $this->queryToGetFriend($friends[$looper]['user_friend_id'], $impFriends);
             if(count($userFriend) !== ZERO && !in_array($userFriend, $sugFriends)){
                  $sugFriends[$looper] =  $userFriend ;
             }
             
         }
         
         return $sugFriends;
     }
     
     private function queryToGetFriend($user_id, $friends){
         $sql ="SELECT F.user_friend_id, U.picture FROM friends AS F 
                INNER JOIN user_details AS U ON F.user_friend_id = U.user_id
                WHERE F.user_id = $user_id AND F.user_friend_id != $this->id AND (F.user_friend_id NOT IN ($friends))

                UNION 

                SELECT F.user_id, U.picture FROM friends AS F 
                INNER JOIN user_details AS U ON F.user_id = U.user_id
                WHERE F.user_friend_id = $user_id AND F.user_id != $this->id AND (F.user_id NOT IN ($friends)) 

                ORDER BY RAND() LIMIT 1";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
         $friends = $sth->fetchAll();
         
         return $friends;
     }
     
     private function implodFriends($friends){
         $nwFriends = array();
         for($looper= 0; $looper < count($friends); $looper++){
             $nwFriends[$looper] = $friends[$looper]['user_friend_id'];
         }
         return $implode_string = "'".implode( "', '", $nwFriends )."'";
     }
     
     private function loadSuggesteFriends($friends){
         $output = '<div id="peopleYouMayKnowHeader">You may know</div>';
         
         if(count($friends) === ZERO){
             $output .= "<span style='font-size:15px; color:rgba(0, 0, 0, 0.2); margin-left: 10px'><b>No suggested Friends Found</b></span>";
         }else{
              foreach ($friends as $value) {
                $userName = $this->getUserFLNameOrRestNameOrEstName($value[0]['user_friend_id']);
                $output .=  "<a href ='".URL."profile/user/".$this->encrypt((int)$value[0]['user_friend_id'])."'>".$this->view->checkSuggestedUserPicture($value[0]['picture'], $userName,  100, 100)."</a>";
              }
         }
        
         
         return $output;
     }
     
     public function getUserNameAndPicture(){
         $details = $this->getUserDetails($this->id);
         $name = $this->getUserFLNameOrRestNameOrEstName($this->id);
         return array($name, $details[0]['picture'], $this->getEmail($this->id));
     }
}
