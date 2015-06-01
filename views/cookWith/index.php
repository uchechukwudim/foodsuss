<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="container">
    <div id="side-bare">
        <?php echo $this->checkUserPicture($userDetails[ZERO]['picture'], 100, 100) ?><br>
        <span class="user-names"><a href="<?php echo URL ?>profile"><?php echo $userDetails[ZERO]['usernames'] ?></a></span>
        <ul>
            <li style="list-style-image: url(<?php echo URL ?>pictures/cookwith/viewshow_icon.png); margin-left: 0px"><span><a href="<?php echo URL ?>cookWith">view shows</a></span></li>
            <li onclick="creatShow()" style="list-style-image: url(<?php echo URL ?>pictures/cookwith/creatshow_icon.png);"><span>create show</span></li>
            <li onclick="getMyshows()" style="list-style-image: url(<?php echo URL ?>pictures/cookwith/myshow_icon.png); margin-left: -5px"><span>my shows</span></li>
        </ul>
    </div>
    <div id="ads">
        <div id="peopleYouMayKnow">
           <img src="<?php  echo URL ?>pictures/general_smal_ajax-loader.gif" width="50" height="50">
       </div>
       <div id="InviteFriends">
           <span><a href="javascript:poptastic('<?php echo GMAILCONTACTLINK ?>');">Invite your friends to enri via email</a></span><img src="<?php echo URL ?>pictures/Gmail_Icon.png" width="30" height="30">
       </div>
       <div id="addHolder">
           <img src="" width="300" height="250" alt="">
           <img src="" width="300" height="250" alt="">
       </div>
    </div>
    <div id="showsHolder">
      
   <?php if(count($cookwith) !== ZERO){ ?>
            
            <?php for($looper = 0; $looper < count($cookwith); $looper++){ ?>
                    <div class="showHolder">
                        <span id="indicator">default</span>
                         <div class="contFoodholder">
                             <img style="margin-right: 5px" src="data:image/jpeg;base64,<?php echo base64_encode($cookwith[$looper]['food_picture']) ?>" width="20" title="<?php echo $cookwith[$looper]['food_name'] ?>" alt="">
                             <img style="margin-right: 10px" src="data:image/jpeg;base64,<?php echo base64_encode($cookwith[$looper]['flag_picture']) ?>" width="20" title="<?php echo $cookwith[$looper]['country_names'] ?>" alt="">
                        </div>
                        <div class="item-one">
                            <div class="userpicture">
                               <?php echo $this->checkUserPicture($cookwith[$looper]['user_pic'], 100, 100) ?>
                            </div>
                            <div class="username"><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($cookwith[$looper]['user_id'])?>"><?php echo $cookwith[$looper]['usernames'] ?></a></div>
                        </div>
                        <div class="item-two">
                                <div class="recipetitle"><?php echo $cookwith[$looper]['recipe_title'] ?></div>
                                <div class="recipedescription"><?php echo $cookwith[$looper]['description'] ?></div>
                                <div class="DIIholder">
                                    <ul>
                                        <li class="DT"><span>Date: <?php echo $cookwith[$looper]['date'] ?></span>  Time - <?php echo $cookwith[$looper]['time'] ?></li>
                                        <li class="INGREE" onclick="tooltip('<?php echo $looper ?>')"><img  src="<?php echo URL ?>pictures/home/ingredient_image.png" width="20" alt="" title="<?php echo $cookwith[$looper]['ingredients'] ?>"><div class="TOOLTIP CW"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER CW"></div></li>
                                        <li onclick="showIVC('<?php echo $looper ?>', '<?php echo $cookwith[$looper]['cookwith_id'] ?>', '<?php echo $cookwith[$looper]['user_id'] ?>')" class="IVC"><img  src="<?php echo URL ?>pictures/profile/ENRI_follower_icon.png" width="20" alt="" title="invitation count"><span><?php echo $cookwith[$looper]['invitation_count'] ?></span><div class="TOOLTIP IC"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER IC"></div></li>
                                    </ul>
                                </div>
                                <div  class="buttonsholder">
                                    <?php if($this->id === $cookwith[$looper]['user_id']){ ?>
                                                 <?php if(!$this->dateChecker($cookwith[$looper]['date'])){ ?>
                                                            <button style="width: 200px; text-align: center; " type="button" class="joinShow">start show</button>
                                                 <?php }else{ ?>
                                                            <a href="<?php echo URL."cookwith/show/".$cookwith[$looper]['show_link'] ?>"><button style="width: 200px; text-align: center;" type="button" class="joinShow">start show</button></a>
                                                 <?php } ?>
                                    <?php }else{?>
                                                   <?php if(!$this->dateChecker($cookwith[$looper]['date'])){ ?>
                                                            <button style="opacity: 0.7; cursor:  default;" type="button" class="joinShow">join now</button>
                                                   <?php }else{ ?>
                                                            <a href="<?php echo URL."cookwith/show/".$cookwith[$looper]['show_link'] ?>"><button type="button" class="joinShow">join show</button></a>
                                                   <?php } ?>
                                                            <button onclick="asktojoin('<?php echo $looper ?>', '<?php echo $cookwith[$looper]['cookwith_id']  ?> ')" type="button" class="asktojoin">ask to join</button>
                                     <?php } ?>
                                    
                                </div>
                        </div>
                        <div class="clearfix"><br></div>
                    </div>
            <?php } ?>
        
     <?php }else{
                    ?>
                        <div style="color: grey; position: relative; top: 100px; left: 50px; width: 500px; font-weight: 700;">
                            You don't have any shows on your feed Yet.
                        </div>
                   <?php
           }?>
     
    </div><br>
    
  
    <div id="postload"></div>
</div>


<div id="eventInvitesLoglayer"></div>
<div id="eventInvitesLogdialog">
            <div id="eventLogheader_dialogProd"><span class ="txt">Invite Friends</span></div>
            
            <div id="friendsHolder">
                
            </div>
    
</div>
	