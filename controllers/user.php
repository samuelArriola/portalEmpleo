<?php 
class user extends controllers{
     public function __construct(){
         //invocar metodo constructor de la clase padre
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

    public function login(){
       $this->view->render($this,"login");    
    }

    public function passwordreset(){
        $this->view->render($this,"passwordreset");
    }

    public function passresetsave(){
        if(!isset($_SESSION)){ 
            session_start(); 
        } 
        
        $id = base64_decode($_GET['code']);
        $_SESSION["code"] = $id;

        $this->view->render($this,"passwordresetsave");
        
    }
    
    public function privilegios(){
       $this->view->render($this,"privilegios");    
    }

    public function postpasswordreset(){
        $email= null;
        $nombre=null;
        $asunto="Recuperación de Contraseña";
        $mensaje=null;
        $estado="0";
        $created_at = date('Y-m-d H:i:s');
        $updated_at=null;
        
        
        //Array para realizar insert en la tabla resetpassword
        $array = array(
            $_POST["id"],
            $estado,
            $created_at,
            $updated_at
        );
        
        $data=$this->model->passwordreset($_POST["id"],$this->resetClass($array));
        if($data==1){
            echo 1;
            exit();
        }else{
            if($data==2){
                echo 2;
                exit();
            }else{
                if($data==3){
                    echo 3;
                    exit();
                }else{
                    $data_email = json_decode($data, true);
                    if(is_array($data_email)){
                        $code = base64_encode($data_email["id"]);
                        $mensaje="<div style='border: 1px solid #336699!important;padding: 40px;border-radius: 5px;margin: 50px;text-align: justify;'><br><strong style='color:#336699;'>Cuenta ZIMEP</strong><br><p style='color: #117a8b;font-size: 30px;'>Cambio de contraseña</p>Hemos recibido una solicitud para restablecer la contraseña de su cuenta.
                        Si usted " . $data_email["nombre"]." ha solicitado un restablecimiento de su cuenta en nuestra plataforma ZIMEP, haga clic en el enlace de abajo.<br><br> Ingresa <a href='http://localhost/portal_empleo/user/passresetsave?code=" . $code ."'>aquí</a>, y digite la nueva contraseña.<br>
                        <br><strong style='font-style: italic;'>Este enlace caducará en 24 horas.</strong><br><br>
                        Si no lo has solicitado, ignora este correo electrónico.<br><br> Gracias,<br>El equipo de cuentas ZIMEP.</div>";
                        $datosemail=$this->email->envio_mail($data_email["emai_pers"],$data_email["nombre"],"Recuperación de Contraseña",$mensaje);
                        
                    }
                }
            }
        }
        
    }

    public function postSavepass(){
        $estado="1";
        $updated_at = date('Y-m-d H:i:s');
        $id=$_SESSION["code"];
        $response=$this->model->getUser($id);
        $created_at=$response[0]["created_at"];
        $updated_at = date('Y-m-d H:i:s');
        if(is_array($response)){
            $array = array(
                $id,
                $estado,
                $created_at,
                $updated_at,
                password_hash($_POST["password"], PASSWORD_DEFAULT)
            );
            echo $this->model->savePassreset($this->useresetClass($array),$this->resetClass($array),$id);
        }else{
            echo $response;
        }
    }
    
    public function postLogin(){
        if(!empty($_POST["id"])){
            if (!empty($_POST["password"])) {
               if (strlen($_POST["password"] <=16 )) {
                   //echo password_hash($_POST["password"], PASSWORD_DEFAULT);
                   $data=$this->model->postLogin($_POST["id"],$_POST["password"]);
                //verificar si data es un array
                if(is_array($data)){
                 //convertir $data en json   
                 echo json_encode($data);
                }else{
                    //imprime dato almacenado
                    echo $data;
                }

               } else {
                   echo 2;
               }
               
            } else {
                echo 1;
            }
        }else{
            echo 3;
        }

    }

    public function registro(){
        $this->view->render($this,"registro");
    }

    public function registroempresa(){
        $this->view->render($this,"registroempresa");
    }

    public function postRegistro(){
        $created_at=date('Y-m-d H:i:s');
        $archivo=null;
        $tipo=null;
        $rol="1";
        if (isset($_FILES['foto_pers'])) {
            $tipo=$_FILES['foto_pers']["type"];
            $archivo= $_FILES['foto_pers']["tmp_name"];
        }
        $imagen=$this->image->cargar_imagen($tipo,$archivo,$_POST["id"],"personas");
        
        //De aquí sale el orden en que serán llamados en la
        //clase anonima
        $array = array(
            $_POST["id"],
            password_hash($_POST["password"], PASSWORD_DEFAULT),
            $created_at,
            $_POST["nomb_pers"],
            $_POST["ape_pers"],
            $_POST["identificacion"],
            $_POST["direccion"],
            $imagen,
            $rol
        );

        //echo $imagen;
        $data= $this->model->registroUser($this->userClass($array),$this->personauClass($array),$this->userrolClass($array));
        if ($data == 1) {
            echo "El usuario ya esta registrado en el sistema.";
        } else {
            echo $data;
        }
        
    }

    public function postRegistroEmpresa(){
        $created_at=date('Y-m-d H:i:s');
        $archivo=null;
        $tipo=null;
        $rol="2";
        if (isset($_FILES['logo'])) {
            $tipo=$_FILES['logo']["type"];
            $archivo= $_FILES['logo']["tmp_name"];
        }
        $imagen=$this->image->cargar_imagen($tipo,$archivo,$_POST["id"],"empresas");
        
        //De aquí sale el orden en que serán llamados en la
        //clase anonima
        $array = array(
            $_POST["id"],
            password_hash($_POST["password"], PASSWORD_DEFAULT),
            $created_at,
            $_POST["nomb_emp"],
            $_POST["razon_s"],
            $_POST["direccion"],
            $imagen,
            $_POST["telefono_emp"],
            $rol
        );

        //echo $imagen;
        $data= $this->model->registroEmpresa($this->userClass($array),$this->empresaClass($array),$this->userrolClass($array));
        if ($data == 1) {
            echo "La empresa ya esta registrada en el sistema.";
        } else {
            echo $data;
        }
        
    }


    public function perfil(){ 
        $user=session::getSession("user");
        if (null != $user) {
            if("3" == $user["rol"] || "1" == $user["rol"]){
                $this->view->render($this, "perfil");
            }elseif("2" == $user["rol"]){
                $this->view->render($this, "perfilempresa");
            }else{
                header("Location:".URL."user/privilegios");    
            }
        } else {
            header("Location:".URL."user/login");
        }
   }

   public function actdataUser() {
       $js_data = json_encode(session::getSession( 'user'));
       echo $js_data;
    }

    public function actUser(){
        $user=session::getSession("user");
        if(null != $user){
            if("3" == $user["rol"] || "1" == $user["rol"]){
                if(empty($_POST["nomb_pers"])){
                    echo "El campo nombre es obligatorio.";
                }else{
                    if(empty($_POST["ape_pers"])){
                        echo "El campo apellidos es obligatorio.";
                    }else{
                        if(empty($_POST["emai_pers"])){
                            echo "El campo correo eléctronico es obligatorio.";
                        }else{
                            $archivo =null;
                            $tipo=null;
                            $imagen=null;
                            //Verificar si se cargo una imagen
                            if (isset($_FILES['foto_pers'])) {
                                $tipo=$_FILES['foto_pers']["type"];
                                $archivo=$_FILES['foto_pers']["tmp_name"];
                                $imagen = $this->image->cargar_imagen($tipo, $archivo, $user["id"],"personas");
                            } else {
                                if (isset($_POST['foto_pers'])) {
                                    $archivo=$_POST['foto_pers'];
                                    //obtener imagen que esta en la db antes de actualizarla
                                    $imagen = $this->image->cargar_imagen($tipo, $archivo, $user["id"],"personas");
                                    if($_POST['foto_pers'] != $user["id"].".png"){
                                        $archivo=RS."images/perfiles/personas/".$archivo;
                                        //eliminar la img que contiene el id anterior y que este en la variable archivo
                                        unlink($archivo);
                                        $archivo=null;
                                    }
                                }
                            }

                            $array=array(
                                $user["id"],
                                $_POST["nomb_pers"],
                                $_POST["ape_pers"],
                                $_POST["emai_pers"],
                                $imagen,
                            );
                            echo $this->model->actUser($this->perfilClass($array), $user["id"]);
                        }
                    }  
                }
            }
        }else{
            echo "No tiene privilegios para ejecutar esta acción."; 
            
        }
    }

    public function convocatorias(){
        $this->view->render($this,"convocatorias");    
     }

     public function getListaConvocatoria(){
        setlocale(LC_TIME, 'spanish.utf-8');
         $count=0;
         $dataFilter = null;
         $data = $this->model->getListaConvocatoria($_POST["filter"],$_POST["page"],$this->page);
        if (is_array($data)) {
            $array = $data["results"];
            foreach ($array as $key => $value) {
                $dataConvo=json_encode($array[$count]);

                $fecha = strftime("%A, %d de %B del %Y", strtotime($value["created_at"]));
                $cierre=strftime("%A, %d de %B del %Y", strtotime($value["fecha_fin"]));
                $response=$this->model->getContrato($value["t_contrato"]);
                $contrato=$response[0]["contrato"];

                $response2=$this->model->getEmpresa($value["id_empresa"]);
                $empresa=$response2[0]["nomb_emp"];
                
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
                    "<a href='#detalleconvocatoria-$codigo' onclick='dataConvo(".$dataConvo.");' class='btn btn-info rounded-pill'>Ver Detalles</a>".
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
                "paginador" => $paginador,
                "codigo" => $codigo
            ));
        } 
        
        
    }

    public function contacto(){
        $this->view->render($this,"contacto");    
    }

     public function enviarCorreo(){
         //$email='comiteempresarialmembrillal@gmail.com';
         $email='comiteempresarialmembrillal@gmail.com';
         $nombre='Formulario de contacto Zimep';
         if(empty($_POST["nombre"])){
             echo "El campo nombre es obligatorio.";
            }else{
                if(empty($_POST["email"])){
                    echo "El campo Correo electronico es obligatorio.";
                }else{
                    if(empty($_POST["telefono"])){
                        echo "El campo teléfono es obligatorio.";
                    }else{
                        if(empty($_POST["asunto"])){
                            echo "El campo asunto es obligatorio.";
                        }else{
                            if(empty($_POST["mensaje"])){
                                echo "El campo mensaje es obligatorio.";
                            }else{
                                $array=array(
                                    $_POST["nombre"],
                                    $_POST["email"],
                                    $_POST["telefono"],
                                    $_POST["asunto"],
                                    $_POST["mensaje"]
                                );
                                
                                if(is_array($array)){
                                    $mensaje="<div style='border: 1px solid #336699!important;padding: 40px;border-radius: 5px;margin: 50px;text-align: justify;'><br><strong style='color:#336699;'>Cuenta ZIMEP</strong><br><p style='color: #117a8b;font-size: 30px;'>".$_POST["nombre"]."</p>Ha envíado un mensaje desde la plataforma Zimep.
                                    <br><br><strong style='font-style: italic;'>Datos personales:</strong><br>
                                    Nombre: ".$_POST["nombre"]."<br>
                                    Correo eléctronico: ".$_POST["email"]."<br>
                                    Teléfono: ".$_POST["telefono"]."
                                    <br><br><strong style='font-style: italic;'>Mensaje: </strong><br><br>
                                    ".$_POST["mensaje"]."
                                    </div>";
                                    $datosemail=$this->email->envio_mail($email,$nombre,$_POST["asunto"],$mensaje);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>