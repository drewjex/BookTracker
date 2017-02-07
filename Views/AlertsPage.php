<?php

/*
 * Main Class for Alerts Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class AlertsPage extends View {
    
    protected $template_path = 'Templates/alerts.php';
    
    public function __construct() {
        $message_dao = new MessageDAO();
        $alerts = $message_dao->getAllMessagesWithId($_SESSION['admin_id']);
        
        foreach ($alerts as $key => $value) {
            $alerts[$key]['to_net_id'] = BYULINK::getNetID((new AdminDAO)->getById($value['to_admin_id'])['person_id'], 'PERSON_ID');
            if ($value['from_admin_id'] == -1 ) {
                $alerts[$key]['from_net_id'] = "Book Tracker";
            } else {
                $alerts[$key]['from_net_id'] = BYULINK::getNetID((new AdminDAO)->getById($value['from_admin_id'])['person_id'], 'PERSON_ID');   
            }
        }
        
        $this->assign('alerts', $alerts);
        
    }
    
    public function display() {
        
        View::getHead("Alerts | Book Tracker");
        View::getSidebar();
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        View::getScript("Templates/alerts-scripts.js");
        View::endPage();
        
    }
    
}

?>