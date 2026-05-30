function fcValidarForm() {
    $("#dt_periodo_fim").change(function () {
        var dt_periodo_ini = $("#dt_periodo_ini").datepicker("getDate");
        var dt_periodo_fim = $("#dt_periodo_fim").datepicker("getDate");
        qtd_dias = (dt_periodo_fim - dt_periodo_ini) / (1000 * 60 * 60 * 24);
        qtd_dias = qtd_dias | 0;
        if(qtd_dias > 31){
            alert("Informe um período com até 31 dias")
            return false;
        }
        
    });

    $("#form").validate({
        rules: {
            dt_periodo_ini: {
                required: true
            },
            dt_periodo_fim: {
                required: true
            }

        },
        messages: {
            dt_periodo_ini: {
                required: "Por favor, informe DT período inicial!"
            },
            dt_periodo_fim: {
                required: "Por favor, informe DT período fim!"
            }
        },
        submitHandler: function (form) {
            
            fcEnviar(); //Se a validação deu certo, faz o envio do formulario.
            return false;
            
        }
    });
}
function fcEnviar() {
    //verifica se foi selecionado    
    var data = tblResultado.rows().data();

    var v_marcador_pk = [];
    for (i = 0; i < data.length; i++) {//calcula o valor total    
       
        if ($("#colaborador_pk_" + i).prop("checked") == true) {
            v_marcador_pk[i] = $("#colaborador_pk_" + i).val()+"|"+$("#agenda_coloborador_padrao_pk" + i).val();
        }
        
    }

    var v_dt_periodo_ini = $("#dt_periodo_ini").val();
    var v_dt_periodo_fim = $("#dt_periodo_fim").val();
    var v_leads_pk = $("#leads_pk").val();
    var v_empresas_pk = $("#empresas_pk").val();
    var v_obs = $("#obs").val();
    var v_array_colaboradores = v_marcador_pk;


    var objParametros = {
        "pk": pk,
        "dt_periodo_ini": (v_dt_periodo_ini),
        "dt_periodo_fim": (v_dt_periodo_fim),
        "leads_pk": (v_leads_pk),
        "empresas_pk": (v_empresas_pk),
        "arrColaborador": v_marcador_pk,
        "obs": (v_obs)
    };

    var arrEnviar = carregarController("ponto_folha", "salvar", objParametros);
    //NewWindow(v_last_url)
    
    if (arrEnviar.result == 'success') {
        // Reload datable
        alert(arrEnviar.message);
        sendPost("ponto_folha_res_form.php", { token: token });
    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar() {
    sendPost("ponto_folha_res_form.php", { token: token });
}

function fcCarregar() {
    if (pk > 0) {

        var objParametros = {
            "pk": pk
        };

        var arrCarregar = carregarController("ponto_folha", "listarPk", objParametros);

        if (arrCarregar.result == 'success') {
            $("#dt_periodo_ini").val(arrCarregar.data[0]['dt_periodo_ini']);
            $("#dt_periodo_fim").val(arrCarregar.data[0]['dt_periodo_fim']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#obs_cancelamento").val(arrCarregar.data[0]['obs_cancelamento']);

        }
        else {
            alert('Falhar ao carregar o registro');
        }
    }
}
//Grid
function fcPesquisar() {

    if ($("#empresas_pk").val() == "") {
        alert('Selecione a Empresa!');
        return false;
    }

    if ($("#leads_pk").val() == "") {
        alert('Selecione o Posto de Trabalho!');
        return false;
    }
    tblResultado.clear();
    fcCarregarGrid();
}

function fcCarregarGrid() {
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val(),
        "leads_pk": $("#leads_pk").val(),
        "ic_escala": $("#ic_escala").val()
    };

    var arrCarregar = carregarController("colaborador", "listarColaboradorFolha", objParametros);

    if (arrCarregar.result == 'success') {
        for (i = 0; i < arrCarregar.data.length; i++) {

            tblResultado.row.add(
                ["<input type='checkbox' id='colaborador_pk_" + i + "' value='" + arrCarregar.data[i]['colaborador_pk'] + "'><input type='hidden' id='agenda_coloborador_padrao_pk"+i+"' value='" + arrCarregar.data[i]['agenda_coloborador_padrao_pk'] + "'>",
                arrCarregar.data[i]['ds_colaborador'],
                arrCarregar.data[i]['ds_status_colaborador'],
                arrCarregar.data[i]['ds_produto_servico'],
                arrCarregar.data[i]['dt_escala'],
                arrCarregar.data[i]['ds_escala'],
                arrCarregar.data[i]['ds_hr_escala'],
                arrCarregar.data[i]['ds_status_escala'],
                arrCarregar.data[i]['dt_cancelamento']
                ]
            ).draw(false);
        }
    }
}


function fcAddLinha(v_li) {


}

//combos
function fcComboEmpresas() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("conta", "listarPk", objParametros);

    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcCarregarLeads() {
    //Carrega os grupos    
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val()
    };
    var arrCarregar = carregarController("lead", "listarLeadsPorEmpresa", objParametros);
    //NewWindow(v_last_url)
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fcMarcarTodos() {

    var data = tblResultado.rows().data();

    if (data.length == 0) {
        alert('Pesquise antes para listar os colaboradores dos postos de trabalho!');
        return false;
    }


    for (i = 0; i < data.length; i++) {//calcula o valor total

        $("#colaborador_pk_" + i).prop("checked", true);

    }

}

function fcFormatarGrid() {
    tblResultado = $("#tblResultado").DataTable({
        "scrollX": false,
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
            orderable: false,
            targets: [1, 2, 3, 4, 5, 6, 7, 8]
        }],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
    return false;

}

$(document).ready(function () {
    //Combo e mascaras

    fcComboEmpresas();
    fcCarregarLeads();

    $(".chzn-select").chosen({ allow_single_deselect: true });

    $("#empresas_pk").change(function () {
        $(".chzn-select").chosen('destroy');
        fcCarregarLeads();
        $(".chzn-select").chosen({ allow_single_deselect: true });

    });

    $('#dt_periodo_ini').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_periodo_ini").keypress(function () {
        mascara(this, mdata);
    });

    $('#dt_periodo_fim').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_periodo_fim").keypress(function () {
        mascara(this, mdata);
    });

    fcFormatarGrid()

    $(document).on('click', '#cmdPesquisarDadosFolha', fcPesquisar);

    $(document).on('click', '#cmdMarcarTodos', fcMarcarTodos);


    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);

    //Atribui a validação do formulário dos campos obrigatórios
    fcValidarForm();

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar();    
    
});
