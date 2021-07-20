<?php
    require_once "../../../../../bin/Conexion.php";
    require_once "../app/controllers/NotasController.php";
    require_once "../app/models/NotasModel.php";
    require_once "../app/models/SesionModel.php";

    if(isset($_POST['key']) && isset($_POST['nota']) && isset($_POST['titulo']) && isset($_POST['contenido'])) {
        $controlador = new NotasController;
        $controlador->initEditNote(
            $_POST['key'],
            $_POST['nota'],
            $_POST['titulo'],
            $_POST['contenido']
        );

        if($controlador->verifySesion()){
            if($controlador->searchNote()){
                $controlador->editNote();
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