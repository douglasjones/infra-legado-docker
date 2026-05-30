<script src="compra_documento_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="modal fade bd-example-modal-lg"  id="janela_documentos">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" >
                        <div class="card-header py-3">
                            <div class="row">
                                <div class='col-md-6' align="left">
                                    <h6 class="font-weight-bold text-primary">Cadastro Documentos</h6>
                                </div>
                                <div class='col-md-6' align="right">
                                    <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                                    <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Salvar</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
        </div>
    </div>
</div>