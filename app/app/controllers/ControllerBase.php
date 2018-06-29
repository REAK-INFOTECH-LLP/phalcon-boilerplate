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
       //echo "starting work to make token verification along with session verification";
        if($this->request->get("token")){
            $this->view->disable();
            $this->verifyToken($this->request->get("token"),$this->request->get("id"),$dispatcher->getControllerName(),$dispatcher->getActionName());
        }
        else{
            //here call checkAcl function for session type checking
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
        /*
        if (!((in_array($controller."/".$action,$acl[$type]))||(in_array($controller."/*",$acl[$type])))) {
            $this->dispatcher->forward(
                [
                    "controller" => "utility",
                    "action"     => "forbidden",
                ]
            );
        }
        */
    }

    private function verifyToken($token,$id,$controller,$action)
    {
        //here verify token `a8c52bdb667b6a060c7ce788fa900378a48c1623`
        $foundUser = Users::find([
            "conditions" => "id = ?1",
            "bind" => [
                1 => $id,
            ],
        ]);
        if(sha1(($foundUser[0]->email).($foundUser[0]->password)) == $token)
        {
            echo "verified token<br>";
            $acl = $this->defineAcl();
           

        }else{
            echo "not verified";
            // $this->dispatcher->forward(
            //     [
            //         "controller" => "utility",
            //         "action"     => "unauthorize",
            //     ]
            // );
        }
    }
}
