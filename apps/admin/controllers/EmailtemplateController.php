<?php

namespace Simpledom\Admin\Controllers;

use EmailTemplate;

class EmailtemplateController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $this->setTitle("Email Template");
        
        // list email templates
        $this->view->templates = EmailTemplate::find();
    }

    protected function ValidateAccess($id) {
        
    }

}
