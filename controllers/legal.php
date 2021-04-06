<?php 
class legal extends controllers{
     public function __construct(){
         //invocar metodo constructor de la clase padre
         parent::__construct();
    }

    public function politica(){
        $this->view->render($this,"politica");
    }

}

?>