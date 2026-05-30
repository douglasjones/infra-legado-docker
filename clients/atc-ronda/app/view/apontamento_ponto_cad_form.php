<script src="apontamento_ponto_cad_form.js?	<?php echo time(); ?>" type="text/javascript" charset="utf-8"></script>
<div class="container">
	<div class="row">
		<div class="col-lg-6">
			<form id="form_ponto">
				<div class="row">
					<div class='col'>
						<h6 class="font-weight">Novo apontamento - <b>Registro de ponto</b></h6>
						<hr>
					</div>
					<div class="row" style="margin: 5px">
						<div class='col-md-12'>
							<label for='tipo_ponto_pk'>Tipo de Registro Ponto:&nbsp;</label>
							<select  name="tipo_ponto_pk" class="form-control form-control-sm" id="tipo_ponto_pk">
								<option value=''></option>
								<option value='1'>Início do expediente</option>
								<option value='2'>Saída para o intervalo</option>
								<option value='3'>Retorno do intervalo</option>
								<option value='4'>Fim de expediente</option>
							</select>
                            <div class='row' id="alert_tipo_ponto_pk" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Tipo de Registro Ponto!</span>
                            </div>
						</div> 
						<div class='col-md-8'>
							<label for='hr_sistema'>Hora Automática do Sistema:&nbsp;</label>
							<input type="checkbox" name="hr_sistema" id="hr_sistema" value="1">
                            
						</div> 	
						<br>
						<div class='col-md-8'>
							<label for='hr_manual'>Hora Entrada Manual:&nbsp;</label>
							<input type="text" name="hr_manual" id="hr_manual">
                            <div class='row' id="alert_hr_manual_sistema" style="display:none">
                                <span aling="center" style="color: red">&nbsp;Por favor, informe o Hora Sistema ou Hora Entrada Manual!</span>
                            </div>
						</div> 	
						<br>
						<div class='col-md-12'>
							<label for='ds_obs_ponto'>Observação:&nbsp;</label>
							<textarea cols="50"  id="ds_obs_ponto" name="ds_obs_ponto"></textarea>
                            <div class='row' id="alert_ds_obs_ponto" style="display:none">
                                <span aling="center" style="color: red">&nbsp;&nbsp;&nbsp;Por favor, informe o Observação!</span>
                            </div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
