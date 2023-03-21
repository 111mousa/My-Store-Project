<?php
namespace PHPMVC\Models;
class UserGroupModel extends AbstractModel
{
    public $GroupName;
    public $GroupId;
    
    protected static $PK = 'GroupId';
    protected static string $tableName = 'app_users_groups';
    
    protected static $tableSchema = array(
        'GroupName'            =>self::DATA_TYPE_STR,
        'GroupId'              =>self::DATA_TYPE_INT
    );
    
    public function getGroupName(): string {
        return $this->groupName;
    }

    public function getGroupId(): int {
        return $this->groupId;
    }

    public function setGroupName(string $name): void {
        $this->groupName = $name;
    }

    public function __get($prop) {
        return $this->$prop;
    }
        public function setGroupId($groupId): void {
        $this->groupId = $groupId;
    }

        public function getThePK() {
        return Employee::$PK;
    }
}