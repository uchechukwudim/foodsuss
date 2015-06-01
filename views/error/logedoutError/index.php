<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.9.1.js"></script>
          <script type="text/javascript" src="<?php echo URL ?>views/default.js"></script>
           <script type="text/javascript" src="<?php echo URL ?>views/sideBar.js"></script>
            <script type="text/javascript" src="<?php echo URL ?>views/search/js/search.js"></script>
            <script type="text/javascript" src="<?php echo URL ?>views/notification/js/notification.js"></script>
             <script type="text/javascript" src="<?php echo URL ?>views/cook/js/cook_post.js"></script>
              <script type="text/javascript" src="<?php echo URL ?>views/cook/js/process_makeRecipe.js"></script>
          <link rel="stylesheet" href="<?php echo URL ?>views/default.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/search/searchsheet.css">
          <link rel="stylesheet" href="<?php echo URL ?>views/css/noitification/notificationsheet.css">
           <link rel="stylesheet" href="<?php echo URL ?>views/css/cook/cooksheet.css">
           
          
      
        
          <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
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
        <title>enrie</title>

    </head>
    <body>
        <div id="header_view">
           <div id='logo'>
               <img src="<?php echo URL ?>pictures/logo_landscap.png" alt="" width="100">
            </div>
        </div>
        <div id="404" style="font-size: 30px; text-align: center; position: relative; top: 100px" >Sorry this link isn't available </div>
        <div id="404_2" style="font-size: 20px; text-align: center; position: relative; top: 100px;">The link you requested may be broken, or the page may have been removed</div>
        <div id="404_3" style="font-size: 160px; text-align: center; position: relative; top: 100px; color: rgba(0, 0, 0, 0.1); margin-bottom: 230px;">404</div>
        <div id="404_redirect" style="text-align: center;"><a style="text-decoration: none; color: orangered;" href="<?php echo URL ?>">Go to enri homepage</a></div>
        <?php
        // put your code here
        ?>
    </body>
</html>
<script>
$('#404_redirect').hover(function(){
    $(this).css({"text-decoration":"underline"});
}, function(){
      $(this).css({"text-decoration":"none"});
});
</script>