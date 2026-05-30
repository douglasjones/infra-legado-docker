<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/afastamento_ferias_colaborador.class.php';


class afastamento_ferias_colaboradordao{

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
    
    public function salvar($afastamento_ferias_colaborador){

        $fields = array();
        $fields['tipo_apontamento'] = $afastamento_ferias_colaborador->gettipo_apontamento();
        $fields['dt_inicio'] = $afastamento_ferias_colaborador->getdt_inicio();
        $fields['dt_fim'] = $afastamento_ferias_colaborador->getdt_fim();
        $fields['ds_obs'] = $afastamento_ferias_colaborador->getds_obs();
        $fields['colaborador_pk'] = $afastamento_ferias_colaborador->getcolaborador_pk();
        $fields['leads_pk'] = $afastamento_ferias_colaborador->getleads_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($afastamento_ferias_colaborador->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("afastamento_ferias_colaborador", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("afastamento_ferias_colaborador", $fields, " pk = ".$afastamento_ferias_colaborador->getpk());
        }

    }

    public function excluir($afastamento_ferias_colaborador){
        
        $this->db->execDelete("afastamento_ferias_colaborador"," pk = ".$afastamento_ferias_colaborador->getpk());
        
        
        
        
    }
    public function excluirPk($pk){
        $this->db->execDelete("afastamento_ferias_colaborador"," pk = ".$pk);
    }
    public function excluirColaborador($colaborador_pk){
        $this->db->execDelete("afastamento_ferias_colaborador"," colaborador_pk = ".$colaborador_pk);
    }
    
    
    public function carregarPorColaboradorPk($colaborador_pk,$dt_inicio_ini,$tipo_apontamento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,ds_obs ";
        $sql.="       ,leads_pk";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where 1=1";
        $sql.=" and tipo_apontamento = ".$tipo_apontamento;
        $sql.=" and colaborador_pk = ".$colaborador_pk;
        $sql.=" and dt_inicio = '".DataYMD($dt_inicio_ini)."'";
      
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    public function carregarPorPk($pk){

        $afastamento_ferias_colaborador = new afastamento_ferias_colaborador();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_apontamento ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,ds_obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk";


        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $afastamento_ferias_colaborador->setpk($query[$i]["pk"]);
                $afastamento_ferias_colaborador->setdt_cadastro($query[$i]["dt_cadastro"]);
                $afastamento_ferias_colaborador->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $afastamento_ferias_colaborador->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $afastamento_ferias_colaborador->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $afastamento_ferias_colaborador->settipo_apontamento($query[$i]['tipo_apontamento']);
                $afastamento_ferias_colaborador->setdt_inicio($query[$i]['dt_inicio']);
                $afastamento_ferias_colaborador->setdt_fim($query[$i]['dt_fim']);
                $afastamento_ferias_colaborador->setds_obs($query[$i]['ds_obs']);
                $afastamento_ferias_colaborador->setcolaborador_pk($query[$i]['colaborador_pk']);
                $afastamento_ferias_colaborador->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $afastamento_ferias_colaborador;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,ds_obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarApontamento($colaborador_pk,$dt_base,$dt_fim,$leads_pk){

        $sql ="";
        $sql.="select af.pk, date_format(af.dt_cadastro,'%d/%m/%Y')dt_cadastro,date_format(af.dt_inicio,'%d/%m/%Y')dt_inicio, af.usuario_cadastro_pk, af.dt_ult_atualizacao, af.usuario_ult_atualizacao_pk  ";
        $sql.="       ,case af.tipo_apontamento when 1 then 'Afastamento Médico' when 2 then 'Licença Maternidade' end ds_tipo_apontamento";
        $sql.="       ,af.dt_inicio ";
        $sql.="       ,af.dt_fim ";
        $sql.="       ,af.ds_obs ";
        $sql.="       ,af.colaborador_pk ";
        $sql.="       ,af.leads_pk";
        $sql.="       ,u.ds_usuario";

        $sql.="  from afastamento_ferias_colaborador af";
        $sql.="  inner join usuarios u on af.usuario_cadastro_pk = u.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and af.colaborador_pk = ".$colaborador_pk;
        }
        if($leads_pk!=""){
            $sql.=" and af.leads_pk = ".$leads_pk;
        }
        if($dt_base!=""){
            $sql.=" and  '".DataYMD($dt_base)."' >= af.dt_inicio ";
            $sql.=" and '".DataYMD($dt_fim)."' <= af.dt_fim  ";
        }
   
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarAfastamentoColaboradores($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,date_format(dt_inicio,'%d/%m/%Y')dt_inicio";
        $sql.="       ,date_format(dt_fim,'%d/%m/%Y')dt_fim";
        $sql.="       ,ds_obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where colaborador_pk = $colaborador_pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_apontamento($tipo_apontamento){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,ds_obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where 1=1 ";
        if($tipo_apontamento != ""){
            $sql.=" and ds_afastamento_ferias_colaborador like '%".$tipo_apontamento."%' ";
        }
        $sql.=" order by tipo_apontamento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_apontamento ";
        $sql.="       ,dt_inicio ";
        $sql.="       ,dt_fim ";
        $sql.="       ,ds_obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk";

        $sql.="  from afastamento_ferias_colaborador ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_apontamento asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
