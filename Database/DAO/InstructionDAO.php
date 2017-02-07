<?php

include_once('DAO.php');

class InstructionDAO extends DAO {
    
    public $tablename = 'instruction';

    public function getIdByName($name) {
        $sql = "SELECT * FROM `instruction` WHERE name LIKE '$name%'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['id'];
    }
    
}

?>