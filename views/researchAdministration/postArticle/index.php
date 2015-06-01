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
            var FIELDCOUNTER = 0;
            var EFIELDCOUNTER = 0;
        </script>
        <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
         <link rel="stylesheet" href="<?php echo URL ?>views/css/reseachAdministration/postArticle/postarticlesheet.css">
         <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
         <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/postArticle/js/postArticle.js"></script>
        <title>Post Article</title>
    </head>
    <body>
        <header>
             <div id="nav">
                <ul>
                    <li style="list-style-image: url(<?php echo URL ?>pictures/research/nav_back.png);"><a href="<?php echo URL ?>researchAdministration/navigation">Researcher Navigation</a></li>
                </ul>
            </div>
        </header>
        <div id="postArticleHolder">
            <img src="<?php echo URL ?>pictures/enri_logo.png" width="50">
            <h2>Post Article</h2>
              <form id="putFood">
                <input type="text" id="article_title" placeholder="Article Title"><br>
                <textarea id="article_description" cols="55" rows="15" draggable="false" placeholder="Write article here. if your not the author of the article, just put the link."></textarea><br>
                <textarea id="article_writeup" cols="55" rows="5" draggable="false" placeholder="Brief direciption of what the article is about."></textarea><br>
                <input type="text" id="article_link" placeholder="Article Link. If your the author leave this empty">
                <input type="file" id="file" name="file"><br>
                <div id="countryOrgin_descrip_holder">
                    <input onkeyup="searchtag(0)" type="text" class="tags" placeholder="tags of what the article is about">
                    <div class="h"></div>
                    
                </div>

                <span class="errMess"></span>

                <button onclick="processPostArticle()" type="button" id="submitPostArticle">Post</button>    
             </form>
        </div>
    </body>
</html>
