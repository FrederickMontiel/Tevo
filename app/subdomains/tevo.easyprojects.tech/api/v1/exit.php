<?php
    require_once "app/controllers/SesionController.php";
    require_once "app/models/SesionModel.php";
    require_once "app/apis/SystemApi.php";
    require_once "../../../../bin/Conexion.php";

    if(isset($_REQUEST['key'])){
        $controlador = new SesionController(
            "a",
            "a"
        );
        $controlador->exitOfSesion($_REQUEST['key']);

        echo $controlador->getJsonResponse();
    }else{
        echo '{"error" : 403, "mensaje" : "No se ha procesado tu solicitud"}';
    }