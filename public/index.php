<?php

use Phalcon\Exception;
use Phalcon\Loader;
use Phalcon\Mvc\Application;

error_reporting(E_ALL);
try {

    /**
     * Include services
     */
    require __DIR__ . '/../config/services.php';
    require __DIR__ . '/../vendor/autoload.php';

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);


    // Load some items
    // Creates the autoloader
    $loader = new Loader();

    //Set file extensions to check
    $loader->setExtensions(array("php"));


    //Register some namespaces
    $loader->registerNamespaces(
            array(
                "Simpledom\Core" => dirname(__DIR__) . "/apps/frontend/core/",
                "Simpledom\Core" => dirname(__DIR__) . "/apps/frontend/core/form/",
            //"Simpledom\Core" => dirname(__DIR__) . "/apps/frontend/core/model/",
            )
    );


    // Register some directories
    $loader->registerDirs(
            array(
                dirname(__DIR__) . "/apps/frontend/core/",
                dirname(__DIR__) . "/apps/frontend/core/form/",
                dirname(__DIR__) . "/apps/frontend/models/",
            )
    );


    $eventsManager = new \Phalcon\Events\Manager();

    //Listen all the loader events
    $eventsManager->attach('loader', function($event, $loader) {
        if ($event->getType() == 'beforeCheckPath') {
            // var_dump($loader->getCheckedPath());
        }
    });

    $loader->setEventsManager($eventsManager);

    // register autoloader
    $loader->register();

    /**
     * Include modules
     */
    require __DIR__ . '/../config/modules.php';

    echo $application->handle()->getContent();


    //Get the generated profiles from the profiler
    $profiles = $di->get('profiler')->getProfiles();
    if (isset($profiles)) {
        foreach ($profiles as $profile) {
//        var_dump("SQL Statement: ", $profile->getSQLStatement());
//        echo("Start Time: " . $profile->getInitialTime());
//        echo("Final Time: " . $profile->getFinalTime());
//        echo("Total Elapsed Time: " . $profile->getTotalElapsedSeconds());
//        echo "<br/>";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
