var pesquisa = 1;
var tblResultado;
function fcCarregarGrid() {
    //tblResultado.clear().destroy();
    var objParametros = {
        "pk": $("#colaborador_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "grupos_leads_pk": $("#grupos_leads_pk").val(),
        "supervisor_pk": $("#supervisores_pk").val(),
        "ds_cpf": $("#ds_cpf").val(),
        "cargo_pk": $("#cargo_pk").val(),
        "ds_pin": $("#ds_pin").val(),
        "ic_status": $("#ic_status").val()

    };
    var v_url = routes_api("colaborador", "listarDataTable", objParametros);
    tblResultado = $("#tblResultado").DataTable({
        searching: true,
        paging: true,
        scrollX: true,
        iDisplayLength: 10,
        processing: false,
        serverSide: true,
        ajax: v_url,
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
        },
        order: [
            [0, "asc"]
        ],
        columns: [
            {
                mRender: function (data, type, full) {
                    return full['pk'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_colaborador'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_lead'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_funcao'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            /*{
                mRender: function (data, type, full) {
                    return full['ds_pin'];
                },
                'orderable': true,
                'searchable': false,
                width: '60px'

            },*/
            {
                mRender: function (data, type, full) {
                    return full['ds_status'];
                },
                'orderable': true,
                'searchable': false,
                width: '60px'

            },
            {
                mRender: function (data, type, full) {
                    var buttonPainel = '<a class="function_edit"><span><i class="bi bi-card-list" style="font-size=18px;color:blue" title="Painel"></i></span></a> &nbsp;&nbsp;';
                    var buttonDelete = '<a class="function_delet_col"><span><i class="bi bi-trash3" style="font-size=18px;color:blue" title="excluir"></i></span></a> &nbsp;&nbsp;';
                    var buttonOpcoes =  '<a class="function_folha"><i class="bi bi-alarm" style="font-size:18px;color:blue" title="Acomp Ponto"></i></a>&nbsp;';
                    return buttonPainel+buttonOpcoes + buttonDelete;
                },
                'orderable': false,
                'searchable': false,
                width: '60px'
            }
        ]

    });
    //Atribui os eventos na coluna ação.

    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcEditar(data['pk']);
    });

    $('#tblResultado tbody').on('click', '.function_delet_col', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['pk'], data['ds_colaborador']);
    });

    $('#tblResultado tbody').on('click', '.function_folha', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirAcompanhamentoFolhaPonto(data['pk'],data['leads_pk'],data['agenda_colaborador_pk']);

    });


}

function fcCarregarLeads() {
    //Carrega os grupos

    var objParametros = {
        "grupos_leads_pk":$("#grupos_leads_pk").val(),
        "supervisor_pk":$("#supervisores_pk").val(),
    };

    var arrCarregar = carregarController("lead", "listarLeadByGrupoAndSupervisores", objParametros);

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}
function fcCarregarLeadsConsultaFolha() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);

    carregarComboAjax($("#leads_consulta_folha_pk"), arrCarregar, " ", "pk", "ds_lead");

}

function fcCarregarGrupoLeads() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("conta", "listarTodos", objParametros);

    carregarComboAjax($("#grupos_leads_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcCarregarColaborador(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
}
function fcEditar(v_pk) {

    var arrCarregar = permissao("colaborador", "cons");
    if (arrCarregar.status != true) {
        utilsJS.toastNotify(false, "Você não tem permissão");
        return false;
    }
    var objParametros = {
        "pk":v_pk,
        "local":$("#local").val()
    };
    sendPost('colaborador','cadForm' ,objParametros);

}

function fcExcluir(v_pk, v_ds_lead) {
    var arrCarregar = permissao("lead", "del");

    if (arrCarregar.status != true) {
        utilsJS.toastNotify(false, 'Você não tem permissão para acessar essa pagina!');
        return false;
    }
    utilsJS.jqueryConfirm('Excluir?', 'Deseja excluir o registro '+v_ds_lead+'?', function () {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("colaborador", "excluir", objParametros);

            if (arrExcluir.status == true) {
                utilsJS.toastNotify(true, arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else {
                utilsJS.toastNotify(false, "Falhou a requisição");
            }
        }
        else {
            utilsJS.toastNotify(false, "Código não encontrado");
        }
    });
    return false;
}

function fcPesquisar() {
    tblResultado.clear().destroy();
    fcCarregarGrid();
}

function fcIncluir() {
    sendPost('colaborador','cadForm',{"local":$("#local").val(),"pk":""})
}


function fcVoltar(){
    if($("#local").val()==1){
        sendPost("menu", "rh",{});
    }
    else{
        sendPost("menu", "operacional",{});
    }
}

function fcCarregarFuncao(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("servico", "listarTodos", objParametros);
    carregarComboAjax($("#cargo_pk"), arrCarregar, " ", "pk", "ds_produto_servico");
}
function fcCarregarColaboradorFolhaPonto() {
    //Carrega os grupos
    
    var objParametros = {
        "leads_pk": $("#leads_consulta_folha_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_consulta_folha_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    carregarComboAjax($("#colaborador_pk_modal"), arrCarregar, " ", "pk", "ds_colaborador");

}


function fcAbrirAcompanhamentoFolhaPonto(colaborador_pk,leads_pk,agenda_colaborador_pk){
    //LISTAR O POSTO DE TRABALHO

    $("#leads_consulta_folha_pk").val("");
    $("#agenda_consulta_folha_colaborador_pk").val("");
    $("#colaborador_consulta_folha_pk").val("");
    $(".chzn-select").chosen('destroy');
       
    $("#leads_consulta_folha_pk").val(leads_pk);
    $("#agenda_consulta_folha_colaborador_pk").val(agenda_colaborador_pk);


    //LISTAR O COLABORADOR
    fcCarregarColaboradorFolhaPonto();

    $("#colaborador_consulta_folha_pk").val(colaborador_pk);

    const dataAtual = new Date();

    // Obtém o mês atual (os meses são indexados a partir de 0, então adicionamos 1)
    const mes = dataAtual.getMonth() + 1;
    if(mes<9){
        mesAtual = "0"+mes;
    }
    else{
        mesAtual = mes;
    }


    // Obtém o ano atual
    const anoAtual = dataAtual.getFullYear();

    $("#ic_consulta_folha_mes").val(mesAtual);


    var html = "";
    for(i=parseInt(anoAtual);i >= parseInt(anoAtual-3);i--){
     
        html += "<option value='" + i + "'>" + i + "</option>";
    }
    $("select[name=ic_consulta_folha_ano]").html(html);


    setTimeout(function () {
        $(".chzn-select").chosen('destroy');
        $(".chzn-select").chosen({ allow_single_deselect: true });
    }, 2000);
    
    fcCarregarGridPontoFolha();
    $("#consulta_folha_ponto").modal("show");
}

function fcFecharConsultaFolhaPonto(){
    $("#consulta_folha_ponto").modal("hide");
}



function fcCarregarGridPontoFolha(){
    $("#grid_consulta_folha_ponto").html("");
    $("#grid_consulta_folha_ponto").append("");
    if($('#agenda_consulta_folha_colaborador_pk').val()==""){
        sweetMensagem('warning','Esse colaborador não tem escala!');
        return false;
    }
    if($('#leads_consulta_folha_pk').val()==""){
        sweetMensagem('warning','Preencha todos os campos!');
        return false;
    }
    if($('#colaborador_consulta_folha_pk').val()==""){
        sweetMensagem('warning', 'preencha todos os campos!');
        return false;
    }
    
    let objParametros = {
        "leads_pk": $('#leads_consulta_folha_pk').val(),
        "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
        "agenda_colaborador_pk": $('#agenda_consulta_folha_colaborador_pk').val(),
        "ic_mes": $('#ic_consulta_folha_mes').val(),
        "ic_ano": $('#ic_consulta_folha_ano').val()
    };
    let arrCarregar = carregarController("ponto_folha", "listarConsultaPontoColaborador", objParametros);
    var html ="";
    if (arrCarregar.status == true) {
        if(arrCarregar.data.length>0){
            $("#ds_turno").text(arrCarregar.data[0]['ds_turno']);
            $("#turnos_pk").text(arrCarregar.data[0]['turnos_pk']);
            $("#ponto_folha_pk").val(arrCarregar.data[0]['ponto_folha_pk']);
            $("#ic_status_ponto_folha_pk").val(arrCarregar.data[0]['ic_status_ponto_folha_pk']);
            var v_dias_trabalhados = 0;
            
            $("#periodo_trabalho").text(arrCarregar.data[0]['hr_inicio_expediente']+" até "+arrCarregar.data[0]['hr_termino_expediente']);
            html+="<div class='row'>";
            html+="<div class='table-container'>";
            html+="<table  style='width:100%;overflow-y: scroll;height: 20px;' id='tblResultado1'>";
            html+="<thead>";
            html+="<tr>";
            html+="                    <th  style='  text-align: center'>";
            html+="                        Validado";
            html+="             </th>";
            html+="                    <th  style='  text-align: center'>";
            html+="                        Data";
            html+="             </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Dia Semana";
            html+="                            </th>";
            html+="       <th  style=' text-align: center'>";
            html+="                                Ini Exp ";
            html+="                            </th>";
            html+="                            <th  style=' text-align: center'>";
            html+="                                Ini Inter ";
            html+="                            </th>";
            html+="                            <th  style='  text-align: center'>";
            html+="                                Fim Inter";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Fim Exp";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             H.T";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             H.E";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             H.F";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Situação";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Apontamento";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Ação";
            html+="                            </th>";
            
            html+="                        </tr>";
            html+="                    </thead>";
            html+="                    <tbody >";
            html += "   <input type='hidden' id='totalLinhas' size='3' value='" + arrCarregar.data.length + "'>";
            
            var v_ponto_batidos = 0;
            var v_dias_folga = 0;
            for(i=0;i<arrCarregar.data.length;i++){
                //-----------------------------//
                if(arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente']!=""){
                    v_dias_trabalhados++;
                }
                else{
                    v_dias_folga++;
                }
                //----------------------------------//
                if(arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente']!=" " ||
                    arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo']!=" "  ||
                    arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo']!=" "  ||
                    arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente']!=" " 
                ){
                    v_ponto_batidos++;
                }

                html+="<tr>";
                    
                html+='<th  style="  text-align: center">';
                
                if (arrCarregar.data[i]['arrVerificado'] && arrCarregar.data[i]['arrVerificado'][0] && arrCarregar.data[i]['arrVerificado'][0]['pk']) {
                    var checked = "";
                    var value = 1;
                    if(arrCarregar.data[i]['arrVerificado'][0]['ic_verificado']==1){
                        checked = "checked";
                        value = 0;
                    }

                    html += "   <input type='checkbox' id='ic_validado" + i + "'  "+checked+" value='"+value+"'  onclick='fcSalvarValidadoReloginho("+i+")'>";
                    html += "   <input type='hidden' id='verificado_pk" + i + "'  value='"+arrCarregar.data[i]['arrVerificado'][0]['pk']+"'>";
                }
                else if(arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento']!=0){
                    html += "   <input type='checkbox' id='ic_validado" + i + "' size='3' checked value='0' onclick='fcSalvarValidadoReloginho("+i+")'>";
                    html += "   <input type='hidden' id='verificado_pk" + i + "'  value=''>";
                }
                else {
                    html += "   <input type='checkbox' id='ic_validado" + i + "' size='3' value='1' onclick='fcSalvarValidadoReloginho("+i+")'>";
                    html += "   <input type='hidden' id='verificado_pk" + i + "'  value=''>";
                }
                html+='</th>';
                html+='<th  style="  text-align: center">';
                html+= arrCarregar.data[i]['dt_hora_ponto'];
                html += "   <input type='hidden' id='dt_hora_ponto" + i + "' size='3' value='" + arrCarregar.data[i]['dt_hora_ponto'] + "'>";
                html += "   <input type='hidden' id='dt_hora_ponto_usa" + i + "' size='3' value='" + arrCarregar.data[i]['dt_hora_ponto_usa'] + "'>";
                html += "   <input type='hidden' id='expediente_diario" + i + "' size='3' value='" + arrCarregar.data[i]['expediente_diario'] + "'>";
                html+='</th>';
                html+='<th  style="  text-align: center">';
                html+= arrCarregar.data[i]['dia_da_semana'];
                html += "         <input type='hidden' id='dt_dia_semana" + i + "' size='3' value='" + arrCarregar.data[i]['dia_da_semana'] + "'>";
                html+='</th>';
                if(arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento']!=0){
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ini']==1){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        
                        html += "<input disabled type='text' id='hr_ini_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html += "<input disabled type='text' id='hr_ini_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ini_int']==3){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html += "<input disabled type='text' id='hr_ini_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html += "<input disabled type='text' id='hr_ini_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_fim_int']==4){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html += "<input disabled type='text' id='hr_fim_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html += "<input disabled type='text' id='hr_fim_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ter']==2){
                        
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html += "<input disabled type='text' id='hr_fim_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html += "<input disabled type='text' id='hr_fim_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                        html+='</th>';
                    }

                    html += "    <th style=' text-align: centers;'>";
                    html += "<input disabled type='text'  id='hr_trabalhadas" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['horas_trabalhadas'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html += "    <th style=' text-align: center;'>";
                    html += "<input disabled type='text' id='hr_excedentes" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['hr_excedentes'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html += "    <th style=' text-align: center;'>";
                    html += "<input disabled type='type' id='hr_faltantes" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['hr_faltante'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                    html += arrCarregar.data[i]['pontos_dia'][0]['situacao'] ;
                    html+='</th>';
                    html+='<th  style="  text-align: center">';
                    html+='<select class="form-control form-control-sm" id="tipo_ponto_pk'+i+'" onchange="habilitarCampos('+i+',this.value)">';
                    html+='        <option value="">Selecione</option>';
                    html+='    <optgroup label="PONTO">';
                    html+='        <option value="1">Ponto/Expediente</option>';
                    html+='    </optgroup>';
                    html+='    <optgroup label="FALTA">';
                    html+='        <option value="2">Falta</option>';
                    html+='        <option value="11">Abonada</option>';
                    html+="        <option value='16'>Atestado</option>";
                    html+="        <option value='18'>Declaração da defesa civil</option>";
                    html+="        <option value='28'>Apoio Operacional </option>";
                    html+="        <option value='29'>Atestado por acompanhar filho ate 5 anos</option>";
                    html+="        <option value='30'>Atestado por serviço Justiça Eleitoral</option>";
                    html+="        <option value='37'>Atestado de horas </option>";
                    html+="        <option value='31'>Doação de sangue</option>";
                    html+="        <option value='32'>Atraso</option>";
                    html+="        <option value='33'>Declaração de horas abonar</option>";
                    html+="        <option value='34'>Sem Justificativa</option>";
                    html+="        <option value='35'>Reciclagem</option>";
                    html+="        <option value='36'>Audiência </option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Folga">';
                    html+='        <option value="3">Folga</option>';
                    html+="        <option value='20'>Folga compensatória</option>";
                    html+="        <option value='21'>Folga de feriado</option>";
                    html+="        <option value='25'>Troca Folga</option>";
                    html+="        <option value='26'>Folga trabalhada</option>";
                    html+="        <option value='27'>Escala Errada</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Afastamento">';
                    html+="        <option value='5'>Afastamento</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Férias">';
                    html+="        <option value='6'>Férias</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Disciplina">';
                    html+="        <option value='8'>Disciplina</option>";
                    html+="        <option value='17'>Advertencia</option>";
                    html+="        <option value='19'>Demissão</option>";
                    html+="        <option value='22'>Justa causa</option>";
                    html+="        <option value='23'>Recisão indireta</option>";
                    html+="        <option value='24'>Suspensão</option>";
                    html+='    </optgroup>';
                    html+='</select>';
                    html+='</th>';



                    
                    html+='</th>';
                    html += '<th style="text-align: center; white-space: nowrap;">';
                    html += '     <a onclick="fcExcluirApontamento(' + arrCarregar.data[i]['pontos_dia'][0]['apontamento_pk'] + ')"><i class="bi-solid bi-trash" style="color:red; cursor:pointer; margin-right: 8px;"></i></a>';
                    html += '     <a onclick="abrirModalHistorico(' + i + ')"><i class="bi bi-ui-checks-grid" style="cursor: pointer;"></i></a>';
                    html += '     <a onclick="fcPontoDiario(' + i + ')"><i class="bi bi-camera-fill" style="cursor: pointer;"></i></a>';
                    html += '</th>';
                    
                    
                }
                else{
                    html+='<th  style="  text-align: center">';
                    html += "<input disabled type='text' id='hr_ini_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                    html+='</th>';
                    html+='<th  style=" text-align: center">';
                    html += "<input disabled type='text' id='hr_ini_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                    html+='</th>';
                    html+='<th  style=" text-align: center">';
                    html += "<input disabled type='text' id='hr_fim_intervalo" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                    html+='</th>';
                    html+='<th  style="  text-align:">';
                    html += "<input disabled type='text' id='hr_fim_expediente" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'].slice(0, 5) + "' onkeypress='mascara(this,horamask)' onChange='calculoOnchange("+i+")'>";
                    html+='</th>';
                    html += "    <th style=' text-align: center;'>";
                    html += "<input disabled type='text'  id='hr_trabalhadas" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['horas_trabalhadas'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html += "    <th style=' text-align: center;'>";
                    html += "<input disabled type='text' id='hr_excedentes" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['hr_excedentes'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html += "    <th style=' text-align: center'>";
                    html += "<input disabled type='type' id='hr_faltantes" + i + "' size='3' value='" + arrCarregar.data[i]['pontos_dia'][0]['hr_faltante'] + "' onkeypress='mascara(this,horamask)' >";
                    html += "    </th>";
                    html+='<th  style="  text-align: center">';
                    html += arrCarregar.data[i]['pontos_dia'][0]['situacao'] ;
                    html+='</th>';
                    html+='<th  style="  text-align: center">';
                    html+='<select class="form-control form-control-sm" id="tipo_ponto_pk'+i+'" onchange="habilitarCampos('+i+',this.value)">';
                    html+='        <option value="">Selecione</option>';
                    html+='    <optgroup label="PONTO">';
                    html+='        <option value="1">Ponto/Expediente</option>';
                    html+="        <option value='37'>Atestado de horas </option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="FALTA">';
                    html+='        <option value="2">Falta</option>';
                    html+='        <option value="11">Abonada</option>';
                    html+="        <option value='16'>Atestado</option>";
                    html+="        <option value='18'>Declaração da defesa civil</option>";
                    html+="        <option value='28'>Apoio Operacional </option>";
                    html+="        <option value='29'>Atestado por acompanhar filho ate 5 anos</option>";
                    html+="        <option value='30'>Atestado por serviço Justiça Eleitoral</option>";
                    html+="        <option value='31'>Doação de sangue</option>";
                    html+="        <option value='32'>Atraso</option>";
                    html+="        <option value='33'>Declaração de horas abonar</option>";
                    html+="        <option value='34'>Sem Justificativa</option>";
                    html+="        <option value='35'>Reciclagem</option>";
                    html+="        <option value='36'>Audiência </option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Folga">';
                    html+='        <option value="3">Folga</option>';
                    html+="        <option value='20'>Folga compensatória</option>";
                    html+="        <option value='21'>Folga de feriado</option>";
                    html+="        <option value='25'>Troca Folga</option>";
                    html+="        <option value='26'>Folga trabalhada</option>";
                    html+="        <option value='27'>Escala Errada</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Afastamento">';
                    html+="        <option value='5'>Afastamento</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Férias">';
                    html+="        <option value='6'>Férias</option>";
                    html+='    </optgroup>';
                    html+='    <optgroup label="Disciplina">';
                    html+="        <option value='8'>Disciplina</option>";
                    html+="        <option value='17'>Advertencia</option>";
                    html+="        <option value='19'>Demissão</option>";
                    html+="        <option value='22'>Justa causa</option>";
                    html+="        <option value='23'>Recisão indireta</option>";
                    html+="        <option value='24'>Suspensão</option>";
                    html+='    </optgroup>';
                    html+='</select>';
                    html+='</th>';
                    html+='<th  style="  text-align: center">';
                    html += '     <a onclick="fcSalvarApontamentoReloginho('+i+')"><i class="bi bi-save-fill" style="color:green;cursor:pointer;size:15px"></i></a> ';
                    html += '     <a onclick="abrirModalHistorico(' + i + ')"><i class="bi bi-ui-checks-grid" style="cursor: pointer;"></i></a>';
                    html += '     <a onclick="fcPontoDiario(' + i + ')"><i class="bi bi-camera-fill" style="cursor: pointer;"></i></a>';
                    html+='</th>';
                    
                }
                html+='</tr>';
            }
            html += "<tr >";
            html+= "    <td  style=' text-align: center' colspan=6>";
            html+= "      &nbsp;";
            html+= "    </td>";
            html += "    <td  style=' text-align: center'>";
            html += "       <b>D.T</b><br>"+v_dias_trabalhados;
            html += "    </td>";
            html+= "    <td  style=' text-align: center'>";
            html+= "       <input type='text' id='ht_total' name='ht_total' size='3' disabled maxlength='8' value='' >";
            html+= "    </td>";
            html+= "    <td  style=' text-align: center'>";
            html+= "       <input type='text' id='he_total' name='he_total' size='3' disabled maxlength='6' value='' onkeypress='mascara(this,horamask)'>";
            html+= "    </td>";
            html+= "    <td  style=' text-align: center'>";
            html+= "       <input type='text' id='hf_total' name='hf_total' size='3' disabled maxlength='6' value='' onkeypress='mascara(this,horamask)'>";
            html+= "    </td>";
            html+= "    <td  style=' text-align: center'>";
            html+= "      &nbsp;";
            html+= "    </td>";
           
            html+= "    <td  style=' text-align: center'>";
            html+= "   &nbsp;";
            html+= "    </td>";
            html+= "    <td  style=' text-align: center'>";
            html+= "   &nbsp;";
            html+= "    </td>";
            html+= "</tr>";
                            
            html+='</tbody>';
            html+=' </table>';
            html+=' </div>';
            html+='</div>';

            setTimeout(function () {
                PreencherAutomatico();
            }, 2000);
        }
        else{
            if(arrCarregar.message!=""){
                html+='<h1 class="pulsing-text">'+arrCarregar.message+'</h1>';
            }
            else{
                html+='<h1 class="pulsing-text">Este colaborador não tem registros!</h1>';
            }
            
        }
        
    }
    
    $("#grid_consulta_folha_ponto").html(html);



    if($("#ic_status_ponto_folha_pk").val()==1){
        $("#tblResultado1 input, #tblResultado1 select, #tblResultado1 a").prop("disabled", true);
        $("#tblResultado1 a i.bi-solid.bi-check").each(function() {
            $(this).parent().removeAttr("onclick").css({
                "pointer-events": "none",
                "opacity": "0.5"
            });
        });        
        $("#tblResultado1 a i.bi-solid.bi-trash").each(function() {
            $(this).parent().removeAttr("onclick").css({
                "pointer-events": "none",
                "opacity": "0.5"
            });
        });        
        $("#text_folha_finalizada").html('<div class="row"><div class="col-md-4"></div><div class="col-md-4"><h6 class="pulsing-text">Está folha já está finalizada e não pode ser alterada!</h6></div></div>');
    }
    else{
        $("#text_folha_finalizada").html("");
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

function habilitarCampos(l,tipo_ponto){
   
    $("#hr_ini_expediente" + l).prop("disabled", false);
    $("#hr_fim_expediente" + l).prop("disabled", false);
    $("#expediente_diario" + l).prop("disabled", false);
    $("#hr_ini_intervalo" + l).prop("disabled", false);
    $("#hr_fim_intervalo" + l).prop("disabled", false);
    $("#hr_excedentes" + l).prop("disabled", false);
    $("#hr_faltantes" + l).prop("disabled", false);
    $("#hr_trabalhadas" + l).prop("disabled", false);


    //FOLGA DE FERIADO
    if(tipo_ponto==21){
        abrirModalFeriados(l);
    }
    

    if(tipo_ponto==""){
        $("#hr_ini_expediente" + l).prop("disabled", true);
        $("#hr_fim_expediente" + l).prop("disabled", true);
        $("#expediente_diario" + l).prop("disabled", true);
        $("#hr_ini_intervalo" + l).prop("disabled", true);
        $("#hr_fim_intervalo" + l).prop("disabled", true);
        $("#hr_excedentes" + l).prop("disabled", true);
        $("#hr_faltantes" + l).prop("disabled", true);
        $("#hr_trabalhadas" + l).prop("disabled", true);
    }
    

}
function PreencherAutomatico() {
    try {
        var v_li = $("#totalLinhas").val(); 
    
        for (l = 0; l < v_li; l++) {
            var hr_ini_expediente = $("#hr_ini_expediente" + l).val() || "00:00";
            
            var hr_fim_expediente = $("#hr_fim_expediente" + l).val() || "00:00";
            var expediente_diario = $("#expediente_diario" + l).val() || "00:00";
         
            var hr_ini_intervalo = $("#hr_ini_intervalo" + l).val() || "0";
            var hr_fim_intervalo = $("#hr_fim_intervalo" + l).val() || "0";
            var turnos_pk = $("#turnos_pk").val();
            var hr_excedentes = "00:00";
            var hr_faltantes = "00:00";

            if (hr_ini_expediente != "00:00" && hr_fim_expediente != "00:00" ) {
    
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
                if (hmToMins(hr_trabalhadas) > expediente_diario) {
                    $("#hr_trabalhadas" + l).css("background-color", "#3F47CC");
                    $("#hr_trabalhadas" + l).css("color", "white");
                } else {
                    $("#hr_trabalhadas" + l).css("background-color", ""); // Remover cor
                    $("#hr_trabalhadas" + l).css("color", "black");
                }
                if (hmToMins(hr_excedentes) > 0) {
                    $("#hr_excedentes" + l).css("background-color", "#FF7F26");
                    $("#hr_excedentes" + l).css("color", "white");
                } else {
                    $("#hr_excedentes" + l).css("background-color", ""); // Remover cor
                    $("#hr_excedentes" + l).css("color", "black");
                }
                if (hmToMins(hr_faltantes) > 0) {
                    $("#hr_faltantes" + l).css("background-color", "#ED1B24");
                    $("#hr_faltantes" + l).css("color", "white");
                } else {
                    $("#hr_faltantes" + l).css("background-color", ""); // Remover cor
                    $("#hr_faltantes" + l).css("color", "black");
                }
                
            } else {
                $("#hr_excedentes" + l).val("");
                $("#hr_faltantes" + l).val("");
                $("#hr_trabalhadas" + l).val("");
            }
        }
        calcTotal();
    } catch (e) {
        alert(e);
    }
    
}
function calculoOnchange(l) {
    try {
        var hr_ini_expediente = $("#hr_ini_expediente" + l).val() || "00:00";
        var hr_fim_expediente = $("#hr_fim_expediente" + l).val() || "00:00";
        var expediente_diario = $("#expediente_diario" + l).val() || "00:00";
        var hr_ini_intervalo = $("#hr_ini_intervalo" + l).val() || "0";
        var hr_fim_intervalo = $("#hr_fim_intervalo" + l).val() || "0";
        var hr_excedentes = "00:00";
        var hr_faltantes = "00:00";

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

           

            // Comparar com o expediente diário considerando a margem de tolerância
            if (expediente_diario > hr_trabalhadas) {
                hr_faltantes = expediente_diario - hr_trabalhadas;
                hr_faltantes = converHrs(hr_faltantes);
            } else if (expediente_diario < hr_trabalhadas) {
        
                hr_excedentes = hr_trabalhadas - expediente_diario;
                hr_excedentes = converHrs(hr_excedentes);
            } else {
                hr_faltantes = "00:00";
                hr_excedentes = "00:00";
            }

            


            hr_trabalhadas = converHrs(hr_trabalhadas);
            
            
                
            // Atualizar os valores no formulário
            $("#hr_faltantes" + l).val(hr_faltantes);
            $("#hr_excedentes" + l).val(hr_excedentes);
            $("#hr_trabalhadas" + l).val(hr_trabalhadas);

            if (hmToMins(hr_trabalhadas) > expediente_diario) {
                $("#hr_trabalhadas" + l).css("background-color", "#3F47CC");
                $("#hr_trabalhadas" + l).css("color", "white");
            } else {
                $("#hr_trabalhadas" + l).css("background-color", ""); // Remover cor
                $("#hr_trabalhadas" + l).css("color", "black");
            }
            if (hmToMins(hr_excedentes) > 0) {
                $("#hr_excedentes" + l).css("background-color", "#FF7F26");
                $("#hr_excedentes" + l).css("color", "white");
            } else {
                $("#hr_excedentes" + l).css("background-color", ""); // Remover cor
                $("#hr_excedentes" + l).css("color", "black");
            }
            if (hmToMins(hr_faltantes) > 0) {
                $("#hr_faltantes" + l).css("background-color", "#ED1B24");
                $("#hr_faltantes" + l).css("color", "white");
            } else {
                $("#hr_faltantes" + l).css("background-color", ""); // Remover cor
                $("#hr_faltantes" + l).css("color", "black");
            }
            
        } else {
            $("#hr_excedentes" + l).val("");
            $("#hr_faltantes" + l).val("");
            $("#hr_trabalhadas" + l).val("");
        }
        calcTotal();
    } catch (e) {
        alert(e);
    }
    
}

function calcTotal(){ 
    try{
        var total_hr_trabalhadas = 0;
        var toral_hr_faltantes = 0;
        var total_hr_excedentes = 0;

        var v_li = $("#totalLinhas").val();

        for (l = 0; l < v_li; l++) {

            var hr_excedentes = $("#hr_excedentes" + l).val();
            var hr_faltantes = $("#hr_faltantes" + l).val();
            var hr_trabalhadas = $("#hr_trabalhadas" + l).val();

            
            if(hr_excedentes == ""){
                hr_excedentes = "00:00";
            }
            if(hr_faltantes == ""){
                hr_faltantes = "00:00";
            }
            if(hr_trabalhadas == ""){
                hr_trabalhadas = "00:00";
            }
            
            
            hr_excedentes = hmToMins(hr_excedentes);
            hr_faltantes = hmToMins(hr_faltantes);
            hr_trabalhadas = hmToMins(hr_trabalhadas);
        

            total_hr_trabalhadas += hr_trabalhadas;
            toral_hr_faltantes += hr_faltantes;
            total_hr_excedentes += hr_excedentes;
        
        }

        total_hr_trabalhadas = converHrs(total_hr_trabalhadas);
        toral_hr_faltantes = converHrs(toral_hr_faltantes);
        total_hr_excedentes = converHrs(total_hr_excedentes);
    

        $("#ht_total").val(total_hr_trabalhadas);
        $("#he_total").val(total_hr_excedentes);
        $("#hf_total").val(toral_hr_faltantes);
        fcGerarFolhaPonto();
    }
     catch (e) {
        alert(e);
    }
    
}

//FUNÇÃO PARA FUNCIONAR O RELOAD DO APONTAMENTO
function fcSalvarApontamentoReloginho(index){

    var data_apontamento = $("#dt_hora_ponto"+index).val();
    var hr_ini_expediente = $("#hr_ini_expediente"+index).val();
    var hr_ini_intervalo = $("#hr_ini_intervalo"+index).val();
    var hr_fim_intervalo = $("#hr_fim_intervalo"+index).val();
    var hr_fim_expediente = $("#hr_fim_expediente"+index).val();
    var tipo_ponto_pk = $("#tipo_ponto_pk"+index).val();
    var hr_trabalhadas = $("#hr_trabalhadas"+index).val();
    var hr_excedentes = $("#hr_excedentes"+index).val();
    var hr_faltantes = $("#hr_faltantes"+index).val();

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
        "leads_pk": $('#leads_consulta_folha_pk').val(),
        "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
        "agenda_colaborador_pk": $('#agenda_consulta_folha_colaborador_pk').val(),
        "dt_apontamento": data_apontamento,
        "tipo_apontamento_pk": tipo_ponto_pk,
        "hr_ini_expediente": hr_ini_expediente,
        "hr_ini_intervalo": hr_ini_intervalo,
        "hr_fim_intervalo": hr_fim_intervalo,
        "hr_fim_expediente": hr_fim_expediente,
        "hr_trabalhadas": hr_trabalhadas,
        "hr_excedentes": hr_excedentes,
        "hr_faltantes": hr_faltantes,
        "motivo_falta_pk": motivo_falta_pk,
        "motivo_afastamento_pk": motivo_afastamento_pk
    };
    var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvarApontamentoReloginho", objParametros);
    if (arrEnviar.status == true){
        // Reload datable
        fcGerarFolhaPonto();
        utilsJS.toastNotify(true, arrEnviar.message);
        $("#grid_consulta_folha_ponto").html("");
        $("#grid_consulta_folha_ponto").append("");
        
        fcCarregarGridPontoFolha();
            
    }
    else{

        utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
    }

}
function fcSalvarFolgaFeriado(index){

    var data_apontamento = $("#dt_hora_ponto"+index).val();
    var tipo_ponto_pk = $("#tipo_ponto_pk"+index).val();

    //QUANDO FOR FALTA MOTIVO FALTA DEFAULT 3 = Atestado
    var motivo_falta_pk = 3
    //QUANDO FOR FALTA MOTIVO AFASTAMENTO DEFAULT 1 = MOTIVOS_MEDICOS
    var motivo_afastamento_pk = 1

    var feriadoSelecionado = $('input[name="feriado_pk"]:checked').val();
    if(tipo_ponto_pk==""){
        sweetMensagem('warning', 'Informe o Apontamento!');
        return false;
    }
    //SALVAR 
    var objParametros = {
        "leads_pk": $('#leads_consulta_folha_pk').val(),
        "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
        "agenda_colaborador_pk": $('#agenda_consulta_folha_colaborador_pk').val(),
        "dt_apontamento": data_apontamento,
        "tipo_apontamento_pk": tipo_ponto_pk,
        "tipo_apontamento_pk": tipo_ponto_pk,
        "feriado_pk": feriadoSelecionado,
        "motivo_afastamento_pk": motivo_afastamento_pk
    };
    var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvarApontamentoReloginho", objParametros);
    if (arrEnviar.status == true){
        // Reload datable
        utilsJS.toastNotify(true, arrEnviar.message);
        fcGerarFolhaPonto();
        $("#grid_consulta_folha_ponto").html("");
        $("#grid_consulta_folha_ponto").append("");
        fcCarregarGridPontoFolha();
        $('#feriadosModal').modal('hide');
            
    }
    else{

        utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
    }

}
function fcSalvarValidadoReloginho(index){
    var dt_hora_ponto = $("#dt_hora_ponto"+index).val();
    var verificado_pk = $("#verificado_pk"+index).val();
    var ic_verificado = $("#ic_validado"+index).val();


    
    utilsJS.jqueryConfirm('Validar?', 'Ao validar, você está de acordo com as informações apresentadas nesta data. ', function () {
        
           
        
            //SALVAR 
            var objParametros = {
                "pk": verificado_pk,
                "leads_pk": $('#leads_consulta_folha_pk').val(),
                "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
                "dt_hora_ponto": dt_hora_ponto,
                "ic_verificado": ic_verificado
            };
            var arrEnviar = carregarController("agenda_colaborador_apontamento", "salvarValidadoReloginho", objParametros);
            if (arrEnviar.status == true){
                // Reload datable
                utilsJS.toastNotify(true, arrEnviar.message);
                fcGerarFolhaPonto();
                $("#grid_consulta_folha_ponto").html("");
                $("#grid_consulta_folha_ponto").append("");
                
                fcCarregarGridPontoFolha();
                    
            }
            else{

                utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
            }
        
        

    });

    if(ic_verificado==1){
        $("#ic_validado" + index).prop("checked", false);
    }
    else{
        $("#ic_validado" + index).prop("checked", true);
    }
    

}
function fcExcluirApontamento(apontamento_pk){

    utilsJS.jqueryConfirm('Remover?', 'Deseja realmente remover o apontamento ? ', function () {
        //SALVAR 
        var objParametros = {
            "apontamento_pk": apontamento_pk
        };
        var arrEnviar = carregarController("agenda_colaborador_apontamento", "desabilitarApontamento", objParametros);
        if (arrEnviar.status == true){
            // Reload datable
            
            utilsJS.toastNotify(true, arrEnviar.message);
            $("#grid_consulta_folha_ponto").html("");
            $("#grid_consulta_folha_ponto").append("");
            fcCarregarGridPontoFolha();
                
        }
        else{
            utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro');
        }
    });

}


function fcGerarFolhaPonto(){
    var v_li = $("#totalLinhas").val();
  
    var arrEnviar = []; 
   

    for (i = 0; i < v_li; i++) {
        
        var v_dt_hora_ponto = $("#dt_hora_ponto" + i).val();
        var v_hr_ini_expediente = ($("#hr_ini_expediente" + i).val() != "") ? $("#hr_ini_expediente" + i).val() : null;
        var v_hr_ini_intervalo = ($("#hr_ini_intervalo" + i).val() != "") ? $("#hr_ini_intervalo" + i).val() : null;
        var v_hr_fim_intervalo = ($("#hr_fim_intervalo" + i).val() != "") ? $("#hr_fim_intervalo" + i).val() : null;
        var v_hr_fim_expediente = ($("#hr_fim_expediente" + i).val() != "") ? $("#hr_fim_expediente" + i).val() : null;
        var v_hr_trabalhadas = ($("#hr_trabalhadas" + i).val() != "") ? $("#hr_trabalhadas" + i).val() : null;
        var v_hr_excedentes = ($("#hr_excedentes" + i).val() != "") ? $("#hr_excedentes" + i).val() : null;
        var v_hr_faltantes = ($("#hr_faltantes" + i).val() != "") ? $("#hr_faltantes" + i).val() : null;
        var v_tipo_ponto_pk = ($("#tipo_ponto_pk" + i).val() != "") ? $("#tipo_ponto_pk" + i).val() : null;
        var ic_verificado = $("#ic_validado"+i).val();
        var objParamentros = {
            "leads_pk": $('#leads_consulta_folha_pk').val(),
            "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
            "agenda_colaborador_pk": $('#agenda_consulta_folha_colaborador_pk').val(),
            "ic_mes": $('#ic_consulta_folha_mes').val(),
            "ic_ano": $('#ic_consulta_folha_ano').val(),
            "dt_hora_ponto": v_dt_hora_ponto,
            "hr_ini_expediente": v_hr_ini_expediente,
            "hr_ini_intervalo": v_hr_ini_intervalo,
            "hr_fim_intervalo": v_hr_fim_intervalo,
            "hr_fim_expediente": v_hr_fim_expediente,
            "hr_trabalhadas": v_hr_trabalhadas,
            "hr_excedentes": v_hr_excedentes,
            "hr_faltantes": v_hr_faltantes,
            "ic_status": ic_verificado,
            "tipo_ponto_pk": v_tipo_ponto_pk
        };

        arrEnviar.push(objParamentros);
    }

    var JsonEnviar = JSON.stringify(arrEnviar);
    formdata.append('arrDados', JsonEnviar);

    $.ajax({
        type: 'POST',
        url: '/api/ponto_folha/gerarFolhaPontoByRelogio',
        data: formdata,
        processData: false,
        contentType: false,
        complete: function (response) {
            try {
                var log = JSON.parse(response.responseText);
                
            } catch (e) {
                utilsJS.sweetMensagem(false, "Ocorreu um erro na requisição <br /> Contate o suporte");
            }
        }
    }); 

}

function abrirModalHistorico(i){
    
    tblListarPontoDia.clear().destroy();
    listarHistorico(i)
    $("#janela_historico").modal("show");
}
function fcFecharModalHistorico(){
    $("#janela_historico").modal("hide");
}
function listarHistorico(i){
   
    try{
        if(i>=0){
            // Obter o valor atual
      
       
            var objParametros = {
                "leads_pk": $('#leads_consulta_folha_pk').val(),
                "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
                "agenda_colaborador_padrao_pk": $('#agenda_consulta_folha_colaborador_pk').val(),
                "dt_ponto": $('#dt_hora_ponto_usa'+i).val(),
                "ic_historico": 1
            };
    
            var v_url = routes_api("ponto_folha", "listarModalPonto", objParametros);
    
            tblListarPontoDia = $("#tblListarPontoDia").DataTable({
                searching: false,
                paging: false,
                processing: false,
                serverSide: false,
                ajax: v_url,
                responsive: true,
                scrollY: true,
                language: {
                    emptyTable: "Não existem Dados cadastrados"
                },
                order: [
                    [0, "asc"]
                ],
                columns: [
                    {
                        mRender: function (data, type, full) {
                            return full['indice'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    },
                    {
                        mRender: function (data, type, full) {
                            return full['dt_cadastro'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    },
                    {
                        mRender: function (data, type, full) {
                            return full['hora'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    },
                    {
                        mRender: function (data, type, full) {
                            return full['tipo_apontamento'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    },
                    {
                        mRender: function (data, type, full) {
                            return full['usuario_cadastro'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    },
                    {
                        mRender: function (data, type, full) {
                            return full['ds_status'];
                        },
                        'orderable': true,
                        'searchable': false,
                        width: '80px'
    
                    }
                ]
    
            });
        }
        else{
            tblListarPontoDia = $("#tblListarPontoDia").DataTable({
                searching: false,
                paging: false        
            });
        }
    }
    catch(e){
        console.log(e);
    }
    
    
}

function abrirModalFeriados(i){
    $('#feriadosModal').modal('show');
    tblFeriado.clear().destroy();
    fcFeriados(i);
}

function fcFeriados(i){
    var objParametros = {
        "ic_mes": $('#ic_consulta_folha_mes').val(),
        "ic_ano": $('#ic_consulta_folha_ano').val(),
        "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
    };     
    
    var v_url = routes_api("feriado", "listarFeriadoRelogio", objParametros);

    //Trata a tabela
        tblFeriado = $('#tblFeriado').DataTable({
            searching: false,
            paging: false,
            scrollX: true,
            pageLength: 10,
            aLengthMenu: [10, 25, 50, 100],
            iDisplayLength: 10,
            processing: false,
            serverSide: true,
            ajax: v_url,
            responsive: true,
            language: {
                emptyTable: "Não existem Dados cadastrados"
            },
            order: [
                [0, "asc"]
            ],
            columns: [
                {
                    mRender: function (data, type, full) {
                        return "<input type='radio' class='checks' name='feriado_pk' value='"+full['pk']+"' onclick='fcSalvarFolgaFeriado("+i+")'>";
                    },
                    'orderable': true,
                    'searchable': false,
    
                },
                {
                    mRender: function (data, type, full) {
                        return full['nome'];
                    },
                    'orderable': true,
                    'searchable': false,
    
                },
                {
                    mRender: function (data, type, full) {
                        return full['data_feriado'];
                    },
                    'orderable': true,
                    'searchable': false,
    
                },
                {
                    mRender: function (data, type, full) {
                        return full['tipo'];
                    },
                    'orderable': true,
                    'searchable': false,
    
                },
                {
                    mRender: function (data, type, full) {
                        return full['estado'];
                    },
                    'orderable': true,
                    'searchable': false,
    
                },
                {
                    mRender: function (data, type, full) {
                        return full['cidade'];
                    },
                    'orderable': true,
                    'searchable': false,
    
                }
            ]
    });           
    
}
function fcPontoDiario(i){
    
    $("#janela_ponto_diario").modal("show");
    $("#grid_ponto_diario").append("");
    $("#grid_ponto_diario").html("");
    var strRetorno = "";
    var objParametrosP = {
        "dt_ini": $('#dt_hora_ponto'+i).val(),
        "dt_final": $('#dt_hora_ponto'+i).val(),
        "leads_pk": $('#leads_consulta_folha_pk').val(),
        "colaborador_pk": $('#colaborador_consulta_folha_pk').val(),
        "agenda_colaborador_padrao_pk": $('#agenda_consulta_folha_colaborador_pk').val()
        
    };
    
    var arrCarregarP = carregarController("ponto", "reloginhoHistoricoPonto", objParametrosP);
    if (arrCarregarP.status == true){
        if(arrCarregarP.data!=null){
            if(arrCarregarP.data.length > 0){
                strRetorno+="    <tbody>";
                strRetorno+="       <tr  align=center style='background-color:f5f5f5;border-color:b4b4b4;border-style: solid;'>";
                strRetorno+="           <th >Legenda Registro Ponto</th>";
                strRetorno+="           <th >Hr Registro Ponto</th>";
                strRetorno+="           <th >Img Ponto App Entrada</th>";
                strRetorno+="           <th >Local Ponto App</th>";
                strRetorno+="       </tr>";
                for(j=0; j < arrCarregarP.data.length ;j++){
                    var ds_localizacao = "";
                    var ds_imagem_entrada = "";
                    var ds_legenda = "";


                    if(arrCarregarP.data[j]['ds_localizacao']!= null){
                        ds_localizacao = arrCarregarP.data[j]['ds_localizacao'];
                    }


                    if(arrCarregarP.data[j]['ds_imagem_entrada']==""){
                        ds_imagem_entrada='';
                    }else{
                        ds_imagem_entrada = arrCarregarP.data[j]['ds_imagem_entrada'];
                    }
                    if (arrCarregarP.data[j]['ds_legenda'] == null) {
                        ds_legenda = "";
                    } else {
                        ds_legenda = arrCarregarP.data[j]['ds_legenda'];
                    }
                    if (arrCarregarP.data[j]['ds_registro_ponto'] == null) {
                        ds_registro_ponto = "";
                    } else {
                        ds_registro_ponto = arrCarregarP.data[j]['ds_registro_ponto'];
                    }
                    strRetorno += "<tr align=center style='border-style: solid;'>";
                    strRetorno+="<td  width='10%'>"+ds_legenda+"</td>";
                    strRetorno+="<td  width='10%'>"+ds_registro_ponto+"</td>";
                    strRetorno+='<td align=center  width="40%" class="galeria">'+arrCarregarP.data[j]['img_ponto']+'</td>';

                    strRetorno+="<td  width='10%'>"+ds_localizacao.substring(0, 50)+"</td>";
                    strRetorno+="</tr>";
                }
            }
        }
        
    }
    if (strRetorno != "") {
        $("#grid_ponto_diario").append(strRetorno);
    } else {
        $("#grid_ponto_diario").append("");
    }
    
}
function fcFecharPontoDiario(){
    $("#grid_ponto_diario").append("");
    $("#janela_ponto_diario").modal("hide");
}
function fcCarregarSupervisor(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarSupervisor", objParametros);
    carregarComboAjax($("#supervisores_pk"), arrCarregar, " ", "pk", "ds_usuario");
}
var formdata = null;

$(document).ready(function()
    {
        formdata = new FormData();

    
    fcCarregarGrupoLeads();
    fcCarregarSupervisor();
    
    $('#grupos_leads_pk').change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeads();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    $('#supervisores_pk').change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeads();
        $(".chzn-select").chosen({ allow_single_deselect: true });
    });
    fcCarregarFuncao();

    fcCarregarColaborador();



    $(".chzn-select").chosen({ allow_single_deselect: true });


    fcCarregarGrid();

    fcCarregarLeadsConsultaFolha();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisarLead', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdVoltar', fcVoltar);


    $("#leads_consulta_folha_pk").change(function () {
        
        $(".chzn-select").chosen('destroy');
        fcCarregarColaboradorFolhaPonto();

        //PEGA A AGENDA DO LEAD

       
        
        $(".chzn-select").chosen({ allow_single_deselect: true });

        fcCarregarGridPontoFolha();

    });
    $("#colaborador_consulta_folha_pk").change(function () {

        if($("#colaborador_consulta_folha_pk").val()!=""){
            var objParametros = {
                "leads_pk": $("#leads_consulta_folha_pk").val(),
                "colaboradores_pk":$("#colaborador_consulta_folha_pk").val()
            };
         
            var arrCarregar = carregarController("agenda_colaborador_padrao", "pegarPostoDeTrabalhoPorLeadEColaborador", objParametros);
      
            if(arrCarregar.data.length > 0){
           
                $("#agenda_consulta_folha_colaborador_pk").val(arrCarregar.data[0]['pk']);
                
                
            }
    
            fcCarregarGridPontoFolha();
        }

        
        

    });
    $("#ic_consulta_folha_mes").change(function () {

        fcCarregarGridPontoFolha();

    });
    $("#ic_consulta_folha_mes").change(function () {

        fcCarregarGridPontoFolha();

    });

    fcFeriados(0);

    listarHistorico(-1);

});
