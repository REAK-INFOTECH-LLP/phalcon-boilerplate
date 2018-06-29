<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->string = "You're at index/index";
    }
    
    public function dashboardAction() {
        $this->view->string = "You're at index/dashboard";
    }

}

