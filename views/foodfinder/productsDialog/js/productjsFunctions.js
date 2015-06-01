
var TPSWITCHER = false;
var SHSWITCHER = false;
var GEOSWITCHER = false;
var TEMPINDEX ;
var tempTitle ='';
function ShowProductsDialogBox(food, data)
{
    //record  scroll postition
   // var scrollPos = $('body').scrollTop();

    //get products with ajax
   // products(food);
        
        //Show dialog box
        $('html').append('<div id="productLayer"></div>');
        $('html').append('<div class=center-DH">\n\
                        <div class="productDialog is-fixed">\n\
                        <div id="ProductClose">|x|</div>\n\
                        <div id="header_dialogProd"><span class="txt">Products Made From '+food+'</span></div>\n\
                        <div id="holdProd"></div>\n\
                        </div>\n\
                         </div>');
         
      $('#holdProd').html(data);
      $('#productLayer').show();
      $('.productDialog').show();
       
      $('#ProductClose').click(function(){
                $('#productLayer').remove();
                $('.productDialog').remove();
                $('#ProductClose').remove();
      });

            $(document).keyup(function(e){
                if(e.which === 27){
                // Close my modal window
                 $('html').css({"overflow-y": "visible"});
                 $('#productLayer').remove();
                $('.productDialog').remove();
                $('#ProductClose').remove();

            }
         });
}


function products(food, country, index)
{
     $("#holdProd").html("");
     $(".products #Prod").eq(index).html("<img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='30' height='30' >");
   $.ajax({
       url: ""+JURL+"foodfinder/getProducts",
       type: "get",
       dataType: "json",
       data: {food: food, country: country},
       success: function(data){
           $(".products #Prod").eq(index).html("<img src='"+JURL+"pictures/foods/ENRI_PRODUCT_ICONS.png' width='40' titile='Products' alt=''>");
           if(data === 0){
                NoProductrrorMessage(food);
           }else{
            
                  ShowProductsDialogBox(food, data);
           }
      
       }
   });
}

function AllProducts(food, index)
{
     $("#holdProd").html("");
     $(".products #Prod").eq(index).html("<img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='30' height='30' >");
   $.ajax({
       url: ""+JURL+"foodfinder/getProducts",
       type: "get",
       dataType: "json",
       data: {food: food},
       success: function(data){
           $(".products #Prod").eq(index).html("<img src='"+JURL+"pictures/foods/ENRI_PRODUCT_ICONS.png' width='40' titile='Products' alt=''>");
          if(data === 0){
                NoProductrrorMessage(food);
           }else{
         
                  ShowProductsDialogBox(food, data);
           }
      
       }
   });
}

function NoProductrrorMessage(food)
  {
       $('html').append('<div id="error_layer"></div>');
       $('html').append('<div class="center-DH">\n\
                          <div class="error_dialog is-fixed">\n\
                                <div id="header_dialog"><span class ="txt">Info Box</span></div>\n\
                                <div id="er_message">'+message+'</div>\n\
                                <div id="error_close">| x |</div>\n\
                          </div>\n\
                        </div>');
      var message = "There are no Products for <b>"+food+"</b> yet. We are working hard to provide Products </br></br> Thank you for your patience";
      document.getElementById('er_message').innerHTML = message;
      
       $('#error_layer').show();
      $('.error_dialog').show();
      $('#error_close').show();
       
      $('#error_close').click(function(){
                $('#error_layer').remove();
                $('.error_dialog').remove();
                $('#error_close').remove();
      });


                       $(document).keyup(function(e){
                           if(e.which === 27){
                           // Close my modal window
                            $('#error_layer').remove();
                           $('.error_dialog').remove();
                           $('#error_close').remove();
                          // window.location.replace("http://localhost/foodfinder/food/"+country+"");
                       }
                    });
  }
  
  function getEatWith(country, index, product_name)
  {
        $('.TOOLTIPHOLDERProd').eq(index).html("<img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50' height='50' >");
            $.ajax({
             url: ""+JURL+"foodfinder/getProductEatWith",
             type: "get",
             dataType: "json",
             data: {product_name: product_name, country: country},
             success: function(data){
                     $('.TOOLTIPHOLDERProd').eq(index).html(data);
              }
           });
 
  }
  

  
  function tooltipProd(index, country, product_name){
    var height = 125;

        //on hover change title text
     //onclick show ingredients
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.prodList ul.eatwith li img.EWimg').eq(index))){
        
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPProd').eq(index).html("");
                    $('.TOOLTIPProd').eq(index).hide(500);
                    $('.TOOLTIPHOLDERProd').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                    $('.TOOLTIPProd').eq(index).hide();
                    $('.TOOLTIPHOLDERProd').eq(index).hide();
                    $('.TOOLTIPProd').eq(index).show();
                    $('.TOOLTIPHOLDERProd').eq(index).show();
                    //call eat with here
                     getEatWith(country, index, product_name);

                    var TP = $('.TOOLTIPHOLDERProd');
                     
                    if(TP[index].scrollHeight > height){
                      
                        $('.TOOLTIPHOLDERProd').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPProd').eq(index).show();
                    $('.TOOLTIPHOLDERProd').eq(index).show();
                    //call eat with here
                    getEatWith(country, index, product_name);
                    var TP = $('.TOOLTIPHOLDERProd');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERProd').eq(index).css({"overflow-y": "scroll"});
                    }
                }
    
        

    
}

  function getAllEatWith(index, product_name)
  {
          $('.TOOLTIPHOLDERProd').eq(index).html("<img src='"+JURL+"pictures/general_smal_ajax-loader.gif' width='50' height='50' >");
            $.ajax({
             url: ""+JURL+"foodfinder/getProductEatWith",
             type: "get",
             dataType: "json",
             data: {product_name: product_name},
             success: function(data){
                   $('.TOOLTIPHOLDERProd').eq(index).html(data);
              }
           });
 
  }

function tooltipAllProd(index, product_name){
    var height = 125;
  

  
        //on hover change title text
     //onclick show ingredients
        $(document).click(function(event){
            var $targt = $(event.target);
            if($targt.is($('.prodList ul.eatwith li img.EWimg').eq(index))){
        
            }
            else{
                    TPSWITCHER = false;
                    $('.TOOLTIPProd').eq(index).html("");
                    $('.TOOLTIPProd').eq(index).hide(500);
                    $('.TOOLTIPHOLDERProd').eq(index).hide(500);
            }
        });
                if(TPSWITCHER){
                   
                 
                    $('.TOOLTIPProd').eq(index).hide();
                    $('.TOOLTIPHOLDERProd').eq(index).hide();
                    $('.TOOLTIPProd').eq(index).show();
                    $('.TOOLTIPHOLDERProd').eq(index).show();
                    //call eat with here
                     getAllEatWith(index, product_name);

                    var TP = $('.TOOLTIPHOLDERProd');
                     
                    if(TP[index].scrollHeight > height){
                      
                        $('.TOOLTIPHOLDERProd').eq(index).css({"overflow-y": "scroll"});
                    }
                }else{
                    TPSWITCHER = true;
                    $('.TOOLTIPProd').eq(index).show();
                    $('.TOOLTIPHOLDERProd').eq(index).show();
                    //call eat with here
                    getAllEatWith(index, product_name);
                    var TP = $('.TOOLTIPHOLDERProd');
                    
                    if(TP[index].scrollHeight > height){
                        $('.TOOLTIPHOLDERProd').eq(index).css({"overflow-y": "scroll"});
                    }
                }
    
        

    
}