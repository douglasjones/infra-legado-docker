<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/lancamento.class.php';
require_once '../model/conta.dao.php';


class lancamentodao{

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
    
    public function salvar($lancamento, $doc_lancamento, $token){
        $conta = new contadao();
        $conta->setToken($token); 

        $fields = array();
        $fields['ds_lancamento'] = $lancamento->getds_lancamento();
        $fields['operacao_pk'] = $lancamento->getoperacao_pk();
        $fields['categoria_operacao_pk'] = $lancamento->getcategoria_operacao_pk();
        $fields['tipos_operacao_pk'] = $lancamento->gettipos_operacao_pk();
        $fields['tipo_grupo_pk'] = $lancamento->gettipo_grupo_pk();
        $fields['grupo_leancamento_pk'] = $lancamento->getgrupo_leancamento_pk();
        
        $fields['leads_clientes_pk'] = $lancamento->getleads_clientes_pk();
        $fields['leads_posto_trabalho_pk'] = $lancamento->getleads_posto_trabalho_pk();
        $fields['contratos_pk'] = $lancamento->getcontratos_pk();
        $fields['colaborador_pk'] = $lancamento->getcolaborador_pk();
        $fields['colaborador_posto_trabalho_pk'] = $lancamento->getcolaborador_posto_trabalho_pk();
        $fields['colaborador_contratos_pk'] = $lancamento->getcolaborador_contratos_pk();
        
        $fields['fornecedor_pk'] = $lancamento->getfornecedor_pk();    
        $fields['fornecedor_posto_trabalho_pk'] = $lancamento->getfornecedor_posto_trabalho_pk();     
        $fields['fornecedor_contratos_pk'] = $lancamento->getfornecedor_contratos_pk();

        if($lancamento->getdt_faturamento()!=""){
            $fields['dt_faturamento'] = DataYMD($lancamento->getdt_faturamento());
        }
        $fields['tipo_grupo_centro_custo_pk'] = $lancamento->gettipo_grupo_centro_custo_pk();
        $fields['grupo_lancamento_centro_custo_pk'] = $lancamento->getgrupo_lancamento_centro_custo_pk();
        $fields['dt_vencimento'] = DataYMD($lancamento->getdt_vencimento());
        $fields['vl_lancamento'] = moeda2float($lancamento->getvl_lancamento());
        $fields['metodos_pagamento_pk'] = $lancamento->getmetodos_pagamento_pk();
        $fields['empresas_pk'] = $lancamento->getempresas_pk();
        $fields['contas_bancarias_pk'] = $lancamento->getcontas_bancarias_pk();
        $fields['ic_status_pagamento'] = $lancamento->getic_status_pagamento();
        $fields['parcela_pk'] = $lancamento->getparcela_pk();
        if($lancamento->getdt_pagamento()!=""){
            $fields['dt_pagamento'] = DataYMD($lancamento->getdt_pagamento());
        }
        $fields['obs_lancamento'] = $lancamento->getobs_lancamento();
    

        $fields['ds_ocorrencia'] = $lancamento->getds_ocorrencia();
        $fields['compras_pk'] = $lancamento->getcompras_pk();
        $fields['ds_num_documento'] = $lancamento->getds_num_documento();
        $fields['ic_tipo_num_documento'] = $lancamento->getic_tipo_num_documento();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];


        if($lancamento->getpk() == ""){
            $pk = "";
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
           
            $pk = $this->db->execInsert("lancamentos", $fields);
            //echo $pk."<br>";
               

            $ic_analise_financeira = $conta->configModulo();
            $ic_analise_financeira = $ic_analise_financeira[0]['ic_analise_financeira'];
   
             if($ic_analise_financeira == 1 && $lancamento->getoperacao_pk() != 1){
            //if($ic_analise_financeira == 1){    
                $fieldsAnalise = array();
                $fieldsAnalise['lancamentos_pk'] = $pk;
                $fieldsAnalise['lancamentos_financeiros_pk'] = 0;
                $fieldsAnalise['usuario_cadastro_lancamento_pk'] = $this->arrToken['usuarios_pk'];
                $fieldsAnalise['ic_status'] = 1;
                $fieldsAnalise['obs'] = $lancamento->getobs_lancamento();

                $fieldsAnalise["dt_ult_atualizacao"] = "sysdate()";
                $fieldsAnalise["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

                $fieldsAnalise["dt_cadastro"] = "sysdate()";
                $fieldsAnalise["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

                $this->db->execInsert("analise_financeira", $fieldsAnalise);
            }
        }else{
  
            $this->db->execUpdate("lancamentos", $fields, " pk = ".$lancamento->getpk());
            $pk = $lancamento->getpk();


        }

        if($doc_lancamento != ""){

            $documentodao = new documentodao();
            $documentodao->setToken($token); 
            $doc_lancamento = json_decode ($doc_lancamento, true);
        
            if(count($doc_lancamento) > 0){
                for($i = 0; $i < count($doc_lancamento); $i++){
                    if($doc_lancamento[$i]['doc_lancamento_pk']!="Nenhum registro encontrado"){
                        if($doc_lancamento[$i]['doc_lancamento_pk']!="Carregando..."){
                            $documento = $documentodao->carregarPorPk($doc_lancamento[$i]['doc_lancamento_pk']);
                            $documento->setds_documento($doc_lancamento[$i]['ds_documento']);

                            $documento->setds_nome_original($doc_lancamento[$i]['ds_nome_original']);
                            $documento->setlancamentos_pk($pk);

                            $documentodao->salvar($documento);
                        }
                    }
                }
            }
        }

        return $pk;

    }

    public function excluirDocsLancamento($lancamentos_pk){
        $this->db->execDelete("documentos"," lancamentos_pk = ".$lancamentos_pk);
    }
    public function excluir($lancamento){
        $this->db->execDelete("lancamentos"," pk = ".$lancamento->getpk());
    }

    
    public function listarExtratoMes($empresas_pk,$contas_bancarias_pk,$_ds_mes,$_ds_ano){
           
        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="        date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')";
        $sql.="           dt_cadastro,";
        $sql.="        date_format(l.dt_vencimento, '%d/%m/%Y')";
        $sql.="           dt_vencimento,";
        $sql.="        date_format(l.dt_pagamento, '%d/%m/%Y')";
        $sql.="           dt_pagamento,";
        $sql.="        date_format(l.dt_faturamento, '%d/%m/%Y')";
        $sql.="           dt_faturamento,";
        $sql.="        CASE l.operacao_pk";
        $sql.="           WHEN 1 THEN 'Receita'";
        $sql.="           WHEN 2 THEN 'Despesa Fixa'";
        $sql.="           WHEN 3 THEN 'Despesa Variada'";
        $sql.="           WHEN 4 THEN 'Imposto'";
        $sql.="           WHEN 5 THEN 'Transferência'";
        $sql.="           WHEN 6 THEN 'Caixinha'";
        $sql.="        END";
        $sql.="           ds_operacao,";
        $sql.="        CASE l.tipo_grupo_pk";
        $sql.="           WHEN 1 THEN '(Clientes)'";
        $sql.="           WHEN 2 THEN 'Colaboradores'";
        $sql.="           WHEN 3 THEN 'Fornecedores'";
        $sql.="           WHEN 4 THEN 'Outros'";
        $sql.="        END";
        $sql.="           ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="        l.operacao_pk,";
        $sql.="        l.tipo_grupo_pk,";
        $sql.="        l.vl_lancamento,";
        $sql.="        l.ds_lancamento,";
        $sql.="        u.ds_usuario,";
        $sql.="        l.grupo_leancamento_pk,"; 
        $sql.="        top.ds_tipo_operacao,"; 
        $sql.="         l.ic_status_pagamento"; 
        $sql.=" FROM lancamentos l";
        $sql.="      INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="      iNNER JOIN tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="      Left JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.=" WHERE     1 = 1";
        $sql.="       AND l.empresas_pk = ".$empresas_pk;
        $sql.="       AND l.contas_bancarias_pk = ".$contas_bancarias_pk;
        $sql.="       AND l.dt_vencimento >='".$_ds_ano."-".$_ds_mes."-01 00:00:00'";
        $sql.="       AND l.dt_vencimento <='".$_ds_ano."-".$_ds_mes."-31 23:59:59'";
        $sql.=" ORDER BY l.dt_vencimento";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarExtratoConciliacao($empresas_pk,$contas_bancarias_pk,$dt_periodo_ini,$dt_periodo_fim){
        //DEBITO ENTRADA
        //CRÉDITO SAIDA   
        $sql ="";
        $sql.="SELECT distinct(l.pk) pk,";
        $sql.="        date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')";
        $sql.="           dt_cadastro,";
        $sql.="        date_format(l.dt_vencimento, '%d/%m/%Y')";
        $sql.="           dt_vencimento,";
        $sql.="        date_format(l.dt_pagamento, '%d/%m/%Y')";
        $sql.="           dt_pagamento,";
        $sql.="        date_format(l.dt_faturamento, '%d/%m/%Y')";
        $sql.="           dt_faturamento,";
        $sql.="        CASE l.operacao_pk";
        $sql.="           WHEN 1 THEN 'Débito'";
        $sql.="           WHEN 2 THEN 'Crédito'";
        $sql.="           WHEN 3 THEN 'Crédito'";
        $sql.="           WHEN 4 THEN 'Crédito'";
        $sql.="           WHEN 5 THEN 'Crédito'";
        $sql.="           WHEN 6 THEN 'Crédito'";
        $sql.="        END";
        $sql.="           ds_operacao,";
        $sql.="        CASE l.tipo_grupo_pk";
        $sql.="           WHEN 1 THEN '(Clientes)'";
        $sql.="           WHEN 2 THEN 'Colaboradores'";
        $sql.="           WHEN 3 THEN 'Fornecedores'";
        $sql.="           WHEN 4 THEN 'Outros'";
        $sql.="        END";
        $sql.="           ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="        l.operacao_pk,";
        $sql.="        l.tipo_grupo_pk,";
        $sql.="        l.vl_lancamento,";
        $sql.="        l.ds_lancamento,";
        $sql.="        u.ds_usuario,";
        $sql.="        l.grupo_leancamento_pk,"; 
        $sql.="        top.ds_tipo_operacao,"; 
        $sql.="        fl.financeiro_conciliacao_banco_itens_pk,"; 
        $sql.="        fl.ic_status ic_status_conciliacao,";
        $sql.="         l.ic_status_pagamento"; 
        $sql.=" FROM lancamentos l";
        $sql.="      INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="      iNNER JOIN tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="      Left JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.="      Left JOIN financeiro_conciliacao_lancamentos fl ON fl.lancamentos_pk = l.pk";
        $sql.=" WHERE     1 = 1";
        //$sql.="       AND l.empresas_pk = ".$empresas_pk;
        //$sql.="       AND l.contas_bancarias_pk = ".$contas_bancarias_pk;
        $sql.="       AND l.dt_vencimento >='".DataYMD($dt_periodo_ini)." 00:00:00'";
        $sql.="       AND l.dt_vencimento <='".DataYMD($dt_periodo_fim)." 23:59:59'";        
        $sql.=" ORDER BY l.dt_vencimento";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
     public function listarGridReceita($_ds_mes,$_ds_ano,$pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim,  $ds_num_documento,$ic_tipo_num_documento){
          
        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="      date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')dt_cadastro,";
        $sql.="      c.ds_conta ds_empresa,";
        $sql.="      cb.ds_conta_bancaria,";
        $sql.="      SUBSTRING(u.ds_usuario,1, 15) ds_usuario,";
        $sql.="      date_format(l.dt_vencimento, '%d/%m/%Y')dt_vencimento,";
        $sql.="      date_format(l.dt_faturamento, '%d/%m/%Y') dt_faturamento,";
        $sql.="      date_format(l.dt_pagamento, '%d/%m/%Y') dt_pagamento,";
        $sql.="      case WHEN l.ic_status_pagamento = 1 THEN 'PAGO'";
        $sql.="        WHEN l.ic_status_pagamento = 2 THEN 'PENDENTE'";
        $sql.="        WHEN l.ic_status_pagamento = 3 THEN 'APROVADO'";
        $sql.="        WHEN l.ic_status_pagamento = 4 THEN 'ATRASADO'";
        $sql.="        WHEN l.ic_status_pagamento = 5 THEN 'CANCELADO'";
        $sql.="      END ds_status_pagamento,";
        $sql.="      l.ic_status_pagamento,";
        $sql.="      CASE l.operacao_pk";
        $sql.="          WHEN 1 THEN 'Receita'";
        $sql.="          WHEN 2 THEN 'Despesa Fixa'";
        $sql.="          WHEN 3 THEN 'Despesa Variada'";
        $sql.="          WHEN 4 THEN 'Imposto'";
        $sql.="          WHEN 5 THEN 'Transferência'";
        $sql.="          WHEN 6 THEN 'Caixinha'";
        $sql.="      END ds_operacao,";
        $sql.="      top.ds_tipo_operacao,";
        $sql.="      CASE l.tipo_grupo_pk";
        $sql.="          WHEN 1 THEN '(Clientes)'";
        $sql.="          WHEN 2 THEN 'Colaboradores'";
        $sql.="          WHEN 3 THEN 'Fornecedores'";
        $sql.="          WHEN 4 THEN 'Outros'";
        $sql.="       END  ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="       l.operacao_pk,";
        $sql.="       l.tipo_grupo_pk,";
        $sql.="       l.vl_lancamento,";
        $sql.="       l.ds_lancamento,";
        $sql.="       l.grupo_leancamento_pk";
        $sql.=" FROM lancamentos l";
        $sql.="     LEFT JOIN contas c on l.empresas_pk = c.pk";
        $sql.="     LEFT JOIN contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="     left JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="     LEFT JOIN tipos_operacao top ON l.tipos_operacao_pk = top.pk";
        $sql.="     left JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.=" WHERE l.operacao_pk = 1";
        
        if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){
  
            $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
            $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";
            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
               // $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }    

        }elseif (!empty($dt_cadastro_ini) and !empty($dt_cadastro_fim)) {
            $sql.=" AND l.dt_cadastro >= '".DataYMD($dt_cadastro_ini)." 00:00:00'";
            $sql.=" AND l.dt_cadastro <= '".DataYMD($dt_cadastro_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_faturamento_ini) and !empty($dt_faturamento_fim)) {
            $sql.=" AND l.dt_faturamento >= '".DataYMD($dt_faturamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_faturamento <= '".DataYMD($dt_faturamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_pagamento_ini) and !empty($dt_pagamento_fim)) {
            $sql.=" AND l.dt_pagamento >= '".DataYMD($dt_pagamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_pagamento <= '".DataYMD($dt_pagamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }

        }elseif(empty($pk)){
            if(empty($ic_status_pagamento)){   
                if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){       
                    $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
                    $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";  
                }
            }else{
                if($ic_status_pagamento==1){
                    $sql.=" AND l.dt_pagamento is not null";
                }elseif($ic_status_pagamento==4){
                    $sql.=" AND l.dt_pagamento is null";
                    $sql.=" AND l.dt_vencimento < sysdate()";
                    $sql.=" AND l.ic_status_pagamento<>1";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";    
                }else{
                    //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                }    
            }                                       
        }
        
        if(!empty($pk)){
            $sql.=" AND l.pk=".$pk;
        }
              
        if(!empty($usuario_cadastro_pk)){
            $sql.=" AND l.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        
        if(!empty($empresas_pk)){
            $sql.=" AND l.empresas_pk=".$empresas_pk;
        }
        
        if(!empty($tipo_grupo_pk)){
            $sql.=" AND l.tipo_grupo_pk=".$tipo_grupo_pk;
        }

        if(!empty($grupo_leancamento_pk)){
            $sql.=" AND l.grupo_leancamento_pk=".$grupo_leancamento_pk;
        }
        if(!empty($ds_num_documento)){
            $sql.=" AND l.ds_num_documento like '%".$ds_num_documento."%'";
        }
        if(!empty($ic_tipo_num_documento)){
            $sql.=" AND l.ic_tipo_num_documento = ".$ic_tipo_num_documento;
        }
        $sql.=" group by l.pk";
        $sql.=" ORDER BY l.dt_vencimento";

        $query = $this->db->execQuery($sql);
        return $query;
    }
        
    public function listarGridDespesa($_ds_mes,$_ds_ano,$pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ic_analise,$ds_num_documento,$ic_tipo_num_documento){
        $conta = new contadao();

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="      date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')dt_cadastro,";
        $sql.="      c.ds_conta ds_empresa,";
        $sql.="      cb.ds_conta_bancaria,";
        $sql.="      SUBSTRING(u.ds_usuario,1, 15) ds_usuario,";
        $sql.="      date_format(l.dt_vencimento, '%d/%m/%Y')dt_vencimento,";
        $sql.="      date_format(l.dt_faturamento, '%d/%m/%Y') dt_faturamento,";
        $sql.="      date_format(l.dt_pagamento, '%d/%m/%Y') dt_pagamento,";
        $sql.="      case WHEN l.ic_status_pagamento = 1 THEN 'PAGO'";
        $sql.="        WHEN l.ic_status_pagamento = 2 THEN 'PENDENTE'";
        $sql.="        WHEN l.ic_status_pagamento = 3 THEN 'APROVADO'";
        $sql.="        WHEN l.ic_status_pagamento = 4 THEN 'ATRASADO'";
        $sql.="        WHEN l.ic_status_pagamento = 5 THEN 'CANCELADO'";
        $sql.="      END ds_status_pagamento,";
        $sql.="      l.ic_status_pagamento,";
        $sql.="      CASE l.operacao_pk";
        $sql.="          WHEN 1 THEN 'Receita'";
        $sql.="          WHEN 2 THEN 'Despesa Fixa'";
        $sql.="          WHEN 3 THEN 'Despesa Variada'";
        $sql.="          WHEN 4 THEN 'Imposto'";
        $sql.="          WHEN 5 THEN 'Transferência'";
        $sql.="          WHEN 6 THEN 'Caixinha'";
        $sql.="      END ds_operacao,";
        $sql.="      top.ds_tipo_operacao,";
        $sql.="      CASE l.tipo_grupo_pk";
        $sql.="          WHEN 1 THEN '(Clientes)'";
        $sql.="          WHEN 2 THEN 'Colaboradores'";
        $sql.="          WHEN 3 THEN 'Fornecedores'";
        $sql.="          WHEN 4 THEN 'Outros'";
        $sql.="       END  ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="       l.operacao_pk,";
        $sql.="       l.tipo_grupo_pk,";
        $sql.="       l.vl_lancamento,";
        $sql.="       l.ds_lancamento,";
        $sql.="       l.grupo_leancamento_pk";
        $sql.=" FROM lancamentos l";
        $sql.="     left JOIN contas c on l.empresas_pk = c.pk";
        $sql.="     left JOIN contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="     INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="     LEFT JOIN tipos_operacao top ON l.tipos_operacao_pk = top.pk";
        $sql.="     INNER JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $ic_analise_financeira = $conta->configModulo();
        $ic_analise_financeira = $ic_analise_financeira[0]['ic_analise_financeira'];
        if($ic_analise_financeira == 1){
            $sql.="     LEFT JOIN analise_financeira af ON af.lancamentos_pk = l.pk";
            $sql.=" WHERE l.operacao_pk <> 1";
            $sql.=" and l.operacao_pk <> 1";
            if($ic_analise == 1){
                $sql.=" AND af.ic_status= 3";
            }else if($ic_analise == 2){
                $sql.=" AND af.ic_status is null";
            }else{
                $sql.=" AND (af.ic_status= 3 or";
                $sql.="      af.ic_status is null)";
            }
        }else{
            $sql.=" WHERE l.operacao_pk <> 1";
        }

        if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){
            $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
            $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";
            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
               // $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }    

        }elseif (!empty($dt_cadastro_ini) and !empty($dt_cadastro_fim)) {
            $sql.=" AND l.dt_cadastro >= '".DataYMD($dt_cadastro_ini)." 00:00:00'";
            $sql.=" AND l.dt_cadastro <= '".DataYMD($dt_cadastro_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_faturamento_ini) and !empty($dt_faturamento_fim)) {
            $sql.=" AND l.dt_faturamento >= '".DataYMD($dt_faturamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_faturamento <= '".DataYMD($dt_faturamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_pagamento_ini) and !empty($dt_pagamento_fim)) {
            $sql.=" AND l.dt_pagamento >= '".DataYMD($dt_pagamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_pagamento <= '".DataYMD($dt_pagamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }

        }elseif(empty($pk)){
            if(empty($ic_status_pagamento)){   
                if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){       
                    $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
                    $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";  
                }
            }else{
                if($ic_status_pagamento==1){
                    $sql.=" AND l.dt_pagamento is not null";
                }elseif($ic_status_pagamento==4){
                    $sql.=" AND l.dt_pagamento is null";
                    $sql.=" AND l.dt_vencimento < sysdate()";
                    $sql.=" AND l.ic_status_pagamento<>1";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";    
                }else{
                    //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                }    
            }                                       
        }
        
        if(!empty($pk)){
            $sql.=" AND l.pk=".$pk;
        }
              
        if(!empty($usuario_cadastro_pk)){
            $sql.=" AND l.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        
        if(!empty($empresas_pk)){
            $sql.=" AND l.empresas_pk=".$empresas_pk;
        }
        
        if(!empty($tipo_grupo_pk)){
            $sql.=" AND l.tipo_grupo_pk=".$tipo_grupo_pk;
        }

        if(!empty($grupo_leancamento_pk)){
            $sql.=" AND l.grupo_leancamento_pk=".$grupo_leancamento_pk;
        }
        if(!empty($ds_num_documento)){
            $sql.=" AND l.ds_num_documento like '%".$ds_num_documento."%'";
        }
        if(!empty($ic_tipo_num_documento)){
            $sql.=" AND l.ic_tipo_num_documento = ".$ic_tipo_num_documento;
        }
        $sql.=" group by l.pk";
        $sql.=" ORDER BY l.dt_vencimento";
        //echo $sql;

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarGridLancamento($pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim,$ds_num_documento,$ic_tipo_num_documento){
        $conta = new contadao();
        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="      date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')dt_cadastro,";
        $sql.="      c.ds_conta ds_empresa,";
        $sql.="      cb.ds_conta_bancaria,";
        $sql.="      SUBSTRING(u.ds_usuario,1, 15) ds_usuario,";
        $sql.="      date_format(l.dt_vencimento, '%d/%m/%Y')dt_vencimento,";
        $sql.="      date_format(l.dt_faturamento, '%d/%m/%Y') dt_faturamento,";
        $sql.="      date_format(l.dt_pagamento, '%d/%m/%Y') dt_pagamento,";
        $sql.="      case WHEN l.ic_status_pagamento = 1 THEN 'PAGO'";
        $sql.="        WHEN l.ic_status_pagamento = 2 THEN 'PENDENTE'";
        $sql.="        WHEN l.ic_status_pagamento = 3 THEN 'APROVADO'";
        $sql.="        WHEN l.ic_status_pagamento = 4 THEN 'ATRASADO'";
        $sql.="        WHEN l.ic_status_pagamento = 5 THEN 'CANCELADO'";
        $sql.="      END ds_status_pagamento,";
        $sql.="      l.ic_status_pagamento,";
        $sql.="      CASE l.operacao_pk";
        $sql.="          WHEN 1 THEN 'Receita'";
        $sql.="          WHEN 2 THEN 'Despesa Fixa'";
        $sql.="          WHEN 3 THEN 'Despesa Variada'";
        $sql.="          WHEN 4 THEN 'Imposto'";
        $sql.="          WHEN 5 THEN 'Transferência'";
        $sql.="          WHEN 6 THEN 'Caixinha'";
        $sql.="      END ds_operacao,";
        $sql.="      top.ds_tipo_operacao,";
        $sql.="      CASE l.tipo_grupo_pk";
        $sql.="          WHEN 1 THEN '(Clientes)'";
        $sql.="          WHEN 2 THEN 'Colaboradores'";
        $sql.="          WHEN 3 THEN 'Fornecedores'";
        $sql.="          WHEN 4 THEN 'Outros'";
        $sql.="       END  ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="       l.operacao_pk,";
        $sql.="       l.tipo_grupo_pk,";
        $sql.="       l.vl_lancamento,";
        $sql.="       l.grupo_leancamento_pk,";
        $sql.="       l.ds_lancamento,";
        $sql.="       CASE";
        $sql.="          WHEN af.ic_status = 1 THEN 'Não Analisado'";
        $sql.="          WHEN af.ic_status = 2 THEN 'Aprovado Analista'";
        $sql.="          WHEN af.ic_status = 3 THEN 'Aprovado Gestor'";
        $sql.="          WHEN af.ic_status = 4 THEN 'Correção Solicitada'";
        $sql.="          WHEN af.ic_status = 5 THEN 'Recusado'";
        $sql.="          WHEN af.ic_status = 6 THEN 'Correção Feita'";
        $sql.="          WHEN af.ic_status = 7 THEN 'Cancelado'";
        $sql.="          END ds_status_analise";
        $sql.=" FROM lancamentos l";
        $sql.="     LEFT JOIN contas c on l.empresas_pk = c.pk";
        $sql.="     LEFT JOIN contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="     INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="     LEFT JOIN tipos_operacao top ON l.tipos_operacao_pk = top.pk";
        $sql.="     INNER JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.="     LEFT JOIN analise_financeira af ON l.pk = af.lancamentos_pk";
        $sql.=" WHERE 1=1";
        $ic_analise_financeira = $conta->configModulo();
        $ic_analise_financeira = $ic_analise_financeira[0]['ic_analise_financeira'];
        if($ic_analise_financeira == 1){
            $sql.=" and (af.ic_status is null || af.ic_status = 3)";
        }

        if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){

            $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
            $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";
            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
               // $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }    

        }elseif (!empty($dt_cadastro_ini) and !empty($dt_cadastro_fim)) {
            $sql.=" AND l.dt_cadastro >= '".DataYMD($dt_cadastro_ini)." 00:00:00'";
            $sql.=" AND l.dt_cadastro <= '".DataYMD($dt_cadastro_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_faturamento_ini) and !empty($dt_faturamento_fim)) {
            $sql.=" AND l.dt_faturamento >= '".DataYMD($dt_faturamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_faturamento <= '".DataYMD($dt_faturamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_pagamento_ini) and !empty($dt_pagamento_fim)) {
            $sql.=" AND l.dt_pagamento >= '".DataYMD($dt_pagamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_pagamento <= '".DataYMD($dt_pagamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }

        }elseif(empty($pk)){
            if(empty($ic_status_pagamento)){   
                if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){       
                    $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
                    $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";  
                }
            }else{
                if($ic_status_pagamento==1){
                    $sql.=" AND l.dt_pagamento is not null";
                }elseif($ic_status_pagamento==4){
                    $sql.=" AND l.dt_pagamento is null";
                    $sql.=" AND l.dt_vencimento < sysdate()";
                    $sql.=" AND l.ic_status_pagamento<>1";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";    
                }else{
                    //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                }    
            }                                       
        }
        
        if(!empty($pk)){
            $sql.=" AND l.pk=".$pk;
        }
        
        if(!empty($usuario_cadastro_pk)){
            $sql.=" AND l.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        
        if(!empty($empresas_pk)){
            $sql.=" AND l.empresas_pk=".$empresas_pk;
        }
        
        if(!empty($tipo_grupo_pk)){
            $sql.=" AND l.tipo_grupo_pk=".$tipo_grupo_pk;
        }

        if(!empty($grupo_leancamento_pk)){
            $sql.=" AND l.grupo_leancamento_pk=".$grupo_leancamento_pk;
        }
        if(!empty($ds_num_documento)){
            $sql.=" AND l.ds_num_documento like '%".$ds_num_documento."%'";
        }
        if(!empty($ic_tipo_num_documento)){
            $sql.=" AND l.ic_tipo_num_documento = ".$ic_tipo_num_documento;
        }
        $sql.=" Group by l.pk";
        $sql.=" ORDER BY l.dt_vencimento desc";
     
        $query = $this->db->execQuery($sql);

        if(count($query) > 0){
            $vl_lancamento = 0;
            $vl_lancamento_pendente  = 0;
            $vl_lancamento_dia = 0;
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $this->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $this->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $this->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }

                $data = $query[$i]["dt_vencimento"];
                $l = $i - 1;
                $a = $i + 1;

                $data_anterior = $query[$l]["dt_vencimento"];
                if($data_anterior == null){
                  $data_anterior = "";
                }
                $proxima_data = $query[$a]["dt_vencimento"];
                if($proxima_data == null){
                    $proxima_data = "";
                }

                //if($query[$i]["operacao_pk"]!=1){
                    $vl_lancamento += $query[$i]["vl_lancamento"];
                //}
                
                if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                    if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                        $vl_lancamento_pendente += $query[$i]["vl_lancamento"];
                    }    
                }
                if($data_anterior == $data){
                    $vl_lancamento_dia += $query[$i]["vl_lancamento"];
                    $vl_lancamento_pendente_dia = "";
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_lancamento_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }else{
                    $vl_lancamento_dia = $query[$i]["vl_lancamento"];
                    $vl_lancamento_pendente_dia = "";
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_lancamento_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }
                
                                                
                $extrato[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_empresa" => $query[$i]["ds_empresa"],
                    "ds_conta_bancaria" => $query[$i]["ds_conta_bancaria"],
                    "ds_status_pagamento" => $query[$i]["ds_status_pagamento"],                    
                    "ds_lancamento" => $query[$i]["ds_lancamento"],                    
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                    "ds_recebido_pago_origem" => $ds_recebido_de,
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "vl_lancamento_dia" =>  number_format($vl_lancamento_dia, 2, ',', '.'),                            
                    "vl_lancamento_pendente_dia" =>  number_format($vl_lancamento_pendente_dia, 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],  
                    "ds_status_analise" => $query[$i]["ds_status_analise"],  
                    "proxima_data" => $proxima_data,                              
                    "t_functions" => ""
                );
            } 
            
            $result[] = array(             
                "vl_total_lancamento" =>  number_format($vl_lancamento, 2, ',', '.'),
                "vl_total_lancamento_pendente" =>  number_format($vl_lancamento_pendente, 2, ',', '.'),
                "DadosExtratoLancamento"=>$extrato, 
                "t_functions" => ""
            );
        }
        return $result;
    }

    public function listarGridLancamentoUsuarios($pk,$ic_status_pagamento,$usuario_cadastro_pk,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim,$dt_vencimento_ini,$dt_vencimento_fim,$dt_pagamento_ini,$dt_pagamento_fim, $ic_status_analise, $ds_num_documento,$ic_tipo_num_documento,$leads_pk){
        $conta = new contadao();
        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="      date_format(l.dt_cadastro, '%d/%m/%Y %H:%i')dt_cadastro,";
        $sql.="      c.ds_conta ds_empresa,";
        $sql.="      cb.ds_conta_bancaria,";
        $sql.="      SUBSTRING(u.ds_usuario,1, 15) ds_usuario,";
        $sql.="      date_format(l.dt_vencimento, '%d/%m/%Y')dt_vencimento,";
        $sql.="      date_format(l.dt_faturamento, '%d/%m/%Y') dt_faturamento,";
        $sql.="      date_format(l.dt_pagamento, '%d/%m/%Y') dt_pagamento,";
        $sql.="      case WHEN l.ic_status_pagamento = 1 THEN 'PAGO'";
        $sql.="        WHEN l.ic_status_pagamento = 2 THEN 'PENDENTE'";
        $sql.="        WHEN l.ic_status_pagamento = 3 THEN 'APROVADO'";
        $sql.="        WHEN l.ic_status_pagamento = 4 THEN 'ATRASADO'";
        $sql.="        WHEN l.ic_status_pagamento = 5 THEN 'CANCELADO'";
        $sql.="      END ds_status_pagamento,";
        $sql.="      l.ic_status_pagamento,";
        $sql.="      CASE l.operacao_pk";
        $sql.="          WHEN 1 THEN 'Receita'";
        $sql.="          WHEN 2 THEN 'Despesa Fixa'";
        $sql.="          WHEN 3 THEN 'Despesa Variada'";
        $sql.="          WHEN 4 THEN 'Imposto'";
        $sql.="          WHEN 5 THEN 'Transferência'";
        $sql.="          WHEN 6 THEN 'Caixinha'";
        $sql.="      END ds_operacao,";
        $sql.="      top.ds_tipo_operacao,";
        $sql.="      CASE l.tipo_grupo_pk";
        $sql.="          WHEN 1 THEN '(Clientes)'";
        $sql.="          WHEN 2 THEN 'Colaboradores'";
        $sql.="          WHEN 3 THEN 'Fornecedores'";
        $sql.="          WHEN 4 THEN 'Outros'";
        $sql.="       END  ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="       l.operacao_pk,";
        $sql.="       l.tipo_grupo_pk,";
        $sql.="       l.vl_lancamento,";
        $sql.="       l.grupo_leancamento_pk,";
        $sql.="       l.ds_lancamento,";
        $sql.="       CASE";
        $sql.="          WHEN af.ic_status = 1 THEN 'Não Analisado'";
        $sql.="          WHEN af.ic_status = 2 THEN 'Aprovado Analista'";
        $sql.="          WHEN af.ic_status = 3 THEN 'Aprovado Gestor'";
        $sql.="          WHEN af.ic_status = 4 THEN 'Correção Solicitada'";
        $sql.="          WHEN af.ic_status = 5 THEN 'Recusado'";
        $sql.="          WHEN af.ic_status = 6 THEN 'Correção Feita'";
        $sql.="          WHEN af.ic_status = 7 THEN 'Cancelado'";
        $sql.="          END ds_status_analise";
        $sql.=" FROM lancamentos l";
        $sql.="     LEFT JOIN contas c on l.empresas_pk = c.pk";
        $sql.="     LEFT JOIN contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="     INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="     LEFT JOIN tipos_operacao top ON l.tipos_operacao_pk = top.pk";
        $sql.="     INNER JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.="     LEFT JOIN analise_financeira af ON l.pk = af.lancamentos_pk";
        $sql.=" WHERE 1=1";
        $ic_analise_financeira = $conta->configModulo();
        $ic_analise_financeira = $ic_analise_financeira[0]['ic_analise_financeira'];
        if($ic_status_analise != ""){
            $sql.=" AND af.ic_status = $ic_status_analise";
        }

        if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){
            $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
            $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";
            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
               // $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }    

        }elseif (!empty($dt_cadastro_ini) and !empty($dt_cadastro_fim)) {
            $sql.=" AND l.dt_cadastro >= '".DataYMD($dt_cadastro_ini)." 00:00:00'";
            $sql.=" AND l.dt_cadastro <= '".DataYMD($dt_cadastro_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_faturamento_ini) and !empty($dt_faturamento_fim)) {
            $sql.=" AND l.dt_faturamento >= '".DataYMD($dt_faturamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_faturamento <= '".DataYMD($dt_faturamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }
        }elseif (!empty($dt_pagamento_ini) and !empty($dt_pagamento_fim)) {
            $sql.=" AND l.dt_pagamento >= '".DataYMD($dt_pagamento_ini)." 00:00:00'";
            $sql.=" AND l.dt_pagamento <= '".DataYMD($dt_pagamento_fim)." 23:59:00'"; 

            // Status
            if($ic_status_pagamento==1){
                $sql.=" AND l.dt_pagamento is not null";
            }elseif($ic_status_pagamento==4){
                $sql.=" AND l.dt_pagamento is null";
                $sql.=" AND l.dt_vencimento < sysdate()";
                $sql.=" AND l.ic_status_pagamento<>1";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";
            }elseif($ic_status_pagamento==2){
                $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                $sql.=" AND l.dt_pagamento is null";    
            }else{
                //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
            }

        }elseif(empty($pk)){
            if(empty($ic_status_pagamento)){   
                if(!empty($dt_vencimento_ini) and !empty($dt_vencimento_fim)){       
                    $sql.=" AND l.dt_vencimento >= '".DataYMD($dt_vencimento_ini)." 00:00:00'";
                    $sql.=" AND l.dt_vencimento <= '".DataYMD($dt_vencimento_fim)." 23:59:00'";  
                }
            }else{
                if($ic_status_pagamento==1){
                    $sql.=" AND l.dt_pagamento is not null";
                }elseif($ic_status_pagamento==4){
                    $sql.=" AND l.dt_pagamento is null";
                    $sql.=" AND l.dt_vencimento < sysdate()";
                    $sql.=" AND l.ic_status_pagamento<>1";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";
                }elseif($ic_status_pagamento==2){
                    $sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                    $sql.=" AND l.dt_pagamento is null";    
                }else{
                    //$sql.=" AND l.ic_status_pagamento=".$ic_status_pagamento;
                }    
            }                                       
        }
        
        if(!empty($pk)){
            $sql.=" AND l.pk=".$pk;
        }
        
        if(!empty($usuario_cadastro_pk)){
            $sql.=" AND l.usuario_cadastro_pk=".$usuario_cadastro_pk;
        }
        
        if(!empty($empresas_pk)){
            $sql.=" AND l.empresas_pk=".$empresas_pk;
        }
        
        if(!empty($tipo_grupo_pk)){
            $sql.=" AND l.tipo_grupo_pk=".$tipo_grupo_pk;
        }

        if(!empty($grupo_leancamento_pk)){
            $sql.=" AND l.grupo_leancamento_pk=".$grupo_leancamento_pk;
        }
        if(!empty($ds_num_documento)){
            $sql.=" AND l.ds_num_documento like '%".$ds_num_documento."%'";
        }
        if(!empty($ic_tipo_num_documento)){
            $sql.=" AND l.ic_tipo_num_documento = ".$ic_tipo_num_documento;
        }

        if(!empty($leads_pk)){
            $sql.=" AND l.grupo_leancamento_pk =".$leads_pk;
        }

        $sql.=" Group by l.pk";
        $sql.=" ORDER BY l.dt_vencimento desc";

        $query = $this->db->execQuery($sql);

        if(count($query) > 0){
            $vl_lancamento = 0;
            $vl_lancamento_pendente  = 0;
            $vl_lancamento_dia = 0;
            for($i = 0; $i < count($query); $i++){
                if($query[$i]['tipo_grupo_pk']==1){
                    $queryLead = $this->listaItensGrupoLeads($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_lead'];
                }else if($query[$i]['tipo_grupo_pk']==2){
                    $queryLead = $this->listaItensGrupoColaboradores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_colaborador'];
                }else if($query[$i]['tipo_grupo_pk']==3){
                    $queryLead = $this->listaItensGrupoFornecedores($query[$i]['grupo_leancamento_pk']);
                    $ds_recebido_de = $queryLead[0]['ds_fornecedor'];
                }

                $data = $query[$i]["dt_vencimento"];
                $l = $i - 1;
                $a = $i + 1;

                $data_anterior = $query[$l]["dt_vencimento"];
                if($data_anterior == null){
                  $data_anterior = "";
                }
                $proxima_data = $query[$a]["dt_vencimento"];
                if($proxima_data == null){
                    $proxima_data = "";
                }

                //if($query[$i]["operacao_pk"]!=1){
                    $vl_lancamento += $query[$i]["vl_lancamento"];
                //}
                
                if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                    if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                        $vl_lancamento_pendente += $query[$i]["vl_lancamento"];
                    }    
                }
                if($data_anterior == $data){
                    $vl_lancamento_dia += $query[$i]["vl_lancamento"];
                    $vl_lancamento_pendente_dia = "";
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_lancamento_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }else{
                    $vl_lancamento_dia = $query[$i]["vl_lancamento"];
                    $vl_lancamento_pendente_dia = "";
                    if($query[$i]["dt_vencimento"] <=  date('d/m/Y')){
                        if($query[$i]["ic_status_pagamento"]!=1 and $query[$i]["dt_pagamento"]==""){
                            $vl_lancamento_pendente_dia += $query[$i]["vl_lancamento"];
                        }    
                    }
                }
                
                                                
                $extrato[] = array(
                    "pk" => $query[$i]["pk"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_empresa" => $query[$i]["ds_empresa"],
                    "ds_conta_bancaria" => $query[$i]["ds_conta_bancaria"],
                    "ds_status_pagamento" => $query[$i]["ds_status_pagamento"],                    
                    "ds_lancamento" => $query[$i]["ds_lancamento"],                    
                    "dt_vencimento" => $query[$i]["dt_vencimento"],
                    "dt_faturamento" => $query[$i]["dt_faturamento"],
                    "dt_pagamento" => $query[$i]["dt_pagamento"],
                    "ds_operacao" => $query[$i]["ds_operacao"],
                    "ds_tipo_grupo" => $query[$i]["ds_tipo_grupo"],                    
                    "ds_recebido_pago_origem" => $ds_recebido_de,
                    "ds_metodo_pagamento" => $query[$i]["ds_metodo_pagamento"],                    
                    "vl_lancamento" =>  number_format($query[$i]["vl_lancamento"], 2, ',', '.'),                            
                    "vl_lancamento_dia" =>  number_format($vl_lancamento_dia, 2, ',', '.'),                            
                    "vl_lancamento_pendente_dia" =>  number_format($vl_lancamento_pendente_dia, 2, ',', '.'),                            
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "operacao_pk" => $query[$i]["operacao_pk"],
                    "ds_tipo_operacao" => $query[$i]["ds_tipo_operacao"],
                    "ic_status_pagamento" => $query[$i]["ic_status_pagamento"],  
                    "ds_status_analise" => $query[$i]["ds_status_analise"],  
                    "proxima_data" => $proxima_data,                              
                    "t_functions" => ""
                );
            } 
            
            $result[] = array(             
                "vl_total_lancamento" =>  number_format($vl_lancamento, 2, ',', '.'),
                "vl_total_lancamento_pendente" =>  number_format($vl_lancamento_pendente, 2, ',', '.'),
                "DadosExtratoLancamento"=>$extrato, 
                "t_functions" => ""
            );
        }
        return $result;
    }


    public function lisarLancamentoPk($pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk, ";
        $sql.="       c.ds_lancamento,";
        $sql.="       c.operacao_pk,";
        $sql.="       c.categoria_operacao_pk,";
        $sql.="       c.tipos_operacao_pk,";
        $sql.="       c.tipo_grupo_pk,";
        $sql.="       c.grupo_leancamento_pk,";
        $sql.="       c.leads_clientes_pk,";
        $sql.="       c.leads_posto_trabalho_pk,";
        $sql.="       c.contratos_pk,";
        $sql.="       c.colaborador_pk,";
        $sql.="       c.colaborador_posto_trabalho_pk,";
        $sql.="       c.colaborador_contratos_pk,";
        $sql.="       c.fornecedor_pk,";
        $sql.="       c.fornecedor_posto_trabalho_pk,";
        $sql.="       c.fornecedor_contratos_pk,";
        $sql.="       c.tipo_grupo_centro_custo_pk,";
        $sql.="       c.grupo_lancamento_centro_custo_pk,"; 
        $sql.="       date_format(c.dt_faturamento, '%d/%m/%Y')dt_faturamento,";
        $sql.="       date_format(c.dt_vencimento, '%d/%m/%Y')dt_vencimento,";
        $sql.="       c.vl_lancamento,";
        $sql.="       c.metodos_pagamento_pk,";
        $sql.="       c.empresas_pk,";
        $sql.="       c.contas_bancarias_pk,";
        $sql.="       c.ic_status_pagamento,";
        $sql.="       date_format(c.dt_pagamento, '%d/%m/%Y')dt_pagamento,";
        $sql.="       c.obs_lancamento,";
        $sql.="       c.parcela_pk,";
        $sql.="       c.ic_tipo_num_documento,";
        $sql.="       c.ds_num_documento";
        $sql.="    FROM  lancamentos c";
        $sql.="    WHERE  pk = ".$pk;       
        //echo $sql;
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    //Antigo
    public function carregarPorPk($pk){

        $lancamento = new lancamento();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_lancamento ";
        $sql.="       ,vl_lancamento ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,ic_status_pagamento ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,dt_competencia ";
        $sql.="       ,n_documento ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,empresas_pk";
        $sql.="       ,tipo_grupo_centro_custo_pk";
        $sql.="       ,grupo_lancamento_centro_custo_pk";
        $sql.="       ,ds_ocorrencia";
        $sql.="       ,contratos_pk";
        $sql.="       ,dt_faturamento";
        $sql.="  from lancamentos ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lancamento->setpk($query[$i]["pk"]);
                $lancamento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lancamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lancamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lancamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lancamento->setdt_vencimento($query[$i]['dt_vencimento']);
                $lancamento->setds_lancamento($query[$i]['ds_lancamento']);
                $lancamento->setvl_lancamento($query[$i]['vl_lancamento']);
                $lancamento->setoperacao_pk($query[$i]['operacao_pk']);
                $lancamento->settipo_grupo_pk($query[$i]['tipo_grupo_pk']);
                $lancamento->setgrupo_leancamento_pk($query[$i]['grupo_leancamento_pk']);
                $lancamento->setic_status_pagamento($query[$i]['ic_status_pagamento']);
                $lancamento->setobs_lancamento($query[$i]['obs_lancamento']);
                $lancamento->setdt_competencia($query[$i]['dt_competencia']);
                $lancamento->setn_documento($query[$i]['n_documento']);
                $lancamento->setcontas_bancarias_pk($query[$i]['contas_bancarias_pk']);
                $lancamento->settipos_operacao_pk($query[$i]['tipos_operacao_pk']);
                $lancamento->setmetodos_pagamento_pk($query[$i]['metodos_pagamento_pk']);
                $lancamento->setempresas_pk($query[$i]['empresas_pk']);
                $lancamento->settipo_grupo_centro_custo_pk($query[$i]['tipo_grupo_centro_custo_pk']);
                $lancamento->setgrupo_lancamento_centro_custo_pk($query[$i]['grupo_lancamento_centro_custo_pk']);
                $lancamento->setds_ocorrencia($query[$i]['ds_ocorrencia']);
                $lancamento->setcontratos_pk($query[$i]['contratos_pk']);
                $lancamento->setdt_faturamento($query[$i]['dt_faturamento']);

            }
        }
        return $lancamento;
    }

    public function listarPorPk($pk){
        $sql ="";
        $sql.="select l.pk, date_format(l.dt_cadastro,'%d/%m/%Y %H:%i:%s') dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,case l.tipo_grupo_centro_custo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Centro de Custo' end ds_tipo_grupo_centro_custo";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,u.ds_usuario";
        $sql.="       ,concat(cf.ds_categoria,' - ',top.ds_tipo_operacao )ds_tipo_operacao";
        $sql.="       ,concat (b.ds_banco,' - AG:',cb.ds_agencia,' - Cont:',cb.ds_conta) ds_dados_conta ";
        $sql.="       ,le.ds_lead ds_cliente ";
        $sql.="       ,l.leads_posto_trabalho_pk";
        $sql.="       ,l.colaborador_posto_trabalho_pk";
        $sql.="       ,l.fornecedor_posto_trabalho_pk";
        $sql.="       ,l.colaborador_contratos_pk";
        $sql.="       ,l.fornecedor_contratos_pk";
        $sql.="  from lancamentos l";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join categorias_financeiras cf on cf.pk = top.categorias_financeiras_pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join bancos b on cb.bancos_pk = b.pk ";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";  
        $sql.="  left join leads le on l.leads_clientes_pk = le.pk ";    
        $sql.="  left join colaboradores cl on l.colaborador_pk = cl.pk ";    
        $sql.=" where 1=1 ";
        /*if($operacao_pk != ""){
            $sql.=" and l.operacao_pk = ".$operacao_pk;
        }*/
        /*if($contas_banarias_pk != ""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_banarias_pk;
        }*/
        if($pk!=""){
            $sql.=" and l.pk  = ".$pk;
        }
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento asc ";
        //echo $sql;
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_vencimento($dt_vencimento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_lancamento ";
        $sql.="       ,vl_lancamento ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,date_format(dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,ic_status_pagamento ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,dt_competencia ";
        $sql.="       ,n_documento ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,empresas_pk";
        $sql.="       ,tipo_grupo_centro_custo_pk";
        $sql.="       ,grupo_lancamento_centro_custo_pk";
        $sql.="       ,ds_ocorrencia";
        $sql.="       ,contratos_pk";

        $sql.="  from lancamentos ";
        $sql.=" where 1=1 ";
        if($dt_vencimento != ""){
            $sql.=" and ds_lancamento like '%".$dt_vencimento."%' ";
        }
        $sql.=" order by dt_vencimento asc ";
       

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listaContaEmpresa($contas_pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from contas_bancarias ";
        $sql.=" where empresas_pk =  ".$contas_pk;
        $sql.=" order by pk asc";
       
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPkDocumentos($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from documentos ";
        $sql.=" where lancamentos_pk =  ".$pk;

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarReceita($operacao_pk,$dt_vencimento_ini,$dt_vencimento_fim,$contas_banarias_pk){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";

        $sql.="  from lancamentos l";
        $sql.="  inner join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  inner join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  inner join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  inner join contas co on l.empresas_pk = co.pk";
        $sql.=" where 1=1 ";
        if($operacao_pk != ""){
            $sql.=" and l.operacao_pk = ".$operacao_pk;
        }
        if($contas_banarias_pk != ""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_banarias_pk;
        }
        if($dt_vencimento_ini!=""){
            $sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
        }
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento asc ";
        

       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function RelatorioLancamento($tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_lancamento_ini,$dt_lancamento_fim,$dt_pagamento_ini,$dt_pagamento_fim,$plano_contas,$dt_faturamento_ini,$dt_faturamento_fim){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";        
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";        
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="  from lancamentos l";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($tipo_lancamento_pk == 1){
            $sql.=" and l.operacao_pk = 1";
        }
        else if($tipo_lancamento_pk == 2){
            $sql.=" and l.operacao_pk <> 1";
        }
        if($empresas_pk != ""){
            $sql.=" and l.empresas_pk = ".$empresas_pk;
        }
        if($tipo_grupo_pk != ""){
            $sql.=" and l.tipo_grupo_pk = ".$tipo_grupo_pk;
        }
        if($grupo_leancamento_pk != ""){
            $sql.=" and l.grupo_leancamento_pk = ".$grupo_leancamento_pk;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and l.usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        if($ic_status_pagamento != ""){
            $sql.=" and l.ic_status_pagamento = ".$ic_status_pagamento;
        }
        if($dt_vencimento_ini!=""){
            $sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
        }
        
        if($dt_faturamento_ini!=""){
            $sql.=" and l.dt_faturamento between '".DataYMD($dt_faturamento_ini)."' and '".DataYMD($dt_faturamento_fim)."'";
        }
        
        if($dt_pagamento_ini!=""){
            $sql.=" and l.dt_pagamento between '".DataYMD($dt_pagamento_ini)."' and '".DataYMD($dt_pagamento_fim)."'";
        }
        
        if(!empty($plano_contas)){
            $sql.=" and top.pk=".$plano_contas;
        }
      
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioLancamentoPago($dt_pagamento_ini,$dt_pagamento_fim,$pk_cliente,$cnpj_cliente,$cnpj_fornecedor,$grupo_leancamento,$dt_lancamento_ini,$dt_lancamento_fim,$lancamento_pk,$tipo_lancamento_pk){

        $sql ="";
        $sql.="select l.pk, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,date_format(l.dt_cadastro ,'%d/%m/%Y %H:%i:%s')dt_cadastro";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="  from lancamentos l";
        $sql.="  left join fornecedor f on l.grupo_leancamento_pk = f.pk";
        $sql.="  left join leads ld on l.grupo_leancamento_pk = ld.pk";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($tipo_lancamento_pk == 1){
            $sql.=" and l.operacao_pk = 1";
        }
        else if($tipo_lancamento_pk == 2){
            $sql.=" and l.operacao_pk <> 1";
        }
        if($pk_cliente != ""){
            $sql.=" and f.pk = ".$pk_cliente." or ld.pk=".$pk_cliente;
        }
        if($lancamento_pk != ""){
            $sql.=" and l.pk = ".$lancamento_pk;
        }
        /*if($cnpj_cliente != ""){
            $sql.=" and ld.ds_cpf_cnpj like'%".$cnpj_cliente."%'";
        }
        if($cnpj_fornecedor != ""){
            $sql.=" and f.ds_cpf_cnpj like'%".$cnpj_fornecedor."%'";
        }*/
        if($grupo_leancamento != ""){
            $sql.=" and l.grupo_leancamento_pk ".$grupo_leancamento;
        }
        
        if($dt_pagamento_ini!=""){
            $sql.=" and l.dt_pagamento between '".DataYMD($dt_pagamento_ini)." 00:00:00' and '".DataYMD($dt_pagamento_fim)." 23:59:59'";
        }
        if($dt_lancamento_ini!=""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_lancamento_ini)." 00:00:00' and '".DataYMD($dt_lancamento_fim)." 23:59:59'";
        }
        $sql.=" and l.ic_status_pagamento=1";
        
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_pagamento asc ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLancamentosMes($pk,$contas_bancarias_pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_pagamento_ini,$dt_pagamento_fim,$dt_faturamento_ini,$dt_faturamento_fim){

        $sql ="";
        $sql.="select l.pk, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,date_format(l.dt_cadastro ,'%d/%m/%Y %H:%i:%s')dt_cadastro";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="  from lancamentos l";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
        if($contas_bancarias_pk != ""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_bancarias_pk;
        }
        if($tipo_lancamento_pk != ""){
            $sql.=" and l.operacao_pk = ".$tipo_lancamento_pk;
        }
        if($empresas_pk != ""){
            $sql.=" and l.empresas_pk = ".$empresas_pk;
        }
        if($tipo_grupo_pk != ""){
            $sql.=" and l.tipo_grupo_pk = ".$tipo_grupo_pk;
        }
        if($grupo_leancamento_pk != ""){
            $sql.=" and l.grupo_leancamento_pk = ".$grupo_leancamento_pk;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and l.usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        if($ic_status_pagamento != ""){
            $sql.=" and l.ic_status_pagamento = ".$ic_status_pagamento;
        }
        if($dt_vencimento_ini!=""){
            $sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
        }
        if($dt_pagamento_ini!=""){
            $sql.=" and l.dt_pagamento between '".DataYMD($dt_pagamento_ini)." 00:00:00' and '".DataYMD($dt_pagamento_fim)." 23:59:59'";
        }
        if($dt_faturamento_ini!=""){
            $sql.=" and l.dt_faturamento between '".DataYMD($dt_faturamento_ini)."' and '".DataYMD($dt_faturamento_fim)."'";
        }
        if($dt_cadastro_ini!=""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
      
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLancamentosVencidoDia($pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim){
        $sql="SELECT CURDATE() dt_atual";
        $query1 = $this->db->execQuery($sql);
        
        
        
        $sql ="";
        $sql.="select l.pk, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
         $sql.="       ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,date_format(l.dt_cadastro ,'%d/%m/%Y %H:%i:%s')dt_cadastro";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="  from lancamentos l";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
        if($tipo_lancamento_pk == 1){
            $sql.=" and l.operacao_pk = 1";
        }
        else{
            $sql.=" and l.operacao_pk <> 1";
        }
        if($empresas_pk != ""){
            $sql.=" and l.empresas_pk = ".$empresas_pk;
        }
        if($tipo_grupo_pk != ""){
            $sql.=" and l.tipo_grupo_pk = ".$tipo_grupo_pk;
        }
        if($grupo_leancamento_pk != ""){
            $sql.=" and l.grupo_leancamento_pk = ".$grupo_leancamento_pk;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and l.usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        /*if($contas_banarias_pk != ""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_banarias_pk;
        }*/
        if($dt_vencimento_ini!=""){
            $sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
        }
        else{
            $sql.=" and l.dt_vencimento between '".$query1[0]['dt_atual']."' and '".$query1[0]['dt_atual']."'";
        }
        if($dt_cadastro_ini!=""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        if($dt_faturamento_ini!=""){
            $sql.=" and l.dt_faturamento between '".DataYMD($dt_faturamento_ini)."' and '".DataYMD($dt_faturamento_fim)."'";
        }
        
        if($ic_status_pagamento!=""){
            $sql.=" and l.ic_status_pagamento = ".$ic_status_pagamento;
        }
        else{
            $sql.=" and l.ic_status_pagamento <> 1 ";
        }
        
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento desc ";
      

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarLancamentosAtrasado($pk,$tipo_lancamento_pk,$dt_vencimento_ini,$dt_vencimento_fim,$ic_status_pagamento,$empresas_pk,$tipo_grupo_pk,$grupo_leancamento_pk,$usuario_cadastro_pk,$dt_cadastro_ini,$dt_cadastro_fim,$dt_faturamento_ini,$dt_faturamento_fim){
        $sql="SELECT CURDATE() dt_atual";
        $query1 = $this->db->execQuery($sql);
        
        
        
        $sql ="";
        $sql.="select l.pk, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(l.dt_vencimento ,'%d/%m/%Y')dt_vencimento";
         $sql.="      ,date_format(l.dt_pagamento ,'%d/%m/%Y')dt_pagamento";
        $sql.="       ,date_format(l.dt_cadastro ,'%d/%m/%Y %H:%i:%s')dt_cadastro";
        $sql.="       ,l.ds_lancamento ";
        $sql.="       ,l.vl_lancamento ";
        $sql.="       ,l.operacao_pk ";
        $sql.="       ,date_format(l.dt_faturamento,'%d/%m/%Y')dt_faturamento";
        $sql.="       ,case l.operacao_pk when 1 then 'Receita' when 2 then 'Despesa Fixa' when 3 then 'Despesa Variada' when 4 then 'Imposto' when 5 then 'Transferência' when 6 then 'Caixinha' end ds_operacao";
        $sql.="       ,l.tipo_grupo_pk ";
        $sql.="       ,case l.tipo_grupo_pk when 1 then 'Leads (Clientes)' when 2 then 'Colaboradores' when 3 then 'Fornecedores' when 4 then 'Outros' end ds_tipo_grupo";
        $sql.="       ,l.grupo_leancamento_pk ";
        $sql.="       ,l.ic_status_pagamento";
        $sql.="       ,case l.ic_status_pagamento when 1 then 'Pago' when 2 then 'Pendente' when 3 then 'Aprovado' when 4 then 'Atrasado' when 5 then 'Cancelado'  end ds_status_pagamento";
        $sql.="       ,l.obs_lancamento ";
        $sql.="       ,date_format(l.dt_competencia ,'%d/%m/%Y')dt_competencia";
        $sql.="       ,l.n_documento ";
        $sql.="       ,l.contas_bancarias_pk ";
        $sql.="       ,l.tipos_operacao_pk ";
        $sql.="       ,l.metodos_pagamento_pk ";
        $sql.="       ,l.empresas_pk";
        $sql.="       ,top.ds_tipo_operacao ";
        $sql.="       ,cb.ds_conta_bancaria ";
        $sql.="       ,mp.ds_metodo_pagamento";
        $sql.="       ,co.ds_razao_social";
        $sql.="       ,cb.vl_saldo_inicial";
        $sql.="       ,l.tipo_grupo_centro_custo_pk";
        $sql.="       ,l.grupo_lancamento_centro_custo_pk";
        $sql.="       ,l.ds_ocorrencia";
        $sql.="       ,l.contratos_pk";
        $sql.="       ,u.ds_usuario";
        $sql.="  from lancamentos l";
        $sql.="  left join tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="  left join contas_bancarias cb on l.contas_bancarias_pk = cb.pk";
        $sql.="  left join metodos_pagamento mp on l.metodos_pagamento_pk = mp.pk";
        $sql.="  left join contas co on l.empresas_pk = co.pk";
        $sql.="  inner join usuarios u on l.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
        if($tipo_lancamento_pk == 1){
            $sql.=" and l.operacao_pk = 1";
        }
        else{
            $sql.=" and l.operacao_pk <> 1";
        }
        if($empresas_pk != ""){
            $sql.=" and l.empresas_pk = ".$empresas_pk;
        }
        if($tipo_grupo_pk != ""){
            $sql.=" and l.tipo_grupo_pk = ".$tipo_grupo_pk;
        }
        if($grupo_leancamento_pk != ""){
            $sql.=" and l.grupo_leancamento_pk = ".$grupo_leancamento_pk;
        }
        if($usuario_cadastro_pk != ""){
            $sql.=" and l.usuario_cadastro_pk = ".$usuario_cadastro_pk;
        }
        /*if($contas_banarias_pk != ""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_banarias_pk;
        }*/
        if($dt_vencimento_ini!=""){
            $sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
        }
        else{
            $sql.=" and l.dt_vencimento < '".$query1[0]['dt_atual']."'";
        }
        if($dt_cadastro_ini!=""){
            $sql.=" and l.dt_cadastro between '".DataYMD($dt_cadastro_ini)." 00:00:00' and '".DataYMD($dt_cadastro_fim)." 23:59:59'";
        }
        if($dt_faturamento_ini!=""){
            $sql.=" and l.dt_faturamento between '".DataYMD($dt_faturamento_ini)."' and '".DataYMD($dt_faturamento_fim)."'";
        }
        
        if($ic_status_pagamento!=""){
            $sql.=" and l.ic_status_pagamento = ".$ic_status_pagamento;
        }
        else{
            $sql.=" and l.ic_status_pagamento <> 1 ";
        }
        
        $sql.=" group by l.pk";
        $sql.=" order by l.dt_vencimento desc ";
    
        

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listarValoresReceita($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk){

        $sql ="";
        $sql.="select ";
        $sql.="       sum(l.vl_lancamento)vl_lancamento ";

        $sql.="  from lancamentos l";
        $sql.=" where 1=1 ";
        if($dt_vencimento_ini!=""){
            //$sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
            $sql.=" and l.dt_vencimento <='".DataYMD($dt_vencimento_fim)."'";
        }  
        if($contas_bancarias_pk!=""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_bancarias_pk;
        }
        $sql.=" and l.operacao_pk = 1";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarValoresDespesas($dt_vencimento_ini,$dt_vencimento_fim,$contas_bancarias_pk){

        $sql ="";
        $sql.="select ";
        $sql.="       sum(l.vl_lancamento)vl_lancamento ";

        $sql.="  from lancamentos l";
        $sql.=" where 1=1 ";
        if($dt_vencimento_ini!=""){
            //$sql.=" and l.dt_vencimento between '".DataYMD($dt_vencimento_ini)."' and '".DataYMD($dt_vencimento_fim)."'";
            $sql.=" and l.dt_vencimento <='".DataYMD($dt_vencimento_fim)."'";
        }  
        if($contas_bancarias_pk!=""){
            $sql.=" and l.contas_bancarias_pk = ".$contas_bancarias_pk;
        }
        $sql.=" and l.operacao_pk in (2,3,4,5,6)";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_vencimento ";
        $sql.="       ,ds_lancamento ";
        $sql.="       ,vl_lancamento ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,tipo_grupo_pk ";
        $sql.="       ,grupo_leancamento_pk ";
        $sql.="       ,ic_status_pagamento ";
        $sql.="       ,obs_lancamento ";
        $sql.="       ,dt_competencia ";
        $sql.="       ,n_documento ";
        $sql.="       ,contas_bancarias_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,metodos_pagamento_pk ";
        $sql.="       ,empresas_pk";
        $sql.="       ,tipo_grupo_centro_custo_pk";
        $sql.="       ,grupo_lancamento_centro_custo_pk";
        $sql.="       ,ds_ocorrencia";
        $sql.="       ,contratos_pk";
        $sql.="       ,date_format(dt_faturamento,'%d/%m/%Y')dt_faturamento";

        $sql.="  from lancamentos ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_vencimento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    //Lista Leads
    public function listaItensGrupoLeads($tipo_grupo_pk){
        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       , case WHEN l.ic_tipo_lead = 1 THEN concat(l.ds_lead,' - Cliente') 
                        ELSE
                        concat(l.ds_lead,' - Posto de Trabalho')
                    END ds_lead";
        $sql.="  from leads l";
        $sql.=" where 1=1 ";
        if($tipo_grupo_pk!=""){
            $sql.=" and l.pk =".$tipo_grupo_pk;
        }
        $sql.=" Order by l.ds_lead";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listaLeadCNPJ($cpf_cnpj,$cnpj_cliente_sem_mascara){
        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,l.ds_lead ";
        $sql.="  from leads l";
        $sql.=" where 1=1 ";
        if($cpf_cnpj!=""){
            $sql.=" and l.ds_cpf_cnpj like '%".$cpf_cnpj."%' or l.ds_cpf_cnpj like '%".$cnpj_cliente_sem_mascara."%'";
        }
        $sql.=" Order by l.ds_lead";
        $query = $this->db->execQuery($sql);
        return $query;
    }
     //Lista Colaboradores
    public function listaItensGrupoColaboradores($tipo_grupo_pk){
        $sql ="";
        $sql.="select c.pk, c.dt_cadastro, c.usuario_cadastro_pk, c.dt_ult_atualizacao, c.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,c.ds_agencia";
        $sql.="       ,c.ds_conta";
        $sql.="       ,c.ds_digito";
        $sql.="       ,c.ds_pix";
        $sql.="       ,c.ds_conta_favorecido";
        $sql.="       ,b.ds_banco";
        $sql.="  from colaboradores c";
        $sql.="  left join bancos b on c.bancos_pk = b.pk";
        $sql.=" where 1=1 ";
        if($tipo_grupo_pk!=""){
            $sql.=" and c.pk =".$tipo_grupo_pk;
        }
        $sql.=" Order by c.ds_colaborador";
        $query = $this->db->execQuery($sql);
        return $query;
    }
     //Lista Colaboradores
    public function listaItensGrupoFornecedores($tipo_grupo_pk){
        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.ds_fornecedor ";
        $sql.="       ,f.ds_cpf_cnpj";
        $sql.="       ,f.ds_agencia";
        $sql.="       ,f.ds_conta";
        $sql.="       ,f.ds_digito";
        $sql.="       ,f.ds_pix";
        $sql.="       ,f.ds_favorecido_pix";
        $sql.="       ,b.ds_banco";
        $sql.="  from fornecedor f";
        $sql.="  left join bancos b on f.bancos_pk = b.pk";
        $sql.=" where 1=1 ";
        if($tipo_grupo_pk!=""){
            $sql.=" and f.pk =".$tipo_grupo_pk;
        }
        $sql.=" order by f.ds_fornecedor";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listaFornecedoresCNPJ($ds_cpf_cnpj,$cnpj_fornecedor_sem_mascara){
        $sql ="";
        $sql.="select f.pk, f.dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,f.ds_fornecedor ";
        $sql.="  from fornecedor f";
        $sql.=" where 1=1 ";
        if($ds_cpf_cnpj!=""){
            $sql.=" and f.ds_cpf_cnpj like '%".$ds_cpf_cnpj."%' or f.ds_cpf_cnpj like '%".$cnpj_fornecedor_sem_mascara."%'";
        }
        $sql.=" order by f.ds_fornecedor";
        $query = $this->db->execQuery($sql);
        return $query;
    }
     //Lista Colaboradores
    public function listaItensGrupoEquipes($tipo_grupo_pk){
        $sql ="";
        $sql.="select e.pk, e.dt_cadastro, e.usuario_cadastro_pk, e.dt_ult_atualizacao, e.usuario_ult_atualizacao_pk ";
        $sql.="       ,e.ds_equipe ";
        $sql.="  from equipes e";
        $sql.=" where 1=1 ";
        if($tipo_grupo_pk!=""){
            $sql.=" and e.pk =".$tipo_grupo_pk;
        }

        $query = $this->db->execQuery($sql);
        return $query;
    }
    //Contratos - Douglas - 08-06-30
    public function listarcontratos($contratos_pk){
        $sql ="";    
        $sql.="SELECT c.pk,";
        $sql.="    case WHEN c.ic_tipo_contrato =1 THEN";
        $sql.="      concat('FIXO',' - Cód:',c.pk,' - Periódo:',date_format(c.dt_inicio_contrato, '%d/%m/%Y'),' - ',date_format(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="     WHEN c.ic_tipo_contrato = 2 THEN";
        $sql.="      concat('Aditivo',' - Cód:',c.pk,' - Periódo:',date_format(c.dt_inicio_contrato, '%d/%m/%Y'),' - ',date_format(c.dt_fim_contrato, '%d/%m/%Y'))";
        $sql.="    WHEN c.ic_tipo_contrato =3 THEN";
        $sql.="      concat('EXTRA',' - Cód:',c.pk,' - Periódo:',date_format(c.dt_inicio_contrato, '%d/%m/%Y'),' - ',date_format(c.dt_fim_contrato, '%d/%m/%Y'))";        
        $sql.="    END ds_contrato";
        $sql.=" FROM contratos c";
        $sql.="   left join contratos_itens ci on c.pk = ci.contratos_pk";
        $sql.=" WHERE c.pk =".$contratos_pk;
        $sql.=" Group by c.pk";

        $query = $this->db->execQuery($sql);
        return $query;
        
        
    }

    public function listaPrimeiroLancamento($empresas_pk,$contas_bancarias_pk){
           
        $sql ="";
        $sql.="select date_format(MIN(l.dt_vencimento), '%m') mes_pri_vencimento, date_format(MIN(l.dt_vencimento), '%Y') ano_pri_vencimento";
        $sql.=" FROM lancamentos l";
        $sql.=" WHERE     1 = 1";
        $sql.="       AND l.empresas_pk = ".$empresas_pk;
        $sql.="       AND l.contas_bancarias_pk = ".$contas_bancarias_pk;
        $sql.=" ORDER BY l.dt_vencimento";
        //echo $sql;
        $query = $this->db->execQuery($sql);
        return $query;
    }


    public function listarExtrato($empresas_pk,$contas_bancarias_pk,$mes_pri_vencimento,$ano_pri_vencimento, $_ds_mes,$_ds_ano){
        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="        date_format(l.dt_cadastro, '%d/%m/%Y')";
        $sql.="           dt_cadastro,";
        $sql.="        date_format(l.dt_vencimento, '%d/%m/%Y')";
        $sql.="           dt_vencimento,";
        $sql.="        date_format(l.dt_pagamento, '%d/%m/%Y')";
        $sql.="           dt_pagamento,";
        $sql.="        date_format(l.dt_faturamento, '%d/%m/%Y')";
        $sql.="           dt_faturamento,";
        $sql.="        CASE l.operacao_pk";
        $sql.="           WHEN 1 THEN 'Receita'";
        $sql.="           WHEN 2 THEN 'Despesa Fixa'";
        $sql.="           WHEN 3 THEN 'Despesa Variada'";
        $sql.="           WHEN 4 THEN 'Imposto'";
        $sql.="           WHEN 5 THEN 'Transferência'";
        $sql.="           WHEN 6 THEN 'Caixinha'";
        $sql.="        END";
        $sql.="           ds_operacao,";
        $sql.="        CASE l.tipo_grupo_pk";
        $sql.="           WHEN 1 THEN '(Clientes)'";
        $sql.="           WHEN 2 THEN 'Colaboradores'";
        $sql.="           WHEN 3 THEN 'Fornecedores'";
        $sql.="           WHEN 4 THEN 'Outros'";
        $sql.="        END";
        $sql.="           ds_tipo_grupo,";
        $sql.="        mp.ds_metodo_pagamento,";
        $sql.="        l.operacao_pk,";
        $sql.="        l.tipo_grupo_pk,";
        $sql.="        l.vl_lancamento,";
        $sql.="        u.ds_usuario,";
        $sql.="        l.grupo_leancamento_pk,"; 
        $sql.="        top.ds_tipo_operacao,"; 
        $sql.="         l.ic_status_pagamento"; 
        $sql.=" FROM lancamentos l";
        $sql.="      INNER JOIN metodos_pagamento mp ON l.metodos_pagamento_pk = mp.pk";
        $sql.="      iNNER JOIN tipos_operacao top on l.tipos_operacao_pk = top.pk";
        $sql.="      Left JOIN usuarios u ON l.usuario_cadastro_pk = u.pk";
        $sql.=" WHERE     1 = 1";
        $sql.="       AND l.empresas_pk = ".$empresas_pk;
        $sql.="       AND l.contas_bancarias_pk = ".$contas_bancarias_pk;
        $sql.="       AND l.dt_vencimento >='".$ano_pri_vencimento."-".$mes_pri_vencimento."-01 00:00:00'";
        $sql.="       AND l.dt_vencimento <='".$_ds_ano."-".$_ds_mes."-31 23:59:59'";
        $sql.=" ORDER BY l.dt_vencimento";
        ///echo $sql;
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    public function relLancamentoPlanoConta($dt_vencimento_ini,$dt_vencimento_fim,$tipos_operacao_pk_receita){

        $sql ="";
        $sql.=" select";
        $sql.="     top.pk tipos_operacao_pk ";
        $sql.="     ,top.ds_tipo_operacao ";
        $sql.=" from lancamentos l";
        $sql.="     inner join tipos_operacao top on l.tipos_operacao_pk = top.pk ";
        $sql.=" where 1=1";
        if(!empty($dt_vencimento_ini)){
            $sql.=" and l.dt_vencimento >='".DataYMD($dt_vencimento_ini)." 00:00:00'";
        }
        if(!empty($dt_vencimento_fim)){
            $sql.=" and l.dt_vencimento <='".DataYMD($dt_vencimento_fim)." 23:59:59'";
        }
        if(!empty($tipos_operacao_pk_receita)){
            $sql.=" and l.tipos_operacao_pk=".$tipos_operacao_pk_receita;
        }
        $sql.=" and l.dt_vencimento is not null";
        $sql.=" group by l.tipos_operacao_pk ";
        $sql.=" order by top.ds_tipo_operacao";

        $query = $this->db->execQuery($sql);

        if(count($query) > 0){    
       
            for($i = 0; $i < count($query); $i++){
                
                $ds_tipo_operacao = $query[$i]["ds_tipo_operacao"];

                if(!empty($ds_tipo_operacao)){
                  
                    $sql ="";
                    $sql.=" select";
                    $sql.="     date_format(l.dt_vencimento, '%d/%m/%Y') dt_vencimento";
                    $sql.="     ,l.ds_lancamento";
                    $sql.="     ,l.parcela_pk";
                    $sql.="     ,sum(l.vl_lancamento) vl_lancamento";
                    $sql.="     ,l.tipos_operacao_pk";
                    $sql.=" from lancamentos l";
                    $sql.="     where l.tipos_operacao_pk=". $query[$i]["tipos_operacao_pk"];
                    if(!empty($dt_vencimento_ini)){
                        $sql.=" and l.dt_vencimento >='".DataYMD($dt_vencimento_ini)." 00:00:00'";
                    }
                    if(!empty($dt_vencimento_fim)){
                        $sql.=" and l.dt_vencimento <='".DataYMD($dt_vencimento_fim)." 23:59:59'";
                    }
                    $sql.=" and l.dt_vencimento is not null";
                    $sql.=" group by l.ds_lancamento";
                    $sql.=" Order by l.dt_vencimento";
       
                   // echo $sql."<br>";
                    $queryLinha = $this->db->execQuery($sql);
                    

                    if(count($queryLinha) > 0){ 
                        $vlTotal = "";
                        $arrayDados = [];
                        for($a = 0; $a < count($queryLinha); $a++){
                            //echo $a." - ".$queryLinha[$a]['dt_vencimento'].' - '.$queryLinha[$a]['ds_lancamento'].' - '.$queryLinha[$a]['parcela_pk'].' - '.$queryLinha[$a]['vl_lancamento']."<br>";
                            $arrayDados[]= array (
                                
                                "dt_vencimento"=>$queryLinha[$a]['dt_vencimento'],
                                "ds_lancamento"=>$queryLinha[$a]['ds_lancamento'],
                                "parcela_pk"=>$queryLinha[$a]['parcela_pk'],
                                "vl_lancamento"=>$queryLinha[$a]['vl_lancamento'],
                            );
                            $vlTotal += $queryLinha[$a]["vl_lancamento"];                  
                        }    
                        //var_dump($arrayDados);
                         $result[] = array (
                             'ds_tipo_operacao'=>$ds_tipo_operacao,
                             'DadosLinha'=>$arrayDados,
                             'VlTotal'=>$vlTotal
                         ); 
                    }                      
           

                    
                }   
            }  
            
        }    

        return $result;
    }
    
    
}

?>
