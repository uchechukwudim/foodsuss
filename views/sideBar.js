/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
  infinitScrollForSideBar();
  
});

function foodFollowLoadingingImage()
{
    $('#foodFollow').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="12" height="12" id="LOADING">');
    $('#foodFollow img#LOADING').css({position: "relative", left: "8px", top:"2px"});
}

function onFoodFollowClick(which)
{
    var home = "HOME";
    var foodfinder = "FINDER";
    var food = 'FOOD';
    var recipe = "RECIPE";
    var eatWith = 'EATWITH';
    var event = 'EVENT';
    var article = 'ARTICLE';
      foodFollowLoadingingImage();
    if(which === home)
    {
      
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                $('#feeds').html(data);
                 onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();

                //whe happens when products button is clicked
                $('.products').click(function(event){
                $('#layer').show();
                $('#dialog').show();
                  });       
            }
        });
    }
    
    if(which === food)
    {
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                $('#Finderbody').html(""+data);
            
                 $('.foodCon').css({"margin-bottom":"-50px;"});
                  $('#foodFollowingHeader').css({"margin-left":"-50px"});
                onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();
                 //whe happens when products button is clicked
                $('.products').click(function(event){
                    $('#layer').show();
                    $('#dialog').show();
                });       
            }
        });
    }
    
    if(which === foodfinder)
    {
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                 $('#Finderbody').html(data);
                 $('#Finderbody').css({
                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"
                 });
                 $('#foodFollowingHeader').css({"margin-left":"-45px"});
                onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();
                 //whe happens when products button is clicked
                $('.products').click(function(event){
                    $('#layer').show();
                    $('#dialog').show();
                });       
            }
        });
    }
    
    if(which === recipe)
    {
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                   $('#body').html(data);
               
                                 $('#foodFollowingHeader').css({"margin-left":"-50px"});
                changeStatusOnHover();
                onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();
                 //whe happens when products button is clicked
                $('.products').click(function(event){
                    $('#layer').show();
                    $('#dialog').show();
                });       
            }
        });
    }
    
      if(which === eatWith)
    {
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                $('#EatWithHolder').html(data);
              
                 onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();

                //whe happens when products button is clicked
                $('.products').click(function(event){
                $('#layer').show();
                $('#dialog').show();
                  });       
            }
        });
    }
    
    if(which === event){
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                $('#events').html(data);
                $('#foodFollowingHeader').css({"margin-left":"-10px"});
              $('#events').css({"position":"relative", left: "-50px"});
            
                 onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();

                //whe happens when products button is clicked
                $('.products').click(function(event){
                $('#layer').show();
                $('#dialog').show();
                  });       
            }
        });
    }
    
    if(which === article){
        $.ajax({
            url: ""+JURL+"sideBar/foodFollow",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#foodFollow img#LOADING').remove();
                $('#Article_feeds').html(data);
                $('#foodFollowingHeader').css({"margin-left":"-10px"});
              $('#Article_feeds').css({"position":"relative", left: "-50px"});
            
                 onHoverNutrient();
                 onhoverOthercountry();
                 $('#layer').hide();
                 $('#dialog').hide();

                //whe happens when products button is clicked
                $('.products').click(function(event){
                $('#layer').show();
                $('#dialog').show();
                  });       
            }
        });
    }
    
}

function chefFollowLoadingingImage()
{
     $('#cheffollow').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="12" height="12" id="LOADING">');
     $('#cheffollow img#LOADING').css({position: "relative", left: "5px", top:"2px"});
}

function onFollowChefClick(which)
{
    var home = "HOME";
    var foodfinder = "FINDER";
    var food = "FOOD";
    var recipe = 'RECIPE';
    var eatWith = 'EATWITH';
    var event = 'EVENT';
    var article = 'ARTICLE';
    chefFollowLoadingingImage();
    if(which === home)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#cheffollow img#LOADING').remove();
               $('#feeds').html(data);
               $('#feeds').css({"width":"620px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                 
                setFriendStatusPadding();
               changeStatusOnHover1();
            }
        });
    }
    
    if(which === food)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                   $('#cheffollow img#LOADING').remove();
               $('#Finderbody').html(""+data);
              $('#Finderbody').append("<p>.</p>");
               $('#Finderbody').css({"width":"620px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
              $('#Finderbody p').css({"clear":"left", "display":"none"});
              $('#FinderrightNav').css({"width":"150px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === foodfinder)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                   $('#cheffollow img#LOADING').remove();
              $('#Finderbody').html(""+data);
              $('#Finderbody').append("<p>.</p>");
               $('#Finderbody').css({"width":"620px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
              $('#Finderbody p').css({"clear":"left", "display":"none"});
              $('#FinderrightNav').css({"width":"150px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
     if(which === recipe)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
               $('#cheffollow img#LOADING').remove();
               $('#body').html(""+data);
              $('#body').append("<p>.</p>");
               $('#body').css({"width":"620px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
              $('#bodyp').css({"clear":"left", "display":"none"});
              $('#rightNav').css({"width":"150px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === eatWith)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                   $('#cheffollow img#LOADING').remove();
               $('#EatWithHolder').html(data);
               $('#EatWithHolder').css({"width":"620px", position:"relative", left:"-25px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === event){
        $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                   $('#cheffollow img#LOADING').remove();
               $('#events').html(data);
                $('#chefsFollowFriendsHeade').css({"with":"600px"});
               $('#events').css({"width":"620px", "border":" 0px solid rgba(0, 0, 0, 0.1)"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === article){
         $.ajax({
            url: ""+JURL+"sideBar/followChef",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                   $('#cheffollow img#LOADING').remove();
               $('#Article_feeds').html(data);
                $('#chefsFollowFriendsHeade').css({"with":"600px"});
               $('#Article_feeds').css({"width":"620px", "border":" 0px solid rgba(0, 0, 0, 0.1)"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
}

function ResFollowLoadingingImage()
{
     $('#RestFollow').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="12" height="12" id="LOADING">');
     $('#RestFollow img#LOADING').css({position: "relative", left: "85px", top:"-22px"});
}

function onFollowRestaurantClick(which)
{
     var home = "HOME";
    var foodfinder = "FINDER";
    var food = "FOOD";
    var recipe = "RECIPE";
    var eatWith = 'EATWITH';
    var event = 'EVENT';
     var article = 'ARTICLE';
     ResFollowLoadingingImage();
    if(which === home)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                 $('#RestFollow img#LOADING').remove();
                $('#feeds').html(data);
                $('#feeds').css({"width":"620px"});
                $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
                changeStatusOnHover();
            }
        });
    }
    
    if(which === food)
    {
        $.ajax({
            url: ""+JURL+"sideBar/followRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
         
                $('#RestFollow img#LOADING').remove();
                $('#Finderbody').html(""+data);
                $('#Finderbody').append("<p>.</p>");
                $('#Finderbody').css({"width":"620px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
                $('#Finderbody p').css({"clear":"left", "display":"none"});
                $('#FinderrightNav').css({"width":"150px"});
                $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
                changeStatusOnHover();
            }
        });
    }
    
    if(which === foodfinder)
    {
        $.ajax({
            url: ""+JURL+"sideBar/FollowRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
                $('#RestFollow img#LOADING').remove();
                $('#Finderbody').html(""+data);
                $('#Finderbody').append("<p>.</p>");
                $('#Finderbody').css({"width":"620px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
                $('#Finderbody p').css({"clear":"left", "display":"none"});
                $('#FinderrightNav').css({"width":"150px"});
                $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
                changeStatusOnHover();
            }
        });
    }
    if(which === recipe)
    {
        alert();
        $.ajax({
            url: ""+JURL+"sideBar/FollowRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
               $('#RestFollow img#LOADING').remove();
               $('#body').html(""+data);
               $('#body').append("<p>.</p>");
               $('#body').css({"width":"650px",
                                     position: "relative",
                                     left:"-40px",
                                     "border-left": "0px solid rgba(0, 0, 0, 0.3)",
                                     "border-right": "0px solid rgba(0, 0, 0, 0.3)"});
              $('#bodyp').css({"clear":"left", "display":"none"});
              $('#rightNav').css({"width":"150px"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === eatWith)
    {
        $.ajax({
            url: ""+JURL+"sideBar/FollowRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
               $('#RestFollow img#LOADING').remove();
               $('#EatWithHolder').html(data);
               $('#EatWithHolder').css({"width":"620px", "border":" 0px solid rgba(0, 0, 0, 0.1)"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === event){
        $.ajax({
            url: ""+JURL+"sideBar/FollowRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
               $('#RestFollow img#LOADING').remove();
               $('#events').html(data);
               $('#events').css({"width":"620px", "border":" 0px solid rgba(0, 0, 0, 0.1)"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
    if(which === article){
         $.ajax({
            url: ""+JURL+"sideBar/FollowRestaurant",
            type: "GET",
            dataType: "json",
            data: {},
            success: function(data){
               $('#RestFollow img#LOADING').remove();
               $('#Article_feeds').html(data);
               $('#Article_feeds').css({"width":"620px", "border":" 0px solid rgba(0, 0, 0, 0.1)"});
               $('.FriendverifyImg').css({position:"relative",
                                          left: "5px",
                                           top: "2px"});
                setFriendStatusPadding();
               changeStatusOnHover();
            }
        });
    }
    
}

function infinitScrollForSideBar()
{
    var prev = 1;
    var next = 1;
    var pages = 0;
    var pageLoader = getWhichPageIsOn();
    var prevSideBarOption = '';
 
    $(window).scroll(function(){
                
        if($(window).scrollTop() === $(document).height() - $(window).height())
        {
           var sideBarOption = getWhichSideBarOptionToRun(pages);
          
             if(sideBarOption != null)
             {
                   
                    if(sideBarOption == prevSideBarOption)
                    {
                         pages = pages + 6;
                    }
                    else
                    {
                        prevSideBarOption = sideBarOption
                        pages = 0;
                        pages = pages+ 6;
                    }

                 
                    $.get(""+JURL+"sideBar/infinityFollow"+sideBarOption, {page: pages}, function(data){
                        $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                         $('#postload').css({"width": "50px"});
                        setTimeout(function(){
                           $("#postload").empty();
                           $(pageLoader).append(""+data);

                           }, 1000);

                    }, 'json');
            }
        }
    });
}

function getWhichSideBarOptionToRun(pages)
{
    var which = '';
    
    if($('#chefsFollowFriendsHeader').text() != "")
    {
        which  = 'Chef';
    }
    else if($('#foodFollowingHeader').text() != "")
    {
        which = 'Food';
    }
    else if($('restFollowFriendsHeader').text() != "")
    {
        which = 'Restaurant';
    }
    else
    {
        which  = null;
    }
    
    return which;
}

function getWhichPageIsOn()
{
   var which ='';
   
   if($('#feeds').text() != "")
   {
       which = '#feeds';
   }
   else if($('#Finderbody').text() != "")
   {
       which = '#Finderbody';
   }
   else if($('#body').text() != "")
   {
       which = '#body';
   }
   else if($('#EatWithHolder').text() != "")
   {
       which = '#EatWithHolder';
   }
   
   return which;
}

