<?php

namespace Simpledom\Frontend\Controllers;

use Contact;
use Simpledom\Core\ContactForm;

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
                    $contact->showSuccessMessages($this, "Your message has been sent successfully");

                    // clear the form
                    $fr->clear();
                }
            } else {
                // invalid request
            }
        }
        $this->view->form = $fr;
    }

}
