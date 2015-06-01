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
<body>
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
			<!--breadcrumbs-->
			
			<!--//breadcrumbs-->
			
			<!--row-->
			<div class="row" >
				<header class="s-title">
					<h1>Add a new recipe</h1>
				</header>
					
				<!--content-->
                                <section class="content full-width wow fadeInUp" style="margin-top: -30px;margin-bottom: 40px;-webkit-box-shadow:0 1px 7px rgba(0,0,0,.2);-moz-box-shadow:0 1px 7px rgba(0,0,0,.2);box-shadow:0 1px 7px rgba(0,0,0,.2);">
					<div class="submit_recipe containerr" >
						<form>
							<section >
								
								<p>All fields are required (Except step photo)</p>
								<div class="f-row">
									<div class="full"><input type="text" placeholder="Recipe title" /></div>
								</div>
								<div class="f-row">
									<div class="third"><input type="text" placeholder="Preparation time e.g 10min" /></div>
									<div class="third"><input type="text" placeholder="Cooking time e.g 10 min" /></div>
									<div class="third"><input type="text" placeholder="Recipe Base Food" /></div>
								</div>
								<div class="f-row">
									<div class="third"><input type="text" placeholder="Recipe Country Origin" /></div>
									<div class="third">
                                                                            <select>
                                                                                <option selected="selected">Select Meal Type</option>
                                                                                <option>BreakFast</option>
                                                                                <option>Launch</option>
                                                                                <option>Dinner</option>
                                                                                <option>Drink</option>
                                                                                <option>Dessert</option>
                                                                                <option>BreakFast or Lunch</option>
                                                                                <option>Lunch or Dinner</option>
                                                                                <option>BreakFast or Dinner</option>
                                                                            </select>
                                                                        </div>
								</div>
							</section>
							
							<section>
								<h2>Description</h2>
								<div class="f-row">
									<div class="full"><textarea placeholder="Recipe title"></textarea></div>
								</div>
							</section>	
							
							<section>
								<h2>Ingredients</h2>
								<div class="f-row ingredient">
									<div class="large ingredient"><input type="text" placeholder="Ingredient" /></div>
									<div class="small ingQuan"><input type="text" placeholder="Quantity" /></div>
									<button class="remove">-</button>
								</div>
								<div class="f-row full">
									<button class="add">Add an ingredient</button>
								</div>
							</section>	
                                                    
                                                        <section>
								<h2>Nutrient Facts</h2>
								<div class="f-row ingredient">
									<div class="large nutrientText"><input type="text" placeholder="Nutrient" /></div>
									<div class="small nutQuan"><input type="text" placeholder="Quantity" /></div>
									<button class="remove">-</button>
								</div>
								<div class="f-row full">
									<button class="add">Add an ingredient</button>
								</div>
							</section>	
							
							<section>
								<h2>Instructions <span>(enter instructions, each step at a time)</span></h2>
								<div class="f-row instruction">
									<div class="full"><input type="text" placeholder="Instructions" /></div>
									<button class="remove">-</button>
								</div>
								<div class="f-row full">
									<button class="add">Add a step</button><button class="addphoto" style="position: relative; left: 40px;">Add step photo</button>
								</div>
                                                                
                                                                
							</section>
							
							<section>
								<h2>Finished Recipe Photo</h2>
								<div class="f-row full">
									<input type="file" />
								</div>
							</section>	
							
							
							<div class="f-row full">
								<input type="submit" class="button" id="submitRecipe" value="Post Recipe" />
							</div>
						</form>
					</div>
				</section>
				<!--//content-->
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


