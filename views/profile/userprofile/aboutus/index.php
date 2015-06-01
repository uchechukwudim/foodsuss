
<style>
    #meHolderHeader b{
       position: relative;
       left: -80px;
    } 
    #meHolderHeader img{
       position: relative;
       left: -80px;
    } 
</style>
<div class="container clearfix">
    
    <div id="personalsProfile">
            <div id="Me">
                <div id="MeHeader" onclick="getUserProfileAbouteMe('<?php echo $userId ?>')">Me</div>
                <div id="profileLocation"><img  id="locImg" src="http://localhost/pictures/profile/loc pin.png" width="20" height="15" alt=""><b>Location</b><span><img src="http://localhost/pictures/profile/arrow.png" width="25" height="10" alt=""><?php echo $userDetails[0]['city'] ?></span></div>
                <div id="favoriteFood"><img src="http://localhost/pictures/profile/favorite.png" width="20" height="15" alt=""><b>Favorite Foods</b> <span><img src="http://localhost/pictures/profile/arrow.png" width="25" height="10" alt=""> <?php echo $userDetails[0]['favorite_foods'] ?></span></div>
            </div>
            <div id="mycookbook">
                <div id="mycookbookHeader" onclick="getUserProfileMyCookBook('<?php echo $userId ?>')">My CookBook</div>
            <?php for($looper = 0; $looper < count($myCookBook); $looper++){ ?>
                <div class="myCBHolder">
                    <div class="myCBImage"> <img src="data:image/jpeg;base64,<?php echo base64_encode($myCookBook[$looper]['recipe_photo']) ?>" width="25" height="25" alt=""></div>
                    <div class="myCBRecipeTitle"><?php echo $myCookBook[$looper]['recipe_title'] ?></div>
                    <div class="myCBFood"><?php echo $myCookBook[$looper]['food_name']?>  <span class="myCBFoodLocation"><?php echo$myCookBook[$looper]['country_names'] ?></span></div>
                   
                </div>
            <?php } ?>
            </div>
            <div id="friendsFollowers">
                <div id="friendsFollowersHeader" onclick="getUserProfileFriendsFollow('<?php echo $userId ?>')">Friends/Followers</div>
                 <?php for($looper = 0; $looper < count($friendsFollowers); $looper++){ ?>
                <div class="FFHolder">
                    <div class="friendPic"><img src="data:image/jpeg;base64, <?php echo base64_encode($friendsFollowers[$looper]['picture']) ?>" width="60" height="60" alt=""></div>
                    <div class="FriendName"><b><a href="http://localhost/profile/user/<?php echo $this->encrypt($this->getfriendUserId($friendsFollowers[$looper]['user_id'],$friendsFollowers[$looper]['user_friend_id'],$userId)) ?>" ><?php echo $friendsFollowers[$looper]['FirstName']." ". $friendsFollowers[0]['LastName'] ?> </a></b></div>
                    <div class="friendUsertType"><?php echo $friendsFollowers[$looper]['user_type'] ?><span><img class="FriendverifyImg" src="http://localhost/pictures/verify.png" width="12" height="12" alt=""></span> </div>
                
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
      
          <div id="profilCover">
              <div id="prfCoverImage"><img src="data:image/jpeg;base64,<?php echo base64_encode($userDetails[0]['cover_picture']) ?>" width="650" height="196" alt=""></div>
              <div id="profilePic">
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($userDetails[0]['picture']) ?>" width="100" height="100" alt="">
              </div> 
        
              <div id="userNameVerifyHolder">
                  <div id="profileUserName"><?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName'] ?></div>
                  <div id="userverify"> <?php echo $userDetails[0]['user_type'] ?></div>
                  <img id="verifyImg" src="http://localhost/pictures/verify.png" width="15" height="15" alt="">
             </div>
          </div>
          
          <div id="AjaximageLoader"><img src="http://localhost/pictures/profile/transparentbck_ajax-loader.gif" width="60" height="60"></div>
          <div id="friendshipUpdate" onmouseover="changeStatusOnHover()" onclick="sendUserFriendShipToServer('<?php echo $status ?>', '<?php echo $statusDetails[ZERO]['user_id'] ?>', '<?php echo $statusDetails[ZERO]['user_friend_id'] ?>')"><?php echo  $status ?></div>
               
          <div id='LOAD'>
                        <div id="meHolder">
                            
                    <div id="meHolderHeader"><img src="http://localhost/pictures/profile/avater.jpg" width="30" height="30"><b>Me</b></div>
                    <div id="About">
                        
                        <div id="aboutHeader">About Me <img src="http://localhost/pictures/profile/pen_edit.png" width="10" height="10"></div>
                        <div id="aboutText">
                          <?php echo $userDetails[0]['About_me'] ?>
                        </div>
                        
                    </div>
                    
                    <div id="location">
                         <div id="LocationHeader">Location</div>
                          <div id="LocationText">
                              <div id="mobile"><b>Mobile:</b><div id="Mh"><?php echo $userDetails[0]['Mobile']?> </div></div>
                              <div id="address"><b>Address:</b><div id="Ah"><?php echo $userDetails[0]['address'] ?></div></div>
                              <div id="currentLocation"><b>Current city:</b><div id="CCh"><?php echo $userDetails[0]['city'] ?></div></div>
                              <div id="FromLoc"><b>From:</b><div id="Fmh"><?php echo $userDetails[0]['town'] ?></div></div>
                              <div id="email"><b>Email:</b><div id="Eh"><?php echo $email  ?></div></div>
                        </div>
                    </div>
                    
                    <div id="favFood">
                         <div id="favFoodHeader">Favorite Foods <img src="http://localhost/pictures/profile/pen_edit.png" width="10" height="10"></div>
                         <div id="favFoodText">
                          <?php echo $this->getfavoriteData($userDetails[0]['favorite_foods'], $type= 'Foods') ?>
                        </div>
                    </div>
                    
                    <div id="favRestuarant">
                         <div id="favRestuarantHeader">Favorite Restaurant<img src="http://localhost/pictures/profile/pen_edit.png" width="10" height="10"></div>
                         <div id="favRestuaranText">
                              <?php echo $this->getfavoriteData($userDetails[0]['favorite_restaurant'], $type= 'Restaurants') ?>
                         </div>
                    </div>
                    
                    <div id="favIngredients">
                         <div id="favIngredientsHeader">Favorite Ingredients<img src="http://localhost/pictures/profile/pen_edit.png" width="10" height="10"></div>
                         <div id="favIngredientsText">
                              <?php echo $this->getfavoriteData($userDetails[0]['favorite_ingredient'], $type= 'Ingredients') ?>
                         </div>
                    </div>
                    
                    <div id="favRecipes">
                         <div id="favRecipesHeader">Favorite Recipes<img src="http://localhost/pictures/profile/pen_edit.png" width="10" height="10"></div>
                         <div id="favRecipesText">
                             <?php echo $this->getfavoriteData($userDetails[0]['favorite_recipes'], $type= 'Recipes') ?>
                         </div>
                    </div>
                    

                </div>
                     
                </div>
                
       </div>
    <div id="postload">
                    
    </div>
</div>
<div id="imagelayer"></div>
        <div id="imagedialog">
            <div id="imageclose">| x |</div>
            <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>
            <div id="holdImage"><img id ="img1" src="" width="600" height="440"></div>
            <div id="imageholdComment"></div>
 </div>

  <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Info Box</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
  <script>

 UserInfinitScrollMyCookBook('<?php echo $this->id ?>');
  UserInfinitScrollFriendsFollow('<?php echo $this->id ?>');

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
                $(this).text("Friends?");
               
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
            
            if(status === "Friends?")
            {
                $(this).text("Follower");
                
            }
            
        });
   
   }
</script>