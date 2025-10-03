<?php
declare(strict_types = 1);

// Separador directorios
define('DS', '/');

/**
 * Definicion constantes rutas
 */
// Root directory
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . DS);

// Base directories
define('CONTROLLER_PATH', ROOT_PATH . 'controller' . DS);
define('MODEL_PATH', ROOT_PATH . 'model' . DS);
define('TEMPLATE_PATH', ROOT_PATH . 'templates' . DS);
define('APP_PATH', ROOT_PATH . 'app' . DS);
define('CORE_PATH', ROOT_PATH . 'src' . DS);

// Core directories
define('CORE_AUTH_PATH', CORE_PATH . 'Auth' . DS);
define('CORE_CONTROLLER_PATH', CORE_PATH . 'Controller' . DS);
define('CORE_DATABASE_PATH', CORE_PATH . 'Database' . DS);
define('CORE_MODEL_PATH', CORE_PATH . 'Model' . DS);
define('CORE_UTILS_PATH', CORE_PATH . 'Utils' . DS);
define('CORE_VIEW_PATH', CORE_PATH . 'View' . DS);

// Public directories
define('WWW_PATH', 'www' . DS);
define('JS_PATH', DS . WWW_PATH . 'js' . DS);
define('CSS_PATH', DS . WWW_PATH . 'css' . DS);
define('LAYOUT_PATH', TEMPLATE_PATH . '_layout' . DS);

// Default Layout
define('DEFAULT_LAYOUT', TEMPLATE_PATH . '_layout' . DS);

// Extensions
define('CONTROLLER_EXT', '.php');
define('TEMPLATE_EXT', '.phtml');

// Others
define('CONTROLLER_PART', 'Controller');


// Importamos ficheros de la aplicación
require_once APP_PATH . 'Routes' . CONTROLLER_EXT;
require_once APP_PATH . 'Constants' . CONTROLLER_EXT;

// Importamos Database
require_once APP_PATH . 'Database' . CONTROLLER_EXT;
require_once CORE_DATABASE_PATH . 'Conector' . CONTROLLER_EXT;

// Importamos Auth
require_once CORE_AUTH_PATH . 'Auth' . CONTROLLER_EXT;
require_once CORE_AUTH_PATH . 'PasswordHasher' . CONTROLLER_EXT;
require_once CORE_AUTH_PATH . 'Session' . CONTROLLER_EXT;

// Importamos Model
require_once CORE_MODEL_PATH . 'Table' . CONTROLLER_EXT;
require_once CORE_MODEL_PATH . 'Model' . CONTROLLER_EXT;

// Importamos Controller
require_once CORE_CONTROLLER_PATH . 'Request' . CONTROLLER_EXT;

// Importamos Utils
require_once CORE_UTILS_PATH . 'Debugguer' . CONTROLLER_EXT;
require_once CORE_UTILS_PATH . 'Tools' . CONTROLLER_EXT;
require_once CORE_UTILS_PATH . 'Validate' . CONTROLLER_EXT;

// Importamos View
require_once CORE_VIEW_PATH . 'Flash' . CONTROLLER_EXT;
