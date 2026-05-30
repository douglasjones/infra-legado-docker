<?
require_once "../inc/php/header.php";
?>
<script src="lancamento_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

<style>
 #loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
  text-align: center;
}
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
    .titulo_calendario_anterior{
        background-color: #DFF0D8;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_grid_produto_servico{
        background-color: #c3c3c3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_atual{
        background-color: #9fd3f6;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .titulo_calendario_seguinte{
        background-color: #FCF8E3;
        border-bottom-style: solid;
        border-bottom-width: thin;
        font-weight: bold;
        text-align: center;
    }
    .subtitulo_calendario{
        text-align: center;
    }
    .corpo{
        border-right-style: dashed;
        border-right-width: thin;        
    }
    .modal-content1{
        width: 1200px;
    }
    .borda{
        width:100px;
        height:100px;
        border:solid 1px;
        
      }
</style>
<div id="loader"></div>
<div class="container-fluid" style=" background-color: #f5f5f5;display:none" id="exibir">
    <div class="row">
        <div class="col-md-1">
            &nbsp;
        </div>
        <div class="col-md-8">
            <h4>Contas a Pagar e Receber</h4>
        </div>
    </div>
    <p>
    <div class="row" > 
        <div class="col-md-12" style=" background-color: #ffffff">
            <table class="table table-borderless"> 
     
                    <div class='row'>
                        <div class='col-sm-5'>
                             &nbsp;
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-2'>
                            <button type='button' class="btn btn-primary" id='cmdIncluirReceita'>Novo Lançamento</button>    
                        </div>
                    </div> 
            </table>
        </div>    
        
        <div class="col-md-1">
            &nbsp;
        </div>        
        <div class="col-md-12" style=" background-color: #ffffff">
            <table class="table table-borderless"> 
                <thead>
                    <div class='row'>
                        <div class='col-sm-5'>
                             &nbsp;
                        </div>
                    </div>
                    
                    <!--<div class='row'>
                        <div class='col-sm-2'>
                            <button type='button' class="btn btn-primary" id='cmdIncluirReceita'>Novo Lançamento</button>    
                        </div>
                    </div>
                    <hr>-->
                 
                    <div class='row'>
                        <div class='col-sm-2'>
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <div id="combo"></div>
                                </div>
                            </div> 
                        </div>
                        <div class='col-sm-1' align="left">
                            <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-1" role="group" aria-label="First group">
                                  <button type="button" class="btn btn-primary" id="ic_jan">JAN</button>
                                  <button type="button" class="btn btn-primary" id="ic_fev">FEV</button>
                                  <button type="button" class="btn btn-primary" id="ic_mar">MAR</button>
                                  <button type="button" class="btn btn-primary" id="ic_abr">ABR</button>
                                  <button type="button" class="btn btn-primary" id="ic_mai">MAI</button>
                                  <button type="button" class="btn btn-primary" id="ic_jun">JUN</button>
                                  <button type="button" class="btn btn-primary" id="ic_jul">JUL</button>
                                  <button type="button" class="btn btn-primary" id="ic_ago">AGO</button>
                                  <button type="button" class="btn btn-primary" id="ic_set">SET</button>
                                  <button type="button" class="btn btn-primary" id="ic_out">OUT</button>
                                  <button type="button" class="btn btn-primary" id="ic_nov">NOV</button>
                                  <button type="button" class="btn btn-primary" id="ic_dez">DEZ</button>
                                  <input type="hidden" id="ic_mes" value="ic_mes" >                                      
                                </div>
                            </div>  
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-5'>
                             &nbsp;
                        </div>
                    </div>
                </thead>          
                <tbody>
                    
                <div class='row'>
                    <div class='col-sm'>
                        <label for='bancos_pk'>Empresa(s):&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='empresas_pk' name='empresas_pk' />
                            <option></option>
                        </select>
                    </div>
                    <div class='col-sm'>
                        <label for='bancos_pk'>Conta(s):&nbsp;</label>
                        <select class='form-control form-control-sm chzn-select'  id='contas_pk' name='contas_pk' />
                            <option></option>
                        </select> 
                    </div>
                    <div class='col-sm'>
                        <label for='bancos_pk'>Saldo Conta:&nbsp;</label>  
                        <div id="ds_saldo_conta"></div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-5'>
                         &nbsp;
                    </div>
                </div>
                    <tr id="exibir_extrato"> 
                        <td colspan="3">                          
                            <label for='bancos_pk'><b>Extrato</b> - &nbsp; Selecione o Periodo - De 
                                <select class='form-control form-control-sm chzn-select'  id='dia_ini_pk' name='dia_ini_pk' style="max-width:70px"/>
                                    <option></option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>                                    
                                </select> 
                                &nbsp;Até&nbsp;
                                <select class='form-control form-control-sm chzn-select'  id='dia_fim_pk' name='dia_fim_pk'  style="max-width:70px"/>
                                    <option></option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>                                    
                                </select> 
                            </label>
                            <div id="extrato"></div>                          
                        </td>
                    </tr>
                </tbody>                                       
            </table> 
        </div>
       <!-- <div class="col-md-0">
            &nbsp;
        </div>  
        <div id='exibir_grafico' class="col-md-2" style=" background-color: #ffffff">
            <table class="table table-borderless"> 
                <tbody>
                    <tr > 
                        <div id="container"></div>                      
                    </tr>
                </tbody>        
            </table> 
        </div>-->
    </div>    
    <br>  
    <div class="row">
         <div id='exibir_grafico' class="col-md-12" style=" background-color: #ffffff">
            <table class="table table-borderless"> 
                <tbody>
                    <tr > 
                        <div id="container"></div>                      
                    </tr>
                </tbody>        
            </table> 
        </div>
    </div>
    <br>
    <?php  
        //include("inc_lancamentos_mes_res_form.php");
        include("inc_receita_res_form.php");
    ?>  
    <div class="row">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    <div class="row" style=" height:100% ">
        <div class="col-md-12">
            &nbsp;
        </div>
    </div>
    
<div class="container">    
    <div class="modal fade bd-example-modal-lg" id="janela_docs" >
        <div class="modal-dialog modal-lg" role="document">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="janela_contatosLabel">Documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">                                    
                    <div>  
                        <p>   
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
                        <hr>
                    </div>  
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>   
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
                            <input id="fileuploadDoc"  type="file" name="FilesPic" multiple data-url="../controller/salvar_arquivo.php">

                        </span>
                        <br>
                        <div id="alert_documento" style="display:none" >
                            <strong style="color: red">Selecione um arquivo</strong>
                        </div>
                        <br>
                        <div id="progressDoc" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <div id="files" class="files"></div>
                        <!---->
                        <div class="row" id="rowFotos"></div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-1">
                        &nbsp;
                    </div>
                    <div class="col-md-10">
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
                        <input type="hidden" name="lancamentos_pk" id="lancamentos_pk"/>

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
<form id="form" class="form">
    <div class="modal" tabindex="-1" role="dialog" id="modal_receita">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><b>Novo Lançamento</b></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados de Indentificação do Lançamento</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div>  
                    <br>
                    <div class='row'>   
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Tipo Lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipo_lancamento_modal_receita_pk' name='tipo_lancamento_modal_receita_pk' requered>
                                <option value=""></option>
                                <option value="1">Receita</option>
                                <option value="2">Despesa Fixa</option>
                                <option value="3">Despesa Variável</option>
                                <option value="4">Imposto</option>
                                <option value="5">Transferência</option>
                                <option value="6" id="exibir_opc_caixinha">Caixinha</option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Tipo Operação / Planos Conta:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='tipos_operacao_pk_receita' name='tipos_operacao_pk_receita' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>   
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_tipo_lancamento" style="display:none">
                        
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Tipo Lançamento</strong>
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_tipo_operacao" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Tipo Operação / Planos Conta</strong>
                        </div>
                    </div>
                    
                    <!--------------------------GRID CONTRATOS----------------------->
                    <p> 
                    
                    
                    <p>                    
                    <div class='row'>   
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Empresa para o lançamento:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='empresa_modal_receita_pk' name='empresa_modal_receita_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>                                     
                       <div class='col-md-4'>
                            <label for='contas_pk'>Conta do Bancária:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='contas_bancarias_pk_receita' name='contas_bancarias_pk_receita' />
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>                    
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_banco" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Conta Bancária</strong>
                        </div>
                    </div>
                    <p>   
                    
                    <div class='row'>
                        <div class='col-md-10'>
                            <label for='ds_lancamento'>Identificação do Lançamento:&nbsp;</label>
                            <input type="hidden" class='form-control form-control-sm' id="lancamento_receita_pk" name="lancamento_receita_pk"/> 
                            <input type="text" class='form-control form-control-sm' maxlength="80" id="ds_lancamento_receita" name="ds_lancamento_receita"/> 
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
                            <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_pk_receita' name='tipo_grupo_pk_receita' requered/>
                                <option value=""></option>
                                <option value="1">Leads (Clientes)</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                            </select>  
                        </div>                        
                    </div>
                    <div class='row' id="div_grupos_lancamento_lead" style="display:none">
                        <p>
                        <div class='col-md-3'>
                            <label for='tipo_grupo_pk'>Clientes:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='leads_clientes_pk' name='leads_clientes_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>    
                        <div class='col-md-3'>
                            <label for='tipo_grupo_pk'>Posto de Trabalho:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='leads_posto_trabalho_pk' name='leads_posto_trabalho_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                        <div class='col-md-6'>
                            <label for='tipo_grupo_pk'>Contrato(s):&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='contratos_pk' name='contratos_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>  
                        <!--<div class='col-md-6'>
                            <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_receita' name='grupo_leancamento_pk_receita' requered/>
                                <option value=""></option>
                            </select>  
                        </div>-->
                    </div> 
                    
                    <div class='row' id="div_grupos_lancamento_colaborador" style="display:none">
                        <p>
                        <div class='col-md-3'>
                            <label for='tipo_grupo_pk'>Colaborador:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='colaborador_pk' name='colaborador_pk' requered/>
                                <option value=""></option>
                            </select>  
                        </div>    
                        <div class='col-md-3'>
                            <label for='tipo_grupo_pk'>Posto de Trabalho:&nbsp;</label>
                         
                        </div>  
                        <div class='col-md-6'>
                            <label for='tipo_grupo_pk'>Contrato(s):&nbsp;</label>
                            
                        </div>  
                        <!--<div class='col-md-6'>
                            <label for='vl_lancamento' class='recebido_de_pago_para'>&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='grupo_leancamento_pk_receita' name='grupo_leancamento_pk_receita' requered/>
                                <option value=""></option>
                            </select>  
                        </div>-->
                    </div> 
                    
                    
                    <div class='row' id="div_lancamento_fornecedor" style="display:none">
                        <div class='col-md-3'>
                            <label for='tipo_grupo_pk'>Fornecedor:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='leads_clientes_pk' name='grupo_leancamento_pk_receita' requered/>
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
                    <br>
                    <div id="listar_conta_bancaria"></div>

                    
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
                            <select class='form-control form-control-sm chzn-select'  id='tipo_grupo_centro_custo_pk_receita' name='tipo_grupo_centro_custo_pk_receita' requered/>
                                <option value=""></option>
                                <option value="1">Leads (Clientes)</option>
                                <option value="2">Colaboradores</option>
                                <option value="3">Fornecedores</option>
                                <option value="4">Centro de Custo</option>
                            </select>  
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento'>Centro de Custo:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='grupo_lancamento_centro_custo_pk_receita' name='grupo_lancamento_centro_custo_pk_receita' requered/>
                                <option value=""></option>
                            </select>  
                        </div>
                    </div>
                    
                    <div id='grid_contrato'></div> 
                    <input type='hidden' id='contratos_ins_pk'>
                    <input type='hidden' id='qtde_contratos'>
                    <br>
                    
                    <!--Identificação de valores do lançamento-->    
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Dados de Valor e Data do Lançamento / Status</h5>
                            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                        </div>
                    </div> 
                    <br>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='vl_lancamento'>Valor do Lançamento:&nbsp;</label>
                            <input type="text" class='form-control form-control-sm' id="vl_lancamento_receita" name="vl_lancamento_receita"/> 
                        </div>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='metodo_recebimento_pagamento'>Data Vencimento / Recebimento</label>
                            <select class='form-control form-control-sm chzn-select'  id='metodos_pagamento_pk_receita' name='metodos_pagamento_pk_receita' requered/>
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
                    <p>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='tipo_data_lancamento'>Dt Faturamento:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" id="dt_faturamento_receita" name="dt_faturamento_receita" maxlength="10"/>
                        </div>
                    </div>
                     <!----------------------ALERT------------------>
                    <div class='row' id="alert_dt_faturamento" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Dt Faturamento</strong>
                        </div>
                    </div>
                    <p>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='vl_lancamento' class='tipo_data_lancamento'>Dt Vencimento / Recebimento:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" id="dt_vencimento_receita" name="dt_vencimento_receita" maxlength="10"/>
                        </div>
                        <div class='col-md-5'>
                            <label for='dt_competencia'>Data de Competência / Referência:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" id="dt_competencia_receita" name="dt_competencia_receita"/>
                        </div>
                    </div>
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_dt_vencimento" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Dt Vencimento / Recebimento</strong>
                        </div>
                    </div>
                    <p>
                    <div class='row'>
                        <div class='col-md-4'>
                            <label for='tipos_operacao_pk'>Status:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='ic_status_pagamento_receita' name='ic_status_pagamento_receita' requered>
                                <option value=""></option>
                                <option id="exibir_pago" value="1">Pago</option>
                                <option value="2">Pendente</option>
                                <option value="3">Aprovado</option>
                                <option value="4">Atrasado</option>
                                <option value="5">Cancelado</option>
                            </select>  
                        </div>
                        <div class='col-md-4' id="exibir_dt_pagamento">
                            <label for='vl_lancamento' class='tipo_data_lancamento'>Dt Pagamento:&nbsp;</label>
                            <input type='text' class="form-control form-control-sm" maxlength="10" id="dt_pagamento_receita" name="dt_pagamento_receita"/>
                        </div>
                    </div>                    
                    <!----------------------ALERT------------------>
                    <div class='row' id="alert_status" style="display:none">
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Status</strong>
                        </div>
                    </div>
                    <div class='row' id="alert_data_pagamento" style="display:none">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <strong style="color: red">Por favor, informe Data Pagamento</strong>
                        </div>
                    </div>
                    <p>
                    <div class='row'>
                        <div class='col-md-10'>
                            <label for='dt_competencia'>Observação:&nbsp;</label>
                            <textarea class="form-control form-control-sm" id="n_documento_receita" name="n_documento_receita"></textarea>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                      <button type="submit" class="btn btn-primary" id="cmdSalvarReceita">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?
require_once "../inc/php/footer.php";
?>
