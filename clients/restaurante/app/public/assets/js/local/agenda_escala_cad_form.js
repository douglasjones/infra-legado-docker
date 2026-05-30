function fcCarregar(){
    if($("#pk").val()!=""){
        var objParametros = {
            "pk": $("#pk").val()
        };
        var objRegistro = carregarController("agenda_colaborador_padrao", "listarPk", objParametros);

        if (objRegistro.status == true){


            $("#pk").val(objRegistro.data['pk']);
            $("#exibir_data_cancelamento").show();
            $("#dt_inicio_agenda").val(objRegistro.data['dt_inicio_agenda']);
            $("#dt_fim_agenda").val(objRegistro.data['dt_fim_agenda']);
            $("#escala_cargos_pk").val(objRegistro.data['produtos_servicos_pk']);
            $("#escala_colaborador_pk").val(objRegistro.data['colaboradores_pk']);
            $("#escala_leads_pk").val(objRegistro.data['leads_pk']);
            $("#dt_cancelamento_agenda_escala").val(objRegistro.data['dt_cancelamento']);
            $("#ds_motivo_cancelamento").val(objRegistro.data['ds_motivo_cancelamento']);
            $("#tipo_escala_pk").val(objRegistro.data['tipos_escalas_pk']);
            if(objRegistro.data['ds_escala']=="12X36"){
                $("#exibir_variacao_escala").show()
            }
            else{
                $("#exibir_variacao_escala").hide();
            }
            $("#ic_variacao_dias_escala").val(objRegistro.data['ic_variacao_dias_escala']);
            if(objRegistro.data['ic_escala_dom']==1){
                $("#ic_dom").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_seg']==1){
                $("#ic_seg").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_ter']==1){
                $("#ic_ter").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_qua']==1){
                $("#ic_qua").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_qui']==1){
                $("#ic_qui").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_sex']==1){
                $("#ic_sex").prop("checked", true);
            }
            if(objRegistro.data['ic_escala_sab']==1){
                $("#ic_sab").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_dom']==1){
                $("#ic_dom_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_seg']==1){
                $("#ic_seg_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_ter']==1){
                $("#ic_ter_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_qua']==1){
                $("#ic_qua_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_qui']==1){
                $("#ic_qui_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_sex']==1){
                $("#ic_sex_folga").prop("checked", true);
            }
            if(objRegistro.data['ic_folga_sab']==1){
                $("#ic_sab_folga").prop("checked", true);
            }
            $("#dom_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#seg_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#ter_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#qua_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#qui_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#sex_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#sab_turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#hr_turno_dom").val(objRegistro.data['hr_inicio_exp_dom']);
            $("#hr_turno_seg").val(objRegistro.data['hr_inicio_exp_seg']);
            $("#hr_turno_ter").val(objRegistro.data['hr_inicio_exp_ter']);
            $("#hr_turno_qua").val(objRegistro.data['hr_inicio_exp_qua']);
            $("#hr_turno_qui").val(objRegistro.data['hr_inicio_exp_qui']);
            $("#hr_turno_sex").val(objRegistro.data['hr_inicio_exp_sex']);
            $("#hr_turno_sab").val(objRegistro.data['hr_inicio_exp_sab']);
            $("#hr_turno_dom_saida").val(objRegistro.data['hr_termino_expediente_dom']);
            $("#hr_turno_seg_saida").val(objRegistro.data['hr_termino_expediente_seg']);
            $("#hr_turno_ter_saida").val(objRegistro.data['hr_termino_expediente_ter']);
            $("#hr_turno_qua_saida").val(objRegistro.data['hr_termino_expediente_qua']);
            $("#hr_turno_qui_saida").val(objRegistro.data['hr_termino_expediente_qui']);
            $("#hr_turno_sex_saida").val(objRegistro.data['hr_termino_expediente_sex']);
            $("#hr_turno_sab_saida").val(objRegistro.data['hr_termino_expediente_sab']);
            $("#hr_intervalo_dom").val(objRegistro.data['hr_inicio_intervalo_dom']);
            $("#hr_intervalo_seg").val(objRegistro.data['hr_inicio_intervalo_seg']);
            $("#hr_intervalo_ter").val(objRegistro.data['hr_inicio_intervalo_ter']);
            $("#hr_intervalo_qua").val(objRegistro.data['hr_inicio_intervalo_qua']);
            $("#hr_intervalo_qui").val(objRegistro.data['hr_inicio_intervalo_qui']);
            $("#hr_intervalo_sex").val(objRegistro.data['hr_inicio_intervalo_sex']);
            $("#hr_intervalo_sab").val(objRegistro.data['hr_inicio_intervalo_sab']);
            $("#hr_intervalo_saida_dom").val(objRegistro.data['hr_termino_intervalo_dom']);
            $("#hr_intervalo_saida_seg").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#hr_intervalo_saida_ter").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#hr_intervalo_saida_qua").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#hr_intervalo_saida_qui").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#hr_intervalo_saida_sex").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#hr_intervalo_saida_sab").val(objRegistro.data['hr_termino_intervalo_ter']);
            $("#turnos_pk").val(objRegistro.data['turnos_pk']);
            $("#hr_inicio_expediente").val(objRegistro.data['hr_inicio_expediente']);
            $("#hr_termino_expediente").val(objRegistro.data['hr_termino_expediente']);
            $("#hr_inicio_intervalo").val(objRegistro.data['hr_inicio_intervalo']);
            $("#hr_termino_intervalo").val(objRegistro.data['hr_termino_intervalo']);
            $("#obs").val(objRegistro.data['obs']);
            if(objRegistro.data['ic_intrajornada']==1){
                $("#ic_intrajornada").prop("checked", true);
            }
        }
        else{
            utilsJS.toastNotify(false, 'Falhar ao carregar o registro');
        }
    }
}

function fcEnviarEscala(){

    //variaveis
    var ic_dom = 2;
    var ic_seg = 2;
    var ic_ter = 2;
    var ic_qua = 2;
    var ic_qui = 2;
    var ic_sex = 2;
    var ic_sab = 2;
    var ic_dom_folga = 2;
    var ic_seg_folga = 2;
    var ic_ter_folga = 2;
    var ic_qua_folga = 2;
    var ic_qui_folga = 2;
    var ic_sex_folga = 2;
    var ic_sab_folga = 2;

    //validações do grid de escala
    if ($('#tipos_escalas_pk').val() == "") {
        utilsJS.toastNotify(false,'Por favor, informe o tipo de escala!');
        $('#tipos_escalas_pk').focus();
        return false;
    }

    if ($('#ic_dom').is(":checked") && $('#dom_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#dom_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_seg').is(":checked") && $('#seg_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#seg_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_ter').is(":checked") && $('#ter_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#ter_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_qua').is(":checked") && $('#qua_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#qua_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_qui').is(":checked") && $('#qui_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#qui_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_sex').is(":checked") && $('#sex_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#sex_turnos_pk').focus();
        return false;
    }
    else if ($('#ic_sab').is(":checked") && $('#sab_turnos_pk').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#sab_turnos_pk').focus();
        return false;
    }
    //HORARIO
    else if ($('#ic_dom').is(":checked") && $('#hr_turno_dom').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_dom').focus();
        return false;
    }
    else if ($('#ic_seg').is(":checked") && $('#hr_turno_seg').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_seg').focus();
        return false;
    }
    else if ($('#ic_ter').is(":checked") && $('#hr_turno_ter').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_ter').focus();
        return false;
    }
    else if ($('#ic_qua').is(":checked") && $('#hr_turno_qua').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_qua').focus();
        return false;
    }
    else if ($('#ic_qui').is(":checked") && $('#hr_turno_qui').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_qui').focus();
        return false;
    }
    else if ($('#ic_sex').is(":checked") && $('#hr_turno_sex').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_sex').focus();
        return false;
    }
    else if ($('#ic_sab').is(":checked") && $('#hr_turno_sab').val() == "") {
        $("#alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert").slideUp(500);
        });
        $('#hr_turno_sab').focus();
        return false;
    }

    if ($('#ic_dom').is(":checked")) {
        ic_dom = 1;
    }
    if ($('#ic_seg').is(":checked")) {
        ic_seg = 1;
    }
    if ($('#ic_ter').is(":checked")) {
        ic_ter = 1;
    }
    if ($('#ic_qua').is(":checked")) {
        ic_qua = 1;
    }
    if ($('#ic_qui').is(":checked")) {
        ic_qui = 1;
    }
    if ($('#ic_sex').is(":checked")) {
        ic_sex = 1;
    }
    if ($('#ic_sab').is(":checked")) {
        ic_sab = 1;
    }

    if ($('#ic_dom_folga').is(":checked")) {
        ic_dom_folga = 1;
    }
    if ($('#ic_seg_folga').is(":checked")) {
        ic_seg_folga = 1;
    }
    if ($('#ic_ter_folga').is(":checked")) {
        ic_ter_folga = 1;
    }
    if ($('#ic_qua_folga').is(":checked")) {
        ic_qua_folga = 1;
    }
    if ($('#ic_qui_folga').is(":checked")) {
        ic_qui_folga = 1;
    }
    if ($('#ic_sex_folga').is(":checked")) {
        ic_sex_folga = 1;
    }
    if ($('#ic_sab_folga').is(":checked")) {
        ic_sab_folga = 1;
    }
    var  ic_intrajornada = ""
    if ($('#ic_intrajornada').is(":checked")) {
        ic_intrajornada = 1;
    }


    formdataEscala.append("pk",$("#pk").val());
    formdataEscala.append("colaboradores_pk",$("#escala_colaborador_pk").val());
    formdataEscala.append("produtos_servicos_pk",$("#escala_cargos_pk").val());
    formdataEscala.append("dt_inicio_agenda",$("#dt_inicio_agenda").val());
    formdataEscala.append("dt_fim_agenda",$("#dt_fim_agenda").val());
    formdataEscala.append("turnos_pk",$("#turnos_pk").val());
    formdataEscala.append("hr_inicio_expediente",$("#hr_inicio_expediente").val());
    formdataEscala.append("hr_termino_expediente",$("#hr_termino_expediente").val());
    formdataEscala.append("hr_inicio_intervalo",$("#hr_inicio_intervalo").val());
    formdataEscala.append("hr_termino_intervalo",$("#hr_termino_intervalo").val());
    formdataEscala.append("ic_intrajornada",ic_intrajornada);
    formdataEscala.append("ic_variacao_dias_escala",$("#ic_variacao_dias_escala").val());
    formdataEscala.append("tipos_escalas_pk",$("#tipo_escala_pk").val());
    formdataEscala.append("ic_folga_dom",ic_dom_folga);
    formdataEscala.append("ic_folga_seg",ic_seg_folga);
    formdataEscala.append("ic_folga_ter",ic_ter_folga);
    formdataEscala.append("ic_folga_qua",ic_qua_folga);
    formdataEscala.append("ic_folga_qui",ic_qui_folga);
    formdataEscala.append("ic_folga_sex",ic_sex_folga);
    formdataEscala.append("ic_folga_sab",ic_sab_folga);
    formdataEscala.append("ic_escala_dom",ic_dom);
    formdataEscala.append("ic_escala_seg",ic_seg);
    formdataEscala.append("ic_escala_ter",ic_ter);
    formdataEscala.append("ic_escala_qua",ic_qua);
    formdataEscala.append("ic_escala_qui",ic_qui);
    formdataEscala.append("ic_escala_sex",ic_sex);
    formdataEscala.append("ic_escala_sab",ic_sab);
    formdataEscala.append("hr_inicio_exp_dom",$("#hr_turno_dom").val());
    formdataEscala.append("hr_inicio_exp_seg",$("#hr_turno_seg").val());
    formdataEscala.append("hr_inicio_exp_ter",$("#hr_turno_ter").val());
    formdataEscala.append("hr_inicio_exp_qua",$("#hr_turno_qua").val());
    formdataEscala.append("hr_inicio_exp_qui",$("#hr_turno_qui").val());
    formdataEscala.append("hr_inicio_exp_sex",$("#hr_turno_sex").val());
    formdataEscala.append("hr_inicio_exp_sab",$("#hr_turno_sab").val());
    formdataEscala.append("hr_inicio_intervalo_dom",$("#hr_intervalo_dom").val());
    formdataEscala.append("hr_inicio_intervalo_seg",$("#hr_intervalo_seg").val());
    formdataEscala.append("hr_inicio_intervalo_ter",$("#hr_intervalo_ter").val());
    formdataEscala.append("hr_inicio_intervalo_qua",$("#hr_intervalo_qua").val());
    formdataEscala.append("hr_inicio_intervalo_qui",$("#hr_intervalo_qui").val());
    formdataEscala.append("hr_inicio_intervalo_sex",$("#hr_intervalo_sex").val());
    formdataEscala.append("hr_inicio_intervalo_sab",$("#hr_intervalo_sab").val());
    formdataEscala.append("hr_termino_intervalo_dom",$("#hr_intervalo_saida_dom").val());
    formdataEscala.append("hr_termino_intervalo_seg",$("#hr_intervalo_saida_seg").val());
    formdataEscala.append("hr_termino_intervalo_ter",$("#hr_intervalo_saida_ter").val());
    formdataEscala.append("hr_termino_intervalo_qua",$("#hr_intervalo_saida_qua").val());
    formdataEscala.append("hr_termino_intervalo_qui",$("#hr_intervalo_saida_qui").val());
    formdataEscala.append("hr_termino_intervalo_sex",$("#hr_intervalo_saida_sex").val());
    formdataEscala.append("hr_termino_intervalo_sab",$("#hr_intervalo_saida_sab").val());
    formdataEscala.append("hr_termino_expediente_dom",$("#hr_turno_dom_saida").val());
    formdataEscala.append("hr_termino_expediente_seg",$("#hr_turno_seg_saida").val());
    formdataEscala.append("hr_termino_expediente_ter",$("#hr_turno_ter_saida").val());
    formdataEscala.append("hr_termino_expediente_qua",$("#hr_turno_qua_saida").val());
    formdataEscala.append("hr_termino_expediente_qui",$("#hr_turno_qui_saida").val());
    formdataEscala.append("hr_termino_expediente_sex",$("#hr_turno_sex_saida").val());
    formdataEscala.append("hr_termino_expediente_sab",$("#hr_turno_sab_saida").val());
    formdataEscala.append("dt_cancelamento",$("#dt_cancelamento_agenda_escala").val());
    formdataEscala.append("ds_motivo_cancelamento",$("#ds_motivo_cancelamento").val());
    formdataEscala.append("obs",$("#obs").val());
    formdataEscala.append("leads_pk",$("#escala_leads_pk").val());
    utilsJS.loading("Salvando...");
    $.ajax({
        type: 'POST',
        url: '/api/agenda_colaborador_padrao/salvar',
        data: formdataEscala,
        processData: false,
        contentType: false,
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                if(log.status==true){
                    $("#pk").val(log.data);
                    fcCadastrarEscala();
                }
                else{
                    utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
                }

            } catch (e) {
                utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
            }
        }
    });
}

function fcCadastrarEscala() {
    var objParametros = {
        "agenda_colaborador_padrao_pk": $("#pk").val(),
        "leads_pk": $("#escala_leads_pk").val(),
        "colaboradores_pk": $("#escala_colaborador_pk").val(),
        "dt_periodo_ini": $("#dt_inicio_agenda").val(),
        "dt_periodo_fim": $("#dt_fim_agenda").val(),
        "tipo_escala_pk": $("#tipo_escala_pk").val(),
        "ds_escala": $('#tipo_escala_pk option:selected').text(),
    }

    var arrEnviar = carregarController("agenda_colaborador_padrao", "escalaDadosColaborador", objParametros);
    //NewWindow(v_last_url)
    if (arrEnviar.status == true) {
        utilsJS.loaded();
        utilsJS.toastNotify(true,"Dados salvos com Sucesso!");
        setTimeout(function(){
            sendPost('agenda_colaborador_padrao','receptivoEscala',{})
        }, 500);
    } else {
        utilsJS.toastNotify(false,arrEnviar.result);
    }
}

function fcCarregarLead() {
    //Carrega os grupos

    var objParametros = {

    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    carregarComboAjax($("#escala_leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}

function fcCarregarColaboradorByFuncaoPk() {
    //Carrega os grupos

    var objParametros = {
        "produtos_servicos":$("#escala_cargos_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarTodosByFuncaoPk", objParametros);
    carregarComboAjax($("#escala_colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");

}
function fcCarregarTipoEscala() {
    //Carrega os grupos
    var objParametros = {
    };

    var arrCarregar = carregarController("tipo_escala", "listarTodos", objParametros);
    carregarComboAjax($("#tipo_escala_pk"), arrCarregar, " ", "pk", "ds_tipo_escala");
}
function fcIntrajornada(){
    if ($('#ic_intrajornada').is(":checked")) {
        $('#hr_inicio_intervalo').val(" ")
        $('#hr_termino_intervalo').val(" ")
        $("#hr_termino_intervalo").attr('disabled','disabled');
        $("#hr_inicio_intervalo").attr('disabled','disabled');

        $('#hr_intervalo_dom').val(" ")
        $('#hr_intervalo_seg').val(" ")
        $('#hr_intervalo_ter').val(" ")
        $('#hr_intervalo_qua').val(" ")
        $('#hr_intervalo_qui').val(" ")
        $('#hr_intervalo_sex').val(" ")
        $('#hr_intervalo_sab').val(" ")
        $("#hr_intervalo_dom").attr('disabled','disabled');
        $("#hr_intervalo_seg").attr('disabled','disabled');
        $("#hr_intervalo_ter").attr('disabled','disabled');
        $("#hr_intervalo_qua").attr('disabled','disabled');
        $("#hr_intervalo_qui").attr('disabled','disabled');
        $("#hr_intervalo_sex").attr('disabled','disabled');
        $("#hr_intervalo_sab").attr('disabled','disabled');

        $('#hr_intervalo_saida_dom').val(" ")
        $('#hr_intervalo_saida_seg').val(" ")
        $('#hr_intervalo_saida_ter').val(" ")
        $('#hr_intervalo_saida_qua').val(" ")
        $('#hr_intervalo_saida_qui').val(" ")
        $('#hr_intervalo_saida_sex').val(" ")
        $('#hr_intervalo_saida_sab').val(" ")
        $("#hr_intervalo_saida_dom").attr('disabled','disabled');
        $("#hr_intervalo_saida_seg").attr('disabled','disabled');
        $("#hr_intervalo_saida_ter").attr('disabled','disabled');
        $("#hr_intervalo_saida_qua").attr('disabled','disabled');
        $("#hr_intervalo_saida_qui").attr('disabled','disabled');
        $("#hr_intervalo_saida_sex").attr('disabled','disabled');
        $("#hr_intervalo_saida_sab").attr('disabled','disabled');
    }else{
        $("#hr_termino_intervalo").removeAttr('disabled');
        $("#hr_inicio_intervalo").removeAttr('disabled');

        $("#hr_intervalo_dom").removeAttr('disabled');
        $("#hr_intervalo_seg").removeAttr('disabled');
        $("#hr_intervalo_ter").removeAttr('disabled');
        $("#hr_intervalo_qua").removeAttr('disabled');
        $("#hr_intervalo_qui").removeAttr('disabled');
        $("#hr_intervalo_sex").removeAttr('disabled');
        $("#hr_intervalo_sab").removeAttr('disabled');

        $("#hr_intervalo_saida_dom").removeAttr('disabled');
        $("#hr_intervalo_saida_seg").removeAttr('disabled');
        $("#hr_intervalo_saida_ter").removeAttr('disabled');
        $("#hr_intervalo_saida_qua").removeAttr('disabled');
        $("#hr_intervalo_saida_qui").removeAttr('disabled');
        $("#hr_intervalo_saida_sex").removeAttr('disabled');
        $("#hr_intervalo_saida_sab").removeAttr('disabled');
    }
}

function fcPreenchimentoAutomatico() {
    //VERIFICA SE AS INFORMAÇÕES NECESSÁRIAS ESTÃO MARCADAS
    if ($("#turnos_pk").val() == "") {
        utilsJS.toastNotify(false,"Por favor, selecione o turno para o preenchimento automático!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#turnos_pk").focus();
        return false;
    }
    if ($("#hr_inicio_expediente").val() == "") {
        utilsJS.toastNotify(false,"Por favor, informe horário de início do expediente!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#hr_inicio_expediente").focus();
        return false;
    }
    if ($("#hr_termino_expediente").val() == "") {
        utilsJS.toastNotify(false,"Por favor, informe horário de termino do expediente!");
        $("#ic_preenchimento_automatico").prop("checked", false);
        $("#hr_termino_expediente").focus();
        return false;
    }
    //PRENCHIMENTO DE TURNO
    if ($("#dias_escala_servico").val() == '12x36') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", true);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", false);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);

    } else if ($("#dias_escala_servico").val() == '6x1') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", false);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", true);
    } else if ($("#dias_escala_servico").val() == '5D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '4D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", false);
        $("#ic_sex_folga").prop("checked", false);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", true);
        $("#ic_sex").prop("checked", true);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '3D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", false);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", true);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '2D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", false);
        $("#ic_qua_folga").prop("checked", true);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", true);
        $("#ic_qua").prop("checked", false);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    } else if ($("#dias_escala_servico").val() == '1D') {
        //FOLGAS
        $("#ic_dom_folga").prop("checked", true);
        $("#ic_seg_folga").prop("checked", false);
        $("#ic_ter_folga").prop("checked", true);
        $("#ic_qua_folga").prop("checked", true);
        $("#ic_qui_folga").prop("checked", true);
        $("#ic_sex_folga").prop("checked", true);
        $("#ic_sab_folga").prop("checked", true);
        //DIAS DE TRABALHO
        $("#ic_dom").prop("checked", false);
        $("#ic_seg").prop("checked", true);
        $("#ic_ter").prop("checked", false);
        $("#ic_qua").prop("checked", false);
        $("#ic_qui").prop("checked", false);
        $("#ic_sex").prop("checked", false);
        $("#ic_sab").prop("checked", false);
    }


    //TURNOS
    $("#dom_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#seg_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#ter_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#qua_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#qui_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#sex_turnos_pk").val($("#turnos_pk option:selected").val());
    $("#sab_turnos_pk").val($("#turnos_pk option:selected").val());
    //HORARIO ENTRATDA EXPEDIENTE
    $("#hr_turno_dom").val($("#hr_inicio_expediente").val());
    $("#hr_turno_seg").val($("#hr_inicio_expediente").val());
    $("#hr_turno_ter").val($("#hr_inicio_expediente").val());
    $("#hr_turno_qua").val($("#hr_inicio_expediente").val());
    $("#hr_turno_qui").val($("#hr_inicio_expediente").val());
    $("#hr_turno_sex").val($("#hr_inicio_expediente").val());
    $("#hr_turno_sab").val($("#hr_inicio_expediente").val());
    //HORARIO SAIDA INTERVALO
    $("#hr_intervalo_dom").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_seg").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_ter").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_qua").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_qui").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_sex").val($("#hr_inicio_intervalo").val());
    $("#hr_intervalo_sab").val($("#hr_inicio_intervalo").val());
    //HORARIO RETORNO INTERVALO
    $("#hr_intervalo_saida_dom").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_seg").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_ter").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_qua").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_qui").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_sex").val($("#hr_termino_intervalo").val());
    $("#hr_intervalo_saida_sab").val($("#hr_termino_intervalo").val());
    //HORARIO SAIDA EXPEDIENTE
    $("#hr_turno_dom_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_seg_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_ter_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_qua_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_qui_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_sex_saida").val($("#hr_termino_expediente").val());
    $("#hr_turno_sab_saida").val($("#hr_termino_expediente").val());
}
function fcCarregarFuncao(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("servico", "listarTodos", objParametros);
    carregarComboAjax($("#escala_cargos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");

}
$(document).ready(function(){



    $(".chzn-select").chosen({width: "200%"});


    //ESCALA
    fcCarregarLead()
    fcCarregarColaboradorByFuncaoPk();
    fcCarregarFuncao();
    $("#escala_cargos_pk").change(function(){
        fcCarregarColaboradorByFuncaoPk();
    });

    $('#dt_inicio_agenda').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_inicio_agenda").keypress(function(){
        mascara(this,mdata);
    });

    $('#dt_fim_agenda').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_fim_agenda").keypress(function(){
        mascara(this,mdata);
    });
    $('#dt_cancelamento_agenda_escala').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });

    $("#dt_cancelamento_agenda_escala").keypress(function(){
        mascara(this,mdata);
    });

    $("#hr_inicio_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_termino_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_inicio_intervalo").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_termino_intervalo").keypress(function () {
        mascara(this, horamask);
    });

    $('#ic_preenchimento_automatico').click(function () {
        fcPreenchimentoAutomatico();//FUNÇÃO DE PREENCHIMENTO AUTOMATICO
    });
    $('#tipo_escala_pk').change(function () {
        if($('#tipo_escala_pk option:selected').text()=="12X36"){
            $("#exibir_variacao_escala").show()
        }
        else{
            $("#exibir_variacao_escala").hide();
        }
    });

    fcCarregarTipoEscala();
    $(document).on('click', '#cmdEnviarEscala', fcEnviarEscala);
    $(document).on('click', '#cmdEnviarEscala1', fcEnviarEscala);
    $(document).on('click', '#ic_intrajornada', fcIntrajornada);



    formdataEscala = new FormData();

    fcCarregar();

});
var formdataEscala = null;