<?php
//clase anonima, sirve para crear objtos unicos
//que solo se pueden usar una vez

declare (strict_types=1);

class anonymous{
    public function userClass($array){
        return new class($array){
            public $id;
            public $password;
            public $created_at;

            function __construct($array){
                $this->id=$array[0];
                $this->password=$array[1];
                $this->created_at=$array[2];
                
            }

        };
    }

    public function userrolClass($array){
        return new class($array){
            public $id_user;
            public $id_rol;
            public $created_at;

            function __construct($array){
                $this->id_user=$array[0];
                $this->id_rol=$array[8];
                $this->created_at=$array[2];
                
            }

        };
    }

    public function resetClass($array){
        return new class($array){
            public $id;
            public $estado;
            public $created_at;
            public $updated_at;

            function __construct($array){
                $this->id=$array[0];
                $this->estado=$array[1];
                $this->created_at=$array[2];
                $this->updated_at=$array[3];
            }

        };
    }

    public function useresetClass($array){
        return new class($array){
            public $id;
            public $updated_at;
            public $password;

            function __construct($array){
                $this->id=$array[0];
                $this->updated_at=$array[3];
                $this->password=$array[4];
            }

        };
    }

    public function personaClass($array){
        return new class($array){
            public $id;
            public $nomb_pers;
            public $ape_pers;
            public $identificacion;
            public $categoria;
            public $direccion;
            public $foto_pers;

            function __construct($array){
                $this->id=$array[0];
                $this->nomb_pers=$array[2];
                $this->ape_pers=$array[3];
                $this->identificacion=$array[4];
                $this->categoria=$array[5];
                $this->direccion=$array[6];
                $this->foto_pers=$array[7];
            }

        };
    }

    public function personauClass($array){
        return new class($array){
            public $identificacion;
            public $id;
            public $nomb_pers;
            public $ape_pers;
            public $direccion;
            public $foto_pers;

            function __construct($array){
                $this->id=$array[0];
                $this->nomb_pers=$array[3];
                $this->ape_pers=$array[4];
                $this->identificacion=$array[5];
                $this->direccion=$array[6];
                $this->foto_pers=$array[7];
            }

        };
    }

    public function empresaClass($array){
        return new class($array){
            public $id;
            public $nomb_emp;
            public $razon_s;
            public $direccion;
            public $logo;
            public $telefono_emp;

            function __construct($array){
                $this->id=$array[0];
                $this->nomb_emp=$array[3];
                $this->razon_s=$array[4];
                $this->direccion=$array[5];
                $this->logo=$array[6];
                $this->telefono_emp=$array[7];
            }

        };
    }
    
        public function convocatoriaClass(array $array){
        return new class($array){
            public $id;
            public $nomb_cargo;
            public $perfil;
            public $desc_cargo;
            public $categoria_lab;
            public $contrato;
            public $salario;
            public $vi_salario;
            public $id_empresa;
            public $estado;
            public $fecha_ini;
            public $fecha_fin;

            function __construct($array){
                $this->id=$array[0];
                $this->nomb_cargo=$array[1];
                $this->perfil=$array[2];
                $this->desc_cargo=$array[3];
                $this->categoria_lab=$array[4];
                $this->contrato=$array[5];
                if(is_numeric($array[6])){
                    $this->salario=$array[6];   
                }
                $this->vi_salario=$array[7];
                $this->id_empresa=$array[8];
                $this->estado=$array[9];
                $this->fecha_ini=$array[10];
                $this->fecha_fin=$array[11];
                
            }

        };
    }

    public function perfilClass($array){
        return new class($array){
            public $id;
            public $nomb_pers;
            public $ape_pers;
            public $emai_pers;
            public $foto_pers;

            function __construct($array){
                $this->id=$array[0];
                $this->nomb_pers=$array[1];
                $this->ape_pers=$array[2];
                $this->emai_pers=$array[3];
                $this->foto_pers=$array[4];
            }

        };
    }

    public function estudioClass($array){
        return new class($array){
            public $cod_da;
            public $id;
            public $nivel_educativo;
            public $titulo;
            public $institucion;
            public $estado;
            public $grado;
            public $soporte;
            

            function __construct($array){
                $this->cod_da=$array[0];
                $this->id=$array[1];
                $this->nivel_educativo=$array[2];
                $this->titulo=$array[3];
                $this->institucion=$array[4];
                $this->estado=$array[5];
                $this->grado=$array[6];
                $this->soporte=$array[7];
            }

        };
    }

    public function academicoplusClass($array){
        return new class($array){
            public $id;
            public $cursos;
            public $id_idioma;
            public $n_idioma;
            

            function __construct($array){
                $this->id=$array[0];
                $this->cursos=$array[1];
                $this->id_idioma=$array[2];
                $this->n_idioma=$array[3];
            }

        };
    }

    public function tecnologiasClass($array){
        
        return new class($array){
            public $cod;
            public $id_pers;
            public $id_prog;
            

            function __construct($array){
                $this->cod=$array[0];
                $this->id_pers=$array[1];
                $this->id_prog=$array[2];
            }

        };
    }

    public function experienciaClass($array){
        return new class($array){
            public $cod_ep;
            public $id;
            public $nomb_empresa;
            public $cargo;
            public $funciones;
            public $fecha_ini;
            public $fecha_fin;

            function __construct($array){
                $this->cod_ep=$array[0];
                $this->id=$array[1];
                $this->nomb_empresa=$array[2];
                $this->cargo=$array[3];
                $this->funciones=$array[4];
                $this->fecha_ini=$array[5];
                $this->fecha_fin=$array[6];
            }

        };
    }

    public function perfilaboralClass($array){
        return new class($array){
            public $cod_dp;
            public $id;
            public $titulo;
            public $id_categoria;
            public $id_perfil;
            public $descripcion;

            function __construct($array){
                $this->cod_dp=$array[0];
                $this->id=$array[1];
                $this->titulo=$array[2];
                $this->id_categoria=$array[3];
                $this->id_perfil=$array[4];
                $this->descripcion=$array[5];
            }

        };
    }

    public function datospersonaClass($array){
        return new class($array){
            public $codi_iden;
            public $id;
            public $nomb_pers;
            public $ape_pers;
            public $sexo;
            public $fnac_pers;
            public $esta_pers;
            public $telefono1;
            public $telefono2;
            public $emai_pers;
            public $direccion;
            public $foto_pers;
        
            function __construct($array){
                $this->codi_iden=$array[0];
                $this->id=$array[1];
                $this->nomb_pers=$array[2];
                $this->ape_pers=$array[3];
                $this->sexo=$array[4];
                $this->fnac_pers=$array[5];
                $this->esta_pers=$array[6];
                $this->telefono1=$array[7];
                $this->telefono2=$array[8];
                $this->emai_pers=$array[9];
                $this->direccion=$array[10];
                $this->foto_pers=$array[11];
            }

        };
    }

    public function postulantesClass($array){
        return new class($array){
            public $id;
            public $id_conv;
            public $id_persona;
            public $estado;
            public $created_at;

            function __construct($array){
                 $this->id=$array[0];
                 $this->id_conv=$array[1];
                 $this->id_persona=$array[2];
                 $this->estado=$array[3];
                 $this->created_at=$array[4];
            }

        };
    } 

    public function hdvClass($array){
        return new class($array){
            public $cod_hdv;
            public $id_persona;
            public $hoja_de_vida;
            public $estado;

            function __construct($array){
                $this->cod_hdv=$array[0];
                $this->id_persona=$array[1];
                $this->hoja_de_vida=$array[2];
                $this->estado=$array[3];
            }

        };
    }

}
?>