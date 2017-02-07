<?php

include_once('DAO.php');

class MessageDAO extends DAO {
    
    public $tablename = 'message';
    
    public function getAllMessagesWithId($id) {
        $sql = "SELECT * FROM `message` WHERE `to_admin_id`=$id OR `from_admin_id`=$id ORDER BY created DESC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getUnreadMessages($id) {
        $sql = "SELECT * FROM `message` WHERE `read`=0 AND `to_admin_id`=$id ORDER BY `created` DESC";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function markAsRead($id) {
        $sql = "UPDATE `message` SET `read`=1 WHERE `id`=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function markAllAsRead($id) {
        $sql = "UPDATE `message` SET `read`=1 WHERE `to_admin_id`=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }

    public function markAsReadBySameMessageId($id) {
        $sql = "UPDATE `message` SET `read`=1 WHERE `same_message_id`=$id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }

    public function getNextSameMessageId() {
        $sql = "SELECT MAX(same_message_id)+1 as maxSame FROM message";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch()['maxSame'];
    }
    
}

?>