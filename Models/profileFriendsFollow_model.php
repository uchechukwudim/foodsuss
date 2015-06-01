<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profileFriendsFollow_model
 *
 * @author Uche
 */
class profileFriendsFollow_model extends Model{
    //put your code here
     function __construct() {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->email = $_SESSION['user'];
    }
    
    public function FriendsFollow($userId='')
    {
    
        if($userId){
            //getting friends and followers here
         $sql1 = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type,F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                  WHERE F.user_id = :user_id AND F.status != :zero
                  UNION 
                  SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type, F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                  WHERE F.user_friend_id = :user_id AND F.status != :zero
                  LIMIT 0 , 6";
         $sth1 = $this->db->prepare($sql1);
         $sth1->setFetchMode(PDO::FETCH_ASSOC);
         $sth1->execute(array(
             ':user_id' => $userId,
                 ':zero' => ZERO
         ));
         //have to take the retrived status and compare it with the person "view" to see friends status
             
         $friendsFollowers = $sth1->fetchAll();
         $recipePostCount = $this->recipePostCount($friendsFollowers, $userId);
         $friendsCount = $this->friendsCount($friendsFollowers, $userId);
         $followerCount = $this->followerCount($friendsFollowers, $userId);
         
         $this->loadFriendsFollows($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $userId);
        }else{
        //getting friends and followers here
         $sql1 = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type,F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                  WHERE F.user_id = :user_id AND F.status != :zero
                  UNION 
                  SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type, F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                  WHERE F.user_friend_id = :user_id AND F.status != :zero
                  LIMIT 0 , 6";
         $sth1 = $this->db->prepare($sql1);
         $sth1->setFetchMode(PDO::FETCH_ASSOC);
         $sth1->execute(array(
             ':user_id' => $this->id,
                 ':zero' => ZERO
         ));
         
             
         $friendsFollowers = $sth1->fetchAll();
         $recipePostCount = $this->recipePostCount($friendsFollowers);
         $friendsCount = $this->friendsCount($friendsFollowers);
         $followerCount = $this->followerCount($friendsFollowers);
         
         $this->loadFriendsFollows($friendsFollowers, $recipePostCount, $friendsCount, $followerCount);
        }
    }
    private function getThisUser_id($user_id, $friend_user_id)
    {
        $ids = array();
        if($user_id === $this->id)
        {
            $ids['user_id'] = $this->id;
            $ids['friend_user_id'] = $friend_user_id;
        }
        else if($friend_user_id === $this->id)
        {
            $ids['user_id'] = $friend_user_id;
             $ids['friend_user_id'] = $user_id;
        }
         return $ids;
    }


    public function FriendFollowRequestProcessing($request, $user_id, $friend_user_id)
    {
        $follow = 'Follow';
        $statusNumber = $this->getStatusNumber($request, $user_id);
        $ids = $this->getThisUser_id($user_id, $friend_user_id);
        if($request === $follow){
          
            $this->switchUserIdInFriendsTableAndUpdateOrInsertUsersStatus($statusNumber, $ids['user_id'], $ids['friend_user_id']);
               
        }else{
                 
                  $this->updateUsersStatus($statusNumber, $ids['user_id'], $ids['friend_user_id']);
        }
    }
    
    private function updateUsersStatus($statusNumber, $user_id, $friend_user_id)
    {
        
                   $sql=  "UPDATE  friends SET  status =  :status WHERE  (user_id = :user_id AND user_friend_id = :user_friend_id) || (user_id = :user_friend_id AND user_friend_id  = :user_id) ";

                    $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':user_id'=> $user_id, ':user_friend_id'=> $friend_user_id, ':status'=>$statusNumber))){

                        echo json_encode($this->getStatusFromDB($friend_user_id));

                    }
                    else
                    {
                        echo json_encode($sth->errorInfo());
                    }
    }
    private function updateStatusAndSwithUsersId($statusNumber, $user_id, $friend_user_id)
    {
        
                   $sql=  "UPDATE  friends SET user_id = :user_friend_id, user_friend_id = :user_id, status =  :status WHERE  user_id = :user_id AND user_friend_id = :user_friend_id ";

                    $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':user_id'=> $user_id, ':user_friend_id'=> $friend_user_id, ':status'=>$statusNumber))){

                        echo json_encode($this->getStatusFromDB($friend_user_id));

                    }
                    else
                    {
                        echo json_encode($sth->errorInfo());
                    }
    }
    
    private function insertUserFriends($statusNumber, $user_id, $friend_user_id)
    {
        $sql = "INSERT INTO friends VALUES (:friends_id, :time, :user_id, :user_friend_id, :status)";
         $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':friends_id'=>EMPTYSTRING,
                                            ':time'=>  time(),
                                            ':user_id'=> $friend_user_id, 
                                            ':user_friend_id'=> $user_id, 
                                            ':status'=>$statusNumber))){

                        echo json_encode($this->getStatusFromDB($friend_user_id));

                    }
                    else
                    {
                        echo json_encode($sth->errorInfo());
                    }
    }
    
    private function switchUserIdInFriendsTableAndUpdateOrInsertUsersStatus($statusNumber, $user_id, $friend_user_id)
    {
         $Sql = "SELECT user_id, user_friend_id, status FROM friends WHERE (user_id = :user_id AND user_friend_id = :user_friend_id AND status =:zero) || (user_id = :user_friend_id AND user_friend_id  = :user_id AND status = :zero)";
            $Sth = $this->db->prepare($Sql);
            $Sth->setFetchMode(PDO::FETCH_ASSOC);
            $Sth->execute(array(':user_id'=>$user_id, ':user_friend_id'=>$friend_user_id, ':zero'=>ZERO));
            $result = $Sth->fetchAll();
            
            if(count($result)!== ZERO){
                if($result[ZERO]['user_id'] === $user_id){
                      //switch users here
                     
                      $this->updateStatusAndSwithUsersId($statusNumber, $user_id,  $friend_user_id);
                }else{
                    //just update same way
                   // echo json_encode('there');
                      $this->updateUsersStatus($statusNumber, $user_id, $friend_user_id);
                }
            }
            else{
                //insert here
                $this->insertUserFriends($statusNumber, $user_id, $friend_user_id);
            }
    }

    private function getStatusNumber($status, $user_id)
    {
        $statusInfo = '';
        if($status =="Following"  ){ $statusInfo = 0;}
        else if($status == "Follower" ){ $statusInfo = 2;}
        else if($status == "Friends" && $user_id == $this->id ){$statusInfo = 1;}
        else if($status == "Friends" && $user_id != $this->id ){$statusInfo = 0;}
        else if($status == "Follow" ){$statusInfo = 1;}
        
        return $statusInfo;
    }





    private function loadFriendsFollows($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $userId='')
    {
        $output = '<div id="FriendFollowerHolder">
                        '.$this->loadFFholder($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $userId).'
                    <p>.</p>
                </div>';
        
        echo json_encode($output);
    }
    
    
    private function loadFFholder($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $userId='')
    {
       $output='    <script type="text/javascript">
                         $(".friendStatus").each(function(index){
        
        $(this).hover(function(){
            var status = $(this).text();
            if(status === "Friends")
            {
                $(this).text("UnFriend");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Following")
            {
                $(this).text("Unfollow");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Follower")
            {
                $(this).text("Follow Back");
                $(this).css({ "text-align":"center", "width":"auto"});
                $(".recipeCount span").eq(index).css({"margin-left":"15px"});
            }
        },function(){
            
            var status = $(this).text();
            if(status === "UnFriend")
            {
                $(this).text("Friends");
               $(this).css({ "text-align":"center"});
            }
            
            if(status === "Unfollow")
            {
                $(this).text("Following");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Follow Back")
            {
                $(this).text("Follower");
                $(this).css({ "text-align":"center", "width":"45px" ,"padding-left": "5px","padding-right":"5px",
                            "margin-right": "10px"});
                
            }
            
        });
    });           
                    </script>';
       $U_id = '';
       $U_F_id = '';
       $STATUS = '';
       $user_name ='';
         for($looper = 0; $looper < count($friendsFollowers); $looper++)
         { 
             if($userId){
                 
                        if($friendsFollowers[$looper]['user_id'] == $userId && $friendsFollowers[$looper]['user_friend_id']!= $userId)
                        {
                            $U_id = $this->id;
                            $U_F_id = $friendsFollowers[$looper]['user_friend_id'];
                            $STATUS = $this->getStatusFromDB($U_F_id);
                            $user_name = $this->getUserFLNameOrRestNameOrEstName($U_F_id);
                        }
                        else if($friendsFollowers[$looper]['user_id'] != $userId && $friendsFollowers[$looper]['user_friend_id']== $userId)
                        {
                            $U_id = $friendsFollowers[$looper]['user_id'];
                            $U_F_id = $this->id;
                            $STATUS = $this->getStatusFromDB($U_id);
                             $user_name = $this->getUserFLNameOrRestNameOrEstName( $U_id);
                        }
                 $output .= '  
                     
                   <div class="FFHolderMain" style=" background-image: url('.$this->view->checkFFbckPic($friendsFollowers[$looper]['cover_picture']).');" >
                      <div class="PNTS"></div> 
                        <div class="friendPicMain" >'.$this->view->checkUserPicture($friendsFollowers[$looper]['picture'], 50, 50).'</div>
                        <div class="FriendNameMain"><b><a href="'.URL.'profile/user/'.$this->view->encrypt($this->view->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId )).'">'.$user_name.'</a> </b></div>
                        <div class="friendUsertTypeMain">'. $friendsFollowers[$looper]['user_type'] .'<span><img class="FriendverifyImg" src="'.URL.'pictures/verify.png" width="12" height="12" alt=""></span> </div>
                        <div class="friendStatus" onclick="sendFriendShipToServer(\''.$STATUS.'\', \''.$U_id.'\', \''.$U_F_id.'\', \''.$looper.'\')">'.$STATUS.'</div>
                        
                        <ul class="FFstatusBar">
                           <li class="recipeCount"><img src="'.URL.'pictures/profile/ENRI_recipe.png" width="20" height="20" title=" Recipes Posted "><span>'.$recipePostCount[$looper].'</span></li>
                           <li class="friendCount"><img src="'.URL.'pictures/profile/ENRI_friends_icon.png" width="20" height="20" title="Friends "> <span>'.$friendsCount[$looper].'</span></li>
                           <li class="followerCount"><img src="'.URL.'pictures/profile/ENRI_follower_icon.png" width="20" height="20" title="Followers"><span>'.$followerCount[$looper].'</span></li>
                        </ul>
                 </div>';
             }
             else{
                 if($friendsFollowers[$looper]['user_id'] == $this->id && $friendsFollowers[$looper]['user_friend_id']!= $this->id)
                        {
                            $U_id = $this->id;
                            $U_F_id = $friendsFollowers[$looper]['user_friend_id'];
                            $STATUS = $this->getStatusFromDB($U_F_id);
                            $user_name = $this->getUserFLNameOrRestNameOrEstName($U_F_id);
                        }
                        else if($friendsFollowers[$looper]['user_id'] != $this->id && $friendsFollowers[$looper]['user_friend_id']== $this->id)
                        {
                            $U_id = $friendsFollowers[$looper]['user_id'];
                            $U_F_id = $this->id;
                            $STATUS = $this->getStatusFromDB($U_id);
                            $user_name = $this->getUserFLNameOrRestNameOrEstName( $U_id);
                        }
                    $output .= ' <div class="FFHolderMain" style=" background-image: url('.$this->view->checkFFbckPic($friendsFollowers[$looper]['cover_picture']).');">
                                      <div class="PNTS"></div> 
                                        <div class="friendPicMain"  >'.$this->view->checkUserPicture($friendsFollowers[$looper]['picture'], 50, 50).'</div>
                                        <div class="FriendNameMain"><b><a href="'.URL.'profile/user/'.$this->view->encrypt($this->view->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $this->id )).'">'.$user_name.'</a> </b></div>
                                        <div class="friendUsertTypeMain">'. $friendsFollowers[$looper]['user_type'] .'<span><img class="FriendverifyImg" src="'.URL.'pictures/verify.png" width="12" height="12" alt=""></span> </div>
                                        <div class="friendStatus" onclick="sendFriendShipToServer(\''.$this->getStatus($friendsFollowers[$looper]['status'], $friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId).'\', \''.$friendsFollowers[$looper]['user_id'].'\', \''.$friendsFollowers[$looper]['user_friend_id'].'\', \''.$looper.'\')">'.$this->getStatus($friendsFollowers[$looper]['status'], $friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId).'</div>
                                      
                                        <ul class="FFstatusBar">
                                          <li class="recipeCount"><img src="'.URL.'pictures/profile/ENRI_recipe.png" width="20" title="Recipes Posted " height="20"><span>'.$recipePostCount[$looper].'</span></li>
                                          <li class="friendCount"><img src="'.URL.'pictures/profile/ENRI_friends_icon.png" width="20" title="Friends " height="20"><span>'.$friendsCount[$looper].'</span></li>
                                          <li class="followerCount"><img src="'.URL.'pictures/profile/ENRI_follower_icon.png" width="20" title="Followers" height="20"><span>'.$followerCount[$looper].'</span></li>
                                        </ul>
                                  </div>';
             }
         } 
            return $output;
    }
    
    private function getFriendFollowNames($user_type, $friendsFollowers, $userId)
    {
        $restaurant = 'Restaurant';
        $user_id = $friendsFollowers['user_id'];
          $friend_user_id = $friendsFollowers['user_friend_id'];
        $name = '';
        if($user_type === $restaurant && $userId)
        {
            $name = $this->getRestuarantName($this->checkForFriendUser_id( $userId, $user_id, $friend_user_id));
        }
        else
        {
            $name =  $friendsFollowers['FirstName']." ". $friendsFollowers['LastName'];
        }
        return $name;
    }
    private function getStatusFromDB($friend_user_id)
    {
        $status = '';
        $sql = "SELECT user_id, user_friend_id, status FROM friends WHERE (user_id = :user_id AND user_friend_id = :user_friend_id) || (user_id = :user_friend_id AND user_friend_id = :user_id)";
    
        $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(
             ':user_id' => $this->id,
             ':user_friend_id' => $friend_user_id
         ));
         $result = $sth->fetchAll();
         if(count($result) === ZERO && $friend_user_id === $this->id)
         {
             $status = '';
         }
         else if(count($result) === ZERO && $friend_user_id !== $this->id)
         {
               $status = 'Follow';
         }
         else
         {
            $status = $this->getStatus($result[ZERO]['status'], $result[ZERO]['user_id'], $result[ZERO]['user_friend_id']);
         }
         return $status;
    }
    
    private function getStatus($status, $user_id, $friend_user_id, $userId='')
    {
        if($userId)
        {
            (int)$userId;
             $statusInfo = '';
            if($status == 1 && $user_id != $userId && $friend_user_id == $userId){ $statusInfo = 'Following';}
            else if($status == 1 && $user_id == $userId && $friend_user_id != $userId){ $statusInfo = 'Follower';}
            else if($status == 2){$statusInfo = 'Friends';}
            else if($status == 0){$statusInfo = 'Follow';}
         
            return $statusInfo;
        }else{
            $statusInfo = '';
            if($status == 1 && $user_id != $this->id && $friend_user_id ==  $this->id){ $statusInfo = 'Following';}
            else if($status == 1 && $user_id == $this->id && $friend_user_id != $this->id){ $statusInfo = 'Follower';}
            else if($status == 2){$statusInfo = 'Friends';}
            else if($status == 0){$statusInfo = 'Follow';}

            return $statusInfo;
        }
    }

    private function recipePostCount($friendsFollowers, $userId='')
    {
        $UserRecipePostCount = array();
        $user_id='';
        for($i =0; $i < count($friendsFollowers); $i++)
        {
           if($userId)
           {
               if($friendsFollowers[$i]['user_id'] ==  $userId && $friendsFollowers[$i]['user_friend_id'] != $userId)
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] != $userId && $friendsFollowers[$i]['user_friend_id'] ==$userId )
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }
                 $UserRecipePostCount[$i] = $this->getUserRecipeCount($user_id);
           }
           else
           {
                if($friendsFollowers[$i]['user_id'] ==  $this->id && $friendsFollowers[$i]['user_friend_id'] !=$this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                      
                }
                else if($friendsFollowers[$i]['user_id'] != $this->id&& $friendsFollowers[$i]['user_friend_id'] ==$this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                    
                }
                 $UserRecipePostCount[$i] = $this->getUserRecipeCount($user_id);
           }
        }
        return $UserRecipePostCount;
    }   

    private function getUserRecipeCount($userId)
    {
        $sql = "SELECT * FROM recipe_post WHERE user_id = :user_id";
        
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id" => $userId
        ));
        
        $recipeCount = $sth->fetchAll();
        
        return count($recipeCount);
    }
    
    private function friendsCount($friendsFollowers, $userId='')
    {
        $friendsCount = array();
        
        for($i=0; $i < count($friendsFollowers); $i++)
        {
            if($userId){
                if($friendsFollowers[$i]['user_id'] ===  $userId  && $friendsFollowers[$i]['user_friend_id'] !== $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] !== $userId  && $friendsFollowers[$i]['user_friend_id'] === $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }
                $friendsCount[$i] = $this->getFriendCount($user_id);
            }
            else
            {
                if($friendsFollowers[$i]['user_id'] === $this->id && $friendsFollowers[$i]['user_friend_id'] !== $this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] !== $this->id && $friendsFollowers[$i]['user_friend_id'] === $this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }
                $friendsCount[$i] = $this->getFriendCount($user_id);
            }
        }
        
        return $friendsCount;
    }
    
    
    function getfriendUserId($user_id, $friend_user_id)
    {
        if($user_id === $this->id && $friend_user_id !== $this->id)
        {
            return $friend_user_id;
        }
        else if($user_id !== $this->id && $friend_user_id === $this->id)
        {
            return $user_id;
        }
    }
    
    private function getFriendCount($userId)
    {
        $status = 2;
        $sql = "SELECT * FROM  `friends` WHERE STATUS = :status AND (user_id =:user_id OR user_friend_id = :user_id)";
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id"=>$userId,
            ":status" => $status
        ));
        
        $count = $sth->fetchAll();
        
        return count($count);
    }
    private function followerCount($friendsFollowers, $userId='')
    {
        $friendsCount = array();
        
        for($i=0; $i < count($friendsFollowers); $i++)
        {
           if($userId){
               if($friendsFollowers[$i]['user_id'] == $userId  && $friendsFollowers[$i]['user_friend_id'] !== $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] !== $userId && $friendsFollowers[$i]['user_friend_id'] == $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }   
                $friendsCount[$i] = $this->getFollowerCount($user_id);
           }
           else
           {
                if($friendsFollowers[$i]['user_id'] ==  $this->id && $friendsFollowers[$i]['user_friend_id'] !== $this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] !==  $this->id && $friendsFollowers[$i]['user_friend_id'] == $this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }   
                $friendsCount[$i] = $this->getFollowerCount($user_id);
           }
        }
        
        return $friendsCount;
    }
    
    private function getFollowerCount($userId)
    {
        $status = 1;
        $sql = "SELECT * FROM  `friends` WHERE STATUS = :status AND (user_id =:user_id)";
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id"=>$userId,
            ":status" => $status
        ));
        
        $count = $sth->fetchAll();
        
        return count($count);
    }
    
    function infinitScrollFriendsFollow($pages, $userId)
    {
        $ID = '';
        $iD = '';
        if($userId)
        {
            $ID = $userId;
            $iD = $userId;
        }
        else
        {
            $ID = $this->id;
        }
         //getting friends and followers here
         $sql1 = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type,F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                  WHERE F.user_id = :user_id AND F.status != :zero
                  UNION 
                  SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type, F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                  WHERE F.user_friend_id = :user_id AND F.status != :zero
                  LIMIT $pages , 6";
         $sth1 = $this->db->prepare($sql1);
         $sth1->setFetchMode(PDO::FETCH_ASSOC);
         $sth1->execute(array(
             ':user_id' => $ID,
                 ':zero' => ZERO
         ));
         
             
         $friendsFollowers = $sth1->fetchAll();
         $recipePostCount = $this->recipePostCount($friendsFollowers, $iD);
         $friendsCount = $this->friendsCount($friendsFollowers, $iD);
         $followerCount = $this->followerCount($friendsFollowers, $iD);
         
         $this->infinitLoadFFholder($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $pages, $userId);
    }
    
    private function infinitLoadFFholder($friendsFollowers, $recipePostCount, $friendsCount, $followerCount, $pages, $userId )
    {
       $output='<script type="text/javascript">
                 changeStatusOnHover();            
                    </script>';
         for($looper = 0; $looper < count($friendsFollowers); $looper++)
         { 
                if($userId){
                 
                        if($friendsFollowers[$looper]['user_id'] == $userId && $friendsFollowers[$looper]['user_friend_id']!= $userId)
                        {
                            $U_id = $this->id;
                            $U_F_id = $friendsFollowers[$looper]['user_friend_id'];
                            $STATUS = $this->getStatusFromDB($U_F_id);
                        }
                        else if($friendsFollowers[$looper]['user_id'] != $userId && $friendsFollowers[$looper]['user_friend_id']== $userId)
                        {
                            $U_id = $friendsFollowers[$looper]['user_id'];
                            $U_F_id = $this->id;
                            $STATUS = $this->getStatusFromDB($U_id);
                        }
                 $output .= '  
                     
                      <div class="FFHolderMain" style=" background-image: url('.$this->view->checkFFbckPic($friendsFollowers[$looper]['cover_picture']).');" >
                      <div class="PNTS"></div> 
                      
                      <div class="friendPicMain">'.$this->view->checkUserPicture($friendsFollowers[$looper]['picture'], 50, 50).'</div>
                      <div class="FriendNameMain"><b><a href="'.URL.'profile/user/'.$this->view->encrypt($this->view->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId )).'">'. $this->getFriendFollowNames($friendsFollowers[$looper]['user_type'], $friendsFollowers[$looper], $userId).'</a> </b></div>
                      <div class="friendUsertTypeMain">'. $friendsFollowers[$looper]['user_type'] .'<span><img class="FriendverifyImg" src="'.URL.'pictures/verify.png" width="12" height="12" alt=""></span> </div>
                      <div class="friendStatus" onclick="sendFriendShipToServer(\''.$STATUS.'\', \''.$U_id.'\', \''.$U_F_id.'\', \''.$pages.'\')">'.$STATUS.'</div>
                      
                      <ul>
                      <li class="recipeCount"><img src="'.URL.'pictures/profile/ENRI_recipe.png" width="20" height="20"><span>'.$recipePostCount[$looper].'</span></li>
                      <li class="friendCount"><img src="'.URL.'pictures/profile/ENRI_friends_icon.png" width="20" height="20"><span>'.$friendsCount[$looper].'</span></li>
                      <li class="followerCount"><img src="'.URL.'pictures/profile/ENRI_follower_icon.png" width="20" height="20"><span>'.$followerCount[$looper].'</span></li>
                      </ul>
                    </div>';
             }
             else{
                $output .= '   <div class="FFHolderMain" style=" background-image: url('.$this->view->checkFFbckPic($friendsFollowers[$looper]['cover_picture']).');" >
                                    <div class="PNTS"></div> 
                                    <div class="friendPicMain">'.$this->view->checkUserPicture($friendsFollowers[$looper]['picture'], 50, 50).'</div>
                                    <div class="FriendNameMain"><b><a href="'.URL.'profile/user/'.$this->view->encrypt($this->view->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $this->id )).'">'.$this->getFriendFollowNames($friendsFollowers[$looper]['user_type'], $friendsFollowers[$looper], $userId).'</a> </b></div>
                                    <div class="friendUsertTypeMain">'. $friendsFollowers[$looper]['user_type'] .'<span><img class="FriendverifyImg" src="'.URL.'pictures/verify.png" width="12" height="12" alt=""></span> </div>
                                    <div class="friendStatus" onclick="sendFriendShipToServer(\''.$this->getStatus($friendsFollowers[$looper]['status'], $friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId).'\', \''.$friendsFollowers[$looper]['user_id'].'\', \''.$friendsFollowers[$looper]['user_friend_id'].'\', \''.$pages.'\')">'.$this->getStatus($friendsFollowers[$looper]['status'], $friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId).'</div>
                                    
                                    <ul>
                                    <li class="recipeCount"><img src="'.URL.'pictures/profile/ENRI_recipe.png" width="20" height="20"><span>'.$recipePostCount[$looper].'</span></li>
                                    <li class="friendCount"><img src="'.URL.'pictures/profile/ENRI_friends_icon.png" width="20" height="20"><span>'.$friendsCount[$looper].'</span></li>
                                    <li class="followerCount"><img src="'.URL.'pictures/profile/ENRI_follower_icon.png" width="20" height="20"><span>'.$followerCount[$looper].'</span></li>
                                    </ul>
                               </div>';
             }
           $pages++;     
         }
            
           echo json_encode($output);
    }
    
 }
