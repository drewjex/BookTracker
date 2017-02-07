<?php

/*
 * Main Class for Home Page (Dashboard)
 *
 * @author Drew Jex Aug 2016
 */

include_once('View.php');

class HomePage extends View {
    
    protected $template_path = 'Templates/home.php';
    public $models;
    
    public function __construct() {
        $dashlet_dao = new DashletDAO();
        $error = false;

        if (isset($_POST['add-dashlet'])) { 
            $type = $_POST['type-select'];
            $title = $_POST['title'];
            if ($type == "request") {
                $blob = array(
                    'type' => $type,
                    'columns' => $_POST['request-columns'],
                    'semester' => $_POST['semester'], 
                    'status' => $_POST['status']
                );
            } else if ($type == "record") {
                $blob = array(
                    'type' => $type,
                    'columns' => $_POST['record-columns'],
                    'editor' => $_POST['editors'],
                    'status' => $_POST['record_status']
                );
            }
            
            $blob = json_encode( $blob );
            
            $model = array('admin_id' => Session::getAdminId(), 
                           'title' => $title, 
                           'settings_blob' => $blob);
                        
            if ($dashlet_dao->add($model) == null) {
                $error = true;
            } else {
                $_SESSION['msg'] = "Successfully added new Dashlet!";
            }
        }

        if (isset($_POST['update-dashlet'])) {
            $id = $_POST['update-dashlet'];
            $type = $_POST['type-select'];
            $title = $_POST['title'];
            if ($type == "request") {
                $blob = array(
                    'type' => $type,
                    'columns' => $_POST['request-columns'],
                    'semester' => $_POST['semester'], 
                    'status' => $_POST['status']
                );
            } else if ($type == "record") {
                $blob = array(
                    'type' => $type,
                    'columns' => $_POST['record-columns'],
                    'editor' => $_POST['editors'],
                    'status' => $_POST['record_status']
                );
            }
            
            $blob = json_encode( $blob );
                        
            $dashlet = $dashlet_dao->getById($id);
            $dashlet['title'] = $title;
            $dashlet['settings_blob'] = $blob;
            
            if (!$dashlet_dao->update($dashlet)) {
                $error = true;
            } else {
                $_SESSION['msg'] = "Successfully updated Dashlet!";
            }
        }
        
        $this->models = $dashlet_dao->getDashletsByAdminId(Session::getAdminId());
        
        $this->assign('models', $this->models);
        $this->assign('statuses', (new RequestStatusDAO)->getAll());
        $this->assign('admins', (new AdminDAO)->getActiveABC());
        $this->assign('record_statuses', (new RecordStatusDAO)->getAll());
        $this->assign('error', $error);
    }

    public function display() {
        
        View::getHead("Home | Book Tracker");
        echo "<style type='text/css'>
                .dashlet_title {
                    cursor: move;
                }
                .add_dashlet {
                    cursor: pointer;
                }
             </style>";
        View::getSidebar();
        View::getTopNav();
        
        $this->getFile($this->template_path, $this->data);
        
        View::getFooter();
        View::getScripts();
        View::getScript('Templates/home-scripts.js');
        foreach ($this->models as $model) {
            $dashlet = new DashletView($model['id']);
            $dashlet->includeScript();
        }
        View::endPage();
        
    }
    
}

?>