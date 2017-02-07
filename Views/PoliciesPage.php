<?php

/*
 * Main Class for Student Policies/Procedures Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class PoliciesPage extends View {
    
    protected $template_path = 'Templates/policies.php';
    
    public function __construct() {
        $settings_dao = new SettingsDAO();
        $policies = $settings_dao->getById(1)['policies'];
        
        $this->assign('policies', $policies);
    }

    public function display() {
        
        View::getHead("Policies | Book Tracker");
        View::getStudentSidebar();
        View::getStudentTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getStudentFooter();
        View::getScripts();
        View::endPage();
        
    }
    
}

?>