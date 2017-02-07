<?php

include_once('DAO.php');

class RequestDAO extends DAO {
    
    public $tablename = 'book_requests';

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
    
    public function getProvidedFormatIds($id) {
        $result = $this->getProvidedFormats($id);
        $ids = array();
        foreach ($result as $r) {
            $ids[] = $r['format_id'];
        }
        
        return $ids;
    }
    
    public function updateProvidedFormat($formats, $id) {
        $result = true;
        if ($this->deleteProvidedFormats($id)) {
            foreach ($formats as $f) {
                if (!$this->addProvidedFormat($id, $f)) {
                    $result = false;
                }
            }
        }
        
        return $result;
    }
    
    public function getProvidedFormats($id) {
        $sql = "SELECT format_id FROM provided_formats WHERE book_request_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function deleteProvidedFormats($id) {
        $sql = "DELETE FROM provided_formats WHERE book_request_id=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function addProvidedFormat($id, $format) {
        $sql = "INSERT INTO provided_formats (book_request_id, format_id) VALUES (:book_request_id, :format_id);";
        $stmt = Database::prepare($sql);
        $stmt->execute(array(
            "book_request_id" => $id,
            "format_id" => $format
        ));
    }

    public function getRequestByStatusId($status_id) {
        $sql = "SELECT * FROM book_requests WHERE status_id = $status_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRequestsByTitle($student_id, $title) {
        $sql = "SELECT * FROM book_requests WHERE student_id=$student_id AND title='$title'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getActiveRequestsByTitle($student_id, $title, $semester_code) { //should only look at current semester
        $sql = "SELECT * FROM book_requests WHERE student_id=$student_id AND book_list_title=".Database::quote($title)." AND semester_code=$semester_code"; //AND status_id != 31 AND status_id != 32
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getRequestsByStudentId($student_id) {
        $sql = "SELECT * FROM book_requests WHERE student_id=$student_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getBySemesterCode($semester_code) {
        if ($semester_code != "all") {
            $sql = "SELECT * FROM book_requests WHERE semester_code=$semester_code";
        } else {
            $sql = "SELECT * FROM book_requests";
        }
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRequestsBySemester($student_id, $semester_code) {
        if ($semester_code != "all") {
            $sql = "SELECT * FROM book_requests WHERE student_id=$student_id AND semester_code=$semester_code";
        } else {
            $sql = "SELECT * FROM book_requests WHERE student_id=$student_id";
        }
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSemesterName($semester_code) {
        $semester = substr($semester_code, -1);
        $year = substr($semester_code, 0, -1); 
        switch ($semester) {
            case 1:
                $semester = "Winter";
            break;
            case 2:
                $semester = "Winter Block 2";
            break;
            case 3:
                $semester = "Spring";
            break;
            case 4:
                $semester = "Summer";
            break;
            case 5:
                $semester = "Fall";
            break;
            case 6:
                $semester = "Fall Block 2";
            break;
        }

        return $semester." ".$year;
    }

    public function requestExistsInSemester($semester_code) {
        $sql = "SELECT * FROM book_requests WHERE semester_code=$semester_code";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }

    public function getNumberAtStatus($status_id, $semester_code) {
        $sql = "SELECT * FROM book_requests WHERE semester_code=$semester_code AND status_id=$status_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
}

?>