<?php
$id_area=$presensi_data_area["id_area"];
$lati=$presensi_data_area["lati"];
$longi= $presensi_data_area["longi"];
$nama= $presensi_data_area["nama_area"];
?>
<!DOCTYPE html >
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Data Area Presensi Maps </title>
    <link rel="icon" type="image/png" href="<?php echo media_url('ico/favicon.ico') ?>">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>

  <body>
    <div id="map"></div>

    <script>    
    var marker;
    function initialize() {  
        // Variabel untuk menyimpan informasi (desc)
        var infoWindow = new google.maps.InfoWindow;
        //  Variabel untuk menyimpan peta Roadmap
        var mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
        } 
        // Pembuatan petanya
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);      
        // Variabel untuk menyimpan batas kordinat
        var bounds = new google.maps.LatLngBounds();
        // Pengambilan data dari database
        <?php
            echo ("addMarker($lati, $longi, '$nama');\n");                        
        ?> 
        // Proses membuat marker 
        function addMarker(lat, lng, info) {
            var lokasi = new google.maps.LatLng(lat, lng);
            bounds.extend(lokasi);
            var marker = new google.maps.Marker({
                map: map,
                position: lokasi
            });       
            map.fitBounds(bounds);
            bindInfoWindow(marker, map, infoWindow, info);
         }        
        // Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, map, infoWindow, html) {
            google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5gQiI_uJGT4c8u781w609bbRjXFQHzRE&callback=initialize">
    </script>
  </body>
</html>