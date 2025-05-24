<?php
    class CCon{
    static function conexionBD(){
        try {
            $conexion = new PDO("sqlsrv:server=DESKTOP-6PELITV;database=BD_AGENCIA_VOLKSWAGEN","sa","BTS134340");
            //echo "Se ha conectado a la base de datos correctamente";
        } catch (PDOException $exp) {
            echo ("No se pudo conectar a la base de datos: $exp");
        }
        return $conexion;
    }

    static function cerrarConn($conexion){
        return $conexion = null;
    }
}
    

    // $consulta= $conexion->prepare("SELECT * FROM tablaEntFed");
    // $consulta->execute();
    // $datos=$consulta->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($datos);
?>