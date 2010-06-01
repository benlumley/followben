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
    var myLatlng = new GLatLng(54, -4);
    bounds = new GLatLngBounds();
    map = new GMap2(document.getElementById("map_canvas"));
    map.addControl(new GMapTypeControl());
    map.enableScrollWheelZoom();
    map.addControl(new GLargeMapControl3D());
    map.addControl(new GOverviewMapControl());
    map.addMapType(G_NORMAL_MAP);
    map.addMapType(G_PHYSICAL_MAP);
    map.setMapType(G_PHYSICAL_MAP);
    map.setCenter(myLatlng, 5);
}


function populateMap(date) {
  if (typeof(date)=='undefined') {
    date = '2010-05-29';
  }
  $.getJSON('/route.json?date=' + date, function (data) {
    $.each(data.points, function(i,point){
      addWaypoint(point);
    });

    map.panToBounds(bounds);
  })

}

function addWaypoint(point) {
  latlng = new GLatLng(point.latitude, point.longitude);
  bounds.extend(latlng);
  waypoints.push(latlng);

  var icon= new GIcon();

  var date = new Date(parseInt(point.timestamp) * 1000);
  var description = '<table id="description"><tr><td>Device Name:</td><td>' + point.device_label + '</td></tr><tr><td>Date:</td><td>' + date.getDayName() + ', ' + date.getMonthName() + ' ' + date.getDate() + ', ' + date.getFullYear() + '</td></tr><tr><td>Time:</td><td>' + date.get12HourTime() + ':' + pad(date.getMinutes(), 2) + ':' +  pad(date.getSeconds(), 2) + ' ' + date.get12HourTimeSuffix() + ' ET</td></tr><tr><td>Speed:</td><td>' + point.speed + ' MPH</td></tr><tr><td>Latitude:</td><td>' + point.latitude + '</td></tr><tr><td>Longitude:</td><td>' + point.longitude + '</td></tr><tr><td>Distance:</td><td>' + point.distance + ' miles</td></tr><tr><td>Heading:</td><td>' + point.heading + ' degrees</td></tr><tr><td>Altitude:</td><td>' + point.altitude + ' feet</td></tr></table>';

//  if(i == 0) {
//    icon.image = "images/red-dot.png";
//    icon.iconAnchor = new GPoint(16, 32);
//    icon.iconSize = new GSize(30, 30);
//    icon.infoWindowAnchor = new GPoint(16, 0);
//  } else if(i == data.points.length-1) {
//    icon.image = "images/green-dot.png";
//    icon.iconAnchor = new GPoint(16, 32);
//    icon.iconSize = new GSize(30, 30);
//    icon.infoWindowAnchor = new GPoint(16, 0);
//  } else {
    icon.image = "images/arrowno.png";
    icon.iconAnchor = new GPoint(8, 8);
    icon.iconSize = new GSize(15, 15);
    icon.infoWindowAnchor = new GPoint(8, 0);
//  }

    icon.shadow = "";
    var marker = new GMarker(latlng, { icon:icon });
    marker.bindInfoWindowHtml(description);
    map.addOverlay(marker);

}


function pad(number, length) {
  var str = '' + number;
  while (str.length < length) {
      str = '0' + str;
  }
  return str;
}

Date.prototype.getMonthName = function() {
  var m = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  return m[this.getMonth()];
}
Date.prototype.getDayName = function() {
  var d = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
  return d[this.getDay()];
}
Date.prototype.get12HourTime = function() {
  return this.getHours()>12 ? this.getHours() - 12 : this.getHours();
}
Date.prototype.get12HourTimeSuffix = function() {
  return this.getHours()>12 ? 'pm' : 'am';
}