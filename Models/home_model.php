  <?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of home_model
 *
 * @author Uche
 */
class home_model extends Model{
   
    function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->CURL = new C_Url();
        ///$this->view = new View();
        
    }
    
    function index()
    {
        $one = 1; $two = 2;
        $this->view->js = array('home/js/homejs.js', 'home/js/homeUserCommentHandler.js', 
                                'foodfinder/productsDialog/js/productjsFunctions.js',
                                'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                'profile/js/friendsFollowers.js'
                                );
      
        $this->view->css = array( 'css/home/homesheet.css',
                                   'css/home/enri_post.css',
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
       
        $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id AND RP.user_id = :user_id
                 
                UNION
            
                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.Post_time, U.FirstName, U.LastName, U.picture,  RPS.sharer_user_id, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN recipe_post_share AS RPS ON RP.user_id = RPS.recipe_owner_user_id
                AND RP.recipe_post_id = RPS.recipe_post_id
                INNER JOIN user_details AS U ON RPS.sharer_user_id = U.user_id
                WHERE RPS.sharer_user_id = :user_id



                UNION 


                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.Post_time, U.FirstName, U.LastName, U.picture, RPS.sharer_user_id, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN recipe_post_share AS RPS ON RP.user_id = RPS.recipe_owner_user_id
                AND RP.recipe_post_id = RPS.recipe_post_id
                INNER JOIN user_details AS U ON RPS.sharer_user_id = U.user_id
                INNER JOIN friends AS FR ON RPS.sharer_user_id = FR.user_id
                AND FR.user_friend_id = :user_id

                UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_id
                AND F.user_friend_id = :user_id AND F.status =:status_one

                UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_id
                AND F.user_friend_id = :user_id AND F.status =:status_two

                 UNION


                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_friend_id
                AND F.user_id = :user_id AND F.status =:status_two

                 UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN food_follow AS FF ON FF.food_id = RP.food_id
                WHERE FF.user_id = :user_id
                ORDER BY post_time DESC LIMIT 0, 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id" => $this->id, ':status_one'=>$one, ':status_two'=>$two
        ));

       $dat = $sth->fetchAll(PDO::FETCH_ASSOC);
       $data = $this->checkSharedRecipeAndAddOwnerName($dat);
      
       $userComments = "";//$this->getrecipePostUserCommentsData($data);
       $foodCountry = $this->getRecipePostFoodCountry($data);
      //echo var_dump($foodCountry);
       $tastyCount = $this->getTastyCount($data);
       $shareCount = $this->getShareCount($data);
       $cootItCount = $this->getCookitCount($data);
       $newData = $this->pushCookBoxValToData($data);
       //echo var_dump( $newData);

      $this->view->renderHomePage('home/index', $newData , $userComments, $foodCountry, $tastyCount, $shareCount, $cootItCount, $userDetails);
          
    }
    
  
    
    
    
    private function getPWI($recipe_post_id){
        $sql = "SELECT recipe_image, recipe_image_direction, step_count FROM recipe_pwi WHERE recipe_post_id = :recipe_post_id ORDER BY step_count ASC";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_post_id' => $recipe_post_id));
        
        $res = $sth->fetchAll();
        
        return $res;
    }
    
    public function showAllComment($recipe_post_id){
        $sql = "SELECT RPC.recipe_post_comments_id, RPC.comments, RPC.user_id, RPC.time, US.FirstName, US.LastName, US.picture FROM recipe_post_comments AS RPC INNER JOIN user_details AS US ON US.user_id = RPC.user_id WHERE recipe_post_id = :recipe_post_id ORDER by time ASC";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":recipe_post_id" => $recipe_post_id
        ));
        
        $userComments = $sth->fetchAll();
   
       echo json_encode($this->loadUserComment($userComments));
    }
    
    public function putInMyCookBox($recipe_post_id){
        $recipe_table = 'USERRECIPEPOST';
        $sql = "SELECT * FROM user_cook_box WHERE recipe_post_id = :recipe_post_id AND user_id = :user_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":recipe_post_id" => $recipe_post_id,
                            ":user_id"=>  $this->id));
        $res = $sth->fetchAll();
        
        if(count($res) === ZERO){
            //insert
            $SQL = "INSERT INTO user_cook_box VALUES(:user_cook_box, :recipe_post_id, :user_id, :recipe_table)";
            $sth = $this->db->prepare($SQL);
            if($sth->execute(array(":user_cook_box"=> "", ":recipe_post_id" => $recipe_post_id, ":user_id" => $this->id, ":recipe_table"=> $recipe_table))){
                echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }
    }
    
    public function searchForShops($country_id, $city){
        $country = $this->getCountryName($country_id);
        $nationnality = $this->getCountryNationality($country);
        
        $shops = $this->CURL->getFoodShops($nationnality, $city);
        echo json_encode($this->loadFoodShop($shops));
    }
     private function loadFoodShop($shopsResult){
        $output = '';
        for($looper = 0; $looper < count($shopsResult); $looper++){
            $output .='<div class="shopIcon"><img src="'.$shopsResult[$looper]['icon'].'" width="35" height="35"></div>
                       <div class="shopName">'.$shopsResult[$looper]['name'].'</div> 
                       <div class="shopAddress">'.$shopsResult[$looper]['formatted_address'].'</div>';
        }
        
        return $output;
    }
   
    
    public function getUserRegCity(){
        echo $this->getUserCity($this->id);
    }
    
    public function getCountry(){
        echo json_encode($this->getUserCountry());
    }
    
    public function getUserCountryNationality($country){
        echo json_encode($this->getCountryNationality($country));
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
    
    
    private function loadUserComment($userComments){
        $output = '';
        for($looper = 3; $looper < count($userComments); $looper++){
            $name = '';
            $userid = $userComments[$looper]['user_id'];
            if($this->getRestuarantName($userid)){
                $name = $this->getRestuarantName($userComments[$looper]['user_id']);
            }else if($this->getRestuarantName($userid) === EMPTYSTRING){
                $name = $userComments[$looper]['FirstName']." ".$userComments[$looper]['LastName'];
            }
            
            $output .='<div class="user_photo"><img src="data:image/jpeg;base64,'.base64_encode($userComments[$looper]["picture"]).'" width="35"></div>
                        <div class="user_name"><b><a href="'.URL.' profile/user/'.$this->encrypt($userComments[$looper]["user_id"]).'">'.$name.'</a></b></div> <div class="postTime">'.$this->timeCounter($userComments[$looper]["time"]).'</div>
                        <div class="user_comment">
                         '.$userComments[$looper]["comments"].'
                        </div>';
        }
        return $output;
    }
    
     private function putRestaurantNameInFollowFriends($userDetails)
      {
          $restaurant = 'Restaurant';
          $newuserDetails= array();
          
         
          
              if($userDetails[ZERO]['user_type'] === $restaurant)
              {
                 
                  $newuserDetails[ZERO]['picture'] = $userDetails[ZERO]['picture'];
                  $newuserDetails[ZERO]['user_type'] = $userDetails[ZERO]['user_type'];
                  $newuserDetails[ZERO]['restaurant_name'] = $this->getRestName($this->id) ;
              }
              else
              {
                  $newuserDetails[ZERO]['FirstName'] = $userDetails[ZERO]['FirstName'];
                  $newuserDetails[ZERO]['LastName'] = $userDetails[ZERO]['LastName'];
                   $newuserDetails[ZERO]['picture'] = $userDetails[ZERO]['picture'];
                  $newuserDetails[ZERO]['user_type'] = $userDetails[ZERO]['user_type'];
                 // $newFollowFriends[$looper]['restaurant_name'] = $this->getRestName($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id']) ;
              }
          
          
          return $newuserDetails;
      }
      
      private function getRestName($user_id)
      {
 
        $name1 = $this->getRestuarantName($user_id);
     
        return $name1;
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
        $sql = "SELECT food_name, food_picture, country_names, flag_picture from food, country WHERE country.country_id= :country_id AND food.food_id = :food_id";
        $sth = $this->db->prepare($sql);
        
        $sth->setFetchMOde(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":country_id" => $countryId,
            ":food_id" => $foodId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
    
    private function getrecipePostUserCommentsData($recipe_post_id){
        return $this->getUserComment($recipe_post_id);
    }
    
    function getUserComment($recipe_post_id)
    {
        $details = array();
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
     private function loadUserRecook($userComments){
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
    
    
    
    
    
    
    function infinitScrollHomeRecipeLoader($pages)
    {
        $status_one = 1;
        $status_two = 2;
             $sql = "SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id AND RP.user_id = :user_id
                 
                UNION
            
                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.Post_time, U.FirstName, U.LastName, U.picture,  RPS.sharer_user_id, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN recipe_post_share AS RPS ON RP.user_id = RPS.recipe_owner_user_id
                AND RP.recipe_post_id = RPS.recipe_post_id
                INNER JOIN user_details AS U ON RPS.sharer_user_id = U.user_id
                WHERE RPS.sharer_user_id = :user_id



                UNION 


                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.Post_time, U.FirstName, U.LastName, U.picture, RPS.sharer_user_id, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN recipe_post_share AS RPS ON RP.user_id = RPS.recipe_owner_user_id
                AND RP.recipe_post_id = RPS.recipe_post_id
                INNER JOIN user_details AS U ON RPS.sharer_user_id = U.user_id
                INNER JOIN friends AS FR ON RPS.sharer_user_id = FR.user_id
                AND FR.user_friend_id = :user_id

                UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type,  RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_id
                AND F.user_friend_id = :user_id AND F.status =:status_one

                UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_id
                AND F.user_friend_id = :user_id AND F.status =:status_two

                 UNION


                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo,  RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN friends AS F ON RP.user_id = F.user_friend_id
                AND F.user_id = :user_id AND F.status =:status_two

                 UNION

                SELECT RP.recipe_post_id, RP.recipe_title, RP.recipe_photo, RP.description, RP.health_facts, RP.meal_type, RP.ingredients, RP.user_id, RP.food_id, RP.country_id, RP.post_time, U.FirstName, U.LastName, U.picture, U.user_type, RP.recipe_pwi_active
                FROM recipe_post AS RP
                INNER JOIN user_details AS U ON RP.user_id = U.user_id
                INNER JOIN food_follow AS FF ON FF.food_id = RP.food_id
                WHERE FF.user_id = :user_id
                ORDER BY post_time DESC LIMIT $pages, 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id" => $this->id, ':status_one'=>$status_one, ':status_two'=> $status_two
        ));
        
        $dat = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        $data = $this->checkSharedRecipeAndAddOwnerName($dat);
         $userComments = $this->getrecipePostUserCommentsData($data);
        $foodCountry = $this->getRecipePostFoodCountry($data);
        
       $tastyCount = $this->getTastyCount($data);
       $shareCount = $this->getShareCount($data);
       $cootItCount = $this->getCookitCount($data);
      
        $newData = $this->pushCookBoxValToData($data);
      $this->infinityHomRecipePostLoaderLoader($newData, $userComments, $foodCountry, $pages, $tastyCount, $shareCount, $cootItCount);
    }
    
    private function infinityHomRecipePostLoaderLoader($data, $userComments, $foodCountry, $pages, $tastyCount, $shareCount, $cootItCount)
    {
        $recipe_post_tasty = "recipe_post_tasty";
        $recipe_post_cookedit = "recipe_post_cookedit";
        $recipe_post_share = "recipe_post_share";
        
        $person_said_tasty = ' person said this is tasty';
        $people_said_tasty = ' people said this is tasty';
        
        $person_said_cooked = " person cooked this";
        $people_said_cooked = " people cooked this";
        
        $person_said_share = " person shared this";
        $people_said_share = " people shared this";
        
        $output = '';
       $Food_Pic = '';
       $Food_Nm = '';
     for($i=0; $i < count($data); $i++){
           if(isset($foodCountry[$i][0]['food_picture'])){$Food_Pic = $foodCountry[$i][0]['food_picture'];$Food_Nm = $foodCountry[$i][0]['food_name'];
           }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
        $RID = $this->view->getUserIDorSharerID($data, $i);
        $user_name = $this->view->getUserNameorRestaurantName($data, $i);
        $output .= '  
                     <script type="text/javascript">
                      inifityScroltooltip(\''.$pages.'\')
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
                                               <li class="tastyCount"  onclick="insertTCS(\''.$this->id.'\', \''.$RID.'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_tasty.'\', \''. $pages.'\')"  style=""><img src="'.URL.'pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="'.$this->view->SCTSurfix($tastyCount[$i], $people_said_tasty, $person_said_tasty).'">'.$this->view->post_statsSurfix($tastyCount[$i]).'</span></li>
                                               <li class="cookCount" onclick="insertTCS(\''.$this->id.'\', \''.$RID.'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_cookedit.'\', \''.$pages.'\')" ><img src="'.URL.'pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="'.$this->view->SCTSurfix($cootItCount[$i], $people_said_cooked , $person_said_cooked).'">'.$this->view->post_statsSurfix($cootItCount[$i]).'</span></li>
                                               <li class="shareCount" onclick="insertTCS(\''.$this->id.'\', \''.$RID.'\', \''.$data[$i]['recipe_post_id'].'\', \''. $recipe_post_share.'\', \''.$pages.'\')"> <img  src="'.URL.'pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="'.$this->view->SCTSurfix($shareCount[$i],$people_said_share, $person_said_share).'">'.$this->view->post_statsSurfix($shareCount[$i]).'</span></li>
                                           </ul>
                                           <ul class="recipeNav">
                                                <li class="cookboxit" onclick="putInMyCookBox(\''.$data[$i]['recipe_post_id'].'\', \''.$RID.'\', \''.$pages.'\')">'.$this->view->checkCoobBoxPic($data[$i]['cookbook'], 20, 20).'</li>
                                                <li onclick="showShops(\''.$pages.'\',\''.$data[$i]['country_id'].'\')" class="ShpCt"><img src="'.URL.'pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                           </ul>
                                       </li>
                                </ul>
                            </div>
                    </div>';
     $pages++;
        }
        
        echo json_encode($output);
    }
    
    private function getPwiInfinity($data, $i){
         if($data[$i]['recipe_pwi_active'] === 'TRUE'){
            echo $this->view->checkPWIPictures($data[$i]['recipe_post_id'], $data[$i]['recipe_dir_image']);
         }else if($data[$i]['recipe_pwi_active'] === 'FALSE'){
             echo $data[$i]['how_its_made'];
         }
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

    private function getSharedRecipeUserNames($data, $i)
    {
        $user_name = '';
         if(isset($data[$i]['Restaurant'])){$user_name = $data[$i]['Restaurant'];}else{$user_name = $data[$i]['FirstName']." ".$data[$i]['LastName'];}
        if(isset($data[$i]['recipe_owner_names'])){
            return "<a href='".URL."profile/user/".$this->encrypt($data[$i]['sharer_user_id'])."' class='sharer_name'>".$user_name."</a> <span class='SHARED'> Shared </span> <a href='".URL."profile/user/".$this->encrypt($data[$i]['user_id'])."' class='recipe_Owner_name'>".$data[$i]['recipe_owner_names']."'s</a> <span class='RECIPE'>Recipe</span>";
        }
        else{
           return "<a href=".URL."profile/user/".$this->encrypt($data[$i]['user_id']).">".$user_name."</a>"; 
        }  
    }
    private function InfinityloadUserRecook($data, $recipe_post_id, $food_id, $Country_id, $divclass, $index){
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
                                        
                                       <div class="userCookit" onclick="countUsertryIt(\''.$data[$i]['recipe_post_comments_id'].'\',\''.$recipe_post_id.'\',\''.$food_id.'\',\''.$Country_id.'\',\''.$divclass.'\',\''.$index.'\')"><span ><img src="http://localhost/pictures/home/cookedit.png" width="15" height="15" alt=""></span></div>
                                        <div class="'.$divclass.'">'.$data[$i]['triedIt'].'</div>
                                         <script>setCookViewCss(\''.$divclass.'\')</script>
                            </div>';
        }
        return $output;    
    }
 
  
    

    function insertTCS($user_id,  $recipe_owner_user_id, $recipe_post_id, $tableName)
    {
        $sql = "SELECT * FROM ". $tableName ." WHERE sharer_user_id = :user_id AND recipe_post_id= :recipe_post_id AND recipe_owner_user_id = :owner_user_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":user_id" => $user_id,
            ":recipe_post_id" => $recipe_post_id,
            ":owner_user_id" => $recipe_owner_user_id
        ));
        
        $data = $sth->fetchAll();
        
        if(count($data) == 0)
        {
            $sql = "INSERT INTO ".$tableName." VALUES ('', '".$user_id."', '". $recipe_owner_user_id."', '".$recipe_post_id."', '".time()."')";
            $sth = $this->db->prepare($sql);
           if($sth->execute())
           {
               $sql = "SELECT * FROM ". $tableName ." WHERE recipe_post_id= :recipe_post_id";
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                    ":recipe_post_id" => $recipe_post_id
                ));

                $data = $sth->fetchAll();
                echo json_encode(count($data));
           }
           else
           {
             echo json_encode($sth->errorInfo());
           }
        }
        else
        {
            echo json_encode(false);
        }
    }
    
    function postUserComment($recipe_post_id, $comment, $foodName, $countryName, $time)
    {
        $sql = "INSERT INTO recipe_post_comments (recipe_post_comments_id, comments, recipe_post_id, food_id, country_id, time, user_id)VALUES(:recipe_post_comments_id, :comment, :recipe_post_id, :food_id, :countryId, :time, :userId)";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        if($sth->execute(array(
            ":recipe_post_comments_id" => "",
            ':comment' => $comment,
            ':recipe_post_id' =>$recipe_post_id,
            ':food_id' => $this->getFoodId($foodName),
            ':countryId' => $this->getCountryID($countryName),
            ':userId' => $this->id,
            ':time' => $time
        )))
        {
            echo json_encode(true);
        }
        else{
             echo json_encode($sth->errorInfo());
        }
    }
    
    function getUserCommentCount($recipe_post_id)
    {
        $sql = "SELECT * FROM recipe_post_comments WHERE recipe_post_id = :r_p_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':r_p_id' => $recipe_post_id
       ));
       
       $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       echo json_encode(count($data));
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
    
   public function userTryItCounter($recipe_post_comments_id, $recipe_post_id, $food_id,  $country_id)
    {
         $sql = "SELECT * FROM recipe_post_user_tryit WHERE recipe_post_comments_id = :r_p_cm_id AND user_id = :userId";
      $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':r_p_cm_id' => $recipe_post_comments_id,
           ':userId' => $this->id
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       if(count($data) == 0)
       {
            $sql = "INSERT INTO recipe_post_user_tryit (user_id, recipe_post_comments_id, recipe_post_id, food_id, country_id) VALUES(:userId, :rpci, :recipe_post_id, :food_id, :country_id)";
            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
                if($sth->execute(array(
                    ':rpci' => $recipe_post_comments_id,
                    ':userId' => $this->id,
                    ':recipe_post_id' => $recipe_post_id,
                    ':food_id' => $food_id,
                    ':country_id'=> $country_id
                ))){
                            //get data after inserting
                    $sql = "SELECT * FROM recipe_post_user_tryit WHERE recipe_post_comments_id = :r_p_cm_id";
                        $sth = $this->db->prepare($sql);
                         $sth->setFetchMode(PDO::FETCH_ASSOC);
                         $sth->execute(array(
                             ':r_p_cm_id' => $recipe_post_comments_id
                         ));

                         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                         
                         echo json_encode(count($data));
                }
                else
                {
                         echo json_encode($sth->errorInfo());
                }
       }
    }
    private function getuserCommentCountSuffix($num){
     $message = '';
        if($num >=2)
           $message = $num." comments";
        else if($num == 1)
          $message = $num." comment";
       
        
        return $message;
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
   
   private function checkSharedRecipeAndAddOwnerName($data){
             $res = "Restaurant";
             
       for($looper =0; $looper < count($data); $looper++)
       {
           $user_id = $data[$looper]['user_id'];
           //get recipe_pwi details 
          
           if(isset($data[$looper]['sharer_user_id'] )){
                $sharer_user_id = $data[$looper]['sharer_user_id'];
                if(is_numeric($sharer_user_id)){
                    $data[$looper]['recipe_owner_names'] = $this->getUserFLNameOrRestNameOrEstName($user_id);

                    if($this->getUserType($sharer_user_id) === $res){
                       $data[$looper]['Restaurant'] = $this->getRestuarantName($sharer_user_id);
                    }
                }
                else{
                     if($this->getUserType($user_id) === $res){
                       $data[$looper]['Restaurant'] = $this->getRestuarantName($user_id);
                     }
                }
          }else if(isset($data[$looper]['user_type']) && is_numeric($data[$looper]['user_type'])){
              $sharer_user_id = $data[$looper]['user_type'];
              $data[$looper]['recipe_owner_names'] = $this->getUserFLNameOrRestNameOrEstName($user_id);

                    if($this->getUserType($sharer_user_id) === $res){
                       $data[$looper]['Restaurant'] = $this->getRestuarantName($sharer_user_id);
                    }
          }else{
              if($this->getUserType($user_id) === $res){
                       $data[$looper]['Restaurant'] = $this->getRestuarantName($user_id);
              }
          }
         
          
       }
       
       return $data;
   }
   
}
