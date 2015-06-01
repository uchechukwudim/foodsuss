<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cookWith_model
 *
 * @author Uche
 */
class cookWith_model extends Model{
    //put your code here
    function __construct()
    {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user')); 
        $this->view->id = $this->id;
        $this->FirstName = $this->getUserFirstName($this->id);
    }
     
     public function index()
     {
        $one = 1; $two = 2;
        $this->view->css = array('css/cookWith/cookwith.css',
                                 'css/cookWith/eventInvitesDialogBox.css');
        $this->view->js = array('cookwith/js/simplewebrtc-latest.js','cookwith/js/cookwith.js',
                                'cookwith/js/Invites.js', 'cookwith/js/uploadImage.js');
        $fileName = "cookWith/index";
        
        $sql0 = "SELECT FirstName, LastName, picture, user_type FROM user_details WHERE user_id = :user_id";
        $sth0 = $this->db->prepare($sql0);
        $sth0->setFetchMode(PDO::FETCH_ASSOC);
        $sth0->execute(array(':user_id'=>  $this->id));
        $tempUserDetails = $sth0->fetchAll();
        $userDetails = $this->putRestaurantNameInFollowFriends($tempUserDetails);
       
        
        $sql = "SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id AND  user_id = :user_id
                AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_id
                AND FF.user_friend_id = :user_id AND FF.status = :status_one AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_id
                AND FF.user_friend_id = :user_id AND FF.status = :status_two 
                AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_friend_id
                AND FF.user_id = :user_id AND FF.status = :status_two AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN food_follow AS FD ON FD.food_id = CW.food_id
                WHERE FD.user_id = :user_id AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY date DESC LIMIT 0, 6";
        
                 $sth = $this->db->prepare($sql);
                 $sth->setFetchMode(PDO::FETCH_ASSOC);
                 $sth->execute(array(
                     ":user_id" => $this->id, ':status_one'=>$one, ':status_two'=>$two
                 ));
                 
                 $tempCookwith = $sth->fetchAll();
                 
                 $cookwith = $this->getInvitationCount($tempCookwith);
            
                 $this->view->renderCookWith($fileName, $userDetails, $cookwith);
     }
     
      
     private function putRestaurantNameInFollowFriends($userDetails){
          $newuserDetails= array();
                  $newuserDetails[ZERO]['picture'] = $userDetails[ZERO]['picture'];
                  $newuserDetails[ZERO]['user_type'] = $userDetails[ZERO]['user_type'];
                  $newuserDetails[ZERO]['usernames'] = $this->getUserFLNameOrRestNameOrEstName($this->id) ;
            
          
          
          return $newuserDetails;
      }
    
     private function getInvitationCount($cookwith){
       
         for($looper =0; $looper < count($cookwith); $looper++){
             $cookwith[$looper]['invitation_count'] = $this->getCookWithInvitationCount($cookwith[$looper]['cookwith_id']);
             $cookwith[$looper]['usernames'] = $this->getUserFLNameOrRestNameOrEstName($cookwith[$looper]['user_id']);
             $cookwith[$looper]['user_pic'] = $this->getUserImage($cookwith[$looper]['user_id']);
         }
         
        return  $cookwith;
     }
     
     private function getCookWithInvitationCount($cookwith_id){
         $sql = "SELECT user_id FROM cookwith_invitations WHERE cookwith_id = :cookwith_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':cookwith_id'=> $cookwith_id));
         $aCookwithShowCount = $sth->fetchAll();
         
         
         return count($aCookwithShowCount);
     }


     public function show($link){
         $this->view->css = array('css/cookWith/showsheet.css');
         $this->view->js = array('cookwith/js/simplewebrtc-latest.js','cookwith/js/show-simplewebrtc.js');
         $fileName = "cookWith/show/index";
         
         if($this->checkLinkCode($link)){
             $this->view->renderCookwithShow($fileName);
         }else{
             $this->index();
         }
         
     }
     
     private function checkLinkCode($linkCode){
         $sql = "SELECT show_link FROM cookwith WHERE show_link = :link";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':link' => $linkCode));
         $res = $sth->fetchAll();
         
         if(count($res) === ZERO){
             return false;
         }else{
             return true;
         }
             
         
     }
     
     public function joinshowRequest($cookwith_id){
         $sql = "SELECT * FROM cookwith_invitations WHERE cookwith_id = :cookwith_id AND user_id = :user_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':cookwith_id'=>$cookwith_id, ':user_id'=>$this->id));
         $result = $sth->fetchAll();
         
         if(count($result) === ZERO){
                 $this->insertShowRequest($cookwith_id);
         }else{
                 echo json_encode(true);
         }
     }
     
     private function insertShowRequest($cookwith_id){
         $status = "REQUEST";
         $sent = "REQUEST SENT";
         $sql = "INSERT INTO cookwith_invitations VALUES (:cookwith_invitations_id, :cookwith_id, :user_id, :status, :time)";
         $sth = $this->db->prepare($sql);
         if($sth->execute(array(':cookwith_invitations_id' => EMPTYSTRING,
                             ':cookwith_id'=>$cookwith_id,
                             ':user_id'=>  $this->id,
                             ':status'=>$status,
                             ':time'=>  time()))){
             echo json_encode($this->getCookWithInvitationCount($cookwith_id));
         }else{
             echo json_encode(false);
         }
     }
     
     
     
     
     public function getinvitees($cookwith_id, $cookwith_User_id){
         $sql = "SELECT user_id, status FROM cookwith_invitations WHERE cookwith_id = :cookwith_id";
         $sth = $this->db->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute(array(':cookwith_id'=>$cookwith_id));
         
         $invitees = $sth->fetchAll();
         
         if(count($invitees) === ZERO){
             $message = "send out invitations.";
             echo json_encode($message);
         }else{
             $this->loadInvitees($invitees, $cookwith_id, $cookwith_User_id);
         }
     }
     
     private function loadInvitees($invitees, $cookwith_id, $cookwith_User_id){
         $output = '';
         
         if($this->id === $cookwith_User_id){
                for($looper = 0; $looper < count($invitees); $looper++){
                $output .= '<div class="invUserDetails">
                               '.$this->view->checkUserPicture($this->getUserImage($invitees[$looper]['user_id']), 50, 50).'<span class="ICuserNames"><a href="'. URL .'profile/user/'.$this->encrypt($invitees[$looper]['user_id']).'">'.$this->getUserFLNameOrRestNameOrEstName($invitees[$looper]['user_id']).'</a></span>
                               <div class="ICuserType" style="color: red;">'.$this->getUserType($invitees[$looper]['user_id']).' <img src="'. URL .'pictures/verify.png" width="12" height="12" alt="">  <span onmouseover="changeStatus(\''.$this->statusSurfix($invitees[$looper]['status']).'\', \''.$looper.'\')" onmouseout="unchangeStatus(\''.$this->statusSurfix($invitees[$looper]['status']).'\', \''.$looper.'\')" onclick="sendChangStatusRequest(\''.$this->statusSurfix($invitees[$looper]['status']).'\', \''.$cookwith_id.'\', \''.$invitees[$looper]['user_id'].'\', \''.$looper.'\')" class="ICstatus" style="color: orangered">'.$this->statusSurfix($invitees[$looper]['status']).'</span></div>
                           </div>';
                }
         }else{
                for($looper = 0; $looper < count($invitees); $looper++){
                $output .= '<div class="invUserDetails">
                               '.$this->view->checkUserPicture($this->getUserImage($invitees[$looper]['user_id']), 50, 50).'<span class="ICuserNames"><a href="'. URL .'profile/user/'.$this->encrypt($invitees[$looper]['user_id']).'">'.$this->getUserFLNameOrRestNameOrEstName($invitees[$looper]['user_id']).'</a></span>
                               <div class="ICuserType">'.$this->getUserType($invitees[$looper]['user_id']).' <img src="'. URL .'pictures/verify.png" width="12" height="12" alt="">  <span class="ICstatus">'.$this->statusSurfix($invitees[$looper]['status']).'</span></div>
                           </div>';
                 }
         }
        
         echo json_encode($output);
     }
     
     private function statusSurfix($status){
         $invited = 'INVITED';
         $request = 'REQUEST';
         $accepted = 'ACCEPTED';
         $decline = 'DECLINED';
         
         $stat = '';
         
         switch ($status){
             case $invited:return 'Invited';
             case $request:return 'Requesting';
             case $accepted: return 'Accepted';
             case $decline: return 'Declined'; 
         }
     }
     
     
     public function getMyshows(){
         $sql = "SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture, F.foodType_name
                 FROM cookwith AS CW 
                 INNER JOIN food AS F ON CW.food_id = F.food_id 
                 INNER JOIN country AS C ON CW.country_id = C.country_id 
                 AND date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND CW.user_id = :user_id

                 UNION

                 SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture, CI.status
                 FROM cookwith AS CW
                 INNER JOIN food AS F ON CW.food_id = F.food_id 
                 INNER JOIN country AS C ON CW.country_id = C.country_id
                 INNER JOIN cookwith_invitations AS CI ON CI.user_id = :user_id 
                 WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                 ORDER BY date DESC LIMIT 0, 6";
         
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(':user_id'=>  $this->id));
                $tempCookwith = $sth->fetchAll();
                 
                $cookwith = $this->getInvitationCount($tempCookwith);
            
                
                echo json_encode($this->loadCookWith($cookwith));
     }
 
     private function loadCookWith($cookwith){
         $output = '<script>
                 hoverIngree();
                    </script>
                    <span id="indicator">myshows</span>';
         
         for($looper =0; $looper < count($cookwith); $looper++){
             $output .= '<div class="showHolder">
                         <div class="contFoodholder">
                             <img style="margin-right: 5px" src="data:image/jpeg;base64,'.base64_encode($cookwith[$looper]['food_picture']).'" width="20" title="'.$cookwith[$looper]['food_name'].'" alt="">
                             <img style="margin-right: 10px" src="data:image/jpeg;base64,'.base64_encode($cookwith[$looper]['flag_picture']).'" width="20" title="'. $cookwith[$looper]['country_names'].'" alt="">
                        </div>
                        <div class="item-one">
                            <div class="userpicture">
                               '. $this->view->checkUserPicture($cookwith[$looper]['user_pic'], 100, 100) .'
                            </div>
                            <div class="username"><a href="<?php echo URL ?>profile/user/'. $this->encrypt($cookwith[$looper]['user_id']).'">'.$cookwith[$looper]['usernames'].'</a></div>
                        </div>
                        <div class="item-two">
                                <div class="recipetitle">'. $cookwith[$looper]['recipe_title'] .'</div>
                                <div class="recipedescription">'. $cookwith[$looper]['description'] .'</div>
                                <div class="DIIholder">
                                    <ul>
                                        <li class="DT"><span>Date: '.$cookwith[$looper]['date'] .'</span>  Time - '.$cookwith[$looper]['time'] .'</li>
                                        <li class="INGREE" onclick="tooltip(\''.$looper.'\')"><img  src="'. URL .'pictures/home/ingredient_image.png" width="20" alt="" title="'.$cookwith[$looper]['ingredients'].'"><div class="TOOLTIP CW"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER CW"></div></li>
                                        <li onclick="showIVC(\''.$looper.'\', \''.$cookwith[$looper]['cookwith_id'] .'\', \''.$cookwith[$looper]['user_id'].'\')" class="IVC"><img  src="'. URL .'pictures/profile/ENRI_follower_icon.png" width="20" alt="" title="invitation count"><span>'.$cookwith[$looper]['invitation_count'].'</span><div class="TOOLTIP IC"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER IC"></div></li>
                                    </ul>
                                </div>
                                <div class="buttonsholder">
                                    '.$this->checkShowButton($cookwith[$looper]['foodType_name'], $cookwith[$looper]['show_link'], $cookwith[$looper]['date']).'
                                </div>
                        </div>
                        <div class="clearfix"><br></div>
                    </div>';
         }
         
         return $output;
     }
     
     private function checkShowButton($which, $link, $date){
         $request = "REQUEST";
         $decline = "DECLINED";
         $accept = "ACCEPTED";
         $invited = "INVITED";
         
         if($which === $request || $which === $decline || $which === $accept || $which === $invited){
             if(!$this->view->dateChecker($date)){
                 return '<button style="opacity: 0.7; cursor:  default;" type="button" class="joinShow">join now</button>
                         <button onclick="" type="button" class="asktojoin">'.$this->getStatus($which).'</button>';
             }else{
                 return '<a href="'.URL."cookwith/show/".$link.'"><button type="button" class="joinShow">join show</button></a>
                     <button onclick="" type="button" class="asktojoin">'.$this->getStatus($which).'</button>  ';
             }
             
         }else{
                if(!$this->view->dateChecker($date)){
                    return ' <button style="opacity: 0.7; cursor:  default; width: 200px; text-align: center;" type="button" class="joinShow">start show</button>';
                }else{
                     return '<a href="'.URL."cookwith/show/".$link.'"><button style="width: 200px; text-align: center;" type="button" class="joinShow">start show</button></a>
                    ';
                }
            
         }
     }
     
       private function checkDefaultShowButton($this_User_id, $c_user_id, $link, $date, $index, $cookWith_id){
        
         if($this_User_id === $c_user_id){ 
                       if(!$this->view->dateChecker($date)){ 
                                  return '<button style="width: 200px; text-align: center; " type="button" class="joinShow">start show</button>';
                         }else{ 
                                return '<a href="'. URL .'"cookwith/show/"'.$link.'"><button style="width: 200px; text-align: center;" type="button" class="joinShow">start show</button></a>';
                         } 
        }else{
                        if(!$this->view->dateChecker($date)){ 
                               return ' <button style="opacity: 0.7; cursor:  default;" type="button" class="joinShow">join now</button>
                                        <button onclick="asktojoin(\''.$index. '\', \''.$cookWith_id.'\')" type="button" class="asktojoin">ask to join</button>';
                         }else{ 
                                return '<a href="'.URL.'"cookwith/show/"'.$link.'"><button type="button" class="joinShow">join show</button></a>
                                 <button onclick="asktojoin(\''.$index.'\', \''.$cookWith_id.'\')" type="button" class="asktojoin">ask to join</button>';
                         } 
                                
             } 
     }
     
     private function getStatus($which){
          $invited = "INVITED";
          $declined = "DECLINED";
          $request = "REQUEST";
          $accepted = "ACCEPTED";
          $accept = "accepted";
          $decline = "declined";
          $requesting = "requesting";
          $invite = "invited";
          
          if($which === $invited){
              return $invited;
          }else if($which === $request){
              return $requesting;
          }else if($which === $declined){
              return $decline;
          }else if($which === $accepted){
              return $accept;
          }
     }
     
      private function checkIsShowButton($which){
         $request = "REQUEST";
         $decline = "DECLINED";
         $accept = "ACCEPTED";
         $invited = "INVITED";
         
         if($which === $request || $which === $decline || $which === $accept || $which === $invited){
             return true;
         }else{
             return false;
         }
     }
     
     public function sendChangStatusRequest($status, $user_id, $cookWith_id){
         $sql = "UPDATE cookwith_invitations SET status = :status WHERE cookwith_id = :cookwith_id AND user_id = :user_id";
         $sth = $this->db->prepare($sql);
         if($sth->execute(array(':status'=> $status,
                                ':cookwith_id'=> $cookWith_id,
                             ':user_id'=>$user_id))){
             echo json_encode($status);
         }
     }
     
     
     public function infinityScrollViewShows($page){
                  $default = 'Default';
            $one = 1; $two = 2;
           $sql = "SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id AND  user_id = :user_id
                AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_id
                AND FF.user_friend_id = :user_id AND FF.status = :status_one AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_id
                AND FF.user_friend_id = :user_id AND FF.status = :status_two 
                AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time,  F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN friends AS FF ON CW.user_id = FF.user_friend_id
                AND FF.user_id = :user_id AND FF.status = :status_two AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                
                UNION
                
                SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, 
                CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture FROM cookwith AS CW
                INNER JOIN food AS F ON CW.food_id = F.food_id
                INNER JOIN country AS C ON CW.country_id = C.country_id
                INNER JOIN food_follow AS FD ON FD.food_id = CW.food_id
                WHERE FD.user_id = :user_id AND date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                ORDER BY date DESC LIMIT $page, 6";
        
                 $sth = $this->db->prepare($sql);
                 $sth->setFetchMode(PDO::FETCH_ASSOC);
                 $sth->execute(array(
                     ":user_id" => $this->id, ':status_one'=>$one, ':status_two'=>$two
                 ));
                 
                 $tempCookwith = $sth->fetchAll();
                 
                 $cookwith = $this->getInvitationCount($tempCookwith);
                 echo json_encode($this->infinityLoader($cookwith, $page, $default));
     }
     
     public function infinityScrollMyshow($page){

         $myshow = 'myshow';
           $sql = "SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture, F.foodType_name
                 FROM cookwith AS CW 
                 INNER JOIN food AS F ON CW.food_id = F.food_id 
                 INNER JOIN country AS C ON CW.country_id = C.country_id 
                 AND date > DATE_SUB(NOW(), INTERVAL 1 DAY) AND CW.user_id = :user_id

                 UNION

                 SELECT CW.cookwith_id, CW.user_id, CW.recipe_title, CW.description, CW.ingredients, CW.show_link, CW.date, CW.time, F.food_picture, F.food_name, C.country_names, C.flag_picture, CI.status
                 FROM cookwith AS CW
                 INNER JOIN food AS F ON CW.food_id = F.food_id 
                 INNER JOIN country AS C ON CW.country_id = C.country_id
                 INNER JOIN cookwith_invitations AS CI ON CI.user_id = :user_id 
                 WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY)
                 ORDER BY date DESC LIMIT $page, 6";
         
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute(array(':user_id'=>  $this->id));
                $tempCookwith = $sth->fetchAll();
                 
                $cookwith = $this->getInvitationCount($tempCookwith);
                echo json_encode($this->infinityLoader($cookwith, $page, $myshow));
     }
     
     private function infinityLoader($cookwith, $page, $which){
         $foodType = '';
          $output = '<script>
                 hoverIngree();
                    </script>
                    <span id="indicator">myshows</span>';

                    for($looper =0; $looper < count($cookwith); $looper++){
                        if(isset($cookwith[$looper]['foodType_name'])){
                            $foodType = $cookwith[$looper]['foodType_name'];
                        }else{
                            $foodType = '';
                        }
                        $output .= '<div class="showHolder">
                                    <div class="contFoodholder">
                                        <img style="margin-right: 5px" src="data:image/jpeg;base64,'.base64_encode($cookwith[$looper]['food_picture']).'" width="20" title="'.$cookwith[$looper]['food_name'].'" alt="">
                                        <img style="margin-right: 10px" src="data:image/jpeg;base64,'.base64_encode($cookwith[$looper]['flag_picture']).'" width="20" title="'. $cookwith[$looper]['country_names'].'" alt="">
                                   </div>
                                   <div class="item-one">
                                       <div class="userpicture">
                                          '. $this->view->checkUserPicture($cookwith[$looper]['user_pic'], 100, 100) .'
                                       </div>
                                       <div class="username"><a href="<?php echo URL ?>profile/user/'. $this->encrypt($cookwith[$looper]['user_id']).'">'.$cookwith[$looper]['usernames'].'</a></div>
                                   </div>
                                   <div class="item-two">
                                           <div class="recipetitle">'. $cookwith[$looper]['recipe_title'] .'</div>
                                           <div class="recipedescription">'. $cookwith[$looper]['description'] .'</div>
                                           <div class="DIIholder">
                                               <ul>
                                                   <li class="DT"><span>Date: '.$cookwith[$looper]['date'] .'</span>  Time - '.$cookwith[$looper]['time'] .'</li>
                                                   <li class="INGREE" onclick="tooltip(\''.$page.'\')"><img  src="'. URL .'pictures/home/ingredient_image.png" width="20" alt="" title="'.$cookwith[$looper]['ingredients'].'"><div class="TOOLTIP CW"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER CW"></div></li>
                                                   <li onclick="showIVC(\''.$page.'\', \''.$cookwith[$looper]['cookwith_id'] .'\', \''.$cookwith[$looper]['user_id'].'\')" class="IVC"><img  src="'. URL .'pictures/profile/ENRI_follower_icon.png" width="20" alt="" title="invitation count"><span>'.$cookwith[$looper]['invitation_count'].'</span><div class="TOOLTIP IC"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER IC"></div></li>
                                               </ul>
                                           </div>
                                           <div class="buttonsholder">
                                               '.$this->checkInfinityShowButton($which, $foodType, $cookwith[$looper]['show_link'], $cookwith[$looper]['date'], $this->id,$cookwith[$looper]['user_id'], $page, $cookwith[$looper]['cookwith_id']).'
                                           </div>
                                   </div>
                                   <div class="clearfix"><br></div>
                               </div>';
                        $page++;
                    }
                    
                    return $output;
     }
     
     private function checkInfinityShowButton($which, $foodType, $link, $date, $this_user_id, $c_user_id, $index, $cookWith_id){
         $default = 'Default'; $myshow = 'myshow';
         
         if($which === $default){
            return $this->checkDefaultShowButton($this_user_id, $c_user_id, $link, $date, $index, $cookWith_id);
         }
         
         if($which === $myshow){
             return $this->checkShowButton($foodType, $link, $date);
         }
     }
     
     
     public function processShowEvent($showTitle, $showDesc, $foodOrigin, $countryOringin, $showDate, $showTime, $ingredients, $invites){
         
     }
}
