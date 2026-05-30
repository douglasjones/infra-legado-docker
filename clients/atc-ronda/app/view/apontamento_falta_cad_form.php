
<script src="apontamento_falta_cad_form.js? <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_falta">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Falta</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div class='col-md-12'>
							<label for='motivo_falta_pk'>Motivo da Falta:&nbsp;</label>
							<select  name="motivo_falta_pk" class="form-control form-control-sm" id="motivo_falta_pk">
								<option value=''></option>
								<option value='1'>Abonada</option>
								<option value='2'>Apoio Operacional</option>
								<option value='3'>Atestado</option>
								<option value='4'>Atraso</option>
								<option value='5'>Extensão SDF</option>
								<option value='6'>Falta de Efetivo</option>
								<option value='7'>Falta Sem Justificativa</option>
								<option value='8'>Licença</option>
								<option value='9'>Remanejameto</option>
								<option value='10'>Reciclagem</option>
								<option value='11'>Extensão SDF</option>
							</select>
                            <div class='row' id="alert_motivo_falta_pk" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;Por favor, informe o Motivo da Falta!</span>
                            </div>
						</div> 	
						<div class='col-md-12'>
							<label for='colaborador_cobertura_falta_pk'>Cobertura:&nbsp;</label>
							<select  name="colaborador_cobertura_falta_pk" class='form-control form-control-sm' id="colaborador_cobertura_falta_pk" onchange='fcAbrirSelectsFalta()'>
								<option value=''></option>
							</select>
						</div> 	
                        <div class='col-md-12' id="motivo_cobertura_pk"style="display:none">
                            <label for='motivo_cobertura_falta_pk'>Motivo Cobertura:&nbsp;</label>
                            <select  name="motivo_cobertura_falta_pk" class="form-control form-control-sm" id="motivo_cobertura_falta_pk">
                                <option value=''></option>
                                <option value='1'>Folga Trabalhada</option>
								<option value='2'>Escala Errada</option>
                                <option value='3'>Posto Vago</option>
                            </select>
                        </div> 
                        <div class='col-md-6' id="dv_vl_ft_falta"style="display:none">
                            <label for='vl_ft_falta'>Vl FT:&nbsp;</label>
                            <input type="text" class="form-control form-control-sm" id="vl_ft_falta" name="vl_ft_falta">
                        </div> 
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_falta'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_falta" name="ds_obs_falta"></textarea>
                            <div class='row' id="alert_ds_obs_falta" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;Por favor, informe a Observação!</span>
                            </div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
