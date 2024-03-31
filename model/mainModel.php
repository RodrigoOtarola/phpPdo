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
        $sql=self::conectar()->prepare($consulta);
        //Ejecutamos la consulta
        $sql->execute();

        return $sql;
    }

    /** Metodos de encryptacion de Hash */
    public function encryption($string){
        $output=FALSE;
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output=base64_encode($output);
        return $output;
    }

    /** Metodos desencriptacion de Hash */
    protected static function decryption($string){
        $key=hash('sha256', SECRET_KEY);
        $iv=substr(hash('sha256', SECRET_IV), 0, 16);
        $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /** Funcion para generar código aleatorios */
    protected static function generar_codigo_aleatorio($letra,$longitud,$numero)
    {
        for ($i = 1;$i<$longitud; $i++){
            $aleatorio = rand(0,9);
            //Concatenamos $leta con el resultado aleatorio
            $letra.=$aleatorio;
        }

        return $letra."-".$numero;
    }

}