<?php

class AuthorizationController extends \Phalcon\Mvc\Controller
{

    public function loginAction(){
        if($this->request->isPost()){
            $username = $this->request->getPost("username");
            $password = $this->request->getPost("password");

            if(($username=="admin")&&($password=="admin")){
                $this->session->set("type","admin");
                $this->response->redirect($this->config->metadata->appUrl.'/index/dashboard');
            }
        }
    }

    public function registerAction(){

    }

    public function forgotPasswordAction(){

    }

    public function logoutAction(){
        $this->session->destroy();
    }

}

