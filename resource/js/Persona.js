class Persona extends Uploadpicture {
    //metodo constructor
    constructor() {
        //hace referencia al metodo constructor de la clase que se esta heredando Uploadpicture
        //invocar todas las propiedades, metodos u objetos de la clase heredada
        super();
        //objetos para actualizar datos
        this.funcion = 0;
        //id del usuario que se va actualizar
        this.id_user = 0;
        //foto del usuario que se va actualizar
        this.perfil = null;
        //codigo unico para actulizar datos del usuario
        this.codigo = null;
    }

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select identificaciones
    getIdentificaciones(iden, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getIdentificaciones", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('codi_iden').options[0] = new Option("Seleccione un tipo de identificación", 0);
                    if (item.length > 0) {

                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('codi_iden').options[count] = new Option(item[i].desc_iden, item[i].codi_iden);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('codi_iden').options[count] = new Option(item[i].desc_iden, item[i].codi_iden);
                                    if (item[i].codi_iden == iden) {
                                        i++;
                                        document.getElementById('codi_iden').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select estado civil
    getEstadoCivil(estado, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getEstadoCivil", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('esta_pers').options[0] = new Option("Seleccione un estado civil", 0);
                    if (item.length > 0) {

                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('esta_pers').options[count] = new Option(item[i].desc_esta, item[i].esta_pers);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('esta_pers').options[count] = new Option(item[i].desc_esta, item[i].esta_pers);
                                    if (item[i].esta_pers == estado) {
                                        i++;
                                        document.getElementById('esta_pers').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select tipo estudio
    getTipoEstudio(estudio, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getTipoEstudio", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    document.getElementById('nivel_educativo').options[0] = new Option("Seleccione un nivel educativo", "");
                    if (item.length > 0) {
                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('nivel_educativo').options[count] = new Option(item[i].descripcion, item[i].id);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('nivel_educativo').options[count] = new Option(item[i].descripcion, item[i].id);
                                    if (item[i].id == estudio) {
                                        i++;
                                        document.getElementById('nivel_educativo').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Tabla con lista de estudios acádemicos
    getListaEstudios(valor, page) {
        $.post(
            URL + "persona/getListaEstudios", {
                filter: valor,
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(response);
                    $("#resultsEstudios").html(item.dataResults);
                    $("#paginador").html(item.paginador);

                } catch (error) {
                    $("#paginador").html(response);
                }
            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Resgistrar estudios acádemicos
    registerEstudios() {
        let valor = false;
        var data = new FormData();
        $.each($('input[type=file]')[0].files, (i, file) => {
            data.append('soporte', file);
        });

        var url = this.funcion == 0 ? "persona/registerEstudios" : "persona/editEstudio";

        let nivel_educativo = document.getElementById("nivel_educativo");
        let estado = document.getElementById("estado");

        //enviar al servidor la id del usuario que se va a registrar

        data.append('cod_da', this.codigo);
        data.append('id', this.id_user);
        data.append('soporte', this.perfil);


        data.append('nivel_educativo', nivel_educativo.options[nivel_educativo.selectedIndex].value);
        data.append('titulo', document.getElementById("titulo").value);
        data.append('institucion', document.getElementById("institucion").value);
        data.append('estado', estado.options[estado.selectedIndex].value);
        data.append('grado', document.getElementById("grado").value);

        console.log(url);
        $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Estudio registrado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerEstudios();
                } else {
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener datos de estudios acádemicos para actualizarlos
    editEstudio(data) {
        document.getElementById("btnregistroestudio").innerHTML = "ACTUALIZAR";
        document.getElementById("addestudiosTitle").innerHTML = "Actualizar Estudio";
        this.funcion = 1;
        this.codigo = data.cod_da;
        this.perfil = data.soporte;
        this.id_user = data.id;
        document.getElementById("soporteUser").innerHTML = ['<img class="foto-perfil" src="', PATHNAME + "/resource/images/imgFiles/soportes/" + data.soporte, '" title="', escape(data.soporte), '"/>'].join('');
        document.getElementById("titulo").value = data.titulo;
        document.getElementById("institucion").value = data.institucion;
        document.getElementById("grado").value = data.grado;
        document.getElementById("estado").value = data.estado;
        this.getTipoEstudio(data.nivel_educativo, 2);
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Procedimiento para elimar estudio registrador por el usuario en el sistema
    deleteEstudio(data) {
        $.post(
            URL + "persona/deleteEstudio", {
                codigo: data.cod_da,
                soporte: data.soporte,
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Estudio Eliminado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.restablecerEstudios();
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
                console.log(response);
            });
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Restablecer modal estudios acádemicos
    restablecerEstudios() {
        document.getElementById("btnregistroestudio").innerHTML = "REGISTRAR";
        document.getElementById("addestudiosTitle").innerHTML = "Registrar Estudio";

        this.funcion = 0;
        this.codigo = 0;
        this.perfil = null;

        document.getElementById("soporteUser").innerHTML = ['<img class="foto-perfil" src="', PATHNAME + "/resource/images/imgFiles/soportes/default.png", '" title="', , '" />'].join('');
        this.getTipoEstudio(null, 1);

        $("#adduser").modal('hide');
        $("#deleteUser").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("titulo").value = "";
        document.getElementById("institucion").value = "";
        document.getElementById("grado").value = "";
        document.getElementById("estado").value = "";

        window.location.href = URL + "persona/datosacademicos";
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Tabla con lista de estudios acádemicos
    getListaExperiencias(valor, page) {
        $.post(
            URL + "persona/getListaExperiencias", {
                filter: valor,
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(response);
                    $("#resultsExperiencias").html(item.dataResults);
                    $("#paginador").html(item.paginador);

                } catch (error) {
                    $("#paginador").html(response);
                }
            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Resgistrar experiencias laboral
    registerExperiencias() {
        let valor = false;
        var data = new FormData();

        var url = this.funcion == 0 ? "persona/registerExperiencias" : "persona/editExperiencia";

        //enviar al servidor la id del usuario que se va a registrar

        data.append('id_user', this.id_user);
        data.append('codigo', this.codigo);

        data.append('nomb_empresa', document.getElementById("nomb_empresa").value);
        data.append('cargo', document.getElementById("cargo").value);
        data.append('funciones', document.getElementById("funciones").value);
        data.append('fecha_ini', document.getElementById("fecha_ini").value);
        data.append('fecha_fin', document.getElementById("fecha_fin").value);

        //console.log(data);
        $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Experiencia Laboral Registrada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerExperiencias();
                } else {
                    // console.log(response);
                    //document.getElementById("registerUMessage").innerHTML = response;
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener datos de experiencia laboral para actualizarlos
    editExperiencia(data) {
        document.getElementById("btnregistroexperiencia").innerHTML = "ACTUALIZAR";
        document.getElementById("addexperienciasTitle").innerHTML = "Actualizar Experiencia";

        this.funcion = 1;
        this.codigo = data.cod_ep;
        this.id_user = data.id;

        document.getElementById("nomb_empresa").value = data.nomb_empresa;
        document.getElementById("cargo").value = data.cargo;
        document.getElementById("funciones").value = data.funciones;
        document.getElementById("fecha_ini").value = data.fecha_ini;
        document.getElementById("fecha_fin").value = data.fecha_fin;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Procedimiento para eliminar experiencia registrada por el usuario en el sistema
    deleteExperiencia(data) {
        $.post(
            URL + "persona/deleteExperiencia", {
                codigo: data.cod_ep,
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Experiencia Eliminada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.restablecerExperiencias();
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Restablecer modal experiencia laboral
    restablecerExperiencias() {
        document.getElementById("btnregistroexperiencia").innerHTML = "REGISTRAR";
        document.getElementById("addexperienciasTitle").innerHTML = "Registrar Experiencia";

        this.funcion = 0;
        this.codigo = 0;

        $("#addexperiencias").modal('hide');
        $("#deleteexperiencias").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("nomb_empresa").value = "";
        document.getElementById("cargo").value = "";
        document.getElementById("funciones").value = "";
        document.getElementById("fecha_ini").value = "";
        document.getElementById("fecha_fin").value = "";

        window.location.href = URL + "persona/experiencialaboral";
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Tabla con lista de estudios acádemicos
    getListaPerfiles(valor, page) {
        $.post(
            URL + "persona/getListaPerfiles", {
                filter: valor,
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(response);
                    $("#resultsPerfiles").html(item.dataResults);
                    $("#paginador").html(item.paginador);

                } catch (error) {
                    $("#paginador").html(response);
                }
            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select categoría laboral
    getCatLaboral(categoria, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getCatLaboral", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    document.getElementById('id_categoria').options[0] = new Option("Seleccione una categoría laboral", "");
                    if (item.length > 0) {
                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('id_categoria').options[count] = new Option(item[i].desc_cat, item[i].id);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('id_categoria').options[count] = new Option(item[i].desc_cat, item[i].id);
                                    if (item[i].id == categoria) {
                                        i++;
                                        document.getElementById('id_categoria').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select perfil laboral
    getPerfilLaboral(perfil, funcion) {
        let count = 1;
        $("#id_categoria").change(function () {
            // Guardamos el select de perfiles
            var perfiles = $("#id_perfil");
            //limpiar select cada que haga un cambio o elija una opción
            //Ocultar opntions antiguos
            //perfiles.find('option:contains("")').hide();
            perfiles.find('option').remove();

            // Guardamos el select de categorias
            var categorias = $(this);
            if ($(this).val() != '') {
                //Enviar cod al server
                var data = new FormData();
                this.codigo = categorias.val();
                data.append('codigo', this.codigo);
                $.ajax({
                    url: URL + "persona/getPerfilLaboral",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {
                        try {
                            let item = JSON.parse(response);
                            document.getElementById('id_perfil').options[0] = new Option("Seleccione un perfil laboral", "");
                            if (item.length > 0) {
                                for (let i = 0; i <= item.length; i++) {
                                    switch (funcion) {
                                        case 1:
                                            $("#id_perfil").val($("#id_perfil option:first").val());
                                            document.getElementById('id_perfil').options[count] = new Option(item[i].desc_perfil, item[i].id);
                                            count++;
                                            break;
                                        case 2:
                                            //console.log(funcion);
                                            //$("#id_perfil").val($("#id_perfil option:first").val());
                                            document.getElementById('id_perfil').options[count] = new Option(item[i].desc_perfil, item[i].id);
                                            if (item[i].id == perfil) {
                                                i++;
                                                $("#id_perfil  option[value=" + item[i].id + "]").attr("selected", true);
                                                document.getElementById('id_perfil').selectedIndex = i;
                                                i--;
                                            }
                                            count++;
                                            break;
                                    }
                                }
                            }
                        } catch (error) {

                        }
                    }
                });
            }
        });
    }

    /**--------------------------------------------------------------------------------------------------------------- */
    getPerfilUpdate(perfil, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getPerfilUpdate", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    document.getElementById('id_perfil').options[0] = new Option("Seleccione un perfil laboral", "");
                    if (item.length > 0) {
                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('id_perfil').options[count] = new Option(item[i].desc_perfil, item[i].id);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('id_perfil').options[count] = new Option(item[i].desc_perfil, item[i].id);
                                    if (item[i].id == perfil) {
                                        i++;
                                        document.getElementById('id_perfil').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }

    /**--------------------------------------------------------------------------------------------------------------- */
    //Resgistrar perfil laboral
    registerPerfiles() {
        let valor = false;
        var data = new FormData();

        var url = this.funcion == 0 ? "persona/registerPerfiles" : "persona/editPerfil";

        let id_categoria = document.getElementById("id_categoria");
        let id_perfil = document.getElementById("id_perfil");

        //enviar al servidor la id del usuario que se va a registrar

        data.append('id_user', this.id_user);
        data.append('codigo', this.codigo);


        data.append('titulo', document.getElementById("titulo").value);
        data.append('id_categoria', id_categoria.options[id_categoria.selectedIndex].value);
        data.append('id_perfil', id_perfil.options[id_perfil.selectedIndex].value);
        data.append('descripcion', document.getElementById("descripcion").value);

        //console.log(data);
        $.ajax({
            url: URL + url,
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Perfil Registrado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerPerfiles();
                } else {
                    // console.log(response);
                    //document.getElementById("registerUMessage").innerHTML = response;
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener datos de PERFIL laboral para actualizarlos
    editPerfil(data) {
        document.getElementById("btnregistroperfil").innerHTML = "ACTUALIZAR";
        document.getElementById("addperfilesTitle").innerHTML = "Actualizar Perfil";

        this.funcion = 1;
        this.codigo = data.cod_dp;
        this.id_user = data.id;

        document.getElementById("titulo").value = data.titulo;
        document.getElementById("descripcion").value = data.descripcion;
        this.getCatLaboral(data.id_categoria, 2);
        this.getPerfilUpdate(data.id_perfil, 2);

    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Procedimiento para eliminar el perfil laboral registrado por el usuario en el sistema
    deletePerfil(data) {
        $.post(
            URL + "persona/deletePerfil", {
                codigo: data.cod_dp,
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Perfil Eliminado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.restablecerPerfiles();
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Restablecer modal perfil laboral
    restablecerPerfiles() {
        document.getElementById("btnregistroperfil").innerHTML = "REGISTRAR";
        document.getElementById("addperfilesTitle").innerHTML = "Registrar Perfil";

        this.funcion = 0;
        this.codigo = 0;

        $("#addperfiles").modal('hide');
        $("#deleteperfil").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("titulo").value = "";
        document.getElementById("descripcion").value = "";
        document.getElementById("id_categoria").value = "";
        document.getElementById("id_perfil").value = "";

        window.location.href = URL + "persona/perfilaboral";
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select idioma
    getIdiomas(idioma, funcion) {
        let count = 1;
        $.post(
            URL + "persona/getIdiomas", {},
            (response) => {
                //console.log(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('id_idioma').options[0] = new Option("Seleccione un idioma", 0);
                    if (item.length > 0) {

                        for (let i = 0; i <= item.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('id_idioma').options[count] = new Option(item[i].desc, item[i].id);
                                    count++;
                                    break;

                                case 2:
                                    document.getElementById('id_idioma').options[count] = new Option(item[i].desc, item[i].id);
                                    if (item[i].id == idioma) {
                                        i++;
                                        document.getElementById('id_idioma').selectedIndex = i;
                                        i--;
                                    }
                                    count++;
                                    break;
                            }
                        }
                    }

                } catch (error) {

                }


            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener información academica complementaria del usuario para mostrar en la vista los datos que ya están almacenados en el sistema
    DatosAPlus() {
        $.post(
            URL + "persona/DatosAPlus", {},
            (response) => {
                if (response == 0) {
                    document.getElementById("divcursos-idiomas").style.display = "none";
                    document.getElementById("divsinregistros").style.display = "block";
                }
                if (response.cursos == null && response.id_idioma == null && response.n_idioma == null) {
                    document.getElementById("divcursos-idiomas").style.display = "none";
                    document.getElementById("divsinregistros").style.display = "block";
                } else {
                    let item = response;
                    this.funcion = 1;
                    this.id_user = item.id;

                    this.getIdiomas(item.id_idioma, 2);
                    document.getElementById("cursos").value = item.cursos;
                    document.getElementById("n_idioma").value = item.n_idioma;
                }

                $(function () {
                    $("#btnshow").click(function () {
                        document.getElementById("divcursos-idiomas").style.display = "block";
                        document.getElementById("divsinregistros").style.display = "none";
                    });
                });
            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Proceso para actualizar los datos personales de la persona
    saveDatosAPlus() {
        let valor = false;

        //crear colección de objetos para enviarlos al servidor
        var data = new FormData();

        let id_idioma = document.getElementById("id_idioma");
        let idioma = id_idioma.options[id_idioma.selectedIndex].value;

        //Actualizar user ini y enviar al servidor la id del usuario que se va a registrar
        data.append('id', this.id_user);

        data.append('id_idioma', idioma);
        data.append('cursos', document.getElementById("cursos").value);
        data.append('n_idioma', document.getElementById("n_idioma").value);

        $.ajax({
            url: URL + "persona/saveDatosAPlus",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                //console.log(response);
                if (response == 0) {
                    toastr.success("Mensaje enviado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    window.location.href = URL + "persona/datosacademicos";
                } else {
                    // console.log(response);
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        })

        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    getTecnologias() {
        $.post(
            URL + "persona/getTecnologias", {},
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(response);
                    $("#listTecnologias").html(item.dataResults);

                } catch (error) {
                    $("#listTecnologias").html(response);
                }
            }
        );
    }

    /**--------------------------------------------------------------------------------------------------------------- */
    //Resgistrar perfil laboral
    registerTecnologias() {
        let valor = false;
        var data = new FormData();
        var value = "";

        //enviar al servidor la id del usuario que se va a registrar

        data.append('id_pers', this.id_user);
        data.append('codigo', this.codigo);

        var tecnologias = []

        $('input[type=checkbox][name="id_prog[]"]:checked').each(function () {
            tecnologias.push($(this).val());
        });

        for (var i = 0; i < tecnologias.length; i++) {
            data.append('id_prog[]', tecnologias[i]);
        }

        //console.log(tecnologias);
        //data.append('id_prog', $('input[name="id_prog[]"]:checked').val());

        //console.log($("input[type=checkbox]:checked").val());
        $.ajax({
            url: URL + "persona/registerTecnologias",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Tecnológias Registradas.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerTecnologias();
                } else {
                    // console.log(response);
                    //document.getElementById("registerUMessage").innerHTML = response;
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */
    /**--------------------------------------------------------------------------------------------------------------- */
    //Restablecer modal perfil laboral
    restablecerTecnologias() {

        this.funcion = 0;
        this.codigo = 0;

        window.location.href = URL + "persona/datosacademicoscomplementarios";
    }
    /**--------------------------------------------------------------------------------------------------------------- */
    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener información del usuario para mostrar en la vista los datos que ya están almacenados en el sistema
    actDatosPersonales() {
        $.post(
            URL + "persona/actDatosPersonales", {},
            (response) => {
                //console.log(response);
                let item = JSON.parse(response);
                //console.log(item);

                this.funcion = 1;
                this.id_user = item.id;
                this.perfil = item.foto_pers;

                this.getIdentificaciones(item.codi_iden, 2);
                this.getEstadoCivil(item.esta_pers, 2);

                document.getElementById("id").value = item.id;
                document.getElementById("nomb_pers").value = item.nomb_pers;
                document.getElementById("ape_pers").value = item.ape_pers;
                document.getElementById("sexo").value = item.sexo;
                document.getElementById("fnac_pers").value = item.fnac_pers;
                document.getElementById("telefono1").value = item.telefono1;
                document.getElementById("telefono2").value = item.telefono2;
                document.getElementById("emai_pers").value = item.emai_pers;
                document.getElementById("direccion").value = item.direccion;
                document.getElementById("fotos").innerHTML = ['<img class="foto-perfil" src="', PATHNAME + "/resource/images/imgFiles/personas/" + item.foto_pers, '" title="', escape(item.foto_pers), '"/>'].join('');
            }
        );
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Proceso para actualizar los datos personales de la persona
    saveDatosPersonales() {
        let valor = false;
        if (validarEmail(document.getElementById("emai_pers").value)) {
            //crear colección de objetos para enviarlos al servidor
            var data = new FormData();

            $.each($('input[type=file]')[0].files, (i, file) => {
                data.append('foto_pers', file);
            });

            let codi_iden = document.getElementById("codi_iden");
            let identificacion = codi_iden.options[codi_iden.selectedIndex].value;

            let esta_pers = document.getElementById("esta_pers");
            let estdcivil = esta_pers.options[esta_pers.selectedIndex].value;

            //Actualizar user ini y enviar al servidor la id del usuario que se va a registrar
            data.append('id', this.id_user);
            data.append('foto_pers', this.perfil);

            data.append('codi_iden', identificacion);
            data.append('id', document.getElementById("id").value);
            data.append('nomb_pers', document.getElementById("nomb_pers").value);
            data.append('ape_pers', document.getElementById("ape_pers").value);
            data.append('sexo', document.getElementById("sexo").value);
            data.append('fnac_pers', document.getElementById("fnac_pers").value);
            data.append('esta_pers', estdcivil);
            data.append('telefono1', document.getElementById("telefono1").value);
            data.append('telefono2', document.getElementById("telefono2").value);
            data.append('emai_pers', document.getElementById("emai_pers").value);
            data.append('direccion', document.getElementById("direccion").value);
            $.ajax({
                url: URL + "persona/saveDatosPersonales",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {
                    //console.log(response);
                    if (response == 0) {
                        toastr.success("Mensaje enviado.", '¡Éxito!', {
                            "progressBar": true,
                            "positionClass": "toast-bottom-right"
                        });
                        window.location.href = URL + "persona/datospersonales";
                    } else {
                        // console.log(response);
                        valor = true;
                        toastr.error(response, '¡Error!', {
                            "progressBar": true,
                            "positionClass": "toast-bottom-right"
                        });
                    }
                }
            })
        } else {
            $('#emai_pers').focus();
            $('#emai_pers').removeClass('is-valid');
            $('#emai_pers').addClass('is-invalid');
            toastr.error("Dirección de correo invalida.", '¡Error!', {
                "progressBar": true,
                "positionClass": "toast-bottom-right"
            });
        }
        return valor;
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /**--------------------------------------------------------------------------------------------------------------- */
    //Obtener información del usuario para actualizar perfil
    dataPersona(data) {
        this.funcion = 1;
        this.id_user = data.id;
        this.perfil = data.foto_pers;
        document.getElementById("fotos").innerHTML = ['<img class="foto-perfil" src="', PATHNAME + "/resource/images/imgFiles/personas/" + data.foto_pers, '" title="', escape(data.foto_pers), '"/>'].join('');
        document.getElementById("nomb_pers").value = data.nomb_pers;
        document.getElementById("ape_pers").value = data.ape_pers;
        document.getElementById("id").value = data.id;
        document.getElementById("direccion").value = data.direccion;
        this.getIdentificaciones(data.codi_iden, 2);
        this.getEstadoCivil(data.esta_pers, 2)
    }
    /**--------------------------------------------------------------------------------------------------------------- */

    /*---------------------------------------Convocatorias laborales--------------------------------------------------------*/
    //Obtener N° de postulaciones
    getDataPostulante() {
        $.post(
            URL + "persona/dataPostulante", {},
            (response) => {
                let item = JSON.parse(response);

                var num_pos = item.length;
                document.getElementById("num_pos").innerHTML = num_pos;
                document.getElementById("descripcion_pos").innerHTML = "Actualmente tienes " + num_pos + " postulaciones abiertas.";
            }
        );
    }
    /*-------------------------------------------------------------------------------------------------------------------- */
    getListadoConvocatoria(valor, page) {
        var valor = valor != null ? valor : "";
        $.post(
            URL + "persona/getListadoConvocatoria", {
                filter: valor,
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    $("#listaConvo").html(item.dataFilter);
                    $("#paginador").html(item.paginador);

                } catch (error) {
                    $("#paginador").html(response);
                }
            }
        );
    }

    getDetalleConvocatoria() {
        $.post(
            URL + "persona/getDetalleconvocatoria", {},
            (response) => {
                let item = JSON.parse(response);
                document.getElementById("perfil-title").innerHTML = item.perfil;
                document.getElementById("descripcion-convo").innerHTML = item.desc_cargo;
                document.getElementById("item-contrato").innerHTML = '<span class="text-success"><i class="fas fa-info-circle"></i> Tipo de Contrato: </span>' + item[0]["contrato"];
                document.getElementById("item-categoria").innerHTML = '<span class="text-success"><i class="fas fa-cog"></i> Categoría: </span>' + item.des_categoria;
                document.getElementById("logo-empresa").innerHTML = ['<img class="card-img-top img-logocenter" src="', PATHNAME + "resource/images/imgFiles/empresas/" + item.logo, '" title="', escape(item.logo), '"/>'].join('');
                document.getElementById("nomb-empresa").innerHTML = item.empresa;
                document.getElementById("item-telefono").innerHTML = '<span class="text-success"><i class="fas fa-cog"></i> Teléfono: </span>' + item.telefono_emp;
                document.getElementById("item-direccion").innerHTML = '<span class="text-success"><i class="fas fa-cog"></i> Dirección: </span>' + item.direccion;
                if (item.vi_salario == 1) {
                    document.getElementById("item-salario").innerHTML = '<snap class="text-success"><i class="fas fa-money-bill-wave"></i> Rango Salarial: </snap>' + new Intl.NumberFormat("es-CO", {
                        style: "currency",
                        currency: "COP"
                    }).format(item.salario);
                } else {
                    document.getElementById("item-salario").innerHTML = '<snap class="text-success"><i class="fas fa-money-bill-wave"></i> Rango Salarial: </snap>' + 'A convenir';
                }
            });
    }

    getListaConvoSilimares() {
        $.post(
            URL + "persona/getListaConvoSilimares", {},
            (response) => {

                let item = JSON.parse(response);

                $("#listaConvoSimilares").html(item.dataFilter);

            }
        );
    }

    registerPostulantes() {
        let valor = false;
        $.post(
            URL + "persona/registerPostulantes", {},
            (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Postulación Exitosa.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });

                } else {

                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
        return valor;
    }

    getListaPostulaciones(page) {
        $.post(
            URL + "persona/getListaPostulaciones", {
                page: page
            },
            (response) => {
                try {
                    let item = JSON.parse(response);
                    $("#listaPostulaciones").html(item.dataResults);
                    $("#paginador").html(item.paginador);

                } catch (error) {

                }
            }
        );
    }

    getDatosReporte(valor, page) {
        var valor = valor != null ? valor : "";
        $.post(
            URL + "persona/getDatosReporte", {
                filter: valor,
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    
                    let item = JSON.parse(response);
                    
                    $("#datosReportes").html(item.dataResults);
                    $("#paginador").html(item.paginador);


                    if (item.dataResults == null) {
                        document.getElementById("reporteMessage").innerHTML = "No hay registros en el sistema.";
                    }
                } catch (error) {

                }
            }
        );
    }

    RegisterHdv() {
        let valor = false;
        var data = new FormData();
        $.each($('input[type=file]')[0].files, (i, file) => {
            data.append('hoja_de_vida', file);
        });

        $.ajax({
            url: URL + "persona/RegisterHdv",
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                console.log(response);
                if (response == 0) {
                    toastr.success("Hoja de vida registrada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerHdv();
                } else {
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
        return valor;
    }

    //Tabla con lista de hojas de vida
    getListaHdv(page) {
        $.post(
            URL + "persona/getListaHdv", {
                page: page
            },
            (response) => {
                //console.log(response);
                //$("#resultsUser").html(response);
                try {
                    let item = JSON.parse(response);
                    //console.log(response);
                    $("#resultsHdv").html(item.dataResults);
                    $("#paginador").html(item.paginador);

                } catch (error) {
                    $("#paginador").html(response);
                }
            }
        );
    }

    editEstadoHdv(data) {
        let valor = false;
        var dataForm = new FormData();

        this.codigo = data.cod_hdv;
        this.perfil = data.hoja_de_vida;
        this.funcion = 1;

        dataForm.append('cod_hdv', this.codigo);
        dataForm.append('hoja_de_vida', this.perfil);
        $.ajax({
            url: URL + "persona/editEstadoHdv",
            data: dataForm,
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                if (response == 0) {
                    toastr.success("Hoja de vida actualizada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerHdv();
                } else {
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });

    }

    editEstadoDefaultHdv() {
        let valor = false;
        $.ajax({
            url: URL + "persona/editEstadoDefaultHdv",
            data: {},
            cache: false,
            contentType: false,
            processData: false,
            type: 'POST',
            success: (response) => {
                if (response == 0) {
                    toastr.success("Hoja de vida actualizada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    restablecerHdv();
                } else {
                    valor = true;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }
        });
    }

    deleteHdv(data) {
        $.post(
            URL + "persona/deleteHdv", {
                codigo: data.cod_hdv,
                file: data.hoja_de_vida,
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Hoja de Vida en Word/PDF Eliminada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.restablecerHdv();
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
                //console.log(response);
            });
    }

    restablecerHdv() {
        this.funcion = 0;
        this.codigo = 0;

        $("#deletehdv").modal('hide');
        $("#ModaleditEstadoHdv").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("nomb_hdv").value = "";


        window.location.href = URL + "persona/subirhdv";
    }

    restablecerEstadoPerfil() {
        this.funcion = 0;
        this.codigo = 0;
        $("#ModaleditEstadoPerfil").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("nomb_titulo").value = "";


        window.location.href = URL + "persona/perfilaboral";
    }


}