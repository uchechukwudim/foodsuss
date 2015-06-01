<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
   <head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="keywords" content="Foodsuss - Browse and discover Food" />
	<meta name="description" content="Foodsuus - Browse and discover Food, Social networking platform">
	<meta name="author" content="foodsuss.com">
	   <script>
          /*
           (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
           (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://google-analytics.com/analytics.js','ga');

            ga('create', 'UA-57721120-1', 'auto');
            ga('send', 'pageview');
            */
        </script>
	<title>Foodsuss</title>
	
	
       <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/default.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/sideBar.js"></script>
            
          <script type="text/javascript" src="<?php echo URL ?>views/search/js/search.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/notification/js/notification.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post_image.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_makeRecipe.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_pwi.js"></script>
          
   
          <link rel="stylesheet" href="<?php echo URL ?>views/default.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/home/new/style.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/imageDialog.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/search/new/searchsheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/noitification/new/notificationsheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/cooksheet.css"> 
          <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/cookoptionsDialogBox.css">
	<link rel="stylesheet" href="css/animate.css" />
	<!--<link href="http://fonts.googleapis.com/css?family=Raleway:400,300,500,600,700,800" rel="stylesheet"> -->
	<link rel="shortcut icon" href="<?php echo URL ?>pictures/favicon3.png" />
	
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
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
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
    </body>
</html>