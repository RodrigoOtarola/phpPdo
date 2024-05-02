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
        /** Validación de formato DNI */
        if (mainModel::verificar_datos("[0-9-]{10,20}", $dni)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "DNI formato erroneo",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }
        /** Validación de formato contraseñas */
        if (mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave1) || mainModel::verificar_datos("[a-zA-Z0-9$@.-]{7,100}", $clave2)) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "Contraseña formato incorrecto",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }

        /** Contraseñas sean iguales */
        if ($clave1 != $clave2) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "Contraseñas no coinciden",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        } else {
//        $clave = mainModel::encryption($clave1);
            $mainModel = new mainModel();

            $clave = $mainModel->encryption($clave1);
        }

        /** Validación que dni sea unico */
        $checkDni = mainModel::ejecutar_consulta_simple("SELECT usuario_dni FROM usuario WHERE usuario_dni = '$dni'");
        //rowCount cuenta cantidad de columnas
        if ($checkDni->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "DNI ya existe en la base de datos",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }

        /** Validación que nombre de usuario sea unico */
        $checkUsuario = mainModel::ejecutar_consulta_simple("SELECT usuario_usuario FROM usuario WHERE usuario_usuario = '$usuario'");
        //rowCount cuenta cantidad de columnas
        if ($checkUsuario->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "Nombre de Usuario ya existe en la base de datos",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }

        /** Validación que email de usuario sea unico */
        if ($email != "") {
            //Formato de un email valido
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $checkEmail = mainModel::ejecutar_consulta_simple("SELECT usuario_email FROM usuario WHERE usuario_email = '$email'");
                //rowCount cuenta cantidad de columnas
                if ($checkEmail->rowCount() > 0) {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Error de ingreso",
                        "Texto" => "Email ya existe en la base de datos",
                        "Tipo" => "error"
                    ];

                    //convertimos tecto en json
                    echo json_encode($alerta);
                    exit();
                }
            } else {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error de ingreso",
                    "Texto" => "Email formato erroneo",
                    "Tipo" => "error"
                ];
                //convertimos tecto en json
                echo json_encode($alerta);
                exit();
            }
        }

        /** Comprobar privilegios */
        if ($privilegio < 1 || $privilegio > 3) {
            if ($checkEmail->rowCount() > 0) {
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Error de ingreso",
                    "Texto" => "Priviligeio seleccionado no es valido",
                    "Tipo" => "error"
                ];

                //convertimos tecto en json
                echo json_encode($alerta);
                exit();
            }
        }

        $datos_usuario_reg = [
            "DNI" => $dni,
            "Nombre" => $nombre,
            "Apellido" => $apellido,
            "Telefono" => $telefono,
            "Direccion" => $direccion,
            "Email" => $email,
            "Usuario" => $usuario,
            "Clave" => $clave,
            "Estado" => "Activa",
            "Privilegio" => $privilegio
        ];
        $agregar_usuario = usuarioModelo::agregar_usuario_modelo($datos_usuario_reg);

        if ($agregar_usuario->rowCount() == 1) {
            $alerta = [
                "Alerta" => "limpiar",
                "Titulo" => "Registro creado",
                "Texto" => "Ingreso realizado con exito",
                "Tipo" => "success"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Error de ingreso",
                "Texto" => "No hemos podido registrar el usuario",
                "Tipo" => "error"
            ];

            //convertimos tecto en json
            echo json_encode($alerta);
            exit();
        }


    }

}