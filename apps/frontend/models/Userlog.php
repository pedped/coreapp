<?php

use Simpledom\Core\AtaModel;

class Userlog extends AtaModel {

    public $id;
    public $userid;
    public $action;
    public $info;
    public $date;

    public function beforeValidationOnCreate() {
        $this->date = date(time());
    }

    public function getPublicResponse() {
        
    }

    /**
     * init the new 
     * @param type $userid
     * @return Userlog
     */
    public static function byUserID($userid) {
        $userLog = new Userlog();
        $userLog->userid = $userid;
        return $userLog;
    }

    /**
     * set user action
     * @param type $action
     * @return Userlog
     */
    public function setAction($action) {
        $this->action = $action;
        return $this;
    }

}
