
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var infowindow;
var city;
function initialize() {
  var pyrmont = new google.maps.LatLng(53.350140, -6.266155);

  map = new google.maps.Map(document.getElementById('map-canvas'), {
    center: pyrmont,
    zoom: 15
  });
  
  $.ajax({
      type: 'GET',
      url: 'PlacesRunner.php',
      dataType: 'json',
      success: function(data){
         for(var i=0; i< data.length; i++){
              city = data[i];
              //alert(data[i]);
                var request = {
                     location: pyrmont,
                     radius: 50000,
                     type: [ "night_club", "bar", "establishment" ],
                     query: 'night club and bar in '+city
                   };
                 infowindow = new google.maps.InfoWindow();
                 var service = new google.maps.places.PlacesService(map);
                 service.textSearch(request, callback);
              
             }
      }
  });


 
}

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) 
    {
      var clubName =  results[i].name;
      var clubAddress =  results[i].formatted_address;
      var clubLogo = results[i].icon;
      $.ajax({
          type: 'POST',
          url: 'PutIntoClubBarRunner.php',
          data: {clubName:clubName, clubAddress: clubAddress, clubLogo: clubLogo, clubCity: city},
          dataType: 'json',
          success: function(){
              
          }
      });
       sleep(2000);
    }
  }
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

google.maps.event.addDomListener(window, 'load', initialize);