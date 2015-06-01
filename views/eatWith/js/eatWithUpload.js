/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    upload();
});

function eatWith()
{
  $('#eatWithLayer').show();
  $('#eatWithDialog').show();

}

function cancel()
{
    $('#eatWithLayer').hide();
  $('#eatWithDialog').hide();
}
function trigger(event)
{
    
       var target = $(event.target);
            
            if(target.is('#eatWithUpload'))
            {
             $('input[type=file]').trigger('click');

            }
            
          $('input[type=file]').change(function(){
          $('#eatWithUpload').attr("src", ""+JURL+"pictures/events/camera_sel.png");
          $('#eatWithUpload').attr("title",  $('#file').val());
    });
}


function changePicIcon()
{
    $('input[type=file]').change(function(){
        $('#eatWithUpload').attr("src", ""+JURL+"pictures/events/camera_sel.png");
       $('#eatWithUpload').attr("title",  $('#file').val());
    })
}

function submitEatWithRequest()
{
    var erMessage = '';
    var empty = "";
   
    var description = $('#description').val();
    var file = $('#file').val();
    $('#eatWithLogSubmitBt').html('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="20" height="20" id="LOADING">');
    if(file === empty)
    {
         
        erMessage = "No Picture or Video uploaded";
        $('#error_info').text(erMessage);
        $('#error_info').show();
        $('#eatWithUpload').css({"margin-left":"20px"});
    }
    else if(description === empty){
       
         erMessage = "No Description";
          $('#error_info').text(erMessage);
            $('#error_info').show();
            $('#eatWithUpload').css({"margin-left":"100px"});
    }
    else{
          $('#error_info').show();
          $('#eatWithUpload').css({"margin-left":"150px"});
          
      $('#file').upload(""+JURL+"eatWith/processEatWithRequest", {description: description},
        function(success)
        {
             $('#eatWithLogSubmitBt img').remove();
            //reset
           var dif_file_er =  'Only Image/Video allowed';
           
             if(success === dif_file_er)
             {
                   $('#eatWithUpload').css({"margin-left":"35px"});
             }
             else{
                   $('#eatWithUpload').css({"margin-left":"20px"});
             }
             
               $('#eatWithUpload').attr("src", ""+JURL+"pictures/eatWith/camera.png");
               $('#eatWithUpload').attr("title",  'upload Picture/Video(mp4, ogg, mov, wmv)');
               $('#description').val(empty);
               $('#description').attr('placeHolder', 'image/video description');
              
               erMessage = success;
               $('#error_info').html(success);
             
               changePicIcon();
        },
        function(progress)
        {
            
        }
        );
    }
}


