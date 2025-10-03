<?php
class Validate {
   private $data;
   private $errors;
   private $response;
   private $rules;

   public function __construct() {
      $this->data = array();
      $this->errors = array();
      $this->response = array();
      $this->rules = array('notEmpty','validDoc','lengPass','validEmail','validTel');
   }

   /* Añadir valor y regla */
   public function add($nombre, $regla, $message, $select = false) {
      $this->data[$nombre] = array("rule"=>$regla, "message"=>$message, "select"=>$select);
   }

   //Funcion para validar todas la reglas
   public function validar() {
      foreach ($this->data as $key => $value) {
         foreach ($this->rules as $rule) {
            if($value['rule'] == $rule) {
               if($value['select']) {
                  @$this->response[$_REQUEST[$key]] = 'selected';
               } else {
                  @$this->response[$key] = $_REQUEST[$key];
               }
               @$result = $this->$rule($_REQUEST[$key]);
               if(!$result) {
                  if($key == 'g-recaptcha-response') {
                     $this->errors["errCaptcha"] = $value['message'];
                     $this->response["errCaptcha"] = $value['message'];
                  } else {
                     $this->errors["err".ucfirst($key)] = $value['message'];
                     $this->response["err".ucfirst($key)] = $value['message'];
                  }
               }
            }
         }
      }
   }

   //Funcion que comprueba que no existan errores
   public function isValid() {
      $valid = false;
      if(count($this->errors) == 0) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion que retorna los errores y valores de request
   public function getResponse() {
      return $this->response;
   }

   /* ESPECIAL COMPARADOR */
   public function compareTo($cad1, $cad2, $message) {
      if($_REQUEST[$cad1] != $_REQUEST[$cad2]) {
         $this->errors["err".ucfirst($cad1)] = $message;
         $this->response["err".ucfirst($cad1)] = $message;
         $this->response[$cad1] = $_REQUEST[$cad1];
         $this->response[$cad2] = $_REQUEST[$cad2];
      }
   }

   /* Definicion de reglas */
   //Funcion que comprueba que no este vacio
   public function notEmpty($valor) {
      $valid = false;
      if(!empty($valor)) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion que valida un documento de identificacion
   public function validDoc($doc) {
      $valid = false;
      if($this->validNIF($doc) || $this->validNIE($doc)) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion para validar nie
   function validNIE($nie) {
      $valid = false;
      $letra = substr($nie, -1);
      $control = strtoupper(substr($nie, 0, 1));
      if($control == 'X') {
         $control = 0;
      } else if ($control == 'Y') {
         $control = 1;
      } else if($control == 'Z') {
         $control = 2;
      }
      $numeros = (integer)substr($nie, 1, -1);
      $vLetra = substr("TRWAGMYFPDXBNJZSQVHLCKE", ($control + $numeros) % 23, 1);
      if($vLetra == $letra && strlen($numeros) == 7) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion para validar nif
   public function validNIF($nif) {
      $valid = false;
      $letra = substr($nif, -1);
      $numeros = substr($nif, 0, -1);
      $vLetra = substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros%23, 1);
      if($vLetra == $letra && strlen($numeros) == 8 ) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion que comprueba que la longitud minima de la password sea 6
   public function lengPass($pass) {
      $valid = false;
      if(strlen($pass) >= 6) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion que comprueba si el mail tiene un formato valido
   public function validEmail($email) {
      $valid = false;
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
         $valid = true;
      }
      return $valid;
   }

   //Funcion que comprueba si es un numero de telefono valido
   public function validTel($tel) {
      $valid = false;
      if(filter_var($tel, FILTER_VALIDATE_INT)) {
         if(strlen($tel) == 9) {
            $valid = true;
         }
      }
      return $valid;
   }

}