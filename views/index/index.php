<html>
    <head>
          <?php ob_start(); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Welcome to enri - Global Food Platform</title>
         <script>var JURL = '<?php echo URL ?>';</script>
         <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
         <link rel="stylesheet" href="<?php echo URL ?>views/css/index/firstSheet.css" type="text/css" media="screen">
       
         <link rel="stylesheet" href="<?php echo URL ?>views/css/foodfinder/countries.css">
         <link rel="stylesheet" href="<?php echo URL ?>views/css/foodfinder/loadCountries.css">
         <link rel="stylesheet" href="<?php echo URL ?>views/default.css">
         <link rel="stylesheet" href="<?php echo URL ?>views/css/index/forgotpasswordsheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/index/verificationsheet.css">
         <link rel="stylesheet" href="<?php echo URL ?>css/firstSheet.css" type="text/css" media="screen">
        
        
        <script src="<?php echo URL.View?>index/js/raphael_2.0.2.js" type="text/javascript"></script>
        <script src="<?php echo URL.View?>index/js/world_1.js" type="text/javascript"></script>
        <script src="<?php echo URL.View?>index/js/mapView.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.9.1.js"></script>
        <script src="<?php echo URL.''.View ?>index/indexJs.js" type="text/javascript"></script>
           <script src="<?php echo URL.View?>index/js/forgotpassword.js" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo URL ?>FooterandHeader/footerSheet.css" type="text/css" media="screen">
        <link rel="stylesheet" href="<?php echo URL ?>views/css/index/indexHeaderFormsheet.css" type="text/css" media="screen">
     
         <script>
          
           (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
           (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','http://google-analytics.com/analytics.js','ga');

            ga('create', 'UA-57721120-1', 'auto');
            ga('send', 'pageview');
            
        </script>
  
    </head>
    <body bgcolor="#ECECEC">
         
        <div id="container" >
            <header>
                <div id='logo'>
                    
                    <img src="<?php echo URL ?>pictures/enri_logo_trans.png" alt="" width="120" style="position: relative; top: 5px;">
               
                    <div id="BETA">BETA</div>
                </div>
            </header>
            <div id="body">
                     <div class="slogan"><h1>Final Destination For Everything Food and</h1></div>
                <div class="slogan-two"><h1>Connect Foodies Around The World</h1></div>
                <div id="map" >
                    <script> 
                    window.onload = function () {
                                  var current = null;
                                        var map = {}; //instance of map							
                                        var svgHeight = 450;
                                        var svgWidth = 1900;
                                        var R = Raphael("body" ,"1200", "700");

                                        R.setViewBox(0, 0, svgWidth, svgHeight, true);
                                        displayMap(R,map);
                                };//end of for
                    </script> 
                </div>
                <div id="FORMSHOLDER">
                        <div class="loginHolder">
                            <div id="LoginText">Login</div>
                            <form>
                                <input type="text" name="email" value="" class="usernamInput" placeholder="Email" onkeyup="processLoginEnter(event)" /><br><br>
                                <input type="password" name="password" value="" class="passwordInput" placeholder="Password" onkeyup="processLoginEnter(event)" />

                                
                                <div class ="logIn">
                                    <button id="loginBut" type="button" onclick="processLogin()">Login</button>
                                </div>

                                <div class =" SignUp">
                                    <a href=""> </a>
                                </div>
                            </form>
                            
                            <div class="creatAcc" onclick="signupLogingSwhitch('SIGNUP')">Create an account <span> | </span></div>
                            <div class= "forgetPw">
                                    <a onclick="showForgotPasswordDialog()" class="fgw">  Forgot Password</a>
                            </div>
                                <div id="errLoginMess"></div>
                        </div>
                </div>
            </div>
           
            <div id="slideshow">
                <div>
                    <ul>
                        <li><img src="<?php echo URL ?>pictures/index/connect_t.png" height="100"><div class="Con_text">Connect with foodies all around the world and discover how other cultures eat the food you love</div></li>
                        <li><img src="<?php echo URL ?>pictures/index/create_t.png" height="100"><div class="Con_text">Create your own cookbook on enri and share with others to build your followers</div></li>
                        <li><img src="<?php echo URL ?>pictures/index/discover_t.png" height="100"><div class="Con_text">Discover new recipes by following cook instructions posted by other foodies.</div></li>
                    </ul>
                </div>
                 <div>
                    <ul>
                        <li><img src="<?php echo URL ?>pictures/index/trends_t.png" height="100"><div class="Con_text">Update of what is going on in the global food industry. Latest trend in cooking and food instructions</div></li>
                        <li><img src="<?php echo URL ?>pictures/index/videocooking_t.png" height="100"><div class="Con_text">Coming soon! live video chat feature. Cookwith your favourite chef and others on enri.</div></li>
                        <li><img src="<?php echo URL ?>pictures/index/sharephoto_t.png" height="100"><div class="Con_text">Adding your favourite food/recipe pictures or videos. Sign Up today and start connecting other foodies</div></li>                        
                    </ul>
                </div>
                
                
            </div>
          
            
            <div class="homeFooder">
                <span>&copy; ENRI 2015</span>
                   <ul>
                       <li><a href="<?php echo URL ?>aboutus">About</a></li>
                       <li><a href="<?php echo URL ?>terms">Terms</a></li>
                       <li><a href="<?php echo URL ?>policy">Policy</a></li>
                       <li><a href="<?php echo URL ?>help">Help</a></li>
                   </ul>
                </div>
       </div>
 
         
