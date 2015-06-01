<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of notification
 *
 * @author Uche
 */
class notifier extends Controller{
    //put your code here
     function __construct() {
          parent::__construct();
          $this->sessionCheck(); 
          
          $this->notifiers = array('follow', 'friend', 'recipePostComment', 'foodFollow', 'eatWithPostCommentTasty',
                                   'cookedRecipe', 'tastyRecipe', 'sharedRecipe', 'recipeENPostComment', 
                                   'cookedRecipeEN', 'tastyRecipeEN', 'sharedRecipeEN', 'cookBoxNotify', 'foodFollowAll', 'asktojoinNotify');
    }
    
    public function index()
    {
        if(isset( $_POST['object_id']) && isset($_POST['reciever_user_id']))
        {
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $object_id = $_POST['object_id'];
            $reciever_user_id = $_POST['reciever_user_id'];
            $this->$notify($object_id, $reciever_user_id, $notify);
        }
        else if(isset($_POST['object_id']) && !(isset($_POST['reciever_user_id'])))
        { 
             $this->indexUserRPWorkings();
             $this->indexENworkings();
             $this->indexShowWorkings();
        }
        else if(isset ($_POST['reciever_user_id1']) && isset ($_POST['reciever_user_id2']))
        {
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $reciever_user_id1 = $_POST['reciever_user_id1'];
            $reciever_user_id2 = $_POST['reciever_user_id2'];
            $this->$notify($reciever_user_id1, $reciever_user_id2, $notify);
        }else{
            $fileName = "error/logedinError/index";
            $this->view->renderLogedinError($fileName);
        }
        
    }
    
    private function follow($reciever_user_id1, $reciever_user_id2, $notify)
    {
        $this->model->follow($reciever_user_id1, $reciever_user_id2, $notify);
    }
    
    private function friend($reciever_user_id1, $reciever_user_id2, $notify)
    {
        $this->model->friend($reciever_user_id1, $reciever_user_id2, $notify);
    }
    
    private function recipePostComment($recipe_post_id, $reciever_user_id, $notify)
    {
        $this->model->recipePostComment($recipe_post_id, $reciever_user_id, $notify);
    }
    
     private function recipeENPostComment($recipe_id, $food_id, $country_id, $notify)
     {
        $this->model->recipeENPostComment($recipe_id, $food_id, $country_id, $notify);
     }
    
     
    private function foodFollow($food_id, $country_id, $notify)
    {
        $this->model->foodFollow($food_id, $country_id, $notify);
    }
    
    private function foodFollowAll($food_id, $notify){
        $this->model->foodFollowAll($food_id, $notify);
    }
    
    private function eatWithPostCommentTasty($eatWith_id, $which, $notify)
    {
        $this->model->eatWithPostCommentTasty($eatWith_id, $which, $notify);
    }
    
    
    private function cookedRecipe($object_id, $reciever_user_id, $notify)
    {
        $this->model->cookedRecipe($object_id, $reciever_user_id, $notify);
    }
    
    private function tastyRecipe($object_id, $reciever_user_id, $notify)
    {
        $this->model->tastyRecipe($object_id, $reciever_user_id, $notify);
    }
    
    private function sharedRecipe($object_id, $reciever_user_id, $notify)
    {
        
        $this->model->sharedRecipe($object_id, $reciever_user_id, $notify);
    }
    
    private function cookedRecipeEN($recipe_id, $notify)
    {
        
        $this->model->cookedRecipeEN($recipe_id, $notify);
    }
    
    
     
    private function tastyRecipeEN($recipe_id, $notify)
    {
        
        $this->model->tastyRecipeEN($recipe_id, $notify);
    }
     
    private function sharedRecipeEN($recipe_id, $notify)
    {
        
        $this->model->sharedRecipeEN($recipe_id, $notify);
    }
    
    private function cookBoxNotify($recipe_id, $recipe_owner_id, $notify){
        $this->model->cookBoxNotify($recipe_id, $recipe_owner_id, $notify);
    }
    
    
    
    
    
    private function indexENworkings()
    {
        $nine = 9; $ten = 10; $eleven = 11; $four = 4; 
        if((int)$_POST['index'] === $nine){     
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $recipe_id = $_POST['object_id'];
            $this->$notify($recipe_id, $notify);
        }
        
        if((int)$_POST['index'] === $ten) {
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $recipe_id = $_POST['object_id'];
            $this->$notify($recipe_id, $notify);
        }
       
        if((int)$_POST['index'] === $eleven) {
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $recipe_id = $_POST['object_id'];
            $this->$notify($recipe_id, $notify);
        }
        
        if((int)$_POST['index'] === $four) {
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $eatWith_id = $_POST['object_id'];
            $which = $_POST['which'];
            $this->$notify($eatWith_id, $which, $notify);
        }
        
       
    }
    
    private function indexUserRPWorkings()
    {
               $eight = 8; $three = 3; $thirteen = 13;
         if((int)$_POST['index'] === $eight){
                $index = $_POST['index'];
                $notify = $this->notifiers[$index];
                $recipe_id = $_POST['object_id'];
                $food_id = $_POST['food_id'];
                $country_id = $_POST['country_id'];
                $this->$notify($recipe_id, $food_id, $country_id, $notify);
            }
            
            if((int)$_POST['index'] === $three){
                    $index = $_POST['index'];
                    $notify = $this->notifiers[$index];
                    $country_id = $_POST['country_id'];
                    $food_id = $_POST['object_id'];
                    $this->$notify($food_id, $country_id, $notify);
            }
            
            if((int)$_POST['index'] === $thirteen){
                 $index = $_POST['index'];
                 $notify = $this->notifiers[$index];
                 $food_id = $_POST['object_id'];
                 $this->$notify($food_id, $notify);
            }
    }
    
    private function indexShowWorkings(){
        $fourtin = 14;
         if((int)$_POST['index'] === $fourtin){
            $index = $_POST['index'];
            $notify = $this->notifiers[$index];
            $cookwith_id= $_POST['object_id'];
            $this->model->$notify($cookwith_id, $notify);
        }
    }
    
    
    public function getNotification(){
    
       $this->model->getNotification();
    }
    
    public function getNotificatioinCount(){
        $this->model->getNotificatioinCount();
    }
    
    public function showNotification($recipe_post_id, $which =''){
    
           $dec_user_id = $this->decrypt($recipe_post_id);
            $this->model->showNotificaton($dec_user_id, $which);
    }
    
}
