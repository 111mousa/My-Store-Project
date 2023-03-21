<?php
namespace PHPMVC\Models;
use PHPMVC\Lib\Database\DataBaseHandler;
class AbstractModel {
    const DATA_TYPE_BOOL = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR = \PDO::PARAM_STR;
    const DATA_TYPE_INT = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL = 4;
    const DATA_TYPE_DATE = 5;
    //VALID DATE RANGE IS 1000-01-01 TO 9999-12-31
    const VALIDATE_DATE_STRING = '/^[1-9][1-9][1-9][1-9]-[0-1]?[0-2]-(?:[0-2]?[1-9]|[3][0-1])$/';
    const VALIDATE_DATE_NUMERIC = '^\d{6,8}$';
    const DEFAULT_MYSQL_DATE = '1970-01-01';

    private static function buildNameParametersSQL() {
        $namedParams = '';
        foreach (static::$tableSchema as $columnName => $type) {
            $namedParams .= $columnName . '=:' . $columnName . ',';
        }
        return trim($namedParams, ',');
    }

    private function prepareValues(\PDOStatement &$stmt) {
        foreach (static::$tableSchema as $columnName => $type) {
            if ($type === 4) {
                $sanityzedValue = filter_var($this->$columnName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stmt->bindValue(":{$columnName}", $sanityzedValue);
            } else {
                $stmt->bindValue(":$columnName", $this->$columnName, $type);
            }
        }
    }

    private function create() {
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . self::buildNameParametersSQL();
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
         if($stmt->execute()) {
            $this->{static::$PK} = DatabaseHandler::factory()->lastInsertId();
            return true;
        }
        return false;
    }
    
    private function update() {
        $pk = static::$PK;
        $sql = 'UPDATE ' . static::$tableName . ' SET ' . self::buildNameParametersSQL() . ' WHERE ' . $pk . '=' .$this->$pk;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        $this->prepareValues($stmt);
        return $stmt->execute();
    }
    
    public function save($primaryKeyCheck = true) {
        if($primaryKeyCheck === false){
            return $this->create();
        }
        $pk = static::$PK;
        return $this->$pk==null?$this->create():$this->update();
    }
    
    public function delete() {
        $pk = static::$PK;
        $sql = 'DELETE FROM ' . static::$tableName .' WHERE ' . static::$PK . '=' .$this->$pk;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        return $stmt->execute();
    }
    
    public static function getAll() {
        $sql = 'SELECT * FROM ' . static::$tableName;
        $stmt = DataBaseHandler::factory()->prepare($sql);
        $stmt->execute();
        if(method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }
    
    public static function getByPK($pk) {
        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . static::$PK . '=' . $pk;
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if ($stmt->execute() === true) {
           $result = null;
           if(method_exists(get_called_class(), '__construct')) {
                $result = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
            } else {
                $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
            }
            return !empty($result) ? array_shift($result) : false;
        }
        return false;
    }
    public static function getBy($columns, $options = array())
    {
        $whereClauseColumns = array_keys($columns);
        $whereClauseValues = array_values($columns);
        $whereClause = [];
        for ( $i = 0, $ii = count($whereClauseColumns); $i < $ii; $i++ ) {
            $whereClause[] = $whereClauseColumns[$i] . ' = "' . $whereClauseValues[$i] . '"';
        }
        $whereClause = implode(' AND ', $whereClause);
        $sql = 'SELECT * FROM ' . static::$tableName . '  WHERE ' . $whereClause;
        return static::get($sql, $options);
    }

    public static function get($sql, $options = array())
    {
        $stmt = DatabaseHandler::factory()->prepare($sql);
        if (!empty($options)) {
            foreach ($options as $columnName => $type) {
                if ($type[0] == 4) {
                    $sanitizedValue = filter_var($type[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                    $stmt->bindValue(":{$columnName}", $sanitizedValue);
                } elseif ($type[0] == 5) {
                    if (!preg_match(self::VALIDATE_DATE_STRING, $type[1]) || !preg_match(self::VALIDATE_DATE_NUMERIC, $type[1])) {
                        $stmt->bindValue(":{$columnName}", self::DEFAULT_MYSQL_DATE);
                        continue;
                    }
                    $stmt->bindValue(":{$columnName}", $type[1]);
                } else {
                    $stmt->bindValue(":{$columnName}", $type[1], $type[0]);
                }
            }
        }
        $stmt->execute();
        if(method_exists(get_called_class(), '__construct')) {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::$tableSchema));
        } else {
            $results = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        }
        if ((is_array($results) && !empty($results))) {
            return new \ArrayIterator($results);
        };
        return false;
    }

    public static function getOne($sql, $options = array())
    {
        $result = static::get($sql, $options);
        return $result === false ? false : $result->current();
    }

    public static function getModelTableName()
    {
        return static::$tableName;
    }
}
