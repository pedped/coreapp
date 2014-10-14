<?php

namespace Simpledom\Admin\BaseControllers;

use BaseContact;
use BaseUser;
use Opinion;

class IndexControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
    }

    public function indexAction() {

        // load total contacts
        $this->view->totalUsers = BaseUser::count();
        $this->view->totalOpinions = Opinion::count();
        $this->view->totalContacts = BaseContact::count();
        $user = new BaseUser();
        $this->view->registerChart = $user->getLastMonthRegistarChart();
    }

    protected function ValidateAccess($id) {
        
    }

}
