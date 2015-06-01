/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var countrySwitch = false;
$(document).ready(function (){
      uploader();
   removeSearchHolderForCountry();
   removeSearchHolderBaseFood();
   removeSearchConfirm();
 
});

function processPutProduct(){
     $('.errMess').html(EMPTY);
    if(!processAField($('#product_name'))  ||  !processAField($('#product_description'))  
       || !processAField($('#ProdFoodName'))
       || !processAField($('#file')) || !processAField($('#ProdCountryName'))){
            $('.errMess').html("All fields must be filled");
    }else if(!processEatWith()){
             $('.errMess').html("All fields must be filled");
    }else{
     
           var productName =  getValue($('#product_name'));
           var desc =   getValue($('#product_description'));
           var foodName =  getValue($('#ProdFoodName'));
           var countryName =  getValue($('#ProdCountryName'));
           var eatwith = JSON.stringify(processEatWith());
          
          processPutProductRequest(productName, desc, foodName, countryName, eatwith);
    }
}



function processPutProductRequest(productName, desc, foodName, countryName, eatwith){
    $('#file').uploader(""+JURL+"researchAdministration/processPutProductRequest", {productName: productName, description: desc, foodName: foodName, countryName: countryName, eatwith:eatwith},
            function(data)
            {
                $('#submitPutProduct img').remove();
                if(data === true){
                    $('.errMess').html(productName+ " has been add to the database.");
                    resetForm();
                }else{
                    $('.errMess').html(data);
                }

            },
            function(progress){
                $('#submitPutProduct').append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='15'>");
                $('#submitPutProduct img').css({position: "relative", left: "20px"});
            }
      );
}

function processEatWith(){
    var $Ew = document.getElementsByClassName('ProdEatwith');
     var $type = document.getElementsByClassName('eatwithtype');
    var eatwith = {};
  var message = '';
     for(var looper =0; looper < $($Ew).size(); looper++){
         
         if($($Ew).eq(looper).val() === EMPTY || !processType($($type).eq(looper).val())){
             return false;
         }else{
           if($($Ew).eq(looper).val().length < 2){
               message = 'eatwith has to be more than 2 letters';
               $('.errMess').html(message);
           }
           else {
                eatwith[looper] = { 
                Ew: "<span class='eatwith'>"+$($Ew).eq(looper).val()+"</span>",
                type: $($type).eq(looper).val()
            };
                  
           }
            
           
         }
     }
    
     return eatwith;
}


function processAField($val)
{
    if($($val).val() === EMPTY){
        return false;
    }else
     return true;
}

function getValue($name){
    if($($name).val() !== EMPTY){
        return  $($name).val();
    }
}

function processType(name){
    var type = 'Type';
    
    if(name === type){
        return false;
    }else{
        return true;
    }
}


function addEatwith(){
    FIELDCOUNTER++;
    $('#eatwithHolder').append('<input type="text" class="ProdEatwith" placeholder="what to eatwith product">\n\
                                <button onclick="removeEatwith('+ FIELDCOUNTER +')" type="button" class="plusProdEatwith">-</button><br>\n\
                                 <select class="eatwithtype">\n\
                                 <option>Type</option>\n\
                                 <option>Food</option>\n\
                                 <option>Product</option>\n\
                                 <option>Recipe</option>\n\
                                 </select><br>');
}

function removeEatwith(index){
    FIELDCOUNTER--;
    var $eatwith = document.getElementsByClassName('ProdEatwith');
     $($eatwith).eq(index).remove();
     
     var $type = document.getElementsByClassName('eatwithtype');
     $($type).eq(index).remove();
      
      var $Pcd = document.getElementsByClassName('plusProdEatwith');
      $($Pcd).eq(index).remove();
}

function searchCountry(){
    var $countryInput = document.getElementById('ProdCountryName');
    
    $('#searchResHolder').remove();
    $('#h').append("<div id='searchResHolder'></div>");
    $('#searchResHolder').css({position: "absolute", left: "183px", bottom: "90px"});
    
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processRecipeOriginSearch", {recipeOrigin: search_val}, function(data){
          $('#searchResHolder').html(data);
    });
    
  
}


function searchFood(){
  
    var $countryInput = document.getElementById('ProdFoodName');
    $('#searchResHolder').remove();
   
      $('#h').append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "90px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
}

function collectValuBaseFood(food){
    var $baseFoodInput = document.getElementById('ProdFoodName');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}

function collectValuCountry(country){
    var $countryInput = document.getElementById('ProdCountryName');
    $($countryInput).val(country);
     $('#searchResHolder').remove();
     countrySwitch = true;
 
}


function removeSearchHolderForCountry(){
    var $countryInput = document.getElementById('ProdCountryName');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchResHolder') || $targt.is($countryInput) || $targt.is('.BaseFoodOrigin')){
               
             }
             else{
                   if(!countrySwitch){
                    $($countryInput).val('');
                    $('#searchResHolder').remove();
                  }
             }
    });
}

function removeSearchHolderBaseFood(){
    var $baseFoodInput = document.getElementById('ProdFoodName');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchResHolder') || $targt.is($baseFoodInput)){
               
             }
             else{
                  
                    $('#searchResHolder').remove();
             }
    });
}

function removeSearchConfirm(){
    var $baseFoodInput = document.getElementById('search_confirm');
    $(document).click(function(event){
        var $targt = $(event.target);
             if($targt.is('#searchCFResHolder') || $targt.is($baseFoodInput)){
               
             }
             else{
                  
                    $('#searchCFResHolder').remove();
             }
    });
}

function resetForm(){
    $('#product_name').val(EMPTY);
    $('#product_description').val(EMPTY);
    $('#ProdFoodName').val(EMPTY);
    $('.eatwithtype').val("Type");
    $('#file').val(EMPTY);
    $('#ProdCountryName').val(EMPTY);
    $('.ProdEatwith').val(EMPTY);
}


function uploader()
{
 
    $.fn.uploader = function(remote,data,successFn,progressFn) {
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
					}
				});
			}
		});
               
	};
}



function postProductEatWith(){
    $('#putProductHolder').html(' <h2>Post Product Eatwith</h2>\n\
                                <form id="putProduct">\n\
                                <input onkeyup="searchProductName()" type="text" id="product_name" placeholder="Product Name"><br>\n\
                                <input onkeyup="searchFood()" type="text" id="ProdFoodName" placeholder="Base Food">\n\
                                <input onkeyup="searchCountry()" type="text" id="ProdCountryName" placeholder="Base Country"><br>\n\
                                <div id="h"></div>\n\
                                <div id="eatwithHolder">\n\
                                    <input type="text" class="ProdEatwith" placeholder="what to eatwith product">\n\
                                    <button onclick="addEatwith()" type="button" class="plusProdEatwith">+</button><br>\n\
                                    <select class="eatwithtype">\n\
                                        <option>Type</option>\n\
                                        <option>Food</option>\n\
                                        <option>Product</option>\n\
                                        <option>Recipe</option>\n\
                                    </select><br>\n\
                                </div>\n\
                                <span class="errMess"></span><br>\n\
                                <button onclick="processPostPutProductEatwith()" type="button" id="submitPutProduct">Post</button>\n\
                            </form>');
}

function searchProductName(){
    var $countryInput = document.getElementById('product_name');
    $('#searchResHolder').remove();
   
      $('#h').append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "115px", "font-size":"14px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseProductSearch", {baseProduct: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
}

function searchConfirmProductName(){
    var $countryInput = document.getElementById('product_name');
    $('#searchCFResHolder').remove();
   
      $('.ch').append("<div id='searchCFResHolder'></div>");
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseProductSearch", {baseProduct: search_val}, function(data){
               $('#searchCFResHolder').html(data);
    });
}


function collectValuBaseProduct(food){
    var $baseFoodInput = document.getElementById('product_name');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}

function processPostPutProductEatwith(){
    $('.errMess').html(EMPTY);
    if(!processAField($('#product_name')) || !processAField($('#ProdFoodName'))
        || !processAField($('#ProdCountryName'))){
            $('.errMess').html("All fields must be filled");
    }else if(!processEatWith()){
             $('.errMess').html("All fields must be filled");
    }else{
     
           var productName =  getValue($('#product_name'));
           var foodName =  getValue($('#ProdFoodName'));
           var countryName =  getValue($('#ProdCountryName'));
           var eatwith = JSON.stringify(processEatWith());
          
          processPostPutProductEatwithRequest(productName,  foodName, countryName, eatwith);
    }
} 

function processPostPutProductEatwithRequest(productName,  foodName, countryName, eatwith){
    $.ajax({
        url: JURL+"researchAdministration/processPostPutProductEatwithRequest",
        type: "POST",
        dataType: "json",
        data: {productName: productName, fooName: foodName, countryName: countryName, eatwith: eatwith},
        success: function(data){
            
        }
    });
}