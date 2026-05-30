<script src="apontamento_colaborador_cad_form.js?   <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
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
				<div class="modal fade bd-example-modal-lg"  id="janela_apontamento_colaborador">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content" >
							<div class="card-header py-3">
								<h6 class="font-weight-bold text-primary">Apontamento Colaborador</h6>
							</div>
							<form id="form_colaborador">
                                <input type="hidden" id="origem" name="origem" value="">
								<div class="card-body">
									<div class="row">
										<div class='col-md-8'>
											<h6 for='ic_contrato'>Colaborador / Posto de Trabalho&nbsp;</h6>
										</div>                                                             
									</div>
									<hr>
									<div class="row">
										<div class='col-md-4'>
											<label for='tipo_apontamento_pk'>Tipo Apontamento:&nbsp;</label>
											<select  name="tipo_apontamento_pk" class="form-control form-control-sm" id="tipo_apontamento_pk" >
												<option value=''></option>
												<option value='1'>Ponto</option>
												<option value='2'>Falta</option>
												<option value='3'>Folga</option>
												<option value='4'>Troca de Escala</option>
												<option value='5'>Afastamento</option>
												<option value='6'>Férias</option>
												<!-----<option value='7'>Serviço Extra</option>----->
											</select>
                                            <div class='row' id="alert_tipo_apontamento_pk" style="display:none">
                                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Tipo Apontamento!</span>
                                            </div>
										</div> 

										<div class='col-md-4'>
											<label for='colaborador_pk_modal'>Colaborador:&nbsp;</label>
											<select  name="colaborador_pk_modal" class='form-control form-control-sm chzn-select' id="colaborador_pk_modal">
                                                <option></option>
											</select>
                                            <div class='row' id="alert_colaborador_pk_modal" style="display:none">
                                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Colaborador!</span>
                                            </div>
										</div>
										
										<div class='col-md-3'> 
											<label for='dt_apontamento'>Dt Apontamento:&nbsp;</label>
											<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_apontamento' name='dt_apontamento'/>
                                            <div class='row' id="alert_dt_apontamento" style="display:none">
                                                <span aling="center" style="color: red">Por favor, informe a Data de Apontamento!</span>
                                            </div>
                                        </div>
                                       
									</div>                               
									<br>
									<div class="row">                            
										<div id="tabelaHistoricoApontamento">
										</div>                                                                        
										<div id="tabelaPostoTrabalho">
										</div> 
                                        <div id="inputDsPin">
                                        </div>                                                                       
									</div>
									<div class='row'>
										<div id='dv_formulario_ponto' style="display: none" >
											<?include "apontamento_ponto_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_falta' style="display: none" >
											<?include "apontamento_falta_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_folga' style="display: none" >
											<?include "apontamento_folga_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_troca_escala' style="display: none" >
											<?include "apontamento_troca_escala_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_afastamento' style="display: none" >
											<?include "apontamento_afastamento_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_ferias' style="display: none" >
											<?include "apontamento_ferias_cad_form.php"?>	 
										</div>
										<div id='dv_formulario_servico_extra' style="display: none" >
											<?include "apontamento_servico_extra_cad_form.php"?>	 
										</div>
									</div>
								</div>	
							</form>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <button class="btn btn-primary" id="cmdEnviar">Salvar</button>
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