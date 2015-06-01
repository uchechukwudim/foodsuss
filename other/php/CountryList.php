<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
          <title>LIST OF COUNTRIES</title>
    <link rel="stylesheet" href="http://localhost/css/countryListPage/countries.css" type="text/css" media="screen">
   <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
   <script src="http://localhost/js/realtimeSearch.js"></script>
       
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
        
                <div id="rightNav">right nav</div>
                <div id="body">
                    <?php include("C:\wamp\countries\LoadCountries.php"); ?>
                      
                </div>
               
               <div class="load">
                    
               </div>
           <?php include("C:\wamp\path\Footer.php"); ?>
     </div>
    
     <script>
               
       $("#search").keyup(function(){
             var search = $(this).val();
             if(search.length === 0 || search === " ")
             return false;
              
            
              var pages = 0; 
               $.post("http://localhost/php/searchProcessing/instantSearch.php", {searchval: search, pages: pages, continent: "<?php echo $continent ?>"}, function(data){
             
                  
                     $("#body").html(data);
                     
                      $(window).scroll(function(){
                      if($(document).scrollTop() === $(document).height() - $(window).height())
                        {
                            pages = pages + 6;
                            $.post("http://localhost/php/searchProcessing/instantSearch.php", {searchval: search, pages: pages, continent: "<?php echo $continent ?>"}, function(data){
                                                            

                                 $(".load").html('<img src="http://localhost/pictures/ajax-loader.gif">');
                                 setTimeout(function(){
   
                                    $(".load").empty();
                                 $("#body").append(data);
                                 }, 1000);      
                            });
                             
                        };});
                       
               });
           
              
          
            });//end of keyup
               
            $("#search").focus();
     
    </script>  
    </body>
      
  
</html>
