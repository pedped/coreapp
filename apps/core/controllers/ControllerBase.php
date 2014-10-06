<?php

namespace Simpledom\Admin\BaseControllers;

use AtaController;
use BaseContact;
use BaseUser;

abstract class ControllerBase extends AtaController {

    public function initialize() {

        // check if user is loged in and is super admin
        if ($this->session->get("userid", -1) > 0) {
            // get the user to know he is admin
            $userid = $this->session->get("userid");
            $user = BaseUser::findFirst($userid);
            if (!$user->isSuperAdmin()) {
                // invalid request
                die("You are not authrized to see this page");
            }
        } else {
            // invalid request
            die("You are not authrized to see this page");
        }


        // CSS in the header
        $this->assets
                ->collection('header')
                ->setPrefix('http://localhost/simpledom/')
                ->addCss('css/bt3/bootstrap.css', true)
                ->addCss('css/app/main.css', true);

        //Javascripts in the footer
        $this->assets
                ->collection('footer')
                ->setPrefix('http://localhost/simpledom/')
                ->addJs('js/jquery/jquery.min.js', true)
                ->addJs('bootstrap/bootstrap.js', true);


        $this->view->pfurl = "http://localhost/simpledom/";

        // set default page title
        $this->setTitle("Dashboard");


        // load messages
        $contacts = BaseContact::find(array(
                    "limit" => 5,
                    "order" => "date DESC"
        ));
        $this->view->lastMessages = $contacts;

        $this->view->totalContactsUnanswered = BaseContact::count("reply IS NULL");
    }

    protected function setTitle($title) {
        $this->view->formTitle = $title;
    }

}
