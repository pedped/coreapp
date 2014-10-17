<?php

namespace Simpledom\Frontend\Controllers;

use PaymentMethod;
use PaymentType;
use Phalcon\Text;

class PaymentController extends ControllerBase {

    /**
     *
     * @var PaymentMethod 
     */
    private $paymentHandler;

    public function finishAction($handler) {

        // the payment has been finished, check for the handler
        $paymentMethod = PaymentType::findFirstByKey($handler);
        if (!$paymentMethod || $paymentMethod->enable = FALSE) {
            // the payment option is disabled
            $this->flash->error("unable to find the payment method, may be it is disabled");
            return;
        }

        // check for the payment method name, find the class name, and call the 
        // finish function for the class
        $handlerUpperCase = Text::camelize($handler);
        $this->paymentHandler = new $handlerUpperCase();
        $this->paymentHandler->OnFinishPayment($this->errors, $_REQUEST);
    }

}
