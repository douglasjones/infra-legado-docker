
function fcEnviarOcorrencia(){
    try {
        if($("#tipos_ocorrencias_pk").val()==""){
            alert('Por favor, informe o tipo de ocorrência!');
            return false;
        }
        
        if($("#ds_ocorrencia").val()==""){
            alert('Por favor, informe uma descrição para a ocorrência!');
            return false;
        } 
    
        var v_ocorrencias_pk = $("#ocorrencias_pk").val();
        var v_leads_pk = $("#leads_pk").val();
        var v_tipos_ocorrencias_pk = $("#tipos_ocorrencias_pk").val();
        var v_ds_ocorrencia = $("#ds_ocorrencia").val(); 
        var v_motivo_sem_interesse_pk = $("#motivo_sem_interesse_pk").val();
        var v_ds_motivo_sem_interesse = $("#ds_motivo_sem_interesse").val();
        var v_classificacao_lead_pk = $("#classificacao_lead_pk").val();
    
        var v_agenda_dt_retorno = "";
        var v_agenda_hr_retorno = "";
        var v_agenda_equipes_pk = "";
        var v_agenda_responsavel_pk = "";
        var v_agenda_ds_retorno = "";
        var v_agenda_retorno_pk = "";
        
        if($("#agenda_retorno_pk").val()!=""){
            v_agenda_equipes_pk = $("#edit_agenda_equipes_pk").val();
            v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
            v_agenda_retorno_pk = $("#agenda_retorno_pk").val(); 
            v_agenda_responsavel_pk = $("#edit_agenda_responsavel_pk").val();
        }else{
            v_agenda_dt_retorno = $("#agenda_dt_retorno").val();
            v_agenda_hr_retorno = $("#agenda_hr_retorno").val();
            v_agenda_equipes_pk = $("#agenda_equipes_pk").val();
            v_agenda_ds_retorno = $("#agenda_ds_retorno").val();
            v_agenda_retorno_pk = $("#agenda_retorno_pk").val(); 
            v_agenda_responsavel_pk = $("#agenda_responsavel_pk").val();
        }
     
        if($('#dt_fechamento').is(":checked")){
            v_dt_fechamento = 1;
        } else{
            v_dt_fechamento = 2;
        }
        if($('#agenda_retorno').is(":checked")){
            v_agenda_retorno = 1;
        }else{
            v_agenda_retorno = 2;
        }
    
        if($('#dt_termino_retorno').is(":checked")){
            v_dt_retorno_termino = 1;
        }else{
            v_dt_retorno_termino = 2;
        }
    
        var objParametros = {
            "pk": v_ocorrencias_pk,
            "leads_pk": v_leads_pk,
            "ds_ocorrencia":v_ds_ocorrencia,
            "tipos_ocorrencias_pk":v_tipos_ocorrencias_pk,
            "dt_fechamento":v_dt_fechamento,
            "dt_retorno":v_agenda_dt_retorno,
            "hr_retorno":v_agenda_hr_retorno,
            "equipes_pk":v_agenda_equipes_pk,
            "responsavel_pk":v_agenda_responsavel_pk,
            "ds_retorno":v_agenda_ds_retorno,  
            "dt_termino_retorno":v_dt_retorno_termino,
            "motivo_sem_interesse_pk":v_motivo_sem_interesse_pk,
            "ds_motivo_sem_interesse":v_ds_motivo_sem_interesse, 
            "agenda_retorno":v_agenda_retorno,
            "agenda_retorno_pk": v_agenda_retorno_pk,
            "classificacao_lead_pk": v_classificacao_lead_pk 
        };    
        
        var arrEnviar = carregarController("ocorrencia", "salvar", objParametros); 
        NewWindow(v_last_url)
        /*if (arrEnviar.result == 'success'){
            // Reload datable
            alert(arrEnviar.message);
            $("#janela_ocorrencia_cad").modal('hide');        
    
            tblOcorrencia.ajax.reload();
        }
        else{
            alert('Falhou a requisição para salvar o registro');
        }*/
    } catch (error) {
       alert(error) 
    }
  
    
}

function fcAbrirFormNovaOcorrencia(){

    $("#ocorrencias_pk").val("");
    $("#ds_ocorrencia").val("");
    $("#tipos_ocorrencias_pk").val("");
    $('#tipos_ocorrencias_pk').prop('disabled', false);
    $('#dt_fechamento').prop('checked', false);
    $('#motivo_sem_interesse_pk').prop('disabled', false);
    
    //AGENDA RETORNO
    $("#agenda_visible").hide();
    $("#sem_interesse").hide();
    $("#agenda_retorno_pk").val("");
    $("#motivo_sem_interesse_pk").val("");
    $("#ds_motivo_sem_interesse").val("");
    
    $("#edit_agenda_visible").hide();
    $("#agenda_equipe_visible").hide();
    $("#agenda_responsavel_visible").hide();
    $('#agenda_retorno').prop('checked', false);
    $('#agenda_retorno').prop('disabled', false);
    $("#agenda_dt_retorno").val("");
    $("#agenda_hr_retorno").val("");
    $("#agenda_ic_agendar_para").val("");
    $("#agenda_equipes_pk").val("");
   
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
    $('#n_retorno').prop('checked', false);
    $('#n_retorno').prop('disabled', true);
    $("#agenda_ds_retorno").val("");
    $('#agenda_ds_retorno').prop('disabled', false);

    $('#cmdEnviarOcorrencia').prop('disabled', false);
    $('#dt_fechamento').prop('disabled', false);
    $('#dt_termino_retorno').prop('checked', false);
    $('#ds_ocorrencia').prop('disabled', false);

    $("#agenda_ds_retorno").html("");
    
    $("#janela_ocorrencia_cad").modal();
}


function fcCarregarOcorrencia(ocorrencias_pk){
    alert(ocorrencias_pk)

    var objParametros = {
        "pk": ocorrencias_pk
    };        
    
    var arrCarregar = carregarController("ocorrencia", "listarPorPk", objParametros);
    NewWindow(v_last_url)

    if (arrCarregar.result == 'success'){
        $("#ocorrencias_pk").val(arrCarregar.data[0]['t_pk']);
        $("#tipos_ocorrencias_pk").val(arrCarregar.data[0]['t_tipos_ocorrencias_pk']);
        $('#tipos_ocorrencias_pk').prop('disabled', true);
        $("#ds_ocorrencia").val(arrCarregar.data[0]['t_ds_ocorrencia']);
        $("#motivo_sem_interesse_pk").val(arrCarregar.data[0]['motivo_sem_interesse_pk']);
        $("#ds_motivo_sem_interesse").val(arrCarregar.data[0]['ds_motivo_sem_interesse']);
        $("#processos_etapas_pk").val(arrCarregar.data[0]['processos_etapas_pk']);

         //chama função de retorno
         fcEditarRetorno(arrCarregar.data[0]['t_pk'])   

        if(arrCarregar.data[0]['t_dt_fechamento']!=null){
            $("input[id=dt_fechamento]").prop("checked", "true");
            $('#ds_ocorrencia').prop('disabled', true);
            $('#cmdEnviarOcorrencia').prop('disabled', true);
        }
                
        $("#dt_fechamento").val(arrCarregar.data[0]['t_dt_fechamento']);
        
        $("#motivo_sem_interesse_pk").val(arrCarregar.data[0]['motivo_sem_interesse_pk']);
        $("#ds_motivo_sem_interesse").val(arrCarregar.data[0]['ds_motivo_sem_interesse']);
        $("#processos_etapas_pk").val(arrCarregar.data[0]['processos_etapas_pk']);

        
        //Carrega as informações da linha selecionada.
        if(arrCarregar.data[0]['t_dt_fechamento']!=null){
                $("input[id=dt_fechamento]").prop("checked", "true");
                $('#dt_fechamento').prop('disabled', true);
                $("#sem_interesse").hide();
        }
    
        
        if(arrCarregar.data[0]['t_motivo_sem_interesse_pk']!="" && arrCarregar.data[0]['t_motivo_sem_interesse_pk']!=null){
            $("#sem_interesse").show();
            $('#motivo_sem_interesse_pk').prop('disabled', true);
            $("#motivo_sem_interesse_pk").val(arrCarregar.data[0]['t_motivo_sem_interesse_pk']);
            $("#ds_motivo_sem_interesse").val(arrCarregar.data[0]['t_ds_motivo_sem_interesse']);
        }

    
        //carrega agenda retorno
        fcEditarRetorno(arrCarregar.data[0]['t_pk']); 

    }
    else{
        alert('Falhar ao carregar o registro');
    }
  
}

//FINAL DOCUMENTOS UPLOAD
function fcEditarRetorno(ocorrencias_pk){
    if(ocorrencias_pk > 0){

        var objParametros = {
            "ocorrencias_pk": ocorrencias_pk,
            "pk":""
        };        
        
        var arrCarregar = carregarController("retorno", "listarOcorrenciasPk", objParametros);
        
        if (arrCarregar.result == 'success'){
            if(arrCarregar.data.length > 0){
                
                $("input[id=agenda_retorno]").prop("checked", "true");
                $("input[id=agenda_retorno]").prop("disabled", "true");
                $("#edit_agenda_dt_retorno").html(arrCarregar.data[0]['dt_retorno']);
                $("#edit_agenda_hr_retorno").html(arrCarregar.data[0]['hr_retorno']);          
                $("#agenda_ds_retorno").val(arrCarregar.data[0]['ds_retorno']);
                $('#agenda_ds_retorno').prop('disabled', false);
                $('#dt_termino_retorno').prop('checked', false);
                $("input[id=dt_termino_retorno]").prop("disabled", false);
                
                $("#agenda_retorno_pk").val(arrCarregar.data[0]['pk']);
                
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var hh = today.getHours();
                var min = today.getMinutes();
                //data
                if(dd<10) {
                    dd = '0'+dd
                } 
                if(mm<10) {
                    mm = '0'+mm
                }     
                //hora 
                if(hh<10) {
                    hh = '0'+hh
                } 
                if(min<10) {
                    min = '0'+min
                } 
                var dtAtual = dd+"/"+mm+"/"+yyyy;
                var str_hora = hh + ':' + min;    
                var strData = arrCarregar.data[0]['dt_retorno'];
                var partesData = strData.split("/");
                var hora1 = arrCarregar.data[0]['hr_retorno'].split(":");       
                var strDataAgora = dtAtual;
                var partesDataAtual = strDataAgora.split("/");
                var hora2 = str_hora.split(":");               
                var data = new Date(partesData[2], partesData[1] - 1, partesData[0], hora1[0], hora1[1]);
                var data_atual = new Date(partesDataAtual[2], partesDataAtual[1] - 1, partesDataAtual[0], hora2[0], hora2[1]);
                
                if(data_atual > data){
                    
                    if(arrCarregar.data[0]['dt_termino_retorno']!=null){
                       $("input[id=n_retorno]").prop("disabled", true);
                      
                    }
                }
                else{
                    if(arrCarregar.data[0]['dt_termino_retorno']!=null){
                        $("input[id=n_retorno]").prop("disabled", true);
                    }
                }
                
                                  
                if(arrCarregar.data[0]['dt_termino_retorno']!=null){  
                    $('#dt_termino_retorno').prop('checked', true);
                    $("input[id=dt_termino_retorno]").prop("disabled", "true");                    
                    //descrição do retorno
                    $('#agenda_ds_retorno').prop('disabled', true);                    
                    //Desabilita o fechamento da Ocorrencia
                    //$("input[id=dt_fechamento]").prop("disabled", "true");
                    
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

function fcCarregarTipoOcorrencia(){
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarTodos", objParametros);    

    carregarComboAjax($("#tipos_ocorrencias_pk"), arrCarregar, " ", "pk", "ds_tipo_ocorrencia");        
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
    carregarComboAjax($("#agenda_responsavel_pk"), arrCarregar, "", "pk", "ds_usuario");        
}
function fcCarregarComboResponsavelEquipe(){     
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

function fcAbrirNovoRetorno(){
    $('#dt_termino_retorno').prop('checked', true); 
    fcEnviarOcorrencia();
    setTimeout(function(){
        fcAbrirFormNovaOcorrencia();
    }, 3000);
   
}


$(document).ready(function(){
    var arrCarregar = permissao("ocorrencia", "cons");        
    
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    
    fcCarregarTipoOcorrencia(); 
    fcCarregarComboEquipe();
    fcCarregarComboUsuario();

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

    
    $("#tipos_ocorrencias_pk").change(function(){       
        fcCarregarFechamentoAutomatico($("#tipos_ocorrencias_pk").val());
        if($("#tipos_ocorrencias_pk option:selected").text()=='Sem Interesse'){
            $('#sem_interesse').show();                
            $("#motivo_sem_interesse_pk").change(function(){
                fcPegarNomeMotivoSemInteresse($("#motivo_sem_interesse_pk").val());
            });
        }
        else{
            $('#sem_interesse').hide();
        }
    }); 
    

    $('#agenda_responsavel_pk').click(function(){ 
        if(click==1){
            
            $('#agenda_responsavel_pk').val("");
            fcCarregarComboUsuarioTodos();
        }
        click++;
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

    //Atribui a validação do formulário dos campos obrigatórios
    
    $(document).on('click', '#agenda_retorno', fcMostrarAgendaRetorno);
    $(document).on('click', '#cmdEnviarOcorrencia', fcEnviarOcorrencia);

    //Verifica se o registro é para alteracao e puxa os dados.
    fcCarregarOcorrencia();
});
