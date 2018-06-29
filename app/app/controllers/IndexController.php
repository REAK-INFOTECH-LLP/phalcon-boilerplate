<?php

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $this->view->string = "You're at index/index";
        /***
         * If sessionVerify set true then redirect to dashboard
         * otherwise go to website index page 
         */ 
        if($this->session->get("sessionVerify")== 1)
        {
            $this->response->redirect("index/dashboard");
        }
        
    }
    
    public function dashboardAction() {
        $this->view->string = "You're at index/dashboard";
    }

}

