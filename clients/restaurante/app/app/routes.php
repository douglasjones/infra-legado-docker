<?php

    /** @noinspection PhpParamsInspection */
    /** @noinspection SpellCheckingInspection */
    /** @noinspection PhpUndefinedVariableInspection */

    use App\Middleware\Authentication;
    $container = $app->getContainer();


    //AREA COLABORADOR
    $app->get('/area_colaborador/receptivo', 'App\Controller\AreaColaboradorController:receptivo')
        ->setName('root');
    $app->get('/area_colaborador/passo1', 'App\Controller\AreaColaboradorController:passo1')
        ->setName('root');
    $app->get('/area_colaborador/passo2', 'App\Controller\AreaColaboradorController:passo2')
        ->setName('root');
    $app->get('/area_colaborador/passo3', 'App\Controller\AreaColaboradorController:passo3')
        ->setName('root');

    $app->get('/area_colaborador/passo4', 'App\Controller\AreaColaboradorController:passo4')
        ->setName('root');

    $app->get('/area_colaborador/tirar_foto_novo_registro', 'App\Controller\AreaColaboradorController:tirarFotoNovoRegistro')
        ->setName('root');

    //REGISTRAR PONTO
    $app->get('/area_colaborador/receptivoRegistrarPonto', 'App\Controller\AreaColaboradorController:receptivoRegistrarPonto')
        ->setName('root');

        $app->get('/area_colaborador/receptivoRegistrarPontoPorPin', 'App\Controller\AreaColaboradorController:receptivoRegistrarPontoPorPin')
        ->setName('root');


    //new Authentication($container) faz a verificação para ver se tem algum usuário logado.

    //MENU
    $app->get('/', 'App\Controller\LoginController:login')
        ->setName('root')->add(new Authentication($container));
    $app->get('/loginSistema', 'App\Controller\LoginController:loginSistema')
        ->setName('root');

    $app->get('/menu/principal', 'App\Controller\MenuController:principal')
        ->setName('root')->add(new Authentication($container));
    $app->get('/menu/administracao', 'App\Controller\MenuController:administracao')
        ->setName('root')->add(new Authentication($container));
    $app->get('/menu/operacional', 'App\Controller\MenuController:operacional')
    ->setName('root')->add(new Authentication($container));
    $app->get('/menu/rh', 'App\Controller\MenuController:rh')
    ->setName('root')->add(new Authentication($container));

    $app->get('/menu/relatorio', 'App\Controller\MenuController:relatorio')
    ->setName('root')->add(new Authentication($container));

    $app->get('/menu/cpainel', 'App\Controller\MenuController:cpainel')
        ->setName('root')->add(new Authentication($container));

    $app->get('/agenda_colaborador_padrao/receptivo', 'App\Controller\AgendaColaboradorPadraoController:receptivo')
    ->setName('root')->add(new Authentication($container));

    $app->get('/agenda_colaborador_padrao/receptivoEscala', 'App\Controller\AgendaColaboradorPadraoController:receptivoEscala')
        ->setName('root')->add(new Authentication($container));

    $app->get('/agenda_colaborador_padrao/cadFormEscala', 'App\Controller\AgendaColaboradorPadraoController:cadFormEscala')
        ->setName('root')->add(new Authentication($container));

    //COLABORADOR
    $app->get('/colaborador/receptivo', 'App\Controller\ColaboradorController:receptivo')
        ->setName('root')->add(new Authentication($container));
    $app->get('/colaborador/cadForm', 'App\Controller\ColaboradorController:cadForm')
        ->setName('editarConta')->add(new Authentication($container));

    //CONTA
    $app->get('/conta/receptivo', 'App\Controller\ContaController:receptivo')
        ->setName('root')->add(new Authentication($container));
    $app->get('/conta/editarConta', 'App\Controller\ContaController:editarConta')
        ->setName('editarConta')->add(new Authentication($container));

    //DOCUMENTO
    $app->get('/documento/download', 'App\Controller\DocumentoController:download')
        ->setName('root')->add(new Authentication($container));
    $app->post('/documento/salvarDocumento', 'App\Controller\DocumentoController:salvarDocumento')
        ->setName('root')->add(new Authentication($container));
	 //GRUPOS
    $app->get('/grupo/receptivo', 'App\Controller\GrupoController:receptivo')
        ->setName('root')->add(new Authentication($container));
    $app->get('/grupo/cadForm', 'App\Controller\GrupoController:cadForm')
    ->setName('root')->add(new Authentication($container));

    //LEAD
    $app->get('/lead/receptivo', 'App\Controller\LeadController:receptivo')
    ->setName('root')->add(new Authentication($container));
    $app->get('/lead/cadForm', 'App\Controller\LeadController:cadForm')
    ->setName('root')->add(new Authentication($container));

    //MÓDULOS
    $app->get('/modulo/receptivo', 'App\Controller\ModuloController:receptivo')
        ->setName('root')->add(new Authentication($container));
    $app->get('/modulo/cadForm', 'App\Controller\ModuloController:cadForm')
        ->setName('root')->add(new Authentication($container));

    //PONTO
    $app->get('/ponto/receptivoPontoAtraso', 'App\Controller\PontoController:receptivoPontoAtraso')
    ->setName('root')->add(new Authentication($container));

    //PONTO FOLHA
    $app->get('/ponto_folha/receptivoPontoFolha', 'App\Controller\PontoFolhaController:receptivoPontoFolha')
        ->setName('root')->add(new Authentication($container));
    $app->get('/ponto_folha/cadForm', 'App\Controller\PontoFolhaController:cadForm')
        ->setName('root')->add(new Authentication($container));
    $app->get('/ponto_folha/registrosCad', 'App\Controller\PontoFolhaController:registrosCad')
        ->setName('root')->add(new Authentication($container));
    $app->get('/ponto_folha/colaboradoresCad', 'App\Controller\PontoFolhaController:colaboradoresCad')
        ->setName('root')->add(new Authentication($container));
    $app->get('/ponto_folha/receptivoPrint', 'App\Controller\PontoFolhaController:receptivoPrint')
        ->setName('root')->add(new Authentication($container));

    //RELATORIO
    $app->get('/relatorio/operacional', 'App\Controller\RelatorioController:operacional')
    ->setName('root')->add(new Authentication($container));
    $app->get('/relatorio/pesqAcompanhamentoPontoSintetico', 'App\Controller\RelatorioController:pesqAcompanhamentoPontoSintetico')
        ->setName('root')->add(new Authentication($container));
    $app->get('/relatorio/resAcompanhamentoPontoSintetico', 'App\Controller\RelatorioController:resAcompanhamentoPontoSintetico')
        ->setName('root')->add(new Authentication($container));
    $app->get('/relatorio/pesqAcompanhamentoPontoAnalitico', 'App\Controller\RelatorioController:pesqAcompanhamentoPontoAnalitico')
        ->setName('root')->add(new Authentication($container));
    $app->get('/relatorio/resAcompanhamentoPontoAnalitico', 'App\Controller\RelatorioController:resAcompanhamentoPontoAnalitico')
        ->setName('root')->add(new Authentication($container));

    $app->get('/relatorio/pesqRelApontamento', 'App\Controller\RelatorioController:pesqColaboradorApontamento')
    ->setName('root')->add(new Authentication($container));
    $app->get('/relatorio/receptivoRelApontamento', 'App\Controller\RelatorioController:resColaboradorApontamento')
    ->setName('root')->add(new Authentication($container));
    //SOLICITAÇÃO ACESSO APP PONTO
    $app->get('/solicitacao_acesso_app/receptivo', 'App\Controller\SolicitacaoAcessoAppController:receptivo')
    ->setName('root')->add(new Authentication($container));
    //USUARIO
    $app->get('/usuario/receptivo', 'App\Controller\UsuarioController:receptivo')
    ->setName('root')->add(new Authentication($container));
    $app->get('/usuario/cadForm', 'App\Controller\UsuarioController:cadForm')
    ->setName('root')->add(new Authentication($container));

    $app->get('/usuarios/edit/{pk}', 'App\Controller\UsuarioController:edit')
    ->setName('root')->add(new Authentication($container));

    //SERVICO
    $app->get('/servico/receptivo', 'App\Controller\ServicoController:receptivo')
        ->setName('root')->add(new Authentication($container));
    $app->get('/servico/cadForm', 'App\Controller\ServicoController:cadForm')
        ->setName('root')->add(new Authentication($container));

    //LOGIN
    $app->get('/login', 'App\Controller\LoginController:login')
        ->setName('login');

    //WEBPONTO
    $app->post('/whatsAppWebPonto', 'App\Controller\WebPontoWhatsAppController:webPontoWhatsApp')
        ->setName('root');
