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
                 <div id="alldd" class="allwrapper-alldropdown-3" tabindex="1">
                     <span id="RecipeSwitchHolder">Foodsuss</span>
                            <span id="allcounterHolder">0</span>
                            <span class="ALLFOODHOLD"><?php echo $food ?></span>
                            <ul class="alldropdown">
                                <li><a href="foodfinder/AFRICA"><i class="icon-envelope icon-large"></i>ENRI</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Chef</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Foodie</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Restaurant</a></li>
                            </ul>
                     </div> 
               
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
                                            <li class="tastyCount"  onclick="insertTastyEN('<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo  $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="say this recipe is tasty"><img src="<?php echo URL ?>pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCounts[$looper], " people said this is tasty", " person said this is tasty")?>"><b><?php echo $this->post_statsSurfix($tastyCounts[$looper])?></b></span></li>
                                            <li class="cookCount" onclick="CookIt('<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="say you cooked this recipe"><img src="<?php echo URL ?>pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cookitCounts[$looper], " people cooked this" ,"person cooked this")?>"><b><?php echo $this->post_statsSurfix($cookitCounts[$looper]) ?></b></span></li>
                                            <li class="shareCount" onclick="insertShareEN( '<?php echo $recipes[$looper]["recipe_id"] ?>', '<?php echo  $recipes[$looper]["country_id"] ?>', '<?php echo $looper  ?>')" title="share this recipe"><img  src="<?php echo URL ?>pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCounts[$looper]," people shared this", "person shared this") ?>"><b><?php echo $this->post_statsSurfix($shareCounts[$looper]) ?></b></span></li>
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
                    
              <?php }else{
                  ?>
               <div style="color: grey; margin-top: 100px;">There are no recipe's for <b><?php echo $food ?></b> from enri yet.</div>
               <?php
              }
              
              ?>
              </div>

            
      </div>
           
      <div id="postload"></div>
</div>

 <script>
      infinitScrollAllENRecipeLoader('<?php echo $food ?>');
</script>