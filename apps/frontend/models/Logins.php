<?php

use Simplemod\Core\AtaModel;

class Logins extends AtaModel {

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var integer
     */
    public $date;

    /**
     *
     * @var string
     */
    public $agent;

    /**
     *
     * @var string
     */
    public $ip;

    /**
     *
     * @var string
     */
    public $time;

    public function getDate() {
        return date("Y-m-d H:i:s", $this->date);
    }

    public function getUser() {
        return User::findFirst($this->userid);
    }

    public function beforeValidationOnCreate() {
        $this->time = date("Y-m-d H:i:s", time());
        $this->date = time();
    }

}
