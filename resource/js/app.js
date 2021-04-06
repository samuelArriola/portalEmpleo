/*Codigo de usuarios */
var data_User = null;
var data_Estudio = null;
var data_Experiencia = null;
var data_Perfil = null;
var data_Hdv = null;
var data_Convo = null;

var usuarios = new Usuarios();
var loginUser = () => {
    usuarios.loginUser();
}

var sessionClose = () => {
    usuarios.sessionClose();
}

var restablecerUser = () => {
    usuarios.restablecerUser();
}

/** Restablecer desde la url "user/registro" */
var restablecerUsers = () => {
    usuarios.restablecerUsers();
}

var restablecerEmpresa = () => {
    usuarios.restablecerEmpresa();
}

var restablecerEmpresaUser = () => {
    usuarios.restablecerEmpresaUser();
}

var archivo = (evt) => {
    usuarios.archivo(evt, "fotos");
}

var getIdentificaciones = () => {
    usuarios.getIdentificaciones(null, 1);
}

var getCategorias = () => {
    usuarios.getCategorias(null, 1);
}

/*Reset contraseña*/
$(function () {
    $("#btn-reset").click(function () {
        let id = document.getElementById("id").value;
        if (id != "") {
            usuarios.resetPassword(id);
            return false;
        }

    });
});

/*Reset contraseña save*/
$(function () {
    $("#btn-resetsave").click(function () {
        let password = document.getElementById("password").value;
        let repassword = document.getElementById("repassword").value;
        if (password != "" && repassword != "") {
            usuarios.resetPasswordSave(password, repassword);
            return false;
        }

    });
});

/*Codigo de registro usuario-rol persona (PANEL ADMIN)*/
$(function () {
    $("#btn-registro").click(function () {
        return usuarios.registroUser();
    });

    $("#registerClose").click(function () {
        usuarios.restablecerUser();
    });

    $("#deleteUser").click(function () {
        usuarios.deleteUser(data_User);
        data_User = null;
    });

});

/*Codigo de registro usuario-rol empresa (PANEL ADMIN)*/
$(function () {
    $("#btn-registro-empresa").click(function () {
        return usuarios.registroEmpresa();
    });

    $("#registerCloseEmp").click(function () {
        usuarios.restablecerEmpresa();
    });
});

/*Codigo de registro usuario-rol empresa*/
$(function () {
    $("#btn-registro-empresaU").click(function () {
        let id = document.getElementById("id").value;
        let nomb_emp = document.getElementById("nomb_emp").value;
        let razon_s = document.getElementById("razon_s").value;
        let direccion = document.getElementById("direccion").value;
        let telefono_emp = document.getElementById("telefono_emp").value;
        let password = document.getElementById("password").value;
        if (id != "" && nomb_emp != "" && razon_s != "" && direccion != "" && telefono_emp != "" && password != "") {
            usuarios.registroEmpresaUser(id, nomb_emp, razon_s, direccion, telefono_emp, password);
            return false;
        }
    });
});


/*Codigo de registro usuario-rol persona*/
$(function () {
    $("#btn-registro-users").click(function () {
        let nomb_pers = document.getElementById("nomb_pers").value;
        let ape_pers = document.getElementById("ape_pers").value;
        let codi_iden = document.getElementById("codi_iden");
        let identificacion = codi_iden.options[codi_iden.selectedIndex].value;
        let id = document.getElementById("id").value;
        let direccion = document.getElementById("direccion").value;
        let password = document.getElementById("password").value;
        if (nomb_pers != "" && ape_pers != "" && identificacion != "Seleccione un tipo de identificación" && id != "" && direccion != "" && password != "") {
            usuarios.registroUsers(nomb_pers, ape_pers, identificacion, id, direccion, password);
            return false;
        }

    });
});

var getUsers = (page) => {
    let valor = document.getElementById("filtrarUser").value;
    usuarios.getUsers(valor, page);
}

var getBusquedaUsers = (page) => {
    $("#btn-filtrouser").click(function (event) {
        event.preventDefault();
    let id_categoria = document.getElementById("id_categoria").value;
    let id_perfil = document.getElementById("id_perfil").value;
    empresa.getBusquedaUsers(id_categoria, id_perfil, page);
});
}

var getConvoCandidatos = (page) => {
    $("#btn-filtrocandidatos").click(function (event) {
        event.preventDefault();
    let convocatoria_lab = document.getElementById("convocatoria_lab").value;
    empresa.getConvoCandidatos(convocatoria_lab, page);
});
}

var dataBusquedaUser = (data) => {
    empresa.viewUserData(data);
    //console.log(data);
}

var dataConvocatoria = (data) => {
    empresa.editConvocatoria(data);
    //console.log(data);
}

var dataConvoCandidatos = (data) => {
    empresa.viewCandidatoData(data);
    //console.log(data);
}
var editEstadoCandidato = (data) => {
    empresa.editEstadoCandidato(data);
//console.log(data_Candidato);
}

var getEmpresas = (page) => {
    let valor_emp = document.getElementById("filtrarEmpresa").value;
    usuarios.getEmpresas(valor_emp, page);
}

var dataUser = (data) => {
    usuarios.editUser(data);
    //console.log(data);
}

var deleteUser = (data) => {
    document.getElementById("iduser").innerHTML = "Identificación: " + data.id;
    document.getElementById("nombreuser").innerHTML = "Nombre: " + data.nomb_pers + " " + data.ape_pers;
    data_User = data;
}

var dataEmpresa = (data) => {
    usuarios.editEmpresa(data);
}

/*Actualizar perfil save*/
$(function () {
    $("#btn-act-perfil").click(function () {
        return usuarios.actUser();
    });
});

/*EMPRESA*/
var empresa = new Empresa();

var restablecerConvocatoria = () => {
    empresa.restablecerConvocatoria();
}

var getCategorias_laborales = () => {
    empresa.getCategorias_laborales(null, 1);
}

var getContratos = () => {
    empresa.getContratos(null, 1);
}

var getConvocatoriasLabs = () => {
    empresa.getConvocatoriasLabs(null, 1);
}


$(function () {
    $("#registerConvocatoria").click(function () {
        return empresa.registerConvocatorias();
    });

    $("#convocatoriaClose").click(function () {
        empresa.restablecerConvocatoria();
    });

    $("#deleteConvo").click(function () {
        empresa.deleteConvo(data_Convo);
        data_Convo = null;
    });
});

var getConvocatorias = (page) => {
    let valor = document.getElementById("filtrarConvocatoria").value;
    empresa.getConvocatorias(valor, page);
}

var dataConvocatoria = (data) => {
    empresa.editConvocatoria(data);
}


var userBusquedaclose = () => {
    empresa.userBusquedaclose();
}

var convoCandidatosclose = () => {
    empresa.convoCandidatosclose();
}

/**---------------------------------------------------------PERSONA----------------------------------------------------- */

var persona = new Persona();

//Select que contiene los tipos de identificaciones
var getIdentificaciones = () => {
    persona.getIdentificaciones(null, 1);
}

//Select que contiene los tipos de estado civil
var getEstadoCivil = () => {
    persona.getEstadoCivil(null, 1);
}

$(function () {
    $("#btn-registro-datosp").click(function (event) {
        event.preventDefault();
        persona.saveDatosPersonales();

    });
});

var getListaEstudios = (page) => {
    let valor = document.getElementById("filtrarEstudio").value;
    persona.getListaEstudios(valor, page);
}

//Select que contiene los tipos de estudio
var getTipoEstudio = () => {
    persona.getTipoEstudio(null, 1);
}

//Select que contiene los idiomas
var getIdiomas = () => {
    persona.getIdiomas(null, 1);
}

$(function () {
    $("#btnacademicoplus").click(function (event) {
        event.preventDefault();
        persona.saveDatosAPlus();

    });
});

$(function () {
    $("#btnregistroestudio").click(function () {
        persona.registerEstudios();
    });

    $("#registerEstudioClose").click(function () {
        persona.restablecerEstudios();
    });

    $("#deleteEstudio").click(function () {
        persona.deleteEstudio(data_Estudio);
        data_estudio = null;
    });

});

var restablecerEstudios = () => {
    persona.restablecerEstudios();
}

var getListaExperiencias = (page) => {
    let valor = document.getElementById("filtrarExperiencia").value;
    persona.getListaExperiencias(valor, page);
}

$(function () {
    $("#btnregistroexperiencia").click(function () {
        persona.registerExperiencias();
    });

    $("#registerExperienciaClose").click(function () {
        persona.restablecerExperiencias();
    });

    $("#deleteExperiencia").click(function () {
        persona.deleteExperiencia(data_Experiencia);
        data_Experiencia = null;
    });

});

var restablecerExperiencias = () => {
    persona.restablecerExperiencias();
}

var getListaPerfiles = (page) => {
    let valor = document.getElementById("filtrarPerfil").value;
    persona.getListaPerfiles(valor, page);
}

//Select que contiene las categorías laborales
var getCatLaboral = () => {
    persona.getCatLaboral(null, 1);
    empresa.getCatLaboral(null, 1);
}

//Select que contiene los perfiles laborales para actualizar
var getPerfilUpdate = () => {
    persona.getPerfilUpdate(null, 1);
}
//Select que contiene los perfiles laborales
var getPerfilLaboral = () => {
    persona.getPerfilLaboral(null, 1);
    empresa.getPerfilLaboral(null, 1);
}


//Lista de tecnologías check
var getTecnologias = () => {
    persona.getTecnologias();
}

$(function () {
    $("#btnregistroperfil").click(function () {
        persona.registerPerfiles();
    });

    $("#registerPerfilClose").click(function () {
        persona.restablecerPerfiles();
    });

    $("#deletePerfil").click(function () {
        persona.deletePerfil(data_Perfil);
        data_Perfil = null;
    });

});

$(function () {
    $("#btntecnologias").click(function () {
        persona.registerTecnologias();
    });

});

var restablecerPerfiles = () => {
    persona.restablecerPerfiles();
}


//Data perfil del usuario
var dataPersona = (data) => {
    persona.getDataPersona(data);
    //console.log(data);
}

var soporteUser = (evt) => {
    persona.archivo(evt, "soporteUser");
}

//Data para actualizar estudios acádemicos del usuario
var dataEstudio = (data) => {
    persona.editEstudio(data);
    //console.log(data);
}

//Data para actualizar la experiencia laboral del usuario
var dataExperiencia = (data) => {
    persona.editExperiencia(data);
    //console.log(data);
}

//Data para actualizar perfil laboral del usuario
var dataPerfil = (data) => {
    persona.editPerfil(data);
    //console.log(data);
}

var deleteEstudio = (data) => {
    document.getElementById("nomb_titulo").innerHTML = "Programa Acádemico: " + data.titulo;
    document.getElementById("nomb_institucion").innerHTML = "Institución: " + data.institucion;
    data_Estudio = data;
}

var deleteExperiencia = (data) => {
    document.getElementById("empresa").innerHTML = "Empresa: " + data.nomb_empresa;
    document.getElementById("cargo_exp").innerHTML = "Cargo: " + data.cargo;
    data_Experiencia = data;
}

var deletePerfil = (data) => {
    document.getElementById("perfil_titulo").innerHTML = "Título: " + data.titulo;
    data_Perfil = data;
}

var deleteConvo = (data) => {
    document.getElementById("nomb_convocatoria").innerHTML = "Cargo: " + data.nomb_cargo;
    document.getElementById("perfil_convocatoria").innerHTML = "Perfil: " + data.perfil;
    data_Convo = data;
}

//Data para actualizar datos personales del usuario
var dataDatosPersonales = (data) => {
    persona.getdataDatosPersonales(data);
    //console.log(data);
}

//lista Hdv
var getListaHdv = (page) => {
    persona.getListaHdv(page);
}

//Subir HDV
$(function () {
    $("#subir_hdv").click(function (event) {
        event.preventDefault();
        persona.RegisterHdv();
    });



    $("#deleteHdv").click(function () {
        persona.deleteHdv(data_Hdv);
        data_Hdv = null;
    });

});

var dataHdv = (data) => {
    $("#editEstadoVisibleHdv").click(function () {
        persona.editEstadoHdv(data);
    });
    document.getElementById("nomb_file").innerHTML = "Nombre del Archivo: " + data.hoja_de_vida;
}

var editEstadoDefaultHdv = () => {
    persona.editEstadoDefaultHdv();

}
var deleteHdv = (data) => {
    document.getElementById("nomb_hdv").innerHTML = "Nombre del Archivo: " + data.hoja_de_vida;
    data_Hdv = data;
}

$(function () {
    $("#restablecerHdv").click(function () {
        persona.restablecerHdv();
    });

});


var restablecerHdv = () => {
    persona.restablecerHdv();
}

$(function () {
    $("#restablecerEstadoPerfil").click(function () {
        persona.restablecerEstadoPerfil();
    });

});

var restablecerEstadoPerfil = () => {
    persona.restablecerEstadoPerfil();
}


/*---------------------------------------Convocatorias laborales--------------------------------------------------------*/
$(function () {
    $("#btnregistropostulante").click(function () {
        persona.registerPostulantes();
    });
});

var getListaPostulaciones = (page) => {
    persona.getListaPostulaciones(page);
}
/*---------------------------------------------------------INDEX---------------------------------------------------------*/
var dataConvo = (data) => {
    usuarios.verOferta(data);
    //console.log(data);
}

$(function () {
    $("#verOfertaClose").click(function () {
        usuarios.restablecerverOferta();
    });

});

var getListaConvocatoria = (page) => {
    let valor = document.getElementById("filtrarConvo").value;
    usuarios.getListaConvocatoria(valor, page);
}

var getListadoConvocatoria = (page) => {
    let valor = document.getElementById("filtrarConvo").value;
    persona.getListadoConvocatoria(valor, page);
}

var getDatosReporte = (page) => {
    let valor = document.getElementById("filtrarReporte").value;
    persona.getDatosReporte(valor, page);
}

/*Codigo de postular a una convocatoria*/
$(function () {

    $("#btn-postular").click(function () {
        return usuarios.postularConvo();
    });
});

/**--------------------------------------------------------------------------------------------------------- */
//Enviar correo
$(function () {
    $("#btn-contacto").click(function () {
        usuarios.enviarCorreo();
    });
});
var restablecerCorreo = () => {
    usuarios.restablecerCorreo();
}
/**--------------------------------------------------------------------------------------------------------- */

$().ready(function () {
    $("#validate").validate();
    $("#validateREstudio").validate();

    //variable local
    let URLactual = window.location.pathname;
    usuarios.userData(URLactual);

    switch (URLactual) {
        case PATHNAME:

            $(".carouselImg").owlCarousel({
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 6000,
                autoplayHoverPause: true,
                lazyLoad: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            $.post(
                URL + "index/getConvocatorias", {},
                (response) => {
                    $("#resultsConvo").html(response);

                    $(".carouselConvocatorias").owlCarousel({
                        loop: true,
                        margin: 20,
                        autoplay: true,
                        autoplayTimeout: 6000,
                        autoplayHoverPause: true,
                        lazyLoad: true,
                        responsiveClass: true,
                        responsive: {
                            0: {
                                items: 1
                            },
                            600: {
                                items: 2
                            },
                            1000: {
                                items: 2
                            }
                        }
                    });

                }
            );

            break;
        case PATHNAME + "admin/user":
            document.getElementById('foto_pers').addEventListener('change', archivo, false);
            document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/personas/default.png", '" title="', , '" />'].join('');
            getIdentificaciones();
            getCategorias();
            getUsers(1);
            break;

        case PATHNAME + "admin/empresa":
            document.getElementById('logo').addEventListener('change', archivo, false);
            document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/empresas/default.png", '" title="', , '" />'].join('');
            getEmpresas(1);
            break;

        case PATHNAME + "user/registroempresa":
            document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/empresas/default.png", '" title="', , '" />'].join('');
            document.getElementById('logo').addEventListener('change', archivo, false);
            break;

        case PATHNAME + "user/registro":
            document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/personas/default.png", '" title="', , '" />'].join('');
            let count = 1;
            $.post(
                URL + "user/getIdentificaciones", {},
                (response) => {
                    try {
                        let item = JSON.parse(response);

                        document.getElementById('codi_iden').options[0] = new Option("Seleccione un tipo de identificación", 0);
                        if (item.results.length > 0) {
                            for (let i = 0; i <= item.results.length; i++) {
                                document.getElementById('codi_iden').options[count] = new Option(item.results[i].desc_iden, item.results[i].codi_iden);
                                count++;

                            }
                        }

                    } catch (error) {

                    }


                }
            );

            document.getElementById('foto_pers').addEventListener('change', archivo, false);
            break;

        case PATHNAME + "persona/datospersonales":
            document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/personas/default.png", '" title="', , '" />'].join('');
            getIdentificaciones();
            getEstadoCivil();
            document.getElementById('foto_pers').addEventListener('change', archivo, false);
            persona.actDatosPersonales();
            break;

        case PATHNAME + "persona/datosacademicos":
            document.getElementById('soporte').addEventListener('change', soporteUser, false);
            document.getElementById("soporteUser").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/soportes/default.png", '" title="', , '" />'].join('');
            getTipoEstudio();
            getListaEstudios(1);
            break;

        case PATHNAME + "persona/datosacademicoscomplementarios":
            getIdiomas();
            getTecnologias();
            persona.DatosAPlus();
            break;

        case PATHNAME + "persona/misconvocatorias":
            persona.getDataPostulante();
            getListadoConvocatoria(1);
            break;

        case PATHNAME + "persona/detalleconvocatoria":
            persona.getDetalleConvocatoria();
            persona.getListaConvoSilimares();
            break;

        case PATHNAME + "persona/mispostulaciones":
            getListaPostulaciones(1);
            break;

        case PATHNAME + "persona/experiencialaboral":
            getListaExperiencias(1);

            break;

        case PATHNAME + "persona/perfilaboral":
            getListaPerfiles(1);
            getCatLaboral();
            getPerfilUpdate();
            getPerfilLaboral();
            break;

        case PATHNAME + "persona/subirhdv":
            document.getElementById('hoja_de_vida').addEventListener('change', archivo, false);
            document.getElementById("file_hdv").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/doc.png", '" title="', , '" />'].join('');
            getListaHdv(1);

        case PATHNAME + "persona/reportes":
            getDatosReporte(1);
            break;

        case PATHNAME + "empresa/convocatorias":
            $(window).on('load', function () {
                setTimeout(function () {
                    $(".loader-page").css({
                        visibility: "hidden",
                        opacity: "0"
                    })
                }, 2000);

            });

            getCategorias_laborales();
            getContratos();
            getConvocatorias(1);
            break;

            case PATHNAME + "empresa/userbusqueda":
            getCatLaboral();
            getPerfilLaboral();
            getBusquedaUsers(1);
            break;

            case PATHNAME + "empresa/candidatos":
                getConvocatoriasLabs();
                getConvoCandidatos(1);
            break;

            

        case PATHNAME + "user/perfil":
            document.getElementById('perfil').addEventListener('change', archivo, false);
            usuarios.actdataUser();
            break;

        case PATHNAME + "user/convocatorias":
            getListaConvocatoria(1);
            break;


    }
});