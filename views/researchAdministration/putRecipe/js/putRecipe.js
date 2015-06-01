/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var countrySwitch = false;
$(document).ready(function(){
    removeSearchHolderBaseFood();
    removeSearchHolderForCountry();
    removeSearchConfirm();
    uploader();
});



function processPutRecipe(){
     $('.errMess').html(EMPTY);
    if(!processAField($('#recipe_title'))  ||  !processAField($('#recipe_instruction'))  
       || !processAField($('#recipe_healthBenefits'))
       || !processAField($('#file')) || !processAField($('#recipe_BasefoodName'))
       || !processAField($('#recipe_countryName'))){
            $('.errMess').html("All fields must be filled");
    }else if(!processMealType($('#mealType'))){
         $('.errMess').html("Choose meal type");
    }else if(!processIngredient()){
             $('.errMess').html("All fields must be filled");
    }else{
           var recipeTitle =  getValue($('#recipe_title'));
           var instruction =   getValue($('#recipe_instruction'));
           var healthBenefit =  getValue($('#recipe_healthBenefits'));
           var mealType =  getValue($('#mealType'));
           var baseFood = getValue($('#recipe_BasefoodName'));
           var baseCountry = getValue($('#recipe_countryName'));
           var ingredients = JSON.stringify(processIngredient());
           processPutRecipeRequest(recipeTitle, instruction, healthBenefit, mealType, baseFood, baseCountry, ingredients);
    }
}


function processPutRecipeRequest(recipeTitle, instructions, healthBenefit, mealType, baseFood, baseCountry, ingredients){
    $('#file').uploader(""+JURL+"researchAdministration/processPutRecipeRequest",
            {recipeTitle: recipeTitle, instructions: instructions, healthBenefit: healthBenefit, mealType: mealType, baseFood: baseFood, baseCountry: baseCountry, ingredients: ingredients},
            function(data)
            {
                $('#submitRecipePut img').remove();
                if(data === true){
                    $('.errMess').html(recipeTitle+ " has been add to the database.");
                    resetForm();
                }else{
                    $('.errMess').html(data);
                }

            },
            function(progress){
                $('#submitRecipePut').append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='15'>");
                $('#submitRecipePut img').css({position: "relative", left: "20px"});
            }
      );
}

function processIngredient()
{
    var $ingreQty = document.getElementsByClassName('recipe_ingreQty');
    var $ingredient = document.getElementsByClassName('recipe_ingre');
    var Ingre = {};
  var message = '';
     for(var looper =0; looper < $($ingreQty).size(); looper++){
         
         if($($ingreQty).eq(looper).val() === EMPTY || $($ingredient).eq(looper).val() === EMPTY){
             return false;
         }else{
           if($($ingreQty).eq(looper).val().length < 2 || $($ingredient).eq(looper).val().length < 2){
               message = 'Ingredient Qty and Ingredient has to be more than 2 letters';
               $('.errMess').html(message);
           }
           else {

                Ingre[looper] = { 
                Qty: "<span class='ingrQty'>"+$($ingreQty).eq(looper).val()+"</span>",
                ingredient: "<span class='ingre'>"+$($ingredient).eq(looper).val()+"</span>"
            };
                  
           }
            
           
         }
     }
    
     return Ingre;
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

function processMealType($name){
    var mealtype = 'Meal Type';
    
    if($($name).val() === mealtype){
        return false;
    }else{
        return true;
    }
}



function addIngreQtyNIngre(){
     FIELDCOUNTER++;
     $('#ingredientHolder').append('<input type="text" class="recipe_ingreQty" placeholder="ingredient Qty"><input type="text" class="recipe_ingre" placeholder="ingredient">\n\
                                     <button onclick="removeIngreQtyNIngre('+ FIELDCOUNTER +')" type="button" class="plus_ingreQty">-</button><br>');
}

function removeIngreQtyNIngre(index){
      FIELDCOUNTER--;
    
    var $ingrQty = document.getElementsByClassName('recipe_ingreQty');
     $($ingrQty).eq(index).remove();
     
     var $ingre = document.getElementsByClassName('recipe_ingre');
      $($ingre).eq(index).remove();
      
      var $Pcd = document.getElementsByClassName('plus_ingreQty');
      $($Pcd).eq(index).remove();
}

function searchCountry(){
    var $countryInput = document.getElementById('recipe_countryName');
    
    $('#searchResHolder').remove();
    $('#h').append("<div id='searchResHolder'></div>");
    $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "0px"});
    
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processRecipeOriginSearch", {recipeOrigin: search_val}, function(data){
          $('#searchResHolder').html(data);
    });
    
  
}


function searchFood(){
  
    var $countryInput = document.getElementById('recipe_BasefoodName');
    $('#searchResHolder').remove();
   
      $('#h').append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "183px", bottom: "0px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
}

function searchConfirmedRecipe(){
    var $countryInput = document.getElementById('search_confirm');
    $('#searchCFResHolder').remove();
   $('.ch').append("<div id='searchCFResHolder'></div>");
      
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseRecipeSearch", {baserecipe: search_val}, function(data){
               $('#searchCFResHolder').html(data);
    });
}

function collectValuBaseFood(food){
    var $baseFoodInput = document.getElementById('recipe_BasefoodName');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}

function collectValuCountry(country){
    var $countryInput = document.getElementById('recipe_countryName');
    $($countryInput).val(country);
     $('#searchResHolder').remove();
     countrySwitch = true;
 
}

function collectValuConfirmSearch(){
        var $baseFoodInput = document.getElementById('search_confirm');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
}


function removeSearchHolderForCountry(){
    var $countryInput = document.getElementById('countryInput');
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
    var $baseFoodInput = document.getElementById('baseFodInput');
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
    $('#recipe_title').val(EMPTY);
    $('#recipe_instruction').val(EMPTY);
    $('#recipe_healthBenefits').val(EMPTY);
    $('#mealType').val("Meal Type");
    $('#file').val(EMPTY);
    $('#recipe_BasefoodName').val(EMPTY);
    $('#recipe_countryName').val(EMPTY);
    $('.recipe_ingreQty').val(EMPTY);
    $('.recipe_ingre').val(EMPTY);
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
