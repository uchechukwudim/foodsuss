<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of terms
 *
 * @author Uche
 */
class terms extends Controller {
    //put your code here
    function __construct() {
        parent::__construct();
 
    }
    
    public function index(){
        
        if($this->sessionChecker()){
            $fileName = 'terms/logedin/index';
            $this->view->renderTerms($fileName);
        }else{
            $fileName = 'terms/logedout/index';
            $this->view->renderTerms($fileName);
        }
        
    }
}
