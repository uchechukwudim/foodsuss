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
         <link rel="stylesheet" href="<?php echo URL ?>views/css/reseachAdministration/putFood/putfoodsheet.css">
         <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
         <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/putFood/js/putfood.js"></script>
        <title>Post Food</title>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li style="list-style-image: url(<?php echo URL ?>pictures/research/nav_back.png);"><a href="<?php echo URL ?>researchAdministration/navigation">Researcher Navigation</a></li>
                <li onclick="postFoodOriginCountryDesc()" title="post country and description for an existing food" style="list-style-image: url(<?php echo URL ?>pictures/research/nav_down.png);">Post Food Country</li>
            </ul>
        </div>
        <div id="confirm">
            <input onkeyup="searchConfirmedFood()" type="text" id="search_confirm" placeholder="Confirm Posted Food"><br>
            <div class="ch"></div>
        </div>
        <div id="putFoodHolder">
            <img src="<?php echo URL ?>pictures/enri_logo.png" width="50">
            <h2>Post Food</h2>
              <form id="putFood">
                <input type="text" id="food_name" placeholder="Food Name"><br>
                <textarea id="gen_description" cols="55" rows="5" draggable="false" placeholder="Describe the food and give a little history, season it can be grown and little statistic of consumption generally."></textarea><br>
                <textarea id="gen_nuterients" cols="55" rows="5" draggable="false" placeholder="Nutrients"></textarea><br>
                <select id="foodType">
                    <option>Food type</option>
                    <option>Fruit and Vegitable</option>
                    <option>Dairy</option>
                    <option>Meat and protein</option>
                    <option>Grain</option>
                    <option>fat oil and sweet</option>
                </select>
                <input type="file" id="file" name="file"><br>
                <div id="countryOrgin_descrip_holder">
                    <input onkeyup="searchCountry(0)" type="text" class="country_origin" placeholder="country(s) that consume's this food">
                    <div class="h"></div>
                    <textarea class="country_description" cols="28" rows="6" placeholder="Describe how this food is being consummed in the said country of origin."></textarea><br>
                      <button onclick="addCountryOriginandDesc()" type="button" class="plusCountry_desc">+</button><br>
                </div>

                <span class="errMess"></span>

                <button onclick="processPutFood()" type="button" id="submitPutFood">Post</button>    
             </form>
        </div>
    </body>
</html>
