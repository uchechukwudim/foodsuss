<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of reseachAdministration
 *
 * @author Uche
 */
class researchAdministration extends Controller{
    //put your code here
    function __construct() {
          parent::__construct();   
    }
    
    public function index(){
        $fileName = 'researchAdministration/index';
        $this->view->renderReseachAdministration($fileName);
    }
    
     public function loginRequest(){
        header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        
        $email = '';
        $password = '';
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $this->model->loginRequest($email, $password);
        }
    }
    
    public function navigation(){
        $fileName = 'researchAdministration/navigation/index';
        if($this->researcherSessionChecker()){
            $this->view->renderReseachAdministrationNavigation($fileName);
        }else{
           // $this->view->renderReseachAdministrationNavigation($fileName);
            header('location:'.URL.'reseachAdministration');
        }
    }
    
    public function putFood(){
         $fileName = 'researchAdministration/putFood/index';
        if($this->researcherSessionChecker()){
            $this->view->renderReseachAdministrationPutFood($fileName);
        }else{
             //$this->view->renderReseachAdministrationPutFood($fileName);
             header('location:'.URL.'reseachAdministration');
        }
    }
    public function processPutFoodRequest(){
        $exploadWith = '.';
        $temp_Origins = array();
 
        if(isset($_POST['foodName']) && isset($_POST['food_description']) && 
           isset($_POST['nutrient']) && isset($_POST['foodType']) && 
           isset($_FILES) && isset($_POST['foodOrigins'])){
            
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
                    $foodName = $_POST['foodName'];
                    $foodDesc = $_POST['food_description'];
                    $nutrients = $_POST['nutrient'];
                    $foodType = $_POST['foodType'];
                    $temp_Origins = json_decode(stripslashes($_POST['foodOrigins']));
                    $foodOrigins = (array)$temp_Origins;
                    $this->model->processPutFoodRequest($foodName, $foodDesc,  $nutrients, $foodType, $foodOrigins, $imageData, $imageName);
              }
            
        }
    }

     public function processExistingPutFoodRequest(){
        if(isset($_POST['foodName']) && isset($_POST['originAndDesc'])){
            $foodName = $_POST['foodName'];
            $temp_Origins = json_decode(stripslashes($_POST['originAndDesc']));
            $foodOrigins = (array)$temp_Origins;
            $this->model->processExistingPutFoodRequest($foodName, $foodOrigins);
        }
    }
    
    public function putRecipe(){
        $fileName = 'researchAdministration/putRecipe/index';
        if($this->researcherSessionChecker()){
            $this->view->renderReseachAdministrationPutRecipe($fileName);
        }else{
            //$this->view->renderReseachAdministrationPutRecipe($fileName);
             header('location:'.URL.'reseachAdministration');
        }
    }
    
        
    public function processPutRecipeRequest(){
        $exploadWith = '.';
        $temp_ingredients  = array();
 
        if(isset($_POST['recipeTitle']) && isset($_POST['instructions']) && 
           isset($_POST['healthBenefit']) && isset($_POST['mealType']) && 
           isset($_POST['baseFood']) && isset($_POST['baseCountry']) &&
           isset($_FILES) && isset($_POST['ingredients'])){
            
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
                    $recipeTitle = $_POST['recipeTitle'];
                    $recInstruction = $_POST['instructions'];
                    $healthBenefit = $_POST['healthBenefit'];
                    $mealType = $_POST['mealType'];
                    $baseFood = $_POST['baseFood'];
                    $baseCountry = $_POST['baseCountry'];
                    $temp_ingredients = json_decode(stripslashes($_POST['ingredients']));
                    $ingredients = $this->concatIngre((array)$temp_ingredients);
                    $this->model->processPutRecipeRequest($recipeTitle,  $recInstruction, $healthBenefit,  $mealType, $baseFood, $baseCountry, $ingredients, $imageData, $imageName);
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
    
  
     
    
    public function putProduct(){
        $fileName = 'researchAdministration/putProduct/index';
        if($this->researcherSessionChecker()){
            $this->view->renderReseachAdministrationPutProduct($fileName);
        }else{
             //$this->view->renderReseachAdministrationPutProduct($fileName);
             header('location:'.URL.'reseachAdministration');
        }
    }
    
    public function processPutProductRequest(){
        $exploadWith = '.';
        $temp_ingredients  = array();
 
        if(isset($_POST['productName']) && isset($_POST['description']) && 
           isset($_POST['foodName']) && isset($_POST['countryName']) && 
           isset($_POST['eatwith']) && isset($_FILES)){
            
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
                    $productName = $_POST['productName'];
                    $description = $_POST['description'];
                    $foodName = $_POST['foodName'];
                    $countryName = $_POST['countryName'];
                    $temp_eatwith = json_decode(stripslashes($_POST['eatwith']));
                    $eatwith = (array)$temp_eatwith;
                    $this->model->processPutProductRequest($productName,  $description, $foodName,  $countryName, $eatwith, $imageData, $imageName);
              }
            
        }
    }
    
    public function processPostPutProductEatwithRequest(){
        if(isset($_POST['productName']) && isset($_POST['foodName']) && 
           isset($_POST['countryName']) && 
           isset($_POST['eatwith'])){
            $productName = $_POST['productName'];
            $foodName = $_POST['foodName'];
            $countryName = $_POST['countryName'];
            $temp_eatwith = json_decode(stripslashes($_POST['eatwith']));
            $eatwith = (array)$temp_eatwith;
            $this->model->processPostPutProductEatwithRequest($productName, $foodName, $countryName,  $eatwith);
        }
    }
    
    public function postArticle(){
        $fileName = 'researchAdministration/postArticle/index';
        if($this->researcherSessionChecker()){
            $this->view->renderReseachAdministrationPostArticle($fileName);
        }else{
             header('location:'.URL.'reseachAdministration');
        }
    }
   
    public function processPostArticleRequest(){
         $exploadWith = '.';
        if(isset($_POST['art_title']) && isset($_POST['art_writeup'])  && isset($_POST['art_des'])  && isset($_POST['tags']) && isset($_FILES)){
            $artTitle = $_POST['art_title']; $artWriteup = $_POST['art_writeup'];
            $artLink = $this->getLink($_POST['art_link']); $artDes = $_POST['art_des']; $artTags = $_POST['tags'];
            
            $file_name = $_FILES['file']['name'];$exp_name = explode($exploadWith , $file_name);
            $ext = end($exp_name);$file_ext = strtolower($ext); $file_size = $_FILES['file']['size'];
            $file_temp = $_FILES['file']['tmp_name'];
            
              if($this->processImage($file_name, $file_ext, $file_size, $file_temp)){
                  $imageData = file_get_contents( $_FILES['file']['tmp_name']);
                    $this->model->processPostArticleRequest($artTitle,  $artWriteup, $artLink, $artDes, $artTags, $imageData);
              }
        }
    }
    
    private function getLink($link){
        $nolink = "No LINK";
        if($link === $nolink){
            return URL;
        }else{
            return $link;
        }
    }
    
    public function researchLogout(){
         Session::init();
         Session::distroy();
         header('location:'.URL.'researchAdministration');
         exit;
    }
    
     public function processRecipeOriginSearch(){
       
        if(isset($_POST['index'])){
             $search_val = $_POST['recipeOrigin'];
             $index = $_POST['index'];
             $this->model->recipeOriginSearch($search_val, $index);
        }else{
            $search_val = $_POST['recipeOrigin'];
             $this->model->recipeOriginSearch($search_val, $index='');
        }
       
    }
    
    public function processBaseFoodSearch(){
        $search_val = $_POST['basefood'];
        $this->model->baseFoodSearch($search_val);
    }
    
     public function processBaseProductSearch(){
        $search_val = $_POST['baseProduct'];
        $this->model->baseProductSearch($search_val);
    }
    
    public function processBaseRecipeSearch(){
        $search_val = $_POST['baserecipe'];
        $this->model->processBaseRecipeSearch($search_val);
    }
    
  
    
 
    public function resendErrorNotificationEmail(){
        $Code =  "asdkfhbdsikewfiwrfiw9w34484";
        if(isset($_POST['confirmationCode']) && $Code === $_POST['confirmationCode']){
            
                     $details = $this->model->getEmailsCode();
                      for($looper =0; $looper < count($details); $looper++){
                          $to = $details[$looper]['user_email'];
                          $subject = "Please Verify your Enri Account";
                          $name = $details[$looper]['FirstName'];
                          $header = EMAILHEADER;
                          $signup_code  = $details[$looper]['signup_code'];
                          $message = $this->getresendErrorNotificationEmailBody($name, $signup_code);

                          //send emails here
                          echo $this->send_An_mail($to, $subject, $message, $header);
                      }
            
        }else{
            header('location:'.URL.'researchAdministration');
        }
      
    }
    
    private function getresendErrorNotificationEmailBody($name, $code){
            
            $message = '<html>
                            <head>
                             <meta charset="UTF-8">
                              <title></title>
                            </head>
                            <body >

                                <table  bgcolor="whitesmoke"  width= "700px">
                                        <tr>
                                            <td colspan="3" width="500px" height ="500px" align="center">
                                                <div id="contain" style="width: 600px; height:500px; background: white; margin-top: 50px;" >
                                                                  <a href="'.URL.'"><img src ="cid:enri_logo.png" width="80" style="margin-right: 400px; margin-top: 10px; width: 80px; "></a>
                                                                <div id="DetailsHolder" style="margin-top: 80px; ">

                                                                                <div style=" margin-right: 305px; font-family: Arial; color: grey; font-size: 15px; margin-bottom:  04.28571428571429% ;">Hello '.$name.',</div>
                                                                                <div style="  margin-left: 20px; margin-right: 20px; font-family: Arial; color: grey; font-size: 15px;">Thank you for signing up with enri. We are sorry if you had some difficulties verifiying your account. Please use your Email and Password to <a href="'.URL.'">login</a> into your account, for The Verification Dialog box to pop up. Please copy the code below and paste to  verify.<br><br>We look forward to having you on enri.</div>
                                                                                <div  style=" width: 200px; font-family: Arial; color: grey; font-size: 20px; text-align: center; margin-top: 50px; margin-bottom: 50px;  background: whitesmoke; padding: 10px 5px 10px 5px; ">'.$code.'</div>
                                                                </div>
                                                        </div>
                                                <div style=" font-family: Arial; font-size: 0.75em; color: grey;  margin-top: 50px;  margin-bottom: 30px;"><span style="padding-bottom: 15px;">&copy; copyright 2015 Enri Inc All rights reserved.</span><br><br> 39 Circular road, Elekahia Estate, RV, 500102</div>
                                            </td>
                                        </tr>

                                </table>

                            </body>
                        </html>
			';
            
            return $message;
        }
    
    
   
}
