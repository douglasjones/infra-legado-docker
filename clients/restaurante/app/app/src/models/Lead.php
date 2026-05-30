<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class Lead {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function excluir($pk){

        $sql ="";
        $sql.="delete from escala_dados_colaborador where pk in(";
        $sql.="        select pk";
        $sql.="                from(";
        $sql.="                select e.pk";
        $sql.="                    from escala_dados_colaborador e";
        $sql.="                    INNER JOIN agenda_colaborador_padrao a on e.agenda_colaborador_padrao_pk = a.pk";
        $sql.="                    where a.leads_pk = ".$pk;
        $sql.="                )";
        $sql.="        X)";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();



        Util::execDelete('documentos', ' leads_pk='.$pk, $this->pdo);
        Util::execDelete('agenda_colaborador_padrao', ' leads_pk='.$pk, $this->pdo);
        Util::execDelete('leads_cargos', ' leads_pk='.$pk, $this->pdo);
        Util::execDelete('leads', ' pk='.$pk, $this->pdo);
    }
    public function excluirFuncao($pk){
        Util::execDelete('leads_cargos', ' pk='.$pk, $this->pdo);
    }

    public function salvar($lead){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        //$fields['grupos_leads_pk'] = $lead['grupos_leads_pk'];
        //$fields['tipos_grupos_lead_pk'] = $lead['tipo_grupos_lead_pk'];
        $fields['ds_lead'] = $lead['ds_lead'];
        $fields['ds_razao_social'] = $lead['ds_razao_social'];
        $fields['ds_cpf_cnpj'] = $lead['ds_cpf_cnpj'];
        $fields['ds_cep'] = $lead['ds_cep'];
        $fields['ds_endereco'] = $lead['ds_endereco'];
        $fields['ds_complemento'] = $lead['ds_complemento'];
        $fields['ds_numero'] = $lead['ds_numero'];
        $fields['ds_bairro'] = $lead['ds_bairro'];
        $fields['ds_cidade'] = $lead['ds_cidade'];
        $fields['ds_uf'] = $lead['ds_uf'];
        $fields['supervisor_pk'] = $lead['supervisor_pk'];
        $fields['supervisor2_pk'] = $lead['supervisor2_pk'];
        $fields['ic_status'] = $lead['ic_status'];
        $fields['ds_tel'] = $lead['ds_tel'];
        $fields['ds_cel'] = $lead['ds_cel'];
        $fields['ds_lead_apelido'] = $lead['ds_lead_apelido'];
        if($lead['dt_ativacao']!=""){
            $fields['dt_ativacao'] = Util::DataYMD($lead['dt_ativacao']);
        }
        else{
            $fields['dt_ativacao'] = "sysdate()";
        }

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
        $fields["contas_pk"] = $_SESSION['session_user']['contas_pk'];

        if($lead['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("leads", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("leads", $fields, " pk = ".$lead['pk'],$this->pdo);
            $pk = $lead['pk'];
            $retorno->status = true;
            $retorno->message = 'Dados atualizado com sucesso';
            $retorno->data = $pk;
        }
        return $retorno;

    }
    public function salvarFuncaoLead($funcao){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['produtos_servicos_pk'] = $funcao['produtos_servicos_pk'];
        $fields['leads_pk'] = $funcao['leads_pk'];
        $fields['ic_status'] = $funcao['ic_status'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($funcao['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("leads_cargos", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("leads_cargos", $fields, " pk = ".$funcao['pk'],$this->pdo);
            $pk = $funcao['pk'];
            $retorno->status = true;
            $retorno->message = 'Dados atualizado com sucesso';
            $retorno->data = $pk;
        }
        return $retorno;

    }
    public function updateEscalaLead($escala){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['leads_pk'] = $escala['leads_pk'];

        Util::execUpdate("agenda_colaborador_padrao", $fields, " pk = ".$escala['pk'],$this->pdo);
        $pk = $escala['pk'];
        $retorno->status = true;
        $retorno->message = 'Dados atualizado com sucesso';
        $retorno->data = $pk;

        return $retorno;

    }
    public function updateDocsLead($docs){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['leads_pk'] = $docs['leads_pk'];


        Util::execUpdate("documentos", $fields, " pk = ".$docs['pk'],$this->pdo);
        $pk = $docs['pk'];
        $retorno->status = true;
        $retorno->message = 'Dados atualizado com sucesso';
        $retorno->data = $pk;

        return $retorno;

    }
    public function listarTodos(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_lead_apelido ";
        $sql.="  from leads l ";
        $sql.=" where 1=1 ";
        $sql.=" and l.ic_status = 1 ";
        $sql.=" and l.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by ds_lead asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }
    public function listarLeadByGrupo($grupos_leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_lead_apelido ";
        $sql.="  from leads l ";
        $sql.=" where 1=1 ";
        $sql.=" and l.ic_status = 1 ";
        $sql.=" and l.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        if($grupos_leads_pk != ""){
            $sql.=" and l.grupos_leads_pk = ".$grupos_leads_pk;
        }
        $sql.=" order by ds_lead asc ";


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }
    public function listarPk($pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="SELECT pk,";
        $sql.="                dt_cadastro,";
        $sql.="                usuario_cadastro_pk,";
        $sql.="                dt_ult_atualizacao,";
        $sql.="                usuario_ult_atualizacao_pk,";
        $sql.="                contas_pk,";
        $sql.="                tipos_grupos_lead_pk,";
        $sql.="                grupos_leads_pk,";
        $sql.="                ds_lead,";
        $sql.="                ds_razao_social,";
        $sql.="                ds_cpf_cnpj,";
        $sql.="                ds_cep,";
        $sql.="                ds_endereco,";
        $sql.="                ds_complemento,";
        $sql.="                ds_numero,";
        $sql.="                ds_bairro,";
        $sql.="                ds_cidade,";
        $sql.="                ds_uf,";
        $sql.="                date_format(dt_ativacao,'%d/%m/%Y')dt_ativacao,";
        $sql.="                dt_cancelamento,";
        $sql.="                obs_motivo_cancelamento,";
        $sql.="                ic_status,";
        $sql.="                supervisor_pk,";
        $sql.="                supervisor2_pk,";
        $sql.="                ds_tel,";
        $sql.="                ds_lead_apelido,";
        $sql.="                ds_cel";
        $sql.="            FROM leads";
        $sql.=" where 1=1 ";
        $sql.=" and pk =  ".$pk;
        $sql.=" and contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by ds_lead asc ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function listarDataTable($leads_pk,$grupos_leads_pk,$supervisores_pk,$ic_status){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";
        if (isset($_GET['search']['value']) and $_GET['search']['value'] != '') {
            $pesq = $_GET['search']['value'];
            $search .= " AND (
                            l.ds_lead LIKE '%".$pesq."%' 
                        )";
        }

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_lead_apelido ";
        $sql.="       ,case l.ic_status when 1 then 'Ativo' when 2 then 'Desativado' end ds_status ";
        $sql.="       ,gl.ds_grupo_leads ";
        $sql.="       ,u.ds_usuario ds_supervisor ";
        $sql.="  from leads l ";
        $sql.="  left join grupos_leads gl on gl.pk = l.grupos_leads_pk";
        $sql.="  left join usuarios u on u.pk = l.supervisor_pk";
        $sql.=" where 1=1 ";
        $sql.="   and l.contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.= $search;
        if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk;
        }
        if($grupos_leads_pk != ""){
            $sql.=" and l.grupos_leads_pk = ".$grupos_leads_pk;
        }

        if($ic_status != ""){
            $sql.=" and l.ic_status = ".$ic_status;
        }

        if($supervisores_pk != ""){
            $sql.=" and l.supervisor_pk =".$supervisores_pk;
        }
        $sql.=" order by l.ds_lead asc ";


        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }
    public function listarGridFuncao($leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }


        $sql ="";
        $sql.=" select lc.pk, ";
        $sql.=" date_format(lc.dt_cadastro,'%d/%m/%Y')dt_cadastro,";
        $sql.=" u.ds_usuario usuario_cadastro, ";
        $sql.=" lc.produtos_servicos_pk, ";
        $sql.=" lc.ic_status, ";
        $sql.=" ps.ds_produto_servico,";
        $sql.=" CASE lc.ic_status when 1 then 'Ativo' when 2 then 'Inativo' end ds_status";
        $sql.=" from leads_cargos lc";
        $sql.=" inner join produtos_servicos ps on lc.produtos_servicos_pk = ps.pk";
        $sql.=" inner join usuarios u on lc.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and lc.leads_pk = ".$leads_pk;
        }
        $sql.=" order by lc.pk asc ";



        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }

    public function verificarCNPJ($ds_cpf_cnpj){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="  from leads ";
        $sql.=" where 1=1 ";
        if($ds_cpf_cnpj != ""){
            $sql.=" and ds_cpf_cnpj = '".$ds_cpf_cnpj."'";
        }
        $sql.="   and contas_pk = ".$_SESSION['session_user']['contas_pk'];
        $sql.=" order by ds_lead asc ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;

    }

    public function listarLeadsPorEmpresa($empresas_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.="   FROM leads l";
        if(!empty($empresas_pk)){
            $sql.=" WHERE l.contas_pk=".$empresas_pk;
        }
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

}
