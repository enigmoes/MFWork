<?php

class Main extends Model
{

   public function __construct()
   {
      $tabla = 'usuarios';
      parent::__construct($tabla);
   }

}