<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="SocialChef - Social Recipe HTML Template" />
	<meta name="description" content="SocialChef - Social Recipe HTML Template">
	<meta name="author" content="themeenergy.com">
       <script type="text/javascript" src="<?php echo URL ?>views/default.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/sideBar.js"></script>
            
          <script type="text/javascript" src="<?php echo URL ?>views/search/js/search.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/notification/js/notification.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post_image.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_makeRecipe.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_pwi.js"></script>
          
	
	<title>Foodsuss - View recipe</title>
   
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
			<a href="index.html" title="Foodsuss" class="logo"><img src="images/ico/logo.png" alt="SocialChef logo" /></a>
                       	<nav class="main-nav" role="navigation" id="menu">
				<ul>
					<li><a href="index.html" title="Home"><span>Home</span></a></li>
                                        <li><a href="contact.html" title="Contact"><span>Profile</span></a></li>
					<li><a href="recipes.html" title="Recipes"><span>Foodsuss</span></a></li>
					<li><a href="blog.html" title="Blog"><span>Post Recipe</span></a></li>
					
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
                                 <img src='images/ENRI_SETTINGS.png' width='20' height='20' onclick="hideShowSettings()" title="settings">
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
                            
                                    <div  onclick="OnOff(), getNotification()"><img src="images/ENRI_NOTIF_APPLE.png" width="20" height="20" title="notification"></div>
                             
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
					<h1>Recipe Name</h1>
				</header>
				<!--content-->
				<section class="content three-fourth">
					<!--recipe-->
						<div class="recipe">
							<div class="row">
								<!--two-third-->
								<article class="two-third wow fadeInLeft">
									<div class="image"><a href="#"><img src="images/img.jpg" alt="" /></a></div>
									<div class="intro"><p><strong>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas</strong></p> <p>Molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.</p></div>
									<div class="instructions">
										<ol>
											<li>Heat oven to 160C/140C fan/gas 3 and line a 12-hole muffin tin with cases. Gently melt the butter, chocolate, sugar and 100ml hot water together in a large saucepan, stirring occasionally, then set aside to cool a little while you weigh the other ingredients.</li>
											<li>Stir the eggs and vanilla into the chocolate mixture. Put the flour into a large mixing bowl, then stir in the chocolate mixture until smooth. Spoon into cases until just over three-quarters full (you may have a little mixture leftover), then set aside for 5 mins before putting on a low shelf in the oven and baking for 20-22 mins. Leave to cool.</li>
											<li>For the icing, melt the chocolate in a heatproof bowl over a pan of barely simmering water. Once melted, turn off the heat, stir in the double cream and sift in the icing sugar. When spreadable, top each cake with some and decorate with your favourite sprinkles and sweets.</li>
										</ol>
									</div>
								</article>
								<!--//two-third-->
								
								<!--one-third-->
								<article class="one-third wow fadeInDown">
									<dl class="basic">
										<dt>Preparation time</dt>
										<dd>15 mins</dd>
										<dt>Cooking time</dt>
										<dd>30 mins</dd>
										<dt>Difficulty</dt>
										<dd>easy</dd>
										<dt>Serves</dt>
										<dd>4 people</dd>
									</dl>
									
									<dl class="user">
										<dt>Category</dt>
										<dd>Deserts</dd>
										<dt>Posted by</dt>
										<dd>Jennifer W.</dd>
									</dl>
									
									<dl class="ingredients">
										<dt>300g</dt>
										<dd>Self-raising flour</dd>
										<dt>200g</dt>
										<dd>Butter</dd>
										<dt>200g</dt>
										<dd>Plain chocolate</dd>
										<dt>2</dt>
										<dd>Eggs</dd>
										<dt>1 tbsp</dt>
										<dd>Vanilla extract</dd>
										<dt>200 g</dt>
										<dd>Brown sugar</dd>
										<dt>100 ml</dt>
										<dd>Double cream</dd>
										<dt>handful</dt>
										<dd>Sprinkles</dd>
									</dl>
								</article>
								<!--//one-third-->
							</div>
						</div>
						<!--//recipe-->
							
						<!--comments-->
						<div class="comments wow fadeInUp" id="comments">
							<h2>5 comments </h2>
							<ol class="comment-list">
								<!--comment-->
								<li class="comment depth-1">
									<div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong>Kimberly C.</strong> said 1 month ago <a href="#" class="comment-reply-link"> Reply</a>
										</div>
										<div class="comment-text">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
										</div>
									</div> 
								</li>
								<!--//comment-->
								
								<!--comment-->
								<li class="comment depth-1">
									<div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong>Alex J.</strong> said 1 month ago <a href="#" class="comment-reply-link"> Reply</a>
										</div>
										<div class="comment-text">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
										</div>
									</div> 
								</li>
								<!--//comment-->
								
								<!--comment-->
								<li class="comment depth-2">
									<div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong>Kimberly C.</strong> said 1 month ago <a href="#" class="comment-reply-link"> Reply</a>
										</div>
										<div class="comment-text">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
										</div>
									</div> 
								</li>
								<!--//comment-->
								
								<!--comment-->
								<li class="comment depth-3">
									<div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong>Alex J.</strong> said 1 month ago <a href="#" class="comment-reply-link"> Reply</a>
										</div>
										<div class="comment-text">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
										</div>
									</div> 
								</li>
								<!--//comment-->
								
								<!--comment-->
								<li class="comment depth-1">
									<div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /></a></div>
									<div class="comment-box">
										<div class="comment-author meta"> 
											<strong>Denise M.</strong> said 1 month ago <a href="#" class="comment-reply-link"> Reply</a>
										</div>
										<div class="comment-text">
											<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation.</p>
										</div>
									</div> 
								</li>
								<!--//comment-->
							</ol>
						</div>
						<!--//comments-->
						
						<!--respond-->
						<div class="comment-respond wow fadeInUp" id="respond">
							<h2>Leave a reply</h2>
							<div class="container">
								<p><strong>Note:</strong> Comments on the web site reflect the views of their authors, and not necessarily the views of the socialchef internet portal. Requested to refrain from insults, swearing and vulgar expression. We reserve the right to delete any comment without notice explanations.</p>
								<p>Your email address will not be published. Required fields are signed with <span class="req">*</span></p>
								<form>
									<div class="f-row">
										<div class="third">
											<input type="text" placeholder="Your name" />
											<span class="req">*</span>
										</div>
										
										<div class="third">
											<input type="email" placeholder="Your email" />
											<span class="req">*</span>
										</div>
										
										<div class="third">
											<input type="text" placeholder="Your website" />
										</div>
									
									</div>
									<div class="f-row">
										<textarea></textarea>
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
										<div class="f-row checkbox">
											<input type="checkbox" id="ch2" />
											<label for="ch2">Notify me of new articles by email.</label>
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
						<h3>Nutrition facts <span>(per serving)</span></h3>
						<table>
							<tr>
								<td>Calories </td>
								<td>505</td>
							</tr>
							<tr>
								<td>Protein</td>
								<td>59g</td>
							</tr>
							<tr>
								<td>Carbs</td>
								<td>59g</td>
							</tr>
							<tr>
								<td>Fat</td>
								<td>29g</td>
							</tr>
							<tr>
								<td>Saturates</td>
								<td>17g</td>
							</tr>
							<tr>
								<td>Fibre</td>
								<td>2g</td>
							</tr>
							<tr>
								<td>Sugar</td>
								<td>44g</td>
							</tr>
							<tr>
								<td>Salt</td>
								<td>0.51g</td>
							</tr>
						</table>
					</div>
					
					<div class="widget share">
						<ul class="boxed">
							<li class="light"><a href="#" title="Facebook"><i class="ico i-facebook"></i> <span>Share on Facebook</span></a></li>
							<li class="medium"><a href="#" title="Twitter"><i class="ico i-twitter"></i> <span>Share on Twitter</span></a></li>
							<li class="dark"><a href="#" title="Favourites"><i class="ico i-favourites"></i> <span>Add to Favourites</span></a></li>
						</ul>
					</div>
					
					<div class="widget members">
						<h3>Members who liked this recipe</h3>
						<ul class="boxed">
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Kimberly C.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Alex J.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Denise M.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Jason H.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Jennifer W.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Anabelle Q.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Thomas M.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Michelle S.</span></a></div></li>
							<li><div class="avatar"><a href="my_profile.html"><img src="images/avatar.jpg" alt="" /><span>Bryan A.</span></a></div></li>
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
	<footer class="foot" role="contentinfo">
		<div class="wrap clearfix">
			<div class="row">
				<article class="one-half">
					<h5>About SocialChef Community</h5>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci.</p>
				</article>
				<article class="one-fourth">
					<h5>Need help?</h5>
					<p>Contact us via phone or email</p>
					<p><em>T:</em>  +1 555 555 555<br /><em>E:</em>  <a href="#">socialchef@email.com</a></p>
				</article>
				<article class="one-fourth">
					<h5>Follow us</h5>
					<ul class="social">
						<li class="facebook"><a href="#" title="facebook">facebook</a></li>
						<li class="youtube"><a href="#" title="youtube">youtube</a></li>
						<li class="rss"><a href="#" title="rss">rss</a></li>
						<li class="gplus"><a href="#" title="gplus">google plus</a></li>
						<li class="linkedin"><a href="#" title="linkedin">linkedin</a></li>
						<li class="twitter"><a href="#" title="twitter">twitter</a></li>
						<li class="pinterest"><a href="#" title="pinterest">pinterest</a></li>
						<li class="vimeo"><a href="#" title="vimeo">vimeo</a></li>
					</ul>
				</article>
				
				<div class="bottom">
					<p class="copy">Copyright 2014 SocialChef. All rights reserved</p>
					
					<nav class="foot-nav">
						<ul>
							<li><a href="index.html" title="Home">Home</a></li>
							<li><a href="recipes.html" title="Recipes">Recipes</a></li>
							<li><a href="blog.html" title="Blog">Blog</a></li>
							<li><a href="contact.html" title="Contact">Contact</a></li>    
							<li><a href="find_recipe.html" title="Search for recipes">Search for recipes</a></li>
							<li><a href="login.html" title="Login">Login</a></li>	<li><a href="register.html" title="Register">Register</a></li>													
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</footer>
	<!--//footer-->
	
	<!--preloader-->
	<div class="preloader">
		<div class="spinner"></div>
	</div>
	<!--//preloader-->
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/jquery.uniform.min.js"></script>
	<script src="js/wow.min.js"></script>
	<script src="js/jquery.slicknav.min.js"></script>
	<script src="js/scripts.js"></script>
	<script>new WOW().init();</script>
</body>
</html>


