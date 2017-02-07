<?php

/*
 * Main Class for Employee Role View
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class Employee_roleView extends View {
    
    protected $template_path = 'Templates/employee-role.php';
    
    public function __construct($data, $role) {   
        $role_dao = new RoleDAO();
        
        $this->assign('role', $role);
        $this->assign('current_admins', $data);
        $this->assign('roles', $role_dao->getAll());
    }
    
}

?>