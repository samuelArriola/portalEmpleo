<?php
class persona_model extends conexion{
    function __construct(){
        parent::__construct();
    }

    function getIdentificaciones(){
         $response= $this->db->select1("*","tipo_identificacion",null,null);
         $response=$response["results"];
         return $response;
    }

    function getEstadoCivil(){
         $response= $this->db->select1("*","estado_civil",null,null); 
         $response=$response["results"];
         return $response;
    }

    function  getTipoEstudio(){
         $response= $this->db->select1("*","tipo_estudio",null,null); 
         $response=$response["results"];
         //Quita el último elemento del array (No definido)
         array_pop($response);
         return $response;
    }

    function  getCatLaboral(){
        $response= $this->db->select1("*","cat_laboral",null,null); 
        $response=$response["results"];
        return $response;
   }

   function  getPerfilUpdate(){
    $response= $this->db->select1("*","perfil_lab",null,null); 
    $response=$response["results"];
    return $response;
}

   function getPerfilLaboral($codigo){
       $where=" WHERE cat_lab = ".$codigo;
       $response= $this->db->select1("*","perfil_lab",$where,null); 
       $response=$response["results"];
       return $response;
       
   }

   function getIdiomas(){
    $response= $this->db->select1("*","idioma",null,null); 
    $response=$response["results"];
    return $response;
}

    function getListaEstudios($id,$filter,$page,$model){
        //$where=" WHERE id = :id AND titulo LIKE :titulo";
        $where=" WHERE id = :id AND titulo LIKE :titulo";
        $param=array(
            'id'=>$id,
            'titulo' => '%'.$filter.'%',
        );
        $columns="cod_da,nivel_educativo,titulo,institucion,estado,grado,soporte";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        return $model->paginador($columns,"persona_datos_academicos","ListaEstudios",$page,$where,$param);
        
    }

    public function registerEstudios($id,$estudio){
        $value="(cod_da,id,nivel_educativo,titulo,institucion,estado,grado,soporte) VALUES (:cod_da,:id,:nivel_educativo,:titulo,:institucion,:estado,:grado,:soporte)";
        $data=$this->db->insert("persona_datos_academicos",$estudio,$value);
        if(is_bool($data)){
            return 0;
        }else{
            return $data;
        }
               
    }

    public function editEstudio($estudio,$cod_da){
        $where=" WHERE cod_da = ".$cod_da;
        $param=array('cod_da'=>$cod_da);
        $response=$this->db->select1("*",'persona_datos_academicos',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            cod_da =:cod_da,
            id =:id,
            nivel_educativo =:nivel_educativo,
            titulo =:titulo,
            institucion =:institucion,
            estado =:estado,
            grado =:grado,
            soporte =:soporte";
            $where=" WHERE cod_da = ".$cod_da;
            $data=$this->db->update("persona_datos_academicos",$estudio,$value,$where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    public function deleteEstudio($cod_da,$soporte){
        //var_dump($cod_da." ".$soporte);die;
        $where = " WHERE cod_da = :cod_da";
        $param=array('cod_da'=>$cod_da);
        $data = $this->db->delete('persona_datos_academicos',$where,$param);
        if (is_bool($data)) {
            $archivo = RS."images/imgFiles/soportes/".$soporte;
            unlink($archivo);
            return 0;
        } else {
            return $data;
        }
    }

    function getListaExperiencias($id,$filter,$page,$model){
        $where=" WHERE id = :id AND cargo LIKE :cargo";
        $param=array(
            'id'=>$id,
            'cargo' => '%'.$filter.'%',
        );
        $columns="cod_ep,id,nomb_empresa,cargo,funciones,fecha_ini,fecha_fin";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        return $model->paginador($columns,"persona_experiencia_profesional","ListaExperiencias",$page,$where,$param);
        
    }

    public function registerExperiencias($id,$experiencia){
        $value="(cod_ep,id,nomb_empresa,cargo,funciones,fecha_ini,fecha_fin) VALUES (:cod_ep,:id,:nomb_empresa,:cargo,:funciones,:fecha_ini,:fecha_fin)";
        $data=$this->db->insert("persona_experiencia_profesional",$experiencia,$value);
        if (is_bool($data)) {
            return 0;
        }else{
            return $data;
        }
               
    }

    public function editExperiencia($experiencia,$cod_ep){
        $where=" WHERE cod_ep = ".$cod_ep;
        $param=array('cod_ep'=>$cod_ep);
        $response=$this->db->select1("*",'persona_experiencia_profesional',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            cod_ep =:cod_ep,
            id =:id,
            nomb_empresa =:nomb_empresa,
            cargo =:cargo,
            funciones =:funciones,
            fecha_ini =:fecha_ini,
            fecha_fin =:fecha_fin";
            $where=" WHERE cod_ep = ".$cod_ep;
            $data=$this->db->update("persona_experiencia_profesional",$experiencia,$value,$where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    public function deleteExperiencia($cod_ep){
        $where = " WHERE cod_ep = :cod_ep";
        $param=array('cod_ep'=>$cod_ep);
        $data = $this->db->delete('persona_experiencia_profesional',$where,$param);
        if (is_bool($data)) {
            return 0;
        } else {
            return $data;
        }
    }

    function getListaPerfiles($id,$filter,$page,$model){
        $where=" WHERE id = :id AND titulo LIKE :titulo";
        $param=array(
            'id'=>$id,
            'titulo' => '%'.$filter.'%',
        );
        $columns="cod_dp,id,titulo,id_categoria,id_perfil,descripcion,estado";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        return $model->paginador($columns,"persona_datos_profesionales","ListaPerfiles",$page,$where,$param);
        
    }

    public function registerPerfiles($id,$perfilaboral){
        $value="(cod_dp,id,titulo,id_categoria,id_perfil,descripcion) VALUES (:cod_dp,:id,:titulo,:id_categoria,:id_perfil,:descripcion)";
        $data=$this->db->insert("persona_datos_profesionales",$perfilaboral,$value);
        if (is_bool($data)) {
            return 0;
        }else{
            return $data;
        }
               
    }

    public function editPerfil($perfilaboral,$cod_dp){
        $where=" WHERE cod_dp = ".$cod_dp;
        $param=array('cod_dp'=>$cod_dp);
        $response=$this->db->select1("*",'persona_datos_profesionales',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            cod_dp =:cod_dp,
            id =:id,
            titulo =:titulo,
            id_categoria =:id_categoria,
            id_perfil =:id_perfil,
            descripcion =:descripcion";
            $where=" WHERE cod_dp = ".$cod_dp;
            $data=$this->db->update("persona_datos_profesionales",$perfilaboral,$value,$where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    public function deletePerfil($cod_dp){
        $where = " WHERE cod_dp = :cod_dp";
        $param=array('cod_dp'=>$cod_dp);
        $data = $this->db->delete('persona_datos_profesionales',$where,$param);
        if (is_bool($data)) {
            return 0;
        } else {
            return $data;
        }
    }

    public function actDatosPersonales($id){
        $where=" WHERE id = :id";
        $param=array('id'=>$id);
        $response= $this->db->select1("*","persona",$where,$param); 
        $response=$response["results"];
        return $response[0];
    }

    public function saveDatosPersonales($datospersona,$id,$email){
        $where=" WHERE id =:id";
        $response=$this->db->select1("*",'persona',$where,array('id' => $datospersona->id));
        if(is_array($response)){
            $response=$response['results'];
            if($response[0]['emai_pers'] == $email){
                $value="codi_iden =:codi_iden,
            id =:id,
            nomb_pers =:nomb_pers,
            ape_pers =:ape_pers,
            sexo =:sexo,
            fnac_pers =:fnac_pers,
            esta_pers =:esta_pers,
            telefono1 =:telefono1,
            telefono2 =:telefono2,
            emai_pers =:emai_pers,
            direccion =:direccion,
            foto_pers =:foto_pers";
            $where=" WHERE id = ".$id;
            $data=$this->db->update("persona",$datospersona,$value, $where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            }
            }else{
                return "El correco eléctronico ya esta registrado en el sistema.";
            }
            
        }else{
            return $response;
        }
    }

    public function DatosAPlus($id){
        $where=" WHERE id = :id";
        $param=array('id'=>$id);
        $response= $this->db->select1("*","persona_datos_academicos_plus",$where,$param); 
        $response=$response["results"];
        if(empty($response)){
            return 0;
        }else{
            return  $response[0];
        }
        
        

    }

    public function saveDatosAPlus($academicoplus,$id){
        $where=" WHERE id =:id";
        $response=$this->db->select1("*",'persona_datos_academicos_plus',$where,array('id' => $id));
        if(is_array($response)){
            $value="id =:id,
            cursos =:cursos,
            id_idioma =:id_idioma,
            n_idioma =:n_idioma";
            $where=" WHERE id = ".$id;
            $data=$this->db->update("persona_datos_academicos_plus",$academicoplus,$value, $where);
            if(is_bool($data)){
                return 0;
            }else{
                return $data;
            } 
        }else{
            return $response;
        }
    }

    function getTecnologias(){
        return $this->db->select1("*","programas",null,null);
    }

    function getTecnologiaUser($id_user){
        $where=" WHERE id_pers = ".$id_user;
        $response=$this->db->select1("id_prog",'tecnologias',$where,null);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    public function registerTecnologias($id,$tecnologias){
        $where = " WHERE id_pers = :id_pers";
        $param=array('id_pers'=>$id);
        $response= $this->db->select1("*",'tecnologias',$where,$param);
            $value="(cod,id_pers,id_prog) VALUES (:cod,:id_pers,:id_prog)";
            $data=$this->db->insert("tecnologias",$tecnologias,$value);
            if (is_bool($data)) {
                return 0;
            }else{
                return $data;
    }       
                     
    }

    public function dataPostulante($id){
        $where=" WHERE id_persona =:id_persona and estado=0";
        $param=array('id_persona'=>$id);
        $response= $this->db->select1("*","postulantes",$where,$param); 
        $response=$response["results"];
        return $response;
        
    }

    function getListadoConvocatoria($filter,$page,$model){
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
        $response=$this->db->select1("nomb_emp as empresa,direccion,logo,telefono_emp",'empresa',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    function getCategoriaLaboral($code){
        $where=" WHERE id = :id";
        $param=array('id'=>$code);
        $response=$this->db->select1("descripcion as des_categoria",'categorias',$where,$param);
        if(is_array($response)){
            //retornar arreglo con la información del usuario
            return $response = $response['results'];
        }else{
            return $response;
        }
    }

    public function getDetalleConvocatoria($codigo){
        $where=" WHERE id =:id and estado=1";
        $param=array('id'=>$codigo);
        $columns="id,nomb_cargo,perfil,desc_cargo,categoria,t_contrato,salario,vi_salario,id_empresa,estado,fecha_ini,fecha_fin,created_at";
        $response= $this->db->select1($columns,"convocatoria",$where,$param); 
        $response=$response["results"];
        return $response[0];
        
    }

    function getListaConvoSilimares($codigo){
        $where=" WHERE id =:id and estado=1";
        $param=array('id'=>$codigo);
        $response=$this->db->select1("categoria",'convocatoria',$where,$param);
        if(is_array($response)){
            $id_categoria=$response['results'][0]["categoria"];
            $where=" WHERE categoria =:categoria and estado=1 and id != :id";
            $param=array('categoria'=>$id_categoria, 'id'=>$codigo);
            $response=$this->db->select1("id,perfil",'convocatoria',$where,$param);
            //retornar arreglo con la información del usuario
            return $response;
        }else{
            return $response;
        }
    }

    public function registerPostulantes($id_conv,$id_persona,$postulantes){
        $where =" WHERE id_conv = :id_conv and id_persona= :id_persona";
        $param=array('id_conv' => $id_conv, 'id_persona' => $id_persona);
        $response= $this->db->select1("*",'postulantes',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            if(0 == count($response)){
                $value="(id,id_conv,id_persona,estado,created_at) VALUES (:id,:id_conv,:id_persona,:estado,:created_at)";
                $data=$this->db->insert("postulantes",$postulantes,$value);
                if (is_bool($data)) {
                    return 0;
                }else{
                    return $data;
                }
            }else{
                //Ya esta registado (id)
                return 1;
            }
        }else{
            return $response;
        }
    }

    public function getListaPostulaciones($id,$page,$model){
        $where=" WHERE id_persona = :id_persona";
        $param=array(
            'id_persona'=>$id,
        );
        $columns="id,id_conv,id_persona,estado";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        return $model->paginador($columns,"postulantes","ListaPostulaciones",$page,$where,$param);
    }

    function getDatosReporte($id,$filter,$page,$model){
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        if($filter=="3"){
            $where=" WHERE id_persona = :id_persona";
            $array=array(
                'id_persona'=>$id,            
            );
            $columns="id_conv,estado,created_at";
            $response= $model->paginador($columns,"postulantes","DatosReporte",$page,$where,$array);
        }else{
            $where=" WHERE id_persona = :id_persona AND estado LIKE :estado";
            $array=array(
                'id_persona'=>$id,
                'estado' => '%'.$filter.'%',
            );
            $columns="id_conv,estado,created_at";
            $response= $model->paginador($columns,"postulantes","DatosReporte",$page,$where,$array);
        }
        
        return $response;
        
    }

    function RegisterHdv($hdv){
        $value="(cod_hdv,id_persona,hoja_de_vida,estado) VALUES (:cod_hdv,:id_persona,:hoja_de_vida,:estado)";
        $data=$this->db->insert("persona_hoja_de_vida",$hdv,$value);
        if(is_bool($data)){
            return 0;
        }else{
            return $data;
        }
    }

    function getListaHdv($id,$page,$model){
        $where=" WHERE id_persona = :id_persona";
        $param=array(
            'id_persona'=>$id
        );
        $columns="cod_hdv,id_persona,hoja_de_vida,estado";
        //return $this->db->select1($columns,"persona",$where,$array);
        //Users es la función que esta en el js getUsers
        return $model->paginador($columns,"persona_hoja_de_vida","ListaHdv",$page,$where,$param);
        
    }

    public function editEstadoHdv($hdv,$cod_hdv,$id_persona){
        $where=" WHERE cod_hdv = ".$cod_hdv;
        $param=array('cod_hdv'=>$cod_hdv);
        $response=$this->db->select1("*",'persona_hoja_de_vida',$where,$param);
        if(is_array($response)){
            $response=$response['results'];
            $value="
            cod_hdv =:cod_hdv,
            id_persona =:id_persona,
            hoja_de_vida =:hoja_de_vida,
            estado =:estado";
            $where=" WHERE cod_hdv = $cod_hdv and id_persona = $id_persona";
            $data=$this->db->update("persona_hoja_de_vida",$hdv,$value,$where);
            if(is_bool($data)){
                $where=" WHERE cod_hdv != ".$cod_hdv." and id_persona=".$id_persona;
                $response=$this->db->select1("estado",'persona_hoja_de_vida',$where,null);
                $estado='0';
                $array=array($estado);
                $value="estado =:estado";
                $data=$this->db->update("persona_hoja_de_vida",$array,$value,$where);
                //var_dump($response);die;
                if(is_bool($data)){
                    return 0;
                }else{
                    return $data;
                }
            }else{
                return $data;
            }
        }else{
            return $response;
        }
    }

    public function editEstadoDefaultHdv($id_persona){
        $where=" WHERE id_persona=".$id_persona;
        $response=$this->db->select1("estado",'persona_hoja_de_vida',$where,null);
        $estado='0';
        $array=array($estado);
        $value="estado =:estado";
        $data=$this->db->update("persona_hoja_de_vida",$array,$value,$where);
        if(is_bool($data)){
            return 0;
        }else{
            return $data;
        }
    }

    function estadoHdv($id_persona){
        $where=" WHERE id_persona =:id_persona and estado=1";
        $param=array('id_persona'=>$id_persona);
        $response=$this->db->select1("estado",'persona_hoja_de_vida',$where,$param);
        $response=$response["results"];
        return $response;    
    }

    public function deleteHdv($cod_hdv,$file){
        //var_dump($cod_hdv." ".$file);die;
        $where = " WHERE cod_hdv = :cod_hdv";
        $param=array('cod_hdv'=>$cod_hdv);
        $data = $this->db->delete('persona_hoja_de_vida',$where,$param);
        if (is_bool($data)) {
            $archivo=RS."files/hdvPersonas/".$file;
            unlink($archivo);
            return 0;
        } else {
            return $data;
        }
    }

}

?>