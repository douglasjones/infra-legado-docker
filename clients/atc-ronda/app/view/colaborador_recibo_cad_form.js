function fcEnviar(){
    
    if($("#tipos_recibo_pk").val()==''){
        alert('Selecione o tipo de recibo!');
        return false;
    }
    
    if($("#colaborador_cadastrado").val()==''){
        alert('Selecione o Tipo Colaborador!');
        return false;
    }
    if($("#colaborador_cadastrado").val()==1){
        if($("#colaborador_pk").val()==''){
            alert('Selecione um Colaborador da lista!');
            return false;
        }   
    }else{
        if($("#ds_nome_colaborador").val()==''){
            alert('Informe o nome do Colaborador para cadastro!');
            return false;
        }
        if($("#ds_cpf").val()==''){
            alert('Informe o CPF do Colaborador para cadastro!');
            return false;
        }
    }
    if($("#mes_ini_pk").val()==''){
        alert('Selecione o Mês de inicio!');
        return false;
    }
    if($("#ano_ini_pk").val()==''){
        alert('Selecione o Ano de inicio!');
        
    }        

   var  data = tblResultado.rows().data();     
     
   if(data.length==''){
       alert('Inclua os dias do Recibo');
       return false;
   }  
          

    var colaborador_pk = "";
    //Cadastrar Colaborador
    if($("#colaborador_cadastrado").val()==2){
        var colaborador_pk = "";
        var dt_nacimento = "00/00/0000";
        var objParametros0 = {
            
            "ds_colaborador":colaborador_pk, 
            "ds_colaborador": $("#ds_nome_colaborador").val(),     
            "ds_cpf":$("#ds_cpf").val(),
            "dt_nascimento":dt_nacimento,
            "ic_status":"1"
        };     

        var arrEnviar0 = carregarController("colaborador", "salvar", objParametros0); 
      
        
        colaborador_pk = arrEnviar0.data[0]['pk'];
    }else{
        colaborador_pk = $("#colaborador_pk").val();
    }

    var v_colaborador_pk = colaborador_pk;         
    var v_vl_total = $("#vl_total_recibo").val();
    var v_tipos_recibos_pk = $("#tipos_recibo_pk").val();
    var v_mes_ini_pk = $("#mes_ini_pk").val();
    var v_ano_ini_pk = $("#ano_ini_pk").val();
    var v_mes_fim_pk = $("#mes_fim_pk").val();
    var v_ano_fim_pk = $("#ano_fim_pk").val();
    var v_colaborador_recibo_pk = colaborador_recibo_pk;
    
    
    var objParametros = {
        "pk":v_colaborador_recibo_pk,
        "colaborador_pk": (v_colaborador_pk),
        "vl_total": (v_vl_total),
        "tipos_recibos_pk": (v_tipos_recibos_pk),
        "mes_ini_pk": (v_mes_ini_pk),
        "ano_ini_pk": (v_ano_ini_pk),
        "mes_fim_pk": (v_mes_fim_pk),
        "ano_fim_pk": (v_ano_fim_pk)        
    };    
    
    var arrEnviar = carregarController("colaborador_recibo", "salvar", objParametros);           

     
    if (arrEnviar.result == 'success'){        
        var v_li = 0;
        
        var v_colaborador_recibo_pk =  arrEnviar.data[0]['pk']
        
        var objParametros00 = { 
                "colaboradores_recibos_pk":v_colaborador_recibo_pk 
        };    
        var arrEnviar = carregarController("colaborador_recibo", "excluirItens", objParametros00);    
          
        var  total_li = tblResultado.rows().data();    

        for(i=0; i < total_li.length ;i++){    
        
            var v_dt_registro = $("#dt_li_"+i).val(); 
            var v_ds_dia_semana = $("#dia_semana_li_"+v_li).val();
            var v_leads_pk = $("#leads_pk_"+v_li).val();  
            var v_produtos_servicos_pk = $("#produtos_servicos_pk_"+v_li).val();
            
            var v_hr_ini_expediente = $("#hr_ini_expediente_"+v_li).val();
            var v_hr_fim_expediente = $("#hr_fim_expediente_"+v_li).val();          
            var v_ds_total_hr = $("#ds_total_hr_"+v_li).val();           
            var v_vl_unitario = $("#vl_unitario_"+v_li).val();           
            var v_colaboradores_recibos_pk = v_colaborador_recibo_pk;  
            
            var objParametros1 = {
                "dt_registro":v_dt_registro,
                "ds_dia_semana": (v_ds_dia_semana),
                "leads_pk": v_leads_pk,
                "hr_ini_expediente": (v_hr_ini_expediente),  
                "hr_fim_expediente": (v_hr_fim_expediente), 
                "ds_total_hr":  moeda2float((v_ds_total_hr)), 
                "vl_unitario":  moeda2float((v_vl_unitario)), 
                "colaboradores_recibos_pk": (v_colaboradores_recibos_pk),
                "produtos_servicos_pk":v_produtos_servicos_pk
            };    

            var arrEnviar = carregarController("colaborador_recibo", "salvarItens", objParametros1);    
                 
            v_li ++
        }

        // Reload datable
        alert(arrEnviar.message);
        sendPost("colaborador_recibo_print_form.php", {token: token,colaborador_recibo_pk: v_colaborador_recibo_pk });
        //sendPost("colaborador_recibo_res_form.php", {token: token});
    }
    else{
        alert('Falhou a requisição para salvar o registro');
    }
}

function fcCancelar(){

    sendPost("colaborador_recibo_res_form.php", {token: token});
}

function fcCarregar(){
    if(colaborador_recibo_pk > 0){
        var objParametros = {
               "colaborador_recibo_pk": colaborador_recibo_pk
        };

        var arrCarregar = carregarController("colaborador_recibo", "listarDadosImpressao", objParametros);   
        
        if (arrCarregar.result == 'success'){        
            $("#tipos_recibo_pk").val(arrCarregar.data[0]['tipos_recibos_pk']);
            $('#tipos_recibo_pk').attr('disabled', 'disabled');
            $("#colaborador_cadastrado").val(1);
            $('#colaborador_cadastrado').attr('disabled', 'disabled');
            $("#div_cadastrado").show();
            $("#colaborador_pk").val(arrCarregar.data[0]['colaborador_pk']);
            $('#colaborador_pk').attr('disabled', 'disabled');
            $("#div_form_ft").show();
            
            $("#mes_ini_pk").val(arrCarregar.data[0]['mes_ini_pk']);
            $("#ano_ini_pk").val(arrCarregar.data[0]['ano_ini_pk']);
            $("#mes_fim_pk").val(arrCarregar.data[0]['mes_fim_pk']);
            $("#ano_fim_pk").val(arrCarregar.data[0]['ano_fim_pk']);
            $("#div_total").html(arrCarregar.data[0]['vl_total']);
            $("#vl_total_recibo").val(arrCarregar.data[0]['vl_total']);
              
            fclistaDias();

            for(x=0; x < arrCarregar.data[0].DadosReciboItens.length ;x++){ 
                 var v_dia_registro = arrCarregar.data[0].DadosReciboItens[x].dia_registro;
                 var v_mes_registro = arrCarregar.data[0].DadosReciboItens[x].mes_registro;
                 var v_ano_registro = arrCarregar.data[0].DadosReciboItens[x].ano_registro;
                 
                 if(arrCarregar.data[0]['mes_ini_pk'] == v_mes_registro ){
                    for(i=0; i < 31 ;i++){
                       
                        if($("#dia_ini_pk_"+i).val() == v_dia_registro){
                           $("#dia_ini_pk_"+i).prop("checked", true);
                           var v_leads_pk = arrCarregar.data[0].DadosReciboItens[x].leads_pk
                           var v_produtos_servicos_pk = arrCarregar.data[0].DadosReciboItens[x].produtos_servicos_pk
                           fcIncluirLinha(i,1,v_leads_pk,v_produtos_servicos_pk) 
                           
                        }   
                    }
                 }                         
                 if(arrCarregar.data[0]['mes_fim_pk'] == v_mes_registro){
                    for(j=0; j < 31 ;j++){
                        if($("#dia_fim_pk_"+j).val() == v_dia_registro){
                           $("#dia_fim_pk_"+j).prop("checked", true);
                           var v_leads_pk = arrCarregar.data[0].DadosReciboItens[x].leads_pk
                           var v_produtos_servicos_pk = arrCarregar.data[0].DadosReciboItens[x].produtos_servicos_pk
                           fcIncluirLinha(j,2,v_leads_pk,v_produtos_servicos_pk)
                        }   
                    }
                 }  
            }          
                     
                     
                     
           
            var data = tblResultado.rows().data();        
            
            for(h=0; h < data.length ;h++){ 
                for(x=0; x < arrCarregar.data[0].DadosReciboItens.length ;x++){ 
                     var v_dt_registro = arrCarregar.data[0].DadosReciboItens[x].dt_registro;
                     if($("#dt_li_"+h).val()==v_dt_registro){     
                         
                        //$("#leads_pk_"+h+" option:selected").val(arrCarregar.data[0].DadosReciboItens[x].leads_pk);
                        //$("#produtos_servicos_pk_"+h).val(arrCarregar.data[0].DadosReciboItens[x].produtos_servicos_pk);
                        $("#hr_ini_expediente_"+h).val(arrCarregar.data[0].DadosReciboItens[x].hr_ini_expediente);
                        $("#hr_fim_expediente_"+h).val(arrCarregar.data[0].DadosReciboItens[x].hr_fim_expediente);
                        $("#ds_total_hr_"+h).val(arrCarregar.data[0].DadosReciboItens[x].ds_total_hr); 
                        $("#vl_unitario_"+h).val(arrCarregar.data[0].DadosReciboItens[x].vl_unitario);                        
                     }  
                }
            }
  
        }else{
            alert('Falhar ao carregar o registro');
        }
    }
}


function fcliberaTipoFormulario(){
 
    var v_tipo_recibo = $("#tipos_recibo_pk option:selected").val();
    
    if(v_tipo_recibo==1){
        $("#div_form_ft").show();
    }else if (v_tipo_recibo==''){
        $("#div_form_ft").hide();
    }
}

function fclimparDadosForm(){
    $("#tipos_recibo_pk option:selected").val('');
    //$("#leads_pk option:selected").val('');
    //$("#colaborador_pk option:selected").val('');
    $("#ano_pk option:selected ").val('');
    $("#mes_pk option:selected").val('')
}

function fclistarTiposRecibos(){    
    var objParametros = {
        "tipos_recibo_pk": $("#tipos_recibo_pk").val()
    };
    var arrCarregar = carregarController("colaborador_recibo", "listarTiposRecibos", objParametros);   
    carregarComboAjax($("#tipos_recibo_pk"), arrCarregar, " ", "pk", "ds_recibo");
}

function fcCarregarColaborador(){
    var objParametros = {
        "leads_pk": $("#leads_pk").val()
    };          
    var arrCarregar = carregarController("colaborador", "listarColaboradoresPK", objParametros); 
    //NewWindow(v_last_url)
    carregarComboAjax($("#colaborador_pk"), arrCarregar, " ", "colaborador_pk", "ds_colaborador");    
}

function fcCarregarLeads(){
    var objParametros = {
        "pk": ""
    };   
    var arrCarregar = carregarController("lead", "listarTodos", objParametros); 
    carregarComboAjax($("#leads_pk"), arrCarregar, " ", "pk", "ds_lead");    
}

function fclistaDias(){
    var vhtml = "";
    var semana = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];
    
    var  data = tblResultado.rows().data();     
     
    for(i = 1; i< data.length; i++){
        tblResultado.row(i).remove().draw();
    }
    
    if($("#ano_ini_pk option:selected").val()!='' && $("#mes_ini_pk option:selected").val()!=''){
        var udm = (new Date($("#ano_ini_pk").val(),parseInt($("#mes_ini_pk").val()),0,0,0,0)).getDate();
        var v_dias =udm+1;
        vhtml+="<table width='1300px' border=0>";
        vhtml+=     "<tr>";  
            for(i=1; i < v_dias  ;i++){
                if(i<=9){                    
                    var v_dia_inicio = '0'+i;
                }else{                   
                    var v_dia_inicio = i; 
                }            
                vhtml+=     "<td width='85' align='center'>";
                vhtml+=         v_dia_inicio+"-<input type='checkbox' id='dia_ini_pk_"+i+"' value="+v_dia_inicio+" onclick='fcIncluirLinha("+i+",1)'> ";
                vhtml+=     "</td>"; 
            }       
        vhtml+=     "</tr>";
        vhtml+="</table>";
       $("#div_dias_inicio").html(vhtml)
    }else{
        alert('Informa o Mês e Ano de inicio do período !');
        return false;
    }
    var vhtml = "";
    if($("#ano_fim_pk option:selected").val()!='' && $("#mes_fim_pk option:selected").val()!=''){
      
        var udm_fim = (new Date($("#ano_fim_pk").val(),parseInt($("#mes_fim_pk").val()),0,0,0,0)).getDate();
        var v_dias_fim =udm_fim+1;
        vhtml+="<table width='1300px' border=0>";
        vhtml+=     "<tr>";  
            for(j=1; j < v_dias_fim ;j++){
                if(j<=9){                    
                    var v_dia_fim = '0'+j;
                }else{                   
                    var v_dia_fim = j; 
                }   
                vhtml+=     "<td width='80' align='center'>";
                vhtml+=         v_dia_fim+"-<input type='checkbox' id='dia_fim_pk_"+j+"' value="+v_dia_fim+" onclick='fcIncluirLinha("+j+",2)'> ";
                vhtml+=     "</td>"; 
            }       
        vhtml+=     "</tr>";
        vhtml+="</table>";
       $("#div_dias_fim").html(vhtml)
    }
}

function fcIncluirLinha(v_tl,id_p,v_lead_pk,v_produtos_servicos_pk){
  
    var data = tblResultado.rows().data(); 
  
    var v_li = "";
    var v_li_print = 1;
    if(data.length==0){
        v_li = 0;       
    }else{
        v_li = data.length ;
        v_li_print = data.length+1;
    }
    
    var semana = ["DOM", "SEG", "TER", "QUA", "QUI", "SEX", "SAB"];  
    if(id_p==1){
        if($("#dia_ini_pk_"+v_tl).prop("checked") == true){
            var v_li_dia = $("#dia_ini_pk_"+v_tl).val()+"/"+$("#mes_ini_pk").val()+"/"+$("#ano_ini_pk").val(); 

            var v_mes_ini = "";
            if($("#mes_ini_pk").val()==1){
                v_mes_ini = 0;
            }else{
               v_mes_ini = $("#mes_ini_pk").val()-1 
            }
            var v_li_dia_semana = semana[new Date($("#ano_ini_pk").val(),v_mes_ini,$("#dia_ini_pk_"+v_tl).val(),0,0,0).getDay()];
        }else{
           
            return false;
        }    

    }else if(id_p==2){
        if($("#dia_fim_pk_"+v_tl).prop("checked") == true){
            var v_li_dia = $("#dia_fim_pk_"+v_tl).val()+"/"+$("#mes_fim_pk").val()+"/"+$("#ano_fim_pk").val(); 
            var v_mes_fim = "";
            if($("#mes_fim_pk").val()==1){
                v_mes_fim = 0;
            }else{
               v_mes_fim = $("#mes_fim_pk").val()-1 
            }
            var v_li_dia_semana = semana[new Date($("#ano_fim_pk").val(),v_mes_fim,$("#dia_fim_pk_"+v_tl).val(),0,0,0).getDay()];
        }else{
            return false;
        }
    }
    
    var strComboLeads = "";
        var url = '../controller/lead.controller.php?job=listarTodos&token='+token;

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){        
        if (output.result == 'success'){             
            strComboLeads+="<select class='form-control form-control-sm' id='leads_pk_"+v_li+"'>"; 
            strComboLeads+="<option value=''></option>"; 
            for(b=0;b<output.data.length;b++){ 
                if(v_lead_pk!=""){
                    if(v_lead_pk==output.data[b]['pk'] ){
                        strComboLeads+="<option value='"+output.data[b]['pk']+"' selected>"+output.data[b]['ds_lead']+"</option>";
                    }else{
                        strComboLeads+="<option value='"+output.data[b]['pk']+"'>"+output.data[b]['ds_lead']+"</option>";
                    }
                }else{
                    strComboLeads+="<option value='"+output.data[b]['pk']+"'>"+output.data[b]['ds_lead']+"</option>";
                }
                 
            }
            strComboLeads+="</select>"; 
            $("#div_lead_recibo_"+v_li).html(strComboLeads)
        }
    });
    request.fail(function(jqXHR, textStatus){
        
    }); 
    
    
    var strComboFuncao= "";
        var url = '../controller/produto_servico.controller.php?job=listarTodos&token='+token;

    var request = $.ajax({
        url:          url,
        type:         'post',
        cache:        false,
        dataType:     'json',
        contentType:  'application/json; charset=utf-8'
    });
    request.done(function(output){        
        if (output.result == 'success'){             
            strComboFuncao+="<select class='form-control form-control-sm' id='produtos_servicos_pk_"+v_li+"'>"; 
            strComboFuncao+="<option value=''></option>"; 
            for(c=0;c<output.data.length;c++){ 
                if(v_produtos_servicos_pk!=""){
                    if(v_produtos_servicos_pk==output.data[c]['pk']){
                        strComboFuncao+="<option value='"+output.data[c]['pk']+"' selected>"+output.data[c]['ds_produto_servico']+"</option>"; 
                    }else{
                        strComboFuncao+="<option value='"+output.data[c]['pk']+"'>"+output.data[c]['ds_produto_servico']+"</option>"; 
                    }                          
                    
                }else{
                    strComboFuncao+="<option value='"+output.data[c]['pk']+"'>"+output.data[c]['ds_produto_servico']+"</option>"; 
                }    
            }
            strComboFuncao+="</select>"; 
            $("#div_funcao_"+v_li).html(strComboFuncao)
        }
    });
    request.fail(function(jqXHR, textStatus){
        
    });     
    tblResultado.row.add(
             [v_li_print,
             v_li_dia+"<input type='hidden' id='dt_li_"+v_li+"' value='"+v_li_dia+"'>",
             v_li_dia_semana+"<input type='hidden' id='dia_semana_li_"+v_li+"' value='"+v_li_dia_semana+"'>",
             "<div id='div_lead_recibo_"+v_li+"'></div>",
             "<div id='div_funcao_"+v_li+"'></div>",
             "<input type='text' id='hr_ini_expediente_"+v_li+"' size='5' value='' onchange='fccalculaTotalHoras("+v_li+")' onkeypress='mascara(this,horamask)' >",
             "<input type='text' id='hr_fim_expediente_"+v_li+"' size='5' value='' onchange='fccalculaTotalHoras("+v_li+")' onkeypress='mascara(this,horamask)'>",
             "<input type='text' id='ds_total_hr_"+v_li+"' onkeypress='mascara(this,soNumeros)'  size='3' value=''>",
             "<input type='text' id='vl_unitario_"+v_li+"' size='5' value='' onchange='fcSomaTotalRecibo()' onkeypress='mascara(this,moeda)'>",
             "<a onclick='fcExcluirLinha("+v_li+")'><span><img width=16 height=16 src='../img/excluir.png'></span></a>"
            ]
    ).draw( false );
    //$(".function_delete").on("click",fcExcluirLinha);
}

function fcExcluirLinha(id){  
   
   fcSomaTotalRecibo(id);
   tblResultado.row(id).remove().draw(); 
   return false;
}



function fccalculaTotalHoras(v_id){
    
    if($("#hr_ini_expediente_"+v_id).val()!='' || $("#hr_fim_expediente_"+v_id).val()!=''){
        const segent = hmToMins($("#hr_ini_expediente_"+v_id).val());
        const segsai = hmToMins($("#hr_fim_expediente_"+v_id).val());

        const diff = segsai - segent;
        if (isNaN(diff)) return;
        const hhmm = [
            Math.floor(diff / 60), 
            Math.round(diff % 60)
        ].map(nr => `00${nr}`.slice(-2)).join(':');

        $("#ds_total_hr_"+v_id).val(hhmm); 
    }
}

function hmToMins(str) {
    const [hh, mm] = str.split(':').map(nr => Number(nr) || 0);
    return hh * 60 + mm;
}

function fcSomaTotalRecibo(v_id){
   
   var id_li  = new Number(v_id);

   var data = tblResultado.rows().data(); 

   var vl = 0;
   
   for(i=0; i < 35 ;i++){

        if(i!=id_li){   
           
            if($("#vl_unitario_"+i).val()){
  
                if($("#vl_unitario_"+i).val()!=''){
           
                    var linha = (new Number($("#vl_unitario_"+i).val().replace(',','.')))              
                    vl = (vl + (linha))   
                }  
            } 
        }
   
   }


 

   $("#vl_total_recibo").val(vl) ;  

    
   $("#div_total").html($("#vl_total_recibo").val()); 
}




function fcSelecionaColaborador(){
    var v_colaborador_cadastrado= $("#colaborador_cadastrado option:selected").val();
    
    if(v_colaborador_cadastrado==1){
        $("#div_cadastrado").show();
        $("#div_nao_cadastrado").hide();
    }else if (v_colaborador_cadastrado==2){
        $("#div_cadastrado").hide();
        $("#div_nao_cadastrado").show();
    }
}

function fcCancelar(){
    sendPost("colaborador_recibo_res_form.php", {token: token});
}

function fcVerificarCNPJ(){
    var ds_cpf_cnpj = $("#ds_cpf").val();
    if(ds_cpf_cnpj.length == 14){
         var objParametros = {
            "ds_cpf": $("#ds_cpf").val()
        };

        var arrCarregar = carregarController("colaborador", "verificarCPF", objParametros);

        if (arrCarregar.result == 'success'){

            if(arrCarregar.data.length > 0){
                alert("Já existe um Colaborador com esse CPF");
                $("#ds_colaborador").val("");
                $("#generos_pk").val("");
                $("#ds_cel").val("");
                $("#ds_cel2").val("");
                $("#dt_nascimento").val("");
                $("#ds_cel3").val("");
                $("#ds_rg").val("");
                $("#ds_cpf").val("");
                $("#ic_whatsapp").val("");
                $("#ds_email").val("");
            }
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    }
}


function fcFormatarGrid(){        
    tblResultado = $("#tblResultado").DataTable({
        "scrollX": false,
        "responsive": true,
        "searching": false,
        "paging": false,
        "bFilter": false,
        "bInfo": false,
        "columnDefs" : [{
            orderable: false,
            targets: [1,2,3,4,5,6,7,8]
        }],        
        "language":{
            "url": "../inc/js/datatables/pt_br.php",
            "type": "GET"
            }            
    });    
    return false;
    
}




$(document).ready(function(){
    
    fclimparDadosForm()
    fclistarTiposRecibos();
    fcCarregarColaborador();    
    fcCarregarLeads()
    $("#colaborador_cadastrado").val('');
    $(".chzn-select").chosen({allow_single_deselect: true});
    
    $("#ds_cpf").keypress(function(){
       chama_mascara(this);
    });
    
    $("#ds_cpf").change(function(){
        fcVerificarCNPJ();
    });
        
    $(document).on('click', '#tipos_recibo_pk', fcliberaTipoFormulario); 
    $(document).on('click', '#cmdBuscarMeses', fclistaDias);    
    //$(document).on('click', '#cmdDadosRecibo', fclinhasRecibo);                
    $(document).on('click', '#cmdCancelar', fcCancelar);       
    $(document).on('click', '#cmdEnviar', fcEnviar);      
    $(document).on('change', '#colaborador_cadastrado', fcSelecionaColaborador); 
    
    fcFormatarGrid()
    
    //carregarListaCombo();

    //Verifica se o registro é para alteracao e puxa os dados.
    
    fcCarregar();
 });
