<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';


class financeiro_conciliacao_lancamentosdao{

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

    public function salvar($financeiro_conciliacao_lancamentos){
 
        $fields = array();
        $fields['lancamentos_pk'] = $financeiro_conciliacao_lancamentos['lancamentos_pk'];
        $fields['financeiro_conciliacao_banco_itens_pk'] = $financeiro_conciliacao_lancamentos['financeiro_conciliacao_banco_itens_pk'];
        $fields['obs'] = $financeiro_conciliacao_lancamentos['obs'];
        $fields['ic_status'] = $financeiro_conciliacao_lancamentos['ic_status'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($financeiro_conciliacao_lancamentos['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("financeiro_conciliacao_lancamentos", $fields);
        }
        else{
            $this->db->execUpdate("financeiro_conciliacao_lancamentos", $fields, " pk = ".$financeiro_conciliacao_lancamentos['pk']);
        }



        return $pk;

    }
    public function excluir($pk){
        
        $this->db->execDelete("financeiro_conciliacao_lancamentos"," pk = ".$pk);
    }
}

?>
