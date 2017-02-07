<?php

include_once('DAO.php');

class EmailListPersonIDsDAO extends DAO {
    
    public $tablename = 'email_list_person_ids';
    
    public function getByListId($id) {
        $sql = "SELECT * FROM `email_list_person_ids` WHERE `email_list_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>