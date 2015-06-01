/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
 
   
});


function invitesFriendsToEvent(){

  
        $('#eventInvitesLoglayer').show();
        $('#eventInvitesLogdialog').show();
        
        $('#eventInvitesLogdialog').css({"width":"500px"});
        $('#friendsHolder').html('<img src="'+JURL+'pictures/events/profile_ajax-loader.gif" width="50" height="50">');
        $('#friendsHolder img').css({position: "relative", left: "230px"});
        getFriendForInvites();
   
    
    
}

function getFriendForInvites(){
    $.ajax({
        url:""+JURL+"events/getFriends",
        type: "POST",
        dataType: "json",
        data: {},
        success:function(data){
            $('#friendsHolder img').remove();
            $('#friendsHolder').html(data);
            cancelInvites();
        }
    });
}

function cancelInvites(){
    $('#cancelInvite').click(function(){
      $('#eventInvitesLoglayer').hide();
        $('#eventInvitesLogdialog').hide();
    });
}

function invite(friendsCount){
    var friends = new Array();
    var Fcount = 0;
    for(var looper=0; looper <= friendsCount-1; looper++)
    {
        var ischecked = $('.inviteCheckBox').eq(looper).is(':checked');
        
        if(ischecked)
        {
            friends[looper] = $('.inviteCheckBox').eq(looper).attr('name').replace(/\s+/g, '');
            Fcount++;
        }
       
    }
 
  
    $('#inviteCounter').html(Fcount+" Invited");
    $('#inviteCounter').attr('name', JSON.stringify(friends));
    $('#inviteCounter').attr('title', Fcount);
    $('#eventInvitesLogdialog').hide();
    $('#eventInvitesLoglayer').hide();
}






function processCreaetShow(){
   showErrorImageMessage("");
    var currentDate = new Date();
    var showTitle = $('#showTitle').val();
    var showDescription = $('#showDesc').val();
    var foodOrigin = $('#showFood').val();
    var countryOrigin = $('#showCountry').val();
    var showDate = $('#showDate').val();
    var showTime =  $('#showTime').val();
    var eventImage = $('#file').val();
     
    var eventYear = getYearFromShowDate(showDate);
    var eventMonth = getMonthFromShowDate(showDate);
    var eventDay = parseInt(getDayFromShowDate(showDate));
     
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth()+1;
    var currentDay = currentDate.getDate();
   
   
    var eventHour = getHourFromShowTime(showTime);
    var currentHour = currentDate.getHours();
   
    var invites = new Array();
    var erMessage = '';

   if(showTitle === EMPTY || showDescription === EMPTY || foodOrigin === EMPTY || countryOrigin === EMPTY || eventImage === EMPTY){
           erMessage = "All fileds have to be filled";
              showErrorImageMessage(erMessage);
   }
   else if(eventYear < currentYear)
   {
       //error message
       erMessage = "event year can't be a past year";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear === currentYear && eventMonth < currentMonth)
   {
       //error message
       erMessage = "event month can't be a past month";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear === currentYear && eventMonth === currentMonth && eventDay < currentDay){
       //error message
       erMessage = "event day cant be a past day";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear === currentYear && eventMonth === currentMonth && eventDay === currentDay && (eventHour < currentHour || currentHour == 0 && eventHour >13))
   {
       //error
       erMessage = "event time cant be a past time";
       showErrorImageMessage(erMessage);
   }else if(!processIngredient()){
       erMessage = "there has to be at list one ingredient added";
       showErrorImageMessage(erMessage);
   }else{
       var ingredients = JSON.stringify(processIngredient());
       var invitees = $('#inviteCounter').attr('name');
       sendCreateShowRequest(showTitle, showDescription, foodOrigin, countryOrigin, showDate, showTime, ingredients, invitees);
   }

}    

function sendCreateShowRequest(showTitle, showDescription, foodOrigin, countryOrigin, showDate, showTime, ingredients, invitees){
    
    $('#file').upload(JURL+"cookWith/processShowEvent", {showTitle: showTitle, showDescription: showDescription, foodOrigin: foodOrigin, countryOrigin: countryOrigin, showDate: showDate, showTime: showTime, ingredients: ingredients, invitees: invitees},
        function(success)
        {
             resetShow();
         
        },
        function(progress)
        {
            
        }
        );
}

function getYearFromShowDate(eventDate){
    var year = new String(eventDate);
    return parseInt(year.charAt(0)+""+year.charAt(1)+""+year.charAt(2)+""+year.charAt(3));
}

function getMonthFromShowDate(eventDate){
    var month = new String(eventDate);
    return parseInt(month.charAt(5)+""+month.charAt(6));
}

function getDayFromShowDate(eventDate){
    var day = new String(eventDate);
    return parseInt(day.charAt(8)+""+day.charAt(9));
}



function getHourFromShowTime(eventTime){
   var hour = new String(eventTime);
   return parseInt(hour.charAt(0)+""+hour.charAt(1));
}

function  showErrorImageMessage(message){
    $('#errMess').html(message);
}

function processIngredient(){
    var $ingreQty = document.getElementsByClassName('ingreQty');
    var $ingredient = document.getElementsByClassName('ingre');
    var Ingre = {};
  var message = '';
     for(var looper =0; looper < $($ingreQty).size(); looper++){
         
         if($($ingreQty).eq(looper).val() === EMPTY || $($ingredient).eq(looper).val() === EMPTY){
             return false;
         }else{
           if($($ingreQty).eq(looper).val().length < 2 || $($ingredient).eq(looper).val().length < 2){
               message = 'Ingredient Qty and Ingredient has to be more than 2 letters';
              createAndShowErrorMessage(message);
           }
           else {

                Ingre[looper] = { 
                Qty: "<span class='ingrQty'>"+$($ingreQty).eq(looper).val()+"</span>",
                ingredient: "<span class='ingre'>"+$($ingredient).eq(looper).val()+"</span>"
            };
                  
           }
            
           
         }
     }
    
     return Ingre;
}


