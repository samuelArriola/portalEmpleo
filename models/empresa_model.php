<?php
class empresa_model extends conexion{
    function __construct(){
        parent::__construct();
        //invocar metodo
        //$this->postLogin();
    }

    function getCategorias(){
        return $response= $this->db->select1("*","cat_laboral",null,null);
    }
    
    function getCategorias_laborales(){
        return $response= $this->db->select1("*","categorias",null,null);
    }
    
    function getContratos(){
        return $response= $this->db->select1("*","tipo_de_contrato",null,null);
    }

    function getConvocatoriasLabs($id_empresa){
        $where=" WHERE id_empresa = :id_empresa";
        $param=array('id_empresa'=>$id_empresa);
        $response= $this->db->select1("id,nomb_cargo","convocatoria",$where,$param); 
        return $response;
    }
    
    function getConvocatorias($filter,$page,$model){
        $id=$_SESSION["user"]["id"];
        $where=" WHERE id_empresa= $id AND nomb_cargo LIKE :nomb_cargo OR perfil LIKE :perfil OR estado LIKE :estado";
        $array=array(
            'nomb_cargo' => '%'.$filter.'%',
            'perfil' => '%'.$filter.'%',
            'estado' => '%'.$filter.'%',
            );
            
            $columns="id,nomb_cargo,perfil,desc_cargo,categoria,t_contrato,salario,vi_salario,estado,fecha_ini,fecha_fin";
            //Convocatorias  es la función que esta en el js getConvocatorias 
            $response= $model->paginador($columns,"convocatoria","Convocatorias ",$page,$where,$array);
            return $response;
        
    }
    
    public function registerConvocatorias($convocatoria){
        $id="";
        
        $id_empresa=$_SESSION["user"]["id"];
        $response= $this->db->selectmax("id","convocatoria",null,null);
        if(is_array($response)){
            $response=$response['results'];
            $id=$response[0]["id"];
            $convocatoria->id=$id;
            //return var_dump((Array)$convocatoria);die;
                $value="(id,nomb_cargo,perfil,desc_cargo,categoria,t_contrato,salario,vi_salario,id_empresa,estado,fecha_ini,fecha_fin) VALUES (:id,:nomb_cargo,:perfil,:desc_cargo,:categoria_lab,:contrato,:salario,:vi_salario,:id_empresa,:estado,:fecha_ini,:fecha_fin)";
                $data=$this->db->insert("convocatoria",$convocatoria,$value);
                if (is_bool($data)) {
                    return 0;
                } else {
                    return $data;
                }
                
                //return var_dump((Array)$persona);die;
            
        }else{
            return $response;
        }
    }

    public function editConvocatoria($id,$convocatoria){
        $where = " WHERE id = :id";
        $param=array('id'=>$id);
        $response=$this->db->select1("*",'convocatoria',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            id =:id,
            nomb_cargo =:nomb_cargo,
            perfil =:perfil,
            desc_cargo =:desc_cargo,
            categoria =:categoria_lab,
            t_contrato =:contrato,
            salario =:salario,
            vi_salario =:vi_salario,
            id_empresa =:id_empresa,
            estado =:estado,
            fecha_ini =:fecha_ini,
            fecha_fin =:fecha_fin";
            $where=" WHERE id = ".$id;
            $data=$this->db->update("convocatoria",$convocatoria,$value,$where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    public function deleteConvo($id){
        $where = " WHERE id = :id";
        $param=array('id'=>$id);
        $data = $this->db->delete('convocatoria',$where,$param);
        if (is_bool($data)) {
            return 0;
        } else {
            return $data;
        }
    }

    function  getCatLaboral(){
        $response= $this->db->select1("*","cat_laboral",null,null); 
        $response=$response["results"];
        return $response;
    }
    
    function getPerfilLaboral($codigo){
        $where=" WHERE cat_lab = ".$codigo;
        $response= $this->db->select1("*","perfil_lab",$where,null); 
        $response=$response["results"];
        return $response;
    }

    function getBusquedaUsers($id_categoria,$id_perfil,$page,$model){
        $where=" WHERE id_categoria LIKE :id_categoria AND id_perfil LIKE :id_perfil";
        $array=array(
            'id_categoria' => '%'.$id_categoria.'%',
            'id_perfil' => '%'.$id_perfil.'%',
        );
        $columns="id";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getBusquedaUsers
        $response= $model->paginador($columns,"persona_datos_profesionales","BusquedaUsers",$page,$where,$array);
        return $response;
        
    }

    function getConvoCandidatos($convocatoria_lab,$page,$model){
        $where=" WHERE id_conv LIKE :id_conv";
        $array=array(
            'id_conv' => '%'.$convocatoria_lab.'%',
        );
        $columns="id_conv,id_persona,estado";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getBusquedaUsers
        $response= $model->paginador($columns,"postulantes","ConvoCandidatos",$page,$where,$array);
        return $response;
        
    }

    function getDatosPersona($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("*",'persona',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function getHvPersona($code){
        $where=" WHERE id_persona = :id_persona AND estado= :estado";
        $param=array('id_persona'=>$code, 'estado'=>'1');
        $response=$this->db->select1("hoja_de_vida",'persona_hoja_de_vida',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function getperfilProfesionalPersona($code){
        $where=" WHERE id = :id AND estado= :estado";
        $param=array('id'=>$code, 'estado'=>'1');
        $response=$this->db->select1("titulo, descripcion",'persona_datos_profesionales',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function getExpLabPersona($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("*",'persona_experiencia_profesional',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }
    
    function getDataCandidato($id_persona,$id_conv){
        $where=" WHERE id_persona = :id_persona AND id_conv= :id_conv";
        $param=array('id_persona'=>$id_persona, 'id_conv'=>$id_conv);
        $response=$this->db->select1("id,estado,id_persona,id_conv,created_at",'postulantes',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    public function editEstadoCandidato($postulantes,$id_persona,$id_conv){
        $where=" WHERE id_persona = :id_persona and id_conv = :id_conv";
        $param=array('id_persona'=>$id_persona, 'id_conv'=>$id_conv);
        $response=$this->db->select1("*",'postulantes',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            id =:id,
            id_conv =:id_conv,
            id_persona =:id_persona,
            estado =:estado,
            created_at =:created_at";
            $where=" WHERE id_persona = ".$id_persona." and id_conv = ".$id_conv;
            $data=$this->db->update("postulantes",$postulantes,$value,$where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    //Obtener la descripción de la categoria
    function getCat($id_cat){
        $where =" WHERE id = :id";
        $response= $this->db->select1("*",'categorias',$where,array('id' => $id_cat));
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    //Obtener la descripción del tipo de contrato
    function getContrato($id_contrato){
        $where =" WHERE id = :id";
        $response= $this->db->select1("*",'tipo_de_contrato',$where,array('id' => $id_contrato));
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }
   
    //Obtener la descripción del tipo de contrato
    function getPostulantes($id_convo){
        $where =" WHERE id_conv = :id_conv";
        $param=array('id_conv'=>$id_convo);
        $response= $this->db->select1("id",'postulantes',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            $response = $response['results'];
            $total=count($response);
            return $total;
        }else{
            return $response;
        }
    }
}
?>