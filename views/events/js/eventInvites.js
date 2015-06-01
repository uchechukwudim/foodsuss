/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    invitesFriendsToEvent();
});


function invitesFriendsToEvent()
{
    $('#event_invites').click(function(){
       // $('#eventInvitesLoglayer').show();
        $('#eventInvitesLogdialog').show();
        
        $('#eventInvitesLogdialog').css({"width":"500px"});
        $('#friendsHolder').html('<img src="'+JURL+'pictures/events/profile_ajax-loader.gif" width="50" height="50">');
        $('#friendsHolder img').css({position: "relative", left: "230px"});
        getFriendForInvites();
    });
    
    
}

function getFriendForInvites()
{
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

function cancelInvites()
{
    $('#cancelInvite').click(function(){
       // $('#eventInvitesLoglayer').hide();
        $('#eventInvitesLogdialog').remove();
    });
}

function invite(friendsCount)
{
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
 
  
    $('#event_invites').html(Fcount+" Invited");
    $('#event_invites').attr('name', JSON.stringify(friends));
    $('#event_invites').attr('title', Fcount);
    $('#eventInvitesLogdialog').hide();
}

