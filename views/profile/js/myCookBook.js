/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){

});

function getProfileMyCookBook()
{
    $('#which_active').html('CB');
    $('#P_cookbook').css({"background": "#F4716A", "color":"white"});
    $('#P_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_followers').css({"background": "#EFEFEF", "color":"grey"});
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $('#meHolderHeader b').css({position: "relative", left:"10px"});
    $('#meHolderHeader img').css({position: "relative", left:"10px"});
    $.ajax({
        url: ""+JURL+"profile/myCookBook",
        type: "GET",
        dataType: "json",
        data: {},
        success: function(data){
            $('#AjaximageLoader').hide();
             $('#LOAD').html("");
            $('#LOAD').html(data);
           
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
             $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
        }
        
    });
}

function getUserProfileMyCookBook(userId)
{
    $('#which_active').html('UCB');
    $('#U_cookbook').css({"background": "#F4716A", "color":"white"});
    $('#U_cookbox').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_followers').css({"background": "#EFEFEF", "color":"grey"});
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
     $('#AjaximageLoader').css({postion: "relative", left: "300px"});
    $.ajax({
        url: ""+JURL+"profile/myCookBook",
        type: "GET",
        dataType: "json",
        data: {userId: userId},
        success: function(data){
            $('#AjaximageLoader').hide();
             $('#LOAD').html("");
            $('#LOAD').html(data);
         
        },
        error: function(data){
             $('#AjaximageLoader').html("something went wrong");
              $('#AjaximageLoader').css({"font-size":"12px", "color":"red"});
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
               }
         });
        
     });
               
}



 function appendLoader(divclass, divclassImg, index)
  {
      $(divclass).eq(index).append('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="15" height="15">');
        $(divclassImg).eq(index).css({"margin-left": "5px", position: "relative", top:"3px"});
  
  }
  
  function removeLoader(divclassImg, index)
  {
      $(divclassImg).eq(index).remove();
  }

function sendUserRecookComment(recipe_post_id, event, reciever_user_id, index)
{
            var recipePostCommentIndex = 2;
    
                if(event.shiftKey && event.keyCode == 13)
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
                   
                }
               else if(event.which === 13)
               {
                   //send recook
                    $('.UserComments #LOADING').eq(index).remove();
                  setLoaderGif(index);
                   var comment  = $('.post_comments_box').eq(index).text();
                   var Tmp_comment = comment.replace(/\s+/g, '');
                   var hashTagTitle = $('.hashTagTitle')[index].innerHTML;
                   var hTagT = hashTagTitle.replace(/\s+/g, '');
                   var foodName = $('.post_flag img.homeFood').eq(index).attr('title');
                   var countryName = $('.post_flag img.homeCountry').eq(index).attr('title');
                  
                  if(Tmp_comment.length !== 0)
                  {
                     
                        $.ajax({
                            type: "POST",
                            url: ""+JURL+"home/postUserComment",
                            data: {comment: comment, recipe_post_id: recipe_post_id, foodName: foodName, countryName: countryName},
                            success: function(data){
                                        $('.UserComments #LOADING').eq(index).remove();
                                      //get comments count after post
                                        getCommentCountAfterPost(recipe_post_id, index);
                                        //get recook or comments after post
                                        getCommentsAfterPost(recipe_post_id, index);
                                        //send notification
                                        sendNotificationHome(recipe_post_id, recipePostCommentIndex, reciever_user_id);
                                   
                             }//success method ends here
                        });
                         
                     $('.post_comments_box').eq(index).html("<p>show how you might make this recipe or Leave a comment</p>");
                     $('.post_comments_box').eq(index).blur();
                  }
                  else
                  {
                         //increase the height if there is nothing typed and enter is pressed
                         $('.post_comments_box').eq(index).css('height', "+=10");
                  }
               }
      
  
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
            type: "POST",
            url: ""+JURL+"home/getUserComment",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
              $('.UserComments').eq(index).html(data);
                $('.commentCounter span').eq(index).html('No more comments to show');
                resetFeed(index);
            }
        });
    }
    
}
function getCommentCountAfterPost(recipe_post_id, index)
{
    $.ajax({
            type: "POST",
            url: ""+JURL+"home/getUserCommentCount",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
                
               if(parseInt(data) > 3){
                  
                $('.commentCounter span').eq(index).html(getuserCommentCountSuffix(data));
                
               }
               else
               {
                  
                       $('.commentCounter span').eq(index).html('No more comments to show');
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



 function getuserCommentCountSuffix(num)
 {
     var message = '';
        if(num >=2)
           message = num+" comments";
        else if(num === 1)
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
            if(data !== ""){
              $('.'+divclass)[index].innerHTML = getuserCookitSurffix(data);
            }

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
   

    return message;
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


function insertTCS(user_id, recipe_owner_user_id, recipe_post_id, tableName, counter)
{
       var recipePostCookedItNotifierIIndex = 5;
       var recipePostTastyItNotifierIndex = 6;
       var recipePostShareItNotifierIIndex = 7;
    removeLoadFunctionBarLoader(tableName, counter);
    loadFunctionBarLoader(tableName, counter);
    
    $.ajax({
        type: "POST",
        url: ""+JURL+"Home/insertTCS",
        dataType: "json",
        data: {user_id: user_id, recipe_post_id: recipe_post_id, owner_user_id: recipe_owner_user_id, tableName: tableName},
        success: function(data){
              removeLoadFunctionBarLoader(tableName, counter);
            
            if(data !== false)
            {
                        if(tableName === "recipe_post_tasty")
                        {
                            if(parseInt(data)  === 1)
                           {
                               $('.post_stats ul li.tastyCount span').eq(counter).html(data);
                               $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" person said this is tasty");
                           }
                           else if(parseInt(data) > 1)
                           {
                               $('.post_stats ul li.tastyCount span').eq(counter).html(data);
                               $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" people said this is tasty");
                              
                           }
                            sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                        }
                        else if(tableName === "recipe_post_cookedit")
                        {
                            if(parseInt(data)  === 1)
                            {
                               $('.post_stats ul li.cookCount span').eq(counter).html(data);
                               $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  person cooked this");
                            }
                            else if(parseInt(data) > 1)
                            {
                                $('.post_stats ul li.cookCount span').eq(counter).html(data);
                                $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  people cooked this");
                            }
                            sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                        }
                        else if(tableName === "recipe_post_share")
                        {
                            if(parseInt(data)  === 1)
                            {
                              $('.post_stats ul li.shareCount span').eq(counter).html(data);
                              $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" person shared this");
                            }
                            else if(parseInt(data) > 1)
                            {
                              $('.post_stats ul li.shareCount span').eq(counter).html(data);
                              $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" people shared this");
                               
                            }
                             sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostShareItNotifierIIndex, recipe_owner_user_id);
                        }
                }
        }
    });
}

function  sendTastyCookedItShareNotificationHome(recipe_post_id, notifierIndex, reciever_user_id)
{
   
    $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: recipe_post_id, index: notifierIndex, reciever_user_id: reciever_user_id},
        success: function(data){
            
        }
    });
    
}

function loadFunctionBarLoader(which, index)
{
    var tasty = 'recipe_post_tasty'; var cook = 'recipe_post_cookedit'; var share = 'recipe_post_share';
    
   var $divclassTasty = $('.post_stats ul li.cookCount span');
   var divclassImgtasty = '.post_stats ul li.cookCount span img';
   
   var $divclassCook = $('.post_stats ul li.cookCount span');
   var divclassImgCook = '.post_stats ul li.cookCount span img';
   
   var $divclassShare = $('.post_stats ul li.shareCount span');
   var divclassImgShare = '.post_stats ul li.shareCount span img';
    
    
    if(which === tasty)
    {
    
        appendLoader($divclassTasty, divclassImgtasty, index);
    }
    else if(which === cook)
    {
        appendLoader($divclassCook,divclassImgCook, index);
    }
    else if(which === share)
    {
        appendLoader($divclassShare,divclassImgShare, index);
    }
}

function removeLoadFunctionBarLoader(which, index)
{
    var tasty = 'recipe_post_tasty'; var cook = 'recipe_post_cookedit'; var share = 'recipe_post_share';
    
    var divclassImgtasty = '.post_stats ul li.cookCount span img';
   
    var divclassImgCook = '.post_stats ul li.cookCount span img';

    var divclassImgShare = '.post_stats ul li.shareCount span img';
   
    if(which === tasty)
    {
        //$('.recipeFuncProgressBar span.tastyCount img').eq(index).remove();
         removeLoader(divclassImgtasty, index);
    }
    else if(which === cook)
    {
        //$('.recipeFuncProgressBarCookedItSharedIt span.cookCount img').eq(index).remove();
        removeLoader(divclassImgCook, index);
    }
    else if(which === share)
    {
        //$('.recipeFuncProgressBarCookedItSharedIt span.shareCount img').eq(index).remove();
         removeLoader(divclassImgShare, index);
    }
}

function SCTSurfix(data, whichPl, whichSig)
{
    if(data === 1)
    {
        data+" "+whichPl;
    }
    else 
    {
        data+" "+whichSig;
    }
}


function showAllComment(index, recipe_post_id){
    var comMessage = 'No more comments to show';
    
    if($('.commentCounter span').eq(index).html() !== comMessage){
        $('.UserComments').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
        $('.UserComments #LOADING').css({position:"relative", left: "230px"});
        $.ajax({
            url: JURL+"Home/showAllComment",
            type: "POST",
            dataType: "json",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
                $('#LOADING').remove();
                     $('.UserComments').eq(index).append(data);
                     $('.commentCounter span').eq(index).html('No more comments to show');
                     resetFeed(index);
            },
            error:function(){
                 $('#LOADING').remove();
            }
        });
    }
    
}

function resetFeed(index){
     var feed_1_bottomMargin  = 100;
                
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



function setFeed_1(index){


		var PC_top = 122;
		var PC_left = 316;
		var topp = 115;
                
                   var feed_1_bottomMargin  = 120;
                
		   var RHeight = $('.post_text ul li.RecpInstr').eq(index).height();
		   var FHeight = $('.feed_1').eq(index).height();
		   var flag = 380;
		   var stat = 390;
		   
		   $('.feed_1').eq(index).height(RHeight+FHeight);
		  
		 
                   
                  var userCommentH =  $('.UserComments').eq(index).height();
                  
		  $('.feed_1').eq(index).css({"margin-bottom": feed_1_bottomMargin+userCommentH}); 
                  
                  var newStat = userCommentH+stat+FHeight-170;
		 var newFlag = userCommentH+flag+FHeight-170;
		   $('.post_flag').eq(index).css({position:"relative", top: -newFlag+"px"} );
		   $('.post_stats').eq(index).css({position:"relative", top: -newStat+"px"} );
		  // $('.picIngShp').eq(index).css({position:"relative", top: topp+RHeight +"px", left:"280px" });
		 // $('.post_comments').eq(index).css({position:"relativee", top: PC_top+RHeight +"px", left: 0+"px" });
		  
		  //var PCom_height = $('.post_comments').eq(index).height();
		  //var PCom_userCom_height = $('.user_comment').eq(index).height();
	
		 // $('.post_comments').eq(index).height(PCom_height+0);
		 // $('.post_comments_box_profile_photo').eq(index).css({position:"relative", top: 26+"px", left: 18+"px"});
		  //$('.post_comments_box').eq(index).css({position:"relative", top: -10+"px", left: 55+"px"});
		   
                            $('.feed_1').eq(index).hover(function(){

                                     $('.post_flag').eq(index).show(800);
                                     $('.post_stats').eq(index).show(800);


                            }, function (){
                                 $(document).click(function(event){
                                     var $tagt =  $(event.target);
                                    
                                     if($tagt.is('.feed_1') || $tagt.is('.post_flag') || $tagt.is('.post_stats')|| 
                                        $tagt.is('.post_stats ul li span') ||  $tagt.is('.post_stats ul') || 
                                        $tagt.is('.post_stats ul li')|| $tagt.is('.post_flag img') || 
                                        $tagt.is('.post_profile_photo') || $tagt.is('.post_profile_photo img') ||
                                         $tagt.is('.post_profile_link')|| $tagt.is('.post_profile_link ul li') ||
                                         $tagt.is('.post_profile_link ul li img') || $tagt.is('.post_text ul li')||
                                        $tagt.is('.post_text ul')|| $tagt.is('.post_text ul li b') || $tagt.is('.post_text') ||
                                        $tagt.is('.picIngShp')|| $tagt.is('.picIngShp ul')||
                                        $tagt.is('.picIngShp ul li')|| $tagt.is('.picIngShp ul li img')){
                                         
                                     }else{
                                        $('.post_flag').eq(index).hide(800);
                                        $('.post_stats').eq(index).hide(800);
                                     }
                                 }) ;
                                 
                                    
                                 
                            });
             

}

function infinitScrollMyCookBook()
{
    
    var pages = 0;
    var CB = 'CB';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            
        
           var myCookbook = $('#which_active').html();
          
             if(myCookbook === CB)
             {
                
                   pages = pages + 6;
                  $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                   $('#userPostLoad').css({"width": "50px", position:"relative", left: "480px", bottom: "50px"});
                    $.post(""+JURL+"profile/infinitScrollMycookBook", {page: pages}, function(data){
                            
                               $("#userPostLoad").empty();
                               $("#myCookBookHolder").append(""+data);

                    }, 'json')
                            .fail(function(){
                                $("#userPostLoad").empty();
                                $("#userPostLoad").html('somthing went wrong');
                                $('#userPostLoad').css({"width": "200px",
                                                                 "height": "20px;",
                                                                color:"red", 
                                                                "font-size":"12", 
                                                                "font-weight":"700", 
                                                                position:"relative", 
                                                                left: "430px"});
                            });
               
             }
             else
             {
                 pages = 0;
             }
        }
    });
}

function UserInfinitScrollMyCookBook(userId)
{
   
    var pages = 0;
    var CB = 'UCB';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
           
            var myCookbook = $('#which_active').text();
            
             if(myCookbook === CB)
             {
                 
                   pages = pages + 6;
                   $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                   $('#userPostLoad').css({"width": "50px", position:"relative", left: "480px", bottom: "50px"});
                   
                    $.post(""+JURL+"profile/infinitScrollMycookBook", {page: pages, userId: userId}, function(data){
                
                               $("#userPostLoad").empty();
                               $("#myCookBookHolder").append(""+data);
                            
                    }, 'json')
                            .fail(function(){
                                $("#userPostLoad").empty();
                                $("#userPostLoad").html('somthing went wrong');
                                $('#userPostLoad').css({"width": "200px",
                                                                 "height": "20px;",
                                                                color:"red", 
                                                                "font-size":"12", 
                                                                "font-weight":"700", 
                                                                position:"relative", 
                                                                left: "430px"});
                            });
                
             }
             else
             {
                 pages = 0;
             }
        }
    });
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
