<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$env = ProjectConfiguration::getEnvironment();
if (!in_array($env, array('dev', 'branch'))) throw new Exception('Not Allowed');

$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', $env, true);
sfContext::createInstance($configuration)->dispatch();
