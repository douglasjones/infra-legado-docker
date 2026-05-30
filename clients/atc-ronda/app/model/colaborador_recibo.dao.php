<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/colaborador_recibo.class.php';


class colaborador_recibodao{

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
    
    public function salvar($colaborador_recibo){

        $fields = array();
        $fields['colaborador_pk'] = $colaborador_recibo->getcolaborador_pk();
        $fields['vl_total'] = $colaborador_recibo->getvl_total();
        $fields['tipos_recibos_pk'] = $colaborador_recibo->gettipos_recibos_pk();
        $fields['mes_ini_pk'] = $colaborador_recibo->getmes_ini_pk();
        $fields['ano_ini_pk'] = $colaborador_recibo->getano_ini_pk();
        $fields['mes_fim_pk'] = $colaborador_recibo->getmes_fim_pk();
        $fields['ano_fim_pk'] = $colaborador_recibo->getano_fim_pk();

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($colaborador_recibo->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("colaboradores_recibos", $fields);
          
            return $pk;
        }
        else{
            $this->db->execUpdate("colaboradores_recibos", $fields, " pk = ".$colaborador_recibo->getpk());
      
            return $colaborador_recibo->getpk();
        }

    }

    public function excluir($colaborador_recibo){
        $this->db->execDelete("colaboradores_recibos"," pk = ".$colaborador_recibo->getpk());
    }
    
    
    public function salvarItens($dt_registro,$ds_dia_semana,$leads_pk,$hr_ini_expediente,$hr_fim_expediente,$ds_total_hr,$vl_unitario,$colaboradores_recibos_pk,$produtos_servicos_pk){

        $fields = array();
        $fields['dt_registro'] = DataYMD($dt_registro);
        $fields['ds_dia_semana'] = $ds_dia_semana;
        $fields['leads_pk'] = $leads_pk;
        $fields['hr_ini_expediente'] = $hr_ini_expediente;
        $fields['hr_fim_expediente'] = $hr_fim_expediente;
        $fields['ds_total_hr'] = $ds_total_hr;
        $fields['vl_unitario'] = $vl_unitario;
        $fields['colaboradores_recibos_pk'] = $colaboradores_recibos_pk;
        $fields['produtos_servicos_pk'] = $produtos_servicos_pk;
      

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("colaboradores_recibos_itens", $fields);
      
 
        return $pk;

    }
    
    public function excluirItens($colaboradores_recibos_pk){
        $this->db->execDelete("colaboradores_recibos_itens"," colaboradores_recibos_pk = ".$colaboradores_recibos_pk);
      
    }

    public function carregarPorPk($pk){

        $colaborador_recibo = new colaborador_recibo();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,tipos_recibos_pk ";


        $sql.="  from colaboradores_recibos ";
        $sql.=" where pk = $pk ";
      
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $colaborador_recibo->setpk($query[$i]["pk"]);
                $colaborador_recibo->setdt_cadastro($query[$i]["dt_cadastro"]);
                $colaborador_recibo->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $colaborador_recibo->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $colaborador_recibo->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $colaborador_recibo->setcolaborador_pk($query[$i]['colaborador_pk']);
                $colaborador_recibo->setvl_total($query[$i]['vl_total']);
                $colaborador_recibo->settipos_recibos_pk($query[$i]['tipos_recibos_pk']);

            }
        }
        return $colaborador_recibo;
    }
   
    public function listarPorPk($pk){

        $sql ="";
        $sql.="select cr.pk, cr.dt_cadastro, cr.usuario_cadastro_pk, cr.dt_ult_atualizacao, cr.usuario_ult_atualizacao_pk  ";
        $sql.="       ,cr.colaborador_pk ";
        $sql.="       ,cr.vl_total ";
        $sql.="       ,cr.tipos_recibos_pk ";
        $sql.="       ,c.ds_colaborador ";
        $sql.="       ,c.ds_cpf ";
        $sql.="       ,cr.mes_ini_pk ";
        $sql.="       ,cr.ano_ini_pk ";
        $sql.="       ,cr.mes_fim_pk ";
        $sql.="       ,cr.ano_fim_pk ";
        $sql.="  from colaboradores_recibos cr ";
        $sql.=" inner join colaboradores c on cr.colaborador_pk = c.pk";
        $sql.=" where cr.pk = $pk ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarItensPorPk($pk){

        $sql ="";
        $sql.="  SELECT cri.pk,";
        $sql.="        date_format(cri.dt_cadastro,'%d/%m/%Y')dt_cadastro,";
        $sql.="        cri.usuario_cadastro_pk,";
        $sql.="        cri.dt_ult_atualizacao,";
        $sql.="        cri.usuario_ult_atualizacao_pk,";
        $sql.="        date_format(cri.dt_registro,'%d/%m/%Y')dt_registro,";
        $sql.="        date_format(cri.dt_registro,'%d')dia_registro,";
        $sql.="        date_format(cri.dt_registro,'%m')mes_registro,";
        $sql.="        date_format(cri.dt_registro,'%Y')ano_registro,";
        $sql.="        cri.ds_dia_semana,";
        $sql.="        cri.ds_referencia,";
        $sql.="        cri.leads_pk,";
        $sql.="        l.ds_lead,";
        $sql.="        cri.leads_pk,";
        $sql.="        cri.produtos_servicos_pk,";
        $sql.="        TIME_FORMAT(cri.hr_ini_expediente,'%H:%i')hr_ini_expediente,";
        $sql.="        TIME_FORMAT(cri.hr_fim_expediente,'%H:%i')hr_fim_expediente,";
        $sql.="        cri.ds_total_hr,";
        
        $sql.="        cri.vl_unitario,";
        $sql.="        ps.ds_produto_servico,";
        $sql.="        cri.colaboradores_recibos_pk";
        $sql.="    FROM colaboradores_recibos_itens cri"; 
        $sql.="    LEFT JOIN leads l ON cri.leads_pk = l.pk";
        $sql.="    LEFT JOIN produtos_servicos ps on cri.produtos_servicos_pk = ps.pk";
        $sql.="    WHERE cri.colaboradores_recibos_pk =".$pk;
        $sql.="    ORDER BY cri.pk";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
    
    
    public function listarDataTable($tipos_recibos_pk,$colaborador_pk,$leads_pk,$dt_registro_ini,$dt_registro_fim){

        $sql ="";
        $sql.="SELECT cr.pk,";
        $sql.="                tr.ds_recibo,";
        $sql.="                c.ds_colaborador,";
        $sql.="                l.ds_lead,";
        $sql.="                date_format(cr.dt_cadastro, '%d/%m/%Y') dt_cadastro";
        $sql.="         FROM colaboradores_recibos cr";
        $sql.="              INNER JOIN colaboradores_recibos_itens cri";
        $sql.="                 ON cr.pk = cri.colaboradores_recibos_pk";
        $sql.="              INNER JOIN tipos_recibo tr ON tr.pk = cr.tipos_recibos_pk";
        $sql.="              INNER JOIN colaboradores c ON c.pk = cr.colaborador_pk";
        $sql.="              LEFT JOIN agenda_colaborador_padrao a ON c.pk = a.colaboradores_pk";
        $sql.="              LEFT JOIN leads l ON a.leads_pk = l.pk";
        $sql.="         WHERE     1 = 1";
        if(!empty($tipos_recibos_pk)){
            $sql.="               AND cr.tipos_recibos_pk =".$tipos_recibos_pk;
        }
        if(!empty($colaborador_pk)){
            $sql.="               AND cr.colaborador_pk = ".$colaborador_pk;
        }
        if(!empty($leads_pk)){
            $sql.="               AND l.pk = ".$leads_pk;
        }
        if(!empty($dt_registro_ini)){
            $sql.="               AND cr.dt_cadastro >='".DataYMD($dt_registro_ini)."'";                                                             
            $sql.="               AND cr.dt_cadastro <='".DataYMD($dt_registro_fim)."'";
        }        
        $sql.="         Group by cr.pk      ";
        $sql.="         ORDER BY cr.dt_cadastro DESC ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,vl_total ";
        $sql.="       ,tipos_recibos_pk ";

        $sql.="  from colaboradores_recibo ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }
    
     public function listarTiposRecibos($tipos_recibos_pk){

        $sql ="";
        $sql.="SELECT tr.pk, tr.ds_recibo";
        $sql.="        FROM tipos_recibo tr";
        $sql.="        WHERE 1=1 ";
        if(!empty($tipos_recibos_pk)){
            $sql.="        AND tr.pk = ".$tipos_recibos_pk;
        }
        $sql.="        AND tr.ic_status = 1";

        $query = $this->db->execQuery($sql);
        return $query;

    }

}

?>
