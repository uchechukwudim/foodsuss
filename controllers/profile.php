<?php

class profile extends Controller{

    function __construct() {
        parent::__construct();
        $this->sessionCheck();
        $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
       $this->restaurant = 'Restaurant';
        $this->establishment = 'Establishment';
    }
    
     public function index()
    {
         $this->model->index();  
    }
    
    //check for establishment and restuarant
    private function  isResuarant($user_type)
    {
        if($user_type === $this->restaurant)
        {
            return true;
        }
    }
      private function isEstablishment($user_type)
      {
        if($user_type === $this->establishment)
        {
            return true;
        }
      }
    
    //load models
    private function loadResturantModel($user_id='')
    {
          
            $modelName = "restaurantProfileAboutMe";
            $this->loadModel($modelName);
            $this->model->restaurantAboutMe($user_id);
    }
    private function loadEstablishmentModel($user_id='')
    {
           $user_type = $_GET['user_type'];
            $modelName = "establishmentProfileAboutMe";
            $this->loadModel($modelName);
            $this->model->establishmentAboutMe($user_id);
    }
    
    private function loadOtherModels()
    {
             $modelName = "profileAboutMe";
             $this->loadModel($modelName);
             $this->model->AboutMe();
    }
    private function loadUserModels($user_id)
    {
            $modelName = "profileAboutMe";
            $this->loadModel($modelName);
            $this->model->AboutMe($user_id);
    }
    
    
    //choose what profile to load
    private function chooseType()
    {
         if(isset($_GET['user_type']) &&  !(isset($_GET['userId']))){
            $user_type = $_GET['user_type'];
                if($this->isResuarant($user_type))
                {
                    //load restuarant model
                   $this->loadResturantModel();
                    
                    die();
                }
                
                if($this->isEstablishment($user_type))
                {
                    //load establishment model
                    $this->loadEstablishmentModel();
                    die();
                }
                
        }
        else if(isset($_GET['user_type']) && isset($_GET['userId'])){
               $user_id = $_GET['userId'];
               $user_type = $_GET['user_type'];
                if($this->isResuarant($user_type))
                {
                    //load restuarant model
                    $user_id = $_GET['userId'];
                    $this->loadResturantModel($user_id);
                }
                
                if($this->isEstablishment($user_type))
                {
                    //load establishment model
                    $user_id = $_GET['userId'];
                    $this->loadEstablishmentModel($user_id);
                }
        }
       else if(isset($_GET['userId']) && !isset($_GET['user_type']))
        {
            $userId = $_GET['userId'];
            $this->loadUserModels($userId);
        }
        else
        {
            $this->loadOtherModels();
        }
    }
  
    
    
    
    
    
    public function AboutMe()
    {
       
        $this->chooseType();
         
    }
    
    
    public function myCookBook()
    {
        
        if(isset($_GET['userId']))
        {
            $userId = $_GET['userId'];
            $modelName = "profileMyCookBook";
            $this->loadModel($modelName);
            $this->model->myCookBook($userId);
        }
        else
        {
            $modelName = "profileMyCookBook";
            $this->loadModel($modelName);
             $this->model->myCookBook();
        }
    }
    
    public function myCookBox(){
        if(isset($_GET['userId']))
        {
            $userId = $_GET['userId'];
            $modelName = "profileMyCookBox";
            $this->loadModel($modelName);
            $this->model->myCookBox($userId);
        }
        else
        {
            $modelName = "profileMyCookBox";
            $this->loadModel($modelName);
             $this->model->myCookBox();
        }
    }


    public function User($sData, $AbtMEfriendFollow='')
    {
       $user_id = $this->decrypt($sData);
       $modelName = "userProfile";
       $this->loadModel($modelName);
      
       $this->model->profile($user_id, $AbtMEfriendFollow);
    }
    
    public function FriendsFollow()
    {
        if(isset($_GET['userId']))
        {
            $userId = $_GET['userId'];
            $modelName = "profileFriendsFollow";
            $this->loadModel($modelName);
            $this->model->FriendsFollow($userId);
        }
        else{
             $modelName = "profileFriendsFollow";
            $this->loadModel($modelName);
            $this->model->FriendsFollow();
        }
    }
    
    public function sendLocationInfoToServer()
    {
        $PostText = $_POST['Text'];
        $userDetailscolumn = $_POST['column'];
        $modelName = "profileAboutMe";
        $this->loadModel($modelName);
        $this->model->sendLocationInfoToServer($PostText, $userDetailscolumn);
    }
    
    function sendResAboutInfoToServer()
    {
        $PostText = $_POST['Text'];
        $userDetailscolumn = $_POST['column'];
        $modelName = "restaurantProfileAboutMe";
        $this->loadModel($modelName);
        $this->model->sendResAboutInfoToServer($PostText, $userDetailscolumn);
    }
    
    public function FriendFollowRequestProcessing()
    {
        $request = $_POST['request'];
        $user_id = $_POST['user_id'];
        $friend_user_id = $_POST['friend_user_id'];
        
        $modelName = "profileFriendsFollow";
        $this->loadModel($modelName);
        $this->model->FriendFollowRequestProcessing($request, $user_id, $friend_user_id);
    }
    
    
    public function infinitScrollMycookBook()
    {
   
        
        if(isset($_POST['userId'])  && isset($_POST['page']))
        {
                 $pages = $_POST['page'];
            $userId = $_POST['userId'];
            $modelName = "profileMyCookBook";
            $this->loadModel($modelName);
            $this->model->infinitScrollMycookBook($pages, $userId);
        }
        else
        {
                 $pages = $_POST['page'];
            $modelName = "profileMyCookBook";
            $this->loadModel($modelName);
            $this->model->infinitScrollMycookBook($pages, $userId='');
        }
    }
    
    public function infinitScrollMycookBox(){
        
        
        if(isset($_GET['userId'])  && isset($_GET['page']))
        {
            $pages = $_GET['page'];
            $userId = $_GET['userId'];
            $modelName = "profileMyCookBox";
            $this->loadModel($modelName);
            $this->model->infinitScrollMycookBox($pages, $userId);
        }
        else
        {
            $pages = $_GET['page'];
            $modelName = "profileMyCookBox";
            $this->loadModel($modelName);
            $this->model->infinitScrollMycookBox($pages, $userId='');
        }
    }
    
    public function infinitScrollFriendsFollow()
    {
         if(isset($_POST['userId'])  && isset($_POST['page']))
         {
             $userId = $_POST['userId'];
             $pages = $_POST['page'];
             $modelName = "profileFriendsFollow";
             $this->loadModel($modelName);
             $this->model->infinitScrollFriendsFollow($pages, $userId);
         }
         else{
                $pages = $_POST['page'];
                $modelName = "profileFriendsFollow";
                $this->loadModel($modelName);
                $this->model->infinitScrollFriendsFollow($pages, $userId='');
         }

    }
    
    public function uploadProfileCover()
    {
      //process image here
        $dot = '.';
        if(isset($_FILES))
         {
           
            $file_name = $_FILES['file1']['name'];
             $exploded_name = explode($dot, $file_name);
             $file_ext = strtolower(end($exploded_name));
             $file_size = $_FILES['file1']['size'];
             $file_temp = $_FILES['file1']['tmp_name'];
           
            
              $imageData = file_get_contents($file_temp);
              $imageName = $file_name;
              $this->model->uploadProfileCover($imageData, $imageName);
             
             
         }
   
       
    }
    
    public function uploadProfilePicture()
    {
     
        //process image here
        $dot = '.';
       if(isset($_FILES))
         {
             $file_name = $_FILES['file']['name'];
             $exploded_name = explode($dot, $file_name);
             $file_ext = strtolower(end($exploded_name));
             $file_size = $_FILES['file']['size'];
             $file_temp = $_FILES['file']['tmp_name'];
          
             $imageData = file_get_contents( $_FILES['file']['tmp_name']); 
             $imageName = $file_name;
             $this->model->uploadProfilePicture($imageData, $imageName);
             
         }
   
    }
    
    function getUploadedImage()
    {
        $which = $_GET['which'];
        $this->model->getUploadedImage($which);
        
    }
    
           //process image    
 
  
    function encrypt($sData)
    {
        $val = rand(ZERO, 4);
        
        $encrpter = $this->enrypter[$val];
        $id =(double)$sData*$encrpter;
        
       return base64_encode($id).$val;
    }

   function decrypt($sData)
   {
       $EncryptedId = substr($sData, 0, strlen($sData)-1) ;
       $val = substr($sData, strlen($sData)-1, strlen($sData));
 
       $url_id = base64_decode($EncryptedId);
       $id=(double)$url_id/$this->enrypter[$val];
       
      return $id;
   }

}
