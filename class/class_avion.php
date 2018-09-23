<?php

class Avion
{
    private $numeroRegistro;
    private $numeroModelo;

    function __construct($numeroRegistro, $numeroModelo)
    {
        $this->numeroRegistro = $numeroRegistro;
        $this->numeroModelo = $numeroModelo;
    }

    public function getNumeroRegistro()
    {
        return $this->numeroRegistro;
    }
     
    public function setNumeroRegistro($numeroRegistro)
    {
        $this->numeroRegistro = $numeroRegistro;
    }
    
    public function getNumeroModelo()
    {
        return $this->numeroModelo;
    }
     
    public function setNumeroModelo($numeroModelo)
    {
        $this->numeroModelo = $numeroModelo;
    }

    public static function obtenerLlavePrimaria($link) {
		// obtener la llave primaria max y retornar la siguiente
		$sql = "SELECT MAX(numeroRegistro) AS 'llave_max' FROM aviones";
		$resultado = $link->ejecutarInstruccion($sql);
		if ($link->cantidadRegistros($resultado) > 0)
        {
			$fila = $link->obtenerFila($resultado);
			return $fila["llave_max"] + 1;
        } else {
			return 0;
		}
	}

    public function agregarAvion($link)
    {
        $sql = sprintf("INSERT INTO aviones VALUES (%s, %s);",
            stripslashes($this->numeroRegistro),
            stripslashes($this->numeroModelo)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Avion agregado con exito!";
        }
        else
        {
            echo "Error! No se agrego el avion.";
        }
    }

    public static function obtenerAvion($link, $numeroRegistro)
    {
        $sql = sprintf("
            SELECT numeroRegistro, numeroModelo
            FROM Aviones
            WHERE numeroRegistro = '%s'",
            stripslashes($numeroRegistro)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        $fila = $link->obtenerFila($resultado);
        $link->liberarResultado($resultado);
        return $fila;
    }

    public function modificarAvion($link)
    {
        $sql = sprintf("
            UPDATE Aviones 
            SET numeroRegistro= '%s', numeroModelo= '%s'
            WHERE numeroRegistro = '%s'",
            stripslashes($this->numeroRegistro),
            stripslashes($this->numeroModelo)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Avion modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el Avion.";
        }
    }
    
}

?>