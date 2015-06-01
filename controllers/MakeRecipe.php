<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MakeRecipe
 *
 * @author Uche
 */
class MakeRecipe extends Controller {
    //put your code here
    function __construct() {
          parent::__construct();
          $this->sessionCheck();
          
          
    }
    
    public function index(){
            $this->model->index();
    }
    
    public function processRecipePosted(){
        $exploadWith = '.';
          $temp_ingredients = array();
         if(isset($_FILES))
         {
             $file_name = $_FILES['file']['name'];
             $exp_name = explode($exploadWith , $file_name);
             $ext = end($exp_name);
             $file_ext = strtolower($ext);
             $file_size = $_FILES['file']['size'];
             $file_temp = $_FILES['file']['tmp_name'];
             
             if($this->processImage($file_name, $file_ext, $file_size, $file_temp))
             {
                 $imageData = file_get_contents( $_FILES['file']['tmp_name']);
                 $imageName = $file_name;
                 $mealType = $_POST['mealtype'];
                 $baseFood = $_POST['basefood'];
                 $recipeOrigin = $_POST['recipeorigin'];
                 $recipeTitle = $_POST['recipetitle'];
                 $recInstruction = $_POST['instruction'];
                 $temp_ingredients = json_decode(stripslashes($_POST['ingredients']));
                 $ingredients = $this->concatIngre((array)$temp_ingredients);
                 $this->model-> processRecipePosted($mealType, $baseFood, $recipeOrigin, $recipeTitle, $recInstruction, $ingredients, $imageData, $imageName);
             }
         }
    }
    
    public function processRecipePWI(){
        $exploadWith = '.';
          $temp_ingredients = array();
         if(isset($_FILES))
         {
            
             $file_name = $_FILES['recipePicUpload']['name'];
             $exp_name = explode($exploadWith , $file_name);
             $ext = end($exp_name);
             $file_ext = strtolower($ext);
             $file_size = $_FILES['recipePicUpload']['size'];
             $file_temp = $_FILES['recipePicUpload']['tmp_name'];
             
             if($this->processImage($file_name, $file_ext, $file_size, $file_temp))
             {
                 $imageData = file_get_contents( $_FILES['recipePicUpload']['tmp_name']);
                 $imageName = $file_name;
                 $mealType = $_POST['mealtype'];
                 $baseFood = $_POST['basefood'];
                 $recipeOrigin = $_POST['recipeorigin'];
                 $recipeTitle = $_POST['recipetitle'];
                 $temp_ingredients = json_decode(stripslashes($_POST['ingredients']));
                 $ingredients = $this->concatIngre((array)$temp_ingredients);
                 $this->model->processRecipePWI($mealType, $baseFood, $recipeOrigin, $recipeTitle, $ingredients, $imageData, $imageName);
             }
         }
    }
    
    private function concatIngre($ingredient){
        $ingres = '';
        
        foreach ($ingredient as $value) {
            $ingres .= '<p>'.$value->{"Qty"}.' '.$value->{"ingredient"}.'</p>';
        }
        
        return $ingres;
    }
    
    public function processStepsPWI(){
      
        if(isset($_FILES)){
              $idname = $_POST['img_id_name'];
              $imageData = file_get_contents($_FILES[$idname]['tmp_name']);
              $recipe_post_id = $_POST['recipe_post_id'];
              $textDesc = $_POST['textDesc'];
              $count = $_POST['counter'];
            
              $this->model->processStepsPWI($recipe_post_id, $textDesc, $imageData, $count);
        }
    }
    
    public function processBaseFoodSearch(){
        $search_val = $_POST['basefood'];
        $this->model->baseFoodSearch($search_val);
    }
    public function processRecipeOriginSearch(){
        $search_val = $_POST['recipeOrigin'];
        $this->model->recipeOriginSearch($search_val);
    }
    
    
    public function view($encrypted_id, $recipeName){
        $recpe_post_id= $this->decrypt($encrypted_id);
        $this->model->viewRecipe($recpe_post_id, $recipeName);
    }
    

}
