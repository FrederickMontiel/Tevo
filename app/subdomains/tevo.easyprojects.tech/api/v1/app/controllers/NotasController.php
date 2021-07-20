<?php
    class NotasController{
        private $model, $modelSesion;

        private $usuario, $notaResultado;

        private $key, $titulo, $contenido, $nota, $notas;

        private $jsonResponse;

        public function __construct(){
            $this->notas = array();
            $this->modelSesion = new SesionModel;
            $this->model = new NotasModel;
        }


        public function initAddNote($key, $titulo, $contenido){
            $this->key = htmlspecialchars($key);
            $this->titulo = htmlspecialchars($titulo);
            $this->contenido = htmlspecialchars($contenido);
        }

        public function initEditNote($key, $nota, $titulo, $contenido){
            $this->key = htmlspecialchars($key);
            $this->nota = htmlspecialchars($nota);
            $this->titulo = htmlspecialchars($titulo);
            $this->contenido = htmlspecialchars($contenido);
        }

        public function initDeleteNote($key, $nota){
            $this->key = htmlspecialchars($key);
            $this->nota = htmlspecialchars($nota);
        }

        public function initGetNotes($key){
            $this->key = htmlspecialchars($key);
        }

        public function verifySesion(){
            if($this->modelSesion->verifySesion($this->key)){
                $this->usuario = $this->modelSesion->getUserSesion();
                return true;
            }else{
                $this->jsonResponse = '{"error" : 403, "mensaje" : "Acceso prohibido porque la llave para la sesión no existe"}';
                return false;
            }
        }

        public  function setNewPaste(){
            if($this->model->addPaste($this->usuario['idUsuario'], $this->titulo, $this->contenido)){
                return true;
            }else{
                return false;
            }
        }

        public function lastPaste(){
            if($this->model->lastPasteByUser($this->usuario['idUsuario'])){
                return true;
            }else{
                return false;
            }
        }

        public function searchNote(){
            if($this->model->getPastById($this->nota, $this->usuario['idUsuario'])){
                $this->notaResultado = $this->model->getNotaResultado();
                return true;
            }else{
                $this->jsonResponse = '{"error" : 404, "mensaje" : "Nota no encontrada o no tienes permiso para acceder a ella."}';
                return false;
            }
        }

        public function searchNotes(){
            if($this->model->myNotes($this->usuario['idUsuario'])){
                $json = array();
                $json['error'] = false;
                $json['notas'] = $this->model->getMyNotes();
                $this->jsonResponse = json_encode($json);
            }else{
                $this->jsonResponse = '{"error" : 404, "mensaje" : "No se encontraron notas."}';
            }
        }

        public function editNote(){
            if($this->model->update(
                $this->titulo,
                $this->contenido
            )){
                $this->jsonResponse = '{"error" : false, "mensaje" : "Se actualizó con exito."}';
            }else{
                $this->jsonResponse = '{"error" : 500, "mensaje" : "La nota no se ha podido actualizar."}';
            }
        }

        public function deleteNote(){
            if($this->model->delete($this->usuario['idUsuario'], $this->nota)){
                $this->jsonResponse = '{"error" : false, "mensaje" : "La nota se eliminó"}';
            }else{
                $this->jsonResponse = '{"error" : 500, "mensaje" : "La nota no se ha podido eliminar."}';
            }
        }

        public function getJsonResponse(){
            return $this->jsonResponse;
        }

        public function getLastPaste(){
            return $this->model->getLastPaste();
        }
    }