var tblDocumentos;
var tblResultado;
function fcVisibilidadeSolicitacoes(){
    $("#solicitar_correcao").hide()
    $("#solicitar_recusa").hide()
    $("#solicitar_aprovacao").hide()
    $("#gestor").hide()
    switch ($('#ic_status').val()) {
        case '2':
            $("#solicitar_aprovacao").show()
            $("#gestor").show()
            break;
        case '3':
            $("#solicitar_aprovacao").show()
            break;
        case '5':
            $("#solicitar_recusa").show()
            break;
        case '4':
            $("#solicitar_correcao").show()
            break;
        case '6':
            $("#solicitar_correcao").show()
            break;
    }
}

function fcCarregar(){

    var objParametros = {
        "pk": pk

    };

    var arrCarregar = carregarController("analise_financeira", "listarPk", objParametros);

        $("#lancamento_pk").html(arrCarregar.data[0]['lancamento_pk'])
        $("#dt_cadastro").html(arrCarregar.data[0]['dt_cadastro'])
        $("#ds_usuario").html(arrCarregar.data[0]['ds_usuario'])
        $("#ds_operacao").html(arrCarregar.data[0]['ds_operacao'])
        $("#ds_metodo_pagamento").html(arrCarregar.data[0]['ds_metodo_pagamento'])
        $("#ds_empresas").html(arrCarregar.data[0]['ds_razao_social'])
        $("#ds_conta_bancaria").html(arrCarregar.data[0]['ds_conta_bancaria'])
        $("#ds_lancamento").html(arrCarregar.data[0]['ds_lancamento'])
        $("#ds_tipo_grupo").html(arrCarregar.data[0]['ds_tipo_grupo'])
        $("#ds_lead").html(arrCarregar.data[0]['ds_recebido_de'])
        $("#ds_grupo_lancamento_centro_custo").html(arrCarregar.data[0]['ds_grupo_lancamento_centro_custo'])
        $("#ds_leads_clientes").html(arrCarregar.data[0]['ds_leads_clientes'])
        $("#vl_lancamento").html(arrCarregar.data[0]['vl_lancamento'])
        $("#dt_vencimento").html(arrCarregar.data[0]['dt_vencimento'])
        $("#ds_tipo_operacao").html(arrCarregar.data[0]['ds_tipo_operacao'])
        $("#ds_contrato").html(arrCarregar.data[0]['ds_lancamento_contrato'])
        $("#ds_posto_trabalho").html(arrCarregar.data[0]['ds_lancamento_posto_trabalho'])
        $("#ds_cliente").html(arrCarregar.data[0]['ds_recebido_de_centro_custo'])
        $("#ds_banco").html(arrCarregar.data[0]['ds_banco'])
        $("#ds_agencia").html(arrCarregar.data[0]['ds_agencia'])
        $("#ds_conta").html(arrCarregar.data[0]['ds_conta'])
        $("#parcela_pk").html(arrCarregar.data[0]['parcela_pk'])
        $("#ds_pix").html(arrCarregar.data[0]['ds_pix'])
        $("#obs").html(arrCarregar.data[0]['obs'])

        fcCarregarGridDocumentos(arrCarregar.data[0]['lancamento_pk'])
       
}

function fcCarregarGestor() {
    var objParametros = {
        "pk": ""
    };

    var arrCarregar = carregarController("usuario", "listarTodosGestores", objParametros);
    carregarComboAjax($("#gestores_pk"), arrCarregar, " ", "pk", "ds_usuario");
}

function fcCarregarGridDocumentos(lancamento_pk) {
    var objParametros = {
        "lancamentos_pk": lancamento_pk
    };

    var v_url = montarUrlController("documento", "listarDocumentosLancamentos", objParametros);
    //Trata a tabela
    tblDocumentos = $('#tblDocumentos').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "paging": false,
        "ordering": false,
        "searching": false,
        "info": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>"
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
}

function fcCarregarGrid() {
    var objParametros = {
        "analise_financeira_pk": pk
    };

    var v_url = montarUrlController("analise_financeira_processos", "historicoAnaliseFinanceira", objParametros);
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "paging": false,
        "ordering": false,
        "info": false,
        "columnDefs": [
            { "targets": -1, "data": "t_obs"},
            { "targets": -2, "data": "t_ds_usuario_cadastro" },
            { "targets": -3, "data": "t_dt_cadastro" },
            { "targets": -4, "data": "t_ic_status" },
            { "targets": -5, "data": "t_pk" }

        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });
}

function fcSalvar(){

    switch($("#ic_status").val()){
        case '2': 
            var obs_aprovacao = $("#obs_aprovacao").val();
            var ic_aprovacao = $("#ic_status").val();
            var gestor_aprovacao_pk = $("#gestores_pk").val();
            var analise_financeira_pk = pk;
            
            var objParametros = {
                "obs_aprovacao": obs_aprovacao,
                "ic_aprovacao": (ic_aprovacao),
                "analise_financeira_pk": (analise_financeira_pk),
                "gestor_aprovacao_pk": (gestor_aprovacao_pk)
            };  
        break;
        case '3':
            var obs_aprovacao = $("#obs_aprovacao").val();
            var ic_aprovacao = $("#ic_status").val();
            var analise_financeira_pk = pk;
            
            var objParametros = {
                "obs_aprovacao": obs_aprovacao,
                "ic_aprovacao": (ic_aprovacao),
                "analise_financeira_pk": (analise_financeira_pk)
            };  
        break;
        case '4':
            var obs_correcao = $("#obs_correcao").val();
            var ic_correcao = $("#ic_status").val();
            var analise_financeira_pk = pk;
            
            var objParametros = {
                "obs_correcao": (obs_correcao),
                "ic_correcao": (ic_correcao),
                "analise_financeira_pk": (analise_financeira_pk)
            };  
        break;
        case '5':
            var obs_recusa = $("#obs_recusa").val();
            var ic_recusa = $("#ic_status").val();
            var analise_financeira_pk = pk;
            
            var objParametros = {
                "obs_recusa": (obs_recusa),
                "ic_recusa": (ic_recusa),
                "analise_financeira_pk": (analise_financeira_pk)
            };  
        break;
        case '6':
            var obs_correcao = $("#obs_correcao").val();
            var ic_correcao = $("#ic_status").val();
            var analise_financeira_pk = pk;
            
            var objParametros = {
                "obs_correcao": (obs_correcao),
                "ic_correcao": (ic_correcao),
                "analise_financeira_pk": (analise_financeira_pk)
            };  
        break;
    }
    
    var arrEnviar = carregarController("analise_financeira_processos", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        sendPost("analise_financeira_res_form.php", {token: token});
    }else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcListarSutatus(){

    var arrCarregar = carregarController("usuario", "listarGruposUsuario", "");

    var ds_drupo =  arrCarregar.data[0]['ds_grupo'];

    
    var html = "";
    html += "<option value=''></option>";
    if(ds_drupo == "Analista Financeiro"){
        html += "<option value='2'>Aprovado Analista</option>";
    }else if(ds_drupo == "Controller"){
        html += "<option value='3'>Aprovado Gestor</option>";
    }
    html += "<option value='4'>Correção Solicitada</option>";
    html += "<option value='5'>Recusado</option>";
    //html += "<option value='6'>Correção Feita</option>";
    $("#ic_status").html(html)
    
    
}


function fcCancelar() {
    sendPost('analise_financeira_res_form.php', { token: token, pk: '' });
}

function fcDownloadDocumento(ds_documento) {
    var arrCarregar = permissao("documento", "ins");

    if (arrCarregar.result != 'success') {
        alert('Falhar ao carregar o registro');
        return false;
    }
    var v_url = "../docs/" + ds_documento;
    window.open(v_url, '_blank');
}

$(document).ready(function () {
    $(document).on('change', '#ic_status', fcVisibilidadeSolicitacoes);
    $(document).on('click', '#cmdIncluirAnalise', fcSalvar);
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $("#solicitar_correcao").hide()
    $("#solicitar_recusa").hide()
    $("#solicitar_aprovacao").hide()
    $("#gestor").hide()

    fcListarSutatus(); 
    fcCarregarGestor();
    //fcCarregarGridDocumentos();
    fcCarregarGrid();
    fcCarregar();
})