
var tblResultado;
var pesquisa = 1;
function fcCarregarGridLeads() {

    //tblResultado.clear().destroy();
    var objParametros = {
        "cod_lead": $("#cod_lead").val(),
        "ds_lead": $("#leads_pk").val(),
        "ic_cliente": $("#ic_status").val(),
        "supervisores_pk": $("#supervisores_pk").val(),
        "ic_tipo_lead": $("#ic_tipo_lead").val(),
        "responsavel_pk": $("#responsavel_pk").val(),
        "leads_pai_pk": $("#leads_clientes_pk").val(),
        "leads_clientes_pk": $("#leads_clientes_pk").val()

    };
    var v_url = montarUrlController("lead", "listarDataTable", objParametros);

    //Trata a tabela
    if(ic_abertura == 1){

        tblResultado = $('#tblResultado').DataTable({
            "scrollX": false,
            "ajax": { "url": v_url, "type": "POST" },
            "responsive": true,
            "ordering": false,
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_painel'><span><i class='bi bi-card-list' style='font-size:18px; color:black' title='PAINEL PRINCIPAL LEAD' ></i></span></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR O LEAD'></i></span></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class=''><span><i class='bi bi-list-task' style='font-size:18px; color:black' title='OCORRÊNCIAS DO LEAD'></i></span></a>\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_agenda'><span><i class='bi bi-calendar2-date' style='font-size:18px; color:black' title='AGENDA DO LEAD'></i></span></a>\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_qr_code'><span><i class='bi bi-qr-code style='font-size:18px; color:black' title=' QR CODE ACESSO APP PONTO'></i></span></a>\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR O LEAD'></i></span></a>\n\
                                    "
            },
            {"targets": -2, "data": "t_ic_cliente"},
            { "targets": -3, "data": "t_ds_cidade" },
            //{"targets": -3, "data": "t_ds_bairro"},
            { "targets": -4, "data": "t_ds_lead" },
            { "targets": -5, "data": "ds_tipo_lead" },

            { "targets": -6, "data": "t_pk" }

            ],
            "language": {
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        });

    }else if(ic_abertura == 2){
     
        tblResultado = $('#tblResultado').DataTable({
            "scrollX": false,
            "ajax": { "url": v_url, "type": "POST" },
            "responsive": true,
            "ordering": false,
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_selecionar_lead'><input type='checkbox' name='checkbox[]' ></input></a>"
            },
            {"targets": -2, "data": "t_ic_cliente"},
            { "targets": -3, "data": "t_ds_cidade" },
            { "targets": -4, "data": "t_ds_lead" },
            { "targets": -5, "data": "ds_tipo_lead" },
            { "targets": -6, "data": "t_pk" }

            ],
            "language": {
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        });
    }

    //Atribui os eventos na coluna ação.

    $('#tblResultado tbody').on('click', '.function_painel', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirPainel(data['t_pk']);
    });

    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcEditar(data['t_pk']);

    });

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_lead']);
    });

    $('#tblResultado tbody').on('click', '.function_qr_code', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirQrCode(data['t_pk'], data['t_ds_lead']);
    });

    $('#tblResultado tbody').on('click', '.function_agenda', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirFormAgenda();
    });
   
}

function fcSelecionarLeads() {
    try {
        var data;
        data = tblResultado.rows('.selected').data();
        var leads = [];
        for (var i = 0; i < data.length; i++) {
            leads[i] = data[i]['t_pk'];  
        }
    
        var json_leads = JSON.stringify(leads);
        var objParametros = {
            "modulos_pk": json_leads
        }
        var arrEnviar = carregarController("comercial", "salvarProcessoMovimentacaoPesquisa", objParametros);
        if (arrEnviar.result == 'success'){
            // Reload datable
            alert(arrEnviar.message);
            fcFecharModalLead();
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }
  
    } catch (error) {
        alert(error)
    }
}

function fcAbrirQrCode(leads_pk, ds_lead) {
    sendPost('qrcode_form.php', { token: token, pk: leads_pk, ds_lead: ds_lead });
}

function fcAbrirPainel(v_pk) {
    var arrCarregar = permissao("lead", "cons");
    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('lead_main_form.php', { token: token, leads_pk: v_pk, ic_abertura: 1});
}

function fcEditar(v_pk) {
    var arrCarregar = permissao("lead", "upd");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }   
    sendPost('lead_cad_form.php', { token: token, leads_pk: v_pk, ic_processo_comercial: 2,processo_default_configuracao_pk: ''});
}


function fcExcluir(v_pk, v_ds_lead) {
    var arrCarregar = permissao("lead", "del");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    if (confirm("Deseja realmente excluir o registro '" + v_ds_lead + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("lead", "excluir", objParametros);

            if (arrExcluir.result == 'success') {

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else {
                alert('Falhou a requisição de exclusão.');
            }
        }
        else {
            alert("Código não encontrado");
        }
    }
    return false;
}

function fcPesquisarLead() {
    
    tblResultado.clear().destroy();
    fcCarregarGridLeads();  
}

function fcIncluirLead() {
    sendPost('lead_cad_form.php', { token: token, leads_pk: '', ic_processo_comercial: 2, processo_default_configuracao_pk: ''});
}

/*
function fcCarregarLeads1() {
    var arrCarregar = carregarController("lead", "listarTodos", "");
    carregarComboAjax($("#ds_lead"), arrCarregar, " ", "pk", "ds_lead");
}
*/


function fcVoltarLead(){
    sendPost("menu_comercial.php", {token: token});
}

function fcAbreModalLead(){

    $('#abrir').modal({backdrop: '', keyboard: false});
}

function fcFecharModalLead(){    
    $('#abrir').hide();
    fcAtualizaComercialPainel();
}

function fcCarregarClientes() {
    //Carrega os grupos
    var objParametros = {
        "ic_tipo_lead": 1,
        "ic_cliente": $("#ic_status").val()
    };

    var arrCarregar = carregarController("lead", "listarTodosClientes", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_clientes_pk"), arrCarregar, " ", "pk", "ds_lead");

}


function fcCarregarLeads() {
    //Carrega os grupos
    
    var objParametros = {
        "ic_tipo_lead": 2, 
        "leads_pai_pk": $("#leads_clientes_pk").val(),
        "ic_cliente": $("#ic_status").val()
    };

    var arrCarregar = carregarController("lead", "listarTodosPostTrabalho", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}



$(document).ready(function () {
    //CONTROLE DE PERMISSÃO DA PAGINA

    var arrCarregar = permissao("lead", "cons");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    //CONTROLE DE ABERTURA DA PAGINA
   
   // fcCarregarLeads1();
    //Atribui os eventos dos demais controles
    

    
    //fcCarregarComboUsuario();
    if(ic_abertura==1){
        //ABRE NO CORPO DO SISTEMA
       $('#abrir').addClass('');
       $("#bt_titulo_ab_padrao").show();       
       $("#bt_titulo_ab_modal").hide();
    }else{
        //ABRE COMO POP-UP
        $('#abrir').addClass('modal fade');
        $("#bt_titulo_ab_padrao").hide();       
        $("#bt_titulo_ab_modal").show();
    }

    fcCarregarLeads();
    fcCarregarClientes();

    $(".chzn-select").chosen({ allow_single_deselect: true });
    $("#ic_status").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarClientes();
        fcCarregarLeads();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });
    $("#leads_clientes_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeads();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });


    fcCarregarGridLeads();
    $('#tblResultado tbody').on('click', "input[name='checkbox[]']", function () { 
        $(this).parents("tr").toggleClass('selected');
   });

   $(document).on('click', '#cmdPesquisarLead', fcPesquisarLead);
   $(document).on('click', '#cmdIncluirLead', fcIncluirLead);   
   $(document).on('click', '#cmdVoltarLead', fcVoltarLead);
   $(document).on('click', '#cmdFecharModalLead', fcFecharModalLead);
   $(document).on('click', '#cmdSalvarModalLead', fcSelecionarLeads);

});
