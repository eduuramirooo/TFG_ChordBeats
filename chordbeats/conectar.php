<?php
class Conectar
{
    private $conexion;
    function __construct($servidor, $usuario, $contraseña, $bbdd)
    {
        $this->conexion = new mysqli($servidor, $usuario, $contraseña, $bbdd);
    }

    /* function hacer_consulta($tipo_consulta, $tabla, $valores, $opciones){
        $consulta = "$tipo_consulta $tabla $valores $opciones"; 
    }   */
    function hacer_consulta($consulta, $tipos, $variables){
        $sentencia = $this->conexion->prepare($consulta);
        $array_completo = array_merge([$tipos],$variables);
        $referencia = [];
        foreach($array_completo as $clave => $valor){
            $referencia[$clave] = &$array_completo[$clave];
        }
        call_user_func_array([$sentencia, 'bind_param'],$referencia);
        //$sentencia->bind_param($tipos, $variables);
        $sentencia->execute();
        return $this->conexion->insert_id;
    }

    function recibir_datos($consulta){
        $sentencia = $this->conexion->query($consulta);
        $filas = [];
        //var_dump($sentencia->fetch_array());
        while($row = $sentencia->fetch_assoc()){
            $filas[] = $row;
        }
        return $filas;
    }
    function ultimo_id() {
        return $this->conexion->insert_id;
    }
}