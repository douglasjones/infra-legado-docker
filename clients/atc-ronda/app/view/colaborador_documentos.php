<?
require_once "../inc/php/header.php";
?>

<script src="colaborador_documentos_res.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">


<div class="row">
    <div class="col-md-2" align="center">
        <button type="button" class="btn btn-primary" id="cmdIncluirDocumento">Incluir Documento</button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblDocumentos">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Documento</th>
                    <th>Observação</th>
                    <th>Nome Original</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="janela_documentos" >
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="janela_contatosLabel">Novo Documento</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">                                    
            <div class="row">
                <div class='col-md-2'>
                    &nbsp;
                </div>
                
                <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                
                <div class='col-md-8'>
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Escolha o Arquivo</span>
                        <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

                    </span>
                    <br>
                    <div id="alert_documento" style="display:none" >
                        <strong style="color: red">Selecione um arquivo</strong>
                    </div>
                    <br>
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <div id="files" class="files"></div>
                    <!---->
                    <div class="row" id="rowFotos"></div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>
                <div class="col-md-8">
                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblArquivos">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nome Original</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>   
            <div class="row">
                <div class="col-md-2">
                    &nbsp;
                </div>

                <div class='col-md-6'>
                    <label for='ds_obs_doc'>Observação: </label>
                    <input type='text' class='form-control form-control-sm'  id='ds_obs_doc' name='ds_obs_doc'>
                    <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                    <input type="hidden" name="ds_documento" id="ds_documento"/>

                </div>
            </div>                                                    
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Enviar</button>
            </div>
        </div>
    </div>
</div>
</div> 



<?
require_once "../inc/php/footer.php";
?>