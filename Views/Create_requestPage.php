<?php

include_once('View.php');

class Create_requestPage extends View {
    
    protected $template_path = 'Templates/create-request.php';
    
    public function __construct() {

        $request_dao = new RequestDAO();
        $student_dao = new StudentDAO();
        $admin_dao = new AdminDAO();

        if (isset($_POST['new_request'])) {
            
            $student_person_id = BYULINK::getPersonID($_POST['student']);
            if ($student_person_id == 000000000) {
                $_SESSION['msg'] = "Request not created! That student does not exist.";
            } else {
                $student = $student_dao->getByPersonId($student_person_id);
                
                if (!$student) {
                    $name = BYULINK::getName($student_person_id, 'PERSON_ID');
                    $student_dao->add(array('person_id' => $student_person_id,
                                            'net_id' => BYULINK::getNetID($student_person_id, 'PERSON_ID'),
                                            'first_name' => $name['preferred_first_name'],
                                            'last_name' => $name['surname'],
                                            'byu_id' => BYULINK::getBYUID($student_person_id, 'PERSON_ID')));
                    $student_id = $student_dao->getLastId();
                } else {
                    $student_id = $student['id'];
                }
                
                $request = array('title' => $_POST['title'],
                                'book_list_title' => $_POST['title'],
                                'student_id' => $student_id,
                                'admin_id' => $_POST['coordinator'],
                                'status_id' => $_POST['status_id'],
                                'semester_code' => $_POST['semester'],
                                'author' => $_POST['author'],
                                'edition' => $_POST['edition'],
                                'publisher' => $_POST['publisher'],
                                'publishing_year' => $_POST['publishing_year'],
                                'page_count' => $_POST['page_count'],
                                'isbn10' => $_POST['isbn10'],
                                'isbn13' => $_POST['isbn13'],
                                'course' => $_POST['course'],
                                'instructor' => $_POST['instructor'],
                                'submitted' => date('Y-m-d H:i:s', time()));
                                
                if ($request_dao->add($request)) {
                    $last_id = $request_dao->getLastId();
                    $admin_person_id = $admin_dao->getById($_POST['coordinator'])['person_id'];
                    $to_email = BYULINK::getEmail($admin_person_id, 'PERSON_ID');
                    $name = BYULINK::getName($admin_person_id, 'PERSON_ID');
                    $full_name = $name['preferred_first_name']." ".$name['surname'];
                    $student_name = BYULINK::getName($student_dao->getById($student_id)['person_id'], 'PERSON_ID');
                    $student_full_name = $student_name['preferred_first_name']." ".$student_name['surname'];
                    $link = "<a href='http://booktracker.byu.edu/?controller=page&action=request&id=".$last_id."'>".$_POST['title']."</a>";
                    $links[] = $link;
                    $settings = (new SettingsDAO)->getById(1);
                    if (isset($settings['student_submit_email_id'])) {
                        Email::send($settings['student_submit_email_id'], $to_email, $full_name, $settings['from_email'], 'ABC Editors', array('admin-name' => $full_name,
                                                                                                                                            'name' => $student_full_name,
                                                                                                                                            'links' => $links));
                    }
                    $_SESSION['msg'] = "Successfully created new book request!";
                }
            }
        }
        
        $coordinators = $admin_dao->getActiveCoordinator();
        foreach ($coordinators as $key => $value) {
            $name = BYULINK::getName($admin_dao->getById($value['id'])['person_id'], 'PERSON_ID');
            $coordinators[$key]['name'] = $name['preferred_first_name']." ".$name['surname'];
        }
        $this->assign('coordinators', $coordinators);
        $this->assign('statuses', (new RequestStatusDAO)->getAll());
    }

    public function display() {
        
        View::getHead("Create Request | Book Tracker");
        View::getSidebar("Drew Jex");
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        View::endPage();
        
    }
    
}

?>