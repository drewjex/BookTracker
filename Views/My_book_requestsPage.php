<?php

/*
 * Main Class for MyBookRequests Page
 *
 * @author Drew Jex Jul 2016
 */

include_once('View.php');

class My_book_requestsPage extends View {
    
    protected $template_path = 'Templates/my-book-requests.php';
    
    public function __construct() {  

        $student_dao = new StudentDAO();

        if (isset($_GET['id']) && Session::isAdmin($_SESSION['phpCAS']['user'])) {
            $net_id = $student_dao->getById($_GET['id'])['net_id'];
            $_SESSION['phpCAS']['user'] = $net_id;
        } 

        $net_id = $_SESSION['phpCAS']['user'];
        $person_id = BYULINK::getPersonID($net_id);
        $student = $student_dao->getByPersonId($person_id);

        $request_dao = new RequestDAO();
        $pofp_dao = new ProofOfPurchaseDAO();
        $status_dao = new RequestStatusDAO();
        $checklist_dao = new RequestChecklistDAO();
        $message_dao = new MessageDAO();

        if (isset($_POST["upload_file"])) {
            
            $uploadOk = 1;

            $request_id = $_POST['request_id'];
            $target_dir = "production/Uploads/Proof_of_purchase/";

            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
            $name = pathinfo($target_file, PATHINFO_FILENAME);
            $extension = pathinfo($target_file, PATHINFO_EXTENSION);
            $increment = ''; 

            while(file_exists($target_dir . $name . $increment . '.' . $extension)) {
                $increment++;
            }

            $basename = $name . $increment . '.' . $extension;
            /*if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "pdf") {
                $uploadOk = 0;
            }*/
            if ($uploadOk != 0) {
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $basename);
                $_SESSION['msg'] = "Successfully submitted new Proof of Purchase file!";
            }

            $pofp_dao->addPofP($request_id, $target_dir . $basename);
           
            $admins = (new AdminDAO)->getActiveAdministrator();
            $same_message_id = $message_dao->getNextSameMessageId();
            foreach ($admins as $admin) {
                $to_admin_id = $admin['id'];
                $from_admin_id = -1;
                $name = BYULINK::getName($person_id, 'PERSON_ID')['preferred_first_name']." ".BYULINK::getName($person_id, 'PERSON_ID')['surname'];
                $content = "A Proof of Purchase file is ready for approval for ".$name."."; 
                
                $message = array('from_admin_id' => $from_admin_id,
                                 'to_admin_id' => $to_admin_id,
                                 'type' => 'request',
                                 'link_id' => $request_id,
                                 'same_message_id' => $same_message_id,
                                 'content' => $content);
                                
                $message_dao->add($message);
            } 
        } else if (isset($_POST['remove_pdf'])) {
            $request_id = $_POST['request_id'];
            if ($pofp_dao->deleteByRequestId($request_id)) {
                $_SESSION['msg'] = "Successfully deleted Proof of Purchase file!";
            }
        } else if (isset($_POST['request_cancel'])) {
            $request_id = $_POST['request_id'];
            $admins = (new AdminDAO)->getActiveAdministrator();
            $request = $request_dao->getById($request_id);
            $same_message_id = $message_dao->getNextSameMessageId();
            foreach ($admins as $admin) {
                $to_admin_id = $admin['id'];
                $from_admin_id = -1;
                $content = "A Cancellation Request was submitted for ".$request['title']."."; 
                
                $message = array('from_admin_id' => $from_admin_id,
                                 'to_admin_id' => $to_admin_id,
                                 'type' => 'request',
                                 'link_id' => $request_id,
                                 'same_message_id' => $same_message_id,
                                 'content' => $content);
                                
                $message_dao->add($message);
            } 

            $request['status_id'] = 31; //REQUEST STATUS
            if ($request_dao->update($request)) {
                $_SESSION['msg'] = "Cancellation request sent!";
            }
            $checklist_dao->addChecklist(array($request['id'], 31, time()));
        }

        $semesters = array();
        $requests = array();

        if ($student != null) {
            $all_requests = $request_dao->getRequestsBySemester($student['id'], 'all');

            foreach ($all_requests as $request) {
                $code = $request['semester_code'];
                $semesters[$code] = $request_dao->getSemesterName($code);
            }

            krsort($semesters);

            if (isset($_POST['update_semester']) && $_POST['semester'] != 'all') { 
                $_SESSION['update_semester'] = $_POST['update_semester'];
                $_SESSION['semester'] = $_POST['semester'];
                $semester = $_POST['semester'];
                $requests = $request_dao->getRequestsBySemester($student['id'], $semester);
                $this->fillInData($requests);
            } else if(isset($_SESSION['update_semester']) && $_SESSION['semester'] != 'all') {
                $semester = $_SESSION['semester'];
                $requests = $request_dao->getRequestsBySemester($student['id'], $semester);
                $this->fillInData($requests);
            } else {
                foreach ($semesters as $key => $value) {
                    $requests[$value] = $request_dao->getRequestsBySemester($student['id'], $key);
                    $this->fillInData($requests[$value]);
                }
            }
        } else {
            $requests = null;
        }

        //$selected_semester = (isset($_POST['semester'])) ? $_POST['semester'] : 'all';
        $selected_semester = (isset($_SESSION['semester'])) ? $_SESSION['semester'] : 'all';
        if (!isset($_POST['semester'])) {
            unset($_SESSION['update_semester']);
            unset($_SESSION['semester']);
        }

        $semesters['all'] = 'All Semesters';

        $this->assign('semesters', $semesters);
        $this->assign('requests', $requests);
        $this->assign('selected_semester', $selected_semester);
    }

    public function fillInData(&$requests) {
        foreach ($requests as $key => $value) {
            $requests[$key]['proof'] = (new RequestChecklistDAO)->checkIfExists($value['id'], 3); //REQUEST STATUS
            $requests[$key]['status'] = (new RequestStatusDAO)->getById($value['status_id'])['name'];
            $requests[$key]['posted'] = (new RequestChecklistDAO)->checkIfExists($value['id'], 27); //REQUEST STATUS
            $requests[$key]['proof_exists'] = (new ProofOfPurchaseDAO)->checkIfExists($value['id']);
            $requests[$key]['pofp_obj'] = (new ProofOfPurchaseDAO)->getByRequestId($value['id']);
        }
    }
    
    public function display() {
        
        View::getHead();
        View::getStyle("Templates/my-book-requests-styles.css");
        View::getStudentSidebar();
        View::getStudentTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getStudentFooter();
        View::getScripts();
        View::getScript("Templates/my-book-requests-scripts.js");
        View::endPage();
        
    } 
    
}

?>