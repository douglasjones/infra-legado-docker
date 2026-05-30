var tblDespesaFixa;
function fcPesquisarDespesaFixa(){
	
    tblDespesaFixa.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluirDespesaFixa(){

    sendPost('inc_receita_cad_form.php',{token: token, pk: ''});

}

function fcExcluirDespesaFixa(v_pk, v_dt_vencimento){

    if (confirm("Deseja realmente excluir o registro '" + v_dt_vencimento + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };              
            
            var arrExcluir = carregarController("lancamento", "excluir", objParametros);   

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblDespesaFixa.ajax.reload();

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
function fcLimparVariavelDespesaFixa(){
    $("#lancamento_despesa_fixa_pk").val("");
    $("#dt_vencimento_despesa_fixa").val("");
    $("#ds_lancamento_despesa_fixa").val("");
    $("#vl_lancamento_despesa_fixa").val("");
    $("#tipo_grupo_pk_despesa_fixa").val("");
    $("#grupo_leancamento_pk_despesa_fixa").val("");
    $("#ic_status_pagamento_despesa_fixa").val("");
    $("#dt_competencia_despesa_fixa").val("");
    $("#n_documento_despesa_fixa").val("");
    $("#tipos_operacao_pk_despesa_fixa").val("");
    $("#metodos_pagamento_pk_despesa_fixa").val("");
    $("#contas_bancarias_pk_despesa_fixa").val("");
    $("#tipo_grupo_centro_custo_pk_despesa_fixa").val("");
    $("#grupo_lancamento_centro_custo_pk_despesa_fixa").val("");
    $("#ds_ocorrencia_despesa_fixa").val("");
}
function fcEditarDespesaFixa(obj){
     fcLimparVariavelDespesaFixa();
    
      
     
    $("#tipo_lancamento_modal_despesa_fixa").val(2);
    $("#lancamento_despesa_fixa_pk").val(obj['t_pk']);
    $("#dt_vencimento_despesa_fixa").val(obj['t_dt_vencimento']);
    $("#ds_lancamento_despesa_fixa").val(obj['t_ds_lancamento']);
    $("#vl_lancamento_despesa_fixa").val(float2moeda(obj['t_vl_lancamento']));
    $("#tipo_grupo_pk_despesa_fixa").val(obj['t_tipo_grupo_pk']);
    $("#empresas_pk_despesa_fixa").val(obj['t_empresas_pk']);
    fcListarItensGruposDespesaFixa();
    $("#grupo_leancamento_pk_despesa_fixa").val(obj['t_grupo_leancamento_pk']);
    $("#ic_status_pagamento_despesa_fixa").val(obj['t_ic_status_pagamento']);
    $("#dt_competencia_despesa_fixa").val(obj['t_dt_competencia']);
    $("#n_documento_despesa_fixa").val(obj['t_n_documento']);
    $("#tipos_operacao_pk_despesa_fixa").val(obj['t_tipos_operacao_pk']);
    $("#metodos_pagamento_pk_despesa_fixa").val(obj['t_metodos_pagamento_pk']);
    $("#contas_bancarias_pk_despesa_fixa").val(obj['t_contas_bancarias_pk']);
    $("#tipo_grupo_centro_custo_pk_despesa_fixa").val(obj['tipo_grupo_centro_custo_pk']);
    $("#empresa_modal_despesa_fixa_pk").val(obj['t_empresas_pk']);
    fcListarItensGruposCentroCustoDespesaFixa();
    $("#grupo_lancamento_centro_custo_pk_despesa_fixa").val(obj['grupo_lancamento_centro_custo_pk']);
    //$("#ds_ocorrencia_despesa_fixa").val(obj['ds_ocorrencia']);
    
    $("#modal_despesa_fixa").modal();
    $(".chzn-select").chosen('destroy');
}

function fcCarregarGridDespesaFixa(){

    
    var objParametros = {
        "dt_vencimento_ini": primeiroDia,
        "dt_vencimento_fim": ultimoDia,
        "contas_bancarias_pk":$("#contas_pk").val(),
        "operacao_pk":2
    };     
    
    var v_url = montarUrlController("lancamento", "listarReceita", objParametros);
   //alert(v_url);
    //Trata a tabela
    tblDespesaFixa = $('#tblDespesaFixa').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a>"
            },
           {"targets": -2, "data": "t_ds_status_pagamento"},
           {"targets": -3, "data": "t_ds_tipo_operacao"},
           {"targets": -4, "data": "t_ds_tipo_grupo"},
           {"targets": -5, "data": "t_vl_lancamento"},
           {"targets": -6, "data": "t_ds_lancamento"},
           {"targets": -7, "data": "t_dt_vencimento"},
           {"targets": -8, "data": "t_ds_recebido_de_centro_custo"},
           {"targets": -9, "data": "t_ds_razao_social"},
           {"targets": -10, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblDespesaFixa tbody').on('click', '.function_edit', function () {
        var data;
        if(tblDespesaFixa.row( $(this).parents('li')).data()){
            data = tblDespesaFixa.row( $(this).parents('li')).data();
        }
        else if(tblDespesaFixa.row( $(this).parents('tr')).data()){
            data = tblDespesaFixa.row( $(this).parents('tr')).data();
        }
        fcEditarDespesaFixa(data);
        
    } );   
    
    $('#tblDespesaFixa tbody').on('click', '.function_delete', function () {
        var data;
        if(tblDespesaFixa.row( $(this).parents('li') ).data()){
            data = tblDespesaFixa.row( $(this).parents('li') ).data();
        }
        else if(tblDespesaFixa.row( $(this).parents('tr') ).data()){
            data = tblDespesaFixa.row( $(this).parents('tr') ).data();
        }
        fcExcluirDespesaFixa(data['t_pk'], data['t_ds_lancamento']);
    } );            
    $('#tblDespesaFixa tbody').on('click', '.function_painel', function () {
        var data;
        if(tblDespesaFixa.row( $(this).parents('li') ).data()){
            data = tblDespesaFixa.row( $(this).parents('li') ).data();
        }
        else if(tblDespesaFixa.row( $(this).parents('tr') ).data()){
            data = tblDespesaFixa.row( $(this).parents('tr') ).data();
        }
        fcAbrirModalDocs(data['t_pk'])
    } );            
    
}
function fcAbrirFormDespesaFixa(){
    //limpa os dados de qualquer registro existe
    fcLimparVariavelDespesaFixa();
    $(".chzn-select").chosen('destroy');
    
    
    $("#modal_despesa_fixa").modal();
    
    $(".chzn-select").chosen({allow_single_deselect: true});
}

function fcListarItensGruposDespesaFixa(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_pk_despesa_fixa").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_leancamento_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_lead");    
    }else if($("#tipo_grupo_pk_despesa_fixa").val()==2){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_colaborador");   
    }else if($("#tipo_grupo_pk_despesa_fixa").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_fornecedor");   
    }
}
function fcListarItensGruposCentroCustoDespesaFixa(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_centro_custo_pk_despesa_fixa").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_lead"); 
        
    }else if($("#tipo_grupo_centro_custo_pk_despesa_fixa").val()==2){
        
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_colaborador");   
        
    }else if($("#tipo_grupo_centro_custo_pk_despesa_fixa").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_fornecedor");  
        
    }
    else if($("#tipo_grupo_centro_custo_pk_despesa_fixa").val()==4){
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_equipe");   
    }
}
function fcListarContaBancariaDespesaFixa(){

    var objParametros = {
        "empresas_pk": $("#empresa_modal_despesa_fixa_pk").val()
    };          
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);    

    carregarComboAjax($("#contas_bancarias_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_dados_conta");    
    
}

function fcListarTipoCategoriaDespesaFixa(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}
function fcListarMetodosPagamentoDespesaFixa(){

    var objParametros = {
        "pk": ""
    };          
   
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);   

    carregarComboAjax($("#metodos_pagamento_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_metodo_pagamento");    
   
}
function fcListarTipoCategoriaDespesaFixa(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_despesa_fixa"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}


function fcValidarFormFixa(){

    $("#formDespesaFixa").validate({
        rules :{
            

        },
        messages:{
        },
        submitHandler: function(form){
            fcEnviarDespesaFixa(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviarDespesaFixa(){
    
    if($('#tipo_lancamento_modal_despesa_fixa').val()==""){
        $("#alert_tipo_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_lancamento").slideUp(500);
        });
        $('#tipo_lancamento_modal_despesa_fixa').focus();
        return false;
    }
    if($('#tipos_operacao_pk_despesa_fixa').val()==""){
        $("#alert_tipo_operacao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_operacao").slideUp(500);
        });
        $('#tipos_operacao_pk_despesa_fixa').focus();
        return false;
    }
    if($('#ds_lancamento_despesa_fixa').val()==""){
        $("#alert_ds_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_lancamento").slideUp(500);
        });
        $('#ds_lancamento_despesa_fixa').focus();
        return false;
    }
    if($('#tipo_grupo_pk_despesa_fixa').val()==""){
        $("#alert_tipo_grupo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_grupo").slideUp(500);
        });
        $('#tipo_grupo_pk_despesa_fixa').focus();
        return false;
    }
    if($('#vl_lancamento_despesa_fixa').val()==""){
        $("#alert_valor").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_valor").slideUp(500);
        });
        $('#vl_lancamento_despesa_fixa').focus();
        return false;
    }
    if($('#dt_vencimento_despesa_fixa').val()==""){
        $("#alert_dt_vencimento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_vencimento").slideUp(500);
        });
        $('#dt_vencimento_despesa_fixa').focus();
        return false;
    }
    
    if($('#metodos_pagamento_pk_despesa_fixa').val()==""){
        $("#alert_metodo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_metodo").slideUp(500);
        });
        $('#metodos_pagamento_pk_despesa_fixa').focus();
        return false;
    }
    
    if($('#contas_bancarias_pk_despesa_fixa').val()==""){
        $("#alert_banco").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_banco").slideUp(500);
        });
        $('#contas_bancarias_pk_despesa_fixa').focus();
        return false;
    }
    if($('#ic_status_pagamento_despesa_fixa').val()==""){
        $("#alert_status").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_status").slideUp(500);
        });
        $('#ic_status_pagamento_despesa_fixa').focus();
        return false;
    }
    


    
    var objParametros = {
        "pk": $("#lancamento_despesa_fixa_pk").val(),
        "dt_vencimento": $("#dt_vencimento_despesa_fixa").val(),
        "ds_lancamento": $("#ds_lancamento_despesa_fixa").val(),
        "vl_lancamento": moeda2float($("#vl_lancamento_despesa_fixa").val()),
        "tipo_grupo_pk": $("#tipo_grupo_pk_despesa_fixa").val(),
        "grupo_leancamento_pk": $("#grupo_leancamento_pk_despesa_fixa").val(),
        "ic_status_pagamento": $("#ic_status_pagamento_despesa_fixa").val(),
        "dt_competencia": $("#dt_competencia_despesa_fixa").val(),
        "n_documento": $("#n_documento_despesa_fixa").val(),
        "tipos_operacao_pk": $("#tipos_operacao_pk_despesa_fixa").val(),
        "metodos_pagamento_pk": $("#metodos_pagamento_pk_despesa_fixa").val(),
        "contas_bancarias_pk": $("#contas_bancarias_pk_despesa_fixa").val(),
        "empresas_pk": $("#empresa_modal_despesa_fixa_pk").val(),
        "tipo_grupo_centro_custo_pk": $("#tipo_grupo_centro_custo_pk_despesa_fixa").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk_despesa_fixa").val(),
        //"ds_ocorrencia": $("#ds_ocorrencia_despesa_fixa").val(),
        "operacao_pk": $("#tipo_lancamento_modal_despesa_fixa").val()    
    };    

    var arrEnviar = carregarController("lancamento", "salvar", objParametros);   
    
      
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
            $("#modal_despesa_fixa").modal("hide");
            
            $("select[id='empresas_pk']").val($("#empresa_modal_despesa_fixa_pk").val());
            $("#empresas_pk").val($("#empresa_modal_despesa_fixa_pk").val());
            
            $("select[id='contas_pk']").val($("#contas_bancarias_pk_despesa_fixa").val());
            $("#contas_pk").val($("#contas_bancarias_pk_despesa_fixa").val());
            
           //FATURAMENTO 
            fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
            
            if($("#tipo_lancamento_modal_despesa_fixa").val()==1){
                document.getElementById("receita-tab").click();
                tblReceita.clear().destroy();
                fcCarregarGridReceita();
                
            }
            else if($("#tipo_lancamento_modal_despesa_fixa").val()==2){
                document.getElementById("despesafixa-tab").click();
                tblDespesaFixa.clear().destroy();
                fcCarregarGridDespesaFixa();
            }
            else if($("#tipo_lancamento_modal_despesa_fixa").val()==3){
                document.getElementById("despesavarival-tab").click();
                tblDespesaVariavel.clear().destroy();
                fcCarregarGridDespesaVariavel();
            }
            else if($("#tipo_lancamento_modal_despesa_fixa").val()==4){
                document.getElementById("impostos-tab").click();
                tblImposto.clear().destroy();
                fcCarregarGridImposto();
            }
            else if($("#tipo_lancamento_modal_despesa_fixa").val()==5){
                document.getElementById("transferencia-tab").click();
                tblTransferencia.clear().destroy();
                fcCarregarGridTransferencia();
            }
            
            
            fcCarregarGraficoLinha();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function carregarComboEmpresaDespesaFixa(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);   
   
    carregarComboAjax($("#empresas_pk_despesa_fixa"), arrCarregar, "", "pk", "ds_razao_social");
}
$(document).ready(function(){
    //RECEITA
 
    $(document).on('click', '#cmdIncluirDespesaFixa', fcAbrirFormDespesaFixa);

    $("#tipo_grupo_pk_despesa_fixa").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposDespesaFixa();   
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#tipo_grupo_centro_custo_pk_despesa_fixa").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposCentroCustoDespesaFixa();    
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#empresa_modal_despesa_fixa_pk").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarContaBancariaDespesaFixa();  
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $(".recebido_de_pago_para").html("Recebido de ?:");
    $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
    $("#tipo_lancamento_modal_despesa_fixa").change(function(){ 
        if($("#tipo_lancamento_modal_despesa_fixa").val()==1){
            $(".recebido_de_pago_para").html("Recebido de ?:");
            $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
        }
        else{
            $(".recebido_de_pago_para").html("Pago para ?:");
            $(".metodo_recebimento_pagamento").html("Método de Pagamento:");
        }
        
    });
    //carregarComboEmpresaDespesaFixa();
    
    fcListarTipoCategoriaDespesaFixa();  
    
    fcListarContaBancariaDespesaFixa();
    
    fcListarMetodosPagamentoDespesaFixa();


    //faz a carga inicial do grid.
    fcCarregarGridDespesaFixa();
    
    fcValidarFormFixa();
  
    
    
    $('#dt_vencimento_despesa_fixa').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_vencimento_despesa_fixa").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_competencia_despesa_fixa').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_competencia_despesa_fixa").keypress(function(){
       mascara(this,mdata);
    });
    $("#vl_lancamento_despesa_fixa").keypress(function(){
       mascara(this,moeda);
    });
    
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisarDespesaFixa);
    $(document).on('click', '#cmdIncluir', fcIncluirDespesaFixa);

});