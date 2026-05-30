<?
require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/beneficio.dao.php";
require_once "../model/beneficio.class.php";
require_once "../model/log_exclusao.dao.php";
require_once "../model/log_exclusao.class.php";

require_once "../model/colaborador.dao.php";
require_once "../model/colaborador.class.php";

require_once "../model/agenda_colaborador_padrao.dao.php";
require_once "../model/agenda_colaborador_padrao.class.php";

$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$ds_beneficio = $arrRequest['ds_beneficio'];
$ic_status = $arrRequest['ic_status'];


$beneficiodao = new beneficiodao();
$beneficiodao->setToken($token); 
$log_exclusaodao = new log_exclusaodao();
$log_exclusaodao->setToken($token);

$colaboradordao = new colaboradordao();
$colaboradordao->setToken($token);

$agenda_colaborador_padraodao = new agenda_colaborador_padraodao();
$agenda_colaborador_padraodao->setToken($token);



switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $beneficio = $beneficiodao->carregarPorPk($pk);
        if($beneficio->getpk()>0){
            
            //$log_exclusaodao->salvar("beneficios",$beneficio->getpk());
            
            $beneficiodao->excluir($beneficio);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'beneficio nao encontrado';
        }
        break;
    }
    case 'salvar':{
        
        $beneficio = $beneficiodao->carregarPorPk($pk);
        $beneficio->setds_beneficio($ds_beneficio);
        $beneficio->setic_status($ic_status);

        
        $pk = $beneficiodao->salvar($beneficio);
        
        $mysql_data[] = array(
                "pk" => $pk
            );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $beneficiodao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_beneficio"=>$query[$i]['ds_beneficio'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			

        $result  = 'success';
        $message = 'query success';
        
        break;        
    }    
    case 'listarTodos':{
        
        $resultado = "";
        $query = $beneficiodao->listar_por_ds_beneficio($ds_beneficio,$ic_status);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_beneficio"=>$query[$i]['ds_beneficio'],
                    "ic_status"=>$query[$i]['ic_status']
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    case 'listarBeneficioColaboradores':{
        
        $colaboradores_pk = $_REQUEST['colaboradores_pk'];
        
        $result  = 'success';
        $message = 'query success';

        if($colaboradores_pk > 0){
            $query = $beneficiodao->listar_beneficio_colaboradores($colaboradores_pk);
        }
        else{
            $mysql_data = [];
        }
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "vl_beneficio" => $query[$i]['vl_beneficio'],
                    "obs"=>$query[$i]['obs'],
                    "ic_status"=>$query[$i]['ic_status'],
                    "beneficios_pk"=>$query[$i]['beneficios_pk']
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;        
        
    }
    case 'listarDataTable':{
        
        
        $resultado = "";
        $query = $beneficiodao->listar_por_ds_beneficio($ds_beneficio);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_ds_beneficio"=>$query[$i]['ds_beneficio'],
                    "t_ic_status"=>$query[$i]['ic_status'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }   
    
    case 'relatorio_projecao_beneficios':{        

        $pk = $_REQUEST['pk'];        
        $_produtos_servicos_pk =$_REQUEST['produtos_servicos_pk'];
        $turnos_pk = $_REQUEST['turnos_pk']; 
        $mes_pk= $_REQUEST['mes_pk'];
        $ano_pk= $_REQUEST['ano_pk'];
        $leads_pk = $_REQUEST['leads_pk'];
        
        $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $mes_pk, $ano_pk);     
        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');   
        
        $dt_inicio = ("01/".$mes_pk."/".$ano_pk);
        $dt_fim = ($ultimoDiaMes."/".$mes_pk."/".$ano_pk);
             
        $resultado = "";
        
        $query = $colaboradordao->relatorio_projecao_beneficios_colaboradores($pk,$_produtos_servicos_pk,$turnos_pk,$dt_inicio,$dt_fim,$leads_pk);

        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $vtipoEscalaMesAtual = "";
                $queryEscala = $agenda_colaborador_padraodao->retornaEscalaColaboradorPeriodoRelatorioBeneficios($query[$i]['pk'],$dt_inicio,$dt_fim);
                $ds_lead = $queryEscala[0]['ds_lead'];
                //Verifica se a escala é 12x36
                if($queryEscala[0]['n_qtde_dias_semana']=='12x36'){ 
                   
                    if(!empty($queryEscala[0]['tipo_escala'])){ 
                   
                        //Retorna se a escala do mes de consulta é para ou impar
                        $queryMes = $agenda_colaborador_padraodao->retornarDifMes($queryEscala[0]['dt_inicio_agenda'],$ano_pk."-".$mes_pk."-".$ultimoDiaMes);  
                        $vtipoEscalaMesAtual = $queryEscala[0]['tipo_escala'];
 
                        for ($b=0; $b < ($queryMes[0]['mesdif']); $b++){   
                            if($b!=0){
                                if($vtipoEscalaMesAtual==1){
                                    $vtipoEscalaMesAtual= 2;
                                }elseif($vtipoEscalaMesAtual==2){                       
                                    $vtipoEscalaMesAtual = 1;
                                }elseif($vtipoEscalaMesAtual==''){
                                     $vtipoEscalaMesAtual = $queryEscala[0]['tipo_escala'];
                                }
                            }
                            
                        } 
                    }    
                }           

               
                //Dias trabalhados na escala               
                               
                $queryDias = $agenda_colaborador_padraodao->retornarDifData(DataYMD($dt_inicio),DataYMD($dt_fim));

                //if($ultimoDiaMes==31){ 
                    //$qtdeDias = $queryDias[0]['dtdif']+1;
                //}else{                     
                    $qtdeDias = ($queryDias[0]['dtdif']+2);
                //}
     
                $v_dias_escala = 0;
                for ($a=1; $a < ($qtdeDias); $a++){ 
                    
                    $diasemana_numero = date('w', strtotime($ano_pk."-".$mes_pk."-".$a));
                    if($vtipoEscalaMesAtual==''){//Dias corridos
                          
                        //echo ($ano_pk."-".$mes_pk."-".$a)."<br>";
                        if($diasemana[$diasemana_numero]=="Dom"){
                            if($queryEscala[0]['ic_dom']==1){
                                //echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";  
                                $v_dias_escala ++;                
                            }                        
                        }elseif($diasemana[$diasemana_numero]=="Seg"){
                            if($queryEscala[0]['ic_seg']==1){
                                //echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";  
                                $v_dias_escala ++;
                            } 
                        }elseif($diasemana[$diasemana_numero]=="Ter"){
                            if($queryEscala[0]['ic_ter']==1){
                                //echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";  
                                $v_dias_escala ++;
                            } 
                        }elseif($diasemana[$diasemana_numero]=="Qua"){
                            if($queryEscala[0]['ic_qua']==1){
                               // echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";
                                $v_dias_escala ++;
                            } 
                        }elseif($diasemana[$diasemana_numero]=="Qui"){
                            if($queryEscala[0]['ic_qui']==1){                 
                                //echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";
                                $v_dias_escala ++;
                            } 
                        }elseif($diasemana[$diasemana_numero]=="Sex"){
                            if($queryEscala[0]['ic_sex']==1){                     
                               // echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>";
                                $v_dias_escala ++;
                            } 
                        }elseif($diasemana[$diasemana_numero]=="Sab"){
                            if($queryEscala[0]['ic_sab']==1){                      
                                //echo ($ano_pk."-".$mes_pk."-".$a)." - ". $diasemana[$diasemana_numero]."<br>"; 
                                $v_dias_escala ++;
                            } 
                        }  
                    }elseif($vtipoEscalaMesAtual==1){// Impar
                        if($a % 2 != 0){
                            $v_dias_escala ++;
                        }
                    }elseif($vtipoEscalaMesAtual==2){// Par
                        if($a % 2 == 0){
                            $v_dias_escala ++;
                        }
                    }
                
                  
                }

                //adicional Noturno
                $adicional_noturno = "Não Tem";
                $vl_adiconal_noturno = '7';
                if($queryEscala[0]['turnos_pk']==3){
                    $adicional_noturno = ($v_dias_escala * $vl_adiconal_noturno);
                }

                //QUERY QUALIFICACAO///
                $query0 = $colaboradordao->listarBeneficiosColaborador($query[$i]['pk']);
                $vl_vt = "";
                $vl_va = "";
                $vl_cb = "";
                $vl_vr = "";
                if(count($query0) > 0){
                    $ds_qualificacao = "";
                    for($j = 0; $j < count($query0); $j++){
                        if($query0[$j]['ds_beneficio']=='VALE TRANSPORTE'){
                            $vl_vt = $query0[$j]['vl_beneficio']; 
                        }
                        if($query0[$j]['ds_beneficio']=='VALE ALIMENTAÇÃO'){
                            $vl_va = $query0[$j]['vl_beneficio']; 
                        }
                        if($query0[$j]['ds_beneficio']=='CESTA BÁSICA'){
                            $vl_cb = $query0[$j]['vl_beneficio']; 
                        }
                        if($query0[$j]['ds_beneficio']=='VALE REFEIÇÃO'){
                            $vl_vr = $query0[$j]['vl_beneficio']; 
                        }
                    }
                }
             
                //Retorna a quantidade de faltas com atestado do periodo
                $queryFaltasAtestado = $colaboradordao->listarFaltasAtestado($query[$i]['pk'], DataYMD($dt_inicio),DataYMD($dt_fim));
                                
                //Retornar total de faltas sem atestado
                $queryFaltas = $colaboradordao->listarFaltas($query[$i]['pk'], DataYMD($dt_inicio),DataYMD($dt_fim));
                
                 //Retornar total de faltas sem atestado mes anterior
                
                if($mes_pk==1){
                    $mes_anteror_pk = 12;
                    $ano_anteior_pk = $ano_pk -1;                    
                }else{
                    $mes_anteror_pk = $mes_pk - 1; 
                }

                
                $ultimoDiaMesAnterior = cal_days_in_month(CAL_GREGORIAN, $mes_anteror_pk , $ano_anteior_pk);    
                            
                $dt_ini_anterior = ("01/".$mes_anteror_pk."/".$ano_anteior_pk);
                $dt_fim_anterior = ($ultimoDiaMesAnterior."/".$mes_anteror_pk."/".$ano_anteior_pk);
                $queryFaltasMesAnterior = $colaboradordao->listarFaltas($query[$i]['pk'], DataYMD($dt_ini_anterior),DataYMD($dt_fim_anterior));
                           
               
                
                $mysql_data[] = array(
                    "colaborador_pk" => $query[$i]["pk"],
                    "ds_colaborador" => $query[$i]["ds_colaborador"],
                    "ds_lead" => $query[$i]["ds_lead"],
                    "ds_turno"=>$query[$i]['ds_turno'],            
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'], 
                    "dias_escala"=>$v_dias_escala,
                    "n_adicional_noturno"=>$adicional_noturno,         
                    "n_dias_abonar"=>$queryFaltasAtestado[0]['Total'],
                    "n_faltas"=>$queryFaltas[0]['Total'],
                    "n_faltas_mes_anterior"=>$queryFaltasMesAnterior[0]['Total'],
                    "vl_vr"=>($vl_vr * $v_dias_escala),
                    "vl_vt"=>($vl_vt * $v_dias_escala), 
                    "vl_va"=>$vl_va, 
                    "ds_escala"=>$ds_lead, 
                    
                    
                );
            }
        }
        else{
            $mysql_data = [];
        }
			
        
        break;
    }
    





    default:{
        break;
    }
}

$beneficiodao = null;

// Prepare data
$data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
);

// Convert PHP array to JSON array
$json_data = json_encode($data);
echo $json_data;


?>
