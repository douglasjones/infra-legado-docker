<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;
use Throwable;

class PontoFolha {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function excluir($pk){
        Util::execDelete('ponto_folha_registros', ' ponto_folha_pk='.$pk, $this->pdo);
        Util::execDelete('ponto_folha_colaborador', ' ponto_folha_pk='.$pk, $this->pdo);
        Util::execDelete('ponto_folha', ' pk='.$pk, $this->pdo);
    }
    public function listarGrid($empresas_pk, $leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        $result = []; //Retorno data setado como vazio

        $sql ="";
        $sql.=" SELECT";
        $sql.="    c.ds_conta,";
        $sql.="    pf.pk,";
        $sql.="    l.ds_lead,";
        $sql.="    l.pk lead_pk";
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.contas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        $sql.=" AND pf.contas_pk is not null";
        if(!empty($empresas_pk)){
            $sql.=" AND pf.contas_pk=".$empresas_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" AND pf.leads_pk=".$leads_pk;
        }
        $sql.=" GROUP BY l.ds_lead";
        $sql.=" ORDER BY l.ds_lead";
  

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        if(count($query) > 0){
            for($i=0; $i<count($query);$i++){
                $sql ="";
                $sql.=" SELECT YEAR(dt_periodo_ini) ano_folha";
                $sql.="   FROM ponto_folha pf";
                $sql.="  WHERE pf.leads_pk =". $query[$i]['lead_pk'];
                $sql.="  GROUP BY YEAR(dt_periodo_ini)";
                


                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $ano = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                $folhas = array();
                for($l=0; $l<count($ano);$l++){
                    $sql ="";
                    $sql.=" SELECT MONTH(dt_periodo_ini) mes_folha";
                    $sql.="  ,CASE MONTHNAME(pf.dt_periodo_ini)";
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
                    $sql.="    END as ds_mes";
                    $sql.="   FROM ponto_folha pf";
                    $sql.="  WHERE pf.leads_pk =". $query[$i]['lead_pk'];
                    $sql.="    AND YEAR(pf.dt_periodo_ini) = ".$ano[$l]['ano_folha'];
                    $sql.="  GROUP BY MONTH(pf.dt_periodo_ini)";
                    $sql.="  ORDER BY MONTH(pf.dt_periodo_ini)";
                    
                    $stmt = $this->pdo->prepare( $sql );
                    $stmt->execute();
                    $mes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                    $folhaPorMes = array();
                    for($a=0;$a<count($mes);$a++){
                        $sql ="";
                        $sql.=" SELECT DATE_FORMAT(pf.dt_cadastro, '%d/%m/%Y') dt_cadastro, pf.pk ponto_folha_pk";
                        $sql.="   FROM ponto_folha pf";
                        $sql.="  WHERE pf.leads_pk =". $query[$i]['lead_pk'];
                        $sql.="    AND YEAR(pf.dt_periodo_ini) = ".$ano[$l]['ano_folha'];
                        $sql.="    AND MONTH(pf.dt_periodo_ini) = ".$mes[$a]['mes_folha'];
                        
                        $stmt = $this->pdo->prepare( $sql );
                        $stmt->execute();
                        $folhasMes = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                        $folhaPorMes[] = array(
                            "ds_mes" => $mes[$a]["ds_mes"],
                            "folhas_mes"=> $folhasMes
                        );

                    }

                    $folhas[] = array(
                        "ds_ano" => $ano[$l]["ano_folha"],
                        "folhaPorMes"=> $folhaPorMes
                    );

                }

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_conta"=>$query[$i]['ds_conta'],
                    "ds_lead"=>$query[$i]['ds_lead'],
                    "lead_pk"=>$query[$i]['lead_pk'],
                    "mesesNoAno"=>$folhas
                );
            }
        }


        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $result;
        $retorno->iTotalDisplayRecords = count($result);
        $retorno->iTotalRecords = count($result);

        return $retorno;
    }
    public function salvarRegistros($jsonDadosRegistros){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        try{
            $arrDadosRegistros = json_decode($jsonDadosRegistros, true);
          
            for($i=0;$i<count($arrDadosRegistros);$i++){

                $fields = array();
                $fields['ponto_pk'] = $arrDadosRegistros[$i]['ponto_folha_pk'];
                $fields['tipos_ponto_pk'] = $arrDadosRegistros[$i]['tipo_ponto_pk'];
                if($arrDadosRegistros[$i]['dt_hora_ponto']!=""){
                    $fields['dt_hora_ponto'] = Util::DataYMD($arrDadosRegistros[$i]['dt_hora_ponto']);
                }
                
                $fields['colaborador_pk'] = $arrDadosRegistros[$i]['colaborador_pk'];
                $fields['ponto_folha_pk'] = $arrDadosRegistros[$i]['ponto_folha_pk'];
                $fields['hr_ini_expediente'] = $arrDadosRegistros[$i]['hr_ini_expediente'];
                $fields['hr_ini_intervalo'] = $arrDadosRegistros[$i]['hr_ini_intervalo'];
                $fields['hr_termino_intervalo'] = $arrDadosRegistros[$i]['hr_fim_intervalo'];
                $fields['hr_termino_expediente'] = $arrDadosRegistros[$i]['hr_fim_expediente'];
                $fields['hr_trabalhadas'] = $arrDadosRegistros[$i]['hr_trabalhadas'];
                $fields['hr_excedente'] = $arrDadosRegistros[$i]['hr_excedentes'];
                $fields['hr_faltantes'] = $arrDadosRegistros[$i]['hr_faltantes'];
                $fields['hr_extra50'] = $arrDadosRegistros[$i]['hr_extra50'];           
                $fields['hr_extra100'] = $arrDadosRegistros[$i]['hr_extra100'];                 
                $fields['hr_adicional_noturno'] = $arrDadosRegistros[$i]['hr_adicional_noturno'];
                $fields['ic_status'] = $arrDadosRegistros[$i]['ic_status'];

                $fields['obs'] = $arrDadosRegistros[$i]['obs'];        
        
                $fields["dt_ult_atualizacao"] = "sysdate()";
                $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                
                if($arrDadosRegistros[$i]['pk']  == ""){

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("ponto_folha_registros", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                }
                else{
                    if($arrDadosRegistros[$i]['hr_ini_expediente']== '' && 
                        $arrDadosRegistros[$i]['hr_ini_intervalo']== '' && 
                        $arrDadosRegistros[$i]['hr_fim_intervalo']== '' && 
                        $arrDadosRegistros[$i]['hr_fim_expediente']== ''){
                            
                        Util::execDelete('ponto_folha_registros'," pk = ".$arrDadosRegistros[$i]['pk'],$this->pdo);

                        $fieldsUpdate = array();
                        $fieldsUpdate['ponto_pk'] = $arrDadosRegistros[$i]['ponto_folha_pk'];
                        $fieldsUpdate['tipos_ponto_pk'] = $arrDadosRegistros[$i]['tipo_ponto_pk'];
                        if($arrDadosRegistros[$i]['dt_hora_ponto']!=""){
                            $fieldsUpdate['dt_hora_ponto'] = Util::DataYMD($arrDadosRegistros[$i]['dt_hora_ponto']);
                        } 
                        
                        $fieldsUpdate['colaborador_pk'] = $arrDadosRegistros[$i]['colaborador_pk'];
                        $fieldsUpdate['ponto_folha_pk'] = $arrDadosRegistros[$i]['ponto_folha_pk'];

                        $fieldsUpdate['ic_status'] = $arrDadosRegistros[$i]['ic_status'];

                        $fieldsUpdate['obs'] = $arrDadosRegistros[$i]['obs'];        
                
                        $fieldsUpdate["dt_ult_atualizacao"] = "sysdate()";
                        $fieldsUpdate["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                        $fieldsUpdate["dt_cadastro"] = "sysdate()";
                        $fieldsUpdate["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];
                        
                        $pk = Util::execInsert("ponto_folha_registros", $fieldsUpdate, $this->pdo);

                    }else{
                        Util::execUpdate("ponto_folha_registros", $fields, " pk = ".$arrDadosRegistros[$i]['pk'],$this->pdo);
                        $pk = $arrDadosRegistros[$i]['pk'];
                        $retorno->status = true;
                        $retorno->message = 'Dados atualizado com sucesso';
                        $retorno->data = $pk;
                    }
                }
            }

            return $retorno;
        }
        catch(Throwable $th){
            print_r($th->getMessage());
            die();
        }
        

    }

    public function salvarFolhaFinalizada($pontoFolhaFinalizada){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        
        $fields['ic_status'] = $pontoFolhaFinalizada['ic_status'];       
        $fields['dt_validacao'] = "sysdate()";
        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
        
        $pk = Util::execUpdate("ponto_folha_colaborador", $fields, "ponto_folha_pk = ".$pontoFolhaFinalizada['pk']." and colaborador_pk = ".$pontoFolhaFinalizada['colaborador_pk'],$this->pdo);
        
        $retorno->status = true;
        $retorno->message = 'Dados cadastrados com sucesso';
        $retorno->data = $pk;
        return $retorno;
    }

    public function salvar($pontoFolha){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $dt_periodo_ini = Util::DataYMD($pontoFolha['dt_periodo_ini']);
        $dt_periodo_fim = Util::DataYMD($pontoFolha['dt_periodo_fim']);

        $fields = array();
        $fields['contas_pk'] = $pontoFolha['empresas_pk'];
        $fields['dt_periodo_ini'] = $dt_periodo_ini;
        $fields['dt_periodo_fim'] = $dt_periodo_fim;
        $fields['obs'] = $pontoFolha['obs'];
        $fields['leads_pk'] = $pontoFolha['leads_pk'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($pontoFolha['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("ponto_folha", $fields,$this->pdo);
            //Salva os colaboradores selecionados
            $this->salvarColaborador($pk, $pontoFolha['arrColaborador'], $dt_periodo_ini, $dt_periodo_fim);

            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }

        
        return $retorno;

    }

    public function salvarColaborador($ponto_folha_pk, $arrColaborador, $dt_periodo_ini, $dt_periodo_fim){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $arrColaborador = explode(',', $arrColaborador);
        $str_dados = [];
        for($i=0; $i<count($arrColaborador);$i++){
            if($arrColaborador[$i] != ''){
                $str_dados[$i] = (explode("|",$arrColaborador[$i]));
    
                $fields = array();
                $fields['ponto_folha_pk'] = $ponto_folha_pk;
                $fields['colaborador_pk'] = $str_dados[$i][0];
    
                $fields["dt_ult_atualizacao"] = "sysdate()";
                $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
    
    
                $fields["dt_cadastro"] = "sysdate()";
                $fields["usuario_cadastro_pk"]   =  $_SESSION['session_user']['par1'];
                $pk = Util::execInsert("ponto_folha_colaborador", $fields,$this->pdo);
                
                //Salva os registros de ponto
                $this->salvarItens($dt_periodo_ini, $dt_periodo_fim, $str_dados[$i][0], $str_dados[$i][1], $ponto_folha_pk);
            }
        }
        
        return $pk;

    }

    public function salvarItens($dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $agenda_colaborador_padrao_pk, $ponto_folha_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        // DADOS DE PARAMETRIZACAO PARA DADOS DE REGISTRO FOLHA
            //Retorna dados escala
                $dadosEscala = $this->listarDadosEscala($dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $agenda_colaborador_padrao_pk);
                
                $hr_saida_intervalo = $dadosEscala[0]["hr_saida_intervalo"];
                $hr_inicio_expediente = $dadosEscala[0]["hr_inicio_expediente"];
                $hr_termino_expediente = $dadosEscala[0]["hr_termino_expediente"];
                $hr_retorno_intervalo = $dadosEscala[0]["hr_retorno_intervalo"];
                $ic_intrajornada = $dadosEscala[0]["ic_intrajornada"];
                $hr_expediente = $dadosEscala[0]["hr_expediente"];
                
            //Retorna preenchimento automatico
                $ic_preencher_folha = $this->listarPreenchimentoAutomatico();

            //Retorna dados Ponto 
                //Dados 5x2
                    $dadosPonto = $this->listarDadosPonto5x2($dt_periodo_ini, 
                                                            $dt_periodo_fim, 
                                                            $colaboradores_pk, 
                                                            $hr_inicio_expediente, 
                                                            $hr_termino_expediente, 
                                                            $hr_saida_intervalo, 
                                                            $hr_retorno_intervalo, 
                                                            $hr_expediente, 
                                                            $ic_intrajornada, 
                                                            $agenda_colaborador_padrao_pk, 
                                                            $ic_preencher_folha
                                                        );


                                                   

        //Salvar registros com base nos pontos/apontamentos informados. 
        for($i=0;$i<count($dadosPonto);$i++){
            $fields = array();
            $fields['dt_hora_ponto'] = $dadosPonto[$i]['dt_hora_ponto'];
            $fields['colaborador_pk'] = $colaboradores_pk;
            $fields['ponto_folha_pk'] = $ponto_folha_pk;
            $fields['hr_ini_expediente'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_ini_expediente'];
            $fields['hr_ini_intervalo'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_ini_intervalo'];
            $fields['hr_termino_intervalo'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_term_intervalo'];
            $fields['hr_termino_expediente'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_term_expediente'];
            $fields['hr_trabalhadas'] = $dadosPonto[$i]['pontos_dia'][0]['horas_trabalhadas'];
            $fields['hr_excedente'] = $dadosPonto[$i]['pontos_dia'][0]['hr_excedentes'];
            $fields['hr_faltantes'] = $dadosPonto[$i]['pontos_dia'][0]['hr_faltante'];
            $fields['tipos_ponto_pk'] = $dadosPonto[$i]['pontos_dia'][0]['tipo_ponto_pk'];
            $fields['obs'] = $dadosPonto[$i]['pontos_dia'][0]['obs'];
    
            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
    
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]  = $_SESSION['session_user']['par1'];
    
            $pk = Util::execInsert("ponto_folha_registros", $fields,$this->pdo);
        }
        

    }
    public function regerar($ponto_folha_pk, $dt_periodo_ini, $dt_periodo_fim,$arrColaborador){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        try{
            $arrColaborador = json_decode($arrColaborador,true);

            $dt_periodo_ini = Util::DataYMD($dt_periodo_ini);
            $dt_periodo_fim = Util::DataYMD($dt_periodo_fim);
            for($l=0;$l<count($arrColaborador);$l++){
                $colaborador_pk = $arrColaborador[$l];
                
                // DADOS DE PARAMETRIZACAO PARA DADOS DE REGISTRO FOLHA
                    //Retorna dados escala
                    $dadosEscala = $this->listarDadosEscala($dt_periodo_ini, $dt_periodo_fim, $colaborador_pk, '');
                    if(count($dadosEscala)>0){
                        $hr_saida_intervalo = $dadosEscala[0]["hr_saida_intervalo"];
                        $hr_inicio_expediente = $dadosEscala[0]["hr_inicio_expediente"];
                        $hr_termino_expediente = $dadosEscala[0]["hr_termino_expediente"];
                        $hr_retorno_intervalo = $dadosEscala[0]["hr_retorno_intervalo"];
                        $ic_intrajornada = $dadosEscala[0]["ic_intrajornada"];
                        $hr_expediente = $dadosEscala[0]["hr_expediente"];
                        $agenda_colaborador_padrao_pk = $dadosEscala[0]["pk"];

                            
                    //Retorna preenchimento automatico
                        $ic_preencher_folha = $this->listarPreenchimentoAutomatico();

                    //Retorna dados Ponto /Apontamento
                        $dadosPonto = $this->listarDadosRegerar($ponto_folha_pk,
                                                                $dt_periodo_ini, 
                                                                $dt_periodo_fim, 
                                                                $colaborador_pk, 
                                                                $hr_inicio_expediente, 
                                                                $hr_termino_expediente, 
                                                                $hr_saida_intervalo, 
                                                                $hr_retorno_intervalo, 
                                                                $hr_expediente, 
                                                                $ic_intrajornada, 
                                                                $agenda_colaborador_padrao_pk,
                                                                $ic_preencher_folha);

                    //Salvar registros com base nos pontos/apontamentos informados. 
                    for($i=0;$i<count($dadosPonto);$i++){
                        $fields = array();
                        $fields['dt_hora_ponto'] = $dadosPonto[$i]['dt_hora_ponto'];
                        $fields['colaborador_pk'] = $colaborador_pk;
                        $fields['ponto_folha_pk'] = $ponto_folha_pk;
                        $fields['hr_ini_expediente'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_ini_expediente'];
                        $fields['hr_ini_intervalo'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_ini_intervalo'];
                        $fields['hr_termino_intervalo'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_term_intervalo'];
                        $fields['hr_termino_expediente'] = $dadosPonto[$i]['pontos_dia'][0]['ponto_term_expediente'];
                        $fields['hr_trabalhadas'] = $dadosPonto[$i]['pontos_dia'][0]['horas_trabalhadas'];
                        $fields['hr_excedente'] = $dadosPonto[$i]['pontos_dia'][0]['hr_excedentes'];
                        $fields['hr_faltantes'] = $dadosPonto[$i]['pontos_dia'][0]['hr_faltante'];
                        $fields['tipos_ponto_pk'] = $dadosPonto[$i]['pontos_dia'][0]['tipo_ponto_pk'];
                        $fields['obs'] = $dadosPonto[$i]['pontos_dia'][0]['obs'];
                
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"]  = $_SESSION['session_user']['par1'];
                
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"]  = $_SESSION['session_user']['par1'];


                        if($dadosPonto[$i]['pk']!=""){
                            Util::execUpdate("ponto_folha_registros", $fields, " pk = ".$dadosPonto[$i]['pk'],$this->pdo);
                        }
                        else{
                            $fields["dt_cadastro"] = "sysdate()";
                            $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];
                            Util::execInsert("ponto_folha_registros", $fields,$this->pdo);
                        }

                        
                    }
                    }
                    
            }
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = '';

            return $retorno;
        }
        catch(Throwable $th){
            print_r($th->getMessage());
            die();
        }
        

    }

    public function listarDadosEscala($dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $agenda_colaborador_padrao_pk){
        
        $result = [];
        $sql="";
        $sql.=" SELECT tipos_escalas_pk,";
        $sql.="   CASE tipos_escalas_pk";
        $sql.="        WHEN 1 THEN 'ímpar'";
        $sql.="        WHEN 2 THEN 'par'";
        $sql.="   END ds_tipo_escala,";
        $sql.="   turnos_pk,";
        $sql.="   pk,";
        $sql.="   CASE turnos_pk";
        $sql.="        WHEN 1 THEN 'Manhã'";
        $sql.="        WHEN 2 THEN 'Tarde'";
        $sql.="        WHEN 3 THEN 'Noite'";
        $sql.="        WHEN 4 THEN 'Dia Todo'";
        $sql.="   END ds_turno,";
        $sql.="   hr_inicio_expediente,";
        $sql.="   hr_termino_expediente,";
        $sql.="   hr_inicio_intervalo,";
        $sql.="   hr_termino_intervalo,";
        $sql.="   ic_intrajornada";
        $sql.="  FROM agenda_colaborador_padrao";
        $sql.=" WHERE dt_inicio_agenda <= '".$dt_periodo_ini."'";
        $sql.="   AND dt_fim_agenda >= '".$dt_periodo_fim."'";
        $sql.="   AND colaboradores_pk =".$colaboradores_pk;
        if(!empty($agenda_colaborador_padrao_pk)){
            $sql.="   AND pk =".$agenda_colaborador_padrao_pk;
        }

   
        
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);  
        if(count($query)>0){
            if($query[0]['ic_intrajornada'] == "2" || $query[0]['ic_intrajornada'] == ''){
                $hr_intervalo_expediente = $this->retornarDifHora($query[0]['hr_inicio_intervalo'], $query[0]['hr_termino_intervalo']);
                $hr_intervalo_expediente = $hr_intervalo_expediente[0]['dif'];
                
            }else{
                $hr_intervalo_expediente = '01:00';
            }
    
            /* if($query[0]['turnos_pk'] == 3 && $query[0]['hr_termino_expediente'] != ''){
                // Adicionar 24 horas ao fim do expediente
                $hr_inicio_expediente = date('H:i', strtotime($query[0]['hr_inicio_expediente'] . ' + 12 hours'));
            }else{
                $hr_inicio_expediente = $query[0]['hr_inicio_expediente'];
            }
            */
            $hr_expediente = $this->retornarDifHora($query[0]['hr_inicio_expediente'], $query[0]['hr_termino_expediente']);
            $hr_expediente = $hr_expediente[0]['dif'];
    
            $hr_trabalhadas_expediente = $this->retornarDifHora($hr_intervalo_expediente, $hr_expediente);
            $hr_trabalhadas_expediente = $hr_trabalhadas_expediente[0]['dif'];
            
    
            $result[] = array(
                "tipo_escala" => $query[0]["tipos_escalas_pk"],
                "ds_tipo_escala"=>$query[0]['ds_tipo_escala'],
                "turnos_pk"=>$query[0]['turnos_pk'],
                "ds_turno"=>$query[0]['ds_turno'],
                "pk"=>$query[0]['pk'],
                "hr_inicio_expediente"=>$query[0]['hr_inicio_expediente'],
                "hr_termino_expediente"=>$query[0]['hr_termino_expediente'],
                "hr_saida_intervalo"=>$query[0]['hr_inicio_intervalo'],
                "hr_retorno_intervalo"=>$query[0]['hr_termino_intervalo'],
                "ic_intrajornada"=>$query[0]['ic_intrajornada'],
                "hr_expediente"=>$hr_trabalhadas_expediente
            );
        }
        

       
        
        return $result;

    }
    

    public function listarDiasEscala($agenda_colaborador_padrao_pk,$dt_periodo_ini,$dt_periodo_fim){

        $sql="";
        $sql.="SELECT ic_escala,";
        $sql.="       dt_escala,";
        $sql.="      CASE 
                        WHEN DAYOFWEEK(dt_escala) = 1 THEN 'Dom'
                        WHEN DAYOFWEEK(dt_escala) = 2 THEN 'Seg'
                        WHEN DAYOFWEEK(dt_escala) = 3 THEN 'Ter'
                        WHEN DAYOFWEEK(dt_escala) = 4 THEN 'Qua'
                        WHEN DAYOFWEEK(dt_escala) = 5 THEN 'Qui'
                        WHEN DAYOFWEEK(dt_escala) = 6 THEN 'Sex'
                        WHEN DAYOFWEEK(dt_escala) = 7 THEN 'Sáb'
                    END AS dia_da_semana,";
        $sql.="       date_format(dt_escala,'%d/%m/%Y')dt_format";
        $sql.="  FROM escala_dados_colaborador";
        $sql.=" WHERE agenda_colaborador_padrao_pk =".$agenda_colaborador_padrao_pk;
        $sql.="   AND dt_escala BETWEEN '".$dt_periodo_ini."' AND '".$dt_periodo_fim."'";
        $sql.=" Group By dt_escala";
        


        
        
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
        return $query;
    }

    public function listarDadosRegistrosFolha($ponto_folha_pk, $colaborador_pk ,$dt_periodo_ini,$dt_periodo_fim){

        $sql="";
        $sql.="SELECT pk, DATE(dt_hora_ponto)";
        $sql.="       ,tipos_ponto_pk";
        $sql.="       ,ic_status";
        $sql.="  FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk =".$ponto_folha_pk;
        $sql.="   AND colaborador_pk =".$colaborador_pk;
        $sql.="   AND dt_hora_ponto >='".$dt_periodo_ini." 00:00:00'";
        $sql.="   AND dt_hora_ponto <='".$dt_periodo_fim." 23:59:59'";
        $sql.=" ORDER BY dt_hora_ponto";
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);   
        return $query;
    }

    public function listarDadosApontamento($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk){

        $arrApontamento = [];
        $arrDadosApontamento = [];
        $tipo_apontamento_pk = '';

        $arrApontamentoAfastamento = $this->listarApontamentoAfastamento($dt_escala, $colaboradores_pk);
        if(count($arrApontamentoAfastamento)!=0){
            $tipo_apontamento_pk = 5;
            $arrApontamento = $arrApontamentoAfastamento;
        }

        $arrApontamentoFerias = $this->listarApontamentoFerias($dt_escala, $colaboradores_pk);
        if(count($arrApontamentoFerias)!=0){
            $tipo_apontamento_pk = 6;
            $arrApontamento = $arrApontamentoFerias;
        }

        $arrApontamentoPonto = $this->listarApontamentoPonto($dt_escala, $colaboradores_pk);
        if(count($arrApontamentoPonto)!=0){
            $tipo_apontamento_pk = 1;
            $arrApontamento = $arrApontamentoPonto;
        }

        $arrApontamentoFalta = $this->listarApontamentoFalta($dt_escala, $colaboradores_pk);
        if(count($arrApontamentoFalta)!=0){
            $tipo_apontamento_pk = 2;
            $arrApontamento = $arrApontamentoFalta;
        }
        
        $arrApontamentoFolga = $this->listarApontamentoFolga($dt_escala, $colaboradores_pk);
        if(count($arrApontamentoFolga)!=0){
            $tipo_apontamento_pk = 3;
            $arrApontamento = $arrApontamentoFolga;
        }
        
        $arrDadosApontamento[] = array(
            "tipo_apontamento_pk" => $tipo_apontamento_pk,
            "arrApontamento" => $arrApontamento
        );

        
        return $arrDadosApontamento;
    }

    public function listarApontamentoPonto($dt_escala, $colaboradores_pk){
        $sql = "";
        $sql.= "  SELECT ap.dt_ponto, ap.hr_ponto, ap.tipo_ponto_pk, ap.ds_obs_ponto";
        $sql.= "    FROM apontamento_ponto ap";
        $sql.= "   INNER JOIN agenda_colaborador_apontamento acp ON ap.agenda_colaborador_apontamento_pk = acp.pk";
        $sql.= "   WHERE ap.dt_ponto ='".$dt_escala."'";
        $sql.= "     AND acp.colaborador_pk  = ".$colaboradores_pk;
       
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
    }

    public function listarApontamentoFalta($dt_escala, $colaboradores_pk){
        $sql = "";
        $sql.= "  SELECT af.motivo_falta_pk, af.dt_falta, af.ds_obs_falta";
        $sql.= "    FROM apontamento_falta af";
        $sql.= "   INNER JOIN agenda_colaborador_apontamento acp ON af.agenda_colaborador_apontamento_pk = acp.pk";
        $sql.= "   WHERE af.dt_falta ='".$dt_escala."'";
        $sql.= "     AND acp.colaborador_pk  = ".$colaboradores_pk;
       
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
    }

    public function listarApontamentoFolga($dt_escala, $colaboradores_pk){
        $sql = "";
        $sql.= "  SELECT af.motivo_folga_pk, af.dt_folga, af.ds_obs_folga, af.apontamento_falta_pk";
        $sql.= "    FROM apontamento_folga af";
        $sql.= "   INNER JOIN agenda_colaborador_apontamento acp ON af.agenda_colaborador_apontamento_pk = acp.pk";
        $sql.= "   WHERE af.dt_folga ='".$dt_escala."'";
        $sql.= "     AND acp.colaborador_pk  = ".$colaboradores_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;

    }

    public function listarApontamentoAfastamento($dt_escala, $colaboradores_pk){

        $sql = "";
        $sql.= "  SELECT aa.motivo_afastamento_pk, aa.dt_ini_afastamento, aa.dt_fim_afastamento, aa.ds_obs_afastamento";
        $sql.= "    FROM apontamento_afastamento aa";
        $sql.= "   INNER JOIN agenda_colaborador_apontamento acp ON aa.agenda_colaborador_apontamento_pk = acp.pk";
        $sql.= "   WHERE aa.dt_ini_afastamento <='".$dt_escala."'";
        $sql.= "     AND aa.dt_fim_afastamento  >='".$dt_escala."'";
        $sql.= "     AND acp.colaborador_pk  = ".$colaboradores_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
    }

    public function listarApontamentoFerias($dt_escala, $colaboradores_pk){

        $sql = "";
        $sql.= "  SELECT af.dt_ini_ferias, af.dt_fim_ferias, af.ds_obs_ferias";
        $sql.= "    FROM apontamento_ferias af";
        $sql.= "   INNER JOIN agenda_colaborador_apontamento acp ON af.agenda_colaborador_apontamento_pk = acp.pk";
        $sql.= "   WHERE af.dt_ini_ferias <='".$dt_escala."'";
        $sql.= "     AND af.dt_fim_ferias  >='".$dt_escala."'";
        $sql.= "     AND acp.colaborador_pk  = ".$colaboradores_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
    }


    public function listarDadosPonto5x2($dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $hr_inicio_expediente, $hr_termino_expediente, $hr_saida_intervalo, $hr_retorno_intervalo, $hr_expediente, $ic_intrajornada, $agenda_colaborador_padrao_pk, $ic_preencher_folha){              

        $diasEscala = $this->listarDiasEscala($agenda_colaborador_padrao_pk,$dt_periodo_ini, $dt_periodo_fim);

        for($i=0; $i<count($diasEscala); $i++){  
            $dt_escala = $diasEscala[$i]['dt_escala'];
            $arrApontamento = $this->listarDadosApontamento($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk);
            $ponto_ini_expediente = "";
            $ponto_term_expediente = "";
            $ponto_ini_intervalo = "";
            $ponto_term_intervalo = "";
            $hr_excedentes = " ";
            $hr_faltante = " ";
            $horas_trabalhadas = " ";
            $obs = " ";

            $arrPontos = [];
            
            //if(count($arrApontamento[0]['arrApontamento']) == 0){

                //if($diasEscala[$i]['ic_escala'] == 1){
        
                    //Query de verificação dos pontos
                    $sql='';
                    $sql.='Select p.pk';
                    $sql.='      ,p.tipos_ponto_pk';
                    $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%H:%i") hora_ponto'; 
                    $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%d-%m-%Y") dt_ponto'; 
                    $sql.='  from ponto p';
                    $sql.=' where p.colaborador_pk ='.$colaboradores_pk;
                    $sql.='   and p.dt_hora_ponto >="'.$dt_escala.' 00:00:00"';
                    $sql.='   and p.dt_hora_ponto <="'.$dt_escala.' 23:59:59"';
                    $sql.=" order by p.dt_hora_ponto";
                    
                    
                    $stmt = $this->pdo->prepare( $sql );
                    $stmt->execute();
                    $query = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
                    
                    //Verificação de tipo de ponto
                    for($l=0; $l<count($query); $l++){
                        if($query[$l]['tipos_ponto_pk'] == 1){
                            $ponto_ini_expediente = $query[$l]["hora_ponto"];
                        }
                        if($query[$l]['tipos_ponto_pk'] == 2){
                            $ponto_term_expediente = $query[$l]["hora_ponto"];
                        }
                        if($query[$l]['tipos_ponto_pk'] == 3){
                            $ponto_ini_intervalo = $query[$l]["hora_ponto"];
                        }
                        if($query[$l]['tipos_ponto_pk'] == 4){
                            $ponto_term_intervalo = $query[$l]["hora_ponto"];
                        }
                    }

                    if($ponto_ini_expediente != '' || $ponto_term_expediente != ''){
                        //VERIFICA SE BATEU O PONTO NO DIA DA FOLGA 
                        if($diasEscala[$i]['ic_escala'] == 1){
                            $tipo_ponto_pk = 1;
                        }
                        else{
                            $tipo_ponto_pk = 5;
                        }
                        
                    }
                    else{
                        if($ic_preencher_folha == 1){
                            $tipo_ponto_pk = 1;
                            $ponto_ini_expediente = $hr_inicio_expediente;
                            $ponto_term_expediente = $hr_termino_expediente;
                            $ponto_ini_intervalo = $hr_saida_intervalo;
                            $ponto_term_intervalo = $hr_retorno_intervalo;
        
                        }
                        else{
                            if($diasEscala[$i]['ic_escala'] == 1){
                                //FALTA
                                $tipo_ponto_pk = 10;
                            }
                            else{
                                //FOLGA
                                $tipo_ponto_pk = 5;
                            }
                            
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                        }
                    } 
                /*}else{
                    $tipo_ponto_pk = 5;
                    $ponto_ini_expediente = " ";
                    $ponto_term_expediente = " ";
                    $ponto_ini_intervalo = " ";
                    $ponto_term_intervalo = " ";
                }*/
            if(count($arrApontamento[0]['arrApontamento']) > 0){
                $arrDadosApontamento = $arrApontamento[0]['arrApontamento'];
                for($a=0;$a<count($arrDadosApontamento);$a++){
                    switch($arrApontamento[0]['tipo_apontamento_pk']){
                        case 1:
                            $tipo_ponto_pk = 1;
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 1){
                                $ponto_ini_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 2){
                                $ponto_term_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 3){
                                $ponto_ini_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 4){
                                $ponto_term_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            break;
                        case 2:
                            $motivo_falta_pk = $arrApontamento[$a]['motivo_falta_pk'];
                            $tipo_ponto_pk = 10;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
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
                            break;
                        case 3:
                            $tipo_ponto_pk = 5;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            break;
                        case 5:
                            $motivo_afastamento_pk = $arrApontamento[$a]['motivo_afastamento_pk'];
                            $tipo_ponto_pk = 15;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            if($motivo_afastamento_pk == 1){
                                $obs = "Motivos Médicos";
                            }else if($motivo_afastamento_pk == 2){
                                $obs = "Invalides";
                            } 
                            break;
                        case 6:
                            $tipo_ponto_pk = 12;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            break;
                    } 
                }
            }
            
            //Função que calcula as horas trabalhadas
            $horas_trabalhadas = $this->calcularHrsTrabalhadas($ponto_ini_expediente, $ponto_term_expediente, $ponto_ini_intervalo, $ponto_term_intervalo, $hr_retorno_intervalo, $hr_saida_intervalo, $ic_intrajornada);
            //echo $horas_trabalhadas.'<br>';
            //Calcula HE e HF
            if($hr_expediente!="" && $horas_trabalhadas > "06:00"){
                if($horas_trabalhadas < $hr_expediente){
                    $queryfaltantes = $this->retornarDifHoraFaltantes($hr_expediente,$horas_trabalhadas); 
                    $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                }else if ($horas_trabalhadas > $hr_expediente){
                    $queryexcedente = $this->retornarDifHora($hr_expediente,$horas_trabalhadas); 
                    $hr_excedentes = $queryexcedente[0]['dif'];
                }else {
                    $hr_excedentes = " ";
                    $hr_faltante = " ";
                }                
            }else{
                $hr_excedentes = " ";
                $hr_faltante = " ";
            } 
            
            //array de pontos por dia
            $arrPontos[] = array(
                "tipo_ponto_pk" => $tipo_ponto_pk,
                "ponto_ini_expediente" => $ponto_ini_expediente,
                "ponto_ini_intervalo" => $ponto_ini_intervalo,
                "ponto_term_intervalo" => $ponto_term_intervalo,
                "ponto_term_expediente" => $ponto_term_expediente,
                "horas_trabalhadas" => $horas_trabalhadas,
                "hr_excedentes" => $hr_excedentes,
                "hr_faltante" => $hr_faltante,
                "obs" => $obs
            );

            //array de dias por período 
            $arrDias[] = array(
                "dt_hora_ponto" => $dt_escala." 00:00:00",
                "pontos_dia"=>$arrPontos
            );
        }
        
        return $arrDias;
    }

    
    public function listarDadosRegerar($ponto_folha_pk,$dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $hr_inicio_expediente, $hr_termino_expediente, $hr_saida_intervalo, $hr_retorno_intervalo, $hr_expediente, $ic_intrajornada, $agenda_colaborador_padrao_pk, $ic_preencher_folha){              

        $registrosFolha = $this->listarDadosRegistrosFolha($ponto_folha_pk, $colaboradores_pk ,$dt_periodo_ini,$dt_periodo_fim);
        $diasEscala = $this->listarDiasEscala($agenda_colaborador_padrao_pk,$dt_periodo_ini, $dt_periodo_fim);
        $obs = "";
        for($i=0; $i<count($diasEscala); $i++){  
            $dt_escala = $diasEscala[$i]['dt_escala'];
            $arrPontos = [];
            if($registrosFolha[$i]['ic_status'] != 1){
                $arrApontamento = $this->listarDadosApontamento($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk);
                $ponto_ini_expediente = "";
                $ponto_term_expediente = "";
                $ponto_ini_intervalo = "";
                $ponto_term_intervalo = "";
                $hr_excedentes = " ";
                $hr_faltante = " ";
                $horas_trabalhadas = " ";
                
                //if(count($arrApontamento[0]['arrApontamento']) == 0){
    
                    //if($diasEscala[$i]['ic_escala'] == 1){
            
                        //Query de verificação dos pontos
                        $sql='';
                        $sql.='Select p.pk';
                        $sql.='      ,p.tipos_ponto_pk';
                        $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%H:%i") hora_ponto'; 
                        $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%d-%m-%Y") dt_ponto'; 
                        $sql.='  from ponto p';
                        $sql.=' where p.colaborador_pk ='.$colaboradores_pk;
                        $sql.='   and p.dt_hora_ponto >="'.$dt_escala.' 00:00:00"';
                        $sql.='   and p.dt_hora_ponto <="'.$dt_escala.' 23:59:59"';
                        $sql.=" order by p.dt_hora_ponto";
                        
                        
                        $stmt = $this->pdo->prepare( $sql );
                        $stmt->execute();
                        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
                        
                        //Verificação de tipo de ponto
                        for($l=0; $l<count($query); $l++){
                            if($query[$l]['tipos_ponto_pk'] == 1){
                                $ponto_ini_expediente = $query[$l]["hora_ponto"];
                            }
                            if($query[$l]['tipos_ponto_pk'] == 2){
                                $ponto_term_expediente = $query[$l]["hora_ponto"];
                            }
                            if($query[$l]['tipos_ponto_pk'] == 3){
                                $ponto_ini_intervalo = $query[$l]["hora_ponto"];
                            }
                            if($query[$l]['tipos_ponto_pk'] == 4){
                                $ponto_term_intervalo = $query[$l]["hora_ponto"];
                            }
                        }
    
                        if($ponto_ini_expediente != '' || $ponto_term_expediente != ''){
                            //VERIFICA SE BATEU O PONTO NO DIA DA FOLGA 
                            if($diasEscala[$i]['ic_escala'] == 1){
                                $tipo_ponto_pk = 1;
                            }
                            else{
                                $tipo_ponto_pk = 5;
                            }
                            
                        }
                        else{
                            if($ic_preencher_folha == 1){
                                $tipo_ponto_pk = 1;
                                $ponto_ini_expediente = $hr_inicio_expediente;
                                $ponto_term_expediente = $hr_termino_expediente;
                                $ponto_ini_intervalo = $hr_saida_intervalo;
                                $ponto_term_intervalo = $hr_retorno_intervalo;
            
                            }
                            else{
                                if($diasEscala[$i]['ic_escala'] == 1){
                                    //FALTA
                                    $tipo_ponto_pk = 10;
                                }
                                else{
                                    //FOLGA
                                    $tipo_ponto_pk = 5;
                                }
                                
                                $ponto_ini_expediente = "";
                                $ponto_term_expediente = "";
                                $ponto_ini_intervalo = "";
                                $ponto_term_intervalo = "";
                            }
                        } 
                    /*}else{
                        $tipo_ponto_pk = 5;
                        $ponto_ini_expediente = " ";
                        $ponto_term_expediente = " ";
                        $ponto_ini_intervalo = " ";
                        $ponto_term_intervalo = " ";
                        $horas_trabalhadas = " ";
                    }*/

                    //Função que calcula as horas trabalhadas
                    $horas_trabalhadas = $this->calcularHrsTrabalhadas($ponto_ini_expediente, $ponto_term_expediente, $ponto_ini_intervalo, $ponto_term_intervalo, $hr_retorno_intervalo, $hr_saida_intervalo, $ic_intrajornada, '');
                    
                    //Calcula HE e HF
                    if($hr_expediente!="" && $horas_trabalhadas > "06:00"){
                        if($horas_trabalhadas < $hr_expediente){
                            $queryfaltantes = $this->retornarDifHoraFaltantes($hr_expediente,$horas_trabalhadas); 
                            $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                        }else if ($horas_trabalhadas > $hr_expediente){
                            $queryexcedente = $this->retornarDifHora($hr_expediente,$horas_trabalhadas); 
                            $hr_excedentes = $queryexcedente[0]['dif'];
                        }else {
                            $hr_excedentes = " ";
                            $hr_faltante = " ";
                        }                
                    }else{
                        $hr_excedentes = " ";
                        $hr_faltante = " ";
                    } 
                if(count($arrApontamento[0]['arrApontamento']) > 0){
                    $arrDadosApontamento = $arrApontamento[0]['arrApontamento'];
                    for($a=0;$a<count($arrDadosApontamento);$a++){
                        switch($arrApontamento[0]['tipo_apontamento_pk']){
                            case 1:
                                $tipo_ponto_pk = 1;
                                if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 1){
                                    $ponto_ini_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                                }
                                if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 2){
                                    $ponto_term_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                                }
                                if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 3){
                                    $ponto_ini_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                                }
                                if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 4){
                                    $ponto_term_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                                }
                                //Função que calcula as horas trabalhadas
                                $horas_trabalhadas = $this->calcularHrsTrabalhadas($ponto_ini_expediente, $ponto_term_expediente, $ponto_ini_intervalo, $ponto_term_intervalo, $hr_retorno_intervalo, $hr_saida_intervalo, $ic_intrajornada, '');
                                
                                //Calcula HE e HF
                                if($hr_expediente!="" && $horas_trabalhadas > "06:00"){
                                    if($horas_trabalhadas < $hr_expediente){
                                        $queryfaltantes = $this->retornarDifHoraFaltantes($hr_expediente,$horas_trabalhadas); 
                                        $hr_faltante = str_replace("-","",$queryfaltantes[0]['dif']);                            
                                    }else if ($horas_trabalhadas > $hr_expediente){
                                        $queryexcedente = $this->retornarDifHora($hr_expediente,$horas_trabalhadas); 
                                        $hr_excedentes = $queryexcedente[0]['dif'];
                                    }else {
                                        $hr_excedentes = " ";
                                        $hr_faltante = " ";
                                    }                
                                }else{
                                    $hr_excedentes = " ";
                                    $hr_faltante = " ";
                                } 

                                break;
                            case 2:
                                $motivo_falta_pk = $arrApontamento[$a]['motivo_falta_pk'];
                                $tipo_ponto_pk = 10;
                                $ponto_ini_expediente = " ";
                                $ponto_term_expediente = " ";
                                $ponto_ini_intervalo = " ";
                                $ponto_term_intervalo = " ";
                                $hr_excedentes = " ";
                                $hr_faltante = " ";
                                $horas_trabalhadas = " ";
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
                                break;
                            case 3:
                                $tipo_ponto_pk = 5;
                                $ponto_ini_expediente = " ";
                                $ponto_term_expediente = " ";
                                $ponto_ini_intervalo = " ";
                                $ponto_term_intervalo = " ";
                                $hr_excedentes = " ";
                                $hr_faltante = " ";
                                $horas_trabalhadas = " ";
                                break;
                            case 5:
                                $motivo_afastamento_pk = $arrApontamento[$a]['motivo_afastamento_pk'];
                                $tipo_ponto_pk = 15;
                                $ponto_ini_expediente = " ";
                                $ponto_term_expediente = " ";
                                $ponto_ini_intervalo = " ";
                                $ponto_term_intervalo = " ";
                                $hr_excedentes = " ";
                                $hr_faltante = " ";
                                $horas_trabalhadas = " ";
                                if($motivo_afastamento_pk == 1){
                                    $obs = "Motivos Médicos";
                                }else if($motivo_afastamento_pk == 2){
                                    $obs = "Invalides";
                                } 
                                break;
                            case 6:
                                $tipo_ponto_pk = 12;
                                $ponto_ini_expediente = " ";
                                $ponto_term_expediente = " ";
                                $ponto_ini_intervalo = " ";
                                $ponto_term_intervalo = " ";
                                $hr_excedentes = " ";
                                $hr_faltante = " ";
                                $horas_trabalhadas = " ";
                                break;
                        } 
                    }
                }
                
                //array de pontos por dia
                $arrPontos[] = array(
                    "tipo_ponto_pk" => $tipo_ponto_pk,
                    "ponto_ini_expediente" => $ponto_ini_expediente,
                    "ponto_ini_intervalo" => $ponto_ini_intervalo,
                    "ponto_term_intervalo" => $ponto_term_intervalo,
                    "ponto_term_expediente" => $ponto_term_expediente,
                    "horas_trabalhadas" => $horas_trabalhadas,
                    "hr_excedentes" => $hr_excedentes,
                    "hr_faltante" => $hr_faltante,
                    "obs" => $obs
                );
            }

            //array de dias por período 
            $arrDias[] = array(
                "dt_hora_ponto" => $dt_escala." 00:00:00",
                "pk" => $registrosFolha[$i]['pk'],
                "pontos_dia"=>$arrPontos
            );
        }
        
        return $arrDias;
    }

    public function retornarDifHora($hr_1,$hr_2){
        //Retorna a diferença entre dois horários 
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(TIMEDIFF('$hr_2','$hr_1'),'%H:%i')dif";
        $sql.="SELECT CASE WHEN '".$hr_2."' >= '".$hr_1."' THEN TIMEDIFF('".$hr_2."', '".$hr_1."')
                ELSE ADDTIME(TIMEDIFF('24:00:00', '".$hr_1."'), '".$hr_2."')
            END AS dif";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);  

        return $query;
    }

    public function retornarDifHoraFaltantes($hr_1,$hr_2){
        //Retorna a diferença entre dois horários 
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(TIMEDIFF('$hr_2','$hr_1'),'%H:%i')dif";
        $sql.="SELECT CASE WHEN '".$hr_2."' <= '".$hr_1."' THEN TIMEDIFF('".$hr_2."', '".$hr_1."')
                ELSE ADDTIME(TIMEDIFF('24:00:00', '".$hr_1."'), '".$hr_2."')
            END AS dif";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);   

        return $query;
    }

    public function calcularHrsTrabalhadas($hr_ini_expediente, $hr_fim_expediente, $hr_ini_intervalo, $hr_fim_intervalo, $hr_termino_intervalo, $hr_ini_intervalo_tb, $ic_intrajornada){

        //Verificar intrajornada para calcular o horário de almoço
        if($ic_intrajornada != 1){
            //Verifica se o campo está preenchido, se não tiver ele calcula com base no informado na escala do colaborador 
            if($hr_ini_intervalo!="" and $hr_fim_intervalo!=""){
                $hr_intervalo = $this->retornarDifHora($hr_ini_intervalo, $hr_fim_intervalo);
                $hr_intervalo = $hr_intervalo[0]['dif'];
            }else{
                $hr_intervalo = $this->retornarDifHora($hr_ini_intervalo_tb, $hr_termino_intervalo);
                $hr_intervalo = $hr_intervalo[0]['dif'];
            }

        }else{
            $hr_intervalo = '01:00';
        }

        /*if($turnos_pk == 3 && $hr_fim_expediente != ''){
            // Adicionar 24 horas ao fim do expediente
            $hr_ini_expediente = date('H:i', strtotime($hr_ini_expediente . ' + 12 hours'));
        }else{
            $hr_ini_expediente = $hr_ini_expediente;
        }*/

        $hr_expediente = $this->retornarDifHora($hr_ini_expediente, $hr_fim_expediente);
        $hr_expediente = $hr_expediente[0]['dif'];

        $hr_trabalhadas = $this->retornarDifHora($hr_intervalo, $hr_expediente);
        $hr_trabalhadas = $hr_trabalhadas[0]['dif'];

        return $hr_trabalhadas;
    }

    public function listarPreenchimentoAutomatico(){
        
        $ic_preencher_folha = 2;

        
       /* //Retorna se o preenchimento automatico está ativo para a conta ou não  
        if($_SESSION['session_user']['contas_pk'] != ''){
            
            $sql="";
            $sql.="SELECT ic_preencher_folha";
            $sql.="  FROM contas";
            $sql.=" WHERE pk=".$_SESSION['session_user']['contas_pk'];
            print_r($sql);
            die();

            $stmt = $this->pdo->prepare( $sql );
            $stmt->execute();
            $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            $ic_preencher_folha = $query[0]['ic_preencher_folha'];

        }*/
        return $ic_preencher_folha;
        
    }

    public function listarPontoFolhaPK($ponto_folha_pk){
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
        

        $stmt = $this->pdo->prepare( $sql.$lengthSql);
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

    public function listarFolhasRegistros($pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.=" SELECT pf.pk,";
        $sql.="    c.ds_conta,";
        $sql.="    l.ds_lead,";
        $sql.="    l.pk leads_pk,";
        $sql.="    date_format(pf.dt_periodo_ini, '%d/%m/%Y') dt_periodo_ini,";
        $sql.="    date_format(pf.dt_periodo_fim, '%d/%m/%Y') dt_periodo_fim,";
        $sql.="    pf.obs";
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.contas_pk = c.pk";
        $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
        if(!empty($pk)){
            $sql.=" WHERE pf.pk=".$pk;
        }      
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $query;

        return $retorno;
        
    }

    public function listarFolhaRegistrosAgrupadoData($ponto_folha_pk,$colaborador_pk){
        
        $sql ="";
        $sql.="SELECT pf.pk ponto_folha_pk,";
        $sql.="        pfr.pk ponto_folha_registro_pk,";
        $sql.="        pfr.colaborador_pk,";
        $sql.="        date_format(pfr.dt_hora_ponto, '%d/%m/%Y') dt_ponto,";
        $sql.="        TIME_FORMAT(pfr.hr_ini_expediente, '%H:%i') hr_ini_expediente,";
        $sql.="        TIME_FORMAT(pfr.hr_termino_expediente, '%H:%i') hr_fim_expediente,";
        $sql.="        TIME_FORMAT(pfr.hr_ini_intervalo, '%H:%i') hr_ini_intervalo,";
        $sql.="        TIME_FORMAT(pfr.hr_termino_intervalo, '%H:%i') hr_fim_intervalo,";
        $sql.="        TIME_FORMAT(pfr.hr_trabalhadas, '%H:%i') hr_trabalhadas,";
        $sql.="        TIME_FORMAT(pfr.hr_excedente, '%H:%i') hr_excedentes,";
        $sql.="        TIME_FORMAT(pfr.hr_faltantes, '%H:%i') hr_faltantes,";
        $sql.="        TIME_FORMAT(pfr.hr_extra50, '%H:%i') hr_extra50,";
        $sql.="        TIME_FORMAT(pfr.hr_extra100, '%H:%i') hr_extra100,";
        $sql.="        TIME_FORMAT(pfr.hr_adicional_noturno, '%H:%i') hr_adicional_noturno,";
        $sql.="        TIME_FORMAT(pfr.hr_saldo, '%H:%i:%s') hr_saldo,";
        $sql.="        pfr.tipos_ponto_pk tipo_ponto_pk,";  
        $sql.="        pfr.ic_status,"; 
        $sql.="         CASE 
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 1 THEN 'Dom'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 2 THEN 'Seg'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 3 THEN 'Ter'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 4 THEN 'Qua'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 5 THEN 'Qui'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 6 THEN 'Sex'
                            WHEN DAYOFWEEK(pfr.dt_hora_ponto) = 7 THEN 'Sáb'
                        END AS dia_da_semana,"; 
        $sql.="        pfr.obs"; 
        $sql.=" FROM ponto_folha pf";
        $sql.="      INNER JOIN ponto_folha_registros pfr ON pf.pk = pfr.ponto_folha_pk";
        $sql.=" WHERE pf.pk = ".$ponto_folha_pk;        
        $sql.=" AND pfr.colaborador_pk =".$colaborador_pk;
        $sql.=" group by date_format(pfr.dt_hora_ponto, '%d/%m/%Y')";
        $sql.=" ORDER BY pfr.dt_hora_ponto";
   
       
 
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query;
    }

    public function listarRegistros($pk, $leads_pk, $colaborador_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

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
        $sql.="    t.ds_turno n_qtde_dias_semana,";
        $sql.="    t.ds_turno,";
        $sql.="    a.hr_inicio_expediente,";
        $sql.="    a.hr_termino_expediente,";
        $sql.="    a.hr_inicio_intervalo,";
        $sql.="    a.hr_termino_intervalo, ";
        $sql.="    a.turnos_pk,";        
        $sql.="    pfr.hr_extra100,";        
        $sql.="    pfr.hr_extra50,";        
        $sql.="    pfr.hr_adicional_noturno,";        
        $sql.="    pfc.ponto_folha_pk, ";  
        $sql.="    pfc.colaborador_pk,";      
        $sql.="    pfc.ic_status ";  
        
        $sql.=" FROM ponto_folha pf";
        $sql.="  LEFT JOIN contas c ON pf.contas_pk = c.pk";
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
        
        
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(count($query) > 0){
            //Total Horas Trabalhadas
            $v_total_ht = $this->TotalHrTrabalhada($pk,$colaborador_pk);     
                        
            //Total Horas Excedentes
            $v_total_he = $this->TotalHrExcedentes($pk,$colaborador_pk);          
                        
            //Total Horas Excedentes
            $v_total_hf = $this->TotalHrFaltantes($pk,$colaborador_pk);      
            
            //Total Hora extra 50%
            $v_total_he50 = $this->TotalHrExtra50($pk,$colaborador_pk);  

            //Total Hora extra 100%
            $v_total_he100 = $this->TotalHrExtra100($pk,$colaborador_pk);      
            
            //Total Hora Adicional Noturno
            $v_total_hadn = $this->TotalHrAdn($pk,$colaborador_pk);       
                        
            $queryTempoExpediente  = $this->retornarDifHora($query[0]['hr_inicio_expediente'],$query[0]['hr_termino_expediente']);
            $expediente = "";
            $expediente = $queryTempoExpediente[0]['dif']; 

            $queryTempoIntervalo  = $this->retornarDifHora($query[0]['hr_inicio_intervalo'],$query[0]['hr_termino_intervalo']);
            $intervalo_diario = "";
            $intervalo_diario = $queryTempoIntervalo[0]['dif']; 

            $queryTempo  = $this->retornarDifHora($intervalo_diario,$expediente);
            $expediente_diario = "";
            $expediente_diario = $queryTempo[0]['dif']; 
            
            for($i = 0; $i < count($query); $i++){                
                $query0 = $this->listarFolhaRegistrosAgrupadoData($query[$i]['pk'],$query[$i]['colaborador_pk']);
                
                for($j = 0; $j < count($query0); $j++){ 
                    $DadosFolhaRegistros[] = "";

                    $dt_registro_ponto = $query0[$j]['dt_ponto'];
                    $hr_ini_expediente= $query0[$j]['hr_ini_expediente'];
                    $hr_ini_intervalo = $query0[$j]['hr_ini_intervalo'];
                    $hr_fim_intervalo = $query0[$j]['hr_fim_intervalo'];
                    $hr_fim_expediente = $query0[$j]['hr_fim_expediente'];
                    if($query0[$j]['tipo_ponto_pk']==1){
                        if($query[$i]['turnos_pk'] == 3 && isset($query0[$j+1])) {
                            $hr_ini_expediente= $query0[$j]['hr_ini_expediente'];
                            $hr_ini_intervalo = $query0[$j+1]['hr_ini_intervalo'];
                            $hr_fim_intervalo = $query0[$j+1]['hr_fim_intervalo'];
                            $hr_fim_expediente = $query0[$j+1]['hr_fim_expediente'];
                            
                        }
                    }

                    $DadosFolhaRegistros[$j] = array(
                        "ponto_folha_pk"=>$query0[$j]['ponto_folha_pk'],
                        "ponto_folha_registro_pk"=>$query0[$j]['ponto_folha_registro_pk'],
                        "colaborador_pk"=>$query0[$j]['colaborador_pk'],
                        "dt_registro_ponto"=>$query0[$j]['dt_ponto'],
                        "tipo_ponto_pk"=>$query0[$j]['tipo_ponto_pk'],
                        "hr_ini_expediente"=>$hr_ini_expediente,
                        "hr_ini_intervalo"=>$hr_ini_intervalo,
                        "hr_fim_intervalo"=>$hr_fim_intervalo,
                        "hr_fim_expediente"=>$hr_fim_expediente,
                        "hr_trabalhadas"=>$query0[$j]['hr_trabalhadas'],
                        "hr_excedentes"=>$query0[$j]['hr_excedentes'],
                        "hr_faltantes"=>$query0[$j]['hr_faltantes'],
                        "ic_status"=>$query0[$j]['ic_status'],
                        "hr_extra50"=>$query0[$j]['hr_extra50'],
                        "hr_extra100"=>$query0[$j]['hr_extra100'],
                        "hr_adicional_noturno"=>$query0[$j]['hr_adicional_noturno'],  
                        "dia_da_semana"=>$query0[$j]['dia_da_semana'], 
                        "obs"=>$query0[$j]['obs']
                    );

                }

                $result[] = array(
                    "pk" => $query[$i]["pk"],
                    "ds_periodo"=>$query[$i]['dt_periodo_ini']." a ".$query[$i]['dt_periodo_fim'],                    
                    "ds_empresa"=>$query[$i]['ds_empresa'],
                    "ds_endereco"=>$query[$i]['ds_endereco']." ,".$query[$i]['ds_numero'],
                    "ds_cnpj"=>$query[$i]['ds_cnpj_conta'],
                    "ds_colaborador"=>$query[$i]['ds_colaborador'],
                    "dt_admissao"=>"",  
                    "ds_cpf"=>$query[$i]['ds_cpf'],
                    "ds_cargo"=>$query[$i]['ds_cargo'],
                    "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                    "ds_escala"=>$query[$i]['n_qtde_dias_semana'],
                    "ds_turno"=>$query[$i]['ds_turno'],
                    "ic_folha_finalizada"=>$query[$i]['ic_status'],
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


        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $result;

        return $retorno;
        
    }

    public function TotalHrTrabalhada($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_trabalhadas), '%H:%i') total_hr_trabalhadas";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_trabalhadas))), '%H:%i') total_hr_trabalhadas";
        $sql.="  FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.="   AND colaborador_pk =".$colaborador_pk;
      
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_trabalhadas'];
    }

    public function TotalHrExcedentes($pk,$colaborador_pk){
        $sql ="";
       // $sql.="SELECT TIME_FORMAT(sum(hr_excedente), '%H:%i') total_hr_excedente";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_excedente))), '%H:%i') total_hr_excedente";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_excedente'];
    }

    
    public function TotalHrFaltantes($pk,$colaborador_pk){
        $sql ="";
       // $sql.="SELECT TIME_FORMAT(sum(hr_faltantes), '%H:%i') total_hr_faltantes";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_faltantes))), '%H:%i') total_hr_faltantes";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_faltantes'];
    }   
    
    public function TotalHrExtra50($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_extra50), '%H:%i') total_hr_extra50";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_extra50))), '%H:%i') total_hr_extra50";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_extra50'];
    } 
    
    public function TotalHrExtra100($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_extra100), '%H:%i') total_hr_extra100";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_extra100))), '%H:%i') total_hr_extra100";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_extra100'];
    } 
    
    public function TotalHrAdn($pk,$colaborador_pk){
        $sql ="";
        //$sql.="SELECT TIME_FORMAT(sum(hr_adicional_noturno), '%H:%i') total_hr_adicional_noturno";
        $sql.="SELECT TIME_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(hr_adicional_noturno))), '%H:%i') total_hr_adicional_noturno";
        $sql.=" FROM ponto_folha_registros";
        $sql.=" WHERE ponto_folha_pk = ".$pk;
        $sql.=" AND colaborador_pk =".$colaborador_pk;
        
        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $query[0]['total_hr_adicional_noturno'];
    } 

    public function listarDadosImpressao($leads_pk, $colaborador_pk, $ponto_folha_pk){
        try{
            $retorno = new \StdClass; //Estrutura de retorno para controller
            $retorno->status = false; //Retorno setado status como false
            $retorno->data = []; //Retorno data setado como vazio

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
            $sql.="       te.ds_tipo_escala n_qtde_dias_semana,";
            $sql.="        t.ds_turno,";
            $sql.="        a.hr_inicio_expediente,";
            $sql.="        a.hr_termino_expediente,";
            $sql.="        a.hr_inicio_intervalo,";
            $sql.="        a.hr_termino_intervalo, ";
            $sql.="        a.turnos_pk,";        
            $sql.="        pfc.ponto_folha_pk, ";  
            //$sql.="    date_format(col.dt_admissao, '%d/%m/%Y') dt_admissao,";  
            $sql.="        pfc.colaborador_pk ";    
            $sql.="   FROM ponto_folha pf";
            $sql.="  LEFT  JOIN contas c ON pf.contas_pk = c.pk";
            $sql.="  INNER JOIN leads l ON pf.leads_pk = l.pk";
            $sql.="  INNER JOIN ponto_folha_colaborador pfc ON pf.pk = pfc.ponto_folha_pk";  
            $sql.="  INNER JOIN agenda_colaborador_padrao a ON pfc.colaborador_pk = a.colaboradores_pk";
            $sql.="  LEFT  JOIN turnos t ON a.turnos_pk = t.pk";
            $sql.="  INNER JOIN tipos_escalas te ON a.tipos_escalas_pk = te.pk";
            $sql.="  INNER JOIN colaboradores col ON pfc.colaborador_pk = col.pk";
            $sql.="  INNER JOIN colaboradores_produtos_servicos cps  ON col.pk = cps.colaboradores_pk";
            $sql.="  INNER JOIN produtos_servicos ps ON cps.produtos_servicos_pk = ps.pk";
            $sql.=" WHERE pfc.ponto_folha_pk=".$ponto_folha_pk;
            
            if(!empty($leads_pk)){
                $sql.=" AND pf.leads_pk=".$leads_pk;
                $sql.=" AND a.leads_pk =".$leads_pk;
                
            }

            if($colaborador_pk != 'null'){
                $sql.=" AND pfc.colaborador_pk=".$colaborador_pk;
            }
            

            $sql.=" AND a.dt_cancelamento is null";

        
        
            $stmt = $this->pdo->prepare( $sql );
            $stmt->execute();
            $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            if(count($query) > 0){

                for($i = 0; $i < count($query); $i++){ 
                    $DadosFolhaRegistros = "";
                    $colaborador_pk = $query[$i]['colaborador_pk'];
                    
                    //Total Horas Trabalhadas
                    $queryHrTrabalhadas = $this->TotalHrTrabalhada($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_ht = "";
                    $v_total_ht = $queryHrTrabalhadas;
                           
                    //Total Horas Excedentes
                    $queryHrExcedentes = $this->TotalHrExcedentes($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_he = "";
                    $v_total_he = $queryHrExcedentes;
                                
                    //Total Horas Excedentes
                    $queryHrFaltantes = $this->TotalHrFaltantes($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_hf = "";
                    $v_total_hf = $queryHrFaltantes;
                    
                    //Total Hora extra 50%
                    $queryHrExtra50 = $this->TotalHrExtra50($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_he50 = "";
                    $v_total_he50 = $queryHrExtra50;

                    //Total Hora extra 100%
                    $queryHrExtra100 = $this->TotalHrExtra100($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_he100 = "";
                    $v_total_he100 = $queryHrExtra100;  
                    
                    //Total Hora Adicional Noturno
                    $queryHrAdn = $this->TotalHrAdn($ponto_folha_pk,$colaborador_pk);                       
                    $v_total_hadn = "";
                    $v_total_hadn = $queryHrExtra100;  
                           
                    $queryTempoExpediente  = $this->retornarDifHora($query[$i]['hr_inicio_expediente'],$query[$i]['hr_termino_expediente']);
                    $expediente_diario = "";
                    $expediente_diario = $queryTempoExpediente[$i]['dif']; 

                    $query0 = $this->listarFolhaRegistrosAgrupadoData($query[$i]['ponto_folha_pk'],$query[$i]['colaborador_pk']);

                    $result[] = array(
                        "pk" => $query[$i]["pk"],
                        "ds_periodo"=>$query[$i]['dt_periodo_ini']." a ".$query[$i]['dt_periodo_fim'],                    
                        "ds_empresa"=>$query[$i]['ds_empresa'],
                        "ds_endereco"=>$query[$i]['ds_endereco']." ,".$query[$i]['ds_numero'],
                        "ds_cnpj"=>$query[$i]['ds_cnpj_conta'],
                        "ds_colaborador"=>$query[$i]['ds_colaborador'],
                        "dt_admissao"=>"",
                        "ds_cpf"=>$query[$i]['ds_cpf'],
                        "ds_cargo"=>$query[$i]['ds_cargo'],
                        "ds_posto_trabalho"=>$query[$i]['ds_posto_trabalho'],
                        "ds_escala"=>$query[$i]['n_qtde_dias_semana'],
                        "ds_turno"=>$query[$i]['ds_turno'],
                        "ds_hr_expediente"=>$query[$i]['hr_inicio_expediente']." a ".$query[$i]['hr_termino_expediente'],
                        "registrosfolha"=>$query0,
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

            $retorno->data = $result;
            $retorno->status = true;
            $retorno->message = 'Dados Salvos com sucesso !';
            return $retorno;
        }
        catch(Throwable $th){
            print_r($th->getMessage());
            die();
        }
        
    } 


    public function listarConsultaPontoColaborador($leads_pk, $colaboradores_pk, $dt_periodo_ini,$dt_periodo_fim,$agenda_colaborador_padrao_pk){              

        $dadosEscala = $this->listarDadosEscala($dt_periodo_ini, $dt_periodo_fim, $colaboradores_pk, $agenda_colaborador_padrao_pk);
        $hr_saida_intervalo = $dadosEscala[0]["hr_saida_intervalo"];
        $hr_inicio_expediente = $dadosEscala[0]["hr_inicio_expediente"];
        $hr_termino_expediente = $dadosEscala[0]["hr_termino_expediente"];
        $hr_retorno_intervalo = $dadosEscala[0]["hr_retorno_intervalo"];
        $ic_intrajornada = $dadosEscala[0]["ic_intrajornada"];
        $hr_expediente = $dadosEscala[0]["hr_expediente"];
        $turnos_pk = $dadosEscala[0]["turnos_pk"];
        $arrPontos = [];
        $arrDias = [];

        $situacao = "";

        $diasEscala = $this->listarDiasEscala($agenda_colaborador_padrao_pk,$dt_periodo_ini, $dt_periodo_fim);
        
        for($i=0; $i<count($diasEscala); $i++){  
            $dt_escala = $diasEscala[$i]['dt_escala'];
            $dt_format = $diasEscala[$i]['dt_format'];
            $dia_da_semana = $diasEscala[$i]['dia_da_semana'];
            $arrApontamento = $this->listarDadosApontamento($dt_escala, $colaboradores_pk, $agenda_colaborador_padrao_pk);
            $ponto_ini_expediente = "";
            $ic_preencher_folha = 1;
            $ponto_term_expediente = "";
            $ponto_ini_intervalo = "";
            $ponto_term_intervalo = "";


            $ic_apontamento_ini = "";
      
            $ic_apontamento_ter = "";
       
            $ic_apontamento_ini_int = "";
         
            $ic_apontamento_fim_int = "";
            $hr_excedentes = " ";
            $hr_faltante = " ";
            $horas_trabalhadas = " ";
            $obs = " ";
            $ic_apontamento = 0;
            $situacao = "";
            $arrPontos = [];

            
            $diaAtual = date('Y-m-d');

            /*echo $diaAtual.'-';
            echo $dt_escala.'<br>';*/

            
                
                //Query de verificação dos pontos
                $sql='';
                $sql.='Select p.pk';
                $sql.='      ,p.tipos_ponto_pk';
                $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%H:%i") hora_ponto'; 
                $sql.='      ,DATE_FORMAT(p.dt_hora_ponto, "%d-%m-%Y") dt_ponto'; 
                $sql.='  from ponto p';
                $sql.=' where p.colaborador_pk ='.$colaboradores_pk;
                $sql.='   and p.dt_hora_ponto >="'.$dt_escala.' 00:00:00"';
                $sql.='   and p.dt_hora_ponto <="'.$dt_escala.' 23:59:59"';
               
                $sql.=" order by p.dt_hora_ponto";
                
                
          
                $stmt = $this->pdo->prepare( $sql );
                $stmt->execute();
                $query = $stmt->fetchAll(\PDO::FETCH_ASSOC); 
                
                //Verificação de tipo de ponto
                for($l=0; $l<count($query); $l++){
                    if($query[$l]['tipos_ponto_pk'] == 1){
                        $ponto_ini_expediente = $query[$l]["hora_ponto"];
                    }
                    if($query[$l]['tipos_ponto_pk'] == 2){
                        $ponto_term_expediente = $query[$l]["hora_ponto"];
                    }
                    if($query[$l]['tipos_ponto_pk'] == 3){
                        $ponto_ini_intervalo = $query[$l]["hora_ponto"];
                    }
                    if($query[$l]['tipos_ponto_pk'] == 4){
                        $ponto_term_intervalo = $query[$l]["hora_ponto"];
                    }
                }
                if($ponto_ini_expediente != '' || $ponto_term_expediente != ''){
                    //VERIFICA SE BATEU O PONTO NO DIA DA FOLGA 
                    if($diasEscala[$i]['ic_escala'] == 1){
                        $situacao = "Escala";
                        $tipo_ponto_pk = 1;
                    }
                    else{
                        $situacao = "Folga";
                        $tipo_ponto_pk = 5;
                    }
                    
                }
                else{
                    
                    if($diasEscala[$i]['ic_escala'] == 1){
                        //FALTA
                        $tipo_ponto_pk = 10;
                        $situacao = "Falta";
                    }
                    else{
                        //FOLGA
                        $tipo_ponto_pk = 5;
                        $situacao = "Folga";
                    }
                    
                    $ponto_ini_expediente = "";
                    $ponto_term_expediente = "";
                    $ponto_ini_intervalo = "";
                    $ponto_term_intervalo = "";
                }
               
            

            if(count($arrApontamento[0]['arrApontamento']) > 0){
                $arrDadosApontamento = $arrApontamento[0]['arrApontamento'];
                for($a=0;$a<count($arrDadosApontamento);$a++){
                    switch($arrApontamento[0]['tipo_apontamento_pk']){
                        case 1:
                            $tipo_ponto_pk = 1;
                            $ic_apontamento = 1;
                            $situacao = "Escala";
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 1){
                                $ic_apontamento_ini = 1;
                                $ponto_ini_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 2){
                            
                                $ic_apontamento_ter = 2;
                                $ponto_term_expediente = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 3){
                           
                                $ic_apontamento_ini_int = 3;
                                $ponto_ini_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            if($arrDadosApontamento[$a]['tipo_ponto_pk'] == 4){
                               
                                $ic_apontamento_fim_int = 4;
                                $ponto_term_intervalo = $arrDadosApontamento[$a]["hr_ponto"];
                            }
                            break;
                        case 2:
                            $ic_apontamento = 1;
                            $motivo_falta_pk = $arrDadosApontamento[$a]['motivo_falta_pk'];
                            $tipo_ponto_pk = 2;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            
                            break;
                        case 3:
                            $ic_apontamento = 1;
                            $motivo_folga_pk = $arrDadosApontamento[$a]['motivo_folga_pk'];
                            $tipo_ponto_pk = 3;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            if($motivo_folga_pk == '1'){
                                $situacao = "Folga Trabalhada";
                            }else if($motivo_folga_pk == '2'){
                                $situacao = "Escala Errada";
                            }else if($motivo_folga_pk == '3'){
                                $situacao = "Convocação Normal";
                            }else if($motivo_folga_pk == '4'){
                                $situacao = "Folga Semanal";
                            }else if($motivo_folga_pk == '5'){
                                $situacao = "Folga Domingo";
                            }
                            break;
                        case 5:
                            $ic_apontamento = 1;
                            $motivo_afastamento_pk = $arrDadosApontamento[$a]['motivo_afastamento_pk'];
                            $tipo_ponto_pk = 5;
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            if($motivo_afastamento_pk == 1){
                                $situacao = "Motivos Médicos";
                            }else if($motivo_afastamento_pk == 2){
                                $situacao = "Invalides";
                            } 
                            break;
                        case 6:
                            $ic_apontamento = 1;
                            $tipo_ponto_pk = 6;
                            $situacao = "";
                            $ponto_ini_expediente = "";
                            $ponto_term_expediente = "";
                            $ponto_ini_intervalo = "";
                            $ponto_term_intervalo = "";
                            break;
                    } 
                }
            }
            

            //array de pontos por dia
            $arrPontos[] = array(
                "ponto_ini_expediente" => $ponto_ini_expediente,
                "ponto_ini_intervalo" => $ponto_ini_intervalo,
                "ponto_term_intervalo" => $ponto_term_intervalo,
                "ponto_term_expediente" => $ponto_term_expediente,
                "ic_apontamento_ini" => $ic_apontamento_ini,
      
                "ic_apontamento_ter" =>$ic_apontamento_ter ,
        
                "ic_apontamento_ini_int" =>$ic_apontamento_ini_int,
            
                "ic_apontamento_fim_int" => $ic_apontamento_fim_int,
                "situacao" => $situacao,
                "ic_apontamento" => $ic_apontamento,
                "tipo_ponto_pk" => $tipo_ponto_pk
            );

            //array de dias por período 
            $arrDias[] = array(
                "dt_hora_ponto" => $dt_format,
                "dia_da_semana" => $dia_da_semana,
                "pontos_dia"=>$arrPontos
            );
        }
        
        return $arrDias;
    }
}
