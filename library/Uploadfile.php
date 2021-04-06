<?php
class Uploadfile{
    
    function cargar_file($tipo,$file,$nombFile){
        $destino="./resource/files/hdvPersonas/".$nombFile;
        //verificar si se cargo unarchivo
        if(strstr($tipo,"doc") || strstr($tipo,"docx") || strstr($tipo,"pdf")){
            //se ultiliza cuando subimos un archivo utilizando HTTP o POST
            move_uploaded_file($file, $destino);
        }else{
            if(null != $file){
                $archivo=RS."files/hdvPersonas/".$file;
            }
            copy($archivo,$destino);
        }
        return $nombFile;
    }
}
?>