<?php
require_once "../../../../../bin/Conexion.php";
require_once "../app/controllers/NotasController.php";
require_once "../app/models/NotasModel.php";
require_once "../app/models/SesionModel.php";

if(isset($_POST['key']) && isset($_POST['nota'])) {
    $controlador = new NotasController;
    $controlador->initDeleteNote(
        $_POST['key'],
        $_POST['nota']
    );

    if($controlador->verifySesion()){
        if($controlador->searchNote()){
            $controlador->deleteNote();
            echo $controlador->getJsonResponse();
        }else{
            echo $controlador->getJsonResponse();
        }
    }else{
        echo $controlador->getJsonResponse();
    }
}else{
    echo '{"error" : 403, "mensaje" : "Acceso prohibido"}';
}