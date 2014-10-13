<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Simpledom\Admin\BaseControllers\ControllerBase;
use TextElement;

class FooterInfoForm extends AtaForm {

    public function initialize() {

        // Website name
        $footertitle = new TextElement("footertitle");
        $footertitle->setLabel("Footer Title");
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $footertitle->setAttribute("class", "form-control");
        $footertitle->addValidator(new PresenceOf(array(
            'message' => 'The footer title is required'
        )));
        $footertitle->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The footer title is too short'
        )));
        $this->add($footertitle);

        // Website Logo
        // Metadata
        $metedata = new \TextAreaElement("metadata");
        $metedata->setLabel("Metadata");
        $metedata->setAttribute("placeholder", "");
        $metedata->setAttribute("class", "form-control");
        $this->add($metedata);


        // Keywords
        $keywords = new TextElement("keywords");
        $keywords->setLabel("Keywords");
        $keywords->setAttribute("placeholder", "seperate keywords by comma");
        $keywords->setAttribute("class", "form-control");
        $this->add($keywords);


        // Address
        $address = new TextArea("address");
        $address->setLabel("Address");
        $address->setAttribute("class", "form-control");
        $address->addValidator(new PresenceOf(array(
            'message' => 'The Address message is required'
        )));
        $address->addValidator(new StringLength(array(
            'min' => 20,
            'messageMinimum' => 'The Address message is too short'
        )));
        $this->add($address);


        $phone = new TextElement("phone");
        $phone->setLabel("Phone");
        $phone->setAttribute("class", "form-control");
        $phone->addValidator(new PresenceOf(array(
            'message' => 'The Phone is required'
        )));
        $phone->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The Phone is too short'
        )));
        $this->add($phone);


        $email = new TextElement("email");
        $email->setLabel("Support Email");
        $email->setAttribute("class", "form-control");
        $email->addValidator(new PresenceOf(array(
            'message' => 'The Support Email message is required'
        )));
        $email->addValidator(new StringLength(array(
            'min' => 8,
            'messageMinimum' => 'The Support Email message is too short'
        )));
        $this->add($email);


        // Latitude
        $latitude = new TextElement("latitude");
        $latitude->setLabel("Latitude");
        $latitude->setAttribute("placeholder", "");
        $latitude->setAttribute("class", "form-control");
        $this->add($latitude);


        // Longtude
        $longtude = new TextElement("longtude");
        $longtude->setLabel("Longtude");
        $longtude->setAttribute("placeholder", "");
        $longtude->setAttribute("class", "form-control");
        $this->add($longtude);


        // Google Crow Days
        // Submit Button
        $submit = new Submit("submit");
        $submit->setName("submit");
        $submit->setAttribute("class", 'btn btn-primary');
        $this->add($submit);
    }

    /**
     * flash error message to controller
     * @param ControllerBase $controller
     * @param type $this
     */
    public function flashErrors(&$controller) {
        foreach ($this->getMessages() as $message) {
            $controller->flash->error($message);
        }
    }

}
