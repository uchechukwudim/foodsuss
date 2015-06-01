<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cookWith
 *
 * @author Uche
 */
class cookWith extends Controller{
    //put your code here
    function __construct() {
          parent::__construct();
         $this->sessionCheck();
          
          
    }
    
    public function index()
    {
        $this->model->index();
    }
    
    public function show($linkcode){
        if($linkcode){
            $this->model->show($linkcode);
        }else{
            $this->model->index();
        }     
    }
    
    public function joinshowRequest(){
        if(isset($_POST['cookwith_id'])){
            $cookwith_id = $_POST['cookwith_id'];
            $this->model->joinshowRequest($cookwith_id);
        }
    }
    
    public function getinvitees(){
        if(isset($_GET['cookwith_id']) && isset($_GET['cookwith_user_id'])){
            $cookwith_id = $_GET['cookwith_id'];
            $cookwith_User_id = $_GET['cookwith_user_id'];
            $this->model->getinvitees($cookwith_id, $cookwith_User_id);
        }
    }
    
      
     public function getMyshows(){
         $this->model->getMyshows();
     }
     
     public function sendChangStatusRequest(){
         if(isset($_POST['status']) && isset($_POST['cookwith_id']) && isset($_POST['user_id'])){
             $status = $_POST['status'];
             $user_id = $_POST['user_id'];
             $cookWith_id = $_POST['cookwith_id'];
             
             $this->model->sendChangStatusRequest($status, $user_id, $cookWith_id);
         }
     }
     
     public function infinityScrollViewShows(){
         if(isset($_GET ['page'])){
             $page = $_GET['page'];
             $this->model->infinityScrollViewShows($page);
             
         }
     }
     
     public function infinityScrollMyshow(){
         if(isset($_GET['page'])){
             $page = $_GET['page'];
             $this->model->infinityScrollMyshow($page);
         }
     }
     
     public function processShowEvent(){
         $exploadWith = '.';
         $temp_ingredients = array();
          
         if(isset($_FILES) && isset($_POST['showTitle']) && isset($_POST['showDescription']) && isset($_POST['foodOrigin']) && 
            isset($_POST['countryOrigin']) && isset($_POST['showDate']) &&
            isset($_POST['showTime']) && isset($_POST['ingredients']) & isset($_POST['invitees'])){
             
             $file_name = $_FILES['file']['name'];
             $exp_name = explode($exploadWith , $file_name);
             $ext = end($exp_name);
             $file_ext = strtolower($ext);
             $file_size = $_FILES['file']['size'];
             $file_temp = $_FILES['file']['tmp_name'];
             
             if($this->processImage($file_name, $file_ext, $file_size, $file_temp))
             {
                $showTitle = $_POST['showTitle'];
                $showDesc = $_POST['showDescription'];
                $foodOrigin = $_POST['foodOrigin'];
                $countryOringin = $_POST['countryOrigin'];
                $showDate = $_POST['showDate'];
                $showTime = $_POST['showTime'];
                $temp_ingredients = json_decode(stripslashes($_POST['ingredients']));
                $ingredients = $this->concatIngre((array)$temp_ingredients);
                $invites = json_decode($_POST['invitees']);
                $link = $this->getToken(20);

                $this->model->processShowEvent($showTitle, $showDesc, $foodOrigin, $countryOringin, $showDate, $showTime, $ingredients, $invites, $link);
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
    
    public function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0) return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }
    
}
