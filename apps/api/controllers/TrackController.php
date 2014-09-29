<?php

namespace Simpledom\Api\Controllers;

use Track;
use User;

class TrackController extends ControllerBase {

    public function getAction($id) {
        return $this->getResponse(User::findFirst($id)->getPublicResponse());
    }

    public function listAction() {
        $results = array();
        foreach (Track::find() as $value) {
            $results[] = $value->getPublicResponse();
        }
        return $this->getResponse($results);
    }

}
