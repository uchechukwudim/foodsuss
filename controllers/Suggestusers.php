<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Suggestusers
 *
 * @author Uche
 */
class Suggestusers extends Controller {
    //put your code here
      function __construct() {
          parent::__construct();
          $this->sessionCheck();
    }
    
    public function index(){
        $this->model->index();
    }
    
    public function GmailContacts(){
   
        $clientid='724459132357-q0cfvt8li65pdc3cf9nnhon0g2urur9j.apps.googleusercontent.com';
        $clientsecret='AF1bi9uBdAg7qAs-hwnAQmRy';
        $redirecturi= URL.'Suggestusers/GmailContacts';  
        $gd = 'gd';
        $gdLink = 'http://schemas.google.com/g/2005';
        $gdEmail = '//gd:email';
        
        if(isset($_GET['code'])){
            $authcode = $_GET['code'];
            
            $fields = $this->setField($authcode, $clientid, $clientsecret, $redirecturi);
            $fields_string = $this->trimFields($fields);
            $accesstoken =$this->setURLGetAccessToken($fields_string);
            
            $url = GMAILQUERYLINK.$accesstoken;
            $xmlresponse = $this->curl_file_get_contents($url) ;

            //reading xml using SimpleXML
            $xml = new SimpleXMLElement($xmlresponse);
            $xml->registerXPathNamespace($gd, $gdLink );
            $result = $xml->xpath($gdEmail);
            
            $userDetails = $this->model->getUserNameAndPicture();
            $name =  $userDetails[0];
            $picture =  $userDetails[1];
            
             $fileName = "emailInvites/index";
            $this->view->renderEmailInvites($fileName, $result);
           
        }else{
           
            $fileName = "emailInvites/index";
            $this->view->renderEmailInvites($fileName, $contacts='');
        }
    }
    
    private function setField($authcode, $clientid, $clientsecret, $redirecturi){
        $auth_code = 'authorization_code';
        $fields=array(

            'code'=>  urlencode($authcode),

            'client_id'=>  urlencode($clientid),

            'client_secret'=>  urlencode($clientsecret),

            'redirect_uri'=>  urlencode($redirecturi),

            'grant_type'=>  urlencode($auth_code)

            );
        return $fields;
    }
    
    private function trimFields($fields){
         $fields_string ='';
        foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }

        $fields_string=rtrim($fields_string,'&');
        
        return $fields_string;
    }
    
    private function setURLGetAccessToken($fields_string){
        $ch = curl_init();

        //set the url, number of POST vars, POST data

        curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');

        curl_setopt($ch,CURLOPT_POST,5);

        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

        // Set so curl_exec returns the result instead of outputting it.

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //to trust any ssl certificates

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //execute post

        $result = curl_exec($ch);

        //close connection

        curl_close($ch);
        $response   =  json_decode($result);
        
        if(property_exists($response,  "access_token")){
              $accesstoken = $response->access_token;  
        }else{
            $fileName = "error/logedinError/index";
            $this->view->renderLogedinError($fileName);
            exit;
        }
      
        
        if( $accesstoken!='')
            $_SESSION['token']= $accesstoken;
        
        return  $accesstoken;
    }
    
    
    function curl_file_get_contents($url)
    {
          $curl = curl_init();
          $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
          curl_setopt($curl,CURLOPT_URL,$url);  //The URL to fetch. This can also be set when initializing      a session with curl_init().
          curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
          curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);   //The number of seconds to wait while trying to connect.
          curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);  //The contents of the "User-Agent: " header to be used in a HTTP request.
          curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
          curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);  //To automatically set the Referer: field in requests where it follows a Location: redirect.
          curl_setopt($curl, CURLOPT_TIMEOUT, 10);  //The maximum number of seconds to allow cURL functions to execute.
          curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  //To stop cURL from verifying the peer's certificate.
          $contents = curl_exec($curl);
          curl_close($curl);
          
          return $contents;
    }
    
    function getUserNameAndPicture(){
       $details = $this->model->getUserNameAndPicture();
       $name = $details[0];
       $user_picture = $details[1];
       $thisuserEmail = $details[2];
       
       file_put_contents(TEMPPICPATH."".$thisuserEmail.".png", $user_picture, $thisuserEmail);
       $image_path = TEMPPICPATH."".$$thisuserEmail.".png";
       $image_name = $email.".png";
       $this->sendinviteMail($contacts ='', $name, $image_path, $image_name);
    }
    
    public function processInviteEmails(){
         
        if(isset($_POST['emails'])){
            $emails = $_POST['emails'];
            $details = $this->model->getUserNameAndPicture();
            $name = $details[0];
            $user_picture = $this->checkPicture($details[1]);
            $thisuserEmail = $details[2];
            file_put_contents(TEMPPICPATH."".$thisuserEmail.".png", $user_picture);
            $image_path = TEMPPICPATH."".$thisuserEmail.".png";
            $image_name = $email.".png";
            $this->sendinviteMail($emails, $name, $image_path, $image_name, $thisuserEmail);
        }
    }
    
   private function checkPicture($image){
       $defaultPic_path = PICTURE."default_pic.png";
       if(!$image || empty($image)){
           $def_pic = file_get_contents($defaultPic_path);
           
           return $def_pic;
       }else{
           return $image;
       }
   }
   
}
