<?php

$application->registerModules(
        array(
            'frontend' => array(
                'className' => 'Simpledom\Frontend\Module',
                'path' => '../apps/frontend/Module.php',
            ),
            'admin' => array(
                'className' => 'Simpledom\Admin\Module',
                'path' => '../apps/admin/Module.php',
            )
        )
);
