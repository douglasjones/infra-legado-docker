<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/teto_gastos_itens.class.php';


class teto_gastos_itensdao{

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

    public function salvar($teto_gastos_itens){

        $vl_teto_anual = moeda2float($teto_gastos_itens->getvl_teto_anual());
        $vl_teto_mensal = moeda2float($teto_gastos_itens->getvl_teto_mensal());
        $dt_ini_teto = dataYMD($teto_gastos_itens->getdt_ini_teto());
        $dt_fim_teto = dataYMD($teto_gastos_itens->getdt_fim_teto());
        $mensagem = $this->fcTotal($teto_gastos_itens->getteto_gastos_pk(), $vl_teto_anual, $vl_teto_mensal, $dt_ini_teto, $dt_fim_teto);

        if($mensagem != null){
            $data[] = array(
                "pk" => "",
                "mensagem_erro" => $mensagem,
            );
            return $data;
        }

        $fields = array();
        $fields['operacao_pk'] = $teto_gastos_itens->getoperacao_pk();
        $fields['categoria_operacao_pk'] = $teto_gastos_itens->getcategoria_operacao_pk();
        $fields['tipos_operacao_pk'] = $teto_gastos_itens->gettipos_operacao_pk();
        $fields['dt_ini_teto'] = $dt_ini_teto;
        $fields['dt_fim_teto'] = $dt_fim_teto;
        $fields['vl_teto_anual'] = $vl_teto_anual;
        $fields['vl_teto_mensal'] = $vl_teto_mensal;
        $fields['ic_teto_mensal'] = $teto_gastos_itens->getic_teto_mensal();
        $fields['vl_teto_anual_atual'] = moeda2float($teto_gastos_itens->getvl_teto_anual_atual());
        $fields['vl_teto_mensal_atual'] = moeda2float($teto_gastos_itens->getvl_teto_mensal_atual());
        $fields['ic_status'] = $teto_gastos_itens->getic_status();
        $fields['obs'] = $teto_gastos_itens->getobs();
        $fields['teto_gastos_pk'] = $teto_gastos_itens->getteto_gastos_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($teto_gastos_itens->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("teto_gastos_itens", $fields);

            $teto_gastos_itens->setpk($pk);
        }
        else{
            $this->db->execUpdate("teto_gastos_itens", $fields, " pk = ".$teto_gastos_itens->getpk());
        }

        $data[] = array(
            "pk" => $teto_gastos_itens->getpk(),
            "mensagem_erro" => "",
        );
        return $data;

    }

    public function excluir($teto_gastos_itens){
        $this->db->execDelete("teto_gastos_itens"," pk = ".$teto_gastos_itens->getpk());
    }

    public function fcTotal($pk, $vl_teto_anual, $vl_teto_mensal,  $dt_ini_teto, $dt_fim_teto){
        $vl_total_teto_anual_cadastrado = 0;
        $vl_total_teto_anual = 0;
        $vl_teto_mensal_total = 0;
        $vl_total_teto = "";
        $diffMes = "";
        $mensagem = "";
        
        $sql ="";
        $sql.="select tg.pk";
        $sql.="       ,TIMESTAMPDIFF(month, '".$dt_ini_teto."', '".$dt_fim_teto."') diffMes";
        $sql.="       ,tg.vl_total_teto ";
        $sql.="  from teto_gastos tg ";
        $sql.=" where pk = $pk ";
        $query_vl_total_teto = $this->db->execQuery($sql);
        $vl_total_teto =  $query_vl_total_teto[0]['vl_total_teto'];
        $diffMes = $query_vl_total_teto[0]['diffMes'];

        $sql ="";
        $sql.="select tgi.pk";
        $sql.="       ,tgi.vl_teto_anual ";
        $sql.="       ,tgi.vl_teto_mensal ";
        $sql.="       ,tgi.vl_teto_anual_atual ";
        $sql.="       ,tgi.vl_teto_mensal_atual ";

        $sql.="  from teto_gastos_itens tgi ";
        $sql.="  inner join teto_gastos tg on tgi.teto_gastos_pk = tg.pk ";
        $sql.=" where teto_gastos_pk = $pk ";
        $query = $this->db->execQuery($sql);
        for($i=0;$i<count($query);$i++){
            $vl_total_teto_anual_cadastrado += $query[$i]['vl_teto_anual'];
        }

        if($vl_total_teto_anual_cadastrado <= $vl_total_teto){
            $vl_total_teto_anual = $vl_teto_anual + $vl_total_teto_anual_cadastrado;
            if($vl_total_teto_anual > $vl_total_teto){
                $mensagem = "A soma dos valores anuais não pode superar o valor do teto de gastos.";
                return $mensagem;
            }
        }else{
            $mensagem = "Valor anual não pode superar o valor do teto total de gastos.";
            return $mensagem;
        }
        if($vl_teto_mensal != ""){
            if($vl_teto_mensal > $vl_teto_anual){
                $mensagem = "Valor mensal não pode superar o valor do teto anual.";
                return $mensagem;
            }
            $vl_teto_mensal_total = $vl_teto_mensal * $diffMes;
            if($vl_teto_mensal_total > $vl_teto_anual){
                $mensagem = "A soma do valor mensal não pode superar o valor do teto anual.";
                return $mensagem;
                
            }
            
        }
    }

    public function carregarPorPk($pk){

        $teto_gastos_itens = new teto_gastos_itens();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,operacao_pk ";
        $sql.="       ,categoria_operacao_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,dt_ini_teto ";
        $sql.="       ,dt_fim_teto ";
        $sql.="       ,vl_teto_anual ";
        $sql.="       ,vl_teto_mensal ";
        $sql.="       ,ic_teto_mensal ";
        $sql.="       ,vl_teto_anual_atual ";
        $sql.="       ,vl_teto_mensal_atual ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,teto_gastos_pk ";

        $sql.="  from teto_gastos_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $teto_gastos_itens->setpk($query[$i]["pk"]);
                $teto_gastos_itens->setdt_cadastro($query[$i]["dt_cadastro"]);
                $teto_gastos_itens->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $teto_gastos_itens->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $teto_gastos_itens->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $teto_gastos_itens->setoperacao_pk($query[$i]['operacao_pk']);
                $teto_gastos_itens->setcategoria_operacao_pk($query[$i]['categoria_operacao_pk']);
                $teto_gastos_itens->settipos_operacao_pk($query[$i]['tipos_operacao_pk']);
                $teto_gastos_itens->setdt_ini_teto($query[$i]['dt_ini_teto']);
                $teto_gastos_itens->setdt_fim_teto($query[$i]['dt_fim_teto']);
                $teto_gastos_itens->setvl_teto_anual($query[$i]['vl_teto_anual']);
                $teto_gastos_itens->setvl_teto_mensal($query[$i]['vl_teto_mensal']);
                $teto_gastos_itens->setic_teto_mensal($query[$i]['ic_teto_mensal']);
                $teto_gastos_itens->setvl_teto_anual_atual($query[$i]['vl_teto_anual_atual']);
                $teto_gastos_itens->setvl_teto_mensal_atual($query[$i]['vl_teto_mensal_atual']);
                $teto_gastos_itens->setic_status($query[$i]['ic_status']);
                $teto_gastos_itens->setobs($query[$i]['obs']);
                $teto_gastos_itens->setteto_gastos_pk($query[$i]['teto_gastos_pk']);
            }
        }
        return $teto_gastos_itens;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,categoria_operacao_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,dt_ini_teto ";
        $sql.="       ,dt_fim_teto ";
        $sql.="       ,vl_teto_anual ";
        $sql.="       ,vl_teto_mensal ";
        $sql.="       ,ic_teto_mensal ";
        $sql.="       ,vl_teto_anual_atual ";
        $sql.="       ,vl_teto_mensal_atual ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,teto_gastos_pk ";

        $sql.="  from teto_gastos_itens ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_teto_gastos_pk($teto_gastos_pk){

        $sql ="";
        $sql.="select tgi.pk, date_format(tgi.dt_cadastro,'%d/%m/%Y') dt_cadastro, tgi.usuario_cadastro_pk, date_format(tgi.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao, tgi.usuario_ult_atualizacao_pk ";
        $sql.="       ,tgi.operacao_pk ";
        $sql.="       ,tgi.categoria_operacao_pk ";
        $sql.="       ,tgi.tipos_operacao_pk ";
        $sql.="       ,CASE
                        WHEN tgi.tipos_operacao_pk = 7 THEN 'Custo Fixo'
                        WHEN tgi.tipos_operacao_pk = 8 THEN 'Custo Variável'
                        WHEN tgi.tipos_operacao_pk = 2 THEN 'Despesa Fixa'
                        WHEN tgi.tipos_operacao_pk = 3 THEN 'Despesa Variável'
                        WHEN tgi.tipos_operacao_pk = 4 THEN 'Imposto'
                        WHEN tgi.tipos_operacao_pk = 5 THEN 'Transferência'
                        WHEN tgi.tipos_operacao_pk = 6 THEN 'Caixinha'
                        END ds_tipos_operacao ";
        $sql.="       ,date_format(tgi.dt_ini_teto ,'%d/%m/%Y') dt_ini_teto";
        $sql.="       ,date_format(tgi.dt_fim_teto ,'%d/%m/%Y') dt_fim_teto";
        $sql.="       ,tgi.vl_teto_anual ";
        $sql.="       ,tgi.vl_teto_mensal ";
        $sql.="       ,tgi.ic_teto_mensal ";
        $sql.="       ,tgi.vl_teto_anual_atual ";
        $sql.="       ,tgi.vl_teto_mensal_atual ";
        $sql.="       ,tgi.ic_status ";
        $sql.="       ,tgi.obs ";
        $sql.="       ,tgi.teto_gastos_pk ";
        $sql.="       ,cf.ds_categoria ";
        $sql.="       ,top.ds_tipo_operacao ";

        $sql.="  from teto_gastos_itens tgi";
        $sql.="  left join categorias_financeiras cf on cf.pk = tgi.categoria_operacao_pk";
        $sql.="  left join tipos_operacao top on top.pk = tgi.operacao_pk";
        $sql.=" where 1=1 ";
        if($teto_gastos_pk != ""){
            $sql.=" and teto_gastos_pk = ".$teto_gastos_pk;
        }
        $sql.=" order by operacao_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,operacao_pk ";
        $sql.="       ,categoria_operacao_pk ";
        $sql.="       ,tipos_operacao_pk ";
        $sql.="       ,dt_ini_teto ";
        $sql.="       ,dt_fim_teto ";
        $sql.="       ,vl_teto_anual ";
        $sql.="       ,vl_teto_mensal ";
        $sql.="       ,ic_teto_mensal ";
        $sql.="       ,vl_teto_anual_atual ";
        $sql.="       ,vl_teto_mensal_atual ";
        $sql.="       ,ic_status ";
        $sql.="       ,obs ";
        $sql.="       ,teto_gastos_pk ";

        $sql.="  from teto_gastos_itens ";
        $sql.=" where 1=1 ";
        $sql.=" order by operacao_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
