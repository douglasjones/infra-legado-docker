<?php
require_once "../inc/php/header.php";
?>

<script src="lead_main_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>


.label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 350px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  -webkit-appearance:none;
  border-radius:0;
}

.label-float input:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input::placeholder{
  color:transparent;
}

.label-float label{
  pointer-events: none;
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 13px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
}

.label-float input:required:invalid + label{
  color: red;
}
.label-float input:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input:focus + label,
.label-float input:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}


</style>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h4>Leads - Painel Principal</h4>
        </div>    
    </div>
    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="dados" role="tabpanel" aria-labelledby="dados-tab">
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-8'>
                    <label for='ds_lead'>Nome do Lead:&nbsp;</label>
                    <div id="ds_lead" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-3'>
                    <label for='ds_razao_social'>Razão Social:&nbsp;</label>
                    <div id="ds_razao_social" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-3'>
                    <label for='ds_cpf_cnpj'>Cpf/Cnpj:&nbsp;</label>
                    <div id="ds_cpf_cnpj" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-2'>
                    <label for='ds_ie'>IE:&nbsp;</label>
                    <div id="ds_ie" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>

                <div class='col-md-8'>
                    <label for='ds_endereco'>Endereço:&nbsp;</label>
                    <div id="ds_endereco" class='form-control form-control-sm'></div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-1'>
                    <label for='ds_numero'>Nr:&nbsp;</label>
                    <div id="ds_numero" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-4'>
                    <label for='ds_complemento'>Complemento:&nbsp;</label>
                    <div id="ds_complemento" class='form-control form-control-sm'></div>
                </div>

                <div class='col-md-3'>
                    <label for='ds_cep'>CEP:&nbsp;</label>
                    <div id="ds_cep" class='form-control form-control-sm'></div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-3'>
                    <label for='ds_bairro'>Bairro:&nbsp;</label>
                    <div id="ds_bairro" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-3'>
                    <label for='ds_cidade'>Cidade:&nbsp;</label>
                    <div id="ds_cidade" class='form-control form-control-sm'></div>
                </div>

                <div class='col-md-2'>
                    <label for='ds_uf'>UF:&nbsp;</label>
                    <div id="ds_uf" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-2'>
                    <label for='ds_tel_lead'>Telefone:&nbsp;</label>
                    <div id="ds_tel_lead" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-2'>
                    <label for='ds_fax'>Fax:&nbsp;</label>
                    <div id="ds_fax" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-4'>
                    <label for='ds_email_lead'>Email:&nbsp;</label>
                    <div id="ds_email_lead" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='ds_site'>Site:&nbsp;</label>
                    <div id="ds_site" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-2'>
                    <label for='n_qtde_torres'>Qtde Torres:&nbsp;</label>
                    <div id="n_qtde_torres" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-2'>
                    <label for='ic_cliente'>Cliente:&nbsp;</label>
                    <div id="ic_cliente" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-4'>
                    <label for='ds_supervisor'>Supervisor:&nbsp;</label>
                    <div id="ds_supervisor" class='form-control form-control-sm'></div>
                </div>
                <div class='col-md-4'>
                    <label for='ds_responsavel'>Responsavel Comercial:&nbsp;</label>
                    <div id="ds_responsavel" class='form-control form-control-sm'></div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-2'>
                    &nbsp;
                </div>
                <div class='col-md-8'>
                    <label for='ds_obs'>Observação:&nbsp;</label>
                    <textarea class='form-control form-control-sm' id="ds_obs" disabled></textarea>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <h4>Contatos</h4>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <div class="row">
            <div class="col-md-12" >
                <table class="table table-striped table-bordered nowrap " style="width:100%;" id="tblContatos" >
                    <thead>
                        <tr>
                        <th>Código</th>
                        <th>Contato</th>
                        <th>Email</th>
                        <th>Cel</th>
                        <th>Whatsapp</th>
                        <th>ic_whatsapp</th>
                        <th>Tel</th>
                        <th>Função</th>
                        <th>cargos_pk</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        </p>
        <div class="row">
            <div class="col-md-12" align="center">
                <button type="button" class="btn btn-primary" id="cmdEditarLead">Editar Lead</button>
            </div>
        </div>
        <p>
        <div class="row">
            <div class="col-md-12" >
                <h4><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirOc()"></i> &nbsp;Ocorrência(s)</h4>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <div id="exibir_oc" style="display:none">
            <?php  include("inc_ocorrencia_res_form.php"); ?>
        </div>
    
        <br>
        <div class="row">
            <div class="col-md-12">
                <h4><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirProcesso()"></i> &nbsp;Processo Operacional</h4>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <div id="exibir_processo" style="display:none">  
            <p>    
            <div class="row">
                <div class="col-md-12" >
                    <button type="button" class="btn btn-primary" id="cmdIncluirProcesso">Incluir Processo</button>
                </div>
            </div>
            <p> 
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblProcessos">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Processo</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div> 
            <hr>
        </div>          
        <form id="form_processo" class="form">
            <div class="modal fade bd-example-modal-lg" id="janela_processos" >
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                                <div class='row'>
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='processos_pk'>Processo Operacional:&nbsp;</label>
                                        <select class='form-control form-control-sm'  id='processos_pk' name='processos_pk'/>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button type="submit" class="btn btn-primary" id="cmdEnviarProcesso"  name="cmdEnviarProcesso">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        <div class="row">
            <div class="col-md-12">
                <h4><i class="fa fa-angle-down" aria-hidden="true" style="font-size: 30px;"  onclick="fcExibirDocumeto()"></i> &nbsp;Documentos</h4>
            </div>
        </div>
        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
        <p>
        <div id="exibir_documento" style="display:none">
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
            <div class="col-md-12" align="Right">
                <button type="button" class="btn btn-secondary" id="cmdVoltar">Retornar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                &nbsp;
            </div>
        </div>

 
    </div>
</div>    

<?php
require_once "../inc/php/footer.php";
?>
