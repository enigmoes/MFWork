<?php

class Model
{
   //Atributos del modelo base
   private $tabla;
   private $db;
   private $cnx;

   //Inicializamos con el nombre de la tabla y el adaptador
   public function __construct($tabla)
   {
      $this->tabla = (string)$tabla;
   }

   //Funcion que inicia la conexion
   public function initCnx()
   {
      $this->cnx = new Conect();
      $this->db = $this->cnx->getConexion();
   }

   /* FUNCIONES DE CONSULTAS GENERICAS */
   public function getAll()
   {
      $this->initCnx();

      $result = array();
      $query = $this->db->query("SELECT * FROM $this->tabla");

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function getBy($column, $value)
   {
      $this->initCnx();

      $result = array();
      $query = $this->db->query("SELECT * FROM $this->tabla WHERE $column = '" . $value . "'");

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function getBy2($column1, $value1, $column2, $value2)
   {
      $this->initCnx();

      $result = array();
      $query = $this->db->query("SELECT * FROM $this->tabla WHERE $column1 = '" . $value1 . "' AND $column2 = '" . $value2 . "'");

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function deleteBy($column, $value)
   {
      $this->initCnx();

      $query = $this->db->query("DELETE FROM $this->tabla WHERE $column = '" . $value . "'");
      return $query;
   }

   public function updateBy($id, $idValue, $column, $value)
   {
      $this->initCnx();

      $query = $this->db->query("UPDATE $this->tabla SET $column = '" . $value . "' WHERE $id = '" . $idValue . "'");
      return $query;
   }

   /* FUNCION DE CONSULTA PERSONALIZADA */
   public function execSql($query)
   {
      $this->initCnx();

      $result = array();
      $query = $this->db->query($query);

      if ($query) {
         if ($query->num_rows > 1) {
            while ($row = $query->fetchObject()) {
               $result[] = $row;
            }
         } else if ($query->num_rows == 1) {
            if ($row = $query->fetchObject()) {
               $result = $row;
            }
         } else {
            $result = false;
         }
      } else {
         $result = false;
      }

      return $result;
   }
}