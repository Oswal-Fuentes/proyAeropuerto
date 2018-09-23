<?php session_start();

include_once("../class/class_conexion.php");
include_once("../class/class_empleado.php");

$link = new Conexion();
$respuesta = Empleado::verificarEmpleado($link, $_POST["txt-username-login"], $_POST["txt-clave-login"]);

if ($respuesta["existe"])
{	
	if ($respuesta["tipo"]=="1"||$respuesta["isAdmin"]==true) {
		$_SESSION["dni"] = $respuesta["dni"];
		$_SESSION["afiliacion"] = $respuesta["afiliacion"];
		$_SESSION["nombre"] = $respuesta["nombre"];
		$_SESSION["username"] = $respuesta["username"];
		$_SESSION["isAdmin"] = $respuesta["isAdmin"];
		echo json_encode($respuesta);
	} else {
		echo "Empleado no existe!";
	}
}
else
{
	echo "Empleado no existe!";
}

?>