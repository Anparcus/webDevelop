// JavaScript Document
//Creamos una funcion que le diga al documento que ejecute los comandos despues de cargar todo el html del sitio
$(document).ready(function() {
    $("#guardar-registro").on("submit", function(e) {
        //prevenimos la accion por defecto del botton que hemos seleccionado
        e.preventDefault();

        //creamos una variable que nos almacene los datos registrados
        var datos = $(this).serializeArray();

        //console.log(datos);
        $.ajax({
            type: $(this).attr("method"),
            data: datos,
            url: $(this).attr("action"),
            dataType: "json",
            success: function(data) {
                console.log(data);

                var resultado = data;

                //Creamos una respuesta para exito
                if (resultado.respuesta == "exito") {
                    Swal(
                        "Correcto!",
                        "Los datos han sido guardados correctamente!",
                        "success"
                    );
                    setTimeout(function() {
                        window.location.href = "admin-area.php";
                    }, 2300);
                } else {
                    Swal(
                        "Ooppsss :( !",
                        "Lo sentimos, hubo un error!",
                        "error"
                    );
                }
            },
        });
    });

    //Borrar registro
    $(".borrar_registro").on("click", function(e) {
        e.preventDefault();

        var id = $(this).attr("data-id");
        var tipo = $(this).attr("data-tipo");
        Swal.fire({
            title: "¿Estas seguro?",
            text: "Un registro eliminado no podra ser recuperado!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Eliminar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value === true) {
                $.ajax({
                    type: "post",
                    data: {
                        id: id,
                        registro: "eliminar",
                    },
                    url: "modelo-" + tipo + ".php",
                    success: function(data) {
                        console.log(data);
                        var resultado = JSON.parse(data);
                        if (resultado.respuesta == "exito") {
                            Swal(
                                "Eliminado!",
                                "Registro Eliminado con exito.",
                                "success"
                            );
                            jQuery('[data-id="' + resultado.id_eliminado + '"]')
                                .parents("tr")
                                .remove();
                        }
                    },
                });
            } else {
                Swal("Oops..", "No se pudo eliminar", "error");
            }
        });
    });
});