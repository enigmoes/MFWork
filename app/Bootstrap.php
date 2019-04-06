<?php

//Separador de directorios
define('DS', DIRECTORY_SEPARATOR);

//Definicion de constantes
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . DS);
define('CONTROLLER_PATH', ROOT_PATH . 'controller' . DS);
define('MODEL_PATH', ROOT_PATH . 'model' . DS);
define('VIEW_PATH', ROOT_PATH . 'view' . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('CORE_PATH', ROOT_PATH . 'core' . DS);
define('WWW_PATH', 'wwwroot' . DS);
define('JS_PATH', DS . WWW_PATH . 'js' . DS);
define('CSS_PATH', DS . WWW_PATH . 'css' . DS);
define('LAYOUT_PATH', ROOT_PATH . 'layout' . DS);

//Definimos layout
define('DEFAULT_LAYOUT', ROOT_PATH . 'layout' . DS);
define('CONTROLLER_EXT', '.php');
define('CONTROLLER_PART', 'Controller');
define('VIEW_EXT', '.phtml');


//Incluimos ficheros esenciales
require APP_PATH . 'Constants' . CONTROLLER_EXT;
require APP_PATH . 'Routes' . CONTROLLER_EXT;
require CORE_PATH . 'Controller' . CONTROLLER_EXT;

//Funcion debug
function debug($data) {
   echo "<pre>";
   print_r($data);
   echo "</pre>";
}