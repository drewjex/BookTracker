<?php

/*
 * Main Class for View 
 *
 * @author Drew Jex Aug 2016
 */

require_once(dirname(__FILE__).'/../../config.php');
include_once(DIR_UTIL . 'includes/BYULINK.php');

foreach (glob(DIR_DAO."*.php") as $filename)
{
    require_once $filename;
}

class View {

    protected $template_path;
    protected $data;

    public function assign($key, $value) {
        $this->data[$key] = $value;
    }
    
    public function getFile($fileName, $data) {
        if ($data != null) 
            extract($data);
        include($fileName);
    }

    public function getScript($fileName) {
        echo "<script src='/production/Views/$fileName' type='text/javascript'></script>";
    }

    public function getStyle($fileName) {
        echo "<link rel='stylesheet' type='text/css' href='/production/Views/$fileName'>";
    }
    
    public function display() {    
        $this->getFile($this->template_path, $this->data);
    }
    
    public function getAdminInfo() {
        if (isset($_SESSION['is_logged_in']) && $_SESSION['is_admin']) {
            $admin_dao = new AdminDAO();
            $role_dao = new RoleDAO();
            $message_dao = new MessageDAO();
            
            $messages = $message_dao->getUnreadMessages($_SESSION['admin_id']);
            
            foreach ($messages as $key => $value) { 
                if ($value['from_admin_id'] != -1) {
                    $person_id = $admin_dao->getById($value['from_admin_id'])['person_id'];
                    $from_name = BYULINK::getName($person_id, 'PERSON_ID');
                    $messages[$key]['from_name'] = $from_name['preferred_first_name']." ".$from_name['surname'];
                    $messages[$key]['picture'] = BYULINK::getPictureURL($person_id, 'PERSON_ID');
                } else {
                    $messages[$key]['from_name'] = "Book Tracker"; //Captain America
                    $messages[$key]['picture'] = "booktracker.png"; //america.png
                }
            }
            
            $admin = $admin_dao->getById($_SESSION['admin_id']);
            $person_id = $admin['person_id'];
            
            $role = $role_dao->getById($admin['role_id']);

            $data['admin_name'] = BYULINK::getName($person_id, 'PERSON_ID');
            $data['picture'] = BYULINK::getPictureURL($person_id, 'PERSON_ID');
            $data['role'] = $role;
            $data['messages'] = $messages;
        }
        
        return $data;
    }

    public function getFooterInfo() {
        $settings_dao = new SettingsDAO();
        $settings = $settings_dao->getById(1);
        $from_email = "abcbookrequests@byu.edu";
        $phone = "801-777-7777";
        if ($settings) {
            if (isset($settings['from_email']))
                $from_email = $settings['from_email'];
            if (isset($settings['contact_phone']))
                $phone = $settings['contact_phone'];
        }

        $data['email'] = $from_email;
        $data['phone'] = $phone;

        return $data;
        
    }

    public function getStudentInfo() {
        if (isset($_SESSION['is_logged_in'])) {
            $student_dao = new StudentDAO();
            $person_id = BYULINK::getPersonID($_SESSION['phpCAS']['user']);

            $data['name'] = BYULINK::getName($person_id, 'PERSON_ID');
            $data['current_student'] = $student_dao->getByPersonId($person_id);
            $data['picture'] = BYULINK::getPictureURL($person_id, 'PERSON_ID');
        }
        
        return $data;
    }

    public function getStudentSidebar() {
        $data = self::getStudentInfo();
        include 'Templates/Theme/student-sidebar.php';
    }

    public function getStudentTopNav() {
        $data = self::getStudentInfo();
        include 'Templates/Theme/student-topnav.php';
    }
    
    public function getSidebar() {
        $data = self::getAdminInfo();
        include 'Templates/Theme/sidebar.php';
    }
    
    public function getHead($title='UAC | Book Tracker') {
        include 'Templates/Theme/head.php';
    }
    
    public function getTopNav() {
        $data = self::getAdminInfo();
        include 'Templates/Theme/topnav.php';
    }
    
    public function getTitle($title) {
        include 'Templates/Theme/title.php';
    }
    
    public function getStudentFooter() {
        $data = self::getFooterInfo();
        include 'Templates/Theme/student-footer.php';
    }

    public function getFooter() {
        include 'Templates/Theme/footer.php';
    }  
    
    public function getScripts() {
        include 'Templates/Theme/scripts.php';
    }
    
    public function endPage() {
        echo "</body></html>";
    }
    
}

?>