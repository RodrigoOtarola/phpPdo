<?php

/** Cuando es una petición ajax */
if ($peticionAjax) {
    require_once "../config/server.php";
} else {
    require_once "./config/server.php";
}

class mainModel
{
    /** Función para conectar a la DDBB */
    protected static function conectar()
    {
        $conexion = new PDO(SGBD, USER, PASS);

        $conexion->exec("SET CHARACTER utf-8");

        return $conexion;
    }

    /** Función para conectar consultas simples */
    protected static function ejecutar_consulta_simple($consulta)
    {
        //Con self llamamos a función de la misma clase
        $sql = self::conectar()->prepare($consulta);
        //Ejecutamos la consulta
        $sql->execute();

        return $sql;
    }

    /** Metodos de encryptacion de Hash */
    public function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /** Metodos desencriptacion de Hash */
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /** Funcion para generar código aleatorios */
    protected static function generar_codigo_aleatorio($letra, $longitud, $numero)
    {
        for ($i = 1; $i < $longitud; $i++) {
            $aleatorio = rand(0, 9);
            //Concatenamos $leta con el resultado aleatorio
            $letra .= $aleatorio;
        }

        return $letra . "-" . $numero;
    }

    /** Funcion para limpíar cadenas */
    protected static function limpiar_cadena($cadena)
    {
        //str_ireplace: Reemplaza el 1er valor por el 2do valor, y 3er parametro es la cadena de texto
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src>", "", $cadena);
        $cadena = str_ireplace("<script type=>", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FROM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("DROP TABLE", "", $cadena);
        $cadena = str_ireplace("DROP DATABASE", "", $cadena);
        $cadena = str_ireplace("TRUNCATE TABLE", "", $cadena);
        $cadena = str_ireplace("SHOW TABLES", "", $cadena);
        $cadena = str_ireplace("SHOW DATABASES", "", $cadena);
        $cadena = str_ireplace("<?php", "", $cadena);
        $cadena = str_ireplace("?>", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace(">", "", $cadena);
        $cadena = str_ireplace("<", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);
        $cadena = str_ireplace("::", "", $cadena);

        //Elimina cadenas invertidas
        $cadena = stripcslashes($cadena);

        //trim: Elimina espacios dentro de la cadena
        $cadena = trim($cadena);

        return $cadena;
    }

    /** Funcion para verificar datos */
    protected static function verificar_datos($filtro, $cadena)
    {
        if (preg_match("/^" . $filtro . "$/", $cadena)) {
            //Cuando no tiene errores
            return false;
        } else {
            //Retornamos true cuando hay errores
            return true;
        }
    }

    /** Fución verificar fecha */
    protected static function verificar_fecha($fecha)
    {
        //explode para separar fecha con -
        $valores = explode('-', $fecha);

        //Función para verificar fecha, recibe mes, dia y año
        if (count($valores) == 3 && checkdate($valores[0], $valores[1], $valores[2])) {
            return false;
        } else {
            return true;
        }

    }

    /** Funcion paginador de tablas */
    protected static function paginador_tabla($pagina, $Npaginas, $url, $botones)
    {
        //Estructura inicial
        $tabla = '	<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

        if ($pagina == 1) {
            $tabla .= '<li class="page-item disabled"><a class="page-link"><i class="fa-solid fa-arrow-left"></i></a></li>';
        } else {
            $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . '1/"><i class="fa-solid fa-arrow-left">Anterior</i></a></li>
                <li class="page-item"><a class="page-link" href="' . $url . ($pagina - 1) . '"><i class="fa-solid fa-arrow-left"></i>Anterior</a></li>';
        }

        //Cuerpo de la paginacion
        $ci=0;
        for($i = $pagina; $i<=$Npaginas;$i++){
            //Condicion para cuantos botones generar
            if ($ci >=$botones){
                break;
            }
            if($pagina==$i){
                $tabla.='<li class="page-item"><a class="page-link active" href="' . $url . $i.'/">'.$i.'</a></li>';
            }else{
                $tabla.='<li class="page-item"><a class="page-link" href="' . $url . $i.'/">'.$i.'</a></li>';
            }
            $ci++;
        }

        //Estructura final de los botones
        if ($pagina == $Npaginas) {
            $tabla .= '<li class="page-item disabled"><a class="page-link"><i class="fa-solid fa-arrow-right"></i></a></li';
        } else {
            $tabla .= '<li class="page-item"><a class="page-link" href="' . $url . ($pagina + 1) . '"><i class="fa-solid fa-arrow-left">Siguente</i></a></li>
                <li class="page-item"><a class="page-link" href="' . $url . $Npaginas.'/"><i class="fa-solid fa-arrow-right">Siguente</i></a></li>';
        }

        $tabla .= '</ul></nav>';
    }

}