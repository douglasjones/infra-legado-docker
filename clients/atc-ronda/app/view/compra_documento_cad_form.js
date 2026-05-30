//COMEÇO DOCUMENTOS UPLOAD
function fcAlterarNomeArquivo(v_arquivo){
    var objParametros = {
        "compras_pk": $("#compras_pk").val(),
        "ds_arquivo": v_arquivo
    };

    var arrEnviar = carregarController("documento", "renomearArquivoColaborador", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").text(arrEnviar.data[0]['t_ds_nome_salvo']);
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcAbrirFormNovoDocumento(){
    tblArquivos.clear().destroy();
    fcCarregarGridArquivos();
    fcLimparDadosDocumento();
    $("#acao").val("ins");
    $("#janela_documentos").modal();
}

function fcLimparDadosDocumento(){
    $("#ds_obs_doc").val("");
    $("#acao").val("");
}

function fcFormatarDadosDocumentos(){
    try{
       var pk = "";
       var ds_documento = "";
       var ds_obs =  "";
       var ds_nome_original = "";
       
       var arrKeys = [];
       var arrDados = [];
       arrKeys[0] = "pk";
       arrKeys[1] = "ds_documento";
       arrKeys[2] = "ds_obs";
       arrKeys[3] = "ds_nome_original";
       
       var  data = tblDocumentos.rows().data();
       
       for(i = 0; i< data.length; i++){
           if(data[i]['t_pk']==""){
               
               
               pk = data[i]['t_pk'];
               ds_documento = data[i]['t_ds_documento'];
               ds_obs =  data[i]['t_ds_obs'];
               ds_nome_original = data[i]['t_ds_nome_original'];
               
               arrDados[i] = [pk, ds_documento, ds_obs, ds_nome_original]; 
           }
                                  
       }
       return arrayToJson(arrKeys, arrDados);
   }
   catch(err) {
       alert(err);
   } 
}

function fcFormatarDadosArquivos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() != "Nenhum registro encontrado"){
        var dsDocumento = "";
        var dsNomeOriginal = "";

        var arrKeys = [];
        arrKeys[0] = "ds_documento";
        arrKeys[1] = "ds_nome_original";

        var arrDados = [];
            var i = 0;
            $('#tblArquivos tbody tr').each(function () {
            var colunas = $(this).children();
                dsDocumento =  $(colunas[0]).text();
                dsNomeOriginal = $(colunas[1]).text();


                arrDados[i] = [dsDocumento, dsNomeOriginal];

                i++;
            });

        return arrayToJson(arrKeys, arrDados);
    }
}

function fcApagarArquivo(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });

    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento(){
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
            var colunas = $(this).children();
            nome_arquivo = $(colunas[0]).text();
            fcExcluirArquivo(nome_arquivo);
        });
}

function fcExcluirArquivo(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };

    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);
}

function fcIncluirLinhaArquivo(nome_original){
    tblArquivos.row.add(
            [$("#ds_documento").text(),
             nome_original,
             "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivo);
    return false;
}

function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}

$(function () {

    $('#fileupload').fileupload({

        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);

            $.each(data.files, function (index, file) {

                $("#ds_nome_original").text(file.name);

                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css('width', progress + '%');
        }
    });
});

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcCarregarGridArquivos(){
    tblArquivos = $("#tblArquivos").DataTable({
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
    });
    return false;
}

function fcDownloadDocumento(ds_documento){
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcValidarDocumentos(){
    try {
        var colunas = $('#tblArquivos tbody tr td');
        if ($(colunas[0]).text() == "Nenhum registro encontrado"){
            $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_documento").slideUp(500);
            });
        }else{
            if($("#compras_pk").val() > 0){
                fcEnviarDocumento($("#compras_pk").val());
            }else{
                var dsDocumento = "";
                var dsNomeOriginal = "";
                $('#tblArquivos tbody tr').each(function () {
                    var colunas = $(this).children();
                    dsDocumento = $(colunas[0]).text();
                    dsNomeOriginal = $(colunas[1]).text();
                });
                fcIncluirDocumentoSemPk(dsDocumento, dsNomeOriginal)
                $("#janela_documentos").modal("hide");
            }
    
        }
    } catch (error) {
        alert(error)
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
        "compras_pk": v_pk,
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