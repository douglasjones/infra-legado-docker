<?

require_once "../inc/php/public.php";
require_once "../inc/classes/bestflow/DataBase.php";
require_once "../model/analise_financeira_processos.dao.php";
require_once "../model/analise_financeira_processos.class.php";
include_once "../model/enviar_email.dao.php";
include_once "../model/usuario.dao.php";
include_once "../model/analise_financeira.dao.php";
include_once "../controller/layout.controller.php";


$arrRequest = tratar_request();

$job = $arrRequest['job'];
$token = $arrRequest['token'];
$pk = $arrRequest['pk'];
$tipo_nivel_usuario = $arrRequest['tipo_nivel_usuario'];
$ic_recusa = $arrRequest['ic_recusa'];
$obs_recusa = $arrRequest['obs_recusa'];
$ic_correcao = $arrRequest['ic_correcao'];
$obs_correcao = $arrRequest['obs_correcao'];
$ic_aprovacao = $arrRequest['ic_aprovacao'];
$obs_aprovacao = $arrRequest['obs_aprovacao'];
$dt_cancelamento = $arrRequest['dt_cancelamento'];
$obs_cancelamento = $arrRequest['obs_cancelamento'];
$analise_financeira_pk = $arrRequest['analise_financeira_pk'];
$gestor_aprovacao_pk = $arrRequest['gestor_aprovacao_pk'];
$lancamento_pk = $arrRequest['lancamento_pk'];
$analise_financeira_processosdao = new analise_financeira_processosdao();
$analise_financeira_processosdao->setToken($token); 
$enviar_emaildao = new enviar_emaildao();
$enviar_emaildao->setToken($token);

$usuariodao = new usuariodao();
$usuariodao->setToken($token);

$analise_financeiradao = new analise_financeiradao();
$analise_financeiradao->setToken($token);


switch($job){

    case 'excluir':{
        
        $resultdo = "";
        
        $analise_financeira_processos = $analise_financeira_processosdao->carregarPorPk($pk);
        if($analise_financeira_processos->getpk()>0){
            
            $analise_financeira_processosdao->excluir($analise_financeira_processos);
            
            $result  = 'success';
            $message = 'Registro excluído com sucesso.';

        }
        else{
            $result  = 'error';
            $message = 'analise_financeira_processos nao encontrado';
        }
        break;
    }
    case 'salvar':{

        $analise_financeira_processos = $analise_financeira_processosdao->carregarPorPk($pk);
        $analise_financeira_processos->settipo_nivel_usuario($tipo_nivel_usuario);
        $analise_financeira_processos->setic_recusa($ic_recusa);
        $analise_financeira_processos->setobs_recusa($obs_recusa);
        $analise_financeira_processos->setic_correcao($ic_correcao);
        $analise_financeira_processos->setobs_correcao($obs_correcao);
        $analise_financeira_processos->setic_aprovacao($ic_aprovacao);
        $analise_financeira_processos->setobs_aprovacao($obs_aprovacao);
        $analise_financeira_processos->setdt_cancelamento($dt_cancelamento);
        $analise_financeira_processos->setobs_cancelamento($obs_cancelamento);
        $analise_financeira_processos->setanalise_financeira_pk($analise_financeira_pk);

        $pk = $analise_financeira_processosdao->salvar($analise_financeira_processos, $gestor_aprovacao_pk);

        $dadosCadastroAnalise = $analise_financeiradao->listarDadosAnaliseFinanceira($analise_financeira_pk);

        //var_dump($dadosCadastroAnalise);
        $dadosUsuarioLogado = $usuariodao->listarGruposUsuario($usuarios_pk);

        $dadosUsuarioCadastro = $usuariodao->listarDadosUsuario($dadosCadastroAnalise[0]['usuario_cadastro_lancamento_pk']);

        if($dadosUsuarioLogado[0]['ds_grupo'] == 'Analista Financeiro'){

            $texto = "";
            if($ic_recusa !== null){    
                $Assunto = "Gepros Analista Financeiro - Lancamento Financeiro Recusado ";
                $texto .="<div style='text-align:center'><b>Gepros - Lan&ccedil;amento Financeiro Recusado</b></div>";
                $texto .="<div style='text-align:center'> O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." foi recusado pelo setor An&aacute;lise Financeira.</div>";             
                $texto .="<div style='text-align:center'>$obs_recusa</div>";
            }else if($ic_aprovacao !== null){
                $Assunto = "Gepros Analista Financeiro - Lancamento Financeiro Aprovado Analista";
                $texto .="<div style='text-align:center'><b>Gepros - Solicita&ccedil;&atilde;o de Corre&ccedil;&atilde;o Lan&ccedil;amento Financeiro</b></div>";
                $texto .="<div style='text-align:center'>O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." foi aprovado pelo setor An&aacute;lise Financeira.</div>";
                $texto .="<div style='text-align:center'>$obs_aprovacao</div>";
            }else if($ic_correcao !== null){
                $Assunto = "Gepros Analista Financeiro - Solicitacao de Correcao Lancamento";
                $texto .="<div style='text-align:center'><b>Gepros - Solicita&ccedil;&atilde;o de Corre&ccedil;&atilde;o Lan&ccedil;amento Financeiro</b></div>";
                $texto .="<div style='text-align:center'>O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." requer sua aten&ccedil;&atilde;o, existem corre&ccedil;&otilde;es para serem feitas solicitadas pelo setor An&aacute;lise Financeira.</div>";
                $texto .="<div style='text-align:center'>$obs_correcao</div>";
            }
        }else if($dadosUsuarioLogado[0]['ds_grupo'] == 'Controller'){

            if($ic_recusa !== null){    
                $Assunto = "Gepros Gestor - Lancamento Financeiro Recusado ";
                $texto .="<div style='text-align:center'><b>Gepros - Lan&ccedil;amento Financeiro Recusado</b></div>";
                $texto .="<div style='text-align:center'> O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." foi recusado pelo setor Gestor.</div>";             
                $texto .="<div style='text-align:center'>$obs_recusa</div>";
            }else if($ic_aprovacao !== null){
                $Assunto = "Gepros Gestor - Lancamento Financeiro Aprovado";
                $texto .="<div style='text-align:center'><b>Gepros - Solicita&ccedil;&atilde;o de Corre&ccedil;&atilde;o Lan&ccedil;amento Financeiro</b></div>";
                $texto .="<div style='text-align:center'>O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." foi aprovado pelo setor Gestor.</div>";
                $texto .="<div style='text-align:center'>$obs_aprovacao</div>";
            }else if($ic_correcao !== null){
                $Assunto = "Gepros Gestor - Solicitacao de Correcao Lancamento Financeiro ";
                $texto .="<div style='text-align:center'><b>Gepros - Solicita&ccedil;&atilde;o de Corre&ccedil;&atilde;o Lan&ccedil;amento Financeiro</b></div>";
                $texto .="<div style='text-align:center'>O Lan&ccedil;amento ".$dadosCadastroAnalise[0]['lancamentos_pk']." requer sua aten&ccedil;&atilde;o, existem corre&ccedil;&otilde;es para serem feitas solicitadas pelo setor Gestor.</div>";
                $texto .="<div style='text-align:center'>$obs_correcao</div>";
            }
        }



        //Chamada para o envio de E-mail
        $html = layout::AnaliseFinanceiraSolicitacaoCorrecao($texto); 

        $emailpara = $dadosUsuarioCadastro[0]['ds_email'];

        $enviar_emaildao->enviaEmailAutenticado($html, /*De*/'sistema@gepros1.com.br', /*Para*/$emailpara, $Assunto);

        $mysql_data[] = array(
            "pk" => $pk
        );
        
        $result  = 'success';
        $message = 'Registro salvo com sucesso.';        
        
        break;
    }
    case 'listarPk':{
        
        $resultado = "";
        $query = $analise_financeira_processosdao->listarPorPk($pk);
        
        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_nivel_usuario"=>$query[$i]['tipo_nivel_usuario'],
                    "ic_recusa"=>$query[$i]['ic_recusa'],
                    "obs_recusa"=>$query[$i]['obs_recusa'],
                    "ic_correcao"=>$query[$i]['ic_correcao'],
                    "obs_correcao"=>$query[$i]['obs_correcao'],
                    "ic_aprovacao"=>$query[$i]['ic_aprovacao'],
                    "obs_aprovacao"=>$query[$i]['obs_aprovacao'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "analise_financeira_pk"=>$query[$i]['analise_financeira_pk']
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
        $query = $analise_financeira_processosdao->listarTodos();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){
                $mysql_data[] = array(
                    "pk" => $query[$i]["pk"],
                    "tipo_nivel_usuario"=>$query[$i]['tipo_nivel_usuario'],
                    "ic_recusa"=>$query[$i]['ic_recusa'],
                    "obs_recusa"=>$query[$i]['obs_recusa'],
                    "ic_correcao"=>$query[$i]['ic_correcao'],
                    "obs_correcao"=>$query[$i]['obs_correcao'],
                    "ic_aprovacao"=>$query[$i]['ic_aprovacao'],
                    "obs_aprovacao"=>$query[$i]['obs_aprovacao'],
                    "dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "analise_financeira_pk"=>$query[$i]['analise_financeira_pk']
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
        $query = $analise_financeira_processosdao->listarDataTable();
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_tipo_nivel_usuario"=>$query[$i]['tipo_nivel_usuario'],
                    "t_ic_recusa"=>$query[$i]['ic_recusa'],
                    "t_obs_recusa"=>$query[$i]['obs_recusa'],
                    "t_ic_correcao"=>$query[$i]['ic_correcao'],
                    "t_obs_correcao"=>$query[$i]['obs_correcao'],
                    "t_ic_aprovacao"=>$query[$i]['ic_aprovacao'],
                    "t_obs_aprovacao"=>$query[$i]['obs_aprovacao'],
                    "t_dt_cancelamento"=>$query[$i]['dt_cancelamento'],
                    "t_obs_cancelamento"=>$query[$i]['obs_cancelamento'],
                    "t_analise_financeira_pk"=>$query[$i]['analise_financeira_pk'],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'historicoAnaliseFinanceira':{
        
        
        $resultado = "";
        $query = $analise_financeira_processosdao->historicoAnaliseFinanceira($analise_financeira_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_cadastro" => $query[$i]["dt_cadastro"],
                    "t_ic_status" => $query[$i]["ic_status"],
                    "t_obs" => $query[$i]["obs"],
                    "t_ds_usuario_cadastro" => $query[$i]["ds_usuario_cadastro"],

                    "t_functions" => ""
                );
            }
        }
        else{
            $mysql_data = [];
        }
		
        break;
    }    
    case 'listarObsAnalise':{
        
        
        $resultado = "";
        $query = $analise_financeira_processosdao->listarObsAnalise($lancamento_pk);
        
        $result  = 'success';
        $message = 'query success';

        if(count($query) > 0){
            for($i = 0; $i < count($query); $i++){

                $mysql_data[] = array(
                    "t_pk" => $query[$i]["pk"],
                    "t_dt_cadastro" => $query[$i]["dt_cadastro"],
                    "t_ic_status" => $query[$i]["ic_status"],
                    "t_obs" => $query[$i]["obs"],
                    "t_ds_usuario_cadastro" => $query[$i]["ds_usuario_cadastro"],
                    "t_analise_financeira_pk" => $query[$i]["analise_financeira_pk"],

                    "t_functions" => ""
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

$analise_financeira_processosdao = null;

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
