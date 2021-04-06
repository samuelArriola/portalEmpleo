<?php
class conexion{

    /*public function __construct(){
        $this->db= new queryManager("sql109.byethost14.com","b14_26734725", "cC1guMFGat", "b14_26734725_zimep");
    }*/

    public function __construct(){
        $this->db= new queryManager("localhost","root","", "cedetec");
    }
}
?>