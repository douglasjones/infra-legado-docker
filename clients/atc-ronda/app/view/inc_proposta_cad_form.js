var tblPropostas;
var tblPropostaItens;
var tblPropostaItensImprimir;
var proposta_contrato_pk = "";

function fcCarregarCategorias() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("categoria_produto", "listarTodos", objParametros);
    carregarComboAjax($("#categorias_produto_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fcCarregarProdutos(categorias_produto_pk) {

    var objParametros = {
        "categorias_produto_pk": categorias_produto_pk
    };
    var arrCarregar = carregarController("produto", "listarPorCategoria", objParametros);

    carregarComboAjax($("#produtos_pk"), arrCarregar, " ", "pk", "ds_produto");
}

function fcAtualizarDadosGridProdutoItens() {

    var objParametros = {
        "pk": $("#propostas_pk").val()
    };

    var v_url = montarUrlController("proposta", "listarProdutosItens", objParametros);
    //Trata a tabela
    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        "scrollX": false,
        "ajax": { "url": v_url, "type": "POST" },
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        },
        { "targets": -2, "data": "vl_total_produto" },
        { "targets": -3, "data": "vl_item_produto" },
        { "targets": -4, "data": "n_qtde_item" },
        { "targets": -5, "data": "ds_produto" },
        { "targets": -6, "data": "produtos_pk", visible: false },
        { "targets": -7, "data": "ds_categoria" },
        { "targets": -8, "data": "categorias_produto_pk", visible: false }
        ],
        "language": {
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
        }
    });

    $('#tblPrdutosItens tbody').on('click', '.function_delete', function () {

        var data;

        if (tblPrdutosItens.row($(this).parents('li')).data()) {
            data = tblPrdutosItens.row($(this).parents('li')).data();
        } else if (tblPrdutosItens.row($(this).parents('tr')).data()) {
            data = tblPrdutosItens.row($(this).parents('tr')).data();
        }

        tblPrdutosItens.row($(this).parents('tr')).remove().draw();
    });

    fcCalcularVlProduto(1);
}

function fcIncluirProdutoIten() {

    tblPrdutosItens.row.add(
        {
            "pk": "",
            "categorias_produto_pk": $("#categorias_produto_pk option:selected").val(),
            "ds_categoria": $("#categorias_produto_pk option:selected").text().substring(0, 15),
            "produtos_pk": $("#produtos_pk option:selected").val(),
            "ds_produto": $("#produtos_pk option:selected").text().substring(0, 15),
            "n_qtde_item": $("#n_qtde_item").val(),
            "vl_item_produto": $("#vl_item_produto").val(),
            "vl_total_produto": parseInt($("#n_qtde_item").val()) * moeda2float($("#vl_item_produto").val()),

            "t_functions": ""
        }
    ).draw();
    $("#categorias_produto_pk").val("");
    $("#produtos_pk").val("");
    $("#n_qtde_item").val("");
    $("#vl_item_produto").val("");
}

function fcImprimir(){
    //get the modal box content and load it into the printable div
    $(".printable").html($("#janela_impressao").html());
    $(".printable #btnImprimirModal").remove();
    $(".printable").printThis();
}

function fcCarregarGridProposta(){   
    var objParametros = {
        "leads_pk": leads_pk,
        "processos_default_pk": processos_default_pk,
        "processos_pk":pk
    }; 
    
    var v_url = montarUrlController("proposta", "listarPropostaLeadProcesso", objParametros);

    //Trata a tabela
    tblPropostas = $('#tblPropostas').DataTable({
        "scrollX": true,
        
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' title='Editar Proposta'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel' title='Imprimir Proposta'><span><img width=16 height=16 src='../img/impressora.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete' title='Excluir Proposta'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            {"targets": -2, "data": "t_vl_total"}, 
            {"targets": -3, "data": "t_dt_fechamento"}, 
            {"targets": -4, "data": "t_dt_previsao_fechamento"},
            {"targets": -5, "data": "t_dt_envio"},
            {"targets": -6, "data": "t_dt_validade"},
            {"targets": -7, "data": "t_dt_cad"},
            {"targets": -8, "data": "t_ds_responsavel"},  
            {"targets": -9, "data": "t_n_versao"},
            {"targets": -10, "data": "t_pk"}

            ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    //Atribui os eventos na coluna ação.
    $('#tblPropostas tbody').on('click', '.function_edit', function () {
        var data;        
        rLinhaSelecionada = null;        
        if(tblPropostas.row( $(this).parents('li')).data()){
            data = tblPropostas.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblPropostas.row( $(this).parents('tr')).data()){
            data = tblPropostas.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarProposta(data);  
        
    } );   
    
    $('#tblPropostas tbody').on('click', '.function_delete', function () {
        
        var data;        
        if(tblPropostas.row( $(this).parents('li') ).data()){
            data = tblPropostas.row( $(this).parents('li') ).data();
        }
        else if(tblPropostas.row( $(this).parents('tr') ).data()){
            data = tblPropostas.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirProposta(data['t_pk']);
        }
    } );   

    $('#tblPropostas tbody').on('click', '.function_painel', function () {
        
        var data;        
        if(tblPropostas.row( $(this).parents('li') ).data()){
            data = tblPropostas.row( $(this).parents('li') ).data();
        }
        else if(tblPropostas.row( $(this).parents('tr') ).data()){
            data = tblPropostas.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcImprimirProposta(data['t_pk']);
        }
    } );     
    return false;
    
}

function fcImprimirProposta(proposta_pk){
    sendPost("impressao_proposta_res_form.php", {token: token, proposta_pk: proposta_pk, processos_default_pk: processos_default_pk, processos_pk: pk});
}

function fcDataHoje(){
    // Obtém a data/hora atual
    var data = new Date();

    // Guarda cada pedaço em uma variável
    var dia     = data.getDate();           // 1-31
    var mes     = data.getMonth();          // 0-11 (zero=janeiro)
    var ano4    = data.getFullYear();       // 4 dígitos
    var arrMes = [];
    arrMes[0] = "Janeiro";  
    arrMes[1] = "Fevereiro";
    arrMes[2] = "Março";
    arrMes[3] = "Abril";
    arrMes[4] = "Maio";
    arrMes[5] = "Junho";
    arrMes[6] = "Julho";
    arrMes[7] = "Agosto";
    arrMes[8] = "Setembro";
    arrMes[9] = "Outubro";
    arrMes[10] = "Novembro";
    arrMes[11] = "Dezembro";
    // Formata a data e a hora (note o mês + 1)
    var str_data = dia + ' , ' + arrMes[(mes+1)] + ' de ' + ano4;
    
    $("#ds_data_hoje").text(str_data);
}

function fcListarInformacaoResponsavel(responsavel_pk){
    var objParametros = {
        "pk": responsavel_pk
    };      
    
    var arrCarregar = carregarController("usuario", "listarPk", objParametros);
    
    $("#ds_responsavel_imp").text(arrCarregar.data[0]['ds_usuario']);
    $("#ds_tel_imp").text(arrCarregar.data[0]['ds_cel']);
    $("#ds_email_imp").text(arrCarregar.data[0]['ds_email']);
}

function fcListarNomeLead(leads_pk){
    var objParametros = {
        "pk": leads_pk
    };      
    
    var arrCarregar = carregarController("lead", "listarPk", objParametros);
    
    $("#ds_empresa_imp").text(arrCarregar.data[0]['ds_lead']);
}

function fcExcluirProposta(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              
       
        var arrExcluir = carregarController("proposta", "excluir", objParametros);  
       
        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblPropostas.ajax.reload();
            //fcRecarregarGridPropostas();
        }
        else{
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcAbrirFormNovaProposta(){

    $('#qtde_itens_proposta').html("");
    $('#vl_total_proposta').html("");
    
    $("#propostas_pk").val("");
    $("#dt_envio").val("");
    $("#dt_previsao_fechamento").val("");
    $('#dt_fechamento').prop('checked', false);
    $("#dt_validade").val("");
    $("#ds_obs_proposta").val("");
    $("#ds_obs_proposta").text("");
    //$("#operador_pk").val("");
    $("#ds_obs_motivo_cancelamento").val("");
    $('#dt_fechamento').prop('checked', false);
    $('#dt_cancelamento').prop('checked', false);
    $("input[id=ds_obs_motivo_cancelamento]").prop("disabled", false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_cancelamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);
    tblPropostaItens.clear().destroy();
    fcFormatarGridPropostaItens();
    $("#janela_proposta").modal();
  
    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        retrieve: true,
        paging: false
    });

    tblPrdutosItens.clear().destroy();

    fcAtualizarDadosGridProdutoItens();

}

function formataDatasForm(){
    
    $('#dt_validade').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_validade").keypress(function(){
       mascara(this,mdata);
    });  
    
    $('#dt_envio').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_envio").keypress(function(){
       mascara(this,mdata);
    });  
    
     $('#dt_previsao_fechamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker();  
    $("#dt_previsao_fechamento").keypress(function(){
       mascara(this,mdata);
    });  
}

function fcValidarFormProposta(){
    
    $("#form_proposta").validate({
        rules :{
            dt_validade:{
                required:true,
                minlength:10
            }
        },
        messages:{
            dt_validade:{
                required:"Por favor, informe Data Validade",
                minlength:"Por favor, informe Data válida"
            }

        },
        submitHandler: function(form){
            fcSalvarProposta();            
            return false;      
        }
    });
}

//SALVA O PROPOSTA
function fcSalvarProposta(){ 

    try{
        var JSONinfo = fcFormatarDadosProposta();

        var JSONprodutosItensinfo = fcFormatarDadosProduto();
         
        var v_dt_fechamento = 0; 
        var v_dt_cancelamento = 0; 
        var str_proposta_pk = "";
    
        /*if(JSONinfo == ""){
            return false;
        }
        if(JSONprodutosItensinfo == ""){
            return false;
        }*/

        $('#dt_fechamento').is(":checked") ? v_dt_fechamento = 1 : v_dt_fechamento = 2;
        $('#dt_cancelamento').is(":checked") ? v_dt_cancelamento = 1 : v_dt_cancelamento = 2;
        $("#propostas_pk").val() != "" ? str_proposta_pk = $("#propostas_pk").val() : "";
        $("#propostas_pai_pk").val() != "" ?  str_proposta_pk = "" : "";
    
        var objParametros = {
            "pk": str_proposta_pk,
            "processos_etapas_pk":$('#processos_etapas_pk_2').val(),        
            "dt_envio": $("#dt_envio").val(),
            "dt_previsao_fechamento": $("#dt_previsao_fechamento").val(),    
            "dt_validade": $("#dt_validade").val(),
            "ds_obs": $("#ds_obs_proposta").val(),
            "ds_obs_motivo_cancelamento": $("#ds_obs_motivo_cancelamento").val(),
            "n_versao": $("#n_versao").html(),
            "agendas_pk": $("#agenda_visita_proposta_pk").val(),
            "vl_total":  moeda2float($('#vl_total_proposta').html()),
            "vl_total_materiais":  moeda2float($('#vl_total_produtos').html()),
            "ds_processo_etapas":$('#etapas_2').text(),
            "dt_cancelamento": v_dt_cancelamento,   
            "dt_fechamento": v_dt_fechamento,      
            "proposta_itens": JSONinfo,     
            "produtosItensinfo":JSONprodutosItensinfo,     
            "leads_pk": leads_pk,       
            "processos_pk": pk   
        }; 
        
        var arrEnviar = carregarController("proposta", "salvar", objParametros);
     
        if(arrEnviar.result == 'success'){
            alert("Registro salvo com sucesso.");
            $("#janela_proposta").modal("hide");
            tblPropostas.ajax.reload();
            tblPrdutosItens.ajax.reload();
            if($("#tblContratoItens").length){ 
                if(v_dt_fechamento===1){
                    proposta_contrato_pk = arrEnviar.data[0]['pk'];
                }
            }
        }    
        else{
            alert(arrEnviar.result);
        }
        
        return true;    
    }catch(e){
        alert(e)
    }
    
}

function fcGerarContrato(){
    var strJSONDadosTabelaContrato = fcFormatarDadosPropostaContrato();  

    var ic_tipo_contrato = 1; 

    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": "",
        "dt_inicio_contrato": "",
        "dt_fim_contrato": $("#dt_validade").val(),
        "processos_etapas_pk":$('#processos_etapas_pk_3').val(),
        "ic_tipo_contrato":ic_tipo_contrato,
        "contratos_pk":"",
        "propostas_pk":proposta_contrato_pk,
        //"responsavel_pk":$("#responsavel_pk").val(),
        //"operador_pk":$("#operador_pk").val(),
        "processos_pk":pk,
        "ds_processo_etapas":$('#etapas_3').text(),
        "contratos_itens": strJSONDadosTabelaContrato
    }; 

    var arrEnviar = carregarController("contrato", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        $("#janela_contratos").modal("hide");
        fcRecarregarGridContratosProcessos();
        
    }
}

//FORMATA OS DADOS DA GRID PROPOSTA ITENS
function fcFormatarDadosProposta(){
    var cboProdutosPk = $("select[id='produtos_servicos_pk']");
    var n_qtde_contratos_itens = $("input[id='n_qtde']");
    var proposta_itens_pk_2 = $("input[id='proposta_itens_pk_2']");
    var vl_total = $("input[id='vl_total']");
    var vl_unit = $("input[id='vl_unit']");
    var n_qtde_dias_semana = $("input[id='n_qtde_dias_semana']");
    var JSONinfo ="" ;


    var arrKeys = [];
    arrKeys[0] = "proposta_itens_pk";
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
    arrKeys[5] = "n_qtde_dias_semana";
   
    var arrDados = [];

    var n_qtde_contrato_item = "";
    var vl_unitario = "";
    var vl_total_contrato = "";
    var n_dias_semana = "";
    var data = tblPropostaItens.rows().data();
 
    var JSONinfo = "";

    for(i = 0; i < data.length; i++){
         if(cboProdutosPk.get(i).value == ""){
            cboProdutosPk.get(i).focus();
            return false;
        } 
     
        produtosPk = cboProdutosPk.get(i).value;
        n_qtde_contrato_item = n_qtde_contratos_itens.get(i).value;
        vl_unitario = moeda2float(vl_unit.get(i).value);
        vl_total_contrato = moeda2float(vl_total.get(i).value);
        n_dias_semana = n_qtde_dias_semana.get(i).value;

        arrDados[i] = [
            proposta_itens_pk_2.get(i).value,
            produtosPk, 
            n_qtde_contrato_item, 
            vl_unitario, 
            vl_total_contrato,
            n_dias_semana
        ];

        JSONinfo = arrayToJson(arrKeys, arrDados); 
    }
    
    return JSONinfo;
}

function fcFormatarDadosProduto(){

    var arrProdutosItens = tblPrdutosItens.rows().data()

    var arrKeys = [];
    arrKeys[0] = "propostas_pk";
    arrKeys[1] = "categorias_produto_pk";
    arrKeys[2] = "produtos_pk";
    arrKeys[3] = "n_qtde_item";
    arrKeys[4] = "vl_item_produto";
    arrKeys[5] = "vl_total_produto";
   
    var arrDados = [];
    var JSONinfo = "";
   
    for(i = 0; i < arrProdutosItens.length; i++){

        arrDados[i] = [
            $("#propostas_pk").val(),
            arrProdutosItens[i]['categorias_produto_pk'], 
            arrProdutosItens[i]['produtos_pk'], 
            arrProdutosItens[i]['n_qtde_item'], 
            moeda2float(arrProdutosItens[i]['vl_item_produto']), 
            arrProdutosItens[i]['vl_total_produto'], 
        ];

        JSONinfo = arrayToJson(arrKeys, arrDados);
    }
    
    return JSONinfo;
}

function fcFormatarDadosPropostaContrato(){

    var cboProdutosPk_contrato = $("select[id='produtos_servicos_pk']");
    var n_qtde_contratos_itens_contrato = $("input[id='n_qtde']");
    var vl_total_contrato = $("input[id='vl_total']");
    var vl_unit_contrato = $("input[id='vl_unit']");
    var n_qtde_dias_semana = $("input[id='n_qtde_dias_semana']");
   
    var arrKeys = [];
    arrKeys[0] = "contratos_itens_pk";
    arrKeys[1] = "produtos_servicos_pk";
    arrKeys[2] = "n_qtde";
    arrKeys[3] = "vl_unit";
    arrKeys[4] = "vl_total";
    arrKeys[5] = "n_qtde_dias_semana";
   
    var arrDadosContrato = [];
    for(l = 0; l < (cboProdutosPk_contrato.length); l++){ 
        try{            
            if(cboProdutosPk_contrato.get(l).value == ""){
                cboProdutosPk_contrato.get(l).focus();
                return "";
            }      

            arrDadosContrato[l] = [
                "",
                cboProdutosPk_contrato.get(l).value, 
                n_qtde_contratos_itens_contrato.get(l).value, 
                moeda2float(vl_unit_contrato.get(l).value), 
                moeda2float(vl_total_contrato.get(l).value),
                n_qtde_dias_semana.get(l).value
            ];
           
        }
        catch(err){
            alert(err.message);
        }
    }
    return arrayToJson(arrKeys, arrDadosContrato); 
    
}

function fcEditarProposta(objRegistro){
    
   $('#exibir_motivo_cancelamento').hide();
     
    $('#dt_fechamento').prop('checked', false);
    $('#dt_cancelamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_cancelamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);

    //carregarComboContratoPai(objRegistro['t_contratos_pk']);
   
    //Carrega as informações da linha selecionada.
    $("#propostas_pk").val(objRegistro['t_pk']);
    $("#dt_envio").val(objRegistro['t_dt_envio']); 
    $("#dt_previsao_fechamento").val(objRegistro['t_dt_previsao_fechamento']);
    $("#dt_validade").val(objRegistro['t_dt_validade']);
    $("#ds_obs_proposta").val(objRegistro['t_ds_obs']);
    
    //fcCarregarOperador();
    //$("#operador_pk").val(objRegistro['t_operador_pk']);
    
    tblPropostaItens.clear().destroy();
    carregarListaComboProdutoPropsota();
    
    if(objRegistro['t_dt_fechamento']!=null){
        $('#dt_fechamento').prop('checked', true);
        $("input[id=dt_envio]").prop("disabled", true);
        $("input[id=dt_previsao_fechamento]").prop("disabled", true);
        $("input[id=dt_fechamento]").prop("disabled", true);
        $("input[id=dt_validade]").prop("disabled", true);
        $("#ds_obs_proposta").prop("disabled", true);
        var v_disabled = "readonly";
    }
    if(objRegistro['t_dt_cancelamento']!=null){
        $('#dt_cancelamento').prop('checked', true);
        $('#exibir_motivo_cancelamento').show();
        $("#ds_obs_motivo_cancelamento").val(objRegistro['t_ds_obs_motivo_cancelamento']);
        if(objRegistro['t_ds_obs_motivo_cancelamento']!=null){
            $("input[id=ds_obs_motivo_cancelamento]").prop("disabled", true);
        }
        $("input[id=dt_cancelamento]").prop("disabled", true);
    }
    
    
    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        retrieve: true,
        paging: false
    });

    tblPrdutosItens.clear().destroy();
    
    fcAtualizarDadosGridProdutoItens();

    $("#janela_proposta").modal(); 
    //fcAtualizarDadosGridPropostaItens(v_disabled);
    

    $("#form_proposta").data('validator').resetForm();
}

function fcVersaoProposta(objRegistro){
    $('#exibir_motivo_cancelamento').hide();
    
    $('#dt_fechamento').prop('checked', false);
    $('#dt_cancelamento').prop('checked', false);
    $("input[id=dt_envio]").prop("disabled", false);
    $("input[id=dt_previsao_fechamento]").prop("disabled", false);
    $("input[id=dt_fechamento]").prop("disabled", false);
    $("input[id=dt_cancelamento]").prop("disabled", false);
    $("input[id=dt_validade]").prop("disabled", false);
    $("#ds_obs_proposta").prop("disabled", false);
        
    //fcFormatarGridPropostaItens();     
    //carregarComboContratoPai(objRegistro['t_contratos_pk']);

    //Carrega as informações da linha selecionada.
    $("#n_versao").html(new Number(objRegistro['t_n_versao']) + "." + (1+new Number(objRegistro['t_n_versao'])));
    $("#propostas_pk").val(objRegistro['t_pk']);
    $("#propostas_pai_pk").val(objRegistro['t_pk']);
    $("#dt_envio").val(objRegistro['t_dt_envio']); 
    $("#dt_previsao_fechamento").val(objRegistro['t_dt_previsao_fechamento']);
    $("#dt_validade").val(objRegistro['t_dt_validade']);
    $("#ds_obs_proposta").val(objRegistro['t_ds_obs']);
   // fcCarregarOperador();
    //$("#operador_pk").val(objRegistro['t_operador_pk']);
    tblPropostaItens.clear().destroy();
    carregarListaComboProdutoPropsota();
    
    if(objRegistro['t_dt_fechamento']!=null){
        $('#dt_fechamento').prop('checked', true);
        $("input[id=dt_envio]").prop("disabled", true);
        $("input[id=dt_previsao_fechamento]").prop("disabled", true);
        $("input[id=dt_fechamento]").prop("disabled", true);
        $("input[id=dt_validade]").prop("disabled", true);
        $("#ds_obs_proposta").prop("disabled", true);
        var v_disabled = "readonly";
    }
    if(objRegistro['t_dt_cancelamento']!=null){
        $('#dt_cancelamento').prop('checked', true);
        $('#exibir_motivo_cancelamento').show();
        $("#ds_obs_motivo_cancelamento").val(objRegistro['t_ds_obs_motivo_cancelamento']);
        if(objRegistro['t_ds_obs_motivo_cancelamento']!=null){
            $("input[id=ds_obs_motivo_cancelamento]").prop("disabled", true);
        }
        $("input[id=dt_cancelamento]").prop("disabled", true);
    }
    
    $("#janela_proposta").modal(); 
    //fcAtualizarDadosGridPropostaItens(v_disabled);

    $("#form_proposta").data('validator').resetForm();
}

//RETORNA OS DADOS CADASTRAIS DO CONTRATO ITENS
function fcAtualizarDadosGridPropostaItens(v_disabled){
    var objParametros = {
        "propostas_pk":$("#propostas_pk").val()
    };  
    var arrCarregar = carregarController("proposta_item", "listarPropostaItem", objParametros); 

    if (arrCarregar.result == 'success'){
        
        for(i = 0; i < arrCarregar.data.length; i++){
            
            if($("#propostas_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirPropostaItens(arrCarregar.data[i]['t_pk'],v_disabled);                
            }
            
            //Pega as variaveis 
            var cboProdutosServicosPk = $("select[id='produtos_servicos_pk']");
            var proposta_itens_pk_2 = $("input[id='proposta_itens_pk_2']");
            var n_qtde = $("input[id='n_qtde']");
            var vl_total = $("input[id='vl_total']");
            var vl_unit = $("input[id='vl_unit']");
            var n_qtde_dias_semana = $("input[id='n_qtde_dias_semana']");
           
            cboProdutosServicosPk.get(i).value = arrCarregar.data[i]['t_produtos_servicos_pk'];            
            proposta_itens_pk_2.get(i).value = arrCarregar.data[i]['t_pk'];     
            n_qtde.get(i).value = arrCarregar.data[i]['t_n_qtde'];
            vl_total.get(i).value = arrCarregar.data[i]['t_vl_total'];
            vl_unit.get(i).value = arrCarregar.data[i]['t_vl_unit'];
            n_qtde_dias_semana.get(i).value = arrCarregar.data[i]['t_n_qtde_dias_semana'];
                     
        }        
        fcCalculaTotalPropsota()
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

function fcAtualizarDadosGridPropostaItensImpressao(){
    fcFormatarGridPropostaItensImpressao();
            
    var objParametros = {
        "propostas_pk":$("#propostas_pk").val()
    };  
    var arrCarregar = carregarController("proposta_item", "listarPropostaItem", objParametros); 
    if (arrCarregar.result == 'success'){
        
        for(i = 0; i < arrCarregar.data.length; i++){
            
            if($("#propostas_pk").val()!=""){
                //Adiciona a linha.
                fcIncluirPropostaItensImpressao(arrCarregar.data[i]['t_pk']);                
            }
            //Pega as variaveis 
            var cboProdutosServicosPk_imp = $("input[id='produtos_servicos_pk_imp']");
            //var proposta_itens_pk_2_imp = $("input[id='proposta_itens_pk_2_imp']");
            var n_qtde_imp = $("input[id='n_qtde_imp']");
            var vl_total_imp = $("input[id='vl_total_imp']");
            var vl_unit_imp = $("input[id='vl_unit_imp']");
            var n_qtde_dias_semana_imp = $("input[id='n_qtde_dias_semana_imp']");
            
                    
            cboProdutosServicosPk_imp.get(i).value = arrCarregar.data[i]['t_ds_produto_servico'];            
           
            //proposta_itens_pk_2_imp.get(i).value = arrCarregar.data[i]['t_pk'];
            
            n_qtde_imp.get(i).value = arrCarregar.data[i]['t_n_qtde'];
            
            vl_total_imp.get(i).value = arrCarregar.data[i]['t_vl_total'];
            
            vl_unit_imp.get(i).value = arrCarregar.data[i]['t_vl_unit'];
            n_qtde_dias_semana_imp.get(i).value = arrCarregar.data[i]['t_n_qtde_dias_semana'];
            
            vl_unit_imp.get(i).disabled = true;
             

                        
        }    
        
        fcCalculaTotalPropsotaImpressao();
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

function fcExcluirLinha(vlr){
    
    var proposta_itens_pk = vlr;

    if(proposta_itens_pk!=""){

         var objParametros = {
            "pk": proposta_itens_pk
        };              

        var arrExcluir = carregarController("proposta_item", "excluir", objParametros);   
        
        if (arrExcluir.result == 'success'){
            //Exibe a mensagem
            alert(arrExcluir.message);
            tblPropostas.ajax.reload();   
        }
        else{
           //Exibe a mensagem
            alert(arrExcluir.message);
        } 
    }
    return false;
 
    fcCalculaTotalPropsota();
}

function fcCancelar(){
    sendPost("proposta_res_form.php", {token: token});
}

function fcCarregar(){
    
    if(pk > 0){

        var objParametros = {
            "pk": pk
        };        
        
        var arrCarregar = carregarController("proposta", "listarPk", objParametros);
        if (arrCarregar.result == 'success'){
        
            $("#n_versao").val(arrCarregar.data[0]['n_versao']);
            $("#responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
            $("#vl_total").val(arrCarregar.data[0]['vl_total']);
            $("#ds_obs_proposta").val(arrCarregar.data[0]['ds_obs']);
            $("#dt_validade").val(arrCarregar.data[0]['dt_validade']);
            $("#dt_envio").val(arrCarregar.data[0]['dt_envio']);
            $("#dt_previsao_fechamento").val(arrCarregar.data[0]['dt_previsao_fechamento']);
            $("#dt_fechamento").val(arrCarregar.data[0]['dt_fechamento']);
            $("#dt_cancelamento").val(arrCarregar.data[0]['dt_cancelamento']);
            $("#ds_obs_proposta_motivo_cancelamento").val(arrCarregar.data[0]['ds_obs_motivo_cancelamento']);
            $("#processos_etapas_pk").val(arrCarregar.data[0]['processos_etapas_pk']);
            $("#agendas_pk").val(arrCarregar.data[0]['agendas_pk']);
            //$("#operador_pk").val(arrCarregar.data[0]['operador_pk']);
            $("#ds_obs_motivo_cancelamento").val(arrCarregar.data[0]['ds_obs_motivo_cancelamento']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

//GRID ITENS PROPOSTA
function carregarListaComboProdutoPropsota(){
    var url = '../controller/produto_servico.controller.php?job=listarTodos&token='+token;
    var request = $.ajax({
        url:          url,
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8',
        type:         'post'
    });
    request.done(function(output){
        if (output.result == 'success'){
            strComboProduto = "<select class='form-control form-control-sm' id='produtos_servicos_pk'  name='produtos_servicos_pk' onchange='carregarValorProdutoServico(this.value)'><option></option>";
            for(i = 0; i < output.data.length; i++){
                strComboProduto = strComboProduto + "<option value='"+output.data[i]['pk']+"' >"+output.data[i]['ds_produto_servico']+"</option>";
            }
            strComboProduto+= "</select>";
            
            //Carrega os dados no combo.
            fcFormatarGridPropostaItens();
            
            fcAtualizarDadosGridPropostaItens("");
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    });
    request.fail(function(jqXHR, textStatus){
        alert('Falha ao carregar o registro: ' + textStatus);
    });
}

//FORMATA O GRID DE CONTRATO ITENS
function fcFormatarGridPropostaItens(){    
    tblPropostaItens = $("#tblPropostaItens").DataTable({
        "scrollX": false,
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        "columnDefs" : [
            {   
                "targets": 0,
                "data": "t1",
                "visible":false
            },
            
            {   
                "targets": 1,
                "data": "t2"
            },            
            {   
                "targets": 2,
                "data": "t3"
            },            
            {   
                "targets": 3,
                "data": "t4"
            },            
            {   
                "targets": 4,
                "data": "t5"
            },
            {   
                "targets": 5,
                "data": "t6"
            },
            {   
                "targets": 6,
                "data": "t7",
                "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            }        
        ],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    return false;    
}

function fcFormatarGridPropostaItensImpressao(){    
    tblPropostaItensImprimir = $("#tblPropostaItensImprimir").DataTable({
        "scrollX": false,
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "ordering": false,
        "columnDefs" : [
            {   
                "targets": 0,
                "data": "t1",
                "visible":false
            },
            
            {   
                "targets": 1,
                "data": "t2"
            },            
            {   
                "targets": 2,
                "data": "t3"
            },            
            {   
                "targets": 3,
                "data": "t4"
            },            
            {   
                "targets": 4,
                "data": "t5"
            },     
            {   
                "targets": 5,
                "data": "t6"
            }     
        ],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    return false;    
}

//INCLUI PROPOSTA ITENS
function fcIncluirPropostaItens(propostas_itens_pk,v_disabled){  
    
    tblPropostaItens.row.add(          
    {           
        "t1":propostas_itens_pk,
        "t2":strComboProduto + "<input type='hidden' class='form-control form-control-sm' id='proposta_itens_pk_2' size='4' /><input type='hidden' class='form-control form-control-sm' id='ic_valor_aberto' size='4' />",
        "t3":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnit()' onkeypress='mascara(this,soNumeros)' id='n_qtde' size='4' "+v_disabled+"/>",
        "t4":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,soNumeros)' id='n_qtde_dias_semana'/>",
        "t5":"<input type='text' class='form-control form-control-sm' onchange='fcCalcularValorVlUnit()' onkeypress='mascara(this,moeda)' id='vl_unit'  />",
        "t6":"<input type='text' class='form-control form-control-sm' onkeypress='mascara(this,moeda)' id='vl_total' "+v_disabled+"/>",
        "t7":"<a class='function_delete' ><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
    }            
    ).draw( false );
    tblPropostaItens.on('click', '.function_delete', function () {      
        var data;        
        if(tblPropostaItens.row( $(this).parents('li') ).data()){    
            data = tblPropostaItens.row( $(this).parents('li') ).data();            
        }else if(tblPropostaItens.row( $(this).parents('tr') ).data()){            
            data = tblPropostaItens.row( $(this).parents('tr') ).data();
            
        }
        
        if(data['t1'] != ""){
              
            fcExcluirLinha(data['t1']);
        }
        tblPropostaItens.row($(this).parents('tr')).remove().draw();
        fcCalculaTotalPropsota();
    } ); 
    
    return false;
}

function fcIncluirPropostaItensImpressao(propostas_itens_pk){  
    
    tblPropostaItensImprimir.row.add(          
    {           
        "t1":propostas_itens_pk,
        "t2":"<input type='text' class='form-control form-control-sm' id='produtos_servicos_pk_imp' disabled>" + "<input type='hidden' class='form-control form-control-sm' id='proposta_itens_pk_2_imp' size='4' /><input type='hidden' class='form-control form-control-sm' id='ic_valor_aberto' size='4' />",
        "t3":"<input type='text' class='form-control form-control-sm'  id='n_qtde_imp' size='4' disabled/>",
        "t4":"<input type='text' class='form-control form-control-sm'  id='n_qtde_dias_semana_imp'/>",
        "t4":"<input type='text' class='form-control form-control-sm' id='vl_unit_imp' disabled />",
        "t5":"<input type='text' class='form-control form-control-sm'  id='vl_total_imp' disabled/>"
    }            
    ).draw( false );
   
    
    return false;
}

function fcCalcularValorVlUnit(){
    var n_qtde_propostas_itens = $("input[id='n_qtde']");
    var vl_unit = $("input[id='vl_unit']");
    var vl_total = $("input[id='vl_total']");

    
    for(i = 0; i < n_qtde_propostas_itens.length; i++){             
        vl_total.get(i).value = float2moeda(n_qtde_propostas_itens.get(i).value * moeda2float(vl_unit.get(i).value));
    }
    
    fcCalculaTotalPropsota()
}

function fcCalcularVlProduto(ic){
    var vl_total_produtos = 0;
    var n_qtde_produtos = 0;
    var vl_total_itens_produtos = 0;
    var vl_total_novo_produto = 0;
    var n_qtde_total_novo_produto = 0;
    var n_qtde_item = 0;

    if(ic === 1){
        var objParametros = {
            "pk": $("#propostas_pk").val()
        };
        var arrCarregar = carregarController("proposta", "listarProdutosItens", objParametros);

        for(i = 0; i < arrCarregar.data.length; i++){
            n_qtde_item = arrCarregar.data[i]['qtde_total_itens']
            vl_total_produtos = arrCarregar.data[i]['vl_total_itens']
        }

        $('#qtde_produtos').html(n_qtde_item);
        $('#vl_total_produtos').html(vl_total_produtos); 

    }else if(ic === 2){
        /*var arrProdutosItens = ""; 
        arrProdutosItens = tblPrdutosItens.rows().data();*/

        n_qtde_produtos = $('#qtde_produtos').html()*1
        vl_total_itens_produtos = moeda2float($('#vl_total_produtos').html())
        vl_total_novo_produto =  moeda2float($("#vl_item_produto").val())
        n_qtde_total_novo_produto = $("#n_qtde_item").val()*1
        
        vl_total_itens_produtos = (vl_total_novo_produto * n_qtde_total_novo_produto ) + vl_total_itens_produtos;
        n_qtde_produtos = n_qtde_total_novo_produto + n_qtde_produtos;
        
        $('#qtde_produtos').html(n_qtde_produtos);
        $('#vl_total_produtos').html(vl_total_itens_produtos);
    }
       
}

function carregarValorProdutoServico(pk){
    
    var objParametros = {
        "pk": pk
    };
    var arrCarregar = carregarController("produto_servico", "listarPk", objParametros); 
    
    
    //PEGA A QUANTIDADE DE LINHAS INSERIDAS
    var  data = tblPropostaItens.rows().data();
    
    var t = (data.length - 1);
    
   
    var vl_unit = $("input[id='vl_unit']"); 
    
    if(arrCarregar.data[0]['ic_valor_aberto']!=1){
        
        vl_unit.get(t).value = float2moeda(arrCarregar.data[0]['vl_produto_servico']);
    }
    else{
        vl_unit.get(t).value = (arrCarregar.data[0]['vl_produto_servico']);
        vl_unit.get(t).disabled = false;
    }
    
    
    t++;
        
}


function fcCalculaTotalPropsota(){

    $('#qtde_itens_proposta').html("");
    $('#vl_total_proposta').html("");
    
    var n_qtde_propostas_itens = $("input[id='n_qtde']");
    var vl_total = $("input[id='vl_total']");

    var vqtde_itens_proposta = 0;
    var vtotal_proposta = 0;
    var  data = tblPropostaItens.rows().data();

    for(i = 0; i < data.length; i++){         
        vqtde_itens_proposta += new Number(n_qtde_propostas_itens.get(i).value)
        
        vtotal_proposta += moeda2float(vl_total.get(i).value)    
    }

   $('#qtde_itens_proposta').html(vqtde_itens_proposta)
   $('#vl_total_proposta').html(float2moeda(vtotal_proposta));
}

function fcCalculaTotalPropsotaImpressao(){

    $('#qtde_itens_proposta_imp').html("");
    $('#vl_total_proposta_imp').html("");
    
    var n_qtde_propostas_itens = $("input[id='n_qtde_imp']");
    var vl_total = $("input[id='vl_total_imp']");

    var vqtde_itens_proposta = 0;
    var vtotal_proposta = 0;
    var  data = tblPropostaItensImprimir.rows().data();
    for(i = 0; i < data.length; i++){ 
       
        vqtde_itens_proposta += new Number(n_qtde_propostas_itens.get(i).value)
        
        vtotal_proposta += moeda2float(vl_total.get(i).value)    
    }

   $('#qtde_itens_proposta_imp').html(vqtde_itens_proposta)
   $('#vl_total_proposta_imp').html(float2moeda(vtotal_proposta));
}

$(document).ready(function(){  

    $('#exibir_motivo_cancelamento').hide();
    
    $("#dt_cancelamento").change(function(){
        if( $("#dt_cancelamento").is(":checked") == true ){
            $('#exibir_motivo_cancelamento').show();
        }
        else{
            $('#exibir_motivo_cancelamento').hide();
        }
    });
    
    tblPrdutosItens = $('#tblPrdutosItens').DataTable({
        retrieve: true,
        paging: false
    });

    tblPrdutosItens.clear().destroy();

    // carregar grid de propsotas
    fcCarregarGridProposta();
    
    //Chama modal de cadastro
        $(document).on('click', '#cmdIncluirProposta ', fcAbrirFormNovaProposta);
    //formata as datas do form  
    formataDatasForm();

    $(document).on('click', '#cmdIncluirPropostaItens', function () {            
        fcIncluirPropostaItens("");
    } );

    //VERSÃO DA PROPOSTA
    $('#n_versao').html('1.0');
    $('#n_versao').val('1.0');
    
    carregarListaComboProdutoPropsota();        
    fcAtualizarDadosGridPropostaItensImpressao();
    fcCarregarCategorias();
    $("#categorias_produto_pk").change(function () {
        if ($("#categorias_produto_pk").val() != '') {
            $(".chzn-select").chosen('destroy');
            fcCarregarProdutos($("#categorias_produto_pk").val());
        }
    });


    $("#vl_item_produto").keypress(function(){
        mascara(this,moeda)
     });
    
    //VALIDAR FORM
    fcValidarFormProposta();

    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#btnImprimirModal', fcImprimir);
    //Atribui a validação do formulário dos campos obrigatórios
    
    fcCalculaTotalPropsota();
    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregar(); 
});