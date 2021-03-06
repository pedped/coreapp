<?php

use Simpledom\Core\AtaModel;

class BaseUserOrder extends AtaModel {

    public function getSource() {
        return 'userorder';
    }

    /**
     * ID
     * @var string
     */
    public $id;

    /**
     * Set ID
     * @param type $id
     * @return BaseUserOrder
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * User ID
     * @var string
     */
    public $userid;

    /**
     * Set User ID
     * @param type $userid
     * @return BaseUserOrder
     */
    public function setUserid($userid) {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Type
     * @var string
     */
    public $type;

    /**
     * Set Type
     * @param type $type
     * @return BaseUserOrder
     */
    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    /**
     * fetch the ProductTypes of this model based on type
     * @return ProductType
     */
    public function getTypes() {
        return ProductType::find('id = ' . $this->type . '');
    }

    /**
     * Item ID
     * @var string
     */
    public $itemid;

    /**
     * Set Item ID
     * @param type $itemid
     * @return BaseUserOrder
     */
    public function setItemid($itemid) {
        $this->itemid = $itemid;
        return $this;
    }

    /**
     * Payment Product Type
     * @var string
     */
    public $paymenttype;

    /**
     * Set Payment Product Type
     * @param type $paymenttype
     * @return BaseUserOrder
     */
    public function setPaymenttype($paymenttype) {
        $this->paymenttype = $paymenttype;
        return $this;
    }

    /**
     * fetch the PaymentTypes of this model based on paymenttype
     * @return PaymentType
     */
    public function getPaymentProductTypes() {
        return PaymentType::find('id = ' . $this->paymenttype . '');
    }

    /**
     * Payment Item ID
     * @var string
     */
    public $paymentitemid;

    /**
     * Set Payment Item ID
     * @param type $paymentitemid
     * @return BaseUserOrder
     */
    public function setPaymentitemid($paymentitemid) {
        $this->paymentitemid = $paymentitemid;
        return $this;
    }

    /**
     * price
     * @var string
     */
    public $price;

    /**
     * Set price
     * @param type $price
     * @return BaseUserOrder
     */
    public function setPrice($price) {
        $this->price = $price;
        return $this;
    }

    /**
     * Price Currency
     * @var string
     */
    public $pricecurrency;

    /**
     * Set Price Currency
     * @param type $pricecurrency
     * @return BaseUserOrder
     */
    public function setPricecurrency($pricecurrency) {
        $this->pricecurrency = $pricecurrency;
        return $this;
    }

    /**
     * date
     * @var string
     */
    public $date;

    /**
     * Set date
     * @param type $date
     * @return BaseUserOrder
     */
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }

    public function getDate() {
        return date('Y-m-d H:m:s', $this->date);
    }

    /**
     * date
     * @var string
     */
    public $done;

    /**
     * date
     * @var string
     */
    public $donedate;

    /**
     * 
     * @param type $done
     * @return BaseUserOrder
     */
    public function setDone($done) {
        $this->done = $done;
        return $this;
    }

    /**
     * 
     * @param type $donedate
     * @return BaseUserOrder
     */
    public function setDonedate($donedate) {
        $this->donedate = $donedate;
        return $this;
    }

    public function beforeValidationOnCreate() {
        $this->date = time();
        $this->done = 0;
        $this->donedate = 0;
    }

    public function beforeValidationOnSave() {
        
    }

    public function getPublicResponse() {
        
    }

    /**
     * 
     * @param type $parameters
     * @return UserOrder
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

}
