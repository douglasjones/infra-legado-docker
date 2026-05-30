var tblResultadoItens;

function fcValidarForm(){

    if($("#tipo_grupo_pk").val()==''){
        alert('Por favor, selecione o campo Grupo de Origem Lançamento!');
        return false;        
    }
    if($("#tipo_grupo_pk option:selected").val()==1){
        if($("#leads_clientes_pk").val()==''){
            alert('Por favor, selecione o campo Pago para\ Recebido de!');
            return false;        
        }
    }else if($("#tipo_grupo_pk option:selected").val()==2){
        if($("#colaborador_pk").val()==''){
            alert('Por favor, selecione o campo Pago para\ Recebido de!');
            return false;        
        }
    }else if($("#tipo_grupo_pk option:selected").val()==3){
        if($("#fornecedor_pk").val()==''){
            alert('Por favor, selecione o campo Pago para\ Recebido de!');
            return false;        
        }
    }

    if($("#ds_ano_vigente_teto").val()==''){
        alert('Por favor, selecione o campo Ano de vigência Teto!');
        return false;        
    }

    if($("#vl_total_teto").val()==''){
        alert('Por favor, informe o campo Vl Total Teto!');
        return false;        
    }

    if($("#ic_status").val()==''){
        alert('Por favor, informe o campo Status!');
        return false;        
    }
    fcEnviar();
}

function fcEnviar(){
    var v_grupo_lancamento_centro_custo_pk = "";
    var v_grupo_leancamento_pk = "";
    var v_tipo_grupo_pk = $("#tipo_grupo_pk").val();

    if(v_tipo_grupo_pk == 2){
        v_grupo_lancamento_centro_custo_pk =  $("#grupo_lancamento_centro_custo_colaborador_pk").val()
    }else if(v_tipo_grupo_pk == 3){
        v_grupo_lancamento_centro_custo_pk = $("#grupo_lancamento_centro_custo_fornecedor_pk").val()
    }

    if (v_tipo_grupo_pk == 1) {
        v_grupo_leancamento_pk = $("#leads_clientes_pk").val();
    } else if (v_tipo_grupo_pk == 2) {
        v_grupo_leancamento_pk = $("#colaborador_pk").val();
    } else if (v_tipo_grupo_pk == 3) {
        v_grupo_leancamento_pk = $("#fornecedor_pk").val();
    } 

    var objParametros = {
        "pk":  pk,
        "tipo_grupo_pk":  v_tipo_grupo_pk,
        "grupo_leancamento_pk": v_grupo_leancamento_pk,
        "leads_posto_trabalho_pk": $("#leads_posto_trabalho_pk").val(),
        "contratos_pk": $("#leads_contratos_pk").val(),
        "colaborador_posto_trabalho_pk":  $("#colaborador_posto_trabalho_pk").val(),
        "colaborador_contratos_pk":  $("#colaborador_contratos_pk").val(),
        "fornecedor_posto_trabalho_pk": $("#fornecedor_posto_trabalho_pk").val(),
        "fornecedor_contratos_pk": $("#fornecedor_contratos_pk").val(),
        "ic_status": $("#ic_status").val(),
        "obs": $("#obs").val(),
        "vl_total_teto": $("#vl_total_teto").val(),
        "vl_utilizado_atual": $("#vl_utilizado_atual").val(),
        "ds_ano_vigente_teto": $("#ds_ano_vigente_teto").val(),
        "grupo_lancamento_centro_custo_pk": v_grupo_lancamento_centro_custo_pk          
    };    

    var arrEnviar = carregarController("teto_gastos", "salvar", objParametros); 
    
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert(arrEnviar.message);
        $("#informacoesItens").show()
        $("#pk").val(arrEnviar.data[0]['pk'])
        if(pk !== ''){
            tblResultadoItens.destroy();
        }
        fcCarregarGrid();
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcValidarItensForm(){

    if($("#tipos_operacao_pk").val()==''){
        alert('Por favor, selecione o campo Tipo de Lançamento!');
        return false;        
    }
    if($("#categoria_operacao_pk").val()==''){
        alert('Por favor, selecione o campo Categoria(s)!');
        return false;    
    }
    if($("#operacao_pk").val()==''){
        alert('Por favor, selecione o campo Planos de Conta!');
        return false;    
    }
    if($("#dt_ini_teto").val()==''){
        alert('Por favor, selecione o campo Dt Ini Validade Teto!');
        return false;    
    }
    if($("#dt_fim_teto").val()==''){
        alert('Por favor, selecione o campo Dt fim Validade Teto!');
        return false;    
    }
    if($("#vl_teto_anual").val()==''){
        alert('Por favor, selecione o campo Vl Teto Anual!');
        return false;    
    }
    fcEnviarItens();
}

function fcEnviarItens(){
    try{
        var objParametros = {
            "ic_status": $("#ic_status").val(),    
            "teto_gastos_pk": $("#pk").val(),  
            "tipos_operacao_pk":  $("#tipos_operacao_pk").val(),
            "categoria_operacao_pk":  $("#categoria_operacao_pk").val(),
            "operacao_pk": $("#operacao_pk").val(),
            "dt_ini_teto": $("#dt_ini_teto").val(),
            "dt_fim_teto":  $("#dt_fim_teto").val(),
            "vl_teto_anual":  $("#vl_teto_anual").val(),
            "vl_teto_mensal": $("#vl_teto_mensal").val(),
            "obs": $("#obs_teto_itens").val()    
        };    
    
        var arrEnviar = carregarController("teto_gastos_itens", "salvar", objParametros);  
        
        if (arrEnviar.result == 'success'){
            if(arrEnviar.data[0]['mensagem_erro'] == ''){
                // Reload datable
                alert(arrEnviar.message); 
                tblResultadoItens.destroy();
                fcCarregarGrid();
                $("#tipos_operacao_pk").val("")
                $("#categoria_operacao_pk").val("")
                $("#operacao_pk").val("")
                $("#dt_ini_teto").val("")
                $("#dt_fim_teto").val("")
                $("#vl_teto_anual").val("")
                $("#vl_teto_mensal").val("")
                $("#obs_teto_itens").val("")
            }else{
                alert(arrEnviar.data[0]['mensagem_erro'])
            }
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }
    }catch(e){
        alert(e)
    }
   
}

function fcCarregarGrid(){
    
    var objParametros = {
        "teto_gastos_pk": $("#pk").val()
    };

    var v_url = montarUrlController("teto_gastos_itens", "listarDataTable", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblResultadoItens = $('#tblResultadoItens').DataTable({
        "scrollX": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a title='Incluir' class='function_delete_item'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
                //"defaultContent": "<a title='Editar' class='function_edit'><span><img width=16 height=16 src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a title='Incluir' class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
            {"targets": -2, "data": "t_vl_teto_mensal"},
            {"targets": -3, "data": "t_vl_teto_anual"},
            {"targets": -4, "data": "t_dt_fim_teto"},
            {"targets": -5, "data": "t_dt_ini_teto"},
            {"targets": -6, "data": "t_categoria_operacao_pk"},
            {"targets": -7, "data": "t_tipos_operacao_pk"},
            {"targets": -8, "data": "t_operacao_pk"},
            {"targets": -9, "data": "t_pk"}

        ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });

    //Atribui os eventos na coluna ação.
    $('#tblResultadoItens tbody').on('click', '.function_edit', function () {
        var data;
        if(tblResultadoItens.row( $(this).parents('li')).data()){
            data = tblResultadoItens.row( $(this).parents('li')).data();
        }
        else if(tblResultadoItens.row( $(this).parents('tr')).data()){
            data = tblResultadoItens.row( $(this).parents('tr')).data();
        }
        fcEditar(data['t_pk']);

    } );

    $('#tblResultadoItens tbody').on('click', '.function_delete_item', function () {
        var data;
        if(tblResultadoItens.row( $(this).parents('li') ).data()){
            data = tblResultadoItens.row( $(this).parents('li') ).data();
        }
        else if(tblResultadoItens.row( $(this).parents('tr') ).data()){
            data = tblResultadoItens.row( $(this).parents('tr') ).data();
        }
        fcExcluirItem(data['t_pk']);
    } );
}

function fcExcluirItem(v_pk){
    if (confirm("Deseja realmente excluir o registro '" + v_pk + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("teto_gastos_itens", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultadoItens.destroy();
                fcCarregarGrid()

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

function fcCancelar(){
    sendPost("teto_gasto_res_form.php", {token: token});
}

function fcCarregar(){

    if(pk > 0){

        $("#informacoesItens").show();
        $("#pk").val(pk);

        var objParametros = {
            "pk": pk
        };  
        
        var arrCarregar = carregarController("teto_gastos", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
            $("#div_clientes").hide();
            $("#div_colaborador").hide();
            $("#div_fornecedor").hide();
        
            var tipo_grupo_pk = arrCarregar.data[0]['tipo_grupo_pk']
            $("#tipo_grupo_pk").val(tipo_grupo_pk);
            
            if(tipo_grupo_pk=='1'){        
                $("#div_clientes").show();
                fccarregarLeadsClientes();
                $("#leads_clientes_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
                if(arrCarregar.data[0]['leads_posto_trabalho_pk'] != null){
                    fccarregarLeadsPostosTrabalho();
                    $("#leads_posto_trabalho_pk").val(arrCarregar.data[0]['leads_posto_trabalho_pk']);
                }
                if(arrCarregar.data[0]['contratos_pk'] != null){
                    fccarregarLeadsContratos();
                    $("#leads_contratos_pk").val(arrCarregar.data[0]['contratos_pk']);
                }
            }else if(tipo_grupo_pk=='2'){
                $("#div_colaborador").show();
                fccarregarColaborador()
                $("#colaborador_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
                if(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk'] != null){
                    fccarregarLeadsClientesCentroCusto()
                    $("#grupo_lancamento_centro_custo_colaborador_pk").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk']);
                }
                if(arrCarregar.data[0]['leads_posto_trabalho_pk'] != null){
                    fccarregarColaboradorPostosTrabalho();
                    $("#colaborador_posto_trabalho_pk").val(arrCarregar.data[0]['leads_posto_trabalho_pk']);
                }
                if(arrCarregar.data[0]['contratos_pk'] != null){
                    fccarregarColaboradorContratos()
                    $("#colaborador_contratos_pk").val(arrCarregar.data[0]['contratos_pk']);
                }
            }else if(tipo_grupo_pk=='3'){
                $("#div_fornecedor").show();
                fccarregarFornecedor();
                $("#fornecedor_pk").val(arrCarregar.data[0]['grupo_leancamento_pk']);
                if(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk'] != null){
                    fccarregarLeadsClientesCentroCustoForncedor();
                    $("#grupo_lancamento_centro_custo_fornecedor_pk").val(arrCarregar.data[0]['grupo_lancamento_centro_custo_pk']);
                }
                if(arrCarregar.data[0]['leads_posto_trabalho_pk'] != null){
                    fccarregarFornecedorPostosTrabalho();
                    $("#fornecedor_posto_trabalho_pk").val(arrCarregar.data[0]['leads_posto_trabalho_pk']);
                }
                if(arrCarregar.data[0]['contratos_pk'] != null){
                    fccarregarFornecedorContratos();
                    $("#fornecedor_contratos_pk").val(arrCarregar.data[0]['contratos_pk']);
                }
            }

            $("#ds_ano_vigente_teto").val(arrCarregar.data[0]['ds_ano_vigente_teto']);
            $("#vl_total_teto").val(arrCarregar.data[0]['vl_total_teto']);
            $("#vl_utilizado_atual").val(arrCarregar.data[0]['vl_utilizado_atual']);
            $("#ic_status").val(arrCarregar.data[0]['ic_status']);
            $("#obs").val(arrCarregar.data[0]['obs']);
            fcCarregarGrid();

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}

function fccarregarLeadsClientes() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#leads_clientes_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsPostosTrabalho() {
    var objParametros = {
        "pk": $("#leads_clientes_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaLeadsPostosTrabalho", objParametros);
    carregarComboAjax($("#leads_posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarLeadsContratos() {
    var objParametros = {
        "leads_pk": $("#leads_posto_trabalho_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    carregarComboAjax($("#leads_contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaboradorContratos() {
    var objParametros = {
        "leads_pk": $("#colaborador_posto_trabalho_pk").val(),
        "colaborador_pk": $("#colaborador_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaColaboradorContratos", objParametros);
    carregarComboAjax($("#colaborador_contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarColaborador() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("colaborador", "listaColaborador", objParametros);
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");
}

function fccarregarLeadsClientesCentroCusto() {
    var objParametros = {
        "colaborador_pk": $("#colaborador_pk").val()
    };
    var arrCarregar = carregarController("lead", "listarClienteColaborador", objParametros);
    carregarComboAjax($("#grupo_lancamento_centro_custo_colaborador_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarColaboradorPostosTrabalho() {

    var objParametros = {
        "colaborador_pk": $("#colaborador_modal_pk").val(),
        "leads_pk": $("#grupo_lancamento_centro_custo_colaborador_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaColaboradorPostosTrabalho", objParametros);
    carregarComboAjax($("#colaborador_posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("fornecedor", "listarTodos", objParametros);
    carregarComboAjax($("#fornecedor_pk"), arrCarregar, " ", "pk", "ds_fornecedor");
}

function fccarregarLeadsClientesCentroCustoForncedor() {
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listaLeadsClientes", objParametros);
    carregarComboAjax($("#grupo_lancamento_centro_custo_fornecedor_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedorPostosTrabalho() {
    var objParametros = {
        "leads_pk": $("#grupo_lancamento_centro_custo_fornecedor_pk").val()
    };
    var arrCarregar = carregarController("lead", "listaFornecedorPostosTrabalho", objParametros);
    carregarComboAjax($("#fornecedor_posto_trabalho_pk"), arrCarregar, " ", "pk", "ds_lead");
}

function fccarregarFornecedorContratos() {
    var objParametros = {
        "leads_pk": $("#fornecedor_posto_trabalho_pk").val()
    };
    var arrCarregar = carregarController("contrato", "listaLeadContratos", objParametros);
    carregarComboAjax($("#fornecedor_contratos_pk"), arrCarregar, " ", "pk", "ds_contrato");
}

function fccarregarCategoriaoperacao() {
    var objParametros = {

    };
    var arrCarregar = carregarController("categoria_financeira", "listarTodos", objParametros);
    carregarComboAjax($("#categoria_operacao_pk"), arrCarregar, " ", "pk", "ds_categoria");
}

function fccarregarTipoPlanoNegocio() {
    var objParametros = {
        "categorias_financeiras_pk": $("#categoria_operacao_pk").val()
    };
    var arrCarregar = carregarController("plano_contas", "listaPorCategoria", objParametros);
    carregarComboAjax($("#operacao_pk"), arrCarregar, " ", "pk", "ds_tipo_operacao");
}

function fcSelecionaGrupo() {

    if ($("#tipo_grupo_pk").val() == 1) {
        fccarregarLeadsClientes();
        $("#div_clientes").show();
        $("#div_colaborador").hide();
        $("#div_fornecedor").hide();
    } else if ($("#tipo_grupo_pk").val() == 2) {
        fccarregarColaborador();
        $("#div_clientes").hide();
        $("#div_colaborador").show();
        $("#div_fornecedor").hide();
    } else if ($("#tipo_grupo_pk").val() == 3) {
        fccarregarFornecedor();
        fccarregarLeadsClientesCentroCustoForncedor();
        $("#div_clientes").hide();
        $("#div_colaborador").hide();
        $("#div_fornecedor").show();
    } else if ($("#tipo_grupo_pk").val() == '') {
        $("#div_clientes").hide();
        $("#div_colaborador").hide();
        $("#div_fornecedor").hide();
    }
}

/*function fcExcluir(v_pk, v_tipo_origem_teto_gastos){

    if (confirm("Deseja realmente excluir o registro '" + v_tipo_origem_teto_gastos + "'?")){
        if(v_pk != ""){

            var objParametros = {
                "pk": v_pk
            };

            var arrExcluir = carregarController("teto_gasto", "excluir", objParametros);

            if (arrExcluir.result == 'success'){

                //Exibe a mensagem
                alert(arrExcluir.message);

                // Reload datable
                tblResultado.ajax.reload();

            }
            else{
                alert('Falhou a requisição de exclusão.');
            }
        }
        else{
            alert("Código não encontrado");
        }
    }
}*/

$(document).ready(function(){

        $('#dt_ini_teto').datepicker({
            startDate: 0,
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked"
        });
    
        $("#dt_ini_teto").keypress(function () {
            mascara(this, mdata);
        });

        $('#dt_fim_teto').datepicker({
            startDate: 0,
            defaultDate: "getDate()",
            dateFormat: 'dd/mm/yyyy',
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked"
        });
    
        $("#dt_fim_teto").keypress(function () {
            mascara(this, mdata);
        });

        $("#vl_teto_anual").keypress(function () {
            mascara(this, moeda);
        });

        $("#vl_teto_mensal").keypress(function () {
            mascara(this, moeda);
        });

        $("#vl_total_teto").keypress(function () {
            mascara(this, moeda);
        });

        $("#vl_utilizado_atual").keypress(function () {
            mascara(this, moeda);
        });

        fccarregarCategoriaoperacao()
        $("#categoria_operacao_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarTipoPlanoNegocio();
        });

        $("#tipo_grupo_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fcSelecionaGrupo();
        });

        //Carrega Combos 
        $("#leads_clientes_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsPostosTrabalho();
        });
    
        $("#leads_posto_trabalho_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsContratos();
        });

        //Selecionar tipo de origem para teto
        $("#tipo_origem_teto_gastos").change(function () {
            fcCarrgaComboOrigem()
        });

        
        $("#colaborador_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarLeadsClientesCentroCusto();
            fccarregarColaboradorPostosTrabalho();
        });

        $("#grupo_lancamento_centro_custo_colaborador_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarColaboradorPostosTrabalho();
        });

        $("#colaborador_posto_trabalho_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarColaboradorContratos()
        });

        $("#grupo_lancamento_centro_custo_fornecedor_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarFornecedorPostosTrabalho();
        });

        $("#fornecedor_posto_trabalho_pk").change(function () {
            $(".chzn-select").chosen('destroy');
            fccarregarFornecedorContratos()
        });

        //Atribui os eventos
        $(document).on('click', '#cmdCancelar', fcCancelar);
        $(document).on('click', '#cmdEnviarTetoGastos', fcValidarForm);
        $(document).on('click', '#cmdIncluirItem', fcValidarItensForm);

        //Verifica se o registro é para alteracao e puxa os dados.
        fcCarregar();
});
