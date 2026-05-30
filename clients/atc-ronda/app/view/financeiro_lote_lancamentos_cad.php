
<div style='display: none'>
    <?include_once "../inc/php/header.php";?>
</div>
<script src="financeiro_lote_lancamentos_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
</head>
<br>
<div class="row">
    <div class="col-md-8" style="margin:20px">
        <br>
        <div class="row">
            <div class='col-sm-6' align="left">
                <h5 class="m-0 font-weight-bold">Controle de lançamentos em lote</h5>
            </div>
        </div>
        <br>
        <div class="row">
            <div class='col-sm-4' align="left">
                <label for='ds_identificacao_lote'>Identificação do Lote:</label>
                <input type="text" class="form-control form-control-sm ds_identificacao_lote" id="ds_identificacao_lote">
            </div>
        </div>
        <br>
        <div class="row">
            <div class='col-sm-6' align="left">
                <button type="button" class="btn btn-secondary btn-sm" id="cmdFechar">Fechar</button>                      
                <button type="button" class="btn btn-primary btn-sm" id="cmdAlterarIdentificao">Salvar Identificação</button>                      
            </div>
        </div>
    </div>
    <div class="col-md-3" align="center">
        <br>
        <div class="row" align="center">
            <div class='col-sm-12' align="right">
                <h5>Legenda</h5>
            </div>
            <div class='col-sm-12' align="right">
                <i style="color:#33cc33;" class="bi bi-database-fill-check fa-lg"></i> 
                Item salvo e lançado em Lançamentos
            </div>
            <br>
            <div class='col-sm-12' align="right">
                <i style="color:#ffcc00;" class="bi bi-database-fill-check fa-lg"></i> 
                Item salvo
            </div>
            <br>
            <div class='col-sm-12' align="right">
                * Item obrigatório 
            </div>
            <br>
        </div>
    </div>
</div>
<br>
<div>
    <table class="table table-striped table-bordered" id="tblResultado">
        <thead>
            <tr>
                <th>Ação</th>
                <th>Cód Lancamento</th>
                <th>Identificação</th>
                <th>Identificação do Lançamento</th>
                <th>Identificação do Documento</th>
                <th>Tipo do Documento</th>
                <th>Tipo de Lançamento</th>
                <th>Categoria(s)</th>
                <th>Planos Conta</th>
                <th>Grupo Origem do Lançamento</th>
                <th>Pago para / Recebido de</th>
                <th>Clientes</th>
                <th>Posto de Trabalho</th>
                <th>Contrato(s)</th>
                <th>Método de pagamento</th>
                <th>Dt. Faturamento</th>
                <th>Dt. Vencimento</th>
                <th>Vl. do Lançamento</th>
                <th>Lançar para a Empresa</th>
                <th>Status</th>
                <th>Observação</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <br>
</div>
<div class='row'>
    <div class='col-md-1'>
        &nbsp;
    </div>
    <div class='col-md-4'>
        <button type="button" class="btn btn-secondary btn-sm"  onclick='window.close()' id="cmdFechar">Fechar</button> 
        <button class="btn btn-primary btn-sm" id='cmdAddLinha'>Adicionar Linha</button>
    </div>
</div>
<br>