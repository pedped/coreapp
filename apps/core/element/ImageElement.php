<?php

use Phalcon\Forms\Element;

class ImageElement extends Element {

    private $href;

    public function getHref() {
        return $this->href;
    }

    public function setHref($href) {
        $this->href = $href;
    }

    public function render($attributes = null) {
        $href = $this->getHref();
        $html = "<img src='$href' class='img img-responsive' />";
        return $html;
    }

}
