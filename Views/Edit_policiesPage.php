<?php

/*
 * Main Class for Edit Policies Page
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class Edit_policiesPage extends View {
    
    protected $template_path = 'Templates/edit-policies.php';
    
    public function __construct() {
        $settings_dao = new SettingsDAO();
        
        if (isset($_POST['update_policies'])) {
            $settings = $settings_dao->getById(1);
            if (!$settings) {
                $settings = array('id' => 1, 
                                  'policies' => $_POST['new_policies']);
                if ($settings_dao->add($settings)) {
                    $_SESSION['msg'] = "Successfully Updated Policies/Procedures!";
                }
            } else {
                $settings['policies'] = $_POST['new_policies'];   
                if ($settings_dao->update($settings)) {
                    $_SESSION['msg'] = "Successfully Updated Policies/Procedures!";
                }
            }
        }
        
        $policies = $settings_dao->getById(1)['policies'];
        
        $this->assign('policies', $policies);
    }

    public function display() {
        
        View::getHead("Edit Policies | Book Tracker");
        View::getSidebar();
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        $this->getFile("Templates/edit-policies-scripts.php", $this->data);
        View::endPage();
        
    }
    
}

?>