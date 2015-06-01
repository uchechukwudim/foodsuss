<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of sideBar
 *
 * @author Uche
 */
class sideBar extends Controller{
    //put your code here
     function __construct() {
          parent::__construct();
          $this->sessionCheck(); 
    }
    
    public function index(){
             $fileName = "error/logedinError/index";
            $this->view->renderLogedinError($fileName);
    }
            
    function foodFollow()
    {
        $modelName = "sideBarFoodFollow";
        $this->loadModel($modelName);
        $this->model->foodFollow();
    }
    
    
    
    
    function followChef()
    {
        $modelName = "sideBarFollowChef";
        $this->loadModel($modelName);
        $this->model->followChef();
    }
    
    
    function FollowRestaurant()
    {
        $modelName = "sideBarFollowRestaurant";
        $this->loadModel($modelName);
        $this->model->FollowRestaurant();
    }
    
    
    
    function infinityFollowChef()
    {
        $page = $_GET['page'];
        $modelName = "sideBarFollowChef";
        $this->loadModel($modelName);
        $this->model->infinityFollowChef($page);
    }
    
    
    function infinityFollowRestaurant()
    {
        $page = $_GET['page'];
        $modelName = "sideBarFollowRestaurant";
        $this->loadModel($modelName);
        $this->model->infinityFollowRestaurant($page);
    }
    
    function infinityFollowFood()
    {
        $page = $_GET['page'];
        $modelName = "sideBarFoodFollow";
        $this->loadModel($modelName);
        $this->model->infinityFoodFollow($page);
    }
}
