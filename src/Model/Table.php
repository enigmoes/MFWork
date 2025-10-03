<?php
declare(strict_types = 1);

class Table
{
    protected $db;

    public function __construct() {
        $cnx = new Conector();
        $this->db = $cnx->getConexion();
    }
}