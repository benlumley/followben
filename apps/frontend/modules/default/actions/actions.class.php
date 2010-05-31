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
  public function executeIndex(sfWebRequest $request)
  {

  }

  public function executeRoute(sfWebRequest $request) {

    if ($request->hasParameter('date')) {
      $date = strtotime($request->getParameter('date'));
    } else {
      $date = time();
    }


    $q = Doctrine::getTable('Position')->createQuery('p');
    $q->where('p.timestamp BETWEEN ? AND ?', array(mktime(0,0,0, date('n', $date), date('j', $date), date('Y', $date)), mktime(23,59,0, date('n'), date('j'), date('Y'))));
    $q->addOrderBy('p.timestamp');
    $this->points = $q->execute();
  }


}
