<?php
class session{
    static function star(){
        //inicializar variables de sesión
        @session_start();
    }
        static function getSession($name){
            //name: nombre del parametro de la sesión
            return $_SESSION[$name];
        }

        static function setSession($name,$data){
            return $_SESSION[$name] = $data;
        }

        //destruir variables de sesión
        static function destroy(){
            @session_destroy();
        }
    }

?>