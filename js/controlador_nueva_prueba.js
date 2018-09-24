var campos = 
[
    "txt-numeroRegistro-prueba",
    "txt-nombre-prueba",
    "txt-puntuacion-prueba",
    "txt-fecha-prueba",
    "txt-horas-prueba",
    "txt-calificacion-prueba"
];

actualizarTabla = function()
{
    // actualizar tabla con los valores en la bd
    $("#prueba").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nueva_prueba.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#prueba").append(tabla);
        }
    });
};

verificarClave = function()
{
    var verificado = ($("#txt-numero-prueba").val() == $("#txt-numero-prueba").val());
    return verificado;
};

agregarDatos = function(objeto)
{
    $("#txt-numero-prueba").val(objeto.numeroPrueba);
    $("#txt-numeroRegistro-prueba").val(objeto.numeroRegistro);
    $("#txt-dni-prueba").val(objeto.dni);
    $("#txt-nombre-prueba").val(objeto.nombre);
    $("#txt-puntuacion-prueba").val(objeto.puntuacion);
    $("#txt-fecha-prueba").val(objeto.fecha);
    $("#txt-horas-prueba").val(objeto.horas);
    $("#txt-calificacion-prueba").val(objeto.calificaciones);
};

modificarEmpleado = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nueva_prueba.php?accion=modificarPrueba",
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
    return $("input[name='rad-empleados']:checked").val();
};

// solo entrar a esta parte cuando el documento este listo:
$(document).ready(function()
{
    // actualizar tabla con los valores en la bd
    actualizarTabla();
    //falta agregar cosas aqui. 

    $("#btn-nueva-prueba-cancelar").click(function(){
        limpiarCampos(campos);
    });

    $("#btn-nueva-prueba-guardar").click(function(){
        // guardar prueba
        if(verificarCampos(campos) && verificarClave())
        {
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nueva_prueba.php?accion=agregarPrueba",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function(texto)
                {
                    console.log(texto)
                    //actualizarTabla();
                    limpiarCampos(campos);
                },
                error: function(error)
                {
                    console.log(error)
                }
            });
        }
    });

    $("#btn-nueva-prueba-eliminar").click(function(){
        console.log(radioChecked());
        if(radioChecked())
        {
            var parametros = "dni=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nueva_prueba.php?accion=eliminarPrueba",
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

    $("#btn-nueva-prueba-editar").click(function() {
        $("#form-fotografia")[0].reset();
        if(radioChecked())
        {
            var parametros = "dni=" + radioChecked();
            $.ajax(
            {
                method: "POST",
                data: parametros,
                url: "../ajax/procesar_nueva_prueba.php?accion=obtenerPrueba",
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

    $("#btn-nueva-prueba-actualizar").click(function() {
        if(verificarCampos(campos) && verificarClave())
        {
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nueva_prueba.php?accion=modificarPrueba",
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