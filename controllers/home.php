<?php

class Home extends Controller{

    function __construct() {
          parent::__construct();
          $this->sessionCheck();  
    }
    
    public function index()
    {
         //$foodShopSearch = new FoodShopSearcher();
        //$this->loadModel('home');
       $this->model->index();

    }
    
    public function homeRecipeSteps($recipe_post_id, $recipeName){
        $rp_id = $this->decrypt($recipe_post_id);
        $modelName = "RecipeSteps";
        $this->loadModel($modelName);
        $this->model->homeRecipeSteps($rp_id, $recipeName);
    } 
    
    public function getCountryFoodName()
    {
        if(isset($_POST['food_id']) && isset($_POST['country_id'])){
               $foodId = $_POST['food_id'];
               $countryId = $_POST['country_id'];
               $this->model->getCountryFoodName($foodId, $countryId);
        }else{
             header('location:'.URL.'home');
        }
       
       
      
    }
    
    public function getTasty()
    {
        if(isset($_POST['recipe_post_id'])){
             $recipe_post_id = $_POST['recipe_post_id'];
            $this->model->getTasty($recipe_post_id);
        }else{
             header('location:'.URL.'home');
        }
       
    }
     function getCookedit()
    {
         if(isset($_POST['recipe_post_id'])){
             $recipe_post_id = $_POST['recipe_post_id'];
            $this->model->getCookedit($recipe_post_id);
         }else{
             header('location:'.URL.'home');
        }
        
    }

    public function getShare()
    {
        if(isset($_POST['recipe_post_id'])){
             $recipe_post_id = $_POST['recipe_post_id'];
            $this->model->getShare($recipe_post_id);
        }else{
             header('location:'.URL.'home');
        }
       
    }


    public function insertTCS()
    {
        if(isset($_POST['user_id']) && isset($_POST['recipe_post_id']) && isset($_POST['owner_user_id']) && isset($_POST['tableName'])){
            $user_id =  $_POST['user_id'];
            $recipe_post_id = $_POST['recipe_post_id'];
            $recipe_owner_user_id = $_POST['owner_user_id'];
            $tableName = $_POST['tableName'];
      
            $this->model->insertTCS($user_id, $recipe_owner_user_id,  $recipe_post_id, $tableName);
        }else{
             header('location:'.URL.'home');
        }
      
    }
    
    public function postUserComment()
    {
        if(isset($_POST['comment']) && isset($_POST['recipe_post_id']) && isset($_POST['foodName']) && isset($_POST['countryName'])){
            $comment = $_POST['comment'];
            $recipe_post_id = $_POST['recipe_post_id'];
            $foodName = $_POST['foodName'];
            $countryName = $_POST['countryName'];
            $time = time();

            $this->model->postUserComment($recipe_post_id, $comment, $foodName, $countryName, $time);
        }else{
             header('location:'.URL.'home');
        }
       
                
    }
    
    public function getUserCommentCount()
    {
        if(isset($_GET['recipe_post_id'])){
            $recipe_post_id = $_GET['recipe_post_id'];
            $this->model->getUserCommentCount($recipe_post_id);
        }else{
             header('location:'.URL.'home');
        }
        
    }
    
   public function getUserComment()
    {
       if(isset($_GET['recipe_post_id'])){
            $Posting = "CMPOST";
            $recipe_post_id = $_GET['recipe_post_id'];
            $this->model->getUserComment($recipe_post_id,  $Posting);
       }else{
             header('location:'.URL.'home');
        }
        
    }
    
    public function userTryItCounter()
    {
        if(isset($_POST['recipe_post_comments_id']) && isset($_POST['recipe_post_id']) && isset($_POST['food_id']) && isset($_POST['country_id'])){
            $recipe_post_comments_id = $_POST['recipe_post_comments_id'];
            $recipe_post_id = $_POST['recipe_post_id'];
            $food_id = $_POST['food_id'];
            $country_id = $_POST['country_id'];
            $this->model->userTryItCounter($recipe_post_comments_id, $recipe_post_id, $food_id,  $country_id);
        }else{
             header('location:'.URL.'home');
        }
        
    }
    
    public function infinitScrollHomeRecipeLoader()
    {
       if(isset($_POST['page'])){
            $pages =  $_POST['page'];
            $this->model->infinitScrollHomeRecipeLoader($pages);
       }else{
             header('location:'.URL.'home');
        }
     
        
    }
    
    public function showAllComment(){
        if(isset($_POST['recipe_post_id'])){
             $recipe_post_id = $_POST['recipe_post_id'];
            $this->model->showAllComment($recipe_post_id);
        }else{
             header('location:'.URL.'home');
        }
       
    }
    
    public function putInMyCookBox(){
        if(isset($_POST['recipe_post_id'])){
            $recipe_post_id = $_POST['recipe_post_id'];     
            $this->model->putInMyCookBox($recipe_post_id);
        }else{
             header('location:'.URL.'home');
        }
        
    }
    
    public function searchForShops(){
        if(isset( $_GET['country_id'])){
            $country_id = $_GET['country_id'];
            $city = $_GET['city'];
            $this->model->searchForShops($country_id, $city);
        }else{
             header('location:'.URL.'home');
        }
       
    }
    
    public function getUserRegCity(){
        $this->model->getUserRegCity();
    }
    
    
    
}