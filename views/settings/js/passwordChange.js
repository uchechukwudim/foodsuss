/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
  changePassword();
});

function changePassword()
{
     $('#setsPasswrdsubmitBt').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15" height="15">');
    var empty = "";
    

        var curPassword = $('#Cur_password').val().replace(/\s+/g, '');
        var nwPassword = $('#Nw_password').val().replace(/\s+/g, '');
        var conPassword = $('#CF_password').val().replace(/\s+/g, '');
    
        if(curPassword === empty && nwPassword === empty && conPassword === empty)
        {
             $('#setsPasswrdsubmitBt img').remove();
             $('#Settingpasssusrform span.err_mes').css({"margin-left": "30px"});
            $('#Settingpasssusrform span.err_mes').html("empty filds");
        }
        else if(nwPassword.length < 6 || nwPassword.length > 20)
        {
            $('#setsPasswrdsubmitBt img').remove();
             $('#Settingpasssusrform span.err_mes').css({"margin-left": "25px"});
             $('#Settingpasssusrform span.err_mes').html("wrong format");
            emptyAllVals();
        }
        else if(nwPassword !== conPassword)
        {
            $('#setsPasswrdsubmitBt img').remove();
            $('#Settingpasssusrform span.err_mes').css({"margin-left": "-40px"});
             $('#Settingpasssusrform span.err_mes').html("password does not match");
            emptyAllVals();
        }
        else
        {
            //send to server
            $.ajax({
                url: JURL+"settings/changePassword",
                type:"POST",
                dataType: "json",
                data: {currentPassword: curPassword, newPassword: nwPassword},
                success:function(data)
                {
                    emptyAllVals();
                    $('#setsPasswrdsubmitBt img').remove();
                    showPasswordConfirmationMessage(data);
                }
                
            });
        }

    
}



function emptyAllVals()
{
    $('#Cur_password').val("");
   $('#Nw_password').val("");
    $('#CF_password').val("");
}

 function showPasswordConfirmationMessage(message)
  {
        $('body').scrollTop(0);
        
                 document.getElementById('passwordDialog_layer').style.display = 'none';
                document.getElementById('password_dialog').style.display = 'none';
                document.getElementById('passwordDialog_close').style.display = 'none';
                
                   document.getElementById('er_message').innerHTML = message;
                   document.getElementById('error_layer').style.display = 'block';
                   document.getElementById('error_dialog').style.display = 'block';
                   document.getElementById('error_close').style.display = 'block';
          
                   document.getElementById('error_close').onclick = function(){
                   document.getElementById('er_message').innerHTML = "";
                   document.getElementById('error_layer').style.display = 'none';
                   document.getElementById('error_dialog').style.display = 'none';
                   document.getElementById('error_close').style.display = 'none';
                      //window.location.href=window.location.href;
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('#error_dialog').hide();
                           $('#error_close').hide();
                             // window.location.href=window.location.href;
                       }
                    });
  }