<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<?php

include ("C:\wamp\path\mysql\SqlConnect.php");

$food = '';
$country = '';
$continent = '';
   if(isset($_GET['food']) && isset($_GET['country']))
   {
       $food = $_GET['food'];
       $country = $_GET['country'];
       $continent = $_GET['continent'];
   
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="http://localhost/Css/mealPage/mealsheet.css" type="text/css" media="screen">
        <link rel="stylesheet" href="http://localhost/Css/mealPage/imageDialog.css" type="text/css" media="screen">
        <link rel="stylesheet" href="http://localhost/Css/mealPage/healthDialog.css" type="text/css" media="screen">
        <script src="http://localhost/js/mealsJs/runMealFunctions.js" type="text/javascript"></script>
         <script src="http://localhost/js/mealsJs/mealjsfunctions.js" type="text/javascript"></script>
        <title>Meal</title>
        
    </head>
    <body>
        
        <div id="container">
                       <?php include("C:\wamp\path\header.php");?>
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
                <div id="countryMeal" ><span class="CM" onclick="navToCountries('<?php echo $continent ?>', '<?php echo $country ?>');"><?php echo $country ?></span></div>
                <div id="FoodMeal" onclick="navToFoods('<?php echo $continent ?>', '<?php echo $country ?>');"><span class="FN"><?php echo $food ?></span></div>
<?php
                        //get data fro database here
                        $sql = "SELECT meals.meal_name, how_to_cook, ingredents, health_benefits, 
                                  meal_image_id FROM `meals` Inner join food_meal on meals.meal_id 
                                  = food_meal.meal_id where food_meal.country_names = '$country' AND 
                                  food_meal.food_name = '$food'";
                          
                         $result =  SQLExc($sql);
                         
         while($row = mysqli_fetch_array($result))
         {
           extract($row);         
?>   
                    <div id="mealCon">
                        <div id="mealName"><?php echo $meal_name ?></div> 
                        <div id ="cook">
                        <span class="cookdesc"><?php echo $how_to_cook ?></span>
                                <div class="pic">Meal Picture
                                   <span class="nImage"><?php echo $meal_image_id ?></span>
                                </div> 
                                <div class ="nuterient" >Health
                                    <span class="nutHold"><?php echo $health_benefits ?></span>
                                </div>
                                <div class="McookedIt">
                                  <a src="#" class="cookit">CookedIt</a>
                                  </div>
                        </div> 
                    <div id="commentsbar">
                        <div class="Recooked"><span class="Rcook">10 people RecookedIt</span></div>
                    </div>      
                        <div class="comments">
                            <div class="commentsHolder">    
                                    <div id="userPic">
                                        <img src="#" width="80px;" height="70px">
                                    </div>
                                    <div id="userName">User Name</div>
                                
                                    <div id="userDesc">A Huge consumer of Casava Palm Oil. Country very reach
                                                        with food. Click to see more foods and how the are
                                                       prepared.</div>
                                    <div id="postTime">Posted Time</div>
                                    <div id="cookedIt">
                                        <a src="#" class="cookit">2 People CookedIt</a>
                                    </div>
                             </div>
                            <div class="commentsHolder">    
                                    <div id="userPic">
                                        <img src="#" width="80px;" height="70px">
                                    </div>
                                    <div id="userName">User Name</div>
                                  
                                    <div id="userDesc">A Huge consumer of Casava Palm Oil. Country very reach
                                                        with food. Click to see more foods and how the are
                                                       prepared.</div>
                                    <div id="postTime">Posted Time</div>
                                    <div id="cookedIt">
                                        <a src="#" class="cookit">2 People CookedIt</a>
                                    </div>
                             </div>
                        </div>   
                             <div class="textarea" contenteditable="true" tabindex="1">
                               <p>Show how you cook Meal Name....</p>
                            </div>
                </div>
<?php 
        }
  ?>
            </div>
            
        </div>
<?php
       }
?>
        
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
        
    </body>
      
    <script>
     //from mealjsfunctions.js to runmealfunction.js
     runFunctions();
       
     
     </script>
</html>
