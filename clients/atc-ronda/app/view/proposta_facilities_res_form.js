var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){
    sendPost('proposta_selecao_form.php',{token: token, pk: '', ic_versao: '', ic_abertura: 1});
}

function fcExcluir(v_pk){

    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("propostas_facilities", "excluir", objParametros);   

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

function fcEditar(v_pk){
    sendPost('proposta_detalhada_cad_form.php', {token: token, pk: v_pk, ic_versao: ''});
}

function fcNovaVersao(v_pk){
    sendPost('proposta_detalhada_cad_form.php', {token: token, pk: v_pk, ic_versao: 1});
}

function fcCarregarGrid(){
try {
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "ic_status": $("#ic_status").val(),
        "usuario_cadastro_pk": $("#usuario_cadastro_pk").val(),
        "usuario_responsavel_comercial_pk": $("#usuario_responsavel_comercial_pk").val(),
        "dt_cadastro": $("#dt_cadastro").val()
    };     
    
    var v_url = montarUrlController("propostas_facilities", "listarDataTable", objParametros);

    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_NovaVersao'><span><i class='bi bi-files' style='font-size:18px; color:black' title='NOVA VERSÃO'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_edit'><span><i class='bi bi-pencil-square' style='font-size:18px; color:black' title='EDITAR'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR'></i></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_impressao'><span><i class='bi bi-printer' style='font-size:18px; color:black' title='IMPRIMIR PROPOSTA'></i></span></a>"
            },           
            {"targets": -2, "data": "t_vl_total_proposta"},
            {"targets": -3, "data": "t_dt_fechamento"},
            {"targets": -4, "data": "t_ds_usuario_responsavel_comercial"},
            {"targets": -5, "data": "t_ds_usuario_cadastro"},
            {"targets": -6, "data": "t_ds_status"},
            {"targets": -7, "data": "t_ds_leads"},
            {"targets": -7, "data": "t_ds_leads"},
            {"targets": -8, "data": "t_proposta_facilities_pai_pk"},
            {"targets": -9, "data": "t_ds_versao"},
            {"targets": -10, "data": "t_pk"},

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
    
    $('#tblResultado tbody').on('click', '.function_NovaVersao', function () {
        var data;
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
        }
        fcNovaVersao(data['t_pk']);
        
    } );   
    
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcExcluir(data['t_pk'], data['t_ds_usuario']);
    } );    

    $('#tblResultado tbody').on('click', '.function_impressao', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcImpressao(data['t_pk']);
    } );    
} catch (error) {
    alert(error)
}
    
}

function fcImpressao(pk){
    sendPost("proposta_facilities_impressao.php", {token: token, pk: pk});
}

function fcVoltar(){
    sendPost("menu_comercial.php", {token: token});
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarLeadsCombo", objParametros);   
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");  
}

function fcCarregarUsuarios(){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("usuario", "listarTodosSemAdm", objParametros);   
    carregarComboAjax($("#usuario_cadastro_pk"), arrCarregar, " ", "pk", "ds_usuario");  
}

function fcCarregarUsuariosResponsaveisComerciais(){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("usuario", "listarTodosSemAdm", objParametros);   
    carregarComboAjax($("#usuario_responsavel_comercial_pk"), arrCarregar, " ", "pk", "ds_usuario");  
}

$(document).ready(function(){

    $('#dt_cadastro').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked"
    }).datepicker(); 
    $("#dt_cadastro").keypress(function(){
        mascara(this,mdata);
    });
    

    //faz a carga inicial do grid.
    fcCarregarGrid();
    fcCarregarLeads();
    fcCarregarUsuarios();
    fcCarregarUsuariosResponsaveisComerciais();
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdVoltar', fcVoltar);

});


