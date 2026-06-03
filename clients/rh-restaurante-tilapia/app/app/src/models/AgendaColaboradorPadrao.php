<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;
use Throwable;

class AgendaColaboradorPadrao {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function excluir($pk){
        Util::execDelete('escala_dados_colaborador', ' agenda_colaborador_padrao_pk='.$pk, $this->pdo);
        Util::execDelete('agenda_colaborador_padrao', ' pk='.$pk, $this->pdo);
    }
    public function retornarDifData($dt_ini,$dt_fim){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $sql ="";
        $sql.="SELECT DATEDIFF('$dt_fim','$dt_ini')dtdif";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $result;

        return $retorno->data;
    }

    public function retornaEscalaColaboradorPeriodo($colaboradores_pk,$dt_periodo_ini,$dt_periodo_fim,$leads_pk,$agenda_colaborador_padrao_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql="";
        $sql.="SELECT a.pk,";
        $sql.="        a.dt_inicio_agenda,";
        $sql.="        date_format(a.dt_inicio_agenda, '%m') mes_inicio_agenda,";
        $sql.="        date_format(a.dt_inicio_agenda, '%Y') ano_inicio_agenda,";
        $sql.="        a.dt_fim_agenda,";
        $sql.="        a.tipos_escalas_pk,";
        $sql.="        a.ic_escala_dom,";
        $sql.="        a.ic_escala_seg,";
        $sql.="        a.ic_escala_ter,";
        $sql.="        a.ic_escala_qua,";
        $sql.="        a.ic_escala_qui,";
        $sql.="        a.ic_escala_sex,";
        $sql.="        a.ic_escala_sab,";
        $sql.="        a.ic_variacao_dias_escala,";
        $sql.="        te.ds_tipo_escala";
        $sql.=" FROM agenda_colaborador_padrao a";
        $sql.=" inner join tipos_escalas te on a.tipos_escalas_pk = te.pk";
        $sql.=" left join leads l on a.leads_pk = l.pk";
        $sql.=" left join contas c on c.pk = a.contas_pk";
        $sql.=" WHERE a.contas_pk =".$_SESSION['session_user']['contas_pk'];
        if(!empty($colaboradores_pk) && $colaboradores_pk!="null"){
            $sql.=" AND a.colaboradores_pk =".$colaboradores_pk;
        }
        if(!empty($agenda_colaborador_padrao_pk)){
            $sql.=" and a.pk =".$agenda_colaborador_padrao_pk;
        }
        $sql.="       AND '".Util::DataYMD($dt_periodo_ini)."' >= a.dt_inicio_agenda";
        $sql.="       AND '".Util::DataYMD($dt_periodo_fim)."' <= a.dt_fim_agenda";
        if(!empty($leads_pk)){
            $sql.="       AND a.leads_pk =".$leads_pk;
        }



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);



        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno->data;
    }

    public function retornarDifMes($dt_ini,$dt_fim){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $sql ="";
        $sql.="SELECT ROUND(TIMESTAMPDIFF(DAY, '".$dt_ini."', '".$dt_fim."')*12/365.24)mesdif";
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);



        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno->data;
    }

    public function retornarEscalaImpar_Par($dt_periodo_ini,$v_mes_inicio_agenda,$v_ano_inicio_agenda,$dt_periodo_fim,$vtipoEscalaCadastro,$MesIniPeriodo){

        if($MesIniPeriodo <="9"){
            $MesForFolha =  str_replace("0","",$MesIniPeriodo );
        }else{
            $MesForFolha =  $MesIniPeriodo;
        }
        //Retorna se a escala do mes de consulta é par ou impar
        $queryMes = $this->retornarDifMes($dt_periodo_ini,$dt_periodo_fim);
        $qtde_mes = $queryMes[0]['mesdif']+1;
        $ds_escala = "";
        $vTipoMesAnterior ="";
        for ($b=0; $b < $qtde_mes; $b++){
            if($v_mes_inicio_agenda!='12'){
                $vTipoMesFor="";
                //Escala de inicio
                if($b==0){
                    if($vtipoEscalaCadastro==1){
                        $vTipoMesFor = "impar";
                    }elseif($vtipoEscalaCadastro==2){
                        $vTipoMesFor = "par";
                    }
                    if($MesForFolha == $v_mes_inicio_agenda){
                        $ds_escala = $vtipoEscalaCadastro;
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
                        $ds_escala = $v_tipoEscalaMesFor;
                        break;
                    }

                }
                //if($v_mes_inicio_agenda != $MesFimPeriodo){
                $v_mes_inicio_agenda++;

                //}

            }else{
                if($b==0){
                    if($vtipoEscalaCadastro==1){
                        $vTipoMesFor = "impar";
                    }elseif($vtipoEscalaCadastro==2){
                        $vTipoMesFor = "par";
                    }
                    if($MesForFolha == $v_mes_inicio_agenda){
                        $ds_escala = $vtipoEscalaCadastro;
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
                    $ds_escala = $v_tipoEscalaMesFor;
                    break;
                }
                $v_mes_inicio_agenda = '01';
                $v_ano_inicio_agenda = $v_ano_inicio_agenda +1;

            }
        }

        return $ds_escala;

    }
    public function escalaDadosColaborador($colaborador_pk, $dt_periodo_ini, $dt_periodo_fim, $leads_pk, $agenda_colaborador_padrao_pk, $ds_escala,$tipo_escala_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = true; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $retorno->message = ""; //Retorno data setado como vazio

        $queryDias = $this->retornarDifData(Util::DataYMD($dt_periodo_ini),Util::DataYMD($dt_periodo_fim));

        $qtdeDias = $queryDias[0]['dtdif'];

        $queryEscala = $this->retornaEscalaColaboradorPeriodo($colaborador_pk, $dt_periodo_ini, $dt_periodo_fim, $leads_pk, $agenda_colaborador_padrao_pk);

        $dtIni = (explode("/",$dt_periodo_ini));
        $diaIniPeriodo = $dtIni[0];
        $dia = $dtIni[0];
        $MesIniPeriodo = $dtIni[1];
        $AnoIniPeriodo = $dtIni[2];

        $dtFim = (explode("/",$dt_periodo_fim));
        $diaFimPeriodo = $dtFim[0];
        $MesFimPeriodo = $dtFim[1];
        $AnoFimPeriodo = $dtFim[2];

        for ($a=0; $a < $qtdeDias; $a++){

            $ic_escala ='';
            $dt_escala = $AnoIniPeriodo.'-'.$MesIniPeriodo.'-'.$dia;

            $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesFimPeriodo, $AnoFimPeriodo);

            if($ds_escala=='12X36'){

                $ic_dia ='';

                $dt_inicio_agenda = $queryEscala[0]['dt_inicio_agenda'];
                $v_mes_inicio_agenda = $queryEscala[0]['mes_inicio_agenda'];
                $v_ano_inicio_agenda = $queryEscala[0]['ano_inicio_agenda'];
                $dt_periodo_fim = $AnoFimPeriodo."-".$MesFimPeriodo."-".$ultimoDiaMes;
                $vtipoEscalaCadastro = $queryEscala[0]['ic_variacao_dias_escala'];

                //Calcula se a escala é ímpar ou par
                $ic_mes = $this->retornarEscalaImpar_Par($dt_inicio_agenda, $v_mes_inicio_agenda, $v_ano_inicio_agenda, $dt_periodo_fim, $vtipoEscalaCadastro, $MesIniPeriodo);

                if($dia % 2 == 0){
                    $ic_dia = 2;
                }else{
                    $ic_dia = 1;
                }

                if($ic_mes == $ic_dia){
                    $ic_escala = 1;
                }else{
                    $ic_escala = 2;
                }


            }else{

                $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');
                $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$dia));

                if($diasemana[$diasemana_numero]=="Dom"){
                    $ic_escala = $queryEscala[0]['ic_escala_dom'];
                }elseif($diasemana[$diasemana_numero]=="Seg"){
                    $ic_escala = $queryEscala[0]['ic_escala_seg'];
                }elseif($diasemana[$diasemana_numero]=="Ter"){
                    $ic_escala = $queryEscala[0]['ic_escala_ter'];
                }elseif($diasemana[$diasemana_numero]=="Qua"){
                    $ic_escala = $queryEscala[0]['ic_escala_qua'];
                }elseif($diasemana[$diasemana_numero]=="Qui"){
                    $ic_escala = $queryEscala[0]['ic_escala_qui'];
                }elseif($diasemana[$diasemana_numero]=="Sex"){
                    $ic_escala = $queryEscala[0]['ic_escala_sex'];
                }elseif($diasemana[$diasemana_numero]=="Sab"){
                    $ic_escala = $queryEscala[0]['ic_escala_sab'];
                }
            }
            $fields = array();
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];
            $fields["dt_ult_atualizacao"]  = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
            $fields["dt_escala"] = $dt_escala;
            $fields["ic_escala"] = $ic_escala;
            $fields["ic_status"] = 1;
            $fields["tipos_escalas_pk"] = $tipo_escala_pk;
            $fields["contas_pk"] = $_SESSION['session_user']['contas_pk'];
            $fields["agenda_colaborador_padrao_pk"] = $agenda_colaborador_padrao_pk;


            $pk = Util::execInsert("escala_dados_colaborador", $fields,$this->pdo);

            $ultimoDiaMesIni = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);

            if($ultimoDiaMesIni == $dia){
                if($MesIniPeriodo == '12'){
                    $AnoIniPeriodo =  $AnoIniPeriodo + 1;
                    $MesIniPeriodo = 1;
                }else{
                    $MesIniPeriodo++;
                }
                $dia = 1;
            }else{
                $dia++;
            }
        }

        return $retorno;
    }

    public function salvar($agenda_colaborador_padrao){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        if($agenda_colaborador_padrao['leads_pk']!=""){
            $fields['leads_pk'] = $agenda_colaborador_padrao['leads_pk'];
        }
        else{
            $fields['leads_pk'] = 0;
        }
        if($agenda_colaborador_padrao['colaboradores_pk']!=""){
            $fields['colaboradores_pk'] = $agenda_colaborador_padrao['colaboradores_pk'];
        }
        else{
            $fields['colaboradores_pk'] = 0;
        }

        $fields['produtos_servicos_pk'] = $agenda_colaborador_padrao['produtos_servicos_pk'];
        $fields['dt_inicio_agenda'] = Util::DataYMD($agenda_colaborador_padrao['dt_inicio_agenda']);
        if($agenda_colaborador_padrao['dt_fim_agenda']!=""){
            $fields['dt_fim_agenda'] = Util::DataYMD($agenda_colaborador_padrao['dt_fim_agenda']);
        }
        $fields['turnos_pk'] = $agenda_colaborador_padrao['turnos_pk'];
        $fields['hr_inicio_expediente'] = $agenda_colaborador_padrao['hr_inicio_expediente'];
        $fields['hr_termino_expediente'] = $agenda_colaborador_padrao['hr_termino_expediente'];
        $fields['hr_inicio_intervalo'] = $agenda_colaborador_padrao['hr_inicio_intervalo'];
        $fields['hr_termino_intervalo'] = $agenda_colaborador_padrao['hr_termino_intervalo'];
        $fields['ic_variacao_dias_escala'] = $agenda_colaborador_padrao['ic_variacao_dias_escala'];
        $fields['tipos_escalas_pk'] = $agenda_colaborador_padrao['tipos_escalas_pk'];
        $fields['ic_intrajornada'] = $agenda_colaborador_padrao['ic_intrajornada'];
        $fields['ic_folga_dom'] = $agenda_colaborador_padrao['ic_folga_dom'];
        $fields['ic_folga_seg'] = $agenda_colaborador_padrao['ic_folga_seg'];
        $fields['ic_folga_ter'] = $agenda_colaborador_padrao['ic_folga_ter'];
        $fields['ic_folga_qua'] = $agenda_colaborador_padrao['ic_folga_qua'];
        $fields['ic_folga_qui'] = $agenda_colaborador_padrao['ic_folga_qui'];
        $fields['ic_folga_sex'] = $agenda_colaborador_padrao['ic_folga_sex'];
        $fields['ic_folga_sab'] = $agenda_colaborador_padrao['ic_folga_sab'];
        $fields['ic_escala_dom'] = $agenda_colaborador_padrao['ic_escala_dom'];
        $fields['ic_escala_seg'] = $agenda_colaborador_padrao['ic_escala_seg'];
        $fields['ic_escala_ter'] = $agenda_colaborador_padrao['ic_escala_ter'];
        $fields['ic_escala_qua'] = $agenda_colaborador_padrao['ic_escala_qua'];
        $fields['ic_escala_qui'] = $agenda_colaborador_padrao['ic_escala_qui'];
        $fields['ic_escala_sex'] = $agenda_colaborador_padrao['ic_escala_sex'];
        $fields['ic_escala_sab'] = $agenda_colaborador_padrao['ic_escala_sab'];
        $fields['hr_inicio_exp_dom'] = $agenda_colaborador_padrao['hr_inicio_exp_dom'];
        $fields['hr_inicio_exp_seg'] = $agenda_colaborador_padrao['hr_inicio_exp_seg'];
        $fields['hr_inicio_exp_ter'] = $agenda_colaborador_padrao['hr_inicio_exp_ter'];
        $fields['hr_inicio_exp_qua'] = $agenda_colaborador_padrao['hr_inicio_exp_qua'];
        $fields['hr_inicio_exp_qui'] = $agenda_colaborador_padrao['hr_inicio_exp_qui'];
        $fields['hr_inicio_exp_sex'] = $agenda_colaborador_padrao['hr_inicio_exp_sex'];
        $fields['hr_inicio_exp_sab'] = $agenda_colaborador_padrao['hr_inicio_exp_sab'];
        $fields['hr_inicio_intervalo_dom'] = $agenda_colaborador_padrao['hr_inicio_intervalo_dom'];
        $fields['hr_inicio_intervalo_seg'] = $agenda_colaborador_padrao['hr_inicio_intervalo_seg'];
        $fields['hr_inicio_intervalo_ter'] = $agenda_colaborador_padrao['hr_inicio_intervalo_ter'];
        $fields['hr_inicio_intervalo_qua'] = $agenda_colaborador_padrao['hr_inicio_intervalo_qua'];
        $fields['hr_inicio_intervalo_qui'] = $agenda_colaborador_padrao['hr_inicio_intervalo_qui'];
        $fields['hr_inicio_intervalo_sex'] = $agenda_colaborador_padrao['hr_inicio_intervalo_sex'];
        $fields['hr_inicio_intervalo_sab'] = $agenda_colaborador_padrao['hr_inicio_intervalo_sab'];
        $fields['hr_termino_intervalo_dom'] = $agenda_colaborador_padrao['hr_termino_intervalo_dom'];
        $fields['hr_termino_intervalo_seg'] = $agenda_colaborador_padrao['hr_termino_intervalo_seg'];
        $fields['hr_termino_intervalo_ter'] = $agenda_colaborador_padrao['hr_termino_intervalo_ter'];
        $fields['hr_termino_intervalo_qua'] = $agenda_colaborador_padrao['hr_termino_intervalo_qua'];
        $fields['hr_termino_intervalo_qui'] = $agenda_colaborador_padrao['hr_termino_intervalo_qui'];
        $fields['hr_termino_intervalo_sex'] = $agenda_colaborador_padrao['hr_termino_intervalo_sex'];
        $fields['hr_termino_intervalo_sab'] = $agenda_colaborador_padrao['hr_termino_intervalo_sab'];
        $fields['hr_termino_expediente_dom'] = $agenda_colaborador_padrao['hr_termino_expediente_dom'];
        $fields['hr_termino_expediente_seg'] = $agenda_colaborador_padrao['hr_termino_expediente_seg'];
        $fields['hr_termino_expediente_ter'] = $agenda_colaborador_padrao['hr_termino_expediente_ter'];
        $fields['hr_termino_expediente_qua'] = $agenda_colaborador_padrao['hr_termino_expediente_qua'];
        $fields['hr_termino_expediente_qui'] = $agenda_colaborador_padrao['hr_termino_expediente_qui'];
        $fields['hr_termino_expediente_sex'] = $agenda_colaborador_padrao['hr_termino_expediente_sex'];
        $fields['hr_termino_expediente_sab'] = $agenda_colaborador_padrao['hr_termino_expediente_sab'];
        $fields['ds_motivo_cancelamento'] = $agenda_colaborador_padrao['ds_motivo_cancelamento'];
        $fields['obs'] = $agenda_colaborador_padrao['obs'];

        if($agenda_colaborador_padrao['pk']  != ""){
            if($agenda_colaborador_padrao['dt_cancelamento']!=""){
                $fields['dt_cancelamento'] = Util::DataYMD($agenda_colaborador_padrao['dt_cancelamento']);
            }
        }


        $fields['contas_pk'] = $_SESSION['session_user']['contas_pk'];
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"]   = $_SESSION['session_user']['par1'];
        if($agenda_colaborador_padrao['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];


            $pk = Util::execInsert("agenda_colaborador_padrao", $fields,$this->pdo);

            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("agenda_colaborador_padrao", $fields, " pk = ".$agenda_colaborador_padrao['pk'],$this->pdo);
            $pk = $agenda_colaborador_padrao['pk'];
            $retorno->status = true;
            $retorno->message = 'Dados atualizado com sucesso';
            $retorno->data = $pk;
        }
        Util::execDelete('escala_dados_colaborador', ' agenda_colaborador_padrao_pk='.$pk, $this->pdo);
        return $retorno;
    }
    public function listarEscala($leads_pk,$colaborador_pk,$tipo_escala_pk,$produtos_servicos_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";


        $sql ="";
        $sql.="SELECT a.pk,";
        $sql.="            a.dt_cadastro,";
        $sql.="            a.usuario_cadastro_pk,";
        $sql.="            a.dt_ult_atualizacao,";
        $sql.="            a.usuario_ult_atualizacao_pk,";
        $sql.="            a.contas_pk,";
        $sql.="            a.leads_pk,";
        $sql.="            a.produtos_servicos_pk,";
        $sql.="            a.colaboradores_pk,";
        $sql.="            date_format(a.dt_inicio_agenda,'%d/%m/%Y')dt_inicio_agenda,";
        $sql.="            date_format(a.dt_fim_agenda,'%d/%m/%Y')dt_fim_agenda,";
        $sql.="            a.turnos_pk,";
        $sql.="            a.hr_inicio_expediente,";
        $sql.="            a.hr_termino_expediente,";
        $sql.="            a.hr_inicio_intervalo,";
        $sql.="            a.hr_termino_intervalo,";
        $sql.="            a.ic_intrajornada,";
        $sql.="            a.ic_variacao_dias_escala,";
        $sql.="            a.ic_folga_dom,";
        $sql.="            a.ic_folga_seg,";
        $sql.="            a.ic_folga_ter,";
        $sql.="            a.ic_folga_qua,";
        $sql.="            a.ic_folga_qui,";
        $sql.="            a.ic_folga_sex,";
        $sql.="            a.ic_folga_sab,";
        $sql.="            a.ic_escala_dom,";
        $sql.="            a.ic_escala_seg,";
        $sql.="            a.ic_escala_ter,";
        $sql.="            a.ic_escala_qua,";
        $sql.="            a.ic_escala_qui,";
        $sql.="            a.ic_escala_sex,";
        $sql.="            a.ic_escala_sab,";
        $sql.="            a.hr_inicio_exp_dom,";
        $sql.="            a.hr_inicio_exp_seg,";
        $sql.="            a.hr_inicio_exp_ter,";
        $sql.="            a.hr_inicio_exp_qua,";
        $sql.="            a.hr_inicio_exp_qui,";
        $sql.="            a.hr_inicio_exp_sex,";
        $sql.="            a.hr_inicio_exp_sab,";
        $sql.="            a.hr_inicio_intervalo_dom,";
        $sql.="            a.hr_inicio_intervalo_seg,";
        $sql.="            a.hr_inicio_intervalo_ter,";
        $sql.="            a.hr_inicio_intervalo_qua,";
        $sql.="            a.hr_inicio_intervalo_qui,";
        $sql.="            a.hr_inicio_intervalo_sex,";
        $sql.="            a.hr_inicio_intervalo_sab,";
        $sql.="            a.hr_termino_intervalo_dom,";
        $sql.="            a.hr_termino_intervalo_seg,";
        $sql.="            a.hr_termino_intervalo_ter,";
        $sql.="            a.hr_termino_intervalo_qua,";
        $sql.="            a.hr_termino_intervalo_qui,";
        $sql.="            a.hr_termino_intervalo_sex,";
        $sql.="            a.hr_termino_intervalo_sab,";
        $sql.="            a.hr_termino_expediente_dom,";
        $sql.="            a.hr_termino_expediente_seg,";
        $sql.="            a.hr_termino_expediente_ter,";
        $sql.="            a.hr_termino_expediente_qua,";
        $sql.="            a.hr_termino_expediente_qui,";
        $sql.="            a.hr_termino_expediente_sex,";
        $sql.="            a.hr_termino_expediente_sab,";
        $sql.="            date_format(a.dt_cancelamento,'%d/%m/%Y')dt_cancelamento,";
        $sql.="            a.ds_motivo_cancelamento,";
        $sql.="            a.obs,";
        $sql.="            a.tipos_escalas_pk,";
        $sql.="            c.ds_colaborador,";
        $sql.="            l.ds_lead,";
        $sql.="            t.ds_tipo_escala ds_escala,";
        $sql.="            ps.ds_produto_servico ds_funcao";
        $sql.="        FROM agenda_colaborador_padrao a";
        $sql.="        LEFT JOIN colaboradores c on c.pk = a.colaboradores_pk";
        $sql.="        LEFT JOIN leads l on l.pk = a.leads_pk";
        $sql.="        LEFT JOIN produtos_servicos ps on ps.pk = a.produtos_servicos_pk";
        $sql.="        INNER JOIN tipos_escalas t on t.pk = a.tipos_escalas_pk";
        $sql.="        WHERE 1=1 ";
        if($leads_pk!=""){
            $sql.=" and a.leads_pk = ".$leads_pk;
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk = ".$colaborador_pk;
        }
        if($tipo_escala_pk!=""){
            $sql.=" and a.tipos_escalas_pk = ".$tipo_escala_pk;
        }
        if($produtos_servicos_pk!=""){
            $sql.=" and a.produtos_servicos_pk = ".$produtos_servicos_pk;
        }

        $sql.="   and a.contas_pk = ".$_SESSION['session_user']['contas_pk'];

        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }
    public function listarEscalaLead($leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";


        $sql ="";
        $sql.="SELECT a.pk,";
        $sql.="            a.dt_cadastro,";
        $sql.="            a.usuario_cadastro_pk,";
        $sql.="            a.dt_ult_atualizacao,";
        $sql.="            a.usuario_ult_atualizacao_pk,";
        $sql.="            a.contas_pk,";
        $sql.="            a.leads_pk,";
        $sql.="            a.produtos_servicos_pk,";
        $sql.="            a.colaboradores_pk,";
        $sql.="            date_format(a.dt_inicio_agenda,'%d/%m/%Y')dt_inicio_agenda,";
        $sql.="            date_format(a.dt_fim_agenda,'%d/%m/%Y')dt_fim_agenda,";
        $sql.="            a.turnos_pk,";
        $sql.="            a.hr_inicio_expediente,";
        $sql.="            a.hr_termino_expediente,";
        $sql.="            a.hr_inicio_intervalo,";
        $sql.="            a.hr_termino_intervalo,";
        $sql.="            a.ic_intrajornada,";
        $sql.="            a.ic_variacao_dias_escala,";
        $sql.="            a.ic_folga_dom,";
        $sql.="            a.ic_folga_seg,";
        $sql.="            a.ic_folga_ter,";
        $sql.="            a.ic_folga_qua,";
        $sql.="            a.ic_folga_qui,";
        $sql.="            a.ic_folga_sex,";
        $sql.="            a.ic_folga_sab,";
        $sql.="            a.ic_escala_dom,";
        $sql.="            a.ic_escala_seg,";
        $sql.="            a.ic_escala_ter,";
        $sql.="            a.ic_escala_qua,";
        $sql.="            a.ic_escala_qui,";
        $sql.="            a.ic_escala_sex,";
        $sql.="            a.ic_escala_sab,";
        $sql.="            a.hr_inicio_exp_dom,";
        $sql.="            a.hr_inicio_exp_seg,";
        $sql.="            a.hr_inicio_exp_ter,";
        $sql.="            a.hr_inicio_exp_qua,";
        $sql.="            a.hr_inicio_exp_qui,";
        $sql.="            a.hr_inicio_exp_sex,";
        $sql.="            a.hr_inicio_exp_sab,";
        $sql.="            a.hr_inicio_intervalo_dom,";
        $sql.="            a.hr_inicio_intervalo_seg,";
        $sql.="            a.hr_inicio_intervalo_ter,";
        $sql.="            a.hr_inicio_intervalo_qua,";
        $sql.="            a.hr_inicio_intervalo_qui,";
        $sql.="            a.hr_inicio_intervalo_sex,";
        $sql.="            a.hr_inicio_intervalo_sab,";
        $sql.="            a.hr_termino_intervalo_dom,";
        $sql.="            a.hr_termino_intervalo_seg,";
        $sql.="            a.hr_termino_intervalo_ter,";
        $sql.="            a.hr_termino_intervalo_qua,";
        $sql.="            a.hr_termino_intervalo_qui,";
        $sql.="            a.hr_termino_intervalo_sex,";
        $sql.="            a.hr_termino_intervalo_sab,";
        $sql.="            a.hr_termino_expediente_dom,";
        $sql.="            a.hr_termino_expediente_seg,";
        $sql.="            a.hr_termino_expediente_ter,";
        $sql.="            a.hr_termino_expediente_qua,";
        $sql.="            a.hr_termino_expediente_qui,";
        $sql.="            a.hr_termino_expediente_sex,";
        $sql.="            a.hr_termino_expediente_sab,";
        $sql.="            date_format(a.dt_cancelamento,'%d/%m/%Y')dt_cancelamento,";
        $sql.="            a.ds_motivo_cancelamento,";
        $sql.="            a.obs,";
        $sql.="            a.tipos_escalas_pk,";
        $sql.="            c.ds_colaborador,";
        $sql.="            l.ds_lead,";
        $sql.="            t.ds_tipo_escala ds_escala,";
        $sql.="            ps.ds_produto_servico ds_funcao";
        $sql.="        FROM agenda_colaborador_padrao a";
        $sql.="        LEFT JOIN colaboradores c on c.pk = a.colaboradores_pk";
        $sql.="        LEFT JOIN leads l on l.pk = a.leads_pk";
        $sql.="        INNER JOIN produtos_servicos ps on ps.pk = a.produtos_servicos_pk";
        $sql.="        INNER JOIN tipos_escalas t on t.pk = a.tipos_escalas_pk";
        $sql.="        WHERE 1=1 ";
        if($leads_pk!=""){
            $sql.=" and a.leads_pk = ".$leads_pk;
        }
        else{
            $sql.=" and a.leads_pk = 0";
        }
        $sql.="   and a.contas_pk = ".$_SESSION['session_user']['contas_pk'];

        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }
    public function listarPk($pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio


        $sql ="";
        $sql.="SELECT a.pk,";
        $sql.="            a.dt_cadastro,";
        $sql.="            a.usuario_cadastro_pk,";
        $sql.="            a.dt_ult_atualizacao,";
        $sql.="            a.usuario_ult_atualizacao_pk,";
        $sql.="            a.contas_pk,";
        $sql.="            a.leads_pk,";
        $sql.="            a.produtos_servicos_pk,";
        $sql.="            a.colaboradores_pk,";
        $sql.="            date_format(a.dt_inicio_agenda,'%d/%m/%Y')dt_inicio_agenda,";
        $sql.="            date_format(a.dt_fim_agenda,'%d/%m/%Y')dt_fim_agenda,";
        $sql.="            a.turnos_pk,";
        $sql.="            a.hr_inicio_expediente,";
        $sql.="            a.hr_termino_expediente,";
        $sql.="            a.hr_inicio_intervalo,";
        $sql.="            a.hr_termino_intervalo,";
        $sql.="            a.ic_intrajornada,";
        $sql.="            a.ic_variacao_dias_escala,";
        $sql.="            a.ic_folga_dom,";
        $sql.="            a.ic_folga_seg,";
        $sql.="            a.ic_folga_ter,";
        $sql.="            a.ic_folga_qua,";
        $sql.="            a.ic_folga_qui,";
        $sql.="            a.ic_folga_sex,";
        $sql.="            a.ic_folga_sab,";
        $sql.="            a.ic_escala_dom,";
        $sql.="            a.ic_escala_seg,";
        $sql.="            a.ic_escala_ter,";
        $sql.="            a.ic_escala_qua,";
        $sql.="            a.ic_escala_qui,";
        $sql.="            a.ic_escala_sex,";
        $sql.="            a.ic_escala_sab,";
        $sql.="            a.hr_inicio_exp_dom,";
        $sql.="            a.hr_inicio_exp_seg,";
        $sql.="            a.hr_inicio_exp_ter,";
        $sql.="            a.hr_inicio_exp_qua,";
        $sql.="            a.hr_inicio_exp_qui,";
        $sql.="            a.hr_inicio_exp_sex,";
        $sql.="            a.hr_inicio_exp_sab,";
        $sql.="            a.hr_inicio_intervalo_dom,";
        $sql.="            a.hr_inicio_intervalo_seg,";
        $sql.="            a.hr_inicio_intervalo_ter,";
        $sql.="            a.hr_inicio_intervalo_qua,";
        $sql.="            a.hr_inicio_intervalo_qui,";
        $sql.="            a.hr_inicio_intervalo_sex,";
        $sql.="            a.hr_inicio_intervalo_sab,";
        $sql.="            a.hr_termino_intervalo_dom,";
        $sql.="            a.hr_termino_intervalo_seg,";
        $sql.="            a.hr_termino_intervalo_ter,";
        $sql.="            a.hr_termino_intervalo_qua,";
        $sql.="            a.hr_termino_intervalo_qui,";
        $sql.="            a.hr_termino_intervalo_sex,";
        $sql.="            a.hr_termino_intervalo_sab,";
        $sql.="            a.hr_termino_expediente_dom,";
        $sql.="            a.hr_termino_expediente_seg,";
        $sql.="            a.hr_termino_expediente_ter,";
        $sql.="            a.hr_termino_expediente_qua,";
        $sql.="            a.hr_termino_expediente_qui,";
        $sql.="            a.hr_termino_expediente_sex,";
        $sql.="            a.hr_termino_expediente_sab,";
        $sql.="            date_format(a.dt_cancelamento,'%d/%m/%Y')dt_cancelamento,";
        $sql.="            a.ds_motivo_cancelamento,";
        $sql.="            a.obs,";
        $sql.="            a.tipos_escalas_pk,";
        $sql.="            c.ds_colaborador,";
        $sql.="            l.ds_lead,";
        $sql.="            t.ds_tipo_escala ds_escala,";
        $sql.="            ps.ds_produto_servico ds_funcao";
        $sql.="        FROM agenda_colaborador_padrao a";
        $sql.="        LEFT JOIN colaboradores c on c.pk = a.colaboradores_pk";
        $sql.="        LEFT JOIN leads l on l.pk = a.leads_pk";
        $sql.="        LEFT JOIN produtos_servicos ps on ps.pk = a.produtos_servicos_pk";
        $sql.="        INNER JOIN tipos_escalas t on t.pk = a.tipos_escalas_pk";
        $sql.="        WHERE 1=1 ";
        if($pk!=""){
            $sql.=" and a.pk = ".$pk;
        }
        $sql.="   and a.contas_pk = ".$_SESSION['session_user']['contas_pk'];

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows[0];

        return $retorno;
    }
    public function listarEscalaColaborador($colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        //PAGINAÇÃO
        if(isset($_GET['start']) && $_GET['start']!=0){
            $displayStart = $_GET['start'];
        }
        else{
            $displayStart = 0;
        }

        if(isset($_GET['length'])){
            $displayRange = $_GET['length'];
            $lengthSql = " LIMIT ".intval($displayRange)." OFFSET ".intval($displayStart);
        }
        else{
            $lengthSql = " ";
        }
        $search = "";


        $sql ="";
        $sql.="SELECT a.pk,";
        $sql.="            a.dt_cadastro,";
        $sql.="            a.usuario_cadastro_pk,";
        $sql.="            a.dt_ult_atualizacao,";
        $sql.="            a.usuario_ult_atualizacao_pk,";
        $sql.="            a.contas_pk,";
        $sql.="            a.leads_pk,";
        $sql.="            a.produtos_servicos_pk,";
        $sql.="            a.colaboradores_pk,";
        $sql.="            date_format(a.dt_inicio_agenda,'%d/%m/%Y')dt_inicio_agenda,";
        $sql.="            date_format(a.dt_fim_agenda,'%d/%m/%Y')dt_fim_agenda,";
        $sql.="            a.turnos_pk,";
        $sql.="            a.hr_inicio_expediente,";
        $sql.="            a.hr_termino_expediente,";
        $sql.="            a.hr_inicio_intervalo,";
        $sql.="            a.hr_termino_intervalo,";
        $sql.="            a.ic_intrajornada,";
        $sql.="            a.ic_variacao_dias_escala,";
        $sql.="            a.ic_folga_dom,";
        $sql.="            a.ic_folga_seg,";
        $sql.="            a.ic_folga_ter,";
        $sql.="            a.ic_folga_qua,";
        $sql.="            a.ic_folga_qui,";
        $sql.="            a.ic_folga_sex,";
        $sql.="            a.ic_folga_sab,";
        $sql.="            a.ic_escala_dom,";
        $sql.="            a.ic_escala_seg,";
        $sql.="            a.ic_escala_ter,";
        $sql.="            a.ic_escala_qua,";
        $sql.="            a.ic_escala_qui,";
        $sql.="            a.ic_escala_sex,";
        $sql.="            a.ic_escala_sab,";
        $sql.="            a.hr_inicio_exp_dom,";
        $sql.="            a.hr_inicio_exp_seg,";
        $sql.="            a.hr_inicio_exp_ter,";
        $sql.="            a.hr_inicio_exp_qua,";
        $sql.="            a.hr_inicio_exp_qui,";
        $sql.="            a.hr_inicio_exp_sex,";
        $sql.="            a.hr_inicio_exp_sab,";
        $sql.="            a.hr_inicio_intervalo_dom,";
        $sql.="            a.hr_inicio_intervalo_seg,";
        $sql.="            a.hr_inicio_intervalo_ter,";
        $sql.="            a.hr_inicio_intervalo_qua,";
        $sql.="            a.hr_inicio_intervalo_qui,";
        $sql.="            a.hr_inicio_intervalo_sex,";
        $sql.="            a.hr_inicio_intervalo_sab,";
        $sql.="            a.hr_termino_intervalo_dom,";
        $sql.="            a.hr_termino_intervalo_seg,";
        $sql.="            a.hr_termino_intervalo_ter,";
        $sql.="            a.hr_termino_intervalo_qua,";
        $sql.="            a.hr_termino_intervalo_qui,";
        $sql.="            a.hr_termino_intervalo_sex,";
        $sql.="            a.hr_termino_intervalo_sab,";
        $sql.="            a.hr_termino_expediente_dom,";
        $sql.="            a.hr_termino_expediente_seg,";
        $sql.="            a.hr_termino_expediente_ter,";
        $sql.="            a.hr_termino_expediente_qua,";
        $sql.="            a.hr_termino_expediente_qui,";
        $sql.="            a.hr_termino_expediente_sex,";
        $sql.="            a.hr_termino_expediente_sab,";
        $sql.="            date_format(a.dt_cancelamento,'%d/%m/%Y')dt_cancelamento,";
        $sql.="            a.ds_motivo_cancelamento,";
        $sql.="            a.obs,";
        $sql.="            a.tipos_escalas_pk,";
        $sql.="            c.ds_colaborador,";
        $sql.="            l.ds_lead,";
        $sql.="            t.ds_tipo_escala ds_escala,";
        $sql.="            ps.ds_produto_servico ds_funcao";
        $sql.="        FROM agenda_colaborador_padrao a";
        $sql.="        LEFT JOIN colaboradores c on c.pk = a.colaboradores_pk";
        $sql.="        LEFT JOIN leads l on l.pk = a.leads_pk";
        $sql.="        INNER JOIN produtos_servicos ps on ps.pk = a.produtos_servicos_pk";
        $sql.="        INNER JOIN tipos_escalas t on t.pk = a.tipos_escalas_pk";
        $sql.="        WHERE 1=1 ";
        if($colaborador_pk!=""){
            $sql.=" and a.colaboradores_pk = ".$colaborador_pk;
        }
        else{
            $sql.=" and a.colaboradores_pk = 0";
        }
        $sql.="   and a.contas_pk = ".$_SESSION['session_user']['contas_pk'];

        $stmt = $this->pdo->prepare( $sql.$lengthSql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $stmtCount = $this->pdo->prepare( $sql );
        $stmtCount->execute();
        $rowsCount = $stmtCount->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rowsCount);
        $retorno->iTotalRecords = count($rowsCount);

        echo json_encode($retorno);
        exit(0);
    }

    public function  listarEscalasPostosColaborador($colaborador_pk, $dt_apontamento){


        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $result = array();
        $sql = "";
        $sql.= "select a.pk agenda_colaborador_padrao_pk";
        $sql.= "       ,a.colaboradores_pk";
        $sql.= "       ,l.ds_lead";
        $sql.= "       ,l.pk leads_pk";
        $sql.= "       ,te.ds_tipo_escala ds_escala";
        $sql.="        ,ps.pk produtos_servicos_pk";
        $sql.="        ,ps.ds_produto_servico ";
        $sql.= "  FROM agenda_colaborador_padrao a";
        $sql.= " INNER JOIN leads l ON a.leads_pk = l.pk";
        $sql.="  INNER JOIN colaboradores_produtos_servicos cps ON a.colaboradores_pk = cps.colaboradores_pk";
        $sql.="  INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.="  INNER JOIN tipos_escalas te ON a.tipos_escalas_pk = te.pk";
        $sql.= "  where 1=1";
        $sql.= "  and a.colaboradores_pk = ".$colaborador_pk;
        $sql.= "  and a.dt_inicio_agenda <= '".Util::DataYMD($dt_apontamento)."'";
        $sql.= "  and a.dt_fim_agenda >= '".Util::DataYMD($dt_apontamento)."'";
        $sql.="   and a.dt_cancelamento is null";



        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno;
    }

    public function calendarioDados($dt_ini,$dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$tipo_escala_pk,$escala_pesq_agenda,$produtos_servicos_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $pontodao = new Ponto($this->pdo);

        $dt_atual = date("Ymd");

        $dadosEscala = $this->calendarioDadosEscala($dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$produtos_servicos_pk,0);

        $result = array();
        for($i=0; $i<count($dadosEscala->data);$i++){
            $DadosEscalaCalendario = array();
            $colaborador_pk = $dadosEscala->data[$i]['colaborador_pk'];
            if($dadosEscala->data[$i]['dt_cancelamento_agenda'] === NULL){
                $sql = "SELECT dt_escala, ic_escala, tipos_escalas_pk, date_format(dt_escala, '%d') dia_mes, date_format(dt_escala, '%Y%m%d') ds_data";
                $sql .="    FROM escala_dados_colaborador";
                $sql .="   WHERE dt_escala BETWEEN '$dt_ini' AND '$dt_fim'";
                $sql .="   AND agenda_colaborador_padrao_pk = ".$dadosEscala->data[$i]['pk'];
                $sql .="   order by dt_escala asc";


                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);


                if(count($query) > 0){
                    for($j=0;$j<count($query);$j++){

                        $ds_background = "#d3d3d3";

                        if($query[$j]['tipos_escalas_pk'] == "12X36"){
                            if($query[$j]['dt_escala'] % 2 == "0" && $query[$j]['ic_escala'] == 1){
                                $ds_escala = "Par";
                            }else{
                                $ds_escala = "Impar";
                            }
                        }else{
                            $ds_escala = " ";
                        }

                        if($query[$j]['ic_escala']==1){

                            $ds_tipo_escala = 'Escala';
                            $dt_escala = $query[$j]['dt_escala'];
                            $ds_data = $query[$j]['ds_data'];
                            $tipo_registro_ponto = "";
                            if($ds_data <= $dt_atual){

                                //query tabela ponto
                                $queryponto = $pontodao->verificarPontoAgenda($colaborador_pk, $dt_escala);
                                //query tabela apontamento
                                $queryapontamento = $pontodao->verificarApontamentoAgenda($colaborador_pk, $dt_escala);

                                if(count($queryapontamento->data) > 0){

                                    $tipo_apontamento_pk = $queryapontamento->data[0]['tipo_apontamento_pk'];
                                    $dt_apontamento = $queryapontamento->data[0]['dt_apontamento'];

                                    if($tipo_apontamento_pk != "" && $dt_apontamento != "" && $colaborador_pk != ""){
                                        $tipo_registro_ponto =  $tipo_apontamento_pk;
                                    }else{
                                        $tipo_registro_ponto =  "";
                                    }

                                    if($dt_apontamento != "" && $colaborador_pk != ""){
                                        $dt_registro =  $dt_apontamento;
                                    }else{
                                        $dt_registro = "";
                                    }

                                }else{

                                    if(count($queryponto->data) > 0){
                                        $tipo_ponto_pk = $queryponto->data[0]['tipo_ponto_pk'];
                                        $dt_hora_ponto = $queryponto->data[0]['dt_hora_ponto'];
                                        $colaborador_pk = $queryponto->data[0]['colaborador_pk'];

                                        if($tipo_ponto_pk != "" && $dt_hora_ponto != "" && $colaborador_pk != ""){
                                            $tipo_registro_ponto =  $tipo_ponto_pk;
                                        }else{
                                            $tipo_registro_ponto =  "";
                                        }

                                        if($dt_hora_ponto != "" && $colaborador_pk != ""){
                                            $dt_registro =  $dt_hora_ponto;
                                        }else{
                                            $dt_registro = "";
                                        }

                                    }
                                }
                                //informa o background
                                if ($tipo_registro_ponto == 1 && $dt_registro != ""){
                                    $ds_background = '#63ed83';
                                }else{
                                    $ds_background = '#FFFF73';
                                }
                            }

                            $DadosEscalaCalendario[] = array(
                                "ds_dia"=>$query[$j]['dia_mes'],
                                "ds_tipo_escala"=>$ds_tipo_escala,
                                "hr_ini"=>$dadosEscala->data[$i]['hr_inicio_expediente'],
                                "hr_fim"=>$dadosEscala->data[$i]['hr_termino_expediente'],
                                "dt_escala"=>$query[$j]['dt_escala'],
                                "tipo_escala_pk"=>$query[$j]['tipos_escalas_pk'],
                                "tipo_registro_ponto"=> $tipo_registro_ponto,
                                "ds_background"=> $ds_background,
                                "ds_escala"=> $ds_escala,
                                "dt_atual"=> $dt_atual
                            );

                        }
                    }
                }else{
                    //echo $i;
                    $DadosEscalaCalendario[] = array(
                        "ds_dia"=>" ",
                        "ds_tipo_escala"=>" ",
                        "dt_escala"=>" ",
                        "hr_ini"=>" ",
                        "hr_fim"=>" ",
                        "tipo_escala_pk"=> " ",
                        "tipo_registro_ponto"=> " ",
                        "ds_background"=> " ",
                        "dt_atual"=> " ",
                        "ds_escala"=> " "
                    );
                }

                foreach($DadosEscalaCalendario as $dCalendario){

                    $result[] = array(
                        "id"=>$dadosEscala->data[$i]['pk'],
                        "resourceId"=>$dadosEscala->data[$i]['colaborador_pk'],
                        "start"=>$dCalendario['dt_escala']."T".$dCalendario['hr_ini'],
                        "end"=>$dCalendario['dt_escala']."T".$dCalendario['hr_fim'],
                        "textColor" => "#000000",
                        'title'=> 'Escala',
                        "color"=>$dCalendario['ds_background'],
                        "agenda_colaborador_padrao_pk"=>$dadosEscala->data[$i]['pk'],
                        "ds_lead"=>$dadosEscala->data[$i]['ds_lead'],
                        "leads_pk"=>$dadosEscala->data[$i]['leads_pk'],
                        "ds_colaborador"=>$dadosEscala->data[$i]['ds_colaborador'],
                        "colaborador_pk"=>$dadosEscala->data[$i]['colaborador_pk'],
                        "ds_produto_servico"=>$dadosEscala->data[$i]['ds_produto_servico'],
                        "produtos_servicos_pk"=>$dadosEscala->data[$i]['produtos_servicos_pk'],
                        "tipo_escala_pk"=>$dadosEscala->data[$i]['tipo_escala_pk'],
                        "ds_tipo_escala"=>$dCalendario['ds_escala'],
                        "dt_cancelamento_agenda"=>$dadosEscala->data[$i]['dt_cancelamento_agenda'],
                        "ic_status"=>$dadosEscala->data[$i]['ic_status']

                    );
                }

            }else{
                $result[] = array(
                    "agenda_colaborador_padrao_pk"=>"",
                    "ds_lead"=>"",
                    "leads_pk"=>"",
                    "ds_colaborador"=>"",
                    "colaborador_pk"=>"",
                    "ds_produto_servico"=>"",
                    "produtos_servicos_pk"=>"",
                    "n_qtde_dias_semana"=>"",
                    "tipo_escala_pk"=>"",
                    "ds_tipo_escala"=>"",
                    "dt_cancelamento_agenda"=>"",
                    "ic_status"=>"",
                    "DadosEscalaCalendario"=>""
                );
            }
        }


        echo json_encode($result);
        exit(0);

        //$dataRequest.='{"resourceIds":"'.$v[$i]['STATUS'].'","color":"'.$color.'","id":"'.$v[$i]['ID'].'","description":"'.$v[$i]['DESCRICAO'].'","title":"'.$v[$i]['TITLE'].'","start":"'.$v[$i]['DATA_HORA'].'","categoryname":"'.$v[$i]['PROCEDIMENTO'].'","groupId":"'.trim($v[$i]['ESPECIALISTA']).'","categoryanimal":"'.$v[$i]['ESPECIE'].' - '.$v[$i]['NOME_ANIMAL'].'"},';
    }

    public function calendarioDadosEscala($dt_fim,$leads_pk,$colaborador_pk,$n_qtde_dias_semana,$produtos_servicos_pk,$resource){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql="";
        $sql.="SELECT DISTINCT(a.pk)pk,";
        $sql.="       l.ds_lead,";
        $sql.="       l.pk leads_pk,";
        $sql.="       c.ds_colaborador,";
        $sql.="       c.pk colaborador_pk,";
        $sql.="       c.ds_colaborador,";
        $sql.="       c.ic_status,";
        $sql.="       ps.pk produtos_servicos_pk,";
        $sql.="       ps.ds_produto_servico,";
        $sql.="       te.ds_tipo_escala n_qtde_dias_semana,";
        $sql.="       a.tipos_escalas_pk tipo_escala_pk,";
        $sql.="       case WHEN a.ic_variacao_dias_escala =1 THEN ";
        $sql.="         'PAR' ";
        $sql.="       WHEN a.ic_variacao_dias_escala=2 THEN ";
        $sql.="         'IMPAR' ";
        $sql.="       ELSE ''  ";
        $sql.="       END ds_tipo_escala,";
        $sql.="       a.dt_cancelamento dt_cancelamento_agenda,";
        $sql.="       a.hr_inicio_expediente,";
        $sql.="       a.hr_termino_expediente,";
        $sql.="       a.hr_inicio_intervalo hr_saida_intervalo,";
        $sql.="       a.hr_termino_intervalo hr_retorno_intervalo,";
        $sql.="       a.dt_inicio_agenda,";
        $sql.="       a.dt_cancelamento";
        $sql.=" FROM agenda_colaborador_padrao a";
        $sql.="     INNER JOIN leads l ON a.leads_pk = l.pk";
        $sql.="     INNER JOIN colaboradores c ON a.colaboradores_pk = c.pk";
        $sql.="     INNER JOIN colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="     INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.="     INNER JOIN tipos_escalas te ON a.tipos_escalas_pk = te.pk";
        $sql.=" WHERE 1=1";
        if($dt_fim!=""){
            $sql.=" AND a.dt_fim_agenda >= '".($dt_fim)."'";
        }

        if($leads_pk!=""){
            $sql.=" AND l.pk=".$leads_pk;
        }
        if($colaborador_pk!=""){
            $sql.=" AND c.pk=".$colaborador_pk;
        }
        if($n_qtde_dias_semana!=""){
            $sql.=" AND te.ds_tipo_escala ='".$n_qtde_dias_semana."'";
        }

        if($produtos_servicos_pk!=""){
            $sql.=" AND ps.pk=".$produtos_servicos_pk;
        }

        $sql.=" AND a.dt_cancelamento is null";
        $sql.=" Group by l.ds_lead, a.colaboradores_pk,  a.pk";
        $sql.=" order by l.ds_lead, c.ds_colaborador";




        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        if($resource==1){
            $result = array();
            foreach($query as $v){
                $result[] = array(
                    "id"=>$v['colaborador_pk'],
                    "posto_trabalho"=>$v['ds_lead'],
                    "colaborador"=>$v['ds_colaborador'],
                    "qualificacao"=>$v['ds_produto_servico'],
                    "escala"=>$v['n_qtde_dias_semana'],
                    "tipo_escala"=>$v['ds_tipo_escala'],
                    "leads_pk"=>$v['leads_pk'],
                    "colaborador_pk"=>$v['colaborador_pk']
                );
            }

            echo json_encode($result);
            exit(0);
        }
        else{
            $retorno->status = true;
            $retorno->message = 'Dados carregados com sucesso';
            $retorno->data = $query;
            return $retorno;
        }

    }

    public function updateDataEscalaColaborador($colaborador_pk,$dt_atual,$nova_data,$leads_pk){


        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="update escala_dados_colaborador set dt_escala='".$nova_data."' where pk in(";
        $sql.="        select pk";
        $sql.="                from(";
        $sql.="                select e.pk";
        $sql.="                    from escala_dados_colaborador e";
        $sql.="                    INNER JOIN agenda_colaborador_padrao a on e.agenda_colaborador_padrao_pk = a.pk";
        $sql.="                    where a.colaboradores_pk = ".$colaborador_pk;
        $sql.="                    and e.dt_escala = '".$dt_atual."'";
        $sql.="                    and a.leads_pk = ".$leads_pk;
        $sql.="                )";
        $sql.="        X)";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();


        $retorno->status = true;
        $retorno->message = 'Informação alterada com sucesso';
        $retorno->data = [];

        return $retorno;
    }


    public function  verificaOutraEscalaColaborador($id_colaborador){


        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $sql="";
        $sql.="SELECT a.pk,";
        $sql.=" l.pk leads_pk,";
        $sql.=" l.ds_lead,";
        $sql.=" c.ds_colaborador,";
        $sql.=" a.turnos_pk,";
        $sql.=" a.hr_inicio_expediente,";
        $sql.=" a.hr_termino_expediente,";
        $sql.="            a.ic_escala_dom ic_dom,";
        $sql.="            a.ic_escala_seg ic_seg,";
        $sql.="            a.ic_escala_ter ic_ter,";
        $sql.="            a.ic_escala_qua ic_qua,";
        $sql.="            a.ic_escala_qui ic_qui,";
        $sql.="            a.ic_escala_sex ic_sex,";
        $sql.="            a.ic_escala_sab ic_sab,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_dom, '%H:%i:%s') hr_turno_dom,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_seg, '%H:%i:%s') hr_turno_seg,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_ter, '%H:%i:%s') hr_turno_ter,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_qua, '%H:%i:%s') hr_turno_qua,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_qui, '%H:%i:%s') hr_turno_qui,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_sex, '%H:%i:%s') hr_turno_sex,";
        $sql.=" TIME_FORMAT(a.hr_inicio_exp_sab, '%H:%i:%s') hr_turno_sab,";
        $sql.="            a.hr_inicio_exp_sab,";
        $sql.=" date_format(a.dt_inicio_agenda, '%d/%m/%Y') dt_inicio_agenda,";
        $sql.=" date_format(a.dt_fim_agenda, '%d/%m/%Y') dt_fim_agenda,";
        $sql.=" date_format(a.dt_cancelamento, '%d/%m/%Y') dt_cancelamento";
        $sql.=" FROM agenda_colaborador_padrao a";
        $sql.="     INNER JOIN leads l ON a.leads_pk = l.pk";
        $sql.="     INNER JOIN colaboradores c ON a.colaboradores_pk = c.pk";
        $sql.=" WHERE c.pk =".$id_colaborador;
        $sql.="       AND a.dt_cancelamento IS NULL";
        //$sql.="       AND a.dt_fim_agenda > sysdate()";


        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno;
    }

    public function pegarPostoDeTrabalhoPorLeadEColaborador($leads_pk,$colaboradores_pk){


        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio


        $sql ="";
        $sql.="select";
        $sql.="     acp.pk";
        $sql.="     ,l.ds_lead";
        $sql.="     ,c.ds_colaborador";
        $sql.="     ,ps.ds_produto_servico ";
        $sql.="     ,date_format(acp.dt_inicio_agenda,'%d/%m/%Y') dt_inicio_agenda ";
        $sql.="     ,date_format(acp.dt_fim_agenda,'%d/%m/%Y') dt_fim_agenda ";
        $sql.="     ,date_format(acp.dt_cancelamento,'%d/%m/%Y') dt_cancelamento ";
        $sql.=" from agenda_colaborador_padrao acp ";
        $sql.="     INNER JOIN leads l ON acp.leads_pk = l.pk";
        $sql.="     INNER JOIN colaboradores c ON acp.colaboradores_pk = c.pk";
        $sql.="     INNER JOIN colaboradores_produtos_servicos cps ON c.pk = cps.colaboradores_pk";
        $sql.="     INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
        $sql.=" where 1=1";

        if(!empty($leads_pk)){
            $sql.=" And l.pk=".$leads_pk;
        }

        if(!empty($colaboradores_pk)){
            $sql." And c.pk=".$colaboradores_pk;
        }
        $sql.=" group by acp.pk ";
        $sql.=" order by l.ds_lead";

        $stmt = $this->pdo->prepare( $sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;

        return $retorno;
    }

    public function listarTurno(){


        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select pk ";
        $sql.="       ,ds_turno ";

        $sql.="  from turnos ";
        $sql.=" where 1=1 ";
        $sql.=" order by ds_turno asc ";


        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno;
    }

    public function processa_escala(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $retorno->message = ""; //Retorno data setado como vazio
        try{
            $sql = "";
            $sql.= "SELECT acp.pk agenda_colaborador_padrao_pk, acp.dt_inicio_agenda, acp.dt_fim_agenda, acp.colaboradores_pk,";
            $sql.="        date_format(acp.dt_inicio_agenda, '%m') mes_inicio_agenda,";
            $sql.="        date_format(acp.dt_inicio_agenda, '%Y') ano_inicio_agenda,";
            $sql.="        acp.dt_fim_agenda,";
            $sql.="        te.ds_tipo_escala n_qtde_dias_semana,";
            $sql.="        acp.tipos_escalas_pk tipo_escala,";         
            $sql.="        acp.ic_escala_dom ic_dom,";
            $sql.="        acp.ic_escala_seg ic_seg,";
            $sql.="        acp.ic_escala_ter ic_ter,";
            $sql.="        acp.ic_escala_qua ic_qua,";
            $sql.="        acp.ic_escala_qui ic_qui,";
            $sql.="        acp.ic_escala_sex ic_sex,";
            $sql.="        acp.ic_escala_sab ic_sab,";
            $sql.="        acp.turnos_pk dom_turnos_pk,";
            $sql.="        acp.turnos_pk seg_turnos_pk,";
            $sql.="        acp.turnos_pk ter_turnos_pk,";
            $sql.="        acp.turnos_pk qua_turnos_pk,";
            $sql.="        acp.turnos_pk qui_turnos_pk,";
            $sql.="        acp.turnos_pk sex_turnos_pk,";
            $sql.="        acp.turnos_pk sab_turnos_pk,";
            $sql.="        acp.turnos_pk";
            $sql.="  FROM agenda_colaborador_padrao acp";
            $sql.=" inner join colaboradores c on acp.colaboradores_pk = c.pk";
            $sql.="  left join escala_dados_colaborador edc on edc.agenda_colaborador_padrao_pk = acp.pk";
           
            $sql.=" inner join tipos_escalas te on acp.tipos_escalas_pk = te.pk";
            $sql.=" WHERE acp.dt_cancelamento IS NULL";
            $sql.="   and c.ic_status = 1";
            $sql.="   and edc.agenda_colaborador_padrao_pk is null";
            $sql.="   order by te.ds_tipo_escala desc";
            
            
            $stmt = $this->pdo->prepare( $sql );
            $stmt->execute();
            $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            for($i=0;$i<count($query);$i++){
                $agenda_colaborador_padrao_pk = $query[$i]['agenda_colaborador_padrao_pk'];
                //echo $agenda_colaborador_padrao_pk;
    
                $queryDias = $this->retornarDifData($query[$i]['dt_inicio_agenda'],$query[$i]['dt_fim_agenda']);
                $qtdeDias = $queryDias[0]['dtdif'];
                $dtIni = (explode("-",$query[$i]['dt_inicio_agenda'])); 
                $diaIniPeriodo = $dtIni[2];  
                $dia = $dtIni[2];  
                $MesIniPeriodo = $dtIni[1];
                $AnoIniPeriodo = $dtIni[0]; 
                
                $dtFim = (explode("-",$query[$i]['dt_fim_agenda']));
                $diaFimPeriodo = $dtFim[2];  
                $MesFimPeriodo = $dtFim[1];
                $AnoFimPeriodo = $dtFim[0]; 
    
                for ($a=0; $a <= $qtdeDias; $a++){
                    $ic_escala ='';
                    $dt_escala = $AnoIniPeriodo.'-'.$MesIniPeriodo.'-'.$dia;
                    $ultimoDiaMes = cal_days_in_month(CAL_GREGORIAN, $MesFimPeriodo, $AnoFimPeriodo);                                                                 
                    $n_qtde_dias_semana = str_replace(' ', '', $query[$i]['n_qtde_dias_semana']);
                    
                    if($n_qtde_dias_semana==='12X36'){ 
                        $ic_dia ='';
                        $dt_inicio_agenda = $query[$i]['dt_inicio_agenda'];
                        $v_mes_inicio_agenda = $query[$i]['mes_inicio_agenda'];
                        $v_ano_inicio_agenda = $query[$i]['ano_inicio_agenda'];
                        $dt_periodo_fim = $AnoFimPeriodo."-".$MesFimPeriodo."-".$ultimoDiaMes;
                        $vtipoEscalaCadastro = $query[$i]['tipo_escala'];
        
                        //Calcula se a escala é ímpar ou par
                        $ic_mes = $this->retornarEscalaImpar_Par($dt_inicio_agenda, $v_mes_inicio_agenda, $v_ano_inicio_agenda, $dt_periodo_fim, $vtipoEscalaCadastro, $MesIniPeriodo);
                        if($dia % 2 == 0){
                            $ic_dia = 2;
                        }else{
                            $ic_dia = 1;
                        }
        
        
                        if($ic_mes == $ic_dia){
                            $ic_escala = 1;
                        }else{
                            $ic_escala = 2;
                        }
                    }
                    else{
                        $diasemana = array('Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab');         
                        $diasemana_numero = date('w', strtotime($AnoIniPeriodo."-".$MesIniPeriodo."-".$dia));  
                        if($diasemana[$diasemana_numero]=="Dom"){
                            $ic_escala = $query[$i]['ic_dom'];   
                        }elseif($diasemana[$diasemana_numero]=="Seg"){
                            $ic_escala = $query[$i]['ic_seg'];
                        }elseif($diasemana[$diasemana_numero]=="Ter"){
                            $ic_escala = $query[$i]['ic_ter'];
                        }elseif($diasemana[$diasemana_numero]=="Qua"){
                            $ic_escala = $query[$i]['ic_qua'];
                        }elseif($diasemana[$diasemana_numero]=="Qui"){
                            $ic_escala = $query[$i]['ic_qui']; 
                        }elseif($diasemana[$diasemana_numero]=="Sex"){
                            $ic_escala = $query[$i]['ic_sex'];
                        }elseif($diasemana[$diasemana_numero]=="Sab"){
                            $ic_escala = $query[$i]['ic_sab']; 
                        }
                    }
                    if($query[$i]['n_qtde_dias_semana']!=""){
                        $fields = array();
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];
                        $fields["dt_ult_atualizacao"]  = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                        $fields["dt_escala"] = $dt_escala;
                        $fields["ic_escala"] = $ic_escala;
                        $fields["tipo_escala_pk"] = $query[$i]['n_qtde_dias_semana'];
                        $fields["agenda_colaborador_padrao"] = $agenda_colaborador_padrao_pk;
            
                        Util::execInsert("escala_dados_colaborador", $fields, $this->pdo);
                    }
                    
        
                    $ultimoDiaMesIni = cal_days_in_month(CAL_GREGORIAN, $MesIniPeriodo, $AnoIniPeriodo);
                    if($ultimoDiaMesIni == $dia){  
                        if($MesIniPeriodo == '12'){
                            $AnoIniPeriodo =  $AnoIniPeriodo + 1;
                            $MesIniPeriodo = 1;
                        }else{
                            $MesIniPeriodo++;
                        }
                        $dia = 1;
                    }else{
                        $dia++;
                    }  
                }  
            }
            
            $retorno->status = true;
            $retorno->message = 'Dados carregados com sucesso';
            $retorno->data = [];
            return $retorno;
        }
        catch (Throwable $e){
            print_r($e->getMessage());
            die();
        }
        
    }
}
