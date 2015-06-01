<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecipeSteps_model
 *
 * @author Uche
 */
class RecipeSteps_model extends Model {
    //put your code here
    function __construct(){
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
    }
    
    public function homeRecipeSteps($recipe_post_id, $recipeName){
          $this->view->js = array('home/js/homejs.js', 'home/js/homeUserCommentHandler.js', 
                                 'home/recipeSteps/js/recipesteps.js',
                                 'foodfinder/productsDialog/js/productjsFunctions.js',
                                 'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                  'profile/js/friendsFollowers.js'
                                );
      
        $this->view->css = array( 'css/home/homesheet.css',
                                   'css/home/enri_post.css',
                                   'css/home/recipestep.css',
                                  'css/foodfinder/food/errorDialgBoxSheet.css',
                                  'css/foodfinder/productsDialog/productsheet.css',
                                  'css/profile/followfriendssheet.css');
        $this->view->id = $this->id;
        
        $sql0 = "SELECT FirstName, LastName, picture, user_type FROM user_details WHERE user_id = :user_id";
        $sth0 = $this->db->prepare($sql0);
        $sth0->setFetchMode(PDO::FETCH_ASSOC);
        $sth0->execute(array(':user_id'=>  $this->id));
        $tempUserDetails = $sth0->fetchAll();
        $userDetails = $this->putRestaurantNameInFollowFriends($tempUserDetails);
        
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.description, RP.health_facts, RP.preparation_time, 
                RP.cooking_time, RP.recipe_photo, RP.meal_type, 
                RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName,
                U.LastName, U.picture, U.user_type, RP.recipe_pwi_active FROM recipe_post AS RP 
                INNER JOIN user_details AS U ON RP.user_id = U.user_id 
                WHERE recipe_post_id = :recipe_post_id AND recipe_title = :recipe_title";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_post_id'=> $recipe_post_id,
                            ':recipe_title' => $recipeName));
        
        $data = $sth->fetchAll(); 
        $tastyCount = $this->getTastyCount($data);
        $shareCount = $this->getShareCount($data);
        $cootItCount = $this->getCookitCount($data);
        $recipe = $this->pushCookBoxValToData($data);
        $recipePost_steps_with_images =  $this->getPWI($recipe_post_id);
        
        $sqlIng = "SELECT * FROM ingredients WHERE recipe_post_id = :recipe_post_id";
        $sthIng = $this->db->prepare($sqlIng);
        $sthIng->setFetchMode(PDO::FETCH_ASSOC);
        $sthIng->execute(array(':recipe_post_id' => $recipe_post_id));
        $ingredients = $sthIng->fetchAll();
        
        $sqlNut = "SELECT * FROM nutrition_fact WHERE recipe_post_id = :recipe_post_id";
        $sthNut = $this->db->prepare($sqlNut);
        $sthNut->setFetchMode(PDO::FETCH_ASSOC);
        $nutrition = $sthNut->fetchAll();
        
        $sqlCk = "SELECT CT.sharer_user_id, US.picture FROM recipe_post_cookedit AS CT 
                  INNER JOIN user_details AS US ON CT.sharer_user_id = US.user_id
                  WHERE CT.recipe_post_id = :recipe_post_id";
        $sthCk = $this->db->prepare($sqlCk);
        $sthCk->setFetchMode(PDO::FETCH_ASSOC);
        $sthCk->execute(array(':recipe_post_id' => $recipe_post_id));
        $result = $sthCk->fetchAll();
        $cookedItUsers = $this->getNamesForCookedIt($result);
        $userComments = $this->getrecipePostUserCommentsData(2);
        
        $fileName = 'recipeSteps/home/index';
        $this->view->renderRecipeStepsFromHome($fileName, $recipeName, $userDetails, $recipe, $ingredients, $nutrition, $cookedItUsers, $recipePost_steps_with_images, $tastyCount, $shareCount, $cootItCount, $userComments);
    }
    
    private function getNamesForCookedIt($cookedItUsers){
        
        for($looper =0; $looper < count($cookedItUsers); $looper++){
             $cookedItUsers[$looper]['name'] = $this->getUserFLNameOrRestNameOrEstName($cookedItUsers[$looper]['sharer_user_id']);
        }
        
        return $cookedItUsers;
    }
    
      private function putRestaurantNameInFollowFriends($userDetails){
          $restaurant = 'Restaurant';
          $newuserDetails= array();
          
         
          
              if($userDetails[ZERO]['user_type'] === $restaurant){
                  $newuserDetails[ZERO]['picture'] = $userDetails[ZERO]['picture'];
                  $newuserDetails[ZERO]['user_type'] = $userDetails[ZERO]['user_type'];
                  $newuserDetails[ZERO]['restaurant_name'] = $this->getRestName($this->id) ;
              }
              else{
                  $newuserDetails[ZERO]['FirstName'] = $userDetails[ZERO]['FirstName'];
                  $newuserDetails[ZERO]['LastName'] = $userDetails[ZERO]['LastName'];
                   $newuserDetails[ZERO]['picture'] = $userDetails[ZERO]['picture'];
                  $newuserDetails[ZERO]['user_type'] = $userDetails[ZERO]['user_type'];
                 // $newFollowFriends[$looper]['restaurant_name'] = $this->getRestName($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id']) ;
              }
          
          
          return $newuserDetails;
      }
    
      private function getTastyCount($data){
        $tastyCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $tastyCount[$loop] = $this->getTasty($data[$loop]['recipe_post_id']);
         
         }
         
         return $tastyCount;
    }
    
    private function getTasty($recipe_post_id){
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
     private function getShareCount($data){
        $shareCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $shareCount[$loop] = $this->getshare($data[$loop]['recipe_post_id']);
         
         }
         
         return  $shareCount;
    }
    
    private function getshare($recipe_post_id){
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
    
     
    private function getCookitCount($data){
        $cookitCount =array();
         for($loop = 0; $loop < count($data); $loop++)
         {
             $cookitCount[$loop] = $this->getCookedit($data[$loop]['recipe_post_id']);
         
         }
         
         return   $cookitCount;
    }
   
    private function getCookedit($recipe_post_id){
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
    private function pushCookBoxValToData($data){
        for($looper = 0; $looper < count($data); $looper++){
         $data[$looper]['cookbook'] = $this->isRecipeInCookBox($data[$looper]['recipe_post_id']);
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
    private function isRecipeInCookBox($recipe_post_id){
        $sql = "SELECT * FROM user_cook_box WHERE recipe_post_id = :recipe_post_id";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(":recipe_post_id" => $recipe_post_id));
        $res = $sth->fetchAll();
        
         if(count($res) > 0){
             return true;
         }else{
             return false;
         }
    }
    
      
    private function getPWI($recipe_post_id){
        $sql = "SELECT recipe_image, recipe_image_direction, step_count FROM recipe_pwi WHERE recipe_post_id = :recipe_post_id ORDER BY step_count ASC";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_post_id' => $recipe_post_id));
        
        $res = $sth->fetchAll();
        
        return $res;
    }
    
    
      private function getrecipePostUserCommentsData($recipe_post_id){
        return $this->getUserComment($recipe_post_id);
    }
    
    function getUserComment($recipe_post_id)
    {
        
       $sql = "SELECT recipe_post_comments_id, comments, user_id, time FROM recipe_post_comments WHERE recipe_post_id = :recipe_post_id ORDER by time ASC";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':recipe_post_id' => $recipe_post_id
       ));
       
       $result = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        return $this->getDetails($result);
    }
    
     private function getDetails($details){
       for($i =0; $i < count($details); $i++){
           $details[$i]['user_id'] = $details[$i]['user_id'];
           $details[$i]['userName'] = $this->getUserFLNameOrRestNameOrEstName($details[$i]['user_id']);
           $details[$i]['image'] = $this->getUserImage($details[$i]['user_id']);
           $details[$i]['time'] = $details[$i]['time'];
           $details[$i]['comments'] = $details[$i]['comments'];
           $details[$i]['recipe_post_comments_id'] = $details[$i]['recipe_post_comments_id'];
           $details[$i]['triedIt'] = $this->getuserTryit($details[$i]['recipe_post_comments_id']);
          
       }
       
       return $details;
    }
     private function getuserTryit($recipe_post_comments_id){
        $sql = "SELECT * FROM recipe_post_user_tryit WHERE recipe_post_comments_id = :r_p_cm_id";
                        $sth = $this->db->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_p_cm_id' => $recipe_post_comments_id
                         ));

           
                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         $count = count($data);
       $message = '';
     if($count >=2){
           $message = $count." people triedIt";
     }else if($count == 1){
          $message = $count." person triedIt";
     }else if($count == 0){
            $message = 'No tries yet';
        }
    
        return $message;
    }

}
