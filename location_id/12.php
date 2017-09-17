<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <title></title>
  </head>
  <body>

    <header>
      <a href="../index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i>Return</a>
    </header>

    <main id="specs"></main>

    <footer>
        <a href="navigate.php">Start navigation</a>
    </footer>

<script>

var specs = document.getElementById('specs');
//AJAX call
var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "../parking_data.json", true);
    xmlhttp.overrideMimeType('charset=utf-8');
    xmlhttp.send();

    xmlhttp.onload = function() {

      //the number in the array to find the object
      var x = 12;
      //convert to JSON data
      var obj = JSON.parse(this.responseText);
      var title =	obj.features[x].properties.Vejnavn;
      var weekdays =	obj.features[x].properties.B_tidsrum_hverdage;
      var saturdays =	obj.features[x].properties.B_tidsrum_loerdage;
      //destination coordinates
      var destY =	obj.features[x].geometry.coordinates[0][0][0];
      var destX =	obj.features[x].geometry.coordinates[0][0][1];

      //headtitle = "Vejnavn"
      document.title = title;

      //store cookies to use for the map
      document.cookie = "x=" + destX;
      document.cookie = "y=" + destY;
      document.cookie = "t=" + title;

      //wirte data to the main tag
      specs.innerHTML = "<h1>" + title + "</h1><br><p>Payment period:<br> <br> Normal: " + weekdays + "<br>Saturdays: " + saturdays + "</p>";
  }


  </script>

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpKllE-UyULtzP8Q_f01yxNqnLTiQa1rs"></script>
</body>
</html>
