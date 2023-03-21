<?php
namespace PHPMVC\Models;
class ClientModel extends AbstractModel
{
    public $ClientId;
    public $Name;
    public $Address;
    public $PhoneNumber;
    public $Email;
    
    protected static $PK = 'ClientId';
    protected static string $tableName = 'app_clients';
    
    protected static $tableSchema = array(
        'Name'             =>   self::DATA_TYPE_STR,
        'Address'          =>   self::DATA_TYPE_STR,
        'PhoneNumber'      =>   self::DATA_TYPE_STR,
        'Email'            =>   self::DATA_TYPE_STR
    );
    
    public function __get($prop) {
        return $this->$prop;
    }
    
}