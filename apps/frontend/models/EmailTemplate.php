<?php

use Simplemod\Core\AtaModel;

class EmailTemplate extends AtaModel {

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $template;

    /**
     *
     * @var string
     */
    public $parameters;

    /**
     *
     * @var ArrayObject
     */
    private $receivers;

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field template
     *
     * @param string $template
     * @return $this
     */
    public function setTemplate($template) {
        $this->template = $template;

        return $this;
    }

    /**
     * Method to set the value of field parameters
     *
     * @param string $parameters
     * @return $this
     */
    public function setParameters($parameters) {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Returns the value of field template
     *
     * @return string
     */
    public function getTemplate() {
        return $this->template;
    }

    /**
     * Returns the value of field parameters
     *
     * @return string
     */
    public function getParameters() {
        return $this->parameters;
    }

    /**
     * 
     * @param type $parameters
     * @return EmailTemplate
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    /**
     * Set recivers
     * @param ArrayObject|String $emails
     */
    public function setReceivers($emails) {
        if (is_array($emails)) {
            $this->receivers = $emails;
        } else {
            $this->receivers = array();
            $this->receivers[] = $emails;
        }
    }

    public function sendEmail() {
        var_dump($this->parameters);
    }

}
