<?php

//Incluimos el front
require '../app/Bootstrap.php';
require CORE_PATH . 'FrontController.php';

$fronController = new FrontController(); //Iniciamos main del front
$fronController->main();