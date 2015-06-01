/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
//alert($('fieldset').width());
});

function processInvites(){
    var emails = new Array();
    var count = 0
    $('input[type=checkbox]:checked').map(function(_, el) {
        emails[count] = ($(el).val());
        count++;
    }).get();
    $('#inviteButton').append('<img src="http://localhost/pictures/ajax-loader-white.gif" width="15">');
   $.ajax({
       url: "http://localhost/Suggestusers/processInviteEmails",
       type: "POST",
       dataType: "json",
       data: {emails: emails},
       success:function(data){
           $('#email_invites fieldset').html('<div styel="text-align: center; font-size: 16px; font-weight: 700; color: grey">Thank you for inviting your friend(s) to join enri </div>');
       }
   });
}