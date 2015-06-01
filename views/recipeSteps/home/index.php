<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="SocialChef - Social Recipe HTML Template" />
	<meta name="description" content="SocialChef - Social Recipe HTML Template">
	<meta name="author" content="themeenergy.com">
        
          <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/default.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/sideBar.js"></script>
            
          <script type="text/javascript" src="<?php echo URL ?>views/search/js/search.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/notification/js/notification.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post_image.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_makeRecipe.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_pwi.js"></script>
          
        <?php 
           if(isset($this->css))
            {
                foreach ($this->css as $css) {
                    echo '<link rel="stylesheet" href="'.URL.View.$css.'">';
                    
                }
            }
          //import javascript files dynamically for all pages
            if(isset($this->js))
            {
                foreach ($this->js as $js) {
                    echo '<script type="text/javascript" src="'.URL.View.$js.'"></script>';
                }
            }
           
          ?>
          
	
	<title>Foodsuss - Post a recipe</title>
   
           <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/new/style.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/new/searchsheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/new/notificationsheet.css">
           <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/new/settingssheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/cooksheet.css"> 
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/cookoptionsDialogBox.css">
	<link rel="stylesheet" href="css/animate.css" />    
	<link rel="shortcut icon" href="<?php echo URL ?>pictures/favicon3.png" />
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
        
        <script type="text/javascript">
             var ADDRESS ='';
             var map;
             var geocoder;
             var mapp;
             var JURL = "<?php echo URL ?>";
             var FIELD_MAX = 10;
             var STEPS_MAX = 20;
             var FIELDCOUNTER = 1;
             var STEPSCOUNTER = 1;
             var EMPTY = "";
             getNotificatioinCount();
           </script>
</head>
<body class="recipePage">
	<!--header-->
	<header class="head" role="banner">
		<!--wrap-->
		<div class="wrapp clearfix">
			<a href="index.html" title="Foodsuss" class="logo"><img src="<?php echo URL ?>pictures/foodsussLogo.png" alt="SocialChef logo" /></a>
                       	<nav class="main-nav" role="navigation" id="menu">
				<ul>
					<li><a href="<?php echo URL ?>home" title="Home"><span>Home</span></a></li>
                                        <li><a href="<?php echo URL ?>profile" title="Profile"><span>Profile</span></a></li>
					<li><a href="<?php echo URL ?>foodfinder" title="Food Finder"><span>FoodFinder</span></a></li>
					<li><a href="<?php echo URL ?>MakeRecipe" title="Post a Recipe"><span>Post Recipe</span></a></li>
					
				</ul>
			</nav>
                        
                        <div id='searcher'>
                            <span id='sr'></span> <input type="text" name="search"  id="search">
                            <div id="searchResult" title="">
                                <ul id="searchChoices">
                                    <li onclick="getWhatTosearchFor('RECIPE')"><img src="<?php echo URL ?>pictures/search/ENRI_RECIPE.png" width="30" height="30"><span>Recipe</span></li>
                                    <li onclick="getWhatTosearchFor('FOOD')"><img src="<?php echo URL ?>pictures/search/ENRI_FOOD.png" width="30" height="30"><span>Food</span></li>
                                    <li onclick="getWhatTosearchFor('PRODUCTS')"><img src="<?php echo URL ?>pictures/search/ENRI_PRODUCT_ICONS.png" width="30" height="30"><span>Products</span></li>
                                    <li onclick="getWhatTosearchFor('FOODIES')"><img src="<?php echo URL ?>pictures/search/ENRI_friends_follow.png" width="30" height="30"><span>Foodies</span></li>
                                    <li onclick="getWhatTosearchFor('CHEFS')"><img src="<?php echo URL ?>pictures/search/ENRI_CHEF.png" width="30" height="30"><span>Chefs</span></li>
                                    <li onclick="getWhatTosearchFor('RESTAURANTS')"><img src="<?php echo URL ?>pictures/search/ENRI_REST.png" width="30" height="30"><span>Restaurants</span></li>
                                </ul>
                            </div>
                         </div>
		
                           <ul id='Navsetting'>
                             <li >
                                 <img src='<?php echo URL ?>pictures/ENRI_SETTINGS.png' width='20' height='20' onclick="hideShowSettings()" title="settings">
                                 <span></span>
                                 <ul>
                                     <li onclick="off()"><a href="<?php echo URL ?>settings">Settings</a></li>
                                     <li onclick="off()"><a href="<?php echo URL ?>help">Help</a></li>
                                     <li onclick="off()"><a href="<?php echo URL ?>index/logout">Logout</a></li>
                                 </ul>
                             </li>
                        </ul>
	
                         <div id="notification">
                                <span id="notifAlertCircle"></span>
                                
                                <div id="apple" onclick="OnOff(), getNotification()"><img src="<?php echo URL ?>pictures/ENRI_NOTIF_APPLE.png" width="20" height="20" title="notification"></div>
                             
                                <span class="notifSpan"></span>
                                <div id="notificationResult">
                                      <div id="NotificationHeasder">Notification</div>
                                      <div id="notifResultHolder"></div>
                               </div>
                        </div>
                
                     
		</div>
	</header>
	<!--//header-->
		
	<!--main-->
	<main class="main" role="main">
		<!--wrap-->
		<div class="wrap clearfix">
			<!--row-->
			<div class="row">
				<header class="s-title wow fadeInLeft">
					<h1><?php echo $recipeName ?></h1>
				</header>
				<!--content-->
				<section class="content three-fourth">
					<!--recipe-->
						<div class="recipe">
							<div class="row">
								<!--two-third-->
								<article class="two-third wow fadeInLeft">
									<div class="image"><img src="data:image/jpeg;base64,<?php echo base64_encode($recipe[0]['recipe_photo'])?>" alt="" /></div>
									<div class="intro"><p><?php echo $recipe[0]['description']; ?></p></div>
									<div class="instructions">
										<ol>
                                                                                    <?php for($looper = 0; $looper < count($recipePost_steps_with_images); $looper++){ ?>
                                                                                    <li><img src="data:image/jpeg;base64,<?php echo base64_encode($recipePost_steps_with_images[$looper]['recipe_image'])?>" alt="">Heat oven to 160C/140C fan/gas 3 and line a 12-hole muffin tin with cases. Gently melt the butter, chocolate, sugar and 100ml hot water together in a large saucepan, stirring occasionally, then set aside to cool a little while you weigh the other ingredients.</li>
                                                                                    <?php } ?>
										</ol>
									</div>
								</article>
								<!--//two-third-->
								
								<!--one-third-->
								<article class="one-third wow fadeInDown">
									<dl class="basic">
										<dt>Preparation time</dt>
										<dd><?php echo $recipe[0]['preparation_time'] ?></dd>
										<dt>Cooking</dt>
										<dd><?php echo $recipe[0]['cooking_time'] ?></dd>
									</dl>
									
									<dl class="user">
										<dt>Category</dt>
                                                                                <dd title="<?php echo $recipe[0]['meal_type'] ?>"><?php echo $recipe[0]['meal_type'] ?></dd>
									</dl>
									
									<dl class="ingredients">
                                                                            <?php for($looper =0; $looper < count($ingredients); $looper++){ ?>
										<dt><?php echo $ingredients[$looper]['ingredient_Qty'] ?></dt>
                                                                                <dd><?php echo $ingredients[$looper]['ingredients_name'] ?></dd>
                                                                            <?php } ?>
									</dl>
								</article>
								<!--//one-third-->
							</div>
						</div>
						<!--//recipe-->
							
						<!--comments-->
						<div class="comments wow fadeInUp" id="comments">
							<h2><?php echo $this->getuserRecookCommentCountSuffix(count($userComments)) ?>  </h2>
							<ol class="comment-list">
								
							   <?php for($loop = 0; $loop < count($userComments); $loop++){ ?>	
								<!--comment-->
								<li class="comment depth-1">
									<div class="avatar"><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($userComments[$loop]['user_id'])?>"><img src="data:image/jpeg;base64,<?php echo base64_encode($userComments[$loop]['image'])?>" width="90" height="90" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong><?php echo $userComments[$loop]['userName'] ?></strong> <?php $this->timeCounterShort($userComments[$loop]['time']); ?>
										</div>
										<div class="comment-text">
											<p><?php echo $userComments[$loop]['comments'] ?></p>
										</div>
									</div> 
								</li>
								<!--//comment-->
                                                           <?php } ?>
							</ol>
						</div>
						<!--//comments-->
						
						<!--respond-->
						<div class="comment-respond wow fadeInUp" id="respond">
							
							<div class="container" style="margin-top: 15px;" >
                                                            <form style="margin-top: 5px;">
									<div class="f-row">
										<textarea  class="post_comments_boxs" onkeyup="sendUserRecookComment('<?php echo $recipe[0]['recipe_post_id'] ?>', event, '<?php echo $recipe[0]['user_id'] ?>', '<?php echo $recipe[0]['food_id'] ?>', '<?php echo $recipe[0]['country_id'] ?>')" ></textarea>
									</div>
									
									<div class="f-row">
										<div class="third bwrap">
											<input type="submit" value="Submit comment" />
										</div>
									</div>
									
									<div class="bottom">
										<div class="f-row checkbox">
											<input type="checkbox" id="ch1" />
											<label for="ch1">Notify me of replies to my comment via e-mail</label>
										</div>
									
									</div>
								</form>
							</div>
						</div>
						<!--//respond-->
				</section>
				<!--//content-->
				
				<!--right sidebar-->
				<aside class="sidebar one-fourth wow fadeInRight">
					<div class="widget nutrition">
                                            <?php if(count($nutrition) === ZERO){
                                                ?>
                                                        <h3>No Nutrition facts <span>(per serving)</span></h3>
                                                <?php
                                            }else{
                                                ?>
                                                    <h3>Nutrition facts <span>(per serving)</span></h3>
                                                    <table>
                                                        <?php for($looper =0; $looper < count($nutrition); $looper++){ ?>
                                                            <tr>
                                                                    <td><?php echo $nutrition[$looper]['Nutrition_name'] ?> </td>
                                                                    <td><?php echo $nutrition[$looper]['Nutrition_Qty'] ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                     </table>
                                                <?php
                                            }?>
					</div>
					
					<div class="widget share">
						<ul class="boxed">
							<li class="light"><a href="#" title="say this recipe is tasty"><i class="ico i-facebook"></i> <span>Tasty</span></a></li>
							<li class="medium"><a href="#" title="say you've cooked this recipe"><i class="ico i-twitter"></i> <span>Cook</span></a></li>
							<li class="dark"><a href="#" title="share this recipe"><i class="ico i-favourites"></i> <span>Share</span></a></li>
						</ul>
					</div>
					
                                    <div class="widget members" style="padding-bottom: 10px;">
						<h3>people who cooked this recipe</h3>
						<ul class="boxed">
                                                    <?php for($looper = 0; $looper < count($cookedItUsers); $looper++){ ?>
                                                    <li><div class="avatar"><a href="<?php echo URL ?>profile/user/<?php echo $this->encrypt($cookedItUsers[$looper]['sharer_user_id']) ?>"><img src="data:image/jpeg;base64,<?php echo  base64_encode($cookedItUsers[$looper]['picture']); ?>" width="90" height="90" alt="" /><span><?php echo  $cookedItUsers[$looper]['name']; ?></span></a></div></li>
                                                    <?php } ?>
						</ul>
					</div>
				</aside>
				<!--//right sidebar-->
			</div>
			<!--//row-->
		</div>
		<!--//wrap-->
	</main>
	<!--//main-->
	
		
	<!--footer-->
        <footer class="foot" role="contentinfo" style="margin-top: 50px;">
		<div class="wrap clearfix">
			<div class="row">
				
					<p class="copy">Copyright 2015 Foodsuss. All rights reserved</p>
					
					<nav class="foot-nav">
						<ul>
                                                    <li style="list-style: none;"><a href="index.html" title="Home">About</a></li>
							<li style="list-style: none;"><a href="recipes.html" title="Recipes">Terms</a></li>
							<li style="list-style: none;"><a href="blog.html" title="Blog">Policies</a></li>
							<li style="list-style: none;"><a href="contact.html" title="Contact">Help</a></li> 												
						</ul>
					</nav>
			
			</div>
		</div>
	</footer>
	<!--//footer-->
	
	<!--preloader-->
	<div class="preloader">
		<div class="spinner"></div>
	</div>
	<!--//preloader-->
	
	<script src="<?php echo URL ?>views/cook/js/new/jquery-1.11.1.min.js"></script>
	<script src="<?php echo URL ?>views/cook/js/new/jquery.uniform.min.js"></script>
	<script src="<?php echo URL ?>views/cook/js/new/wow.min.js"></script>
	<script src="<?php echo URL ?>views/cook/js/new/jquery.slicknav.min.js"></script>
	<script src="<?php echo URL ?>views/cook/js/new/scripts.js"></script>
	<script>new WOW().init();</script>
</body>
</html>


