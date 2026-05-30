<?
include_once "../inc/php/header.php";
?>
<script src="financeiro_import_lancamentos_cad.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
</head>
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Importar Arquivo</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Cancelar</button>   
                            &nbsp;
                            <button type="submit" class="btn btn-primary btn-sm" id="cmdIncluir">Enviar</button>                     
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id='form'>
                        <div class='row'>
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <span class="btn btn-success fileinput-button">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    <span>Escolha o Arquivo</span>
                                    <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivos_importLancamento.php">
                                    <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                                    <input type="hidden" name="ds_documento" id="ds_documento"/>
                                </span>
                                <br>
                                <br>
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <div id="files" class="files"></div>
                                <div class='row' id="alert_ds_documento" style="display:none">
                                    <div class='col-md-12'>
                                        <strong style="color: red">Por favor, escolha um arquivo .csv</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="obs">Observação:&nbsp;</label>
                                <textarea id="obs" class="form-control form-control-sm" name="obs"></textarea>
                            </div>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>