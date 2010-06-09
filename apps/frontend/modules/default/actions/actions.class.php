<?php

/**
 * default actions.
 *
 * @package    followben
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->tweets = Doctrine::getTable('Tweet')->getLatestKeywords(array('le2jog', 'justgiving'), sfConfig::get('app_twitter_display'));
  }

  public function executeRoute(sfWebRequest $request) {
    if ($request->hasParameter('date')) {
      $date = strtotime($request->getParameter('date'));
    } else {
      $date = time();
    }
    if ($request->hasParameter('end_date')) {
      $end_date = strtotime($request->getParameter('end_date'));
    } else {
      $end_date = time();
    }

    $start_stamp = mktime(0,0,0, date('n', $date), date('j', $date), date('Y', $date));
    $end_stamp = mktime(23,59,0, date('n', $end_date), date('j', $end_date), date('Y', $end_date));

    $q = Doctrine::getTable('Position')->createQuery('p');
    $q->where('p.timestamp BETWEEN ? AND ?', array($start_stamp, $end_stamp));
    $q->addOrderBy('p.timestamp');
    $this->points = $q->execute();

    if ($this->points->count()==0) {
      $q = Doctrine::getTable('Position')->createQuery('p');
      $q->limit(1);
      $q->orderBy('p.timestamp DESC');
      $this->points = $q->execute();
    }

    $q = Doctrine::getTable('Tweet')->createQuery('t');
    $q->where('UNIX_TIMESTAMP(t.created_at) BETWEEN ? AND ?', array($start_stamp, $end_stamp));
    $q->andWhere('t.latitude IS NOT NULL');
    $q->andWhere('t.longitude IS NOT NULL');
    $q->addOrderBy('t.id');
    $this->tweets = $q->execute();

    $q = Doctrine::getTable('Day')->createQuery('d');
    $q->where('d.date BETWEEN ? AND ?', array( date('Y-m-d', $date),  date('Y-m-d', $end_date)));
    $q->orderBy('d.date ASC');
    $days = $q->execute();
    $this->waypoints = array();
    foreach ($days as $d) {
      if (empty($this->waypoints)) {
        $this->waypoints[] = array('latitude'=> $d->getStartLatt(), 'longitude'=>$d->getStartLong(), 'title'=>$d->getTitle() . " (Start)", 'type'=>'start');
      }
      $this->waypoints[] = array('latitude'=> $d->getEndLatt(), 'longitude'=>$d->getEndLong(), 'title'=>$d->getTitle() . " (End)", 'type'=>'end');
    }


  }
}