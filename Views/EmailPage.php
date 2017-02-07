<?php

/*
 * Main Class for Email Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class EmailPage extends View {
    
    protected $template_path = 'Templates/email.php';
    
    public function __construct() {
        $mail = new PHPMailer;
        $email_dao = new EmailDAO();
        $email_list_dao = new EmailListsDAO();
        $email_person_dao = new EmailListPersonIDsDAO();
        $settings_dao = new SettingsDAO();
        $eh_dao = new EmailHistoryDAO();
        
        $net_id = $_SESSION['phpCAS']['user'];
        $person_id = BYULINK::getPersonID($net_id, 'NET_ID');
        
        if (isset($_POST['send_email'])) {
            $email_id = $_POST['send_email'];
            $email = $email_dao->getById($email_id);
            $settings = $settings_dao->getById(1);
            if (!$settings) {
                $from_email = "abcbookrequests@byu.edu";
            } else {
                $from_email = $settings['from_email'];
            }
            if ($email['email_list_id'] != null || $email['email_list_id'] != 0) {
                $people = $email_person_dao->getByListId($email['email_list_id']);
                $recipients = array();
                foreach ($people as $p) {
                    $to_email = BYULINK::getEmail($p['person_id'], 'PERSON_ID');
                    $name = BYULINK::getName($p['person_id'], 'PERSON_ID');
                    $full_name = $name['preferred_first_name']." ".$name['surname'];
                    Email::send($email_id, $to_email, $full_name, $from_email, 'ABC Editors');
                    $recipients[] = BYULINK::getNetID($p['person_id'], 'PERSON_ID'); //$to_email;
                }
                sort($recipients);
                $eh_dao->add(array('email_id' => $email_id,
                                   'email_name' => $email['title'],
                                   'recipients' => json_encode($recipients)));
                $_SESSION['msg'] = "Emails successfully sent!";
            }
        } else if (isset($_POST['delete_email'])) {
            $email_id = $_POST['delete_email'];
            if ($email_dao->delete($email_id)) {
                $_SESSION['msg'] = "Email successfully deleted!";
            }
        } else if (isset($_POST['update_email']) && $_POST['update_email'] != 0) {
            $email_id = $_POST['update_email'];
            $email = $email_dao->getById($email_id);
            $email['title'] = $_POST['email_subject'];
            $email['content'] = $_POST['email_content'];
            if ($email_dao->update($email)) {
                $_SESSION['msg'] = "Email successfully updated!";
            }
        } else if (isset($_POST['create_email']) && $_POST['create_email'] != 0) {
            $model = array('title' => $_POST['email_subject'],
                           'content' => $_POST['email_content'],
                           'automatic' => $_POST['email_type']);

            if ($email_dao->add($model)) {
                $_SESSION['msg'] = "Email successfully created!";
            }
        } else if (isset($_POST['create_list'])) {
            $model = array('name' => $_POST['name']);
            if ($email_list_dao->add($model)) {
                $_SESSION['msg'] = "A new list was created!";
            }
        } else if (isset($_POST['update_list'])) {
            $list = $email_list_dao->getById($_POST['update_list']);
            $list['name'] = $_POST['name'];
            if ($email_list_dao->update($list)) {
                $_SESSION['msg'] = "A list was updated!";
            }
        } else if (isset($_POST['delete_list'])) {
            $list_id = $_POST['delete_list'];
            $people = $email_person_dao->getByListId($list_id);
            foreach ($people as $p) {
                $email_person_dao->delete($p['id']);
            }
            $emails = $email_dao->getAll();
            foreach ($emails as $email) {
                if ($email['email_list_id'] == $list_id) {
                    $email['email_list_id'] = NULL;
                    $email_dao->update($email);
                }
            }
            if ($email_list_dao->delete($list_id)) {
                $_SESSION['msg'] = "A list was deleted!";
            }
        } else if (isset($_POST['remove_assigned_list'])) {
            $email = $email_dao->getById($_POST['remove_assigned_list']);
            $email['email_list_id'] = null;
            if ($email_dao->update($email)) {
                $_SESSION['msg'] = "An email list was unassigned from an email!";
            }
        }
        
        $automatic_emails = $email_dao->getAutomaticEmails();
        $semester_emails = $email_dao->getSemesterEmails();

        $lists = (new EmailListsDAO)->getAll();
        foreach ($lists as $key => $value) {
            $people = (new EmailListPersonIDsDAO)->getByListId($value['id']);
            foreach ($people as $p) {
                $lists[$key]['people'][] = $p;
            }
        }

        $triggers = array(
            array('column_name' => 'student_submit_email_id',
                    'name' => 'Student Request Submitted'),
            array('column_name' => 'request_status_18_email_id',
                    'name' => 'Task 18 Checked'),
            array('column_name' => 'request_status_21_email_id',
                    'name' => 'Task 21 Checked'),
            array('column_name' => 'request_status_2_email_id',
                    'name' => 'Task 2 Checked')
        );

        $history = $eh_dao->getAllSortedRecent();
        
        $this->assign('automatic_emails', $automatic_emails);
        $this->assign('semester_emails', $semester_emails);
        $this->assign('settings', (new SettingsDAO)->getById(1));
        $this->assign('triggers', $triggers);
        $this->assign('email_lists', $lists);
        $this->assign('history', $history);
    }

    public function display() {
        
        View::getHead("Emails | Book Tracker");
        View::getStyle("Templates/email-styles.css");
        View::getSidebar();
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        $this->getFile("Templates/email-scripts.php", $this->data);
        View::endPage();
        
    }
    
}

?>