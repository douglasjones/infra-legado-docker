var tblOcorrencia;
var leads_pk = "";
function fcPesquisar(){
	
    tblOcorrencia.clear().destroy();
    fcCarregarGridOcorrencia();
    
}
function fcCarregarGridOcorrencia(){  

    var objParametros = {
        "leads_pk": $("#leads_pk").val(),
        "leads_usuarios_pk": $("#leads_usuarios_pk").val(),
        "dt_cadastro_ini":$("#dt_cadastro_ini_pesq").val(),
        "dt_cadastro_fim":$("#dt_cadastro_fim_pesq").val(),
        "oc_aberta_fechado":$("#oc_aberta_fechado").val(),
        "tipos_ocorrencias_pk":$("#tipo_ocorrencia_pk_pesq").val()
    };     
    var v_url = montarUrlController("ocorrencia", "listarOcorrenciaClientes", objParametros);
    //NewWindow(v_last_url)
    //Trata a tabela
    tblOcorrencia = $('#tblOcorrencia').DataTable({
        "scrollX": false,
        "bPaginate": true,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=16 height=16 title='Editar Ocorrência' src='../img/copiar.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_painel'><span><img width=16 height=16 title='Acessar Painel do Lead' src='../img/painel.png'></span></a>&nbsp;&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },      
           {"targets": -2, "data": "t_dt_termino_retorno"}, 
           {"targets": -3, "data": "t_ds_retorno"},
           {"targets": -4, "data": "t_dt_retorno"},
           {"targets": -5, "data": "t_agendado_para"},            
           {"targets": -6, "data": "t_nome_usuario_cadastro"},
           {"targets": -7, "data": "t_ds_ocorrencia"},
           {"targets": -8, "data": "t_tipos_ocorrencias_pk" ,"visible":false},
           {"targets": -9, "data": "t_ds_tipo_ocorrencia"}, 
           {"targets": -10, "data": "t_dt_fechamento"},
           {"targets": -11, "data": "t_ds_status"}, 
           {"targets": -12, "data": "t_dt_prazo_execucao"},           
           {"targets": -13, "data": "t_dt_cadastro"},           
           {"targets": -14, "data": "t_ds_lead"},
           {"targets": -15, "data": "t_pk"},
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblOcorrencia tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblOcorrencia.row( $(this).parents('li') ).data()){
            data = tblOcorrencia.row( $(this).parents('li') ).data();
        }
        else if(tblOcorrencia.row( $(this).parents('tr') ).data()){
            data = tblOcorrencia.row( $(this).parents('tr') ).data();
        }
        
        if(data['t_pk'] != ""){
            fcExcluirOcorrencia(data['t_pk']);
        }
    } );
    
    $('#tblOcorrencia tbody').on('click', '.function_edit', function () {
        var data;
        
        rLinhaSelecionada = null;
        
        if(tblOcorrencia.row( $(this).parents('li')).data()){
            data = tblOcorrencia.row( $(this).parents('li')).data();
            rLinhaSelecionada = $(this).parents('li');
        }
        else if(tblOcorrencia.row( $(this).parents('tr')).data()){
            data = tblOcorrencia.row( $(this).parents('tr')).data();
            rLinhaSelecionada = $(this).parents('tr');
        }
        fcEditarOcorrencia(data);        
    } ); 
       fcColorirGrid();
}

function fcAbrirFormNovaOcorrencia(){
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
    setTimeout(function(){
        tblDocumentosOc.clear().destroy();
        fcCarregarGridDocumentosOC();
    }, 2000);
    
    $('#doc').hide();
    $("#janela_ocorrencia").modal();
    
    
}

function fcEditarOcorrencia(objRegistro){    

    fcAbrirFormNovaOcorrencia();
  
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
    $("#ic_status_fechamento").val(objRegistro['t_ic_status_fechamento']);
    
    
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
    
    $('#obs_execucao').prop('disabled', true);
    $('#obs_execucao').val(objRegistro['t_obs_execucao']);
    if(objRegistro['t_dt_prazo_execucao']!=null){
        $('#obs_execucao').prop('disabled', false);
    }
    else{
        $('#obs_execucao').prop('disabled', true);
        $('#obs_execucao').val("");
    }
    $('#obs_status').prop('disabled', true);
    $('#obs_status').val(objRegistro['t_obs_status']);
    if(objRegistro['t_ic_status_fechamento']==2 || objRegistro['t_ic_status_fechamento']==3){
        $('#obs_status').prop('disabled', false);
    }
    else{
        $('#obs_status').prop('disabled', true);
        
    }
    
    
    
    
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

    fcAbrirFormNovaOcorrencia();
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

    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("ocorrencia", "excluir", objParametros);   

        if (arrExcluir.result == 'success'){

            //Exibe a mensagem
            alert(arrExcluir.message);
            tblOcorrencia.clear().destroy();    
            fcCarregarGridOcorrencia();
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
         v_agenda_dt_retorno = $("#edit_agenda_dt_retorno").val();
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
  
    if($("#ocorrencias_pk").val()==''){
        var objParametros = {        
            "leads_pk": $("#leads_ocorrencia_pk").val(),
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
            //"dt_prazo_execucao":$("#dt_prazo_execucao").val(),
            //"ic_status_fechamento":$("#ic_status_fechamento").val(),
            //"obs_status":$("#obs_status").val(),
            //"obs_execucao":$("#obs_execucao").val(),
            "clientes_pk":1,
            "doc_oc":strJSONDadosTabela
        };
    }else{
        var objParametros = {      
            "leads_pk": $("#leads_ocorrencia_pk").val(),
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
            "ic_status_fechamento":$("#ic_status_fechamento").val(),
            "obs_status":$("#obs_status").val(),
            "obs_execucao":$("#obs_execucao").val(),
            "clientes_pk":1,
            "doc_oc":strJSONDadosTabela
        };
    }

    var arrEnviar = carregarController("ocorrencia", "salvar", objParametros); 
   
    if (arrEnviar.result == 'success'){                
        // Reload datable
        //alert(arrEnviar.message);
        //$("#janela_ocorrencia").modal("hide"); 
            //tblOcorrencia.clear().destroy();    
            //fcCarregarGridOcorrencia();   
            
        alert(arrEnviar.message);
        $("#janela_ocorrencia").modal("hide"); 

        tblOcorrencia.clear().destroy();    
        fcCarregarGridOcorrencia();
        
        fcColorirGrid();
            
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
    carregarComboAjax($("#tipo_ocorrencia_pk_pesq"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");
        
}
// Validaão de OC 
function fcValidarFormOcorrencia(){
    
    $("#form_ocorrencia").validate({
        rules :{
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

    var v_url = "../docs/"+ds_documento;
    window.open(v_url, '_blank');
}

function fcExcluirDocumentoOc(v_pk,v_ds_documento){

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
function fcListarLeadsPkUsuarioLogado(){
    var objParametros = {
        "pk": ""
    };        

    var arrCarregar = carregarController("usuario", "listarUsuarioLogado", objParametros);

    if (arrCarregar.result == 'success'){
        $("#leads_pk").val(arrCarregar.data[0]['leads_pk']);
        $(".ds_usuario").text(arrCarregar.data[0]['ds_usuario']);
    }else{
        alert('Falhar ao carregar o registro');
    }
}
function fcColorirGrid(){
    setTimeout(function(){
        $('#tblOcorrencia tbody tr').each(function () {
             var colunas = $(this).children();
      
             if($(colunas[4]).text()=="Não lido"){
                 for(i=0;i<15;i++){
                     $(colunas[i]).css("background-color", "#FFFF00"); 
                 }
             }
             if($(colunas[4]).text()=="Dentro do prazo"){
                 for(i=0;i<15;i++){
                     $(colunas[i]).css("background-color", "#1dc2ff"); 
                 }
             }
             if($(colunas[4]).text()=="Chamado atrasado"){
                 for(i=0;i<15;i++){
                     $(colunas[i]).css("background-color", "#FF4500"); 
                 }
             }
             if($(colunas[4]).text()=="Chamado recusado"){
                 for(i=0;i<15;i++){
                     $(colunas[i]).css("background-color", "#fab14c"); 
                 }
             }
             if($(colunas[4]).text()=="Finalizado"){
                 for(i=0;i<15;i++){
                     $(colunas[i]).css("background-color", "#47e51f"); 
                 }
             }
         });
     }, 4000);
}

function fcCarregarLeads(){
    //Carrega os grupos
     
    var objParametros = {
        "leads_pk_pai": $("#leads_pk").val()
    };      
    
    var arrCarregar = carregarController("lead", "listaLeadsClientesPK", objParametros); 
    carregarComboAjax($("#leads_usuarios_pk"), arrCarregar, " ", "pk", "ds_lead");    
}

function fcCarregarLeadsNewOC(){
    //Carrega os grupos
     
    var objParametros = {
        "leads_pk_pai": $("#leads_pk").val()
    };      
    
    var arrCarregar = carregarController("lead", "listaLeadsClientesPK", objParametros); 
    carregarComboAjax($("#leads_ocorrencia_pk"), arrCarregar, "", "pk", "ds_lead");    
}


$(document).ready(function(){   
    
    fcListarLeadsPkUsuarioLogado();
    $(document).on('click', '#dt_termino_retorno', fcEditRetornoFechaOC);    
    $(document).on('click', '#cmdIncluirOcorrencia', fcAbrirFormNovaOcorrencia);
    $(document).on('click', '#cmdPesquisar', fcPesquisar);
    $(document).on('click', '#agenda_retorno', fcMostrarAgendaRetorno);
    $(document).on('click', '#ic_docs', fcMostrarDocumento);
        
    fcCarregarLeads();
    fcCarregarLeadsNewOC();
    
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
    
    $('#dt_cadastro_ini_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", ""); 
    $("#dt_cadastro_ini_pesq").keypress(function(){
       mascara(this,mdata);
    });
    $('#dt_cadastro_fim_pesq').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate", ""); 
    $("#dt_cadastro_fim_pesq").keypress(function(){
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
    
    fcColorirGrid();
    
    $('#doc').hide();
    
    
    $('#obs_execucao').prop('disabled', true);
    $("#dt_prazo_execucao").change(function(){
        if($("#dt_prazo_execucao").val()!=""){
            $('#obs_execucao').prop('disabled', false);
        }
        else{
            $('#obs_execucao').prop('disabled', true);
            $('#obs_execucao').val("");
        }
    });
    $('#obs_status').prop('disabled', true);
    $("#ic_status_fechamento").change(function(){
       if($("#ic_status_fechamento").val()==2 || $("#ic_status_fechamento").val()==3){
           $('#obs_status').prop('disabled', false);
       }
       else{
           $('#obs_status').prop('disabled', true);
           $('#obs_status').val("");
       }
   });
    
    $("#tipo_ocorrencia_pk").change(function(){
        fcCarregarFechamentoAutomatico($("#tipo_ocorrencia_pk").val());
        
        fcPegarNomeTipoOc($("#tipo_ocorrencia_pk").val());
        
    }); 
});
