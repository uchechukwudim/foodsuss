<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
  <div id="container">
    <?php include("C:\wamp\path\header.php"); ?>
            <div id="leftnav">
                <div id="Swrapper">
                <?php
                          include("C:\wamp\path\searchBox\searchform.php"); 
                ?>
             </div>
            </div>
            <div id="rightNav">
                right bar
            </div>
            <div id="body">
                 <div id="dd" class="wrapper-dropdown-3" tabindex="1">
                            <span>Recipes</span>
                            <ul class="dropdown">
                                <li><a href="foodfinder/AFRICA"><i class="icon-envelope icon-large"></i>Traditional</a></li>
                                <li><a href="foodfinder/ASIA"><i class="icon-truck icon-large"></i>Chef"s</a></li>
                            </ul>
                     </div> 
                <div id="countryMeal" ><span class="CM" onclick="navToCountries();"><?php echo $country ?></span></div>
                <div id="FoodMeal" onclick="navToFoods('<?php echo $country ?>');"><span class="FN"><?php echo $food ?></span></div>

            </div>
            
      <div id="imagelayer"></div>
        <div id="imagedialog">
            <div id="imageclose">| x |</div>
            <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>
            <div id="holdImage"><img id ="img1" src="" width="600" height="440"></div>
            <div id="imageholdComment"></div>
        </div>
        <div id="healthlayer"> </div>
        <div id="healthdialog">
            <div id="healthclose">| x |</div>
            <div id="healthheader_dialogProd"><span class ="txt">Health Benefits</span></div>
            <div id="holdhealth">
                <span id='Hhealth'></span>
            </div>
            <div id="healthholdComment">comment</div>
        </div>
        
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Error Message</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
</div>