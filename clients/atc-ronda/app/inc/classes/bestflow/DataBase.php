<?php

require_once "../inc/php/public.php";

class DataBase {
    
    protected $conn;
    
    private $last_sql = "";
    
    protected $DB_HOST = "187.127.23.38";
    protected $DB_PORT = 3309;
    protected $DB_USER = "gepros1com_atc";
    protected $DB_PASS = "gepros15082008";
    protected $DB_NAME = "gepros1com_atc";
    
    function getLastSQL(){
        return $this->last_sql;
    }
    
    function conectar(){        
        $host = getenv("DB_HOST") ?: $this->DB_HOST;
        $port = getenv("DB_PORT") ?: $this->DB_PORT;
        $user = getenv("DB_USER") ?: $this->DB_USER;
        $pass = getenv("DB_PASSWORD") ?: $this->DB_PASS;
        $name = getenv("DB_NAME") ?: $this->DB_NAME;

        //Cria a conexao com o banco de dados
        $this->conn = new mysqli($host, $user, $pass, $name, (int)$port);
        
        //defini o charset da conexao 
        $this->conn->set_charset("utf8");
        
        //verifica se deu erro.
        if ($this->conn->connect_errno) {
            echo "Erro ao conectar com o banco de dados.";
            exit;
        }        
    }
    
    function mysqlnull($value){
   


        if($value == 'Null')
            return $value;
        if($value == 'null')
            return $value;
        if($value == 'sysdate()')
            return $value;    
        //elseif(ereg('^[a-zA-Z_][0-9a-zA-Z]*\([^}]*)$', $value))
        elseif(preg_match('^[a-zA-Z_][0-9a-zA-Z]*\([^}]*)$', $value))   
           return $value;
        //if(strpos($value, "()"))   
        //    return $value;
        elseif(is_null($value))
            return "null";
        elseif(trim($value) == "")
            return "null";
        else
            return "'" . $this->conn->real_escape_string($value) . "'";
    }
    
    function desconectar(){
        $this->conn->close();
    }
    
    function execSQL($strSQL){
        $strSQL = $this->conn->real_escape_string($strSQL);
        $this->last_sql = $strSQL;
        $result = $this->conn->query($strSQL);
    }
    
    function execQuery($strSQL){
		
        $this->last_sql = $strSQL;

        $arrRetorno = array();
        if(!$result = $this->conn->query($strSQL)){
            echo "Erro ao executar a consulta no banco de dados";
        }
               
        if (method_exists('mysqli_result', 'fetch_all')){ # Compatibility layer with PHP < 5.3
            $arrRetorno = $result->fetch_all(MYSQLI_ASSOC);
        } else{
            $i = 0;
            while($row = $result->fetch_assoc()){
                $arrRetorno[$i] = $row;
                $i++;
            }
        }
        $result->free();
        
        return $arrRetorno;
    }
    
    
    function execInsert($table, $fields){
        if(empty($table)) return null;
    
        if(!is_array($fields)) return null;

        $into = array();
        $values = array();
        foreach($fields as $field => $value){
                $value = (!is_null($value) && empty($value) && $value != 0?'null':$value);
                $into[] = $field;
                $values[] = $this->mysqlnull($value);
        }
        $into = implode(", ", $into);

        $values = implode(", ", $values);

        $sql = "Insert Into $table ($into) Values (" . $values . ")";
        
            $this->last_sql = $sql;

            $this->conn->query($sql);
            
            return $this->conn->insert_id;        
    }
    
    function execDelete($table, $where = null){
	$sql = "delete from $table where ".$where;

        $this->last_sql = $sql;
     
        $this->conn->query($this->conn->real_escape_string($sql));
           
    }    
    
    function execUpdate($table, $fields, $where = null){

        if(empty($table)) return null;
        if(!is_array($fields)) return null;
        $set = array();
        $into = array();
        foreach($fields as $field => $value){
            $value = (!is_null($value) && empty($value) && $value != 0?'null':$value);
            $campos[] = $field;
            $into[] = $field;
            if(!empty($value) || $value == '0')
                $set[] = "$field = " . $this->mysqlnull($value);
        }
        if(empty($set)) return null;

        $into = implode(",", $into);
        $campos = implode(",", $campos);
        $sql = "Update $table Set ". implode(", ", $set);
   
        if(!empty($where)){
            $sql .= " Where $where";		
        }

        $this->last_sql = $sql;
        $this->conn->query($sql);
    }    
    


}
