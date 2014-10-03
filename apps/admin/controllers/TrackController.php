<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Logins;
use Track;

class TrackController extends ControllerBase {

    public function indexAction() {
        $this->setTitle("Tracks");
    }

    public function viewvisitAction($id) {
        // set title
        $this->setTitle("View Visit");

        // Load Track
        $this->view->track = Track::findFirst($id);
    }

    public function visitsAction() {

        // set title
        $this->setTitle("Visitors");

        // load the visits count
        $tr = new Track();
        $this->view->totalVisits = Track::count();
        $this->view->last7DayVisits = $tr->getLastSevenDaysVistCount();

        $this->view->visits = $tr->getLastMonthVisitChart();

        // Load Last 100 Visits
        $this->view->last100Tracks = Track::find(array(
                    "limit" => "100",
                    "order" => "id DESC"
        ));
    }

    public function loginAction($page = 1) {
        // set logins
        $this->setTitle("Logins");

        // load the users
        $logins = Logins::find();

        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            "data" => $logins,
            "limit" => 30,
            "page" => $numberPage
        ));
        $this->view->users = $paginator->getPaginate();
    }

    protected function ValidateAccess($id) {
        
    }

}
