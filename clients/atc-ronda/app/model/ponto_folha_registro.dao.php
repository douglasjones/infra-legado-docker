<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/ponto_folha_registro.class.php';

require_once "../model/ponto_folha.dao.php";
require_once "../model/ponto_folha.class.php";
require_once "../model/ponto.dao.php";
require_once "../model/ponto.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";
require_once "../model/agenda_colaborador_padrao.dao.php";
require_once "../model/agenda_colaborador_padrao.class.php";


class ponto_folha_registrodao{

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
    
    public function salvar($ponto_folha_registro){ 

        $fields = array();
        $fields['ponto_pk'] = $ponto_folha_registro->getponto_pk();
        $fields['tipo_ponto_pk'] = $ponto_folha_registro->gettipo_ponto_pk();
        if($ponto_folha_registro->getdt_hora_ponto()!=""){
            $fields['dt_hora_ponto'] = ($ponto_folha_registro->getdt_hora_ponto());
        }
        
        $fields['colaborador_pk'] = $ponto_folha_registro->getcolaborador_pk();
        $fields['ponto_folha_pk'] = $ponto_folha_registro->getponto_folha_pk();
        $fields['hr_ini_expediente'] = $ponto_folha_registro->gethr_ini_expediente();
        $fields['hr_ini_intervalo'] = $ponto_folha_registro->gethr_ini_intervalo();
        $fields['hr_fim_intervalo'] = $ponto_folha_registro->gethr_fim_intervalo();
        $fields['hr_fim_expediente'] = $ponto_folha_registro->gethr_fim_expediente();
        $fields['hr_trabalhadas'] = $ponto_folha_registro->gethr_trabalhadas();
        $fields['hr_excedente'] = $ponto_folha_registro->gethr_excedente();
        $fields['hr_faltantes'] = $ponto_folha_registro->gethr_faltantes();
        $fields['hr_extra50'] = $ponto_folha_registro->gethr_extra50();           
        $fields['hr_extra100'] = $ponto_folha_registro->gethr_extra100();                 
        $fields['hr_adicional_noturno'] = $ponto_folha_registro->gethr_adicional_noturno();
        $fields['ic_status'] = $ponto_folha_registro->getic_status();

        $fields['obs'] = $ponto_folha_registro->getobs();        
 
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($ponto_folha_registro->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]  = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("ponto_folha_registros", $fields);
            /*echo $this->db->getLastSQL();
            exit;*/
            return $pk;
        }
        else{
             $this->db->execUpdate("ponto_folha_registros", $fields, " pk = ".$ponto_folha_registro->getpk());
             //echo $this->db->getLastSQL();
        }

    }

    public function excluir($pk,$colaborador_pk){

        $this->db->execDelete("ponto_folha_registros"," ponto_folha_pk = ".$pk." and colaborador_pk=".$colaborador_pk ); 
         
    }

    public function ponto_folha_colaborador($pk,$colaborador_pk){
        $this->db->execDelete("ponto_folha_colaborador"," ponto_folha_pk = ".$pk." and colaborador_pk=".$colaborador_pk);  
         
    }
    
    public function carregarPorPk($pk){
        
        $ponto_folha_registro = new ponto_folha_registro();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ponto_pk ";
        $sql.="       ,tipo_ponto_pk ";
        $sql.="       ,dt_hora_ponto ";
        //$sql.="       ,tipo_registr_folha ";
        $sql.="       ,ponto_folha_pk ";


        $sql.="  from ponto_folha_registros ";
        $sql.=" where pk = $pk ";

            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ponto_folha_registro->setpk($query[$i]["pk"]);
                $ponto_folha_registro->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ponto_folha_registro->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ponto_folha_registro->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ponto_folha_registro->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ponto_folha_registro->setponto_pk($query[$i]['ponto_pk']);
                $ponto_folha_registro->settipo_ponto_pk($query[$i]['tipo_ponto_pk']);
                $ponto_folha_registro->setdt_hora_ponto($query[$i]['dt_hora_ponto']);
                //$ponto_folha_registro->settipo_registr_folha($query[$i]['tipo_registr_folha']);
                $ponto_folha_registro->setponto_folha_pk($query[$i]['ponto_folha_pk']);

            }
        }
        return $ponto_folha_registro;
    }
    
    public function listarFolhaRegistrosAgrupadoData($ponto_folha_pk,$colaborador_pk){
        
        $sql ="";
        $sql.="SELECT pf.pk ponto_folha_pk,";
        $sql.="        pfr.pk ponto_folha_registro_pk,";
        $sql.="        pfr.colaborador_pk,";
        $sql.="        date_format(pfr.dt_hora_ponto, '%d/%m/%Y') dt_ponto,";
        $sql.="        TIME_FORMAT(pfr.hr_ini_expediente, '%H:%i') hr_ini_expediente,";
        $sql.="        TIME_FORMAT(pfr.hr_fim_expediente, '%H:%i') hr_fim_expediente,";
        $sql.="        TIME_FORMAT(pfr.hr_ini_intervalo, '%H:%i') hr_ini_intervalo,";
        $sql.="        TIME_FORMAT(pfr.hr_fim_intervalo, '%H:%i') hr_fim_intervalo,";
        $sql.="        TIME_FORMAT(pfr.hr_trabalhadas, '%H:%i') hr_trabalhadas,";
        $sql.="        TIME_FORMAT(pfr.hr_excedente, '%H:%i') hr_excedentes,";
        $sql.="        TIME_FORMAT(pfr.hr_faltantes, '%H:%i') hr_faltantes,";
        $sql.="        TIME_FORMAT(pfr.hr_extra50, '%H:%i') hr_extra50,";
        $sql.="        TIME_FORMAT(pfr.hr_extra100, '%H:%i') hr_extra100,";
        $sql.="        TIME_FORMAT(pfr.hr_adicional_noturno, '%H:%i') hr_adicional_noturno,";
        $sql.="        TIME_FORMAT(pfr.hr_saldo, '%H:%i:%s') hr_saldo,";
        $sql.="        pfr.tipo_ponto_pk,"; 
        $sql.="        pfr.ic_status,"; 
        $sql.="        pfr.obs"; 
        $sql.=" FROM ponto_folha pf";
        $sql.="      INNER JOIN ponto_folha_registros pfr ON pf.pk = pfr.ponto_folha_pk";
        $sql.=" WHERE pf.pk = ".$ponto_folha_pk;        
        $sql.=" AND pfr.colaborador_pk =".$colaborador_pk;
        $sql.=" group by date_format(pfr.dt_hora_ponto, '%d/%m/%Y')";
        $sql.=" ORDER BY pfr.dt_hora_ponto";
        $query = $this->db->execQuery($sql);
        return $query;
    }

    /*public function listarFolhaRegistrosRHTipoImpressao($ponto_folha_pk,$colaborador_pk,$dt_registro){
        $sql ="";
        $sql.="SELECT date_format(pfr.dt_hora_ponto, '%d/%m/%Y') dt_ponto,";
        $sql.="        TIME_FORMAT(pfr.dt_hora_ponto, '%H:%i') hr_ponto,";
        $sql.="        pfr.tipo_ponto_pk";
        $sql.=" FROM ponto_folha_registros pfr";
        $sql.=" WHERE     pfr.ponto_folha_pk =".$ponto_folha_pk;
        $sql.="       AND pfr.colaborador_pk = ".$colaborador_pk;
        $sql.="       AND pfr.dt_hora_ponto >= '".DataYMD($dt_registro)." 00:00:00'";
        $sql.="       AND pfr.dt_hora_ponto <= '".DataYMD($dt_registro)." 23:29:29'";
        $sql.=" ORDER BY pfr.pk";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }*/
    
    public function carregarPorPontoPk($pk){

        $ponto_folha_registro = new ponto_folha_registro();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ponto_pk ";
        $sql.="       ,tipo_ponto_pk ";
        $sql.="       ,dt_hora_ponto ";
        $sql.="       ,tipo_registr_folha ";
        $sql.="       ,ponto_folha_pk ";


        $sql.="  from ponto_folha_registros ";
        $sql.=" where ponto_pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ponto_folha_registro->setpk($query[$i]["pk"]);
                $ponto_folha_registro->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ponto_folha_registro->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ponto_folha_registro->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ponto_folha_registro->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ponto_folha_registro->setponto_pk($query[$i]['ponto_pk']);
                $ponto_folha_registro->settipo_ponto_pk($query[$i]['tipo_ponto_pk']);
                $ponto_folha_registro->setdt_hora_ponto($query[$i]['dt_hora_ponto']);
                $ponto_folha_registro->settipo_registr_folha($query[$i]['tipo_registr_folha']);
                $ponto_folha_registro->setponto_folha_pk($query[$i]['ponto_folha_pk']);

            }
        }
        return $ponto_folha_registro;
    }

    public function carregarPorPontoFolhaPk($pk){

        $ponto_folha_registro = new ponto_folha_registro();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,ponto_pk ";
        $sql.="       ,tipo_ponto_pk ";
        $sql.="       ,dt_hora_ponto ";
        $sql.="       ,tipo_registr_folha ";
        $sql.="       ,ponto_folha_pk ";


        $sql.="  from ponto_folha_registros ";
        $sql.=" where ponto_folha_pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ponto_folha_registro->setpk($query[$i]["pk"]);
                $ponto_folha_registro->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ponto_folha_registro->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ponto_folha_registro->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ponto_folha_registro->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ponto_folha_registro->setponto_pk($query[$i]['ponto_pk']);
                $ponto_folha_registro->settipo_ponto_pk($query[$i]['tipo_ponto_pk']);
                $ponto_folha_registro->setdt_hora_ponto($query[$i]['dt_hora_ponto']);
                $ponto_folha_registro->settipo_registr_folha($query[$i]['tipo_registr_folha']);
                $ponto_folha_registro->setponto_folha_pk($query[$i]['ponto_folha_pk']);

            }
        }
        return $ponto_folha_registro;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,ponto_pk ";
        $sql.="       ,tipo_ponto_pk ";
        $sql.="       ,dt_hora_ponto ";
        $sql.="       ,tipo_registr_folha ";
        $sql.="       ,ponto_folha_pk ";

        $sql.="  from ponto_folha_registros ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarPontoFolhaPK($ponto_folha_pk){
        
        $sql ="";
        $sql.="select pfr.ponto_folha_pk";
        $sql.="       ,pfr.colaborador_pk";
        $sql.="       ,date_format(pfr.dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="       ,date_format(pfr.dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,pfr.ic_status, case when pfr.ic_status = 1 Then 'Finalizada' Else 'Não Finalizada' end ic_status";
        $sql.="  from ponto_folha_colaborador pfr ";
        $sql.="  inner join colaboradores c on pfr.colaborador_pk = c.pk";

        $sql.=" WHERE pfr.ponto_folha_pk=".$ponto_folha_pk;
       
        $sql.=" order by pfr.pk ";
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ponto_pk ";
        $sql.="       ,tipo_ponto_pk ";
        $sql.="       ,dt_hora_ponto ";
        $sql.="       ,tipo_registr_folha ";
        $sql.="       ,ponto_folha_pk ";

        $sql.="  from ponto_folha_registros ";
        $sql.=" where 1=1 ";
        $sql.=" order by ponto_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    
    public function salvar_folha_finalizada($ponto_folha_registro){
            
        $fields = array();
        
        $fields['ic_status'] = $ponto_folha_registro->getic_status();       
        $fields['dt_validacao'] = "sysdate()";
        
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $this->db->execUpdate("ponto_folha_colaborador", $fields, " ponto_folha_pk = ".$ponto_folha_registro->getpk()." and colaborador_pk = ".$ponto_folha_registro->getcolaborador_pk());
        
    }

}


?>
