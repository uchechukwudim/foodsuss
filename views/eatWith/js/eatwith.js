/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
    //sendUserRecookComment();
  
     onHoverLike();
    reciepeUserCommentfocusInFocusout();
    infinitScrollEatWithLoader();
});


function reciepeUserCommentfocusInFocusout()
{
    //when mouse is click to type
     var comment = '';
    $(".EatWithUsercomment").each(function(index){
         // var comment = $(this)[index].innerHTML;
       $(this).focusin(function(){
          comment = $(this).text();
          if(comment.indexOf("Leave a comment.....") !== -1)
              {
                  $(this).html("");
                  $(this).focus();
                  $(this).css('height', "-=40");
                   $(this).css('height', "+=40");
                   $(this).css('color', "grey");
              }
           
       });
       
    });

    //when mouse is click out of textarea
     $(".EatWithUsercomment").each(function(index){
         $(this).focusout(function(){
               if($(this).text().length === 0){
              $(this).html("Leave a comment.....");
              $(this).css('color', "rgba(0, 0, 0, 0.2)");
               //$(this).css('height', "-=40");
               }
         });
        
     });
               
}
function sendUserComment(eatWith_id, event, index)
{
    
    var key = event || window.event;
    var eatWithIndex = 4;
    var eatWithComment = "Commented on your EatWith post";
    
     if(key.shiftKey && key.keyCode == 13)
     {
         //increat height
         $(this).css('height', "+=10");

         //break text
         var content = this.value;
         var caret = getCaret(this);
         this.value = content.substring(0,caret)+
          "\n"+content.substring(caret,content.length);
         event.stopPropagation();


     }
    else if(key.which === 13)
    {
         $('.imgAjxLoad').eq(index).hide();
      $('.imgAjxLoad').eq(index).show();
        //send comment
      var cmText_original = 'No comment';
       var Comment = $('.EatWithUsercomment').eq(index).text();
       var Tmp_comment = Comment.replace(/\s+/g, '');

       if(Tmp_comment.length !== 0 && Tmp_comment.length >3)
       {

             $.ajax({
                 type: "POST",
                 url: ""+JURL+"eatWith/postUserComment",
                 data: {commentText: Comment, eatWith_id: eatWith_id},
                 success: function(data){
                     sendEatWithNotification(eatWith_id, eatWithComment,  eatWithIndex);
                      //get comments after post
                      var temp =     $('.commentsCount span').eq(index).text();
                      if(temp.replace(/\s+/g, '') === cmText_original.replace(/\s+/g, '')){
                          $('.EatWithcommentsHolder')[index].style.display = "block";
                         $('.EatWithcommentsHolder').eq(index).html(""+data);
                         $('.commentsCount span').eq(index).html(getuserCommentCountSuffix(getUserCommentCount(index)+1));
                      }
                      else{
                           $('.EatWithcommentsHolder').eq(index).append(""+data);
                            $('.commentsCount span').eq(index).html(getuserCommentCountSuffix(getUserCommentCount(index)+1));
                      }
                         $('.imgAjxLoad').eq(index).hide();
                  },//success method ends here
                  error:function(){
                      $('.imgAjxLoad').eq(index).hide();
                  }
             });

           $('.EatWithUsercomment').eq(index).html("<p>Leave a comment.....</p>");
           $('.EatWithUsercomment').eq(index).css('color', "rgba(0, 0, 0, 0.2)");

            reciepeUserCommentfocusInFocusout();
           $('.EatWithUsercomment').eq(index).blur();
       }
       else
       {
              //increase the height if there is nothing typed and enter is pressed
             $('.EatWithUsercomment').eq(index).css('height', "+=10");
       }
    }
           

}

function getUserCommentCount(index)
{
    var commentCountText = new String(""+$('.commentsCount span').eq(index).text());
    var commentCount ='';
    var i = 0;
    var Ncomment = 'No comment';
    

    if(commentCountText.replace(/\s+/g, '') === Ncomment.replace(/\s+/g, '')){
       
        return 0;
    }else{
            while(commentCountText.charAt(i) !== " ")
            {

               commentCount = commentCount+commentCountText.charAt(i);
               i++;
            }

            return parseInt(commentCount);
        } 
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
 
 function onHoverLike()
 {
     $('.PicVidinfoBar img').hover(function(){
         $('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/eatWith/liked_img.png');
     }, function(){
         $('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/eatWith/like_img.png');
     });
 }
 
 function eatWithLikes(eatWith_id, index)
 {
     var eatWithIndex = 4;
     var eatWithTasty = "said your EatWith post is Tasty";
    
     $('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/general_smal_ajax-loader.gif');
     $('.PicVidinfoBar img').hover(function(){},function(){$('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/general_smal_ajax-loader.gif');});
     $.ajax({
       url: ""+JURL+"eatWith/inserteatWithLikes",
       type: "POST",
       dataType: "json",
       data:{eatWith_id: eatWith_id},
       success:function(data){
       sendEatWithNotification(eatWith_id, eatWithTasty,  eatWithIndex);
       $('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/eatWith/like_img.png');
        onHoverLike();
           if(data)
           {
               $('.PicVidinfoBar span').text(getLikesPrefix(getUserLikesCount(index)+1));
           }else{
                   
           }
              
       },
       error:function(){
            $('.PicVidinfoBar img').attr('src', ''+JURL+'pictures/eatWith/like_img.png');
       }
     });
 }
 
 function getLikesPrefix(num)
    {
        var message = '';
        if(num >=2)
           message = num+" people said is tasty";
        else if(num == 1)
         message = num+" person said is tasty";
       else
            message = " No Tasty's";
        
        return message;
    }
    
function getUserLikesCount(index)
{
    var likesCountText = new String(""+$('.PicVidinfoBar span').eq(index).text());
    var likesCount ='';
    var i = 0;
    var Nlikes = "No Tasty's";
    

    if(likesCountText.replace(/\s+/g, '') === Nlikes.replace(/\s+/g, '')){
       
        return 0;
    }else{
            while(likesCountText.charAt(i) !== " ")
            {

               likesCount = likesCount+likesCountText.charAt(i);
               i++;
            }

            return parseInt(likesCount);
        } 
}


 
 function infinitScrollEatWithLoader()
{
    var prev = 1;
    var next = 1;
    var pages = 0;
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            
            if(getWhichSideBarOptionToRun(pages) == null)
            {
                 $("#postload").empty();
                 $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                 $('#postload').css({"width": "50px"});
                 pages = pages + 8;
                   $.post(""+JURL+"eatWith/infinitScrollEatWithLoader", {page: pages}, function(data){
      
                          $("#postload").empty();
                          $("#EatWithHolder").append(""+data);
                          showUserComments();
                          onHoverLike();
                          reciepeUserCommentfocusInFocusout();
                          
                   }, 'json');
            }
        }
    });
}

function getWhichSideBarOptionToRun(pages)
{
    var which = '';
    
    if($('#chefsFollowFriendsHeader').text() != "")
    {
        which  = 'Chef';
    }
    else if($('#foodFollowingHeader').text() != "")
    {
        which = 'Food';
    }
    else if($('restFollowFriendsHeader').text() != "")
    {
        which = 'Restaurant';
    }
    else
    {
        which  = null;
    }
    
    return which;
}

function sendEatWithNotification(eatWith_id, which,  eatWithIndex)
{
     $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: eatWith_id, which: which, index: eatWithIndex},
        success: function(data){
            
        }
    });
}



function showEatwithUserComment(eatWith_id, index){
       var comment = "No more comments to show";
        var tempCom = $('.commentsCount span').eq(index).text();
          $('.EatWithcommentsHolder img.EWLOAD').remove();
        $('.EatWithcommentsHolder').eq(index).append('<img style="position: relative; left: 200px; bottom: 10px;" class="EWLOAD" src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="25" >');
   
     if(comment !== tempCom){
        $.ajax({
                url: JURL+"eatWith/showEatWithUserComment",
                type: "GET",
                dataType:"json",
                data:{eatWith_id: eatWith_id},
                success:function(data){
                    $('.EatWithcommentsHolder img.EWLOAD').remove();
                    $('.commentsCount span').eq(index).text("No more comments to show");
                    $('.EatWithcommentsHolder').eq(index).append(data);
                },
                error:function(){
                     $('.EatWithcommentsHolder img.EWLOAD').remove();
                }
        });
     }

}




