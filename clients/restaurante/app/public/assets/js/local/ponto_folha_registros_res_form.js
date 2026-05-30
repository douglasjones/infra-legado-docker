var tblResultado;

function fcEditar(v_pk,v_colaborador_pk){
    var v_leads_pk = $("#leads_pk").val();

    var objParametros = {
        'leads_pk': v_leads_pk,
        'colaborador_pk': v_colaborador_pk,
        'pk': v_pk
    };
    sendPost('ponto_folha','registrosCad',objParametros)
}

function fcExcluir(ponto_folha_pk,colaborador_pk){
    var arrCarregar = permissao("ponto_folha_registros", "del");

    if (arrCarregar.status != true){
        utilsJS.toastNotify(false, 'Você não tem permissão para acessar essa pagina!');
        setTimeout(function() {
            sendPost('menu','principal',{})
        }, 2000);
        return false;
    }

    if (confirm("Deseja realmente excluir o registro?")){
        if(ponto_folha_pk != ""){

            var objParametros = {
                "ponto_folha_pk": ponto_folha_pk,
                "colaborador_pk":colaborador_pk
            };              
            
            var arrExcluir = carregarController("ponto_folha", "excluirFolhaColaborador", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}

function fcCarregarGrid(){
    let pk = $('#pk').val();

    var objParametros = {
        "ponto_folha_pk": pk
    };     
    
    var v_url = routes_api("ponto_folha", "listarPontoFolhaPK", objParametros);
    tblResultado = $('#tblResultado').DataTable({
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
                    return "<input type=checkbox name='checks[]' value='1'>";
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['colaborador_pk'];
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
                    return full['dt_ult_atualizacao'];
                },
                'orderable': true,
                'searchable': false,
                width: '80px'

            },
            {
                mRender: function (data, type, full) {
                    return full['ic_status'];
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
                    var buttonPainel = '<a class="function_edit"><span><i class="bi bi-pencil-square" style="font-size=18px;color:blue" title="Editar"></i></span></a> ';
                    var buttonDelete = '<a class="function_delete"><span><i class="bi bi-x-circle" style="font-size=18px;color:blue" title="Excluir"></i></span></a> ';
                    var buttonPrint = '<a class="function_print"><i class="bi bi-printer" style="font-size:18px;color:blue" title="Abrir Formulário para impressao"></i></a> ';
                
                    return buttonPainel + buttonDelete + buttonPrint;
                },
                'orderable': false,
                'searchable': false,
                width: '80px'
            }
        ]

    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblResultado tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcEditar(data['ponto_folha_pk'],data['colaborador_pk']);
        
    } );   

    $('#tblResultado tbody').on('click', '.function_print', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcPrintFolha(data['colaborador_pk']);
    } );  
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['ponto_folha_pk'],data['colaborador_pk']);
    } );        
    
}

function fcCarregar(){
    let pk = $('#pk').val();
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("ponto_folha", "listarFolhasRegistros", objParametros);
  
        if (arrCarregar.status == true){
            
            $("#ds_empresa").html(arrCarregar.data[0]['ds_conta']);
            $("#ds_lead").html(arrCarregar.data[0]['ds_lead']);
            $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
            $("#dt_periodo_ini").html(arrCarregar.data[0]['dt_periodo_ini']);
            $("#dt_periodo_fim").html(arrCarregar.data[0]['dt_periodo_fim']);
            $("#obs").val(arrCarregar.data[0]['obs']); 
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fcCancelar(){
    var objParametros = {};
    sendPost('ponto_folha','receptivoPontoFolha',objParametros)
}


function fcPrintFolha(v_colaborador_pk){
    var v_pk = $("#pk").val();

    var v_leads_pk = $("#leads_pk").val();
    
    var objParametros = {
        "leads_pk":v_leads_pk,
        "pk":v_pk,
        "colaborador_pk":v_colaborador_pk
    };
    sendPost('ponto_folha','receptivoPrint',objParametros)
    
}

function fcGerarPlanilhaExcel(){
    var v_leads_pk = $("#leads_pk").val();
    sendPost('ponto_folha_planilha_form.php', {token: token, pk: pk, leads_pk: v_leads_pk});
}


$(document).ready(function(){
    fcCarregar();

    //faz a carga inicial do grid.
    fcCarregarGrid();
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdVoltar', fcCancelar);

    $("#cmdPrintAll").click(function(){
        fcPrintFolha(null);
    });

    
    $('#tblResultado tbody').on('click', "input[name='checks[]']", function () { 
        $(this).parents("tr").toggleClass('selected');
    });
    

    $('#dt_ini_periodo').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_ini_periodo").keypress(function () {
        mascara(this, mdata);
    });  

    $('#dt_fim_periodo').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    });
    $("#dt_fim_periodo").keypress(function () {
        mascara(this, mdata);
    });   
    
    $(document).on('click', '#cmdEnviar', fcValidarForm);
    $(document).on('click', '#cmdRegerarFolha', fcAbrirRegerar);
    $(document).on('click', '#cmdFechar', fcFecharModalRegerar);
    $(document).on('click', '#cmdFecharRegerar2', fcFecharModalRegerar);
});


