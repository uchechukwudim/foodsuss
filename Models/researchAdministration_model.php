<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reseachAdministration_model
 *
 * @author Uche
 */
class researchAdministration_model extends Model {
    //put your code here
    function __construct() {
        parent::__construct();
       
          $this->id = -1;
          $this->email = '';
    }
    
    public function loginRequest($email, $password){
        header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        
        $message = '';
        
        $sql = "SELECT user_email FROM research_users WHERE user_email = :user_email AND password = :password";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_email' => $email, ':password'=>  md5($password)));
        $request = $sth->fetchAll();
        
        if(count($request) === ZERO){
            $message = 'wrong email or password';
            echo json_encode($message);
        }else{
            Session::init();
            Session::set('researcher_loggedIn', true);
            Session::set('researcher_user', filter_var($email));
            $this->email = $email;
            echo json_encode(true);
        }
    }
    
    public function processPutFoodRequest($foodName, $foodDesc,  $nutrients, $foodType, $temp_Origins, $imageData, $imageName){
        $sql = "SELECT food_id FROM  food WHERE food_name = :food_name AND food_description = :food_description
                 AND food_picture = :food_picture AND Nutrients = :Nutrients AND foodType_name = :foodType_name";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':food_name'=>$foodName,
                            ':food_description'=>$foodDesc,
                            ':food_picture'=>$imageData,
                            ':Nutrients'=> $nutrients,
                            ':foodType_name' =>$foodType));
        
        $result = $sth->fetchAll();
        if(count($result) > ZERO){
            echo json_encode("Food already exist");
        }else{
            $this->insertIntoFood($foodName, $foodDesc, $nutrients, $foodType, $imageData, $imageName, $temp_Origins);
           
        }
    }
    
    public function processExistingPutFoodRequest($foodName, $foodOrigins){
         $this->InserIntoFoodCountry($foodOrigins, $foodName);
    }
    
    private function insertIntoFood($foodName, $foodDesc,  $nutrients, $foodType, $imageData, $imageName, $temp_Origins){
        $sql = "INSERT INTO food VALUES (:food_id, :food_name, :food_description, :food_picture, :Nutrients, :foodType_name, :user_email)";
        $sth = $this->db->Sdb->prepare($sql);
        
        //insert into databse enri food table
        if($sth->execute(array(':food_id'=>'',
                               ':food_name'=>$foodName,
                               ':food_description'=>$foodDesc,
                               ':food_picture'=>$imageData,
                               ':Nutrients'=> $nutrients,
                               ':foodType_name'=>$foodType,
                               ':user_email'=>$this->email))){
            
             $this->InserIntoFoodCountry($temp_Origins, $foodName);
             
               //insert into database user_enri food table
                $sthh = $this->db->prepare($sql);

                //insert into databse enri food table
                $sthh->execute(array(':food_id'=>'',
                                        ':food_name'=>$foodName,
                                        ':food_description'=>$foodDesc,
                                        ':food_picture'=>$imageData,
                                        ':Nutrients'=> $nutrients,
                                        ':foodType_name'=>$foodType,
                                        ':user_email'=>$this->email));
                       
                 
                    
        }else{
            echo json_encode('Something went wrong please try again later');
        }
        
        
    }
    
    private function InserIntoFoodCountry($foodOrigins, $foodName){
       foreach ($foodOrigins as $value) {
              $this->prepareStat($foodName, $value->{"country_name"}, $value->{"description"});
        }
         echo json_encode(true);  
    }
    
    private function prepareStat($foodName, $countryName, $countryFoodDesc ){
        $sql = "INSERT INTO food_country VALUES (:food_country_id, :food_name, :country_names, :country_food_description)";
        
        $sth = $this->db->Sdb->prepare($sql);
        $sth->execute(array(':food_country_id'=>'',
                            ':food_name'=>$foodName,
                            ':country_names' =>$countryName,
                            ':country_food_description'=>$countryFoodDesc));
        
        $sthh = $this->db->prepare($sql);
        $sthh->execute(array(':food_country_id'=>'',
                            ':food_name'=>$foodName,
                            ':country_names' =>$countryName,
                            ':country_food_description'=>$countryFoodDesc));
         
    }
    
    
    
    
    public function processPutRecipeRequest($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName){
        if($this->isRecipeExist($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName)){
              echo json_encode("Recipe already exist");
        }else{
            $this->insertIntoRecipe($recipeTitle, $recInstruction, $healthBenefit, $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName);
        }
    }
    
    private function isRecipeExist($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName){
        $sql = "SELECT recipe_id FROM recipes WHERE recipe_title = :recipe_title AND ingridients = :ingridients AND
                cook = :cook AND health_benefits = :health_benefits AND recipe_photo = :recipe_photo AND meal_type = :meal_type
                AND food_id = :food_id AND country_id = :country_id";
        
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_title'=>$recipeTitle,
                            ':ingridients'=>$ingredients,
                            ':cook'=>$recInstruction,
                            ':health_benefits' => $healthBenefit,
                            ':recipe_photo' => $imageData,
                            ':meal_type' => $mealType,
                            ':food_id' => $this->getFoodId($baseFood),
                            ':country_id' => $this->getCountryID($baseCountry)));
        $resuslt = $sth->fetchAll();
        
        if(count($resuslt) > ZERO){
            return true;
        }else{
            return false;
        }
    }
    
    private function insertIntoRecipe($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName){
        $sql = "INSERT INTO recipes VALUES (:recipe_id, :recipe_title, :ingridients, :cook, :health_benefits, :recipe_photo, :meal_type, :user_email, :food_id, :country_id, :time)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(':recipe_id' =>'',
                                ':recipe_title'=>$recipeTitle,
                                ':ingridients'=>$ingredients,
                                ':cook'=>$recInstruction,
                                ':health_benefits' => $healthBenefit,
                                ':recipe_photo' => $imageData,
                                ':meal_type' => $mealType,
                                ':user_email' => $this->email,
                                ':food_id' => $this->getFoodId($baseFood),
                                ':country_id' => $this->getCountryID($baseCountry),
                                ':time' => time()))){
            $recipe_id = $this->getThisRecipeId($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName);
            $this->insertIntoFoodRecipes($recipe_id, $baseFood, $baseCountry);
            
            $sthh = $this->db->prepare($sql);
            $sthh->execute(array(':recipe_id' =>'',
                                ':recipe_title'=>$recipeTitle,
                                ':ingridients'=>$ingredients,
                                ':cook'=>$recInstruction,
                                ':health_benefits' => $healthBenefit,
                                ':recipe_photo' => $imageData,
                                ':meal_type' => $mealType,
                                ':user_email' => $this->email,
                                ':food_id' => $this->getFoodId($baseFood),
                                ':country_id' => $this->getCountryID($baseCountry),
                                ':time' => time()));
        }else{
            echo json_encode($sth->errorInfo());
        }
        
    }
    
    private function insertIntoFoodRecipes($recipe_id, $foodName, $country_name){
        $sql = "INSERT INTO foods_recipes VALUES (:foods_recipes_id, :recipe_id, :food_name, :country_names)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(':foods_recipes_id' => '',
                            ':recipe_id' => $recipe_id,
                            ':food_name' => $foodName,
                            ':country_names' => $country_name))){
            echo json_encode(true);
        }else{
            echo json_encode("Could not insert into food_recipe table, but inserted data into recipe table");
        }
    }
    
     private function getThisRecipeId($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName){
        $sql = "SELECT recipe_id FROM recipes WHERE recipe_title = :recipe_title AND ingridients = :ingridients AND
                cook = :cook AND health_benefits = :health_benefits AND recipe_photo = :recipe_photo AND meal_type = :meal_type
                AND food_id = :food_id AND country_id = :country_id";
        
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':recipe_title'=>$recipeTitle,
                            ':ingridients'=>$ingredients,
                            ':cook'=>$recInstruction,
                            ':health_benefits' => $healthBenefit,
                            ':recipe_photo' => $imageData,
                            ':meal_type' => $mealType,
                            ':food_id' => $this->getFoodId($baseFood),
                            ':country_id' => $this->getCountryID($baseCountry)));
        $resuslt = $sth->fetchAll();
        
        return $resuslt[ZERO]['recipe_id'];
    }
    
    public function processPutProductRequest($productName,  $description, $foodName,  $countryName, $eatwith, $imageData, $imageName){
        if($this->isProductExist($productName,  $description, $imageData)){
            echo json_encode("Product already exist");
        }else{
            $this->insertIntoProduct($productName, $description, $foodName, $countryName, $eatwith, $imageData, $imageName);
        }
    }
    
    public function processPostPutProductEatwithRequest($productName, $foodName, $countryName,  $eatwith){
        $product_id = $this->getProductId($productName);
        $country_id = $this->getCountryID($countryName);
        if($product_id === EMPTYSTRING){
            echo json_encode("Product ".$productName." does not exist. you cannot post eatwith for product that does not exist");
        }else{
            $this->insertIntoProductEatwith($product_id, $country_id, $eatwith);
        }
    }


    private function insertIntoProduct($productName,  $description, $foodName,  $countryName,  $eatwith, $imageData, $imageName){
        $sql = "INSERT INTO products VALUES (:product_id, :product_name, :description, :product_picture)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(':product_id' => '',
                            ':product_name' => $productName,
                            ':description' => $description,
                            ':product_picture' => $imageData))){
                    $this->insertIntoFoodProduct($productName, $foodName, $description, $imageData, $countryName, $eatwith);
                            
                    $sthh = $this->db->prepare($sql);
                    $sthh->execute(array(':product_id' => '',
                            ':product_name' => $productName,
                            ':description' => $description,
                            ':product_picture' => $imageData));
                    
        }else{
            echo json_encode("Something went wrong please try again later");
        }
    }
    
    private function insertIntoFoodProduct($productName, $foodName, $description,  $imageData, $countryName, $eatwith){
        $sql = "INSERT INTO food_products VALUES (:food_products_id, :product_name, :food_name, :country_names)";
        $sth = $this->db->Sdb->prepare($sql);
        if($sth->execute(array(':food_products_id' => '',
                               ':product_name' => $productName,
                               ':food_name' => $foodName,
                               ':country_names' => $countryName))){

                 $product_id = $this->getThisProductId($productName,  $description, $imageData);
                 $country_id = $this->getCountryID($countryName);
                 $this->insertIntoProductEatwith($product_id, $country_id, $eatwith);

                 $sthh = $this->db->prepare($sql);
                 $sthh->execute(array(':food_products_id' => '',
                               ':product_name' => $productName,
                               ':food_name' => $foodName,
                               ':country_names' => $countryName));
            
            
        }else{
            echo json_encode($sth->errorInfo());
        }
    }
    
    private function insertIntoProductEatwith($product_id, $country_id, $eatwith){
        
        foreach ($eatwith as $value) {
             $sql = "INSERT INTO product_eatwith VALUES (:product_eatWith_id, :product_id, :eatWith, :type, :country_id)";
             $sth = $this->db->Sdb->prepare($sql);
             if($sth->execute(array(':product_eatWith_id' => '',
                                 ':product_id' => $product_id,
                                 ':eatWith' => $value->{'Ew'},
                                 ':type' => $value->{'type'},
                                 ':country_id' => $country_id))){
                                     echo json_encode(true);
                                 }else{
                                     echo json_encode($sth->errorInfo());
                                 }
                                    
                                 
        }
       
    }
    
    
    private function isProductExist($productName,  $description, $imageData){
        $sql = "SELECT product_id FROM products WHERE product_name = :product_name AND description = :description
                AND product_picture = :product_picture";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':product_name'=>$productName,
                            ':description'=>$description,
                            ':product_picture'=> $imageData));
        $result = $sth->fetchAll();
        
        if(count($result) > ZERO){return true;}else{return false;} 
    }
    
    private function getThisProductId($productName,  $description, $imageData){
        $sql = "SELECT product_id FROM products WHERE product_name = :product_name AND description = :description
                AND product_picture = :product_picture";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':product_name'=>$productName,
                            ':description'=>$description,
                            ':product_picture'=> $imageData)
                );
        $result = $sth->fetchAll();
        
        return $result[ZERO]['product_id'];
    }
    
    
    
    
    
     public function recipeOriginSearch($search_val, $index){
          $sql = "SELECT country_names FROM country WHERE country_names LIKE '%$search_val%'";
                $sth = $this->db->Sdb->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();
                $searchResult = $sth->fetchAll();
               
         if($index === EMPTYSTRING){
             echo $this->loadResultRecipeOrigin($searchResult); 
         }else{
             echo $this->loadResultRecipeOriginWithIndex($searchResult, $index);
         }
         
     
     }
      private function loadResultRecipeOriginWithIndex($searchResult, $index){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuCountry(\''.$searchResult[$looper]['country_names'].'\', \''.$index.'\')">'.$searchResult[$looper]['country_names'].'</div>';
         }
         
         return $output;
     }
     
     private function loadResultRecipeOrigin($searchResult){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuCountry(\''.$searchResult[$looper]['country_names'].'\')">'.$searchResult[$looper]['country_names'].'</div>';
         }
         
         return $output;
     }
     
      public function baseFoodSearch($search_val){
         $sql = "SELECT food_name FROM food WHERE food_name LIKE '%$search_val%'";
         $sth = $this->db->Sdb->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
         $searchResult = $sth->fetchAll();
         
         echo $this->loadResultBaseFood($searchResult);
     }
     
     private function loadResultBaseFood($searchResult){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuBaseFood(\''.$searchResult[$looper]['food_name'].'\')">'.$searchResult[$looper]['food_name'].'</div>';
         }
         
         return $output;
     }
     
     public function baseProductSearch($search_val){
         $sql = "SELECT product_name FROM products WHERE product_name LIKE '%$search_val%'";
         $sth = $this->db->Sdb->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
         $searchResult = $sth->fetchAll();
         echo $this->loadResultBaseProduct($searchResult);
     }
     
     private function loadResultBaseProduct($searchResult){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuBaseProduct(\''.$searchResult[$looper]['product_name'].'\')">'.$searchResult[$looper]['product_name'].'</div>';
         }
         
         return $output;
     }
     
     public function processBaseRecipeSearch($search_val){
         $sql = "SELECT recipe_title FROM recipes WHERE recipe_title LIKE '%$search_val%'";
         $sth = $this->db->Sdb->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
         $searchResult = $sth->fetchAll();
         echo $this->loadResultConfirmSearch($searchResult);
     }
     
      private function loadResultConfirmSearch($searchResult){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuConfirmSearch(\''.$searchResult[$looper]['recipe_title'].'\')">'.$searchResult[$looper]['recipe_title'].'</div>';
         }
         
         return $output;
     }
     
        public function getEmailsCode(){
            $sql = "SELECT Urs.user_email, Urs.status, Urs.signup_code, UD.FirstName FROM users AS Urs
                    INNER JOIN user_details AS UD ON Urs.user_id = UD.user_id
                    WHERE Urs.status = :status AND UD.user_type != 'Restaurant'

                    UNION

                    SELECT Urs.user_email, Urs.status, Urs.signup_code, RU.restaurant_name FROM users AS Urs
                    INNER JOIN restaurant_users AS RU ON Urs.user_id = RU.user_id
                    WHERE Urs.status = :status
                    ";
            
            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(':status' => ZERO));

            $result = $sth->fetchAll();
            
            return $result;
        }
        
        
        public function processPostArticleRequest($artTitle,  $artWriteup, $artLink, $artDes, $artTags, $image){
            
            if(!checkforExistingArticle($artTitle,  $artWriteup, $artDes, $artTags, $image)){
                $this->insertIntoArticle($artTitle, $artWriteup, $artLink, $artDes, $artTags, $image);
            }else{
                echo json_encode("Article Already Exist");
            }
            
        }
        
        private function insertIntoArticle($artTitle,  $artWriteup, $artLink, $artDes, $artTags, $image){
            $sql = "INSERT INTO articles VALUES (:article_id, :article_title, :article, :article_desc, 
                    :article_link, :user_id, :article_picture_cover, :timestamp, :tags, :views_count)";
            $sth = $this->db->prepare($sql);
            if($sth->execute(array(':article_id' => "",
                                   ':article_title' => $artTitle,
                                   ':article' => $artWriteup,
                                   'article_desc' => $artDes,
                                   ':article_link' => $artLink,
                                   ':user_id' => $this->id,
                                   ':article_picture_cover' => $image,
                                   ':timestamp' => time(),
                                   ':tags' => $artTags,
                                   ':views_count' => ZERO))){
                echo json_encode(true);
            }else{
                echo json_encode($sth->errorInfo());
            }
        }
        private function checkforExistingArticle($artTitle,  $artWriteup, $artDes, $artTags, $image){
            $sql = "SELECT article_id FROM articles WHERE article_title = :artTitle AND article = :article
                    AND article_desc = :artDes AND article_link = :article_link  AND user_id = :user_id
                    AND tags = :tags AND article_picture_cover =:article_picture_cover";
            $sth = $this->db->prepare($sql);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute(array(':artTitle' => $artTitle,
                                ':article' => $artWriteup,
                                'artDesc' => $artDes,
                                ':user_id' => ZERO,
                                ':tags' => $artTags,
                                ':article_picture_cover' => $image));
            $result = $sth->fetchAll();
            
            if(count($result) === ZERO){
                return true;
            }else{
                return false;
            }
        }
}
