<?php

namespace Simpledom\Api\Controllers;

use User;

class UserController extends ControllerBase {

    public function getAction($id) {
        echo User::findFirst($id)->active;
    }

}
