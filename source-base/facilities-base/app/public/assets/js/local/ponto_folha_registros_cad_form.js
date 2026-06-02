function textoSituacaoApontamentoFolha(tipo) {
    var mapa = {
        "1": "Dia Trabalhado",
        "2": "Falta",
        "3": "Folga",
        "5": "Afastamento",
        "6": "Férias",
        "8": "Disciplina",
        "11": "Abonada",
        "16": "Atestado",
        "17": "Advertencia",
        "18": "Declaração da defesa civil",
        "19": "Demissão",
        "20": "Folga compensatória",
        "21": "Folga de feriado",
        "22": "Justa causa",
        "23": "Recisão indireta",
        "24": "Suspensão",
        "25": "Troca Folga",
        "26": "Folga trabalhada",
        "27": "Escala Errada",
        "28": "Apoio Operacional",
        "29": "Atestado por acompanhar filho ate 5 anos",
        "30": "Atestado por serviço Justiça Eleitoral",
        "31": "Doação de sangue",
        "32": "Atraso",
        "33": "Declaração de horas abonar",
        "34": "Sem Justificativa",
        "35": "Reciclagem",
        "36": "Audiência",
        "37": "Atestado de horas"
    };

    return mapa[String(tipo)] || "";
}

function tipoRegistroFolhaPorSituacao(situacao, tipoApontamento) {
    if (tipoApontamento !== "") {
        return tipoApontamento;
    }

    var mapaLegado = {
        "Folga": 5,
        "Falta": 10,
        "Abonada": 11,
        "Dia Trabalhado": 1,
        "Expediente": 1,
        "Ponto/Expediente": 1,
        "Férias": 12,
        "Afastamento": 15,
        "Atestado": 16,
        "Advertencia": 17,
        "Declaração da defesa civil": 18,
        "Demissão": 19,
        "Folga compensatória": 20,
        "Folga de feriado": 21,
        "Justa causa": 22,
        "Recisão indireta": 23,
        "Suspensão": 24,
        "Troca Folga": 25,
        "Atestado de horas": 37,
        "Declaração de horas abonar": 33,
        "Audiência": 36
    };

    return mapaLegado[situacao] || "";
}

function montarOptionsApontamentoFolha(tipoSelecionado) {
    var grupos = [
        {label: "PONTO", options: [{value: "1", text: "Ponto/Expediente"}]},
        {label: "FALTA", options: [
            {value: "2", text: "Falta"},
            {value: "11", text: "Abonada"},
            {value: "16", text: "Atestado"},
            {value: "18", text: "Declaração da defesa civil"},
            {value: "28", text: "Apoio Operacional"},
            {value: "29", text: "Atestado por acompanhar filho ate 5 anos"},
            {value: "30", text: "Atestado por serviço Justiça Eleitoral"},
            {value: "37", text: "Atestado de horas"},
            {value: "31", text: "Doação de sangue"},
            {value: "32", text: "Atraso"},
            {value: "33", text: "Declaração de horas abonar"},
            {value: "34", text: "Sem Justificativa"},
            {value: "35", text: "Reciclagem"},
            {value: "36", text: "Audiência"}
        ]},
        {label: "Folga", options: [
            {value: "3", text: "Folga"},
            {value: "20", text: "Folga compensatória"},
            {value: "21", text: "Folga de feriado"},
            {value: "25", text: "Troca Folga"},
            {value: "26", text: "Folga trabalhada"},
            {value: "27", text: "Escala Errada"}
        ]},
        {label: "Afastamento", options: [{value: "5", text: "Afastamento"}]},
        {label: "Férias", options: [{value: "6", text: "Férias"}]},
        {label: "Disciplina", options: [
            {value: "8", text: "Disciplina"},
            {value: "17", text: "Advertencia"},
            {value: "19", text: "Demissão"},
            {value: "22", text: "Justa causa"},
            {value: "23", text: "Recisão indireta"},
            {value: "24", text: "Suspensão"}
        ]}
    ];

    var html = "<option value=''></option>";
    for (var i = 0; i < grupos.length; i++) {
        html += "<optgroup label='" + grupos[i].label + "'>";
        for (var j = 0; j < grupos[i].options.length; j++) {
            var option = grupos[i].options[j];
            html += "<option " + (String(tipoSelecionado) == option.value ? " selected" : "") + " value='" + option.value + "'>" + option.text + "</option>";
        }
        html += "</optgroup>";
    }

    return html;
}

function marcarApontamentoAlterado(row) {
    if ($("#ic_acao" + row).val() !== "") {
        $("#apontamento_alterado" + row).val("1");
    }
}

function estiloSituacaoFolha(situacao) {
    var estilo = " text-align: center";
    if ($.trim(situacao) === "Falta") {
        estilo += ";background-color:#f8c8dc";
    }
    return estilo;
}

function aplicarBloqueioCamposApontamentoFolha(row, limpar) {
    var tipo = $("#ic_acao" + row).val();
    var validado = $("#ic_status" + row).is(":checked");
    var tiposPermitemPonto = ["1", "33", "36", "37"];
    var permitePreencherPonto = tiposPermitemPonto.indexOf(String(tipo)) !== -1;
    var bloqueado = validado || !permitePreencherPonto;
    var campos = "#hr_ini_expediente" + row + ",#hr_ini_intervalo" + row + ",#hr_fim_intervalo" + row + ",#hr_fim_expediente" + row + ",#hr_trabalhadas" + row + ",#hr_excedentes" + row + ",#hr_faltantes" + row + ",#hr_extra50" + row + ",#hr_extra100" + row + ",#hr_adicional_noturno" + row;

    $(campos).prop("disabled", bloqueado);
    $("#ic_acao" + row).prop("disabled", validado);

    if (limpar === true && tipo !== "" && !permitePreencherPonto) {
        $("#hr_ini_expediente" + row).val("");
        $("#hr_ini_intervalo" + row).val("");
        $("#hr_fim_intervalo" + row).val("");
        $("#hr_fim_expediente" + row).val("");
        $("#hr_trabalhadas" + row).val("");
        $("#hr_excedentes" + row).val("");
        $("#hr_faltantes" + row).val("");
        $("#hr_extra50" + row).val("");
        $("#hr_extra100" + row).val("");
        $("#hr_adicional_noturno" + row).val("");
    }
}

function configurarAcoesFolhaFinalizada(finalizada) {
    var elementosFinalizacao = $("#cmdImprimirModal, #ic_folha_finalizada, label[for='ic_folha_finalizada']");
    if (finalizada) {
        elementosFinalizacao.hide();
    } else {
        elementosFinalizacao.show();
    }
}

function fcEnviar(){
    var formdata = new FormData();
    var v_li = $("#totalLinhas").val()
    var arrEnviar = []; 

    for (i = 0; i < v_li; i++) {
        var v_ponto_folha_pk = $("#pk").val();
        var v_dt_hora_ponto = $("#dt_hora_ponto" + i).val();
        var v_colaborador_pk = $("#colaborador_pk").val();
        var v_leads_pk = $("#leads_pk").val();
        var v_ponto_folha_registros_pk = $("#ponto_folha_registros_pk" + i).val();
        var v_hr_ini_expediente = ($("#hr_ini_expediente" + i).val() != "") ? $("#hr_ini_expediente" + i).val() : null;
        var v_hr_ini_intervalo = ($("#hr_ini_intervalo" + i).val() != "") ? $("#hr_ini_intervalo" + i).val() : null;
        var v_hr_fim_intervalo = ($("#hr_fim_intervalo" + i).val() != "") ? $("#hr_fim_intervalo" + i).val() : null;
        var v_hr_fim_expediente = ($("#hr_fim_expediente" + i).val() != "") ? $("#hr_fim_expediente" + i).val() : null;
        var v_hr_trabalhadas = ($("#hr_trabalhadas" + i).val() != "") ? $("#hr_trabalhadas" + i).val() : null;
        var v_hr_excedentes = ($("#hr_excedentes" + i).val() != "") ? $("#hr_excedentes" + i).val() : null;
        var v_hr_faltantes = ($("#hr_faltantes" + i).val() != "") ? $("#hr_faltantes" + i).val() : null;
        var v_hr_extra50 = ($("#hr_extra50" + i).val() != "") ? $("#hr_extra50" + i).val() : null;
        var v_hr_extra100 = ($("#hr_extra100" + i).val() != "") ? $("#hr_extra100" + i).val() : null;
        var v_hr_adicional_noturno = ($("#hr_adicional_noturno" + i).val() != "") ? $("#hr_adicional_noturno" + i).val() : null;
        var v_obs = ($("#obs" + i).val() != "") ? $("#obs" + i).val() : null;
        var v_ic_status = ($("#ic_status" + i).is(':checked')) ? $("#ic_status" + i).val() : 0;
        var v_apontamento_alterado = ($("#apontamento_alterado" + i).val() == "1") ? 1 : 0;
        var v_tipo_apontamento_pk = ($("#ic_acao" + i).val() != "") ? $("#ic_acao" + i).val() : "";
        var v_tipo_ponto_pk = $("#tipo_ponto_pk_original" + i).val();
        if (v_apontamento_alterado == 1 || v_tipo_ponto_pk == "") {
            v_tipo_ponto_pk = tipoRegistroFolhaPorSituacao($("#ds_situacao" + i).html(), v_tipo_apontamento_pk);
        }
        var ic_folha_finalizada = "";
        if ($("#ic_folha_finalizada").is(':checked') == true) {
            ic_folha_finalizada = 1;            
        }
        
        var objParamentros = {
            "pk": v_ponto_folha_registros_pk,
            "colaborador_pk": v_colaborador_pk,
            "leads_pk": v_leads_pk,
            "dt_hora_ponto": v_dt_hora_ponto,
            "ponto_folha_pk": v_ponto_folha_pk,
            "hr_ini_expediente": v_hr_ini_expediente,
            "hr_ini_intervalo": v_hr_ini_intervalo,
            "hr_fim_intervalo": v_hr_fim_intervalo,
            "hr_fim_expediente": v_hr_fim_expediente,
            "hr_trabalhadas": v_hr_trabalhadas,
            "hr_excedentes": v_hr_excedentes,
            "hr_faltantes": v_hr_faltantes,
            "tipo_ponto_pk": v_tipo_ponto_pk,
            "tipo_apontamento_pk_novo": v_tipo_apontamento_pk,
            "apontamento_alterado": v_apontamento_alterado,
            "agenda_colaborador_pk": $("#agenda_colaborador_pk").val(),
            "ic_status": v_ic_status,
            "hr_extra50": v_hr_extra50,
            "hr_extra100": v_hr_extra100,
            "hr_adicional_noturno": v_hr_adicional_noturno,
            "ic_folha_finalizada": ic_folha_finalizada,
            "obs": v_obs
        };

        arrEnviar.push(objParamentros);
    }

    var JsonEnviar = JSON.stringify(arrEnviar);
    formdata.append('arrDadosRegistros', JsonEnviar);
    console.log(JsonEnviar);
    

    $.ajax({
        type: 'POST',
        url: '/api/ponto_folha/alterarRegistrosFolhaPonto',
        data: formdata,
        processData: false,
        contentType: false,
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                if(log.status==true){
                    if ($("#ic_folha_finalizada").is(':checked') == true) {
                        var totalVerificado = 0;
                        for (i = 0; i < v_li; i++) {
                            //PRECISA SER SELECIONADO
                            if($("#ic_status"+i).is(':checked') == false){
                                totalVerificado = 1;
                            }
                    
                        }
                        if(totalVerificado==1){
                            sweetMensagem('warning','Todos os registros precisam ser validados antes de Finalizar a folha');
                            return false;
                        }
                        utilsJS.jqueryConfirm('Finalizar Folha ?', 'Ao finalizar a folha, você está de acordo com todos os dados preenchidos. ', function () {
       
                            utilsJS.toastNotify(true,'Registros salvos com sucesso!')
                            var objParametros = {
                                "pk":$('#pk').val()  
                            };
                            sendPost('ponto_folha','colaboradoresCad' ,objParametros);
                        });
                    }
                    else{
                        utilsJS.toastNotify(true,'Registros salvos com sucesso!')
                        var objParametros = {
                            "pk":$('#pk').val()  
                        };
                        sendPost('ponto_folha','colaboradoresCad' ,objParametros);
                    }
                    
                }
            } catch (e) {
                sweetMensagem(false, "Ocorreu um erro na requisição <br /> Contate o suporte");
            }
        }
    }); 
}

function salvarFolhaFinalizada(pk){

    var ic_folha_finalizada = "";
    if ($("#ic_folha_finalizada").is(':checked') == true) {

        utilsJS.jqueryConfirm('Finalizar Folha ?', 'Ao finalizar a folha, você está de acordo com todos os dados preenchidos. ', function () {
       
            ic_folha_finalizada = 1;
            var objParametros = {
                "ic_status": ic_folha_finalizada,
                "pk": pk,
                "colaborador_pk": $("#colaborador_pk").val()
                
            };
            var arrCarregar = carregarController("ponto_folha", "salvarFolhaFinalizada", objParametros);
            if (arrCarregar.status == true) {
                utilsJS.toastNotify(true,'Registros salvos com sucesso!')
                var objParametros = {
                    "pk":$('#pk').val()  
                };
                sendPost('ponto_folha','colaboradoresCad' ,objParametros);
            }

        });
    }
    else{
    }
}

function fcCarregar(){
    utilsJS.loading("Carregando as informações !");
    
    let pk = $('#pk').val();
    let colaborador_pk = $('#colaborador_pk').val();
    let leads_pk = $('#leads_pk').val();
    $("#listar_registros").html("");
    $("#listar_registros").append("");

    setTimeout(() => {
        try {
        if (pk > 0) {
        
            var objParametros = {
                "pk": pk,
                "colaborador_pk": colaborador_pk,
                "leads_pk": leads_pk
            };
            var arrCarregar = carregarController("ponto_folha", "listarRegistros", objParametros);
    
            if (arrCarregar.status == true) {
    
                
                $("#ds_periodo").html(arrCarregar.data[0]['ds_periodo']);
                $("#ds_empresa").html(arrCarregar.data[0]['ds_empresa']);
                $("#ds_cnpj").html(arrCarregar.data[0]['ds_cnpj'])
                $("#ds_endereco").html(arrCarregar.data[0]['ds_endereco'])
                $("#ds_colaborador").html(arrCarregar.data[0]['ds_colaborador']);
                $("#ds_cpf").html(arrCarregar.data[0]['ds_cpf']);
                $("#ds_cargo").html(arrCarregar.data[0]['ds_cargo']);
                $("#ds_posto_trabalho").html(arrCarregar.data[0]['ds_posto_trabalho']);
                $("#ds_dt_admissao").html(arrCarregar.data[0]['dt_admissao']);
                $("#ds_dados_turno").html("Turno: " + arrCarregar.data[0]['ds_turno'] + "  -  Escala: " + arrCarregar.data[0]['ds_escala'] + "  -  Expediente: " + arrCarregar.data[0]['ds_hr_expediente']);
                $("#agenda_colaborador_pk").val(arrCarregar.data[0]['agenda_colaborador_pk']);
    
                var v_html = "";
                var t_hr_ini_exp = "";
                var v_contador = "";
                var v_ht_total = "";
                var v_he_total = "";
                var v_hf_total = "";
                var v_he1_total = "";
                var v_he2_total = "";
                var v_an_total = "";
                var v_expediente_diario = "";
                var v_ds_turno = "";
                var turnos_pk = "";
                var dias_trabalhados = 0;
                var v_ponto_batidos = 0;
                var v_dias_folga = 0;
    
                
    
                if (arrCarregar.data[0]['total_ht'] != null) {
                    v_ht_total = arrCarregar.data[0]['total_ht'];
                }
                if (arrCarregar.data[0]['total_he'] != null) {
                    v_he_total = arrCarregar.data[0]['total_he'];
                }
                if (arrCarregar.data[0]['total_hf'] != null) {
                    v_hf_total = arrCarregar.data[0]['total_hf'];
                }
                if (arrCarregar.data[0]['total_he50'] != null) {
                    v_he1_total = arrCarregar.data[0]['total_he50'];
                }
                if (arrCarregar.data[0]['total_he100'] != null) {
                    v_he2_total = arrCarregar.data[0]['total_he100'];
                }
                if (arrCarregar.data[0]['total_hadn'] != null) {
                    v_an_total = arrCarregar.data[0]['total_hadn'];
                }
                if (arrCarregar.data[0]['expediente_diario'] != null) {
                    v_expediente_diario = arrCarregar.data[0]['expediente_diario'];
                    //console.log(v_expediente_diario);
                }
                if (arrCarregar.data[0]['ds_turno'] != null) {
                    v_ds_turno = arrCarregar.data[0]['ds_turno'];
                    turnos_pk = arrCarregar.data[0]['turnos_pk'];
                }
                if (arrCarregar.data[0]['ic_folha_finalizada'] == "1" ||arrCarregar.data[0]['ic_folha_finalizada'] == 1) {
                    $("#ic_folha_finalizada").prop('checked', true);
                    configurarAcoesFolhaFinalizada(true);
                } else {
                    configurarAcoesFolhaFinalizada(false);
                }
                
                $("#totalLinhas").val(arrCarregar.data[0].registrosfolha.length);
              
                for (i = 0; i < arrCarregar.data[0].registrosfolha.length; i++) {
                    
                    var v_pk = "";
                    var v_dt = "";
                    var hr_ini_expediente = "";
                    var hr_ini_intervalo = "";
                    var hr_fim_intervalo = "";
                    var hr_fim_expediente = "";
                    var hr_trabalhadas = "";
                    var hr_excedentes = "";
                    var hr_faltantes = "";
                    var hr_extra50 = "";
                    var hr_extra100 = "";
                    var hr_adicional_noturno = "";
                    var ds_situacao = "";
                    var v_ic_status = "";
                    var v_obs = "";
                    var arrApontamento = "";
                    var arrPontos = "";
                    var tipo_apontamento = 0;
                    var corEntrada = 0;
                    var corIniIntervalo = 0;
                    var corFimIntervalo = 0;
                    var corSaida = 0;
                    var optionCombolist = 0;
    
                    v_pk = arrCarregar.data[0].registrosfolha[i].ponto_folha_registro_pk;
                    v_dt = arrCarregar.data[0].registrosfolha[i].dt_registro_ponto;
                    arrApontamento = arrCarregar.data[0].registrosfolha[i].arrApontamento;
                    arrPontos = arrCarregar.data[0].registrosfolha[i].arrPontos;
    
                    hr_ini_expediente = arrCarregar.data[0].registrosfolha[i].hr_ini_expediente;
                    hr_ini_expediente = hr_ini_expediente == null ? '' : hr_ini_expediente;
    
                    hr_ini_intervalo = arrCarregar.data[0].registrosfolha[i].hr_ini_intervalo;
                    hr_ini_intervalo = hr_ini_intervalo == null ? '' : hr_ini_intervalo;
    
                    hr_fim_intervalo = arrCarregar.data[0].registrosfolha[i].hr_fim_intervalo;
                    hr_fim_intervalo = hr_fim_intervalo == null ? '' : hr_fim_intervalo;
    
                    hr_fim_expediente = arrCarregar.data[0].registrosfolha[i].hr_fim_expediente;
                    hr_fim_expediente = hr_fim_expediente == null ? '' : hr_fim_expediente;                
    
                    hr_trabalhadas = arrCarregar.data[0].registrosfolha[i].hr_trabalhadas;
                    hr_trabalhadas = hr_trabalhadas == null ? '' : hr_trabalhadas;
    
                    hr_excedentes = arrCarregar.data[0].registrosfolha[i].hr_excedentes;
                    hr_excedentes = hr_excedentes == null ? '' : hr_excedentes;
    
                    hr_faltantes = arrCarregar.data[0].registrosfolha[i].hr_faltantes;
                    hr_faltantes = hr_faltantes == null ? '' : hr_faltantes;
    
                    hr_extra50 = arrCarregar.data[0].registrosfolha[i].hr_extra50;
                    hr_extra50 = hr_extra50 == null ? '' : hr_extra50;
    
                    hr_extra100 = arrCarregar.data[0].registrosfolha[i].hr_extra100;
                    hr_extra100 = hr_extra100 == null ? '' : hr_extra100;
    
                    hr_adicional_noturno = arrCarregar.data[0].registrosfolha[i].hr_adicional_noturno;
                    hr_adicional_noturno = hr_adicional_noturno == null ? '' : hr_adicional_noturno;
    
                    hr_adicional_noturno = arrCarregar.data[0].registrosfolha[i].hr_adicional_noturno;
                    hr_adicional_noturno = hr_adicional_noturno == null ? '' : hr_adicional_noturno;
    
                    v_dia_semana = arrCarregar.data[0].registrosfolha[i].dia_da_semana;
                    v_dia_semana = v_dia_semana == null ? '' : v_dia_semana;
    
                    if(hr_ini_expediente!=""){
                        v_ponto_batidos++;
                    }
    
                    var  tipo_ponto_pk = arrCarregar.data[0].registrosfolha[i].tipo_ponto_pk;
                    if (tipo_ponto_pk == 1) {
                        ds_situacao = "Expediente";
                    } else if (tipo_ponto_pk == 5) {
                        v_dias_folga++;
                        ds_situacao = "Folga";
                    } else if (tipo_ponto_pk == 10) {
                        ds_situacao = "Falta";
                    } else if (tipo_ponto_pk == 11) {
                        ds_situacao = "Abonada";
                    }else if (tipo_ponto_pk == 12) {
                        ds_situacao = "Férias";
                    }else if (tipo_ponto_pk == 15) {
                        ds_situacao = "Afastamento";
                    }else if (tipo_ponto_pk == 16) {
                        ds_situacao = "Atestado";
                    }else if (tipo_ponto_pk == 17) {
                        ds_situacao = "Advertencia";
                    }else if (tipo_ponto_pk == 18) {
                        ds_situacao = "Declaração da defesa civil";
                    }else if (tipo_ponto_pk == 19) {
                        ds_situacao = "Demissão";
                    }else if (tipo_ponto_pk == 20) {
                        ds_situacao = "Folga compensatória";
                    }else if (tipo_ponto_pk == 21) {
                        ds_situacao = "Folga de feriado";
                    }else if (tipo_ponto_pk == 22) {
                        ds_situacao = "Justa causa";
                    }else if (tipo_ponto_pk == 23) {
                        ds_situacao = "Recisão indireta";
                    }else if (tipo_ponto_pk == 24) {
                        ds_situacao = "Suspensão";
                    }else if (tipo_ponto_pk == 25) {
                        ds_situacao = "Troca Folga";
                    }else if (tipo_ponto_pk == 37) {
                        ds_situacao = "Atestado de horas";
                    }
                    else if (tipo_ponto_pk == 33) {
                        ds_situacao = "Declaração de horas abonar";
                    }
                    else if (tipo_ponto_pk == 36) {
                        ds_situacao = "Audiência";
                    }
                    
                    
                    if(ds_situacao=="" && tipo_apontamento!=""){
                        ds_situacao = textoSituacaoApontamentoFolha(tipo_apontamento);
                    }

                    var obs = arrCarregar.data[0].registrosfolha[i].obs;
                    obs = obs == null ? '' : obs;
                    
                    var ic_status = arrCarregar.data[0].registrosfolha[i].ic_status;
                    ic_status = ic_status == null ? '' : ic_status;
                    
    
    
                    
                    
                    
    
                    
    
    
                    
    
    
                    //VERIFICA SE EXISTE ALGUM DADO EM FOLHA.CASO CONTRÁRIO PEGA AS INFORMAÇÕES DO PONTO
                    if(hr_ini_expediente==""){
                        hr_ini_expediente = arrPontos[0]['ponto_ini_expediente'].substring(0, 5)
                        
                    }
                    if(hr_ini_intervalo==""){
                        hr_ini_intervalo = arrPontos[0]['ponto_ini_intervalo'].substring(0, 5)
                    }
                    if(hr_fim_intervalo==""){
                        hr_fim_intervalo = arrPontos[0]['ponto_term_intervalo'].substring(0, 5)
                    }
                    if(hr_fim_expediente==""){
                        hr_fim_expediente = arrPontos[0]['ponto_term_expediente'].substring(0, 5)
                    }
    
                    
                    if(arrApontamento[0]['arrApontamento'].length > 0){
                        
                        tipo_apontamento = arrApontamento[0]['tipo_apontamento_pk'];
                        optionCombolist = 1;
                        if(tipo_apontamento==1){
                            
                            for(a = 0;a<arrApontamento[0]['arrApontamento'].length;a++){
                                if(arrApontamento[0]['arrApontamento'][a]['tipo_ponto_pk']==1){
                                    corEntrada = 1;
                                    hr_ini_expediente = arrApontamento[0]['arrApontamento'][a]['hr_ponto'].substring(0, 5);
                                }
                                else if(arrApontamento[0]['arrApontamento'][a]['tipo_ponto_pk']==3){
                                    corIniIntervalo=1;
                                    hr_ini_intervalo = arrApontamento[0]['arrApontamento'][a]['hr_ponto'].substring(0, 5);
                                }
                                else if(arrApontamento[0]['arrApontamento'][a]['tipo_ponto_pk']==4){
                                    corFimIntervalo =1;
                                    hr_fim_intervalo = arrApontamento[0]['arrApontamento'][a]['hr_ponto'].substring(0, 5);
                                }
                                else if(arrApontamento[0]['arrApontamento'][a]['tipo_ponto_pk']==2){
                                    corSaida = 1;
                                    hr_fim_expediente = arrApontamento[0]['arrApontamento'][a]['hr_ponto'].substring(0, 5);
                                }
                            }
                        }
    
                        
                        
    
                        if (tipo_apontamento == 1) {
                            ds_situacao = "Expediente";
                        } else if (tipo_apontamento == 5 || tipo_apontamento == 3) {
                            v_dias_folga++;
                            ds_situacao = "Folga";
                            hr_ini_expediente = "";
                            hr_ini_intervalo = "";
                            hr_fim_intervalo = "";
                            hr_fim_expediente = "";
                            
                        } else if (tipo_apontamento == 10 || tipo_apontamento == 2) {
                            ds_situacao = "Falta";
                            hr_ini_expediente = "";
                            hr_ini_intervalo = "";
                            hr_fim_intervalo = "";
                            hr_fim_expediente = "";
                        } else if (tipo_apontamento == 11) {
                            ds_situacao = "Abonada";
                        }else if (tipo_apontamento == 12 || tipo_apontamento == 6) {
                            ds_situacao = "Férias";
                            hr_ini_expediente = "";
                            hr_ini_intervalo = "";
                            hr_fim_intervalo = "";
                            hr_fim_expediente = "";
                        }else if (tipo_apontamento == 15) {
                            ds_situacao = "Afastamento";
                        }else if (tipo_apontamento == 16) {
                            ds_situacao = "Atestado";
                        }else if (tipo_apontamento == 17) {
                            ds_situacao = "Advertencia";
                        }else if (tipo_apontamento == 18) {
                            ds_situacao = "Declaração da defesa civil";
                        }else if (tipo_apontamento == 19) {
                            ds_situacao = "Demissão";
                        }else if (tipo_apontamento == 20) {
                            ds_situacao = "Folga compensatória";
                        }else if (tipo_apontamento == 21) {
                            ds_situacao = "Folga de feriado";
                            hr_ini_expediente = "";
                            hr_ini_intervalo = "";
                            hr_fim_intervalo = "";
                            hr_fim_expediente = "";
                        }else if (tipo_apontamento == 22) {
                            ds_situacao = "Justa causa";
                        }else if (tipo_apontamento == 23) {
                            ds_situacao = "Recisão indireta";
                        }else if (tipo_apontamento == 24 || tipo_apontamento == 8) {
                            ds_situacao = "Suspensão";
                            
                        }else if (tipo_apontamento == 25) {
                            ds_situacao = "Troca Folga";
                        }
                    }
    
                    if(arrCarregar.data[0].registrosfolha[i].situacao!=null){
                        ds_situacao = arrCarregar.data[0].registrosfolha[i].situacao;
                        tipo_apontamento = arrCarregar.data[0].registrosfolha[i].tipo_apontamento_pk;
                    }
    
                    
    
                    if(ds_situacao=="Atestado de horas"){
                        hr_faltantes="00:00";
                    }
                    if(ds_situacao=="Abonada"){
                        hr_faltantes="00:00";
                    }
                    if(hr_ini_expediente!=""){
                        dias_trabalhados++;
                    }
                    
                    v_html += "<tr>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='hidden' id='ponto_folha_registros_pk" + i + "' value='" + v_pk + "'>";
                    v_html += "<input type='hidden' id='expediente_diario" + i + "' value='" + v_expediente_diario + "'>";
                    v_html += "<input type='hidden' id='apontamento_alterado" + i + "' value='0'>";
                    v_html += "<input type='hidden' id='tipo_ponto_pk_original" + i + "' value='" + (tipo_ponto_pk == null ? "" : tipo_ponto_pk) + "'>";
    
                    v_html += "<input type='hidden' id='ds_turno" + i + "' value='" + v_ds_turno + "'>";
    
                    if (ic_status == 1) {
                        v_html += "     <input type='checkbox' class='ic_status' id='ic_status"+i+"' checked value='1' onchange='aplicarBloqueioCamposApontamentoFolha("+i+", false)'>";
                    }else {
                        v_html += "     <input type='checkbox' class='ic_status' id='ic_status"+i+"' value='1' onchange='aplicarBloqueioCamposApontamentoFolha("+i+", false)'>";
                    }
    
                    v_html += "   </td>";
                    v_html += "   <td width='25'>";
                    v_html +=           v_dia_semana;
                    v_html += "         <input type='hidden' id='dt_dia_semana" + i + "' size='3' value='" + v_dia_semana + "'>";
                    v_html += "   </td>";
                    v_html += "   <td width='25'>";
                    v_html += v_dt;
                    v_html += "   <input type='hidden' id='dt_hora_ponto" + i + "' size='3' value='" + v_dt + "'>";
                    v_html += "   </td>";
    
                  
    
                    
    
    
    
                    v_html += "   <td width='25' >";
                    v_html += "<input type='text' "+ (corEntrada == 1 ? " style='background-color:#ADD8E6;' " : "") +" "+ (ic_status == 1 ? " " : "") +"  id='hr_ini_expediente" + i + "' size='3' value='" + hr_ini_expediente + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+","+turnos_pk+");marcarApontamentoAlterado("+i+")'>";
                    v_html += "   </td>";
                    v_html += "   <td width='25' >";
                    v_html += "<input type='text' "+ (corIniIntervalo == 1 ? " style='background-color:#ADD8E6'" : "") +" "+ (ic_status == 1 ? " " : "") +" id='hr_ini_intervalo" + i + "' size='3' value='" + hr_ini_intervalo + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+","+turnos_pk+");marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td width='25' >";
                    v_html += "<input type='text' "+ (corFimIntervalo == 1 ? " style='background-color:#ADD8E6'" : "") +" "+ (ic_status == 1 ? " " : "") +" id='hr_fim_intervalo" + i + "' size='3' value='" + hr_fim_intervalo + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+","+turnos_pk+");marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
    
                    v_html += "    <td width='25'>";
                    v_html += "<input type='text' "+ (corSaida == 1 ? " style='background-color:#ADD8E6'" : "") +" "+ (ic_status == 1 ? " " : "") +" id='hr_fim_expediente" + i + "' size='3' value='" + hr_fim_expediente + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+","+turnos_pk+");marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='hr_trabalhadas" + i + "' size='3' value='" + hr_trabalhadas + "' onkeypress='mascara(this,horamask)' onChange='calcTotal();marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='hr_excedentes" + i + "' size='3' value='" + hr_excedentes + "' onkeypress='mascara(this,horamask)' onChange='calcTotal();marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='type' "+ (ic_status == 1 ? " " : "") +" id='hr_faltantes" + i + "' size='3' value='" + hr_faltantes + "' onkeypress='mascara(this,horamask)' onChange='calcTotal();marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td id='td_situacao" + i + "' style='" + estiloSituacaoFolha(ds_situacao) + "'>";
                    v_html += "<font size='1,7'><span id='ds_situacao" + i + "'>" + ds_situacao + "</span></font>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='hr_extra50" + i + "' size='3' value='" + hr_extra50 + "' onkeypress='mascara(this,horamask)' onChange='marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <th style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='hr_extra100" + i + "' size='3' value='" + hr_extra100 + "' onChange='marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='hr_adicional_noturno" + i + "' size='3' value='" + hr_adicional_noturno + "' onkeypress='mascara(this,horamask)' onChange='marcarApontamentoAlterado("+i+")'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "<input type='text' "+ (ic_status == 1 ? " " : "") +" id='obs" + i + "' maxlength='20' value='" + obs + "'>";
                    v_html += "    </td>";
                    v_html += "    <td style=' text-align: center'>";
                    v_html += "     <select "+ (ic_status == 1 ? " " : "") +" id='ic_acao" + i + "'  "+ (optionCombolist == 1 ? " style='background-color:#ADD8E6'" : "") +" onchange='fcAlteraSituacao(this.value," + i + ")'>";
                    v_html += montarOptionsApontamentoFolha(tipo_apontamento);
                    v_html += "        </select> ";
                    v_html += "    </td>";
                    v_html += "    <td style='text-align: center'>";
                    v_html += "         <i " + (ic_status == 1 ? "" : "") + " class='bi bi-ui-checks-grid' id='btnListarPonto' title='Verificar Registro de Ponto' onclick='abrirModalPonto(" + i + ", " + colaborador_pk + ", " + leads_pk + ", &quot;" + DataYMD(v_dt) + "&quot;)' style='display: inline-block; margin-right: 8px; cursor: pointer;'></i>";
                    v_html += "    </td>";
                    v_html += "    <td style='text-align: center'>"; 
                    //v_html += "   <i onclick='fcSalvarApontamento(" + i + ")' class='bi bi-check' style='color: green; cursor: pointer;'></i>";
                    v_html += "    </td>";
                    v_html += "</tr>";
                    
                    
                    
                    setTimeout(function () {
                        PreencherAutomatico(i,turnos_pk);
                    }, 2000);
                    setTimeout(function(row){
                        aplicarBloqueioCamposApontamentoFolha(row, false);
                    }, 0, i);
                    
                }
                v_html += "<tr style='background: #1A0F6B'>";
                v_html += "    <td  width='15%'  colspan='16'>";
                v_html += "      <label style=' color: white '><b>TOTAL DE HORAS</b></label>";
                v_html += "    </td>";
                v_html += "</tr>";
                v_html += "<tr >";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center' colspan=5>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <b>D.T</b>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <b>H.T</b>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <b>H.E</b>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <b>H.F</b>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <b>H.E1</b>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "   <b>H.E2</b>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "   <b>A.N</b>";
                v_html += "    </td>";
                v_html += "</tr>";
                v_html += "<tr >";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center' colspan=5>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html +=           dias_trabalhados;
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <input type='text' id='ht_total' name='ht_total' size='3' maxlength='8' value='" + v_ht_total + "' >";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <input type='text' id='he_total' name='he_total' size='3' maxlength='6' value='" + v_he_total + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <input type='text' id='hf_total' name='hf_total' size='3' maxlength='6' value='" + v_hf_total + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "      &nbsp;";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <input type='text' id='he1_total' name='he1_total' size='3' maxlength='6' value='" + v_he1_total + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td style=' text-align: center'>";
                v_html += "       <input type='text' id='he2_total' name='he2_total' size='3' maxlength='6' value='" + v_he2_total + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
                v_html += "    <td  style=' text-align: center'>";
                v_html += "       <input type='text' id='an_total' name='an_total' size='3' maxlength='6' value='" + v_an_total + "' onkeypress='mascara(this,horamask)'>";
                v_html += "    </td>";
               
                v_html += "    <td  style=' text-align: center'>";
                v_html += "   &nbsp;";
                v_html += "    </td>";
                v_html += "</tr>";
    
                $("#listar_registros").html(v_html);
            }
            else {
                alert('Falhar ao carregar o registro');
            }
        }
        } finally {
            utilsJS.loaded();
        }
    }, 3000);
    

}

//FUNÇÃO PARA FUNCIONAR O RELOAD DO APONTAMENTO
function fcSalvarApontamento(index){
    var data_apontamento = $("#dt_hora_ponto"+index).val();
    var hr_ini_expediente = $("#hr_ini_expediente"+index).val();
    var hr_ini_intervalo = $("#hr_ini_intervalo"+index).val();
    var hr_fim_intervalo = $("#hr_fim_intervalo"+index).val();
    var hr_fim_expediente = $("#hr_fim_expediente"+index).val();
    var tipo_ponto_pk = $("#ic_acao"+index).val();

    //QUANDO FOR FALTA MOTIVO FALTA DEFAULT 3 = Atestado
    var motivo_falta_pk = 3
    //QUANDO FOR FALTA MOTIVO AFASTAMENTO DEFAULT 1 = MOTIVOS_MEDICOS
    var motivo_afastamento_pk = 1
    if(tipo_ponto_pk==""){
        sweetMensagem('warning', 'Informe o Apontamento!');
        return false;
    }
    //SALVAR 
    var objParametros = {
        "leads_pk": $('#leads_pk').val(),
        "colaborador_pk": $('#colaborador_pk').val(),
        "agenda_colaborador_pk": $('#agenda_colaborador_pk').val(),
        "dt_apontamento": data_apontamento,
        "tipo_apontamento_pk": tipo_ponto_pk,
        "hr_ini_expediente": hr_ini_expediente,
        "hr_ini_intervalo": hr_ini_intervalo,
        "hr_fim_intervalo": hr_fim_intervalo,
        "hr_fim_expediente": hr_fim_expediente,
        "motivo_falta_pk": motivo_falta_pk,
        "motivo_afastamento_pk": motivo_afastamento_pk
    };
    var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvarApontamentoReloginho", objParametros);
    if (arrEnviar.status == true){
        // Reload datable
        utilsJS.toastNotify(true, arrEnviar.message);
        location.reload();
            
    }
    else{

        utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
    }

}
function hmToMins(str){
    if (typeof str !== 'undefined' && str !== null) {
        const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
        return hh * 60 + mm;
    }
}

function converHrs(hr){

    horas = (hr / 60)|0;
    min = hr % 60; 
    
    if(horas < 0){
        horas = horas * -1;
    }

    if(min < 0){
        min = min * -1;
    }

    if(min < 10){
        min = "0"+min;
    }

    if(horas < 10){
        horas = "0"+horas;
    }

    return hora = horas +":"+ min;  
}

function PreencherAutomatico(l,turnos_pk) {
    try {
        var v_li = $("#totalLinhas").val(); 
    
        for (l = 0; l < v_li; l++) {

            var ic_acao = $("#ic_acao" + l).val()
            var hr_ini_expediente = $("#hr_ini_expediente" + l).val() || "00:00";
            var hr_fim_expediente = $("#hr_fim_expediente" + l).val() || "00:00";
            var expediente_diario = $("#expediente_diario" + l).val() || "00:00";
           
            var hr_ini_intervalo = $("#hr_ini_intervalo" + l).val() || "0";
            var hr_fim_intervalo = $("#hr_fim_intervalo" + l).val() || "0";
            var hr_excedentes = "00:00";
            var hr_faltantes = "00:00";
            var hr_adicional_noturno = "00:00";
    
            if (hr_ini_expediente != "00:00" && hr_fim_expediente != "00:00") {
    
                hr_ini_expediente = hmToMins(hr_ini_expediente);
                hr_fim_expediente = hmToMins(hr_fim_expediente);
                expediente_diario = hmToMins(expediente_diario);
    
                // Converter intervalo apenas se ambos forem preenchidos
                hr_ini_intervalo = hr_ini_intervalo != "00:00" ? hmToMins(hr_ini_intervalo) : hmToMins("00:01");
                hr_fim_intervalo = hr_fim_intervalo != "00:00" ? hmToMins(hr_fim_intervalo) : hmToMins("00:01");
    
                var hr_trabalhadas = 0;
    
                // Se ambos os horários do intervalo estiverem preenchidos, calcula normalmente
                if (hr_ini_intervalo > 0 && hr_fim_intervalo > 0) {
                    var hr_trabalhadas_manha = hr_ini_intervalo - hr_ini_expediente;
                    var hr_trabalhadas_tarde = hr_fim_expediente - hr_fim_intervalo;
    
                    hr_trabalhadas = hr_trabalhadas_manha + hr_trabalhadas_tarde;
                } else {
                    // Ignora o intervalo e calcula direto
                    hr_trabalhadas = hr_fim_expediente - hr_ini_expediente;
                }
    
                // Corrigir para expediente que ultrapassa meia-noite
                if (hr_trabalhadas < 0) {
                    hr_trabalhadas += 24 * 60;
                }
    
                // Margem de tolerância em minutos
                var margemTolerancia = 5;
    
                // Comparar com o expediente diário considerando a margem de tolerância
                if (expediente_diario > hr_trabalhadas + margemTolerancia) {
                    hr_faltantes = expediente_diario - hr_trabalhadas;
                    hr_faltantes = converHrs(hr_faltantes);
                } else if (expediente_diario < hr_trabalhadas - margemTolerancia) {
                    hr_excedentes = hr_trabalhadas - expediente_diario;
                    hr_excedentes = converHrs(hr_excedentes);
                } else {
                    hr_faltantes = "00:00";
                    hr_excedentes = "00:00";
                }
    
                // Adicional noturno para turnos específicos
                if (turnos_pk == 3) {
                    var adicionaisNoturnos = Math.floor(hr_trabalhadas / 60);
                    var minutosAdicionalNoturno = adicionaisNoturnos * 60;
                    hr_adicional_noturno = converHrs(minutosAdicionalNoturno);
                    $("#hr_adicional_noturno" + l).val(hr_adicional_noturno);
                }
    
                hr_trabalhadas = converHrs(hr_trabalhadas);
                
                if($("#hr_faltantes" + l).val()==""){
                    // Atualizar os valores no formulário
                    $("#hr_faltantes" + l).val(hr_faltantes);
                }
                

                if($("#hr_excedentes" + l).val()==""){
                    $("#hr_excedentes" + l).val(hr_excedentes);
                }
               


                if($("#hr_trabalhadas" + l).val()==""){
                    $("#hr_trabalhadas" + l).val(hr_trabalhadas);
                }
                
                
            } else {
                $("#hr_excedentes" + l).val("");
                $("#hr_faltantes" + l).val("");
                $("#hr_trabalhadas" + l).val("");
                $("#hr_adicional_noturno" + l).val("");
            }
        }

        calcTotal();
    } catch (e) {
        alert(e);
    }
    
}
function calculoOnchange(l,turnos_pk) {
    try {
        var v_li = $("#totalLinhas").val(); 
    
        //for (l = 0; l < v_li; l++) {

            var ic_acao = $("#ic_acao" + l).val()
            var hr_ini_expediente = $("#hr_ini_expediente" + l).val() || "00:00";
            var hr_fim_expediente = $("#hr_fim_expediente" + l).val() || "00:00";
            var expediente_diario = $("#expediente_diario" + l).val() || "00:00";
            var hr_ini_intervalo = $("#hr_ini_intervalo" + l).val() || "0";
            var hr_fim_intervalo = $("#hr_fim_intervalo" + l).val() || "0";
            var hr_excedentes = "00:00";
            var hr_faltantes = "00:00";
            var hr_adicional_noturno = "00:00";
    
            if (hr_ini_expediente != "00:00" && hr_fim_expediente != "00:00") {
    
                hr_ini_expediente = hmToMins(hr_ini_expediente);
                hr_fim_expediente = hmToMins(hr_fim_expediente);
                expediente_diario = hmToMins(expediente_diario);
    
                // Converter intervalo apenas se ambos forem preenchidos
                hr_ini_intervalo = hr_ini_intervalo != "00:00" ? hmToMins(hr_ini_intervalo) : hmToMins("00:01");
                hr_fim_intervalo = hr_fim_intervalo != "00:00" ? hmToMins(hr_fim_intervalo) : hmToMins("00:01");
                
                var hr_trabalhadas = 0;
    
                // Se ambos os horários do intervalo estiverem preenchidos, calcula normalmente
                if (hr_ini_intervalo > 0 && hr_fim_intervalo > 0) {
                    var hr_trabalhadas_manha = hr_ini_intervalo - hr_ini_expediente;
                    var hr_trabalhadas_tarde = hr_fim_expediente - hr_fim_intervalo;
    
                    hr_trabalhadas = hr_trabalhadas_manha + hr_trabalhadas_tarde;
                } else {
                    // Ignora o intervalo e calcula direto
                    hr_trabalhadas = hr_fim_expediente - hr_ini_expediente;
                }
    
                // Corrigir para expediente que ultrapassa meia-noite
                if (hr_trabalhadas < 0) {
                    hr_trabalhadas += 24 * 60;
                }
    
                // Margem de tolerância em minutos
                var margemTolerancia = 5;
    
                // Comparar com o expediente diário considerando a margem de tolerância
                if (expediente_diario > hr_trabalhadas + margemTolerancia) {
                    hr_faltantes = expediente_diario - hr_trabalhadas;
                    hr_faltantes = converHrs(hr_faltantes);
                } else if (expediente_diario < hr_trabalhadas - margemTolerancia) {
            
                    hr_excedentes = hr_trabalhadas - expediente_diario;
                    hr_excedentes = converHrs(hr_excedentes);
                } else {
                    hr_faltantes = "00:00";
                    hr_excedentes = "00:00";
                }
    
                // Adicional noturno para turnos específicos
                if (turnos_pk == 3) {
                    var adicionaisNoturnos = Math.floor(hr_trabalhadas / 60);
                    var minutosAdicionalNoturno = adicionaisNoturnos * 60;
                    hr_adicional_noturno = converHrs(minutosAdicionalNoturno);
                    $("#hr_adicional_noturno" + l).val(hr_adicional_noturno);
                }
    
                hr_trabalhadas = converHrs(hr_trabalhadas);
                
               
                  
                // Atualizar os valores no formulário
                $("#hr_faltantes" + l).val(hr_faltantes);
                $("#hr_excedentes" + l).val(hr_excedentes);
                $("#hr_trabalhadas" + l).val(hr_trabalhadas);
                
            } else {
                $("#hr_excedentes" + l).val("");
                $("#hr_faltantes" + l).val("");
                $("#hr_trabalhadas" + l).val("");
                $("#hr_adicional_noturno" + l).val("");
            }
        //}

        calcTotal();
    } catch (e) {
        alert(e);
    }
    
}



function calcTotal(){ 
    var total_hr_trabalhadas = 0;
    var toral_hr_faltantes = 0;
    var total_hr_excedentes = 0;
    var total_hr_an = 0;

    var v_li = $("#totalLinhas").val();

    for (l = 0; l < v_li; l++) {

        var hr_excedentes = $("#hr_excedentes" + l).val();
        var hr_faltantes = $("#hr_faltantes" + l).val();
        var hr_trabalhadas = $("#hr_trabalhadas" + l).val();
        var hr_an = $("#hr_adicional_noturno" + l).val();

        
        if(hr_excedentes == ""){
            hr_excedentes = "00:00";
        }
        if(hr_faltantes == ""){
            hr_faltantes = "00:00";
        }
        if(hr_trabalhadas == ""){
            hr_trabalhadas = "00:00";
        }
        if(hr_an == ""){
            hr_an = "00:00";
        }
        
        hr_excedentes = hmToMins(hr_excedentes);
        hr_faltantes = hmToMins(hr_faltantes);
        hr_trabalhadas = hmToMins(hr_trabalhadas);
        hr_an = hmToMins(hr_an);

        total_hr_trabalhadas += hr_trabalhadas;
        toral_hr_faltantes += hr_faltantes;
        total_hr_excedentes += hr_excedentes;
        total_hr_an += hr_an;
    }

    total_hr_trabalhadas = converHrs(total_hr_trabalhadas);
    toral_hr_faltantes = converHrs(toral_hr_faltantes);
    total_hr_excedentes = converHrs(total_hr_excedentes);
    total_hr_an = converHrs(total_hr_an);

    $("#ht_total").val(total_hr_trabalhadas);
    $("#he_total").val(total_hr_excedentes);
    $("#hf_total").val(toral_hr_faltantes);
    $("#an_total").val(total_hr_an);
}

function PrintElem(elem){
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}

function fcAlteraSituacao(pk, row){
    marcarApontamentoAlterado(row);

    var situacao = textoSituacaoApontamentoFolha(pk);
    $("#ds_situacao" + row).html(situacao);
    $("#td_situacao" + row).attr("style", estiloSituacaoFolha(situacao));
    aplicarBloqueioCamposApontamentoFolha(row, true);

    if (pk == 11 || pk == 37) {
        $("#hr_faltantes"+row).val("00:00");
    }
}

function fcCancelar(){
    var objParametros = {
        "pk":$('#pk').val()  
    };
    sendPost('ponto_folha','colaboradoresCad',objParametros)
}


var formdata;
var tblListarPontoDia;
$(document).ready(function () {

    formdata = new FormData();
    $("#ic_marcar_todos").on( 'change', function () {
        $(".ic_status").prop('checked', $("#ic_marcar_todos").prop("checked"));
        var v_li = $("#totalLinhas").val();
        for (var i = 0; i < v_li; i++) {
            aplicarBloqueioCamposApontamentoFolha(i, false);
        }
    } );

    //fcVerificacaoPonto();
    fcCarregar();

    //Atibuir funções
    $(document).on('click', '#cmdVoltar', fcCancelar);
    $(document).on('click', '#cmdImprimirModal', fcEnviar);
    $(document).on('click', '#cmdFecharPonto', fcFecharModalPonto);
});


