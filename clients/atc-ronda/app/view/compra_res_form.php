<?
require_once "../inc/php/header.php";
?>
<script src="compra_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet" />
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>
<style>
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    max-height: calc(100vh - 200px);
    overflow-y: auto;
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
                            <h6 class="m-0 font-weight-bold text-primary">Compras </h6>     
                        </div> 
                    </div>
                </div>
				<div class="card-body">
                    <form method="post">
                        
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="categorias_pk">Categoria:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="categorias_pk">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="fornecedor_pk">Fornecedor:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="fornecedor_pk">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="ds_numero_nota">Número da NF:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="ds_numero_nota">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-4'>
                                <label for="empresas_pk">Empresas:&nbsp;</label>
                                <select class="form-control form-control-sm chzn-select" id="empresas_pk">
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-2">
                                <label for="dt_cadastro_ini">DT Compra Ini:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_cadastro_ini" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <label for="dt_cadastro_fim">DT Compra Fim:&nbsp;</label>
                                <input type="text" class="form-control form-control-sm" id="dt_cadastro_fim" maxlength="10">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4" align="center">
                                <button type="button" class="btn btn-link" id="cmdPesquisar"><img src="../img/pesquisar.png" width=40 height=40>Pesquisar</button>
                                &nbsp;
                                <button type="button" class="btn btn-link" id="cmdIncluir"><img src="../img/incluir.png" width=40 height=40>Incluir</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                            <thead>
                                <tr>
                                    <th>Cód</th>
                                    
                                    <th>Fornecedor</th>
                                    <th>Categoria</th>
                                    <th>Num NF</th>
                                    <th>Empresa</th>
                                    <th>DT Compra</th>
                                    <th>VL Compra</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
