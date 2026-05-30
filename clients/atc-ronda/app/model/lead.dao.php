<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/lead.class.php';
require_once "../model/processo.dao.php";
require_once "../model/processo.class.php";
require_once "../model/processo_default.dao.php";
require_once "../model/processo_default.class.php";
require_once "../model/contato.dao.php";
require_once "../model/contato.class.php";
require_once "../model/lead_imposto.dao.php";
require_once "../model/lead_imposto.class.php";
require_once "../model/lead_desconto.dao.php";
require_once "../model/lead_desconto.class.php";

require_once "../model/comercial.dao.php";
class leaddao{

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
    
    public function salvar($lead, $token, $arrContatosLead, $arrImpostoLead, $arrDescontoLead, $processo_default_configuracao_pk){

        $processodao = new processodao();
        $processodao->setToken($token); 

        $processo_defaultdao = new processo_defaultdao();
        $processo_defaultdao->setToken($token); 

        $contatodao = new contatodao();
        $contatodao->setToken($token);
            
        $lead_impostodao = new lead_impostodao();
        $lead_impostodao->setToken($token);

        $lead_descontodao = new lead_descontodao();
        $lead_descontodao->setToken($token);

        $comercialdao = new comercialdao();
        $comercialdao->setToken($token);

        $fields = array();
        $fields['ds_lead'] = $lead->getds_lead();
        $fields['ds_endereco'] = $lead->getds_endereco();
        $fields['ds_numero'] = $lead->getds_numero();
        $fields['ds_complemento'] = $lead->getds_complemento();
        $fields['ds_cep'] = $lead->getds_cep();
        $fields['ds_bairro'] = $lead->getds_bairro();
        $fields['ds_cidade'] = $lead->getds_cidade();
        $fields['ds_uf'] = $lead->getds_uf();
        $fields['ic_cliente'] = $lead->getic_cliente();
        $fields['ds_obs'] = $lead->getds_obs();
        $fields['n_qtde_torres'] = $lead->getn_qtde_torres();
        
        $fields['ds_razao_social'] = $lead->getds_razao_social();
        $fields['ds_cpf_cnpj'] = $lead->getds_cpf_cnpj();
        $fields['ds_ie'] = $lead->getds_ie();
        $fields['ds_tel'] = $lead->getds_tel();
        $fields['ds_fax'] = $lead->getds_fax();
        $fields['ds_site'] = $lead->getds_site();
        $fields['ds_email'] = $lead->getds_email();
        $fields['supervisores_pk'] = $lead->getsupervisores_pk();
        $fields['supervisor1_pk'] = $lead->getsupervisor1_pk();
        $fields['supervisor2_pk'] = $lead->getsupervisor2_pk();
        $fields['responsavel_pk'] = $lead->getresponsavel_pk();
        $fields['segmentos_pk'] = $lead->getsegmentos_pk();
        $fields['leads_pai_pk'] = $lead->getleads_pai_pk();
        $fields['ic_tipo_lead'] = $lead->getic_tipo_lead();
        $fields['ds_email'] = $lead->getds_email();
        $fields['ds_tipo'] = $lead->getds_tipo();
        $fields['ds_porte'] = $lead->getds_porte();
        $fields['dt_abertura'] = $lead->getdt_abertura();
        $fields['ds_atividade_principal'] = $lead->getds_atividade_principal();
        $fields['ds_atividade_secundaria'] = $lead->getds_atividade_secundaria();
        $fields['ds_socio1'] = $lead->getds_socio1();
        $fields['ds_socio2'] = $lead->getds_socio2();
        $fields['ds_socio3'] = $lead->getds_socio3();
        
        if($lead->getdt_vencimento()!=""){
            $fields['dt_vencimento'] = $lead->getdt_vencimento();
        }
        else{
            $fields['dt_vencimento'] = "null";
        }

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($lead->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("leads", $fields);
        }
        else{
            $this->db->execUpdate("leads", $fields, " pk = ".$lead->getpk());
            $pk = $lead->getpk();
        }

        if($pk!=""){
            $leads_pk = $pk;
            //processo 
            //veririca se ja tem um processo registrado
            $queryProcesso = $processodao->verificarQtdeLead($pk); 

            if($queryProcesso[0]["qtde"]==0){
                //cadastra um novo processo
                $processo_default= $processo_defaultdao->listarTodos();

                if($processo_default[0]['pk']>0){                   
                    $processo = $processodao->carregarPorPk("");

                    $processo->setds_processo($processo_default[0]['ds_processo_default']);

                    $processo->setprocessos_default_pk($processo_default[0]['pk']);
                    $processo->setleads_pk($leads_pk);

                    $processo_pk = $processodao->salvar($processo);
                }              
            }

            if(count($arrContatosLead) > 0){
                for($i = 0; $i < count($arrContatosLead); $i++){    
                    $contato = $contatodao->carregarPorPk($arrContatosLead[$i]['contatos_pk']);                    
                    $contato->setds_contato($arrContatosLead[$i]['ds_contato']);
                    $contato->setds_cel($arrContatosLead[$i]['ds_cel']);
                    $contato->setic_whatsapp($arrContatosLead[$i]['ic_whatsapp']);
                    $contato->setds_email($arrContatosLead[$i]['ds_email']);
                    $contato->setds_tel($arrContatosLead[$i]['ds_tel_contato']);
                    $contato->setcargos_pk($arrContatosLead[$i]['cargos_pk']);
                    $contato->setleads_pk($pk);
                    $contatos_pk = $contatodao->salvar($contato);                        
                }
            }
        }else{            
            $leads_pk = $lead->getpk();
            if(count($arrContatosLead) > 0){
                for($i = 0; $i < count($arrContatosLead); $i++){         
                    $contato = $contatodao->carregarPorPk($arrContatosLead[$i]['contatos_pk']);                                        
                    $contato->setds_contato($arrContatosLead[$i]['ds_contato']);
                    $contato->setds_cel($arrContatosLead[$i]['ds_cel']);
                    $contato->setic_whatsapp($arrContatosLead[$i]['ic_whatsapp']);
                    $contato->setds_email($arrContatosLead[$i]['ds_email']);
                    $contato->setds_tel($arrContatosLead[$i]['ds_tel_contato']);
                    $contato->setcargos_pk($arrContatosLead[$i]['cargos_pk']);
                    $contato->setleads_pk($lead->getpk());
                    $contatos_pk = $contatodao->salvar($contato);                        
                }
            }
        }   
        
        //Imposto
        if(count($arrImpostoLead) > 0){   
            $lead_impostodao->excluirPorLead($leads_pk);
            for($i = 0; $i < count($arrImpostoLead); $i++){     
                if($arrImpostoLead[$i]['imposto_pk']!=""){
                    $lead_imposto = $lead_impostodao->carregarPorPk(0);
                    $lead_imposto->setds_percentual_imposto($arrImpostoLead[$i]['ds_percentual_imposto']);
                    $lead_imposto->setimposto_pk($arrImpostoLead[$i]['imposto_pk']);
                    $lead_imposto->setleads_pk($leads_pk);
                    $imposto_pk = $lead_impostodao->salvar($lead_imposto);
                }
            }
        }

        $lead_descontodao->excluirPorLead($leads_pk);
        //Desconto
        if(count($arrDescontoLead) > 0){   
            for($i = 0; $i < count($arrDescontoLead); $i++){     

                if($arrDescontoLead[$i]['ds_desconto']!=""){
                    $lead_desconto = $lead_descontodao->carregarPorPk(0);
                    $lead_desconto->setds_desconto($arrDescontoLead[$i]['ds_desconto']);
                    $lead_desconto->setvl_desconto($arrDescontoLead[$i]['vl_desconto']);
                    if($arrDescontoLead[$i]['dt_base_desconto']!=""){
                        $lead_desconto->setdt_base(DataYMD($arrDescontoLead[$i]['dt_base_desconto']));
                    }
                    $lead_desconto->setleads_pk($leads_pk);
                    
                    $desconto = $lead_descontodao->salvar($lead_desconto);
                }
            }
        }

        if($processo_default_configuracao_pk != ''){   
            $comercialdao->salvarProcessoMovimentacaoStatus($processo_default_configuracao_pk, $pk, '', '');
        }

    }

    public function excluir($lead){
        $this->db->execDelete("leads"," pk = ".$lead->getpk());
    }
    //novo
    public function listarLeadsPorEmpresa($empresas_pk){

        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.=" FROM leads l";
        $sql.="     LEFT JOIN processos p ON l.pk = p.leads_pk";
        $sql.="     LEFT JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="     LEFT JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.=" WHERE 1 = 1";
        if(!empty($empresas_pk)){
            $sql.=" AND c.empresas_pk=".$empresas_pk;
        }
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function llistaLeadsClientes(){
        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE l.ic_tipo_lead=1";
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }

    

    public function listaLeadsClientes(){
        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE l.ic_tipo_lead=1";
        $sql.=" AND l.ic_cliente=1";
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listaLeadsPostosTrabalho($pk){
        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE l.ic_tipo_lead=2";
        $sql.=" AND l.leads_pai_pk=".$pk;        
        $sql.=" AND l.ic_cliente=1";     
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";        

        $query = $this->db->execQuery($sql);
        return $query;
    }  

    public function listarClienteColaborador($colaborador_pk){
        $sql ="";
        $sql.=" SELECT l.pk,";
        $sql.="        l.ds_lead";
        $sql.=" FROM leads l ";
        $sql.=" left JOIN leads ll ON l.pk = ll.leads_pai_pk";
        $sql.=" left JOIN agenda_colaborador_padrao a ON ll.pk = a.leads_pk";
        $sql.=" WHERE 1 = 1 ";
        if(!empty($colaborador_pk)){
           // $sql.=" AND a.colaboradores_pk = ".$colaborador_pk;
        }
        $sql.="    AND l.ic_cliente = 1";
        $sql.="    AND l.ic_tipo_lead = 1";
        $sql.="    AND a.dt_cancelamento IS NULL";    
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";    
        $query = $this->db->execQuery($sql);
        return $query;
    }  

    public function listaColaboradorPostosTrabalho($colaborador_pk,$leads_pk){
        $sql ="";
        $sql.=" SELECT l.pk,";
        $sql.="        l.ds_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE 1=1";
        if(!empty($leads_pk)){
            $sql.=" AND l.leads_pai_pk=".$leads_pk;
            $sql.=" or l.pk=".$leads_pk;
        }
        $sql.="    AND l.ic_cliente = 1";
        $sql.="    Group by l.ds_lead";

        $query = $this->db->execQuery($sql);
        return $query;
    }  



    public function listaFornecedorPostosTrabalho($leads_pk){
        $sql ="";
        $sql.=" SELECT l.pk,";
        $sql.="        l.ds_lead,";
        $sql.="        l.ic_cliente";
        $sql.=" FROM leads l  ";
        $sql.=" WHERE 1=1 ";
        if(!empty($leads_pk)){
            $sql.=" AND l.leads_pai_pk=".$leads_pk;
        }
        //$sql.="    AND l.ic_cliente = 1";
        $sql.="    AND l.ic_tipo_lead = 2";
        
        $sql.="    Group by l.pk";
        $sql.="  ORDER BY l.ic_cliente = 1 desc ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }  
    
    
     public function listaLeadPK($pk){

        $sql ="";
        $sql.=" SELECT l.pk, l.ds_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE l.pk=".$pk;
        $sql.=" GROUP BY l.pk";
        $sql.=" ORDER BY l.ds_lead";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }    
    
    //antigo
    public function excluirProcesso($lead){
        $sql="";
        $sql.=" select pk from processos where leads_pk = ".$lead->getpk();
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            
            
            $sql="";
            $sql.=" select pk from processos_etapas where processos_pk = ".$query[$i]['pk'];
            $queryp = $this->db->execQuery($sql);
            for($j = 0; $j < count($queryp); $j++){
                
                
                $sql="";
                $sql.="select pk from contratos where processos_etapas_pk = ".$queryp[$j]['pk'];

                $queryc = $this->db->execQuery($sql);
                for($c = 0; $c < count($queryc); $c++){
                    $this->db->execDelete("contratos_itens"," contratos_pk = ".$queryc[$c]['pk']);
                }
                
                $sql="";
                $sql.="select pk from propostas where processos_etapas_pk = ".$queryp[$j]['pk'];

                $queryprop = $this->db->execQuery($sql);
                for($p = 0; $p < count($queryprop); $p++){
                    $this->db->execDelete("propostas_itens"," propostas_pk = ".$queryprop[$p]['pk']);
                }
                
                
                
                $this->db->execDelete("propostas"," processos_etapas_pk = ".$queryp[$j]['pk']);
                $this->db->execDelete("contratos"," processos_etapas_pk = ".$queryp[$j]['pk']);
                $this->db->execDelete("agenda_colaborador_padrao"," processos_etapas_pk = ".$queryp[$j]['pk']);
            }
            $this->db->execDelete("processos_etapas"," processos_pk = ".$query[$i]['pk']);
        }
        
        $this->db->execDelete("processos"," leads_pk = ".$lead->getpk());
    }
    
    public function excluirDocumento($lead){
        $this->db->execDelete("documentos"," leads_pk = ".$lead->getpk());
    }
    public function excluirOcorrencia($lead){
        $this->db->execDelete("ocorrencias"," leads_pk = ".$lead->getpk());
    }
    public function excluirImposto($lead){
        $this->db->execDelete("leads_impostos"," leads_pk = ".$lead->getpk());
    }
    
    public function listaLeadsClientesPK($leads_pk_pai){

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.=" l.ds_lead";
        $sql.=",case WHEN l.ic_tipo_lead =1  THEN 'Sede'
                WHEN l.ic_tipo_lead =2  THEN 'Posto de Trabalho'
              END ds_tipo_lead";
        $sql.=" FROM leads l";
        $sql.=" WHERE 1=1 ";        
        if(!empty($leads_pk_pai)){
            $sql.=" And l.pk = ".$leads_pk_pai;
            $sql.=" or l.leads_pai_pk = ".$leads_pk_pai;
        }

        $sql.=" order by l.pk";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    //antigo
    public function carregarPorPk($pk){

        $lead = new lead();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_lead ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ds_obs ";
        $sql.="       ,n_qtde_torres ";
        
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_ie";
        $sql.="       ,ds_tel";
        $sql.="       ,ds_fax";
        $sql.="       ,ds_site";
        $sql.="       ,ds_email";
        $sql.="       ,supervisores_pk";
        $sql.="       ,responsavel_pk";
        $sql.="       ,segmentos_pk";
        $sql.="       ,ic_tipo_lead";
        $sql.="       ,leads_pai_pk";
        //$sql.="       ,dt_vencimento";


        $sql.="  from leads ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $lead->setpk($query[$i]["pk"]);
                $lead->setdt_cadastro($query[$i]["dt_cadastro"]);
                $lead->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $lead->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $lead->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $lead->setds_lead($query[$i]['ds_lead']);
                $lead->setds_endereco($query[$i]['ds_endereco']);
                $lead->setds_numero($query[$i]['ds_numero']);
                $lead->setds_complemento($query[$i]['ds_complemento']);
                $lead->setds_cep($query[$i]['ds_cep']);
                $lead->setds_bairro($query[$i]['ds_bairro']);
                $lead->setds_cidade($query[$i]['ds_cidade']);
                $lead->setds_uf($query[$i]['ds_uf']);
                $lead->setic_cliente($query[$i]['ic_cliente']);
                $lead->setds_obs($query[$i]['ds_obs']);
                $lead->setn_qtde_torres($query[$i]['n_qtde_torres']);
                
                $lead->setds_razao_social($query[$i]['ds_razao_social']);
                $lead->setds_cpf_cnpj($query[$i]['ds_cpf_cnpj']);
                $lead->setds_ie($query[$i]['ds_ie']);
                $lead->setds_tel($query[$i]['ds_tel']);
                $lead->setds_fax($query[$i]['ds_fax']);
                $lead->setds_site($query[$i]['ds_site']);
                $lead->setds_email($query[$i]['ds_email']);
                $lead->setsupervisores_pk($query[$i]['supervisores_pk']);
                $lead->setresponsavel_pk($query[$i]['responsavel_pk']);
                $lead->setsegmentos_pk($query[$i]['segmentos_pk']);
                $lead->setic_tipo_lead($query[$i]['ic_tipo_lead']);
                $lead->setleads_pai_pk($query[$i]['leads_pai_pk']);
                //$lead->setdt_vencimento($query[$i]['dt_vencimento']);

            }
        }
        return $lead;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select l.pk, date_format(l.dt_cadastro,'%d/%m/%Y') dt_cadastro, l.usuario_cadastro_pk, date_format(l.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao, l.usuario_ult_atualizacao_pk  ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_endereco ";
        $sql.="       ,l.ds_numero ";
        $sql.="       ,l.ds_complemento ";
        $sql.="       ,l.ds_cep ";
        $sql.="       ,l.ds_bairro ";
        $sql.="       ,l.ds_cidade ";
        $sql.="       ,l.ds_uf ";
        $sql.="       ,l.ic_cliente ";
        $sql.="       ,case l.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_ic_cliente";
        $sql.="       ,l.ds_obs ";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.n_qtde_torres ";        
        $sql.="       ,l.ds_razao_social";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,l.ds_ie";
        $sql.="       ,l.ds_tel";
        $sql.="       ,l.ds_fax";
        $sql.="       ,l.ds_site";
        $sql.="       ,l.ds_email";
        $sql.="       ,l.supervisores_pk";
        $sql.="       ,l.supervisor1_pk";
        $sql.="       ,l.supervisor2_pk";
        $sql.="       ,l.responsavel_pk";
        $sql.="       ,l.segmentos_pk";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       ,u.ds_usuario ds_supervisor";
        $sql.="       ,u.ds_email ds_email_supervisor";
        $sql.="       ,ur.ds_usuario ds_responsavel";
        $sql.="       ,l.ds_tipo";
        $sql.="       ,l.ds_porte";
        $sql.="       ,date_format(l.dt_abertura,'%d/%m/%Y') dt_abertura";
        $sql.="       ,l.ds_atividade_principal";
        $sql.="       ,l.ds_atividade_secundaria";
        $sql.="       ,l.ds_socio1";
        $sql.="       ,l.ds_socio2";
        $sql.="       ,l.ds_socio3";
        $sql.="       ,usu.ds_usuario ds_usuario_cadastro";

        $sql.="  from leads l";
        $sql.="        left join usuarios u on u.pk = l.supervisores_pk";
        $sql.="        left join usuarios ur on ur.pk = l.responsavel_pk";
        $sql.="        Inner join usuarios usu on usu.pk = l.usuario_cadastro_pk";
        $sql.=" where l.pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarLeadsComMovimentacao(){

        $sql ="";
        $sql.="SELECT ";
        $sql.="        l.pk";
        $sql.="    FROM";
        $sql.="        leads l";
        $sql.="            INNER JOIN";
        $sql.="        movimentacao_estoque me ON l.pk AND me.leads_pk";
        $sql.="        where 1=1";
        $sql.="        and me.conjunto_material_pk is null";
        $sql.="    GROUP BY l.pk";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarDataCadastroMovimentacaoEstoquePorLeadsPk($leads_pk){

        $sql ="";
        $sql.="SELECT ";
        $sql.="        DATE_FORMAT(dt_cadastro, '%d/%m/%Y') dt_cadastro";
        $sql.="    FROM";
        $sql.="        movimentacao_estoque";
        $sql.="    WHERE";
        $sql.="        leads_pk =".$leads_pk;
        $sql.="    GROUP BY DATE_FORMAT(dt_cadastro, '%d/%m/%Y')";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkMovimentacaoEstoquePorLeadsPk($leads_pk,$dt_cadastro){

        $sql ="";
        $sql.="SELECT ";
        $sql.="        pk";
        $sql.="    FROM";
        $sql.="        movimentacao_estoque";
        $sql.="    WHERE";
        $sql.="        leads_pk = ".$leads_pk;
        $sql.="            AND dt_cadastro BETWEEN '".DataYMD($dt_cadastro)." 00:00:00' AND '".DataYMD($dt_cadastro)." 23:59:59'";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkContato($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from contatos ";
        $sql.=" where leads_pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkMovimentacaoEstoque($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from movimentacao_estoque ";
        $sql.=" where leads_pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkLeadsImpostos($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from leads_impostos ";
        $sql.=" where leads_pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkDocumentos($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from documentos ";
        $sql.=" where leads_pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkOcorrencia($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from ocorrencias ";
        $sql.=" where leads_pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkContratosItens($pk){

        $sql ="";
        $sql.="select ci.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join contratos c on pe.pk = c.processos_etapas_pk";
        $sql.="  inner join contratos_itens ci on c.pk = ci.contratos_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkContratos($pk){

        $sql ="";
        $sql.="select c.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join contratos c on pe.pk = c.processos_etapas_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkPropostasItens($pk){

        $sql ="";
        $sql.="select pi.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join propostas pp on pe.pk = pp.processos_etapas_pk";
        $sql.="  inner join propostas_itens pi on pp.pk = pi.propostas_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkPropostas($pk){

        $sql ="";
        $sql.="select pp.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join propostas pp on pe.pk = pp.processos_etapas_pk";
        $sql.="  inner join propostas_itens pi on pp.pk = pi.propostas_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkAgendaColaboradorPadrao($pk){

        $sql ="";
        $sql.="select acp.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.="  inner join agenda_colaborador_padrao acp on pe.pk = acp.processos_etapas_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkProcessosEtapas($pk){

        $sql ="";
        $sql.="select pe.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.="  inner join processos_etapas pe on p.pk = pe.processos_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarPkProcessos($pk){

        $sql ="";
        $sql.="select p.pk";

        $sql.="  from leads l";
        $sql.="  inner join processos p on l.pk = p.leads_pk";
        $sql.=" where l.pk = $pk ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    public function listarLeadPai(){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk  ";
        $sql.="       ,l.ds_lead ";
        $sql.="       ,l.ds_endereco ";
        $sql.="       ,l.ds_numero ";
        $sql.="       ,l.ds_complemento ";
        $sql.="       ,l.ds_cep ";
        $sql.="       ,l.ds_bairro ";
        $sql.="       ,l.ds_cidade ";
        $sql.="       ,l.ds_uf ";
        $sql.="       ,l.ic_cliente ";
        $sql.="       ,case l.ic_cliente when 1 then 'Sim' when 2 then 'Não' end ds_ic_cliente";
        $sql.="       ,l.ds_obs ";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.n_qtde_torres ";        
        $sql.="       ,l.ds_razao_social";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,l.ds_ie";
        $sql.="       ,l.ds_tel";
        $sql.="       ,l.ds_fax";
        $sql.="       ,l.ds_site";
        $sql.="       ,l.ds_email";
        $sql.="       ,l.supervisores_pk";
        $sql.="       ,l.responsavel_pk";
        $sql.="       ,l.segmentos_pk";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       ,u.ds_usuario ds_supervisor";
        $sql.="       ,u.ds_email ds_email_supervisor";
        $sql.="       ,ur.ds_usuario ds_responsavel";

        $sql.="  from leads l";
        $sql.="        left join usuarios u on u.pk = l.supervisores_pk";
        $sql.="        left join usuarios ur on ur.pk = l.responsavel_pk";
        $sql.=" where l.ic_cliente = 1 ";
        $sql.=" and l.ic_tipo_lead = 1 ";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    public function listarEnderecoPorLeadPk($leads_pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,responsavel_pk";
        $sql.="       ,segmentos_pk";
        $sql.="       ,ic_tipo_lead";
        $sql.="       ,leads_pai_pk";
        $sql.="       ,date_format(dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="  from leads ";
        $sql.=" where 1=1";
        if($leads_pk!=0){
            $sql.=" and pk =".$leads_pk;
        }
        $sql.=" group by ds_cidade";
        $sql.=" order by ds_cidade";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function listarEndereco($leads_pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,responsavel_pk";
        $sql.="       ,segmentos_pk";
        $sql.="       ,ic_tipo_lead";
        $sql.="       ,leads_pai_pk";
        $sql.="       ,date_format(dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="  from leads ";
        $sql.=" where 1=1";
        if($leads_pk!=0){
            $sql.=" and pk =".$leads_pk;
        }
        $query = $this->db->execQuery($sql);
        for($i = 0; $i < count($query); $i++){
            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_cep"=>$query[$i]['ds_cep'],
                "ds_numero"=>$query[$i]['ds_numero'],
                "ds_cidade"=>$query[$i]['ds_cidade'],
                "ds_uf"=>$query[$i]['ds_uf'],
                "ds_bairro"=>$query[$i]['ds_bairro'],
                "ds_complemento"=>$query[$i]['ds_complemento'],
                "ds_endereco_completo"=>$query[$i]['ds_endereco']." N°:".$query[$i]['ds_numero']." (".$query[$i]['ds_cidade']."-".$query[$i]['ds_uf'].")",
                "ds_endereco"=>$query[$i]['ds_endereco']
            );
        }
        return $result;
    }
    public function RelatorioPostoTrabalhoAnalitico($leads_pk,$ds_cidade,$ic_tipo_lead,$ic_cliente){
        $sql ="";
        $sql.="select l.pk, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk  ";
        $sql.="       ,uc.ds_usuario ds_usuario_cadastro";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_razao_social";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,l.ds_cep ";
        $sql.="       ,l.ds_endereco ";
        $sql.="       ,l.ds_numero ";
        $sql.="       ,l.ds_complemento ";
        $sql.="       ,l.ds_bairro ";
        $sql.="       ,l.ds_cidade ";
        $sql.="       ,l.ds_uf ";
        $sql.="       ,l.ds_tel";
        $sql.="       ,ur.ds_usuario ds_supervisor";
        $sql.="       ,l.responsavel_pk";
        $sql.="       ,case l.segmentos_pk when 1 then 'Condomínios' when 2 then 'Escolas' when 3 then 'Escritórios' when 4 then 'Industrias' when 5 then 'Residencial' when 6 then 'Pós obra' end ds_segmento";
        $sql.="       ,case l.ic_tipo_lead when 1 then 'Cliente' when 2 then 'Posto de Trabalho' end ds_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       ,ll.ds_lead ds_lead_pai";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,date_format(l.dt_cadastro,'%d/%m/%Y')dt_cadastro";
        $sql.="  from leads l";
        $sql.="  left join leads ll on ll.pk = l.leads_pai_pk";
        $sql.="  left join usuarios ur on ur.pk = l.supervisores_pk";
        $sql.="  inner join usuarios uc on uc.pk = l.usuario_cadastro_pk";
        $sql.=" where 1=1";
        if($leads_pk!=""){
            $sql.=" and l.pk =".$leads_pk;
        }
        if($ic_tipo_lead!=""){
            $sql.=" and l.ic_tipo_lead =".$ic_tipo_lead;
        }
        if($ic_cliente!=""){
            $sql.=" and l.ic_cliente =".$ic_cliente;
        }
        if($ds_cidade!=""){
            $sql.=" and l.ds_cidade like '%".$ds_cidade."%'";
        }
        $sql.=" group by l.pk";
        $sql.=" order by l.ds_lead";
       
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listar_por_ds_lead($ds_lead,$ic_cliente,$supervisores_pk,$responsavel_pk,$ds_lead_grid,$ic_tipo_lead,$leads_pai_pk, $leads_clientes_pk, $cod_lead){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,case WHEN l.leads_pai_pk is null  THEN
                            l.ds_lead 
                        ELSE 
                            concat(ll.ds_lead,' - Posto:',l.ds_lead) 
                        END ds_lead";
        $sql.="       ,l.ds_endereco ";
        $sql.="       ,l.ds_numero ";
        $sql.="       ,l.ds_complemento ";
        $sql.="       ,l.ds_cep ";
        $sql.="       ,l.ds_bairro ";
        $sql.="       ,l.ds_cidade ";
        $sql.="       ,l.ds_uf ";
        $sql.="       ,case l.ic_cliente when 1 then 'Ativo' when 2 then 'Desativado' end ic_cliente ";
        $sql.="       ,l.ds_obs ";
        $sql.="       ,l.n_qtde_torres ";        
        $sql.="       ,l.ds_razao_social";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,l.ds_ie";
        $sql.="       ,l.ds_tel";
        $sql.="       ,l.ds_fax";
        $sql.="       ,l.ds_site";
        $sql.="       ,l.ds_email";
        $sql.="       ,l.supervisores_pk";
        $sql.="       ,l.responsavel_pk";
        $sql.="       ,l.segmentos_pk";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,case l.ic_tipo_lead when 1 then 'Cliente' when 2 then 'Posto de Trabalho' end ds_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="  from leads l ";
        $sql.="  left join leads ll on l.leads_pai_pk = ll.pk";
        $sql.=" where 1=1 ";
        if($ic_cliente != ""){
            $sql.=" and l.ic_cliente = ".$ic_cliente;
        } 
        if($leads_clientes_pk!="" && $leads_pai_pk!=""){
            $sql .= " and (l.pk = " . $leads_clientes_pk . " OR l.leads_pai_pk = " . $leads_clientes_pk . ")";
        }
        
        if($ic_tipo_lead!=""){
            $sql.=" and l.ic_tipo_lead = ".$ic_tipo_lead;
        }
        
        
        if($ds_lead_grid != ""){
            $sql.=" and l.ds_lead like '%".$ds_lead_grid."%'";
        }
        if($ds_lead != ""){
            $sql.=" and l.pk = ".$ds_lead;
        }
  

        if($supervisores_pk != ""){
            $sql.=" and l.supervisores_pk =".$supervisores_pk;
        }
        if($responsavel_pk != ""){
            $sql.=" and l.responsavel_pk =".$responsavel_pk;
        }

        if($cod_lead != ""){
            $sql.=" and l.pk = ".$cod_lead;
        }

        $sql.=" order by ds_lead asc ";
  
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_por_ds_lead_pai_pk($ic_tipo_lead,$leads_pai_pk,$ic_cliente){

        $sql ="";
        $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
        $sql.="       ,case WHEN l.leads_pai_pk is null  THEN
                            l.ds_lead 
                        ELSE 
                            concat(ll.ds_lead,' - Posto:',l.ds_lead) 
                        END ds_lead";
        $sql.="       ,case l.ic_cliente when 1 then 'Ativo' when 2 then 'Desativado' end ic_cliente ";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,case l.ic_tipo_lead when 1 then 'Cliente' when 2 then 'Posto de Trabalho' end ds_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="  from leads l ";
        $sql.="  left join leads ll on l.leads_pai_pk = ll.pk";
        $sql.=" where 1=1 ";
        if($ic_cliente != ""){
            $sql.=" and l.ic_cliente = ".$ic_cliente;
        } 
        if($ic_tipo_lead!=""){
            $sql.=" and l.ic_tipo_lead = ".$ic_tipo_lead;
        }
        if($leads_pai_pk!=""){
            $sql .= " and (l.pk = " . $leads_pai_pk . " OR l.leads_pai_pk = " . $leads_pai_pk . ")";
        }
        
        
        
        $sql.=" order by ds_lead asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function verificarCNPJ($ds_cpf_cnpj){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="  from leads ";
        $sql.=" where 1=1 ";
        if($ds_cpf_cnpj != ""){
            $sql.=" and ds_cpf_cnpj = '".$ds_cpf_cnpj."'";
        }
        $sql.=" order by ds_lead asc ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodosAtivo(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_lead ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,case ic_cliente when 1 then 'Sim' when 2 then 'Não' end ic_cliente ";
        $sql.="       ,ds_obs ";
        $sql.="       ,n_qtde_torres ";        
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_ie";
        $sql.="       ,ds_tel";
        $sql.="       ,ds_fax";
        $sql.="       ,ds_site";
        $sql.="       ,ds_email";
        $sql.="       ,supervisores_pk";
        $sql.="       ,responsavel_pk";
        $sql.="       ,segmentos_pk";
        $sql.="       ,ic_tipo_lead";
        $sql.="       ,leads_pai_pk";
        $sql.="       ,date_format(dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="  from leads ";
        $sql.=" where 1=1 ";
        $sql.=" and ic_cliente = 1";
        $sql.=" order by ds_lead asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodosConta($empresas_pk){

        $sql ="";
        $sql.="select  l.pk";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,c.empresas_pk";
        $sql.="       ,co.ds_razao_social";
        $sql.="  from leads l";
        $sql.="       left join processos p on p.leads_pk = l.pk ";
        $sql.="       left join processos_etapas pe on pe.processos_pk = p.pk ";
        $sql.="       left join contratos c on c.processos_etapas_pk = pe.pk ";
        $sql.="       left join contas co on c.empresas_pk = co.pk ";
        $sql.=" where 1=1 ";
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (c.empresas_pk=".$empresas_pk.")";
            }
            else{
                $sql.=" and c.empresas_pk=".$empresas_pk;
            }
            
        }
        else{
            $sql.=" and c.empresas_pk is null";
        }
        //$sql.=" and l.ic_cliente = 1";
        $sql.=" group by l.pk";
        $sql.=" order by l.ds_lead asc ";
    
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarTodosContaFatura($empresas_pk,$tipo_contrato_pk){

        $sql ="";
       $sql.="select  l.pk";
        $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
        $sql.="       ,l.ds_lead";
        $sql.="       ,l.ds_cpf_cnpj";
        $sql.="       ,c.empresas_pk";
        $sql.="       ,co.ds_razao_social";
        $sql.="  from leads l";
        $sql.="       inner join processos p on p.leads_pk = l.pk ";
        $sql.="       inner join processos_etapas pe on pe.processos_pk = p.pk ";
        $sql.="       inner join contratos c on c.processos_etapas_pk = pe.pk ";
        $sql.="       left join contas co on c.empresas_pk = co.pk ";
        $sql.=" where 1=1 ";
        if($empresas_pk != ""){
            if($empresas_pk==1){
                $sql.=" and (c.empresas_pk=".$empresas_pk.")";
            }
            else{
                $sql.=" and c.empresas_pk=".$empresas_pk;
            }
            
        }
        else{
            $sql.=" and c.empresas_pk is null";
        }
        if($tipo_contrato_pk!=""){
            $sql.=" and c.ic_tipo_contrato=".$tipo_contrato_pk;
        }
        //$sql.=" and l.ic_cliente = 1";
        $sql.=" group by l.pk";
        $sql.=" order by l.ds_lead asc ";
    
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function listarLeadPesquisa($strPesquisar,$token){
       
        if (strlen(intval($strPesquisar)) >= 10) {
            $pesquisar = formatCnpjCpf($strPesquisar);
        }
        else{
             $pesquisar = ($strPesquisar);
        }
       
    
                       
        $sql ="";
        $sql.="select l.pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,group_concat(DISTINCT u.ds_usuario)ds_responsavel";
        $sql.="       ,concat(l.ds_endereco,' - ',l.ds_bairro)ds_endereco";
        $sql.="  from leads l";
        $sql.="       left join usuarios u on u.pk = l.responsavel_pk";
        $sql.="       left join contatos c on c.leads_pk = l.pk";
        $sql.=" where 1=1 ";
        
        if(!empty($pesquisar)){
		$sql.=" and (l.ds_cpf_cnpj like '".("%".$pesquisar."%")."' ";
                $sql.="     or l.ds_razao_social like '" . ("%".$pesquisar."%") . " '";
                $sql.="     or l.ds_lead Like '" . ("%".$pesquisar."%") . "' ";
                $sql.="     or l.ds_endereco Like '" . ("%".$pesquisar."%") . "' ";
                $sql.="     or c.ds_contato Like '" . ("%".$pesquisar."%") . "' ";
                $sql.="     or u.ds_usuario Like '" . ("%".$pesquisar."%") . "' ";
                $sql.="     or l.pk = '" . ("".$pesquisar."")."') ";
        }
        $sql.=" group by l.pk";
        $sql.=" order by l.pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_lead ";
        $sql.="       ,ds_endereco ";
        $sql.="       ,ds_numero ";
        $sql.="       ,ds_complemento ";
        $sql.="       ,ds_cep ";
        $sql.="       ,ds_bairro ";
        $sql.="       ,ds_cidade ";
        $sql.="       ,ds_uf ";
        $sql.="       ,ic_cliente ";
        $sql.="       ,ds_obs ";
        $sql.="       ,n_qtde_torres ";
        $sql.="       ,ic_tipo_lead";
        $sql.="       ,leads_pai_pk";
        
        $sql.="       ,ds_razao_social";
        $sql.="       ,ds_cpf_cnpj";
        $sql.="       ,ds_ie";
        $sql.="       ,ds_tel";
        $sql.="       ,ds_fax";
        $sql.="       ,ds_site";
        $sql.="       ,ds_email";
        $sql.="       ,supervisores_pk";
        $sql.="       ,responsavel_pk";
        $sql.="       ,segmentos_pk";
        $sql.="       ,date_format(dt_vencimento,'%d/%m/%Y')dt_vencimento";

        $sql.="  from leads ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_lead asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function relatorioEscalaDia($leads_pk,$colaborador_pk,$dt_ini){

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="       l.ds_lead,";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
        $sql.="       date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento,";
        $sql.="       col.ds_re,";
        $sql.="       col.ds_pin,";
        $sql.="       col.ds_colaborador,";
        $sql.="       ps.ds_produto_servico,";
        $sql.="       ci.periodo,";
        $sql.="       ci.n_qtde_dias_semana ";
       
        $sql.="  FROM leads l";
        $sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        $sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="       INNER JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.="       INNER JOIN contratos_itens ci ON c.pk = ci.contratos_pk";
        $sql.="       INNER JOIN agenda_colaborador_padrao agp ON ci.pk = agp.contratos_itens_pk";
        $sql.="       INNER JOIN colaboradores col ON agp.colaboradores_pk = col.pk";
        $sql.="       INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";        

        
        $sql.=" where 1=1 ";
 
        $sql.=" and pt.dt_hora_ponto >= '".DataYMD($dt_ini)." 00:00:00'";
        $sql.=" and pt.dt_hora_ponto <='".DataYMD($dt_ini)." 23:59:59'";
        
        if($leads_pk != ""){
            $sql.=" and ds_ponto = ".$leads_pk;
        }
        
        if($colaborador_pk != ""){
            $sql.=" and col.pk  = ".$colaborador_pk;
        }
        
        $sql.=" order by l.ds_lead asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }  
    public function listarColaboradoresEscala($leads_pk){

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="       l.ds_lead,";
        $sql.="       col.ds_re,";
        $sql.="       col.ds_pin,";
        $sql.="       col.ds_colaborador,";
        $sql.="       col.pk colaboradores_pk,";
        $sql.="       ps.ds_produto_servico,";
        $sql.="       ci.periodo,";
        $sql.="       ci.n_qtde_dias_semana ";
        $sql.="       ,l.ic_tipo_lead";
        $sql.="       ,l.leads_pai_pk";
       
        $sql.="  FROM leads l";
        $sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        $sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.="       INNER JOIN contratos c ON pe.pk = c.processos_etapas_pk";
        $sql.="       INNER JOIN contratos_itens ci ON c.pk = ci.contratos_pk";
        $sql.="       INNER JOIN agenda_colaborador_padrao agp ON ci.pk = agp.contratos_itens_pk";
        $sql.="       INNER JOIN colaboradores col ON agp.colaboradores_pk = col.pk";
        $sql.="       INNER JOIN produtos_servicos ps ON ci.produtos_servicos_pk = ps.pk";        

        
        $sql.=" where 1=1 ";
 
        
        if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk;
        }
        
        $sql.=" and col.ic_status=1 ";
        $sql.=" order by l.ds_lead asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }  
    public function listarLeadsComProcessos(){

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="       case WHEN l.ic_tipo_lead = 1   THEN concat(l.ds_lead,' - Cliente')
        ELSE 
        concat(l.ds_lead,' - Posto de Trabalho')
      END ds_lead";       
        $sql.="  FROM leads l";
        //$sql.="       INNER JOIN processos p ON l.pk = p.leads_pk";
        //$sql.="       INNER JOIN processos_etapas pe ON p.pk = pe.processos_pk";
        $sql.=" where 1=1 ";         
        $sql.=" group by l.pk";
        $sql.=" order by l.ds_lead asc ";
 
        $query = $this->db->execQuery($sql);
        return $query;

    }  
    
    
    public function listarPkSubMenu($pk){

        $sql ="";
        $sql.="select l.pk ";
        $sql.="       ,l.ds_lead ";

        $sql.="  from leads l ";
        $sql.=" where l.pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarEmpresaLead($pk){

        $sql ="";
        $sql.=" select ct.ds_razao_social,ct.ds_cpf_cnpj,ct.ds_endereco ";
        $sql.=" from contratos c ";
        $sql.="        inner join contas ct on c.empresas_pk = ct.pk";
        $sql.="        inner join processos_etapas pe on c.processos_etapas_pk = pe.pk";
        $sql.="        inner join processos p on pe.processos_pk = p.pk";
        $sql.="        where 1=1 ";
        $sql.="        and p.leads_pk = ".$pk;

        $sql.="        order by ct.ds_razao_social asc";
        $query = $this->db->execQuery($sql);
        return $query;

    }
        
    public function listarLeadsCombo($pk){

        $sql ="";
        $sql.="SELECT l.pk,";
        $sql.="       l.ds_lead";
        $sql.="  FROM leads l";
        $sql.=" where 1=1 "; 
        
        if($pk != ""){
            $sql.=" and l.pk = ".$pk;
        }
        $sql.=" Order by l.ds_lead";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    
    public function listarPostosTrabalhoMesaOperacional(){
        $sql = "";
        $sql .=" SELECT l.pk leads_pk,";
        $sql .="   l.ds_lead";
        $sql .="   FROM leads l";
        $sql .="  INNER JOIN agenda_colaborador_padrao a ON l.pk = a.leads_pk";
        $sql .="  WHERE 1 = 1 AND l.ic_cliente = 1 AND a.dt_cancelamento IS NULL";
        $sql.= " Group by l.pk";
        $sql.=" Order by l.ds_lead";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    //Novo
    public function listarTodosAtivos(){

            $sql ="";
            $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
            $sql.="       ,ds_lead ";
    
            $sql.="  from leads ";
            $sql.=" where (ic_cliente = 1 or ic_status=9)";
            $sql.=" order by ds_lead";
  
            $query = $this->db->execQuery($sql);
            return $query;
    
        }
        public function listarLeadsParaContrato($ds_lead,$ic_cliente,$supervisores_pk,$responsavel_pk,$ds_lead_grid,$ic_tipo_lead){

            $sql ="";
            $sql.="select l.pk, l.dt_cadastro, l.usuario_cadastro_pk, l.dt_ult_atualizacao, l.usuario_ult_atualizacao_pk ";
            $sql.="       ,case WHEN l.leads_pai_pk is null  THEN
                                 concat(l.ds_lead,' - CLIENTE') 
                            ELSE 
                                concat(ll.ds_lead,' - ',l.ds_lead,' Cód: ',l.pk,' - POSTO DE TRABALHO') 
                            END ds_lead";
            $sql.="       ,l.ds_endereco ";
            $sql.="       ,l.ds_numero ";
            $sql.="       ,l.ds_complemento ";
            $sql.="       ,l.ds_cep ";
            $sql.="       ,l.ds_bairro ";
            $sql.="       ,l.ds_cidade ";
            $sql.="       ,l.ds_uf ";
            $sql.="       ,case l.ic_cliente when 1 then 'Ativo' when 2 then 'Desativado' end ic_cliente ";
            $sql.="       ,l.ds_obs ";
            $sql.="       ,l.n_qtde_torres ";        
            $sql.="       ,l.ds_razao_social";
            $sql.="       ,l.ds_cpf_cnpj";
            $sql.="       ,l.ds_ie";
            $sql.="       ,l.ds_tel";
            $sql.="       ,l.ds_fax";
            $sql.="       ,l.ds_site";
            $sql.="       ,l.ds_email";
            $sql.="       ,l.supervisores_pk";
            $sql.="       ,l.responsavel_pk";
            $sql.="       ,l.segmentos_pk";
            $sql.="       ,l.ic_tipo_lead";
            $sql.="       ,case l.ic_tipo_lead when 1 then 'Cliente' when 2 then 'Posto de Trabalho' end ds_tipo_lead";
            $sql.="       ,l.leads_pai_pk";
            $sql.="       ,date_format(l.dt_vencimento,'%d/%m/%Y')dt_vencimento";
            $sql.="  from leads l ";
            $sql.="  left join leads ll on l.leads_pai_pk = ll.pk";
            $sql.=" where 1=1 ";
            $sql.=" and l.ic_cliente=1 ";
        
            $sql.=" order by ds_lead asc ";

            $query = $this->db->execQuery($sql);
            return $query;
    
        }

        public function listarLeadCombo($ds_lead){

            $sql ="";
            $sql.="select l.pk, l.ds_lead ";
            $sql.="  from leads l ";
            $sql.=" where 1=1 ";
            
            if($ds_lead != ""){
                $sql.=" and l.pk = ".$ds_lead;
            }
      
            $sql.=" order by ds_lead asc ";
            $query = $this->db->execQuery($sql);
            return $query;
    
        }

        public function relPosto_Colaborador($leads_pk,$colaborador_pk){

            $sql ="";
            $sql.="select";
            $sql.="     acp.pk"; 
            $sql.="     ,l.ds_lead";
            $sql.="     ,c.ds_colaborador";
            $sql.="     ,cri.n_qtde_dias_semana"; 
            $sql.="     ,ps.ds_produto_servico "; 
            $sql.="     ,date_format(acp.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda ";            
            $sql.="     ,date_format(acp.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda ";
            $sql.="     ,date_format(acp.dt_cancelamento,'%d/%m/%Y') dt_cancelamento "; 
            $sql.=" from agenda_colaborador_padrao acp ";
            $sql.="     inner join colaboradores c on acp.colaboradores_pk = c.pk ";
            $sql.="     inner join leads l on acp.leads_pk = l.pk ";
            $sql.="     left join contratos cr on acp.contratos_pk = cr.pk ";
            $sql.="     left join contratos_itens cri on cr.pk = cri.contratos_pk ";
            $sql.="     left join produtos_servicos ps on cri.produtos_servicos_pk  = ps.pk ";
            $sql.=" where 1=1";

            if(!empty($leads_pk)){
                $sql.=" And l.pk=".$leads_pk;
            }

            if(!empty($colaborador_pk)){
                $sql." And c.pk=".$colaborador_pk;
            }
            $sql.=" group by acp.pk "; 
            $sql.=" order by l.ds_lead";
                   
            $query = $this->db->execQuery($sql);
            return $query;
    
        }
    

}

?>
