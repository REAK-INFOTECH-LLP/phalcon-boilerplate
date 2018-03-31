<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->disable();
        echo "Default Action Index/Index";
    }
    
    public function dashboardAction() {
        $this->view->disable();
        echo "Guest shouldn't be able to access this";
    }

}

