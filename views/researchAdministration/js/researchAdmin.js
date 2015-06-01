/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   // redirectTohttps();
});

function redirectTohttps(){
    
    var link = window.location.href.toString().split(window.location.host)[0];
    var http = 'http://';
    
    var https = 'https://';
    var homehttps = https+'enrifinder.com/researchAdministration/';
    if(link === http){
        window.location.href = homehttps;
    }
}

function processResearcherLogin(){
    $('#researcher_loginBut').html('Log In');
    $('#researcher_loginBut').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15">');
    $('#researcher_loginBut img').css({"margin-left":"1px"});
    var email = $('#researcher_email').val();
    var password = $('#researcher_password').val();
    
    if(email.length === 0 || password.length === 0){
         $('#researcher_loginBut').html('Log In');
        $('.errorMes').html('Fields are empty');
       
    }else if(password.length < 6 || password.length > 20){
          $('#researcher_loginBut').html('Log In');
         $('.errorMes').html("password is not complete");
    }else{
        loginRequest(email, password);
    }
}

function loginRequest(email, password){
  
    $.ajax({
        url: JURL+"researchAdministration/loginRequest",
        type: "POST",
        dataType: "json",
        crossDomain: true,
        data: {email: email, password: password},
        success: function(data){
            if(data === true){
                window.location.href = JURL+'researchAdministration/navigation';
            }else{
                $('#researcher_loginBut').html('Log In');
                $('.errorMes').html(data);
            }
        }
    });
}

function processResearcherLoginEnter(event){
     var enter = 13;
     if(event.which === enter){
        processResearcherLogin();
    }
}

function removeSearchConfirm(){
    var $baseFoodInput = document.getElementById('search_confirm');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchCFResHolder') || $targt.is($baseFoodInput)){
               
             }
             else{
                  
                    $('#searchCFResHolder').remove();
             }
    });
}
