<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings_model
 *
 * @author Uche
 */
class settings_model extends Model {
    //put your code here
     function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->LastName = $this->getUserLastName($this->id);
        $this->Names = $this->getUserFLNameOrRestNameOrEstName($this->id);
        $this->image = $this->getUserImage($this->id);
        $this->DOB = $this->getDOB($this->id);
        $this->email = $_SESSION['user'];
        $this->userType = $this->getUserType($this->id);
       
    }
    
    public function index()
    {
         $this->view->css =  Array('css/settings/settingssheet.css',
                                 'css/settings/settingsaccount.css',
                                'css/settings/settingspassword.css',
                                 'css/settings/passwordDialogBox.css',
                         'css/foodfinder/food/errorDialgBoxSheet.css');
         
        $this->view->js = Array('settings/js/accountUpdate.js',
                                'settings/js/passwordChange.js',
                                 'settings/js/settings.js');
        
        $this->view->renderSettings("settings/index", $this->Names, $this->FirstName, $this->LastName, $this->userType, $this->image, $this->email, $this->DOB);
    }
    
    
  public function updateInfo($firstName, $lastName, $email, $password, $date)
    {
        $sqlp = "SELECT user_password FROM users WHERE user_id = :user_id AND user_password = :password";
        $sthp = $this->db->prepare($sqlp);
        $sthp->setFetchMode(PDO::FETCH_ASSOC);
        $sthp->execute(array(
            ':user_id' =>  $this->id,
            ':password' =>  md5($password)
        ));
        $pWord = $sthp->fetchAll();
        
        if(count($pWord)==0)
        {
            //show error message
            $ermessage = false;
            echo json_encode($ermessage);
        }
        else
        {
                //update user stuff here
                 $sql = "UPDATE user_details SET FirstName = :firstName, LastName = :lastName, DOB = :dob WHERE user_id= :user_id";
                 $sql1 = "UPDATE users SET user_email = :email WHERE user_id = :user_id";
                 $sth = $this->db->prepare($sql);
                 $sth1 = $this->db->prepare($sql1);
                if($sth->execute(array(
                    ':firstName' => $firstName,
                    ':lastName' => $lastName,
                    ':dob' => $date,
                    ':user_id' => $this->id
                )) && $sth1->execute(array(':email'=>$email, ':user_id'=>  $this->id)))
                {
                     $ermessage = true;
                    echo json_encode($ermessage);
                }
                else
                {
                    echo json_encode($sth->errorInfo());
                }
        }
         
    }
    
    public function changePassword($current_pword, $new_password)
    {
        $sqlp = "SELECT user_password FROM users WHERE user_id = :user_id AND user_password = :password";
        $sthp = $this->db->prepare($sqlp);
        $sthp->setFetchMode(PDO::FETCH_ASSOC);
        $sthp->execute(array(
            ':user_id' =>  $this->id,
            ':password' =>  md5($current_pword)
        ));
        $pWord = $sthp->fetchAll();
        
        if(count($pWord)=== ZERO)
        {
            //show error message
            $ermessage = "Your current password is wrong. Please try again";
            echo json_encode($ermessage);
        }
        else if(count($pWord)> 0 && $pWord[ZERO]['user_password'] == md5($new_password))
        {
            $erMessage = "Your new password is the same as your old password.<br><br> Please Enter new Password";
            echo json_encode($erMessage);
        }
        else
        {
            $sql = "UPDATE users SET user_password = :password WHERE user_id = :user_id";
            $sth = $this->db->prepare($sql);
            if($sth->execute(array(':password'=>md5($new_password), ':user_id'=>  $this->id)))
            {
                //show confirmation message
                $ermessage = "Your password has been updated";
                echo json_encode($ermessage);
            }
            else
            {
                echo json_encode($sth->errorInfo());
            }
                
        }
    }
    
    
    public function deactivate(){
        $inactive = "INACTIVE";
        $sql = "UPDATE users SET on_off = :inactive WHERE user_id = :user_id";
        $sth = $this->db->prepare($sql);
        if($sth->execute(array(':inactive'=> $inactive, ':user_id'=>$this->id))){
            echo json_encode(true);
        }else{
            echo json_encode($sth->errorInfo());
        }
    }
}
