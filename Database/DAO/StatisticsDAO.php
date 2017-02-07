<?php

include_once('DAO.php');

class StatisticsDAO extends DAO {
    
    public $tablename = 'statistics';

    public function getByFilter($dates, $statuses, $semesters) {
        $sql = "SELECT * FROM statistics s LEFT JOIN statistics_data sd ON s.id = sd.statistics_id WHERE s.submitted >= '".date("Y-m-d", strtotime($dates[0]))."' AND s.submitted <= '".date("Y-m-d", strtotime($dates[1]))."'";

        $sql .= " AND (";

        foreach($statuses as $key => $value) {
            $sql .= "sd.request_status_id=".Database::quote($value)." OR ";
        }

        $sql = substr($sql, 0, -4);
        $sql .= ") AND (";

        foreach($semesters as $key => $value) {
            $sql .= "s.semester_code=".Database::quote($value)." OR ";
        }

        $sql = substr($sql, 0, -4);
        $sql .= ");";

        //return $sql;

        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllInTimeFrame($date1, $date2, $status_id, $semester) {
        $sql = "SELECT s.submitted, sd.value FROM statistics s LEFT JOIN statistics_data sd ON s.id = sd.statistics_id WHERE s.submitted >= '".date("Y-m-d", strtotime($date1))."' AND s.submitted <= '".date("Y-m-d", strtotime($date2))."' AND sd.request_status_id=$status_id AND s.semester_code = $semester;";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $return = array();
        $count = 0;
        foreach ($result as $key => $value) {
            $return[$count][] = (strtotime($value['submitted'])*1000)-(25200*1000);
            $return[$count][] = intval($value['value']);
            $count++;
        }

        return $return;
    }
    
}

?>