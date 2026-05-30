
function fcCarregarBoxes(){
    var objParametros = {
        "ds_processo_default": 'Comercial'
    };

    var arrCarregar = carregarController("processo_default_configuracao", "carregarCaixasECards", objParametros);

    var html = "";
        html +='<input type="hidden" id="primeiro_box_processo_pk" value="'+arrCarregar.data[0]['pk']+'">';
    for(var i=0; i < arrCarregar.data.length; i++){
        html +='<div class="box" id="box'+arrCarregar.data[i]['pk']+'" style="background-color:#eaeaea;width:300px;"  ondragover="onDragOver(event);" ondrop="onDrop(event, '+arrCarregar.data[i]['pk']+');" >';
        html +='   <div class="head_card">';
        html +='       <div>'+arrCarregar.data[i]['ds_processo_default_configuracao']+'</div>';
        html +='       <button class="menu"><b>...</b></button>';
        html +='    </div>';
        html+="     <div>";
        html+="        <br>";
        html+="        <input type='text' class='form-control form-control-sm' id='txt' onkeyup='fcPesquisar("+arrCarregar.data[i]['pk']+")' />";

        html+="     </div>";

        if(arrCarregar.data[i]['arrMovimentacao'].length > 0){
            for(var l=0; l < arrCarregar.data[i]['arrMovimentacao'].length; l++){
                var ds_cpf_cnpj = arrCarregar.data[i]['arrMovimentacao'][l]['ds_cpf_cnpj']!=null ?arrCarregar.data[i]['arrMovimentacao'][l]['ds_cpf_cnpj'] :"-";
                // html +='<div id="card" style="background-color:'+arrCarregar.data[i]['arrMovimentacao'][l]['ds_cor_card']+'" name="'+arrCarregar.data[i]['arrMovimentacao'][l]['ds_lead']+'" class="draggable" draggable="true" ondragstart="onDragStart(event, '+arrCarregar.data[i]['arrMovimentacao'][l]['leads_pk']+', '+arrCarregar.data[i]['arrMovimentacao'][l]['pk']+');">';
                html +='<div id="card" name="'+arrCarregar.data[i]['arrMovimentacao'][l]['ds_lead']+'" style="width:260px;justify-content: center;" class="draggable" draggable="true" ondragstart="onDragStart(event, '+arrCarregar.data[i]['arrMovimentacao'][l]['modulos_pk']+', '+arrCarregar.data[i]['arrMovimentacao'][l]['pk']+');">';
                html +='    <div class="row" style="justify-content: space-between">';
                //html +='        <div style="background-color:orange; border-radius:20px; width:40px; height:10px; margin:15px; 0px 0px 0px">&nbsp;</div>';
                html +='        <div style="border-radius:20px; width:40px; height:10px; margin:15px; 0px 0px 0px">&nbsp;</div>';
                html +='        <div align="right"><i class="bi bi-pencil-square" onClick="fcAlterarLead('+arrCarregar.data[i]['arrMovimentacao'][l]['modulos_pk']+')"></i> &nbsp;&nbsp; </div>';
                html +='    </div>';
                html +='    <hr style="background-color:black; margin: 0px">';
                html +='    <div id="lead_pk" style="font-size:11px;">Cód: '+arrCarregar.data[i]['arrMovimentacao'][l]['modulos_pk']+'</div>';
                html +='    <div  style="font-size:12px;" id="nm_lead">Lead: <b>'+arrCarregar.data[i]['arrMovimentacao'][l]['ds_lead']+'</b></div>';
                html +='    <div id="ds_cnpj_cpf" style="font-size:11px;">CNPJ/CPF: '+ds_cpf_cnpj+'</div>';
                html +='    <hr style="background-color:black">';
                html +='    <div class="row" style="justify-content: space-between">';
                html +='        <div>';
                html +='             &nbsp;&nbsp;';
                if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Sem Interesse"){
                    html +='             <i class="bi bi-exclamation-diamond"></i>';
                }else if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Cliente(s) Fechado(s) 100%"){
                    html +='             <i class="bi bi-hand-thumbs-up"></i>';
                }else if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Contrato(s) – 80%"){
                    html +='             <i class="bi bi-chat-dots"></i>';
                    html +='             <i class="bi bi-calendar2-date"></i>';
                    html +='             <i class="bi bi-file-earmark-check"></i>';
                    html +='             <i class="bi bi-cc-circle"></i>'
                }else if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Proposta(s) – 50%"){
                    html +='             <i class="bi bi-chat-dots"></i>';
                    html +='             <i class="bi bi-calendar2-date"></i>';
                    html +='             <i class="bi bi-file-earmark-check"></i>';
                }else if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Agenda - 25%"){
                    html +='             <i class="bi bi-chat-dots"></i>';
                    html +='             <i class="bi bi-calendar2-date" onclick="fcCarregarAgenda('+arrCarregar.data[i]['arrMovimentacao'][l]['modulos_pk']+')" ></i>';
                }else if(arrCarregar.data[i]['ds_processo_default_configuracao'] == "Prospecções - Target"){
                    html +='             <i class="bi bi-chat-dots"></i>';
                }
                html +='        </div>';
                html +='        <div style="font-size:11px;">';
                html +='            <i class="bi bi-clock"></i> '+arrCarregar.data[i]['arrMovimentacao'][l]['dt_cadastro']+' ás '+arrCarregar.data[i]['arrMovimentacao'][l]['hr_cadastro'];
                html +='            &nbsp;&nbsp;';
                html +='        </div>';
                html +='    </div>';
    
               // html +='    <div align="right"><i class="bi bi-card-list" style="font-size: 27px;" onclick="fcAbrirModalHistorico('+arrCarregar.data[i]['arrMovimentacao'][l]['leads_pk']+')"></i>&nbsp;&nbsp;<i class="bi bi-file-earmark-plus" style="font-size:25px;" onclick="fcListarMenu('+i+', '+l+', '+arrCarregar.data[i]['processos_default_pk']+', '+arrCarregar.data[i]['arrMovimentacao'][l]['leads_pk']+')"></i></div>';
                html +='</div>';
                html +='<div class="row" align="center" class="menu_suspenso" style="margin:2px; width:790px;" id="menu_suspenso_'+i+'_'+l+'" ></div>';
            }
        }else{
            html +='<div style="width:260px;justify-content: center;">';
            html +='</div>'; 
        }
        html +='    <input type="hidden" id="modulos_pk">';
        html +='    <input type="hidden" id="processo_movimentacao_status_pk_pai">';
        html +=' </div>';
        }

    $('#parent').append(html)
}

function fcAlterarLead(pk){
    sendPost("lead_main_form.php", {token: token,  leads_pk: pk});
}

function fcPesquisar(pk){
    /*$("#parent #box"+pk+" input").keyup(function(){*/
       // var index = $("#parent #box"+pk+" input").parent().index();
        var nth = "#parent #box"+pk+" #card #nm_lead";
        var valor = $("#parent #box"+pk+" input").val().toUpperCase();
        $("#parent #box"+pk+" #card").show();

        $(nth).each(function(){
            if($(this).text().toUpperCase().indexOf(valor) < 0){
                $(this).parent().hide();
            }
        });
    //});
    $("#parent #box"+pk+" #card").blur(function(){
        $(this).val("");
    });
}

function onDragStart(event, pk, processo_movimentacao_status_pk_pai) {
event
    .dataTransfer
    .setData('text/plain', event.target.id);
    $('#modulos_pk').val(pk)
    $('#processo_movimentacao_status_pk_pai').val(processo_movimentacao_status_pk_pai)

event
    .currentTarget
    .style
}

function onDragOver(event) {
    event.preventDefault();
}

function onDrop(event, origin) {
    const id = event
        .dataTransfer
        .getData('text');
        const draggableElement = document.getElementById(id);
        const dropzone = event.target;
        dropzone.appendChild(draggableElement);
        event
    .dataTransfer
    .clearData();
    fcVerificacaoModuloObrigatorio(origin, $('#modulos_pk').val(), $('#processo_movimentacao_status_pk_pai').val());
}

function fcVerificacaoModuloObrigatorio(origin, modulos_pk, processo_movimentacao_status_pk_pai){
    var ds_modulo = fcVerificacaoProcesso(origin);
    switch (ds_modulo) {
        case 'Prospecções - Target':{
            fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            break;
        }
        case 'Agenda - 25%':{
            if (confirm("Deseja adicionar uma nova Agenda?")){
                fcAbrirFormAgenda('', '', 'add', modulos_pk)
                fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            }else{
                var objParametros = {
                    "modulos_pk": modulos_pk
                };
                var arrCarregar = carregarController("comercial", "pesquisarModuloAgenda", objParametros);
                if(arrCarregar.data[0]['pk'] > 0){
                    fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
                }else{
                    alert("Lead não pode ser atualizado pois não existe uma agenda cadastrada para ele.")
                }
                location.reload();
            }
            break;
        }
        case 'Proposta(s) - 50%':{
            fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            break;
        }
        case 'Contrato(s) - 80%':{
            fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            break;
        }
        case 'Cliente(s) Fechado(s) 100%':{
            fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            break;
        }
        case 'Sem Interesse':{
            fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
            break;
        }
    }
    //fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai)
}

function fcVerificacaoProcesso(origin){
    var objParametros = {
        "processo_default_configuracao_pk": origin
    };

    var arrCarregar = carregarController("comercial", "verificacaoModuloObrigatorio", objParametros);
    return arrCarregar.data[0]['ds_processo_default_configuracao']
}

function fcAlterarStatus(origin, modulos_pk, processo_movimentacao_status_pk_pai){
    var objParametros = {
        "modulos_pk": modulos_pk,
        "processo_default_configuracao_pk": origin,
        "tipo_modulos_sistema_pk": 1,
        "processo_movimentacao_status_pk_pai": processo_movimentacao_status_pk_pai
    };

    var arrEnviar = carregarController("comercial", "salvarProcessoMovimentacaoStatus", objParametros);


    if (arrEnviar.result == 'success'){
        $("#parent").html('');
        fcCarregarBoxes();
    }else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcEnviarForm(ds_arquivo, modulos_pk){
    //sendPost(""+ds_arquivo+".php", {token: token, leads_pk: modulos_pk, ic_processo_comercial: 1});
    fcAbrirApontamento('', '')
}

//Leads
function fcNovoLead(){
    var primeiro_box_processo_pk = $('#primeiro_box_processo_pk').val()
    sendPost("lead_cad_form.php", {token: token, ic_processo_comercial: 1, leads_pk:'', processo_default_configuracao_pk : primeiro_box_processo_pk });
}

function  fcAtualizaComercialPainel(){
    location.reload();
}

function fcLeadResModal(){
    fcAbreModalLead();

    fcCarregarClientes();

    $(".chzn-select").chosen({ allow_single_deselect: true });
}
$(document).ready(function(){
    //
    fcCarregarBoxes();


    $(document).on('click', '#cmdEnviarLead', fcNovoLead);
    $(document).on('click', '#cmdBuscarLead', fcLeadResModal);

    

})
