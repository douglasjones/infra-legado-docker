

<script src="regerar_res_form.js?   <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.css">

    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	
    <?require_once '../inc/php/scripts.php';?>
</head>  
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="modal fade bd-example-modal-lg"  id="janela_regerar">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content" >
							<div class="card-header py-3">
								<h6 class="font-weight-bold text-primary">Regerar Folha</h6>
							</div>
							<form id="form_colaborador">
								<div class="card-body py-3">
									<div class="row">
                                        <div class='col-md-3'> &nbsp; </div>
                                        <input type='hidden' id='colaboradores_pk' name='colaboradores_pk'/>
                                        <input type='hidden' id='ponto_folha_pk' name='ponto_folha_pk'/>
										<div class='col-md-3'> 
											<label for='dt_apontamento'>Dt. Iní. Período:&nbsp;</label>
											<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_ini_periodo' name='dt_ini_periodo'/>
											<input type='hidden' id='data_periodo_ini' name='data_periodo_ini'/>
                                            <div class='row' id="alert_dt_ini_periodo" style="display:none">
                                                <span aling="center" style="color: red">Por favor, informe a Data ínicio do Período!</span>
                                            </div>
                                        </div>
										<div class='col-md-3'> 
											<label for='dt_apontamento'>Dt. Fim. Período:&nbsp;</label>
											<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_fim_periodo' name='dt_fim_periodo'/>
											<input type='hidden' id='data_periodo_fim' name='data_periodo_fim'/>
                                            <div class='row' id="alert_dt_fim_periodo" style="display:none">
                                                <span aling="center" style="color: red">Por favor, informe a Data Fim do Período!</span>
                                            </div>
                                        </div>
									</div>                               
									<br>
								</div>	
							</form>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button class="btn btn-primary" id="cmdEnviar">Regerar</button>
                            </div>
						</div>
                    </div>
				</div>
                
			</div>
		</div>
	</div>
</body>

<?
    require_once "../inc/php/footer.php";
?>