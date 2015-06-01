<div id="container">
<div id="personals">
    
        <div id="userPersonals">
            
            <span id="imgP">
                <?php echo  $this->checkUserPicture($userDetails[ZERO]['picture'], 100, 100) ?>
            </span>
            <span id="nameP">
                <a href='<?php echo URL ?>profile'><b><?php 
                             echo $userDetails[ZERO]['UserName'];
                        ?></b></a>
            </span>
            <div id="personalNav">
     
                <ul>
                    <li id="messaging" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_MESSAGE_SMALL.png);" >
                        <a href="<?php echo URL ?>message" >Message</a>
                   </li>
                    <li id="cookwith" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_COOKWITH_SMALL.png);" >
                        <a href="<?php echo URL ?>CookWith" >CookWith</a>
                   </li>
                   <li id="eatwithP" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_EATWITH_SMALL.png);">
                    <a href="<?php echo URL ?>EatWith" >EatWith</a>
                   </li>
                   
                   <li id="eventsP"  style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_EVENT_SMALL.png);">
                      <a href="<?php echo URL ?>events" > Events</a>
                   </li>

                </ul>

            </div>
        </div>
 
      
            <div id='actContainer'>
                <span id='connect'>Following</span>
             <ul id='act'>
                 <li id="foodFollow" onclick="onFoodFollowClick('HOME')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('HOME')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('HOME')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_REST_SMALL.png);">
                       <span>Restaurants</span>
                   </li>
                </ul>
            </div>
     
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

<div id="feeds">
<?php if(count($data) !== 0){ ?>
         <?php for($looper =0; $looper<count($data); $looper++){?>
                                <div class="feed_1">
                                    <script>
                                
                                    </script>
                                         <div class="post_profile_photo"><?php echo $this->checkUserPicture($data[0]['picture'], 100, 100)?></div>
                                                <div class="post_text">
                                                    <span class="mealType"><?php echo $this->checkMealType($data[$looper]['meal_type'], 25, 25) ?></span>
							<ul >
                                                            <li style ="color:#FF4500; margin-left:-5px"><b> <?php echo $data[$looper]['UserName']; ?>   </b></li>
                                                                          <li class="hashTagTitle"><b><?php echo $data[$looper]['recipe_title']  ?></b></li>
									  <li class="RecpInstr">
									  <?php echo $data[$looper]['how_its_made'] ?>
									 </li>
									
							</ul>
						</div>
                                         
                                                <div class="post_profile_link">
						 <ul>
                                                       <li style="position: relative; top: 5px;"><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($data[$looper]['user_id']) ?>"><img src="<?php echo URL ?>pictures/home/ENRI_COOKBOOK.png" width="20" alt="" title="cook book"></a></li>
                                                       <li onclick="showNotifRecipeImage(<?php echo $data[$looper]['recipe_post_id'] ?>)" style="position: relative; top: 8px;"><img src="<?php echo URL ?>pictures/home/ENRI_RES_PIC.png" width="25" alt="" title="recipe picture"></li>
                                                       <li onclick="tooltip('<?php echo $looper ?>')" class="INGRE" style="position: relative; top: 9px; right: 2px;"> <img  src="<?php echo URL ?>pictures/home/ingredient_image.png" width="25" alt="" title="<?php echo $data[$looper]['ingredients'] ?>"><div class="TOOLTIP"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDER"></div></li>
						  </ul>
						</div>
                                         
                                                <div class="picIngShp">
							<ul class="recipeNav">
                                                            <li class="cookboxit" onclick="putInMyCookBox('<?php echo $data[$looper]['recipe_post_id']  ?>', '<?php echo $data[$looper]['user_id']?>', '<?php echo $looper ?>')"><?php echo $this->checkCoobBoxPic($data[$looper]['cookbook'], 20, 20) ?></li>
                                                            <li onclick="showShops('<?php echo  $looper ?>','<?php echo $data[$looper]['recipe_post_id'] ?>')" class="ShpCt"><img src="<?php echo URL ?>pictures/home/ENRI_SHOPS_ICON.png" width="25" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
							</ul>
						</div>
                                                <div class="post_comments">
                                                                <div class="commentCounter">- - - - - - - - - - - - - - - - - - - - - <span onclick="showAllComment('<?php echo $looper ?>', <?php echo $data[$looper]['recipe_post_id'] ?>)"><?php echo $this->getuserCommentCountSuffix(count($userComments)) ?></span> - - - - - - - - - - - - - - - - - - - - - </div>
                                                                <div class="UserComments">
                                                                        <?php 
                                                                        if(count($userComments) >= THREE){
                                                                            for($loop=0; $loop < THREE; $loop++)
                                                                            {
                                                                                ?>
                                                                            <div class="user_photo"><?php echo $this->checkUserPicture($userComments[$looper]['image'], 35, 35) ?></div>
                                                                            <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$looper]['user_id'])?>"><?php echo $userComments[$looper]['userName'] ?></a></b></div> <div class="postTime"><?php echo $this->timeCounter($userComments[$looper]['time'])?></div>
                                                                            <div class="user_comment">
                                                                            <?php echo $userComments[$looper]['comments'] ?>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                        }else if(count($userComments)< THREE){
                                                                            for($loop=0; $loop < count($userComments); $loop++)
                                                                            {
                                                                                ?>
                                                                            <div class="user_photo"><?php echo $this->checkUserPicture($userComments[$looper]['image'], 35, 35) ?></div>
                                                                            <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$looper]['user_id'])?>"><?php echo $userComments[$looper]['userName'] ?></a></b></div> <div class="postTime"><?php echo $this->timeCounter($userComments[$looper]['time'])?></div>
                                                                            <div class="user_comment">
                                                                            <?php echo $userComments[$looper]['comments'] ?>
                                                                            </div>
                                                                            <?php
                                                                            }
                                                                        }
                                                                            ?>
                                                                </div>
                                                                <div class="post_comments_box_profile_photo"><img src="<?php echo URL ?>pictures/me.jpg" width="35"></div>
                                                                <div class="post_comments_box"  contenteditable="true" tabindex="1" onkeyup="sendUserRecookComment('<?php echo $data[$looper]['recipe_post_id'] ?>', event, '<?php echo $data[$looper]['user_id'] ?>', '<?php echo $looper ?>')">
                                                                    <p>show how you might make this recipe or leave a comment</p>
                                                                </div>
                                                </div>
                                         
                                                <div class="post_stats">
							  <ul>
                                                              <li class="tastyCount"  onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $data[$looper]['user_id'] ?>', '<?php echo $data[$looper]['recipe_post_id'] ?>', 'recipe_post_tasty', '<?php echo $looper ?>')" style="list-style-image: url(http://localhost/pictures/home/ENRI_TASTYIT.png)" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCount, " people said this is tasty", " person said this is tasty")?>"><b><?php echo $this->post_statsSurfix($tastyCount)?></b></span></li>
                                                              <li class="cookCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $data[$looper]['user_id']   ?>', '<?php echo $data[$looper]['recipe_post_id'] ?>', 'recipe_post_cookedit', '<?php echo $looper ?>')" style="list-style-image: url(http://localhost/pictures/home/ENRI_COOKEDIT.png)" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cootItCount, " people cooked this" ,"person cooked this")?>"><b><?php echo $this->post_statsSurfix($cootItCount) ?></b></span></li>
                                                              <li class="shareCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $data[$looper]['user_id']   ?>', '<?php echo $data[$looper]['recipe_post_id'] ?>', 'recipe_post_share', '<?php echo $looper ?>')" style="list-style-image: url(http://localhost/pictures/home/ENRI_SHAREIT.png)" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCount," people shared this", "person shared this") ?>"><b><?php echo $this->post_statsSurfix($shareCount) ?></b></span></li>
							  </ul>
						</div>
						<div class="post_flag">
							<img class="homeCountry" src="data:image/jpeg;base64,<?php echo base64_encode($foodCountry[0]['flag_picture'])?>" width="35" height="35" title="<?php echo $foodCountry[0]['country_names'] ?>"> 
                                                        <img class="homeFood" src="data:image/jpeg;base64,<?php echo base64_encode($foodCountry[0]['food_picture'])?>" width="35" height="35" title="<?php echo $foodCountry[0]['food_name'] ?>">
						</div>
                                    </div>
                                  <?php }?>
                       
<?php }else{
                ?>
    <div style="color: grey; margin-top: 100px;"> </div>
               <?php
      }
?>
</div>
    <div id="postload">
                    
    </div>
        <?php require View.'footer.php'; ?>
    
</div>

 <div id="imagelayer"></div>
        <div id="imagedialog">
            <div id="imageclose">| x |</div>
            <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>
            <div id="holdImage"><img id ="img1" src="" width="600" height="440"></div>
            <div id="imageholdComment"></div>
        </div>
  
<!---
        error dialog box start here
        -->
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Info Box</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
        
        <!---
        error dialog box end here
        -->

        <div id="productLayer"></div>
        <div id="productDialog">
            <div id="ProductClose">|x|</div>
            <div id="header_dialogProd"><span class="txt"></span></div>
            <div id="holdProd"></div>
           
        </div>
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