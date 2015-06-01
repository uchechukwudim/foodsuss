<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foodFinderRecipePost_model
 *
 * @author Uche
 */
class foodFinderRecipePost_model extends Model {
   
    function __construct()
    {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
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
    
    
    private function getrecipePostUserCommentsData($data)
    {
      $userComments = array();
      $index = "INDEX";
         for($loop = 0; $loop < count($data); $loop++)
         {
           $recipe_title = $data[$loop]['recipe_title'];
            $userComments[$loop] = $this->getUserComment($recipe_title, $index);
         }
        
        return  $userComments;
    }
    
    function getUserComment($rTitle, $which)
    {
        $details = array();
       $sql = "SELECT recipe_post_comments_id, comments, user_id, time FROM recipe_post_comments WHERE recipe_post_id = :recipe_post_id ORDER by time ASC";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':recipe_post_id' => $this->getRecipePostId($rTitle)
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
    
     private function loadUserRecook($data)
    {
        $output = '';
        for($i=0; $i < count($data); $i++)
        {
            $output .= '<div class="commentsHolderHome">    
                                        <div class="userPic">
                                            <img src="data:image/jpeg;base64,'.base64_encode($data[$i]['image']).'" width="80" height="70">
                                        </div>
                                        <div class="postTime">'.  $this->timeCounter($data[$i]['time']).'</div>
                                        <div class="userName"><a href="'.URL.'profile/user/'.$this->encrypt($data[$i]['user_id']).'">'.$data[$i]['userName'].'</a></div>

                                        <div class="userDesc">'.$data[$i]['comments'].'</div>
                                        
                                        <div class="userCookit"><a src="" onclick="countUsertryIt(\''.$data[$i]['comments'].'\','.$data[$i]['recipe_post_comments_id'].')"><img src="http://localhost/pictures/home/cookedit.png" width="15" height="15"></a></div>
                                        <div class="cookeditview">'.$data[$i]['triedIt'].'</div>
                         </div>';
        }
        return $output;    
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
    
    
     function getRecipeAccordingToUserType($userType, $countryMeal, $foodMeal)
    {
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.how_its_made, RP.health_facts, RP.ingredients, RP.user_id, RP.meal_type, RP.food_id, RP.country_id, U.user_type, USR.FirstName, USR.LastName, USR.picture
                FROM recipe_post AS RP
                INNER JOIN  user_details  AS U ON RP.user_id = U.user_id
                AND U.user_type =  :userType
                AND RP.food_id =  :food_id
                AND RP.country_id =  :country_id
                INNER JOIN user_details AS USR ON RP.user_id = USR.user_id
                ORDER BY post_time ASC LIMIT 0 , 6";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":userType" => "$userType",
            ":food_id" => (int)$this->getFoodId($foodMeal),
            ":country_id" => (int)$this->getCountryID($countryMeal)
        ));
        
        $data = $sth->fetchAll();
        if(count($data) == 0)
        {
            //error message
          
              echo json_encode(false);
            
        }
        else
        {
            $userComments = $this->getrecipePostUserCommentsData($data);
            $foodCountry = $this->getRecipePostFoodCountry($data);
        
            $tastyCount = $this->getTastyCount($data);
            $shareCount = $this->getShareCount($data);
            $cootItCount = $this->getCookitCount($data);
             $newData = $this->pushCookBoxValToData($data);
            $this->loadRecipePost($newData,  $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount);
        }
      
    }
    
     public function getAllRecipeAccordingToUserType($userType, $food){
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.meal_type, RP.food_id, RP.country_id, U.user_type, USR.FirstName, USR.LastName, USR.picture
                FROM recipe_post AS RP
                INNER JOIN  user_details  AS U ON RP.user_id = U.user_id
                AND U.user_type =  :userType
                AND RP.food_id =  :food_id
                INNER JOIN user_details AS USR ON RP.user_id = USR.user_id
                ORDER BY post_time ASC LIMIT 0 , 6";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":userType" => "$userType",
            ":food_id" => (int)$this->getFoodId($food)
        ));
        
        $data = $sth->fetchAll();
        if(count($data) == 0)
        {
            //error message
          
              echo json_encode(false);
            
        }
        else
        {
            $userComments = $this->getrecipePostUserCommentsData($data);
            $foodCountry = $this->getRecipePostFoodCountry($data);
        
            $tastyCount = $this->getTastyCount($data);
            $shareCount = $this->getShareCount($data);
            $cootItCount = $this->getCookitCount($data);
             $newData = $this->pushCookBoxValToData($data);
            $this->loadRecipePost($newData,  $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount);
        }
      
    }
     private function pushCookBoxValToData($data){
        for($looper = 0; $looper < count($data); $looper++){
         
           $data[$looper]['cookbook'] = $this->isRecipeInCookBox($data[$looper]['recipe_post_id']);
       
        }
        
        return $data;
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
    
    private function loadRecipePost($data,  $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount)
    {
        $output = '';
        $recipe_post_tasty = "recipe_post_tasty";
        $recipe_post_cookedit = 'recipe_post_cookedit';
        $recipe_post_share = 'recipe_post_share';
        
         $person_said_tasty = ' person said this is tasty';
        $people_said_tasty = ' people said this is tasty';
        
        $person_said_cooked = " person cooked this";
        $people_said_cooked = " people cooked this";
        
        $person_said_share = " person shared this";
        $people_said_share = " people shared this";
        
        for($i=0; $i < count($data); $i++)
        {
          $user_name = $data[$i]['FirstName'].' '.$data[$i]['LastName'];
        $output .=  '  
               <script type="text/javascript">
                  inifityScroltooltip(\''.$i.'\')
               </script>
              <div class="post_profile_photo">'. $this->view->checkUsersPicture($data[$i]['picture'], $data[$i]['user_id'], $user_name, 100, 100).'</div>

                    <div class="feed_1">
                            <div class="post_text">

                                <ul>
                                       <li class="RecpPhoto"> 
                                            '.$this->view->checkPWIPictures($data[$i]['recipe_post_id'], $data[$i]['recipe_photo']).'
                                       </li>
                                       <li class="post_flag">
                                                    <img class="homeCountry" src="'.$this->view->checkCountryPic($foodCountry[$i][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$i][0]['country_names'].'"> 
                                                    <img class="homeFood" src="'.$this->view->checkFoodPic($foodCountry[$i][0]['food_picture']).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($foodCountry[$i][0]['food_name']).'">
                                       </li>
                                       <li> <span class="mealType">'. $this->view->checkMealType($data[$i]['meal_type'], 25, 25).'</span></li>
                                       <li class="hashTagTitle"><b>'.$data[$i]['recipe_title'].'</b></li>
                                       <li class="recipDesc">'.$data[$i]['description'].'</li>
                                       <li class="post_profile_link">
                                           <ul class="TYCKSHR">
                                               <li class="tastyCount"  onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_tasty.'\', \''. $i.'\')"  style=""><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->view->SCTSurfix($tastyCount[$i], $people_said_tasty, $person_said_tasty).'">'.$this->view->post_statsSurfix($tastyCount[$i]).'</span></li>
                                               <li class="cookCount" onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_cookedit.'\', \''.$i.'\')" ><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->view->SCTSurfix($cootItCount[$i], $people_said_cooked , $person_said_cooked).'">'.$this->view->post_statsSurfix($cootItCount[$i]).'</span></li>
                                               <li class="shareCount" onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_share.'\', \''. $i.'\')"> <img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'.$this->view->SCTSurfix($shareCount[$i],$people_said_share, $person_said_share).'">'.$this->view->post_statsSurfix($shareCount[$i]).'</span></li>
                                           </ul>
                                           <ul class="recipeNav">
                                                <li class="cookboxit" onclick="putInMyCookBox(\''.$data[$i]['recipe_post_id'].'\', \''.$data[$i]['user_id'].'\', \''.$i.'\')">'.$this->view->checkCoobBoxPic($data[$i]['cookbook'], 20, 20).'</li>
                                                <li onclick="showShops(\''.$i.'\',\''.$data[$i]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                           </ul>
                                       </li>
                                </ul>
                            </div>
                    </div>';
        }
        
        echo json_encode($output);
    }
     private function loadUserComment($userComments){
        $output = '';
        for($looper = 3; $looper < count($userComments); $looper++){
            
            $output .='<div class="user_photo"><img src="data:image/jpeg;base64,'.base64_encode($userComments[$looper]["image"]).'" width="35"></div>
                        <div class="user_name"><b><a href="'.URL.' profile/user/'.$this->encrypt($userComments[$looper]["user_id"]).'">'.$userComments[$looper]['userName'] .'</a></b></div> <div class="postTime">'.$this->timeCounter($userComments[$looper]["time"]).'</div>
                        <div class="user_comment">
                         '.$userComments[$looper]["comments"].'
                        </div>';
        }
        return $output;
    }
    
    private function getSharedRecipeId($data, $i)
    {
      
        if(isset($data[$i]['recipe_owner_names']))
        { 
            return $data[$i]['sharer_user_id']; 
        }
        else
         {
            return $data[$i]['user_id'];

         }
                    
    }
    
    
    
    function infinitScrollAllHomeENRecipeLoader($userType, $foodName, $countryName, $page)
    {
        $sql = "";
        $data = '';
        if($countryName){
            $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.meal_type, RP.food_id, RP.country_id, U.user_type, USR.FirstName, USR.LastName, USR.picture
                    FROM recipe_post AS RP
                    INNER JOIN users AS U ON RP.user_id = U.user_id
                    AND U.user_type =  :userType
                    AND RP.food_id =  :food_id
                    AND RP.country_id =  :country_id
                    INNER JOIN user_details AS USR ON RP.user_id = USR.user_id
                    LIMIT $page , 6";
                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ":userType" => $userType,
                        ":food_id" => $this->getFoodId($foodName),
                        ":country_id"=> $countryName
                    ));

                    $data = $sth->fetchAll();
        }else{
            
            $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.meal_type, RP.food_id, RP.country_id, U.user_type, USR.FirstName, USR.LastName, USR.picture
                    FROM recipe_post AS RP
                    INNER JOIN users AS U ON RP.user_id = U.user_id
                    AND U.user_type =  :userType
                    AND RP.food_id =  :food_id
                    INNER JOIN user_details AS USR ON RP.user_id = USR.user_id
                    LIMIT $page , 6";
                     $sth = $this->db->prepare($sql);
                     $sth->setFetchMode(PDO::FETCH_ASSOC);
                     $sth->execute(array(
                        ":userType" => $userType,
                        ":food_id" => $this->getFoodId($foodName)
                     ));

                     $data = $sth->fetchAll();
        }
        
       
        
            $userComments = $this->getrecipePostUserCommentsData($data);
            $foodCountry = $this->getRecipePostFoodCountry($data);
        
            $tastyCount = $this->getTastyCount($data);
            $shareCount = $this->getShareCount($data);
            $cootItCount = $this->getCookitCount($data);
            $newData = $this->pushCookBoxValToData($data);
            $this->loadinfinitScrollHomeRecipeLoader($newData,  $userComments, $foodCountry, $tastyCount,  $shareCount, $cootItCount, $page);
        
      
    }
    
     private function loadinfinitScrollHomeRecipeLoader($data,  $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $page)
     {
        $output = '';
        $recipe_post_tasty = "recipe_post_tasty";
        $recipe_post_cookedit = 'recipe_post_cookedit';
        $recipe_post_share = 'recipe_post_share';
        
        
         $person_said_tasty = ' person said this is tasty';
        $people_said_tasty = ' people said this is tasty';
        
        $person_said_cooked = " person cooked this";
        $people_said_cooked = " people cooked this";
        
        $person_said_share = " person shared this";
        $people_said_share = " people shared this";
        for($i=0; $i < count($data); $i++)
        {

            $output .= '
                   <script type="text/javascript">
                                reciepeENUserCommentfocusInFocusout();   
                                setFeed_1(\''.$page.'\');
                                inifityScroltooltip(\''.$page.'\')

                 </script>
                             <div class="post_profile_photo">'. $this->view->checkUsersPicture($data[$i]['picture'], $RID, $user_name, 100, 100).'</div>

                    <div class="feed_1">
                            <div class="post_text">

                                <ul>
                                       <li class="RecpPhoto"> 
                                            '.$this->view->checkPWIPictures($data[$i]['recipe_post_id'], $data[$i]['recipe_photo']).'
                                       </li>
                                       <li class="post_flag">
                                                    <img class="homeCountry" src="'.$this->view->checkCountryPic($foodCountry[$i][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$i][0]['country_names'].'"> 
                                                    <img class="homeFood" src="'.$this->view->checkFoodPic($Food_Pic).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($Food_Nm).'">
                                       </li>
                                       <li> <span class="mealType">'. $this->view->checkMealType($data[$i]['meal_type'], 25, 25).'</span></li>
                                       <li class="hashTagTitle"><b>'.$data[$i]['recipe_title'].'</b></li>
                                       <li class="recipDesc">'.$data[$i]['description'].'</li>
                                       <li class="post_profile_link">
                                           <ul class="TYCKSHR">
                                               <li class="tastyCount"  onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_tasty.'\', \''. $pages.'\')"  style=""><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->view->SCTSurfix($tastyCount[$i], $people_said_tasty, $person_said_tasty).'">'.$this->view->post_statsSurfix($tastyCount[$i]).'</span></li>
                                               <li class="cookCount" onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_cookedit.'\', \''.$pages.'\')" ><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->view->SCTSurfix($cootItCount[$i], $people_said_cooked , $person_said_cooked).'">'.$this->view->post_statsSurfix($cootItCount[$i]).'</span></li>
                                               <li class="shareCount" onclick="insertTCS(\''.$this->id.'\', \''.$data[$i]['user_id'].'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_share.'\', \''.$pages.'\')"> <img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'.$this->view->SCTSurfix($shareCount[$i],$people_said_share, $person_said_share).'">'.$this->view->post_statsSurfix($shareCount[$i]).'</span></li>
                                           </ul>
                                           <ul class="recipeNav">
                                                <li class="cookboxit" onclick="putInMyCookBox(\''.$data[$i]['recipe_post_id'].'\', \''.$data[$i]['user_id'].'\', \''.$pages.'\')">'.$this->view->checkCoobBoxPic($data[$i]['cookbook'], 20, 20).'</li>
                                                <li onclick="showShops(\''.$pages.'\',\''.$data[$i]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                           </ul>
                                       </li>
                                </ul>
                            </div>
                    </div>';
                $page++;
        }
        
        echo json_encode($output);
    }
    
    
    
    private function getuserCommentCountSuffix($num)
    {
     $message = '';
        if($num >=2)
           $message = $num." comments";
        else if($num == 1)
          $message = $num." comment";
    
       
        
        return $message;
    }
    
    
}
