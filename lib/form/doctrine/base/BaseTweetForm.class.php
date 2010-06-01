<?php

/**
 * Tweet form base class.
 *
 * @method Tweet getObject() Returns the current form's model object
 *
 * @package    followben
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseTweetForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'text'           => new sfWidgetFormInputText(),
      'html'           => new sfWidgetFormTextarea(),
      'uri'            => new sfWidgetFormInputText(),
      'reply_id'       => new sfWidgetFormInputText(),
      'reply_user_id'  => new sfWidgetFormInputText(),
      'reply_username' => new sfWidgetFormInputText(),
      'language'       => new sfWidgetFormInputText(),
      'source'         => new sfWidgetFormInputText(),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'text'           => new sfValidatorString(array('max_length' => 140)),
      'html'           => new sfValidatorString(),
      'uri'            => new sfValidatorString(array('max_length' => 255)),
      'reply_id'       => new sfValidatorPass(array('required' => false)),
      'reply_user_id'  => new sfValidatorInteger(array('required' => false)),
      'reply_username' => new sfValidatorString(array('max_length' => 100, 'required' => false)),
      'language'       => new sfValidatorString(array('max_length' => 2)),
      'source'         => new sfValidatorString(array('max_length' => 255)),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('tweet[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Tweet';
  }

}
