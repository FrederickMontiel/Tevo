<?php
    require_once "../../../../../bin/Conexion.php";
    require_once "../app/controllers/NotasController.php";
    require_once "../app/models/NotasModel.php";
    require_once "../app/models/SesionModel.php";

    if(isset($_REQUEST['key']) && isset($_REQUEST['titulo']) && isset($_REQUEST['contenido'])){
        $controlador = new NotasController;
        $controlador->initAddNote(
            $_REQUEST['key'],
            $_REQUEST['titulo'],
            $_REQUEST['contenido']
        );
        if($controlador->verifySesion()){
            if($controlador->setNewPaste()){
                if($controlador->lastPaste()){
                    $paste = $controlador->getLastPaste();
                    echo '{"error" : false, "mensaje" : "Se ha integrado exitosamente.", "nota" : {"id" : "'.$paste['idNota'].'", "titulo" : "'.$paste['tituloNota'].'", "contenido" : "'.$paste['contenidoNota'].'"}}';
                }else{
                    echo '{"error" : 500, "mensaje" : "Error en la consulta al obtener la nota recientemente añadida."}';
                }
            }else{
                echo '{"error" : 500, "mensaje" : "Error en la consulta al añadir una nota."}';
            }
        }else{
            echo '{"error" : 403, "mensaje" : "Acceso prohibido porque la llave para la sesión no existe"}';
        }
    }else{
        echo '{"error" : 403, "mensaje" : "Acceso prohibido"}';
    }