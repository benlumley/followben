<?php

class getPositionsTask extends sfBaseTask {
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
    ));

    $this->namespace        = 'instamapper';
    $this->name             = 'get-positions';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [get-positions|INFO] task retrives instamapper data from their API.
Call it with:

  [php symfony get-positions|INFO]
EOF;

	  $this->new              = 0;
  }

  protected function execute($arguments = array(), $options = array()) {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    $web = new sfWebBrowser();

    $latest = Doctrine::getTable('Position')->createQuery('p')->limit(1)->orderBy('p.timestamp DESC')->fetchOne();

    $this->logSection($this->namespace, 'Getting latest instamapper positions');
    $instamapper = $web->get('http://www.instamapper.com/api?action=getPositions&key='.sfConfig::get('app_instamapper_api_key') .'&num=1000'.($latest instanceOf Position ? '&from_ts='.$latest->getTimestamp() : '').'&format=json');
    
    try {
      if(!$instamapper->responseIsError()) {

        $json = json_decode($instamapper->getResponseText());

        foreach ($json->positions as $gps) {
          if(!$latest instanceOf Position || $gps->timestamp <= $latest->getTimestamp()) {
            $position = new Position();

            $position->setDeviceKey($gps->device_key);
            $position->setDeviceLabel($gps->device_label);
            $position->setTimestamp($gps->timestamp);
            $position->setLatitude($gps->latitude);
            $position->setLongitude($gps->longitude);
            $position->setAltitude($gps->altitude);
            $position->setSpeed($gps->speed);
            $position->setHeading($gps->heading);

            $position->save();

            echo '.';
            $this->new++;
          }
        }

      } else {
        // Error response (eg. 404, 500, etc)
      }
    } catch (Exception $e) {
      // Adapter error (eg. Host not found)
    }

    echo "\n";
    $this->logSection($this->namespace, 'Done: '.$this->new.' added.');
  }
}
