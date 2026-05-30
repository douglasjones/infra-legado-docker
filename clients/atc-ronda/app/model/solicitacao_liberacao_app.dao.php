<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/solicitacao_liberacao_app.class.php';


class solicitacao_liberacao_appdao{

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
    
    public function salvar($solicitacao_liberacao_app){
      
        $fields = array();
        $fields['ds_pin'] = $solicitacao_liberacao_app->getds_pin();
        $fields['colaborador_pk'] = $solicitacao_liberacao_app->getcolaborador_pk();
        $fields['id_cliente'] = $solicitacao_liberacao_app->getid_cliente();
        $fields['ds_imagem'] = $solicitacao_liberacao_app->getds_imagem();
        
        $fields['ds_aparelho'] = $solicitacao_liberacao_app->getds_aparelho();
        $fields['usuario_aprovacao_pk'] = $solicitacao_liberacao_app->getusuario_aprovacao_pk();
        $fields['obs'] = $solicitacao_liberacao_app->getobs();
        $fields['ic_status'] = $solicitacao_liberacao_app->getic_status();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        if($this->arrToken['usuarios_pk']==""){
            $fields["usuario_ult_atualizacao_pk"] = 1;
        }else{
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        }
        

        if($solicitacao_liberacao_app->getpk()  == ""){
            $fields['dt_solit_liberacao'] =$solicitacao_liberacao_app->getdt_solit_liberacao();
            $fields["dt_cadastro"] = "sysdate()";
            if($this->arrToken['usuarios_pk']==""){
                $fields["usuario_cadastro_pk"]   = 1;
            }else{
                $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
            }         
       
            $pk = $this->db->execInsert("ponto_solicitacao_liberacao_app", $fields);
            return $pk;
        }
        else{

            if($solicitacao_liberacao_app->getic_status()==1){
                $fields['dt_liberacao'] = "sysdate()";
            }else{
                $fields['dt_liberacao'] = $solicitacao_liberacao_app->getdt_liberacao();
            }
            
            return $this->db->execUpdate("ponto_solicitacao_liberacao_app", $fields, "  pk = ".$solicitacao_liberacao_app->getpk());
        }

    }

    public function excluir($solicitacao_liberacao_app){
        $this->db->execDelete("ponto_solicitacao_liberacao_app"," pk = ".$solicitacao_liberacao_app->getpk());
    }

    public function carregarPorPk($pk){
        $solicitacao_liberacao_app = new solicitacao_liberacao_app();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_pin ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,id_cliente ";
        $sql.="       ,ds_imagem ";
        $sql.="       ,dt_solit_liberacao ";
        $sql.="       ,ds_aparelho ";
        $sql.="       ,dt_liberacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";


        $sql.="  from ponto_solicitacao_liberacao_app ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $solicitacao_liberacao_app->setpk($query[$i]["pk"]);
                $solicitacao_liberacao_app->setdt_cadastro($query[$i]["dt_cadastro"]);
                $solicitacao_liberacao_app->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $solicitacao_liberacao_app->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $solicitacao_liberacao_app->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $solicitacao_liberacao_app->setds_pin($query[$i]['ds_pin']);
                $solicitacao_liberacao_app->setcolaborador_pk($query[$i]['colaborador_pk']);
                $solicitacao_liberacao_app->setid_cliente($query[$i]['id_cliente']);
                $solicitacao_liberacao_app->setds_imagem($query[$i]['ds_imagem']);
                $solicitacao_liberacao_app->setdt_solit_liberacao($query[$i]['dt_solit_liberacao']);
                $solicitacao_liberacao_app->setds_aparelho($query[$i]['ds_aparelho']);
                $solicitacao_liberacao_app->setdt_liberacao($query[$i]['dt_liberacao']);
                $solicitacao_liberacao_app->setusuario_aprovacao_pk($query[$i]['usuario_aprovacao_pk']);
                $solicitacao_liberacao_app->setobs($query[$i]['obs']);
                $solicitacao_liberacao_app->setic_status($query[$i]['ic_status']);

            }
        }
        return $solicitacao_liberacao_app;
    }
    
    public function loginPontoApp($ds_pin,$colaborador_pk){

        $sql ="";
        $sql.="select psl.pk, psl.dt_cadastro, psl.usuario_cadastro_pk, psl.dt_ult_atualizacao, psl.usuario_ult_atualizacao_pk  ";
        $sql.="       ,psl.ds_pin ";
        $sql.="       ,psl.id_cliente ";
        $sql.="       ,psl.ds_imagem ";
        $sql.="       ,psl.dt_solit_liberacao ";
        $sql.="       ,psl.ds_aparelho ";
        $sql.="       ,psl.dt_liberacao ";
        $sql.="       ,psl.usuario_aprovacao_pk ";
        $sql.="       ,psl.obs ";
        $sql.="       ,psl.ic_status ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,ct.ds_conta ";
        $sql.="       ,c.pk colaborador_pk ";
        $sql.="  from ponto_solicitacao_liberacao_app psl";
        $sql.="  inner join colaboradores c on psl.colaborador_pk = c.pk";
        $sql.="  left join contas ct on psl.id_cliente = ct.id_cliente";
        $sql.=" where psl.ds_pin = '$ds_pin'";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarPorPk($pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_pin ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,id_cliente ";
        $sql.="       ,ds_imagem ";
        $sql.="       ,dt_solit_liberacao ";
        $sql.="       ,ds_aparelho ";
        $sql.="       ,dt_liberacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";
        $sql.="  from ponto_solicitacao_liberacao_app ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_solicitacoes($colaborador_pk,$ds_pin,$ds_re,$ic_status){

        $sql ="";
        $sql.="select psl.pk, psl.dt_cadastro, psl.usuario_cadastro_pk, psl.dt_ult_atualizacao, psl.usuario_ult_atualizacao_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,psl.colaborador_pk ";
        $sql.="       ,psl.ds_pin ";
        $sql.="       ,c.ds_re "; 
        $sql.="       ,psl.ds_imagem ";
        $sql.="       ,date_format(psl.dt_solit_liberacao,'%d/%m/%Y %H:%m:%s')dt_solit_liberacao  ";
        $sql.="       ,date_format(psl.dt_liberacao,'%d/%m/%Y %H:%m:%s')dt_liberacao ";
        $sql.="       ,psl.usuario_aprovacao_pk ";
        $sql.="       ,u.ds_usuario";
        $sql.="       ,psl.obs ";
        $sql.="       ,case when psl.ic_status = 1 then 'Liberado' when psl.ic_status = 2 then 'Pendente' end status  ";
        $sql.="  from ponto_solicitacao_liberacao_app psl ";
        $sql.="  inner join colaboradores c on psl.colaborador_pk = c.pk";
        $sql.="  left join usuarios u on psl.usuario_aprovacao_pk = u.pk";
        $sql.=" where 1=1 ";
        $sql.=" and c.ic_status = 1 ";

        if($colaborador_pk != ""){
            $sql.=" and psl.colaborador_pk =".$colaborador_pk;
        }        
        
        if($ds_pin != ""){
            $sql.=" and psl.ds_pin like '%".$ds_pin."%' ";
        }

        if($ds_re != ""){
            $sql.=" and c.ds_re =".$ds_re;
        }

        if($ic_status != ""){
            $sql.=" and psl.ic_status =".$ic_status;
        }
        
        $sql.=" order by psl.dt_solit_liberacao asc ";
  
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_pin ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,id_cliente ";
        $sql.="       ,ds_imagem ";
        $sql.="       ,dt_solit_liberacao ";
        $sql.="       ,ds_aparelho ";
        $sql.="       ,dt_liberacao ";
        $sql.="       ,usuario_aprovacao_pk ";
        $sql.="       ,obs ";
        $sql.="       ,ic_status ";

        $sql.="  from ponto_solicitacao_liberacao_app ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_pin asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarQtdeRegistro($ic_status,$colaborador_pk,$dt_liberacao){

        $sql ="";
        $sql.="select count(0)qtde_registro ";

        $sql.="  from ponto_solicitacao_liberacao_app ";
        $sql.=" where 1=1 ";
        if($ic_status!=""){
            $sql.=" and ic_status = ".$ic_status;
        }
        if($colaborador_pk!=""){
            $sql.=" and colaborador_pk = ".$colaborador_pk;
        }
        //if($dt_liberacao!=""){
            $sql.=" and dt_liberacao is not null";
        //}

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
