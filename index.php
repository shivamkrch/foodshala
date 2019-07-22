<?php
require_once __DIR__.'/vendor/autoload.php';

$router = new Klein\Klein();

$router->respond('GET','/',function($req, $res, $service){
    $service->render(__DIR__.'/templates/pages/home.php');
});

$router->dispatch();