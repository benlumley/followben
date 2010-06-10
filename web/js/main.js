$(document).ready(function () {

  window.fbAsyncInit = function() {
    FB.init({appId: '129755327051677', status: true, cookie: true, xfbml: true});
  };
  (function() {
    var e = document.createElement('script'); e.async = true;
    e.src = document.location.protocol +
      '//connect.facebook.net/en_US/all.js';
    document.getElementById('fb-root').appendChild(e);
  }());


  mapSetup();
  reloadMap();

  $('.date .from.selector').each(function() {
    $(this).datepicker({
      'dateFormat': 'D d M',
      'minDate': 'Thu 10 June',
      'maxDate': 'Sat 19 June',
      'altField': '#real_start_timestamp',
      'altFormat': 'dd/mm'
    });
    $(this).change(function() {
      reloadMap();
    });
  });
  $('.date .to.selector').each(function() {
    $(this).datepicker({
      'dateFormat': 'D d M',
      'minDate': 'Thu 10 June',
      'maxDate': 'Sat 19 June',
      'altField': '#real_end_timestamp',
      'altFormat': 'dd/mm'
    });
    $(this).change(function() {
      reloadMap();
    });
  });

  initTweets();


});


var waypoints = [];
var map = null;
var bounds = null;
var end_point_time = null;
var timer = null;
var nights = [];


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

function reloadMap() {
      var today = new Date();
      var date = $('#real_start_timestamp').val().split('/');
      var end_date = $('#real_end_timestamp').val().split('/');
      populateMap(today.getFullYear() + '-' + date[1] + '-' + date[0], today.getFullYear() + '-' + end_date[1] + '-' + end_date[0]);
}

function populateMap(date, end_date) {
  $.getJSON('/route.json?date=' + date + '&end_date=' + end_date, function (data) {
    map.clearOverlays();
    bounds = new GLatLngBounds();
    waypoints = [];
    nights = [];

    $.each(data.points, function(i,point){
      addWaypoint(point, i, data.points.length);
    });

    $.each(data.tweets, function(i,tweet){
      addTweet(tweet);
    });

    $.each(data.waypoints, function(i,waypoint){
      addNight(waypoint);
    });

    map.setZoom(map.getBoundsZoomLevel(bounds));
    map.setCenter(bounds.getCenter());
    if (waypoints.length > 0) {
      polyline = new GPolyline(waypoints);
      map.addOverlay(polyline);
    }
  });
  clearTimeout(timer);
  timer = setTimeout('populateMap(\'' + date + '\', \'' +  end_date + '\')', 300000);
}

function addWaypoint(point, i, length) {
  latlng = new GLatLng(point.latitude, point.longitude);
  bounds.extend(latlng);
  waypoints.push(latlng);

  var icon= new GIcon();

  var date = new Date(parseInt(point.timestamp) * 1000);
  var description = '<table id="description"><tr><td class="first">Time:</td><td>' + date.get12HourTime() + ':' + pad(date.getMinutes(), 2) + ' ' + date.get12HourTimeSuffix() + '</td></tr></table>';
  if(i == length-1) {
    icon.image = "images/cyclingsport.png";
    icon.iconAnchor = new GPoint(16, 32);
    icon.iconSize = new GSize(32, 37);
    icon.infoWindowAnchor = new GPoint(16, 0);
  } else if(i==0) {
    icon.image = "images/red-dot.png";
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

function addTweet(tweet) {
  latlng = new GLatLng(tweet.latitude, tweet.longitude);
  bounds.extend(latlng);

  var icon= new GIcon();

  icon.image = "images/ben.png";
  icon.iconAnchor = new GPoint(16, 32);
  icon.iconSize = new GSize(44, 37);
  icon.infoWindowAnchor = new GPoint(16, 0);

  icon.shadow = "";
  var marker = new GMarker(latlng, { icon:icon });
  marker.bindInfoWindowHtml(tweet.html + ' - <em>' + tweet.time + '</em>', { "maxWidth": 300  });
  map.addOverlay(marker);
}

function addNight(night) {
  latlng = new GLatLng(night.latitude, night.longitude);
  bounds.extend(latlng);

  var icon= new GIcon();

  icon.image = "images/cabin.png";
  icon.iconAnchor = new GPoint(16, 32);
  icon.iconSize = new GSize(32, 37);
  icon.infoWindowAnchor = new GPoint(16, 0);

  icon.shadow = "";
  var marker = new GMarker(latlng, { icon:icon });
  marker.bindInfoWindowHtml(night.title);
  map.addOverlay(marker);
}

var tweets;
function initTweets() {

  frame = $('ul#twitter');
  tweets = $('ul#twitter li');

  tweets.hide();

  frame.css(
    {
      "overflow":"hidden"
    }
  );
  $(tweets[0]).show();

  setTimeout('nextTweet()', 10000);
}

function nextTweet() {
  var done = false;
  tweets.each(function (i) {
    if (!done && $(this).is(':visible')) {
      done=true;
      next = i+1;
      if (typeof(tweets[next])=='undefined') {
        next = 0;
      }
      $(this).fadeOut(500, function () {$(tweets[next]).fadeIn(800)});
    }
  })
  setTimeout('nextTweet()', 10000);
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