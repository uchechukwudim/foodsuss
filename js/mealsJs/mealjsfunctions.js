//implementation of functions for meal.php
function navToCountries(continent, country)
{
       
        window.location.href = "CountryList.php?state="+continent+"_"+country+"";

}

function navToFoods(continent,country)
{
    window.location = "food.php?country="+country+"&continent="+continent+"";
}

function commentFunc()
{

    //when mouse is click to type
    $(".textarea").focus(function(){

       $(".textarea").html("");
         $(".textarea").focus();
    });

    //when mouse is click out of textarea
     $(".textarea").focusout(function(){
         $(".textarea").html("<p>Show how you cook Meal Name....</p>");
     });
               
}

 function showReciepieImageDialog()
 { 
     $('.pic').each(function(index){
         $(this).click(function(){
             
             var m = $('.pic span.nImage').text();
             document.getElementById('img1').src = "processPictures.php?id="+m[index]+"";
              $('#imagelayer').show();
              $('#imagedialog').show();
       
         });
     });
 }
 
 function hideReciepieImageDialogOnLoad()
 {
     $('#imagelayer').hide();
     $('#imagedialog').hide();
 }
 
 function closeImageReciepieDialog()
 {
     $('#imageclose').click(function(){
     $('#imagelayer').hide();
     $('#imagedialog').hide();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#imagelayer').hide();
                $('#imagedialog').hide();
           }
     });
 }
 
 function showUserComments()
 {
     $(".Recooked").each(function(index){
         
         $(this).click(function(){
             show(index);
         });
     });
 } 

 function show(index)
 {
     var comments = $('.comments');
     var textarea = $('.textarea');
     //offset check the size of the element at the time its clicked
     var  commentWidth = comments[index].offsetWidth;
     var commentHeight = comments[index].offsetHeight;
     
     if(commentWidth===0 || commentHeight===0)
      {
            comments[index].style.display = 'block';
           textarea [index].style.marginTop = "10px";
      }
      else if(commentWidth !==0 || commentHeight!==0)
      {
           comments[index].style.display = 'none';
      }
   
 }
 
 function hideHealthDialogOnLaod()
 {
     $('#healthlayer').hide();
     $('#healthdialog').hide();
 }
 
 function showHealthDialog()
 {
     $('.nuterient').each(function(index){
         $(this).click(function(){
             
             var h = $('.nuterient span.nutHold').text();
         
             $('#Hhealth').html(""+h);
             $('#healthlayer').show();
              $('#healthdialog').show();
         });
     });
 }
 
function closeHealthDialog()
{
     $('#healthclose').click(function(){
                $('#healthlayer').hide();
              $('#healthdialog').hide();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
               $('#healthlayer').hide();
              $('#healthdialog').hide();
           }
     });
}
