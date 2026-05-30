<script src="correcao_usuario_analise_financeira_form_res.js?   <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<?require_once '../inc/php/scripts.php';?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="../inc/css/themas/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>  
<body>
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="modal fade bd-example-modal-lg"  id="modal_correcao_obs">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content" >
							<div class="card-header py-3">
								<h6 class="font-weight-bold text-primary">Observação Analista/Gestor</h6>
							</div>
							<form id="form_correcao">
								<div class="card-body">
									<div class="row">
										<div class='col-md-12'>
											<label><b>Observação Analista/Gestor:&nbsp;</b></label>
											<div id="obs">

                                            </div>
										</div>
									</div>
									<br>
									<div id="usuario_obs"  class="row">
										<div class='col-md-12'>
											<h6><b>Informações Correção</b></h6>
											<hr>	
										</div>
										<div class='col-md-12'>
											<label><b>Observação:&nbsp;</b></label>
											<div>
												<textarea cols="50"  id="obs_correcao" name="obs_correcao"></textarea>
												<input type="hidden" id="analise_financeira_pk" name="analise_financeira_pk"></textarea>
												<div class='row' id="alert_obs_correcao" style="display:none">
													<span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe a Observação!</span>
												</div>
											</div>
											<br>
											<div id="correcao">
												<button type='button' class='btn btn-primary' id='cmdCorrecaoFeita' name='cmdCorrecaoFeita'>Solicitar Nova Analise</button>
											</div>
										</div>
									</div>	
								</div>	
							</form>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>
						</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</body>
<?require_once "../inc/php/footer.php";?>