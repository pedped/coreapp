<?php

namespace Simplemod\Admin;

use Phalcon\Loader;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

class Module implements ModuleDefinitionInterface {

    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders() {

        $loader = new Loader();

        $loader->registerNamespaces(
                array(
                    'Simplemod\Admin\Controllers' => __DIR__ . '/controllers/',
                    'Simplemod\Core' => dirname(__DIR__) . '/frontend/core/',
                    'Simplemod\Models' => dirname(__DIR__) . '/frontend/models/',
                    'Simplemod\Admin\Models' => __DIR__ . '/models/',
                )
        );

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices($di) {


        $config = require_once 'config/config.php';


        //Registering a dispatcher
        $di->set('dispatcher', function() {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace("Simplemod\Admin\Controllers");
            return $dispatcher;
        });


        //Registering the view component
        $di->set('view', function() {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');
            return $view;
        });


        $loader = new Loader();

        /**
         * We're a registering a set of directories taken from the configuration file
         */
        $loader->registerDirs(
                array(
                    __DIR__ . '\\component\\',
                    __DIR__ . '\\models\\',
                    __DIR__ . '\\controllers\\',
                    dirname(__DIR__) . '\\frontend\\core\\',
                    dirname(__DIR__) . '\\frontend\\models\\',
                )
        )->register();


        $di->set('profiler', function() {
            return new \Phalcon\Db\Profiler();
        }, true);



        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        $di->set('db', function () use ($config) {
            return new DbAdapter(array(
                'host' => $config->database->host,
                'username' => $config->database->username,
                'password' => $config->database->password,
                'dbname' => $config->database->dbname
            ));
        });



        $di->set('url', function() {
            $url = new Url();
            $url->setBaseUri('/simplemod/admin/');
            return $url;
        });


        //$di['router']->setDefaultNamespace("Simplemod\Admin\Controllers");
    }

}
