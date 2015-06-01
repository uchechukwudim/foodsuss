/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
});
function showCookImageDialog()
{
   $('#makeRecOptLoglayer').remove();
   $('#makeRecOptLogdialog').remove();
   resetForm();
   var cooklayer = document.createElement('div');
   var cookDialog = document.createElement('div');
   var closedialog = document.createElement('div');
   var dialogHolder = document.createElement('div');
   var dialogHeader = document.createElement('div');
   var DHspan = document.createElement('span');
   
   
   cooklayer.id = "cooklayer";
   cooklayer.className = "cooklayer";
   
   cookDialog.id = "cookdialog";
   cookDialog.className = "cookdialog";
   closedialog.id = "cookclose";
 
   dialogHolder.id = 'dialogHolder';
   dialogHolder.className = 'dialogHolder';
   
 
   dialogHeader.id = "cookheader_dialog"; 
   DHspan.className = "txt";
   DHspan.innerHTML = "Cook";
   
   dialogHeader.appendChild(DHspan);

   dialogHolder.appendChild(dialogHeader);
   
   dialogHolder.appendChild(cookDialog);
   document.body.appendChild(dialogHolder);
   document.body.appendChild(cooklayer);
   
   appendFormToDialogBox(cookDialog);
   $('html').css({"overflow-y":"hidden"});
   $('#cooklayer').show();
   $('#cookdialog').show();
   $('#cookheader_dialog').show();
  
}


function appendFormToDialogBox(cookDialog)
{
    var form = document.createElement('form');
    //form.target = 'cookform';
    form.id = 'cookPostForm';
    form.method = "post";
    form.enctype =  'multipart/form-data';
    form.action = "";
    
    var BLD = document.createElement('select');
    BLD.id = 'BLD';
    
   var Op = document.createElement('option');
   Op.innerHTML = 'Meal Type';
   BLD.appendChild(Op);
   
   var Op1 = document.createElement('option');
   Op1.innerHTML = 'Breakfast';
   BLD.appendChild(Op1);
   
   var Op2 = document.createElement('option');
   Op2.innerHTML = 'Lunch';
   BLD.appendChild(Op2);
   
   var Op3 = document.createElement('option');
   Op3.innerHTML = 'Dinner';
   BLD.appendChild(Op3);
   
   var Op4 = document.createElement('option');
   Op4.innerHTML = 'Drink';
   BLD.appendChild(Op4);
   
   var Op5 = document.createElement('option');
   Op5.innerHTML = 'Dessert';
   BLD.appendChild(Op5);
   
   var Op6 = document.createElement('option');
   Op6.innerHTML = 'Breakfast or Lunch';
   BLD.appendChild(Op6);
   
   var Op7 = document.createElement('option');
   Op7.innerHTML = 'Lunch or Dinner';
   BLD.appendChild(Op7);
   
   var Op8 = document.createElement('option');
   Op8.innerHTML = 'Breakfast or Dinner';
   BLD.appendChild(Op8);
   
   form.appendChild(BLD);
    
    var countryInput = document.createElement('input');
    countryInput.id = 'countryInput';
    countryInput.className = 'countryInput';
    countryInput.type = 'text';
    countryInput.placeholder = 'recipe origin country';
    countryInput.onkeyup = searchCountry;
    countryInput.onblur = removeSearchHolderForCountry;
    countryInput.onfocus = doFullEmptyCheck;
    
    form.appendChild(countryInput);
    
    var baseFoodInput = document.createElement('input');
    baseFoodInput.id = 'baseFodInput';
    baseFoodInput.type = 'text';
    baseFoodInput.placeholder = 'recipe base food';
    baseFoodInput.onkeyup = searchFood;
    baseFoodInput.onblur = removeSearchHolderBaseFood;
    form.appendChild(baseFoodInput);
    
    
    var recipeNameInput = document.createElement('input');
    recipeNameInput.id = "recipePicNameInput";
    recipeNameInput.type= 'text';
    recipeNameInput.placeholder = 'recipe name';
    form.appendChild(recipeNameInput);
    
    var stepCount = document.createElement('div');
    stepCount.className = 'stepCount';
    stepCount.innerHTML = 'Step 1';
    
    var stepText = document.createElement('textarea');
    stepText.className = 'stepText';
    stepText.placeholder = 'Step 1 Direction.';
    
    var stepImage = document.createElement('img');
    stepImage.className = 'stepImage';
    stepImage.src = JURL+"pictures/camera.png";
    stepImage.onclick = getPWIFirstPic;
    stepImage.title = 'upload step 1 picture';
    
     var stepUploadPic = document.createElement('input');
     stepUploadPic.id = 'stepUploadPic1';
     stepUploadPic.type = 'file';
     stepUploadPic.name = 'stepUploadPic1';
    
       
    var plusStep = document.createElement('button');
    plusStep.id = 'plusStep';
    plusStep.innerHTML = 'add more steps';
    plusStep.onclick = plusSteps;
    plusStep.type = "button";
    
    
    //creat holder for step text and step image
    var dirStepHolder = document.createElement('div');
    dirStepHolder.id = 'dirStepHolder';
    dirStepHolder.appendChild(stepCount);
    dirStepHolder.appendChild(stepImage);
    dirStepHolder.appendChild(stepUploadPic);
    dirStepHolder.appendChild(stepText);
    form.appendChild(dirStepHolder);
    
    var plusStep = document.createElement('button');
    plusStep.id = 'plusStep';
    plusStep.innerHTML = 'add more step';
    plusStep.title = 'add more steps';
    plusStep.type = "button";
    plusStep.onclick = plusSteps;
    form.appendChild(plusStep);
    
    
    var ingrQuntity = document.createElement('input');
    ingrQuntity.className = 'ingrQun';
    ingrQuntity.type = 'text';
    ingrQuntity.maxLength = '20';
    ingrQuntity.placeholder = 'ingredient Qty';

    
    var ingredient = document.createElement('input');
    ingredient.className = 'cookIngredient';
    ingredient.type = 'text';
    ingredient.maxLength = '40';
    ingredient.placeholder = 'ingredient';

   
    
    var IngrHolder = document.createElement('div');
    IngrHolder.id = 'ingHolder';
    
    IngrHolder.appendChild(ingrQuntity);
    IngrHolder.appendChild(ingredient);
    form.appendChild(IngrHolder);
    
    
    var plusIngr = document.createElement('button');
    plusIngr.id = 'plusIngre';
    plusIngr.innerHTML = 'add more fields';
    plusIngr.title = 'add more fileds';
    plusIngr.onclick = plusIngredient;
    plusIngr.type = "button";
    form.appendChild(plusIngr);
   
    var recipePicUpload =  document.createElement('input');
    recipePicUpload.id = 'recipePicUpload';
    recipePicUpload.type = 'file';
     recipePicUpload.name = 'recipePicUpload';
    form.appendChild(recipePicUpload);
    
    var recipeUploadBut = document.createElement('img');
    recipeUploadBut.id = 'recipeUploadBut';
    recipeUploadBut.src = JURL+"pictures/camera.png";
    recipeUploadBut.title = 'upload recipe picture';
    recipeUploadBut.onclick = getRecipePic;
    form.appendChild(recipeUploadBut);
    
    var cancel = document.createElement('button');
    cancel.id = 'cookcancel';
    cancel.innerHTML = "cancel";
    cancel.form = 'usrform';
    cancel.type = 'button';
    cancel.name = 'cancel';
    cancel.onclick =  closDialog;
    form.appendChild(cancel);
    
    var submit = document.createElement('button');
    submit.id = 'cooksubmit';
    submit.innerHTML = "post";
    submit.form = 'usrform';
    submit.type = 'button';
    submit.name = 'submit';
    submit.onclick = processPictureMakeRecipe;
    form.appendChild(submit);
    
    cookDialog.appendChild(form);
    
    
}

    function plusIngredient()
    {
        if(FIELDCOUNTER < FIELD_MAX){
            FIELDCOUNTER++;
            var $ingrHolder = document.getElementById('ingHolder');
            
            $($ingrHolder).append("<input  class = 'ingrQun' placeholder= '  ingredient Qty' maxlength = '15'  type='text'>");
            $($ingrHolder).append("<input  class = 'cookIngredient' placeholder= '  ingredient' maxlength = '30'  type='text'>");
            $($ingrHolder).append("<button  class = 'negIngre' onclick='removeField("+FIELDCOUNTER+")' type='button'>x</button");
        }
    }
    function removeField(index)
    {
        if(FIELDCOUNTER === index){
          FIELDCOUNTER--;
          index--;
          var $ingreQun = document.getElementsByClassName('ingrQun');
          $($ingreQun).eq(index).remove();

          var $cookIngre = document.getElementsByClassName('cookIngredient');
          $($cookIngre).eq(index).remove();

          var $negIngre = document.getElementsByClassName('negIngre');
          $($negIngre).eq(index).remove();
          $($negIngre).eq(index-1).remove();
        }
     
   }
    
    function plusSteps()
    {
           
        if(STEPSCOUNTER < STEPS_MAX){
            STEPSCOUNTER++;
            var $dirStepHolder = document.getElementById('dirStepHolder');

            $($dirStepHolder).append("<div class ='stepCount'>Step "+ STEPSCOUNTER +" </div>");
            $($dirStepHolder).append("<img onclick='getPWIOtherPic("+ STEPSCOUNTER +")'  class= 'stepImage' src = '"+JURL+"pictures/camera.png' title='upload step "+STEPSCOUNTER+" picture' >");
            $($dirStepHolder).append("<input style='display: none;' id='stepUploadPic"+STEPSCOUNTER+"' name='stepUploadPic"+STEPSCOUNTER+"' type='file'>");
            $($dirStepHolder).append("<textarea class='stepText' placeholder='Step "+STEPSCOUNTER+" direction'>");
            $($dirStepHolder).append("<button  class = 'negSteps' onclick='removeStep("+ STEPSCOUNTER +")' type='button'>x</button");
        }
    }
    
    function removeStep(index)
    {
        
        if(STEPSCOUNTER === index){
            
            STEPSCOUNTER--;
            index--;
            var $stepCount= document.getElementsByClassName('stepCount');
            $($stepCount).eq(index).remove();

            var $stepImage = document.getElementsByClassName('stepImage');
            $($stepImage).eq(index).remove();

            var $stepUploadPic = document.getElementsByClassName('stepUploadPic');
            $($stepUploadPic).eq(index).remove();

            var $stepText = document.getElementsByClassName('stepText');
            $($stepText).eq(index).remove();

            var $negSteps = document.getElementsByClassName('negSteps');
            $($negSteps).eq(index).remove();
            $($negSteps).eq(index-1).remove();
        }
        

    }

     
  
  
  function getRecipePic()
  {
      $('input[name=recipePicUpload]').trigger('click');
      
      $('input[name=recipePicUpload]').change(function(){
          var recipePicBut = document.getElementById('recipeUploadBut');
          
          recipePicBut.src = JURL+'pictures/camera_sel.png';
      });
  }

  function getPWIFirstPic(){
       $('input[id=stepUploadPic1]').trigger('click');
      
      $('input[id=stepUploadPic1]').change(function(){
          $('.stepImage').eq(0).attr('src', JURL+'pictures/camera_sel.png');
      });
  }
  
   function getPWIOtherPic(count){
      
       $('input[id=stepUploadPic'+count+']').trigger('click');
      
      $('input[id=stepUploadPic'+count+']').change(function(){
          var nC =  parseInt(count);
          nC = nC-1;
          $('.stepImage').eq(nC).attr('src', JURL+'pictures/camera_sel.png');
      });
  }



function resetForm(){
    $('#BLD').val("Meal Type");
    $('#countryInput').val(EMPTY);
    $('#baseFodInput').val(EMPTY);
    $("#recipePicNameInput").val(EMPTY);
    $('.ingrQun').val(EMPTY);
    $('.cookIngredient').val(EMPTY);
    $('.stepText').val(EMPTY);
    $('input[type=file]').val(EMPTY);
    $('#postErrorMessage').html(EMPTY);
}


