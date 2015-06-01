<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profileMyCookBook_model
 *
 * @author Uche
 */
class profileMyCookBook_model extends Model{
    //put your code here
     function __construct() {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->email = $_SESSION['user'];
       
       
    }
    
    
    public function myCookBook($userId='')
    {
        if($userId)
        {
            //get "mycookbook here
               $sql1 = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, RP.recipe_pwi_active,
                        F.food_name, F.food_picture, C.country_names, C.flag_picture
                        FROM recipe_post AS RP
                        INNER JOIN food AS F ON RP.food_id = F.food_id
                        INNER JOIN country AS C ON RP.country_id = C.country_id
                        WHERE user_id = :user_id ORDER BY RP.post_time DESC
                        LIMIT 0 , 6";
               $sth1 = $this->db->prepare($sql1);
               $sth1->setFetchMode(PDO::FETCH_ASSOC);
               $sth1->execute(array(
                   'user_id' => $userId
               ));

               $myCB = $sth1->fetchAll();
               $myCookBook = $this->pushPWIIntoData($myCB);

              $userComments = $this->getrecipePostUserCommentsData($myCookBook);
              $foodCountry = $this->getRecipePostFoodCountry($myCookBook);

             $tastyCount = $this->getTastyCount($myCookBook);
             $shareCount = $this->getShareCount($myCookBook);
             $cootItCount = $this->getCookitCount($myCookBook);

             $this->loadMyCookBook($myCookBook, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount );
        }
        else{
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

             $this->loadMyCookBook($myCookBook,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount );
        }
    }
    
     
    private function pushPWIIntoData($data){
        $none = 'NONE';
        for($looper = 0; $looper < count($data); $looper++){
           //get recipe_pwi details 
           if($this->checkPostWithPicture($data[$looper]['recipe_post_id'], $data[$looper]['recipe_pwi_active']) !== false){
                $res = $this->checkPostWithPicture($data[$looper]['recipe_post_id'], $data[$looper]['recipe_pwi_active']);
               if(count($res) !== ZERO){
                       $data[$looper]['recipe_dir_image'] = $res[ZERO]['recipe_image'];
                       $data[$looper]['recipe_image_dir'] = $res[ZERO]['recipe_image_direction'];
                  }else{
                     $data[$looper]['recipe_dir_image'] = $none;
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
    
    private function loadMyCookBook($myCookBook,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount )
    {
        $output='                
        <div id="myCookBookHolder">
            '.$this->loadFeeds($myCookBook,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount).'             
        </div>';
        
        echo json_encode($output);
    }
    
    private function loadFeeds($myCookBook,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount)
    {
        $Food_Pic = '';
        $Food_Nm = '';
        $recipe_post_tasty = "recipe_post_tasty";
        $recipe_post_cookedit = "recipe_post_cookedit";
        $recipe_post_share = "recipe_post_share";
        $output = '<script type="text/javascript">
                             hideReciepieImageDialogOnLoad();
                                closeImageReciepieDialog();
             </script>';
        for($looper=0; $looper < count($myCookBook); $looper++)
        {
            if(isset($foodCountry[$looper][0]['food_picture'])){
                $Food_Pic = $foodCountry[$looper][0]['food_picture'];
                $Food_Nm = $foodCountry[$looper][0]['food_name'];
            }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
            
            $output .= '
              <script type="text/javascript">
                    inifityScroltooltip(\''.$looper.'\'); 
             </script>
             	<div class="post_profile_photo">'. $this->view->checkUserPicture($this->getUserImage($myCookBook[$looper]['user_id']), 100, 100).'</div>
					  
             <div class="feed_1">
                          <div class="post_text">
                                <ul >
                                    <li class="RecpPhoto">
                                       '.$this->view->checkPWIPictures($myCookBook[$looper]['recipe_post_id'], $myCookBook[$looper]['recipe_photo']).'
                                    </li>
                                    <li class="post_flag">
                                         <img src="'.$this->view->checkCountryPic($foodCountry[$looper][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$looper][0]['country_names'].'"> 
                                         <img src="'.$this->view->checkFoodPic($Food_Pic).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($Food_Nm).'">
                                    </li>
                                    <li><span class="mealType">'.$this->view->checkMealType($myCookBook[$looper]['meal_type'], 25, 25).'</span></li>
                                    <li class="hashTagTitle"><b>'. $myCookBook[$looper]['recipe_title'].'</b></li>
                                    <li class="recipDesc">'. $myCookBook[$looper]['description'] .'</li>
                                    <li class="post_profile_link"> 
                                        <ul class="TYCKSHR">
                                            <li class="tastyCount"  onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_tasty.'\', \''.$looper.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCount[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCount[$looper]).'</span></li>
                                            <li class="cookCount" onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_cookedit.'\', \''.$looper.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootItCount[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootItCount[$looper]).'</span></li>
                                            <li class="shareCount" onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_share.'\', \''.$looper.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCount[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCount[$looper]).'</span></li>
                                        </ul>
                                        <ul class="recipeNav">
                                            <li onclick="showShops(\''.$looper.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\')" class="ShpCt"><img src="'. URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                        </ul>
                                    </li>
                                </ul>
			</div>		
            </div>';
        }
        
        return $output;
    }
    
      private function getPwiInfinity($myCookBook, $looper){
        if($myCookBook[$looper]['recipe_pwi_active'] === 'TRUE'){
            return $this->view->checkPWIPictures($myCookBook[$looper]['recipe_post_id'], $myCookBook[$looper]['recipe_dir_image']);
         }else if($myCookBook[$looper]['recipe_pwi_active'] === 'FALSE'){
             return $myCookBook[$looper]['how_its_made'];
         }
    }
    
    private function loadUserRecook($userComments, $recipe_post_id, $food_id, $Country_id, $divclass, $index)
    {
        $output = '';
        for($i=0; $i < count($userComments); $i++)
        {
            $output .= '<div class="commentsHolderHome">    
                                               <div class="userPic">
                                            <img src="data:image/jpeg;base64,'.base64_encode($userComments[$i]['image']).'" width="80" height="70">
                                        </div>
                                        <div class="postTime">'.  $this->timeCounter($userComments[$i]['time']).'</div>
                                        <div class="userName"><a href="'.URL.'profile/user/'.$this->encrypt($userComments[$i]['user_id']).'">'.$userComments[$i]['userName'].'</a></div>

                                        <div class="userDesc">'.$userComments[$i]['comments'].'</div>
                                        
                                        <div class="userCookit" onclick="countUsertryIt(\''.$userComments[$i]['recipe_post_comments_id'].'\',\''.$recipe_post_id.'\',\''.$food_id.'\',\''.$Country_id.'\',\''.$divclass.'\',\''.$i.'\')"><span ><img src="http://localhost/pictures/home/cookedit.png" width="15" height="15" alt=""></span></div>
                                        <div class="'.$divclass.'">'.$userComments[$i]['triedIt'].'</div>
                                         <script>setCookViewCss(\''.$divclass.'\')</script>
                          </div>';
        }
        return $output;    
    }
    
     private function getrecipePostUserCommentsData($data)
     {
      $userComments = array();
      $index = "INDEX";
         for($loop = 0; $loop < count($data); $loop++)
         {
            $recipe_post_id  = $data[$loop]['recipe_post_id'];
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
           ':recipe_post_id' =>  $recipe_post_id
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
    
    
    
    
    
    
    
    function infinitScrollMycookBook($pages, $userId)
    {
        $ID = '';
        if($userId)
        {
            $ID = $userId;
        }
        else
        {
            $ID = $this->id;
        }
         //get "mycookbook here
         $sql2 = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.meal_type, RP.user_id, RP.recipe_pwi_active,
                  F.food_name F.food_picture, C.country_names, C.flag_picture
                  FROM recipe_post AS RP
                  INNER JOIN food AS F ON RP.food_id = F.food_id
                  INNER JOIN country AS C ON RP.country_id = C.country_id
                  WHERE user_id = :user_id ORDER BY RP.post_time DESC
                  LIMIT $pages , 6";
         $sth2 = $this->db->prepare($sql2);
         $sth2->setFetchMode(PDO::FETCH_ASSOC);
         $sth2->execute(array(
             'user_id' => $ID
         ));
         
          $myCB = $sth2->fetchAll();
          $myCookBook = $this->pushPWIIntoData($myCB);
         
        $userComments = $this->getrecipePostUserCommentsData($myCookBook);
        $foodCountry = $this->getRecipePostFoodCountry($myCookBook);
          
       $tastyCount = $this->getTastyCount($myCookBook);
       $shareCount = $this->getShareCount($myCookBook);
       $cootItCount = $this->getCookitCount($myCookBook);
   
      echo json_encode($this->infinitLoadFeeds($myCookBook, $userComments, $foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $pages));
    }
    
    private function infinitLoadFeeds($myCookBook,$userComments,$foodCountry, $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $pages)
    {
        $recipe_post_tasty = "recipe_post_tasty";
        $recipe_post_cookedit = "recipe_post_cookedit";
        $recipe_post_share = "recipe_post_share";
        $Food_Pic  = '';
        $Food_Nm = '';
        
        $output = '';
        for($looper=0; $looper < count($myCookBook); $looper++)
        {
            if(isset($foodCountry[$looper][0]['food_picture'])){
                $Food_Pic = $foodCountry[$looper][0]['food_picture'];
                $Food_Nm = $foodCountry[$looper][0]['food_name'];
            }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
            $output .= '
                            <script type="text/javascript">
                              inifityScroltooltip(\''.$pages.'\')
                            </script>
                            <div class="feed_1">
                                    <div class="post_text">
                                        <ul >
                                            <li class="RecpPhoto">
                                               '.$this->checkPWIPictures($myCookBook[$looper]['recipe_post_id'], $myCookBook[$looper]['recipe_photo']).'
                                            </li>
                                            <li class="post_flag">
                                                 <img src="'.$this->view->checkCountryPic($foodCountry[$looper][0]['flag_picture']).'" width="20" height="20" title="'. $foodCountry[$looper][0]['country_names'].'"> 
                                                 <img src="'.$this->view->checkFoodPic($Food_Pic).'" width="20" height="20" title="'.$this->view->checkFoodpicTitle($Food_Nm).'">
                                            </li>
                                            <li><span class="mealType">'.$this->view->checkMealType($myCookBook[$looper]['meal_type'], 25, 25).'</span></li>
                                            <li class="hashTagTitle"><b>'. $myCookBook[$looper]['recipe_title'].'</b></li>
                                            <li class="recipDesc">'. $myCookBook[$looper]['description'] .'</li>
                                            <li class="post_profile_link"> 
                                                <ul class="TYCKSHR">
                                                    <li class="tastyCount"  onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_tasty.'\', \''. $pages.'\')" title="say this recipe is tasty"><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->SCTSurfix($tastyCount[$looper], " people said this is tasty", " person said this is tasty").'">'.$this->post_statsSurfix($tastyCount[$looper]).'</span></li>
                                                    <li class="cookCount" onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_cookedit.'\', \''. $pages.'\')" title="say you cooked this recipe"><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->SCTSurfix($cootItCount[$looper], " people cooked this" ,"person cooked this").'">'.$this->post_statsSurfix($cootItCount[$looper]).'</span></li>
                                                    <li class="shareCount" onclick="insertTCS(\''.$this->id .'\', \''.$this->id.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\', \''.$recipe_post_share.'\', \''. $pages.'\')" title="share this recipe"><img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'. $this->SCTSurfix($shareCount[$looper]," people shared this", "person shared this").'">'.$this->post_statsSurfix($shareCount[$looper]).'</span></li>
                                                </ul>
                                                <ul class="recipeNav">
                                                    <li onclick="showShops(\''.$pages.'\', \''.$myCookBook[$looper]['recipe_post_id'].'\')" class="ShpCt"><img src="'. URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>	
                            </div>';
            $pages++;
        }
        
        return $output;
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
    
 private function InfinityloadUserRecook($data, $recipe_post_id, $food_id, $Country_id, $divclass, $index)
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
                                        
                                       <div class="userCookit" onclick="countUsertryIt(\''.$data[$i]['recipe_post_comments_id'].'\',\''.$recipe_post_id.'\',\''.$food_id.'\',\''.$Country_id.'\',\''.$divclass.'\',\''.$i.'\')"><span ><img src="http://localhost/pictures/home/cookedit.png" width="15" height="15" alt=""></span></div>
                                        <div class="'.$divclass.'">'.$data[$i]['triedIt'].'</div>
                                         <script>setCookViewCss(\''.$divclass.'\')</script>
                            </div>';
        }
        return $output;    
    }
    
      function removeHashTag($title)
    {
     $output = '';
     for($i =1; $i <  strlen($title); $i++)
     {
         $char = substr($title, $i, 1);
         if($char !== "#")
         {
             $output .= $char;
         }
     }
     
     return $output;
   }
    
}
