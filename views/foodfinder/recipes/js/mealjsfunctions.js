    var temptxtCount = 0;
    var tempTextCountLength = 150;
$(document).ready(function(){
    var CRdd = new CRDropDown( $('#CRdd') );
    removeDropdownList();
    reciepeENUserCommentfocusInFocusout();

 
});
//implementation of functions for meal.php
function navToCountries()
{
       
        window.location.href = ""+JURL+"foodfinder";
}

function navToFoods(country)
{
  window.location = ""+JURL+"foodfinder/food/"+country+"";
}

function reciepeENUserCommentfocusInFocusout()
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
                 tempTextCountLength = 150;
               }
         });
        
     });
               
}

 function showReciepieImageDialog()
 { 
       //$('body').scrollTop(0);
        document.getElementById('img1').src = ""+JURL+"pictures/general_smal_ajax-loader.gif";
   var tableName = "recipes_images";
   var imageColumName = "recipe_image";
   var imageIdName = "recipe_image_id";
     $('.cook .picEN').each(function(index){
         $(this).click(function(){
             var m = $('.picEN span.nImage').text();
             document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+m[index]+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
              $('#imagelayer').show();
              $('#imagedialog').show();
       
         });
     });
 }
 
 function showReciepieImageDialog(imageId)
 { 
       //$('body').scrollTop(0);
        document.getElementById('img1').src = ""+JURL+"pictures/general_smal_ajax-loader.gif";
   var tableName = "recipes";
   var imageColumName = "recipe_photo";
   var imageIdName = "recipe_id";
     $('.cook .picEN').each(function(index){
         $(this).click(function(){
             var m = $('.picEN span.nImage').text();
             document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+imageId+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
              $('#imagelayer').show();
              $('#imagedialog').css({position: 'absolute',
                            top:'10%', bottoom: '10%',right:'5%', left:'5%'});
              $('#imagedialog').show();
       
         });
     });
 }
 
 function hideReciepieImageDialogOnLoad()
 {
     $('#imagelayer').hide();
     $('#imagedialog').hide();
 }
 
 function closeImageReciepieDialog()
 {
     $('#imageclose').click(function(){
     $('#imagelayer').hide();
     $('#imagedialog').hide();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#imagelayer').hide();
                $('#imagedialog').hide();
           }
     });
 }
 
 function showUserComments(index)
 {
  
         
         $(".recookcomments").eq(index).click(function(){
             show(index);
         });
   
 } 

 function show(index)
 {
     var comments = $('.comments');
     var textarea = $('.usertextarea');
     //offset check the size of the element at the time its clicked
     var  commentWidth = comments[index].offsetWidth;
     var commentHeight = comments[index].offsetHeight;
     
     if(commentWidth===0 || commentHeight===0)
      {
            comments[index].style.display = 'block';
           textarea [index].style.marginTop = "10px";
      }
      else if(commentWidth !==0 || commentHeight!==0)
      {
           comments[index].style.display = 'none';
      }
   
 }
 
 function hideHealthDialogOnLaod()
 {
     $('#healthlayer').hide();
     $('#healthdialog').hide();
 }
 
 function showHealthDialog()
 {
       $('body').scrollTop(0);
     $('.nuterientEN').each(function(index){
         $(this).click(function(){
             
             var h = $('.nuterientEN span.nutHold').text();
         
             $('#Hhealth').html(""+h);
             $('#healthlayer').show();
              $('#healthdialog').show();
         });
     });
 }
 
function closeHealthDialog()
{
     $('#healthclose').click(function(){
                $('#healthlayer').hide();
              $('#healthdialog').hide();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
               $('#healthlayer').hide();
              $('#healthdialog').hide();
           }
     });
}

function CRDropDown(el) {
   
    this.CRdd = el;
    this.placeholder = this.CRdd.children('#CRSwitchHolder');
    this.opts = this.CRdd.find('ul.CRdropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
     
}
CRDropDown.prototype = {
    initEvents : function() {
        var obj = this;

        obj.CRdd.on('click', function(event){
            $(this).toggleClass('active');
            $('.CRwrapper-CRdropdown-3 .CRdropdown').show();
            return false;
        });
 
        obj.opts.on('click',function(){
            var opt = $(this);
            obj.val = opt.text();
            obj.index = opt.index();
            obj.placeholder.text(obj.val);
                 
        setDropdownArrow(obj.val);
        
        if(obj.val === "ENRI")
        {
            getENRIRecipes();
            
        }else
        {
            getRecipeAccordingToUserType(obj.val);
        }
        $('#counterHolder').text('0');
              
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

function setDropdownArrow(usertype)
{
   
    if(usertype === "ENRI")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".CRwrapper-CRdropdown-3:after{position:absolute; left: 50px;}\n\
                           .CRwrapper-CRdropdown-3 .CRdropdown:after{position:absolute; left: 6px;} \n\
                            .CRwrapper-CRdropdown-3 .CRdropdown:before{position:absolute; left: 6px;}");
    }
    else if(usertype === "Chef")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".CRwrapper-CRdropdown-3:after{position:absolute; left: 50px;}\n\
                           .CRwrapper-CRdropdown-3 .CRdropdown:after{position:absolute; left: 6px;} \n\
                            .CRwrapper-CRdropdown-3 .CRdropdown:before{position:absolute; left: 6px;}");
    }
    else if(usertype === "Foodie")
    {
      $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".CRwrapper-CRdropdown-3:after{position:absolute; left: 55px;}\n\
                           .CRwrapper-CRdropdown-3 .CRdropdown:after{position:absolute; left: 31px;} \n\
                            .CRwrapper-CRdropdown-3 .CRdropdown:before{position:absolute; left: 31px;}");
    
       
    }
    else if(usertype === "Restaurant")
    {
         $("<style type='text/css' id='dynamic' />").appendTo("head");
      $("#dynamic").text(".CRwrapper-CRdropdown-3:after{position:absolute; left: 75px;}\n\
                           .CRwrapper-CRdropdown-3 .CRdropdown:after{position:absolute; left: 31px;} \n\
                            .CRwrapper-CRdropdown-3 .CRdropdown:before{position:absolute; left: 31px;}");
    }
}

function removeDropdownList()
{
  
      //remove active class when mouse is click any other place
      $(function(){
           $(document).click(function(){
               $("#CRdd").removeClass("active");
                //$('#makeReciepe').css({"z-index":"1"});
           });
      });
}


function  getRecipeAccordingToUserType(userType)
{
   var foodncountry = $('#FoodMeal span img').attr('title');
  
    var FC = foodncountry.split(" in ");
    var food = FC[0];
    var country = FC[1];
    $.ajax({
        url: ""+JURL+"foodfinder/getRecipeAccordingToUserType",
        type: "GET",
        dataType: "json",
        data:{userType: userType, country: country, food: food},
        success: function(data){
            
            if(data === false)
            {
           
                $('#recipesHolder').html(" <div style='color: grey; margin-top: 100px;'>There are no recipe's for <b>"+food+"</b> </b> in <b>"+country+"</b> yet</div>");
            
               // NoRecipePostInfoBoxMessage(userType, country, food);
            }
            else
            {
                $('#recipesHolder').html(""+data);
                             
                   reciepeUserCommentfocusInFocusout();
                 
                  // infinitScrollHomeRecipeLoader();

            }
        },
        error:function(){
            $('#recipesHolder').html(" <div style='color: grey; margin-top: 100px;'>something went wrong. Please try again.</b> yet</div>");
        }
    });
}
function getENRIRecipes()
{
     var foodncountry = $('#FoodMeal span img').attr('title');
  
     var FC = foodncountry.split(" in ");
     var food = FC[0];
     var country = FC[1];
    $.ajax({
        url: ""+JURL+"foodfinder/getEnriRecipes",
        type: "GET",
        dataType: "json",
        data:{food: food, country: country},
        success: function(data)
        {
            if(data === false)
            {
                  $('#recipesHolder').html(" <div style='color: grey; margin-top: 100px;'>There are no recipe's for <b>"+food+"</b> </b> in <b>"+country+"</b> yet by enri</div>");
               
                              var enri = 'ENRI';
               // NoRecipePostInfoBoxMessage(enri, country, food);
            }
            else{
                    loadMeal(data);
                    runFunctions();
             }
        }
    });
}

function loadMeal(data)
{
    $('#recipesHolder').html(""+data);
    
}




function RuncontinentDropdownList()
{
    $("#dd").click(function(){
         $(this).css("active");
             $('#makeReciepe').css({"z-index":"0"});
         return false;
      });
      
      //remove active class when mouse is click any other place
      $(function(){
           $(document).click(function(){
               $("#dd").removeClass("active");
                $('#makeReciepe').css({"z-index":"1"});
           });
      });
}


function sendUserCommentEN(recipe_id, event, food_id, country_id, index)
{
    var textCountLength = 150;
  
    var pcb = document.getElementsByClassName('post_comments_box')[index];
   
    var  recipeENPostCommentIndex = 8;
    var enter = 13;
  
                if(event.shiftKey && event.keyCode == enter)
                {
                    //increat height  
                    
                     $('.post_comments_box').eq(index).css({'height':"+=10"});
                         $('.feed_1').eq(index).css({"margin-bottom": "+=10"});
                    //break text
                    var content = $('.post_comments_box').eq(index).val();
                    var caret = getCaret(this);
                    this.value = content.substring(0,caret)+
                     "\n"+content.substring(caret,content.length);
                    event.stopPropagation();
                    
                   
                }
               else if(event.which === enter)
               {
                   //send
                     tempTextCountLength = 150;
                  var comment  =   $('.post_comments_box').eq(index).text();
                  var Tmp_comment = comment.replace(/\s+/g, '');
                  var recipeId = recipe_id;
                 
                  
                        if(Tmp_comment.length !== 0)
                        {

                              $('.UserComments #LOADING').eq(index).remove();
                             setLoaderGif(index);
                              $.ajax({
                                  type: "post",
                                  url: ""+JURL+"foodfinder/postUserRecook",
                                  dataType: "json",
                                  data: {recook: comment, recipe_id: recipeId, food_id: food_id},
                                  success: function(data){
                                        $('.UserComments #LOADING').eq(index).remove();
                                      //get recook or comments after post

                                      if(data === true){
                                          getUserRecookCommentCount(recipe_id, index);
                                          getUserRecookComment(comment, recipe_id, food_id, index);
                                          sendNotificationEN(recipe_id, food_id, country_id, recipeENPostCommentIndex);  
                                      }

                                   },//success method ends here
                                   error:function(){
                                        $('.UserComments #LOADING').eq(index).remove();
                                   }
                              });

                              $('.post_comments_box').eq(index).html("<p>show how you might make this recipe or Leave a comment</p>");
                              $('.post_comments_box').eq(index).blur();
                        }
                        else
                        {
                               //increase the height if there is nothing typed and enter is pressed
                               $('.post_comments_box').eq(index).css({'height':"+=10"});
                               $('.feed_1').eq(index).css({"margin-bottom": "+=10"});
                        }
               }else{
                     //check to see if var is 186 add 10 to the height and plus with the defined variable
                     temptxtCount = getCaretCharacterOffsetWithin(pcb);
                     if(temptxtCount === 1){tempTextCountLength = 150;}
         
                     if(temptxtCount === tempTextCountLength){
                           $('.post_comments_box').eq(index).css({'height':"+=30"});
                           $('.feed_1').eq(index).css({"margin-bottom": "+=30"});
                           tempTextCountLength = tempTextCountLength + textCountLength ;
                     }
               }
      

}
function setLoaderGif(index){
     $('.UserComments').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div></>");
     $('.UserComments #LOADING').eq(index).css({position:"relative", left: "520px", top: "59px"});
}

function getUserRecookComment(comment, recipe_id, food_id, index)
{
    var comMessage = 'No more comments to show';

    var commentCount = $('.commentCounter span').eq(index).text();
   
    if(commentCount === comMessage){
           $.ajax({
            type: "GET",
            url: ""+JURL+"foodfinder/getSingleUserRecookComment",
            dataType: "json",
            data: {recook: comment, recipe_id: recipe_id, food_id: food_id},
            success: function(data){
                $('.UserComments').eq(index).html(data);
                $('.commentCounter span').eq(index).html('No more comments to show');
                resetFeed(index);
            }
        });
    }
}

function getUserRecookCommentCount(recipe_id, index)
{
 
        var comMessage = 'No more comments to show';

    var commentCount = $('.commentCounter span').eq(index).text();
   
    if(commentCount !== comMessage){
         $.ajax({
            type: "GET",
            url: ""+JURL+"foodfinder/getUserRecookCommentCount",
            data: {recipe_id: recipe_id},
            success: function(data){
                if(parseInt(data) > 3){
                    var remMesNum = parseInt(data) - 3;
                    var message = "Show "+remMesNum+" more messages";
                   $('.commentCounter span').eq(index).html(message);

                }
                else{
                      $('.commentCounter span').eq(index).html('No more comments to show');
                  }
            }
        });
    }
}

function  sendNotificationEN(recipe_id, food_id, country_id, recipeENPostCommentIndex)
{
    $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: recipe_id, food_id: food_id, country_id: country_id, index: recipeENPostCommentIndex},
        success: function(data){
            
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

function countUsertryIt(recook,id)
{

    $.ajax({
        url: ""+JURL+"foodfinder/userTryItCounter",
        type: "Get",
        data: {recipe_recook_id: id},
        success: function(data)
        {
            $('.userCookit a').each(function(index){
                var reck = $('.userDesc')[index].innerHTML;
                
                if(reck === recook){
                    $('.cookeditview')[index].innerHTML = getuserCookitSurffix(data);
                }
                
            });
        }
    });
}

function getuserCookitSurffix(num)
    {
       var message = '';
        if(num >=2)
           message = num+" people TriedIt";
        else if(num == 1)
          message = num+" person TriedIt";
        else if(num < 1){
            message = 'No cooks yet';
        }
        
        return message;
    }
    
 
 
 function showUserReccokComments()
 {
     $('.numberOfcomments').each(function(index){
           $(this).click(function(){
               $('.comments')[index].style.display = "block";
                
           });
     });
 }
 
 function NoReciperrorMessage(country, food)
  {
      var message = "There are no recipes for <b>"+food+"</b> in <b>"+country+"</b> posted by ENRI yet. We are working hard to provide</br> recipes </br></br> Thank you for your patience";
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
  
  function NoRecipePostInfoBoxMessage(userType, country, food)
  {
      var message = "There are no <b>"+userType+"</b> recipes Post for <b>"+food+"</b> in <b>"+country+"</b> yet. We are working hard to </br> provide recipes </br></br> Thank you for your patience";
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
  
  function attachErrorDialog(){
      $('html').append('error_layer');
  }

function getShare(recipe_post_Id, counter)
{
    $.ajax({
        type: "POST",
        url: ""+JURL+"Home/getShare",
        dataType: "json",
        data: {recipe_post_id: recipe_post_Id},
        success: function(data){
            if(data == "1")
            {
              $('.recipeFuncProgressBar span.shareCount').eq(counter).html(data+" Person SharedIt");
            }
            else
            {
                $('.recipeFuncProgressBar span.shareCount').eq(counter).html(data+" People SharedIt");
            }
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
            if(data == "1")
            {
              $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" Person TastyIt");
            }
            else
            {
                $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" People TastyIt");
            }
           
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
              $('.recipeFuncProgressBar span.cookCount').eq(counter).html(data+" Person CookedIt");
            }
            else
            {
                $('.recipeFuncProgressBar span.cookCount').eq(counter).html(data+" People CookedIt");
            }
          
        }
    });
}

function getShareEN(recipe_id, country_id, counter)
{
    $.ajax({
        url: ""+JURL+"foodfinder/getShareEN",
        type: "POST",
        dataType: "json",
        data: {recipe_id: recipe_id, country_id: country_id},
        success:function(data){
          if(data == 1)
          {
             $('.NumofCookedItandRcook span.shareCountEN').eq(counter).html(data+" person SharedIt");
          }
          else
          {
               $('.NumofCookedItandRcook span.shareCountEN').eq(counter).html(data+" people SharedIt");
          }
        }
    });
}

function getTastyEN(recipe_id, country_id, counter)
{
     $.ajax({
        url: ""+JURL+"foodfinder/getTastyEN",
        type: "POST",
        dataType: "json",
        data: {recipe_id: recipe_id, country_id: country_id},
        success:function(data){
            if(data == 1)
            {
              $('.NumofCookedItandRcook span.tastyCountEN').eq(counter).html(data+" person TastIt");
            }
            else
            {
                 $('.NumofCookedItandRcook span.tastyCountEN').eq(counter).html(data+" people TastIt");
            }
        }
    });
}

function insertTCS(user_id, recipe_owner_user_id, recipe_post_id, tableName, counter)
{
   var tb = "";
   var tN = getTableName(tb, tableName);
   
   var recipePostCookedItNotifierIIndex = 5;
   var recipePostTastyItNotifierIndex = 6;
   var recipePostShareItNotifierIIndex = 7;
   removeLoadFunctionBarLoaderRP(tN, counter);
    loadFunctionBarLoaderRP(tN, counter);
   

    $.ajax({
        type: "POST",
        url: ""+JURL+"home/insertTCS",
        dataType: "json",
        data: {user_id: user_id, recipe_post_id: recipe_post_id,  owner_user_id: recipe_owner_user_id, tableName: tN},
        success: function(data){
               removeLoadFunctionBarLoaderRP(tN, counter);
             if(data !== false)
            {
                        if(tN === "recipe_post_tasty")
                        {
                       
                            if(parseInt(data)  == 1)
                           {
                             $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" person said this is tasty");
                           }
                           else if(parseInt(data) > 1)
                           {
                               $('.recipeFuncProgressBar span.tastyCount').eq(counter).html(data+" People said this is tasty");
                           }
                            sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostTastyItNotifierIndex, recipe_owner_user_id);
                        }
                        else if(tN === "recipe_post_cookedit")
                        {
                            if(parseInt(data)  == 1)
                            {
                              $('.recipeFuncProgressBarCookedItSharedIt span.cookCount').eq(counter).html(data+" person cooked this");
                            }
                            else if(parseInt(data) > 1)
                            {
                                $('.recipeFuncProgressBarCookedItSharedIt span.cookCount').eq(counter).html(data+" people cooked this");
                            }
                            sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostCookedItNotifierIIndex, recipe_owner_user_id);
                        }
                        else if(tN === "recipe_post_share")
                        {
                            if(parseInt(data)  == 1)
                            {
                              $('.recipeFuncProgressBarCookedItSharedIt span.shareCount').eq(counter).html(data+" person shared this");
                            }
                            else if(parseInt(data) > 1)
                            {
                                $('.recipeFuncProgressBarCookedItSharedIt span.shareCount').eq(counter).html(data+" people shared this");
                            }
                             sendTastyCookedItShareNotificationHome(recipe_post_id, recipePostShareItNotifierIIndex, recipe_owner_user_id);
                        }
                }
        },
        error: function(){
            removeLoadFunctionBarLoaderRP(tN, counter);
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

function loadFunctionBarLoaderRP(which, index)
{
    var tasty = 'recipe_post_tasty'; var cook = 'recipe_post_cookedit'; var share = 'recipe_post_share';
    
   var $divclassTasty = $('.recipeFuncProgressBar span.tastyCount');
   var divclassImgtasty = '.recipeFuncProgressBar span.tastyCount img';
   
   var $divclassCook = $('.recipeFuncProgressBarCookedItSharedIt span.cookCount');
   var divclassImgCook = '.recipeFuncProgressBarCookedItSharedIt span.cookCount img';
   
   var $divclassShare = $('.recipeFuncProgressBarCookedItSharedIt span.shareCount');
   var divclassImgShare = '.recipeFuncProgressBarCookedItSharedIt span.shareCount img';
    
    
    if(which === tasty)
    {
    
        appendLoaderRP($divclassTasty, divclassImgtasty, index);
    }
    else if(which === cook)
    {
        appendLoaderRP($divclassCook,divclassImgCook, index);
    }
    else if(which === share)
    {
        appendLoaderRP($divclassShare,divclassImgShare, index);
    }
}

function removeLoadFunctionBarLoaderRP(which, index)
{
    var tasty = 'recipe_post_tasty'; var cook = 'recipe_post_cookedit'; var share = 'recipe_post_share';
    
    var divclassImgtasty = '.recipeFuncProgressBar span.tastyCount img';
   
    var divclassImgCook = '.recipeFuncProgressBarCookedItSharedIt span.cookCount img';

    var divclassImgShare = '.recipeFuncProgressBarCookedItSharedIt span.shareCount img';
   
    if(which === tasty)
    {
        //$('.recipeFuncProgressBar span.tastyCount img').eq(index).remove();
         removeLoaderRP(divclassImgtasty, index);
    }
    else if(which === cook)
    {
        //$('.recipeFuncProgressBarCookedItSharedIt span.cookCount img').eq(index).remove();
        removeLoaderRP(divclassImgCook, index);
    }
    else if(which === share)
    {
        //$('.recipeFuncProgressBarCookedItSharedIt span.shareCount img').eq(index).remove();
         removeLoaderRP(divclassImgShare, index);
    }
}

function appendLoader(divclass, divclassImg, index)
  {
   
      $(divclass).eq(index).append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15" height="15">');
        $(divclassImg).css({"margin-left": "5px", position: "relative", top:"3px"});
  
  }
  
  function removeLoaderRP(divclassImg, index)
  {
      $(divclassImg).remove();
      //$(divclassImg).eq(index).remove();
  }

function insertTastyEN(recipe_id, country_id,  counter)
{
   
   var recipeENTastyNotifierIndex = 10;
   var which = 1;
        removeLoadFunctionBarLoaderEN(which, counter);
   loadFunctionBarLoaderEN(which, counter);

    $.ajax({
        type:"POST",
        url: ""+JURL+"foodfinder/insertTastyEN",
        dataType: "json",
        data: {recipe_id: recipe_id, country_id: country_id},
        success:function(data){
              removeLoadFunctionBarLoaderEN(which, counter);
            if(data !== false){
                    if(data === 1)
                    {
                      $('.post_stats ul li.tastyCount span b').eq(counter).html(data);
                      $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" person said this is tasty");
                       sendTastyCookedItShareNotificationEN(recipe_id, recipeENTastyNotifierIndex);
                    }
                    else if(data > 1)
                    {
                        $('.post_stats ul li.tastyCount span b').eq(counter).html(data);
                        $('.post_stats ul li.tastyCount span').eq(counter).prop('title', data+" people said this is tasty");
                         sendTastyCookedItShareNotificationEN(recipe_id, recipeENTastyNotifierIndex);
                    }else{}
                 
            }
        },
        error:function(){
            removeLoadFunctionBarLoaderEN(which, counter);
        }
        
    });
}

function CookIt(recipe_id, countryId, counter)
{
     var recipeENCookedNotifierIIndex = 9;
     var which = 2;
     removeLoadFunctionBarLoaderEN(which, counter);
   loadFunctionBarLoaderEN(which, counter);
   
    $.ajax({
        url: ""+JURL+"foodfinder/Cookit",
        type: "GET",
        dataType: "json",
        data: {recipe_id: recipe_id, countryID: countryId},
        success: function(data){
         removeLoadFunctionBarLoaderEN(which, counter);
        
                if(data === 1)
                {
                   $('.post_stats ul li.cookCount span b').eq(counter).html(data);
                   $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  person cooked this");
                   sendTastyCookedItShareNotificationEN(recipe_id, recipeENCookedNotifierIIndex);
                }
                else if(data > 1)
                {
                      $('.post_stats ul li.cookCount span b').eq(counter).html(data);
                      $('.post_stats ul li.cookCount span').eq(counter).prop('title', data+"  people cooked this");
                      sendTastyCookedItShareNotificationEN(recipe_id, recipeENCookedNotifierIIndex);
                }else{
                    
                }
                 
            
        }
    });
}


function insertShareEN(recipe_id, country_id, counter)
{
    var recipeENShareNotifierIIndex = 11;
    var which = 3;
     removeLoadFunctionBarLoaderEN(which, counter);
    loadFunctionBarLoaderEN(which, counter);
    
     $.ajax({
        type:"POST",
        url: ""+JURL+"foodfinder/insertShareEN",
        data: {recipe_id: recipe_id, country_id: country_id},
        dataType: "json",
        success:function(data){
                   removeLoadFunctionBarLoaderEN(which, counter);
            if(data !== false){
                if(data === 1)
                {
                  $('.post_stats ul li.shareCount span b').eq(counter).html(data);
                  $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" person shared this");
                   sendTastyCookedItShareNotificationEN(recipe_id, recipeENShareNotifierIIndex);
                }
                else if(data > 1)
                {
                     $('.post_stats ul li.shareCount span b').eq(counter).html(data);
                     $('.post_stats ul li.shareCount span').eq(counter).prop('title', data+" people shared this");
                      sendTastyCookedItShareNotificationEN(recipe_id, recipeENShareNotifierIIndex);
                }else{
                    
                }
              
            }
        }
        
    });
}

function  sendTastyCookedItShareNotificationEN(recipe_id, notifierIndex)
{
   
    $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: recipe_id, index: notifierIndex},
        success: function(data){
            
        }
    });
    
}


function loadFunctionBarLoaderEN(which, index)
{
    var tasty = 1; var cook = 2; var share = 3;
    
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

function removeLoadFunctionBarLoaderEN(which, index)
{
   var tasty = 1; var cook = 2; var share = 3;
    
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

function getRecipeTableName(tb, tableName)
{
      if(tableName == "1")
      {
        tb = "recipe_post_tasty";
           alert(tb);
      }
      else if(tableName == "2")
      {
        tb = "recipe_post_share";
      }
}

function getTableName(tb, tableName)
{
    var tasty = "1"; var cook = "2"; var share ="3";
      if(tableName === tasty)
    {
        tb = "recipe_post_tasty";
    }
    else if(tableName === cook)
    {
        tb = "recipe_post_cookedit";
    }
    else if(tableName == share)
    {
        tb = "recipe_post_share";
    }
    return tb;
}

function showRecipeImage(imageId)
{

   //$('body').scrollTop(0);
   document.getElementById('img1').src = ""+JURL+"pictures/general_smal_ajax-loader.gif";
  var tableName = "recipe_post";
   var imageColumName = "recipe_photo";
   var imageIdName = "recipe_post_id";
    $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div id="imagedialog">\n\
                    <div id="imageclose">| x |</div>\n\
                    <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                    <div id="holdImage"><img id ="img1" src="" width="600" height="440"></div>\n\
                    <div id="imageholdComment"></div>\n\
                    </div>');
     document.getElementById('img1').src = ""+JURL+"libs/processPictures.php?id="+imageId+"&tableName="+tableName+"&imageColumName="+imageColumName+"&imageIdName="+imageIdName+"";
    
     $('#imagelayer').show();
     $('#imagedialog').show();
     closeImageReciepieDialog();
}


function infinitScrollCountryLoader()
{
    var prev = 1;
    var next = 1;
    var pages = 6;
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            var con = $("#Finderbody .wrapper-dropdown-3 span").text();
            con = getContinent(con);
           
         
            if(prev === con)
             {
                     pages = pages + 6;
             }
             else{
                  pages = 6;
                  prev = con;
                  pages = pages + 6;
             }
             
             $("#Finderload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
             $('#postload').css({"width": "50px"});
              
             $.get("foodfinder/infinitScrollCountryLoader", {page: pages, continent: con}, function(data){
              
                    $("#Finderload").empty();
                    $("#Finderbody").append(""+data);
                 
                 
             }, 'json');
        }
    });
    
    
}

function showAllComment(index, recipe_id){
    var comMessage = 'No more comments to show';
    
    if($('.commentCounter span').eq(index).html() !== comMessage){
        $('.UserComments').eq(index).append("<div id='LOADING'><img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='25'></div>");
        $('.UserComments #LOADING').css({position:"relative", left: "230px"});
        $.ajax({
            url: JURL+"foodfinder/showAllComment",
            type: "POST",
            dataType: "json",
            data: {recipe_id: recipe_id},
            success: function(data){
           $('#LOADING').remove();
                $('.UserComments').eq(index).append(data);
                $('.commentCounter span').eq(index).html('No more comments to show');
                resetFeed(index);
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



function putInMyCookBox(recipe_id, index){
    
    $.ajax({
        url: JURL+"foodfinder/putInMyCookBox",
        type: "POST",
        dataType: "json",
        data: {recipe_id: recipe_id},
        success: function(){
            $('.picIngShp ul li.cookboxit').eq(index).html("<img src='"+JURL+"pictures/home/favorite_on.png' width='20' height='20'>");
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