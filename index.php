<?php

require "config.php";

//Index:controlador - index:metodo
$url= $_GET["url"] ?? "index/index";
//divide los datos y devuelve un arreglo
$url= explode("/", $url);
$controller="";
$method="";

//verificar si contiene o no  dato
if(isset($url[0])){
    //obtiene nombre de controlador
    $controller=$url[0];
}

if(isset($url[1])){
    if($url[1] != ''){
        //obtiene nombre de metodo
        $method="$url[1]";
    }
    
}

//Cargar las clases que están siendo invocadas automaticamente
spl_autoload_register(function($class){ //captura el nombre de la clase que esta siendo invocada
    //verificar si existe en la carpeta librería
    if(file_exists(LBS.$class.".php")){
        //invocar todas las clases que esten en la carpeta librería
        require LBS.$class.".php";
    }
});

require 'controllers/error.php';
$error= new errors();
//crear instancia de la clase controllers
//$obj= new Controllers();
//echo $controller." ".$method;

//invocar los controladores que esten en la carpeta controllers
$controllersPath="controllers/".$controller.".php";
if(file_exists($controllersPath)){
    require $controllersPath;
    //instaciar la clase
    $controller=new $controller();
    //verificar si tiene dato
    if(isset($method)){
        //verificar si existe el metodo que se esta invocando en el controlador
        if(method_exists($controller, $method)){
            //ejecutar metodo si existe en el controlador
            $controller->{$method}();
        }else{
            $error->error();

        }

    }
}else{
    $error->error();
}
?>