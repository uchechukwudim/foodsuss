  <div id="container">
     <div id="leftnav">
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
                    <li id="messaging" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_MESSAGE_SMALL.png);" >
                        <a href="<?php echo URL ?>message" >Message</a>
                   </li>
                    <li id="cookwith" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_COOKWITH_SMALL.png);" >
                        <a href="<?php echo URL ?>cookWith" >CookWith</a>
                   </li>
                   <li id="eatwithP" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_EATWITH_SMALL.png);">
                    <a href="<?php echo URL ?>eatWith" >EatWith</a>
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
                 <li id="foodFollow" onclick="onFoodFollowClick('RECIPE')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('RECIPE')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('RECIPE')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_REST_SMALL.png);">
                       <span>Restaurants</span>
                   </li>
                </ul>
            </div>
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
      
            <div id="body">
                <div id="CRdd" class="CRwrapper-CRdropdown-3" tabindex="1" >
                     <span id="CRSwitchHolder">Foodsuss</span>
                            <span id="counterHolder">0</span>
                            <ul class="CRdropdown">
                                <li><a href="foodfinder/AFRICA"><i class="icon-envelope icon-large"></i>ENRI</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Chef</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Foodie</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Restaurant</a></li>
                            </ul>
                     </div> 
               
                <div id="FoodMeal" onclick="navToFoods('<?php echo $country ?>');" style="position: relative; top: -14px; left: 300px;"><span class="FN"><img src="data:image/jpeg;base64,<?php echo base64_encode($food_picture) ?>" width="20" height="20" title="<?php echo $food ?> in <?php echo $country; ?>"></span></div>
     
               <div id="recipesHolder">
                 <?php if(count($recipes) !== ZERO){ ?>
                       <?php for($looper = 0; $looper < count($recipes); $looper++){ ?>
                      <div class="post_profile_photo"><img src="<?php echo URL ?>pictures/favicon3.png" width="100" height="100"></div>
                        <div class="feed_1">
                            <div class="post_text">
                                <ul >
                                    <li class="RecpPhoto">
                                        <?php echo $this->checkPWIPictures($recipes[$looper]['recipe_id'], $recipes[$looper]['recipe_photo']);?>  
                                    </li>
                                    <li class="post_flag">
                                        <img class="homeCountry" src="data:image/jpeg;base64,<?php echo base64_encode( $recipes[$looper]['flag_picture'])?>" width="20" height="20" title="<?php echo  $recipes[$looper]['country_names'] ?>"> 
                                        <img class="homeFood" src="data:image/jpeg;base64,<?php echo base64_encode( $recipes[$looper]['food_picture'])?>" width="20" height="20" title="<?php echo  $recipes[$looper]['food_name'] ?>">
                                    </li>
                                    <li><span class="mealType"><?php echo $this->checkMealType($recipes[$looper]['meal_type'], 25, 25) ?></span></li>
                                    <li class="hashTagTitle"><b><?php echo $recipes[$looper]['recipe_title']  ?></b></li>
                                    <li class="recipDesc"><?php echo $recipes[$looper]['cook'] ?></li>
                                    <li class="post_profile_link">
                                        <ul class="TYCKSHR">
                                            <li class="tastyCount"  onclick="insertTastyEN('<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo  $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="say this recipe is tasty"><img src="<?php echo URL ?>pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty")?>"><?php echo $this->post_statsSurfix($tastyCounts[$looper])?></span></li>
                                            <li class="cookCount" onclick="CookIt('<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="say you cooked this recipe"><img src="<?php echo URL ?>pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cookitCounts[$looper], " people cooked this" ,"person cooked this")?>"><?php echo $this->post_statsSurfix($cookitCounts[$looper]) ?></span></li>
                                            <li class="shareCount" onclick="insertShareEN( '<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo  $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="share this recipe"><img  src="<?php echo URL ?>pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this") ?>"><?php echo $this->post_statsSurfix($shareCounts[$looper]) ?></span></li>
                                       </ul>
                                       <ul class="recipeNav">
                                            <li class="cookboxit" onclick="putInMyCookBox('<?php echo $recipes[$looper]['recipe_id']  ?>', '<?php echo $looper ?>')"><?php echo $this->checkCoobBoxPic($cookBox[$looper], 20, 20) ?></li>
                                            <li onclick="showShops('<?php echo  $looper ?>','<?php echo $recipes[$looper]['country_id'] ?>')" class="ShpCt"><img src="<?php echo URL ?>pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                       </ul>
                                    </li>
                               </ul>
                           </div>
                      </div>
                   <?php } ?>
                         
            <?php   }else{
                            ?>
                                <div style="color: grey; margin-top: 100px;">There are no recipe's for <b><?php echo $food ?></b> from enri yet.</div>
                           <?php
                    }
             ?>
                </div>

            
      </div>
           
      <div id="postload" style="margin-left: 100px;" ></div>
</div>

<script>
     infinitScrollENRecipeLoader('<?php echo $country ?>');
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
                  
                  var newStat = userCommentH+stat+FHeight-240;
		 var newFlag = userCommentH+flag+FHeight-240;
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