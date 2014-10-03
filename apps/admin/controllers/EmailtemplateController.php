<?php

namespace Simpledom\Admin\Controllers;

use BaseEmailTemplate;

class EmailtemplateController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {
        $this->setTitle("Email Template");
        
        // list email templates
        $this->view->templates = BaseEmailTemplate::find();
    }

    protected function ValidateAccess($id) {
        
    }

}
