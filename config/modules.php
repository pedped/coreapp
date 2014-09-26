<?php

$application->registerModules(
        array(
            'frontend' => array(
                'className' => 'Simplemod\Frontend\Module',
                'path' => '../apps/frontend/Module.php',
            ),
            'admin' => array(
                'className' => 'Simplemod\Admin\Module',
                'path' => '../apps/admin/Module.php',
            )
        )
);
