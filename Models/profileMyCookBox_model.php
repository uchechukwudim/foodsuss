<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profileMyCookBox_model
 *
 * @author Uche
 */
class profileMyCookBox_model extends Model {
    //put your code here
    function __construct() {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->email = $_SESSION['user'];
       
       
    }
    
    public function myCookBox($userId=''){
        if($userId){
            $userId;
            $this->getCookBox($userId);
        }else{
            $this->getCookBox();
        }
    }
    
     private function getCookBox($user_id =''){
         $u_id = '';
    if($user_id){$u_id = $user_id;}else{$u_id = $this->id;}
        $cookBox = array();
        $URecpPost = 'USERRECIPEPOST';
        $ERecpPost = 'ENRIRECIPEPOST';
        $userComments = '';
                
        $foodCountry = '';

        $tastyCount = '';
        $shareCount = '';
        $cootItCount = '';
        
        
        $sql = "SELECT recipe_post_id, recipe_table FROM user_cook_box WHERE user_id = :user_id LIMIT 0, 6" ;
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":user_id"=> (int)$u_id));
        $cB = $sth->fetchAll();
        
        for($looper = 0; $looper < count($cB); $looper++){
            if($cB[$looper]['recipe_table'] === $URecpPost){
            
                $cookBox[$looper] = $this->getFromUserRecipePost($cB[$looper]['recipe_post_id']);
                $cookBox[$looper]['recipe_table'] = $URecpPost;
                $userComments[$looper] = $this->getrecipePostUserCommentsData($cB[$looper]['recipe_post_id'], $looper);
                
                $foodCountry[$looper] = $this->getRecipePostFoodCountry( $cookBox[$looper][0]['food_id'],$cookBox[$looper][0]['country_id'], $looper);

                $tastyCount[$looper] = $this->getTastyCount($cB[$looper]['recipe_post_id'], $looper);
                $shareCount[$looper] = $this->getShareCount($cB[$looper]['recipe_post_id'], $looper);
                $cootItCount[$looper] = $this->getCookitCount($cB[$looper]['recipe_post_id'], $looper);
               
            }
            
            if($cB[$looper]['recipe_table'] === $ERecpPost){
                 $cookBox[$looper] = $this->getFromEnriRecipePost($cB[$looper]['recipe_post_id']);
                 $cookBox[$looper]['recipe_table'] = $ERecpPost;
                $shareCount[$looper] = $this->getShareEN($cB[$looper]['recipe_post_id']);
                $tastyCount[$looper] = $this->getTastyEN($cB[$looper]['recipe_post_id']);
                $cootItCount[$looper]= $this->getCookedItEN($cB[$looper]['recipe_post_id']);
                $userComments[$looper] = $this->getUserRecookComment($cB[$looper]['recipe_post_id'], $looper);
            }
        }
        //echo var_dump( $cookBox);
       // echo var_dump($tastyCount);
       
       $this->loadMyCookBook($cookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount);
        
    }
    private function getFromUserRecipePost($recipe_post_id){
        $URecpPost = 'USERRECIPEPOST';
  
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, RP.recipe_pwi_active,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipe_post AS RP
                  INNER JOIN food AS F ON RP.food_id = F.food_id
                  INNER JOIN country AS C ON RP.country_id = C.country_id
                  WHERE  RP.recipe_post_id = :recipe_post_id ORDER BY RP.post_time DESC
                  ";
        
                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':recipe_post_id' => $recipe_post_id
                    ));
                    $myCookBox = $sth->fetchAll();
                    $myCookBox[0]['recipe_table'] =  $URecpPost;
                    $res = $this->checkPostWithPicture($recipe_post_id, $myCookBox[0]['recipe_pwi_active']);
                    if(count($res) !== ZERO){
                           $myCookBox[0]['recipe_dir_image'] = $res[ZERO]['recipe_image'];
                            $myCookBox[0]['recipe_image_dir'] = $res[ZERO]['recipe_image_direction'];
                    }else{
                           $myCookBox[0]['recipe_dir_image'] = 'NONE';
                           $myCookBox[0]['recipe_image_dir'] = '';
                    }
                 
                    
              return $myCookBox;
    }
    
    private function getFromEnriRecipePost($recipe_post_id){
        $ERecpPost = 'ENRIRECIPEPOST';
        $sql = "SELECT R.recipe_id, R.recipe_title, R.recipe_photo, R.cook, R.health_benefits, R.ingridients, R.food_id, R.country_id, R.meal_type,
                  F.food_name, F.food_picture, C.country_names, C.flag_picture
                  FROM recipes AS R
                  INNER JOIN food AS F ON R.food_id = F.food_id
                  INNER JOIN country AS C ON R.country_id = C.country_id
                  WHERE R.recipe_id = :recipe_id
                  ";
        
                    $sth = $this->db->Sdb->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':recipe_id' => $recipe_post_id
                    ));

                    $myCookBox = $sth->fetchAll();
                    $myCookBox[0]['recipe_table'] = $ERecpPost;
                    
                    
             return $myCookBox;
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
    
       function getUserRecookComment($recipe_id, $loop)
       {
            $details = array();
            $recookComments = array();
          
                 $sql = "SELECT recipe_recook_id, recook, user_id, time FROM recipes_recook WHERE recipe_id = :recipeId ORDER by time ASC";
                 $sth = $this->db->Sdb->prepare($sql);
                 $sth->setFetchMode(PDO::FETCH_ASSOC);
                 $sth->execute(array(
                     ':recipeId' => $recipe_id
                 ));

                 $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                 $detail = $this->getENDetails($data, $details);
                 $recookComments[$loop] = $detail;
            


           return $recookComments;
      }
   
    
    
    
    
    
    
    private function loadMyCookBook($myCookBox,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount )
    {
        $output='                
        <div id="myCookBookHolder">
            '.$this->loadFeeds($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount).'             
        </div>';
        
        echo json_encode($output);
    }
    
    private function loadFeeds($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount)
    {
            $URecpPost = 'USERRECIPEPOST';
         $ERecpPost = 'ENRIRECIPEPOST';
        $output = '<script type="text/javascript">
                             hideReciepieImageDialogOnLoad();
                                closeImageReciepieDialog();
                                showUserReccokComments();
                                reciepeUserCommentfocusInFocusout();
          
             </script>';
        for($looper=0; $looper < count($myCookBox); $looper++)
        {
            if($myCookBox[$looper][0]['recipe_table'] === $URecpPost){
                $output .= $this->loadUserRecipePost($myCookBox,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper);
            }else if($myCookBox[$looper][0]['recipe_table'] === $ERecpPost){
                //load enri recipe post here
                $output .= $this->loadENRecipes($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper);
            }
            
        }
        
        return $output;
    }
    
    private function loadUserRecipePost($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper){
            $recipe_post_tasty = "recipe_post_tasty";
            $recipe_post_cookedit = "recipe_post_cookedit";
            $recipe_post_share = "recipe_post_share";
            $Food_Pic = '';
            $Food_Nm = '';
            
            if(isset($foodCountry[$looper][0]['food_picture'])){
                $Food_Pic = $foodCountry[$looper][$looper][0]['food_picture'];
                $Food_Nm = $foodCountry[$looper][$looper][0]['food_name'];
            }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
            $output = '
               <script type="text/javascript">
                  inifityScroltooltip(\''.$looper.'\');    
              </script>
	      <div class="post_profile_photo">'. $this->view->checkUserPicture($this->getUserImage($myCookBox[$looper][0]['user_id']), 100, 100).'</div>
	
             <div class="feed_1">
                 <div class="post_text">        
                    <ul >
                        <li class="RecpPhoto">
                               '.$this->view->checkPWIPictures($myCookBox[$looper][0]['recipe_post_id'], $myCookBox[$looper][0]['recipe_photo']).'
                        </li>   
                        <li class="post_flag">
                             <img src="'.$this->view->checkCountryPic($foodCountry[$looper][$looper][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$looper][$looper][0]['country_names'].'"> 
                             <img src="'.$this->view->checkFoodPic($Food_Pic).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($Food_Nm).'">
                        </li>
                        <li><span class="mealType">'.$this->view->checkMealType($myCookBox[$looper][0]['meal_type'], 25, 25).'</span></li>
                        <li class="hashTagTitle"><b>'. $myCookBox[$looper][0]['recipe_title'].'</b></li>
                        <li class="recipDesc">'. $myCookBox[$looper][0]['description'] .'</li>
                        <li class="post_profile_link"> 
                            <ul class="TYCKSHR">
                                <li class="tastyCount"  onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_tasty.'\', \''.$looper.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCount[$looper][$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCount[$looper][$looper]).'</span></li>
                                <li class="cookCount" onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_cookedit.'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootItCount[$looper][$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootItCount[$looper][$looper]).'</span></li>
                                <li class="shareCount" onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_share.'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCount[$looper][$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCount[$looper][$looper]).'</span></li>
                            </ul>
                            <ul class="recipeNav">
                              <li class="cookboxit"  onclick="putInMyCookBox(\''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$looper.'\')">'.$this->view->checkCoobBoxPic(true, 20, 20).'</li>
                              <li onclick="showShops(\''.$looper.'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\')" class="ShpCt"><img src="'. URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                           </ul>
                        </li>
                    </ul>
		</div>		
	    </div>';
            
            return $output;
    }
    
     private function getPwiInfinity($myCookBox, $looper){
        if($myCookBox[$looper][ZERO]['recipe_pwi_active'] === 'TRUE'){
            return  $this->view->checkPWIPictures($myCookBox[$looper][ZERO]['recipe_post_id'], $myCookBox[$looper][ZERO]['recipe_dir_image']);
         }else if($myCookBox[$looper][ZERO]['recipe_pwi_active'] === 'FALSE'){
             return $myCookBox[$looper][ZERO]['how_its_made'];
         }
    }
    
    private function loadENRecipes($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCounts, $shareCounts, $cootitCounts, $looper){
        
        $output = '  
                <script type="text/javascript">
                 inifityScroltooltip(\''.$looper.'\')
               </script>

               <div class="post_profile_photo"><img src="'.URL.'pictures/favicon3.png" width="100" height="100"></div>
               <div class="feed_1">
                       <div class="post_text">
                               <ul >
                                   <li class="RecpPhoto">
                                          '.$this->view->checkPWIPictures($myCookBox[$looper][0]['recipe_id'], $myCookBox[$looper][0]['recipe_photo']).'
                                   </li>
                                   <li class="post_flag">
                                       <img class="homeCountry" src="data:image/jpeg;base64,'.base64_encode( $myCookBox[$looper][0]['flag_picture']).'" width="20" height="20" title="'. $myCookBox[$looper][0]['country_names'].'"> 
                                       <img class="homeFood" src="data:image/jpeg;base64,'.base64_encode( $myCookBox[$looper][0]['food_picture']).'" width="20" height="20" title="'.$myCookBox[$looper][0]['food_name'].'">
                                   </li>
                                   <li><span class="mealType">'.$this->view->checkMealType($myCookBox[$looper][0]['meal_type'], 25, 25).'</span></li>
                                   <li class="hashTagTitle"><b>'.$myCookBox[$looper][0]['recipe_title'].'</b></li>
                                   <li class="recipDesc">'.$myCookBox[$looper][0]['cook'].'</li>
                                   <li class="post_profile_link"> 
                                        <ul class="TYCKSHR">
                                            <li class="tastyCount"  onclick="insertTastyEN(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCounts[$looper]).'</span></li>
                                            <li class="cookCount" onclick="CookIt(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootitCounts[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootitCounts[$looper]).'</span></li>
                                            <li class="shareCount" onclick="insertShareEN(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCounts[$looper]).'</span></li>
                                        </ul>
                                        <ul class="recipeNav">
                                            <li class="cookboxit" onclick="putInMyCookBox(\''.$myCookBox[$looper][0]['recipe_id'].'\', \''.$looper.'\')">'.$this->view->checkCoobBoxPic(true, 20, 20).'</li>
                                            <li onclick="showShops(\''.$looper.'\', \''.$myCookBox[$looper][0]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                        </ul>
                                   </li>
                              </ul>
                      </div>
           </div>';

         
         return $output;
     }
    
    
    private function getrecipePostUserCommentsData($recipe_post_id, $loop)
     {
      $userComments = array();
      $index = "INDEX";
        
            $userComments[$loop] = $this->getUserComment($recipe_post_id, $index);
    
        return  $userComments;
     }
    
      function getUserComment($recipe_post_id, $which)
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
    
      private function getRecipePostFoodCountry($food_id, $country_id, $loop)
      {
          $foodCountry = array();
            
                
                $foodCountry[$loop] = $this->getCountryFoodName($food_id, $country_id);
            
        
            return $foodCountry;
     }
    
    function getCountryFoodName($foodId, $countryId)
    {
        $sql = "SELECT food_name, food_picture, flag_picture, country_names FROM food, country WHERE country.country_id= :country_id AND food.food_id = :food_id";
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMOde(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":country_id" => $countryId,
            ":food_id" => $foodId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
       private function getTastyCount($recipe_post_id, $loop)
       {
              $tastyCount =array();
        
             $tastyCount[$loop] = $this->getTasty($recipe_post_id);
       
         
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
    
     private function getShareCount($recipe_post_id, $loop)
    {
        $shareCount =array();
        
             $shareCount[$loop] = $this->getshare($recipe_post_id);
         
         
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
    
     private function getCookitCount($recipe_post_id, $loop)
     {
        $cookitCount =array();
        
        $cookitCount[$loop] = $this->getCookedit($recipe_post_id, $loop);

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
    
        
    private function getuserCommentCountSuffix($num)
    {
     $message = '';
        if($num >=2)
           $message = $num." comments";
        else if($num == 1)
          $message = $num." comment";
         else 
           $message = "No comment";
        
        return $message;
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
    
       private function InfinityRecipePostCommentsLoader($userComments){
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
    
     private function getENDetails($data, $details)
     {
       for($i =0; $i < count($data); $i++)
       {
           $details[$i]['user_id'] = $data[$i]['user_id'];
           $details[$i]['userName'] = $this->getUserFLNameOrRestNameOrEstName($data[$i]['user_id']);
           $details[$i]['image'] = $this->getUserImage($data[$i]['user_id']);
           $details[$i]['time'] = $data[$i]['time'];
           $details[$i]['comments'] = $data[$i]['recook'];
           $details[$i]['recipe_recook_id'] = $data[$i]['recipe_recook_id'];
           $details[$i]['try_it'] = $this->getuserTryit($data[$i]['recipe_recook_id']);
       }
       
       return $details;
    }
    
     private function getENuserTryit($recipe_recook_id)
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
    
    
    
    
    
    
    
    
    
    
    
    public function infinitScrollMycookBox($pages, $userId){
            $u_id = '';
    if($userId){$u_id = $userId;}else{$u_id = $this->id;}
        $cookBox = array();
        $URecpPost = 'USERRECIPEPOST';
        $ERecpPost = 'ENRIRECIPEPOST';
        $userComments = '';
                
        $foodCountry = '';

        $tastyCount = '';
        $shareCount = '';
        $cootItCount = '';
        
        
        $sql = "SELECT recipe_post_id, recipe_table FROM user_cook_box WHERE user_id = :user_id LIMIT $pages, 6" ;
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":user_id"=> (int)$u_id));
        $cB = $sth->fetchAll();
        
        for($looper = 0; $looper < count($cB); $looper++){
            if($cB[$looper]['recipe_table'] === $URecpPost){
            
                $cookBox[$looper] = $this->getFromUserRecipePost($cB[$looper]['recipe_post_id']);
                 $cookBox[$looper]['recipe_table'] = $URecpPost;
                $userComments[$looper] = $this->getrecipePostUserCommentsData($cB[$looper]['recipe_post_id'], $looper);
                
                $foodCountry[$looper] = $this->getRecipePostFoodCountry( $cookBox[$looper][0]['food_id'],$cookBox[$looper][0]['country_id'], $looper);

                $tastyCount[$looper] = $this->getTastyCount($cB[$looper]['recipe_post_id'], $looper);
                $shareCount[$looper] = $this->getShareCount($cB[$looper]['recipe_post_id'], $looper);
                $cootItCount[$looper] = $this->getCookitCount($cB[$looper]['recipe_post_id'], $looper);
               
            }
            
            if($cB[$looper]['recipe_table'] === $ERecpPost){
                 $cookBox[$looper] = $this->getFromEnriRecipePost($cB[$looper]['recipe_post_id']);
                 $cookBox[$looper]['recipe_table'] = $ERecpPost;
                $shareCount[$looper] = $this->getShareEN($cB[$looper]['recipe_post_id']);
                $tastyCount[$looper] = $this->getTastyEN($cB[$looper]['recipe_post_id']);
                $cootItCount[$looper]= $this->getCookedItEN($cB[$looper]['recipe_post_id']);
                $userComments[$looper] = $this->getUserRecookComment($cB[$looper]['recipe_post_id'], $looper);
            }
        }
        
       echo json_encode( $this->infinityLoadFeeds($cookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $pages));
    }
    
    
     private function infinityLoadFeeds($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $pages)
    {
            $URecpPost = 'USERRECIPEPOST';
         $ERecpPost = 'ENRIRECIPEPOST';
        $output = '<script type="text/javascript">
                             hideReciepieImageDialogOnLoad();
                                closeImageReciepieDialog();
                  </script>';
        for($looper=0; $looper < count($myCookBox); $looper++)
        {
            if($myCookBox[$looper][0]['recipe_table'] === $URecpPost){
                $output .= $this->infinityLoadUserRecipePost($myCookBox,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper, $pages);
            }else if($myCookBox[$looper][0]['recipe_table'] === $ERecpPost){
                //load enri recipe post here
                $output .= $this->infinityLoadENRecipes($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper, $pages);
            }
            $pages++;
        }
        
        return $output;
    }
    
    private function infinityLoadUserRecipePost($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $looper, $pages){
        $recipe_post_tasty = "recipe_post_tasty";
            $recipe_post_cookedit = "recipe_post_cookedit";
            $recipe_post_share = "recipe_post_share";
            $Food_Pic = '';
            $Food_Nm = '';
              if(isset($foodCountry[$looper][$looper][0]['food_picture'])){
                $Food_Pic = $foodCountry[$looper][$looper][0]['food_picture'];
                $Food_Nm = $foodCountry[$looper][$looper][0]['food_name'];
            }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
            $output = '
                <script type="text/javascript"> 
                     inifityScroltooltip(\''.$pages.'\');    
                </script>
               <div class="post_profile_photo">'. $this->view->checkUserPicture($this->getUserImage($myCookBox[$looper][0]['user_id']), 100, 100).'</div>
	
             <div class="feed_1">
                 <div class="post_text">        
                    <ul >
                        <li class="RecpPhoto">
                               '.$this->view->checkPWIPictures($myCookBox[$looper][0]['recipe_post_id'], $myCookBox[$looper][0]['recipe_photo']).'
                        </li>   
                        <li class="post_flag">
                             <img src="'.$this->view->checkCountryPic($foodCountry[$looper][$looper][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$looper][$looper][0]['country_names'].'"> 
                             <img src="'.$this->view->checkFoodPic($Food_Pic).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($Food_Nm).'">
                        </li>
                        <li><span class="mealType">'.$this->view->checkMealType($myCookBox[$looper][0]['meal_type'], 25, 25).'</span></li>
                        <li class="hashTagTitle"><b>'. $myCookBox[$looper][0]['recipe_title'].'</b></li>
                        <li class="recipDesc">'. $myCookBox[$looper][0]['description'] .'</li>
                        <li class="post_profile_link"> 
                            <ul class="TYCKSHR">
                                <li class="tastyCount"  onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_tasty.'\', \''.$looper.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCount[$looper][$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCount[$looper][$looper]).'</span></li>
                                <li class="cookCount" onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_cookedit.'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootItCount[$looper][$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootItCount[$looper][$looper]).'</span></li>
                                <li class="shareCount" onclick="insertTCS(\''.$this->id .'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$recipe_post_share.'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCount[$looper][$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCount[$looper][$looper]).'</span></li>
                            </ul>
                            <ul class="recipeNav">
                              <li class="cookboxit"  onclick="putInMyCookBox(\''.$myCookBox[$looper][0]['recipe_post_id'].'\', \''.$myCookBox[$looper][0]['user_id'].'\', \''.$looper.'\')">'.$this->view->checkCoobBoxPic(true, 20, 20).'</li>
                              <li onclick="showShops(\''.$looper.'\', \''.$myCookBox[$looper][0]['recipe_post_id'].'\')" class="ShpCt"><img src="'. URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                           </ul>
                        </li>
                    </ul>
		</div>		
	    </div>';
            
            return $output;
    }
    
    private function infinityLoadENRecipes($myCookBox, $foodCountry, $userComments, $foodCountry, $tastyCounts, $shareCounts, $cootitCounts, $looper, $pages){
        
    $output = '  
               <script type="text/javascript">
                   inifityScroltooltip(\''.$pages.'\')
               </script>
               <div class="post_profile_photo"><img src="'.URL.'pictures/favicon3.png" width="100" height="100"></div>
               <div class="feed_1">
                       <div class="post_text">
                               <ul >
                                   <li class="RecpPhoto">
                                          '.$this->view->checkPWIPictures($myCookBox[$looper][0]['recipe_id'], $myCookBox[$looper][0]['recipe_photo']).'
                                   </li>
                                   <li class="post_flag">
                                       <img class="homeCountry" src="data:image/jpeg;base64,'.base64_encode( $myCookBox[$looper][0]['flag_picture']).'" width="20" height="20" title="'. $myCookBox[$looper][0]['country_names'].'"> 
                                       <img class="homeFood" src="data:image/jpeg;base64,'.base64_encode( $myCookBox[$looper][0]['food_picture']).'" width="20" height="20" title="'.$myCookBox[$looper][0]['food_name'].'">
                                   </li>
                                   <li><span class="mealType">'.$this->view->checkMealType($myCookBox[$looper][0]['meal_type'], 25, 25).'</span></li>
                                   <li class="hashTagTitle"><b>'.$myCookBox[$looper][0]['recipe_title'].'</b></li>
                                   <li class="recipDesc">'.$myCookBox[$looper][0]['cook'].'</li>
                                   <li class="post_profile_link"> 
                                        <ul class="TYCKSHR">
                                            <li class="tastyCount"  onclick="insertTastyEN(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCounts[$looper]).'</span></li>
                                            <li class="cookCount" onclick="CookIt(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootitCounts[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootitCounts[$looper]).'</span></li>
                                            <li class="shareCount" onclick="insertShareEN(\''.$myCookBox[$looper][0]["recipe_id"].'\', \''.$myCookBox[$looper][0]["country_id"].'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCounts[$looper]).'</span></li>
                                        </ul>
                                        <ul class="recipeNav">
                                            <li class="cookboxit" onclick="putInMyCookBox(\''.$myCookBox[$looper][0]['recipe_id'].'\', \''.$looper.'\')">'.$this->view->checkCoobBoxPic(true, 20, 20).'</li>
                                            <li onclick="showShops(\''.$looper.'\', \''.$myCookBox[$looper][0]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="25" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                        </ul>
                                   </li>
                              </ul>
                      </div>
           </div>';
            
         
         return $output;
     }
    
    
    
}
