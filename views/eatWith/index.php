<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="container">
<div id="personals">
    
        <div id="userPersonals">
            
            <span id="imgP">
                <?php echo  $this->checkUserPicture($userDetails[ZERO]['picture'], 100, 100) ?>
            </span>
            <span id="nameP">
                <a href='<?php echo URL ?>profile'><b><?php 
                            $name = '';
                            if(isset($userDetails[ZERO]['FirstName'])){
                                 echo $userDetails[ZERO]['FirstName']." ".$userDetails[ZERO]['LastName'] ;
                            }else{
                                echo $userDetails[ZERO]['restaurant_name'];
                            }
                        ?></b></a>
            </span>
            <div id="personalNav">
     
                <ul>
                    <li id="messaging" style="list-style-image: url(pictures/navigationbar/ENRI_MESSAGE_SMALL.png);" >
                        <a href="<?php echo URL ?>message" >Message</a>
                   </li>
                    <li id="cookwith" style="list-style-image: url(pictures/navigationbar/ENRI_COOKWITH_SMALL.png);" >
                        <a href="<?php echo URL ?>cookWith" >CookWith</a>
                   </li>
                   <li id="eatwithP" style="list-style-image: url(pictures/navigationbar/ENRI_EATWITH_SMALL.png);">
                    <a href="<?php echo URL ?>eatWith" >EatWith</a>
                   </li>
                   
                   <li id="eventsP"  style="list-style-image: url(pictures/navigationbar/ENRI_EVENT_SMALL.png);">
                      <a href="<?php echo URL ?>events" > Events</a>
                   </li>
                   <li id="articleP"  style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_ARTILE_ICON_small.png);">
                      <a href="<?php echo URL ?>articles" > Articles</a>
                   </li>

                </ul>

            </div>
        </div>
 
      
            <div id='actContainer'>
                <span id='connect'>Following</span>
             <ul id='act'>
                 <li id="foodFollow" onclick="onFoodFollowClick('EATWITH')" style="list-style-image: url(pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('EATWITH')" style="list-style-image: url(pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('EATWITH')" style="list-style-image: url(pictures/navigationbar/ENRI_REST_SMALL.png);">
                       <span>Restaurants</span>
                   </li>
                </ul>
            </div>
     
</div>

<div id="adds">
    <div id="peopleYouMayKnow">
        <div id="peopleYouMayKnowHeader">People you may know</div>
        <?php for($loop =0; $loop < 6; $loop++){
            
               echo  $this->checkUserPicture("", 100, 100) ;
        }
        ?>
    </div>
    <div id="addHolder">
        <img src="" width="300" height="250" alt="">
        <img src="" width="300" height="250" alt="">
    </div>
</div>


<div id="EatWithHolder">
    <div id="eatWithInfoBar">
        <ul>
            <li id="picCount">Pictures <span><?php echo $userPicCount ?></span> </li><li id='vidCount'>Videos <span><?php echo $userVidCount ?></span> </li>
            <li id='postEatWith' onclick="eatWith()">EatWith</li>
        </ul>
    </div>
    <?php for($looper =0; $looper < count($eatWith); $looper++){ ?>
    <div class="eatWithHold">
         <div class ="EatWithuserFeed"> 
            <div class="userphoto">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($eatWith[$looper]['picture']); ?>" width="50" height="50" alt="">
            </div>
        </div>
        <div class="eatWithUsername">
            <a href=""><?php echo $eatWith[$looper]['userNames'] ?></a>      
                   <br> <span><?php echo $eatWith[$looper]['user_type'] ?> <img src="<?php echo URL?>pictures/verify.png" width="10" height="10"></span>
        </div>
        <div class="EatwithUserPicVidHolder">
              <?php $pic = 'Pic'; $vid = 'Vid'; if($eatWith[$looper]['Which'] === $pic){?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($eatWith[$looper]['eatWith_picture']); ?>" width="450" height="400" alt="">
            <?php }  else if($eatWith[$looper]['Which']===$vid) {//show player for video?>
            
           
            <video  width="500" height="450"  controls style="margin-top: -10px; border: 1px solid rgba(0, 0, 0, 0.1);">
                <source src="<?php echo $eatWith[$looper]['video'] ?>" type="Video/mp4">
            </video>
       
               <?php }?>  
              
            <div class="PicVidinfoBar">
                <img src="<?php echo URL ?>pictures/eatWith/like_img.png" width="30" height="30" onclick="eatWithLikes('<?php echo $eatWith[$looper]['eatWith_id']?>', '<?php echo $looper ?>')">
                <span><?php echo $this->getLikesPrefix($eatWithLikeCount[$looper]) ?></span>
            </div>
           
            <div class="PicDescription"><?php echo $eatWith[$looper]['description'] ?></div>
            <div class="commentsCount" onclick="showEatwithUserComment(<?php echo $eatWith[$looper]['eatWith_id'] ?>, <?php echo $looper ?>)"><span><?php echo $this->getuserCommentCountSuffix(count($eatWithUserComments[$looper])) ?></span></div>
        </div>
        <div class="EatWithcommentsHolder">
         <?php if(count($eatWithUserComments[$looper])==0){
             echo '<div class="userComment"></div>';
         }else if(count($eatWithUserComments[$looper]) <= THREE){
                 for($loop =0; $loop < count($eatWithUserComments[$looper]); $loop++){ ?>
                   <div class="userComment">
                       <img src="data:image/jpeg;base64,<?php echo base64_encode($eatWithUserComments[$looper][$loop]['image'])?>" width="40" height="40" alt=""><span><?php echo $eatWithUserComments[$looper][$loop]['userNames'] ?></span>   
                       <div class="userCommentText">
                          <?php echo $eatWithUserComments[$looper][$loop]['commentText'] ?>
                       </div>
                   </div>
        <?php }
         
           }else{
                    for($loop =0; $loop < THREE; $loop++){ ?>
                   <div class="userComment">
                       <img src="data:image/jpeg;base64,<?php echo base64_encode($eatWithUserComments[$looper][$loop]['image'])?>" width="40" height="40" alt=""><span><b><?php echo $eatWithUserComments[$looper][$loop]['userNames'] ?></b></span>   
                       <div class="userCommentText">
                          <?php echo $eatWithUserComments[$looper][$loop]['commentText'] ?>
                       </div>
                   </div>
        <?php }
         
                }?>
        </div>
        <img src="<?php echo URL ?>pictures/general_smal_ajax-loader.gif" width="30" height="30" class="imgAjxLoad"><div class="EatWithUsercomment" contenteditable="true" tabindex="1" onkeyup="sendUserComment('<?php echo $eatWith[$looper]['eatWith_id']; ?>', event, '<?php echo $looper; ?>')"> <p> Leave a comment.....</p></div>
    </div>
    <?php } ?>
      
</div>
    <div id="postload">
                    
    </div>
        <?php require View.'footer.php'; ?>
    
</div>


     <div id="eatWithLayer"></div>
        <div id="eatWithDialog">
            <div id="header_dialogEatwith"><span class="txt">EatWith Upload</span></div>
            <div id="holdEatWith">
                <form action ="" method ="post" enctype="multipart/form-data" id="eventLogusrform"> 
                    <textarea cols="48" rows="8" id="description" draggable="false" maxlength="300" placeholder="image/video description"></textarea><br>
                    <span id="error_info">Please upload a picture/Video with Description</span><img src="<?php echo URL ?>pictures/eatWith/camera.png" width="25" height="25" title="upload Picture/Video(mp4, ogg, mov, wmv) " id="eatWithUpload" onclick="trigger(event)">
                     <input type="file" name="file" id="file"/>
                     <button id="eatWithLogSubmitBt" type="submit" name='submit' form="usrform" onclick="submitEatWithRequest()">Submit</button>
                     <button id="eatWithLogCancelBt" type="submit" name='cancel' form="usrform" onclick="cancel()">Cancel</button>
                    
                </form>
            </div>
           
        </div>
