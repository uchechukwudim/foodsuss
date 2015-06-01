/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){

    showCookBar();
    MRclose();
});

function showCookBar()
{
    var z = 0;
    var oneH = 100;
   if($(document).scrollTop() === z){
       $('#post_recipe').show(800);
       $('#post_recipe').hover(function(){
                 $('#post_recipe span').css({"color": "white"});
            }, function(){
                 $('#post_recipe span').css({"color": "rgba(0, 0, 0, 0.5)"});
            });
   }
   $(document).scroll(function(){
      
        if($(document).scrollTop() >= z && $(document).scrollTop() <= oneH)
        {

            $('#post_recipe').show(800);

            $('#post_recipe').hover(function(){
                 $('#post_recipe span').css({"color": "white"});
            }, function(){
                 $('#post_recipe span').css({"color": "rgba(0, 0, 0, 0.5)"});
            });
        }
         else{
            $('#post_recipe').hide(800);
        }
   });
   
}


function cookOptions(){
    

    $('html').append('<div id="makeRecOptLoglayer"></div>');
    $('html').append('<div id="makeRecOptLogdialog">\n\
                        <div id="makeRecOptLogheader_dialogProd"><span class ="txt">Choose</span><span onclick ="ChooseOpclose()" class ="esc">[Esc]</span></div>\n\
                        <div id="makeRecOptHolder">\n\
                          <ul>\n\
                         <li id="MROptList" onclick="showCookTextDialog()" ><img src="'+JURL+'pictures/cook/ENRI_TellUSFOOD_ICONS.png" width="25"><span>Post with Text</span></li>\n\
                         <li onclick="showCookImageDialog()"><img src="'+JURL+'pictures/cook/ENRI_RES_PIC.png" width="25">Post with Pictures</li>\n\
                          </ul>\n\
                        </div>\n\
                     </div>');
    $('#makeRecOptLoglayer').show();
    $('#makeRecOptLogdialog').show();
}

function ChooseOpclose(){
    
        $('#makeRecOptLoglayer').remove();
        $('#makeRecOptLogdialog').remove();

     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#makeRecOptLoglayer').remove();
                $('#makeRecOptLogdialog').remove();
           }
     });
}


function MRclose(){
    $('#makeRecOptLogclose').click(function(){
        $('#makeRecOptLoglayer').remove();
        $('#makeRecOptLogdialog').remove();
     });
     
     $(document).keyup(function(event){
         
         if(event.which === 27)
          {
                $('#makeRecOptLoglayer').remove();
                $('#makeRecOptLogdialog').remove();
           }
     });
}

function showCookTextDialog()
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
   
   appendFormTextToDialogBox(cookDialog);
   $('html').css({"overflow-y":"hidden"});
   $('#cooklayer').show();
   $('#cookdialog').show();
   $('#cookheader_dialog').show();
  
}


function appendFormTextToDialogBox(cookDialog)
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
    recipeNameInput.id = "recipeNameInput";
    recipeNameInput.type= 'text';
    recipeNameInput.placeholder = 'recipe name';
    form.appendChild(recipeNameInput);
    
    var recipeInstInput = document.createElement('textarea');
    recipeInstInput.id = 'recipeInstInput';
    recipeInstInput.placeholder = 'recipe directions';
    form.appendChild(recipeInstInput);
    
    
    
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
    plusIngr.innerHTML = 'add more field';
    plusIngr.onclick = plusTextIngredient;
    plusIngr.type = "button";
    form.appendChild(plusIngr);
   
    var recipePicUpload =  document.createElement('input');
    recipePicUpload.id = 'recipePicUpload';
    recipePicUpload.type = 'file';
     recipePicUpload.name = 'file';
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
    submit.onclick = processTextMakeRecipe;
    form.appendChild(submit);
    
    cookDialog.appendChild(form);
    
    
}

    function plusTextIngredient()
    {
        if(FIELDCOUNTER < FIELD_MAX){
            FIELDCOUNTER++;
            var $ingrHolder = document.getElementById('ingHolder');

            $($ingrHolder).append("<input  class = 'ingrQun' placeholder= '  ingredient Qty' maxlength = '15'  type='text'>");
            $($ingrHolder).append("<input  class = 'cookIngredient' placeholder= '  ingredient' maxlength = '30'  type='text'>");
            $($ingrHolder).append("<button  class = 'negIngre' onclick='removeTextField("+FIELDCOUNTER+")' type='button'>x</button");
        }
    }

     
  function removeTextField(index)
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
  
  function getRecipePic()
  {
      $('input[type=file]').trigger('click');
      
      $('input[type=file]').change(function(){
          var recipePicBut = document.getElementById('recipeUploadBut');
          
          recipePicBut.src = JURL+'pictures/camera_sel.png';
      });
  }




function resetForm(){
    $('#BLD').val("Meal Type");
    $('#countryInput').val(EMPTY);
    $('#baseFodInput').val(EMPTY);
    $("#recipeNameInput").val(EMPTY);
    $("#recipeInstInput").val(EMPTY);
    $('.ingrQun').val(EMPTY);
    $('.cookIngredient').val(EMPTY);
    $('input[type=file]').val(EMPTY);
    $('#postErrorMessage').html(EMPTY);
}


