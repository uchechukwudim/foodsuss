<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of aboutus
 *
 * @author Uche
 */
class aboutus extends Controller{
    //put your code here
     function __construct() {
        parent::__construct();
 
    }
    
    public function index(){
        
        if($this->sessionChecker()){
             $fileName = 'aboutus/logedin/index';
             $this->view->renderAboutus($fileName);
        }else{
                $fileName = 'aboutus/logedout/index';
                $this->view->renderAboutus($fileName);
        }
       
    }
}
