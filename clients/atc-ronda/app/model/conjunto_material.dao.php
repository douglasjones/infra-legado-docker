<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/conjunto_material.class.php';


class conjunto_materialdao{

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
    
    public function salvar($conjunto_material){

        $fields = array();
        $fields['colaborador_pk'] = $conjunto_material->getcolaborador_pk();
        $fields['leads_pk'] = $conjunto_material->getleads_pk();
        $fields['contratos_pk'] = $conjunto_material->getcontratos_pk();
        $fields['ds_conjunto_material'] = $conjunto_material->getds_conjunto_material();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($conjunto_material->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("conjunto_material", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("conjunto_material", $fields, " pk = ".$conjunto_material->getpk());
        }

    }

    public function excluir($conjunto_material){
        $this->db->execDelete("conjunto_material"," pk = ".$conjunto_material->getpk());
    }
    public function pegarPkConjuntoMaterial0($contrato_pk){
        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";

        $sql.="  from conjunto_material ";
        
        $sql.=" where contratos_pk = 0";
        
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function pegarPkMaterial0($contrato_pk){
        $sql ="";
        $sql.="select pk";

        $sql.="  from movimentacao_estoque ";
        
        $sql.=" where contratos_pk = 0";
        
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function excluirConjuntoMaterial0($pk){
        $this->db->execDelete("conjunto_material"," pk =".$pk);
    }
    public function excluirMaterial0($pk){
        $this->db->execDelete("movimentacao_estoque"," pk = ".$pk);
    }

    public function carregarPorPk($pk){

        $conjunto_material = new conjunto_material();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";


        $sql.="  from conjunto_material ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $conjunto_material->setpk($query[$i]["pk"]);
                $conjunto_material->setdt_cadastro($query[$i]["dt_cadastro"]);
                $conjunto_material->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $conjunto_material->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $conjunto_material->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $conjunto_material->setcolaborador_pk($query[$i]['colaborador_pk']);
                $conjunto_material->setleads_pk($query[$i]['leads_pk']);

            }
        }
        return $conjunto_material;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";

        $sql.="  from conjunto_material ";
        if($pk!=""){
            $sql.=" where pk = $pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarColaboradorPk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";

        $sql.="  from conjunto_material ";
        if($colaborador_pk!=""){
            $sql.=" where colaborador_pk = $colaborador_pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarMovimentarMaterialProd($colaborador_pk,$leads_pk,$categoria_pk,$produtos_pk,$dt_movimentacao_ini,$dt_movimentacao_fim,$grupo_para_movimentacao_pk,$contratos_pk){


        //PAGINAÇÃO
        if(isset($_POST['start']) && $_POST['start']!=0){
            $displayStart = $_POST['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_POST['length'])){
            $displayRange = $_POST['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";
        if (isset($_POST['search']['value']) and $_POST['search']['value'] != '') {
            $pesq = $_POST['search']['value'];
            $search .= " AND (
                            cp.ds_categoria LIKE '%".$pesq."%' 
                            )";
        }

        //if($leads_pk != ''){
            $sql ="";
            $sql.="select me.pk,";
            $sql.=" me.grupo_para_movimentacao_pk,";
            $sql.=" cm.pk conjunto_material_pk,";
            $sql.=" cm.ds_conjunto_material,";
            $sql.=" date_format(me.dt_cadastro,'%d/%m/%Y')dt_cadastro,";
            $sql.=" case me.grupo_para_movimentacao_pk when 1 then 'Colaborador' when 2 then 'Posto de Trabalho' end ds_grupo_movimentado,";
            $sql.=" me.colaborador_pk,me.leads_pk,me.contratos_pk,cp.ds_categoria,pi.pk produto_iten_pk, p.ds_produto,sum(me.qtde)qtde";

            $sql.="  from movimentacao_estoque me";
            $sql.="  inner join conjunto_material cm  on cm.pk = me.conjunto_material_pk";
            $sql.="  inner join produtos_itens pi on me.produtos_itens_pk = pi.pk";
            $sql.="  inner join produtos p on pi.produtos_pk = p.pk";
            $sql.="  inner join categorias_produto cp on p.categorias_produto_pk = cp.pk";
            $sql.="  where 1=1";
            $sql.= $search;
            if($colaborador_pk!=""){
                $sql.=" and me.colaborador_pk = $colaborador_pk ";
            }
            if($leads_pk!=""){
                $sql.=" and me.leads_pk = $leads_pk ";
            }
            if($contratos_pk!=""){
                $sql.=" and me.contratos_pk = $contratos_pk ";
            }
            if($categoria_pk!=""){
                $sql.=" and cp.pk= $categoria_pk ";
            }
            if($produtos_pk!=""){
                $sql.=" and p.pk= $produtos_pk ";
            }
            if($dt_movimentacao_ini!=""){
                $sql.=" and me.dt_cadastro between '".DataYMD($dt_movimentacao_ini)." 00:00:00' and '".DataYMD($dt_movimentacao_fim)." 23:59:59'";
            }
            if($grupo_para_movimentacao_pk!=""){
                if($grupo_para_movimentacao_pk==1){
                    $sql.=" and cm.leads_pk is null";
                }
                if($grupo_para_movimentacao_pk==2){
                    $sql.=" and cm.colaborador_pk is null";
                }
            }
            $sql.= " group by cm.pk";
            $sql.= " ORDER BY me.dt_cadastro desc";
            
            //PEGA TODOS OS REGISTROS
            $queryCount = $this->db->execQuery($sql);
            //PEGA OS REGISTROS DA PAGINAÇÃO
            $query = $this->db->execQuery($sql.$lengthSql);

            $arrRetorno = [];
            $arrRetorno['query'] = $query;
            $arrRetorno['count'] = count($queryCount);
            return $arrRetorno;
        //}else{
        //    return $result = [];
        //}
        
        

    }
    public function listarQtde($conjunto_material_pk){
        $sql.="select count(0) qtde";

        $sql.="  from movimentacao_estoque me";
        $sql.="  where 1=1";
        if($conjunto_material_pk!=""){
            $sql.=" and me.conjunto_material_pk = $conjunto_material_pk ";
        }
       

        $query = $this->db->execQuery($sql);
        return $query;
    }
    public function pegarNomeColaborador($colaborador_pk){

        $sql ="";
        $sql.="select c.ds_colaborador";

        $sql.="  from colaboradores c";
        if($colaborador_pk!=""){
            $sql.=" where c.pk = $colaborador_pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function pegarNomeLead($leads_pk){

        $sql ="";
        $sql.="select l.ds_lead";

        $sql.="  from leads l";
        if($leads_pk!=""){
            $sql.=" where l.pk = $leads_pk ";
        }
        
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_colaborador_pk($colaborador_pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";

        $sql.="  from conjunto_material ";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and ds_conjunto_material like '%".$colaborador_pk."%' ";
        }
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,leads_pk ";
        $sql.="       ,ds_conjunto_material";
       
        $sql.="  from conjunto_material ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
