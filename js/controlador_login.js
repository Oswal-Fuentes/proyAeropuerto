var campos =
[
    "txt-username-login",
    "txt-clave-login"
];

procesarParametros = function(campos)
{
    var parametros = campos[0] + "=" + $.trim($("#"+campos[0]).val());
    for (i = 1; i < campos.length; i++)
    {
        parametros += "&" + campos[i] + "=" + $.trim($("#"+campos[i]).val());
    }
    return parametros;
};

$(document).ready(function()
{
    $("#btn-login").click(function()
    {
        $.ajax(
        {
            url: "ajax/procesar_login.php",
            type: "POST",
            // esta data se la enviamos al servidor:
            data: procesarParametros(campos),
            dataType: "json",
            success: function()
            {
                window.location = "menu/home.php";
            },
            error: function(error)
            {
                console.log(error);
                $("#div-error-login").html("Error! Empleado no existe.");
                $("#div-error-login").removeClass("hidden");
            }
        });
    });
});
