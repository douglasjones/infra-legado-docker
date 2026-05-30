var tblResultado;
function fcEnviar(){
    //Validações de Campos
    if($("#ds_tarefa").val()==""){
        $("#alert_ds_tarefa").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_ds_tarefa").slideUp(500);
        });
        $('#ds_tarefa').focus();
        return false;
    }          
    if($("#leads_pk").val()==""){
        $("#alert_leads_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_leads_pk").slideUp(500);
        });
        $('#leads_pk').focus();
        return false;
    }  

    if($("#tarefas_local_pk").val()==""){
        $("#alert_tarefas_local_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tarefas_local_pk").slideUp(500);
        });
        $('#tarefas_local_pk').focus();
        return false;
    } 
    
    if($("#tarefas_area_pk").val()==""){
        $("#alert_tarefas_area_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tarefas_areal_pk").slideUp(500);
        });
        $('#tarefas_area_pk').focus();
        return false;
    } 
    
    if($("#tarefas_tipos_servicos_pk").val()==""){
        $("#alert_tarefas_tipos_servicos_pk").fadeTo(2000, 500).slideUp(500, function(){
            $("#alert_tarefas_tipos_servicos_pk").slideUp(500);
        });
        $('#tarefas_tipos_servicos_pk').focus();
        return false;
    } 

    var v_ds_tarefa = $("#ds_tarefa").val();
    var v_leads_pk = $("#leads_pk").val();
    var v_tarefas_local_pk = $("#tarefas_local_pk").val();
    var v_tarefas_area_pk = $("#tarefas_area_pk").val();
    var v_colaborador_pk = $("#colaborador_pk").val();
    var v_tarefas_tipos_servicos_pk = $("#tarefas_tipos_servicos_pk").val();
    if($('#ic_dom').is(":checked")){
        var v_ic_dom = 1;
    }else{
        var v_ic_dom = "";
    }
    if($('#ic_seg').is(":checked")){
        var v_ic_seg = 1;
    }else{
        var v_ic_seg = "";
    }    
    if($('#ic_ter').is(":checked")){
        var v_ic_ter = 1;
    }else{
        var v_ic_ter = "";
    }
    if($('#ic_qua').is(":checked")){
        var v_ic_qua = 1;
    }else{
        var v_ic_qua = "";
    }
    if($('#ic_qui').is(":checked")){
        var v_ic_qui = 1;
    }else{
        var v_ic_qui = "";
    }
    if($('#ic_sex').is(":checked")){
        var v_ic_sex = 1;
    }else{
        var v_ic_sex = "";
    }
    if($('#ic_sab').is(":checked")){
        var v_ic_sab = 1;
    }else{
        var v_ic_sab = "";
    }
    var v_hr_ini_dom = $("#hr_ini_dom").val(); 
    var v_hr_fim_dom = $("#hr_fim_dom").val(); 
    var v_hr_ini_seg = $("#hr_ini_seg").val(); 
    var v_hr_fim_seg = $("#hr_fim_seg").val(); 
    var v_hr_ini_ter = $("#hr_ini_ter").val(); 
    var v_hr_fim_ter = $("#hr_fim_ter").val();
    var v_hr_ini_qua = $("#hr_ini_qua").val(); 
    var v_hr_fim_qua = $("#hr_fim_qua").val(); 
    var v_hr_ini_qui = $("#hr_ini_qui").val(); 
    var v_hr_fim_qui = $("#hr_fim_qui").val();
    var v_hr_ini_sex = $("#hr_ini_sex").val(); 
    var v_hr_fim_sex = $("#hr_fim_sex").val(); 
    var v_hr_ini_sab = $("#hr_ini_sab").val(); 
    var v_hr_fim_sab = $("#hr_fim_sab").val(); 
    var v_obs = $("#obs").val();   
    
    var v_pk = $("#agenda_colaborador_terafas_pk").val();

    var objParametros = {
        "pk": v_pk,
        "ds_tarefa": (v_ds_tarefa),
        "leads_pk": (v_leads_pk),
        "tarefas_local_pk": (v_tarefas_local_pk),
        "tarefas_area_pk": (v_tarefas_area_pk),
        "colaborador_pk": (v_colaborador_pk),
        "tarefas_tipos_servicos_pk": (v_tarefas_tipos_servicos_pk),
        "ic_dom": (v_ic_dom),   
        "ic_seg": (v_ic_seg),
        "ic_ter": (v_ic_ter),
        "ic_qua": (v_ic_qua),
        "ic_qui": (v_ic_qui),
        "ic_sex": (v_ic_sex),
        "ic_sab": (v_ic_sab),
        "hr_ini_dom": v_hr_ini_dom,
        "hr_fim_dom": v_hr_fim_dom,
        "hr_ini_seg": v_hr_ini_seg,
        "hr_fim_seg": v_hr_fim_seg,
        "hr_ini_ter": v_hr_ini_ter,
        "hr_fim_ter": v_hr_fim_ter,
        "hr_ini_qua": v_hr_ini_qua,
        "hr_fim_qua": v_hr_fim_qua,
        "hr_ini_qui": v_hr_ini_qui,
        "hr_fim_qui": v_hr_fim_qui,
        "hr_ini_sex": v_hr_ini_sex,
        "hr_fim_sex": v_hr_fim_sex,
        "hr_ini_sab": v_hr_ini_sab,
        "hr_fim_sab": v_hr_fim_sab,
        "obs": (v_obs)  
    };    

    var arrEnviar = carregarController("agenda_colaborador_tarefa", "salvarTarefa", objParametros);           
    //NewWindow(v_last_url);
    if (arrEnviar.result == 'success'){
        // Reload datable
        alert('Tarefa registrada com sucesso!');
        
      
        $("#agenda_colaborador_terafas_pk").val(arrEnviar.data[0]['pk']);
        
        fcLimpaForm();
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcLimpaForm(){ 
    
    $("#ds_tarefa").val('');
    if($("#agenda_colaborador_terafas_pk").val()!=''){
        $( "#leads_pk" ).prop( "disabled", true );       
    }    
    
    $("#tarefas_local_pk").val('');
    $("#tarefas_area_pk").val('');
    $("#colaborador_pk").val('');
    $("#tarefas_tipos_servicos_pk").val('');
    
    $("#ic_seg").prop("checked", false);
    $("#ic_seg").prop("checked", false);
    $("#ic_ter").prop("checked", false);
    $("#ic_qua").prop("checked", false);
    $("#ic_qui").prop("checked", false);
    $("#ic_sex").prop("checked", false);
    $("#ic_sab").prop("checked", false);
    $("#ic_dom").prop("checked", false);
    
    $("#hr_ini_dom").val(''); 
    $("#hr_fim_dom").val(''); 
    $("#hr_ini_seg").val(''); 
    $("#hr_fim_seg").val(''); 
    $("#hr_ini_ter").val(''); 
    $("#hr_fim_ter").val('');
    $("#hr_ini_qua").val(''); 
    $("#hr_fim_qua").val(''); 
    $("#hr_ini_qui").val(''); 
    $("#hr_fim_qui").val('');
    $("#hr_ini_sex").val(''); 
    $("#hr_fim_sex").val(''); 
    $("#hr_ini_sab").val(''); 
    $("#hr_fim_sab").val(''); 
    $("#obs").val('');    
    $("#tblResultado").dataTable().fnDestroy();
    fcCarregarGridTarefasItens();
    
    return false;
}


function fcCancelar(){
    sendPost("tarefas_res_form.php", {token: token});
}

function fcCarregar(){
    if(pk > 0){
        var objParametros = {
            "pk": pk
        };       
        
        var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarPk", objParametros);

        if (arrCarregar.result == 'success'){
           
            $("#ds_tarefa").val(arrCarregar.data[0]['ds_tarefa']);
            
            $("select[id='leads_pk']").val(arrCarregar.data[0]['leads_pk']);            
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);
            $("#tarefas_local_pk").val(arrCarregar.data[0]['tarefas_local_pk']);
            $("#dt_execucao").val(arrCarregar.data[0]['dt_execucao']);

            $("#obs_tarefa").val(arrCarregar.data[0]['obs_tarefa']);


        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}
//combos
function fcCarregarLeads(){    
    var objParametros = {
        "pk": ""
    };          
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}
function fcCarregarTarefasTipoServicos(){  

    var objParametros = {

    };   
    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefasTipoServicos", objParametros);
    
    carregarComboAjax($("#tarefas_tipos_servicos_pk"), arrCarregar, " ", "pk", "ds_tarefa_tipo_servico");     

}
function fcCarregarColaborador(){   
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };          
    var arrCarregar = carregarController("colaborador", "listarColaboradorLead", objParametros); 
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "pk", "ds_colaborador");    
}
function fcCarregarTarfaLocal(){         
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };   
    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefaLocal", objParametros);
    
    carregarComboAjax($("#tarefas_local_pk"), arrCarregar, " ", "pk", "ds_local");     
}

function fcCarregarTarfaArea(){    

    var objParametros = {
        "tarefas_local_pk": $("#tarefas_local_pk").val()
    };   

    var arrCarregar = carregarController("agenda_colaborador_tarefa", "listarTarefaArea", objParametros);

    carregarComboAjax($("#tarefas_area_pk"), arrCarregar, " ", "pk", "ds_area");     
}


function fcCarregarGridTarefasItens(){ 

   var agenda_colaborador_terafas_pk = $("#agenda_colaborador_terafas_pk").val();

   var objParametros = {
       "agenda_colaborador_tarefa_pk":agenda_colaborador_terafas_pk
    };     
    
    var v_url = montarUrlController("agenda_colaborador_tarefa_itens", "listarPkTarefas", objParametros);
    //NewWindow(v_last_url);
    
    //Trata a tabela
    tblResultado = $('#tblResultado').DataTable({
        "scrollX": false,
        "ajax": {"url": v_url, "type": "POST"},
        "responsive": false,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": "<a class='function_print'><span><img width=20 height=20 src='../img/QrCode.png'></span></a>&nbsp;&nbsp;<a class='function_delete'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            },
           {"targets": -2, "data": "obs"},
           {"targets": -3, "data": "ds_dias_hr"}, 
           {"targets": -4, "data": "tarefas_tipos_servicos_pk",visible:false},
           {"targets": -5, "data": "ds_tarefa_tipo_servico"},            
           {"targets": -6, "data": "colaborador_pk",visible:false},
           {"targets": -7, "data": "ds_colaborador"}, 
           {"targets": -8, "data": "tarefas_area_pk",visible:false},
           {"targets": -9, "data": "ds_area"},
           {"targets": -10, "data": "tarefas_local_pk",visible:false},
           {"targets": -11, "data": "ds_local"},
           {"targets": -12, "data": "leads_pk",visible:false},
           {"targets": -13, "data": "ds_lead"},
           {"targets": -14, "data": "ds_tarefa"},
           {"targets": -15, "data": "pk"}
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
        fcExcluir(data['pk']);
    } );  
    
    
    $('#tblResultado tbody').on('click', '.function_print', function () {
        var data;
        if(tblResultado.row( $(this).parents('li') ).data()){
            data = tblResultado.row( $(this).parents('li') ).data();
        }
        else if(tblResultado.row( $(this).parents('tr') ).data()){
            data = tblResultado.row( $(this).parents('tr') ).data();
        }
        fcPrintQrcode(data['pk']);
    } );   
    
}
function fcExcluir(agenda_colaborador_tarefa_itens_pk){
  
   var objParametros = {
       "pk":agenda_colaborador_tarefa_itens_pk
    };     
    
    var v_url = montarUrlController("agenda_colaborador_tarefa_itens", "excluir", objParametros);
    
    tblResultado.row($(this).parents('tr')).remove().draw();
    
    return false;
}


$(document).ready(function(){
    
    //carregar combos e mascaras
    fcCarregarLeads();  
    fcCarregarTarefasTipoServicos();
    fcCarregarColaborador();

    $('#dt_execucao').datepicker({defaultDate: "getDate()",
        dateFormat: 'dd/mm/yyyy',
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true,
        todayBtn: "linked",
        minDate: 0
    }).datepicker("setDate",  ); 
    $("#dt_execucao").keypress(function(){
       mascara(this,mdata);
    });  

    $("#leads_pk").change(function(){
        $(".chzn-select").chosen('destroy');
        fcCarregarTarfaLocal();
        $(".chzn-select").chosen({allow_single_deselect: true}); 

        $(".chzn-select").chosen('destroy');
        fcCarregarColaborador();        
        $(".chzn-select").chosen({allow_single_deselect: true});        
    });
    
    $("#tarefas_local_pk").change(function(){

        $(".chzn-select").chosen('destroy');
        fcCarregarTarfaArea();
        $(".chzn-select").chosen({allow_single_deselect: true});          
       
    });
    
    $("#ic_dom").change(function(){        
        if($('#ic_dom').is(":checked")){           
            $("#hr_ini_dom").prop( "disabled",false) 
            $("#hr_fim_dom").prop( "disabled",false) 
        }else{
            $("#hr_ini_dom").prop( "disabled",true)
            $("#hr_fim_dom").prop( "disabled",true)
            $("#hr_ini_dom").val('');
            $("#hr_fim_dom").val('');
        }
    });   
    
    $("#ic_seg").change(function(){        
        if($('#ic_seg').is(":checked")){           
            $("#hr_ini_seg").prop( "disabled",false) 
            $("#hr_fim_seg").prop( "disabled",false) 
        }else{
            $("#hr_ini_seg").prop( "disabled",true)
            $("#hr_fim_seg").prop( "disabled",true)
            $("#hr_ini_seg").val('');
            $("#hr_fim_seg").val('');
        }
    });  
    
    $("#ic_ter").change(function(){        
        if($('#ic_ter').is(":checked")){           
            $("#hr_ini_ter").prop( "disabled",false) 
            $("#hr_fim_ter").prop( "disabled",false) 
        }else{
            $("#hr_ini_ter").prop( "disabled",true)
            $("#hr_fim_ter").prop( "disabled",true)
            $("#hr_ini_ter").val('');
            $("#hr_fim_ter").val('');
        }
    }); 

    $("#ic_qua").change(function(){        
        if($('#ic_qua').is(":checked")){           
            $("#hr_ini_qua").prop( "disabled",false) 
            $("#hr_fim_qua").prop( "disabled",false) 
        }else{
            $("#hr_ini_qua").prop( "disabled",true)
            $("#hr_fim_qua").prop( "disabled",true)
            $("#hr_ini_qua").val('');
            $("#hr_fim_qua").val('');
        }
    }); 
    
    $("#ic_qui").change(function(){        
        if($('#ic_qui').is(":checked")){           
            $("#hr_ini_qui").prop( "disabled",false) 
            $("#hr_fim_qui").prop( "disabled",false) 
        }else{
            $("#hr_ini_qui").prop( "disabled",true)
            $("#hr_fim_qui").prop( "disabled",true)
            $("#hr_ini_qui").val('');
            $("#hr_fim_qui").val('');
        }
    }); 
    
    $("#ic_sex").change(function(){        
        if($('#ic_sex').is(":checked")){           
            $("#hr_ini_sex").prop( "disabled",false) 
            $("#hr_fim_sex").prop( "disabled",false) 
        }else{
            $("#hr_ini_sex").prop( "disabled",true)
            $("#hr_fim_sex").prop( "disabled",true)
            $("#hr_ini_sex").val('');
            $("#hr_fim_sex").val('');
        }
    }); 
    
    $("#ic_sab").change(function(){        
        if($('#ic_sab').is(":checked")){           
            $("#hr_ini_sab").prop( "disabled",false) 
            $("#hr_fim_sab").prop( "disabled",false) 
        }else{
            $("#hr_ini_sab").prop( "disabled",true)
            $("#hr_fim_sab").prop( "disabled",true)
            $("#hr_ini_sab").val('');
            $("#hr_fim_sab").val('');
        }
    }); 
    
    $("#hr_ini_dom").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_seg").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_ter").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_qua").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_qui").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_sex").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_ini_sab").keypress(function(){
       mascara(this,horamask);
    });    
    $("#hr_fim_dom").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_seg").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_ter").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_qua").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_qui").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_sex").keypress(function(){
       mascara(this,horamask);
    });
    $("#hr_fim_sab").keypress(function(){
       mascara(this,horamask);
    });
    $(".chzn-select").chosen({allow_single_deselect: true});

    fcCarregarGridTarefasItens();
      
    //Atribui os eventos
    $(document).on('click', '#cmdCancelar', fcCancelar); 
    
    $(document).on('click', '#cmdIncluirNovaTarefa', fcEnviar);

    fcCarregar();
 });
