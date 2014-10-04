<?php

namespace Simpledom\Admin\Controllers;

use AtaPaginator;
use Simpledom\Core\SystemLogForm;
use BaseSystemLog;

class SystemLogController extends ControllerBase {

    public function initialize() {
        parent::initialize();
        $this->setTitle('SystemLog');
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

        $fr = new SystemLogForm();
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $systemlog = new \BaseSystemLog();

                $systemlog->title = $this->request->getPost('title', 'string');
                $systemlog->ip = $this->request->getPost('ip', 'string');
                $systemlog->message = $this->request->getPost('message', 'string');
                $systemlog->date = $this->request->getPost('date', 'string');
                if (!$systemlog->create()) {
                    $systemlog->showErrorMessages($this);
                } else {
                    $systemlog->showSuccessMessages($this, 'New SystemLog added Successfully');

                    // clear the title and message so the user can add better info
                    $fr->clear();
                }
            } else {
                // invalid
            }
        }
        $this->view->form = $fr;
    }

    public function listAction($page = 1) {

        // load the users
        $systemlogs = BaseSystemLog::find(
                        array(
                            'order' => 'id DESC'
        ));


        $numberPage = $page;

        // create paginator
        $paginator = new AtaPaginator(array(
            'data' => $systemlogs,
            'limit' => 10,
            'page' => $numberPage
        ));


        $paginator->
                setTableHeaders(array(
                    'ID', 'Title', 'IP', 'Message', 'Date'
                ))->
                setFields(array(
                    'id', 'title', 'ip', 'message', 'date'
                ))->
                setEditUrl(
                        'view'
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
        $item = BaseSystemLog::findFirst($id);
        if (!$item) {
            // item is not exist any more
            return $this->dispatcher->forward(array(
                        'controller' => 'systemlog',
                        'action' => 'list'
            ));
        }

        // check if user want to remove it
        if ($this->request->isPost()) {
            $result = BaseSystemLog::findFirst($id)->delete();
            if (!$result) {
                $this->flash->error('unable to remove this SystemLog item');
            } else {
                $this->flash->success('SystemLog item deleted successfully');
                return $this->dispatcher->forward(array(
                            'controller' => 'systemlog',
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
        $this->setTitle('Edit SystemLog');

        $systemlogItem = BaseSystemLog::findFirst($id);

        // create form
        $fr = new SystemLogForm();

        // check for post request
        if ($this->request->isPost()) {
            if ($fr->isValid($_POST)) {
                // form is valid
                $systemlog = BaseSystemLog::findFirst($id);
                $systemlog->title = $this->request->getPost('title', 'string');

                $systemlog->ip = $this->request->getPost('ip', 'string');

                $systemlog->message = $this->request->getPost('message', 'string');

                $systemlog->date = $this->request->getPost('date', 'string');
                if (!$systemlog->save()) {
                    $systemlog->showErrorMessages($this);
                } else {
                    $systemlog->showSuccessMessages($this, 'SystemLog Saved Successfully');
                }
            } else {
                // invalid
            }
        } else {

            // set default values

            $fr->get('title')->setDefault($systemlogItem->title);
            $fr->get('ip')->setDefault($systemlogItem->ip);
            $fr->get('message')->setDefault($systemlogItem->message);
            $fr->get('date')->setDefault($systemlogItem->date);
        }
        $this->view->form = $fr;
    }

    public function viewAction($id) {

        $item = BaseSystemLog::findFirst($id);
        $this->view->item = $item;

        $form = new SystemLogForm();
        $form->get('id')->setDefault($item->id);
        $form->get('title')->setDefault($item->title);
        $form->get('ip')->setDefault($item->ip);
        $form->get('message')->setDefault($item->message);
        $form->get('date')->setDefault($item->date);
        $this->view->form = $form;
    }

}
