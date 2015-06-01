<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script>
            var EMPTY = '';
            var JURL = '<?php echo URL ?>';
           
        </script>
        <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
         <link rel="stylesheet" href="<?php echo URL ?>views/css/reseachAdministration/reseachAdministrationsheet.css">
          <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
        <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/navigation/js/navigation.js"></script>
         <title>Researchers Navigation</title>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li style="list-style-image: url(<?php echo URL ?>pictures/research/nav_back.png);"><a href="<?php echo URL ?>researchAdministration/researchLogout">Log out</a></li>
            </ul>
        </div>
        <div id="research_nagivationHolder">
            <img src="<?php echo URL ?>pictures/enri_logo.png" width="100">
            <h2>Navigation</h2>
                <div id="generalHolder">
                     <ul>
                         <li><a href="<?php echo URL ?>researchAdministration/putFood">Put Food</a></li>
                        <li><a href="<?php echo URL ?>researchAdministration/putRecipe">Put Recipe</a></li>
                        <li style="border-bottom: 1px solid rgba(0,0,0,0.1);"><a href="<?php echo URL ?>researchAdministration/putProduct">Put Food Product</a></li>
                        <li style="border-bottom: 1px solid rgba(0,0,0,0.1);"><a href="<?php echo URL ?>researchAdministration/postArticle">Post Article</a></li>
                        <li style="border-bottom: 1px solid rgba(0,0,0,0.1);" onclick="reSendReverificatioinEmail()">Send re-verification email</li>
                    </ul>
                </div>
           
        </div>
     
    </body>
</html>
