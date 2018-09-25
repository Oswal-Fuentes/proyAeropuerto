<?php
include_once("../class/class_conexion.php");
include_once("../class/class_empleado.php");

$link = new Conexion();

switch ($_GET["accion"])
{
    // case 'guardarEmpleado':
    //     $llave_primaria = Empleado::obtenerLlavePrimaria($link);
    //     $empleado = new Empleado(
    //         $llave_primaria,
    //         $_POST["txt-afiliacion-empleado"],
    //         $_POST["txt-nombre-empleado"],
    //         $_POST["txt-username-empleado"],
    //         $_POST["txt-clave-empleado"],
    //         0,
    //         $_POST["txt-tipo-empleado"]     
    //     );
    //     echo $empleado->agregarEmpleado($link);
    //     break;
        
    case 'agregarTecnico':
        $llave_primaria = Empleado::obtenerLlavePrimaria($link);
        $empleado = new Empleado(
            $llave_primaria,
            $_POST["txt-afiliacion-empleado"],
            $_POST["txt-nombre-empleado"],
            $_POST["txt-username-empleado"],
            $_POST["txt-clave-empleado"],
            0,
            1,
            $_POST["txt-direccion-empleado"],
            $_POST["txt-telefono-empleado"],
            $_POST["txt-sueldo-empleado"],
            0
        );

        echo $empleado->agregarTecnico($link);
        break;

    case 'agregarControladorAereo':
        $llave_primaria = Empleado::obtenerLlavePrimaria($link);
        $empleado = new Empleado(
            $llave_primaria,
            $_POST["txt-afiliacion-empleado"],
            $_POST["txt-nombre-empleado"],
            $_POST["txt-username-empleado"],
            $_POST["txt-clave-empleado"],
            0,
            0,
            0,
            0,
            0,
            $_POST["txt-fechaExamen-empleado"]
        );

        echo $empleado->agregarControladorAereo($link);
        break;

    case 'generarTabla':
        echo Empleado::generarEmpleado($link);
        break;

    case 'eliminarEmpleado':
        Empleado::eliminarEmpleado($link, $_POST["dni"]);
        break;

    case 'obtenerEmpleado':
        echo json_encode(Empleado::obtenerEmpleado($link, $_POST["dni"]));
        break;

    case 'modificarEmpleado':
        if(Empleado::verificarModificar($link, $_POST["txt-dni-empleado"], $_POST["txt-username-empleado"]))
        {
            $empleado = new Empleado(
                $_POST["txt-dni-empleado"],
                null,
                $_POST["txt-afiliacion-empleado"],
                $_POST["txt-nombre-empleado"],
                $_POST["txt-username-empleado"],
                $_POST["txt-clave-empleado"],
                $_POST["txt-isAdmin-empleado"],
                $_POST["input-foto-empleado"],
                $_POST["txt-verificar-clave-empleado"]
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
