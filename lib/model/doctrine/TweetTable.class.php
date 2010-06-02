<?php

class TweetTable extends Doctrine_Table {
  public static function getInstance() {
    return Doctrine_Core::getTable('Tweet');
  }

  public function getLatest($limit = 10) {
    return Doctrine_Query::create()->
      from('Tweet')->
      orderBy('id desc')->
      limit($limit)->
      execute();
  }
}