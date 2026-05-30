<?

include_once '../inc/php/public.php';
include_once '../inc/classes/bestflow/DataBase.php';
include_once '../model/proposta.class.php';

class propostadao{

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
    
    public function salvar($proposta, $arrPropostaItens, $arrPropostaItensInfo){
        
        $fields = array();
        $fields['n_versao'] = $proposta->getn_versao();
        $fields['responsavel_pk'] = $this->arrToken['usuarios_pk'];
        $fields['vl_total'] = $proposta->getvl_total();
        $fields['vl_total_materiais'] = $proposta->getvl_total_materiais();
        $fields['ds_obs'] = $proposta->getds_obs();
        $fields['dt_envio'] = $proposta->getdt_envio();
        $fields['dt_previsao_fechamento'] = $proposta->getdt_previsao_fechamento();
        $fields['processos_etapas_pk'] = $proposta->getprocessos_etapas_pk();
        $fields['agendas_pk'] = $proposta->getagendas_pk();
        $fields['leads_pk'] = $proposta->getleads_pk();
        $fields['ds_obs_motivo_cancelamento'] = $proposta->getds_obs_motivo_cancelamento();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        
        $proposta->getdt_validade()!="" ? $fields['dt_validade'] = $proposta->getdt_validade() : $fields['dt_validade'] = "sysdate()";
        $proposta->getdt_cancelamento() == 1 ? $fields['dt_cancelamento'] = "sysdate()" : $fields['dt_cancelamento'] = " ";
        $proposta->getdt_fechamento() == 1 ? $fields['dt_fechamento'] = "sysdate()" : $fields['dt_fechamento'] = " ";
 
        if($proposta->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            
            $pk = $this->db->execInsert("propostas", $fields);
     
            if(count($arrPropostaItens) > 0){   
                for($i = 0; $i < count($arrPropostaItens); $i++){
                    $this->adicionarPropostaItens($arrPropostaItens[$i]['proposta_itens_pk'],$arrPropostaItens[$i]['n_qtde_dias_semana'],$pk, $arrPropostaItens[$i]['n_qtde'], $arrPropostaItens[$i]["vl_unit"], $arrPropostaItens[$i]["vl_total"], $arrPropostaItens[$i]["produtos_servicos_pk"]);
                }            
            }

            for($i = 0; $i < count($arrPropostaItensInfo); $i++){
                $this->salvarProdutosItens($pk,$arrPropostaItensInfo[$i]['categorias_produto_pk'],$arrPropostaItensInfo[$i]['produtos_pk'],$arrPropostaItensInfo[$i]['n_qtde_item'],$arrPropostaItensInfo[$i]['vl_item_produto'], $arrPropostaItensInfo[$i]['']);
            }
            
            return $pk;
        }  else{ 

            $this->db->execUpdate("propostas", $fields, " pk = ".$proposta->getpk());
      
            for($i = 0; $i < count($arrPropostaItens); $i++){
  
                $this->adicionarPropostaItens($arrPropostaItens[$i]['proposta_itens_pk'],$arrPropostaItens[$i]['n_qtde_dias_semana'],$proposta->getpk(), $arrPropostaItens[$i]['n_qtde'], $arrPropostaItens[$i]["vl_unit"], $arrPropostaItens[$i]["vl_total"], $arrPropostaItens[$i]["produtos_servicos_pk"]);
            }       

            $this->excluirProdutosItens($proposta->getpk());
            for($i = 0; $i < count($arrPropostaItensInfo); $i++){                
                $this->salvarProdutosItens($proposta->getpk(),$arrPropostaItensInfo[$i]['categorias_produto_pk'],$arrPropostaItensInfo[$i]['produtos_pk'],$arrPropostaItensInfo[$i]['n_qtde_item'],$arrPropostaItensInfo[$i]['vl_item_produto'], $arrPropostaItensInfo[$i]['vl_total_produto']);
            }
      
        }

    }

    public function excluir($proposta){
        //deleta itens proposta
        $this->db->execDelete("propostas_itens"," propostas_pk = ".$proposta->getpk());

        $this->db->execDelete("propostas"," pk = ".$proposta->getpk());
    }

    public function carregarPorPk($pk){

        $proposta = new proposta();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        //$sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where pk = $pk ";
  
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $proposta->setpk($query[$i]["pk"]);
                $proposta->setdt_cadastro($query[$i]["dt_cadastro"]);
                $proposta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $proposta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $proposta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
                $proposta->setn_versao($query[$i]['n_versao']);
                $proposta->setresponsavel_pk($query[$i]['responsavel_pk']);
                $proposta->setvl_total($query[$i]['vl_total']);
                $proposta->setds_obs($query[$i]['ds_obs']);
                $proposta->setdt_validade($query[$i]['dt_validade']);
                $proposta->setdt_envio($query[$i]['dt_envio']);
                $proposta->setdt_previsao_fechamento($query[$i]['dt_previsao_fechamento']);
                $proposta->setdt_fechamento($query[$i]['dt_fechamento']);
                $proposta->setdt_cancelamento($query[$i]['dt_cancelamento']);
                $proposta->setds_obs_motivo_cancelamento($query[$i]['ds_obs_motivo_cancelamento']);
                $proposta->setprocessos_etapas_pk($query[$i]['processos_etapas_pk']);
                $proposta->setagendas_pk($query[$i]['agendas_pk']);
                //$proposta->setoperador_pk($query[$i]['operador_pk']);

            }
        }
        return $proposta;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        //$sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where pk = $pk ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_rel_funil_vendas($leads_pk,$responsavel_pk,$dt_envio_ini,$dt_envio_fim,$dt_prev_fechamento_ini,$dt_prev_fechamento_fim,$dt_fechamento_ini,$dt_fechamento_fim,$grupos_pk){

        $sql ="";
        $sql.=" SELECT  l.ds_lead,";
        $sql.="         pe.processos_pk,";
        $sql.="         ps.classificacao_processo_pk,";
        $sql.="         case ps.classificacao_processo_pk when 1 then '25%' when 2 then '50%' when 3 then '75%' when 4 then 'Cliente' end ds_classficacao_processo,";
        $sql.="         SUM(pi.n_qtde) n_qtde,";
        $sql.="         p.vl_total,";
        //$sql.="         p.operador_pk,";
        $sql.="         date_format(p.dt_envio,'%d-%m-%Y')dt_envio,";
        $sql.="         date_format(p.dt_cancelamento,'%d-%m-%Y')dt_cancelamento,";
        $sql.="         date_format(p.dt_fechamento,'%d-%m-%Y')dt_fechamento,";
        $sql.="         date_format(p.dt_previsao_fechamento,'%d-%m-%Y')dt_previsao_fechamento,";
        $sql.="         date_format(p.dt_validade,'%d-%m-%Y')dt_validade,";
        $sql.="         (u.ds_usuario)ds_responsavel,";
        $sql.="         date_format(p.dt_cadastro,'%d-%m-%Y')dt_cadastro";
        $sql.="    FROM propostas p";
        $sql.="         INNER JOIN propostas_itens pi ON p.pk = pi.propostas_pk";
        $sql.="         INNER JOIN processos_etapas pe ON p.processos_etapas_pk = pe.pk";
        $sql.="         INNER JOIN processos ps ON pe.processos_pk = ps.pk";
        $sql.="         INNER JOIN leads l ON p.leads_pk = l.pk";
        $sql.="         inner join usuarios u on p.responsavel_pk = u.pk ";
        $sql.="   where 1 = 1";
        if($leads_pk!=""){
            $sql.=" and l.pk = ".$leads_pk;
        }
        if($responsavel_pk!=""){
            $sql.=" and u.pk = ".$responsavel_pk;
        }
        if($grupos_pk!=""){
            $sql.=" and u.grupos_pk = ".$grupos_pk;
        }
        if($dt_envio_ini!=""){
            $sql.=" and date_format(p.dt_envio,'%Y-%m-%d') >= '".DataYMD($dt_envio_ini)." '";
        }
        if($dt_envio_fim!=""){
            $sql.=" and date_format(p.dt_envio,'%Y-%m-%d') <= '".DataYMD($dt_envio_fim)." '";
        }
        if($dt_prev_fechamento_ini!=""){
            $sql.=" and date_format(p.dt_previsao_fechamento,'%Y-%m-%d') >= '".DataYMD($dt_prev_fechamento_ini)." '";
        }
        if($dt_prev_fechamento_fim!=""){
            $sql.=" and date_format(p.dt_previsao_fechamento,'%Y-%m-%d') <= '".DataYMD($dt_prev_fechamento_fim)." '";
        }
        if($dt_fechamento_ini!=""){
            $sql.=" and date_format(p.dt_fechamento,'%Y-%m-%d') >= '".DataYMD($dt_fechamento_ini)." '";
        }
        if($dt_fechamento_fim!=""){
            $sql.=" and date_format(p.dt_fechamento,'%Y-%m-%d') <= '".DataYMD($dt_fechamento_fim)." '";
        }
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_dt_inicio(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,dt_fim ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
        //$sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_envio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,n_versao ";
        $sql.="       ,responsavel_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,ds_obs ";
        $sql.="       ,dt_validade ";
        $sql.="       ,dt_envio ";
        $sql.="       ,dt_previsao_fechamento ";
        $sql.="       ,dt_fechamento ";
        $sql.="       ,dt_cancelamento ";
        $sql.="       ,ds_obs_motivo_cancelamento ";
        $sql.="       ,processos_etapas_pk ";
        $sql.="       ,agendas_pk ";
       // $sql.="       ,operador_pk ";

        $sql.="  from propostas ";
        $sql.=" where 1=1 ";
        $sql.=" order by dt_envio asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listar_proposta_lead_processo($leads_pk,$processos_pk){

        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.n_versao";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y %H:%i') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";
        $sql.="    ,date_format(p.dt_previsao_fechamento, '%d/%m/%Y') dt_previsao_fechamento";
        $sql.="    ,date_format(p.dt_fechamento, '%d/%m/%Y ') dt_fechamento";        
        $sql.="    ,date_format(p.dt_cancelamento, '%d/%m/%Y ') dt_cancelamento";        
        $sql.="    ,p.vl_total";
        $sql.="    ,p.vl_total_materiais";
        $sql.="    ,p.ds_obs_motivo_cancelamento";
        $sql.="    ,p.ds_obs";
        $sql.="    ,p.responsavel_pk";
        $sql.="    ,p.leads_pk";
        $sql.="    ,c.ds_contato";
        $sql.="    ,c.ds_email ds_email_contato";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    left join contatos c on p.leads_pk = c.leads_pk";
        $sql.=" where 1=1 ";
        if($leads_pk!=""){
            $sql.=" and pr.leads_pk=".$leads_pk;
        }
        if($processos_pk!=""){
            $sql.=" and pr.pk=".$processos_pk;
        }
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";       
     

        $query = $this->db->execQuery($sql);

        $result = [];
        $vl_total_item ="";
        for($i=0; $i<count($query);$i++){  
            $vl_total_item  = $query[$i]['vl_total'] + $query[$i]['vl_total_materiais'];

            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_responsavel"=>$query[$i]['ds_responsavel'],
                "responsavel_pk"=>$query[$i]['responsavel_pk'],
                "n_versao"=>$query[$i]['n_versao'],
                "dt_cad"=>$query[$i]['dt_cad'],
                "dt_validade"=>$query[$i]['dt_validade'],
                "dt_envio"=>$query[$i]['dt_envio'],
                "dt_previsao_fechamento"=>$query[$i]['dt_previsao_fechamento'],
                "dt_fechamento"=>$query[$i]['dt_fechamento'],
                "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                "ds_obs_motivo_cancelamento"=>$query[$i]['ds_obs_motivo_cancelamento'],
                "ds_obs"=>$query[$i]['ds_obs'],
                "ds_contato"=>$query[$i]['ds_contato'],
                "leads_pk"=>$query[$i]['leads_pk'],
                "ds_email_contato"=>$query[$i]['ds_email_contato'],
                "vl_total"=>number_format($vl_total_item ,2,',','.')
            );
        }
        return $result;

    }
    public function listar_proposta_lead_processo_dashboard($token){

        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.n_versao";
        $sql.="    ,p.leads_pk";
        $sql.="    ,pr.pk processos_pk";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y %H:%i') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";
        $sql.="    ,date_format(p.dt_previsao_fechamento, '%d/%m/%Y') dt_previsao_fechamento";
        $sql.="    ,date_format(p.dt_fechamento, '%d/%m/%Y ') dt_fechamento";        
        $sql.="    ,p.vl_total";
        $sql.="    ,p.ds_obs";
        //$sql.="    ,p.operador_pk";
        $sql.="    ,l.ds_lead";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        if(!permissao("meu_gepros_listar", "cons", $token)){
            $sql.=" and p.responsavel_pk = ".$this->arrToken['usuarios_pk'];
        }
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";       
     

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function adicionarPropostaItens($propostas_itens_pk,$n_qtde_dias_semana,$propostas_pk, $n_qtde, $vl_unit, $vl_total, $produtos_servicos_pk){   

        $fields = array();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields['propostas_pk'] = $propostas_pk;
        $fields['n_qtde'] = $n_qtde;
        $fields['vl_unit'] = $vl_unit;
        $fields['vl_total'] = $vl_total;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
        $fields['n_qtde_dias_semana'] = $n_qtde_dias_semana;
        
        if($propostas_itens_pk  == ""){            
            $this->db->execInsert("propostas_itens", $fields);            
        }else{           
            $this->db->execUpdate("propostas_itens", $fields, " pk = ".$propostas_itens_pk);                         
        }  
        
    }
    public function excluirItemPropostaPk($pk){
        $this->db->execDelete("propostas_itens"," propostas_pk = ".$pk);
        
    }

    public function listarDadosImpressaoProposta($pk){
        $sql ="";
        $sql.="SELECT p.pk ,p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk";
        $sql.="    ,p.leads_pk";
        $sql.="    ,pr.pk processos_pk";
        $sql.="    ,u.ds_usuario ds_responsavel";
        $sql.="    ,date_format(p.dt_cadastro, '%d/%m/%Y') dt_cad";
        $sql.="    ,date_format(p.dt_validade, '%d/%m/%Y') dt_validade";
        $sql.="    ,date_format(p.dt_envio, '%d/%m/%Y') dt_envio";     
        $sql.="    ,p.vl_total";
        $sql.="    ,p.vl_total_materiais";
        $sql.="    ,p.ds_obs";
        $sql.="    ,l.ds_lead";
        $sql.="    ,l.ds_endereco";
        $sql.="    ,l.ds_cidade";
        $sql.="    ,l.ds_tel";
        $sql.="    ,l.ds_cep";
        $sql.="    ,l.ds_cpf_cnpj";
        $sql.="    ,l.ds_uf";
        $sql.="    ,l.ds_email";
        $sql.=" FROM propostas p";
        $sql.="    LEFT JOIN propostas_itens pri ON pri.propostas_pk = p.pk";
        $sql.="    INNER JOIN processos_etapas pe ON pe.pk = p.processos_etapas_pk";
        $sql.="    INNER JOIN processos pr ON pr.pk = pe.processos_pk";
        $sql.="    INNER JOIN usuarios u on u.pk = p.responsavel_pk";
        $sql.="    INNER JOIN leads l on l.pk = p.leads_pk";
        $sql.=" where 1=1 ";
        $sql.=" and p.pk = ".$pk;
        $sql.="  group by p.pk ";
        $sql.=" order by p.pk asc ";  

        $query = $this->db->execQuery($sql);
        for($i=0; $i<count($query);$i++){  
            $vl_total_item  = $query[$i]['vl_total'] + $query[$i]['vl_total_materiais'];

            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_responsavel"=>$query[$i]['ds_responsavel'],
                "dt_cad"=>$query[$i]['dt_cad'],
                "dt_validade"=>$query[$i]['dt_validade'],
                "dt_envio"=>$query[$i]['dt_envio'],
                "vl_total"=>number_format($vl_total_item ,2,',','.'),
                "ds_obs"=>$query[$i]['ds_obs'],
                "ds_lead"=>$query[$i]['ds_lead'],
                "leads_pk"=>$query[$i]['leads_pk'],
                "ds_endereco"=>$query[$i]['ds_endereco'],
                "ds_cidade"=>$query[$i]['ds_cidade'],
                "ds_tel"=>$query[$i]['ds_tel'],
                "ds_cep"=>$query[$i]['ds_cep'],
                "ds_cpf_cnpj"=>$query[$i]['ds_cpf_cnpj'],
                "ds_uf"=>$query[$i]['ds_uf'],
                "ds_email"=>$query[$i]['ds_email']
            );
        }

        return $result;   
        
    }

    public function salvarProdutosItens($pk,$categorias_produto_pk,$produtos_pk,$n_qtde_item,$vl_item_produto, $vl_total_produto){
     
        $fields = array();
        $fields['propostas_pk'] = $pk;
        $fields['categorias_produto_pk'] = $categorias_produto_pk;
        $fields['produtos_pk'] = $produtos_pk;
        $fields['n_qtde_item'] = $n_qtde_item;
        $fields['vl_item_produto'] = $vl_item_produto;
        $fields['vl_total_produto'] =  moeda2float($vl_total_produto);

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("propostas_produtos_itens", $fields);
       
    }

    public function excluirProdutosItens($propostas_pk){        
        $this->db->execDelete("propostas_produtos_itens"," propostas_pk = ".$propostas_pk);
    }

    public function listarProdutosItens($pk){

        $sql ="";
        $sql.=" SELECT cpi.pk,";
        $sql.="        cp.ds_categoria,";
        $sql.="        cpi.categorias_produto_pk,";
        $sql.="        cpi.produtos_pk,";
        $sql.="        p.ds_produto,";
        $sql.="        cpi.n_qtde_item,";
        $sql.="        cpi.vl_item_produto,";
        $sql.="        cpi.propostas_pk,";
        $sql.="        cpi.vl_total_produto";
        $sql.=" FROM propostas_produtos_itens cpi";
        $sql.="      LEFT JOIN categorias_produto cp ON cpi.categorias_produto_pk = cp.pk";
        $sql.="      LEFT JOIN produtos p ON cpi.produtos_pk = p.pk";          
        $sql.=" WHERE cpi.propostas_pk =".$pk;       
        $sql.=" ORDER BY cpi.pk";
   
        $query = $this->db->execQuery($sql);
        $result = [];
        $qtde_total_itens ="";
        $vl_total_itens ="";

        for($i=0; $i<count($query);$i++){
            $qtde_total_itens += $query[$i]['n_qtde_item'];
            $vl_total_itens += ($query[$i]['vl_item_produto'] * $query[$i]['n_qtde_item']);
        }

        for($i=0; $i<count($query);$i++){  
            $vl_total_item  = ($query[$i]['n_qtde_item'] * $query[$i]['vl_item_produto']);

            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_categoria"=>$query[$i]['ds_categoria'],
                "categorias_produto_pk"=>$query[$i]['categorias_produto_pk'],
                "produtos_pk"=>$query[$i]['produtos_pk'],
                "ds_produto"=>$query[$i]['ds_produto'],
                "n_qtde_item"=>$query[$i]['n_qtde_item'],
                "qtde_total_itens"=>$qtde_total_itens,
                "vl_total_item"=>number_format($vl_total_item ,2,',','.'),
                "vl_total_itens"=>number_format($vl_total_itens ,2,',','.'),
                "vl_item_produto"=> number_format($query[$i]['vl_item_produto'] ,2,',','.'),  
                "vl_total_produto"=> number_format($query[$i]['vl_total_produto'] ,2,',','.')  
            );
        }
        return $result;

    }
}

?>
