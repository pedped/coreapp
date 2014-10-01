<?php

use Simpledom\Core\AtaModel;

class Faq extends AtaModel {

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $head;

    /**
     *
     * @var string
     */
    public $title;

    /**
     *
     * @var string
     */
    public $message;

    public function getPublicResponse() {
        
    }

    public function getItems() {
        return Faq::find(
                        array(
                            "head = '$this->head'",
                            "order" => "id DESC"
        ));
    }

}
