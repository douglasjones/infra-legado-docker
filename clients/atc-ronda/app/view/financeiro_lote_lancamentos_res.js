function fcCarregarComboUsuarios() {
    var objParametros = {

    };
    var arrCarregar = carregarController("usuario", "listarTodosSemAdm", objParametros);
    carregarComboAjax($("#usuario_cadastro_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcCarregar() {
    var objParametros = {
        "usuario_cadastro_pk": $('#usuario_cadastro_pk').val(),
        "dt_cadastro": $('#dt_cadastro').val(),
        "ic_status": $('#ic_status').val()
    };     
    
    var v_url = montarUrlController("financeiro_import_lancamentos", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "ordering": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR'></i></span></a>&nbsp;&nbsp;<a class='function_copy'><span><i class='bi bi-clipboard' style='font-size:18px; color:black' title='COPIAR'></i></span></a>"
            },           
            {"targets": -2, "data": "t_ic_status"},
            {"targets": -3, "data": "t_dt_cadastro"},
            {"targets": -4, "data": "t_ds_usuario_cadstro"},
            {"targets": -5, "data": "t_ds_identificacao_lote"},
            {"targets": -6, "data": "t_pk"},

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
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
        fcEditar(data['t_pk']);
        
    } );    
    
    $('#tblResultado tbody').on('click', '.function_copy', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcCopiar(data['t_pk']);
        
    } );       
}

function fcVoltar() {
    sendPost('menu_financeiro.php', { token: token });
}

function fcImportar() {  
    sendPost('financeiro_import_lote_lancamento_cad.php', { token: token, copia_pk: '' });
}

function fcCopiar(copia_pk) {  
    window.location.reload();
    var objParametros = {
        "copia_pk": copia_pk
    }
    var arrEnviar = carregarController("financeiro_import_lancamento_itens", "copiar", objParametros);
    window.open("financeiro_lote_lancamentos_cad.php?token="+token+"&financeiro_import_lancamentos_pk="+arrEnviar.data[0]['financeiro_import_lancamentos_pk']+"&copia_pk="+copia_pk, 
    "Cadastro Em Lote","width="+screen.availWidth+",height="+screen.availHeight+",top=0,left=0,resizable=no,scrollbars=yes,status=no");
}

function fcEditar(financeiro_import_lancamentos_pk){
    window.location.reload();
    window.open("financeiro_lote_lancamentos_cad.php?token="+token+"&financeiro_import_lancamentos_pk="+financeiro_import_lancamentos_pk+"&copia_pk=", 
    "Cadastro Em Lote","width="+screen.availWidth+",height="+screen.availHeight+",top=0,left=0,resizable=no,scrollbars=yes,status=no");

}

$(document).ready(function () {
    fcCarregar();
    fcCarregarComboUsuarios();

    $('#dt_cadastro').datepicker({
        defaultDate: "",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();
    $("#dt_cadastro").keypress(function () {
        mascara(this, mdata);
    });

    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdImportar', fcImportar);
})


