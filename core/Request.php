<?php
class Request {
   /* CLASE QUE RETORNA UN VALOR DE UN REQUEST */

   //Funcion que establace un valor concreto de un request
   public static function set($nombre, $valor) {
      $_REQUEST[$nombre] = $valor;
   }

   //Funcion que retorna el valor de un request
   public static function get($nombre) {
      return $_REQUEST[$nombre];
   }

   //Funcion que establace un valor de $_POST
   public static function setPOST($nombre, $valor) {
      $_POST[$nombre] = $valor;
   }

   //Funcion que retorna un valor de $_POST
   public static function getPOST($nombre) {
      return $_POST[$nombre];
   }

   //Funcion que establece un valor de $_GET
   public static function setGET($nombre, $valor) {
      $_GET[$nombre] = $valor;
   }

   //Funcion que retorna un valo de $_GET
   public static function getGET($nombre) {
      return $_GET[$nombre];
   }

   //Funcion que establece un valor de $_FILES
   public static function setFile($nombre, $valor) {
      $_FILES[$nombre] = $valor;
   }

   //Funcion que retorna un valo de $_FILES
   public static function getFile($nombre) {
      return $_FILES[$nombre];
   }

}