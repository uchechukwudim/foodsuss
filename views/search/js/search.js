/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */$(document).ready(function(){
    search();
 });

function search()
{
    var empty = '';
     focusInOutSearch();
     
    $('#search').keyup(function(){
        
            var search_val = $(this).val();
            var searchFor = $(this).attr('placeholder');
           
            $('#searchResult').show();
            ShowSetLoaderImage(search_val);
            $.post(""+JURL+"search", {search_value: search_val, searchFor: searchFor}, function(data){
                displayRecipeResult(search_val, data);
            });
    });
}

function displayRecipeResult(search_val, result)
{
    var empty = '';
    if(search_val === empty)
    {
        $('#searchResult').html(result);
        $('#searchResult').css({"height":"270px"});
    }
    else
    {
        $('#searchResult').css({"height":"350px", "overflow-y":"auto", "overflow-x":"hidden"});
        $('#searchResult').html(result);
    }
}

function ShowSetLoaderImage(search_val)
{
    var empty = '';
    
    if(search_val !== empty)
    {
         $('#searchResult').html('<img src="'+JURL+'pictures/general_smal_ajax-loader.gif" width="50" height="50">');
         $('#searchResult').css({"height":"70px"});
         $('#searchResult img').css({position:"relative",left:"170px", top:"10px"});
    }
    
}

function getWhatTosearchFor(which)
{
    
     $('#search').attr('placeholder', which);
     $('#search').focus();
     $('#searchResult').hide();
      
}



function focusInOutSearch()
{
     $('#search').on('focusin',function(){
         $('#searcher input').css({"background-image": "url()"});
         $('#searchResult').show();
    });
    $('#search').focusout(function(){
        $(document).click(function(event){
             var $targt = $(event.target);
            
            if( $targt.is('.RecipeSearchResult') || $targt.is('.RecipeSearchResult img') || $targt.is('.RecipeSearchResult span') ){
                $('#search').attr('placeholder', "");
            }
            else if($targt.is('input#search') || $targt.is('#searchResult') || $targt.is('#searchResult ul li') ||
                 $targt.is('#searchResult ul li img') ||$targt.is('#searchResult ul li span'))
             {
               
             }
             else
             {
                   $('#search').attr('placeholder', "");;
                  $('#searcher input').css({"background-image": "url(pictures/ENRI_SERCHER_ICON_SMALL.png)"});
                  $('#searchResult').hide();
             }
            
        });
    });
  
}