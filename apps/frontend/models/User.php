<?php

define("USERLEVEL_SUPERADMIN", 9);
define("USERLEVEL_ADMIN", 8);
define("USERLEVEL_USER", 1);

use Phalcon\Mvc\Controller;
use Simpledom\Core\AtaModel;

class User extends AtaModel {

    /**
     *
     * @var integer
     */
    public $userid;

    /**
     *
     * @var string
     */
    public $email;

    /**
     *
     * @var integer
     */
    public $level;

    /**
     *
     * @var string
     */
    public $fname;

    /**
     *
     * @var string
     */
    public $lname;

    /**
     *
     * @var integer
     */
    public $gender;

    /**
     *
     * @var string
     */
    public $imagelink;

    /**
     *
     * @var string
     */
    public $regdate;

    /**
     *
     * @var integer
     */
    public $active;

    /**
     *
     * @var integer
     */
    public $verified;

    /**
     *
     * @var string
     */
    public $token;
    /**
     *
     * @var string
     */
    public $regtime;

    /**
     *
     * @var string
     */
    public $resetcode;

    /**
     *
     * @var integer
     */
    public $resetcodedate;

    public function getGenderTitle() {
        if ($this->gender == 1) {
            return "Male";
        } else {
            return "Female";
        }
    }

    public function getJoinDate() {
        return date("Y-m-d H:i:s ", $this->regdate);
    }

    public function beforeValidationOnCreate() {
        $this->imagelink = "/var/www/hello/";
        $this->verified = 0;
        $this->active = 1;
        $this->regdate = date(time());
        $this->verifycode = $this->generateRandomString(256);
        $this->resetcode = "0";
        $this->resetcodedate = "0";
        $this->regtime = date(time());
    }

    public function beforeCreate() {
        $this->password = md5($this->password);
    }

    public function afterCreate() {
        // user created successfully, we have to send email message for the request
    }

    /**
     * Generate a token for the user
     */
    public function generateToken() {

        $this->token = $this->generateRandomString(256);
    }

    /**
     * Try to login to the system, retrun user on succcessfully
     * @param type $email
     * @param type $password
     * @return boolean|User
     */
    public static function Login($email, $password) {

        // TODO validate email


        $user = User::findFirst(array(
                    "email = '$email'"
        ));

        if (isset($user->userid)) {
            // user found, we have to check for password
            if (md5($password) === $user->password) {
                // valid password, we have to generate token for the request
                $user->generateToken();

                // load the user
                return $user;
            } else {
                return false;
            }
        }

        // invalid request
        return false;
    }

    /**
     * store the session
     * @param Controller $controller
     */
    public function setSession($controller) {
        $controller->session->set("userid", $this->userid);
        $controller->session->set("fname", $this->fname);
        $controller->session->set("lname", $this->lname);
        $controller->session->set("imagelink", $this->imagelink);
        $controller->session->set("email", $this->email);
    }

    /**
     * 
     * @param type $parameters
     * @return User
     */
    public static function findFirst($parameters = null) {
        return parent::findFirst($parameters);
    }

    public function requestResetPassword() {

        // we have to generate a password request code
        $this->resetcode = $this->generateRandomString(64);
        $this->resetcodedate = time() + 3600 * 24;

        // send email to user about the request
        if ($this->save()) {
            EmailManager::sendPasswordRequest($this->getFullName(), $this->email, $this->resetcode);
        } else {
            return false;
        }
    }

    /**
     * get the user Full Name
     * @return String
     */
    public function getFullName() {
        return $this->fname . " " . $this->lname;
    }

    /**
     * Track User Login
     */
    public function trackLogin($agent, $ip) {
        $login = new Logins();
        $login->agent = $agent;
        $login->ip = $ip;
        $login->userid = $this->userid;

        // try to log login
        $login->create();
    }

    public function isSuperAdmin() {
        return $this->level == USERLEVEL_SUPERADMIN;
    }

    public function getPublicResponse() {
        $result = new stdClass();
        $result->userid = $this->userid;
        $result->firstname = $this->fname;
        $result->lastname = $this->lname;
        return $result;
    }

    /**
     * get last month registration count
     * @return User
     */
    public function getLastMonthRegistarChart() {

        return $this->rawQuery("SELECT  YEAR(user.regtime) as year , MONTH(user.regtime) as month , day(user.regtime) as day , count(user.userid) as total FROM `user` WHERE YEAR(user.regtime) >= YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
AND MONTH(user.regtime) >= MONTH(CURRENT_DATE - INTERVAL 1 MONTH) GROUP BY day(user.regtime)");
    }

}
