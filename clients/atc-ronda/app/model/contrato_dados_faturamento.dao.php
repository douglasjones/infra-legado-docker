<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/contrato_dados_faturamento.class.php';


class contrato_dados_faturamentodao{

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
    
    public function salvar($contrato_dados_faturamento){

        $fields = array();
        $fields['metodos_pagamento_pk'] = $contrato_dados_faturamento->getmetodos_pagamento_pk();
        $fields['num_parcela'] = $contrato_dados_faturamento->getnum_parcela();
        $fields['dt_pagamento'] = $contrato_dados_faturamento->getdt_pagamento();
        $fields['dt_faturamento'] = $contrato_dados_faturamento->getdt_faturamento();
        $fields['vl_servico'] = $contrato_dados_faturamento->getvl_servico();
        $fields['contratos_pk'] = $contrato_dados_faturamento->getcontratos_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($contrato_dados_faturamento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("contrato_dados_faturamento", $fields);
 
            return $pk;
        }
        else{
            return $this->db->execUpdate("contrato_dados_faturamento", $fields, " pk = ".$contrato_dados_faturamento->getpk());
        }

    }

    public function excluir($contrato_dados_faturamento){
        $this->db->execDelete("contrato_dados_faturamento"," pk = ".$contrato_dados_faturamento->getpk());
    }

    public function carregarPorPk($pk){

        $contrato_dados_faturamento = new contrato_dados_faturamento();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,num_parcela ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_servico ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_faturamento";


        $sql.="  from contrato_dados_faturamento ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $contrato_dados_faturamento->setpk($query[$i]["pk"]);
                $contrato_dados_faturamento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $contrato_dados_faturamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $contrato_dados_faturamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $contrato_dados_faturamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $contrato_dados_faturamento->setmetodos_pagamento_pk($query[$i]['metodos_pagamento_pk']);
                $contrato_dados_faturamento->setnum_parcela($query[$i]['num_parcela']);
                $contrato_dados_faturamento->setdt_pagamento($query[$i]['dt_pagamento']);
                $contrato_dados_faturamento->setvl_servico($query[$i]['vl_servico']);
                $contrato_dados_faturamento->setcontratos_pk($query[$i]['contratos_pk']);
                $contrato_dados_faturamento->setdt_faturamento($query[$i]['dt_faturamento']);

            }
        }
        return $contrato_dados_faturamento;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,num_parcela ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_servico ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_faturamento";

        $sql.="  from contrato_dados_faturamento ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarGridContratoDadosFaturamento($contratos_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,num_parcela ";
        $sql.="       ,date_format(dt_pagamento,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,vl_servico ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,date_format(dt_faturamento,'%d/%m/%Y')dt_faturamento";

        $sql.="  from contrato_dados_faturamento ";
        $sql.=" where contratos_pk = $contratos_pk ";
        $sql.=" order by dt_pagamento asc";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_metodos_pagamento_pk($metodos_pagamento_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,num_parcela ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_servico ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_faturamento";

        $sql.="  from contrato_dados_faturamento ";
        $sql.=" where 1=1 ";
        if($metodos_pagamento_pk != ""){
            $sql.=" and ds_contrato_dados_faturamento like '%".$metodos_pagamento_pk."%' ";
        }
        $sql.=" order by metodos_pagamento_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function addMes($dt_base,$mes){
        if($dt_base==""){
            $sql ="";
            $sql.="SELECT date_format(DATE_ADD(CURRENT_DATE(), INTERVAL ".$mes." MONTH),'%d/%m/%Y')dt_base; ";
        }
        else{
            $sql ="";
            $sql.="SELECT date_format(DATE_ADD('".DataYMD($dt_base)."', INTERVAL ".$mes." MONTH),'%d/%m/%Y')dt_base; ";
        }
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,num_parcela ";
        $sql.="       ,dt_pagamento ";
        $sql.="       ,vl_servico ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,dt_faturamento";

        $sql.="  from contrato_dados_faturamento ";
        $sql.=" where 1=1 ";
        $sql.=" order by metodos_pagamento_pk asc ";
   
        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
