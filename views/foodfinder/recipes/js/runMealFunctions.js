$(document).ready(function(){
    runFunctions();
  
    //RuncontinentDropdownList();
  
    
     //doo();
});
  //call every function for meal.php          
  function runFunctions(){
       reciepeENUserCommentfocusInFocusout();
      reciepeUserRecookfocusInFocusout();
       reciepeUserCommentfocusInFocusout();
      hideReciepieImageDialogOnLoad();
     // showReciepieImageDialog();
      closeImageReciepieDialog();
     // showUserComments();
      hideHealthDialogOnLaod();
      showHealthDialog();
      closeHealthDialog();
      //GetNumberOfCookIt();
      //sendUserCommentEN();
      //sendUserRecookComment();
      //getUserRecookComment();
     // getUserRecookCommentCount();
      showUserReccokComments();
      
  }
  
function loadMeal(data,firstName, lastName, image)
{
    $('#recipesHolder').html(""+data);
   $('#nameP a b').text(firstName+" "+lastName);
       $('#imgP img').attr('src', image);
}

 function infinitScrollENRecipeLoader(country)
 {

   var pages = 0;
   var food = $('#FoodMeal span.FN img').attr('title');
  
   //var userType =  $('#dd span').text();
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            var switcher = $('#counterHolder').text();
            
            if(switcher === "0")
            {
                pages = 0;
                 pages = pages + 6;
                $('#counterHolder').text('1');
            }
            else
            {
                   pages = pages + 6;
            }
             $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                 $('#postload').css({"width": "50px"});
                $("#postload").css({
                   position: "relative",
                   left: "450px",
                   top: "25px"
                 });
             
             $.get(""+JURL+"foodfinder/infinitScrollENRecipeLoader", {page: pages, foodName: food, countryName: country}, function(data){
                 
                
                    $("#postload").empty();
                    $("#recipesHolder").append(""+data);
                    showUserComments(); reciepeUserRecookfocusInFocusout();
                    reciepeUserCommentfocusInFocusout();  sendUserCommentEN();
                    showUserReccokComments();
                  
                 
             }, 'json').fail(function(){
                             $("#postload").html("something went wrong");
                             $("#postload").css({"color":"orangered"});
                        });
        }
    });
}


  
