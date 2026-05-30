<?
require_once "../inc/php/header.php";
?>
<script src="ponto_rel_sintetico_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
                            <h6 class="m-0 font-weight-bold text-primary">Acompanhamento de Registro de Ponto Sintético</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                        </div>
                    </div>
				</div>
                
				<div class="card-body">
                    <form id="form" class="form">
                        <div class='row'>
                            <div class="col-md-3">
                                &nbsp;
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_tel'>Dt do registro do Ponto De: </label>
                                <input type='text' class='form-control form-control-sm'  id='dt_ini' name='dt_ini'> 
                            </div>
                            <div class='col-md-3'>
                                <label for='ds_tel'>Dt do registro deo Ponto Até: </label>
                                <input type='text' class='form-control form-control-sm'  id='dt_fim' name='dt_ate'>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-3">
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='clientes_pk'>Leads</label>
                                <select class='form-control form-control-sm chzn-select'  id='ds_lead' name='ds_lead'>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-md-3">
                                &nbsp;
                            </div>
                            <div class='col-md-6'>
                                <label for='clientes_pk'>Colaboradores</label>
                                <select class='form-control form-control-sm chzn-select'  id='colaboradores_pk' name='colaboradores_pk'>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            &nbsp;
                        </div>
                        <div class="col-md-4" align="center">
                            <button type="button" class="btn btn-primary btn-sm" id="cmdGerarRelatorio" name="cmdGerarRelatorio">Gerar Relatório</button>                         
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
