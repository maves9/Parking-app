<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Handispot</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link href="css/font-awesome.min.css" rel="stylesheet">
	 <link href="css/animate.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>

	<header id="frontHeader">
			<a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>Home</a>
	</header>

	<img id="logo" src="./img/logo.svg">

	<main id="main-index">
			<button id="btn" class="animated jackInTheBox">Quick search</button>
			<article class="box animated zoomIn">
					<p>Radius in km</p>
					<img src="./img/left-arrow.png" id="down" onclick="modify_qty(-1)">
					<input id="qty" value="5" max="100" />
					<img src="./img/right-arrow.png" id="up" onclick="modify_qty(1)">
			</article>

	<div id="loading" class="loader"></div>

	<ul id="list"></ul>

	</main>

	<footer>
			<a href="search.php" class="animated zoomIn">Normal Search</a>
	</footer>

<!-- geolocation calculator (haversine formular) -->
<script src="js/haversine.js"></script>
<!-- get list items -->
<script type="text/javascript">
//radius-btn function
var searchRadius = 5;

function modify_qty(val) {
    var qty = document.getElementById('qty').value;
    var new_qty = parseInt(qty) + val;

    if (new_qty < 0) {
        new_qty = 0;
    }

    document.getElementById('qty').value = new_qty;
    return searchRadius = new_qty;
}


//variables are made
var fHeader = document.getElementById("frontHeader");
var logo = document.getElementById("logo");
var btn = document.getElementById("btn");
var ul = document.getElementById('list');

	btn.onclick = function(){
		document.getElementById('loading').style.display = "flex";
		fHeader.style.display = "block";
		logo.style.display = "none";
		ul.style.display = "block";
		btn.style.display = "none";
		document.getElementsByClassName('box')[0].style.display = "none";
		//finds your position
		navigator.geolocation.getCurrentPosition(map, showError);
		//in case of error
		function showError(error) {
			switch(error.code) {
				case error.PERMISSION_DENIED:
					ul.innerHTML = "<li>Your browser denied the request for Geolocation please return</li>"
				break;

				case error.POSITION_UNAVAILABLE:
					ul.innerHTML = "<li>Location information is unavailable.</li>"
				break;

				case error.TIMEOUT:
					ul.innerHTML = "<li>The request to get user location timed out.</li>"
				break;

				case error.UNKNOWN_ERROR:
					ul.innerHTML = "<li>An unknown error occurred.</li>"
				break;
			}
		}

function map(position){
	var obj,
	    xmlhttp,
	    i,
			ii;

	xmlhttp = new XMLHttpRequest();
	xmlhttp.open("GET", "parking_data.json", true);
	xmlhttp.send();

	xmlhttp.onload = function() {

		if (this.readyState == 4 && this.status == 200) {
			obj = JSON.parse(this.responseText);
			console.log(obj);
			//var features = obj.features;
			var features = obj.features;
			var dbList = [];

			for (i in features) {


				var street = features[i].properties.Vejnavn;

				var destX =	features[i].geometry.coordinates[0][0][0];
				var destY =	features[i].geometry.coordinates[0][0][1];

				var x =	position.coords.latitude;
				var	y = position.coords.longitude;

						//haversine coords to calculate
				const start = {
						latitude: x,
						longitude: y
				}

				const end = {
					latitude: destY,
					longitude: destX
				}

				//results
				var distanceDisplay = Math.floor(haversine(start, end) * 10) / 10;
				var distanceBetween = haversine(start, end);
				var avaidableSpots = distanceBetween <= searchRadius;

				//console.log(getSorted(dbList, features));

				if (avaidableSpots) {
					var href = '"location_id/' + [i] + '.php"';
						ul.innerHTML += `<li>` + "<a href=" + href + ">" + `${street} <br><small>` + distanceDisplay + " km. away</small></a> </li>";
						}
				}

				document.getElementById('loading').style.display = "none";

				if(!ul.children[0]){
					ul.innerHTML = "<li>No results found</li>";
				}
			}
		}

	}

}

</script>
</body>
</html>
