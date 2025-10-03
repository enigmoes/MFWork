<?php
require_once CORE_CONTROLLER_PATH . 'Router' . CONTROLLER_EXT;

//Archivos de rutas
Router::connect('/', ['controller' => 'main', 'action' => 'index']);