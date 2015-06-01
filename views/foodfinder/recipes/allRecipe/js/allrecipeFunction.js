/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var recSwitcher = false;
$(document).ready(function(){
    
      var dd = new DropDown( $('#alldd') );
      removeDropdownList();
      turnLightOn();
});

  function turnLightOn()
     {
         $('.H_light').css({"border-bottom":"0px solid orangered"});
         $('.P_light').css({"border-bottom":"0px solid orangered"});
         $('.F_light').css({"border-bottom":"3px solid orangered"});
         $('.M_light').css({"border-bottom":"0px solid orangered"});
     }
    

function DropDown(el) {

    this.dd = el;
    this.placeholder = this.dd.children('#RecipeSwitchHolder');
    this.opts = this.dd.find('ul.alldropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
  
}
DropDown.prototype = {
    initEvents : function() {
        
        var obj = this;
 
        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            $('.allwrapper-alldropdown-3 .alldropdown').show();
            return false;
        });
 
        obj.opts.on('click',function(){
            recSwitcher = true;
            var opt = $(this);
            obj.val = opt.text();
            obj.index = opt.index();
            obj.placeholder.text(obj.val);
            
        setDropdownArrow(obj.val);
        
        if(obj.val === "ENRI")
        {
            getAllENRIRecipes();
            
        }else
        {
          getAllRecipeAccordingToUserType(obj.val);
        }
        $('#allcounterHolder').text('0');
              
        });
    },
    getValue : function() {
        return this.val;
    },
    getIndex : function() {
        return this.index;
    }
};

function getCaret(el) {
  if (el.selectionStart) {
     return el.selectionStart;
  } else if (document.selection) {
     el.focus();

   var r = document.selection.createRange();
   if (r == null) {
    return 0;
   }

    var re = el.createTextRange(),
    rc = re.duplicate();
    re.moveToBookmark(r.getBookmark());
    rc.setEndPoint('EndToStart', re);

    return rc.text.length;
  }  
  return 0;
}

function removeDropdownList()
{
  
      //remove active class when mouse is click any other place
      $(function(){
           $(document).click(function(){
               $("#alldd").removeClass("active");
                $('#makeReciepe').css({"z-index":"1"});
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


function setDropdownArrow(usertype)
{
   
    if(usertype === "ENRI")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".allwrapper-alldropdown-3:after{position:absolute; left: 50px;}\n\
                           .allwrapper-alldropdown-3 .alldropdown:after{position:absolute; left: 6px;} \n\
                            .allwrapper-alldropdown-3 .alldropdown:before{position:absolute; left: 6px;}");
    }
    else if(usertype === "Chef")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".allwrapper-alldropdown-3:after{position:absolute; left: 50px;}\n\
                           .allwrapper-alldropdown-3 .alldropdown:after{position:absolute; left: 6px;} \n\
                            .allwrapper-alldropdown-3 .alldropdown:before{position:absolute; left: 6px;}");
    }
    else if(usertype === "Foodie")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".allwrapper-alldropdown-3:after{position:absolute; left: 55px;}\n\
                           .allwrapper-alldropdown-3 .alldropdown:after{position:absolute; left: 31px;} \n\
                            .allwrapper-alldropdown-3 .alldropdown:before{position:absolute; left: 31px;}");
    
       
    }
    else if(usertype === "Restaurant")
    {
         $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".allwrapper-alldropdown-3:after{position:absolute; left: 75px;}\n\
                           .allwrapper-alldropdown-3 .alldropdown:after{position:absolute; left: 31px;} \n\
                            .allwrapper-alldropdown-3 .alldropdown:before{position:absolute; left: 31px;}");
    }
}

function  getAllRecipeAccordingToUserType(userType)
{
   
    var food = $('#alldd span.ALLFOODHOLD').html();
    $('#RecipeSwitchHolder').append("<img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='15' height='15'>");
     $('#RecipeSwitchHolder img').css({position:"relative", left: "27px"});
    $.ajax({
        url: ""+JURL+"foodfinder/getAllRecipeAccordingToUserType",
        type: "POST",
        dataType: "json",
        data:{userType: userType,  food: food},
        success: function(data){
             $('#RecipeSwitchHolder img').remove();
            if(data === false)
            {
                $('#recipesHolder').html("");
                $('#body').css({"padding-bottom":"50px",
                                "border-left":" 1px solid rgba(0, 0, 0, 0.0)",
                                 "border-right":"1px solid rgba(0, 0, 0, 0.0)"});
                NoRecipePostInfoBoxMessage(userType, food);
            }
            else
            {
                $('#recipesHolder').html(""+data);
                $('#body').css({"padding-bottom":"50px",
                                "border-left":" 1px solid rgba(0, 0, 0, 0.0)",
                                 "border-right":"1px solid rgba(0, 0, 0, 0.0)"});
                          
                   reciepeUserCommentfocusInFocusout();
                   //sendUserComment();
                
                   infinitScrollHomeRecipeLoader();

            }
        }, 
        error: function(){
              $('#RecipeSwitchHolder img').remove();
        }
    });
}

function getAllENRIRecipes()
{
   var food = $('#alldd span.ALLFOODHOLD').html();
    $.ajax({
        url: ""+JURL+"foodfinder/getAllEnriRecipes",
        type: "GET",
        dataType: "json",
        data:{food: food},
        success: function(data)
        {
            if(data === false)
            {
            
                var enri = 'ENRI';
                NoRecipePostInfoBoxMessage(enri, food);
            }
            else{
                    loadMeal(data);
                    runFunctions();
                
             }
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
                               $('.post_stats ul li.tastyCount span b').eq(counter).html(data);
                               $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" person said this is tasty");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                           }
                           else if(parseInt(data) > 1)
                           {
                               $('.post_stats ul li.tastyCount  b').eq(counter).html(data);
                               $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" people said this is tasty");
                              sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                           }
                            
                        }
                        else if(tableName === "recipe_post_cookedit")
                        {
                            if(parseInt(data)  === 1)
                            {
                               $('.post_stats ul li.cookCount span b').eq(counter).html(data);
                               $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  person cooked this");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                            }
                            else if(parseInt(data) > 1)
                            {
                                $('.post_stats ul li.cookCount span b').eq(counter).html(data);
                                $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  people cooked this");
                                sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                            }
                        
                        }
                        else if(tableName === "recipe_post_share")
                        {
                            if(parseInt(data)  === 1)
                            {
                              $('.post_stats ul li.shareCount span b').eq(counter).html(data);
                              $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" person shared this");
                               sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostShareItNotifierIIndex, recipe_owner_user_id);
                            }
                            else if(parseInt(data) > 1)
                            {
                              $('.post_stats ul li.shareCount span b').eq(counter).html(data);
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




 function infinitScrollAllENRecipeLoader(food)
 {
    var enri = "ENRI";
   var pages = 6;
  
    
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            var userType =  $('#RecipeSwitchHolder').text();
          
            //var switcher = $('#counterHolder').text();
            
            if(recSwitcher === true)
            {
                recSwitcher= false;
                pages = 6;
                 pages = pages + 6;
                $('#counterHolder').text('1');
            }
            else
            {
                   pages = pages + 6;
            }
            
            if(userType === enri){
                                    $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="20px" hieght="20px">');
                                     $('#postload').css({"width": "50px"});
                                    $("#postload").css({
                                       position: "relative",
                                       left: "550px",
                                       top: "25px"
                                     });

                                    $.get(""+JURL+"foodfinder/infinitScrollAllENRecipeLoader", {page: pages, foodName: food}, function(data){

                                           $("#postload").empty();
                                           $("#recipesHolder").append(data);
                                           reciepeUserRecookfocusInFocusout();

                                    }, 'json');
            }else{
                    $("#postload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="20px" hieght="20px">');
                         $('#postload').css({"width": "50px"});
                        $("#postload").css({
                           position: "relative",
                           left: "550px",
                           top: "25px"
                         });

                     $.get(""+JURL+"foodfinder/infinitScrollAllENRecipeLoader", {page: pages, foodName: food, user_type: userType}, function(data){

                            $("#postload").empty();
                            $("#recipesHolder").append(data);
                            reciepeUserRecookfocusInFocusout();

                     }, 'json');
            }
             
        }
    });
}


function sendUserRecookComment(recipe_post_id, event, reciever_user_id, index)
{
            var recipePostCommentIndex = 2;
    
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
                                   
                             },//success method ends here
                             error: function(){
                                 $('.UserComments #LOADING').eq(index).remove();
                             }
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
    var comMessage = 'No more comments to show';

    var commentCount = $('.commentCounter span').eq(index).text();
   
    if(commentCount !== comMessage){
        $.ajax({
                type: "POST",
                url: ""+JURL+"home/getUserCommentCount",
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
    }
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
                  
                  var newStat = userCommentH+stat+FHeight-240;
		 var newFlag = userCommentH+flag+FHeight-240;
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

function NoRecipePostInfoBoxMessage(userType, food)
  {
      var message = "There are no <b>"+userType+"</b> recipe Post for <b>"+food+"</b> yet. We are working hard to </br> provide recipes </br></br> Thank you for your patience";
       $('html').append('<div id="error_layer"></div>');
       $('html').append('<div id="error_dialog">\n\
                        <div id="header_dialog"><span class ="txt">Info Box</span></div>\n\
                        <div id="er_message">'+message+'</div>\n\
                        <div id="error_close">| x |</div>\n\
                        </div>');
      document.getElementById('er_message').innerHTML = message;
                   document.getElementById('error_layer').style.display = 'block';
                   document.getElementById('error_dialog').style.display = 'block';
                   document.getElementById('error_close').style.display = 'block';


                   document.getElementById('error_close').onclick = function(){
                   document.getElementById('er_message').innerHTML = "";
                   document.getElementById('error_layer').style.display = 'none';
                   document.getElementById('error_dialog').style.display = 'none';
                   document.getElementById('error_close').style.display = 'none';
                  // window.location.replace("http://localhost/foodfinder/food/"+country+"");
              
                   };

                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('#error_dialog').hide();
                           $('#error_close').hide();
                           //window.location.replace("http://localhost/foodfinder/food/"+country+"");
                       }
                    });
  }