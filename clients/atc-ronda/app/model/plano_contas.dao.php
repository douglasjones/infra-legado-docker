<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/plano_contas.class.php';


class plano_contasdao{

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
    
    public function salvar($plano_contas){

        $fields = array();
        $fields['ds_tipo_operacao'] = $plano_contas->getds_tipo_operacao();
        $fields['ic_status'] = $plano_contas->getic_status();
        $fields['categorias_financeiras_pk'] = $plano_contas->getcategorias_financeiras_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($plano_contas->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("tipos_operacao", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("tipos_operacao", $fields, " pk = ".$plano_contas->getpk());
        }

    }

    public function excluir($plano_contas){
        $this->db->execDelete("tipos_operacao"," pk = ".$plano_contas->getpk());
    }

    public function carregarPorPk($pk){

        $plano_contas = new plano_contas();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ds_tipo_operacao ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_financeiras_pk ";


        $sql.="  from tipos_operacao ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $plano_contas->setpk($query[$i]["pk"]);
                $plano_contas->setdt_cadastro($query[$i]["dt_cadastro"]);
                $plano_contas->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $plano_contas->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $plano_contas->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $plano_contas->setds_tipo_operacao($query[$i]['ds_tipo_operacao']);
                $plano_contas->setic_status($query[$i]['ic_status']);
                $plano_contas->setcategorias_financeiras_pk($query[$i]['categorias_financeiras_pk']);

            }
        }
        return $plano_contas;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ds_tipo_operacao ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_financeiras_pk ";

        $sql.="  from tipos_operacao ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listaPorCategoria($categorias_financeiras_pk){

        $sql ="";
        $sql.="select toc.pk, toc.dt_cadastro, toc.usuario_cadastro_pk, toc.dt_ult_atualizacao, toc.usuario_ult_atualizacao_pk  ";
        $sql.="       ,concat(cf.ds_categoria,' - ',toc.ds_tipo_operacao )ds_tipo_operacao";
        $sql.="       ,toc.ic_status ";
        $sql.="       ,toc.categorias_financeiras_pk ";

        $sql.="  from tipos_operacao toc";
        $sql.="  inner join categorias_financeiras cf on cf.pk = toc.categorias_financeiras_pk";        
        $sql.=" where cf.ic_status =  1";
        if(!empty($categorias_financeiras_pk)){
            $sql.=" AND toc.categorias_financeiras_pk = $categorias_financeiras_pk ";
        }            
        $sql.=" order by cf.ds_categoria,toc.ds_tipo_operacao ";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listar_por_ds_tipo_operacao($ds_tipo_operacao,$categorias_financeiras_pk,$ic_status){
        $sql ="";
        $sql.="select tp.pk, tp.dt_cadastro, tp.usuario_cadastro_pk, tp.dt_ult_atualizacao, tp.usuario_ult_atualizacao_pk ";
        $sql.="       ,tp.ds_tipo_operacao ";
        $sql.="       ,case when tp.ic_status = 1 then 'Ativo' ELSE 'Desativado' END ds_status ";
        $sql.="       ,tp.categorias_financeiras_pk ";
        $sql.="       ,cf.ds_categoria ";
        
        $sql.="  from tipos_operacao tp ";
        $sql.=" inner join categorias_financeiras cf on tp.categorias_financeiras_pk = cf.pk ";
        $sql.=" where 1=1 ";
        
        if($categorias_financeiras_pk != ""){
            $sql.=" and tp.categorias_financeiras_pk = ".$categorias_financeiras_pk;
        }
        
        if($ds_tipo_operacao != ""){
            $sql.=" and tp.ds_tipo_operacao like '%".$ds_tipo_operacao."%' ";
        }
        
        if($ic_status != ""){
            $sql.=" and tp.ic_status = ".$ic_status;
        }
        
        $sql.=" order by tp.ds_tipo_operacao asc ";
       
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tipo_operacao ";
        $sql.="       ,ic_status ";
        $sql.="       ,categorias_financeiras_pk ";

        $sql.="  from tipos_operacao ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_tipo_operacao asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
