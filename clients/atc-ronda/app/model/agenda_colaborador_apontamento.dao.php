<?

require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/agenda_colaborador_apontamento.class.php';


class agenda_colaborador_apontamentodao{

    private $db;
    private $arrToken;

    public function getdb(){
        return $this->db;
   } 

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
	
    public function consultarHorarrio(){
        $sql = "";
        $sql .= "select current_time";
        $hora = $this->db->execQuery($sql);
        $horario = $hora[0]['current_time'];
        return $horario;
    }

	public function salvar($agenda_colaborador_apontamento){

		$fields = array();
        $fields['leads_pk'] = $agenda_colaborador_apontamento->getleads_pk();
        $fields['tipo_apontamento_pk'] = $agenda_colaborador_apontamento->gettipo_apontamento_pk();
        $fields['colaborador_pk'] = $agenda_colaborador_apontamento->getcolaborador_pk();
        $fields['agenda_colaborador_padrao_pk'] = $agenda_colaborador_apontamento->getagenda_colaborador_padrao_pk();
        $fields['dt_apontamento'] = $agenda_colaborador_apontamento->getdt_apontamento();
		
		$fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($agenda_colaborador_apontamento->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
            $pk = $this->db->execInsert("agenda_colaborador_apontamento", $fields);
            $agenda_colaborador_apontamento->setpk($pk);
            return $pk;
        }
        else{
            $this->db->execUpdate("agenda_colaborador_apontamento", $fields, " pk = ".$agenda_colaborador_apontamento->getpk());
        }
		
	}
    
    public function excluir($agenda_colaborador_apontamento, $apontamento_ponto_pk){;

        $this->db->execDelete("agenda_colaborador_apontamento"," pk = ".$agenda_colaborador_apontamento->getpk());
        switch($agenda_colaborador_apontamento->gettipo_apontamento_pk()){
            case '1': 
                $this->db->execDelete("apontamento_ponto"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                $this->db->execDelete("ponto","apontamento_ponto_pk =". $apontamento_ponto_pk);
                break;
            case '2':
                $this->db->execDelete("apontamento_falta"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                $this->db->execDelete("apontamento_folga"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                break;
            case '3':
                $this->db->execDelete("apontamento_folga"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                break;
            case '4':
                $this->db->execDelete("apontamento_troca_escala"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                break;
            case '5':
                $this->db->execDelete("apontamento_afastamento"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                break;
            case '6':
                $this->db->execDelete("apontamento_ferias"," agenda_colaborador_apontamento_pk = ".$agenda_colaborador_apontamento->getpk());
                break;
        }
    }

    public function carregarPorPk($pk){
        $agenda_colaborador_apontamento = new agenda_colaborador_apontamento();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,leads_pk ";
			$sql.="       ,tipo_apontamento_pk ";
			$sql.="       ,colaborador_pk ";
			$sql.="       ,agenda_colaborador_padrao_pk ";
			$sql.="       ,dt_apontamento ";

			$sql.="  from agenda_colaborador_apontamento ";
			$sql.=" where pk = $pk ";
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$agenda_colaborador_apontamento->setpk($query[$i]["pk"]);
					$agenda_colaborador_apontamento->setdt_cadastro($query[$i]["dt_cadastro"]);
					$agenda_colaborador_apontamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$agenda_colaborador_apontamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$agenda_colaborador_apontamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$agenda_colaborador_apontamento->setleads_pk($query[$i]['leads_pk']);
					$agenda_colaborador_apontamento->settipo_apontamento_pk($query[$i]['tipo_apontamento_pk']);
					$agenda_colaborador_apontamento->setcolaborador_pk($query[$i]['colaborador_pk']);
					$agenda_colaborador_apontamento->setagenda_colaborador_padrao_pk($query[$i]['agenda_colaborador_padrao_pk']);
					$agenda_colaborador_apontamento->setdt_apontamento($query[$i]['dt_apontamento']);
				}
        }
        return $agenda_colaborador_apontamento;
    }

    public function listarApontamentoColaboradorDia($colaborador_pk,$dt_apontamento,$tipo_apontamento_pk){

        $sql ="";
        $sql.="SELECT a.pk agenda_colaborador_apontamento_pk,";
        $sql.="       c.pk colaboradores_pk,";
        $sql.="       c.ds_colaborador,";
        $sql.="       ap.pk apontamento_ponto_pk,";
        $sql.="       u.pk usuario_cadastro_pk,";
        $sql.="       u.ds_usuario,";
        $sql.="       a.tipo_apontamento_pk,";
        $sql.="       l.pk leads_pk,";
        $sql.="       l.ds_lead,";
        $sql.="       DATE_FORMAT(a.dt_apontamento, '%d/%m/%Y  %H:%i') dt_apontamento,";
        $sql.="       CASE";
        $sql.="         WHEN a.tipo_apontamento_pk = 1 THEN 'Ponto'";
        $sql.="         WHEN a.tipo_apontamento_pk = 2 THEN 'Falta'";
        $sql.="         WHEN a.tipo_apontamento_pk = 3 THEN 'Folga'";
        $sql.="         WHEN a.tipo_apontamento_pk = 4 THEN 'Troca de Escala'";
        $sql.="         WHEN a.tipo_apontamento_pk = 5 THEN 'Afastamento'";
        $sql.="         WHEN a.tipo_apontamento_pk = 6 THEN 'Férias'";
        $sql.="         WHEN a.tipo_apontamento_pk = 7 THEN 'Serviço Extra'";
        $sql.="        END ds_tipo_apontamento";
        $sql.="  FROM agenda_colaborador_apontamento a";
        $sql.="       LEFT JOIN colaboradores c ON a.colaborador_pk = c.pk";
        $sql.="       LEFT JOIN apontamento_ponto ap ON a.pk = ap.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN leads l ON l.pk = a.leads_pk";
        $sql.="       LEFT JOIN usuarios u ON a.usuario_cadastro_pk = u.pk"; 
        $sql.=" WHERE     1 = 1";
        if($tipo_apontamento_pk!=""){
            $sql.=" and a.tipo_apontamento_pk =".$tipo_apontamento_pk;
        }
        if($dt_apontamento!=""){
 
            $sql.=" and a.dt_apontamento <= '".dataYMD($dt_apontamento)." 23:59:59'";
            $sql.=" and a.dt_apontamento >= '".dataYMD($dt_apontamento)." 00:00:00'";
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaborador_pk =".$colaborador_pk;
        }
        $sql.=" order by a.pk desc ";
        
        $query = $this->db->execQuery($sql);
        
        return $query;
    }

    public function relApontamento($colaborador_pk,$tipo_apontamento_pk,$dt_ini,$dt_fim,$leads_pk){

        $sql ="";
        $sql.="SELECT a.pk agenda_colaborador_apontamento_pk,";
        $sql.="       c.pk colaboradores_pk,";
        $sql.="       c.ds_colaborador,";
        $sql.="       u.pk usuario_cadastro_pk,";
        $sql.="       u.ds_usuario,";
        $sql.="       a.tipo_apontamento_pk,";
        $sql.="       l.pk leads_pk,";
        $sql.="       l.ds_lead,";
        $sql.="       DATE_FORMAT(a.dt_apontamento, '%d/%m/%Y  %H:%i') dt_apontamento,";
        $sql.="       DATE_FORMAT(a.dt_cadastro, '%d/%m/%Y  %H:%i') dt_cadastro,";
        $sql.="       CASE";
        $sql.="         WHEN a.tipo_apontamento_pk = 1 THEN 'Ponto'";
        $sql.="         WHEN a.tipo_apontamento_pk = 2 THEN 'Falta'";
        $sql.="         WHEN a.tipo_apontamento_pk = 3 THEN 'Folga'";
        $sql.="         WHEN a.tipo_apontamento_pk = 4 THEN 'Troca de Escala'";
        $sql.="         WHEN a.tipo_apontamento_pk = 5 THEN 'Afastamento'";
        $sql.="         WHEN a.tipo_apontamento_pk = 6 THEN 'Férias'";
        $sql.="         WHEN a.tipo_apontamento_pk = 7 THEN 'Serviço Extra'";
        $sql.="        END ds_tipo_apontamento,";
        $sql.="      CASE";
        $sql.="        WHEN a.tipo_apontamento_pk = 1 THEN ap.ds_obs_ponto";
        $sql.="        WHEN a.tipo_apontamento_pk = 2 THEN apf.ds_obs_falta";
        $sql.="        WHEN a.tipo_apontamento_pk = 3 THEN apfo.ds_obs_folga";
        $sql.="        WHEN a.tipo_apontamento_pk = 4 THEN ate.ds_obs_troca_escala";
        $sql.="        WHEN a.tipo_apontamento_pk = 5 THEN apfa.ds_obs_afastamento";
        $sql.="        WHEN a.tipo_apontamento_pk = 6 THEN af.ds_obs_ferias";
        $sql.="      END   obs   ";
        $sql.="  FROM agenda_colaborador_apontamento a";
        $sql.="       LEFT JOIN colaboradores c ON a.colaborador_pk = c.pk";
        $sql.="       LEFT JOIN leads l ON l.pk = a.leads_pk";
        $sql.="       LEFT JOIN usuarios u ON a.usuario_cadastro_pk = u.pk"; 
        $sql.="       LEFT JOIN apontamento_ponto ap on a.pk = a.agenda_colaborador_padrao_pk";
        $sql.="       LEFT JOIN apontamento_falta apf on a.pk = apf.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN apontamento_folga apfo on a.pk = apfo.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN apontamento_afastamento apfa on a.pk = apfa.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN apontamento_ferias af on a.pk = af.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN apontamento_troca_escala ate on a.pk = ate.agenda_colaborador_apontamento_pk";
        $sql.=" WHERE     1 = 1";
        if($tipo_apontamento_pk!=""){
            $sql.=" and a.tipo_apontamento_pk =".$tipo_apontamento_pk;
        }
        if($dt_ini!=""){
 
            $sql.=" and a.dt_apontamento >= '".dataYMD($dt_ini)." 00:00:00'";
            $sql.=" and a.dt_apontamento <= '".dataYMD($dt_fim)." 23:59:59'";
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaborador_pk =".$colaborador_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and a.leads_pk =".$leads_pk;
        }
        $sql.=" order by a.pk desc ";
   
        $query = $this->db->execQuery($sql);
        
        return $query;
    }

    public function relMovimentacaoFt($colaborador_pk,$dt_ini,$dt_fim,$leads_pk){

        $sql ="";
        $sql.="SELECT a.pk agenda_colaborador_apontamento_pk,";
        $sql.="       c.pk colaboradores_pk,";
        $sql.="       c.ds_colaborador,";
        $sql.="       co.ds_colaborador ds_colaborador_cobertura_falta,";
        $sql.="       a.tipo_apontamento_pk,";
        $sql.="       apfo.vl_ft,";
        $sql.="       l.pk leads_pk,";
        $sql.="       u.ds_usuario,";
        $sql.="       l.ds_lead,";
        $sql.="       apfo.ds_obs_folga,";
        $sql.="       apfa.ds_obs_falta,";
        $sql.="       apfo.motivo_ft_pk,";
        $sql.="       CASE";
        $sql.="          WHEN apfo.motivo_ft_pk = 1 THEN 'Posto Vago'";
        $sql.="          WHEN apfo.motivo_ft_pk = 2 THEN 'Falta de Efetivo'";
        $sql.="          WHEN apfo.motivo_ft_pk = 3 THEN 'Cobertura'";
        $sql.="          WHEN apfo.motivo_ft_pk = 4 THEN 'Troca de Plantão'";
        $sql.="          WHEN apfo.motivo_ft_pk = 5 THEN 'Serviço Extra'";
        $sql.="       END ds_motivo_ft,";
        $sql.="       CASE";
        $sql.="          WHEN apfa.motivo_cobertura_pk = 1 THEN 'Cobertura - Folga Trabalhada'";
        $sql.="          WHEN apfa.motivo_cobertura_pk = 2 THEN 'Escala Errada'";
        $sql.="          WHEN apfa.motivo_cobertura_pk = 3 THEN 'Cobertura'";
        $sql.="          WHEN apfa.motivo_cobertura_pk = 4 THEN 'Posto Vago'";
        $sql.="       END ds_motivo_cobertura_falta,";
        $sql.="       DATE_FORMAT(a.dt_apontamento, '%d/%m/%Y') dt_apontamento,";
        $sql.="       DATE_FORMAT(a.dt_apontamento, '%m') mes_apontamento,";
        $sql.="       CASE";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 01 THEN 'Janeiro'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 02 THEN 'Fevereiro'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 03 THEN 'Março'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 04 THEN 'Abril'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 05 THEN 'Maio'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 06 THEN 'Junho'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 07 THEN 'Julho'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 08 THEN 'Agosto'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 09 THEN 'Setembro'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 10 THEN 'Outubro'";
        $sql.="          WHEN DATE_FORMAT(a.dt_apontamento, '%m') = 11 THEN 'Novembro'";
        $sql.="          ELSE 'Dezembro'";
        $sql.="       END ds_mes_apontamento,";
        $sql.="       DATE_FORMAT(a.dt_cadastro, '%d/%m/%Y  %H:%i') dt_cadastro";
        $sql.="  FROM agenda_colaborador_apontamento a";
        $sql.="       LEFT JOIN colaboradores c ON a.colaborador_pk = c.pk";
        $sql.="       LEFT JOIN apontamento_folga apfo on a.pk = apfo.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN apontamento_falta apfa on apfa.pk = apfo.apontamento_falta_pk";
        $sql.="       LEFT JOIN colaboradores co ON apfa.colaborador_cobertura_falta_pk = co.pk";
        $sql.="       LEFT JOIN leads l ON l.pk = apfo.lead_cobertura_pk";
        $sql.="       LEFT JOIN usuarios u ON a.usuario_cadastro_pk = u.pk"; 
        $sql.=" WHERE     1 = 1";
        $sql.="     and apfo.motivo_folga_pk = 1";
        if($dt_ini!=""){
            $sql.=" and a.dt_apontamento >= '$dt_ini 00:00:00'";
            $sql.=" and a.dt_apontamento <= '$dt_fim 23:59:59'";
        }
        if($colaborador_pk!=""){
           $sql.=" and a.colaborador_pk = ".$colaborador_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and apfo.lead_cobertura_pk =".$leads_pk;
        }
        $sql.=" order by a.pk desc ";
        $query = $this->db->execQuery($sql);

        $sql = "";
        $sql.=" SELECT sum(vl_ft) total_vl_ft FROM apontamento_folga";
        $total = $this->db->execQuery($sql);


        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){  
                
                $result[] = array(
                    "ds_usuario" => $query[$i]["ds_usuario"],
                    "dt_cadastro" => $query[$i]["dt_cadastro"],
                    "ds_mes_apontamento" => $query[$i]["ds_mes_apontamento"],
                    "dt_apontamento" => $query[$i]["dt_apontamento"],
                    "ds_colaborador_cobertura_falta" => $query[$i]["ds_colaborador_cobertura_falta"],
                    "ds_colaborador" => $query[$i]["ds_colaborador"],
                    "ds_lead" => $query[$i]["ds_lead"],
                    "ds_motivo_ft" => $query[$i]["ds_motivo_ft"],
                    "ds_motivo_cobertura_falta" => $query[$i]["ds_motivo_cobertura_falta"],
                    "vl_ft" => number_format($query[$i]["vl_ft"], 2, ',', ' '),
                    "total_vl_ft" => number_format($total[0]["total_vl_ft"], 2, ',', ' '),
                    "ds_obs_falta" => $query[$i]["ds_obs_falta"],
                    "ds_obs_folga" => $query[$i]["ds_obs_folga"]
                );

            }
        }
        
        return $result;
    }
    
}



class apontamento_pontodao extends agenda_colaborador_apontamentodao{
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }

    
	public function salvar($apontamento_ponto){
        
        parent::__construct();  
        $this->db = parent::getdb();  
        
		$fields = array();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_ponto->getagenda_colaborador_apontamento_pk();
        $fields['tipo_ponto_pk'] = $apontamento_ponto->gettipo_ponto_pk();
        $fields['hr_ponto'] = $apontamento_ponto->gethr_ponto();
        $fields['ds_obs_ponto'] = $apontamento_ponto->getds_obs_ponto();
        $fields['dt_ponto'] = $apontamento_ponto->getdt_ponto();     
       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        
        if($apontamento_ponto->getpk() == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
            $pk = $this->db->execInsert("apontamento_ponto", $fields);
            $apontamento_ponto->setpk($pk);

            $fields_ponto = array();
            $fields_ponto['ds_pin'] = $apontamento_ponto->getds_pin();
            $fields_ponto['colaborador_pk'] = $apontamento_ponto->getcolaborador_pk();

            if($apontamento_ponto->gettipo_ponto_pk()==1){
                $fields_ponto['tipo_ponto_pk'] = 1;
            }elseif($apontamento_ponto->gettipo_ponto_pk()==2){
                $fields_ponto['tipo_ponto_pk'] = 3;
            }elseif($apontamento_ponto->gettipo_ponto_pk()==3){
                $fields_ponto['tipo_ponto_pk'] = 4;
            }elseif($apontamento_ponto->gettipo_ponto_pk()==4){
                $fields_ponto['tipo_ponto_pk'] = 2;
            }
    
            $sql = "";
            $sql.="select DATE_FORMAT(sysdate(), '%H:%i:%s') time";
            $time = $this->db->execQuery($sql);
            
            if($apontamento_ponto->gethr_ponto() == "sysdate()"){
                $fields_ponto['dt_hora_ponto'] = $apontamento_ponto->getdt_ponto()." ".$time[0]['time'];
            }else{
                $fields_ponto['dt_hora_ponto'] = $apontamento_ponto->getdt_ponto()." ".$apontamento_ponto->gethr_ponto();
            }
            $fields_ponto['ic_origem_registro_pk'] = 1;     
            $fields_ponto['apontamento_ponto_pk'] = $pk;     
    
            $fields_ponto["dt_ult_atualizacao"] = "sysdate()";
            $fields_ponto["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
          
            $fields_ponto["dt_cadastro"] = "sysdate()";
            $fields_ponto["usuario_cadastro_pk"] = $this->arrToken['usuarios_pk'];
            $this->db->execInsert("ponto", $fields_ponto);

            return $pk;
        }
        else{
            return $this->db->execUpdate("apontamento_ponto", $fields, " pk = ".$apontamento_ponto->getpk());
        }

    }

    public function carregarPorPk($pk){
        $apontamento_ponto = new apontamento_ponto();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,tipo_ponto_pk ";
			$sql.="       ,hr_ponto ";
			$sql.="       ,ds_obs_ponto ";
			$sql.="       ,dt_ponto ";

			$sql.="  from apontamento_ponto ";
			$sql.=" where pk = $pk ";
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_ponto->setpk($query[$i]["pk"]);
					$apontamento_ponto->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_ponto->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_ponto->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_ponto->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_ponto->settipo_ponto_pk($query[$i]['tipo_ponto_pk']);
					$apontamento_ponto->sethr_ponto($query[$i]['hr_ponto']);
					$apontamento_ponto->setds_obs_ponto($query[$i]['ds_obs_ponto']);
					$apontamento_ponto->setdt_ponto($query[$i]['dt_ponto']);
				}
        }
        return $apontamento_ponto;
    }
	
	
}

class apontamento_faltadao extends agenda_colaborador_apontamentodao{	
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	public function salvar($apontamento_falta){
        parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fieldsFolga = array();

		$fields['ds_obs_falta'] = $apontamento_falta->getds_obs_falta();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_falta->getagenda_colaborador_apontamento_pk();
        $fields['colaborador_cobertura_falta_pk'] = $apontamento_falta->getcolaborador_cobertura_falta_pk();
        $fields['motivo_falta_pk'] = $apontamento_falta->getmotivo_falta_pk();
        $fields['dt_falta'] = $apontamento_falta->getdt_falta();
        $fields['motivo_cobertura_pk'] = $apontamento_falta->getmotivo_cobertura_pk();
        $fields['lead_pk'] = $apontamento_falta->getlead_pk();

       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_falta->getpk()  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_falta", $fields);
            //echo $this->db->getLastSQL();

            if($apontamento_falta->getcolaborador_cobertura_falta_pk() != "" && $apontamento_falta->getmotivo_cobertura_pk() == "1"){
                $fieldsFolga["dt_ult_atualizacao"] = "sysdate()";
                $fieldsFolga["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
                $fieldsFolga["dt_cadastro"] = "sysdate()";
                $fieldsFolga["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];
                $fieldsFolga['apontamento_falta_pk'] = $pk;
                $fieldsFolga['lead_cobertura_pk'] = $apontamento_falta->getlead_cobertura_pk();
                $fieldsFolga['agenda_colaborador_apontamento_pk'] = $apontamento_falta->getagenda_colaborador_apontamento_pk();
                $fieldsFolga['dt_folga'] = $apontamento_falta->getdt_falta();
                $fieldsFolga['motivo_ft_pk'] = $apontamento_falta->getmotivo_cobertura_pk();
                $fieldsFolga['motivo_folga_pk'] = 1;
                $fieldsFolga['vl_ft'] = moeda2float($apontamento_falta->getvl_ft_falta());

                $this->db->execInsert("apontamento_folga", $fieldsFolga);
                
            }

            $apontamento_falta->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_falta", $fields, " pk = ".$apontamento_falta->getpk());
        }
        return $apontamento_falta->getpk();

    }

    public function carregarPorPk($pk){
        $apontamento_falta = new apontamento_falta();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,ds_obs_falta ";
			$sql.="       ,colaborador_cobertura_falta_pk ";
			$sql.="       ,motivo_falta_pk ";
			$sql.="       ,dt_falta ";

			$sql.="  from apontamento_falta ";
			$sql.=" where pk = ".$pk;
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_falta->setpk($query[$i]["pk"]);
					$apontamento_falta->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_falta->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_falta->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_falta->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_falta->setds_obs_falta($query[$i]['ds_obs_falta']);
					$apontamento_falta->setcolaborador_cobertura_falta_pk($query[$i]['colaborador_cobertura_falta_pk']);
					$apontamento_falta->setmotivo_falta_pk($query[$i]['motivo_falta_pk']);
					$apontamento_falta->setdt_falta($query[$i]['dt_falta']);
				}
        }
        return $apontamento_falta;
    }
	
}

class apontamento_feriasdao extends agenda_colaborador_apontamentodao{	
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	
	public function salvar($apontamento_ferias){
        
	    parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fields['dt_ini_ferias'] = $apontamento_ferias->getdt_ini_ferias();
        $fields['dt_fim_ferias'] = $apontamento_ferias->getdt_fim_ferias();
        $fields['colaborador_cobertura_ferias_pk'] = $apontamento_ferias->getcolaborador_cobertura_ferias_pk();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_ferias->getagenda_colaborador_apontamento_pk();
        $fields['ds_obs_ferias'] = $apontamento_ferias->getds_obs_ferias();
       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_ferias->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_ferias", $fields);
            $apontamento_ferias->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_ferias", $fields, " pk = ".$apontamento_ferias->getpk());
        }
        return $apontamento_ferias->getpk();

    }

    public function carregarPorPk($pk){
        $apontamento_ferias = new apontamento_ferias();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,dt_ini_ferias ";
			$sql.="       ,dt_fim_ferias ";
			$sql.="       ,colaborador_cobertura_ferias_pk ";
			$sql.="       ,ds_obs_ferias ";

			$sql.="  from apontamento_ferias ";
			$sql.=" where pk = ".$pk;
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_ferias->setpk($query[$i]["pk"]);
					$apontamento_ferias->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_ferias->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_ferias->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_ferias->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_ferias->setdt_ini_ferias($query[$i]['dt_ini_ferias']);
					$apontamento_ferias->setdt_fim_ferias($query[$i]['dt_fim_ferias']);
					$apontamento_ferias->setcolaborador_cobertura_ferias_pk($query[$i]['colaborador_cobertura_ferias_pk']);
					$apontamento_ferias->setds_obs_ferias($query[$i]['ds_obs_ferias']);
				}
        }
        return $apontamento_ferias;
    }
}

class apontamento_folgadao extends agenda_colaborador_apontamentodao{
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	public function salvar($apontamento_folga){
	
		parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fields['motivo_folga_pk'] = $apontamento_folga->getmotivo_folga_pk();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_folga->getagenda_colaborador_apontamento_pk();
        $fields['motivo_ft_pk'] = $apontamento_folga->getmotivo_ft_pk();
        $fields['ds_obs_folga'] = $apontamento_folga->getds_obs_folga();
        $fields['dt_folga'] = $apontamento_folga->getdt_folga();
        $fields['lead_cobertura_pk'] = $apontamento_folga->getlead_cobertura_pk();
        $fields['vl_ft'] = moeda2float($apontamento_folga->getvl_ft());
       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_folga->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_folga", $fields);
            $apontamento_folga->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_folga", $fields, " pk = ".$apontamento_folga->getpk());
        }
        return $apontamento_folga->getpk();

    }

    public function carregarPorPk($pk){
        $apontamento_folga = new apontamento_folga();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,motivo_folga_pk ";
			$sql.="       ,motivo_ft_pk ";
			$sql.="       ,ds_obs_folga ";
			$sql.="       ,dt_folga ";

			$sql.="  from apontamento_folga ";
			$sql.=" where pk = ".$pk;
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_folga->setpk($query[$i]["pk"]);
					$apontamento_folga->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_folga->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_folga->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_folga->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					$apontamento_folga->setds_obs_falta($query[$i]['ds_obs_folga']);
					$apontamento_folga->setcolaborador_cobertura_falta_pk($query[$i]['colaborador_cobertura_falta_pk']);
					$apontamento_folga->setmotivo_falta_pk($query[$i]['motivo_falta_pk']);
					$apontamento_folga->setdt_falta($query[$i]['dt_falta']);
				}
        }
        return $apontamento_folga;
    }
}

class apontamento_afastamentodao extends agenda_colaborador_apontamentodao{	
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	
	public function salvar($apontamento_afastamento){
	
		parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fields['motivo_afastamento_pk'] = $apontamento_afastamento->getmotivo_afastamento_pk();
        
        $fields['dt_ini_afastamento'] = $apontamento_afastamento->getdt_ini_afastamento();
        $fields['dt_fim_afastamento'] = $apontamento_afastamento->getdt_fim_afastamento();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_afastamento->getagenda_colaborador_apontamento_pk();
        $fields['colaborador_cobertura_afastamento_pk'] = $apontamento_afastamento->getcolaborador_cobertura_afastamento_pk();
        $fields['ds_obs_afastamento'] = $apontamento_afastamento->getds_obs_afastamento();
       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_afastamento->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_afastamento", $fields);
            $apontamento_afastamento->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_afastamento", $fields, " pk = ".$apontamento_afastamento->getpk());
        }
        return $apontamento_afastamento->getpk();

    }

	public function carregarPorPk($pk){
        $apontamento_afastamento = new apontamento_afastamento();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,motivo_afastamento_pk ";
			$sql.="       ,dt_ini_afastamento ";
			$sql.="       ,dt_fim_afastamento ";
			$sql.="       ,colaborador_cobertura_afastamento_pk ";
			$sql.="       ,ds_obs_afastamento ";

			$sql.="  from apontamento_afastamento ";
			$sql.=" where pk = ".$pk;
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_afastamento->setpk($query[$i]["pk"]);
					$apontamento_afastamento->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_afastamento->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_afastamento->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_afastamento->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_afastamento->setmotivo_afastamento_pk($query[$i]['motivo_afastamento_pk']);
					$apontamento_afastamento->setdt_ini_afastamento($query[$i]['dt_ini_afastamento']);
					$apontamento_afastamento->setdt_fim_afastamento($query[$i]['dt_fim_afastamento']);
					$apontamento_afastamento->setcolaborador_cobertura_afastamento_pk($query[$i]['colaborador_cobertura_afastamento_pk']);
					$apontamento_afastamento->setds_obs_afastamento($query[$i]['ds_obs_afastamento']);
                

				}
        }
        return $apontamento_afastamento;
    }
}

class apontamento_servico_extradao extends agenda_colaborador_apontamentodao{	
    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	
	public function salvar($apontamento_servico_extra){
	
        parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fields['dt_ini_exec_servico'] = $apontamento_servico_extra->getdt_ini_exec_servico();
        $fields['dt_fim_exec_servico'] = $apontamento_servico_extra->getdt_fim_exec_servico();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_servico_extra->getagenda_colaborador_apontamento_pk();
        $fields['contrato_pk'] = $apontamento_servico_extra->getcontrato_pk();
        $fields['vl_servico'] = moeda2float($apontamento_servico_extra->getvl_servico());
        $fields['leads_pk'] = $apontamento_servico_extra->getleads_pk();
        $fields['ds_obs_servico_extra'] = $apontamento_servico_extra->getds_obs_servico_extra();
		
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_servico_extra->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_servico_extra", $fields);
            $apontamento_servico_extra->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_servico_extra", $fields, " pk = ".$apontamento_servico_extra->getpk());
        }
        return $apontamento_servico_extra->getpk();

    }

    public function carregarPorPk($pk){
        $apontamento_servico_extra = new apontamento_servico_extra();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";

			$sql.="      , dt_ini_exec_servico ";
			$sql.="      , dt_fim_exec_servico ";
			$sql.="       ,contrato_pk ";
			$sql.="       ,vl_servico ";
			$sql.="       ,leads_pk ";
			$sql.="       ,ds_obs_servico_extra ";

			$sql.="  from apontamento_servico_extra ";
			$sql.=" where pk = ".$pk;
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_servico_extra->setpk($query[$i]["pk"]);
					$apontamento_servico_extra->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_servico_extra->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_servico_extra->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_servico_extra->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_servico_extra->setdt_ini_exec_servico($query[$i]['dt_ini_exec_servico']);
					$apontamento_servico_extra->setdt_fim_exec_servico($query[$i]['dt_fim_exec_servico']);
					$apontamento_servico_extra->setcontrato_pk($query[$i]['contrato_pk']);
					$apontamento_servico_extra->setvl_servico($query[$i]['vl_servico']);
					$apontamento_servico_extra->setleads_pk($query[$i]['leads_pk']);
					$apontamento_servico_extra->setds_obs_servico_extra($query[$i]['ds_obs_servico_extra']);
                

				}
        }
        return $apontamento_servico_extra;
    }
	
}

class apontamento_troca_escaladao extends agenda_colaborador_apontamentodao{

    private $arrToken;
    private $db;

    public function setToken($v_token){
        $this->arrToken = tratarToken($v_token);
    }
	
	public function salvar($apontamento_troca_escala){
	
        parent::__construct();
        $this->db = parent::getdb();
        
		$fields = array();
		$fields['ds_obs_troca_escala'] = $apontamento_troca_escala->getds_obs_troca_escala();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_troca_escala->getagenda_colaborador_apontamento_pk();
        $fields['dt_troca_escala'] = $apontamento_troca_escala->getdt_troca_escala();
        $fields['motivos_troca_escala_pk'] = $apontamento_troca_escala->getmotivos_troca_escala_pk();
        $fields['colaborador_cobertura_troca_escala_pk'] = $apontamento_troca_escala->getcolaborador_cobertura_troca_escala_pk();
       
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        if($apontamento_troca_escala->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("apontamento_troca_escala", $fields);
            $apontamento_troca_escala->setpk($pk);
        }
        else{
            $this->db->execUpdate("apontamento_troca_escala", $fields, " pk = ".$apontamento_troca_escala->getpk());
        }
        return $apontamento_troca_escala->getpk();

    }

    public function carregarPorPk($pk){
        $apontamento_troca_escala = new apontamento_troca_escala();
        if($pk != ""){

			$sql ="select pk ";
			$sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
			$sql.="      , usuario_cadastro_pk ";
			$sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
			$sql.="      , usuario_ult_atualizacao_pk ";
			
			$sql.="       ,ds_obs_troca_escala ";
			$sql.="       ,dt_troca_escala ";
			$sql.="       ,motivos_troca_escala_pk ";
			$sql.="       ,colaborador_cobertura_troca_escala_pk ";

			$sql.="  from apontamento_troca_escala ";
			$sql.=" where pk = ".$pk;
            
				$query = $this->db->execQuery($sql);
				for($i = 0; $i < count($query); $i++){
					$apontamento_troca_escala->setpk($query[$i]["pk"]);
					$apontamento_troca_escala->setdt_cadastro($query[$i]["dt_cadastro"]);
					$apontamento_troca_escala->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
					$apontamento_troca_escala->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
					$apontamento_troca_escala->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);
					
					$apontamento_troca_escala->setds_obs_troca_escala($query[$i]['ds_obs_troca_escala']);
					$apontamento_troca_escala->setdt_troca_escala($query[$i]['dt_troca_escala']);
					$apontamento_troca_escala->setmotivos_troca_escala_pk($query[$i]['motivos_troca_escala_pk']);
					$apontamento_troca_escala->setcolaborador_cobertura_troca_escala_pk($query[$i]['colaborador_cobertura_troca_escala_pk']);
				}
        }
        return $apontamento_troca_escala;
    }
}

?>

