/*
//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//     
//     Name: instamapper.sql
//     Description: MySQL table instructions
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
*/

CREATE TABLE `instamapper` (
  `id` int(10) NOT NULL auto_increment,
  `device_key` varchar(30) default NULL,
  `device_label` varchar(50) default NULL,
  `timestamp` int(20) default NULL,
  `latitude` double default NULL,
  `longitude` double default NULL,
  `altitude` double default '0',
  `speed` double default '0',
  `heading` double default NULL,
  `added` int(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;
