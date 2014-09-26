<?php

namespace Simplemod\Admin\Controllers;

use Contact;
use User;

class IndexController extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {

        // load total contacts
        $this->view->totalUsers = User::count();
        $this->view->totalContacts = Contact::count();
    }

}