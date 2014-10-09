<?php

namespace Simpledom\Frontend\Controllers;

use BaseUserLog;
use Simpledom\Core\MasterTutorialForm;

class IndexController extends ControllerBase {

    public function indexAction() {

        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction("Visiting Home Page")->create();
        }


        $form = new MasterTutorialForm();
        $this->view->form = $form;
    }

}
