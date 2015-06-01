<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<?php 
$country = '';

      include ("C:\wamp\path\mysql\SqlConnect.php");
   if(isset($_GET['country']) || isset($_GET['continent'])){
       $country = $_GET['country'];
       $continent = $_GET['continent'];
       
        
   }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
         <link rel="stylesheet" href="http://localhost/Css/foodPage/foodsheet.css" type="text/css" media="screen">
          <link rel="stylesheet" href="http://localhost/Css/foodPage/productsheet.css" type="text/css" media="screen">
            <link rel="stylesheet" href="http://localhost/Css/foodPage/errorDialgBoxSheet.css" type="text/css" media="screen">
        <title></title>
        <script src="http://localhost/js/jquery.min.js" type="text/javascript"></script>
        <script src="http://localhost/js/jquery-2.0.0.js" type="text/javascript"></script>
        <script src="http://localhost/js/foodPage/foodpage.js" type="text/Javascript"></script>
       
    </head>
    <body>
      
    <div id="container">
        
         <?php include("C:\wamp\path\header.php"); ?>
            <div id="leftnav">
                <div id="Swrapper">
                <?php
                         include("C:\wamp\path\searchBox\searchform.php"); 
                ?>
             </div>
            </div>
        <div id="body">
            <div id="tag">
                    <img src="http://localhost/pictures/foods/tag.jpg"> <p>Tell us food we don't know about</p>
                    <p class='navCountry'> <?php echo $country; ?></p> <img src='' width='20' height='20' class='im1'> 
            </div>
            
          <form action ="" method ="post" enctype="multipart/form-data" id="usrform">   
                
                    <textarea  name="comment" form="usrform" id ='inputFood' ></textarea>

                   <div class="btnTag">
                       <button id="submitBt" type="submit" name='submit' form="usrform">Tell</button>
                       <div id="uploadPic">
                          <p>Picture</p>
                          <input type="file" name="image" />
                       </div>
                   </div>
         </form>
                 <?php  include("C:\wamp\path\loadFoods\LoadFoods.php");?>
            </div>
    </div>
        <!--
          Products mage start here
        -->
        <div id="layer"></div>
        <div id="dialog">
            <div id="close">| x |</div>
            <div id="header_dialogProd"><span class ="txt"></span></div>
            <div id="holdProd"></div>
        </div>
        
        <!--
          Products mage end her
        -->
        
        <!---
        error dialog box start here
        -->
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Error Message</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
        
        <!---
        error dialog box end here
        -->
        <?php
    
        ?>
    </body>
    <script type="text/javascript">
    $(document).ready(function(){
      //Comment box for users to tell Enri about a food she doesnt know:::::  
      //from foodPage.js file
         inputFocus();
         inputfocusout();
      //end of comment boxx::::::::::::::::::::::::::::::::::::::::::::::::: 
 
      //show/hide product dialog box:::::::::::::::::::::::::::::::::::::::::::::
    $('#layer').hide();
    $('#dialog').hide();

    //whe happens when products button is clicked
    $('.products').click(function(event){
    $('#layer').show();
    $('#dialog').show();
      });   
    });
  
    //when navCountry is clicked it goes back to 
    $('#tag p.navCountry').click(function(){
         
            window.location.href = "http://localhost/php/CountryList.php?state='<?php echo $continent ?>'";
    });
    
     <?php
       // if there are no food to display this message shows
          $message = "Sorry there are no foods yet for <b>$country</b> we are working on it. Please feel free to tell us about food </br>we do not know.";
          $sql = "SELECT country_names FROM food_country WHERE country_names = '$country'";
          $result = getNumberOfRows($sql);
          if($result === 0)
          {
              ?>
                     NoFooderrorMessage('<?php echo $message ?>');
             <?php
          }
          ?>
              
       //no food display ends here::::::::::::::::
    </script>
    <?php 
      include("C:\wamp\path\loadFoods\userfoodPost.php");
    ?>
</html>


