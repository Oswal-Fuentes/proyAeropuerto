<?php session_start();
	
include_once('../class/class_conexion.php');
include_once('../class/class_menu.php');
$link = new Conexion();

switch ($_GET['accion'])
{
	
	case 'generarMenu':
		$menu = new Menu(
			$_SESSION['dni'],
			$_POST['pagina'],
			null
		);

		echo $menu->generarMenu($link);
		break;

	case 'verificarAcceso':
		$menu = new Menu(
			$_SESSION['dni'],
			$_POST['pagina'],
			null
		);
		echo json_encode($menu->verificarAcceso($link));
		break;

	case 'generarSettings':
		echo Menu::generarSettings($_SESSION['dni'], $_SESSION['nombre']);
		break;

	default:
		echo header('HTTP', true, 500);
		break;
}

$link->cerrarConexion();

?>
