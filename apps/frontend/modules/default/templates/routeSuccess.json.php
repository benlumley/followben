{
  "points": [
    <?php $chunks = array() ?>
    <?php foreach ($points as $point): ?>
      <?php ob_start() ?>
      {
        "latitude": <?php echo $point->getLatitude() ?>,
        "longitude": <?php echo $point->getLongitude() ?>,
        "timestamp": <?php echo $point->getTimestamp() ?>,
        "altitude": <?php echo $point->getAltitude() . PHP_EOL ?>
      }
      <?php $chunks[] = ob_get_clean() ?>
    <?php endforeach; ?>
    <?php echo implode(',' . PHP_EOL, $chunks) ?>
   ],
  "tweets": [
    <?php $chunks = array() ?>
    <?php foreach ($tweets as $tweet): ?>
      <?php ob_start() ?>
      {
        "html": "<?php echo str_replace('"', '\'', $tweet->getRawValue()->getHTMLHashtagsStripped()) ?>",
        "latitude": <?php echo $tweet->getLatitude() ?>,
        "longitude": <?php echo $tweet->getLongitude() ?>,
        "time": "<?php echo nice_time($tweet->getDateTimeObject('created_at')->format('U')) ?>"
      }
      <?php $chunks[] = ob_get_clean() ?>
    <?php endforeach; ?>
    <?php echo implode(',' . PHP_EOL, $chunks) ?>
   ],
   "waypoints": [
    <?php $chunks = array() ?>
    <?php foreach ($waypoints as $waypoint): ?>
      <?php ob_start() ?>
      {
        "latitude": <?php echo $waypoint['latitude'] ?>,
        "longitude": <?php echo $waypoint['longitude'] ?>,
        "title": "<?php echo $waypoint['title'] ?>",
        "type": "<?php echo $waypoint['type'] ?>"
      }
      <?php $chunks[] = ob_get_clean() ?>
    <?php endforeach; ?>
    <?php echo implode(',' . PHP_EOL, $chunks) ?>
   ]
}