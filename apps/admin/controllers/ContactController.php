<?php

namespace Simplemod\Admin\Controllers;

use AtaPaginator;
use Contact;
use Simplemod\Core\ContactReplyForm;
use Simplemod\Core\SendBulkEmailForm;

class ContactController extends ControllerBase {

    public function listAction($page = 1) {


        // load the users
        $contacts = Contact::find(
                        array(
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function unansweredAction($page = 1) {


        // set title
        $this->setTitle("Un Answered");

        // load the users
        $contacts = Contact::find(
                        array(
                            "reply" => "NULL",
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function sentAction($page = 1) {

        // set title
        $this->setTitle("Sent Message");

        // load the users
        $contacts = Contact::find(
                        array(
                            "reply" => "IS NOT NULL",
                            "order" => "date DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $contacts,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->contactsList = $paginator->getPaginate();
    }

    public function deleteAction($id) {
        // set title
        $this->setTitle("Delete Message");

        $this->view->contactItem = Contact::findFirst($id);

        // create reply form
        $fr = new ContactReplyForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $contact = Contact::findFirst($id);
                $contact->reply = $this->request->getPost("message", "string");
                if (!$contact->save()) {
                    $contact->showErrorMessages($this);
                } else {
                    $contact->showErrorMessages($this, "Reply Message Sent Successfully");
                }
            } else {
                // invalid
            }
        }
        // $this->view->item = $fr;
    }

    public function viewAction($id) {
        // set title
        $this->setTitle("View Contact");

        $this->view->contactItem = Contact::findFirst($id);

        // create reply form
        $fr = new ContactReplyForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $contact = Contact::findFirst($id);
                $contact->reply = $this->request->getPost("message", "string");
                if (!$contact->save()) {
                    $contact->showErrorMessages($this);
                } else {
                    $contact->showErrorMessages($this, "Reply Message Sent Successfully");
                }
            } else {
                // invalid
            }
        }
        $this->view->replyForm = $fr;
    }

    function sendbulkAction() {
        
        $this->setTitle("Send Email To Users");
        
        $fr = new SendBulkEmailForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid, we have to send email
                // TODO send email
                $users = \User::find();
                
            } else {
                // invalid
            }
        }
        $this->view->sendForm = $fr;
    }

}
