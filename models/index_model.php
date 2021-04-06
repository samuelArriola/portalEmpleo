<?php
class index_model extends conexion{
    function __construct(){
        parent::__construct();
        //invocar metodo
        //$this->postLogin();
    }

    function getConvocatorias(){
        $where=" WHERE estado=1 ORDER BY id DESC LIMIT 10";
        return $this->db->select1("*","convocatoria",$where,null);
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