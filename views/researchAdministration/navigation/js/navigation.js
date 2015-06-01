/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
});

function reSendReverificatioinEmail(){
    var code = "asdkfhbdsikewfiwrfiw9w34484";
    $.ajax({
        url: JURL+"researchAdministration/resendErrorNotificationEmail",
        type: "POST",
        dataType: "json",
        data: {confirmationCode: code},
        success: function(data){
            
        }
        
    });
}