<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification_model
 *
 * @author Uche
 */
class notifier_model extends Model{
    //put your code here
    function __construct()
     {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->recipes_recook = 'recipes_recook';
        $this->recipe_share = 'recipe_share';
        $this->recipe_tasty = 'recipe_tasty';
        $this->recipes_cookedit = 'ecipes_cookedit';
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
     
     //home recipe post commet notification
     public function recipePostComment($recipe_post_id, $reciever_user_id, $notify)
     {
         $message = $this->getRPCNotificationMessage($recipe_post_id, $this->id);
         $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
         $this->PushNotifictionToUser($recipe_post_id, $this->id, $notify);
     }
     
     //enri recipe post comment notification
     public function recipeENPostComment($recipe_id, $food_id, $country_id, $notify){
         //write the method later
        $this->PushNotifictionToUserForENRecipeComment($recipe_id, $food_id, $country_id, $notify);
     }
     
     private function getRPCNotificationMessage($recipe_post_id, $user_id)
     {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> commented on your recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($recipe_post_id)."'>".$this->getRecipePostTitle($recipe_post_id)."</a>";
         
         return $message;
     }
   
     
     private function PushNotifictionToUser($recipe_post_id, $user_id, $notify)
     {
         $commentUsers = $this->getUserWhoCommentedOnAPost($recipe_post_id, $food_id='', $country_id='');
         for($looper = 0; $looper < count($commentUsers); $looper++)
         {
             if((int)$commentUsers[$looper]['user_id'] !== (int)$this->id){
                $message = $this->getRPCNotificationMessageOtherUsers($recipe_post_id, $user_id);
                $this->InsertIntoNotificationtable($commentUsers[$looper]['user_id'], $message, $notify);
                
                //send emails  about a new 
                $to = $this->getEmail($commentUsers[$looper]['user_id']);
                $name = $this->getUserFLNameOrRestNameOrEstName($this->id);
                $header = EMAILHEADER;
                $subject = $name." commented on the post you commented on";
                $subText = ' commented on the recipe '.$this->getRecipePostTitle($recipe_post_id).' you also commented on';
                $buttonText = 'Login to see the comment';
                $emailMessage = $this->getRecipeCommentEmailBody($name, $subText, $buttonText, $to);
                
                file_put_contents(TEMPPICPATH."".$to.".png", $this->checkPicture($this->getUserImage($this->id)));
                $image_path = TEMPPICPATH."".$to.".png";
                $image_name = $to.".png"; 

                $this->send_relationship_mail($to, $subject, $emailMessage, $header, $name, $image_path, $image_name);
             }
         }
     }
     
     
     
     
     function PushNotifictionToUserForENRecipeComment($recipe_id, $food_id, $country_id, $notify)
     {
         $commentedUsers = $this->getUserWhoCommentedOnAPost($recipe_id, $food_id, $country_id);
         for($looper = 0; $looper < count($commentedUsers); $looper++)
         {
             if((int)$commentedUsers[$looper]['user_id'] !== (int)$this->id){
             $message = $this->getRPCENNotificationMessage($recipe_id, $this->id, $food_id, $country_id);
             $this->InsertIntoNotificationtable($commentedUsers[$looper]['user_id'], $message, $notify);
             }
         }
     }
     
     
       private function getRPCENNotificationMessage($recipe_post_id, $user_id, $food_id, $country_id)
     {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> also commented on the recipe post <a href='".URL."/foodfinder/meal/".$this->getFoodName($food_id)."/".$this->getCountryName($country_id)."'>".$this->getRecipeName($recipe_post_id)."</a>";
         
         return $message;
     }
     
     
     
      private function getRPCNotificationMessageOtherUsers($recipe_post_id, $user_id)
      {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> also commented on recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($recipe_post_id)."'>".$this->getRecipePostTitle($recipe_post_id)."</a>";
         
         return $message;
      }
     
     private function getUserWhoCommentedOnAPost($recipe_post_id, $food_id, $country_id)
     {
         $commentUsers = '';
         if($food_id && $country_id)
         {
             $sql = "SELECT user_id FROM recipes_recook WHERE recipe_id = :recipe_id";
             $sth = $this->db->Sdb->prepare($sql);
             $sth->setFetchMode(PDO::FETCH_ASSOC);
             $sth->execute(array(':recipe_id'=>$recipe_post_id));

            $commentUsers = $sth->fetchAll();
            
         }else if(empty($food_id) && empty($country_id)){
            $sql = "SELECT user_id FROM recipe_post_comments WHERE recipe_post_id = :recipe_post_id";
            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(':recipe_post_id'=>$recipe_post_id));

            $commentUsers = $sth->fetchAll();
         }
         
         return $commentUsers;
     }
     
     private function getRecieverID($reciever_user_id1,$reciever_user_id2)
     {
         if($reciever_user_id2 === $this->id)
         {
             return $reciever_user_id1;
         }
         else if($reciever_user_id1 == $this->id)
         {
             return $reciever_user_id2;
         }
     }
     
     //follow or friend notification
     public function follow($reciever_user_id1, $reciever_user_id2, $notify)
     {
         $reciever_user_id = $this->getRecieverID($reciever_user_id1, $reciever_user_id2);
         $message = $this->getFollowNotificationMessage($this->id);
         $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
         
         
         //send email to user
         $to = $this->getEmail($reciever_user_id);
         $name = $this->getUserFLNameOrRestNameOrEstName($this->id);
         $header = EMAILHEADER;
         $subject = $name. " is following you ";
         $subText = ' is following you';
         $buttonText = 'follow back';
         $emailMessage = $this->getRelationshipEmailBody($name, $subText, $buttonText, $to);
        

         file_put_contents(TEMPPICPATH."".$to.".png", $this->checkPicture($this->getUserImage($this->id)));
         $image_path = TEMPPICPATH."".$to.".png";
         $image_name = $to.".png"; 
         
         $this->send_relationship_mail($to, $subject, $emailMessage, $header, $name, $image_path, $image_name);
     }
     
     private function getFollowNotificationMessage($user_id)
     {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> is Following you";
         return $message;
     }
     
     public function friend($reciever_user_id1, $reciever_user_id2, $notify)
     {
         $reciever_user_id = $this->getRecieverID($reciever_user_id1, $reciever_user_id2);
         $message = $this->getFriendNotificationMessage($this->id);
         $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
          
         $to = $this->getEmail($reciever_user_id);
         $name = $this->getUserFLNameOrRestNameOrEstName($this->id);
         $header = EMAILHEADER;
         $subject = $name. " followed you back";
         $subText = ' is now your friend';
         $buttonText = 'check '.$name.' out';
         $emailMessage = $this->getRelationshipEmailBody($name, $subText, $buttonText, $to);
         
         file_put_contents(TEMPPICPATH."".$to.".png", $this->checkPicture($this->getUserImage($this->id)));
         $image_path = TEMPPICPATH."".$to.".png";
         $image_name = $to.".png"; 
         
         $this->send_relationship_mail($to, $subject, $emailMessage, $header, $name, $image_path, $image_name);
     }
     
     private function getFriendNotificationMessage($user_id)
     {
         $enrptedID = $this->view->encrypt($user_id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> is now your friend";
         return $message;
     }
     
     
     //home recipe cooked, tasty and share notification
     
     public function cookedRecipe($object_id, $reciever_user_id, $notify)
     {
         $reciever_user_id = $reciever_user_id;
          $message = $this->getCookeditTastyShareMessage($notify, $this->id, $object_id);
          $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
     }
     
     public function tastyRecipe($object_id, $reciever_user_id, $notify)
     {
         $reciever_user_id = $reciever_user_id;
          $message = $this->getCookeditTastyShareMessage($notify, $this->id, $object_id);
          $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
     }
     
     public function sharedRecipe($object_id, $reciever_user_id, $notify)
     {
          $reciever_user_id = $reciever_user_id;
          $message = $this->getCookeditTastyShareMessage($notify, $this->id, $object_id);
          $this->InsertIntoNotificationtable($reciever_user_id, $message, $notify);
     }
     
     private function getCookeditTastyShareMessage($which, $user_id, $object_id)
     {
         $cookedRecipe = 'cookedRecipe'; $tastyRecipe = 'tastyRecipe'; $sharedRecipe='sharedRecipe';
         $enrptedID = $this->view->encrypt($user_id);
         $message = '';
         if($which === $cookedRecipe){
             $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFirstName($user_id)." ".$this->getUserLastName($user_id)."</a></span> cooked your recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($object_id)."'>".$this->getRecipePostTitle($object_id)."</a>";
         }
         else if($which === $tastyRecipe){
              $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFirstName($user_id)." ".$this->getUserLastName($user_id)."</a></span> said your recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($object_id)."'>".$this->getRecipePostTitle($object_id)."</a> is tasty";
         }
         else if($which === $sharedRecipe){
              $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a></span> shared your recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($object_id)."'>".$this->getRecipePostTitle($object_id)."</a>";
         }
         
         return $message;
     }
     
     
     // food follow notification starts here
     public function foodFollow($food_id, $country_id, $notify)
     {
         $foodFollowers = $this->getUserFollowingFood($food_id, $country_id);
         $this->sendNotificationToFoodFollers($foodFollowers, $food_id, $country_id, $notify);
     }
     
     private function sendNotificationToFoodFollers($foodFollowers, $food_id, $country_id, $notify)
     {
         for($looper = 0; $looper < count($foodFollowers); $looper++){
             
             $message = $this->foodFollowMessage($this->id, $food_id, $country_id);
             if((int)$foodFollowers[$looper]['user_id'] !== $this->id){
                 $this->InsertIntoNotificationtable($foodFollowers[$looper]['user_id'], $message, $notify);
             }
         }
     }
     
     private function foodFollowMessage($user_id, $food_id, $country_id)
     {
          $enrptedID = $this->view->encrypt($user_id);
          $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> is following the food <a href = '".URL."foodfinder/".MEAL."/".$this->getFoodName($food_id)."/".$this->getCountryName($country_id)."'>".$this->getFoodName($food_id)."</a> that your following.  </span>";
          
          return $message;
     }
     
     private function getUserFollowingFood($food_id, $country_id)
     {
         $sql = "SELECT user_id FROM food_follow WHERE food_id = :food_id AND country_id = :country_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':food_id'=>$food_id, 'country_id'=>$country_id));
         $foodFollowers = $sth->fetchAll();
         
         return $foodFollowers;
     }
     
     //foodfollowall
     public function foodFollowAll($food_id, $notify){
         $allFoodFollowers = $this->getUserFollowingAllFood($food_id);
         $this->sendNotificationToAllFoodFollowers($allFoodFollowers, $food_id, $notify);
     }
     
      private function sendNotificationToAllFoodFollowers($foodFollowers, $food_id, $notify)
      {
         for($looper = 0; $looper < count($foodFollowers); $looper++){
             
             $message = $this->allFoodFollowMessage($this->id, $food_id);
             if((int)$foodFollowers[$looper]['user_id'] !== $this->id){
                 $this->InsertIntoNotificationtable($foodFollowers[$looper]['user_id'], $message, $notify);
             }
         }
      }
     private function allFoodFollowMessage($user_id, $food_id)
     {
          $enrptedID = $this->view->encrypt($user_id);
          $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> is following the food <a href = '".URL."foodfinder/recipes/".$this->getFoodName($food_id)."/'>".$this->getFoodName($food_id)."</a> that your following.  </span>";
          
          return $message;
     }
     
      private function getUserFollowingAllFood($food_id)
     {
         $sql = "SELECT user_id FROM food_follow WHERE food_id = :food_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':food_id'=>$food_id));
         $foodFollowers = $sth->fetchAll();
         
         return $foodFollowers;
     }
     
     
     
     
     public function cookBoxNotify($recipe_post_id, $recipe_owner_id, $notify){
         $message = $this->cookBoxNotifyMessage($recipe_post_id);
         $this->InsertIntoNotificationtable($recipe_owner_id, $message, $notify);
     }
     
     private function cookBoxNotifyMessage($recipe_post_id){
         $enrptedID = $this->view->encrypt($this->id);
           $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> CookBox your recipe ".$this->getRecipePostTitle($recipe_post_id)."</span>";
           return $message;
     }
     
     
     //Foodfinder recipe post and user recipe post notifiction starts here
     
     public function cookedRecipeEN($recipe_id, $notify)
     {
         
         $cookedIt_users = $this->getUserForENNotification($recipe_id, $this->recipes_cookedit);
         $tasty_users = $this->getUserForENNotification($recipe_id,  $this->recipe_tasty);
         $share_user = $this->getUserForENNotification($recipe_id,  $this->recipe_share);
         $recook_users = $this->getUserForENNotification($recipe_id, $this->recipes_recook);
         
         $this->sendNotificationToCTSRUsers($recipe_id, $cookedIt_users, $tasty_users, $share_user, $recook_users, $notify);
  
     }
     
     public function tastyRecipeEN($recipe_id, $notify)
     {
         
         $cookedIt_users = $this->getUserForENNotification($recipe_id, $this->recipes_cookedit);
         $tasty_users = $this->getUserForENNotification($recipe_id,  $this->recipe_tasty);
         $share_user = $this->getUserForENNotification($recipe_id,  $this->recipe_share);
         $recook_users = $this->getUserForENNotification($recipe_id, $this->recipes_recook);
         $this->sendNotificationToCTSRUsers($recipe_id, $cookedIt_users, $tasty_users, $share_user, $recook_users, $notify);
         
     }
     
     public function sharedRecipeEN($recipe_id, $notify)
     {
       
         $cookedIt_users = $this->getUserForENNotification($recipe_id, $this->recipes_cookedit);
         $tasty_users = $this->getUserForENNotification($recipe_id,  $this->recipe_tasty);
         $share_user = $this->getUserForENNotification($recipe_id,  $this->recipe_share);
         $recook_users = $this->getUserForENNotification($recipe_id, $this->recipes_recook);
         $this->sendNotificationToCTSRUsers($recipe_id, $cookedIt_users, $tasty_users, $share_user, $recook_users, $notify);
         $this->sendENShareNotificationToFriendsAndFollowers($recipe_id, $notify);
     }
     
     private function sendENShareNotificationToFriendsAndFollowers($recipe_id, $notify)
     {
         $friendFollowers = $this->getFriendsFollowers($this->id);
         for($looper = 0; $looper < count($friendFollowers); $looper++)
         {
             $user_id = $friendFollowers[$looper]['user_id'];
             $friend_user_id = $friendFollowers[$looper]['user_friend_id'];
             $message  = $this->getENShareToFriendsFollowersMessage($recipe_id);
             $this->InsertIntoNotificationtable($this->checkForFriendUser_id($this->id, $user_id, $friend_user_id), $message, $notify);
         }
     }
     
     private function getENShareToFriendsFollowersMessage($recipe_id)
     {
         $enrptedID = $this->view->encrypt($this->id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> shared the recipe <a href='".URL."/notifier/showNotification/".$this->view->encrypt($recipe_id)."'>".$this->getRecipeName($recipe_id)."</a> with you</span>";
         return $message;
     }
     private function getFriendsFollowers($thisUserId)
     {
         $status_1 = 1;
         $status_2 = 2;
         $sql = "SELECT user_id, user_friend_id FROM  `friends` WHERE "
                 . "(user_id = :user_id AND status = :status_2)"
                 . "|| ( user_friend_id = :user_id AND status = :status_1 ) "
                 . "|| (user_id = :user_id AND status = :status_1)";
         
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':user_id'=>$thisUserId, ':status_1'=>$status_1, ':status_2'=>$status_2));
         $user_ids = $sth->fetchAll();
         
         return $user_ids;
     }
     
     
     
     private function getUserForENNotification($recipe_id, $tableName)
     {
         $sql = "SELECT user_id FROM ".$tableName." WHERE recipe_id = :recipe_id";
         
         $sth = $this->db->Sdb->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':recipe_id'=> $recipe_id));
         
         $user_ids = $sth->fetchAll();
         
         return $user_ids;
     }
     
     private function sendNotificationToCTSRUsers($recipe_id, $cookedIt_users, $tasty_users, $share_user, $recook_users, $which)
     {
         //CTSR cooked, tasty, share recipe
         $cookedRecipeEN = 'cookedRecipeEN'; $tastyRecipeEN = 'tastyRecipeEN'; $sharedRecipeEN = 'sharedRecipeEN';
         $cookit = 'cooked';  $share = 'shared'; $tasty = 'said is tasty'; $recook = 'commented on';
         
         if($which === $cookedRecipeEN){
             $cookedItSent = " cooked the recipe";
             $this->sendNotificationProcessing($recipe_id, $cookedIt_users, $cookedRecipeEN, $cookedItSent, $cookit);
             $this->sendNotificationProcessing($recipe_id, $tasty_users, $cookedRecipeEN, $cookedItSent, $tasty);
             $this->sendNotificationProcessing($recipe_id, $share_user, $cookedRecipeEN, $cookedItSent, $share);
             $this->sendNotificationProcessing($recipe_id, $recook_users, $cookedRecipeEN, $cookedItSent, $recook );
         }
    
         if($which === $tastyRecipeEN){
             $tastySentence = " said tasty to the recipe";
              $this->sendNotificationProcessing($recipe_id, $cookedIt_users, $tastyRecipeEN, $tastySentence, $cookit);
             $this->sendNotificationProcessing($recipe_id, $tasty_users, $tastyRecipeEN, $tastySentence, $tasty);
             $this->sendNotificationProcessing($recipe_id, $share_user, $tastyRecipeEN, $tastySentence, $share);
             $this->sendNotificationProcessing($recipe_id, $recook_users, $tastyRecipeEN, $tastySentence, $recook );
         }
         
         if($which === $sharedRecipeEN){
               $shareSentence = " shared the recipe";
               $this->sendNotificationProcessing($recipe_id, $cookedIt_users, $sharedRecipeEN, $shareSentence, $cookit);
               $this->sendNotificationProcessing($recipe_id, $tasty_users, $sharedRecipeEN, $shareSentence, $tasty);
               $this->sendNotificationProcessing($recipe_id, $share_user, $sharedRecipeEN, $shareSentence, $share);
               $this->sendNotificationProcessing($recipe_id, $recook_users, $sharedRecipeEN, $shareSentence, $recook );
         }
           
     }    
     
      private function sendNotificationProcessing($recipe_id, $users_ids, $notify, $sentence, $which)
      {
            if(!empty($users_ids))
            {
                for($looper = 0; $looper < count($users_ids); $looper++)
                {
                    if((int)$users_ids[$looper]['user_id'] !== (int)$this->id){
                        
                        $message = $this->getENRINotificationMessage($recipe_id, $sentence, $which);
                        $this->InsertIntoNotificationtable($users_ids[$looper]['user_id'], $message, $notify);
                    }
                }
            }
      }
      
      private function getENRINotificationMessage($recipe_id, $sentence, $which)
      {
           $enrptedID = $this->view->encrypt($this->id);
           $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a>".$sentence." <a href='".URL."/notifier/showNotification/".$this->view->encrypt($recipe_id)."'>".$this->getRecipeName($recipe_id)."</a> you $which </span>";
           return $message;
      }
      
      
      
      
      //Eatwith Notification start here
      
      public function eatWithPostCommentTasty($eatWith_id, $which, $notify){
          $commentUsers = $this->getEatWithCommentUsers($eatWith_id);
          $tastyUsers = $this->getEatWithTastyUsers($eatWith_id);
          
          if(count($tastyUsers) === (int)ZERO){
               $this->sendEatWithTastyUserNotification($eatWith_id, $tastyUsers, $which, $notify);
          }
          
          if(count($commentUsers) === (int)ZERO){
             $this->sendEatWithCommentUserNotification($eatWith_id, $commentUsers, $which, $notify);
          }
         
      }
      
      private function sendEatWithCommentUserNotification($eatWith_id, $commentUsers, $which, $notify){
          for($looper = 0; $looper < count($commentUsers); $looper++){
              $message  = $this->getEatWithCommentTastyMessage($eatWith_id, $which);
              $this->InsertIntoNotificationtable($commentUsers[$looper]['user_id'], $message, $notify);
          }
      }
      private function sendEatWithTastyUserNotification($eatWith_id, $tastyUsers, $which, $notify){
          for($looper = 0; $looper < count($tastyUsers); $looper++){
              $message  = $this->getEatWithCommentTastyMessage($eatWith_id, $which);
              $this->InsertIntoNotificationtable($tastyUsers[$looper]['user_id'], $message, $notify);
          }
      }
      
      private function getEatWithCommentTastyMessage($eatWith_id, $which){
         $enrptedID = $this->view->encrypt($this->id);
         $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> $which <a href='".URL."/notifier/showNotification/".$this->view->encrypt($eatWith_id)."'>EatWith Post</a></span>";
         
         return $message;
      }
      private function getEatWithCommentUsers($eatWith_id) {
          $sql = "SELECT user_id FROM eatwith_comments WHERE eatWith_id = :eatWith_id";
          $sth = $this->db->prepare($sql);
          $sth->setFetchMode(PDO::FETCH_ASSOC);
          $sth->execute(array(':eatWith_id'=> $eatWith_id));
         $users = $sth->fetchAll();
         
         return $users;
      }
      
      private function getEatWithTastyUsers($eatWith_id)
      {
           $sql = "SELECT user_id FROM  eatwith_likes WHERE eatWith_id = :eatWith_id";
          $sth = $this->db->prepare($sql);
          $sth->setFetchMode(PDO::FETCH_ASSOC);
          $sth->execute(array(':eatWith_id'=> $eatWith_id));
         $users = $sth->fetchAll();
         
         return $users;
      }
      
      
      
      public function getNotification(){
          $unseen = "UNSEEN";
          $noNotifMEssage = "<div id = 'NoNotificationMessage'>No new notification(s)</div>";
          $sql = "SELECT NT.from_user_id, NT.to_user_id, NT.notification_message, NT.status, NT.type, NT.time, 
                  UD.picture FROM notification AS NT INNER JOIN user_details AS UD ON
                  NT.from_user_id = UD.user_id WHERE NT.to_user_id = :user_id AND status = :status ORDER BY time DESC";
          
          $sth = $this->db->prepare($sql);
          $sth->setFetchMode(PDO::FETCH_ASSOC);
          $sth->execute(array(":user_id" => $this->id, ":status"=>$unseen));
          
          $notifications = $sth->fetchAll();
           if(count($notifications) > ZERO){
                 echo $this->loadNotifications($notifications);
           }else{
               echo $noNotifMEssage;
           }
        
      }
         
     private function loadNotifications($notifications){
         $outptut = '<div id="noitifCount">'.count($notifications).'</div>';
         for($looper = 0; $looper < count($notifications); $looper++){
             $outptut .='<div class="NotifUserPic">'.$this->view->checkUserPicture($notifications[$looper]['picture'], 40, 40).'</div>
                        <div class="notifUserNameInfo">'.$notifications[$looper]['notification_message'].'</div>
                        <div class="notifTime">'.$this->view->timeCounterNotif($notifications[$looper]['time']).'</div>';
         }
         $this->ViewCountNotificationUpdate();
         $this->notificationStatusUpdate();
         
         return $outptut;
     }
     
     private function ViewCountNotificationUpdate(){
          $unseen = "UNSEEN";
         $sql = "UPDATE notification SET view_counter = view_counter+1 WHERE to_user_id = :user_id AND status = :status";
         $sth = $this->db->prepare($sql);
         if(!$sth->execute(array(":user_id"=> $this->id, ":status"=> $unseen))){
           echo $this->errorInfo();
         }
     }
     
     private function notificationStatusUpdate(){
           $unseen = "UNSEEN";
           $seen = "SEEN";
           $five = 5;
           
           $sql = "UPDATE notification SET status = :cur_status WHERE view_counter > :five AND to_user_id = :user_id AND status = :status";
           $sth = $this->db->prepare($sql);
            if(!$sth->execute(array(":user_id"=> $this->id, 
                                   ":status"=> $unseen,
                                   ":cur_status"=> $seen,
                                   ":five" => $five))){ echo $sth->errorInfo();}
     }
     
     
     public function getNotificatioinCount(){
         $sql = "SELECT * FROM notification WHERE to_user_id = :user_id AND view_counter = :zero";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(":user_id"=> $this->id, ":zero" => ZERO));
         
         $res = $sth->fetchAll();
         
         echo json_encode($this->notifCountPrefix(count($res)));
         
     }
     private function notifCountPrefix($num){
             $nine = 9;
             $plus = '+';
         if((int)$num > 9){
             return $nine."".$plus;
         }else{
             return $num;
         }
     }
     
     public function showNotificaton($recipe_post_id, $which){
         $this->view->js = array('home/js/homejs.js', 'home/js/homeUserCommentHandler.js', 
                               'foodfinder/productsDialog/js/productjsFunctions.js',
                               'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                'profile/js/friendsFollowers.js'
                                );
      
        $this->view->css = array( 'css/home/homesheet.css', 'css/home/imageDialog.css',
                                  'css/home/enri_post.css',
                                  'css/foodfinder/food/errorDialgBoxSheet.css',
                                  'css/foodfinder/productsDialog/productsheet.css',
                                  'css/profile/followfriendssheet.css');
        $recipe_Post = "RP";
        
        if($recipe_Post === $which){
            
                    $userDetails = $this->getUserDetails($this->id);

                    $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, U.picture,
                                    F.food_name, F.food_picture, C.country_names, C.flag_picture
                                    FROM recipe_post AS RP
                                    INNER JOIN user_details AS U ON RP.user_id = U.user_id
                                    INNER JOIN food AS F ON RP.food_id = F.food_id
                                    INNER JOIN country AS C ON RP.country_id = C.country_id
                                    WHERE recipe_post_id = :recipe_post_id";

                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(":recipe_post_id" => $recipe_post_id));

                    $data = $sth->fetchAll();
                    $userComments = $this-> getUserComment($data[ZERO]['recipe_post_id']);
                    $food_id = $data[ZERO]['food_id'];
                    $country_id = $data[ZERO]['country_id'];
                    $foodCountry = $this->getCountryFoodName($food_id, $country_id);

                    $tastyCount = $this->getTasty($data[ZERO]['recipe_post_id']);
                    $shareCount = $this->getTasty($data[ZERO]['recipe_post_id']);
                    $cookItCount = $this->getCookedit($data[ZERO]['recipe_post_id']);

                    $cb = $this->getCookBoxInfo($data[ZERO]['recipe_post_id'], $data[ZERO]['user_id']);
                    $data[0]['cookbook'] = $cb;
                    $data[0]['UserName'] = $this->getUserFLNameOrRestNameOrEstName($data[ZERO]['user_id']);
                    $userDetails[0]['UserName'] = $this->getUserFLNameOrRestNameOrEstName($this->id);
                    $fileName = "showNotification/RP/index";
                    
                   // var_dump($userComments);
                    $this->view->renderHomePage($fileName, $data, $userComments, $foodCountry, $tastyCount, $shareCount, $cookItCount, $userDetails);
        }else{
                $userDetails = $this->getUserDetails($this->id);

                    $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, U.picture,
                                    F.food_name, F.food_picture, C.country_names, C.flag_picture
                                    FROM recipe_post AS RP
                                    INNER JOIN user_details AS U ON RP.user_id = U.user_id
                                    INNER JOIN food AS F ON RP.food_id = F.food_id
                                    INNER JOIN country AS C ON RP.country_id = C.country_id
                                    WHERE recipe_post_id = :recipe_post_id";

                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(":recipe_post_id" => $recipe_post_id));

                    $data = $sth->fetchAll();
                    
                    if(count($data) === 0){
                        $this->view->renderHomePage($fileName, $data, $userComments='', $foodCountry='', $tastyCount='', $shareCount='', $cookItCount='', $userDetails='');
                    }else{
                        
                            $userDetails = $this->getUserDetails($this->id);

                            $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, U.picture,
                                    F.food_name, F.food_picture, C.country_names, C.flag_picture
                                    FROM recipe_post AS RP
                                    INNER JOIN user_details AS U ON RP.user_id = U.user_id
                                    INNER JOIN food AS F ON RP.food_id = F.food_id
                                    INNER JOIN country AS C ON RP.country_id = C.country_id
                                    WHERE recipe_post_id = :recipe_post_id";

                            $sth = $this->db->prepare($sql);
                            $sth->setFetchMode(PDO::FETCH_ASSOC);
                            $sth->execute(array(":recipe_post_id" => $recipe_post_id));

                            $data = $sth->fetchAll();
                            $userComments = $this-> getUserComment($data[ZERO]['recipe_post_id']);
                            $food_id = $data[ZERO]['food_id'];
                            $country_id = $data[ZERO]['country_id'];
                            $foodCountry = $this->getCountryFoodName($food_id, $country_id);

                            $tastyCount = $this->getTasty($data[ZERO]['recipe_post_id']);
                            $shareCount = $this->getTasty($data[ZERO]['recipe_post_id']);
                            $cookItCount = $this->getCookedit($data[ZERO]['recipe_post_id']);

                            $cb = $this->getCookBoxInfo($data[ZERO]['recipe_post_id'], $data[ZERO]['user_id']);
                            $data[0]['cookbook'] = $cb;
                            $data[0]['UserName'] = $this->getUserFLNameOrRestNameOrEstName($data[ZERO]['user_id']);
                            $userDetails[0]['UserName'] = $this->getUserFLNameOrRestNameOrEstName($this->id);
                            $fileName = "showNotification/RP/index";
                            //($userComments);
                            $this->view->renderHomePage($fileName, $data, $userComments, $foodCountry, $tastyCount, $shareCount, $cookItCount, $userDetails);
                    }
        }
     }
     
        private function getCookBoxInfo($recipe_post_id, $user_id){
            $sql = "SELECT * FROM user_cook_box WHERE recipe_post_id = :recipe_post_id AND user_id = :user_id";
            $sth = $this->db->prepare($sql);
            $sth->execute(array(':recipe_post_id' => $recipe_post_id, ':user_id'=> $user_id));
            $CB = $sth->fetchAll();
            
            if(count($CB) === 0){
                return false;
            }else{
                return true;
            }
        }
        private function getshare($recipe_post_id)
        {
          $sql = "SELECT *  FROM recipe_post_share WHERE recipe_post_id= :recipe_post_id";

          $sth = $this->db->prepare($sql);
          $sth->setFetchMode(PDO::FETCH_ASSOC);
          $sth->execute(array(
              ":recipe_post_id" => $recipe_post_id
          ));

          $shareCount = $sth->fetchAll();
          if(empty($shareCount ))
          {
               return "0";
          }else{
           return  count($shareCount);
          }
        }
       private function getTasty($recipe_post_id)
       {
            $sql = "SELECT * FROM recipe_post_tasty WHERE recipe_post_id= :recipe_post_id ";

            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(
                ":recipe_post_id" => $recipe_post_id
            ));

            $tastyCount = $sth->fetchAll();
            if(empty($tastyCount))
            {
               return "0";
            }
            else{
                return count($tastyCount);
            }
      }
      
      private function getCookedit($recipe_post_id)
      {
            $sql = "SELECT * FROM recipe_post_cookedit WHERE recipe_post_id= :recipe_post_id";

            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(
                ":recipe_post_id" => $recipe_post_id
            ));

            $cookItCount = $sth->fetchAll();
            if(empty($cookItCount))
            {
               return  "0";
            }
            else{
                return count($cookItCount);
            }
      }
    
     
         function getUserComment($recipe_post_id)
         {
            $details = array();
           $sql = "SELECT recipe_post_comments_id, comments, user_id, time FROM recipe_post_comments WHERE recipe_post_id = :recipe_post_id ORDER by time ASC";
           $sth = $this->db->prepare($sql);
           $sth->setFetchMode(PDO::FETCH_ASSOC);
           $sth->execute(array(
               ':recipe_post_id' => $recipe_post_id 
           ));

           $data = $sth->fetchAll(PDO::FETCH_ASSOC);
           $detail = $this->getDetails($data, $details);

                  return $detail;
                
        }
    
     private function getDetails($data, $details)
     {
       for($i =0; $i < count($data); $i++)
       {
           $details[$i]['user_id'] = $data[$i]['user_id'];
           $details[$i]['userName'] = $this->getUserFLNameOrRestNameOrEstName($data[$i]['user_id']);
           $details[$i]['image'] = $this->getUserImage($data[$i]['user_id']);
           $details[$i]['time'] = $data[$i]['time'];
           $details[$i]['comments'] = $data[$i]['comments'];
           $details[$i]['recipe_post_comments_id'] = $data[$i]['recipe_post_comments_id'];
          
       }
       
       return $details;
    }
    
    function getCountryFoodName($foodId, $countryId)
    {
        $sql = "SELECT food_name, food_picture, country_names, flag_picture FROM food, country WHERE country.country_id= :country_id AND food.food_id = :food_id";
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMOde(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":country_id" => $countryId,
            ":food_id" => $foodId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
    
    public function asktojoinNotify($cookwith_id, $notify){
        $sql = "SELECT user_id FROM cookwith_invitations WHERE cookwith_id = :cookwith_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':cookwith_id'=> $cookwith_id));
        $users = $sth->fetchAll();
        
        if(count($users) !== ZERO){
            $this->sendAskjoinRequestNotification($users, $cookwith_id, $notify);
        }
    }
    
    private function sendAskjoinRequestNotification($users, $cookwith_id, $notify){
        $cookwith_title_and_host = $this->cookwith_title($cookwith_id);
        $show_title = $cookwith_title_and_host[ZERO]['recipe_title'];
        $host_user_id = $cookwith_title_and_host[ZERO]['user_id'];
        
        $sub_otherUser_message = 'has ask for invitation to join the show to make ';
        $sub_host_message = 'has ask for invitation to join your show to make ';
        
        for($looper = 0; $looper < count($users); $looper++){
            $message = $this->getAskjoinRequestNotificationMessage($this->id, $show_title,  $sub_otherUser_message);
            $this->InsertIntoNotificationtable($users[$looper]['user_id'], $message, $notify);
        }
        
         $message = $this->getAskjoinRequestNotificationMessage($this->id, $show_title,  $sub_host_message);
         $this->InsertIntoNotificationtable($host_user_id, $message, $notify);
    }
    
    private function getAskjoinRequestNotificationMessage($user_id, $show_title, $sub_message){
        $enrptedID = $this->view->encrypt($user_id);
          $message = "<span><a href='".URL."profile/user/".$enrptedID."'>".$this->getUserFLNameOrRestNameOrEstName($this->id)."</a> ".$sub_message." <a href='".URL."cookwith'>".$show_title."</a></span>";
          
          return $message;
    }
    
    private function cookwith_title($cookwith_id){
        $sql = "SELECT recipe_title, user_id FROM cookwith WHERE cookwith_id = :cookwith_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':cookwith_id'=> $cookwith_id));
        $cookwith_title_user_id = $sth->fetchAll();
        
        return $cookwith_title_user_id;
    }
    
      private function checkPicture($image){
        $defaultPic_path = PICTURE."default_pic.png";
        if(!$image || empty($image)){
            $def_pic = file_get_contents($defaultPic_path);
                return $def_pic;
        }else{
                return $image;
             }
      
     }
}

