<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of articles_model
 *
 * @author Uche
 */
class articles_model extends Model {
    //put your code here
     function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->CURL = new C_Url();
        ///$this->view = new View();
        
    }
    
    public function index(){
        $restuarant = 'Restaurant';
        $this->view->js = array('articles/js/articlesheet.js',
                                'foodfinder/productsDialog/js/productjsFunctions.js',
                                'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                'profile/js/friendsFollowers.js'
                                );
        $this->view->css = array( 'css/articles/articlesheet.css',
                                 'css/foodfinder/food/errorDialgBoxSheet.css',
                                  'css/foodfinder/productsDialog/productsheet.css',
                                  'css/profile/followfriendssheet.css');
        $this->view->id = $this->id;
        
        $sql0 = "SELECT FirstName, LastName, picture, user_type FROM user_details WHERE user_id = :user_id";
        $sth0 = $this->db->prepare($sql0);
        $sth0->setFetchMode(PDO::FETCH_ASSOC);
        $sth0->execute(array(':user_id'=>  $this->id));
        $userDetails = $sth0->fetchAll();
        $fileName = "articles/index";
        
        $sql = "SELECT Art.article_id, Art.article_title, Art.article, Art.article_desc, Art.article_link, Art.user_id,
                Art.article_picture_cover, Art.timestamp, UD.FirstName, UD.LastName, UD.picture, 
                CASE UD.user_type WHEN :Rest THEN (SELECT restaurant_name FROM restaurant_users WHERE user_id = Art.user_id) 
                END AS Restaurant FROM articles AS Art 
                INNER JOIN user_details AS UD ON UD.user_id = Art.user_id
                ORDER BY Art.timestamp DESC LIMIT 0, 6";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array("Rest" => $restuarant));
        $article = $sth->fetchAll();
        $article_comments = $this->getArticleComment($article);
        $article_likes_counts = $this->getArticleLike($article);
        $article_share_counts = $this->getArticleShare($article);
       
        $this->view->renderArticle($fileName, $userDetails, $article, $article_comments, $article_likes_counts, $article_share_counts);
    }
    
    private function getArticleComment($article){
          $restuarant = 'Restaurant';
          $article_comment = Array();
        for($looper = 0; $looper < count($article); $looper++){
            $sql = "SELECT ArtC.comment, ArtC.user_id, ArtC.time, UD.FirstName, UD.LastName, UD.picture, CASE UD.user_type WHEN :Rest 
                    THEN (SELECT restaurant_name FROM restaurant_users WHERE user_id = ArtC.user_id) 
                    END AS Restaurant FROM article_comments AS ArtC 
                    INNER JOIN user_details AS UD ON UD.user_id = ArtC.user_id
                    WHERE ArtC.article_id = :article_id ORDER BY ArtC.time ASC";
                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(":Rest" => $restuarant, 
                                        ":article_id" => $article[$looper]['article_id']));
                    $article_comment[$looper] = $sth->fetchAll();
        }
        
        return $article_comment;
    }
    
    private function getArticleLike($article){
        $article_likes_count = Array();
        for($looper = 0; $looper < count($article); $looper++){
            $article_id = $article[$looper]['article_id'];
            
            $sql1 = "SELECT user_id FROM article_likes WHERE article_id = :article_id";
            $sth1 = $this->db->prepare($sql1);
            $sth1->setFetchMode(PDO::FETCH_ASSOC);
            $sth1->execute(array(":article_id" => $article_id));
            $res1 = $sth1->fetchAll();
            $article_likes_count[$looper] = count($res1);
            
        }
        return  $article_likes_count;
    }
    
     private function getArticleShare($article){
        $article_share_count = Array();
        for($looper = 0; $looper < count($article); $looper++){
            $article_id = $article[$looper]['article_id'];
            
            
            $sql2 = "SELECT user_id FROm article_share WHERE article_id = :article_id";
            $sth2 = $this->db->prepare($sql2);
            $sth2->setFetchMode(PDO::FETCH_ASSOC);
            $sth2->execute(array(":article_id" => $article_id));
            $res2 = $sth2->fetchAll();
            $article_share_count[$looper] = count($res2);
            
        }
        return $article_share_count;
    }
    
    
    
   public function gudRead($article_id){
       $sql = "SELECT user_id FROM article_likes WHERE user_id = :user_id AND article_id = :article_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(':user_id' => $this->id, ':article_id'=> $article_id));
       
       $res = $sth->fetchAll();
       if(count($res) === ZERO){
           echo json_encode($this->insertIntoArticleLike($article_id));
       }
           
       
   }
   
   private function insertIntoArticleLike($article_id){
       $sql = "INSERT INTO article_likes VALUES (:article_likes_id, :article_id, :user_id)";
       $sth = $this->db->prepare($sql);
       if($sth->execute(array(':article_likes_id' => EMPTYSTRING,
                            ':article_id' => $article_id,
                            ':user_id'=> $this->id))){
           return true;
       }else{
           return false;
       }
   }
   
   
   public function shareArticle($article_id){
        $sql = "SELECT user_id FROM article_share WHERE user_id = :user_id AND article_id = :article_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(':user_id' => $this->id, ':article_id'=> $article_id));
       
       $res = $sth->fetchAll();
       if(count($res) === ZERO){
           echo json_encode($this->insertIntoArticleShare($article_id));
       }
   }
   
   private function insertIntoArticleShare($article_id){
        $sql = "INSERT INTO article_share VALUES (:article_share_id, :article_id, :user_id)";
       $sth = $this->db->prepare($sql);
       if($sth->execute(array(':article_share_id' => EMPTYSTRING,
                              ':article_id' => $article_id,
                              ':user_id'=> $this->id))){
           return true;
       }else{
           return false;
       }
   }
   
   public function showAllComment($article_id){
       
       $restuarant = 'Restaurant';
       $sql = "SELECT ArtC.comment, ArtC.user_id, ArtC.time, UD.FirstName, UD.LastName, UD.picture, CASE UD.user_type WHEN :Rest 
                    THEN (SELECT restaurant_name FROM restaurant_users WHERE user_id = ArtC.user_id) 
                    END AS Restaurant FROM article_comments AS ArtC 
                    INNER JOIN user_details AS UD ON UD.user_id = ArtC.user_id
                    WHERE ArtC.article_id = :article_id ORDER BY ArtC.time ASC";
                    $sth = $this->db->prepare($sql);
                    $sth->setFetchMode(PDO::FETCH_ASSOC);
                    $sth->execute(array(":Rest" => $restuarant, 
                                        ":article_id" => $article_id));
                    $article_comment= $sth->fetchAll();
                    
        echo json_encode($this->loadUserComment($article_comment));
   }
    
   
    private function loadUserComment($userComments){
        $output = '';
        for($looper = 0; $looper < count($userComments); $looper++){
            $name = '';
            if($userComments[$looper]['Restaurant'] === 'NULL' || $userComments[$looper]['Restaurant'] === NULL ){
                $name = '<a href="'.URL.'profile/user/'.$this->encrypt($userComments[$looper]['user_id']).'">'.$userComments[$looper]['FirstName'].' '.$userComments[$looper]['LastName'].'</a>';
            }else{
               $name = '<a href="'.URL.'profile/user/'.$this->encrypt($userComments[$looper]['user_id']).'">'.$userComments[$looper]['Restaurant'].'</a>';
            }
            
            $output .='<div class="user_photo"><img src="data:image/jpeg;base64,'.base64_encode($userComments[$looper]["picture"]).'" width="35"></div>
                        <div class="user_name"><b><a href="'.URL.' profile/user/'.$this->encrypt($userComments[$looper]["user_id"]).'">'.$name.'</a></b></div> <div class="postTime">'.$this->timeCounter($userComments[$looper]["time"]).'</div>
                        <div class="user_comment">
                         '.$userComments[$looper]["comment"].'
                        </div>';
        }
        return $output;
    }
    
    public function postUserComment($comment, $article_id){
        if(!$this->checkIfCommentExist($comment, $article_id)){
            $sql = "INSERT INTO article_comments VALUES (:article_comments_id, :article_id, :comment, :user_id, :time)";
            $sth = $this->db->prepare($sql);
            if($sth->execute(array(':article_comments_id' => EMPTYSTRING,':article_id' => $article_id,
                                ':comment' => $comment,
                                ':user_id' => $this->id,
                                ':time' => time()))){
                    echo json_encode(true);
            }else{
                echo json_encode(false);
            }
        }else{
            $message = "You can't post one comment twice";
            echo json_encode($message);
        }
    }
    
    private function checkIfCommentExist($comment, $article_id){
        $sql = "SELECT article_comments_id FROM article_comments WHERE comment = :comment AND article_id = :article_id AND user_id = :user_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':comment' => $comment,
                            ':article_id' => $article_id,
                            ':user_id' => $this->id));
        $result = count($sth->fetchAll());
        
        if($result === ZERO){
            return false;
        }else{
            return true;
        }
        
    }
    
   public function getArticleCommentPost($article_id){
       $this->showAllComment($article_id);
   }
   
   public function getUserCommentCount($article_id){
       $sql = "SELECT article_id FROM  article_comments WHERE article_id = :article_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(':article_id' => $article_id));
       $result = count($sth->fetchAll());
       
       echo json_encode($result);
   }
}

