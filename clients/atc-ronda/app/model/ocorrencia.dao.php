<?php

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/ocorrencia.class.php';

class ocorrenciadao{
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
    
    public function salvar($ocorrencia){
        $fields = array();
        $fields['ds_ocorrencia'] = $ocorrencia->getds_ocorrencia();
        $fields['tipos_ocorrencias_pk'] = $ocorrencia->gettipos_ocorrencias_pk();
        $fields['processos_etapas_pk'] = $ocorrencia->getprocessos_etapas_pk();
        $fields['leads_pk'] = $ocorrencia->getleads_pk();
        $fields['ic_recusa'] = $ocorrencia->getic_recusa();
        $fields['colaborador_pk'] = $ocorrencia->getcolaborador_pk();
        if($ocorrencia->getdt_prazo_execucao()!=""){
            $fields['dt_prazo_execucao'] = DataYMD($ocorrencia->getdt_prazo_execucao());
            $fields['dt_visualizacao'] = "sysdate()";
        }
        
        
        if($ocorrencia->getdt_fechamento()== 1){
            $fields['dt_fechamento'] = "sysdate()";
        }
        if($ocorrencia->getdt_fechamento()== 2){
            $fields['dt_fechamento'] = " ";
        }
        
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["clientes_pk"] = $ocorrencia->getclientes_pk();
        $fields["obs_execucao"] = $ocorrencia->getobs_execucao();
        $fields["obs_recusa"] = $ocorrencia->getobs_recusa();

        if($ocorrencia->getpk()  == ""){			
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            $pk = $this->db->execInsert("ocorrencias", $fields);

            return $pk;
        }else{						
            return $this->db->execUpdate("ocorrencias", $fields, " pk = ".$ocorrencia->getpk());			
        }
	
    }

    public function excluir($ocorrencia){
       
        $this->db->execDelete("ocorrencias"," pk = ".$ocorrencia->getpk());
    }

    public function carregarPorPk($pk){

        $ocorrencia = new ocorrencia();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,dt_prazo_execucao ";
        $sql.="       ,clientes_pk";
        $sql.="       ,obs_execucao";
        $sql.="       ,obs_recusa";
        $sql.="       ,colaborador_pk";


        $sql.="  from ocorrencias ";
        $sql.=" where pk = $pk ";

            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ocorrencia->setpk($query[$i]["pk"]);
                $ocorrencia->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ocorrencia->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ocorrencia->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ocorrencia->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ocorrencia->setds_ocorrencia($query[$i]['ds_ocorrencia']);
                $ocorrencia->settipos_ocorrencias_pk($query[$i]['tipos_ocorrencias_pk']);
                $ocorrencia->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $ocorrencia->setdt_fechamento($query[$i]['dt_fechamento']);
                $ocorrencia->setleads_pk($query[$i]['leads_pk']);
                $ocorrencia->setic_recusa($query[$i]['ic_recusa']);
                

            }
        }
        return $ocorrencia;
    }
    
    public function listarOcorrenciaClientes($leads_pk,$dt_cadastro_ini,$dt_cadastro_fim,$tipos_ocorrencias_pk,$oc_aberta_fechado,$leads_usuarios_pk){

        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,r.responsavel_pk";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,e1.ds_equipe equipe_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,o.ic_recusa ";       
        $sql.="       ,o.clientes_pk";
        $sql.="       ,o.obs_execucao";
        $sql.="       ,o.obs_recusa";
        $sql.="       ,o.colaborador_pk";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,date_format(o.dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN colaboradores c on o.colaborador_pk = c.pk";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  LEFT JOIN equipes e1 on r.equipes_pk = e1.pk ";
                
        $sql.=" where 1=1 ";
        //$sql.=" and o.usuario_cadastro_pk = ".$this->arrToken['usuarios_pk'];
        

        if(!empty($leads_usuarios_pk)){
            $sql.=" and o.leads_pk = ".$leads_usuarios_pk;
        }else{
            $sql.=" and l.pk = ".$leads_pk;
            $sql.=" or l.leads_pai_pk = ".$leads_pk;
        }
        
        if($oc_aberta_fechado != ""){
            if($oc_aberta_fechado==1){
                $sql.=" and dt_prazo_execucao is null";
            }else if($oc_aberta_fechado==2){
                $sql.=" and o.dt_prazo_execucao >=".date("Y-m-d") ;
                $sql.=" and o.dt_fechamento is null ";
                $sql.=" and o.ic_recusa !=1 ";
            }else if($oc_aberta_fechado==3){
                $sql.=" and o.dt_prazo_execucao < ".date("Y-m-d") ;
            }else if($oc_aberta_fechado==4){
                $sql.=" and o.ic_recusa =1 ";
            }else if($oc_aberta_fechado==5){
                $sql.=" and o.ic_recusa !=1 ";
                $sql.=" and o.dt_fechamento is not null ";
            }                
        }
       
        if($tipos_ocorrencias_pk != ""){
            $sql.=" and o.tipos_ocorrencias_pk = ".$tipos_ocorrencias_pk;
        }
        if($dt_cadastro_ini != ""){
            $sql.=" and o.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        
        $sql.=" Group by o.pk ";
        $sql.="       ORDER BY o.dt_cadastro desc";

        $query = $this->db->execQuery($sql);
        return $query;

        
    }
    
    
    // antigo
    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_recusa ";
        $sql.="       ,date_format(dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="       ,date_format(dt_cadastro,'%d/%m/%Y %H:%i:%s')dt_cadastro_email";
        $sql.="       ,date_format(dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";
        $sql.="       ,clientes_pk";
        $sql.="       ,obs_execucao";
        $sql.="       ,obs_recusa";
        $sql.="       ,colaborador_pk";

        $sql.="  from ocorrencias ";
        $sql.=" where pk = $pk ";
        
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarOcorrenciaPorPk($pk){
        

        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,o.colaborador_pk";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y') dt_prazo_execucao";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,r.responsavel_pk";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,e1.ds_equipe equipe_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,r.pk retornos_pk";  
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  LEFT JOIN equipes e1 on r.equipes_pk = e1.pk ";                
        $sql.=" Where o.pk = ".$pk;
        $sql.=" Group by o.pk ";
        
        $query = $this->db->execQuery($sql);

        for($i = 0; $i < count($query); $i++){
                                
            $ds_status = "";

            if($query[$i]["ic_recusa"]=="1"){
                $ds_status = "Chamado recusado";
            }
            else if ($query[$i]['dt_prazo_execucao']=="") {
                $ds_status = "Não lido";    
            }
            else if ($query[$i]['dt_fechamento'] !=''){
                $ds_status = "Finalizado"; 
            }
            else if ($query[$i]['dt_prazo_execucao'] >= date("d/m/Y")  ){
                $ds_status = "Dentro do prazo"; 
            }
            else if ($query[$i]['dt_prazo_execucao'] < date("d/m/Y")  ){
                $ds_status = "Chamado atrasado"; 
            }
            
            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_lead"=>$query[$i]['ds_lead'],
                "dt_cadastro"=>$query[$i]['dt_cadastro'],                    
                "colaborador_pk"=>$query[$i]['colaborador_pk'],                    
                "ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                "tipos_ocorrencias_pk"=>$query[$i]['tipos_ocorrencias_pk'],
                "ds_ocorrencia"=>wordwrap($query[$i]['ds_ocorrencia'], 30, "<br />\n"),
                "nome_usuario_cadastro"=>$query[$i]['nome_usuario_cadastro'],
                "dt_fechamento"=>$query[$i]['dt_fechamento'],
                "agendado_para"=>$query[$i]['nome_agendado_para'],
                "dt_retorno"=>$query[$i]['dt_retorno'],
                "ds_retorno"=>wordwrap($query[$i]['ds_retorno'], 30, "<br />\n"),
                "dt_termino_retorno"=>$query[$i]['dt_termino_retorno'],                    
                "ds_tipo_ocorrencia"=>$query[$i]['ds_tipo_ocorrencia'],
                "ds_processo_etapa"=>$query[$i]['ds_processo_etapa'],
                "ds_processo"=>$query[$i]['ds_processo'],  
                "dt_prazo_execucao"=>$query[$i]['dt_prazo_execucao'], 
                "retornos_pk"=>$query[$i]['retornos_pk'],  
                "motivo_sem_interesse_pk"=>$query[$i]['motivo_sem_interesse_pk'],  
                "ds_motivo_sem_interesse"=>$query[$i]['ds_motivo_sem_interesse'],         
                "ds_status"=>$ds_status
            );
        }
        return $result;

    }
    public function listarPkRetorno($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from retornos ";
        $sql.=" where ocorrencias_pk = $pk ";
        
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function verificarOcorrenciaLancamento($ds_ocorrencia){

        $sql ="";
        $sql.="select count(0)qtde";

        $sql.="  from ocorrencias ";
        $sql.=" where pk = ".$ds_ocorrencia;
      
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function verificarOcorrenciaLancamentoDespesa($ds_ocorrencia){

        $sql ="";
        $sql.="select count(0)qtde";

        $sql.="  from lancamentos ";
        $sql.=" where ds_ocorrencia = '".$ds_ocorrencia."'";
       
     
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_ds_ocorrencia($ds_lead,$tipos_ocorrencias_pk,$ic_status,$usuario_cadastro_pk,$dt_cadastro,$dt_cadastro_fim,$usuario_agendado_para,$dt_prazo_execucao_ini,$dt_prazo_execucao_fim,$ic_status_fechamento,$equipes_pk,$colaborador_pk){
         //PAGINAÇÃO
         if(isset($_POST['start']) && $_POST['start']!=0){
            $displayStart = $_POST['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_POST['length'])){
            $displayRange = $_POST['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";
        if (isset($_POST['search']['value']) and $_POST['search']['value'] != '') {
            $pesq = $_POST['search']['value'];
            $search .= " AND (
                            l.ds_lead LIKE '%".$pesq."%' OR 
                            c.ds_colaborador LIKE '%".$pesq."%' OR 
                            o.pk LIKE '%".$pesq."%' 
                            )";
        }





        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,o.clientes_pk";
        $sql.="       ,o.obs_execucao";
        $sql.="       ,o.obs_recusa";
        $sql.="       ,o.dt_prazo_execucao";
        $sql.="       ,o.ic_recusa";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,o.colaborador_pk";
        $sql.="       ,date_format(o.dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";
        $sql.="       ,case o.ic_recusa when 1 then 'Chamado Recusado' end ds_recusa";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="       ,o.dt_prazo_execucao dt_prazo_execucao_comp";
        $sql.="  from ocorrencias o";
        $sql.="  LEFT JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  LEFT JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  LEFT JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN colaboradores c on o.colaborador_pk = c.pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        
        $sql.=" where 1=1 ";
        $sql.= $search;
        //Lead
        if($ds_lead != " "){
            $sql.=" and l.ds_lead like '%".$ds_lead."%' ";
        }
        //Tipo Ocorrencia
        if(!empty($tipos_ocorrencias_pk)){
            $sql.=" and o.tipos_ocorrencias_pk=".$tipos_ocorrencias_pk;
        }
        if(!empty($colaborador_pk)){
            $sql.=" and o.colaborador_pk=".$colaborador_pk;
        }
        if(!empty($equipes_pk)){
            $sql.=" and r.equipes_pk =".$equipes_pk;
        }
        
        if(!empty($usuario_cadastro_pk)){
            $sql.=" and o.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
                
       if($ic_status_fechamento != ""){
            if($ic_status_fechamento==1){
                $sql.=" and dt_prazo_execucao is null";             
            }else if($ic_status_fechamento==2){
                $sql.=" and o.dt_prazo_execucao >=".date("Y-m-d") ;
                   $sql.=" and o.dt_fechamento is null ";
                $sql.=" and o.ic_recusa !=1 ";
            }else if($ic_status_fechamento==3){
                $sql.=" and o.dt_prazo_execucao < ".date("Y-m-d") ;
            }else if($ic_status_fechamento==4){
                $sql.=" and o.ic_recusa =1 ";
            }else if($ic_status_fechamento==5){
                $sql.=" and o.ic_recusa !=1 ";
                $sql.=" and o.dt_fechamento is not null ";
            }                
        }
                
        /*if(!empty($ic_status_fechamento)){
            $sql.=" and o.ic_status_fechamento=".$ic_status_fechamento;
        }*/
        if(!empty($usuario_agendado_para)){
            $sql.=" and r.responsavel_pk=".$usuario_agendado_para;
        }
        
        if(!empty($dt_cadastro)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_cadastro)." 00:00:00'";
        }
        
        if(!empty($dt_cadastro_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        if(!empty($dt_prazo_execucao_ini)){
            $sql.=" and o.dt_prazo_execucao >='".DataYMD($dt_prazo_execucao_ini)."'";
        }
        
        if(!empty($dt_prazo_execucao_fim)){
            $sql.=" and o.dt_prazo_execucao <='".DataYMD($dt_prazo_execucao_fim)."'";
        }
        
        if(!empty($ic_status)){
            if($ic_status==1){
                $sql.=" and o.dt_fechamento is null";
            }else{
                $sql.=" and o.dt_fechamento is not null";
            }
        }
        
        $sql.=" order by o.dt_cadastro desc";
        
        
        //PEGA TODOS OS REGISTROS
        $queryCount = $this->db->execQuery($sql);
        //PEGA OS REGISTROS DA PAGINAÇÃO
        $query = $this->db->execQuery($sql.$lengthSql);

        $arrRetorno = [];
        $arrRetorno['query'] = $query;
        $arrRetorno['count'] = count($queryCount);
        return $arrRetorno;

    }
    public function RelatorioOcorrenciaTempo($leads_pk,$supervisor_pk,$tipo_ocorrencia_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_atendimento_ini,$dt_atendimento_fim){
        
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,us.ds_usuario ds_supervisor";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN usuarios us on l.supervisores_pk = us.pk ";
        
        $sql.=" where 1=1 ";
        
        //Tipo Ocorrencia
        if(!empty($tipo_ocorrencia_pk)){
            $sql.=" and o.tipos_ocorrencias_pk=".$tipo_ocorrencia_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and l.pk=".$leads_pk;
        }
        if(!empty($supervisor_pk)){
            $sql.=" and us.pk=".$supervisor_pk;
        }
        if(!empty($dt_abertura_ini)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_abertura_ini)." 00:00:00'";
        }
        
        if(!empty($dt_abertura_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_abertura_fim)." 23:59:59'";
        }
        if(!empty($dt_atendimento_ini)){
            $sql.=" and o.dt_prazo_execucao >='".DataYMD($dt_atendimento_ini)."'";
        }
        
        if(!empty($dt_atendimento_fim)){
            $sql.=" and o.dt_prazo_execucao <='".DataYMD($dt_atendimento_fim)."'";
        }
        
        $sql.=" group by o.pk";
        $sql.=" order by 5 desc";
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEquipeOcorrencia($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim){
        
        $sql.="select e.ds_equipe, r.equipes_pk,o.usuario_cadastro_pk";
        $sql.="  from ocorrencias o";
        $sql.="  left JOIN retornos r on r.ocorrencias_pk = o.pk ";
        $sql.="  left JOIN equipes e on r.equipes_pk = e.pk ";
        
        $sql.=" where 1=1 ";
        
        if(!empty($leads_pk)){
            $sql.=" and o.leads_pk=".$leads_pk;
        }
        if(!empty($equipes_pk)){
            $sql.=" and r.equipes_pk=".$equipes_pk;
        }
        if(!empty($dt_abertura_ini)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_abertura_ini)." 00:00:00'";
        }
        
        if(!empty($dt_abertura_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_abertura_fim)." 23:59:59'";
        }
        if(!empty($dt_execucao_ini)){
            $sql.=" and o.dt_prazo_execucao >='".DataYMD($dt_execucao_ini)."'";
        }
        
        if(!empty($dt_execucao_fim)){
            $sql.=" and o.dt_prazo_execucao <='".DataYMD($dt_execucao_fim)."'";
        }
        if(!empty($dt_fechamento_ini)){
            $sql.=" and o.dt_fechamento >='".DataYMD($dt_fechamento_ini)."'";
        }
        
        if(!empty($dt_fechamento_fim)){
            $sql.=" and o.dt_fechamento <='".DataYMD($dt_fechamento_fim)."'";
        }
        
        $sql.=" group by r.equipes_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarUsuarioEquipe($equipes_pk,$leads_pk){
        
        $sql.="select eu.usuarios_pk";
        $sql.="  from ocorrencias o";
        $sql.="  inner join equipes_usuarios eu on o.usuario_cadastro_pk";
        
        $sql.=" where 1=1 ";
        
        if(!empty($equipes_pk)){
            $sql.=" and eu.equipes_pk=".$equipes_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and o.leads_pk=".$leads_pk;
        }
        $sql.=" group by eu.usuarios_pk";
        echo $sql."<br>";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarUsuarioCadastroOc($leads_pk){
        
        $sql.="select o.usuario_cadastro_pk";
        $sql.="  from ocorrencias o";
       
        //$sql.="  left join equipes_usuarios eu on o.usuario_cadastro_pk = eu.usuarios_pk";
        
        $sql.=" where 1=1 ";
        
        //$sql.=" and eu.equipes_pk is null";
        
        if(!empty($leads_pk)){
            $sql.=" and o.leads_pk=".$leads_pk;
        }
        $sql.=" group by o.usuario_cadastro_pk";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTipoOcorrenciaPorEquipe($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim,$strUsuario){
        
        $sql.="select o.tipos_ocorrencias_pk, ti.ds_tipo_ocorrencia";
        $sql.="  from ocorrencias o";
        $sql.="  left JOIN retornos r on r.ocorrencias_pk = o.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias ti on ti.pk = o.tipos_ocorrencias_pk ";
        
        $sql.=" where 1=1 ";
        
        if(!empty($leads_pk)){
            $sql.=" and o.leads_pk=".$leads_pk;
        }
        if($equipes_pk!="null"){
            $sql.=" and (r.equipes_pk=".$equipes_pk." )" ;
        }
        else{
            $sql.=" and ( r.responsavel_pk in ".$strUsuario." or o.usuario_cadastro_pk in ".$strUsuario.") and r.equipes_pk is null";
        }
        
        if(!empty($dt_abertura_ini)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_abertura_ini)." 00:00:00'";
        }
        
        if(!empty($dt_abertura_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_abertura_fim)." 23:59:59'";
        }
        if(!empty($dt_execucao_ini)){
            $sql.=" and o.dt_prazo_execucao >='".DataYMD($dt_execucao_ini)."'";
        }
        
        if(!empty($dt_execucao_fim)){
            $sql.=" and o.dt_prazo_execucao <='".DataYMD($dt_execucao_fim)."'";
        }
        if(!empty($dt_fechamento_ini)){
            $sql.=" and o.dt_fechamento >='".DataYMD($dt_fechamento_ini)."'";
        }
        
        if(!empty($dt_fechamento_fim)){
            $sql.=" and o.dt_fechamento <='".DataYMD($dt_fechamento_fim)."'";
        }
        
        $sql.=" group by o.tipos_ocorrencias_pk";
     
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function dateDiff($dt_cadastro,$dt_prazo){
        $sql="";
        $sql.=" select datediff('".DataYMD($dt_prazo)."','".DataYMD($dt_cadastro)."')datediff";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listar_ocorrencia_processo_lead($leads_pk,$dt_cadastro_ini,$dt_cadastro_fim,$tipos_ocorrencias_pk,$oc_aberta_fechado){

        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,r.responsavel_pk";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,e1.ds_equipe equipe_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,o.ic_recusa ";       
        $sql.="       ,o.clientes_pk";
        $sql.="       ,o.obs_execucao";
        $sql.="       ,o.obs_recusa";
        $sql.="       ,o.colaborador_pk";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,date_format(o.dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN colaboradores c on o.colaborador_pk = c.pk";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  LEFT JOIN equipes e1 on r.equipes_pk = e1.pk ";
                
        $sql.=" where 1=1 ";
        //$sql.=" and o.usuario_cadastro_pk = ".$this->arrToken['usuarios_pk'];
        
        if($leads_pk != ""){
            $sql.=" and o.leads_pk = ".$leads_pk;
        }
        if($oc_aberta_fechado != ""){
            if($oc_aberta_fechado==1){
                $sql.=" and dt_prazo_execucao is null";
            }else if($oc_aberta_fechado==2){
                $sql.=" and o.dt_prazo_execucao >=".date("Y-m-d") ;
                $sql.=" and o.dt_fechamento is null ";
                $sql.=" and o.ic_recusa !=1 ";
            }else if($oc_aberta_fechado==3){
                $sql.=" and o.dt_prazo_execucao < ".date("Y-m-d") ;
            }else if($oc_aberta_fechado==4){
                $sql.=" and o.ic_recusa =1 ";
            }else if($oc_aberta_fechado==5){
                $sql.=" and o.ic_recusa !=1 ";
                $sql.=" and o.dt_fechamento is not null ";
            }                
        }
        
        
        
        if($tipos_ocorrencias_pk != ""){
            $sql.=" and o.tipos_ocorrencias_pk = ".$tipos_ocorrencias_pk;
        }
        if($dt_cadastro_ini != ""){
            $sql.=" and o.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        
        $sql.=" Group by o.pk ";
        $sql.="       ORDER BY o.dt_cadastro desc";
        
        $query = $this->db->execQuery($sql);
        return $query;

        
    }
    public function relatorioSLAOcorrencia($equipes_pk,$leads_pk,$dt_abertura_ini,$dt_abertura_fim,$dt_execucao_ini,$dt_execucao_fim,$dt_fechamento_ini,$dt_fechamento_fim,$tipos_ocorrencias_pk,$strUsuario){

        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario nome_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,date_format(o.dt_fechamento,'%Y-%m-%d')dt_fechamento_comp ";  
        $sql.="       ,r.responsavel_pk";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u1.ds_usuario nome_agendado_para ";
        $sql.="       ,e1.ds_equipe equipe_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";     
        $sql.="       ,o.leads_pk ";  
        $sql.="       ,o.ic_recusa ";       
        $sql.="       ,o.clientes_pk";
        $sql.="       ,o.obs_execucao";
        $sql.="       ,o.obs_recusa";
        $sql.="       ,date_format(o.dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="       ,date_format(o.dt_prazo_execucao,'%Y-%m-%d')dt_prazo_execucao_comp";
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  left JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  LEFT JOIN equipes e1 on r.equipes_pk = e1.pk ";
                
        $sql.=" where 1=1 ";
        
        if($leads_pk != ""){
            $sql.=" and o.leads_pk = ".$leads_pk;
        }        
        
        
        if($tipos_ocorrencias_pk != ""){
            $sql.=" and o.tipos_ocorrencias_pk = ".$tipos_ocorrencias_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and o.leads_pk=".$leads_pk;
        }
        if($equipes_pk!="null"){
            $sql.=" and (r.equipes_pk=".$equipes_pk." )" ;
        }
        else{
            $sql.=" and ( r.responsavel_pk in ".$strUsuario." or o.usuario_cadastro_pk in ".$strUsuario.") and r.equipes_pk is null";
        }
        if(!empty($dt_abertura_ini)){
            $sql.=" and o.dt_cadastro >='".DataYMD($dt_abertura_ini)." 00:00:00'";
        }
        
        if(!empty($dt_abertura_fim)){
            $sql.=" and o.dt_cadastro <='".DataYMD($dt_abertura_fim)." 23:59:59'";
        }
        if(!empty($dt_execucao_ini)){
            $sql.=" and o.dt_prazo_execucao >='".DataYMD($dt_execucao_ini)."'";
        }
        
        if(!empty($dt_execucao_fim)){
            $sql.=" and o.dt_prazo_execucao <='".DataYMD($dt_execucao_fim)."'";
        }
        if(!empty($dt_fechamento_ini)){
            $sql.=" and o.dt_fechamento >='".DataYMD($dt_fechamento_ini)."'";
        }
        
        if(!empty($dt_fechamento_fim)){
            $sql.=" and o.dt_fechamento <='".DataYMD($dt_fechamento_fim)."'";
        }

        
        $sql.=" Group by o.pk ";
        $sql.="       ORDER BY o.dt_cadastro desc";
        
        $query = $this->db->execQuery($sql);
        return $query;

        
    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_ocorrencia ";
        $sql.="       ,tipos_ocorrencias_pk ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ic_status_fechamento ";
        $sql.="       ,date_format(dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";
        $sql.="       ,clientes_pk";
        $sql.="       ,obs_execucao";
        $sql.="       ,obs_status";
        $sql.="       ,date_format(dt_visualizacao,'%d/%m/%Y %H:%i:%s')dt_visualizacao";

        $sql.="  from ocorrencias ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_ocorrencia asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarOcorrenciasLeadPk($leads_pk){

        $sql ="";
        $sql.="select o.pk, o.usuario_cadastro_pk, o.dt_ult_atualizacao, o.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,date_format(o.dt_cadastro,'%d/%m/%Y <br>%H:%i:%s')dt_cadastro "; 
        $sql.="       ,tio.ds_tipo_ocorrencia";
        $sql.="       ,o.ds_ocorrencia";
        $sql.="       ,u.ds_usuario ds_usuario_cadastro ";
        $sql.="       ,date_format(o.dt_fechamento,'%d/%m/%Y<br>%H:%i:%s')dt_fechamento ";  
        $sql.="       ,r.responsavel_pk";
        $sql.="       ,r.equipes_pk";
        $sql.="       ,u1.ds_usuario ds_agendado_para ";
        $sql.="       ,e1.ds_equipe equipe_agendado_para ";
        $sql.="       ,date_format(r.dt_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_retorno "; 
        $sql.="       ,r.ds_retorno ";
        $sql.="       ,date_format(r.dt_termino_retorno,'%d/%m/%Y<br>%H:%i:%s')dt_termino_retorno ";
        $sql.="       ,o.tipos_ocorrencias_pk ";
        $sql.="       ,o.processos_etapas_pk ";   
        $sql.="       ,date_format(o.dt_prazo_execucao,'%d/%m/%Y')dt_prazo_execucao";  
        $sql.="       ,o.leads_pk ";    
        $sql.="       ,case when o.ic_recusa = 1 then 'Chamado recusado'";    
        $sql.="       when o.dt_prazo_execucao is null then 'Não lido'";    
        $sql.="       when o.dt_fechamento is not null then 'Finalizado'";    
        $sql.="       when o.dt_prazo_execucao >= sysdate() then 'Dentro do prazo'";    
        $sql.="       when o.dt_prazo_execucao < sysdate() then 'Chamado atrasado'";    
        $sql.="       end ds_status";    
        $sql.="  from ocorrencias o";
        $sql.="  INNER JOIN leads l on o.leads_pk = l.pk ";
        $sql.="  INNER JOIN usuarios u on o.usuario_cadastro_pk = u.pk ";
        $sql.="  INNER JOIN tipos_ocorrencias tio on o.tipos_ocorrencias_pk = tio.pk ";
        $sql.="  LEFT JOIN retornos r on o.pk = r.ocorrencias_pk ";
        $sql.="  LEFT JOIN usuarios u1 on r.responsavel_pk = u1.pk ";
        $sql.="  LEFT JOIN equipes e1 on r.equipes_pk = e1.pk ";                
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and o.leads_pk = ".$leads_pk;
        }
        $sql.=" Group by o.pk ";
        $sql.="       ORDER BY o.pk desc";
    
        $query = $this->db->execQuery($sql);
        return $query;        
    } 

}

?>
