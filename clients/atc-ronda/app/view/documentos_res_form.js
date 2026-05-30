function fcCarregarGridDocumentos(){
    var objParametros = {
        "leads_pk": leads_pk
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosLead", objParametros);
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bDeferRender"   : true,
        "orderable": false,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            {"targets": -2, "data": "t_ds_nome_original"},
            {"targets": -3, "data": "t_ds_obs"},
            {"targets": -4, "data": "t_ds_documento"},
            {"targets": -5, "data": "t_pk"}

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcDownloadDocumento(data['t_ds_documento']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentos.row( $(this).parents('li') ).data()){
            data = tblDocumentos.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentos.row( $(this).parents('tr') ).data()){
            data = tblDocumentos.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumento(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumento(ds_documento){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }

    var v_url = "../docs/"+ds_documento;
    NewWindow(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){
    var arrCarregar = permissao("documento", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivo(v_ds_documento);
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcAbrirFormNovoDocumento(){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    tblArquivos.clear().destroy(); 
    fcCarregarGridArquivos();
    $("#janela_documentos").modal();
    $("#ds_obs_doc").val("");
}

function fcCarregarInfoDocumentos(){
    if(leads_pk > 0){
        var objParametros = {
            "pk": leads_pk
        }; 
        var arrCarregar = carregarController("lead", "listarPk", objParametros);
        
        $("#ds_lead_titulo_documentos").html("<b>"+arrCarregar.data[0]['ds_lead']+"</b>");
        $("#id_lead_documentos").html("Cód Lead: "+arrCarregar.data[0]['pk']);
        $("#dt_cadastro_lead_documentos").html("Dt de Cad: "+arrCarregar.data[0]['dt_cadastro']);
        $("#dt_ult_atualizacao_lead_documentos").html("Dt Utl atualização: "+arrCarregar.data[0]['dt_ult_atualizacao']);
        $("#ds_usuario_cadastro_documentos").html("Usuário de Cad: "+arrCarregar.data[0]['ds_usuario_cadastro']);
    }
}

$(document).ready(function(){
            
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);

    //carrega dados da grid de documentos
    fcCarregarGridDocumentos();
    fcCarregarInfoDocumentos();
});