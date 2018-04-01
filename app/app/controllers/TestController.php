<?php

class TestController extends \Phalcon\Mvc\Controller
{

    public function unitTest(){
        return "ThisWorks";
    }

    public function integrationtestAction(){
        $this->view->disable();
        $data = $this->request->getPost("data");
        echo $data+10;
    }

    public function integrationtestwithjsonAction() {
        $this->view->disable();
        $jsonData = $this->request->getPost("json");
        $jsonData = json_decode($jsonData);
        print_r($jsonData);
    }

    public function testcomposerAction() {
        $this->view->disable();
        $hello = new Rivsen\Demo\Hello();
        echo $hello->hello();
    }

}

