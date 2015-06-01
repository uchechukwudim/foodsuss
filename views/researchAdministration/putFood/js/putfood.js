/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var countrySwitch = false;
$(document).ready(function(){
    uploader();
    removeSearchHolderForCountry();
    removeSearchConfirm();
});

function addCountryOriginandDesc(){
       FIELDCOUNTER++;
    $('#countryOrgin_descrip_holder').append('<input onkeyup="searchCountry('+ FIELDCOUNTER +')" type="text" class="country_origin" placeholder="country(s) that consume`s this food">\n\
                                              <div class="h"></div>\n\
                                             <textarea class="country_description" cols="28" rows="6" placeholder="Describe how this food is being consummed in the said country of origin."></textarea><br>\n\
                                             <button onclick="RemoveCountryOriginandDesc('+ FIELDCOUNTER +')" type="button" class="plusCountry_desc">-</button><br>')
}

function RemoveCountryOriginandDesc(index){
    FIELDCOUNTER--;
    
    var $Co = document.getElementsByClassName('country_origin');
     $($Co).eq(index).remove();
     
     var $Cd = document.getElementsByClassName('country_description');
      $($Cd).eq(index).remove();
      
      var $Pcd = document.getElementsByClassName('plusCountry_desc');
      $($Pcd).eq(index).remove();
     
}

function processPutFood(){

     $('.errMess').html("");
    if(!processAField($('#food_name'))  ||  !processAField($('#gen_description'))  
       || !processAField($('#gen_description'))
       || !processAField($('#gen_nuterients'))
       || !processAField($('#file'))){
            $('.errMess').html("All fields must be filled");
    }else if(!processFoodType($('#foodType')) ){
        $('.errMess').html("choose food type");
    }else if(!processFoodOrigins()){
             $('.errMess').html("All fields must be filled");
    }else{
           var foodName =  getValue($('#food_name'));
           var foodGeneralDesc =   getValue($('#gen_description'));
           var nutrient =  getValue($('#gen_nuterients'));
           var foodType =  getValue($('#foodType'));
           var originAndDesc = JSON.stringify(processFoodOrigins());
           processPutFoodRequest(foodName, foodGeneralDesc, nutrient, foodType, originAndDesc);
    }
}

function processPutFoodRequest(foodName, foodGeneralDesc, nutrient, foodType, originAndDesc){
     $('#file').uploader(""+JURL+"researchAdministration/processPutFoodRequest", {foodName: foodName, food_description: foodGeneralDesc, nutrient: nutrient, foodType: foodType, foodOrigins: originAndDesc},
            function(data)
            {
                $('#submitPutFood img').remove();
                if(data === true){
                    $('.errMess').html(foodName+ " has been add to the database.");
                    resetForm();
                }else{
                    $('.errMess').html(data);
                }

            },
            function(progress){
                $('#submitPutFood').append("<img src='"+JURL+"pictures/ajax-loader-white.gif' width='15'>");
            }
      );
}

function searchCountry(index){
    var $countryInput = document.getElementsByClassName('country_origin');
    
    $('#searchResHolder').remove();
    var $hold = document.getElementsByClassName('country_origin');
    $('.h').eq(index).append("<div id='searchResHolder'></div>");
    $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "58px"});
    
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processRecipeOriginSearch", {recipeOrigin: search_val, index: index}, function(data){
          $('#searchResHolder').html(data);
    });
    
  
}

function collectValuCountry(country, index){
    var $countryInput = document.getElementsByClassName('country_origin');
    $($countryInput).eq(index).val(country);
     $('#searchResHolder').remove();
     countrySwitch = true;
 
}

function removeSearchHolderForCountry(){
    var $countryInput = document.getElementsByClassName('country_origin');
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


function processFoodOrigins()
{
    var $country_origin = document.getElementsByClassName('country_origin');
    var $country_description = document.getElementsByClassName('country_description');
    var coutryDescription = {};
     for(var looper =0; looper < $($country_origin).size(); looper++){
         
         if($($country_origin).eq(looper).val() === EMPTY || $($country_description).eq(looper).val() === EMPTY){
             return false;
         }else{
             coutryDescription [looper] = { 
                country_name: $($country_origin).eq(looper).val(),
                description: $($country_description ).eq(looper).val()
            };
         }
     }
    
     return coutryDescription ;
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

function processFoodType($name){
    var foodtype = 'Food type';
    
    if($($name).val() === foodtype){
        return false;
    }else{
        return true;
    }
}

function resetForm(){
    $('#food_name').val(EMPTY);
    $('#gen_description').val(EMPTY);
    $('#gen_nuterients').val(EMPTY);
    $('#foodType').val("Food Type");
    $('#file').val(EMPTY);
    $('.country_origin').val(EMPTY);
    $('.country_description').val(EMPTY);
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









function postFoodOriginCountryDesc(){
    $('#putFoodHolder').html('<h2>Post country(s) Origin<h2>\n\
                                <div id="countryOrgin_descrip_holder">\n\
                                <input onkeyup="searchFood()" type="text" id="existing_food_name" placeholder="existing Food Name"><br>\n\
                                <input onkeyup=" searchCountry(0)" type="text" class="country_origin exist" placeholder="country(s) that consume`s this food">\n\
                                <div class="h"></div>\n\
                                <textarea class="country_description existing" cols="54" rows="6" placeholder="Describe how this food is being consummed in the said country of origin."></textarea><br>\n\
                                  <button onclick="addExistingCountryOriginandDesc()" type="button" class="plusCountry_desc">+</button><br>\n\
                               </div>\n\
                              <span style="font-size: 14px;" class="errMess"></span>\n\
                              <button onclick="processExistingPutFood()" type="button" id="Existing_submitPutFood">Post</button> ');
}

function addExistingCountryOriginandDesc(){
       EFIELDCOUNTER++;
    $('#countryOrgin_descrip_holder').append('<input onkeyup="searchCountry('+ EFIELDCOUNTER +')" type="text" class="country_origin exist" placeholder="country(s) that consume`s this food">\n\
                                              <div class="h"></div>\n\
                                             <textarea class="country_description existing" cols="54" rows="6" placeholder="Describe how this food is being consummed in the said country of origin."></textarea><br>\n\
                                             <button onclick="RemoveExistingCountryOriginandDesc('+ EFIELDCOUNTER +')" type="button" class="plusCountry_desc">-</button><br>')
}

function RemoveExistingCountryOriginandDesc(index){
    EFIELDCOUNTER--;
    
    var $Co = document.getElementsByClassName('country_origin');
     $($Co).eq(index).remove();
     
     var $Cd = document.getElementsByClassName('country_description');
      $($Cd).eq(index).remove();
      
      var $Pcd = document.getElementsByClassName('plusCountry_desc');
      $($Pcd).eq(index).remove();
     
}

function processExistingPutFood(){
    
     $('.errMess').html("");
    if(!processAField($('#existing_food_name'))){
            $('.errMess').html("All fields must be filled");
    }else if(!processFoodOrigins()){
             $('.errMess').html("All fields must be filled");
    }else{
           var foodName =  getValue($('#existing_food_name'));
           var originAndDesc = JSON.stringify(processFoodOrigins());
           processExistingPutFoodRequest(foodName, originAndDesc);
       }
}

function processExistingPutFoodRequest(foodName, originAndDesc){
    $.ajax({
        url: JURL+"researchAdministration/processExistingPutFoodRequest",
        type: "POST",
        dataType: "json",
        data: {foodName: foodName, originAndDesc: originAndDesc},
        success: function(data){
            if(data === true){
                $('.errMess').html("Data has been uploaded");
                $('#food_name').val(EMPTY);
                $('.country_origin').val(EMPTY);
                $('.country_description').val(EMPTY);
            }
        }
    });
}


function searchFood(){
  
    var $countryInput = document.getElementById('existing_food_name');
    $('#searchResHolder').remove();
   
      $('.h').append("<div id='searchResHolder'></div>");
      $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "90px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchResHolder').html(data);
    });
}

function collectValuBaseFood(food){
    var $baseFoodInput = document.getElementById('existing_food_name');
    $($baseFoodInput).val(food);
     $('#searchResHolder').remove();
 
}


function searchConfirmedFood(){
    var $countryInput = document.getElementById('search_confirm');
    $('#searchCFResHolder').remove();
   
      $('.ch').append("<div id='searchCFResHolder'></div>");
     // $('#searchResHolder').css({position: "absolute", left: "0px", bottom: "90px"});
        
    var search_val = $($countryInput).val();
    $.post(JURL+"researchAdministration/processBaseFoodSearch", {basefood: search_val}, function(data){
               $('#searchCFResHolder').html(data);
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
