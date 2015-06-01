/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
  
    
});


function getProfileFriendsFollow()
{
    $('#which_active').html('FF');
    $('#P_followers').css({"background": "#F4716A", "color":"white"});
    $('#P_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $('#meHolderHeader b').css({position: "relative", left:"10px"});
             $('#meHolderHeader img').css({position: "relative", left:"10px"});
    $.ajax({
        url: ""+JURL+"profile/FriendsFollow",
        type: "GET",
        dataType: "json",
        data: {},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html(data);
            
            setMyFriendStatus();
            changeStatusOnHover();
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
              $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
        }
        
    });
}

function getUserProfileFriendsFollow(userId)
{
    $('#which_active').html('UFF');
    $('#U_followers').css({"background": "orangered", "color":"white"});
    $('#U_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $('#AjaximageLoader').css({postion: "relative", left: "300px"});
    $.ajax({
        url: ""+JURL+"profile/FriendsFollow",
        type: "GET",
        dataType: "json",
        data: {userId: userId},
        success: function(data){
            $('#AjaximageLoader').hide();
            $('#LOAD').html(data);
           setMyFriendStatus();
           changeStatusOnHover();
         
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
              $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
        }
        
    });
}

function setMyFriendStatus()
{
    
    var empty = '';
     $('.friendStatus').each(function(){
         var txt = $(this).text().replace(/\"/g, "");
         
         if(txt === empty)
         {
             $(this).css({"background": "white"});
         }
     });
}

function changeStatusOnHover()
{

    $('.friendStatus').each(function(index){
        
        $(this).hover(function(){
            var status = $(this).text();
            if(status === "Friends")
            {
                $(this).text("UnFriend");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Following")
            {
                $(this).text("Unfollow");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Follower")
            {
                $(this).text("Follow Back");
                $(this).css({ "text-align":"center", "width":"auto"});
                $(".recipeCount span").eq(index).css({"margin-left":"15px"});
            }
        },function(){
            
            var status = $(this).text();
            if(status === "UnFriend")
            {
                $(this).text("Friends");
               $(this).css({ "text-align":"center"});
            }
            
            if(status === "Unfollow")
            {
                $(this).text("Following");
                $(this).css({ "text-align":"center"});
            }
            
            if(status === "Follow Back")
            {
                $(this).text("Follower");
                $(this).css({ "text-align":"center", "width":"45px" ,"padding-left": "5px","padding-right":"5px",
                            "margin-right": "10px"});
                
            }
            
        });
    });
}

function sendFriendShipToServer(friendRequest, user_id, friend_user_id, index)
{
    
  $('.friendUsertTypeMain').eq(index).append('<img class="ajaxloader" src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="12" height="12" alt="">');
  $('.ajaxloader').css({position: "relative", left: "60px", top:"5px"});
  $('.friendStatus').eq(index).attr('onclick',  '');
  
  
  $.ajax({
      url: ""+JURL+"profile/FriendFollowRequestProcessing",
      type: "POST",
      dataTyep:"json",
      data: {request: friendRequest, user_id: user_id, friend_user_id: friend_user_id},
      success: function(data){
          
          $('.friendStatus').eq(index).html(data.replace(/\"/g, ""));
         
          
          $('.friendStatus').eq(index).click(function(){
              sendFriendShipToServer(data.replace(/\"/g, ""), user_id, friend_user_id, index);
          });
           $('.ajaxloader').remove();
          
           sendNotification(FriendOrFollowing(data.replace(/\"/g, "")), user_id, friend_user_id);
           
      }
  });
}

function  sendNotification(FriendFollowIndex, reciever_user_id1, reciever_user_id2)
{
    var zero = 0; var one = 1;

    if(FriendFollowIndex === zero || FriendFollowIndex === one){
            $.ajax({
                url:""+JURL+"notifier",
                type: "POST",
                data: {index: FriendFollowIndex, reciever_user_id1: reciever_user_id1, reciever_user_id2: reciever_user_id2},
                success: function(data){

                }
            });
    }
}

function FriendOrFollowing(which)
{
    var friends = 'Friends';
    var following = 'Following';
    if(which === following)
    {
        return 0;
    }
    else if(which === friends)
    {
        return 1;
    }
    else{
        return -1;
    }
}
function infinitScrollFriendsFollow()
{
    var pages = 0;
    var F = 'FF';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
        
           var FF = $('#which_active').text();
    
             if(FF === F)
             {
                        
                pages = pages + 6;
                   $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                   $('#userPostLoad').css({"width": "50px", position:"relative", left: "0px"});
                    $.post(""+JURL+"profile/infinitScrollFriendsFollow", {page: pages}, function(data){

                               $("#userPostLoad").empty();
                               $("#FriendFollowerHolder").append(""+data);
                                 setFriendStatusPadding();
                                 changeStatusOnHover();
                    }, 'json')
                            .fail(function(){
                                $("#userPostLoad").empty();
                                $("#userPostLoad").html('somthing went wrong');
                                $('#userPostLoad').css({"width": "200px",
                                                                 "height": "20px;",
                                                                color:"red", 
                                                                "font-size":"12", 
                                                                "font-weight":"700", 
                                                                position:"relative", 
                                                                left: "430px"});
                            });
             }
             else
             {
                 pages = 0;
             }
        }
    });
}

function UserInfinitScrollFriendsFollow(userId)
{
 
    var pages = 0;
    var UFF = 'UFF';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
         
          var FF = $('#which_active').text();
          
             if(FF === UFF)
             {
                  $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="20px" hieght="20px">');
                   $('#userPostLoad').css({"width": "50px", position:"relative", left: "480px"});
                 pages = pages + 6;
                    $.post(""+JURL+"profile/infinitScrollFriendsFollow", {page: pages, userId: userId}, function(data){
                          
                               $("#userPostLoad").empty();
                               $("#FriendFollowerHolder").append(""+data);
                                 setFriendStatusPadding();
                                 changeStatusOnHover();
                    }, 'json')
                            .fail(function(){
                                        $("#userPostLoad").empty();
                                        $("#userPostLoad").html('somthing went wrong');
                                        $('#userPostLoad').css({"width": "200px",
                                                                 "height": "20px;",
                                                                color:"red", 
                                                                "font-size":"12", 
                                                                "font-weight":"700", 
                                                                position:"relative", 
                                                                left: "430px"});
                                    });
             }
             else
             {
                 pages = 0;
             }
        }
    });
}