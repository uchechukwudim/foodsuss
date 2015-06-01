/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var EMPTY = '';
$(document).ready(function(){
    ChangeNav();
    getEventUploadedImage();
    eventUploader();
});

function ChangeNav()
{
    $('#Eboard').click(function(){
        $('#Eboard').css({"font-weight": "700"});
        $('#E4U').css({"font-weight": "600"});
        
        eventBoardRequest();
        
        
    });
    
    $('#E4U').click(function(){
 
          $('#E4U').css({"font-weight": "700"});
        $('#Eboard').css({"font-weight": "600"});
        
        eventForYouRequest();
        
    });
}

function eventBoardRequest()
{
    $('#E4U').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
     $('#E4U img').css({position: "relative",
                        left: "50px"});
                    
                    $.ajax({
           url: ""+JURL+"events/eventsBoard",
           type:"GET",
           dataType: "json",
           data: {},
           success:function(data){
                 $('#E4U img').remove();
               $('#eventsHolder').html(data);
           }
       });
}

function eventForYouRequest()
{
     $('#E4U').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
      $('#E4U img').css({position: "relative",
                        left: "50px"});
                    
       $.ajax({
           url: ""+JURL+"events/eventsForYou",
           type:"GET",
           dataType: "json",
           data: {},
           success:function(data){
                 $('#E4U img').remove();
               $('#eventsHolder').html(data);
               
               changDeclineOpacity();
           }
       });
}

function attendEvent(user_id, event_id, privacy, index)
{
    var attend = $('.eventAccept').eq(index).text();
    var attendText = "attend";
    var attending  = "attending";
    var deline = "decline";
    
    if(attend === attendText)
    {
        $('#E4U').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
         $('#E4U img').css({position: "relative",
                           left: "50px"});
                       
       $.ajax({
           url:""+JURL+"events/attendEvent",
           type: "POST",
           dataType: "json",
           data: {user_id: user_id, event_id:event_id, privacy: privacy},
           success:function(data){
               $('#E4U img').remove();
              if(data)
               {
                    $('.eventAccept').eq(index).text(attending);
                    $('.Decline').eq(index).text(deline);
               }
           }
       });
    }
}

function declineEvent(user_id, event_id, index)
{
    var decline= $('.Decline').eq(index).text();
    var declineText = "decline";
    var declined = "declined";
    var attend  = "attend";
        
    if(decline == declineText)
    {
         $('#E4U').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
         $('#E4U img').css({position: "relative",
                           left: "50px"});
                       
       $.ajax({
           url:""+JURL+"events/declineEvent",
           type: "POST",
           dataType: "json",
           data: {user_id: user_id, event_id:event_id},
           success:function(data){
               $('#E4U img').remove();
               if(data)
               {
                    $('.eventAccept').eq(index).text(attend);
                    $('.Decline').eq(index).text(declined);
               }
           }
       });
    }
}

function changDeclineOpacity()
{
    $('.Decline').css({"opacity": "1.0", "cursor": "pointer"});
}

function creatEvent()
{
    var escape = 27;

        $('#eventLoglayer').show();
        $('#eventLogdialog').show();
        
        $('#eventLogclose').click(function(){
            $('#eventLoglayer').hide();
            $('#eventLogdialog').hide();
        });
        
        $('#eventLogCancelBt').click(function(){
            $('#eventLoglayer').hide();
            $('#eventLogdialog').hide();
        });
        
       
}

function getEventUploadedImage()
{
    $('#eventImg').click(function(event){
        var target = $(event.target);
            
            if(target.is(this))
            {
                $('input[type=file]').trigger('click');
            }
    });
    
    $('input[type=file]').change(function(){
          $('#eventImg').attr("src", ""+JURL+"pictures/events/camera_sel.png");
          $('#eventImg').attr("title",  $('#file').val());
    });
}

function submitEventRequest()
{
    var erMessage = '';
    var empty = "";
    var currentDate = new Date();
    var eventTypeFirst = "Event Type";
    var privacyFirst = "Privacy";
    var eventName = $('#eventName').val();
    var eventDescription = $('#eventDes').val();
    var location = $('#eventLocation').val();
    var date = $('#eventDATE').val();
    var eventTime =  $('#eventTime').val();
    var privacy = $('#eventPrivacy').val();
    var eventType = $('#eventType').val();
    var eventImage = $('#file').val();
    
    var eventYear = getYearFromEventDate(date);
    var eventMonth = getMonthFromEventDate(date);
    var eventDay= getDayFromEventDate(date);
    
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth()+1;
    var currentDay = currentDate.getDate();
  
    
    var eventHour = getHourFromEventTime(eventTime);
    var currentHour = currentDate.getHours();
    
    var invites = new Array();

    $('#event_invites').prepend('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15" id="LOADING">');
    $('#LOADING').css({position: "relative", right:"60px"});
   if(eventName == empty  || eventDescription== empty || location== empty  ||date== empty || eventTime == empty  || eventImage == empty )
   {
       //error message
       erMessage = "All Fields have to be filled";
      showErrorImageMessage(erMessage);
   }
   else if(eventType == eventTypeFirst || privacy == privacyFirst)
   {
       //error message
       erMessage = "Event Type or Privacy was not selected";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear < currentYear)
   {
       //error message
       erMessage = "event Year can't be a past Year";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear == currentYear && eventMonth < currentMonth)
   {
       //error message
       erMessage = "Event Month can't be a past month";
    showErrorImageMessage(erMessage);
   }
   else if(eventYear == currentYear && eventMonth == currentMonth && eventDay < currentDay)
   {
       //error message
       erMessage = "Event day cant be a past day";
       showErrorImageMessage(erMessage);
   }
   else if(eventYear == currentYear && eventMonth == currentMonth && eventDay == currentDay && (eventHour < currentHour || currentHour == 0 && eventHour >13))
   {
       //error
       erMessage = "Event Time cant be a past time";
       showErrorImageMessage(erMessage);
   }
   else
   {
   
       var invitedFriends = $('#event_invites').attr('name');
       var friendsCount = $('#event_invites').attr('title');
       $('#file').upload(JURL+"events/processEvent", {eventName: eventName, eventDes: eventDescription, location: location, date: date, time:eventTime, eventType: eventType, privacy: privacy, invitedFriends: invitedFriends, friendsCount: friendsCount},
        function(success)
        {
             resetevent();
            erMessage = "Your event has been created";
            $('#eventLoglayer').hide();
            $('#eventLogdialog').hide();
            showErrorImageMessage(erMessage);
        },
        function(progress)
        {
            
        }
        );
       
   }
 
}

function getYearFromEventDate(eventDate)
{
    var year = new String(eventDate);
    return year.charAt(0)+""+year.charAt(1)+""+year.charAt(2)+""+year.charAt(3);
}

function getMonthFromEventDate(eventDate)
{
    var month = new String(eventDate);
    return month.charAt(5)+""+month.charAt(6);
}

function getDayFromEventDate(eventDate)
{
    var day = new String(eventDate);
    return day.charAt(8)+""+day.charAt(9);
}



function getHourFromEventTime(eventTime)
{
   var hour = new String(eventTime);
   return hour.charAt(0)+""+hour.charAt(1);
}


function showErrorImageMessage(message)
  {
        //$('body').scrollTop(0);
               
                   document.getElementById('er_message').innerHTML = message;
                   document.getElementById('error_layer').style.display = 'block';
                   document.getElementById('error_dialog').style.display = 'block';
                   document.getElementById('error_close').style.display = 'block';


                   document.getElementById('error_close').onclick = function(){
                   document.getElementById('er_message').innerHTML = "";
                   document.getElementById('error_layer').style.display = 'none';
                   document.getElementById('error_dialog').style.display = 'none';
                   document.getElementById('error_close').style.display = 'none';
                     $('#LOADING').remove();
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('#error_dialog').hide();
                           $('#error_close').hide();
                             $('#LOADING').remove();
                       }
                    });
  }


function resetevent(){
   $('#eventName').val(EMPTY);
   $('#eventDes').val(EMPTY);
   $('#eventLocation').val(EMPTY);
   $('#eventDATE').val(EMPTY);
   $('#eventTime').val(EMPTY);
   $('#eventPrivacy').val(EMPTY);
   $('#eventType').val(EMPTY);
   var input = $('#file');
   input.replaceWith(input.val('').clone(true));
   $('#eventImg').attr('src', JURL+"pictures/events/camera.png");
}