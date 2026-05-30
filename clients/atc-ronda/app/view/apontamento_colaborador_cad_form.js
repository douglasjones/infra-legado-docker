function fcColaboradorModal(colaborador_pk) {
    var objParametros = {
        "pk": colaborador_pk
    };

    var arrCarregar = carregarController("colaborador", "comboColaboradorpk", objParametros);

    //Combo de colaboradores
    if($("#origem").val() == "calendario_escala" || $("#origem").val() == "mesa_operacional"){
       carregarComboAjax($("#colaborador_pk_modal"), arrCarregar, "", "colaborador_pk", "ds_colaborador");	
    }else{
        carregarComboAjax($("#colaborador_pk_modal"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
    }
}

function fcExcluir(v_pk, v_ds_tipo_apontamento, v_apontamento_ponto_pk){

    if (confirm("Deseja realmente excluir o registro ?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk,
                "ds_tipo_apontamento": v_ds_tipo_apontamento,
                "apontamento_ponto_pk": v_apontamento_ponto_pk
            };    
                  
            var arrExcluir = carregarController("agenda_colaborador_apontamento", "excluir", objParametros); 

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);
                
                $("#janela_apontamento_colaborador").modal("hide");

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}


function fcTblHistoricoApontamento(colaborador_pk, dt_apontamento){
    //Table de Histório de Apontamentos
	var strhtml = "";
	strhtml += "	<div class='row'>";
	strhtml += "		<div class='col-md-12'>";
	strhtml += "			<h6 for='ic_contrato'>&nbsp;&nbsp;&nbsp;Histórico Apontamento &nbsp;</h6>";
	strhtml += "			<hr> ";
	strhtml += "		</div> ";
	strhtml += "	</div> ";	
    strhtml += "<div class='row' style='margin:2px;width:790px;'>";
    strhtml += "    <div class='col-md-12'>";
    strhtml += "        <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblHistoricoApontamento'>";
	strhtml += "            <thead>";
	strhtml += "                <tr>";
	strhtml += "                    <th>Tipo Apontamento</th>";
	strhtml += "                    <th>Posto de Trabalho</th>";
	strhtml += "                    <th>Data e HR Apontamento</th>";
	strhtml += "                    <th>Usuário Cadastro</th>";
	strhtml += "                    <th>Ação</th>";
	strhtml += "                </tr>";
	strhtml += "            </thead>";
	
    var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_apontamento": dt_apontamento
		
    };
	
	var arrCarregar = carregarController("agenda_colaborador_apontamento", "listarApontamentoColaboradorDia", objParametros);
	strhtml += "            <tbody>";
	
    for (i = 0; i < arrCarregar.data.length; i++) {
		
        strhtml += "			<tr>";
        strhtml += "  				<td>";
        strhtml += 						arrCarregar.data[i]['t_ds_tipo_apontamento'];
        strhtml += "  				</td>";
        strhtml += "  				<td>";
		strhtml += 						arrCarregar.data[i]['t_ds_lead'];
        strhtml += "  				</td>"; 
		strhtml += "  				<td>";
		strhtml += 						arrCarregar.data[i]['t_dt_apontamento'];
        strhtml += "  				</td>";
        strhtml += "  				<td>";
		strhtml += 						arrCarregar.data[i]['t_ds_usuario'];
        strhtml += "  				</td>";
        strhtml += "  				<td>";
        strhtml += "                     <img width=18 height=18 src='../img/excluir.png' class='' onclick='fcExcluir("+arrCarregar.data[i]['t_pk']+","+arrCarregar.data[i]['t_tipo_apontamento_pk']+", "+arrCarregar.data[i]['t_apontamento_ponto_pk']+")'>";
        strhtml += "  				</td>";
        strhtml += "			</tr>";
	}
    strhtml += "            </tbody>";
    strhtml += "        </table>";
    strhtml += "    </div>";
    strhtml += "</div>";

    $("#tabelaHistoricoApontamento").show();
    $("#tabelaHistoricoApontamento").html(strhtml);
}

function fctblPostoTrabalho(colaborador_pk, dt_apontamento, leads_pk){
	
   //Table de postos de trabalho
    var strghtml = "";
	strghtml += "	<div class='row'>";
	strghtml += "		<div class='col-md-12'>";
	strghtml += "			<h6 for='ic_contrato'>&nbsp;&nbsp;&nbsp;Posto de Trabalho &nbsp;</h6>";
	strghtml += "			<hr> ";
	strghtml += "		</div> ";
	strghtml += "	</div> ";		
    strghtml += "<div class='row' style='margin:2px;width:790px;'>";
    strghtml += "    <div class='col-md-12'>";
    strghtml += "        <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblPostoTrabalho'>";
    strghtml += "            <thead>";
    strghtml += "                <tr>";
    strghtml += "                    <th>Posto de Trabalho</th>";
    strghtml += "                    <th>Serviço</th>";
    strghtml += "                    <th>Escala</th>";
    strghtml += "                </tr>";
strghtml += "            </thead>";
	
	var objParametros = {
        "colaborador_pk": colaborador_pk,
        "dt_apontamento": dt_apontamento
		
    };
    var arrCarregar = carregarController("agenda_colaborador_padrao", "listarEscalasPostosColaborador", objParametros);

    //NewWindow(v_last_url);
            
	strghtml += "            <tbody>";
    for (i = 0; i < arrCarregar.data.length; i++) {
        strghtml += "			<tr>";
        strghtml += "  				<td> ";

        if(leads_pk == arrCarregar.data[i]['leads_pk']){
		    strghtml += "  					<input type='radio' name='agendaPadrao_leads' id='agendaPadrao_leads' value='"+arrCarregar.data[i]['agenda_colaborador_padrao_pk']+" - "+arrCarregar.data[i]['leads_pk']+"' checked >&nbsp;&nbsp;<span>"+arrCarregar.data[i]['ds_lead']+"<span> ";
        } else{
            strghtml += "  					<input type='radio' name='agendaPadrao_leads' id='agendaPadrao_leads' value='"+arrCarregar.data[i]['agenda_colaborador_padrao_pk']+" - "+arrCarregar.data[i]['leads_pk']+"' >&nbsp;&nbsp;<span>"+arrCarregar.data[i]['ds_lead']+"<span> ";
         
        }
        strghtml += "  					<div class='row' id='alert_agendaPadrao_leads' style='display:none'> <span aling='center' style='color: red'>&nbsp;&nbsp;Por favor, informe Posto de trabalho!</span> </div> ";
        strghtml += "  				</td>";
        strghtml += "  				<td>";
        strghtml += 						arrCarregar.data[i]['ds_produto_servico'];
        strghtml += "  				</td>";
        strghtml += "  				<td>";
        strghtml += 						arrCarregar.data[i]['ds_escala'];
        strghtml += "  				</td>";
        strghtml += "			</tr>";
    }
    strghtml += "            </tbody>";
    strghtml += "        </table>";
    strghtml += "    </div>";
    strghtml += "</div>";
	
	$("#tabelaPostoTrabalho").show();
    $("#tabelaPostoTrabalho").html(strghtml);
}

function fcAbrirApontamento(colaborador_pk) {
    
    $("#tipo_apontamento_pk").val("");
    $("#dt_apontamento").val("");
    $("#dv_formulario_ponto").hide();
    $("#dv_formulario_falta").hide();
    $("#dv_formulario_folga").hide();
    $("#dv_formulario_troca_escala").hide();
    $("#dv_formulario_afastamento").hide();
    $("#dv_formulario_ferias").hide();
    $("#dv_formulario_servico_extra").hide();
    $("#tabelaPostoTrabalho").hide();
    $("#tabelaHistoricoApontamento").hide();
    $("#colaborador_pk_modal").val("");
    fcColaboradorModal(colaborador_pk);
    $("#colaborador_pk_modal").chosen({width: "100%"});
    $(".chzn-select").chosen({ allow_single_deselect: true });
   
    $("#janela_apontamento_colaborador").modal();
}

function fcAbrirJanelaForm(colaborador_pk, tipo_apontamento_pk) {
		
		$("#dv_formulario_ponto").hide();
		$("#dv_formulario_falta").hide();
		$("#dv_formulario_folga").hide();
		$("#dv_formulario_troca_escala").hide();
		$("#dv_formulario_afastamento").hide();
		$("#dv_formulario_ferias").hide();
		$("#dv_formulario_servico_extra").hide();
		
		switch(tipo_apontamento_pk){
				
			case "1": 
				$("#dv_formulario_ponto").show();
                fcLimparFormPonto();
				break;
			case "2":
				$("#dv_formulario_falta").show();
                fcLimparFormFalta();
                fcCarregarCoberturaFalta(colaborador_pk);
                fcCarregarLeadsFalta();
				break;
			case "3":
				$("#dv_formulario_folga").show();
                fcLimparFormFolga();
                fcCarregarLeadsFT();
				break;
			case "4":
				$("#dv_formulario_troca_escala").show();
                fcLimparFormTrocaEscala();
                fcCarregarCoberturaTrocaEscala(colaborador_pk);
				break;
			case "5":
				$("#dv_formulario_afastamento").show();
                fcLimparFormAfastamento();
                fcCarregarCoberturaAfastamento(colaborador_pk);
				break;
			case "6":
				$("#dv_formulario_ferias").show();
                fcLimparFormFerias();
                fcCarregarCoberturaFerias(colaborador_pk);
				break;
			case "7":
				$("#dv_formulario_servico_extra").show();
                fcLimparFormServicoExtra();
				break;
			
		}		
}

function fcChangeCarregarTabelas(colaborador_pk, dt_apontamento, leads_pk){
	
    var tipo_apontamento_pk = $("#tipo_apontamento_pk").val();
	if ($("#origem").val() == ""){
        var colaborador_pk = $("#colaborador_pk_modal").val();
        var dt_apontamento = $("#dt_apontamento").val();
    }
    
	if((colaborador_pk != "") && (dt_apontamento != "")){
        fcConsultarDsPin(colaborador_pk);
		fcTblHistoricoApontamento(colaborador_pk, dt_apontamento, tipo_apontamento_pk);
		fctblPostoTrabalho(colaborador_pk, dt_apontamento, tipo_apontamento_pk, leads_pk);
        fcChangeCarregarFormularios();
	}
	
}

function fcChangeCarregarFormularios(){
    var colaborador_pk = $("#colaborador_pk_modal").val();
    var dt_apontamento = $("#dt_apontamento").val();
    var tipo_apontamento_pk = $("#tipo_apontamento_pk").val();
    
	if((colaborador_pk != "") && (dt_apontamento != "") && (tipo_apontamento_pk > 0)){
        fcAbrirJanelaForm(colaborador_pk, tipo_apontamento_pk);	
	}
	
}

function fcConsultarDsPin(colaborador_pk){
    
    var objParametros = {
        "pk": colaborador_pk
		
    };
	
	var arrCarregar = carregarController("colaborador", "listarDsPin", objParametros);
    var ds_pin = arrCarregar.data[0]['ds_pin'];
	var strhtml = "";
    strhtml += "<input type='hidden' name='ds_pin' id='ds_pin' value='"+ds_pin+"'>";
    $("#inputDsPin").html(strhtml);

}

function fcValidarFormulario(){
    
	var tipo_apontamento_pk = $("#tipo_apontamento_pk").val();
    
    if($("#tipo_apontamento_pk").val()==""){
        $("#alert_tipo_apontamento_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_apontamento_pk").slideUp(500);
        });
        $('#tipo_apontamento_pk').focus();
        return false;
    }     
    if($("#colaborador_pk_modal").val()==""){
        $("#alert_colaborador_pk_modal").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_colaborador_pk_modal").slideUp(500);
        });
        $('#colaborador_pk_modal').focus();
        return false;
    }    
    if($("#dt_apontamento").val()==""){
        $("#alert_dt_apontamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_apontamento").slideUp(500);
        });
        $('#dt_apontamento').focus();
        return false;
    } 
    if($("#agendaPadrao_leads").prop('checked') == false){
        $("#alert_agendaPadrao_leads").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_agendaPadrao_leads").slideUp(500);
        });
        $('#agendaPadrao_leads').focus();
        return false;
    } 
    
    var agendaPadrao_leads =  $("#agendaPadrao_leads").val();
    var arr = agendaPadrao_leads.split("-");

    agenda_colaborador_padrao_pk = arr[0];
    leads_pk = arr[1];

    switch(tipo_apontamento_pk){
        case "1":{
            
            if($("#tipo_ponto_pk").val()==""){
                $("#alert_tipo_ponto_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_tipo_ponto_pk").slideUp(500);
                });
                $('#tipo_ponto_pk').focus();
                return false;
            }  
            if ($("#hr_sistema").prop('checked') == false ) {
                if($("#hr_manual").val()==""){
                    $("#alert_hr_manual_sistema").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert_hr_manual_sistema").slideUp(500);
                    });
                    $('#hr_manual').focus();
                    return false;
                }  
            }

            var v_hr_sistema = "";
            var v_tipo_ponto_pk = $("#tipo_ponto_pk").val();
            var v_ds_obs_ponto = $("#ds_obs_ponto").val();
            if($("#hr_sistema").prop('checked') == true){
                v_hr_sistema = 1;
            }
            var v_hr_manual = $("#hr_manual").val();
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_dt_ponto = $("#dt_apontamento").val();
            var v_ds_pin = $("#ds_pin").val();
            var v_leads_pk = leads_pk;
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "tipo_ponto_pk": (v_tipo_ponto_pk),
                "ds_obs_ponto": (v_ds_obs_ponto),
                "hr_sistema": (v_hr_sistema),
                "hr_manual": (v_hr_manual),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_ponto": (v_dt_ponto),
                "ds_pin": (v_ds_pin),
                "dt_apontamento": (v_dt_apontamento)
            };  

            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            
            //NewWindow(v_last_url);
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "2":{
            
            if($("#motivo_falta_pk").val()==""){
                $("#alert_motivo_falta_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_motivo_falta_pk").slideUp(500);
                });
                $('#motivo_falta_pk').focus();
                return false;
            }   
            

            var v_motivo_falta_pk = $("#motivo_falta_pk").val();
            var v_colaborador_cobertura_falta_pk = $("#colaborador_cobertura_falta_pk").val();
            var v_ds_obs_falta = $("#ds_obs_falta").val(); 
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_leads_pk = leads_pk;
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_dt_falta = $("#dt_apontamento").val();
            var v_motivo_cobertura_pk = $("#motivo_cobertura_falta_pk").val();
            var v_vl_ft_falta = $("#vl_ft_falta").val();
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "motivo_falta_pk": (v_motivo_falta_pk),
                "colaborador_cobertura_falta_pk": (v_colaborador_cobertura_falta_pk),
                "ds_obs_falta": (v_ds_obs_falta), 
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_apontamento": (v_dt_apontamento),
                "lead_cobertura_falta_pk": (v_leads_pk),
                "vl_ft_falta": (v_vl_ft_falta),
                "motivo_cobertura_falta_pk": (v_motivo_cobertura_pk),
                "dt_falta": (v_dt_falta)
            };  

            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            if (arrEnviar.result == 'success'){
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "3":{
            
            if($("#motivo_folga_pk").val()==""){
                $("#alert_motivo_folga_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_motivo_folga_pk").slideUp(500);
                });
                $('#motivo_folga_pk').focus();
                return false;
            }  
            if($("#motivo_folga_pk").val()== 1 && $("#motivo_ft_pk").val()==""){
                $("#alert_motivo_ft_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_motivo_ft_pk").slideUp(500);
                });
                $('#motivo_ft_pk').focus();
                return false;
            }     
            if($("#motivo_folga_pk").val()== 1 && $("#lead_cobertura_pk").val()==""){
                $("#alert_leads_ft").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_leads_ft").slideUp(500);
                });
                $('#motivo_folga_pk').focus();
                return false;
            }     

            var v_motivo_folga_pk = $("#motivo_folga_pk").val();
            var v_motivo_ft_pk = $("#motivo_ft_pk").val();
            var v_vl_ft = $("#vl_ft").val();
            var v_lead_cobertura_pk = $("#lead_cobertura_pk").val();
            var v_ds_obs_folga = $("#ds_obs_folga").val(); 
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_leads_pk = leads_pk;
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_dt_folga = $("#dt_apontamento").val();
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "motivo_ft_pk": (v_motivo_ft_pk),
                "motivo_folga_pk": (v_motivo_folga_pk),
                "lead_cobertura_pk": (v_lead_cobertura_pk),
                "ds_obs_folga": (v_ds_obs_folga),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "dt_folga": (v_dt_folga),
                "vl_ft": (v_vl_ft),
                "dt_apontamento": (v_dt_apontamento)
            };  

            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "4":{
            
            if($("#colaborador_cobertura_troca_escala_pk").val()==""){
                $("#alert_colaborador_cobertura_troca_escala_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_colaborador_cobertura_troca_escala_pk").slideUp(500);
                });
                $('#colaborador_cobertura_troca_escala_pk').focus();
                return false;
            }  
            if($("#motivos_troca_escala_pk").val()== ""){
                $("#alert_motivos_troca_escala_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_motivos_troca_escala_pk").slideUp(500);
                });
                $('#motivos_troca_escala_pk').focus();
                return false;
            }   

            var v_colaborador_cobertura_troca_escala_pk = $("#colaborador_cobertura_troca_escala_pk").val();
            var v_motivos_troca_escala_pk = $("#motivos_troca_escala_pk").val();
            var v_ds_obs_troca_escala = $("#ds_obs_troca_escala").val();
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_leads_pk = leads_pk;
            var v_dt_troca_escala = $("#dt_apontamento").val();
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "colaborador_cobertura_troca_escala_pk": (v_colaborador_cobertura_troca_escala_pk),
                "motivos_troca_escala_pk": (v_motivos_troca_escala_pk),
                "ds_obs_troca_escala": (v_ds_obs_troca_escala),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "dt_troca_escala": (v_dt_troca_escala),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_apontamento": (v_dt_apontamento)
            };  

            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "5":{
            
            if($("#motivo_afastamento_pk").val()==""){
                $("#alert_motivo_afastamento_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_motivo_afastamento_pk").slideUp(500);
                });
                $('#motivo_afastamento_pk').focus();
                return false;
            }  
            if($("#dt_ini_afastamento").val()== ""){
                $("#alert_dt_ini_afastamento").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_ini_afastamento").slideUp(500);
                });
                $('#dt_ini_afastamento').focus();
                return false;
            } 
            if($("#dt_fim_afastamento").val()== ""){
                $("#alert_dt_fim_afastamento").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_fim_afastamento").slideUp(500);
                });
                $('#dt_fim_afastamento').focus();
                return false;
            }      

            var v_motivo_afastamento_pk = $("#motivo_afastamento_pk").val();
            var v_dt_ini_afastamento = $("#dt_ini_afastamento").val();
            var v_dt_fim_afastamento = $("#dt_fim_afastamento").val();
            var v_colaborador_cobertura_afastamento_pk = $("#colaborador_cobertura_afastamento_pk").val();
            var v_ds_obs_afastamento = $("#ds_obs_afastamento").val();
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_leads_pk = leads_pk;
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "motivo_afastamento_pk": (v_motivo_afastamento_pk),
                "dt_ini_afastamento": (v_dt_ini_afastamento),
                "dt_fim_afastamento": (v_dt_fim_afastamento),
                "colaborador_cobertura_afastamento_pk": (v_colaborador_cobertura_afastamento_pk),
                "ds_obs_afastamento": (v_ds_obs_afastamento),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_apontamento": (v_dt_apontamento)
            };  
            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "6":{
            
            if($("#dt_ini_ferias").val()==""){
                $("#alert_dt_ini_ferias").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_ini_ferias").slideUp(500);
                });
                $('#dt_ini_ferias').focus();
                return false;
            }  
            if($("#dt_fim_ferias").val()== ""){
                $("#alert_dt_fim_ferias").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_fim_ferias").slideUp(500);
                });
                $('#dt_fim_ferias').focus();
                return false;
            }   

            var v_dt_ini_ferias = $("#dt_ini_ferias").val();
            var v_dt_fim_ferias = $("#dt_fim_ferias").val();
            var v_colaborador_cobertura_ferias_pk = $("#colaborador_cobertura_ferias_pk").val();
            var v_ds_obs_ferias = $("#ds_obs_ferias").val();
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_leads_pk = leads_pk;
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "dt_ini_ferias": (v_dt_ini_ferias),
                "dt_fim_ferias": (v_dt_fim_ferias),
                "colaborador_cobertura_ferias_pk": (v_colaborador_cobertura_ferias_pk),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "ds_obs_ferias": (v_ds_obs_ferias),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_apontamento": (v_dt_apontamento)
            };  
            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }
        case "7":{
            
            if($("#leads_pk_modal").val()==""){
                $("#alert_leads_pk_modal").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_leads_pk_modal").slideUp(500);
                });
                $('#leads_pk_modal').focus();
                return false;
            }  
            if($("#dt_ini_exec_servico").val()== ""){
                $("#alert_dt_ini_exec_servico").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_ini_exec_servico").slideUp(500);
                });
                $('#dt_ini_exec_servico').focus();
                return false;
            } 
            if($("#dt_fim_exec_servico").val()== ""){
                $("#alert_dt_fim_exec_servico").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_dt_fim_exec_servico").slideUp(500);
                });
                $('#dt_fim_exec_servico').focus();
                return false;
            } 
            if($("#contrato_pk").val()==""){
                $("#alert_contrato_pk").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_contrato_pk").slideUp(500);
                });
                $('#contrato_pk').focus();
                return false;
            }     
            if($("#vl_servico").val()==""){
                $("#alert_vl_servico").fadeTo(2000, 500).slideUp(500, function(){
                    $("#alert_vl_servico").slideUp(500);
                });
                $('#vl_servico').focus();
                return false;
            }     
            
            var v_leads_pk_modal = $("#leads_pk_modal").val();
            var v_dt_ini_exec_servico = $("#dt_ini_exec_servico").val();
            var v_dt_fim_exec_servico = $("#dt_fim_exec_servico").val();
            var v_contrato_pk = $("#contrato_pk").val();
            var v_vl_servico = $("#vl_servico").val();
            var v_colaborador_pk = $("#colaborador_pk_modal").val();
            var v_ds_obs_servico_extra = $("#ds_obs_servico_extra").val();
            var v_dt_apontamento = $("#dt_apontamento").val();
            var v_leads_pk = leads_pk;
            var v_agenda_colaborador_padrao_pk = agenda_colaborador_padrao_pk;
            var v_tipo_apontamento_pk = tipo_apontamento_pk;
            
            var objParametros = {
                "leads_pk_modal": (v_leads_pk_modal),
                "dt_ini_exec_servico": (v_dt_ini_exec_servico),
                "dt_fim_exec_servico": (v_dt_fim_exec_servico),
                "contrato_pk": (v_contrato_pk),
                "vl_servico": (v_vl_servico),
                "ds_obs_servico_extra": (v_ds_obs_servico_extra),
                "colaborador_pk": (v_colaborador_pk),
                "leads_pk": (v_leads_pk),
                "agenda_colaborador_padrao_pk": (v_agenda_colaborador_padrao_pk),
                "tipo_apontamento_pk": (v_tipo_apontamento_pk),
                "dt_apontamento": (v_dt_apontamento)
            }; 
            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvar", objParametros);
            if (arrEnviar.result == 'success'){
                // Reload datable
                alert(arrEnviar.message);
                $("#janela_apontamento_colaborador").modal("hide");
            }
            else{
                alert('Falhou a requisição para salvar o registro');
            }

        }

    }
    
}

$(document).ready(function () {

    $('#dt_apontamento').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_apontamento").keypress(function () {
        mascara(this, mdata);
    });
    
    if($("#origem").val() == "calendario_escala" || $("#origem").val() == "mesa_operacional"){
        $("#dt_apontamento").prop("disabled", true);
        $("#tipo_apontamento_pk").on('change', function(){
            fcChangeCarregarFormularios();
        });
    }else{
        $("#colaborador_pk_modal").on('change', function(){
            fcChangeCarregarTabelas();   
        });
        $("#dt_apontamento").on('change', function(){
            fcChangeCarregarTabelas();   
        });
        $("#tipo_apontamento_pk").on('change', function(){
            fcChangeCarregarFormularios();   
        });
    }
    $("#cmdEnviar").on('click', function(){
        fcValidarFormulario();   
        $(".chzn-select").chosen("destroy");
    });
    
    
});

function fcteste(pk) {
    alert(pk);
}