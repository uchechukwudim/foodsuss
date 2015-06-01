
<?php
$output = "";

//this "class" is used by food.php 


include("C:\wamp\path\loadFoods\otherCountryProcess.php");
if(isset($_GET['country'])){
    $continent =  $_GET['continent'];
    $country = $_GET['country'];
    $sql = "SELECT FC.food_name, FC.country_names, F.food_description, F.food_picture, F.Nutrients FROM  `food_country` AS FC INNER JOIN Food AS F ON FC.food_name = F.food_name WHERE country_names = '$country'";

    $result = SQLExc($sql);
    
     
    while(  $row = mysqli_fetch_array($result)){
      
      extract($row);
    
    ?>
   <div class="foodCon">
                     <div id="foodpic">
                            <img src="<?php echo $food_picture; ?>" height="100" width="100">
                     </div>
                     <div id="foodName">
                      <?php echo $food_name; ?>
                     </div>
                     <div id="foodDesc">
                      <?php echo $food_description ?>
                     </div>
                     <div id="meals" onclick='window.location = "http://localhost/php/meals.php?food=<?php echo $food_name ?>&country=<?php echo $country ?>&continent=<?php echo $continent ?>";'>
                     <div id = "M">Recipes</div>
                     </div> 
                     <div class="products" onclick="prod('<?php echo $food_name ?>'); getproductsFromDatabase('<?php echo $food_name ?>', '<?php echo $country ?>');">
                         <div id = "P" >Products</div>
                     </div>
                     
           <div class="OtherCountry" title="<?php echo otherCountry($country, $food_name); ?>">Other countries</div>
           <div class="nuterients" title ="<?php echo $Nutrients ?>">Nutrients </div>
           <div class="tooltips"></div>
            
           </div>
    <?php
          }
          
  
 }


?>
 
<script type="text/javascript">
 
       function prod(Food){
          $('#header_dialogProd span.txt').html("Products From "+ Food);
       }
        function getproductsFromDatabase(Food, country)
          {
               $.post('http://localhost/php/foodPageProcessing/getProducts.php', {food: Food, country: country}, function(data){
                    var scrollPosition = $('body').scrollTop();
                   if(data.indexOf(",") >=0)
                    {
                        //show error messge here when there are no products in database
                         showErrorMessage(data);
                        //closing error dialog box start heree
                        //press X to close error
                         pressXTOCloseErrorDialog(scrollPosition);       
                        //close lyer when esc is press
                        pressEscToCloseErrorDialog(scrollPosition) 
                        //closing error dialog box end heree
                    }
                    else
                    {
                           //when there are products of a food in database
                           
                           //show products
                           showProducts(data)
                           //closing products dialog box start here
                           
                           //closing dialong when X is click
                           pressXToClosProductDialg(scrollPosition);
                           //close dialog when esc is press
                           pressExcToCloseProductDialog(scrollPosition);
                           
                           //closing products dialog box end here
                    }

               });  
          }
   
    function pressExcToCloseProductDialog(scrollPosition)
    {
        $(document).keyup(function(e){
        if(e.which == 27){
            // Close my modal window
            $('#layer').hide();
            $('#dialog').hide();
            $('body').css({"overflow": "auto"});
               $('body').scrollTop(scrollPosition);
        }
    });
    }
    function pressXToClosProductDialg(scrollPosition)
    {
         $('#close').click(function(){
            $('#layer').hide();
            $('#dialog').hide();
            $('body').css({"overflow": "auto"});
               $('body').scrollTop(scrollPosition);
        });
    }
    
    function pressXTOCloseErrorDialog(scrollPosition){
        
        $('#error_close').click(function(){
           $('#error_layer').hide();
           $('#error_dialog').hide();
           $('#error_close').hide();
           $('body').css({"overflow": "auto"});
           $('body').scrollTop(scrollPosition);
         });
    }
    
    function pressEscToCloseErrorDialog(scrollPosition){
        $(document).keyup(function(e){
            if(e.which == 27){
            // Close my modal window
             $('#error_layer').hide();
            $('#error_dialog').hide();
            $('#error_close').hide();
             $('body').css({"overflow": "auto"});
             $('body').scrollTop(scrollPosition);
        }
     });
    }
    
    function showErrorMessage(data){
          $('#layer').hide();
                            $('#dialog').hide();
                             $('body').scrollTop(0);
                            $('body').css({"overflow": "hidden"});
                                var newData = data.replace(',', '');
                                $('#er_message').html("There are no Products for "+newData+" yet");
                                $('#error_layer').show();
                                $('#error_dialog').show();
                                $('#error_close').show();
    }
    
    function showProducts(data){
        $('#holdProd').html(""+data);
                            $('body').scrollTop(0);
                             $('body').css({"overflow": "hidden"});
                             
    }
    
    function NoFooderrorMessage(message)
               {
                 $('#er_message').html(""+message);
                 $('#error_layer').show();
                 $('#error_dialog').show();
                 $('#error_close').show();
                 
                        closeNoFoodErrorMessage();
               } 
               
     function closeNoFoodErrorMessage()
     {
         $(document).keyup(function(e){
            if(e.which == 27){
            // Close my modal window
             $('#error_layer').hide();
            $('#error_dialog').hide();
            $('#error_close').hide();
          
        }
     });
     
     $('#error_close').click(function(){
           $('#error_layer').hide();
           $('#error_dialog').hide();
           $('#error_close').hide();
           $('body').css({"overflow": "auto"});
           $('body').scrollTop(scrollPosition);
         });
     }
     
 
</script>
 
 <script src="http://localhost/js/foodPage/tooltip.js" type="text/javascript"></script>