<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of eatWith
 *
 * @author Uche
 */
class eatWith extends Controller{
    //put your code here
     function __construct() {
          parent::__construct();
         $this->sessionCheck();
          
          
    }
    
    public function index()
    {
        $this->model->index();
    }
    
    public function postUserComment()
    {
       $eatWith_id =  $_POST['eatWith_id'];
       $commentText = $_POST['commentText'];
       
       $this->model->postUserComment($eatWith_id, $commentText);
 
    }
    
    public function inserteatWithLikes()
    {
         $eatWith_id =  $_POST['eatWith_id'];
         
         $this->model->inserteatWithLikes($eatWith_id);
    }
    
    public function showEatWithUserComment(){
        if(isset($_GET['eatWith_id'])){
            $eatWith_id = $_GET['eatWith_id'];
            $this->model->showEatWithUserComment($eatWith_id);
        }
    }
    
    public function infinitScrollEatWithLoader()
    {
        $pages = $_POST['page'];
        
        $this->model->infinitScrollEatWithLoader($pages);
    }
    
    function processEatWithRequest()
    {
       $erMessage = '';
        
        $accepted_image_ext = array('jpg', 'png', 'jpeg', 'gif');
        $accepted_video_ext =array('mp4', 'mov', 'ogg', 'wmv');
         if(isset($_FILES))
         {
             if(empty($_FILES))
             {
                 $erMessage .= 'File exceeds the maximum size';
                 echo json_encode($erMessage);
             }
             else
             {
                 $this->init($accepted_image_ext, $accepted_video_ext);
             }
         }
        
    }
    
    private function init($accepted_image_ext, $accepted_video_ext)
    {
                    $exploadWith = '.';
                    $description = $_POST['description'];
                    $file_name = $_FILES['file']['name'];
                    $exp_name = explode($exploadWith , $file_name);
                    $ext = end($exp_name);
                    $file_ext = strtolower($ext);
                    $file_size = $_FILES['file']['size'];
                    $file_temp = $_FILES['file']['tmp_name'];
                    $vid_pic = $this->getWhichEatWith($accepted_image_ext, $accepted_video_ext, $file_ext);

                    if($this->processImageEat($file_name, $file_ext, $file_size, $file_temp))
                    {
                        $this->goToModelUploadEatWith($file_name, $file_temp, $vid_pic, $description, $file_ext);
                    }
    }
    
    private function goToModelUploadEatWith($file_name, $file_temp, $vid_pic, $description, $file_ext)
    {
         $pic = 'Pic'; $vid = 'Vid';
        if($vid_pic === $pic){
            $imageData = file_get_contents($file_temp);
            $imageName = $file_name;
            $this->model->processEatWithRequest($imageName,  $imageData, $vid_pic, $description, $file_ext);
        }else if($vid_pic === $vid)
        {
             $imageName = $file_name;
             $this->model->processEatWithRequest($imageName, $file_temp, $vid_pic, $description, $file_ext);
        }
    }
    
    private function getWhichEatWith($accepted_image_ext, $accepted_video_ext, $file_ext)
    {
        $pic = 'Pic'; $vid = 'Vid';
        if(in_array($file_ext, $accepted_image_ext))
        {
            return $pic;
        }
        else if(in_array($file_ext, $accepted_video_ext))
        {
            return $vid;
        }
    }
    private function processImageEat($file_name, $file_ext,  $file_size, $file_temp)
    {
     static $maxSize = 3145728;
     $errors = '';
     $accepted_image_ext = array('jpg', 'png', 'jpeg', 'gif', 'mp4', 'mov', 'ogg', 'wmv');
     $accepted_video_ext =array('mp4', 'mov', 'ogg', 'wmv');
     $Image = array();
     
      if(in_array($file_ext, $accepted_image_ext) === false)
      {
          $errors .= 'Only Image/Video allowed';
      }
      
      if($file_size >$maxSize)
      {
          $errors .= 'File exceeds the maximum size';
      }
      
      if(empty($errors))
      {
         return true;
                  
      }
      else
      {
          echo json_encode($errors);
          
      }
  }
  
}
