<?php
class Request
{
   public String $token;
   /* CLASE QUE RETORNA UN VALOR DE UN REQUEST */

   //Controlador principal
   public function __construct() {
      // Generamos token
      $this->setRequestToken();
   }

   public function middleware() {
      // Check token
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && $this->token != $_REQUEST['post_token']) {
         throw new Exception('petición no autorizada.'); die();
      }
   }

   public function is($type) {
      try {
         $this->middleware();
      } catch (Exception $e) {
         echo 'Exception: ',  $e->getMessage(), "\n";
      }
      return $_SERVER['REQUEST_METHOD'] == $type;
   }

   //Funcion que establace un valor concreto de un request
   public function set($key, $value) {
      $_REQUEST[$key] = $value;
   }

   //Funcion que retorna el valor de un request
   public function get($key) {
      $request = false;
      if (is_null($key)) {
         $request = $_REQUEST;
      } elseif (isset($_REQUEST[$key])) {
         $request = $_REQUEST[$key];
      }
      return $request;
   }

   //Funcion que establace un valor de $_POST
   public function setData($key, $value) {
      $_POST[$key] = $value;
   }

   //Funcion que retorna un valor de $_POST
   public function getData($key = null) {
      $data = false;
      if (is_null($key)) {
         $data = $_POST;
      } elseif (isset($_POST[$key])) {
         $data = $_POST[$key];
      }
      return $data;
   }

   //Funcion que establece un valor de $_GET
   public function setQuery($key, $value) {
      $_GET[$key] = $value;
   }

   //Funcion que retorna un valo de $_GET
   public function getQuery($key = null) {
      $query = false;
      if (is_null($key)) {
         $query = $_GET;
      } elseif (isset($_GET[$key])) {
         $query = $_GET[$key];
      }
      return $query;
   }

   //Funcion que establece un valor de $_FILES
   public function setFile($key, $v) {
      $_FILES[$key] = $value;
   }

   //Funcion que retorna un valo de $_FILES
   public function getFile($key) {
      $files = false;
      if (is_null($key)) {
         $files = $_FILES;
      } elseif (isset($_FILES[$key])) {
         $files = $_FILES[$key];
      }
      return $files;
   }

   // Función que establece el token de la request
   public function setRequestToken() {
      if ($_SERVER['REQUEST_METHOD'] == 'GET') {
         // Establacemos token
         $this->token = Tools::getToken(64);
         // Guardamos token en sesión
         Session::write('request_token', $this->token);
      } else {
         $this->token = Session::read('request_token');
      }
   }

}