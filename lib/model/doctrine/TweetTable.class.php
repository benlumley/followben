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

  public function getLatestTagged($tags = array(), $limit = 10) {
    $q = Doctrine_Query::create()->from('Tweet');
    
    if(is_array($tags)) {
      foreach($tags as $tag) {
        $q->orWhere('text LIKE ?', '%#'.$tag.'%');
      }
    } else if (!empty($tags)) {
      $q->where('text LIKE ?', '%#'.$tags.'%');
    }
    
    $q->orderBy('id desc')->limit($limit);

    return $q->execute();
  }

  public function getLatestKeywords($keywords = array(), $limit = 10) {
    $q = $this->getKeyWordsQuery($keywords);
    $q->orderBy('id desc')->limit($limit);
    return $q->execute();
  }
  public function getKeywordsQuery($keywords = array()) {
    $q = Doctrine_Query::create()->from('Tweet t');

    if(is_array($keywords)) {
      $query = array();
      foreach($keywords as $keyword) {
       $query[] = 'text LIKE \'%'.$keyword.'%\'';
      }
      $q->andWhere('(' . implode(' OR ', $query) . ')');
    } else if (!empty($keywords)) {
      $q->andwhere('text LIKE ?', '%'.$keyword.'%');
    }
    return $q;
  }

  public function getGeoTweets() {
    return Doctrine_Query::create()->from('Tweet')->
      where('latitude IS NOT NULL')->
      andWhere('longitude IS NOT NULL')->
      orderBy('id desc')->
      execute();
  }
}