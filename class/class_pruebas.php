<?php

class Pruebas{

	private $numeroPrueba;
	private $numeroRegistro;
	private $dni;
	private $nombre;
	private $puntuacion;
	private $fecha;
	private $horas;
	private $calificacion;

	function __construct($numeroPrueba, $numeroRegistro, $dni, $nombre, $puntuacion, $fecha, $horas, $calificacion){
		$this->numeroPrueba = $numeroPrueba;
		$this->numeroRegistro = $numeroRegistro;
		$this->dni = $dni;
		$this->nombre = $nombre;
		$this->puntuacion = $puntuacion;
		$this->fecha = $fecha;
		$this->horas = $horas;
		$this->calificacion = $calificacion;
	}

	public function getNumeroPrueba(){
	    return $this->numeroPrueba;
	}
	 
	public function setNumeroPrueba($numeroPrueba){
	    $this->numeroPrueba = $numeroPrueba;
	}
	
	public function getNumeroRegistro(){
	    return $this->numeroRegistro;
	}
     
    public function setNumeroRegistro(){
	    $this->numeroRegistro = $numeroRegistro;
    }
    
	public function setCodigoTipoSeccion($numeroRegistro){
	    $this->numeroRegistro = $numeroRegistro;
	}
	
	public function getDni(){
	    return $this->dni;
	}
	 
	public function setDni($dni){
	    $this->dni = $dni;
	}
	
	public function getNombre(){
	    return $this->nombre;
	}
	 
	public function setNombre($nombre){
	    $this->nombre = $nombre;
	}
	
	public function getPuntuacion(){
	    return $this->puntuacion;
	}
	 
	public function setPuntuacion($puntuacion){
	    $this->puntuacion = $puntuacion;
	}
	
	public function getFecha(){
	    return $this->fecha;
	}
	 
	public function setFecha($fecha){
	    $this->fecha = $fecha;
	}
	
	public function getHoras(){
	    return $this->horas;
	}
	 
	public function setHoras($horas){
	    $this->horas = $horas;
	}
	
	public function getCalificacion(){
	    return $this->calificacion;
	}
	 
	public function setCalificacion($calificacion){
	    $this->calificacion = $calificacion;
	}

	public static function eliminarSeccion($link, $numeroPrueba){
		$sql = sprintf("
			DELETE FROM tbl_secciones_x_usuarios
			WHERE numeroPrueba = '%s'",
			stripslashes($numeroPrueba)
		);

		$link->ejecutarInstruccion($sql);

		$sql = sprintf("
			DELETE FROM tbl_secciones
			WHERE numeroPrueba = '%s'",
			stripslashes($numeroPrueba)
		);

		$link->ejecutarInstruccion($sql);
	}

	public static function verificarIntegridad($link, $fecha, $horas, $nombre){
		$sql = sprintf("
			SELECT fecha, horas, nombre
			FROM tbl_secciones
			WHERE (fecha = '%s' AND horas = '%s')
			OR (nombre = '%s' AND horas = '%s')",
			stripslashes($fecha),
			stripslashes($horas),
			stripslashes($nombre),
			stripslashes($horas)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function verificarModificar($link, $fecha, $horas, $nombre, $numeroPrueba){
		$sql = sprintf("
			SELECT numeroPrueba fecha, horas, nombre
			FROM tbl_secciones
			WHERE ((fecha = '%s' AND horas = '%s')
			OR (nombre = '%s' AND horas = '%s'))
			AND numeroPrueba != '%s'",
			stripslashes($fecha),
			stripslashes($horas),
			stripslashes($nombre),
			stripslashes($horas),
			stripslashes($numeroPrueba)
		);

		return($link->cantidadRegistros($link->ejecutarInstruccion($sql)) == 0);
	}

	public static function generarTabla($link){
		$sql = "SELECT 
			a.numeroPrueba, a.numeroRegistro, a.dni, a.nombre, a.puntuacion, a.fecha, a.horas, a.calificacion, 
			b.numeroRegistro, b.tipo_seccion, 
			c.dni, c.nombre, 
			d.nombre, d.codigo_edificio, d.alias AS alias_aula, 
			e.codigo_edificio, e.codigo_region, e.alias AS alias_edificio, 
			f.codigo_region, f.alias AS alias_region, 
			g.puntuacion, g.horario, 
			h.codigo_usuario, h.nombres, h.apellidos, 
			i.horas, i.hora_inicio 
			FROM tbl_secciones a
			INNER JOIN tbl_tipos_secciones b
			ON (a.numeroRegistro = b.numeroRegistro)
			INNER JOIN tbl_asignaturas c
			ON (a.dni = c.dni)
			INNER JOIN tbl_aulas d
			ON (a.nombre = d.nombre)
			INNER JOIN tbl_edificios e
			ON (d.codigo_edificio = e.codigo_edificio)
			INNER JOIN tbl_regiones f
			ON (e.codigo_region = f.codigo_region)
			INNER JOIN tbl_horarios g
			ON (a.puntuacion = g.puntuacion)
			INNER JOIN tbl_usuarios h
			ON (a.fecha = h.codigo_usuario)
			INNER JOIN tbl_horas_inicio i
			ON (a.horas = i.horas)";

		if($resultado = $link->ejecutarInstruccion($sql)){
			while ($fila = $link->obtenerFila($resultado)) {
				echo "<tr>";
				echo "<td><input type='radio' name='rad-secciones' value='".$fila["numeroPrueba"]."'></td>";
				echo "<td>".$fila["tipo_seccion"]."</td>";
				echo "<td>".$fila["nombre"]."</td>";
				echo "<td>".$fila["alias_aula"]."</td>";
				echo "<td>".$fila["alias_edificio"]."</td>";
				echo "<td>".$fila["alias_region"]."</td>";
				echo "<td>".$fila["horario"]."</td>";
				echo "<td>".$fila["hora_inicio"]."</td>";
				echo "<td>".$fila["nombres"]." ".$fila["apellidos"]."</td>";
				echo "<td>".$fila["calificacion"]."</td>";
				echo "</tr>";
			}

			$link->liberarResultado($resultado);
		}
	}

	public function agregarSeccion($link){
		$sql = sprintf("
			INSERT INTO tbl_secciones 
			(numeroPrueba, numeroRegistro, dni, nombre, puntuacion, fecha, horas, calificacion) 
			VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
			stripslashes($this->numeroRegistro),
			stripslashes($this->dni),
			stripslashes($this->nombre),
			stripslashes($this->puntuacion),
			stripslashes($this->fecha),
			stripslashes($this->horas),
			stripslashes($this->calificacion)
		);
		
		if($link->ejecutarInstruccion($sql))
			echo "Seccion agregada con exito!";
		else
			echo "Error! No se agrego la seccion.";
	}

	public static function obtenerSeccion($link, $numeroPrueba){
		$sql = sprintf("
			SELECT numeroPrueba, numeroRegistro, dni, nombre, puntuacion, fecha, horas, calificacion
			FROM tbl_secciones
			WHERE numeroPrueba = '%s'",
			stripslashes($numeroPrueba)
		);

		return $link->obtenerFila($link->ejecutarInstruccion($sql));
	}

	public function modificarSeccion($link){
		$sql = sprintf("
			UPDATE tbl_secciones 
			SET numeroRegistro='%s', dni='%s', nombre='%s', puntuacion='%s', fecha='%s', horas='%s', calificacion='%s'
			WHERE numeroPrueba = '%s'",
			stripslashes($this->numeroRegistro),
			stripslashes($this->dni),
			stripslashes($this->nombre),
			stripslashes($this->puntuacion),
			stripslashes($this->fecha),
			stripslashes($this->horas),
			stripslashes($this->calificacion),
			stripslashes($this->numeroPrueba)
		);

		if($link->ejecutarInstruccion($sql))
			echo "Seccion modificada con exito!";
		else
			echo "Error! No se modifico la seccion.";
	}

}

?>