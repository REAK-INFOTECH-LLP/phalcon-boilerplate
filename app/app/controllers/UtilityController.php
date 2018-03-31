<?php

class UtilityController extends ControllerBase {

    public function indexAction() {

    }
    
    public function forbiddenAction() {
        $this->view->disable();
        echo "LUL You got 403'd";
    }
    
    public function notfoundAction() {
        $this->view->disable();
        echo "Not Found";
    }

}

