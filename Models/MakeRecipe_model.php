<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MakeRecipe_model
 *
 * @author Uche
 */
class MakeRecipe_model extends Model {
    //put your code here
    function __construct()
     {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
     }
     
     public function index(){
         
         $this->view->js = array();
         
         $this->view->css = array( 'css/cook/new/style.css');
         $fileName = "cook/new/index";
         $this->view->renderMakeRecipe($fileName);
     }
     
     public function processRecipePosted($mealType, $baseFood, $recipeOrigin, $recipeTitle, $recInstruction, $ingredients, $imageData, $imageName){
         
         $sql = 'SELECT recipe_post_id FROM recipe_post WHERE user_id = :user_id AND  recipe_title = :recipe_title AND how_its_made = :HIM AND country_id = :country_id AND food_id = :food_id AND recipe_pwi_active = :FALSE';
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(":user_id" => $this->id,
                             ":recipe_title"=>$recipeTitle,
                             ":HIM" => $recInstruction,
                             ":country_id" => $this->getCountryID($recipeOrigin),
                             ":food_id" => $this->getFoodId($baseFood),
                             ":recipe_pwi_active" => 'FALSE'));
         
         $result = $sth->fetchAll();
         
         if(count($result) === ZERO){
             $SQL = "INSERT INTO recipe_post VALUES (:recipe_post_id, :recipe_title, :how_its_made, :ingredients, :health_facts, :recipe_photo, :meal_type, :user_id, :food_id, :country_id, :post_time, :recipe_pwi_active)";
             $STH = $this->db->prepare($SQL);
             if($STH->execute(array(
                 ":recipe_post_id" => '',
                 ":recipe_title" => $recipeTitle,
                 ":how_its_made" => $recInstruction,
                 ":ingredients"=>$ingredients,
                 ":health_facts" => '',
                 ":meal_type" => $mealType,
                 ":recipe_photo" => $imageData,
                 ":user_id" => $this->id,
                 ":food_id" => $this->getFoodId($baseFood),
                 ":country_id" => $this->getCountryID($recipeOrigin),
                 ":post_time" => time(),
                 ":recipe_pwi_active" => 'FALSE'
             ))){
                   echo json_encode(true);
             }
             else{
                 echo json_encode($STH->errorInfo());
             }
         }else{
             $message = "You are trying post same recipe twice.";
             echo json_encode($message);
         }
     }
     
     
    public function processRecipePWI($mealType, $baseFood, $recipeOrigin, $recipeTitle, $ingredients, $imageData, $imageName){
         
        $sql = 'SELECT recipe_post_id FROM recipe_post WHERE user_id = :user_id AND  recipe_title = :recipe_title AND how_its_made = :HIM AND country_id = :country_id AND food_id = :food_id AND recipe_pwi_active = :recipe_pwi_active';
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(":user_id" => $this->id,
                             ":recipe_title"=>$recipeTitle,
                             ":HIM" => EMPTYSTRING,
                             ":country_id" => $this->getCountryID($recipeOrigin),
                             ":food_id" => $this->getFoodId($baseFood),
                             ":recipe_pwi_active" => 'TRUE'));
         
         $result = $sth->fetchAll();
         
         if(count($result) === ZERO){
             $SQL = "INSERT INTO recipe_post VALUES (:recipe_post_id, :recipe_title, :how_its_made, :ingredients, :health_facts, :recipe_photo, :meal_type, :user_id, :food_id, :country_id, :post_time, :recipe_pwi_active)";
             $STH = $this->db->prepare($SQL);
             $time = time();
             if($STH->execute(array(
                 ":recipe_post_id" => '',
                 ":recipe_title" => $recipeTitle,
                 ":how_its_made" => EMPTYSTRING,
                 ":ingredients"=>$ingredients,
                 ":health_facts" => '',
                 ":meal_type" => $mealType,
                 ":recipe_photo" => $imageData,
                 ":user_id" => $this->id,
                 ":food_id" => $this->getFoodId($baseFood),
                 ":country_id" => $this->getCountryID($recipeOrigin),
                 ":post_time" => $time,
                 ":recipe_pwi_active" => 'TRUE'
             ))){
                            $sql = 'SELECT recipe_post_id FROM recipe_post WHERE user_id = :user_id AND  '
                                    . 'recipe_title = :recipe_title AND how_its_made = :HIM AND '
                                    . 'country_id = :country_id AND food_id = :food_id AND '
                                    . 'recipe_pwi_active = :recipe_pwi_active AND '
                                    . 'recipe_photo = :recipe_photo AND'
                                    . ' post_time = :post_time';
                            $sth = $this->db->prepare($sql);
                            $sth->setFetchMode(PDO::FETCH_ASSOC);
                            $sth->execute(array(":user_id" => $this->id,
                                                ":recipe_title"=>$recipeTitle,
                                                ":HIM" => EMPTYSTRING,
                                                ":country_id" => $this->getCountryID($recipeOrigin),
                                                ":food_id" => $this->getFoodId($baseFood),
                                                ":recipe_pwi_active" => 'TRUE',
                                                ":recipe_photo" => $imageData,
                                                ":post_time"=>$time));

                             $result = $sth->fetchAll();
                             $result[ZERO]['istrue'] = true;
                              echo json_encode($result);
             }
             else{
                   echo json_encode($STH->errorInfo());
             }
         }else{
                  $message = "You are trying post same recipe twice.";
                  echo json_encode($message);
         }
     }
     
     public function processStepsPWI($recipe_post_id, $textDesc, $imageData, $count){
         $sql = 'INSERT INTO recipe_pwi VALUE (:recipe_pwi_id, :recipe_image, :recipe_image_direction, :step_count, :recipe_post_id)';
         $sth = $this->db->prepare($sql);
         if($sth->execute(array(':recipe_pwi_id' => EMPTYSTRING,
                             ':recipe_image' => $imageData,
                             ':recipe_image_direction' => $textDesc,
                             ':step_count' => $count,
                             ':recipe_post_id' => $recipe_post_id))){
             echo json_encode(true);
         }else{
             echo $sth->errorInfo();
         }
     }
     
     
     
     public function baseFoodSearch($search_val){
         $sql = "SELECT food_name FROM food WHERE food_name LIKE '%$search_val%'";
         $sth = $this->db->prepare($sql);
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
     
     public function recipeOriginSearch($search_val){
         $sql = "SELECT country_names FROM country WHERE country_names LIKE '%$search_val%'";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
         $searchResult = $sth->fetchAll();
         
         echo $this->loadResultRecipeOrigin($searchResult);
     }
      private function loadResultRecipeOrigin($searchResult){
         $output = '';
         for($looper = 0; $looper < count($searchResult); $looper++){
             $output .= '<div class="BaseFoodOrigin" onclick="collectValuCountry(\''.$searchResult[$looper]['country_names'].'\')">'.$searchResult[$looper]['country_names'].'</div>';
         }
         
         return $output;
     }
     
     public function viewRecipe($recipe_post_id, $recipeName){
         
         $rest = "Restaurant";
         $fileName = "cook/viewrecipe/index";
 
         $sql = "SELECT recipe_title, description, ingredients, health_facts, preparation_time, cooking_time, recipe_photo, meal_type, user_id FROM recipe_post WHERE recipe_post_id = :recipe_post_id AND recipe_title = :recipe_title";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(":recipe_post_id" => $recipe_post_id,
                             ":recipe_title" =>$recipeName));
         
         $recipe = $sth->fetchAll();
         
         $sql1 = "SELECT recipe_post_steps_id, step FROM recipe_post_cook_steps WHERE recipe_post_id = :recipe_post_id";
         $sth1 = $this->db->prepare($sql1);
         $sth1->setFetchMode(PDO::FETCH_ASSOC);
         $sth1->execute(array(":recipe_post_id"));
         $recipe_steps = $sth1->fetchAll();
         
         $user_name = $this->getUserFLNameOrRestNameOrEstName($user_id);
         $user_photo = $this->getUserImage($user_id);
         
         $this->view->renderViewRecipe($fileName, $recipe, $recipe_steps, $user_name, $user_photo);
     }
}
