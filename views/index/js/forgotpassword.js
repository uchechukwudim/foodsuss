/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var EMPTY = '';
$(document).ready(function(){
   
});



function showForgotPasswordDialog(){
    $('html').append('<div id="forgetPWLayer"></div>');
    $('html').append('<div class="center-DH">\n\
                        <div class="forgetPWDialog is-fixed">\n\
                            <div id="forgetPWDialogclose">| x |</div>\n\
                            <div id="forgetPWDialog_header"><span class ="txt">Forgot Password?</span></div>\n\
                            <div id="formHolder">\n\
                                <form>\n\
                                    <input type="email" id="forgetEmail" placeholder="email"><br>\n\
                                    <span class="forgetPWError"></span><br>\n\
                                    <button onclick="sendNewPassword()" type="button" id="forgetPWButton">Send</button>\n\
                                </form>\n\
                            </div>\n\
                        </div>\n\
                     </div>');
    
    $('#forgetPWLayer').show();
    $('.forgetPWDialog').show();
    closeForgotPasswordDialog();
}

function closeForgotPasswordDialog(){
    
    $('#forgetPWDialogclose').click(function(){
        $('#forgetPWLayer').remove();
        $('.forgetPWDialog').remove();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#forgetPWLayer').remove();
                $('.forgetPWDialog').remove();
           }
     });
}


function sendNewPassword(){
    var email = $('#forgetEmail').val();
    
    if(email === EMPTY){
        $('.forgetPWError').html('please file out your email.');
    }else if(!validateEmail(email)){
         $('.forgetPWError').html('invalide email format.');
    }else{
        ajaxNewPassword(email);
    }
}


function  ajaxNewPassword(email){
    $('#forgetPWButton').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="18">');
    $.ajax({
        url: JURL+"index/forgotpassword",
        type: "POST",
        dataType: "json",
        data: {email: email},
        success: function(data){
            $('#forgetPWButton img').remove();
            if(data === true){
                $('.forgetPWError').html('Please check your email for temporary password and link.');
                $('.forgetPWError').css({"color":"green"});
            }else if(data === false){
                $('.forgetPWError').html('please try again something went wrong.');
            }else{
                $('.forgetPWError').html(data);
            }
        },
        error: function(){
             $('#forgetPWButton img').remove();
             $('.forgetPWError').html('please try again something went wrong.');
        }
    });
}


function processforgotPasswordLoginEnter(event, email){
    if(event.which === 13){
         processforgotPasswordLogin(email)
    }
}

function processforgotPasswordLogin(email){
   var six = 6;
   var twty = 20;
    var temp_password = $('#tempPassword').val();
    var new_password = $('#newPassword').val();
    var message = '';
    if(temp_password === EMPTY || new_password ===EMPTY){
        message = 'temp password or new password field is empty';
        $('#errLoginMess').html(message);
    }else if(new_password.length < six || new_password.length > twty){
         message = 'password has to be greater than 6 and less than 20 letters ';
         $('#errLoginMess').html(message);
    }else{
        ajaxProcessForgetpaswordLogin(temp_password, new_password, email);
    }
}


function ajaxProcessForgetpaswordLogin(temp_password, new_password, email){
     $('#loginBut').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="18">');
    var message = '';
    $.ajax({
        url: JURL+"index/ProcessForgetpasswordLogin",
        type: "POST",
        dataType: "json",
        data: {tempPassword: temp_password, newPassword: new_password, email: email},
        success: function(data){
             $('#loginBut img').remove();
            if(data === true){
                message = 'Your new password has been updated. You can now <a href ="'+JURL+'">log in</a>';
                $('.loginHolder').html(message);
                 $('.loginHolder').css({"color": "white", "font-size": "16px", "font-weight":"700"});
            }else if(data === false){
                message = "sorry please try again something went wrong";
                $('#errLoginMess').html(message);
            }else{
                $('#errLoginMess').html(data);
            }
        },
        error:function(){
            $('#loginBut img').remove();
             message = "sorry please try again something went wrong";
              $('.forgetPWError').html(message);
        }
    });
}

function validateEmail(email){
 
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(email);  
}