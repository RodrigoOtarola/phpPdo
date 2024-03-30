<?php

class vistasModelo{

    /** Modelo para obtener vistas */
    protected static function obtener_vistas_modelo($vistas){
        $listaBlanca=[];
        //Comprueba si valor esta en array de datos, 1er param es el valor y 2do param es el arreglo
        if(in_array($vistas, $listaBlanca)){
            //is_file= comprueba si exista un archivo, mediante url entregada
            if (is_file("./view/contenidos/".$vistas."-view-php")){
                $contenido="./view/contenidos/".$vistas."-view-php";
            }else{
                $contenido="404";
            }

        }elseif ($vistas =="login" || $vistas == "index"){
            $contenido="login";
        }else{
            $contenido="404";
        }

        return $contenido;
    }

}