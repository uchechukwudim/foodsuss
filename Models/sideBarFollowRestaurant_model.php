<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homeFollowRestaurant_model
 *
 * @author Uche
 */
class sideBarFollowRestaurant_model extends Model {
    //put your code here
    function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
    }
    
    
    function FollowRestaurant()
    {
        $restaurant = 'Restaurant';
        
        $sql = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type, F.user_id, F.user_friend_id, F.status
                FROM user_details AS U
                INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                WHERE F.user_id = :user_id AND F.status != :zero AND U.user_type = :user_type
                UNION 
                SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.cover_picture, U.user_type,  F.user_id, F.user_friend_id, F.status
                FROM user_details AS U
                INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                WHERE F.user_friend_id = :user_id AND F.status != :zero AND U.user_type = :user_type LIMIT 0, 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':user_id' => $this->id,
            ':zero' =>ZERO,
            ':user_type' => $restaurant
        ));
        
        $restaurantFollow = $sth->fetchAll();
         $recipePostCount = $this->recipePostCount( $restaurantFollow, $this->id);
         $friendsCount = $this->friendsCount( $restaurantFollow, $this->id);
         $followerCount = $this->followerCount( $restaurantFollow, $this->id);
         echo json_encode($this->loadRestaurantFollows( $restaurantFollow, $this->id, $recipePostCount,  $friendsCount,  $followerCount, $page=''));

    }
      
    private function loadRestaurantFollows($restaurantFollow, $userId, $recipePostCount,  $friendsCount,  $followerCount, $page)
    {
        $header = '<script> changeStatusOnHover()</script>'
                . '<div id="chefsFollowFriendsHeader" style="font-size: 1.2em;"><img src="'.URL.'pictures/ENRI_REST.png" width="30">  Restaurants You Follow/Friend</div>';
        
        if($page)
        {
                    $output ='' ;
        }
        else
        {
                    $output = $header;
        }

        
        for($looper = 0; $looper < count($restaurantFollow); $looper++)
        {
            $user_id = $restaurantFollow[$looper]['user_id'];  $friend_user_id=$restaurantFollow[$looper]['user_friend_id'];
            $output .= '<div class="FFHolderMain" style=" background-image: url('.$this->view->checkFFbckPic($restaurantFollow[$looper]['cover_picture']).');">
                           <div class="PNTS"></div> 
                           <div class="friendPicMain">'.$this->view->checkUserPicture($restaurantFollow[$looper]['picture'], 50, 50).'</div>
                           <div class="FriendNameMain"><a style="color:black;" href="'.URL.'profile/user/'.$this->encrypt($this->checkForFriendUser_id($this->id, $user_id, $friend_user_id)).'"><b>'.$this->getRestuarantName($this->checkForFriendUser_id($this->id, $user_id, $friend_user_id)).' </b></a></div>
                           <div class="friendUsertTypeMain">'.  $restaurantFollow[$looper]['user_type'] .'<span><img class="FriendverifyImg" src="'.URL.'pictures/verify.png" width="12" height="12" alt=""></span> </div>
                           <div class="friendStatus" onclick="sendFriendShipToServer(\''.$this->getStatus( $restaurantFollow[$looper]['status'],  $restaurantFollow[$looper]['user_id'],  $restaurantFollow[$looper]['user_friend_id'], $userId).'\', \''. $restaurantFollow[$looper]['user_id'].'\', \''. $restaurantFollow[$looper]['user_friend_id'].'\', \''.$looper.'\')">'.$this->getStatus( $restaurantFollow[$looper]['status'],  $restaurantFollow[$looper]['user_id'],  $restaurantFollow[$looper]['user_friend_id'], $userId).'</div>
                           
                            <ul>
                              <li class="recipeCount"><img src="'.URL.'pictures/profile/ENRI_recipe.png" width="20" height="20" title="Recipes Posted "><span>'.$recipePostCount[$looper].'</span></li>
                              <li class="friendCount"><img src="'.URL.'pictures/profile/ENRI_friends_icon.png" width="20" height="20" title="Friends"> <span>'.$friendsCount[$looper].'</span></li>
                              <li class="followerCount"><img src="'.URL.'pictures/profile/ENRI_follower_icon.png" width="20" height="20" title="Followers"><span>'.$followerCount[$looper].'</span></li>'
                         . '</ul>'
                    . '</div>';
        }
        
        return $output;
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
                if($friendsFollowers[$i]['user_id'] ==  $userId  && $friendsFollowers[$i]['user_friend_id'] != $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] != $userId  && $friendsFollowers[$i]['user_friend_id'] == $userId )
                {
                     $user_id = $friendsFollowers[$i]['user_id'];
                }
                $friendsCount[$i] = $this->getFriendCount($user_id);
            }
            else
            {
                if($friendsFollowers[$i]['user_id'] == $this->id && $friendsFollowers[$i]['user_friend_id'] != $this->id)
                {
                     $user_id = $friendsFollowers[$i]['user_friend_id'];
                }
                else if($friendsFollowers[$i]['user_id'] != $this->id && $friendsFollowers[$i]['user_friend_id'] == $this->id)
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
    
    function infinityFollowRestaurant($page)
    {
         $restaurant = 'Restaurant';
        
        $sql = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type, F.user_id, F.user_friend_id, F.status
                FROM user_details AS U
                INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                WHERE F.user_id = :user_id AND F.status != :zero AND U.user_type = :user_type
                UNION 
                SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type, F.user_id, F.user_friend_id, F.status
                FROM user_details AS U
                INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                WHERE F.user_friend_id = :user_id AND F.status != :zero AND U.user_type = :user_type LIMIT $page, 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':user_id' => $this->id,
            ':zero' =>ZERO,
            ':user_type' => $restaurant
        ));
        
        $restaurantFollow = $sth->fetchAll();
         $recipePostCount = $this->recipePostCount( $restaurantFollow, $this->id);
         $friendsCount = $this->friendsCount( $restaurantFollow, $this->id);
         $followerCount = $this->followerCount( $restaurantFollow, $this->id);
         echo json_encode($this->loadRestaurantFollows( $restaurantFollow, $this->id, $recipePostCount,  $friendsCount,  $followerCount, $page));

    }
}
