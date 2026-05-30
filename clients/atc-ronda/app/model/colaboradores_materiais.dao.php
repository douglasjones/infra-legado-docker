<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaboradores_materiais.class.php';


class colaboradores_materiaisdao{

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
    
    public function salvar($colaboradores_materiais){

        $fields = array();
        $fields['tipo_material_pk'] = $colaboradores_materiais->gettipo_material_pk();
        $fields['material_pk'] = $colaboradores_materiais->getmaterial_pk();
        $fields['qtde_material'] = $colaboradores_materiais->getqtde_material();
        $fields['dt_entrega'] = $colaboradores_materiais->getdt_entrega();
        $fields['dt_devolucao'] = $colaboradores_materiais->getdt_devolucao();
        $fields['obs'] = $colaboradores_materiais->getobs();
        $fields['colaborador_pk'] = $colaboradores_materiais->getcolaborador_pk();
        $fields['conjunto_material_pk'] = $colaboradores_materiais->getconjunto_material_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaboradores_materiais->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_materiais", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("colaboradores_materiais", $fields, " pk = ".$colaboradores_materiais->getpk());
        }

    }

    public function excluir($colaboradores_materiais){
        $this->db->execDelete("colaboradores_materiais"," pk = ".$colaboradores_materiais->getpk());
    }

    public function carregarPorPk($pk){

        $colaboradores_materiais = new colaboradores_materiais();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,tipo_material_pk ";
        $sql.="       ,material_pk ";
        $sql.="       ,qtde_material ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,dt_devolucao ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,conjunto_material_pk";


        $sql.="  from colaboradores_materiais ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaboradores_materiais->setpk($query[$i]["pk"]);
                $colaboradores_materiais->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaboradores_materiais->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaboradores_materiais->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaboradores_materiais->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaboradores_materiais->settipo_material_pk($query[$i]['tipo_material_pk']);
                $colaboradores_materiais->setmaterial_pk($query[$i]['material_pk']);
                $colaboradores_materiais->setqtde_material($query[$i]['qtde_material']);
                $colaboradores_materiais->setdt_entrega($query[$i]['dt_entrega']);
                $colaboradores_materiais->setdt_devolucao($query[$i]['dt_devolucao']);
                $colaboradores_materiais->setobs($query[$i]['obs']);
                $colaboradores_materiais->setcolaborador_pk($query[$i]['colaborador_pk']);
                $colaboradores_materiais->setconjunto_material_pk($query[$i]['conjunto_material_pk']);

            }
        }
        return $colaboradores_materiais;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,tipo_material_pk ";
        $sql.="       ,material_pk ";
        $sql.="       ,qtde_material ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,dt_devolucao ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,conjunto_material_pk";

        $sql.="  from colaboradores_materiais ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_tipo_material_pk($tipo_material_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_material_pk ";
        $sql.="       ,material_pk ";
        $sql.="       ,qtde_material ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,dt_devolucao ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,conjunto_material_pk";

        $sql.="  from colaboradores_materiais ";
        $sql.=" where 1=1 ";
        if($tipo_material_pk != ""){
            $sql.=" and ds_colaboradores_materiais like '%".$tipo_material_pk."%' ";
        }
        $sql.=" order by tipo_material_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,tipo_material_pk ";
        $sql.="       ,material_pk ";
        $sql.="       ,qtde_material ";
        $sql.="       ,dt_entrega ";
        $sql.="       ,dt_devolucao ";
        $sql.="       ,obs ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,conjunto_material_pk";

        $sql.="  from colaboradores_materiais ";
        $sql.=" where 1=1 ";
        $sql.=" order by tipo_material_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
}
?>
