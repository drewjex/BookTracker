<?php

class Database {
    
    public static $conn;

    const hostname = "localhost";
    const dbname = "***"; 
    const username = "***";
    const password = "***";
    
    private function getDB() {

        if (!self::$conn) {
            try {
                self::$conn = new PDO("mysql:host=".self::getHost().";dbname=".self::getDBName(), self::getUsername(), self::getPassword());
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection failed";
            }
        }
        
        return self::$conn;
    }

    public static function getHost() {
        return self::hostname;
    }

    public static function getDBName() {
        return self::dbname;
    }

    public static function getUsername() {
        return self::username;
    }

    public static function getPassword() {
        return self::password;
    }
    
    public function quote($string) {
        return Database::getDB()->quote($string);
    }
    
    public function prepare($sql) {
        return Database::getDB()->prepare($sql);
    }
    
    public function query($sql) {
        return Database::getDB()->query($sql);
    }
    
    public function getLastId() {
        return Database::getDB()->lastInsertId();
    }
    
}

?>
