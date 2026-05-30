<script src="financeiro_contas_pagar_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<form id="form" class="form">
    <div class="modal" tabindex="-1" role="dialog" id="modal_lancamento">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Novo <b>Lançamento</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Indentificação do Lançamento</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                     
                        </div>
                    </div>  
                    <p> 
                    <div class='row'>
                        <div class='col-md-10'>
                            <label for='ds_lancamento'>Identificação do Lançamento:&nbsp;</label>
                            <input type="text" class='form-control form-control-sm' maxlength="80" id="ds_lancamento_modal" name="ds_lancamento_modal"/> 
                            <input type="hidden" id="lancamento_pk" value="" >
                        </div>
                    </div>            
                    <div class='row' id="alert_ds_lancamento_modal" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe a Identificação do Lançamento</strong>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            <label for='ds_num_documento_modal'>Identificação do Documento:&nbsp;</label>
                            <input type="text" class='form-control form-control-sm' maxlength="80" id="ds_num_documento_modal" name="ds_num_documento_modal"/> 
                        </div>
                        <div class='col-md-5'>
                            <label for='ic_tipo_num_documento'>Tipo do Documento:&nbsp;</label> 
                            <select class='form-control form-control-sm'  id='ic_tipo_num_documento' name='ic_tipo_num_documento'>
                                <option value=""></option>                               
                                <option value="1">Num Boleto</option>
                                <option value="2">Num NF</option>
                            </select>
                        </div>
                    </div> 
                    <p>       
                    <div class='row'>   
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Tipo de Lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipo_lancamento_modal_pk' name='tipo_lancamento_modal_pk' requered>
                                <option value=""></option>                               
                                <option value="1">Receita</option>
                                <option value="7">Custo Fixo</option>
                                <option value="8">Custo Variável</option>
                                <option value="2">Despesa Fixa</option>
                                <option value="3">Despesa Variável</option>
                                <option value="4">Imposto</option>
                                <option value="5">Transferência</option>
                                <option value="6" id="exibir_opc_caixinha">Caixinha</option>
                            </select>  
                        </div>                     
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Categoria(s):&nbsp;</label>
                            <select class='form-control form-control-sm'  id='categoria_operacao_modal_pk' name='categoria_operacao_modal_pk' requered>
                                <option value=""></option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Planos Conta:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipos_operacao_modal_pk' name='tipos_operacao_modal_pk' requered/>
                                <option value="">Seleccione um item</option>
                            </select>  
                        </div>
                    </div>  
                    <!--Alert--> 
                    <div class='row' id="alert_tipo_lancamento_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe o Tipo de Lançamento</strong>
                        </div>
                    </div>  
                    <div class='row' id="alert_categoria_operacao_modal_pk" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe a Categoria</strong>
                        </div>
                    </div> 
                    <div class='row' id="alert_tipos_operacao_modal_pk" style="display:none">
                        <div class='col-md-8'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe o Plano de Contas</strong>
                        </div>
                    </div>
                    <!--Fim Alert-->
                    <br>     
                    <div class="row">                        
                        <div class="col-md-12">
                            <h5><div id="label_lancamento"></div></h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>                     
                    <p>           
                    <div class='row'>
                        <div class='col-md-5'>
                            <label for='tipo_grupo_pk'>Grupo Origem do Lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='tipo_grupo_modal_pk' name='tipo_grupo_modal_pk' requered/>
                                <option value=""></option>
                                <option value="1">Cliente(s)</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                                <!--<option value="4">Centro(s) de Custo(s)</option>-->
                            </select>  
                        </div>
                    </div> 
                    <!--aAlert-->
                    <div class='row' id="alert_tipo_grupo_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe o Grupo de Origem</strong>
                        </div>
                    </div>
                    <!--fim-->
                    <div class='row' id="div_grupos_lancamento_lead" style="display:none">
                        <p>
                        <div class='col-md-4'>
                            <label for='pago_para'>Pago para / Recebido de:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='leads_clientes_modal_pk' name='leads_clientes_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>    
                        <div class='col-md-4'>
                            <label for='posto_trabalho_leads'>Posto de Trabalho:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='leads_posto_trabalho_modal_pk' name='leads_posto_trabalho_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                        <div class='col-md-4'>
                            <label for='contratos_leads'>Contrato(s):&nbsp;</label>
                            <select class='form-control form-control-sm'  id='contratos_modal_pk' name='contratos_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                    </div>   
                    <!--aAlert-->
                    <div class='row' id="alert_leads_clientes_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Pago para / Recebido de</strong>
                        </div>
                    </div>              
                    <!--fim-->
                    <div class='row'>
                        <div class='col-md-10'>
                            <label for='ds_lancamento' id="label_lancamento" ></label>
                        </div>
                    </div> 
                    <div class='row' id="div_grupos_lancamento_colaborador" style="display:none">
                        <p>
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Pago para / Recebido de:&nbsp;</label>
                            <select class='form-control form-control-sm '  id='colaborador_modal_pk' name='colaborador_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div> 
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Cliente:&nbsp;</label>
                            <select class='form-control form-control-sm '  id='grupo_lancamento_centro_custo_colaborador_pk' name='grupo_lancamento_centro_custo_colaborador_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>                        
                        

                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Posto de Trabalho:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='colaborador_posto_trabalho_modal_pk' name='colaborador_posto_trabalho_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Contrato(s):&nbsp;</label>
                            <select class='form-control form-control-sm'  id='colaborador_contratos_modal_pk' name='colaborador_contratos_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                    </div>   
                    <!--aAlert-->
                    <div class='row' id="alert_colaborador_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Pago para / Recebido de</strong>
                        </div>
                    </div>              
                    <!--fim-->                    
                    <div class='row' id="div_grupos_lancamento_fornecedor" style="display:none">
                        <p>
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Pago para / Recebido de:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='fornecedor_modal_pk' name='fornecedor_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>    
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Cliente:&nbsp;</label>
                            <select class='form-control form-control-sm '  id='grupo_lancamento_centro_custo_fornecedor_pk' name='grupo_lancamento_centro_custo_fornecedor_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>     
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Posto de Trabalho:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='fornecedor_posto_trabalho_modal_pk' name='fornecedor_posto_trabalho_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                        <div class='col-md-4'>
                            <label for='tipo_grupo_pk'>Contrato(s):&nbsp;</label>
                            <select class='form-control form-control-sm'  id='fornecedor_contratos_modal_pk' name='fornecedor_contratos_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                    </div> 
                     <!--aAlert-->
                    <div class='row' id="alert_fornecedor_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Pago para / Recebido de</strong>
                        </div>
                    </div>              
                    <!--fim-->       
                    <br>  
                    <div id="listar_dados_bancarios_colaborador"></div>
                        
            
                    <div  id='divExibirCentroCustol'>
                        <div class="row" >
                            <div class="col-md-12">
                                <h5>Centro de Custo</h5>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>
                        </div>      
                        <br>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label for='tipo_grupo_pk'>Grupos Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='tipo_grupo_centro_custo_pk_receita' name='tipo_grupo_centro_custo_pk_receita'>
                                    <option value=""></option>
                                    <option value="1">Leads (Clientes)</option>
                                    <option value="2">Colaboradores</option>
                                    <option value="3">Fornecedores</option>
                                    <option value="4">Centro de Custo</option>
                                </select>  
                            </div>
                            <div class='col-md-4'>
                                <label for='vl_lancamento'>Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='grupo_lancamento_centro_custo_pk_receita' name='grupo_lancamento_centro_custo_pk_receita'>
                                    <option value=""></option>
                                </select>  
                            </div>
                            
                        </div>
                        <br>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h5>Datas e Valor</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Parcelas</label>
                            <div id="combo_qtde_parcelas_pk"></div>                           
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Método de pagamento</label>
                            <select class='form-control form-control-sm'  id='metodos_pagamento_modal_pk' name='metodos_pagamento_modal_pk' requered/>
                                <option ></option>
                            </select> 
                        </div>
                    </div>    
                    <div class='row' id="alert_metodos_pagamento_modal_pk" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Método de Pagamento</strong>
                        </div>
                    </div>     

                    <p>
                    <div class='row'>
                        <div class='col-md-12'>
                            <table class='table table-striped table-bordered nowrap' style='width:100%' id='tbParcelas'>
                                <thead>
                                    <tr>
                                        <th>Parcela</th>
                                        <th>Dt Faturamento</th>
                                        <th>Dt Vencimento</th>
                                        <th>Vl do Lançamento:</th>
                                    </tr>
                                </thead>                                
                                    <tr>
                                        <td >
                                            Parcela  <text id='ds_parcela'> 1 <text> <input type='hidden' id='parcela_pk"+v_linha+"' value='"+v_linha+"' />                                            
                                        </td>
                                        <td>
                                            <input type='text' class="form-control form-control-sm" id="dt_faturamento_modal1" name="dt_faturamento_modal" maxlength="10"/>
                                        </td>
                                        <td>
                                            <input type='text' class="form-control form-control-sm" id="dt_vencimento_modal1" name="dt_vencimento_modal" maxlength="10"/>
                                        </td>
                                        <td>
                                            <input type="text" class='form-control form-control-sm' id="vl_lancamento_modal1" name="vl_lancamento_modal"/> 
                                        </td>
                                    </tr>    
                                <tbody id="div_datas_valores_pagamento">     
                                
                                </tbody>
                            </table>
                        </div>    
                    </div>
                    <!--aAlert-->
                    <div class='row' id="alert_dt_vencimento_modal" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div> 
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Dt Vencimento</strong>
                        </div>
                    </div>      
                    <!--aAlert-->
                    <div class='row' id="alert_vl_lancamento_modal" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe Vl do Lançamento</strong>
                        </div>
                    </div>   
                    <!--fim-->    
                    <br>
                    <div class="row"> 
                        <div class='col-md-12'>
                            <br>
                            <h6>
                                <b>Documentos</b>
                            </h6>
                            
                        <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 1em;'> 
                        </div>
                    </div> 
                    <div class="row" >
                        <input type="hidden" name="ds_documento_lancamento" id="ds_documento_lancamento"/>
                        <input type="hidden" name="ds_nome_original_lancamento" id="ds_nome_original_lancamento"/>

                        <div class='col-md-12'>
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>Incluir Documento</span>
                                
                                <input id="fileuploadLancamento"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">
                            </span>
                            <br>
                            <div id="alert_documento" style="display:none" >
                                <strong style="color: red">Selecione um arquivo</strong>
                            </div>
                            <br>
                            <div id="progressLancamento" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <div id="files" class="files"></div>
                            <!---->
                            <div class="row" id="rowFotos"></div>
                        </div>
                    </div> 
                    <div class="row"> 
                        <div class='col-md-12'>
                            &nbsp;
                        </div>
                        <div class='col-md-12'>
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id='tblDocumentosLancamento'>
                                <thead>
                                    <tr>
                                        <th>Cód</th>
                                        <th>Documento</th>
                                        <th>Nome Original</th>
                                        <th>Ação</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-md-12">
                            <h5>Empresa e Conta / Status</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>
                    <p>
                    <div class='row' id="div_lancar_empresa">   
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Lançar para a Empresa:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='empresa_modal_pk' name='empresa_modal_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>                                     
                        <div class='col-md-4' id="div_conta_bancarias">
                            <label for='contas_pk'>Conta do Bancária:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='contas_bancarias_modal_pk' name='contas_bancarias_modal_pk' />
                                <option value=""></option>
                            </select>  
                        </div>
                    </div> 
                    <!--aAlert-->
                    <div class='row' id="alert_empresa_modal_pk" style="display:none">
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe a Empresa para Lançamento</strong>
                        </div>
                    </div>     
                    <div class='row' id="alert_contas_bancarias_modal_pk" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>                    
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe a Conta para Lanamento</strong>
                        </div>
                    </div>              
                    <!--fim-->        
                    <br>    
                
                    <div class='row' >
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                            <select class='form-control form-control-sm'  id='ic_status_pagamento_modal' name='ic_status_pagamento_modal' requered>
                                <option value=""></option>
                                <option id="exibir_pago" value="1">Pago</option>
                                <option value="2">Pendente</option>
                                <option value="3">Aprovado</option>
                                <option value="4">Atrasado</option>
                                <option value="5">Cancelado</option>
                            </select>  
                        </div>
                        <div class='col-md-4' id="exibir_dt_modal">
                            <label for='dt_pagamento' >Dt Pagamento:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" maxlength="10" id="dt_pagamento_modal" name="dt_pagamento_modal"/>
                        </div>
                    </div>                    
                    <!--aAlert-->             
                    <div class='row' id="alert_ic_status_pagamento_modal" style="display:none">                          
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe o Status</strong>
                        </div>
                    </div>      
                    <div class='row' id="alert_dt_pagamento_modal" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>                    
                        <div class='col-md-6'>
                            <strong style="color: red">Por favor, informe a Dt de Pagamento</strong>
                        </div>
                    </div>    
                    <!--fim-->                           
                    <div class='row'>
                        <div class='col-md-10'>
                            <label for='dt_competencia'>Observação:&nbsp;</label>
                            <textarea class="form-control form-control-sm" id="obs_lancamento_modal" name="obs_lancamento_modal"></textarea>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="button" class="btn btn-primary" id="btnSalvarLancamento">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>
