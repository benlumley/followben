<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />

  <link rel="stylesheet" href="css/screen.css" type="text/css" media="screen, projection" />
  <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
  <!--[if IE]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen, projection" />
  <![endif]-->
  <link rel="stylesheet" href="css/style.css" type="text/css" media="screen, projection" />
  <title>Follow Ben</title>


<?php

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//     
//     Name: index.php
//     Description: Contains map display 
//     Author: Jim Cleek (derived from work by Mike Hedman)
//     Updates and Information: http://forums.instamapper.com/viewtopic.php?pid=5090
//     
//     Version: 1.10
//     Date: 10/15/2009
//     
//     Changelog:
//     
//     1.10- Incorporated cleaned up CSS by TechRemedy
//           Added LAT LONG information to points bubble
//     1.9 - Added option to specify whether inline values are allowed
//           Added option to specify how many points to show
//           Added option for automatic screen refresh
//     1.8 - Added distance between points using haversine formulae
//           Added version checking
//     1.7 - Added inline date option for linking to specific map
//     1.6 - Fixed display of overlay configuration box
//     1.5 - Replaced customization TD with javascript overlay
//     1.4 - Added MySQL database configuration to put data from API feed in database
//           Removed all javascript calculations and replaced with php
//           Fixed end date filtering
//     1.3 - Added map customizations section
//
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
  
  include '../config/config.php';

  $timestamp_array = array();
  $findtimestamps=mysql_query("SELECT timestamp FROM " . $mysql_table . " ORDER BY timestamp");
  while($foundtimestamps=mysql_fetch_array($findtimestamps))
  {
    array_push($timestamp_array, $foundtimestamps['timestamp']);
  }
  $findminlatitude=mysql_query("SELECT * FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . " ORDER BY latitude LIMIT 1");
  $foundminlatitude=mysql_fetch_array($findminlatitude);
  $findmaxlatitude=mysql_query("SELECT * FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . " ORDER BY latitude DESC LIMIT 1");
  $foundmaxlatitude=mysql_fetch_array($findmaxlatitude);
  $findminlongitude=mysql_query("SELECT * FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . " ORDER BY longitude LIMIT 1");
  $foundminlongitude=mysql_fetch_array($findminlongitude);
  $findmaxlongitude=mysql_query("SELECT * FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . " ORDER BY longitude DESC LIMIT 1");
  $foundmaxlongitude=mysql_fetch_array($findmaxlongitude);
  

//    $html .= "    <meta http-equiv=\"refresh\" content=\"" . $refresh_seconds . "\">\r\n";
  $html .= "    <script type=\"text/javascript\" src=\"/javascript/lightbox-form.js\"></script>\r\n";
  $html .= "    <script type=\"text/javascript\" src=\"http://maps.google.com/maps?file=api&amp;v=2&amp;key=" . $google_api_key . "\"></script>\r\n";
  $html .= "    <script type=\"text/javascript\">\r\n";
  $html .= "      function initialize()\r\n";
  $html .= "      {\r\n";
  $html .= "        if (GBrowserIsCompatible())\r\n";
  $html .= "        {\r\n";
  $html .= "          var map = new GMap2(document.getElementById(\"map_canvas\"));\r\n";
  $html .= "          botLeft = new GLatLng(" . $foundminlatitude['latitude'] . ", " . $foundminlongitude['longitude'] . ");\r\n";
  $html .= "          topRight = new GLatLng(" . $foundmaxlatitude['latitude'] . ", " . $foundmaxlongitude['longitude'] . ");\r\n";
  $html .= "          bounds = new GLatLngBounds(botLeft, topRight);\r\n";
  $html .= "          map.setCenter(new GLatLng(((" . $foundmaxlatitude['latitude'] . " + " . $foundminlatitude['latitude'] . ") / 2.0),((" . $foundmaxlongitude['longitude'] . " + " . $foundminlongitude['longitude'] . ") / 2.0)),map.getBoundsZoomLevel(bounds));			\r\n";
  $html .= "          map.addControl(new " . $map_zoom_control . "());\r\n";
  if($show_map_type == "yes")
  {
    $html .= "          map.addControl(new GMapTypeControl());\r\n";
  }
  if($mouse_wheel_zoom == "yes")
  {
    $html .= "          map.enableScrollWheelZoom();\r\n";
  }
  if($show_overview == "yes")
  {
    $html .= "          map.addControl(new GOverviewMapControl());\r\n";
  }
  $html .= "          map.addMapType(G_NORMAL_MAP);\r\n";
  $html .= "          map.addMapType(G_PHYSICAL_MAP);\r\n";
  $html .= "          map.setMapType(G_PHYSICAL_MAP);\r\n";
  $html .= "\r\n";
  $html .= "\r\n";
  $html .= "          var allPoints = new Array();\r\n";
  if($points_to_show > 0)
  {
    $query_limit = " LIMIT " . $points_to_show;
  }
  else
  {
    $query_limit = "";
  }
  $countpositionsquery = mysql_query("SELECT COUNT(*) AS positionCount FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . $query_limit);
  $countpositions      = mysql_fetch_array($countpositionsquery);		// Total positions:    $countpositions[0]
  $position_number = 1;
  $findpositions=mysql_query("SELECT * FROM " . $mysql_table . " WHERE timestamp >= " . $start_timestamp . " AND timestamp <= " . $end_timestamp . " ORDER BY timestamp" . $query_limit);
  while($foundpositions=mysql_fetch_array($findpositions))
  {

    if($position_number == 1)
    {
      $hold_latitude  = $foundpositions['latitude'];
      $hold_longitude = $foundpositions['longitude'];
    }
    else
    {
      //Calculate distance - Haversine formulae
      $radius = 6378100;
      $latDist = $hold_latitude  - $foundpositions['latitude'];
      $lngDist = $hold_longitude - $foundpositions['longitude'];
      $latDistRad = deg2rad($latDist);
      $lngDistRad = deg2rad($lngDist);
      $sinLatD = sin($latDistRad);
      $sinLngD = sin($lngDistRad);
      $cosLat1 = cos(deg2rad($hold_latitude));
      $cosLat2 = cos(deg2rad($foundpositions['latitude']));
      $a = $sinLatD*$sinLatD + $cosLat1*$cosLat2*$sinLngD*$sinLngD*$sinLngD;
      if($a<0) $a = -1*$a;
      $c = 2*atan2(sqrt($a), sqrt(1-$a));
      $distance = $radius*$c;
      //Calculate distance - Haversine formulae
      $hold_latitude  = $foundpositions['latitude'];
      $hold_longitude = $foundpositions['longitude'];
    }
    
    $html .= "          var latlng = new GLatLng(" . $foundpositions['latitude'] . ", " . $foundpositions['longitude'] . ");\r\n";
    $html .= "          allPoints.push(latlng)\r\n";
    $html .= "          \r\n";
    $html .= "          var icon= new GIcon();\r\n";
    if($units == "metric")
    {
      $html .= "          var description = '<table id=description><tr><td>Device Name:</td><td>" . htmlentities($foundpositions['device_label'], ENT_QUOTES) . "</td></tr><tr><td>Date:</td><td>" . date("l, M j, Y", $foundpositions['timestamp']) . "</td></tr><tr><td>Time:</td><td>" . date("g:i:s a", $foundpositions['timestamp']) . " ET</td></tr><tr><td>Speed:</td><td>" . round($foundpositions['speed'] * 3.6, 1) . " KPH</td></tr><tr><td>Latitude:</td><td>" . $foundpositions['latitude'] . "</td></tr><tr><td>Longitude:</td><td>" . $foundpositions['longitude'] . "</td></tr><tr><td>Distance:</td><td>" . round($distance / 1000,2) . " kilometers</td></tr><tr><td>Heading:</td><td>" . $foundpositions['heading'] . " degrees</td></tr><tr><td>Altitude:</td><td>" . round($foundpositions['altitude'], 2) . " meters</td></tr></table>';\r\n";
    }
    else
    {
      $html .= "          var description = '<table id=description><tr><td>Device Name:</td><td>" . htmlentities($foundpositions['device_label'], ENT_QUOTES) . "</td></tr><tr><td>Date:</td><td>" . date("l, M j, Y", $foundpositions['timestamp']) . "</td></tr><tr><td>Time:</td><td>" . date("g:i:s a", $foundpositions['timestamp']) . " ET</td></tr><tr><td>Speed:</td><td>" . round($foundpositions['speed'] * 2.2369362920544, 1) . " MPH</td></tr><tr><td>Latitude:</td><td>" . $foundpositions['latitude'] . "</td></tr><tr><td>Longitude:</td><td>" . $foundpositions['longitude'] . "</td></tr><tr><td>Distance:</td><td>" . round($distance * .000621371192237334,2) . " miles</td></tr><tr><td>Heading:</td><td>" . $foundpositions['heading'] . " degrees</td></tr><tr><td>Altitude:</td><td>" . round($foundpositions['altitude'] * 3.2808399, 2) . " feet</td></tr></table>';\r\n";
    }
    if($position_number == 1)
    {
      $html .= "          icon.image = \"images/red-dot.png\";\r\n";
      $html .= "          icon.iconAnchor = new GPoint(16, 32);\r\n";
      $html .= "          icon.iconSize = new GSize(30, 30);  \r\n";
      $html .= "          icon.infoWindowAnchor = new GPoint(16, 0);\r\n";
    }
    elseif($position_number == $countpositions[0])
    {
      $html .= "          icon.image = \"images/green-dot.png\";\r\n";
      $html .= "          icon.iconAnchor = new GPoint(16, 32);\r\n";
      $html .= "          icon.iconSize = new GSize(30, 30);  \r\n";
      $html .= "          icon.infoWindowAnchor = new GPoint(16, 0);\r\n";
    }
    else
    {
      $html .= "          icon.image = \"images/arrowno.png\";\r\n";
      $html .= "          icon.iconAnchor = new GPoint(8, 8);\r\n";
      $html .= "          icon.iconSize = new GSize(15, 15);  \r\n";
      $html .= "          icon.infoWindowAnchor = new GPoint(8, 0);\r\n";
    }
    
    $html .= "          var line = new GPolyline(allPoints);\r\n";
    $html .= "          icon.shadow = \"\";\r\n";
    $html .= "          var marker = new GMarker(latlng, { icon:icon });\r\n";
    $html .= "          marker.bindInfoWindowHtml(description);\r\n";
    $html .= "          \r\n";
    $html .= "          map.addOverlay(marker);\r\n";
    $position_number++;
  }
  $html .= "          if (allPoints.length > 0)\r\n";
  $html .= "          {\r\n";
  $html .= "            polyline = new GPolyline(allPoints);\r\n";
  $html .= "            map.addOverlay(polyline);\r\n";
  $html .= "          }\r\n";
  $html .= "        }\r\n";
  $html .= "      }\r\n";
  $html .= "      \r\n";
  $html .= "    </script>\r\n";
  $html .= "  \r\n";

  

  print $html;

?>
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <div class="container ">
      <div>
        <h1>Follow Ben</h1>
      </div>

      <div class="span-6">
        <h4>What Am I Doing?</h4>
        <p>I am cycling from Lands End to John O'Groats in aid of Friends of Bristol Haematology and Oncology Centre</p>
        <a href= 'http://www.justgiving.com/ben-lumley' alt='JustGiving - Sponsor me!' target='_blank'> <img src='/images/justgiving.png' width='230' height='50'> </a>
      </div>
      <div class="span-6">
        <h4>What's this?</h4>
        <p>Its a map that will show.</p>
      </div>
      <div class="span-6">
        <h4>Follow Me</h4>
        <p>I am cycling from Lands End to John O'Groats in aid of the Friends of Bristol Haematology and Oncology Centre at the BRI in Bristol</p>
        <p>This map will let you keep an eye on my progress, whilst subtly convincing you to sponsor me!</p>
      </div>
      <div class="span-6 last">
        <h4>Sponsor Me</h4>
        <p>I am cycling from Lands End to John O'Groats in aid of the Friends of Bristol Haematology and Oncology Centre at the BRI in Bristol</p>
        <p>This map will let you keep an eye on my progress, whilst subtly convincing you to sponsor me!</p>
      </div>


      <div class="clear"></div>
      <div class="span-6 ">
<iframe src="http://www.facebook.com/plugins/livefeed.php?app_id=255955255198&amp;width=230&amp;height=600&amp;xid" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:230px; height:600px;" allowTransparency="true"></iframe>

      </div>
      <div id="map_canvas" class="span-18 last" style="height: 600px"></div>
      <div class="clear"></div>


<!--
      <object type="application/x-shockwave-flash" allowScriptAccess="always" height="230" width="150" align="middle" data="http://www.justgiving.com/widgets/jgwidget.swf" flashvars="EggId=2420906&IsMS=0"><param name="movie" value="http://www.justgiving.com/widgets/jgwidget.swf" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="quality" value="high" /><param name="wmode" value="transparent" /><param name="flashvars" value="EggId=2420906&IsMS=0" /></object>
-->
    </div>
  </body>
</html>

