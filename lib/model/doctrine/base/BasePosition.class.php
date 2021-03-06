<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Position', 'doctrine');

/**
 * BasePosition
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $device_key
 * @property string $device_label
 * @property integer $timestamp
 * @property float $latitude
 * @property float $longitude
 * @property float $altitude
 * @property float $speed
 * @property float $heading
 * @property integer $added
 * 
 * @method integer  getId()           Returns the current record's "id" value
 * @method string   getDeviceKey()    Returns the current record's "device_key" value
 * @method string   getDeviceLabel()  Returns the current record's "device_label" value
 * @method integer  getTimestamp()    Returns the current record's "timestamp" value
 * @method float    getLatitude()     Returns the current record's "latitude" value
 * @method float    getLongitude()    Returns the current record's "longitude" value
 * @method float    getAltitude()     Returns the current record's "altitude" value
 * @method float    getSpeed()        Returns the current record's "speed" value
 * @method float    getHeading()      Returns the current record's "heading" value
 * @method integer  getAdded()        Returns the current record's "added" value
 * @method Position setId()           Sets the current record's "id" value
 * @method Position setDeviceKey()    Sets the current record's "device_key" value
 * @method Position setDeviceLabel()  Sets the current record's "device_label" value
 * @method Position setTimestamp()    Sets the current record's "timestamp" value
 * @method Position setLatitude()     Sets the current record's "latitude" value
 * @method Position setLongitude()    Sets the current record's "longitude" value
 * @method Position setAltitude()     Sets the current record's "altitude" value
 * @method Position setSpeed()        Sets the current record's "speed" value
 * @method Position setHeading()      Sets the current record's "heading" value
 * @method Position setAdded()        Sets the current record's "added" value
 * 
 * @package    followben
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePosition extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('position');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('device_key', 'string', 30, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 30,
             ));
        $this->hasColumn('device_label', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 50,
             ));
        $this->hasColumn('timestamp', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
        $this->hasColumn('latitude', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('longitude', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('altitude', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('speed', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('heading', 'float', null, array(
             'type' => 'float',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => '',
             ));
        $this->hasColumn('added', 'integer', 4, array(
             'type' => 'integer',
             'fixed' => 0,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             'length' => 4,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}