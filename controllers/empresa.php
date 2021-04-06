<?php
class empresa extends controllers{
    function __construct(){
        parent::__construct();
    }

    public function panel(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("2" == $user["rol"]){
        $this->view->render($this, "index");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function userbusqueda(){ 
         $user=session::getSession("user");
         if (null != $user) {
             if("2" == $user["rol"]){
        $this->view->render($this, "busqueda");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }
    
    public function convocatorias(){ 
         $user=session::getSession("user");
         if (null != $user) {
             if("2" == $user["rol"]){
        $this->view->render($this, "convocatorias");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function candidatos(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("2" == $user["rol"]){
       $this->view->render($this, "candidatos");
            }else{
                header("Location:".URL."user/privilegios");    
            }
            
        } else {
            header("Location:".URL."user/login");
            
        }
   }

    function getCategorias(){
        $data=$this->model->getCategorias();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }
    
    public function getCategorias_laborales(){
        $data = $this->model->getCategorias_laborales();
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
    }
    
    public function getContratos(){
        $data = $this->model->getContratos();
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
    }

    function getConvocatoriasLabs(){
        $user=session::getSession("user");
        $id_empresa=$user["id"];
        $data=$this->model->getConvocatoriasLabs($id_empresa);
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }
    
    public function getConvocatorias(){
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                $count=0;
        $dataFilter = null;
        $item=1;
        $data = $this->model->getConvocatorias($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data["results"];
            foreach ($array as $key => $value) {
                $dataConvocatoria=json_encode($array[$count]);
                $data2=$this->model->getCat($value["categoria"]);
                $data3=$this->model->getContrato($value["t_contrato"]);
                $data4=$this->model->getPostulantes($value["id"]);

                if ($value["estado"] == 1) {
                    $value["estado"] = "<span class='badge badge-success'>Activo</span>";
                } else if ($value["estado"] == 2) {
                    $value["estado"] = "<span class='badge badge-warning'>Inactivo</span>";
                } else {
                    $value["estado"] = "<span class='badge badge-danger'>Cerrado</span>";
                }
                
                $dataFilter .= "<div class='card mb-2'>" .
                "<div class='card-body'>" .
                "<div class='row' style='display: flex !important;align-items: center !important;'>".
                "<div class='col-md-6 border-right'>".
                    "<h5 class='card-title' style='color: #15488d;'>" . $value["nomb_cargo"] . "</h5>" .
                    "<h6 class='text-muted' style='margin-top: -8px;'>" . $value["perfil"] . "</h6>" .
                    "<small class='text-success' style='margin-top: -8px;'>" . $data2[0]["descripcion"] . " | ". $data3[0]["descripcion"] ."</small>" .
                "</div>" .
                "<div class='col-md-3 border-right'>".
                "<h4 class='text-center mb-0 font-weight-bold'>$data4</h4>".
                "<p class=' text-center text-success font-italic' style='line-height: 1.2;'>Postulantes se han registrado en esta convocatoria.</p>".
                "</div>" .
                "<div class='col-md-3 align-middle'>".
                "<div class='text-center align-middle'>".
                "<a href='#modal1' onclick='dataConvocatoria(".$dataConvocatoria.");' data-toggle='modal' data-target='#addconvo'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                "<a href='#modal2' onclick='deleteConvo(".$dataConvocatoria.");' data-toggle='modal' data-target='#deleteconvo'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                "</div>" .
                "</div>" .
                    "</div>" .
                    "</div>" .
                    "<div class='card-footer text-muted'>Estado: ".$value["estado"]. "</div>".
                    "</div>";
                $count++;
                $item++;
                  
            }
            //echo $dataFilter;
            $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode( array(
                "dataFilter" => $dataFilter,
                "paginador" => $paginador
            ));
        } else {
            echo $data;
        }
            }
        }
        
    }
    
    public function registerConvocatorias(){
        $id_empresa=$_SESSION["user"]["id"];
        $vi_salario=null;
        $id="";
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                if(empty($_POST["nomb_cargo"])){
                    echo "El campo nombre del cargo es obligatorio.";
                }else{
                   if(empty($_POST["perfil"])){
                       echo "El campo perfil del aspirante es obligatorio.";
                   }else{
                      if(empty($_POST["desc_cargo"])){
                          echo "El campo descripción del cargo es obligatorio.";
                      }else{
                        if(strcmp("Seleccione una categoría", $_POST["categoria_lab"]) === 0){
                            echo "Seleccione una categoría.";
                        }else{
                            if(strcmp("Seleccione un tipo de contrato", $_POST["contrato"]) === 0){
                                echo "Seleccione un tipo de contrato.";
                            }else{
                                if(empty($_POST["salario"])){
                                    echo "El campo salario es obligatorio.";
                                }else{
                                    if($_POST["vi_salario"] == "0"){
                                        $vi_salario="0";
                                    }else{
                                        $vi_salario="1";
                                    }
                                    if(empty($_POST["estado"])){
                                       echo "El campo estado es obligatorio.";
                                   }else{
                                       if(empty($_POST["fecha_ini"])){
                                           echo "El campo fecha inicio es obligatorio.";
                                       }else{
                                         if(empty($_POST["fecha_fin"])){
                                             echo "El campo fecha fin es obligatorio.";
                                         }else{
                                             $array=array(
                                                 $id,
                                                 $id_empresa,
                                                 $_POST["nomb_cargo"],
                                                 $_POST["perfil"],
                                                 $_POST["desc_cargo"],
                                                 $_POST["categoria_lab"],
                                                 $_POST["contrato"],
                                                 $_POST["salario"],
                                                 $vi_salario,
                                                 $_POST["estado"],
                                                 $_POST["fecha_ini"],
                                                 $_POST["fecha_fin"]
                                                 );
                                                //return var_dump($this->convocatoriaClass($array));
                                                $data = $this->model->registerConvocatorias($this->convocatoriaClass($array));
                                                        if ($data == 1) {
                                                            echo "La convocatoria ya esta registrada en el sistema.";
                                                        } else {
                                                            echo $data;
                                                        }
                                         }
                                       }
                                   }
                                }
                            }
                        }
                      }
                   }
                }
            }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function editConvocatoria(){
        $user=session::getSession("user");
        $id=$_POST["codigo"];
        $id_empresa=$user["id"];
        if(null != $user){
            if("2" == $user["rol"]){
                if(empty($_POST["nomb_cargo"])){
                    echo "El campo nombre del cargo es obligatorio.";
                }else{
                   if(empty($_POST["perfil"])){
                       echo "El campo perfil del aspirante es obligatorio.";
                   }else{
                      if(empty($_POST["desc_cargo"])){
                          echo "El campo descripción del cargo es obligatorio.";
                      }else{
                        if(strcmp("Seleccione una categoría", $_POST["categoria_lab"]) === 0){
                            echo "Seleccione una categoría.";
                        }else{
                            if(strcmp("Seleccione un tipo de contrato", $_POST["contrato"]) === 0){
                                echo "Seleccione un tipo de contrato.";
                            }else{
                                if(empty($_POST["salario"])){
                                    echo "El campo salario es obligatorio.";
                                }else{
                                    if($_POST["vi_salario"] == "0"){
                                        $vi_salario="0";
                                    }else{
                                        $vi_salario="1";
                                    }
                                    if(empty($_POST["estado"])){
                                       echo "El campo estado es obligatorio.";
                                   }else{
                                       if(empty($_POST["fecha_ini"])){
                                           echo "El campo fecha inicio es obligatorio.";
                                       }else{
                                         if(empty($_POST["fecha_fin"])){
                                             echo "El campo fecha fin es obligatorio.";
                                         }else{
                                             $array=array(
                                                 $id,
                                                 $_POST["nomb_cargo"],
                                                 $_POST["perfil"],
                                                 $_POST["desc_cargo"],
                                                 $_POST["categoria_lab"],
                                                 $_POST["contrato"],
                                                 $_POST["salario"],
                                                 $vi_salario,
                                                 $id_empresa,
                                                 $_POST["estado"],
                                                 $_POST["fecha_ini"],
                                                 $_POST["fecha_fin"]
                                                 );
                                                //return var_dump($this->convocatoriaClass($array));
                                                $data = $this->model->editConvocatoria($id,$this->convocatoriaClass($array));
                                                        if ($data == 1) {
                                                            echo "La convocatoria ya esta registrada en el sistema.";
                                                        } else {
                                                            echo $data;
                                                        }
                                         }
                                       }
                                   }
                                }
                            }
                        }
                      }
                   }
                }
            }else{
                header("Location:".URL."user/privilegios");    
            }
        }else {
            header("Location:".URL."user/login");
            
        }
    }

    public function deleteConvo(){
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                echo $this->model->deleteConvo($_POST["codigo"]);
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    function getCatLaboral(){
        $data=$this->model->getCatLaboral();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }

    function getPerfilLaboral(){
        $data=$this->model->getPerfilLaboral($_POST["codigo"]);
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }

    public function getBusquedaUsers(){
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                $count=0;
                $dataFilter = null;
                $data = $this->model->getBusquedaUsers($_POST["id_categoria"],$_POST["id_perfil"],$_POST["page"],$this->page);
                if(is_array($data)){
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataBusquedaUser=json_encode($array[$count]);
                        $response=$this->model->getDatosPersona($value["id"]);
                        $response2=$this->model->getperfilProfesionalPersona($value["id"]);
                        if($response2==null){
                            $response2=array(0);
                        }
                        $response3=$this->model->getHvPersona($value["id"]);
                        $response3=$this->model->getHvPersona($value["id"]);
                        if($response3==null){
                            $response3=array(0);
                        }
                        $dataUser=array_merge($response, $response2, $response3);
                        $dataUserB=json_encode($dataUser);
                        
                        if(0 == ($response3[0])){
                            $hv_persona="--";
                        }else{
                            $hv_persona="<a download href='".RS."files/hdvPersonas/".$response3[0]["hoja_de_vida"]."'><i class='fas fa-paperclip text-success font-italic text-center'></i></a>";
                        }
                        
                        $anno_actual = date("Y");
                        $fechaComoEntero = strtotime($response[0]["fnac_pers"]);
                        $fnac=date("Y",$fechaComoEntero);
                        $edad=$anno_actual-$fnac;
                        $dataFilter .= "<tr>" .
                        "<td style='width:180px;'><center><img class='img-profile rounded-circle w-25' src=".URL.RS."images/imgFiles/personas/".$response[0]['foto_pers']."><center></td>" .
                        "<td class='text-center font-italic'>" . $hv_persona . "</td>" .
                        "<td>" . $value["id"] . "</td>" .
                        "<td>" . $response[0]["nomb_pers"] . " " . $response[0]["ape_pers"] . "</td>" .
                        "<td>" . $edad . "</td>" .
                        "<td class='text-center'>" .
                        "<a href='#busquedauser' onclick='dataBusquedaUser(".$dataUserB.");' data-toggle='modal' data-target='#busquedauser' class='btn btn-info rounded-pill'>Ver Detalles</a>".
                        "</td>" .
                        "</tr>";
                        $count++;
                    }
                    //echo $dataFilter;
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode( array(
                        "dataFilter" => $dataFilter,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }
        }
    }

    public function getConvoCandidatos(){
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                $count=0;
                $dataFilter = null;
                $data_Estados=null;
                $data = $this->model->getConvoCandidatos($_POST["convocatoria_lab"],$_POST["page"],$this->page);
                if(is_array($data)){
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataConvoCandidatos=json_encode($array[$count]);
                        $response=$this->model->getDatosPersona($value["id_persona"]);
                        
                        $response2=$this->model->getperfilProfesionalPersona($value["id_persona"]);
                        if($response2==null){
                            $response2=array(0);
                        }
                        $response3=$this->model->getHvPersona($value["id_persona"]);
                        if($response3==null){
                            $response3=array(0);
                        }
                        $response4=$this->model->getDataCandidato($value["id_persona"],$value["id_conv"]);
                        $dataUser=array_merge($response, $response2, $response3, $response4);
                        $dataCandidatos=json_encode($dataUser);
                        
                        if(0 == ($response3[0])){
                            $hv_persona="--";
                        }else{
                            $hv_persona="<a download href='".RS."files/hdvPersonas/".$response3[0]["hoja_de_vida"]."'><i class='fas fa-paperclip text-success font-italic text-center'></i></a>";
                        }

                        $anno_actual = date("Y");
                        $fechaComoEntero = strtotime($response[0]["fnac_pers"]);
                        $fnac=date("Y",$fechaComoEntero);
                        $edad=$anno_actual-$fnac;
                        $dataFilter .= "<tr>" .
                        "<td style='width:180px;'><center><img class='img-profile rounded-circle w-25' src=".URL.RS."images/imgFiles/personas/".$response[0]['foto_pers']."><center></td>" .
                        "<td class='text-center font-italic'>" . $hv_persona . "</td>" .
                        "<td>" . $value["id_persona"] . "</td>" .
                        "<td>" . $response[0]["nomb_pers"] . " " . $response[0]["ape_pers"] . "</td>" .
                        "<td>" . $edad . "</td>" .
                        "<td class='text-center'>" .
                        "<a href='#convocandidato' onclick='dataConvoCandidatos(".$dataCandidatos.");' data-toggle='modal' data-target='#convocandidato' class='btn btn-info rounded-pill'>Ver Detalles</a>".
                        "</td>" .
                        "</tr>";
                        $count++;
                    }

                    //echo $dataFilter;
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode( array(
                        "dataFilter" => $dataFilter,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }else{
            header("Location:".URL."user/login");
        }
    }

    public function editEstadoCandidato(){
        $user=session::getSession("user");
        if(null != $user){
            if("2" == $user["rol"]){
                $array=array(
                    $_POST["id"],
                    $_POST["id_conv"],
                    $_POST["id_persona"],
                    $_POST["estado"],
                    $_POST["created_at"]
                );
                echo $this->model->editEstadoCandidato($this->postulantesClass($array),$_POST["id_persona"], $_POST["id_conv"]);
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }else{
            header("Location:".URL."user/login");
        }
    }
}
?>