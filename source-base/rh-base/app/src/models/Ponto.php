<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;

class Ponto {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    function calculaTempo($hora_inicial, $hora_final) {
        $i = 1;
        $tempo_total = [];
    
        
       $tempos = array($hora_final, $hora_inicial);
    
       foreach($tempos as $tempo) {
        $segundos = 0;
    
        list($h, $m, $s) = explode(':', $tempo);
    
        $segundos += $h * 3600;
        $segundos += $m * 60;
        $segundos += $s;
    
        $tempo_total[$i] = $segundos;
     
        $i++;
        }
        $segundos = $tempo_total[1] - $tempo_total[2];
    
        $horas = floor($segundos / 3600);
        $segundos -= $horas * 3600;
        $minutos = str_pad((floor($segundos / 60)), 2, '0', STR_PAD_LEFT);
        $segundos -= $minutos * 60;
        $segundos = str_pad($segundos, 2, '0', STR_PAD_LEFT);
    
        return "$horas:$minutos:$segundos";
    }

    function converterHoraPMinuto($hora_inicial) {
    
        $i = 1;
        $tempo_total = [];
    
    
       $tempos = array($hora_inicial, $hora_inicial);
    
       foreach($tempos as $tempo) {
        $segundos = 0;
    
        list($h, $m, $s) = explode(':', $tempo);
    
        $segundos += $h * 3600;
        $segundos += $m * 60;
        $segundos += $s;
     
        $i++;
        }
    
        return $segundos;
    }

    public function verificarPontoAgenda($colaborador_pk, $dt_escala) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql="";
        $sql.="select p.colaborador_pk, p.tipos_ponto_pk tipo_ponto_pk, date_format(p.dt_hora_ponto, '%d/%m/%Y') dt_hora_ponto";
        $sql.="  from ponto p";
        $sql.=" where 1=1";
        if($colaborador_pk != ""){
            $sql.="   and p.colaborador_pk =" .$colaborador_pk;
        }
        if($dt_escala != ""){
            $sql.=" and date_format(dt_hora_ponto, '%Y/%m/%d') = date_format('".$dt_escala."', '%Y/%m/%d')";
        }
        //print_r($sql.PHP_EOL);



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;

        return $retorno;
    }
    public function verificarApontamentoAgenda($colaborador_pk, $dt_escala) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio


        $sql="";
        $sql.="select acp.colaborador_pk, acp.tipo_apontamento_pk,  date_format(acp.dt_apontamento, '%d/%m/%Y') dt_apontamento";
        $sql.="  from agenda_colaborador_apontamento acp";
        $sql.=" where 1=1";
        if($colaborador_pk != ""){
            $sql.="   and acp.colaborador_pk =" .$colaborador_pk;
        }
        if($dt_escala != ""){
            $sql.=" and date_format(dt_apontamento, '%Y/%m/%d') = date_format('".$dt_escala."', '%Y/%m/%d')";
        }



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;

        return $retorno;
    }

    public function popUpAtraso($dt_ini,$dt_fim,$diasemana_numero,$ic_inverter_folga, $leads_pk,
    $colaborador_pk,
    $turnos_pk,
    $funcao_pk) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $result = [];
        $sql ="";
        $sql.=" Select ";
        $sql.="    acp.pk agenda_colaborador_padaro_pk ";
        $sql.="    , acp.colaboradores_pk  ";
        $sql.="    , l.ds_lead ds_posto_trabalho";
        $sql.="    , c.ds_cel ";
        $sql.="    , c.ds_colaborador ";
        $sql.="    , ps.ds_produto_servico ds_funcao";
        $sql.="     ,te.ds_tipo_escala ds_escala";
        $sql.="    , t.ds_turno ";
        $sql.="    , acp.hr_inicio_expediente ";
        $sql.="    , acp.hr_termino_expediente";
        $sql.="    , edc.dt_escala ";
        $sql.=" from agenda_colaborador_padrao acp ";
        $sql.="    INNER join escala_dados_colaborador edc on acp.pk = edc.agenda_colaborador_padrao_pk ";
        $sql.="    INNER join ponto_solicitacao_liberacao_app psla on acp.colaboradores_pk = psla.colaborador_pk ";
        $sql.="    INNER join colaboradores c on acp.colaboradores_pk = c.pk";
        $sql.="     INNER JOIN tipos_escalas te ON acp.tipos_escalas_pk = te.pk";
        $sql.="    INNER join produtos_servicos ps on acp.produtos_servicos_pk = ps.pk";


        $sql.="    left join turnos t on acp.turnos_pk = t.pk";
        $sql.="    left join leads l on acp.leads_pk = l.pk";
        $sql.="    where psla.dt_liberacao is not null";
        $sql.=" and acp.dt_cancelamento is null";
        $sql.=" and c.ic_status = 1";
        $sql.=" and edc.dt_escala >='".Util::DataYMD($dt_ini)." 00:00:00'";
        $sql.=" and edc.dt_escala <='".Util::DataYMD($dt_ini)." 23:59:59'";

        if($leads_pk!=""){
            $sql.=" and l.pk = ".$leads_pk;
        }
        if($colaborador_pk!=""){
            $sql.=" and c.pk = ".$colaborador_pk;
        }
        if($turnos_pk!=""){
            $sql.=" and t.pk = ".$turnos_pk;
        }
        if($funcao_pk!=""){
            $sql.=" and ps.pk = ".$funcao_pk;
        }
        $sql.=" and edc.ic_escala = 1";
        $sql.=" group by acp.pk ";
        $sql.=" order by acp.hr_inicio_expediente, l.ds_lead, c.ds_colaborador ";



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $ds_status = "";
                $ic_status = "";
                //Bateram o Ponto mesmo que atrasado
                $dt_hora_escala = Util::DataYMD($dt_ini)." ".$query[$i]['hr_inicio_expediente'];
                $TotalTempoAtraso = 0;
                $sql ="";
                $sql.=" select";
                $sql.="    p.pk";
                $sql.="    ,p.colaborador_pk";
                $sql.="    ,date_format(p.dt_hora_ponto, '%H:%i') hr_ponto";
                $sql.="    ,TIMESTAMPDIFF(minute , '".$dt_hora_escala."' , p.dt_hora_ponto) atraso";
                $sql.=" from ponto p";
                $sql.="     where p.colaborador_pk = ".$query[$i]["colaboradores_pk"];
                $sql.="     and p.tipos_ponto_pk = 1";
                $sql.="     and p.dt_hora_ponto >='".Util::DataYMD($dt_ini)." 00:00:00'";
                $sql.="     and p.dt_hora_ponto <='".Util::DataYMD($dt_ini)." 23:59:59'";
                $sql.=" order by TIMESTAMPDIFF(minute , '".$dt_hora_escala."' , p.dt_hora_ponto) desc";
                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $query1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                if(count($query1) == 0){
                    /*$ds_status = "Ponto Registrado";
                    $atraso = Util::minuto2Hora($query1[0]['atraso']);
                    if($query1[0]['atraso'] <=0){
                        $ic_status = 0;

                        $TotalTempoAtraso = "";
                    }elseif ($query1[0]['atraso'] >=10 and $query1[0]['atraso'] <=15){

                        $ic_status = 10;
                        $TotalTempoAtraso = $atraso;
                    }elseif ($query1[0]['atraso']  >=15 and $query1[0]['atraso'] <=25){
                        $ic_status = 15;

                        $TotalTempoAtraso = $atraso;
                    }elseif ($query1[0]['atraso'] > 25){
                        $ic_status = 25;
                        $TotalTempoAtraso = $atraso;
                    }
                    }else*/
                    //NÃO BATERAM O PONTO
                    $dt_hora_atual = date('y-m-d H:i');
                    $ds_status = "Ponto Não Registrado";
                    $sql ="";
                    $sql.=" select  TIMESTAMPDIFF(MINUTE , '".$dt_hora_escala."' , '".$dt_hora_atual."') atraso";

                    $stmt = $this->pdo->prepare( $sql );
                    $stmt->execute();
                    $query1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                    $atraso = Util::minuto2Hora($query1[0]['atraso']);
                    if($query1[0]['atraso'] <=5 && $query1[0]['atraso'] > 0 ){
                        $ic_status = 5;
                        $TotalTempoAtraso = "";
                    }elseif ($query1[0]['atraso'] >5 && $query1[0]['atraso'] <=10){
                        $ic_status = 10;
                        $TotalTempoAtraso = $atraso;
                    }else if ($query1[0]['atraso'] > 10){
                        $ic_status = 25;
                        $TotalTempoAtraso = $atraso;
                    }
                }

                $result[] = array (
                    'agenda_colaborador_padaro_pk'=>$query[$i]['agenda_colaborador_padaro_pk'],
                    'colaborador_pk'=>$query[$i]['colaboradores_pk'],
                    'ds_posto_trabalho'=>$query[$i]['ds_posto_trabalho'],
                    'ds_cel'=>$query[$i]['ds_cel'],
                    'ds_colaborador'=>$query[$i]['ds_colaborador'],
                    'ds_funcao'=>$query[$i]['ds_funcao'],
                    'ds_escala'=>$query[$i]['ds_escala'],
                    'ds_turno'=>$query[$i]['ds_turno'],
                    'hr_inicio_expediente'=>$query[$i]['hr_inicio_expediente'],
                    'ds_status'=>$ds_status,
                    'ic_status'=>$ic_status,
                    'TotalTempoAtraso'=>$TotalTempoAtraso,
                );

            }
        }

    
        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $result;
        $retorno->iTotalDisplayRecords = count($query);
        $retorno->iTotalRecords = count($query);

        
        
        

        echo json_encode($retorno);
        exit(0);
    }



    public function salvarPontoDeskTop($dados_ponto){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        try{
            $distancia_ponto= "km.";
            $sql="";
            $sql.="SELECT l.pk,";
            $sql.="       l.ds_lead,";
            $sql.="       concat(l.ds_endereco,', ',l.ds_numero,',',l.ds_cidade,',Brasil')ds_local_trabalho";
            $sql.="  FROM leads l";
            $sql.="  where l.pk = ".$dados_ponto['leads_pk'];
            



            $stmt = $this->pdo->prepare( $sql );
            $stmt->execute();
            $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if(count($query) > 0){
                $location1 = Util::getCoordinates($dados_ponto['ds_localizacao']);
                $location2 = Util::getCoordinates($query[0]['ds_local_trabalho']);
                                
                
                // Verifica se as coordenadas foram obtidas com sucesso
                if ($location2) {
                    // Calcula a distância entre os dois pontos
                    $distancia = Util::calcularDistancia($location1['lat'], $location1['lon'], $location2['lat'], $location2['lon']);
                    $distancia_ponto = round($distancia, 2) . " km.";
                }
            }
            $fields = array();
            $fields['ic_tipo_dispositivo'] = $dados_ponto['ic_tipo_app'];
            $fields['ds_identificacao_dispositivo'] = $dados_ponto['ds_dispositivo'];
            $fields['colaborador_pk'] = $dados_ponto['colaborador_pk'];
            $fields['ds_pin'] = $dados_ponto['id_cliente'];
            $fields['tipos_ponto_pk'] = $dados_ponto['tipo_ponto_pk'];
            $fields['dt_hora_ponto'] = 'sysdate()';
            $fields['agenda_colaborador_padrao_pk'] = $dados_ponto['agenda_colaborador_padrao_pk'];
            $fields['leads_pk'] = $dados_ponto['leads_pk'];
            $fields['ds_distancia_ponto'] = $distancia_ponto;
            $fields['ds_localizacao'] = $dados_ponto['ds_localizacao'];
            $fields['img_ponto'] = ($dados_ponto['img_ponto']);
            $fields['ds_imagem'] = $dados_ponto['ds_imagem'];
            $fields['ic_tipo_sincronizacao'] = $dados_ponto['ic_sincronizacao'];

            $fields["dt_ult_atualizacao"] = "sysdate()";

            if(!isset($_SESSION['session_user']['par1'])){
                $fields["usuario_ult_atualizacao_pk"] = 1;
            }else{
                $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
            }

            //$fields['dt_solit_liberacao'] = "sysdate()";

            $fields["dt_cadastro"] = "sysdate()";
            if(!isset($_SESSION['session_user']['par1'])){
                $fields["usuario_cadastro_pk"]   = 1;
            }else{
                $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
            }

            $pk = Util::execInsert("ponto", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;

            return $retorno;
        }
        catch(\Throwable $e){

            $retorno->data = "";
            return $retorno;
        }

    }


    public function listarColaborador($colaborador_pk,$dt_ini,$dt_fim,$leads_pk) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $mysql_data = []; //Retorno data setado como vazio


        $sql ="";
        $sql.=" SELECT ";
        $sql.="    p.pk,";
        $sql.="    p.dt_cadastro,";
        $sql.="    p.usuario_cadastro_pk,";
        $sql.="    p.dt_ult_atualizacao,";
        $sql.="    p.usuario_ult_atualizacao_pk,";
        $sql.="    p.ds_pin,";
        $sql.="    p.colaborador_pk,";
        $sql.="    p.tipos_ponto_pk,";
        $sql.="    p.dt_hora_ponto,";
        $sql.="    p.ds_localizacao,";
        $sql.="    p.ds_imagem,";
        $sql.="    p.ic_tipo_dispositivo,";
        $sql.="    agp.leads_pk,";
        $sql.="    agp.ic_variacao_dias_escala,";
        $sql.="    DATE_FORMAT(p.dt_hora_ponto, '%d/%m/%Y') dt_ponto";
        $sql.=" FROM";
        $sql.="    ponto p";
        $sql.="        INNER JOIN";
        $sql.="    colaboradores c ON p.colaborador_pk = c.pk";
        $sql.="        INNER JOIN";
        $sql.="    agenda_colaborador_padrao agp ON p.colaborador_pk = agp.colaboradores_pk";
        $sql.="         INNER JOIN";
        $sql.="    leads l ON agp.leads_pk = l.pk";

        $sql.=" WHERE 1 = 1 ";
        $sql.="  AND c.ic_funcionario =1";
        //$sql.=" and agp.dt_fim_agenda >='".Util::DataYMD($dt_ini)." 00:00:00'";
        $sql.=" and p.dt_hora_ponto between '".Util::DataYMD($dt_ini)." 00:00:00' and '".Util::DataYMD($dt_fim)." 23:59:59'";

        $sql.="          AND agp.dt_cancelamento IS NULL";
        $sql.="          AND c.ic_status = 1";
        if($colaborador_pk != ""){
            $sql.=" and p.colaborador_pk  =".$colaborador_pk;
        }
        if($leads_pk != ""){
            $sql.=" and agp.leads_pk  =".$leads_pk;
        }
        $sql.=" GROUP BY c.pk , agp.leads_pk";
        $sql.=" ORDER BY c.ds_colaborador , p.dt_hora_ponto";
       
        

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(count($query) > 0){
            for($i=0;$i < count($query);$i++){
                $sql ="";
                $sql.="SELECT ";
                $sql.="            *";
                $sql.="        FROM";
                $sql.="            ponto p";
                $sql.="                INNER JOIN";
                $sql.="            colaboradores c ON p.colaborador_pk = c.pk";
                $sql.="                INNER JOIN";
                $sql.="            agenda_colaborador_padrao agp ON p.colaborador_pk = agp.colaboradores_pk";
                $sql.="        WHERE 1 = 1";

                $sql.=" and p.dt_hora_ponto between '".Util::DataYMD($dt_ini)." 00:00:00' and '".Util::DataYMD($dt_fim)." 23:59:59'";

                if($colaborador_pk != ""){
                    $sql.=" and p.colaborador_pk  =".$colaborador_pk;
                }
                $sql.=" and agp.dt_cancelamento is null";
                $sql.=" and c.ic_status =1";
                $sql.=" group by agp.leads_pk";
                $sql.=" ORDER BY c.ds_colaborador";



                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $query1 = $stmt->fetchAll(\PDO::FETCH_ASSOC);


                $mysql_data[] = array(
                    "colaborador_pk" => $query[$i]["colaborador_pk"],
                    "leads_pk" => $query[$i]["leads_pk"],
                    "dt_ponto" => $query[$i]["dt_ponto"],
                    "ic_inverter_folga" => $query[$i]["ic_variacao_dias_escala"],
                    "qtde_lead_colaborador" =>count($query1)
                );
            }
        }

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $mysql_data;

        return $retorno;
    }

    public function pegarPontoBatidoHoje($colaborador_pk) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $mysql_data = []; //Retorno data setado como vazio

        $dataAtual = date('Y-m-d');
        $sql ="";
        $sql.=" SELECT ";
        $sql.="    p.ds_pin,";
        $sql.="    p.colaborador_pk,";
        $sql.="    p.tipos_ponto_pk";
        $sql.=" FROM";
        $sql.="    ponto p";

        $sql.=" WHERE 1 = 1 ";
        $sql.=" and p.dt_hora_ponto between '".$dataAtual." 00:00:00' and '".$dataAtual." 23:59:59'";
        if($colaborador_pk != ""){
            $sql.=" and p.colaborador_pk  =".$colaborador_pk;
        }
  
       
        

       
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno;
    }


    


    public function relatorioPonto($leads_pk,$colaborador_pk,$dt_ini,$dt_fim,$qtde_lead_colaborador) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $mysql_data = []; //Retorno data setado como vazio

        $ds_legenda[] = "";
        $hr_saida_intervalo = "";
        $hr_volta_intervalo = "";

        $hr_entrada = ("00:00:00");
        $hr_saida = ("23:59:59");




        $sql ="";
        $sql.="SELECT ";
        $sql.="            l.pk,";
        $sql.="             l.ds_lead,";
        $sql.="            l.pk leads_pk,";
        $sql.="            col.pk colaboradores_pk,";
        $sql.="            CONCAT(l.ds_endereco,";
        $sql.="                    ', ',";
        $sql.="                    l.ds_cidade,";
        $sql.="                    ' - ',";
        $sql.="                    l.ds_uf) ds_local_trabalho,";
        $sql.="            col.ds_pin,";
        $sql.="            col.ds_colaborador,";
        $sql.="            ps.ds_produto_servico,";
        $sql.="            pt.tipos_ponto_pk,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%Y-%m-%d') dt_hora_ponto,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%d/%m/%Y') dt_rh_entratada,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%H:%i:%s') hr_entrada,";
        $sql.="            pt.ds_total_horas_trabalhadas,";
        $sql.="             pt.ds_localizacao,";
        $sql.="            pt.ds_imagem ds_imagem_entrada,";
        $sql.="            pt.img_ponto,";
        $sql.="             pt.ds_distancia_ponto,";
        $sql.="            agp.hr_inicio_exp_dom hr_turno_dom,";
        $sql.="            agp.hr_inicio_exp_seg hr_turno_seg,";
        $sql.="            agp.hr_inicio_exp_ter hr_turno_ter,";
        $sql.="            agp.hr_inicio_exp_qua hr_turno_qua,";
        $sql.="            agp.hr_inicio_exp_qui hr_turno_qui,";
        $sql.="            agp.hr_inicio_exp_sex hr_turno_sex,";
        $sql.="            agp.hr_inicio_exp_sab hr_turno_sab,";
        $sql.="            agp.hr_termino_expediente_dom hr_turno_dom_saida,";
        $sql.="            agp.hr_termino_expediente_seg hr_turno_seg_saida,";
        $sql.="            agp.hr_termino_expediente_ter hr_turno_ter_saida,";
        $sql.="            agp.hr_termino_expediente_qua hr_turno_qua_saida,";
        $sql.="             agp.hr_termino_expediente_qui hr_turno_qui_saida,";
        $sql.="            agp.hr_termino_expediente_sex hr_turno_sex_saida,";
        $sql.="            agp.hr_termino_expediente_sab hr_turno_sab_saida,";
        $sql.="            agp.hr_inicio_intervalo_dom hr_intervalo_dom,";
        $sql.="            agp.hr_inicio_intervalo_seg hr_intervalo_seg,";
        $sql.="            agp.hr_inicio_intervalo_ter hr_intervalo_ter,";
        $sql.="            agp.hr_inicio_intervalo_qua hr_intervalo_qua,";
        $sql.="            agp.hr_inicio_intervalo_qui hr_intervalo_qui,";
        $sql.="            agp.hr_inicio_intervalo_sex hr_intervalo_sex,";
        $sql.="            agp.hr_inicio_intervalo_sab hr_intervalo_sab,";
        $sql.="            agp.hr_termino_intervalo_dom hr_intervalo_saida_dom,";
        $sql.="            agp.hr_termino_intervalo_seg hr_intervalo_saida_seg,";
        $sql.="            agp.hr_termino_intervalo_ter hr_intervalo_saida_ter,";
        $sql.="            agp.hr_termino_intervalo_qua hr_intervalo_saida_qua,";
        $sql.="            agp.hr_termino_intervalo_qui hr_intervalo_saida_qui,";
        $sql.="            agp.hr_termino_intervalo_sex hr_intervalo_saida_sex,";
        $sql.="            agp.hr_termino_intervalo_sab hr_intervalo_saida_sab,";
        $sql.="            agp.ic_escala_dom ic_dom,";
        $sql.="            agp.ic_escala_seg ic_seg,";
        $sql.="            agp.ic_escala_ter ic_ter,";
        $sql.="            agp.ic_escala_qua ic_qua,";
        $sql.="            agp.ic_escala_qui ic_qui,";
        $sql.="            agp.ic_escala_sex ic_sex,";
        $sql.="            agp.ic_escala_sab ic_sab,";
        $sql.="            te.ds_tipo_escala n_qtde_dias_semana,";
        $sql.="            pt.ds_imagem ds_imagem_saida,";
        $sql.="            psl.ds_link_imagem_cadastro ds_imagem_sistema,";
        $sql.="            psl.img_colaborador_cadastro,";
        $sql.="            psl.ds_imagem ds_imagem_sistema_antiga";
        $sql.="        FROM";
        $sql.="            ponto pt";
        $sql.="                INNER JOIN";
        $sql.="            colaboradores col ON pt.colaborador_pk = col.pk";
        $sql.="                LEFT JOIN";
        $sql.="            colaboradores_produtos_servicos cps ON col.pk = cps.colaboradores_pk";
        $sql.="                LEFT JOIN";
        $sql.="            produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.="                INNER JOIN";
        $sql.="             agenda_colaborador_padrao agp ON pt.colaborador_pk = agp.colaboradores_pk";
        $sql.="            INNER JOIN tipos_escalas te ON agp.tipos_escalas_pk = te.pk";
        $sql.="                LEFT JOIN";
        $sql.="            leads l ON pt.leads_pk = l.pk";
        $sql.="                LEFT JOIN";
        $sql.="            ponto_solicitacao_liberacao_app psl ON col.pk = psl.colaborador_pk";
        $sql.="        WHERE 1 = 1 ";

        $sql.=" and pt.dt_hora_ponto between '".Util::DataYMD($dt_ini)." ".$hr_entrada."' and '".Util::DataYMD($dt_fim)." ".$hr_saida."'";

        if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk ;
        }

        if($colaborador_pk != ""){
            $sql.=" and col.pk  = ".$colaborador_pk;
        }
        /*if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk;
        }*/
        $sql.=" and agp.dt_cancelamento is null";

        $sql.=" group by DATE_FORMAT(pt.dt_hora_ponto, '%H:%i:%s'),pt.tipos_ponto_pk ";
        $sql.=" order by col.ds_colaborador, pt.dt_hora_ponto asc ";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(count($query) > 0){

            for($i=0;$i < count($query);$i++){
                $ds_total_horas_trabalhadas = "";
                $coordernadas_lead = "";
                $latitude_lead = "";
                $longitude_lead = "";
                $latitude_ponto = "";
                $latitude_ponto = "";
                $distancia_entre_pontos = "";
                $endereco_ponto = "";
                $ds_registro_ponto = "";

                $diasemana_numero = date('w', strtotime(Util::DataYMD($query[$i]['dt_rh_entratada'])));

                $horaA = "";
                $horaB = "";
                $horaD = "";
                $horaE = "";
                $hr_diferenca = "";
                $hr_diferenca_positivo = "";
                $diferenca_segundo_positivo = "";

                if($diasemana_numero==0){
                    //if($query[$i]['ic_dom']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_dom'].':00';
                    $horac = $query[$i]['hr_turno_dom_saida'].':00';

                    if($query[$i]['hr_intervalo_dom']!=""){
                        $horaD = $query[$i]['hr_intervalo_dom'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_dom']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_dom'].':00';
                    }


                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}

                }
                else if($diasemana_numero==1){
                    //if($query[$i]['ic_seg']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_seg'].':00';
                    $horac = $query[$i]['hr_turno_seg_saida'].':00';
                    if($query[$i]['hr_intervalo_seg']!=""){
                        $horaD = $query[$i]['hr_intervalo_seg'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_seg']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_seg'].':00';
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }
                else if($diasemana_numero==2){
                    //if($query[$i]['ic_ter']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_ter'].':00';
                    $horac = $query[$i]['hr_turno_ter_saida'].':00';

                    if($query[$i]['hr_intervalo_ter']!=""){
                        $horaD = $query[$i]['hr_intervalo_ter'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_ter']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_ter'].':00';
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);

                    //}
                }
                else if($diasemana_numero==3){
                    //if($query[$i]['ic_qua']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_qua'].':00';
                    $horac = $query[$i]['hr_turno_qua_saida'].':00';
                    if($query[$i]['hr_intervalo_qua']!=""){
                        $horaD = $query[$i]['hr_intervalo_qua'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_qua']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_qua'].':00';
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }
                else if($diasemana_numero==4){
                    //if($query[$i]['ic_qui']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_qui'].':00';
                    $horac = $query[$i]['hr_turno_qui_saida'].':00';
                    if($query[$i]['hr_intervalo_qui']!=""){
                        $horaD = $query[$i]['hr_intervalo_qui'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_qui']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_qui'].':00';
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);

                    //}
                }
                else if($diasemana_numero==5){
                    //if($query[$i]['ic_sex']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_sex'].':00';
                    $horac = $query[$i]['hr_turno_sex_saida'].':00';
                    if($query[$i]['hr_intervalo_sex']!=""){
                        $horaD = $query[$i]['hr_intervalo_sex'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_sex']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_sex'].':00';
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }

                else if($diasemana_numero==6){
                    //if($query[$i]['ic_sab']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_sab'].':00';
                    $horac = $query[$i]['hr_turno_sab_saida'].':00';
                    if($query[$i]['hr_intervalo_sab']!=""){
                        $horaD = $query[$i]['hr_intervalo_sab'].':00';
                    }
                    if($query[$i]['hr_intervalo_saida_sab']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_sab'].':00';
                    }


                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }


                $hr_diferenca_positivo = 0;
                $segundos_positivo =0;
                $segundos = 0;
                if($horaD!="" && $horaE!=""){
                    $hr_diferenca_positivo = Util::calculaTempo($horaD, $horaE);



                    $segundos_positivo = Util::converterHoraPMinuto($hr_diferenca_positivo);


                    $segundos=Util::converterHoraPMinuto($hr_diferenca);
                }



                //if($i==0){

                    if($query[$i]['tipos_ponto_pk']==1){
                        $hr_entrada = $query[$i]['hr_entrada'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Inicio Expediente";
                        $ds_total_horas_trabalhadas = gmdate('H:i:s', strtotime(date('H:i:s')) - strtotime($query[$i]['hr_entrada']));
                    }
                    if($query[$i]['tipos_ponto_pk']==2){

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $hr_saida = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Fim Expediente";
                        $ds_total_horas_trabalhadas = gmdate('H:i:s', strtotime($hr_saida) - strtotime($hr_entrada));

                    }
                    if($query[$i]['tipos_ponto_pk']==3){

                        $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Saída p/ Intervalo";

                    }
                    if($query[$i]['tipos_ponto_pk']==4){

                        $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto'];

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Retorno do Intervalo";

                    }

                //}
                /*else{
                    if($query[$i]['tipos_ponto_pk']==1){
                        $hr_diferenca_ponto = Util::calculaTempo($query[0]['hr_entrada'],$query[$i]['hr_entrada']);

                        $segundos_ponto = Util::converterHoraPMinuto($hr_diferenca_ponto);

                        if($segundos_ponto<="24200"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Retorno do Intervalo";
                        }
                        else if($segundos_ponto > "24200" && $segundos_ponto < "25000"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Inicio Expediente";

                        }
                        else if($segundos_ponto > "25000"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Retorno do Intervalo";

                        }
                    }
                    if($query[$i]['tipos_ponto_pk']==2){

                        $hr_diferenca_ponto = Util::calculaTempo($query[0]['hr_entrada'],$query[$i]['hr_entrada']);
                        $segundos_ponto = Util::converterHoraPMinuto($hr_diferenca_ponto);

                        if($segundos_ponto<="25200"){
                            if(($i+1)==count($query)){
                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                $hr_saida = $query[$i]['hr_entrada'];
                                $ds_legenda[$i] = "Fim Expediente";
                                $ds_total_horas_trabalhadas = gmdate('H:i:s', strtotime($hr_saida) - strtotime($hr_entrada));
                            }
                            else{
                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                $ds_legenda[$i] = "Saída p/ Intervalo";
                            }

                        }
                        else if($segundos_ponto > "25200"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $hr_saida = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Fim Expediente";
                        }

                    }
                    if($query[$i]['tipos_ponto_pk']==3){

                        $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Saída p/ Intervalo";

                    }
                    if($query[$i]['tipos_ponto_pk']==4){

                        $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto'];

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Retorno do Intervalo";

                    }
                }*/


                //CALCULA O ATRASO NA VOLTA DO INTERVALO
                if($ds_legenda[$i]=="Saída p/ Intervalo"){
                    $hr_saida_intervalo = $ds_registro_ponto;
                }
                if($ds_legenda[$i]=="Retorno do Intervalo"){
                    $hr_volta_intervalo = $ds_registro_ponto;
                }

                $hr_diferenca_intervalo =0;
                $segundos_intervalo = 0;

                if($hr_saida_intervalo!="" && $hr_volta_intervalo!=""){
                    $hr_diferenca_intervalo = Util::calculaTempo($hr_saida_intervalo,$hr_volta_intervalo);
                    $segundos_intervalo = Util::converterHoraPMinuto($hr_diferenca_intervalo);
                }


                if($segundos_positivo > 0){
                    $diferenca_segundo_positivo = $segundos_positivo - $segundos_intervalo;
                }

                if($query[$i]['ds_local_trabalho']!=""){
                    //TRANSFORMAR ENDEREÇO LEAD EM COORDENADAS
                    /*$coordernadas_lead = Util::fcTransformarEnderecoEmCoordenadas($query[$i]['ds_local_trabalho']);

                    $arrCoordenadasLead = explode(',',$coordernadas_lead);
                    $latitude_lead = $arrCoordenadasLead[0];
                    $longitude_lead = $arrCoordenadasLead[1];*/
                }

                if($query[$i]['ds_localizacao']!=""){

                    $arrCoordenadasPonto = explode(',',$query[$i]['ds_localizacao']);
                    

                    //TRANSFORMAR COORDERNADAS PONTO EM ENDEREÇO
                    $endereco_ponto = $arrCoordenadasPonto[0].", ".$arrCoordenadasPonto[1]." - ".$arrCoordenadasPonto[2];

                }
                $distancia_entre_pontos =$query[$i]['ds_distancia_ponto'];
                /*$endereco_ponto = "";
                $distancia_entre_pontos ="";
                if($query[$i]['ds_local_trabalho']!="" && $query[$i]['ds_localizacao']!=""){
                    //CALCULAR A DISTANCIA DO LEAD E O PONTO
                    //$distancia_entre_pontos = Util::fcCalcularDistanciaEntrePontos($latitude_ponto, $longitude_ponto, $latitude_lead, $longitude_lead);
                }*/


                $ds_lead = $query[$i]['ds_lead'];


                $ds_imagem_saida = $query[$i]['ds_imagem_saida'];


                $ds_imagem_sistema = $query[$i]['ds_imagem_sistema'];


                $ds_local_trabalho = $query[$i]['ds_local_trabalho'];

                if (strpos($query[$i]['img_ponto'], 'data:image/png;base64') !== false) {
                    $arr = (explode("data:image/png;base64,",$query[$i]['img_ponto']));
                
                    $img_ponto = $arr[1];
                } else {
                    $img_ponto = $query[$i]['img_ponto'];
                }
              
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$ds_lead,
                    "ds_re"=>"",
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$colaborador_pk,
                    "hora_saida"=>$hr_saida,
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    //"periodo"=>$query[$i]['periodo'],
                    "periodo"=>"",
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "dt_rh_entratada"=>$query[$i]['dt_rh_entratada'],
                    "hr_escala"=>$horaB." / ".$horac,
                    "hr_escala_intervalo"=>$horaD." / ".$horaE,
                    "segundos"=>$segundos,
                    "ds_local_trabalho"=>$ds_local_trabalho,
                    "ds_imagem_entrada"=>$query[$i]['ds_imagem_entrada'],
                    "img_ponto"=>'<img width="60" height="60" src="data:image/png;base64,'. ($img_ponto).'">',
                    "img_colaborador_cadastro"=>'<img width="60" height="60" src="data:image/png;base64,'. ($query[$i]['img_colaborador_cadastro']).'">',
                    "ds_legenda"=>$ds_legenda[$i],
                    "ds_registro_ponto"=>$ds_registro_ponto,
                    "ds_imagem_saida"=>$ds_imagem_saida,
                    "ds_imagem_sistema"=>$ds_imagem_sistema,
                    "diferenca_segundo_positivo"=>$diferenca_segundo_positivo,
                    "segundos_positivo"=>$segundos_positivo,
                    "hr_diferenca_intervalo"=>$hr_diferenca_intervalo,
                    "hr_diferenca"=>$hr_diferenca_intervalo,
                    "segundos_intervalo"=>$segundos_intervalo,
                    "ds_distancia_entre_pontos" =>$distancia_entre_pontos." Km",
                    "ds_localizacao"=>$endereco_ponto,
                    "ds_total_horas_trabalhadas"=>$ds_total_horas_trabalhadas,
                );
            }
        }

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $mysql_data;

        return $retorno;
    }


    public function relatorioPontoSinteticaAntigo($leads_pk,$colaborador_pk,$dt_ini,$dt_fim,$qtde_lead_colaborador) {
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $mysql_data = []; //Retorno data setado como vazio

        $ds_legenda[] = "";
        $hr_saida_intervalo = "";
        $hr_volta_intervalo = "";

        $hr_entrada = ("00:00:00");
        $hr_saida = ("23:59:59");


        $sql ="";
        $sql.="SELECT ";
        $sql.="            l.pk,";
        $sql.="             l.ds_lead,";
        $sql.="            l.pk leads_pk,";
        $sql.="            col.pk colaboradores_pk,";
        $sql.="            CONCAT(l.ds_endereco,";
        $sql.="                    ', ',";
        $sql.="                    l.ds_cidade,";
        $sql.="                    ' - ',";
        $sql.="                    l.ds_uf) ds_local_trabalho,";
        $sql.="            col.ds_pin,";
        $sql.="            col.ds_colaborador,";
        $sql.="            ps.ds_produto_servico,";
        $sql.="            pt.tipos_ponto_pk,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%Y-%m-%d') dt_hora_ponto,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%d/%m/%Y') dt_rh_entratada,";
        $sql.="            DATE_FORMAT(pt.dt_hora_ponto, '%H:%i:%s') hr_entrada,";
        $sql.="            pt.ds_total_horas_trabalhadas,";
        $sql.="             pt.ds_localizacao,";
        $sql.="            pt.ds_imagem ds_imagem_entrada,";
        $sql.="            pt.img_ponto,";
        $sql.="            agp.hr_inicio_exp_dom hr_turno_dom,";
        $sql.="            agp.hr_inicio_exp_seg hr_turno_seg,";
        $sql.="            agp.hr_inicio_exp_ter hr_turno_ter,";
        $sql.="            agp.hr_inicio_exp_qua hr_turno_qua,";
        $sql.="            agp.hr_inicio_exp_qui hr_turno_qui,";
        $sql.="            agp.hr_inicio_exp_sex hr_turno_sex,";
        $sql.="            agp.hr_inicio_exp_sab hr_turno_sab,";
        $sql.="            agp.hr_termino_expediente_dom hr_turno_dom_saida,";
        $sql.="            agp.hr_termino_expediente_seg hr_turno_seg_saida,";
        $sql.="            agp.hr_termino_expediente_ter hr_turno_ter_saida,";
        $sql.="            agp.hr_termino_expediente_qua hr_turno_qua_saida,";
        $sql.="             agp.hr_termino_expediente_qui hr_turno_qui_saida,";
        $sql.="            agp.hr_termino_expediente_sex hr_turno_sex_saida,";
        $sql.="            agp.hr_termino_expediente_sab hr_turno_sab_saida,";
        $sql.="            agp.hr_inicio_intervalo_dom hr_intervalo_dom,";
        $sql.="            agp.hr_inicio_intervalo_seg hr_intervalo_seg,";
        $sql.="            agp.hr_inicio_intervalo_ter hr_intervalo_ter,";
        $sql.="            agp.hr_inicio_intervalo_qua hr_intervalo_qua,";
        $sql.="            agp.hr_inicio_intervalo_qui hr_intervalo_qui,";
        $sql.="            agp.hr_inicio_intervalo_sex hr_intervalo_sex,";
        $sql.="            agp.hr_inicio_intervalo_sab hr_intervalo_sab,";
        $sql.="            agp.hr_termino_intervalo_dom hr_intervalo_saida_dom,";
        $sql.="            agp.hr_termino_intervalo_seg hr_intervalo_saida_seg,";
        $sql.="            agp.hr_termino_intervalo_ter hr_intervalo_saida_ter,";
        $sql.="            agp.hr_termino_intervalo_qua hr_intervalo_saida_qua,";
        $sql.="            agp.hr_termino_intervalo_qui hr_intervalo_saida_qui,";
        $sql.="            agp.hr_termino_intervalo_sex hr_intervalo_saida_sex,";
        $sql.="            agp.hr_termino_intervalo_sab hr_intervalo_saida_sab,";
        $sql.="            agp.ic_escala_dom ic_dom,";
        $sql.="            agp.ic_escala_seg ic_seg,";
        $sql.="            agp.ic_escala_ter ic_ter,";
        $sql.="            agp.ic_escala_qua ic_qua,";
        $sql.="            agp.ic_escala_qui ic_qui,";
        $sql.="            agp.ic_escala_sex ic_sex,";
        $sql.="            agp.ic_escala_sab ic_sab,";
        $sql.="            te.ds_tipo_escala n_qtde_dias_semana,";
        $sql.="            pt.ds_imagem ds_imagem_saida,";
        $sql.="            psl.ds_link_imagem_cadastro ds_imagem_sistema,";
        $sql.="            psl.img_colaborador_cadastro,";
        $sql.="            psl.ds_imagem ds_imagem_sistema_antiga";
        $sql.="        FROM";
        $sql.="            ponto pt";
        $sql.="                INNER JOIN";
        $sql.="            colaboradores col ON pt.colaborador_pk = col.pk";
        $sql.="                LEFT JOIN";
        $sql.="            colaboradores_produtos_servicos cps ON col.pk = cps.colaboradores_pk";
        $sql.="                LEFT JOIN";
        $sql.="            produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.="                INNER JOIN";
        $sql.="             agenda_colaborador_padrao agp ON pt.colaborador_pk = agp.colaboradores_pk";
        $sql.="            INNER JOIN tipos_escalas te ON agp.tipos_escalas_pk = te.pk";
        $sql.="                LEFT JOIN";
        $sql.="            leads l ON pt.leads_pk = l.pk";
        $sql.="                LEFT JOIN";
        $sql.="            ponto_solicitacao_liberacao_app psl ON col.pk = psl.colaborador_pk";
        $sql.="        WHERE 1 = 1 ";

        $sql.=" and pt.dt_hora_ponto between '".Util::DataYMD($dt_ini)." ".$hr_entrada."' and '".Util::DataYMD($dt_fim)." ".$hr_saida."'";

        if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk ;
        }

        if($colaborador_pk != ""){
            $sql.=" and col.pk  = ".$colaborador_pk;
        }
        /*if($leads_pk != ""){
            $sql.=" and l.pk = ".$leads_pk;
        }*/
        $sql.=" and agp.dt_cancelamento is null";

        $sql.=" group by DATE_FORMAT(pt.dt_hora_ponto, '%H:%i:%s'),pt.tipos_ponto_pk ";
        $sql.=" order by col.ds_colaborador, pt.dt_hora_ponto asc ";
   



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(count($query) > 0){
            for($i=0;$i < count($query);$i++){
                $ds_total_horas_trabalhadas = "";
                $coordernadas_lead = "";
                $latitude_lead = "";
                $longitude_lead = "";
                $latitude_ponto = "";
                $latitude_ponto = "";
                $distancia_entre_pontos = "";
                $endereco_ponto = "";
                $ds_registro_ponto = "";

                $diasemana_numero = date('w', strtotime(Util::DataYMD($query[$i]['dt_rh_entratada'])));

                $horaA = "00:00:00";
                $horaB = "00:00:00";
                $horaD = "00:00:00";
                $horaE = "00:00:00";
                $hr_diferenca = "00:00:00";
                $hr_diferenca_positivo = "00:00:00";
                $diferenca_segundo_positivo = 0;

                if($diasemana_numero==0){
                    //if($query[$i]['ic_dom']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_dom'];
                    $horac = $query[$i]['hr_turno_dom_saida'];

                    if($query[$i]['hr_intervalo_dom']!=""){
                        $horaD = $query[$i]['hr_intervalo_dom'];
                    }
                    if($query[$i]['hr_intervalo_saida_dom']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_dom'];
                    }


                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}

                }
                else if($diasemana_numero==1){
                    //if($query[$i]['ic_seg']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_seg'];
                    $horac = $query[$i]['hr_turno_seg_saida'];
                    if($query[$i]['hr_intervalo_seg']!=""){
                        $horaD = $query[$i]['hr_intervalo_seg'];
                    }
                    if($query[$i]['hr_intervalo_saida_seg']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_seg'];
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }
                else if($diasemana_numero==2){
                    //if($query[$i]['ic_ter']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_ter'];
                    $horac = $query[$i]['hr_turno_ter_saida'];

                    if($query[$i]['hr_intervalo_ter']!=""){
                        $horaD = $query[$i]['hr_intervalo_ter'];
                    }
                    if($query[$i]['hr_intervalo_saida_ter']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_ter'];
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);

                    //}
                }
                else if($diasemana_numero==3){
                    //if($query[$i]['ic_qua']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_qua'];
                    $horac = $query[$i]['hr_turno_qua_saida'];
                    if($query[$i]['hr_intervalo_qua']!=""){
                        $horaD = $query[$i]['hr_intervalo_qua'];
                    }
                    if($query[$i]['hr_intervalo_saida_qua']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_qua'];
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }
                else if($diasemana_numero==4){
                    //if($query[$i]['ic_qui']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_qui'];
                    $horac = $query[$i]['hr_turno_qui_saida'];
                    if($query[$i]['hr_intervalo_qui']!=""){
                        $horaD = $query[$i]['hr_intervalo_qui'];
                    }
                    if($query[$i]['hr_intervalo_saida_qui']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_qui'];
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);

                    //}
                }
                else if($diasemana_numero==5){
                    //if($query[$i]['ic_sex']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_sex'];
                    $horac = $query[$i]['hr_turno_sex_saida'];
                    if($query[$i]['hr_intervalo_sex']!=""){
                        $horaD = $query[$i]['hr_intervalo_sex'];
                    }
                    if($query[$i]['hr_intervalo_saida_sex']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_sex'];
                    }

                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }
                if($diasemana_numero==6){
                    //if($query[$i]['ic_sab']==1){
                    $horaA = $query[$i]['hr_entrada'];
                    $horaB = $query[$i]['hr_turno_sab'];
                    $horac = $query[$i]['hr_turno_sab_saida'];
                    if($query[$i]['hr_intervalo_sab']!=""){
                        $horaD = $query[$i]['hr_intervalo_sab'];
                    }
                    if($query[$i]['hr_intervalo_saida_sab']!=""){
                        $horaE = $query[$i]['hr_intervalo_saida_sab'];
                    }


                    $hr_diferenca = Util::calculaTempo($horaB, $horaA);
                    //}
                }

                

                if($horaD!=null){
                    
                    $hr_diferenca_positivo = Util::calculaTempo($horaD, $horaE);
                    
                    $segundos_positivo = Util::converterHoraPMinuto($hr_diferenca_positivo);
                    

                }





                $segundos =Util::converterHoraPMinuto($hr_diferenca);
                
                //if($i==0){
                    if($query[$i]['tipos_ponto_pk']==1){
                        $hr_entrada = $query[$i]['hr_entrada'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Inicio Expediente";
                    }
                    if($query[$i]['tipos_ponto_pk']==2){

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $hr_saida = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Fim Expediente";

                    }
                    if($query[$i]['tipos_ponto_pk']==3){

                        $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Saída p/ Intervalo";

                    }
                    if($query[$i]['tipos_ponto_pk']==4){

                        $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto'];

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Retorno do Intervalo";

                    }

                /*}
                else{
                    if($query[$i]['tipos_ponto_pk']==1){
                        $hr_diferenca_ponto = Util::calculaTempo($query[0]['hr_entrada'],$query[$i]['hr_entrada']);

                        $segundos_ponto = Util::converterHoraPMinuto($hr_diferenca_ponto);

                        if($segundos_ponto<="24200"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Retorno do Intervalo";
                        }
                        else if($segundos_ponto > "24200" && $segundos_ponto < "25000"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Inicio Expediente";

                        }
                        else if($segundos_ponto > "25000"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Retorno do Intervalo";

                        }


                    }
                    if($query[$i]['tipos_ponto_pk']==2){

                        $hr_diferenca_ponto = Util::calculaTempo($query[0]['hr_entrada'],$query[$i]['hr_entrada']);
                        $segundos_ponto = Util::converterHoraPMinuto($hr_diferenca_ponto);

                        if($segundos_ponto<="25200"){
                            if(($i+1)==count($query)){
                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                $hr_saida = $query[$i]['hr_entrada'];
                                $ds_legenda[$i] = "Fim Expediente";
                            }
                            else{
                                $ds_registro_ponto = $query[$i]['hr_entrada'];
                                $ds_legenda[$i] = "Saída p/ Intervalo";
                            }

                        }
                        else if($segundos_ponto > "25200"){
                            $ds_registro_ponto = $query[$i]['hr_entrada'];
                            $hr_saida = $query[$i]['hr_entrada'];
                            $ds_legenda[$i] = "Fim Expediente";
                        }

                    }
                    if($query[$i]['tipos_ponto_pk']==3){

                        $dt_rh_saida_intervalo = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_saida_intervalo = $query[$i]['dt_hora_ponto'];
                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Saída p/ Intervalo";

                    }
                    if($query[$i]['tipos_ponto_pk']==4){

                        $dt_rh_entratada_retorno = $query[$i]['hr_entrada'];
                        $dt_hora_ponto_entrada_retorno = $query[$i]['dt_hora_ponto'];

                        $ds_registro_ponto = $query[$i]['hr_entrada'];
                        $ds_legenda[$i] = "Retorno do Intervalo";

                    }
                }*/
                if($hr_saida!="" && $hr_entrada!=""){
                    $ds_total_horas_trabalhadas = gmdate('H:i:s', strtotime($hr_saida) - strtotime($hr_entrada));
                }


                
                //CALCULA O ATRASO NA VOLTA DO INTERVALO
                if($ds_legenda[$i]=="Saída p/ Intervalo"){
                    $hr_saida_intervalo = $ds_registro_ponto;
                }
                if($ds_legenda[$i]=="Retorno do Intervalo"){
                    $hr_volta_intervalo = $ds_registro_ponto;
                }
                
                if($hr_saida_intervalo!=""){
                    $hr_diferenca_intervalo = Util::calculaTempo($hr_saida_intervalo,$hr_volta_intervalo);
                    $segundos_intervalo = Util::converterHoraPMinuto($hr_diferenca_intervalo);

                }
                else{
                    $hr_diferenca_intervalo = "";
                    $segundos_intervalo = "";
                }
                

                if($segundos_positivo > 0){
                    $diferenca_segundo_positivo = $segundos_positivo - $segundos_intervalo;
                }

                
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    //"ds_re"=>$query[$i]['ds_re'],
                    "ds_pin"=>$query[$i]['ds_pin'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "colaborador_pk"=>$colaborador_pk,
                    "leads_pk"=>$query[$i]['leads_pk'],
                    "ds_produto_servico"=>$query[$i]['ds_produto_servico'],
                    //"periodo"=>$query[$i]['periodo'],
                    "n_qtde_dias_semana"=>$query[$i]['n_qtde_dias_semana'],
                    "dt_rh_entratada"=>$query[$i]['dt_rh_entratada'],
                    "hr_escala"=>$horaB." / ".$horac,
                    "hr_escala_intervalo"=>$horaD." / ".$horaE,
                    "segundos"=>$segundos,
                    "ds_local_trabalho"=>$query[$i]['ds_local_trabalho'],
                    "ds_imagem_entrada"=>$query[$i]['ds_imagem_entrada'],
                    "ds_legenda"=>$ds_legenda[$i],
                    "ds_registro_ponto"=>$ds_registro_ponto,
                    "ds_imagem_saida"=>$query[$i]['ds_imagem_saida'],
                    "ds_imagem_sistema"=>$query[$i]['ds_imagem_sistema'],
                    "diferenca_segundo_positivo"=>$diferenca_segundo_positivo,
                    "segundos_positivo"=>$segundos_positivo,
                    "hr_diferenca_intervalo"=>$hr_diferenca_intervalo,
                    "hr_diferenca"=>$hr_diferenca_intervalo,
                    "segundos_intervalo"=>$segundos_intervalo
                );

               
            }
        }

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $mysql_data;

        return $retorno;
    }

}
