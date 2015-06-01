

var TPSWITCHER = false;
var SHSWITCHER = false;
var GEOSWITCHER = false;
var TEMPINDEX ;
var tempTitle = '';
var countrySwitch = false;
var  ADDSHOWCOUNTER = 0;
$(document).ready(function(){
    eventUploader();
    hoverIngree();
    infinityScrollMyshow();
    infinityScrollViewShows();
    removeSearchHolderForCountry();
    removeSearchHolderBaseFood();
});

function getMyshows(){
    $.ajax({
        url: JURL+"cookWith/getMyshows",
        type: "POST",
        dataType: "json",
        data: {},
        success: function(data){
            $('#indicator').html('myshows');
            $('#showsHolder').html(data);
        }
    });
}

function creatShow(){
    $('#showsHolder').html('<form id="creatShowForm">\n\
                                <h2>Create Show</h2>\n\
                                <input id="showTitle" type="text" placeholder="show title"><br>\n\
                                <textarea id="showDesc" placeholder="show description" cols="55" rows="5"></textarea><br>\n\
                                <input onkeyup="searchCountry()" id="showCountry" type="text" placeholder="country origin">\n\
                                <input onkeyup="searchFood()" id="showFood" type="text" placeholder="food origin"><div id="showCFHolding"></div><br>\n\
                                <input id="showDate" type="date"> <input type="time" id="showTime">\n\
                                <input type="file" id="file" name="file">\n\
                                <img onclick="getRecipePic()" id="getShowPic" src="'+JURL+'pictures/camera.png" width="30" title="upload picture">\n\
                                <img onclick="invitesFriendsToEvent()" id="inviteUsers" src="'+JURL+'pictures/invite_user_icon.png" width="30" title="invite friends/followers">\n\
                                <span id="inviteCounter" title="number of people invited"></span>\n\
                                <div id="addIngreHolder">\n\
                                     <input class="ingreQty" type="text" placeholder="ingredient Qty">\n\
                                     <input class="ingre" type="text" placeholder="ingredient">\n\
                                    <button onclick="addIngredient()" type="button" class="addIngredientInp">+</button><br>\n\
                                </div>\n\
                                <div id="errMess"></div>\n\
                                <button id="cancelShow" type="button">cancel</button>\n\
                                <button onclick="processCreaetShow()" id="createShow" type="button">create show</button>\n\
                            </form>');
}

function getRecipePic()
  {
      $('input[type=file]').trigger('click');
      
      $('input[type=file]').change(function(){
          var recipePicBut = document.getElementById('getShowPic');
          
          recipePicBut.src = JURL+'pictures/camera_sel.png';
      });
  }

function addIngredient(){
    ADDSHOWCOUNTER++;
    $('#addIngreHolder').append(' <input class="ingreQty" type="text" placeholder="ingredient Qty">\n\
                                  <input class="ingre" type="text" placeholder="ingredient">\n\
                                  <button onclick="minusIngredient('+ FIELDCOUNTER +')" type="button" class="addIngredientInp">-</button><br>');
}

function minusIngredient(index){
   
      ADDSHOWCOUNTER--;

    var $ingrQty = document.getElementsByClassName('ingreQty');
    $($ingrQty).eq(index).remove();

     var $ingre = document.getElementsByClassName('ingre');
      $($ingre).eq(index).remove();
      
      var $Pcd = document.getElementsByClassName('addIngredientInp');
      $($Pcd).eq(index).remove();
}

function searchCountry(){
    var $countryInput = document.getElementById('showCountry');
    
    $('#searchResHolder').remove();
    var $dialog = document.getElementById('showCFHolding');
    $($dialog).append("<div id='searchResHolder'></div>");
    $('#searchResHolder').css({position: "absolute", left: "351px", top: "245px", "width": "175px"});
    
    var search_val = $($countryInput).val();
    $.post(JURL+"MakeRecipe/processRecipeOriginSearch", {recipeOrigin: search_val}, function(data){
          $('#searchResHolder').html(data);
    });
    
  
}
function searchFood(){
  
    var $countryInput = document.getElementById('showFood');
    $('#searchResHolder').remove();
     var $dialog = document.getElementById('showCFHolding');
      $($dialog).append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "531px", top: "245px", "width": "175px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"MakeRecipe/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
}

function collectValuBaseFood(food){
    var $baseFoodInput = document.getElementById('showFood');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}

function collectValuCountry(country){
    var $countryInput = document.getElementById('showCountry');
    $($countryInput).val(country);
     $('#searchResHolder').remove();
     countrySwitch = true;
 
}


function removeSearchHolderForCountry(){
    var $countryInput = document.getElementById('showCountry');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchResHolder') || $targt.is($countryInput) || $targt.is('.BaseFoodOrigin')){
               
             }
             else{
                   if(!countrySwitch){
                    $($countryInput).val('');
                    $('#searchResHolder').remove();
                  }
             }
    });
}

function removeSearchHolderBaseFood(){
    var $baseFoodInput = document.getElementById('showFood');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchResHolder') || $targt.is($baseFoodInput)){
               
             }
             else{
                  
                    $('#searchResHolder').remove();
             }
    });
}


function hoverIngree(){
       $('.DIIholder ul li.INGREE img').each(function(index){
              $('.DIIholder ul li.INGREE img').eq(index).hover(function(){
                    tempTitle =  $('.DIIholder ul li.INGREE img').eq(index).attr('title');
                      $('.DIIholder ul li.INGREE img').eq(index).attr('title', 'ingredients');
              }, function(){
                        $('.DIIholder ul li.INGREE img').eq(index).attr('title', tempTitle);
              });
       });
    
}

function tooltip(index){
    var height = 125;
        
         //on hover change title text
        //onclick show ingredients
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.DIIholder ul li.INGREE img').eq(index))){
                
            }else{
                    TPSWITCHER = false;
                    //$('.TOOLTIP').eq(index).html("");
                    $('.TOOLTIP.CW').eq(index).hide(500);
                    $('.TOOLTIPHOLDER.CW').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                     $('.TOOLTIP.CW').eq(index).hide();
                    $('.TOOLTIPHOLDER.CW').eq(index).hide();
                    $('.TOOLTIP.CW').eq(index).show();
                    $('.TOOLTIPHOLDER.CW').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDER.CW').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDER.CW');
                     
                    if(TP[index].scrollHeight > height){
                      
                        $('.TOOLTIPHOLDER.CW').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIP.CW').eq(index).show();
                    $('.TOOLTIPHOLDER.CW').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDER.CW').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDER.CW');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDER.CW').eq(index).css({"overflow-y": "scroll"});
                    }
                }
    
        

    
}



function showIVC(index, cookwith_id, cookwith_user_id){
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
        $('.TOOLTIP.IC').eq(index).show();
        $('.TOOLTIPHOLDER.IC').eq(index).show();
        $('.TOOLTIPHOLDER.IC').eq(index).html("<img id='SHLOADERIC' src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50'>");
        getinvitees(index, cookwith_id, cookwith_user_id);
    }
    
      $(document).click(function(event){
       var $targt = $(event.target);
            if($targt.is($('.DIIholder ul li.IVC img').eq(index))){
               
            }
            else{
          
                     SHSWITCHER = false;
                    //$('.TOOLTIP.IC').eq(index).html("");
                    $('.TOOLTIP.IC').eq(index).hide(500);
                    $('.TOOLTIPHOLDER.IC').eq(index).hide(500);
            }
   });
   
 
 }
 
 function getinvitees(index, cookwith_id, cookwith_user_id){
     $.ajax({
         url: JURL+"cookWith/getinvitees",
         type: "GET",
         dataType: "json",
         data: {cookwith_id: cookwith_id, cookwith_user_id: cookwith_user_id},
         success: function(data){
              $('.TOOLTIPHOLDER.IC img').eq(index).remove();
              $('.TOOLTIPHOLDER.IC').eq(index).html(data);
         }
     });
 }
 
 
 function asktojoin(index, cookwith_id){
     $('.asktojoin img').eq(index).remove();
     $('.asktojoin').eq(index).append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='15'>");
     var notifierIndex = 14;
     $.ajax({
         url: JURL+"cookWith/joinshowRequest",
         type: "POST",
         dataType: "json",
         data: {cookwith_id: cookwith_id},
         success: function(data){
              $('.asktojoin img').eq(index).remove();
             if(data !== false && data !== true){
                 $('.DIIholder ul li.IVC span').eq(index).html(data);
                 sendAskjoinNotification(notifierIndex, cookwith_id);
             }
         }
     });
 }
 
 function sendAskjoinNotification(notifierIndex, cookwith_id){
     $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: cookwith_id, index: notifierIndex},
        success: function(data){
            
        }
    });
    
 }
 
 function changeStatus(status, index){
     var request = "Requesting";
     var accept = "Accepted";
   
     if(status === request){
         $('.ICuserType span').eq(index).html('Accept');
          $('.ICuserType span').eq(index).css({"text-decoration": "underline"});
     }
     
     if(status === accept){
         $('.ICuserType span').eq(index).html('Decline');
         $('.ICuserType span').eq(index).css({"text-decoration": "underline"});
     }
 }
 
 function unchangeStatus(status, index){
       $('.ICuserType span').eq(index).html(status);
          $('.ICuserType span').eq(index).css({"text-decoration": "none"});
 }
 
 function sendChangStatusRequest(status, cookwith_id, user_id, index){
     var stat = '';
     var accept = "ACCEPTED";
     var declined = "DECLINED";
     
     var request = "Requesting";
     var decline = "Declined";
     
     if(status === request){
         stat = accept;
     }else if(status === decline){
         stat = declined;
     }
     
     $.ajax({
         url: JURL+"cookWith/sendChangStatusRequest",
         type: "POST",
         dataType: "json",
         data: {status: stat, cookwith_id: cookwith_id, user_id: user_id},
         success: function(data){
            $('.ICuserType span').eq(index).html(data);  
         }
     });
 }
 
function infinityScrollViewShows(){
    var prev = 1;
    var next = 1;
    var pages = 0;
    var Default = "default";

    $(window).scroll(function(){
                
        if($(window).scrollTop() === $(document).height() - $(window).height())
        {
          
            if(getWhichSideBarOptionToRun() === Default)
            {
                $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                $('#postload').css({"width": "50px"});
                    pages = pages + 6;
                   $.get(""+JURL+"cookWith/infinityScrollViewShows", {page: pages}, function(data){
        
                          $("#postload").empty();
                          $("#showsHolder").append(data);

                   }, 'json');
            }
        }
    });
} 

function infinityScrollMyshow(){
    var prev = 1;
    var next = 1;
    var pages = 0;
     var myshow = "myshows";
    $(window).scroll(function(){
                
        if($(window).scrollTop() === $(document).height() - $(window).height()){
             if(getWhichSideBarOptionToRun() === myshow){
                $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                $('#postload').css({"width": "50px"});
                    pages = pages + 6;
                   $.get(""+JURL+"cookWith/infinityScrollMyshow", {page: pages}, function(data){
        
                          $("#postload").empty();
                          $("#showsHolder").append(data);

                   }, 'json');
             }
        }
    });
}


function getWhichSideBarOptionToRun(){
    var Default = "default";
    var myshow = "myshows";
    
    var which = $('#indicator').text();
    //alert(which);
    if(which === Default){
        return Default;
    }else if(which === myshow){
        return myshow;
    }
}







