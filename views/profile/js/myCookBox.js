/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getProfileMyCookBox(){
    $('#which_active').html('CBX');
    $('#P_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_cookbox').css({"background": "#F4716A", "color":"white"});
    $('#P_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#P_followers').css({"background": "#EFEFEF", "color":"grey"});
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $('#meHolderHeader b').css({position: "relative", left:"10px"});
    $('#meHolderHeader img').css({position: "relative", left:"10px"});
    $.ajax({
        url: ""+JURL+"profile/myCookBox",
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

function getUserProfileMyCookBox(userId)
{
    $('#which_active').html('UCBX');
    $('#U_cookbook').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_cookbox').css({"background": "orangered", "color":"white"});
    $('#U_aboutme').css({"background": "#EFEFEF", "color":"grey"});
    $('#U_followers').css({"background": "#EFEFEF", "color":"grey"});
    
    $('#AjaximageLoader').hide();
    $('#AjaximageLoader').show();
    $('#AjaximageLoader').css({postion: "relative", left: "300px"});
    $.ajax({
        url: ""+JURL+"profile/myCookBox",
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


function infinitScrollMyCookBox()
{
    
    var Bpages = 0;
    var CBX = 'CBX';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            
           
           var myCookbox = $('#which_active').text();
           
             if(myCookbox === CBX)
             {
              
                     Bpages = Bpages + 6;
                     $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                     $('#userPostLoad').css({"width": "50px", position:"relative", left: "480px", bottom: "50px"});
                     $.get(""+JURL+"profile/infinitScrollMycookBox", {page: Bpages}, function(data){
                            
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
                 Bpages = 0;
             }
        }
    });
}

function UserInfinitScrollMyCookBox(userId)
{
   
    var Bpages = 0;
    var CBX = 'UCBX';
     $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
          
             var myCookbox = $('#which_active').text();
          
             if(myCookbox === CBX)
             {
                      Bpages = Bpages + 6;
                   $("#userPostLoad").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                  $('#userPostLoad').css({"width": "50px", position:"relative", left: "480px", bottom: "50px"});
                   
                    $.get(""+JURL+"profile/infinitScrollMycookBox", {page: Bpages, userId: userId}, function(data){
                
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
                 Bpages = 0;
             }
        }
    });
}

