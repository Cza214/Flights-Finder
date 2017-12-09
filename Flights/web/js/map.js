function getCoordinates(clb){
    var elementsOfPath = window.location.pathname.split('/');
    var Coordinates = [];
    $.getJSON('/../json/airports.json', function (data) {
        $.each(data, function (key, airport) {
            if(airport.code === elementsOfPath[2] || airport.code === elementsOfPath[3]){
                Coordinates.push({ 'lat': airport.lat, 'lng': airport.lon})
            }
        });
        if(typeof clb === 'function'){
            clb(Coordinates);
        }
    });
}

function initMap() {
    getCoordinates(function(Coordinates) {
        var flightPlanCoordinates = [
            {lat: Coordinates[0].lat, lng: Coordinates[0].lng},
            {lat: Coordinates[1].lat, lng: Coordinates[1].lng}
        ];

        var bound = new google.maps.LatLngBounds();

        for (var i = 0; i < flightPlanCoordinates.length; i++) {
            bound.extend(new google.maps.LatLng(flightPlanCoordinates[i].lat, flightPlanCoordinates[i].lng))
        }
        var map = new google.maps.Map(document.getElementById("flight_map"), {
            zoom: 4,
            streetViewControl: false,
            center: bound.getCenter(),
            mapTypeId: 'hybrid',
            mapTypeControl: false,
            scaleControl: false,
            draggable: false,
        });

        var markerDeparture = new google.maps.Marker({
            position: flightPlanCoordinates[0],
            map: map,
            title: 'Departure'
        });
        var markerArrival = new google.maps.Marker({
            position: flightPlanCoordinates[1],
            map: map,
            title: 'Arrival'
        });
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#00c60c',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        flightPath.setMap(map);
    });
}