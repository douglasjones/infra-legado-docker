var tblReceita;
function fcPesquisarReceita(){
	
    tblReceita.clear().destroy();
    fcCarregarGrid();
    
}

function fcIncluirReceita(){

    sendPost('inc_receita_cad_form.php',{token: token, pk: ''});

}

function fcExcluirReceita(v_pk, v_dt_vencimento){

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
                tblReceita.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
        
    }
    return false;
}
function fcLimparVariavelReceita(){
    $("#lancamento_receita_pk").val("");
    $("#dt_vencimento_receita").val("");
    $("#ds_lancamento_receita").val("");
    $("#vl_lancamento_receita").val("");
    $("#tipo_grupo_pk_receita").val("");
    $("#grupo_leancamento_pk_receita").val("");
    $("#ic_status_pagamento_receita").val("");
    $("#dt_competencia_receita").val("");
    $("#n_documento_receita").val("");
    $("#tipos_operacao_pk_receita").val("");
    $("#metodos_pagamento_pk_receita").val("");
    $("#contas_bancarias_pk_receita").val("");
    $("#tipo_grupo_centro_custo_pk_receita").val("");
    $("#grupo_lancamento_centro_custo_pk_receita").val("");
    $("#ds_ocorrencia_receita").val("");
    $("#tipo_lancamento_modal_receita_pk").val("");
}
function fcEditarReceita(obj){
     fcLimparVariavelReceita();
    
    $("#tipo_lancamento_modal_receita_pk").val(obj['t_operacao_pk']);
    $("#lancamento_receita_pk").val(obj['t_pk']);
    $("#dt_vencimento_receita").val(obj['t_dt_vencimento']);
    $("#ds_lancamento_receita").val(obj['t_ds_lancamento']);
    $("#vl_lancamento_receita").val(float2moeda(obj['t_vl_lancamento']));
    $("#tipo_grupo_pk_receita").val(obj['t_tipo_grupo_pk']);
    $("#empresas_pk_receita").val(obj['t_empresas_pk']);
    fcListarItensGruposReceita();
    $("#grupo_leancamento_pk_receita").val(obj['t_grupo_leancamento_pk']);
    $("#ic_status_pagamento_receita").val(obj['t_ic_status_pagamento']);
    $("#dt_competencia_receita").val(obj['t_dt_competencia']);
    $("#n_documento_receita").val(obj['t_n_documento']);
    $("#tipos_operacao_pk_receita").val(obj['t_tipos_operacao_pk']);
    $("#metodos_pagamento_pk_receita").val(obj['t_metodos_pagamento_pk']);

    fcListarContaBancariaReceita(obj['t_empresas_pk']);

    $("#contas_bancarias_pk_receita").val(obj['t_contas_bancarias_pk']);
    
    $("#tipo_grupo_centro_custo_pk_receita").val(obj['tipo_grupo_centro_custo_pk']);

    $("#empresa_modal_receita_pk").val(obj['t_empresas_pk']);
    fcListarItensGruposCentroCustoReceita();
    $("#grupo_lancamento_centro_custo_pk_receita").val(obj['grupo_lancamento_centro_custo_pk']);
    //$("#ds_ocorrencia_receita").val(obj['ds_ocorrencia']);
    
    $("#modal_receita").modal();
    $(".chzn-select").chosen('destroy');
}

function fcCarregarGridReceita(){

    
    var objParametros = {
        "dt_vencimento_ini": primeiroDia,
        "dt_vencimento_fim": ultimoDia,
        "contas_bancarias_pk":$("#contas_pk").val()
    };     
    
   // var v_url = montarUrlController("lancamento", "listarReceita", objParametros);
    var v_url = montarUrlController("lancamento", "listarLancamentosMes", objParametros);
   //alert(v_url);
    //Trata a tabela
    tblReceita = $('#tblReceita').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_opcoes'><span><img width=16 height=16 src='../img/excluir.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=18 height=18 src='../img/relatorio.jpg' title='Documentos'></span></a>"
            },
           {"targets": -2, "data": "t_ds_status_pagamento"},
           {"targets": -3, "data": "t_ds_tipo_operacao"},
           {"targets": -4, "data": "t_ds_tipo_grupo"},
           {"targets": -5, "data": "t_vl_lancamento"},
           {"targets": -6, "data": "t_ds_lancamento"},
           {"targets": -7, "data": "t_dt_vencimento"},
           {"targets": -8, "data": "t_ds_recebido_de_centro_custo"},
           {"targets": -9, "data": "t_ds_operacao"},
           {"targets": -10, "data": "t_ds_razao_social"},
           {"targets": -11, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    
    
    //Atribui os eventos na coluna ação.
    $('#tblReceita tbody').on('click', '.function_edit', function () {
        var data;
        if(tblReceita.row( $(this).parents('li')).data()){
            data = tblReceita.row( $(this).parents('li')).data();
        }
        else if(tblReceita.row( $(this).parents('tr')).data()){
            data = tblReceita.row( $(this).parents('tr')).data();
        }

        fcEditarReceita(data);
        
    } );   
    
    $('#tblReceita tbody').on('click', '.function_opcoes', function () {
        var data;
        
        if(tblReceita.row( $(this).parents('li') ).data()){
            data = tblReceita.row( $(this).parents('li') ).data();
        }
        else if(tblReceita.row( $(this).parents('tr') ).data()){
            data = tblReceita.row( $(this).parents('tr') ).data();
        }
        
       
        fcExcluirReceita(data['t_pk'], data['t_ds_lancamento']);
    } );   
    
    $('#tblReceita tbody').on('click', '.function_painel', function () {
        var data;
        if(tblReceita.row( $(this).parents('li') ).data()){
            data = tblReceita.row( $(this).parents('li') ).data();
        }
        else if(tblReceita.row( $(this).parents('tr') ).data()){
            data = tblReceita.row( $(this).parents('tr') ).data();
        }
        fcAbrirModalDocs(data['t_pk'])
    } );            
    
}
function fcAbrirFormReceita(){
    //limpa os dados de qualquer registro existe
    fcLimparVariavelReceita();
    $(".chzn-select").chosen('destroy');
    
    $("#modal_receita").modal();
    
    $(".chzn-select").chosen({allow_single_deselect: true});
}

function fcListarItensGruposReceita(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_pk_receita").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_lead");    
    }else if($("#tipo_grupo_pk_receita").val()==2){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_colaborador");   
    }else if($("#tipo_grupo_pk_receita").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_leancamento_pk_receita"), arrCarregar, " ", "pk", "ds_fornecedor");   
    }
}
function fcListarItensGruposCentroCustoReceita(){

    var objParametros = {
        "tipo_grupo_pk": ""
    };          
    if($("#tipo_grupo_centro_custo_pk_receita").val()==1){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoLeads", objParametros); 
       
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_lead"); 
        
    }else if($("#tipo_grupo_centro_custo_pk_receita").val()==2){
        
        var arrCarregar = carregarController("lancamento", "listaItensGrupoColaboradores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_colaborador");   
        
    }else if($("#tipo_grupo_centro_custo_pk_receita").val()==3){
        var arrCarregar = carregarController("lancamento", "listaItensGrupoFornecedores", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_fornecedor");  
        
    }
    else if($("#tipo_grupo_centro_custo_pk_receita").val()==4){
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);    
        carregarComboAjax($("#grupo_lancamento_centro_custo_pk_receita"), arrCarregar, " ", "pk", "ds_equipe");   
    }
}
function fcListarContaBancariaReceita(){

    var objParametros = {
        "empresas_pk": $("#empresa_modal_receita_pk").val()
    };          
    var arrCarregar = carregarController("conta_bancaria", "listarContasLancamento", objParametros);    

    carregarComboAjax($("#contas_bancarias_pk_receita"), arrCarregar, " ", "pk", "ds_dados_conta");    
    
}

function fcListarTipoCategoriaReceita(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_receita"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}
function fcListarMetodosPagamentoReceita(){

    var objParametros = {
        "pk": ""
    };          
   
    var arrCarregar = carregarController("metodo_pagamento", "listarTodos", objParametros);   

    carregarComboAjax($("#metodos_pagamento_pk_receita"), arrCarregar, " ", "pk", "ds_metodo_pagamento");    
   
}
function fcListarTipoCategoriaReceita(){

    var objParametros = {
        "categorias_financeiras_pk": 2
    };          
   
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);   
 
    carregarComboAjax($("#tipos_operacao_pk_receita"), arrCarregar, " ", "pk", "ds_tipo_operacao");    
   
}


function fcValidarFormReceita(){

    $("#form").validate({
        rules :{
            

        },
        messages:{
        },
        submitHandler: function(form){
            fcEnviarReceita(); //Se a validação deu certo, faz o envio do formulario.
            return false;
        }
    });

}
function fcEnviarReceita(){
    
    if($('#tipo_lancamento_modal_receita_pk').val()==""){
        $("#alert_tipo_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_lancamento").slideUp(500);
        });
        $('#tipo_lancamento_modal_receita_pk').focus();
        return false;
    }
    if($('#tipos_operacao_pk_receita').val()==""){
        $("#alert_tipo_operacao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_operacao").slideUp(500);
        });
        $('#tipos_operacao_pk_receita').focus();
        return false;
    }
    if($('#ds_lancamento_receita').val()==""){
        $("#alert_ds_lancamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_lancamento").slideUp(500);
        });
        $('#ds_lancamento_receita').focus();
        return false;
    }
    if($('#tipo_grupo_pk_receita').val()==""){
        $("#alert_tipo_grupo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_grupo").slideUp(500);
        });
        $('#tipo_grupo_pk_receita').focus();
        return false;
    }
    if($('#vl_lancamento_receita').val()==""){
        $("#alert_valor").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_valor").slideUp(500);
        });
        $('#vl_lancamento_receita').focus();
        return false;
    }
    if($('#metodos_pagamento_pk_receita').val()==""){
        $("#alert_metodo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_metodo").slideUp(500);
        });
        $('#metodos_pagamento_pk_receita').focus();
        return false;
    }
    if($('#dt_vencimento_receita').val()==""){
        $("#alert_dt_vencimento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_vencimento").slideUp(500);
        });
        $('#dt_vencimento_receita').focus();
        return false;
    }
    
    
    
    if($('#contas_bancarias_pk_receita').val()==""){
        $("#alert_banco").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_banco").slideUp(500);
        });
        $('#contas_bancarias_pk_receita').focus();
        return false;
    }
    if($('#ic_status_pagamento_receita').val()==""){
        $("#alert_status").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_status").slideUp(500);
        });
        $('#ic_status_pagamento_receita').focus();
        return false;
    }
    


    
    var objParametros = {
        "pk": $("#lancamento_receita_pk").val(),
        "dt_vencimento": $("#dt_vencimento_receita").val(),
        "ds_lancamento": $("#ds_lancamento_receita").val(),
        "vl_lancamento": moeda2float($("#vl_lancamento_receita").val()),
        "tipo_grupo_pk": $("#tipo_grupo_pk_receita").val(),
        "grupo_leancamento_pk": $("#grupo_leancamento_pk_receita").val(),
        "ic_status_pagamento": $("#ic_status_pagamento_receita").val(),
        "dt_competencia": $("#dt_competencia_receita").val(),
        "n_documento": $("#n_documento_receita").val(),
        "tipos_operacao_pk": $("#tipos_operacao_pk_receita").val(),
        "metodos_pagamento_pk": $("#metodos_pagamento_pk_receita").val(),
        "contas_bancarias_pk": $("#contas_bancarias_pk_receita").val(),
        "empresas_pk": $("#empresa_modal_receita_pk").val(),
        "tipo_grupo_centro_custo_pk": $("#tipo_grupo_centro_custo_pk_receita").val(),
        "grupo_lancamento_centro_custo_pk": $("#grupo_lancamento_centro_custo_pk_receita").val(),
        //"ds_ocorrencia": $("#ds_ocorrencia_receita").val(),
        "operacao_pk": $("#tipo_lancamento_modal_receita_pk").val()    
    };    

    var arrEnviar = carregarController("lancamento", "salvar", objParametros);   
    
      
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
            $("#modal_receita").modal("hide");
            $("select[id='empresas_pk']").val($("#empresa_modal_receita_pk").val());
            $("#empresas_pk").val($("#empresa_modal_receita_pk").val());
            
            $("select[id='contas_pk']").val($("#contas_bancarias_pk_receita").val());
            $("#contas_pk").val($("#contas_bancarias_pk_receita").val());
            
            //FATURAMENTO 
            fcDatasCaleandario($("#ic_mes").val(),$("#ds_ano").val());
          
            setTimeout(function(){
                tblReceita.clear().destroy();
               
                fcCarregarGridReceita();


                fcCarregarGraficoLinha();
            }, 500);
            
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function carregarComboEmpresaReceita(){
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("conta", "listarPk", objParametros);   
   
    carregarComboAjax($("#empresas_pk_receita"), arrCarregar, "", "pk", "ds_razao_social");
}
$(document).ready(function(){
    //RECEITA
 
    $(document).on('click', '#cmdIncluirReceita', fcAbrirFormReceita);

    $("#tipo_grupo_pk_receita").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposReceita();   
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#tipo_grupo_centro_custo_pk_receita").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarItensGruposCentroCustoReceita();    
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    $("#empresa_modal_receita_pk").change(function(){ 
        $(".chzn-select").chosen('destroy');
        fcListarContaBancariaReceita();  
        $(".chzn-select").chosen({allow_single_deselect: true});
    });
    
    $(".recebido_de_pago_para").html("Recebido de ?:");
    $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
    $("#tipo_lancamento_modal_receita_pk").change(function(){ 
        if($("#tipo_lancamento_modal_receita_pk").val()==1){
            $(".recebido_de_pago_para").html("Recebido de ?:");
            $(".metodo_recebimento_pagamento").html("Método de Recebimento:");
        }
        else{
            $(".recebido_de_pago_para").html("Pago para ?:");
            $(".metodo_recebimento_pagamento").html("Método de Pagamento:");
        }
        
    });
    //carregarComboEmpresaReceita();
    
    fcListarTipoCategoriaReceita();  
    
    //fcListarContaBancariaReceita(); 
    
    fcListarMetodosPagamentoReceita();


    //faz a carga inicial do grid.
    fcCarregarGridReceita();
    
    fcValidarFormReceita();
  
    
    
    $('#dt_vencimento_receita').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_vencimento_receita").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_competencia_receita').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() );  
    $("#dt_competencia_receita").keypress(function(){
       mascara(this,mdata);
    });
    $("#vl_lancamento_receita").keypress(function(){
       mascara(this,moeda);
    });
    
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
    
    
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisarReceita);
    $(document).on('click', '#cmdIncluir', fcIncluirReceita);

});


