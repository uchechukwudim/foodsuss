/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var TPSWITCHER = false;
var SHSWITCHER = false;
var GEOSWITCHER = false;
var TEMPINDEX ;
var tempTitle ='';

$(document).ready(function(){

hoverIngre();
getFriendSuggestion();
//alert($('#adds').width());
});


function hideShowSettings()
{
  
        $('ul#Navsetting li ul').show();
        $('ul#Navsetting li span').show();
 
    
    $(document).click(function(event){
        var $targt = $(event.target);
        
        if($targt.is('ul#Navsetting li ul') || $targt.is('ul#Navsetting ul li') || $targt.is('ul#Navsetting li img'))
        {
            
        }
        else
        {
             $('ul#Navsetting li ul').hide();
               $('ul#Navsetting li span').hide();
        }
    });
}

function off()
{
    $('ul#Navsetting li ul').hide();
}

function hoverIngre(){
       $('.post_profile_link ul li.INGRE img').each(function(index){
                $('.post_profile_link ul li.INGRE img').eq(index).hover(function(){
                tempTitle = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                $('.post_profile_link ul li.INGRE img').eq(index).attr('title', 'ingredients');
            },function(){
                $('.post_profile_link ul li.INGRE img').eq(index).attr('title', tempTitle);
            });
       });
    
}

function tooltip(index){
    var height = 125;

   // $('.TOOLTIP').eq(index).append("<b>INGREDIENTS</b><br>");
  
  
        
        //on hover change title text
  
            
            //onclick show ingredients
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.post_profile_link ul li.INGRE img').eq(index)) || $targt.is('#recipeFunHolder ul li.INGRE img')){
               
            }
            else{
                    TPSWITCHER = false;
                    //$('.TOOLTIP').eq(index).html("");
                    $('.TOOLTIP').eq(index).hide(500);
                    $('.TOOLTIPHOLDER').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                     $('.TOOLTIP').eq(index).hide();
                    $('.TOOLTIPHOLDER').eq(index).hide();
                    $('.TOOLTIP').eq(index).show();
                    $('.TOOLTIPHOLDER').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDER').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDER');
                     
                    if(TP[index].scrollHeight > height){
                      
                        $('.TOOLTIPHOLDER').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIP').eq(index).show();
                    $('.TOOLTIPHOLDER').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDER').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDER');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDER').eq(index).css({"overflow-y": "scroll"});
                    }
                }
    
        

    
}

function inifityScroltooltip(index){
        var height = 150;
        var   tempTitle;
      //$('.TOOLTIP').eq(index).append("<b>INGREDIENTS</b><br>");
      
        //on hover change title text
      $('.post_profile_link ul li.INGRE img').eq(index).hover(function(){
            tempTitle = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
            $('.post_profile_link ul li.INGRE img').eq(index).attr('title', 'ingredients');
        },function(){
            $('.post_profile_link ul li.INGRE img').eq(index).attr('title', tempTitle);
        });

            //onclick show ingredients
        
        
        $('.post_profile_link ul li.INGRE img').eq(index).click(function(){
         
    
           if(TPSWITCHER){
                  
              
                     $('.TOOLTIP').eq(index).hide();
                    $('.TOOLTIPHOLDER').eq(index).hide();
                    $('.TOOLTIP').eq(index).show();
                    $('.TOOLTIPHOLDER').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDER').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDER');
 
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDER').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                   
                    TPSWITCHER = true;
                    $('.TOOLTIP').eq(index).show();
                    $('.TOOLTIPHOLDER').eq(index).html( tempTitle);
                    $('.TOOLTIPHOLDER').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    
                    var TP = $('.TOOLTIPHOLDER');

                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDER').eq(index).css({"overflow-y": "scroll"});
                    }
                }
             
        });
        
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.post_profile_link ul li.INGRE img').eq(index))){
               
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIP').eq(index).hide(500);
                    $('.TOOLTIPHOLDER').eq(index).hide(500);
            }
        });
}

function isScrolledIntoView(elem)
{
    var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();
    return docViewTop - elemTop ;
    if(elemTop >= docViewTop+20){
        //return elemTop+" "+docViewTop+" up";
    }else if(elemBottom <= docViewBottom+20)
    {
       // return elemBottom+" "+docViewBottom+" down"
    }
    //return ((elemBottom <= docViewBottom+20) && (elemTop >= docViewTop+20));
}

function showShops(index, country_id){
    //get current city
    
    if(SHSWITCHER){
        if(TEMPINDEX !== index ){
           
             SHSWITCHER = false;
             TEMPINDEX = index;
             
        }else{
           
        }
   
    }
    else{
         
         SHSWITCHER = true;
        $('.TOOLTIPShc').eq(index).show();
        $('.TOOLTIPHOLDERShc').eq(index).show();
        $('.TOOLTIPHOLDERShc').eq(index).html("<img id='SHLOADER' src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50'>");
        getLocation(index, country_id);
    }
    
      $(document).click(function(event){
       var $targt = $(event.target);
            if($targt.is($('.post_profile_link ul.recipeNav li.ShpCt img').eq(index))){
               
            }
            else{
          
                     SHSWITCHER = false;
                    $('.TOOLTIPShc').eq(index).html("");
                    $('.TOOLTIPShc').eq(index).hide(500);
                    $('.TOOLTIPHOLDERShc').eq(index).hide(500);
            }
   });
   
 
 }
function getLocation(index, country_id) {
    var latlng = new Array();
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
             latlng = new Array(position.coords.latitude, position.coords.longitude);
                getUserCurrentCityWithIpAddress(index, country_id, latlng);
        });
    } else { 
       
    }

}


function getUserCurrentCityWithIpAddress(index, country_id, latlng){
  
    $.get("https://maps.googleapis.com/maps/api/geocode/json?latlng="+latlng[0]+","+latlng[1]+"&key=AIzaSyATqukgypXfCIXhRgHQ_LJQFaZwG6naZyw", function (response) {
        
           var city = response['results'][0]["address_components"][3]["long_name"];
            getUserRegisteredCity(index, city, country_id);
 
    }, "json");
  
}

function getUserRegisteredCity(index, currentCity, country_id){
   
    $.get(JURL+'home/getUserRegCity', function(response){
        
        getShopsCity(index, currentCity, response, country_id);
    });
 
}

function getShopsCity(index, currentCity, regCity, country_id){
    var tempCurCity = currentCity.replace(/\s+/g, '');
    var tempUserMainCity = regCity.replace(/\s+/g, ''); 
  
   if(tempCurCity === tempUserMainCity){
       searchShops(index, regCity, country_id);
   }else{
       $('.TOOLTIPHOLDERShc').eq(index).html('<div style="margin-left: 20px;" id="TextQues"><b>Do you want to use your currenct location to search for shops</b></div>\n\
                                                \n\
                                              <button id="YesBut">Yes</button><button  id="NoBut">No</button>');
        $('#YesBut').click(function(){
             $('.TOOLTIPHOLDERShc').eq(index).html("<img id='SHLOADER' src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50'>");
            searchShops(index, currentCity, country_id);
            return false;
        });
        
        $('#NoBut').click(function(){
             $('.TOOLTIPHOLDERShc').eq(index).html("<img id='SHLOADER' src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50'>");
            searchShops(index, regCity, country_id);
             return false;
        });
   }
     
}

function searchShops(index, city, country_id){
        AjaxSearch(index, city, country_id);

}

function AjaxSearch(index, city, country_id){
     var height = 150;
    $.ajax({
        url: JURL+"home/searchForShops",
        type: "GET",
        dataType: "json",
        data:{city: city.replace(/\s+/g, ''), country_id: country_id},
        success: function(data){
        
              $('.TOOLTIPShc').eq(index).append("<b>Food Shops</b><br>");
               $('.TOOLTIPHOLDERShc').eq(index).html(data);
                var TP = $('.TOOLTIPHOLDERShc');
               if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERShc').eq(index).css({"overflow-y": "scroll"});
                          $('.TOOLTIPHOLDERShc').eq(index).css({"overflow-x": "hidden"});
                    }
                  SHSWITCHER = true;
        }
       
    });
     
}

function getNotificatioinCount(){
     $.ajax({
        url: JURL+"notifier/getNotificatioinCount",
        type: "GET",
        dataType: "json",
        success: function(data){
            if(data !== 0){
                 $('#notifAlertCircle').css({"display":"block"});
                $('#notifAlertCircle').html(data);
            }
           
            
            
        }
       
    });
}

function createShowImageENDialogBox(recipe_id){
   
  
    var tableName = "recipes";
    var imageColumName = "recipe_photo";
    var imageIdName = "recipe_id";
     $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="imagedialog is-fixed">\n\
                      <div id="imageclose">| x |</div>\n\
                      <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                      <div id="holdImage"><img id ="img1" src=""></div>\n\
                      <div id="imageholdComment"></div>\n\
                      </div>\n\
                    </div>');
     document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+recipe_id+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
   $('#imagelayer').show();
     $('.imagedialog').show();
   closeShowImageEND();
}


function closeShowImageEND(){
    $('#imageclose').click(function(){
        $('#imagelayer').remove();
        //$('.imagedialog.is-fixed').hide();
        $('.imagedialog').remove();
    });
}

 function getFriendSuggestion(){
     $.ajax({
         url: JURL+"Suggestusers",
         type: "GET",
         dataType: "json",
         success:function(data){
           $('#peopleYouMayKnow').html(data);
         }
     });
 }
 
 
 function inifityScroltooltipNut(index){
        var height = 125;
        var   tempTitle;
        $('.TOOLTIPNut').eq(index).append("<b>NUTRIENTS</b><br>");

        //on hover change title text
      $('.OtherCountryNuterients ul li.Nutr').eq(index).hover(function(){
            tempTitle = $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title');
            $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', 'ingredients');
        },function(){
            $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', tempTitle);
        });

            //onclick show ingredients
        
        
        $('.OtherCountryNuterients ul li.Nutr').eq(index).click(function(){
          
           if(TPSWITCHER){
                  
                 
                     $('.TOOLTIPNut').eq(index).hide();
                    $('.TOOLTIPHOLDERNut').eq(index).hide();
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');
 
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');

                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }
             
        });
        
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Nutr').eq(index))){
               
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPNut').eq(index).hide(500);
                    $('.TOOLTIPHOLDERNut').eq(index).hide(500);
            }
        });
}


function inifityScroltooltipCont(index){
        var height = 125;
        var   tempTitle;
        $('.TOOLTIPCont').eq(index).append("<b>COUNTRIES</b><br>");

        //on hover change title text
      $('.OtherCountryNuterients ul li.Count').eq(index).hover(function(){
            tempTitle = $('.OtherCountryNuterients ul li.Count').eq(index).attr('title');
            $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', 'other countries that eat this food');
        },function(){
            $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', tempTitle);
        });

            //onclick show ingredients
        
        
        $('.OtherCountryNuterients ul li.Count').eq(index).click(function(){
          
           if(TPSWITCHER){
                  
                 
                     $('.TOOLTIPCont').eq(index).hide();
                    $('.TOOLTIPHOLDERCont').eq(index).hide();
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDERCont');
 
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDERCont');

                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }
             
        });
        
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Count').eq(index))){
               
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPCont').eq(index).hide(500);
                    $('.TOOLTIPHOLDERCont').eq(index).hide(500);
            }
        });
}


 
 var newwindow;
function poptastic(url)
{
	newwindow=window.open(url,'name','height=450,width=600, left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,status=yes');
	if (window.focus) {
            newwindow.focus();
      
        }
}


function showHomeRecipeImage(imageId)
{

  var tableName = "recipe_post";
   var imageColumName = "recipe_photo";
   var imageIdName = "recipe_post_id";
   $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="imagedialog is-fixed">\n\
                      <div id="imageclose">| x |</div>\n\
                      <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                      <div id="holdImage"><img id ="img1" src=""></div>\n\
                      <div id="imageholdComment"></div>\n\
                      </div>\n\
                    </div>');

     document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+imageId+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
     $('#imagelayer').show();
     $('.imagedialog').show();
      closeImageReciepieDialog();
}


function showProfileRecipeImage(imageId)
{
          //$(document).scrollTop(0);
   document.getElementById('img1').src = ""+JURL+"pictures/general_smal_ajax-loader.gif";
   $('html').css({"overflow-y":"hidden"});
   var tableName = "recipe_post";
   var imageColumName = "recipe_photo";
   var imageIdName = "recipe_post_id";
   $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="imagedialog is-fixed">\n\
                      <div id="imageclose">| x |</div>\n\
                      <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                      <div id="holdImage"><img id ="img1" src=""></div>\n\
                      <div id="imageholdComment"></div>\n\
                      </div>\n\
                    </div>');
   
     document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+imageId+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
      $('#imagelayer').show();
     $('.imagedialog').show();
      closeImageReciepieDialog();
 
}

 function closeImageReciepieDialog()
 {
     $('#imageclose').click(function(){
     $('#imagelayer').remove();
     $('.imagedialog').remove();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#imagelayer').remove();
                $('.imagedialog').remove();
           }
     });
 }
 


 
 function hideReciepieImageDialogOnLoad()
 {
      $('html').css({"overflow-y":"visible"});
     $('#imagelayer').hide();
     $('.imagedialog').hide();
 }