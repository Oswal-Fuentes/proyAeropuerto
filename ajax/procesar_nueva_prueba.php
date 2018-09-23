<?php
include_once("../class/class_conexion.php");
include_once("../class/class_pruebas.php");

$link = new Conexion();

switch ($_GET["accion"])
{
    case 'guardarPrueba':
        $llave_primaria = Prueba::obtenerLlavePrimaria($link);

        // hacemos un nuevo empleado con los valores que tiene el empleado en la bd
        $prueba = new Prueba(
            $llave_primaria,
            $_POST["txt-numeroPrueba-Pruebas"],
            $_POST["txt-numeroRegistro-Pruebas"],
            $_POST["txt-nombre-Pruebas"],
            $_POST["txt-puntuacion-Pruebas"],
            $_POST["txt-fecha-Pruebas"],
            $_POST["txt-horas-Pruebas"],
            $_POST["txt-calificacion-Pruebas"],
            0
        );
        echo $empleado->agregarPrueba($link);
        break;

    case 'generarTabla':
        echo Prueba::generarPrueba($link);
        break;

    case 'eliminarPrueba':
        Prueba::eliminarPrueba($link, $_POST["numeroPrueba"]);
        break;

    case 'obtenerPrueba':
        echo json_encode(Prueba::obtenerEmpleado($link, $_POST["dni"]));
        break;

    case 'modificarPrueba':
        if(Prueba::verificarModificar($link, $_POST["txt-numeroPrueba-Pruebas"]
        {
            $prueba = new Prueba(
                $_POST["txt-numeroPrueba-Pruebas"],
                null,

                $_POST["txt-numeroRegistro-Pruebas"],
                $_POST["txt-nombre-Pruebas"],
                $_POST["txt-puntuacion-Pruebas"],
                $_POST["txt-fecha-Pruebas"],
                $_POST["txt-horas-Pruebas"],
                $_POST["txt-calificacion-Pruebas"],
            );
            echo $empleado->modificarEmpleado($link);
        }
        else
        {
            echo header('HTTP', true, 500);
        }
        break;

    default:
        echo header('HTTP', true, 500);
        break;
}

$link->cerrarConexion();

?>
