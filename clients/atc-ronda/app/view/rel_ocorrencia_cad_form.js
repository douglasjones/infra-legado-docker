
function fcCarregarGrid(){  
    
    
        
        var objParametros = {
            "ds_lead":ds_lead,
            "tipos_ocorrencias_pk": tipos_ocorrencias_pk,
            "ic_status": ic_status,
            "usuario_cadastro_pk": usuario_cadastro_pk,
            "dt_cadastro": dt_cadastro,
            "dt_cadastro_fim": dt_cadastro_fim,
            "usuario_agendado_para": usuario_agendado_para
        };         

        var arrCarregar = carregarController("ocorrencia", "listarDataTableGrid", objParametros); 
      
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length >0){
                var Lead = "";
                var dt_cad_oc = "";
                var tipo_oc = "";
                var ds_oc = "";
                var usuario_cad = "";
                var dt_fechamento_oc = "";
                var agendado_para = "";
                var dt_retorno = "";
                var ds_retorno = "";
                var dt_fechamento_retorno = "";
                var ds_status = "";
                
                var strRetorno = "";
                
                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                strRetorno+="<tbody>";
                strRetorno+="<tr>";
                strRetorno+="<th width='10%'>Lead</th><th width='10%'>Dt Cad OC</th>\n\
                <th width='10%'>Tipo OC</th>\n\
                <th width='10%'>Descr OC</th>\n\
                <th width='10%'>Usuário Cad</th>\n\
                <th width='10%'>Dt Fech OC</th>\n\
                <th width='10%'>Agendado Para</th>\n\
                <th width='10%'>Dt Retorno</th>\n\
                <th width='10%'>Descr Retorno</th>\n\
                <th width='10%'>Dt Fech Retorno</th>\n\
                <th width='10%'>Status</th>";
                strRetorno+="</tr>";
                for(j=0; j < arrCarregar.data.length ;j++){
                    
                        
                        if(arrCarregar.data[j]['t_ds_ocorrencia']!=null){
                           ds_oc = arrCarregar.data[j]['t_ds_ocorrencia'];
                        }
                        else{
                            ds_oc = "";
                        }
                        
                        if(arrCarregar.data[j]['t_agendado_para']!=null){
                           agendado_para = arrCarregar.data[j]['t_agendado_para'];
                        }
                        else{
                            agendado_para = "";
                        }
                        
                        if(arrCarregar.data[j]['t_dt_retorno']!=null){
                           dt_retorno = arrCarregar.data[j]['t_dt_retorno'];
                        }
                        else{
                            dt_retorno = "";
                        }
                        
                        if(arrCarregar.data[j]['t_ds_retorno']!=null){
                           ds_retorno = arrCarregar.data[j]['t_ds_retorno'];
                        }
                        else{
                            ds_retorno = "";
                        }
                        
                        if(arrCarregar.data[j]['t_dt_termino_retorno']!=null){
                          dt_fechamento_retorno = arrCarregar.data[j]['t_dt_termino_retorno'];
                        }
                        else{
                            dt_fechamento_retorno = "";
                        }
                        
                        if(arrCarregar.data[j]['t_dt_fechamento']!=null){
                          dt_fechamento_oc = arrCarregar.data[j]['t_dt_fechamento'];
                        }
                        else{
                            dt_fechamento_oc = "";
                        }
                        
                        Lead = arrCarregar.data[j]['t_ds_lead']
                        dt_cad_oc = arrCarregar.data[j]['t_dt_cadastro'];
                        tipo_oc = arrCarregar.data[j]['t_ds_tipo_ocorrencia'];
                        
                        usuario_cad = arrCarregar.data[j]['t_nome_usuario_cadastro'];
                        
                        if(ic_status==1){
                            ds_status= "Aberta";
                        }
                        else if(ic_status==2){
                            ds_status = "Fechada";
                        }
                        
                        
                        

                        strRetorno+="<tr>";
                        strRetorno+="<td width='10%'>"+Lead+"</td>";
                        
                        strRetorno+="<td width='10%'>"+dt_cad_oc+"</td>";
                        strRetorno+="<td width='10%'>"+tipo_oc+"</td>";
                        strRetorno+="<td width='10%'>"+ds_oc+"</td>";
                        strRetorno+="<td width='10%'>"+usuario_cad+"</td>";
                        strRetorno+="<td width='10%'>"+dt_fechamento_oc+"</td>";
                        strRetorno+="<td width='10%'>"+agendado_para+"</td>";
                        strRetorno+="<td width='10%'>"+dt_retorno+"</td>";
                        strRetorno+="<td width='10%'>"+ds_retorno+"</td>";
                        strRetorno+="<td width='10%'>"+dt_fechamento_retorno+"</td>";
                        strRetorno+="<td width='10%'>"+ds_status+"</td>";

                        strRetorno+="</tr>";
                       
                        
            }
            strRetorno+="</tbody>";
            strRetorno+="</table>";
            strRetorno+="</div>";
            strRetorno+="</div>";
            strRetorno+="<br><br><br><br>";
            strRetorno+="</tbody>";
            strRetorno+="</table>";
            strRetorno+="</div>";
            strRetorno+="</div>";
            strRetorno+="<hr><br>";
            
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
    }
    else{
        var strNenhumRegisto = "";
        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
}

};

function fcCancelar(){

    sendPost("rel_ocorrencia_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#form").html() + '</table></body></html>';
 
    var htmlBase64 = btoa(htmlPlanilha);
    var link = "data:application/vnd.ms-excel;base64," + htmlBase64;
 
    var hyperlink = document.createElement("a");
    hyperlink.download = "export.xls";
    hyperlink.href = link;
    hyperlink.style.display = 'none';
 
    document.body.appendChild(hyperlink);
    hyperlink.click();
    document.body.removeChild(hyperlink);
}

function fcPegarTipoOC(){    
    var objParametros = {
        "pk": tipos_ocorrencias_pk
    };          
    var arrCarregar = carregarController("tipo_ocorrencia", "listarPk", objParametros);    
    $("#ds_tipo_oc").text(arrCarregar.data[0]['ds_tipo_ocorrencia']);
}
function fcPegarUsuarioCad(){    
    var objParametros = {
        "pk": usuario_cadastro_pk
    };          
    var arrCarregar = carregarController("usuario", "listarPk", objParametros);      
    $("#ds_usuario_cadastro").text(arrCarregar.data[0]['ds_usuario']);
}
function fcPegarAgendadoPara(){    
    var objParametros = {
        "pk": usuario_agendado_para
    };          
    var arrCarregar = carregarController("usuario", "listarPk", objParametros);      
    $("#ds_usuario_agendado_para").text(arrCarregar.data[0]['ds_usuario']);
}

$(document).ready(function(){    

    $(document).on('click', '#cmdCancelar', fcCancelar);
    $(document).on('click', '#cmdExport', fcExport);
    
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var hh = today.getHours();
    var min = today.getMinutes();
    var seg = today.getSeconds();
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
    if(seg<10) {
        seg = '0'+seg
    } 

    today = dd + '/' + mm + '/' + yyyy + ' '+hh+':'+min+':'+seg;


    $("#dt_emissao").text(today);
    $("#ds_lead").text(ds_lead);
    if(tipos_ocorrencias_pk!=""){
        fcPegarTipoOC();
    }
    if(usuario_cadastro_pk!=""){
       fcPegarUsuarioCad();  
    }
    if(usuario_agendado_para!=""){
        fcPegarAgendadoPara();
    }
    
    $("#dt_abertura_oc_ini_fim").text(dt_cadastro+" - "+dt_cadastro_fim);
    if(ic_status==1){
        $("#ds_status_oc").text("Aberta");
    }
    else if(ic_status==2){
        $("#ds_status_oc").text("Fechada");
    }
    
    
    fcCarregarGrid();

});


