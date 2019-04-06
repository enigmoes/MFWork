<?php
class Security {
   /* CLASE DE SEGURIDAD */

   //Funcion que limpia una cadena
   public static function clean($string, $html = false) {
      $string = addslashes($string);
      $string = trim($string);
      if ($html === true) {
         $string = htmlspecialchars($string);
      }
      return $string;
   }

   //Funcion que retorna la IP desde la que se accede
   public static function getIp() {
      if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
         $ip = $_SERVER['HTTP_CLIENT_IP'];
      } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
         $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
         $ip = $_SERVER['REMOTE_ADDR'];
      }
      return $ip;
   }

   //Funcion que envia un email en caso de 3 intentos fallidos de login con enlace de recuperacion
   //e IP desde la que se accedio
   private static function sendFailMail($email, $enlace) {
      $mensaje = "<p>Hemos detectado varios intentos de login fallido desde la siguiente direccion IP: 
         <b>".Security::getIp()."</b></p>
         <p>Si no ha sido usted o no recuerda la contraseña puede cambiarla introduciendo el codigo de recuperacion 
         que vera en el siguiente <a href=".$enlace.">enlace</a></p>";
      $headers = "X-Mailer: PHP5\n";
      $headers .= 'MIME-Version: 1.0' . "\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $enviado = mail($email, 'Intento de Login | Bolsa de Empleo', $mensaje, $headers);
      return $enviado;
   }

   //Funcion que envia un mail de recuperacion
   private static function sendRecoverMail($email, $enlace) {
      $mensaje = "<p>Para recuperar la contraseña visite el siguiente <a href=".$enlace.">enlace</a></p>";
      $headers = "X-Mailer: PHP5\n";
      $headers .= 'MIME-Version: 1.0' . "\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $enviado = mail($email, 'Recuperacion de Contraseña | Bolsa de Empleo', $mensaje, $headers);
      return $enviado;
   }

   //Funcion para enviar mail
   public static function sendMail($email, $asunto, $message) {
      $headers = "X-Mailer: PHP5\n";
      $headers .= 'MIME-Version: 1.0' . "\n";
      $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
      $enviado = mail($email, $asunto, $message, $headers);
      return $enviado;
   }

   //Funcion que genera una cadena aleatoria con la longitud indicada
   public static function genCad($long) {
      $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      $cad = "";
      for($i = 0; $i < $long; $i++) {
         $cad .= substr($char, rand(0,62), 1);
      }
      return $cad;
   }

   //Funcion que genera un token para un usuario
   public static function getToken($user, $password) {
      return base64_encode($user.'::'.$password);
   }

   //Funcion que retorna el usuario para el que se genero el token
   public static function getTokenUser($token) {
      $data = explode('::', base64_decode($token));
      return $data[0];
   }

   //Funcion que retorna la url desde la que se accede una la pagina
   public static function getUri() {
      $uri = "";
      if(isset($_SERVER['HTTPS'])) {
         $uri = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
      } else {
         $uri = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
      }
      $uri = explode('?', $uri);
      return $uri[0];
   }

   //Funcion que envia un mail de recuperacion normal o de tipo fallo en caso de que sea un atacante
   public static function sendRecover($user, $password, $email, $fail = false) {
      $token = Security::getToken($user, $password);
      if($fail) {
         $enviado = Security::sendFailMail($email, Security::getUri().'?controller=recover&action=check&token='.$token);
      } else {
         $enviado = Security::sendRecoverMail($email, Security::getUri().'?controller=recover&action=check&token='.$token);
      }
      return $enviado;
   }

}