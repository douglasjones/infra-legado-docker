<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<script src="contrato_operacional_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<style>
@import "bourbon";
      .label-float{
  position: relative;
  padding-top: 13px;
}

.label-float input[type=text]{
  border: 0;
  border-bottom: 2px solid lightgrey;
  outline: none;
  min-width: 300px;
  font-size: 16px;
  transition: all .3s ease-out;
  -webkit-transition: all .3s ease-out;
  -moz-transition: all .3s ease-out;
  
  border-radius:0;
}

.label-float input[type=text]:focus{
  border-bottom: 2px solid #3951b2;
}

.label-float input[type=text]:placeholder{
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

.label-float input[type=text]:required:invalid + label{
  color: red;
}
.label-float input[type=text]:focus:required:invalid{
  border-bottom: 2px solid red;
}
.label-float input:required:invalid + label:before{
  content: '*';
}
.label-float input[type=text]:focus + label,
.label-float input[type=text]:not(:placeholder-shown) + label{
  font-size: 13px;
  margin-top: 0;
  color: #3951b2;
}
.oc_modal{
    cursor:pointer;
}
.doc_modal{
    cursor:pointer;
}
.processo_modal{
    cursor:pointer;
}

</style>
<div class="container">
    <form id="form_contrato" class="form">
        <!-- Inicio janeja modal para CONTRATOS -->
        <div class="modal fade bd-example-modal-lg"  id="janela_contratos">
    
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" >
                    <div class="modal-header">
                        <div class='col-md-7'>
                            <h5>Novo Contrato / Aditivo / Serviço(s) Extra(s)</h5>
                        </div>    
                        <div class='col-md-1'>
                           &nbsp;
                        </div>  
                        <div class='col-md-4'>
                            <button type="button" class="close" onclick='fcFecharModalContrato()' aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>    
                    </div>
                    <form id="form_contato">
                        <div class="modal-content bd-example-modal-lg-12">
                            <div class="modal-body" >
                                <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Empresa / Posto de Trabalho</b>&nbsp;</label>
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                <div class="row">
                                    <div class='col-md-4'>
                                        <label for='ic_contrato'>Empresa:&nbsp;</label>
                                        <select id="empresas_pk" name="empresas_pk" class="form-control form-control-sm">
                                        </select>
                                    </div> 
                                     <!--<div class='col-md-4'> 
                                        <label for='ic_contrato'>Posto de Trabalho:&nbsp;</label>
                                        <select id="leads_pk_cad_form" name="leads_pk" class="form-control form-control-sm">
                                        </select>
                                        <input type='hidden'  id="processos_pk_cad_form" name="processos_pk_cad_form"/>
                                        <input type='hidden'  id="processos_etapas_pk_1" name="processos_etapas_pk_1"/>
                                        ///<label for='ic_contrato'>Posto de Trabalho:&nbsp;</label>
                                        ///<select id="leads_pk_cad_form" name="leads_pk_cad_form" class="form-control form-control-sm">
                                        ///</select>
                                        ///<input type='hidden'  id="processos_pk_cad_form" name="processos_pk_cad_form"/>
                                        ///<input type='hidden'  id="processos_etapas_pk_1" name="processos_etapas_pk_1"/>
                                    </div>-->
                                   
                                    <div class='col-md-4'>
                                        <label for='ds_uf'>Cliente:</label>
                                        <select id="leads_clientes_cad_pk" class='form-control form-control-sm chzn-select' name="leads_clientes_cad_pk">
                                            <option ></option>
                                        </select>
                                    </div>
                        
                            
                                    <div class='col-md-4'>
                                        <label for='ds_uf'>Posto de Trabalho:</label>
                                        <select id="leads_pk_cad_form" class='form-control form-control-sm chzn-select' name="leads_pk_cad_form">
                                            <option ></option>
                                        </select>
                                        <input type='hidden'  id="processos_pk_cad_form" name="processos_pk_cad_form"/>
                                        <input type='hidden'  id="processos_etapas_pk_1" name="processos_etapas_pk_1"/>
                                    </div>
                                                            
                                </div>
                                <div class='row' id="alert_empresa" style="display:none">                                    
                                    <div class='col-md-4'>
                                        <strong style="color: red">Por favor, selecione Empresa</strong>
                                    </div>
                                    <br>
                                </div>
                                <div class='row' id="alert_posto" style="display:none">
                                    <div class='col-md-4'>
                                        &nbsp;
                                    </div>    
                                    <div class='col-md-4'>
                                        <strong style="color: red">Por favor, selecione Posto de Trabalho</strong>
                                    </div>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class='col-md-6'>
                                        <label for='ic_contrato'>Identificação Contrato:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' id='ds_identificacao_area' name='ds_identificacao_area'>
                                    </div>                                        
                                </div>
                                <p>
                                <!--Periodo do contrato-->    
                                <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Período Contrato</b>&nbsp;</label>                                        
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                               
                                <div class="row">
                                    <input type='hidden'   id='contratos_pk' name='contratos_pk' value=''>
                                    <div class='col-md-4'>
                                        <label for='dt_inicio_contrato'>Data Início: </label>
                                        <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_inicio_contrato' name='dt_inicio_contrato'>
                                    </div>
                                    <div class='col-md-4'>
                                        <label for='dt_fim_contrato'>Data Fim: </label>
                                        <input type='text' class='form-control form-control-sm' maxlength="10"  id='dt_fim_contrato' name='dt_fim_contrato'>
                                    </div>                                                   
                                </div>
                                <div class='row' id="alert_data" style="display:none">                                    
                                    <div class='col-md-8'>
                                        <strong style="color: red">Por favor, Informe Data Início de Fim</strong>
                                    </div>
                                </div>
                                <p>
                                <!--Cancelamento-->    
                                <div id='exibir_cancelamento' style='display:none'>                                    
                                    <div class="row">
                                        <div class='col-md-8'>
                                            <label for='ic_contrato'><b>Cancelamento Contrato</b>&nbsp;</label>
                                        </div>                                                             
                                    </div>
                                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                                   
                                    <div class='row'>
                                        <div class="col-md-2">
                                            <label for='dt_inicio_contrato'>Cancelar :</label>
                                            <input type='checkbox'  maxlength="10"  id='dt_cancelamento_contrato' name='dt_cancelamento_contrato'>
                                        </div>
                                        <div class='col-md-4' id="exibir_motivo_cancelamento_contrato">
                                            <label for='dt_previsao_fechamento'>Motivo Cancelamento: </label>
                                            <input type='text' class='form-control form-control-sm' maxlength="10"  id='ds_obs_motivo_cancelamento_contrato' name='ds_obs_motivo_cancelamento_contrato'>
                                        </div>
                                    </div>
                                    <p>
                                </div>    
                                <!--Tipo de Contrato-->
                                <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Tipo de Contrato(s) e Serviço(s) Extra(s)</b>&nbsp;</label>
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                                     
                               
                                <div class="row">
                                    <div class='col-md-4'>
                                        <label for='ic_contrato'>Contrato Novo:&nbsp;</label>
                                        <input type='radio'  id="ic_contrato" name="ic_contrato"/>
                                    </div>                                                             
                                </div>
                                <div class="row">                                                           
                                    <div class='col-md-5'>
                                        <label for='ic_aditivo'>Contrato Aditivo:&nbsp;</label>
                                        <input type='radio'  id="ic_aditivo" name="ic_aditivo"/>
                                    </div>
                                    <div class='col-md-5' id="exib_contrato_pai">
                                        <label for='contrato_pai_pk'>Contrato Original: </label>

                                        <select class='form-control form-control-sm'  id='contrato_pai_pk' name='contrato_pai_pk'>
                                            <option></option>
                                        </select>
                                    </div>                                    
                                </div>
                                <div class="row" id="exib_contrato_pai">  
                                    
                                    <div class='col-md-5'>
                                        <label for='ic_aditivo'>Serviço Extra:&nbsp;</label>
                                        <input type='radio'  id="ic_servico_extra" name="ic_servico_extra"/>
                                    </div>                                    
                                </div>
                                <div class="row">                                                         
                                    <div class='col-md-2'>
                                       &nbsp;
                                       <div id="input"></div>
                                    </div>
                                    <div class='col-md-4' id="alert_contrato_pai" style="display:none" >
                                        <strong style="color: red">Selecione o Contrato Original</strong>
                                    </div>
                                </div>
                          
                                <div id='exibir_servico_extra'>                                   
                                   <div class="row">
                                       <div class='col-md-8'>
                                           <label for='ic_contrato'><b>Dados Financeiros</b>&nbsp;</label>
                                       </div>                                                             
                                   </div>
                                   <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                              
                                    <div class="row">
                                        <div class='col-md-4'>
                                            <label for='ic_contrato'>Lançar no Financeiro:&nbsp;</label>
                                            <select class='form-control form-control-sm'  id='ic_lancar_financeiro' name='ic_lancar_financeiro'>
                                                <option></option>
                                                <option value="1">Sim</option>
                                                <option value="2">Não</option>
                                            </select>
                                        </div> 
                                        <div class='col-md-4'>
                                            <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Método Pagamento</label>
                                            <select class='form-control form-control-sm'  id='metodos_pagamento_pk' name='metodos_pagamento_pk'/>
                                                <option ></option>
                                            </select> 
                                        </div>
                                        <div class='col-md-3'>
                                            <label for='ic_contrato'>Qtde Parcelas:&nbsp;</label>
                                            <div id="combo_qtde_parcelas_pk"></div>
                                        </div> 
                                    </div>
                                    <p>
                                    <div class="row">
                                        <div class='col-md-8'>
                                            <label for='ic_contrato'><b>Dados de Faturamento</b>&nbsp;</label>
                                        </div>                                                             
                                    </div>
                                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>                     
                          
                                    <span id='contrato_dados_fatura'></span>
                                    <br>
                                </div>
                                
                                <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Serviços a serem prestados</b>&nbsp;</label>
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                <br>
                                <div class='row'>
                                    <div class='col-md-12' align="left"> 
                                        <button type="button" class="btn btn-primary" id="cmdIncluirContratosItens" name="cmdIncluirContratosItens">Incluir Serviço</button>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblContratoItens">
                                            <thead>
                                                <tr>
                                                    <th>Cód</th>
                                                    <th>Prod/Serv</th>
                                                    <th>Qtde</th>
                                                    <th>Período</th>
                                                    <th>Escala</th>
                                                    <th>Vl. Unit </th>
                                                    <th>Vl. Total </th>
                                                    <th>Vl. Mão Obra </th>
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="7">&nbsp;</th>                                                                                              
                                                    <th><div id='vl_total_mao_obra'></div></th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tfoot> 
                                        </table>
                                    </div>
                                </div>
                                <p>
                                <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Valor Total do Contrato</b>&nbsp;</label>
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                <div class="row">
                                    <div class='col-md-2'>
                                        <label for='ic_contrato'>VL. Total:&nbsp;</label>
                                        <input type='text' class='form-control form-control-sm' id='vl_contrato' name='vl_contrato'>
                                    </div>                                        
                                </div>
                                <p>    
                                 <div class="row">
                                    <div class='col-md-8'>
                                        <label for='ic_contrato'><b>Materiai(s) (Insumos / Equipamentos / EPI´s)</b>&nbsp;</label>
                                    </div>                                                             
                                </div>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                                <p>       
                                <div class="row">
                                      <div class='col-md-12' align="left"> 
                                        <button type="button" class="btn btn-primary" id="cmdIncluirMaterial" name="cmdIncluirMaterial">Incluir Produto</button>
                                    </div>
                                 </div>
                                <p>
                                 <div class="row">
                                    <div class='col-md-3'>
                                       <label for='ic_contrato'>Categoria:&nbsp;</label>
                                       <select class='form-control form-control-sm'  id='categorias_produto_pk' name='categorias_produto_pk' requered/>
                                           <option></option>
                                       </select>   
                                    </div>                                     
                                    <div class='col-md-4'>
                                        <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Item</label>
                                        <select class='form-control form-control-sm'  id='produtos_pk' name='produto_pk' requered/>
                                           <option></option>
                                       </select>  
                                    </div>                                   
                                    <div class='col-md-2'>
                                       <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Qtde</label>
                                       <input class='form-control form-control-sm' type="text" id="n_qtde_item" name="n_qtde_item">
                                    </div>                                                                       
                                    <div class='col-md-2'>
                                        <label for='ic_contrato'>Valor:&nbsp;</label>
                                        <input class='form-control form-control-sm' type="text" id="vl_item_produto" name="vl_item_produto">                   
                                    </div>                                                                        
                                 </div>    
                                <div class='row' id="alert_categorias_produto_pk" style="display:none">                                    
                                    <div class='col-md-8'>
                                       <strong style="color: red">Por favor, Selecione a categoria!</strong>
                                    </div>
                                </div>
                                <div class='row' id="alert_produtos_pk" style="display:none">                                    
                                    <div class='col-md-8'>
                                       <strong style="color: red">Por favor, Selecione o Item!</strong>
                                    </div>
                                </div>
                                <div class='row' id="alert_n_qtde_item" style="display:none">                                    
                                    <div class='col-md-8'>
                                       <strong style="color: red">Por favor, Informe a quantidade!</strong>
                                    </div>
                                </div>
                                <div class='row' id="alert_vl_item_produto" style="display:none">                                    
                                    <div class='col-md-8'>
                                       <strong style="color: red">Por favor, Informe o valor do item!</strong>
                                    </div>
                                </div>   
                                <p>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblPrdutosItens">
                                            <thead>
                                                <tr>                                                   
                                                    <th>categoria_pk</th>
                                                    <th>Categoria</th>
                                                    <th>item_pk</th>
                                                    <th>Item</th>
                                                    <th>Qtde</th>
                                                    <th>Vl. Item</th>                     
                                                    <th>Ação</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>                                          
                                     
                                            </tfoot> 
                                        </table>
                                    </div>
                                </div>                                
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick='fcFecharModalContrato()'>Fechar</button>
                            <button type="button" class="btn btn-primary" id="cmdEnviarContrato"  name="cmdEnviarContrato">Salvar</button>
                        </div>       
                    </div>
                </div>
            </div>  
        </div>
    </form>
</div> 
