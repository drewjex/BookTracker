<?php

include_once('DAO.php');

class ChangeLogDAO extends DAO {
    
    public $tablename = 'change_log';
    
    public function getRecordsById($id) {
        $sql = "SELECT * FROM `change_log` WHERE table_name = 'book_records' AND `entry_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRequestsById($id) {
        $sql = "SELECT * FROM `change_log` WHERE table_name = 'book_requests' AND `entry_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChecklistsById($id) {
        $sql = "SELECT * FROM `change_log` WHERE table_name = 'book_request_checklist' AND `entry_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFormatsById($id) {
        $sql = "SELECT * FROM `change_log` WHERE table_name = 'book_record_formats' AND `entry_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>