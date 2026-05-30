function fcPesquisar() {
    tblEscala.clear().destroy();
    fcCarregarGridEscala();
}
function fcCarregarGridEscala(){

    var objParametros = {
        "leads_pk":$("#leads_pk_pesq_agenda").val(),
        "colaborador_pk":$("#colaborador_pk_pesq_agenda").val(),
        "tipo_escala_pk":$("#tipo_escala_pk").val(),
        "produtos_servicos_pk":$("#produtos_pesq_agenda").val(),
    };

    var v_url = routes_api("agenda_colaborador_padrao", "listarEscala", objParametros);

    //Trata a tabela
    tblEscala = $('#tblEscala').DataTable({
        searching: true,
        paging: true,
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
                    return full['pk'];
                },
                'orderable': true,
                'searchable': false

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_colaborador'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_lead'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_funcao'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    return full['dt_inicio_agenda']+" - "+full['dt_fim_agenda'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    return full['ds_escala'];
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    if(full['dt_cancelamento']==null){
                        return "Ativa";
                    }
                    else{
                        return "Cancelada";
                    }
                },
                'orderable': true,
                'searchable': false,

            },
            {
                mRender: function (data, type, full) {
                    var buttonPainel = '<a class="function_edit"><span><i class="fa fa-edit" style="font-size=18px;color:blue" title="editar"></i></span></a> ';
                    var buttonDelete = '<a class="function_delete"><span><i class="fa fa-trash-alt" style="font-size=18px;color:blue" title="excluir"></i></span></a> ';


                    return buttonPainel + buttonDelete;
                },
                'orderable': false,
                'searchable': false,
            }
        ]
    });
    //Atribui os eventos na coluna ação.
    $('#tblEscala tbody').on('click', '.function_edit', function () {
        var data;
        rLinhaSelecionada = null;
        if (tblEscala.row($(this).parents('li')).data()) {
            data = tblEscala.row($(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if (tblEscala.row($(this).parents('tr')).data()) {
            data = tblEscala.row($(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditar(data['pk']);
    });

    $('#tblEscala tbody').on('click', '.function_delete', function () {
        var data;
        if (tblEscala.row($(this).parents('li')).data()) {
            data = tblEscala.row($(this).parents('li')).data();
        }
        else if (tblEscala.row($(this).parents('tr')).data()) {
            data = tblEscala.row($(this).parents('tr')).data();
        }

        if (data['pk'] != "") {
            fcExcluirEscala(data['pk']);
        }
        tblEscala.row($(this).parents('tr')).remove().draw();
    });

    return false;
}

function  fcExcluirEscala(v_pk){
    utilsJS.jqueryConfirm('Excluir?', 'Deseja excluir o registro '+v_pk+'?', function () {
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("agenda_colaborador_padrao", "excluir", objParametros);

            if (arrExcluir.status == true){
                utilsJS.toastNotify(true,arrExcluir.message)

                // Reload datable
                tblEscala.ajax.reload();

            }else{

                utilsJS.toastNotify(false, 'Falhou a requisição de exclusão ');
            }
        }
        else{
            utilsJS.toastNotify(false, 'Código não encontrado');
        }
    });
}
function fcRecarregarGridEscala(){
    tblEscala.clear().destroy();
    fcCarregarGridEscala();
}

function fcCarregarColaboradorByFuncaoPk() {
    //Carrega os grupos

    var objParametros = {
        "produtos_servicos":$("#produtos_pesq_agenda").val()
    };

    var arrCarregar = carregarController("colaborador", "listarTodosByFuncaoPk", objParametros);
    carregarComboAjax($("#colaborador_pk_pesq_agenda"), arrCarregar, " ", "pk", "ds_colaborador");

}
function fcCarregarTipoEscala() {
    //Carrega os grupos
    var objParametros = {
    };

    var arrCarregar = carregarController("tipo_escala", "listarTodos", objParametros);
    carregarComboAjax($("#tipo_escala_pk"), arrCarregar, " ", "pk", "ds_tipo_escala");
}
function fcCarregarFuncao(){

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("servico", "listarTodos", objParametros);
    carregarComboAjax($("#produtos_pesq_agenda"), arrCarregar, " ", "pk", "ds_produto_servico");

}

function fcCarregarLead() {
    //Carrega os grupos

    var objParametros = {

    };

    var arrCarregar = carregarController("lead", "listarTodos", objParametros);
    carregarComboAjax($("#leads_pk_pesq_agenda"), arrCarregar, " ", "pk", "ds_lead");

}

function fcIncluir(){
    var objParametros = {
        "pk":"",
        "local":$("#local").val()
    };
    sendPost('agenda_colaborador_padrao','cadFormEscala',objParametros)

}
function fcCancelar(){

    sendPost('menu','operacional',{})

}
function fcEditar(pk){
    var objParametros = {
        "pk":pk
    };
    sendPost('agenda_colaborador_padrao','cadFormEscala',objParametros)

}
$(document).ready(function(){
    //ESCALA
    fcCarregarFuncao();
    fcCarregarLead();
    fcCarregarGridEscala();
    fcCarregarColaboradorByFuncaoPk();
    $("#produtos_pesq_agenda").change(function(){
        fcCarregarColaboradorByFuncaoPk();
    });

    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdCancelar', fcCancelar);


    $(".chzn-select").chosen({width: "100%"});
    fcCarregarTipoEscala();


});