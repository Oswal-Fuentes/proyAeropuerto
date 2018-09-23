<?php
class Empleado
{
	private $dni;
	private $afiliacion;
	private $nombre;
	private $username;
	private $pass;
	private $isAdmin;
	private $tipo;

	function __construct($dni, $afiliacion, $nombre, $username, $pass, $isAdmin, $tipo)
	{
		$this->dni = $dni;
		$this->afiliacion = $afiliacion;
		$this->nombre = $nombre;
		$this->username = $username;
		$this->pass = $pass;
		$this->isAdmin = $isAdmin;
		$this->tipo = $tipo;
	}

	public function getDni()
	{
	    return $this->dni;
	}

	public function setDni($dni)
	{
	    $this->dni = $dni;
	}

	public function getAfiliacion()
	{
	    return $this->afiliacion;
	}

	public function setAfiliacion($afiliacion)
	{
	    $this->afiliacion = $afiliacion;
	}

	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getUsername()
	{
	    return $this->username;
	}

	public function setUsername($username)
	{
	    $this->username = $username;
	}

	public function getPass()
	{
	    return $this->pass;
	}

	public function setPass($pass)
	{
	    $this->pass = $pass;
	}

	public function getisAdmin()
	{
	    return $this->isAdmin;
	}

	public function setisAdmin($isAdmin)
	{
	    $this->isAdmin = $isAdmin;
	}

	public function getTipo()
	{
	    return $this->tipo;
	}

	public function setTipo($tipo)
	{
	    $this->tipo = $tipo;
	}

	public static function obtenerLlavePrimaria($link) {
		// obtener la llave primaria max y retornar la siguiente
		$sql = "SELECT MAX(dni) AS 'llave_max' FROM empleado";
		$resultado = $link->ejecutarInstruccion($sql);
		if ($link->cantidadRegistros($resultado) > 0)
        {
			$fila = $link->obtenerFila($resultado);
			return $fila["llave_max"] + 1;
        } else {
			return 0;
		}
	}

    public static function verificarEmpleado($link, $username, $pass)
    {
        $sql = sprintf(
            "SELECT dni, afiliacion, nombre, username, pass, isAdmin, tipo
            FROM empleado
            WHERE username = '%s'
            AND pass = '%s'",
            stripslashes($username),
            stripslashes($pass)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        if ($link->cantidadRegistros($resultado) > 0)
        {
            $fila = $link->obtenerFila($resultado);
            $respuesta = array(
                "existe" => true,
                "dni" => $fila["dni"],
                "afiliacion" => $fila["afiliacion"],
                "nombre" => $fila["nombre"],
				"username" => $fila["username"],
				"pass" => $fila["pass"],
				"isAdmin" => $fila["isAdmin"],
				"tipo" => $fila["tipo"]
            );
        }
        else
        {
            $respuesta = array( "existe" => false );
        }
        $link->liberarResultado($resultado);
        return $respuesta;
    }

    public function agregarEmpleado($link)
    {
		// si es una cadena: '%s'
		// si no es una cadena: %s
		// quitar url_imagen de la bd
        $sql = sprintf("INSERT INTO empleado VALUES (%s, %s, '%s', '%s', '%s', '%s', %s);",
            stripslashes($this->dni),
            stripslashes($this->afiliacion),
            stripslashes($this->nombre),
            stripslashes($this->username),
            stripslashes($this->pass),
			stripslashes($this->isAdmin),
			stripslashes($this->tipo)
        );
        if($link->ejecutarInstruccion($sql))
            echo "Empleado agregado con exito!";
        else
            echo "Error! No se agrego el Empleado.";
	}
	
	public function modificarEstudiante($link)
    {
        $sql = sprintf("
            UPDATE empleado 
            SET dni= '%s', afiliacion= '%s', nombre= '%s', username= '%s', pass= '%s', isAdmin= '%s', tipo= '%s'
            WHERE dni = '%s'",
			stripslashes($this->dni),
            stripslashes($this->afiliacion),
            stripslashes($this->nombre),
            stripslashes($this->username),
            stripslashes($this->pass),
			stripslashes($this->isAdmin),
			stripslashes($this->tipo)
        );
        if($link->ejecutarInstruccion($sql))
        {
            echo "Empleado modificado con exito!";
        }
        else
        {
            echo "Error! No se modifico el empleado.";
        }
    }
}

?>