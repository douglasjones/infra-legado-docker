
function fcDownloadDocumento(ds_documento) {
    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    var v_url = "../docs/" + ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumento(v_pk, v_ds_documento) {

    /*var objParametros = {
        "ds_dominio_modulo": "exclusao_anexos_financeiro",
        "ic_acao": "del"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    if (arrCarregar.result != 'success') {
        alert("Você não tem Permissão");
        return false;
    }*/



    var arrCarregar = permissao("financeiro_documento", "del");

    if (arrCarregar.result != 'success') {
        alert('Você não tem permissão para exclusão!');
        return false;
    }

    var objParametros = {
        "pk": v_pk
    };

    var arrExcluir = carregarController("documento", "excluir", objParametros);

    if (arrExcluir.result == 'success') {

        //Exibe a mensagem
        alert(arrExcluir.message);
        fcExcluirArquivo(v_ds_documento);
        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    }
    else {
        alert('Falhou a requisição de exclusão.');
    }
  
}

function fcValidarDocumentos() {
    var colunas = $('#tblArquivos tbody tr td');
    if ($(colunas[0]).text() == "Nenhum registro encontrado") {
        $("#alert_documento").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert_documento").slideUp(500);
        });
    }
    else {
        fcEnviarDocumento();
    }

}
function fcEnviarDocumento() {
    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    var strJSONDadosTabela = fcFormatarDadosArquivos();
    var v_ds_obs = $("#ds_obs_doc").val();

    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val(),
        "ds_arquivo": strJSONDadosTabela,
        "ds_obs": v_ds_obs
    };


    var arrEnviar = carregarController("documento", "salvar", objParametros);

    if (arrEnviar.result == 'success') {
        // Reload datable
        $("#janela_documentos").modal("hide");
        alert(arrEnviar.message);
        tblDocumentos.clear().destroy();
        fcCarregarGridDocumentos();
    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }

}

function fcCarregarGridArquivos() {
    tblArquivos = $("#tblArquivos").DataTable(
        {
            "searching": false,
            "paging": false,
            "columnDefs": [{
                orderable: false,
                targets: [0, 1, 2]
            }],
            "language": {
                "url": "../inc/js/datatables/pt_br.php",
                "type": "GET"
            }
        }
    );
    return false;
}
//COMEÇO DOCUMENTOS UPLOAD

function fcAlterarNomeArquivo(v_arquivo) {

    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val(),
        "ds_arquivo": v_arquivo
    };


    var arrEnviar = carregarController("documento", "renomearArquivoLancamento", objParametros);

    if (arrEnviar.result == 'success') {
        // Reload datable
        $("#ds_documento").text(arrEnviar.data[0]['t_ds_nome_salvo']);

    }
    else {
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcApagarArquivo() {
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });

    tblArquivos.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumento() {
    var nome_arquivo = "";
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivo(nome_arquivo);
    });
}


function fcExcluirArquivo(v_nome_arquivo) {

    var objParametros = {
        "ds_dominio_modulo": "exclusao_anexos_financeiro",
        "ic_acao": "del"
    };

    var arrCarregar = permissaoAtualizada("usuario", "verificarPermissao", objParametros);

    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };


    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);

    if (arrEnviar.result == 'success') {

    }
}
function fcIncluirLinhaArquivo(nome_original) {
    tblArquivos.row.add(
        [$("#ds_documento").text(),
            nome_original,
            "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        ]
    ).draw(false);

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click", fcApagarArquivo);
    return false;
}


function ResetDoc() {
    $('#progressDoc .progress-bar').css('width', '0%');
}
$(function () {

    $('#fileuploadDoc').fileupload({

        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('ResetDoc()', 2000);

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

function fsCleanDoc() {
    $('#progressDoc .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivos() {

    var dsDocumento = "";
    var dsNomeOriginal = "";

    var arrKeys = [];
    arrKeys[0] = "ds_documento";
    arrKeys[1] = "ds_nome_original";

    var arrDados = [];
    var i = 0;
    $('#tblArquivos tbody tr').each(function () {
        var colunas = $(this).children();
        dsDocumento = $(colunas[0]).text();
        dsNomeOriginal = $(colunas[1]).text();


        arrDados[i] = [dsDocumento, dsNomeOriginal];
        i++;
    });

    return arrayToJson(arrKeys, arrDados);

}

function fcAbrirFormNovoDocumento() {

    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }

    tblArquivos.clear().destroy();

    fcCarregarGridArquivos();

    $("#janela_documentos").modal();
    $("#ds_obs_doc").val("");
}

function fcCarregarGridDocumentos() {
    var objParametros = {
        "lancamentos_pk": $("#lancamentos_pk").val()
    };

    var v_url = montarUrlController("documento", "listarDocumentosLancamentos", objParametros);
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "bDeferRender": true,
        //"bProcessing"    : true,
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        },
        { "targets": -2, "data": "t_ds_nome_original" },
        { "targets": -3, "data": "t_ds_obs" },
        { "targets": -4, "data": "t_ds_documento" },
        { "targets": -5, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_edit', function () {
        var data;

        if (tblDocumentos.row($(this).parents('li')).data()) {
            data = tblDocumentos.row($(this).parents('li')).data();
        }
        else if (tblDocumentos.row($(this).parents('tr')).data()) {
            data = tblDocumentos.row($(this).parents('tr')).data();
        }

        if (data['t_pk'] != "") {
            fcDownloadDocumento(data['t_ds_documento']);
        }
    });
    $('#tblDocumentos tbody').on('click', '.function_delete', function () {
        var data;

        if (tblDocumentos.row($(this).parents('li')).data()) {
            data = tblDocumentos.row($(this).parents('li')).data();
        }
        else if (tblDocumentos.row($(this).parents('tr')).data()) {
            data = tblDocumentos.row($(this).parents('tr')).data();
        }

        if (data['t_pk'] != "") {
            fcExcluirDocumento(data['t_pk'], data['t_ds_documento']);
        }
    });
}



function fcAnexarDocumento(pk) {

    $("#janela_docs").modal();

    $("#lancamentos_pk").val(pk);
    tblDocumentos.clear().destroy();

    fcCarregarGridDocumentos();
}

$(document).ready(function () {
    
    fcCarregarGridArquivos();
    fcCarregarGridDocumentos();
    $(document).on('click', '#cmdEnviarDocumento', fcValidarDocumentos);
    $(document).on('click', '#cmdIncluirDocumento', fcAbrirFormNovoDocumento);
});

