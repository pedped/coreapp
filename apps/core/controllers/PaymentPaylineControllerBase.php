<?php

namespace Simpledom\Admin\BaseControllers;

use AtaPaginator;
use PaymentPayline;
use Simpledom\Core\PaymentPaylineForm;


class PaymentPaylineControllerBase extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('PaymentPayline');
    }

    /**
     * this function will validate request access
     * @param type $id
     * @return boolean
     */
    protected function ValidateAccess($id) {
        return true;
    }

    public function addAction() {

        $fr = new PaymentPaylineForm();
        $this->handleFormScripts($fr);
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $paymentpayline = new PaymentPayline();

                $paymentpayline->userid = $this->request->getPost('userid', 'string');
                $paymentpayline->date = $this->request->getPost('date', 'string');
                $paymentpayline->amount = $this->request->getPost('amount', 'string');
                $paymentpayline->cur = $this->request->getPost('cur', 'string');
                $paymentpayline->usertransactionid = $this->request->getPost('usertransactionid', 'string');
                $paymentpayline->paylineidget = $this->request->getPost('paylineidget', 'string');
                $paymentpayline->paylinetransactionid = $this->request->getPost('paylinetransactionid', 'string');
                $paymentpayline->done = $this->request->getPost('done', 'string');
                if (!$paymentpayline->create()) {
                    $paymentpayline->showErrorMessages($this);
                } else {
                    $paymentpayline->showSuccessMessages($this, 'New PaymentPayline added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $paymentpaylines = PaymentPayline::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $paymentpaylines,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'User ID', 'Date', 'Amount', 'Currency', 'User Transaction ID', 'Payline ID Get', 'Payline Transaction ID', 'Done'
                ))->
                setFields(array(
                    'id', 'userid', 'date', 'amount', 'cur', 'usertransactionid', 'paylineidget', 'paylinetransactionid', 'done'
                ))->
                setEditUrl(
                        'edit'
                )->
                setDeleteUrl(
                        'delete'
                )->setListPath(
                'list');

        $this->view->list = $paginator->getPaginate();
    }

    public function deleteAction($id) {

        if (!$this->ValidateAccess($id)) {
            // user do not have permission to remove this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // check if item exist
        $item = PaymentPayline::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'paymentpayline',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = PaymentPayline::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this PaymentPayline item');
            } else {
                $this->flash->success('PaymentPayline item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'paymentpayline',
                            'action' => 'list'
                ));
            }
        }
    }

    public function editAction($id) {


        if (!$this->ValidateAccess($id)) {
            // user do not have permission to edut this object
            return $this->response->setStatusCode('403', 'You do not have permission to access this page');
        }

        // set title
        $this->setTitle('Edit PaymentPayline');

        $paymentpaylineItem = PaymentPayline::findFirst($id);

        // create form
        $fr = new PaymentPaylineForm();
        $this->handleFormScripts($fr);
        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $paymentpayline = PaymentPayline::findFirst($id);
                $paymentpayline->userid = $this->request->getPost('userid', 'string');

                $paymentpayline->date = $this->request->getPost('date', 'string');

                $paymentpayline->amount = $this->request->getPost('amount', 'string');

                $paymentpayline->cur = $this->request->getPost('cur', 'string');

                $paymentpayline->usertransactionid = $this->request->getPost('usertransactionid', 'string');

                $paymentpayline->paylineidget = $this->request->getPost('paylineidget', 'string');

                $paymentpayline->paylinetransactionid = $this->request->getPost('paylinetransactionid', 'string');

                $paymentpayline->done = $this->request->getPost('done', 'string');
                if (!$paymentpayline->save()) {
                    $paymentpayline->showErrorMessages($this);
                } else {
                    $paymentpayline->showSuccessMessages($this, 'PaymentPayline Saved Successfully');
                }
            } else {
                // invalid
                $fr->flashErrors($this);
            }
        } else {

            // set default values

            $fr->get('userid')->setDefault($paymentpaylineItem->userid);
            $fr->get('date')->setDefault($paymentpaylineItem->date);
            $fr->get('amount')->setDefault($paymentpaylineItem->amount);
            $fr->get('cur')->setDefault($paymentpaylineItem->cur);
            $fr->get('usertransactionid')->setDefault($paymentpaylineItem->usertransactionid);
            $fr->get('paylineidget')->setDefault($paymentpaylineItem->paylineidget);
            $fr->get('paylinetransactionid')->setDefault($paymentpaylineItem->paylinetransactionid);
            $fr->get('done')->setDefault($paymentpaylineItem->done);
        }

        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = PaymentPayline::findFirst($id);
        $this->view->item = $item;

        $form = new PaymentPaylineForm();
        $this->handleFormScripts($form);
        $form->get('id')->setDefault($item->id);
        $form->get('userid')->setDefault($item->userid);
        $form->get('date')->setDefault($item->date);
        $form->get('amount')->setDefault($item->amount);
        $form->get('cur')->setDefault($item->cur);
        $form->get('usertransactionid')->setDefault($item->usertransactionid);
        $form->get('paylineidget')->setDefault($item->paylineidget);
        $form->get('paylinetransactionid')->setDefault($item->paylinetransactionid);
        $form->get('done')->setDefault($item->done);
        $this->view->form = $form;
    }

}
