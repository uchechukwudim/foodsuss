
<style>
       .friendStatus{
        text-align:  center
    }
</style>
<div class="container clearfix">
    
    <div id="personalsProfile">
            <div id="Me">
                <div id="MeHeader" onclick="getUserProfileAbouteMe('<?php echo $userId ?>')">Me</div>
                <div id="profileLocation"><img  id="locImg" src="<?php echo URL ?>pictures/profile/loc pin.png" width="20" height="15" alt=""><b>Location</b><span><img src="<?php echo URL ?>pictures/profile/arrow.png" width="25" height="10" alt=""><?php echo $userDetails[0]['city'] ?></span></div>
                <div id="favoriteFood"><img src="<?php echo URL ?>pictures/profile/favorite.png" width="20" height="15" alt=""><b>Favorite Foods</b> <span><img src="<?php echo URL ?>pictures/profile/arrow.png" width="25" height="10" alt=""> <?php echo $userDetails[0]['favorite_foods'] ?></span></div>
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
                    <div class="FriendName"><b><a href="<?php echo URL; ?>profile/user/<?php echo $this->encrypt($this->getfriendUserId($friendsFollowers[$looper]['user_id'],$friendsFollowers[$looper]['user_friend_id'],$userId)) ?>" ><?php echo  $friendName ?> </a></b></div>
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
             <div id="prfCoverImage"> <?php echo $this->checkCoverPicture($userDetails[0]['cover_picture']) ?></div>
              <div id="profilePic">
                    <?php echo $this->checkUserPicture($userDetails[0]['picture'], 100, 100) ?>
              </div> 
        
              <div id="userNameVerifyHolder">
                  <div id="profileUserName"><?php echo $userDetails[0]['FirstName']." ". $userDetails[0]['LastName'] ?></div>
                  <div id="userverify"> <?php echo $userDetails[0]['user_type'] ?></div>
                  <img id="verifyImg" src="<?php echo URL; ?>pictures/verify.png" width="15" height="15" alt="">
             </div>
          </div>
          
          <div id="AjaximageLoader"><img src="<?php echo URL; ?>pictures/profile/transparentbck_ajax-loader.gif" width="60" height="60"></div>
          <div id="friendshipUpdate" onmouseover="changeStatusOnHover()" onclick="sendUserFriendShipToServer('<?php echo $status ?>', '<?php echo $statusDetails[ZERO]['user_id'] ?>', '<?php echo $statusDetails[ZERO]['user_friend_id'] ?>')"><?php echo  $status ?></div>
                
                <div id='LOAD'>
                     <div id="FriendFollowerHolder">
                    <div id="FriendFollowerHolderHeader"><img src="<?php echo URL; ?>pictures/profile/friends_follow.png" width="30" height="30"><b> Friends/Followers</b></div>
                    <?php 
                    $output='';
                      $U_id = '';
                        $U_F_id = '';
                     for($looper = 0; $looper < count($friendsFollowers); $looper++)
                     { 
                        if($friendsFollowers[$looper]['user_id'] == $userId && $friendsFollowers[$looper]['user_friend_id']!= $userId)
                        {
                            $U_id = $this->id;
                            $U_F_id = $friendsFollowers[$looper]['user_friend_id'];
                            
                        }
                        else if($friendsFollowers[$looper]['user_id'] != $userId && $friendsFollowers[$looper]['user_friend_id']== $userId)
                        {
                            $U_id = $friendsFollowers[$looper]['user_id'];
                            $U_F_id = $this->id;
                       
                        }
                        
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
                    <div class="FFHolderMain">
                      <div class="friendPicMain"><?php echo $this->checkUserPicture($friendsFollowers[$looper]['picture'], 60, 60) ?></div>
                      <div class="FriendNameMain"><b><a href="<?php echo URL; ?>profile/user/<?php echo $this->encrypt($this->getfriendUserId($friendsFollowers[$looper]['user_id'], $friendsFollowers[$looper]['user_friend_id'],$userId))?>"><?php echo  $friendName?></a> </b></div>
                      <div class="friendUsertTypeMain"><?php echo $friendsFollowers[$looper]['user_type'] ?><span><img class="FriendverifyImg" src="<?php echo URL; ?>pictures/verify.png" width="12" height="12" alt=""></span> </div>
                      <div class="friendStatus"  onclick="sendFriendShipToServer('<?php echo $friendsFollowers[$looper]['status']?>', '<?php echo $U_id ?>', '<?php echo $U_F_id ?>', '<?php echo $looper ?>')"> <?php echo preg_replace('/\s+/', '', $friendsFollowers[$looper]['status']) ?></div>
                      <div class="recipeCount"><img src="<?php echo URL; ?>profile/recipe.png" width="20" height="20"> Recipes Posted <span><?php echo $recipePostCount[$looper] ?></span></div>
                      <div class="friendCount"><img src="<?php echo URL; ?>pictures/profile/friends_icon.png" width="20" height="20"> Friends <span> <?php echo $friendsCount[$looper] ?></span></div>
                      <div class="followerCount"><img src="<?php echo URL; ?>pictures/profile/follower_icon.png" width="20" height="20"> Followers<span><?php echo $followerCount[$looper] ?></span></div>
                  </div>
                   <?php } ?>
                    <p>.</p>
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
   setMyFriendStatus();
   changeStatusOnHoverFF();

     function setMyFriendStatus()
     {
  
        var empty = '';
       
         $('.friendStatus').each(function(){
             var txt = $(this).text().trim().replace(/\"/g, "");

             if(txt === empty)
             {
                 $(this).css({"background": "white"});
             }
         });
    }    
   function changeStatusOnHoverFF()
   {
    
    $('.friendStatus').each(function(){
        
        $(this).hover(function(){
         
            var status = $(this).text().trim();
            if(status == 'Friends')
            {
                 
                $(this).text('UnFriend');
                
            }
            
            if(status == "Following")
            {
                $(this).text("Unfollow");
               
            }
            
            if(status == "Follower")
            {
                $(this).text("Friends?");
                
            }
        },function(){
            
            var status = $(this).text().trim();
            if(status == "UnFriend")
            {
                $(this).text("Friends");
                
            }
            
            if(status == "Unfollow")
            {
                $(this).text("Following");
                
            }
            
            if(status == "Friends?")
            {
                $(this).text("Follower");
                
            }
            
        });
    });
}
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