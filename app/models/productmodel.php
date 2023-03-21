<?php
namespace PHPMVC\Models;
class ProductModel extends AbstractModel
{
    public $CategoryId;
    public $ProductId;
    public $Name;
    public $Image;
    public $Quantity;
    public $BuyPrice;
    public $SellPrice;
    public $BarCode;
    public $Unit;
    
    protected static $PK = 'ProductId';
    protected static string $tableName = 'app_products_list';
    
    protected static $tableSchema = array(
        'CategoryId'             =>   self::DATA_TYPE_INT,
        'Name'             =>   self::DATA_TYPE_STR,
        'Image'          =>   self::DATA_TYPE_STR,
        'Quantity'             =>   self::DATA_TYPE_INT,
        'BuyPrice'          =>   self::DATA_TYPE_DECIMAL,
        'SellPrice'          =>   self::DATA_TYPE_DECIMAL,
        'BarCode'             =>   self::DATA_TYPE_STR,
        'Unit'          =>   self::DATA_TYPE_INT
    );
    
    public static function getAll()
    {
        $sql = 'select apl.*,apc.CategoryName as CategoryName from '.static::$tableName.' as apl';
        $sql.= ' inner join '.ProductCategoryModel::getModelTableName().' as apc ';
        $sql.= 'on apl.CategoryId = apc.CategoryId';
        return self::get($sql);
    }
    
}