<?php
namespace PHPMVC\Models;
class UserGroupPrivilegeModel extends AbstractModel
{
    public $Id;
    public $PrivilegeId;
    public $GroupId;
    
    protected static $PK = 'Id';
    protected static string $tableName = 'app_users_groups_privileges';
    
    protected static $tableSchema = array(
        'PrivilegeId'            =>self::DATA_TYPE_INT,
        'GroupId'              =>self::DATA_TYPE_INT
    );
    
    public function getThePK() {
        return Employee::$PK;
    }
    
    public static function getPrivilegesForGroup($groupId)
    {
        $sql = 'select augp.*,aup.Privilege from '.static::$tableName . ' as augp ';
        $sql.='inner join app_users_privileges as aup on augp.PrivilegeId = aup.PrivilegeId';
        $sql.=' where augp.GroupId = '.$groupId;
        $privileges = self::get($sql);
        $extractedUrls = [];
        if($privileges !== false){
            foreach ($privileges as $privilege){
                $extractedUrls[] = $privilege->Privilege;
            }
        }
        return $extractedUrls;
    }
}