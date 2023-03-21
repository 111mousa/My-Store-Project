<?php
namespace PHPMVC\Models;
class SupplierModel extends AbstractModel
{
    public $SuplierId;
    public $Name;
    public $Address;
    public $PhoneNumber;
    public $Email;
    
    protected static $PK = 'SuplierId';
    protected static string $tableName = 'app_suppliers';
    
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