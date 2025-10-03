<?php
declare (strict_types = 1);

class FrontController
{
   public $controller;
   public $action;
   public $params;

   public function main()
   {
      $this->setParams();

      if (!empty($this->controller)) {
         $controllerObj = $this->loadController($this->controller);
         $this->launchAction($controllerObj);
      } else {
         $controllerObj = $this->loadController(DEFAULT_CONTROLLER);
         $this->launchAction($controllerObj);
      }
   }

   //Funcion que carga el controlador pasado por parametro
   public function loadController($controller)
   {
      if (!is_file(CONTROLLER_PATH . ucwords($controller) . CONTROLLER_PART . CONTROLLER_EXT)) {
         trigger_error('No existe el controlador');
      }

      require_once(CONTROLLER_PATH . basename(ucwords($controller) . CONTROLLER_PART . CONTROLLER_EXT));
      $controller = ucwords($controller) . CONTROLLER_PART;
      $controllerObj = new $controller();
      return $controllerObj;
   }

   //Funcion que carga la accion pasada por parametro
   public function loadAction($controllerObj, $action, $params = null)
   {
      if (is_null($params)) {
         $controllerObj->$action();
      } else {
         $controllerObj->$action(...$params);
      }
   }

   //Funcion que lanza la accion en el controlador seleccionado
   public function launchAction($controllerObj)
   {
      if (!empty($this->action) && method_exists($controllerObj, $this->action)) {
         if (!empty($this->params) && is_array($this->params)) {
            $this->loadAction($controllerObj, $this->action, $this->params);
         } else {
            $this->loadAction($controllerObj, $this->action);
         }
      } else {
         $this->loadAction($controllerObj, DEFAULT_ACTION);
      }
   }

   //Obtener controlador y accion
   public function setParams() {
      // if (!empty($_GET)) {
      //    $this->controller = $_GET['controller'];
      //    $this->action = $_GET['action'];
      //    if (!is_null($_GET['params']) && !empty($_GET['params'])) {
      //       $this->params = explode('/', $_GET['params']);
      //    } else {
      //       $this->params = NULL;
      //    }
      // }
      // Separamos la URL $uri[0] de la query $uri[1]
      $uri = explode('?', $_SERVER['REQUEST_URI']);
      // Comprobamos que URL no este vacio
      if (isset($uri[0]) && !empty($uri[0])) {
         // Procesamos URL $uri[0]
         $url = array_values(array_filter(explode('/', $uri[0])));
         // Comprobamos que URL no este vacio
         if (!empty($url)) {
            // Asignamos controlador $url[0]
            if (isset($url[0]) && !empty($url[0])) {
               $this->controller = $url[0];
            }
            // Asignamos action $url[1]
            if (isset($url[1]) && !empty($url[1])) {
               $this->action = $url[1];
            }
            // Extraemos parametros
            $params = array_slice($url, 2, count($url));
            // Asignamos parametros
            if (!empty($params)) {
               $this->params = $params;
            }
         }
      }
   }
}
