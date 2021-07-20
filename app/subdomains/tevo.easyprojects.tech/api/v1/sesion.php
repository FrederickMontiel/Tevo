<?php
    require_once "app/controllers/SesionController.php";
    require_once "app/models/SesionModel.php";
    require_once "app/apis/SystemApi.php";
    require_once "../../../../bin/Conexion.php";

    if(isset($_REQUEST['correo']) && isset($_REQUEST['clave'])){
        if(strlen($_REQUEST['correo']) > 6 && strpos($_REQUEST['correo'], "@") && strpos($_REQUEST['correo'], ".")){
            if(strlen($_REQUEST['clave']) > 5){
                $controlador = new SesionController(
                    $_REQUEST['correo'],
                    $_REQUEST['clave']
                );
                $controlador->encodeParams();
                $controlador->initSesion();
                echo $controlador->getJsonResponse();
            }else{
                echo '{"error" : 403, "mensaje" : "La clave no tiene mas de 6 caracteres"}';
            }
        }else{
            echo '{"error" : 403, "mensaje" : "El correo es invalido"}';
        }
    }else{
        echo '{"error" : 403, "mensaje" : "No se ha procesado tu solicitud"}';
    }