<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function initialize(){
        $this->view->appUrl = $this->config->metadata->appUrl;
    }
    
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        // Executed before every found action
        $this->checkAcl($dispatcher->getControllerName(), $dispatcher->getActionName());
        
    }
    
    private function defineAcl(){
        // Allow array
        return $acl = array(
            "admin" =>  array(
                "index/*",
                "utility/*",
                "test/*",
                "authorization/*",
            ),
            "guest"  =>  array(
                "index/index",
                "authorization/*",
                "utility/forbidden",
                "utility/notfound",
                "test/*",
            )
        );
    }
    
    private function checkAcl($controller, $action){
        $type = $this->session->get("type");
        empty($type)?$type="guest":true;
        
        $acl = $this->defineAcl();
        
        // if (!((in_array($controller."/".$action,$acl[$type]))||(in_array($controller."/*",$acl[$type])))) {
        //     $this->dispatcher->forward(
        //         [
        //             "controller" => "utility",
        //             "action"     => "forbidden",
        //         ]
        //     );
        // }
        
    }
}
