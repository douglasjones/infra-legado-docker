<?
require_once "../inc/php/header.php";
?>
<script src="compra_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Cadastro Compras </h6>     
                        </div> 
                        <div class='col-sm-6' align="right">
                            <button type="button" class="btn btn-secondary" id="cmdVoltar">Voltar</button>
                            <button type="button" class="btn btn-primary" id="cmdSalvarCompra">Salvar</button> 
                        </div> 
                    </div>
                </div>
				<div class="card-body">
                    <form id="form" class="form">
                        <div class='row'>   
                            <input type="hidden" id="compras_pk">
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Fornecedor:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='fornecedor_pk_ins' name='fornecedor_pk_ins' >
                                    <option value=""></option>
                                </select>  
                            </div>
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Categoria:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='categoria_pk_ins' name='categoria_pk_ins'/>
                                    <option value=""></option>
                                </select>  
                            </div>
                        </div>  
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_fornecedor" style="display:none">
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Fornecedor</strong>
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_categoria" style="display:none">
                            <div class='col-md-4'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Categoria</strong>
                            </div>
                        </div>
                        <div class='row'>   
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='empresa_pk_ins' name='empresa_pk_ins' />
                                    <option value=""></option>
                                </select>  
                            </div>                                     
                        </div> 
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_empresa" style="display:none">
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Empresa</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label for='tipo_grupo_pk'>Grupos Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='tipo_grupo_centro_custo_pk' name='tipo_grupo_centro_custo_pk' />
                                    <option value=""></option>
                                    <option value="1">Leads (Clientes)</option>
                                    <option value="2">Colaboradores</option>
                                    <option value="3">Fornecedores</option>
                                    <option value="4">Centro de Custo</option>
                                </select>  
                            </div>
                            <div class='col-md-4'>
                                <label for='vl_lancamento'>Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='grupo_lancamento_centro_custo_pk' name='grupo_lancamento_centro_custo_pk' />
                                    <option value=""></option>
                                </select>  
                            </div>
                        </div>
                        <br>
                        <!--Identificação de valores do lançamento-->    
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Dados NF / Pagamento</h6>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>
                        </div> 
                        <br>
                        <div class='row'>
                            <div class='col-md-3'>
                                <label for='vl_lancamento'>N Doc (NF/Pedido):&nbsp;</label>
                                <input type="text" class='form-control form-control-sm' id="ds_numero_nota_ins" name="ds_numero_nota_ins"/> 
                            </div>
                            <div class='col-md-3'>
                                <label for='vl_lancamento'>DT. Pag.</label>
                                <input type="text" class='form-control form-control-sm' id="dt_pagamento" name="dt_pagamento" maxlength="10"/> 
                            </div>
                            <div class='col-md-3'>
                                <label for='vl_lancamento' >DT. Prevista Entrega</label>
                                <input type="text" class='form-control form-control-sm' id="dt_entrega" name="dt_entrega" maxlength="10"/> 
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_n_doc" style="display:none">
                            <div class='col-md-3'>
                                <strong style="color: red">Por favor, informe N Doc (NF/Pedido)</strong>
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_dt_pag" style="display:none">
                            <div class='col-md-3'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <strong style="color: red">Por favor, informe DT. Pag.</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label for='vl_lancamento' >Forma de Pagamento:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='metodos_pagamento_pk' name='metodos_pagamento_pk' />
                                    <option ></option>
                                </select>
                            </div>
                            <div class='col-md-5'>
                                <label for='dt_competencia'>Qtde. Parcelas:&nbsp;</label>
                                <div id="qtde_parcela_combo"></div>
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_forma_apg" style="display:none">
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe Forma de Pagamento</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label for='vl_lancamento' >VL N Doc (NF/Pedido):&nbsp;</label>
                                <input type="text" class='form-control form-control-sm'  id='vl_notafiscal' name='vl_notafiscal' />
                            </div>
                            <div class='col-md-4'>
                                <label for='vl_lancamento' >VL Frete:&nbsp;</label>
                                <input type="text" class='form-control form-control-sm'  id='vl_frete' name='vl_frete' />
                            </div>
                            
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_vl_n_doc" style="display:none">
                            <div class='col-md-4'>
                                <strong style="color: red">Por favor, informe VL N Doc (NF/Pedido)</strong>
                            </div>
                        </div>
                        
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Cadastros de Produto</h6>
                                <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                            </div>
                        </div> 
                        <br>
                        <div class='row'>
                            <div class="col-md-12" >
                                <button type='button' class="btn btn-primary" id='cmdIncluirProduto'>Incluir Produto</button>
                            </div>
                        </div>
                        <br>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblCompraProduto">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
                                            <th>Categoria_pk</th>
                                            <th>Categoria</th>
                                            <th>Produto_pk</th>
                                            <th>Produto</th>
                                            <th>ic_entrega</th>
                                            <th>Qtde</th>
                                            <th>Lanc. Entoque</th>
                                            <th>Vl. Unitário</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                        <br>
                        <div class='row'>
                            <div class='col-md-4'>
                                <label for='ic_status'>Status:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='ic_status' name='ic_status'>
                                    <option value="2">Em processo</option>
                                    <option value="1">Finalizado</option>
                                </select>  
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer" align='right'>
                      <button type="button" class="btn btn-secondary" id="cmdVoltar">Voltar</button>
                      <button type="button" class="btn btn-primary" id="cmdSalvarCompra">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?
include_once "compra_add_produtos_cad_form.php";
include_once "compra_documento_cad_form.php";
?>
