<?
include_once "../inc/php/header.php";
?>
<script src="financeiro_conciliacao_banco_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>
</head>
<div class="container col-lg">
    <br>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Conciliação Bancária</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdCancelar">Cancelar</button>   
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Enviar</button>                     
                        </div>
                    </div>
                </div>
                <form id="form" class="form" method="POST" novalidate="novalidate" autocomplete="off" onsubmit="return false;">
                    <div class="card-body">
                        <div class="row" id='exibirEmpresaCad'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <input type="hidden" id="dt_periodo_ini">
                            <input type="hidden" id="dt_periodo_fim">
                            <div class='col-sm-6'>
                                <label for='bancos_pk'>Empresa(s):&nbsp;</label>
                                <select class='form-control form-control-sm'  id='empresas_pk' name='empresas_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row" id='exibirEmpresaEdit'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <input type="hidden" id="dt_periodo_ini">
                            <input type="hidden" id="dt_periodo_fim">
                            <div class='col-sm-6'>
                                <label for='bancos_pk'>Empresa(s):&nbsp;</label>
                                <select class='form-control form-control-sm'  id='edit_empresas_pk' name='edit_empresas_pk' disabled />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class='row' id='exibirContaCad'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-sm-6'>
                                <label for='bancos_pk'>Conta(s):&nbsp;</label>
                                <select class='form-control form-control-sm'  id='contas_pk' name='contas_pk' />
                                    <option></option>
                                </select> 
                            </div>
                        </div>
                        <div class='row' id='exibirContaEdit'>
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-sm-6'>
                                <label for='bancos_pk'>Conta(s):&nbsp;</label>
                                <select class='form-control form-control-sm'  id='edit_contas_pk' name='edit_contas_pk' disabled />
                                    <option></option>
                                </select> 
                            </div>
                        </div>
                        <div id='exibirSaldo'>
                            <div class='row'>
                            <div class='col-md-3'>
                                    &nbsp;
                                </div>
                                <div class='col-sm-2'>
                                    <label for='bancos_pk'>Período:&nbsp;</label>
                                    <input type='text' class='form-control form-control-sm'  id='periodo' name='periodo' disabled /> 
                                </div>
                                <div class='col-sm-2'>
                                    <label for='bancos_pk'>Saldo Conciliação:&nbsp;</label>
                                    <input type='text' class='form-control form-control-sm'  id='vl_saldo_conta' name='vl_saldo_conta' disabled />
                                    
                                </div>
                                <div class='col-sm-2'>
                                    <label for='bancos_pk'>Saldo Lançamentos:&nbsp;</label>
                                    <input type='text' class='form-control form-control-sm'  id='saldo_lancamento' name='saldo_lancamento'  disabled/>
                                    
                                </div>
                            </div>
                        </div>                        
                        <p>
                        <div id='exibirAnexo'>
                            <div class='row'>
                                <div class='col-md-3'>
                                    &nbsp;
                                </div>
                                <div class='col-md-5'>
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Escolha o Arquivo</span>
                                        <input id="fileupload"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">
                                        <input type="hidden" name="ds_nome_original" id="ds_nome_original"/>
                                        <input type="hidden" name="ds_documento" id="ds_documento"/>
                                    </span>
                                    <br>
                                    <br>
                                    <div id="progress" class="progress">
                                        <div class="progress-bar progress-bar-success"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row" id='exibirObsCad'>
                            <div class="col-md-3">
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                <label for="obs">Observação:&nbsp;</label>
                                <textarea id="obs" class="form-control form-control-sm" name="obs"></textarea>
                            </div>
                            
                        </div>
                        <div class="row" id='exibirObsEdit'>
                            <div class="col-md-3">
                                &nbsp;
                            </div>
                            <div class="col-md-6">
                                <label for="obs">Observação:&nbsp;</label>
                                <textarea id="obs" class="form-control form-control-sm" name="obs" disabled></textarea>
                            </div>
                            
                        </div>
                        <br>
                        <br>
                        <br>
                        <div id='exibirDatatable'>
                            <div class="row">
                                <div class='col-md-12' id="alert_button" style="display:none" align="right">
                                    <button type="button" class="btn btn-outline-primary" id="salvarConciliacaoLancamento">Salvar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h3> Conciliação</h3>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <h3>Lançamentos</h3>
                                    <hr>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='col-md-12' id="alert_conciliacao" align="left">
                                    <strong style="color: blue"> <h6>* Por favor, selecione Conciliação</h6></strong>
                                </div>
                                <div class='col-md-12' id="alert_lancamento" style="display:none" align="right">
                                    <strong style="color: blue"><h6> * Por favor, selecione Lançamentos</h6></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cód</th>
                                                <th>Data</th>
                                                <th>Tipo</th>
                                                <th>Valor</th>
                                                <th>Cód verificação</th>
                                                <th>Estabelecimento</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultadoReceitaDespesa">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cód</th>
                                                <th>Data</th>
                                                <th>Tipo</th>
                                                <th>Valor</th>
                                                <th>Cód verificação</th>
                                                <th>Estabelecimento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
                </form>
                <div class="modal fade bd-example-modal-lg" id="janela_modal" >
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="janela_modalLabel">Dados</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class='col-md-3'>
                                        <label for='data'>Código: </label>
                                        <input type="hidden" id="financeiro_conciliacao_lancamentos_pk">
                                        <b><span  id='codigo_modal' name='codigo_modal'></span></b>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='data'>Data: </label>
                                        
                                        <b><span  id='data_modal' name='data_modal'></span></b>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='data'>Tipo: </label>
                                        
                                        <b><span  id='tipo_modal' name='tipo_modal'></span></b>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='data'>Valor: </label>
                                        
                                        <b><span  id='valor_modal' name='valor_modal'></span></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-3'>
                                        <label for='data'>Cód Veri.: </label>
                                        
                                        <b><span  id='codigo_veri_modal' name='codigo_veri_modal'></span></b>
                                    </div>
                                    <div class='col-md-9'>
                                        <label for='data'>Estabelecimento: </label>
                                        
                                        <b><span  id='estabelecimento_modal' name='estabelecimento_modal'></span></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class='col-md-9'>
                                        <label for='data'>Observação: </label>
                                        <textarea id="obs_modal" class="form-control form-control-sm" name="obs_modal"></textarea>
                                    </div>
                                    <div class='col-md-3'>
                                        <label for='data'>Status: </label>
                                        <select class='form-control form-control-sm'  id='ic_status_modal' name='ic_status_modal' />
                                            <option value=''></option>
                                            <option value='2'> Verificação Pendete</option>
                                            <option value='1'> Conciliado</option>
                                            <option value='3'>Não identificado </option>
                                        </select>
                                    </div>
                                </div>
                            </div>                                                    
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                    <button type="submit" class="btn btn-primary" id="cmdEnviarModal"  name="cmdEnviarModal">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>
    </div>
</div>