<?
require_once "../inc/php/header.php";
?>
<script src="faturamento_res_form.js?<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Gepros CRM</title>

    <!-- Custom fonts for this template-->
    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <?require_once '../inc/php/scripts.php';?>
</head>
<div class="container">
	<br>
	<div class="row">
		<div class="col-lg">
			<div class="card shadow mb-4">
				<div class="card-header py-3">	
                    <div class="row">
                        <div class='col-sm-6' align="left">
                            <h6 class="m-0 font-weight-bold text-primary">Faturamento</h6>
                        </div> 
                        <div class='col-sm-6' align="Right">
                            <button type="button" class="btn btn-secondary btn-sm" id="cmdVoltar">Voltar</button>
                            &nbsp;
                            <button type="button" class="btn btn-primary btn-sm" id="cmdIncluir">Novo</button>                       
                        </div>
                    </div>
				</div>
				<div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="empresas_pk">Empresa:&nbsp;</label>
                                <select id="empresas_pk" class="form-control form-control-sm" name="empresas_pk">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class='col-md-2'>
                                <label for='ds_tel'>DT Fat Ini: </label>
                                <input type='text' class='form-control form-control-sm'  id='dt_faturamento_ini' name='dt_faturamento_ini'>
                            </div>
                            <div class='col-md-2'>
                                <label for='ds_tel'>DT Fat Fim: </label>
                                <input type='text' class='form-control form-control-sm'  id='dt_faturamento_fim' name='dt_faturamento_fim'>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="ic_status">Status:&nbsp;</label>
                                <select id="ic_status" class="form-control form-control-sm" name="ic_status">
                                    <option value=""></option>
                                    <option value="1">Ativo</option>
                                    <option value="2">Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="empresas_pk">Tipos de Contrato:&nbsp;</label>
                                <select id="empresas_pk" class="form-control form-control-sm" name="empresas_pk">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                &nbsp;
                            </div>
                            <div class="col-md-4">
                                <label for="empresas_pk">Emissões:&nbsp;</label>
                                <select id="empresas_pk" class="form-control form-control-sm" name="empresas_pk">
                                    <option value=""></option>
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
                    </form>                  
                    <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>
                    <p>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="tblResultado">
                                <thead>
                                    <tr>
                                        <th>Cód</th>
                                        <th>Dt Ini Fat</th>
                                        <th>Dt Fim Fat</th>
                                        <th>Emissões</th>
                                        <th>Status</th>
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
