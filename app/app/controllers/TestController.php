<?php

class TestController extends ControllerBase
{

    public function unitTest(){
        return "ThisWorks";
    }

    public function integrationtestAction(){
        $this->view->disable();
        $data = $this->request->getPost("data");
        echo $data+10;
    }

    public function testcomposerAction() {
        $this->view->disable();
        $hello = new Rivsen\Demo\Hello();
        echo $hello->hello();
    }

    public function testAction(){
        $this->view->disable();
        print_r($this->config->metadata->appUrl);
    }

    public function fetchAllClientsAction(){
        // Function to fetch all the clients registered on portal
        //
        // Should Return an Integer value via view
        
        $clients = (new \Clients)->getCount();
        $this->view->allclients = $clients;
    }

    public function dbcheckAction(){
        $this->view->disable();
        if($this->request->isPost()){
            $value = $this->request->getPost("value");

            $user = new \User;
            $user->value = $value;
            
            print_r($user->create());
            echo "done";

        } else {
            // Do Nothing
        }
    }

}

