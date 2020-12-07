$(function() {
    //Elimina Dragón
    let BotonApareceDragon = document.querySelector(
        "#dragon_icon a img.dragon_icon"
    );
    let BotonEliminaDragon = document.querySelector(
        "#dragon_icon a img.prohibido"
    );

    dragonSvg = document.getElementsByClassName("dragon_svg");
    //listeners
    BotonEliminaDragon.addEventListener("click", eliminarDragon);
    BotonApareceDragon.addEventListener("click", apareceDragonSvg);
    //functions
    function eliminarDragon(e) {
        e.preventDefault();
        siExisteDragon = document.querySelector(
            ".buttonHeader img.prohibido.elimina"
        );
        if (siExisteDragon) {
            console.log("existe");
        } else {
            console.log("No existe");
            dragonSvg[0].classList.add("elimina");
            BotonEliminaDragon.classList.add("elimina");
            console.log(BotonApareceDragon);
            BotonApareceDragon.classList.add("margin_left_25");
        }
    }
    //$('.rojo').removeClass("rojo").addClass("verde");

    function apareceDragonSvg(e) {
        e.preventDefault();
        dragonSvg[0].classList.remove("elimina");
        BotonEliminaDragon.classList.remove("elimina");
        BotonApareceDragon.classList.remove("margin_left_25");
    }
    //Lettering
    $(".nombre-sitio").lettering();

    //Agregar clase a Menú

    $(
        'body.conferencia .navegacion-principal a:contains("Conferencia")'
    ).addClass("activo");
    $(
        'body.calendario .navegacion-principal a:contains("Calendario")'
    ).addClass("activo");
    $('body.invitados .navegacion-principal a:contains("Invitados")').addClass(
        "activo"
    );

    //Menu Fijo
    var windowHeight = $(window).height();
    var barraAltura = $(".barra").innerHeight();
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll > windowHeight) {
            $(".barra").addClass("fixed");
            $("body").css({
                "margin-top": barraAltura + "px",
            });
        } else {
            $(".barra").removeClass("fixed");
            $("body").css({
                "margin-top": "0px",
            });
        }
    });
    //Menu Responsive

    $(".menu-movil").on("click", function() {
        $(".navegacion-principal").slideToggle();
    });

    // Programa de Conferencias
    $(".programa-evento .info-curso:first").show();
    $(".menu-programa a").on("click", function() {
        $(".menu-programa a").removeClass("activo");
        $(this).addClass("activo");
        $(".ocultar").fadeOut(300);
        var enlace = $(this).attr("href");
        $(enlace).fadeIn(300);
        return false;
    });
    if (document.getElementsByClassName(".resumen-evento")) {
        //Animaciones para los numeros
        var resumenLista = jQuery(".resumen-evento");
        if (resumenLista.length > 0) {
            $(".resumen-evento").waypoint(
                function() {
                    $(".resumen-evento li:nth-child(1) p").animateNumber({
                            number: 6,
                        },
                        1200
                    );
                    $(".resumen-evento li:nth-child(2) p").animateNumber({
                            number: 15,
                        },
                        1200
                    );
                    $(".resumen-evento li:nth-child(3) p").animateNumber({
                            number: 3,
                        },
                        1400
                    );
                    $(".resumen-evento li:nth-child(4) p").animateNumber({
                            number: 9,
                        },
                        1500
                    );
                }, {
                    offset: "60%",
                }
            );
        }

        //cuenta regresiva

        $(".cuenta-regresiva").countdown(
            "2019/12/10 09:00:00",
            function(event) {
                $("#dias").html(event.strftime("%D"));
                $("#horas").html(event.strftime("%H"));
                $("#minutos").html(event.strftime("%M"));
                $("#segundos").html(event.strftime("%S"));
            }
        );
    }

    // Colorbox

    if ($(".invitado-info").length > 0) {
        $(".invitado-info").colorbox({
            inline: true,
            width: "50%",
        });
        $(".boton_newsletter").colorbox({
            inline: true,
            width: "50%",
        });
    }

    //Dragon
    dragon();

    function dragon() {
        setTimeout(function() {
            //Dragon
            "use strict";
            // Ported from flash
            // credits https://www.deviantart.com/gifhaas/art/Dragon-8681899 dragon by GifHaas on DeviantArt

            const screen = document.getElementById("screen");
            const xmlns = "http://www.w3.org/2000/svg";
            const xlinkns = "http://www.w3.org/1999/xlink";

            const resize = () => {
                width = window.innerWidth;
                height = window.innerHeight;
            };

            let width, height;
            window.addEventListener("resize", () => resize(), false);
            resize();

            const prepend = (use, i) => {
                const elem = document.createElementNS(xmlns, "use");
                elems[i].use = elem;
                elem.setAttributeNS(xlinkns, "xlink:href", "#" + use);
                screen.prepend(elem);
            };

            const N = 40;

            const elems = [];
            for (let i = 0; i < N; i++)
                elems[i] = { use: null, x: width / 2, y: 0 };
            const pointer = { x: width / 2, y: height / 2 };
            const radm = Math.min(pointer.x, pointer.y) - 20;
            let frm = Math.random();
            let rad = 0;

            for (let i = 1; i < N; i++) {
                if (i === 1) prepend("Cabeza", i);
                else if (i === 8 || i === 14) prepend("Aletas", i);
                else prepend("Espina", i);
            }

            const run = () => {
                requestAnimationFrame(run);
                let e = elems[0];
                const ax = (Math.cos(3 * frm) * rad * width) / height;
                const ay = (Math.sin(4 * frm) * rad * height) / width;
                e.x += (ax + pointer.x - e.x) / 10;
                e.y += (ay + pointer.y - e.y) / 10;
                for (let i = 1; i < N; i++) {
                    let e = elems[i];
                    let ep = elems[i - 1];
                    const a = Math.atan2(e.y - ep.y, e.x - ep.x);
                    e.x += (ep.x - e.x + (Math.cos(a) * (100 - i)) / 5) / 4;
                    e.y += (ep.y - e.y + (Math.sin(a) * (100 - i)) / 5) / 4;
                    const s = (162 + 4 * (1 - i)) / 50;
                    e.use.setAttributeNS(
                        null,
                        "transform",
                        `translate(${(ep.x + e.x) / 2},${
                            (ep.y + e.y) / 2
                        }) rotate(${
                            (180 / Math.PI) * a
                        }) translate(${0},${0}) scale(${s},${s})`
                    );
                }
                if (rad < radm) rad++;
                frm += 0.003;
                if (rad > 60) {
                    pointer.x += (width / 2 - pointer.x) * 0.05;
                    pointer.y += (height / 2 - pointer.y) * 0.05;
                }
            };

            run();
        }, 2000);
    }
});