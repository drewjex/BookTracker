<?php

include_once('DAO.php');

class StudentDAO extends DAO {
    
    public $tablename = 'student';

    public function getAssociatedRequests($id) {
        $sql = "SELECT * FROM book_requests WHERE student_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRequestedFormatIds($id) {
        $result = $this->getRequestedFormats($id);
        $ids = array();
        foreach ($result as $r) {
            $ids[] = $r['format_id'];
        }
        
        return $ids;
    }
    
    public function updateRequestedFormat($formats, $id) {
        $result = true;
        if ($this->deleteRequestedFormats($id)) {
            foreach ($formats as $f) {
                if (!$this->addRequestedFormat($id, $f)) {
                    $result = false;
                }
            }
        }
        
        return $result;
    }

    public function updateNotes($notes, $id) {
        $sql = "UPDATE student SET notes = '$notes' WHERE id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function getRequestedFormats($id) {
        $sql = "SELECT format_id FROM requested_formats WHERE student_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function deleteRequestedFormats($id) {
        $sql = "DELETE FROM requested_formats WHERE student_id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function addRequestedFormat($id, $format) {
        $sql = "INSERT INTO requested_formats (student_id, format_id) VALUES (:student_id, :format_id);";
        $stmt = Database::prepare($sql);
        $stmt->execute(array(
            "student_id" => $id,
            "format_id" => $format
        ));
    }
    
    public function getByPersonId($id) {
        $sql = "SELECT * FROM student WHERE person_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getByNetId($id) {
        $sql = "SELECT * FROM student WHERE net_id='$id'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
}

?>