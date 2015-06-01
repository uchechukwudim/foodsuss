<?php

class foodFinder extends Controller{
   
    function __construct() {
          parent::__construct();
          $this->sessionCheck();
     
    }

    //Methods with interface::::::::::::::::::::::::::::::::::::::
    public function index()
    {
    
        $this->model->index();
        
    }
    function food($country)
    {
        if($country){
     
            $modelName = "foodFinderFood";
            $this->loadModel($modelName);
            $this->model->food($country);
        }

    }
    
    function recipesbycountry($food, $country)
    {    
        if(isset($food) && isset($country)){
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->recipesbycountry($food, $country);
        }else{
            return false;
        }
    }
    
    public function recipes($food){
        if($food){
            $modelName = "foodFinderAllRecipe";
            $this->loadModel($modelName);
            $this->model->index($food);
        }
    }
    
    function  getEnriRecipes()
    {
        if(isset($_GET['food']) && $_GET['country']){
            $food = $_GET['food'];
            $country = $_GET['country'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->getEnriRecipes($food, $country);
        }
       
    }
    public function getAllENRIRecipes(){
        if(isset($_GET['food'])){
            $food = $_GET['food'];
            $modelName = "foodFinderAllRecipe";
            $this->loadModel($modelName);
            $this->model->getAllEnriRecipes($food);
        }
    
        
    }
      
    public function showAllComment(){
        
        if(isset($_POST['recipe_id'])){
            $recipe_post_id = $_POST['recipe_id'];
            $modelName = "foodFinderAllRecipe";
            $this->loadModel($modelName);
            $this->model->showAllComment($recipe_post_id);
        }

    }
    
     public function putInMyCookBox(){
         
         if(isset($_POST['recipe_id'])){
            $recipe_id = $_POST['recipe_id'];  
            $modelName = "foodFinderAllRecipe";
            $this->loadModel($modelName);
            $this->model->putInMyCookBox($recipe_id);
         }
       
    }
    
  //method with interface ends here::::::::::::::::::::::::::::::::::::
    
   
  //methods called by jquery or Ajax:::::::::::::::::::::::::::::::::::
    function getCountries()
    {
        if(isset($_GET['continent'])){
            $continent = $_GET['continent'];
            $this->model->getCountries($continent);
        }
 
    }

    function infinitScrollCountryLoader()
    {
        if(isset($_GET['page']) && isset( $_GET['continent'])){
            $pages =  $_GET['page'];
            $continent =  $_GET['continent'];
             $this->model->infinitScrollCountryLoader($pages, $continent);
        }
       
    }
    
    function infinitScrollFoodLoader(){
        
        if(isset($_GET['country_name'])){
              $pages = $_GET['pages'];
              $country_name = $_GET['country_name'];
              $modelName = "foodFinderFood";
             $this->loadModel($modelName);
             $this->model->infinitScrollFood($pages, $country_name);
        }else{
            $pages = $_GET['pages'];
             $this->model->infinitScrollFoodLoader($pages);
        }
       
    }
    
    function insertTCSEN()
    {
        
    }
    
    function TellUseNewFood()
    {
        
         if($_POST && $_FILES)
         {
             $file_name = $_FILES['file']['name'];
             $file_ext = strtolower(end(explode('.', $file_name)));
             $file_size = $_FILES['file']['size'];
             $file_temp = $_FILES['file']['tmp_name'];
           
             $userInput =$_POST["comment"];
             $this->UserInputCommentandimageIntoDb($file_name, $file_ext, $file_size, $file_temp,  $userInput);
         }
         else  if($_POST)
         {
             $userInput = $_POST['comment'];
             $this-> UserInputCommentIntoDb($userInput);
         }
      
       
    }
    
    function InsertFollowFood()
    {
        if(isset( $_POST['food_id']) && isset($_POST['country_id'])){
            $food_id = $_POST['food_id'];
            $country_id = $_POST['country_id'];
            $modelName = "foodFinderFood";
            $this->loadModel($modelName);
            $this->model->InsertFollowFood($food_id,  $country_id);
        }
      

    }
    
    function InsertFollowFoodAll(){
         if(isset( $_POST['food_id'])){
             $food_id = $_POST['food_id'];
             $this->model->InsertFollowFoodAll($food_id);
         }
    }
    
    function getFoodFollowers(){
        if(isset($_GET['food_id']) && isset($_GET['country_id'])){
            $food_id = $_GET['food_id'];
            $country_id = $_GET['country_id'];
            $modelName = "foodFinderFood";
            $this->loadModel($modelName);
            $this->model->getFoodFollowers($food_id, $country_id);
        }
    }
    
    function getFoodFollowersAll(){
         if(isset($_GET['food_id'])){
             $food_id = $_GET['food_id'];
             $this->model->getFoodFollowersAll($food_id);
         }
    }
            
    function getImage()
    {
        $id = $_REQUEST['id'];
        echo json_encode($id);
    }
    
    function Cookit()
    {
        if(isset( $_GET['recipe_id']) && isset($_GET['countryID'])){
            $recipe_id = $_GET['recipe_id'];
            $country_id = $_GET['countryID'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->Cookit($recipe_id, $country_id);
        }
        
      
    }
    
   
    function insertShareEN()
    {
       if(isset($_POST['recipe_id']) && isset($_POST['country_id'])){
            $recipe_id = $_POST['recipe_id'];
            $country_id = $_POST['country_id'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->insertShareEN($recipe_id, $country_id);
       }
        
    }
    
    function insertTastyEN(){
        if(isset($_POST['recipe_id']) && isset($_POST['country_id'])){
            $recipe_id = $_POST['recipe_id'];
            $country_id = $_POST['country_id'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->insertTastyEN($recipe_id, $country_id);
        }
    
  
    }

    function getShareEN()
    {
        if(isset($_POST['recipe_id']) && isset($_POST['country_id'])){
            $recipe_id = $_POST['recipe_id'];
            $country_id = $_POST['country_id'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model-> getShareEN($recipe_id, $country_id);
        }
        
    }
    
    function getTastyEN(){
        if(isset($_POST['recipe_id']) && isset($_POST['country_id'])){
            $recipe_id = $_POST['recipe_id'];
            $country_id = $_POST['country_id'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->getTastyEN($recipe_id, $country_id);
        }
        
    }
    
    function postUserRecook()
    {
        if(isset($_POST['recipe_id']) && isset($_POST['recook']) && isset($_POST['food_id'])){
            $r_id = $_POST['recipe_id'];
            $Rcook = $_POST['recook'];
            $food_id = $_POST['food_id'];
            $email = $_SESSION['user']; 
            $time = time();
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->postUserRecook($r_id, $Rcook, $email, $food_id, $time);
        }
    }
    
    function getUserRecookComment()
    {
        if(isset($_GET['recipeName'])){
            $recipeName = $_GET['recipeName'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->getUserRecookComment($recipeName);
        }
       
    }
    
    function getSingleUserRecookComment()
    {
        if(isset($_GET['recipe_id']) && isset($_GET['food_id']) && isset($_GET['recook'])){
            $recipe_id = $_GET['recipe_id'];
            $food_id = $_GET['food_id'];
            $comment = $_GET['recook'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->getSingleUserRecookComment($recipe_id, $food_id,  $comment);
        }
        
    }
    
     function userTryItCounter()
     {
         if(isset($_GET['recipe_recook_id'])){
            $recipe_recook_id = $_GET['recipe_recook_id'];
            $useremail = $_SESSION['user'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->userTryItCounter($recipe_recook_id, $useremail);
         }
        
     }
    
    function postRecookCounter()
    {
        if(isset($_POST['counter'])){
            $counted = $_POST['counter'];
            $modelName = "foodFinderRecipes";
            $this->loadModel($modelName);
            $this->model->postRecookCounter($counted);
        }
       
    }
    
 function getUserRecookCommentCount()
 {
    if(isset($_GET['recipe_id'])){
        $recipe_id = $_GET['recipe_id'];
        $modelName = "foodFinderRecipes";
        $this->loadModel($modelName);
        $this->model->getSingleUserRecookCommentCount($recipe_id);
    }
     
 }
 
 function getProducts()
 {
     if(isset($_GET['country'])){
        $food =  $_GET['food'];
        $country =  $_GET['country'];
        $this->model->getProducts($food, $country);
     }else{
         $food =  $_GET['food'];
         $this->model->getAllProducts($food);
     }
    
 }
 
 function getProductEatWith()
 {
     
     if(isset($_GET['country'])){
         $product = $_GET['product_name'];
        $country = $_GET['country'];
        $this->model->getProductEatWith($product, $country);
     }else{
         
          $product = $_GET['product_name'];
          $this->model->getAllProductEatWith($product);
     }
     
 }
 function getRecipeAccordingToUserType()
 {
     if(isset($_GET['userType']) && isset($_GET['country']) && isset($_GET['food'])){
        $userType = $_GET['userType'];
        $countryMeal = $_GET['country'];
        $foodMeal = $_GET['food'];
        $modelName = "foodFinderRecipePost";

        $this->loadModel($modelName);
        $this->model->getRecipeAccordingToUserType($userType, $countryMeal, $foodMeal);
     }
    
 }
 public function getAllRecipeAccordingToUserType(){
     if(isset($_POST['userType']) && isset($_POST['food'])){
        $userType = $_POST['userType'];
        $food = $_POST['food'];
        $modelName = "foodFinderRecipePost";
        $this->loadModel($modelName);
        $this->model->getAllRecipeAccordingToUserType($userType, $food);
     }
 }
 
function infinitScrollHomeRecipeLoader()
{
    if(isset($_GET['page']) && isset($_GET['foodName']) && isset( $_GET['countryName']) && isset($_GET['userType'])){
        $page = $_GET['page'];
        $foodName = $_GET['foodName'];
        $countryName = $_GET['countryName'];
        $userType = $_GET['userType'];

        $modelName = "foodFinderRecipePost";

        $this->loadModel($modelName);
        $this->model->infinitScrollHomeRecipeLoader($userType, $foodName, $countryName, $page);
    }
   
}
    
   //methods called by jquery or ajax ends here:::::::::::::::::::::::::::::::::::::::::::::::::::
    
    
    
    //private functions::::::::::::::::::::::::::::::::::::::::::
     private function indexx($continent = false)
    {  
        
        $this->model->indexx($continent);
    }
    private function UserInputCommentIntoDb($userInput)
    {
          if(strlen(trim($userInput)) == 0)
              {
                //error messsage
                 $EntryMessage = "There was no entry in the Textarea";
                 echo json_encode($EntryMessage);
              }
              else{
                  $this->model->UserInputCommentIntoDb($userInput);
              }
    }
  private function UserInputCommentandimageIntoDb($file_name, $file_ext, $file_size, $file_tmp, $foodComment)
  {       if(strlen(trim($foodComment)) === 0)
           {
                    //error messsage
                 $EntryMessage = "There was no entry in the Textarea";
                 echo json_encode($EntryMessage);
           }
          else if(strlen($file_name) != 0 && strlen(trim($foodComment)) !== 0)
            {
                //process image here
                $this->processThisImage($file_name, $file_ext, $file_size, $file_tmp, $foodComment);
            }

  }
  
  
  function infinitScrollENRecipeLoader()
  {
      $pages = '';
        $foodName ='';
        $countryName = '';
      
      if(isset($_GET['page']) && isset($_GET['foodName']) && isset($_GET['countryName'])){
        $pages =  $_GET['page'];
        $foodName = $_GET['foodName'];
        $countryName = $_GET['countryName'];
        $modelName = "foodFinderRecipes";
        $this->loadModel($modelName);
        $this->model->infinitScrollENRecipeLoader($foodName, $countryName, $pages);
      }
      
       
      
  }
  
  public function infinitScrollAllENRecipeLoader(){
      
      if(isset($_GET['user_type'])){
         $pages =  $_GET['page'];
         $foodName = $_GET['foodName'];
         $user_type = $_GET['user_type'];
         $modelName = "foodFinderRecipePost";
         $this->loadModel($modelName);
         $this->model->infinitScrollAllHomeENRecipeLoader($user_type, $foodName, $countryName = '', $pages);
      }else{
            $pages =  $_GET['page'];
            $foodName = $_GET['foodName'];
            $modelName = "foodFinderAllRecipe";
            $this->loadModel($modelName);
            $this->model->infinitScrollAllENRecipeLoader($pages, $foodName);
      }
      
  }
  
  function infinitScrollFood()
  {
      if(isset($_POST['page']) && isset($_POST['country'])){
        $pages =  $_POST['page'];
        $country = $_POST['country'];
     
        $modelName = "foodFinderFood";
        $this->loadModel($modelName);
        $this->model->infinitScrollFood($pages, $country);
      }
     
  }

  //process image    
  private function processThisImage($file_name, $file_ext,  $file_size, $file_temp, $userinput)
  {
     static $maxSize = 3145728;
     $errors = '';
     $accepted_ext = array('jpg', 'png', 'jpeg', 'gif');
     $Image = array();
     
      if(in_array($file_ext, $accepted_ext) === false)
      {
          $errors .= 'Only Image allowed'."</br>";
      }
      
      if($file_size >$maxSize)
      {
          $errors .= 'File size to big'."</br>";
      }
      
      if(empty($errors))
      {
          $this->model->userInputCommentandImageIntoDb(addslashes($file_name), addslashes($file_temp), $userinput);
                  
      }
      else
      {
          echo json_encode($errors);
          
      }
  }
 
}