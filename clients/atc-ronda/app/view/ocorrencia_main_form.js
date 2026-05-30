var tblResultado;
function fcPesquisar(){
    tblResultado.clear().destroy();
    fcCarregarGrid();    
    fcColorirGrid();
}

function fcIncluir(){
    var arrCarregar = permissao("ocorrencia", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    sendPost('ocorrencia_cad_form.php',{token: token, pk: ''});
}

function fcExcluir(v_pk, v_ds_ocorrencia){
    var arrCarregar = permissao("ocorrencia", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if (confirm("Deseja realmente excluir o registro '" + v_ds_ocorrencia + "'?")){
        if(v_pk != ""){
            var objParametros = {
                "pk": v_pk
            }; 
            var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);  
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
}

function fcCarregarGrid(){

    var objParametros = {
        "ds_lead": $("#ds_lead option:selected").text(),
        "tipos_ocorrencias_pk": $("#tipo_ocorrencia_res_pk").val(),
        "ic_status": $("#ic_status").val(),
        "usuario_cadastro_pk": $("#usuario_cadastro_res_pk").val(),
        "dt_cadastro": $("#dt_cadastro").val(),
        "dt_prazo_execucao_ini": $("#dt_prazo_execucao_ini").val(),
        "dt_prazo_execucao_fim": $("#dt_prazo_execucao_fim").val(),
        "ic_status_fechamento": $("#ic_status_fechamento_pesq").val(),
        "equipes_pk": $("#equipes_pk_res").val(),
        "dt_cadastro_fim": $("#dt_cadastro_fim").val(),
        "colaborador_pk":$("#colaborador_pk").val()
    };     
    
   
    var v_url = montarUrlController("ocorrencia", "listarDataTableGrid", objParametros);
  
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "bPaginate": false,
        "bDeferRender"   : true,
        //"bProcessing"    : true,
        "aaSorting"      : [],
        "sPaginationType": "full_numbers",
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 title='Editar Ocorrência' src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 title='Acessar Painel do Lead' src='../img/painel.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },      
           {"targets": -2, "data": "t_obs_recusa"}, 
           {"targets": -3, "data": "t_dt_termino_retorno"}, 
           {"targets": -4, "data": "t_ds_retorno"},
           {"targets": -5, "data": "t_dt_retorno"},
           {"targets": -6, "data": "t_agendado_para"},            
           {"targets": -7, "data": "t_nome_usuario_cadastro"},
           {"targets": -8, "data": "t_ds_ocorrencia"},
           {"targets": -9, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -10, "data": "t_ds_tipo_ocorrencia"}, 
           {"targets": -11, "data": "t_dt_fechamento"},
           {"targets": -12, "data": "t_ic_recusa" ,"visible":false},
           {"targets": -13, "data": "t_ds_status"}, 
           {"targets": -14, "data": "t_obs_execucao"}, 
           {"targets": -15, "data": "t_dt_prazo_execucao"},           
           {"targets": -16, "data": "t_dt_cadastro"},           
           {"targets": -17, "data": "t_ds_colaborador"},           
           {"targets": -18, "data": "t_ds_lead"},
           {"targets": -19, "data": "t_pk"},

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
        
    $('#tblResultado tbody').on('click', '.function_delete', function () {
        
        var data;
        
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirOcorrencia(data['t_pk']);
        }
    } );
    
    $('#tblResultado tbody').on('click', '.function_edit', function () {
      
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblResultado.row( $(this).parents('li')).data()){
            data = tblResultado.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblResultado.row( $(this).parents('tr')).data()){
            data = tblResultado.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOcorrencia(data);        
    } );   
    $('#tblResultado tbody').on('click', '.function_painel', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcAbrirPainel(data['t_leads_pk']);
    } );
    /*$('#tblResultado tbody').on('click', '.function_enviar', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcAbrirModalEnviar(data['t_leads_pk'],data['t_dt_cadastro'],data['t_ds_tipo_ocorrencia'],data['t_ds_ocorrencia'],data['t_dt_termino_retorno']);
    } );*/
    
}

function fcAbrirPainel(leads_pk){
    sendPost('lead_main_form.php', {token: token, pk: leads_pk});
}

function fcAbrirModalEnviar(leads_pk,dt_cadastro,ds_tipo_oc,ds_oc,dt_termino_oc){
    fcLimparVariavelEnvioEmail()
    
    tblEnviarEmail.clear().destroy();
    fcFormatarGridEnvioEmail();
    fcAtualizarDadosEnviarEmail(leads_pk);
    $("#janela_enviar_email").modal();
    $("#dt_ocorrencia").val(dt_cadastro);
    $("#ds_tipo_oc").val(ds_tipo_oc);
    $("#ds_oc").val(ds_oc);
    $("#dt_termino_oc").val(dt_termino_oc);
}

function fcLimparVariavelEnvioEmail(){
    $("#dt_ocorrencia").val("");
    $("#ds_tipo_oc").val("");
    $("#ds_oc").val("");
    $("#dt_termino_oc").val("");
}

function fcCarregarTipoOcorrenciaRes(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipo_ocorrencia_res_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");        
}
function fcCarregarComboUsuarioRes(){    
    var objParametros = {
        "pk": ""
    };  
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#usuario_cadastro_res_pk"), arrCarregar, " ", "pk", "ds_usuario");        
}
function fcCarregarComboEquipeRes(){    
    var objParametros = {
        "pk": ""
    };  
    
    
    var arrCarregarLogado = carregarController("equipe", "listarEquipeUsuarioLogado", objParametros);  

    if(arrCarregarLogado.data.length > 0){
        carregarComboAjax($("#equipes_pk_res"), arrCarregarLogado, "", "pk", "ds_equipe"); 
    }
    else{
        var arrCarregar = carregarController("equipe", "listarTodos", objParametros);
        carregarComboAjax($("#equipes_pk_res"), arrCarregar, " ", "pk", "ds_equipe"); 
    }
    
           
}


function fcFormatarGridEnvioEmail(){    
    tblEnviarEmail = $("#tblEnviarEmail").DataTable({
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
                "data": "t1"
            },
            
            {   
                "targets": 1,
                "data": "t2"
            },            
            {   
                "targets": 2,
                "data": "t3"
            }          
            
        ],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });
    return false;    
}

function fcIncluirEnvioEmail(){  
    
    tblEnviarEmail.row.add(          
    {           
        "t1":"<input type='checkbox' class='form-control form-control-sm' id='id_enviar_email' />",
        "t2":"<input type='text' class='form-control form-control-sm' id='ds_nome_contato' disabled />",
        "t3":"<input type='text' class='form-control form-control-sm' id='ds_email_contato' disabled />"
    }            
    ).draw( false ); 
    
    return false;
}

function fcAtualizarDadosEnviarEmail(leads_pk){
    var objParametros = {
        "leads_pk":leads_pk
    };  
    var arrCarregar = carregarController("lead", "listarContatoLead", objParametros); 
    
    if (arrCarregar.result == 'success'){
        
        for(i = 0; i < arrCarregar.data.length; i++){
            
            if(leads_pk!=""){
                //Adiciona a linha.
                fcIncluirEnvioEmail();                
            }     
            var check_envio = $("input[id='id_enviar_email']");
            var ds_nome_contato = $("input[id='ds_nome_contato']");
            var ds_email_contato = $("input[id='ds_email_contato']");
           
                     
            ds_nome_contato.get(i).value = arrCarregar.data[i]['t_ds_contato'];            
            ds_email_contato.get(i).value = arrCarregar.data[i]['t_ds_email'];     
            check_envio.get(i).checked = false;
        }        
    }
    else{
        alert('Falhou a requisição de exclusão.');
    }
}

function fcFormatarDadosEnviarEmail(){

    var check_envio = $("input[id='id_enviar_email']");
    var ds_nome_contato = $("input[id='ds_nome_contato']");
    var ds_email_contato = $("input[id='ds_email_contato']");

   

    var arrKeys = [];
    arrKeys[0] = "check_envio";
    arrKeys[1] = "ds_nome_contato";
    arrKeys[2] = "ds_email_contato";
    var checked = 2;
    var arrDados = [];
    var  data = tblEnviarEmail.rows().data();
        
    for(i = 0; i< data.length; i++){
        try{       
            
            if(check_envio.get(i).checked){
               checked = 1;
                if(ds_email_contato.get(i).value==""){
                    alert("Esse contato não possui um E-mail cadastrado!");
                    return false;
                }
            }
            else{
                checked = 2;
            }
            
            arrDados[i] = [
                checked,
                ds_nome_contato.get(i).value, 
                ds_email_contato.get(i).value
            ];
           
        }
        catch(err){
            alert(err.message);
        }
    }
    return arrayToJson(arrKeys, arrDados); 
    
}

function fcEnviarEmail(){
    var strJSONDadosTabela = fcFormatarDadosEnviarEmail(); 
    
    var objParametros = {
        "enviar_email": strJSONDadosTabela ,
        "dt_ocorrencia":$("#dt_ocorrencia").val(),
        "ds_tipo_oc":$("#ds_tipo_oc").val(),
        "ds_oc":$("#ds_oc").val(),
        "dt_termino":$("#dt_termino_oc").val()
    };    
    
     

    var arrEnviar = carregarController("ocorrencia", "enviar_email", objParametros);
    if (arrEnviar.result == 'success'){
        //alert("E-mail enviado com sucesso!!!");
        $("#janela_enviar_email").modal("hide");   
        
    }    
    else{
       
        alert(arrEnviar.result);
    }
}

function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("lead", "listarTodos", objParametros);    

    carregarComboAjax($("#ds_lead"), arrCarregar, " ", "pk", "ds_lead");        
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");        
}




//--INCLUIR OC--------///
function fcAbrirFormNovaOcorrenciaLeadCombo(){
    $('#doc').show();
    $('#tipo_ocorrencia_pk').prop('disabled',true);
    $("#ocorrencias_pk").val("");
    $("#ds_ocorrencia").val("");
    $("#tipo_ocorrencia_pk").val("");
    $('#tipo_ocorrencia_pk').prop('disabled', false);
    $('#dt_fechamento').prop('checked', false);
    $('#ic_docs').prop('checked', false);
    $('#ic_docs').prop('disabled', false);
    
    //AGENDA RETORNO
    $("#agenda_visible").hide();
    $("#agenda_retorno_pk").val("");
    
    $("#edit_agenda_visible").hide();
    $("#agenda_equipe_visible").hide();
    $("#agenda_responsavel_visible").hide();
    $('#agenda_retorno').prop('checked', false);
    $('#agenda_retorno').prop('disabled', true);
    $("#agenda_dt_retorno").val("");
    $("#agenda_hr_retorno").val("");
    $("#agenda_ic_agendar_para").val("");
    $("#agenda_equipes_pk").val("");
    $("#agenda_responsavel_pk").val("");
    $("#agenda_ds_retorno").val("");
    $("#tipo_lembrete_pk").val("");
    $("#edit_tipo_lembrete_pk").val("");
    $("#dt_prazo_execucao").val("");
    $("#ic_abrir_oc_combo_lead").val("");
    
    //EDIÇÃO AGENDA
    
    $("#edit_agenda_dt_retorno").html("");
    $('#edit_agenda_responsavel_pk').prop('disabled', false);
    $("#edit_agenda_equipes_pk").val("");
    $("#edit_agenda_dt_retorno_termino").val("");
    $("#edit_agenda_hr_retorno_termino").val("");
    $("input[id=edit_agenda_dt_retorno_termino]").prop("disabled", false);
    $("input[id=edit_agenda_hr_retorno_termino]").prop("disabled", false);
    $('#edit_agenda_equipes_pk').prop('disabled', false);
    $("#edit_agenda_responsavel_pk").val("");
    $("#edit_agenda_ds_retorno").html("");
    
    $("#agenda_ds_retorno").html("");
    
    fcCarregarTipoOcorrencia();
    
    
    setTimeout(function(){
        tblDocumentosOc.clear().destroy();
        fcCarregarGridDocumentosOC();
    }, 2000);
    
    $('#doc').hide();
    $("#janela_ocorrencia").modal();
     setTimeout(function(){
        fcCarregarLeads();
        fcCarregarComboColaboradorOcorrencia();
        $(".chzn-select").chosen('destroy');

        $("#leads_pk").val("");
        $("#colaborador_pk_ocorrencia_ins").val("");

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
  
}

function fcEditarOcorrencia(objRegistro){    
    var arrCarregar = permissao("ocorrencia", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    $('#doc').hide();
        
    fcAbrirFormNovaOcorrenciaLeadCombo();
  
    //carrega agenda retorno
    fcEditarRetorno(objRegistro['t_pk']);       
    $("#ocorrencias_pk").val(objRegistro['t_pk']);
    //Carrega as informações da linha selecionada.
    if(objRegistro['t_dt_fechamento']!=null){
         $("input[id=dt_fechamento]").prop("checked", "true");
         $('#dt_fechamento').prop('disabled', true);
    }
    fcCarregarTipoOcorrencia();    
    $("#tipo_ocorrencia_pk").val(objRegistro['t_tipos_ocorrencias_pk']);
    $("#dt_prazo_execucao").val(objRegistro['t_dt_prazo_execucao']);
   
   
   
    if(objRegistro['t_ic_recusa']=='1'){
        $("input[id=ic_recusa]").prop("checked", "true");
        //$("#ic_recusa").val(objRegistro['t_ic_status_fechamento']);
        $('#div_ds_recusa').show();
        $("input[id=dt_prazo_execucao]").prop("disabled", "true");
        $("textarea[id=obs_execucao]").prop("disabled", "true");
        $("#obs_recusa").val(objRegistro['t_obs_recusa']);
    }else{
        $('#div_ds_recusa').hide();
        $("input[id=dt_prazo_execucao]").prop("disabled", false);
        $("textarea[id=obs_execucao]").prop("disabled", false);
        $("#obs_execucao").val(objRegistro['t_obs_execucao']);
    }
    
    $('#tipo_ocorrencia_pk').prop('disabled', true);
    $("#ds_ocorrencia").val(objRegistro['t_ds_ocorrencia']);
        
    fcPegarNomeTipoOc($("#tipo_ocorrencia_pk").val());
        
    if(fcQtdeDocumentosOcorrenciaPk() > 0){
        $('#ic_docs').prop('disabled', true);
        $('#ic_docs').prop('checked', true);
        $('#doc').show();
        tblDocumentosOc.clear().destroy();
        fcCarregarGridDocumentosOC();
    }
    else{
        $('#ic_docs').prop('checked', false);
        $('#ic_docs').prop('disabled', false);
        $('#doc').hide();
    }
    
    setTimeout(function(){
        fcCarregarLeads();
        fcCarregarComboColaboradorOcorrencia();
        $(".chzn-select").chosen('destroy');

        $("#leads_pk").val(objRegistro['t_leads_pk']);
        $("#colaborador_pk_ocorrencia_ins").val(objRegistro['t_colaborador_pk']);

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
}

function fcQtdeDocumentosOcorrenciaPk(){
    var objParametros = {
        "ocorrencias_pk": $("#ocorrencias_pk").val()
    };     
    var arrCarregar = carregarController("documento", "listarDocumentosOc", objParametros); 
    if (arrCarregar.result == 'success'){ 
        return arrCarregar.data.length;
    }
    
}

function fcEditarOcorrenciaCalendario(pk,tipos_ocorrencias_pk,ds_ocorrencia,dt_fechamento){
    var arrCarregar = permissao("ocorrencia", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    fcAbrirFormNovaOcorrenciaLeadCombo();
    //carrega agenda retorno
    
    fcEditarRetorno(pk);    
    //Carrega as informações da linha selecionada.
    if('t_dt_fechamento'!=null){
         $("input[id=dt_fechamento]").prop("checked", "true");
         $('#dt_fechamento').prop('disabled', true);
    }
    
    $("#ocorrencias_pk").val(pk);    
    fcCarregarTipoOcorrencia();    
    $("#tipo_ocorrencia_pk").val(tipos_ocorrencias_pk);  
    $('#tipo_ocorrencia_pk').prop('disabled', true);
    $("#ds_ocorrencia").val(ds_ocorrencia);
}


function fcExcluirOcorrencia(v_pk){
    var arrCarregar = permissao("ocorrencia", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblResultado.clear().destroy();    
            fcCarregarGrid();
            fcColorirGrid();
            
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function Reset(){
    $('#progress .progress-bar').css('width', '0%');
}


function fsClean() {
    $('#progress .progress-bar').css('width', '0%');
}


//FINAL DOCUMENTOS UPLOAD
function fcEditarRetorno(ocorrencias_pk){
    var arrCarregar = permissao("agenda_retorno", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(ocorrencias_pk > 0){

        var objParametros = {
            "ocorrencias_pk": ocorrencias_pk
        };        
        
        var arrCarregar = carregarController("retorno", "listarOcorrenciasPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data.length > 0){
                
                $("input[id=agenda_retorno]").prop("checked", "true");
                $("input[id=agenda_retorno]").prop("disabled", "true");
                $("#edit_agenda_dt_retorno").html(arrCarregar.data[0]['dt_retorno']);
                $("#edit_agenda_hr_retorno").html(arrCarregar.data[0]['hr_retorno']);          
                $("#agenda_ds_retorno").val(arrCarregar.data[0]['ds_retorno']);
                $("#tipo_lembrete_pk").val(arrCarregar.data[0]['tipo_lembrete_pk']);
                $("#edit_tipo_lembrete_pk").val(arrCarregar.data[0]['tipo_lembrete_pk']);
                $('#agenda_ds_retorno').prop('disabled', false);
                $('#dt_termino_retorno').prop('checked', false);
                $("input[id=dt_termino_retorno]").prop("disabled", false);
                
                $("#agenda_retorno_pk").val(arrCarregar.data[0]['pk']);
                                               
                if(arrCarregar.data[0]['dt_termino_retorno']!=null){  
                    $('#dt_termino_retorno').prop('checked', true);
                    $("input[id=dt_termino_retorno]").prop("disabled", "true");
                    
                    //descrição do retorno
                    $('#agenda_ds_retorno').prop('disabled', true);
                    
                    //Desabilita o fechamento da Ocorrencia
                    $("input[id=dt_fechamento]").prop("disabled", "true");
                    
                }
             
                if(arrCarregar.data[0]['equipes_pk']!= null && arrCarregar.data[0]['responsavel_pk']==null){                    
					
					fcCarregarComboResponsavelEquipe(arrCarregar.data[0]['responsavel_pk']);
					$("#edit_agenda_responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                    fcCarregarComboEquipeEdit();
                    $("#edit_agenda_equipes_pk").val(arrCarregar.data[0]['equipes_pk']);
                    $("select[id=edit_agenda_equipes_pk]").prop("disabled", "true");
                }else{
					
                    fcCarregarComboResponsavelEquipe(arrCarregar.data[0]['equipes_pk']);
                    
                    $("#edit_agenda_responsavel_pk").val(arrCarregar.data[0]['responsavel_pk']);
                    
                    $("select[id=edit_agenda_responsavel_pk]").prop("disabled", "true");
                    $("select[id=edit_agenda_equipes_pk]").prop("disabled", "true");
                }
                
                $("#edit_agenda_visible").show();
            }
            else{
                
                $('#agenda_retorno').prop('checked', false);
                $("#agenda_retorno").prop("disabled", false);
                
                $("#edit_agenda_visible").hide();
            }
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }    
}
function fcEditRetornoFechaOC(){
    var arrCarregar = permissao("agenda_retorno", "upd");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if($('#dt_termino_retorno').is(":checked")){         
        $('#dt_fechamento').prop('disabled', false);
        
    }else{               
       $('#dt_fechamento').prop('disabled',true);
       $('#dt_fechamento').prop('checked', false);
    }  
}

function fcCarregarComboResponsavelEquipe(v_equipes_pk){
     
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#edit_agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
    
    
}


function fcCarregarComboEquipeEdit(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#edit_agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");
        
}

function fcEnviarOcorrencia(){
    var arrCarregar = permissao("ocorrencia", "ins");        
        
 
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }

    
     if($('#leads_pk').val()==""){
        $("#alert_ds_lead").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_lead").slideUp(500);
        });
        $('#leads_pk').focus();
        return false;
    }
    var strJSONDadosTabela =  fcFormatarDadosArquivosOc();
    var v_agenda_equipes_pk = "";
    var v_agenda_responsavel_pk = "";
    var v_agenda_dt_retorno = "";
    var v_agenda_hr_retorno = "";
    var v_agenda_ds_retorno = "";
    var v_tipo_lembrete_pk = "";
    var v_dt_retorno_termino = 0;
    
    var v_dt_fechamento = 0;
    var v_agenda_retorno = 0;
    var v_ds_ocorrencia = $("#ds_ocorrencia").val();
    var v_tipo_ocorrencia_pk = $("#tipo_ocorrencia_pk").val();
   
    //Valida retorno 
    //fcValidarFormOcorrenciaRetorno() 
    
    if($("#agenda_retorno_pk").val()!=""){
         v_agenda_equipes_pk = $("#edit_agenda_equipes_pk").val();
         v_agenda_responsavel_pk = $("#edit_agenda_responsavel_pk").val();
         v_tipo_lembrete_pk = $("#edit_tipo_lembrete_pk").val();
         //v_agenda_dt_retorno_termino = $("#dt_retorno_termino").val();
         //v_agenda_hr_retorno_termino = $("#edit_agenda_hr_retorno_termino").val();
         v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
    }else{
        v_agenda_dt_retorno = $("#agenda_dt_retorno").val();
        v_agenda_hr_retorno = $("#agenda_hr_retorno").val();
        v_agenda_equipes_pk = $("#agenda_equipes_pk").val();
        v_agenda_responsavel_pk = $("#agenda_responsavel_pk").val();
        v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
        v_tipo_lembrete_pk = $("#tipo_lembrete_pk").val();
    }
 
    if($('#dt_fechamento').is(":checked")){
        v_dt_fechamento = 1;
    }
    else{
        v_dt_fechamento = 2;
    }
    if($('#agenda_retorno').is(":checked")){
        v_agenda_retorno = 1;
    }
    else{
        v_agenda_retorno = 2;
    }
   if($('#dt_termino_retorno').is(":checked")){
        v_dt_retorno_termino = 1;
    }
    else{
        v_dt_retorno_termino = 2;
    }
    //Dt execução

    //Recusa
    if($('#ic_recusa').is(":checked")){
        var v_ic_recusa = 1;
    }else{
        var v_ic_recusa = 0;       
    }
    
     var v_obs_recusa = $("#obs_recusa").val()

    if($("#ocorrencias_pk").val()==''){
        var objParametros = {        
            "leads_pk": $("#leads_pk").val(),
            "pk": $("#ocorrencias_pk").val(),
            "ds_ocorrencia":v_ds_ocorrencia,
            "tipos_ocorrencias_pk":v_tipo_ocorrencia_pk,
            "dt_fechamento":v_dt_fechamento,
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,
            "agenda_retorno":v_agenda_retorno,
            "dt_termino_retorno":v_dt_retorno_termino,
            //"hr_termino_retorno":v_agenda_hr_retorno_termino,
            "tipo_lembrete_pk":v_tipo_lembrete_pk,
            "agenda_retorno_pk":$("#agenda_retorno_pk").val(),
            "dt_prazo_execucao":$("#dt_prazo_execucao").val(),
            "obs_execucao":$("#obs_execucao").val(),
            "ic_recusa":v_ic_recusa,
            "colaborador_pk":$("#colaborador_pk_ocorrencia_ins").val(),
            "obs_recusa":v_obs_recusa,
           
            "doc_oc":strJSONDadosTabela
        };
    }else{
        var objParametros = {      
            
            "pk": $("#ocorrencias_pk").val(),
            "ds_ocorrencia":v_ds_ocorrencia,
            "tipos_ocorrencias_pk":v_tipo_ocorrencia_pk,
            "dt_fechamento":v_dt_fechamento,
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,
            "agenda_retorno":v_agenda_retorno,
            "dt_termino_retorno":v_dt_retorno_termino,
            //"hr_termino_retorno":v_agenda_hr_retorno_termino,
            "agenda_retorno":v_agenda_retorno,
            "tipo_lembrete_pk":v_tipo_lembrete_pk,
            "agenda_retorno_pk":$("#agenda_retorno_pk").val(),
            "dt_prazo_execucao":$("#dt_prazo_execucao").val(),
            "obs_execucao":$("#obs_execucao").val(),
            "ic_recusa":v_ic_recusa,
            "obs_recusa":v_obs_recusa,
            "leads_pk":$("#leads_pk").val(),
            "colaborador_pk":$("#colaborador_pk_ocorrencia_ins").val(),
            "doc_oc":strJSONDadosTabela
        };
    }

    var arrEnviar = carregarController("ocorrencia", "salvar", objParametros); 
   
    if (arrEnviar.result == 'success'){                
        // Reload datable
        alert(arrEnviar.message);
        $("#janela_ocorrencia").modal("hide"); 
         fcColorirGrid();
        //verifica se a tabela existe
        if ($("#tblOcorrencia").length){     
            tblOcorrencia.clear().destroy();    
            fcCarregarGridOcorrencia();
            //TABELA DOCS PAINEL 
            tblDocumentos.clear().destroy();    
            fcCarregarGridDocumentos();
           
        }
        else if ($("#tblResultado").length){     
            tblResultado.ajax.reload();
        }
        else{
            fcCarregar();
        }
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
   
}

function fcCarregarTipoOcorrencia(){

    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    
    carregarComboAjax($("#tipo_ocorrencia_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");
        
}
// Validaão de OC 
function fcValidarFormOcorrencia(){
    dt_prazo_execucao
    $("#form_ocorrencia").validate({
        rules :{
            leads_pk:{
                required:true
            },
            ds_ocorrencia:{
                required:true
            },
            tipo_ocorrencia_pk:{
                required:true
            },

            agenda_dt_retorno:{
                    required:true
            },
            agenda_hr_retorno:{
                required:true
            },      
            agenda_responsavel_pk:{
                required:true
            },
            agenda_equipes_pk:{
                required:true
            }
        },
        messages:{
            leads_pk:{
                required:"Por favor, informe Leads"
            },
            ds_ocorrencia:{
                required:"Por favor, informe Ocorrência"
            },
            tipo_ocorrencia_pk:{
                required:"Por favor, informe Tipo ocorrência"
            },
            agenda_dt_retorno:{
                required:"Por favor, informe a Data"
            },
            agenda_hr_retorno:{
                required:"Por favor, informe a Hora"
            },  
            agenda_responsavel_pk:{
                required:"Por favor, selecione o Usuário"
            },
            agenda_equipes_pk:{
                required:"Por favor, selecione a Equipe"
            } 
        },
        submitHandler: function(form){
            if($('#ic_recusa').is(":checked")){
               if($('#obs_recusa').val()==""){
                    $("#alert_ds_recusa_ocorrencia").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert_ds_recusa_ocorrencia").slideUp(500);
                    });
                    $('#obs_recusa').focus();
                    return false;
                }
            }else{   
                if($('#dt_prazo_execucao').val()==""){
                    $("#alert_dt_prazo_execucao").fadeTo(2000, 500).slideUp(500, function(){
                        $("#alert_dt_prazo_execucao").slideUp(500);
                    });
                    $('#dt_prazo_execucao').focus();
                    return false;
                }
            }
            fcEnviarOcorrencia(); //Se a validação deu certo, faz o envio do formulario.            
            return false;
        }      
    });    
}

function fcCarregarComboEquipe(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("equipe", "listarTodos", objParametros);   
    carregarComboAjax($("#agenda_equipes_pk"), arrCarregar, " ", "pk", "ds_equipe");        
}

function fcCarregarComboUsuario(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("usuario", "listarTodos", objParametros);    
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, " ", "pk", "ds_usuario");
        
}


function fcCarregarFechamentoAutomatico(v_tipo_ocorrencia_pk){
    
    if(v_tipo_ocorrencia_pk > 0){

        var objParametros = {
            "pk": v_tipo_ocorrencia_pk
        };        
        
        var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ic_fechar_ocorrencia_auto").val(arrCarregar.data[0]['ic_fechar_ocorrencia_auto']);
            
            if(arrCarregar.data[0]['ic_fechar_ocorrencia_auto'] == 1){               
                $("input[id=dt_fechamento]").prop("checked", "true");
                $("input[id=dt_fechamento]").prop("disabled", "true");
                //Desabilita o marcador para retorno
                $("#agenda_visible").hide();
                $('#agenda_retorno').prop('checked', false);
                $("input[id=agenda_retorno]").prop("disabled", "true"); 
                //Limpa os dados do retorno
                $("#agenda_retorno_pk").val("");
                $("#edit_agenda_visible").hide();
                $("#agenda_equipe_visible").hide();
                $("#agenda_responsavel_visible").hide();
                $('#agenda_retorno').prop('checked', false);
                $("#agenda_dt_retorno").val("");
                $("#agenda_hr_retorno").val("");
                $("#agenda_ic_agendar_para").val("");
                $("#agenda_equipes_pk").val("");
                $("#agenda_responsavel_pk").val("");
                $("#agenda_ds_retorno").val("");
            }
            else{
                $('#dt_fechamento').prop('checked', false);
                $('#dt_fechamento').prop('disabled', false);                
                $('#agenda_retorno').prop('disabled', false);
            }
            

        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}

function fcMostrarAgendaRetorno(){
    if($('#agenda_retorno').is(":checked")){
        $("#agenda_visible").show();
        $('#dt_fechamento').prop('checked', false);
        $("input[id=dt_fechamento]").prop("disabled", "true");
        ///Deixa Combo usuario marcado        
        $('#ic_usuario').prop('checked', true); 
        $('#ic_usuario').prop('checked', true);
        $('#ic_equipe').prop('checked', false);
        $('#agenda_responsavel_visible').show();
        $('#agenda_equipe_visible').hide();
        
    }
    else{
        $("#agenda_visible").hide();
        $('#dt_fechamento').prop('disabled', false);   
    }
}




function fcIncluirLinhaArquivoOc(nome_original){
    tblDocumentosOc.row.add(
            {
            "t_pk":"",
            "t_ds_documento":$("#ds_documento_oc").text(),
            "t_ds_nome_original":nome_original,
            "t_functions":"<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
        }
    ).draw( false );

    //Adiciona o evento click na linha que acabou de ser adicionada.
    $(".function_delete").on("click",fcApagarArquivoOc);
    return false;
}


function Reset(){
    $('#progressOc .progress-bar').css('width', '0%');
}
$(function () {
    
    $('#fileuploadOc').fileupload({
        
        dataType: 'json',
        done: function (e, data) {
            window.setTimeout('Reset()', 2000);
   
            $.each(data.files, function (index, file) {
                
                $("#ds_nome_original_oc").html(file.name);
                //tblDocumentosOc.clear().destroy();    
                //fcCarregarGridDocumentosOC();
                fcAlterarNomeArquivoOc(file.name);
                fcIncluirLinhaArquivoOc(file.name);
                
                
                               
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

function fsClean() {
    $('#progressOc .progress-bar').css('width', '0%');
}

function fcFormatarDadosArquivosOc(){

    var DocOcPk = "";
    var dsDocumento = "";
    var dsNomeOriginal = "";
    
    var arrKeys = [];
    arrKeys[0] = "doc_oc_pk";
    arrKeys[1] = "ds_documento";
    arrKeys[2] = "ds_nome_original";
    
    var arrDados = [];
    var i = 0;
        $('#tblDocumentosOc tbody tr').each(function () {
            
        var colunas = $(this).children();
            DocOcPk =  $(colunas[0]).text(); 
            dsDocumento =  $(colunas[1]).text(); 
            dsNomeOriginal = $(colunas[2]).text();
            
            
            arrDados[i] = [DocOcPk,dsDocumento, dsNomeOriginal];
            i++;
        });
       
    return arrayToJson(arrKeys, arrDados);
    
}

function fcAlterarNomeArquivoOc(v_arquivo){    
    
    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "ds_arquivo": v_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "renomearArquivo", objParametros);           
         
    if (arrEnviar.result == 'success'){
        // Reload datable
        $("#ds_documento_oc").text(arrEnviar.data[0]['t_ds_nome_salvo']);
        
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }    
}

function fcApagarArquivoOc(){
    var nome_arquivo = "";
    $('#tblDocumentosOc tbody tr').click(function () {
        var colunas = $(this).children();
        nome_arquivo = $(colunas[0]).text();
        fcExcluirArquivoOc(nome_arquivo);
    });
    
    tblDocumentosOc.row($(this).parents('tr')).remove().draw();
}

function fcCancelarEnvioDocumentoOc(){
    var nome_arquivo = "";
    $('#tblDocumentosOc tbody tr').each(function () {
        var colunas = $(this).children();
            var colunas = $(this).children();
            nome_arquivo = $(colunas[0]).text();
            fcExcluirArquivoOc(nome_arquivo);
        });
}


function fcExcluirArquivoOc(v_nome_arquivo){
    var objParametros = {
        "nome_arquivo": v_nome_arquivo
    };       
    
    
    var arrEnviar = carregarController("documento", "removerArquivo", objParametros);           
           
    if (arrEnviar.result == 'success'){
        
    }
}

function fcCarregarGridDocumentosOC(){
    var objParametros = {
        "ocorrencias_pk": $("#ocorrencias_pk").val()
    };     
    
    var v_url = montarUrlController("documento", "listarDocumentosOc", objParametros);
 
    //Trata a tabela
    tblDocumentosOc = $('#tblDocumentosOc').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit' download><span><img width=16 height=16 src='../img/download.png'></span></a>&nbsp;&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "t_ds_nome_original"},
           {"targets": -3, "data": "t_ds_documento"},
           {"targets": -4, "data": "t_pk"}

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblDocumentosOc tbody').on('click', '.function_edit', function () {
        var data;
        
        if(tblDocumentosOc.row( $(this).parents('li') ).data()){
            data = tblDocumentosOc.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentosOc.row( $(this).parents('tr') ).data()){
            data = tblDocumentosOc.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcDownloadDocumentoOc(data['t_ds_documento']);
        }
    });
    $('#tblDocumentosOc tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblDocumentosOc.row( $(this).parents('li') ).data()){
            data = tblDocumentosOc.row( $(this).parents('li') ).data();
        }
        else if(tblDocumentosOc.row( $(this).parents('tr') ).data()){
            data = tblDocumentosOc.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirDocumentoOc(data['t_pk'],data['t_ds_documento']);
        }
    });
}

function fcDownloadDocumentoOc(ds_documento){
    var arrCarregar = permissao("documento", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumentoOc(v_pk,v_ds_documento){
    var arrCarregar = permissao("documento", "del");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(v_pk != ""){
        
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("documento", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            fcExcluirArquivoOc(v_ds_documento);
            tblDocumentosOc.clear().destroy();    
            fcCarregarGridDocumentosOC();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}

function fcPegarNomeTipoOc(v_tipo_ocorrencia_pk){
    
    if(v_tipo_ocorrencia_pk > 0){

        var objParametros = {
            "pk": v_tipo_ocorrencia_pk
        };        
        
        var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            $("#ds_tipo_ocorrencia").val(arrCarregar.data[0]['ds_tipo_ocorrencia']);
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
    
}

function fcMostrarDocumento(){
    if($('#ic_docs').is(":checked")){
        $('#doc').show();
        tblDocumentosOc.clear().destroy();
        fcCarregarGridDocumentosOC();
        
    }
    else{
        $('#doc').hide();
    }
}
function fcColorirGrid(){
    setTimeout(function(){
        $('#tblResultado tbody tr').each(function () {
             var colunas = $(this).children();
      
             if($(colunas[6]).text()=="Não lido"){
                 for(i=0;i<19;i++){
                     $(colunas[i]).css("background-color", "#FFFF00"); 
                 }
             }
             if($(colunas[6]).text()=="Dentro do prazo"){
                 for(i=0;i<19;i++){
                     $(colunas[i]).css("background-color", "#1dc2ff"); 
                 }
             }
             if($(colunas[6]).text()=="Chamado atrasado"){
                 for(i=0;i<19;i++){
                     $(colunas[i]).css("background-color", "#FF4500"); 
                 }
             }
             if($(colunas[6]).text()=="Chamado recusado"){
                 for(i=0;i<19;i++){
                     $(colunas[i]).css("background-color", "#fab14c"); 
                 }
             }
             if($(colunas[6]).text()=="Finalizado"){
                 for(i=0;i<19;i++){
                     $(colunas[i]).css("background-color", "#47e51f"); 
                 }
             }
         });
     }, 2000);
}
function fcCarregarComboColaboradorOcorrencia(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);    
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    carregarComboAjax($("#colaborador_pk_ocorrencia_ins"), arrCarregar, " ", "pk", "ds_colaborador");
        
}
$(document).ready(function(){
    var arrCarregar = permissao("ocorrencia", "cons");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    fcCarregarGridDocumentosOC();
    fcCarregarLeads();
    fcCarregarComboEquipeRes();
    fcCarregarComboColaboradorOcorrencia();
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#tipo_ocorrencia_pk").change(function(){
        fcCarregarFechamentoAutomatico($("#tipo_ocorrencia_pk").val());
        
        fcPegarNomeTipoOc($("#tipo_ocorrencia_pk").val());
        
    }); 
    
    //carrega cadastro ini
    $('#dt_cadastro').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro").keypress(function(){
       mascara(this,mdata);
    });
    
        
    //carrega cadastro fim
    $('#dt_cadastro_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_cadastro_fim").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_prazo_execucao_ini').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_prazo_execucao_ini").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_prazo_execucao_fim').datepicker({
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_prazo_execucao_fim").keypress(function(){
       mascara(this,mdata);
    });
    
    fcCarregarTipoOcorrenciaRes();    
    fcCarregarComboUsuarioRes();    
    //faz a carga inicial do grid
    fcCarregarGrid();
    
    fcColorirGrid();
    
    
    fcFormatarGridEnvioEmail();
    
    //Valida Campos Ocorrencia
    fcValidarFormOcorrencia();
    
    //fcValidarFormOcorrencia();
    ///fcValidarFormOcorrencia();
    //Atribui os eventos dos demais controles
    $(document).on('click', '#cmdPesquisar', fcPesquisar);  
    $(document).on('click', '#cmdEnviarEmail', fcEnviarEmail);  
    

    $(document).on('click', '#dt_termino_retorno', fcEditRetornoFechaOC);    
        
    $(document).on('click', '#cmdIncluirNovaOcLeadCombo', fcAbrirFormNovaOcorrenciaLeadCombo);

    //AGENDA RETORNO
    $(document).on('click', '#agenda_retorno', fcMostrarAgendaRetorno);
    $(document).on('click', '#ic_docs', fcMostrarDocumento);
    
    $('#dt_prazo_execucao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#dt_prazo_execucao").keypress(function(){
       mascara(this,mdata);
    });

    //carrega datepicker com a data atual (Agenda)
     $('#agenda_dt_retorno').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#agenda_dt_retorno").keypress(function(){
       mascara(this,mdata);
    });
    $("#agenda_hr_retorno").keypress(function(){
       mascara(this,horamask);
    });               

    $('#edit_agenda_dt_retorno_termino').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", new Date() ); 
    $("#edit_agenda_dt_retorno_termino").keypress(function(){
       mascara(this,mdata);
    });
    $("#edit_agenda_hr_retorno_termino").keypress(function(){
       mascara(this,horamask);
    });
    

    /*$("#tipo_ocorrencia_pk").blur(function(){
        fcCarregarFechamentoAutomatico($("#tipo_ocorrencia_pk").val());
    }); */

    //EXIBE O COMBO DE AGENDA DE ROTORNO DE USUARIOS E EQUIPES 
    $('#ic_equipe').click(function() {           
        $('#ic_equipe').prop('checked', true);
        $('#ic_usuario').prop('checked', false);
        $('#agenda_responsavel_visible').hide();
        $('#agenda_equipe_visible').show();
    });
    $('#ic_usuario').click(function() {       
        $('#ic_usuario').prop('checked', true);
        $('#ic_equipe').prop('checked', false);
        $('#agenda_responsavel_visible').show();
        $('#agenda_equipe_visible').hide();
    });
    

    
    //Recusa OC
    $('#ic_recusa').click(function() {  
        if($('#ic_recusa').is(":checked")){     
            //$('#div_ds_recusa').hide();
            $('#div_ds_recusa').show();
            $("input[id=dt_prazo_execucao]").prop("disabled", "true");
            $("textarea[id=obs_execucao]").prop("disabled", "true");
        }else{            
            $('#div_ds_recusa').hide();
            $("input[id=dt_prazo_execucao]").prop("disabled", false);
            $("textarea[id=obs_execucao]").prop("disabled", false);
        }
    });
   

    $("#edit_agenda_visible").hide();

    //CARREGA COMBO USUARIO E EQUIPE AGENDA
    fcCarregarComboEquipe();
    
    fcCarregarComboUsuario();

    //carrega dados da grid de ocorrencias

    fcCarregarGridOcorrencia();
    
    
    //Valida Campos Ocorrencia
    fcValidarFormOcorrencia();

    //carrega combo
    fcCarregarTipoOcorrencia(); 
    
    
    fcCarregarGridDocumentosOC();
    
    $('#doc').hide();
    
    
    
    
    
    
    
    

});


