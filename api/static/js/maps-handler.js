function initMap(){
    var gre = {lat: 51.4826, lng: 0.0077};
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 13,
        center: gre
    });
    var startmarker = new google.maps.Marker({
        map: map,
        title: "Start point",
        label: "A"
    });
    var endmarker = new google.maps.Marker({
        map: map,
        title: "End point",
        label: "B"
    });
    var currMarker = startmarker;
    google.maps.event.addListener(map, 'click', function(event) {
        currMarker.setPosition(event.latLng);
        if (currMarker == startmarker) {
            document.getElementById('startloc').value = event.latLng;
            currMarker = endmarker;
        }
        else {
            document.getElementById('endloc').value = event.latLng;
            currMarker = startmarker;
        }
    });
}
var map;
function initCommuteMap(){
    var gre = {lat: 51.4826, lng: 0.0077};
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: gre
    });
    httpRequest = new XMLHttpRequest();
    var data;
    if (!httpRequest) {
        alert('failed to load map');
        return false;
    }
    httpRequest.onload = setUpMaps;
    httpRequest.open('GET', 'commutedetails.php?id=' + document.getElementById('commuteId').innerText);
    httpRequest.send();
    function setUpMaps() {
        var response = JSON.parse(httpRequest.responseText);
        if (response.success) {
            var org = new google.maps.LatLng(response.data.startLat - 0, response.data.startLng - 0);
            var dest = new google.maps.LatLng(response.data.endLat - 0, response.data.endLng - 0);
            var rendererOptions = { map: map };
            var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
            var request = { origin: org, destination: dest, travelMode: google.maps.DirectionsTravelMode.DRIVING };
            var directionsService = new google.maps.DirectionsService();
            directionsService.route(request,
            function(response,status) {
                if(status == google.maps.DirectionsStatus.OK) {
                    directionsDisplay.setDirections(response);
                }
                else{
                    alert('failed to load map');
                }
            });
        }
    }
}

function initCommuteEditMap(){
    var gre = {lat: 51.4826, lng: 0.0077};
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 12,
        center: gre
    });
    httpRequest = new XMLHttpRequest();
    var data;
    if (!httpRequest) {
        alert('failed to load map');
        return false;
    }
    httpRequest.onload = setUpMaps;
    httpRequest.open('GET', 'commutedetails.php?id=' + document.getElementById('commuteId').innerText);
    httpRequest.send();
    function setUpMaps() {
        var response = JSON.parse(httpRequest.responseText);
        if (response.success) {
            var startmarker = new google.maps.Marker({
                map: map,
                position: {lat: response.data.startLat - 0, lng: response.data.startLng - 0},
                title: "Start point",
                label: "A"
            });
            var endmarker = new google.maps.Marker({
                map: map,
                position: {lat: response.data.endLat - 0, lng: response.data.endLng - 0},
                title: "End point",
                label: "B"
            });
            var currMarker = startmarker;
            google.maps.event.addListener(map, 'click', function(event) {
                currMarker.setPosition(event.latLng);
                if (currMarker == startmarker) {
                    document.getElementById('startloc').value = event.latLng;
                    currMarker = endmarker;
                }
                else {
                    document.getElementById('endloc').value = event.latLng;
                    currMarker = startmarker;
                }
            });
        }
    }
}
