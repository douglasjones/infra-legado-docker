<?
require_once "../inc/php/header.php";
?>
<script src="compras_solicitacao_orcamentos_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
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

.label-float input[type=text]::invalid + label{
  color: red;
}
.label-float input[type=text]:focus::invalid{
  border-bottom: 2px solid red;
}
.label-float input::invalid + label:before{
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
    <form id="formOrcamento" class="form">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Orçamentos </h6>     
                        </div>
                        <div class='col-sm-6' align="right">
                            <button type="button" class="btn btn-secondary" id="cmdVoltar">Voltar</button>    
                        <button type="button" class="btn btn-primary" id="cmdEnviarOrcamento"  name="cmdEnviarOrcamento">Incluir Orçamento</button>
                        </div> 
                    </div>
                </div>
				    <div class="card-body">
                        <input type='hidden' class='form-control form-control-sm'  id='acao' name='acao'>
                        <input type='hidden' class='form-control form-control-sm'  id='compras_solicitacao_orcamentos_pk' name='compras_solicitacao_orcamentos_pk' value="">
                        <input type='hidden' class='form-control form-control-sm'  id='compra_solicitacao_pk' name='compra_solicitacao_pk'>

                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='fornecedor_pk'>Fornecedor:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='fornecedor_pk' name='fornecedor_pk' />
                                    <option></option>
                                </select>  
                            </div>
                            <div class='col-md-3'>
                                <label for='dt_pevisao_entrega'> Dt Previsão de Entrega:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' id='dt_pevisao_entrega' name='dt_pevisao_entrega'  > 
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        <div class='row' id="alert_fornecedor_pk" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe o fornecedor!</strong>
                            </div>
                        </div>
                        <!----------------------ALERT------------------>
                        
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='vl_frete'> Vl do Frete:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' id='vl_frete' name='vl_frete'  >
                            </div>
                        </div> 
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-2'>
                                <label for='obs_orcamento'> Observação:&nbsp;</label>
                                <textarea id="obs_orcamento" name="obs_orcamento"  rows="3" cols="60"></textarea>  
                            </div>
                        </div>
                    
                        <p>
                        <div class='row'>
                            <div class='col-md-12'>
                                <h5>Produto(s) / Itens Orçamento</h5> 
                                <hr>
                            </div>
                        </div>
                        
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='processos_pk'>Categoria:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='categorias_produto_pk' name='categorias_produto_pk'/>
                                    <option></option>
                                </select>    
                            </div>
                            <!----------<div class='col-md-5'>
                                <label for='processos_pk'>Produtos/Itens:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='produtos_pk' name='produtos_pk'/>
                                    <option></option>
                                </select>    
                            </div>-------->
                            <div class='col-md-5'>
                                <label for='produtos_pk'>Produto/Item:&nbsp;</label>
                                <select class='form-control form-control-sm' id="produtos_pk" name="produtos_pk">   
                                    <option></option>
                                </select>
                            </div>
                            <div class='col-md-1' id="div_incluir_produto">
                                <label>&nbsp;</label>
                                <button type='button' class="btn btn-secondary" id="cmdAddProduto" name="cmdAddProduto">Add. Item</button>
                            </div>
                        </div>
                        <div class='row' id="alert_categorias_produto_pk" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, selecione a categoria!</strong>
                            </div>
                        </div>  
                        <div class='row' id="alert_produtos_pk" style="display:none">
                            <div class='col-md-6'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, selecione o produto/item!</strong>
                            </div>
                        </div>    
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='processos_pk'>Quantidade:&nbsp;</label>
                                <input type="text" class='form-control form-control-sm'  id='qtde_produto' name='qtde_produto'/>     
                            </div>
                            <div class='col-md-3'>
                                <label for='processos_pk'>Valor Unitário:&nbsp;</label>
                                <input type="text" class='form-control form-control-sm'  id='vl_item_produto' name='vl_item_produto'/>    
                            </div>
                        </div>
                        <div class='row' id="alert_qtde_produto" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe a quantidade!</strong>
                            </div>
                        </div>
                        <div class='row' id="alert_vl_item_produto" style="display:none">
                            <div class='col-md-6'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <strong style="color: red">Por favor, informe o valor!</strong>
                            </div>
                        </div>            
                            
                        <p> 
        
                        <div class="row" id="div_incluir_item" style="display:show">
                            <div class='col-md-12' align="left">
                                <button type="button" class="btn btn-primary" id="cmdIncluirItem"   name="cmdIncluirItem" >Incluir Item</button>
                            </div>
                    </div>  
    
                        <p> 
                        <div class="container">     
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblProdutosItens">
                                    <thead>
                                        <tr>
                                            <th>Cód</th>
                                            <th>Categoria_pk</th>
                                            <th>Categoria</th>
                                            <!-------<th>Produto_pk</th>---------->
                                            <th>Produtos/Itens</th>
                                            <th>Qtde</th>
                                            <th>Vl</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                        </div> 
                        
                        <p>
                        <div class='row' id="div_titulo_aprovacao"  style="display:none">                       
                            <div class='col-md-12'>
                                <h5>Aprovar Orçamento</h5> 
                                <hr>
                            </div>                      
                        </div>
                        
                        <div class='row' id="div_aprovacao_status" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <label for="ic_status_orcamento">Status Aprovação Orçamento:&nbsp;</label>
                                <select  class="form-control form-control-sm" id="ic_status_orcamento" name="ic_status_orcamento" >                              
                                    <option value="1">Em Análise</option>
                                    <option value="2">Aprovado</option>
                                    <option value="3">Reprovado</option>
                                </select>
                            </div>
                        </div>    
                        <div class='row' id="div_aprovacao_obs" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-5'>
                                <label for='obs_solicitacao'> Obs Aprovação Orçamento:&nbsp;</label>
                                <textarea id="obs_aprovacao_orcamento" name="obs_aprovacao_orcamento" rows="3" cols="60"></textarea>
                            </div>
                        </div> 

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary">Voltar</button>
                        <button type="button" class="btn btn-primary" id="cmdEnviarOrcamento"  name="cmdEnviarOrcamento">Incluir Orçamento</button>
                    </div>
                    </div>    
                </div>
            </div>
        </div>  
    </form>
</div>

<?
include_once "produto_add.php";
require_once "../inc/php/footer.php";
?>
