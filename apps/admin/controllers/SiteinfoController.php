<?php

namespace Simpledom\Admin\Controllers;

use Simpledom\Core\SiteInfoForm;

class SiteinfoController extends ControllerBase {

    public function indexAction() {

        // set page title
        $this->setTitle("Site Info");

        // load the form
        $fr = new SiteInfoForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
            } else {
                // valid request    
            }
        }
        $this->view->siteInfoForm = $fr;
    }

}
