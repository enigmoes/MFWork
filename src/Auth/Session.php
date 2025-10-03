<?php
class Session {
   /* CLASE PARA EL MANEJO DE SESIONES */

   //Funcion para iniciar sesiones
   public static function start() {
      @session_set_cookie_params(0, './', $_SERVER['HTTP_HOST'], false, true);
      @session_start();
   }

   //Funcione que retorna el valor de una sesion
   public static function read($name) {
      if(isset($_SESSION[$name])) {
         $value = $_SESSION[$name];
      } else {
         $value = false;
      }
      return $value;
   }

   //Funcion que establece una sesion con sus valores
   public static function write($name, $data) {
      $_SESSION[$name] = $data;
   }

   //Funcion que elimina un indice del array de sesiones
   public static function delete($name) {
      unset($_SESSION[$name]);
   }

   //Funcion que elimina todas las sessiones
   public static function destroy() {
      @session_destroy();
   }

}