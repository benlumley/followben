<?php

//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//     
//     Name: config.php
//     Description: Contains map display configuration information
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


$version                = "1.10";                                   // Version
$map_title              = "Where Is Ben?";       // Page Title
$instamapper_api_key    = "5591835202184065782";                                      // Insert your InstaMapper API key here
$google_api_key         = "ABQIAAAAAUguE8MuC-8PIvn0Zzd8kRQ8dVouXys_kbKZZsjz1nUeriY2rxQLznqPyejISb4vmU5kbM-bfRwJ9A";                                      // Insert your Google API key here
$start_timestamp        = "";                                      // Unix timestamp - leave blank to load last point
$end_timestamp          = "";                                      // Unix timestamp
$no_data_message        = "No track data available";               // Message when no data is found
$map_width              = "850";                                   // Width of map
$map_height             = "500";                                   // Height of map
$map_zoom_control       = "GLargeMapControl3D";                    // GLargeMapControl3D, GLargeMapControl, GSmallMapControl, GSmallZoomControl3D, GSmallZoomControl
$show_map_type          = "yes";                                   // yes or no
$show_overview          = "yes";                                   // yes or no
$mouse_wheel_zoom       = "yes";                                   // yes or no
$show_map_customization = "yes";                                   // yes or no
$units                  = "imperial";                              // imperial or metric
$points_to_show         = 99999;                                       // Maximum number of points to show on map
$refresh_seconds        = 5;                                       // How often (in seconds) to refresh screen
$allow_inline_url       = "yes";                                   // Allow values to be passed in URL

$mysql_user             = "root";                                      // MySQL User Name
$mysql_password         = "";                                      // MySQL Password
$mysql_host             = "localhost";                                      // MySQL Host
$mysql_database         = "whereisben";                                      // MySQL Database
$mysql_table            = "instamapper";                           // MySQL Table
$mysql_update_time      = 1;                                       // Number of minutes to wait to update MySQL


//////////////////////////////////////////////////////////////////////////////////////
////////////////////  DO NOT MAKE ANY CHANGES BELOW THIS LINE  //////////////////////
//////////////////////////////////////////////////////////////////////////////////////

$file     = "http://www.getcis.com/track/version.php";
$contents = file($file);
$current_version = $contents[0];

$sql = array(
"user" => $mysql_user,
"pass" => $mysql_password,
"host" => $mysql_host,
"db" =>   $mysql_database
);
$link=mysql_connect($sql['host'],$sql['user'],$sql['pass']);
mysql_select_db($sql[db]);
$findlast=mysql_query("SELECT * FROM " . $mysql_table . " ORDER BY timestamp DESC LIMIT 1");
$foundlast=mysql_fetch_array($findlast);
if(time()-(60 * $mysql_update_time) > $foundlast['added'])
{
  $file = "http://www.instamapper.com/api?action=getPositions&key=" . $instamapper_api_key . "&num=1000&from_ts=" . $foundlast['timestamp'];
  $contents = file($file);
  $lines = 1;
  foreach ($contents as $line)
  {
    if($lines > 1) // Skip version information
    {
      $data = explode(",", $line);
      $device_key   = $data[0];
      $device_label = mysql_real_escape_string($data[1]);
      $timestamp    = $data[2];
      $latitude     = $data[3];
      $longitude    = $data[4];
      $altitude     = $data[5];
      $speed        = $data[6];
      $heading      = $data[7];
      if($timestamp > $foundlast['timestamp'])
      {
        $newpoint="INSERT INTO " . $mysql_table . "(id,device_key,device_label,timestamp,latitude,longitude,altitude,speed,heading,added) VALUES ('','$device_key','$device_label','$timestamp','$latitude','$longitude','$altitude','$speed','$heading'," . time() . ")";
        mysql_query($newpoint);
      }
    }
    $lines++;
  }
}
if($allow_inline_url == "yes" && isset($_GET['start_timestamp']) && $_GET['start_timestamp'] > 1230768001 && $_GET['start_timestamp'] < 32472144001)
{
  $start_timestamp = $_GET['start_timestamp'];
  $show_map_customization = "no";
  if(isset($_GET['end_timestamp']) && $_GET['end_timestamp'] > 1230768001 && $_GET['end_timestamp'] < 32472144001)
  {
    $end_timestamp = $_GET['end_timestamp'];
  }
  if(isset($_GET['points_to_show']) && $_GET['points_to_show'] > 0 && $_GET['points_to_show'] < 1001)
  {
    $points_to_show = $_GET['points_to_show'];
  }
}

if(isset($_POST['start_timestamp']))
{
  $start_timestamp = $_POST['start_timestamp'];
}
if(isset($_POST['end_timestamp']))
{
  $end_timestamp = $_POST['end_timestamp'];
}
if($start_timestamp == "")
{
  $findfirst=mysql_query("SELECT * FROM " . $mysql_table . " ORDER BY timestamp DESC LIMIT " . $points_to_show);
  while($foundfirst=mysql_fetch_array($findfirst))
  {
    $start_timestamp = $foundfirst['timestamp'];
  }
  $end_timestamp   = $foundlast['timestamp'];
}
if($end_timestamp == "")
{
  $end_timestamp   = $foundlast['timestamp'];
}
if($start_timestamp > $end_timestamp)
{
  $hold_timestamp  = $end_timestamp; 
  $end_timestamp   = $start_timestamp;
  $start_timestamp = $hold_timestamp;
}

if(isset($_POST['units']))
{
  $units = $_POST['units'];
}
if(isset($_POST['width']) && $_POST['width'] > 1 && $_POST['width'] < 5000)
{
  $map_width = $_POST['width'];
}
if(isset($_POST['height']) && $_POST['height'] > 1 && $_POST['height'] < 5000)
{
  $map_height = $_POST['height'];
}
if(isset($_POST['map_zoom_control']))
{
  $map_zoom_control = $_POST['map_zoom_control'];
}
if(isset($_POST['show_map_type']))
{
  $show_map_type = $_POST['show_map_type'];
}
if(isset($_POST['show_overview']))
{
  $show_overview = $_POST['show_overview'];
}
if(isset($_POST['mouse_wheel_zoom']))
{
  $mouse_wheel_zoom = $_POST['mouse_wheel_zoom'];
}

?>