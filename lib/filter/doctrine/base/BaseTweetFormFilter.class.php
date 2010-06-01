<?php

/**
 * Tweet filter form base class.
 *
 * @package    followben
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseTweetFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'text'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'html'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'uri'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'reply_id'       => new sfWidgetFormFilterInput(),
      'reply_user_id'  => new sfWidgetFormFilterInput(),
      'reply_username' => new sfWidgetFormFilterInput(),
      'language'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'source'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'text'           => new sfValidatorPass(array('required' => false)),
      'html'           => new sfValidatorPass(array('required' => false)),
      'uri'            => new sfValidatorPass(array('required' => false)),
      'reply_id'       => new sfValidatorPass(array('required' => false)),
      'reply_user_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'reply_username' => new sfValidatorPass(array('required' => false)),
      'language'       => new sfValidatorPass(array('required' => false)),
      'source'         => new sfValidatorPass(array('required' => false)),
      'created_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('tweet_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tweet';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Text',
      'text'           => 'Text',
      'html'           => 'Text',
      'uri'            => 'Text',
      'reply_id'       => 'Text',
      'reply_user_id'  => 'Number',
      'reply_username' => 'Text',
      'language'       => 'Text',
      'source'         => 'Text',
      'created_at'     => 'Date',
      'updated_at'     => 'Date',
    );
  }
}
