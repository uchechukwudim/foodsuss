/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var countrySwitch = false;
$(document).ready(function(){
 escDialog();
 uploader();
});


function processTextMakeRecipe()
{

     $('#cooksubmit img').remove();                         
     var message = '';
   if(!checkFalseVals()){
         
         //show message
         message  = 'All Fields are required';
        createAndShowErrorMessage(message);
   }
   else{
           if(!stripValAndDoCheck){
               message = 'All fields require character letters';
               createAndShowErrorMessage(message);
           }else{
                    if(!doValsCount()){
                        message = 'Recipe Instruction field should be more than 50 letters and every other field should be more then 2 letters';
                       createAndShowErrorMessage(message);
                    }
                    else{
                            //get all values and send to server here
                            var mealType = processMealType();
                            var baseFood = processBaseFood();
                            var recipeOrigin = processRecipeOriginCountry();
                            var recipeTitle = processRecipeTitle();
                            var recipeInstruction = processRecInstruction() ;
                            var ingredient = JSON.stringify(processIngredient());


                               $('#recipePicUpload').uploader(""+JURL+"MakeRecipe/processRecipePosted", {mealtype: mealType, basefood: baseFood, recipeorigin: recipeOrigin, recipetitle: recipeTitle, instruction:recipeInstruction, ingredients: ingredient},
                                    function(data)
                                    {
                                        $('#cooksubmit img').remove();
                                         if(data === true){
                                             message = "Your message has been uploaded. Post another Recipe";
                                             createAndShowErrorMessage(message);
                                             resetForm_afterPost();
                                         }else if(data === false){
                                             message = "We are sorry your recipe cannot be posted at this time.";
                                             createAndShowErrorMessage(message);
                                         }
                                         else{
                                             //show data
                                             createAndShowErrorMessage(data);
                                         }
                                    },
                                    function(progress){
                                        $('#cooksubmit').append("<img src='"+JURL+"pictures/ajax-loader-white.gif'>");
                                    }
                                );

                    }
           }
   }

}

function createAndShowErrorMessage(message){
   $('#postErrorMessage').remove();
    var $dialog = document.getElementById('cookcancel');
    $($dialog).prepend("<div id='postErrorMessage'>"+message+"</div>");
}

function doValsCount(){
    if(processBaseFood().length < 2  || processRecipeTitle().length < 2  ||
       processRecInstruction().length < 50 ){
          return false;
    }else
        return true;
}

function checkFalseVals()
{
    var message = '';
    if(!processMealType() || !processBaseFood() || !processRecipeOriginCountry() || !processRecipeTitle() ||
       !processRecInstruction() || !processIngredient()){
        return false;
    }else if(!processRecPicture()){
        message = 'Recipe Image you required. Please upload picture of your recipe';
        createAndShowErrorMessage(message);
    }
        return true;
}

function stripValAndDoCheck()
{
    if(processMealType().replace(/\s+/g, '') === EMPTY || processBaseFood().replace(/\s+/g, '') === EMPTY  ||
       processRecipeOriginCountry().replace(/\s+/g, '') === EMPTY  || processRecipeTitle().replace(/\s+/g, '') === EMPTY  ||
       processRecInstruction().replace(/\s+/g, '') === EMPTY  || processRecPicture().replace(/\s+/g, '') === EMPTY  ||
       processIngredient().replace(/\s+/g, '') === EMPTY ){
          return false;
    }else
        return true;
}

function processMealType()
{
    var $mealType = document.getElementById('BLD');
    var MT = 'Meal Type';
    
    if($($mealType).val() === MT)
        return false;
    else
        return $($mealType).val();
}

function processBaseFood()
{
    var $baseFood = document.getElementById('baseFodInput');
    if($($baseFood).val() === EMPTY)
        return false;
    else
     return $($baseFood).val();
}

function processRecipeOriginCountry()
{
   var $RecipeOrigin = document.getElementById('countryInput');
   
   if($($RecipeOrigin).val() === EMPTY)
       return false;
   else
       return $($RecipeOrigin).val();
}

function processRecipeTitle()
{
    var $recTitle = document.getElementById('recipeNameInput');
    
    if($($recTitle).val() === EMPTY)
        return false;
    else
        return $($recTitle).val();
}

function processRecInstruction(){
    
    var $recInstruction = document.getElementById('recipeInstInput');
    
    if($($recInstruction).val() === EMPTY)
        return false;
    else
        return $($recInstruction).val();
}

function processRecPicture()
{
    var $recPic = document.getElementById('recipePicUpload');
    
    if($($recPic).val() === EMPTY)
        return false;
    else
        return $($recPic).val();
}

function processIngredient()
{
    var $ingreQty = document.getElementsByClassName('ingrQun');
    var $ingredient = document.getElementsByClassName('cookIngredient');
    var Ingre = {};
    var message = '';
    
     for(var looper =0; looper < $($ingreQty).size(); looper++){
         
         if($($ingreQty).eq(looper).val() === EMPTY || $($ingredient).eq(looper).val() === EMPTY){
             return false;
         }else{
           if($($ingreQty).eq(looper).val().length < 2 || $($ingredient).eq(looper).val().length < 2){
               message = 'Ingredient Qty and Ingredient has to be more than 2 letters';
              createAndShowErrorMessage(message);
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



function closDialog()
{
    var $layer = document.getElementById('cooklayer');
    var $dialog = document.getElementById('cookdialog');
    var $dialogHolder = document.getElementById('dialogHolder');
    var $DialogHeader = document.getElementById('cookheader_dialog');
    
         $($layer).remove();
         $($dialog).remove();
         $($DialogHeader).remove();
         $($dialogHolder).remove();
         $('html').css({"overflow-y":"visible"});
}

function escDialog()
{
    $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                 var $layer = document.getElementById('cooklayer');
                 var $dialog = document.getElementById('cookdialog');
                 var $DialogHeader = document.getElementById('cookheader_dialog');
                 $($layer).hide();
                 $($dialog).hide();
                 $($DialogHeader).hide();
                   $('html').css({"overflow-y":"visible"});
           }
           
     });
}

function searchCountry(){
    var $countryInput = document.getElementById('countryInput');
    
    $('#searchResHolder').remove();
    var $dialog = document.getElementById('cookdialog');
    $($dialog).append("<div id='searchResHolder'></div>");
    $('#searchResHolder').css({position: "absolute", left: "340px", bottom: "248px"});
    
    var search_val = $($countryInput).val();
    $.post(JURL+"MakeRecipe/processRecipeOriginSearch", {recipeOrigin: search_val}, function(data){
          $('#searchResHolder').html(data);
    });
    
  
}
function searchFood(){
  
    var $countryInput = document.getElementById('baseFodInput');
    $('#searchResHolder').remove();
     var $dialog = document.getElementById('cookdialog');
      $($dialog).append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "175px", bottom: "248px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"MakeRecipe/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
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

function collectValuBaseFood(food){
    var $baseFoodInput = document.getElementById('baseFodInput');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}

function collectValuCountry(country){
    var $countryInput = document.getElementById('countryInput');
    $($countryInput).val(country);
     $('#searchResHolder').remove();
     countrySwitch = true;
 
}


function doFullEmptyCheck()
{
    var backspace = 8;
     var $countryInput = document.getElementById('countryInput');
      
     if($($countryInput).val() !== EMPTY){
         $($countryInput).keyup(function(event){
             if(event.keyCode === backspace){
                 $($countryInput).val('');
                 countrySwitch = false;
             }
         });
     }
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

function resetForm_afterPost(){
    $('#BLD').val("Meal Type");
    $('#countryInput').val(EMPTY);
    $('#baseFodInput').val(EMPTY);
    $("#recipeNameInput").val(EMPTY);
    $("#recipeInstInput").val(EMPTY);
    $('.ingrQun').val(EMPTY);
    $('.cookIngredient').val(EMPTY);
    $('input[type=file]').val(EMPTY);
    $('#recipeUploadBut').attr('src', JURL+'pictures/camera.png');
    //$('#postErrorMessage').html(EMPTY);
}
