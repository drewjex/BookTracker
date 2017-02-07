<?php

include_once('DAO.php');

class StatisticsDataDAO extends DAO {
    
    public $tablename = 'statistics_data';

    public function getByStatId($id) {
        $sql = "SELECT * FROM statistics_data WHERE statistics_id=$id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>