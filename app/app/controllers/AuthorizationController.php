<?php

class AuthorizationController extends ControllerBase
{

    public function loginAction()
    {
       
        if($this->session->get("sessionVerify")== 1)
        {
            $this->response->redirect("index/index");
        }
        else {
            if ($this->request->isPost()) {

                try {
                    $bruteForceCheck = $this->checkLoginFailure($this->request->getPost("email"));
                    if ($bruteForceCheck) {
                        $foundUser = Users::find([
                            "conditions" => "email = ?1",
                            "bind" => [
                                1 => $this->request->getPost("email"),
                            ],
                        ]);
                        if ($foundUser[0]->password == sha1($this->request->getPost("password"))) {
                            // Successfully Authenticated - Redirect on Dashboard / Visiting Page
                            // sessionVerify used for check user logged in or not 
                            $this->session->set("sessionVerify", true);
                            $this->session->set("type", $foundUser[0]->type);
                            $this->session->set("id", $foundUser[0]->id);
                            $this->response->redirect("index/dashboard");
                        } else {
                            $this->flash->error("Incorrect Credentials");
                            $this->logLoginFailure(array($this->request->getPost("email"), strtotime("now")));
                        }
                    } else {
                        $this->flash->error("Your account is under brute force attack, and has been temporarily blocked");
                    }
                } catch (\Exception $e) {
                    $this->flash->error("System failure, Please contact site administrator.");
                    $this->logger->critical('[LOGIN] Login Exception - ' . $e);
                }
            }
        }
    }

    private function logLoginFailure($account = null)
    {
        // Receives email address and timestamp of login
        try {
            $failureAttempts = new Login;
            $failureAttempts->email = $account[0];
            $failureAttempts->timestamp = $account[1];
            if (!$failureAttempts->create()) {
                $this->logger->critical('[LOGIN] Login Failure DB didnt SAVE');
            }
        } catch (\Exception $e) {
            $this->logger->critical('[LOGIN] Login Failure Exception - ' . $e);
        }
    }

    private function checkLoginFailure($email)
    {
        try {
            $checkTimestamp = strtotime("-" . $this->config->metadata->loginFailureTimeLimit . " minutes", strtotime("now"));
            $checkLogin = Login::count([
                "conditions" => "email = ?1 and timestamp > ?2",
                "bind" => [
                    1 => $email,
                    2 => $checkTimestamp,
                ],
            ]);
            // Dynamic value for failed login threshold
            return ($checkLogin < $this->config->metadata->loginFailureLimit) ? true : false;
        } catch (\Exception $e) {
            $this->logger->critical('[LOGIN] Check Login Failure Exception - ' . $e);
            return false;
        }
    }

    public function registerAction()
    {
        if ($this->request->isPost()) {
            try {
                $user = new Users;
                if ($user->create($this->request->getPost())) {
                    $this->flash->success("User has been created successfully, Please login.");
                    $this->response->redirect("authorization/login");
                } else {
                    $this->flash->error("User cannot be created, Please try again");
                    $this->logger->error("[LOGIN] Register Error, Query didn't complete successfully");
                }
            } catch (\Exception $e) {
                $this->logger->critical('[LOGIN] Register Exception - ' . $e);
            }
        }
    }

    public function forgotPasswordAction()
    {
        if ($this->request->isPost()) {
            try {
                $email = $this->request->getPost("email");
                // Confirm if Email is a registered user
                $user = Users::find([
                    "conditions" => "email = ?1",
                    "bind" => [
                        1 => $email,
                    ],
                ]);
                // Just making sure, we indeed get a user from it
                $dbEmail = $user[0]->email;
                $forgetPassword = new ForgotPassword;
                $forgetPassword->email = $dbEmail;
                $forgetPassword->secret = $this->generateRandomString();
                $forgetPassword->timestamp = strtotime("now");
                if ($forgetPassword->create()) {
                    $body = file_get_contents(APP_PATH . "/views/emails/forgotPassword.volt");
                    $replaceParams = array(
                        "{{firstName}}" => $user[0]->firstName,
                        "{{lastName}}" => $user[0]->lastName,
                        "{{appUrl}}" => $this->config->metadata->appUrl."authorization/changePassword",
                        "{{resetPassParams}}" => "email=".$user[0]->email."&secret=" . $forgetPassword->secret,
                        "{{fromName}}" => $this->config->metadata->fromName,
                    );
                    $body = strtr($body, $replaceParams);
                    $utility = new UtilityController;
                    if ($utility->sendEmail($dbEmail, $user[0]->firstName." ".$user[0]->lastName, "Password reset request", $body)) {
                        // Password successfully sent
                        $this->flash->success("Email with password reset link has been sent, Please check your inbox");
                    } else {
                        $this->flash->error("Password Reset Email couldn't be sent at the moment, Please try again !");
                        $this->logger->error("[LOGIN] Password Reset Email function failed");
                    }
                } else {
                    $this->flash->error("Password Reset Email couldn't be sent at the moment, Please try again !");
                    $this->logger->error("[LOGIN] Password Reset DB Entry Failed");
                }
            } catch (\Exception $e) {
                $this->flash->success("Email with password reset link has been sent, Please check your inbox");
                $this->logger->error('[LOGIN] Forget Password - ' . $e);
            }
        }
    }

    public function changePasswordAction()
    {

        if ($this->request->isPost()) {
            $validForgotPassword = ForgotPassword::count([
                "conditions" => "email = ?1 AND secret = ?2 AND timestamp > ?3",
                "bind" => [
                    1 => $this->request->get("email"),
                    2 => $this->request->get("secret"),
                    3 => strtotime("-30 minutes", strtotime("now")),
                ],
            ]);
            if ($validForgotPassword > 0) {
                // Found more than 1 entry, Resuming to change password
                $user = Users::find([
                    "conditions" => "email = ?1",
                    "bind" => [
                        1 => $this->request->get("email"),
                    ],
                ]);
                $user[0]->password = sha1($this->request->getPost("password"));
                if ($user[0]->update()) {
                    $this->flash->success("Password has been successfully updated, Please login.");
                    // Dispatch to login
                    $this->response->redirect("authorization/login");
                } else {
                    $this->flash->error("Password cannot be updated at this moment, Please try again");
                    $this->logger->error("[LOGIN] changePasswordAction, New password wasn't updated to database");
                }
            }
        }
    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function logoutAction()
    {
        $this->session->destroy();
        $this->response->redirect("authorization/login");
    }
}
