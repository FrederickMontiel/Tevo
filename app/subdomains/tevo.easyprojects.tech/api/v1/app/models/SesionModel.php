<?php
    class SesionModel{
        private $conn;

        private $resultado;
        private $userSesion;

        public function __construct(){
            $database = new Conexion;
            $this->conn = $database->getConexion();
        }

        public function searchUser($correo){
            $sql = "SELECT * FROM Usuarios WHERE correoUsuario = :correo";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":correo", $correo);
            $query->execute();

            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if(is_array($resultado) && isset($resultado)){
                $this->resultado = $resultado;
                return true;
            }else{
                return false;
            }
        }

        public function saveKeySesion($key){
            $idUsuario = $this->resultado['idUsuario'];

            $sql = "INSERT INTO Sesiones (idSesion, usuarioSesion) VALUES (:llave, :usuario)";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":llave", $key);
            $query->bindParam(":usuario", $idUsuario);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function verifySesion($key){
            $sql = "SELECT * FROM Sesiones s, Usuarios u WHERE s.usuarioSesion = u.idUsuario AND s.idSesion = :key";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":key", $key);
            $query->execute();

            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if(is_array($resultado) && isset($resultado)){
                $this->userSesion = $resultado;
                return true;
            }else{
                return false;
            }
        }

        public function deleteSesion($key){
            $sql = "DELETE FROM Sesiones WHERE idSesion = :sesion";

            $query = $this->conn->prepare($sql);
            $query->bindParam(":sesion", $key);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function getUserSesion(){
            return $this->userSesion;
        }

        public function getFindedUser(){
            return $this->resultado;
        }
    }