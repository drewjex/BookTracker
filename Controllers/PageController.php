<?php

include_once 'Controller.php';

class PageController implements Controller {
    
    public function execute($action) {

        $class = ucfirst($action)."Page";

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $page = new $class($id);
        } else {
            $page = new $class;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
        
        $page->display();
        
    }
    
}

?>