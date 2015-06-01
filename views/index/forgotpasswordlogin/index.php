<html>
    <head>
          <?php ob_start(); ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>enri - Forgot Password</title>
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
        
  
    </head>
    <body bgcolor="#ffffff">
         
        <div id="container">
            <div id="body">
              
                <div id="FORMSHOLDER">
                        <div class="loginHolder">
                            <img src="<?php echo URL ?>pictures/white_enri_logo.png" width="120">
                            <form>
                                <input type="password" name="password" value="" class="passwordInput" id="tempPassword" placeholder="temp password" onkeyup="processforgotPasswordLoginEnter(event, '<?php echo $email ?>')" /><br><br>
                                <input type="password" name="password" value="" class="passwordInput" id="newPassword" placeholder="new password" onkeyup="processforgotPasswordLoginEnter(event, '<?php echo $email ?>')" />
                                
                                <div class ="logIn">
                                    <button id="loginBut" type="button" onclick="processforgotPasswordLogin('<?php echo $email ?>')">send</button>
                                </div>

                                <div class =" SignUp">
                                    <a href=""> </a>
                                </div>

                                 <div id="errLoginMess"></div>
                            </form>
                            
                        </div>
                </div>
            </div>
         
            
            <div class="homeFooder">
                <div class="finalFooter">
                   &copy; ENRI 2015
                   <ul>
                       <li><a href="<?php echo URL ?>aboutus">About</a></li>
                       <li><a href="<?php echo URL ?>terms">Terms</a></li>
                       <li><a href="<?php echo URL ?>policy">policy</a></li>
                       <li><a href="<?php echo URL ?>help">Help</a></li>
                   </ul>
                </div>
            </div>
       </div>

        
       
                     