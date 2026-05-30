<?
require_once "../inc/php/header.php";
?>
<script src="inc_impostos_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">    
    <div class="row">
        <div class="col-md-12">
            
             <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblImposto">
                <thead>
                    <tr>
                        <th>Cod</th>
                        <th>Empresa</th>
                        <th>Centro Custo</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Tipo Grupo</th>
                        <th>Tipo Operação</th>
                        <th>Pago </th>
                        <th>Ação</th>
                    </tr>
                </thead>              
            </table>
        </div>
    </div>
</div>
<form id="formImposto" class="formImposto">
    <div class="modal" tabindex="-1" role="dialog" id="modal_imposto">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Novo Lançamento</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados de Origem</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='empresa_modal_imposto_pk' name='empresa_modal_imposto_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Tipo Lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipo_lancamento_modal_imposto' name='tipo_lancamento_modal_imposto' requered/>
                                <option value=""></option>
                                <option value="1">Receita</option>
                                <option value="2">Despesa Fixa</option>
                                <option value="3">Despesa Variável</option>
                                <option value="4">Imposto</option>
                                <option value="5">Transferência</option>
                            </select>  
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_tipo_lancamento" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Tipo Lançamento</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Tipo Operação / Planos Conta:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipos_operacao_pk_imposto' name='tipos_operacao_pk_imposto' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_tipo_operacao" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Tipo Operação / Planos Conta</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <label for='ds_lancamento'>Identificação Origem:&nbsp;</label>
                            <input type="hidden" class='form-control form-control-sm' id="lancamento_imposto_pk" name="lancamento_imposto_pk"/> 
                            <input type="text" class='form-control form-control-sm' id="ds_lancamento_imposto" name="ds_lancamento_imposto"/> 
                        </div>
                    </div>  
                    <div class='row' id="alert_ds_lancamento" style="display:none">
                        <div class='col-md-8'>
                            <strong style="color: red">Por favor, informe Identificação Origem</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Grupo Origem do Lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_imposto' name='tipo_grupo_pk_imposto' requered/>
                                <option value=""></option>
                                <option value="1">Leads (Clientes)</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_imposto' name='grupo_leancamento_pk_imposto' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div> 
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_tipo_grupo" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Grupo Origem do Lançamento</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Centro de Custo</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div> 
                    <br>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Grupos Centro de Custo:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_centro_custo_pk_imposto' name='tipo_grupo_centro_custo_pk_imposto' requered/>
                                <option value=""></option>
                                <option value="1">Leads (Clientes)</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                                <option value="4">Centro de Custo</option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento'>Centro de Custo:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='grupo_lancamento_centro_custo_pk_imposto' name='grupo_lancamento_centro_custo_pk_imposto' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados de Valor e Data</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>
                    <br>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='vl_lancamento'>Valor:&nbsp;</label>
                            <input type="text" class='form-control form-control-sm' id="vl_lancamento_imposto" name="vl_lancamento_imposto"/> 
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='metodo_recebimento_pagamento'>&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='metodos_pagamento_pk_imposto' name='metodos_pagamento_pk_imposto' requered/>
                                <option ></option>
                            </select> 
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_valor" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Valor</strong>
                        </div>
                    </div>
                    <div class='row' id="alert_metodo" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Metodo Recebimento / Pagamento</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='dt_vencimento'>Data de Entrada:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" id="dt_vencimento_imposto" name="dt_vencimento_imposto"/>
                        </div>
                        <div class='col-md-5'>
                            <label for='dt_competencia'>Data de Competência / Referência:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" id="dt_competencia_imposto" name="dt_competencia_imposto"/>
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_dt_vencimento" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Data de Entrada</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados Bancário / Status</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>
                    <br>
                    <div class='row'>                        
                       <div class='col-md-4'>
                            <label for='contas_pk'>Conta Bancária:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='contas_bancarias_pk_imposto' name='contas_bancarias_pk_imposto' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_banco" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Conta Bancária</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='ic_status_pagamento_imposto' name='ic_status_pagamento_imposto' requered/>
                                <option value="1">Pago</option>
                                <option value="2">Pendente</option>
                                <option value="3">Aprovado</option>
                                <option value="4">Atrasado</option>
                                <option value="5">Cancelado</option>
                            </select>  
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_status" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Status</strong>
                        </div>
                    </div>
                    
                    <div class='row'>
                        <div class='col-md-6'>
                            <label for='dt_competencia'>Observação:&nbsp;</label>
                            <textarea class="form-control form-control-sm" id="n_documento_imposto" name="n_documento_imposto"></textarea>
                        </div>
                    </div>  
                     
                    <!--div class='row'>
                        <div class='col-md-2'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento'>Valor:&nbsp;</label>
                            <input type="text" class='form-control form-control-sm' id="vl_lancamento_imposto" name="vl_lancamento_imposto"/> 
                        </div>
                        <div class='col-md-4'>
                            <label for='contas_pkk'>Conta Bancária:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='contas_bancarias_pk_imposto' name='contas_bancarias_pk_imposto' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div-->  
                       
                      
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-primary" id="cmdSalvarImposto">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>



<?
require_once "../inc/php/footer.php";
?>
