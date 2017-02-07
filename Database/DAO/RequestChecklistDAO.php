<?php

include_once('DAO.php');

class RequestChecklistDAO extends DAO {
    
    public $tablename = 'book_request_checklist';
    
    public function getByBookRequestId($id) {
        $sql = "SELECT * FROM book_request_checklist WHERE book_request_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function deleteChecklist($book_request_id, $status_id) {
        $sql = "DELETE FROM book_request_checklist WHERE book_request_id=$book_request_id AND status_id=$status_id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function checkIfExists($book_request_id, $status_id) {
        $sql = "SELECT * FROM book_request_checklist WHERE book_request_id=$book_request_id AND status_id=$status_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function updateChecklist($book_request_id, $status_id) {
        $completed = date('Y-m-d H:i:s', time());
        $sql = "UPDATE book_request_checklist SET completed='$completed' WHERE book_request_id=".$book_request_id." AND status_id=".$status_id;
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function addChecklist($data) {
        //date_default_timezone_set("America/Denver");
        if ($this->checkIfExists($data[0], $data[1])) {
            $completed = date('Y-m-d H:i:s', $data[2]); //fix timezone problem
            $sql = "UPDATE book_request_checklist SET completed='$completed' WHERE book_request_id=".$data[0]." AND status_id=".$data[1];
            $stmt = Database::prepare($sql);
            return $stmt->execute();
        } else {
            $sql = "INSERT INTO book_request_checklist (book_request_id, status_id, `completed`) VALUES (:book_request_id, :status_id, :completed);";
            $stmt = Database::prepare($sql);
            return $stmt->execute(array(
                "book_request_id" => $data[0],
                "status_id" => $data[1],
                "completed" => date('Y-m-d H:i:s', strtotime($data[2]))
            ));
        }
    }
    
}

?>