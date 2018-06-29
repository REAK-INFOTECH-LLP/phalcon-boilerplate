<?php

class UtilityController extends ControllerBase
{

    public function indexAction()
    {
   
    }

    public function forbiddenAction()
    {
        $this->response->redirect($this->config->metadata->appUrl . '/authorization/login');
    }

    public function notfoundAction()
    {

    }

    public function sendEmail($toEmail, $toName, $subject, $body)
    {
        // Send Email
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($this->config->metadata->fromEmail, $this->config->metadata->fromName);
        $email->setSubject($subject);
        $email->addTo($toEmail, $toName);
        $email->addContent(
            "text/html", $body
        );
        $sendgrid = new \SendGrid($this->config->metadata->sendGridAPIKey);
        try {
            $response = $sendgrid->send($email);
            return true;
        } catch (Exception $e) {
            $this->logger->critical("[UTILITY] sendEmail - ".$e->getMessage());
            return false;
        }
    }

}
