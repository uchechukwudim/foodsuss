<?php

class View {

    function __construct() {
        $this->HEADER = 'new/header.php';
        $this->FOOTER = 'footer.php';
        $this->id = 0;
        $this->userId = '';
        $this->FirstName = '';
        $this->LastName = '';
        $this->image = '';
         $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
    }
    
    public function render($fileName, $data = '', $userComments='', $foodCountry='')
    {
        if($fileName == "index/index")
        {
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
    }
    
    public function renderFoodFinder($fileName, $userDetails, $countries, $foods, $foodFollows_FoodFollowCount, $otherCountries)
    {
        if($fileName == "index/index")
        {
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
    }
    
     public function renderFoodFinderFood($fileName, $userDetails, $foods, $country,  $foodFollows_FoodFollowCount, $country, $flag_picture, $otherCountries, $yesFood)
     {
        if($fileName == "index/index")
        {
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
     }
     
     public function renderFoodFinderRecipesbycountry($fileName, $userDetails, $country, $food, $flag_picture, $food_picture, $recipes,  $comments, $shareCounts, $tastyCounts, $cookitCounts, $cookBox)
     {
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
     }
     
     public function renderFoodFinderAllRecipes($fileName, $userDetails, $food, $recipes, $comments, $shareCounts, $tastyCounts, $cookitCounts, $userRecipeCommentCounts, $cookBox, $food){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
     }

        public function rendereEvents($fileName, $userDetails='', $events='', $eventAttendCount='', $eventInvited='', $myPublicAttendingEvent='')
        {
            if($fileName == "index/index")
            {
                require_once View.''.$fileName.'.php';
            }
            else{
                    require View.$this->HEADER;
                    require_once View.''.$fileName.'.php';

            }
        }
    
     public function renderHomePage($fileName, $data = '', $userComments='', $foodCountry='', $tastyCount='', $shareCount='', $cootItCount='', $userDetails='')
     {
        if($fileName == "index/index")
        {
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
     }
     
     public function renderRecipeStepsFromHome($fileName, $recipeName, $userDetails, $recipe, $ingredients, $nutrition, $cookedItUsers, $recipePost_steps_with_images, $tastyCount, $shareCount, $cootItCount, $userComments){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
        }else{
                //require View.$this->HEADER;
                require_once View.''.$fileName.'.php';      
        }
     }
     
      public function renderProfilePage($fileName, $userDetails = '', $friendsFollowers='', $myCookBook='', $cookBox ='', $recipeImages='', $userComments='',  $foodCountry='',   $tastyCount='', $shareCount='',   $cootItCount='', $userId='',  $status='',   $statusDetails='', $email, $recipePostCount='', $friendsCount='', $followerCount='',  $restaurantinitDetails='')
      {
        if($fileName == "index/index")
        {
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
        }
     }
     
     public function renderMakeRecipe($fileName){
        if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
        }
        else{
               // require View.$this->HEADER;
                require_once View.''.$fileName.'.php';      
        }
     }
     
     public function renderSettings($fileName, $Names, $firstName, $lastName, $user_type, $image='', $email='', $DOB='')
     {
        if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';  
        }
     }
     
     public function renderCookWith($fileName, $userDetails, $cookwith)
     {
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php'; 
        }
     }
     
     public function renderCookwithShow($fileName){
          if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
        }
        else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
        }
     }
     
     public function renderEatWith($fileName, $userDetails='', $eatWith='', $userPicCount='', $userVidCount='', $eatWithLikeCount ='',  $eatWithUserComments ='')
     {
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
         }
     }
     
     public function renderMessage($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                
         }
     }
     
     public function renderLogedinError($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
                require View.$this->FOOTER;
                
         }
     }
     
     public function renderEmailInvites($fileName, $contacts){
          if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
                //require View.$this->HEADER;
                require_once View.''.$fileName.'.php';
               
                
         }
     }
     
     public function renderLogedoutError($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';
                require View.$this->FOOTER;
                
         }
     }
     
     public function renderAboutus($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';     
         }
     }
     
     public function renderTerms($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';
                
         }
     }
     
     public function renderPolicy($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';
                
         }
     }
     
     public function renderHelp($fileName){
         if($fileName == "index/index")
         {
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderForgotpasswordlogin($fileName, $email){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministration($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministrationNavigation($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministrationPutFood($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministrationPutRecipe($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
              
                require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministrationPutProduct($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }else{
               require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderReseachAdministrationPostArticle($fileName){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }else{
             require_once View.''.$fileName.'.php';      
         }
     }
     
     public function renderArticle($fileName, $userDetails, $articles, $article_comments, $article_likes_counts, $article_share_counts){
         if($fileName == "index/index"){
               require_once View.''.$fileName.'.php';
         }
         else{
                require View.$this->HEADER;
                require_once View.''.$fileName.'.php';      
         }
     }
             
    function loadHeader()
    {
        require View.$this->HEADER;
    }
    
    function loadFooter()
    {
        require View.$this->FOOTER;
    }
    
   public function getuserCommentCountSuffix($num)
    {
     $message = '';
    
        if($num >=0 && $num <=3)
        {
           return $message = "No more comments to show";
        }
        else if($num > 3)
        {
            $newNum = $num-3;
            if($newNum === 1){
                return $message = "Show ".$newNum." more comment";
            }else{
                  return $message = "Show ".$newNum." more comments";
            }
        }
    }
    
    
    //for home page
    function SCTSurfix($data, $whichPl, $whichSig)
    {
        if($data == 1)
        {
            return $data." ".$whichSig;
        }
        else 
        {
            return $data." ".$whichPl;
        }
    }
    
    function foodFollowSurfix($num)
    {
        $surfix = 'No followers';
        if($num === ZERO)
        {
            return $surfix;
        }
        else if($num === 1)
        {
            $surfix = $num." follower";
           return $surfix;
        }
        else if($num > 1)
        {
            $surfix = $num." followers";
            return $surfix;
        }
            
    }
    //user comments
  public function timeCounter($posttime){
    $suffix = '';
    $currentTim = time();
    $timeDiff = $currentTim - $posttime;
    
    switch(1)
    {
        case ($timeDiff < 60):
          $count = $timeDiff;
            
            if($count==0)
                $count = "a moment";
            else if($count==1)
                $suffix = "second";
            else 
                $suffix = "seconds";
            
         break;
         
        case ($timeDiff > 60 && $timeDiff < 3600):
          $count = floor($timeDiff/60);
           if($count==1)
                $suffix = "Minute";
            else 
                $suffix = "Minutes";
            
         break;
         
          case ($timeDiff > 3600 && $timeDiff < 86400):
                $count = floor($timeDiff/3600);
             if($count==1)
                  $suffix = "hour";
              else 
                  $suffix = "hours";       
         break;
         
         case ($timeDiff > 86400 && $timeDiff < 604800):
                $count = floor($timeDiff/86400);
             if($count==1)
                  $suffix = "day";
              else 
                  $suffix = "days";
              
         break;
         
          case ($timeDiff > 604800 && $timeDiff < 2629743):
                $count = floor($timeDiff/604800);
             if($count==1)
                  $suffix = "week";
              else 
                  $suffix = "weeks";
              
         break;
         
         case ($timeDiff > 2629743 && $timeDiff < 31556926):
                $count = floor($timeDiff/2629743);
             if($count==1)
                  $suffix = "month";
              else 
                  $suffix = "months";
              
         break;
         
         case ($timeDiff > 31556926):
                $count = floor($timeDiff/31556926);
             if($count==1)
                  $suffix = "year";
              else 
                  $suffix = "years";
              
         break;
    }

        return "Posted ".$count." ".$suffix." ago";
 }
 
 public function timeCounterNotif($posttime){
    $suffix = '';
    $currentTim = time();
    $timeDiff = $currentTim - $posttime;
    
    switch(1)
    {
        case ($timeDiff < 60):
          $count = $timeDiff;
            
            if($count==0)
                $count = "a moment";
            else if($count==1)
                $suffix = "second";
            else 
                $suffix = "seconds";
            
         break;
         
        case ($timeDiff > 60 && $timeDiff < 3600):
          $count = floor($timeDiff/60);
           if($count==1)
                $suffix = "Minute";
            else 
                $suffix = "Minutes";
            
         break;
         
          case ($timeDiff > 3600 && $timeDiff < 86400):
                $count = floor($timeDiff/3600);
             if($count==1)
                  $suffix = "hour";
              else 
                  $suffix = "hours";       
         break;
         
         case ($timeDiff > 86400 && $timeDiff < 604800):
                $count = floor($timeDiff/86400);
             if($count==1)
                  $suffix = "day";
              else 
                  $suffix = "days";
              
         break;
         
          case ($timeDiff > 604800 && $timeDiff < 2629743):
                $count = floor($timeDiff/604800);
             if($count==1)
                  $suffix = "week";
              else 
                  $suffix = "weeks";
              
         break;
         
         case ($timeDiff > 2629743 && $timeDiff < 31556926):
                $count = floor($timeDiff/2629743);
             if($count==1)
                  $suffix = "month";
              else 
                  $suffix = "months";
              
         break;
         
         case ($timeDiff > 31556926):
                $count = floor($timeDiff/31556926);
             if($count==1)
                  $suffix = "year";
              else 
                  $suffix = "years";
              
         break;
    }

        return "Posted ".$count." ".$suffix." ago";
 }
 
 
   public function timeCounterShort($posttime){
    $suffix = '';
    $currentTim = time();
    $timeDiff = $currentTim - $posttime;
    
    switch(1)
    {
        case ($timeDiff < 60):
          $count = $timeDiff;
            
            if($count==0)
                $count = "a moment";
            else if($count==1)
                $suffix = "sec";
            else 
                $suffix = "sec";
            
         break;
         
        case ($timeDiff > 60 && $timeDiff < 3600):
          $count = floor($timeDiff/60);
           if($count==1)
                $suffix = "min";
            else 
                $suffix = "mins";
            
         break;
         
          case ($timeDiff > 3600 && $timeDiff < 86400):
                $count = floor($timeDiff/3600);
             if($count==1)
                  $suffix = "hr";
              else 
                  $suffix = "hrs";       
         break;
         
         case ($timeDiff > 86400 && $timeDiff < 604800):
                $count = floor($timeDiff/86400);
             if($count==1)
                  $suffix = "d";
              else 
                  $suffix = "d";
              
         break;
         
          case ($timeDiff > 604800 && $timeDiff < 2629743):
                $count = floor($timeDiff/604800);
             if($count==1)
                  $suffix = "wk";
              else 
                  $suffix = "wks";
              
         break;
         
         case ($timeDiff > 2629743 && $timeDiff < 31556926):
                $count = floor($timeDiff/2629743);
             if($count==1)
                  $suffix = "mon";
              else 
                  $suffix = "mons";
              
         break;
         
         case ($timeDiff > 31556926):
                $count = floor($timeDiff/31556926);
             if($count==1)
                  $suffix = "yr";
              else 
                  $suffix = "yrs";
              
         break;
    }

        return "".$count."".$suffix."";
 }
 
 
 public function dateChecker($date){
     $format = "Y-m-d";
     $now_date = strtotime(date($format));
             
      if(strtotime($date) === $now_date){
          return true;
      }else{
          return false;
      }
 }
 
 //for home page title
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
 
 //profile users
    function encrypt($sData)
    {
        $val = rand(ZERO, 4);

        $encrpter = $this->enrypter[$val];
        $id =(double)$sData*$encrpter;

       return base64_encode($id).$val;
    }
    
    //for profile
     public function getfriendUserId($user_id, $friend_user_id, $userId)
    {
        if((int)$user_id == (int)$userId && (int)$friend_user_id != (int)$userId)
        {
           
            return $friend_user_id;
        }
        else if((int)$user_id != (int)$userId && (int)$friend_user_id == (int)$userId)
        {
           
            return $user_id;
        }
    }
    
    // for profile
     public function getfavoriteData($favData, $type)
    {
        if(!empty($favData))
        {
            return $favData;
        }
        else 
        {
            return "No Favorite $type. Edit your Favorite ".$type.".";
        }
    }
    
    //for profile
     public function getStatus($status, $user_id, $friend_user_id, $userId='')
     {
        if($userId)
        {
            (int)$userId;
             (String)$statusInfo = '';
            if($status == 1 && $user_id != $userId && $friend_user_id == $userId){ $statusInfo = 'Following';}
            else if($status == 1 && $user_id == $userId && $friend_user_id != $userId){ $statusInfo = 'Follower';}
            else if($status == 2){$statusInfo = "Friends";}
            else if($status == 0){$statusInfo = 'Follow';}

            return (String)$statusInfo;
        }else{
            $statusInfo = '';
            if($status == 1 && $user_id != $this->id && $friend_user_id ==  $this->id){ $statusInfo = 'Following';}
            else if($status == 1 && $user_id == $this->id && $friend_user_id != $this->id){ $statusInfo = 'Follower';}
            else if($status == 2){$statusInfo = 'Friends';}
            else if($status == 0){$statusInfo = 'Follow';}

            return (string)$statusInfo;
        }
    }
    
    
    //for profile
    public function getRestfavoriteData($favData, $type)
    {
        if(!empty($favData))
        {
            return $favData;
        }
        else 
        {
            return "No $type. Edit your ".$type.". Separate each ".$type." with a commer";
        }
    }
    
     public function getAboutUsData($abousUs)
     {
        if(!empty($abousUs))
        {
            return $abousUs;
        }
        else 
        {
            return "No About Us. Edit your About Us.";
        }
    }
    
    //for profile
    public function ownerUserIdSet($owner_user_id, $user_id)
    {
        if(isset($owner_user_id))
        {
            return $owner_user_id;
        }
        else{
            return $user_id;
        }
    }
    
    //method for events
    public function getAttendingText($statusCount)
    {
        $text = '';
        $attend = 'attend';
        $attending = 'attending';
        if($statusCount == ZERO)
        {
            $text = $attend;
        }
        else if($statusCount == 1)
        {
            $text = $attending;
        }
        
        return $text;
    }
    
    //for eatwith page
    public function getLikesPrefix($num)
    {
        $message = '';
        if($num >=2){
           $message = $num." people said is tasty";
        }else if($num == 1){
          $message = $num." person said is tasty";
        }else{
            $message = " No Tasty's";
        }
        
        return $message;
    }
    
    public function checkCoverPicture($pic)
    {
        $default_cover = '<img src="'.URL.'pictures/default_cover.png" alt="">';
        $user_cover = '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" alt="" height="317">';
        if(empty($pic))
        {
            return $default_cover;
        }
        else
        {
            return $user_cover;
        }
    }
    
    public function checkUserPicture($pic, $width, $height)
    {
        $default_picture = '<img src="'.URL.'pictures/default_picture.jpg" width="'.$width.'" height="'.$height.'" alt="">';
        $user_picture = '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" width="'.$width.'" height="'.$height.'" alt="">';
        if(empty($pic))
        {
            return $default_picture;
        }
        else
        {
            return $user_picture;
        }
    }
    
    public function checkUsersPicture($pic, $user_id, $user_name, $width, $height)
    {
        $default_picture = '<a href='.URL.'profile/user/'.$this->encrypt($user_id).'><img src="'.URL.'pictures/default_picture.jpg" width="'.$width.'" height="'.$height.'" alt="" title="'.$user_name.'"></a>';
        $user_picture = '<a href='.URL.'profile/user/'.$this->encrypt($user_id).'><img src="data:image/jpeg;base64,'.base64_encode($pic).'" width="'.$width.'" height="'.$height.'" alt="" title="'.$user_name.'"></a>';
        if(empty($pic))
        {
            return $default_picture;
        }
        else
        {
            return $user_picture;
        }
    }
    
    public function checkSuggestedUserPicture($pic, $title, $width, $height)
    {
        $default_picture = '<img src="'.URL.'pictures/default_picture.jpg" width="'.$width.'" height="'.$height.'" alt="" title="'.$title.'">';
        $user_picture = '<img src="data:image/jpeg;base64,'.base64_encode($pic).'" width="'.$width.'" height="'.$height.'" alt="" title="'.$title.'">';
        if(empty($pic))
        {
            return $default_picture;
        }
        else
        {
            return $user_picture;
        }
    }
    
       
    
    public function getuserRecookCommentCountSuffix($num)
    {
         $message = '';
           if($num >1)
           {
              return $message = $num." comments";
           }
           else if($num == 1)
           {
             return $message = $num." comment";
           }
           else
           {
              return  $message = "No comments";
           }


    }

    public function checkCoobBoxPic($cookBoxbool, $width, $height){
         $default_false_star = '<img src="'.URL.'pictures/home/favorite.png" width="'.$width.'" height="'.$height.'" alt="" title="Put this recipe in your CookBox">';
          $default_true_star = '<img src="'.URL.'pictures/home/favorite_on.png" width="'.$width.'" height="'.$height.'" alt="" title="this recipe is in your CookBox">';
         if($cookBoxbool){
             return $default_true_star;
         }else{
             return $default_false_star;
         }
    }
    
    public function checkMealType($mealType, $width, $height){
        $breakFast_icon = '<img src="'.URL.'pictures/home/breakfast_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Breakfast meal">';
        $lunch_icon  = '<img src="'.URL.'pictures/home/lunch_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Lunch meal">';
        $dinner_icon  = '<img src="'.URL.'pictures/home/dinner_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Dinner meal">';
        $dessert_icon  = '<img src="'.URL.'pictures/home/dessert_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Dessert">';
        $drink_icon  = '<img src="'.URL.'pictures/home/drink_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Drink">';
        $dinner2_icon  = '<img src="'.URL.'pictures/home/dinner_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Dinner meal" style="position: relative; top: -20px; left: 0px; margin-bottom: -20px;">';
        $lunch2_icon  = '<img src="'.URL.'pictures/home/lunch_icon.png" width="'.$width.'" height="'.$height.'" alt="" title="Lunch meal" style="position: relative; top: -25px; left: 0px; margin-bottom: -20px;">';
        
        $breakfast = 'Breakfast';
        $lunch = 'Lunch';
        $dinner = 'Dinner';
        $dessert = 'Dessert';
        $drink = 'Drink';
        $breakfastLunch = 'Breakfast or Lunch';
        $lunchDinner = 'Lunch or Dinner';
        $breakfastDinner = 'Breakfast or Dinner';
        
        if($mealType === $breakfast){
            return $breakFast_icon;
        }else if($mealType === $lunch){
            return $lunch_icon;
        }else if($mealType === $dinner){
            return $dinner_icon;
        }else if($mealType === $breakfastDinner){
            return $breakFast_icon." ".$dinner2_icon;
        }else if($mealType === $lunchDinner){
            return $lunch_icon." ".$dinner2_icon;
        }else if($mealType === $breakfastLunch){
            return $breakFast_icon." ".$lunch2_icon;
        }else if($mealType === $dessert){
            return $dessert_icon;
        }else if($mealType === $drink){
            return $drink_icon;
        }
        
        
    }
    
    
    //for home page
    public function getSharedRecipeName($data, $i, $width, $height){
       
        if(isset($data[$i]['recipe_owner_names']) && isset($data[$i]['sharer_user_id']) && (int)$data[$i]['sharer_user_id'] === (int)$this->id && (int)$data[$i]['user_type'] !== (int)$data[$i]['user_id']){
             return "<a href='".URL."profile/user/".$this->encrypt($data[$i]['sharer_user_id'])."' class='sharer_name'>".$user_name."</a> <span class='SHARED'> shared </span> <a href='".URL."profile/user/".$this->encrypt($data[$i]['user_id'])."' class='recipe_Owner_name'>".$data[$i]['recipe_owner_names']."'s</a> <span class='RECIPE'>recipe</span>";                                                     
        }else if(isset($data[$i]['recipe_owner_names']) && is_numeric($data[$i]['user_type']) && (int)$data[$i]['user_type'] === (int)$this->id && (int)$data[$i]['user_type'] !== (int)$data[$i]['user_id']){
            return "<a href='".URL."profile/user/".$this->encrypt($data[$i]['user_type'])."' class='sharer_name'>".$user_name."</a> <span class='SHARED'> shared </span> <a href='".URL."profile/user/".$this->encrypt($data[$i]['user_id'])."' class='recipe_Owner_name'>".$data[$i]['recipe_owner_names']."'s</a> <span class='RECIPE'>recipe</span>";   
        }else if(isset($data[$i]['recipe_owner_names']) && is_numeric($data[$i]['user_type']) && (int)$data[$i]['user_type'] !== (int)$this->id && (int)$data[$i]['user_type'] === (int)$data[$i]['user_id']){
             return "<a href='".URL."profile/user/".$this->encrypt($data[$i]['user_type'])."' class='sharer_name'>".$user_name."</a> <span class='SHARED'> shared owned </span><span class='RECIPE'>recipe</span>"; 
        }else if(isset($data[$i]['recipe_owner_names']) && is_numeric($data[$i]['user_type'])  && (int)$data[$i]['user_type'] === (int)$data[$i]['user_id']){
             return "<a href='".URL."profile/user/".$this->encrypt($data[$i]['user_type'])."' class='sharer_name'>".$user_name."</a> <span class='SHARED'> you shared </span><span class='RECIPE'>recipe</span>"; 
        }else{
            return "<a href=".URL."profile/user/".$this->encrypt($data[$i]['user_id']).">".$user_name."</a>";
        }
    }
    
    
    
    
    public function post_statsSurfix($number){
        $oneBil = "1b+";
        if($number > 999 && $number <= 9999){
            return $this->checkHunInThou($number);
        }
        else if( $number > 9999 && $number <= 99999){
            return $this->checkHunInTensThous($number);
        }else if($number > 99999 && $number <= 999999){
            return $this-> checkHunInHunThous($number);
        }else if($number > 999999 && $number <= 9999999){
            return $this->checkMill($number);
        }else if($number > 9999999 && $number <= 99999999){
            return $this->checkTensMill($number);
        }else if($number > 99999999 && $number <= 999999999){
            return $this->checkHunsMill($number);
        }else if($number > 999999999 && $number <= 9999999999){
            return $oneBil ;
        }else{
            return $number;
        }
            
        
    }
    
    
   private function checkHunInThou($number){
       $one = 1;
       $strNum = $number."";
       
       if((int)$strNum[$one] > ZERO )
       {
           return (int)$strNum[ZERO].".".(int)$strNum[$one]."k" ;
       }else if((int)$strNum[$one] === ZERO ){
            return (int)$strNum[ZERO]."k";
       }
    
   }
   
   private function checkHunInTensThous($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$two] > ZERO ){
            return (int)$strNum[ZERO]."".(int)$strNum[$one].".".(int)$strNum[$two]."k";
        }else if((int)$strNum[$two] === ZERO){
            return (int)$strNum[ZERO]."".(int)$strNum[$one]."k";
        }
   }
   private function checkHunInHunThous($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        return (int)$strNum[ZERO]."".(int)$strNum[$one]."".(int)$strNum[$two]."k";
   }
   
   private function checkMill($number){
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$one] > ZERO){
            return (int)$strNum[ZERO].".".(int)$strNum[$one]."m";
        }else if((int)$strNum[$one] === ZERO){
             return (int)$strNum[ZERO]."m";
        }
   }
   
   private function checkTensMill($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$two] > ZERO){
            return (int)$strNum[ZERO]."".(int)$strNum[$one].".".(int)$strNum[$two]."m";
        }else{
             return (int)$strNum[ZERO]."".(int)$strNum[$one]."m";
        }
        
   }
   
   private function checkHunsMill($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        return (int)$strNum[ZERO]."".(int)$strNum[$one]."".(int)$strNum[$two]."m";
   }
   
   public function checkPWIPictures($recipe_post_id, $pwi_image){
         return '<a href="'.URL.'home/recipesteps/'.$this->encrypt($recipe_post_id).'" title="click to view full steps"  target="_blank"><img class = "pwi" src="data:image/jpeg;base64,'.base64_encode($pwi_image).'"  alt=""></a>';
       
   }
   
   public function checkFFbckPic($pic){
       $default_pic = URL.'pictures/default_cover_small.png';
       $userCover_pic = 'data:image/jpeg;base64,'.base64_encode($pic).'';
       if(empty($pic)){
           return $default_pic;
       }else{
           return $userCover_pic;
       }
   }
   
   public function checkFoodPic($picData){
       if($picData){
           return 'data:image/jpeg;base64,'.base64_encode($picData).'';
       }else{
           return URL.'pictures/ENRI_NOTIF_APPLE.png';
       }
   }
   
    public function checkCountryPic($picData){
       if($picData){
           return 'data:image/jpeg;base64,'.base64_encode($picData).'';
       }else{
           return URL.'pictures/default_country_pic.png';
       }
   }
   
   public function checkFoodpicTitle($title){
       if($title){
           return $title;
       }else{
           return 'Enri don\'t have the food for this recipe';
       }
   }
   
   public function personpersons($number){
       
       if((int)$number === 1){
           return $number.' person';
       }else{
           return $number.' persons';
       }
       
   }
   
   public function getUserIDorSharerID($data, $index){
       $RID = 0;
        if(isset($data[$index]['recipe_owner_names']) && isset($data[$index]['sharer_user_id'])){
                if( (int)$this->id !== (int)$data[$i]['user_id'] && (int)$this->id === (int)$data[$index]['sharer_user_id'] ){
                    $RID = $data[$index]['user_id'];
                }else  if( (int)$this->id === (int)$data[$index]['user_id'] && (int)$this->id !== (int)$data[$index]['sharer_user_id']){
                    $RID = $data[$index]['sharer_user_id'];
                }else{
                    $RID = $data[$index]['user_id'];
                }
        }else if(isset($data[$index]['recipe_owner_names']) && is_numeric($data[$index]['user_type'])){
            if( (int)$this->id !== (int)$data[$index]['user_id'] && (int)$this->id === (int)$data[$index]['user_type'] ){
                $RID = $data[$index]['user_id'];
            }else  if( (int)$this->id === (int)$data[$index]['user_id'] && (int)$this->id !== (int)$data[$index]['user_type']){
                $RID = $data[$index]['user_type'];
            }else{
                $RID = $data[$index]['user_id'];
            }
        }else{$RID = $data[$index]['user_id'];}
        
        return $RID;
   }
   
   public function getUserNameorRestaurantName($data, $index){
       $user_name = '';
       if(isset($data[$index]['Restaurant'])){
           $user_name = $data[$index]['Restaurant'];
           
       }else{$user_name = $data[$index]['FirstName']." ".$data[$index]['LastName'];}
       return $user_name;
   }
  
}