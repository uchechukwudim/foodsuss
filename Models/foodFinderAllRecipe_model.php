<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foodFinderAllRecipe_model
 *
 * @author Uche
 */
class foodFinderAllRecipe_model extends Model {
    //put your code here
    function __construct()
    {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
         
    }
    
    public function index($food){
        $this->view->id = $this->id;
        $this->view->css = new ArrayObject(array('css/foodfinder/recipes/recipeAll/recipeallsheet.css',
                                                 'css/foodfinder/recipes/errorDialgBoxSheet.css',
                                                 'css/foodfinder/food/errorDialgBoxSheet.css',
                                                  'css/profile/followfriendssheet.css'));
        //load js filess
        $this->view->js = array('foodfinder/recipes/js/mealjsfunctions.js', 
                                'foodfinder/recipes/allRecipe/js/allrecipeFunction.js',
                                'profile/js/friendsFollowers.js');
        
        $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.food_name = :food LIMIT 0 , 6";
        $sth = $this->db->Sdb->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
                            ':food' => $food,
                        ));
         $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
         if(count($recipes) !== 0){
                 $shareCounts = $this->getShares($recipes);
         $tastyCounts = $this->getTasties($recipes);
         $cookitCounts = $this->getcookits($recipes);
          
         $cookBox = $this->getUserCookBoxInfo($recipes);
         
         $userDetails = $this->getUserDetails($this->id);
         $userRecipeCommentCounts = $this->getRecipeCommentCounts($recipes);
         
         $comments = $this->getUserRecookComment($recipes);
         $fileName = ''.FOODFINDER.'/recipes/allRecipe/index';
        $this->view->renderFoodFinderAllRecipes($fileName, $userDetails, $food, $recipes, $comments, $shareCounts, $tastyCounts, $cookitCounts, $userRecipeCommentCounts, $cookBox, $food);
         //echo var_dump($recipes);
         }else{
             //check if the food exist if it does bring tell the users no recipes yet
             //if it doesnt show 404 message
             if(count($this->getFoodId($food)) !== ZERO){
                    $fileName = ''.FOODFINDER.'/recipes/allRecipe/index';
                     $userDetails = $this->getUserDetails($this->id);
                    $this->view->renderFoodFinderAllRecipes($fileName, $userDetails, $food, $recipes, $comments='', $shareCounts='', $tastyCounts='', $cookitCounts='', $userRecipeCommentCounts='', $cookBox='', $food);
     
             }
         }
     
    }
    
      private function getShares($data)
      {
        $sharesCounts = array();
        for($loop=0; $loop < count($data); $loop++)
        {
            $sharesCounts[$loop] = $this->getShareEN($data[$loop]['recipe_id']);
        }

        return $sharesCounts;
      }
   function getShareEN($recipe_id)
   {
       $sql = "SELECT user_id FROM recipe_share WHERE recipe_id= :R_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id
       ));
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       return count($data);
   }
   
   private function getTasties($data)
   {
       $tastyCounts = array();
       for($loop=0; $loop < count($data); $loop++)
       {
           $tastyCounts[$loop] = $this->getTastyEN($data[$loop]['recipe_id']);
       }
      return $tastyCounts;
   }
    private function getTastyEN($recipe_id)
    {
       $sql = "SELECT user_id FROM recipe_tasty WHERE recipe_id = :R_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id
       ));
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
      return count($data);
    }
    
      private function getcookits($data)
      {
        $cookitCounts = array();
        for($loop=0; $loop < count($data); $loop++)
        {
             $cookitCounts[$loop]= $this->getCookedItEN($data[$loop]['recipe_id']);
        }

        return $cookitCounts;
      }
   
     private function getCookedItEN($recipe_id)
     {
     
       $sql = "SELECT user_id FROM recipes_cookedit WHERE recipe_id = :R_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id
       ));
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       return count($data);
       
    }
    
     private function getRecipeCommentCounts($data)
     {
       $recipeCommentsCount = array();
  
       for($loop=0; $loop < count($data); $loop++)
       {
           $recipeCommentsCount[$loop] = $this->getUserRecookCommentCount($data[$loop]['recipe_id']);
       }
       return $recipeCommentsCount;
     }
   
     private function getUserRecookCommentCount($recip_id)
     {
       $sql = "SELECT * FROM recipes_recook WHERE recipe_id = :r_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':r_id' => $recip_id
       ));
       
       $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
       
     
         return count($data);
       
     }
     
       function getUserRecookComment($recipes)
       {
            $details = array();
            $recookComments = array();
            for($looper = 0; $looper < count($recipes); $looper++){
                 $sql = "SELECT recipe_recook_id, recook, user_id, time FROM recipes_recook WHERE recipe_id = :recipeId ORDER by time ASC";
                 $sth = $this->db->Sdb->prepare($sql);
                 $sth->setFetchMode(PDO::FETCH_ASSOC);
                 $sth->execute(array(
                     ':recipeId' => $recipes[$looper]['recipe_id']
                 ));

                 $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                 $detail = $this->getDetails($data, $details);
                 $recookComments[$looper] = $detail;
            }


           return $recookComments;
      }
   
      public function getSingleUserRecookComment($recipe_id, $food_id, $Rcook)
      {
            $details = array();
            $sql = "SELECT recipe_recook_id, recook, user_id, time FROM recipes_recook WHERE recipe_id = :recipeId AND recook = :recook AND food_id= :food_id and user_id = :user_id ORDER by time ASC";
            $sth = $this->db->Sdb->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(
                ':recipeId' => $recipe_id,
                ':recook' => $Rcook,
                ':food_id'=> $food_id,
                ':user_id'=> $this->id
            ));

            $data = $sth->fetchAll(PDO::FETCH_ASSOC);
            $detail = $this->getDetails($data, $details);



           echo json_encode($this->loadUserRecook($detail));
      }
     private function getDetails($data, $details)
     {
       for($i =0; $i < count($data); $i++)
       {
           $details[$i]['user_id'] = $data[$i]['user_id'];
           $details[$i]['userName'] = $this->getUserFLNameOrRestNameOrEstName($data[$i]['user_id']);
           $details[$i]['image'] = $this->getUserImage($data[$i]['user_id']);
           $details[$i]['time'] = $data[$i]['time'];
           $details[$i]['comment'] = $data[$i]['recook'];
           $details[$i]['recipe_recook_id'] = $data[$i]['recipe_recook_id'];
           $details[$i]['try_it'] = $this->getuserTryit($data[$i]['recipe_recook_id']);
       }
       
       return $details;
    }
    
     private function getuserTryit($recipe_recook_id)
     {
        $sql = "SELECT * FROM recipe_reccook_tryitusercount WHERE recipe_recook_id = :r_r_i";
                        $sth = $this->db->Sdb->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_r_i' => $recipe_recook_id
                         ));

           
                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         $count = count($data);
       $message = '';
        if($count >=2)
           $message = $count." people triedIt";
        else if($count == 1)
          $message = $count." person triedIt";
        else if($count < 1){
            $message = 'No tries yet';
        }
        
        return $message;
    }
    
    
    public function showAllComment($recipe_id){
        $details = array();
        $sql = "SELECT recipe_recook_id, recook, user_id, time FROM recipes_recook WHERE recipe_id = :recipeId ORDER by time ASC";
                 $sth = $this->db->Sdb->prepare($sql);
                 $sth->setFetchMode(PDO::FETCH_ASSOC);
                 $sth->execute(array(
                     ':recipeId' => $recipe_id
                 ));

                 $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                 $detail = $this->getDetails($data, $details);
       echo json_encode($this->loadUserComment($detail));
    }
    
      public function putInMyCookBox($recipe_id){
        $recipe_table = 'ENRIRECIPEPOST';
        $sql = "SELECT * FROM user_cook_box WHERE recipe_post_id = :recipe_post_id AND user_id = :user_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":recipe_post_id" => $recipe_id,
                            ":user_id"=>  $this->id));
        $res = $sth->fetchAll();
        
        if(count($res) === ZERO){
            //insert
            $SQL = "INSERT INTO user_cook_box VALUES(:user_cook_box, :recipe_post_id, :user_id, :recipe_table)";
            $sth = $this->db->prepare($SQL);
            if($sth->execute(array(":user_cook_box"=> "", ":recipe_post_id" => $recipe_id, ":user_id" => $this->id, ":recipe_table"=> $recipe_table))){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }
    }
    
    private function getUserCookBoxInfo($recipes){
        $cookBoxinfo =  array();
        for($looper= 0; $looper < count($recipes); $looper++){
            $cookBoxinfo[$looper] = $this->isInCookBox($recipes[$looper]['recipe_id']);
        }
        
        return $cookBoxinfo;
    }
    private function isInCookBox($recipe_id){
        $recipe_table = "ENRIRECIPEPOST";
        $sql = "SELECT * FROM user_cook_box WHERE recipe_post_id = :recipe_id AND recipe_table = :recipe_table AND user_id = :user_id";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(":recipe_id"=>$recipe_id, ":recipe_table"=>$recipe_table, ":user_id"=>$this->id));
        $res = $sth->fetchAll();
        if(count($res) === 0){
            return false;
        }else{
            return true;
        }
    }
    
    public function getAllEnriRecipes($food){
        $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.food_name = :food LIMIT 0 , 6";
        $sth = $this->db->Sdb->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array( ':food' => $food,));
        $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
         if(count($recipes ) === ZERO){
            echo json_encode(false);
         }else{
            $shareCounts = $this->getShares($recipes);
            $tastyCounts = $this->getTasties($recipes);
            $cookitCounts = $this->getcookits($recipes);
            $cookBox = $this->getUserCookBoxInfo($recipes);
            $comments = $this->getUserRecookComment($recipes);
            
            echo json_encode($this->loadENRecipes($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox));
         }
    }
    
   
    public function infinitScrollAllENRecipeLoader($pages, $food){
        $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.food_name = :food LIMIT $pages , 6";
        $sth = $this->db->Sdb->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
                            ':food' => $food,
                        ));
         $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
       
            $shareCounts = $this->getShares($recipes);
            $tastyCounts = $this->getTasties($recipes);
            $cookitCounts = $this->getcookits($recipes);
            $cookBox = $this->getUserCookBoxInfo($recipes);
            $comments = $this->getUserRecookComment($recipes);
            
           echo json_encode($this->infinityLoadENRecipes($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox, $pages));
        
    }
    //loaders here:::::::::::::::::::::::::::::::::::::::::::::::::
   
     private function infinityLoadENRecipes($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox, $pages){
         $output = '';
         
         for($looper = 0; $looper < count($recipes); $looper++){
             $output .= '  
                             <script type="text/javascript">
                              inifityScroltooltip(\''.$pages.'\')
                            </script>
                            <div class="post_profile_photo"><img src="data:image/jpeg;base64,'.base64_encode($recipes[$looper]['recipe_photo']).'" width="100" height="100"></div>
                            <div class="feed_1">
                                    <div class="post_text">
                                            <ul >
                                                <li class="RecpPhoto">
                                                    '. $this->view->checkPWIPictures($recipes[$looper]['recipe_id'], $recipes[$looper]['recipe_photo']).' 
                                                </li>
                                                <li class="post_flag">
                                                    <img class="homeCountry" src="data:image/jpeg;base64,'.base64_encode( $recipes[$looper]['flag_picture']).'" width="20" height="20" title="'. $recipes[$looper]['country_names'].'"> 
                                                    <img class="homeFood" src="data:image/jpeg;base64,'.base64_encode( $recipes[$looper]['food_picture']).'" width="20" height="20" title="'.$recipes[$looper]['food_name'].'">
                                               </li>
                                               <li><span class="mealType">'.$this->view->checkMealType($recipes[$looper]['meal_type'], 25, 25).'</span></li>
                                               <li class="hashTagTitle"><b>'.$recipes[$looper]['recipe_title'].'</b></li>
                                               <li class="recipDesc">'.$recipes[$looper]['cook'].'</li>
                                               <li class="post_profile_link">
                                                    <ul class="TYCKSHR">
                                                        <li class="tastyCount"  onclick="insertTastyEN(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$pages.'\')title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCounts[$looper]).'</span></li>
                                                        <li class="cookCount" onclick="CookIt(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$pages.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cookitCounts[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cookitCounts[$looper]).'</span></li>
                                                        <li class="shareCount" onclick="insertShareEN(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$pages.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCounts[$looper]).'</span></li>
                                                    </ul>
                                                     <ul class="recipeNav">
                                                        <li class="cookboxit" onclick="putInMyCookBox(\''.$recipes[$looper]['recipe_id'].'\', \''.$pages.'\')">'.$this->view->checkCoobBoxPic($cookBox[$looper], 20, 20).'</li>
                                                        <li onclick="showShops(\''. $pages.'\', \''.$recipes[$looper]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                                     </ul>
                                               </li>
                                           </ul>
                                   </div>
                            </div>';
             $pages++;
         }
         return $output;
     }
     
      private function loadENRecipes($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox){
         $output = '';
         
         for($looper = 0; $looper < count($recipes); $looper++){
             $output .= ' <script type="text/javascript">
                              inifityScroltooltip(\''.$looper.'\')
                            </script>
                            <div class="post_profile_photo"><img src="'.URL.'pictures/favicon3.png" width="100" height="100"></div>
                            <div class="feed_1">
                                    <div class="post_text">
                                            <ul >
                                                <li class="RecpPhoto">
                                                    '. $this->view->checkPWIPictures($recipes[$looper]['recipe_id'], $recipes[$looper]['recipe_photo']).' 
                                                </li>
                                                <li class="post_flag">
                                                    <img class="homeCountry" src="data:image/jpeg;base64,'.base64_encode( $recipes[$looper]['flag_picture']).'" width="20" height="20" title="'. $recipes[$looper]['country_names'].'"> 
                                                    <img class="homeFood" src="data:image/jpeg;base64,'.base64_encode( $recipes[$looper]['food_picture']).'" width="20" height="20" title="'.$recipes[$looper]['food_name'].'">
                                               </li>
                                               <li><span class="mealType">'.$this->view->checkMealType($recipes[$looper]['meal_type'], 25, 25).'</span></li>
                                               <li class="hashTagTitle"><b>'.$recipes[$looper]['recipe_title'].'</b></li>
                                               <li class="recipDesc">'.$recipes[$looper]['cook'].'</li>
                                               <li class="post_profile_link">
                                                    <ul class="TYCKSHR">
                                                        <li class="tastyCount"  onclick="insertTastyEN(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$looper.'\')title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCounts[$looper]).'</span></li>
                                                        <li class="cookCount" onclick="CookIt(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cookitCounts[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cookitCounts[$looper]).'</span></li>
                                                        <li class="shareCount" onclick="insertShareEN(\''.$recipes[$looper]["recipe_id"].'\', \''.$recipes[$looper]["country_id"].'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCounts[$looper]).'</span></li>
                                                    </ul>
                                                     <ul class="recipeNav">
                                                        <li class="cookboxit" onclick="putInMyCookBox(\''.$recipes[$looper]['recipe_id'].'\', \''.$looper.'\')">'.$this->view->checkCoobBoxPic($cookBox[$looper], 20, 20).'</li>
                                                        <li onclick="showShops(\''. $looper.'\', \''.$recipes[$looper]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                                     </ul>
                                               </li>
                                           </ul>
                                   </div>
                            </div>';
            
         }
         return $output;
     }
    
     private function loadUserComment($userComments){
        $output = '';
        for($looper = 3; $looper < count($userComments); $looper++){
            
            $output .='<div class="user_photo"><img src="data:image/jpeg;base64,'.base64_encode($userComments[$looper]["image"]).'" width="35"></div>
                        <div class="user_name"><b><a href="'.URL.' profile/user/'.$this->encrypt($userComments[$looper]["user_id"]).'">'.$userComments[$looper]['userName'] .'</a></b></div> <div class="postTime">'.$this->timeCounter($userComments[$looper]["time"]).'</div>
                        <div class="user_comment">
                         '.$userComments[$looper]["comment"].'
                        </div>';
        }
        return $output;
    }
}
