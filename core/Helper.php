<?php

class Helper
{
   private $className;
   private $view;
   private $data;

   public function __construct($className = '', $view = '', $data = [])
   {
      $this->className = $className;
      $this->view = $view;
      $this->data = $data;
   }

   //Funcion que envia una peticion a un controlador y accion
   public function url($route)
   {
      //Si no es un array
      if (!is_array($route) && !isset($route['controller']) && !isset($route['action'])) {
         return trigger_error('Url no valida');
      }

      //Si tiene parametros
      if (isset($route['?'])) {
         $query = http_build_query($route['?']);
         $urlString = DS . $route['controller'] . DS . $route['action'] . '?' . $query;
      } else {
         $urlString = DS . $route['controller'] . DS . $route['action'];
      }
      return $urlString;
   }

   //Funcion que retorna la url de un fichero de javascript
   public function js($file)
   {
      $path = str_replace('/', DS, $file);
      return '<script src="' . JS_PATH . $path . '"></script>';
   }

   //Funcion que retorna la url de un fichero de javascript
   public function css($file)
   {
      $path = str_replace('/', DS, $file);
      return '<link rel="stylesheet" href="' . CSS_PATH . $path . '">';
   }

   //Funcion que carga el contenido de la vista
   public function content($content = '')
   {
      //Si el content no esta vacio
      if (!empty($content)) {
         $this->helper = new Helper();

         require VIEW_PATH . $content . VIEW_EXT;
      } else {
         //Cargamos cada valor en una variable simple
         foreach ($this->data as $clave => $valor) {
            ${$clave} = $valor;
         }

         $this->helper = new Helper();

         require VIEW_PATH . $this->className . DS . $this->view . VIEW_EXT;
      }
   }
}