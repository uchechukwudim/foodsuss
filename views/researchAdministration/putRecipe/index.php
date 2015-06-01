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
         <link rel="stylesheet" href="<?php echo URL ?>views/css/reseachAdministration/putRecipe/putrecipesheet.css">
         <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
         <script type="text/javascript" src="<?php echo URL ?>views/researchAdministration/putRecipe/js/putRecipe.js"></script>
        <title>Post Food</title>
    </head>
    <body>
        <div id="nav">
            <ul>
                <li style="list-style-image: url(<?php echo URL ?>pictures/research/nav_back.png);"><a href="<?php echo URL ?>researchAdministration/navigation">Researcher Navigation</a></li>
            </ul>
        </div>
        <div id="confirm">
            <input onkeyup="searchConfirmedRecipe()" type="text" id="search_confirm" placeholder="Confirm Posted Recipe"><br>
            <div class="ch"></div>
        </div>
        <div id="putRecipeHolder">
                 <img src="<?php echo URL ?>pictures/enri_logo.png" width="50">
                 <h2>Post Recipe</h2>
                 <form id="putRecipe">
                    <input type="text" id="recipe_title" placeholder="recipe title"><br>
                    <textarea id="recipe_instruction" cols="55" rows="5" placeholder="recipe instructions"></textarea><br>
                    <textarea id="recipe_healthBenefits" cols="55" rows="5" placeholder="Health Benefit"></textarea><br>
                    <select id="mealType">
                        <option>Meal Type </option>
                        <option>BreakFast</option>
                        <option>Launch</option>
                        <option>Dinner</option>
                        <option>Dessert</option>
                        <option>Drink</option>
                        <option>Breakfast or Lunch</option>
                        <option>Lunch or Dinner</option>
                        <option>Breakfast or Dinner</option>
                    </select>
                    <input type="file" id="file" name="file"><br>
                    <input onkeyup="searchCountry()"  type="text" id="recipe_countryName" placeholder="country origin">
                    <input onkeyup="searchFood()" type="text" id="recipe_BasefoodName" placeholder="recipe Base food"><br>
                    <div id="h"></div>

                    <div id="ingredientHolder">
                        <input type="text" class="recipe_ingreQty" placeholder="ingredient Qty"><input type="text" class="recipe_ingre" placeholder="ingredient">
                        <button onclick="addIngreQtyNIngre()" type="button" class="plus_ingreQty">+</button><br>
                    </div>
                    <span class="errMess"></span><br>
                    <button onclick="processPutRecipe()" type="button" id="submitRecipePut">Post</button>
                </form>
        </div>
      
    </body>
</html>
