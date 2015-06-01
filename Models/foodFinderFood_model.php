<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of foodFinderFood_model
 *
 * @author Uche
 */
class foodFinderFood_model extends Model {
   function __construct()
     {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
         
     }
   
     //for "food" page::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    function food($country){
         //load css files
         $this->view->id = $this->id;
        $this->view->css = new ArrayObject(array('css/foodfinder/food/foodsheet.css', 
                                                'css/foodfinder/food/errorDialgBoxSheet.css',
                                                'css/foodfinder/productsDialog/productsheet.css',
                                                 'css/foodfinder/countries.css',
                                                'css/foodfinder/loadCountries.css',
                                                'css/profile/followfriendssheet.css'));
         //load js files
        $this->view->js = array('foodfinder/food/js/foodpage.js', 
                                'foodfinder/food/js/tooltip.js',
                                'foodfinder/food/js/Upload.js',
                                'foodfinder/productsDialog/js/productjsFunctions.js',
                                'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                 'profile/js/friendsFollowers.js');
        
               $userDetails = $this->getUserDetails($this->id);
        
                $sql = "SELECT FC.food_name, FC.country_names, C.country_id, F.food_id, F.food_description, F.food_picture, F.Nutrients
                        FROM  `food_country` AS FC
                        INNER JOIN food AS F ON FC.food_name = F.food_name
                        INNER JOIN country AS C ON FC.country_names = C.country_names
                        WHERE FC.country_names =  :country 
                        LIMIT 0 , 6";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                    ':country' => $country
                ));
                
                $flag_picture = $this->getCountryFlagPicture($country);
         
                $foods = $sth->fetchAll(PDO::FETCH_ASSOC);
                $yesFood = '';
                if(count($foods) === ZERO){
                    $yesFood = 0;
                }
                else{
                    $yesFood = 1;
                }
                    
                
                $foodFollows_FoodFollowCount = $this->getFoodFollowsAndFollowCount($foods);
                $otherCountries = $this->getOtherCountry($foods);
                $fileName = FOODFINDER.'/food/index';
          //echo var_dump($otherCountries);
                $this->view->renderFoodFinderFood($fileName, $userDetails, $foods, $country, $foodFollows_FoodFollowCount, $country, $flag_picture, $otherCountries, $yesFood);
        
        
        
 
       
    }
    
    
    private function getFoodFollowsAndFollowCount($foods)
    {
        $foodFollow_count = array();
        
        
        for($looper = 0; $looper < count($foods); $looper++){
            
            $food_id = $foods[$looper]['food_id'];
            $country_id = $foods[$looper]['country_id'];
        
            if($this->isFollowFood($this->id, $food_id, $country_id)){
                $foodFollow_count[$looper]['food_follow'] =  $src = URL."pictures/foods/ufollow.png";
                $foodFollow_count[$looper]['food_follow_title'] = "unfollow ".$foods[$looper]["food_name"]." in ".$foods[$looper]["country_names"]."";
            }
            else{
                $foodFollow_count[$looper]['food_follow'] = URL."pictures/foods/follow.png";
                $foodFollow_count[$looper]['food_follow_title'] = "follow ".$foods[$looper]["food_name"]." in ".$foods[$looper]["country_names"]."";
            }

            $foodFollow_count[$looper]['follow_count'] = $this->getFollowFoodCount($food_id, $country_id);
        }
        return $foodFollow_count;
    }
    
    private function getFollowFoodCount($food_id, $country_id)
    {
        $sql = "SELECT * FROM food_follow WHERE food_id = :food_id AND country_id = :country_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':food_id'=>$food_id, ':country_id'=>$country_id));
        
        $foodFollowCount = $sth->fetchAll();
        
        return count($foodFollowCount);
                
    }
    
    function getOtherCountry($foods)
    {
        $otherCountries = array();
        $output = '';
        
        for($looper = 0; $looper < count($foods); $looper++){
            
            $food_name = $foods[$looper]['food_name'];
            $country_name = $foods[$looper]['country_names'];
            
                $sql = "SELECT country_names FROM food_country WHERE food_name = :food";

               $sth = $this->db->Sdb->prepare($sql);
               $sth->setFetchMode(PDO::FETCH_ASSOC);
               $sth->execute(array(
                   ':food' => $food_name
               ));
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                for($i=0; $i < count($data); $i++)
                {

                    if($data[$i]['country_names'] != $country_name)
                    {
                       $output .= $data[$i]['country_names'] ."</br>";
                    }
                }
               
                $otherCountries[$looper] = $output;
                 $output = '';
        }

        return $otherCountries;
   }

   
   function InsertFollowFood($food_id,  $country_id)
   {
       
       if($this->isFollowFood($this->id, $food_id, $country_id))
       {
           //delet
           $sql = "DELETE FROM food_follow WHERE user_id =:user_id AND food_id= :food_id AND country_id= :country_id";
                $sth = $this->db->prepare($sql);
               if($sth->execute(array(
                    ":user_id" => $this->id,
                    ":food_id" => $food_id,
                    ":country_id" => $country_id
                )))
               {
                   echo json_encode('DELETED');
               }
               else
               {
                   echo json_encode("NOT DELETED");
               }
       }
       else{
                //insert
                $sql = "INSERT INTO food_follow (user_id, food_id, country_id) VALUES (:user_id, :food_id, :country_id)";
                $sth = $this->db->prepare($sql);
               if($sth->execute(array(
                    ":user_id" => $this->id,
                    ":food_id" => $food_id,
                    ":country_id" => $country_id
                )))
               {
                   echo json_encode('INSERTED');
               }
               else
               {
                   echo json_encode("NOT INSERTED");
               }
       }
   }
   
   function getFoodFollowers($food_id, $country_id){
       echo json_encode($this->view->foodFollowSurfix($this->getFollowFoodCount($food_id, $country_id)));
   }
   
    //for food page
    function UserInputCommentIntoDb($userInput)
    {
        $email = $_SESSION['user'];
        $sql = "INSERT INTO  usersfoodinput (food_Input, userFoodImage_Name, userFoodImage, user_email) VALUES (:input, :imageN, :imageT, :email)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(
            ':input' => $userInput,
            ':imageN' => "",
            ':imageT' => "",
            ':email' => $email
        ))){
             echo json_encode($this->userInputMessage);
         } else
         {
            
              echo json_encode($sth->errorInfo());
         }
       
    }
      // for food page
    function userInputCommentandImageIntoDb($imageName, $ImageTemp, $userInput)
    {
        $email = $_SESSION['user'];
        $sql = "INSERT INTO  usersfoodinput (food_Input, userFoodImage_Name, userFoodImage, user_email) VALUES (:input, :imageN, :imageT, :email)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(
            ':input' => $userInput,
            ':imageN' => $imageName,
            ':imageT' => $ImageTemp,
            ':email' => $email
        ))){
             echo json_encode($this->userInputMessage);
         } else
         {
             //error
              echo json_encode($sth->errorInfo());
         }
    }
    private function isFollowFood($user_id, $food_id, $country_id)
    {
        $sql = "SELECT user_id FROM food_follow WHERE user_id = :user_id AND food_id= :food_id AND country_id= :country_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ":user_id" => $user_id,
           ":food_id" => $food_id,
           ":country_id" => $country_id
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       if(count($data)> 0)
       {
           return true;
       }
       else 
       {
           return false;
       }
    }
    
    function otherCountry($country, $food)
    {
        $output = '';
        $sql = "SELECT country_names FROM food_country WHERE food_name = :food";

       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':food' => $food
       ));
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        for($i=0; $i < count($data); $i++)
        {

        if($data[$i]['country_names'] != $country)
               {
                  $output .= $data[$i]['country_names'] ."</br>";
               }
        }

        return $output;
   }

 
 function infinitScrollFood($pages, $country)
 {
      
     $sql = "SELECT FC.food_name, FC.country_names, C.country_id, F.food_id, F.food_description, F.food_picture, F.Nutrients
            FROM  `food_country` AS FC
            INNER JOIN food AS F ON FC.food_name = F.food_name
            INNER JOIN country AS C ON FC.country_names = C.country_names
            WHERE FC.country_names =  :country 
            LIMIT $pages , 6";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                    ':country' => $country
                ));
              
         
                $foods = $sth->fetchAll(PDO::FETCH_ASSOC);
                $foodFollows_FoodFollowCount = $this->getFoodFollowsAndFollowCount($foods);
                $otherCountries = $this->getOtherCountry($foods);
              
                $this->infinitLoadFoods($foods,  $foodFollows_FoodFollowCount, $country,  $otherCountries, (int)$pages);
 }
  private function infinitLoadFoods($foods,  $foodFollows_FoodFollowCount,  $country, $otherCountries, $pages)
    {
        $output = '';
        $src = '';
        $title = '';
        for($looper=0; $looper < count($foods); $looper++)
        {
           
            $output .= ' <div class="foodCon">
                       <script  type="text/javascript">
                            inifityScroltooltipNut(\''.$pages.'\');
                               inifityScroltooltipCont(\''.$pages.'\');
                        </script>
                       
                 <div class="followFood" > <span class="FollowCount"><b>'.$this->view->foodFollowSurfix($foodFollows_FoodFollowCount[$looper]['follow_count']).'</b></span><img class="followFoodimg" src="'.$foodFollows_FoodFollowCount[$looper]['food_follow'].'" title="'. $foodFollows_FoodFollowCount[$looper]['food_follow_title'] .'" width="30" height="30"  onclick="followFood(\''.$this->id .'\', \''.$foods[$looper]["food_id"].'\', \''.$foods[$looper]["country_id"].'\', \''.$looper.'\')"></div>
                     
                 <div class="foodpic">
                         <img src="data:image/jpeg;base64,'.base64_encode($foods[$looper]["food_picture"]).'" height="100" width="100" alt="">
                     </div>
                 
                     <div class="foodName">
                      '.$foods[$looper]["food_name"].'
                      </div>
                     
                     <div class="foodDesc">
                    '.$foods[$looper]["food_description"].'
                     </div>
                   <div class="enri_recipes">
                     <span ><a href="'.URL.MEAL.$foods[$looper]["food_name"].'/'.$foods[$looper]["country_names"].'"><img src="'.URL.'pictures/foods/ENRI_RECIPE_ICON.png" width="30" title="recipes" alt=""></a></span>
                   </div>
                   <div class="products" onclick=" AllProducts(\''.$foods[$looper]["food_name"].'\');">
                        <div id = "Prod" style=""><img src="'.URL.'pictures/foods/ENRI_PRODUCT_ICONS.png" width="40" title="products" alt=""></div>
                   </div>
                <div class="OtherCountryNuterients">
                     <ul>
                         <li class="Count" title="'.$otherCountries[$looper].'">Countries<div class="TOOLTIPCont"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERCont"></div></li>
                         <li class="Nutr"  style="margin-left: 10px;" title="'.$foods[$looper]["Nutrients"].'">Nutrients<div class="TOOLTIPNut"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERNut"></div></li>
                     </ul>
                 </div>
                <div id="tooltips"></div>
           </div>';
            $pages++;
        }
          
       echo json_encode($output);
            
    }
   
//food methods ends here:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
}
