<?php

/**
 * BaseTweet
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property bigint $id
 * @property string $text
 * @property string $html
 * @property string $uri
 * @property bigint $reply_id
 * @property integer $reply_user_id
 * @property string $reply_username
 * @property float $latitude
 * @property float $longitude
 * @property string $language
 * @property string $source
 * 
 * @method bigint  getId()             Returns the current record's "id" value
 * @method string  getText()           Returns the current record's "text" value
 * @method string  getHtml()           Returns the current record's "html" value
 * @method string  getUri()            Returns the current record's "uri" value
 * @method bigint  getReplyId()        Returns the current record's "reply_id" value
 * @method integer getReplyUserId()    Returns the current record's "reply_user_id" value
 * @method string  getReplyUsername()  Returns the current record's "reply_username" value
 * @method float   getLatitude()       Returns the current record's "latitude" value
 * @method float   getLongitude()      Returns the current record's "longitude" value
 * @method string  getLanguage()       Returns the current record's "language" value
 * @method string  getSource()         Returns the current record's "source" value
 * @method Tweet   setId()             Sets the current record's "id" value
 * @method Tweet   setText()           Sets the current record's "text" value
 * @method Tweet   setHtml()           Sets the current record's "html" value
 * @method Tweet   setUri()            Sets the current record's "uri" value
 * @method Tweet   setReplyId()        Sets the current record's "reply_id" value
 * @method Tweet   setReplyUserId()    Sets the current record's "reply_user_id" value
 * @method Tweet   setReplyUsername()  Sets the current record's "reply_username" value
 * @method Tweet   setLatitude()       Sets the current record's "latitude" value
 * @method Tweet   setLongitude()      Sets the current record's "longitude" value
 * @method Tweet   setLanguage()       Sets the current record's "language" value
 * @method Tweet   setSource()         Sets the current record's "source" value
 * 
 * @package    followben
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseTweet extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('tweet');
        $this->hasColumn('id', 'bigint', null, array(
             'type' => 'bigint',
             'primary' => true,
             ));
        $this->hasColumn('text', 'string', 140, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 140,
             ));
        $this->hasColumn('html', 'string', null, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '',
             ));
        $this->hasColumn('uri', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('reply_id', 'bigint', null, array(
             'type' => 'bigint',
             ));
        $this->hasColumn('reply_user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('reply_username', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             ));
        $this->hasColumn('latitude', 'float', null, array(
             'type' => 'float',
             'length' => '',
             ));
        $this->hasColumn('longitude', 'float', null, array(
             'type' => 'float',
             'length' => '',
             ));
        $this->hasColumn('language', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 2,
             ));
        $this->hasColumn('source', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));

        $this->option('orderBy', 'id DESC');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}