<html lang="en">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
    <header id="header-search">
        <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>Home</a>
    </header>
    <main id="main-search">
        <p>Max price pr. hour</p>
        <select name="price" id="price">
            <option value="0">0kr</option>
            <option value="10">10kr</option>
            <option value="20">20kr</option>
            <option value="30">30kr</option>
            <option value="40">40kr</option>
            <option value="50">50</option>
            <option value="all">All</option>
        </select>
        <p> Max range</p>
        <select name="range" id="range">
            <option value="1">1km</option>
            <option value="2">2km</option>
            <option value="3">3km</option>
            <option value="4">4km</option>
            <option value="5">5km</option>
            <option value="10">10km</option>
            <option value="all">All</option>
        </select>
            <input type="text" placeholder="Search location" name="location">

    </main>
    <ul id="list">

    </ul>
    <footer>
        <button id="nSearch" class="animated zoomIn">Search</button>
    </footer>


    <script type="text/javascript">

    var searchRadius = document.getElementById('range').value;
    var s = document.getElementById('main-search');
    var nSearch = document.getElementById('nSearch');

    var ul = document.getElementById('list');

      nSearch.onclick = function(){

        s.style.display = "none";
        ul.style.display = "block";

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
          function loop() {
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

               for (i in features) {

                 setTimeout(loop(), 3000 + (i * 4000));

                 }
                }
              }
            }
          }
        }



    </script>



    </body>
</html>
