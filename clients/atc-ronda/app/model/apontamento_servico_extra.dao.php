<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/apontamento_servico_extra.class.php';


class apontamento_servico_extradao{

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
    
    public function salvar($apontamento_servico_extra){

        $fields = array();
        $fields['colaborador_pk'] = $apontamento_servico_extra->getcolaborador_pk();
        $fields['dt_escala'] = $apontamento_servico_extra->getdt_escala();
        $fields['leads_pk'] = $apontamento_servico_extra->getleads_pk();
        $fields['contratos_pk'] = $apontamento_servico_extra->getcontratos_pk();
        $fields['contratos_itens_pk'] = $apontamento_servico_extra->getcontratos_itens_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_servico_extra->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_servico_extra", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("apontamento_servico_extra", $fields, " pk = ".$apontamento_servico_extra->getpk());
        }

    }

    public function excluir($apontamento_servico_extra){
        $this->db->execDelete("apontamento_servico_extra"," pk = ".$apontamento_servico_extra->getpk());
    }

    public function carregarPorPk($pk){

        $apontamento_servico_extra = new apontamento_servico_extra();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,contratos_itens_pk";


        $sql.="  from apontamento_servico_extra ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $apontamento_servico_extra->setpk($query[$i]["pk"]);
                $apontamento_servico_extra->setdt_cadastro($query[$i]["dt_cadastro"]);
                $apontamento_servico_extra->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $apontamento_servico_extra->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $apontamento_servico_extra->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $apontamento_servico_extra->setcolaborador_pk($query[$i]['colaborador_pk']);
                $apontamento_servico_extra->setdt_escala($query[$i]['dt_escala']);
                $apontamento_servico_extra->setleads_pk($query[$i]['leads_pk']);
                $apontamento_servico_extra->setcontratos_pk($query[$i]['contratos_pk']);
                $apontamento_servico_extra->setcontratos_itens_pk($query[$i]['contratos_itens_pk']);

            }
        }
        return $apontamento_servico_extra;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";

        $sql.="  from apontamento_servico_extra ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarContratos($pk){

        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk  ";
        $sql.="       ,c.empresas_pk ";

        $sql.="  from contratos c ";
        $sql.=" where c.pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_colaborador_pk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";

        $sql.="  from apontamento_servico_extra ";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and ds_apontamento_servico_extra like '%".$colaborador_pk."%' ";
        }
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarServicoExtra($colaborador_pk,$leads_pk,$dt_base){

        $sql ="";
        $sql.="select a.pk, date_format(a.dt_cadastro,'%d/%m/%Y')dt_cadastro, a.usuario_cadastro_pk, a.dt_ult_atualizacao, a.usuario_ult_atualizacao_pk ";
        $sql.="       ,a.colaborador_pk ";
        $sql.="       ,a.dt_escala ";
        $sql.="       ,a.leads_pk ";
        $sql.="       ,a.contratos_pk ";
        $sql.="       ,u.ds_usuario";

        $sql.="  from apontamento_servico_extra a";
        $sql.="  inner join usuarios u on a.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and a.colaborador_pk  =".$colaborador_pk;
        }
        if($leads_pk != ""){
            $sql.=" and a.leads_pk  =".$leads_pk;
        }
        if($dt_base != ""){
            $sql.=" and a.dt_escala ='".DataYMD($dt_base)."'";
        }
   
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLeadComServicoExtra($leads_pk){

        $sql ="";
        $sql.="select l.pk,l.ds_lead,c.pk contratos_pk,ci.pk contratos_itens_pk";

        $sql.="  from leads l ";
        $sql.="  inner join processos p on p.leads_pk = l.pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join contratos c on c.processos_etapas_pk = pe.pk";
        $sql.="  inner join contratos_itens ci on c.pk = ci.contratos_pk";
        $sql.="   left join  apontamento_servico_extra a on a.contratos_itens_pk = ci.pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=0){
            $sql.=" and l.pk =".$leads_pk;
        }
        
        $sql.=" and c.ic_tipo_contrato = 3";
        $sql.=" and a.pk is null";
        $sql.=" group by l.pk";
        $sql.=" order by l.ds_lead asc";
   
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarContratosItensApontamento($leads_pk){

        $sql ="";
        $sql.="select ci.n_qtde";
        $sql.="       ,ci.vl_unit";
        $sql.="       ,ci.vl_total";
        $sql.="       ,ci.contratos_pk";
        $sql.="       ,ci.produtos_servicos_pk";
        $sql.="       ,ci.n_qtde_dias_semana";
        $sql.="       ,ci.periodo";
        $sql.="       ,ci.vl_mao_obra";
        $sql.="       ,ps.ds_produto_servico";
        $sql.="       ,c.pk contratos_pk";
        $sql.="       ,ci.pk contratos_itens_pk";

        $sql.="  from leads l ";
        $sql.="  inner join processos p on p.leads_pk = l.pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join contratos c on c.processos_etapas_pk = pe.pk";
        $sql.="  inner join contratos_itens ci on c.pk = ci.contratos_pk";
        
        $sql.="  inner join produtos_servicos ps on ps.pk = ci.produtos_servicos_pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=0){
            $sql.=" and l.pk =".$leads_pk;
        }
        
        $sql.=" and c.ic_tipo_contrato = 3";
        $sql.=" order by l.ds_lead asc";
        
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function verificarApontamento($contratos_pk,$contratos_itens_pk){

        $sql ="";
        $sql.="select count(0)total ";

        $sql.="  from apontamento_servico_extra ";
        $sql.=" where 1=1 ";
        $sql.=" and contratos_pk= ".$contratos_pk;
        $sql.=" and contratos_itens_pk= ".$contratos_itens_pk;

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_escala ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";

        $sql.="  from apontamento_servico_extra ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
