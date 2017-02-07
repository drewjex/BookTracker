<?php

include_once 'Controller.php';
require_once(dirname(__FILE__).'/../../config.php');

class CommandController implements Controller {
    
    public function execute($action) {

        switch($action) {
            case 'delete':
                $dashlet_dao = new DashletDAO();
                $dashlet_dao->delete($_POST['data']);
            break;
            case 'update_order':
                $ids = json_decode(stripslashes($_POST['data']));
                $order = 1;
                $dashlet_dao = new DashletDAO();
                foreach ($ids as $id) {
                    if ($id != null) {
                        $dashlet = $dashlet_dao->getById($id);
                        $dashlet['order'] = $order;
                        $dashlet_dao->update($dashlet);
                        $order++;
                    }
                }
            break;
            case 'add_checklist':
                $data = json_decode(stripslashes($_POST['data']));
                $checklist_dao = new RequestChecklistDAO();
                $checklist_dao->addChecklist($data);
                $changelog_dao = new ChangeLogDAO();
                $model = array('table_name' => 'book_request_checklist',
                               'column_name' => 'status_id',
                               'entry_id' => $data[0],
                               'changed_by' => $_SESSION['admin_id'],
                               'old_value' => null,
                               'new_value' => (new RequestStatusDAO)->getById($data[1])['name']);
                $changelog_dao->add($model);
            break;
            case 'delete_checklist':
                $data = json_decode(stripslashes($_POST['data']));
                $checklist_dao = new RequestChecklistDAO();
                $checklist_dao->deleteChecklist($data[0], $data[1]);
                $changelog_dao = new ChangeLogDAO();
                $model = array('table_name' => 'book_request_checklist',
                               'column_name' => 'status_id',
                               'entry_id' => $data[0],
                               'changed_by' => $_SESSION['admin_id'],
                               'old_value' => (new RequestStatusDAO)->getById($data[1])['name'],
                               'new_value' => null);
                $changelog_dao->add($model);
            break;
            case 'update_request':
                $data = json_decode($_POST['data']);
                $request_dao = new RequestDAO();
                $request = $request_dao->getById($data[0]);
                $old_value = $request[$data[1]];
                $request[$data[1]] = $data[2];
                $request_dao->update($request);
                if ($old_value != $data[2]) {
                    $changelog_dao = new ChangeLogDAO();
                    $model = array('table_name' => 'book_requests',
                                'column_name' => $data[1],
                                'entry_id' => $data[0],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => $old_value,
                                'new_value' => $data[2]);
                    $changelog_dao->add($model);
                }
            break;
            case 'assign_record':
                $data = json_decode(stripslashes($_POST['data']));
                $request_assigned_dao = new RequestsAssignedDAO();
                $model = array('book_request_id' => $data[0],
                                'book_record_id' => $data[1]);
                $request_assigned_dao->add($model);
            break;
            case 'update_request_status':
                $data = json_decode(stripslashes($_POST['data']));
                $request_dao = new RequestDAO();
                $request = $request_dao->getById($data[0]);
                $old_value = $request['status_id'];
                $request['status_id'] = $data[1];
                $request_dao->update($request);
                if ((new RequestStatusDAO)->getById($old_value)['name'] != (new RequestStatusDAO)->getById($data[1])['name']) {
                    $changelog_dao = new ChangeLogDAO();
                    $model = array('table_name' => 'book_requests',
                                'column_name' => 'status_id',
                                'entry_id' => $data[0],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => (new RequestStatusDAO)->getById($old_value)['name'],
                                'new_value' => (new RequestStatusDAO)->getById($data[1])['name']);
                    $changelog_dao->add($model);
                }
            break;
            case 'check_message':
                $message_dao = new MessageDAO();
                $message = $message_dao->getById($_POST['data']);
                $same_message_id = $message['same_message_id'];
                if ($same_message_id != null)
                    $message_dao->markAsReadBySameMessageId($same_message_id);
                $message_dao->markAsRead($_POST['data']);
            break;
            case 'update_record_status':
                $data = json_decode(stripslashes($_POST['data']));
                $record_dao = new RecordDAO();
                $record = $record_dao->getById($data[0]);
                $old_value = $record['status_id'];
                $record['status_id'] = $data[1];
                $record_dao->update($record);
                if ((new RecordStatusDAO)->getById($old_value)['name'] != (new RecordStatusDAO)->getById($data[1])['name']) {
                    $changelog_dao = new ChangeLogDAO();
                    $model = array('table_name' => 'book_records',
                                'column_name' => 'status_id',
                                'entry_id' => $data[0],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => (new RecordStatusDAO)->getById($old_value)['name'],
                                'new_value' => (new RecordStatusDAO)->getById($data[1])['name']);
                    $changelog_dao->add($model);
                }
            break;
            case 'update_record_priority':
                $data = json_decode(stripslashes($_POST['data']));
                $record_dao = new RecordDAO();
                $record = $record_dao->getById($data[0]);
                $old_value = $record['priority_id'];
                $record['priority_id'] = $data[1];
                $record_dao->update($record);
                if ((new PriorityDAO)->getById($old_value)['name'] != (new PriorityDAO)->getById($data[1])['name']) {
                    $changelog_dao = new ChangeLogDAO();
                    $model = array('table_name' => 'book_records',
                                'column_name' => 'priority_id',
                                'entry_id' => $data[0],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => (new PriorityDAO)->getById($old_value)['name'],
                                'new_value' => (new PriorityDAO)->getById($data[1])['name']);
                    $changelog_dao->add($model);
                }
            break;
            case 'update_record':
                $data = json_decode($_POST['data']);
                $record_dao = new RecordDAO();
                $record = $record_dao->getById($data[0]);
                $old_value = $record[$data[1]];
                $record[$data[1]] = $data[2];
                $record_dao->update($record);
                if ($old_value != $data[2]) {
                    $changelog_dao = new ChangeLogDAO();
                    $model = array('table_name' => 'book_records',
                                'column_name' => $data[1],
                                'entry_id' => $data[0],
                                'changed_by' => $_SESSION['admin_id'],
                                'old_value' => $old_value,
                                'new_value' => $data[2]);
                    $changelog_dao->add($model);
                }
            break;
            case 'end_task':
                $task_dao = new TasksDAO();
                $task = $task_dao->getById($_POST['data']);
                $task['end_time'] = date('Y-m-d H:i:s',time());
                $task['active'] = 0;
                $task['admin_id'] = $_SESSION['admin_id'];
                $task_dao->update($task);
            break;
            case 'update_time_log':
                $data = json_decode(stripslashes($_POST['data']));
                $task_dao = new TasksDAO();
                $task = $task_dao->getById($data[0]);
                if ($data[1] == 'admin_id') {
                    $data[2] = (new AdminDAO)->getIdByNetId($data[2]);
                } else if ($data[1] == 'instruction_id') {
                    $data[2] = (new InstructionDAO)->getIdByName($data[2]);
                } else if ($data[1] == 'start_time' || $data[1] == 'end_time') {
                    $data[2] = date('Y-m-d H:i:s', strtotime($data[2]));
                }
                $task[$data[1]] = $data[2];
                $task_dao->update($task);
            break;
            case 'update_time':
                $task_dao = new TasksDAO();
                $is_doing_task = $task_dao->isDoingTask($_SESSION['admin_id'], $_POST['data']);
                echo gmdate("H:i:s", time() - strtotime($is_doing_task['start_time']));
            break;
            case 'update_saved_formats':
                $data = json_decode(stripslashes($_POST['data']));
                $record_format_dao = new RecordFormatsDAO();
                $record_format_dao->add(array('book_record_id' => $data[0],
                                              'format_id' => $data[1]));
                $changelog_dao = new ChangeLogDAO();
                $model = array('table_name' => 'book_record_formats',
                               'column_name' => 'format_id',
                               'entry_id' => $data[0],
                               'changed_by' => $_SESSION['admin_id'],
                               'old_value' => null,
                               'new_value' => (new FormatDAO)->getById($data[1])['name']);
                $changelog_dao->add($model);
            break;
            case 'delete_saved_formats':
                $data = json_decode(stripslashes($_POST['data']));
                $record_format_dao = new RecordFormatsDAO();
                $record_format_dao->deleteCheck($data[0], $data[1]);
                $changelog_dao = new ChangeLogDAO();
                $model = array('table_name' => 'book_record_formats',
                               'column_name' => 'format_id',
                               'entry_id' => $data[0],
                               'changed_by' => $_SESSION['admin_id'],
                               'old_value' => (new FormatDAO)->getById($data[1])['name'],
                               'new_value' => null);
                $changelog_dao->add($model);
            break;
            case 'update_file_path':
                $data = json_decode($_POST['data']);
                $record_dao = new RecordDAO();
                $record = $record_dao->getById($data[0]);
                $record['file_path'] = $data[1];
                $record_dao->update($record);
            break;
            case 'update_from_email':
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                      'from_email' => $_POST['data']);
                    $settings_dao->add($settings);
                } else {
                    $settings['from_email'] = $_POST['data'];   
                    $settings_dao->update($settings);
                }
            break;
            case 'update_contact_phone':
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                      'contact_phone' => $_POST['data']);
                    $settings_dao->add($settings);
                } else {
                    $settings['contact_phone'] = $_POST['data'];   
                    $settings_dao->update($settings);
                }
            break;
            case 'get_courses':
                $info = $this->getBookInfo($_SESSION['phpCAS']['user'], $_POST['data']);
                echo json_encode($info);
            break;
            case 'get_email':
                $email_dao = new EmailDAO();
                $email = $email_dao->getById($_POST['data']);
                $response = array('subject' => $email['title'],
                                  'content' => $email['content']);
                echo json_encode($response);
            break;
            case 'add_to_list':
                $data = json_decode(stripslashes($_POST['data']));
                $list_dao = new EmailListPersonIDsDAO();
                $model = array('email_list_id' => $data[1],
                               'person_id' => BYULINK::getPersonID($data[0]));
                $list_dao->add($model);
                echo $list_dao->getLastId();
            break;
            case 'remove_from_list':
                $list_dao = new EmailListPersonIDsDAO();
                $list_dao->delete($_POST['data']);
            break;
            case 'get_statistics':
                $request_dao = new RequestDAO();
                $semester_code = $_POST['data'];
                $semesters = $request_dao->getBySemesterCode($semester_code);
                for ($i=0; $i<count($semesters); $i++) {
                    $semesters[$i]['submitted'] = strtotime($semesters[$i]['submitted']);
                }
                echo json_encode($semesters);
            break;
            case 'update_settings':
                $data = json_decode($_POST['data']);
                switch ($data[1]) {
                    case 'record_status':
                        $dao = new RecordStatusDAO();
                    break;
                    case 'priority':
                        $dao = new PriorityDAO();
                    break;
                    case 'record_format':
                        $dao = new FormatDAO();
                    break;
                    case 'request_status':
                        $dao = new RequestStatusDAO();
                    break;
                    case 'instruction':
                        $dao = new InstructionDAO();
                    break;
                    case 'text':
                        $dao = new TextDAO();
                    break;
                }
                
                $object = $dao->getById($data[0]);
                $object['name'] = $data[2];
                $dao->update($object);
            break;
            case 'update_deny_status':
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                    'coordinator_deny_status_id' => $_POST['data']);
                    $settings_dao->add($settings);
                } else {
                    $settings['coordinator_deny_status_id'] = $_POST['data'];   
                    $settings_dao->update($settings);
                }
            break;
            case 'update_approve_status':
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                    'coordinator_approve_status_id' => $_POST['data']);
                    $settings_dao->add($settings);
                } else {
                    $settings['coordinator_approve_status_id'] = $_POST['data'];   
                    $settings_dao->update($settings);
                }
            break;
            case 'update_email':
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                      'student_submit_email_id' => $_POST['data']);
                    $settings_dao->add($settings);
                } else {
                    $settings['student_submit_email_id'] = $_POST['data'];   
                    $settings_dao->update($settings);
                }
            break;
            case 'check_all':
                $admin_id = $_SESSION['admin_id'];
                $message_dao = new MessageDAO();
                $message_dao->markAllAsRead($admin_id);
            break;
            case 'ajax_book_records':

                $column = $_SESSION['search_column'];

                $columns = array(1 => 'br.title',
                                 2 => 'br.isbn10', 
                                 3 => 'br.isbn13',
                                 4 => 'br.publisher',
                                 5 => 'p.name');

                if ($column == -1 || empty($_GET['search']['value'])) {
                    $table = "
                        (SELECT br.id, br.title, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, p.name AS priority_name, rs.name AS record_status_name 
                        FROM `book_records` br 
                        LEFT JOIN `priority` p ON p.id = br.priority_id
                        LEFT JOIN `record_status` rs on rs.id = br.status_id
                        GROUP BY br.id) temp";
                } else {
                    $search = $columns[$column];
                    $value = $_GET['search']['value'];
                    $table = "
                        (SELECT br.id, br.title, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, p.name AS priority_name, rs.name AS record_status_name 
                        FROM `book_records` br 
                        LEFT JOIN `priority` p ON p.id = br.priority_id
                        LEFT JOIN `record_status` rs on rs.id = br.status_id
                        WHERE $search LIKE '%$value%'
                        GROUP BY br.id) temp";
                }

                $primaryKey = 'id';

                $columns = array(
                    array( 
                        'db' => 'id', 
                        'dt' => 0, 
                        'formatter' => function($d, $row) {
                            return null;
                        }
                    ),
                    array( 
                        'db' => 'title',  
                        'dt' => 1,
                        'formatter' => function ($d, $row) {
                            return "<a href='?controller=page&action=record&id=".$row[0]."'>".$d."</a>";
                        } 
                    ),
                    array( 'db' => 'isbn10',     'dt' => 2 ),
                    array( 'db' => 'isbn13',     'dt' => 3 ),
                    array( 'db' => 'page_count',   'dt' => 4 ),
                    array( 'db' => 'record_status_name', 'dt' => 5),
                    array( 'db' => 'edition',   'dt' => 6 ),
                    array( 'db' => 'author',   'dt' => 7),
                    array( 'db' => 'publisher',   'dt' => 8 ),
                    array( 
                        'db' => 'priority_name',   
                        'dt' => 9
                    )

                );
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'ajax_book_requests':

                //$data = $_GET['data'];
                //$column = $_GET['column'];
                $column = $_SESSION['search_column'];

                $columns = array(1 => 'br.title',
                                 2 => 's.net_id',
                                 3 => 'admin_net_id',
                                 4 => 'rs.name',
                                 5 => 'sn.full_name',
                                 6 => 'br.isbn10', 
                                 7 => 'br.isbn13',
                                 8 => 'br.publisher',
                                 9 => 'br.course');

                if ($column == -1 || empty($_GET['search']['value'])) {
                    $table = "
                        (SELECT br.id, br.title, s.net_id, admin_net_id, rs.name, sn.full_name, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, br.publishing_year,  
                        br.course, br.section, br.instructor, br.submitted
                        FROM `book_requests` br 
                        LEFT JOIN `student` s ON s.id = br.student_id
                        LEFT JOIN `admin` a ON a.id = br.admin_id
                        LEFT JOIN `request_status` rs ON rs.id = br.status_id
                        LEFT JOIN `semester_name` sn ON sn.semester_code = br.semester_code
                        GROUP BY br.id) temp";
                } else {
                    $search = $columns[$column];
                    $value = $_GET['search']['value'];
                    $table = "
                        (SELECT br.id, br.title, s.net_id, admin_net_id, rs.name, sn.full_name, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, br.publishing_year,  
                        br.course, br.section, br.instructor, br.submitted
                        FROM `book_requests` br 
                        LEFT JOIN `student` s ON s.id = br.student_id
                        LEFT JOIN `admin` a ON a.id = br.admin_id
                        LEFT JOIN `request_status` rs ON rs.id = br.status_id
                        LEFT JOIN `semester_name` sn ON sn.semester_code = br.semester_code
                        WHERE $search LIKE '%$value%'
                        GROUP BY br.id) temp";
                }

                $primaryKey = 'id';

                $columns = array(
                    array( 
                        'db' => 'id', 
                        'dt' => 0, 
                        'formatter' => function($d, $row) {
                            return null;
                        }
                    ),
                    array( 
                        'db' => 'title',  
                        'dt' => 1,
                        'formatter' => function ($d, $row) {
                            return "<a href='?controller=page&action=request&id=".$row[0]."'>".$d."</a>";
                        } 
                    ),
                    array( 'db' => 'net_id',     'dt' => 2 ),
                    array( 'db' => 'admin_net_id',     'dt' => 3 ),
                    array( 'db' => 'name',     'dt' => 4 ),
                    array( 'db' => 'full_name',     'dt' => 5 ),
                    array( 'db' => 'page_count',     'dt' => 6 ),
                    array( 'db' => 'isbn10',     'dt' => 7 ),
                    array( 'db' => 'isbn13',     'dt' => 8 ),
                    array( 'db' => 'edition',   'dt' => 9 ),
                    array( 'db' => 'author',   'dt' => 10),
                    array( 'db' => 'publisher',   'dt' => 11 ),
                    array( 'db' => 'publishing_year',   'dt' => 12 ),
                    array( 'db' => 'course',   'dt' => 13 ),
                    array( 'db' => 'section',   'dt' => 14 ),
                    array( 'db' => 'instructor',   'dt' => 15 ),
                    array( 'db' => 'submitted',   'dt' => 16 ),

                );
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'link_book_records':

                $column = $_SESSION['search_column'];

                $columns = array(1 => 'br.title',
                                 2 => 'br.isbn10', 
                                 3 => 'br.isbn13',
                                 4 => 'br.publisher',
                                 5 => 'p.name');

                if ($column == -1 || empty($_GET['search']['value'])) {
                    $table = "
                        (SELECT br.id, br.title, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, p.name AS priority_name, rs.name AS record_status_name 
                        FROM `book_records` br 
                        LEFT JOIN `priority` p ON p.id = br.priority_id
                        LEFT JOIN `record_status` rs on rs.id = br.status_id
                        GROUP BY br.id) temp";
                } else {
                    $search = $columns[$column];
                    $value = $_GET['search']['value'];
                    $table = "
                        (SELECT br.id, br.title, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, p.name AS priority_name, rs.name AS record_status_name 
                        FROM `book_records` br 
                        LEFT JOIN `priority` p ON p.id = br.priority_id
                        LEFT JOIN `record_status` rs on rs.id = br.status_id
                        WHERE $search LIKE '%$value%'
                        GROUP BY br.id) temp";
                }

                $primaryKey = 'id';

                $columns = array(
                    array( 
                        'db' => 'id', 
                        'dt' => 0, 
                        'formatter' => function($d, $row) {
                            return null;
                        }
                    ),
                    array( 
                        'db' => 'title',  
                        'dt' => 1, 
                        'formatter' => function ($d, $row) {
                            return "<form id='assign_record".$row[0]."' style='display:none;' action='' method='post'>
                            <input type='hidden' name='assign_record' value='".$row[0]."' />
                            </form><a href='#' onclick='assignBookRecord(event, ".$row[0].");'>".$d."</a>";
                        } 
                    ),
                    array( 'db' => 'isbn10',     'dt' => 2 ),
                    array( 'db' => 'isbn13',     'dt' => 3 ),
                    array( 'db' => 'page_count',   'dt' => 4 ),
                    array( 'db' => 'record_status_name', 'dt' => 5),
                    array( 'db' => 'edition',   'dt' => 6 ),
                    array( 'db' => 'author',   'dt' => 7),
                    array( 'db' => 'publisher',   'dt' => 8 ),
                    array( 
                        'db' => 'priority_name',   
                        'dt' => 9
                    )

                );
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'link_book_requests':

                $column = $_SESSION['search_column'];

                $columns = array(1 => 'br.title',
                                 2 => 's.net_id',
                                 3 => 'admin_net_id',
                                 4 => 'rs.name',
                                 5 => 'sn.full_name',
                                 6 => 'br.isbn10', 
                                 7 => 'br.isbn13',
                                 8 => 'br.publisher',
                                 9 => 'br.course');

                if ($column == -1 || empty($_GET['search']['value'])) {
                    $table = "
                        (SELECT br.id, br.title, s.net_id, admin_net_id, rs.name, sn.full_name, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, br.publishing_year,  
                        br.course, br.section, br.instructor, br.submitted
                        FROM `book_requests` br 
                        LEFT JOIN `student` s ON s.id = br.student_id
                        LEFT JOIN `admin` a ON a.id = br.admin_id
                        LEFT JOIN `request_status` rs ON rs.id = br.status_id
                        LEFT JOIN `semester_name` sn ON sn.semester_code = br.semester_code
                        GROUP BY br.id) temp";
                } else {
                    $search = $columns[$column];
                    $value = $_GET['search']['value'];
                    $table = "
                        (SELECT br.id, br.title, s.net_id, admin_net_id, rs.name, sn.full_name, br.isbn10, br.isbn13, br.page_count, br.edition, br.author, br.publisher, br.publishing_year,  
                        br.course, br.section, br.instructor, br.submitted
                        FROM `book_requests` br 
                        LEFT JOIN `student` s ON s.id = br.student_id
                        LEFT JOIN `admin` a ON a.id = br.admin_id
                        LEFT JOIN `request_status` rs ON rs.id = br.status_id
                        LEFT JOIN `semester_name` sn ON sn.semester_code = br.semester_code
                        WHERE $search LIKE '%$value%'
                        GROUP BY br.id) temp";
                }

                $primaryKey = 'id';

                $columns = array(
                    array( 
                        'db' => 'id', 
                        'dt' => 0, 
                        'formatter' => function($d, $row) {
                            return null;
                        }
                    ),
                    array( 
                        'db' => 'title',  
                        'dt' => 1,
                        'formatter' => function ($d, $row) {
                            return "<form id='assign_request".$row[0]."' style='display:none;' action='' method='post'>
                                    <input type='hidden' name='assign_request' value='".$row[0]."' />
                                    </form><a href='#' onclick='assignBookRequest(event, ".$row[0].");'>".$d."</a>";
                        } 
                    ),
                    array( 'db' => 'net_id',     'dt' => 2 ),
                    array( 'db' => 'admin_net_id',     'dt' => 3 ),
                    array( 'db' => 'name',     'dt' => 4 ),
                    array( 'db' => 'full_name',     'dt' => 5 ),
                    array( 'db' => 'page_count',     'dt' => 6 ),
                    array( 'db' => 'isbn10',     'dt' => 7 ),
                    array( 'db' => 'isbn13',     'dt' => 8 ),
                    array( 'db' => 'edition',   'dt' => 9 ),
                    array( 'db' => 'author',   'dt' => 10),
                    array( 'db' => 'publisher',   'dt' => 11 ),
                    array( 'db' => 'publishing_year',   'dt' => 12 ),
                    array( 'db' => 'course',   'dt' => 13 ),
                    array( 'db' => 'section',   'dt' => 14 ),
                    array( 'db' => 'instructor',   'dt' => 15 ),
                    array( 'db' => 'submitted',   'dt' => 16 )

                );
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'ajax_students':
                $table = "
                    (SELECT id, net_id, byu_id, first_name, last_name FROM `student` GROUP BY id) temp";

                $primaryKey = 'id';

                $columns = array(
                    array( 
                        'db' => 'id', 
                        'dt' => 0, 
                        'formatter' => function($d, $row) {
                            return null;
                        }
                    ),
                    array( 
                        'db' => 'first_name',  
                        'dt' => 1, 
                        'formatter' => function ($d, $row) {
                            return "<a href='?controller=page&action=student&id=".$row[0]."'>".$d."</a>";
                        } 
                    ),
                    array( 'db' => 'last_name',     'dt' => 2 ),
                    array( 'db' => 'net_id',     'dt' => 3 ),
                    array( 'db' => 'byu_id',     'dt' => 4 ),

                );
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'dashlet_data':

                $blob = json_decode($_GET['data']);
                $dashlet_dao = new DashletDAO();
                
                if ($blob->type == "request") {
                    $small_title = "Book Requests";
                    $table = $dashlet_dao->getRequestSQLByFilter($blob->type, $blob->columns, $blob->semester, $blob->status);
                    $columns = array(
                        array( 
                            'db' => 'id', 
                            'dt' => 0, 
                            'formatter' => function($d, $row) {
                                return null;
                            }
                        )
                    );         
                    foreach ($blob->columns as $key => $value) {
                        $columns[] = array(
                            'db' => $value,  
                            'dt' => $key+1, 
                            'formatter' => function ($d, $row) {
                                return "<a href='?controller=page&action=request&id=".$row[0]."'>".$d."</a>";
                            }
                        );
                    }
                } else if ($blob->type == "record") {
                    $small_title = "Book Records"; 
                    $table = $dashlet_dao->getRecordSQLByFilter($blob->type, $blob->columns, $blob->editor, $blob->status); 
                    $columns = array(
                        array( 
                            'db' => 'id', 
                            'dt' => 0, 
                            'formatter' => function($d, $row) {
                                return null;
                            }
                        )
                    );
                    
                    foreach ($blob->columns as $key => $value) {
                        if (strpos($value, '.') !== false) {
                            if ($value == 'p.name') {
                                $value = "priority_name";
                            } else if ($value == 'rs.name') {
                                $value = "record_status_name";
                            } else {
                                $value = strstr($value, '.');
                                $value = ltrim($value, '.');
                            }
                        }
                        $columns[] = array(
                            'db' => $value,  
                            'dt' => $key+1, 
                            'formatter' => function ($d, $row) {
                                return "<a href='?controller=page&action=record&id=".$row[0]."'>".$d."</a>";
                            }
                        );
                    }
                }

                $primaryKey = 'id';
                
                // SQL server connection information
                $sql_details = array(
                    'user' => Database::getUsername(),
                    'pass' => Database::getPassword(),
                    'db'   => Database::getDBName(),
                    'host' => Database::getHost()
                );
                
                echo json_encode(
                    SSP::simple_join( $_GET, $sql_details, $table, $primaryKey, $columns )
                );
            break;
            case 'add_previous_page':
                $data = json_decode(stripslashes($_POST['data']));
                if ($data[1] != null) {
                    if (isset($_SESSION['last_page']) && count($_SESSION['last_page']) > 4 && !array_key_exists($data[0], $_SESSION['last_page'])) {
                        reset($_SESSION['last_page']);
                        $first_key = key($_SESSION['last_page']);
                        unset($_SESSION['last_page'][$first_key]);
                    } 
                    
                    $_SESSION['last_page'][$data[0]] = $data[1];
                }
            break;
            case 'update_email_trigger':
                $data = json_decode(stripslashes($_POST['data']));
                $settings_dao = new SettingsDAO();
                $settings = $settings_dao->getById(1);
                if (!$settings) {
                    $settings = array('id' => 1, 
                                      $data[0] => $data[1]);
                    $settings_dao->add($settings);
                } else {
                    $settings[$data[0]] = $data[1];   
                    $settings_dao->update($settings);
                }
            break;
            case 'send_2_email':
                $student_id = $_POST['data'];
                $student_dao = new StudentDAO();
                $student = $student_dao->getById($student_id);

                $student_name = BYULINK::getName($student['person_id'], 'PERSON_ID');
                $student_full_name = $student_name['preferred_first_name']." ".$student_name['surname'];
                $to_email = BYULINK::getEmail($student['person_id'], 'PERSON_ID');

                $settings = (new SettingsDAO)->getById(1);
                if (isset($settings['request_status_2_email_id'])) { 
                    Email::send($settings['request_status_2_email_id'], $to_email, $student_full_name, $settings['from_email'], 'ABC Editors', array('name' => $student_full_name)); 
                    $email_dao = new EmailDAO();
                    $sent_email = $email_dao->getById($settings['request_status_2_email_id']);
                    $eh_dao = new EmailHistoryDAO();
                    $eh_dao->add(array('email_id' => $settings['request_status_2_email_id'],
                                       'email_name' => $sent_email['title'],
                                       'recipients' => json_encode(array($student['net_id']))));
                }
            break;
            case 'send_18_email':
                $student_id = $_POST['data'];
                $student_dao = new StudentDAO();
                $student = $student_dao->getById($student_id);

                $student_name = BYULINK::getName($student['person_id'], 'PERSON_ID');
                $student_full_name = $student_name['preferred_first_name']." ".$student_name['surname'];
                $to_email = BYULINK::getEmail($student['person_id'], 'PERSON_ID');

                $settings = (new SettingsDAO)->getById(1);
                if (isset($settings['request_status_18_email_id'])) { 
                    Email::send($settings['request_status_18_email_id'], $to_email, $student_full_name, $settings['from_email'], 'ABC Editors', array('name' => $student_full_name)); 
                    $email_dao = new EmailDAO();
                    $sent_email = $email_dao->getById($settings['request_status_18_email_id']);
                    $eh_dao = new EmailHistoryDAO();
                    $eh_dao->add(array('email_id' => $settings['request_status_18_email_id'],
                                       'email_name' => $sent_email['title'],
                                       'recipients' => json_encode(array($student['net_id']))));
                }
            break;
            case 'send_21_email':
                $student_id = $_POST['data'];
                $student_dao = new StudentDAO();
                $student = $student_dao->getById($student_id);

                $student_name = BYULINK::getName($student['person_id'], 'PERSON_ID');
                $student_full_name = $student_name['preferred_first_name']." ".$student_name['surname'];
                $to_email = BYULINK::getEmail($student['person_id'], 'PERSON_ID');

                $settings = (new SettingsDAO)->getById(1);
                if (isset($settings['request_status_21_email_id'])) { 
                    Email::send($settings['request_status_21_email_id'], $to_email, $student_full_name, $settings['from_email'], 'ABC Editors', array('name' => $student_full_name)); 
                    $email_dao = new EmailDAO();
                    $sent_email = $email_dao->getById($settings['request_status_21_email_id']);
                    $eh_dao = new EmailHistoryDAO();
                    $eh_dao->add(array('email_id' => $settings['request_status_21_email_id'],
                                       'email_name' => $sent_email['title'],
                                       'recipients' => json_encode(array($student['net_id']))));
                }
            break;
            case 'get_message_data':
                $message_id = $_POST['data'];
                $message_dao = new MessageDAO();
                $message = $message_dao->getById($message_id);
                echo json_encode($message);
            break;
            case 'update_student_list':
                $data = json_decode(stripslashes($_POST['data']));
                $email_dao = new EmailDAO();
                $email = $email_dao->getById($data[1]);
                $email['email_list_id'] = $data[0];
                $email_dao->update($email);
            break;
            case 'update_search_column':
                $_SESSION['search_column'] = $_POST['data'];
            break;
            case 'search_byu':
                $search = $_POST['data'];
                //$names = explode(" ", $search);
                //echo BYULINK::getPersonIDByName($names[0], $names[1]);
                $result = BYULINK::getName($search, 'NET_ID');
                echo $result['preferred_first_name']." ".$result['surname'];
            break;
            case 'update_graph':
                //$dates = json_decode(stripslashes($_POST['dates']));
                //$statuses = json_decode(stripslashes($_POST['statuses']));
                //$semesters = json_decode(stripslashes($_POST['semesters']));

                $date1 = $_GET['start_date'];
                $date2 = $_GET['end_date'];
                $status_id = $_GET['request_status'];
                $semester = $_GET['semester'];

                //just filter out the data collected that meets the criteria of everything provided
                $statistics_dao = new StatisticsDAO();
                //$stats = $statistics_dao->getByFilter($dates, $statuses, $semesters);
                $stats = $statistics_dao->getAllInTimeFrame($date1, $date2, $status_id, $semester);

                //echo $dates[0]." ".$statuses[0]." ".$semesters[0];
                echo json_encode($stats);
                //echo $stats;
            break;
            case 'get_request_statuses':
                echo json_encode((new RequestStatusDAO)->getAll());
            break;
        }
        
    }

    public function getBookInfo($netid,$semester){
	
        if($semester==null)return array();
        
        $byulink = new BYULINK();
        $courses=$byulink->getStudentClasses($netid,$semester,'NET_ID');

        //drupal_set_message(print_r($courses, true));

        if(empty($courses))
            return array();

        //var_dump($courses);

        $query=array();
        foreach($courses as $course){
            $query[]=array(
                "term" => $semester, //find a way to make this get the number automatically //getYearTerm() // $byulink->getYearTerm(time())
                "department" => $course['dept_name'],
                "courseNumber" => $course['catalog_number'].$course['catalog_suffix'],
                "sections" => $course['section_number'] //find a way to get their section number
            );
        }	
        
        //var_dump($query);

        $baseUrl = "https://bkstws.byu.edu/Booklist/v2_1/api/CTL/course";
        $username = "universityaccessibility";
        $password = "c3nte4";
        $accept = 'application/json'; //we want JSON

        $url = $baseUrl . '?query=' . urlencode(json_encode($query));

        $req = curl_init($url);
        curl_setopt($req, CURLOPT_HTTPHEADER, array('Accept: ' . $accept)); //set our accept header
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true); //when we run curl_exec, we want the result to be the return value
        curl_setopt($req, CURLOPT_USERPWD, $username . ':' . $password); //username and password for Basic Authentication 
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($req, CURLOPT_CAINFO, "../includes/cacert.pem") ;  

        $resultJSON = curl_exec($req);
        error_log("curl error: " . curl_error($req));

        $result = json_decode($resultJSON);

        $courses=array();

        $additional_data = array();
        for ($i=0; $i<count($result); $i++) {
            
            $course_key=$result[$i]->department.' '.$result[$i]->courseNumber.' '.$result[$i]->sections;
            
            if(isset($result[$i]->instructors) && isset($result[$i]->instructors[0])){
                $instructor = $result[$i]->instructors[0]->surname.', '.$result[$i]->instructors[0]->givenName;
            }
            else{
                $instructor = '';
            }

            $courses[]=array(
                'department'=>$result[$i]->department,
                'courseNumber'=>$result[$i]->courseNumber,
                'sections'=>$result[$i]->sections,
                'instructor'=>$instructor,
                'adoptions'=>array(),
            );

            $course_key = $i;
            
            $book_key = 0;
            for ($j=0; $j<count($result[$i]->adoptions); $j++) {
                for ($k=0; $k<count($result[$i]->adoptions[$j]->options[0]->items); $k++) {
                    if (empty($result[$i]->adoptions[$j]->options[0]->items[$k]->title)) {
                        $title=$result[$i]->adoptions[$j]->options[0]->items[$k]->description;
                    } else {
                        $title=$result[$i]->adoptions[$j]->options[0]->items[$k]->title;
                    }
                    
                    $courses[$course_key]['adoptions'][$book_key]['title']=$title;
                    
                    $item=$result[$i]->adoptions[$j]->options[0]->items[$k];

                    $courses[$course_key]['adoptions'][$book_key]['author'] = isset($item->author) ? $item->author : '';
                    $courses[$course_key]['adoptions'][$book_key]['price'] = isset($item->formattedNewPrice) ? $item->formattedNewPrice : '';
                    $courses[$course_key]['adoptions'][$book_key]['isbn'] = isset($item->isbn) ? $item->isbn : '';
                    $courses[$course_key]['adoptions'][$book_key]['edition'] = isset($item->edition) ? $item->edition : '';

                    $person_id = $byulink->getPersonID($netid, 'NET_ID');
                    $student = (new StudentDAO)->getByPersonId($person_id);
                    $submitted = false;
                    if ($student) {
                        $submitted = (new RequestDAO)->getActiveRequestsByTitle($student['id'], addslashes($title), $semester);
                    }
                    $courses[$course_key]['adoptions'][$book_key]['submitted'] = $submitted;
                
                    $courses[$course_key]['adoptions'][$book_key]['publisher']='';
                    $courses[$course_key]['adoptions'][$book_key]['publish_date']='';
                
                    if($courses[$course_key]['adoptions'][$j]['isbn']!=''){
                        $additional_data[$j] = $this->getOpenLibraryData($courses[$course_key]['adoptions'][$j]['isbn']);
                        $var = "ISBN:".$courses[$course_key]['adoptions'][$book_key]['isbn'];
                        if(isset($additional_data[$j]->$var)){
                            $courses[$course_key]['adoptions'][$book_key]['publisher'] = $additional_data[$j]->$var->publishers[0]->name;
                            $courses[$course_key]['adoptions'][$book_key]['publish_date'] = $additional_data[$j]->$var->publish_date;
                        }
                    }
                    $book_key++;
                }
            } 
        }
        return $courses;
    }

    public function getOpenLibraryData($isbn) {

        $baseUrl = "https://openlibrary.org/api/books";
        $accept = 'application/json'; //we want JSON
        $url = $baseUrl . '?bibkeys=ISBN:' . $isbn . '&jscmd=data&format=json';

        $req = curl_init($url);
        curl_setopt($req, CURLOPT_HTTPHEADER, array('Accept: ' . $accept)); //set our accept header
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true); //when we run curl_exec, we want the result to be the return value  

        $resultJSON = curl_exec($req);

        return json_decode($resultJSON);
    }

    /*
    public function getBookInfo($netid,$semester){
	
        if($semester==null)return array();
        
        $byulink = new BYULINK();
        $courses=$byulink->getStudentClasses($netid,$semester,'NET_ID');

        //drupal_set_message(print_r($courses, true));

        if(empty($courses))
            return array();

        //var_dump($courses);

        $query=array();
        foreach($courses as $course){
            $query[]=array(
                "term" => $semester, //find a way to make this get the number automatically //getYearTerm() // $byulink->getYearTerm(time())
                "department" => $course['dept_name'],
                "courseNumber" => $course['catalog_number'].$course['catalog_suffix'],
                "sections" => $course['section_number'] //find a way to get their section number
            );
        }	
        
        //var_dump($query);

        $baseUrl = "https://bkstws.byu.edu/Booklist/v2_1/api/CTL/course";
        $username = "universityaccessibility";
        $password = "c3nte4";
        $accept = 'application/json'; //we want JSON

        $url = $baseUrl . '?query=' . urlencode(json_encode($query));

        $req = curl_init($url);
        curl_setopt($req, CURLOPT_HTTPHEADER, array('Accept: ' . $accept)); //set our accept header
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true); //when we run curl_exec, we want the result to be the return value
        curl_setopt($req, CURLOPT_USERPWD, $username . ':' . $password); //username and password for Basic Authentication 
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($req, CURLOPT_CAINFO, "../includes/cacert.pem") ;  

        $resultJSON = curl_exec($req);
        error_log("curl error: " . curl_error($req));

        $result = json_decode($resultJSON);

        //var_dump($result);
        //drupal_set_message("books:".print_r(curl_error($req),true));
        $courses=array();

        $additional_data = array();
        for ($i=0; $i<count($result); $i++) {
            
            $course_key=$result[$i]->department.' '.$result[$i]->courseNumber.' '.$result[$i]->sections;
            
            if(isset($result[$i]->instructors) && isset($result[$i]->instructors[0])){
                $instructor = $result[$i]->instructors[0]->surname.', '.$result[$i]->instructors[0]->givenName;
            }
            else{
                $instructor = '';
            }

            $courses[]=array(
                'department'=>$result[$i]->department,
                'courseNumber'=>$result[$i]->courseNumber,
                'sections'=>$result[$i]->sections,
                'instructor'=>$instructor,
                'adoptions'=>array(),
            );

            $course_key = $i;

            $test_dao = new TestDAO();
            ob_start();
            var_dump($result[$i]->adoptions);
            $test_result = ob_get_clean();
            $test_dao->add(array('jsonString' => $test_result));
            
            for ($j=0; $j<count($result[$i]->adoptions); $j++) {
                
                if (empty($result[$i]->adoptions[$j]->options[0]->items[0]->title)) {
                    //note - online texts will have a description, but no title - do they want us to replace the title with the description if this happens?
                    $title=$result[$i]->adoptions[$j]->options[0]->items[0]->description;
                } else {
                    //note - online texts will have a description, but no title - do they want us to replace the title with the description if this happens?
                    $title=$result[$i]->adoptions[$j]->options[0]->items[0]->title;
                }
                
                $courses[$course_key]['adoptions'][$j]['title']=$title;
                
                $item=$result[$i]->adoptions[$j]->options[0]->items[0];

                $courses[$course_key]['adoptions'][$j]['author'] = isset($item->author) ? $item->author : '';
                $courses[$course_key]['adoptions'][$j]['price'] = isset($item->formattedNewPrice) ? $item->formattedNewPrice : '';
                $courses[$course_key]['adoptions'][$j]['isbn'] = isset($item->isbn) ? $item->isbn : '';
                $courses[$course_key]['adoptions'][$j]['edition'] = isset($item->edition) ? $item->edition : '';

                $person_id = $byulink->getPersonID($netid, 'NET_ID');
                $student = (new StudentDAO)->getByPersonId($person_id);
                $submitted = false;
                if ($student) {
                    $submitted = (new RequestDAO)->getActiveRequestsByTitle($student['id'], addslashes($title), $semester);
                }
                $courses[$course_key]['adoptions'][$j]['submitted'] = $submitted;
            
                $courses[$course_key]['adoptions'][$j]['publisher']='';
                $courses[$course_key]['adoptions'][$j]['publish_date']='';
            
                if($courses[$course_key]['adoptions'][$j]['isbn']!=''){
                    $additional_data[$j] = $this->getOpenLibraryData($courses[$course_key]['adoptions'][$j]['isbn']);
                    $var = "ISBN:".$courses[$course_key]['adoptions'][$j]['isbn'];
                    if(isset($additional_data[$j]->$var)){
                        $courses[$course_key]['adoptions'][$j]['publisher'] = $additional_data[$j]->$var->publishers[0]->name;
                        $courses[$course_key]['adoptions'][$j]['publish_date'] = $additional_data[$j]->$var->publish_date;
                    }
                }
            } 
        }
        return $courses;
    }

    */
    
}

?>