<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_curso.class.php';


class colaborador_cursodao{

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
    
    public function salvar($colaborador_curso){

        $fields = array();
        $fields['colaboradores_pk'] = $colaborador_curso->getcolaboradores_pk();
        $fields['cursos_pk'] = $colaborador_curso->getcursos_pk();
        if($colaborador_curso->getdt_execucao()!=""){
            $fields['dt_execucao'] = DataYMD($colaborador_curso->getdt_execucao());
        }
        if($colaborador_curso->getdt_validacao()!=""){
            $fields['dt_validacao'] = DataYMD($colaborador_curso->getdt_validacao());
        }


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_curso->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_curso", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_curso", $fields, " pk = ".$colaborador_curso->getpk());
        }

    }

    public function excluir($colaborador_curso){
        $this->db->execDelete("colaboradores_curso"," pk = ".$colaborador_curso->getpk());
    }
    public function excluirColaborador($colaboradores_pk){
        $this->db->execDelete("colaboradores_curso"," colaboradores_pk = ".$colaboradores_pk);
    }

    public function carregarPorPk($pk){

        $colaborador_curso = new colaborador_curso();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaboradores_pk ";
        $sql.="       ,cursos_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,dt_validacao ";


        $sql.="  from colaboradores_curso ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_curso->setpk($query[$i]["pk"]);
                $colaborador_curso->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_curso->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_curso->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_curso->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_curso->setcolaboradores_pk($query[$i]['colaboradores_pk']);
                $colaborador_curso->setcursos_pk($query[$i]['cursos_pk']);
                $colaborador_curso->setdt_execucao($query[$i]['dt_execucao']);
                $colaborador_curso->setdt_validacao($query[$i]['dt_validacao']);

            }
        }
        return $colaborador_curso;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,cursos_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,dt_validacao ";

        $sql.="  from colaboradores_curso ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_colaboradores_pk($colaboradores_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,cursos_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,dt_validacao ";

        $sql.="  from colaboradores_curso ";
        $sql.=" where 1=1 ";
        if($colaboradores_pk != ""){
            $sql.=" and ds_colaborador_curso like '%".$colaboradores_pk."%' ";
        }
        $sql.=" order by colaboradores_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarCursoColaboradores($colaboradores_pk){

        $sql ="";
        $sql.="select cc.pk, cc.dt_cadastro, cc.usuario_cadastro_pk, cc.dt_ult_atualizacao, cc.usuario_ult_atualizacao_pk ";
        $sql.="       ,cc.colaboradores_pk ";
        $sql.="       ,cc.cursos_pk ";
        $sql.="       ,date_format(cc.dt_execucao,'%d/%m/%Y')dt_execucao";
        $sql.="       ,date_format(cc.dt_validacao,'%d/%m/%Y')dt_validacao";

        $sql.="  from colaboradores_curso cc";
        
        $sql.=" where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and cc.colaboradores_pk=".$colaboradores_pk;
        }
        $sql.=" order by cc.colaboradores_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function RelatorioColaboradorCurso($colaboradores_pk,$cursos_pk,$dt_execucao_ini,$dt_execucao_fim,$dt_validacao_ini,$dt_validacao_fim){

        $sql ="";
        $sql.="select cc.pk, cc.dt_cadastro, cc.usuario_cadastro_pk, cc.dt_ult_atualizacao, cc.usuario_ult_atualizacao_pk ";
        $sql.="       ,cc.colaboradores_pk ";
        $sql.="       ,cl.ds_colaborador";
        $sql.="       ,cc.cursos_pk ";
        $sql.="       ,c.ds_curso";
        $sql.="       ,date_format(cc.dt_execucao,'%d/%m/%Y')dt_execucao";
        $sql.="       ,date_format(cc.dt_validacao,'%d/%m/%Y')dt_validacao";

        $sql.="  from colaboradores_curso cc";
        $sql.="       inner join colaboradores cl on cl.pk = cc.colaboradores_pk";
        $sql.="       inner join cursos c on c.pk = cc.cursos_pk";
        $sql.=" where 1=1 ";
        if($colaboradores_pk!=""){
            $sql.=" and cc.colaboradores_pk=".$colaboradores_pk;
        }
        if($cursos_pk!=""){
            $sql.=" and cc.cursos_pk=".$cursos_pk;
        }
        if($dt_execucao_ini!=""){
            $sql.=" and cc.dt_execucao between '".DataYMD($dt_execucao_ini)."' and '".DataYMD($dt_execucao_fim)."'";
        }
        if($dt_validacao_ini!=""){
            $sql.=" and cc.dt_validacao between '".DataYMD($dt_validacao_ini)."' and '".DataYMD($dt_validacao_fim)."'";
        }
        $sql.=" order by cc.colaboradores_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaboradores_pk ";
        $sql.="       ,cursos_pk ";
        $sql.="       ,dt_execucao ";
        $sql.="       ,dt_validacao ";

        $sql.="  from colaboradores_curso ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaboradores_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
