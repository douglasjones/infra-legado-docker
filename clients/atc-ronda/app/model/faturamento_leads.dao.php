<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/faturamento_leads.class.php';


class faturamento_leadsdao{

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
    
    public function salvar($faturamento_leads){

        $fields = array();
        $fields['leads_pk'] = $faturamento_leads->getleads_pk();
        $fields['vl_total_bruto'] = $faturamento_leads->getvl_total_bruto();
        $fields['vl_total_faturamento'] = $faturamento_leads->getvl_total_faturamento();
        $fields['obs_faturamento_lead'] = $faturamento_leads->getobs_faturamento_lead();
        $fields['dt_cancelamento'] = $faturamento_leads->getdt_cancelamento();
        $fields['obs_cancelamento'] = $faturamento_leads->getobs_cancelamento();
        $fields['ic_starus'] = $faturamento_leads->getic_starus();
        $fields['faturamento_pk'] = $faturamento_leads->getfaturamento_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($faturamento_leads->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("faturamento_leads", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("faturamento_leads", $fields, " pk = ".$faturamento_leads->getpk());
        }

    }

    public function excluir($faturamento_leads){
        $this->db->execDelete("faturamento_leads"," pk = ".$faturamento_leads->getpk());
    }

    public function carregarPorPk($pk){

        $faturamento_leads = new faturamento_leads();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,vl_total_bruto ";
        $sql.="       ,vl_total_faturamento ";
        $sql.="       ,obs_faturamento_lead ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,ic_starus ";
        $sql.="       ,faturamento_pk ";


        $sql.="  from faturamento_leads ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $faturamento_leads->setpk($query[$i]["pk"]);
                $faturamento_leads->setdt_cadastro($query[$i]["dt_cadastro"]);
                $faturamento_leads->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $faturamento_leads->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $faturamento_leads->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $faturamento_leads->setleads_pk($query[$i]['leads_pk']);
                $faturamento_leads->setvl_total_bruto($query[$i]['vl_total_bruto']);
                $faturamento_leads->setvl_total_faturamento($query[$i]['vl_total_faturamento']);
                $faturamento_leads->setobs_faturamento_lead($query[$i]['obs_faturamento_lead']);
                $faturamento_leads->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $faturamento_leads->setobs_cancelamento($query[$i]['obs_cancelamento']);
                $faturamento_leads->setic_starus($query[$i]['ic_starus']);
                $faturamento_leads->setfaturamento_pk($query[$i]['faturamento_pk']);

            }
        }
        return $faturamento_leads;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,vl_total_bruto ";
        $sql.="       ,vl_total_faturamento ";
        $sql.="       ,obs_faturamento_lead ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,ic_starus ";
        $sql.="       ,faturamento_pk ";

        $sql.="  from faturamento_leads ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarFaturamentoPk($faturamento_pk){
        $sql ="";
        $sql.="SELECT fl.pk faturamento_pk,";
        $sql.="        l.pk leads_pk,";
        $sql.="        l.ds_lead,";
        $sql.="        empr.pk empresa_pk,";
        $sql.="        empr.ds_conta ds_empresa,";
        $sql.="        date_format(fl.dt_ini,'%d/%m/%Y') dt_ini_faturamento, ";
        $sql.="        date_format(fl.dt_fim,'%d/%m/%Y') dt_fim_faturamento, ";
        $sql.="        fl.tipo_contrato_fixo,";
        $sql.="        fl.tipo_contrato_aditivo,";
        $sql.="        fl.tipo_contrato_extra";
        $sql.=" FROM faturamento fl";
        $sql.="      INNER JOIN faturamento_emrpesas fe ON fl.pk = fe.faturamento_pk";
        $sql.="      INNER JOIN contratos ct ON fe.empresa_pk = ct.empresas_pk";
        $sql.="      INNER JOIN processos_etapas pe ON ct.processos_etapas_pk = pe.pk";
        $sql.="      INNER JOIN processos proc ON pe.processos_pk = proc.pk";
        $sql.="      INNER JOIN leads l ON proc.leads_pk = l.pk";
        $sql.="      INNER JOIN contas empr ON ct.empresas_pk = empr.pk";
        $sql.=" WHERE fl.pk=".$faturamento_pk;
        $sql.=" GROUP BY l.pk, ct.empresas_pk";
        $sql.=" ORDER BY l.ds_lead";
       
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listarContratosLeads($leads_pk,$dt_ini_faturamento,$dt_fim_faturamento,$tipo_contrato_fixo,$tipo_contrato_aditivo,$tipo_contrato_extra){
        $sql ="";
        $sql.="SELECT c.pk contratos_pk,";
        $sql.="    date_format(c.dt_inicio_contrato, '%d/%m/%Y')dt_inicio_contrato,";
        $sql.="    date_format(c.dt_fim_contrato, '%d/%m/%Y') dt_fim_contrato,";
        $sql.="    CASE";
        $sql.="       WHEN c.ic_tipo_contrato = 1 THEN 'Contrato Fixo'";
        $sql.="       WHEN c.ic_tipo_contrato = 2 THEN 'Contrato Aditivo'";
        $sql.="       WHEN c.ic_tipo_contrato = 3 THEN 'Contrato Extra'";
        $sql.="    END ds_tipo_contrato";
        $sql.=" FROM contratos c";
        $sql.="  INNER JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
        $sql.="  INNER JOIN processos p ON pe.processos_pk = p.pk";
        $sql.="  INNER JOIN leads l ON p.leads_pk = l.pk";

        $sql.=" WHERE l.pk = ".$leads_pk;
        $sql.=" AND '".DataYMD($dt_ini_faturamento)."' >= c.dt_inicio_contrato";
        $sql.=" AND '".DataYMD($dt_fim_faturamento)."' <= c.dt_fim_contrato";     
        $sql.=" GROUP BY c.pk";
        $sql.=" ORDER BY c.pk";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
     public function listarItensContrato($contratos_pk){
               
        $sql ="";
        $sql.="SELECT ci.pk contratos_itens_pk,";
        $sql.=" ps.ds_produto_servico,";
        $sql.=" ci.n_qtde,";
        $sql.=" ci.vl_unit,";
        $sql.=" ci.vl_total";
        $sql.=" FROM contratos_itens ci";
        $sql.="  INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";
        
        $sql.=" WHERE ci.contratos_pk=".$contratos_pk;
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,vl_total_bruto ";
        $sql.="       ,vl_total_faturamento ";
        $sql.="       ,obs_faturamento_lead ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,obs_cancelamento ";
        $sql.="       ,ic_starus ";
        $sql.="       ,faturamento_pk ";

        $sql.="  from faturamento_leads ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

}

?>
