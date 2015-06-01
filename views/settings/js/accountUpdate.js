/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    updateInfo();
});

function updateInfo()
{
    var firstName = $('#FirstNAME').val();
    var lastName = $('#LastNAME').val();
    var email = $('#EMAIL').val();
    var year = $('#YEAR').val();
    var month = $('#MONTH').val();
    var day = $('#DAY').val();
    var message = '';
    var filter = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    
    //alert(firstName+" "+lastName+" "+ email+" "+year+"-"+month+"-"+day);
    $('#setssubmitBt').click(function(){
       
          if(firstName == $('#FirstNAME').val() && lastName  == $('#LastNAME').val() && email == $('#EMAIL').val() && year ==$('#YEAR').val() && month == $('#MONTH').val() && day == $('#DAY').val())
             {
                  //There where no changes made. message informing the user
                   message = "There where no changes made";
                  showErrorImageMessage(message);
         
             }
             else if($('#FirstNAME').val().replace(/\s+/g, '').length > 11 || $('#LastNAME').val().replace(/\s+/g, '').length > 11 || $('#LastNAME').val().replace(/\s+/g, '').length <= 1 || $('#FirstNAME').val().replace(/\s+/g, '').length <= 1)
             {
                 //error message here. FirstName and LastName must be less than 10 letters and greater than 4
                   message = "FirstName and LastName must be less than 10 letters and greater than 1";
                   showErrorImageMessage(message);
             }
             else if($('#YEAR').val() == "Year" ||$('#MONTH').val()=="Month" || $('#DAY').val() == "Day")
             {
                 //wrong date formate
                   message = "Wrong date format. Please enter a correct Date";
                     showErrorImageMessage(message);
             }
             else if(!filter.test($('#EMAIL').val()))
             {
                 // wrong email format
                  message = "Wrong Email format. Please enter a correct email";
                    showErrorImageMessage(message);
             }
             else
             {
                 
                  showPasswordDialogBox();
                  
                  $('#PwordConfirmsubmitBt').click(function(){
                          if($('#updatePwordConfimation').val().replace(/\s+/g, '') != "")
                          {
                              //CSS SETINGS
                              $('#NoPwordErrorMessage').html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" height="30px">');
                              $('#NoPwordErrorMessage').show();
                              $('#NoPwordErrorMessage img').css({position: "relative", left:"80px"});
                              $('#password_dialog').css({"height":"160px"});
                              $('#passwordDialog_close').css({position: "absolute", top:"130px"});
                          
                          
                             // SEND TO SERVER
                                  var password = $('#updatePwordConfimation').val().replace(/\s+/g, '');
                                  var firstName1 = $('#FirstNAME').val().replace(/\s+/g, '');
                                  var lastName1 = $('#LastNAME').val().replace(/\s+/g, '');
                                  var email1 = $('#EMAIL').val();
                                  var year1 = $('#YEAR').val();
                                  var month1 = $('#MONTH').val();
                                  var day1 = $('#DAY').val();
                                $.ajax({
                                    url: JURL+"settings/updateInfo",
                                    type: "POST",
                                    dataType: "json",
                                    data: {FirstName: firstName1, LastName: lastName1, Email: email1, date: year1+"-"+month1+"-"+day1, password: password},
                                    success: function(data){
                                        
                                          var ermessage = 'Password is wrong. Please try again.';
                                          if(!data)
                                          {
                                               $('#NoPwordErrorMessage').html(ermessage);
                                               $('#updatePwordConfimation').val("");
                                          }
                                          
                                          if(data)
                                          {
                                              message = "Your profile has been updated";
                                               showPasswordConfirmationMessage(message);
                                        }
                                    }
                                });
                           }
                           else
                           {
                               message  = "Please type in a password to confirm";
                               $('#NoPwordErrorMessage').html(message);
                               
                               $('#NoPwordErrorMessage').show();
                           }

                    });
                    
             }
    });
}

function showErrorImageMessage(message)
  {
        //$('body').scrollTop(0);
                
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
  
  function showPasswordDialogBox()
  {
      //$('body').scrollTop(0);
                
                  
                   document.getElementById('passwordDialog_layer').style.display = 'block';
                   document.getElementById('password_dialog').style.display = 'block';
                   document.getElementById('passwordDialog_close').style.display = 'block';


                   document.getElementById('passwordDialog_close').onclick = function(){
                   //document.getElementById('er_message').innerHTML = "";
                   document.getElementById('passwordDialog_layer').style.display = 'none';
                   document.getElementById('password_dialog').style.display = 'none';
                   document.getElementById('passwordDialog_close').style.display = 'none';
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                           $('#passwordDialog_layer').hide();
                           $('#password_dialog').hide();
                           $('#passwordDialog_close').hide();
                       }
                    });
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
                      window.location.href=window.location.href;
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('#error_dialog').hide();
                           $('#error_close').hide();
                              window.location.href=window.location.href;
                       }
                    });
  }