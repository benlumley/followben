<?php

/**
 * Day form base class.
 *
 * @method Day getObject() Returns the current form's model object
 *
 * @package    followben
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseDayForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'date'       => new sfWidgetFormInputHidden(),
      'title'      => new sfWidgetFormInputText(),
      'start_latt' => new sfWidgetFormInputText(),
      'start_long' => new sfWidgetFormInputText(),
      'end_latt'   => new sfWidgetFormInputText(),
      'end_long'   => new sfWidgetFormInputText(),
      'notes'      => new sfWidgetFormTextarea(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
      'deleted_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'date'       => new sfValidatorChoice(array('choices' => array($this->getObject()->get('date')), 'empty_value' => $this->getObject()->get('date'), 'required' => false)),
      'title'      => new sfValidatorString(array('max_length' => 100)),
      'start_latt' => new sfValidatorNumber(array('required' => false)),
      'start_long' => new sfValidatorNumber(array('required' => false)),
      'end_latt'   => new sfValidatorNumber(array('required' => false)),
      'end_long'   => new sfValidatorNumber(array('required' => false)),
      'notes'      => new sfValidatorString(array('required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
      'deleted_at' => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('day[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Day';
  }

}
