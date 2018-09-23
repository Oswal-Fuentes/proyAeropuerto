var campos = 
[
    "txt-numero-prueba",
    "txt-dni-prueba", 
    "txt-nombre-Pruebas",
    "txt-puntuacion-Pruebas",
    "txt-fecha-Pruebas",
    "txt-horas-Pruebas",
    "txt-calificacion-Pruebas"
];

errorDeIntegridad = function()
{
    hasError("#div-txt-numeroPrueba-Pruebas");
};

resetFormulario = function()
{
    $("input[name=rad-Pruebas]").attr("checked",false);
    $("#div-alert-mensaje").addClass("hidden");
    $("#btn-nueva-Pruebas-actualizar").addClass("hidden");
    $("#btn-nueva-Pruebas-guardar").removeClass("hidden");
    $("#btn-modal").removeClass("hidden");
};

actualizarTabla = function()
{
    $("#aviones").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nueva_Pruebas.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#Pruebas").append(tabla);
        }
    });
};

agregarDatos = function(objeto)
{
    $("#txt-numeroPruebas-Pruebas").val(objeto.numero);
    $("#txt-numeroRegistro-Pruebas").val(objeto.registro);
    $("#txt-nombre-Pruebas").val(objeto.nombre);
    $("#txt-puntuacion-Pruebas").val(objeto.puntuacion);
    $("#txt-fecha-Pruebas").val(objeto.fechas);
    $("#txt-horas-Pruebas").val(objeto.horas);
    $("#txt-calificacion-Pruebas").val(objeto.calificacion);
};

radioChecked = function()
{
    return $("input[name='rad-Pruebas']:checked").val();
};

$(document).ready(function()
{
    actualizarTabla();
    $("#btn-nueva-Pruebas-guardar").click(function()
    {
        if(verificarCampos(campos))
        {
            var parametros = procesarParametros(campos);
            $.ajax(
            {
                url: "../ajax/procesar_nueva_prueba.php?accion=guardarPruebas",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function(texto)
                {
                    actualizarTabla();
                    limpiarCampos(campos);
                    resetFormulario();
                },
                error: function()
                {
                    errorDeIntegridad();
                    $("#div-alert-mensaje").html("Error! Ya existe una prueba con ese numero.");
                    $("#div-alert-mensaje").removeClass("hidden");
                }
            });
        }
    });

    $("#btn-nueva-Pruebas-cancelar").click(function()
    {
        limpiarCampos(campos);
        resetFormulario();
    });

    $("#btn-nueva-Prueba-eliminar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "numeroPrueba=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nueva-prueba.php?accion=eliminarPrueba",
                method: "POST",
                data: parametros,
                dataType: "html",
                success: function()
                {
                    actualizarTabla();
                    $("#div-alert-mensaje").addClass("hidden");
                }
            });
        }
    });

    $("#btn-nueva-Prueba-editar").click(function()
    {
        if(radioChecked())
        {
            var parametros = "numeroPrueba=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo-Prueba.php?accion=obtenerPruebas",
                method: "POST",
                data: parametros,
                dataType: "json",
                success: function(objeto)
                {
                    $("#btn-nueva-Prueba-actualizar").removeClass("hidden");
                    $("#btn-nueva-Prueba-guardar").addClass("hidden");
                    $("#btn-modal").addClass("hidden");
                    $("#div-alert-mensaje").addClass("hidden");
                    agregarDatos(objeto);
                }
            });
        }
    });

    $("#btn-nuevo-Prueba-actualizar").click(function()
    {
        var parametros = procesarParametros(campos);
        $.ajax(
        {
            url: "../ajax/procesar_nueva_Prueba.php?accion=modificarPrueba",
            method: "POST",
            data: parametros,
            success: function(texto)
            {
                actualizarTabla();
                limpiarCampos(campos);
                resetFormulario();
            },
            error: function()
            {
                errorDeIntegridad();
                $("#div-alert-mensaje").html("Error! Ya existe una Prueba con ese numero.");
                $("#div-alert-mensaje").removeClass("hidden");
            }
        });
    });
});