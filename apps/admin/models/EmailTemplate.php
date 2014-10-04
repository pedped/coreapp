<?php

class EmailTemplate extends BaseEmailTemplate {

    public function getSource() {
        return 'email_template';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Name
     * @var string
     */
    public $name;

    /**
     * Template
     * @var string
     */
    public $template;

    /**
     * Validations and business logic
     */
    public function validation() {
        /**
         *                         $this->validate(
         *                                 new Email(
         *                                 array(
         *                             'field' => 'email',
         *                             'required' => true,
         *                                 )
         *                                 )
         * *                         );
         *                         if ($this->validationHasFailed() == true) {
         *                             return false;
         *                         }
         */
        return true;
    }

    public function beforeValidationOnCreate() {
        //$this->date = time();
        //$this->delete = 0;
    }

    //public function getDate() {
    //    return date('Y-m-d H:m:s', $this->date);
    //}

    public function getPublicResponse() {
        
    }

}
