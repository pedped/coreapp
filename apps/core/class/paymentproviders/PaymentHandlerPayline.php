<?php

use Simpledom\Core\Classes\Config;

class PaymentHandlerPayline extends PaymentMethod {

    public function CheckPayed($paymentID) {
        
    }

    public function CreatePayment($amount, $currency, $userTransactionID) {
        
    }

    public function GetPaymentInfo($paymentitemid) {
        
    }

    public function OnFinishPayment(&$errors, $parameters) {

        //Get Inputs
        $paylineTransactionID = $parameters['trans_id'];
        $paylineGetID = $parameters['id_get'];
        $paylinePaylineID = $parameters['pid'];

        // Add Payline Function
        if (!$this->SetPayed($errors, $paylineTransactionID, $paylineGetID, $paylinePaylineID)) {
            $errors = _("Unable to finish payment");
            return false;
        }


        // payment method set to done, check if this payment was belong to a order
        require_once '../core/class.order.php';
        $o = new Order($_SESSION["uid"]);
        $paymentType = __ORDERPAYMENTTYPE_PAYLINE;
        $o->OnSuccessPayment($errors, $paymentType, $paylinePaylineID);


        // the payment may be for the increase cach. check for it
        if (Config::DebugMode()) {
            var_dump($errors);
        }
    }

    protected function SetPayed(&$errors) {

        $paylineTransactionID = func_get_arg(1);
        $paylineIDGet = func_get_arg(2);
        $paylinePaymentID = func_get_arg(3);

        // we have to check if user really payed the price
        if (!$this->VerifyValidPayment($errors, $paylineTransactionID, $paylineIDGet) || !$this->VerifyPaylineIDGetAndPaylineID($paylinePaymentID, $paylineIDGet)) {
            $errors[] = _("Can not validate your payment");
            return;
        }
        // Set Payed
        $done = Mobile_PaylinePaymentSetDone($this->userid, $paylineTransactionID, $paylineIDGet);
        if ($done == false) {
            $errors[] = _("Can not update database info, may be you have payed this order before or you are not authorzed to access this payment");
            return false;
        } else {
            return $done;
        }
    }

    public function StartPayment(&$errors, $paymentID, $amount, $currency) {
        
    }

    public function VerifyValidPayment(&$errors) {

        $paylineTransactionID = func_get_arg(1);
        $paylineIDGet = func_get_arg(2);

        if ($paylineTransactionID == false || $paylineIDGet == false) {
            $errors[] = _("Invalid Parameters to verfiy your payment");
            return false;
        }

        // verfiy via payline verify proccess
        function get($url, $api, $trans_id, $id_get) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "api=$api&id_get=$id_get&trans_id=$trans_id");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        }

        $url = 'http://payline.ir/payment-test/gateway-result-second';
        $api = Config::GetPaylineAPI();
        $trans_id = $paylineTransactionID;
        $id_get = $paylineIDGet;
        $result = get($url, $api, $trans_id, $id_get);
        switch ($result) {
            case '-1' :
                $errors[] = _("invalid payline api");
                return false;
            case '-2' :
                $errors[] = _("invalid Transaction ID");
                return false;
            case '-3' :
                $errors[] = _("invalid Payline GetID");
                return false;
            case '-4' :
                $errors[] = _("Payline can not find this transaction or is not valid");
                return false;
            case '1' :
                // valid payment
                return true;
        }

        return false;
    }

    public function VerifyPaylineIDGetAndPaylineID($paylinePaymentID, $paylineIDGet) {
        
        $mobile_PaylinePayment_GetPaymentGetID = Mobile_PaylinePayment_GetPaymentGetID($paylinePaymentID);
        return intval($mobile_PaylinePayment_GetPaymentGetID) == intval($paylineIDGet);
    }

}
