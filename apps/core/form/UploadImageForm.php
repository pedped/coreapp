<?php

namespace Simpledom\Core;

use Phalcon\Forms\Element\File;
use Phalcon\Forms\Element\Submit;
use Phalcon\Validation\Validator\PresenceOf;
use Simpledom\Core\AtaForm;

class UploadImageForm extends AtaForm {

    public function initialize() {


        // Path
        $file = new File('file');
        $file->setLabel('File');
        $this->add($file);

        // Submit Button
        $submit = new Submit('submit');
        $submit->setName('submit');
        $submit->setAttribute('class', 'btn btn-primary');
        $this->add($submit);
    }

}
