<?php

require_once "config/app.php";
require_once "controller/vistasControlador.php";

//Intanciamos la clase vistaControlador.
$plantilla = new vistasControlador();
$plantilla->obtener_plantilla_controlador();