<?php

include_once('DAO.php');

class RequestsAssignedDAO extends DAO {
    
    public $tablename = 'book_requests_assigned';
    
    public function getByRequestId($request_id) {
        $sql = "SELECT * FROM book_requests_assigned WHERE book_request_id=$request_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function getByRecordId($record_id) {
        $sql = "SELECT * FROM book_requests_assigned WHERE book_record_id=$record_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function updateById($id, $key, $value) {
        $sql = "UPDATE book_requests_assigned SET $key='$value' WHERE id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function deleteByRequestId($request_id) {
        $sql = "DELETE FROM book_requests_assigned WHERE book_request_id=$request_id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
}

?>