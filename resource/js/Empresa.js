class Empresa{
    constructor() {
        //objetos para actualizar datos
        this.funcion=0;
        //id del usuario que se va actualizar
        this.id_empresa=0;
        //codigo
        this.codigo=0;
        //id del candidato
        this.id_candidato='';
    }
    
    //Llenar select de categorías laborales
    getCategorias_laborales(cat, funcion) {
        let count = 1;
        $.post(
            URL + "empresa/getCategorias_laborales", {},
            (response) => {
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('categoria').options[0] = new Option("Seleccione una categoría", 0);
                    if (item.results.length > 0) {
                        for (let i = 0; i <= item.results.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('categoria').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    count++;
                                break;
                            
                                case 2:
                                    document.getElementById('categoria').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    if (item.results[i].id == cat) {
                                        i++;
                                        document.getElementById('categoria').selectedIndex=i;
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
    
    //Llena select de tipos de contratos laborales
    getContratos(contrato, funcion) {
        let count = 1;
        $.post(
            URL + "empresa/getContratos", {},
            (response) => {
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('t_contrato').options[0] = new Option("Seleccione un tipo de contrato", 0);
                    if (item.results.length > 0) {
                        for (let i = 0; i <= item.results.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('t_contrato').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    count++;
                                break;
                            
                                case 2:
                                    document.getElementById('t_contrato').options[count] = new Option(item.results[i].descripcion, item.results[i].id);
                                    if (item.results[i].id == contrato) {
                                        i++;
                                        document.getElementById('t_contrato').selectedIndex=i;
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
    
    getConvocatorias(valor,page){
        var valor = valor != null ? valor : "";
        $("#resultsConvo").html('<div class="d-flex justify-content-center"><div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div></div>');

        $.post(
            URL+"empresa/getConvocatorias",
            {
                filter:valor,
                page:page
            },
            (response)=>{
                
                //console.log(response);
                //$("#resultsUser").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#resultsConvo").html(item.dataFilter);
                    $("#paginador").html(item.paginador);
                    
                    
                      
                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }
    
    //registro de convocatorias
    registerConvocatorias(){
        var valor=false;
        var data =new FormData();
        
        var url=this.funcion == 0 ? "empresa/registerConvocatorias" : "empresa/editConvocatoria";
        
        let t_contrato = document.getElementById("t_contrato");
        let contrato = t_contrato.options[t_contrato.selectedIndex].value;
        let categoria = document.getElementById("categoria");
        let categoria_lab = categoria.options[categoria.selectedIndex].value;
        data.append('codigo', this.codigo);   
        data.append('nomb_cargo', $("#nomb_cargo").val());
        data.append('perfil', $("#perfil").val());
        data.append('desc_cargo', $("#desc_cargo").val());
        data.append('categoria_lab', categoria_lab);
        data.append('contrato', contrato);
        data.append('salario', $("#salario").val());
        if( $("#vi_salario").is(':checked') ) {
            data.append('vi_salario', "1");
        }else{
            data.append('vi_salario', "0");
        }
        data.append('id_empresa', this.id_empresa);
        data.append('estado', $("#estado").val());
        data.append('fecha_ini', $("#fecha_ini").val());
        data.append('fecha_fin', $("#fecha_fin").val());
        
        $.ajax({
           url:URL+url,
           data:data,
           cahe:false,
           contentType:false,
           processData:false,
           type:'POST',
           success:(response)=>{
               //console.log(response);
               if(response == 0){
                   this.restablecerConvocatoria();
                   valor=false;
               }else{
                   toastr.error(response, '¡Error!', {
                                "progressBar": true,
                                "positionClass": "toast-bottom-right"
                            });
                   valor=true;
               }
           }
        });
        
        return valor;
    }

    //editar convocatoria
    editConvocatoria(data){
        $('#addconvo').modal({
            backdrop: 'static',
            keyboard: false
        });
        
        document.getElementById("registerConvocatoria").innerHTML = "ACTUALIZAR";
        document.getElementById("addconvoTitle").innerHTML = "Actualizar Convocatoria";
        this.funcion = 1;
        this.codigo = data.id;
        this.id_empresa = data.id_empresa;
        document.getElementById("nomb_cargo").value = data.nomb_cargo;
        document.getElementById("perfil").value = data.perfil;
        document.getElementById("desc_cargo").value = data.desc_cargo;
        document.getElementById("salario").value = data.salario;
        document.getElementById("estado").value = data.estado;
        document.getElementById("fecha_ini").value = data.fecha_ini;
        document.getElementById("fecha_fin").value = data.fecha_fin;
        if(data.vi_salario==1){
            $("#vi_salario").prop("checked", true);
        }else{
            $("#vi_salario").prop("checked", false);
        }
        this.getContratos(data.t_contrato, 2);
        this.getCategorias_laborales(data.categoria, 2);
    }

    //eliminar convocatoria
    deleteConvo(data){
        $.post(
            URL + "empresa/deleteConvo", {
                codigo: data.id,
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Convocatoria Eliminada.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.restablecerConvocatoria();
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
    }
    
    //restablecer convocatoria
    restablecerConvocatoria() {
        document.getElementById("registerConvocatoria").innerHTML="REGISTRAR";
        document.getElementById("addconvoTitle").innerHTML="Registrar convocatoria laboral";
        
        this.funcion=0;
        this.id_empresa=0;
        this.codigo=0;

        document.getElementById("nomb_cargo").value = "";
        document.getElementById("perfil").value = "";
        document.getElementById("desc_cargo").value = "";
        document.getElementById("salario").value = "";
        document.getElementById("vi_salario").value = "";
        document.getElementById("estado").value = "";
        document.getElementById("fecha_ini").value = "";
        document.getElementById("fecha_fin").value = "";
        
        this.getCategorias_laborales(null,1);
        this.getContratos(null,1);
        
        window.location.href = URL + "empresa/convocatorias";
    }

    /**--------------------------------------------------------------------------------------------------------------- */
    //Opciones de select categoría laboral
    getCatLaboral(categoria, funcion) {
        let count = 1;
        $.post(
            URL + "empresa/getCatLaboral", {},
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
                    url: URL + "empresa/getPerfilLaboral",
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

    getBusquedaUsers(id_categoria,id_perfil,page){
        var id_perfil = id_perfil != null ? id_perfil : "";
        var id_categoria = id_categoria != null ? id_categoria : "";
        $.post(
            URL+"empresa/getBusquedaUsers",
            {
                id_categoria:id_categoria,
                id_perfil:id_perfil,
                page:page
            },
            (response)=>{
                //console.log(response);
                //$("#resultsUser").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#results_busquedauser").html(item.dataFilter);
                    $("#paginador").html(item.paginador);

                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }

    viewUserData(data) {

        $('#busquedauser').modal({
            backdrop: 'static',
            keyboard: false
        });
        
        document.getElementById("nombUser").innerHTML = data[0].nomb_pers+" "+data[0].ape_pers;
        if(data[1].titulo==undefined || data[1].descripcion==undefined){
            document.getElementById("perfilUser").innerHTML = "---";
            document.getElementById("descPerfilUser").innerHTML = "---";
        }else{
            document.getElementById("perfilUser").innerHTML = data[1].titulo;
            document.getElementById("descPerfilUser").innerHTML = data[1].descripcion;
        }   
        
        document.getElementById("fnac_pers").innerHTML = "<span class='font-weight-bold mb-0'>Fecha de Nacimiento: </span>"+data[0].fnac_pers;
        document.getElementById("direccion").innerHTML = "<span class='font-weight-bold mb-0'>Dirección: </span>"+data[0].direccion;
        document.getElementById("emai_pers").innerHTML = "<span class='font-weight-bold mb-0'>Correo Electrónico: </span>"+data[0].emai_pers;
        document.getElementById("telefono1").innerHTML = "<span class='font-weight-bold mb-0'>Teléfono: </span>"+data[0].telefono1;
        this.funcion = 1;
        this.perfil = data[0].foto_pers;
        this.id_candidato = data[0].id;
        document.getElementById("fotoPerfilUser").innerHTML = ['<img class="sizefotoPerfilUser" src="', PATHNAME + "resource/images/imgFiles/personas/" + data[0].foto_pers, '" title="', escape(data[0].foto_pers), '"/>'].join('');
        if(data[2].hoja_de_vida==undefined){
            document.getElementById("downloadcvUser").innerHTML = " ";
        }else{
            document.getElementById("downloadcvUser").innerHTML = ['<a download class="btn btn-success rounded-pill text-white" href="',PATHNAME + "resource/files/hdvPersonas/"+data[2].hoja_de_vida,'">DESCARGAR CV</a>'].join('');
        }

       
    }

    getConvoCandidatos(convocatoria_lab,page){
        var convocatoria_lab = convocatoria_lab != null ? convocatoria_lab : "";
        $.post(
            URL+"empresa/getConvoCandidatos",
            {
                convocatoria_lab:convocatoria_lab,
                page:page
            },
            (response)=>{
                //console.log(response);
                //$("#resultsUser").html(response);
                try{
                    let item=JSON.parse(response);
                    $("#results_candidatos").html(item.dataFilter);
                    $("#paginador").html(item.paginador);

                }catch(error){
                    $("#paginador").html(response);
                }
            }
        );
    }

    viewCandidatoData(data) {

        console.log(data);
        $('#convocandidato').modal({
            backdrop: 'static',
            keyboard: false
        });

        
        
        document.getElementById("nombUser").innerHTML = data[0].nomb_pers+" "+data[0].ape_pers;
        if(data[1].titulo==undefined || data[1].descripcion==undefined){
            document.getElementById("perfilUser").innerHTML = "---";
            document.getElementById("descPerfilUser").innerHTML = "---";
        }else{
            document.getElementById("perfilUser").innerHTML = data[1].titulo;
            document.getElementById("descPerfilUser").innerHTML = data[1].descripcion;
        }   
        
        document.getElementById("fnac_pers").innerHTML = "<span class='font-weight-bold mb-0'>Fecha de Nacimiento: </span>"+data[0].fnac_pers;
        document.getElementById("direccion").innerHTML = "<span class='font-weight-bold mb-0'>Dirección: </span>"+data[0].direccion;
        document.getElementById("emai_pers").innerHTML = "<span class='font-weight-bold mb-0'>Correo Electrónico: </span>"+data[0].emai_pers;
        document.getElementById("telefono1").innerHTML = "<span class='font-weight-bold mb-0'>Teléfono: </span>"+data[0].telefono1;
        this.funcion = 1;
        this.perfil = data[0].foto_pers;
        this.id_candidato = data[0].id;
        document.getElementById("fotoPerfilUser").innerHTML = ['<img class="sizefotoPerfilUser" src="', PATHNAME + "resource/images/imgFiles/personas/" + data[0].foto_pers, '" title="', escape(data[0].foto_pers), '"/>'].join('');
        if(data[2].hoja_de_vida==undefined){
            document.getElementById("downloadcvUser").innerHTML = " ";
        }else{
            document.getElementById("downloadcvUser").innerHTML = ['<a download class="btn btn-success rounded-pill text-white" href="',PATHNAME + "resource/files/hdvPersonas/"+data[2].hoja_de_vida,'">DESCARGAR CV</a>'].join('');
        }

        
          $(function () {
            $("#estado0").click(function () {
                let array0=[data[0].id,data[3].id_conv,data[3].id,'0',data[3].created_at];
                empresa.editEstadoCandidato(array0);
            });

            $("#estado1").click(function () {
                let array1=[data[0].id,data[3].id_conv,data[3].id,'1',data[3].created_at];
                empresa.editEstadoCandidato(array1);
            });

            $("#estado2").click(function () {
                let array2=[data[0].id,data[3].id_conv,data[3].id,'2',data[3].created_at];
                empresa.editEstadoCandidato(array2);
            });

            $("#estado3").click(function () {
                let array3=[data[0].id,data[3].id_conv,data[3].id,'3',data[3].created_at];
                empresa.editEstadoCandidato(array3);
            });
        
        });

        document.getElementById("results_estados").innerHTML = "<div class='row'>"+
        "<div class='col-md-3'>"+
            "<div class='shadow p-3 mb-5 bg-white rounded' id='estadoAct0'>"+
                "<div class='form-check'>"+
                    "<input class='form-check-input' type='radio' name='estado' id='estado0' value='0'/>"+
                    "<small class='text-dark' name='estado0' id='estado0'><i class='fas fa-user-clock'></i> En espera</small>"+
                "</div>"+
            "</div>"+
        "</div>"+

        "<div class='col-md-3'>"+
            "<div class='shadow p-3 mb-5 bg-white rounded' id='estadoAct1'>"+
                "<div class='form-check'>"+
                    "<input class='form-check-input' type='radio' name='estado' id='estado1' value='1'/>"+
                    "<small class='text-info' name='estado1' id='estado1'><i class='fas fa-user-alt-slash'></i> Visto</small>"+
                "</div>"+
            "</div>"+
        "</div>"+

        "<div class='col-md-3'>"+
            "<div class='shadow p-3 mb-5 bg-white rounded' id='estadoAct2'>"+
                "<div class='form-check'>"+
                    "<input class='form-check-input' type='radio' name='estado' id='estado2' value='2'/>"+
                    "<small class='text-success' name='estado2' id='estado2'><i class='fas fa-user-check'></i> Finalista</small>"+
                "</div>"+
            "</div>"+
        "</div>"+

        "<div class='col-md-3'>"+
            "<div class='shadow p-3 mb-5 bg-white rounded' id='estadoAct3'>"+
                "<div class='form-check'>"+
                    "<input class='form-check-input' type='radio' name='estado' id='estado3' value='3'/>"+
                    "<small class='text-danger' name='estado3' id='estado3'><i class='fas fa-user-times'></i> Rechazado</small>"+
                "</div>"+
            "</div>"+
        "</div>"+
    "</div>";

        var estado0= $("#estado0").val();
        var estado1= $("#estado1").val();
        var estado2= $("#estado2").val();
        var estado3= $("#estado3").val();
               
    
        if(data[3].estado=="0" && estado0=="0"){
            $("#estado0").prop("checked", true);
            $("#estadoAct0").addClass("border");
            $("#estadoAct0").addClass("border-dark");
        }

        if(data[3].estado=="1" && estado1=="1"){
            $("#estado1").prop("checked", true);
            $("#estadoAct1").addClass("border");
            $("#estadoAct1").addClass("border-info");
        }

        if(data[3].estado=="2" && estado2=="2"){
            $("#estado2").prop("checked", true);
            $("#estadoAct2").addClass("border");
            $("#estadoAct2").addClass("border-success");
        }
        
        if(data[3].estado=="3" && estado3=="3"){
            $("#estado3").prop("checked", true);
            $("#estadoAct3").addClass("border");
            $("#estadoAct3").addClass("border-danger");
        }

        

    }

    editEstadoCandidato (data){
        //console.log(data);
        $.post(
            URL + "empresa/editEstadoCandidato", {
                id_persona: data[0],
                id_conv: data[1],
                id: data["2"],
                estado: data[3],
                created_at: data[4],
            },
            (response) => {
                if (response == 0) {
                    toastr.success("Estado del candidato actualizado.", '¡Éxito!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                    this.convoCandidatosclose();
                    window.location.href = URL + "empresa/candidatos";
                } else {
                    toastr.error(response, '¡Error!', {
                        "progressBar": true,
                        "positionClass": "toast-bottom-right"
                    });
                }
            });
            
    }

    //Llena select con las convo laborales de una empresa
    getConvocatoriasLabs(convo, funcion) {
        let count = 1;
        $.post(
            URL + "empresa/getConvocatoriasLabs", {},
            (response) => {
                try {
                    let item = JSON.parse(response);
                    //console.log(item);
                    document.getElementById('convocatoria_lab').options[0] = new Option("Seleccione una categoría", 0);
                    if (item.results.length > 0) {
                        for (let i = 0; i <= item.results.length; i++) {
                            switch (funcion) {
                                case 1:
                                    document.getElementById('convocatoria_lab').options[count] = new Option(item.results[i].nomb_cargo, item.results[i].id);
                                    count++;
                                break;
                            
                                case 2:
                                    document.getElementById('convocatoria_lab').options[count] = new Option(item.results[i].nomb_cargo, item.results[i].id);
                                    if (item.results[i].id == convo) {
                                        i++;
                                        document.getElementById('convocatoria_lab').selectedIndex=i;
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

    userBusquedaclose(){
        this.funcion = 0;
        this.id_candidato = 0;
        this.perfil = null;

        $("#adduser").modal('hide');
        $("#deleteUser").modal('hide');
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();

        document.getElementById("nombUser").innerHTML = "";
        document.getElementById("perfilUser").innerHTML = "";
        document.getElementById("descPerfilUser").innerHTML = "";
        document.getElementById("fotoPerfilUser").innerHTML = "";
        document.getElementById("downloadcvUser").innerHTML = "";
        document.getElementById("fnac_pers").innerHTML = "";
        document.getElementById("direccion").innerHTML = "";
        document.getElementById("emai_pers").innerHTML = "";
        document.getElementById("telefono1").iinnerHTML= "";
    }

    convoCandidatosclose(){
        this.funcion = 0;
        this.id_candidato = 0;
        this.perfil = null;

        document.getElementById("nombUser").innerHTML = "";
        document.getElementById("perfilUser").innerHTML = "";
        document.getElementById("descPerfilUser").innerHTML = "";
        document.getElementById("fotoPerfilUser").innerHTML = "";
        document.getElementById("downloadcvUser").innerHTML = " ";
        document.getElementById("fnac_pers").innerHTML = "";
        document.getElementById("direccion").innerHTML = "";
        document.getElementById("emai_pers").innerHTML = "";
        document.getElementById("telefono1").iinnerHTML= "";

        $("#estadoAct0").removeClass("border");
        $("#estadoAct0").removeClass("border-dark");
        $("#estadoAct1").removeClass("border");
        $("#estadoAct1").removeClass("border-info");
        $("#estadoAct2").removeClass("border");
        $("#estadoAct2").removeClass("border-success");
        $("#estadoAct3").removeClass("border");
        $("#estadoAct3").removeClass("border-danger");
    }

}