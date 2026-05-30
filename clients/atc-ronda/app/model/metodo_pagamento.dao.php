<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/metodo_pagamento.class.php';


class metodo_pagamentodao{

    private $db;
    private $arrToken;

    public function __construct(){
        
        $this->db = new DataBase();
        $this->db->conectar();
        
    }
    
    public function __destruct() {
        $this->db->desconectar();
    }
    
    
    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }       
    
    public function salvar($metodo_pagamento){

        $fields = array();
        $fields['ds_metodo_pagamento'] = $metodo_pagamento->getds_metodo_pagamento();
        $fields['ic_status'] = $metodo_pagamento->getic_status();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($metodo_pagamento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("metodos_pagamento", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("metodos_pagamento", $fields, " pk = ".$metodo_pagamento->getpk());
        }

    }

    public function excluir($metodo_pagamento){
        $this->db->execDelete("metodos_pagamento"," pk = ".$metodo_pagamento->getpk());
    }

    public function carregarPorPk($pk){

        $metodo_pagamento = new metodo_pagamento();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_metodo_pagamento ";
        $sql.="       ,ic_status ";


        $sql.="  from metodos_pagamento ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $metodo_pagamento->setpk($query[$i]["pk"]);
                $metodo_pagamento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $metodo_pagamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $metodo_pagamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $metodo_pagamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $metodo_pagamento->setds_metodo_pagamento($query[$i]['ds_metodo_pagamento']);
                $metodo_pagamento->setic_status($query[$i]['ic_status']);

            }
        }
        return $metodo_pagamento;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_metodo_pagamento ";
        $sql.="       ,ic_status ";

        $sql.="  from metodos_pagamento ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_metodo_pagamento($ds_metodo_pagamento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_metodo_pagamento ";
        $sql.="       ,ic_status ";

        $sql.="  from metodos_pagamento ";
        $sql.=" where 1=1 ";
        if($ds_metodo_pagamento != ""){
            $sql.=" and ds_metodo_pagamento like '%".$ds_metodo_pagamento."%' ";
        }
        $sql.=" order by ds_metodo_pagamento asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_metodo_pagamento ";
        $sql.="       ,ic_status ";

        $sql.="  from metodos_pagamento ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_metodo_pagamento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
