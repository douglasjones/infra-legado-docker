<?
require_once "../inc/php/header.php";
?>
<script src="financeiro_conciliacao_banco_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

<div class="container">
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
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <div class="row">
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='ic_contrato'>Empresa:&nbsp;</label>
                            <select id="empresas_pk" name="empresas_pk" class="form-control form-control-sm chzn-select">
                            </select>
                        </div>                                                             
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='bancos_pk'>Banco(s):&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='bancos_pk' name='bancos_pk' />
                                <option></option>
                            </select>    
                        </div>            
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_agencia'>Agência:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='ds_agencia' name='ds_agencia' />
                                <option></option>
                            </select>    
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-4'>
                            &nbsp;
                        </div>
                        <div class='col-md-4'>
                            <label for='ds_agencia'>Contas:&nbsp;</label>
                            <select class='form-control form-control-sm chzn-select'  id='ds_conta' name='ds_conta' />
                                <option></option>
                            </select>  
                        </div>
                    </div>
                    <p>
                    <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4" align="center">
                                <button type="button" class="btn btn-primary btn-sm" id="cmdPesquisar">Pesquisar</button>                         
                            </div>
                        </div>
                    <p>    
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    <p>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>Cód</th>
                                        <th>Empresa</th>
                                        <th>Banco</th>
                                        <th>Agência</th>
                                        <th>Conta</th>
                                        <th>Dt Conciliação</th>
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