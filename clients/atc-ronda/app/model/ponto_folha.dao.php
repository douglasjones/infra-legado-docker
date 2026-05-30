<?
ini_set('max_execution_time', '36000');
require_once '../inc/php/public.php';
require_once '../inc/classes/bestflow/DataBase.php';
require_once '../model/ponto_folha.class.php';
require_once "../model/ponto_folha_registro.dao.php";
require_once "../model/ponto_folha_registro.class.php";


class ponto_folhadao{

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
    
    //Novo
    public function listarDataTable($empresas_pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$ic_status){
        $sql ="";
        $sql.=" SELECT";
        $sql.="    c.ds_conta,";
        $sql.="    l.ds_lead,";
        $sql.="    l.pk lead_pk";
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.empresas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        $sql.=" AND pf.empresas_pk is not null";

        if(!empty($empresas_pk)){
            $sql.=" AND pf.empresas_pk=".$empresas_pk;
        }
        
        if(!empty($leads_pk)){
            $sql.=" AND pf.leads_pk=".$leads_pk;
        }

        $sql.=" GROUP BY l.ds_lead";
        $sql.=" ORDER BY l.ds_lead";
        
        $query = $this->db->execQuery($sql);

        for($i=0; $i<count($query);$i++){
            $mesesNoAno = array();
            $sql ="";
            $sql.=" SELECT DATE_FORMAT(pf.dt_periodo_ini, '%Y') ano_periodo_ini";
            $sql.="   FROM ponto_folha pf";
            $sql.="  WHERE pf.leads_pk =". $query[$i]['lead_pk'];
            $sql.="  GROUP BY DATE_FORMAT(pf.dt_periodo_ini, '%Y')";
            $ano = $this->db->execQuery($sql);

            for($l=0; $l<count($ano);$l++){
                $sql ="";
                $sql.=" SELECT pf.pk ponto_folha_pk,";
                $sql.="   CASE MONTHNAME(pf.dt_periodo_ini)";
                $sql.="   WHEN 'January' THEN 'Janeiro'";
                $sql.="   WHEN 'February' THEN 'Fevereiro'";
                $sql.="   WHEN 'March' THEN 'Março'";
                $sql.="   WHEN 'April' THEN 'Abril'";
                $sql.="   WHEN 'May' THEN 'Maio'";
                $sql.="   WHEN 'June' THEN 'Junho'";
                $sql.="   WHEN 'July' THEN 'Julho'";
                $sql.="   WHEN 'August' THEN 'Agosto'";
                $sql.="   WHEN 'September' THEN 'Setembro'";
                $sql.="   WHEN 'October' THEN 'Outubro'";
                $sql.="   WHEN 'November' THEN 'Novembro'";
                $sql.="   WHEN 'December' THEN 'Dezembro'";
                $sql.="    END as mes_periodo_ini";
               // $sql.="   DATE_FORMAT(pf.dt_periodo_ini, '%Y') ano_periodo_ini";
                $sql.="   FROM ponto_folha pf";
                $sql.="  WHERE pf.leads_pk =". $query[$i]['lead_pk'];
                $sql.="    and DATE_FORMAT(pf.dt_periodo_ini, '%Y') = ".$ano[$l]['ano_periodo_ini'];
                //$sql.="  GROUP BY DATE_FORMAT(pf.dt_periodo_ini, '%m'),   DATE_FORMAT(pf.dt_periodo_ini, '%Y')";
                $meses = $this->db->execQuery($sql);
                $mesesNoAno[] = array(
                    "ds_ano" => $ano[$l]["ano_periodo_ini"],
                    "ds_meses"=>$meses
                );   
            }
            $result[] = array(
                "pk" => $query[$i]["pk"],
                "ds_conta"=>$query[$i]['ds_conta'],
                "ds_lead"=>$query[$i]['ds_lead'],
                "lead_pk"=>$query[$i]['lead_pk'],
                "mesesNoAno"=>$mesesNoAno
            );
        }
        
        return $result;
    }
    
     public function listarDadosImpressao($pk,$colaborador_pk,$leads_pk){

        $ponto_folha_registrodao = new ponto_folha_registrodao();

        $sql ="";
        $sql.=" SELECT pf.pk,";
        $sql.="    c.ds_razao_social ds_empresa,";
        $sql.="    c.ds_endereco,";
        $sql.="    c.ds_numero,";
        $sql.="    c.ds_cpf_cnpj ds_cnpj_conta,";
        $sql.="    l.ds_lead ds_posto_trabalho,";
        $sql.="    date_format(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="    date_format(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="    date_format(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="    col.ds_colaborador,";
        $sql.="    col.ds_cpf,";
        $sql.="    ps.ds_produto_servico ds_cargo,";
        $sql.="    a.n_qtde_dias_semana,";
        $sql.="    t.ds_turno,";
        $sql.="    a.hr_inicio_expediente,";
        $sql.="    a.hr_termino_expediente,";
        $sql.="    a.hr_saida_intervalo,";
        $sql.="    a.hr_retorno_intervalo, ";
        $sql.="    a.turnos_pk,";        
        $sql.="    a.ic_intrajornada,";        
        $sql.="    pfr.hr_extra100,";        
        $sql.="    pfr.hr_extra50,";        
        $sql.="    pfr.hr_adicional_noturno,";        
        $sql.="    pfc.ponto_folha_pk, ";  
        $sql.="    pfc.colaborador_pk,";   
        $sql.="    date_format(col.dt_admissao, '%d/%m/%Y') dt_admissao,";        
        $sql.="    pfc.ic_status ";  
          
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.empresas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        $sql.="  INNER JOIN ponto_folha_colaborador pfc ON pf.pk = pfc.ponto_folha_pk";  
        $sql.="  INNER JOIN ponto_folha_registros pfr ON pf.pk = pfr.ponto_folha_pk";  
        $sql.="  INNER JOIN agenda_colaborador_padrao a ON pfc.colaborador_pk = a.colaboradores_pk";
        $sql.="  LEFT JOIN turnos t ON a.turnos_pk = t.pk";
        $sql.="  INNER JOIN colaboradores col ON pfc.colaborador_pk = col.pk";
        $sql.="  INNER JOIN colaboradores_produtos_servicos cps  ON col.pk = cps.colaboradores_pk";
        $sql.="  INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        
        if(!empty($pk)){
            $sql.=" WHERE pf.pk=".$pk;
        }

        if(!empty($colaborador_pk)){
            $sql.=" AND pfc.colaborador_pk=".$colaborador_pk;
        }
        
        if(!empty($leads_pk)){
            $sql.=" AND pf.leads_pk=".$leads_pk;
            $sql.=" AND a.leads_pk=".$leads_pk;
        }
        $sql.=" AND a.dt_cancelamento is null";

        $sql.=" GROUP BY pf.pk";
  
        $query = $this->db->execQuery($sql);

          
        if(count($query) > 0){
            
            //Total Horas Trabalhadas
            $queryHrTrabalhadas = $this->TotalHrTrabalhada($pk,$colaborador_pk);                       
            $v_total_ht = "";
            $v_total_ht = $queryHrTrabalhadas[0]['total_hr_trabalhadas'];
                        
            //Total Horas Excedentes
            $queryHrExcedentes = $this->TotalHrExcedentes($pk,$colaborador_pk);                       
            $v_total_he = "";
            $v_total_he = $queryHrExcedentes[0]['total_hr_excedente'];
                        
            //Total Horas Excedentes
            $queryHrFaltantes = $this->TotalHrFaltantes($pk,$colaborador_pk);                       
            $v_total_hf = "";
            $v_total_hf = $queryHrFaltantes[0]['total_hr_faltantes'];
            
            //Total Hora extra 50%
            $queryHrExtra50 = $this->TotalHrExtra50($pk,$colaborador_pk);                       
            $v_total_he50 = "";
            $v_total_he50 = $queryHrExtra50[0]['total_hr_extra50'];

            //Total Hora extra 100%
            $queryHrExtra100 = $this->TotalHrExtra100($pk,$colaborador_pk);                       
            $v_total_he100 = "";
            $v_total_he100 = $queryHrExtra100[0]['total_hr_extra100'];  
            
            //Total Hora Adicional Noturno
            $queryHrAdn = $this->TotalHrAdn($pk,$colaborador_pk);                       
            $v_total_hadn = "";
            $v_total_hadn = $queryHrAdn[0]['total_hr_adicional_noturno'];  
                        
            $queryTempoExpediente  = $this->retornarDifHora($query[0]['hr_inicio_expediente'],$query[0]['hr_termino_expediente']);
            $expediente_diario = "";
            $expediente_diario = $queryTempoExpediente[0]['dif']; 
            
            for($i = 0; $i < count($query); $i++){                
                $query0 = $ponto_folha_registrodao->listarFolhaRegistrosAgrupadoData($query[$i]['pk'],$query[$i]['colaborador_pk']);
                //$queryapontamento = $this->apontamentoPontoColaboradorData($query[$i]['dt_periodo_ini'],$query[$i]['dt_periodo_fim'],$query[$i]['colaborador_pk']);
                  
                for($j = 0; $j < count($query0); $j++){ 
                    $v_hr_extra50 = "";
                    $v_hr_adicional_noturno = "";  
                    $DadosFolhaRegistros[] = "";
                    //hora extra 
                    /*if($query0[$j]['hr_extra50']==""){
                        if($query[$i]['n_qtde_dias_semana']=="12x36"){
                            if($query[$i]['hr_saida_intervalo']=="" and $query[$i]['hr_retorno_intervalo']=="" ){
                                if($query0[$j]['tipo_ponto_pk']==1){   
                                    $v1 = "1";                     
                                    $v_hr_extra50 = "01:00";                                                                    
                                    $v_total_he50 += $v_hr_extra50;
                                }                            
                            }
                        }
                    }else{                      
                        $v_hr_extra50 = $query0[$j]['hr_extra50'];
                    }
         
                    //Adicional Noturno
                    if($query0[$j]['hr_adicional_noturno']==""){
                      
                        if($query[$i]['n_qtde_dias_semana']=="12x36"){
                          
                            if($query[$i]['turnos_pk']==3){
                                
                                if($query0[$j]['tipo_ponto_pk']==1){
                                    $v2 = "1";
                                    $v_hr_adicional_noturno = "08:00";
                                    //echo $v_hr_adicional_noturno."<br>";
                                    $v_total_hadn += $v_hr_adicional_noturno; 
                                }    
                            }
                        }    
                    }else{                     
                        $v_hr_adicional_noturno = $query0[$j]['hr_adicional_noturno']; 
                        $v_total_hadn += $query0[$j]['hr_adicional_noturno']; 
                    }*/
              

                    $DadosFolhaRegistros[$j] = array(
                        "ponto_folha_pk"=>$query0[$j]['ponto_folha_pk'],
                        "ponto_folha_registro_pk"=>$query0[$j]['ponto_folha_registro_pk'],
                        "colaborador_pk"=>$query0[$j]['colaborador_pk'],
                        "dt_registro_ponto"=>$query0[$j]['dt_ponto'],
                        "tipo_ponto_pk"=>$query0[$j]['tipo_ponto_pk'],
                        "hr_ini_expediente"=>$query0[$j]['hr_ini_expediente'],
                        "hr_ini_intervalo"=>$query0[$j]['hr_ini_intervalo'],
                        "hr_fim_intervalo"=>$query0[$j]['hr_fim_intervalo'],
                        "hr_fim_expediente"=>$query0[$j]['hr_fim_expediente'],
                        "hr_trabalhadas"=>$query0[$j]['hr_trabalhadas'],
                        "hr_excedentes"=>$query0[$j]['hr_excedentes'],
                        "hr_faltantes"=>$query0[$j]['hr_faltantes'],
                        "ic_status"=>$query0[$j]['ic_status'],
                        "hr_extra50"=>$query0[$j]['hr_extra50'],
                        "hr_extra100"=>$query0[$j]['hr_extra100'],
                        "hr_adicional_noturno"=>$query0[$j]['hr_adicional_noturno'],  
                        
                        
                        "obs"=>$query0[$j]['obs']
                    );

                }

               /* if($v1 == 1){
                    if($v_total_he50!=""){
                        if($v_total_he50<=9){
                            $v_total_he50 = "0".$v_total_he50.":00"; 
                        }else{
                            $v_total_he50 = $v_total_he50.":00"; 
                        }          
                    }
                }

                if($v2 == 1){    
                    if($v_hr_adicional_noturno!=""){
                        if($v_hr_adicional_noturno<=9){
                            $$v_hr_adicional_noturno = "0".$v_hr_adicional_noturno.":00"; 
                        }else{
                            $v_hr_adicional_noturno = $v_hr_adicional_noturno.":00"; 
                        }          
                    }
                }*/

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['dt_periodo_ini']." a ".$query[$i]['dt_periodo_fim'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco']." ,".$query[$i]['ds_numero'],
                    "ds_cnpj"=>$query[$i]['ds_cnpj_conta'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_admissao"=>$query[$i]['dt_admissao'],  
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['n_qtde_dias_semana'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ic_folha_finalizada"=>$query[$i]['ic_status'],
                    "ic_intrajornada"=>$query[$i]['ic_intrajornada'],
                    "ds_hr_expediente"=>$query[$i]['hr_inicio_expediente']." a ".$query[$i]['hr_termino_expediente'],
                    "registrosfolha"=>$DadosFolhaRegistros,
                    "total_ht"=> $v_total_ht,
                    "total_he"=> $v_total_he,
                    "total_hf"=> $v_total_hf,
                    "total_he50"=> $v_total_he50,
                    "total_he100"=> $v_total_he100,
                    "total_hadn"=> $v_total_hadn,
                    "expediente_diario"=> $expediente_diario
                 
                );
            }
        }
        return $result;
    }
    
    
    
    public function listarDadosPrint($pk,$colaborador_pk,$leads_pk){
        $sql ="";
        $sql.=" SELECT pf.pk,";
        $sql.="    c.ds_razao_social ds_empresa,";
        $sql.="    c.ds_endereco,";
        $sql.="    c.ds_numero,";
        $sql.="    c.ds_cpf_cnpj,";
        $sql.="    l.ds_lead ds_posto_trabalho,";
        $sql.="    date_format(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="    date_format(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="    date_format(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="    col.ds_colaborador,";
        $sql.="    col.ds_cpf,";
        $sql.="    ps.ds_produto_servico ds_cargo,";
        $sql.="    a.n_qtde_dias_semana,";
        $sql.="    t.ds_turno,";
        $sql.="    a.hr_inicio_expediente,";
        $sql.="    a.hr_termino_expediente,";
        $sql.="    a.hr_saida_intervalo,";
        $sql.="    a.hr_retorno_intervalo, ";
        $sql.="    pfc.ponto_folha_pk, ";  
        $sql.="    pfc.colaborador_pk ";    
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.empresas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        $sql.="  INNER JOIN ponto_folha_colaborador pfc ON pf.pk = pfc.ponto_folha_pk";  
        $sql.="  INNER JOIN agenda_colaborador_padrao a ON pfc.colaborador_pk = a.colaboradores_pk";
        $sql.="  LEFT JOIN turnos t ON a.turnos_pk = t.pk";
        $sql.="  INNER JOIN colaboradores col ON pfc.colaborador_pk = col.pk";
        $sql.="  INNER JOIN colaboradores_produtos_servicos cps  ON col.pk = cps.colaboradores_pk";
        $sql.="  INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        
        if(!empty($pk)){
            $sql.=" WHERE pf.pk=".$pk;
        }

        if(!empty($colaborador_pk)){
            $sql.=" AND pfc.colaborador_pk=".$colaborador_pk;
        }
        
        if(!empty($leads_pk)){
            $sql.=" AND pf.leads_pk=".$leads_pk;
            $sql.=" AND a.leads_pk=".$leads_pk;
        }
        
        $sql.=" group by col.pk";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    public function listarFolhasRegstros($pk){

        $sql ="";
        $sql.=" SELECT pf.pk,";
        $sql.="    c.ds_conta,";
        $sql.="    l.ds_lead,";
        $sql.="    l.pk leads_pk,";
        $sql.="    date_format(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="    date_format(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="    pf.obs";
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.empresas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        
        if(!empty($pk)){
            $sql.=" WHERE pf.pk=".$pk;
        }      
        
   
        $query = $this->db->execQuery($sql);
        return $query;
    }

   public function TotalHrTrabalhada($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_trabalhadas), '%H:%i') total_hr_trabalhadas";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_trabalhadas))), '%H:%i') total_hr_trabalhadas";
        $sql.="  FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.="   AND colaborador_pk =".$colaborador_pk;

        $query = $this->db->execQuery($sql);
        return $query;
    }

   public function TotalHrExcedentes($pk,$colaborador_pk){
        $sql ="";
       // $sql.="SELECT TIME_FORMAT(sum(hr_excedente), '%H:%i') total_hr_excedente";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_excedente))), '%H:%i') total_hr_excedente";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
  
        $query = $this->db->execQuery($sql);
        return $query;
    }

   public function TotalHrFaltantes($pk,$colaborador_pk){
        $sql ="";
       // $sql.="SELECT TIME_FORMAT(sum(hr_faltantes), '%H:%i') total_hr_faltantes";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_faltantes))), '%H:%i') total_hr_faltantes";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;

        $query = $this->db->execQuery($sql);
        return $query;
    }   
    
    public function TotalHrExtra50($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_extra50), '%H:%i') total_hr_extra50";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_extra50))), '%H:%i') total_hr_extra50";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;

        $query = $this->db->execQuery($sql);
        return $query;
    } 
    
    public function TotalHrExtra100($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_extra100), '%H:%i') total_hr_extra100";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_extra100))), '%H:%i') total_hr_extra100";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;

        $query = $this->db->execQuery($sql);
        return $query;
    } 
    
        public function TotalHrAdn($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_adicional_noturno), '%H:%i') total_hr_adicional_noturno";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_adicional_noturno))), '%H:%i') total_hr_adicional_noturno";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;

        $query = $this->db->execQuery($sql);
        return $query;
    } 
    
   public function retornarDifHora($hr_regristo_ponto,$hr_escala){
        $sql ="";
        $sql.="SELECT TIME_FORMAT(TIMEDIFF('$hr_escala','$hr_regristo_ponto'),'%H:%i')dif";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
    
    
    public function retornarDifDtHora($dt_hr_ponto_fim,$dt_hr_ponto_ini){
        $sql ="";
        $sql.="SELECT TIMEDIFF('$dt_hr_ponto_fim','$dt_hr_ponto_ini')dif";

        $query = $this->db->execQuery($sql);
        return $query;
    }
    
   public function retornarHRSemIntervalo($hr_trabalhadas,$hr_intervalo){
        $sql ="";
        $sql.="SELECT TIME_FORMAT(ADDTIME('$hr_trabalhadas','-$hr_intervalo'),'%H:%i')hrSemIntervalo";
        
        $query = $this->db->execQuery($sql);
        return $query;
    }
    
    
   /*public function retornarDifData($dt_ini,$dt_fim){

        $sql ="";
        $sql.="SELECT DATEDIFF('$dt_fim','$dt_ini')dtdif";
   
        $query = $this->db->execQuery($sql);
        return $query;
    }*/
    
    public function retornarAddTempo($hr_turno,$tempo){
        $sql ="";
        $sql.="SELECT TIME_FORMAT(DATE_ADD('$hr_turno', INTERVAL $tempo  MINUTE),'%H:%i')hr_tempo";

        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function retornarUltRegistroIniintervalo($dt_ponto,$tipo_registro){
        $sql ="";
        $sql.="SELECT pfr.pk,pfr.dt_hora_ponto dt_ini_intervalo_reg";
        $sql.=" FROM ponto_folha_registros pfr";
        $sql.=" WHERE     pfr.dt_hora_ponto >= '".$dt_ponto." 00:00:00'";
        $sql.="      AND pfr.dt_hora_ponto <= '".$dt_ponto." 23:59:59'";
        $sql.="      AND pfr.tipo_ponto_pk = ".$tipo_registro;
    
        $query = $this->db->execQuery($sql);
        return $query;
    }

    public function RetornaMesParImpar($dt_ini_escala,$v_mes_inicio_agenda,$v_ano_inicio_agenda,$dt_fim_periodo_folha,$vtipoEscalaCadastro,$MesIniPeriodo){

        if($MesIniPeriodo <="9"){  
            $MesForFolha =  str_replace("0","",$MesIniPeriodo );
        }else{
            $MesForFolha =  $MesIniPeriodo;
        }   

        $agenda_colaborador_padraodao = new agenda_colaborador_padraodao(); 
        //Retorna se a escala do mes de consulta é par ou impar                                
        $queryMes = $agenda_colaborador_padraodao->retornarDifMes($dt_ini_escala,$dt_fim_periodo_folha);  
        $qtde_mes = $queryMes[0]['mesdif']+1;
        for ($b=0; $b < $qtde_mes; $b++){
            if($v_mes_inicio_agenda!='12'){  
                //Escala de inicio
                if($b==0){
                    if($vtipoEscalaCadastro==1){
                        $vTipoMesFor = "impar";
                    }elseif($vtipoEscalaCadastro==2){
                        $vTipoMesFor = "par";
                    }
                    if($MesForFolha == $v_mes_inicio_agenda){
                        return  $vtipoEscalaCadastro;                       
                        break;
                    }
                    
                    $v_mes = $v_mes_inicio_agenda;
                }else{
                    if($v_mes_inicio_agenda == "01"){
                        $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, 12,  $v_ano_inicio_agenda -1);
                    }else{
                        $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda -1 ,  $v_ano_inicio_agenda);
                    }         
                    if($vTipoMesAnterior==''){
                        //echo "If<br>";
                        $vTipoMesAnterior = $vTipoMesFor;
                        if($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior<=30){
                            $v_tipoEscalaMesFor=2;
                            $vTipoMesAnterior = "par";                                                    
                        }elseif ($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior>30){
                            $v_tipoEscalaMesFor=1;
                            $vTipoMesAnterior = "impar";
                        }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior<=30){
                            $v_tipoEscalaMesFor=1;
                            $vTipoMesAnterior = "impar";
                        }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior>30){
                            $v_tipoEscalaMesFor=2;
                            $vTipoMesAnterior = "par";
                        }  
                    }else{
                        //echo "else<br>";
                        if($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior<=30){
                            $v_tipoEscalaMesFor=2;
                            $vTipoMesAnterior = "par";                                                    
                        }elseif ($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior>30){
                            $v_tipoEscalaMesFor=1;
                            $vTipoMesAnterior = "impar";
                        }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior<=30){
                            $v_tipoEscalaMesFor=1;
                            $vTipoMesAnterior = "impar";
                        }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior>30){
                            $v_tipoEscalaMesFor=2;
                            $vTipoMesAnterior = "par";
                        }  
                    }
                    if($MesForFolha == $v_mes_inicio_agenda){
                        return   $v_tipoEscalaMesFor;                       
                        break;
                    }
                    
                }                                         
                if($v_mes_inicio_agenda != $MesFimPeriodo){
                    $v_mes_inicio_agenda++;
                    
                }                             
                
            }else{
                if($b==0){
                    if($vtipoEscalaCadastro==1){
                        $vTipoMesFor = "impar";
                    }elseif($vtipoEscalaCadastro==2){
                        $vTipoMesFor = "par";
                    }
                    if($MesForFolha == $v_mes_inicio_agenda){
                        return  $vtipoEscalaCadastro;                       
                        break;
                    }
                    
                    $v_mes = $v_mes_inicio_agenda;              
                }
                //$vtipoEscalaMesAtual = $vtipoEscalaMesAtual; 
                
                    //ultimo dia do mes anterior
                    $v_ultDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $v_mes_inicio_agenda -1,  $v_ano_inicio_agenda);  

                    
                    //echo "else<br>";
                    if($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior<=30){
                        $v_tipoEscalaMesFor=2;
                        $vTipoMesAnterior = "par";                                                    
                    }elseif ($vTipoMesAnterior == "par" and $v_ultDiaMesAnterior>30){
                        $v_tipoEscalaMesFor=1;
                        $vTipoMesAnterior = "impar";
                    }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior<=30){
                        $v_tipoEscalaMesFor=1;
                        $vTipoMesAnterior = "impar";
                    }elseif ($vTipoMesAnterior == "impar" and $v_ultDiaMesAnterior>30){
                        $v_tipoEscalaMesFor=2;
                        $vTipoMesAnterior = "par";
                    }  
                    

                if($MesForFolha == $v_mes_inicio_agenda){
                    return   $v_tipoEscalaMesFor;                      
                    break;
                }                       
                $v_mes_inicio_agenda = '01';
                $v_ano_inicio_agenda = $v_ano_inicio_agenda +1;
                
            }                
        }   

    }

    public function verificarPreenchimento($empresas_pk){

        $sql = "";
        $sql.= "SELECT ic_preencher_folha from contas";
        $sql.= "    WHERE pk =".$empresas_pk;
        
        $query = $this->db->execQuery($sql);
        return $query[0]["ic_preencher_folha"];
    }

    public function horaParaMinutos($hora){
        $partes = explode(":", $hora);
        $minutos = $partes[0]*60+$partes[1];
        return $minutos;
    }

    public function calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turno_pk){
        
        
        $minutos_fim_expediente = $this->horaParaMinutos($hr_fim_expediente);
        $minutos_ini_expediente = $this->horaParaMinutos($hr_ini_expediente);

        if($turno_pk == 3){
            $minutos_fim_expediente = intval($minutos_fim_expediente) + 1440;
        }

        if($ic_intrajornada == "2"){
            if($hr_ini_intervalo!="" and $hr_fim_intervalo!=""){
                $minutos_fim_intervalo = $this->horaParaMinutos($hr_fim_intervalo);
                $minutos_ini_intervalo = $this->horaParaMinutos($hr_ini_intervalo);

                $hr_intervalo = $minutos_ini_intervalo - $minutos_fim_intervalo;
            }else{
                $minutos_fim_turno_intervalo = $this->horaParaMinutos($hr_termino_intervalo);
                $minutos_ini_turno_intervalo = $this->horaParaMinutos($hr_ini_intervalo_tb);

                $hr_intervalo = $minutos_ini_turno_intervalo - $minutos_fim_turno_intervalo;
            }

            $hr_intervalo = $minutos_ini_turno_intervalo - $minutos_fim_turno_intervalo;

        }else{
            $hr_intervalo = 60;
            $hr_turno_intervalo = 60;
        }

        //Calcular Hora Trabalhada No dia
        if($hr_ini_expediente!="" and $hr_fim_expediente!=""){
            $hr_trabalhadas = $minutos_fim_expediente - $minutos_ini_expediente;  
            $hr_trabalhadas = $hr_trabalhadas < 0 ? $hr_trabalhadas * -1 : $hr_trabalhadas;
            $hr_trabalhadas = $hr_trabalhadas - $hr_intervalo;  
            $horas = ($hr_trabalhadas / 60)|0;
            $horas = $horas < 0 ? $horas * -1 : $horas;
            $min = $hr_trabalhadas < 0 ? $hr_trabalhadas % 60 * -1 : $hr_trabalhadas % 60; 
            $hr_trabalhadas = $horas.":".$min;
        } 

        $return[] = array(
            "hr_trabalhadas" => $hr_trabalhadas
        );

        return $return;
    }

    public function calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno){
        $minutos_fim_turno = $this->horaParaMinutos($hr_fim_turno);
        $minutos_ini_turno = $this->horaParaMinutos($hr_ini_turno);
 
        if($ic_intrajornada == "2"){
             
            $minutos_fim_turno_intervalo = $this->horaParaMinutos($hr_termino_intervalo);
            $minutos_ini_turno_intervalo = $this->horaParaMinutos($hr_ini_intervalo_tb);

            $hr_intervalo = $minutos_ini_turno_intervalo - $minutos_fim_turno_intervalo;

            if($hr_termino_intervalo!="" and $hr_ini_intervalo_tb!=""){
                $hr_turno_intervalo = $minutos_fim_turno_intervalo - $minutos_ini_turno_intervalo;
            } 
 
            }else{
                $hr_intervalo = 60;
                $hr_turno_intervalo = 60;
            }
 
         //Calcular Turno
        if($hr_ini_expediente!="" and $hr_fim_expediente!=""){
        $hr_turno = $minutos_fim_turno - $minutos_ini_turno;  
        $hr_turno = $hr_turno < 0 ? $hr_turno * -1 : $hr_turno;
        $hr_turno = $hr_turno - $hr_turno_intervalo; 
        $horas = ($hr_turno / 60)|0;
        $horas = $horas < 0 ? $horas * -1 : $horas;
        $min = $hr_turno < 0 ? $hr_turno % 60 * -1 : $hr_turno % 60;  
        $hr_turno_dia = $horas.":".$min; 
        }
 
        $return[] = array(
            "hr_turno_dia" => $hr_turno_dia
        );

        return $return;
     }
    
    //antigo
    public function salvar($ponto_folha, $arrColaborador, $token){

        $ponto_folha_registrodao = new ponto_folha_registrodao();
        $ponto_folha_registrodao->setToken($token);

        $pontodao = new pontodao();
        $pontodao->setToken($token); 

        $agenda_colaborador_padraodao = new agenda_colaborador_padraodao(); 
        $agenda_colaborador_padraodao->setToken($token); 

        $fields = array();
        //$fields['colaborador_pk'] = $ponto_folha->getcolaborador_pk();
        $fields['empresas_pk'] = $ponto_folha->getempresas_pk();       
        $fields['dt_periodo_ini'] = DataYMD($ponto_folha->getdt_periodo_ini());
        $fields['dt_periodo_fim'] = DataYMD($ponto_folha->getdt_periodo_fim());
        $fields['obs'] = $ponto_folha->getobs();       
        $fields['leads_pk'] = $ponto_folha->getleads_pk();


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];


        if($ponto_folha->getpk()  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

            $pk = $this->db->execInsert("ponto_folha", $fields);

            $dt_periodo_ini = $ponto_folha->getdt_periodo_ini();
            $dt_periodo_fim = $ponto_folha->getdt_periodo_fim();

            $leads_pk = $ponto_folha->getleads_pk();

            //REGISTRA ponto_folha_colaborado
            $str = (explode(",",$arrColaborador));  
            $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');            
            for($i = 0; $i < count($str); $i++){ 
                if($str[$i]!=""){

                    //Separa por colaborador
                    $str_dados = (explode("|",$str[$i]));

                   
                    //registra a folha do colaborador               
                    $this->salvarColaborador($pk,$str_dados[0]);
                    
                    //Pesquisa a agenda de escala do colaborador
                    $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodo($str_dados[0],$dt_periodo_ini,$dt_periodo_fim,$leads_pk,$str_dados[1]);
                                   
                    $dtIni_e = (explode("/",$dt_periodo_ini)); 
                    $dtFim_e = (explode("/",$dt_periodo_fim));
            
                    $diaIniPeriodo = $dtIni_e[0];  
                    $MesIniPeriodo = $dtIni_e[1];
                    $AnoIniPeriodo = $dtIni_e[2]; 

                    $diaFimPeriodo = $dtFim_e[0];  
                    $MesFimPeriodo = $dtFim_e[1];
                    $AnoFimPeriodo = $dtFim_e[2]; 
         
                    $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesFimPeriodo, $AnoFimPeriodo);
                  
                    //Roda for do periodo Dias
                    $queryDias = $agenda_colaborador_padraodao->retornarDifData(DataYMD($dt_periodo_ini),DataYMD($dt_periodo_fim));
                    $ic_preenchimento = $this->verificarPreenchimento($ponto_folha->getempresas_pk());

                    $qtdeDias = $queryDias[0]['dtdif'];
                    $tipo_escala = $queryEscala[0]['tipo_escala'];
                    $n_qtde_dias_semana = $queryEscala[0]['n_qtde_dias_semana'];
                    $dt_inicio_agenda = $queryEscala[0]['dt_inicio_agenda'];
                    $v_mes_inicio_agenda = $queryEscala[0]['mes_inicio_agenda'];
                    $v_ano_inicio_agenda = $queryEscala[0]['ano_inicio_agenda'];  
                    $ic_intrajornada = $queryEscala[0]['ic_intrajornada'];  
                    $turnos_pk = $queryEscala[0]['turnos_pk'];  
                    
             
                    $queryApontamentoFerias = $this->apontamentoColaboradorFerias(DataDMY($dt_inicio_agenda), $dt_periodo_fim, $str_dados[0]);
                    for($v =0; $v < count($queryApontamentoFerias); $v++){
                        $dt_ini_ferias = $queryApontamentoFerias[$v]['dt_ini_ferias'];
                        $dt_fim_ferias = $queryApontamentoFerias[$v]['dt_fim_ferias'];
                    }
                   
                    $queryApontamentoAfastamento = $this->apontamentoColaboradorAfastamento(DataDMY($dt_inicio_agenda), $dt_periodo_fim, $str_dados[0]);
                    for($v =0; $v < count($queryApontamentoAfastamento); $v++){
                        $dt_ini_afastamento = $queryApontamentoAfastamento[$v]['dt_ini_afastamento'];
                        $dt_fim_afastamento = $queryApontamentoAfastamento[$v]['dt_fim_afastamento'];
                    }
                    //$ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesFimPeriodo, $AnoFimPeriodo);
            
                    // For dos dias do periodo da escala
                    for ($a=0; $a <= $qtdeDias; $a++){      
                          
                        //variaveis                     
                        $ic_escala = "";   
                        $hr_ini_turno = "";   
                        $hr_fim_turno = "";
                        $hr_ini_intervalo_tb = "";
                        $hr_termino_intervalo = "";
                        $ponto_pk = "";
                        $tipo_ponto_pk = "";
                        $dt_hora_ponto = "";
                        $obs = "";
                        
                        //Verifico os dias de escala
                        $d = ($diaIniPeriodo."/".$MesIniPeriodo."/".$AnoIniPeriodo);
                        $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$diaIniPeriodo));  
                        $TipoDia = ($diaIniPeriodo % 2) == true ? "impar" : "par";
                    
                        if($diasemana[$diasemana_numero]=="Dom"){
                            $ic_escala = $queryEscala[0]['ic_dom'];   
                            $turnos_pk = $queryEscala[0]['dom_turnos_pk'];                        
                            $hr_ini_turno = $queryEscala[0]['hr_turno_dom'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_dom_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_dom'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_dom'];
                        }elseif($diasemana[$diasemana_numero]=="Seg"){
                            $ic_escala = $queryEscala[0]['ic_seg'];
                            $turnos_pk = $queryEscala[0]['seg_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_seg'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_seg_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_seg'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_seg'];
                        }elseif($diasemana[$diasemana_numero]=="Ter"){
                            $ic_escala = $queryEscala[0]['ic_ter'];
                            $turnos_pk = $queryEscala[0]['ter_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_ter'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_ter_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_ter'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_ter'];
                        }elseif($diasemana[$diasemana_numero]=="Qua"){
                            $ic_escala = $queryEscala[0]['ic_qua'];
                            $turnos_pk = $queryEscala[0]['qua_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_qua'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_qua_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_qua'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qua'];
                        }elseif($diasemana[$diasemana_numero]=="Qui"){
                            $ic_escala = $queryEscala[0]['ic_qui']; 
                            $turnos_pk = $queryEscala[0]['qui_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_qui'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_qui_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_qui'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qui'];
                        }elseif($diasemana[$diasemana_numero]=="Sex"){
                            $ic_escala = $queryEscala[0]['ic_sex'];
                            $turnos_pk = $queryEscala[0]['sex_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_sex'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_sex_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_sex'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sex'];
                        }elseif($diasemana[$diasemana_numero]=="Sab"){
                            $ic_escala = $queryEscala[0]['ic_sab']; 
                            $turnos_pk = $queryEscala[0]['sab_turnos_pk'];
                            $hr_ini_turno = $queryEscala[0]['hr_turno_sab'];   
                            $hr_fim_turno = $queryEscala[0]['hr_turno_sab_saida'];
                            $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_sab'];
                            $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sab'];
                        }       
                        
                 

                        if($n_qtde_dias_semana=='12x36'){ 
             
                            //Função Cerifica se mes do for é impar ou par
                            $v_tipoEscalaMesFor =  $this->RetornaMesParImpar($queryEscala[0]['dt_inicio_agenda'],$queryEscala[0]['mes_inicio_agenda'], $queryEscala[0]['ano_inicio_agenda'],$AnoFimPeriodo."-".$MesFimPeriodo."-".$ultimoDiaMes,$queryEscala[0]['tipo_escala'],$MesIniPeriodo,$token);
                            $queryApontamentoColaborador = $this->apontamentoColaboradorData($d, $d, $str_dados[0]);
                            $tipo_apontamento_pk = $queryApontamentoColaborador[0]['tipo_apontamento_pk'];
                            $motivo_afastamento_pk = $queryApontamentoColaborador[0]['motivo_afastamento_pk'];
                            $motivo_falta_pk = $queryApontamentoColaborador[0]['motivo_falta_pk'];
                            $queryapontamento = $this->apontamentoPontoColaboradorData($d, $d, $str_dados[0]);
                            $hr_excedentes = "";
                            $hr_faltante = "";
                            $hr_trabalhadas = "";
                           // echo $v_tipoEscalaMesFor;
                            if($v_tipoEscalaMesFor==1){
                                if($TipoDia=='par'){
                                    $ic_escala = 2;
                                }else{
                                    $ic_escala = 1;
                                }
                            }elseif($v_tipoEscalaMesFor==2){
                                if($TipoDia=='impar'){
                                    $ic_escala = 2;
                                }else{
                                    $ic_escala = 1;
                                }
                            }

                            if($tipo_apontamento_pk == 5 || ($dt_ini_afastamento != "" && strtotime($dt_ini_afastamento) <= strtotime(DataYMD($d)) && strtotime($dt_fim_afastamento) >= strtotime(DataYMD($d)))){
                                $tipo_ponto_pk = 15;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";
                                if($motivo_afastamento_pk == 1){
                                    $obs = "Motivos Médicos";
                                }else if($motivo_afastamento_pk == 2){
                                    $obs = "Invalides";
                                } 

                            }else if($tipo_apontamento_pk == 6 || ($dt_ini_ferias != "" && strtotime($dt_ini_ferias) <= strtotime(DataYMD($d)) && strtotime($dt_fim_ferias) >= strtotime(DataYMD($d)))){
                                $tipo_ponto_pk = 12;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";  

                            }else if($tipo_apontamento_pk == 2){
                                $tipo_ponto_pk = 10;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = "";
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";

                                if($motivo_falta_pk == 1){
                                    $obs = "Abonada";
                                }else if($motivo_falta_pk == 2){
                                    $obs = "Apoio Operacional";
                                }else if($motivo_falta_pk == 3){
                                    $obs = "Atestado";
                                }else if($motivo_falta_pk == 4){
                                    $obs = "Atraso";
                                }else if($motivo_falta_pk == 5){
                                    $obs = "Extensão SDF";
                                }else if($motivo_falta_pk == 6){
                                    $obs = "Falta de efetivo";
                                }else if($motivo_falta_pk == 7){
                                    $obs = "Falta sem justificativa";
                                }else if($motivo_falta_pk == 8){
                                    $obs = "Licença";
                                }else if($motivo_falta_pk == 9){
                                    $obs = "Remanejamento";
                                }else if($motivo_falta_pk == 10){
                                    $obs = "Reciclagem";
                                }
                                
                            }else if($tipo_apontamento_pk == 3){
                                $tipo_ponto_pk = 5;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";  

                            }else if($queryapontamento[0]['pk']!=""){
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $hr_turno_dia = "";
                                $hr_intervalo = "";
                                $hr_extra50 = "";
                                $hr_adicional_noturno = "";
                                $obs = "Apontamento";
                                $ic_escala = 1;
                                $tipo_ponto_pk = 1;
                                
                                $hr_ini_expediente = $queryapontamento[0]['ini_expediente'];
                                $hr_fim_expediente = $queryapontamento[0]['fim_expediente'];
                                $hr_ini_intervalo = $queryapontamento[0]['ini_intervalo'];
                                $hr_fim_intervalo = $queryapontamento[0]['fim_intervalo'];

                                if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                    $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                    $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                }

                                $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                if($ic_intrajornada == 1){
                                    $hr_extra50 = "01:00";
                                }
                                
                                //Calcula HE e HF
                                if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){
                                    if($hr_trabalhadas < $hr_turno_dia){
                                        $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                        $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                    }else if ($hr_trabalhadas > $hr_turno_dia){
                                        $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                        $hr_excedentes = $queryexcedente[0]['dif'];
                                    }else {
                                        $hr_excedentes = " ";
                                        $hr_faltante = " ";
                                    }                
                                }else{
                                    $hr_excedentes = " ";
                                    $hr_faltante = " ";
                                }    

                                //Calcular AN
                                if($turnos_pk==3 && $hr_trabalhadas != ""){
                                    $partes_hr_excedentes = explode(":", $hr_excedentes);
                                    $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                    $partes_hr_excedentes = $partes_hr_excedentes+480;

                                    $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                   // $horas = ($hr_adicional_noturno / 60)|0;
                                    $horas = 8;
                                    $horas = $horas < 0 ? $horas * -1 : $horas;
                                    //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                    $min = 00;  
                                    $hr_adicional_noturno = $horas.":".$min;   
                                }

                            }else{
                                $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                                $dia1 = $d == $ultimoDia?01:$d+1;
                                $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                                $query2 = $pontodao->listarPontoColaboradorNoturno($d1,$d1,$str_dados[0],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,1);                
                                $query = $pontodao->listarPontoColaboradorPeriodoFolha($d,$d,$str_dados[0],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno);
                               // echo $ic_escala."<br>";     
                                //echo $d."-".$ic_escala."<br>";
                               // exit;
                  
                                if($ic_escala==1){
              
                                    $hr_ini_expediente = "";
                                    $hr_fim_expediente = "";
                                    $hr_ini_intervalo = "";
                                    $hr_fim_intervalo = "";
                                    $dt_hora_ponto = DataYMD($d); 
                                    $hr_excedentes = "";
                                    $hr_faltante = "";
                                    $hr_trabalhadas = "";
                                    $hr_turno_dia = "";
                                    $hr_intervalo = "";
                                    $hr_extra50 = "";
                                    $hr_adicional_noturno = "";
                                    $obs = "App Ponto";
                       
                                    if(count($query) > 0){
                          
                                        $dt_hora_ponto = DataYMD($d); 
                                        for($j = 0; $j < count($query); $j++){ 
                                      
                                            if($query[$j]['tipo_ponto_pk']==1 or $query[$j]['tipo_ponto_pk']==4 ){ 
                                             
                                                $tipo_ponto_pk = 1;
                                                //Ponto de Entrada  
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_ini_expe']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_ini_expe'])){ 
                                               
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_ini_expediente = $query[$j]['hr_ponto'];
                                                    
                                                }

                                                //retorno do intervalo
                                                if($hr_termino_intervalo!=""){ 
                                                    
                                                    if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_retorno_inter']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_retorno_inter'])){ 
                                                        $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                        $hr_fim_intervalo = $query[$j]['hr_ponto']; 
                                                    }
                                                }
                                            }elseif($query2[$j]['tipo_ponto_pk']==1 or $query2[$j]['tipo_ponto_pk']==4 ){
                                             
                                                $tipo_ponto_pk = 1;
                                                //Ponto de Entrada  
                                                if(strtotime($query2[$j]['hr_ponto']) > strtotime($query2[$j]['dif_hr_sub_ini_expe']) and  strtotime($query2[$j]['hr_ponto']) < strtotime($query2[$j]['dif_hr_add_ini_expe'])){ 
                                               
                                                    $dt_hora_ponto = $query2[$j]['dt_ponto']; 
                                                    $hr_ini_expediente = $query2[$j]['hr_ponto'];
                                                    
                                                }

                                                //retorno do intervalo
                                                if($hr_termino_intervalo!=""){ 
                                                    
                                                    if(strtotime($query2[$j]['hr_ponto']) > strtotime($query2[$j]['dif_hr_sub_retorno_inter']) and  strtotime($query2[$j]['hr_ponto']) < strtotime($query2[$j]['dif_hr_add_retorno_inter'])){ 
                                                        $dt_hora_ponto = $query2[$j]['dt_ponto']; 
                                                        $hr_fim_intervalo = $query2[$j]['hr_ponto']; 
                                                    }
                                                }
                                            }                                           
                                            if($query[$j]['tipo_ponto_pk']==2 or $query[$j]['tipo_ponto_pk']==3){ 

                                                //Saida para o intervalo     
                                        
                                                if($hr_ini_intervalo_tb!=""){                                                                                                
                                                    if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_saida_inter']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_saida_inter'])){ 
                                                             
                                                        $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                        $hr_ini_intervalo = $query[$j]['hr_ponto']; 
                                                    }
                                                }else{
                                                    $hr_extra50 = "01:00";
                                                }               

                                                //Ponto de termonio expediente                                           
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_fim_expe']) and strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_fim_expe']) ){                                                                                          
                                              
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_fim_expediente = $query[$j]['hr_ponto'];
                                                    
                                                }

                                            }else{ 
                                                if($turnos_pk==3){  
                                                    if(count($query2)> 0){  

                                                        $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                                                        $dia1 = $d == $ultimoDia?01:$d+1;
                                                        $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo);                                           
                                                        //$d1 = (($diaIniPeriodo+1)."/".$MesIniPeriodo."/".$AnoIniPeriodo);                                                
                                                        $query1 = $pontodao->listarPontoColaboradorNoturno($d,$d1,$str_dados[0],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,2);
                            
                                                        //Termino do Expediente
                                                        if(count($query) > 0){ 
                                                            for($h = 0; $h < count($query1); $h++){
                                                                if(strtotime($query1[$h]['hr_ponto']) > strtotime($query1[$h]['dif_hr_sub_fim_expe']) and strtotime($query1[$h]['hr_ponto']) < strtotime($query1[$h]['dif_hr_add_fim_expe']) ){                                                                                          
                                                                    $hr_fim_expediente = $query1[$h]['hr_ponto'];
                                                                }
                                                            }
                                                        } 

                                                        //Saida para o intervalo
                                                        if($hr_ini_intervalo_tb!=""){                                                                                      
                                                            if(strtotime($query1[$j]['hr_ponto']) > strtotime($query1[$j]['dif_hr_sub_saida_inter']) and  strtotime($query1[$j]['hr_ponto']) < strtotime($query1[$j]['dif_hr_add_saida_inter'])){ 
                                                                $hr_ini_intervalo = $query1[$j]['hr_ponto']; 
                                                            }
                                                        }else{
                                                            $hr_extra50 = "01:00";
                                                        }         
                                                        
                                                        //Retorno do intervalo
                                                        if($hr_termino_intervalo!=""){ 
                                                            $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                                                            $dia1 = $d == $ultimoDia?01:$d+1;
                                                            $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo);  
                                                            //$d1 = (($diaIniPeriodo+1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                                                            $query2 = $pontodao->listarPontoColaboradorNoturno($d1,$d1,$str_dados[0],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,1);                  
                                                            if(strtotime($query2[$j]['hr_ponto']) > strtotime($query2[$j]['dif_hr_sub_retorno_inter']) and  strtotime($query2[$j]['hr_ponto']) < strtotime($query2[$j]['dif_hr_add_retorno_inter'])){ 
                                                                $hr_fim_intervalo = $query2[$j]['hr_ponto']; 
                                                            }
                                                        }
                                
                                                    }else{
                                                        if($ic_preenchimento != "2") {
                                                            $tipo_ponto_pk = 1;
                                                            $dt_hora_ponto = DataYMD($d); 
                                                            $hr_ini_expediente = $hr_ini_turno;
                                                            $hr_fim_expediente = $hr_fim_turno;
                                                            $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                                            $hr_fim_intervalo = $hr_termino_intervalo;  
                                                            $hr_extra50 = "";                                    
                                                            $hr_adicional_noturno = "";
                                                            $obs = "Escala";
                                                            $hr_excedentes = "";
                                                            $hr_faltante = "";
                                                            $hr_trabalhadas = " ";
                                                        }else{
                                                            $tipo_ponto_pk = "";
                                                            $dt_hora_ponto = DataYMD($d);
                                                            $hr_ini_expediente = "";
                                                            $hr_fim_expediente = "";
                                                            $hr_ini_intervalo  = "";
                                                            $hr_fim_intervalo  = ""; 
                                                            $hr_excedentes = "";
                                                            $hr_faltante = "";
                                                            $hr_trabalhadas = "";
                                                            $hr_extra50 = " ";                                    
                                                            $hr_adicional_noturno = " ";
                                                            $obs = " ";    
                                                        }
                                                    }
                                                    $hr_extra50 = "01:00";
                                                }  
                                            } 
                                            
                                            $partes_fim_expediente = explode(":", $hr_fim_expediente);
                                            $minutos_fim_expediente = $partes_fim_expediente[0]*60+$partes_fim_expediente[1];

                                            $partes_ini_expediente = explode(":", $hr_ini_expediente);
                                            $minutos_ini_expediente = $partes_ini_expediente[0]*60+$partes_ini_expediente[1];
                                
                                            //Calcula Horas Trabalhadas
                                            $hr_trabalhadas = "";
                                            if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                                
                                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                            }
            
                                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                            if($ic_intrajornada == 1){
                                                $hr_extra50 = "01:00";
                                            }

                                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                                if($hr_trabalhadas < $hr_turno_dia){
                                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                                }else {
                                                    $hr_excedentes = " ";
                                                    $hr_faltante = " ";
                                                }                      
                                            }  


                                            if($turnos_pk==3 && $hr_trabalhadas != ""){
                                                $partes_hr_excedentes = explode(":", $hr_excedentes);
                                                $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                                $partes_hr_excedentes = $partes_hr_excedentes+480;
            
                                                $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                                //$horas = ($hr_adicional_noturno / 60)|0;
                                                $horas = 8;
                                                $horas = $horas < 0 ? $horas * -1 : $horas;
                                               // $min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60; 
                                                $min = 00;   
                                                $hr_adicional_noturno = $horas.":".$min;   
                                            }

                                        }
                                    }else{   
                                        if($ic_preenchimento != "2") {
                                            $tipo_ponto_pk = 1;
                                            $dt_hora_ponto = DataYMD($d); 
                                            $hr_ini_expediente = $hr_ini_turno;
                                            $hr_fim_expediente = $hr_fim_turno;
                                            $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                            $hr_fim_intervalo = $hr_termino_intervalo;  
                                            $hr_extra50 = "";                                    
                                            $hr_adicional_noturno = "";
                                            $obs = "Escala";
                                            $hr_excedentes = "";
                                            $hr_faltante = "";
                                            $hr_trabalhadas = "";
                                            $hr_turno_dia = "";

                                            //Calcula Horas Trabalhadas
                                             if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                            }

                                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                            if($ic_intrajornada == 1){
                                                $hr_extra50 = "01:00";
                                            }

                                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                                if($hr_trabalhadas < $hr_turno_dia){
                                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                                }else {
                                                    $hr_excedentes = " ";
                                                    $hr_faltante = " ";
                                                }                
                                            }   
                                            if($turnos_pk==3 && $hr_trabalhadas != ""){
                                                $partes_hr_excedentes = explode(":", $hr_excedentes);
                                                $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                                $partes_hr_excedentes = $partes_hr_excedentes+480;
            
                                                $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                                $horas = 8;//($hr_adicional_noturno / 60)|0;
                                                $horas = $horas < 0 ? $horas * -1 : $horas;
                                                //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                                $min = 00;  
                                                $hr_adicional_noturno = $horas.":".$min;   
                                            }
                                        }else{
                                            $tipo_ponto_pk = "";
                                            $dt_hora_ponto = DataYMD($d);
                                            $hr_ini_expediente = "";
                                            $hr_fim_expediente = "";
                                            $hr_ini_intervalo  = "";
                                            $hr_fim_intervalo  = ""; 
                                            $hr_excedentes = "";
                                            $hr_faltante = "";
                                            $hr_trabalhadas = "";
                                            $obs = " ";    
                                        }
                                    }

                                     
                                
                                }else{                                 
                                    if($ic_preenchimento != "2") {
                                        //FOLGA      
                                        $tipo_ponto_pk = 5;
                                        $dt_hora_ponto = DataYMD($d);
                                        $hr_ini_expediente = "";
                                        $hr_fim_expediente = "";
                                        $hr_ini_intervalo  = "";
                                        $hr_fim_intervalo  = ""; 
                                        $hr_excedentes = "";
                                        $hr_faltante = "";
                                        $hr_trabalhadas = "";
                                        $hr_extra50 = " ";                                    
                                        $hr_adicional_noturno = " ";
                                        $obs = " "; 
                                    }else{
                                        $tipo_ponto_pk = "";
                                        $dt_hora_ponto = DataYMD($d);
                                        $hr_ini_expediente = "";
                                        $hr_fim_expediente = "";
                                        $hr_ini_intervalo  = "";
                                        $hr_fim_intervalo  = ""; 
                                        $hr_excedentes = "";
                                        $hr_faltante = "";
                                        $hr_trabalhadas = "";
                                        $hr_extra50 = " ";                                    
                                        $hr_adicional_noturno = " ";
                                        $obs = " "; 
                                    }   
                                }
                            
                            }
                        }else{  
                       
                            $queryApontamentoColaborador = $this->apontamentoColaboradorData($d, $d, $str_dados[0]);
                            $tipo_apontamento_pk = $queryApontamentoColaborador[0]['tipo_apontamento_pk'];
                            $motivo_afastamento_pk = $queryApontamentoColaborador[0]['motivo_afastamento_pk'];
                            $motivo_falta_pk = $queryApontamentoColaborador[0]['motivo_falta_pk'];
                            $queryapontamento = $this->apontamentoPontoColaboradorData($d, $d, $str_dados[0]);
                            $hr_excedentes = "";
                            $hr_faltante = "";
                            $hr_trabalhadas = "";
                            if($tipo_apontamento_pk == 5 || ($dt_ini_afastamento != "" && strtotime($dt_ini_afastamento) <= strtotime(DataYMD($d)) && strtotime($dt_fim_afastamento) >= strtotime(DataYMD($d)))){
                               
                                $tipo_ponto_pk = 15;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";
                                if($motivo_afastamento_pk == 1){
                                    $obs = "Motivos Médicos";
                                }else if($motivo_afastamento_pk == 2){
                                    $obs = "Invalides";
                                } 

                            }else if($tipo_apontamento_pk == 6 || ($dt_ini_ferias != "" && strtotime($dt_ini_ferias) <= strtotime(DataYMD($d)) && strtotime($dt_fim_ferias) >= strtotime(DataYMD($d)))){
                                $tipo_ponto_pk = 12;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";  
                                 
                            }else if($tipo_apontamento_pk == 2){
                                $tipo_ponto_pk = 10;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = "";
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";
                                if($motivo_falta_pk == 1){
                                    $obs = "Abonada";
                                }else if($motivo_falta_pk == 2){
                                    $obs = "Apoio Operacional";
                                }else if($motivo_falta_pk == 3){
                                    $obs = "Atestado";
                                }else if($motivo_falta_pk == 4){
                                    $obs = "Atraso";
                                }else if($motivo_falta_pk == 5){
                                    $obs = "Extensão SDF";
                                }else if($motivo_falta_pk == 6){
                                    $obs = "Falta de efetivo";
                                }else if($motivo_falta_pk == 7){
                                    $obs = "Falta sem justificativa";
                                }else if($motivo_falta_pk == 8){
                                    $obs = "Licença";
                                }else if($motivo_falta_pk == 9){
                                    $obs = "Remanejamento";
                                }else if($motivo_falta_pk == 10){
                                    $obs = "Reciclagem";
                                }
                                
                            }else if($tipo_apontamento_pk == 3){
                                $tipo_ponto_pk = 5;
                                $dt_hora_ponto = DataYMD($d); 
                                $hr_ini_expediente = "";
                                $hr_fim_expediente = "";
                                $hr_ini_intervalo = "";
                                $hr_fim_intervalo = "";  
                                $hr_extra50 = "";                                    
                                $hr_adicional_noturno = ""; 
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "";  
                                 
                            }else if($queryapontamento[0]['pk']!=""){
                   
                                $hr_ini_expediente = $queryapontamento[0]['ini_expediente'];
                                $hr_fim_expediente = $queryapontamento[0]['fim_expediente'];
                                $hr_ini_intervalo = $queryapontamento[0]['ini_intervalo'];
                                $hr_fim_intervalo = $queryapontamento[0]['fim_intervalo'];
                                $dt_hora_ponto = DataYMD($d);
                                $tipo_ponto_pk = 1;
                                $hr_extra50 = "";
                                $hr_adicional_noturno = "";
                                $hr_excedentes = "";
                                $hr_faltante = "";
                                $hr_trabalhadas = "";
                                $obs = "Apontamento";

                                if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                    $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                    $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                }

                                $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];
                                
                                if($ic_intrajornada == 1){
                                    $hr_extra50 = "01:00";
                                }

                                if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){    
                                    if($hr_trabalhadas < $hr_turno_dia){
                                        $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                        $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                    }else if ($hr_trabalhadas > $hr_turno_dia){
                                        $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                        $hr_excedentes = $queryexcedente[0]['dif'];
                                    }else {
                                        $hr_excedentes = " ";
                                        $hr_faltante = " ";
                                    }                
                                }   
                                
                                if($turnos_pk==3 && $hr_trabalhadas != ""){
                                    $partes_hr_excedentes = explode(":", $hr_excedentes);
                                    $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                    $partes_hr_excedentes = $partes_hr_excedentes+480;

                                    $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                    //$horas = ($hr_adicional_noturno / 60)|0;
                                    $horas = 8;
                                    $horas = $horas < 0 ? $horas * -1 : $horas;
                                    //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                    $min = 00;  
                                    $hr_adicional_noturno = $horas.":".$min;   
                                }

                            }else{
                                
                                if($ic_escala==1){   
                                  
                                    $query = $pontodao->listarPontoColaboradorPeriodoFolha($d,$d,$str_dados[0],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno);

                                    $hr_ini_expediente = "";
                                    $hr_fim_expediente = "";
                                    $hr_ini_intervalo = "";
                                    $hr_fim_intervalo = "";
                                    $hr_excedentes = "";
                                    $hr_faltante = "";
                                    $hr_trabalhadas = "";
                                    $obs = "App Ponto";

                                    if(count($query) > 0){ 
                                        for($j = 0; $j < count($query); $j++){ 

                                            $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                            if($query[$j]['tipo_ponto_pk']==1 or $query[$j]['tipo_ponto_pk']==4 ){
                                                $tipo_ponto_pk = 1;
                                                //Ponto de Entrada  
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_ini_expe']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_ini_expe'])){ 
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_ini_expediente = $query[$j]['hr_ponto'];
                                                }
                                                //retorno do intervalo
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_retorno_inter']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_retorno_inter'])){ 
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_fim_intervalo = $query[$j]['hr_ponto']; 
                                                }
                                            }    
                                            if($query[$j]['tipo_ponto_pk']==2 or $query[$j]['tipo_ponto_pk']==3){ 
                                                $tipo_ponto_pk = 1;
                                                
                                                //Saída para o intervalo                                                    
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_saida_inter']) and  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_saida_inter'])){ 
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_ini_intervalo = $query[$j]['hr_ponto']; 
                                                }
                                                //Ponto de termino expediente 
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_fim_expe']) and strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_fim_expe']) ){                                           
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_fim_expediente = $query[$j]['hr_ponto'];
                                                }
                                            }

                                            $hr_trabalhadas = "";
                                            if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                            }
            
                                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];
                                            
                                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                                if($hr_trabalhadas < $hr_turno_dia){
                                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                                }else {
                                                    $hr_excedentes = " ";
                                                    $hr_faltante = " ";
                                                }                  
                                            }  

                                            if($ic_intrajornada == 1){
                                                $hr_extra50 = "01:00";
                                            }
                                            
                                        }
                                    }else{      
                                        if($ic_preenchimento != "2") {
                                            $tipo_ponto_pk = 1;
                                            $dt_hora_ponto = DataYMD($d); 
                                            $hr_ini_expediente = $hr_ini_turno;
                                            $hr_fim_expediente = $hr_fim_turno;
                                            $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                            $hr_fim_intervalo = $hr_termino_intervalo;  
                                            $hr_extra50 = "";                                    
                                            $hr_adicional_noturno = "";
                                            $obs = "Escala";
                                            $hr_excedentes = "";
                                            $hr_faltante = "";
                                            $hr_trabalhadas = "";
    
                                            if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                            }
            
                                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];
                                            if($ic_intrajornada == 1){
                                                $hr_extra50 = "01:00";
                                            }
                                            
                                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){   
                                                
                                                if($hr_trabalhadas < $hr_turno_dia){
                                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                                }else {
                                                    $hr_excedentes = " ";
                                                    $hr_faltante = " ";
                                                }                   
                                            }  

                                            if($turnos_pk==3 && $hr_trabalhadas != ""){
                                                $partes_hr_excedentes = explode(":", $hr_excedentes);
                                                $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                                $partes_hr_excedentes = $partes_hr_excedentes+480;
            
                                                $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                                //$horas = ($hr_adicional_noturno / 60)|0;
                                                $horas = 8;
                                                $horas = $horas < 0 ? $horas * -1 : $horas;
                                                //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                                $min = 00;  
                                                $hr_adicional_noturno = $horas.":".$min;  
                                        
                                            }
                                        }else{
                                            $tipo_ponto_pk = "";
                                            $dt_hora_ponto = DataYMD($d);
                                            $hr_ini_expediente = "";
                                            $hr_fim_expediente = "";
                                            $hr_ini_intervalo  = "";
                                            $hr_fim_intervalo  = ""; 
                                            $hr_excedentes = "";
                                            $hr_faltante = "";
                                            $hr_trabalhadas = "";
                                            $obs = " ";    
                                        }
                                    }                    
                                }else{
                                    if($ic_preenchimento != "2") {
                                        //FOLGA      
                                        $tipo_ponto_pk = 5;
                                        $dt_hora_ponto = DataYMD($d);
                                        $hr_ini_expediente = "";
                                        $hr_fim_expediente = "";
                                        $hr_ini_intervalo  = "";
                                        $hr_fim_intervalo  = ""; 
                                        $hr_excedentes = "";
                                        $hr_faltante = "";
                                        $hr_trabalhadas = "";
                                        $hr_extra50 = "";                                    
                                        $hr_adicional_noturno = "";
                                        $obs = " "; 
                                    }else{
                                        $tipo_ponto_pk = "";
                                        $dt_hora_ponto = DataYMD($d);
                                        $hr_ini_expediente = "";
                                        $hr_fim_expediente = "";
                                        $hr_ini_intervalo  = "";
                                        $hr_fim_intervalo  = ""; 
                                        $hr_excedentes = "";
                                        $hr_faltante = "";
                                        $hr_trabalhadas = "";
                                        $hr_extra50 = " ";                                    
                                        $hr_adicional_noturno = " ";
                                        $obs = " "; 
                                    }                    
                                }   
                            }
                        }         
                            
                        //Cadastro ponto_folha_registro
                        $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk(0);
                        $ponto_folha_registro->setponto_folha_pk($pk);
                        $ponto_folha_registro->setponto_pk($ponto_pk);
                        $ponto_folha_registro->settipo_ponto_pk($tipo_ponto_pk);
                        $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto);                        
                        $ponto_folha_registro->setcolaborador_pk($str_dados[0]);              
                        $ponto_folha_registro->sethr_ini_expediente($hr_ini_expediente);
                        $ponto_folha_registro->sethr_ini_intervalo($hr_ini_intervalo);
                        $ponto_folha_registro->sethr_fim_intervalo($hr_fim_intervalo);
                        $ponto_folha_registro->sethr_fim_expediente($hr_fim_expediente);
                        $ponto_folha_registro->sethr_trabalhadas($hr_trabalhadas);
                        $ponto_folha_registro->sethr_excedente($hr_excedentes);
                        $ponto_folha_registro->sethr_faltantes($hr_faltante);
                        $ponto_folha_registro->sethr_extra50($hr_extra50);
                        $ponto_folha_registro->sethr_extra100($hr_extra100);
                        $ponto_folha_registro->sethr_adicional_noturno($hr_adicional_noturno); 
                        $ponto_folha_registro->setobs($obs); 
                             

                        $ponto_folha_registrodao->salvar($ponto_folha_registro);
                        
                        $ultimoDiaMesIni = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                        $ultimoDiaMesFim = cal_days_in_month(CAL_GREGORIAN, $MesFimPeriodo, $AnoFimPeriodo);
  
                        if($ultimoDiaMesIni ==  $ultimoDiaMesFim){
                            if($diaIniPeriodo == $ultimoDiaMes){
                                if($MesIniPeriodo==12 and $ultimoDiaMes==31){             
                                    $MesIniPeriodo = "01";
                                    $AnoIniPeriodo ++;
                                }else{
                                    $MesIniPeriodo++;
                                }
                                $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);    
                                $diaIniPeriodo = "01"; 
                            }else{                                   
                                 $diaIniPeriodo++;
                            } 
                        }else{
                            if($ultimoDiaMesIni == $diaIniPeriodo){
                                $diaIniPeriodo = "01";
                                $MesIniPeriodo = $MesFimPeriodo;
                            }else{
                                $diaIniPeriodo++;
                            }
                        }                               
                    }
                }
            }
            return $pk;
        }
        else{
           return $this->db->execUpdate("ponto_folha", $fields, " pk = ".$ponto_folha->getpk());
        }

    }

    public function regerar($ponto_folha, $arrColaborador, $token){

        $arrColaborador = json_decode($arrColaborador);
        $ponto_folha_registrodao = new ponto_folha_registrodao();
        $ponto_folha_registrodao->setToken($token);

        $pontodao = new pontodao();
        $pontodao->setToken($token); 

        $agenda_colaborador_padraodao = new agenda_colaborador_padraodao(); 
        $agenda_colaborador_padraodao->setToken($token); 

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
        $this->db->execUpdate("ponto_folha", $fields, " pk = ".$ponto_folha->getpk());

        $pk = $ponto_folha->getpk();
        $dt_periodo_ini = $ponto_folha->getdt_periodo_ini();
        $dt_periodo_fim = $ponto_folha->getdt_periodo_fim();
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
        
        for($i = 0; $i < count($arrColaborador); $i++){            

            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];
            $this->db->execUpdate("ponto_folha_colaborador", $fields, " ponto_folha_pk = ".$ponto_folha->getpk());

            $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodo($arrColaborador[$i],$dt_periodo_ini,$dt_periodo_fim,"", "");
            $ic_preenchimento = $queryEscala[0]['ic_preencher_folha'];
            $ic_intrajornada = $queryEscala[0]['ic_intrajornada'];  

            $dtIni_e = (explode("/",$dt_periodo_ini)); 
            $diaIniPeriodo = $dtIni_e[0];  
            $MesIniPeriodo = $dtIni_e[1];
            $AnoIniPeriodo = $dtIni_e[2]; 

            $dtFim_e = (explode("/",$dt_periodo_fim));
            $diaFimPeriodo = $dtIni_e[0];  
            $MesFimPeriodo = $dtIni_e[1];
            $AnoFimPeriodo = $dtIni_e[2]; 

            $queryDias = $agenda_colaborador_padraodao->retornarDifData(DataYMD($dt_periodo_ini),DataYMD($dt_periodo_fim));
            $qtdeDias = $queryDias[0]['dtdif'];
            
            $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
            $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$diaIniPeriodo));

            $queryRegistrosPonto = $ponto_folha_registrodao->listarFolhaRegistrosAgrupadoData($pk,$arrColaborador[$i]);

            $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodo($arrColaborador[$i],$dt_periodo_ini,$dt_periodo_fim,"","");
            $dt_inicio_agenda = $queryEscala[0]['dt_inicio_agenda'];
            $n_qtde_dias_semana = $queryEscala[0]['n_qtde_dias_semana'];

            $queryApontamentoFerias = $this->apontamentoColaboradorFerias(DataDMY($dt_inicio_agenda), $dt_periodo_fim, $arrColaborador[$i]);
            for($v =0; $v < count($queryApontamentoFerias); $v++){
                $dt_ini_ferias = $queryApontamentoFerias[$v]['dt_ini_ferias'];
                $dt_fim_ferias = $queryApontamentoFerias[$v]['dt_fim_ferias'];
            }
            $queryApontamentoAfastamento = $this->apontamentoColaboradorAfastamento(DataDMY($dt_inicio_agenda), $dt_periodo_fim, $arrColaborador[$i]);
            for($v =0; $v < count($queryApontamentoAfastamento); $v++){
                $dt_ini_afastamento = $queryApontamentoAfastamento[$v]['dt_ini_afastamento'];
                $dt_fim_afastamento = $queryApontamentoAfastamento[$v]['dt_fim_afastamento'];
            }


            for($l = 0; $l <= $qtdeDias; $l++){

                $data = $AnoIniPeriodo."-".$MesIniPeriodo."-".$diaIniPeriodo;

                if($diaIniPeriodo < 10){
                    if($diaIniPeriodo == "01" || $diaIniPeriodo >= 10){
                        $diaIniPeriodo = $diaIniPeriodo;
                    }else{
                        $diaIniPeriodo = "0".$diaIniPeriodo;
                    }
                }

                if($MesIniPeriodo < 10){
                    if(mb_strpos($MesIniPeriodo, '0') === false){
                        $MesIniPeriodo = "0".$MesIniPeriodo;
                    }else{
                        $MesIniPeriodo = $MesIniPeriodo;
                    }
                }else{
                    $MesIniPeriodo = $MesIniPeriodo;
                }
                    //Verifico os dias de escala
                
                $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$diaIniPeriodo));  
                $TipoDia = ($diaIniPeriodo % 2) == true ? "impar" : "par";
            
                $queryApontamentoColaborador = $this->apontamentoColaboradorData(DataDMY($data), DataDMY($data), $arrColaborador[$i]);
                $tipo_apontamento_pk = $queryApontamentoColaborador[0]['tipo_apontamento_pk'];
                $motivo_afastamento_pk = $queryApontamentoColaborador[0]['motivo_afastamento_pk'];
                $motivo_falta_pk = $queryApontamentoColaborador[0]['motivo_falta_pk'];
                $queryapontamento = $this->apontamentoPontoColaboradorData(DataDMY($data), DataDMY($data), $arrColaborador[$i]);

                if($queryRegistrosPonto[$l]['ic_status'] != 1){
                    
                    if($diasemana[$diasemana_numero]=="Dom"){
                        $ic_escala = $queryEscala[0]['ic_dom'];   
                        $turno_pk = $queryEscala[0]['dom_turnos_pk'];                        
                        $hr_ini_turno = $queryEscala[0]['hr_turno_dom'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_dom_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_dom'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_dom'];
                    }elseif($diasemana[$diasemana_numero]=="Seg"){
                        $ic_escala = $queryEscala[0]['ic_seg'];
                        $turnos_pk = $queryEscala[0]['seg_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_seg'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_seg_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_seg'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_seg'];
                    }elseif($diasemana[$diasemana_numero]=="Ter"){
                        $ic_escala = $queryEscala[0]['ic_ter'];
                        $turno_pk = $queryEscala[0]['ter_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_ter'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_ter_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_ter'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_ter'];
                    }elseif($diasemana[$diasemana_numero]=="Qua"){
                        $ic_escala = $queryEscala[0]['ic_qua'];
                        $turnos_pk = $queryEscala[0]['qua_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_qua'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_qua_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_qua'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qua'];
                    }elseif($diasemana[$diasemana_numero]=="Qui"){
                        $ic_escala = $queryEscala[0]['ic_qui']; 
                        $turno_pk = $queryEscala[0]['qui_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_qui'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_qui_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_qui'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_qui'];
                    }elseif($diasemana[$diasemana_numero]=="Sex"){
                        $ic_escala = $queryEscala[0]['ic_sex'];
                        $turnos_pk = $queryEscala[0]['sex_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_sex'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_sex_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_sex'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sex'];
                    }elseif($diasemana[$diasemana_numero]=="Sab"){
                        $ic_escala = $queryEscala[0]['ic_sab']; 
                        $turnos_pk = $queryEscala[0]['sab_turnos_pk'];
                        $hr_ini_turno = $queryEscala[0]['hr_turno_sab'];   
                        $hr_fim_turno = $queryEscala[0]['hr_turno_sab_saida'];
                        $hr_ini_intervalo_tb = $queryEscala[0]['hr_intervalo_sab'];
                        $hr_termino_intervalo = $queryEscala[0]['hr_intervalo_saida_sab'];
                    } 
                    
                    if($n_qtde_dias_semana=='12x36'){ 
                        
                        //Função Cerifica se mes do for é impar ou par
                        $v_tipoEscalaMesFor =  $this->RetornaMesParImpar($queryEscala[0]['dt_inicio_agenda'],$queryEscala[0]['mes_inicio_agenda'], $queryEscala[0]['ano_inicio_agenda'],$AnoFimPeriodo."-".$MesIniPeriodo."-".$ultimoDiaMes,$queryEscala[0]['tipo_escala'],$MesIniPeriodo,$token);
                        //echo $data."-".$v_tipoEscalaMesFor."<br>";
                        $hr_excedentes = " ";
                        $hr_faltante = " ";
                        $hr_trabalhadas = " ";

                        if($v_tipoEscalaMesFor==1){
                            if($TipoDia=='par'){
                                $ic_escala = 2;
                            }else{
                                $ic_escala = 1;
                            }
                        }elseif($v_tipoEscalaMesFor==2){
                            if($TipoDia=='impar'){
                                $ic_escala = 2;
                            }else{
                                $ic_escala = 1;
                            }
                        }

                        if($tipo_apontamento_pk == 5 || ($dt_ini_afastamento != "" && strtotime($dt_ini_afastamento) <= strtotime(DataYMD($data)) && strtotime($dt_fim_afastamento) >= strtotime(DataYMD($data)))){
                            $tipo_ponto_pk = 15;
                            $dt_hora_ponto = $data; 
                            $hr_ini_expediente = " ";
                            $hr_fim_expediente = " ";
                            $hr_ini_intervalo = " ";
                            $hr_fim_intervalo = " ";  
                            $hr_extra50 = " ";                                    
                            $hr_adicional_noturno = " "; 
                            $hr_excedentes = " ";
                            $hr_faltante = " ";
                            $hr_trabalhadas = " ";
                            $obs = " ";
                            if($motivo_afastamento_pk == 1){
                                $obs = "Motivos Médicos";
                            }else if($motivo_afastamento_pk == 2){
                                $obs = "Invalides";
                            } 

                        }else if($tipo_apontamento_pk == 6 || ($dt_ini_ferias != "" && strtotime($dt_ini_ferias) <= strtotime(DataYMD($data)) && strtotime($dt_fim_ferias) >= strtotime(DataYMD($data)))){
                            $tipo_ponto_pk = 12;
                            $dt_hora_ponto = $data; 
                            $hr_ini_expediente = " ";
                            $hr_fim_expediente = " ";
                            $hr_ini_intervalo = " ";
                            $hr_fim_intervalo = " ";  
                            $hr_extra50 = " ";                                    
                            $hr_adicional_noturno = " "; 
                            $hr_excedentes = " ";
                            $hr_faltante = " ";
                            $hr_trabalhadas = " ";
                            $obs = " ";  

                        }else if($tipo_apontamento_pk == 2){
                            $tipo_ponto_pk = 10;
                            $dt_hora_ponto = $data; 
                            $hr_ini_expediente = " ";
                            $hr_fim_expediente = " ";
                            $hr_ini_intervalo = " ";
                            $hr_fim_intervalo = " ";  
                            $hr_extra50 = " ";                                    
                            $hr_adicional_noturno = " ";
                            $hr_excedentes = " ";
                            $hr_faltante = " ";
                            $hr_trabalhadas = " ";
                            $obs = " ";

                            if($motivo_falta_pk == 1){
                                $obs = "Abonada";
                            }else if($motivo_falta_pk == 2){
                                $obs = "Apoio Operacional";
                            }else if($motivo_falta_pk == 3){
                                $obs = "Atestado";
                            }else if($motivo_falta_pk == 4){
                                $obs = "Atraso";
                            }else if($motivo_falta_pk == 5){
                                $obs = "Extensão SDF";
                            }else if($motivo_falta_pk == 6){
                                $obs = "Falta de efetivo";
                            }else if($motivo_falta_pk == 7){
                                $obs = "Falta sem justificativa";
                            }else if($motivo_falta_pk == 8){
                                $obs = "Licença";
                            }else if($motivo_falta_pk == 9){
                                $obs = "Remanejamento";
                            }else if($motivo_falta_pk == 10){
                                $obs = "Reciclagem";
                            }
                            
                        }else if($tipo_apontamento_pk == 3){
                            $tipo_ponto_pk = 5;
                            $dt_hora_ponto = $data; 
                            $hr_ini_expediente = " ";
                            $hr_fim_expediente = " ";
                            $hr_ini_intervalo = " ";
                            $hr_fim_intervalo = " ";  
                            $hr_extra50 = " ";                                    
                            $hr_adicional_noturno = " "; 
                            $hr_excedentes = " ";
                            $hr_faltante = " ";
                            $hr_trabalhadas = " ";
                            $obs = " ";  

                        }else if($queryapontamento[0]['pk']!="" ){
                            $hr_ini_expediente = " " ;
                            $hr_fim_expediente = " " ;
                            $hr_ini_intervalo = " " ;
                            $hr_fim_intervalo = " " ;
                            $dt_hora_ponto = $data; 
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $hr_turno_dia = " " ;
                            $hr_intervalo = " " ;
                            $hr_extra50 = " " ;
                            $hr_adicional_noturno = " " ;
                            $obs = "Apontamento";
                            $ic_escala = 1;
                            $tipo_ponto_pk = 1;
                            
                            $hr_ini_expediente = $queryapontamento[0]['ini_expediente'];
                            $hr_fim_expediente = $queryapontamento[0]['fim_expediente'];
                            $hr_ini_intervalo = $queryapontamento[0]['ini_intervalo'];
                            $hr_fim_intervalo = $queryapontamento[0]['fim_intervalo'];
                            
                            if($hr_ini_expediente != '' && $hr_fim_expediente != ''){
                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                            }

                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                            if($ic_intrajornada == 1){
                                $hr_extra50 = "01:00";
                            }
                            
                            //Calcula HE e HF
                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){
                                if($hr_trabalhadas < $hr_turno_dia){
                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                }else {
                                    $hr_excedentes = " ";
                                    $hr_faltante = " ";
                                }                
                            }else{
                                $hr_excedentes = " ";
                                $hr_faltante = " ";
                            }    

                            //Calcular AN
                            if($turnos_pk==3 && $hr_trabalhadas != ""){
                                $partes_hr_excedentes = explode(":", $hr_excedentes);
                                $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                $partes_hr_excedentes = $partes_hr_excedentes+480;

                                $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                //$horas = ($hr_adicional_noturno / 60)|0;
                                $horas = 8;
                                $horas = $horas < 0 ? $horas * -1 : $horas;
                                //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                $min = 00;  
                                $hr_adicional_noturno = $horas.":".$min;   
                            }

                        }else{
                            $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                            $dia1 = $diaIniPeriodo == $ultimoDia?01:$diaIniPeriodo+1;
                            $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                            //$d1 = (($diaIniPeriodo+1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                            $query2 = $pontodao->listarPontoColaboradorNoturno($d1,$d1,$arrColaborador[$i],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,1);                
                            $query = $pontodao->listarPontoColaboradorPeriodoFolhaRegerar(($data),($data),$arrColaborador[$i],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno);
                            if($ic_escala==1){
                                
                                $hr_ini_expediente = " " ;
                                $hr_fim_expediente = " " ;
                                $hr_ini_intervalo = " " ;
                                $hr_fim_intervalo = " " ;
                                $dt_hora_ponto = $data; 
                                $hr_excedentes = " " ;
                                $hr_faltante = " " ;
                                $hr_trabalhadas = " " ;
                                $hr_turno_dia = " " ;
                                $hr_intervalo = " " ;
                                $hr_extra50 = " " ;
                                $hr_adicional_noturno = " " ;
                                $obs = "App Ponto";

                                if(count($query) > 0){
                                    $dt_hora_ponto = $data; 
                                    for($j = 0; $j < count($query); $j++){  
                                   
                                             
                                        if($query[$j]['tipo_ponto_pk']==1 || $query[$j]['tipo_ponto_pk']==4 ){     
                                                                           
                                            $tipo_ponto_pk = 1;
                              
                                            //Ponto de Entrada  
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_ini_expe']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_ini_expe'])){ 
                                 
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_ini_expediente = $query[$j]['hr_ponto'];
                                                
                                            }

                                            //retorno do intervalo
                                            if($hr_termino_intervalo!="" ){ 
                                                
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_retorno_inter']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_retorno_inter'])){ 
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_fim_intervalo = $query[$j]['hr_ponto']; 
                                                }
                                            }

                                        // echo $hr_ini_expediente.'/'.$hr_fim_expediente.'<br>';
                                        }                                           
                                        if($query[$j]['tipo_ponto_pk']==2 || $query[$j]['tipo_ponto_pk']==3){ 
                                            //Saida para o intervalo     
                                    
                                            if($hr_ini_intervalo_tb!=""){                                                                                                     
                                                if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_saida_inter']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_saida_inter'])){ 
                                                    $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                    $hr_ini_intervalo = $query[$j]['hr_ponto']; 
                                                }
                                            }else{
                                                $hr_extra50 = "01:00";
                                            }               

                                            //Ponto de termonio expediente                                           
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_fim_expe']) && strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_fim_expe']) ){                                                                                          
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_fim_expediente = $query[$j]['hr_ponto'];
                                                
                                            }
                                        }else{ 
                                            if($turnos_pk==3){  
                                                if($query2 > 0){
                                                    $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                                                    $dia1 = $diaIniPeriodo == $ultimoDia?01:$diaIniPeriodo+1;
                                                    $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo);                                        
                                                    //$d1 = (($diaIniPeriodo+1)."/".$MesIniPeriodo."/".$AnoIniPeriodo);                                                
                                                    $query2 = $pontodao->listarPontoColaboradorNoturno($d1,$d1,$arrColaborador[$i],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,2);
                        
                                                    //Termino do Expediente
                                                    if(count($query) > 0){ 
                                                        for($h = 0; $h < count($query2); $h++){
                                                            if(strtotime($query2[$h]['hr_ponto']) > strtotime($query2[$h]['dif_hr_sub_fim_expe']) && strtotime($query2[$h]['hr_ponto']) < strtotime($query2[$h]['dif_hr_add_fim_expe']) ){                                                                                          
                                                                $hr_fim_expediente = $query2[$h]['hr_ponto'];
                                                            }
                                                        }
                                                    } 

                                                    //Saida para o intervalo
                                                    if($hr_ini_intervalo_tb!=""){                                                                                      
                                                        if(strtotime($query2[$j]['hr_ponto']) > strtotime($query2[$j]['dif_hr_sub_saida_inter']) &&  strtotime($query2[$j]['hr_ponto']) < strtotime($query2[$j]['dif_hr_add_saida_inter'])){ 
                                                            $hr_ini_intervalo = $query2[$j]['hr_ponto']; 
                                                        }
                                                    }else{
                                                        $hr_extra50 = "01:00";
                                                    }         
                                                    
                                                    //Retorno do intervalo
                                                    if($hr_termino_intervalo!=""){  
                                                        
                                                        $ultimoDia = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                                                        $dia1 = $diaIniPeriodo == $ultimoDia?01:$diaIniPeriodo+1;
                                                        $d1 = (($dia1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                                                        //$d1 = (($diaIniPeriodo+1)."/".$MesIniPeriodo."/".$AnoIniPeriodo); 
                                                        $query2 = $pontodao->listarPontoColaboradorNoturno($d1,$d1,$arrColaborador[$i],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno,1);                  
                                                        if(strtotime($query2[$j]['hr_ponto']) > strtotime($query2[$j]['dif_hr_sub_retorno_inter']) &&  strtotime($query2[$j]['hr_ponto']) < strtotime($query2[$j]['dif_hr_add_retorno_inter'])){ 
                                                            $hr_fim_intervalo = $query2[$j]['hr_ponto']; 
                                                        }
                                                    }
                            
                                                }else{
                                                    if($ic_preenchimento != "2") {
                                                        $tipo_ponto_pk = 1;
                                                        $dt_hora_ponto = $data; 
                                                        $hr_ini_expediente = $hr_ini_turno;
                                                        $hr_fim_expediente = $hr_fim_turno;
                                                        $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                                        $hr_fim_intervalo = $hr_termino_intervalo;  
                                                        $hr_extra50 = " " ;                                    
                                                        $hr_adicional_noturno = " " ;
                                                        $obs = "Escala";
                                                        $hr_excedentes = " " ;
                                                        $hr_faltante = " " ;
                                                        $hr_trabalhadas = " ";
                                                    }else{
                                                        $tipo_ponto_pk = " " ;
                                                        $dt_hora_ponto = $data;
                                                        $hr_ini_expediente = " " ;
                                                        $hr_fim_expediente = " " ;
                                                        $hr_ini_intervalo  = " " ;
                                                        $hr_fim_intervalo  = " " ; 
                                                        $hr_excedentes = " " ;
                                                        $hr_faltante = " " ;
                                                        $hr_trabalhadas = " " ;
                                                        $hr_extra50 = " ";                                    
                                                        $hr_adicional_noturno = " ";
                                                        $obs = " ";    
                                                    }
                                                }
                                            }  
                                        }  
                                        
                                        $partes_fim_expediente = explode(":", $hr_fim_expediente);
                                        $minutos_fim_expediente = $partes_fim_expediente[0]*60+$partes_fim_expediente[1];

                                        $partes_ini_expediente = explode(":", $hr_ini_expediente);
                                        $minutos_ini_expediente = $partes_ini_expediente[0]*60+$partes_ini_expediente[1];

                                        //Calcula Horas Trabalhadas
                                        $hr_trabalhadas = "";
                                        if($hr_ini_expediente != ' ' && $hr_fim_expediente != ' '){
                                            $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                            $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                        }
        
                                        $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                        $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                        if($ic_intrajornada == 1){
                                            $hr_extra50 = "01:00";
                                        }

                                        if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                            if($hr_trabalhadas < $hr_turno_dia){
                                                $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                            }else if ($hr_trabalhadas > $hr_turno_dia){
                                                $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_excedentes = $queryexcedente[0]['dif'];
                                            }else {
                                                $hr_excedentes = " ";
                                                $hr_faltante = " ";
                                            }                      
                                        }  

                                        if($turnos_pk==3 && $hr_trabalhadas != ""){
                                            $partes_hr_excedentes = explode(":", $hr_excedentes);
                                            $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                            $partes_hr_excedentes = $partes_hr_excedentes+480;
        
                                            $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                            //$horas = ($hr_adicional_noturno / 60)|0;
                                            $horas = 8;
                                            $horas = $horas < 0 ? $horas * -1 : $horas;
                                            //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                            $min = 00;  
                                            $hr_adicional_noturno = $horas.":".$min;   
                                        }
                                    }
                                }else{   
                                    if($ic_preenchimento != "2") {
                                        $tipo_ponto_pk = 1;
                                        $dt_hora_ponto = $data; 
                                        $hr_ini_expediente = $hr_ini_turno;
                                        $hr_fim_expediente = $hr_fim_turno;
                                        $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                        $hr_fim_intervalo = $hr_termino_intervalo;  
                                        $hr_extra50 = " " ;                                    
                                        $hr_adicional_noturno = " " ;
                                        $obs = "Escala";
                                        $hr_excedentes = " " ;
                                        $hr_faltante = " " ;
                                        $hr_trabalhadas = " " ;
                                        $hr_turno_dia = " " ;

                                        //Calcula Horas Trabalhadas
                                        if($hr_ini_expediente != ' ' && $hr_fim_expediente != ' '){
                                            $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                            $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                        }
        
                                        $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                        $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                        if($ic_intrajornada == 1){
                                            $hr_extra50 = "01:00";
                                        }

                                        if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                            if($hr_trabalhadas < $hr_turno_dia){
                                                $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                            }else if ($hr_trabalhadas > $hr_turno_dia){
                                                $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_excedentes = $queryexcedente[0]['dif'];
                                            }else {
                                                $hr_excedentes = " ";
                                                $hr_faltante = " ";
                                            }                
                                        }   
                                        if($turnos_pk==3 && $hr_trabalhadas != ""){
                                            $partes_hr_excedentes = explode(":", $hr_excedentes);
                                            $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                            $partes_hr_excedentes = $partes_hr_excedentes+480;
        
                                            $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                            //$horas = ($hr_adicional_noturno / 60)|0;
                                            $horas = 8;
                                            $horas = $horas < 0 ? $horas * -1 : $horas;
                                            //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                            $min = 00;  
                                            $hr_adicional_noturno = $horas.":".$min;   
                                        }
                                    }else{
                                        $tipo_ponto_pk = " " ;
                                        $dt_hora_ponto = $data;
                                        $hr_ini_expediente = " " ;
                                        $hr_fim_expediente = " " ;
                                        $hr_ini_intervalo  = " " ;
                                        $hr_fim_intervalo  = " " ; 
                                        $hr_excedentes = " " ;
                                        $hr_faltante = " " ;
                                        $hr_trabalhadas = " " ;
                                        $obs = " ";    
                                    }
                                }
                            
                            }else{                                 
                                if($ic_preenchimento != "2") {
                                    //FOLGA      
                                    $tipo_ponto_pk = 5;
                                    $dt_hora_ponto = $data;
                                    $hr_ini_expediente = " " ;
                                    $hr_fim_expediente = " " ;
                                    $hr_ini_intervalo  = " " ;
                                    $hr_fim_intervalo  = " " ; 
                                    $hr_excedentes = " " ;
                                    $hr_faltante = " " ;
                                    $hr_trabalhadas = " " ;
                                    $hr_extra50 = " ";                                    
                                    $hr_adicional_noturno = " ";
                                    $obs = " "; 
                                }else{
                                    $tipo_ponto_pk = " " ;
                                    $dt_hora_ponto = $data;
                                    $hr_ini_expediente = " " ;
                                    $hr_fim_expediente = " " ;
                                    $hr_ini_intervalo  = " " ;
                                    $hr_fim_intervalo  = " " ; 
                                    $hr_excedentes = " " ;
                                    $hr_faltante = " " ;
                                    $hr_trabalhadas = " " ;
                                    $hr_extra50 = " ";                                    
                                    $hr_adicional_noturno = " ";
                                    $obs = " "; 
                                }   
                            }
                        
                        }
                    }else{  
    
                        $hr_excedentes = " " ;
                        $hr_faltante = " " ;
                        $hr_trabalhadas = " " ;
                        if($tipo_apontamento_pk == 5 || ($dt_ini_afastamento != "" && strtotime($dt_ini_afastamento) <= strtotime(DataYMD($data)) && strtotime($dt_fim_afastamento) >= strtotime(DataYMD($data)))){
                            
                            $tipo_ponto_pk = 15;
                            $dt_hora_ponto = $data;
                            $hr_ini_expediente = " " ;
                            $hr_fim_expediente = " " ;
                            $hr_ini_intervalo = " " ;
                            $hr_fim_intervalo = " " ;  
                            $hr_extra50 = " " ;                                    
                            $hr_adicional_noturno = " " ; 
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $obs = " " ;
                            if($motivo_afastamento_pk == 1){
                                $obs = "Motivos Médicos";
                            }else if($motivo_afastamento_pk == 2){
                                $obs = "Invalides";
                            } 

                        }else if($tipo_apontamento_pk == 6 || ($dt_ini_ferias != "" && strtotime($dt_ini_ferias) <= strtotime(DataYMD($data)) && strtotime($dt_fim_ferias) >= strtotime(DataYMD($data)))){
                            $tipo_ponto_pk = 12;
                            $dt_hora_ponto = $data;
                            $hr_ini_expediente = " " ;
                            $hr_fim_expediente = " " ;
                            $hr_ini_intervalo = " " ;
                            $hr_fim_intervalo = " " ;  
                            $hr_extra50 = " " ;                                    
                            $hr_adicional_noturno = " " ; 
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $obs = " " ;  
                                
                        }else if($tipo_apontamento_pk == 2){
                            $tipo_ponto_pk = 10;
                            $dt_hora_ponto = $data;
                            $hr_ini_expediente = " " ;
                            $hr_fim_expediente = " " ;
                            $hr_ini_intervalo = " " ;
                            $hr_fim_intervalo = " " ;  
                            $hr_extra50 = " " ;                                    
                            $hr_adicional_noturno = " " ;
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $obs = " " ;
                            if($motivo_falta_pk == 1){
                                $obs = "Abonada";
                            }else if($motivo_falta_pk == 2){
                                $obs = "Apoio Operacional";
                            }else if($motivo_falta_pk == 3){
                                $obs = "Atestado";
                            }else if($motivo_falta_pk == 4){
                                $obs = "Atraso";
                            }else if($motivo_falta_pk == 5){
                                $obs = "Extensão SDF";
                            }else if($motivo_falta_pk == 6){
                                $obs = "Falta de efetivo";
                            }else if($motivo_falta_pk == 7){
                                $obs = "Falta sem justificativa";
                            }else if($motivo_falta_pk == 8){
                                $obs = "Licença";
                            }else if($motivo_falta_pk == 9){
                                $obs = "Remanejamento";
                            }else if($motivo_falta_pk == 10){
                                $obs = "Reciclagem";
                            }
                            
                        }else if($tipo_apontamento_pk == 3){
                            $tipo_ponto_pk = 5;
                            $dt_hora_ponto = $data;
                            $hr_ini_expediente = " " ;
                            $hr_fim_expediente = " " ;
                            $hr_ini_intervalo = " " ;
                            $hr_fim_intervalo = " " ;  
                            $hr_extra50 = " " ;                                    
                            $hr_adicional_noturno = " " ; 
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $obs = " " ;  
                                
                        }else if($queryapontamento[0]['pk']!=""){
                
                            $hr_ini_expediente = $queryapontamento[0]['ini_expediente'];
                            $hr_fim_expediente = $queryapontamento[0]['fim_expediente'];
                            $hr_ini_intervalo = $queryapontamento[0]['ini_intervalo'];
                            $hr_fim_intervalo = $queryapontamento[0]['fim_intervalo'];
                            $dt_hora_ponto = $data;
                            $tipo_ponto_pk = 1;
                            $hr_extra50 = " " ;
                            $hr_adicional_noturno = " " ;
                            $hr_excedentes = " " ;
                            $hr_faltante = " " ;
                            $hr_trabalhadas = " " ;
                            $obs = "Apontamento";

                            if($hr_ini_expediente != ' ' && $hr_fim_expediente != ' '){
                                $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                            }

                            $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                            $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                            if($ic_intrajornada == 1){
                                $hr_extra50 = "01:00";
                            }

                            if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){    
                                if($hr_trabalhadas < $hr_turno_dia){
                                    $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                }else if ($hr_trabalhadas > $hr_turno_dia){
                                    $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                    $hr_excedentes = $queryexcedente[0]['dif'];
                                }else {
                                    $hr_excedentes = " ";
                                    $hr_faltante = " ";
                                }                
                            }   
                            
                            if($turnos_pk==3 && $hr_trabalhadas != ""){
                                $partes_hr_excedentes = explode(":", $hr_excedentes);
                                $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                $partes_hr_excedentes = $partes_hr_excedentes+480;

                                $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                //$horas = ($hr_adicional_noturno / 60)|0;
                                $horas = 8;
                                $horas = $horas < 0 ? $horas * -1 : $horas;
                              //  $min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                $min = 00;  
                                $hr_adicional_noturno = $horas.":".$min;   
                            }

                        }else{
                            if($ic_escala==1){  
                            
                                $query = $pontodao->listarPontoColaboradorPeriodoFolha(DataDMY($data),DataDMY($data),$arrColaborador[$i],$hr_ini_turno,$hr_ini_intervalo_tb,$hr_termino_intervalo,$hr_fim_turno);
                                $hr_ini_expediente = " " ;
                                $hr_fim_expediente = " " ;
                                $hr_ini_intervalo = " " ;
                                $hr_fim_intervalo = " " ;
                                $hr_excedentes = " " ;
                                $hr_faltante = " " ;
                                $hr_trabalhadas = " " ;
                                $obs = "App Ponto";

                                if(count($query) > 0){ 
                                    for($j = 0; $j < count($query); $j++){ 
                                        $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                        if($query[$j]['tipo_ponto_pk']==1 or $query[$j]['tipo_ponto_pk']==4 ){
                                            $tipo_ponto_pk = 1;
                                            //Ponto de Entrada  
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_ini_expe']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_ini_expe'])){ 
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_ini_expediente = $query[$j]['hr_ponto'];
                                            }
                                            //retorno do intervalo
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_retorno_inter']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_retorno_inter'])){ 
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_fim_intervalo = $query[$j]['hr_ponto']; 
                                            }
                                        }    
                                        if($query[$j]['tipo_ponto_pk']==2 or $query[$j]['tipo_ponto_pk']==3){ 
                                            $tipo_ponto_pk = 1;
                                            
                                            //Saída para o intervalo                                                    
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_saida_inter']) &&  strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_saida_inter'])){ 
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_ini_intervalo = $query[$j]['hr_ponto']; 
                                            }
                                            //Ponto de termino expediente 
                                            if(strtotime($query[$j]['hr_ponto']) > strtotime($query[$j]['dif_hr_sub_fim_expe']) && strtotime($query[$j]['hr_ponto']) < strtotime($query[$j]['dif_hr_add_fim_expe']) ){                                           
                                                $dt_hora_ponto = $query[$j]['dt_ponto']; 
                                                $hr_fim_expediente = $query[$j]['hr_ponto'];
                                            }
                                        }

                                        $hr_trabalhadas = "";
                                        if($hr_ini_expediente != ' ' && $hr_fim_expediente != ' '){
                                            $hr_trab =$this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                        }
        
                                        $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                        $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];

                                        if($ic_intrajornada == 1){
                                            $hr_extra50 = "01:00";
                                        }
                                        
                                        if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){ 
                                            if($hr_trabalhadas < $hr_turno_dia){
                                                $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                            }else if ($hr_trabalhadas > $hr_turno_dia){
                                                $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_excedentes = $queryexcedente[0]['dif'];
                                            }else {
                                                $hr_excedentes = " ";
                                                $hr_faltante = " ";
                                            }                  
                                        }  
                                        
                                    }
                                }else{      
                                    if($ic_preenchimento != "2") {
                                        $tipo_ponto_pk = 1;
                                        $dt_hora_ponto = $data;
                                        $hr_ini_expediente = $hr_ini_turno;
                                        $hr_fim_expediente = $hr_fim_turno;
                                        $hr_ini_intervalo = $hr_ini_intervalo_tb;
                                        $hr_fim_intervalo = $hr_termino_intervalo;  
                                        $hr_extra50 = " " ;                                    
                                        $hr_adicional_noturno = " " ;
                                        $obs = "Escala";
                                        $hr_excedentes = " " ;
                                        $hr_faltante = " " ;
                                        $hr_trabalhadas = " " ;

                                        if($hr_ini_expediente != ' ' && $hr_fim_expediente != ' '){
                                            $hr_trab = $this->calcularHrsTrabalhadas($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $turnos_pk);
                                            $hr_trabalhadas = $hr_trab[0]['hr_trabalhadas'];
                                        }
        
                                        $hr_turno = $this->calcularTurno($ic_intrajornada, $hr_ini_expediente, $hr_fim_expediente, $hr_termino_intervalo, $hr_ini_intervalo_tb, $hr_ini_turno, $hr_fim_turno);
                                        $hr_turno_dia = $hr_turno[0]['hr_turno_dia'];
                                        
                                        if($ic_intrajornada == 1){
                                            $hr_extra50 = "01:00";
                                        }

                                        if($hr_turno_dia!="" && $hr_trabalhadas > "06:00"){   
                                            
                                            if($hr_trabalhadas < $hr_turno_dia){
                                                $queryfaltantes = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                            }else if ($hr_trabalhadas > $hr_turno_dia){
                                                $queryexcedente = $this->retornarDifHora($hr_turno_dia,$hr_trabalhadas); 
                                                $hr_excedentes = $queryexcedente[0]['dif'];
                                            }else {
                                                $hr_excedentes = " ";
                                                $hr_faltante = " ";
                                            }                   
                                        }  

                                        if($turnos_pk==3 && $hr_trabalhadas != ""){
                                            $partes_hr_excedentes = explode(":", $hr_excedentes);
                                            $partes_hr_excedentes = $partes_hr_excedentes[0]*60+$partes_hr_excedentes[1];
                                            $partes_hr_excedentes = $partes_hr_excedentes+480;
        
                                            $hr_adicional_noturno  = $partes_hr_excedentes < 0 ? $partes_hr_excedentes * -1 : $partes_hr_excedentes;
                                            //$horas = ($hr_adicional_noturno / 60)|0;
                                            $horas = 8;
                                            $horas = $horas < 0 ? $horas * -1 : $horas;
                                            //$min = $hr_adicional_noturno < 0 ? $hr_adicional_noturno % 60 * -1 : $hr_adicional_noturno % 60;  
                                            $min = 00;  
                                            $hr_adicional_noturno = $horas.":".$min;   
                                        }
                                    }else{
                                        $tipo_ponto_pk = " " ;
                                        $dt_hora_ponto = $data;
                                        $hr_ini_expediente = " " ;
                                        $hr_fim_expediente = " " ;
                                        $hr_ini_intervalo  = " " ;
                                        $hr_fim_intervalo  = " " ; 
                                        $hr_excedentes = " " ;
                                        $hr_faltante = " " ;
                                        $hr_trabalhadas = " " ;
                                        $obs = " ";    
                                    }
                                }  
                                
                            }else{
                                if($ic_preenchimento != "2") {
                                    //FOLGA      
                                    $tipo_ponto_pk = 5;
                                    $dt_hora_ponto = $data;
                                    $hr_ini_expediente = " " ;
                                    $hr_fim_expediente = " " ;
                                    $hr_ini_intervalo  = " " ;
                                    $hr_fim_intervalo  = " " ; 
                                    $hr_excedentes = " " ;
                                    $hr_faltante = " " ;
                                    $hr_trabalhadas = " " ;
                                    $hr_extra50 = " ";                                    
                                    $hr_adicional_noturno = " ";
                                    $obs = " "; 
                                }else{
                                    $tipo_ponto_pk = " ";
                                    $dt_hora_ponto = $data;
                                    $hr_ini_expediente = " ";
                                    $hr_fim_expediente = " ";
                                    $hr_ini_intervalo  = " ";
                                    $hr_fim_intervalo  = " "; 
                                    $hr_excedentes = " ";
                                    $hr_faltante = " ";
                                    $hr_trabalhadas = " ";
                                    $hr_extra50 = " ";                                    
                                    $hr_adicional_noturno = " ";
                                    $obs = " "; 
                                }                    
                            }   
                        }

                        
                    }
                    
                    $ponto_folha_registro = $ponto_folha_registrodao->carregarPorPk($queryRegistrosPonto[$l]['ponto_folha_registro_pk']);
                    $ponto_folha_registro->setponto_folha_pk($queryRegistrosPonto[$l]['ponto_folha_pk']);
                    $ponto_folha_registro->settipo_ponto_pk($tipo_ponto_pk);
                    $ponto_folha_registro->setdt_hora_ponto($dt_hora_ponto);                        
                    $ponto_folha_registro->setcolaborador_pk($arrColaborador[$i]);              
                    $ponto_folha_registro->sethr_ini_expediente($hr_ini_expediente);
                    $ponto_folha_registro->sethr_ini_intervalo($hr_ini_intervalo);
                    $ponto_folha_registro->sethr_fim_intervalo($hr_fim_intervalo);
                    $ponto_folha_registro->sethr_fim_expediente($hr_fim_expediente);
                    $ponto_folha_registro->sethr_trabalhadas($hr_trabalhadas);
                    $ponto_folha_registro->sethr_excedente($hr_excedentes);
                    $ponto_folha_registro->sethr_faltantes($hr_faltante);
                    $ponto_folha_registro->sethr_extra50($hr_extra50);
                    $ponto_folha_registro->sethr_extra100($hr_extra100);
                    $ponto_folha_registro->sethr_adicional_noturno($hr_adicional_noturno); 
                    $ponto_folha_registro->setobs($obs); 

                    $ponto_folha_registrodao->salvar($ponto_folha_registro);
                }
                

                $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo); 
                if($diaIniPeriodo == $ultimoDiaMes){
                    if($MesIniPeriodo==12 && $ultimoDiaMes==31){             
                        $MesIniPeriodo = "01";
                        $AnoIniPeriodo ++;
                    }else{
                        $MesIniPeriodo++;
                    }   
                    $diaIniPeriodo = "01"; 
                }else{
                    $diaIniPeriodo++;
                }
                
            }
        }
    }

    public function salvarColaborador($ponto_folha_pk,$colaborador_pk){

        $fields = array();
        $fields['ponto_folha_pk'] = $ponto_folha_pk;
        $fields['colaborador_pk'] = $colaborador_pk;
        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $this->arrToken['usuarios_pk'];

        $fields["dt_cadastro"] = "sysdate()";
        $fields["usuario_cadastro_pk"]   = $this->arrToken['usuarios_pk'];

        $pk = $this->db->execInsert("ponto_folha_colaborador", $fields);
        return $pk;

    }

    public function excluir($pk){ 
        $this->db->execDelete("ponto_folha"," pk = ".$pk);   

    }

    public function excluir_ponto_folha_colaborador($pk){ 
        $this->db->execDelete("ponto_folha_colaborador"," ponto_folha_pk = ".$pk);   

    }    
    
    //antigo    
    public function excluirPontoEPontoFolhaRegistro($ponto_pk){
        $this->db->execDelete("ponto"," pk = ".$ponto_pk);
        $this->db->execDelete("ponto_folha_registros"," ponto_pk = ".$ponto_pk);
    }
    public function carregarPorPk($pk){

        $ponto_folha = new ponto_folha();
        if($pk != ""){
            
        $sql ="select pk ";
        $sql.="      , date_format(dt_cadastro,'%d/%m/%Y') dt_cadastro ";
        $sql.="      , usuario_cadastro_pk ";
        $sql.="      , date_format(dt_ult_atualizacao,'%d/%m/%Y') dt_ult_atualizacao ";
        $sql.="      , usuario_ult_atualizacao_pk ";

        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_periodo_ini ";
        $sql.="       ,dt_periodo_fim ";
        $sql.="       ,obs ";
        $sql.="       ,leads_pk";
        $sql.="  from ponto_folha ";
        $sql.=" where pk = $pk ";
            $query = $this->db->execQuery($sql);
            for($i = 0; $i < count($query); $i++){
                $ponto_folha->setpk($query[$i]["pk"]);
                $ponto_folha->setdt_cadastro($query[$i]["dt_cadastro"]);
                $ponto_folha->setusuario_cadastro_pk($query[$i]["usuario_cadastro_pk"]);
                $ponto_folha->setdt_ult_atualizacao($query[$i]["dt_ult_atualizacao"]);
                $ponto_folha->setusuario_ult_atualizacao_pk($query[$i]["usuario_ult_atualizacao_pk"]);

                $ponto_folha->setcolaborador_pk($query[$i]['colaborador_pk']);
                $ponto_folha->setdt_periodo_ini($query[$i]['dt_periodo_ini']);
                $ponto_folha->setdt_periodo_fim($query[$i]['dt_periodo_fim']);
                $ponto_folha->setobs($query[$i]['obs']);

            }
        }
        return $ponto_folha;
    }

    public function listarPorPk($pk){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_periodo_ini ";
        $sql.="       ,dt_periodo_fim ";
        $sql.="       ,obs ";
        $sql.="       ,leads_pk";
        $sql.="  from ponto_folha ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPkPontoFolhaRegistro($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from ponto_folha_registros ";
        $sql.=" where ponto_pk = $pk ";
    
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPkPonto($pk){

        $sql ="";
        $sql.="select pk";

        $sql.="  from ponto ";
        $sql.=" where pk = $pk ";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPontoFolhaAntigo(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk  ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_periodo_ini ";
        $sql.="       ,dt_periodo_fim ";
        $sql.="       ,obs ";
        $sql.="       ,leads_pk";

        $sql.="  from ponto_folha ";
        $sql.=" where colaborador_pk is not null";
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function query1(){

        $sql.=" select pf.pk,  pf.usuario_cadastro_pk, pf.dt_ult_atualizacao, pf.usuario_ult_atualizacao_pk ";
        $sql.="                ,pf.colaborador_pk ";
        $sql.="                ,date_format(pf.dt_periodo_ini,'%d/%m/%Y')dt_periodo_ini";
        $sql.="                ,date_format(pf.dt_periodo_fim,'%d/%m/%Y')dt_periodo_fim";
        $sql.="                ,date_format(pf.dt_cadastro,'%d/%m/%Y')dt_cadastro";
        $sql.="                ,pf.obs ";
        $sql.="                ,pf.leads_pk";
        $sql.="                ,l.ds_lead";
        $sql.="                ,c.ds_colaborador";
        $sql.="                ,c.pk colaborador_pk";

        $sql.="           from ponto_folha pf";
        $sql.="                inner join leads l on pf.leads_pk = l.pk";
        $sql.="                left join colaboradores c on pf.colaborador_pk = c.pk";
        $sql.="                LEFT JOIN ponto_solicitacao_liberacao_app psl ON c.pk = psl.colaborador_pk";
        $sql.="                left join colaboradores_produtos_servicos cps  on c.pk = cps.colaboradores_pk";
        $sql.="         where 1=1 ";
        $sql.="         and pf.colaborador_pk is not null";

        //$sql.="           group by pf.dt_periodo_ini,l.pk";


        $sql.="         order by pf.colaborador_pk asc ";
        
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function query2($leads_pk,$dt_ini,$dt_fim){

       $sql="";
        $sql.="select pf.pk,  pf.usuario_cadastro_pk, pf.dt_ult_atualizacao, pf.usuario_ult_atualizacao_pk ";
        $sql.="       ,pf.colaborador_pk ";
        $sql.="       ,date_format(pf.dt_periodo_ini,'%d/%m/%Y')dt_periodo_ini";
        $sql.="       ,date_format(pf.dt_periodo_fim,'%d/%m/%Y')dt_periodo_fim";
        $sql.="       ,date_format(pf.dt_cadastro,'%d/%m/%Y')dt_cadastro";
        $sql.="       ,pf.obs ";
        $sql.="       ,pf.leads_pk";
        $sql.="       ,l.ds_lead";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,c.pk colaborador_pk";

        $sql.="  from ponto_folha pf";
        $sql.="       inner join leads l on pf.leads_pk = l.pk";
        $sql.="       inner join colaboradores c on pf.colaborador_pk = c.pk";
        $sql.="       LEFT JOIN ponto_solicitacao_liberacao_app psl ON c.pk = psl.colaborador_pk";
        $sql.="       left join colaboradores_produtos_servicos cps  on c.pk = cps.colaboradores_pk";
        $sql.=" where 1=1 ";
        $sql.=" and l.pk=".$leads_pk;
        $sql.=" and pf.dt_periodo_ini ='".DataYMD($dt_ini)."'";
        $sql.=" and pf.dt_periodo_fim ='".DataYMD($dt_fim)."'";
        $sql.=" group by c.pk";
        $sql.=" order by pf.colaborador_pk asc ";
        
       
        $query = $this->db->execQuery($sql);
        return $query;

    }

    
    public function listarGridPontoFolhaPostoTrabalho($leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql ="";
        $sql.="SELECT ";
        $sql.="            pf.pk,";
        $sql.="            pf.leads_pk,";
        $sql.="            l.ds_lead,";
        $sql.="            DATE_FORMAT(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim";
        $sql.="        FROM";
        $sql.="            ponto_folha pf";
        $sql.="            inner join ponto_folha_colaborador pfc on pf.pk = pfc.ponto_folha_pk";
        $sql.="                INNER JOIN";
        $sql.="            leads l ON pf.leads_pk = l.pk";
        $sql.="         where 1=1 ";
                    
        if($dt_periodo_ini!=""){
            $sql.=" and pf.dt_periodo_ini ='".DataYMD($dt_periodo_ini)."'";
        }
        if($dt_periodo_fim!=""){
            $sql.=" and pf.dt_periodo_fim ='".DataYMD($dt_periodo_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and pfc.colaborador_pk =".($colaborador_pk);
        }
        
        $sql.=" group by pf.pk";
        $sql.=" order by pf.pk desc";
      
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarImpressaoPontoFolhaPostoTrabalho($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql ="";
        $sql.="SELECT ";
        $sql.="            pf.pk,";
        $sql.="            l.ds_lead,";
        $sql.="            pfc.colaborador_pk,";
        $sql.="            DATE_FORMAT(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim";
        $sql.="        FROM";
        $sql.="            ponto_folha pf";
        $sql.="            inner join ponto_folha_colaborador pfc on pf.pk = pfc.ponto_folha_pk";
        $sql.="                INNER JOIN";
        $sql.="            leads l ON pf.leads_pk = l.pk";
        $sql.="         where 1=1 ";
                    
        if($dt_periodo_ini!=""){
            $sql.=" and pf.dt_periodo_ini ='".DataYMD($dt_periodo_ini)."'";
        }
        if($dt_periodo_fim!=""){
            $sql.=" and pf.dt_periodo_fim ='".DataYMD($dt_periodo_fim)."'";
        }
        if($colaborador_pk!=""){
            $sql.=" and pfc.colaborador_pk =".($colaborador_pk);
        }
        if($pk!=""){
            $sql.=" and pf.pk =".($pk);
        }
        
        //$sql.=" group by pf.pk";
        $sql.=" order by pf.pk desc";
      
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarModalPontoFolhaPostoTrabalho($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql ="";
        $sql.="SELECT ";
        $sql.="            pf.pk,";
        $sql.="            l.ds_lead,";
        $sql.="            c.ds_colaborador,";
        $sql.="            c.pk colaborador_pk,";
        $sql.="            DATE_FORMAT(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim";
        $sql.="        FROM";
        $sql.="            ponto_folha pf";
        $sql.="            inner join ponto_folha_colaborador pfc on pf.pk = pfc.ponto_folha_pk";
        $sql.="            inner join colaboradores c on pfc.colaborador_pk = c.pk";
        $sql.="                INNER JOIN";
        $sql.="            leads l ON pf.leads_pk = l.pk";
        $sql.="         where 1=1 ";
                    
        if($dt_periodo_ini!=""){
            $sql.=" and pf.dt_periodo_ini ='".DataYMD($dt_periodo_ini)."'";
        }
        if($dt_periodo_fim!=""){
            $sql.=" and pf.dt_periodo_fim ='".DataYMD($dt_periodo_fim)."'";
        }
        if($pk!=""){
            $sql.=" and pf.pk =".($pk);
        }
        if($colaborador_pk!=""){
            $sql.=" and c.colaborador_pk =".($colaborador_pk);
        }
        
        
        $sql.=" order by pf.pk desc";
      
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPontoColaborador($pk,$leads_pk,$dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql ="";
        $sql.="SELECT ";
        $sql.="            pt.pk ponto_pk,";
        $sql.="            pf.pk,";
        $sql.="            l.ds_lead,";
        $sql.="            c.ds_colaborador,";
        $sql.="            pfr.tipo_ponto_pk,";
        $sql.="            DATE_FORMAT(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="            DATE_FORMAT(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="            date_format(pfr.dt_hora_ponto,'%d/%m/%Y') dt_hora_ponto,";
        $sql.="            date_format(pfr.dt_hora_ponto,'%H:%i:%s') hr_entrada";
        
        $sql.="        FROM";
        $sql.="            ponto_folha pf";
        $sql.="            inner join ponto_folha_colaborador pfc on pf.pk = pfc.ponto_folha_pk";
        $sql.="            left join ponto_folha_registros pfr on pf.pk = pfr.ponto_folha_pk";
        $sql.="            inner join colaboradores c on pfc.colaborador_pk = c.pk";
        $sql.="            inner join ponto pt on pfr.ponto_pk = pt.pk";
        $sql.="                INNER JOIN";
        $sql.="            leads l ON pf.leads_pk = l.pk";
        $sql.="         where 1=1 ";
                    
        if($dt_periodo_ini!=""){
            $sql.=" and pfr.dt_hora_ponto >='".DataYMD($dt_periodo_ini)." 00:00:00'";
        }
        if($dt_periodo_fim!=""){
            $sql.=" and pfr.dt_hora_ponto<='".DataYMD($dt_periodo_fim)." 23:59:59'";
        }
        if($pk!=""){
            $sql.=" and pf.pk =".($pk);
        }
        if($leads_pk!=""){
            $sql.=" and l.pk =".($leads_pk);
        }
        if($colaborador_pk!=""){
            $sql.=" and pt.colaborador_pk =".($colaborador_pk);
        }
        
        
        $sql.=" order by pf.pk desc";
        
       
        $query = $this->db->execQuery($sql);
        return $query;

    }
    public function listarPorColaborador($colaborador_pk){

        $sql ="";
        $sql.="select p.pk, p.dt_cadastro, p.usuario_cadastro_pk, p.dt_ult_atualizacao, p.usuario_ult_atualizacao_pk ";
        $sql.="       ,p.colaborador_pk ";
        $sql.="       ,date_format(p.dt_periodo_ini,'%d/%m/%Y')dt_periodo_ini ";
        $sql.="       ,date_format(p.dt_periodo_fim,'%d/%m/%Y')dt_periodo_fim ";
        $sql.="       ,p.obs ";
        $sql.="       ,p.leads_pk";
        $sql.="       ,c.ds_colaborador";
        $sql.="       ,c.pk colaborador_pk";

        $sql.="  from ponto_folha p";
        $sql.="       inner join colaboradores c on p.colaborador_pk = c.pk";
        $sql.=" where 1=1 ";
        if($colaborador_pk != ""){
            $sql.=" and p.colaborador_pk =".$colaborador_pk;
        }
        $sql.=" order by c.ds_colaborador asc ";
        

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarTodos(){

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,colaborador_pk ";
        $sql.="       ,dt_periodo_ini ";
        $sql.="       ,dt_periodo_fim ";
        $sql.="       ,obs ";
        $sql.="       ,leads_pk";

        $sql.="  from ponto_folha ";
        $sql.=" where 1=1 ";
        $sql.=" order by colaborador_pk asc ";

        $query = $this->db->execQuery($sql);
        return $query;

    }

    public function listarDadosPrintAll($ponto_folha_pk,$leads_pk){

        $ponto_folha_registrodao = new ponto_folha_registrodao();
        $ponto_folha_registrodao->setToken($token); 

        $sql ="";
        $sql.=" SELECT DISTINCT pf.pk,";
        $sql.="        c.ds_razao_social ds_empresa,";
        $sql.="        c.ds_endereco,";
        $sql.="        c.ds_numero,";
        $sql.="        c.ds_cpf_cnpj ds_cnpj_conta,";
        $sql.="        l.ds_lead ds_posto_trabalho,";
        $sql.="        date_format(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="        date_format(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="        date_format(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro,";
        $sql.="        col.ds_colaborador,";
        $sql.="        col.ds_cpf,";
        $sql.="        ps.ds_produto_servico ds_cargo,";
        $sql.="        a.n_qtde_dias_semana,";
        $sql.="        t.ds_turno,";
        $sql.="        a.hr_inicio_expediente,";
        $sql.="        a.hr_termino_expediente,";
        $sql.="        a.hr_saida_intervalo,";
        $sql.="        a.hr_retorno_intervalo, ";
        $sql.="        a.turnos_pk,";        
        $sql.="        pfc.ponto_folha_pk, ";  
        $sql.="    date_format(col.dt_admissao, '%d/%m/%Y') dt_admissao,";  
        $sql.="        pfc.colaborador_pk ";    
        $sql.="   FROM ponto_folha pf";
        $sql.="  LEFT  JOIN contas c ON pf.empresas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        $sql.="  INNER JOIN ponto_folha_colaborador pfc ON pf.pk = pfc.ponto_folha_pk";  
        $sql.="  INNER JOIN agenda_colaborador_padrao a ON pfc.colaborador_pk = a.colaboradores_pk";
        $sql.="  LEFT  JOIN turnos t ON a.turnos_pk = t.pk";
        $sql.="  INNER JOIN colaboradores col ON pfc.colaborador_pk = col.pk";
        $sql.="  INNER JOIN colaboradores_produtos_servicos cps  ON col.pk = cps.colaboradores_pk";
        $sql.="  INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        
        if(!empty($ponto_folha_pk)){
            $sql.=" WHERE pfc.ponto_folha_pk=".$ponto_folha_pk;
        }
        $sql.=" AND a.dt_cancelamento is null";
        if(!empty($leads_pk)){
            $sql.=" AND pf.leads_pk=".$leads_pk;
            $sql.=" AND a.leads_pk =".$leads_pk;
            
        }

        $query = $this->db->execQuery($sql);

        if(count($query) > 0){            

            for($i = 0; $i < count($query); $i++){ 

               // $DadosFolhaRegistros = "";
                $colaborador_pk = $query[$i]['colaborador_pk'];

                //Total Horas Trabalhadas
                $queryHrTrabalhadas = $this->TotalHrTrabalhada($ponto_folha_pk,$colaborador_pk);                       
                $v_total_ht = "";
                $v_total_ht = $queryHrTrabalhadas[$i]['total_hr_trabalhadas'];
                            
                //Total Horas Excedentes
                $queryHrExcedentes = $this->TotalHrExcedentes($ponto_folha_pk,$colaborador_pk);                       
                $v_total_he = "";
                $v_total_he = $queryHrExcedentes[$i]['total_hr_excedente'];
                            
                //Total Horas Excedentes
                $queryHrFaltantes = $this->TotalHrFaltantes($ponto_folha_pk,$colaborador_pk);                       
                $v_total_hf = "";
                $v_total_hf = $queryHrFaltantes[$i]['total_hr_faltantes'];
                
                //Total Hora extra 50%
                $queryHrExtra50 = $this->TotalHrExtra50($ponto_folha_pk,$colaborador_pk);                       
                $v_total_he50 = "";
                $v_total_he50 = $queryHrExtra50[$i]['total_hr_extra50'];

                //Total Hora extra 100%
                $queryHrExtra100 = $this->TotalHrExtra100($ponto_folha_pk,$colaborador_pk);                       
                $v_total_he100 = "";
                $v_total_he100 = $queryHrExtra100[$i]['total_hr_extra100'];  
                
                //Total Hora Adicional Noturno
                $queryHrAdn = $this->TotalHrAdn($ponto_folha_pk,$colaborador_pk);                       
                $v_total_hadn = "";
                $v_total_hadn = $queryHrExtra100[$i]['total_hr_adicional_noturno'];  
                            
                $queryTempoExpediente  = $this->retornarDifHora($query[$i]['hr_inicio_expediente'],$query[$i]['hr_termino_expediente']);
                $expediente_diario = "";
                $expediente_diario = $queryTempoExpediente[$i]['dif']; 
                $queryListarFolhaRegistros = $ponto_folha_registrodao->listarFolhaRegistrosAgrupadoData($ponto_folha_pk,$colaborador_pk);
            
                for($j = 0; $j < count($queryListarFolhaRegistros); $j++){ 
        
                    $v_hr_extra50 = "";
                    //$v_hr_adicional_noturno = "";   
                    //hora extra 
                    if($queryListarFolhaRegistros[$j]['hr_extra50']==""){
                        if($queryListarFolhaRegistros[$j]['n_qtde_dias_semana']=="12x36"){
                            if($queryListarFolhaRegistros[$j]['hr_saida_intervalo']=="" and $queryListarFolhaRegistros[$j]['hr_retorno_intervalo']=="" ){
                                if($queryListarFolhaRegistros[$j]['tipo_ponto_pk']==1){   
                                    $v1 = "1";                     
                                    $v_hr_extra50 = "01:00";                                                                    
                                    $v_total_he50 += $v_hr_extra50;
                                }                            
                            }
                        }
                    }else{                      
                        $v_hr_extra50 = $queryListarFolhaRegistros[$j]['hr_extra50'];
                    }

                    //Adicional Noturno
                    if($queryListarFolhaRegistros[$j]['hr_adicional_noturno']==""){
                        
                        if($queryListarFolhaRegistros[$j]['n_qtde_dias_semana']=="12x36"){
                        
                            if($queryListarFolhaRegistros[$j]['turnos_pk']==3){
                                
                                if($queryListarFolhaRegistros[$j]['tipo_ponto_pk']==1){
                                    $v2 = "1";
                                    //$v_hr_adicional_noturno = "07:00";
                                    //echo $v_hr_adicional_noturno."<br>";
                                    $v_total_hadn += $v_hr_adicional_noturno; 
                                }    
                            }
                        }    
                    }else{                     
                        $v_hr_adicional_noturno = $queryListarFolhaRegistros[$j]['hr_adicional_noturno']; 
                        $v_total_hadn += $queryListarFolhaRegistros[$j]['hr_adicional_noturno']; 
                    }
                
                    $DadosFolhaRegistros[$j] = array(
                        "ponto_folha_pk"=>$queryListarFolhaRegistros[$j]['ponto_folha_pk'],
                        "ponto_folha_registro_pk"=>$queryListarFolhaRegistros[$j]['ponto_folha_registro_pk'],
                        "colaborador_pk"=> $queryListarFolhaRegistros[$j]['colaborador_pk'],
                        "dt_registro_ponto"=>$queryListarFolhaRegistros[$j]['dt_ponto'],
                        "tipo_ponto_pk"=>$queryListarFolhaRegistros[$j]['tipo_ponto_pk'],
                        "hr_ini_expediente"=>$queryListarFolhaRegistros[$j]['hr_ini_expediente'],
                        "hr_ini_intervalo"=>$queryListarFolhaRegistros[$j]['hr_ini_intervalo'],
                        "hr_fim_intervalo"=>$queryListarFolhaRegistros[$j]['hr_fim_intervalo'],
                        "hr_fim_expediente"=>$queryListarFolhaRegistros[$j]['hr_fim_expediente'],
                        "hr_trabalhadas"=>$queryListarFolhaRegistros[$j]['hr_trabalhadas'],
                        "hr_excedentes"=>$queryListarFolhaRegistros[$j]['hr_excedentes'],
                        "hr_faltantes"=>$queryListarFolhaRegistros[$j]['hr_faltantes'],
                        "hr_extra50"=>$v_hr_extra50,
                        "hr_extra100"=>$queryListarFolhaRegistros[$j]['hr_extra100'],
                        "hr_adicional_noturno"=>$v_hr_adicional_noturno,  
                        "obs"=>$queryListarFolhaRegistros[$j]['obs']
                    );
                }    

               // var_dump($DadosFolhaRegistros);

                if($v1 == 1){
                    if($v_total_he50!=""){
                        if($v_total_he50<=9){
                            $v_total_he50 = "0".$v_total_he50.":00"; 
                        }else{
                            $v_total_he50 = $v_total_he50.":00"; 
                        }          
                    }
                }

                if($v2 == 1){    
                    if($v_hr_adicional_noturno!=""){
                        if($v_hr_adicional_noturno<=9){
                            $$v_hr_adicional_noturno = "0".$v_hr_adicional_noturno.":00"; 
                        }else{
                            $v_hr_adicional_noturno = $v_hr_adicional_noturno.":00"; 
                        }          
                    }
                }

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['dt_periodo_ini']." a ".$query[$i]['dt_periodo_fim'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco']." ,".$query[$i]['ds_numero'],
                    "ds_cnpj"=>$query[$i]['ds_cnpj_conta'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_admissao"=>$query[$i]['dt_admissao'],
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['n_qtde_dias_semana'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ds_hr_expediente"=>$query[$i]['hr_inicio_expediente']." a ".$query[$i]['hr_termino_expediente'],
                    "registrosfolha"=>$DadosFolhaRegistros,
                    "total_ht"=> $v_total_ht,
                    "total_he"=> $v_total_he,
                    "total_hf"=> $v_total_hf,
                    "total_he50"=> $v_total_he50,
                    "total_he100"=> $v_total_he100,
                    "total_hadn"=> $v_total_hadn,
                    "expediente_diario"=> $expediente_diario
                ); 
            } 

            
        }

        return $result;
    }
 


    public function apontamentoPontoColaboradorData($dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql= "";
        $sql.="SELECT aca.pk";
        $sql.="      ,ap.dt_ponto , ap.hr_ponto ";
        $sql.="      ,aca.colaborador_pk";
        $sql.="      ,ap.tipo_ponto_pk";
        $sql.="      ,aca.leads_pk";
        $sql.="  FROM agenda_colaborador_apontamento aca";
        $sql.=" INNER JOIN apontamento_ponto ap ON ap.agenda_colaborador_apontamento_pk = aca.pk";
        $sql.=" WHERE 1 = 1";
        $sql.="   AND aca.tipo_apontamento_pk = 1";
        if($dt_periodo_ini != "" && $dt_periodo_fim != ""){
            $sql.=" AND dt_apontamento >= '".dataYMD($dt_periodo_ini)." 00:00:00'";
            $sql.=" AND dt_apontamento <= '".dataYMD($dt_periodo_fim)." 23:59:59'";
        }
        if($colaborador_pk != ""){
            $sql.=" AND aca.colaborador_pk = ".$colaborador_pk;
        }
        $query = $this->db->execQuery($sql);

        $ini_expediente = "";
        $ini_intervalo = "";
        $fim_intervalo = "";
        $fim_expediente = "";

            for($i=0; $i < count($query); $i++){
                $tipo_ponto_pk = $query[$i]["tipo_ponto_pk"];

                if($tipo_ponto_pk == 1){
                    $ini_expediente =  $query[$i]["hr_ponto"];
                }else if($tipo_ponto_pk == 2){
                    $ini_intervalo =  $query[$i]["hr_ponto"];
                }else if($tipo_ponto_pk == 3){
                    $fim_intervalo =  $query[$i]["hr_ponto"];
                }else if($tipo_ponto_pk == 4){
                    $fim_expediente =  $query[$i]["hr_ponto"];
                }

            }

            $result[] = array(
                "pk" => $query[0]["pk"],
                "dt_hr_ponto" => $query[0]["dt_ponto"] ." ". $query[0]["hr_ponto"],
                "colaborador_pk" => $query[0]["colaborador_pk"],
                "tipo_ponto_pk" => $query[0]["tipo_ponto_pk"],
                "ini_expediente" => $ini_expediente,
                "ini_intervalo" => $ini_intervalo,
                "fim_intervalo" => $fim_intervalo,
                "fim_expediente" => $fim_expediente,
                "leads_pk" => $query[0]["leads_pk"]
            );

        return $result;

    }

    public function apontamentoColaboradorData($dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql= "";
        $sql.="SELECT aca.pk";
        $sql.="      ,aca.colaborador_pk";
        $sql.="      ,aca.dt_apontamento";
        $sql.="      ,aca.tipo_apontamento_pk";
        $sql.="      ,aca.leads_pk";
        $sql.="      ,af.motivo_falta_pk";
        $sql.="  FROM agenda_colaborador_apontamento aca";
        $sql.="  LEFT JOIN apontamento_falta af ON af.agenda_colaborador_apontamento_pk = aca.pk";
        $sql.=" WHERE 1 = 1";
        $sql.="   AND NOT aca.tipo_apontamento_pk = 1";
        if($dt_periodo_ini != "" && $dt_periodo_fim != ""){
            $sql.=" AND dt_apontamento >= '".dataYMD($dt_periodo_ini)." 00:00:00'";
            $sql.=" AND dt_apontamento <= '".dataYMD($dt_periodo_fim)." 23:59:59'";
        }
        if($colaborador_pk != ""){
            $sql.=" AND aca.colaborador_pk = ".$colaborador_pk;
        }
        
        $query = $this->db->execQuery($sql);

        $result[] = array(
            "pk" => $query[0]["pk"],
            "colaborador_pk" => $query[0]["colaborador_pk"],
            "dt_apontamento" => $query[0]["dt_apontamento"],
            "tipo_apontamento_pk" => $query[0]["tipo_apontamento_pk"],
            "motivo_falta_pk" => $query[0]["motivo_falta_pk"]
        );

        return $result;

    }
    public function apontamentoColaboradorFerias($dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql= "";
        $sql.="SELECT aca.pk";
        $sql.="      ,aca.colaborador_pk";
        $sql.="      ,aca.dt_apontamento";
        $sql.="      ,aca.tipo_apontamento_pk";
        $sql.="      ,aca.leads_pk";
        $sql.="      ,afe.dt_ini_ferias";
        $sql.="      ,afe.dt_fim_ferias";
        $sql.="  FROM agenda_colaborador_apontamento aca";
        $sql.="  LEFT JOIN apontamento_ferias afe ON afe.agenda_colaborador_apontamento_pk = aca.pk";
        $sql.=" WHERE 1 = 1";
        $sql.="   AND aca.tipo_apontamento_pk = 6";
        if($dt_periodo_ini != "" && $dt_periodo_fim != ""){
            $sql.=" AND dt_apontamento >= '".dataYMD($dt_periodo_ini)." 00:00:00'";
            $sql.=" AND dt_apontamento <= '".dataYMD($dt_periodo_fim)." 23:59:59'";
        }
        if($colaborador_pk != ""){
            $sql.=" AND aca.colaborador_pk = ".$colaborador_pk;
        }
        
        $query = $this->db->execQuery($sql);

        $result[] = array(
            "pk" => $query[0]["pk"],
            "colaborador_pk" => $query[0]["colaborador_pk"],
            "dt_apontamento" => $query[0]["dt_apontamento"],
            "tipo_apontamento_pk" => $query[0]["tipo_apontamento_pk"],
            "dt_ini_ferias" => $query[0]["dt_ini_ferias"],
            "dt_fim_ferias" => $query[0]["dt_fim_ferias"]
        );

        return $result;

    }
    
    public function apontamentoColaboradorAfastamento($dt_periodo_ini,$dt_periodo_fim,$colaborador_pk){

        $sql= "";
        $sql.="SELECT aca.pk";
        $sql.="      ,aca.colaborador_pk";
        $sql.="      ,aca.dt_apontamento";
        $sql.="      ,aca.tipo_apontamento_pk";
        $sql.="      ,aca.leads_pk";
        $sql.="      ,aa.motivo_afastamento_pk";
        $sql.="      ,aa.dt_ini_afastamento";
        $sql.="      ,aa.dt_fim_afastamento";
        $sql.="  FROM agenda_colaborador_apontamento aca";
        $sql.="  LEFT JOIN apontamento_afastamento aa ON aa.agenda_colaborador_apontamento_pk = aca.pk";
        $sql.=" WHERE 1 = 1";
        $sql.="   AND aca.tipo_apontamento_pk = 5";
        if($dt_periodo_ini != "" && $dt_periodo_fim != ""){
            $sql.=" AND dt_apontamento >= '".dataYMD($dt_periodo_ini)." 00:00:00'";
            $sql.=" AND dt_apontamento <= '".dataYMD($dt_periodo_fim)." 23:59:59'";
        }
        if($colaborador_pk != ""){
            $sql.=" AND aca.colaborador_pk = ".$colaborador_pk;
        }
        
        $query = $this->db->execQuery($sql);

        $result[] = array(
            "pk" => $query[0]["pk"],
            "colaborador_pk" => $query[0]["colaborador_pk"],
            "dt_apontamento" => $query[0]["dt_apontamento"],
            "tipo_apontamento_pk" => $query[0]["tipo_apontamento_pk"],
            "motivo_afastamento_pk" => $query[0]["motivo_afastamento_pk"],
            "dt_ini_afastamento" => $query[0]["dt_ini_afastamento"],
            "dt_fim_afastamento" => $query[0]["dt_fim_afastamento"]
        );

        return $result;

    }

}

?>