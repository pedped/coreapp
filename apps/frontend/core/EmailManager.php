<?php

define("EMAILTEMPLATE_RESETPASSWORD", "RESET_PASSWORD");

class EmailManager {

    public static function sendPasswordRequest($name, $email, $resetcode) {
        // load the email template from server
        $emailTemplate = EmailTemplate::findFirst("name = '" . EMAILTEMPLATE_RESETPASSWORD . "'");
        $emailTemplate->setParameters(array(
            "name" => $name,
            "email" => $email,
            "resetcode" => $resetcode,
            "link" => $resetcode,
        ));
        $emailTemplate->setReceivers($email);
        return $emailTemplate->sendEmail();
    }

}
