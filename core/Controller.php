<?php

class Controller
{
   public $request;
   public $model;

   //Controlador principal
   public function __construct()
   {
      //Incluimos clases necesarias para funcionar
      require_once APP_PATH . 'Database' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Auth' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Conect' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Model' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Request' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Security' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Session' . CONTROLLER_EXT;
      require_once CORE_PATH . 'Validate' . CONTROLLER_EXT;

      //Inicamos session
      Session::start();

      //Recorremos todos los modelos y los incluimos tambien
      foreach (glob(MODEL_PATH . '*.php') as $file) {
         require_once $file;
      }

      //Establecemos request
      $this->setRequest();

      //Creamos atributo dinamico
      $className = str_replace(CONTROLLER_PART, '', get_called_class());
      $this->$className = new $className;
   }

   //Funcion que carga una vista con los datos pasados
   public function view($vista, $datos = [], $layout = '')
   {
      //Si no exite layout
      if (empty($layout)) {
         $layout = LAYOUT_PATH . 'default' . DS . 'default' . VIEW_EXT;
      } else {
         if (is_file(LAYOUT_PATH . $layout)) {
            $layout = LAYOUT_PATH . basename($layout . VIEW_EXT);
         } else {
            trigger_error('No existe el layout');
         }
      }

      //Clase desde la que se llama a la vista
      $className = str_replace(CONTROLLER_PART, '', get_called_class());

      //Incluimos la clase helper que nos valdra para redireccionar las
      //peticiones de una forma mas amigable
      require_once CORE_PATH . 'Helper' . CONTROLLER_EXT;
      $this->helper = new Helper($className, $vista, $datos);

      //Incluimos la vista seleccionada
      require_once $layout;
   }

   //Funcion que redirecciona a un controlador y a una accion
   public function redirect($route)
   {
      header('Location: ' . $route);
   }

   //Returns a request data
   public function setRequest() {
      $num = 0;
      //Recorremos apartir de la segunda query
      foreach ($_REQUEST as $key => $request) {
         if ($num != 0) {
            $this->request['data'][$key] = $request;
         }
         $num++;
      }
   }
}