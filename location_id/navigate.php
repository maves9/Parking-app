<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <title></title>
    <style media="screen">

    </style>

</head>
<body>

  <header>
    <a onclick="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"></i>Return</a>
  </header>

  <main class="mainGPS">
    <div id="map"></div>
    <div style="background:#fff" id="nav-panel"></div>
  </main>

<script>
//Return button
function goBack() {
    window.history.back();
}

    //split to array by ";"
    var cookie = document.cookie.split(';')
    //target the cookies
    var cookieX = cookie[0].split('=');
    var cookieY = cookie[1].split('=');
    var cookieT = cookie[2].split('=');
    //target the value of the cookie and declare data type
    var destX = Number(cookieX[1]);
    var destY =  Number(cookieY[1]);
    var title = String(cookieT[1]);

    document.title = title;

    //gps position
    navigator.geolocation.getCurrentPosition(initMap, calculateAndDisplayRoute);

    //destination position
    function initMap(position) {

      //latitude and longitude from gps
      var x =	position.coords.latitude;
      var y = position.coords.longitude;

      //calculate direction
      var directionsDisplay = new google.maps.DirectionsRenderer;
      var directionsService = new google.maps.DirectionsService;

      //make the map
      var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: {lat: x, lng: y}
      });

      //display direction panel
      directionsDisplay.setMap(map);
      directionsDisplay.setPanel(document.getElementById('nav-panel'));

      calculateAndDisplayRoute(directionsService, directionsDisplay, x, y);
    }

    function calculateAndDisplayRoute(directionsService, directionsDisplay, x, y) {

        //calculate settings
        directionsService.route({
          origin: {lat: x, lng: y},
          destination: {lat: destX, lng: destY},
          travelMode: 'DRIVING'
        },

        //response status from maps api
        function(response, status) {
          if (status === 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
      }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpKllE-UyULtzP8Q_f01yxNqnLTiQa1rs"></script>
</body>
</html>
