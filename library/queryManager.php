<?php
class queryManager{
    private $pdo;
    function __construct($HOST,$USER,$PASS,$DB){
        try{
            $this->pdo = new PDO('mysql:host='.$HOST.';dbname='.$DB.';charset=utf8',$USER, $PASS,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );
        }catch(PDOException $e){
            print "¡Error!: ".$e->getMessage();
            die();
        }
    }

    function select1($attr,$table,$where,$param){
        try{
            $where = $where ?? "";
        
            $query = "SELECT ".$attr." FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchAll(PDO::FETCH_ASSOC);
            return array("results" => $response);
        }catch (PDOException $e){
            return $e->getMessage();
        }
        $pdo = null;
    }

    function selectmax($attr,$table,$where,$param){
        try{
            if($where==""){
                $query="SELECT MAX(".$attr.")+1 as id FROM ".$table;

            }else{
                $query="SELECT MAX(".$attr.")+1 FROM ".$table." WHERE ".$where;
            }
            $sth=$this->pdo->prepare($query);
            //nombre de las columnas de la tabla de la db
            $sth->execute($param);
            //arreglo con todos los elementos de la tabla de la db
            $response=$sth->fetchAll(PDO::FETCH_ASSOC);
            //devuelve array de $response
            return array("results"=>$response);
        }catch(PDOException $e){
            return $e->getMessage();
        }
        //cerrar conexión a la db
        $pdo=null;
    }

    function select2($attr,$table1,$table2,$on,$where,$param){
        try{
            $where = $where ?? "";
           // $query = "SELECT * FROM usuarios u INNER JOIN  registro r ON u.id = r.id_user";
            $query = "SELECT ".$attr." FROM ".$table1." INNER JOIN ".$table2." ON ".$on.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchAll(PDO::FETCH_ASSOC);
            return array("results" => $response);
        }catch (PDOException $e){
            return $e->getMessage();
        }
        $pdo = null;
    }

    function select3($attr,$table,$pagi_inicial,$pagi_cuantos,$where,$param){
        try{
            $query = "SELECT ".$attr." FROM ".$table.$where." LIMIT $pagi_inicial,$pagi_cuantos";
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            $response = $sth->fetchAll(PDO::FETCH_ASSOC);
            return array("results" => $response);
        }catch (PDOException $e){
            return $e->getMessage();
        }
        $pdo = null;
    }

    function insert($table,$param,$value){
        try{
            $query= "INSERT INTO ".$table.$value;
            $sth=$this->pdo->prepare($query);
            $sth->execute((array)$param);
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
        $pdo=null;
    }
    
    /** $table: clase anonima
     * $param: atributos con la información de usuario
     * $value: información de las columnas que se van actualizar */
    function update($table,$param,$value,$where){
        try{
            $query="UPDATE ".$table." SET ".$value.$where;
            $sth=$this->pdo->prepare($query);
            $sth->execute((array)$param);
            return true;
        }catch(PDOException $e){
            return $e->getMessage();
        }
        $pdo=null;

    }

    function delete($table,$where,$param){
        try{
            $query = "DELETE FROM ".$table.$where;
            $sth = $this->pdo->prepare($query);
            $sth->execute($param);
            return true;
        }catch (PDOException $e){
            return $e->getMessage();
        }
        $pdo = null;
    }
    
}
?>