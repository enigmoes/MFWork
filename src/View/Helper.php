<?php

class Helper extends Controller
{
   public $className;
   public $template;
   public $data;
   public $fetch;

   public function __construct($className = '', $template = '', $data = [])
   {
      $this->className = $className;
      $this->template = $template;
      $this->data = $data;
   }

   //Funcion que envia una peticion a un controlador y accion
   public function url($route)
   {
      $urlString = '';

      //Si no es un array
      if (!is_array($route) && !isset($route['controller'])) {
         return trigger_error('Url no valida');
      }

      if(!isset($route['action'])) {
         $urlString = DS . $route['controller'];
      } else {
         $urlString = DS . $route['controller'] . DS . $route['action'];
      }
      
      if (isset($route[0])) {
         for ($i = 0; $i < count($route) - 1; $i++) {
            if (isset($route[$i])) {
            // if (!in_array($route[$i], ['controller', 'action'])) {
               $urlString .= DS . $route[$i];
            // }
            }
         }
      }

      //Si tiene parametros
      if (isset($route['?'])) {
         $query = http_build_query($route['?']);
         $urlString .= '?' . $query;
      }
      return $urlString;
   }

   //Funcion que retorna la url de un fichero de javascript
   public function js($file, $type = NULL)
   {
      $path = str_replace('/', DS, $file);
      if (is_null($type)) {
         return '<script src="' . JS_PATH . $path . '"></script>';
      } else {
         $this->fetch[$type][] = '<script src="' . JS_PATH . $path . '"></script>';
      }
   }

   //Funcion que retorna la url de un fichero de javascript
   public function css($file, $type = NULL)
   {
      $path = str_replace('/', DS, $file);
      if (is_null($type)) {
         return '<link rel="stylesheet" href="' . CSS_PATH . $path . '">';
      } else {
         $this->fetch[$type][] = '<link rel="stylesheet" href="' . CSS_PATH . $path . '">';
      }
   }

   //Funcion que carga el contenido de la vista
   public function content($content = '')
   {
      // Establecemos helper
      $this->Helper = $this;

      // Establecemos request
      $this->request = new Request();

      //Cargamos cada valor en una variable simple
      foreach ($this->data as $clave => $valor) {
         ${$clave} = $valor;
      }

      //Si el content no esta vacio
      if (!empty($content)) {
         require TEMPLATE_PATH . $content . TEMPLATE_EXT;
      } else {
         require TEMPLATE_PATH . $this->className . DS . $this->template . TEMPLATE_EXT;
      }
   }

   // Funcion fetch
   public function fetch($type)
   {
      $fetch = '';
      if (!is_null($this->fetch)) {
         foreach ($this->fetch[$type] as $element) {
            $fetch .= $element . PHP_EOL;
         }
      }
      return $fetch;
   }
}