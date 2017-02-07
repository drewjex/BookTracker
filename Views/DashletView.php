<?php 

/*
 * Main Class for Dashlets
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class DashletView extends View {
    
    protected $template_path = 'Templates/dashlet.php';    
    
    public function __construct($id) {
        $dashlet_dao = new DashletDAO();
        $dashlet = $dashlet_dao->getById($id);
        
        $blob = json_decode($dashlet['settings_blob']);
        
        if ($blob->type == "request") {
            $small_title = "Book Requests";
        } else if ($blob->type == "record") {
            $small_title = "Book Records"; 
        }

        $columns = $blob->columns;
        /*foreach ($columns as $key => $value) {
            $columns[$key] = str_replace("_id", "", $columns[$key]);
            $columns[$key] = str_replace("_code", "", $columns[$key]);
        }*/
        
        $this->assign('title', $dashlet['title']);
        $this->assign('small_title', $small_title);
        $this->assign('blob', $blob);
        $this->assign('columns', $columns);
        $this->assign('id', $dashlet['id']);
        $this->assign('settings_blob', $dashlet['settings_blob']);
    }
    
    public function includeScript() {
        $this->getFile('Templates/dashlet-scripts.php', $this->data);
    }
    
}

?>