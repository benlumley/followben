//////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
//     
//     Name: ReadMe.txt
//     Description: Contains map display installation instructions
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

InstaMapper is a GPS tracking application available for cell phones by several manufacturers including iPhone and Blackberry. The application records your location on a server hosted by InstaMapper.com. Using the API provided by InstaMapper.com this custom web interface can plot your location, current track or any previous points. There are, however, some limitations to the API which limit the capabilities of this interface.

This custom interface requires php and MySQL.

To install this on your server:
1) Unzip the files leaving the folders intact
2) Create the instamapper MySQL table using instamapper.sql
3) Edit config.php with your information. At a minumum you must put in your InstaMapper API key and Google Maps key.
4) Upload all files except ReadMe.txt to a folder on your web server (/track)
5) Open a browser window and browse to the location you uploaded the files to (www.domain.com/track)

Valid values can be passed in the URL for start_timestamp, end_timestamp and points_to_show if the allow_inline_url value is set to "yes" in the config file. If the start_timestamp value is not set all URL values are ignored.

Ex:

http://www.domain.com/track/?start_timestamp=1230768001 (shows all points from 01/01/2009 through the end of the data table)
http://www.domain.com/track/?start_timestamp=1230768001&end_timestamp=1233446399 (shows all points from 01/01/2009-01/31/2009
http://www.domain.com/track/?start_timestamp=1230768001&points_to_show=5 (shows 5 points starting on 01/01/2009)

If you have any problems, ideas for improvements, etc please post in the forums found here: http://forums.instamapper.com/viewtopic.php?id=1492

Credit: This effort is derived from work originially done my Mike Hedman (http://forums.instamapper.com/viewtopic.php?id=1308)