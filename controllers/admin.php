<?php
class admin extends controllers{
    
    public function __construct(){
        parent::__construct();
        //$this->getIdentificaciones();
        //$this->getUsers();
    }

    public function options(){
        $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"]){
                 $this->view->render($this, "index");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
        
    }

    public function panel(){
         $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"]){
            $this->view->render($this, "panel");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function user(){
         $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"]){
            $this->view->render($this, "user");
        }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function getIdentificaciones(){
        $data = $this->model->getIdentificaciones();
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
    }

    public function getCategorias(){
        $data = $this->model->getCategorias();
        if (is_array($data)) {
            echo json_encode($data);
        } else {
            echo $data;
        }
    }

    public function getUsers(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"]){
                $count=0;
        $dataFilter = null;
        $data = $this->model->getUsers($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data["results"];
            foreach ($array as $key => $value) {
                $dataUser=json_encode($array[$count]);
                if ($value["id_cat"] == 1) {
                    $value["id_cat"] = "<span class='badge badge-success'>Categoría A</span>";
                } else if ($value["id_cat"] == 2) {
                    $value["id_cat"] = "<span class='badge badge-info'>Categoría B</span>";
                } else {
                    $value["id_cat"] = "<span class='badge badge-warning'>Categoría C</span>";
                }
                $dataFilter .= "<tr>" .
                    "<td>" . $value["id"] . "</td>" .
                    "<td>" . $value["nomb_pers"] . " " . $value["ape_pers"] . "</td>" .
                    "<td>" . $value["direccion"] . "</td>" .
                    "<td>" . $value["id_cat"] . "</td>" .
                    "<td class='text-center'>" .
                    "<a href='#modal1' onclick='dataUser(".$dataUser.");' data-toggle='modal' data-target='#adduser'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                    "<a href='#deleteUser' onclick='deleteUser(".$dataUser.");' data-toggle='modal' data-target='#deleteUser'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
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

    public function postRegistro(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"]){
                if(empty($_POST["nomb_pers"])){
                    echo "El campo nombre es obligatorio.";
                }else{
                    if(empty($_POST["ape_pers"])){
                        echo "El campo apellido es obligatorio.";
                    }else{
                        if(empty($_POST["id"])){
                            echo "El campo tipo de identificación es obligatorio.";
                        }else{
                            if(strcmp("Seleccione un tipo de identificación", $_POST["identificacion"]) === 0){
                                echo "Seleccione un tipo de identificación";
                            }else{
                                if(empty($_POST["id"])){
                                    echo "El campo n° de identificación es obligatorio.";
                                }else{
                                    if(empty($_POST["direccion"])){
                                        echo "El campo dirección es obligatorio.";
                                    }else{
                                        if(strcmp("Seleccione una categoría", $_POST["categoria"]) === 0){
                                            echo "Seleccione una categoría";
                                        }else{
                                            if(6 <= strlen($_POST["password"])){
                                                if(strcmp("Seleccione un tipo de identificación", $_POST["identificacion"]) === 0){
                                                    echo "Seleccione un tipo de identificación";
                                                }else{
                                                    $archivo=null;
                                                    $tipo=null;
                                                    if (isset($_FILES['foto_pers'])) {
                                                        $tipo = $_FILES['foto_pers']["type"];
                                                        $archivo = $_FILES['foto_pers']["tmp_name"]; 
                                                    } 
                                                    $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"personas");
                                                    //De aquí sale el orden en que serán llamados en la
                                                    //clase anonima
                                                    $array = array(
                                                        $_POST["id"],
                                                        password_hash($_POST["password"], PASSWORD_DEFAULT),
                                                        $_POST["nomb_pers"],
                                                        $_POST["ape_pers"],
                                                        $_POST["identificacion"],
                                                        $_POST["categoria"],
                                                        $_POST["direccion"],
                                                        $imagen,
                                                        );
                                                        //echo $imagen;
                                                        $data = $this->model->registroUser($this->userClass($array), $this->personaClass($array));
                                                        if ($data == 1) {
                                                            echo "El usuario ya esta registrado en el sistema.";
                                                        } else {
                                                            echo $data;
                                                        }
                                                    
                                                }
                                                
                                            }else{
                                                echo"Digite una contraseña de 6 digitos o más";
                                                
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

    public function getEmpresas(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"]){
                 $count=0;
        $dataFilter = null;
        $data = $this->model->getEmpresas($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data["results"];
            foreach ($array as $key => $value) {
                $dataEmpresa=json_encode($array[$count]);
                $dataFilter .= "<tr>" .
                    "<td>" . $value["id"] . "</td>" .
                    "<td>" . $value["nomb_emp"]."</td>" .
                    "<td>" . $value["direccion"] . "</td>" .
                    "<td class='text-center'>" .
                    "<a href='#modal1' onclick='dataEmpresa(".$dataEmpresa.");' data-toggle='modal' data-target='#addempresa'><i class='fas fa-sync pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-info'></i></a>" . " | " .
                    "<a href='#'><i class='fas fa-trash-alt pt-2 pb-2 pl-2 pr-2 text-white rounded-circle bg-danger'></i></a>" .
                    "</td>" .
                    "</tr>";
                $count++;
            }
            //echo $dataFilter;
            $paginador ="<p>Resultados " .$data["pagi_info"]."</p><p>".$data["pagi_navegacion"]."</p> ";
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

    public function postRegistroEmpresa(){
        $archivo=null;
        $tipo=null;
        if (isset($_FILES['logo'])) {
            $tipo = $_FILES['logo']["type"];
            $archivo = $_FILES['logo']["tmp_name"]; 
        } 
        $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"empresas");

        $array = array(
            $_POST["id"],
            $_POST["password"],
            $_POST["nomb_emp"],
            $_POST["razon_s"],
            $_POST["direccion"],
            $imagen,
            $_POST["telefono_emp"],
        );
        $data = $this->model->registroEmpresa($this->userClass($array), $this->empresaClass($array));
        if ($data == 1) {
            echo "La empresa ya esta registrada en el sistema.";
        } else {
            echo $data;
        }
    }

    public function empresa(){
          $user=session::getSession("user");
         if (null != $user) {
             if("3" == $user["rol"]){
             $this->view->render($this, "empresa");
             }else{
                 header("Location:".URL."user/privilegios");    
             }
             
         } else {
             header("Location:".URL."user/login");
             
         }
    }

    public function editUser(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"]){
                if(empty($_POST["nomb_pers"])){
                    echo "El campo nombre es obligatorio.";
                }else{
                    if(empty($_POST["ape_pers"])){
                        echo "El campo apellido es obligatorio.";
                    }else{
                        if(empty($_POST["id"])){
                            echo "El campo tipo de identificación es obligatorio.";
                        }else{
                            if(strcmp("Seleccione un tipo de identificación", $_POST["identificacion"]) === 0){
                                echo "Seleccione un tipo de identificación";
                            }else{
                                if(empty($_POST["id"])){
                                    echo "El campo n° de identificación es obligatorio.";
                                }else{
                                    if(empty($_POST["direccion"])){
                                        echo "El campo dirección es obligatorio.";
                                    }else{
                                        if(strcmp("Seleccione una categoría", $_POST["categoria"]) === 0){
                                            echo "Seleccione una categoría";
                                        }else{
                                            if(6 <= strlen($_POST["password"])){
                                                if(strcmp("Seleccione un tipo de identificación", $_POST["identificacion"]) === 0){
                                                    echo "Seleccione un tipo de identificación";
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
                                                            if($_POST['foto_pers'] != $_POST['id_user'].".png"){
                                                                $archivo=RS."images/imgFiles/personas/".$archivo;
                                                                //eliminar la img que contiene el id anterior y que este en la variable archivo
                                                                unlink($archivo);
                                                                $archivo=null;
                                                            }
                                                        }   
                                                    }
                                                    
                                                    $response=$this->model->getUser($_POST["id_user"]);
                                                    if(is_array($response)){
                                                        $array=array(
                                                            $_POST["id"],
                                                            $response[0]['password'],
                                                            $_POST["nomb_pers"],
                                                            $_POST["ape_pers"],
                                                            $_POST["identificacion"],
                                                            $_POST["categoria"],
                                                            $_POST["direccion"],
                                                            $imagen,
                                                        );
                                                         echo $this->model->editUser($this->userClass($array), $this->personaClass($array), $_POST["id_user"]);
                                                    }else{
                                                        echo $response;
                                                    } 
                                                }
                                                
                                            }else{
                                                echo"Digite una contraseña de 6 digitos o más";
                                                
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
        
    public function deleteUser(){
        echo $this->model->deleteUser($_POST["id_user"]);
    }
    
    public function editEmpresa(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"]){
                if(empty($_POST["id"])){
                    echo "El campo Nit es obligatorio.";
                }else{
                    if(empty($_POST["nomb_emp"])){
                        echo "El campo nombre de la empresa es obligatorio.";
                    }else{
                        if(empty($_POST["razon_s"])){
                            echo "El campo razón social es obligatorio.";
                            }else{
                                if(empty($_POST["direccion"])){
                                    echo "El dirección es obligatorio.";
                                }else{
                                    if(empty($_POST["telefono_emp"])){
                                        echo "El campo teléfono es obligatorio.";
                                    }else{
                                            if(6 <= strlen($_POST["password"])){
                                                if(strcmp("Seleccione un tipo de identificación", $_POST["identificacion"]) === 0){
                                                    echo "Seleccione un tipo de identificación";
                                                }else{
                                                    $archivo =null;
                                                    $tipo=null;
                                                    $imagen=null;
                                                    //Verificar si se cargo una imagen
                                                    if (isset($_FILES['logo'])) {
                                                        $tipo=$_FILES['logo']["type"];
                                                        $archivo=$_FILES['logo']["tmp_name"];
                                                        $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"empresas");
                                                    } else {
                                                        if (isset($_POST['logo'])) {
                                                            $archivo=$_POST['logo'];
                                                            //obtener imagen que esta en la db antes de actualizarla
                                                            $imagen = $this->image->cargar_imagen($tipo, $archivo, $_POST["id"],"empresas");
                                                            if($_POST['logo'] != $_POST['id_user'].".png"){
                                                                $archivo=RS."images/imgFiles/empresas/".$archivo;
                                                                //eliminar la img que contiene el id anterior y que este en la variable archivo
                                                                unlink($archivo);
                                                                $archivo=null;
                                                            }
                                                        }   
                                                    }
                                                    
                                                    $response=$this->model->getUser($_POST["id_user"]);
                                                    if(is_array($response)){
                                                        $array=array(
                                                            $_POST["id"],
                                                        $response[0]['password'],
                                                            $_POST["nomb_emp"],
                                                            $_POST["razon_s"],
                                                            $_POST["direccion"],
                                                            $imagen,
                                                        $_POST["telefono_emp"],
                                                        );
                                                         echo $this->model->editEmpresa($this->userClass($array), $this->empresaClass($array), $_POST["id_user"]);
                                                    }else{
                                                        echo $response;
                                                    } 
                                                }
                                                
                                            }else{
                                                echo"Digite una contraseña de 6 digitos o más";
                                                
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
