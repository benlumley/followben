<?php
require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', ProjectConfiguration::getEnvironment(), false);
sfContext::createInstance($configuration)->dispatch();