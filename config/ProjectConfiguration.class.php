<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin', 'sfWebBrowserPlugin');
  }

  public function getEnvironment() {
    if (strpos ( $_SERVER ['HTTP_HOST'], 'home.benlumley.co.uk' ) || strpos (dirname(__FILE__), 'whereisben' )) {
      return 'dev';
    } else {
      return 'prod';
    }
  }




}
