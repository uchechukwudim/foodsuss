/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    

});

function getProfileAbouteMe()
{
    $('#AjaximageLoader').show();
    $.ajax({
        url: JURL+"profile/AboutMe",
        type: "GET",
        dataType: "json",
        data: {},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html("");
            $('#LOAD').html(data);
            addressSendder();
            
             appendEditPen();
             favouritePen();
             AboutMeSender();
             favFoodSender();
             FavRestaurantSender();
             favIngredientSender();
             favRecipeSender();
     
        },
        error:function(){
            $('#AjaximageLoader').hide();
        }
        
    });
}

function getRestaurantProfileAbouteMe(user_type)
{
    $('#AjaximageLoader').show();
    $.ajax({
        url: JURL+"profile/AboutMe",
        type: "GET",
        dataType: "json",
        data: {user_type: user_type},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html("");
            $('#LOAD').html(data);
            
             appendEditPen();
             favouritePen();
             AboutMeSender();
             cuisineSender();
             mostFoodSender();
             mostIngredientSender();
             mostRecipeSender();
        },
        error:function(){
             $('#AjaximageLoader').hide();
        }
        
    });
}

function getUserRestaurantProfileAbouteMe(user_type, userId)
{
    $('#AjaximageLoader').show();
    $.ajax({
        url: JURL+"profile/AboutMe",
        type: "GET",
        dataType: "json",
        data: {user_type: user_type, userId: userId},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html("");
            $('#LOAD').html(data);
            
              $('#meHolderHeader b').css({position: "relative", left:"-80px"});
             $('#meHolderHeader img').css({position: "relative", left:"-80px"});
        },
        error:function(){
            $('#AjaximageLoader').hide();
        }
        
    });
}

function getUserProfileAbouteMe(userId)
{
    $('#AjaximageLoader').show();
     $('#AjaximageLoader').css({postion: "relative", left: "300px"});
    $.ajax({
        url:  JURL+"profile/AboutMe",
        type: "GET",
        dataType: "json",
        data: {userId: userId},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html("");
            $('#LOAD').html(data);
            $('#meHolderHeader b').css({position: "relative", left:"-80px"});
             $('#meHolderHeader img').css({position: "relative", left:"-80px"});
            
     
        },
        error:function(){
             $('#AjaximageLoader').hide();
        }
        
    });
}


  function initializee() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var mapOptions = {
      zoom: 8,
      center: latlng
    }
    mapp = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
  }

  function codeAddress(city) {
    var address = city;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        mapp.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: mapp,
            position: results[0].geometry.location
        });
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }



function appendEditPen()
{
     var editImageTitle = 'click to edit. double click to save edited text';
    //mobile
      var tempMobile = $('#Mh').text();  
    $('#mobile').hover(function (){
        $('#mobile').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick=" MobileSender('+tempMobile+')" title="'+editImageTitle+'">');
          $('#mobile img').css({ "float":"right",
                                position: "relative",
                                bottom: "15px",
                                right: "10px"
                                });
        //mobile image click method here
        EditLocationMobile();
    },
    function (){
         $('#mobile img').remove();
    });
    
    //address
    $('#address').hover(function(){
        $('#address').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="addressSender()"  title="'+editImageTitle+'">');
          $('#address img').css({ "float":"right",
                                position: "relative",
                                bottom: "34px",
                                right: "10px"
                                });
         //address edit method here
         EditLocationAddress();
    },
    function(){
        $('#address img').remove();
    });
    
  //location
  $('#currentLocation').hover(function(){
      $('#currentLocation').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="currentLocationSender()"  title="'+editImageTitle+'">');
          $('#currentLocation img').css({ "float":"right",
                                position: "relative",
                                bottom: "34px",
                                right: "10px"
                                });
                            
       //current location edit method here
       EditCurrentLocation();
  }, 
  function(){
       $('#currentLocation img').remove();
  });
  
  //from
  $('#FromLoc').hover(function(){
      $('#FromLoc').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="FromLocSender()"  title="'+editImageTitle+'"> ');
          $('#FromLoc img').css({ "float":"right",
                                position: "relative",
                                bottom: "34px",
                                right: "10px"
                                });
       //Edit from method here
       EditFromLoc();
  }, 
  function(){
      $('#FromLoc img').remove();
  });
  
 
}




function favouritePen()
{
    //about
    $('#About').hover(function(){
      $('#About').css({"cursor":"pointer"});
      $('#aboutHeader img').show();
       $('#aboutHeader img').click(function(){
               //edit about method here
           EditAboutMe();   
       });
    },
    function(){
        $('#aboutHeader img').hide();
    });
    
   
    
    //fav food
    $('#cuisine').hover(function(){
        $('#cuisine').css({"cursor":"pointer"});
      $('#cuisineHeader img').show();
      
      //edit fav food method here
     EditCuisins();
    }, 
    function(){
        $('#cuisineHeader img').hide();
    });
    
    //favRest
    $('#mostFood').hover(function(){
         $('#mostFood').css({"cursor":"pointer"});
      $('#mostFoodHeader img').show();
      
      //edit Fav rest method here
      EditMostFood();
      
    },
    function(){
          $('#mostFoodHeader img').hide();
    });
    
    //fav ingredient
    $('#mostIngredients').hover(function(){
         $('#mostIngredients').css({"cursor":"pointer"});
      $('#mostIngredientsHeader img').show();
      
      //edit fav ingredients method here
      EditMostIngredient();
    },
    function(){
         $('#mostIngredientsHeader img').hide();
    });
    
    //fav recipe
    $('#mostRecipes').hover(function(){
           $('#mostRecipes').css({"cursor":"pointer"});
      $('#mostRecipesHeader img').show();
      
      //edit fav recipe method here
      EditMostRecipe();
    },
    function(){
         $('#mostRecipesHeader img').hide();
    });
}

function EditLocationMobile()
{
  
     $('#mobile img').click(function(){
         $('#Mh').attr('contentEditable',true);
          $('#Mh').focus();
          
     });
  
}

function MobileSender(tempMobile)
{
    var maxLength = 13;
    var columnName = "phone";
             //send to database and save
              $('#Mh').attr('contentEditable',false);
              //send data to server here
            var mNumber = $('#Mh').text();
           processLocationInputsAndSend(mNumber , columnName, maxLength);
}

function EditLocationAddress()
{

     $('#address  img').click(function(){
         $('#Ah').attr('contentEditable',true);
         $('#Ah').focus();
         
     });
     
}

function addressSender()
{
    var  maxLength = 100;
    var columnName = "address";
 
             //send to database and save
             $('#Ah').attr('contentEditable',false);
              //send address to server here
             var newAddress =  $('#Ah').text();
          processLocationInputsAndSend( newAddress, columnName, maxLength);
 
}

function EditCurrentLocation()
{
      
  
     $('#currentLocation img').click(function(){
         $('#CCh').attr('contentEditable',true);
         $('#CCh').focus();
         
         
     });

}

function currentLocationSender()
{
    var  maxLength = 50;
    var columnName = "city";

             //send to database and save
              $('#CCh').attr('contentEditable',false);
              //send current location to server here
              
              var newCurrentLoc = $('#CCh').text();
              processLocationInputsAndSend(newCurrentLoc, columnName, maxLength);
       
              
}

function EditFromLoc()
{
    
     $('#FromLoc img').click(function(){
         $('#Fmh').attr('contentEditable',true);
         $('#Fmh').focus();
        
     }).blur(function(){
              $('#Fmh').attr('contentEditable',false);
         });
       
}

function FromLocSender()
{  
    var columnName = "opening_times";
    var maxLength = 50;
         
             //send to database and save
              $('#Fmh').attr('contentEditable',false);
              //send where your from to server here
              var newOpeningTime = $('#Fmh').text();
            processLocationInputsAndSend( newOpeningTime, columnName, maxLength);
        
}

function EditEmail()
{
    var FromLoc = $('#Eh').text();
     $('#email img').click(function(){
         $('#Eh').attr('contentEditable',true);
         $('#Eh').focus();
         
         $('#email img').dblclick(function(){
             //send to database and save
              $('#Eh').attr('contentEditable',false);
         });
     }).blur(function(){
              $('#Eh').attr('contentEditable',false);
         });
}

function EditAboutMe()
{
   var empty = '';
   var tempText = 'No About Us. Edit your About Us.';
    $('#aboutHeader img').click(function(){
         if(tempText.replace(/\s+/g, '')  ===  $('#aboutText').text().replace(/\s+/g, ''))
         {
              $('#aboutText').attr('contentEditable',true);
              $('#aboutText').text('');
              $('#aboutText').focus();
              $('#aboutText').focusout(function(){
                   if($('#aboutText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#aboutText').text(tempText);
                       $('#aboutText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#aboutText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#aboutText').attr('contentEditable',true);
               $('#aboutText').focus();
               $('#aboutText').focusout(function(){
                   if($('#aboutText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#aboutText').text(tempText);
                       $('#aboutText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#aboutText').attr('contentEditable',false);
                   }
              });
         }
    });
    
   
}

function AboutMeSender()
{
     var tempAboutMe =  $('#aboutText').text();
    var columnName = "about_us";

    $('#aboutHeader img').on("dblclick",function(){
          $('#aboutText').attr('contentEditable',false);
          //send aboutme to server here
          var newAboutMe =  $('#aboutText').text();
           processInputsAndSend(tempAboutMe, newAboutMe , columnName);
          
          
   });
}

function EditCuisins()
{
    var empty = '';
   var tempText = 'No Cuisine. Edit your Cuisine. Separate each Cuisine with a commer';
    $('#cuisineHeader img').click(function(){
         if(tempText.replace(/\s+/g, '')  ===  $('#cuisineText').text().replace(/\s+/g, ''))
         {
              $('#cuisineText').attr('contentEditable',true);
              $('#cuisineText').text('');
              $('#cuisineText').focus();
              $('#cuisineText').focusout(function(){
                   if($('#cuisineText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#cuisineText').text(tempText);
                       $('#cuisineText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#cuisineText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#cuisineText').attr('contentEditable',true);
               $('#cuisineText').focus();
               $('#cuisineText').focusout(function(){
                   if($('#cuisineText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#cuisineText').text(tempText);
                       $('#cuisineText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#cuisineText').attr('contentEditable',false);
                   }
              });
         }

    });
   
   
}



function cuisineSender()
{
    var erMessage = '';
    var maxLength = 300;
    var Tempcuisine = $('#cuisineText').text();
    var columnName = "cuisins";
    $('#cuisineHeader img').dblclick(function(){
        $('#cuisineText').attr('contentEditable',false);
        //send fav food to server here
      
        var newCuisine = $('#cuisineText').text();
        processInputsAndSend(Tempcuisine, newCuisine, columnName);
   });
}
function EditMostFood()
{
     var empty = '';
     var tempText = 'No Foods. Edit your Foods. Separate each Foods with a commer';
     
         $('#mostFoodHeader img').click(function(){
          if(tempText.replace(/\s+/g, '')  ===  $('#mostFoodText').text().replace(/\s+/g, ''))
         {
              $('#mostFoodText').attr('contentEditable',true);
              $('#mostFoodText').text('');
              $('#mostFoodText').focus();
              $('#mostFoodText').focusout(function(){
                   if($('#mostFoodText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#mostFoodText').text(tempText);
                       $('#mostFoodText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostFoodText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#mostFoodText').attr('contentEditable',true);
               $('#mostFoodText').focus();
               $('#mostFoodText').focusout(function(){
                   if($('#mostFoodText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#mostFoodText').text(tempText);
                       $('#mostFoodText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostFoodText').attr('contentEditable',false);
                   }
              });
         }
     });
     
}

function mostFoodSender()
{
    var erMessage = '';
    var maxLength = 300;
    var tempFavRest = $('#mostFoodText').text();
    var columnName = "food_specialty";
    
     $('#mostFoodHeader img').dblclick(function(){
         $('#mostFoodText').attr('contentEditable',false);
         //send fav restaurants to server here
         var newFavRest = $('#mostFoodText').text();
         processInputsAndSend(tempFavRest, newFavRest, columnName);
     });
}

function EditMostIngredient()
{
    var empty = '';
     var tempText = 'No Ingredients. Edit your Ingredients. Separate each Ingredients with a commer';
     
    $('#mostIngredientsHeader img').click(function(){
        if(tempText.replace(/\s+/g, '')  ===  $('#mostIngredientsText').text().replace(/\s+/g, ''))
         {
              $('#mostIngredientsText').attr('contentEditable',true);
              $('#mostIngredientsText').text('');
              $('#mostIngredientsText').focus();
              $('#mostIngredientsText').focusout(function(){
                   if($('#mostIngredientsText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#mostIngredientsText').text(tempText);
                       $('#mostIngredientsText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostIngredientsText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#mostIngredientsText').attr('contentEditable',true);
               $('#mostIngredientsText').focus();
               $('#mostIngredientsText').focusout(function(){
                   if($('#mostIngredientsText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#mostIngredientsText').text(tempText);
                       $('#mostIngredientsText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostIngredientsText').attr('contentEditable',false);
                   }
              });
         }
    });
    
    
}

function mostIngredientSender()
{
    var tempFavIngred = $('#mostIngredientsText').text();
    var columnName = "most_used_Ingrdient";
    
     $('#mostIngredientsHeader img').dblclick(function(){
          $('#mostIngredientsText').attr('contentEditable',false);
          //send fav ingredients to server here
          var newFavIngred = $('#mostIngredientsText').text();
          processInputsAndSend(tempFavIngred, newFavIngred , columnName);
     });
}

function EditMostRecipe()
{
   
    var empty = '';
     var tempText = 'No Recipes. Edit your Recipes. Separate each Recipes with a commer';
    $('#mostRecipesHeader img').click(function(){
        if(tempText.replace(/\s+/g, '')  ===  $('#mostRecipesText').text().replace(/\s+/g, ''))
         {
              $('#mostRecipesText').attr('contentEditable',true);
              $('#mostRecipesText').text('');
              $('#mostRecipesText').focus();
              $('#mostRecipesText').focusout(function(){
                   if($('#mostRecipesText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#mostRecipesText').text(tempText);
                       $('#mostRecipesText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostRecipesText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#mostRecipesText').attr('contentEditable',true);
               $('#mostRecipesText').focus();
               $('#mostRecipesText').focusout(function(){
                   if($('#mostRecipesText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#mostRecipesText').text(tempText);
                       $('#mostRecipesText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#mostRecipesText').attr('contentEditable',false);
                   }
              });
         }
    });
    
   
}

function mostRecipeSender()
{
     var tempFavRecipe = $('#mostRecipesText').text();
    var columnName = "most_used_recipe";
    
     $('#mostRecipesHeader img').dblclick(function(){
           $('#mostRecipesText').attr('contentEditable',false);
           //send fav rescipe to server here
           var newFavRecipe = $('#mostRecipesText').text()
           processInputsAndSend(tempFavRecipe, newFavRecipe, columnName);
    });
}

function sendResAboutInfoToServer(Text, column)
{
    $.ajax({
        url: JURL+"profile/sendResAboutInfoToServer",
        type: "POST",
        dataType: "json",
        data:{Text: Text, column: column},
        success: function(){
            
        }
    });
}


function processInputsAndSend(tempText, newText, columnName)
{
    var empty = '';
    var erMessage = '';
    var maxLength = 300;
   
    if(newText.length > maxLength)
    {
        //error Message
        erMessage = 'You have exceeded 300 words';
        alert(erMessage);
        $('#errorMessage').text(erMessage);
    }
    else if(newText.replace(/\s+/g, '') === empty)
    {
        erMessage = 'You are trying to send empty field';
        alert(erMessage);
         $('#errorMessage').text(erMessage);
    }
    else if(tempText !== newText)
    {

         sendResAboutInfoToServer(newText, columnName);
    }
 
}

function processLocationInputsAndSend(newText, columnName, maxLength)
{
    var empty = '';
    var erMessage = '';
   
 
    if(newText.length > maxLength)
    {
        //error Message
        erMessage = 'You have exceeded '+maxLength+' words';
          alert( erMessage);
        $('#errorMessage').text(erMessage);
    }
    else if(newText.replace(/\s+/g, '') === empty)
    {
        erMessage = 'You are trying to send empty field';
         $('#errorMessage').text(erMessage);
    }
    else 
    {
        
             sendResAboutInfoToServer(newText, columnName);
    }
 
}