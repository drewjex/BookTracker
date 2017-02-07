<?php

include_once('DAO.php');

class RecordFormatsDAO extends DAO {
    
    public $tablename = 'book_record_formats';
    
    public function deleteByRecordId($id) {
        $sql = "DELETE FROM `$this->tablename` WHERE book_record_id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function deleteCheck($book_record_id, $format_id) {
        $sql = "DELETE FROM `book_record_formats` WHERE book_record_id=$book_record_id AND format_id=$format_id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
}

?>