<?
require_once "../inc/php/header.php";
?>
<script src="auditoria_supervisao_postos_trabalho_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script>
function geoFindMe() {
    function success(position) {
      var ds_localizacao = position.coords.latitude +" "+ position.coords.longitude;
      $('#ds_localizacao').val(ds_localizacao)  
      alert(ds_localizacao)
    }
  
    function error() {
      alert("Não foi possível recuperar sua localização");
    }

    navigator.geolocation.getCurrentPosition(success, error);
}
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br>
            <h3>Supervisão Auditoria Posto de Trabalho</h3>
            <hr>
        </div>
    </div>
    <form id="form" class="form">
        <div class='row'>
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='leads_pk'>Posto de trabalho:&nbsp;</label>
                <select class="form-control form-control-sm" id="leads_pk" name="leads_pk">
                    <option></option>
                </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <input type='hidden' name='ds_localizacao' id='ds_localizacao'>
            <input type='hidden' name='qtd_campos' id='qtd_campos'>
            <input type='hidden' name='supervisao_auditoria_pk' id='supervisao_auditoria_pk'>
            <input type='hidden' name='v_pk' id='v_pk'>
            <div class='col-md-4'>
                <label for='auditoria_categorias_pk'>Categoria:&nbsp;</label>
                <select class="form-control form-control-sm" id="auditoria_categorias_pk" name="auditoria_categorias_pk">
                    <option></option>
                </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='auditoria_categoria_tipos_pk'>Formulário:&nbsp;</label>
                <select class="form-control form-control-sm" id="auditoria_categoria_tipos_pk" name="auditoria_categoria_tipos_pk">
                    <option></option>
                </select>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4'>
                  &nbsp;
            </div>
            <div class='col-md-4'>
                <label for='ds_obs_geral'>Observação Auditoria:&nbsp;</label>
                <textarea class='form-control form-control-sm' id='ds_obs_geral' name='ds_obs_geral'></textarea>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class='col-md-4'>
                    &nbsp;
                </div>
                <h3>
                    <div align="right" class='col-md-4'>
                        <span id="ds_form"></span>
                    </div>
                </h3>
                <hr>
            </div>
        </div>

        <div class="container">
            <div id="auditoria_categoria_form" name="auditoria_categoria_form">

            </div>
        </div>
        <div class="container_documentacao" id="container_documentacao">
            <div class="row">

                <div class="col-md-12">
                    &nbsp;
                    <br>
                    <h3>Documentos</h3>
                    <hr>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col-md-12" >
                        <button type="button" class="btn btn-primary" id="cmdIncluirDocumento">Incluir Documento</button>
                    </div>
                </div>
                <p>
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
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
                        <br>
                        <div class="row">
                            <div class="col-md-2">
                                &nbsp;
                            </div>

                            <div class='col-md-6'>
                                <div class="label-float">
                                    <!--<input type="text" id="ds_obs_doc" name="ds_obs_doc" placeholder=" "/>-->
                                    <!--<label for="agenda_ds_retorno">Observação:</label>-->
                                    <textarea  class=" form-control form-control-file" id="ds_obs_doc" name="ds_obs_doc"></textarea>
                                </div>
                                <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                                <input type="hidden" name="ds_documento" id="ds_documento"/>

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" align="center">
                <hr>
                <button type="button" class="btn btn-secondary" id="cmdCancelar">Cancelar</button>
                &nbsp;
                <button type="button" class="btn btn-primary" id="cmdEnviar">Salvar</button>
            </div>
        </div>
    </form>
</div>
<?
require_once "../inc/php/footer.php";
?>