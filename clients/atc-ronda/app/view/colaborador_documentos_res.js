function fcCarregarGridDocumentos(){
    var objParametros = {
        "colaboradores_pk": colaborador_pk
    };

    var v_url = montarUrlController("documento", "listarDocumentosColaborador", objParametros);

    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><i class='bi bi-x-circle' style='font-size:18px; color:black' title='EXCLUIR'></i></span></a>"
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
        fcDownloadDocumento(data['t_ds_documento']);
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
        else{
            fcExcluirArquivo(data['t_ds_documento']);
            tblDocumentos.row($(this).parents('tr')).remove().draw();
        }
    });
}

function fcDownloadDocumento(ds_documento){
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk,v_ds_documento){
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

function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    //alert(1);


    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    }
    else{
        if(colaborador_pk == ""){
            if($("#acao").val() == "ins"){
                var dsDocumento = "";
                var dsNomeOriginal = "";
                $('#tblArquivos tbody tr').each(function () {
                var colunas = $(this).children();
                    var colunas = $(this).children();
                    dsDocumento = $(colunas[0]).text();
                    dsNomeOriginal = $(colunas[1]).text();
                    fcIncluirDocumentoSemPk(dsDocumento,dsNomeOriginal);
                });
                $("#janela_documentos").modal("hide");
            }
        }
        else{
            fcEnviarDocumento(colaborador_pk);
        }

    }

}

function fcIncluirDocumentoSemPk(v_documento,v_nome_original){
    tblDocumentos.row.add(
        {
            "t_pk":"",
            "t_ds_documento":v_documento,
            "t_ds_obs":$("#ds_obs_doc").val(),
            "t_ds_nome_original":v_nome_original,
            "t_functions":""
        }
    ).draw();

    return false;
}
function fcEnviarDocumento(v_pk){

    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();

    var objParametros = {
        "colaboradores_pk": v_pk,
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };


    var arrEnviar = carregarController("documento", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        //alert(arrEnviar.message);
        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCarregarGridArquivos(){
    tblArquivos = $("#tblArquivos").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs" : [{
                orderable: false,
                targets: [0,1,2]
            }],
            "language":{
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
                }
        }
    );
    return false;
}

$(document).ready(function(){
    
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
     fcCarregarGridDocumentos();
     fcCarregarGridArquivos();
    //Atribui os eventos dos demais controles
    
});