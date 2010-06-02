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
   ]
}