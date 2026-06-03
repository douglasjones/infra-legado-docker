<?php

namespace App\Model;

use App\Utils\Util;
use GuzzleHttp\Client;
use Throwable;

class AgendaColaboradorApontamento {

    public $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function desabilitarApontamento($apontamento_pk){;

        $fields = array();
        $fields['ic_status'] = 2;
        Util::execUpdate("agenda_colaborador_apontamento", $fields, " pk = ".$apontamento_pk,$this->pdo);
            
        
    }
    public function excluir($pk,$tipo_apontamento_pk, $apontamento_ponto_pk){;

        Util::execDelete('agenda_colaborador_apontamento', ' pk='.$pk, $this->pdo);
        switch($tipo_apontamento_pk){
            case '1':
                Util::execDelete('apontamento_ponto', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                Util::execDelete('ponto', ' apontamento_ponto_pk='.$apontamento_ponto_pk, $this->pdo);
                break;
            case '2':
                Util::execDelete('apontamento_falta', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                Util::execDelete('apontamento_folga', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                break;
            case '3':
                Util::execDelete('apontamento_folga', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                break;
            case '4':
                Util::execDelete('apontamento_troca_escala', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                break;
            case '5':
                Util::execDelete('apontamento_afastamento', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                break;
            case '6':
                Util::execDelete('apontamento_ferias', ' agenda_colaborador_apontamento_pk='.$pk, $this->pdo);
                break;
        }
    }
    public function salvar($agenda_colaborador_apontamento){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['leads_pk'] = $agenda_colaborador_apontamento['leads_pk'];
        $fields['tipo_apontamento_pk'] = $agenda_colaborador_apontamento['tipo_apontamento_pk'];
        $fields['colaborador_pk'] = $agenda_colaborador_apontamento['colaborador_pk'];
        $fields['agenda_colaborador_padrao_pk'] = $agenda_colaborador_apontamento['agenda_colaborador_padrao_pk'];
        $fields['dt_apontamento'] = $agenda_colaborador_apontamento['dt_apontamento'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
        $fields["ic_status"] = 1;

        if($agenda_colaborador_apontamento['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];


            $pk = Util::execInsert("agenda_colaborador_apontamento", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("agenda_colaborador_apontamento", $fields, " pk = ".$agenda_colaborador_apontamento['pk'],$this->pdo);
            $pk = $agenda_colaborador_apontamento['pk'];
            $retorno->status = true;
            $retorno->message = 'Dados atualizado com sucesso';
            $retorno->data = $pk;
        }
        return $retorno;

    }
    public function salvarPonto($apontamento_ponto){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_ponto['agenda_colaborador_apontamento_pk'];
        $fields['tipo_ponto_pk'] = $apontamento_ponto['tipo_ponto_pk'];
        $fields['hr_ponto'] = $apontamento_ponto['hr_ponto'];
        $fields['ds_obs_ponto'] = $apontamento_ponto['ds_obs_ponto'];
        $fields['dt_ponto'] = $apontamento_ponto['dt_ponto'];

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_ponto['pk'] == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;

            $fields_ponto = array();
            $fields_ponto['colaborador_pk'] = $apontamento_ponto['colaborador_pk'];

            $fields_ponto['tipos_ponto_pk'] = $apontamento_ponto['tipo_ponto_pk'];


            $sql = "";
            $sql.="select DATE_FORMAT(sysdate(), '%H:%i:%s') time";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $time = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            if($apontamento_ponto['hr_ponto'] == "sysdate()"){
                $fields_ponto['dt_hora_ponto'] = $apontamento_ponto['dt_ponto']." ".$time[0]['time'];
            }else{
                $fields_ponto['dt_hora_ponto'] = $apontamento_ponto['dt_ponto']." ".$apontamento_ponto['hr_ponto'];
            }
            $fields_ponto['apontamento_ponto_pk'] = $pk;
            $fields_ponto['contas_pk'] = $_SESSION['session_user']['contas_pk'];

            $fields_ponto["dt_ult_atualizacao"] = "sysdate()";
            $fields_ponto["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

            $fields_ponto["dt_cadastro"] = "sysdate()";
            $fields_ponto["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];
            $ponto_pk = Util::execInsert("ponto", $fields_ponto,$this->pdo);

        }
        else{
            Util::execUpdate("apontamento_ponto", $fields, " pk = ".$apontamento_ponto['pk'],$this->pdo);
            $pk = $apontamento_ponto['pk'];
        }
        return $retorno;

    }

    public function salvarValidadoReloginho($dados){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $this->atualizarStatusFolhaReloginho(
            $dados['leads_pk'],
            $dados['colaborador_pk'],
            $dados['dt_hora_ponto'],
            $dados['ic_verificado']
        );

        $pk = null;
        if($this->tabelaExiste('validar_reloginho')){
            $fields = array();
            $fields['leads_pk'] = $dados['leads_pk'];
            $fields['colaborador_pk'] = $dados['colaborador_pk'];
            $fields['ic_verificado'] = $dados['ic_verificado'];
            $fields['dt_hora_ponto'] = Util::DataYMD($dados['dt_hora_ponto']);

            $fields["dt_ult_atualizacao"] = "sysdate()";
            $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("validar_reloginho", $fields,$this->pdo);
        }

        $retorno->status = true;
        $retorno->message = 'Dados cadastrados com sucesso';
        $retorno->data = $pk;

        return $retorno;

    }

    public function tabelaExiste($nomeTabela){
        $sql = "";
        $sql.= "SELECT 1";
        $sql.= "  FROM information_schema.tables";
        $sql.= " WHERE table_schema = DATABASE()";
        $sql.= "   AND table_name = '".$nomeTabela."'";
        $sql.= " LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $query = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return count($query) > 0;
    }

    public function atualizarStatusFolhaReloginho($leads_pk, $colaborador_pk, $dt_hora_ponto, $ic_verificado){
        $usuarioSessaoPk = isset($_SESSION['session_user']['par1']) ? (int)$_SESSION['session_user']['par1'] : 0;
        $sql = "";
        $sql.= "UPDATE ponto_folha_registros pfr";
        $sql.= " INNER JOIN ponto_folha pf ON pf.pk = pfr.ponto_folha_pk";
        $sql.= "   SET pfr.ic_status = ".((int)$ic_verificado === 1 ? 1 : 0).",";
        $sql.= "       pfr.dt_ult_atualizacao = sysdate(),";
        $sql.= "       pfr.usuario_ult_atualizacao_pk = ".$usuarioSessaoPk;
        $sql.= " WHERE pf.leads_pk = ".(int)$leads_pk;
        $sql.= "   AND pfr.colaborador_pk = ".(int)$colaborador_pk;
        $sql.= "   AND DATE(pfr.dt_hora_ponto) = '".Util::DataYMD($dt_hora_ponto)."'";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function salvarApontamentoReloginho($apontamento){
        try{
            $retorno = new \StdClass; //Estrutura de retorno para controller
            $retorno->status = false; //Retorno setado status como false
            $retorno->data = []; //Retorno data setado como vazio


            switch ($apontamento['tipo_apontamento_pk']) {
                //PONTO
                case 1:
                    if($apontamento['hr_ini_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 1;
                        $fields['hr_ponto'] = $apontamento['hr_ini_expediente'].":00";
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);

                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_ini_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 3;
                        $fields['hr_ponto'] = $apontamento['hr_ini_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 4;
                        $fields['hr_ponto'] = $apontamento['hr_fim_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 2;
                        $fields['hr_ponto'] = $apontamento['hr_fim_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                break;
                //PONTO
                case 33:
                    if($apontamento['hr_ini_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 1;
                        $fields['hr_ponto'] = $apontamento['hr_ini_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_ini_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 3;
                        $fields['hr_ponto'] = $apontamento['hr_ini_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 4;
                        $fields['hr_ponto'] = $apontamento['hr_fim_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 2;
                        $fields['hr_ponto'] = $apontamento['hr_fim_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                break;
                //PONTO
                case 36:
                    if($apontamento['hr_ini_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 1;
                        $fields['hr_ponto'] = $apontamento['hr_ini_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_ini_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 3;
                        $fields['hr_ponto'] = $apontamento['hr_ini_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 4;
                        $fields['hr_ponto'] = $apontamento['hr_fim_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 2;
                        $fields['hr_ponto'] = $apontamento['hr_fim_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                break;
                //PONTO
                case 37:
                    if($apontamento['hr_ini_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 1;
                        $fields['hr_ponto'] = $apontamento['hr_ini_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_ini_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 3;
                        $fields['hr_ponto'] = $apontamento['hr_ini_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_intervalo']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 4;
                        $fields['hr_ponto'] = $apontamento['hr_fim_intervalo'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                    if($apontamento['hr_fim_expediente']!=""){
                        $fields = array();
                        $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                        $fields['tipo_ponto_pk'] = 2;
                        $fields['hr_ponto'] = $apontamento['hr_fim_expediente'].":00";
                        $fields['dt_ponto'] = Util::DataYMD($apontamento['dt_apontamento']);
                        $fields['hr_trabalhadas'] = $apontamento['hr_trabalhadas'];
                        $fields['hr_excedentes'] = $apontamento['hr_excedentes'];
                        $fields['hr_faltantes'] = $apontamento['hr_faltantes'];
                        $fields["dt_ult_atualizacao"] = "sysdate()";
                        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    
                        $fields["dt_cadastro"] = "sysdate()";
                        $fields["usuario_cadastro_pk"] = $_SESSION['session_user']['par1'];

                        $pk = Util::execInsert("apontamento_ponto", $fields,$this->pdo);
                        $retorno->status = true;
                        $retorno->message = 'Dados cadastrados com sucesso';
                        $retorno->data = $pk;
                    }
                break;
                //FALTA
                case 2:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FOLGA
                case 3:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //AFASTAMENTO
                case 5:
                    $fields = array();
                    $fields['motivo_afastamento_pk'] = $apontamento['motivo_afastamento_pk'];

                    $fields['dt_ini_afastamento'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_afastamento'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];


                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_afastamento", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;                
                //FÉRIAS
                case 6:
                    $fields = array();
                    $fields['dt_ini_ferias'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_ferias'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_ferias", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;                              
                //DISCIPLINA
                case 8:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FALTA
                case 11:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 16:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //DISCIPLINA
                case 17:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FALTA
                case 18:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //DISCIPLINA
                case 19:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FOLGA
                case 20:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FOLGA
                case 21:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['feriado_pk'] = $apontamento['feriado_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //DISCIPLINA
                case 22:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //DISCIPLINA
                case 23:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //DISCIPLINA
                case 24:
                    $fields = array();
                    $fields['tipo_disciplina_pk'] = 1;
                    $fields['dt_disciplina'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['colaborador_pk'] = Util::DataYMD($apontamento['colaborador_pk']);
                    $fields['agenda_colaborador_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['leads_pk'] = $apontamento['leads_pk'];
                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                    $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FOLGA
                case 25:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FOLGA
                case 26:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FOLGA
                case 27:
                    $fields = array();
                    $fields['motivo_folga_pk'] = 1;
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    
                    $fields['dt_folga'] = Util::DataYMD($apontamento['dt_apontamento']);
                

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                    
                break;
                //FALTA
                case 28:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 29:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 30:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 31:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 32:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                
                //FALTA
                case 34:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                //FALTA
                case 35:
                    $fields = array();
                    $fields['agenda_colaborador_apontamento_pk'] = $apontamento['agenda_colaborador_padrao_pk'];
                    $fields['motivo_falta_pk'] = $apontamento['motivo_falta_pk'];
                    $fields['dt_falta'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_inicio_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['dt_fim_atestado'] = Util::DataYMD($apontamento['dt_apontamento']);
                    $fields['lead_pk'] = $apontamento['leads_pk'];

                    $fields["dt_ult_atualizacao"] = "sysdate()";
                    $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

                    $fields["dt_cadastro"] = "sysdate()";
                    $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

                    $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
                    $retorno->status = true;
                    $retorno->message = 'Dados cadastrados com sucesso';
                    $retorno->data = $pk;
                break;
                
            }
            return $retorno;
        }
        catch(Throwable $th){
            print_r($th->getMessage());
            die();
        }
        

    }
    public function salvarFalta($apontamento_falta){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fieldsFolga = array();

        $fields['ds_obs_falta'] = $apontamento_falta['ds_obs_falta'];
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_falta['agenda_colaborador_apontamento_pk'];
        $fields['colaborador_cobertura_falta_pk'] = $apontamento_falta['colaborador_cobertura_falta_pk'];
        $fields['motivo_falta_pk'] = $apontamento_falta['motivo_falta_pk'];
        $fields['dt_falta'] = $apontamento_falta['dt_falta'];
        $fields['motivo_cobertura_pk'] = $apontamento_falta['motivo_cobertura_pk'];
        $fields['lead_pk'] = $apontamento_falta['lead_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_falta['pk']  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;

            if($apontamento_falta['colaborador_cobertura_falta_pk'] != "" && $apontamento_falta['motivo_cobertura_pk'] == "1"){
                $fieldsFolga["dt_ult_atualizacao"] = "sysdate()";
                $fieldsFolga["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];
                $fieldsFolga["dt_cadastro"] = "sysdate()";
                $fieldsFolga["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];
                $fieldsFolga['apontamento_falta_pk'] = $pk;
                $fieldsFolga['lead_cobertura_pk'] = $apontamento_falta['lead_cobertura_pk'];
                $fieldsFolga['agenda_colaborador_apontamento_pk'] = $apontamento_falta['agenda_colaborador_apontamento_pk'];
                $fieldsFolga['dt_folga'] = $apontamento_falta['dt_falta'];
                $fieldsFolga['motivo_ft_pk'] = $apontamento_falta['motivo_cobertura_pk'];
                $fieldsFolga['motivo_folga_pk'] = 1;

                $valor = str_replace (".", "", $apontamento_falta['vl_ft_falta']);
                $valor = str_replace (",", ".", $valor);
                $fieldsFolga['vl_ft'] = $valor;
                Util::execInsert("apontamento_folga", $fieldsFolga,$this->pdo);
            }
        }
        else{
            Util::execUpdate("apontamento_falta", $fields, " pk = ".$apontamento_falta['pk'],$this->pdo);
        }
        return $retorno;

    }
    public function salvarAbono($dados){
        //É PARA SER SALVO EM FALTA MESMO
        //É PARA SER SALVO EM FALTA MESMO
        //É PARA SER SALVO EM FALTA MESMO
        //É PARA SER SALVO EM FALTA MESMO




        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['agenda_colaborador_apontamento_pk'] = $dados['agenda_colaborador_apontamento_pk'];
        $fields['motivo_falta_pk'] = 1;
        $fields['dt_falta'] = $dados['dt_falta'];
        $fields['dt_inicio_atestado'] = $dados['dt_falta'];
        $fields['dt_fim_atestado'] = $dados['dt_falta'];
        $fields['lead_pk'] = $dados['lead_pk'];
        $fields['hr_ini_abono'] = $dados['hr_ini_abono'];
        $fields['hr_ini_intervalo_abono'] = $dados['hr_ini_intervalo_abono'];
        $fields['hr_termino_intervalo_abono'] = $dados['hr_termino_intervalo_abono'];
        $fields['hr_termino_abono'] = $dados['hr_termino_abono'];

        

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($dados['pk']  == ""){
            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_falta", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_falta", $fields, " pk = ".$dados['pk'],$this->pdo);
        }
        return $retorno;

    }
    public function salvarFolga($apontamento_folga){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['motivo_folga_pk'] = $apontamento_folga['motivo_folga_pk'];
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_folga['agenda_colaborador_apontamento_pk'];
        $fields['motivo_ft_pk'] = $apontamento_folga['motivo_ft_pk'];
        $fields['ds_obs_folga'] = $apontamento_folga['ds_obs_folga'];
        $fields['dt_folga'] = $apontamento_folga['dt_folga'];
        $fields['lead_cobertura_pk'] = $apontamento_folga['lead_cobertura_pk'];

        $valor = str_replace (".", "", $apontamento_folga['vl_ft']);
        $valor = str_replace (",", ".", $valor);

        $fields['vl_ft'] = $valor;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_folga['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_folga", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_folga", $fields, " pk = ".$apontamento_folga['pk'],$this->pdo);
        }
        return $retorno;
    }
    public function salvarTrocaEscala($apontamento_troca_escala){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['ds_obs_troca_escala'] = $apontamento_troca_escala['ds_obs_troca_escala'];
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_troca_escala['agenda_colaborador_apontamento_pk'];
        $fields['dt_troca_escala'] = $apontamento_troca_escala['dt_troca_escala'];
        $fields['motivos_troca_escala_pk'] = $apontamento_troca_escala['motivos_troca_escala_pk'];
        $fields['colaborador_cobertura_troca_escala_pk'] = $apontamento_troca_escala['colaborador_cobertura_troca_escala_pk'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_troca_escala['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_troca_escala", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_troca_escala", $fields, " pk = ".$apontamento_troca_escala['pk'],$this->pdo);
        }
        return $retorno;
    }
    public function salvarAfastamento($apontamento_afastamento){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['motivo_afastamento_pk'] = $apontamento_afastamento['motivo_afastamento_pk'];

        $fields['dt_ini_afastamento'] = $apontamento_afastamento['dt_ini_afastamento'];
        $fields['dt_fim_afastamento'] = $apontamento_afastamento['dt_fim_afastamento'];
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_afastamento['agenda_colaborador_apontamento_pk'];
        $fields['colaborador_cobertura_afastamento_pk'] = $apontamento_afastamento['colaborador_cobertura_afastamento_pk'];
        $fields['ds_obs_afastamento'] = $apontamento_afastamento['ds_obs_afastamento'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_afastamento['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_afastamento", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_afastamento", $fields, " pk = ".$apontamento_afastamento['pk'],$this->pdo);
        }
        return $retorno;
    }
    public function salvarFerias($apontamento_ferias){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['dt_ini_ferias'] = $apontamento_ferias['dt_ini_ferias'];
        $fields['dt_fim_ferias'] = $apontamento_ferias['dt_fim_ferias'];
        $fields['colaborador_cobertura_ferias_pk'] = $apontamento_ferias['colaborador_cobertura_ferias_pk'];
        $fields['agenda_colaborador_apontamento_pk'] = $apontamento_ferias['agenda_colaborador_apontamento_pk'];
        $fields['ds_obs_ferias'] = $apontamento_ferias['ds_obs_ferias'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_ferias['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_ferias", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_ferias", $fields, " pk = ".$apontamento_ferias['pk'],$this->pdo);
        }
        return $retorno;
    }
    public function salvarServicoExtra($apontamento_servico_extra){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['colaborador_pk'] = $apontamento_servico_extra['colaborador_pk'];
        $fields['produtos_servicos_pk'] = $apontamento_servico_extra['produtos_servicos_pk'];
        $fields['obs'] = $apontamento_servico_extra['obs'];
        $fields['leads_pk'] = $apontamento_servico_extra['leads_pk'];
        $fields['dt_periodo_ini'] = $apontamento_servico_extra['dt_periodo_ini'];
        $fields['dt_periodo_fim'] = $apontamento_servico_extra['dt_periodo_fim'];

        $valors = str_replace (".", "", $apontamento_servico_extra['vl_servico']);
        $valors = str_replace (",", ".", $valors);

        $valorm = str_replace (".", "", $apontamento_servico_extra['vl_mao_obra']);
        $valorm = str_replace (",", ".", $valorm);

        $fields['vl_servico'] = $valors;
        $fields['vl_mao_obra'] = $valorm;

        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_servico_extra['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_servico_extra", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_servico_extra", $fields, " pk = ".$apontamento_servico_extra['pk'],$this->pdo);
        }
        return $retorno;
    }
    public function salvarDisciplina($apontamento_disciplina){

        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $fields = array();
        $fields['tipo_disciplina_pk'] = $apontamento_disciplina['tipo_disciplina_pk'];
        $fields['dt_disciplina'] = $apontamento_disciplina['dt_disciplina'];
        $fields['colaborador_pk'] = $apontamento_disciplina['colaborador_pk'];
        $fields['agenda_colaborador_pk'] = $apontamento_disciplina['agenda_colaborador_pk'];
        $fields['leads_pk'] = $apontamento_disciplina['leads_pk'];
        $fields['obs'] = $apontamento_disciplina['obs'];


        $fields["dt_ult_atualizacao"] = "sysdate()";
        $fields["usuario_ult_atualizacao_pk"] = $_SESSION['session_user']['par1'];

        if($apontamento_disciplina['pk']  == ""){

            $fields["dt_cadastro"] = "sysdate()";
            $fields["usuario_cadastro_pk"]   = $_SESSION['session_user']['par1'];

            $pk = Util::execInsert("apontamento_disciplina", $fields,$this->pdo);
            $retorno->status = true;
            $retorno->message = 'Dados cadastrados com sucesso';
            $retorno->data = $pk;
        }
        else{
            Util::execUpdate("apontamento_disciplina", $fields, " pk = ".$apontamento_disciplina['pk'],$this->pdo);
        }
        return $retorno;
    }


    public function listarApontamentoColaboradorDia($colaborador_pk,$dt_apontamento){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

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
        $sql.="         WHEN a.tipo_apontamento_pk = 8 THEN 'Disciplina'";
        $sql.="        END ds_tipo_apontamento";
        $sql.="  FROM agenda_colaborador_apontamento a";
        $sql.="       LEFT JOIN colaboradores c ON a.colaborador_pk = c.pk";
        $sql.="       LEFT JOIN apontamento_ponto ap ON a.pk = ap.agenda_colaborador_apontamento_pk";
        $sql.="       LEFT JOIN leads l ON l.pk = a.leads_pk";
        $sql.="       LEFT JOIN usuarios u ON a.usuario_cadastro_pk = u.pk";
        $sql.=" WHERE     1 = 1";

        if($dt_apontamento!=""){

            $sql.=" and a.dt_apontamento <= '".Util::DataYMD($dt_apontamento)." 23:59:59'";
            $sql.=" and a.dt_apontamento >= '".Util::DataYMD($dt_apontamento)." 00:00:00'";
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaborador_pk =".$colaborador_pk;
        }
        $sql.=" order by a.pk desc ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $retorno;
    }

    public function consultarHorario(){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql = "";
        $sql .= "select current_time";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);


        $retorno->data = $rows;
        $retorno->status = true;
        $retorno->message = 'Dados Salvos com sucesso !';
        return $rows[0]['current_time'];
    }

    public function listarDisciplina($ds_tipo_disciplina){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio

        $sql ="";
        $sql.="select pk, dt_cadastro, usuario_cadastro_pk, dt_ult_atualizacao, usuario_ult_atualizacao_pk ";
        $sql.="       ,ds_tipo_dsciplna ";
        $sql.="       ,ic_status ";

        $sql.="  from tipos_disciplinas ";
        $sql.=" where 1=1 ";
        if($ds_tipo_disciplina != ""){
            $sql.=" and ds_tipo_dsciplna like '%".$ds_tipo_disciplina."%' ";
        }
        $sql.=" order by ds_tipo_dsciplna asc ";

        $stmt = $this->pdo->prepare( $sql );
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;

        return $retorno;
    }

    public function relApontamento($colaborador_pk,$tipo_apontamento_pk,$dt_ini,$dt_fim,$leads_pk){
        $retorno = new \StdClass; //Estrutura de retorno para controller
        $retorno->status = false; //Retorno setado status como false
        $retorno->data = []; //Retorno data setado como vazio
        
        $sql ="";
        $sql.="SELECT a.pk agenda_colaborador_apontamento_pk,";
        $sql.="       c.pk colaboradores_pk,";
        $sql.="       c.ds_colaborador t_ds_colaborador,";
        $sql.="       u.pk usuario_cadastro_pk,";
        $sql.="       u.ds_usuario t_ds_usuario,";
        $sql.="       a.tipo_apontamento_pk,";
        $sql.="       l.pk leads_pk,";
        $sql.="       l.ds_lead t_ds_lead,";
        $sql.="       DATE_FORMAT(a.dt_apontamento, '%d/%m/%Y  %H:%i') t_dt_apontamento,";
        $sql.="       DATE_FORMAT(a.dt_cadastro, '%d/%m/%Y  %H:%i') t_dt_cadastro,";
        $sql.="       CASE";
        $sql.="         WHEN a.tipo_apontamento_pk = 1 THEN 'Ponto'";
        $sql.="         WHEN a.tipo_apontamento_pk = 2 THEN 'Falta'";
        $sql.="         WHEN a.tipo_apontamento_pk = 3 THEN 'Folga'";
        $sql.="         WHEN a.tipo_apontamento_pk = 4 THEN 'Troca de Escala'";
        $sql.="         WHEN a.tipo_apontamento_pk = 5 THEN 'Afastamento'";
        $sql.="         WHEN a.tipo_apontamento_pk = 6 THEN 'Férias'";
        $sql.="         WHEN a.tipo_apontamento_pk = 7 THEN 'Serviço Extra'";
        $sql.="         WHEN a.tipo_apontamento_pk = 8 THEN 'Disciplina'";
        $sql.="        END t_ds_tipo_apontamento,";
        $sql.="      CASE";
        $sql.="        WHEN a.tipo_apontamento_pk = 1 THEN ap.ds_obs_ponto";
        $sql.="        WHEN a.tipo_apontamento_pk = 2 THEN apf.ds_obs_falta";
        $sql.="        WHEN a.tipo_apontamento_pk = 3 THEN apfo.ds_obs_folga";
        $sql.="        WHEN a.tipo_apontamento_pk = 4 THEN ate.ds_obs_troca_escala";
        $sql.="        WHEN a.tipo_apontamento_pk = 5 THEN apfa.ds_obs_afastamento";
        $sql.="        WHEN a.tipo_apontamento_pk = 6 THEN af.ds_obs_ferias";
        $sql.="      END   t_obs   ";
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
 
            $sql.=" and a.dt_apontamento >= '".Util::dataYMD($dt_ini)." 00:00:00'";
            $sql.=" and a.dt_apontamento <= '".Util::dataYMD($dt_fim)." 23:59:59'";
        }
        if($colaborador_pk!=""){
            $sql.=" and a.colaborador_pk =".$colaborador_pk;
        }
        if(!empty($leads_pk)){
            $sql.=" and a.leads_pk =".$leads_pk;
        }
        $sql.=" order by a.pk desc ";

        
   
        $stmt = $this->pdo->prepare( $sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $retorno->status = true;
        $retorno->message = 'Dados carregados com sucesso';
        $retorno->data = $rows;
        $retorno->iTotalDisplayRecords = count($rows);
        $retorno->iTotalRecords = count($rows);

        echo json_encode($retorno);
        exit(0);
    }

}
