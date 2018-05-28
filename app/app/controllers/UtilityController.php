<?php

class UtilityController extends ControllerBase {

    public function indexAction() {

    }
    
    public function forbiddenAction() {
        $this->response->redirect($this->config->metadata->appUrl.'/authorization/login');
    }
    
    public function notfoundAction() {

    }

}

