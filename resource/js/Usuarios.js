class Usuarios extends Uploadpicture{
    //metodo constructor
    constructor() {
        //hace referencia al metodo constructor de la clase que se esta heredando Uploadpicture
        //invocar todas las propiedades, metodos u objetos de la clase heredada
        super();
        //objetos para actualizar datos
        this.funcion=0;
        //id del usuario que se va actualizar
        this.id_user=0;
        //foto del usuario que se va actualizar
        this.perfil=null;
    }
    
    resetPassword(id){
            var data = new FormData();
            data.append('id', id);
            $.ajax({
                url: URL + "user/postpasswordreset",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {
                        console.log(response);
                        if(response == 0){
                            toastr.success("El mensaje ha sido enviado.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }else{
                            if (response == 1) {
                                toastr.error("Usted solicitó un cambio de contraseña hace poco, debe esperar 24 horas para solicitar uno nuevamente.", '¡Error!', {
                                    "progressBar": true,
                                    "positionClass": "toast-bottom-right"
                                });
                                //restablecerUsers();
                            } else {
                                if(response == 2){
                                    toastr.error("El usuario no ha registrado un correo electrónico en la plataforma de ZIMEP. Por favor comunicarse con el administrador.", '¡Error!', {
                                        "progressBar": true,
                                        "positionClass": "toast-bottom-right"
                                    });
                                }else{
                                    if(response == 3){
                                        toastr.error("El usuario no está registrado en la plataforma de ZIMEP.", '¡Error!', {
                                            "progressBar": true,
                                            "positionClass": "toast-bottom-right"
                                        });
                                    }
                                    else{
                                        toastr.error(response, '¡Error!', {
                                            "progressBar": true,
                                            "positionClass": "toast-bottom-right"
                                        });
                                    }
                                }
                                
                                
                            }
                        }

                    }
                });
        
    }

    resetPasswordSave(password,repassword){
        if (validarPass(password)) {
            if (password.length <= 16) {
                if(password == repassword){
                    var data = new FormData();
                data.append('password', password);

                $.ajax({
                    url: URL + "user/postSavepass",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {
                        console.log(response);
                        if (response == 0) {
                            toastr.success("Contraseña Actualizada.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            //restablecerEmpresaUser();
                        } else {
                            console.log(response);
                            //document.getElementById("registerEMessage").innerHTML =response;
                            toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }
                    }
                });
                }else{
                    toastr.error("Las contraseñas no coinciden.", '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }

                }else{
                    toastr.error("La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.", '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            }else{
                toastr.error("La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.", '¡Error!', {
                    "progressBar": true,
                    "positionClass": "toast-bottom-right"
                });
            }
    }
    
    //login de usuario
    loginUser() {
        if (document.getElementById("id").value != "") {
            if (validarPass(document.getElementById("password").value)) {
                $.post(
                    URL + "user/postLogin",
                    $(".logindata").serialize(),
                    function (response){
                        console.log(response);
                        if (response == '1') {
                            document.getElementById("password").focus();
                            toastr.error('Ingrese contraseña.', '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        } else {
                            if (response == '2') {
                                document.getElementById("password").focus();
                                toastr.error('La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.', '¡Error!', {
                                    "progressBar": true,
                                    "positionClass": "toast-bottom-right"
                                });
                            } else {
                                if (response == '3') {
                                    document.getElementById("id").focus();
                                    document.getElementById("indexMessage").innerHTML = "Ingrese usuario.";
                                } else {
                                    if (response == '{"id":0}') {
                                        document.getElementById("password").focus();
                                        document.getElementById("indexMessage").innerHTML = "Contraseña incorrecta.";
                                        $("#password").removeClass("is-valid");
                                        $("#password").addClass("is-invalid");
                                    } else {
                                        try {
                                            var item = JSON.parse(response);
                                            if (0 < item.id) {
                                                if (1 == item.rol) {
                                                    //Permite almacenar información en la memoria local del navegador
                                                    localStorage.setItem("user", response);
                                                    window.location.href = URL + "persona/panel";
                                                } else {
                                                    if (2 == item.rol) {
                                                        localStorage.setItem("user", response);
                                                        window.location.href = URL + "empresa/panel";
                                                    } else {
                                                        if (3 == item.rol) {
                                                            localStorage.setItem("user", response);
                                                            window.location.href = URL + "admin/options";
                                                        }
                                                    }
                                                }
                                            } else {
                                                document.getElementById("indexMessage").innerHTML = "Credenciales de usuario incorrectas.";
                                            }
                                        } catch (error) {
                                            document.getElementById("indexMessage").innerHTML = response;
                                        }
                                    }
                                }
                            }
                        }

                    }
                );
            } else {
                document.getElementById("password").focus();
                document.getElementById("indexMessage").innerHTML = "La contraseña esta vacía o ha sido digita en un formato invalido.";
                $("#password").removeClass("is-valid");
                $("#password").addClass("is-invalid");
            }
        } else {
            document.getElementById("id").focus();
            document.getElementById("indexMessage").innerHTML = "Ingrese un usuario.";
        }
    }

    userData(URLactual) {
        //se cerro la sesión
        if (PATHNAME + "user/login" == URLactual) {
            //eliminar datos que esten en la memoria local
            localStorage.clear();
            document.getElementById('menu-navbar').style.display = 'none';

        } else {
            if (null != localStorage.getItem("user")) {
                let user = JSON.parse(localStorage.getItem("user"));
                if (0 < user.id) {
                    document.getElementById('menu-navbar').style.display = 'block';
                    
                    if (1 == user.rol) {
                        document.getElementById('nombreusuario').innerHTML = user.nombre+" "+user.apellido;
                        document.getElementById("fotoUser").innerHTML = ['<img class="img-profile rounded-circle" src="', PERFILES +"personas/"+ user.perfil, '" title="', escape(user.perfil), '" />'].join('');
                        document.getElementById('rolusuario').innerHTML = "PERSONA";
                    }
                    if (2 == user.rol) {
                        document.getElementById('nombreusuario').innerHTML = user.nombre;
                        document.getElementById("fotoUser").innerHTML = ['<img class="img-profile rounded-circle" src="', PERFILES +"empresas/"+ user.perfil, '" title="', escape(user.perfil), '" />'].join('');
                        document.getElementById('rolusuario').innerHTML = "EMPRESA";
                        
                    }
                    if (3 == user.rol) {
                        document.getElementById('nombreusuario').innerHTML = user.nombre+" "+user.apellido;
                        document.getElementById("fotoUser").innerHTML = ['<img class="img-profile rounded-circle" src="', PERFILES +"personas/"+ user.perfil, '" title="', escape(user.perfil), '" />'].join('');
                        document.getElementById('rolusuario').innerHTML = "ADMINISTRADOR";
                    }
                }

            } else {
                localStorage.clear();
                document.getElementById('menu-navbar').style.display = 'none';
            }
        }
    }

    getIdentificaciones(iden, funcion) {
        let count = 1;
        $.post(
            URL + "admin/getIdentificaciones", {},
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
                                        document.getElementById('codi_iden').selectedIndex=i;
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

    //Categorias para priorizar usuarios
    getCategorias(cat, funcion) {
        let count = 1;
        $.post(
            URL + "admin/getCategorias", {},
            (response) => {
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('id_cat').options[0] = new Option("Seleccione una categoría", 0);
                    if (item.results.length > 0) {
                        for (let i = 0; i <= item.results.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('id_cat').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    count++;
                                break;
                            
                                case 2:
                                    document.getElementById('id_cat').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    if (item.results[i].id == cat) {
                                        i++;
                                        document.getElementById('id_cat').selectedIndex=i;
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

    //registro de usuario rol de persona (PANEL ADMIN)
    registroUser() {
        let valor= false;
        if (validarPass(document.getElementById("password").value)) {
                //crear colección de objetos para enviarlos al servidor
                var data = new FormData();
                $.each($('input[type=file]')[0].files, (i, file) => {
                    data.append('foto_pers', file);
                });
                //Actualizar user ini
                /** 
                 * Si la función me devulve un valor true se realizar el registro del usuario admin/postRegistro
                 * sino se realizar la actualización admin/editUser
                 * la variable url se concatenara en la url del metodo .ajax
                */
                var url=this.funcion == 0 ? "admin/postRegistro" : "admin/editUser";
                
                let codi_iden = document.getElementById("codi_iden");
                let identificacion = codi_iden.options[codi_iden.selectedIndex].value;
                let id_cat = document.getElementById("id_cat");
                let categoria = id_cat.options[id_cat.selectedIndex].value;

                //enviar al servidor la id del usuario que se va a registrar
                data.append('id_user', this.id_user);
                data.append('foto_pers', this.perfil);

                //Actualizar user fin

                data.append('nomb_pers', document.getElementById("nomb_pers").value);
                data.append('ape_pers', document.getElementById("ape_pers").value);
                data.append('identificacion', identificacion);
                data.append('categoria', categoria);
                data.append('id', document.getElementById("id").value);
                data.append('direccion', document.getElementById("direccion").value);
                data.append('password', document.getElementById("password").value);
                console.log(data);
                $.ajax({
                    url: URL + url,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {
                        //console.log(response);
                        if (response == 0) {
                            toastr.success("Usuario registrado.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            restablecerUser();
                        } else {
                            // console.log(response);
                            //document.getElementById("registerUMessage").innerHTML = response;
                            valor=true;
                            toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }

                    }
                });
        } else {
            document.getElementById("password").focus();
            document.getElementById("registerUMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
            valor=true;
        }
        return valor;
    }

    //para filtrar usuarios en el panel administrador, módulo usuarios
    getUsers(valor,page){
        var valor = valor != null ? valor : "";
        $.post(
            URL+"admin/getUsers",
            {
                filter:valor,
                page:page
            },
            (response)=>{
                //console.log(response);
                //$("#resultsUser").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#resultsUser").html(item.dataFilter);
                    $("#paginador").html(item.paginador);

                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }

    //Obtener información del usuario
    editUser(data){
        document.getElementById("btn-registro").innerHTML="ACTUALIZAR";
        document.getElementById("adduserTitle").innerHTML="Actualizar usuario";
        this.funcion=1;
        this.id_user=data.id;
        this.perfil=data.foto_pers;
        document.getElementById("fotos").innerHTML=['<img class="foto-perfil" src="',PATHNAME+"/resource/images/imgFiles/personas/"+data.foto_pers, '" title="', escape(data.foto_pers), '"/>'].join('');
        document.getElementById("nomb_pers").value =data.nomb_pers;
        document.getElementById("ape_pers").value =data.ape_pers;
        document.getElementById("id").value =data.id;
        document.getElementById("direccion").value =data.direccion;
        document.getElementById("id_cat").value =data.id_cat;
        document.getElementById("password").value="A9w12345";
        document.getElementById("password").disabled=true;
        this.getIdentificaciones(data.codi_iden,2);
        this.getCategorias(data.id_cat,2);
    }

    deleteUser(data){
        $.post(
            URL+"admin/deleteUser",
            {
                id_user:data.id
            },
            (response)=>{
                if (response == 0) {
                    toastr.success("Usuario eliminado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    $('#deleteUser').modal('toggle');
                    this.restablecerUser();
                } else {
                    //document.getElementById("deleteUMessage").innerHTML=response;
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
                console.log(response);
            }
        );
    }

    //restablecer user (PANEL ADMIN)
    restablecerUser() {
        document.getElementById("btn-registro").innerHTML="REGISTRAR";
        document.getElementById("adduserTitle").innerHTML="Registrar usuario";
        
        this.funcion=0;
        this.id_user=0;
        this.perfil=null;

        document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/personas/user.png", '" title="', , '" />'].join('');
        this.getIdentificaciones(null,1);
        this.getCategorias(null,1);
        //ocultar modal después de guardar los datos
        //$('#adduser').modal('toggle');

        $("#adduser").modal('hide');
        $("#deleteUser").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        //limpiar campos de texto
        document.getElementById("nomb_pers").value = "";
        document.getElementById("ape_pers").value = "";
        document.getElementById("id").value = "";
        document.getElementById("direccion").value = "";
        document.getElementById("password").value = "";
        //this.getUsers(null,1);
         window.location.href = URL + "admin/user";
    }
    
     //registro de usuario rol de empresa (PANEL ADMIN)
    registroEmpresa() {
        let valor= false;
        if (validarPass(document.getElementById("password").value)) {
                //crear colección de objetos para enviarlos al servidor
                var data = new FormData();
                $.each($('input[type=file]')[0].files, (i, file) => {
                    data.append('logo', file);
                });
                //Actualizar user ini
                /** 
                 * Si la función me devulve un valor true se realizar el registro del usuario admin/postRegistro
                 * sino se realizar la actualización admin/editUser
                 * la variable url se concatenara en la url del metodo .ajax
                */
                
                var url=this.funcion == 0 ? "admin/postRegistroEmpresa" : "admin/editEmpresa";

                //enviar al servidor la id del usuario que se va a registrar
                data.append('id_user', this.id_user);
                data.append('logo', this.perfil);

                //Actualizar user fin

                data.append('id', document.getElementById("id").value);
                data.append('nomb_emp', document.getElementById("nomb_emp").value);
                data.append('razon_s', document.getElementById("razon_s").value);
                data.append('direccion', document.getElementById("direccion").value);
                data.append('telefono_emp', document.getElementById("telefono_emp").value);
                data.append('password', document.getElementById("password").value);
                console.log(data);
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
                            toastr.success("Usuario registrado.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            restablecerEmpresa();
                        } else {
                            // console.log(response);
                            //document.getElementById("registerUMessage").innerHTML = response;
                            valor=true;
                            toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }

                    }
                });
        } else {
            document.getElementById("password").focus();
            document.getElementById("registerEMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
            valor=true;
        }
        return valor;
    }

    //para filtrar empresas en el panel administrador, módulo empresa
    getEmpresas(valor_emp,page){
        var valor_emp = valor_emp != null ? valor_emp : "";
        $.post(
            URL+"admin/getEmpresas",
            {
                filter:valor_emp,
                page:page
            },
            (response)=>{
                //$("#resultsEmpresa").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#resultsEmpresa").html(item.dataFilter);
                    $("#paginador").html(item.paginador);
                    
                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }

    editEmpresa(data){
        document.getElementById("btn-registro-empresa").innerHTML="ACTUALIZAR";
        document.getElementById("addempresaTitle").innerHTML="Actualizar usuario";
        this.funcion=1;
        this.id_user=data.id;
        this.perfil=data.logo;
        document.getElementById("fotos").innerHTML=['<img class="foto-perfil" src="',PATHNAME+"/resource/images/imgFiles/empresas/"+data.logo, '" title="', escape(data.logo), '"/>'].join('');
        document.getElementById("id").value =data.id;
        document.getElementById("nomb_emp").value =data.nomb_emp;
        document.getElementById("razon_s").value =data.razon_s;
        document.getElementById("direccion").value =data.direccion;
        document.getElementById("telefono_emp").value =data.telefono_emp;
        document.getElementById("password").value="A9w12345";
        document.getElementById("password").disabled=true;
    }

    restablecerEmpresa() {
        document.getElementById("btn-registro-empresa").innerHTML="REGISTRAR";
        document.getElementById("addempresaTitle").innerHTML="Registrar empresa";
        
        this.funcion=0;
        this.id_user=0;
        this.perfil=null;

        document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "resource/images/imgFiles/empresas/user.png", '" title="', , '" />'].join('');

        $("#addempresa").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        //limpiar campos de texto
        document.getElementById("id").value = "";
        document.getElementById("nomb_emp").value = "";
        document.getElementById("razon_s").value = "";
        document.getElementById("direccion").value = "";
        document.getElementById("telefono_emp").value = "";
        document.getElementById("password").value = "";
         window.location.href = URL + "admin/empresa";
    }

    //registro de usuario rol de empresa
    registroEmpresaUser(id, nomb_emp, razon_s, direccion, telefono_emp, password) {
        if (validarPass(password)) {
            if (password.length <= 16) {
                //crear colección de objetos para enviarlos al servidor
                var data = new FormData();
                $.each($('input[type=file]')[0].files, (i, file) => {
                    data.append('logo', file);
                });

                data.append('id', id);
                data.append('nomb_emp', nomb_emp);
                data.append('razon_s', razon_s);
                data.append('direccion', direccion);
                data.append('telefono_emp', telefono_emp);
                data.append('password', password);

                $.ajax({
                    url: URL + "user/postRegistroEmpresa",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {
                        if (response == 0) {
                            toastr.success("Empresa registrada.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            restablecerEmpresaUser();
                        } else {
                            console.log(response);
                            //document.getElementById("registerEMessage").innerHTML =response;
                            toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }
                    }
                });

            } else {
                document.getElementById("password").focus();
                document.getElementById("registerEMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
            }
        } else {
            document.getElementById("password").focus();
            document.getElementById("registerEMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
        }
    }

    restablecerEmpresaUser() {
        document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/empresas/user.png", '" title="', , '" />'].join('');
        
        //limpiar campos de texto
        document.getElementById("id").value = "";
        document.getElementById("nomb_emp").value = "";
        document.getElementById("razon_s").value = "";
        document.getElementById("direccion").value = "";
        document.getElementById("telefono_emp").value = "";
        document.getElementById("password").value = "";
    }

    //registro de usuario rol de persona
    registroUsers(nomb_pers, ape_pers, identificacion, id, direccion, password) {
        //verificar si los parametros están vacios
        if (validarPass(password)) {
            if (password.length <= 16) {
                //crear colección de objetos para enviarlos al servidor
                var data = new FormData();
                $.each($('input[type=file]')[0].files, (i, file) => {
                    data.append('foto_pers', file);
                });

                data.append('nomb_pers', nomb_pers);
                data.append('ape_pers', ape_pers);
                data.append('identificacion', identificacion);
                data.append('id', id);
                data.append('direccion', direccion);
                data.append('password', password);

                $.ajax({
                    url: URL + "user/postRegistro",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: (response) => {
                        console.log(response);
                        if (response == 0) {
                            toastr.success("Usuario registrado.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            restablecerUsers();
                        } else {
                            // console.log(response);
                            //document.getElementById("registerUMessage").innerHTML = response;
                            toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                        }

                    }
                });

            } else {
                document.getElementById("password").focus();
                document.getElementById("registerUMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
            }
        } else {
            document.getElementById("password").focus();
            document.getElementById("registerUMessage").innerHTML = "La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.";
        }
    }

    restablecerUsers() {        
        document.getElementById("fotos").innerHTML = ['<img class="img60" src="', PATHNAME + "/resource/images/imgFiles/personas/user.png", '" title="', , '" />'].join('');
        
        //limpiar campos de texto
        document.getElementById("nomb_pers").value = "";
        document.getElementById("ape_pers").value = "";
        document.getElementById("id").value = "";
        document.getElementById("direccion").value = "";
        document.getElementById("password").value = "";
    }

    /** --------------------------------------------------------------------------------------------------------*/
    /**ACTUALIZAR PERFIL DE USUARIO CON ROL PERSONA O ADMIN -- INI */

    //Actualizar perfil del usuario persona en su sesión 
    actdataUser(){
        $.post(
            URL+"user/actdataUser",
            {},
            (response)=>{
                
                let item=JSON.parse(response);
                console.log(item);

                this.funcion=1;
                this.id_user=item.id;
                this.perfil=item.perfil;
                
                if(item.rol=="1" || item.rol=="3"){
                    this.getIdentificaciones(item.codi,2);
                
               document.getElementById("id").value =item.id;
               document.getElementById("nomb_pers").value =item.nombre;
               document.getElementById("ape_pers").value =item.apellido;
               document.getElementById("emai_pers").value =item.correo;
               document.getElementById("fotos").innerHTML=['<img class="foto-perfil" src="',PATHNAME+"/resource/images/imgFiles/personas/"+item.perfil, '" title="', escape(item.perfil), '"/>'].join('');
                }else{
                    this.getIdentificaciones(item.codi,2);
                    document.getElementById("id").value =item.id;
                    document.getElementById("nomb_emp").value =item.nombre;
                    if(item.correo==undefined){
                        document.getElementById("emai_emp").value ="";
                    }else{
                        document.getElementById("emai_emp").value =item.correo;
                    }

                    document.getElementById("fotos").innerHTML=['<img class="foto-perfil" src="',PATHNAME+"/resource/images/imgFiles/empresas/"+item.perfil, '" title="', escape(item.perfil), '"/>'].join('');
                }
                
            }
            );
        }

    //Guardar datos actualizados del perfil de un usuario con rol de persona
    actUser() {
        let valor=false;
        if (validarEmail(document.getElementById("emai_pers").value)) {
            //crear colección de objetos para enviarlos al servidor
            var data = new FormData();
            $.each($('input[type=file]')[0].files, (i, file) => {
                data.append('foto_pers', file);
            });
            //Actualizar user ini y enviar al servidor la id del usuario que se va a registrar
            data.append('id_user', this.id_user);
            data.append('foto_pers', this.perfil);
            
            data.append('id', document.getElementById("id").value);
            data.append('nomb_pers', document.getElementById("nomb_pers").value);
            data.append('ape_pers', document.getElementById("ape_pers").value);
            data.append('emai_pers', document.getElementById("emai_pers").value);
            
            //console.log(data);
            $.ajax({
                url: URL + "user/actUser",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {
                    //console.log(response);
                    if (response == 0) {
                        if (null != localStorage.getItem("user")) {
                            document.getElementById('nombreusuario').innerHTML =document.getElementById("nomb_pers").value+' '+document.getElementById("ape_pers").value;
                            document.getElementById("fotoUser").innerHTML = ['<img class="img-profile rounded-circle" src="', PERFILES +"personas/"+ this.perfil, '" title="', escape(this.perfil), '" />'].join('');
                            
                            toastr.success("Datos actualizados.", '¡Éxito!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                            window.location.href=URL+"user/perfil";
                        }
                        
                          
                    } else {
                        valor=true;
                        toastr.error(response, '¡Error!', {
                            "progressBar": true,
                            "positionClass": "toast-bottom-right"
                        });
                    }
                }
            });
        } else {
            document.getElementById("emai_pers").focus();
            toastr.error("Correo electrónico no válido.", '¡Error!', {
                "progressBar": true,
                "positionClass": "toast-bottom-right"
            });
        }
        return valor;
    }

    /**ACTUALIZAR PERFIL DE USUARIO CON ROL PERSONA O ADMIN -- FIN */
    /** --------------------------------------------------------------------------------------------------------*/

    /**VER DETALLES DE OFERTA LABORAL EN MI INDEX -- INICIO */
    /** --------------------------------------------------------------------------------------------------------*/

    verOferta(data){
        $('#verOferta').modal({
            backdrop: 'static',
            keyboard: false
        });
        
        document.getElementById("verOfertaTitle").innerHTML=data.nomb_cargo;
        
        var desc=data.desc_cargo.split(";");
        for (var i=1; i < desc.length; i++) {
            document.getElementById("verOfertaDescripcion").innerHTML += '<li>'+desc[i]+'</li>';
        }
        
        document.getElementById("cargo").innerHTML='Cargo Vacante: '+data.nomb_cargo;
        document.getElementById("perfil").innerHTML='Perfil del Aspirante: '+data.perfil;
        
        if(data.vi_salario == 1){
            document.getElementById("salario").innerHTML='Salario: '+new Intl.NumberFormat("es-CO", {style: "currency", currency: "COP"}).format(data.salario);
        }else{
            document.getElementById("salario").innerHTML='Salario: A convenir';
        }
    }

    restablecerverOferta(){
        document.getElementById("verOfertaDescripcion").innerHTML="";
    }
    /**VER DETALLES DE OFERTA LABORAL EN MI INDEX -- FIN */
    /** --------------------------------------------------------------------------------------------------------*/

    /**LISTADO DE OFERTAS LABORALES EN MI INDEX -- INICIO */
    /** --------------------------------------------------------------------------------------------------------*/
    
    getListaConvocatoria(valor,page){
        var valor = valor != null ? valor : "";
        $.post(
            URL+"user/getListaConvocatoria",
            {
                filter:valor,
                page:page
            },
            (response)=>{
                //console.log(response);
                //$("#resultsUser").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#listaConvo").html(item.dataFilter);
                    $("#paginador").html(item.paginador);

                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }
    /**LISTADO DE OFERTAS LABORALES EN MI INDEX -- FIN */
    /** --------------------------------------------------------------------------------------------------------*/
    
    postularConvo() {
        if (null != localStorage.getItem("user")) {
            let valor= false;
            var url_act= location.href;
            var data=url_act.split('-');
            var codigo=data[1];
            window.location.href=URL+"persona/detalleconvocatoria?codigo="+codigo;
            return valor;
        }else{
            window.location.href=URL+"user/login";
        }
    }

    enviarCorreo(){
        let valor= false;
        if (validarEmail(document.getElementById("email").value)) {
            //crear colección de objetos para enviarlos al servidor
            var data = new FormData();
            data.append('nombre', document.getElementById("nombre").value);
            data.append('email', document.getElementById("email").value);
            data.append('telefono', document.getElementById("telefono").value);
            data.append('asunto', document.getElementById("asunto").value);
            data.append('mensaje', document.getElementById("mensaje").value);
            $.ajax({
                url: URL + "user/enviarCorreo",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: (response) => {
                    console.log(response);
                    if (response == 0) {
                        toastr.success("Mensaje enviado.", '¡Éxito!', {
                            "progressBar": true,
                            "positionClass": "toast-bottom-right"
                        });
                        restablecerCorreo();
                    } else {
                        // console.log(response);
                        valor=true;
                        toastr.error(response, '¡Error!', {
                            "progressBar": true,
                            "positionClass": "toast-bottom-right"
                        });
                    }
                }
                })
        }else {
            $('#email').focus();
            $('#email').removeClass('is-valid');
            $('#email').addClass('is-invalid');
            toastr.error("Dirección de correo invalida.", '¡Error!', {
                "progressBar": true,
                "positionClass": "toast-bottom-right"
            });
        }
        return valor;
    }
    
    restablecerCorreo(){
        this.funcion=0;
        document.getElementById("nombre").value="";
        document.getElementById("email").value="";
        document.getElementById("telefono").value="";
        document.getElementById("asunto").value="";
        document.getElementById("mensaje").value="";
        window.location.href=URL+"user/contacto";
    }

    /**CERRAR SESSION  -- INI */
    sessionClose() {
        localStorage.clear();
        document.getElementById('menu-navbar').style.display = 'none';
    }
    /**CERRAR SESSION  -- FIN */
}