<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class index_model extends Model{

    function __construct() {
        parent::__construct();
       
          $this->id = -1;
        //$this->FirstName = $this->getUserFirstName($this->id);
        //$this->userInputMessage = 'Food sent.<br><br> Thank you '.$this->FirstName.' for telling us about the food we dont know.';
   
    }
    
    public function index(){
      
        $this->view->render('index/index');
    }
    
    public function verifyCode($email, $code){
        $sql = "SELECT signup_code FROM users WHERE user_email = :user_email";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_email'=>$email));
        $user_code = $sth->fetchAll();
        
        if(count($user_code) !== 0){
              if($user_code[ZERO]['signup_code'] === $code){
                  //update status
                        $sql = "UPDATE users SET status = :one WHERE user_email = :user_email";
                        $sth = $this->db->prepare($sql);
                         if($sth->execute(array(':user_email'=>$email, ':one'=> 1))){
                              echo json_encode(true);
                         }else{
                             echo json_encode($sth->errorInfo());
                         }
                         
                }else{
                    echo json_encode(false);
                }
        }
    }
    
    public function resendVerification($email){
       $code = $this->randomCode(7);
       $name = $this->getUserFLNameOrRestNameOrEstName((int)$this->getUserID($email));
       $subject = 'Verification Code';
       $to = $email;
       $header = EMAILHEADER;
       $message = $this->getEmailBody($name, $code);
       
         
       $sql = "UPDATE users SET signup_code = :code WHERE user_email = :user_email";
       $sth = $this->db->prepare($sql);
       if($sth->execute(array(':code'=>$code, ':user_email'=>$email))){
           $this->verify($to, $subject, $message, $header, $name);
           echo json_encode(true);
       }else{
           echo json_encode($sth->errorInfo());
       }
    }
    
    public function processLogIn($email, $password)
    {
        header('Access-Control-Allow-Origin:*'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      $VERIFY = "VERIFY";
      $one = '1';
      $inactive = 'INACTIVE';
      $message = '';
            //check for database here
            $sql = "SELECT user_id, status, on_off FROM users WHERE user_email = :username AND user_password = :userpassword";
            $user_det = $this->prepareLoginStatement($sql, $email, $password);
         
                if(count($user_det) === ZERO){
                   $message = "wrong email or password";
                    echo json_encode($message);
                }
                else{
                       if((int)$user_det[ZERO]['status'] === ZERO){
                           echo json_encode($VERIFY);
                       }else if((int)$user_det[ZERO]['status'] === (int)$one){
                           
                             if($user_det[ZERO]['on_off'] === $inactive){
                                 $this->update_OnOff($email);
                             }
                            Session::init();
                            Session::set('loggedIn', true);
                            Session::set('user', filter_var($email));
                            echo json_encode(true);
                       }
                }
            
    }
    
    private function update_OnOff($email){
        $active = "ACTIVE";
        $sql = "UPDATE users SET on_off = :active WHERE user_email = :user_email";
        $sth = $this->db->prepare($sql);
        $sth->execute(array(':active'=> $active, ':user_email'=>$email));
    }
    
    private function prepareLoginStatement($sql, $email, $password)
    {
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
           ':username' => filter_var($email),
            ':userpassword' => md5(filter_var($password))
        ));
      
        return $sth->fetchAll();
    }
    
    public function processSignupNorm($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type){
       $email_exist = 'EXIST';
        if($this->checkExistingEmail($email)){
            echo json_encode($email_exist);
        }else{
                //insert
               
                $this->insertUserNorm($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type);
        }
    }
    
    public function processSignupRest($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type, $rest_name){
        $email_exist = 'EXIST';
        if($this->checkExistingEmail($email)){
            echo json_encode($email_exist);
        }else{
                //insert
                $this->insertUserRest($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type, $rest_name);
        }
    }
    
    public function forgotpassword($email){
        
        if($this->checkExistingEmail($email)){
                    $generatedPassword =  $this->randomCode(7);
                    $no = 'NO';
                    $sql = "INSERT INTO forget_password VALUES (:forget_password_id, :user_email, :generated_password, :isUsed)";
                    $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':forget_password_id'=>"",
                                           ':user_email'=>$email,
                                           ':generated_password'=> md5($generatedPassword),
                                           ':isUsed'=>$no))){
                        $subject = 'New Password';
                        $to = $email;
                        $names = $this->getUserFLNameOrRestNameOrEstName($this->getUserID($email));
                        $header = EMAILHEADER;
                        $message = $this->newpasswordEmailBody($generatedPassword, $names, $email);
                        echo json_encode($this->verify($to, $subject, $message, $header, $names));
                    }else{
                         $errmessage = 'sorry something went wrong';
                         echo json_encode($errmessage);
                    }
        }else{
            $errmessage = 'could not associate email with an account.';
            echo json_encode($errmessage);
        }
       
    }
    
    public function ProcessForgetpasswordLogin($tempPassword, $newPassword, $email){
        $md5TempPassword = md5($tempPassword);
        $md5NewPassword = md5($newPassword);
        $no = 'NO';
        $yes = 'YES';
        $sql = "SELECT user_email FROM forget_password WHERE user_email = :email and generated_password = :temp_pw AND isUsed = :isUsed";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':email'=>$email,
                            ':temp_pw'=>$md5TempPassword,
                            ':isUsed'=>$no));
        $result = $sth->fetchAll();
  
        if(count($result) > 0){
            //update users with new password
            $Sql = "UPDATE users SET user_password = :newPassword WHERE user_email = :email";
            $sth = $this->db->prepare($Sql);
            if($sth->execute(array(':newPassword'=>$md5NewPassword,
                                ':email'=>$email))){
                    $mes = true;
                    
                    $sq = "UPDATE forget_password SET isUsed = :isUsed WHERE user_email = :email AND generated_password = :temp_pw";
                    $sth = $this->db->prepare($sq);
                    $sth->execute(array('email'=>$email, 'isUsed'=> $yes, ':temp_pw'=>$md5TempPassword));
                    echo json_encode($mes);
            }else{
                    $mes = false;
                    echo json_encode($mes);
            }
        }else{
                $mes = 'Your temp password is wrong';
                echo json_encode($mes);
        }
    }
    
    private function insertUserNorm($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type){
        $active = "ACTIVE";
        $code = $this->randomCode(7);
        $sql = "INSERT INTO users VALUES(:user_id, :user_email, :user_password, :user_type, :status, :signup_code, :signup_date, :on_off)";
        $sth = $this->db->prepare($sql);
        if($sth->execute(array(':user_id'=>'',
                            ':user_email'=>$email,
                            ':user_password'=> md5($password),
                            ':user_type'=>$user_type,
                            ':status'=> ZERO,
                            ':signup_code'=>$code,
                            ':signup_date'=>  time(),
                            ':on_off'=> $active)))
       {
            //send email
            $this->sendVerificationEmail($email, $firstName, $lastName, $code);
                    //insert into user_details
                    $id = $this->getUserID($email);
                    $sql = "INSERT INTO user_details (FirstName, LastName, city, country, user_type, user_id) VALUES (:firstName, :lastName, :city, :country, :user_type, :user_id)";
                    $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':firstName'=>$firstName, 
                                        ':lastName'=>$lastName, 
                                        ':city'=> $cur_city, 
                                        ':country'=>$cur_country,
                                        ':user_type'=>$user_type,
                                        ':user_id'=>$id))){
                        echo json_encode('INSERTED');
                    }else{
                        echo $sth->errorInfo();
                    }
       }else{
           echo $sth->errorInfo();
       }
    }
    
    
    private function insertUserRest($firstName, $lastName, $email, $password, $cur_city, $cur_country, $user_type, $rest_name){
        $code = $this->randomCode(7);
        $active = "ACTIVE";
        $sql = "INSERT INTO users VALUES(:user_id, :user_email, :user_password, :user_type, :status, :signup_code, :signup_date, :on_off )";
        $sth = $this->db->prepare($sql);
        if($sth->execute(array(':user_id'=>'',
                            ':user_email'=>$email,
                            ':user_password'=> md5($password),
                            ':user_type'=>$user_type,
                            ':status'=> ZERO,
                            ':signup_code'=>$code,
                            '::signup_date'=>  time(),
                            ':on_off'=>$active)))
       {
            //send email
            $this->sendVerificationEmail($email, $firstName, $lastName, $code);
                    //insert into user_details
                    $id = $this->getUserID($email);
                    $sql = "INSERT INTO user_details (FirstName, LastName, city, country, user_type, user_id) VALUES (:firstName, :lastName, :city, :country, :user_type, :user_id)";
                    $sth = $this->db->prepare($sql);
                    if($sth->execute(array(':firstName'=>$firstName, 
                                        ':lastName'=>$lastName, 
                                        ':city'=> $cur_city, 
                                        ':country'=>$cur_country,
                                        ':user_type'=>$user_type,
                                        ':user_id'=>$id)))
                    {
                        
                                        $sql = "INSERT INTO restaurant_users (user_id, restaurant_name) VALUES (:user_id, :restaurant_name)";
                                        $sth = $this->db->prepare($sql);
                                        if($sth->execute(array(':restaurant_name'=>$rest_name,':user_id'=>$id))){
                                            echo json_encode('INSERTED');
                                        }else{
                                            echo $sth->errorInfo();
                                        }
                    }else{
                        echo $sth->errorInfo();
                    }
       }else{
           echo var_dump($sth->errorInfo());
       }
  }
  
  private function sendVerificationEmail($email, $firstName, $lastName, $code){
      $subject = 'Verification Code';
      $to = $email;
      $header = EMAILHEADER;
      $name = $firstName." ".$lastName;
      $message = $this->getEmailBody($name, $code);
      $this->verify($to, $subject, $message, $header, $name);
  }
  
    private function getEmailBody($name, $code){
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
                                                                                <div style="  margin-left: 20px; margin-right: 20px; font-family: Arial; color: grey; font-size: 15px;">Thank you for signing up with enri. Please copy the code below for your verification. If you loose the confirmation dialog box, you can log in with your email and password to finish your confirmation. <br><br>We look forward to having you on enri.</div>
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
        
        
    private function newpasswordEmailBody($code, $names, $email){
        
        $message = '<html>
                        <head>
                         <meta charset="UTF-8">
                          <title></title>
                        </head>
                        <body >
                            <table  bgcolor="whitesmoke"  width= "700px">
                                <tr>
                                    <td colspan="3" width="500px" height ="500px" align="center">
                                                     <div  id="contain" style="width: 600px; height:500px; background: white; margin-top: 50px;" >
                                                          <a href="'.URL.'"><img src ="cid:enri_logo.png" width="80" style="margin-right: 400px; margin-top: 10px; width: 80px; "></a>
                                                        <div id="DetailsHolder" style="margin-top: 80px; ">

                                                                                        <div style=" margin-right: 305px; font-family: Arial; color: grey; font-size: 15px; margin-bottom:  04.28571428571429% ;">Hello '.$names.',</div>
                                                                                            <div style=" width: 450px; margin-left: 20px;  font-family: Arial; color: grey; font-size: 15px;">Please click on the link below or copy and paste it on your address bar, to use Your temporary password below.<br>
                                                                                                <br><a href="'.URL.'index/forgotpasswordlogin/'.md5(md5($code)).'/'.$email.'" style=" text-align: center; width: 200px; font-size: 12px;"><span style="width: 200px">'.URL.'index/forgotpasswordlogin/'.md5(md5($code)).'/'.$email.'</span></a>.
                                                                                            </div>
                                                                                            <div style="margin-top: 50px; margin-bottom: 5px; color: grey; font-size: 16px; font-weight: 700;">Temperary Password</div>
                                                                                            <div  style=" width: 200px; font-family: Arial; color: grey; font-size: 20px; text-align: center; margin-bottom: 50px;  background: whitesmoke; padding: 10px 5px 10px 5px;">'.$code.'</div>
                                                                                         </div>
                                                        </div>

                                        <div style=" font-family: Arial; font-size: 0.75em; color: grey;  margin-top: 50px;  margin-bottom: 30px;"><span style="padding-bottom: 15px;">&copy; copyright 2015 Enri Inc All rights reserved.</span><br><br> 39 Circular road, Elekahia Estate, RV, 500102</div>
                                    </td>
                                </tr>

                            </table>
                        </body>
                </html>';
        
        return $message;
    }
    
    private function randomCode($length) {
        $string = '';
        /* Only select from letters and numbers that are readable - no 0 or O etc..*/
        $characters = "123456789abcdefghijklmnopqrstuvwxyzABCDEFHJKLMNPRTVWXYZ";

        for ($p = 0; $p < $length; $p++) 
        {
            $string .= $characters[mt_rand(0, strlen($characters)-1)];
        }

        return $string;

     }
    
    private function checkExistingEmail($email){
        $sql = "SELECT user_email FROM users WHERE user_email = :user_email";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_email'=> $email));
        $Email = $sth->fetchAll();
        
        if(count($Email) === ZERO || empty($Email)){
            return false;
        }else{
            return true;
        }
         
    }
    
    

  
    
   
    //:::::::::::::::::::::::::::::private functions ends here   
}