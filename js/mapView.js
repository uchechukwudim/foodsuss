function displayMap(R,map)
{
				render_map(R,map);		
				for (var state in map) {	
				if(state.indexOf("Africa") !== -1){
    	            map[state].color = "red";
					var attr = {
							"fill": '#ffff00',
							stroke: "none",
							"stroke-width": .5,
							"stroke-linejoin": "round",	
						};
					map[state].attr(attr);
					
                                                 (function (st, state) {
						st[0].style.cursor = "pointer";
						
						st[0]
						st[0].onclick = function () {
						window.location.href = "http://localhost/php/CountryList.php?state="+ state+"";
                                             
						};
					})(map[state], state);
					}else if(state.indexOf("America") !== -1){
						map[state].color = "#66ff33";
						var attr2 = {
								"fill": '#66ff33',
								stroke: "none",
								"stroke-width": .5,
								"stroke-linejoin": "round"
							};
						map[state].attr(attr2);
						(function (stm, state) {
							stm[0].style.cursor = "pointer";
							
							
							stm[0].onclick = function () {
								window.location.href = "http://localhost/php/CountryList.php?state="+ state+"";
							};
						})(map[state], state);
					}else if(state.indexOf("NorthA") !== -1){
						map[state].color = "#339900";
						var attr3 = {
								"fill": '#339900',
								stroke: "none", 
								"stroke-width": .0,
								"stroke-linejoin": "round"
							};
						map[state].attr(attr3);
						(function (stnm, state) {
							stnm[0].style.cursor = "pointer";
							
							
							stnm[0].onclick = function () {
								alert(state);
							};
						})(map[state], state);
					
					}else if(state.indexOf("Europe") !== -1){
						map[state].color = "#339900";
						var attr3 = {
								"fill": 'red',
								stroke: "none", 
								"stroke-width": .0,
								"stroke-linejoin": "round"
							};
						map[state].attr(attr3);
						(function (stnm, state) {
							stnm[0].style.cursor = "pointer";
							
							
							stnm[0].onclick = function () {
								window.location.href = "http://localhost/php/CountryList.php?state="+ state+"";
							};
						})(map[state], state);
					
					}else if(state.indexOf("Asia") !== -1){
						map[state].color = "orange";
						var attr3 = {
								"fill": 'orange',
								stroke: "none", 
								"stroke-width": .0,
								"stroke-linejoin": "round"
							};
						map[state].attr(attr3);
						(function (stnm, state) {
							stnm[0].style.cursor = "pointer";
							
							
							stnm[0].onclick = function () {
								window.location.href = "http://localhost/php/CountryList.php?state="+ state+"";
							};
						})(map[state], state);
					
					}else{
						map[state].color = "orange";
						var attr3 = {
								"fill": '#ff33cc',
								stroke: "none", 
								"stroke-width": .0,
								"stroke-linejoin": "round"
							};
						map[state].attr(attr3);
						(function (stnm, state) {
							stnm[0].style.cursor = "pointer";
							
							
							stnm[0].onclick = function () {
								window.location.href = "http://localhost/php/CountryList.php?state="+ state+"";
							};
						})(map[state], state);
					
					}
				}; // end for
				

				function lon2x(lon) {
					var xfactor = 2.752;
					var xoffset = 473.75;
					var x = (lon * xfactor) + xoffset;
					return x;
				}
				function lat2y(lat) {
					var yfactor = -2.753;
					var yoffset = 231;
					var y = (lat * yfactor) + yoffset;
					return y;
				}
}
