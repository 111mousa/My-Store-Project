<?php
namespace PHPMVC\Models;
class ProductCategoryModel extends AbstractModel
{
    public $CategoryId;
    public $CategoryName;
    public $CategoryImage;
    
    protected static $PK = 'CategoryId';
    protected static string $tableName = 'app_products_categories';
    
    protected static $tableSchema = array(
        'CategoryName'             =>   self::DATA_TYPE_STR,
        'CategoryImage'          =>   self::DATA_TYPE_STR
    );
    
}