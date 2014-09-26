<?php

namespace Simplemod\Core;

use Phalcon\Forms\Form;

class AtaForm extends Form {

    public function initialize() {

        //Add a text element to put a hidden csrf
        $this->add(new Hidden("csrf"));
    }

    /**
     * This method returns the default value for field 'csrf'
     */
    public function getCsrf() {
        return $this->security->getToken();
    }

    public function renderDecorated($name) {
        $element = $this->get($name);


        //Get any generated messages for the current element
        $messages = $this->getMessagesFor($element->getName());



        echo '<p>';
        echo '<label for="', $element->getName(), '">', $element->getLabel(), '</label>';
        echo $element;
        if (count($messages)) {
            //Print each element
            echo '<div class="element-error-messages">';
            foreach ($messages as $message) {
                echo $this->flash->error($message);
            }
            echo '</div>';
        }
        echo '</p>';
    }

}
