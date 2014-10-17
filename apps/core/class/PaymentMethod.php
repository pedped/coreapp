<?php

abstract class PaymentMethod {

    public abstract function OnFinishPayment();

    public abstract function CheckPayed($paymentID);

    public abstract function CreatePayment($amount, $currency, $userTransactionID);

    public abstract function VerifyValidPayment(&$errors);

    protected abstract function SetPayed(&$errors);

    public abstract function StartPayment(&$errors, $paymentID, $amount, $currency);

    public abstract function GetPaymentInfo($paymentitemid);

    public static function PaymentInfo($paymenttype, $paymentitemid) {
        switch ($paymenttype) {
            case __ORDERPAYMENTTYPE_PAYPAL:
                // it was paypal payment info]
                die("not implanted");
                break;
            case __ORDERPAYMENTTYPE_MELLAT:
                // it was mellat payment
                require_once 'class.payment.mellat.php';
                $mp = new MellatPayment(0);
                $paymentinfo = $mp->GetPaymentInfo($paymentitemid);
                return $paymentinfo;
            case __ORDERPAYMENTTYPE_PAYLINE:
                // it was mellat payment
                require_once 'class.payment.payline.php';
                $pp = new PaymentPayline(0);
                $paymentinfo = $pp->GetPaymentInfo($paymentitemid);
                return $paymentinfo;
            default:
                die("getPaymentInfo implanted");
                break;
        }
    }

}
