<?php
class Auth {
   //Atributos de autenticacion
   private $entity;
   private $adapter;
   private $user;
   private $userCol;
   private $pass;
   private $passCol;

   //Inicializamos la entidad y el adaptador de la conexion
   public function __construct($entity, $adapter) {
      $this->entity = (string)$entity;
      $this->adapter = $adapter;
   }

   //Inicializar el usuario
   public function postUser($col, $user) {
      $this->user = (string)$user;
      $this->userCol = (string)$col;
   }

   //Obtener el usuario
   public function getUser() {
      return $this->user;
   }

   //Inicializar la password
   public function postPass($col, $pass) {
      $this->pass = (string)$pass;
      $this->passCol = (string)$col;
   }

   //Obtener la password
   public function getPass() {
      return $this->pass;
   }

   //Funcion que verifica si existe el usuario
   public function checkUser() {
      $check = false;
      $user = new $this->entity($this->adapter);
      $usuario = $this->user;
      if(count($user->getBy($this->userCol, $usuario)) == 1) {
         $check = true;
      }
      return $check;
   }

   //Funcion que verifica si el usuario conincide con las password
   public function checkPass() {
      $check = false;
      $user = new $this->entity($this->adapter);
      $password = $this->pass;
      if(count($user->getBy2($this->userCol, $this->user, $this->passCol, $password)) == 1) {
         $check = true;
      }
      return $check;
   }

}