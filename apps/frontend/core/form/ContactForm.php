<?php

namespace Simplemod\Core;

use EditorElement;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ContactForm extends AtaForm {

    public function initialize() {



        // First Name
        $name = new Text("name");
        $name->setLabel("Full Name");
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $name->setAttribute("class", "form-control");
        $name->addValidator(new PresenceOf(array(
            'message' => 'The name is required'
        )));
        $name->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The name is too short'
        )));
        $this->add($name);

        // ٍEmail
        $email = new Text("email");
        $email->setLabel("Email");
        //$email->setAttribute("placeholder", "Enter Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
            'message' => 'The email is required'
        )));
        $email->addValidator(new Email(array(
            'message' => 'please enter a valid email'
        )));
        $this->add($email);


        // Section
        $reason = new Select("section", array(
            'support' => 'Support',
            'sale' => 'Sale'
        ));
        $reason->setLabel("Section");
        $reason->setAttribute("class", "form-control");
        $this->add($reason);




        // ٍEmail
        $message = new EditorElement("message");
        $message->setLabel("Message");
        $message->setAttribute("class", "form-control");
        $message->addValidator(new PresenceOf(array(
            'message' => 'The message is required'
        )));
        $message->addValidator(new StringLength(array(
            'min' => 10,
            'messageMinimum' => 'The message is too short'
        )));
        $message->setLanguage("en");
        $this->add($message);


        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

}