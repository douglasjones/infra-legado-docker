<?
require_once "../inc/php/header.php";
?>

<script src="compras_solicitacao_cad_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Solicitação de Compras </h6>     
                        </div>
                        <div class='col-sm-6' align="right">
                            <button type="button" class="btn btn-secondary" id="cmdCancelar">Voltar</button>    
                            <button type="button" class="btn btn-primary" id="cmdEnviarSolicitacaoCompra"  name="cmdEnviarSolicitacaoCompra">Salvar Solicitação de Compras</button>
                        </div> 
                    </div>
                </div>
				<div class="card-body">
                    <form id="formOrcamento" class="formOrcamento">
                        <input type="hidden" id="compra_solicitacao_pk" name="compra_solicitacao_pk">
                        <input type='hidden' class='form-control form-control-sm'  id='dt_aprovacao' name='dt_aprovacao' value="">
                        <input type='hidden' class='form-control form-control-sm'  id='obs_aprovacao' name='obs_aprovacao' value="">
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='ds_compra_solicitacao'>Identificação Solicitação de Compra:&nbsp;</label>
                                <input type='text' class='form-control form-control-sm' id='ds_compra_solicitacao' name='ds_compra_solicitacao' required >                
                            </div>
                            <div class='col-md-2'>
                                <label for='dt_solicitacao'> Dt da Solicitação:&nbsp;</label>
                                <input class='form-control form-control-sm'  type='text' id='dt_solicitacao' name='dt_solicitacao' />
                            </div>            
                        </div>         
                        <div class='row' id="alert_ds_compra_solicitacao" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe a identificação da solicitação de compra!</strong>
                            </div>
                        </div>
                        <div class='row' id="alert_dt_solicitacao" style="display:none">
                            <div class='col-md-5'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe a data da solicitação de compra!</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='tipos_operacao_pk'>Empresa:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='empresas_pk' name='empresas_pk' />
                                    <option value=""></option>
                                </select> 
                            </div>
                        </div> 
                        <div class='row' id="alert_empresas_pk" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe a empresa da solicitação de compra!</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='solicitante_pk'>Solicitante:&nbsp;</label>
                                <select class="form-control form-control-sm "  id='solicitante_pk' name='solicitante_pk' />
                                    <option></option>
                                </select>
                            </div>
                            <div class='col-md-4'>
                                <label for='solicitante_pk'>Aprovadores:&nbsp;</label>
                                <select class="form-control form-control-sm "  id='usuario_aprovacao_pk' name=usuario_aprovacao_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div> 
                                
                        <div class='row' id="alert_solicitante_pk" style="display:none">
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, informe o solicitante da solicitação de compra!</strong>
                            </div>
                        </div>
                                <div class='row' id="alert_usuario_aprovacao_pk" style="display:none">
                            <div class='col-md-5'>
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <strong style="color: red">Por favor, selecione o Aprovador da solicitaçao de compra!</strong>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='tipo_grupo_centro_custo_pk'> Grupo de Centro de Custos:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='tipo_grupo_centro_custo_pk' name='tipo_grupo_centro_custo_pk' />
                                    <option value=""></option>
                                    <option value="1">Leads (Clientes)</option>
                                    <option value="2">Colaboradores</option>
                                    <!--<option value="3">Fornecedores</option>-->
                                    <option value="4">Centro de Custo</option>
                                </select>
                            </div>
                            <div class='col-md-4'>
                                <label for='grupo_lancamento_centrocusto_pk'>Centro de Custo:&nbsp;</label>
                                <select class='form-control form-control-sm'  id='grupo_lancamento_centrocusto_pk' name='grupo_lancamento_centrocusto_pk' />
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-1'>
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for='obs_solicitacao'> Observação da Solicitação:&nbsp;</label>
                                <textarea id="obs_solicitacao" name="obs_solicitacao" rows="3" cols="60"></textarea>
                            </div>
                        </div>        


                        </p>    
                        <div class="row">
                            <div class="col-md-12">
                                <?
                                    require_once "compras_solicitacao_orcamentos_res_form.php";
                                ?>
                            </div>
                        </div>    
                        <div class='row' id="div_aprovacao" style="display:none">
                            <div class="col-md-12" align="center" >
                                <h5>Aprove um dos orçamento(s)</h5>
                            </div>
                        </div>
                        <tfoot>
                            <div class="row">
                                <div class="col-md-12" align="right"   >
                                    <hr>                
                                    <button type="button" class="btn btn-secondary" id="cmdCancelar" data-dismiss="modal">Voltar</button>
                                    <button type="button" class="btn btn-primary" id="cmdEnviarSolicitacaoCompra"   name="cmdEnviarSolicitacaoCompra" >Salvar Solicitação de Compras</button>
                                </div>
                            </div>
                        </tfoot>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<?
require_once "../inc/php/footer.php";
?>
