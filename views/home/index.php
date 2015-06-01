<!--
  View for home profile page. in views/home/index.php. folder
-->
<main class="main" role="main">
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
                    <li id="messaging" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_MESSAGE_SMALL.png);" >
                        <a href="<?php echo URL ?>message" >Message</a>
                   </li>
                    <li id="cookwith" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_COOKWITH_SMALL.png);" >
                        <a href="<?php echo URL ?>cookWith" >CookWith</a>
                   </li>
                   <li id="eatwithP" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_EATWITH_SMALL.png);">
                    <a href="<?php echo URL ?>eatWith" >EatWith</a>
                   </li>
                   
                   <li id="eventsP"  style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_EVENT_SMALL.png);">
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
                 <li id="foodFollow" onclick="onFoodFollowClick('HOME')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('HOME')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('HOME')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_REST_SMALL.png);">
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
        <span><a href="javascript:poptastic('<?php echo GMAILCONTACTLINK ?>');">Invite your friends to Foodsuss</a></span><img src="<?php echo URL ?>pictures/Gmail_Icon.png" width="30" height="30">
    </div>
    <div id="addHolder">
        <img src="" width="300" height="250" alt="">
        <img src="" width="300" height="250" alt="">
    </div>
</div>

<div id="feeds">
<?php if(count($data) !== 0){ ?>
    <?php for($i =0; $i<count($data); $i++){?>
            <?php 
                   
                    $user_name = $this->getUserNameorRestaurantName($data, $i);
                    $Food_Pic = '';$Food_Nm = '';
                    $RID = $this->getUserIDorSharerID($data, $i);
                       if(isset($foodCountry[$i][0]['food_picture'])){
                            $Food_Pic = $foodCountry[$i][0]['food_picture'];
                            $Food_Nm = $foodCountry[$i][0]['food_name'];
                        }else{$Food_Pic = EMPTYSTRING; $Food_Nm = EMPTYSTRING;}
           ?>
     <div class="post_profile_photo"><?php echo $this->checkUsersPicture($data[$i]['picture'], $RID, $user_name, 100, 100)?></div>
					  
						
                    <div class="feed_1">
                         
                            <div class="post_text">

                                <ul>
                                       <li class="RecpPhoto">
                                        <?php 
                                             echo $this->checkPWIPictures($data[$i]['recipe_post_id'], $data[$i]['recipe_photo']);
                                        ?>
                                       </li>
                                       <li class="post_flag">
                                                    <img class="homeCountry" src="<?php echo $this->checkCountryPic($foodCountry[$i][0]['flag_picture']);?>" width="20" height="20" title="<?php echo $foodCountry[$i][0]['country_names'] ?>"> 
                                                    <img class="homeFood" src="<?php echo $this->checkFoodPic($Food_Pic) ;?>" width="20" height="20" title="<?php echo $this->checkFoodpicTitle($Food_Nm) ?>">
                                       </li>
                                       <li> <span class="mealType"><?php echo $this->checkMealType($data[$i]['meal_type'], 25, 25) ?></span></li>
                                       <li class="hashTagTitle"><a href="<?php echo URL ?>home/homeRecipeSteps/<?php echo $this->encrypt($data[$i]['recipe_post_id'])?>/<?php echo $data[$i]['recipe_title'] ?>"><b><?php echo $data[$i]['recipe_title']  ?></b></a></li>
                                       <li class="recipDesc"> <?php echo $data[$i]['description']; ?></li>
                                       <li class="post_profile_link">
                                           <ul class="TYCKSHR">
                                               <li class="tastyCount"  onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $RID ?>', '<?php echo $data[$i]['recipe_post_id'] ?>', 'recipe_post_tasty', '<?php echo $i ?>')"  style=""><img src="<?php echo URL ?>pictures/home/ENRI_TASTYIT_G.png" width="18" alt="" title="say this recipe is tasty"><span title="<?php echo $this->SCTSurfix($tastyCount[$i], " people said this is tasty", " person said this is tasty")?>"><?php echo $this->post_statsSurfix($tastyCount[$i])?></span></li>
                                               <li class="cookCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $RID ?>', '<?php echo $data[$i]['recipe_post_id'] ?>', 'recipe_post_cookedit', '<?php echo $i ?>')" ><img src="<?php echo URL ?>pictures/home/ENRI_COOKEDIT_G.png" width="18" alt="" title="say you cooked this recipe"><span title="<?php echo $this->SCTSurfix($cootItCount[$i], " people cooked this" ,"person cooked this")?>"><?php echo $this->post_statsSurfix($cootItCount[$i]) ?></span></li>
                                               <li class="shareCount" onclick="insertTCS('<?php echo $this->id ?>', '<?php echo $RID ?>', '<?php echo $data[$i]['recipe_post_id'] ?>', 'recipe_post_share', '<?php echo $i ?>')"> <img  src="<?php echo URL ?>pictures/home/ENRI_SHAREIT_G.png" width="18" alt="" title="share this recipe"><span title="<?php echo $this->SCTSurfix($shareCount[$i]," people shared this", "person shared this") ?>"><?php echo $this->post_statsSurfix($shareCount[$i]) ?></span></li>
                                           </ul>
                                           <ul class="recipeNav">
                                                <li class="cookboxit" onclick="putInMyCookBox('<?php echo $data[$i]['recipe_post_id']  ?>', '<?php echo $RID ?>', '<?php echo $i ?>')"><?php echo $this->checkCoobBoxPic($data[$i]['cookbook'], 20, 20) ?></li>
                                                <li onclick="showShops('<?php echo  $i ?>','<?php echo $data[$i]['country_id'] ?>')" class="ShpCt"><img src="<?php echo URL ?>pictures/home/ENRI_SHOPS_ICON.png" width="20" alt="" title="possible shops around you to get recipe ingredients"><div class="TOOLTIPShc"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERShc"></div></li>
                                           </ul>
                                       </li>
                                </ul>
                            </div>			
                    </div>
        <?php }?>
<?php }else{
                ?>
    <div style="color: grey; position: relative; top: 100px; left: 50px; width: 500px; font-weight: 700;">You don't have any Post on your feed Yet.
        Find and Follow a food, friend, chef, restaurant or foodie to start getting post on your feed</div>
               <?php
      }
?>
</div>
    <div id="postload">
                    
    </div>
        <?php require View.'footer.php'; ?>
    
</div>

</main>
<!---
        error dialog box start here
        -->
        
        
        <!---
        error dialog box end here
        -->

        <script>
   
