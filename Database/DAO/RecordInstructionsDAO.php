<?php

include_once('DAO.php');

class RecordInstructionsDAO extends DAO {
    
    public $tablename = 'book_record_instructions';
    
    public function deleteByRecordId($id) {
        $sql = "DELETE FROM `$this->tablename` WHERE book_record_id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
}

?>