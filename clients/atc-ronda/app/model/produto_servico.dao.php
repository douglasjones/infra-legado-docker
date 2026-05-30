<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/produto_servico.class.php';


class produto_servicodao{

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
    
    public function salvar($produto_servico){

        $fields = array();
        $fields['ds_produto_servico'] = $produto_servico->getds_produto_servico();
        $fields['ds_obs'] = $produto_servico->getds_obs();
        $fields['ic_status'] = 1;
        $fields['ds_cbo'] = $produto_servico->getds_cbo();
        $fields['vl_servico'] = moeda2float($produto_servico->getvl_servico());
        //$fields['polos_pk'] = $produto_servico->getpolos_pk();
        //$fields['tipos_unidades_pk'] = $produto_servico->gettipos_unidades_pk();
        //$fields['fornecedor_pk'] = $produto_servico->getfornecedor_pk();
        


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($produto_servico->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("produtos_servicos", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("produtos_servicos", $fields, " pk = ".$produto_servico->getpk());
        }

    }

    public function excluir($produto_servico){
        $this->db->execDelete("produtos_servicos"," pk = ".$produto_servico->getpk());
    }

    public function carregarPorPk($pk){

        $produto_servico = new produto_servico();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_produto_servico ";


        $sql.="  from produtos_servicos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $produto_servico->setpk($query[$i]["pk"]);
                $produto_servico->setdt_cadastro($query[$i]["dt_cadastro"]);
                $produto_servico->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $produto_servico->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $produto_servico->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $produto_servico->setds_produto_servico($query[$i]['ds_produto_servico']);

            }
        }
        return $produto_servico;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_produto_servico ";
        $sql.="       ,ds_cbo ";
        $sql.="       ,vl_servico ";
        $sql.="  from produtos_servicos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarProdutosContrato($contratos_pk){

        $sql ="";
        $sql.="SELECT ps.pk,";
        $sql.=" ps.ds_produto_servico";
        $sql.=" FROM produtos_servicos ps";
        $sql.="     INNER JOIN contratos_itens ci ON ci.produtos_servicos_pk = ps.pk";
        $sql.=" WHERE ci.contratos_pk =".$contratos_pk;
        //$sql.=" AND ps.ic_status = 1";
        $sql.=" ORDER by  ps.ds_produto_servico";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    //ANTIGO
    public function listar_por_ds_produto_servico($ds_produto_servico,$ds_cob){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_produto_servico ";
        $sql.="       ,ds_cbo ";
        $sql.="  from produtos_servicos ";
        $sql.=" where 1=1 ";
        if($ds_produto_servico != ""){
            $sql.=" and ds_produto_servico like '%".$ds_produto_servico."%' ";
        }
         if($ds_cbo != ""){
            $sql.=" and ds_cbo =".$ds_cbo;
        }
        $sql.=" order by ds_produto_servico asc ";
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_por_leads_pk($leads_pk,$contratos_pk,$colaborador_pk){

        $sql ="";
        $sql.="select  p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.ds_produto_servico ";
        $sql.="       ,p.pk ";
        $sql.="       ,ci.pk contratos_itens_pk ";
        $sql.="  from produtos_servicos p ";
        $sql.="     inner join contratos_itens ci on p.pk = ci.produtos_servicos_pk";
        $sql.="     left join colaboradores_produtos_servicos cps on cps.produtos_servicos_pk = p.pk";
        $sql.=" where 1=1 ";    
        if($colaborador_pk!=""){
            $sql.=" AND cps.colaboradores_pk =".$colaborador_pk;
        }
        if($contratos_pk!=""){
            $sql.=" AND ci.contratos_pk=".$contratos_pk;
        }
        
        
        if($leads_pk!=""){
            $sql.=" and p.pk in (SELECT  cti.produtos_servicos_pk FROM  contratos ctt INNER JOIN contratos_itens cti ON ctt.pk = cti.contratos_pk inner JOIN processos_etapas pet ON pet.pk = ctt.processos_etapas_pk INNER JOIN   processos prs ON prs.pk = pet.processos_pk WHERE prs.leads_pk = $leads_pk ";
            if($contratos_pk!=""){
                $sql.=" and ctt.pk = ".$contratos_pk;
            }
            
            $sql.=" GROUP BY cti.produtos_servicos_pk)";
        }
        $sql.=" group by p.pk";
        $sql.=" order by p.ds_produto_servico asc ";   

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_produto_servico ";

        $sql.="  from produtos_servicos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_produto_servico asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listar_qualificacao_colaboradores($colaboradores_pk){

        $sql ="";
        $sql.="select produtos_servicos_pk, colaboradores_pk, ic_possui_treinamento, ic_possui_certificado";
        $sql.="  from colaboradores_produtos_servicos ";
        $sql.=" where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and colaboradores_pk = ".$colaboradores_pk;
        }
        $sql.=" order by produtos_servicos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarFuncaoColaborador($colaboradores_pk){

        $sql ="";
        $sql.="select cps.produtos_servicos_pk, cps.colaboradores_pk, cps.ic_possui_treinamento, cps.ic_possui_certificado";
        $sql.="     ,group_concat(ps.ds_produto_servico)ds_produto_servico";
        $sql.="  from colaboradores_produtos_servicos cps ";
        $sql.="     inner join produtos_servicos ps on cps.produtos_servicos_pk = ps.pk";
        $sql.=" where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and colaboradores_pk = ".$colaboradores_pk;
        }
        $sql.=" order by produtos_servicos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function adicionarProdutosServicosColaboradores($colaboradores_pk, $produtos_servicos_pk, $ic_possui_treinamento,$ic_possui_certificado){
        
        $fields = array();
        $fields['colaboradores_pk'] = $colaboradores_pk;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
        $fields['ic_possui_treinamento'] = $ic_possui_treinamento;
        $fields['ic_possui_certificado'] = $ic_possui_certificado;
        
        $this->db->execInsert("colaboradores_produtos_servicos", $fields);
        
    }
    
    function excluirProdutosServicosColaboradoresPk($colaboradores_pk){
        $this->db->execDelete("colaboradores_produtos_servicos", " colaboradores_pk = " . $colaboradores_pk);
    }

}

?>
