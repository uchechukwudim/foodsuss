<script>
  infinitScrollMyCookBook();
  infinitScrollFriendsFollow();
</script>
<div class="container clearfix">
    
    <div id="personalsProfile">
            <div id="Me">
                <div id="MeHeader" onclick="getUserProfileAbouteMe('<?php echo $userId ?>')">Me <img style="margin-left: 218px;" src="<?php echo URL ?>pictures/profile/avater.jpg" width="20" height="20"></div>
                <div id="profileLocation"><img  id="locImg" src="<?php echo URL ?>pictures/profile/loc pin.png" width="20" height="15" alt=""><b>Location</b><span><img src="<?php echo URL ?>pictures/profile/arrow.png" width="25" height="10" alt=""><?php echo $userDetails[0]['city'] ?></span></div>
                <div id="favoriteFood"><img src="<?php echo URL ?>pictures/profile/favorite.png" width="20" height="15" alt=""><b>Favorite Foods</b> <span><img src="<?php echo URL ?>profile/arrow.png" width="25" height="10" alt=""> <?php echo $userDetails[0]['favorite_foods'] ?></span></div>
            </div>
            <div id="mycookbook">
                <div id="mycookbookHeader" onclick="getUserProfileMyCookBook('<?php echo $userId ?>')">My CookBook <img style="margin-left: 150px;" src="<?php echo URL ?>pictures/profile/ENRI_COOKBOOK.png" width="20" height="20"></div>
            <?php for($looper = 0; $looper < count($myCookBook); $looper++){ ?>
                <div class="myCBHolder">
                    <div class="myCBImage"> <img src="data:image/jpeg;base64,<?php echo base64_encode($myCookBook[$looper]['recipe_photo']) ?>" width="25" height="25" alt=""></div>
                    <div class="myCBRecipeTitle"><?php echo $myCookBook[$looper]['recipe_title'] ?></div>
                    <div class="myCBFood"><?php echo $myCookBook[$looper]['food_name']?>  <span class="myCBFoodLocation"><?php echo$myCookBook[$looper]['country_names'] ?></span></div>
                   
                </div>
            <?php } ?>
            </div>
         <div id="mycookBox">
                <div id="mycookBoxHeader" onclick="getProfileMyCookBox()">My CookBox <img style="margin-left: 158px;" src="<?php echo URL ?>pictures/profile/ENRI_COOKBOOK.png" width="20" height="20"></div>
            <?php for($looper = 0; $looper < count($cookBox); $looper++){
                 $URecpPost = 'USERRECIPEPOST';
                 $ERecpPost = 'ENRIRECIPEPOST';
                 $r_pic = '';
                 $r_title = '';
                 $r_food_pic = '';
                 $r_food_name = '';
                 $r_country_name = '';
                 $r_country_pic = '';
                 if($cookBox[$looper][0]['recipe_table'] === $URecpPost){
                        $r_pic = $cookBox[$looper][0]['recipe_photo'];
                        $r_title = $cookBox[$looper][0]['recipe_title'] ;
                        $r_food_pic = $cookBox[$looper][0]['food_picture'];
                        $r_food_name = $cookBox[$looper][0]['food_name'];
                        $r_country_name = $cookBox[$looper][0]['country_names'];
                        $r_country_pic = $cookBox[$looper][0]['flag_picture'];
                 }else if($cookBox[$looper][0]['recipe_table'] === $ERecpPost){
                       $r_pic = $cookBox[$looper][0]['recipe_photo'];
                        $r_title = $cookBox[$looper][0]['recipe_title'] ;
                        $r_food_pic = $cookBox[$looper][0]['food_picture'];
                        $r_food_name = $cookBox[$looper][0]['food_name'];
                        $r_country_name = $cookBox[$looper][0]['country_names'];
                        $r_country_pic = $cookBox[$looper][0]['flag_picture'];
                 }
                
                ?>
                <div class="myCBxHolder">
                    <div class="myCBxImage"> <img src="data:image/jpeg;base64,<?php echo base64_encode($r_pic) ?>" width="30" height="30" alt=""></div>
                    <div class="myCBxRecipeTitle"><?php echo $r_title ?></div>
                    <div class="myCBxFood"><img src="data:image/jpeg;base64,<?php echo base64_encode($r_food_pic) ?>" width="20" height="20" alt="" title="<?php echo $r_food_name ?>">  <span class="myCBFoodLocation"><img src="data:image/jpeg;base64,<?php echo base64_encode($r_country_pic) ?>" width="20" height="20" alt="" title="<?php echo $r_country_name ?>"></span></div>
                   
                </div>
            <?php } ?>
            </div>
            <div id="friendsFollowers">
                <div id="friendsFollowersHeader" onclick="getUserProfileFriendsFollow('<?php echo $userId ?>')">Friends/Followers <img style="margin-left: 110px;" src="<?php echo URL ?>pictures/profile/ENRI_friends_icon.png" width="20" height="20"> <img style="margin-left: 0px;" src="<?php echo URL ?>pictures/profile/ENRI_follower_icon.png" width="20" height="20"></div>
                 <?php for($looper = 0; $looper < count($friendsFollowers); $looper++){ 
                     $friendName = '';
                     if(isset($friendsFollowers[$looper]['FirstName']))
                     {
                         $friendName = $friendsFollowers[$looper]['FirstName']." ". $friendsFollowers[$looper]['LastName'];
                     }
                     else
                     {
                         $friendName = $friendsFollowers[$looper]['restaurant_name'];
                     }    
                  ?>
                <div class="FFHolder">
                    <div class="friendPic"><?php echo $this->checkUserPicture($friendsFollowers[$looper]['picture'], 60, 60) ?></div>
                    <div class="FriendName"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($this->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'], $userId )) ?>" ><?php echo  $friendName ?> </a></b></div>
                    <div class="friendUsertType"><?php echo $friendsFollowers[$looper]['user_type'] ?><span><img class="FriendverifyImg" src="<?php echo URL ?>pictures/verify.png" width="12" height="12" alt=""></span> </div>
                
                </div>
                 <?php } ?>
            </div>
            <div id="photos">
                <div id="photosheader">Photos</div>
               <?php for($looper = 0; $looper < count($recipeImages); $looper++){ ?>
                <div class="photosHolder" onclick="showPhotos('<?php echo $recipeImages[$looper]['recipe_title']?>', 'data:image/jpeg;base64,<?php echo base64_encode($recipeImages[$looper]['recipe_photo']) ?>')"><img src="data:image/jpeg;base64, <?php echo base64_encode($recipeImages[$looper]['recipe_photo']) ?>" width="91" height="91" alt=""></div>
              <?php } ?>
              <p>.</p>
            </div>
   </div>
    
    <div id="profilExtras">
    Adds
    </div>

      <div id="profilDetailsHolder">
      
          <div class="profilCover">
             <div class="prfCoverImage"> <?php echo $this->checkCoverPicture($userDetails[0]['cover_picture']) ?></div>
              <div id="profilePic">
                    <?php echo $this->checkUserPicture($userDetails[0]['picture'], 100, 100) ?>
              </div> 
        
        
              <div id="userNameVerifyHolder">
                  <div id="profileUserName"><?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName'] ?></div>
                  <div id="userverify"> <?php echo $userDetails[0]['user_type'] ?></div>
                  <img id="verifyImg" src="<?php echo URL ?>pictures/verify.png" width="15" height="15" alt="">
             </div>
          </div>
         
          <div id="updateInfo" title="change profile picture">Change Picture </div> <div id="updateCover">Change Cover<input type="file" name="file" id="file"/></div>
          <div id="AjaximageLoader"><img src="<?php echo URL ?>pictures/profile/transparentbck_ajax-loader.gif" width="60" height="60"></div>
                
                <div id='LOAD'>
                        <div id="myCookBookHolder">
                             <div id="myCookBookHolderHeader"><img src="<?php echo URL ?>pictures/profile/ENRI_COOKBOOK.png" width="30" height="30"> <b>My CookBook</b></div>
                                  <?php for($looper =0; $looper<count($myCookBook); $looper++){?>
                                    <div class="feed">
                                                        
                                                        <div class='homeCountry'><img src="data:image/jpeg;base64,<?php echo base64_encode($foodCountry[$looper][0]['flag_picture'])?>" width="25" height="25" title="<?php echo $foodCountry[$looper][0]['country_names'] ?>"></div>
                                                        <div class='homeFood'><img src="data:image/jpeg;base64,<?php echo base64_encode($foodCountry[$looper][0]['food_picture'])?>" width="25" height="25" title="<?php echo $foodCountry[$looper][0]['food_name'] ?>"></div>
                                                        
                                                        <div class="feedMessage">   
                                                            <div class="hashTagTitle"><?php echo $myCookBook[$looper]['recipe_title'] ?>

                                                            </div>
                                                            <div class="messagefeed">
                                                               <?php echo $myCookBook[$looper]['how_its_made'] ?>
                                                            </div>
                                                        </div>  
                                                                    <div class="recipeFunc">

                                                                        <div class="pic" onclick="showProfileRecipeImage(<?php echo $myCookBook[$looper]['recipe_post_id'] ?>) ">Recipe photo</div>

                                                                        <div class ="nuterient" title="<?php echo $myCookBook[$looper]['health_facts'] ?>">Health
                                                                        <span class="nutHold"> </span>
                                                                        </div>
                                                                        <div class="Ingredients" title="<?php echo $myCookBook[$looper]['ingredients'] ?>">Ingredient
                                                                            <span class="IngHolder"> </span>
                                                                        </div>
                                                                        <div class="iconTCS">
                                                                            <span class="TastyCounting" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $myCookBook[$looper]['user_id']  ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_tasty', '<?php echo $looper?>')"><img src="<?php echo URL ?>pictures/home/tasty.png" width="15" height="15"></span>
                                                                             <span class="CookCounting" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $myCookBook[$looper]['user_id']  ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>','recipe_post_cookedit', '<?php echo $looper?>')"><img src="<?php echo URL ?>pictures/home/cookedit.png" width="15" height="15"></span>
                                                                              <span class="shareCounting" onclick="insertTCS('<?php echo $this->id ?>','<?php echo $myCookBook[$looper]['user_id']  ?>',  '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_share', '<?php echo $looper?>')"><img src="<?php echo URL ?>pictures/home/sharer.png" width="15" height="15"></span>

                                                                        </div>
                                                                   </div>  
                                            <div class='recipeFuncProgressBar'>
                                                <span class='tastyCount'><?php echo $this->SCTSurfix($tastyCount[$looper], " people said this is tasty", " person said this is tasty")?></span>
                                            </div>
                                            <div class="recipeFuncProgressBarCookedItSharedIt"> 
                                                <span class='cookCount'> <?php echo $this->SCTSurfix($cootItCount[$looper], " people cooked this" ,"person cooked this")?></span>
                                                <span class='shareCount'> <?php echo $this->SCTSurfix($shareCount[$looper]," people shared this", "person shared this") ?></span>
                                            </div>
                                           <div class="homeNumberOfcomments"> 
                                               <div class="homeCommentsCount"><?php echo $this->getuserCommentCountSuffix(count($userComments[$looper])) ?> </div>
                                           </div>
                                           <div class="homeUserComments">    
                                                                <?php 
                                                        for($loop=0; $loop < count($userComments[$looper]); $loop++)
                                                        {
                                                            ?>
                                                        <div class="commentsHolderHome">    
                                                                        <div class="userPic">
                                                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($userComments[$looper][$loop]['image'])?>" width="80" height="70">
                                                                        </div>
                                                                        <div class="postTime"><?php echo $this->timeCounter($userComments[$looper][$loop]['time'])?></div>
                                                                        <div class="userName"><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$looper]['user_id']) ?>"><?php echo $userComments[$looper][$loop]['userName'] ?></a></div>

                                                                        <div class="userDesc"><?php echo $userComments[$looper][$loop]['comments'] ?></div>

                                                                        <div class="userCookit" onclick="countUsertryIt( '<?php echo $userComments[$looper][$loop]['recipe_post_comments_id'] ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', '<?php echo $myCookBook[$looper]['food_id']?>', '<?php echo $myCookBook[$looper]['country_id']?>',  '<?php echo $this->removeHashTag($myCookBook[$looper]['recipe_title']."_cookeditview")?>',  '<?php echo $loop ?>')"><span ><img src="<?php echo URL ?>pictures/home/cookedit.png" width="15" height="15" alt=""></span></div>
                                                                        <div class="<?php echo $this->removeHashTag($myCookBook[$looper]['recipe_title'] ."_cookeditview")?>"><?php echo $userComments[$looper][$loop]['triedIt'] ?></div>
                                                                        <script>setCookViewCss('<?php echo $this->removeHashTag($myCookBook[$looper]['recipe_title'] ."_cookeditview") ?>')</script>
                                                        </div>
                                                          <?php
                                                        }
                                                      ?>

                                                       
                                          </div> 
                                          <div class="post_comments_box_profile_photo"><?php echo $this->checkUserPicture($userDetails[0]['thisuserimage'], 35, 35)?></div>
                                           <div class="usertextareaHome" contenteditable="true" tabindex="1"  onkeyup="sendUserRecookComment('<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', event, '<?php echo $myCookBook[$looper]['user_id'] ?>', '<?php echo $looper ?>')">
                                                   <p>Show how you make <?php echo $myCookBook[$looper]['recipe_title']?>... or Leave a comment</p>
                                          </div>

                                  </div>
                                  <?php }?>
                         </div>
                     
                </div>
                
       </div>
    <div id="postload">
                    
    </div>
</div>

  