var tblResultado;
function fcPesquisar(){
	
    tblResultado.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluir(){
    //alert(leads_pk);
    sendPost('proposta_selecao_form.php',{token: token, pk: '', ic_versao: '', ic_abertura: 2, leads_pk: leads_pk});
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
        "leads_pk": leads_pk
    };     
    
    var v_url = montarUrlController("propostas_facilities", "listarDataTablePk", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": true,
            "ajax": { "url": v_url, "type": "POST" },
            "ordering": false,
            "responsive": true,
            "searching": true,
            "paging": true,
            "bFilter": true,
            "bInfo": true,
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



function fcCarregarInfoComercial(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_comercial").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_comercial").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_comercial").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_comercial").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_comercial").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}



$(document).ready(function(){
    //faz a carga inicial do grid.
    fcCarregarInfoComercial();
    fcCarregarGrid();
    //Atribui os eventos dos demais controles
    //$(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#cmdIncluir', fcIncluir);
    $(document).on('click', '#cmdVoltar', fcVoltar);
    
});


