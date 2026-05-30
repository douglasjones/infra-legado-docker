
<script src="apontamento_afastamento_cad_form.js? <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_afastamento">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Afastamento</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div class='col-md-12'>
							<label for='motivo_afastamento_pk'>Motivo da Afastamento:&nbsp;</label>
							<select  name="motivo_afastamento_pk" class="form-control form-control-sm" id="motivo_afastamento_pk">
								<option value=''></option>
								<option value='1'>Motivos Médicos</option>
								<option value='2'>Invalides</option>
							</select>
							<div class='row' id="alert_motivo_afastamento_pk" style="display:none">
								<span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Motivo Afastamento!</span>
							</div>
						</div>
						<br>
						<div id="dt_afastamento" class="row" style="margin: 3px">						
							<div class='col'>
								<label for='dt_ini_afastamento'> Início Afastamento: &nbsp; </label>
								<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_ini_afastamento' name='dt_ini_afastamento' />
								<div class='row' id="alert_dt_ini_afastamento" style="display:none">
									<span aling="center" style="color: red">Por favor, informe o Início Afastamento!</span>
								</div>
							</div>
							
							<div class='col'>
								<label for='dt_fim_afastamento'> Fim Afastamento: &nbsp; </label>
								<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_fim_afastamento' name='dt_fim_afastamento' />
								<div class='row' id="alert_dt_fim_afastamento" style="display:none">
									<span aling="center" style="color: red">Por favor, informe o Fim do Afastamento!</span>
								</div>
							</div>
						</div>
						<div class='col-md-12'>
							<label for='colaborador_cobertura_afastamento_pk'>Cobertura:&nbsp;</label>
							<select  name="colaborador_cobertura_afastamento_pk" class='form-control form-control-sm' id="colaborador_cobertura_afastamento_pk">
								<option value=''></option>
							</select>
						</div> 	
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_afastamento'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_afastamento" name="ds_obs_afastamento"></textarea>
							<div class='row' id="alert_ds_obs_afastamento" style="display:none">
								<span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe a observação!</span>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
