src="http://localhost/js/jquery.min.js";
        src="http://localhost/js/jquery-2.0.0.js";
    src="http://localhost/js/foodPage/foodpage.js";
$(document).ready(function(){
 
    
    //alert($(document).height());
    onHoverNutrient();
    onhoverOthercountry();
});

function onHoverNutrient()
{
    $(".nuterients").hover(function(event){
        
        //in
             var title = event.target.title;
              event.target.title = "";
              event.target._ref = title;
             $(".tooltips").html(title);
             $(".tooltips").show();
             mouse();
             
             
      }, function(){
          
          //out
            event.target.title = event.target._ref;
            
            $(".tooltips").hide();
      });
      
}

function onhoverOthercountry()
{
    $(".OtherCountry").hover(function(event){
      
         var title = event.target.title;
         
         if(title.length > 0){
              event.target.title = "";
              event.target._ref = title;
             $(".tooltips").html(title);
             $(".tooltips").css({
                 "width": "auto",
                 "height": "auto"
             });
             $(".tooltips").show();
             mouse();
         }
         else  if(title.length <= 0){
             event.target.title = "";
             event.target._ref = "";
         }
     
    }, function(){
        
        //out
             event.target.title = event.target._ref;
             $(".tooltips").css({
                 "width": "300px",
                 "height": "100px"
             });
             $(".tooltips").hide();
    });
}
function mouse()
{
     $(document).mousemove(function(event){
          
          var x = event.pageX-270;
          
          var y = event.pageY;
          
          //switching tooltip to show bellow or above
           if($(window).height() - y < 100 && event.target.className === "OtherCountry")
                {
                   y = event.pageY-150;
                }
         else if($(window).height() - y < 100 && event.target.className === "nuterients"){
            
                y = event.pageY-250;
               
            }
            else
                {
                    y = event.pageY-100;
                }
           //::::::::::::::
         $(".tooltips").css("left", x+"px").css("top", y+"px");
      });
}

