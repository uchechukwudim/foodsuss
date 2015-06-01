/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

src="http://code.jquery.com/jquery-latest.js";
 
 $(document).ready(function(){
      var dd = new DropDown( $('#dd') );
     infinitScrollCountryLoader();
     //getCounties();
     $("#search").focus();
     RuncontinentDropdownList();
  
});
 
 
function index(data)
{
    $('#Finderbody').append(''+data);
}

function getCounties()
{

    $.get("http://localhost/index/getCountries", function(data){
           $('#Finderbody').append(''+data);
    }, 'json');

    return false;
}

function infinitScrollCountryLoader()
{
    var prev = 1;
    var next = 1;
    var pages = 6;
   
    $(window).scroll(function(){
                
        if($(window).scrollTop() === $(document).height() - $(window).height())
        {
            var con = $("#Finderbody .wrapper-dropdown-3 span").text();
            con = getContinent(con);
           
         
            if(prev === con)
             {
                     pages = pages + 6;
             }
             else{
                  pages = 6;
                  prev = con;
                  pages = pages + 6;
             }

             $.get("http://localhost/index/infinitScrollCountryLoader", {page: pages, continent: con}, function(data){
             
                 $("#Finderload").html('<img src="pictures/ajax-loader.gif">');
                 setTimeout(function(){
                    $("#Finderload").empty();
                    $("#Finderbody").append(""+data);
                    }, 1000);
                 
             }, 'json');
             
          
        }
    });
}

function DropDown(el) {
    this.dd = el;
    this.placeholder = this.dd.children('span');
    this.opts = this.dd.find('ul.dropdown > li');
    this.val = '';
    this.index = -1;
    this.initEvents();
}
DropDown.prototype = {
    initEvents : function() {
        var obj = this;
 
        obj.dd.on('click', function(event){
            $(this).toggleClass('active');
            return false;
        });
 
        obj.opts.on('click',function(){
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
     
    $("#dd").click(function(){
         $(this).css("active");
        return false;
         
      });
      
      //remove active class when mouse is click any other place
      $(function(){
           $(document).click(function(){
               $("#dd").removeClass("active");
           });
      });
}

function getCountriesViaContinent(continent)
{
    $.get("http://localhost/index/getCountries/"+continent+"", function(data){
         $('.loadCon').remove();
         $('#Finderbody').append(""+data);
    }, 'json');
}

function getContinent(continent){

        if(continent === "Continent")
          return "Africa";
      else
          return continent;
    }