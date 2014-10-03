<?php

namespace Simpledom\Frontend\Controllers;

use Contact;
use Simpledom\Core\ContactForm;
use User;
use Userlog;

class ContactController extends ControllerBase {



    public function indexAction() {
        $fr = new ContactForm();

        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // valid request
                $contact = new Contact();
                $contact->email = $this->request->getPost("email", "email");
                $contact->message = $this->request->getPost("message", "string");
                $contact->name = $this->request->getPost("name", "string");
                $contact->section = $this->request->getPost("section", "string");


                if (!$contact->create()) {
                    $contact->showErrorMessages($this);
                } else {

                    // check if the user logged in to the system, log home page visit
                    if ($this->session->has("userid")) {
                        Userlog::byUserID($this->session->get("userid"))->setAction("Posted New Contact Message")->setInfo("contact id is " . $contact->id)->create();
                    }

                    $contact->showSuccessMessages($this, "Your message has been sent successfully");

                    // clear the form
                    $fr->clear();
                }
            } else {
                // invalid request
            }
        } else {
            // check if user logged in to system, set name and email
            if ($this->session->has("userid")) {
                $userid = $this->session->get("userid");
                $user = User::findFirst($userid);
                $fr->get("name")->setDefault($user->getFullName());
                $fr->get("email")->setDefault($user->email);
            }
        }
        $this->view->form = $fr;
    }

}
