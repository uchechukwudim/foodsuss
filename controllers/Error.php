<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Uche
 */
class Error extends Controller{
    //put your code here
    function __construct() {
          parent::__construct();
          
    }
    
    public function index(){
        if($this->sessionErrorChecker()){
            $fileName = 'error/logedinError/index';
            $this->view->renderLogedinError($fileName);
        }else{
            $fileName = 'error/logedoutError/index';
            $this->view->renderLogedoutError($fileName);
        }
    }
    
 
}
