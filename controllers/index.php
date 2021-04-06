<?php 
class index extends controllers{
     public function __construct(){
         //invocar metodo constructor de la clase padre
         parent::__construct();
         //$this->getConvocatorias();
    }

    public function index(){
        $this->view->render($this,"index");
    }

    function getConvocatorias(){
        setlocale(LC_TIME, 'spanish.utf-8');
        $count=0;
        $dataFilter = null;
        $data=$this->model->getConvocatorias();
        if(is_array($data)){
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

                $dataFilter .= "<div class='owl-item'>".
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
            echo $dataFilter;
        }else{
            echo $data;
        }
    }
}

?>