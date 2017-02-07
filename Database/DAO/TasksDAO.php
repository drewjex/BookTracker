<?php

include_once('DAO.php');

class TasksDAO extends DAO {
    
    public $tablename = 'tasks';
    
    public function isDoingTask($admin_id, $book_record_id) {
        $sql = "SELECT * FROM `tasks` WHERE `admin_id`=$admin_id AND `book_record_id`=$book_record_id AND `active`=1";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getTaskByRecordId($book_record_id) {
        $sql = "SELECT * FROM `tasks` WHERE `book_record_id`=$book_record_id ORDER BY start_time ASC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getInactiveTaskByRecordId($book_record_id) {
        $sql = "SELECT * FROM `tasks` WHERE `book_record_id`=$book_record_id AND active=0 ORDER BY start_time DESC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getTotalTime($book_record_id) {
        if ($book_record_id == null)
            return gmdate("H:i:s", 0);
        $result = $this->getInactiveTaskByRecordId($book_record_id);
        $total = 0;
        foreach ($result as $key => $value) {
            $total += (strtotime($value['end_time']) - strtotime($value['start_time']));
        }
        
        return gmdate("H:i:s", $total);
    }
    
}

?>