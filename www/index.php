<?php
declare(strict_types = 1);

// Incluimos el front
require_once '../app/Bootstrap.php';

// Importamos controladores
require_once CORE_CONTROLLER_PATH . 'Controller' . CONTROLLER_EXT;
require_once CORE_CONTROLLER_PATH . 'FrontController' . CONTROLLER_EXT;

$fronController = new FrontController(); // Iniciamos main del front
$fronController->main();