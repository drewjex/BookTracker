<?php

include_once('DAO.php');

class EmailDAO extends DAO {
    
    public $tablename = 'emails';

    public function getAutomaticEmails() {
        $sql = "SELECT * FROM emails WHERE automatic=1";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSemesterEmails() {
        $sql = "SELECT * FROM emails WHERE automatic=0";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}

?>