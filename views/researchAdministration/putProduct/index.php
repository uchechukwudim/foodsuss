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
        </script>
        <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
         <link rel="stylesheet" href="<?php echo URL ?>views/css/reseachAdministration/putProduct/putproductsheet.css">
         <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
         <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/putProduct/js/putProduct.js"></script>
        <title>Post Product</title>
    </head>
    <body>    
         <div id="nav">
            <ul>
                <li style="list-style-image: url(<?php echo URL ?>pictures/research/nav_back.png);"><a href="<?php echo URL ?>researchAdministration/navigation">Researcher Navigation</a></li>
                <li onclick="postProductEatWith()" title="post an existing product eatwith" style="list-style-image: url(<?php echo URL ?>pictures/research/nav_down.png);">Post Product Eatwith</li>
            </ul>
         </div>
         <div id="confirm">
            <input onkeyup="searchConfirmProductName()" type="text" id="search_confirm" placeholder="Confirm Posted Product"><br>
            <div class="ch"></div>
        </div>
        
        <div id="putProductHolder">
            <img src="<?php echo URL ?>pictures/enri_logo.png" width="50">
                 <h2>Post Product</h2>
            <form id="putProduct">
                <input type="text" id="product_name" placeholder="Product Name"><br>
                <textarea id="product_description" cols="55" rows="5" placeholder="Product Description"></textarea><br>
                <input onkeyup="searchFood()" type="text" id="ProdFoodName" placeholder="Base Food">
                <input onkeyup="searchCountry()" type="text" id="ProdCountryName" placeholder="Base Country"><br>
                <div id="h"></div>
                <input type="file" id="file" name="file"><br>
                <div id="eatwithHolder">
                    <input type="text" class="ProdEatwith" placeholder="what to eatwith product">
                    <button onclick="addEatwith()" type="button" class="plusProdEatwith">+</button><br>
                    <select class="eatwithtype">
                        <option>Type</option>
                        <option>Food</option>
                        <option>Product</option>
                        <option>Recipe</option>
                    </select><br>
                </div>
                <span class="errMess"></span><br>
                <button onclick="processPutProduct()" type="button" id="submitPutProduct">Post</button>
            </form>
        </div>
        
    </body>
</html>
