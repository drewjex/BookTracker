<?php

include_once('DAO.php');

class DashletDAO extends DAO {
    
    protected $tablename = 'dashlets';
    
    public function add($model) {
        
        $dashlets = $this->getDashletsByAdminId($model['admin_id']);
        $model['order'] = $dashlets[count($dashlets)-1]['order'] + 1;
        
        $sql = "INSERT INTO `$this->tablename` SET ";
        $sql_fields = "";

        foreach($model as $key => $value){
            $sql_fields .= "`".$key."`=".Database::quote($value).", ";
        }

        $sql_fields = substr($sql_fields,0,-2);
        $sql .= $sql_fields;
        
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function getDashletsByAdminId($id) {
        $sql = "SELECT * FROM dashlets WHERE admin_id=$id ORDER BY `order` ASC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRequestResultsByFilter($type, $columns, $semester, $status) {
        $sql = "SELECT id, ";
        foreach ($columns as $c) {
            $sql .= $c.", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " FROM book_requests WHERE (semester_code="; 
        foreach ($semester as $s) {
            $sql .= $s." OR semester_code=";
        }
        $sql = substr($sql, 0, -18);     
        $sql .= ") AND (status_id=";
        foreach ($status as $s) {
            $sql .= $s." OR status_id=";
        }
        $sql = substr($sql, 0, -14);
        $sql .= ");";
        
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRecordResultsByFilter($type, $columns, $editor, $priority) {
        $sql = "SELECT br.id, ";
        foreach ($columns as $c) {
            $sql .= $c.", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " FROM book_records br LEFT JOIN book_records_assigned ra ON br.id = ra.book_record_id 
                                       LEFT JOIN admin a ON ra.admin_id = a.id 
                                       WHERE (a.id="; 
        foreach ($editor as $e) {
            $sql .= $e." OR a.id=";
        }
        $sql = substr($sql, 0, -9);     
        $sql .= ") AND (br.priority_id=";
        foreach ($priority as $p) {
            $sql .= $p." OR br.priority_id=";
        }
        $sql = substr($sql, 0, -19);
        $sql .= ") GROUP BY br.id;";
        
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getRequestSQLByFilter($type, $columns, $semester, $status) {
        $sql = "(SELECT br.id, ";
        foreach ($columns as $c) {
            $sql .= $c.", ";
        }
        $sql = substr($sql, 0, -2);
        $sql .= " FROM book_requests br LEFT JOIN request_status rs ON br.status_id = rs.id 
                                        LEFT JOIN admin a ON br.admin_id = a.id 
                                        LEFT JOIN student s ON br.student_id = s.id
                                        LEFT JOIN semester_name sn ON br.semester_code = sn.semester_code
                                        WHERE (br.semester_code="; 
        foreach ($semester as $s) {
            $sql .= $s." OR br.semester_code=";
        }
        $sql = substr($sql, 0, -21);     
        $sql .= ") AND (br.status_id=";
        foreach ($status as $s) {
            $sql .= $s." OR br.status_id=";
        }
        $sql = substr($sql, 0, -17);
        $sql .= ") GROUP BY br.id) temp";
        
        return $sql;
    }
    
    public function getRecordSQLByFilter($type, $columns, $editor, $statuses) {
        $sql = "(SELECT br.id, ";
        foreach ($columns as $c) {
            if ($c == 'p.name') {
                $sql .= $c." AS priority_name, ";
            } else if ($c == 'rs.name') {
                $sql .= $c." AS record_status_name, ";
            } else {
                $sql .= $c.", ";
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .= " FROM book_records br LEFT JOIN book_records_assigned ra ON br.id = ra.book_record_id 
                                       LEFT JOIN admin a ON ra.admin_id = a.id 
                                       LEFT JOIN record_status rs ON rs.id = br.status_id
                                       LEFT JOIN priority p ON p.id = br.priority_id
                                       WHERE (a.id="; 
        foreach ($editor as $e) {
            $sql .= $e." OR a.id=";
        }
        $sql = substr($sql, 0, -9);     
        $sql .= ") AND (br.status_id=";
        foreach ($statuses as $s) {
            $sql .= $s." OR br.status_id=";
        }
        $sql = substr($sql, 0, -17);
        $sql .= ") GROUP BY br.id) temp";
        
        return $sql;
    }
    
}

?>