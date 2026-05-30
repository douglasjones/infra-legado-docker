var tblResultado;
function fcPesquisar() {

    tblResultado.clear().destroy();
    fcCarregarGrid();

}
function fcVoltar(){
    sendPost("menu_rh.php", {token: token});
}

function fcIncluir() {

    sendPost('colaborador_cad_form.php', { token: token, colaborador_pk: '' });

}

function fcExcluir(v_pk, v_ds_colaborador) {

    if (confirm("Deseja realmente excluir o registro '" + v_ds_colaborador + "'?")) {
        if (v_pk != "") {

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("colaborador", "excluir", objParametros);

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
}

function fcEditar(v_pk) {
    sendPost('colaborador_cad_form.php', { token: token, colaborador_pk: v_pk });
}

function fcImpressao(v_pk) {
    sendPost('colaborador_print_form.php', { token: token, colaborador_pk: v_pk });
}

function fcCarregarGrid() {
    var ic_reserva = "";
    if ($('#ic_reserva').is(":checked")) {
        ic_reserva = 1;
    }
    var objParametros = {
        "pk": $("#colaborador_pk").val(),
        "ic_status": $("#ic_status").val(),
        "leads_pk": $("#leads_pk").val(),
        "ic_origem": $("#ic_origem").val(),
        "ds_pin": $("#ds_pin").val(),
        "ds_cpf": $("#ds_cpf").val(),
        "generos_pk": $("#generos_pk").val(),
        "ds_re": $("#ds_re").val(),
        "ic_status_app": $("#ic_status_app").val(),
        "ic_reserva": ic_reserva,
        "produtos_servicos_pk": $("#ds_produto_servico").val()
    };

    var v_url = montarUrlController("colaborador", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "searching": true,
        "paging":true,
        "serverSide": true,
        "iDisplayLength":10,
        "pageLength":10,
        "oLanguage": {
            "sLengthMenu": "Mostrar _MENU_ registros por página",
            "sZeroRecords": "Nenhum registro encontrado",
            "sInfo": "Mostrando _START_ até _END_ de _TOTAL_ registro(s)",
            "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
            "sInfoFiltered": "",
            "sSearch": "Pesquisar: ",
            "oPaginate": {
                "sFirst": "Início",
                "sPrevious": "Anterior",
                "sNext": "Próximo",
                "sLast": "Último"
            }
        },
        "ajax": { "url": v_url, "type": "POST", "datatype":"json" },
        "responsive": true,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit'><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR O LEAD'></i></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><i class='bi bi-whatsapp'></i></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_print'><span><i class='bi bi-printer' title='Abrir Formulario para impressao'> </i></span></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_opcoes'><i class='bi bi-blockquote-left' title='Formulários Colaborador'></i></a>\n\
                                    &nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR O LEAD'></i></span></a>"
        },
        { "targets": -2, "data": "t_ds_funcao" },
        { "targets": -3, "data": "t_ds_cel2" },
        { "targets": -4, "data": "t_ic_status" },
        { "targets": -5, "data": "t_ic_origem" },
        { "targets": -6, "data": "ds_status_app" },
        { "targets": -7, "data": "t_ds_cel" },
        { "targets": -8, "data": "t_ds_re" },
        { "targets": -9, "data": "t_ds_pin" },
        { "targets": -10, "data": "t_ds_colaborador" },
        { "targets": -11, "data": "ds_lead" },
        { "targets": -12, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
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
        fcEditar(data['t_pk']);

    });
    $('#tblResultado tbody').on('click', '.function_print', function () {
        var data;
        
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcImpressao(data['t_pk']);
    });

    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_colaborador']);
    });

    $('#tblResultado tbody').on('click', '.function_painel', function () {
        var data;

        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }
        if (data['t_ic_whatsapp'] == "Sim") {
            fcAbrirMensagemWhatsAppTel(data);
        }


    });
    $('#tblResultado tbody').on('click', '.function_opcoes', function () {
        var data;

        if (tblResultado.row($(this).parents('li')).data()) {
            data = tblResultado.row($(this).parents('li')).data();
        }
        else if (tblResultado.row($(this).parents('tr')).data()) {
            data = tblResultado.row($(this).parents('tr')).data();
        }

        fcAbrirGridForulario(data['t_pk']);



    });

}

function fcAbrirGridForulario(pk) {
    sendPost('formulario_contrato_colaborador_res_form.php', { token: token, colaborador_pk: pk });
}
function fcAbrirGridForulario(pk) {
    sendPost('formulario_contrato_colaborador_res_form.php', { token: token, colaborador_pk: pk });
}
function fcAbrirMensagemWhatsAppTel(objRegistro) {
    var str = objRegistro['t_ds_cel'];
    var telefone = str.replace(/[^\d]+/g, '');
    var url = "https://api.whatsapp.com/send?phone=55" + telefone + "&text=Olá"

    window.open(url, '_blank');
}

function fcCarregarGenero() {
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("genero", "listarTodos", objParametros);
    carregarComboAjax($("#generos_pk"), arrCarregar, " ", "pk", "ds_genero");

}

function fcCarregarQualificacao() {
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);
   // NewWindow(v_last_url);
    carregarComboAjax($("#ds_produto_servico"), arrCarregar, " ", "pk", "ds_produto_servico");
    //alert(1);
}

function fcCarregarLeads() {
    //Carrega os grupos

    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros);
    
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "leads_pk", "ds_lead");

}

function fcCarregarColaborador() {
    //Carrega os grupos
    
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");

}

$(document).ready(function () {
    $("#leads_pk").change(function () {
        
        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });
    //faz a carga inicial do grid.
    fcCarregarGenero();

    fcCarregarLeads();
    fcCarregarColaborador();
    fcCarregarQualificacao();
    
    $(".chzn-select").chosen({ allow_single_deselect: true });
    
    
    $("#ds_cpf").keypress(function(){
       chama_mascara(this);
    });
    
    fcCarregarGrid();

    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir); 
    $(document).on('click', '#cmdVoltar', fcVoltar); 
    
    
});
