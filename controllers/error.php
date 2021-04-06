<?php 
class errors extends controllers{
     
    public function error(){
        $this->view->render($this,"error");
    }
}

?>