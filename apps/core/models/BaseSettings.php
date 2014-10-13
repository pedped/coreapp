<?php

use Phalcon\Mvc\Model\Validator\Email as Email;
use Simpledom\Core\AtaModel;

class BaseSettings extends AtaModel {

    public function getSource() {
        return "settings";
    }

    /**
     *
     * @var string
     */
    public $websitename;

    /**
     *
     * @var string
     */
    public $keywords;

    /**
     *
     * @var string
     */
    public $metadata;

    /**
     *
     * @var string
     */
    public $latitude;

    /**
     *
     * @var string
     */
    public $longtude;

    /**
     *
     * @var string
     */
    public $contactemail;

    /**
     *
     * @var string
     */
    public $contactphone;

    /**
     *
     * @var string
     */
    public $address;

    /**
     * Validations and business logic
     */
    public function validation() {

        $this->validate(
                new Email(
                array(
            'field' => 'email',
            'required' => true,
                )
                )
        );
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }

   
    /**
     * 
     * @param type $parameters
     * @return BaseSettings
     */
    public static function Get() {
        return parent::findFirst();
    }

    public function getPublicResponse() {
        
    }

}
