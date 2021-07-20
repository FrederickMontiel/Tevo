<?php
    class NotasModel{
        private $conn;

        private $resultado;
        private $notaResultado;
        private $notas;

        public function __construct(){
            $this->notas = array();
            $database = new Conexion;
            $this->conn = $database->getConexion();
        }

        public function addPaste($usuario, $titulo, $contenido){
            $fecha = date("Y-m-d H:i:s");
            $sql = "INSERT INTO Notas (usuarioNota, tituloNota, contenidoNota, fechaNota) VALUES (:usuario, :titulo, :contenido, :fecha)";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":usuario", $usuario);
            $query->bindParam(":titulo", $titulo);
            $query->bindParam(":contenido", $contenido);
            $query->bindParam(":fecha", $fecha);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function lastPasteByUser($usuario){
            $sql = "SELECT * FROM Notas WHERE usuarioNota = :usuario ORDER BY idNota DESC";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":usuario", $usuario);
            $query->execute();

            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if(is_array($resultado) && isset($resultado)){
                $this->resultado = $resultado;
                return true;
            }else{
                return false;
            }
        }

        public function getPastById($id, $usuario){
            $sql = "SELECT * FROM Notas WHERE idNota = :id AND usuarioNota = :usuario";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":id", $id);
            $query->bindParam(":usuario", $usuario);
            $query->execute();

            $resultado = $query->fetch(PDO::FETCH_ASSOC);

            if(is_array($resultado) && isset($resultado)){
                $this->notaResultado = $resultado;
                return true;
            }else{
                return false;
            }
        }

        public function update($titulo, $contenido){
            $fecha = date("Y-m-d H:i:s");
            $nota = $this->notaResultado['idNota'];

            $sql = "UPDATE Notas SET tituloNota = :titulo, contenidoNota = :contenido, fechaNota = :fecha WHERE idNota = :nota";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":nota", $nota);
            $query->bindParam(":titulo", $titulo);
            $query->bindParam(":contenido", $contenido);
            $query->bindParam(":fecha", $fecha);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function delete($usuario, $nota){
            $sql = "DELETE FROM Notas WHERE usuarioNota = :usuario AND idNota = :nota";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":nota", $nota);
            $query->bindParam(":usuario", $usuario);

            if($query->execute()){
                return true;
            }else{
                return false;
            }
        }

        public function myNotes($usuario){
            $sql = "SELECT * FROM Notas WHERE usuarioNota = :usuario ORDER BY fechaNota DESC";
            $query = $this->conn->prepare($sql);
            $query->bindParam(":usuario", $usuario);
            $query->execute();

            $this->notas = array();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $nota = array();
                $nota['idNota'] = intval($row['idNota']);
                $nota['tituloNota'] = $row['tituloNota'];
                $nota['contenidoNota'] = $row['contenidoNota'];

                $this->notas[] = $nota;
            }

            if(is_array($this->notas) && count($this->notas) > 0){
                return true;
            }else{
                return false;
            }
        }

        public function getMyNotes(){
            return $this->notas;
        }

        public function getNotaResultado(){
            return $this->notaResultado;
        }

        public function getLastPaste(){
            return $this->resultado;
        }
    }