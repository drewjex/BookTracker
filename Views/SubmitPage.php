<?php

/*
 * Main Class for Student Submit New Book Request Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class SubmitPage extends View {
    
    protected $template_path = 'Templates/submit.php';
    
    public function __construct() {       
        
        $request_dao = new RequestDAO();
        $admin_dao = new AdminDAO();
        $student_dao = new StudentDAO();
        
        $net_id = $_SESSION['phpCAS']['user'];
        $person_id = BYULINK::getPersonID($net_id);

        $links = array();
        
        if (isset($_POST['new_requests'])) {
            $info = json_decode($_POST['json']);
            $student = $student_dao->getByPersonId($person_id);
            if (!$student) {
                $name = BYULINK::getName($person_id, 'PERSON_ID');
                $student_dao->add(array('person_id' => $person_id,
                                        'net_id' => BYULINK::getNetID($person_id, 'PERSON_ID'),
                                        'first_name' => $name['preferred_first_name'],
                                        'last_name' => $name['surname'],
                                        'byu_id' => BYULINK::getBYUID($person_id, 'PERSON_ID'))); 
                $student_id = $student_dao->getLastId();
            } else {
                $student_id = $student['id'];
            }
            if (!empty($_POST['selected_books'])) {
                foreach ($_POST['selected_books'] as $book) {
                    $arr = explode("-", $book);
                    $model = array('student_id' => $student_id,
                                'admin_id' => $_POST['coordinator_id'],
                                'semester_code' => $_POST['semester'],
                                'title' => $info[$arr[0]]->adoptions[$arr[1]]->title,
                                'book_list_title' => $info[$arr[0]]->adoptions[$arr[1]]->title,
                                'edition' => $info[$arr[0]]->adoptions[$arr[1]]->edition,
                                'author' => $info[$arr[0]]->adoptions[$arr[1]]->author,
                                'publisher' => $info[$arr[0]]->adoptions[$arr[1]]->publisher,
                                'publishing_year' => $info[$arr[0]]->adoptions[$arr[1]]->publisher_date,
                                'isbn10' => (strlen($info[$arr[0]]->adoptions[$arr[1]]->isbn) == 10) ? $info[$arr[0]]->adoptions[$arr[1]]->isbn : null,
                                'isbn13' => (strlen($info[$arr[0]]->adoptions[$arr[1]]->isbn) == 13) ? $info[$arr[0]]->adoptions[$arr[1]]->isbn : null,
                                'course' => $info[$arr[0]]->department." ".$info[$arr[0]]->courseNumber,
                                'section' => $info[$arr[0]]->sections,
                                'instructor' => $info[$arr[0]]->instructor,
                                'submitted' => date('Y-m-d H:i:s',time())
                    );
                    if ($request_dao->add($model)) {
                        $last_id = $request_dao->getLastId();
                        $_SESSION['msg'] = "Successfully submitted new Book Request!";
                    }
                    
                    $admin_person_id = $admin_dao->getById($_POST['coordinator_id'])['person_id'];
                    $to_email = BYULINK::getEmail($admin_person_id, 'PERSON_ID');
                    $name = BYULINK::getName($admin_person_id, 'PERSON_ID');
                    $full_name = $name['preferred_first_name']." ".$name['surname'];

                    $student_name = BYULINK::getName($student_dao->getById($student_id)['person_id'], 'PERSON_ID');
                    $student_full_name = $student_name['preferred_first_name']." ".$student_name['surname'];
                    $link = "<a href='http://booktracker.byu.edu/?controller=page&action=request&id=".$last_id."'>".$model['title']."</a>";
                    $links[] = $link;
               }

                $settings = (new SettingsDAO)->getById(1);
                if (isset($settings['student_submit_email_id'])) { 
                    Email::send($settings['student_submit_email_id'], $to_email, $full_name, $settings['from_email'], 'ABC Editors', array('admin-name' => $full_name,
                                                                                                                                           'name' => $student_full_name,
                                                                                                                                           'links' => $links));
                }
            }
            header("Location: ?controller=page&action=my_book_requests");
            exit();
        }

        $coordinators = $admin_dao->getActiveCoordinator();
        foreach ($coordinators as $key => $value) {
            $name = BYULINK::getName($admin_dao->getById($value['id'])['person_id'], 'PERSON_ID');
            $coordinators[$key]['name'] = $name['preferred_first_name']." ".$name['surname'];
        }
        $this->assign('coordinators', $coordinators);
    }
    
    public function display() {
        
        View::getHead("Submit Request | Book Tracker");
        View::getStudentSidebar();
        View::getStudentTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getStudentFooter();
        View::getScripts();
        $this->getFile("Templates/submit-scripts.php", $this->data);
        View::endPage();
        
    } 
    
}

?>