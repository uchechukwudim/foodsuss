/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
  reciepeUserCommentfocusInFocusout();
  //sendUserComment();
  showUserReccokComments();
});


function reciepeUserCommentfocusInFocusout()
{
    //when mouse is click to type
     var comment = '';
    $(".usertextareaHome").each(function(index){
         // var comment = $(this)[index].innerHTML;
       $(this).focusin(function(){
          comment = $(this).text();
          if(comment.indexOf("Show how you make") !== -1)
              {
                  $(this).html("");
                  $(this).focus();
              }
           
       });
       
    });

    //when mouse is click out of textarea
     $(".usertextareaHome").each(function(index){
         $(this).focusout(function(){
               if($(this).text().length === 0){
              $(this).html("<p>Show how you make "+$('.hashTagTitle')[index].innerHTML+".... or Leave a comment</p>");
               }
         });
        
     });
               
}

function sendUserComment(recipe_post_id, event, reciever_user_id, index)
{
    
      var recipePostCommentIndex = 2;
      var enter = 13;
                if(event.shiftKey && event.keyCode === enter)
                {
                
                    //increat height
                    $('.usertextareaHome').eq(index).css('height', "+=10");
                    
                    //break text
                    var content = $('.usertextareaHome').eq(index).val();
                    var caret = getCaret($('.usertextareaHome').eq(index));
                    var newVal = content.substring(0,caret)+
                     "\n"+content.substring(caret,content.length);
                    
                    $('.usertextareaHome').eq(index).val(newVal);
                    event.stopPropagation();
                   
                }
               else if(event.keyCode === enter)
               {
                   //alert(event.keyCode);
                   //send recook
                   var $divclass = $('.homeCommentsCount');
                   var divclassImg = '.homeCommentsCount img';
                   appendLoader($divclass, divclassImg, index);
                   
                  var comment  = $('.usertextareaHome').eq(index).text();
                  var Tmp_comment = comment.replace(/\s+/g, '');
                  var hashTagTitle = $('.hashTagTitle')[index].innerHTML;
                  var hTagT = hashTagTitle.replace(/\s+/g, '');
                  var foodName = $('.homeFood img').eq(index).attr('title');
                  var countryName = $('.homeCountry img').eq(index).attr('title');
                  
                  if(Tmp_comment.length !== 0)
                  {
                     
                        $.ajax({
                            type: "POST",
                            url: ""+JURL+"home/postUserComment",
                            data: {comment: comment, recipe_post_id: recipe_post_id, foodName: foodName, countryName: countryName},
                            success: function(data){
                                        var divclassImg = '.homeCommentsCount img';
                                        removeLoader(divclassImg, index);
                                        //get recook or comments after post
                                        getCommentsAfterPost(recipe_post_id, index);
                                        //get comments count after post
                                        getCommentCountAfterPost(recipe_post_id, index);
                                        //send notification
                                        sendNotificationHome(recipe_post_id, recipePostCommentIndex, reciever_user_id);
                                   
                             },//success method ends here
                             error:function(){
                                 var divclassImg = '.homeCommentsCount img';
                                  removeLoader(divclassImg, index);
                             }
                        });
                         
                     $('.usertextareaHome').eq(index).html("<p>Show how you make "+$('.hashTagTitle')[index].innerHTML+".... Or Leave a comment</p>");
                     $('.usertextareaHome').eq(index).blur();
                  }
                  else
                  {
                         //increase the height if there is nothing typed and enter is pressed
                         $('.usertextareaHome').eq(index).css('height', "+=10");
                  }
               }
      
}
  function removeLoader(divclassImg, index)
  {
      $(divclassImg).remove();
      //$(divclassImg).eq(index).remove();
  }
  
   function appendLoader(divclass, divclassImg, index)
  {
      $(divclass).eq(index).append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
        $(divclassImg).css({"margin-left": "5px", position: "relative", top:"3px"});
  
  }
  
  
function getCommentsAfterPost(recipe_post_id, index)
{
    $.ajax({
            type: "POST",
            url: ""+JURL+"home/getUserComment",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
              $('.homeUserComments')[index].innerHTML = ""+data;
              $('.homeNumberOfcomments')[index].style.display = "block";

            }
        });
}
function getCommentCountAfterPost(recipe_post_id, index)
{
    $.ajax({
            type: "POST",
            url: ""+JURL+"home/getUserCommentCount",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
               if(data != 0){
               $('.homeCommentsCount')[index].innerHTML = getuserCommentCountSuffix(data);
                 $('.homeNumberOfcomments')[index].style.display = "block";
               }
               else
               {
                       $('.homeCommentsCount')[index].innerHTML = "No comments";
               }
            }
        });
}

function  sendNotificationHome(recipe_post_id, recipePostCommentIndex, reciever_user_id)
{
    $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: recipe_post_id, index: recipePostCommentIndex, reciever_user_id: reciever_user_id},
        success: function(data){
            
        }
    });
}

 function showUserReccokComments()
 {
     $('.homeNumberOfcomments').each(function(index){
           $(this).click(function(){
               $('.homeUserComments')[index].style.display = "block";
                
           });
     });
 }
 
 function infinitScrollHomeRecipeLoader()
{
   
    var pages = 0;
    var country = $('#countryMeal span.CM img').attr('title');
    var food = $('#FoodMeal span.FN img').attr('title');
    var userType =  $('#RecipeSwitchHolder').text();
    $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="20px" hieght="20px">');
     $("#postload").css({
                   position: "relative",
                   left: "520px",
                   top: "25px"
                 });
                 
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            var switcher = $('#counterHolder').text();
            
            if(switcher === "0")
            {
                pages = 0;
                 pages = pages + 6;
                $('#counterHolder').text('1');
            }
            else
            {
                   pages = pages + 6;
            }
              //pages = pages + 3;
             $.get(""+JURL+"foodFinder/infinitScrollHomeRecipeLoader", {page: pages, foodName: food, countryName: country, userType: userType}, function(data){
                
                    $("#postload").empty();
                    $("#recipesHolder").append(""+data);
                     reciepeUserCommentfocusInFocusout();
                     sendUserComment();
                     showUserReccokComments();
                    infinitScrollHomeRecipeLoader();
                 
                 
             }, 'json').fail(function(){
                            $("#postload").html("something went wrong");
                            $("#postload").css({"color":"orangered"});
                      });
        }
    });
}

