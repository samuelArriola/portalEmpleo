<?php

class controllers extends anonymous{
    public function __construct(){
        session::star();
        //instancia de la clase views
        $this->view= new views();
        $this->image= new Uploadimage();
        $this->file= new Uploadfile();
        $this->page= new paginador();
        $this->email= new EnvioMail();
        $this->loadClassmodels();
    }

    function loadClassmodels(){
        $model=get_class($this).'_model';
        $path='models/'.$model.'.php';
        //verificar si existe el archivo en la carpeta model
        if(file_exists($path)){
            //invocamos el archivo que esta en la carpeta model
            require $path;
            //asignar o almacenar la instancia de la clase que estamos invocando
            $this->model = new $model();

        }
    }
}
?>