src="http://code.jquery.com/jquery-latest.js";
 var TPSWITCHER = false;
var SHSWITCHER = false;
var GEOSWITCHER = false;
var TEMPINDEX ;
var tempTitle ='';
var tempTitleCont = '';
 $(document).ready(function(){
      var FAdd = new FADropDown( $('#FAdd') );
     infinitScrollCountryLoader();
     //getCounties();
      RuncontinentDropdownList();
      turnLightOn();
      inputFocus();
      hoverIngreNut();
      hoverIngreCont();

});

 function turnLightOn()
 {
     $('.H_light').css({"border-bottom":"0px solid orangered"});
     $('.P_light').css({"border-bottom":"0px solid orangered"});
     $('.F_light').css({"border-bottom":"3px solid orangered"});
     $('.M_light').css({"border-bottom":"0px solid orangered"});
 }

 function index(data, firstName, lastName, image)
 {
       $('#Finderbody').append(''+data);
       $('#nameP a b').text(firstName+" "+lastName);
       $('#imgP img').attr('src', image);
 }
 
function getCounties()
{

    $.get(""+JURL+"foodfinder/getCountries", function(data){
           $('#CountryFoodHolder').html(data);
    }, 'json');

    return false;
}

function infinitScrollCountryLoader()
{
    var prev = 1;
    var next = 1;
    var pages = 0;
    var foodPages = 0;
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() >= $(document).height() - $(window).height())
        {
            var foodName = $('.foodName').eq(0).text();
            
            if(foodName === EMPTY){
            var con = $(".FAwrapper-FAdropdown-3 span").text();
            con = getContinent(con);
           
         
                if(prev === con)
                 {
                         pages = pages + 6;
                 }
                 else{
                      pages = 0;
                      prev = con;
                      pages = pages + 6;
                 }
                    $("#Finderload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                    $('#Finderload').css({"width": "50px"});
                 $.get(""+JURL+"foodfinder/infinitScrollCountryLoader", {page: pages, continent: con}, function(data){

                        $("#Finderload").empty();
                        $("#CountryFoodHolder").append(""+data);
                 }, 'json').fail(function(){
                                $("#Finderload").empty();
                                $("#Finderload").html("somthing went wrong");
                                $("#Finderload").css({"color":"orangered"});
                            });
            }else{
                    foodPages = foodPages+6;
                    $("#Finderload").html('<img src="'+JURL+'pictures/postLoad_ajax-loader.gif" width="30px" hieght="30px">');
                    $('#Finderload').css({"width": "50px"});
                     $.get(""+JURL+"foodfinder/infinitScrollFoodLoader", {pages:  foodPages}, function(data){

                        $("#Finderload").empty();
                        $("#CountryFoodHolder").append(""+data);
                 }, 'json').fail(function(){
                                $("#Finderload").empty();
                                $("#Finderload").html("somthing went wrong");
                                $("#Finderload").css({"color":"orangered"});
                            });
            }
        }
    });
}

function FADropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.FAdropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
    
}
FADropDown.prototype = {
    initEvents : function() {
        var obj = this;
        
        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            $('.FAwrapper-FAdropdown-3 .FAdropdown').show();
            return false;
        });
        
     
 
        obj.opts.on('click',function(){
            $('.FAwrapper-FAdropdown-3 .FAdropdown').hide();
            var opt = $(this);
            obj.val = opt.text();
            obj.index = opt.index();
            obj.placeholder.text(obj.val);
            
            //get countries according to continent
         
            getCountriesViaContinent(obj.val);
            
              
        });
    },
    getValue : function() {
        return this.val;
    },
    getIndex : function() {
        return this.index;
    }
};

function RuncontinentDropdownList()
{
    $("#FAdd").click(function(){
         $(this).css("active");
         return false;
      });
      
      //remove active class when mouse is click any other place
      $(function(){
           $(document).click(function(){
               $("#FAdd").removeClass("active");
           });
      });
}

function getCountriesViaContinent(continent)
{
    $.get(""+JURL+"foodfinder/getCountries", {continent: continent}, function(data){
         $('.loadCon').remove();
         $('#CountryFoodHolder').html(data);
    }, 'json').fail(function(){
                                 $('.loadCon').remove();
                            });
}

function getContinent(continent){

        if(continent === "Continent")
          return "Africa";
      else
          return continent;
    }
    

function inputFocus(){
    
       $("#btnTag").hide();
        $("#inputFood").focus(function(){
                $("#inputFood").css('height', function(index){
                      return index += 100;
                }); 
                  $("#btnTag").show();
        });//inputfood docus
        //what happens when botton tell is clicked
            $("#submitBt").click(function(even){ 
                var $target = $(even.target);
                if($target.is(this))
                    {
                        var comment = $('#inputFood').val();
                        var files = $('#file').val();
                        
                        if(!files){
                        $.ajax({
                            type: "POST",
                            url: ""+JURL+"foodfinder/TellUseNewFood",
                            data: 'comment='+comment,
                            dataType: "json",
                            success: function(data){
                                 showErrorNoEntryMessage(data);
                                 //reset values
                                $('#inputFood').val("");
                                $('#file').val("");
                                $("#inputFood").css('height', function(index){
                                   return index += 50;
                                 }); 
                                 $("#btnTag").hide();
                            },
                            error:function(){
                                var message = 'something went wrong';
                                showErrorNoEntryMessage(message);
                            }
                        });
                     }
                    
                  }
                    return false;
            });//submit
            
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
           
        return false;
}

function uplaod()
{
         $('#uploadPic P').click(function() {
            $('input[type=file]').trigger('click');
         });
}

function  showErrorNoEntryMessage(message)
  {
      
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
  
   function followFood(foodId, count)
  {
      var inserted = "INSERTED";
      var deleted = "DELETED"
       $('.followFood img.followFoodimg').eq(count).attr('src', ""+JURL+"pictures/general_smal_ajax-loader.gif");
      var foodFollowIndex = 13;
     
      $.ajax({
            type: "POST",
            url: ""+JURL+"foodfinder/InsertFollowFoodAll",
            dataType: "json",
            data: {food_id: foodId},
            success: function(data){
         
              if(data === inserted)
              {
                  $('.followFood img.followFoodimg').eq(count).attr('src', ""+JURL+"pictures/foods/ufollow.png");
                  $('.followFood img.followFoodimg').eq(count).attr('title',"unfollow Food" );
                  getFoodFollowersAll(foodId, count);
                  sendFollowFoodNotification(foodId, foodFollowIndex);
              }
              else if(data === deleted)
              {
                 $('.followFood img.followFoodimg').eq(count).attr('src', ""+JURL+"pictures/foods/follow.png");
                 $('.followFood img.followFoodimg').eq(count).attr('title',"follow Food" );
                 getFoodFollowersAll(foodId, count);
              }
            }
      });
              
  }
  
  
  function getFoodFollowersAll(food_id, index){
      $.ajax({
          url: ""+JURL+"foodfinder/getFoodFollowersAll",
          type: "GET",
          dataType: "json",
          data: {food_id: food_id},
          success:function(data){
              $('.followFood span.FollowCount b').eq(index).html(data);
          },
          error:function(){
              
          }
      });
  }
  
  function sendFollowFoodNotification(food_id, foodFollowIndex)
  {
      $.ajax({
        url:""+JURL+"notifier",
        type: "POST",
        data: {object_id: food_id,  index: foodFollowIndex},
        success: function(data){
            
        },
        error:function(){
              
        }
    });
  }
  
  function hoverIngreNut(){
       $('.OtherCountryNuterients ul li.Nutr').each(function(index){
             $('.OtherCountryNuterients ul li.Nutr').eq(index).hover(function(){
            tempTitle = $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title');
             $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', '');
            },function(){
                $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', tempTitle);
            });
       });
    
}
  
  function tooltipNut(index){
    var height = 125;

 
  
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Nutr').eq(index))){
                //$('.TOOLTIPNut b').eq(index).remove();
                //$('.TOOLTIPNut').eq(index).append("<b>NUTRIENTS</b>");
                 //.$('.TOOLTIPHOLDERNut').eq(index).text(EMPTY);
            }
            else{
                    TPSWITCHER = false;
                    //$('.TOOLTIPNut').eq(index).html("");
                    $('.TOOLTIPNut').eq(index).hide(500);
                    $('.TOOLTIPHOLDERNut').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                     $('.TOOLTIPNut').eq(index).hide();
                    $('.TOOLTIPHOLDERNut').eq(index).hide();
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');
                     
                    if(TP[index].scrollHeight >= height){
                      
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }
}

function inifityScroltooltipNut(index){
        var height = 125;
        var   tempTitle;
       // $('.TOOLTIPNut').eq(index).append("<b>NUTRIENTS</b><br>");

        //on hover change title text
      $('.OtherCountryNuterients ul li.Nutr').eq(index).hover(function(){
            tempTitle = $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title');
            $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', 'ingredients');
        },function(){
            $('.OtherCountryNuterients ul li.Nutr').eq(index).attr('title', tempTitle);
        });

            //onclick show ingredients
        
        
        $('.OtherCountryNuterients ul li.Nutr').eq(index).click(function(){
          
           if(TPSWITCHER){
                  
                 
                     $('.TOOLTIPNut').eq(index).hide();
                    $('.TOOLTIPHOLDERNut').eq(index).hide();
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');
 
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPNut').eq(index).show();
                    $('.TOOLTIPHOLDERNut').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERNut').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDERNut');

                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERNut').eq(index).css({"overflow-y": "scroll"});
                    }
                }
             
        });
        
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Nutr').eq(index))){
               
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPNut').eq(index).hide(500);
                    $('.TOOLTIPHOLDERNut').eq(index).hide(500);
            }
        });
}




 function hoverIngreCont(){
       $('.OtherCountryNuterients ul li.Count').each(function(index){
             $('.OtherCountryNuterients ul li.Count').eq(index).hover(function(){
            tempTitleCont = $('.OtherCountryNuterients ul li.Count').eq(index).attr('title');
             $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', 'other countries that eat this food');
            },function(){
                $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', tempTitleCont);
            });
       });
    
}
  
  function tooltipCont(index){
    var height = 125;

        
        //on hover change title text
  
            
            //onclick show ingredients
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Count').eq(index))){
               //$('.TOOLTIPCont b').eq(index).remove();
               //$('.TOOLTIPCont').eq(index).append("<b>COUNTRIES</b>");
              // $('.TOOLTIPHOLDERCont').eq(index).text(EMPTY);
            }
            else{
                    TPSWITCHER = false;
                    //$('.TOOLTIPCont').eq(index).html("");
                    $('.TOOLTIPCont').eq(index).hide(500);
                    $('.TOOLTIPHOLDERCont').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                     $('.TOOLTIPCont').eq(index).hide();
                    $('.TOOLTIPHOLDERCont').eq(index).hide();
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html(tempTitleCont);
                    var TP = $('.TOOLTIPHOLDERCont');
                     
                    if(TP[index].scrollHeight >= height){
                      
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html( tempTitleCont);
                    var TP = $('.TOOLTIPHOLDERCont');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }
}


function inifityScroltooltipCont(index){
        var height = 125;
        var   tempTitle;
        //$('.TOOLTIPCont').eq(index).append("<b>COUNTRIES</b><br>");

        //on hover change title text
      $('.OtherCountryNuterients ul li.Count').eq(index).hover(function(){
            tempTitle = $('.OtherCountryNuterients ul li.Count').eq(index).attr('title');
            $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', 'other countries that eat this food');
        },function(){
            $('.OtherCountryNuterients ul li.Count').eq(index).attr('title', tempTitle);
        });

            //onclick show ingredients
        
        
        $('.OtherCountryNuterients ul li.Count').eq(index).click(function(){
          
           if(TPSWITCHER){
                  
                 
                     $('.TOOLTIPCont').eq(index).hide();
                    $('.TOOLTIPHOLDERCont').eq(index).hide();
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                   // var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html(tempTitle);
                    var TP = $('.TOOLTIPHOLDERCont');
 
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPCont').eq(index).show();
                    $('.TOOLTIPHOLDERCont').eq(index).show();
                    //var title = $('.post_profile_link ul li.INGRE img').eq(index).attr('title');
                    $('.TOOLTIPHOLDERCont').eq(index).html( tempTitle);
                    var TP = $('.TOOLTIPHOLDERCont');

                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERCont').eq(index).css({"overflow-y": "scroll"});
                    }
                }
             
        });
        
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.OtherCountryNuterients ul li.Count').eq(index))){
               
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPCont').eq(index).hide(500);
                    $('.TOOLTIPHOLDERCont').eq(index).hide(500);
            }
        });
}

