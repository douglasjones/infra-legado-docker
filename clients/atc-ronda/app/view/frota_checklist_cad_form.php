<?
require_once "../inc/php/header.php";
?>
<script src="frota_checklist_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-6">
                <div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Checklist</h6>   
                        </div>
                        <div class="col-md-6" align="right">
                            <button class="btn btn-secondary btn-sm" id="cmdCancelar" name="cmdCancelar">Voltar</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
                            <div class="col-md-12">
                                &nbsp;
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4">
                                    <label for='id_veiculo'> Id Veículo:</label>
                                    <input class="form-control form-control-sm" name="id_veiculo" id="id_veiculo" type='text'>
                                    <input type='hidden' name='frota_pk' id='frota_pk'>
                                    <input type='hidden' name='frota_checklist_pk' id='frota_checklist_pk'>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-5">
                                    &nbsp;
                                </div>
                                <div class="col-md-4">
                                    &nbsp;
                                    <button class="btn btn-primary" id="cmdBuscarVeiculo" name="cmdBuscarVeiculo">Buscar Veiculo</button>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4">
                                    <label for='condutores_pk'> Condutor:</label>
                                    <select class="form-control form-control-sm" name="condutores_pk" id="condutores_pk" type='text'>
                                        <option></option>
                                    </select> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    &nbsp;
                                </div>
                                <div class="col-md-4">
                                    <label for='leads_pk'> Posto de Trabalho:</label>
                                    <select class="form-control form-control-sm" name="leads_pk" id="leads_pk" type='text'>
                                        <option></option>
                                    </select>
                                    <input type='hidden' name='qtd_campos' id='qtd_campos'>
                                </div> 
                            </div>
                            <br>  
                            <div class='row'>
                                <div class='col-md-12' id='conteiner_forms'>
                                    <div class="row">
                                        <div class="col-md-12">
                                            &nbsp; <h5>Último Checklist</h5>
                                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                            <div id='formUltimoChecklist' name='formUltimoChecklist'>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <p>
                                    &nbsp; 
                                    </p>
                                    <div class="row">
                                        <div class="col-md-4">
                                            &nbsp;
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-primary" id="cmdRepetirChecklist" name="cmdRepetirChecklist">Repetir Ult Checklist</button>
                                            &nbsp;
                                            <button class="btn btn-primary" id="cmdNovoChecklist" name="cmdNovoChecklist">&nbsp;Novo Checklist&nbsp;</button>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12" id='div_none'> 
                                            &nbsp; <h5>Novo Checklist</h5>
                                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                            <div id='formNovoChecklist' name='formNovoChecklist'>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <br>
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
                                                            <label for='ds_obs_doc'><b>Observação:</b></label>
                                                            <textarea class="form-control form-control-sm" name="ds_obs_doc" id="ds_obs_doc"> </textarea>
                                                            <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                                                            <input type="hidden" name="ds_documento" id="ds_documento"/>

                                                        </div>
                                                    </div>                                                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" id="cmdCancelarDocumento" data-dismiss="modal">Fechar</button>
                                                        <button type="button" class="btn btn-primary" id="cmdEnviarDocumento"  name="cmdEnviarDocumento">Enviar</button>
                                                    </div>
                                                </div>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            &nbsp;
                                        </div>
                                    </div>                                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" id="cmdCancelar">Fechar</button>
                                        <button type="button" class="btn btn-primary" id="cmdEnviar"  name="cmdEnviar">Enviar</button>
                                    </div>
                                </div>
                            </div>  
                        </div>  
                    </div>
                </div>
            </div>
        </div>   
    </div>
</div>
<?
require_once "../inc/php/footer.php";
?>
