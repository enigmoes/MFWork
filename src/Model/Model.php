<?php
declare (strict_types = 1);

class Model extends Table
{
   //Atributos del modelo base
   protected String $table;
   protected String $primaryKey;

   public function __construct()
   {
      parent::__construct();
   }

   public function newEmptyEntity()
   {
      $class = get_class($this);
      return new $class;
   }

   public function patchEntity(Model $class, array $data)
   {
      // Comprobamos si existe la tabla y no esta vacia
      if (isset($data[$class->table]) && !empty($data[$class->table])) {
         // Recorremos valores de la tabla en el request y asignamos al objeto
         foreach($data[$class->table] as $key => $value) {
            if (property_exists($class, $key)) {
               $class->{$key} = $value;
            }
         }
      }
      return $class;
   }

   // Función para guardar contenido
   public function save()
   {
      $query = null;
      $qColumns = '';
      $qvalues = '';

      // Obtenemos atributos del objeto invocado
      $fields = \Closure::fromCallable("get_object_vars")->__invoke($this);

      // Extraemos columnas, recorremos y construimos query
      $columns = array_keys($fields);
      foreach ($columns as $column) {
         if ($column == end($columns)) {
            $qColumns .= '`'. $column .'`';
         } else {
            $qColumns .= '`'. $column .'`, ';
         }
      }

      // Extraemos valores, recorremos y construimos query
      $values = array_values($fields);
      foreach ($values as $value) {
         if ($value == end($values)) {
            $qvalues .= "'". $value ."'";
         } else {
            $qvalues .= "'". $value ."', ";
         }
      }

      // Execute query string
      try {
         $query = $this->db->query('INSERT INTO `'. $this->table .'` ('. $qColumns .') VALUES ('. $qvalues .')');
         // Mensaje OK
      } catch (PDOException $e) {
         echo $e->getMessage();
      }
   }

   // Función para establacer tabla
   public function setTable(String $table)
   {
      if (!empty($table)) {
         $this->table = $table;
      }
   }

   // Función para establecer clave primaria
   public function setPrimarykey(String $key)
   {
      if (!empty($key)) {
         $this->primaryKey = $key;
      }
   }

   /* FUNCIONES DE CONSULTAS GENERICAS */
   public function getAll()
   {
      $result = [];
      $query = $this->db->query("SELECT * FROM $this->table");

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function getBy($column, $value)
   {
      $result = [];
      $query = $this->db->query("SELECT * FROM $this->table WHERE $column = '" . $value . "'");

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function find($fields = [])
   {
      $result = [];
      $strQuery = '';

      // Construir query
      if (!empty($fields)) {
         if (is_array($fields)) {
            // Buscamos select
            if (isset($fields['SELECT']) && is_array($fields['SELECT'])) {
               $selectQuery = implode(',', $fields['SELECT']);
               $strQuery .= "SELECT " . $selectQuery . " FROM " . $this->table;
            } else {
               $strQuery .= "SELECT * FROM " . $this->table;
            }
            // Buscamos where
            if (isset($fields['WHERE']) && is_array($fields['WHERE'])) {
               $strQuery .= " WHERE ";
               foreach ($fields['WHERE'] as $key => $field) {
                  $strQuery .= $key . ' = ' . $field;
               }
            }
         }
      } else {
         $strQuery .= "SELECT * FROM " . $this->table;
      }

      $query = $this->db->query($strQuery);

      while ($row = $query->fetchObject()) {
         $result[] = $row;
      }

      return $result;
   }

   public function deleteBy($column, $value)
   {
      $query = $this->db->query("DELETE FROM $this->table WHERE $column = '" . $value . "'");
      return $query;
   }

   public function updateBy($id, $idValue, $column, $value)
   {
      $query = $this->db->query("UPDATE $this->table SET $column = '" . $value . "' WHERE $id = '" . $idValue . "'");
      return $query;
   }
}