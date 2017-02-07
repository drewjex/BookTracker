<?php

/*
 * Main Class for Record Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class RecordPage extends View {
    
    protected $template_path = 'Templates/record.php';
    
    public function __construct($id) {
        $record_dao = new RecordDAO();
        $admin_dao = new AdminDAO();
        $task_dao = new TasksDAO();
        $record = $record_dao->getById($id);
        $change_log_dao = new ChangeLogDAO();
        $request_assigned_dao = new RequestsAssignedDAO();

        if (isset($_POST['remove_record'])) {
            $associated_requests = $record_dao->getAssociatedRequests($id);
            foreach ($associated_requests as $a) {
                $request_assigned_dao->deleteByRequestId($a['book_request_id']);
            }
            $record_dao->delete($id);
            header("Location: ?controller=page&action=records");
            exit;
        } else if (isset($_POST['save_formats'])) { //not used anymore
            $record_format_dao = new RecordFormatsDAO();
            $record_format_dao->deleteByRecordId($id);
            $formats = $record_format_dao->getAll();
            for ($i=0; $i<count($formats); $i++) { 
                $format_id = $formats[$i]['id'];
                if (isset($_POST["format-".$format_id])) {
                    $record_format_dao->add(array('book_record_id' => $id,
                                                  'format_id' => $format_id));
                }
            }
        } else if (isset($_POST['update_instructions'])) {
            $record_instructions_dao = new RecordInstructionsDAO();
            $records_assigned_dao = new RecordsAssignedDAO();
            $record_texts_dao = new RecordTextsDAO();
            $current_admins = $records_assigned_dao->getAdminsAssigned($id);
            $current_admin_ids = array();
            foreach ($current_admins as $ca) {
                $current_admin_ids[] = $ca['admin_id'];
            }
            $record_instructions_dao->deleteByRecordId($id);
            $records_assigned_dao->deleteByRecordId($id);
            $record_texts_dao->deleteByRecordId($id);
            foreach ($_POST['assigned_admins'] as $a) {
                $model = array('book_record_id' => $id,
                               'admin_id' => $a);
                $records_assigned_dao->add($model);
                $message_dao = new MessageDAO();
                $to_admin_id = $a;
                $from_admin_id = $_SESSION['admin_id'];
                if (in_array($to_admin_id, $current_admin_ids)) {
                    $content = "Your record has been updated!";
                } else {
                    $content = "You have been assigned a new book record!"; 
                }
                
                $message = array('from_admin_id' => $from_admin_id,
                                 'to_admin_id' => $to_admin_id,
                                 'type' => 'record',
                                 'link_id' => $id,
                                 'content' => $content);
                                
                $message_dao->add($message);
            }
            foreach ($_POST['instructions'] as $i) {
                $model = array('book_record_id' => $id,
                               'instruction_id' => $i);
                $record_instructions_dao->add($model);
            }
            foreach ($_POST['additional_text'] as $a) {
                $model = array('book_record_id' => $id,
                               'text_id' => $a);
                $record_texts_dao->add($model);
            }
            $notes = $_POST['notes'];
            $record = $record_dao->getById($id);
            $record['notes'] = $notes;
            if ($record_dao->update($record)) {
                $_SESSION['msg'] = "Successfully updated instructions!";
            }
        } else if (isset($_POST['new_task'])) {
            $model = array('admin_id' => $_SESSION['admin_id'],
                           'book_record_id' => $record['id'],
                           'instruction_id' => 0,
                           'semester_code' => 0,
                           'chapter' => 0,
                           'start_page' => 0,
                           'end_page' => 0);
            if ($task_dao->add($model)) {
                $_SESSION['msg'] = "Successfully started a new task!";
            }
        } else if (isset($_POST['finish_task'])) {
            $task = $task_dao->getById($_POST['task_id']);
            $task['instruction_id'] = $_POST['instruction_id'];
            $task['semester_code'] = $_POST['semester_code'];
            $task['chapter'] = $_POST['chapter'];
            $task['start_page'] = $_POST['start_page'];
            $task['end_page'] = $_POST['end_page'];
            $task_dao->update($task);
        } else if (isset($_POST['remove_task'])) {
            if ($task_dao->delete($_POST['remove_task'])) {
                $_SESSION['msg'] = "Successfully deleted time log entry!";
            }
        } else if (isset($_POST['assign_request'])) {

            $request_assigned_dao->deleteByRequestId($_POST['assign_request']);

            $model = array('book_request_id' => $_POST['assign_request'],
                           'book_record_id' => $record['id']);
            if ($request_assigned_dao->add($model)) {
                $_SESSION['msg'] = "Successfully linked new Book Request!";
            }
            $model = array('table_name' => 'book_requests',
                            'column_name' => 'book_record',
                            'entry_id' => $_POST['assign_request'],
                            'changed_by' => $_SESSION['admin_id'],
                            'old_value' => null,
                            'new_value' => $record['title']);
            $change_log_dao->add($model);

        } else if (isset($_POST['remove_request'])) {

            $old_value = $record['title'];
            if ($request_assigned_dao->deleteByRequestId($_POST['remove_request'])) {
                $_SESSION['msg'] = "Successfully unlinked Book Request!";
            }
            $model = array('table_name' => 'book_requests',
                            'column_name' => 'book_record',
                            'entry_id' => $_POST['remove_request'],
                            'changed_by' => $_SESSION['admin_id'],
                            'old_value' => $old_value,
                            'new_value' => null);
            $change_log_dao->add($model);

        }

        $requests = $record_dao->getAssociatedRequests($id);
        
        $saved_formats = $record_dao->getSavedFormats($id);
        $saved_format_ids = array();
        foreach ($saved_formats as $s) {
            $saved_format_ids[] = $s['format_id'];
        }
        
        $admins = $record_dao->getAssignedEditors($id);
        $admin_ids = array();
        foreach ($admins as $a) {
            $admin_ids[] = $a['admin_id'];
        }
        
        $instructions = $record_dao->getInstructions($id);
        $instruction_ids = array();
        foreach ($instructions as $i) {
            $instruction_ids[] = $i['instruction_id'];
        }
        
        $texts = $record_dao->getTexts($id);
        $text_ids = array();
        foreach ($texts as $t) {
            $text_ids[] = $t['text_id'];
        }
        
        $is_doing_task = $task_dao->isDoingTask($_SESSION['admin_id'], $record['id']);
        $current_time = null;
        if (!empty($is_doing_task)) {
            $current_time = gmdate("H:i:s", time() - strtotime($is_doing_task['start_time']));
        }
        $tasks = $task_dao->getInactiveTaskByRecordId($record['id']);
        
        foreach ($tasks as $key => $value) {
            $tasks[$key]['admin'] = BYULINK::getNetID((new AdminDAO)->getById($value['admin_id'])['person_id'], 'PERSON_ID');
            $tasks[$key]['instruction'] = (new InstructionDAO)->getById($value['instruction_id'])['name'];
            if ($tasks[$key]['admin'] == null) {
                $tasks[$key]['admin'] = "N/A";
            } if ($tasks[$key]['instruction'] == null) {
                $tasks[$key]['instruction'] = "N/A";
            }
            $tasks[$key]['duration'] = gmdate("H:i:s", strtotime($value['end_time']) - strtotime($value['start_time']));
        }
        
        foreach ($record as $key => $value) {
            if ($value == null && $key != "notes" && $key != "file_path")
                $record[$key] = "-";
        }
        
        $admins = $admin_dao->getActiveABC();
        $logs = $change_log_dao->getRecordsById($id);
        $format_logs = $change_log_dao->getFormatsById($id);

        $this->assign('record', $record);
        $this->assign('texts', (new TextDAO)->getAll());
        $this->assign('instructions', (new InstructionDAO)->getAll());
        $this->assign('priorities', (new PriorityDAO)->getAll());
        $this->assign('statuses', (new RecordStatusDAO)->getAll());
        $this->assign('records', $record_dao->getAll());
        $this->assign('requests', $requests);
        $this->assign('admins', $admins); 
        $this->assign('saved_formats', $saved_format_ids);
        $this->assign('admin_ids', $admin_ids);
        $this->assign('instruction_ids', $instruction_ids);
        $this->assign('text_ids', $text_ids);
        $this->assign('notes', $record['notes']);
        $this->assign('is_doing_task', $is_doing_task);
        $this->assign('tasks', $tasks);
        $this->assign('current_time', $current_time);
        $this->assign('logs', $logs);
        $this->assign('format_logs', $format_logs);
    }

    public function display() {
        
        View::getHead("Record | ".$this->data['record']['title']);
        View::getStyle('Templates/request-styles.css');
        View::getSidebar("Drew Jex");
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        $this->getFile('Templates/record-scripts.php', $this->data);
        View::endPage();
        
    }
    
}

?>