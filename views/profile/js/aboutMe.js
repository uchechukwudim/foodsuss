/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

});

function getProfileAbouteMe()
{
    $('#which_active').html('ABU');
    $('#P_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_aboutme').css({"background": "#F4716A", "color":"white"});
    $('#P_followers').css({"background": "#EFEFEF", "color":"grey"});
    
     $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $.ajax({
        url: ""+JURL+"profile/AboutMe",
        type: "GET",
        dataType: "json",
        success: function(data){
            $('#AjaximageLoader').remove();
            //$('#LOAD').html("");
            $('#LOAD').html(data);
         
             appendEditPen();
             favouritePen();
             AboutMeSender();
             favFoodSender();
             FavRestaurantSender();
             favIngredientSender();
             favRecipeSender();
           
     
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
              $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
        }
        
    });
}


function getUserProfileAbouteMe(userId)
{
    $('#which_active').html('UABU');
    $('#U_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_aboutme').css({"background": "orangered", "color":"white"});
    $('#U_followers').css({"background": "#EFEFEF", "color":"grey"});
    
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
     $('#AjaximageLoader').css({postion: "relative", left: "300px"});
    $.ajax({
        url: ""+JURL+"profile/AboutMe",
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
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
              $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
        }
        
    });
}

function getRestaurantProfileAbouteMe(user_type)
{
     $('#which_active').html('RABU');
    $('#U_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_aboutme').css({"background": "orangered", "color":"white"});
    $('#U_followers').css({"background": "#EFEFEF", "color":"grey"});
    
     $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $.ajax({
        url: ""+JURL+"profile/AboutMe",
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
             favFoodSender();
             FavRestaurantSender();
             favIngredientSender();
             favRecipeSender();
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
        }
        
    });
}


function initialize() {
  var mapOptions = {
    zoom: 6
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'Location found using HTML5.'
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}
// google.maps.event.addDomListener(window, "click", initialize);



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
        $('#address').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="addressSendder()" title="'+editImageTitle+'">');
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
      $('#currentLocation').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="currentLocationSender()" title="'+editImageTitle+'">');
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
      $('#FromLoc').append('<img src="'+JURL+'pictures/profile/pen_edit.png" width="10" height="10" ondblclick="FromLocSender()" title="'+editImageTitle+'">');
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
     $('#favFood').hover(function(){
         $('#favFood').css({"cursor":"pointer"});
      $('#favFoodHeader img').show();
      
      //edit Fav rest method here
      EditFavFood();
      
    },
    function(){
          $('#favFoodHeader img').hide();
    });
    
   

    //favRest
    $('#favRestuarant').hover(function(){
         $('#favRestuarant').css({"cursor":"pointer"});
      $('#favRestuarantHeader img').show();
      
      //edit Fav rest method here
      EditFavRestaurant();
      
    },
    function(){
          $('#favRestuarantHeader img').hide();
    });
    
    //fav ingredient
    $('#favIngredients').hover(function(){
         $('#favIngredients').css({"cursor":"pointer"});
      $('#favIngredientsHeader img').show();
      
      //edit fav ingredients method here
      EditFavIngredient();
    },
    function(){
         $('#favIngredientsHeader img').hide();
    });
    
    //fav recipe
    $('#favRecipes').hover(function(){
           $('#favRecipes').css({"cursor":"pointer"});
      $('#favRecipesHeader img').show();
      
      //edit fav recipe method here
      EditFavRecipe();
    },
    function(){
         $('#favRecipesHeader img').hide();
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

    var columnName = "Mobile";
    var maxLength = 13;
             //send to database and save
              $('#Mh').attr('contentEditable',false);
              //send data to server here
               var mNumber = $('#Mh').text();
           
               if(tempMobile !== mNumber)
               {
           
                     processLocationInputsAndSend(mNumber, columnName, maxLength);
                 
               }
}

function EditLocationAddress()
{

     $('#address  img').click(function(){
         $('#Ah').attr('contentEditable',true);
         $('#Ah').focus();
         
     });
     
}

function addressSendder()
{

    var columnName = "address";
    var maxLength = 50;
             //send to database and save
             $('#Ah').attr('contentEditable',false);
              //send address to server here
             var newAddress =  $('#Ah').text();
             processLocationInputsAndSend(newAddress, columnName, maxLength);
             
 
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
    var columnName = "city";
    var maxLength= 30;
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
    var columnName = "town";
    var maxLength = 30;
             //send to database and save
              $('#Fmh').attr('contentEditable',false);
              //send where your from to server here
              var newFromLoc = $('#Fmh').text();
            processLocationInputsAndSend(newFromLoc, columnName, maxLength);
               
              
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
   var tempText = 'No About Me. Edit your About Me.';
   

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
    var columnName = "About_me";

    $('#aboutHeader img').on("dblclick",function(){
          $('#aboutText').attr('contentEditable',false);
          //send aboutme to server here
          var newAboutMe =  $('#aboutText').text();
           processInputsAndSend(tempAboutMe , newAboutMe , columnName);
        
          
   });
}

function EditFavFood()
{
   var empty = '';
   var tempText = 'No Favorite Food. Edit your Favorite food.';
   
    $('#favFoodHeader img').click(function(){
     
        if(tempText.replace(/\s+/g, '')  ===  $('#favFoodText').text().replace(/\s+/g, ''))
         {
               
              $('#favFoodText').attr('contentEditable',true);
              $('#favFoodText').text('');
              $('#favFoodText').focus();
              $('#favFoodText').focusout(function(){
                  
                   if($('#favFoodText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#favFoodText').text(tempText);
                       $('#favFoodText').attr('contentEditable',false);
                   }
                   else
                   {
                      
                       $('#favFoodText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#favFoodText').attr('contentEditable',true);
               $('#favFoodText').focus();
               $('#favFoodText').focusout(function(){
                  
                   if($('#favFoodText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#favFoodText').text(tempText);
                       $('#favFoodText').attr('contentEditable',false);
                   }
                   else
                   {
                      
                       $('#favFoodText').attr('contentEditable',false);
                   }
              });
         }
    });
   
   
}

function favFoodSender()
{
     var tempFavFood = $('#favFoodText').text();
    var columnName = "favorite_foods";
    $('#favFoodHeader img').dblclick(function(){
        $('#favFoodText').attr('contentEditable',false);
        //send fav food to server here
        var newFavFood = $('#favFoodText').text();
        processInputsAndSend(tempFavFood, newFavFood , columnName);
      
   });
}
function EditFavRestaurant()
{
    var empty = '';
   var tempText = 'No Favorite Restaurants. Edit your Favorite Restaurants.';
     $('#favRestuarantHeader img').click(function(){
        
          
        if(tempText.replace(/\s+/g, '')  ===  $('#favRestuaranText').text().replace(/\s+/g, ''))
         {
              $('#favRestuaranText').attr('contentEditable',true);
              $('#favRestuaranText').text('');
              $('#favRestuaranText').focus();
              $('#favRestuaranText').focusout(function(){
                   if($('#favRestuaranText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#favRestuaranText').text(tempText);
                       $('#favRestuaranText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favRestuaranText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#favRestuaranText').attr('contentEditable',true);
               $('#favRestuaranText').focus();
                $('#favRestuaranText').focusout(function(){
                   if($('#favRestuaranText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#favRestuaranText').text(tempText);
                       $('#favRestuaranText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favRestuaranText').attr('contentEditable',false);
                   }
              });
         }
     });
     
}

function FavRestaurantSender()
{
    var tempFavRest = $('#favRestuaranText').text();
    var columnName = "favorite_restaurant";
    
     $('#favRestuarantHeader img').dblclick(function(){
         $('#favRestuaranText').attr('contentEditable',false);
         //send fav restaurants to server here
         var newFavRest = $('#favRestuaranText').text();
         processInputsAndSend(tempFavRest, newFavRest, columnName);
        
     });
}

function EditFavIngredient()
{
   var empty = '';
   var tempText = 'No Favorite Ingredients. Edit your Favorite Ingredients.';
   
    $('#favIngredientsHeader img').click(function(){
      
        
         if(tempText.replace(/\s+/g, '')  ===  $('#favIngredientsText').text().replace(/\s+/g, ''))
         {
              $('#favIngredientsText').attr('contentEditable',true);
              $('#favIngredientsText').text('');
              $('#favIngredientsText').focus();
              $('#favIngredientsText').focusout(function(){
                   if($('#favIngredientsText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#favIngredientsText').text(tempText);
                       $('#favIngredientsText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favIngredientsText').attr('contentEditable',false);
                   }
              });
         }
         else
         {
              $('#favIngredientsText').attr('contentEditable',true);
               $('#favIngredientsText').focus();
               $('#favIngredientsText').focusout(function(){
                   if($('#favIngredientsText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#favIngredientsText').text(tempText);
                       $('#favIngredientsText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favIngredientsText').attr('contentEditable',false);
                   }
              });
         }
    });
    
    
}

function favIngredientSender()
{
 
   
    var tempFavIngred = $('#favIngredientsText').text();
    var columnName = "favorite_ingredient";
    
     $('#favIngredientsHeader img').dblclick(function(){
          $('#favIngredientsText').attr('contentEditable',false);
          //send fav ingredients to server here
          var newFavIngred = $('#favIngredientsText').text();
           processInputsAndSend(tempFavIngred, newFavIngred, columnName);
         
     });
}

function EditFavRecipe()
{
   var empty = '';
   var tempText = 'No Favorite Recipes. Edit your Favorite Recipes.';
   
    $('#favRecipesHeader img').click(function(){
        $('#favRecipesText').attr('contentEditable',true);
        $('#favRecipesText').focus();
        
         if(tempText.replace(/\s+/g, '')  ===  $('#favRecipesText').text().replace(/\s+/g, ''))
         {
              $('#favRecipesText').attr('contentEditable',true);
              $('#favRecipesText').text('');
              $('#favRecipesText').focus();
              $('#favRecipesText').focusout(function(){
                   if($('#favRecipesText').text().replace(/\s+/g, '') === empty)
                   {
                       //$('#favRecipesText').text(tempText);
                       $('#favRecipesText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favRecipesText').attr('contentEditable',false);
                   }
              });
         }else{
              $('#favRecipesText').attr('contentEditable',true);
               $('#favRecipesText').focus();
               $('#favRecipesText').focusout(function(){
                   if($('#favRecipesText').text().replace(/\s+/g, '') === empty)
                   {
                       $('#favRecipesText').text(tempText);
                       $('#favRecipesText').attr('contentEditable',false);
                   }
                   else
                   {
                       $('#favRecipesText').attr('contentEditable',false);
                   }
              });
         }
    });
    
   
}

function favRecipeSender()
{
     var tempFavRecipe = $('#favRecipesText').text();
    var columnName = "favorite_recipes";
    
     $('#favRecipesHeader img').dblclick(function(){
           $('#favRecipesText').attr('contentEditable',false);
           //send fav rescipe to server here
           var newFavRecipe = $('#favRecipesText').text();
           processInputsAndSend(tempFavRecipe, newFavRecipe, columnName);
          
    });
}

function sendLocationInfoToServer(Text, column)
{
    $.ajax({
        url: ""+JURL+"profile/sendLocationInfoToServer",
        type: "POST",
        dataType: "json",
        data:{Text: Text, column: column},
        success: function(){
            
        },
        error:function(){
            
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
    
         $('#errorMessage').text(erMessage);
    }
    else if(tempText !== newText)
    {

         sendLocationInfoToServer(newText, columnName);
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
        
              sendLocationInfoToServer(newText, columnName);
    }
 
}