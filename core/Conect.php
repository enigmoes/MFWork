<?php
class Conect {
   //Atributos de conexion a la db
   private $driver;
   private $host;
   private $port;
   private $db;
   private $user;
   private $pass;
   private $charset;

   //Inicializacion de los atributos de conexion con los datos de Database.php
   public function __construct() {
      $db_conf = Database::$config;
      $this->driver = $db_conf['driver'];
      $this->host = $db_conf['host'];
      $this->user = $db_conf['user'];
      $this->pass = $db_conf['pass'];
      $this->db = $db_conf['db'];
      $this->charset = $db_conf['charset'];
   }

   //Funcion que retorna la conexion a la base de datos
   public function getConexion() {
      $cnx = false;
      try {
         if($this->driver == "mysql" || $this->driver == "pgsql") {
            $cnx = new PDO($this->driver.":host=".$this->host.";port=".$this->port.";dbname=".$this->db, $this->user, $this->pass);
            $cnx->query("SET NAMES '".$this->charset."'");
         } else if($this->driver == "sqlite") {
            $cnx = new PDO($this->driver.":".$this->db);
            $cnx->query("SET NAMES '".$this->charset."'");
         }
      } catch (PDOException $e) {
         echo "Fallo la conexion con la db";
      }
      return $cnx;
   }

   //Funcion que retorna el numero de tablas en la db
   public static function getNumTables($adapter) {
      $result = array();
      $query = @$adapter->query("SHOW TABLES");
      $adapter = null;
      while($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }
}