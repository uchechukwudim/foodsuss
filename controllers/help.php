<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of help
 *
 * @author Uche
 */
use Mailgun\Mailgun;
error_reporting(E_ALL);
ini_set('display_errors', 1);
class help extends Controller {
    //put your code here
     function __construct() {
        parent::__construct();
 
    }
    
    public function index(){
        
        if($this->sessionChecker()){
                $fileName = 'help/logedin/index';
                 $this->view->renderHelp($fileName);
        }else{
            $fileName = 'help/logedout/index';
            $this->view->renderHelp($fileName);
        }
        
    }
    
    public function sendContactFormEmail(){
        if(isset($_POST['names']) && isset($_POST['email']) && isset($_POST['message'])){
            $names = $_POST['names'];
            $email = $_POST['email'];
            $message = $_POST['message'];
            $to = "help@enrifinder.com";
            $subject = 'From Help Contact form';
            $header = $email;
            
           echo json_encode($this->send_Helpmail($to, $subject, $message, $header, $names));
        }
    }
    
    
    function send_Helpmail($to,$subject,$message,$header, $name){
	
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
}
