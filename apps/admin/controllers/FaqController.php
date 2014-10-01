<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Contact;
use Faq;
use Simpledom\Core\ContactReplyForm;
use Simpledom\Core\FaqForm;

class FaqController extends ControllerBase {

    public function addAction() {

        $fr = new FaqForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $faq = new \Faq();
                $faq->head = $this->request->getPost("head", "string");
                $faq->title = $this->request->getPost("title", "string");
                $faq->message = $this->request->getPost("message", "string");
                if (!$faq->create()) {
                    $faq->showErrorMessages($this);
                } else {
                    $faq->showSuccessMessages($this, "New FAQ added Successfully");

                    // clear the title and message so the user can add better info
                    $fr->get("title")->clear();
                    $fr->get("message")->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {


        // load the users
        $faqs = Faq::find(
                        array(
                            "order" => "head ASC , id DESC"
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $faqs,
            "limit" => 10,
            "page" => $numberPage
        ));
        $this->view->list = $paginator->getPaginate();
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

}
