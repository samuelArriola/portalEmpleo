<?php
class user_model extends conexion{
    function __construct(){
        parent::__construct();
        //invocar metodo
        //$this->postLogin();
    }

    /*public function userModel(){
        //echo "metodo index model";
    }*/

    public function postLogin($id,$password){
        //buscar en la columna id de la tabla user el $param $id
        $on=" users.id = user_roles.id_user";
        $where = " WHERE users.id = :id";
        $param=array('id'=>$id);
        $response=$this->db->select2("users.id, users.password, user_roles.id_rol as rol",'users','user_roles',$on,$where, $param);
        $roles = array();
        //return $response;
        //var_dump($response);
        if(is_array($response)){
            $response=$response['results'];
            $count  = 0;
            if(count($response)){
            //var_dump($response[0]["password"]);
            foreach ( $response as $key => $value) {
                $where = " WHERE id = :id";
                $param = array('id' => $value["rol"]);
                $response1 = $this->db->select1("id",'roles',$where,$param);
                //array $roles que contiene la colección de Roble de acuerdo a la cantidad de roles que contenga el usuario que está tratando de Iniciar sesión en el sistema
                $roles[$count ] = $response1['results'];
                $count++;
            }
            if(password_verify($password,$response[0]["password"])){
                if($response[0]["rol"] == "3" || $response[0]["rol"] == "1"){
                    $where = " WHERE id = :id";
                    $param = array('id' => $value["id"]);
                    $response2 = $this->db->select1("nomb_pers as nombre, ape_pers as apellido, foto_pers as perfil, emai_pers as correo, codi_iden as codi",'persona',$where,$param);
                    $response = $response + $response2;
                    $data= [];
                    $data["id"] = $response[0]["id"];
                    $data["password"] = $response[0]["password"];
                    $data["rol"] = $response[0]["rol"];
                    $data["nombre"] = $response["results"][0]["nombre"];
                    $data["apellido"] = $response["results"][0]["apellido"];
                    $data["perfil"] = $response["results"][0]["perfil"];
                    $data["correo"] = $response["results"][0]["correo"];
                    $data["codi"] = $response["results"][0]["codi"];
                    session::setSession("user",$data);
                    $js_data = json_encode($data);
                    return $js_data;
                }
            if($response[0]["rol"] == "2"){
                $where = " WHERE id = :id";
                $param =array('id' => $value["id"]);
                $response2 = $this->db->select1("nomb_emp as nombre, logo as perfil",'empresa',$where,$param);
                $response = $response + $response2;
                $data= [];
                $data["id"] = $response[0]["id"];
                $data["password"] = $response[0]["password"];
                $data["rol"] = $response[0]["rol"];
                $data["nombre"] = $response["results"][0]["nombre"];
                $data["perfil"] = $response["results"][0]["perfil"];
                session::setSession("user",$data);
                $js_data = json_encode($data);
                return $js_data;
        }
            }else{
                $data=array(
                    "id"=>0,
                );
                return $data;
            }
        }else{
            return "El usuario no esta registrado en el sistema.";
        }
        }else{
            return $response;
        }
        

    }

    /*public function postLogin($id,$password){
        //buscar en la columna id de la tabla user el $param $id
        $where=" id = :id";
        $param=array('id'=>$id);
        $response=$this->db->select1("*",'users',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            if(0 != count($response)){
                //var_dump($response[0]["password"]);
            if(password_verify($password, $response[0]["password"])){
                
                $data=array(
                    "id"=>$response[0]["id"],
                    "password"=>$response[0]["password"],
                );
                session::setSession("User",$data);
                return $data;
            }else{
                $data=array(
                    "id"=>0,
                );
                return $data;
            }
            
            }else{
               return "El usuario no esta registrado."; 
            }
            
        }else{
            return $response;
        }
        

    }*/

    function getIdentificaciones(){
        return $response= $this->db->select1("*","tipo_identificacion",null,null);
    }

    public function registroUser($user,$persona,$userrol){
        $where =" WHERE id = :id";
        $param=array('id' => $user->id);
        $response= $this->db->select1("*",'users',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            if(0 == count($response)){
                $value="(id,password,created_at) VALUES (:id,:password,:created_at)";
                $data=$this->db->insert("users",$user,$value);
                if (is_bool($data)) {
                    $response= $this->db->select1("*",'users',$where,$param);
                    if (is_array($response)) {
                        $response=$response['results'];
                        $persona->id=$response[0]["id"];
                        $value="(codi_iden,id,nomb_pers,ape_pers,direccion,foto_pers) VALUES (:identificacion,:id,:nomb_pers,:ape_pers,:direccion,:foto_pers)";
                        $data= $this->db->insert("persona",$persona,$value);
                        if(is_bool($data)){
                            $response= $this->db->select1("*",'users',$where,$param);
                            if (is_array($response)) {
                                $response=$response['results'];
                                $userrol->id_user=$response[0]["id"];
                                $value="(id_user,id_rol,created_at) VALUES (:id_user,:id_rol,:created_at)";
                                $data= $this->db->insert("user_roles",$userrol,$value);
                                if(is_bool($data)){
                                    return 0;
                                }else{
                                    return $data;
                                }
                            }else{
                                return $data;
                            }
                        }else{
                            return $data;
                        }
                    } else {
                        return $data;
                    }
                    

                } else {
                    return $data;
                }
                //return var_dump((Array)$user);
                //return var_dump((Array)$persona);
            }else{
                //Ya esta registado (id)
                return 1;
            }
        }else{
            return $response;
        }
    }

    public function registroEmpresa($user,$empresa,$userrol){
        $where =" WHERE id = :id";
        $param=array('id' => $user->id);
        $response= $this->db->select1("*",'users',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            if(0 == count($response)){
                $value="(id,password,created_at) VALUES (:id,:password,:created_at)";
                $data=$this->db->insert("users",$user,$value);
                if (is_bool($data)) {
                    $response= $this->db->select1("*",'users',$where,$param);
                    if (is_array($response)) {
                        $response=$response['results'];
                        $empresa->id=$response[0]["id"];
                        $value="(id,nomb_emp,razon_s,direccion,logo,telefono_emp) VALUES (:id,:nomb_emp,:razon_s,:direccion,:logo,:telefono_emp)";
                        $data= $this->db->insert("empresa",$empresa,$value);
                        if(is_bool($data)){
                            $response= $this->db->select1("*",'users',$where,$param);
                            if (is_array($response)) {
                                $response=$response['results'];
                                $userrol->id_user=$response[0]["id"];
                                $value="(id_user,id_rol,created_at) VALUES (:id_user,:id_rol,:created_at)";
                                $data= $this->db->insert("user_roles",$userrol,$value);
                                if(is_bool($data)){
                                    return 0;
                                }else{
                                    return $data;
                                }
                            }else{
                                return $data;
                            }
                        }else{
                            return $data;
                        }
                    } else {
                        return $data;
                    }
                } else {
                    return $data;
                }
                //return var_dump((Array)$user);
                //return var_dump((Array)$persona);
            }else{
                //Ya esta registado (id)
                return 1;
            }
        }else{
            return $response;
        }
    }
     
    public function passwordreset($id,$reset){
        $where=" WHERE id = :id";
        $param=array('id'=>$id);
        $response=$this->db->select1("id, nomb_pers as nombre, ape_pers as apellido, emai_pers as email",'persona',$where,$param);
        $estados = array();
        $count  = 0;
        if(is_array($response)){
            $response=$response['results'];
            if(count($response) > 0){
                    if($response[0]["email"] != null || $response[0]["email"] != ""){
                        $response1=$this->db->select1("id, estado",'resetpassword',$where,$param);
                        if(is_array($response1)){
                            $response1=$response1['results'];
                            $count  = 0;
                                
                                foreach ( $response1 as $key => $value) {
                                    $where = " WHERE id = :id";
                                    $response1 = $this->db->select1("estado",'resetpassword',$where,array('id' => $value["id"]));
                                    //array $roles que contiene la colección de Roble de acuerdo a la cantidad de roles que contenga el usuario que está tratando de Iniciar sesión en el sistema
                                    $roles[$count ] = $response1['results'];
                                    $count++;
                                }
                                $posicion = -1 ;
                                 for( $contador=0; $contador < count($response1['results']); $contador++ ){
                                    if( $response1['results'][$contador]["estado"] == "0") {
                                         $posicion = $contador;
                                    break;
                                   }
                               }

                               if( $posicion == -1 ){
                                $response2= $this->db->select1("*",'resetpassword',$where,array('id' => $reset->id));
                                if (is_array($response2)) {
                                    $response2=$response2['results'];
                                    $reset->id=$response2[0]["id"];
                                    $value="(id,estado,created_at,updated_at) VALUES (:id,:estado,:created_at,:updated_at)";
                                            $data=$this->db->insert("resetpassword",$reset,$value);
                                    if(is_bool($data)){
                                        //return 0;
                                        //var_dump($response);die;
                                        $data= [];
                                        $data["id"] = $response[0]["id"];
                                        $data["nombre"] = $response[0]["nombre"]." ". $response[0]["apellido"];
                                        $data["emai_pers"] = $response[0]["email"];
                                        $js_data = json_encode($data);
                                        return $js_data;
                                    }else{
                                        return $data;
                                    }
                                } else {
                                    return $data;
                                }
                                
                               }else{        
                                //return "Usted solicitó un cambio de contraseña hace poco, debe esperar 24 horas para solicitar uno nuevamente.";
                                return 1;
                               } 
                            
                        }else{
                            return $response;
                        }
  
                }else{
                    //return "El usuario no ha registrado un correo electrónico en la plataforma de ZIMEP. Por favor comunicarse con el administrador.";
                    return 2;
                    
                }
            }else{
                
                //return  "El usuario no esta registrado en la plataforma de ZIMEP.";
                return  3;
            }
        }else{
            return $response;
        }

        
    }

    public function savePassreset($usereset,$reset,$code){
        $where=" WHERE id =:id";
        $response=$this->db->select1("*",'users',$where,array('id' => $usereset->id));
        if(is_array($response)){
            $response=$response['results'];
            if(0 != count($response)){
                $where=" WHERE id = :id and estado = :estado";
                $param=array('id'=>$code, 'estado'=>"0");
                $response1=$this->db->select1("estado,created_at",'resetpassword',$where,$param);
                $response1=$response1['results'];
                if(0 != count($response1)){
                    $value="id =:id, password =:password, updated_at=:updated_at";
                    $where=" WHERE id = ".$code;
                    $data=$this->db->update("users",$usereset,$value, $where);
                    if(is_bool($data)){
                        $value="id=:id, estado=:estado,created_at=:created_at,updated_at=:updated_at";
                        $where=" WHERE estado='0' and id = ".$code;
                        $data=$this->db->update("resetpassword",$reset,$value, $where);
                        if(is_bool($data)){
                            return 0;
                        }else{
                            return $data;
                        }
                    }else{
                        return $data;
                    }
                    
                }else{
                    return "Los cambios no se guardaron debido a que el enlace ya caducó o se realizó la actualización de la contraseña, solicite uno nuevo.";
                }
            }else{
                echo "El usuario no esta registrado en la plataforma de ZIMEP.";
            }
        }else{
            return $response;
        }
    }

    function getUser($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("id,created_at",'users',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }   

    public function actUser($perfil,$id){
        $where=" WHERE id =:id";
        $response=$this->db->select1("nomb_pers,ape_pers,emai_pers,foto_pers",'persona',$where,array('id' => $perfil->id));
        if(is_array($response)){
            $response=$response['results'];
            $value="id =:id, nomb_pers =:nomb_pers, ape_pers =:ape_pers,emai_pers =:emai_pers, foto_pers =:foto_pers";
            $where=" WHERE id = ".$id;
            if(count($response)>0){
                $data=$this->db->update("persona",$perfil,$value, $where);
                if(is_bool($data)){
                    return 0;
                }else{
                    return $data;
                }
            }
        }
    }

    function getListaConvocatoria($filter,$page,$model){
        $where=" WHERE perfil LIKE :perfil OR nomb_cargo LIKE :nomb_cargo";
        $array=array(
            'perfil' => '%'.$filter.'%',
            'nomb_cargo' => '%'.$filter.'%',
        );
        $columns="id,nomb_cargo,perfil,desc_cargo,categoria,t_contrato,salario,vi_salario,id_empresa,estado,fecha_ini,fecha_fin,created_at";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        $response= $model->paginador($columns,"convocatoria","ListaConvocatoria",$page,$where,$array);
        return $response;
        
    }

    function getContrato($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("descripcion as contrato",'tipo_de_contrato',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function getEmpresa($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("nomb_emp",'empresa',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }
    

}
?>