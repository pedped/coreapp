<?php

namespace Simpledom\Frontend\Controllers;

use BaseUserLog;

class IndexController extends ControllerBase {

    public function indexAction() {

        // check if the user logged in to the system, log home page visit
        if ($this->session->has("userid")) {
            BaseUserLog::byUserID($this->session->get("userid"))->setAction("Visiting Home Page")->create();
        }
    }

}
