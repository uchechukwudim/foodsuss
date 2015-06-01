/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var EMPTY = '';
$(document).ready(function(){
    
});


function sendHelpEmail(){
    var contact_names = $('#contact_names').val();
    var contact_email = $('#contact_email').val();
    var message = $('#message').val();
    var errorMessage = '';
    
    if(contact_names === EMPTY || contact_email === EMPTY || message === EMPTY){
        errorMessage = 'All fields have to be filled';
        $('.errorMessage').text(errorMessage);
    }else if(!validateEmail(contact_email)){
         errorMessage = 'email is not valide';
        $('.errorMessage').text(errorMessage);
    }else{
        ajaxHelpContactForm(contact_names, contact_email, message);
    }
}

function ajaxHelpContactForm(contactNames, contactEmail, message){
    var errorMessage = '';
   $.ajax({
       url: JURL+"help/sendContactFormEmail",
       type: "POST",
       dataType: "json",
       data: {names: contactNames, email: contactEmail, message: message },
       success:function(data){
          
           
           if(data){
               clearForm();
               errorMessage = 'Thank you for your email. We will look into whatever issue you are facing and we will get back to you as soon as possible.<br>Thank you for using enri.';
               $('.errorMessage').html(errorMessage);  
               $('.errorMessage').css({"color": "green"});
           }else{
               errorMessage = 'sorry something went wrong. please try again';
                $('.errorMessage').text(errorMessage);
           }
         
       },
       error: function(){
           errorMessage = 'sorry something went wrong. please try again';
        $('.errorMessage').text(errorMessage);
       }
   });
}

function clearForm(){
    $('#contact_names').val(EMPTY);
    $('#contact_email').val(EMPTY);
    $('#message').val(EMPTY);
}

function validateEmail(email){
 
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return filter.test(email);
    
    
}