<?php

$peticionAjax= true;

require_once "../config/app.php";

if(isset($_POST['usuario_dni_reg'])){

    /** Instancia del controlador */
    require_once "../controller/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();


    if(isset($_POST['usuario_dni_reg']) && isset($_POST['usuario_nombre_reg'])){
        echo $ins_usuario->agregar_usuario_controlador();
    }


}else{
    //Creamos la session
    session_start(['name'=>'SPM']);

    //limpiamos la session
    session_unset();

    //Eliminamos la session
    session_destroy();

    //Redireccionamos
    header("Location: ".SERVERURL."login/");
}