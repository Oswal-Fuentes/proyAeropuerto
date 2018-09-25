<?php

class Menu 
{
    private $dni;
    private $url_menu;
    private $menu;

    function __construct($dni, $url_menu, $menu)
    {
        $this->dni = $dni;
        $this->url_menu = $url_menu;
        $this->menu = $menu;
    }

    public function getDni()
    {
        return $this->dni;
    }
     
    public function setDni($dni)
    {
        $this->dni = $dni;
    }
    
    public function getUrlMenu()
    {
        return $this->url_menu;
    }
     
    public function setUrlMenu($url_menu)
    {
        $this->url_menu = $url_menu;
    }
    
    public function getMenu()
    {
        return $this->menu;
    }
     
    public function setMenu($menu)
    {
        $this->menu = $menu;
    }

    public function generarMenu($link)
    {
        $sql = "SELECT dni, isAdmin
            FROM empleado
            WHERE dni = $this->dni";
        $resultado = $link->ejecutarInstruccion($sql);
        while ($fila = $link->obtenerFila($resultado))
        {
            if ($fila["isAdmin"]) {
                echo "<li><a href='nuevo_empleado.php' class=\"menu-top-active\">Nuevo empleado</a></li>";
                echo "<li><a href='nuevo_avion.php' class=\"menu-top-active\">Nuevo avion</a></li>";
            } else {
                echo "<li><a href='nueva_prueba.php' class=\"menu-top-active\">Nuevo prueba</a></li>";
                echo "<li><a href='nuevo_avion.php' class=\"menu-top-active\">Mostrar aviones</a></li>";
            }
        }
        $link->liberarResultado($resultado);
    }

    public function verificarAcceso($link)
    {
        $sql = sprintf(
            "SELECT codigo_tipo_usuario, url_menu
            FROM tbl_menus
            WHERE codigo_tipo_usuario = '%s'
            AND url_menu = '%s'",
            stripslashes($this->codigo_tipo_usuario),
            stripslashes($this->url_menu)
        );
        $resultado = $link->ejecutarInstruccion($sql);
        if ($link->cantidadRegistros($resultado) > 0)
        {
            return array( "acceso" => true );
        }
        else
        {
            return array( "acceso" => false );
        }
    }

    public static function generarSettings($dni, $nombre)
    {
        echo "<div class='media-body'><h4 class='media-heading'><b>Nombre:</b> $nombre<br/><b>Dni:</b> $dni<br/></h4></div>";
    }
}
// CALL modificar_empleado (1, 2, "cano", "nozo", "123", 1);
?>
