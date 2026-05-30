
<script src="apontamento_servico_extra_cad_form.js? <?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_servico_extra">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Serviço Extra</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div class='col-md-12'>
							<label for='leads_pk_modal'>Posto de Trabalho:&nbsp;</label>
							<select  name="leads_pk_modal" class="form-control form-control-sm" id="leads_pk_modal">
								<option value=''></option>
								<option value='1'> Alphaville II</option>
							</select>
                            <div class='row' id="alert_leads_pk_modal" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Posto de trabalho!</span>
                            </div>
						</div>
						<br>
						<div id="dt_afastamento" class="row" style="margin: 2px">						
							<div class='col'>
								<label for='dt_ini_exec_servico'> Ini Execução Serviço: &nbsp; </label>
								<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_ini_exec_servico' name='dt_ini_exec_servico' />
                                <div class='row' id="alert_dt_ini_exec_servico" style="display:none">
                                    <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Inicio da execução do serviço!</span>
                                </div>
                            </div>
							<div class='col'>
								<label for='dt_fim_exec_servico'> Fim Execução Serviço: &nbsp; </label>
								<input maxlength="10" type='text' class='form-control form-control-sm'  id='dt_fim_exec_servico' name='dt_fim_exec_servico' />
                                <div class='row' id="alert_dt_fim_exec_servico" style="display:none">
                                    <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Fim da execução do serviço!</span>
                                </div>
                            </div>
                            
						</div>
						<div class='col-md-12'>
							<label for='contrato_pk'>Contrato:&nbsp;</label>
							<select  name="contrato_pk" class="form-control form-control-sm" id="contrato_pk">
								<option value=''></option>
								<option value='1'>contrato extra</option>
							</select>
                            <div class='row' id="alert_contrato_pk" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Contrato!</span>
                            </div>
						</div> 
						<div class='col-md-8'>
							<label for='vl_servico '>Valor Serviço:&nbsp;</label>
							<input type="text" class='form-control form-control-sm' name="vl_servico" id="vl_servico">
                            <div class='row' id="alert_vl_servico" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Valor do serviço!</span>
                            </div>
                        </div> 	
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_servico_extra'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_servico_extra" name="ds_obs_servico_extra"></textarea>
                            <div class='row' id="alert_ds_obs_servico_extra" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe a observação!</span>
                            </div>
                        </div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

