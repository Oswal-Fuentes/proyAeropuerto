// todos los campos del formulario:
var campos =
[
    //"txt-numeroRegistro-avion",
    "txt-numeroModelo-avion",
];

actualizarTabla = function()
{
    // actualizar tabla con los valores en la bd
    $("#aviones").find("tr:gt(0)").remove();
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_avion.php?accion=generarTabla",
        method: "POST",
        success: function(tabla)
        {
            $("#aviones").append(tabla);
        }
    });
};

agregarDatos = function(objeto)
{
    $("#txt-numeroRegistro-avion").val(objeto.numeroRegistro);
    $("#txt-numeroModelo-avion").val(objeto.numeroModelo);
};

modificarAvion = function(parametros)
{
    $.ajax(
    {
        url: "../ajax/procesar_nuevo_avion.php?accion=modificarAvion",
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
    return $("input[name='rad-avion']:checked").val();
};

// solo entrar a esta parte cuando el documento este listo:
$(document).ready(function()
{
    // actualizar tabla con los valores en la bd
    actualizarTabla();

    $("#btn-nuevo-avion-cancelar").click(function(){
        limpiarCampos(campos);
    });

    $("#btn-nuevo-avion-guardar").click(function(){
        // esta func de verificarCampos es para ver que niguna este vacio va
        // byespues
        if(verificarCampos(campos))
        {
        console.log('hola');
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nuevo_avion.php?accion=guardarAvion",
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

    $("#btn-nuevo-avion-eliminar").click(function(){
        if(radioChecked())
        {
            var parametros = "numeroRegistro=" + radioChecked();
            $.ajax(
            {
                url: "../ajax/procesar_nuevo_avion.php?accion=eliminarAvion",
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

    $("#btn-nuevo-avion-editar").click(function() {
        $("#form-fotografia")[0].reset();
        if(radioChecked())
        {
            var parametros = "numeroRegistro=" + radioChecked();
            $.ajax(
            {
                method: "POST",
                data: parametros,
                url: "../ajax/procesar_nuevo_avion.php?accion=obtenerAvion",
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

    $("#btn-nuevo-avion-actualizar").click(function() {
        if(verificarCampos(campos))
        {
            var parametros = procesarParametros(campos);
            $.ajax({
                url: "../ajax/procesar_nuevo_avion.php?accion=modificarAvion",
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
