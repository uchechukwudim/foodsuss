var EMPTY = '';

$(document).ready(function(){
    sliderFun();
   //redirectTohttps();
});

function redirectTohttps(){
    
    var link = window.location.href.toString().split(window.location.host)[0];
    var http = 'http://';
    
    var https = 'https://';
    var homehttps = 'https://enrifinder.com';
    if(link === http){
        window.location.href = homehttps;
    }
}

function sliderFun(){
    $("#slideshow > div:gt(0)").hide();

    setInterval(function() { 
      $('#slideshow > div:first')
        .fadeOut(1000)
        .next()
        .fadeIn(1000)
        .end()
        .appendTo('#slideshow');
    },  8000);
}

function signupLogingSwhitch(which){
    var login = "LOGIN";
    var signup = "SIGNUP";
   
    var loginForm = '<div class="loginHolder">\n\
                        <div id="LoginText">Login</div>\n\
                        <form>\n\
                            <input type="text" name="email" value="" class="usernamInput" placeholder="email" onkeyup="processLoginEnter(event)" /><br><br>\n\
                            <input type="password" name="password" value="" class="passwordInput" placeholder="password" onkeyup="processLoginEnter(event)" />\n\
                            <div class ="logIn">\n\
                                <button id="loginBut" type="button" onclick="processLogin()">Login</button>\n\
                            </div>\n\
                            <div class =" SignUp">\n\
                                <a href=""> </a>\n\
                            </div>\n\
                        </form>\n\
                        <div class="creatAcc" onclick="signupLogingSwhitch(\''+signup+'\')">Create an account <span> | </span></div>\n\
                        <div class= "forgetPw">\n\
                             <a href="" class="fgw"> Forgot password</a>\n\
                        </div>\n\
                         <div id="errLoginMess"></div>\n\
                </div>';
    
    var signupForm = '<div class="signupForm">\n\
                            <div style="font-size: 20px; margin-bottom: 10px; margin-top: 10px; color: orangered; font-weight: 700; position: relative; left: -140px;">Sign Up, <span>It`s Free!</span></div>\n\
                            <form method="post" action="" enctype="multipart/form-data" id="signup-form">\n\
                                    <input type="text" class="first_name" maxlength="12" placeholder="FirstName">\n\
                                    <input type="text" class="last_name" maxlength="12" placeholder="LastName"><br>\n\
                                    <input type="email" class="signup_email" placeholder="Email">\n\
                                    <input type="password" class="signup_password" placeholder="Password"><span style="color:  orangered; font-size: 9px; position: relative; bottom: 8px; left: 130px;">Greater than 6 and less than 20 letters</span><br>\n\
                                    <input type="text" class="current_city" placeholder="City">\n\
                                    <input type="text"  class="current_country" placeholder="Country">\n\
                                    <select id="userType" onchange="appendRestNameAndAddress()">\n\
                                        <option>You are a</option>\n\
                                        <option>Foodie</option>\n\
                                        <option>Chef</option>\n\
                                        <option>Restaurant</option>\n\
                                    </select><br>\n\
                                    <div style=" color: grey; width: 190px; position: relative; left: 240px; font-size: 11px; margin-bottom: 20px;">By clicking Sign Up, you agree to our <a style="color: orangered" href="'+JURL+'terms">Terms</a> and that you have read our <a style="color: orangered" href="'+JURL+'terms">Data Use Policy</a>, including our <a style="color: orangered" href="'+JURL+'policy">Cookie Use</a>.</div>\n\
                                    <button id="sigupBut" type="button" onclick="processSignup()" form="signup-form"><b>Register</b></button><span class="signup_er_message"></span>\n\
                            </form>\n\
                            <div class="LoginAcc" onclick="signupLogingSwhitch(\''+login+'\')">Log In</div>\n\
                    </div>';
    
    if(which === signup){ 
        $('#FORMSHOLDER').html(signupForm );
            $('.signupForm').css({position:"absolute", left:"1000px"}).animate({left: "750px"});
    }else if(which === login){
        $('#FORMSHOLDER').html(loginForm);
        $('.loginHolder').css({position:"absolute", left:"800px"}).animate({left: "700px"});
    }
}

function LoginErrorMessage()
{
    $('#errLoginMess').html("Wrong Email or Password");
}

function LoginFormEmpty(){
    $('#errLoginMess').html("Email or Password is empty");
}

function appendRestNameAndAddress()
{
    var rest = 'Restaurant';
    var userType = $('#userType').val();
    if(rest === userType){
       $('#signup-form').append("<input type='text' class='rest_name' placeholder='Restaurant Name'>");
    }else{

         $('.rest_name').remove();
    }
    
}
function processLoginEnter(event){
    if(event.which === 13){
        processLogin();
    }
}

function processLogin(){
    var VERIFY = "VERIFY";
    $('#loginBut').html('Log In');
    $('#loginBut').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15">');
    $('#loginBut img').css({"margin-left":"3px"});
    var email = $('.usernamInput').val();
    var password = $('.passwordInput').val();
    
    if(email.length === 0 || password.length === 0){
        $('#loginBut').html('Log In');
         $('#errLoginMess').html("email or password is empty");
    }else if(password.length < 6 || password.length > 20){
         $('#loginBut').html('Log In');
         $('#errLoginMess').html("password is not complete");
    }else{
        $.ajax({
            url: JURL+"landing/processLogIn",
            type: "POST",
            dataType: "json",
            crossDomain: true,
            data: {email: email, password: password},
            success:function(data){
      
                $('#loginBut').html('Log In');
                if(data === true){
                    window.location.href = JURL+'home';
                }else if(data === VERIFY){
                    createVerificationDialog(email);
                }else{
                    $('#errLoginMess').html(data);
                }
            },
             error: function(){
               $('#loginBut').html('Log In');
             }
        });
    }
}









function processSignup(){
   
   $('#sigupBut img').html('Sign Up');
    $('#sigupBut').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="18">');
    var firstName = $('.first_name').val();
    var lastName = $('.last_name').val();
    var email = $('.signup_email').val();
    var password = $('.signup_password').val();
    var cur_city = $('.current_city').val();
    var cur_country = $('.current_country').val();
    var user_type =  $('#userType').val();
    var rest_name = $('.rest_name').val();
  
    if(!checkInputval(firstName, lastName, email, password, cur_city, cur_country)){
        $('#sigupBut img').remove();
        $('.signup_er_message').html('all fields have to be filled');
    }else if(!validateEmail(email)){
        $('#sigupBut img').remove();
        $('.signup_er_message').html('Your email is not valide');
    }
    else if(!checkPasswordCount(password)){
        $('#sigupBut img').remove();
        $('.signup_er_message').html('Wrong password formate');
    }
    else if(!checkUserTyp(user_type)){
        $('#sigupBut img').remove();
        $('.signup_er_message').html('you have not selected "who you are"');
    }else{
          if(isRestuarant(user_type)){
               if(!checkRestVal(rest_name)){
                   $('#sigupBut img').remove();
                   $('.signup_er_message').html('Restaurant name is empty');
               }else{
                   sendSignupDeatailsToServer(firstName, lastName, email, password, cur_city, cur_country, user_type, rest_name);
               }
          }else{
                   sendSignupDeatailsToServer(firstName, lastName, email, password, cur_city, cur_country, user_type, rest_name);
          } 
    }

}

function checkInputval(firstName, lastName, email, password, cur_city, cur_country){
    if(firstName === EMPTY || lastName === EMPTY || email === EMPTY || password === EMPTY ||
       cur_city === EMPTY || cur_country === EMPTY ){
        return false;
    }else{
        return true;
    }
}

function validateEmail(email){
 
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(email);  
}

function checkPasswordCount(password){
    var six = 6; var twty = 20;
    if(password.length < six || password > twty){
        return false;
    }else{
        return true;
    }
}

function checkUserTyp(user_type){
     var user_type_default = "You are a";
   
    
    if(user_type === user_type_default){
        return false;
    }else{
        return true;
    }
}

function isRestuarant(user_type){
     var rest = "Restaurant";
     
     if(user_type === rest){
         return true;
     }else{
         return false;
     }
}

function checkRestVal(rest_name){
    if(rest_name === EMPTY){
        return false;
    }else{
        return true;
    }
}

function sendSignupDeatailsToServer(firstName, lastName, email, password, cur_city, cur_country, user_type, rest_name){
   var EXIST = 'EXIST';
   var INSERTED = 'INSERTED';
    $.ajax({
        url: JURL+"landing/processSignup",
        type:"POST",
        dataType: "json",
        data:{firstName: firstName , lastName: lastName , email: email, password: password, 
              cur_city:cur_city, cur_country:cur_country, user_type:user_type, rest_name: rest_name},
        success:function(data){
             if(data === EXIST){
                 $('#sigupBut img').remove();
                $('.signup_er_message').html('email already exist');
             }else if(data === INSERTED){
                 createVerificationDialog(email);
                 $('#sigupBut img').remove();
                     $('.first_name').val(EMPTY);
                     $('.last_name').val(EMPTY);
                    $('.signup_email').val(EMPTY);
                    $('.signup_password').val(EMPTY);
                    $('.current_city').val(EMPTY);
                    $('.current_country').val(EMPTY);
                    $('#userType').val('Your are a');
                    $('.rest_name').val(EMPTY);
                    $('.signup_er_message').html(EMPTY);
                  
             }
        },
         error: function(){
                $('#sigupBut img').remove();
         }
        
    });
}

function createVerificationDialog(email){
    $('html').append('<div id="verlayer"></div>');
    $('html').append('<div id="verdialog">\n\
                    <div id="verclose">| x |</div>\n\
                    <div id="verheader_dialogProd"><span class ="txt">Thank you for signing up with enri</span></div>\n\
                    <div id="holdVer">\n\
                    <form class="verform">\n\
                    <div class="resendVerEmail" onclick="resendVerification(\''+email+'\')">Resend verification code</div>\n\
                    <span>Please check your email for Verification code. If this dialog box closes, login with your details and this dialog box will pop back up.</span>\n\
                    <input type="text" class="veri_code" placeholder=" Verification code"><br>\n\
                    <div class="veri_error"></div>\n\
                    <button type="button" class="verify" onclick="checkVerificationCode(\''+email+'\')"><b>Verify</b></button>\n\
                   </form>\n\
                      </div>\n\
                    </div>');
     $('#verlayer').show();
     $('#verdialog').show();
     closeImageReciepieDialog();
}

function checkVerificationCode(email){
    var code = $('.veri_code').val();
    $('.verify img').remove();
     $('.verify').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15">');
    if(code === EMPTY){
         $('.verify img').remove();
        $('.veri_error').html("Verification filed is empty");
    }else if(code.length < 7 || code.length > 7){
         $('.verify img').remove();
        $('.veri_error').html("code should be 7 letters");
    }
    else{
              
        $.ajax({
            url: JURL+"landing/verifyCode",
            type: "GET",
            dataType: "json",
            data: {email: email, code: code},
            success:function(data){
                if(data === true){
                    $('#verheader_dialogProd span').html('Confirmation');
                    $('#holdVer').html('<div id="conf_message">Thank you for taking time to verify your account.<br> You can now log in and start discovering new food, recipes, products and share your love for food</div>')
                }
                
                if(data === false){
                     $('.verify img').remove();
                    $('.veri_error').html("Your code is wrong");
                }
            }
        });
    }
}

function resendVerification(email){
    $.ajax({
            url: JURL+"landing/resendVerification",
            type: "GET",
            dataType: "json",
            data: {email: email},
            success:function(data){
                if(data === true){
                    $('.verify img').remove();
                    $('.veri_error').html("Check you email for new code");
                }
                
                if(data === false){
                     $('.verify img').remove();
                    $('.veri_error').html("could not send code. Please try again");
                }
            }
        });
}

 function closeImageReciepieDialog()
 {
     $('#verclose').click(function(){
     $('#verlayer').remove();
     $('#verdialog').remove();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#verlayer').remove();
                $('#verdialog').remove();
           }
     });
 }