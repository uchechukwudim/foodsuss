<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profile_model
 *
 * @author Uche
 */
class profile_model extends Model{
     function __construct() {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->foodies = 'Foodie';
        $this->chef = 'Chef';
        $this->restaurant = 'Restaurant';
        $this->establishment = 'Establishment';
        $this->GAPI_KEY = 'AIzaSyATqukgypXfCIXhRgHQ_LJQFaZwG6naZyw';
    }
    
    function index()
    {
          $userId = $this->id;
         $this->view->js = array('profile/js/profile.js',
                                  'profile/js/aboutMe.js',
                                  'profile/js/myCookBook.js',
                                  'profile/js/myCookBox.js',
                                  'profile/js/friendsFollowers.js',
                                  'https://maps.googleapis.com/maps/api/js?key='.$this->GAPI_KEY.'');
         
         $this->view->css = array('css/profile/profilesheet.css', 
                                  'css/profile/aboutsheet.css',
                                   'css/profile/mycookbooksheet.css',
                                   'css/profile/followfriendssheet.css', 
                                    'css/profile/errorDialgBoxSheet.css');
         $this->view->id = $this->id;
         
         //getting user details here
         $sql = "SELECT * FROM user_details WHERE user_id = :user_id";
         
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         
         $sth->execute(array(
             ':user_id' => $this->id
         ));
         
         $userDetails = $sth->fetchAll();
   
         //getting friends and followers here
         $sql1 = "SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type,F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                  WHERE F.user_id = :user_id AND F.status != :zero
                  UNION 
                  SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type, F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                  WHERE F.user_friend_id = :user_id AND F.status != :zero
                  ORDER BY RAND() DESC";
         $sth1 = $this->db->prepare($sql1);
         $sth1->setFetchMode(PDO::FETCH_ASSOC);
         $sth1->execute(array(
             ':user_id' => $this->id,
             ':zero'=>ZERO
         ));
         
         
         //get cookBox here
         
         $cookBox = $this->getCookBox();
         
         
         $friendsFollowers  = $sth1->fetchAll();
         //$friendsFollowers = $this->putRestaurantNameInFollowFriends($tempFriendsFollowers, $this->id);
         //get "mycookbook here
         $sql2 = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, RP.recipe_pwi_active,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipe_post AS RP
                  INNER JOIN food AS F ON RP.food_id = F.food_id
                  INNER JOIN country AS C ON RP.country_id = C.country_id
                  WHERE user_id = :user_id ORDER BY RP.post_time DESC
                  LIMIT 0 , 6";
         $sth2 = $this->db->prepare($sql2);
         $sth2->setFetchMode(PDO::FETCH_ASSOC);
         $sth2->execute(array(
             'user_id' => $this->id
         ));
         
         $myCB = $sth2->fetchAll();
         $myCookBook = $this->pushPWIIntoData($myCB);
         
     
        $userComments = $this->getrecipePostUserCommentsData($myCookBook);
        $foodCountry = $this->getRecipePostFoodCountry($myCookBook);
   
       $tastyCount = $this->getTastyCount($myCookBook);
       $shareCount = $this->getShareCount($myCookBook);
       $cootItCount = $this->getCookitCount($myCookBook);
   
         //get images here
         $sql3 = "SELECT recipe_photo, recipe_title FROM recipe_post WHERE user_id= :user_id";
         $sth3 = $this->db->prepare($sql3);
         $sth3->setFetchMode(PDO::FETCH_ASSOC);
         $sth3->execute(array(
             ':user_id' => $this->id
         ));
         
         $recipeImages = $sth3->fetchAll();
        
        
      //echo var_dump($myCookBook);
      $this->openProfile($userDetails[ZERO]['user_type'], $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='');
    }
    
    
    private function openProfile($type, $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='')
    {
        if($type === $this->foodies)
        {
            $this->view->renderProfilePage('profile/types/foodies/index', $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='');
        }
        else if($type === $this->chef)
        {
            $this->view->renderProfilePage('profile/types/Chef/index', $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='');
        }
        else if($type === $this->restaurant){
            $this->view->js = array('profile/js/profile.js',
                                  'profile/types/restaurant/js/restaurantAboutMe.js',
                                  'profile/js/myCookBook.js',
                                   'profile/js/myCookBox.js',
                                  'profile/js/friendsFollowers.js',
                                  'https://maps.googleapis.com/maps/api/js?key='.$this->GAPI_KEY.'');
            
             $this->view->css = array('css/profile/profilesheet.css', 
                                  'css/profile/restaurantaboutmesheet.css',
                                   'css/profile/mycookbooksheet.css',
                                   'css/profile/followfriendssheet.css',
                                    'css/profile/errorDialgBoxSheet.css');
            //getting user details here
         $sql = "SELECT * FROM restaurant_users WHERE user_id = :user_id";
         
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         
         $sth->execute(array(
             ':user_id' => $this->id
         ));
         
         $restaurantinitDetails = $sth->fetchAll();
            $this->view->renderProfilePage('profile/types/restaurant/index', $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='', $restaurantinitDetails);
        }
        else if($type == $this->establishment)
        {
            $this->view->renderProfilePage('profile/types/establishment/index', $userDetails , $friendsFollowers, $myCookBook, $cookBox, $recipeImages, $userComments,  $foodCountry,   $tastyCount, $shareCount,   $cootItCount,   $userId, $status='',   $statusDetails='', $email='', $recipePostCount='', $friendsCount='', $followerCount='');
        }
    }
    
    private function pushPWIIntoData($data){
        for($looper = 0; $looper < count($data); $looper++){
           //get recipe_pwi details 
           if($this->checkPostWithPicture($data[$looper]['recipe_post_id'], $data[$looper]['recipe_pwi_active']) !== false){
                $res = $this->checkPostWithPicture($data[$looper]['recipe_post_id'], $data[$looper]['recipe_pwi_active']);
                  if(count($res) !== ZERO){
                       $data[$looper]['recipe_dir_image'] = $res[ZERO]['recipe_image'];
                       $data[$looper]['recipe_image_dir'] = $res[ZERO]['recipe_image_direction'];
                  }else{
                     $data[$looper]['recipe_dir_image'] = 'NONE';
                       $data[$looper]['recipe_image_dir'] = '';
                  }
           }
        }
        
        return $data;
    }
     
    private function checkPostWithPicture($recipe_post_id, $recipe_pwi){
        $TRUE = 'TRUE';
        $FALSE = 'FALSE';
        if($recipe_pwi === $TRUE){
            //get picture from recipe_pwi
            return $this->getRecipe_pwi_picture_text($recipe_post_id);
        }else if($recipe_pwi === $FALSE){
            return false;
        }
        
    }
    
    private function getRecipe_pwi_picture_text($recipe_post_id){
        $sql = "SELECT recipe_image, recipe_image_direction FROM recipe_pwi WHERE recipe_post_id = :recipe_post_id LIMIT 0, 1";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_post_id' => $recipe_post_id));
        
        $result = $sth->fetchAll();
        
        return $result;
    }
    
    private function getCookBox(){
        $cookBox = array();
        $URecpPost = 'USERRECIPEPOST';
         $ERecpPost = 'ENRIRECIPEPOST';
        $sql = "SELECT recipe_post_id, recipe_table FROM user_cook_box WHERE user_id = :user_id LIMIT 0, 6";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":user_id"=>  $this->id));
        $cB = $sth->fetchAll();
        
        for($looper = 0; $looper < count($cB); $looper++){
            if($cB[$looper]['recipe_table'] === $URecpPost){
            
                $cookBox[$looper] = $this->getFromUserRecipePost($cB[$looper]['recipe_post_id']);
            }
            
            if($cB[$looper]['recipe_table'] === $ERecpPost){
                 $cookBox[$looper] = $this->getFromEnriRecipePost($cB[$looper]['recipe_post_id']);
            }
        }
        
        return $cookBox;
        
    }
    private function getFromUserRecipePost($recipe_post_id){
        $URecpPost = 'USERRECIPEPOST';
  
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipe_post AS RP
                  INNER JOIN food AS F ON RP.food_id = F.food_id
                  INNER JOIN country AS C ON RP.country_id = C.country_id
                  WHERE  RP.recipe_post_id = :recipe_post_id";
        
                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':recipe_post_id' => $recipe_post_id
                    ));
                    $myCookBox = $sth->fetchAll();
                    $myCookBox[0]['recipe_table'] =  $URecpPost;
              return $myCookBox;
    }
    
    private function getFromEnriRecipePost($recipe_post_id){
        $ERecpPost = 'ENRIRECIPEPOST';
        $sql =   "SELECT R.recipe_id, R.recipe_title, R.recipe_photo, R.cook, R.health_benefits, R.ingridients, R.food_id, R.country_id, R.meal_type,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipes AS R
                  INNER JOIN food AS F ON R.food_id = F.food_id
                  INNER JOIN country AS C ON R.country_id = C.country_id
                  WHERE R.recipe_id = :recipe_id";
        
                    $sth = $this->db->Sdb->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':recipe_id' => $recipe_post_id
                    ));

                    $myCookBox = $sth->fetchAll();
                    $myCookBox[0]['recipe_table'] = $ERecpPost;
                    
             return $myCookBox;
    }
      
     private function putRestaurantNameInFollowFriends($friendsFollowers, $thisUserId)
      {
          $restaurant = 'Restaurant';
          $newFollowFriends = array();
          
       ;
            
          for($looper = 0; $looper < count($friendsFollowers); $looper++)
          {
               $user_friend_id = $friendsFollowers[$looper]['user_friend_id'];
             $user_id = $friendsFollowers[$looper]['user_id'];
          
              if($friendsFollowers[$looper]['user_type'] === $restaurant)
              {
                 
                  $newFollowFriends[$looper]['picture'] = $friendsFollowers[$looper]['picture'];
                  $newFollowFriends[$looper]['user_id'] = $friendsFollowers[$looper]['user_id'];
                  $newFollowFriends[$looper]['user_friend_id'] = $friendsFollowers[$looper]['user_friend_id'];
                  $newFollowFriends[$looper]['status'] = $friendsFollowers[$looper]['status'];
                    $newFollowFriends[$looper]['user_type'] = $friendsFollowers[$looper]['user_type'];
                  $newFollowFriends[$looper]['restaurant_name'] = $this->getRestName($this->checkForFriendUser_id($thisUserId, $user_id, $user_friend_id)) ;
              }
              else
              {
                  $newFollowFriends[$looper]['FirstName'] = $friendsFollowers[$looper]['FirstName'];
                  $newFollowFriends[$looper]['LastName'] = $friendsFollowers[$looper]['LastName'];
                  $newFollowFriends[$looper]['picture'] = $friendsFollowers[$looper]['picture'];
                  $newFollowFriends[$looper]['user_id'] = $friendsFollowers[$looper]['user_id'];
                  $newFollowFriends[$looper]['user_friend_id'] = $friendsFollowers[$looper]['user_friend_id'];
                  $newFollowFriends[$looper]['status'] = $friendsFollowers[$looper]['status'];
                    $newFollowFriends[$looper]['user_type'] = $friendsFollowers[$looper]['user_type'];
                 // $newFollowFriends[$looper]['restaurant_name'] = $this->getRestName($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id']) ;
              }
          }
          
          return $newFollowFriends;
      }
      
      private function getRestName($user_id)
      {

         $restaurant = 'Restaurant';
           $name1 = $this->getRestuarantName($user_id);
           return $name1;
        
      }
  
     
    private function getrecipePostUserCommentsData($data)
    {
      $userComments = array();
      $index = "INDEX";
         for($loop = 0; $loop < count($data); $loop++)
         {
           $recipe_post_id = $data[$loop]['recipe_post_id'];
            $userComments[$loop] = $this->getUserComment($recipe_post_id , $index);
         }
        
        return  $userComments;
    }
    
     function getUserComment($recipe_post_id , $which)
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
      
            if($which == "INDEX")
            {
              return $detail;
            }
            else if($which == "CMPOST")
            {
                 echo $this->loadUserRecook($detail);
            }
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
           $details[$i]['triedIt'] = $this->getuserTryit($data[$i]['recipe_post_comments_id']);
          
       }
       
       return $details;
    }
    
      private function getRecipePostFoodCountry($data)
      {
          $foodCountry = array();
            for($loop = 0; $loop < count($data); $loop++)
             {
                $food_id = $data[$loop]['food_id'];
                $country_id = $data[$loop]['country_id'];
                $foodCountry[$loop] = $this->getCountryFoodName($food_id, $country_id);
             }
        
            return $foodCountry;
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
       private function getTastyCount($data)
       {
        $tastyCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $tastyCount[$loop] = $this->getTasty($data[$loop]['recipe_post_id']);
         
         }
         
         return $tastyCount;
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
    
     private function getShareCount($data)
    {
        $shareCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $shareCount[$loop] = $this->getshare($data[$loop]['recipe_post_id']);
         
         }
         
         return  $shareCount;
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
    
     private function getCookitCount($data)
    {
        $cookitCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $cookitCount[$loop] = $this->getCookedit($data[$loop]['recipe_post_id']);
         
         }
         
         return   $cookitCount;
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
    
      private function getuserTryit($recipe_post_comments_id)
     {
        $sql = "SELECT * FROM recipe_post_user_tryit WHERE recipe_post_comments_id = :r_p_cm_id";
                        $sth = $this->db->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_p_cm_id' => $recipe_post_comments_id
                         ));

           
                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         $count = count($data);
       $message = '';
        if($count >=2)
           $message = $count." people triedIt";
        else if($count == 1)
          $message = $count." person triedIt";
        else if($count == 0){
            $message = 'No tries yet';
        }
    
        return $message;
    }
    
    
    public function uploadProfilePicture($imageData, $imageName)
    {
        $sql = "UPDATE  user_details SET  picture = :picture  WHERE user_id = :user_id";
        $sth = $this->db->prepare($sql);
        
        if($sth->execute(array(':picture'=>$imageData, ':user_id'=> $this->id)))
        {
            echo json_encode(true);
        }
        else
        {
            $sth->errorInfo();
        }
    }
    
    public function uploadProfileCover($imageData, $imageName)
    {
        $sql = "UPDATE  user_details SET  cover_picture = :cover_picture  WHERE user_id = :user_id";
        $sth = $this->db->prepare($sql);
        
        if($sth->execute(array(':cover_picture'=>$imageData, ':user_id'=> $this->id)))
        {
             echo json_encode(true);
        }
        else
        {
            $sth->errorInfo();
        }
    }
    
    public function getUploadedImage($which)
    {
        $profilePic = "PROFILEPIC";
        $profileCover = "PROFILECOVER";
        if($which == $profilePic )
        {
            $sql = "SELECT picture FROM user_details WHERE user_id = :user_id";
            
            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(':user_id'=>  $this->id));
            
            $image = $sth->fetchAll();
              echo json_encode('data:image/jpeg;base64,'.base64_encode($image[0]['picture']).'');
        }
        else if($which == $profileCover )
        {
             $sql = "SELECT cover_picture FROM user_details WHERE user_id = :user_id";
             $sth = $this->db->prepare($sql);
             $sth->setFetchMode(PDO::FETCH_ASSOC);
             $sth->execute(array(':user_id'=>  $this->id));
            
             $image = $sth->fetchAll();
             
             echo json_encode('data:image/jpeg;base64,'.base64_encode($image[0]['cover_picture']).'');
        }
    }
    
    private function getFriendsFollowersCount(){
      $sql = 'SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type,F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_friend_id
                  WHERE F.user_id = :user_id AND F.status != 0
                  UNION 
                  SELECT U.user_id, U.FirstName, U.LastName, U.picture, U.user_type, F.user_id, F.user_friend_id, F.status
                  FROM user_details AS U
                  INNER JOIN  `friends` AS F ON U.user_id = F.user_id
                  WHERE F.user_friend_id = :user_id AND F.status != :zero';
      
      $sth = $this->db->prepare($sql);
      $sth->setFetchMode(PDO::FETCH_ASSOC);
      $sth->execute(array(':user_id'=> $this->id, ':zero'=>ZERO));
      
      $count = count($sth->fetchAll());
      
      return $count;
    }
    
    private function getCookBookCount(){
        $sql =   'SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipe_post AS RP
                  INNER JOIN food AS F ON RP.food_id = F.food_id
                  INNER JOIN country AS C ON RP.country_id = C.country_id
                  WHERE user_id = :user_id';
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array('user_id'=>  $this->id));
        
        $count = count($sth->fetchAll());
        
        return $count;
    }
    private function getCookBoxCount(){
        
    }
}