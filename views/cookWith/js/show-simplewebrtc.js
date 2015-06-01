/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   
    var room = location.search && location.search.split('?')[1];
    var webrtc = new SimpleWebRTC({
        // the id/element dom element that will hold "our" video
        localVideoEl: 'localVideo',
        // the id/element dom element that will hold remote videos
        remoteVideosEl: 'remotesVideos',
        // immediately ask for camera access
        autoRequestMedia: true,
        //for errors
        log: true
   });
   
    webrtc.on('readyToCall', function () {
        // you can name it anything
         if(room) webrtc.joinRoom(room);
     });
     
     if(room){
         setroom(room);
     }else{
         $('#createRoomeName').click(function(){
             var val = $('#createInput').val();
             
             webrtc.createRoom(val, function(err, name){
                 var newURL = location.pathname+ '?' +name;
                 if(!err){
                     history.replaceState({foo: 'bar'}, null, newURL);
                     setroom(name);
                 }
             });
             
             return false;
         });
     }
});

function setroom(name){
    $('form').remove();
    $('h1').text('Welcome to '+name);
    $('#subtitle').text('share this link to have friends join');
    $('#roomLink').text(location.href);
    $('body').addClass('active');
}