<?php
class sessiones extends controllers{
    function __construct(){
        parent::__construct();
    }

    public function destroySession(){
        session::destroy();
        header("Location:".URL."user/login");
    }
}
?>