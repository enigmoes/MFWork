<?php

class Router
{
   //Funcion para contruir rutas de controllador
   public static function connect($route, $defaults = [])
   {
      //Si no existe el controlador por defecto
      if (!isset($defaults['controller'])) {
         define('DEFAULT_CONTROLLER', 'main');
      } else {
         define('DEFAULT_CONTROLLER', $defaults['controller']);
      }
      //Si no existe la accion por defecto
      if (!isset($defaults['action'])) {
         define('DEFAULT_ACTION', 'index');
      } else {
         define('DEFAULT_ACTION', $defaults['action']);
      }
   }

   //Funcion que envia una peticion a un controlador y accion
   public static function url($route)
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
}