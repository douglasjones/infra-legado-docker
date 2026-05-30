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
    
    if($('#dt_periodo_ini').val()==""){
        $("#alert_dt_periodo_ini").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_periodo_ini").slideUp(500);
        });
        $('#dt_periodo_ini').focus();
        return false;
    }
    if($('#dt_periodo_fim').val()==""){
        $("#alert_dt_periodo_fim").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_periodo_fim").slideUp(500);
        });
        $('#dt_periodo_fim').focus();
        return false;
    }

    fcEnviar();
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

    var objParametros = {
        "dt_periodo_ini": (v_dt_periodo_ini),
        "dt_periodo_fim": (v_dt_periodo_fim),
        "leads_pk": (v_leads_pk),
        "empresas_pk": (v_empresas_pk),
        "arrColaborador": v_marcador_pk,
        "obs": (v_obs)
    };

    var arrEnviar = carregarController("ponto_folha", "salvar", objParametros);
    if (arrEnviar.status == true){
        // Reload datable
        utilsJS.toastNotify(true, arrEnviar.message);
       // sendPost('ponto_folha','receptivoPontoFolha' ,objParametros);
    }
    else{
        utilsJS.toastNotify(false,'Falhou a requisição para salvar o registro');
    }

}

//combos
function fcCarregarEmpresas() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("conta", "listarPk", objParametros);
    carregarComboAjax($("#empresas_pk"), arrCarregar, " ", "pk", "ds_conta");
}

function fcCarregarLeads() {
    var objParametros = {
        "empresas_pk": $("#empresas_pk").val()
    };
    var arrCarregar = carregarController("lead", "listarLeadsPorEmpresa", objParametros);
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fcCarregarGridColaborador() {
    try {
        var objParametros = {
            "empresas_pk": $("#empresas_pk").val(),
            "leads_pk": $("#leads_pk").val(),
            "ic_escala": $("#ic_escala").val()
        };
    
        var arrCarregar = carregarController("colaborador", "listarColaboradorFolha", objParametros);
        //Trata a tabela           
    
        if (arrCarregar.status == true) {
            for (i = 0; i < arrCarregar.data.length; i++) {
    
                tblResultado.row.add(
                    ["<input type='checkbox' id='colaborador_pk_" + i + "' value='" + arrCarregar.data[i]['colaborador_pk'] + "'><input type='hidden' id='agenda_coloborador_padrao_pk"+i+"' value='" + arrCarregar.data[i]['agenda_colaborador_padrao_pk'] + "'>",
                        arrCarregar.data[i]['ds_colaborador'],
                        arrCarregar.data[i]['ds_status_colaborador'],
                        arrCarregar.data[i]['ds_produto_servico'],
                        arrCarregar.data[i]['dt_ini_escala']+' - '+arrCarregar.data[i]['dt_fim_escala'],
                        arrCarregar.data[i]['n_qtde_dias_semana'],
                        arrCarregar.data[i]['hr_inicio_expediente'] +' - '+ arrCarregar.data[i]['hr_termino_expediente'],
                        arrCarregar.data[i]['ds_status_escala'],
                        arrCarregar.data[i]['dt_cancelamento']
                    ]
                ).draw(false);
            }
        }
    } catch (error) {
        console.log(error)
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

function fcPesquisar() {
    try {

        if ($("#empresas_pk").val() == "") {
            alert('Selecione a Empresa!');
            return false;
        }

        if ($("#leads_pk").val() == "") {
            alert('Selecione o Posto de Trabalho!');
            return false;
        }
        tblResultado.clear();
        fcCarregarGridColaborador();
    } catch (error) {
        console.log(error) 
    }
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

function fcCancelar() {
    var objParametros = {};
    sendPost('ponto_folha','receptivoPontoFolha',objParametros)
}

$(document).ready(function(){
    //Combo e mascaras
    fcCarregarEmpresas();
    $('#empresas_pk').select2();
    
    $("#empresas_pk").change(function(){
        fcCarregarLeads();
        $('#leads_pk').select2();
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


    fcFormatarGrid(); 

    //Atribui os eventos
    $(document).on('click', '#cmdPesquisarDadosFolha', fcPesquisar);
    $(document).on('click', '#cmdMarcarTodos', fcMarcarTodos);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdEnviarContato', fcValidarForm);

    //Atribui a validação do formulário dos campos obrigatórios
    //fcValidarForm();

});
