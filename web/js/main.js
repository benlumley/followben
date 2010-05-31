$(document).ready(function () {
  mapSetup();
  populateMap();

  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());


});

window.fbAsyncInit = function() {
FB.init({appId: 'your app id', status: true, cookie: true,
         xfbml: true});
};

var origin = null;
var destination = null;
var waypoints = [];
var markers = [];
var map = null;
var bounds = null;
var directionsService = null;
var dirDisplayOptions = {
      markerOptions: { icon: "/images/arrowno.png" }
    }


function mapSetup() {

    var myLatlng = new google.maps.LatLng(54, -4);
    var myOptions = {
      zoom: 5,
      center: myLatlng,
      navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN},
      overviewControlOptions: { enabled: true },
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    bounds = new google.maps.LatLngBounds();
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    directionsService = new google.maps.DirectionsService();
}


function populateMap(date) {
  if (typeof(date)=='undefined') {
    date = '2010-05-29';
  }
  $.getJSON('/frontend.php/route.json?date=' + date, function (data) {
    $.each(data.points, function(i,point){
      addWaypoint(point);
    });
    //map.panToBounds(bounds);
    applyRoute();
  })

}

function addWaypoint(point) {
  latLng = new google.maps.LatLng(point.latitude, point.longitude);
//  bounds.extend(latLng);

  waypoints.push({ location: latLng, stopover: true });
}

function addMarker(latlng) {
  markers.push(new google.maps.Marker({
    position: latlng,
    map: map,
    icon: "/images/arrowno.png",
    title: "test"
  }));
}


function applyRoute() {

    using_waypoints = [];
    z=0;
    for (i in waypoints) {
      if (origin == null) {
        origin = waypoints[i].location;
      } else if (using_waypoints.length < 8) {
        using_waypoints.push(waypoints[i]);
      } else {
        destination = waypoints[i].location;

        loadRoute(origin, destination, using_waypoints);

        using_waypoints = [];
        origin = destination;
        destination = null;
        return;
      }

    }

    console.log(using_waypoints);
    if (using_waypoints.length) {
      destination = using_waypoints.pop();
      destination = destination.location;
      loadRoute(origin, destination, using_waypoints);
    }


}


function loadRoute(origin, destination, waypoints) {

    var request = {
      origin: origin,
      destination: destination,
      waypoints: waypoints,
      travelMode: google.maps.DirectionsTravelMode.DRIVING,
      optimizeWaypoints: false,
      avoidHighways: false,
      avoidTolls: false
    };

    directionsService.route(request, function(response, status) {
      console.log(status);
      if (status == google.maps.DirectionsStatus.OK) {
        renderDirections(response);
      }
    });
}

function renderDirections(result) {
  var directionsRenderer = new google.maps.DirectionsRenderer(dirDisplayOptions);
  directionsRenderer.setMap(map);
  directionsRenderer.setDirections(result);
} 