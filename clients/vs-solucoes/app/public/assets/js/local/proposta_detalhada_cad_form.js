function fcCarregarItens(){
    try {
        var html='';
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("propostas_facilities", "listarPropostaDetalhada", objParametros);
        var dados = [];

        if(arrCarregar && Array.isArray(arrCarregar.data)){
            dados = arrCarregar.data;
        }

        if(arrCarregar && arrCarregar.status == true){
            if(dados.length === 0){
                $('#itens').html(
                    '<div class="row"><div class="col-md-1">&nbsp;</div><div class="col-md-10">' +
                    '<div class="alert alert-warning mb-3">Nenhum item de proposta foi configurado para este cliente.</div>' +
                    '</div></div>'
                );
                $('#totais_itens').html('');
                return;
            }

            for(var i=0; i<dados.length; i++){
                var subGrupos = Array.isArray(dados[i]['SubGrupos']) ? dados[i]['SubGrupos'] : [];
                var itens = Array.isArray(dados[i]['Itens']) ? dados[i]['Itens'] : [];

                html+='<div class="row">';
                html+='   <div class="col-md-1">';
                html+='       &nbsp;';
                html+='   </div>';
                html+='   <div class="col-md-10">';
                html+="       <h5>"+dados[i].ds_nome_grupo+"</h5>";
                html+='       <hr style="border: solid 1px black; margin-top:0px">';
                html+='   </div>';
                html+='</div>';
                if(subGrupos.length > 0){
                    for(var x=0; x<subGrupos.length; x++){
                        var itensSubGrupos = Array.isArray(subGrupos[x].ItensSubGrupos) ? subGrupos[x].ItensSubGrupos : [];
                        html+='<div class="row">';
                        html+='   <div class="col-md-1">';
                        html+='       &nbsp;';
                        html+='   </div>';
                        html+='   <div class="col-md-10">';
                        html+='       <h6>'+ subGrupos[x].ds_nome_grupo +'</h6>';
                        html+='       <hr style="border: solid 0.2px black; margin-top:0px">';
                        html+='   </div>';
                        html+='</div>';
                        for(var j=0; j<itensSubGrupos.length;j++){
                            html+='<div class="row">';
                            html+='   <div class="col-md-1">';
                            html+='       &nbsp;';
                            html+='   </div>';
                            html+='   <div class="col-md-6">';
                            html+='       <label><b>'+ itensSubGrupos[j].ds_label +':&nbsp;</b></label>';
                            html+='   </div>';
                            html+='   %<div class="col-md-1" align="rigth">';
                            html+='        <input type="hidden" class="form-control form-control-sm pk'+itensSubGrupos[j].pk+'">';
                            html+='        <input type="Text" name="valorPorcentagem'+dados[i].pk+'[]" id="valorPorcentagem'+subGrupos[x].pk+'"  onchange="fcPorcentagensTotaisSubGrupos('+subGrupos[x].pk+', '+dados[i].pk+')" class="form-control form-control-sm percentual'+itensSubGrupos[j].pk+'">';
                            html+='   </div>';
                            html+='   R$<div class="col-md-2" align="rigth">';
                            html+='        <input type="Text" name="valor'+dados[i].pk+'[]" id="valor'+subGrupos[x].pk+'" onkeypress="mascara(this, moeda)" onchange="fcTotaisSubGrupos('+subGrupos[x].pk+', '+dados[i].pk+')" class="form-control form-control-sm valor'+itensSubGrupos[j].pk+'" value="0,00">';
                            html+='   </div>';
                            html+='</div>';

                        }
                        html+='<br>';
                        html+='<div class="row">';
                        html+='   <div class="col-md-5">';
                        html+='       &nbsp;';
                        html+='   </div>';
                        html+='   <div class="col-md-2" align="right">';
                        html+='       <label><b>Totais '+ subGrupos[x].ds_nome_grupo +' &nbsp;</b></label>';
                        html+='   </div>';
                        html+='   %<div class="col-md-1" align="rigth">';
                        html+='        <input type="Text" id="porcentagens'+subGrupos[x].pk+'" class="form-control form-control-sm">';
                        html+='   </div>';
                        html+='   R$<div class="col-md-2" align="right">';
                        html+='        <input type="Text" id="totais'+subGrupos[x].pk+'" class="form-control form-control-sm" value="0,00">';
                        html+='   </div>';
                        html+='</div>';
                        html+='<br>';
                    }
                }
                if(itens.length > 0){
                    for(var l=0; l<itens.length; l++){
                        html+='<div class="row">';
                        html+='   <div class="col-md-1">';
                        html+='       &nbsp;';
                        html+='   </div>';
                        html+='   <div class="col-md-6">';
                        html+='       <label><b>'+ itens[l].ds_label +':&nbsp;</b></label>';
                        html+='   </div>';
                        html+='   %<div class="col-md-1" align="rigth">';
                        html+='        <input type="hidden" class="form-control form-control-sm pk'+itens[l].pk+'">';
                        html+='        <input type="Text" name="valorPorcentagem'+dados[i].pk+'[]" onchange="fcPorcentagensTotaisGrupos('+dados[i].pk+')" class="form-control form-control-sm percentual'+itens[l].pk+'">';
                        html+='   </div>';
                        html+='   R$<div class="col-md-2" align="rigth">';
                        html+='        <input type="Text" name="valor'+dados[i].pk+'[]" onkeypress="mascara(this, moeda)" onchange="fcTotaisGrupos('+dados[i].pk+')" class="form-control form-control-sm valor'+itens[l].pk+'" value="0,00">';
                        html+='   </div>';
                        html+='</div>';
                    }
                }
                html+='<br>';
                html+='<div class="row">';
                html+='   <div class="col-md-5">';
                html+='       &nbsp;';
                html+='   </div>';
                html+='   <div class="col-md-2" align="right">';
                html+='       <label><b>Total '+dados[i].ds_nome_grupo +' &nbsp;</b></label>';
                html+='   </div>';
                html+='   %<div class="col-md-1" align="rigth">';
                html+='        <input type="Text" id="porcentagens'+dados[i].pk+'" class="form-control form-control-sm">';
                html+='   </div>';
                html+='   R$<div class="col-md-2" align="right">';
                html+='        <input type="Text" id="totais'+dados[i].pk+'" class="form-control form-control-sm" value="0,00">';
                html+='   </div>';
                html+='</div>';
                html+='<br>';
            }
            $('#itens').html(html)

            var htmlTotais = "";
            for(var y=0; y<dados.length; y++){
                htmlTotais+='<div class="row">';
                htmlTotais+='   <div class="col-md-1">';
                htmlTotais+='       &nbsp;';
                htmlTotais+='   </div>';
                htmlTotais+='   <div class="col-md-6">';
                htmlTotais+='       <label><b>'+ dados[y].ds_nome_grupo +':&nbsp;</b></label>';
                htmlTotais+='   </div>';
                htmlTotais+='   %<div class="col-md-1" align="rigth">';
                htmlTotais+='        <input type="Text" name="porcentagemFinal[]" id="porcentagensFinais'+dados[y].pk+'" class="form-control form-control-sm">';
                htmlTotais+='   </div>';
                htmlTotais+='   R$<div class="col-md-2" align="rigth">';
                htmlTotais+='        <input type="Text" name="totalFinal[]" id="totalFinal'+dados[y].pk+'" onkeypress="mascara(this, moeda)" class="form-control form-control-sm" value="0,00">';
                htmlTotais+='   </div>';
                htmlTotais+='</div>';
            }

            $('#totais_itens').html(htmlTotais)


        }
    } catch (error) {
        utilsJS.toastNotify(false, error);

    }

}

function salvarItensProposta(pk){
    try {
        var objParametros = {
            "pk": ""
        };
        var arrCarregar = carregarController("propostas_facilities", "pegarDadosItens", objParametros);
        var dados = (arrCarregar && Array.isArray(arrCarregar.data)) ? arrCarregar.data : [];

        for(var i=0; i<dados.length; i++){

            var ds_valor = "";
            var ds_percentual = "";
            var propostas_facilities_label_pk = "";
            var propostas_facilities_grupos_subgrupos_pk = "";
            var ic_status = 1;

            if(Array.isArray(dados[i]['grupos']) && dados[i]['grupos'].length > 0){
                for(var l=0; l<dados[i]['grupos'].length; l++){
                    var arrDados = [];
                    var arrKeys = [];
                    for(var x=0; x<dados[i]['grupos'][l]['Itens'].length; x++){
                        arrKeys[0] = "pk";
                        arrKeys[1] = "propostas_facilities_grupos_subgrupos_pk";
                        arrKeys[2] = "propostas_facilities_label_pk";
                        arrKeys[3] = "ds_valor";
                        arrKeys[4] = "ds_percentual";
                        arrKeys[5] = "ic_status";
                        arrKeys[6] = "propostas_facilities_pk";

                        propostas_facilities_label_pk = dados[i]['grupos'][l]['Itens'][x]['pk'];
                        propostas_facilities_grupos_subgrupos_pk = dados[i]['grupos'][l]['Itens'][x]['propostas_facilities_grupos_subgrupos_pk']

                        ds_valor = moeda2float($(".valor"+propostas_facilities_label_pk).val());
                        ds_percentual = $(".percentual"+propostas_facilities_label_pk).val();
                        itens_pk = $(".pk"+propostas_facilities_label_pk).val();
                        //ic_status = (arrCarregar.data[i]['grupos'][l]['ic_status']);



                        arrDados[x] = [itens_pk, propostas_facilities_grupos_subgrupos_pk, propostas_facilities_label_pk, ds_valor, ds_percentual, ic_status, pk];
                    }
                    arrGrupos = arrayToJson(arrKeys, arrDados)
                    if(arrGrupos.length > 0){
                        var objParametrosSalvar = {
                            "arrGrupos": arrGrupos
                        };

                        carregarController("propostas_facilities_itens", "salvar", objParametrosSalvar);
                    }
                }
            }
            if(Array.isArray(dados[i]['SubGrupos']) && dados[i]['SubGrupos'].length > 0){
                for(var l=0; l<dados[i]['SubGrupos'].length; l++){
                    var arrDados = [];
                    var arrKeys = [];
                    for(var x=0; x<dados[i]['SubGrupos'][l]['ItensSubGrupos'].length; x++){
                        arrKeys[0] = "pk";
                        arrKeys[1] = "propostas_facilities_grupos_subgrupos_pk";
                        arrKeys[2] = "propostas_facilities_label_pk";
                        arrKeys[3] = "ds_valor";
                        arrKeys[4] = "ds_percentual";
                        arrKeys[5] = "ic_status";
                        arrKeys[6] = "propostas_facilities_pk";

                        propostas_facilities_label_pk = dados[i]['SubGrupos'][l]['ItensSubGrupos'][x]['pk'];
                        propostas_facilities_grupos_subgrupos_pk = dados[i]['SubGrupos'][l]['ItensSubGrupos'][x]['subgrupo_pk']

                        ds_valor = $(".valor"+propostas_facilities_label_pk).val();
                        ds_percentual = $(".percentual"+propostas_facilities_label_pk).val();
                        itens_pk = $(".pk"+propostas_facilities_label_pk).val();
                        //ic_status = arrCarregar.data[i]['ic_status'];
                        ic_status =1;

                        arrDados[x] = [itens_pk, propostas_facilities_grupos_subgrupos_pk, propostas_facilities_label_pk, ds_valor, ds_percentual, ic_status, pk];
                    }
                    arrGrupos = arrayToJson(arrKeys, arrDados)
                    if(arrGrupos.length > 0){
                        var objParametrosSalvar = {
                            "arrGrupos": arrGrupos
                        };

                        carregarController("propostas_facilities_itens", "salvar", objParametrosSalvar);
                    }
                }
            }
        }
    } catch (error) {
        utilsJS.toastNotify(false, error);
    }

}

function fcSalvarProposta(){
    var v_leads_pk = $("#leads_pk_proposta_detalhada").val();
    var v_ic_tipo_proposta = $("#ic_tipo_proposta").val();
    var v_produtos_servicos_pk = $("#produtos_servicos_pk_proposta").val();
    var v_ds_qtde_efetivo = $("#ds_qtde_efetivo").val();
    var v_ds_qtde_hr_semanais = $("#ds_qtde_hr_semanais").val();
    var v_ic_escala = $("#ic_escala").val();
    var v_convencao_coletiva_pk = $("#convencao_coletiva_pk").val();
    var v_dt_base_categoria = $("#dt_base_categoria").val();
    var v_ds_num_registro_mte = $("#ds_num_registro_mte").val();
    var v_vl_salario_piso_categoria = moeda2float($("#vl_salario_piso_categoria").val());
    var v_vl_total_proposta = moeda2float($("#vl_total_proposta").val());
    if($("#vl_total_percentual_proposta").val()!=""){
        var v_vl_total_percentual_proposta = moeda2float($("#vl_total_percentual_proposta").val());
    }
    else{
        var v_vl_total_percentual_proposta = moeda2float(0);
    }


    var objParametros = {
        "pk": $("#pk").val(),
        "leads_pk": v_leads_pk,
        "ic_tipo_proposta": v_ic_tipo_proposta,
        "produtos_servicos_pk": v_produtos_servicos_pk,
        "ds_qtde_efetivo": v_ds_qtde_efetivo,
        "ds_qtde_hr_semanais": v_ds_qtde_hr_semanais,
        "ic_escala": v_ic_escala,
        "convencao_coletiva_pk": v_convencao_coletiva_pk,
        "dt_base_categoria": v_dt_base_categoria,
        "ds_num_registro_mte": v_ds_num_registro_mte,
        "vl_salario_piso_categoria": v_vl_salario_piso_categoria,
        "vl_total_proposta": v_vl_total_proposta,
        "vl_total_percentual_proposta": v_vl_total_percentual_proposta,
        "ic_versao": $("#ic_versao").val()
    };

    var arrEnviar = carregarController("propostas_facilities", "salvar", objParametros);
    //NewWindow(v_last_url)
    if (arrEnviar.status == true){
        // Reload datable
        salvarItensProposta(arrEnviar.data);
        utilsJS.toastNotify(true, arrEnviar.message);
        if($("#ic_abertura").val() == 1){
            var objParametros = {
                "ic_abertura":1,
                "pk":v_leads_pk
            };
            sendPost('lead','leadMainPainel' ,objParametros);

        }else{
            var objParametros = {

            };
            sendPost('propostas_facilities','receptivo',objParametros);
        }
    }
    else{
        utilsJS.toastNotify(false, 'Falhou a requisição para salvar o registro.');
    }
}

function fcTotaisGrupos(grupos_pk){
    var totais = 0;
    $("input[name='valor"+grupos_pk+"[]']").each(function (){
        totais += new Number(moeda2float($(this).val()));
    });
    $("#totais"+grupos_pk+"").val(float2moeda(totais))
    $("#totalFinal"+grupos_pk+"").val(float2moeda(totais))
    fcCalcularTotalFinal()
}

function fcCalcularTotalFinal(){
    var totaisPorcentagens = 0;
    var totaisValores = 0;

    $("input[name='totalFinal[]']").each(function (){
        totaisValores += new Number(moeda2float($(this).val()));
    });

    $("input[name='porcentagemFinal[]']").each(function (){
        totaisPorcentagens += new Number($(this).val());
    });

    $("#vl_total_proposta").val(float2moeda(totaisValores))
    $("#vl_total_percentual_proposta").val(totaisPorcentagens)
}

function fcTotaisSubGrupos(sub_grupos_pk, grupos_pk){
    var totais = 0;
    vlSubGrupos = $("input[id='valor"+sub_grupos_pk+"']")
    for(i = 0; i < vlSubGrupos.length; i++){
        totais += new Number(moeda2float(vlSubGrupos.get(i).value));
    }
    $("#totais"+sub_grupos_pk+"").val(float2moeda(totais))
    fcTotaisGrupos(grupos_pk);
}

function fcPorcentagensTotaisGrupos(grupos_pk){
    var totais = 0;
    $("input[name='valorPorcentagem"+grupos_pk+"[]']").each(function (){
        totais += new Number($(this).val());
    });
    $("#porcentagens"+grupos_pk+"").val(totais)
    $("#porcentagensFinais"+grupos_pk+"").val(totais)
    fcCalcularTotalFinal()
}

function fcPorcentagensTotaisSubGrupos(sub_grupos_pk, grupos_pk){
    var totais = 0;
    porcentagemSubGrupos = $("input[id='valorPorcentagem"+sub_grupos_pk+"']")
    for(i = 0; i < porcentagemSubGrupos.length; i++){
        totais += new Number(porcentagemSubGrupos.get(i).value);
    }
    $("#porcentagens"+sub_grupos_pk+"").val(totais)
    fcPorcentagensTotaisGrupos(grupos_pk);
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("lead", "listarTodosPostTrabalho", objParametros);
    carregarComboAjax($("#leads_pk_proposta_detalhada"), arrCarregar, " ", "pk", "ds_lead");
    $("#leads_pk_proposta_detalhada").val($("#leads_pk").val());
}

function fcCarregarProdutosServicos(){
    var objParametros = {
        "pk": ""
    };
    var arrCarregar = carregarController("produto_servico", "listarTodos", objParametros);

    carregarComboAjax($("#produtos_servicos_pk_proposta"), arrCarregar, " ", "pk", "ds_produto_servico");
}

function fcVoltar(){
    if($("#ic_abertura").val() != 1){
        var objParametros = {

        };
        sendPost('propostas_facilities','receptivo',objParametros);
    }
    else{
        var objParametros = {
            "ic_abertura":1,
            "pk":$("#leads_pk").val()
        };
        sendPost('lead','leadMainPainel' ,objParametros);
    }
}

function fcCarregarDadosProposta(){
    if($("#pk").val()>0){
        var objParametros = {
            "pk":  $("#pk").val()
        };
        var arrCarregar = carregarController("propostas_facilities", "listarDadosPropostaDetalhada", objParametros);
        if(!arrCarregar || !Array.isArray(arrCarregar.data) || arrCarregar.data.length === 0){
            return;
        }
        $("#leads_pk_proposta_detalhada").val(arrCarregar.data[0]['leads_pk'])
        $("#ic_tipo_proposta").val(arrCarregar.data[0]['ic_tipo_proposta'])
        $("#produtos_servicos_pk_proposta").val(arrCarregar.data[0]['produtos_servicos_pk'])
        $("#ds_qtde_efetivo").val(arrCarregar.data[0]['ds_qtde_efetivo'])
        $("#ds_qtde_hr_semanais").val(arrCarregar.data[0]['ds_qtde_hr_semanais'])
        $("#ic_escala").val(arrCarregar.data[0]['ic_escala'])
        $("#convencao_coletiva_pk").val(arrCarregar.data[0]['convencao_coletiva_pk'])
        $("#dt_base_categoria").val(arrCarregar.data[0]['dt_base_categoria'])
        $("#ds_num_registro_mte").val(arrCarregar.data[0]['ds_num_registro_mte'])
        $("#vl_salario_piso_categoria").val(float2moeda(arrCarregar.data[0]['vl_salario_piso_categoria']))
        $("#vl_total_percentual_proposta").val(arrCarregar.data[0]['vl_total_percentual_proposta'])
        $("#vl_total_proposta").val(float2moeda(arrCarregar.data[0]['vl_total_proposta']))

        for(var i=0; i<arrCarregar.data[0].dadosItens.length; i++){
            var propostas_facilities_label_pk = arrCarregar.data[0].dadosItens[i]['propostas_facilities_label_pk']
            var ds_valor = arrCarregar.data[0].dadosItens[i]['ds_valor']
            var ds_percentual = arrCarregar.data[0].dadosItens[i]['ds_percentual']
            var propostas_facilities_grupos_subgrupos_pk = arrCarregar.data[0].dadosItens[i]['propostas_facilities_grupos_subgrupos_pk']
            var itens_pk = arrCarregar.data[0].dadosItens[i]['pk']
            var grupo_pai_pk = ''

            $(".pk"+propostas_facilities_label_pk).val(itens_pk);
            $(".valor"+propostas_facilities_label_pk).val(float2moeda(ds_valor));
            $(".percentual"+propostas_facilities_label_pk).val(ds_percentual);
            if(arrCarregar.data[0].dadosItens[i]['grupo_pai_pk'] > 0){
                grupo_pai_pk = arrCarregar.data[0].dadosItens[i]['grupo_pai_pk']
                fcTotaisSubGrupos(propostas_facilities_grupos_subgrupos_pk, grupo_pai_pk)
                fcPorcentagensTotaisSubGrupos(propostas_facilities_grupos_subgrupos_pk, grupo_pai_pk)
            }else{
                fcTotaisGrupos(propostas_facilities_grupos_subgrupos_pk);
                fcPorcentagensTotaisGrupos(propostas_facilities_grupos_subgrupos_pk);
            }
        }
    }
}

$(document).ready(function(){
    //Carregar Combo
    fcCarregarLeads();
    fcCarregarProdutosServicos();
    fcCarregarItens();
    fcCarregarDadosProposta();
    $('#leads_pk_proposta_detalhada').select2();
    //Atribuir mascaras
    $('#dt_base_categoria').datepicker({
        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked"
    }).datepicker();
    $("#dt_base_categoria").keypress(function(){
        mascara(this,mdata);
    });
    $("#ds_qtde_efetivo").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#ds_qtde_hr_semanais").keypress(function(){
        mascara(this,soNumeros);
    });
    $("#vl_salario_piso_categoria").keypress(function(){
        mascara(this,moeda);
    });
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdVoltar', fcVoltar);
    $(document).on('click', '#cmdSalvaProposta', fcSalvarProposta);

});
