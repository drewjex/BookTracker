<?php

require_once(dirname(__FILE__).'/../../../config.php');
require_once(DIR_DB.'Database.php');

class DAO {
    
    protected $tablename = null;
    
    public function __construct() {}
    
    public function getTableName() {
        return $this->tablename;
    }
    
    public function getAll() {
        $sql = "SELECT * FROM `$this->tablename`";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getById($id) {
        $sql = "SELECT * FROM `$this->tablename` WHERE id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function add($model) {
        $sql = "INSERT INTO `$this->tablename` SET ";
        $sql_fields = "";

        foreach($model as $key => $value){
            $sql_fields .= "`".$key."`=".Database::quote($value).", ";
        }

        $sql_fields = substr($sql_fields,0,-2);
        $sql .= $sql_fields;
        
        $stmt = Database::prepare($sql);
        if ($stmt->execute()) {
            $id = Database::getLastId(); 
            return $this->getById($id);  
        }
        
        return null;
    }
    
    public function update($model) {
        $sql = "UPDATE `$this->tablename` SET ";
        $sql_fields = "";

        foreach($model as $key => $value){
            $sql_fields .= "`".$key."`=".Database::quote($value).", ";
        }

        $sql_fields = substr($sql_fields,0,-2);
        $sql .= $sql_fields;
        $sql .= " WHERE id=".$model['id'];
        
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function delete($id) {
        $sql = "DELETE FROM `$this->tablename` WHERE id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }

    public function deleteAll() {
        $sql = "TRUNCATE TABLE `$this->tablename`";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function getLastId() {
        return Database::getLastId();
    }
    
}

?>