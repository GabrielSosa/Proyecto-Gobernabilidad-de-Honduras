function initMap(x,y) {
        var lati = parseFloat(x);
        var longi = parseFloat(y);
        var uluru = {lat: lati, lng: longi};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 9,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }

$('#modalEdicion').on('shown.bs.modal', function () {

        var altitud = $('#x').val();
        var longitud = $('#y').val();
        initMap(altitud , longitud);
    });
