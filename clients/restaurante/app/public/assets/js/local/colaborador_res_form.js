var pesquisa = 1;
var tblResultado;
function fcCarregarGrid() {
    //tblResultado.clear().destroy();
    var objParametros = {
        "pk": $("#colaborador_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "grupos_leads_pk": $("#grupos_leads_pk").val(),
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
            emptyTable: "Não existem Dados cadastrados"
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
            {
                mRender: function (data, type, full) {
                    return full['ds_pin'];
                },
                'orderable': true,
                'searchable': false,
                width: '60px'

            },
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
        "grupos_leads_pk":$("#grupos_leads_pk").val()
    };

    var arrCarregar = carregarController("lead", "listarLeadByGrupo", objParametros);

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");

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
function fcCarregarGridPontoFolha(){
    $("#grid_consulta_folha_ponto").html("");
    $("#grid_consulta_folha_ponto").append("");
    if($('#agenda_consulta_folha_colaborador_pk').val()==""){
        utilsJS.toastNotify(false, 'Esse colaborador não tem escala!');
        return false;
    }
    if($('#leads_consulta_folha_pk').val()==""){
        utilsJS.toastNotify(false, 'Preencha todos os campos!');
        return false;
    }
    if($('#colaborador_consulta_folha_pk').val()==""){
        utilsJS.toastNotify(false, 'preencha todos os campos!');
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
            html+="<div class='row'>";
            html+="<div class='table-container'>";
            html+="<table  style='width:100%;overflow-y: scroll;height: 20px;' id='tblResultado1'>";
            html+="<thead>";
            html+="<tr>";
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
            html+="                             Situação";
            html+="                            </th>";
            html+="                             <th align='center' style=' text-align: center'>";
            html+="                             Ação";
            html+="                            </th>";
            
            html+="                        </tr>";
            html+="                    </thead>";
            html+="                    <tbody >";
            for(i=0;i<arrCarregar.data.length;i++){
                html+="<tr>";
                    
                html+='<th  style="  text-align: center">';
                html+= arrCarregar.data[i]['dt_hora_ponto'];
                html+='</th>';
                html+='<th  style="  text-align: center">';
                html+= arrCarregar.data[i]['dia_da_semana'];
                html+='</th>';
                if(arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento']!=0){
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ini']==1){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'];
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'];
                        html+='</th>';
                    }
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ini_int']==3){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'];
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'];
                        html+='</th>';
                    }
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_fim_int']==4){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'];
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'];
                        html+='</th>';
                    }
                    
                    if(arrCarregar.data[i]['pontos_dia'][0]['tipo_ponto_pk']==1 && arrCarregar.data[i]['pontos_dia'][0]['ic_apontamento_ter']==2){
                        html+='<th  style="  text-align: center;background-color:#ADD8E6">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'];
                        html+='</th>';
                    }
                    else{
                        html+='<th  style="  text-align: center">';
                        html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'];
                        html+='</th>';
                    }

                    html+='<th  style="  text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['situacao'];
                    html+='</th>'
                    
                }
                else{
                    html+='<th  style="  text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_expediente'];
                    html+='</th>';
                    html+='<th  style=" text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_ini_intervalo'];
                    html+='</th>';
                    html+='<th  style=" text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_intervalo'];
                    html+='</th>';
                    html+='<th  style="  text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['ponto_term_expediente'];
                    html+='</th>';
                    html+='<th  style="  text-align: center">';
                    html+= arrCarregar.data[i]['pontos_dia'][0]['situacao'];
                    html+='</th>'
                    
                }

                ;
                
                //if(arrCarregar.data[i]['pontos_dia'][0]['situacao']=="Escala"){
                    html+='<th  style="  text-align: center">';
                    html += '<a class="nav-link" href="javascript:fcAbrirApontamentoOperacionalControlePonto(' + $('#colaborador_consulta_folha_pk').val() + ', \'' + arrCarregar.data[i]['dt_hora_ponto'].toString() + '\')">';
                    html+= '            <i class="bi bi-hand-index-thumb" style="font-size:20px; color:blue"></i>';
                    html+= '        </a>';
                    html+='</th>';
                //}
                //else{
                  //  html+='<th  style="  text-align: center">';
                    //html+= "";
                    //html+='</th>';
                //}
                
                
                
                html+='</tr>';
            }
                            
            html+='</tbody>';
            html+=' </table>';
            html+=' </div>';
            html+='</div>';
        }
        else{
            html+='<h1 class="pulsing-text">Este colaborador não tem registros!</h1>';
        }
        
    }
    
    $("#grid_consulta_folha_ponto").html(html);

}
function fcCarregarLeadsConsultaFolha() {
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    
    carregarComboAjax($("#leads_consulta_folha_pk"), arrCarregar, " ", "pk", "ds_lead");

}
//FUNÇÃO PARA FUNCIONAR O RELOAD DO APONTAMENTO
function fcCarregarCalendario(){
}
$(document).ready(function () {

    //CONTROLE DE PERMISSÃO DA PAGINA
    /*var arrCarregar = permissao("lead", "cons");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false, 'Você não tem permissão para acessar essa pagina!');
        setTimeout(function() {
            sendPost('menu','principal',{})
        }, 2000);
        return false;
    }*/
    fcCarregarGrupoLeads();
    fcCarregarLeads();
    $('#grupos_leads_pk').change(function () {
        fcCarregarLeads();
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



});
