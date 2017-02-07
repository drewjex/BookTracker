<?php

/*
 * Main Class for Create Record Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class Create_recordPage extends View {
    
    protected $template_path = 'Templates/create-record.php';
    
    public function __construct() {

        $request_assigned_dao = new RequestsAssignedDAO();
        $record_dao = new RecordDAO();
        $change_log_dao = new ChangeLogDAO();

        if (isset($_GET['id'])) {
            $request_id = $_GET['id'];
        } else {
            $request_id = -1;
        }
        
        if (isset($_POST['new_record'])) {
            $record = array('title' => $_POST['title'],
                            'author' => $_POST['author'],
                            'edition' => $_POST['edition'],
                            'publisher' => $_POST['publisher'],
                            'isbn10' => $_POST['isbn10'],
                            'isbn13' => $_POST['isbn13'],
                            'priority_id' => $_POST['priority_id'],
                            'status_id' => $_POST['status_id'],
                            'created' => date('Y-m-d H:i:s', time()));
            if ($record_dao->add($record)) {
                $_SESSION['msg'] = "Successfully created new book record!";
            }

            if (isset($_POST['request_id']) && $_POST['request_id'] != -1) {
                $model = array('book_request_id' => $_POST['request_id'],
                               'book_record_id' => $record_dao->getLastId());
                if ($request_assigned_dao->add($model)) {
                    $_SESSION['msg'] = "Successfully assigned new book record to your book request!";
                }
                $model = array('table_name' => 'book_requests',
                                'column_name' => 'book_record',
                                'entry_id' => $_POST['request_id'],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => null,
                                'new_value' => $_POST['title']);
                $change_log_dao->add($model);

                header("Location: ?controller=page&action=request&id=".$_POST['request_id']);
                die();
            }
        }
        
        $this->assign('request_id', $request_id);
        $this->assign('priorities', (new PriorityDAO)->getAll());
        $this->assign('statuses', (new RecordStatusDAO)->getAll());
    }

    public function display() {
        
        View::getHead("Create Record | Book Tracker");
        View::getSidebar("Drew Jex");
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        View::endPage();
        
    }
    
}

?>