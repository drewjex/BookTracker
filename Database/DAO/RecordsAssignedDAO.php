<?php

include_once('DAO.php');

class RecordsAssignedDAO extends DAO {
    
    public $tablename = 'book_records_assigned';
    
    public function deleteByRecordId($id) {
        $sql = "DELETE FROM `$this->tablename` WHERE book_record_id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }

    public function getAdminsAssigned($id) {
        $sql = "SELECT admin_id FROM `book_records_assigned` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getByRecordId($id) {
        $sql = "SELECT * FROM `book_records_assigned` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCurrentRecords() {
        $sql = "SELECT * FROM book_records_assigned ra 
                         LEFT JOIN book_records br ON ra.book_record_id = br.id
                         WHERE NOT br.status_id = 4";
        $stmt = Database::prepare($sql);
        $stmt->execute(); 
        return $stmt->fetchAll();
    }
    
}

?>