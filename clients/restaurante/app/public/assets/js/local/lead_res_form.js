var pesquisa = 1;
var tblResultado;
function fcCarregarGridLeads() {
    //tblResultado.clear().destroy();
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "grupos_leads_pk": $("#grupos_leads_pk").val(),
        "supervisores_pk": $("#supervisores_pk").val(),
        "ic_status": $("#ic_status").val()

    };
    var v_url = routes_api("lead", "listarDataTable", objParametros);
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
                    return full['ds_grupo_leads'];
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
                    return full['ds_supervisor'];
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
                width: '60px'

            },
            {
                mRender: function (data, type, full) {
                    var buttonPainel = '<a class="function_painel"><span><i class="bi bi-card-list" style="font-size=18px;color:blue" title="Painel"></i></span></a> &nbsp;&nbsp;';
                    var buttonDelete = '<a class="function_delete"><span><i class="bi bi-trash3" style="font-size=18px;color:blue" title="excluir"></i></span></a> &nbsp;&nbsp;';
                    var buttonOc = '<a class="function_oc"><span><i class="bi bi-list-task" style="font-size=18px;color:blue" title="ocorrencia"></i></span></a> &nbsp;&nbsp;';
                    var buttonQrCode = '<a class="function_qr_code"><span><i class="bi bi-qr-code" style="font-size=18px;color:blue" title="QrCode"></i></span></a> ';


                    return buttonPainel + buttonDelete + buttonQrCode;
                },
                'orderable': false,
                'searchable': false,
                width: '60px'
            }
        ]

    });
    //Atribui os eventos na coluna ação.

    $('#tblResultado tbody').on('click', '.function_painel', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirPainel(data['pk']);
    });
    $('#tblResultado tbody').on('click', '.function_oc', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirOcorrencia(data['pk']);
    });

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['pk'], data['ds_lead']);
    });

    $('#tblResultado tbody').on('click', '.function_qr_code', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcAbrirQrCode(data['pk'], data['ds_lead']);
    });


}


function fcAbrirQrCode(leads_pk, ds_lead) {
    var objParametros = {
        "ds_lead":ds_lead,
        "pk":leads_pk,
        "local":$("#local").val()
    };
    sendPost('lead','qrCode' ,objParametros);
}

function fcCarregarLeads() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);

    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");

}


function fcCarregarGrupoLeads() {
    //Carrega os grupos

    var objParametros = {
    };

    var arrCarregar = carregarController("conta", "listarTodos", objParametros);

    carregarComboAjax($("#grupos_leads_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcCarregarSupervisor(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarSupervisor", objParametros);
    carregarComboAjax($("#supervisores_pk"), arrCarregar, " ", "pk", "ds_usuario");
}
function fcAbrirPainel(v_pk) {
    var arrCarregar = permissao("lead", "cons");
    if (arrCarregar.status != true) {
        utilsJS.toastNotify(false, "Você não tem permissão");
        return false;
    }
    var objParametros = {
        "pk":v_pk,
        "local":$("#local").val()
    };
    sendPost('lead','cadForm' ,objParametros);

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

            var arrExcluir = carregarController("lead", "excluir", objParametros);

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

function fcPesquisarLead() {
    tblResultado.clear().destroy();
    fcCarregarGridLeads();
}

function fcIncluirLead() {
    sendPost('lead','cadForm',{"local":$("#local").val(),"pk":""})
}


function fcVoltarLead(){
    if($("#local").val()==1){
        sendPost("menu", "comercial",{});
    }
    else{
        sendPost("menu", "operacional",{});
    }
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
    fcCarregarSupervisor();

    $('#abrir').addClass('');
    $("#bt_titulo_ab_padrao").show();


    $(".chzn-select").chosen({ allow_single_deselect: true });


    fcCarregarGridLeads();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisarLead', fcPesquisarLead);
    $(document).on('click', '#cmdIncluirLead', fcIncluirLead);
    $(document).on('click', '#cmdVoltarLead', fcVoltarLead);


    $('#abrir').addClass('');
    $("#bt_titulo_ab_padrao").show();


});
