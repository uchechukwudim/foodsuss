<?php
//this is the index for conrollers in controller folder
error_reporting(E_ALL);
ini_set('display_errors', 1);
class index extends Controller {

    function __construct() {
        parent::__construct();
     
        $this->js = array();
        $this->css = array();
        
        $this->FoodBody = ''.View.INDEX.'/food/index.php';
        $this->IndexCountryBody = ''.View.INDEX.'/CountryList/index.php';
        $this->RecipesBody = ''.View.INDEX.'/recipes/index.php';
    
        
    }

    public function index()
    {
      //$this->loadModel("index");
        //$this->model->index();
      
        $this->view->render('index/index');
      
    }
    
    
    public function processLogIn()
    {
        header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        $email = '';
        $password = '';
        if(isset($_POST['email']) && isset($_POST['password'])){
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            $this->model->processLogIn($email, $password);
        }else{
            header('location:'.URL);
        }
       
    }
    
    public function processSignup(){
        $firstName ='';
        $lastName = ''; 
        $email = ''; 
        $password = ''; 
        $cur_city = ''; 
        $cur_country = ''; 
        $user_type = ''; 
        $rest_name = '';
      
        if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password'])&&
        isset($_POST['cur_city']) && isset($_POST['cur_country']) && isset($_POST['user_type']) && !isset($_POST['rest_name'])){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName']; 
            $email = $_POST['email']; 
            $password = $_POST['password']; 
            $cur_city = $_POST['cur_city']; 
            $cur_country = $_POST['cur_country']; 
            $user_type = $_POST['user_type']; 
           
            $this->model->processSignupNorm($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type);
       
        }else if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['email']) && isset($_POST['password'])&&
                isset($_POST['cur_city']) && isset($_POST['cur_country']) && isset($_POST['user_type']) && isset($_POST['rest_name'])){
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName']; 
            $email = $_POST['email']; 
            $password = $_POST['password']; 
            $cur_city = $_POST['cur_city']; 
            $cur_country = $_POST['cur_country']; 
            $user_type = $_POST['user_type']; 
            $rest_name = $_POST['rest_name'];
            
            $this->model->processSignupRest($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type, $rest_name);
        }
    }
    
    public function verifyCode(){
        $email = '';
        $code = '';
        if(isset($_GET['email']) && $_GET['code']){
            $email = $_GET['email'];
            $code = $_GET['code'];
            $this->model->verifyCode($email, $code);
        }
    }
    public function resendVerification(){
        $email = '';
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            $this->model->resendVerification($email);
        }
    }
    public function CountryList($state)
    {
       $this->js = array('index/CountryList/js/CountryListjs.js');
       
       $this->css = array('css/index/foodfindersheet.css','css/index/countries.css', 'css/index/loadCountries.css');
       require ''.$this->IndexCountryBody;
       $this->model->CountryList($state);
    }
    
    function getCountries($continent = false)
    {
       $this->model->getCountries($continent);
    }

    function infinitScrollCountryLoader()
    {
        $this->model->infinitScrollCountryLoader($_GET['page'], $_GET['continent']);
    }
    
    function food($country)
    {
        //load css files
        $this->css = new ArrayObject(array('css/foodfinder/food/foodsheet.css', 
                                                'css/foodfinder/food/errorDialgBoxSheet.css',
                                                'css/foodfinder/products/productsheet.css'));
         //load js files
        $this->js = array('foodfinder/food/js/foodpage.js', 
                                'foodfinder/food/js/tooltip.js',
                                'foodfinder/food/js/Upload.js',
                                'foodfinder/products/js/productjsFunctions.js',
                                'foodfinder/products/js/runProductsjsFunctions.js');
        
       // View.$this->view->loadHeader();
        require ''.$this->FoodBody;
        $this->model->food($country);
        View.$this->view->loadFooter();
    }
    
    function meal($food, $country)
    {
         //load css files
        $this->css = new ArrayObject(array('css/foodfinder/recipes/mealsheet.css', 
                                                 'css/foodfinder/recipes/healthDialog.css', 
                                                 'css/foodfinder/recipes/imageDialog.css', 
                                                 'css/foodfinder/recipes/errorDialgBoxSheet.css'));
        //load js filess
        $this->js = array('foodfinder/recipes/js/mealjsfunctions.js', 
                                'foodfinder/recipes/js/runMealFunctions.js');
        
        require ''.$this->RecipesBody;
        $this->model->meal($food, $country);
        View.$this->view->loadFooter();
    }
    
    public function forgotpassword(){
        if(isset($_POST['email'])){
           $email = $_POST['email'];
           $this->model->forgotpassword($email);
        }
    }
    
    
    
    public function logout()
    {
        Session::init();
         Session::distroy();
         header('location:'.URL);
         exit;
    }
    
    public function forgotpasswordlogin($code, $email){
        if($code && $email){
            $fileName = 'index/forgotpasswordlogin/index';
            $this->view->renderForgotpasswordlogin($fileName, $email);
        }else{
            header('location:'.URL);
        }
    }
    
    public function ProcessForgetpasswordLogin(){
         
        if(isset($_POST['tempPassword']) && isset($_POST['newPassword']) && isset($_POST['email'])){
            $tempPassword = $_POST['tempPassword'];
            $newPassword = $_POST['newPassword'];
            $email = $_POST['email'];
            
            $this->model->ProcessForgetpasswordLogin($tempPassword, $newPassword, $email);
        }else{
           header('location:'.URL);
        }
    }
} 