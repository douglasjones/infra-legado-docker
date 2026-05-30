<?php
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);
?>

<script src="documentos_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<div class="container">  
    <div class="modal fade bd-example-modal-lg" id="janela_documentos" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="m-0 font-weight-bold text-primary">Lead - Documento</h6>
                    <div align="right">
                        <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-primary btn-sm" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Salvar</button>
                    </div>
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
                                <input id="fileupload"  type="file" enctype="multipart/form-data" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

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
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-5'>
                            <label for="ic_tipo_documento">Tipo Documento:</label>                
                            <select id="ic_tipo_documento" class="form-control form-control-sm" name="ic_tipo_documento">
                                <option value="1">Interno</option>
                                <option value="2">Acesso do Cliente</option>
                                <option value="3">Acesso do Colaborador</option>
                            </select>
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
                </div>
            </div>
        </div>
    </div>
</div>