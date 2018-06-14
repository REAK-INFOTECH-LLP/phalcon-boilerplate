<?php

class AuthorizationController extends \Phalcon\Mvc\Controller
{

    public function loginAction(){
        if($this->request->isPost()){

            try{
                $foundUser = Users::find([
                    "conditions"    =>  "email = ?1",
                    "bind"  =>  [
                        1   =>  $this->request->getPost("email")
                    ]
                ]);
                if($foundUser[0]->password == sha1($this->request->getPost("password"))){
                    // Successfully Authenticated - Redirect on Dashboard / Visiting Page
                    $this->session->set("type",$foundUser[0]->type);
                    $this->session->set("id",$foundUser[0]->id);
                    $this->dispatcher->forward([
                        "controller"    =>  "index",
                        "action" =>  "dashboard"
                    ]);
                }
                else {
                    $this->flash->error("Incorrect Credentials");
                    logLoginFailure(array($this->request->getPost("email"),strtotime("now")));
                }
            }
            catch(\Exception $e){
                $this->flash->error("System failure, Please contact site administrator.");
                $this->logger->critical('[LOGIN] Login Exception - '.$e);
            }
        }
    }

    private function logLoginFailure($account=null){
        // Receives email address and timestamp of login
    }

    public function registerAction(){

    }

    public function forgotPasswordAction(){

    }

    public function logoutAction(){
        $this->session->destroy();
    }

}

