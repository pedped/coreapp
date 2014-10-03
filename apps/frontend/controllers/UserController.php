<?php

namespace Simpledom\Frontend\Controllers;

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
use Simpledom\Core\ForgetPasswordForm;
use Simpledom\Core\LoginForm;
use Simpledom\Core\ProfileEditForm;
use Simpledom\Core\RegisterForm;
use User;
use Userlog;

class UserController extends ControllerBase {

    public function LogoutAction() {
        // destroy session
        $this->session->destroy();

        return $this->dispatcher->forward(array(
                    "controller" => "index",
                    "action" => "index"
        ));
    }

    public function ForgetpasswordAction() {
        $fr = new ForgetPasswordForm();
        if ($this->request->isPost()) {
            // we have to validate the request 
            if ($fr->isValid($_POST)) {
                // valid request, we have to reset user request
                $email = $this->request->getPost("email", "email");
                $user = User::findFirst("email = '" . $email . "'");
                if (!$user) {
                    // user not found
                    $this->flash->error("Unable to find such user with requested email");
                } else {
                    // user found, we have to request password request for user
                    if ($user->requestResetPassword()) {
                        $this->flash->success("Password Reset Link Sent To Your Email, Please Check Your Email");
                    } else {
                        $this->flash->error("Unable to send password reset link");
                    }
                }
            } else {
                // invalid request
            }
        }
        $this->view->form = $fr;
    }

    public function welcomeAction() {
        $this->view->firstName = $this->session->get("fname");
        $this->view->lastName = $this->session->get("lname");
    }

    public function listAction($page = 1) {


        // load the users
        $users = User::find();


        $numberPage = $page;

        // create paginator
        $paginator = new Paginator(array(
            "data" => $users,
            "limit" => 1,
            "page" => $numberPage
        ));
        $this->view->users = $paginator->getPaginate();
    }

    public function loginAction() {
        $lf = new LoginForm();
        $this->view->loginform = $lf;
        if ($this->request->isPost()) {
            if (!$lf->isValid($_POST)) {
                // invalid post
            } else {
                $email = $this->request->getPost("email");
                $password = $this->request->getPost("password");
                $user = User::Login($email, $password);
                if ($user) {
                    // set session
                    $user->setSession($this);

                    // set login for the user
                    $user->trackLogin($this->request->getUserAgent(), $_SERVER["REMOTE_ADDR"]);

                    // we need to log this action for the user
                    Userlog::byUserID($user->userid)->setAction("Login To System")->Create();

                    // go to welcome page
                    return $this->dispatcher->forward(array(
                                "controller" => "user",
                                "action" => "welcome"
                    ));
                } else {
                    // unabel to find the user
                    $this->flash->error("Unable to find user");
                }
            }
        }
    }

    /**
     * Index action
     */
    public function registerAction() {

        // create new login form
        $rf = new RegisterForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$rf->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                $user = new User();
                $user->fname = $this->request->getPost("firstname");
                $user->lname = $this->request->getPost("lastname");
                $user->gender = $this->request->getPost("gender");
                $user->email = $this->request->getPost("email");
                $user->password = $this->request->getPost("password");
                $user->level = USERLEVEL_USER;

                // check if we can save user
                if (!$user->create()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {
                    $user->showSuccessMessages($this, "User creating was successfull");
                }
            }
        }


        $this->view->registerform = $rf;
    }

    /**
     * Index action
     */
    public function indexAction() {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for user
     */
    public function searchAction() {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "User", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "userid";

        $user = User::find($parameters);
        if (count($user) == 0) {
            $this->flash->notice("The search did not find any user");

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $user,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Edits a user
     *
     * @param string $userid
     */
    public function editAction() {
        // create new login form
        $pef = new ProfileEditForm();
        if ($this->request->isPost()) {
            // user want to submit the post, validae the request
            if (!$pef->isValid($_POST)) {
                // invalid post
            } else {
                // valid post, we have to create new user based on the request
                $user = User::findFirst($this->session->get("userid"));
                $user->fname = $this->request->getPost("firstname");
                $user->lname = $this->request->getPost("lastname");
                $user->gender = $this->request->getPost("gender");

                // check if we can save user
                if (!$user->save()) {
                    // unable to save user
                    $user->showErrorMessages($this);
                } else {

                    // reset the session
                    $user->setSession($this);

//                    return $this->dispatcher->forward(array(
//                                "controller" => "user",
//                                "action" => "edit",
//                                "params" => array(
//                                    "success" => "1"
//                                )
//                    ));
                }
            }
        }


        $this->view->form = $pef;
    }

    /**
     * Creates a new user
     */
    public function createAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $user = new User();

        $user->fname = $this->request->getPost("fname");
        $user->lname = $this->request->getPost("lname");
        $user->gender = $this->request->getPost("gender");
        $user->imagelink = $this->request->getPost("imagelink");
        $user->regdate = $this->request->getPost("regdate");
        $user->active = $this->request->getPost("active");
        $user->verified = $this->request->getPost("verified");


        if (!$user->save()) {
            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "new"
            ));
        }

        $this->flash->success("user was created successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

    /**
     * Saves a user edited
     *
     */
    public function saveAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $userid = $this->request->getPost("userid");

        $user = User::findFirstByuserid($userid);
        if (!$user) {
            $this->flash->error("user does not exist " . $userid);

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        $user->fname = $this->request->getPost("fname");
        $user->lname = $this->request->getPost("lname");
        $user->gender = $this->request->getPost("gender");
        $user->imagelink = $this->request->getPost("imagelink");
        $user->regdate = $this->request->getPost("regdate");
        $user->active = $this->request->getPost("active");
        $user->verified = $this->request->getPost("verified");


        if (!$user->save()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "edit",
                        "params" => array($user->userid)
            ));
        }

        $this->flash->success("user was updated successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

    /**
     * Deletes a user
     *
     * @param string $userid
     */
    public function deleteAction($userid) {

        $user = User::findFirstByuserid($userid);
        if (!$user) {
            $this->flash->error("user was not found");

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "index"
            ));
        }

        if (!$user->delete()) {

            foreach ($user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                        "controller" => "user",
                        "action" => "search"
            ));
        }

        $this->flash->success("user was deleted successfully");

        return $this->dispatcher->forward(array(
                    "controller" => "user",
                    "action" => "index"
        ));
    }

}
