<?php

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    public function initialize(){
        $this->view->appUrl = $this->config->application->baseUri;
    }
    
    public function beforeExecuteRoute(Dispatcher $dispatcher) {
        // Executed before every found action
         if($this->request->get("token")){
            $this->view->disable();
            $this->verifyToken($this->request->get("token"),$this->request->get("id"),$dispatcher->getControllerName(),$dispatcher->getActionName());
        }
        else{
            //checkAcl function for session checking
            $this->checkAcl($dispatcher->getControllerName(), $dispatcher->getActionName());
        }
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
        
        if (!((in_array($controller."/".$action,$acl[$type]))||(in_array($controller."/*",$acl[$type])))) {
            $this->dispatcher->forward(
                [
                    "controller" => "utility",
                    "action"     => "forbidden",
                ]
            );
        }
        
    }

    private function verifyToken($token,$id,$controller,$action)
    {
        $foundUser = Users::find([
            "conditions" => "id = ?1",
            "bind" => [
                1 => $id,
            ],
        ]);
        if(sha1(($foundUser[0]->email).($foundUser[0]->password)) == $token)
        {
            /** 
             * User Verified Automatically directed to given url
             */
                      
        }else{
            /** 
             * User Not Verified here 
             * return a json with status "failure"
             */
            echo json_encode(array("status"=>"failure","message"=>"Un Authorized User"));
        }
    }
}
