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

}

