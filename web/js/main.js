$(document).ready(function () {
  var today = new Date();
  var date = $('.date .from.selector').val().split('/')

  mapSetup();
  populateMap(today.getFullYear() + '-' + date[1] + '-' + date[0]);

  $('.date .from.selector').each(function() {
    $(this).datepicker({
      'dateFormat': 'dd/mm',
      'maxDate': today
    });
    $(this).change(function() {
      var date = $(this).val().split('/')
      populateMap(today.getFullYear() + '-' + date[1] + '-' + date[0]);
    });
  });

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

var waypoints = [];
var map = null;
var bounds = null;
var end_point_time = null;
var timer = null;


function mapSetup() {
    var myLatlng = new GLatLng(54, -4);
    map = new GMap2(document.getElementById("canvas"));
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
  $.getJSON('/route.json?date=' + date, function (data) {
    map.clearOverlays();
    bounds = new GLatLngBounds();
    waypoints = [];

    $.each(data.points, function(i,point){
      addWaypoint(point, i, data.points.length);
    });

    map.setZoom(map.getBoundsZoomLevel(bounds));
    map.setCenter(bounds.getCenter());
    if (waypoints.length > 0) {
      polyline = new GPolyline(waypoints);
      map.addOverlay(polyline);
    }
  });
  clearTimeout(timer);
  timer = setTimeout('populateMap(\'' + date + '\')', 300000);
}

function addWaypoint(point, i, length) {
  latlng = new GLatLng(point.latitude, point.longitude);
  bounds.extend(latlng);
  waypoints.push(latlng);

  var icon= new GIcon();

  var date = new Date(parseInt(point.timestamp) * 1000);
  var description = '<table id="description"><tr><td class="first">Time:</td><td>' + date.get12HourTime() + ':' + pad(date.getMinutes(), 2) + ' ' + date.get12HourTimeSuffix() + '</td></tr></table>';
  if(i==0) {
    icon.image = "images/red-dot.png";
    icon.iconAnchor = new GPoint(16, 32);
    icon.iconSize = new GSize(30, 30);
    icon.infoWindowAnchor = new GPoint(16, 0);
  } else if(i == length-1) {
    icon.image = "images/green-dot.png";
    icon.iconAnchor = new GPoint(16, 32);
    icon.iconSize = new GSize(30, 30);
    icon.infoWindowAnchor = new GPoint(16, 0);
  } else {
    icon.image = "images/arrowno.png";
    icon.iconAnchor = new GPoint(8, 8);
    icon.iconSize = new GSize(15, 15);
    icon.infoWindowAnchor = new GPoint(8, 0);
  }

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