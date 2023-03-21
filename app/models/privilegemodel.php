<?php
namespace PHPMVC\Models;
class PrivilegeModel extends AbstractModel
{
    public $PrivilegeId;
    public $Privilege;
    public $PrivilegeTitle;
    
    protected static $PK = 'PrivilegeId';
    protected static string $tableName = 'app_users_privileges';
    
    protected static $tableSchema = array(
        'PrivilegeId'            =>self::DATA_TYPE_INT,
        'Privilege'              =>self::DATA_TYPE_STR,
        'PrivilegeTitle'         =>self::DATA_TYPE_STR
    );
    public function getPrivilegeTitle() {
        return $this->PrivilegeTitle;
    }

    public function setPrivilegeTitle($privilegeTitle): void {
        $this->PrivilegeTitle = $privilegeTitle;
    }

        public function getPrivilegeId(): int {
        return $this->PrivilegeId;
    }

    public function getPrivilege(): string {
        return $this->Privilege;
    }

    public function setPrivilegeId(int $id): void {
        $this->privilegeId = $id;
    }

    public function __get($prop) {
        return $this->$prop;
    }
        public function setPrivilege($privilege): void {
        $this->Privilege = $privilege;
    }

        public function getThePK() {
        return Employee::$PK;
    }
}