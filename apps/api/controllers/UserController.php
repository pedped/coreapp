<?php

namespace Simpledom\Api\Controllers;

use User;

class UserController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(User::findFirst($id)->getPublicResponse());
    }

    public function listAction() {
        $results = array();
        foreach (User::find() as $value) {
            $results[] = $value->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}