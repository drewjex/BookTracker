<?php

include_once('DAO.php');

class EmailHistoryDAO extends DAO {
    
    public $tablename = 'email_history';

    public function getAllSorted() { 
        $sql = "SELECT * FROM `email_history` ORDER BY `id` DESC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSortedRecent() { 
        $sql = "SELECT * FROM `email_history` WHERE Year(email_history.date) > Year(CURDATE() - interval 2 year) ORDER BY `id` DESC"; 
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>