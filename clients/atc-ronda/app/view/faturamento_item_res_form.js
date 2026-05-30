
function fcDetalhar(v_pk){
    sendPost('faturamento_item_cad_form.php', {token: token, pk: v_pk});
}

function fcCarregarCargaHoraria(linhas){
    $('.carga_hr_dia_pk_'+linhas).append('<option></option>')
    for(var i=1; i<=12; i++){
        $('.carga_hr_dia_pk_'+linhas).append('<option>'+i+'</option>')
    }
    $('.carga_hr_dia_pk_'+linhas).append('<option>24</option>')
}

function fcSalvar(){
try {
    fcSalvarContratos();
    var contratos_pk = $("input[class='contratos_pk']");
    var faturamento_itens_pk = $("input[class='faturamento_itens_pk']");
    var leads_pk = $("input[class='leads_pk']");
    var contas_pk = $("input[class='contas_pk']");
    var vl_total_lancamento = $("input[class='vl_total_contrato']");
    var obs_faturamento = $("textarea[class='obs_faturamento']");
    var obs_corpo_nota = $("textarea[class='obs_corpo_nota']");
    var obs_lancamento = $("textarea[class='obs_lancamento']");

    for(i = 0; i < contratos_pk.length; i++){    
        var objParametros = {
            "pk": faturamento_itens_pk.get(i).value,
            "faturamento_pk": faturamento_pk,
            "contratos_pk": contratos_pk.get(i).value,
            "leads_pk": leads_pk.get(i).value,
            "contas_pk": contas_pk.get(i).value,
            "vl_total_lancamento": vl_total_lancamento.get(i).value,
            "obs_faturamento_contrato": obs_faturamento.get(i).value,
            "obs_corpo_nota": obs_corpo_nota.get(i).value,
            "obs_lancamento": obs_lancamento.get(i).value
        };
        var arrCarregar = carregarController("faturamento_item", "salvar", objParametros);
    }
    if(arrCarregar.result == 'success'){
        alert('Registros salvos com sucesso!')
        sendPost('faturamento_res_form.php', {token: token});
    } 

} catch (error) {
    alert(error)
}
}

function fcCarregarEscalas(linha){
    $('.escala_pk_'+linha).append('<option></option>')
                                    .append('<option>1D</option>')
                                    .append('<option>2D</option>')
                                    .append('<option>3D</option>')
                                    .append('<option>4D</option>')
                                    .append('<option>4x1</option>')
                                    .append('<option>4x2</option>')
                                    .append('<option>5x1</option>')
                                    .append('<option>5x2</option>')
                                    .append('<option>6x1</option>')
                                    .append('<option>12x36</option>')
}

function fcCarregarProdutosServicos(linha){
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);   
    carregarComboAjax($(".produtos_servicos_pk"+linha), arrCarregar, " ", "pk", "ds_produto_servico");  
}

function fcRemoverLinha(id, linhas, contratoPk){
    $("#trContratoItens"+id+"_"+linhas+"_"+contratoPk+"_1").remove().draw();
}

function fcValidarContrato(contratoPk){
    $('#ic_contrato'+contratoPk).html("") 

    if($('#ic_status'+contratoPk).val() == 1){
        $('#ic_contrato'+contratoPk).append("<b>Validado</b>") 
        $('#ic_contrato'+contratoPk+" b").css("color", 'green')

    }else if($('#ic_status'+contratoPk).val() == 2){
        $('#ic_contrato'+contratoPk).append("<b>Pendente Analise</b>") 
        $('#ic_contrato'+contratoPk+" b").css("color", 'red')

    }else if($('#ic_status'+contratoPk).val() == 3){
        $('#ic_contrato'+contratoPk).append("<b>Não Faturar</b>") 
        $('#ic_contrato'+contratoPk+" b").css("color", 'red') 

    }
}

function fcCalcularTotalItens(linha, contratoPk){
    var vl_total_item = $('#n_qtde_colaborador_'+contratoPk+'_'+linha).val() * moeda2float($('#vl_unit_'+contratoPk+'_'+linha).val())
    $('#vl_total_item_'+contratoPk+'_'+linha).val(float2moeda(vl_total_item)) 

    fcCalcularTotal(contratoPk)
}

function fcCalcularTotal(contratoPk){
    var total = 0;
    $('.vl_total_item_'+contratoPk).each(function() {
        total += moeda2float($(this).val());
    }); 
    
    $('#vl_contrato'+contratoPk).val(float2moeda(total));
    $('#vl_total_contrato'+contratoPk).val(total);
    
}

function fcMarcaConta(id){
    if($("#conta"+id).is(":checked") == true) {
        $("#lineContratoFixo"+id).show();
        $("#lineContratoAditivo"+id).show();
        $("#lineContratoServicoExtra"+id).show();
    }else{
        $("#lineContratoFixo"+id).hide();
        $("#lineContratoAditivo"+id).hide();
        $("#lineContratoServicoExtra"+id).hide();
    }
}

function fcMacarTipoContrato(id,icTipoContrato){
    if($("#tipoContratoFixoConta"+id).is(":checked") == true) {
        $("#lineCtfDados"+id+icTipoContrato).show();
    }else{
        $("#lineCtfDados"+id+icTipoContrato).hide();
    }  
}

function fcAbrirDadosContrato(id,contratoPk,icTipoContrato){
    if($("#ContratoFixoLead"+id+"_"+contratoPk+"_"+icTipoContrato).is(":checked") == true) {
        $("#lineCtfDadosItem"+id+"_"+contratoPk+"_"+icTipoContrato).show();
        fcCalcularTotal(contratoPk)
    }else{
        $("#lineCtfDadosItem"+id+"_"+contratoPk+"_"+icTipoContrato).hide();
    }
}

function fcSalvarContratos(){

    var contratos_pk = $("input[class='contratos_pk']");
    var leads_pk = $("input[class='leads_pk']");
    var vl_total_lancamento = $("input[class='vl_total_contrato']");
    var ic_tipo_contrato = $("input[class='ic_tipo_contrato']");
    var obs_corpo_nota = $("textarea[class='obs_corpo_nota']");
    var faturamento_contratos_pk = $("input[class='faturamento_contratos_pk']");
    var ic_status = $("select[class='ic_status']");
    var dt_faturamento = $("input[id='dt_faturamento']");
    var dt_vencimento = $("input[id='dt_vencimento']");

    
    var arrKeys = [];
    arrKeys[0] = "produto_servico_pk";
    arrKeys[1] = "n_qtde_colaborador";
    arrKeys[2] = "vl_unitario_produtos_servicos";
    arrKeys[3] = "ds_periodo";
    arrKeys[4] = "n_qtde_dias_semana";
    arrKeys[5] = "faturamento_contratos_itens_pk";
    
    for(i = 0; i < contratos_pk.length; i++){ 
        var arrDados = []; 
        var v_contratos_pk = contratos_pk.get(i).value  
    
        var produto_servico_pk = $("input[id='produto_servico_pk["+v_contratos_pk+"]']");
        var n_qtde_colaborador = $("input[class='n_qtde_colaborador["+v_contratos_pk+"]']");
        var vl_unitario_produtos_servicos = $("input[class='vl_unitario_produtos_servicos["+v_contratos_pk+"]']");
        var ds_periodo = $("input[id='ds_periodo["+v_contratos_pk+"]']");
        var n_qtde_dias_semana = $("input[id='n_qtde_dias_semana["+v_contratos_pk+"]']");
        var faturamento_contratos_itens_pk = $("input[id='faturamento_contratos_itens_pk["+v_contratos_pk+"]']");
        for(l = 0; l < produto_servico_pk.length; l++){ 
            arrDados[l] = [produto_servico_pk.get(l).value, n_qtde_colaborador.get(l).value, vl_unitario_produtos_servicos.get(l).value, ds_periodo.get(l).value, n_qtde_dias_semana.get(l).value, faturamento_contratos_itens_pk.get(l).value];
        } 

        var arrItens = arrayToJson(arrKeys, arrDados);

        var objParametros = {
            "pk": faturamento_contratos_pk.get(i).value,
            "faturamento_pk": faturamento_pk,
            "contratos_pk": v_contratos_pk,
            "leads_pk": leads_pk.get(i).value,
            "ic_status": ic_status.get(i).value,
            "vl_total_contrato": vl_total_lancamento.get(i).value,
            "obs_corpo_nota_fiscal": obs_corpo_nota.get(i).value,
            "dt_faturamento": dt_faturamento.get(i).value,
            "dt_vencimento": dt_vencimento.get(i).value,
            "arrItens": arrItens,
            "ic_tipo_contrato": ic_tipo_contrato.get(i).value
        };
        carregarController("faturamento_contratos", "salvar", objParametros);
    }
}

function fcAddLinha(id, contratoPk){ 
    try {
        
    var linhas = $("#tbContratoItens"+id+"_"+contratoPk+"_1 tbody tr").length;
    linhas = linhas + linhas;

    $("#tbContratoItens"+id+"_"+contratoPk+"_1 tbody").append("<tr id='trContratoItens"+id+"_"+linhas+"_"+contratoPk+"_1'></tr>")
    $("#trContratoItens"+id+"_"+linhas+"_"+contratoPk+"_1").append("<td><input type='hidden' id='faturamento_contratos_itens_pk["+contratoPk+"]'></td>")
                                                .append("<td><select class='produtos_servicos_pk"+linhas+"' onChange='fcAtribuirProdutosServicos("+linhas+")'></select><input type='hidden' class='produto_servico_input_pk"+linhas+"' id='produto_servico_pk["+contratoPk+"]'></td>")
                                                .append("<td><input type='number' class='n_qtde_colaborador["+contratoPk+"]' id='n_qtde_colaborador_"+contratoPk+"_"+linhas+"' onchange='fcCalcularTotalItens("+linhas+", "+contratoPk+")'></td>")
                                                .append("<td><select onChange='fcAtribuirCargaHoraria("+linhas+")' class='carga_hr_dia_pk_"+linhas+"'></select><input type='hidden' class='ds_periodo"+linhas+"' id='ds_periodo["+contratoPk+"]'></td>")
                                                .append("<td><select onChange='fcAtribuirEscalas("+linhas+")' class='escala_pk_"+linhas+"'></select><input type='hidden' class='n_qtde_dias_semana"+linhas+"' id='n_qtde_dias_semana["+contratoPk+"]'></td>")
                                                .append("<td><input type='text' class='vl_unitario_produtos_servicos["+contratoPk+"]' id='vl_unit_"+contratoPk+"_"+linhas+"' onchange='fcCalcularTotalItens("+linhas+", "+contratoPk+")'  onkeypress='mascara(this, moeda)' value='0'></td>")
                                                .append("<td><input type='text' id='vl_total_item_"+contratoPk+"_"+linhas+"' class='vl_total_item_"+contratoPk+"'  onkeypress='mascara(this, moeda)' value='0,00''></td>")
                                                .append("<td><i id='trash"+id+"_"+linhas+"_"+contratoPk+"' onclick='fcRemoverLinha("+id+", "+linhas+", "+contratoPk+")' width='10px' class='bi bi-trash'></i></td>");
    fcCarregarCargaHoraria(linhas)
    fcCarregarEscalas(linhas)
    fcCarregarProdutosServicos(linhas)
    } catch (error) {
        alert(error)
    }
}

function fcAtribuirProdutosServicos(linhas){
    $(".produto_servico_input_pk"+linhas).val($(".produtos_servicos_pk"+linhas).val())
}

function fcAtribuirEscalas(linhas){
    $(".n_qtde_dias_semana"+linhas).val($(".escala_pk_"+linhas).val())
}

function fcAtribuirCargaHoraria(linhas){
    $(".ds_periodo"+linhas).val($(".carga_hr_dia_pk_"+linhas).val())
}

function fcCarregarDadosFaturamentoUpdate(faturamento_pk){
    try {
        var v_faturamento_pk = faturamento_pk;
        var objParametros = {
            "pk": v_faturamento_pk
        };
        var arrCarregar = carregarController("faturamento", "listarUpdateFaturamento", objParametros);
        if (arrCarregar.result == 'success') {    
            //Dados do Faturamento
    
            $('#dsUsuarioCadastro').append(arrCarregar.data[0].ds_usuario_cadastro);
            $('#dtCadastro').append(arrCarregar.data[0].dt_cadastro);
            $('#dsUsuarioAtualizacao').append(arrCarregar.data[0].ds_usuario_atualizacao);
            $('#dtAtualizacao').append(arrCarregar.data[0].dt_ult_atualizacao);
            $('#pkFaturamento').append(arrCarregar.data[0].pk);
            $('#periodoFaturamento').append("De "+arrCarregar.data[0].dt_faturamento_ini+" Até "+arrCarregar.data[0].dt_faturamento_fim);
            $('#dsStatusFaturamento').append(arrCarregar.data[0].ds_usatus_faturamento);
            $('#dsObs').append(arrCarregar.data[0].obs);
            //Dados Contratos
            var dsContratoFixo = "";
            if(arrCarregar.data[0].ic_contrato_fixo==1){
                dsContratoFixo = "Contratos Fixos";
            }
            var dsContratoAditivos = "";
            if(arrCarregar.data[0].ic_contrato_aditivo==1){
                dsContratoAditivos = "Contratos Aditivos";
            }
            var dsContratoExtras = "";
            if(arrCarregar.data[0].ic_contrato_servico_extra==1){
                dsContratoExtras = "Contratos Aditivos";
            }
            $('#dsTiposContratos').append(dsContratoFixo+"<br>"+dsContratoAditivos+"<br>"+dsContratoExtras );
    
            //Dados Emissões
            var dsFaturas = "";
            if(arrCarregar.data[0].ic_gerar_fatura==1){
                dsFaturas = "Gerar Faturas";
            }
            var dsNF = "";
            if(arrCarregar.data[0].ic_gerar_nota_fiscal==1){
                dsNF = "Gerar Notas Fiscais";
            }    
            var dsBoleto = "";
            if(arrCarregar.data[0].ic_gerar_boleto==1){
                dsBoleto = "Gerar Boletos";
            } 
            $('#dsEmissoes').append(dsFaturas+"<br>"+dsNF+"<br>"+dsBoleto);
            
            //Dados Contas
            var dsContas = "";
            var vhtml = "";
            for(var i=0; i < arrCarregar.data.length; i++){
                $('#composicao_faturamento').append("<div id='container"+i+"' class='row'></div>");  
                $("#container"+i).append("<div id='margin"+i+"' class='col-1'>&nbsp;</div>"); 
                $("#container"+i).append("<div id='size"+i+"' class='col-10'></div>"); 
                $("#size"+i).append("<table width='100%' id='container_table"+i+"'></table>"); 
                for(var j=0; j < arrCarregar.data[i].DadosContas.length; j++){
                    $('#dsContas').append(arrCarregar.data[i].DadosContas[j]['ds_conta']+"<br>");
                    $("#container_table"+j).append("<tr id='tr"+j+"'></tr>"); 
                    $("#tr"+j).append("<td id='td"+j+"'></td>"); 
                    $("#td"+j).append("<i class='bi bi-node-plus' style='font-size:20px; color:blue'></i>&nbsp;")  
                    $("#td"+j).append("<input type='checkbox' onclick='fcMarcaConta("+j+")' id='conta"+j+"' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'> - "+arrCarregar.data[i].DadosContas[j]['ds_conta']);  
                    //CONTRATOS FIXOS
                    if(arrCarregar.data[0].ic_contrato_fixo==1){
                        $("#td"+j).append("<div id='lineContratoFixo"+j+"' style='display:none'></div>");
                        $("#lineContratoFixo"+j).append("<table width='100%' id='tableContratoFixo"+j+"' class='table'></table>");  
                        $("#tableContratoFixo"+j).append("<tr></tr>");
                        $("#tableContratoFixo"+j+" tr").append("<td width='25'>&nbsp</td>");
                        $("#tableContratoFixo"+j+" tr").append("<td id='tdContratoFixo"+j+"'></td>");
                        $("#tdContratoFixo"+j).append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='bi bi-play-fill' style='font-size:20px; color:blue'></i>&nbsp;<input type='checkbox' onclick='fcMacarTipoContrato("+j+",1)' id='tipoContratoFixoConta"+j+"' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'> - Contratos Fixos");  
                        $("#tdContratoFixo"+j).append("<div id='lineCtfDados"+j+"1' style='display:none'></div>");  
                        $("#lineCtfDados"+j+"1").append("<table width='100%' id='tableCtfDados"+j+"1' border=0 class='table'><table>");
                        var vl_total_faturamento = 0.00;
                        for(var h=0; h < arrCarregar.data[i].DadosContratos.length; h++){
                            if(arrCarregar.data[i].DadosContratos[h]['ic_tipo_contrato']==1 && arrCarregar.data[i].DadosContratos[h]['contas_contratos_pk'] == arrCarregar.data[i].DadosContas[j]['contas_pk'] ){ 
                                var contratos_pk = arrCarregar.data[i].DadosContratos[h]['contratos_pk'];
                                $("#tableCtfDados"+j+"1").append("<tr id='trCtfDados"+j+"1"+h+"'></tr>");
                                $("#trCtfDados"+j+"1"+h).append("<td width='35'>&nbsp</td>");
                                $("#trCtfDados"+j+"1"+h).append("<td id='tdCtfDados"+j+"1"+h+"'></td>");
                                $("#tdCtfDados"+j+"1"+h).append("&nbsp;<i class='bi bi-circle-fill' style='font-size:10px; color:blue'></i>")
                                $("#tdCtfDados"+j+"1"+h).append("&nbsp;<input type='checkbox' onclick='fcAbrirDadosContrato("+j+","+contratos_pk+",1)' id='ContratoFixoLead"+j+"_"+contratos_pk+"_1' value='"+contratos_pk+"'> ");
                                $("#tdCtfDados"+j+"1"+h).append("- Lead: "+arrCarregar.data[i].DadosContratos[h]['ds_lead']+" - "+ arrCarregar.data[i].DadosContratos[h]['ds_identificacao_area']);
                                $("#tdCtfDados"+j+"1"+h).append("- <span id='ic_contrato"+contratos_pk+"' align='left'></span>");
                                $("#tdCtfDados"+j+"1"+h).append("<div align='right'> <span id='vl_total_contrato"+j+"_"+h+"' align='right'>R$ </span> </div>");
                                $("#tdCtfDados"+j+"1"+h).append("<div id='lineCtfDadosItem"+j+"_"+contratos_pk+"_1' style='display:none'></div>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='contratos_pk' type='hidden' value='"+contratos_pk+"'>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='vl_total_contrato' id='vl_total_contrato"+contratos_pk+"' type='hidden' value=''>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='leads_pk' type='hidden' value='"+arrCarregar.data[i].DadosContratos[h]['leads_pk']+"'>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='contas_pk' type='hidden' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'>");          
                                $("#tdCtfDados"+j+"1"+h).append("<input class='ic_tipo_contrato' type='hidden' value='"+arrCarregar.data[i].DadosContratos[j]['ic_tipo_contrato']+"'>");          
                                $("#tdCtfDados"+j+"1"+h).append("<input class='faturamento_contratos_pk' type='hidden' value='"+arrCarregar.data[i].DadosContratos[h]['faturamento_contratos_pk']+"'>");        
                                $("#tdCtfDados"+j+"1"+h).append("<input class='faturamento_itens_pk' type='hidden' value='"+arrCarregar.data[i].DadosContratos[h]['faturamento_itens_pk']+"'>");        
                                $("#lineCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<table width='100%' id='tableCtfDadosItem"+j+"_"+contratos_pk+"_1' border='1'  class='table'></table>");
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<tr></tr>");
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1 tr").append("<td></td>");
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1 tr td").append("<table id='containerCtfDadosItem"+j+"_"+contratos_pk+"_1' width='100%' border='0'></table>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<thead></thead>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead tr").append("<th colspan='4' style='text-align:center; margin:10px;background:#f5f5f5'>Composição do Contrato</th>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr id='trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='10%'>Cód Contrato: "+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='20%'>Usuário Cadastro: "+arrCarregar.data[i].DadosContratos[h]['ds_usuario_cadastro_contrato']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='20%'>Dt Cadastro: "+arrCarregar.data[i].DadosContratos[h]['dt_cadastro']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='35%'>Validade do Contrato: De "+arrCarregar.data[i].DadosContratos[h]['dt_inicio_contrato']+" Até "+arrCarregar.data[i].DadosContratos[h]['dt_fim_contrato']+"</td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr id='trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='35%'>Razão Social: "+arrCarregar.data[i].DadosContratos[h]['ds_razao_social']+"</td>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='40%'>CNPJ: "+arrCarregar.data[i].DadosContratos[h]['ds_cpf_cnpj']+"</td>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='40%'>Endereço: "+arrCarregar.data[i].DadosContratos[h]['ds_endereco_lead']+"</td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr><td width='40%' colspan=6><button class='btn btn-primary' onclick='fcAddLinha("+j+","+contratos_pk+")' align='left' >Adicionar Linha</button></td></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<tbody></tbody>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody").append("<tr></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody tr").append("<td colspan='4'></td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody tr td").append("<table width='100%' border='1' class='table table-striped' id='tbContratoItens"+j+"_"+contratos_pk+"_1'></table>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<thead></thead>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead").append("<tr></tr>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Cód</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Serviço Prestado</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Qtde Colaboradores</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Carga HR Dia</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Escala</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Vl Unitário</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Vl Total</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Ação</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<tbody></tbody>");
                                var vl_total = 0.00; 
                                for(var k=0; k < arrCarregar.data[i].DadosContratosItens.length; k++){
                                    if(arrCarregar.data[i].DadosContratos[h]['contratos_pk']==arrCarregar.data[i].DadosContratosItens[k]['contratos_pk']){
                                        vl_total += parseFloat(arrCarregar.data[i].DadosContratosItens[k]['vl_total']);
                                        var vl_contrato = arrCarregar.data[i].DadosContratos[h]['vl_contrato'] == '0,00' ? vl_total : arrCarregar.data[i].DadosContratos[h]['vl_contrato'];
                                        
                                        $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tbody").append("<tr id='trContratoItens"+j+"_"+k+"_"+contratos_pk+"_1'></tr>")
                                        $("#trContratoItens"+j+"_"+k+"_"+contratos_pk+"_1").append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['faturamento_contratos_itens_pk']+"<input id='faturamento_contratos_itens_pk["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['faturamento_contratos_itens_pk']+"'</td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_servico_prestado']+"<input id='produto_servico_pk["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['produto_servico_pk']+"'></td>")
                                                                                    .append("<td><input type='number' class='n_qtde_colaborador["+contratos_pk+"]' id='n_qtde_colaborador_"+contratos_pk+"_"+k+"' onchange='fcCalcularTotalItens("+k+", "+contratos_pk+")' value='"+arrCarregar.data[i].DadosContratosItens[k]['n_qtde_colaborador']+"'></td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_carga_horaria_dia']+"<input id='ds_periodo["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['ds_carga_horaria_dia']+"'></td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_escala']+"<input id='n_qtde_dias_semana["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['ds_escala']+"'></td>")
                                                                                    .append("<td><input type='text' class='vl_unitario_produtos_servicos["+contratos_pk+"]' id='vl_unit_"+contratos_pk+"_"+k+"'  onchange='fcCalcularTotalItens("+k+", "+contratos_pk+")'  onkeypress='mascara(this, moeda)' value='"+float2moeda(arrCarregar.data[i].DadosContratosItens[k]['vl_unit'])+"'></td>")
                                                                                    .append("<td><input type='text'  id='vl_total_item_"+contratos_pk+"_"+k+"' class='vl_total_item_"+contratos_pk+"' onkeypress='mascara(this, moeda)' value='"+float2moeda(arrCarregar.data[i].DadosContratosItens[k]['vl_total'])+"'></td>")
                                                                                    .append("<td></td>");
                                        
                                    }
                                }
                                $("#vl_total_contrato"+j+"_"+h).append(float2moeda(vl_contrato))
                                $("#vl_total_contrato"+contratos_pk).val(vl_contrato)
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<tfoot></tfoot>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='totalContratos"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#totalContratos"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Total Contratos</td>");
                                $("#totalContratos"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input type='text' id='vl_contrato"+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"' onkeypress='mascara(this, moeda)' value='"+float2moeda(vl_contrato)+"'></td>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='dtFaturamento"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#dtFaturamento"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Data Faturamento</td>");
                                $("#dtFaturamento"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input type='text' onkeypress='mascara(this, mdata)' id='dt_faturamento' value='"+arrCarregar.data[i].DadosContratos[h]['dt_faturamento']+"'></td>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='dtVencimento"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#dtVencimento"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Data Vencimento</td>");
                                $("#dtVencimento"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input onkeypress='mascara(this, mdata)' id='dt_vencimento' value='"+arrCarregar.data[i].DadosContratos[h]['dt_vencimento']+"'></td>");

                                vl_total_faturamento += parseFloat(vl_contrato);
                            }
                            $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='textarea"+j+"_"+contratos_pk+"_1'></tr>");
                            var obs_faturamento_contrato = arrCarregar.data[i].DadosContratos[h]['obs_faturamento_contrato'] == null? " ":arrCarregar.data[i].DadosContratos[h]['obs_faturamento_contrato'];
                            var obs_lancamento = arrCarregar.data[i].DadosContratos[h]['obs_lancamento'] == null? " ":arrCarregar.data[i].DadosContratos[h]['obs_lancamento'];
                            var obs_corpo_nota = arrCarregar.data[i].DadosContratos[h]['obs_corpo_nota'] == null? " ":arrCarregar.data[i].DadosContratos[h]['obs_corpo_nota'];

                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='2'><label>Observação Faturamento</label><textarea rows='4' class='obs_faturamento' cols='50' value=''>"+obs_faturamento_contrato+"</textarea></td>");
                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='3'><label>Observação Financeiro</label><textarea rows='4' class='obs_lancamento' cols='50' value=''>"+obs_lancamento+"</textarea></td>");
                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='3'><label>Observação Corpo da Nota Fiscal</label><textarea rows='4' class='obs_corpo_nota' cols='58' value=''>"+obs_corpo_nota+"</textarea></td>");
    
                            $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='StatusCtfDadosItem"+j+"_"+contratos_pk+"_1' align='right'></tr>");
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<td colspan='8'></td>");
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1 td").append("<select class='ic_status' id='ic_status"+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"'><option></option>\n\
                                                                                                <option value='1'>Validado</option>\n\
                                                                                                <option value='2'>Pendente Análise</option>\n\
                                                                                                <option value='3'>Não Faturar</option>\n\
                                                                                        </select>"); 
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1 td").append("&nbsp;<button height='10px' class='btn btn-success' onclick='fcValidarContrato("+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+")' align='right'>Status</button>"); 
                            $('#ic_status'+contratos_pk).val(arrCarregar.data[i].DadosContratos[h]['ic_status'])
                            fcValidarContrato(contratos_pk);
                        }
                    }
                }
            }  
            $("#vl_total_geral_faturamento").append(float2moeda(vl_total_faturamento))
            
        }        
    } catch (error) {
        alert(error)
    }
}

function fcCarregarDatosFaturamento(faturamento_pk){
    try {
        var v_faturamento_pk = faturamento_pk;
        var objParametros = {
            "pk": v_faturamento_pk
        };
        var arrCarregar = carregarController("faturamento", "listarDadosFaturamento", objParametros);
        //NewWindow(v_last_url)
        if (arrCarregar.result == 'success') {  
            //Dados do Faturamento
    
            $('#dsUsuarioCadastro').append(arrCarregar.data[0].ds_usuario_cadastro);
            $('#dtCadastro').append(arrCarregar.data[0].dt_cadastro);
            $('#dsUsuarioAtualizacao').append(arrCarregar.data[0].ds_usuario_atualizacao);
            $('#dtAtualizacao').append(arrCarregar.data[0].dt_ult_atualizacao);
            $('#pkFaturamento').append(arrCarregar.data[0].pk);
            $('#periodoFaturamento').append("De "+arrCarregar.data[0].dt_faturamento_ini+" Até "+arrCarregar.data[0].dt_faturamento_fim);
            $('#dsStatusFaturamento').append(arrCarregar.data[0].ds_usatus_faturamento);
            $('#dsObs').append(arrCarregar.data[0].obs);
            //Dados Contratos
            var dsContratoFixo = "";
            if(arrCarregar.data[0].ic_contrato_fixo==1){
                dsContratoFixo = "Contratos Fixos";
            }
            var dsContratoAditivos = "";
            if(arrCarregar.data[0].ic_contrato_aditivo==1){
                dsContratoAditivos = "Contratos Aditivos";
            }
            var dsContratoExtras = "";
            if(arrCarregar.data[0].ic_contrato_servico_extra==1){
                dsContratoExtras = "Contratos Aditivos";
            }
            $('#dsTiposContratos').append(dsContratoFixo+"<br>"+dsContratoAditivos+"<br>"+dsContratoExtras );
    
            //Dados Emissões
            var dsFaturas = "";
            if(arrCarregar.data[0].ic_gerar_fatura==1){
                dsFaturas = "Gerar Faturas";
            }
            var dsNF = "";
            if(arrCarregar.data[0].ic_gerar_nota_fiscal==1){
                dsNF = "Gerar Notas Fiscais";
            }    
            var dsBoleto = "";
            if(arrCarregar.data[0].ic_gerar_boleto==1){
                dsBoleto = "Gerar Boletos";
            } 
            $('#dsEmissoes').append(dsFaturas+"<br>"+dsNF+"<br>"+dsBoleto);
            
            //Dados Contas
            var dsContas = "";
            var vhtml = "";
            for(var i=0; i < arrCarregar.data.length; i++){   
                $('#composicao_faturamento').append("<div id='container"+i+"' class='row'></div>");  
                $("#container"+i).append("<div id='margin"+i+"' class='col-1'>&nbsp;</div>"); 
                $("#container"+i).append("<div id='size"+i+"' class='col-10'></div>"); 
                $("#size"+i).append("<table width='100%' id='container_table"+i+"'></table>"); 
                for(var j=0; j < arrCarregar.data[i].DadosContas.length; j++){
                    $('#dsContas').append(arrCarregar.data[i].DadosContas[j]['ds_conta']+"<br>");
                    $("#container_table"+j).append("<tr id='tr"+j+"'></tr>"); 
                    $("#tr"+j).append("<td id='td"+j+"'></td>"); 
                    $("#td"+j).append("<i class='bi bi-node-plus' style='font-size:20px; color:blue'></i>&nbsp;")  
                    $("#td"+j).append("<input type='checkbox' onclick='fcMarcaConta("+j+")' id='conta"+j+"' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'> - "+arrCarregar.data[i].DadosContas[j]['ds_conta']);  
                    //CONTRATOS FIXOS
                    if(arrCarregar.data[0].ic_contrato_fixo==1){
                        $("#td"+j).append("<div id='lineContratoFixo"+j+"' style='display:none'></div>");
                        $("#lineContratoFixo"+j).append("<table width='100%' id='tableContratoFixo"+j+"' class='table'></table>");  
                        $("#tableContratoFixo"+j).append("<tr></tr>");
                        $("#tableContratoFixo"+j+" tr").append("<td width='25'>&nbsp</td>");
                        $("#tableContratoFixo"+j+" tr").append("<td id='tdContratoFixo"+j+"'></td>");
                        $("#tdContratoFixo"+j).append("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='bi bi-play-fill' style='font-size:20px; color:blue'></i>&nbsp;<input type='checkbox' onclick='fcMacarTipoContrato("+j+",1)' id='tipoContratoFixoConta"+j+"' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'> - Contratos Fixos");  
                        $("#tdContratoFixo"+j).append("<div id='lineCtfDados"+j+"1' style='display:none'></div>");  
                        $("#lineCtfDados"+j+"1").append("<table width='100%' id='tableCtfDados"+j+"1' border=0 class='table'><table>");
                        var vl_total_faturamento = 0.00;
                        for(var h=0; h < arrCarregar.data[i].DadosContratos.length; h++){
                            if(arrCarregar.data[i].DadosContratos[h]['ic_tipo_contrato']==1 && arrCarregar.data[i].DadosContratos[h]['contas_contratos_pk'] == arrCarregar.data[i].DadosContas[j]['contas_pk'] ){ 
                                var contratos_pk = arrCarregar.data[i].DadosContratos[h]['contratos_pk'];
                                $("#tableCtfDados"+j+"1").append("<tr id='trCtfDados"+j+"1"+h+"'></tr>");
                                $("#trCtfDados"+j+"1"+h).append("<td width='35'>&nbsp</td>");
                                $("#trCtfDados"+j+"1"+h).append("<td id='tdCtfDados"+j+"1"+h+"'></td>");
                                $("#tdCtfDados"+j+"1"+h).append("&nbsp;<i class='bi bi-circle-fill' style='font-size:10px; color:blue'></i>")
                                $("#tdCtfDados"+j+"1"+h).append("&nbsp;<input type='checkbox' onclick='fcAbrirDadosContrato("+j+","+contratos_pk+",1)' id='ContratoFixoLead"+j+"_"+contratos_pk+"_1' value='"+contratos_pk+"'> ");
                                $("#tdCtfDados"+j+"1"+h).append("- Lead: "+arrCarregar.data[i].DadosContratos[h]['ds_lead']+" - "+ arrCarregar.data[i].DadosContratos[h]['ds_identificacao_area']);
                                $("#tdCtfDados"+j+"1"+h).append("- <span id='ic_contrato"+contratos_pk+"' align='left'></span>");
                                $("#tdCtfDados"+j+"1"+h).append("<div align='right'> <span id='vl_total_contrato"+j+"_"+h+"' align='right'>R$ </span> </div>");
                                $("#tdCtfDados"+j+"1"+h).append("<div id='lineCtfDadosItem"+j+"_"+contratos_pk+"_1' style='display:none'></div>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='contratos_pk' type='hidden' value='"+contratos_pk+"'>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='vl_total_contrato' id='vl_total_contrato"+contratos_pk+"' type='hidden' value=''>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='leads_pk' type='hidden' value='"+arrCarregar.data[i].DadosContratos[h]['leads_pk']+"'>");
                                $("#tdCtfDados"+j+"1"+h).append("<input class='contas_pk' type='hidden' value='"+arrCarregar.data[i].DadosContas[j]['contas_pk']+"'>");          
                                $("#tdCtfDados"+j+"1"+h).append("<input class='ic_tipo_contrato' type='hidden' value='"+arrCarregar.data[i].DadosContratos[j]['ic_tipo_contrato']+"'>");     
                                $("#tdCtfDados"+j+"1"+h).append("<input class='faturamento_contratos_pk' type='hidden' value=''>");       
                                $("#tdCtfDados"+j+"1"+h).append("<input class='faturamento_itens_pk' type='hidden' value=''>");       
                                $("#lineCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<table width='100%' id='tableCtfDadosItem"+j+"_"+contratos_pk+"_1' border='1'  class='table'></table>");  
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<tr></tr>");
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1 tr").append("<td></td>");
                                $("#tableCtfDadosItem"+j+"_"+contratos_pk+"_1 tr td").append("<table id='containerCtfDadosItem"+j+"_"+contratos_pk+"_1' width='100%' border='0'></table>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<thead></thead>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead tr").append("<th colspan='4' style='text-align:center; margin:10px;background:#f5f5f5'>Composição do Contrato</th>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr id='trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='10%'>Cód Contrato: "+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='20%'>Usuário Cadastro: "+arrCarregar.data[i].DadosContratos[h]['ds_usuario_cadastro_contrato']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='20%'>Dt Cadastro: "+arrCarregar.data[i].DadosContratos[h]['dt_cadastro']+"</td>");
                                $("#trSuperiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='35%'>Validade do Contrato: De "+arrCarregar.data[i].DadosContratos[h]['dt_inicio_contrato']+" Até "+arrCarregar.data[i].DadosContratos[h]['dt_fim_contrato']+"</td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr id='trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='35%'>Razão Social: "+arrCarregar.data[i].DadosContratos[h]['ds_razao_social']+"</td>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='40%'>CNPJ: "+arrCarregar.data[i].DadosContratos[h]['ds_cpf_cnpj']+"</td>");
                                $("#trInferiorItensCtfDados"+j+"_"+contratos_pk+"_1").append("<td width='40%'>Endereço: "+arrCarregar.data[i].DadosContratos[h]['ds_endereco_lead']+"</td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 thead").append("<tr><td width='40%' colspan=6><button class='btn btn-primary' onclick='fcAddLinha("+j+","+contratos_pk+")' align='left' >Adicionar Linha</button></td></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<tbody></tbody>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody").append("<tr></tr>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody tr").append("<td colspan='4'></td>");
                                $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tbody tr td").append("<table width='100%' border='1' class='table table-striped' id='tbContratoItens"+j+"_"+contratos_pk+"_1'></table>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<thead></thead>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead").append("<tr></tr>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Cód</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Serviço Prestado</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Qtde Colaboradores</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Carga HR Dia</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Escala</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Vl Unitário</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Vl Total</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 thead tr").append("<th>Ação</th>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<tbody></tbody>");
                                var vl_total = 0.00; 
                                for(var k=0; k < arrCarregar.data[i].DadosContratosItens.length; k++){
                                    if(arrCarregar.data[i].DadosContratos[h]['contratos_pk']==arrCarregar.data[i].DadosContratosItens[k]['contratos_pk']){
                                        vl_total += parseFloat(arrCarregar.data[i].DadosContratosItens[k]['vl_total']);
                                        var vl_contrato = arrCarregar.data[i].DadosContratos[h]['vl_contrato'] == '0,00' ? vl_total : arrCarregar.data[i].DadosContratos[h]['vl_contrato'];
                                        
                                        $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tbody").append("<tr id='trContratoItens"+j+"_"+k+"_"+contratos_pk+"_1'></tr>")
                                        $("#trContratoItens"+j+"_"+k+"_"+contratos_pk+"_1").append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['contratos_itens_pk']+"<input id='faturamento_contratos_itens_pk["+contratos_pk+"]' type='hidden' value=''></td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_servico_prestado']+"<input id='produto_servico_pk["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['produto_servico_pk']+"'></td>")
                                                                                    .append("<td><input type='number' class='n_qtde_colaborador["+contratos_pk+"]' id='n_qtde_colaborador_"+contratos_pk+"_"+k+"' onchange='fcCalcularTotalItens("+k+", "+contratos_pk+")' value='"+arrCarregar.data[i].DadosContratosItens[k]['n_qtde_colaborador']+"'></td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_carga_horaria_dia']+"<input id='ds_periodo["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['ds_carga_horaria_dia']+"'></td>")
                                                                                    .append("<td>"+arrCarregar.data[i].DadosContratosItens[k]['ds_escala']+"<input id='n_qtde_dias_semana["+contratos_pk+"]' type='hidden' value='"+arrCarregar.data[i].DadosContratosItens[k]['ds_escala']+"'></td>")
                                                                                    .append("<td><input type='text' class='vl_unitario_produtos_servicos["+contratos_pk+"]' id='vl_unit_"+contratos_pk+"_"+k+"' onchange='fcCalcularTotalItens("+k+", "+contratos_pk+")'  onkeypress='mascara(this, moeda)' value='"+float2moeda(arrCarregar.data[i].DadosContratosItens[k]['vl_unit'])+"'></td>")
                                                                                    .append("<td><input type='text' id='vl_total_item_"+contratos_pk+"_"+k+"' class='vl_total_item_"+contratos_pk+"'  onkeypress='mascara(this, moeda)' value='"+float2moeda(arrCarregar.data[i].DadosContratosItens[k]['vl_total'])+"'></td>")
                                                                                    .append("<td></td>");
                                        
                                    }
                                }
                                $("#vl_total_contrato"+j+"_"+h).append(float2moeda(vl_contrato))
                                $("#vl_total_contrato"+contratos_pk).val(vl_contrato)
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1").append("<tfoot></tfoot>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='totalContratos"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#totalContratos"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Total Contratos</td>");
                                $("#totalContratos"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input type='text' id='vl_contrato"+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"' onkeypress='mascara(this, moeda)' value='"+float2moeda(vl_contrato)+"'></td>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='dtFaturamento"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#dtFaturamento"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Data Faturamento</td>");
                                $("#dtFaturamento"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input type='text' onkeypress='mascara(this, mdata)' id='dt_faturamento'></td>");
                                $("#tbContratoItens"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='dtVencimento"+j+"_"+contratos_pk+"_1'></tr>");
                                $("#dtVencimento"+j+"_"+contratos_pk+"_1").append("<td colspan=6 align='right' >&nbsp;Data Vencimento</td>");
                                $("#dtVencimento"+j+"_"+contratos_pk+"_1").append("<td colspan=2><input onkeypress='mascara(this, mdata)' id='dt_vencimento'></td>");
                                
                                vl_total_faturamento += parseFloat(vl_contrato);
                            }
                            $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='textarea"+j+"_"+contratos_pk+"_1'></tr>");
                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='2'><label>Observação Faturamento</label><textarea rows='4' class='obs_faturamento' cols='50' value=''></textarea></td>");
                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='3'><label>Observação Financeiro</label><textarea rows='4' class='obs_lancamento' cols='50' value=''></textarea></td>");
                            $("#textarea"+j+"_"+contratos_pk+"_1").append("<td colspan='3'><label>Observação Corpo da Nota Fiscal</label><textarea rows='4' class='obs_corpo_nota' cols='58' value=''></textarea></td>");
    
                            $("#containerCtfDadosItem"+j+"_"+contratos_pk+"_1 tfoot").append("<tr id='StatusCtfDadosItem"+j+"_"+contratos_pk+"_1' align='right'></tr>");
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1").append("<td colspan='8'></td>");
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1 td").append("<select class='ic_status'  id='ic_status"+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+"'><option></option>\n\
                                                                                                <option value='1'>Validado</option>\n\
                                                                                                <option value='2'>Pendente Análise</option>\n\
                                                                                                <option value='3'>Não Faturar</option>\n\
                                                                                        </select>"); 
                            $("#StatusCtfDadosItem"+j+"_"+contratos_pk+"_1 td").append("&nbsp;&nbsp;<button height='10px' class='btn btn-success' onclick='fcValidarContrato("+arrCarregar.data[i].DadosContratos[h]['contratos_pk']+")' align='right'>Status</button>"); 
                        }
                    }
                }
            }  
            $("#vl_total_geral_faturamento").append(float2moeda(vl_total_faturamento))
            
        }        
    } catch (error) {
        alert(error)
    }
}

function fcProcessar(){
    if (confirm("Deseja realmente processar esse faturamento?")){
        var objParametros = {
            "pk": faturamento_pk
        };
        
        var arrCarregar = carregarController("faturamento", "processar", objParametros);
        if(arrCarregar.result == 'success'){
            alert('Registros salvos com sucesso!')
            sendPost('faturamento_res_form.php', {token: token});
        }else{
            alert(arrCarregar.message)
        }
    }
}

$(document).ready(function(){
    if(acao == '1'){
        fcCarregarDatosFaturamento(faturamento_pk)
    }else{
        fcCarregarDadosFaturamentoUpdate(faturamento_pk)
    }
    $(document).on('click', '#cmdSalvar', fcSalvar);
    $(document).on('click', '#cmdProcessar', fcProcessar);
});


