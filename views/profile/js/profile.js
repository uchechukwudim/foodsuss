$(document).ready(function(){
   window.fbAsyncInit = function() {
                  FB.init({
                    appId      : '1496995027250577',
                    xfbml      : true,
                    version    : 'v2.2'
                  });
                };

                (function(d, s, id){
                   var js, fjs = d.getElementsByTagName(s)[0];
                   if (d.getElementById(id)) {return;}
                   js = d.createElement(s); js.id = id;
                   js.src = "//connect.facebook.net/en_US/sdk.js";
                   fjs.parentNode.insertBefore(js, fjs);
                 }(document, 'script', 'facebook-jssdk'));
                 
                 
     //hideReciepieImageDialogOnLoad();
     //closeImageReciepieDialog();
     //showUserReccokComments();
     //getCoverPicFromSystem();
     reciepeUserCommentfocusInFocusout();
     getProfilePictureFromSystem();
     upload();
     uploading();
     turnLightOn();
     setFollowCountPos();
    $('#which_active').html('CB');
    $('#P_cookbook').css({"background": "#F4716A", "color":"white"});
   
});


      function fbthings(){
                   
                    FB.ui({
                       method: 'feed',
                       name: '<?php echo $Result ?>',
                       link: JURL,
                       app_id: '1496995027250577',
                       caption: 'enri',
                       picture: '<?php echo URL ?>img/app-head.png',
                       description: JURL+'help',
                       redirect_uri: JURL
                     }, function(response){});
                 }
                 function tweet(){
                     newwindow=window.open('https://twitter.com/share?url='+JURL+'&text=Your <?php echo $name ?> is a <?php echo $grade ?>&via=thisisuchedim&hashtags=testandtreatmalaria','name','height=450,width=600, left=400,top=100,resizable=yes,scrollbars=yes,toolbar=yes,status=yes');
                        if (window.focus) {
                            newwindow.focus();

                        }
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
              $(this).css({"height":"35px"});
                 tempTextCountLength = 150;
               }
         });
        
     });
               
}


function setFollowCountPos(){
     $('#profilePic').hover(function(){
         $('.follow_friend_count_holder').css({position: "relative", left:"-164px"});
         $('#updateInfo').css({"display": "block"});
     }, function(){
         $('.follow_friend_count_holder').css({position: "relative", left:"-30px"});
          $('#updateInfo').css({"display": "none"});
     });
}


function turnLightOn()
{
     $('.H_light').css({"border-bottom":"0px solid #F4716A"});
     $('.P_light').css({"border-bottom":"3px solid #F4716A"});
     $('.F_light').css({"border-bottom":"0px solid #F4716A"});
     $('.M_light').css({"border-bottom":"0px solid #F4716A"});
}

function showPhotos(imageName, image)
 { 
     
     
      $('html').append('<div id="imagelayer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="imagedialog is-fixed">\n\
                      <div id="imageclose">| x |</div>\n\
                      <div id="imageheader_dialogProd"><span class ="txt">Recipe Image</span></div>\n\
                      <div id="holdImage"><img id ="img1" src=""></div>\n\
                      <div id="imageholdComment"></div>\n\
                      </div>\n\
                    </div>');
       $('#imageheader_dialogProd span.txt').text(imageName+" Image");
      $('#holdImage img').attr('src', ''+image+'');
     $('#imagelayer').show();
     $('.imagedialog').show();
     closeShowImageEND();
 }
 
 
function closeShowImageEND(){
    $('#imageclose').click(function(){
        $('#imagelayer').remove();
        //$('.imagedialog.is-fixed').hide();
        $('.imagedialog').remove();
    });
    
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#imagelayer').remove();
                $('.imagedialog').remove();
           }
     });
}
 
 function getCoverPicFromSystem(){
    $('input[name=file1]').trigger('click');

    uploadCoverPicture();
        
}

function uploadCoverPicture()
{
   
      var profileCover = "PROFILECOVER";
      var idname = 'file1'
     $('input[name=file1]').change(function(){
       
       if(PictureProccessing(idname)){
          
         $('#file1').uploading(""+JURL+"profile/uploadProfileCover", {}, function(success){
               if(success === null || success === EMPTY){
                    $("#file1").replaceWith($("#file1").clone());
                    $('#AjaximageLoader').hide();
                    var message = 'something went wrong. Please check your internet and try again';
                    showImageUploadErrorMessage(message);
                }else if(success !== true){   
                    $("#file1").replaceWith($("#file1").clone());
                    $('#AjaximageLoader').hide();
                    showImageUploadErrorMessage(success);
                }else{
                    getUploadedImage(profileCover);
                }
              //$('input[type=file]').remove();
              //$('#updateCover').append('<input type="file" name="file" id="file"/>');  
          },
           function(progress) {
               $('#AjaximageLoader').hide();
               $('#AjaximageLoader').show();
           });
          
       }
       
     });
}

function getProfilePictureFromSystem()
{
    
    $('#updateInfo').click(function(event){
        var target = $(event.target);
        
        if(target.is(this))
        {
          $('input[name=file]').trigger('click');
        
          uploadProfilePicture();
        }
    });
}

function uploadProfilePicture()
{
       var profilePic = "PROFILEPIC";
       var idname = 'file'; 
     $('input[name=file]').change(function(){
       
        if(PictureProccessing(idname)){
                $('#file').upload(""+JURL+"profile/uploadProfilePicture", {}, function(success){

              if(success === null || success === EMPTY){
                $("#file").replaceWith($("#file").clone());
                  $('#AjaximageLoader').hide();
                  var message = 'something went wrong. Please check your internet and try again';
                  showImageUploadErrorMessage(message);
              }else if(success !== true){
                   $("#file").replaceWith($("#file").clone());
                    $('#AjaximageLoader').hide();
                    showImageUploadErrorMessage(success);
              }else{
                     getUploadedImage(profilePic);
              }

               // $('input[type=file]').remove();
                //$('#updateCover').append('<input type="file" name="file" id="file"/>');

            },
             function(progress) {
                  $('#AjaximageLoader').hide();
                 $('#AjaximageLoader').show();
             });

        }
       
     });
    
}

function getUploadedImage(which)
{
 var profilePic = "PROFILEPIC";
  var profileCover = "PROFILECOVER";
  
    $.ajax({
        url: ""+JURL+"profile/getUploadedImage",
        type: "GET",
        dataType: "json",
        data: {which: which},
        success: function(data){
               $('#AjaximageLoader').hide();
                $("#file").replaceWith($("#file").clone());
                $("#file1").replaceWith($("#file1").clone());
               if(which === profilePic)
               {
                   $('#profilePic img').attr('src', ''+data+'');
               }
               
               if(which === profileCover)
               {
                   $('.prfCoverImage img').attr('src', ''+data+'');
               }
        },
        
        error : function (){
            $('#AjaximageLoader').hide();
            var message = 'something went wrong. Please check your internet and try again';
            showImageUploadErrorMessage(message);
        }
    });
}

function PictureProccessing(idname){
    //check file sizes and if its image..
  
    var message = '';
    var maxSize = 4145728;
    var fielArray = ["image/png", "image/jpeg", "image/gif", "image/jpg"];
  
        var control = document.getElementById(idname);
        var files = control.files;
        var size = files[0].size;
        var name = files[0].name;
        var ftype = files[0].type;
      
        if(!checkFileFormat(ftype, fielArray)){
            message = ' wrong file format! Only accept (png, jpg, gif, jpeg)';
            showImageUploadErrorMessage(message);
            return false;
        }else if(size > maxSize){
            message = ' Picture Size is to big. Picture has to be less than 4MB in size';
            showImageUploadErrorMessage(message);
            return false;
        }else{
              return true;
        }
  
}

function checkFileFormat(ftype, fielArray){
    if(ftype === fielArray[0] || ftype === fielArray[1] || ftype === fielArray[2] || ftype === fielArray[3]){
        return true;
    }else{
        return false;
    }
}

function showImageUploadErrorMessage(message)
{
    $('html').append('<div id="error_layer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="error_dialog is-fixed">\n\
                      <div id="error_close">| x |</div>\n\
                      <div id="header_dialog"><span class ="txt">Info box</span></div>\n\
                      <div id="er_message">'+message+'</div>\n\
                      </div>\n\
                    </div>');
    $('#error_layer').show();
    $('.error_dialog').show();
     $('#error_close').show();
    
    
                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').hide();
                           $('.error_dialog').hide();
                           $('#error_close').hide();
                       }
                    });
                    
                      $('#error_close').click(function(){
                          // Close my modal window
                            $('#error_layer').hide();
                           $('.error_dialog').hide();
                           $('#error_close').hide();
                      });
}

function changeMyStatusOnHover()
{
   
        
        $('#friendshipUpdate').hover(function(){
            var status = $(this).text();
            if(status === "Friends")
            {
                $(this).text("UnFriend");
                $(this).css({
                   "width":"45px",
                   "padding-left":"7px"
               });
            }
            
            if(status === "Following")
            {
                $(this).text("Unfollow");
                $(this).css({
                   "width":"45px",
                   "padding-left":"7px"
               });
            }
            
            if(status === "Follower")
            {
                $(this).text("Follow Back");
                $(this).css({
                   "width":"40px",
                   "padding-left":"10px"
               });
            }
        },function(){
            
            var status = $(this).text();
            if(status === "UnFriend")
            {
                $(this).text("Friends");
                $(this).css({
                   "width":"40px",
                   "padding-left":"10px"
               });
            }
            
            if(status === "Unfollow")
            {
                $(this).text("Following");
                $(this).css({
                   "width":"45px",
                   "padding-left":"5px"
               });
            }
            
            if(status === "Follow Back")
            {
                $(this).text("Follower");
                $(this).css({
                   "width":"40px",
                   "padding-left":"9px"
               });
            }
            
        });
   
}

function sendUserFriendShipToServer(friendRequest, user_id, friend_user_id)
{
     $('#AjaximageLoader').hide();
     $('#AjaximageLoader').show();
     $('#AjaximageLoader').css({postion: "relative", left: "300px"});
     $('#friendshipUpdate').attr('onclick',  '');
  
  
  $.ajax({
      url: ""+JURL+"profile/FriendFollowRequestProcessing",
      type: "POST",
      dataTyep:"json",
      data: {request: friendRequest, user_id: user_id, friend_user_id: friend_user_id},
      success: function(data){
          
          $('#friendshipUpdate').html(data.replace(/\"/g, ""));
          $('#friendshipUpdate').attr('onclick',  '');
          $('#friendshipUpdate').click(function(){
              sendUserFriendShipToServer(data.replace(/\"/g, ""), user_id, friend_user_id);
          });
           $('#AjaximageLoader').hide();
            sendNotification(FriendOrFollowing(data.replace(/\"/g, "")), user_id, friend_user_id);
      }
  });
}
function  sendNotification(FriendFollowIndex, reciever_user_id1, reciever_user_id2)
{
    var zero = 0; var one = 1;

    if(FriendFollowIndex === zero || FriendFollowIndex === one){
            $.ajax({
                url:""+JURL+"notifier",
                type: "POST",
                data: {index: FriendFollowIndex, reciever_user_id1: reciever_user_id1, reciever_user_id2: reciever_user_id2},
                success: function(data){

                }
            });
    }
}

function FriendOrFollowing(which)
{
    var friends = 'Friends';
    var following = 'Following';
    if(which === following)
    {
        return 0;
    }
    else if(which === friends)
    {
        return 1;
    }
    else{
        return -1;
    }
}



    function initialize() {
   
      var mapOptions = {
        zoom: 6
      };
      map = new google.maps.Map(document.getElementById("map-canvas"),
          mapOptions);

      // Try HTML5 geolocation
      if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = new google.maps.LatLng(position.coords.latitude,
                                           position.coords.longitude);

          var infowindow = new google.maps.InfoWindow({
            map: map,
            position: pos,
            content: "Location found using HTML5."
          });

          map.setCenter(pos);
        }, function() {
          handleNoGeolocation(true);
        });
      } else {
        // Browser doesnt support Geolocation
        handleNoGeolocation(false);
      }
    }

    function handleNoGeolocation(errorFlag) {
      if (errorFlag) {
        var content = "Error: The Geolocation service failed.";
      } else {
        var content = "Error: Your browser doesn\'t support geolocation.";
      }

      var options = {
        map: map,
        position: new google.maps.LatLng(60, 105),
        content: content
      };

      var infowindow = new google.maps.InfoWindow(options);
      map.setCenter(options.position);
    }




function upload()
{
    $.fn.upload = function(remote,data,successFn,progressFn) {
		// if we dont have post data, move it along
		if(typeof data != "object") {
			progressFn = successFn;
			successFn = data;
		}
		return this.each(function() {
			if($(this)[0].files[0]) {
				var formData = new FormData();
				formData.append($(this).attr("name"), $(this)[0].files[0]);
 
				// if we have post data too
				if(typeof data == "object") {
					for(var i in data) {
						formData.append(i,data[i]);
					}
				}
 
				// do the ajax request
				$.ajax({
					url: remote,
					type: 'POST',
					xhr: function() {
						myXhr = $.ajaxSettings.xhr();
						if(myXhr.upload && progressFn){
							myXhr.upload.addEventListener('progress',function(prog) {
								var value = ~~((prog.loaded / prog.total) * 100);
 
								// if we passed a progress function
								if(progressFn && typeof progressFn == "function") {
									progressFn(prog,value);
 
								// if we passed a progress element
								} else if (progressFn) {
									$(progressFn).val(value);
								}
							}, false);
						}
						return myXhr;
					},
					data: formData,
					dataType: "json",
					cache: false,
					contentType: false,
					processData: false,
					complete : function(res) {
						var json;
						try {
							json = JSON.parse(res.responseText);
						} catch(e) {
							json = res.responseText;
						}
						if(successFn) successFn(json);
					},
                                        error: function(){
                                           $('#AjaximageLoader').hide();
                                        }
				});
			}
		});
               
	};
}


function uploading()
{
    $.fn.uploading = function(remote,data,successFn,progressFn) {
		// if we dont have post data, move it along
		if(typeof data != "object") {
			progressFn = successFn;
			successFn = data;
		}
		return this.each(function() {
			if($(this)[0].files[0]) {
				var formData = new FormData();
				formData.append($(this).attr("name"), $(this)[0].files[0]);
 
				// if we have post data too
				if(typeof data == "object") {
					for(var i in data) {
						formData.append(i,data[i]);
					}
				}
 
				// do the ajax request
				$.ajax({
					url: remote,
					type: 'POST',
					xhr: function() {
						myXhr = $.ajaxSettings.xhr();
						if(myXhr.upload && progressFn){
							myXhr.upload.addEventListener('progress',function(prog) {
								var value = ~~((prog.loaded / prog.total) * 100);
 
								// if we passed a progress function
								if(progressFn && typeof progressFn == "function") {
									progressFn(prog,value);
 
								// if we passed a progress element
								} else if (progressFn) {
									$(progressFn).val(value);
								}
							}, false);
						}
						return myXhr;
					},
					data: formData,
					dataType: "json",
					cache: false,
					contentType: false,
					processData: false,
					complete : function(res) {
						var json;
						try {
							json = JSON.parse(res.responseText);
						} catch(e) {
							json = res.responseText;
						}
						if(successFn) successFn(json);
					},
                                        error: function(){
                                           $('#AjaximageLoader').hide();
                                        }
				});
			}
		});
               
	};
}

function shareProfile(){
    $('html').append('<div id="layer"></div>');
    $('html').append('<div class=center-DH">\n\
                      <div class="dialog is-fixed">\n\
                      <div id="close">| x |</div>\n\
                      <div id="header_dialog"><span class ="txt">Share Profile</span></div>\n\
                      <div id="hold">\n\
                        <div class="socialMed">\n\
                            <ul>\n\
                                <li class="FB" onclick="fbthings()">Share on facebook</li>\n\
                                <li class="TWT"><a  onclick="tweet()" >Share on Twitter</a></li>\n\
                                <li class="Gplus"><a  onclick="" >Share on google+</a></li>\n\
                            </ul>\n\
                        </div>\n\
                    </div>\n\
                      </div>\n\
                    </div>');
     $('#layer').show();
     $('.dialog').show();
     closeDialog();
}

 function closeDialog(){
     $('#close').click(function(){
     $('#layer').remove();
     $('.dialog').remove();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27){
                $('#layer').remove();
                $('.dialog').remove();
          }
     });
 }