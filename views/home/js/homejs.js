

var picture = '';
var content = '';


$(document).ready(function(){

   // hideReciepieImageDialogOnLoad();
   // closeImageReciepieDialog();
    turnLightOn();

});

function turnLightOn()
{
 
     $('.H_light').css({"border-bottom":"3px solid orangered"});
     $('.P_light').css({"border-bottom":"0px solid orangered"});
     $('.F_light').css({"border-bottom":"0px solid orangered"});
     $('.M_light').css({"border-bottom":"0px solid orangered"});
}

function strechHeader(){
    
}

function inputFocus(){
       $(".btnTag").hide();
        $("#inputFood").focus(function(){
                $("#inputFood").css('height', function(index){
                      return index += 50;
                });
                
                $("#makeReciepe").css('height', function(index){
                      return index += 150;
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

function displaysettings()
{
    var val = false;
    $("#settings span#Nsetting").click(function(){
        
        if(!val)
            {
                $("ul#navMenu li").show();
                val = true;
            }
            else
                {
                     $("ul#navMenu li").hide();
                     val = false;
                }
        
    }, function(){
        $("ul#navMenu li").hide();
    });
    
}



function getCountryFoodName(foodId, countryId, counter)
{
    $.ajax({
        type: "POST",
        url: ""+JURL+"home/getCountryFoodName",
        dataType: "json",
        data: {food_id: foodId, country_id: countryId},
        success: function(data){
            $('.homeCountry').eq(counter).html(data[0].country_names);
             $('.homeFood').eq(counter).html(data[0].food_name);
        },
        error: function(){
                
        }
    });
}



 

 
function getShare(recipe_post_Id, counter)
{
    $.ajax({
        type: "POST",
        url: ""+JURL+"home/getShare",
        dataType: "json",
        data: {recipe_post_id: recipe_post_Id},
        success: function(data){
            if(data === "1")
            {
              $('.recipeFuncProgressBar span.shareCount').eq(counter).html(data+" person shared this");
            }
            else
            {
                $('.recipeFuncProgressBar span.shareCount').eq(counter).html(data+" people shared this");
            }
        }, 
        error: function(){
                
        }
    });
}
function getTasty(recipe_post_Id, counter)
{
    $.ajax({
        type: "POST",
        url: ""+JURL+"home/getTasty",
        dataType: "json",
        data: {recipe_post_id: recipe_post_Id},
        success: function(data){
            if(data === "1")
            {
              $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" person said this is Tasty");
            }
            else
            {
                $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" people said this is Tasty");
            }
           
        },
         error: function(){
                
        }
    });
}
function getCookedit(recipe_post_Id, counter)
{
    $.ajax({
        type: "POST",
        url: ""+JURL+"home/getCookedit",
        dataType: "json",
        data: {recipe_post_id: recipe_post_Id},
        success: function(data){
         
             if(data == "1")
            {
              $('.recipeFuncProgressBar span.cookCount').eq(counter).html(data+" person cooked this");
            }
            else
            {
                $('.recipeFuncProgressBar span.cookCount').eq(counter).html(data+" people cooked this");
            }
          
        },
         error: function(){
                
        }
    });
}
 function appendLoader(divclass, divclassImg, index)
  {
   
      $(divclass).eq(index).append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15" height="15">');
        $(divclassImg).css({"margin-left": "5px", position: "relative", top:"3px"});
  
  }
  
  function removeLoader(divclassImg, index)
  {
      $(divclassImg).remove();
      //$(divclassImg).eq(index).remove();
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
        url: ""+JURL+"home/insertTCS",
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
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                           }
                           else if(parseInt(data) > 1)
                           {
                               $('.post_stats ul li.tastyCount span').eq(counter).html(data);
                               $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" people said this is tasty");
                              sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                           }
                            
                        }
                        else if(tableName === "recipe_post_cookedit")
                        {
                            if(parseInt(data)  === 1)
                            {
                               $('.post_stats ul li.cookCount span').eq(counter).html(data);
                               $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  person cooked this");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                            }
                            else if(parseInt(data) > 1)
                            {
                                $('.post_stats ul li.cookCount span').eq(counter).html(data);
                                $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  people cooked this");
                                sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                            }
                        
                        }
                        else if(tableName === "recipe_post_share")
                        {
                            if(parseInt(data)  === 1)
                            {
                              $('.post_stats ul li.shareCount span').eq(counter).html(data);
                              $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" person shared this");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostShareItNotifierIIndex, recipe_owner_user_id);
                            }
                            else if(parseInt(data) > 1)
                            {
                              $('.post_stats ul li.shareCount span').eq(counter).html(data);
                              $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" people shared this");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostShareItNotifierIIndex, recipe_owner_user_id);
                               
                            }
                            
                        }
                }
        },
         error: function(){
                 removeLoadFunctionBarLoader(tableName, counter);
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
        $('#LOADING').remove();
        $('.UserComments').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
        $('.UserComments #LOADING').css({position:"relative", left: "230px"});
        $.ajax({
            url: JURL+"home/showAllComment",
            type: "POST",
            dataType: "json",
            data: {recipe_post_id: recipe_post_id},
            success: function(data){
           $('#LOADING').remove();
                $('.UserComments').eq(index).append(data);
                $('.commentCounter span').eq(index).html('No more comments to show');
                resetFeed(index);
            },
            error: function(){
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

function putInMyCookBox(recipe_post_id, recipe_owner_id, index){
    $.ajax({
        url: JURL+"home/putInMyCookBox",
        type: "POST",
        dataType: "json",
        data: {recipe_post_id: recipe_post_id},
        success: function(){
            $('.picIngShp ul li.cookboxit').eq(index).html("<img src='"+JURL+"pictures/home/favorite_on.png' width='20' height='20'>");
            sendCookBoxNotification(recipe_post_id, recipe_owner_id);
        },
        error: function(){
                  
        }
    });
}


function sendCookBoxNotification(recipe_post_id, recipe_owner_id){
    var notifierIndex = 12;
     $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: recipe_post_id, index: notifierIndex, reciever_user_id: recipe_owner_id},
        success: function(data){
            
        }
    });
}