<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
                 <li id="foodFollow" onclick="onFoodFollowClick('ARTICLE')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_FOOD_SMALL.png);">
                     <span>Foods</span>
                   </li>
                   <li id="cheffollow" onclick="onFollowChefClick('ARTICLE')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_CHEF_SMALL.png);">
                       <span>Chefs</span>
                   </li>
                   <li id="RestFollow" onclick="onFollowRestaurantClick('ARTICLE')" style="list-style-image: url(<?php echo URL; ?>pictures/navigationbar/ENRI_REST_SMALL.png);">
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
    
    <div id="Article_feeds">
        <?php for($looper =0; $looper < count($articles); $looper++){ ?>
            <div class="article">
                 <div class="article_poster_picture"><?php echo $this->checkUserPicture($articles[$looper]['picture'], 100, 100); ?></div>
               <div class="article_holder">
                    <div class="article_poster_name">
                        <?php
                            if($articles[$looper]['Restaurant'] === 'NULL' || $articles[$looper]['Restaurant'] === NULL ){
                                echo '<a href="'.URL.'profile/user/'.$this->encrypt($articles[$looper]['user_id']).'">'.$articles[$looper]['FirstName'].' '.$articles[$looper]['LastName'].'</a>';
                            }else{
                                echo '<a href="'.URL.'profile/user/'.$this->encrypt($articles[$looper]['user_id']).'">'.$articles[$looper]['Restaurant'].'</a>';
                            }
                        ?>
                    </div>
                     <div class="article_post_time"><?php echo $this->timeCounterShort((int)$articles[$looper]['timestamp']);  ?></div>
                     <div class="dimacate"></div>
                    <div class="article_picture"><img src="data:image/jpeg;base64,<?php echo base64_encode($articles[$looper]['article_picture_cover'])?>" width="150" height="100" alt=""></div>
                    <div class="article_title"><?php echo $articles[$looper]['article_title']; ?></div>
                    <div class="article_desc"><?php echo $articles[$looper]['article_desc']; ?>
                        <br><span class="article_ref"><a href="<?php echo $articles[$looper]['article_link'];?> "><?php echo $articles[$looper]['article_link']; ?></a></span>
                    </div>
                    
                    <div class="LCS_bar">
                        <ul>
                            <li><span class="like_link" onclick="gudRead(<?php echo $articles[$looper]['article_id'] ?>, <?php echo $looper ?>)"><img src="<?php echo URL ?>pictures/article/gudRead.png" width="20" title="say its good read"></span><span class="art_like_count" title="<?php echo $this->personpersons($article_likes_counts[$looper]) ?> said this is a good read"><?php echo $this->post_statsSurfix($article_likes_counts[$looper]); ?></span></li>
                            <li><span class="share_link" onclick="shareArticle(<?php echo $articles[$looper]['article_id'] ?>, <?php echo $looper ?>)"><img src="<?php echo URL ?>pictures/article/share.png" width="20" title="share this aticle"></span><span class="art_share_count" title="<?php echo $this->personpersons($article_share_counts[$looper]) ?> shared this article"><?php echo $this->post_statsSurfix($article_share_counts[$looper]); ?></span></li>
                            <li></li>
                        </ul>
                    </div>
                     </div>
                 <div class="commments_holder">
                      <div class="commentCounter">- - - - - - - - - - - - - - - - - - - - - <span onclick="showAllcomments('<?php echo $articles[$looper]['article_id'] ?>', '<?php echo $looper ?>')"><?php echo $this->getuserCommentCountSuffix(count($article_comments[$looper])) ?></span> - - - - - - - - - - - - - - - - - - - - - </div>
                        <div class="user_comments_holder">
                          <?php if (count($article_comments[$looper]) >= THREE){?>
                                <?php $name = ''; for($loop = 0; $loop < THREE; $loop++){
                                 if($article_comments[$looper][$loop]['Restaurant'] === 'NULL' || $article_comments[$looper][$loop]['Restaurant'] === NULL ){
                                        $name = '<a href="'.URL.'profile/user/'.$this->encrypt($article_comments[$looper][$loop]['user_id']).'">'.$article_comments[$looper][$loop]['FirstName'].' '.$article_comments[$looper][$loop]['LastName'].'</a>';
                                    }else{
                                       $name = '<a href="'.URL.'profile/user/'.$this->encrypt($article_comments[$looper][$loop]['user_id']).'">'.$article_comments[$looper][$loop]['Restaurant'].'</a>';
                                    }
                                ?><div class="user_photo"><?php echo $this->checkUserPicture($article_comments[$looper][$loop]['picture'], 35, 35) ?></div>
                                    <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($article_comments[$looper][$loop]['user_id'])?>"><?php echo $name ?></a></b></div> <div class="postTime"><?php echo $this->timeCounterNotif($article_comments[$looper][$loop]['time']); ?></div>
                                    <div class="user_comment">
                                      <?php echo $article_comments[$looper][$loop]['comment']; ?>
                                    </div>

                            <?php }
                                }else{
                             ?>
                                        <?php $name = ''; for($loop = 0; $loop < count($article_comments[$looper]); $loop++){
                                        if($article_comments[$looper][$loop]['Restaurant'] === 'NULL' || $article_comments[$looper][$loop]['Restaurant'] === NULL ){
                                               $name = '<a href="'.URL.'profile/user/'.$this->encrypt($article_comments[$looper][$loop]['user_id']).'">'.$article_comments[$looper][$loop]['FirstName'].' '.$article_comments[$looper][$loop]['LastName'].'</a>';
                                           }else{
                                              $name = '<a href="'.URL.'profile/user/'.$this->encrypt($article_comments[$looper][$loop]['user_id']).'">'.$article_comments[$looper][$loop]['Restaurant'].'</a>';
                                           }
                                       ?><div class="user_photo"><?php echo $this->checkUserPicture($article_comments[$looper][$loop]['picture'], 35, 35) ?></div>
                                              <div class="user_name"><b><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($article_comments[$looper][$loop]['user_id'])?>"><?php echo $name ?></a></b></div> <div class="postTime"><?php echo $this->timeCounterNotif($article_comments[$looper][$loop]['time']); ?></div>
                                              <div class="user_comment">
                                                <?php echo $article_comments[$looper][$loop]['comment']; ?>
                                              </div>
                                      <?php }?>
                             <?php
                                }
                              ?>
                      
                        </div> 
                     <div class="post_comments_box_profile_photo"><?php echo $this->checkUserPicture($userDetails[ZERO]['picture'], 35, 35)?></div>
                     <div class="post_comments_box"  contenteditable="true" tabindex="1" onkeyup="sendUserRecookComment('<?php echo $articles[$looper]['article_id'] ?>', event, '<?php echo $articles[$looper]['user_id'] ?>', '<?php echo $looper ?>')">
                         <p>Leave a comment</p>
                    </div>
                 </div>
            </div>
        <?php } ?>
    </div>
</div>