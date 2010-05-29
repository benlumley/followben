<?php

/**
 * Position filter form base class.
 *
 * @package    followben
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePositionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'device_key'   => new sfWidgetFormFilterInput(),
      'device_label' => new sfWidgetFormFilterInput(),
      'timestamp'    => new sfWidgetFormFilterInput(),
      'latitude'     => new sfWidgetFormFilterInput(),
      'longitude'    => new sfWidgetFormFilterInput(),
      'altitude'     => new sfWidgetFormFilterInput(),
      'speed'        => new sfWidgetFormFilterInput(),
      'heading'      => new sfWidgetFormFilterInput(),
      'added'        => new sfWidgetFormFilterInput(),
      'created_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'deleted_at'   => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
    ));

    $this->setValidators(array(
      'device_key'   => new sfValidatorPass(array('required' => false)),
      'device_label' => new sfValidatorPass(array('required' => false)),
      'timestamp'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'latitude'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'longitude'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'altitude'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'speed'        => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'heading'      => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'added'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'deleted_at'   => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('position_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Position';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'device_key'   => 'Text',
      'device_label' => 'Text',
      'timestamp'    => 'Number',
      'latitude'     => 'Number',
      'longitude'    => 'Number',
      'altitude'     => 'Number',
      'speed'        => 'Number',
      'heading'      => 'Number',
      'added'        => 'Number',
      'created_at'   => 'Date',
      'updated_at'   => 'Date',
      'deleted_at'   => 'Date',
    );
  }
}
