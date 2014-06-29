<?php
    require 'Slim/Slim.php';
    require 'telemetry.php';
    
    \Slim\Slim::registerAutoloader();
    
    // create the slim router
    $app = new Slim(
        array(
            'debug' => true
        )
    );
    
    /* telemetry functions */
    $app->post('/telemetry', telemetry_handle_post);
    
    /* run the slim app */
    $app->run();
    
?>