<?php

use Simpledom\Core\AtaModel;

class Sentemail extends AtaModel {

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $subject;

    /**
     *
     * @var string
     */
    public $content;

    /**
     *
     * @var string
     */
    public $generaltemplate;

    /**
     *
     * @var string
     */
    public $receivers;

    /**
     *
     * @var string
     */
    public $date;

    /**
     *
     * @var string
     */
    public $ip;

    /**
     *
     * @var Boolean
     */
    public $requestresult;

    /**
     *
     * @var boolean
     */
    public $sentresult;

    /**
     * Validations and business logic
     */
    public function validation() {
        
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->sentresult = "0";
    }

    public function getDate() {
        return date("Y-m-d H:m:s", $this->date);
    }

    /**
     * 
     * @param type $parameters
     * @return Sentemail
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function getPublicResponse() {
        
    }

}
