<?php
//renderizar o ejecutar vistas de acuerdo al controlador que esta siendo invocado
class views{
    //pasar nombre del controlador y de la vista
    function render($controller, $view){
        //obtener controladores que pasa como parametro por la función
        $controllers=get_class($controller);

        require VIEWS.DFT."head.html";
        require VIEWS.$controllers."/".$view.".html";
        require VIEWS.DFT."footer.html";
    }
}
?>