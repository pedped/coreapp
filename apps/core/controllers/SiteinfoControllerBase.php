<?php

namespace Simpledom\Admin\BaseControllers;

use Settings;
use Simpledom\Core\FooterInfoForm;
use Simpledom\Core\SiteInfoForm;

class SiteinfoControllerBase extends ControllerBase {

    public function infoAction() {

        // set page title
        $this->setTitle("Site Info");

        // load settings
        $settings = Settings::Get();
        $fr = new SiteInfoForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
                $fr->flashErrors($this);
            } else {
                // valid request
                $settings->websitename = $this->request->getPost("websitename");
                $settings->contactemail = $this->request->getPost("email");
                $settings->contactphone = $this->request->getPost("phone");
                $settings->address = $this->request->getPost("address");
                $settings->keywords = $this->request->getPost("keywords");
                $settings->metadata = $this->request->getPost("metadata");
                $settings->latitude = $this->request->getPost("latitude");
                $settings->longtude = $this->request->getPost("longtude");
                if ($settings->save()) {
                    $settings->showErrorMessages($this);
                } else {
                    $settings->showSuccessMessages($this, "Website Settings Saved Successfully");
                }
            }
        }


        // Set Default Items
        $fr->get("websitename")->setDefault($settings->websitename);
        $fr->get("email")->setDefault($settings->contactemail);
        $fr->get("phone")->setDefault($settings->contactphone);
        $fr->get("address")->setDefault($settings->address);
        $fr->get("keywords")->setDefault($settings->keywords);
        $fr->get("metadata")->setDefault($settings->metadata);
        $fr->get("latitude")->setDefault($settings->latitude);
        $fr->get("longtude")->setDefault($settings->longtude);

        $this->view->siteInfoForm = $fr;
    }

    public function footerAction() {

        // set page title
        $this->setTitle("Website Footer Text");

        // load settings
        $settings = Settings::Get();
        $fr = new FooterInfoForm();
        if ($this->request->isPost()) {
            if (!$fr->isValid($_POST)) {
                // invalid request
                $fr->flashErrors($this);
            } else {
                // valid request
                $settings->websitename = $this->request->getPost("sitename");
                $settings->contactemail = $this->request->getPost("email");
                $settings->contactphone = $this->request->getPost("phone");
                $settings->address = $this->request->getPost("address");
                $settings->keywords = $this->request->getPost("keywords");
                $settings->metadata = $this->request->getPost("metadata");
                $settings->latitude = $this->request->getPost("latitude");
                $settings->longtude = $this->request->getPost("longtude");
                if ($settings->save()) {
                    $settings->showErrorMessages($this);
                } else {
                    $settings->showSuccessMessages($this, "Website Settings Saved Successfully");
                }
            }
        }


        // Set Default Items
        $fr->get("websitename")->setDefault($settings->websitename);
        $fr->get("email")->setDefault($settings->contactemail);
        $fr->get("phone")->setDefault($settings->contactphone);
        $fr->get("address")->setDefault($settings->address);
        $fr->get("keywords")->setDefault($settings->keywords);
        $fr->get("metadata")->setDefault($settings->metadata);
        $fr->get("latitude")->setDefault($settings->latitude);
        $fr->get("longtude")->setDefault($settings->longtude);

        $this->view->siteInfoForm = $fr;
    }

    protected function ValidateAccess($id) {
        
    }

}
