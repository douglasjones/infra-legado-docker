<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/documento.class.php';


class documentodao{

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
    
    public function salvar($documento){
        $fields = array();
        $fields['ds_documento'] = $documento->getds_documento();
        $fields['ds_obs'] = $documento->getds_obs();
        $fields['ds_nome_original'] = $documento->getds_nome_original();
        $fields['colaboradores_pk'] = $documento->getcolaboradores_pk();
        $fields['leads_pk'] = $documento->getleads_pk();
        $fields['contratos_pk'] = $documento->getcontratos_pk();
        $fields['ocorrencias_pk'] = $documento->getocorrencias_pk();
        $fields['agenda_colaborador_tarefa_pk'] = $documento->getagenda_colaborador_tarefa_pk();
        $fields['lancamentos_pk'] = $documento->getlancamentos_pk();
        $fields['compras_pk'] = $documento->getcompras_pk();
        $fields['agendas_pk'] = $documento->getagendas_pk();
        $fields['ic_tipo_documento'] = $documento->getic_tipo_documento();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($documento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("documentos", $fields);

        }
        else{
            $pk = $this->db->execUpdate("documentos", $fields, " pk = ".$documento->getpk());
        }
        return $pk;

    }

    public function excluir($documento){
        $this->db->execDelete("documentos"," pk = ".$documento->getpk());
    }
    

    public function carregarPorPk($pk){

        $documento = new documento();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk";
        $sql.="       ,lancamentos_pk";


        $sql.="  from documentos ";
        $sql.=" where pk = $pk ";
        
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $documento->setpk($query[$i]["pk"]);
                $documento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $documento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $documento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $documento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $documento->setds_documento($query[$i]['ds_documento']);
                $documento->setds_obs($query[$i]['ds_obs']);
                $documento->setds_nome_original($query[$i]['ds_nome_original']);
                $documento->setcolaboradores_pk($query[$i]['colaboradores_pk']);
                $documento->setleads_pk($query[$i]['leads_pk']);
                $documento->setcontratos_pk($query[$i]['contratos_pk']);
                $documento->setocorrencias_pk($query[$i]['ocorrencias_pk']);
                $documento->setagenda_colaborador_tarefa_pk($query[$i]['agenda_colaborador_tarefa_pk']);
                $documento->setlancamentos_pk($query[$i]['lancamentos_pk']);

            }
        }
        return $documento;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk";
        $sql.="       ,lancamentos_pk";

        $sql.="  from documentos ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_documento($ds_documento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk";
        $sql.="       ,lancamentos_pk";

        $sql.="  from documentos ";
        $sql.=" where 1=1 ";
        if($ds_documento != ""){
            $sql.=" and ds_documento like '%".$ds_documento."%' ";
        }
        $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_documetos_lead($leads_pk,$ic_tipo_documento){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.colaboradores_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.="       left join colaboradores c on d.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and d.leads_pk =".$leads_pk;
        }
        if(!empty($ic_tipo_documento)){
            $sql.=" and d.ic_tipo_documento =".$ic_tipo_documento;
        }


        $sql.=" order by d.pk desc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarDocumentosTarefa($tarefas_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.colaboradores_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.="       left join colaboradores c on d.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($tarefas_pk != ""){
            $sql.=" and d.agenda_colaborador_tarefa_pk =".$tarefas_pk;
        }
        $sql.=" order by d.ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;
    }
        
    public function listar_documetos_colaboradores($colaboradores_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.colaboradores_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.="       left join colaboradores c on d.colaboradores_pk = c.pk";
        $sql.=" where 1=1 ";
        if($colaboradores_pk != ""){
            $sql.=" and d.colaboradores_pk =".$colaboradores_pk;
        }
        $sql.=" order by d.ds_documento asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk";
        $sql.="       ,lancamentos_pk";

        $sql.="  from documentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_documento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosLead($leads_pk){

        $sql ="";
        $sql.="select count(*) total from documentos where leads_pk = $leads_pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosAgendas(){

        $sql ="";
        $sql.="select count(*) total from documentos where agendas_pk is not null";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosCompra(){

        $sql ="";
        $sql.="select count(*) total from documentos ";
      

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosColaborador($colaboradores_pk){

        $sql ="";
        $sql.="select count(*) total from documentos where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and colaboradores_pk = $colaboradores_pk";
        }
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQuantidadeDocumentosLancamentos($lancamentos_pk){

        $sql ="";
        $sql.="select count(*) total from documentos where 1=1 ";
        if($lancamentos_pk!=""){
            $sql.=" and lancamentos_pk = $lancamentos_pk";
        }
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function excluirDocumentoColaboradoresPk($colaboradores_pk){
        $this->db->execDelete("documentos"," colaboradores_pk = ".$colaboradores_pk);
    }
    
    public function listar_por_colaboradores_pk($colaboradores_pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_documento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,ds_nome_original ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,contratos_pk ";
        $sql.="       ,ocorrencias_pk ";
        $sql.="       ,agenda_colaborador_tarefa_pk";
        $sql.="       ,lancamentos_pk";

        $sql.="  from documentos ";
        $sql.=" where 1=1 ";
        $sql.=" and colaboradores_pk = ".$colaboradores_pk;
        $sql.=" order by ds_documento asc ";
        
         $query = $this->db->execQuery($sql);
        return $query;
    }
     public function listar_documetos_ocorrencia($ocorrencias_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.=" where 1=1 ";
        if($ocorrencias_pk != ""){
            $sql.=" and d.ocorrencias_pk =".$ocorrencias_pk;
        }
        $sql.=" order by d.ds_documento asc ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
     public function listarDocumentosAgenda($agendas_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.=" where 1=1 ";
        if($agendas_pk != ""){
            $sql.=" and d.agendas_pk =".$agendas_pk;
        }
        $sql.=" order by d.ds_documento asc ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
     public function listar_documetos_lancamentos($lancamentos_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.=" where 1=1 ";
        if($lancamentos_pk != ""){
            $sql.=" and d.lancamentos_pk =".$lancamentos_pk;
        }
        $sql.=" order by d.ds_documento asc ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listar_documetos_compras($compras_pk){

        $sql ="";
        $sql.="select d.pk, d.dt_cadastro, d.usuario_cadastro_pk, d.dt_ult_atualizacao, d.usuario_ult_atualizacao_pk ";
        $sql.="       ,d.ds_documento ";
        $sql.="       ,d.ds_obs ";
        $sql.="       ,d.ds_nome_original ";
        $sql.="       ,d.leads_pk ";
        $sql.="       ,d.contratos_pk ";
        $sql.="       ,d.ocorrencias_pk ";
        $sql.="       ,d.agenda_colaborador_tarefa_pk";
        $sql.="       ,d.lancamentos_pk";

        $sql.="  from documentos d";
        $sql.=" where 1=1 ";
        if($compras_pk != ""){
            $sql.=" and d.compras_pk =".$compras_pk;
        }
        $sql.=" order by d.ds_documento asc ";
        $query = $this->db->execQuery($sql);
        return $query;
    }

}

?>
