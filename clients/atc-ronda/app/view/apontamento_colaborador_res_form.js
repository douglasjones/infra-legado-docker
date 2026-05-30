var tblEscala;
var tblGridDados;
var grid_agenda;
var tabela  ;

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();  

if(dd<10) {
    dd = '0'+dd
} 
if(mm<10) {
    mm = '0'+mm
}   
var dtAtual = dd+'/'+mm+'/'+yyyy;

//ABRE MODAL PRINCIPAL
function fcAbrirModalPainelApontamento(str_colaborador_pk,str_leads_pk,str_dt_agenda,strGridAgenda){
  
   $("#html_modal_painel").empty();
   $("#html_modal_painel").append("");
    
    var strModal="";
    
    //CASO CONTRARIO EXIBE O MODAL DE TRABALHO

    strModal+="<div style='overflow: scroll;' class='modal fade bd-example-modal-lg' id='janela_modal_painel' tabindex='-1' role='dialog' aria-labelledby='janela_contatosLabel' aria-hidden='true'>";
    strModal+="    <div class='modal-dialog modal-lg' role='document'>";

    strModal+="        <div class='modal-content'>";
    strModal+="            <div class='modal-header'>";
    strModal+="                <h5 class='modal-title' id='janela_contatosLabel'>Apontamento por Colaborador</h5>";
    strModal+="                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
    strModal+="                    <span aria-hidden='true'>&times;</span>";
    strModal+="                </button>";
    strModal+="            </div>";
    strModal+="            <form id='form_contato'>";
    strModal+="                <div class='modal-body'>";
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12'>";   
    strModal+="                    <label for='clientes_pk'><b>Selecione o Colaborador</b></label>";   
    strModal+="            <br>";
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-6'>"; 
    strModal+="                    <select class='form-control form-control-sm chzn-select'  id='colaborador_combo_apontamento_pk' name='colaborador_combo_apontamento_pk' onchange='fcListarLeadColaborador(0)'>";   
    strModal+="                        <option></option>";   
    strModal+="                    </select>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <br>";
    strModal+="            <br>";
   
    
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12 text-left'>      ";                              
    strModal+="                    <b>Posto(s) de Trabalho X Escala / Serviço Extra</b>";
    strModal+="                </div>                        ";                                                  
    strModal+="            </div>";
    strModal+="            <br>";
    
    strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="            <div class='row'>"; 
    strModal+="                <div class='col-md-12'>";   
    strModal+="                    <div id='html_lista_lead'></div>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <br>";
    strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-4'>";   
    strModal+="                    <label for='clientes_pk'><b>Data Apontamento</b></label>";   
    strModal+="                    <input type='index' id='dt_apontamento' name='dt_apontamento' class='form-control form-control-sm' onchange='fcHistoricoApontamento();'>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <br>";

    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12 text-left'>";                              
    strModal+="                    <b>Registro Atual</b>";
    strModal+="                </div>";                                                  
    strModal+="            </div>";
        strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12'>";   
    strModal+="                    <div id='html_historico_apontamento'></div>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <br>";
    
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12 text-left'>      ";                              
    strModal+="                    <b>Funcionalidades</b>";
    strModal+="                </div>                        ";                                                  
    strModal+="            </div>";
    strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="            <br>";
    strModal+="            <div class='row'>";
    strModal+="                <div class='col-md-12'>";   
    strModal+="                    <div id='html_funcionalidades'></div>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+="            <br>";
    
    strModal+="                    <div class='row'>   ";             

    strModal+="                        <div class='col-md text-center' >";
    strModal+="                            <button type='button' class='btn btn-secondary' id='cmdCancelarModalPainel'>Fechar</button>";
    strModal+="                        </div>";

    strModal+="                     </div>";  
    strModal+="        </div>";
    strModal+="    </div>";
    strModal+="</div>";
    $("#html_modal_painel").append(strModal);

    $("#janela_modal_painel").modal();
    setTimeout(function(){
        fcCarregarColaboradorIniApontamento();
        
        if(str_colaborador_pk!=""){
            
            grid_agenda = strGridAgenda; 
            
            $("#colaborador_combo_apontamento_pk").val(str_colaborador_pk);
            $("#colaborador_combo_apontamento_pk").val(str_colaborador_pk);
            document.getElementById("colaborador_combo_apontamento_pk").disabled = true;
            
            fcListarLeadColaborador(str_leads_pk);
            
            fcHistoricoApontamento();
            
            $(".chzn-select").chosen({allow_single_deselect: true});
            
        }
        else{
            $(".chzn-select").chosen('destroy');
            
            $(".chzn-select").chosen({allow_single_deselect: true});
        }
        
        
    }, 1000);
    
    //carrega datepicker com a data atual (Agenda)
    $('#dt_apontamento').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker(); 
    $("#dt_apontamento").keypress(function(){
       mascara(this,mdata);
    });
    
    $("#dt_apontamento").val(str_dt_agenda);
    
   
    
}

//LISTA OS POSTOS DE TRABALHO DO COLABORADOR SELECIONADO 
function fcListarLeadColaborador(strLeads){
   fcHistoricoApontamento();
   
   
   $(".chzn-select").chosen('destroy');
            
            
   var strModal="";
   $("#html_lista_lead").append("");
   $("#html_lista_lead").empty();
   
   var objParametros = {
        "colaboradores_pk": $("#colaborador_combo_apontamento_pk").val()
    };         

    var arrCarregar = carregarController("agenda_colaborador_padrao", "listarPostoTrabalhoColaboradorEscala", objParametros);  
    //NewWindow(v_last_url)
    if (arrCarregar.result == 'success'){
        
        
        strModal+="            <div class='row'>";
        strModal+="                <div class='col-md-12 text-left'>      ";                              
        strModal+="                    <b>Posto de Trabalho Colaborador</b>";
        strModal+="                </div>                        ";                                                  
        strModal+="            </div>";
        
        strModal+="<div class='row'>";
        strModal+="    <div class='col-md-12'>";
        strModal+="    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblLeadColaborador'>";
        strModal+="        <thead>";
        strModal+="            <tr>";
        strModal+="                <th>Posto de Trabalho</th>";
        strModal+="                <th>Serviço</th>";
        strModal+="                <th>Escala</th>";
        strModal+="            </tr>";
        strModal+="        </thead>";
        strModal+="        <tbody>";
                
        for(p=0; p < arrCarregar.data.length ;p++){
            
            strModal+="<tr>";
            strModal+="<td >";
            if(strLeads!=""){
                if(strLeads==arrCarregar.data[p]['leads_pk']){
                    strModal+=" <input type='radio' id='leads_pk_radio' checked name='leads_pk_radio' value='"+arrCarregar.data[p]['leads_pk']+"' onchange='fcHistoricoApontamento();'>&nbsp;&nbsp;<b>"+arrCarregar.data[p]['ds_lead'];
                }
                else{
                    strModal+=" <input type='radio' id='leads_pk_radio' name='leads_pk_radio' value='"+arrCarregar.data[p]['leads_pk']+"' onchange='fcHistoricoApontamento();'>&nbsp;&nbsp;<b>"+arrCarregar.data[p]['ds_lead'];
                }
            }
            else{
                strModal+=" <input type='radio' id='leads_pk_radio' name='leads_pk_radio' value='"+arrCarregar.data[p]['leads_pk']+"' onchange='fcHistoricoApontamento();'>&nbsp;&nbsp;<b>"+arrCarregar.data[p]['ds_lead'];
            }
            strModal+="</td>";
            strModal+="<td>";
            strModal+="&nbsp;&nbsp;"+arrCarregar.data[p]['ds_produto_servico'];
            strModal+="</td>";
            strModal+="<td>";
            strModal+="&nbsp;&nbsp;"+arrCarregar.data[p]['n_qtde_dias_semana'];
            strModal+="</td>";
            strModal+="</tr>";
        }
        strModal+="</tbody>";
        strModal+="</table>";
        strModal+="</div>";
        strModal+="</div>";
    }
    
    
    strModal+="<br>";
    strModal+="<br>";
    
    strModal+=" <div class='row'>";
    strModal+="                <div class='col-md-12'>";   
    strModal+="                    <label for='clientes_pk'><b>Posto de Trabalho Serviço Extra</b></label>";   
    strModal+="            <br>";
    strModal+="            <hr style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
    strModal+="            <br>";
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    strModal+=" <div class='row'>";
    strModal+="                <div class='col-md-6'>";
    strModal+="                    <select class='form-control form-control-sm chzn-select'  id='leads_servico_extra_pk' name='leads_servico_extra_pk' onchange='fcDesabilitarLead();'>";   
    strModal+="                        <option></option>";   
    strModal+="                    </select>";   
    strModal+="                </div>";                                                       
    strModal+="            </div>";
    
    
    
    
    
    $("#html_lista_lead").append(strModal);
    fcCarregarLeadsServicoExtra(strLeads);
    $(".chzn-select").chosen({allow_single_deselect: true});
}



function fcDesabilitarLead(){
   
    if($("#leads_servico_extra_pk").val()!=""){
        
        
      
        
        $('#leads_pk_radio').prop('disabled', true);
        $("#leads_pk_radio").prop("checked", false);
        $("input:radio[name=leads_pk_radio]").removeAttr("checked");
        $('input:radio[name=leads_pk_radio]:checked').val("");
        fcHistoricoApontamento();
        $('#exibir_apontamento').hide();
        $('#exibir_apontamento0').hide();
        $('#exibir_apontamento1').hide();
        $('#exibir_apontamento2').hide();
        $('#exibir_apontamento_servico_extra').hide();
        $('#exibir_apontamento_servico_extra0').show();
        $('#exibir_apontamento_servico_extra3').show();
        
        
        
        
    }
    else{
        
        $("#html_historico_apontamento").append("");
        $("#html_historico_apontamento").empty();
        
        $('#leads_pk_radio').prop('disabled', false);

        $('#exibir_apontamento').hide();
        $('#exibir_apontamento0').hide();
        $('#exibir_apontamento1').hide();
        $('#exibir_apontamento2').hide();
        $('#exibir_apontamento_servico_extra').hide();
        $('#exibir_apontamento_servico_extra0').hide();
        $('#exibir_apontamento_servico_extra3').hide();
    }
}

function fcCarregarLeadsServicoExtra(strLeads){
    var objParametros = {
        "leads_pk": strLeads
    };  
    
    var arrCarregar = carregarController("apontamento_servico_extra", "listarLeadComServicoExtra", objParametros); 
   
    if(strLeads!=0){
        carregarComboAjax($("#leads_servico_extra_pk"), arrCarregar, "", "pk", "ds_lead");
        if($("#leads_servico_extra_pk").val()!=""){
            $('#exibir_apontamento_servico_extra').show();
            $('#exibir_apontamento_servico_extra0').show();
            $('#exibir_apontamento_servico_extra3').show();
        }
    }
    else{
        carregarComboAjax($("#leads_servico_extra_pk"), arrCarregar, " ", "pk", "ds_lead");
    }
        
    
        
}

//CARREGA O APONTAMENTO DO COLABORADOR X POSTO DE TRABALHO 
function fcHistoricoApontamento(){
    
    
    var leads_pk = "";
    
    
    
    var strModal="";
    $("#html_historico_apontamento").append("");
    $("#html_historico_apontamento").empty();

    if($("#colaborador_combo_apontamento_pk").val()==""){
        $("#html_historico_apontamento").append("");
        $("#html_historico_apontamento").empty();
        return false;
    }
    
    if($('input:radio[name=leads_pk_radio]:checked').val()==undefined){
        leads_pk = $("#leads_servico_extra_pk").val();
        $('#exibir_apontamento_servico_extra').show();
        $('#exibir_apontamento_servico_extra0').hide();
    }
    else if($('input:radio[name=leads_pk_radio]:checked').val()==""){
        leads_pk = $("#leads_servico_extra_pk").val();
        $('#exibir_apontamento_servico_extra').show();
        $('#exibir_apontamento_servico_extra0').hide();
    }
    else {
        leads_pk = $('input:radio[name=leads_pk_radio]:checked').val();
        $('#exibir_apontamento_servico_extra').hide();
        $('#exibir_apontamento_servico_extra0').hide();
    }
    
    
    if(leads_pk==undefined){
        $("#html_historico_apontamento").append("");
        $("#html_historico_apontamento").empty();
        return false;
    }
    if(leads_pk==""){
        $("#html_historico_apontamento").append("");
        $("#html_historico_apontamento").empty();
        return false;
    }
    
    if($("#dt_apontamento").val()==""){
        $("#html_historico_apontamento").append("");
        $("#html_historico_apontamento").empty();
        return false;
    }
    strModal+="<div class='row'>";
    strModal+="    <div class='col-md-12'>";
    strModal+="    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblLeadColaborador'>";
    strModal+="        <thead>";
    strModal+="            <tr>";
    strModal+="                <th>Tipo Apontamento</th>";
    strModal+="                <th>Data Apontamento</th>";
    strModal+="                <th>Observação</th>";
    strModal+="                <th>DT. Cadastro</th>";
    strModal+="                <th>Usuário. Cadastro</th>";
    strModal+="            </tr>";
    strModal+="        </thead>";
    strModal+="        <tbody>";
    var objParametros1 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_agenda": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar1 = carregarController("agenda_colaborador_pausa", "listarAgendaPausa", objParametros1);

    if (arrCarregar1.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";

        
        if(arrCarregar1.data.length > 0){
     
            for(i=0; i < arrCarregar1.data.length ;i++){
                var strObs="";
                var strDiaFolga ="";
                
                //ATRIBUIR FOLGA
                if(arrCarregar1.data[i]['ds_agenda_colaborador_pausa']=="Folga" && arrCarregar1.data[i]['motivo_folga_pk']!=null){
                    
                    if(arrCarregar1.data[i]['ds_motivo_folga']!=null){
                         strDiaFolga = "Folga "+arrCarregar1.data[i]['ds_motivo_folga'];
                    }
                    else{
                         strDiaFolga = "Folga";
                    }

                    if(arrCarregar1.data[i]['ds_obs_folga']!=null){
                        strObs = arrCarregar1.data[i]['ds_obs_folga'];
                    }
                    else{
                        strObs = "";
                    }

                    tipo_apontamento = strDiaFolga;
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = strObs;
                    dt_cadastro = arrCarregar1.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar1.data[i]['ds_usuario'];

                }
                //INCLUIR ESCALA
                if(arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Folga" && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Substituição Agenda" && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Férias"){
                    
                    

                    tipo_apontamento = "Incluir Escala";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = strObs;
                    dt_cadastro = arrCarregar1.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar1.data[i]['ds_usuario'];

                }
                

                //TROCA COLABORADOR
                if( arrCarregar1.data[i]['motivos_pausas_pk']!=null && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']=="Substituição Agenda"){
               
                    tipo_apontamento = "Troca Colaborador";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = "";
                    dt_cadastro = arrCarregar1.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar1.data[i]['ds_usuario'];

                }

                //EXCLUSAO
                if(arrCarregar1.data[i]['motivo_exclusao_pk']!=null && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']=="Exclusão" ){
               
                    if(arrCarregar1.data[i]['ds_obs_exclusao']!=null){
                        strObs = arrCarregar1.data[i]['ds_obs_exclusao'];
                    }
                    else{
                        strObs = "";
                    }

                    tipo_apontamento = "Exclusão";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = strObs;
                    dt_cadastro = arrCarregar1.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar1.data[i]['ds_usuario'];

                }
                //FÉRIAS
                if(arrCarregar1.data[i]['motivo_exclusao_pk']==null  && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']=="Férias"){
                    
                    tipo_apontamento = "Férias";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = "";
                    dt_cadastro = arrCarregar1.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar1.data[i]['ds_usuario'];
                }
               
                
                
                
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
               
            }
        }
    }
    var objParametros2 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_agenda": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar2 = carregarController("agenda_colaborador_pausa", "listarFalta", objParametros2);

    if (arrCarregar2.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";


        if(arrCarregar2.data.length > 0){
  
            for(i=0; i < arrCarregar2.data.length ;i++){
                var strObs="";
                //FALTA

                //if(arrCarregar2.data[i]['dt_escala']==$("#dt_apontamento").val()){
                    if(arrCarregar2.data[i]['obs_falta']!=null){
                        strObs = arrCarregar2.data[i]['obs_falta'];
                    }
                    else{
                        strObs = "";
                    }

                    tipo_apontamento = "Falta";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = strObs;
                    dt_cadastro = arrCarregar2.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar2.data[i]['ds_usuario'];

                //}
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
            }
        }
    }
    var objParametros3 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_agenda": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar3 = carregarController("agenda_colaborador_pausa", "listarHoraExtra", objParametros3);
    
    if (arrCarregar3.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";


        if(arrCarregar3.data.length > 0){

            for(i=0; i < arrCarregar3.data.length ;i++){
                
                var strObs="";
                
                if(arrCarregar3.data[i]['hr_extra_ini']!=""){


                    if(arrCarregar3.data[i]['obs']!=null){
                        strObs = arrCarregar3.data[i]['obs'];
                    }
                    else{
                        strObs = "";
                    }

                    tipo_apontamento = "Hora Extra";
                    data_apontamento = $("#dt_apontamento").val();
                    observacao = strObs;
                    dt_cadastro = arrCarregar3.data[i]['dt_cadastro'];
                    usuario_cadastro = arrCarregar3.data[i]['ds_usuario'];
                }
                
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
            }
        }
    }
    var objParametros4 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_agenda": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar4 = carregarController("agenda_colaborador_pausa", "listarPonto", objParametros4);
    
    if (arrCarregar4.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";


        if(arrCarregar4.data.length > 0){
           
            for(i=0; i < arrCarregar4.data.length ;i++){
                tipo_apontamento = "Ponto " + arrCarregar4.data[i]['ds_tipo_ponto'];
                data_apontamento = $("#dt_apontamento").val();
                observacao = "";
                dt_cadastro = arrCarregar4.data[i]['dt_cadastro'];
                usuario_cadastro = arrCarregar4.data[i]['ds_usuario'];
                
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
            }
        }
    }
    var objParametros5 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_base": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar5 = carregarController("afastamento_ferias_colaborador", "listarApontamento", objParametros5);

    if (arrCarregar5.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";


        if(arrCarregar5.data.length > 0){

            //for(i=0; i < arrCarregar4.data.length ;i++){
                tipo_apontamento = arrCarregar5.data[0]['ds_tipo_apontamento'];
                data_apontamento = $("#dt_apontamento").val();
                observacao = "";
                dt_cadastro = arrCarregar5.data[0]['dt_cadastro'];
                usuario_cadastro = arrCarregar5.data[0]['ds_usuario'];
                
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
            //}
        }
    }
    var objParametros6 = {
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_base": $("#dt_apontamento").val(),
        "leads_pk": leads_pk
    };         

    var arrCarregar6 = carregarController("apontamento_servico_extra", "listarServicoExtra", objParametros6);
     
    if (arrCarregar6.result == 'success'){
        var tipo_apontamento = "";
        var data_apontamento = "";
        var observacao = "";
        var dt_cadastro = "";
        var usuario_cadastro = "";


        if(arrCarregar6.data.length > 0){
            //for(i=0; i < arrCarregar4.data.length ;i++){
                tipo_apontamento = "Serviço Extra";
                data_apontamento = $("#dt_apontamento").val();
                observacao = "";
                dt_cadastro = arrCarregar6.data[0]['dt_cadastro'];
                usuario_cadastro = arrCarregar6.data[0]['ds_usuario'];
                
                if(tipo_apontamento!=""){
                    strModal+="<tr>";
                    strModal+="<td >";
                    strModal+=tipo_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=data_apontamento;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=observacao;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=dt_cadastro;
                    strModal+="</td>";
                    strModal+="<td>";
                    strModal+=usuario_cadastro;
                    strModal+="</td>";
                    strModal+="</tr>";
                }
            //}
        }
    }
    
    
    
    strModal+="</tbody>";
    strModal+="</table>";
    strModal+="</div>";
    strModal+="</div>";
    
    
    
    $("#html_historico_apontamento").append(strModal);
    fcListarInformacoesAgenda(leads_pk);
    
    
    
    
}

//PEGA AS INFORMAÇÕES NECESSARIAS PARA O CADASTRO DE TODOS OS APONTAMENTOS
function fcListarInformacoesAgenda(leads_pk){
    var strModal="";
    $("#html_funcionalidades").append("");
    $("#html_funcionalidades").empty();
     var dt_ini_agenda = $("#dt_apontamento").val();

    // Precisamos quebrar a string para retornar cada parte
    var dataSplit = dt_ini_agenda.split('/');

    var day = dataSplit[0]; // 15
    var month = dataSplit[1]; // 04
    var year = dataSplit[2]; // 2019
    
    var primeiroDia = new Date("0"+year, (month-1), 1);
    var ultimoDia = new Date(year, month, 0);
    
    var ddi = primeiroDia.getDate();        
    var mmi = primeiroDia.getMonth()+1; //January is 0!   
    var yyyyi = primeiroDia.getFullYear();
    
    
    var ddf = ultimoDia.getDate();        
    var mmf = ultimoDia.getMonth()+1; //January is 0!   
    var yyyyf = ultimoDia.getFullYear();
    var dia_a = "";
   
    if(ddi<10){
        dia_a = "0"+ddi;
    }
    else{
        dia_a = ddi;
    }
    var mes_a = "";
    if(mmi<10){
        mes_a = "0"+mmi;
    }
    else{
        mes_a = mmi;
    }
    
    
    var nova_v_dt_agenda = dia_a+"/"+mes_a+"/"+yyyyi;
    var nova_v_dt_agenda_fim = ddf+"/"+mmf+"/"+yyyyf;
    
    var ArrData = $("#dt_apontamento").val().split("/");
    //exemplo de como as datas são montadas: Mon Jul 16 2018 00:00:00 GMT-0300 (Hora oficial do Brasil);
    //0 dia; 1 mes; 2 ano

    var dt_semana = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
   
        $("#leads_pk_apontamento").val("") ;
        $("#turnos_pk_apontamento").val("");
        $("#colaborador_pk_apontamento").val("");
        $("#dt_agenda_apontamento").val("");
        $("#ds_re_apontamento").val("");
        $("#ds_colaborador_apontamento").val("");
        $("#ds_produto_servico_apontamento").val("");
        $("#ds_turno_apontamento").val("");
        $("#hr_turno_apontamento").val("");
        $("#hr_turno_saida_apontamento").val("");
        $("#dia_semana_apontamento").val("");
        $("#produtos_servicos_pk_apontamento").val("");
        $("#contratos_itens_pk_apontamento").val("");
        $("#agenda_pk_apontamento").val("");
        $("#processos_etapas_pk_apontamento").val("");
        $("#ds_registro_inicial").html("");
    
    var objParametros1 = {
        "leads_pk": leads_pk,
        "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
        "dt_agenda": nova_v_dt_agenda,
        "dt_agenda_fim": nova_v_dt_agenda_fim
        //"dia_semana": i
    };         

   var arrCarregar = carregarController("agenda_colaborador_padrao", "listarAgendaLeadDataGrid", objParametros1);  
  
   
   
    strModal+="<div class='row'>";
    strModal+="<div class='col-md-12'>";
    strModal+="<div class='modal-content' style='box-shadow: 2px 2px 5px grey;'>";
    strModal+="    <div class='modal-body'>  ";
    
    $("#leads_pk_apontamento").val(leads_pk) ;
    
    $("#colaborador_pk_apontamento").val($("#colaborador_combo_apontamento_pk").val());
    $("#dt_agenda_apontamento").val($("#dt_apontamento").val());
    $("#ds_colaborador_apontamento").val($("#colaborador_combo_apontamento_pk option:selected").val());
    $("#ds_re_apontamento").val("");
    $("#ds_produto_servico_apontamento").val(ds_produto_servico);
    $("#hr_turno_apontamento").val(hr_turno);
    $("#hr_turno_saida_apontamento").val(hr_turno_saida);
    $("#dia_semana_apontamento").val(dt_semana.getDay());
    
    
    
    if (arrCarregar.result == 'success'){
        
        
        for(j=0; j < arrCarregar.data.length ;j++){
            
            //DOMINGO

            if(dt_semana.getDay()==0){
                if(arrCarregar.data[j]['t_ic_dom']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_dom']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_dom'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_dom_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_dom_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_dom']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_dom'];
                }
            }
            else if(dt_semana.getDay()==1){
                if(arrCarregar.data[j]['t_ic_seg']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_seg']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_seg'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_seg_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_seg_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_seg']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_seg'];
                }
            }
            else if(dt_semana.getDay()==2){
                if(arrCarregar.data[j]['t_ic_ter']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_ter']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_ter'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_ter_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_ter_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_ter']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_ter'];
                }
            }
            else if(dt_semana.getDay()==3){
                if(arrCarregar.data[j]['t_ic_qua']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_qua']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_qua'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_qua_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qua_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_qua']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_qua'];
                }
            }
            else if(dt_semana.getDay()==4){
                if(arrCarregar.data[j]['t_ic_qui']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_qui']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_qui'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_qui_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_qui_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_qui']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_qui'];
                }
            }
            else if(dt_semana.getDay()==5){
                if(arrCarregar.data[j]['t_ic_sex']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_sex']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_sex'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_sex_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sex_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_sex']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_sex'];
                }
            }
            else if(dt_semana.getDay()==6){
                if(arrCarregar.data[j]['t_ic_sab']==1){
                    $("#ds_registro_inicial").val("Trabalhando");
                }
                else{
                    $("#ds_registro_inicial").val("Folga");
                }
                var hr_turno = "";
                if(arrCarregar.data[j]['t_hr_turno_sab']!=null){
                    hr_turno = arrCarregar.data[j]['t_hr_turno_sab'];
                }
                var hr_turno_saida = "";
                if(arrCarregar.data[j]['t_hr_turno_sab_saida']!=null){
                    hr_turno_saida = arrCarregar.data[j]['t_hr_turno_sab_saida'];
                }
                var ds_produto_servico = "";
                if(arrCarregar.data[j]['t_ds_produto_servico_sab']!=null){
                    ds_produto_servico = arrCarregar.data[j]['t_ds_produto_servico_sab'];
                }
            }
            
            $("#turnos_pk_apontamento").val(arrCarregar.data[j]['t_turnos_pk']);
            $("#ds_turno_apontamento").val(arrCarregar.data[j]['t_ds_turnos']);
            $("#produtos_servicos_pk_apontamento").val(arrCarregar.data[j]['t_produto_servico_pk']);
            $("#contratos_itens_pk_apontamento").val(arrCarregar.data[j]['t_contratos_itens_pk']);
            $("#agenda_pk_apontamento").val(arrCarregar.data[j]['t_pk']);
            $("#processos_etapas_pk_apontamento").val(arrCarregar.data[j]['t_processos_etapas_pk']);
            
        }
        
        
        var objParametros1 = {
            "colaborador_pk": $("#colaborador_combo_apontamento_pk").val(),
            "dt_agenda": $("#dt_apontamento").val(),
            "leads_pk": leads_pk
        };         

        var arrCarregar1 = carregarController("agenda_colaborador_pausa", "listarAgendaPausa", objParametros1);

        if (arrCarregar1.result == 'success'){
            if(arrCarregar1.data.length > 0){

                for(i=0; i < arrCarregar1.data.length ;i++){
                    //ATRIBUIR FOLGA
                    if(arrCarregar1.data[i]['ds_agenda_colaborador_pausa']=="Folga" && arrCarregar1.data[i]['motivo_folga_pk']!=null){
                        $("#ds_registro_inicial").val("Folga");
                        
                        

                    }
                    //INCLUIR ESCALA
                    if(arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Folga" && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Substituição Agenda" && arrCarregar1.data[i]['ds_agenda_colaborador_pausa']!="Férias"){
                        $("#ds_registro_inicial").val("Trabalhando");

                    }

                }
            }
        }
        
        
        
        
        
        //if($("#ds_registro_inicial").val()!="Folga"){
            strModal+="                    <div class='row' id='exibir_apontamento'>   ";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <b>Ponto/Falta/Folga</b>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <b>Nova Escala/Troca/Excluir</b>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <b>Afastamento/Hora Extra/Férias</b>";
            strModal+="                        </div>";
            strModal+="                    </div>";

            strModal+="                    <div class='row' id='exibir_apontamento0'>   ";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='abrirModalPonto' href='javascript:abrirModalPonto("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_saida_apontamento").val()+'"'+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+'"'+$("#ds_turno_apontamento").val()+'"'+")'><img border='0' src='../img/registro_ponto.png' width='45' height='50'><br><font size='4px'>Registrar Ponto</font></a><br>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center'>";
            strModal+="                            <a id='abrirModalIncluirEscala' href='javascript:abrirModalIncluirEscala("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+$("#agenda_pk_apontamento").val()+","+$("#processos_etapas_pk_apontamento").val()+","+$("#contratos_itens_pk_apontamento").val()+")'><img border='0' src='../img/calendario.png' width='38' height='38'><br><font size='4px'>Registrar nova Escala</font></a><br>";
            strModal+="                        </div>"; 
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='fcAbrirModalAfastamento' href='javascript:fcAbrirModalAfastamento("+$("#leads_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+")'><img border='0' src='../img/relatorio.png' width='45' height='50'><br><font size='4px'>Registrar Afastamento</font></a><br>";
            strModal+="                        </div>";


            strModal+="                    </div>";
            strModal+="                    <div class='row'  id='exibir_apontamento1'>   "; 
             strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='abrirModalFalta' href='javascript:abrirModalFalta("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_saida_apontamento").val()+'"'+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+'"'+$("#ds_turno_apontamento").val()+'"'+")'><img border='0' src='../img/falta.png' width='45' height='50'><br><font size='4px'>Registrar Falta</font></a><br>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center'>";
            strModal+="                            <a id='abrirModal' href='javascript:abrirModal("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+ $("#produtos_servicos_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+$("#contratos_itens_pk_apontamento").val()+",1,"+'"'+$("#ds_re_apontamento").val()+'"'+")'><img border='0' src='../img/change_01.png' width='45' height='50'><br><font size='4px'>Registrar Troca de Escala</font></a><br>";
            strModal+="                        </div>";

            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='fcAbrirModalHoraExtra' href='javascript:fcAbrirModalHoraExtra("+$("#leads_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+")'><img border='0' src='../img/horaextra.png' width='45' height='50'><br><font size='4px'>Registrar Hora Extra</font></a><br>";
            strModal+="                        </div>";

            //strModal+="                        <div class='col-md text-center' >";
            //strModal+="                            <a href='javascript:fcAbrirModalTarefa("+$("#leads_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+$("#agenda_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+")'><img border='0' src='../img/relatorio.png' width='45' height='50'><br><font size='4px'>Registrar Tarefas</font></a><br>";
            //strModal+="                        </div>";


            strModal+="                    </div>"; 
            strModal+="                    <div class='row'  id='exibir_apontamento2'>   ";  
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='abrirModalFolga' href='javascript:abrirModalFolga("+$("#leads_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+")'><img border='0' src='../img/folga.png' width='45' height='50'><br><font size='4px'>Registrar Folga</font></a><br>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='abrirModalExclusao' href='javascript:abrirModalExclusao("+$("#leads_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+")'><img border='0' src='../img/excluir.png' width='45' height='50'><br><font size='4px'>Excluir Escala</font></a><br>";
            strModal+="                        </div>";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <a id='abrirModalFerias' href='javascript:abrirModalFerias("+$("#leads_pk_apontamento").val()+","+$("#turnos_pk_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#ds_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+")'><img border='0' src='../img/ferias1.png' width='45' height='50'><br><font size='4px'>Registrar Férias</font></a><br>";
            strModal+="                         </div>";
            strModal+="                    </div>";
        /*}else{
            strModal+="                    <div class='row' id='exibir_apontamento'>   ";
            strModal+="                        <div class='col-md text-center' >";
            strModal+="                            <b>Nova Escala</b>";
            strModal+="                        </div>";
            strModal+="                    </div>";

            strModal+="                    <div class='row' id='exibir_apontamento0'>   ";
            strModal+="                        <div class='col-md text-center'>";
            strModal+="                            <a id='abrirModalIncluirEscala' href='javascript:abrirModalIncluirEscala("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+$("#colaborador_pk_apontamento").val()+","+$("#agenda_pk_apontamento").val()+","+$("#processos_etapas_pk_apontamento").val()+","+$("#contratos_itens_pk_apontamento").val()+")'><img border='0' src='../img/calendario.png' width='38' height='38'><br><font size='4px'>Registrar nova Escala</font></a><br>";
            strModal+="                        </div>"; 
            strModal+="                    </div>";
        }*/
        

        

        
        
        
        
    }
    
        strModal+="            <hr id='exibir_apontamento_servico_extra3' style='height:1px; border:none; color:#14074F; background-color:#14074F; margin-top: 0px; margin-bottom: 0px;'>    ";
        strModal+="                    <div class='row' id='exibir_apontamento_servico_extra0' style='display:none'>   ";
        
        strModal+="                        <div class='col-md text-center' >";
        strModal+="                            <b>Serviço Extra</b>";
        strModal+="                        </div>";
        strModal+="                        <div class='col-md text-center' >";
        strModal+="                            &nbsp;";
        strModal+="                        </div>";
        strModal+="                        <div class='col-md text-center' >";
        strModal+="                            &nbsp;";
        strModal+="                        </div>";
        strModal+="                     </div>";
        strModal+="                    <div class='row' id='exibir_apontamento_servico_extra' style='display:none'>   ";
        strModal+="                        <div class='col-md text-center' >";
        strModal+="                            <a  href='javascript:abrirModalServicoExtra("+$("#leads_pk_apontamento").val()+","+'"'+$("#ds_re_apontamento").val()+'"'+","+'"'+$("#ds_colaborador_apontamento").val()+'"'+","+'"'+$("#ds_produto_servico_apontamento").val()+'"'+","+'"'+$("#hr_turno_apontamento").val()+'"'+","+'"'+$("#hr_turno_saida_apontamento").val()+'"'+","+$("#colaborador_pk_apontamento").val()+","+'"'+$("#dt_agenda_apontamento").val()+'"'+","+$("#dia_semana_apontamento").val()+","+'"'+$("#ds_turno_apontamento").val()+'"'+")'><img border='0' src='../img/iconeServicoExtra.png' width='45' height='50'><br><font size='4px'>Apontar quem Executou</font></a><br>";
        strModal+="                        </div>";
        strModal+="                        <div class='col-md text-center'>";
        strModal+="                            &nbsp;";
        strModal+="                        </div>"; 
        strModal+="                        <div class='col-md text-center' >";
        strModal+="                            &nbsp;";
        strModal+="                        </div>";
        strModal+="                     </div>";
        strModal+="             </div>";
        strModal+="          </div>";
        strModal+="       </div>";
        strModal+="    </div>";
        
        $("#html_funcionalidades").append(strModal);
        
        
        
        
        if($("#leads_servico_extra_pk").val()!=""){
            if($('input:radio[name=leads_pk_radio]:checked').val()==undefined){
                setTimeout(function(){
                    $('#exibir_apontamento').hide();
                    $('#exibir_apontamento0').hide();
                    $('#exibir_apontamento1').hide();
                    $('#exibir_apontamento2').hide();
                    $('#exibir_apontamento_servico_extra').hide();
                    $('#exibir_apontamento_servico_extra0').show();
                    $('#exibir_apontamento_servico_extra').show();
                    $('#exibir_apontamento_servico_extra0').show();
                    $('#exibir_apontamento_servico_extra3').hide();
                }, 500);
            }
            else{
                setTimeout(function(){
                    $('#exibir_apontamento').show();
                    $('#exibir_apontamento0').show();
                    $('#exibir_apontamento1').show();
                    $('#exibir_apontamento2').show();
                    $('#exibir_apontamento_servico_extra').show();
                    $('#exibir_apontamento_servico_extra0').show();
                    $('#exibir_apontamento_servico_extra').show();
                    $('#exibir_apontamento_servico_extra0').show();
                    $('#exibir_apontamento_servico_extra3').show();
                }, 500);
            }
            
            
        }
        else{
            setTimeout(function(){
                $('#exibir_apontamento').show();
                $('#exibir_apontamento0').show();
                $('#exibir_apontamento1').show();
                $('#exibir_apontamento2').show();
                $('#exibir_apontamento_servico_extra').show();
                $('#exibir_apontamento_servico_extra0').hide();
                $('#exibir_apontamento_servico_extra').hide();
                $('#exibir_apontamento_servico_extra0').hide();
                $('#exibir_apontamento_servico_extra3').hide();
            }, 500);
        }
}


function fcFecharModalPainel(){
    $("#janela_modal_painel").modal("hide");
}
function fcLimparVariavelExclusao(){
    $("#turnos_exclusao_pk").val("");
    $("#colaborador_exclusao_pk").val("");
    $("#dt_base_exclusao").val("");
    $("#ds_obs_exclusao").val("");
    $("#motivo_exclusao_pk").val("");
    $("#ds_obs_exclusao").val("");
    $("#dia_semana_exclusao").val("");
    $("#leads_pk_exclusao").val("");
}
function fcLimparVariavelFolga(){
    $("#turnos_folga_pk").val("");
    $("#colaborador_folga_pk").val("");
    $("#dt_base_folga").val("");
    $("#ds_obs_folga").val("");
    $("#motivo_folga_pk").val("");
    $("#ds_obs_folga").val("");
    $("#dia_semana_folga").val("");
    $("#leads_pk_folga").val("");
    $("#colaborador_cobertura_pk").val("");
}
function abrirModalExclusao(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){
    fcLimparVariavelExclusao();
    $("#dt_agenda_excluir").html("<b>Data Selecionada :</b>"+dt_agenda);
    $("#ds_re_excluir").html("<b>R.E:</b>"+ds_re);
    $("#ds_colaborador_excluir").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_excluir").html("<b>Função:</b> "+ds_funcao);
    $("#hr_excluir").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    $("#turnos_exclusao_pk").val(turnos_pk);
    $("#colaborador_exclusao_pk").val(colaborador_pk);
    $("#dt_base_exclusao").val(dt_agenda);
    $("#dia_semana_exclusao").val(dia_semana);
    $("#leads_pk_exclusao").val(leads_pk);
    $("#modal_exclusao").modal();
}
function abrirModalFolga(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){
    fcLimparVariavelFolga();
    $("#dt_agenda_folga").html("<b>Data Selecionada: </b> "+dt_agenda);
    $("#ds_re_folga").html("<b>R.E: </b> "+ds_re);
    $("#ds_colaborador_folga").html("<b>Colaborador: </b> "+ds_colaborador);
    $("#ds_funcao_folga").html("<b>Função: </b> "+ds_funcao);
    $("#hr_folga").html("<b>Turno: </b> " +ds_turno +" "+ hr_entrada);
    $("#turnos_folga_pk").val(turnos_pk);
    $("#colaborador_folga_pk").val(colaborador_pk);
    $("#dt_base_folga").val(dt_agenda);
    $("#dia_semana_folga").val(dia_semana);
    $("#leads_pk_folga").val(leads_pk);
    
    
    
    $('#motivo_folga_pk').change(function() {
        if($("#motivo_folga_pk").val()==5){
            $("#exibir_colaborador_cobertura").show();
            setTimeout(function(){
                fcCarregarColaboradorCobertura(ds_funcao);
                $(".chzn-select").chosen('destroy');

                $(".chzn-select").chosen({allow_single_deselect: true});
            }, 1000);
        }
        else{
            $("#exibir_colaborador_cobertura").hide();
        }
    });
    
     
    
    $("#modal_folga").modal();
}

function fcCarregarColaboradorCobertura(ds_funcao){
    var objParametros = {
        "pk": "",
        "ds_funcao": ds_funcao
    };  
    
    var arrCarregar = carregarController("colaborador", "listarColaboradorPorDsFuncao", objParametros); 
   
    carregarComboAjax($("#colaborador_cobertura_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}

function fcDeletarPonto(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_hora_ponto": dt_base,
        "colaborador_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("ponto", "excluirColaborador", objParametros);
   
}
function fcDeletarHoraExtra(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_hora_ponto": dt_base,
        "colaborador_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("colaborador_hora_extra", "excluirColaborador", objParametros);
    
}
function fcDeletarFalta(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_escala": dt_base,
        "colaborador_pk": colaborador_pk,
        //"leads_pk": $("#leads_pk_falta").val()

    }; 

    var arrEnviar = carregarController("colaborador_falta", "excluirColaborador", objParametros);
    

}
function fcDeletarCobertura(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk,
        //"leads_pk": $("#leads_pk_falta").val()

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "excluirCobertura", objParametros);
   

}
function fcDeletarTrocaColaborador(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "excluirColaboradorTroca", objParametros);

}
function fcDeletarExclusao(dt_base,colaborador_pk){

    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "excluirColaboradorExclusao", objParametros);
    
}
function fcDeletarFerias(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "excluirColaboradorFerias", objParametros);

}
function fcDeletarFolga(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "excluirColaboradorFolga", objParametros);
  
}
function fcDeletarExclusaoNovaEscala(dt_base,colaborador_pk){
    var objParametros = {
        "pk": "",
        "dt_inicio_pausa": dt_base,
        "dt_fim_pausa": dt_base,
        "colaboradores_pk": colaborador_pk

    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "carregarExclusaoNovaEscala", objParametros);
    
}

function fcAbrirModalHoraExtra(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){

    
    $("#ic_dia_hora_extra").val("");
    $("#obs_hora_extra").val("");
    $("#hr_inicio_hora_extra").val("");
    $("#hr_fim_hora_extra").val("");
    
    $("#dt_execucao_hora_extra").val(dt_agenda);
    $("#ic_dia_hora_extra").val(dia_semana);
    //$("#agendas_pk_hora_extra").val(agendas_pk);
    $("#leads_pk_hora_extra").val(leads_pk);
    $("#colaborador_pk_hora_extra").val(colaborador_pk);
    
    $("#dt_agenda_hora_extra").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_hora_extra").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_hora_extra").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_hora_extra").html("<b>Função:</b> "+ds_funcao);
    $("#hr_hora_extra").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    
    
    
    
    $("#modal_hora_extra").modal();
    
}

function fcSalvarHoraExtra(){
    if($("#hr_inicio_hora_extra").val()==""){
        $("#alert_hr_extra").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_hr_extra").slideUp(500);
        });
        return false;
    }
    
    if($("#hr_fim_hora_extra").val()==""){
        $("#alert_hr_extra").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_hr_extra").slideUp(500);
        });
        return false;
    }
    var ArrData = $("#dt_execucao_hora_extra").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": "",
        "colaborador_pk": $("#colaborador_pk_hora_extra").val(),
        "leads_pk": $("#leads_pk_hora_extra").val(),
        "dt_escala": $("#dt_execucao_hora_extra").val(),
        "hr_extra_ini": $("#hr_inicio_hora_extra").val(),
        "hr_extra_fim": $("#hr_fim_hora_extra").val(),
        "obs": $("#obs_hora_extra").val()
        
    }; 

    var arrEnviar = carregarController("colaborador_hora_extra", "salvar", objParametros);
   
    if (arrEnviar.result == 'success'){
        fcDeletarFalta($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        
        fcDeletarFerias($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarExclusao($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarPonto($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarFolga($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarTrocaColaborador($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarFalta($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarCobertura($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        fcDeletarExclusaoNovaEscala($("#dt_execucao_hora_extra").val(),$("#colaborador_pk_hora_extra").val());
        
        
        
        if(grid_agenda=1){
                
            fcColorirGrid($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#colaborador_pk_hora_extra").val(),"10eec2");
            fcPreencherLabel($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#colaborador_pk_hora_extra").val(),"Hora Extra");
            fcColorirLabel($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#colaborador_pk_hora_extra").val(),"0000ff");

        }
        else if(grid_agenda=2){
                
            fcColorirGrid($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#leads_pk_hora_extra").val(),"10eec2");
            fcPreencherLabel($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#leads_pk_hora_extra").val(),"Hora Extra");
            fcColorirLabel($("#ic_dia_hora_extra").val(),(data.getDate()-1),$("#leads_pk_hora_extra").val(),"0000ff");

        }
        
        
        
        
        
        alert(arrEnviar.message);
        $("#modal_hora_extra").modal("hide");
        fcHistoricoApontamento();
        
    }    
    else{
        alert(arrEnviar.result);
    }
    
   
    
}
function fcAbrirModalAfastamento(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){

    
    $("#motivo_afastamento_pk").val("");
    $("#ic_dia_semana_afastamento").val("");
    $("#obs_afastamento").val("");
    $("#dt_inicio_afastamento").val("");
    $("#dt_fim_afastamento").val("");
    
    $("#dt_inicio_afastamento").val(dt_agenda);
    
    //$("#agendas_pk_afastamento").val(agendas_pk);
    $("#leads_pk_afastamento").val(leads_pk);
    $("#colaborador_pk_afastamento").val(colaborador_pk);
    $("#ic_dia_semana_afastamento").val(dia_semana);
    
    $("#dt_agenda_afastamento").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_afastamento").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_afastamento").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_afastamento").html("<b>Função:</b> "+ds_funcao);
    $("#hr_afastamento").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    
    
    
    
    $("#modal_afastamento").modal();
    
}

function fcSalvarAfastamento(){
    if($("#motivo_afastamento_pk").val()==""){
        $("#alert_motivo_afastamento").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_motivo_afastamento").slideUp(500);
        });
        return false;
    }
    if($("#dt_inicio_afastamento").val()==""){
        $("#alert_afastamento_dia").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_afastamento_dia").slideUp(500);
        });
        return false;
    }
    
    if($("#dt_fim_afastamento").val()==""){
        $("#alert_afastamento_dia").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_afastamento_dia").slideUp(500);
        });
        return false;
    }
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": "",
        "colaborador_pk": $("#colaborador_pk_afastamento").val(),
        "leads_pk": $("#leads_pk_afastamento").val(),
        "dt_inicio": $("#dt_inicio_afastamento").val(),
        "dt_fim": $("#dt_fim_afastamento").val(),
        "tipo_apontamento": $("#motivo_afastamento_pk").val(),
        "ds_obs": $("#obs_afastamento").val()
        
    }; 

    var arrEnviar = carregarController("afastamento_ferias_colaborador", "salvar", objParametros);
  
    if (arrEnviar.result == 'success'){
        
        
        
        
        
        fcDeletarFalta($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        
        fcDeletarFerias($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarExclusao($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarPonto($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarFolga($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarTrocaColaborador($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarFalta($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarCobertura($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarExclusaoNovaEscala($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        fcDeletarHoraExtra($("#dt_inicio_afastamento").val(),$("#colaborador_pk_afastamento").val());
        
        alert(arrEnviar.message);
        
        
        
        if(grid_agenda!=""){
            var objParametros1 = {
                "dt_inicio": $("#dt_inicio_afastamento").val(),
                "dt_fim": $("#dt_fim_afastamento").val()
            };      

            var arrCarregar1 = carregarController("agenda_colaborador_pausa", "datediff", objParametros1); 
         
            var date_dif = arrCarregar1.data[0]['diferenca'];
            var dt_agenda = $("#dt_inicio_afastamento").val();
            var dt_for_agenda = dt_agenda;

            // Precisamos quebrar a string para retornar cada parte
            var dataSplitFor = dt_for_agenda.split('/');

            var dayFor = dataSplitFor[0]; // 15
            var monthFor = dataSplitFor[1]; // 04
            var yearFor = dataSplitFor[2]; // 2019

           // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
            var data_for_agenda = new Date(yearFor, monthFor - 1, dayFor); 	
            var ultimoDia = new Date(data_for_agenda.getFullYear(), data_for_agenda.getMonth() + 1, 0);

      
            for(i=0;i<=(date_dif);i++){




                var dataComp = dt_agenda.split('/');

                var dayComp = dataComp[0]; // 15
                var monthComp = dataComp[1]; // 04
                var yearComp = dataComp[2]; // 2019

               // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
                var data_comp_agenda = new Date(yearComp, monthComp - 1, dayComp); 


                var dia_semana = data_comp_agenda.getDay();


        

                if(data_comp_agenda<=ultimoDia){
                    if(grid_agenda=1){

                        fcColorirGrid(dia_semana,(dayComp-1),$("#colaborador_pk_afastamento").val(),"CFFFBF");
                        fcPreencherLabel(dia_semana,(dayComp-1),$("#colaborador_pk_afastamento").val(),"Afastamento");
                        fcColorirLabel(dia_semana,(dayComp-1),$("#colaborador_pk_afastamento").val(),"0000ff");

                    }
                    else if(grid_agenda=2){

                        fcColorirGrid(dia_semana,(dayComp-1),$("#leads_pk_afastamento").val(),"CFFFBF");
                        fcPreencherLabel(dia_semana,(dayComp-1),$("#leads_pk_afastamento").val(),"Afastamento");
                        fcColorirLabel(dia_semana,(dayComp-1),$("#leads_pk_afastamento").val(),"0000ff");

                    }
                }





                var p_nova_dt_agenda = dt_agenda.split("/");


                //pega a data que ja passou pelo for 
                var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                //a cada looping acrescenta mais um dia 
                nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

                var dt_agenda = 0;
                var dia = 0;
                var mes = 0;
                var ano = 0;
                if(nova_dt_agenda_dia_proximo.getDate()<10){
                    dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }
                else{
                    dia = nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }

                if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                    mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }
                else{
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }                
                dt_agenda = dia+"/"+mes+"/"+ano;
            }
        }
        
        
        
        
        
        
        
        
        $("#modal_afastamento").modal("hide");
        fcHistoricoApontamento();
        
    }    
    else{
        alert(arrEnviar.result);
    }
    
   
    
}
function fcSalvarExclusao(){
     var ArrData = $("#dt_base_exclusao").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    if($("#motivo_exclusao_pk").val()==""){
        $("#alert_motivo_exclusao").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_motivo_exclusao").slideUp(500);
        });
        return false;
    }
    var objParametros = {
            "pk": "",
            "turnos_pk": $("#turnos_exclusao_pk").val(),
            "obs": $("#obs_ponto").val(),
            "colaboradores_pk": $("#colaborador_exclusao_pk").val(),
            "dt_inicio_pausa": $("#dt_base_exclusao").val(),
            "dt_fim_pausa": $("#dt_base_exclusao").val(),
            "motivo_exclusao_pk": $("#motivo_exclusao_pk").val(),
            "ds_obs_exclusao": $("#ds_obs_exclusao").val(),
            "ds_agenda_colaborador_pausa": "Exclusão"

        }; 

        var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
        
        if (arrEnviar.result == 'success'){
            fcDeletarPonto($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarHoraExtra($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarFalta($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarCobertura($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarFerias($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarTrocaColaborador($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            fcDeletarFolga($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            //fcDeletarExclusaoNovaEscala($("#dt_base_exclusao").val(),$("#colaborador_exclusao_pk").val());
            
            if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_exclusao").val(),(data.getDate()-1),$("#colaborador_exclusao_pk").val(),"salmon");

            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_exclusao").val(),(data.getDate()-1),$("#leads_pk_exclusao").val(),"salmon");

            }
            
            
            
            
            alert(arrEnviar.message);
            $("#modal_exclusao").modal("hide");
            fcHistoricoApontamento();

        }    
        else{
            alert(arrEnviar.result);
        }
}
function fcSalvarFolga(){
     var ArrData = $("#dt_base_folga").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    
    
    if($("#motivo_folga_pk").val()==""){
        $("#alert_motivo_folga").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_motivo_folga").slideUp(500);
        });
        return false;
    }
    if($("#motivo_folga_pk").val()==5){
        if($("#colaborador_cobertura_pk").val()==""){
            $("#alert_ds_colaborador_cobertura").fadeTo(2000, 500).slideUp(500, function(){
                $("#alert_ds_colaborador_cobertura").slideUp(500);
            });
            return false;
        }
    }
    var objParametros = {
            "pk": "",
            "turnos_pk": $("#turnos_folga_pk").val(),
            "colaboradores_pk": $("#colaborador_folga_pk").val(),
            "dt_inicio_pausa": $("#dt_base_folga").val(),
            "dt_fim_pausa": $("#dt_base_folga").val(),
            "motivo_folga_pk": $("#motivo_folga_pk").val(),
            "ds_obs_folga": $("#ds_obs_folga").val(),
            "colaborador_substituto_pk": $("#colaborador_cobertura_pk").val(),
            "ds_agenda_colaborador_pausa": "Folga"

        }; 

        var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
       
        if (arrEnviar.result == 'success'){
            fcDeletarPonto($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
            fcDeletarHoraExtra($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
           
            fcDeletarFalta($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
            
            fcDeletarCobertura($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
          
            fcDeletarFerias($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
            
            fcDeletarExclusaoNovaEscala($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
           
            fcDeletarTrocaColaborador($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
           
            fcDeletarExclusao($("#dt_base_folga").val(),$("#colaborador_folga_pk").val());
            
            
            
            if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_folga").val(),(data.getDate()-1),$("#colaborador_folga_pk").val(),"black");
                fcPreencherLabel($("#dia_semana_folga").val(),(data.getDate()-1),$("#colaborador_folga_pk").val(),"Folga "+$("#motivo_folga_pk option:selected").text());
                fcColorirLabel($("#dia_semana_folga").val(),(data.getDate()-1),$("#colaborador_folga_pk").val(),"ec1c24");

            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_folga").val(),(data.getDate()-1),$("#leads_pk_folga").val(),"black");
                fcPreencherLabel($("#dia_semana_folga").val(),(data.getDate()-1),$("#leads_pk_folga").val(),"Folga "+$("#motivo_folga_pk option:selected").text());
                fcColorirLabel($("#dia_semana_folga").val(),(data.getDate()-1),$("#leads_pk_folga").val(),"ec1c24");

            }
           
            
           
           
           
           
            
            alert(arrEnviar.message);
            $("#modal_folga").modal("hide");
            fcHistoricoApontamento();

        }    
        else{
            alert(arrEnviar.result);
        }
}

function fcLimparVariavelPonto(){
    $("#ds_re_ponto").html("");
    $("#ds_colaborador_ponto").html("");
    $("#ds_funcao_ponto").html("");
    $("#hr_ponto").html("");
    $("#colaborador_ponto_pk").val("");
    $("#motivo_falta_pk").val("");
    $("#colaborador_falta_pk").val("");
    
    $("#hr_entrada_manual").val("");
    $("#obs_ponto").val("");
    $("#dia_semana_ponto").val("");
    $("#dt_escala_ponto").val("");
    $("#tipo_registro_ponto_pk").val("");
    $("#leads_pk_ponto").val("");
    $('#ic_hr_sistema').prop('checked', false);
    $('#ic_hr_sistema').prop('disabled', false);
    $('#ic_falta').prop('checked', false);
    $('#ic_falta').prop('disabled', false);
    $('#motivo_falta_pk').prop('disabled', false);
    $('#hr_entrada_manual').prop('disabled', false);
}
function fcLimparVariavelServicoExtra(){
    $("#ds_re_ponto").html("");
    $("#ds_colaborador_ponto").html("");
    $("#ds_funcao_ponto").html("");
    $("#hr_ponto").html("");
    $("#colaborador_ponto_pk").val("");
    $("#motivo_falta_pk").val("");
    $("#colaborador_falta_pk").val("");
    
    $("#hr_entrada_manual").val("");
    $("#obs_ponto").val("");
    $("#dia_semana_ponto").val("");
    $("#dt_escala_ponto").val("");
    $("#tipo_registro_ponto_pk").val("");
    $("#leads_pk_ponto").val("");
    $('#ic_hr_sistema').prop('checked', false);
    $('#ic_hr_sistema').prop('disabled', false);
    $('#ic_falta').prop('checked', false);
    $('#ic_falta').prop('disabled', false);
    $('#motivo_falta_pk').prop('disabled', false);
    $('#hr_entrada_manual').prop('disabled', false);
}

function abrirModalPonto(leads_pk,ds_re,ds_colaborador,ds_funcao,hr_entrada,hr_saida,colaborador_pk,dt_agenda,dia_semana,ds_turno){
    
    fcLimparVariavelPonto();
   
    $("#dt_agenda_ponto").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_ponto").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_ponto").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_ponto").html("<b>Função:</b> "+ds_funcao);
    $("#hr_ponto").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    $("#colaborador_ponto_pk").val(colaborador_pk);
    $("#dt_escala_ponto").val(dt_agenda);
    $("#dia_semana_ponto").val(dia_semana);
    $("#leads_pk_ponto").val(leads_pk);
    $(".chzn-select").chosen('destroy');
    $("#modal_ponto").modal();
    
    setTimeout(function(){
        fcCarregarColaborador();
        $(".chzn-select").chosen('destroy');

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
}
function abrirModalServicoExtra(leads_pk,ds_re,ds_colaborador,ds_funcao,hr_entrada,hr_saida,colaborador_pk,dt_agenda,dia_semana,ds_turno){
    
    fcLimparVariavelServicoExtra();
   
    $("#dt_agenda_servico_extra").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_servico_extra").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_servico_extra").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_servico_extra").html("<b>Função:</b> "+ds_funcao);
    $("#hr_servico_extra").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    $("#colaborador_servico_extra_pk").val(colaborador_pk);
    $("#dt_escala_servico_extra").val(dt_agenda);
    $("#dia_semana_servico_extra").val(dia_semana);
    $("#leads_pk_servico_extra").val(leads_pk);
    $("#modal_servico_extra").modal();
    
    setTimeout(function(){
        fcCarregarGridContratos();
    }, 500);
    
    
    
}

function fcCarregarGridContratos(){
    
            
            
   var strModal="";
   $("#grid_contratos_itens").append("");
   $("#grid_contratos_itens").empty();
   
   var objParametros = {
        "leads_pk": $("#leads_pk_servico_extra").val()
    };         

    var arrCarregar = carregarController("apontamento_servico_extra", "listarContratosItensApontamento", objParametros);  
    
    if (arrCarregar.result == 'success'){
        ;
        
        strModal+="<div class='row'>";
        strModal+="    <div class='col-md-12'>";
        strModal+="    <table class='table table-striped table-bordered nowrap' style='width:100%' id='tblContratosItensApontamento'>";
        strModal+="        <thead>";
        strModal+="            <tr>";
        strModal+="                <th>&nbsp;</th>";
        strModal+="                <th>Prod/Serv</th>";
        strModal+="                <th>Vl.Mão Obra</th>";
        strModal+="                <th>Vl.Mão Obra Pag.</th>";
        strModal+="                <th>Data de Faturamento.</th>";
        strModal+="            </tr>";
        strModal+="        </thead>";
        strModal+="        <tbody>";
                
        for(p=0; p < arrCarregar.data.length ;p++){
            
            strModal+="<tr>";
            strModal+="<td >";
            strModal+=" <input type='checkbox' id='contratos_itens_pk_radio"+p+"' name='contratos_itens_pk_radio"+p+"' value='"+arrCarregar.data[p]['contratos_itens_pk']+"'>";
            strModal+=" <input type='hidden' id='contratos_pk_radio"+p+"' name='contratos_pk_radio"+p+"' value='"+arrCarregar.data[p]['contratos_pk']+"'>";
            
            
            strModal+="</td>";
            strModal+="<td>";
            strModal+="&nbsp;&nbsp;"+arrCarregar.data[p]['ds_produto_servico'];
            strModal+="</td>";
            strModal+="<td>";
            strModal+="&nbsp;&nbsp;"+arrCarregar.data[p]['vl_mao_obra'];
            strModal+="</td>";
            strModal+="<td>";
            strModal+=" <input type='text' class='form-control form-control-sm' onkeypress='mascara(this,moeda)' id='vl_total_mao_obra"+p+"' name='vl_total_mao_obra"+p+"' value='"+arrCarregar.data[p]['vl_mao_obra']+"'>";
            strModal+="</td>";
            strModal+="<td>";
            strModal+=" <input type='text' class='form-control form-control-sm' onkeypress='mascara(this,mdata)' maxlength='10' id='dt_faturamento"+p+"' name='dt_faturamento"+p+"'>";
            strModal+="</td>";
            strModal+="</tr>";
        }
        strModal+="</tbody>";
        strModal+="</table>";
        strModal+="</div>";
        strModal+="</div>";
    }
    
    
    
    
    
    
    
    $("#grid_contratos_itens").append(strModal);
}


function fcFormatarDadosContratoServicoExtra(){
    
    
    
    
    var contratos_pk = "";
    var contratos_itens_pk = "";
    var checked = "";
    var vl_total_mao_obra = "";
    var dt_faturamento = "";
    
    var arrKeys = [];
    arrKeys[0] = "contratos_pk";
    arrKeys[1] = "contratos_itens_pk";
    arrKeys[2] = "check";
    arrKeys[3] = "vl_total_mao_obra";
    arrKeys[4] = "dt_faturamento";
    
    var arrDados = [];
        var i = 0;
        var alt = 1;
        
        
        
        $('#tblContratosItensApontamento tbody tr').each(function () {
        var colunas = $(this).children();
            var check = 0;
        
            if($("#contratos_itens_pk_radio"+i).is(":checked") == true){
                check = 1;
                alt = 0;
                if($("#dt_faturamento"+i).val()==""){
                    alt = 1;
                }
            }
            else{
                check = 2;
                
            }
        
        
            
            contratos_pk =  $("#contratos_pk_radio"+i).val(); 
            contratos_itens_pk =  $("#contratos_itens_pk_radio"+i).val(); 
            vl_total_mao_obra =  moeda2float($("#vl_total_mao_obra"+i).val()); 
            dt_faturamento =  ($("#dt_faturamento"+i).val()); 
            checked =  check; 
            
            
            arrDados[i] = [contratos_pk, contratos_itens_pk,checked,vl_total_mao_obra,dt_faturamento];
            i++;
        });
    
    
    if(alt == 0){
        return arrayToJson(arrKeys, arrDados);
    }
    else{
        return 1;
    }
    
    
    
}






function fcLimparVariavelFalta(){
    $("#ds_re_falta").html("");
    $("#ds_colaborador_falta").html("");
    $("#ds_funcao_falta").html("");
    $("#hr_falta").html("");
    $("#motivo_falta_pk").val("");
    $("#colaborador_falta_pk").val("");
    $("#colaborador_faltou_pk").val("");
    
    $("#hr_entrada_manual").val("");
    $("#obs_falta").val("");
    $("#dia_semana_falta").val("");
    $("#dt_escala_falta").val("");
    $("#leads_pk_falta").val("");
    $('#ic_hr_sistema').prop('checked', false);
    $('#ic_hr_sistema').prop('disabled', false);
    $('#ic_falta').prop('checked', false);
    $('#ic_falta').prop('disabled', false);
    $('#motivo_falta_pk').prop('disabled', false);
    $('#hr_entrada_manual').prop('disabled', false);
}

function abrirModalFalta(leads_pk,ds_re,ds_colaborador,ds_funcao,hr_entrada,hr_saida,colaborador_pk,dt_agenda,dia_semana,ds_turno){
    
    fcLimparVariavelFalta();
   
    $("#dt_agenda_falta").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_falta").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_falta").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_falta").html("<b>Função:</b> "+ds_funcao);
    $("#hr_falta").html("<b>Turno :</b> " +ds_turno + hr_entrada);
    $("#colaborador_faltou_pk").val(colaborador_pk);
    $("#dt_escala_falta").val(dt_agenda);
    $("#dia_semana_falta").val(dia_semana);
    $("#leads_pk_falta").val(leads_pk);
    $(".chzn-select").chosen('destroy');
    $("#modal_falta").modal();
    
    setTimeout(function(){
        fcCarregarColaborador();
        $(".chzn-select").chosen('destroy');

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
}


function fcLimparVariavelFerias(){
    $("#ds_re_ferias").html("");
    $("#ds_colaborador_ferias").html("");
    $("#ds_funcao_ferias").html("");
    $("#hr_ferias").html("");
    $("#colaborador_ponto_pk").val("");
    $("#motivo_falta_pk").val("");
    $("#colaborador_ferias_pk").val("");
    $("#turnos_pk_ferias").val("");
    
    $("#dt_ferias_fim").val("");
    $("#dt_ferias_ini").val("");
    $("#leads_pk_ferias").val("");
}
function fcLimparVariavelCobertura(){
    $("#ds_re_cobertura").html("");
    $("#ds_colaborador_cobertura").html("");
    $("#ds_funcao_cobertura").html("");
    $("#hr_cobertura").html("");
    $("#colaborador_ponto_pk").val("");
    $("#colaborador_reserva_cobertura_pk").val("");
    $("#turnos_pk_cobertura").val("");
    $("#obs_cobertura").val("");
    
    $("#leads_pk_cobertura").val("");
}

function abrirModalFerias(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){
    
    fcLimparVariavelFerias();
    $("#modal_ferias").modal();
    $("#dt_agenda_ferias").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_ferias").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_ferias").html("<b> Colaborador: </b>"+ds_colaborador);
    $("#ds_funcao_ferias").html("<b>Função:</b> "+ds_funcao);
    $("#hr_ferias").html("<b>Turno :</b> " +ds_turno + hr_entrada);
    $("#colaborador_ferias_pk").val(colaborador_pk);
    $("#dt_ferias_ini").val(dt_agenda);
    $("#dia_semana_ferias").val(dia_semana);
    $("#leads_pk_ferias").val(leads_pk);
    $("#turnos_pk_ferias").val(turnos_pk);
    
    setTimeout(function(){
        fcCarregarColaborador();
        $(".chzn-select").chosen('destroy');

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
}
function abrirModalCobertura(leads_pk,turnos_pk,colaborador_pk,dt_agenda,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada,dia_semana){
    
    fcLimparVariavelCobertura();
   
    $("#ds_re_cobertura").html("R.E: "+ds_re);
    $("#ds_colaborador_cobertura").html("Nome Colaborador: "+ds_colaborador);
    $("#ds_funcao_cobertura").html("Função: "+ds_funcao);
    $("#hr_cobertura").html("Turno / Escala: " +ds_turno + hr_entrada);
    $("#colaborador_cobertura_pk").val(colaborador_pk);
    $("#dt_cobertura_ini").val(dt_agenda);
    $("#leads_pk_cobertura").val(leads_pk);
    $("#turnos_pk_cobertura").val(turnos_pk);
    $("#modal_cobertura").modal();
    setTimeout(function(){
        fcCarregarColaborador();
        $(".chzn-select").chosen('destroy');

        $(".chzn-select").chosen({allow_single_deselect: true});
    }, 1000);
}

function fcIncluirFerias(){
    if($('#dt_ferias_ini').val()==""){
        $("#alert_dt_ferias").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_ferias").slideUp(500);
        });
        return false;
    }
    if($('#dt_ferias_fim').val()==""){
        $("#alert_dt_ferias").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_dt_ferias").slideUp(500);
        });
        return false;
    }
    
    $("#modal_ferias").modal("hide");

    setTimeout(function(){
        var objParametros = {
            "dt_inicio": $("#dt_ferias_ini").val(),
            "dt_fim": $("#dt_ferias_fim").val()
        };      

        var arrCarregar = carregarController("agenda_colaborador_pausa", "datediff", objParametros); 
        var date_dif = arrCarregar.data[0]['diferenca'];
        var dt_agenda = $("#dt_ferias_ini").val();
        var dt_for_agenda = dt_agenda;

        // Precisamos quebrar a string para retornar cada parte
        var dataSplitFor = dt_for_agenda.split('/');

        var dayFor = dataSplitFor[0]; // 15
        var monthFor = dataSplitFor[1]; // 04
        var yearFor = dataSplitFor[2]; // 2019

       // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
        var data_for_agenda = new Date(yearFor, monthFor - 1, dayFor); 	
        var ultimoDia = new Date(data_for_agenda.getFullYear(), data_for_agenda.getMonth() + 1, 0);
        if($("#colaborador_substituto_ferias_pk").val()!=""){
            var ds_colaborador_ferias  = fcListarNomeColaborador($("#colaborador_substituto_ferias_pk").val());
        }
        else{
            var ds_colaborador_ferias  ="";
        }
        
        for(i=0;i<=date_dif;i++){
            var objParametros = {
                "ds_agenda_colaborador_pausa": "Férias",
                "turnos_pk": $("#turnos_pk_ferias").val(),
                "dt_inicio_pausa": dt_agenda,
                "dt_fim_pausa": dt_agenda,
                "colaboradores_pk": $("#colaborador_ferias_pk").val(),
                "colaborador_substituto_pk":$("#colaborador_substituto_ferias_pk").val()
            }; 


            var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
           
            if (arrEnviar.result == 'success'){
                
                
                if(i==0){

                    alert(arrEnviar.message);

                }

                var dataComp = dt_agenda.split('/');

                var dayComp = dataComp[0]; // 15
                var monthComp = dataComp[1]; // 04
                var yearComp = dataComp[2]; // 2019

               // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
                var data_comp_agenda = new Date(yearComp, monthComp - 1, dayComp); 


                var dia_semana = data_comp_agenda.getDay();


                fcDeletarFalta(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarCobertura(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarExclusao(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarTrocaColaborador(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarFolga(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarPonto(dt_agenda,$("#colaborador_ferias_pk").val());
                fcDeletarHoraExtra(dt_agenda,$("#colaborador_ferias_pk").val());
                
                if(grid_agenda==1){
                    if(data_comp_agenda<=ultimoDia){
                        fcColorirGrid(dia_semana,(dayComp-1),$("#colaborador_ferias_pk").val(),"3511aa");
                        if(ds_colaborador_ferias!=""){
                            fcPreencherLabel(dia_semana,(dayComp-1),$("#colaborador_ferias_pk").val(),ds_colaborador_ferias);
                        }
                        else{
                            fcPreencherLabel(dia_semana,(dayComp-1),$("#colaborador_ferias_pk").val(),"Férias");
                        }
                        
                        fcColorirLabel(dia_semana,(dayComp-1),$("#colaborador_ferias_pk").val(),"black");
                    }
                   
                }
                else if(grid_agenda==2){
                    if(data_comp_agenda<=ultimoDia){
                        fcColorirGrid(dia_semana,(dayComp-1),$("#leads_pk_ferias").val(),"3511aa");
                        if(ds_colaborador_ferias!=""){
                            fcPreencherLabel(dia_semana,(dayComp-1),$("#leads_pk_ferias").val(),ds_colaborador_ferias);
                        }
                        else{
                            fcPreencherLabel(dia_semana,(dayComp-1),$("#leads_pk_ferias").val(),"Férias");
                        }
                        
                        fcColorirLabel(dia_semana,(dayComp-1),$("#leads_pk_ferias").val(),"black");
                    }
                   
                }
                
                
                

                

                 var p_nova_dt_agenda = dt_agenda.split("/");


                //pega a data que ja passou pelo for 
                var nova_dt_agenda_dia_anterior = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                var nova_dt_agenda_dia_proximo = new Date(p_nova_dt_agenda[2], p_nova_dt_agenda[1] - 1, p_nova_dt_agenda[0]);
                //a cada looping acrescenta mais um dia 
                nova_dt_agenda_dia_proximo.setDate(nova_dt_agenda_dia_anterior.getDate() + 1);

                var dt_agenda = 0;
                var dia = 0;
                var mes = 0;
                var ano = 0;
                if(nova_dt_agenda_dia_proximo.getDate()<10){
                    dia = "0"+nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }
                else{
                    dia = nova_dt_agenda_dia_proximo.getDate();
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();
                }

                if((nova_dt_agenda_dia_proximo.getMonth()+1)<10){
                    mes = "0"+(nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }
                else{
                    mes = (nova_dt_agenda_dia_proximo.getMonth()+1);
                    ano = nova_dt_agenda_dia_proximo.getFullYear();

                }                
                dt_agenda = dia+"/"+mes+"/"+ano;

            }
            else{
                alert(arrEnviar.result);
            }
        }
    fcHistoricoApontamento();
    }, 100); 
}
function fcIncluirCobertura(){
    
    
    if($("#colaborador_reserva_cobertura_pk").val()==""){
        $("#alert_cobertura").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_cobertura").slideUp(500);
        });
        return false;
    }
    
    
    var dt_agenda = $("#dt_cobertura_ini").val();

    var objParametros = {
        "ds_agenda_colaborador_pausa": "Cobertura",
        "turnos_pk": $("#turnos_pk_cobertura").val(),
        "dt_inicio_pausa": $("#dt_cobertura_ini").val(),
        "dt_fim_pausa": $("#dt_cobertura_ini").val(),
        "colaboradores_pk": $("#colaborador_cobertura_pk").val(),
        "colaborador_substituto_pk": $("#colaborador_reserva_cobertura_pk").val(),
        "ds_obs_folga": $("#obs_cobertura").val()
    }; 
    var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
    
    if (arrEnviar.result == 'success'){
        var dataComp = dt_agenda.split('/');

        var dayComp = dataComp[0]; // 15
        var monthComp = dataComp[1]; // 04
        var yearComp = dataComp[2]; // 2019

       // Agora podemos inicializar o objeto Date, lembrando que o mês começa em 0, então fazemos -1.
        var data_comp_agenda = new Date(yearComp, monthComp - 1, dayComp); 


        var dia_semana = data_comp_agenda.getDay();


        fcDeletarFalta(dt_agenda,$("#colaborador_cobertura_pk").val());
        fcDeletarExclusao(dt_agenda,$("#colaborador_cobertura_pk").val());
        fcDeletarTrocaColaborador(dt_agenda,$("#colaborador_cobertura_pk").val());
        fcDeletarFolga(dt_agenda,$("#colaborador_cobertura_pk").val());
        fcDeletarPonto(dt_agenda,$("#colaborador_cobertura_pk").val());
        fcDeletarHoraExtra(dt_agenda,$("#colaborador_cobertura_pk").val());

        
        alert(arrEnviar.message);
        $("#modal_cobertura").modal("hide");
        fcHistoricoApontamento();

    }
    else{
        alert(arrEnviar.result);
    }
        
    
    
}

function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("colaborador", "listarTodosReservas", objParametros);  
    
    carregarComboAjax($("#colaborador_falta_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    carregarComboAjax($("#colaborador_reserva_cobertura_pk"), arrCarregar, " ", "pk", "ds_colaborador");
    carregarComboAjax($("#colaborador_substituto_ferias_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}
function fcDesabilitarHrSistema(){
    if($('#ic_hr_sistema').is(":checked")){
        $('#ic_hr_sistema').prop('checked', true);
        $('#hr_entrada_manual').val("");
        $('#hr_entrada_manual').prop('disabled',true);
        $('#motivo_falta_pk').prop('disabled',true);
        $('#ic_falta').prop('disabled',true);
        $('#exibir_colaborador_falta').hide();
        $('#ic_falta').prop('checked',false);
        
    }
    else {
        $('#ic_hr_sistema').prop('checked', false);
        $('#hr_entrada_manual').prop('disabled',false);
        $('#motivo_falta_pk').prop('disabled',true);
        $('#ic_falta').prop('disabled',false);
        $('#colaborador_falta_pk').prop('disabled',false);
        $('#ic_falta').prop('checked',false);
        $('#exibir_colaborador_falta').hide();
    }
    
    
    
}
function fcDesabilitarFalta(){
    if($('#ic_falta').is(":checked")){
        $('#ic_falta').prop('checked', true);
        $('#hr_entrada_manual').val("");
        $('#hr_entrada_manual').prop('disabled',true);
        $('#motivo_falta_pk').prop('disabled',false);
        $('#ic_hr_sistema').prop('checked', false);
        $('#ic_hr_sistema').prop('disabled', true);
        setTimeout(function(){
            fcCarregarColaborador();
            $(".chzn-select").chosen('destroy');

            $(".chzn-select").chosen({allow_single_deselect: true});
        }, 500);
        $('#exibir_colaborador_falta').show();
        
    }
    else {
        $('#ic_falta').prop('checked', false);
        $('#hr_entrada_manual').val("");
        $('#hr_entrada_manual').prop('disabled',false);
        $('#motivo_falta_pk').prop('disabled',true);
        $('#ic_hr_sistema').prop('checked', false);
        $('#ic_hr_sistema').prop('disabled', false);
        $('#colaborador_falta_pk').prop('disabled', false);
        $('#exibir_colaborador_falta').hide();
    }
    
    
    
}

function fcListarNomeColaborador(pk){
     var objParametros = {
        "pk": pk
    };      
    
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros);   
    if(arrCarregar.data.length > 0){
        return arrCarregar.data[0]['ds_colaborador'];
    }
    else{
        return "";
    }
    
    
}
function fcSalvarPonto(){
   
    var ArrData = $("#dt_escala_ponto").val().split("/");
    var data_ponto = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    
    if($("#tipo_registro_ponto_pk").val()==""){
        $("#alert_tipo_registro").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tipo_registro").slideUp(500);
        });
        return false;
    }
    
    
    
        var str_hora = "";
        if($('#ic_hr_sistema').is(":checked")){
            var data = new Date();
            var hora    = data.getHours();          // 0-23
            var min     = data.getMinutes();        // 0-59
            var seg     = data.getSeconds();        // 0-59
            
             str_hora = hora + ':' + min;
        }
        else{
             str_hora = $("#hr_entrada_manual").val()
        }
        //Pega o Pin do Colaborador
        var ds_pin = FcBuscarPinColaborador($("#colaborador_ponto_pk").val())


        var objParametros = {
            "pk": "",
            "colaborador_pk": $("#colaborador_ponto_pk").val(),
            "dt_hora_ponto": $("#dt_escala_ponto").val(),
            "hr_ponto": str_hora,
            "ds_pin": ds_pin,
            "tipo_ponto_pk": $("#tipo_registro_ponto_pk").val(),
            "ic_dispositivo": 2
        }; 

        var arrEnviar = carregarController("ponto", "salvar", objParametros);
       
        if (arrEnviar.result == 'success'){
            fcDeletarHoraExtra($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            //fcDeletarExclusaoNovaEscala($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarFalta($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarCobertura($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarFerias($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarExclusao($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarFolga($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            fcDeletarTrocaColaborador($("#dt_escala_ponto").val(),$("#colaborador_ponto_pk").val());
            
            
            
            fcHistoricoApontamento();
            
            
            
            alert(arrEnviar.message);
            $("#modal_ponto").modal("hide");
            
            
            
            
            if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_ponto").val(),(data_ponto.getDate()-1),$("#colaborador_ponto_pk").val(),"green");
                    
            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_ponto").val(),(data_ponto.getDate()-1),$("#leads_pk_ponto").val(),"green");
                    
            }
            
            
            

        }    
        else{
            alert(arrEnviar.result);
        }
}
function fcSalvarServicoExtra(){
   
   
   
   var StrServicoExtra = fcFormatarDadosContratoServicoExtra();
   
   if(StrServicoExtra==1){
       alert("Por favor, Informe um Contrato e Preencha Data Faturamento.");
       return false;
   }


        var objParametros = {
            "pk": "",
            "colaborador_pk": $("#colaborador_servico_extra_pk").val(),
            "dt_escala": $("#dt_escala_servico_extra").val(),
            "leads_pk": $("#leads_pk_servico_extra").val(),
            "StrServicoExtra": StrServicoExtra,

        }; 

        var arrEnviar = carregarController("apontamento_servico_extra", "salvar", objParametros);
       
        if (arrEnviar.result == 'success'){    
            
            
            fcHistoricoApontamento();
            
            
            
            alert(arrEnviar.message);
            $("#modal_servico_extra").modal("hide");
            
            
            
            
            /*if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_ponto").val(),(data_ponto.getDate()-1),$("#colaborador_ponto_pk").val(),"green");
                    
            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_ponto").val(),(data_ponto.getDate()-1),$("#leads_pk_ponto").val(),"green");
                    
            }*/
            
            
            

        }    
        else{
            alert(arrEnviar.result);
        }
}
function fcSalvarFalta(){
    var ArrData = $("#dt_escala_falta").val().split("/");
    var data_ponto = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    
    if($("#motivo_falta_pk").val()==""){
        $("#alert_motivo_falta").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_motivo_falta").slideUp(500);
        });
        return false;
    }
    
    
    
        var objParametros = {
            "pk": "",
            "motivo_falta_pk": $("#motivo_falta_pk").val(),
            "obs": $("#obs_falta").val(),
            "colaborador_reserva_pk": $("#colaborador_falta_pk").val(),
            "colaborador_pk": $("#colaborador_faltou_pk").val(),
            "dt_escala": $("#dt_escala_falta").val(),
            "leads_pk": $("#leads_pk_falta").val(),

        }; 

        var arrEnviar = carregarController("colaborador_falta", "salvar", objParametros);
       
        if (arrEnviar.result == 'success'){
            
            if($("#colaborador_falta_pk").val()!=""){
                var ds_colaborador_falta  = fcListarNomeColaborador($("#colaborador_falta_pk").val());
            }
            else{
                var ds_colaborador_falta  = "Falta" ;
            }
            
            
            fcDeletarPonto($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarHoraExtra($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarCobertura($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarExclusao($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarFolga($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarTrocaColaborador($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarFerias($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            fcDeletarExclusaoNovaEscala($("#dt_escala_falta").val(),$("#colaborador_faltou_pk").val());
            
            
            if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_falta").val(),(data_ponto.getDate()-1),$("#colaborador_faltou_pk").val(),"orange");
                fcPreencherLabel($("#dia_semana_falta").val(),(data_ponto.getDate()-1),$("#colaborador_faltou_pk").val(),ds_colaborador_falta+" - "+ $("#motivo_falta_pk option:selected").text());
                    
            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_falta").val(),(data_ponto.getDate()-1),$("#leads_pk_falta").val(),"orange");
                fcPreencherLabel($("#dia_semana_falta").val(),(data_ponto.getDate()-1),$("#leads_pk_falta").val(),ds_colaborador_falta+" - "+ $("#motivo_falta_pk option:selected").text());
                    
            }
            
            
            
            alert(arrEnviar.message);
            $("#modal_falta").modal("hide");
            fcHistoricoApontamento();

        }    
        else{
            alert(arrEnviar.result);
        }
}


function fcLimparVariavelColaborador(){

    //$("#ds_colaborador_atual_agenda").html("");
    $("#dt_base_modal").html("");
    $("#dt_base_inclusao_modal").val("");
    $("#dias_semana_inclusao").val("");
    $("#produtos_servicos_pk").val("");
    $("#turnos_pk").val("");
    $("#agenda_contratos_pk").val("");
    $("#colaborador_atual_pk").val("");
    $("#ds_obs").val("");
    $("#dia_semana_troca").val("");
    $("#pausa_pk").val("");
    $("#leads_pk_troca").val("");
}
function abrirModal(leads_pk,ds_turno,hr_turno,ds_produto_servico,ds_colaborador,dt_agenda,dia_semana,produtos_servicos_pk,turnos_pk,colaborador_atual_pk,contratos_pk,pausa_pk,ds_re){
    
    var arrCarregar = permissao("agenda_colaborador", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }

    fcLimparVariavelColaborador();
    
    //$("#ds_turno_agenda").html("Turno:  "+ds_turno+" ("+hr_turno+")");
    //$("#ds_servico_agenda").html("Serviço:  "+ds_produto_servico);
    //$("#ds_colaborador_atual_agenda").html("Colaborador Atual:  "+ds_colaborador);
    
    $("#dt_base_inclusao_modal").val(dt_agenda);
    $("#dias_semana_inclusao").val(dia_semana);
    $("#produtos_servicos_pk").val(produtos_servicos_pk);
    $("#turnos_pk").val(turnos_pk);
    $("#colaborador_atual_pk").val(colaborador_atual_pk);
    $("#agenda_contratos_pk").val(contratos_pk);
    $("#dt_base_modal").html("<b>Data Selecionada:</b>"+dt_agenda);
    $("#ds_re_troca").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_troca").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_troca").html("<b>Função:</b> "+ds_produto_servico);
    $("#hr_troca").html("<b>Turno:</b> " +ds_turno +" "+ hr_turno);
    $("#dt_escala_ponto").val(dt_agenda);
    $("#dia_semana_troca").val(dia_semana);
    $("#leads_pk_troca").val(leads_pk);
    if(pausa_pk!=0){
        $("#pausa_pk").val(pausa_pk);
    }
    

    fcCarregarColaboradores();

    fcCarregarMotivoAlteracaoEscala();

    $("#janela_escala").modal();
    
}
function abrirModalRetomarEscala(leads_pk,re,colaborador,funcao,ds_turno,hr_turno_saida,hr_turno,dt_agenda,dia_semana,colaborador_pk){
    
    var arrCarregar = permissao("agenda_colaborador", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(dia_semana==1){
        $("#ds_dia_semana").html("Domingo");
    }
    else if(dia_semana==2){
        $("#ds_dia_semana").html("Segunda");
    }
    else if(dia_semana==3){
        $("#ds_dia_semana").html("Terça");
    }
    else if(dia_semana==4){
        $("#ds_dia_semana").html("Quarta");
    }
    else if(dia_semana==5){
        $("#ds_dia_semana").html("Quinta");
    }
    else if(dia_semana==6){
        $("#ds_dia_semana").html("Sexta");
    }
    else if(dia_semana==7){
        $("#ds_dia_semana").html("Sabado");
    }
    $("#dt_inicio_inc").val(dt_agenda);
    $("#dt_base_modal_inc").html("<b>Data Selecionada: </b>" + dt_agenda);
    $("#ds_turno_inc").html("<b>Turno: </b>" +ds_turno+" "+hr_turno);
    $("#re_ins").html("<b>R.E: </b>" +re);
    $("#colaborador_ins").html("<b>Colaborador: </b>" +colaborador);
    $("#funcao_ins").html("<b>Função: </b>" +funcao);
    $("#ds_hr_entrada_inc").html(hr_turno);
    $("#ds_hr_saida_inc").html(hr_turno_saida);
    $("#dia_semana_inc").val(dia_semana);
    $("#colaborador_pk_inc").val(colaborador_pk);
    $("#leads_pk_inc").val(leads_pk);
    

    $("#janela_retornar_escala").modal();
    
}

function fcIncluirRetomarEscala(){
    var ArrData = $("#dt_inicio_inc").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    fcDeletarTrocaColaborador($("#dt_inicio_inc").val(),$("#colaborador_pk_inc").val());
    fcDeletarExclusao($("#dt_inicio_inc").val(),$("#colaborador_pk_inc").val());
    fcDeletarFolga($("#dt_inicio_inc").val(),$("#colaborador_pk_inc").val());

    $("#janela_retornar_escala").modal("hide");
    fcHistoricoApontamento();
   
        

    
   
    
}
function abrirModalIncluirEscala(leads_pk,ds_re,ds_colaborador,ds_funcao,dt_agenda,dia_semana,colaborador_pk,agenda_pk,processos_etapas_pk,contratos_itens_pk){
    
    var arrCarregar = permissao("agenda_colaborador", "ins");        
        
    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
    if(dia_semana==1){
        $("#ds_dia_semana_ins").html("Dia Semana: Domingo");
    }
    else if(dia_semana==2){
        $("#ds_dia_semana_ins").html("Dia Semana: Segunda");
    }
    else if(dia_semana==3){
        $("#ds_dia_semana_ins").html("Dia Semana: Terça");
    }
    else if(dia_semana==4){
        $("#ds_dia_semana_ins").html("Dia Semana: Quarta");
    }
    else if(dia_semana==5){
        $("#ds_dia_semana_ins").html("Dia Semana: Quinta");
    }
    else if(dia_semana==6){
        $("#ds_dia_semana_ins").html("Dia Semana: Sexta");
    }
    else if(dia_semana==7){
        $("#ds_dia_semana_ins").html("Dia Semana: Sabado");
    }
    $("#dt_inicio_ins").val(dt_agenda);
    $("#dia_semana_ins").val(dia_semana);
    $("#colaborador_pk_ins").val(colaborador_pk);
    $("#agenda_pk_ins").val(agenda_pk);
    $("#leads_pk_ins").val(leads_pk);
    $("#processos_etapas_pk_ins").val(processos_etapas_pk);
    $("#contratos_itens_pk_ins").val(contratos_itens_pk);
    
    
    $("#dt_base_modal_ins").html("<b>Data Selecionada:</b>"+dt_agenda);
    $("#ds_re_ins").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_ins").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_ins").html("<b>Função:</b> "+ds_funcao);
    //$("#hr_troca").html("<b>Turno:</b> " +ds_turno +" "+ hr_turno);
    fcCarregarTurno();

    $("#hr_turno_ins").keypress(function(){
       mascara(this,horamask);
    });
    $("#janela_incluir_escala").modal();
    
}

function fcCarregarTurno(){
    
    var objParametros = {
        "pk": ""
    };      
    
    var arrCarregar = carregarController("turno", "listarTodos", objParametros);
    
    carregarComboAjax($("#turnos_pk_ins"), arrCarregar, " ", "pk", "ds_turno");
        
}

function fcIncluirNovaEscala(){
    var ArrData = $("#dt_inicio_ins").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    
    
    if($("#hr_turno_ins").val()==""){
        $("#alert_turno_ins_escala").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_turno_ins_escala").slideUp(500);
        });
        return false;
    }
    if($("#turnos_pk_ins").val()==""){
        $("#alert_hora_turno_escala").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_hora_turno_escala").slideUp(500);
        });
        return false;
    }
    
        var objParametros = {
            "ds_agenda_colaborador_pausa": $("#hr_turno_ins").val(),
            "turnos_pk": $("#turnos_pk_ins").val(),
            "dt_inicio_pausa": $("#dt_inicio_ins").val(),
            "dt_fim_pausa": $("#dt_inicio_ins").val(),
            "colaboradores_pk": $("#colaborador_pk_ins").val()
        }; 
     

        var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
      
        if (arrEnviar.result == 'success'){
            fcDeletarHoraExtra($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarFalta($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarCobertura($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarFerias($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarExclusao($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarTrocaColaborador($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarFolga($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            fcDeletarPonto($("#dt_inicio_ins").val(),$("#colaborador_pk_ins").val());
            
            
            if(grid_agenda==1){
                
                fcColorirGrid($("#dia_semana_ins").val(),(data.getDate()-1),$("#colaborador_pk_ins").val(),"black");
                fcPreencherLabel($("#dia_semana_ins").val(),(data.getDate()-1),$("#colaborador_pk_ins").val(),"("+$("#hr_turno_ins").val()+")");
                fcColorirLabel($("#dia_semana_ins").val(),(data.getDate()-1),$("#colaborador_pk_ins").val(),"0000ff");
                    
            }
            else if(grid_agenda==2){
                
                fcColorirGrid($("#dia_semana_ins").val(),(data.getDate()-1),$("#leads_pk_ins").val(),"black");
                fcPreencherLabel($("#dia_semana_ins").val(),(data.getDate()-1),$("#leads_pk_ins").val(),"("+$("#hr_turno_ins").val()+")");
                fcColorirLabel($("#dia_semana_ins").val(),(data.getDate()-1),$("#leads_pk_ins").val(),"0000ff");
                    
            }
            
            
            
            
            alert(arrEnviar.message);
            $("#janela_incluir_escala").modal("hide");
            fcHistoricoApontamento();

        }    
        else{
            alert(arrEnviar.result);
        }
        

    
   
    
}
function fcCarregarMotivoAlteracaoEscala(){
    var objParametros = {
        "pk": "",
        "ic_status": 1
    };  
    
    var arrCarregar = carregarController("motivo_alteracao_escala", "listarTodos", objParametros); 
   
    carregarComboAjax($("#motivo_alteracao_pk"), arrCarregar, " ", "pk", "ds_motivo_alteracao_escala");
        
}
function fcCarregarColaboradores(){
    var objParametros = {
        "pk": "",
        "dia_semana_pk": $("#dias_semana_inclusao").val(),
        "turnos_pk": $("#turnos_pk").val(),
        "contratos_itens_pk":$("#produtos_servicos_pk").val() ,
        "dt_inicio_agenda": $("#dt_base_inclusao_modal").val(),
        "agenda_colaborador_padrao_pk":""
    };  
    
    var arrCarregar = carregarController("colaborador", "listarTodosColaboradoresEServicoAgenda", objParametros); 
    carregarComboAjax($("#colaboradores_pk"), arrCarregar, " ", "pk", "ds_colaborador");
        
}


function fcIncluirColaboradorPausa(){
    if($("#motivo_alteracao_pk").val()==""){
        $("#alert_motivo").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_motivo").slideUp(500);
        });
        return false;
    }
    
    if($("#colaboradores_pk").val()==""){
        $("#alert_colaborador").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_colaborador").slideUp(500);
        });
        return false;
    }
    var ArrData = $("#dt_base_inclusao_modal").val().split("/");
    var data = new Date(ArrData[2], ArrData[1] - 1, ArrData[0]);
    //atualiza o registro no DB, pois já existe uma PK para contatos no banco.
    var objParametros = {
        "pk": "",
        "ds_agenda_colaborador_pausa": "Substituição Agenda",
        "dt_inicio_pausa": $("#dt_base_inclusao_modal").val(),
        "dt_fim_pausa": $("#dt_base_inclusao_modal").val(),
        "colaboradores_pk": $("#colaborador_atual_pk").val(),
        "colaborador_substituto_pk": $("#colaboradores_pk").val(),
        "turnos_pk": $("#turnos_pk").val(),
        "motivos_pausas_pk": $("#motivo_alteracao_pk").val(),
        "leads_pk": $("#leads_pk_troca").val()
        
    }; 

    var arrEnviar = carregarController("agenda_colaborador_pausa", "salvar", objParametros);
  
    if (arrEnviar.result == 'success'){
        if($("#colaboradores_pk").val()!=""){
            var ds_colaborador  = fcListarNomeColaborador($("#colaboradores_pk").val());
       }
       else{
           var ds_colaborador  = "Troca Colaborador";
       }
        fcDeletarFalta($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        
        fcDeletarFerias($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        fcDeletarExclusao($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        fcDeletarPonto($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        fcDeletarHoraExtra($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        fcDeletarFolga($("#dt_base_inclusao_modal").val(),$("#colaborador_atual_pk").val());
        
        
         if(grid_agenda==1){
                
            fcColorirGrid($("#dia_semana_troca").val(),(data.getDate()-1),$("#colaborador_atual_pk").val(),"yellow");
            fcPreencherLabel($("#dia_semana_troca").val(),(data.getDate()-1),$("#colaborador_atual_pk").val(),ds_colaborador);
            fcColorirLabel($("#dia_semana_troca").val(),(data.getDate()-1),$("#colaborador_atual_pk").val(),"0000ff");

        }
        else if(grid_agenda==2){

            fcColorirGrid($("#dia_semana_troca").val(),(data.getDate()-1),$("#leads_pk_troca").val(),"yellow");
            fcPreencherLabel($("#dia_semana_troca").val(),(data.getDate()-1),$("#leads_pk_troca").val(),ds_colaborador);
            fcColorirLabel($("#dia_semana_troca").val(),(data.getDate()-1),$("#leads_pk_troca").val(),"0000ff");

        }
        
        
        
        alert(arrEnviar.message);
        $("#janela_escala").modal("hide");
        fcHistoricoApontamento();
        
    }    
    else{
        alert(arrEnviar.result);
    }
    
}

//---------------------------------------------------------------TAREFA----------------------------------

function fcAbrirModalTarefa(leads_pk,dt_agenda,ic_dia_semana,agendas_pk,ds_re,ds_colaborador,ds_funcao,ds_turno,hr_entrada){

    
    $("#ic_dia").val("");
    $("#ds_tarefa").val("");
    $("#obs_tarefa").val("");
    $("#hr_inicio").val("");
    $('#ic_tarefa_recorrente').prop('checked', false);
    $("#dt_execucao").val(dt_agenda);
    $("#ic_dia").val(ic_dia_semana);
    $("#agendas_pk").val(agendas_pk);
    $("#leads_pk_tarefa").val(leads_pk);
    $("#dt_agenda_tarefa").html("<b>Data Selecionada:</b> "+dt_agenda);
    $("#ds_re_tarefa").html("<b>R.E:</b> "+ds_re);
    $("#ds_colaborador_tarefa").html("<b>Colaborador:</b> "+ds_colaborador);
    $("#ds_funcao_tarefa").html("<b>Função:</b> "+ds_funcao);
    $("#hr_tarefa").html("<b>Turno:</b> " +ds_turno +" "+ hr_entrada);
    
    
    
    
    $("#modal_tarefa").modal();
    window.setTimeout(function(){
    tblTarefa.clear().destroy();
    
    fcFormatarGrid();
    }, 200);
    
}
function fcFormatarGrid(){
       
   var objParametros = {
        "agendas_pk": $("#agendas_pk").val(),
        "ic_dia":$("#ic_dia").val(),
        "dt_execucao":$("#dt_execucao").val()
    };     
    var v_url = montarUrlController("agenda_colaborador_tarefa", "listarTarefaPorIcDiaAgenda", objParametros);
    //Trata a tabela
    tblTarefa = $('#tblTarefa').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false, 
        "columnDefs": [
            {
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "hr_inicio"},
           {"targets": -3, "data": "dt_execucao"},
           {"targets": -4, "data": "obs_tarefa"},
           {"targets": -5, "data": "ds_tarefa"},
           {"targets": -6, "data": "pk"},
           

         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });
    $('#tblTarefa tbody').on('click', '.function_delete', function () {
        var data;
        
        if(tblTarefa.row( $(this).parents('li') ).data()){
            data = tblTarefa.row( $(this).parents('li') ).data();
        }
        else if(tblTarefa.row( $(this).parents('tr') ).data()){
            data = tblTarefa.row( $(this).parents('tr') ).data();
        }
        
        if(data['pk'] != ""){
            fcExcluirTarefa(data['pk']);
        }
        tblTarefa.clear().destroy();
        fcFormatarGrid();
        
    } );
    
}
function fcExcluirTarefa(v_pk){
    if(v_pk != ""){
        var objParametros = {
            "pk": v_pk
        };              

        var arrExcluir = carregarController("agenda_colaborador_tarefa", "excluir", objParametros);   
        if (arrExcluir.result == 'success'){

            tblTarefa.clear().destroy();
            fcFormatarGrid();
        }
        else{
            alert('Falhou a requisição de exclusão.');
        }
    }
    else{
        alert("Código não encontrado");
    }
}
function fcSalvarTarefa(){
   var ic_tarefa_recorrente = "";
     
    if($("#ic_tarefa_recorrente").is(":checked")){
       ic_tarefa_recorrente = 1; 
      
    }
    var objParametros = {
        "agendas_pk": $("#agendas_pk").val(),
        "pk":"",
        "dt_execucao":$("#dt_execucao").val(),
        "ic_tarefa_recorrente":ic_tarefa_recorrente,
        "ds_tarefa":$("#ds_tarefa").val(),
        "obs_tarefa":$("#obs_tarefa").val(),
        "hr_inicio":$("#hr_inicio").val(),
        "ic_dia":$("#ic_dia").val()

    }; 
    //alert($('#agenda_contratos_itens_pk').val())
    var arrEnviar = carregarController("agenda_colaborador_tarefa", "salvar", objParametros);

    if (arrEnviar.result == 'success'){
        tblTarefa.clear().destroy();
        fcFormatarGrid();
    }    
    else{
        alert(arrEnviar.result);
    }
}

function fcGridDados(){
    var objParametrosContrato = {
        "leads_pk":  leads_pk
    };    
    
    var v_url = carregarController("contrato", "listarDadosContratoLead", objParametrosContrato); 
        //Trata a tabela
        tblGridDados = $('#tblGridDados').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": true,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_edit'><span><img width=18 height=18 title='Agenda de Escalas'src='../img/calendario.png'></span></a>"
            },
           {"targets": -2, "data": "n_qtde"}, 
           {"targets": -3, "data": "n_qtde_dias_semana"},
           {"targets": -4, "data": "ds_produto_servico"},
           {"targets": -5, "data": "dt_periodo"},
           {"targets": -6, "data": "pk"}, 
         ],
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }
    });

}
function FcBuscarPinColaborador(colaborador_pk){

    var objParametrosColaboradores = {
        "colaborador_pk": colaborador_pk
    };

    var arrColaborador = carregarController("colaborador", "listarDadosColaborador", objParametrosColaboradores);

    if (arrColaborador.result == 'success'){

       return arrColaborador.data[0]['ds_pin']
    }

}

function fcCarregarColaboradorIniApontamento(){    
    var objParametros = {
        "pk": ""
    };         
    var arrCarregar = carregarController("colaborador", "listarColaboradorAgenda", objParametros);    
    
    carregarComboAjax($("#colaborador_combo_apontamento_pk"), arrCarregar, " ", "pk", "ds_colaborador");         
}


$(document).ready(function(){
    
    //AGENDAS

    fcCarregarTurno();

    
    //fcGridDados();
    
    //fcCarregarEtapasProcesso();
    //$(document).on('click', '#cmdEnviar', fcCarregar);
    $(document).on('click', '#cmdIncluir', fcIncluirColaboradorPausa);
    $(document).on('click', '#cmdRetornarEscala', fcIncluirRetomarEscala);
    $(document).on('click', '#cmdIncluirEscala', fcIncluirNovaEscala);
    $(document).on('click', '#btnAtribuirFerias', fcIncluirFerias);
    
    
    $('#cmdAgendaColaborador').on('click', function(e) {
        e.preventDefault();
        if($("#colaboradores_pk").val()!=""){
            $("#myModal").modal("show");
            $(".modal-body-agenda").html('<iframe width="1180px" height="525px" frameborder="0" scrolling="yes" allowtransparency="true" src="agenda_colaborador_cad_form.php?token='+token+'&pk='+$("#colaboradores_pk").val()+'"></iframe>');
            
        }
        else{
            $("#myModal").modal("hide");
            $("#colaboradores_pk").focus();
        }
       
    });
    
    //fcCarregarLead();
    //fcFormatarGrid();
  
    //TAREFA
    $(document).on('click', '#btntarefa', fcSalvarTarefa);
    $(document).on('click', '#btnAfastamento', fcSalvarAfastamento);
    
    
    
    $("#hr_inicio").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_inicio_hora_extra").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_hora_extra").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_entrada_manual").keypress(function(){
       mascara(this,horamask);
    });
    $(document).on('click', '#btnPonto', fcSalvarPonto);
    $(document).on('click', '#btnServicoExtra', fcSalvarServicoExtra);
    $(document).on('click', '#btnFalta', fcSalvarFalta);
    $(document).on('click', '#ic_hr_sistema', fcDesabilitarHrSistema);
    $(document).on('click', '#ic_falta', fcDesabilitarFalta);
    $(document).on('click', '#btnExclusao', fcSalvarExclusao);
    $(document).on('click', '#btnAtribuirFolga', fcSalvarFolga);
    $(document).on('click', '#btnCobertura', fcIncluirCobertura);
    $(document).on('click', '#cmdCancelarModalPainel', fcFecharModalPainel);
    $(document).on('click', '#btnHoraExtra', fcSalvarHoraExtra);
    
    $("#tabela input").keyup(function(){
        var index = $(this).parent().index();
        var nth = "#tabela th:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                        $(this).parent().hide();
                }
            });
    });
    $("#tabela select").keyup(function(){
        var index = $(this).parent().index();
        var nth = "#tabela th:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tabela tbody tr").show();
        $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                        $(this).parent().hide();
                }
            });
    });
    $("#tabela select").blur(function(){
        $(this).val("");
    });	
    
    
    //fcCarregarColaborador();
    
    
    //$(".chzn-select").chosen('destroy');
    
    //$(".chzn-select").chosen({allow_single_deselect: true});
    
    
    $("#exibir_colaborador_cobertura").hide();
    
   
    // Mostra o resultado

    $('#dt_ferias_ini').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_ferias_ini").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_ferias_fim').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_ferias_fim").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_inicio_afastamento').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_inicio_afastamento").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    $('#dt_fim_afastamento').datepicker({

        defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: false,
        todayBtn: "linked",
        minDate: new Date()       
    });
    $("#dt_fim_afastamento").keypress(function(){
        mascara(this,mdata);      
        $('#sandbox-container input').datepicker({ minDate: 0});
    });
    
   
});