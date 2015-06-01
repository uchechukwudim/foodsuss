
<div class="container clearfix">
    <div id="which_active"></div>
    <div id="personalsProfile">
           <ul>
            <li id="U_cookbook" onclick="getUserProfileMyCookBook('<?php echo $userId ?>')">Cookbook</li>
            <li id="U_cookbox" onclick="getUserProfileMyCookBox('<?php echo $userId ?>')">Cookbox</li>
            <li id="U_aboutme"  onclick="getUserProfileAbouteMe('<?php echo $userId ?>')">About Me</li>
            <li id="U_followers" onclick="getUserProfileFriendsFollow('<?php echo $userId ?>')">Followers</li>
        </ul>
   </div>
    
    <div id="adds">
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

      <div id="profilDetailsHolder">
      
          <div class="profilCover">
            <div class="prfCoverImage"> <?php echo $this->checkCoverPicture($userDetails[0]['cover_picture']) ?></div>
          </div>
          
          <div class="other_cover">
              <div id="profilePicu">
                    <?php echo $this->checkUserPicture($userDetails[0]['picture'], 136, 136) ?> 
              </div> 
          </div>
          
           <div id="userNameVerifyHolder">
                  <div id="profileUserName"><?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName'] ?></div>
                  <div id="userverify" style="position: relative; top: 5px;"> <?php echo $userDetails[0]['user_type'] ?></div>
                  <img id="verifyImg" src="<?php echo URL ?>pictures/verify.png" width="15" height="15" alt="" style="position: relative; left: 46px;">
                    <div class="follow_friend_count_holder">
                      <span>Followers</span><br>
                      <span class="counting"><?php echo $this->post_statsSurfix(count($friendsFollowers)) ?></span>
                  </div>
                  <div id="friendshipUpdate" onmouseover="changeStatusOnHover()" onclick="sendUserFriendShipToServer('<?php echo $status ?>', '<?php echo $statusDetails[ZERO]['user_id'] ?>', '<?php echo $statusDetails[ZERO]['user_friend_id'] ?>')"><?php echo  $status ?></div>
           </div>
         
          
          <div id="AjaximageLoader"><img style="position: relative; bottom: 20px; left: 100px;" src="<?php echo URL ?>pictures/profile/transparentbck_ajax-loader.gif" width="60" height="60"></div>
                
                <div id='LOAD'>
                        <div id="myCookBookHolder">
                            <!-- <div id="myCookBookHolderHeader"><img src="<?php echo URL ?>pictures/profile/ENRI_COOKBOOK.png" width="30" height="30"> <b>My CookBook</b></div> -->
                                  <?php 
                                   $Food_Pic = '';
                                   $Food_Nm = '';
                                  for($looper =0; $looper<count($myCookBook); $looper++){
                                       if(isset($foodCountry[$looper][0]['food_picture'])){
                                            $Food_Pic = $foodCountry[$looper][0]['food_picture'];
                                            $Food_Nm = $foodCountry[$looper][0]['food_name'];
                                        }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
                                  ?>
                                    <div class="feed_1">
                                   
                                         <div class="post_profile_photo"><?php echo $this->checkUserPicture($userDetails[0]['picture'], 100, 100)?></div>
                                                <div class="post_text">
                                                    <span class="mealType"><?php echo $this->checkMealType($myCookBook[$looper]['meal_type'], 25, 25) ?></span>
							<ul >
                                                            <li style ="color:#FF4500; margin-left:-5px"><b> <?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName']; ?>   </b></li>
                                                                          <li class="hashTagTitle"><b><?php echo $myCookBook[$looper]['recipe_title']  ?></b></li>
									  <li class="RecpInstr">
									 <?php 
                                                                            if($myCookBook[$looper]['recipe_pwi_active'] === 'TRUE'){
                                                                               echo $this->checkPWIPictures($myCookBook[$looper]['recipe_post_id'], $myCookBook[$looper]['recipe_dir_image']);
                                                                            }else if($myCookBook[$looper]['recipe_pwi_active'] === 'FALSE'){
                                                                                echo $myCookBook[$looper]['how_its_made'];
                                                                            }
                                                                          ?>
									 </li>
									
							</ul>
						</div>
                                         
                                                <div class="post_profile_link">
						 <ul>
                                                    
                                                       <li onclick="showHomeRecipeImage(<?php echo $myCookBook[$looper]['recipe_post_id'] ?>)" style="position: relative; top: 8px;"><img src="<?php echo URL ?>pictures/home/ENRI_RES_PIC.png" width="25" alt="" title="recipe picture"></li>
                                                       <li onclick="tooltip('<?php echo $looper ?>')" class="INGRE" style="position: relative; top: 9px; right: 2px;"> <img  src="<?php echo URL ?>pictures/home/ingredient_image.png" width="25" alt="" title="<?php echo $myCookBook[$looper]['ingredients'] ?>"><div class="TOOLTIP"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER"></div></li>
						  </ul>
						</div>
                                         
                                                <div class="picIngShp">
							<ul class="recipeNav">
                                                            <li onclick="showShops('<?php echo  $looper ?>','<?php echo $myCookBook[$looper]['recipe_post_id'] ?>')" class="ShpCt"><img src="<?php echo URL ?>pictures/home/ENRI_SHOPS_ICON.png" width="25" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
							</ul>
						</div>
                                                <div class="post_comments">
                                                                <div class="commentCounter">- - - - - - - - - - - - - - - - - - - - - <span onclick="showAllComment('<?php echo $looper ?>', <?php echo $myCookBook[$looper]['recipe_post_id'] ?>)"><?php echo $this->getuserCommentCountSuffix(count($userComments[$looper])) ?></span> - - - - - - - - - - - - - - - - - - - - - </div>
                                                                <div class="UserComments">
                                                                        <?php 
                                                                        if(count($userComments[$looper]) >= THREE){
                                                                            for($loop=0; $loop < THREE; $loop++)
                                                                            {
                                                                                ?>
                                                                            <div class="user_photo"><?php echo $this->checkUserPicture($userComments[$looper][$loop]['image'], 35, 35) ?></div>
                                                                            <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$looper][$loop]['user_id'])?>"><?php echo $userComments[$looper][$loop]['userName'] ?></a></b></div> <div class="postTime"><?php echo $this->timeCounter($userComments[$looper][$loop]['time'])?></div>
                                                                            <div class="user_comment">
                                                                            <?php echo $userComments[$looper][$loop]['comments'] ?>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                        }else if(count($userComments[$looper])< THREE){
                                                                            for($loop=0; $loop < count($userComments[$looper]); $loop++)
                                                                            {
                                                                                ?>
                                                                            <div class="user_photo"><?php echo $this->checkUserPicture($userComments[$looper][$loop]['image'], 35, 35) ?></div>
                                                                            <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$looper][$loop]['user_id'])?>"><?php echo $userComments[$looper][$loop]['userName'] ?></a></b></div> <div class="postTime"><?php echo $this->timeCounter($userComments[$looper][$loop]['time'])?></div>
                                                                            <div class="user_comment">
                                                                            <?php echo $userComments[$looper][$loop]['comments'] ?>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                        }
                                                                            ?>
                                                                </div>
                                                                <div class="post_comments_box_profile_photo"><?php echo $this->checkUserPicture($userDetails[0]['thisuserimage'], 35, 35)?></div>
                                                                <div class="post_comments_box"  contenteditable="true" tabindex="1" onkeyup="sendUserRecookComment('<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', event, '<?php echo $myCookBook[$looper]['user_id'] ?>', '<?php echo $looper ?>')">
                                                                    <p>show how you might make this recipe or leave a comment</p>
                                                                </div>
                                                </div>
                                         
                                                <div class="post_stats">
							  <ul>
                                                              <li class="tastyCount"  onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $myCookBook[$looper]['user_id'] ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_tasty', '<?php echo $looper ?>')" style="list-style-image: url(<?php echo URL?>pictures/home/ENRI_TASTYIT.png)" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCount[$looper], " people said this is tasty", " person said this is tasty")?>"><b><?php echo $this->post_statsSurfix($tastyCount[$looper])?></b></span></li>
                                                              <li class="cookCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $myCookBook[$looper]['user_id']   ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_cookedit', '<?php echo $looper ?>')" style="list-style-image: url(<?php echo URL ?>pictures/home/ENRI_COOKEDIT.png)" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cootItCount[$looper], " people cooked this" ,"person cooked this")?>"><b><?php echo $this->post_statsSurfix($cootItCount[$looper]) ?></b></span></li>
                                                              <li class="shareCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $myCookBook[$looper]['user_id']   ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_share', '<?php echo $looper ?>')" style="list-style-image: url(<?php echo URL ?>pictures/home/ENRI_SHAREIT.png)" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCount[$looper]," people shared this", "person shared this") ?>"><b><?php echo $this->post_statsSurfix($shareCount[$looper]) ?></b></span></li>
							  </ul>
						</div>
						<div class="post_flag">
							<img class="homeCountry" src="<?php echo $this->checkCountryPic($foodCountry[$looper][0]['flag_picture']);?>" width="35" height="35" title="<?php echo $foodCountry[$looper][0]['country_names'] ?>"> 
                                                        <img class="homeFood" src="<?php echo $this->checkFoodPic($Food_Pic) ;?>" width="35" height="35" title="<?php echo $this->checkFoodpicTitle($Food_Nm); ?>">
						</div>
                                    </div>
                                  <?php }?>
                         </div>
                     
                </div>
                
       </div>
   <div id="userPostLoad"></div>
</div>

  
  <script>
$('#which_active').html('UCB');
    $('#U_cookbook').css({"background": "orangered", "color":"white"});
 UserInfinitScrollMyCookBook('<?php echo $this->id ?>');
  UserInfinitScrollFriendsFollow('<?php echo $this->id ?>');
 UserInfinitScrollMyCookBox('<?php echo $this->id ?>') 
    function changeStatusOnHover()
     {
        $('#friendshipUpdate').hover(function(){
            var status = $(this).text();
            if(status === "Friends")
            {
                $(this).text("UnFriend");
                
            }
            
            if(status === "Following")
            {
                $(this).text("Unfollow");
                
            }
            
            if(status === "Follower")
            {
                $(this).text("Follow Back");
               
            }
        },function(){
            
            var status = $(this).text();
            if(status === "UnFriend")
            {
                $(this).text("Friends");
               
            }
            
            if(status === "Unfollow")
            {
                $(this).text("Following");
               
            }
            
            if(status === "Follow Back")
            {
                $(this).text("Follower");
                
            }
            
        });
   
   }
   </script>
    <script>
      $('.feed_1').each(function (index){

		var PC_top = 122;
		var PC_left = 316;
		var topp = 115;
                
                   var feed_1_bottomMargin  = 120;
                
		   var RHeight = $('.post_text ul li.RecpInstr').eq(index).height();
		   var FHeight = $('.feed_1').eq(index).height();
		   var flag = 380;
		   var stat = 390;
		   
		   $('.feed_1').eq(index).height(RHeight+FHeight);
		  
		 
                   
                  var userCommentH =  $('.UserComments').eq(index).height();
                  
		  $('.feed_1').eq(index).css({"margin-bottom": feed_1_bottomMargin+userCommentH}); 
                  
                  var newStat = userCommentH+stat+FHeight-170;
		 var newFlag = userCommentH+flag+FHeight-170;
		   $('.post_flag').eq(index).css({position:"relative", top: -newFlag+"px"} );
		   $('.post_stats').eq(index).css({position:"relative", top: -newStat+"px"} );
		  // $('.picIngShp').eq(index).css({position:"relative", top: topp+RHeight +"px", left:"280px" });
		 // $('.post_comments').eq(index).css({position:"relativee", top: PC_top+RHeight +"px", left: 0+"px" });
		  
		  //var PCom_height = $('.post_comments').eq(index).height();
		  //var PCom_userCom_height = $('.user_comment').eq(index).height();
	
		 // $('.post_comments').eq(index).height(PCom_height+0);
		 // $('.post_comments_box_profile_photo').eq(index).css({position:"relative", top: 26+"px", left: 18+"px"});
		  //$('.post_comments_box').eq(index).css({position:"relative", top: -10+"px", left: 55+"px"});
		   
                            $('.feed_1').eq(index).hover(function(){

                                     $('.post_flag').eq(index).show(800);
                                     $('.post_stats').eq(index).show(800);


                            }, function (){
                                 $(document).click(function(event){
                                     var $tagt =  $(event.target);
                                    
                                     if($tagt.is('.feed_1') || $tagt.is('.post_flag') || $tagt.is('.post_stats')|| 
                                        $tagt.is('.post_stats ul li span') ||  $tagt.is('.post_stats ul') || 
                                        $tagt.is('.post_stats ul li')|| $tagt.is('.post_flag img') || 
                                        $tagt.is('.post_profile_photo') || $tagt.is('.post_profile_photo img') ||
                                         $tagt.is('.post_profile_link')|| $tagt.is('.post_profile_link ul li') ||
                                         $tagt.is('.post_profile_link ul li img') || $tagt.is('.post_text ul li')||
                                        $tagt.is('.post_text ul')|| $tagt.is('.post_text ul li b') || $tagt.is('.post_text') ||
                                        $tagt.is('.picIngShp')|| $tagt.is('.picIngShp ul')||
                                        $tagt.is('.picIngShp ul li')|| $tagt.is('.picIngShp ul li img')){
                                         
                                     }else{
                                        $('.post_flag').eq(index).hide(800);
                                        $('.post_stats').eq(index).hide(800);
                                     }
                                 }) ;
                                 
                                    
                                 
                            });
                                  
                                    

	          });
                  
               
        
      ;
		
</script>