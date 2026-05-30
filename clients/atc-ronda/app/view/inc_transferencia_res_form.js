

var tblTransferencia;
var tblTransferencia;
function fcPesquisarTransferencia(){
	
    tblTransferencia.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluirTransferencia(){

    sendPost('inc_receita_cad_form.php',{token: token, pk: ''});

}

function fcExcluirTransferencia(v_pk, v_dt_vencimento){

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
                tblTransferencia.ajax.reload();

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
function fcLimparVariavelTransferencia(){
    $("#lancamento_transferencia_pk").val("");
    $("#dt_vencimento_transferencia").val("");
    $("#ds_lancamento_transferencia").val("");
    $("#vl_lancamento_transferencia").val("");
    $("#tipo_grupo_pk_transferencia").val("");
    $("#grupo_leancamento_pk_transferencia").val("");
    $("#ic_status_pagamento_transferencia").val("");
    $("#dt_competencia_transferencia").val("");
    $("#n_documento_transferencia").val("");
    $("#tipos_operacao_pk_transferencia").val("");
    $("#metodos_pagamento_pk_transferencia").val("");
    $("#contas_bancarias_pk_transferencia").val("");
    $("#tipo_grupo_centro_custo_pk_transferencia").val("");
    $("#grupo_lancamento_centro_custo_pk_transferencia").val("");
    $("#ds_ocorrencia_transferencia").val("");
}
function fcEditarTransferencia(obj){
     fcLimparVariavelTransferencia();
    
      
     
    $("#tipo_lancamento_modal_transferencia").val(5);
    $("#lancamento_transferencia_pk").val(obj['t_pk']);
    $("#dt_vencimento_transferencia").val(obj['t_dt_vencimento']);
    $("#ds_lancamento_transferencia").val(obj['t_ds_lancamento']);
    $("#vl_lancamento_transferencia").val(float2moeda(obj['t_vl_lancamento']));
    $("#tipo_grupo_pk_transferencia").val(obj['t_tipo_grupo_pk']);
    $("#empresas_pk_transferencia").val(obj['t_empresas_pk']);
    fcListarItensGruposTransferencia();
    $("#grupo_leancamento_pk_transferencia").val(obj['t_grupo_leancamento_pk']);
    $("#ic_status_pagamento_transferencia").val(obj['t_ic_status_pagamento']);
    $("#dt_competencia_transferencia").val(obj['t_dt_competencia']);
    $("#n_documento_transferencia").val(obj['t_n_documento']);
    $("#tipos_operacao_pk_transferencia").val(obj['t_tipos_operacao_pk']);
    $("#metodos_pagamento_pk_transferencia").val(obj['t_metodos_pagamento_pk']);
    $("#contas_bancarias_pk_transferencia").val(obj['t_contas_bancarias_pk']);
    $("#tipo_grupo_centro_custo_pk_transferencia").val(obj['tipo_grupo_centro_custo_pk']);
    $("#empresa_modal_transferencia_pk").val(obj['t_empresas_pk']);
    fcListarItensGruposCentroCustoTransferencia();
    $("#grupo_lancamento_centro_custo_pk_transferencia").val(obj['grupo_lancamento_centro_custo_pk']);
    //$("#ds_ocorrencia_transferencia").val(obj['ds_ocorrencia']);
    
    $("#modal_transferencia").modal();
    $(".chzn-select").chosen('destroy');
}

function fcCarregarGridTransferencia(){

    
    var objParametros = {
        "dt_vencimento_ini": primeiroDia,
        "dt_vencimento_fim": ultimoDia,
        "contas_bancarias_pk":$("#contas_pk").val(),
        "operacao_pk":5
    };     
    
    var v_url = montarUrlController("lancamento", "listarReceita", objParametros);
   //alert(v_url);
    //Trata a tabela
    tblTransferencia = $('#tblTransferencia').DataTable({
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
    $('#tblTransferencia tbody').on('click', '.function_edit', function () {
        var data;
        if(tblTransferencia.row( $(this).parents('li')).data()){
            data = tblTransferencia.row( $(this).parents('li')).data();
        }
        else if(tblTransferencia.row( $(this).parents('tr')).data()){
            data = tblTransferencia.row( $(this).parents('tr')).data();
        }
        fcEditarTransferencia(data);
        
    } );   
    
    $('#tblTransferencia tbody').on('click', '.function_delete', function () {
        var data;
        if(tblTransferencia.row( $(this).parents('li') ).data()){
            data = tblTransferencia.row( $(this).parents('li') ).data();
        }
        else if(tblTransferencia.row( $(this).parents('tr') ).data()){
            data = tblTransferencia.row( $(this).parents('tr') ).data();
        }
        fcExcluirTransferencia(data['t_pk'], data['t_ds_lancamento']);
    } );            
    $('#tblTransferencia tbody').on('click', '.function_painel', function () {
        var data;
        if(tblTransferencia.row( $(this).parents('li') ).data()){
            data = tblTransferencia.row( $(this).parents('li') ).data();
        }
        else if(tblTransferencia.row( $(this).parents('tr') ).data()){
            data = tblTransferencia.row( $(this).parents('tr') ).data();
        }
        fcAbrirModalDocs(data['t_pk'])
    } );            
    
}
function fcAbrirFormTransferencia(){
    //limpa os dados de qualquer registro existe
    fcLimparVariavelTransferencia();
    $(".chzn-select").chosen('destroy');
    
    
    $("#modal_transferencia").modal();
    
    $(".chzn-select").chosen({allow_single_deselect: true});
}

function fcListarItensGruposTransferencia(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_pk_transferencia").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_leancamento_pk_transferencia"), arrCarregar, " ", "pk", "ds_lead");    
    }else if($("#tipo_grupo_pk_transferencia").val()==2){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_transferencia"), arrCarregar, " ", "pk", "ds_colaborador");   
    }else if($("#tipo_grupo_pk_transferencia").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_transferencia"), arrCarregar, " ", "pk", "ds_fornecedor");   
    }
}
function fcListarItensGruposCentroCustoTransferencia(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_centro_custo_pk_transferencia").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_transferencia"), arrCarregar, " ", "pk", "ds_lead"); 
        
    }else if($("#tipo_grupo_centro_custo_pk_transferencia").val()==2){
        
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_transferencia"), arrCarregar, " ", "pk", "ds_colaborador");   
        
    }else if($("#tipo_grupo_centro_custo_pk_transferencia").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_transferencia"), arrCarregar, " ", "pk", "ds_fornecedor");  
        
    }
    else if($("#tipo_grupo_centro_custo_pk_transferencia").val()==4){
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_transferencia"), arrCarregar, " ", "pk", "ds_equipe");   
    }
}
function fcListarContaBancariaTransferencia(){

    var objParametros = {
        "empresas_pk": $("#empresa_modal_transferencia_pk").val()
    };          
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);    

    carregarComboAjax($("#contas_bancarias_pk_transferencia"), arrCarregar, " ", "pk", "ds_dados_conta");    
    
}

function fcListarTipoCategoriaTransferencia(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_transferencia"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}
function fcListarMetodosPagamentoTransferencia(){

    var objParametros = {
        "pk": ""
    };          
   
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);   

    carregarComboAjax($("#metodos_pagamento_pk_transferencia"), arrCarregar, " ", "pk", "ds_metodo_pagamento");    
   
}
function fcListarTipoCategoriaTransferencia(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_transferencia"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}


function fcValidarFormTransferencia(){

    $("#formTransferencia").validate({
        rules :{
            

        },
        messages:{
        },
        submitHandler: function(form){
            fcEnviarTransferencia(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviarTransferencia(){
    
    if($('#tipo_lancamento_modal_transferencia').val()==""){
        $("#alert_tipo_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_lancamento").slideUp(500);
        });
        $('#tipo_lancamento_modal_transferencia').focus();
        return false;
    }
    if($('#tipos_operacao_pk_transferencia').val()==""){
        $("#alert_tipo_operacao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_operacao").slideUp(500);
        });
        $('#tipos_operacao_pk_transferencia').focus();
        return false;
    }
    if($('#ds_lancamento_transferencia').val()==""){
        $("#alert_ds_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_lancamento").slideUp(500);
        });
        $('#ds_lancamento_transferencia').focus();
        return false;
    }
    if($('#tipo_grupo_pk_transferencia').val()==""){
        $("#alert_tipo_grupo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_grupo").slideUp(500);
        });
        $('#tipo_grupo_pk_transferencia').focus();
        return false;
    }
    if($('#vl_lancamento_transferencia').val()==""){
        $("#alert_valor").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_valor").slideUp(500);
        });
        $('#vl_lancamento_transferencia').focus();
        return false;
    }
    if($('#dt_vencimento_transferencia').val()==""){
        $("#alert_dt_vencimento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_vencimento").slideUp(500);
        });
        $('#dt_vencimento_transferencia').focus();
        return false;
    }
    
    if($('#metodos_pagamento_pk_transferencia').val()==""){
        $("#alert_metodo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_metodo").slideUp(500);
        });
        $('#metodos_pagamento_pk_transferencia').focus();
        return false;
    }
    
    if($('#contas_bancarias_pk_transferencia').val()==""){
        $("#alert_banco").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_banco").slideUp(500);
        });
        $('#contas_bancarias_pk_transferencia').focus();
        return false;
    }
    if($('#ic_status_pagamento_transferencia').val()==""){
        $("#alert_status").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_status").slideUp(500);
        });
        $('#ic_status_pagamento_transferencia').focus();
        return false;
    }
    


    
    var objParametros = {
        "pk": $("#lancamento_transferencia_pk").val(),
        "dt_vencimento": $("#dt_vencimento_transferencia").val(),
        "ds_lancamento": $("#ds_lancamento_transferencia").val(),
        "vl_lancamento": moeda2float($("#vl_lancamento_transferencia").val()),
        "tipo_grupo_pk": $("#tipo_grupo_pk_transferencia").val(),
        "grupo_leancamento_pk": $("#grupo_leancamento_pk_transferencia").val(),
        "ic_status_pagamento": $("#ic_status_pagamento_transferencia").val(),
        "dt_competencia": $("#dt_competencia_transferencia").val(),
        "n_documento": $("#n_documento_transferencia").val(),
        "tipos_operacao_pk": $("#tipos_operacao_pk_transferencia").val(),
        "metodos_pagamento_pk": $("#metodos_pagamento_pk_transferencia").val(),
        "contas_bancarias_pk": $("#contas_bancarias_pk_transferencia").val(),
        "empresas_pk": $("#empresa_modal_transferencia_pk").val(),
        "tipo_grupo_centro_custo_pk": $("#tipo_grupo_centro_custo_pk_transferencia").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk_transferencia").val(),
        //"ds_ocorrencia": $("#ds_ocorrencia_transferencia").val(),
        "operacao_pk": $("#tipo_lancamento_modal_transferencia").val()    
    };    

    var arrEnviar = carregarController("lancamento", "salvar", objParametros);   
    
      
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
            $("#modal_transferencia").modal("hide");
            
            $("select[id='empresas_pk']").val($("#empresa_modal_transferencia_pk").val());
            $("#empresas_pk").val($("#empresa_modal_transferencia_pk").val());
            
            $("select[id='contas_pk']").val($("#contas_bancarias_pk_transferencia").val());
            $("#contas_pk").val($("#contas_bancarias_pk_transferencia").val());
            
           //FATURAMENTO 
            fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
            
            if($("#tipo_lancamento_modal_transferencia").val()==1){
                document.getElementById("receita-tab").click();
                tblReceita.clear().destroy();
                fcCarregarGridReceita();
                
            }
            else if($("#tipo_lancamento_modal_transferencia").val()==2){
                document.getElementById("despesafixa-tab").click();
                tblDespesaFixa.clear().destroy();
                fcCarregarGridDespesaFixa();
            }
            else if($("#tipo_lancamento_modal_transferencia").val()==3){
                document.getElementById("despesavarival-tab").click();
                tblDespesaVariavel.clear().destroy();
                fcCarregarGridDespesaVariavel();
            }
            else if($("#tipo_lancamento_modal_transferencia").val()==4){
                document.getElementById("impostos-tab").click();
                tblImposto.clear().destroy();
                fcCarregarGridImposto();
            }
            else if($("#tipo_lancamento_modal_transferencia").val()==5){
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

function carregarComboEmpresaTransferencia(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);   
   
    carregarComboAjax($("#empresas_pk_transferencia"), arrCarregar, "", "pk", "ds_razao_social");
}
$(document).ready(function(){
    //RECEITA
 
    $(document).on('click', '#cmdIncluirTransferencia', fcAbrirFormTransferencia);

    $("#tipo_grupo_pk_transferencia").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposTransferencia();   
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#tipo_grupo_centro_custo_pk_transferencia").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposCentroCustoTransferencia();    
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#empresa_modal_transferencia_pk").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarContaBancariaTransferencia();  
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $(".recebido_de_pago_para").html("Recebido de ?:");
    $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
    $("#tipo_lancamento_modal_transferencia").change(function(){ 
        if($("#tipo_lancamento_modal_transferencia").val()==1){
            $(".recebido_de_pago_para").html("Recebido de ?:");
            $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
        }
        else{
            $(".recebido_de_pago_para").html("Pago para ?:");
            $(".metodo_recebimento_pagamento").html("Método de Pagamento:");
        }
        
    });
    //carregarComboEmpresaTransferencia();
    
    fcListarTipoCategoriaTransferencia();  
    
    fcListarContaBancariaTransferencia();
    
    fcListarMetodosPagamentoTransferencia();


    //faz a carga inicial do grid.
    fcCarregarGridTransferencia();
    
    //$("#loader").show();
    //$("#exibir").hide();
    
    var today = new Date();
    var mm = today.getMonth()+1; //January is 0!
    
    setTimeout(function(){
   
       if(mm==1){
            $("#ic_jan").trigger("click");
        }
        else if(mm==2){
            $("#ic_fev").trigger("click");
        }
        else if(mm==3){
            $("#ic_mar").trigger("click");
        }
        else if(mm==4){
            $("#ic_abr").trigger("click");
        }
        else if(mm==5){
            $("#ic_mai").trigger("click");
        }
        else if(mm==6){
            $("#ic_jun").trigger("click");
        }
        else if(mm==7){

            $("#ic_jul").trigger("click");
        }
        else if(mm==8){
            $("#ic_ago").trigger("click");
        }
        else if(mm==9){
            $("#ic_set").trigger("click");
        }
        else if(mm==10){
            $("#ic_out").trigger("click");
        }
        else if(mm==11){
            $("#ic_nov").trigger("click");
        }
        else if(mm==12){
            $("#ic_dez").trigger("click");
        } 
    }, 500);
    
    
   
    
    fcValidarFormTransferencia();
  
    
    
    $('#dt_vencimento_transferencia').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_vencimento_transferencia").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_competencia_transferencia').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_competencia_transferencia").keypress(function(){
       mascara(this,mdata);
    });
    $("#vl_lancamento_transferencia").keypress(function(){
       mascara(this,moeda);
    });
    
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisarTransferencia);
    $(document).on('click', '#cmdIncluir', fcIncluirTransferencia);

});