<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/faturamento.class.php';
require_once "../model/lancamento.dao.php";


class faturamentodao{

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

    public function salvar($faturamento){
 
        $fields = array();
        $fields['dt_faturamento_ini'] = DataYMD($faturamento->getdt_faturamento_ini());
        $fields['dt_faturamento_fim'] = DataYMD($faturamento->getdt_faturamento_fim());
        $fields['ic_contrato_fixo'] = $faturamento->getic_contrato_fixo();
        $fields['ic_contrato_aditivo'] = $faturamento->getic_contrato_aditivo();
        $fields['ic_contrato_servico_extra'] = $faturamento->getic_contrato_servico_extra();
        $fields['ic_gerar_boleto'] = $faturamento->getic_gerar_boleto();
        $fields['ic_gerar_fatura'] = $faturamento->getic_gerar_fatura();
        $fields['ic_gerar_nota_fiscal'] = $faturamento->getic_gerar_nota_fiscal();
        $fields['ic_processar_faturamento'] = $faturamento->getic_processar_faturamento();
        $fields['obs'] = $faturamento->getobs();
        $fields['ic_status'] = $faturamento->getic_status();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
    
        if($faturamento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("faturamento", $fields);
            $faturamento->setpk($pk);
            
        }else{
            $this->db->execUpdate("faturamento", $fields, " pk = ".$faturamento->getpk());
        }
        return $faturamento->getpk();;

    }

    public function excluir($faturamento){
        $this->db->execDelete("faturamento"," pk = ".$faturamento->getpk());
    }

    public function processar($pk, $token){
        $lancamentodao = new lancamentodao();
        $lancamentodao->setToken($token);

        $sql = "";
        $sql .= " SELECT f.pk faturamento_pk,";
        $sql .= "    f.dt_faturamento_ini,";
        $sql .= "    f.dt_faturamento_fim,";
        $sql .= "    fi.vl_total_lancamento,";
        $sql .= "    fi.leads_pk clientes_pk,";
        $sql .= "    fi.obs_lancamento,";
        $sql .= "    fi.contratos_pk,";
        $sql .= "    fi.contas_pk,";
        $sql .= "    fi.pk faturamento_itens_pk";
        $sql .= " FROM faturamento f";
        $sql .= "    INNER JOIN faturamento_itens fi ON fi.faturamento_pk = f.pk ";
        $sql .= "    INNER JOIN leads l ON l.pk = fi.leads_pk";
        $sql .= " WHERE f.pk = $pk";
        $query = $this->db->execQuery($sql);
        
        $sql = "";
        $sql = "SELECT pk, ds_categoria FROM categorias_financeiras WHERE ds_categoria = 'Receita' order by pk desc";
        $queryOperacao = $this->db->execQuery($sql);

        $sql = "";
        $sql = "SELECT pk, ds_metodo_pagamento FROM metodos_pagamento WHERE ds_metodo_pagamento = 'Boleto'";
        $queryPagamento = $this->db->execQuery($sql);

        $sql = "";
        $sql = "SELECT pk, ds_tipo_operacao FROM tipos_operacao WHERE ds_tipo_operacao = 'Receita'";
        $queryTiposOperacao = $this->db->execQuery($sql);
        
        if(count($query) > 0){
            for($i=0; $i<count($query); $i++){
                $lancamento_pk = '';
                $sql = "";
                $sql .= " SELECT fc.leads_pk,";
                $sql .= "    fc.contratos_pk,";
                $sql .= "    fc.ic_status,";
                $sql .= "    date_format(fc.dt_faturamento,'%d/%m/%Y') dt_faturamento,";
                $sql .= "    date_format(fc.dt_vencimento,'%d/%m/%Y')dt_vencimento";
                $sql .= " FROM faturamento_contratos fc";
                $sql .= " WHERE fc.faturamento_pk = $pk";
                $sql .= "   AND fc.contratos_pk =".$query[$i]['contratos_pk'];
                $queryContratos = $this->db->execQuery($sql);

                if($queryContratos[0]['ic_status'] == 1){
                    $lancamento = $lancamentodao->carregarPorPk('');
                    $lancamento->setds_lancamento("Receita Faturamento Cliente");
                    $lancamento->setoperacao_pk(1);
                    $lancamento->setcategoria_operacao_pk($queryOperacao[0]['pk']);
                    $lancamento->settipos_operacao_pk($queryTiposOperacao[0]['pk']);
                    $lancamento->setdt_faturamento($queryContratos[0]['dt_faturamento']);
                    $lancamento->setdt_vencimento($queryContratos[0]['dt_vencimento']);
                    $lancamento->setvl_lancamento(number_format($query[$i]['vl_total_lancamento'],2,",","."));
                    $lancamento->setmetodos_pagamento_pk($queryPagamento[0]['pk']);
                    $lancamento->setempresas_pk($query[$i]['contas_pk']);
                    $lancamento->setic_status_pagamento(2);
                    $lancamento->setgrupo_leancamento_pk($queryContratos[0]['leads_pk']);
                    $lancamento->settipo_grupo_pk(1);
                    $lancamento->setparcela_pk(1);
                    $lancamento->setleads_clientes_pk($query[$i]['clientes_pk']);
                    $lancamento->setleads_posto_trabalho_pk($queryContratos[0]['leads_pk']);
                    $lancamento->setcontratos_pk($query[$i]['contratos_pk']);
                    $lancamento->setobs_lancamento($query[$i]['obs_lancamento']);
                    $lancamento_pk = $lancamentodao->salvar($lancamento, '', $token);
                    
                    $fields = array();
                    $fields['lancamentos_pk'] = $lancamento_pk;
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
                    $this->db->execUpdate("faturamento_itens", $fields, " pk = ".$query[$i]['faturamento_itens_pk']);

                }
                
                //echo $lancamento_pk."<br>";

                
            }
            
            $fields = array();
            $fields['ic_status'] = 2;
            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
            $this->db->execUpdate("faturamento", $fields, " pk = ".$query[0]['faturamento_pk']);
        }else{
            throw new Exception('Salve o Faturamento Primeiro!');
        }
        

        $mysql_data[] = array(
            "pk" => $pk
        );
        
    }

    public function carregarPorPk($pk){

        $faturamento = new faturamento();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,dt_faturamento_ini ";
        $sql.="       ,dt_faturamento_fim ";
        $sql.="       ,ic_contrato_fixo ";
        $sql.="       ,ic_contrato_aditivo ";
        $sql.="       ,ic_contrato_servico_extra ";
        $sql.="       ,ic_gerar_boleto ";
        $sql.="       ,ic_gerar_nota_fiscal ";
        $sql.="       ,ic_processar_faturamento ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";


        $sql.="  from faturamento ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $faturamento->setpk($query[$i]["pk"]);
                $faturamento->setdt_cadastro($query[$i]["dt_cadastro"]);
                $faturamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $faturamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $faturamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $faturamento->setdt_faturamento_ini($query[$i]['dt_faturamento_ini']);
                $faturamento->setdt_faturamento_fim($query[$i]['dt_faturamento_fim']);
                $faturamento->setic_contrato_fixo($query[$i]['ic_contrato_fixo']);
                $faturamento->setic_contrato_aditivo($query[$i]['ic_contrato_aditivo']);
                $faturamento->setic_contrato_servico_extra($query[$i]['ic_contrato_servico_extra']);
                $faturamento->setic_gerar_boleto($query[$i]['ic_gerar_boleto']);
                $faturamento->setic_gerar_nota_fiscal($query[$i]['ic_gerar_nota_fiscal']);
                $faturamento->setic_processar_faturamento($query[$i]['ic_processar_faturamento']);
                $faturamento->setobs($query[$i]['obs']);
                $faturamento->setic_status($query[$i]['ic_status']);

            }
        }
        return $faturamento;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_faturamento_ini ";
        $sql.="       ,dt_faturamento_fim ";
        $sql.="       ,ic_contrato_fixo ";
        $sql.="       ,ic_contrato_aditivo ";
        $sql.="       ,ic_contrato_servico_extra ";
        $sql.="       ,ic_gerar_boleto ";
        $sql.="       ,ic_gerar_nota_fiscal ";
        $sql.="       ,ic_processar_faturamento ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";

        $sql.="  from faturamento ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_faturamento_ini($dt_faturamento_ini){

        $sql ="";
        $sql.="select f.pk, date_format(f.dt_cadastro, '%d/%m/%y') dt_cadastro, f.usuario_cadastro_pk, f.dt_ult_atualizacao, f.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(f.dt_faturamento_ini, '%d/%m/%y') dt_faturamento_ini ";
        $sql.="       ,date_format(f.dt_faturamento_fim, '%d/%m/%y') dt_faturamento_fim ";
        $sql.="       ,f.ic_contrato_fixo ";
        $sql.="       ,f.ic_contrato_aditivo ";
        $sql.="       ,f.ic_contrato_servico_extra ";
        $sql.="       ,f.ic_gerar_boleto ";
        $sql.="       ,f.ic_gerar_nota_fiscal ";
        $sql.="       ,f.ic_processar_faturamento ";
        $sql.="       ,f.obs ";
        $sql.="       ,f.ic_status";
        $sql.="       ,count(fi.lancamentos_pk) n_emissoes";
        $sql.="       ,case when f.ic_status = 1 then 'Faturamento Gerado'";
        $sql.="             when f.ic_status = 2 then 'Faturamento Processado' end ds_status";

        $sql.="  from faturamento f";
        $sql.="   left join faturamento_itens fi on fi.faturamento_pk = f.pk";
        $sql.=" where 1=1 ";
        if($dt_faturamento_ini != ""){
            $sql.=" and f.ds_faturamento like '%".$dt_faturamento_ini."%' ";
        }
        $sql.=" group by fi.faturamento_pk";
        $sql.=" order by f.pk desc ";
    
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_faturamento_ini ";
        $sql.="       ,dt_faturamento_fim ";
        $sql.="       ,ic_contrato_fixo ";
        $sql.="       ,ic_contrato_aditivo ";
        $sql.="       ,ic_contrato_servico_extra ";
        $sql.="       ,ic_gerar_boleto ";
        $sql.="       ,ic_gerar_nota_fiscal ";
        $sql.="       ,ic_processar_faturamento ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";

        $sql.="  from faturamento ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_faturamento_ini asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarLancamentos($pk){
        $sql='';
        $sql.="select ";
        $sql.="     f.pk,"; 
        $sql.="     l.ds_lead,";
        $sql.="     fc.contratos_pk,";
        $sql.="     case";
        $sql.="         when fc.ic_tipo_contrato = 1 then ";
        $sql.="          'Contrato Fixo' ";
        $sql.="         when fc.ic_tipo_contrato = 2 then ";	 
        $sql.="            'Contrato Aditivo' ";
        $sql.="         when fc.ic_tipo_contrato = 2 then ";
        $sql.="            'Serviço Extra' ";
        $sql.="     end as tipo_contrato, ";
        $sql.="     fi.lancamentos_pk , ";
        $sql.="     DATE_FORMAT(l.dt_cadastro, '%d/%m/%Y') dt_lancamento, ";
        $sql.="     DATE_FORMAT(fc.dt_faturamento, '%d/%m/%Y') dt_faturamento, ";
        $sql.="     DATE_FORMAT(fc.dt_vencimento, '%d/%m/%Y') dt_vencimento, ";
        $sql.="     fc.vl_total_contrato ";
        $sql.=" from faturamento f ";
        $sql.="     inner join faturamento_contratos fc on	f.pk = fc.faturamento_pk ";
        $sql.="     inner join leads l on fc.leads_pk = l.pk ";
        $sql.="     inner join faturamento_itens fi on 	f.pk = fi.faturamento_pk and fc.contratos_pk = fi.contratos_pk ";
        $sql.="     left join lancamentos la on fi.lancamentos_pk = la.pk ";
        $sql.=" where f.pk =".$pk;
        $sql.=" group by fc.contratos_pk";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    //CONTAS FATURAMENTO
    public function excluirFaturamentoContas($pk){
        $this->db->execDelete("faturamento_contas"," faturamento_pk = ".$pk);
    }

    public function salvarFaturamentoContas($faturamento_pk,$contas_pk){        

        $fields["faturamento_pk"]   = $faturamento_pk;
        $fields["contas_pk"]   = $contas_pk;
        $fields["ic_status"]   = 1;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

       $this->db->execInsert("faturamento_contas", $fields);
  
        
    }

    public function listarDadosFaturamento($pk){
        $sql = "";
        $sql.="SELECT f.pk,";
        $sql.="        date_format(f.dt_cadastro,'%d/%m/%Y') dt_cadastro,";
        $sql.="        f.usuario_cadastro_pk, ";
        $sql.="        date_format(f.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao,";
        $sql.="        f.usuario_ult_atualizacao_pk,";
        $sql.="        date_format(f.dt_faturamento_ini,'%d/%m/%Y') dt_faturamento_ini,";
        $sql.="        date_format(f.dt_faturamento_fim,'%d/%m/%Y') dt_faturamento_fim,";
        $sql.="        f.dt_faturamento_ini dt_faturamento_base_ini,";
        $sql.="        f.dt_faturamento_fim dt_faturamento_base_fim,";
        $sql.="        f.ic_contrato_fixo,";
        $sql.="        f.ic_contrato_aditivo,";
        $sql.="        f.ic_contrato_servico_extra,";
        $sql.="        f.ic_gerar_fatura,";
        $sql.="        f.ic_gerar_boleto,";
        $sql.="        f.ic_gerar_nota_fiscal,";
        $sql.="        f.ic_processar_faturamento,";
        $sql.="        f.obs,";
        $sql.="        f.ic_status,";
        $sql.="        u.ds_usuario ds_usuario_cadastro,";
        $sql.="        u1.ds_usuario ds_usuario_atualizacao";
        $sql.="       ,case WHEN f.ic_status = 1  THEN 'Faturamento Gerado' 
                                WHEN f.ic_status = 2  THEN 'Faturamento Cancelado' 
                                WHEN f.ic_status = 3  THEN 'Faturamento Processado' 
                        END ds_usatus_faturamento";
        $sql.=" FROM faturamento f";
        $sql.=" INNER JOIN usuarios u on f.usuario_cadastro_pk = u.pk";
        $sql.=" INNER JOIN usuarios u1 on f.usuario_ult_atualizacao_pk = u1.pk";
        $sql.=" WHERE f.pk =".$pk;
        $queryFatutamento = $this->db->execQuery($sql); 
   
        //Dados de Contas
        $sql ="";
        $sql.="SELECT fc.pk,";
        $sql.="        c.pk contas_pk,";
        $sql.="        c.ds_conta,";
        $sql.="        c.ds_razao_social,";
        $sql.="        c.ds_cpf_cnpj";
        $sql.=" FROM faturamento_contas fc ";
        $sql.=" INNER JOIN contas c ON fc.contas_pk = c.pk";
        $sql.=" WHERE fc.faturamento_pk = ".$pk;
        $sql.="   AND c.ic_status = 1";
        $sql.=" ORDER BY c.ds_razao_social";
        $queryContas = $this->db->execQuery($sql);
        if(count($queryContas) > 0){
       
            for($i = 0; $i < count($queryContas); $i++){
                //Dados Contas Empresas
                $DadosContas[] = array(
                    "contas_pk" => $queryContas[$i]["contas_pk"],
                    "ds_conta" => $queryContas[$i]["ds_conta"],
                    "ds_razao_social" => $queryContas[$i]["ds_razao_social"],
                    "ds_cpf_cnpj" => $queryContas[$i]["ds_cpf_cnpj"]
                );

                //CONTRATOS
                $sql = "";
                $sql.="SELECT c.pk contratos_pk,";
                $sql.="        date_format(c.dt_cadastro,'%d/%m/%Y') dt_cadastro,";
                $sql.="        c.ds_identificacao_area,";
                $sql.="        c.ic_tipo_contrato,";
                $sql.="        c.vl_contrato,";
                $sql.="        c.empresas_pk contas_contratos_pk,";
                $sql.="        u.ds_usuario ds_usuario_cadastro_contrato,";
                $sql.="        l.pk leads_pk,";
                $sql.="        l.ds_lead,";
                $sql.="        l.ds_razao_social,";
                $sql.="        l.ds_cpf_cnpj,";
                $sql.="        concat(l.ds_endereco,' - ',l.ds_numero,' - Complemento: ',l.ds_complemento,' - Bairro: ',l.ds_bairro,' - Cidade: ',l.ds_cidade,' - Cep: ',l.ds_cep,' - UF:',ds_uf )ds_endereco_lead,";
                $sql.="         CASE";
                $sql.="             WHEN l.ic_tipo_lead = 1 THEN 'Cliente Matris'";
                $sql.="             ELSE 'Posto de Trabalho'";
                $sql.="         END ds_tipo_lead,";
                $sql.="       date_format(c.dt_inicio_contrato,'%d/%m/%Y') dt_inicio_contrato,";
                $sql.="       date_format(c.dt_fim_contrato,'%d/%m/%Y') dt_fim_contrato";
                $sql.="    FROM contratos c";
                $sql.="        INNER JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
                $sql.="        INNER JOIN processos p ON pe.processos_pk = p.pk";
                $sql.="        INNER JOIN leads l on p.leads_pk = l.pk";
                $sql.="        INNER JOIN usuarios u on c.usuario_cadastro_pk = u.pk"; 
                $sql.="    WHERE c.dt_cancelamento IS NULL ";
                $sql.="    AND c.empresas_pk = ".$queryContas[$i]["contas_pk"];
                //$sql.="    AND c.dt_inicio_contrato <='". ($queryFatutamento[0]['dt_faturamento_base_ini'])." 00:00:00'"; 
                //$sql.="    AND c.dt_fim_contrato >='". ($queryFatutamento[0]['dt_faturamento_base_fim'])." 23:59:59'"; 
                $sql.="    AND c.dt_inicio_contrato <= sysdate()"; 
                $sql.="    AND c.dt_fim_contrato >= sysdate()"; 
                $sql.="    AND c.dt_cancelamento is null";
                $sql.="    AND l.ic_cliente=1";
                $sql.="   ORDER BY l.ds_lead ";
                //echo $sql;
                $queryContratos = $this->db->execQuery($sql);   
            
                if(count($queryContratos) > 0){
                    for($h = 0; $h < count($queryContratos); $h++){
                        $ds_ideintificacao_contrato = "";
                        if($queryContratos[$h]["ds_identificacao_area"]!=null){
                            $ds_ideintificacao_contrato = $queryContratos[$h]["ds_identificacao_area"];
                        }
                        $DadosContratos[] = array(
                            "contratos_pk" => $queryContratos[$h]["contratos_pk"],
                            "dt_cadastro" => $queryContratos[$h]["dt_cadastro"],
                            "ds_identificacao_area" => $ds_ideintificacao_contrato,
                            "ic_tipo_contrato" => $queryContratos[$h]["ic_tipo_contrato"],
                            "vl_contrato" => $queryContratos[$h]["vl_contrato"]  == null ? "0,00" : $queryContratos[$h]["vl_contrato"],
                            "contas_contratos_pk" => $queryContratos[$h]["contas_contratos_pk"],
                            "ds_usuario_cadastro_contrato" => $queryContratos[$h]["ds_usuario_cadastro_contrato"],
                            "leads_pk" => $queryContratos[$h]["leads_pk"],
                            "ds_lead" => $queryContratos[$h]["ds_lead"],    
                            "ds_razao_social" => $queryContratos[$h]["ds_razao_social"],
                            "ds_cpf_cnpj" => $queryContratos[$h]["ds_cpf_cnpj"] == null ? " " : $queryContratos[$h]["ds_cpf_cnpj"],
                            "ds_endereco_lead" => $queryContratos[$h]["ds_endereco_lead"] == null ? " " : $queryContratos[$h]["ds_endereco_lead"],
                            "ds__tipo_lead" => $queryContratos[$h]["ds_tipo_lead"],
                            "dt_inicio_contrato" => $queryContratos[$h]["dt_inicio_contrato"],
                            "dt_fim_contrato" => $queryContratos[$h]["dt_fim_contrato"]        
                        );

                        //CONTRATOS ITENS
                        $sql ="";
                        $sql.="SELECT ci.pk,";
                        $sql.="    ps.pk produto_servico_pk,";
                        $sql.="    ps.ds_produto_servico,";
                        $sql.="    ci.contratos_pk,";  
                        $sql.="    ci.periodo,";                       
                        $sql.="    ci.n_qtde n_qtde_colaborador,";
                        $sql.="    ci.n_qtde_dias_semana,"; 
                        $sql.="    ci.vl_unit,";
                        $sql.="    ci.vl_total";
                        $sql.=" FROM contratos_itens ci";
                        $sql.="    INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";
                        $sql.=" WHERE ci.contratos_pk =".$queryContratos[$h]["contratos_pk"];
                        
                        $queryContratosItens = $this->db->execQuery($sql);
                        if(count($queryContratosItens) > 0){
                            for($l = 0; $l < count($queryContratosItens); $l++){
                                $DadosContratosItens[] = array(
                                    "contratos_itens_pk" => $queryContratosItens[$l]["pk"],
                                    "contratos_pk" => $queryContratosItens[$l]["contratos_pk"],
                                    "produto_servico_pk" => $queryContratosItens[$l]["produto_servico_pk"],
                                    "ds_servico_prestado" => $queryContratosItens[$l]["ds_produto_servico"],
                                    "n_qtde_colaborador" => $queryContratosItens[$l]["n_qtde_colaborador"],
                                    "ds_escala" => $queryContratosItens[$l]["n_qtde_dias_semana"],
                                    "ds_carga_horaria_dia" => $queryContratosItens[$l]["periodo"],
                                    "vl_unit" => $queryContratosItens[$l]["vl_unit"],
                                    "vl_total" => $queryContratosItens[$l]["vl_total"],
                                );
                            }  
                        }  
                        
                    }  
                } 
            }
        } 

        $result[] = array(
            "pk" => $pk,
            "ds_usuario_cadastro"=>$queryFatutamento[0]['ds_usuario_cadastro'],
            "ds_usuario_atualizacao"=>$queryFatutamento[0]['ds_usuario_atualizacao'],
            "dt_cadastro"=>$queryFatutamento[0]['dt_cadastro'],
            "dt_ult_atualizacao"=>$queryFatutamento[0]['dt_ult_atualizacao'],
            "dt_faturamento_ini"=>$queryFatutamento[0]['dt_faturamento_ini'],
            "dt_faturamento_fim"=>$queryFatutamento[0]['dt_faturamento_fim'],
            "ds_usatus_faturamento"=>$queryFatutamento[0]['ds_usatus_faturamento'],
            "ic_contrato_fixo"=>$queryFatutamento[0]['ic_contrato_fixo'],
            "ic_contrato_aditivo"=>$queryFatutamento[0]['ic_contrato_aditivo'],
            "ic_contrato_servico_extra"=>$queryFatutamento[0]['ic_contrato_servico_extra'],
            "ic_gerar_fatura"=>$queryFatutamento[0]['ic_gerar_fatura'],
            "ic_gerar_boleto"=>$queryFatutamento[0]['ic_gerar_boleto'],
            "ic_gerar_nota_fiscal"=>$queryFatutamento[0]['ic_gerar_nota_fiscal'],
            "obs"=>$queryFatutamento[0]['obs'],
            "DadosContas"=>$DadosContas,
            "DadosContratos"=>$DadosContratos,
            "DadosContratosItens"=>$DadosContratosItens,
        ); 
     
        //var_dump($result);
        return $result;
    }


    public function listarUpdateFaturamento($pk){
        $sql = "";
        $sql.="SELECT f.pk,";
        $sql.="        date_format(f.dt_cadastro,'%d/%m/%Y') dt_cadastro,";
        $sql.="        f.usuario_cadastro_pk, ";
        $sql.="        date_format(f.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao,";
        $sql.="        f.usuario_ult_atualizacao_pk,";
        $sql.="        date_format(f.dt_faturamento_ini,'%d/%m/%Y') dt_faturamento_ini,";
        $sql.="        date_format(f.dt_faturamento_fim,'%d/%m/%Y') dt_faturamento_fim,";
        $sql.="        f.dt_faturamento_ini dt_faturamento_base_ini,";
        $sql.="        f.dt_faturamento_fim dt_faturamento_base_fim,";
        $sql.="        f.ic_contrato_fixo,";
        $sql.="        f.ic_contrato_aditivo,";
        $sql.="        f.ic_contrato_servico_extra,";
        $sql.="        f.ic_gerar_fatura,";
        $sql.="        f.ic_gerar_boleto,";
        $sql.="        f.ic_gerar_nota_fiscal,";
        $sql.="        f.ic_processar_faturamento,";
        $sql.="        f.obs,";
        $sql.="        f.ic_status,";
        $sql.="        u.ds_usuario ds_usuario_cadastro,";
        $sql.="        u1.ds_usuario ds_usuario_atualizacao";
        $sql.="               ,case WHEN f.ic_status = 1  THEN 'Faturamento Gerado' 
                                    WHEN f.ic_status = 2  THEN 'Faturamento Cancelado' 
                                    WHEN f.ic_status = 3  THEN 'Faturamento Processado' 
                            END ds_usatus_faturamento";
        $sql.=" FROM faturamento f";
        $sql.=" INNER JOIN usuarios u on f.usuario_cadastro_pk = u.pk";
        $sql.=" INNER JOIN usuarios u1 on f.usuario_ult_atualizacao_pk = u1.pk";
        $sql.=" WHERE f.pk =".$pk;
        
        $queryFatutamento = $this->db->execQuery($sql); 
        
        //Dados de Contas
        $sql ="";
        $sql.="SELECT fc.pk,";
        $sql.="        c.pk contas_pk,";
        $sql.="        c.ds_conta,";
        $sql.="        c.ds_razao_social,";
        $sql.="        c.ds_cpf_cnpj";
        $sql.=" FROM faturamento_contas fc ";
        $sql.=" INNER JOIN contas c ON fc.contas_pk = c.pk";
        $sql.=" WHERE fc.faturamento_pk = ".$pk;
        $sql.="   AND c.ic_status = 1";
        $sql.=" ORDER BY c.ds_razao_social";
        $queryContas = $this->db->execQuery($sql);

        if(count($queryContas) > 0){
            for($i = 0; $i < count($queryContas); $i++){
                //Dados Contas Empresas
                $DadosContas[] = array(
                    "contas_pk" => $queryContas[$i]["contas_pk"],
                    "ds_conta" => $queryContas[$i]["ds_conta"],
                    "ds_razao_social" => $queryContas[$i]["ds_razao_social"],
                    "ds_cpf_cnpj" => $queryContas[$i]["ds_cpf_cnpj"]
                );

                //CONTRATOS
                $sql = "";
                $sql.="SELECT c.pk contratos_pk,";
                $sql.="        date_format(c.dt_cadastro,'%d/%m/%Y') dt_cadastro,";
                $sql.="        c.ds_identificacao_area,";
                $sql.="        c.ic_tipo_contrato,";
                $sql.="        c.vl_contrato,";
                $sql.="        c.empresas_pk contas_contratos_pk,";
                $sql.="        u.ds_usuario ds_usuario_cadastro_contrato,";
                $sql.="        l.pk leads_pk,";
                $sql.="        l.ds_lead,";
                $sql.="        l.ds_razao_social,";
                $sql.="        l.ds_cpf_cnpj,";
                $sql.="        fc.pk faturamento_contratos_pk,";
                $sql.="        date_format(fc.dt_vencimento,'%d/%m/%Y') dt_vencimento,";
                $sql.="        date_format(fc.dt_faturamento,'%d/%m/%Y') dt_faturamento,";
                $sql.="        fi.pk faturamento_itens_pk,";
                $sql.="        fi.obs_faturamento_contrato,";
                $sql.="        fi.obs_lancamento,";
                $sql.="        fi.obs_corpo_nota,";
                $sql.="        fc.ic_status,";
                $sql.="        concat(l.ds_endereco,' - ',l.ds_numero,' - Complemento: ',l.ds_complemento,' - Bairro: ',l.ds_bairro,' - Cidade: ',l.ds_cidade,' - Cep: ',l.ds_cep,' - UF:',ds_uf )ds_endereco_lead,";
                $sql.="         CASE";
                $sql.="             WHEN l.ic_tipo_lead = 1 THEN 'Cliente Matris'";
                $sql.="             ELSE 'Posto de Trabalho'";
                $sql.="         END ds_tipo_lead,";
                $sql.="       date_format(c.dt_inicio_contrato,'%d/%m/%Y') dt_inicio_contrato,";
                $sql.="       date_format(c.dt_fim_contrato,'%d/%m/%Y') dt_fim_contrato";
                $sql.="    FROM contratos c";
                $sql.="        INNER JOIN processos_etapas pe ON c.processos_etapas_pk = pe.pk";
                $sql.="        INNER JOIN processos p ON pe.processos_pk = p.pk";
                $sql.="        INNER JOIN leads l on p.leads_pk = l.pk";
                $sql.="        INNER JOIN usuarios u on c.usuario_cadastro_pk = u.pk"; 
                $sql.="        INNER JOIN faturamento_contratos fc ON fc.contratos_pk = c.pk"; 
                $sql.="        INNER JOIN faturamento_itens fi ON fc.contratos_pk = fi.contratos_pk AND fc.faturamento_pk = fi.faturamento_pk"; 
                $sql.="    WHERE c.dt_cancelamento IS NULL ";
                $sql.="    AND c.empresas_pk = ".$queryContas[$i]["contas_pk"];
                //$sql.="    AND c.dt_inicio_contrato <='". ($queryFatutamento[0]['dt_faturamento_base_ini'])." 00:00:00'"; 
                //$sql.="    AND c.dt_fim_contrato >='". ($queryFatutamento[0]['dt_faturamento_base_fim'])." 23:59:59'"; 
                $sql.="    AND c.dt_inicio_contrato <= sysdate()"; 
                $sql.="    AND c.dt_fim_contrato >= sysdate()"; 
                $sql.="    AND c.dt_cancelamento is null";
                $sql.="    AND l.ic_cliente=1";
                $sql.="    AND fc.faturamento_pk=".$pk;
                $sql.="   ORDER BY l.ds_lead ";
                $queryContratos = $this->db->execQuery($sql);   

                if(count($queryContratos) > 0){
                    for($h = 0; $h < count($queryContratos); $h++){
                        $ds_ideintificacao_contrato = "";
                        if($queryContratos[$h]["ds_identificacao_area"]!=null){
                            $ds_ideintificacao_contrato = $queryContratos[$h]["ds_identificacao_area"];
                        }
                        $DadosContratos[] = array(
                            "faturamento_contratos_pk" => $queryContratos[$h]["faturamento_contratos_pk"],
                            "faturamento_itens_pk" => $queryContratos[$h]["faturamento_itens_pk"],
                            "obs_faturamento_contrato" => $queryContratos[$h]["obs_faturamento_contrato"],
                            "dt_vencimento" => $queryContratos[$h]["dt_vencimento"],
                            "dt_faturamento" => $queryContratos[$h]["dt_faturamento"],
                            "obs_lancamento" => $queryContratos[$h]["obs_lancamento"],
                            "obs_corpo_nota" => $queryContratos[$h]["obs_corpo_nota"],
                            "contratos_pk" => $queryContratos[$h]["contratos_pk"],
                            "dt_cadastro" => $queryContratos[$h]["dt_cadastro"],
                            "ds_identificacao_area" => $ds_ideintificacao_contrato,
                            "ic_tipo_contrato" => $queryContratos[$h]["ic_tipo_contrato"],
                            "vl_contrato" => $queryContratos[$h]["vl_contrato"]  == null ? "0,00" : $queryContratos[$h]["vl_contrato"],
                            "contas_contratos_pk" => $queryContratos[$h]["contas_contratos_pk"],
                            "ic_status" => $queryContratos[$h]["ic_status"],
                            "ds_usuario_cadastro_contrato" => $queryContratos[$h]["ds_usuario_cadastro_contrato"],
                            "leads_pk" => $queryContratos[$h]["leads_pk"],
                            "ds_lead" => $queryContratos[$h]["ds_lead"],    
                            "ds_razao_social" => $queryContratos[$h]["ds_razao_social"],
                            "ds_cpf_cnpj" => $queryContratos[$h]["ds_cpf_cnpj"] == null ? " " : $queryContratos[$h]["ds_cpf_cnpj"],
                            "ds_endereco_lead" => $queryContratos[$h]["ds_endereco_lead"] == null ? " " : $queryContratos[$h]["ds_endereco_lead"],
                            "ds__tipo_lead" => $queryContratos[$h]["ds_tipo_lead"],
                            "ds__tipo_lead" => $queryContratos[$h]["ds_tipo_lead"],
                            "dt_inicio_contrato" => $queryContratos[$h]["dt_inicio_contrato"],
                            "dt_fim_contrato" => $queryContratos[$h]["dt_fim_contrato"]        
                        );

                        //CONTRATOS ITENS
                        $sql ="";
                        $sql.="SELECT fci.pk faturamento_contratos_itens_pk,";
                        $sql.="    ps.pk produto_servico_pk,";
                        $sql.="    ps.ds_produto_servico,";
                        $sql.="    fci.contratos_pk,";  
                        $sql.="    fci.ds_periodo,";                       
                        $sql.="    fci.n_qtde_produtos_servicos,";
                        $sql.="    fci.n_qtde_dias_semana,"; 
                        $sql.="    fci.vl_unitario_produtos_servicos";
                        $sql.=" FROM faturamento_contratos_itens fci";
                        $sql.="    INNER JOIN produtos_servicos ps ON fci.produtos_servicos_pk = ps.pk";
                        $sql.=" WHERE fci.contratos_pk =".$queryContratos[$h]["contratos_pk"];
                        $sql.="   AND fci.faturamento_contratos_pk =".$queryContratos[$h]["faturamento_contratos_pk"];
                        //echo $sql."<br>";

                        $queryContratosItens = $this->db->execQuery($sql);
                        if(count($queryContratosItens) > 0){
                            for($l = 0; $l < count($queryContratosItens); $l++){
                                $vl_total = $queryContratosItens[$l]["n_qtde_produtos_servicos"] * $queryContratosItens[$l]["vl_unitario_produtos_servicos"];
                                $DadosContratosItens[] = array(
                                    "faturamento_contratos_itens_pk" => $queryContratosItens[$l]["faturamento_contratos_itens_pk"],
                                    "contratos_pk" => $queryContratosItens[$l]["contratos_pk"],
                                    "produto_servico_pk" => $queryContratosItens[$l]["produto_servico_pk"],
                                    "ds_servico_prestado" => $queryContratosItens[$l]["ds_produto_servico"],
                                    "n_qtde_colaborador" => $queryContratosItens[$l]["n_qtde_produtos_servicos"],
                                    "ds_escala" => $queryContratosItens[$l]["n_qtde_dias_semana"],
                                    "ds_carga_horaria_dia" => $queryContratosItens[$l]["ds_periodo"],
                                    "vl_unit" => $queryContratosItens[$l]["vl_unitario_produtos_servicos"],
                                    "vl_total" => $vl_total,
                                );
                            }  
                        }  
                    }  
                } 
     
            }
        }   

        $result[] = array(
            "pk" => $pk,
            "ds_usuario_cadastro"=>$queryFatutamento[0]['ds_usuario_cadastro'],
            "ds_usuario_atualizacao"=>$queryFatutamento[0]['ds_usuario_atualizacao'],
            "dt_cadastro"=>$queryFatutamento[0]['dt_cadastro'],
            "dt_ult_atualizacao"=>$queryFatutamento[0]['dt_ult_atualizacao'],
            "dt_faturamento_ini"=>$queryFatutamento[0]['dt_faturamento_ini'],
            "dt_faturamento_fim"=>$queryFatutamento[0]['dt_faturamento_fim'],
            "ds_usatus_faturamento"=>$queryFatutamento[0]['ds_usatus_faturamento'],
            "ic_contrato_fixo"=>$queryFatutamento[0]['ic_contrato_fixo'],
            "ic_contrato_aditivo"=>$queryFatutamento[0]['ic_contrato_aditivo'],
            "ic_contrato_servico_extra"=>$queryFatutamento[0]['ic_contrato_servico_extra'],
            "ic_gerar_fatura"=>$queryFatutamento[0]['ic_gerar_fatura'],
            "ic_gerar_boleto"=>$queryFatutamento[0]['ic_gerar_boleto'],
            "ic_gerar_nota_fiscal"=>$queryFatutamento[0]['ic_gerar_nota_fiscal'],
            "obs"=>$queryFatutamento[0]['obs'],
            "DadosContas"=>$DadosContas,
            "DadosContratos"=>$DadosContratos,
            "DadosContratosItens"=>$DadosContratosItens,
        );
        return $result;
    }

}

?>
