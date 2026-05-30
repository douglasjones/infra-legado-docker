<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/analise_financeira.class.php';
require_once "../model/lancamento.dao.php";
require_once "../model/produto_servico.dao.php";
require_once '../model/usuario.dao.php';


class analise_financeiradao{

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

    public function salvar($analise_financeira){

        $fields = array();
        $fields['lancamentos_pk'] = $analise_financeira->getlancamentos_pk();
        $fields['lancamentos_financeiros_pk'] = $analise_financeira->getlancamentos_financeiros_pk();
        
        $fields['ic_status'] = $analise_financeira->getic_status();
        $fields['gestor_aprovacao_pk'] = $analise_financeira->getgestor_aprovacao_pk();
        $fields['obs'] = $analise_financeira->getobs();
        $fields['dt_cancelamento'] = $analise_financeira->getdt_cancelamento();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        if($analise_financeira->getlancamentos_pk()!='' or $analise_financeira->getlancamentos_pk()!='0'){

            
            if($analise_financeira->getpk()  == ""){
                $fields['usuario_cadastro_lancamento_pk'] = $this->arrToken['usuarios_pk'];
                $fields["dt_cadastro"] = "sysdate()";
                $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                $pk = $this->db->execInsert("analise_financeira", $fields);
                $analise_financeira->setpk($pk);
            }
            else{
                $this->db->execUpdate("analise_financeira", $fields, " pk = ".$analise_financeira->getpk());
            }
        }
        return $analise_financeira->getpk();

    }

    public function excluir($analise_financeira){
        $this->db->execDelete("analise_financeira"," pk = ".$analise_financeira->getpk());
    }

    public function carregarPorPk($pk){

        $analise_financeira = new analise_financeira();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,lancamentos_pk ";
        $sql.="       ,lancamentos_financeiros_pk ";
        $sql.="       ,usuario_cadastro_lancamento_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,gestor_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,dt_cancelamento ";


        $sql.="  from analise_financeira ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $analise_financeira->setpk($query[$i]["pk"]);
                $analise_financeira->setdt_cadastro($query[$i]["dt_cadastro"]);
                $analise_financeira->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $analise_financeira->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $analise_financeira->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $analise_financeira->setlancamentos_pk($query[$i]['lancamentos_pk']);
                $analise_financeira->setlancamentos_financeiros_pk($query[$i]['lancamentos_financeiros_pk']);
                $analise_financeira->setusuario_cadastro_lancamento_pk($query[$i]['usuario_cadastro_lancamento_pk']);
                $analise_financeira->setic_status($query[$i]['ic_status']);
                $analise_financeira->setgestor_aprovacao_pk($query[$i]['gestor_aprovacao_pk']);
                $analise_financeira->setobs($query[$i]['obs']);
                $analise_financeira->setdt_cancelamento($query[$i]['dt_cancelamento']);

            }
        }
        return $analise_financeira;
    }

    public function listarPorPk($pk){

        $lancamentodao = new lancamentodao();
        $produto_servicodao = new produto_servicodao();

        $ds_recebido_de = "";
        $ds_recebido_de_centro_custo = "";                
        $ds_agencia = "";                
        $ds_conta = "";                
        $ds_digito = "";                
        $ds_banco = "";

        $sql ="";
        $sql.="select af.pk, date_format(af.dt_cadastro,'%d/%m/%Y') dt_cadastro, af.usuario_cadastro_pk  ";
        $sql.="       ,l.pk lancamentos_pk ";
        $sql.="       ,af.usuario_cadastro_lancamento_pk ";
        $sql.="       ,af.ic_status ";
        $sql.="       ,af.gestor_aprovacao_pk ";
        $sql.="       ,l.obs_lancamento obs ";
        $sql.="       ,date_format(af.dt_cancelamento,'%d/%m/%Y') dt_cancelamento";
        $sql.="       ,l.tipos_operacao_pk";
        $sql.="       ,l.ds_lancamento";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,l.operacao_pk";
        $sql.="       ,CASE";
        $sql.="          WHEN l.operacao_pk = 1 THEN 'Receita'";
        $sql.="          WHEN l.operacao_pk = 2 THEN 'Despesa Fixa'";
        $sql.="          WHEN l.operacao_pk = 3 THEN 'Despesa Variável'";
        $sql.="          WHEN l.operacao_pk = 4 THEN 'Imposto'";
        $sql.="          WHEN l.operacao_pk = 5 THEN 'Transferência'";
        $sql.="          WHEN l.operacao_pk = 6 THEN 'Caixinha'";
        $sql.="          WHEN l.operacao_pk = 7 THEN 'Custo Fixo'";
        $sql.="          END ds_operacao";
        $sql.="       ,l.metodos_pagamento_pk";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,l.contas_bancarias_pk";
        $sql.="       ,l.vl_lancamento";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y') dt_vencimento";
        $sql.="       ,date_format(l.dt_pagamento,'%d/%m/%Y') dt_pagamento";
        $sql.="       ,l.parcela_pk";
        $sql.="       ,l.grupo_leancamento_pk";
        $sql.="       ,CASE";
        $sql.="          WHEN l.tipo_grupo_pk = 1 THEN 'Cliente(s)'";
        $sql.="          WHEN l.tipo_grupo_pk = 2 THEN 'Colaboradores'";
        $sql.="          WHEN l.tipo_grupo_pk = 3 THEN 'Fornecedores'";
        $sql.="          END ds_tipo_grupo";
        $sql.="       ,l.tipo_grupo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.colaborador_contratos_pk";
        $sql.="       ,l.fornecedor_contratos_pk";
        $sql.="       ,l.leads_posto_trabalho_pk";
        $sql.="       ,l.colaborador_posto_trabalho_pk";
        $sql.="       ,l.fornecedor_posto_trabalho_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,c.ds_conta";
        $sql.="       ,le.ds_lead ds_cliente ";
        $sql.="       ,top.ds_tipo_operacao";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,concat(cb.ds_conta_bancaria, ' - Agência: ', cb.ds_agencia, ' - Conta: ', cb.ds_conta) ds_conta_bancaria";
        $sql.="       , date_format(l.dt_cadastro,'%d/%m/%Y') dt_cadastro_lancamento";
        $sql.="  from analise_financeira af";
        $sql.="  LEFT JOIN lancamentos l ON l.pk = af.lancamentos_pk";
        $sql.="  LEFT JOIN analise_financeira_processos afp ON afp.analise_financeira_pk = af.pk";
        $sql.="  LEFT JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.="  LEFT JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="  LEFT JOIN contas c ON l.empresas_pk = c.pk";
        $sql.="  LEFT JOIN contas_bancarias cb ON l.contas_bancarias_pk = cb.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  LEFT JOIN leads le on l.leads_clientes_pk = le.pk ";    
        $sql.="  LEFT JOIN tipos_operacao top ON l.tipos_operacao_pk = top.pk";
        $sql.=" where af.pk = $pk ";
        //echo $sql;
        $query = $this->db->execQuery($sql);

        if($query[0]['tipo_grupo_pk']==1){
            $queryLead = $lancamentodao->listaItensGrupoLeads($query[0]['grupo_leancamento_pk']);
            $ds_recebido_de = $queryLead[0]['ds_lead'];                    
        }
        else if($query[0]['tipo_grupo_pk']==2){
            $queryLead = $lancamentodao->listaItensGrupoColaboradores($query[0]['grupo_leancamento_pk']);
            $ds_recebido_de = $queryLead[0]['ds_colaborador'];
            $ds_agencia = $queryLead[0]['ds_agencia'];         
            $ds_conta = $queryLead[0]['ds_conta'];            
            $ds_digito = $queryLead[0]['ds_digito'];             
            $ds_banco = $queryLead[0]['ds_banco'];
            $ds_pix = $queryLead[0]['ds_pix'];
            $ds_favorecido_pix = $queryLead[0]['ds_conta_favorecido'];
        }
        else if($query[0]['tipo_grupo_pk']==3){
            $queryLead = $lancamentodao->listaItensGrupoFornecedores($query[0]['grupo_leancamento_pk']);
            $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
            $ds_agencia = $queryLead[0]['ds_agencia'];         
            $ds_conta = $queryLead[0]['ds_conta'];            
            $ds_digito = $queryLead[0]['ds_digito'];             
            $ds_banco = $queryLead[0]['ds_banco'];
            $ds_pix = $queryLead[0]['ds_pix'];
            $ds_favorecido_pix = $queryLead[0]['ds_favorecido_pix'];
        }

        //CENTRO CUSTO
        if($query[0]['tipo_grupo_centro_custo_pk']==1){
            $queryLead = $lancamentodao->listaItensGrupoLeads($query[0]['grupo_lancamento_centro_custo_pk']);
            $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
        }else if($query[0]['tipo_grupo_centro_custo_pk']==2){;

            $queryLead = $lancamentodao->listaItensGrupoLeads($query[0]['grupo_lancamento_centro_custo_pk']);
            $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
        }else if($query[0]['tipo_grupo_centro_custo_pk']==3){
            $queryLead = $lancamentodao->listaItensGrupoLeads($query[0]['grupo_lancamento_centro_custo_pk']);
            $ds_recebido_de_centro_custo = $queryLead[0]['ds_lead'];
    
        }else if($query[0]['tipo_grupo_centro_custo_pk']==4){
            $queryLead = $lancamentodao->listaItensGrupoEquipes($query[0]['grupo_lancamento_centro_custo_pk']);
            $ds_recebido_de_centro_custo = $queryLead[0]['ds_equipe'];
        }

        //Posto de trabalho
        $lancamento_posto_trabalho_pk = "";
        if(!empty($query[0]['leads_posto_trabalho_pk'])){
            $lancamento_posto_trabalho_pk = $query[0]['leads_posto_trabalho_pk'];
        }else if(!empty($query[0]['colaborador_posto_trabalho_pk'])){
            $lancamento_posto_trabalho_pk = $query[0]['colaborador_posto_trabalho_pk'];
        }else if(!empty($query[0]['fornecedor_posto_trabalho_pk'])){
            $lancamento_posto_trabalho_pk = $query[0]['fornecedor_posto_trabalho_pk'];
        }
        $ds_lancamento_posto_trabalho = "";
        if(!empty($lancamento_posto_trabalho_pk)){
            $queryPostoTrabalho = $lancamentodao->listaItensGrupoLeads($lancamento_posto_trabalho_pk );
            $ds_lancamento_posto_trabalho = $queryPostoTrabalho[0]['ds_lead'];              
        }

        //Contratos
        $lancamento_contrato_pk = "";
        $ds_produto_servico = "";                
        if(!empty($query[0]['colaborador_contratos_pk'])){
            $lancamento_contrato_pk = $query[0]['colaborador_contratos_pk'];
        }else if(!empty($query[0]['fornecedor_contratos_pk'])){
            $lancamento_contrato_pk = $query[0]['fornecedor_contratos_pk'];
        }else if(!empty($query[0]['contratos_pk'])){
            $lancamento_contrato_pk = $query[0]['contratos_pk'];
        }         
        
        $ds_lancamento_contrato= "";
        if(!empty($lancamento_contrato_pk)){
            $queryContrato = $lancamentodao->listarcontratos($lancamento_contrato_pk);
            $ds_lancamento_contrato = $queryContrato[0]['ds_contrato'];  
            $queryProdutoServico = $produto_servicodao->listarProdutosContrato($lancamento_contrato_pk);
            $ds_produto_servico =  $queryProdutoServico[0]['ds_produto_servico'];   

            if(!empty($ds_produto_servico)){
                $ds_lancamento_contrato  = $ds_lancamento_contrato." Serviço:".$ds_produto_servico; 
            }                                   
        }

        $mysql_data[] = array(
            "lancamentos_pk" => $query[0]["lancamentos_pk"],
            "ds_agencia"=>$ds_agencia,
            "ds_conta"=>$ds_conta,
            "ds_digito"=>$ds_digito,
            "ds_banco"=>$ds_banco,
            
            "dt_vencimento"=>$query[0]['dt_vencimento'],
            "ds_usuario_cadastro"=>$query[0]['ds_usuario'],
            "dt_cadastro"=>$query[0]['dt_cadastro_lancamento'],
            "vl_inicial_conta"=>$query[0]['vl_saldo_inicial'],
            "dt_pagamento"=>$query[0]['dt_pagamento'],
            "vl_saldo"=>number_format((($query[0]['vl_lancamento']-$query[0]['vl_lancamento']) ),2,",","."),
            "ds_lancamento"=>$query[0]['ds_lancamento'],
            "vl_lancamento"=>($query[0]['vl_lancamento']),
            "operacao_pk"=>$query[0]['operacao_pk'],
            "ds_operacao"=>$query[0]['ds_operacao'],
            "ds_tipo_operacao"=>$query[0]['ds_tipo_operacao'],
            "tipo_grupo_pk"=>$query[0]['tipo_grupo_pk'],
            "ds_tipo_grupo"=>$query[0]['ds_tipo_grupo'],
            "ds_tipo_grupo_centro_custo"=>$query[0]['ds_tipo_grupo_centro_custo'],
            "grupo_leancamento_pk"=>$query[0]['grupo_leancamento_pk'],
            "ic_status_pagamento"=>$query[0]['ic_status_pagamento'],
            "ds_status_pagamento"=>$query[0]['ds_status_pagamento'],
            "obs_lancamento"=>$query[0]['obs_lancamento'],
            "dt_competencia"=>$query[0]['dt_competencia'],
            "n_documento"=>$query[0]['n_documento'],
            "contas_bancarias_pk"=>$query[0]['contas_bancarias_pk'],
            "tipos_operacao_pk"=>$query[0]['tipos_operacao_pk'],
            "metodos_pagamento_pk"=>$query[0]['metodos_pagamento_pk'],
            "ds_metodo_pagamento"=>$query[0]['ds_metodo_pagamento'],
            "ds_conta_bancaria"=>$query[0]['ds_conta_bancaria'],
            "ds_tipo_operacao"=>$query[0]['ds_tipo_operacao'],
            "empresas_pk"=>$query[0]['empresas_pk'],
            "ds_razao_social"=>$query[0]['ds_razao_social'],
            "ds_dados_conta"=>$query[0]['ds_dados_conta'],
            "ds_pix"=>$ds_pix,
            "ds_favorecido_pix"=>$ds_favorecido_pix,
            "tipo_grupo_centro_custo_pk"=>$query[0]['tipo_grupo_centro_custo_pk'],
            "grupo_lancamento_centro_custo_pk"=>$query[0]['grupo_lancamento_centro_custo_pk'],
            "ds_ocorrencia"=>$query[0]['ds_ocorrencia'],
            "dt_pagamento"=>$query[0]['dt_pagamento'],
            "contratos_pk"=>$query[0]['contratos_pk'],
            "ds_usuario"=>$query[0]['ds_usuario'],
            "dt_faturamento"=>$query[0]['dt_faturamento'],
            "parcela_pk"=>$query[0]['parcela_pk'],
            "ds_recebido_de"=>$ds_recebido_de,
            "ds_recebido_de_centro_custo"=>$ds_recebido_de_centro_custo,
            "ds_cliente"=>$query[0]['ds_cliente'],
            "ds_lancamento_posto_trabalho"=>$ds_lancamento_posto_trabalho,   
            "obs"=>$query[0]['obs'],   
            "ds_lancamento_contrato"=>$ds_lancamento_contrato
        );
        //var_dump($mysql_data);

        return $mysql_data;

    }

    public function listar_por_lancamentos_pk($ic_status, $lancamento_pk, $dt_cadastro_ini, $dt_cadastro_fim, $dt_aprovacao_ini, $dt_aprovacao_fim, $dt_correcao_ini, $dt_correcao_fim, $dt_recusa_ini, $dt_recusa_fim, $usuario_cadastro_lancamento_pk, $usuario_cadastro_gestor_pk, $usuario_cadastro_analista_pk,$dt_lancamento_ini,$dt_lancamento_fim ){

        
        $usuario = new usuariodao();

        $sql ="";
        $sql.="SELECT af.pk, DATE_FORMAT(l.dt_cadastro, '%d/%m/%Y')dt_cadastro_financeiro, af.usuario_cadastro_pk ";
        $sql.="       ,max(afp.pk) ";
        $sql.="       ,af.lancamentos_pk ";
        $sql.="       ,af.ic_status ";
        $sql.="       ,CASE";
        $sql.="          WHEN af.ic_status = 1 THEN 'Não Analisado'";
        $sql.="          WHEN af.ic_status = 2 THEN 'Aprovado Analista'";
        $sql.="          WHEN af.ic_status = 3 THEN 'Aprovado Gestor'";
        $sql.="          WHEN af.ic_status = 4 THEN 'Correção Solicitada'";
        $sql.="          WHEN af.ic_status = 5 THEN 'Recusado'";
        $sql.="          WHEN af.ic_status = 6 THEN 'Correção Feita'";
        $sql.="          WHEN af.ic_status = 7 THEN 'Cancelado'";
        $sql.="          END ds_status";
        $sql.="       ,CASE";
        $sql.="          WHEN afp.ic_recusa = 1 THEN DATE_FORMAT(afp.dt_cadastro, '%d/%m/%Y')";
        $sql.="       END dt_recusa ";
        $sql.="       ,CASE";
        $sql.="          WHEN afp.ic_aprovacao = 1 THEN DATE_FORMAT(afp.dt_cadastro, '%d/%m/%Y')";
        $sql.="       END dt_aprovacao";
        $sql.="       ,CASE";
        $sql.="          WHEN afp.ic_correcao = 1 THEN DATE_FORMAT(afp.dt_cadastro, '%d/%m/%Y')";
        $sql.="       END dt_correcao";
        $sql.="       ,af.gestor_aprovacao_pk ";
        $sql.="       ,af.usuario_cadastro_lancamento_pk ";
        $sql.="       ,u.ds_usuario ds_usuario_cadastro_lancamento";
        $sql.="       ,af.dt_cancelamento ";
        $sql.="       ,afp.dt_cadastro dt_cadastro_processos";
        $sql.="       ,afp.usuario_cadastro_pk ";
        $sql.="  FROM analise_financeira af ";
        $sql.="  INNER JOIN lancamentos l on af.lancamentos_pk = l.pk";
        $sql.="  LEFT JOIN analise_financeira_processos afp ON afp.analise_financeira_pk = af.pk ";
        $sql.="  LEFT JOIN usuarios u ON af.usuario_cadastro_lancamento_pk = u.pk ";
        $sql.="  LEFT JOIN usuarios usu ON afp.usuario_cadastro_pk = usu.pk ";
        $sql.=" WHERE 1=1 ";

        if($ic_status != ""){
            $sql.=" AND af.ic_status = '".$ic_status."' ";
        }
        if($lancamento_pk != ""){
            $sql.=" AND af.lancamento_pk = '".$lancamento_pk."' ";
        }

        if($dt_cadastro_ini != ""){
            $sql.=" AND afp.dt_cadastro <= '".$dt_cadastro_ini."' ";
        }
        if($dt_cadastro_fim != ""){
            $sql.=" AND afp.dt_cadastro <= '".$dt_cadastro_fim."' ";
        }

        if($dt_aprovacao_ini != ""){
            $sql.=" AND afp.dt_cadastro >= '".DataYMD($dt_aprovacao_ini)."' ";
            $sql.=" AND afp.ic_aprovacao = '1' ";
        }
        if($dt_aprovacao_fim != ""){
            $sql.=" AND afp.dt_cadastro <= '".DataYMD($dt_aprovacao_fim)."' ";
            $sql.=" AND afp.ic_aprovacao = '1' ";
        }

        if($dt_correcao_ini != ""){
            $sql.=" AND afp.dt_cadastro >= '".DataYMD($dt_correcao_ini)."' ";
            $sql.=" AND afp.ic_correcao = '1' ";
        }
        if($dt_correcao_fim != ""){
            $sql.=" AND afp.dt_cadastro <= '".DataYMD($dt_correcao_fim)."' ";
            $sql.=" AND afp.ic_correcao = '1' ";
        }

        if($dt_recusa_ini != ""){
            $sql.=" AND afp.dt_cadastro >= '".DataYMD($dt_recusa_ini)."' ";
            $sql.=" AND afp.ic_recusa = '1' ";
        }
        if($dt_recusa_fim != ""){
            $sql.=" AND afp.dt_cadastro >= '".DataYMD($dt_recusa_fim)."' ";
            $sql.=" AND afp.ic_recusa = '1' ";
        }

        if($dt_lancamento_ini != ""){
            $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_lancamento_ini)."' ";            
        }
        if($dt_lancamento_fim != ""){
            $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_lancamento_fim)."' ";            
        }

        if($usuario_cadastro_lancamento_pk != ""){
            $sql.=" AND af.usuario_cadastro_pk = '".$usuario_cadastro_lancamento_pk."' ";
        }
        if($usuario_cadastro_analista_pk != ""){
            $sql.=" AND afp.usuario_cadastro_pk = '".$usuario_cadastro_analista_pk."' ";
        }
        if($usuario_cadastro_gestor_pk != ""){
            $sql.=" AND afp.usuario_cadastro_pk = '".$usuario_cadastro_gestor_pk."' ";
        }
        $grupo_usuario = $usuario->listarGruposUsuario($this->arrToken['usuarios_pk']);
        if($grupo_usuario[0]['ds_grupo'] == "Gestor"){
            $sql.=" AND af.gestor_aprovacao_pk = '".$this->arrToken['usuarios_pk']."' ";
            $sql.=" AND (af.ic_status = 2 || af.ic_status = 3)";
        }
        $sql.=" GROUP BY af.pk";
        $sql.=" ORDER BY af.pk desc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,lancamentos_financeiros_pk ";
        $sql.="       ,usuario_cadastro_lancamento_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,gestor_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,dt_cancelamento ";

        $sql.="  from analise_financeira ";
        $sql.=" where 1=1 ";
        $sql.=" order by lancamentos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDadosAnaliseFinanceira($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,lancamentos_pk ";
        $sql.="       ,lancamentos_financeiros_pk ";
        $sql.="       ,usuario_cadastro_lancamento_pk ";
        $sql.="       ,ic_status ";
        $sql.="       ,gestor_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,dt_cancelamento ";

        $sql.="  from analise_financeira ";
        $sql.=" where pk = $pk ";
        $sql.=" order by lancamentos_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
