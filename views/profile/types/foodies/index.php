<script>
  infinitScrollMyCookBook();
  infinitScrollMyCookBox();
  infinitScrollFriendsFollow();
  $('#which_active').html('CB');
  $('#U_cookbook').css({"background": "orangered", "color":"white"});
  
                window.fbAsyncInit = function() {
                  FB.init({
                    appId      : '1496995027250577',
                    xfbml      : true,
                    version    : 'v2.2'
                  });
                };

                (function(d, s, id){
                   var js, fjs = d.getElementsByTagName(s)[0];
                   if (d.getElementById(id)) {return;}
                   js = d.createElement(s); js.id = id;
                   js.src = "//connect.facebook.net/en_US/sdk.js";
                   fjs.parentNode.insertBefore(js, fjs);
                 }(document, 'script', 'facebook-jssdk'));
                /*
                  function fbthings(){
                      alert("fb");
                    FB.ui({
                       method: 'feed',
                       name: '<?php echo $Result ?>',
                       link: JURL,
                       app_id: '1496995027250577',
                       caption: 'enri',
                       picture: '<?php echo URL ?>img/app-head.png',
                       description: JURL+'help',
                       redirect_uri: JURL
                     }, function(response){});
                 }
                 function tweet(){
                     newwindow=window.open('https://twitter.com/share?url='+JURL+'&text=Your <?php echo $name ?> is a <?php echo $grade ?>&via=thisisuchedim&hashtags=testandtreatmalaria','name','height=450,width=600, left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,status=yes');
                        if (window.focus) {
                            newwindow.focus();

                        }
                 }
                 */
                
</script>
<div class="container clearfix">
    <div id="which_active"></div>
    <div id="personalsProfile">
        <ul>
            <li id="P_cookbook" onclick="getProfileMyCookBook()">Cookbook</li>
            <li id="P_cookbox" onclick="getProfileMyCookBox()">Cookbox</li>
            <li id="P_aboutme" onclick="getProfileAbouteMe()">About Me</li>
            <li id="P_followers" onclick="getProfileFriendsFollow()">Followers</li>
             <li id="P_followers" onclick="shareProfile()">Share profile</li>
        </ul>
   </div>
    
     <div id="adds">
        <div id="peopleYouMayKnow">
            <img src="<?php  echo URL ?>pictures/general_smal_ajax-loader.gif" width="50" height="50">
        </div>
        <div id="InviteFriends">
            <span><a href="javascript:poptastic('<?php echo GMAILCONTACTLINK ?>');">Invite your friends to Foodsuss</a></span><img src="<?php echo URL ?>pictures/Gmail_Icon.png" width="30" height="30">
        </div>
        <div id="addHolder">
            <img src="" width="300" height="250" alt="">
            <img src="" width="300" height="250" alt="">
        </div>
    </div>

      <div id="profilDetailsHolder">
      
          <div class="profilCover">
              <div class="prfCoverImage"> <?php echo $this->checkCoverPicture($userDetails[0]['cover_picture']) ?></div>  
                <div onclick="getCoverPicFromSystem()" id="updateCover">Change Cover</div><input type="file" name="file1" id="file1"/>
          </div>
          <div class="other_cover">
              <div id="profilePic">
                    <?php echo $this->checkUserPicture($userDetails[0]['picture'], 136, 136) ?>
                  <div id="updateInfo" title="change profile picture">Change Profile Picture<input type="file" name="file" id="file"/> </div>
              </div> 
          </div>
         <div id="userNameVerifyHolder">
                  <div id="profileUserName"><?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName'] ?></div>
                  <div id="userverify" style="position:relative; top:6px;"> <?php echo $userDetails[0]['user_type'] ?></div>
                  <img id="verifyImg" src="<?php echo URL ?>pictures/verify.png" width="15" height="15" alt="" style="position: relative; left: 46px;">
                  <div class="follow_friend_count_holder">
                      <span>Followers</span><br>
                      <span class="counting"><?php echo $this->post_statsSurfix(count($friendsFollowers)) ?></span>
                  </div>
             </div>
           
          <div id="AjaximageLoader"><img src="<?php echo URL ?>pictures/profile/transparentbck_ajax-loader.gif" width="60" height="60"></div>
                
                <div id='LOAD'>
                        <div id="myCookBookHolder">
                             <!--<div id="myCookBookHolderHeader"><img src="<?php echo URL ?>pictures/profile/ENRI_COOKBOOK.png" width="30" height="30"> <b>My CookBook</b></div>-->
                                <?php 
                                    $Food_Pic = '';
                                    $Food_Nm = '';
                                    for($looper =0; $looper<count($myCookBook); $looper++){
                                    
                                        if(isset($foodCountry[$looper][0]['food_picture'])){
                                            $Food_Pic = $foodCountry[$looper][0]['food_picture'];
                                            $Food_Nm = $foodCountry[$looper][0]['food_name'];
                                        }else{$Food_Pic = EMPTYSTRING; $Food_Nm = '';}
                                    ?>
                                 <div class="post_profile_photo"><?php echo $this->checkUserPicture($userDetails[0]['picture'], 100, 100)?></div>
                                <div class="feed_1">
                                    <div class="post_text">  
                                        <ul>
                                            <li class="RecpPhoto">
                                                <?php 
                                                     echo $this->checkPWIPictures($myCookBook[$looper]['recipe_post_id'], $myCookBook[$looper]['recipe_photo']);
                                                ?>
                                            </li>
                                             <li class="post_flag">
                                                    <img class="homeCountry" src="<?php echo $this->checkCountryPic($foodCountry[$looper][0]['flag_picture']);?>" width="20" height="20" title="<?php echo $foodCountry[$looper][0]['country_names'] ?>"> 
                                                    <img class="homeFood" src="<?php echo $this->checkFoodPic($Food_Pic) ;?>" width="20" height="20" title="<?php echo $this->checkFoodpicTitle($Food_Nm) ?>">
                                             </li>
                                             <li> <span class="mealType"><?php echo $this->checkMealType($myCookBook[$looper]['meal_type'], 25, 25) ?></span></li>
                                             <li class="hashTagTitle"><b><?php echo $myCookBook[$looper]['recipe_title']  ?></b></li>
                                             <li class="recipDesc"> <?php echo $myCookBook[$looper]['description']; ?></li>
                                             <li class="post_profile_link">
                                                 <ul class="TYCKSHR">
                                                    <li class="tastyCount"  onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $myCookBook[$looper]['user_id'] ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_tasty', '<?php echo $looper ?>')"  title="say this recipe is tasty"><img src="<?php echo URL ?>pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCount[$looper], " people said this is tasty", " person said this is tasty")?>"><?php echo $this->post_statsSurfix($tastyCount[$looper])?></span></li>
                                                    <li class="cookCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $myCookBook[$looper]['user_id']   ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_cookedit', '<?php echo $looper ?>')" title="say you cooked this recipe"><img src="<?php echo URL ?>pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cootItCount[$looper], " people cooked this" ,"person cooked this")?>"><?php echo $this->post_statsSurfix($cootItCount[$looper]) ?></span></li>
                                                    <li class="shareCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo  $myCookBook[$looper]['user_id']   ?>', '<?php echo $myCookBook[$looper]['recipe_post_id'] ?>', 'recipe_post_share', '<?php echo $looper ?>')" title="share this recipe"><img  src="<?php echo URL ?>pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCount[$looper]," people shared this", "person shared this") ?>"><?php echo $this->post_statsSurfix($shareCount[$looper]) ?></span></li>
                                                 </ul>
                                                 <ul class="recipeNav">
                                                    <li onclick="showShops('<?php echo  $looper ?>','<?php echo $myCookBook[$looper]['recipe_post_id'] ?>')" class="ShpCt"><img src="<?php echo URL ?>pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                                 </ul>
                                                 
                                             </li>     
                                        </ul>
				   </div>
                                </div>
                                        <?php }?>
                      </div>  
             </div>

      </div>
<div  id="userPostLoad"></div>

<script>
window.twttr=(function(d,s,id){var t,js,fjs=d.getElementsByTagName(s)[0];if(d.getElementById(id)){return}js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);return window.twttr||(t={_e:[],ready:function(f){t._e.push(f)}})}(document,"script","twitter-wjs"));
</script>