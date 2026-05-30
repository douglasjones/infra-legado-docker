<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
//require_once "../controller/comercial.controller.php";

class comercialdao{

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

    public function salvarProcessoMovimentacaoStatus($processo_default_configuracao_pk, $modulos_pk, $processo_movimentacao_status_pk_pai, $ic_cartao_movimentado){
        $fields['processo_default_configuracao_pk'] = $processo_default_configuracao_pk;
        $fields['modulos_pk'] = $modulos_pk;
        $fields['tipo_modulos_sistema_pk'] = '1';
        $fields['processo_movimentacao_status_pk_pai'] = $processo_movimentacao_status_pk_pai;
        $fields['ic_cartao_movimentado'] = $ic_cartao_movimentado;
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];

        $this->db->execInsert("processo_movimentacao_status", $fields);

        if($processo_movimentacao_status_pk_pai != ""){
            $fields['ic_cartao_movimentado'] = 1;
            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];

            $this->db->execUpdate("processo_movimentacao_status", $fields, " pk = ".$processo_movimentacao_status_pk_pai);
        }
    }

    public function salvarProcessoMovimentacaoPesquisa($modulos_pk){
        $message = "";
        $sqlProcessoInicial = "select pk from processo_default_configuracao where ds_processo_default_configuracao = 'Prospect - Target'";
        $queryProcessoInicial = $this->db->execQuery($sqlProcessoInicial);
        if($modulos_pk != ""){
            $arrModulos = json_decode ($modulos_pk, true);
            for($i=0; $i<count($arrModulos); $i++){
                
                $sql = "Select modulos_pk from processo_movimentacao_status where modulos_pk =".$arrModulos[$i];
                $query = $this->db->execQuery($sql);
                if(count($query) == 0){
                    $fields['processo_default_configuracao_pk'] = $queryProcessoInicial[0]['pk'];
                    $fields['tipo_modulos_sistema_pk'] = '1';
                    $fields['modulos_pk'] = $arrModulos[$i];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];
    
                    $this->db->execInsert("processo_movimentacao_status", $fields);

                    $message = 'Registro adicionado com sucesso ao painel.';     
                }else{
                    $sqlVerificacao = "Select modulos_pk from processo_movimentacao_status where ic_cartao_movimentado IS NULL and processo_default_configuracao_pk < ".$queryProcessoInicial[0]['pk']." and modulos_pk =".$arrModulos[$i];
                    $queryVerificacao = $this->db->execQuery($sqlVerificacao);
                    if(count($queryVerificacao)==0){
                        $fields['processo_default_configuracao_pk'] = $queryProcessoInicial[0]['pk'];
                        $fields['tipo_modulos_sistema_pk'] = '1';
                        $fields['modulos_pk'] = $arrModulos[$i];
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"]   = $this->arrToken['usuarios_pk'];
                        $this->db->execInsert("processo_movimentacao_status", $fields);
                        $message = 'Registro adicionado com sucesso ao painel.';    
                    }else{
                        $message = 'Lead '.$arrModulos[$i].' está em movimentação no painel, e não pode ser adicionado.';    
                    }
                }
            }
        }
        return $message;
    }

    public function verificacaoModuloObrigatorio($processo_default_configuracao_pk){

        $sql = "";
        $sql .="SELECT pk, ds_processo_default_configuracao";
        $sql .="  FROM processo_default_configuracao";
        $sql .=" WHERE pk =".$processo_default_configuracao_pk;
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function pesquisarModuloAgenda($modulos_pk){

        $sql = "";
        $sql .="select pk from agendas where leads_pk =".$modulos_pk;
        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
