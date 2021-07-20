<?php
    class Conexion{
        private $conexion;

        public function __construct(){
            $this->conexion = new PDO("mysql:host=localhost;dbname=DBTevo", "admin", "admin");
        }

        public function getConexion(){
            return $this->conexion;
        }
    }