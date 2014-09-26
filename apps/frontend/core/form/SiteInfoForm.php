<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\TextArea;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SiteInfoForm extends AtaForm {

    public function initialize() {

        // Website name
        $websitename = new Text("websitename");
        $websitename->setLabel("Website Name");
        //$name->setAttribute("placeholder", "Enter your Full Name");
        $websitename->setAttribute("class", "form-control");
        $websitename->addValidator(new PresenceOf(array(
            'message' => 'The website name is required'
        )));
        $websitename->addValidator(new StringLength(array(
            'min' => 6,
            'messageMinimum' => 'The website is too short'
        )));
        $this->add($websitename);


        // Footer Name
        $footername = new TextArea("footername");
        $footername->setLabel("Footer");
        $footername->setAttribute("placeholder", "You may define the title where you have to user for footer text");
        $footername->setAttribute("class", "form-control");
        $footername->addValidator(new PresenceOf(array(
            'message' => 'The footer text is required'
        )));
        $footername->addValidator(new StringLength(array(
            'min' => 20,
            'messageMinimum' => 'The footer text is too short'
        )));
        $this->add($footername);


        // Website Logo
        // Offline Message
        $oflinemessage = new TextArea("offlinemessage");
        $oflinemessage->setLabel("Offline Message");
        $oflinemessage->setAttribute("placeholder", "This message will be shown to users when your site is offline");
        $oflinemessage->setAttribute("class", "form-control");
        $oflinemessage->addValidator(new PresenceOf(array(
            'message' => 'The offline message is required'
        )));
        $oflinemessage->addValidator(new StringLength(array(
            'min' => 20,
            'messageMinimum' => 'The offline message is too short'
        )));
        $this->add($oflinemessage);


        // Metadata
        $metedata = new TextArea("metadata");
        $metedata->setLabel("Metadata");
        $metedata->setAttribute("placeholder", "");
        $metedata->setAttribute("class", "form-control");
        $this->add($metedata);



        // Keywords
        $keywords = new Text("keywords");
        $keywords->setLabel("Keywords");
        $keywords->setAttribute("placeholder", "seperate keywords by comma");
        $keywords->setAttribute("class", "form-control");
        $this->add($keywords);


        // Latitude
        $latitude = new Text("latitude");
        $latitude->setLabel("Latitude");
        $latitude->setAttribute("placeholder", "");
        $latitude->setAttribute("class", "form-control");
        $this->add($latitude);


        // Longtude
        $longtude = new Text("longtude");
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

}
