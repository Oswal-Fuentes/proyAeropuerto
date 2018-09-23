<?php

class Tecnico
{
    
    private $dni; 
    private $direccion; 
    private $telefono; 
    private $sueldo;  

    function __construct($dni, $direccion, $telefono, $sueldo)
    {
        $this->dni = $dni;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->sueldo = $sueldo;
    }

    public function getDni()
    {
        return $this->dni;
    }
     
    public function setDni($dni)
    {
        $this->dni = $dni;
    }
    
    public function getDireccion()
    {
        return $this->direccion;
    }
     
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }
    
    public function getTelefono()
    {
        return $this->telefono;
    }
     
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }
    
    public function getSueldo()
    {
        return $this->sueldo;
    }
     
    public function setSueldo($sueldo)
    {
        $this->sueldo = $sueldo;
    }

    public static function generarTabla($link)
    {
        $sql = "SELECT a.dni, a.direccion, a.sueldo AS alias_aula, a.telefono, b.direccion, b.codigo_region, b.sueldo AS alias_edificio, c.codigo_region, c.alias AS alias_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.direccion = b.direccion)
            INNER JOIN tbl_regiones c
            ON (b.codigo_region = c.codigo_region)";
        $resultado = $link->ejecutarInstruccion($sql);
        while ($fila = $link->obtenerFila($resultado))
        {
            echo "<tr>";
            echo "<td><input type='radio' name='rad-aulas' value='".$fila["dni"]."'></td>";
            echo "<td>".$fila["alias_aula"]."</td>";
            echo "<td>".$fila["alias_edificio"]."</td>";
            echo "<td>".$fila["alias_region"]."</td>";
            echo "<td>".$fila["telefono"]."</td>";
            echo "</tr>";
        }
        $link->liberarResultado($resultado);
    }

    public static function generarSelect($link)
    {
        $sql = "SELECT a.dni, a.direccion, a.sueldo AS alias_aula, b.direccion, b.codigo_region, b.sueldo AS alias_edificio, c.codigo_region, c.alias AS alias_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.direccion = b.direccion)
            INNER JOIN tbl_regiones c
            ON (b.codigo_region = c.codigo_region)";
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            echo "<select class='form-control' id='slc-aula'>";
            while ($fila = $link->obtenerFila($resultado))
            {
                echo "<option value='".$fila["dni"]."'>";
                echo $fila["alias_region"]." | ".$fila["alias_edificio"]." | ".$fila["alias_aula"];
                echo "</option>";
            }
            echo "</select>";
            $link->liberarResultado($resultado);
        }
    }

    public function agregarAula($link)
    {
        $sql = sprintf(
            "INSERT INTO tbl_aulas VALUES (NULL, '%s', '%s', '%s');",
            stripslashes($this->direccion),
            stripslashes($this->telefono),
            stripslashes($this->sueldo)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Edificio agregado con exito!";
        }
        else
        {
            echo "Error! No se agrego el edificio.";
        }
    }

    public static function obtenerAula($link, $dni)
    {
        $sql = sprintf(
            "SELECT a.dni, a.direccion, a.telefono, a.sueldo, b.direccion, b.codigo_region
            FROM tbl_aulas a
            INNER JOIN tbl_edificios b
            ON (a.direccion = b.direccion)
            WHERE dni = '%s'",
            stripslashes($dni)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public static function eliminarAula($link, $dni)
    {
        //Eliminar las secciones que usan esta aula
        $sql = sprintf(
            "SELECT codigo_seccion, dni
            FROM tbl_secciones
            WHERE dni = '%s'",
            stripslashes($dni)
        );
        if($resultado = $link->ejecutarInstruccion($sql))
        {
            while ($fila = $link->obtenerFila($resultado))
            {
                Seccion::eliminarSeccion($link, $fila["codigo_seccion"]);
            }
            $link->liberarResultado($resultado);
        }

        //Eliminar el aula
        $sql = sprintf(
            "DELETE FROM tbl_aulas
            WHERE dni = '%s'",
            stripslashes($dni)
        );
        $link->ejecutarInstruccion($sql);
    }

    public static function verificarIntegridad($link, $alias, $direccion)
    {
        $sql = sprintf("
            SELECT sueldo, direccion
            FROM tbl_aulas
            WHERE (sueldo = '%s' AND direccion = '%s')",
            stripslashes($sueldo),
            stripslashes($direccion)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public static function verificarModificar($link, $sueldo, $direccion, $dni)
    {
        $sql = sprintf(
            "SELECT dni, direccion, sueldo
            FROM tbl_aulas
            WHERE (sueldo = '%s' AND direccion = '%s')
            AND dni != '%s'",
            stripslashes($sueldo),
            stripslashes($direccion),
            stripslashes($dni)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $registros = $link->cantidadRegistros($resultado);
        $link->liberarResultado($resultado);
        return ($registros == 0);
    }

    public function modificarAula($link)
    {
        $sql = sprintf(
            "UPDATE tbl_aulas 
            SET direccion= '%s', sueldo= '%s', telefono = '%s'
            WHERE dni = '%s'",
            stripslashes($this->direccion),
            stripslashes($this->sueldo),
            stripslashes($this->telefono),
            stripslashes($this->dni)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Edificio modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el edificio.";
        }
    }

}

?>
