<?php

class FrontController
{
   private $controller;
   private $action;

   public function main()
   {
      $this->setParams();

      if (!empty($this->controller)) {
         $controllerObj = $this->loadController($this->controller);
         FrontController::launchAction($controllerObj);
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
   public function loadAction($controllerObj, $action)
   {
      $controllerObj->$action();
   }

   //Funcion que lanza la accion en el controlador seleccionado
   public function launchAction($controllerObj)
   {
      if (!empty($this->action) && method_exists($controllerObj, $this->action)) {
         $this->loadAction($controllerObj, $this->action);
      } else {
         $this->loadAction($controllerObj, DEFAULT_ACTION);
      }
   }

   //Obtener controlador y accion
   public function setParams() {
      if (!empty($_GET)) {
         $this->controller = key($_GET);
         $this->action = reset($_GET);
      }
   }
}
