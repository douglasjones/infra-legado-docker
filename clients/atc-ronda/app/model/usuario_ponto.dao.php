<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/usuario_ponto.class.php';


class usuario_pontodao{

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
    
    public function salvar($usuario_ponto){
        
        $fields = array();
        if($usuario_ponto->gethr_entrada_dom()==""){
            $fields['hr_entrada_dom'] = "null";
        }
        else{
            $fields['hr_entrada_dom'] = $usuario_ponto->gethr_entrada_dom();
        }
        if($usuario_ponto->gethr_saida_dom()==""){
            $fields['hr_saida_dom'] = "null";
        }
        else{
            $fields['hr_saida_dom'] = $usuario_ponto->gethr_saida_dom();
        }
        if($usuario_ponto->gethr_entrada_seg()==""){
            $fields['hr_entrada_seg'] = "null";
        }
        else{
            $fields['hr_entrada_seg'] = $usuario_ponto->gethr_entrada_seg();
        }
        if($usuario_ponto->gethr_saida_seg()==""){
            $fields['hr_saida_seg'] = "null";
        }
        else{
            $fields['hr_saida_seg'] = $usuario_ponto->gethr_saida_seg();
        }
        if($usuario_ponto->gethr_entrada_ter()==""){
            $fields['hr_entrada_ter'] = "null";
        }
        else{
            $fields['hr_entrada_ter'] = $usuario_ponto->gethr_entrada_ter();
        }
        if($usuario_ponto->gethr_saida_ter()==""){
            $fields['hr_saida_ter'] = "null";
        }
        else{
            $fields['hr_saida_ter'] = $usuario_ponto->gethr_saida_ter();
        }
        if($usuario_ponto->gethr_entrada_qua()==""){
            $fields['hr_entrada_qua'] = "null";
        }
        else{
            $fields['hr_entrada_qua'] = $usuario_ponto->gethr_entrada_qua();
        }
        if($usuario_ponto->gethr_saida_qua()==""){
            $fields['hr_saida_qua'] = "null";
        }
        else{
            $fields['hr_saida_qua'] = $usuario_ponto->gethr_saida_qua();
        }
        if($usuario_ponto->gethr_entrada_qui()==""){
            $fields['hr_entrada_qui'] = "null";
        }
        else{
            $fields['hr_entrada_qui'] = $usuario_ponto->gethr_entrada_qui();
        }
        if($usuario_ponto->gethr_saida_qui()==""){
            $fields['hr_saida_qui'] = "null";
        }
        else{
            $fields['hr_saida_qui'] = $usuario_ponto->gethr_saida_qui();
        }
        if($usuario_ponto->gethr_entrada_sex()==""){
            $fields['hr_entrada_sex'] = "null";
        }
        else{
            $fields['hr_entrada_sex'] = $usuario_ponto->gethr_entrada_sex();
        }
        if($usuario_ponto->gethr_saida_sex()==""){
            $fields['hr_saida_sex'] = "null";
        }
        else{
            $fields['hr_saida_sex'] = $usuario_ponto->gethr_saida_sex();
        }
        if($usuario_ponto->gethr_entrada_sab()==""){
            $fields['hr_entrada_sab'] = "null";
        }
        else{
            $fields['hr_entrada_sab'] = $usuario_ponto->gethr_entrada_sab();
        }
        if($usuario_ponto->gethr_entrada_sab()==""){
            $fields['hr_saida_sab'] = "null";
        }
        else{
            $fields['hr_saida_sab'] = $usuario_ponto->gethr_saida_sab();
        }
        
        $fields['ic_dom'] = $usuario_ponto->getic_dom();
        $fields['ic_seg'] = $usuario_ponto->getic_seg();
        $fields['ic_ter'] = $usuario_ponto->getic_ter();
        $fields['ic_qua'] = $usuario_ponto->getic_qua();
        $fields['ic_qui'] = $usuario_ponto->getic_qui();
        $fields['ic_sex'] = $usuario_ponto->getic_sex();
        $fields['ic_sab'] = $usuario_ponto->getic_sab();
        $fields['colaborador_pk'] = $usuario_ponto->getcolaborador_pk();
        
        if($usuario_ponto->getturnos_pk_dom()==""){
            $fields['turnos_pk_dom'] = "null";
        }
        else{
            $fields['turnos_pk_dom'] = $usuario_ponto->getturnos_pk_dom();
        }
        if($usuario_ponto->getturnos_pk_seg()==""){
            $fields['turnos_pk_seg'] = "null";
        }
        else{
            $fields['turnos_pk_seg'] = $usuario_ponto->getturnos_pk_seg();
        }
        if($usuario_ponto->getturnos_pk_ter()==""){
            $fields['turnos_pk_ter'] = "null";
        }
        else{
            $fields['turnos_pk_ter'] = $usuario_ponto->getturnos_pk_ter();
        }
        if($usuario_ponto->getturnos_pk_qua()==""){
            $fields['turnos_pk_qua'] = "null";
        }
        else{
            $fields['turnos_pk_qua'] = $usuario_ponto->getturnos_pk_qua();
        }
        if($usuario_ponto->getturnos_pk_qui()==""){
            $fields['turnos_pk_qui'] = "null";
        }
        else{
            $fields['turnos_pk_qui'] = $usuario_ponto->getturnos_pk_qui();
        }
        if($usuario_ponto->getturnos_pk_sex()==""){
            $fields['turnos_pk_sex'] = "null";
        }
        else{
            $fields['turnos_pk_sex'] = $usuario_ponto->getturnos_pk_sex();
        }
        if($usuario_ponto->getturnos_pk_sab()==""){
            $fields['turnos_pk_sab'] = "null";
        }
        else{
            $fields['turnos_pk_sab'] = $usuario_ponto->getturnos_pk_sab();
        }
        $fields['usuarios_pk'] = $usuario_ponto->getusuarios_pk();
        $fields['ic_registrar_ponto'] = $usuario_ponto->getic_registrar_ponto();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($usuario_ponto->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("usuario_ponto", $fields);
            return $pk;
        }
        else{
            return $this->db->execUpdate("usuario_ponto", $fields, " pk = ".$usuario_ponto->getpk());
        }

    }

    public function excluir($usuario_ponto){
        $this->db->execDelete("usuario_ponto"," pk = ".$usuario_ponto->getpk());
    }

    public function carregarPorPk($pk){

        $usuario_ponto = new usuario_ponto();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,hr_entrada_dom ";
        $sql.="       ,hr_saida_dom ";
        $sql.="       ,hr_entrada_seg ";
        $sql.="       ,hr_saida_seg ";
        $sql.="       ,hr_entrada_ter ";
        $sql.="       ,hr_saida_ter ";
        $sql.="       ,hr_entrada_qua ";
        $sql.="       ,hr_saida_qua ";
        $sql.="       ,hr_entrada_qui ";
        $sql.="       ,hr_saida_qui ";
        $sql.="       ,hr_entrada_sex ";
        $sql.="       ,hr_saida_sex ";
        $sql.="       ,hr_entrada_sab ";
        $sql.="       ,hr_saida_sab ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,turnos_pk_dom ";
        $sql.="       ,turnos_pk_seg ";
        $sql.="       ,turnos_pk_ter ";
        $sql.="       ,turnos_pk_qua ";
        $sql.="       ,turnos_pk_qui ";
        $sql.="       ,turnos_pk_sex ";
        $sql.="       ,turnos_pk_sab ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,colaborador_pk";
        $sql.="       ,ic_registrar_ponto";


        $sql.="  from usuario_ponto ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $usuario_ponto->setpk($query[$i]["pk"]);
                $usuario_ponto->setdt_cadastro($query[$i]["dt_cadastro"]);
                $usuario_ponto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $usuario_ponto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $usuario_ponto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $usuario_ponto->sethr_entrada_dom($query[$i]['hr_entrada_dom']);
                $usuario_ponto->sethr_saida_dom($query[$i]['hr_saida_dom']);
                $usuario_ponto->sethr_entrada_seg($query[$i]['hr_entrada_seg']);
                $usuario_ponto->sethr_saida_seg($query[$i]['hr_saida_seg']);
                $usuario_ponto->sethr_entrada_ter($query[$i]['hr_entrada_ter']);
                $usuario_ponto->sethr_saida_ter($query[$i]['hr_saida_ter']);
                $usuario_ponto->sethr_entrada_qua($query[$i]['hr_entrada_qua']);
                $usuario_ponto->sethr_saida_qua($query[$i]['hr_saida_qua']);
                $usuario_ponto->sethr_entrada_qui($query[$i]['hr_entrada_qui']);
                $usuario_ponto->sethr_saida_qui($query[$i]['hr_saida_qui']);
                $usuario_ponto->sethr_entrada_sex($query[$i]['hr_entrada_sex']);
                $usuario_ponto->sethr_saida_sex($query[$i]['hr_saida_sex']);
                $usuario_ponto->sethr_entrada_sab($query[$i]['hr_entrada_sab']);
                $usuario_ponto->sethr_saida_sab($query[$i]['hr_saida_sab']);
                $usuario_ponto->setic_dom($query[$i]['ic_dom']);
                $usuario_ponto->setic_seg($query[$i]['ic_seg']);
                $usuario_ponto->setic_ter($query[$i]['ic_ter']);
                $usuario_ponto->setic_qua($query[$i]['ic_qua']);
                $usuario_ponto->setic_qui($query[$i]['ic_qui']);
                $usuario_ponto->setic_sex($query[$i]['ic_sex']);
                $usuario_ponto->setic_sab($query[$i]['ic_sab']);
                $usuario_ponto->setturnos_pk_dom($query[$i]['turnos_pk_dom']);
                $usuario_ponto->setturnos_pk_seg($query[$i]['turnos_pk_seg']);
                $usuario_ponto->setturnos_pk_ter($query[$i]['turnos_pk_ter']);
                $usuario_ponto->setturnos_pk_qua($query[$i]['turnos_pk_qua']);
                $usuario_ponto->setturnos_pk_qui($query[$i]['turnos_pk_qui']);
                $usuario_ponto->setturnos_pk_sex($query[$i]['turnos_pk_sex']);
                $usuario_ponto->setturnos_pk_sab($query[$i]['turnos_pk_sab']);
                $usuario_ponto->setusuarios_pk($query[$i]['usuarios_pk']);
                $usuario_ponto->setcolaborador_pk($query[$i]['colaborador_pk']);
                $usuario_ponto->setic_registrar_ponto($query[$i]['ic_registrar_ponto']);

            }
        }
        return $usuario_ponto;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,hr_entrada_dom ";
        $sql.="       ,hr_saida_dom ";
        $sql.="       ,hr_entrada_seg ";
        $sql.="       ,hr_saida_seg ";
        $sql.="       ,hr_entrada_ter ";
        $sql.="       ,hr_saida_ter ";
        $sql.="       ,hr_entrada_qua ";
        $sql.="       ,hr_saida_qua ";
        $sql.="       ,hr_entrada_qui ";
        $sql.="       ,hr_saida_qui ";
        $sql.="       ,hr_entrada_sex ";
        $sql.="       ,hr_saida_sex ";
        $sql.="       ,hr_entrada_sab ";
        $sql.="       ,hr_saida_sab ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,turnos_pk_dom ";
        $sql.="       ,turnos_pk_seg ";
        $sql.="       ,turnos_pk_ter ";
        $sql.="       ,turnos_pk_qua ";
        $sql.="       ,turnos_pk_qui ";
        $sql.="       ,turnos_pk_sex ";
        $sql.="       ,turnos_pk_sab ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,colaborador_pk";
        $sql.="       ,ic_registrar_ponto";

        $sql.="  from usuario_ponto ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listar_por_hr_entrada_dom($hr_entrada_dom){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,hr_entrada_dom ";
        $sql.="       ,hr_saida_dom ";
        $sql.="       ,hr_entrada_seg ";
        $sql.="       ,hr_saida_seg ";
        $sql.="       ,hr_entrada_ter ";
        $sql.="       ,hr_saida_ter ";
        $sql.="       ,hr_entrada_qua ";
        $sql.="       ,hr_saida_qua ";
        $sql.="       ,hr_entrada_qui ";
        $sql.="       ,hr_saida_qui ";
        $sql.="       ,hr_entrada_sex ";
        $sql.="       ,hr_saida_sex ";
        $sql.="       ,hr_entrada_sab ";
        $sql.="       ,hr_saida_sab ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,turnos_pk_dom ";
        $sql.="       ,turnos_pk_seg ";
        $sql.="       ,turnos_pk_ter ";
        $sql.="       ,turnos_pk_qua ";
        $sql.="       ,turnos_pk_qui ";
        $sql.="       ,turnos_pk_sex ";
        $sql.="       ,turnos_pk_sab ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,colaborador_pk";
        $sql.="       ,ic_registrar_ponto";

        $sql.="  from usuario_ponto ";
        $sql.=" where 1=1 ";
        if($hr_entrada_dom != ""){
            $sql.=" and ds_usuario_ponto like '%".$hr_entrada_dom."%' ";
        }
        $sql.=" order by hr_entrada_dom asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,hr_entrada_dom ";
        $sql.="       ,hr_saida_dom ";
        $sql.="       ,hr_entrada_seg ";
        $sql.="       ,hr_saida_seg ";
        $sql.="       ,hr_entrada_ter ";
        $sql.="       ,hr_saida_ter ";
        $sql.="       ,hr_entrada_qua ";
        $sql.="       ,hr_saida_qua ";
        $sql.="       ,hr_entrada_qui ";
        $sql.="       ,hr_saida_qui ";
        $sql.="       ,hr_entrada_sex ";
        $sql.="       ,hr_saida_sex ";
        $sql.="       ,hr_entrada_sab ";
        $sql.="       ,hr_saida_sab ";
        $sql.="       ,ic_dom ";
        $sql.="       ,ic_seg ";
        $sql.="       ,ic_ter ";
        $sql.="       ,ic_qua ";
        $sql.="       ,ic_qui ";
        $sql.="       ,ic_sex ";
        $sql.="       ,ic_sab ";
        $sql.="       ,turnos_pk_dom ";
        $sql.="       ,turnos_pk_seg ";
        $sql.="       ,turnos_pk_ter ";
        $sql.="       ,turnos_pk_qua ";
        $sql.="       ,turnos_pk_qui ";
        $sql.="       ,turnos_pk_sex ";
        $sql.="       ,turnos_pk_sab ";
        $sql.="       ,usuarios_pk ";
        $sql.="       ,colaborador_pk";
        $sql.="       ,ic_registrar_ponto";

        $sql.="  from usuario_ponto ";
        $sql.=" where 1=1 ";
        $sql.=" order by hr_entrada_dom asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
