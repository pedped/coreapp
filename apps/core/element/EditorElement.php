<?php

use Phalcon\Forms\Element;

/**
 * Uses CKEDITOR
 */
class EditorElement extends Element {

    private $language = "en";

    public function getLanguage() {
        return $this->language;
    }

    public function setLanguage($language = "en") {
        $this->language = $language;
    }

    public function render($attributes = null) {
        $name = $this->getName();
        $text = $this->getDefault();
        $html = "
            <textarea name='$name' id='$name' rows='10' cols='80'>
                $text
            </textarea>
            <script>
                CKEDITOR.replace( '$name' , {
                    language: '$this->language'
} );
            </script>
            ";
        return $html;
    }

}
