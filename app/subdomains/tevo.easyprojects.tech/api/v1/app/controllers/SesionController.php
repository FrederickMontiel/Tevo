<?php
    class SesionController{
        private $model;
        private $system;

        private $correo;
        private $clave;

        private $jsonResponse;

        public function __construct($correo, $clave){
            $this->model = new SesionModel();
            $this->system = new SystemApi();

            $this->correo = $correo;
            $this->clave = $clave;
        }

        public function encodeParams(){
            $this->correo = htmlspecialchars($this->correo);
            $this->clave = htmlspecialchars($this->clave);
        }

        public function initSesion(){
            if($this->model->searchUser($this->correo)){
                $usuario = $this->model->getFindedUser();
                if(password_verify($this->clave, $usuario['claveUsuario'])){
                    $this->saveSesion();
                }else{
                    $this->jsonResponse = '{"error" : 403, "mensaje" : "Lo sentimos, los datos ingresados no coinciden."}';
                }
            }else{
                $this->jsonResponse = '{"error" : 404, "mensaje" : "No existe el usuario en nuestra base de datos."}';
            }
        }

        public function saveSesion(){
            $llave = $this->system->randomText(100);
            if($this->model->saveKeySesion($llave)){
                $this->jsonResponse = '{"error" : false, "mensaje" : "Haz iniciado sesión con exito.", "key" : "'.$llave.'"}';
            }else{
                $this->jsonResponse = '{"error" : 500, "mensaje" : "Hubo un error al tratar de registrar tu sesión."}';
            }
        }

        public function exitOfSesion($key){
            if($this->model->verifySesion($key)){
                if($this->model->deleteSesion($key)){
                    $this->jsonResponse = '{"error" : false, "mensaje" : "Sesión cerrada."}';
                }else{
                    $this->jsonResponse = '{"error" : 500, "mensaje" : "Error al cerrar la sesión."}';
                }
            }else{
                $this->jsonResponse = '{"error" : 403, "mensaje" : "No tienes acceso para cerrar esta sesión."}';
            }
        }

        public function getJsonResponse(){
            return $this->jsonResponse;
        }
    }