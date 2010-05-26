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
  
  include 'config.php';

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
  
  $html .= "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\r\n";
  $html .= "<html>\r\n";
  $html .= "  <head>\r\n";
  $html .= "    <title>" . $map_title . "</title>\r\n";
  if($show_map_customization == "no")
  {
    $html .= "    <meta http-equiv=\"refresh\" content=\"" . $refresh_seconds . "\">\r\n";
  }
  $html .= "    <link type=\"text/css\" rel=\"stylesheet\" href=\"css/stylesheet.css\">\r\n";
  $html .= "    <script type=\"text/javascript\" src=\"java/lightbox-form.js\"></script>\r\n";
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
  $html .= "          map.setMapType(G_NORMAL_MAP);\r\n";
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
      $html .= "          icon.image = \"icons/red-dot.png\";\r\n";
      $html .= "          icon.iconAnchor = new GPoint(16, 32);\r\n";
      $html .= "          icon.iconSize = new GSize(30, 30);  \r\n";
      $html .= "          icon.infoWindowAnchor = new GPoint(16, 0);\r\n";
    }
    elseif($position_number == $countpositions[0])
    {
      $html .= "          icon.image = \"icons/green-dot.png\";\r\n";
      $html .= "          icon.iconAnchor = new GPoint(16, 32);\r\n";
      $html .= "          icon.iconSize = new GSize(30, 30);  \r\n";
      $html .= "          icon.infoWindowAnchor = new GPoint(16, 0);\r\n";
    }
    else
    {
      if($foundpositions['heading'] == 0.0)
      {
        $html .= "          icon.image = \"icons/arrowno.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 23 && $foundpositions['heading'] < 68)
      {
        $html .= "          icon.image = \"icons/arrow45.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 67 && $foundpositions['heading'] < 113)
      {
        $html .= "          icon.image = \"icons/arrow90.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 112 && $foundpositions['heading'] < 158)
      {
        $html .= "          icon.image = \"icons/arrow135.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 157 && $foundpositions['heading'] < 203)
      {
        $html .= "          icon.image = \"icons/arrow180.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 202 && $foundpositions['heading'] < 248)
      {
        $html .= "          icon.image = \"icons/arrow225.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 247 && $foundpositions['heading'] < 293)
      {
        $html .= "          icon.image = \"icons/arrow270.png\";\r\n";
      }
      elseif($foundpositions['heading'] > 292 && $foundpositions['heading'] < 338)
      {
        $html .= "          icon.image = \"icons/arrow315.png\";\r\n";
      }
      else
      {
        $html .= "          icon.image = \"icons/arrow0.png\";\r\n";
      }
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
  $html .= "  </head>\r\n";
  $html .= "  <body onload=\"initialize()\" onunload=\"GUnload()\">\r\n";
  $html .= "    <center>\r\n";
  if($version != $current_version)
  {
    $map_title .= "  (<a href=\"http://forums.instamapper.com/viewtopic.php?pid=5090/\">Upgrade to v." . $current_version . "</a>)";
  }
  $html .= "    <div><h2>" . $map_title . "</h2></div>\r\n";
  if($show_map_customization == "yes")
  {
    $html .= "      <form method=\"link\" action=\"?\">\r\n";
    $html .= "        <p><INPUT type=\"button\" value=\"Customize Map\" name=\"button1\" onclick=\"openbox('Map Customization', 0)\" class=\"btn\"></p>\r\n";
    $html .= "      </form>\r\n";
  }
  $html .= "    <table id=\"main\">\r\n";
  $html .= "      <tr>\r\n";
  $html .= "        <td>\r\n";
  $html .= "          <div id=\"map_canvas\" style=\"width: " . $map_width . "px; height: " . $map_height . "px\"></div>\r\n";
  $html .= "        </td>\r\n";
  $html .= "      </tr>\r\n";
  $html .= "    </table>\r\n";
  $html .= "    GPS tracking powered by <a href=\"http://www.instamapper.com/\">InstaMapper.com</a><br>\r\n";
  $html .= "    <a href=\"http://forums.instamapper.com/viewtopic.php?pid=5090/\">Click Here</a> for the development thread\r\n";
  $html .= "    </center>\r\n";

  
  // Begin Customization Light Box
  $html .= "    <div id=\"filter\"></div>\r\n";
  $html .= "    <div id=\"box\">\r\n";
  $html .= "      <span id=\"boxtitle\"></span>\r\n";
  $html .= "      <form action=\"\" method=\"post\" target=\"_parent\">\r\n";
  $html .= "        <center>\r\n";
  $html .= "          <table>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Units:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"units\">\r\n";
  $html .= "                  <option>" . $units . "</option>\r\n";
  $html .= "                  <option>imperial</option>\r\n";
  $html .= "                  <option>metric</option>\r\n";
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Map Width:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <input type=\"text\" name=\"width\" value=\"" . $map_width . "\">\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Map Height:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <input type=\"text\" name=\"height\" value=\"" . $map_height . "\">\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Zoom Control:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"map_zoom_control\">\r\n";
  $html .= "                  <option>" . $map_zoom_control . "</option>\r\n";
  $html .= "                  <option>GLargeMapControl3D</option>\r\n";
  $html .= "                  <option>GLargeMapControl</option>\r\n";
  $html .= "                  <option>GSmallMapControl</option>\r\n";
  $html .= "                  <option>GSmallZoomControl3D</option>\r\n";
  $html .= "                  <option>GSmallZoomControl</option>\r\n";
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Show Map Type:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"show_map_type\">\r\n";
  $html .= "                  <option>" . $show_map_type . "</option>\r\n";
  $html .= "                  <option>no</option>\r\n";
  $html .= "                  <option>yes</option>\r\n";
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Show Overview:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"show_overview\">\r\n";
  $html .= "                  <option>" . $show_overview . "</option>\r\n";
  $html .= "                  <option>no</option>\r\n";
  $html .= "                  <option>yes</option>\r\n";
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Mouse Wheel Zoom:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"mouse_wheel_zoom\">\r\n";
  $html .= "                  <option>" . $mouse_wheel_zoom . "</option>\r\n";
  $html .= "                  <option>no</option>\r\n";
  $html .= "                  <option>yes</option>\r\n";
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                Start Date:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"start_timestamp\">\r\n";
  $found_valid_start_timestamp = "no";
  foreach($timestamp_array as $timestamp)
  {
    if($timestamp >= $start_timestamp && $found_valid_start_timestamp == "no")
    {
      $start_timestamp = $timestamp;
      $found_valid_start_timestamp = "yes";
    }
    if($timestamp <= $end_timestamp)
    {
      $hold_timestamp = $timestamp;
    }
  }
  $end_timestamp = $hold_timestamp;
  foreach($timestamp_array as $timestamp)
  {
    $html .= "                  <option value=\"" . $timestamp . "\""; if($timestamp == $start_timestamp){$html .= " SELECTED";} $html .= ">" . date("l, M j, Y - g:i:s a", $timestamp) . " ET</option>\r\n";
  }
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                End Date:\r\n";
  $html .= "              </td>\r\n";
  $html .= "              <td>\r\n";
  $html .= "                <select name=\"end_timestamp\">\r\n";
  foreach($timestamp_array as $timestamp)
  {
    $html .= "                  <option value=\"" . $timestamp . "\""; if($timestamp == $end_timestamp){$html .= " SELECTED";} $html .= ">" . date("l, M j, Y - g:i:s a", $timestamp) . " ET</option>\r\n";
  }
  $html .= "                </select>\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "            <tr>\r\n";
  $html .= "              <td colspan=\"2\" align=\"center\">\r\n";
  $html .= "                <input type=\"submit\" value=\"Update Map View\" class=\"btn\">\r\n";
  $html .= "                <input type=\"button\" name=\"cancel\" value=\"Cancel\" onclick=\"closebox()\" class=\"btn\">\r\n";
  $html .= "              </td>\r\n";
  $html .= "            </tr>\r\n";
  $html .= "          </table>\r\n";
  $html .= "        </center>\r\n";
  $html .= "      </form>\r\n";
  $html .= "      <form method=\"link\" action=\"?\">\r\n";
  $html .= "        <p><input type=\"submit\" value=\"Reset Map\" class=\"btn\"></p>\r\n";
  $html .= "      </form>\r\n";
  $html .= "    </div>\r\n";
  // End Customization Light Box
  
  $html .= "  </body>\r\n";
  $html .= "</html>\r\n";

  print $html;

?>