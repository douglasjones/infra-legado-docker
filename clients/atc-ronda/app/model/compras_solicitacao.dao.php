<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/compras_solicitacao.class.php';


class compras_solicitacaodao{

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
    
    public function salvar($compras_solicitacao){

        $fields = array();
        $fields['solicitante_pk'] = $compras_solicitacao->getsolicitante_pk();
        $fields['ds_compra_solicitacao'] = $compras_solicitacao->getds_compra_solicitacao();
        $fields['dt_solicitacao'] = DataYMD($compras_solicitacao->getdt_solicitacao());
        $fields['obs_solicitacao'] = $compras_solicitacao->getobs_solicitacao();
        $fields['usuario_aprovacao_pk'] = $compras_solicitacao->getusuario_aprovacao_pk();
        $fields['dt_aprovacao'] = $compras_solicitacao->getdt_aprovacao();
        $fields['obs_aprovacao'] = $compras_solicitacao->getobs_aprovacao();
        $fields['tipo_grupo_centro_custo_pk'] = $compras_solicitacao->gettipo_grupo_centro_custo_pk();
        $fields['grupo_lancamento_centrocusto_pk'] = $compras_solicitacao->getgrupo_lancamento_centrocusto_pk();

        $fields['empresas_pk'] = $compras_solicitacao->getempresas_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($compras_solicitacao->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("compras_solicitacao", $fields);
            return $pk;
        }
        else{
            $this->db->execUpdate("compras_solicitacao", $fields, " pk = ".$compras_solicitacao->getpk());
            return $compras_solicitacao->getpk();
        }

    }

    public function excluir($compras_solicitacao){
        $this->db->execDelete("compras_solicitacao"," pk = ".$compras_solicitacao->getpk());
    }

    public function carregarPorPk($pk){

        $compras_solicitacao = new compras_solicitacao();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,solicitante_pk ";
        $sql.="       ,ds_compra_solicitacao ";
        $sql.="       ,dt_solicitacao ";
        $sql.="       ,obs_solicitacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,dt_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,tipo_grupo_centro_custo_pk ";
        $sql.="       ,grupo_lancamento_centrocusto_pk ";


        $sql.="  from compras_solicitacao ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $compras_solicitacao->setpk($query[$i]["pk"]);
                $compras_solicitacao->setdt_cadastro($query[$i]["dt_cadastro"]);
                $compras_solicitacao->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $compras_solicitacao->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $compras_solicitacao->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $compras_solicitacao->setsolicitante_pk($query[$i]['solicitante_pk']);
                $compras_solicitacao->setds_compra_solicitacao($query[$i]['ds_compra_solicitacao']);
                $compras_solicitacao->setdt_solicitacao($query[$i]['dt_solicitacao']);
                $compras_solicitacao->setobs_solicitacao($query[$i]['obs_solicitacao']);
                $compras_solicitacao->setusuario_aprovacao_pk($query[$i]['usuario_aprovacao_pk']);
                $compras_solicitacao->setdt_aprovacao($query[$i]['dt_aprovacao']);
                $compras_solicitacao->setobs_aprovacao($query[$i]['obs_aprovacao']);
                $compras_solicitacao->settipo_grupo_centro_custo_pk($query[$i]['tipo_grupo_centro_custo_pk']);
                $compras_solicitacao->setgrupo_lancamento_centrocusto_pk($query[$i]['grupo_lancamento_centrocusto_pk']);

            }
        }
        return $compras_solicitacao;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,empresas_pk ";
        $sql.="       ,solicitante_pk ";
        $sql.="       ,ds_compra_solicitacao ";
        $sql.="       ,date_format(dt_solicitacao, '%d/%m/%Y') dt_solicitacao ";        
        $sql.="       ,obs_solicitacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,date_format(dt_aprovacao, '%d/%m/%Y') dt_aprovacao";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,tipo_grupo_centro_custo_pk ";
        $sql.="       ,grupo_lancamento_centrocusto_pk ";

        $sql.="  from compras_solicitacao ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
   

    public function listar_por_solicitante_pk($empresa_pk,$solicitante_pk,$usuario_aprovacao_pk,$tipo_grupo_centro_custo_pk,$grupo_lancamento_centrocusto_pk,$ic_status,$dt_solicitacao_ini,$dt_solicitacao_fim,$dt_aprovacao_ini,$dt_aprovacao_fim){

        $sql =""; 
        $sql.=" SELECT cs.pk,";
        $sql.="       c.ds_conta ds_empresa,";
        $sql.="       u.ds_usuario ds_solicitante,";
        $sql.="       cs.solicitante_pk,";
        $sql.="       cs.ds_compra_solicitacao,";
        $sql.="       date_format(cs.dt_solicitacao, '%d/%m/%Y') dt_solicitacao,";
        /*$sql.="       CASE WHEN cs.dt_aprovacao  = 1 THEN 'Em Análise'";
        $sql.="            WHEN cs.ic_status = 2 THEN 'Aprovada'";
        $sql.="            WHEN cs.ic_status = 3 THEN 'Reprovada'";
        $sql.="       END  ds_status,";   */     
        $sql.="       case WHEN cs.dt_aprovacao is null"; 
        $sql.="          THEN 'Em Análise'";
        $sql.="          ELSE 'Aprovado'";
        $sql.="       END ds_status,";
        
        $sql.="       u1.ds_usuario ds_usuario_aprovacao,";
        $sql.="       cs.usuario_aprovacao_pk,";
        $sql.="       date_format(cs.dt_aprovacao, '%d/%m/%Y') dt_aprovacao,";
        $sql.="       CASE";
        $sql.="          WHEN cs.tipo_grupo_centro_custo_pk = 1 THEN 'Leads (Clientes)'";
        $sql.="          WHEN cs.tipo_grupo_centro_custo_pk = 2 THEN 'Colaboradores'";
        $sql.="          WHEN cs.tipo_grupo_centro_custo_pk = 4 THEN 'Centros de Custos'";
        $sql.="       END  ds_tipo_grupo_centro_custo,";   
        $sql.="       cs.tipo_grupo_centro_custo_pk, ";
        $sql.="       cs.grupo_lancamento_centrocusto_pk";
        $sql.=" FROM compras_solicitacao cs";
        $sql.="     LEFT JOIN contas c ON cs.empresas_pk = c.pk";
        $sql.="     LEFT JOIN usuarios u ON cs.solicitante_pk = u.pk";
        $sql.="     LEFT JOIN usuarios u1 ON cs.usuario_aprovacao_pk = u1.pk";
       
        $sql.="  WHERE 1=1";        
        if(!empty($empresa_pk)){
            $sql.="  AND cs.empresas_pk=".$empresa_pk;
        }
        if(!empty($solicitante_pk)){
            $sql.="  AND cs.solicitante_pk=".$solicitante_pk;
        }
        if(!empty($usuario_aprovacao_pk)){
            $sql.="  AND cs.usuario_aprovacao_pk=".$usuario_aprovacao_pk;
        }                
        if(!empty($tipo_grupo_centro_custo_pk)){
            $sql.="  AND cs.tipo_grupo_centro_custo_pk=".$tipo_grupo_centro_custo_pk;
        }           
        if(!empty($grupo_lancamento_centrocusto_pk)){
            $sql.="  AND cs.grupo_lancamento_centrocusto_pk=".$grupo_lancamento_centrocusto_pk;
        }         
        if(!empty($ic_status)){
            $sql.="  AND cs.ic_status=".$ic_status;
        }    
        if(!empty($dt_solicitacao_ini)){
            $sql.="  AND cs.dt_solicitacao >='".$dt_solicitacao_ini." 00:00:00'";
        } 
        if(!empty($dt_solicitacao_fim)){
            $sql.="  AND cs.dt_solicitacao <='".$dt_solicitacao_fim." 23:59:59'";
        } 
        if(!empty($dt_aprovacao_ini)){
            $sql.="  AND cs.dt_aprovacao >='".$dt_aprovacao_ini." 00:00:00'";
        } 
        if(!empty($dt_aprovacao_fim)){
            $sql.="  AND cs.dt_aprovacao <='".$dt_aprovacao_fim." 23:59:59'";
        } 
        $sql.=" Order by cs.pk desc";  
       // echo $sql; 

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarCentroCusto($pk,$tipo_grupo_centro_custo_pk,$grupo_lancamento_centrocusto_pk){

        $sql ="";
        $sql.="select cs.pk ";
        if($tipo_grupo_centro_custo_pk==1){
            $sql.="       ,l.ds_lead ds_grupo_lancamento_centrocusto";
        }
        if($tipo_grupo_centro_custo_pk==2){
            $sql.="       ,c.ds_colaborador ds_grupo_lancamento_centrocusto";
        }        

        if($tipo_grupo_centro_custo_pk==3){
            $sql.="       ,f.ds_fornecedor ds_grupo_lancamento_centrocusto";
        }   

        $sql.="  from compras_solicitacao cs ";
        if($tipo_grupo_centro_custo_pk==1){
            $sql.=" INNER JOIN leads l on l.pk = cs.grupo_lancamento_centrocusto_pk";
        }
        if($tipo_grupo_centro_custo_pk==2){
            $sql.=" INNER JOIN colaboradores c on cs.pk = c.grupo_lancamento_centrocusto_pk";
        }
        if($tipo_grupo_centro_custo_pk==2){
            $sql.=" INNER JOIN fornecedor f on f.pk = cs.grupo_lancamento_centrocusto_pk";
        }
        $sql.=" where cs.pk=".$pk;

        if($tipo_grupo_centro_custo_pk==1){
            $sql.=" AND l.pk = ".$grupo_lancamento_centrocusto_pk;
        }
        if($tipo_grupo_centro_custo_pk==2){
            $sql.=" and c.pk =".$grupo_lancamento_centrocusto_pk;
        }
        if($tipo_grupo_centro_custo_pk==2){
            $sql.=" AND f.pk = ".$grupo_lancamento_centrocusto_pk;
        }
        $sql.=" order by cs.pk desc";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,solicitante_pk ";
        $sql.="       ,ds_compra_solicitacao ";
        $sql.="       ,dt_solicitacao ";
        $sql.="       ,obs_solicitacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,dt_aprovacao ";
        $sql.="       ,obs_aprovacao ";
        $sql.="       ,tipo_grupo_centro_custo_pk ";
        $sql.="       ,grupo_lancamento_centrocusto_pk ";

        $sql.="  from compras_solicitacao ";
        $sql.=" where 1=1 ";
        $sql.=" order by solicitante_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
