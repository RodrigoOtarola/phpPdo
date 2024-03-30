<?php

require_once "./model/vistasModelo.php";


class vistasControlador extends vistasModelo{

    /** Controlador para obtener plantilla */
    public function obtener_plantilla_controlador(){
        return require_once "./view/plantilla.php";
    }

    /** Controlador obtener vistas */
    public function obtener_vistas_controlador(){
        if(isset($_GET['views'])){
            // explode, funcion para dividir un string con delimitador
            $ruta = explode("/",$_GET['views']);

            $respuesta = vistasModelo::obtener_vistas_modelo($ruta[0]);
        }else{
            $respuesta="login";
        }
        return $respuesta;
    }
}