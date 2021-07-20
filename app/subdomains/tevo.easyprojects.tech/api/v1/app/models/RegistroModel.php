<?php
    class RegistroModel{
        private $conn;

        public function __construct(){
            $database = new Conexion;
            $this->conn = $database->getConexion();
        }

        public function addUser($usuario, $correo, $clave){
            $sql = "INSERT INTO Usuarios (apodoUsuario, correoUsuario, claveUsuario) VALUES (:usuario, :correo, :clave)";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":usuario", $usuario);
            $query->bindParam(":correo", $correo);
            $query->bindParam(":clave", $clave);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function addRol($usuario, $rol){
            $sql = "INSERT INTO RolesUsuario (rolAsignacion, usuarioAsignacion) VALUES (:rol, :usuario)";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":rol", $rol);
            $query->bindParam(":usuario", $usuario);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }
    }