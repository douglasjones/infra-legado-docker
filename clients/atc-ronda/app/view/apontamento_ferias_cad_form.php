
<script src="apontamento_ferias_cad_form.js? <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_ferias">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Férias</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div id="dt_ferias" class="row" style="margin: 3px">						
							<div class='col'>
								<label for='dt_ini_ferias'> Início das Férias: &nbsp; </label>
								<input type='text' maxlength="10" class='form-control form-control-sm'  id='dt_ini_ferias' name='dt_ini_ferias' />
							</div>
                            <div class='col' id="alert_dt_ini_ferias" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Tipo Apontamento!</span>
                            </div>
							<div class='col'>
								<label for='dt_fim_ferias'> Fim das Férias: &nbsp; </label>
								<input type='text' maxlength="10" class='form-control form-control-sm'  id='dt_fim_ferias' name='dt_fim_ferias' />
							</div>
                            <div class='col' id="alert_dt_fim_ferias" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Tipo Apontamento!</span>
                            </div>
						</div>
						<div class='col-md-12'>
							<label for='colaborador_cobertura_ferias_pk'>Cobertura:&nbsp;</label>
							<select  name="colaborador_cobertura_ferias_pk" class='form-control form-control-sm' id="colaborador_cobertura_ferias_pk">
								<option value=''></option>
							</select>
						</div> 	
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_ferias'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_ferias" name="ds_obs_ferias"></textarea>
                            <div class='col' id="alert_ds_obs_ferias" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Tipo Apontamento!</span>
                            </div>
                        </div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
