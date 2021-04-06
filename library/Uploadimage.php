<?php
class Uploadimage{
    
    function cargar_imagen($tipo,$imagen,$id,$carpeta){
        $destino="./resource/images/imgFiles/".$carpeta."/".$id.".png";
        //verificar si se cargo una imagen
        if(strstr($tipo,"image")){
            //se ultiliza cuando subimos un archivo utilizando HTTP o POST
            move_uploaded_file($imagen, $destino);
            
        }else{
            if(null == $imagen){
                //agregar un usuario y no se cargo ninguna imagen de lo contrario entra al else
                $archivo=RS."images/imgFiles/".$carpeta."/default.png";
            }else{
                $archivo=RS."images/imgFiles/".$carpeta."/".$imagen;
            }
            copy($archivo,$destino);
        }
        return $id.".png";
    }
}
?>