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

function mapSetup() {
    var myLatlng = new google.maps.LatLng(54, -4);
    var myOptions = {
      zoom: 5,
      center: myLatlng,
      navigationControlOptions: {style: google.maps.NavigationControlStyle.ZOOM_PAN},
      overviewControlOptions: { enabled: true },
      mapTypeId: google.maps.MapTypeId.TERRAIN
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
}


function populateMap(date) {
  if (typeof(date)=='undefined') {
    date = '2010-05-29';
  }
  $.getJSON('/frontend_dev.php/route.json?date=' + date, function (data) {
    $.each(data.points, function(i,point){
      addWaypoint(point);
    });
  })

}

function addWaypoint(point) {
  latLng = new google.maps.LatLng(point.latitude, point.longitude);
  if (origin == null) {
    origin = latLng;
    addMarker(origin);
  } else if (destination == null) {
    destination = latLng;
    addMarker(destination);
  } else {
    waypoints.push({ location: destination, stopover: true });
    destination = latLng;
    addMarker(destination);
  }
}

function addMarker(latlng) {
  markers.push(new google.maps.Marker({
    position: latlng,
    map: map,
    icon: "/images/blue-dot.png",
    title: "test"
  }));
}
