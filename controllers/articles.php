<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of articles
 *
 * @author Uche
 */
class articles extends Controller{
    //put your code here
    
    function __construct() {
          parent::__construct();
          $this->sessionCheck();
          
          
    }
    
    public function index(){
        $this->model->index();
    }
    
    public function gudRead(){
        if(isset($_POST['article_id'])){
            $article_id = $_POST['article_id'];
            
            $this->model->gudRead($article_id);
        }
    }
    
    public function shareArticle(){
         if(isset($_POST['article_id'])){
            $article_id = $_POST['article_id'];
            
            $this->model->shareArticle($article_id);
        }
    }
    
    public function showAllComment(){
        if(isset($_POST['article_id'])){
            $article_id = $_POST['article_id'];
            
            $this->model->showAllComment($article_id);
        }
    }
    
    public function postUserComment(){
        if(isset($_POST['comment']) && isset($_POST['article_id'])){
            $comment = $_POST['comment'];
            $artile_id = $_POST['article_id'];
            
            $this->model->postUserComment($comment, $artile_id);
        }
    }
    
    public function getArticleCommentPost(){
        if(isset($_POST['article_id'])){
            $article_id = $_POST['article_id'];
            $this->model->getArticleCommentPost($article_id);
        }
        
    }
    
    public function getUserCommentCount(){
        if(isset($_POST['article_id'])){
            $article_id = $_POST['article_id'];
            $this->model->getUserCommentCount($article_id);
        }
    }
}
