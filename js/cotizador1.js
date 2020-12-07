(function() {
    "use strict";

    document.addEventListener("DOMContentLoaded", function() {
        var regalo = document.getElementById("regalo"); //Lo ponemos antes del DomContentLoaded para que se carge la información antes de definir las normas de la función
        //Le dice al buscador que carge el documento despues de haber cargado todo el DOM del Contenido

        //Campos datos de usuario

        var nombre = document.getElementById("nombre"); //Tomamos el DOM del HTML para crear una variable
        var apellido = document.getElementById("apellido");
        var email = document.getElementById("email");

        //Campos pases

        var pase_dia = document.getElementById("pase_dia");
        var pase_dosdias = document.getElementById("pase_dosdias");
        var pase_completo = document.getElementById("pase_completo");

        //Botones y divs

        var calcular = document.getElementById("calcular");
        var errorDiv = document.getElementById("error");
        var botonRegistro = document.getElementById("btnRegistro");
        var lista_productos = document.getElementById("lista-productos");
        var suma = document.getElementById("suma-total");

        //Extras

        var camisas = document.getElementById("camisa_evento");
        var etiquetas = document.getElementById("etiquetas");

        //Ocultar Casillas en Registro
        /*
        var a = document.getElementById("pase_dia");
        var b = document.getElementById("pase_dosdia");
        var c = document.getElementById("pase_completo");
        */
        //prevenimos errores con un if para que los archivos puedan ser cargados al cargar solo la pagina en la que queremos que actue

        if (document.getElementById("calcular")) {
            calcular.addEventListener("click", calcularMontos); //Le decimos al buscador que calcular oye el Click en el botón y ejecuta la función calcularMontos

            botonRegistro.disabled = true; //desactivamos el boton de pagar

            pase_dia.addEventListener("blur", mostrarDias); // le decimos al buscador que pase_dia registra el ultimo dato introducido con 'blur' y ejecuta la funcion mostrarDias
            pase_dosdias.addEventListener("blur", mostrarDias);
            pase_completo.addEventListener("blur", mostrarDias);

            /*a.addEventListener("blur", ocultarDias);
            b.addEventListener("blur", ocultarDias);
            c.addEventListener("blur", ocultarDias);*/

            nombre.addEventListener("blur", validarCampos);
            apellido.addEventListener("blur", validarCampos);
            email.addEventListener("blur", validarCampos);
            email.addEventListener("blur", validarMail);

            var formulario_editar = document.getElementsByClassName(
                "editar-registrado"
            );
            if (formulario_editar.length > 0) {
                if (
                    pase_dia.value ||
                    pase_dosdias.value ||
                    pase_completo.value
                ) {
                    mostrarDias();
                }
            }

            function validarCampos() {
                if (this.value == "") {
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "Este campo es obligatorio";
                    this.style.border = "1px solid red";
                    errorDiv.style.border = "1px solid red";
                } else {
                    errorDiv.style.display = "none";
                    this.style.border = "1px solid #cccccc";
                }
            } //function validarCampos

            function validarMail() {
                if (this.value.indexOf("@") > -1) {
                    errorDiv.style.display = "none";
                    this.style.border = "1px solid #cccccc";
                } else {
                    errorDiv.style.display = "block";
                    errorDiv.innerHTML = "debe tener al menos una @";
                    this.style.border = "1px solid red";
                    errorDiv.style.border = "1px solid red";
                }
            } // Function validaMail

            function calcularMontos(event) {
                //Decimos que es un event
                event.preventDefault();
                if (regalo.value === "") {
                    alert("Debes elegir un regalo");
                    regalo.focus();
                } else {
                    var boletosDia = parseInt(pase_dia.value, 10) || 0,
                        boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                        boletoCompleto = parseInt(pase_completo.value, 10) || 0,
                        cantCamisas = parseInt(camisas.value, 10) || 0,
                        cantEtiquetas = parseInt(etiquetas.value, 10) || 0;

                    var totalPagar =
                        boletosDia * 30 +
                        boletos2Dias * 45 +
                        boletoCompleto * 50 +
                        cantCamisas * 10 * 0.93 +
                        cantEtiquetas * 2;

                    var listadoProductos = [];

                    if (boletosDia >= 1) {
                        listadoProductos.push(boletosDia + " Pases por día");
                    }
                    if (boletos2Dias >= 1) {
                        listadoProductos.push(
                            boletos2Dias + " Pases por 2 días"
                        );
                    }
                    if (boletoCompleto >= 1) {
                        listadoProductos.push(
                            boletoCompleto + " Pases completos"
                        );
                    }
                    if (cantCamisas >= 1) {
                        listadoProductos.push(cantCamisas + " Camisas");
                    }
                    if (cantEtiquetas >= 1) {
                        listadoProductos.push(cantEtiquetas + " Etiquetas");
                    }
                    lista_productos.style.display = "block";
                    lista_productos.innerHTML = "";

                    for (var i = 0; i < listadoProductos.length; i++) {
                        lista_productos.innerHTML +=
                            listadoProductos[i] + "<br/>";
                    }
                    suma.innerHTML = totalPagar.toFixed(2) + " €";

                    botonRegistro.disabled = false;
                    document.getElementById("total_pedido").value = totalPagar;
                }
            }

            function mostrarDias() {
                var boletosDia = parseInt(pase_dia.value, 10) || 0,
                    boletos2Dias = parseInt(pase_dosdias.value, 10) || 0,
                    boletoCompleto = parseInt(pase_completo.value, 10) || 0;

                var diasElegidos = [];

                if (boletosDia > 0) {
                    diasElegidos.push("Friday");
                }
                if (boletos2Dias > 0) {
                    diasElegidos.push("Friday", "Saturday");
                }
                if (boletoCompleto > 0) {
                    diasElegidos.push("Friday", "Saturday", "Sunday");
                }
                for (var i = 0; i < diasElegidos.length; i++) {
                    document.getElementById(diasElegidos[i]).style.display =
                        "block";
                }
            } //funcion mostarDias

            // los oculta si vuelven a 0
            if (diasElegidos.length == 0) {
                var todosDias = document.getElementsByClassName(
                    "contenido-dia"
                );
                for (var i = 0; i < todosDias.length; i++) {
                    todosDias[i].style.display = "none";
                }
            }

            /* function ocultarDias() {
                var pa = parseInt(a.value, 10) || 0,
                    pb = parseInt(b.value, 10) || 0,
                    pc = parseInt(c.value, 10) || 0;

                var out = [];

                if (pa + pb + pc <= "0") {
                    out.push(
                        "viernes",
                        "sabado",
                        "domingo",
                        "Friday",
                        "Saturday",
                        "Sunday"
                    );
                    for (var i = 0; i < out.length; i++) {
                        document.getElementById(out[i]).style.display = "none";
                    }
                } else {
                    if (pb + pc <= "0") {
                        out.push("sabado", "domingo", "Saturday", "Sunday");
                        for (var d = 0; d < out.length; d++) {
                            document.getElementById(out[d]).style.display =
                                "none";
                        }
                    } else {
                        if (pc <= "0") {
                            out.push("domingo", "Sunday");
                            for (var e = 0; e < out.length; e++) {
                                document.getElementById(out[e]).style.display =
                                    "none";
                            }
                        }
                    }
                }
            } // funcion ocultarDias*/
        } //if previniendo errores en javaScript
    }); // DOM CONTENT LOADED
})();