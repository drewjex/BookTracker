<?php

/*
 * Main Class for Employees Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class EmployeesPage extends View {
    
    protected $template_path = 'Templates/employees.php';
    
    public function __construct() {
        
        $admin_dao = new AdminDAO();
        $role_dao = new RoleDAO();
        
        if (isset($_POST['new_message'])) {
            $message_dao = new MessageDAO();
            $to_admin_id = $_POST['to_admin_id'];
            $from_admin_id = $_SESSION['admin_id'];
            $content = $_POST['message_content'];
            
            $message = array('from_admin_id' => $from_admin_id,
                             'to_admin_id' => $to_admin_id,
                             'type' => 'private',
                             'content' => $content);
                             
            if ($message_dao->add($message)) {
                $_SESSION['msg'] = "Successfully sent private message!";
            }
        } else if (isset($_POST['new_user'])) {
            $net_id = $_POST['net_id']; 
            $person_id = BYULINK::getPersonID($net_id, 'NET_ID');
            $role_id = $_POST['role'];
            
            $exists = $admin_dao->getByPersonId($person_id);
            if ($exists) {
                $exists['active'] = 1;
                $exists['role_id'] = $_POST['role'];
                if ($admin_dao->update($exists)) {
                    $_SESSION['msg'] = "Successfully added a new user!";
                }
            } else {
                $admin = array('person_id' => $person_id,
                               'admin_net_id' => BYULINK::getNetID($person_id),
                               'role_id' => $role_id);
                if ($admin_dao->add($admin)) {
                    $_SESSION['msg'] = "Successfully added a new user!";
                }
            }
        } else if (isset($_POST['edit_user'])) {
            $admin = $admin_dao->getById($_POST['admin_id']);
            $net_id = $_POST['net_id']; 
            $person_id = BYULINK::getPersonID($net_id, 'NET_ID');
            $role_id = $_POST['role'];
            
            $admin['person_id'] = $person_id;
            $admin['role_id'] = $role_id;
                           
            if ($admin_dao->update($admin)) {
                $_SESSION['msg'] = "Successfully updated user in database!";
            }
        } else if (isset($_POST['remove_user'])) {
            $admin = $admin_dao->getById($_POST['remove_user']);
            $admin['active'] = 0;

            if ($admin_dao->update($admin)) {
                $_SESSION['msg'] = "Successfully removed user!";
            }
        }
        
        $active_admins = $admin_dao->getActiveAdministrator();
        $active_abc = $admin_dao->getActiveEditor();
        $active_coordinators = $admin_dao->getActiveCoordinator();
        
        foreach ($active_admins as $key => $value) { 
            $active_admins[$key]['role_name'] = $role_dao->getById($value['role_id'])['name'];
            $active_admins[$key]['first_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['preferred_first_name'];
            $active_admins[$key]['last_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['surname'];
            $active_admins[$key]['picture'] = BYULINK::getPictureURL($value['person_id'], 'PERSON_ID');
            $active_admins[$key]['phone'] = BYULINK::getPhone($value['person_id'], 'RES', 'PERSON_ID');
            $active_admins[$key]['email'] = BYULINK::getEmail($value['person_id'], 'PERSON_ID');
            $active_admins[$key]['net_id'] = BYULINK::getNETID($value['person_id']);
        }
        
        foreach ($active_abc as $key => $value) { 
            $active_abc[$key]['role_name'] = $role_dao->getById($value['role_id'])['name'];
            $active_abc[$key]['first_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['preferred_first_name'];
            $active_abc[$key]['last_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['surname'];
            $active_abc[$key]['picture'] = BYULINK::getPictureURL($value['person_id'], 'PERSON_ID');
            $active_abc[$key]['phone'] = BYULINK::getPhone($value['person_id'], 'RES', 'PERSON_ID');
            $active_abc[$key]['email'] = BYULINK::getEmail($value['person_id'], 'PERSON_ID');
            $active_abc[$key]['net_id'] = BYULINK::getNETID($value['person_id']);
        }
        
        foreach ($active_coordinators as $key => $value) { 
            $active_coordinators[$key]['role_name'] = $role_dao->getById($value['role_id'])['name'];
            $active_coordinators[$key]['first_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['preferred_first_name'];
            $active_coordinators[$key]['last_name'] = BYULINK::getName($value['person_id'], 'PERSON_ID')['surname'];
            $active_coordinators[$key]['picture'] = BYULINK::getPictureURL($value['person_id'], 'PERSON_ID');
            $active_coordinators[$key]['phone'] = BYULINK::getPhone($value['person_id'], 'RES', 'PERSON_ID');
            $active_coordinators[$key]['email'] = BYULINK::getEmail($value['person_id'], 'PERSON_ID');
            $active_coordinators[$key]['net_id'] = BYULINK::getNETID($value['person_id']);
        }

        $this->assign('active_admins', $active_admins);
        $this->assign('active_abc', $active_abc);
        $this->assign('active_coordinators', $active_coordinators);
        $this->assign('roles', $role_dao->getAll());
        
    }
    
    public function display() {
        
        View::getHead("Employees | Book Tracker");
        View::getSidebar();
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        View::getScript('Templates/employees-scripts.js');
        View::endPage();
        
    }
    
}

?>