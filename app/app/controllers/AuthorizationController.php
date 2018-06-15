<?php

class AuthorizationController extends \Phalcon\Mvc\Controller
{

    public function loginAction(){
        if($this->request->isPost()){

            try{
                $bruteForceCheck = $this->checkLoginFailure($this->request->getPost("email"));
                if($bruteForceCheck){
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
                else {
                    $this->flash->error("Your account is under brute force attack, and has been temporarily blocked");
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
        try {
            $failureAttempts = new Login;
            $failureAttempts->email = $account[0];
            $failureAttempts->timestamp = $account[1];
        }
        catch(\Exception $e){
            $this->logger->critical('[LOGIN] Login Failure Exception - '.$e);
        }
    }

    private function checkLoginFailure($email){
        try{
            $checkTimestamp = strtotime("-30 minutes", strtotime("now"));
            $checkLogin = Login::count([
                "conditions"    =>  "email = ?1 and timestamp > ?2",
                "bind"  =>  [
                    1   =>  $email,
                    2   =>  $checkTimestamp
                ]
            ]);
            return ($checkLogin<25)?true:false;
        }
        catch(\Exception $e){
            $this->logger->critical('[LOGIN] Check Login Failure Exception - '.$e);
            return false;
        }
    }

    public function registerAction(){
        if($this->request->isPost()){
            try{
                $user = new Users;
                if($user->create($this->request->getPost())){
                    $this->flash->success("User has been created successfully, Please login.");
                    $this->dispatcher->forward([
                        "controller"    =>  "authorization",
                        "action" =>  "login"
                    ]);
                }
                else{
                    $this->flash->error("User cannot be created, Please try again");
                    $this->logger->error("[LOGIN] Register Error, Query didn't complete successfully");
                }
            }
            catch (\Exception $e){
                $this->logger->critical('[LOGIN] Register Exception - '.$e);
            }
        }
    }

    public function forgotPasswordAction(){

    }

    public function logoutAction(){
        $this->session->destroy();
    }

}

