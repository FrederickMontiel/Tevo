<?php
    require_once "../../../../../bin/Conexion.php";
    require_once "../app/controllers/NotasController.php";
    require_once "../app/models/NotasModel.php";
    require_once "../app/models/SesionModel.php";

    if(isset($_POST['key'])) {
        $controlador = new NotasController;
        $controlador->initGetNotes(
            $_POST['key']
        );

        if($controlador->verifySesion()){
            $controlador->searchNotes();
            echo $controlador->getJsonResponse();
        }else{
            echo $controlador->getJsonResponse();
        }
    }else{
        echo '{"error" : 403, "mensaje" : "Acceso prohibido"}';
    }