/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 var temptxtCount = 0;
    var tempTextCountLength = 150;
$(document).ready(function(){
  reciepeUserCommentfocusInFocusout()
});

function reciepeUserCommentfocusInFocusout()
{
    //when mouse is click to type
     var comment = '';
    $(".post_comments_box").each(function(index){
         // var comment = $(this)[index].innerHTML;
  
       $(".post_comments_box").eq(index).focusin(function(){
           
          comment =  $(".post_comments_box").eq(index).text();
             if(comment.indexOf("Leave a comment") !== -1)
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
              $(this).html("<p>Leave a comment</p>");
              $(this).css({"height":"35px"});
                 tempTextCountLength = 150;
               }
         });
        
     });
               
}


function gudRead(article_id, index){
    
    $('.LCS_bar ul li span.like_link').eq(index).html('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="20" >');
    $.ajax({
        url: JURL+"articles/gudRead",
        type: "POST",
        dataType: "json",
        data: {article_id: article_id},
        success: function(data){
            $('.LCS_bar ul li span.like_link').eq(index).html('<img src="'+JURL+'pictures/article/gudRead.png" width="20" title="say its good read">');
            if(data === true || data === 'true'){
                var count = $('.LCS_bar ul li span.art_like_count').html();
                count = parseInt(count) + 1;
                $('.LCS_bar ul li span.art_like_count').eq(index).html(count);
                $('.LCS_bar ul li span.art_like_count').eq(index).attr('title', personpersons(count)+' said this is a good read');
            }else{
                $('.LCS_bar ul li span.like_link').eq(index).html('<img src="'+JURL+'pictures/article/gudRead.png" width="20" title="say its good read">');
            }
        },
        error: function(){
            $('.LCS_bar ul li span.like_link').eq(index).html('<img src="'+JURL+'pictures/article/gudRead.png" width="20" title="say its good read">');
        }
    });
}

function personpersons(number){
    var num = parseInt(number);
    
    if(num === 1){
        return num+ ' person';
    }else{
        num+' persons';
    }
}


function shareArticle(article_id, index){
    $('.LCS_bar ul li span.share_link').eq(index).html('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="20" >');
    $.ajax({
        url: JURL+"articles/shareArticle",
        type: "POST",
        dataType: "json",
        data: {article_id: article_id},
        success: function(data){
            $('.LCS_bar ul li span.share_link').eq(index).html('<img src="'+JURL+'pictures/article/share.png" width="20" title="say its good read">');
            if(data === true || data === 'true'){
                var count = $('.LCS_bar ul li span.art_like_count').html();
                count = parseInt(count) + 1;
                $('.LCS_bar ul li span.art_share_count').eq(index).html(count);
                $('.LCS_bar ul li span.art_share_count').eq(index).attr('title', personpersons(count)+' said this is a good read');
            }else{
                $('.LCS_bar ul li span.share_link').eq(index).html('<img src="'+JURL+'pictures/article/share.png" width="20" title="say its good read">');
            }
        },
        error: function(){
             $('.LCS_bar ul li span.share_link').eq(index).html('<img src="'+JURL+'pictures/article/share.png" width="20" title="say its good read">');
        }
    });
}


function showAllComment(index, article_id){
     var comMessage = 'No more comments to show';
    
    if($('.commentCounter span').eq(index).html() !== comMessage){
        $('#LOADING').remove();
        $('.user_comments_holder').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
        $('.user_comments_holder #LOADING').css({position:"relative", left: "230px"});
        $.ajax({
            url: JURL+"articles/showAllComment",
            type: "POST",
            dataType: "json",
            data: {article_id: article_id},
            success: function(data){
           $('#LOADING').remove();
                $('.user_comments_holder').eq(index).append(data);
                $('.commentCounter span').eq(index).html('No more comments to show');
                
            },
            error: function(){
                  $('#LOADING').remove();
            }
        });
    }
}

function sendUserRecookComment(article_id, event, reciever_user_id, index)
{
            var textCountLength = 150;
            var recipePostCommentIndex = 2;
            var comment  = $('.post_comments_box').eq(index).text();
            var Tmp_comment = comment.replace(/\s+/g, '');
                  
            var pcb = document.getElementsByClassName('post_comments_box')[index];
                if(event.shiftKey && event.keyCode === 13)
                {
                
                    //increat height
                    $('.post_comments_box').eq(index).css('height', "+=10");
                    
                    //break text
                    var content = $('.post_comments_box').eq(index).val();
                    var caret = getCaret($('.post_comments_box').eq(index));
                    var newVal = content.substring(0,caret)+
                     "\n"+content.substring(caret,content.length);
                    
                    $('.post_comments_box').eq(index).val(newVal);
                    event.stopPropagation();
                   
                }else if(event.which === 13 && Tmp_comment.length === 0){
                    //increat height
                    $('.post_comments_box').eq(index).css('height', "+=10");
                    
                    //break text
                    var content = $('.post_comments_box').eq(index).val();
                    var caret = getCaret($('.post_comments_box').eq(index));
                    var newVal = content.substring(0,caret)+
                     "\n"+content.substring(caret,content.length);
                    
                    $('.post_comments_box').eq(index).val(newVal);
                    event.stopPropagation();
                }else if(event.which === 13){
                   $('.user_comments_holder #LOADING').eq(index).remove();
                  //setLoaderGif(index);
                 
                  if(Tmp_comment.length !== 0)
                  {
                    $('.user_comments_holder').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
                    $('.user_comments_holder #LOADING').css({position:"relative", left: "230px"});
                        tempTextCountLength = 150;
                        $.ajax({
                            type: "POST",
                            url: ""+JURL+"articles/postUserComment",
                            dataType: "json",
                            data: {comment: comment, article_id: article_id},
                            success: function(data){
                                
                                if(data === true){
                                        $('.user_comments_holder #LOADING').eq(index).remove();
                                      //get comments count after post
                                       getCommentCountAfterPost(article_id, index);
                                        //get recook or comments after post
                                       
                                        //send notification
                                       // sendNotificationHome(article_id, recipePostCommentIndex, reciever_user_id);
                                   
                                }else{
                                     $('.user_comments_holder #LOADING').eq(index).remove();
                                     $('.user_comments_holder').eq(index).append("<span>"+data+"</span>");
                                     $('.user_comments_holder span').eq(index).css({"color" :"red", 
                                                                                        "font-size": "12px",
                                                                                        position: "relative",
                                                                                        left: "150px"});
                                     
                                }
                                    
                             },//success method ends here
                             error: function(){
                                   $('.user_comments_holder #LOADING').eq(index).remove();
                              }
                        });
                         
                     $('.post_comments_box').eq(index).html("<p>Leave a comment</p>");
                     $('.post_comments_box').eq(index).blur();
                  }else{
                               //increase the height if there is nothing typed and enter is pressed
                               $('.post_comments_box').eq(index).css('height', "+=10");

                                //break text
                                var content = $('.post_comments_box').eq(index).val();
                                var caret = getCaret($('.post_comments_box').eq(index));
                                var newVal = content.substring(0,caret)+
                                 "\n"+content.substring(caret,content.length);

                                $('.post_comments_box').eq(index).val(newVal);
                                event.stopPropagation();
                               $('.article').eq(index).css({"margin-bottom": "+=10"});
                        }
               }else{
                
                     //check to see if var is 186 add 10 to the height and plus with the defined variable
                     temptxtCount = getCaretCharacterOffsetWithin(pcb);
                     if(temptxtCount === 1){tempTextCountLength = 150;}
                      // $('.UserComments').eq(index).html(temptxtCount);4
                      //alert(temptxtCount);
                     if(temptxtCount === tempTextCountLength){
                           $('.post_comments_box').eq(index).css({'height':"+=30"});
                           $('.article').eq(index).css({"margin-bottom": "+=30"});
                           tempTextCountLength = tempTextCountLength + 150 ;
                     }
               }
               
               // work on user pasting content here
               //var ctrlDown = false;
                //var ctrlKey = 17, vKey = 86, cKey = 67;
      
  
}

function getCommentsAfterPost(article_id, index){
    //var comMessage = 'No more comments to show';
    //var commentCount = $('.commentCounter span').eq(index).text();
   
    //if(commentCount === comMessage){
            $.ajax({
                type: "POST",
                url: ""+JURL+"articles/getArticleCommentPost",
                dataType: "json",
                data: {article_id: article_id},
                success: function(data){
                    $('.user_comments_holder #LOADING').eq(index).remove();
                    $('.user_comments_holder').eq(index).html(data);


                }
            });
    //} 
}

function getCommentCountAfterPost(article_id, index){
   $('.user_comments_holder').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
   $('.user_comments_holder #LOADING').css({position:"relative", left: "230px"});
    
    var comMessage = 'No more comments to show';
    var commentCount = $('.commentCounter span').eq(index).text();
   
    if(commentCount !== comMessage){
            ajaxCommentCount(article_id, index);
    }else{
        
            if(checkCommentSize()){
                 ajaxCommentCount(article_id, index);
            }else{;
                 getCommentsAfterPost(article_id, index);
            }
    }
}

function ajaxCommentCount(article_id, index){
     $.ajax({
                type: "POST",
                url: ""+JURL+"articles/getUserCommentCount",
                dataType: "json",
                data: {article_id: article_id},
                success: function(data){
                    $('.user_comments_holder #LOADING').eq(index).remove();
                   if(parseInt(data) > 3){
                       var remMesNum = parseInt(data) - 3;
                       var message = "Show "+remMesNum+" more messages"
                       $('.commentCounter span').eq(index).html(message);

                   }else{
                        
                        var message = 'No more comments to show';
                        $('.commentCounter span').eq(index).html(message);
                   }
                }
            });
}

function checkCommentSize(){
    var comSize = $('.user_name').size();
    
    if(comSize >= 3){
        return true;
    }else{
        return false;
    }
}

function showAllcomments(article_id, index){
   $('.user_comments_holder').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
   $('.user_comments_holder #LOADING').css({position:"relative", left: "230px"});
   
   var comMessage  = 'No more comments to show';
   $('.commentCounter span').eq(index).text(comMessage);
   
   getCommentsAfterPost(article_id, index);
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