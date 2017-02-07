<?php

include_once('DAO.php');

class AdminDAO extends DAO {
    
    public $tablename = 'admin';
    
    public function getId() {
        return $_SESSION['admin_id'];
    }
    
    public function getByPersonId($person_id) {
        $sql = "SELECT * FROM admin WHERE person_id='".$person_id."'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getNetId() {
        $sql = "SELECT * FROM admin WHERE id='".$_SESSION['admin_id']."'";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        $person_id = $stmt->fetch()['person_id'];
        return BYULINK::getNetID($person_id, 'PERSON_ID');
    }
    
    public function getActiveAdministrator() {
        $sql = "SELECT * FROM admin WHERE active=1 AND role_id=1";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getActiveABC() {
        $sql = "SELECT * FROM admin WHERE active=1 AND (role_id=1 OR role_id=2) ORDER BY role_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getActiveEditor() {
        $sql = "SELECT * FROM admin WHERE active=1 AND role_id=2 ORDER BY role_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getActiveAll() {
        $sql = "SELECT * FROM admin WHERE active=1 ORDER BY role_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getIdByNetId($net_id) {
        $person_id = BYULINK::getPersonID($net_id);
        $sql = "SELECT * FROM admin WHERE `person_id`=$person_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['id'];
    }
    
    public function getActiveCoordinator() {
        $sql = "SELECT * FROM admin WHERE active=1 AND role_id=3";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
}

?>