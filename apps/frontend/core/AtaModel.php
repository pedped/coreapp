<?php

namespace Simpledom\Core;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

class AtaModel extends Model {

    /**
     * Create Custom Query
     * @param type $sql
     * @param type $params
     * @return \Phalcon\Mvc\Model\Resultset\Simple
     */
    public function rawQuery($sql, $params = null) {
        return new Resultset(null, $this, $this->getReadConnection()->query($sql, $params));
    }

    public function generateRandomString($length = 10) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * 
     * @param ControllerBase $controller
     */
    public function showErrorMessages($controller) {
        echo "<div class='alert alert-danger'>";
        foreach ($this->getMessages() as $message) {
            $controller->flash->error($message);
        }
        echo "</div>";
    }

    /**
     * 
     * @param ControllerBase $controller
     */
    public function showSuccessMessages($controller, $message) {
        echo "<div class='alert alert-success'>";
        $controller->flash->success($message);
        echo "</div>";
    }

}
