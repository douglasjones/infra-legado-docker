
function fcValidarDocumentos(){
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado"){
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_documento").slideUp(500);
        });
    } 
    else{
        fcEnviarDocumento();
    }
    
}
function fcEnviarDocumento(){ 
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var strJSONDadosTabela =  fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();
    var v_ic_tipo_documento = $("#ic_tipo_documento").val();
    
    var objParametros = {
        "leads_pk": leads_pk,
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs,
        "ic_tipo_documento": v_ic_tipo_documento
    };       
    
    
    var arrEnviar = carregarController("documento", "salvar", objParametros);  
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
        tblDocumentos.clear().destroy();    
        fcCarregarGridDocumentos();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCarregarGridArquivos(){
    try {
        
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
    } catch (error) {
        alert(error)
    }
}
//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo){    
    
    var objParametros = {
        "leads_pk": leads_pk,
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);           
   
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento").text(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
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
    if (arrEnviar.result == 'success'){
        
    }
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
                
                $("#ds_nome_original").html(file.name);
                
                fcAlterarNomeArquivo(file.name);
                fcIncluirLinhaArquivo(file.name);
                
            });
        },
        fail: function (data) {
            alert("Falha ao subir o arquivo");
        },            
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progressOc .progress-bar').css('width', progress + '%');
        }
    });
});

function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos(){

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


$(document).ready(function(){
    $(document).on('click', '#cmdCancelarDocumento', fcCancelarEnvioDocumento);
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);

    fcCarregarGridArquivos();

});