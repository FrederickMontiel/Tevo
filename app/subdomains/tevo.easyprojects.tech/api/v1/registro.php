<?php
    require_once "app/controllers/RegistroController.php";
    require_once "app/models/RegistroModel.php";
    require_once "app/models/SesionModel.php";
    require_once "app/apis/SystemApi.php";
    require_once "../../../../bin/Conexion.php";

    if(isset($_REQUEST['usuario']) && isset($_REQUEST['correo']) && isset($_REQUEST['clave'])){
        if(strlen($_REQUEST['usuario']) > 4){
            if (strlen($_REQUEST['correo']) > 6 && strpos($_REQUEST['correo'], "@") && strpos($_REQUEST['correo'], ".")) {
                if (strlen($_REQUEST['clave']) > 5) {
                    $controlador = new RegistroController(
                        $_REQUEST['usuario'],
                        $_REQUEST['correo'],
                        $_REQUEST['clave']
                    );
                    $controlador->encodeParams();
                    $controlador->registerUser();

                    echo $controlador->getJsonResponse();
                } else {
                    echo '{"error" : 403, "mensaje" : "La clave debe contenet más de 5 caracteres."}';
                }
            } else {
                echo '{"error" : 403, "mensaje" : "El correo es invalido."}';
            }
        }else{
            echo '{"error" : 403, "mensaje" : "El usuario debe contener mas de 4 caracteres."}';
        }
    }else{
        echo '{"error" : 403, "mensaje" : "No se ha procesado tu solicitud"}';
    }