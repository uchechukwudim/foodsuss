
<div id="Findercontainer">
         <div id="Finderleftnav">
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
                                  <li id="foodFollow" onclick="onFoodFollowClick('FOOD')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                                      <span>Foods</span>
                                    </li>
                                    <li id="cheffollow" onclick="onFollowChefClick('FOOD')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                                        <span>Chefs</span>
                                    </li>
                                    <li id="RestFollow" onclick="onFollowRestaurantClick('FOOD')" style="list-style-image: url(<?php echo URL ?>pictures/navigationbar/ENRI_REST_SMALL.png);">
                                        <span>Restaurants</span>
                                    </li>
                                 </ul>
                             </div>

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
         
     <div id="Finderbody">
         <div style="width: 510px; border-radius: 1px; box-shadow: 0 0 10px 0px rgba(11, 2, 23, 0.3);  position: relative; left: 230px; top: 45px; background: whitesmoke">
             <div id="FFdd" class="FFwrapper-FFdropdown-3" tabindex="1" style="margin-bottom: -20px;  background: whitesmoke">
                            <span>Continent</span>
                            <ul class="FFdropdown">
                                <li><a href="foodfinder/AFRICA"><i class="icon-envelope icon-large"></i>Africa</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Asia</a></li>
                                <li><a href="foodfinder/AMERICA"><i class="icon-plane icon-large"></i>America</a></li>
                                <li><a href="foodfinder/EUROPE"><i class="icon-plane icon-large"></i>Europe</a></li>
                            </ul>
              </div>
               
             <div id="tag" style="position: relative; top: 5px;">
                 <img src="<?php echo URL ?>pictures/foods/ENRI_TellUSFOOD_ICONS.png" width="25" alt=""> <span>Tell us food we don't know about</span>
                   
            </div>
            
             <form action ="" method ="post" enctype="multipart/form-data" id="usrform" style="padding-left:10px;">   

                      <textarea  name="comment" form="usrform" id ='inputFood' style="position: relative; bottom: 10px; margin-bottom: 30px;" placeholder=" Food name, country(s) of origin, nutrients and more"></textarea>

                     <div id="btnTag">
                         <button id="submitBt" type="submit" name='submit' form="usrform">Post</button>
                         <div id="uploadPic">
                             <img src="<?php echo URL ?>pictures/camera.png" width="25" height="25" alt="">
                            <input type="file" name="file" id="file"/>
                         </div>
                     </div>
            </form>
    </div>
    <div id="foodCountryHolder">
            <?php for($looper =0; $looper < count($foods); $looper++) { ?>
                 <div class="foodCon">
                       <script  type="text/javascript">
                      
                        </script>
                       
                        <div class="followFood" > <span class="FollowCount"><b><?php echo $this->foodFollowSurfix($foodFollows_FoodFollowCount[$looper]['follow_count']) ?></b></span><img class="followFoodimg" src="<?php echo $foodFollows_FoodFollowCount[$looper]['food_follow'] ?>" title="<?php echo $foodFollows_FoodFollowCount[$looper]['food_follow_title'] ?>" width="30" height="30"  onclick="followFood('<?php echo $this->id ?>', '<?php echo  $foods[$looper]["food_id"] ?>', '<?php echo $foods[$looper]["country_id"] ?>', '<?php echo $looper ?>')"></div>
                     
                 <div class="foodpic">
                         <img src="data:image/jpeg;base64,<?php echo base64_encode($foods[$looper]["food_picture"])?>" height="100" width="100" alt="">
                     </div>
                 
                     <div class="foodName">
                      <?php echo $foods[$looper]["food_name"] ?>
                      </div>
                     
                     <div class="foodDesc">
                     <?php echo $foods[$looper]["food_description"] ?>
                     </div>
                   <div class="enri_recipes">
                     <span ><a href="<?php echo URL.MEAL.$foods[$looper]["food_name"].'/'.$foods[$looper]["country_names"] ?>"><img src="<?php echo URL ?>pictures/foods/ENRI_RECIPE_ICON.png" width="30" title="recipes" alt=""></a></span>
                     </div>
                     <div class="products" onclick="products('<?php echo $foods[$looper]["food_name"] ?>','<?php echo $foods[$looper]["country_names"] ?>', '<?php echo $looper ?>');">
                         <div id = "Prod" ><img src="<?php echo URL ?>pictures/foods/ENRI_PRODUCT_ICONS.png" width="40" title="products" alt=""></div>
                     </div>
                    <div class="OtherCountryNuterients">
                        <ul>
                            <li class="Count" onclick="tooltipCont('<?php echo $looper ?>')" title="<?php echo $otherCountries[$looper] ?>">Countries<div class="TOOLTIPCont"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERCont"></div></li>
                            <li class="Nutr" onclick="tooltipNut('<?php echo $looper ?>')" style="margin-left: 10px;" title="<?php echo $foods[$looper]["Nutrients"] ?>">Nutrients<div class="TOOLTIPNut"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERNut"></div></li>
                        </ul>
                    </div>

                    <div id="tooltips"></div>

           </div>
            <?php } ?>
       </div>
 </div>
       <div id="Finderload">

       </div>
         
</div>
<script>
    infinitScrollFoodCountryLoader('<?php echo $country ?>');
</script>


        <?php 
   if((int)$yesFood === 0){
        ?>
            <script  type="text/javascript">
            NoFooderrorMessage('<?php echo $country ?>');
            </script>
        <?php
   }
   
   