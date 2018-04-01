<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->disable();
        //print_r($this->config);
    }
    
    public function dashboardAction() {
        $this->view->disable();
        echo "Guest shouldn't be able to access this";
    }

}

