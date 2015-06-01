<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
          
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="http://localhost/css/firstSheet.css" type="text/css" media="screen">
        <script src="<?php echo URL.View?>index/js/raphael_2.0.2.js" type="text/javascript"></script>
        <script src="<?php echo URL.View?>index/js/world_1.js" type="text/javascript"></script>
        <script src="<?php echo URL.View?>index/js/mapView.js" type="text/javascript"></script>
         <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.9.1.js"></script>
         <script src="<?php echo URL.''.View ?>index/indexJs.js" type="text/javascript"></script>
          <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.9.1.js"></script>
    
         <link rel="stylesheet" href="http://localhost/FooterandHeader/headerSheet.css" type="text/css" media="screen">
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
           
        <title></title>
    </head>
    <body bgcolor="#fcfcfc">
        <div id="header">
                    <h3 class="h1">Welcome To</h3>
                    <h1 class= "enri"><a href="http://localhost/php/" class="en">ENRI</a></h1>
                    <h3 class="h2">Find out what is happening with the food you love all around the world.</h3>

                  
                        <form action ="<?php echo URL ?>index/processLogon"method="POST">
                            <div class ="username">Username
                            </div>
                            <input type="text" name="email" value="" class="usernamInput" />

                            <div class ="password">Password</div>
                            <input type="password" name="password" value="" class="passwordInput"/>

                            <div class= "forgetPw">
                                <a href="" class="fgw">Forget Your Password?</a>
                            </div>
                            <div class ="logIn">
                                <button onclick="">Log In</button>
                            </div>
                            <div class =" SignUp">
                                <a href=""> SignUp</a>
                               
                            </div>
                             <div id="errLoginMess"></div>
                        </form>
            </div>
    </body>
</html>
