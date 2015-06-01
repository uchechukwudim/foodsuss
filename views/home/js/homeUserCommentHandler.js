/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    var temptxtCount = 0;
    var tempTextCountLength = 150;
$(document).ready(function(){

   //sendUserRecookComment();
   // getUserComment();
   // getUserCommentCount();
     infinitScrollHomeRecipeLoader();
     reciepeUserCommentfocusInFocusout();
     //setCookView();

});

function reciepeUserCommentfocusInFocusout()
{
    //when mouse is click to type
  
     var comment = '';
    $(".post_comments_box").each(function(index){
         // var comment = $(this)[index].innerHTML;
    
       $(".post_comments_box").eq(index).focusin(function(){
               
          comment =  $(".post_comments_box").eq(index).text();

          if(comment.indexOf("show how you might make") !== -1)
              {
                   $(".post_comments_box").eq(index).html("");
                   $(".post_comments_box").eq(index).focus();
              }
           
       });
       
    });

    //when mouse is click out of textarea
     $(".post_comments_box").each(function(index){
         $(this).focusout(function(){
               if($(this).text().length === 0){
              $(this).html("<p>show how you might make this recipe or Leave a comment</p>");
              $(this).css({"height":"35px"});
                 tempTextCountLength = 150;
               }
         });
        
     });
               
}

function sendUserRecookComment(recipe_post_id, event, reciever_user_id, food_id, country_id)
{
            var textCountLength = 150;
            var recipePostCommentIndex = 2;
            var pcb = document.getElementsByClassName('post_comments_boxx')[index];
                if(event.shiftKey && event.keyCode === 13){
                    //break text
                    var content = $('.post_comments_boxx').eq(index).val();
                    var caret = getCaret($('.post_comments_box').eq(index));
                    var newVal = content.substring(0,caret)+
                     "\n"+content.substring(caret,content.length);
                    
                    $('.post_comments_boxx').eq(index).val(newVal);
                    event.stopPropagation();
                   
                }else if(event.which === 13){
                   
                                //send recook
                                var comment  = $('.post_comments_boxx').text();
                                var Tmp_comment = comment.replace(/\s+/g, '');
                                
                               if(Tmp_comment.length !== 0){
                                   setLoaderGif(index);
                                            tempTextCountLength = 150;
                                            $.ajax({
                                                type: "POST",
                                                url: ""+JURL+"home/postUserComment",
                                                dataType: "json",
                                                data: {comment: comment, recipe_post_id: recipe_post_id, food_id: food_id, country_id: country_id},
                                                success: function(data){
                                                            $('.UserComments #LOADING').eq(index).remove();
                                                          //get comments count after post
                                                            getCommentCountAfterPost(recipe_post_id);
                                                            //get recook or comments after post
                                                            getCommentsAfterPost(recipe_post_id);
                                                            //send notification
                                                            sendNotificationHome(recipe_post_id, recipePostCommentIndex, reciever_user_id);

                                                 },//success method ends here
                                                 error: function(){
                                                       $('.UserComments #LOADING').eq(index).remove();
                                                  }
                                            });

                                         $('.post_comments_box').eq(index).html("<p>show how you might make this recipe or Leave a comment</p>");
                                         $('.post_comments_box').eq(index).blur();
                                }else{
                                         //increase the height if there is nothing typed and enter is pressed
                                         $('.post_comments_box').eq(index).css({'height':"+=10"});
                                         $('.feed_1').eq(index).css({"margin-bottom": "+=10"});
                                     }
               }else{
                
                     //check to see if var is 186 add 10 to the height and plus with the defined variable
                     temptxtCount = getCaretCharacterOffsetWithin(pcb);
                     if(temptxtCount === 1){tempTextCountLength = 150;}
                      // $('.UserComments').eq(index).html(temptxtCount);4
                      //alert(temptxtCount);
                     if(temptxtCount === tempTextCountLength){
                           $('.post_comments_box').eq(index).css({'height':"+=30"});
                           $('.feed_1').eq(index).css({"margin-bottom": "+=30"});
                           tempTextCountLength = tempTextCountLength + 150 ;
                     }
               }
               
               // work on user pasting content here
               //var ctrlDown = false;
                //var ctrlKey = 17, vKey = 86, cKey = 67;
      
  
}

function setLoaderGif(index){
     $('.UserComments').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div></>");
     $('.UserComments #LOADING').eq(index).css({position:"relative", left: "520px", top: "59px"});
}

function getCommentsAfterPost(recipe_post_id, index)
{
     var comMessage = 'No more comments to show';

    var commentCount = $('.commentCounter span').eq(index).text();
   
    if(commentCount === comMessage){
        $.ajax({
            type: "GET",
            url: ""+JURL+"home/getUserComment",
            dataType: "json",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
              $('.UserComments').eq(index).html(data);
               // $('.commentCounter span').eq(index).html('No more comments to show');
                resetFeedcom(index);
            }
        });
    }
    
}
function getCommentCountAfterPost(recipe_post_id, index)
{
    var comMessage = 'No more comments to show';

    var commentCount = $('.commentCounter span').eq(index).text();
   
    //if(commentCount !== comMessage){
        $.ajax({
                type: "GET",
                url: ""+JURL+"home/getUserCommentCount",
                dataType: "json",
                data: {recipe_post_id: recipe_post_id},
                success: function(data){

                   if(parseInt(data) > 3){
                       var remMesNum = parseInt(data) - 3;
                       var message = "Show "+remMesNum+" more messages"
                       $('.commentCounter span').eq(index).html(message);

                   }
                   else
                   {
                      var message = 'No more comments to show';
                        $('.commentCounter span').eq(index).html(message);
                   }
                }
            });
    //}
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

function getUserComment()
{
    
    $('.homeUserComments').each(function(index){
        var HashTagTitle = $('.hashTagTitle')[index].innerHTML;
         var rTitle = HashTagTitle.replace(/\s+/g, '');
           $.ajax({
            type: "GET",
            url: ""+JURL+"home/getUserComment",
            dataType: "json",
            data: {hashTagTitle: rTitle},
            success: function(data){
               $('.homeUserComments')[index].innerHTML = ""+data;
            }
        });
    });
}

function getUserCommentCount()
{
  
    $('.homeUserComments').each(function(index){
        var HashTagTitle = $('.hashTagTitle')[index].innerHTML;
         var rTitle = HashTagTitle.replace(/\s+/g, '');
         $.ajax({
            type: "GET",
            url: ""+JURL+"home/getUserCommentCount",
            dataType: "json",
            data: {hashTagTitle: rTitle},
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
    });
}

function getSingleUserComment(HashTagtitle, classIndex)
{
       $.ajax({
            type: "POST",
            url: ""+JURL+"home/getUserComment",
            dataType: "json",
            data: {hashTagTitle: HashTagtitle},
            success: function(data){
               $('.homeUserComments')[classIndex].innerHTML = ""+data;
            }
        });
}

function getSingleUserCommentCount(HashTagtitle, classIndex)
{
     $.ajax({
            type: "POST",
            url: ""+JURL+"home/getUserCommentCount",
            dataType: "json",
            data: {hashTagTitle: HashTagtitle},
            success: function(data){
               if(data != 0){
               $('.homeCommentsCount')[classIndex].innerHTML = getuserCommentCountSuffix(data);
                 $('.homeNumberOfcomments')[classIndex].style.display = "block";
               }
               else
               {
                       $('.homeCommentsCount')[classIndex].innerHTML = "No comments";
               }
            }
        });
}

 function getuserCommentCountSuffix(num)
 {
     var message = '';
        if(num >=2)
           message = num+" comments";
        else if(num == 1)
          message = num+" comment";
       
        
        return message;
 }
 
 function countUsertryIt(id, recipe_post_id, food_id, country_id, divclass, index)
{

    $.ajax({
        url: ""+JURL+"home/userTryItCounter",
        type: "POST",
        data: {recipe_post_comments_id: id, recipe_post_id: recipe_post_id, food_id: food_id, country_id: country_id },
        success: function(data)
        {
 
              $('.'+divclass)[index].innerHTML = getuserCookitSurffix(data);

        }
    });
}

function getuserCookitSurffix(num)
{
   var message = '';
   if(num == 1)
      message = num+" person TriedIt";
    else if(num >1)
       message = num+" people TriedIt";
    else if(num < 1)
        message = 'No cooks yet';
    

    return message;
}

function infinitScrollHomeRecipeLoader()
{
    var prev = 1;
    var next = 1;
    var pages = 0;
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            
            if(getWhichSideBarOptionToRun() == null)
            {
                $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                $('#postload').css({"width": "50px"});
                    pages = pages + 6;
                   $.post(""+JURL+"home/infinitScrollHomeRecipeLoader", {page: pages}, function(data){
        
                          $("#postload").empty();
                          $("#feeds").append(""+data);

                   }, 'json').fail(function(){
                                $("#postload").empty();
                                $("#postload").html('somthing went wrong');
                              
                            });
            }
        }
    });
}

function getWhichSideBarOptionToRun()
{
    var which = '';
    
    if($('#chefsFollowFriendsHeader').text() !== "")
    {
        which  = 'Chef';
    }
    else if($('#foodFollowingHeader').text() !== "")
    {
        which = 'Food';
    }
    else if($('restFollowFriendsHeader').text() !== "")
    {
        which = 'Restaurant';
    }
    else
    {
     
        which  = null;
    }
    
    return which;
}


function setCookViewCss(cookedItView)
{

    $("."+cookedItView).css({
        "width": "100px",
        "font-size": "12px",
        "color": "#cccccc",
         position: "relative",
         left: "310px",
         top: "-8px"
    

    });
}

function resetFeedcom(index){
     var feed_1_bottomMargin  = 50;
                
		   var RHeight = $('.post_text ul li.RecpInstr').eq(index).height();
		   var FHeight = $('.feed_1').eq(index).height();
		   var flag = 310;
		   var stat = 320;
		   
		   $('.feed_1').eq(index).height(RHeight+FHeight);
		  
		 
                   
                  var userCommentH =  $('.UserComments').eq(index).height();
                  
		  $('.feed_1').eq(index).css({"margin-bottom": feed_1_bottomMargin+userCommentH}); 
                  
                  var newStat = userCommentH+stat+FHeight-150;
		 var newFlag = userCommentH+flag+FHeight-150;
		   $('.post_flag').eq(index).css({position:"relative", top: -newFlag+"px"} );
		   $('.post_stats').eq(index).css({position:"relative", top: -newStat+"px"} );
}


function getCaretCharacterOffsetWithin(element) {
      var caretOffset = 0;
    var doc = element.ownerDocument || element.document;
    var win = doc.defaultView || doc.parentWindow;
    var sel;
    if (typeof win.getSelection != "undefined") {
        sel = win.getSelection();
        if (sel.rangeCount > 0) {
            var range = win.getSelection().getRangeAt(0);
            var preCaretRange = range.cloneRange();
            preCaretRange.selectNodeContents(element);
            preCaretRange.setEnd(range.endContainer, range.endOffset);
            caretOffset = preCaretRange.toString().length;
        }
    } else if ( (sel = doc.selection) && sel.type != "Control") {
        var textRange = sel.createRange();
        var preCaretTextRange = doc.body.createTextRange();
        preCaretTextRange.moveToElementText(element);
        preCaretTextRange.setEndPoint("EndToEnd", textRange);
        caretOffset = preCaretTextRange.text.length;
    }
  return caretOffset;
}