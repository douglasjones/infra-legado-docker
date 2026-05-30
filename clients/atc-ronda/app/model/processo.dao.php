<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/processo.class.php';


class processodao{

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
    
    public function salvar($processo){
        
        $fields = array();
        $fields['ds_processo'] = $processo->getds_processo();
        $fields['processos_default_pk'] = $processo->getprocessos_default_pk();
        $fields['leads_pk'] = $processo->getleads_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($processo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            
            $pk = $this->db->execInsert("processos", $fields);
            
            //Inclui as etapas
            $sql = "";
            $sql.="insert into processos_etapas (dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, ds_processo_etapa, n_ordem_etapa, processos_pk) ";
            $sql.="select SYSDATE(), ".$this->arrToken['usuarios_pk'].", SYSDATE(), ".$this->arrToken['usuarios_pk'].", ds_processo_default_etapa, n_ordem_etapa, $pk ";
            $sql.="  from processos_default_etapas ";
            $sql.=" where processos_default_pk = ".$processo->getprocessos_default_pk();
            
            $this->db->execSQL($sql);
 
            return $pk;
        }else{
            return $this->db->execUpdate("processos", $fields, " pk = ".$processo->getpk());
        }

    }

    public function excluir($processo){
        $this->db->execDelete("processos"," pk = ".$processo->getpk());
    }

    public function carregarPorPk($pk){

        $processo = new processo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_processo";
        $sql.="       ,processos_default_pk";
        $sql.="       ,leads_pk ";


        $sql.="  from processos";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $processo->setpk($query[$i]["pk"]);
                $processo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $processo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $processo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $processo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $processo->setds_processo($query[$i]['ds_processo']);
                $processo->setprocessos_default_pk($query[$i]['processos_default_pk']);
                $processo->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $processo;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo ";
        $sql.="       ,p.processos_default_pk ";
        $sql.="       ,p.leads_pk ";
        $sql.="       ,l.ds_lead";
        $sql.="  from processos p";
        $sql.="       inner join leads l on p.leads_pk = l.pk";
        $sql.=" where p.pk = $pk ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
       
    
    public function verificarQtdeLead($leads_pk){

        $sql ="";
        $sql.="select count(0)qtde";
        $sql.="  from processos p";
        $sql.=" where p.leads_pk = $leads_pk ";
        $sql.=" and ds_processo = 'Operacional'";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEtapasPorPk($pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo_etapa ";
        $sql.="       ,p.n_ordem_etapa ";
        $sql.="       ,CONCAT( p.n_ordem_etapa, '. ', p.ds_processo_etapa )etapas ";
        $sql.="  from processos_etapas p";
        $sql.=" where p.processos_pk = $pk ";
        $sql.=" group by etapas";
        $sql.=" order by etapas";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEtapasPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo_etapa ";
        $sql.="       ,p.n_ordem_etapa ";
        $sql.="       ,p.processos_pk";
        $sql.="       ,CONCAT( p.n_ordem_etapa, '. ', p.ds_processo_etapa )etapas ";
        $sql.="  from processos_etapas p";
        $sql.="       inner join processos ps on ps.pk = p.processos_pk";
        $sql.=" where ps.leads_pk = $leads_pk ";
        $sql.="  and p.ds_processo_etapa like '%Agenda%'";
        $sql.=" group by etapas";
        $sql.=" order by etapas";
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorLeadsPk($leads_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk  ";
        $sql.="       ,p.ds_processo ";
        $sql.="       ,p.processos_default_pk ";
        $sql.="       ,p.leads_pk ";
        $sql.="       ,pe.pk processos_etapas_pk ";

        $sql.="  from processos_etapas pe ";
        $sql.="  inner join processos p on pe.processos_pk = p.pk";
        $sql.=" where leads_pk = $leads_pk ";
        $sql.=" group by p.pk";
    
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_processo_default($ds_processo_default){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from processos_default ";
        $sql.=" where 1=1 ";
        if($ds_processo_default != ""){
            $sql.=" and ds_processo_default like '%".$ds_processo_default."%' ";
        }
        $sql.=" order by ds_processo_default asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_processo ";
        $sql.="       ,processos_default_pk ";
        $sql.="       ,leads_pk ";

        $sql.="  from processos_default ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_processo_default asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function adicionarProcessosEtapas($processo_pk, $ds_processo_etapa, $n_ordem_etapa,$dt_fim,$equipes_pk){
        
        $fields = array();
        $fields["dt_cadastro"] = "sysdate()";
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields['ds_processo_etapa'] = $ds_processo_etapa;
        $fields['n_ordem_etapa'] = $n_ordem_etapa;
        $fields['processos_pk'] = $processo_pk;
        $fields['dt_fim'] = $dt_fim;
        $fields['equipes_pk'] = $equipes_pk;
        
        $this->db->execInsert("processos_etapas", $fields);
        
    }
    
    function excluirProcessosEtapasPk($processo_pk){
      
        $this->db->execDelete("processos_etapas", " processos_pk = " . $processo_pk);
    }
    function excluirContratos($processo_etapas_pk){
      
        $this->db->execDelete("contratos", " processos_etapas_pk = " . $processo_etapas_pk);
    }
    function excluirAgendaColaborador($processo_etapas_pk){
      
        $this->db->execDelete("agenda_colaborador_padrao", " processos_etapas_pk = " . $processo_etapas_pk);
    }

}

?>
