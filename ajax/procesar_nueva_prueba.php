<?php session_start();
include_once("../class/class_conexion.php");
include_once("../class/class_pruebas.php");

$link = new Conexion();

switch ($_GET["accion"])
{
    case 'agregarPrueba':
        $llave_primaria = Prueba::obtenerLlavePrimaria($link);
        // hacemos una nueva prueba con los valores que tiene la prueba en la bd
        $prueba = new Prueba(
            $llave_primaria,
            //$_POST["txt-numero-prueba"],
            $_POST["txt-numeroRegistro-prueba"],
            $_SESSION["dni"],
            $_POST["txt-nombre-prueba"],
            $_POST["txt-puntuacion-prueba"],
            $_POST["txt-fecha-prueba"],
            $_POST["txt-horas-prueba"],
            $_POST["txt-calificacion-prueba"]
        );
        echo $prueba->agregarPrueba($link);
        break;

    case 'generarTabla':
        echo Prueba::generarPrueba($link);
        break;

    //case 'eliminarPrueba':
     //   Prueba::eliminarPrueba($link, $_POST["numeroPrueba"]);
     //   break;

    case 'obtenerPrueba':
        echo json_encode(Prueba::obtenerPrueba($link, $_POST["numero-prueba"]));
        break;

    case 'modificarPrueba':
        if(Prueba::verificarModificar($link, $_POST["txt-numero-prueba"]))
        {
            $prueba = new Prueba(
                $_POST["txt-numero-prueba"],
                $_POST["txt-numeroRegistro-prueba"],
                $_POST["txt-dni-prueba"],
                $_POST["txt-nombre-prueba"],
                $_POST["txt-puntuacion-prueba"],
                $_POST["txt-fecha-prueba"],
                $_POST["txt-horas-prueba"],
                $_POST["txt-calificacion-prueba"]
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
