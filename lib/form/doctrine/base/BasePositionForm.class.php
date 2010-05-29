<?php

/**
 * Position form base class.
 *
 * @method Position getObject() Returns the current form's model object
 *
 * @package    followben
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePositionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'device_key'   => new sfWidgetFormInputText(),
      'device_label' => new sfWidgetFormInputText(),
      'timestamp'    => new sfWidgetFormInputText(),
      'latitude'     => new sfWidgetFormInputText(),
      'longitude'    => new sfWidgetFormInputText(),
      'altitude'     => new sfWidgetFormInputText(),
      'speed'        => new sfWidgetFormInputText(),
      'heading'      => new sfWidgetFormInputText(),
      'added'        => new sfWidgetFormInputText(),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'deleted_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'device_key'   => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'device_label' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'timestamp'    => new sfValidatorInteger(array('required' => false)),
      'latitude'     => new sfValidatorNumber(array('required' => false)),
      'longitude'    => new sfValidatorNumber(array('required' => false)),
      'altitude'     => new sfValidatorNumber(array('required' => false)),
      'speed'        => new sfValidatorNumber(array('required' => false)),
      'heading'      => new sfValidatorNumber(array('required' => false)),
      'added'        => new sfValidatorInteger(array('required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'deleted_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('position[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Position';
  }

}
