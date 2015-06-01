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
class eatWith_model extends Model {
    //put your code here
    function __construct()
     {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
      
     }
     
     public function index()
     {
                 
         $this->view->css = array('css/eatWith/eatwith.css',
                                   'css/eatWith/eatwithdialogbox.css',
                                  'css/profile/followfriendssheet.css',
                                  'css/foodfinder/food/errorDialgBoxSheet.css',
                                 'css/foodfinder/productsDialog/productsheet.css'
                                 );
         
         $this->view->js = array('eatWith/js/eatwith.js',
                                 'eatWith/js/uploadImage.js',
                                 'eatWith/js/eatWithUpload.js',
                                 'foodfinder/js/foodfinder.js',
                                 'foodfinder/food/js/foodpage.js', 
                                 'foodfinder/food/js/tooltip.js',
                                 'foodfinder/productsDialog/js/productjsFunctions.js',
                                 'foodfinder/productsDialog/js/runProductsjsFunctions.js',
                                 'profile/js/friendsFollowers.js');
         
         
        $sql0 = "SELECT FirstName, LastName, picture FROM user_details WHERE user_id = :user_id";
        $sth0 = $this->db->prepare($sql0);
        $sth0->setFetchMode(PDO::FETCH_ASSOC);
        $sth0->execute(array(':user_id'=>  $this->id));
        $userDetails = $sth0->fetchAll();
        
        //
        $sql1 = "SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time,  US.user_type, US.picture, EW.user_id
                FROM eatwith AS EW
                INNER JOIN user_details AS US ON EW.user_id = US.user_id
                WHERE EW.user_id = :user_id
                
                UNION 
                
                SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time,  US.user_type, US.picture, EW.user_id
                FROM eatwith AS EW
                INNER JOIN user_details AS US ON EW.user_id = US.user_id
                INNER JOIN friends AS F ON EW.user_id = F.user_id
                AND F.user_friend_id = :user_id
                
                UNION 
                
                SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time, US.user_type, US.picture, EW.user_id
                FROM eatwith AS EW
                INNER JOIN user_details AS US ON EW.user_id = US.user_id
                INNER JOIN friends AS F ON EW.user_id = F.user_friend_id
                AND F.user_id = :user_id
                ORDER BY posted_time ASC LIMIT 0, 8";
        
                $sth1 = $this->db->prepare($sql1);
                $sth1->setFetchMode(PDO::FETCH_ASSOC);
                $sth1->execute(array(':user_id'=>  $this->id));
                $eatWith = $sth1->fetchAll();
          
                //get user picture and video  and counts
                $pic = 'Pic';
                $sql2 = "SELECT * FROM eatwith WHERE user_id = :user_id AND Which =:which_pic";
                $sth2 = $this->db->prepare($sql2);
                $sth2->setFetchMode(PDO::FETCH_ASSOC);
                $sth2->execute(array(':user_id'=>  $this->id, ':which_pic'=>$pic));
                $userPctures = $sth2->fetchAll();
                $userPicCount = count($userPctures);
                
                $vid = 'Vid';
                $sql3 = "SELECT * FROM eatwith WHERE user_id = :user_id AND Which =:which_vid";
                $sth3 = $this->db->prepare($sql3);
                $sth3->setFetchMode(PDO::FETCH_ASSOC);
                $sth3->execute(array(':user_id'=>  $this->id, ':which_vid'=> $vid));
                $userVideos = $sth3->fetchAll();
                $userVidCount = count($userVideos);
                
                //get eatWith likes
                $eatWithLikeCount = $this->getEatWithLikes($eatWith);
                
                //get eatWithUserComments
                $eatWithUserComments = $this->getEatWithUserComments($eatWith);
                
                $newEatWith = $this->getUserNames($eatWith);
            
         $this->view->renderEatWith("eatWith/index", $userDetails, $newEatWith, $userPicCount, $userVidCount, $eatWithLikeCount,  $eatWithUserComments);
     }
     
     private function getUserNames($eatWith){
         for($looper =0; $looper < count($eatWith); $looper++){
             $eatWith[$looper]['userNames'] = $this->getUserFLNameOrRestNameOrEstName($eatWith[$looper]['user_id']);
         }
         
         return $eatWith;
     }
     
     private function getEatWithLikes($eatWith)
     {
         $eatWithLikes = array();
         
         for($looper =0; $looper < count($eatWith); $looper++)
         {
             $sql = "SELECT user_id FROM eatwith_likes WHERE eatWith_id = :eatWith_id";
             $sth = $this->db->prepare($sql);
             $sth->setFetchMode(PDO::FETCH_ASSOC);
             $sth->execute(array(':eatWith_id' => $eatWith[$looper]['eatWith_id']));
             
             $eatWithuserLike = $sth->fetchAll();
             
             $eatWithLikes[$looper] = count($eatWithuserLike);
             
         }
         
         return $eatWithLikes;
     }
     
     private function getEatWithUserComments($eatWith)
     {
         $details = array();
         $eatWith_Details = '';
         for($looper=0; $looper <count($eatWith); $looper++)
         {
             $sql = "SELECT user_id, user_comment, comment_time FROM eatwith_comments WHERE eatWith_id = :eatWith_id";
             $sth = $this->db->prepare($sql);
             $sth->setFetchMode(PDO::FETCH_ASSOC);
             $sth->execute(array(':eatWith_id' => $eatWith[$looper]['eatWith_id']));
             $data = $sth->fetchAll();
             
             $eatWith_Details[$looper] = $this->getDetails($data, $details); 
         }
         
         return $eatWith_Details;
     }
     
     private function getDetails($data, $details)
     {
          for($i =0; $i < count($data); $i++)
          {
            $details[$i]['user_id'] = $data[$i]['user_id'];
            $details[$i]['userNames'] = $this->getUserFLNameOrRestNameOrEstName($data[$i]['user_id']);
            $details[$i]['image'] = $this->getUserImage($data[$i]['user_id']);
            $details[$i]['time'] = $data[$i]['comment_time'];
            $details[$i]['commentText'] = $data[$i]['user_comment'];
          }
          return $details;
     }
     
     
     public function showEatWithUserComment($eatWith_id){
           $details = array();
           $result= '';
         $sql = "SELECT user_id, user_comment, comment_time FROM eatwith_comments WHERE eatWith_id = :eatWith_id ";
             $sth = $this->db->prepare($sql);
             $sth->setFetchMode(PDO::FETCH_ASSOC);
             $sth->execute(array(':eatWith_id' => $eatWith_id));
             $data = $sth->fetchAll();
             
             $eatWithUserComments = $this->getDetails($data, $details); 
             for($loop = THREE; $loop < count($eatWithUserComments); $loop++)
                    { 

                       $result .= '<div class="userComment">
                           <img src="data:image/jpeg;base64,'.base64_encode($eatWithUserComments[$loop]['image']).'" width="40" height="40" alt=""><span>'.$eatWithUserComments[$loop]['userNames'].'</span>   
                           <div class="userCommentText">
                              '.$eatWithUserComments[$loop]['commentText'].'
                           </div>
                       </div>';
                   }
             echo json_encode($result);
     }
     
     
     //ajex request functions start here
     
     public function processEatWithRequest($name, $file, $vid_pic, $description, $ext)
     {
              $pic = 'Pic'; $vid = 'Vid';

          if($vid_pic === $pic) {
              if(!$this->isDublicate($this->id, $name, $vid_pic)){
                  //insert
                  $this->insertPicture($this->id, $name, $file, $vid_pic, $description);
              }
          }
          else if($vid_pic === $vid){
               if(!$this->isDublicate($this->id, $name, $vid_pic)){
                  //insert
                   $path = "".Video.$this->getEmail($this->id);//windows
                   $path1 = "".VideoDB.$this->getEmail($this->id)."/";
                   
                   if(!$this->isDirCreated($path)){ $this->createDir($path); }
                
                   $file_path = $path."\\".$name; //windows path
                   $db_file_path = $path1.$name;
                   
                   $this->insertVideo($this->id, $name, $file, $file_path, $db_file_path, $vid_pic, $description);
              }
          }
     }

 private function insertVideo($user_id, $name, $file, $file_path, $db_file_path, $vid_pic, $description)
 {
     $empty = '';
     $sql = "INSERT INTO eatwith VALUES(:eatWith_id, :user_id, :name, :eatWith_picture, :video, :description, :Which, :posted_time) ";
     $sth = $this->db->prepare($sql);
     if($sth->execute(array(':eatWith_id'=>'',
                         ':user_id'=>$user_id,
                         ':name'=>$name,
                         ':eatWith_picture'=>$empty,
                         ':video'=>$db_file_path,
                         ':description'=>$description,
                         ':Which'=>$vid_pic,
                         ':posted_time'=>time())))
     {
         
        //move file 
        move_uploaded_file($file, $file_path);
         $erMessage = "Your video has been uploaded";
         echo json_encode($erMessage);
     }
 }
 
 private function insertPicture($user_id, $name, $imageData, $vid_pic, $description)
 {
     $empty = '';
     $sql = "INSERT INTO eatwith VALUES(:eatWith_id, :user_id, :name, :eatWith_picture, :video, :description, :Which, :posted_time) ";
     $sth = $this->db->prepare($sql);
     if($sth->execute(array(':eatWith_id'=>'',
                         ':user_id'=>$user_id,
                         ':name'=>$name,
                         ':eatWith_picture'=>$imageData,
                         ':video'=>$empty,
                         ':description'=>$description,
                         ':Which'=>$vid_pic,
                         ':posted_time'=>time())))
     {
         //messege
         $erMessage = "You picture has been uploaded";
         echo json_encode($erMessage);
     }
     else
     {
         echo json_encode($sth->errorInfo());
     }
 }
 private function isDublicate($user_id, $name, $vid_pic)
 {
     if($this->checkDupEatWith($user_id, $name))
     {
         //send back error message 
         $erMessage = 'You uploaded this '.$this->changToFullString($vid_pic).' before';
         echo json_encode($erMessage);
         return true;
     }
     else
     {
         return false;
     }
 }

private function checkDupEatWith($user_id, $name)
{

          $sql = "SELECT * FROM eatwith WHERE user_id= :user_id AND name = :name";
          $sth = $this->db->prepare($sql);
          $sth->setFetchMode(PDO::FETCH_ASSOC);
          $sth->execute(array(':user_id'=>$user_id, ':name'=>$name));
          $result = $sth->fetchAll();
          
          if(count($result) > 0)
          {
              //there is duplicate eatWith
              return true;
          }
          else
          {
              //there is no duplicate eatWith
              return false;
          }
}

private function changToFullString($vid_pic)
{
          $pic = 'Pic'; $vid = 'Vid';
          $fullString = '';
          if($vid_pic == $pic){
              $fullString = 'Picture';
          }
          else if($vid_pic == $vid){
              $fullString = 'Video';
          }
          
          return $fullString;
}

private function isDirCreated($path)
{
    if(is_dir($path)){
        return true;
    }
    else
    {
        return false;
    }
}

private function createDir($path)
{
    mkdir($path, 0777);
}



     public function postUserComment($eatWith_id, $commentText)
     {
         $err_message = false;
         $empty = '';
         $sql = "SELECT * FROM eatwith_comments WHERE eatWith_id = :eatWith_id AND user_id= :user_id AND user_comment =:comment";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':eatWith_id'=>$eatWith_id, ':user_id'=>  $this->id, ':comment'=>$commentText));
         $result = $sth->fetchAll();
         
         if(count($result) ===0)
         {
             $sql = "INSERT INTO eatwith_comments VALUES(:eatwith_comment_id, :eatWith_id, :user_id, :user_comment, :comment_time)";
             $sth = $this->db->prepare($sql);
             
             if($sth->execute(array(':eatwith_comment_id'=>$empty,
                                    ':eatWith_id'=>$eatWith_id,
                                    ':user_id'=>  $this->id,
                                    ':user_comment'=>$commentText,
                                    ':comment_time'=> time())))
             {
                      echo $this->loadUserComments($this->id, $commentText);
             }
             else{
                 echo json_encode($sth->errorInfo());
             }
         }
         else
         {
             //cant post the same comment twice
             
             echo json_encode($err_message);
         }
     }
     
     public function getUserCommentCount($eatWith_id)
     {
         
     }
     
     private function loadUserComments($user_id, $commentText)
     {
            $output = '';
           $output = '<div class="userComment"><img src="data:image/jpeg;base64,'.base64_encode($this->getUserImage($user_id)).'" width="40" height="40" alt="">
                   <span>'. $this->getUserFirstName($user_id).' '.$this->getUserLastName($user_id).'</span>
                  <div class="userCommentText">'.$commentText.'</div></div>';
         
         return $output;
     }
     
     
     public function inserteatWithLikes($eatWith_id)
     {
          $empty = '';
         $sql = "SELECT * FROM eatwith_likes WHERE eatWith_id = :eatWith_id AND user_id = :user_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':eatWith_id'=> $eatWith_id, ':user_id'=>$this->id));
         
         $result = $sth->fetchAll();
         
         if(count($result) == 0)
         {
             $sql = "INSERT INTO eatwith_likes VALUES (:eatwith_likes_id, :eatWith_id, :user_id)";
             $sth = $this->db->prepare($sql);
             
             if($sth->execute(array(':eatwith_likes_id'=>$empty, ':eatWith_id'=>$eatWith_id, ':user_id'=>  $this->id)))
             {
                 echo json_encode(true);
             }
             else
             {
                 echo json_encode($sth->errorInfo());
             }
             
         }
         else
         {
             echo json_encode(false);
         }
     }
     
     public function infinitScrollEatWithLoader($pages)
     {
           $sql1 = "SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time, US.FirstName, US.LastName, US.user_type, US.picture
                    FROM eatWIth AS EW
                    INNER JOIN user_details AS US ON EW.user_id = US.user_id
                    WHERE EW.user_id = :user_id

                    UNION 

                    SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time, US.FirstName, US.LastName, US.user_type, US.picture
                    FROM eatWIth AS EW
                    INNER JOIN user_details AS US ON EW.user_id = US.user_id
                    INNER JOIN friends AS F ON EW.user_id = F.user_id
                    AND F.user_friend_id = :user_id

                    UNION 

                    SELECT EW.eatWith_id, EW.user_id, EW.eatWith_picture, EW.video, EW.description, EW.Which, EW.posted_time, US.FirstName, US.LastName, US.user_type, US.picture
                    FROM eatWIth AS EW
                    INNER JOIN user_details AS US ON EW.user_id = US.user_id
                    INNER JOIN friends AS F ON EW.user_id = F.user_friend_id
                    AND F.user_id = :user_id
                    ORDER BY posted_time ASC LIMIT $pages, 8";
           
                $sth1 = $this->db->prepare($sql1);
                $sth1->setFetchMode(PDO::FETCH_ASSOC);
                $sth1->execute(array(':user_id'=>  $this->id));
                $eatWith = $sth1->fetchAll();
                
                 $eatWithLikeCount = $this->getEatWithLikes($eatWith);
                 
                //get eatWithUserComments
                $eatWithUserComments = $this->getEatWithUserComments($eatWith);
                
              echo json_encode($this->loadEatWith($eatWith, $eatWithLikeCount, $eatWithUserComments));
     }
     
     private function loadEatWith($eatWith, $eatWithLikeCount, $eatWithUserComments)
     {
                $output = '';
                $pic = "Pic"; $vid = "Vid";
                $viewer = '';
                for($looper=0; $looper < count($eatWith); $looper++)
                {
                      if($eatWith[$looper]["Which"] === $pic){
                          $viewer = '<img src="data:image/jpeg;base64,'.base64_encode($eatWith[$looper]['eatWith_picture']).'" width="450" height="400" alt="">';
                      }else if($eatWith[$looper]['Which']===$vid) {
                          $viewer = '<video width="450" height="450"> 
                                   <source src="data:video/mp4;base64,'.base64_encode($eatWith[$looper]['video']).'" type="video/mp4">
                                   </video>';
                      }
                            $output .= '<div class="eatWithHold">
                            <div class ="EatWithuserFeed"> 
                               <div class="userphoto">
                                   <img src="data:image/jpeg;base64,'. base64_encode($eatWith[$looper]['picture']).'" width="50" height="50" alt="">
                               </div>
                           </div>
                           <div class="eatWithUsername">
                               <a href="">'. $eatWith[$looper]['FirstName']."".$eatWith[$looper]['LastName'].'</a>      
                                      <br> <span>'. $eatWith[$looper]['user_type'].' <img src="'. URL.'pictures/verify.png" width="10" height="10"></span>
                           </div>
                           <div class="EatwithUserPicVidHolder">
                               '.$viewer.'
                               <div class="PicVidinfoBar">
                                   <img src="'. URL .'pictures/eatWith/like_img.png" width="30" height="30" onclick="eatWithLikes(\''.$eatWith[$looper]['eatWith_id'].'\', \''.$looper.'\')">
                                   <span>'.$this->view->getLikesPrefix($eatWithLikeCount[$looper]).'</span>
                               </div>

                               <div class="PicDescription">'.$eatWith[$looper]['description'].'</div>
                               <div class="commentsCount"><span>'.$this->view->getuserCommentCountSuffix(count($eatWithUserComments[$looper])).'</span></div>
                           </div>
                           <div class="EatWithcommentsHolder">
                            '.$this->loadUserComment($eatWithUserComments[$looper]).'
                           </div>
                           <img src="'. URL.'pictures/general_smal_ajax-loader.gif" width="30" height="30" class="imgAjxLoad"><div class="EatWithUsercomment" contenteditable="true" tabindex="1" onkeyup="sendUserComment(\''. $eatWith[$looper]['eatWith_id'].'\', event, \''. $looper.'\')"> <p> Leave a comment.....</p></div>
                       </div>';

            }
            
            return $output;
     }
     private function loadUserComment($eatWithUserComments)
     {
         $result = '';
     
         if(count($eatWithUserComments)==0){
             $result =  '<div class="userComment">No comments yet. Be the first to comment</div>';
         }else{
                    for($loop =0; $loop < count($eatWithUserComments); $loop++)
                    { 

                       $result .= '<div class="userComment">
                           <img src="data:image/jpeg;base64,'.base64_encode($eatWithUserComments[$loop]['image']).'" width="40" height="40" alt=""><span>'.$eatWithUserComments[$loop]['FirstName'].' '.$eatWithUserComments[$loop]['LastName'].'</span>   
                           <div class="userCommentText">
                              '.$eatWithUserComments[$loop]['commentText'].'
                           </div>
                       </div>';
                   }
            }
            
            return $result;
    }
}
