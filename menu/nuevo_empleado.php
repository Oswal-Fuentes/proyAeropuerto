<?php session_start();
if (!isset($_SESSION["dni"]))
    header("Location: ../login.php");

include_once("../class/class_conexion.php");
include_once("../class/class_empleado.php");
include_once("../class/class_menu.php");
$link = new Conexion();
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="Cache-control" content="no-cache" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <![endif]-->
    <title>UNITEC | Nuevo Empleado</title>
    <link rel="icon" type="image/png" href="../favicon.ico">
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <!-- FONT AWESOME ICONS  -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="../assets/css/style.css" rel="stylesheet" />
     <!-- HTML5 Shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Email: </strong>soporte@unitec.hn
                    &nbsp;&nbsp;
                    <strong>Ayuda: </strong>+504 2232 6112
                </div>
            </div>
        </div>
    </header>
    <!-- HEADER END-->
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../index.html">
                    <img src="../assets/img/unah-logo-mini.png"/>
                </a>
            </div>
            <div class="left-div">
                <div class="user-settings-wrapper">
                    <ul class="nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <span class="glyphicon glyphicon-user" style="font-size: 25px;"></span>
                            </a>
                            <div class="dropdown-menu dropdown-settings">
                                <div class="media" id="div-user-settings"></div>
                                <hr />
                                <a href="cerrar_sesion.php" class="btn btn-danger btn-sm">Cerrar sesion</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- MENU SECTION END-->
    <div class="content-wrapper" id="div-wrapper">
        <div class="container">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                       <b>Nuevo Empleado</b>
                    </div>
                    <div class="panel-body">
                    <!-- <div class="form-group" id="div-txt-tipo-empleado">
                            <label class="control-label" for="txt-tipo-empleado">Tipo de Empleado:</label>
                            <input type="password" class="form-control" id="txt-tipo-empleado">
                        </div> -->
                        <div class="form-group" id="div-slc-tipo-empleado">
                            <label class="control-label" for="slc-tipo-empleado">Tipo de Empleado:</label>
                            <select class="form-control" id="slc-tipo-empleado">
                                <option value="0"></option>
                                <option value="1">Tecnico</option>
                                <option value="2">Controlador aereo</option>
                            </select>
                        </div>
                        <div class="form-group" id="div-txt-nombre-empleado" >
                          <label class="control-label" for="txt-nombre-empleado">Nombre:</label>
                          <input type="text" class="form-control" id="txt-nombre-empleado">
                          <input type="hidden" class="form-control" id="txt-dni-empleado" value="">
                        </div>
                        <div class="form-group" id="div-txt-afiliacion-empleado" >
                          <label class="control-label" for="txt-afiliacion-empleado">Afiliacion:</label>
                          <input type="text" class="form-control" id="txt-afiliacion-empleado">
                        </div>
                        <div class="form-group" id="div-txt-username-empleado" >
                          <label class="control-label" for="txt-username-empleado">Username:</label>
                          <input type="text" class="form-control" id="txt-username-empleado">
                        </div>
                        <div class="form-group" id="div-txt-clave-empleado">
                            <label class="control-label" for="txt-clave-empleado">Clave:</label>
                            <input type="password" class="form-control" id="txt-clave-empleado">
                        </div>
                        <div class="form-group" id="div-txt-verificar-clave-empleado">
                            <label class="control-label" for="txt-verificar-clave-empleado">Verificar su clave:</label>
                            <input type="password" class="form-control" id="txt-verificar-clave-empleado">
                        </div>
                        <div class="form-group" id="div-txt-direccion-empleado">
                            <label class="control-label" for="txt-direccion-empleado">Dirección:</label>
                            <input type="text" class="form-control" id="txt-direccion-empleado">
                        </div>
                        <div class="form-group" id="div-txt-telefono-empleado">
                            <label class="control-label" for="txt-telefono-empleado">Teléfono:</label>
                            <input type="text" class="form-control" id="txt-telefono-empleado">
                        </div>
                        <div class="form-group" id="div-txt-sueldo-empleado">
                            <label class="control-label" for="txt-sueldo-empleado">Sueldo:</label>
                            <input type="text" class="form-control" id="txt-sueldo-empleado">
                        </div>
                        <div class="form-group" id="div-txt-fechaExamen-empleado">
                            <label class="control-label" for="txt-fechaExamen-empleado">Fecha Examen:</label>
                            <input type="date" class="form-control" id="txt-fechaExamen-empleado">
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-default" id="btn-nuevo-empleado-cancelar">Cancelar</button>
                        <button type="button" class="btn btn-success hidden" id="btn-nuevo-empleado-actualizar">Actualizar</button>
                        <button type="button" class="btn btn-primary" id="btn-nuevo-empleado-guardar">Guardar</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel panel-info">
                    <div class="panel-heading">
                       <b>Tabla de Empleados</b>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <table class="table table-striped table-hover" id="empleado">
                                <th></th>
                                <th>DNI</th>
                                <th>Afiliacion</th>
                                <th>Tipo de Usuario</th>
                                <th>Nombre</th>
                                <th>Username</th>
                            </table>
                        </div>
                    </div>
                    <div class="panel-footer">
                    <button class="btn btn-primary btn-xs" id="btn-nuevo-empleado-editar"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</button>
                    <button class="btn btn-danger btn-xs" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-modal"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CONTENT-WRAPPER SECTION END-->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    IS424 Septiembre, 2018  |  Grupo 5</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END-->
    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-body"><b>¿Esta seguro de que desea eliminar este registro?</b></div>
          <div class="modal-footer">
              <button class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-sm">Cancelar</button>
              <button class="btn btn-danger" data-toggle="modal" data-target=".bs-example-modal-sm" id="btn-nuevo-empleado-eliminar"><i class="fa fa-times" aria-hidden="true"></i> Eliminar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Small modal -->
    <!-- JAVASCRIPT AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY SCRIPTS -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/controlador.js"></script>
    <script src="../js/controlador_nuevo_empleado.js"></script>
</body>
</html>
