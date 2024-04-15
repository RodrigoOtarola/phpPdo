<?php
if ($peticionAjax) {
    require_once "../model/usuarioModelo.php";
} else {
    require_once "../model/usuarioModelo.php";
}

class usuarioControlador extends usuarioModelo
{

    /** Controlador agregar usuario */
    public static function agregar_usuario_controlador()
    {
        $dni = mainModel::limpiar_cadena($_POST['usuario_dni_reg']);
        $nombre = mainModel::limpiar_cadena($_POST['usuario_nombre_reg']);
        $apellido = mainModel::limpiar_cadena($_POST['usuario_apellido_reg']);
        $telefono = mainModel::limpiar_cadena($_POST['usuario_telefono_reg']);
        $direccion = mainModel::limpiar_cadena($_POST['usuario_direccion_reg']);
        $usuario = mainModel::limpiar_cadena($_POST['usuario_usuario_reg']);
        $email = mainModel::limpiar_cadena($_POST['usuario_email_reg']);
        $clave1 = mainModel::limpiar_cadena($_POST['usuario_clave_1_reg']);
        $clave2 = mainModel::limpiar_cadena($_POST['usuario_clave_2_reg']);
        $privilegio = mainModel::limpiar_cadena($_POST['usuario_privilegio_reg']);

        /** Comprobar campos vacios */
        if ($dni == "" || $nombre == "" || $apellido == "" || $usuario == "" || $clave1 == "" || $clave2 == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrio un error inesperado",
                "Texto" => "Faltan campos requeridos",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }
    }

}