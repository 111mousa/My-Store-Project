<?php
namespace PHPMVC\Models;
class EmployeeModel extends AbstractModel
{
    private $name;
    public $id;
    public $address;
    public $age;
    public $tax;
    public $salary;
    public $gender;
    public $type;
    public $os;
    public $notes;
    protected static $PK = 'id';
    protected static string $tableName = 'employees';
    
    protected static $tableSchema = array(
        'tax'                  =>self::DATA_TYPE_DECIMAL,
        'address'              =>self::DATA_TYPE_STR,
        'age'                  =>self::DATA_TYPE_INT,
        'id'                   =>self::DATA_TYPE_INT,
        'name'                 =>self::DATA_TYPE_STR,
        'salary'               =>self::DATA_TYPE_DECIMAL,
        'gender'               =>self::DATA_TYPE_STR,
        'type'               =>self::DATA_TYPE_STR,
        'os'               =>self::DATA_TYPE_STR,
        'notes'               =>self::DATA_TYPE_STR
    );
    
    public function getName(): string {
        return $this->name;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getAddress(): string {
        return $this->address;
    }

    public function getAge(): int {
        return $this->age;
    }

    public function getTax(): float {
        return $this->tax;
    }

    public function getSalary(): float {
        return $this->salary;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    public function setAge(int $age): void {
        $this->age = $age;
    }

    public function setTax(float $tax): void {
        $this->tax = $tax;
    }

    public function setSalary(float $salary): void {
        $this->salary = $salary;
    }
    public function __get($prop) {
        return $this->$prop;
    }
    public function getThePK() {
        return Employee::$PK;
    }
}