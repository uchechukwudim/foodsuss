<?php
use Mailgun\Mailgun;
class Controller {

    function __construct() {
       // echo "This is the Main Controller</br>";
       $this->user = "user";
         $this->view = new View(); //instanciate it here as every controller passes through this 
         $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
     
    }
    
    public function loadModel($name)
    {
        $path = 'Models/'.$name.'_model.php';
        
        if(file_exists($path))
         {
             require 'Models/'.$name.'_model.php';
             $modelname = $name.'_model'; 
             $this->model = new $modelname();
         }
    }
    
   public function sessionCheck()
    {
       Session::init();
        $isLoggedin = Session::get('l');
        if(!Session::get('user'))
        {
         
            Session::distroy();
             //exit;
        }
    }
    
    public function sessionErrorChecker(){
       Session::init();
        $isLoggedin = Session::get('loggedIn');
        if($isLoggedin === false)
        {
             Session::distroy();
             return false;
        }else{
            return true;
        }
    }
    
     public function sessionChecker(){
       Session::init();
        $isLoggedin = Session::get('loggedIn');
        if($isLoggedin === false)
        {
             //Session::distroy();
             return false;
        }else{
            return true;
        }
    }
    
    public function researcherSessionChecker(){
        Session::init();
        $isLoggedin = Session::get('researcher_loggedIn');
        if($isLoggedin === false)
        {
             return false;
        }else{
            return true;
        }
    }


    public function processImage($file_name, $file_ext,  $file_size, $file_temp)
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
          return true;

       }
       else
       {
           echo json_encode($errors);

       }
   }
   
   public function sendinviteMail($emails, $name, $user_picture_path, $user_pic_name, $thisuserEmail){
         $subject = $name.' sent you an invitation.';
         $body = $this->getEmailBody($name, $thisuserEmail);
         
         $header = EMAILHEADER;
         for($looper =0; $looper < count($emails); $looper++) {
            $to = $emails[$looper]; 
            $this->send_mail($to, $subject, $body, $header, $name, $user_picture_path, $user_pic_name);
         }
        unlink($user_picture_path);
        echo json_encode(true);
  }
   
   function send_mail($to,$subject,$message,$header, $name, $user_picture_path, $user_pic_name){
	
                    $API_KEY = "key-e3b26a3500b85a05b2364458cd7238a1";

                    # Instantiate the client.
                    $mgClient = new Mailgun($API_KEY);
                    $domain = "enrifinder.com";

                    # Make the call to the client.
                    $result = $mgClient->sendMessage($domain, array(
                        'from'    => 'enri '.$header,
                        'to'      => $to,
                        'subject' => $subject,
                        'text'    => '',
                        'html'    => $message
                    ), array(
                        'inline' => array(ENRILOGO, $user_picture_path)
                    ));
                    if($result){
                        return true;
                    }else{
                        return false;
                    }   
       		       
	}
        
        private function getEmailBody($name, $email){
          

            $message = '
			<html>
			<head>
                         <meta charset="UTF-8">
			  <title></title>
			</head>
			<body >
			<table  bgcolor="whitesmoke"  width= "700px">
                            <tr>
                                <td colspan="3" width="500px" height ="500px" align="center">
                                                 <div id="contain" style="width: 600px; height:500px; background: white; margin-top: 50px;">
                                                                        <a href="'.URL.'"><img src ="cid:enri_logo.png" width="80" style="margin-right: 400px; margin-top: 10px; width: 80px; "></a>
                                                                        <div id="DetailsHolder" style="position: relative; top: 80px;  text-align: center;" >
                                                                                        <img src="cid:'.$email.'.png" width="100px" style="margin-bottom: 20px;">
                                                                                        <div style=" font-family: Arial; color: grey; font-size: 15px; margin-bottom:  20px ;"><b>'.$name.' has invited you to join enri</b></div>
                                                                                        <div style=" font-family: Arial; font-size: 1.125em; background: orangered; width: 150px; color: white; padding: 10px 5px 10px 5px; font-weight: 700; margin-bottom: 20px; margin-left: 220px;"><a style="text-decoration: none; color: white;" href="'.URL.'">Accept invitation</a></div>
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
        
        
         public function send_An_mail($to,$subject,$message,$header){
            $API_KEY = "key-e3b26a3500b85a05b2364458cd7238a1";
         
            # Instantiate the client.
            $mgClient = new Mailgun($API_KEY);
            $domain = "enrifinder.com";

            # Make the call to the client.
            $result = $mgClient->sendMessage($domain, array(
                'from'    => 'enri '.$header,
                'to'      => $to,
                'subject' => $subject,
                'text'    => '',
                'html'    => $message
            ), array(
                'inline' => array(ENRILOGO)
            ));
         
            if($result){
                return true;
            }else{
                return false;
            }
    }
       
                
        
        function decrypt($sData){
           $EncryptedId = substr($sData, 0, strlen($sData)-1) ;
           $val = substr($sData, strlen($sData)-1, strlen($sData));

           $url_id = base64_decode($EncryptedId);
           $id=(double)$url_id/$this->enrypter[$val];

          return $id;
        }
   
   

}