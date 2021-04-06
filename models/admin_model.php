<?php
class admin_model extends conexion{
    function __construct(){
        parent::__construct();
        //invocar metodo
        //$this->postLogin();
    }

    function getIdentificaciones(){
        $response= $this->db->select1("codi_iden,desc_iden","tipo_identificacion",null,null);
        $i = 0;
         foreach($response as $rst){
             foreach($rst as $row){
                     $array[$i] = $data = [ "codi_iden" => $row["codi_iden"], "desc_iden" => $row["desc_iden"], ];
                    $js_data = html_entity_decode(json_encode($array));
                   // $js_data = json_encode(array_map('utf8_encode', $array));
                    $i++;
             }
         }
         return $js_data;
        
    }

    function getCategorias(){
        return $response= $this->db->select1("*","cat_persona",null,null);
    }

    public function registroUser($user,$persona){
        $where =" WHERE id = :id";
        $response= $this->db->select1("*",'users',$where,array('id' => $user->id));
        if(is_array($response)){
            $response=$response['results'];
            if(0 == count($response)){
                $value="(id,password) VALUES (:id,:password)";
                $data=$this->db->insert("users",$user,$value);
                if (is_bool($data)) {
                    $response= $this->db->select1("*",'users',$where,array('id' => $user->id));
                   if (is_array($response)) {
                        $response=$response['results'];
                        $persona->id=$response[0]["id"];
                        $value="(codi_iden,id,nomb_pers,ape_pers,id_cat,direccion,foto_pers) VALUES (:identificacion,:id,:nomb_pers,:ape_pers,:categoria,:direccion,:foto_pers)";
                        $data= $this->db->insert("persona",$persona,$value);
                        if(is_bool($data)){
                            return 0;
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
                //return var_dump((Array)$persona);die;
            }else{
                //Ya esta registado (id)
                return 1;
            }
        }else{
            return $response;
        }
    }

    public function registroEmpresa($user,$empresa){
        $where =" WHERE id = :id";
        $response= $this->db->select1("*",'users',$where,array('id' => $user->id));
        if(is_array($response)){
            $response=$response['results'];
            if(0 == count($response)){
                $value="(id,password) VALUES (:id,:password)";
                $data=$this->db->insert("users",$user,$value);
                if (is_bool($data)) {
                    $response= $this->db->select1("*",'users',$where,array('id' => $user->id));
                    if (is_array($response)) {
                        $response=$response['results'];
                        $empresa->id=$response[0]["id"];
                        $value="(id,nomb_emp,razon_s,direccion,logo,telefono_emp) VALUES (:id,:nomb_emp,:razon_s,:direccion,:logo,:telefono_emp)";
                        $data= $this->db->insert("empresa",$empresa,$value);
                        if(is_bool($data)){
                            return 0;
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
                //return var_dump((Array)$empresa);
            }else{
                //Ya esta registado (id)
                return 1;
            }
        }else{
            return $response;
        }
    }

    function getUsers($filter,$page,$model){
        $where=" WHERE id LIKE :id OR nomb_pers LIKE :nomb_pers";
        $array=array(
            'id' => '%'.$filter.'%',
            'nomb_pers' => '%'.$filter.'%',
        );
        $columns="codi_iden,id,nomb_pers,ape_pers,direccion,foto_pers,id_cat";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        $response= $model->paginador($columns,"persona","Users",$page,$where,$array);
        return $response;
        
    }

    function getEmpresas($filter,$page,$model){
        $where=" WHERE id LIKE :id OR nomb_emp LIKE :nomb_emp";
        $array=array(
            'id' => '%'.$filter.'%',
            'nomb_emp' => '%'.$filter.'%',
        );
        $columns="id,nomb_emp,razon_s,direccion,logo,telefono_emp";
        //return $this->db->select1($columns,"empresa",$where,$array);
        return $model->paginador($columns,"empresa","Empresas",$page,$where,$array);
    }

    function editUser($user,$persona,$id_user){
        $where=" WHERE id =:id";
        $response=$this->db->select1("*",'users',$where,array('id' => $user->id));
        if(is_array($response)){
            $response=$response['results'];
            $value="id =:id, password =:password";
            $where=" WHERE id = ".$id_user;
            if(0 == count($response)){
             $data=$this->db->update("users",$user,$value, $where);
             if(is_bool($data)){
                 $where="id =:id";
                 $response=$this->db->select1("*",'users',$where,array('id' => $user->id));
                 if(is_array($response)){
                     $response=$response['results'];
                     $persona->id=$response[0]["id"];
                     $value="id = :id, nomb_pers = :nomb_pers, ape_pers = :ape_pers, codi_iden = :identificacion, direccion = :direccion, foto_pers = :foto_pers, id_cat = :categoria";
                     $where=" WHERE id = ".$id_user;
                     $data=$this->db->update("persona",$persona,$value, $where);
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
            }else{
                
                 if ($response[0]['id'] == $id_user) {
                     $value="id = :id, password = :password";
                     $where=" WHERE id = ".$id_user;
                     $data=$this->db->update("users",$user,$value, $where);
                        if(is_bool($data)){
                            if($response[0]['id'] == $id_user){
                                $value="id = :id, nomb_pers = :nomb_pers, ape_pers = :ape_pers, codi_iden = :identificacion, direccion = :direccion, foto_pers = :foto_pers, id_cat = :categoria";
                                $where=" WHERE id = ".$id_user;
                                $data=$this->db->update("persona",$persona,$value, $where);
                                if(is_bool($data)){
                                    //echo "actualizo";die;
                                    return 0;
                                    }else{
                                        return $data;
                                    }
                            }else{
                                return "El número de identificación ya esta registrado en el sistema.";
                            }
                            
                        }else{
                            return $data;
                        }
                 }else{
                    return "El número de identificación ya esta registrado en el sistema.";
                }
                
            }
            
        }else{
            return $response;
        }
        
    }
    
    function editEmpresa($user,$empresa,$id_user){
        $where="WHERE id =:id";
        $response=$this->db->select1("*",'users',$where,array('id' => $user->id));
        if(is_array($response)){
            $response=$response['results'];
            $value="id =:id, password =:password";
            $where=" WHERE id = ".$id_user;
            if(0 == count($response)){
             $data=$this->db->update("users",$user,$value, $where);
             if(is_bool($data)){
                 $where="id =:id";
                 $response=$this->db->select1("*",'users',$where,array('id' => $user->id));
                 if(is_array($response)){
                     $response=$response['results'];
                     $empresa->id=$response[0]["id"];
                     $value="id = :id, nomb_emp = :nomb_emp, razon_s = :razon_s, direccion = :direccion, logo = :logo, telefono_emp = :telefono_emp";
                     $where=" WHERE id = ".$id_user;
                     $data=$this->db->update("empresa",$empresa,$value, $where);
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
            }else{
                
                 if ($response[0]['id'] == $id_user) {
                     $value="id = :id, password = :password";
                     $where=" WHERE id = ".$id_user;
                     $data=$this->db->update("users",$user,$value, $where);
                        if(is_bool($data)){
                            if($response[0]['id'] == $id_user){
                                $value="id = :id, nomb_emp = :nomb_emp, razon_s = :razon_s, direccion = :direccion, logo = :logo, telefono_emp = :telefono_emp";
                                $where=" WHERE id = ".$id_user;
                                $data=$this->db->update("empresa",$empresa,$value, $where);
                                if(is_bool($data)){
                                    //echo "actualizo";die;
                                    return 0;
                                    }else{
                                        return $data;
                                    }
                            }else{
                                return "El número de identificación ya esta registrado en el sistema.";
                            }
                            
                        }else{
                            return $data;
                        }
                 }else{
                    return "El número de identificación ya esta registrado en el sistema.";
                }
                
            }
            
        }else{
            return $response;
        }
        
    }

    //para obtener el password del usuario que se va actualizar
    function getUser($id_user){
        $where ="WHERE id = :id";
        $response= $this->db->select1("*",'users',$where,array('id' => $id_user));
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function deleteUser($id_user){
        $where="WHERE id = :id";
        $data=$this->db->delete('todo',$where,array('id' => $id_user));
    }
    
    
}
?>