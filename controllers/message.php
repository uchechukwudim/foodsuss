<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of message
 *
 * @author Uche
 */
class message extends Controller{
    //put your code here
    function __construct() {
          parent::__construct();
         $this->sessionCheck();
          
          
    }
    
    public function index()
    {
        $fileName = "message/index";
        $this->view->renderMessage($fileName);
    }
}
