<?php
namespace PHPMVC\Models;
class UserModel extends AbstractModel
{
    public $UserName;
    public $UserId;
    public $Password;
    public $Email;
    public $PhoneNumber;
    public $SubscribtionDate;
    public $LastLogin;
    public $GroupId;
    public $Status;
    public $Profile;
    public $privileges;



    protected static $PK = 'UserId';
    protected static string $tableName = 'app_users';
    
    protected static $tableSchema = array(
        'UserName'            =>self::DATA_TYPE_STR,
        'UserId'              =>self::DATA_TYPE_INT,
        'Password'            =>self::DATA_TYPE_STR,
        'Email'               =>self::DATA_TYPE_STR,
        'PhoneNumber'         =>self::DATA_TYPE_STR,
        'SubscribtionDate'    =>self::DATA_TYPE_STR,
        'LastLogin'           => self::DATA_TYPE_STR,
        'GroupId'             => self::DATA_TYPE_INT,
        'Status'              => self::DATA_TYPE_INT

    );
    
    public function getName(): string {
        return $this->UserName;
    }

    public function getId(): int {
        return $this->UserId;
    }

    public function getPassword(): string {
        return $this->Password;
    }

    public function getEmail(): string {
        return $this->Email;
    }
    
    public function setPassword($password): void {
        $this->Password = $password;
    }

    public function setEmail($email): void {
        $this->Email = $email;
    }

    public function setName(string $name): void {
        $this->UserName = $name;
    }

    public function setId(int $id): void {
        $this->UserId = $id;
    }

    public function __get($prop) {
        return $this->$prop;
    }
    public function getSubscribtionDate(): \DateTime {
        return $this->SubscribtionDate;
    }

    public function getLastLogin() {
        return $this->LastLogin;
    }

    public function getGroupId() {
        return $this->GroupId;
    }

    public function setSubscribtionDate(\DateTime $subscribtionDate): void {
        $this->SubscribtionDate = $subscribtionDate;
    }

    public function setLastLogin($lastLogin): void {
        $this->LastLogin = $lastLogin;
    }

    public function setGroupId($groupId): void {
        $this->GroupId = $groupId;
    }
    
    public function cryptPassword($password)
    {
        $this->Password = crypt($password, APP_SALT);
    }
    
    public static function getUsers(UserModel $user)
    {
        return self::get(
                'select au.*,aug.GroupName from '.static::$tableName.' as au inner join app_users_groups '
                . 'as aug on au.GroupId = aug.GroupId where au.UserId != '.$user->UserId
        );
    }
    
    public static function userExist($username)
    {
        return self::getBy(['UserName'=>$username]);
    }
    
    public static function deleteUserProfile($id)
    {
        return self::get(
                'delete from app_users_profiles where UserId = '.$id
        );
    }

    public static function authenticate($userName,$password,$session)
    {
        $password = crypt($password,APP_SALT);
        $sql = 'select *,(select GroupName from app_users_groups where app_users_groups.GroupId = '.static::$tableName.'.GroupId)GroupName from '.self::$tableName.' where UserName = '."'$userName'".' and Password = '."'$password'";
        $foundUser = self::getOne($sql);
        if($foundUser !== false){
            if($foundUser->Status === 2){
                return 2;
            }
            $foundUser->lastLogin = date('Y-m-d H:i:s');
            $foundUser->save();
            $foundUser->Profile = UserProfileModel::getByPK($foundUser->UserId);
            $foundUser->Privileges = UserGroupPrivilegeModel::getPrivilegesForGroup($foundUser->GroupId);
            $session->user = $foundUser;
            return 1;
        }
        return false;
    }
    
 
}