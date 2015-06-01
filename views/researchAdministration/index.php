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
         <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/js/researchAdmin.js"></script>
        <title>enri Researchers Home</title>
    </head>
    <body>
        <div id="formHolder">
            <img src="<?php echo URL ?>pictures/enri_logo.png" width="100">
            <h2>Researcher Home</h2>
            <form>
               
                <input onkeyup="processResearcherLoginEnter(event)" type="email" id="researcher_email" placeholder="email"><br>
                <input onkeyup="processResearcherLoginEnter(event)" type="password" id="researcher_password" placeholder="password">
                <span class="errorMes"></span>
                <button onclick="processResearcherLogin()"  type="button" id="researcher_loginBut">Log In</button>
            </form>
        </div>
        
    </body>
</html>
