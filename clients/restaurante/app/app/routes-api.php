<?php

use App\Middleware\Authentication;

$app->group('/api', function () use ($app) {

	$container = $app->getContainer();

    //AREA DO COLABORADOR
    $app->group('/area_colaborador', function () use ($app) {
        $app->post('/buscarColaborador', 'App\Controller\AreaColaboradorController:buscarColaborador')->setName('buscarColaborador');
        $app->post('/salvarPrimeiroRegistro', 'App\Controller\AreaColaboradorController:salvarPrimeiroRegistro')->setName('salvarPrimeiroRegistro');
        $app->post('/pegarInfoColaborador', 'App\Controller\AreaColaboradorController:pegarInfoColaborador')->setName('pegarInfoColaborador');
        $app->post('/salvarPonto', 'App\Controller\AreaColaboradorController:salvarPonto')->setName('salvarPonto');
    });

	//SECTION AUTH
	$app->group('/auth', function () use ($app) {
		$app->post('/login', 'App\Controller\LoginController:apiLogin')->setName('api-login');
        $app->post('/logout', 'App\Controller\LoginController:apiLogoff')->setName('api-logoff');
        $app->post('/updateSenha', 'App\Controller\LoginController:updateSenha')->setName('api-updateSenha');
	});

    //AGENDA COLABORADOR APONTAMENTO
    $app->group('/agenda_colaborador_apontamento', function () use ($app) {
        $app->post('/listarApontamentoColaboradorDia', 'App\Controller\AgendaColaboradorApontamentoController:listarApontamentoColaboradorDia')->setName('listarApontamentoColaboradorDia');
        $app->post('/salvar', 'App\Controller\AgendaColaboradorApontamentoController:salvar')->setName('listarApontamentoColaboradorDia');
        $app->get('/relApontamento', 'App\Controller\AgendaColaboradorApontamentoController:relApontamento')->setName('relApontamento');
		$app->post('/listarDisciplina', 'App\Controller\AgendaColaboradorApontamentoController:listarDisciplina')->setName('listarDisciplina');
    });

    //AGENDA COLABORADOR PADRAO
    $app->group('/agenda_colaborador_padrao', function () use ($app) {
        $app->post('/updateDataEscalaColaborador', 'App\Controller\AgendaColaboradorPadraoController:updateDataEscalaColaborador')->setName('updateDataEscalaColaborador');
        $app->post('/listarEscalasPostosColaborador', 'App\Controller\AgendaColaboradorPadraoController:listarEscalasPostosColaborador')->setName('listarEscalasPostosColaborador');
        $app->get('/listarEscalaLead', 'App\Controller\AgendaColaboradorPadraoController:listarEscalaLead')->setName('listarEscalaLead');
        $app->get('/listarEscala', 'App\Controller\AgendaColaboradorPadraoController:listarEscala')->setName('listarEscala');
	    $app->get('/listarEscalaColaborador', 'App\Controller\AgendaColaboradorPadraoController:listarEscalaColaborador')->setName('listarEscalaColaborador');
	    $app->post('/salvar', 'App\Controller\AgendaColaboradorPadraoController:salvar')->setName('salvar');
	    $app->post('/escalaDadosColaborador', 'App\Controller\AgendaColaboradorPadraoController:escalaDadosColaborador')->setName('escalaDadosColaborador');
	    $app->post('/listarTurno', 'App\Controller\AgendaColaboradorPadraoController:listarTurno')->setName('escalaDadosColaborador');
	    $app->post('/listarPk', 'App\Controller\AgendaColaboradorPadraoController:listarPk')->setName('listarPk');
	    $app->post('/excluir', 'App\Controller\AgendaColaboradorPadraoController:excluir')->setName('salvar');
	    $app->get('/calendarioDados', 'App\Controller\AgendaColaboradorPadraoController:calendarioDados')->setName('calendarioDados');
	    $app->get('/calendarioDadosEscala', 'App\Controller\AgendaColaboradorPadraoController:calendarioDadosEscala')->setName('calendarioDadosEscala');
    });
    //BANCO
    $app->group('/banco', function () use ($app) {
	    $app->post('/listarTodos', 'App\Controller\BancoController:listarTodos')->setName('listarTodos');
	 });
    //COLABORADOR
    $app->group('/colaborador', function () use ($app) {
        $app->post('/listarColaboradorFolha','App\Controller\ColaboradorController:listarColaboradorFolha')->setName('listarColaboradorFolha');
        $app->get('/listarDataTable', 'App\Controller\ColaboradorController:listarDataTable')->setName('listarTodos');
	    $app->get('/listarGridFuncao', 'App\Controller\ColaboradorController:listarGridFuncao')->setName('listarGridFuncao');
	    $app->post('/salvar', 'App\Controller\ColaboradorController:salvar')->setName('salvar');
	    $app->post('/salvarFuncao', 'App\Controller\ColaboradorController:salvarFuncao')->setName('salvarFuncao');
	    $app->post('/excluirFuncao', 'App\Controller\ColaboradorController:excluirFuncao')->setName('excluirFuncao');
	    $app->post('/excluir', 'App\Controller\ColaboradorController:excluir')->setName('excluir');
	    $app->post('/listarTodosByFuncaoPk', 'App\Controller\ColaboradorController:listarTodosByFuncaoPk')->setName('listarTodos');
	    $app->post('/listarTodos', 'App\Controller\ColaboradorController:listarTodos')->setName('listarTodos');
	    $app->post('/listarPk', 'App\Controller\ColaboradorController:listarPk')->setName('listarPk');
	    $app->post('/RelatorioDadosColaborador', 'App\Controller\ColaboradorController:RelatorioDadosColaborador')->setName('listarPk');
	    $app->post('/listarDsPin', 'App\Controller\ColaboradorController:listarDsPin')->setName('listarDsPin');
	    $app->post('/listarColaboradoresQualificacao', 'App\Controller\ColaboradorController:listarColaboradoresQualificacao')->setName('listarColaboradoresQualificacao');
	    $app->post('/listarColaboradorLeadCalendario', 'App\Controller\ColaboradorController:listarColaboradorLeadCalendario')->setName('listarColaboradoresQualificacao');
	    $app->post('/listarColaboradorLead', 'App\Controller\ColaboradorController:listarColaboradorLead')->setName('listarColaboradorLead');
    });

    //CONTA
    $app->group('/conta', function () use ($app) {
		$app->post('/salvar', 'App\Controller\ContaController:salvar')->setName('salvar');
        $app->post('/excluir', 'App\Controller\ContaController:excluir')->setName('excluir');
        $app->post('/listarTodos', 'App\Controller\ContaController:listarTodos')->setName('listarTodos');
        $app->get('/listarDataTable', 'App\Controller\ContaController:listarDataTable')->setName('listarDataTable');
        $app->post('/listarPk', 'App\Controller\ContaController:listarPk')->setName('listarPk');
    });

    //DOCUMENTO
    $app->group('/documento', function () use ($app) {
		$app->get('/listarDocumentosLead', 'App\Controller\DocumentoController:listarDocumentosLead')->setName('listarDocumentosLead');
		$app->get('/listarDocumentosColaborador', 'App\Controller\DocumentoController:listarDocumentosColaborador')->setName('listarDocumentosColaborador');
		$app->post('/renomearArquivo', 'App\Controller\DocumentoController:renomearArquivo')->setName('renomearArquivo');
		$app->post('/excluir', 'App\Controller\DocumentoController:excluir')->setName('renomearArquivo');
    });

	//GRUPO
    $app->group('/grupo', function () use ($app) {
        $app->post('/listarTodos', 'App\Controller\GrupoController:listarTodos')->setName('listarTodos');
        $app->get('/listarGrid', 'App\Controller\GrupoController:listarGrid')->setName('listarGrid');
		$app->post('/listarPk', 'App\Controller\GrupoController:listarPk')->setName('listarPk');
        $app->post('/listarPermissoesGrupo', 'App\Controller\GrupoController:listarPermissoesGrupo')->setName('listarPermissoesGrupo');
        $app->post('/salvar', 'App\Controller\GrupoController:salvar')->setName('salvar');
        $app->post('/excluir', 'App\Controller\GrupoController:excluir')->setName('salvar');
    });
    //GRUPO LEADS
    $app->group('/grupo_lead', function () use ($app) {
        $app->post('/listarTodos', 'App\Controller\GrupoLeadController:listarTodos')->setName('listarTodos');
    });
    //LEADS
    $app->group('/lead', function () use ($app) {
        $app->post('/verificarCNPJ', 'App\Controller\LeadController:verificarCNPJ')->setName('verificarCNPJ');
        $app->post('/listarTodos', 'App\Controller\LeadController:listarTodos')->setName('listarTodos');
        $app->post('/listarLeadByGrupo', 'App\Controller\LeadController:listarLeadByGrupo')->setName('listarTodos');
        $app->post('/listarPk', 'App\Controller\LeadController:listarPk')->setName('listarPk');
        $app->post('/excluirFuncao', 'App\Controller\LeadController:excluirFuncao')->setName('excluirFuncao');
        $app->post('/excluir', 'App\Controller\LeadController:excluir')->setName('excluir');
        $app->post('/salvar', 'App\Controller\LeadController:salvar')->setName('salvar');
        $app->post('/salvarFuncao', 'App\Controller\LeadController:salvarFuncao')->setName('salvar');
        $app->get('/listarDataTable', 'App\Controller\LeadController:listarDataTable')->setName('listarDataTable');
        $app->post('/listarLeadsPorEmpresa', 'App\Controller\LeadController:listarLeadsPorEmpresa')->setName('listarLeadsPorEmpresa');
		$app->get('/listarGridFuncao', 'App\Controller\LeadController:listarGridFuncao')->setName('listarGridFuncao');
    });
	//MÓDULOS
    $app->group('/modulo', function () use ($app) {
        $app->get('/listarDataTable', 'App\Controller\ModuloController:listarDataTable')->setName('listarDataTable');
		$app->post('/listarTodos', 'App\Controller\ModuloController:listarTodos')->setName('listarTodos');
		$app->post('/listarTipoModulo', 'App\Controller\ModuloController:listarTipoModulo')->setName('listarTipoModulo');
        $app->post('/salvar', 'App\Controller\ModuloController:salvar')->setName('salvar');
        $app->post('/listarPk', 'App\Controller\ModuloController:listarPk')->setName('listarPk');
        $app->post('/excluir', 'App\Controller\ModuloController:excluir')->setName('excluir');
    });

    //PONTO
    $app->group('/ponto', function () use ($app) {
        $app->post('/listarColaborador', 'App\Controller\PontoController:listarColaborador')->setName('relAcompanhamentoPontoSintetico');
        $app->post('/relatorioPontoSinteticaAntigo', 'App\Controller\PontoController:relatorioPontoSinteticaAntigo')->setName('relAcompanhamentoPontoSintetico');
        $app->post('/relatorioPonto', 'App\Controller\PontoController:relatorioPonto')->setName('relatorioPonto');
        $app->post('/relAcompanhamentoPontoSintetico', 'App\Controller\PontoController:relAcompanhamentoPontoSintetico')->setName('relAcompanhamentoPontoSintetico');
        $app->get('/popUpAtraso', 'App\Controller\PontoController:popUpAtraso')->setName('popUpAtraso');
        $app->get('/relRondas', 'App\Controller\PontoController:relRondas')->setName('relRondas');
    });

    //PONTO FOLHA
    $app->group('/ponto_folha', function () use ($app) {
        $app->post('/listarGrid', 'App\Controller\PontoFolhaController:listarGrid')->setName('listarGrid');
        $app->post('/salvar', 'App\Controller\PontoFolhaController:salvar')->setName('salvar');
        $app->get('/listarPontoFolhaPK', 'App\Controller\PontoFolhaController:listarPontoFolhaPK')->setName('listarPontoFolhaPK');
        $app->post('/listarFolhasRegistros', 'App\Controller\PontoFolhaController:listarFolhasRegistros')->setName('listarFolhasRegistros');
        $app->post('/listarRegistros', 'App\Controller\PontoFolhaController:listarRegistros')->setName('listarRegistros');
        $app->post('/salvarRegistros', 'App\Controller\PontoFolhaController:salvarRegistros')->setName('salvarRegistros');
        $app->post('/salvarFolhaFinalizada', 'App\Controller\PontoFolhaController:salvarFolhaFinalizada')->setName('salvarFolhaFinalizada');
        $app->post('/listarConsultaPontoColaborador', 'App\Controller\PontoFolhaController:listarConsultaPontoColaborador')->setName('listarConsultaPontoColaborador');
        $app->post('/listarDadosImpressao', 'App\Controller\PontoFolhaController:listarDadosImpressao')->setName('listarDadosImpressao');
        $app->post('/regerar', 'App\Controller\PontoFolhaController:regerar')->setName('regerar');
        $app->post('/excluir', 'App\Controller\PontoFolhaController:excluir')->setName('excluir');
    });

    //SERVICO
    $app->group('/servico', function () use ($app) {
        $app->get('/listarGrid', 'App\Controller\ServicoController:listarGrid')->setName('listarGrid');
        $app->post('/listarTodos', 'App\Controller\ServicoController:listarTodos')->setName('listarGrid');
        $app->post('/listarByLeads', 'App\Controller\ServicoController:listarByLeads')->setName('listarByLeads');
        $app->post('/salvar', 'App\Controller\ServicoController:salvar')->setName('salvar');
        $app->post('/excluir', 'App\Controller\ServicoController:excluir')->setName('excluir');
        $app->post('/listarPk', 'App\Controller\ServicoController:listarPk')->setName('listarPk');
    });

    //TIPO ESCALA
    $app->group('/tipo_escala', function () use ($app) {
        $app->post('/listarTodos', 'App\Controller\TipoEscalaController:listarTodos')->setName('listarTodos');
    });

    //SOLICITACAO ACESSO APP
    $app->group('/solicitacao_acesso_app', function () use ($app) {
        $app->get('/listar_solicitacoes', 'App\Controller\SolicitacaoAcessoAppController:listarSolicitacoes')->setName('listar_solicitacoes');
        $app->post('/liberarAcesso', 'App\Controller\SolicitacaoAcessoAppController:liberarAcesso')->setName('salvar');
        $app->post('/excluir', 'App\Controller\SolicitacaoAcessoAppController:excluir')->setName('excluir');
    });

    //USUARIO
    $app->group('/usuario', function () use ($app) {
		$app->get('/listarGrid', 'App\Controller\UsuarioController:listarGrid')->setName('listarGrid');
        $app->post('/salvar', 'App\Controller\UsuarioController:salvar')->setName('salvar');
        $app->post('/excluir', 'App\Controller\UsuarioController:excluir')->setName('excluir');
        $app->post('/listarPk', 'App\Controller\UsuarioController:listarPk')->setName('listarPk');
        $app->post('/listarAdmSistema', 'App\Controller\UsuarioController:listarAdmSistema')->setName('listarAdmSistema');
        $app->post('/listarSupervisor', 'App\Controller\UsuarioController:listarSupervisor')->setName('listarSupervisor');
        $app->post('/listarTodos', 'App\Controller\UsuarioController:listarTodos')->setName('listarTodos');
        $app->post('/listarUsuarioLogado', 'App\Controller\UsuarioController:listarUsuarioLogado')->setName('listarUsuarioLogado');
        $app->post('/listarTodosSemAdm', 'App\Controller\UsuarioController:listarTodosSemAdm')->setName('listarTodosSemAdm');
        $app->post('/verificarPermissao', 'App\Controller\UsuarioController:verificarPermissao')->setName('verificarPermissao');
    });
});

