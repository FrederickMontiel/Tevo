<?php
    class RegistroController{
        private $model;
        private $modelSesion;
        private $system;

        private $usuario;
        private $correo;
        private $clave;

        private $dataUsuario;

        private $jsonResponse;

        public function __construct($usuario, $correo, $clave){
            $this->model = new RegistroModel();
            $this->modelSesion = new SesionModel();
            $this->system = new SystemApi();

            $this->usuario = $usuario;
            $this->correo = $correo;
            $this->clave = $clave;
        }

        public function encodeParams(){
            $this->usuario = htmlspecialchars($this->usuario);
            $this->correo = htmlspecialchars($this->correo);
            $this->clave = password_hash(htmlspecialchars($this->clave), PASSWORD_BCRYPT);
        }

        public function registerUser(){
            if(!$this->modelSesion->searchUser($this->correo)){
                if($this->model->addUser($this->usuario, $this->correo, $this->clave)){
                    if($this->modelSesion->searchUser($this->correo)){
                        $this->saveSesion();
                    }else{
                        $this->jsonResponse = '{"error" : 500, "mensaje" : "No se pudo registrar el usuario."}';
                    }
                }else{
                    $this->jsonResponse = '{"error" : 500, "mensaje" : "No se pudo registrar el usuario."}';
                }
            }else{
                $this->jsonResponse = '{"error" : 403, "mensaje" : "Ya existe el usuario."}';
            }
        }

        public function saveSesion(){
            $llave = $this->system->randomText(100);
            if($this->modelSesion->saveKeySesion($llave)){
                $usuario = $this->modelSesion->getFindedUser();
                $this->model->addRol($usuario['idUsuario'], 2);
                $this->jsonResponse = '{"error" : false, "mensaje" : "El usuario se registró con exito.", "key" : "'.$llave.'"}';
            }else{
                $this->jsonResponse = '{"error" : 500, "mensaje" : "Hubo un error al tratar de registrar tu sesión."}';
            }
        }

        public function getJsonResponse(){
            return $this->jsonResponse;
        }
    }