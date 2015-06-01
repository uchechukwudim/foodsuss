/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var NOTIFSWITCHER = false;
$(document).ready(function(){

});

function OnOff()
{

     $('#notificationResult').show();
     $('#notification span').show();
     $('#updateInfo').css({"z-index": "0"});
     $('#updateCover').css({"z-index": "0"});
       $('#friendshipUpdate').css({"z-index": "0"});
    $(document).click(function(event){
        var $tagt =  $(event.target);
        
        if($tagt.is('#notificationResult') || $tagt.is('#notification #apple img')){}
        else{
            NOTIFSWITCHER = false;
              $('#notification span').hide();
              $('#notificationResult').hide();
              $('#updateInfo').css({"z-index": "1"});
              $('#updateCover').css({"z-index": "1"});
              $('#friendshipUpdate').css({"z-index": "1"});
            }
     });
        
}

function getNotification(){
     $('#notifAlertCircle').css({"display":"none"});
  if(!NOTIFSWITCHER)  {
      NOTIFSWITCHER = true;
        $('#notifResultHolder').html("<img id='NOTIFLOADER' src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50' height='50'>");
        $('#NOTIFLOADER').css({position:"relative", left:"170px", top: "60px"});

       $.ajax({
           url: JURL+"notifier/getNotification",
           type: "GET",
           dataTyp: "json",
           data: {},
           success:function(data){
               $('#notifResultHolder').html(data);
           }

       });
    }
}

function showNotifRecipeImage(imageId)
{

     //$(document).scrollTop(0);
          $('html').css({"overflow-y":"hidden"});
  var tableName = "recipe_post";
   var imageColumName = "recipe_photo";
   var imageIdName = "recipe_post_id";
   $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div id="imagedialog">\n\
                    <div id="imageclose">| x |</div>\n\
                    <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                    <div id="holdImage"><img id ="img1" src="" width="600" height="440"></div>\n\
                    <div id="imageholdComment"></div>\n\
                    </div>');

     document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+imageId+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
     $('#imagelayer').show();
     $('#imagedialog').show();
      closeImageReciepieDialog();
}