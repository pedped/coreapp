<?php

namespace Simpledom\Frontend\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Url;
use BaseTrack;

class ControllerBase extends Controller {

    private $pageTitle = "Title";

    public function getPageTitle() {
        return $this->pageTitle;
    }

    public function setPageTitle($pageTitle) {
        $this->pageTitle = $pageTitle;
    }

    /**
     * this function will get website settings
     * @param type $title
     * @return string
     */
    public function getSettings($title) {

        return $title;
    }

    public function initialize() {
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


        // we have to track user action right there
        $action = new BaseTrack();
        $action->date = time();
        $action->agent = $this->request->getUserAgent();
        $action->ip = $_SERVER['REMOTE_ADDR'];
        $action->parameters = json_encode($_REQUEST);
        $url = new Url();
        $action->url = $url->getBaseUri();

        if ($this->session->has("userid")) {
            $action->userid = $this->session->get("userid");
        }

        // set page title
        $this->view->pageTitle = $this->pageTitle;

        // save the action
        $action->create();
    }

}
