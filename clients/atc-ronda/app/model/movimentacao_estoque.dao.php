<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/movimentacao_estoque.class.php';


class movimentacao_estoquedao{

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
    
    public function salvar($movimentacao_estoque){


        $fields = array();
        $fields['leads_pk'] = $movimentacao_estoque->getleads_pk();
        $fields['colaborador_pk'] = $movimentacao_estoque->getcolaborador_pk();
        $fields['produtos_itens_pk'] = $movimentacao_estoque->getprodutos_itens_pk();
        $fields['qtde'] = $movimentacao_estoque->getqtde();
        $fields['dt_entrega'] = $movimentacao_estoque->getdt_entrega();        
        $fields['obs_movimentacao'] = $movimentacao_estoque->getobs_movimentacao();
        $fields['conjunto_material_pk'] = $movimentacao_estoque->getconjunto_material_pk();
        $fields['ic_mateiral_carga'] = $movimentacao_estoque->getic_mateiral_carga();
        $fields['polos_destino_pk'] = $movimentacao_estoque->getpolos_destino_pk();
        $fields['polos_origem_pk'] = $movimentacao_estoque->getpolos_origem_pk();
        $fields['grupo_para_movimentacao_pk'] = $movimentacao_estoque->getgrupo_para_movimentacao_pk();
        $fields['contratos_pk'] = $movimentacao_estoque->getcontratos_pk();
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($movimentacao_estoque->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            $pk = $this->db->execInsert("movimentacao_estoque", $fields);
            
            return $pk;
        }
        else{
            $fields['dt_devolucao'] = $movimentacao_estoque->getdt_devolucao();
            return $this->db->execUpdate("movimentacao_estoque", $fields, " pk = ".$movimentacao_estoque->getpk());
        }
    }

    public function excluir($movimentacao_estoque){
        $this->db->execDelete("movimentacao_estoque"," pk = ".$movimentacao_estoque->getpk());
    }
    public function excluirLead($leads_pk){
        $this->db->execDelete("movimentacao_estoque"," leads_pk = ".$leads_pk);
    }
    public function excluirMovimentacaoColaboradoresPk($colaborador_pk){
        $this->db->execDelete("movimentacao_estoque"," colaborador_pk = ".$colaborador_pk);
    }

    public function carregarPorPk($pk){

        $movimentacao_estoque = new movimentacao_estoque();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,produtos_itens_pk ";
        $sql.="       ,qtde ";
        $sql.="       ,obs_movimentacao ";
        $sql.="       ,conjunto_material_pk";
        $sql.="       ,ic_mateiral_carga";


        $sql.="  from movimentacao_estoque ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $movimentacao_estoque->setpk($query[$i]["pk"]);
                $movimentacao_estoque->setdt_cadastro($query[$i]["dt_cadastro"]);
                $movimentacao_estoque->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $movimentacao_estoque->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $movimentacao_estoque->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $movimentacao_estoque->setleads_pk($query[$i]['leads_pk']);
                $movimentacao_estoque->setcolaborador_pk($query[$i]['colaborador_pk']);
                $movimentacao_estoque->setprodutos_itens_pk($query[$i]['produtos_itens_pk']);
                $movimentacao_estoque->setqtde($query[$i]['qtde']);
                $movimentacao_estoque->setobs_movimentacao($query[$i]['obs_movimentacao']);
                $movimentacao_estoque->setconjunto_material_pk($query[$i]['conjunto_material_pk']);

            }
        }
        return $movimentacao_estoque;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,produtos_itens_pk ";
        $sql.="       ,qtde ";
        $sql.="       ,obs_movimentacao ";
        $sql.="       ,conjunto_material_pk";
        $sql.="       ,ic_mateiral_carga";

        $sql.="  from movimentacao_estoque ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarMovimentacoes($leads_pk,$catetoria_pk,$produtos_pk,$dt_ini,$dt_fim){

        $sql ="";
        $sql.="select me.pk";
        $sql.="       ,me.dt_cadastro";
        $sql.="       ,me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk  ";
        $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
        $sql.="       ,me.leads_pk ";
        $sql.="       ,me.colaborador_pk ";
        $sql.="       ,me.produtos_itens_pk ";
        $sql.="       ,me.qtde ";
        $sql.="       ,me.obs_movimentacao ";
        $sql.="       ,me.conjunto_material_pk";
        $sql.="       ,me.ic_mateiral_carga";
        $sql.="       ,l.ds_lead";
        $sql.="       ,cp.ds_categoria";
        $sql.="       ,p.ds_produto";
        $sql.="       ,u.ds_usuario";
        $sql.="  from movimentacao_estoque me ";
        $sql.="     INNER JOIN leads l on me.leads_pk = l.pk";
        $sql.="     INNER JOIN usuarios u on me.usuario_cadastro_pk = u.pk";
        $sql.="     LEFT JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="     LEFT JOIN produtos p on p.pk = pi.produtos_pk";        
        $sql.="     LEFT JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk "; 
        $sql.=" where 1=1 ";
        
        if($leads_pk != ""){
            $sql.=" and me.leads_pk = ".$leads_pk;
        }
        if($catetoria_pk != ""){
            $sql.=" and cp.pk = ".$catetoria_pk;
        }
        if($produtos_pk != ""){
            $sql.=" and p.pk = ".$produtos_pk;
        }   
        
        if($dt_ini != ""){
                $sql.=" and me.dt_entrega between '".DataYMD($dt_ini)."' and '".DataYMD($dt_fim)."'";
        }

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioEstoqueCarga($leads_pk,$catetoria_pk,$produtos_pk,$dt_ini,$dt_fim){

        $sql ="";
        $sql.="select me.pk";
        $sql.="       ,date_format(me.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="       ,l.ds_lead";
        $sql.="       ,cp.ds_categoria";
        $sql.="       ,CONCAT(pi.pk, ' - ', p.ds_produto) ds_produto";
        $sql.="       ,u.ds_usuario";
        $sql.="  from movimentacao_estoque me ";
        $sql.="     INNER JOIN leads l on me.leads_pk = l.pk";
        $sql.="     INNER JOIN usuarios u on me.usuario_cadastro_pk = u.pk";
        $sql.="     LEFT JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="     LEFT JOIN produtos p on p.pk = pi.produtos_pk";        
        $sql.="     LEFT JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk "; 
        $sql.=" where 1=1 ";
        
        if($leads_pk != ""){
            $sql.=" and me.leads_pk = ".$leads_pk;
        }
        if($catetoria_pk != ""){
            $sql.=" and cp.pk = ".$catetoria_pk;
        }
        if($produtos_pk != ""){
            $sql.=" and p.pk = ".$produtos_pk;
        }   
        
        if($dt_ini != ""){
                $sql.=" and me.dt_cadastro between '".DataYMD($dt_ini)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59' ";
        }
        $sql.=" and me.ic_mateiral_carga = 1";
        $sql.=" order by me.dt_cadastro, l.ds_lead";
  
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioEstoqueCargaSintetico($leads_pk,$catetoria_pk,$produtos_pk,$dt_ini,$dt_fim){

        $sql ="";
        $sql.="select me.pk";
        $sql.="       ,date_format(me.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="       ,l.ds_lead";
        $sql.="       ,cp.ds_categoria";
        
        $sql.="       ,CONCAT(p.ds_produto) ds_produto";
        $sql.="       ,count(p.ds_produto)qtde";
        $sql.="  from movimentacao_estoque me ";
        $sql.="     INNER JOIN leads l on me.leads_pk = l.pk";
        $sql.="     INNER JOIN usuarios u on me.usuario_cadastro_pk = u.pk";
        $sql.="     LEFT JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="     LEFT JOIN produtos p on p.pk = pi.produtos_pk";        
        $sql.="     LEFT JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk "; 
        $sql.=" where 1=1 ";
        
        if($leads_pk != ""){
            $sql.=" and me.leads_pk = ".$leads_pk;
        }
        if($catetoria_pk != ""){
            $sql.=" and cp.pk = ".$catetoria_pk;
        }
        if($produtos_pk != ""){
            $sql.=" and p.pk = ".$produtos_pk;
        }   
        
        if($dt_ini != ""){
                $sql.=" and me.dt_cadastro between '".DataYMD($dt_ini)." 00:00:00' and '".DataYMD($dt_fim)." 23:59:59' ";
        }
        $sql.=" and me.ic_mateiral_carga = 1";
        $sql.=" group by p.ds_produto, l.ds_lead";
        $sql.=" order by me.dt_cadastro, l.ds_lead";
  
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    public function listar_por_pk($leads_pk,$colaborador_pk,$conjunto_material_pk,$contratos_pk){
        //if($leads_pk!="" || $colaborador_pk !=""){
            $sql ="";
            $sql.="select me.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
            $sql.="       ,me.leads_pk ";
            $sql.="       ,me.colaborador_pk ";
            $sql.="       ,me.produtos_itens_pk ";
            $sql.="       ,me.qtde ";
            $sql.="       ,me.obs_movimentacao obs_material ";
            $sql.="       ,me.conjunto_material_pk";
            $sql.="       ,me.ic_mateiral_carga";
            $sql.="       ,case me.ic_mateiral_carga when 1 then 'Sim' when 2 then 'Não' end ds_ic_mateiral_carga";
            $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
            $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
            $sql.="       ,p.ds_produto ";
            $sql.="       ,p.pk produtos_pk ";
            $sql.="       ,cp.pk categorias_produto_pk ";
            $sql.="       ,cp.ds_categoria ds_categorias_produto";
            $sql.="       ,pi.pk produtos_itens_pk ";
            $sql.="       ,pi.ds_n_serie ";
            $sql.="  from movimentacao_estoque me ";
            $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
            $sql.="     INNER JOIN produtos p on p.pk = pi.produtos_pk";        
            $sql.="     INNER JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";        
            $sql.=" where 1=1 ";        
            if($leads_pk != ""){
                $sql.=" and me.leads_pk = ".$leads_pk;
            }
            if($colaborador_pk != ""){
                $sql.=" and me.colaborador_pk = ".$colaborador_pk;
            }
            if($contratos_pk != ""){
                $sql.=" and me.contratos_pk = ".$contratos_pk;
            }
            if($conjunto_material_pk != ""){
                $sql.=" and me.conjunto_material_pk = ".$conjunto_material_pk;
            }
            $sql.=" order by me.leads_pk desc ";
            
            $query = $this->db->execQuery($sql);
            
        //}
 
        
        
        return $query;

    }
    public function listarEstoqueBaixa($leads_pk,$categorias_pk,$produtos_pk,$dt_inicio,$dt_fim,$ic_status){
        if($leads_pk!="" ){
            $sql ="";
            $sql.="select pi.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
            $sql.="       ,me.leads_pk ";
            $sql.="       ,me.colaborador_pk ";
            $sql.="       ,me.produtos_itens_pk ";
            $sql.="       ,me.qtde ";
            $sql.="       ,me.obs_movimentacao obs_material ";
            $sql.="       ,me.ic_mateiral_carga";
            $sql.="       ,me.conjunto_material_pk";
            $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
            $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
            $sql.="       ,p.ds_produto ";
            $sql.="       ,p.pk produtos_pk ";
            $sql.="       ,cp.pk categorias_produto_pk ";
            $sql.="       ,cp.ds_categoria ds_categorias_produto";
            $sql.="       ,pi.pk produtos_itens_pk ";
            $sql.="       ,pi.ds_n_serie ";
            $sql.="       ,pi.obs_baixa";
            $sql.="       ,date_format(pi.dt_baixa,'%d/%m/%Y') dt_baixa ";
            $sql.="       ,l.ds_lead";
            $sql.="  from movimentacao_estoque me ";
            $sql.="     INNER JOIN leads l ON me.leads_pk = l.pk";
            $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
            $sql.="     INNER JOIN produtos p on p.pk = pi.produtos_pk";        
            $sql.="     INNER JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";        
            $sql.=" where 1=1 ";        
            if($leads_pk != ""){
                $sql.=" and me.leads_pk = ".$leads_pk;
            }
            if($categorias_pk != ""){
                $sql.=" and cp.pk = ".$categorias_pk;
            }
            if($produtos_pk != ""){
                $sql.=" and p.pk = ".$produtos_pk;
            }
            if($dt_inicio != ""){
                $sql.=" and me.dt_entrega = '".DataYMD($dt_inicio)."'";
            }
            if($dt_fim != ""){
                $sql.=" and me.dt_devolucao = '".DataYMD($dt_fim)."'";
            }
            if($ic_status!=""){
                if($ic_status==1){
                    $sql.=" and pi.dt_baixa is not null";
                }
                else if($ic_status==2){
                    $sql.=" and pi.dt_baixa is null";
                }
            }
            
            $sql.=" order by p.ds_produto asc ";
            
            
            $query = $this->db->execQuery($sql);
            
        }
 
        
        
        return $query;

    }
    public function relatorioMovimentacaoEstoqueTroca($leads_pk,$colaboradores_pk,$produtos_pk,$categorias_pk,$dt_troca_ini,$dt_troca_fim){
            $sql ="";
            $sql.="select me.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
            $sql.="       ,me.leads_pk ";
            $sql.="       ,me.colaborador_pk ";
            $sql.="       ,me.produtos_itens_pk ";
            $sql.="       ,me.qtde ";
            $sql.="       ,me.ic_mateiral_carga";
            $sql.="       ,me.obs_movimentacao obs_material ";
            $sql.="       ,me.conjunto_material_pk";
            $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
            $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
            $sql.="       ,p.ds_produto ";
            $sql.="       ,p.pk produtos_pk ";
            $sql.="       ,cp.pk categorias_produto_pk ";
            $sql.="       ,cp.ds_categoria ds_categorias_produto";
            $sql.="       ,pi.pk produtos_itens_pk ";
            $sql.="       ,pi.ds_n_serie ";
            $sql.="       ,p.ic_tempo_troca";
        
                $sql.="       ,l.ds_lead";
          
               $sql.="       ,c.ds_colaborador";
            
            
            $sql.="  from movimentacao_estoque me ";
            $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
            $sql.="     left JOIN produtos p on p.pk = pi.produtos_pk";        
            $sql.="     left JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";  
           
                 $sql.="     left JOIN leads l on me.leads_pk = l.pk ";    
            
                 $sql.="     left JOIN colaboradores c on me.colaborador_pk = c.pk ";    
            
              
            $sql.=" where 1=1 ";        
            if($leads_pk != ""){
                $sql.=" and me.leads_pk = ".$leads_pk;
            }
            if($colaboradores_pk != ""){
                $sql.=" and me.colaborador_pk = ".$colaboradores_pk;
            }
            if($produtos_pk != ""){
                $sql.=" and p.pk = ".$produtos_pk;
            }
            if($categorias_pk != ""){
                $sql.=" and cp.pk = ".$categorias_pk;
            }
            if($dt_troca_ini != ""){
                $sql.=" and me.dt_entrega between '".DataYMD($dt_troca_ini)."' and '".DataYMD($dt_troca_fim)."'";
            }
            //$sql.=" and p.ic_tempo_troca is not null";
            $sql.=" order by me.leads_pk desc ";
           
            
            $query = $this->db->execQuery($sql);
            
 
        
        
        return $query;

    }
    
    public function relatorioMovimentacaoEstoqueProduto($leads_pk,$dt_troca_ini,$dt_troca_fim){
            
            $sql ="";
            $sql.="select me.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
            $sql.="       ,me.leads_pk ";
            $sql.="       ,me.colaborador_pk ";
            $sql.="       ,me.produtos_itens_pk ";
            $sql.="       ,me.qtde ";
            $sql.="       ,me.ic_mateiral_carga";
            $sql.="       ,me.obs_movimentacao obs_material ";
            $sql.="       ,me.conjunto_material_pk";
            $sql.="       ,me.qtde";
            $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
            $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
            $sql.="       ,date_format(me.dt_cadastro, '%d/%m/%Y') AS dt_cadastro ";
            $sql.="       ,p.ds_produto ";
            $sql.="       ,p.pk produtos_pk ";
            $sql.="       ,cp.pk categorias_produto_pk ";
            $sql.="       ,cp.ds_categoria ds_categorias_produto";
            $sql.="       ,pi.pk produtos_itens_pk ";
            $sql.="       ,p.tipo_unidade_pk";
            $sql.="       ,pi.ds_n_serie ";
            $sql.="       ,pi.vl_item "; 
            $sql.="       ,p.ic_tempo_troca";
            $sql.="       ,l.ds_lead";
            $sql.="       ,c.ds_colaborador";

            $sql.="  from movimentacao_estoque me ";
            $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
            $sql.="     left JOIN produtos p on p.pk = pi.produtos_pk";        
            $sql.="     left JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";  
            $sql.="     left JOIN leads l on me.leads_pk = l.pk ";    
            $sql.="     left JOIN colaboradores c on me.colaborador_pk = c.pk ";    
            
            
            $sql.=" where 1=1 ";        
            if($leads_pk != ""){
                $sql.=" and me.leads_pk = ".$leads_pk;
            }

            if($dt_troca_ini != ""){
                $sql.=" and me.dt_entrega between '".DataYMD($dt_troca_ini)."' and '".DataYMD($dt_troca_fim)."'";
            }
            //$sql.=" and p.ic_tempo_troca is not null";
            $sql.=" order by me.leads_pk desc ";
            
            $query = $this->db->execQuery($sql);
            
        return $query;

    }
    public function relatorioMovimentacaoEstoqueCustoMedio($produtos_pk,$dt_troca_ini,$dt_troca_fim){
            
        $sql ="";
        $sql.="select me.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
        $sql.="       ,me.leads_pk ";
        $sql.="       ,me.colaborador_pk ";
        $sql.="       ,me.produtos_itens_pk ";
        $sql.="       ,me.qtde ";
        $sql.="       ,me.ic_mateiral_carga";
        $sql.="       ,me.obs_movimentacao obs_material ";
        $sql.="       ,me.conjunto_material_pk";
        $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
        $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
        $sql.="       ,date_format(me.dt_cadastro, '%d/%m/%Y') AS dt_cadastro ";
        $sql.="       ,p.ds_produto "; //1
        $sql.="       ,p.pk produtos_pk ";
        $sql.="       ,cp.pk categorias_produto_pk ";
        $sql.="       ,cp.ds_categoria ds_categorias_produto";
        $sql.="       ,pi.pk produtos_itens_pk ";
        $sql.="       ,case p.tipo_unidade_pk when 1 then 'Caixa' when 2 then 'Par' when 3 then 'Unidade' when 4 then 'Conjunto' when 5 then 'Fardo' when 6 then 'Bloco' end ds_tipo_unidade"; //3
        $sql.="       ,pi.ds_n_serie ";//2
        //$sql.="       ,ee.ds_n_ordem ";
        $sql.="       ,pi.vl_item "; 
        $sql.="       ,p.ic_tempo_troca";
        $sql.="       ,l.ds_lead";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,ee.qtde AS qtde_inicial";//5 
        $sql.="       ,ee.vl_unitario";//5 
        $sql.="       ,pi.qtde AS qtde_produtos_itens";

        $sql.="  from movimentacao_estoque me ";
        $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="     left JOIN produtos p on p.pk = pi.produtos_pk";        
        $sql.="     left JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";  
        $sql.="     left JOIN leads l on me.leads_pk = l.pk ";    
        $sql.="     left JOIN colaboradores c on me.colaborador_pk = c.pk ";    
        $sql.="     left JOIN entrada_estoque ee ON ee.produtos_pk = p.pk ";   
        
        
        $sql.=" where 1=1 ";        
        if($produtos_pk != ""){
            $sql.=" and pi.produtos_pk = ".$produtos_pk;
        }

        if($dt_troca_ini != ""){
            $sql.=" and me.dt_entrega between '".DataYMD($dt_troca_ini)."' and '".DataYMD($dt_troca_fim)."'";
        }
        //$sql.=" and p.ic_tempo_troca is not null";
        $sql.=" order by me.leads_pk desc ";
        
        $query = $this->db->execQuery($sql);
        
        return $query;

    }
    
    public function calcularDataTroca($ic_tempo_troca,$dt_movimentado){
        $sql="";
        $sql.=" select date_format(date_add('".DataYMD($dt_movimentado)."', interval ".$ic_tempo_troca." month),'%d/%m/%Y')dt_troca,date_add('".DataYMD($dt_movimentado)."', interval ".$ic_tempo_troca." month)dt_troca_usa  ";
        //echo $sql."<br>";
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    public function listar_impressao($leads_pk,$colaborador_pk,$conjunto_material_pk){
        if($leads_pk!="" || $colaborador_pk !=""){
            $sql ="";
            $sql.="select me.pk, me.dt_cadastro, me.usuario_cadastro_pk, me.dt_ult_atualizacao, me.usuario_ult_atualizacao_pk ";
            $sql.="       ,me.leads_pk ";
            $sql.="       ,me.colaborador_pk ";
            $sql.="       ,me.produtos_itens_pk ";
            $sql.="       ,me.qtde ";
            $sql.="       ,me.ic_mateiral_carga";
            $sql.="       ,me.obs_movimentacao obs_material ";
            $sql.="       ,me.conjunto_material_pk";
            $sql.="       ,date_format(me.dt_entrega,'%d/%m/%Y') dt_entrega ";
            $sql.="       ,date_format(me.dt_devolucao,'%d/%m/%Y') dt_devolucao ";
            $sql.="       ,p.ds_produto ";
            $sql.="       ,p.pk produtos_pk ";
            $sql.="       ,cp.pk categorias_produto_pk ";
            $sql.="       ,cp.ds_categoria ds_categorias_produto";
            $sql.="       ,pi.pk produtos_itens_pk ";
            $sql.="       ,pi.ds_n_serie ";
            $sql.="  from movimentacao_estoque me ";
            $sql.="     INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
            $sql.="     INNER JOIN produtos p on p.pk = pi.produtos_pk";        
            $sql.="     INNER JOIN categorias_produto cp on p.categorias_produto_pk = cp.pk ";        
            $sql.=" where 1=1 ";        
            if($leads_pk != ""){
                $sql.=" and me.leads_pk = ".$leads_pk;
            }
            if($colaborador_pk != ""){
                $sql.=" and me.colaborador_pk = ".$colaborador_pk;
            }
            if($conjunto_material_pk != ""){
                $sql.=" and me.conjunto_material_pk = ".$conjunto_material_pk;
            }
            $sql.=" order by me.leads_pk desc ";
             
            $query = $this->db->execQuery($sql);
            
        }
 
        
        
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,produtos_itens_pk ";
        $sql.="       ,qtde ";
        $sql.="       ,ic_mateiral_carga";
        $sql.="       ,obs_movimentacao ";
        $sql.="       ,conjunto_material_pk";

        $sql.="  from movimentacao_estoque ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioEstoqueMinimo($categorias_pk,$produtos_pk,$leads_pk){

        $sql ="";
        $sql.="select ee.pk,";
        $sql.="       p.ds_produto";
        $sql.="       ,c.ds_categoria";
        $sql.="       ,p.pk produtos_pk";
        $sql.="       ,(ee.qtde) qtde_inicial";
        $sql.="       ,(p.qtde_minima) qtde_minima";
        $sql.="       ,date_format(ee.dt_cadastro,'%d/%m/%Y')dt_cadastro_estoque";
        $sql.="  from produtos p";
        $sql.="       left join entrada_estoque ee  ON ee.produtos_pk = p.pk";
        $sql.="       left join produtos_itens pi ON p.pk = pi.produtos_pk";
        $sql.="       left join categorias_produto c ON p.categorias_produto_pk = c.pk";
        $sql.="       left join movimentacao_estoque me ON pi.pk = me.produtos_itens_pk";

        $sql.=" where 1=1 ";
        if($categorias_pk!=""){
            $sql.=" and c.pk = ".$categorias_pk;
        }
        if($produtos_pk!=""){
            $sql.=" and p.pk = ".$produtos_pk;
        }
        if($leads_pk != ""){
            $sql.=" and me.leads_pk = ".$leads_pk;
        }
       
        $sql.=" group by p.pk";
        $sql.=" order by p.ds_produto ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioEstoqueMinimoAtual($categorias_pk,$produtos_pk){

        $sql ="";
        $sql.="select ee.pk,";
        $sql.="       p.ds_produto";
        $sql.="       ,c.ds_categoria";
        $sql.="       ,p.pk produtos_pk";
        $sql.="       ,sum(ee.qtde) qtde_inicial";
        $sql.="  from entrada_estoque ee";
        $sql.="       left join produtos p ON ee.produtos_pk = p.pk";
        $sql.="       left join categorias_produto c ON p.categorias_produto_pk = c.pk";

        $sql.=" where 1=1 ";
        if($categorias_pk!=""){
            $sql.=" and c.pk = ".$categorias_pk;
        }
        if($produtos_pk!=""){
            $sql.=" and p.pk = ".$produtos_pk;
        }
       
        $sql.=" group by p.pk";
        $sql.=" order by p.ds_produto ";
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioEstoqueAtual($categorias_pk,$produtos_pk,$entrada_estoque_pk){

        $sql ="";
        $sql.="SELECT c.ds_categoria,";
        $sql.="       p.ds_produto,";        
        $sql.="       date_format(ee.dt_cadastro, '%d/%m/%Y') dt_cadastro_estoque,";
        $sql.="       sum(ee.qtde) qtde_inicial,";
        $sql.="       COUNT(DISTINCT me.pk) qtde_movimentado";
        $sql.="  FROM movimentacao_estoque me";
        $sql.="       INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="       INNER JOIN produtos p ON pi.produtos_pk = p.pk";
        $sql.="       INNER JOIN entrada_estoque ee ON  pi.entrada_estoque_pk = ee.pk";
        $sql.="      LEFT JOIN categorias_produto c ON p.categorias_produto_pk = c.pk";     
        $sql.=" where 1=1 ";
        if($categorias_pk!=""){
            $sql.=" and c.pk = ".$categorias_pk;
        }
        if($produtos_pk!=""){
            $sql.=" and p.pk = ".$produtos_pk;
        }
        if($entrada_estoque_pk!=""){
            $sql.=" and pi.entrada_estoque_pk = ".$entrada_estoque_pk;
        }
        $sql.=" GROUP BY p.pk";
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function RelatorioEstoque($categorias_pk,$produtos_pk,$entrada_estoque_pk,$leads_pk){

        $sql ="";
        $sql.="SELECT c.ds_categoria,";
        $sql.="       p.ds_produto,";        
        $sql.="       COUNT(DISTINCT me.pk) qtde_movimentado";
        $sql.="  FROM movimentacao_estoque me";
        $sql.="       INNER JOIN produtos_itens pi ON me.produtos_itens_pk = pi.pk";
        $sql.="       INNER JOIN produtos p ON pi.produtos_pk = p.pk";
        $sql.="       LEFT JOIN categorias_produto c ON p.categorias_produto_pk = c.pk";     
        $sql.=" where 1=1 ";
        if($categorias_pk!=""){
            $sql.=" and c.pk = ".$categorias_pk;
        }
        if($produtos_pk!=""){
            $sql.=" and p.pk = ".$produtos_pk;
        }
        if($leads_pk!=""){
            $sql.=" and me.leads_pk = ".$leads_pk;
        }
        if($entrada_estoque_pk!=""){
            //$sql.=" and pi.entrada_estoque_pk = ".$entrada_estoque_pk;
        }
        if($produtos_pk!=""){
            $sql.=" GROUP BY p.pk";
        }
        
        
        

        $query = $this->db->execQuery($sql);
        return $query;
    }
}

?>
