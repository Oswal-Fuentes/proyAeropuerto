// todos los campos del formulario:
var campos =
[
    "txt-afiliacion-empleado",
    "txt-nombre-empleado",
    "txt-username-empleado",
    "txt-clave-empleado",
    "txt-verificar-clave-empleado",
    "txt-tipo-empleado",
];

actualizarTabla = function()
{
    // actualizar tabla con los valores en la bd
    $("#empleado").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_empleado.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#empleado").append(tabla);
        }
    });
};

verificarClave = function()
{
    var verificado = ($("#txt-clave-empleado").val() == $("#txt-verificar-clave-empleado").val());
    return verificado;
};

agregarDatos = function(objeto)
{
    $("#txt-dni-empleado").val(objeto.dni);
    $("#txt-afiliacion-empleado").val(objeto.afiliacion);
    $("#txt-nombre-empleado").val(objeto.nombre);
    $("#txt-username-empleado").val(objeto.username);
    $("#txt-clave-empleado").val(objeto.clave);
    $("#txt-isAdmin-empleado").val(objeto.isAdmin);
    $("#txt-tipo-empleado").val(objeto.tipo);
};

modificarEmpleado = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_empleado.php?accion=modificarEmpleado",
        method: "POST",
        data: parametros,
        dataType: "html",
        success:function(texto)
        {
            actualizarTabla();
            limpiarCampos(campos);
        },
        error:function(error)
        {
            console.log(error)
        }
    });
};

radioChecked = function()
{
    // obtener el valor del radio button que esta con un check
    return $("input[name='rad-empleado']:checked").val();
};

// solo entrar a esta parte cuando el documento este listo:
$(document).ready(function()
{
    // actualizar tabla con los valores en la bd
    actualizarTabla();

    $("#btn-nuevo-empleado-cancelar").click(function(){
        limpiarCampos(campos);
    });

    $("#btn-nuevo-empleado-guardar").click(function(){
        // guardar empleado
        if(verificarCampos(campos) && verificarClave())
        {
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nuevo_empleado.php?accion=guardarEmpleado",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function(texto)
                {
                    console.log(texto)
                    actualizarTabla();
                    limpiarCampos(campos);
                },
                error: function(error)
                {
                    console.log(error)
                }
            });
        }
    });

    $("#btn-nuevo-empleado-eliminar").click(function(){
        if(radioChecked())
        {
            var parametros = "dni=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_empleado.php?accion=eliminarEmpleado",
                method: "POST",
                data: parametros,
                dataType: "html",
                success:function()
                {
                    actualizarTabla();
                }
            });
        }
    });

    $("#btn-nuevo-empleado-editar").click(function() {
        $("#form-fotografia")[0].reset();
        if(radioChecked())
        {
            var parametros = "dni=" + radioChecked();
            $.ajax(
            {
                method: "POST",
                data: parametros,
                url: "../ajax/procesar_nuevo_empleado.php?accion=obtenerEmpleado",
                dataType: "json",
                success:function(objeto)
                {
                    // $("#btn-modal").addClass("hidden");
                    agregarDatos(objeto);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    $("#btn-nuevo-empleado-actualizar").click(function() {
        if(verificarCampos(campos) && verificarClave())
        {
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nuevo_empleado.php?accion=modificarEmpleado",
                method: "POST",
                data: parametros,
                dataType: "html",
                success:function(texto)
                {
                    actualizarTabla();
                    limpiarCampos(campos);
                },
                error:function(error)
                {
                    console.log(error)
                }
            });
        }
    });
});