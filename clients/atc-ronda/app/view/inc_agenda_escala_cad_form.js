function fcSalvar() {
    try{
 //variaveis
 var ic_folga_inverter = 2;
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
 var ic_preenchimento_automatico = 2;
 var ic_nao_repetir = 2;

 //validações do grid de escala
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

 if ($('#ic_folga_inverter').is(":checked")) {
     ic_folga_inverter = 1;
 }

 if ($('#ic_preenchimento_automatico').is(":checked")) {
     ic_preenchimento_automatico = 1;
 }
 var  ic_intrajornada = ""
 if ($('#ic_intrajornada').is(":checked")) {
     ic_intrajornada = 1;
 }

 if ($('#ic_nao_repetir').is(":checked")) {
     ic_nao_repetir = 1;
 }

 

 //pega o contratos itens do produto serviço
 var objParametros0 = {
     "contratos_pk": $("#contratos_pk_combo option:selected").val(),
     "produtos_servicos_pk": $('#produtos_servicos_pk option:selected').val()
 }
 var arrCarregar0 = carregarController("contrato_item", "listarContratosItemPK", objParametros0);
 
 var v_contratos_itens_pk = arrCarregar0.data[0]['contratos_itens_pk'];
 var v_n_qtde_dias_semana = arrCarregar0.data[0]['n_qtde_dias_semana'];
 

    if(v_n_qtde_dias_semana == '12x36' && $("#tipo_escala").val() == ""){
        $("#alert_tipo_escala").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_escala").slideUp(500);
        });
        $('#tipo_escala').focus();
        return false;
    }

 var objParametros = {
     "pk": $("#agenda_colaborador_padrao_pk").val(),
     "leads_pk": $("#leads_pk_agenda").val(),
     "contratos_pk": $("#contratos_pk_combo").val(),
     "dt_inicio_agenda": $("#dt_inicio_agenda").val(),
     "dt_fim_agenda": $("#dt_fim_agenda").val(),
     "produtos_servicos_pk": $('#produtos_servicos_pk').val(),
     "colaboradores_pk": $("#agenda_colaboradores_pk").val(),
     "processos_etapas_pk": $('#processos_etapas_pk_2').val(),
     "contratos_itens_pk": v_contratos_itens_pk,
     "turnos_pk": $('#turno_base_agenda_pk').val(),
     "hr_inicio_expediente": $('#hr_inicio_expediente').val(),
     "hr_termino_expediente": $('#hr_termino_expediente').val(),
     "hr_saida_intervalo": $('#hr_saida_intervalo').val(),
     "hr_retorno_intervalo": $('#hr_retorno_intervalo').val(),
     "ic_folga_inverter": ic_folga_inverter,
     "tipo_escala": $("#tipo_escala").val(),
     "ic_intrajornada": ic_intrajornada,
     "ic_dom": ic_dom,
     "ic_seg": ic_seg,
     "ic_ter": ic_ter,
     "ic_qua": ic_qua,
     "ic_qui": ic_qui,
     "ic_sex": ic_sex,
     "ic_sab": ic_sab,
     "ic_dom_folga": ic_dom_folga,
     "ic_seg_folga": ic_seg_folga,
     "ic_ter_folga": ic_ter_folga,
     "ic_qua_folga": ic_qua_folga,
     "ic_qui_folga": ic_qui_folga,
     "ic_sex_folga": ic_sex_folga,
     "ic_sab_folga": ic_sab_folga,
     "dom_turnos_pk": $('#dom_turnos_pk').val(),
     "seg_turnos_pk": $('#seg_turnos_pk').val(),
     "ter_turnos_pk": $('#ter_turnos_pk').val(),
     "qua_turnos_pk": $('#qua_turnos_pk').val(),
     "qui_turnos_pk": $('#qui_turnos_pk').val(),
     "sex_turnos_pk": $('#sex_turnos_pk').val(),
     "sab_turnos_pk": $('#sab_turnos_pk').val(),
     "hr_turno_dom": $("#hr_turno_dom").val(),
     "hr_turno_seg": $("#hr_turno_seg").val(),
     "hr_turno_ter": $("#hr_turno_ter").val(),
     "hr_turno_qua": $("#hr_turno_qua").val(),
     "hr_turno_qui": $("#hr_turno_qui").val(),
     "hr_turno_sex": $("#hr_turno_sex").val(),
     "hr_turno_sab": $("#hr_turno_sab").val(),
     "hr_turno_dom_saida": $("#hr_turno_dom_saida").val(),
     "hr_turno_seg_saida": $("#hr_turno_seg_saida").val(),
     "hr_turno_ter_saida": $("#hr_turno_ter_saida").val(),
     "hr_turno_qua_saida": $("#hr_turno_qua_saida").val(),
     "hr_turno_qui_saida": $("#hr_turno_qui_saida").val(),
     "hr_turno_sex_saida": $("#hr_turno_sex_saida").val(),
     "hr_turno_sab_saida": $("#hr_turno_sab_saida").val(),
     "hr_intervalo_dom": $("#hr_intervalo_dom").val(),
     "hr_intervalo_seg": $("#hr_intervalo_seg").val(),
     "hr_intervalo_ter": $("#hr_intervalo_ter").val(),
     "hr_intervalo_qua": $("#hr_intervalo_qua").val(),
     "hr_intervalo_qui": $("#hr_intervalo_qui").val(),
     "hr_intervalo_sex": $("#hr_intervalo_sex").val(),
     "hr_intervalo_sab": $("#hr_intervalo_sab").val(),
     "hr_intervalo_saida_dom": $("#hr_intervalo_saida_dom").val(),
     "hr_intervalo_saida_seg": $("#hr_intervalo_saida_seg").val(),
     "hr_intervalo_saida_ter": $("#hr_intervalo_saida_ter").val(),
     "hr_intervalo_saida_qua": $("#hr_intervalo_saida_qua").val(),
     "hr_intervalo_saida_qui": $("#hr_intervalo_saida_qui").val(),
     "hr_intervalo_saida_sex": $("#hr_intervalo_saida_sex").val(),
     "hr_intervalo_saida_sab": $("#hr_intervalo_saida_sab").val(),
     "dt_cancelamento": $("#dt_cancelamento_agenda_escala").val(),
     "ds_motivo_cancelamento": $("#ds_motivo_cancelamento").val(),
     "n_qtde_dias_semana": v_n_qtde_dias_semana,
     "ic_preenchimento_automatico": ic_preenchimento_automatico,
     "ic_nao_repetir": ic_nao_repetir,
 };
 
 var arrEnviar = carregarController("agenda_colaborador_padrao", "salvar", objParametros);
 

 if (arrEnviar.result == 'success') {

     $("#agenda_colaborador_padrao_pk").val(arrEnviar.data[0]['pk'])
     $("#n_qtde_dias_semana").val(v_n_qtde_dias_semana)
     fcCadastrarEscala();
     fcValidarFormAgendas();
     $("#janela_agendas").modal("hide");
 } else {
     alert(arrEnviar.result);
 }
    }catch(e){
alert(e)
    }
   
}

function fcCadastrarEscala() {

    //alert($("#tipo_escala").val());

    var objParametros = {
        "agenda_colaborador_padrao_pk": $("#agenda_colaborador_padrao_pk").val(),
        "leads_pk": $("#leads_pk_agenda").val(),
        "colaboradores_pk": $("#agenda_colaboradores_pk").val(),
        "dt_periodo_ini": $("#dt_inicio_agenda").val(),
        "dt_periodo_fim": $("#dt_fim_agenda").val(),
        "tipo_escala": $("#tipo_escala").val(),
        "n_qtde_dias_semana": $("#n_qtde_dias_semana").val()
    }

    var arrEnviar = carregarController("agenda_colaborador_padrao", "escala_dados_colaborador", objParametros);
    //NewWindow(v_last_url)
    if (arrEnviar.result == 'success') {
        alert(arrEnviar.message);
    } else {
        alert(arrEnviar.result);
    }
}


function fcValidarFormAgendas() {
    $("#form_agenda").validate({
        rules: {
            leads_pk_agenda: {
                required: true
            },
            contratos_pk_combo: {
                required: true
            },
            dt_inicio_agenda: {
                required: true
            },
            dt_fim_agenda: {
                required: true
            },
            produtos_servicos_pk: {
                required: true
            },
            agenda_colaboradores_pk: {
                required: true
            }
        },
        messages: {
            leads_pk_agenda: {
                required: "Por favor, selecione um posto de trabalho!"
            },
            contratos_pk_combo: {
                required: "Por favor, selecione um contrato!"
            },
            dt_inicio_agenda: {
                required: "Por favor, informe a data de início da escala!"
            },
            dt_fim_agendak: {
                required: "Por favor, informe a data de termino da escala!"
            },
            produtos_servicos_pk: {
                required: "Por favor, selecione o serviço da escala!"
            },
            agenda_colaboradores_pk: {
                required: "Por favor, selecione o colaborador da escala!"
            }

        },
        submitHandler: function (form) {
            fcSalvar();
            recarregarGridResEscala();
            return false;
        }
    });
}
//EDITAR ESCALA
function fcEditarAgenda(objRegistro) {
    $("#janela_agendas").modal();
    $("#grid_itens_contrato").html();
    fcLimparFormAgenda();
    //CONSULTA DADOS ESCALA

    var objParametros0 = {
        "pk": objRegistro['t_pk']
    };

    //CLIQUE DO PREENCHIMENTO AUTOMATICO
    $('#ic_preenchimento_automatico').click(function () {
        fcPreenchimentoAutomatico();//FUNÇÃO DE PREENCHIMENTO AUTOMATICO
    });
    //valida formulário
    fcValidarFormAgendas();

    //CARREGA COMBOS         
    var arrCarregar = carregarController("agenda_colaborador_padrao", "lisarEscalaEditar", objParametros0)

    if (arrCarregar.result == 'success') {
        $("#agenda_colaborador_padrao_pk").val(arrCarregar.data[0]['t_pk']);//PK AGENDA        
        $("#exibir_data_cancelamento").show();//PERMITE O CANCELAMENTO DA ESCALA        
        fcComboLeads(arrCarregar.data[0]['t_leads_pk']);//COMBO LEADS
        $('#dt_cancelamento_agenda_escala').datepicker({
            defaultDate: "",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            minDate: 0
        }).datepicker();
        $("#dt_cancelamento_agenda_escala").keypress(function () {
            mascara(this, mdata);
        });
        $("#dt_cancelamento_agenda_escala").val(arrCarregar.data[0]['t_dt_cancelamento']);//DT CANCELAMENTO
        $("#ds_motivo_cancelamento").val(arrCarregar.data[0]['t_ds_motivo_cancelamento']);
        if (arrCarregar.data[0]['t_dt_cancelamento'] != null) {//desabilita a o salvar se a escala estiver cancelada
            alert('A escala esta cancelada!')
            $("#dt_cancelamento_agenda_escala").prop("disabled", true);
            $("#ds_motivo_cancelamento").prop("disabled", true);
            $("#cmdEnviarAgenda").hide();
        } else {
            $("#dt_cancelamento_agenda_escala").prop("disabled", false);
            $("#ds_motivo_cancelamento").prop("disabled", false);
            $("#cmdEnviarAgenda").show();
        }

        $("#contratos_pk_combo").val(arrCarregar.data[0]['t_contratos_pk']);//CONTRATOS PK
        //$("#contratos_pk_combo").prop("disabled", true);//DESABILITA O COMBO DE CONTRATO
        fcHtmlItensContrato();//CARREGA HTML DE ITENS
        $("#dt_inicio_agenda").val(arrCarregar.data[0]['t_dt_inicio_agenda']);//DATA INICIO ESCALA
        $("#dt_fim_agenda").val(arrCarregar.data[0]['t_dt_fim_agenda']);//DATA INICIO ESCALA
        $("#dt_inicio_agenda").prop("disabled", true);
        $("#dt_fim_agenda").prop("disabled", true);
        fcProduto();//COMBO DE PRODUTOS
        $("#produtos_servicos_pk").val(arrCarregar.data[0]['t_produtos_servicos_pk']);//CONTRATOS PK  
        $("#produtos_servicos_pk").prop("disabled", true);

        //Verifica status atual do Colaborador
        fcVerificaColaborador(arrCarregar.data[0]['t_colaborador_pk'])
               

        fcColaborador();// CARREGA COMBO DE COLABORADOR
        $("#agenda_colaboradores_pk").val(arrCarregar.data[0]['t_colaborador_pk']);//CONTRATOS PK    

        $("#agenda_colaboradores_pk").prop("disabled", true);//DESABILITA COMBO 
        fcCarregarTurno();//CARREGA COMBO DE TURNOS*/
        $("#turno_base_agenda_pk").val(arrCarregar.data[0]['t_turnos_pk']);
        $("#hr_inicio_expediente").val(arrCarregar.data[0]['t_hr_inicio_expediente']);
        $("#hr_termino_expediente").val(arrCarregar.data[0]['t_hr_termino_expediente']);
        $("#hr_saida_intervalo").val(arrCarregar.data[0]['t_hr_saida_intervalo']);
        $("#hr_retorno_intervalo").val(arrCarregar.data[0]['t_hr_retorno_intervalo']);
        if (arrCarregar.data[0]['t_ic_preenchimento_automatico'] == 1) {
            $("#ic_preenchimento_automatico").prop("checked", true);
        } else {
            $("#ic_preenchimento_automatico").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_intrajornada'] == 1) {
            $("#ic_intrajornada").prop("checked", true);
            fcIntrajornada();
        } else {
            $("#ic_intrajornada").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_folga_inverter'] == 1) {
            $("#ic_folga_inverter").prop("checked", true);
        } else {
            $("#ic_folga_inverter").prop("checked", false);
        }
        $("#tipo_escala").val(arrCarregar.data[0]['t_tipo_escala']);

        if (arrCarregar.data[0]['t_ic_dom_folga'] == 1) {
            $("#ic_dom_folga").prop("checked", true);
        } else {
            $("#ic_dom_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_seg_folga'] == 1) {
            $("#ic_seg_folga").prop("checked", true);
        } else {
            $("#ic_seg_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_ter_folga'] == 1) {
            $("#ic_ter_folga").prop("checked", true);
        } else {
            $("#ic_ter_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_qua_folga'] == 1) {
            $("#ic_qua_folga").prop("checked", true);
        } else {
            $("#ic_qua_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_qui_folga'] == 1) {
            $("#ic_qui_folga").prop("checked", true);
        } else {
            $("#ic_qui_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_sex_folga'] == 1) {
            $("#ic_sex_folga").prop("checked", true);
        } else {
            $("#ic_sex_folga").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_sab_folga'] == 1) {
            $("#ic_sab_folga").prop("checked", true);
        } else {
            $("#ic_sab_folga").prop("checked", false);
        }

        if (arrCarregar.data[0]['t_ic_dom'] == 1) {
            $("#ic_dom").prop("checked", true);
        } else {
            $("#ic_dom").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_seg'] == 1) {
            $("#ic_seg").prop("checked", true);
        } else {
            $("#ic_seg").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_ter'] == 1) {
            $("#ic_ter").prop("checked", true);
        } else {
            $("#ic_ter").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_qua'] == 1) {
            $("#ic_qua").prop("checked", true);
        } else {
            $("#ic_qua").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_qui'] == 1) {
            $("#ic_qui").prop("checked", true);
        } else {
            $("#ic_qui").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_sex'] == 1) {
            $("#ic_sex").prop("checked", true);
        } else {
            $("#ic_sex").prop("checked", false);
        }
        if (arrCarregar.data[0]['t_ic_sab'] == 1) {
            $("#ic_sab").prop("checked", true);
        } else {
            $("#ic_sab").prop("checked", false);
        }

        $("#dom_turnos_pk").val(arrCarregar.data[0]['t_dom_turnos_pk']);
        $("#seg_turnos_pk").val(arrCarregar.data[0]['t_seg_turnos_pk']);
        $("#ter_turnos_pk").val(arrCarregar.data[0]['t_ter_turnos_pk']);
        $("#qua_turnos_pk").val(arrCarregar.data[0]['t_qua_turnos_pk']);
        $("#qui_turnos_pk").val(arrCarregar.data[0]['t_qui_turnos_pk']);
        $("#sex_turnos_pk").val(arrCarregar.data[0]['t_sex_turnos_pk']);
        $("#sab_turnos_pk").val(arrCarregar.data[0]['t_sab_turnos_pk']);
        $("#hr_turno_dom").val(arrCarregar.data[0]['t_hr_turno_dom']);
        $("#hr_turno_seg").val(arrCarregar.data[0]['t_hr_turno_seg']);
        $("#hr_turno_ter").val(arrCarregar.data[0]['t_hr_turno_ter']);
        $("#hr_turno_qua").val(arrCarregar.data[0]['t_hr_turno_qua']);
        $("#hr_turno_qui").val(arrCarregar.data[0]['t_hr_turno_qui']);
        $("#hr_turno_sex").val(arrCarregar.data[0]['t_hr_turno_sex']);
        $("#hr_turno_sab").val(arrCarregar.data[0]['t_hr_turno_sab']);

        $("#hr_intervalo_dom").val(arrCarregar.data[0]['t_hr_intervalo_dom']);
        $("#hr_intervalo_seg").val(arrCarregar.data[0]['t_hr_intervalo_seg']);
        $("#hr_intervalo_ter").val(arrCarregar.data[0]['t_hr_intervalo_ter']);
        $("#hr_intervalo_qua").val(arrCarregar.data[0]['t_hr_intervalo_qua']);
        $("#hr_intervalo_qui").val(arrCarregar.data[0]['t_hr_intervalo_qui']);
        $("#hr_intervalo_sex").val(arrCarregar.data[0]['t_hr_intervalo_sex']);
        $("#hr_intervalo_sab").val(arrCarregar.data[0]['t_hr_intervalo_sab']);

        $("#hr_intervalo_saida_dom").val(arrCarregar.data[0]['t_hr_intervalo_saida_dom']);
        $("#hr_intervalo_saida_seg").val(arrCarregar.data[0]['t_hr_intervalo_saida_seg']);
        $("#hr_intervalo_saida_ter").val(arrCarregar.data[0]['t_hr_intervalo_saida_ter']);
        $("#hr_intervalo_saida_qua").val(arrCarregar.data[0]['t_hr_intervalo_saida_qua']);
        $("#hr_intervalo_saida_qui").val(arrCarregar.data[0]['t_hr_intervalo_saida_qui']);
        $("#hr_intervalo_saida_sex").val(arrCarregar.data[0]['t_hr_intervalo_saida_sex']);
        $("#hr_intervalo_saida_sab").val(arrCarregar.data[0]['t_hr_intervalo_saida_sab']);
        $("#hr_turno_dom_saida").val(arrCarregar.data[0]['t_hr_turno_dom_saida']);
        $("#hr_turno_seg_saida").val(arrCarregar.data[0]['t_hr_turno_seg_saida']);
        $("#hr_turno_ter_saida").val(arrCarregar.data[0]['t_hr_turno_ter_saida']);
        $("#hr_turno_qua_saida").val(arrCarregar.data[0]['t_hr_turno_qua_saida']);
        $("#hr_turno_qui_saida").val(arrCarregar.data[0]['t_hr_turno_qui_saida']);
        $("#hr_turno_sex_saida").val(arrCarregar.data[0]['t_hr_turno_sex_saida']);
        $("#hr_turno_sab_saida").val(arrCarregar.data[0]['t_hr_turno_sab_saida']);
    }
}
//NOVO CADASTRO
function fcAbrirFormNovaEscala() {
    $("#janela_agendas").modal();
    $("#grid_itens_contrato").html();
    $("#exibir_data_cancelamento").hide();    

    //LIMPA FORM
    fcLimparFormAgenda();

    $("#contratos_pk_combo").prop("disabled", false);
    $("#dt_inicio_agenda").prop("disabled", false);
    $("#dt_fim_agenda").prop("disabled", false);
    $("#produtos_servicos_pk").prop("disabled", false);
    $("#agenda_colaboradores_pk").prop("disabled", false);
    //COMBOS  
    fcComboLeads(leads_pk);//LEADS

    //CARREGAR HTML ITENS CONTRATO    
    $("#contratos_pk_combo").change(function () {
    
        //VERIFICA SE PRODUTO SELECIONADO NÃO ESTA VAZIO
        if ($("#contratos_pk_combo").val() != "") {
            fcHtmlItensContrato();//CARREGA HTML ITENS CONTRATO
            fcContratoDatas();// CARREGA DATAS CONTRATO
            fcProduto() // CAREEGA COMBO PRODUTOS
            $("#print_escala_colaborador").html('');
        } else {
            $("#grid_itens_contrato").empty();
            $("#grid_itens_contrato").html('');
            $("#dt_inicio_agenda").val('');
            $("#dt_fim_agenda").val('');
            $("#produtos_servicos_pk").html('');
            $("#agenda_colaboradores_pk").html('');
            $("#print_escala_colaborador").html('');
        }
    });
    //CARREGA COMBO SERVIÇOS AO CLICAR EM CONTRATOS
    $("#produtos_servicos_pk").change(function () {
        //VERIFICA SE PRODUTO SELECIONADO NÃO ESTA VAZIO
        if ($("#produtos_servicos_pk").val() != "") {
            fcVerificaServidoQtdeEscala()//Verifica se o serviço selecionado a quantidade do contrato ja tem escalas definidas 
            $("#print_escala_colaborador").html('');
        } else {
            $("#escala_colaborador").val('');
            $("#print_escala_colaborador").html('');
            $("#agenda_colaboradores_pk").html('');
        }
    });
    //VERIFICA SE O COLABORADOR JA ESTA REGISTRADO EM OUTRA ESCALA
    $("#agenda_colaboradores_pk").change(function () {
        //VERIFICA SE PRODUTO SELECIONADO NÃO ESTA VAZIO
        if ($("#agenda_colaboradores_pk").val() != "") {
            fcVerificaOutraEscalaColaborador()//Verifica se o colaborador ja esta em outra escala                   
        }
    });

    fcCarregarTurno()//CARREGA TURNO    

    //CLIQUE DO PREENCHIMENTO AUTOMATICO
    $('#ic_preenchimento_automatico').click(function () {
        fcPreenchimentoAutomatico();//FUNÇÃO DE PREENCHIMENTO AUTOMATICO
    });
    //valida formulário
    fcValidarFormAgendas();
}
//INICIA COMBOS
function fcComboLeads(leads_pk) {
    var v_leads_pk = "";

    if (leads_pk != '' && typeof leads_pk != 'undefined') {
        v_leads_pk = leads_pk;
    }

    var objParametros = {
        "leads_pk": v_leads_pk
    };
    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros)
    if (v_leads_pk == "") {
        carregarComboAjax($("#leads_pk_agenda"), arrCarregar, " ", "leads_pk", "ds_lead");
        //COMBO DE CONTRATOS  
        $("#leads_pk_agenda").change(function () {
            $("#contratos_pk_combo").html('');
            $("#grid_itens_contrato").empty();
            $("#grid_itens_contrato").html('');
            $("#dt_inicio_agenda").val('');
            $("#dt_fim_agenda").val('');
            $("#produtos_servicos_pk").html('');
            $("#agenda_colaboradores_pk").html('');
            $("#dias_escala_servico").html('');
            $("#print_escala_colaborador").html('');
            fcComboContratos($("#leads_pk_agenda").val());// COMBO CONTRATOS 

        });
        $("#leads_pk_agenda").prop("disabled", false);
    } else {
        // Chamada da pagina de processos
        carregarComboAjax($("#leads_pk_agenda"), arrCarregar, "", "leads_pk", "ds_lead");
        fcComboContratos($("#leads_pk_agenda").val());//COMBO DE CONTRATOS  
        $("#leads_pk_agenda").prop("disabled", true);
    }
}

function  fcVerificaColaborador(colaborador_pk){
    var objParametros = {
        "pk": colaborador_pk 
    };

    var arrCarregar = carregarController("colaborador", "listarPk", objParametros);
    if (arrCarregar.result == 'success'){
        
       if(arrCarregar.data[0]['ic_status']!=1){
         alert('Colaborador não está com status de ativo em sua ficha, verifique!');
         $('#janela_agendas').modal('hide');
         return false;
       }
    }    
    
}

function fcComboContratos(leads_pk, processos_pk, colaborador_pk) {

    var v_leads_pk = "";
    var v_processos_pk = "";
    var v_colaborador_pk = "";

    if (leads_pk != '' && typeof leads_pk != 'undefined') {
        v_leads_pk = leads_pk;
    }

    if (processos_pk != '' && typeof processos_pk != 'undefined') {
        v_processos_pk = processos_pk;
    }

    if (colaborador_pk != '' && typeof colaborador_pk != 'undefined') {
        v_colaborador_pk = colaborador_pk;
    }

    var objParametros = {
        "leads_pk": v_leads_pk,
        "processos_pk": v_processos_pk,
        "colaborador_pk": v_colaborador_pk
    };

    var arrCarregar = carregarController("contrato", "listarLeadsPk", objParametros);
    
    carregarComboAjax($("#contratos_pk_combo"), arrCarregar, " ", "pk", "ds_combo_contrato");
}

function fcProduto() {

    var objParametros = {
        "contratos_pk": $("#contratos_pk_combo").val()
    };

    var arrCarregar = carregarController("produto_servico", "listarProdutosContrato", objParametros);

    carregarComboAjax($("#produtos_servicos_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}

function fcColaborador() {

    var objParametros = {
        "contratos_pk": $("#contratos_pk_combo").val(),
        "produtos_servicos_pk": $("#produtos_servicos_pk").val(),
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradoresQualidicacaoContrato", objParametros);

    carregarComboAjax($("#agenda_colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");
}

function fcCarregarTurno() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("turno", "listarTodos", objParametros);
    carregarComboAjax($("#turno_base_agenda_pk"), arrCarregar, " ", "pk", "ds_turno");

}
//CONSULTAS
function fcContratoDatas() {
    var objParametros = {
        "leads_pk": $("#leads_pk_agenda").val(),
        "pk": $("#contratos_pk_combo").val()
    };

    var arrCarregar = carregarController("contrato", "listarPk", objParametros);

    if (arrCarregar.result == 'success') {
        //$("#dt_inicio_agenda").val(arrCarregar.data[0]['dt_inicio_contrato']); 

        var str = arrCarregar.data[0]['dt_fim_contrato'];
        //carraga processo etapa do contrato selecionado        
        $("#processos_etapas_pk_2").val(arrCarregar.data[0]['processos_etapas_pk'])

        var date = new Date(str.split('/').reverse().join('/'));
        var novaData = new Date();

        if (date < novaData) {
            alert("Período do contrato seleciona esta vencido! Selecione ou Cadastre um contrato!");
            $("#contratos_pk_combo").val(0);
        } else {
            $("#dt_fim_agenda").val(arrCarregar.data[0]['dt_fim_contrato']);
        }
    }
}

function fcVerificaServidoQtdeEscala() {
    var objParametros = {
        "produtos_servicos_pk": $("#produtos_servicos_pk").val(),
        "contratos_pk": $("#contratos_pk_combo option:selected").val()
    };
    var arrCarregar = carregarController("contrato_item", "verificaServidoQtdeEscala", objParametros);
    if (arrCarregar.result == 'success') {
        var v_qtde_escalas = (arrCarregar.data[0]['qtde_servico_escala']);
        if (v_qtde_escalas > arrCarregar.data[0]['qtde_servico_item_contrato']) {
            $("#dias_escala_servico").val() // zera a quantidade de dias da escala
            $("#print_dias_por_servico").html('') //zera html dos dias de escala 
            $("#agenda_colaboradores_pk").html('') //zera o combo de colaboradores            
            var resultado = confirm("O Serviço selecionado já tem a quantidade de Escalas do contrato cadastradas! Verifique o contrato ou selecione outro serviço !");
        } else {
            $("#print_dias_por_servico").html("Escala do serviço selecionado: " + arrCarregar.data[0]['dias_escala'])//PRINTA A ESCALA DO SERVIÇO SELECIONADO
            $("#dias_escala_servico").val(arrCarregar.data[0]['dias_escala']);//ADICIONA O VALOR DA ESCALA PARA UTILIZAR NO PREENCHIMENTO AUTOMATICO

            fcColaborador();//CARREGA HColaborador     
        }
    }
}
//verifica se o colaborador tem uma ou mais escalas ativas
function fcVerificaOutraEscalaColaborador() {
    var vhtml = "";
    var objParametros = {
        "colaboradores_pk": $("#agenda_colaboradores_pk").val()
    };

    var arrCarregar = carregarController("agenda_colaborador_padrao", "verificaOutraEscalaColaborador", objParametros);
    //alert(v_last_url)
    if (arrCarregar.result == 'success') {

        if (arrCarregar.data[0]['pk'] != 0) {

            $("#cmdEnviarAgenda").hide();

            vhtml += "<div class='row'>";
            vhtml += "     <div class='col-md-12'>";
            vhtml += "         <h5>Escala(s) registradas para o Colaborador</h5>";
            vhtml += "     </div>";
            vhtml += " </div>";

            for (i = 0; i < arrCarregar.data.length; i++) {
                vstatus = "Escala Ativa";
                vhtml += "<div class='row'>";
                vhtml += "     <div class='col-md-12'>";
                vhtml += "        <table class='table' style='width:100%' >";
                vhtml += "            <tr align='left' style='font-size: 14px'>";
                vhtml += "                <td whidt='30%'>";
                vhtml += "                    Posto de Trabalho: ";
                vhtml += "                </td>";
                vhtml += "                <td>";
                vhtml += arrCarregar.data[i]['ds_lead'];
                vhtml += "                </td>";
                vhtml += "            </tr>";
                vhtml += "            <tr align='left' style='font-size: 14px'>";
                vhtml += "                <td whidt='30%' >";
                vhtml += "                    DT escala: ";
                vhtml += "                </td>";
                vhtml += "                <td >";
                vhtml += arrCarregar.data[i]['dt_inicio_agenda'] + " Até " + arrCarregar.data[i]['dt_fim_agenda'];
                vhtml += "                </td>";
                vhtml += "            </tr>";
                vhtml += "            <tr align='left' style='font-size: 14px'>";
                vhtml += "                <td whidt='30%' >";
                vhtml += "                    Status: ";
                vhtml += "                </td>";
                vhtml += "                <td style='color:red' >";
                vhtml += "Escala Ativa";
                vhtml += "                </td>";
                vhtml += "            </tr>";
                vhtml += "        </table>";
                vhtml += "      </div>";
                vhtml += "</div>";
            }
            vhtml += "<div class='row'>";
            vhtml += "     <div class='col-md-12'>";
            vhtml += "         <button type='button' id='btn_continuar_registro' class='btn btn-primary' onclick='liberaRegistroEscala()'  >Continuar o Registro</button>";
            vhtml += "     </div>";
            vhtml += " </div>";
            $("#print_escala_colaborador").html(vhtml)
        } else {
            $("#cmdEnviarAgenda").show();
            $("#print_escala_colaborador").html('')
        }
    }
}

//AÇÔES
function liberaRegistroEscala() {
    var resultado = confirm("O Colaborador " + $("#agenda_colaboradores_pk option:selected").text() + " possui estala(s) ativas! Deseja continuar com o cadastro de uma nova escla para este colaboradro?");
    if (resultado == true) {
        $("#cmdEnviarAgenda").show();
        $("#print_escala_colaborador").html('')
    } else {
        $("#print_escala_colaborador").html('')
        $("#agenda_colaboradores_pk option:selected").text('');
    }
}
function fcPreenchimentoAutomatico() {
    //VERIFICA SE O CHECKBOS ESTA MARCADO
    if ($("#ic_preenchimento_automatico").is(":checked") == true) {

        if ($("#produtos_servicos_pk option:selected").val() == "") {
            alert("Por favor, selecione o serviço para o preenchimento da escala!");
            $("#ic_preenchimento_automatico").prop("checked", false);
            return false;
        }

        //VERIFICA SE AS INFORMAÇÕES NECESSÁRIAS ESTÃO MARCADAS
        if ($("#turno_base_agenda_pk").val() == "") {
            alert("Por favor, selecione o turno para o preenchimento automático!");
            $("#ic_preenchimento_automatico").prop("checked", false);
            $("#turno_base_agenda_pk").focus();
            return false;
        }
        if ($("#hr_inicio_expediente").val() == "") {
            alert("Por favor, informe horário de início do expediente!");
            $("#ic_preenchimento_automatico").prop("checked", false);
            $("#hr_inicio_expediente").focus();
            return false;
        }
        if ($("#hr_termino_expediente").val() == "") {
            alert("Por favor, informe horário de termino do expediente!");
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
        $("#dom_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#seg_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#ter_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#qua_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#qui_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#sex_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        $("#sab_turnos_pk").val($("#turno_base_agenda_pk option:selected").val());
        //HORARIO ENTRATDA EXPEDIENTE             
        $("#hr_turno_dom").val($("#hr_inicio_expediente").val());
        $("#hr_turno_seg").val($("#hr_inicio_expediente").val());
        $("#hr_turno_ter").val($("#hr_inicio_expediente").val());
        $("#hr_turno_qua").val($("#hr_inicio_expediente").val());
        $("#hr_turno_qui").val($("#hr_inicio_expediente").val());
        $("#hr_turno_sex").val($("#hr_inicio_expediente").val());
        $("#hr_turno_sab").val($("#hr_inicio_expediente").val());
        //HORARIO SAIDA INTERVALO 
        $("#hr_intervalo_dom").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_seg").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_ter").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_qua").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_qui").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_sex").val($("#hr_saida_intervalo").val());
        $("#hr_intervalo_sab").val($("#hr_saida_intervalo").val());
        //HORARIO RETORNO INTERVALO
        $("#hr_intervalo_saida_dom").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_seg").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_ter").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_qua").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_qui").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_sex").val($("#hr_retorno_intervalo").val());
        $("#hr_intervalo_saida_sab").val($("#hr_retorno_intervalo").val());
        //HORARIO SAIDA EXPEDIENTE
        $("#hr_turno_dom_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_seg_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_ter_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_qua_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_qui_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_sex_saida").val($("#hr_termino_expediente").val());
        $("#hr_turno_sab_saida").val($("#hr_termino_expediente").val());
    } 

    if ($('#ic_intrajornada').is(":checked")) {
        $('#hr_saida_intervalo').val(" ")
        $('#hr_retorno_intervalo').val(" ")
        $("#hr_retorno_intervalo").attr('disabled','disabled');
        $("#hr_saida_intervalo").attr('disabled','disabled');

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
    }
}

//HTML
function fcHtmlItensContrato() {
    $("#grid_itens_contrato").empty();
    $("#grid_itens_contrato").html();
    var strRetorno = "";
    var strNenhumRegisto = "";
    var qtde_dias_semana = "";
    var ds_produto_servico = "";
    var ds_itens_contratador = "";
    var ds_profissionais_contratados = "";
    var ds_diferenca = "";
    var objParametros1 = {
        "leads_pk": $("#leads_pk_agenda").val(),
        "contratos_pk": $("#contratos_pk_combo").val()
    };
    var arrCarregar1 = carregarController("contrato_item", "listarItensEscala", objParametros1);
   
    $("#agenda_contratos_itens_pk").val(arrCarregar1.data[0]['t_pk'])
    if (arrCarregar1.result == 'success') {
        strRetorno += "<div class='row'>";
        strRetorno += "<div class='col-md-12'>";
        strRetorno += "<table class='table' style='width:100%' >";
        strRetorno += "<tbody>";

        strRetorno += "<thead>";
        strRetorno += "<tr align='center'>";
        strRetorno += "<th >Serviços Contratados</th><th >Qtde de<br>Colaborador</th><th >Escala</th>";
        strRetorno += "</tr>";
        strRetorno += "</thead>";
        for (i = 0; i < arrCarregar1.data.length; i++) {
            ds_produto_servico = arrCarregar1.data[i]['t_ds_produto_servico'];
            ds_itens_contratador = arrCarregar1.data[i]['t_n_qtde'];
            qtde_dias_semana = arrCarregar1.data[i]['t_n_qtde_dias_semana'];
            strRetorno += "<tbody>";
            strRetorno += "<tr align='center'>";
            strRetorno += "<td width='20%'>" + ds_produto_servico + "</td>";
            strRetorno += "<td width='20%'>" + ds_itens_contratador + "</td>";
            strRetorno += "<td width='20%'>" + qtde_dias_semana + "</td>";
            strRetorno += "</tr>";
            strRetorno += "</tbody>";
        }
        strRetorno += "</table>";
        strRetorno += "</div>";
        strRetorno += "</div>";
        $("#grid_itens_contrato").html(strRetorno);
    }
}
//LIMPEZA
function fcLimparFormAgenda() {
    $("#grid_itens_contrato").html("");
    $("#dias_por_servico").html("");
    $("#agenda_colaborador_padrao_pk").val("");
    $("#grid").empty();
    $("#agenda_produtos_servicos_pk").val("");
    $("#agenda_contratos_itens_pk").val("");
    $("#dt_inicio_agenda").val("");
    $("#dt_fim_agenda").val("");
    $("#agenda_colaboradores_pk").val("");
    $("#contratos_pk_combo").val("");
    $("#dt_cancelamento_agenda_escala").val("");
    $("#ds_motivo_cancelamento").val("");
    $("#tipo_escala").val("");
    $("#agenda_colaboradores_pk").html('');
    $("#ic_dom").prop("checked", false);
    $("#ic_seg").prop("checked", false);
    $("#ic_ter").prop("checked", false);
    $("#ic_qua").prop("checked", false);
    $("#ic_qui").prop("checked", false);
    $("#ic_sex").prop("checked", false);
    $("#ic_sab").prop("checked", false);
    $("#ic_dom_folga").prop("checked", false);
    $("#ic_seg_folga").prop("checked", false);
    $("#ic_ter_folga").prop("checked", false);
    $("#ic_qua_folga").prop("checked", false);
    $("#ic_qui_folga").prop("checked", false);
    $("#ic_sex_folga").prop("checked", false);
    $("#ic_sab_folga").prop("checked", false);
    $("#ic_folga_inverter").prop("checked", false);
    $("#ic_dom").prop("disabled", false);
    $("#ic_seg").prop("disabled", false);
    $("#ic_ter").prop("disabled", false);
    $("#ic_qua").prop("disabled", false);
    $("#ic_qui").prop("disabled", false);
    $("#ic_sex").prop("disabled", false);
    $("#ic_sab").prop("disabled", false);
    $("#ic_dom_folga").prop("disabled", false);
    $("#ic_seg_folga").prop("disabled", false);
    $("#ic_ter_folga").prop("disabled", false);
    $("#ic_qua_folga").prop("disabled", false);
    $("#ic_qui_folga").prop("disabled", false);
    $("#ic_sex_folga").prop("disabled", false);
    $("#ic_sab_folga").prop("disabled", false);
    $("#ic_folga_inverter").prop("disabled", false);
    $("#dom_turnos_pk").val("");
    $("#seg_turnos_pk").val("");
    $("#ter_turnos_pk").val("");
    $("#qua_turnos_pk").val("");
    $("#qui_turnos_pk").val("");
    $("#sex_turnos_pk").val("");
    $("#sab_turnos_pk").val("");
    $("#hr_turno_dom").val("");
    $("#hr_turno_seg").val("");
    $("#hr_turno_ter").val("");
    $("#hr_turno_qua").val("");
    $("#hr_turno_qui").val("");
    $("#hr_turno_sex").val("");
    $("#hr_turno_sab").val("");
    $("#hr_turno_dom_saida").val("");
    $("#hr_turno_seg_saida").val("");
    $("#hr_turno_ter_saida").val("");
    $("#hr_turno_qua_saida").val("");
    $("#hr_turno_qui_saida").val("");
    $("#hr_turno_sex_saida").val("");
    $("#hr_turno_sab_saida").val("");
    $("#hr_intervalo_dom").val("");
    $("#hr_intervalo_seg").val("");
    $("#hr_intervalo_ter").val("");
    $("#hr_intervalo_qua").val("");
    $("#hr_intervalo_qui").val("");
    $("#hr_intervalo_sex").val("");
    $("#hr_intervalo_sab").val("");
    $("#hr_intervalo_saida_dom").val("");
    $("#hr_intervalo_saida_seg").val("");
    $("#hr_intervalo_saida_ter").val("");
    $("#hr_intervalo_saida_qua").val("");
    $("#hr_intervalo_saida_qui").val("");
    $("#hr_intervalo_saida_sex").val("");
    $("#hr_intervalo_saida_sab").val("");
    $("#leads_pk_agenda").val("");
    $("#turno_base_agenda_pk").val("");
    $("#hr_inicio_expediente").val("");
    $("#hr_termino_expediente").val("");
    $("#hr_saida_intervalo").val("");
    $("#hr_retorno_intervalo").val("");
    $("#ic_preenchimento_automatico").prop("checked", false);
}

function recarregarGridResEscala(){
    setTimeout(function(){
        tblAgenda.ajax.reload(); 
    }, 100);  
}

function fcIntrajornada(){
    if ($('#ic_intrajornada').is(":checked")) {
        $('#hr_saida_intervalo').val(" ")
        $('#hr_retorno_intervalo').val(" ")
        $("#hr_retorno_intervalo").attr('disabled','disabled');
        $("#hr_saida_intervalo").attr('disabled','disabled');

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
        $("#hr_retorno_intervalo").removeAttr('disabled');
        $("#hr_saida_intervalo").removeAttr('disabled');

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

$(document).ready(function () {
    //CHAMADA MODAL 
    $(document).on('click', '#btn_modal_agenda', fcAbrirFormNovaEscala);
    $(document).on('click', '#ic_intrajornada', fcIntrajornada);

    $('#dt_inicio_agenda').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date());
    $("#dt_inicio_agenda").keypress(function () {
        mascara(this, mdata);
    });
    $('#dt_fim_agenda').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date());

    $("#dt_fim_agenda").keypress(function () {
        mascara(this, mdata);
    });

    $("#hr_inicio_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_termino_expediente").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_saida_intervalo").keypress(function () {
        mascara(this, horamask);
    });
    $("#hr_retorno_intervalo").keypress(function () {
        mascara(this, horamask);
    });
});
