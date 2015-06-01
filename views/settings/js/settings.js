/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadPasswordChange(){
    $('#settingsPasswordNav').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
    $('#settingsConHeading').html('Password <span id="deactivateAcc"><a onclick="deactivateAcc()">Deactivate My Account</a></span><br>\n\
            <span id="SettingsheadingDetails">Change your Password</span>');
    $('#setsAccount').html('<div id="SettingsDetailsHolder">\n\
                                 <div id="setsPassword">\n\
                                    <form action ="" method ="post" enctype="multipart/form-data" id="Settingpasssusrform">\n\
                                        <input type="password" id="Cur_password" placeholder=" Current password"><br>\n\
                                        <input type="password" id="Nw_password" placeholder=" New password"><span class="NP_info">greater than 6 and lesser than 20 letters</span><br>\n\
                                        <input type="password" id="CF_password" placeholder=" Confirm password"><span class="err_mes"></span><br>\n\
                                        <button type="button" id="setsPasswrdsubmitBt" onclick="changePassword()">Save Changes</button>\n\
                                    </form>\n\
                                </div>\n\
                           </div> ');
    $('#settingsPasswordNav img').remove();
}

function deactivateAcc(){
    var deact_code  = 'udjhdhfhdjdfxfdsddsfjnsef';
    $('#deactivateAcc').append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
   $.ajax({
       url: JURL+"settings/deactivate",
       type:"POST",
       dataType: "json",
       data:{deact_code: deact_code },
       success:function(data){
           var message ="All you have to do is no log in and your account will be activated.";
           if(data === true){
               showErrorImageMessage(message);
                  window.location.href = JURL;
           }
       }
   });
}


function showErrorImageMessage(message)
  {
        $('body').scrollTop(0);
                
                   document.getElementById('er_message').innerHTML = message;
                   document.getElementById('error_layer').style.display = 'block';
                   document.getElementById('error_dialog').style.display = 'block';
                   document.getElementById('error_close').style.display = 'block';



                   document.getElementById('error_close').onclick = function(){
                   document.getElementById('er_message').innerHTML = "";
                   document.getElementById('error_layer').style.display = 'none';
                   document.getElementById('error_dialog').style.display = 'none';
                   document.getElementById('error_close').style.display = 'none';
                      
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('#error_dialog').hide();
                           $('#error_close').hide();
                         
                       }
                    });
  }