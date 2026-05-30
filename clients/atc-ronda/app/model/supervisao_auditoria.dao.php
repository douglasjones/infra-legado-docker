<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/supervisao_auditoria.class.php';


class supervisao_auditoriadao{

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

    public function salvar($supervisao_auditoria){

        $fields = array();
        $fields['leads_pk'] = $supervisao_auditoria->getleads_pk();
        $fields['auditorias_categorias_pk'] = $supervisao_auditoria->getauditorias_categorias_pk();
        $fields['auditorias_categorias_tipos_pk'] = $supervisao_auditoria->getauditorias_categorias_tipos_pk();
        $fields['dt_agendamento'] = $supervisao_auditoria->getdt_agendamento();
        $fields['usuario_agendamento_pk'] = $supervisao_auditoria->getusuario_agendamento_pk();
        $fields['dt_execucao'] = $supervisao_auditoria->getdt_execucao();
        $fields['usuario_execucao_pk'] = $supervisao_auditoria->getusuario_execucao_pk();
        $fields['ic_contato_cliente'] = $supervisao_auditoria->getic_contato_cliente();
        $fields['obs_contato_cliente'] = $supervisao_auditoria->getobs_contato_cliente();
        $fields['obs_geral'] = $supervisao_auditoria->getobs_geral();
        $fields['ds_localizacao'] = $supervisao_auditoria->getds_localizacao();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($supervisao_auditoria->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("supervisao_auditorias", $fields);
            $supervisao_auditoria->setpk($pk);
        }
        else{
            $this->db->execUpdate("supervisao_auditorias", $fields, " pk = ".$supervisao_auditoria->getpk());
        }
        return $supervisao_auditoria->getpk();;

    }

    public function excluir($supervisao_auditoria){
        $this->db->execDelete("supervisao_auditorias"," pk = ".$supervisao_auditoria->getpk());
    }

    public function carregarPorPk($pk){

        $supervisao_auditoria = new supervisao_auditoria();
        if($pk != ""){

        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,leads_pk ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,dt_agendamento ";
        $sql.="       ,usuario_agendamento_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,usuario_execucao_pk ";
        $sql.="       ,ic_contato_cliente ";
        $sql.="       ,obs_contato_cliente ";
        $sql.="       ,obs_geral ";
        $sql.="       ,ds_localizacao ";


        $sql.="  from supervisao_auditorias ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $supervisao_auditoria->setpk($query[$i]["pk"]);
                $supervisao_auditoria->setdt_cadastro($query[$i]["dt_cadastro"]);
                $supervisao_auditoria->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $supervisao_auditoria->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $supervisao_auditoria->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $supervisao_auditoria->setleads_pk($query[$i]['leads_pk']);
                $supervisao_auditoria->setauditorias_categorias_pk($query[$i]['auditorias_categorias_pk']);
                $supervisao_auditoria->setauditorias_categorias_tipos_pk($query[$i]['auditorias_categorias_tipos_pk']);
                $supervisao_auditoria->setdt_agendamento($query[$i]['dt_agendamento']);
                $supervisao_auditoria->setusuario_agendamento_pk($query[$i]['usuario_agendamento_pk']);
                $supervisao_auditoria->setdt_execucao($query[$i]['dt_execucao']);
                $supervisao_auditoria->setusuario_execucao_pk($query[$i]['usuario_execucao_pk']);
                $supervisao_auditoria->setic_contato_cliente($query[$i]['ic_contato_cliente']);
                $supervisao_auditoria->setobs_contato_cliente($query[$i]['obs_contato_cliente']);
                $supervisao_auditoria->setobs_geral($query[$i]['obs_geral']);
                $supervisao_auditoria->setds_localizacao($query[$i]['ds_localizacao']);

            }
        }
        return $supervisao_auditoria;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,leads_pk ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,dt_agendamento ";
        $sql.="       ,usuario_agendamento_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,usuario_execucao_pk ";
        $sql.="       ,ic_contato_cliente ";
        $sql.="       ,obs_contato_cliente ";
        $sql.="       ,obs_geral ";
        $sql.="       ,ds_localizacao ";

        $sql.="  from supervisao_auditorias ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_leads_pk($leads_pk){

        $sql ="";
        $sql.="SELECT sa.pk,";
        $sql.="    sa.dt_cadastro,";
        $sql.="    sa.usuario_cadastro_pk,";
        $sql.="    sa.dt_ult_atualizacao,";
        $sql.="    sa.usuario_ult_atualizacao_pk,";
        $sql.="    sa.leads_pk,";
        $sql.="    sa.auditorias_categorias_pk,";
        $sql.="    sa.auditorias_categorias_tipos_pk,";
        $sql.="    sa.dt_agendamento,";
        $sql.="    sa.usuario_agendamento_pk,";
        $sql.="    sa.usuario_execucao_pk,";
        $sql.="    sa.ic_contato_cliente,";
        $sql.="    sa.obs_contato_cliente,";
        $sql.="    sa.obs_geral,";
        $sql.="    sa.ds_localizacao,";
        $sql.="    l.ds_lead,";
        $sql.="    ac.ds_categoria,";
        $sql.="    act.ds_auditoria_categoria_tipo,";
        $sql.="    date_format(sa.dt_execucao,'%d/%m/%Y') dt_execucao,";
        $sql.="    u.ds_usuario";
        $sql.=" FROM supervisao_auditorias sa";
        $sql.="    INNER JOIN leads l ON sa.leads_pk = l.pk";
        $sql.="    INNER JOIN auditoria_categorias ac ON sa.auditorias_categorias_pk = ac.pk";
        $sql.="    INNER JOIN auditoria_categorias_tipos act ON sa.auditorias_categorias_tipos_pk = act.pk";
        $sql.="    LEFT JOIN usuarios u ON sa.usuario_execucao_pk = u.pk";
        $sql.=" WHERE 1 = 1";
        $sql.=" ORDER BY sa.pk DESC";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,auditorias_categorias_pk ";
        $sql.="       ,auditorias_categorias_tipos_pk ";
        $sql.="       ,dt_agendamento ";
        $sql.="       ,usuario_agendamento_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,usuario_execucao_pk ";
        $sql.="       ,ic_contato_cliente ";
        $sql.="       ,obs_contato_cliente ";
        $sql.="       ,obs_geral ";
        $sql.="       ,ds_localizacao ";

        $sql.="  from supervisao_auditorias ";
        $sql.=" where 1=1 ";
        $sql.=" order by leads_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDadosRelSupervisao($leads_pk, $dt_ini, $dt_fim, $supervisores_pk, $auditorias_categorias_pk, $auditorias_categorias_tipos_pk){

        $sql ="";
        $sql.="select sa.pk, sa.usuario_cadastro_pk, sa.dt_ult_atualizacao, sa.usuario_ult_atualizacao_pk ";
        $sql.="       ,date_format(sa.dt_cadastro,'%d/%m/%Y %H:%i:%s') dt_cadastro";
        $sql.="       ,sa.leads_pk ";
        $sql.="       ,sa.auditorias_categorias_pk ";
        $sql.="       ,sa.auditorias_categorias_tipos_pk ";
        $sql.="       ,sa.dt_agendamento ";
        $sql.="       ,sa.usuario_agendamento_pk ";
        $sql.="       ,sa.dt_execucao ";
        $sql.="       ,sa.usuario_execucao_pk ";
        $sql.="       ,u.ds_usuario ds_supervisor ";
        $sql.="       ,us.ds_usuario ds_usuario_cadastro ";
        $sql.="       ,sa.ic_contato_cliente ";
        $sql.="       ,sa.obs_contato_cliente ";
        $sql.="       ,sa.obs_geral ";
        $sql.="       ,sa.ds_localizacao ";
        $sql.="       ,ac.ds_categoria";
        $sql.="       ,act.ds_auditoria_categoria_tipo";
        $sql.="       ,l.ds_lead";

        $sql.="  from supervisao_auditorias sa ";
        $sql.="    LEFT JOIN leads l ON sa.leads_pk = l.pk";
        $sql.="    LEFT JOIN auditoria_categorias ac ON sa.auditorias_categorias_pk = ac.pk";
        $sql.="    LEFT JOIN auditoria_categorias_tipos act ON sa.auditorias_categorias_tipos_pk = act.pk";
        $sql.="    LEFT JOIN usuarios u ON sa.usuario_execucao_pk = u.pk";
        $sql.="    LEFT JOIN usuarios us ON sa.usuario_cadastro_pk = us.pk";
        $sql.=" where 1=1 ";
        if($leads_pk != ""){
            $sql.=" and sa.leads_pk = $leads_pk";
        }
        if($dt_ini != ""){
            $sql.=" and sa.dt_cadastro >= '$dt_ini 00:00:00'";
            $sql.=" and sa.dt_cadastro <= '$dt_fim 23:59:59'";
        }
        if($supervisores_pk != ""){
            $sql.=" and sa.usuario_execucao_pk = $supervisores_pk";
        }
        if($auditorias_categorias_pk != ""){
            $sql.=" and sa.auditorias_categorias_pk = $auditorias_categorias_pk";
        }
        if($auditorias_categorias_tipos_pk != ""){
            $sql.=" and sa.auditorias_categorias_tipos_pk = $auditorias_categorias_tipos_pk";
        }
        $sql.=" order by sa.leads_pk asc ";
        $query = $this->db->execQuery($sql);
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $endereco_ponto = " ";
                $latitude_ponto = " ";
                $longitude_ponto = " ";

                if($query[$i]['ds_localizacao']!=""){
                    $arrCoordenadasPonto = explode(' ',$query[$i]['ds_localizacao']);
                    $latitude_ponto = $arrCoordenadasPonto[0];
                    $longitude_ponto = $arrCoordenadasPonto[1];
                    
                    //TRANSFORMAR COORDERNADAS PONTO EM ENDEREÇO
                    $endereco_ponto = fcTransformarCoordenadasEmEndereco($latitude_ponto,$longitude_ponto);
                   
                } 
                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "ds_usuario_cadastro"=>$query[$i]['ds_usuario_cadastro'],
                    "ds_categoria"=>$query[$i]['ds_categoria'],
                    "ds_auditoria_categoria_tipo"=>$query[$i]['ds_auditoria_categoria_tipo'],
                    "supervisao_auditorias_pk"=>$query[$i]['pk'],
                    "auditorias_categorias_tipos_pk"=>$query[$i]['auditorias_categorias_tipos_pk'],
                    "dt_cadastro"=>$query[$i]['dt_cadastro'],
                    "ds_supervisor"=>$query[$i]['ds_supervisor'],
                    "obs_geral"=>$query[$i]['obs_geral'],
                    "ds_localizacao"=>$endereco_ponto
                );
            }
        }

        return $result;

    }

    public function listarComboSupervisores(){

        $sql ="";
        $sql.="select sa.usuario_execucao_pk ";
        $sql.="      ,u.ds_usuario ";
        $sql.="  from supervisao_auditorias  sa";
        $sql.="    LEFT JOIN usuarios u ON sa.usuario_execucao_pk = u.pk";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_usuario asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
