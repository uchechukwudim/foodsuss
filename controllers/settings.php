<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of settings
 *
 * @author Uche
 */
class settings extends Controller{
    //put your code here
       function __construct() {
          parent::__construct();
          $this->sessionCheck();
    }
    
    public function index()
    {
        $this->model->index();
    }
    
    function updateInfo()
    {
        $password = $_POST['password'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $email = $_POST['Email'];
        $date = $_POST['date'];
        
        $this->model->updateInfo($firstName, $lastName, $email, $password, $date);
    }
    
    function changePassword()
    {
        $current_pword = $_POST['currentPassword'];
        $new_password = $_POST['newPassword'];

        $this->model->changePassword($current_pword, $new_password);
    }
    
    public function deactivate(){
        if(isset($_POST['deact_code'])){
            $this->model->deactivate();
        }else{
            $this->model->index();
        }
    }
}
