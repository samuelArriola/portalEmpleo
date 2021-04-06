<?php
class persona extends controllers{
    
    //Variables para subir sorportes
    private $archivo=null;
    private $tipo=null;
    

    function __construct()
    {
        parent::__construct();
    }

    function getIdentificaciones(){
        $data=$this->model->getIdentificaciones();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }

    function getEstadoCivil(){
        $data=$this->model->getEstadoCivil();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }

    function getTipoEstudio(){
        $data=$this->model->getTipoEstudio();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
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

    function getPerfilUpdate(){
        $data=$this->model->getPerfilUpdate();
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

    function getIdiomas(){
        $data=$this->model->getIdiomas();
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }
    }

    public function panel(){ 
         $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "index");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function hojadevida(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "hojadevida");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function datosacademicos(){ 
         $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "datosacademicos");
        }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function datosacademicoscomplementarios(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $this->view->render($this, "datosacademicoscomplementarios");
            }else{
                header("Location:".URL."user/privilegios");    
            }
        } else {
            header("Location:".URL."user/login");
        }
    }

    public function experiencialaboral(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $this->view->render($this, "experiencialaboral");
            }else{
                header("Location:".URL."user/privilegios");    
            }
        } else {
            header("Location:".URL."user/login");
        }
    }

    public function perfilaboral(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $this->view->render($this, "perfilaboral");
            }else{
                header("Location:".URL."user/privilegios");    
            }
        } else {
            header("Location:".URL."user/login");
        }
    }

    public function datospersonales(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
       $this->view->render($this, "datospersonales");
       }else{
                header("Location:".URL."user/privilegios");    
            }
            
        } else {
            header("Location:".URL."user/login");
            
        }
    }

    public function misconvocatorias(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "misconvocatorias");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function mispostulaciones(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "mispostulaciones");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function reportes(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "reportes");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function subirhdv(){ 
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"] || "1" == $user["rol"]){
        $this->view->render($this, "subirhdv");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function detalleconvocatoria(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                if(!isset($_SESSION)){ 
                    session_start(); 
                } 
                
                $codigo = $_GET['codigo'];
                $_SESSION["codigo"] = $codigo;
       $this->view->render($this, "detalleconvocatoria");
       }else{
                header("Location:".URL."user/privilegios");    
            }
            
        } else {
            header("Location:".URL."user/login");
            
        }
    }

    public function getListaEstudios(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                
                $count=0;
                $dataResults = null;
                $data = $this->model->getListaEstudios($user["id"],$_POST["filter"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataEstudio=json_encode($array[$count]);
                        
                        if($value["estado"] == "2"){
                            $estado="<td><span class='badge badge-success'>Completo</span></td>";
                        }elseif($value["estado"] == "3"){
                            $estado="<td><span class='badge badge-warning'>Incompleto</span></td>";
                        }elseif($value["estado"] == "1"){
                            $estado="<td><span class='badge badge-info'>En curso</span></td>";
                        }else{
                            $estado="<td><span class='badge badge-danger'>No definido</span></td>";
                        }

                        if($value["grado"] == '' || $value["grado"] =='0000-00-00'){
                            $value["grado"]="<span class='font-italic text-muted'>No registra</span>";
                        }
                        if($value["institucion"]==''){
                            $value["institucion"]="<span class='font-italic text-muted'>No registra</span>";
                        }
                        
                        $dataResults .= "<tr>" .
                        "<td>" . $value["titulo"] . "</td>" .
                        "<td>" . $value["institucion"]."</td>" .
                        $estado.
                        "<td>" . $value["grado"] . "</td>" .
                        "<td class='text-center'>" .
                        "<a href='#modal1' onclick='dataEstudio(".$dataEstudio.");' data-toggle='modal' data-target='#addestudios'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                        "<a href='#modal2' onclick='deleteEstudio(".$dataEstudio.");' data-toggle='modal' data-target='#deletestudio'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                        "</td>" .
                        "</tr>";
                        $count++;
                        

                    }
            //echo $dataResults;
            $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode( array(
                "dataResults" => $dataResults,
                "paginador" => $paginador
            ));
        } else {
            echo $data;
        }
            }
        }
        
    }

    
    public function registerEstudios(){
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                $nombSoporte=$id."-".str_replace(' ', '-', $_POST["titulo"]);
                if(empty($_POST["nivel_educativo"])){
                    echo "El campo nivel educativo es obligatorio.";
                }else{
                    if(empty($_POST["titulo"])){
                        echo "El campo título académico es obligatorio.";
                    }else{
                        if(empty($_POST["institucion"])){
                            echo "El campo institución es obligatorio.";
                        }else{
                            if( $_POST["estado"] == "0"){
                                echo "El campo estado es obligatorio.";
                            }else{
                                if(isset($_FILES['soporteUser'])){
                                    $this->tipo=$_FILES['soporteUser']["type"];
                                    $this->archivo=$_FILES['soporteUser']["tmp_name"];
                                }
                                $imagen=$this->image->cargar_imagen($this->tipo,$this->archivo,$nombSoporte,"soportes");
                                
                                $cod_da="";
                                $array=array(
                                    $cod_da,
                                    $id,
                                    $_POST["nivel_educativo"],
                                    $_POST["titulo"],
                                    $_POST["institucion"],
                                    $_POST["estado"],
                                    $_POST["grado"],
                                    $imagen
                                );
                                //var_dump($this->estudioClass($array));die;
                                $data = $this->model->registerEstudios($id,$this->estudioClass($array));
                            }      
                        }
                    }
                }
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function editEstudio(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                $nombSoporte=$id."-".str_replace(' ', '-', $_POST["titulo"]);
                if(empty($_POST["nivel_educativo"])){
                    echo "El campo nivel educativo es obligatorio.";
                }else{
                    if(empty($_POST["titulo"])){
                        echo "El campo título académico es obligatorio.";
                    }else{
                        if(empty($_POST["institucion"])){
                            echo "El campo institución es obligatorio.";
                        }else{
                            if( $_POST["estado"] == "0"){
                                echo "El campo estado es obligatorio.";
                            }else{
                                if(isset($_FILES['soporteUser'])){
                                    $this->tipo=$_FILES['soporteUser']["type"];
                                    $this->archivo=$_FILES['soporteUser']["tmp_name"];
                                }
                                $imagen=$this->image->cargar_imagen($this->tipo,$this->archivo,$nombSoporte,"soportes");
                                if (isset($_POST['soporteUser'])) {
                                    $archivo=$_POST['soporteUser'];
                                    //obtener imagen que esta en la db antes de actualizarla
                                    $imagen=$this->image->cargar_imagen($this->tipo,$this->archivo,$nombSoporte,"soportes");
                                    if($_POST['soporteUser'] != $_POST["soporte"].".png"){
                                        $archivo=RS."images/imgFiles/soportes/".$archivo;
                                        //eliminar la img que contiene el id anterior y que este en la variable archivo
                                        unlink($archivo);
                                        $archivo=null;
                                    }
                                }
                                $array=array(
                                    $_POST["cod_da"],
                                    $id,
                                    $_POST["nivel_educativo"],
                                    $_POST["titulo"],
                                    $_POST["institucion"],
                                    $_POST["estado"],
                                    $_POST["grado"],
                                    $imagen
                                );
                                echo $this->model->editEstudio($this->estudioClass($array),$_POST["cod_da"]);
                            } 
                        } 
                    }
                }
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function deleteEstudio(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                echo $this->model->deleteEstudio($_POST["codigo"],$_POST["soporte"]);
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function getListaExperiencias(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                
                $count=0;
                $dataResults = null;
                $data = $this->model->getListaExperiencias($user["id"],$_POST["filter"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataExperiencia=json_encode($array[$count]);

                        if($value["fecha_ini"] == '' || $value["fecha_fin"] ==''){
                            $value["fecha_ini"]="<span class='font-italic text-muted'>No registra</span>";
                            $value["fecha_fin"]="<span class='font-italic text-muted'>No registra</span>";
                        }
                        
                        $dataResults .= "<tr>" .
                        "<td>" . $value["nomb_empresa"] . "</td>" .
                        "<td>" . $value["cargo"]."</td>" .
                        "<td>" . $value["fecha_ini"] . "</td>" .
                        "<td>" . $value["fecha_fin"] . "</td>" .
                        "<td class='text-center'>" .
                        "<a href='#modal1' onclick='dataExperiencia(".$dataExperiencia.");' data-toggle='modal' data-target='#addexperiencias'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                        "<a href='#modal2' onclick='deleteExperiencia(".$dataExperiencia.");' data-toggle='modal' data-target='#deletexperiencia'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                        "</td>" .
                        "</tr>";
                        $count++;
                        

                    }
            //echo $dataResults;
            $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode( array(
                "dataResults" => $dataResults,
                "paginador" => $paginador
            ));
        } else {
            echo $data;
        }
            }
        }
        
    }

    public function registerExperiencias(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                if(empty($_POST["nomb_empresa"])){
                    echo "El campo nombre de la empresa es obligatorio.";
                }else{
                    if(empty($_POST["cargo"])){
                        echo "El campo cargo es obligatorio.";
                    }else{
                        if(empty($_POST["funciones"])){
                            echo "El campo funciones es obligatorio.";
                        }else{
                                    $cod_ep="";
                                    $array=array(
                                        $cod_ep,
                                        $id,
                                        $_POST["nomb_empresa"],
                                        $_POST["cargo"],
                                        $_POST["funciones"],
                                        $_POST["fecha_ini"],
                                        $_POST["fecha_fin"]
                                    );
                                    //var_dump($this->experienciaClass($array));
                                    $data = $this->model->registerExperiencias($id,$this->experienciaClass($array));
                             
                        } 
                    }
                }
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function editExperiencia(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                if(empty($_POST["nomb_empresa"])){
                    echo "El campo nombre de la empresa es obligatorio.";
                }else{
                    if(empty($_POST["cargo"])){
                        echo "El campo cargo es obligatorio.";
                    }else{
                        if(empty($_POST["funciones"])){
                            echo "El campo funciones es obligatorio.";
                        }else{
                            $array=array(
                                $_POST["codigo"],
                                $id,
                                $_POST["nomb_empresa"],
                                $_POST["cargo"],
                                $_POST["funciones"],
                                $_POST["fecha_ini"],
                                $_POST["fecha_fin"]
                            );
                            
                            echo $this->model->editExperiencia($this->experienciaClass($array),$_POST["codigo"]);

                        }
                    }
                }
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function deleteExperiencia(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                echo $this->model->deleteExperiencia($_POST["codigo"]);
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function getListaPerfiles(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $count=0;
                $dataResults = null;
                $data = $this->model->getListaPerfiles($user["id"],$_POST["filter"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataPerfil=json_encode($array[$count]);
                        if($value["estado"] == "1"){
                            $checked="checked";
                        }else{
                            $checked="";
                        }
                        $dataResults .= "<tr>" .
                        "<td class='text-center'>
                                <div class='form-check'>
                                    <input data-toggle='modal' data-target='#ModaleditEstadoPerfil' onclick='dataPerfil(".$dataPerfil.");' class='form-check-input' type='radio' name='estado' id='estado' value=".$value["estado"]." $checked/>
                                </div>
                            </td>" .
                        "<td>" . $value["titulo"] . "</td>" .
                        "<td>" . $value["descripcion"] ."</td>" .
                        "<td class='text-center'>" .
                        "<a href='#modal1' onclick='dataPerfil(".$dataPerfil.");' data-toggle='modal' data-target='#addperfiles'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                        "<a href='#modal2' onclick='deletePerfil(".$dataPerfil.");' data-toggle='modal' data-target='#deleteperfil'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                        "</td>" .
                        "</tr>";
                        $count++;
                    }
                    
                    //echo $dataResults;
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode( array(
                        "dataResults" => $dataResults,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }
        }
    }

    public function registerPerfiles(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                if(empty($_POST["titulo"])){
                    echo "El campo título es obligatorio.";
                }else{
                    if(empty($_POST["id_categoria"])){
                        echo "El campo categoría es obligatorio.";
                    }else{
                        if(empty($_POST["id_perfil"])){
                            echo "El campo perfil es obligatorio.";
                        }else{
                            if(empty($_POST["descripcion"])){
                                echo "El campo descripción del cargo es obligatorio.";
                            }else{
                                   
                                    $cod_dp="";
                                    $array=array(
                                        $cod_dp,
                                        $id,
                                        $_POST["titulo"],
                                        $_POST["id_categoria"],
                                        $_POST["id_perfil"],
                                        $_POST["descripcion"]
                                    );
                                    //var_dump($this->estudioClass($array));
                                    $data = $this->model->registerPerfiles($id,$this->perfilaboralClass($array));
                            } 
                        } 
                    }
                }
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function editPerfil(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                if(empty($_POST["titulo"])){
                    echo "El campo título es obligatorio.";
                }else{
                    if(empty($_POST["id_categoria"])){
                        echo "El campo categoría es obligatorio.";
                    }else{
                        if(empty($_POST["id_perfil"])){
                            echo "El campo perfil es obligatorio.";
                        }else{
                            if(empty($_POST["descripcion"])){
                                echo "El campo descripción del cargo es obligatorio.";
                            }else{
                                   
                                    $array=array(
                                        $_POST["codigo"],
                                        $id,
                                        $_POST["titulo"],
                                        $_POST["id_categoria"],
                                        $_POST["id_perfil"],
                                        $_POST["descripcion"]
                                    );

                                    echo $this->model->editPerfil($this->perfilaboralClass($array),$_POST["codigo"]);
                            } 
                        } 
                    }
                }
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function deletePerfil(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                echo $this->model->deletePerfil($_POST["codigo"]);
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function actDatosPersonales() {
        $user=session::getSession("user");
        $id=$user["id"];
        $data=$this->model->actDatosPersonales($id);
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }

    }

    public function saveDatosPersonales(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                if($_POST["codi_iden"] == "0"){
                    echo "El campo tipo identificación es obligatorio.";
                }else{
                    if(empty($_POST["id"])){
                        echo "El campo n° identificación es obligatorio.";
                    }else{
                        if(empty($_POST["nomb_pers"])){
                            echo "El campo nombre es obligatorio.";
                        }else{
                            if(empty($_POST["ape_pers"])){
                                echo "El campo apellidos es obligatorio.";
                            }else{
                                if(empty($_POST["sexo"])){
                                    echo "El campo género es obligatorio.";
                                }else{
                                    if(empty($_POST["fnac_pers"])){
                                        echo "El campo fecha de nacimiento es obligatorio.";
                                    }else{
                                        if($_POST["codi_iden"] == "0"){
                                            echo "El campo estado civil es obligatorio.";
                                        }else{
                                            if(empty($_POST["telefono1"])){
                                                echo "El campo teléfono es obligatorio.";
                                            }else{
                                                if(empty($_POST["direccion"])){
                                                    echo "El campo dirección es obligatorio.";
                                                }else{
                                                    $archivo =null;
                                                    $tipo=null;
                                                    $imagen=null;
                                                    //Verificar si se cargo una imagen
                                                    if (isset($_FILES['foto_pers'])) {
                                                        $tipo=$_FILES['foto_pers']["type"];
                                                        $archivo=$_FILES['foto_pers']["tmp_name"];
                                                        $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"personas");
                                                    } else {
                                                        if (isset($_POST['foto_pers'])) {
                                                            $archivo=$_POST['foto_pers'];
                                                            //obtener imagen que esta en la db antes de actualizarla
                                                            $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"personas");
                                                            if($_POST['foto_pers'] != $_POST['id'].".png"){
                                                                $archivo=RS."images/imgFiles/personas/".$archivo;
                                                                //eliminar la img que contiene el id anterior y que este en la variable archivo
                                                                unlink($archivo);
                                                                $archivo=null;
                                                            }
                                                        }   
                                                    }
                                                    $array=array(
                                                        $_POST["codi_iden"],
                                                        $_POST["id"],
                                                        $_POST["nomb_pers"],
                                                        $_POST["ape_pers"],
                                                        $_POST["sexo"],
                                                        $_POST["fnac_pers"],
                                                        $_POST["esta_pers"],
                                                        $_POST["telefono1"],
                                                        $_POST["telefono2"],
                                                        $_POST["emai_pers"],
                                                        $_POST["direccion"],
                                                        $imagen,
                                                    );
                                                    echo $this->model->saveDatosPersonales($this->datospersonaClass($array),$_POST["id"],$_POST["emai_pers"]);
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
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function DatosAPlus() {
        $user=session::getSession("user");
        $id=$user["id"];
        $data=$this->model->DatosAPlus($id);
        if(is_array($data)){
            echo json_encode($data);
        }else{
            echo $data;
        }

    }

    public function saveDatosAPlus(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                
                    $array=array(
                        $id,
                        $_POST["cursos"],
                        $_POST["id_idioma"],
                        $_POST["n_idioma"],
                    );
                    echo $this->model->saveDatosAPlus($this->academicoplusClass($array),$id); 
                
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    function getTecnologias(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                $count=0;
                $dataFilter = null;
                $data=$this->model->getTecnologias();
                if(is_array($data)){
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataTecn=json_encode($array[$count]);
                        $response=$this->model->getTecnologiaUser($id);
                        $checked="";
                        foreach ($response as $key2 => $value2) {
                            if($value2["id_prog"] == $value["id"]){
                                $checked ="checked";
                            }
                        }
                        $dataFilter .= "<div class='form-check col-6'>".
                        "<input class='form-check-input' type='checkbox' value='".$value["id"]."' id='".$value["id"]."' name='id_prog[]' $checked>".
                        "<label class='form-check-label' for='tecnologias'>".$value["desc"].
                        "</label>".
                        "</div> ";
                        $count++;
                    }
                    echo $dataFilter;
                }else{
                    echo $data;
                }
            }
        }
    }

    public function registerTecnologias(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                $cod="";
                
                if(isset($_POST['id_prog'])){
                    $contador = 0;
                    $limite = count($_POST['id_prog']);
                    
                        $programas=$_POST['id_prog'];
                        foreach($programas as $check){
                            $array=array(
                                $cod,
                                $id,
                                $check
                            );

                            $data = $this->model->registerTecnologias($id,$this->tecnologiasClass($array));
                            
                           //var_dump($array); 
                        }
                        $contador++;
                   
             }else{
                 echo "No se ha seleccionado ninguna aplicación tecnológica.";
             }
               
            }
        }
    }

    public function dataPostulante(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id=$user["id"];
                $data=$this->model->dataPostulante($id);
                if(is_array($data)){
                    echo json_encode($data);
                }else{
                    echo $data;
                }
            }
        }
    }

    public function getListadoConvocatoria(){
        setlocale(LC_TIME, 'spanish.utf-8');
         $count=0;
         $dataFilter = null;
         $data = $this->model->getListadoConvocatoria($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data["results"];
            foreach ($array as $key => $value) {
                $dataConvo=json_encode($array[$count]);

                $fecha = strftime("%A, %d de %B del %Y", strtotime($value["created_at"]));
                $cierre=strftime("%A, %d de %B del %Y", strtotime($value["fecha_fin"]));
                $response=$this->model->getContrato($value["t_contrato"]);
                $contrato=$response[0]["contrato"];

                $response2=$this->model->getEmpresa($value["id_empresa"]);
                $empresa=$response2[0]["empresa"];

                $codigo=$value["id"];

                $dataFilter .= "<div class='col-md-6'>".
                "<div class='card border mb-3 shadow-sm bg-white rounded' style='border: 1px solid #336699!important;'>" .
                "<div class='card-header text-justify text-white text-uppercase' style='background: #86BBD8;border: #336699;'><b>". $value["nomb_cargo"] . "</b></div>" .
                "<div class='card-body text-justify' style='border-top: 1px solid #336699!important;border-bottom: 1px solid #336699!important;'>".
                    "<h6 class='card-title'>Perfil del Aspirante: " . $value["perfil"]. "</h6>" .
                    "<div class='row'>".
                        "<div class='col-md-6'><small class='form-text text-muted'>Empresa: <br>".$empresa."</small></div>".
                        "<div class='col-md-6'><small class='form-text text-muted' style='margin: 0 !important;'>Tipo de Contrato: <br>".$contrato."</small></div>".
                        "<div class='col-md-12 mt-3'><small class='form-text text-info text-capitalize font-italic' style='margin: 0 !important;'><i class='fas fa-info-circle'></i> Cierre Oferta: ".$cierre."</small></div>".
                        "</div>".
                    "</div>".
                "<div class='card-footer text-white' style='background: #86BBD8;border: #336699;'>".
                    "<small class='form-text text-white float-left text-capitalize font-italic'>".$fecha."</small>".
                    "<div align='right'>".
                        "<a href='detalleconvocatoria?codigo=$codigo' onclick='dataConvo(".$dataConvo.");' class='btn btn-info rounded-pill'>Ver Detalles</a>".
                        "</div>".
                    "</div>".
                    "</div>".
                "</div>";
                $count++;
            }
            //echo $dataFilter;
            $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
            echo json_encode( array(
                "dataFilter" => $dataFilter,
                "paginador" => $paginador
            ));
        } 
        
        
    }

    public function getDetalleConvocatoria(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $codigo=$_SESSION["codigo"];
                $data=$this->model->getDetalleConvocatoria($codigo);
                
                $response=$this->model->getContrato($data["t_contrato"]);

                $response2=$this->model->getEmpresa($data["id_empresa"]);
                
                $response3=$this->model->getCategoriaLaboral($data["categoria"]);
                
                $response=$response+$response2[0]+$response3[0];
                $data=$data+$response;
                
                if(is_array($data)){
                    echo json_encode($data);
                }else{
                    echo $data;
                }
            }
        }
    }

    public function getListaConvoSilimares(){
        //5 últimas ofertas similares
         $count=0;
         $codigo=$_SESSION["codigo"];
         $dataFilter=null;
         $data = $this->model->getListaConvoSilimares($codigo);
        if (is_array($data)) {
            $array = $data["results"];
            
            foreach ($array as $key => $value) {
                $dataConvo=json_encode($array[$count]);
                $codigo=$value["id"];
                $dataFilter .= "<a href='detalleconvocatoria?codigo=$codigo' class='text-decoration-none'><i class='fas fa-bullhorn'></i> ".$value["perfil"]."</a><br>";
                $count++;
            }
            echo json_encode(array("dataFilter" => $dataFilter));
        } 
        
        
    }

    public function registerPostulantes(){
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id='';
                $id_conv=$_SESSION["codigo"];
                $id_persona=$user["id"];
                $estado='0';
                $created_at=date('Y-m-d H:i:s');
                $array=array(
                    $id,
                    $id_conv,
                    $id_persona,
                    $estado,
                    $created_at
                );
                $data = $this->model->registerPostulantes($id_conv,$id_persona,$this->postulantesClass($array));
                if ($data == 1) {
                    echo "Usted ya ha aplicado a esta convocatoria laboral, no puede aplicar dos veces a la misma convocatoria.";
                } else {
                    echo $data;
                }
            }else{
                header("Location:".URL."user/privilegios");    
            }
        }else{
            header("Location:".URL."user/login");
        }
    }

    public function getListaPostulaciones(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $count=0;
                $dataResults = null;
                $data = $this->model->getListaPostulaciones($user["id"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataPerfil=json_encode($array[$count]);

                        $response=$this->model->getDetalleConvocatoria($value["id_conv"]);
                        
                        $response2=$this->model->getEmpresa($response["id_empresa"]);

                        $codigo=$value["id_conv"];

                        if($value["estado"]==0){
                            $estado="<span class='text-dark'><i class='fas fa-user-clock'></i> En espera</span>";
                        }elseif($value["estado"]==1){
                            $estado="<span class='text-info'><i class='fas fa-user-alt-slash'></i> Visto</span>";
                        }elseif($value["estado"]==2){
                            $estado="<span class='text-success'><i class='fas fa-user-check'></i> Finalista</span>";
                        }else{
                            $estado="<span class='text-danger'><i class='fas fa-user-times'></i> Rechazado</span>";
                        }
                        $dataResults .= "<div class='col-md-4'>".
                        "<div class='card border mb-3 shadow-sm p-3'>" .
                        "<a href='detalleconvocatoria?codigo=$codigo' class='text-decoration-none text-dark'><h6 class='card-title'>".$response["perfil"]."</h6><a>".
                        "<p class='card-subtitle text-muted'>".$response2[0]["empresa"]."</p>".
                        "<div class='card-body'>".
                        "<small class='float-right'>".$estado."</small>".
                         "</div>" .
                        "</div>".
                        "</div>";
                        $count++;
                    }

                    //echo $dataResults;
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode( array(
                        "dataResults" => $dataResults,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }
        }
    }

    public function RegisterHdv(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $id_persona=$user["id"];
                $estado="0";
                $cod_hdv="";
                if(isset($_FILES['hoja_de_vida'])){
                    $ext = pathinfo($_FILES['hoja_de_vida']["name"], PATHINFO_EXTENSION);
                    if($ext == "doc" || $ext == "docx" || $ext == "pdf"){
                        if($_FILES['hoja_de_vida']["size"]<=2000000 && $_FILES['hoja_de_vida']["size"]>0){
                            $this->tipo=$_FILES['hoja_de_vida']["type"];
                            $this->archivo=$_FILES['hoja_de_vida']["tmp_name"];
                            $nombFile=$_FILES['hoja_de_vida']["name"];
                            $file=$this->file->cargar_file($this->tipo,$this->archivo,$nombFile);
                            $array=array(
                                $cod_hdv,
                                $id_persona,
                                $file,
                                $estado
                            );
                            //var_dump($this->hdvClass($array));die;
                            $data = $this->model->RegisterHdv($this->hdvClass($array));
                        }else{
                            echo "El archivo que intenta subir al sistema, excede el tamaño.";
                        }
                    }else{
                        echo "No se ha podido subir su hoja de vida correctamente. Formatos permitidos .DOC, .DOCX o .PDF.";
                    }
                }else{
                    echo "No ha subido ningún archivo valido.";
                }
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function getListaHdv(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $count=0;
                $dataResults = null;
                $data = $this->model->getListaHdv($user["id"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataHdv=json_encode($array[$count]);
                        $response=$this->model->estadoHdv($value["id_persona"]);

                        if($value["estado"] == "1"){
                            $checked="checked";
                        }else{
                            $checked="";
                        }

                        if(empty($response)){
                            $checkedDefault="checked";
                        }else{
                            $checkedDefault="";
                        }

                        $dataResults .= 
                        "<tr>" .
                            "<td class='text-center'>
                                <div class='form-check'>
                                    <input data-toggle='modal' data-target='#ModaleditEstadoHdv' onclick='dataHdv(".$dataHdv.");' class='form-check-input' type='radio' name='estado' id='estado' value=".$value["estado"]." $checked/>
                                </div>
                            </td>" .
                            "<td><a download href='".RS."files/hdvPersonas/".$value["hoja_de_vida"]."'>" . $value["hoja_de_vida"]."</a></td>" .
                            "<td class='text-center'>" .
                                "<a href='#modal2' onclick='deleteHdv(".$dataHdv.");' data-toggle='modal' data-target='#deletehdv'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                            "</td>" .
                        "</tr>";
                        $count++;
                    }
                    $dataFijo="
                    <tr>
                        <td class='text-center'>
                            <div class='form-check'>
                                <input onclick='editEstadoDefaultHdv();' class='form-check-input' type='radio' name='estadoDefault' id='estadoDefault' value='0' $checkedDefault>
                            </div>
                        </td>
                        <td colspan='2' class='font-italic'>No adjuntar Hoja de Vida en Word/PDF a mis postulaciones laborales.</td>
                    </tr>";
                    //echo $dataResults;
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode(array(
                        "dataResults" => $dataFijo.$dataResults,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function editEstadoHdv(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){    
                $id_persona=$user["id"];
                $estado="1";
                $cod_hdv=$_POST["cod_hdv"];
                $file=$_POST["hoja_de_vida"];

                $array=array(
                    $cod_hdv,
                    $id_persona,
                    $file,
                    $estado
                );
                echo $this->model->editEstadoHdv($this->hdvClass($array),$_POST["cod_hdv"],$id_persona);
            
                
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function editEstadoDefaultHdv(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){    
                $id_persona=$user["id"];
                echo $this->model->editEstadoDefaultHdv($id_persona);
            }else{
                echo "No tiene privilegios para ejecutar esta acción."; 
            }
        }
    }

    public function deleteHdv(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                echo $this->model->deleteHdv($_POST["codigo"],$_POST["file"]);
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
        }
    }

    public function getDatosReporte(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $count=0;
                $dataResults = null;
                $data = $this->model->getDatosReporte($user["id"],$_POST["filter"],$_POST["page"],$this->page);
                //var_dump($data);die;
                if (is_array($data)) {
                    $array = $data["results"];
                    foreach ($array as $key => $value) {
                        $dataReporte=json_encode($array[$count]);

                        $response=$this->model->getDetalleConvocatoria($value["id_conv"]);

                        $codigo=$value["id_conv"];

                        if($value["estado"]==0){
                            $estado="<span class='text-dark'><i class='fas fa-user-clock'></i> En espera</span>";
                        }elseif($value["estado"]==1){
                            $estado="<span class='text-info'><i class='fas fa-user-alt-slash'></i> Visto</span>";
                        }elseif($value["estado"]==2){
                            $estado="<span class='text-success'><i class='fas fa-user-check'></i> Finalista</span>";
                        }else{
                            $estado="<span class='text-danger'><i class='fas fa-user-times'></i> Rechazado</span>";
                        }

                        $dataResults .= "<tr>" .
                        "<td>" . $response["perfil"] . "</td>" .
                        "<td>" . $value["created_at"]."</td>" .
                        "<td>" .$estado."</td>" .
                        "</tr>";
                        $count++;
                        
                    }
                    //echo $dataResults;
                    
                    $paginador ="<p class='pl-2 pr-2'>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p>";
                    echo json_encode( array(
                        "dataResults" => $dataResults,
                        "paginador" => $paginador
                    ));
                } else {
                    echo $data;
                }
            }
        }
    }
    
}

?>

