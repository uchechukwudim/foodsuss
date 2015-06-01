<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foodFinderRecipes_model
 *
 * @author Uche
 */
class foodFinderRecipes_model extends Model{
  
   function __construct()
   {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
     
   }
   
   //Meal page::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    function recipesbycountry($food, $country)
    {
        //load css files
        $this->view->css = new ArrayObject(array('css/foodfinder/recipes/mealsheet.css', 
                                                'css/foodfinder/recipes/imageDialog.css',
                                                 'css/foodfinder/recipes/errorDialgBoxSheet.css',
                                                 'css/foodfinder/food/errorDialgBoxSheet.css',
                                                'css/foodfinder/productsDialog/productsheet.css',
                                                  'css/profile/followfriendssheet.css'));
        //load js filess
        $this->view->js = array('foodfinder/recipes/js/mealjsfunctions.js', 
                                'foodfinder/recipes/js/userPostfunctions.js',
                                'foodfinder/recipes/js/runMealFunctions.js',
                                'foodfinder/food/js/foodpage.js', 
                                'foodfinder/food/js/tooltip.js',
                                'foodfinder/productsDialog/js/productjsFunctions.js',
                                'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                'profile/js/friendsFollowers.js');
    
        $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.country_names =  :country
                 AND FR.food_name =  :food
                 LIMIT 0 , 6";
        $sth = $this->db->Sdb->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
                            ':food' => $food,
                            ':country' => $country
                        ));
         $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
         $shareCounts = $this->getShares($recipes, $country);
         $tastyCounts = $this->getTasties($recipes, $country);
         $cookitCounts = $this->getcookits($recipes, $country);
        
         $flag_picture = $this->getCountryFlagPicture($country);
         $food_picture = $this->getFoodPicture($food);
         
         $cookBox = $this->getUserCookBoxInfo($recipes);
         
         $userDetails = $this->getUserDetails($this->id);
         $userRecipeCommentCounts = $this->getRecipeCommentCounts($recipes);
         
         $comments = $this->getUserRecookComment($recipes);
        
         $fileName = ''.FOODFINDER.'/recipes/index';
     
         $this->view->renderFoodFinderRecipesbycountry($fileName, $userDetails, $country, $food, $flag_picture, $food_picture, $recipes, $comments, $shareCounts, $tastyCounts, $cookitCounts, $cookBox);
     
    }
    
    private function getShares($data, $country)
    {
        $sharesCounts = array();
        for($loop=0; $loop < count($data); $loop++)
        {
            $sharesCounts[$loop] = $this->getShareEN($data[$loop]['recipe_id'], $this->getCountryID($country));
        }
        
      return $sharesCounts;
    }
   function getShareEN($recipe_id, $country_id)
   {
       $sql = "SELECT user_id FROM recipe_share WHERE recipe_id= :R_id AND country_id = :c_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id,
           ':c_id' => $country_id
       ));
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       return count($data);
   }
   
   private function getTasties($data, $country)
   {
       $tastyCounts = array();
       for($loop=0; $loop < count($data); $loop++)
       {
           $tastyCounts[$loop] = $this->getTastyEN($data[$loop]['recipe_id'], $this->getCountryID($country));
       }
      return $tastyCounts;
   }
    private function getTastyEN($recipe_id, $country_id)
   {
       $sql = "SELECT user_id FROM recipe_tasty WHERE recipe_id= :R_id AND country_id = :c_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id,
           ':c_id' => $country_id
       ));
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
     return count($data);
   }
   
   private function getcookits($data, $country)
   {
       $cookitCounts = array();
       for($loop=0; $loop < count($data); $loop++)
       {
            $cookitCounts[$loop]= $this->getCookedItEN($data[$loop]['recipe_id'], $this->getCountryID($country));
       }
       
       return $cookitCounts;
   }
   
  private function getCookedItEN($recipe_id, $country_id)
   {
     
       $sql = "SELECT user_id FROM recipes_cookedit WHERE recipe_id= :R_id AND country_id = :c_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':R_id' => $recipe_id,
           ':c_id' => $country_id
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
   
   function getSingleUserRecookCommentCount($recipe_id)
    {
       $sql = "SELECT * FROM recipes_recook WHERE recipe_id = :r_id";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':r_id' => $recipe_id
       ));
       
       $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        echo count($data);
       
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
      
        function getEnriRecipes($food, $country)
    {
        $this->userSwitch = 1;
        $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.country_names =  :country
                 AND FR.food_name =  :food
                 LIMIT 0 , 6";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
                            ':food' => $food,
                            ':country' => $country
                        ));
         $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
         if(count($recipes ) === ZERO)
         {
            echo json_encode(false);
         }else{
            
            $shareCounts = $this->getShares($recipes, $country);
            $tastyCounts = $this->getTasties($recipes, $country);
            $cookitCounts = $this->getcookits($recipes, $country);
            $cookBox = $this->getUserCookBoxInfo($recipes);
            $comments = $this->getUserRecookComment($recipes);
        
         
            $this->loadMeal($recipes, "ENRIRECIPE", $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox);
         }
    }
  
   private function loadMeal($recipes, $which,  $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox)
   {
        $output = '';
        $recipe_post_tasty = "1";
        $recipe_post_share = '2';
              for($looper = 0; $looper < count($recipes); $looper++){
             $output .= '  
                             <script type="text/javascript">
                              inifityScroltooltip(\''.$looper.'\')
                            </script>
                           <div class="post_profile_photo"><img src="'.URL.'pictures/favicon3.png" width="100" height="100"></div>
                            <div class="feed_1">
                                    <div class="post_text">
                                            <ul >
                                                <li class="RecpPhoto">
                                                    '. $this->view->checkPWIPictures($recipes[$looper]['recipe_id'], $recipes[$looper]['recipe_photo']).' 
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
            if($which === "MEAL"){
                 $FirstName = $this->getUserFirstName($this->id);
                 $LastName = $this->getUserLastName($this->id);
                $image = 'data:image/jpeg;base64,'.base64_encode($this->getUserImage($this->id));
                    ?>
                         <script type="text/javascript">
                           loadMeal(<?php echo json_encode($output); ?>,<?php  echo json_encode($FirstName)?>,<?php  echo json_encode($LastName)?>,<?php  echo json_encode($image)?>);
                         </script> 
                   <?php
            }

            if($which ==="ENRIRECIPE")
            {
               echo json_encode($output);
            }

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
   
    function getSingleUserRecookComment($recipe_id, $food_id, $Rcook)
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
           $details[$i]['userName'] = $this->getUserFirstName($data[$i]['user_id']);
           $details[$i]['image'] = $this->getUserImage($data[$i]['user_id']);
           $details[$i]['time'] = $data[$i]['time'];
           $details[$i]['comments'] = $data[$i]['recook'];
           $details[$i]['recipe_recook_id'] = $data[$i]['recipe_recook_id'];
           $details[$i]['try_it'] = $this->getuserTryit($data[$i]['recipe_recook_id']);
       }
       
       return $details;
    }
    
     private function loadUserRecook($userComments)
    {
        $output = '';
        
        if(count($userComments) >= THREE){
             for($loop=0; $loop < THREE; $loop++)
            {
                $output .= '<div class="user_photo">'.$this->view->checkUserPicture($userComments[$loop]['image'], 35, 35) .'</div>
                            <div class="user_name"><b><a href="'. URL .'profile/user/'.$this->encrypt($userComments[$loop]['user_id']).'">'. $userComments[$loop]['userName'].'</a></b></div> <div class="postTime">'. $this->timeCounter($userComments[$loop]['time']).'</div>
                            <div class="user_comment">
                            '.$userComments[$loop]['comments'].'
                            </div>';
            }
        }else if(count($userComments) < THREE){
            for($loop=0; $loop < count($userComments); $loop++)
            {
                $output .= '<div class="user_photo">'.$this->view->checkUserPicture($userComments[$loop]['image'], 35, 35) .'</div>
                            <div class="user_name"><b><a href="'. URL .'profile/user/'.$this->encrypt($userComments[$loop]['user_id']).'">'. $userComments[$loop]['userName'].'</a></b></div> <div class="postTime">'. $this->timeCounter($userComments[$loop]['time']).'</div>
                            <div class="user_comment">
                            '.$userComments[$loop]['comments'].'
                            </div>';
            }
        }
       
        return $output;    
    }
   

  

    //meal page
    function Cookit($recipe_id, $country_id)
    {
        $sql = "SELECT * FROM recipes_cookedit WHERE country_id = :C_id AND user_id = :U_id AND recipe_id = :R_id";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':C_id' => $country_id,
            ':U_id' => $this->id,
            ':R_id' => $recipe_id,
        ));
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
                //check if the user have cookit before
                if(count($data) === 0)
                {
                    $sql = "INSERT INTO recipes_cookedit (recipe_CookedIt_id, country_id, user_id, recipe_id) VALUES (:Mid, :country_id, :user_id, :recipe_id)";
                    $sth = $this->db->Sdb->prepare($sql);
                    //check if it inserted
                    if($sth->execute(array(
                        ':Mid' => "",
                        ':country_id' => $country_id,
                        ':user_id' => $this->id,
                        ':recipe_id' => $recipe_id,
                    )))
                    {
                        echo json_encode($this->getCookedItEN($recipe_id, $country_id));
                    }
                    else{
                        echo $sth->errorInfo();
                    }
               }
              
    }
    
    function insertTastyEN($recipe_id, $country_id)
    {
         $sql = "SELECT * FROM recipe_tasty WHERE country_id = :C_id AND user_id = :U_id AND recipe_id = :R_id";
         $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':C_id' => $country_id,
            ':U_id' => $this->id,
            ':R_id' => $recipe_id,
        ));
       
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
         
        //check if the user have cookit before
                if(count($data) === 0)
                {
                    $sql = "INSERT INTO recipe_tasty (recipe_tasty_id,  recipe_id, user_id, country_id) VALUES (:Mid,  :recipe_id,  :user_id, :country_id)";
                    $sth = $this->db->Sdb->prepare($sql);
                    //check if it inserted
                    if($sth->execute(array(
                        ':Mid' => "",
                        ':country_id' => $country_id,
                        ':user_id' => $this->id,
                        ':recipe_id' => $recipe_id,
                    )))
                    {
                       
                       echo json_encode($this->getTastyEN($recipe_id, $country_id));
                    }
                    
                }
                else{
                        echo json_encode(false);
                    }
    }
    
    function insertShareEN($recipe_id, $country_id)
    {
         $sql = "SELECT * FROM recipe_share WHERE country_id = :C_id AND user_id = :U_id AND recipe_id = :R_id";
         $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':C_id' => $country_id,
            ':U_id' => $this->id,
            ':R_id' => $recipe_id,
        ));
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        //check if the user have cookit before
                if(count($data) === 0)
                {
                    $sql = "INSERT INTO recipe_share (recipe_share_id,  recipe_id, user_id, country_id) VALUES (:Mid,  :recipe_id,  :user_id, :country_id)";
                    $sth = $this->db->Sdb->prepare($sql);
                    //check if it inserted
                    if($sth->execute(array(
                        ':Mid' => "",
                        ':country_id' => $country_id,
                        ':user_id' => $this->id,
                        ':recipe_id' => $recipe_id,
                    )))
                    {
                       echo json_encode($this->getShareEN($recipe_id, $country_id));
                       
                    }
                    else{
                        echo json_encode(false);
                    }
                }
                else{
                        echo json_encode(false);
                    }
    }
    //meal page

   
 
       
   
   function postUserRecook($recipe_id, $Rcook, $email, $food_id, $time)
   {
        $sql = "INSERT INTO recipes_recook (recook, recipe_id, food_id, time, user_id)VALUES(:recook, :recipeId, :foodId, :time, :userId)";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        if($sth->execute(array(
            ':recook' => $Rcook,
            ':recipeId' => $recipe_id,
            ':foodId' => $food_id,
            ':userId' => $this->getUserID($email),
            ':time' => $time
        )))
        {
            echo json_encode(true);
        }
        else{
             echo json_encode($sth->errorInfo());
        }
   }
   
   
   function userTryItCounter($recipe_recook_id, $userEmail)
   {
      $sql = "SELECT * FROM recipe_reccook_tryitusercount WHERE recipe_recook_id = :r_r_i AND user_id = :userId";
      $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':r_r_i' => $recipe_recook_id,
           ':userId' => $this->getUserID($userEmail)
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       if(count($data) == 0)
       {
            $sql = "INSERT INTO recipe_reccook_tryitusercount(user_id, recipe_recook_id) VALUES(:userId, :rri)";
            $sth = $this->db->Sdb->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
                if($sth->execute(array(
                    ':rri' => $recipe_recook_id,
                    ':userId' => $this->getUserID($userEmail)
                ))){
                            //get data after inserting
                    $sql = "SELECT * FROM recipe_reccook_tryitusercount WHERE recipe_recook_id = :r_r_i";
                        $sth = $this->db->Sdb->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_r_i' => $recipe_recook_id
                         ));

                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         
                         echo json_encode(count($data));
                }
                else{
                 echo json_encode($sth->errorInfo());
                }
       }
       else
       {
           $sql = "SELECT * FROM recipe_reccook_tryitusercount WHERE recipe_recook_id = :r_r_i";
                        $sth = $this->db->Sdb->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_r_i' => $recipe_recook_id
                         ));

           
                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         $count = count($data);
                         
                 echo json_encode($count);
       }
      
      
   }
   
   function postRecookCounter($counted)
   {
       $sql = "UPDATE recipes_recook SET tryItCount = :counted";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       if($sth->execute(array(
           ':counted' => $counted
       ))){
            echo json_encode(true);
       }
       else{
            echo json_encode($sth->errorInfo());
       }
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
   
function infinitScrollENRecipeLoader($foodName, $countryName, $pages)
{
     $sql = "SELECT recipes.recipe_id, recipes.recipe_title, cook, ingridients, health_benefits, recipe_photo,
                 meal_type, recipes.country_id, recipes.food_id, FR.food_name, FR.country_names, F.food_picture, 
                 C.flag_picture FROM `recipes`
                 INNER JOIN foods_recipes AS FR ON recipes.recipe_id = FR.recipe_id 
                 INNER JOIN food AS F ON recipes.food_id = F.food_id 
                 INNER JOIN country AS C ON recipes.country_id = C.country_id 
                 WHERE FR.country_names =  :country
                 AND FR.food_name =  :food
                 LIMIT $pages , 6" ;
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
                            ':food' => $foodName,
                            ':country' => $countryName
                        ));
        $recipes  = $sth->fetchAll(PDO::FETCH_ASSOC);
       
            $shareCounts = $this->getShares($recipes, $countryName);
            $tastyCounts = $this->getTasties($recipes, $countryName);
            $cookitCounts = $this->getcookits($recipes, $countryName);
            $cookBox = $this->getUserCookBoxInfo($recipes);
            $comments = $this->getUserRecookComment($recipes);
            
           echo json_encode($this->infinitScrollENRecipeLoaderLoader($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox, $pages));
        
}

 private function infinitScrollENRecipeLoaderLoader($recipes, $shareCounts, $tastyCounts,  $cookitCounts, $comments, $cookBox, $pages)
   {
        $output = '';
        $recipe_post_tasty = "1";
        $recipe_post_share = '2';
                for($looper = 0; $looper < count($recipes); $looper++){
             $output .= '  
                             <script type="text/javascript">
                              inifityScroltooltip(\''.$pages.'\')
                            </script>
                            <div class="post_profile_photo"><img src="'.URL.'pictures/favicon3.png" width="100" height="100"></div>
                            <div class="feed_1">
                                    <div class="post_text">
                                            <ul >
                                                <li class="RecpPhoto">
                                                    '. $this->view->checkPWIPictures($recipes[$looper]['recipe_id'], $recipes[$looper]['recipe_photo']).' 
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
    
   
   
 //meal methods ends here ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

}
