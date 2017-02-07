<?php

include_once('DAO.php');

class RequestStatusDAO extends DAO {
    
    public $tablename = 'request_status';
    
    public function getByStatus($status) {
        $sql = "SELECT * FROM request_status WHERE name='$status'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
}

?>