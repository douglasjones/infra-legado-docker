
<script src="apontamento_troca_escala_cad_form.js? <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_trocaEscala">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Troca De Escalas</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div class='col-md-12'>
							<label for='colaborador_cobertura_troca_escala_pk'>Cobertura:&nbsp;</label>
							<select  name="colaborador_cobertura_troca_escala_pk" class='form-control form-control-sm' id="colaborador_cobertura_troca_escala_pk">
								<option value=''></option>
							</select>
                            <div class='row' id="alert_colaborador_cobertura_troca_escala_pk" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe a Cobertura!</span>
                            </div>
						</div> 	
						<div class='col-md-12'>
							<label for='motivos_troca_escala_pk'>Motivos Troca De Escala:&nbsp;</label>
							<select  name="motivos_troca_escala_pk" class="form-control form-control-sm" id="motivos_troca_escala_pk">
								<option value=''></option>
								<option value='1'>Troca de Turno</option>
								<option value='2'>Serviço Extra</option>
								<option value='3'>Motivo de Saúde</option>
							</select>
                            <div class='row' id="alert_motivos_troca_escala_pk" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Motivo troca de escala!</span>
                            </div>
						</div> 	
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_troca_escala'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_troca_escala" name="ds_obs_troca_escala"></textarea>
                            <div class='row' id="alert_ds_obs_troca_escala" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe a Observação!</span>
                            </div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>