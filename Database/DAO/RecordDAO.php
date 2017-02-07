<?php

include_once('DAO.php');

class RecordDAO extends DAO {
    
    public $tablename = 'book_records';

    public function update($model) {
        $model['modified'] = date('Y-m-d H:i:s',time());
        $sql = "UPDATE `$this->tablename` SET ";
        $sql_fields = "";

        foreach($model as $key => $value){
            $sql_fields .= "`".$key."`=".Database::quote($value).", ";
        }

        $sql_fields = substr($sql_fields,0,-2);
        $sql .= $sql_fields;
        $sql .= " WHERE id=".$model['id'];
        
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }

    public function getAssociatedRequests($id) {
        $sql = "SELECT * FROM book_requests_assigned br 
                         LEFT JOIN book_requests b ON b.id = br.book_request_id
                         WHERE br.book_record_id=$id GROUP BY b.id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getSavedFormats($id) {
        $sql = "SELECT * FROM `book_record_formats` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getAssignedEditors($id) {
        $sql = "SELECT * FROM `book_records_assigned` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getInstructions($id) {
        $sql = "SELECT * FROM `book_record_instructions` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getTexts($id) {
        $sql = "SELECT * FROM `book_record_texts` WHERE `book_record_id`=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateFilePathText($from_text, $to_text) {
        $from_text = Database::quote($from_text);
        $to_text = Database::quote($to_text);
        $sql = "UPDATE book_records SET `file_path` = REPLACE(file_path, $from_text, $to_text)";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
}

?>