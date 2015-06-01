/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){

});



function processPictureMakeRecipe(){
    
     $('#cooksubmit img').remove();                         
     var message = '';
   if(!checkFalseVals()){
         
         //show message
         message  = 'All Fields are required';
        createAndShowErrorMessage(message);
   }
   else{
       
                    if(!processStepsImages()){
                       return false;
                    }else if(!doStepsPictureProccessing()){
                        return false;
                    }else{
                            //get all values and send to server here
                            var mealType = processMealType();
                            var baseFood = processBaseFood();
                            var recipeOrigin = processRecipeOriginCountry();
                            var recipeTitle = processRecipeTitle();
                            var recipeInstruction = processRecInstruction() ;
                            var ingredient = JSON.stringify(processIngredient());


                               $('#recipePicUpload').uploader(""+JURL+"MakeRecipe/processRecipePWI", {mealtype: mealType, basefood: baseFood, recipeorigin: recipeOrigin, recipetitle: recipeTitle, instruction:recipeInstruction, ingredients: ingredient},
                                    function(data){
                                       var result = data;
                                        $('#cooksubmit img').remove();
                                         if(result[0]['istrue'] === true){
                                             //get recipe_post_id
                                             var recipe_post_id = result[0]['recipe_post_id'];
                                             sendPWIPitureAndText(recipe_post_id); 
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
                                        $('#cooksubmit').append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='10'>");
                                    }
                                );

                    }
   }
}


function sendPWIPitureAndText(recipe_post_id){
    var message = '';
    var counter = 1;
    var $stepText = document.getElementsByClassName('stepText');
    for(var looper=0; looper < STEPSCOUNTER; looper++){
         var idname = 'stepUploadPic'+counter+'';
         var $image = document.getElementById(idname);
         var textDesc = $($stepText).eq(looper).val();
          sendaResquest(recipe_post_id, $image, idname, textDesc, counter);
      counter++;
    }
    $('#cooksubmit').html('post');
     message = "Your Recipe have been Posted. Post another Recipe";
     createAndShowErrorMessage(message);
     resetForm();
}

function sendaResquest(recipe_post_id, $imageid, idname, textDesc, index){
    $('#cooksubmit img').remove();
    var id = '#'+idname;
   $(id).uploader(""+JURL+"MakeRecipe/processStepsPWI", {recipe_post_id: recipe_post_id, textDesc: textDesc, img_id_name: idname, counter: index},
     function(success){
         $('#cooksubmit img').remove();
        return success; 
     }, 
     function(progress){
        $('#cooksubmit').append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='10'>");
     }
   );
}



function processStepsImages(){
    var count = 1;
    var message = '';
    var $stepText = document.getElementsByClassName('stepText');
    for(var looper =0; looper < $($stepText).size(); looper++){
         var idname = 'stepUploadPic'+count+'';
         var $image = document.getElementById(idname);
        if($($image).val() === EMPTY || $($stepText).eq(looper).val() === EMPTY){
            message = 'Step '+count+' image or text has not been filled';
            createAndShowErrorMessage(message);
           return false;
         }
         count++;
    }
    return true;
}

function doStepsPictureProccessing(){
    //check file sizes and if its image..
  
    var message = '';
    var maxSize = 4145728;
    var fielArray = ["image/png", "image/jpeg", "image/gif", "image/jpg"];
    var count = 1;
    
    for(var looper = 0; looper < STEPSCOUNTER; looper++){
        var idname = 'stepUploadPic'+count+'';
  
        var control = document.getElementById(idname);
        var files = control.files;
        var size = files[0].size;
        var name = files[0].name;
        var ftype = files[0].type;
        var fileTrue = fielArray.indexOf(ftype);
        if(!checkFileFormat(ftype, fielArray)){
            message = 'Step '+count+' wrong file format!';
            createAndShowErrorMessage(message);
            return false;
        }else if(size > maxSize){
            message = 'Step '+count+' Picture has to be less than 4MB in size';
            createAndShowErrorMessage(message);
            return false;
        } 
        count++;
    }
    return true;
}


function checkFileFormat(ftype, fielArray){
    if(ftype === fielArray[0] || ftype === fielArray[1] || ftype === fielArray[2] || ftype === fielArray[3]){
        return true;
    }else{
        return false;
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
       !processIngredient()){
        return false;
    }else if(!processRecPicture()){
        message = 'Please upload picture of your recipe';
        createAndShowErrorMessage(message);
    }
        return true;
}

function stripValAndDoCheck()
{
    alert();
    if(processMealType().replace(/\s+/g, '') === EMPTY || processBaseFood().replace(/\s+/g, '') === EMPTY  || processRecipeOriginCountry().replace(/\s+/g, '') === EMPTY  || processRecipeTitle().replace(/\s+/g, '') === EMPTY  ||
       processRecPicture().replace(/\s+/g, '') === EMPTY  || processIngredient().replace(/\s+/g, '') === EMPTY ){
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
    var $recTitle = document.getElementById('recipePicNameInput');
    
    if($($recTitle).val() === EMPTY)
        return false;
    else
        return $($recTitle).val();
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
                }else {

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


