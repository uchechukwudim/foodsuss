src="http://code.jquery.com/jquery-latest.js";

var picture = '';
var content = '';
function inputFocus(){
       $(".btnTag").hide();
        $("#inputFood").focus(function(){
                $("#inputFood").css('height', function(index){
                      return index += 100;
                });
                
                $(".btnTag").show();
        });
        
}

function inputfocusout()
{
    $("#inputFood").focusout(function(){
     
            //what happens when botton tell is clicked
            $("#submitBt").click(function(even){ 
                var $target = $(even.target);
                if($target.is(this))
                    {
                  
                    }
            });
            
            //what happens when botton picture is clicked
            $("#uploadPic p").click(function(even){ 
            
                var $target = $(even.target);
                if($target.is(this))
                    {
                      uplaod();
                    }
            });
            $("#uploadPic").click(function(even){ 
              
                var $target = $(even.target);
                if($target.is(this))
                    {
                       $('input[type=file]').trigger('click');
                    }
            });
           
            //:::::::::::::::::::::::::::::::::::::::::::::::::::::
         
            
        });
}

function uplaod()
{
         $('#uploadPic P').click(function() {
         $('input[type=file]').trigger('click');
});
}