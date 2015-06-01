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
                 <li id="foodFollow" onclick="onFoodFollowClick('EVENT')" style="list-style-image: url(pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('EVENT')" style="list-style-image: url(pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('EVENT')" style="list-style-image: url(pictures/navigationbar/ENRI_REST_SMALL.png);">
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

    
    <div id="events">
        <div id="eventNavBar">
            <ul>
                <li id="Eboard">Event Board</li>|
                <li id="E4U">Events for You</li>
                <li id="creatEvent" onclick="creatEvent()">Create Event</li>
            </ul>    
        </div>
        
        <div id="eventsHolder">
            <?php for($looper =0; $looper < count($events); $looper++){ ?>
            <div class="anEvent">
                <div class="eventImage"><img src="data:image/jpeg;base64,<?php echo base64_encode($events[$looper]['event_pictureCover'])?>" width="150" height="120" alt=""></div>
                <div class="eventName"><?php echo $events[$looper]['event_name'] ?></div><br>
                <div class="eventDateTime"><?php echo $events[$looper]['date']." At ".$events[$looper]['time'] ?></div>
                <div class="eventWhere"><?php echo $events[$looper]['where'] ?></div>
                <div class="yourInvited"></div>
                
                <div class="eventAccept" onclick="attendEvent('<?php echo $this->id ?>', '<?php echo $events[$looper]['event_id'] ?>', 'Public', '<?php echo $looper ?>')"><?php echo $this->getAttendingText($myPublicAttendingEvent[$looper]) ?></div><div class="Decline">decline</div>
                <div class="eventInfo" ><span class="eventAttending"><?php echo $eventAttendCount[$looper] ?> attending</span> <span class="eventInvited"> <?php echo $eventInvited[$looper] ?> invited</span></div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<div id="eventLoglayer"></div>
        <div id="eventLogdialog">
            <div id="eventLogclose">| x |</div>
            <div id="eventLogheader_dialogProd"><span class ="txt">Create Event</span></div>
            <div id="eventLogForm">
                <form action ="" method ="post" enctype="multipart/form-data" id="eventLogusrform"> 
                     <span id="evName">Event Name </span><input type="text" name="eventName" value="" id="eventName"/><br>
                     <span id="evDesc">Description</span> <textarea cols="40" rows="5" id="eventDes" draggable="false" maxlength="300" placeholder=""></textarea><br>
                     <span id="evLocation">Location</span> <input type="text" name="location"  value="" id="eventLocation"/><br>
                     <span id="evD_T">Date & Time</span> <input type="date" name="date"  value="" id="eventDATE"/>  
                     <input type="time" name="time"  value="" id="eventTime"/>
                     <img src="<?php echo URL ?>pictures/events/camera.png" width="25" height="25" title="upload event Image" id="eventImg">
                     <input type="file" name="file" id="file"/><br>
                     <span id="evPrivacy">Privacy</span><select size="1" name="edob" id="eventPrivacy">
                                <option>Privacy</option>
                                <option>Public</option>
                                <option>Guest and Friends</option>
                                 <option>Invites Only</option>
                      </select>
                      <span id="evType">Event Type</span><select size="1" name="edob" id="eventType">
                          <option>Event Type</option>
                                <option>CookWith</option>
                                <option>Other</option>
                      </select><br>
                      <button id="eventLogCancelBt" type="submit" name='cancel' form="usrform">Cancel</button>
                      <button id="eventLogSubmitBt" type="submit" name='submit' form="usrform" onclick="submitEventRequest()">Submit</button>
                      <div id="event_invites"><img src="<?php echo URL ?>pictures/events/follower_icon.png" width="15" height="15" alt="" name=""> Invite Friends</div>
                 </form>
            </div>
        </div>




<div id="eventInvitesLoglayer"></div>
<div id="eventInvitesLogdialog">
            <div id="eventLogheader_dialogProd"><span class ="txt">Invite Friends</span></div>
            
            <div id="friendsHolder">
                
            </div>
    
</div>

  
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Info Box</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>