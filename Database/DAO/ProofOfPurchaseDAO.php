<?php

include_once('DAO.php');

class ProofOfPurchaseDAO extends DAO {
    
    public $tablename = 'proof_of_purchase';
    
    public function checkIfExists($book_request_id) {
        $sql = "SELECT * FROM proof_of_purchase WHERE book_request_id=$book_request_id";
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return ($stmt->rowCount() > 0);
    }
    
    public function getByRequestId($book_request_id) {
        $sql = "SELECT * FROM proof_of_purchase WHERE book_request_id=".$book_request_id;
        $stmt = Database::prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function deleteByRequestId($book_request_id) {
        $checklist_dao = new RequestChecklistDAO();
        $checklist_dao->deleteChecklist($book_request_id, 3);
        $file = $this->getByRequestId($book_request_id)['pdf_url'];
        unlink($file);
        $sql = "DELETE FROM proof_of_purchase WHERE book_request_id=$book_request_id";
        $stmt = Database::prepare($sql);
        return $stmt->execute();
    }
    
    public function addPofP($book_request_id, $pdf_url) {
        if ($this->checkIfExists($book_request_id)) {
            $sql = "UPDATE proof_of_purchase SET pdf_url='$pdf_url' WHERE book_request_id=".$book_request_id;
            $stmt = Database::prepare($sql);
            return $stmt->execute();
        } else {
            $sql = "INSERT INTO proof_of_purchase (book_request_id, pdf_url) VALUES (:book_request_id, :pdf_url);";
            $stmt = Database::prepare($sql);
            return $stmt->execute(array(
                "book_request_id" => $book_request_id,
                "pdf_url" => $pdf_url
            ));
        }
    }
    
}

?>