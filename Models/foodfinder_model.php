<?php
  
class foodfinder_model extends Model {

    function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        
        $this->userInputMessage = 'Food sent.<br><br> Thank you '.$this->FirstName.' for telling us about the food we dont know.';
    }
    
    //Methods with interface::::::::::::::::::::::::::::::::::::::
    function index()
    {
        
        
         $this->view->css = new ArrayObject(array('css/foodfinder/foodfindersheet.css', 
                                                  'css/foodfinder/countries.css',
                                                
                                                'css/foodfinder/food/errorDialgBoxSheet.css',
                                                  'css/foodfinder/loadCountries.css',
                                                  'css/foodfinder/food/errorDialgBoxSheet.css',
                                                  'css/foodfinder/productsDialog/productsheet.css',
                                                  'css/profile/followfriendssheet.css'));
        $this->view->js = array('foodfinder/js/foodfinder.js',
                             
                                 'foodfinder/food/js/tooltip.js',
                                'foodfinder/productsDialog/js/productjsFunctions.js',
                                'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                'profile/js/friendsFollowers.js');
        
        $sql = "SELECT food_name, food_id, food_description, food_picture, Nutrients FROM `food` ORDER BY food_name ASC LIMIT 0 , 6";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();
               
         
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
      
        
        $userDetails = $this->getUserDetails($this->id);
        //$countries = $this->preperegetCountryStatement($continent);
        $fileName = 'foodfinder/index';
        $this->view->renderFoodFinder($fileName, $userDetails, $countries = '', $foods, $foodFollows_FoodFollowCount, $otherCountries);
        
    }
     
    
    private function preperegetCountryStatement($continent)
    {
        $data = '';
        if($continent === false){
            
                $continent = AFRICA;
                $sql = " SELECT country_names, flag_picture, description FROM country WHERE continent_id = :continent  ORDER BY country_names ASC LIMIT 0, 6";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(
                    ':continent' => $continent
                ));
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        else {
                    $sql = " SELECT country_names, flag_picture, description FROM country WHERE continent_id = :continent  ORDER BY country_names ASC LIMIT 0, 6";
                    $continent = $this->getDefinedContinent($continent);
                    $sth = $this->db->Sdb->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':continent' => $continent
                    ));
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }
        
   private function LoadCountries($countries)
    {
         $output = '';
        for($looper =0; $looper< count($countries); $looper++)
        {
            $output .= '<div class="loadCon">

                          <div class="picture"><img src="data:image/jpeg;base64,'. base64_encode($countries[$looper]['flag_picture']).'" width="70" height="70" alt=""></div>
                          <div class="Cname">
                           <a href="'.URL.FOODFINDER.'/food/'.$countries[$looper]['country_names'].'" class ="Clink">'.$countries[$looper]['country_names'].'</a>
                          </div>
                          <div class="Desc">
                              '.$countries[$looper]['description'].'
                          </div>
                   </div>';
        }
        
        return $output;
    }
     function infinitScrollCountryLoader($pages, $continent)
    {
        if($pages && $continent)
        {
            $continent = $this->getDefinedContinent($continent);
            $sql = " SELECT country_names, flag_picture, description FROM country WHERE continent_id = :continent ORDER BY country_names ASC LIMIT $pages, 6";
                    $sth = $this->db->Sdb->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(
                        ':continent' => $continent
                    ));
        $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
        $output = $this->LoadCountries($data);
        }
        else
        {
            $continent = $this->getDefinedContinent($continent);
            $sql = " SELECT country_names, flag_picture, description FROM country WHERE continent_id = :continent ORDER BY country_names ASC LIMIT $pages, 6";
                        $sth = $this->db->Sdb->prepare($sql);
                        $sth->setFetchMode(PDO::FETCH_ASSOC);
                        $sth->execute(array(
                            ':continent' => $continent
                        ));
            $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
            $output = $this->LoadCountries($data);
        }
       echo json_encode($output);
    }
     
    //for country page
     function getCountries($continent)
     {
        $data = $this->preperegetCountryStatement($continent);
        $output = $this->LoadCountries($data);
        echo json_encode($output);
     }
   
       private function getDefinedContinent($continent)
    {
        if($continent === "Africa")
            return AFRICA;
        else if($continent === "Asia")
            return ASIA;
        else if($continent === "America")
            return AMERICA;
        else if($continent === "Europe")
            return EUROPE;
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

 
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
 public function infinitScrollFoodLoader($pages){
     $sql = "SELECT food_name, food_id, food_description, food_picture, Nutrients FROM `food` Order BY food_name ASC LIMIT $pages , 6";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();
               
         
                $foods = $sth->fetchAll(PDO::FETCH_ASSOC);
               
                
                $foodFollows_FoodFollowCount = $this->getFoodFollowsAndFollowCount($foods);
                $otherCountries = $this->getOtherCountry($foods);
                
               echo json_encode($this->loadFoods($foods, $foodFollows_FoodFollowCount, $otherCountries, $pages));
      
 }
 
 
private function loadFoods($foods, $foodFollows_FoodFollowCount, $otherCountries, $pages){
    $output = '';
     for($looper = 0; $looper < count($foods); $looper++){    
              $output .=     '
                        <script type="text/javascript">
                           inifityScroltooltipNut(\''.$pages.'\');
                               inifityScroltooltipCont(\''.$pages.'\');
                        </script>

                             <div class="foodCon">
                       
                                <div class="followFood" > <span class="FollowCount"><b>'.$this->view->foodFollowSurfix($foodFollows_FoodFollowCount[$looper]['follow_count']).'</b></span><img class="followFoodimg" src="'.$foodFollows_FoodFollowCount[$looper]['food_follow'].'" title="'.$foodFollows_FoodFollowCount[$looper]['food_follow_title'].'" width="30" height="30"  onclick="followFood(\''.$this->id.'\', \''.$foods[$looper]["food_id"].'\', \''.$looper.'\')"></div>

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
                                    <span ><a href="'.URL.FOODFINDER."/".RECIPES."/".$foods[$looper]["food_name"].'"><img src="'.URL.'pictures/foods/ENRI_RECIPE_ICON.png" width="30" title="recipes" alt=""></a></span>
                                </div>
                                <div class="products" onclick=" AllProducts(\''.$foods[$looper]["food_name"].'\', \''.$pages.'\');">
                                    <div id = "Prod" ><img src="'.URL.'pictures/foods/ENRI_PRODUCT_ICONS.png" width="40" title="products" alt=""></div>
                                </div>

                               <div class="OtherCountryNuterients">
                                    <ul>
                                        <li class="Count"  title="'.$otherCountries[$looper].'">Countries<div class="TOOLTIPCont"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERCont"></div></li>
                                        <li class="Nutr"  style="margin-left: 10px;" title="'.$foods[$looper]["Nutrients"].'">Nutrients<div class="TOOLTIPNut"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERNut"></div></li>
                                    </ul>
                                </div>
                                    <div id="tooltips"></div>
                            </div>';
              $pages++;
      }
    
      return $output;
}
    
    
   

    
   
//:::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
   function getProducts($food, $country)
   {
   
       $sql = "SELECT products.product_name, products.description, products.product_picture, 
               food_products.country_names FROM products
               INNER JOIN food_products ON products.product_name = food_products.product_name
               AND food_products.country_names = :country_name
               WHERE food_products.food_name = :food";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':food' => $food,
           ':country_name' => $country
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
            if(count($data) ==  ZERO)
            {
               //error messa here
                $erMessage = ZERO;
                echo json_encode($erMessage);
            }
            else
            {
                
              echo json_encode($this->loadProducts($data));
            
            }
          
   }
   
  public function getAllProducts($food){
      
       $sql = "SELECT products.product_name, products.description, products.product_picture FROM products
               INNER JOIN food_products ON products.product_name = food_products.product_name
               WHERE food_products.food_name = :food";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ':food' => $food,
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
            if(count($data) ==  ZERO)
            {
               //error messa here
                $erMessage = ZERO;
                echo json_encode($erMessage);
            }
            else
            {
                
              echo json_encode($this->loadAllProducts($data));
            
            }
  }
   
   function getProductEatWith($product_name, $country)
   {
         $country_id = $this->getCountryID($country);
         $product_id = $this->getProductId($product_name);
        
        $Sql = "SELECT eatWith, type FROM product_eatwith WHERE product_id = :productId AND country_id = :countryId LIMIT 0, 8";
        
        $sth = $this->db->Sdb->prepare($Sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":productId" => $product_id,
            ":countryId" => $country_id
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        
        echo json_encode($this->loadProductEatWith($data, $product_name));
   }
   
   function getAllProductEatWith($product_name)
   {
         
        $product_id = $this->getProductId($product_name);
        
        $Sql = "SELECT eatWith, type FROM product_eatwith WHERE product_id = :productId  LIMIT 0, 8";
        
        $sth = $this->db->Sdb->prepare($Sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":productId" => $product_id,
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        
        echo json_encode($this->loadProductEatWith($data, $product_name));
   }
   
   private function loadProductEatWith($data, $product_name){
       $output = '';//'<b class ="EWheader">Combine or Eat '.$product_name.' With</b><br>';
       for($looper =0; $looper< count($data); $looper++){
           $output .= '<span class="eatWith_name">'.$data[$looper]['eatWith'].'       </span><img class ="EWarrow" src="'.URL.'pictures/arrow.png" width="20" height="10"><span class="eatwithType">   '.$data[$looper]['type'].'</span><br>';
       }
       
       return $output;
   }
   
   private function loadProducts($data)
   {
       $output = '';
       for($i = 0; $i < count($data); $i++){
           
            $output .='<div class="prodList">
                      <div class="productImage"><img src="data:image/jpeg;base64,'.base64_encode($data[$i]['product_picture']).' " width="50px" height="50px"></div>
                      <div class="productName">'.$data[$i]['product_name'].'</div>
                      <div class="HowItsMade"><a href="">How its Made</a></div>
                      <div class="prodductInfo">'.$data[$i]['description'].'</div>
                      <ul class="eatwith">
                      <li onclick="tooltipProd(\''.$i.'\', \''.$data[$i]['country_names'].'\', \''.$data[$i]['product_name'].'\')"><img class="EWimg" src="'.URL.'pictures/navigationbar/ENRI_EATWITH_SMALL.png" width="15" height="15" title="food/products you could combine or eat with '.$data[$i]['product_name'].'" ><div class="TOOLTIPProd"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERProd"></div></li>
                      </ul>
                   </div>';
            
       }
       
      return  $output;
   }
   
   private function loadAllProducts($data)
   {
       $output = '';
       for($i = 0; $i < count($data); $i++){
           
            $output .='<div class="prodList">
                      <div class="productImage"><img src="data:image/jpeg;base64,'.base64_encode($data[$i]['product_picture']).' " width="50px" height="50px"></div>
                      <div class="productName">'.$data[$i]['product_name'].'</div>
                      <div class="HowItsMade"><a href="">How its Made</a></div>
                      <div class="prodductInfo">'.$data[$i]['description'].'</div>
                      <ul class="eatwith">
                      <li onclick="tooltipAllProd(\''.$i.'\', \''.$data[$i]['product_name'].'\')"><img class="EWimg" src="'.URL.'pictures/navigationbar/ENRI_EATWITH_SMALL.png" width="15" height="15" title="food/products you could combine or eat with '.$data[$i]['product_name'].'" ><div class="TOOLTIPProd"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERProd"></div></li>
                      </ul>
                   </div>';
            
       }
       
      return  $output;
   }
   
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::

  
     private function getFoodFollowsAndFollowCount($foods)
    {
        $foodFollow_count = array();
        
        
        for($looper = 0; $looper < count($foods); $looper++){
            
            $food_id = $foods[$looper]['food_id'];
          
        
            if($this->isUserFollowFood($this->id, $food_id)){
                $foodFollow_count[$looper]['food_follow'] =  $src = URL."pictures/foods/ufollow.png";
                $foodFollow_count[$looper]['food_follow_title'] = "unfollow ".$foods[$looper]["food_name"];
            }
            else{
                $foodFollow_count[$looper]['food_follow'] = URL."pictures/foods/follow.png";
                $foodFollow_count[$looper]['food_follow_title'] = "follow ".$foods[$looper]["food_name"];
            }

            $foodFollow_count[$looper]['follow_count'] = $this->getFollowFoodCount($food_id);
        }
        return $foodFollow_count;
    }
    
       private function isUserFollowFood($user_id, $food_id)
       {
               $sql = "SELECT user_id FROM food_follow WHERE  food_id= :food_id AND user_id = :user_id";
               $sth = $this->db->prepare($sql);
               $sth->setFetchMode(PDO::FETCH_ASSOC);
               $sth->execute(array(
                   ":food_id" => $food_id,
                   ":user_id" =>$user_id,
               ));

               $data = $sth->fetchAll(PDO::FETCH_ASSOC);

               if(count($data)===0)
               {
                   return false;
               }
               else 
               {
                   return true;
               }
     }
    
    private function getFollowFoodCount($food_id)
    {
        $sql = "SELECT * FROM food_follow WHERE food_id = :food_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':food_id'=>$food_id));
        
        $foodFollowCount = $sth->fetchAll();
        
        return count($foodFollowCount);
                
    }
    
    function getOtherCountry($foods)
    {
        $otherCountries = array();
        $output = '';
        
        for($looper = 0; $looper < count($foods); $looper++){
            
                $food_name = $foods[$looper]['food_name'];
            
            
               $sql = "SELECT country_names FROM food_country WHERE food_name = :food";

               $sth = $this->db->Sdb->prepare($sql);
               $sth->setFetchMode(PDO::FETCH_ASSOC);
               $sth->execute(array(
                   ':food' => $food_name
               ));
                $data = $sth->fetchAll(PDO::FETCH_ASSOC);
                for($i=0; $i < count($data); $i++)
                {

                       $output .= "<div style='margin-bottom: 5px;'>".$data[$i]['country_names'] ."</div>";
                    
                }
               
                $otherCountries[$looper] = $output;
                 $output = '';
        }

        return $otherCountries;
   }

   
   function InsertFollowFoodAll($food_id)
   {
 
      $result = '';
      $country_ids = $this->getAllFoodCountries($food_id);
      //echo var_dump($country_ids);
      for($looper = 0; $looper < count($country_ids); $looper++){
          $result = $this->insertOrDelete($this->id, $food_id, $country_ids[$looper]['country_id']);
      }
       echo json_encode($result);
   }
   
   function insertOrDelete($user_id, $food_id, $country_id){
       $delete = 'DELETED';
       $insert = 'INSERTED';
         if($this->isFollowFood($user_id, $food_id, $country_id)){
           //delet
           $sql = "DELETE FROM food_follow WHERE user_id =:user_id AND food_id= :food_id AND country_id= :country_id";
                $sth = $this->db->prepare($sql);
               if($sth->execute(array(
                    ":user_id" => $user_id,
                    ":food_id" => $food_id,
                    ":country_id" => $country_id
                )))
               {
                   return $delete;
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
                    ":user_id" => $user_id,
                    ":food_id" => $food_id,
                    ":country_id" => $country_id
                )))
               {
                   return $insert;
               }
               else
               {
                   echo json_encode("NOT INSERTED");
               }
       }
     
   }
   
   private function getAllFoodCountries($food_id){
       $food_name = $this->getFoodName($food_id);
       $sql = "SELECT C.country_id FROM food_country AS FC
               INNER JOIN country AS C ON C.country_names = FC.country_names 
               WHERE FC.food_name = :food_name";
       $sth = $this->db->Sdb->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(':food_name'=>$food_name));
       
       $country_ids = $sth->fetchAll();
       
       return $country_ids;
   }
   
   
    private function isFollowFood($user_id, $food_id, $country_id)
    {
        $sql = "SELECT user_id FROM food_follow WHERE  food_id= :food_id AND user_id = :user_id AND country_id = :country_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ":food_id" => $food_id,
           ":user_id" =>$user_id,
           ":country_id"=>$country_id
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       if(count($data)===0)
       {
           return false;
       }
       else 
       {
           return true;
       }
    }
    
    public function getFoodFollowersAll($food_id){
        echo json_encode($this->view->foodFollowSurfix($this->getFollowFoodCount($food_id)));
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

    
   
    

    
  
    
  
   
  
    
    
  

    
}//end of class