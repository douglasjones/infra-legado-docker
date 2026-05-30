var tblResultado;
function fcCarregarGrid(){
    var objParametros = {
        "leads_pk": leads_pk,
        "dt_ini": dt_ini,
        "dt_fim": dt_fim,
        "supervisores_pk": supervisores_pk,
        "auditorias_categorias_pk": categorias_pk,
        "auditorias_categorias_tipos_pk": tipos_categorias_pk
    };     
    
    var arrCarregar = carregarController("supervisao_auditoria", "listarDadosRelSupervisao", objParametros);

    //Trata a tabela
    if (arrCarregar.result == 'success'){
        if(arrCarregar.data.length > 0){
            var strRetorno = "";
            var ds_lead = "";
            var ds_usuario_cadastro = "";
            var ds_categoria = "";
            var ds_auditoria_categoria_tipo = "";
            var dt_cadastro = "";
            var ds_supervisor = "";
            var ds_localizacao = "";
            var obs_geral = "";
            var auditoria_categoria_tipos_pk = "";
            var supervisao_auditorias_pk = "";

            strRetorno+="<div class='row'><div class='col-md-12'>";
            strRetorno+="   <table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";
            strRetorno+="       <tbody>";
            strRetorno+="           <tr>";
            strRetorno+="               <th><input type='text' id='txtPostoTrabalho' /></th>";
            strRetorno+="               <th><input type='text' id='txtSupervisor' /></th>";
            strRetorno+="               <th><input type='text' id='txtCategoria' /></th>";
            strRetorno+="               <th><input type='text' id='txtTipoCategoria' /></th>";
            strRetorno+="               <th><input type='text' id='txtDtCategoria' /></th>";
            strRetorno+="               <th><input type='text' id='txtLocalizacao' /></th>";
            strRetorno+="               <th><input type='text' id='txtObservacao' /></th>";
            strRetorno+="           </tr>";
            strRetorno+="           <tr>";
            strRetorno+="             <th width='10%'>Posto Trabalho</th>\n\
                                      <th width='10%'>Supervisor</th>\n\
                                      <th width='10%'>Categoria</th>\n\
                                      <th width='10%'>Tipo Categoria</th>\n\
                                      <th width='10%'>Dt Categoria</th>\n\
                                      <th width='10%'>Localização</th>\n\
                                      <th width='10%'>Observação</th>\n\
                                      <th width='10%'>Ação</th>";
            strRetorno+="           </tr>";

            for(j=0; j < arrCarregar.data.length; j++){
                //Verificações de variaveis 
                arrCarregar.data[j]['ds_lead']!=null? ds_lead = arrCarregar.data[j]['ds_lead']:ds_lead = "";
                arrCarregar.data[j]['ds_usuario_cadastro']!=null? ds_usuario_cadastro = arrCarregar.data[j]['ds_usuario_cadastro']:ds_usuario_cadastro = "";
                arrCarregar.data[j]['ds_categoria']!=null? ds_categoria = arrCarregar.data[j]['ds_categoria']:ds_categoria = "";
                arrCarregar.data[j]['ds_auditoria_categoria_tipo']!=null? ds_auditoria_categoria_tipo = arrCarregar.data[j]['ds_auditoria_categoria_tipo']:ds_auditoria_categoria_tipo = "";
                arrCarregar.data[j]['dt_cadastro']!=null? dt_cadastro = arrCarregar.data[j]['dt_cadastro']:dt_cadastro = "";
                arrCarregar.data[j]['ds_localizacao']!=null? ds_localizacao = arrCarregar.data[j]['ds_localizacao']:ds_localizacao = "";
                arrCarregar.data[j]['obs_geral']!=null? obs_geral = arrCarregar.data[j]['obs_geral']:obs_geral = "";
                arrCarregar.data[j]['auditoria_categoria_tipos_pk']!=null? auditoria_categoria_tipos_pk = arrCarregar.data[j]['auditoria_categoria_tipos_pk']:auditoria_categoria_tipos_pk = "";
                arrCarregar.data[j]['supervisao_auditorias_pk']!=null? supervisao_auditorias_pk = arrCarregar.data[j]['supervisao_auditorias_pk']:supervisao_auditorias_pk= "";
                
                strRetorno+="   <tr>";
                strRetorno+="       <td width='10%'>"+ds_lead+"</td>";
                strRetorno+="       <td width='10%'>"+ds_usuario_cadastro+"</td>";
                strRetorno+="       <td width='10%'>"+ds_categoria+"</td>";
                strRetorno+="       <td width='10%'>"+ds_auditoria_categoria_tipo+"</td>";
                strRetorno+="       <td width='10%'>"+dt_cadastro+"</td>";
                strRetorno+="       <td width='10%'>"+ds_localizacao+"</td>";
                strRetorno+="       <td width='10%'>"+obs_geral+"</td>";
                strRetorno+="       <td>";
                strRetorno+="           <a title='Auditoria' onclick='fcAbrirJanelaAuditoria("+supervisao_auditorias_pk+","+auditoria_categoria_tipos_pk+")'><img width=20 height=20 src='../img/copiar.png'></a>";
                strRetorno+="           <a title='Auditoria Documentos' onclick='fcAbrirJanelaAuditoriaDocumentos("+supervisao_auditorias_pk+")'><img width=20 height=20 src='../img/download.png'></a>";
                strRetorno+="       </td>";
                strRetorno+="   </tr>";       
                    
            }
            strRetorno+="           </tbody>";
            strRetorno+="       </table>";
            strRetorno+="   </div>";
            strRetorno+="</div>";
            strRetorno+="<br><br><br><br>";
        }else{
            var strNenhumRegisto = "";
            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+=" </div>";
            $("#grid").append(strNenhumRegisto);
        }

        if(strRetorno!=""){
            $("#grid").append(strRetorno);
        }else{
            var strNenhumRegisto = "";
            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+="</div>";
            $("#grid").append(strNenhumRegisto);
        }
    
    }
}

function fcCancelar(){
    sendPost("rel_auditorias_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#grid").html() + '</table></body></html>';
 
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

function fcAbrirJanelaAuditoria(supervisao_auditorias_pk, auditoria_categoria_tipos_pk) {  
    $("#auditoria_categoria_form").html(" "); 
    fcCarregarForm(supervisao_auditorias_pk, auditoria_categoria_tipos_pk)
    $("#janela_auditoria_form").modal();  
}

function fcCarregarForm(supervisao_auditorias_pk, auditoria_categoria_tipos_pk){
    if(supervisao_auditorias_pk > 0){
        var objParametros = {
            "supervisao_auditorias_pk": supervisao_auditorias_pk,
            "auditoria_categoria_tipos_pk": auditoria_categoria_tipos_pk
        };

        var arrCarregar = carregarController("supervisao_auditorias_itens", "listarValoresCamposForm", objParametros);
        if (arrCarregar.result == 'success'){
            for(var i=0; i < arrCarregar.data.length; i++){
                var html = "";
                html += "<input type='hidden' id='auditorias_categorias_itens_pk_"+i+"' name='auditorias_categorias_itens_pk_"+i+"' value='"+arrCarregar.data[i]['pk']+"'>";
                if(arrCarregar.data[i]['tipo_item_pk'] == "1"){
                    html += "<div class='row'>";
                    html += "   <div class='col-md-4'>";
                    html += "       &nbsp;";
                    html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                    html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='select'>";
                    html += "   </div>";
                    html += "   <div class='col-md-4'>";
                    html += "       <br>";
                    html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                    html += "       <select disabled readonly='readonly' tabindex='-1' aria-disabled='true' class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>";
                    html += "           <option></option>";
                    for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                        if(arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_dados'] == arrCarregar.data[i]['itensDados'][l]['pk']){
                            html += "       <option value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'selected>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+"</option>"; 
                        }
                    }
                    html += "       </select>";
                    html += "   </div>";
                    html += "</div>";
                }else if(arrCarregar.data[i]['tipo_item_pk'] == "2"){
                    arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_dados']!=null? ds_resultado_dados = arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_dados']:ds_resultado_dados= "";
                
                    html += "<div class='row'>";
                    html += "   <div class='col-md-4'>";
                    html += "       &nbsp;";
                    html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                    html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='text'>";
                    html += "   </div>";
                    html += "   <div class='col-md-4'>";
                    html += "       <br>";
                    html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                    html += "       <input class='form-control form-control-sm' disabled readonly='readonly' tabindex='-1' aria-disabled='true' type='text' id='campo_"+i+"' name='campo_"+i+"' value="+ds_resultado_dados+">";
                    html += "   </div>";
                    html += "</div>";
                }else if(arrCarregar.data[i]['tipo_item_pk'] == "3"){
                    html += "<div class='row'>";
                    html += "   <div class='col-md-4'>";
                    html += "       &nbsp;";
                    html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='checkbox'>";
                    html += "   </div>";
                    html += "   <div class='col-md-4'>";
                    html += "       <br>";
                    if(arrCarregar.data[i]['itensDados'].length > 0){
                        html += "       <b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b><hr style='margin-top:0'>";
                        for(var l=0; l<arrCarregar.data[i]['itensDados'].length; l++){
                            html += "       <input type='hidden' id='pk_campo_"+i+"_"+l+"' name='pk_campo_"+i+"_"+l+"'value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['pk']+">";
                            html += "   <label for='campo_"+i+"_"+l+"'>"+arrCarregar.data[i]['itensDados'][l]['ds_item_dados']+":&nbsp;</label>";
                            if(arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['ic_checkbox'] == "1"){
                                html += "   <input disabled readonly='readonly' tabindex='-1' aria-disabled='true' type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"' checked><br>";
                            }else{
                                html += "   <input disabled readonly='readonly' tabindex='-1' aria-disabled='true' type='checkbox' id='campo_"+i+"_"+l+"' name='campo"+i+"_"+l+"' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'><br>";
                            }
                        }
                    }else{
                        html += "   <label for='campo_"+i+"_"+l+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;<b></label>";
                        html += "       <input type='hidden' id='pk_campo_"+i+"_0' name='pk_campo_"+i+"_0' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                            if(arrCarregar.data[i]['supervisaoAuditoriasItens'][l]['ic_checkbox'] == "1"){
                                html += "   <input disabled readonly='readonly' tabindex='-1' aria-disabled='true' type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"' checked><br>";
                            }else{
                                html += "   <input disabled readonly='readonly' tabindex='-1' aria-disabled='true' type='checkbox' id='campo_"+i+"_0' name='campo"+i+"_0' value='"+arrCarregar.data[i]['itensDados'][l]['pk']+"'><br>";
                            }
                    }
                    html += "       <input type='hidden' id='qtd_checkbox_"+i+"' name='qtd_checkbox_"+i+"'' value='"+l+"'>";
                    html += "   </div>";
                    html += "</div>";
                }else if(arrCarregar.data[i]['tipo_item_pk'] == "4"){ 
                    arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_textarea']!=null? ds_resultado_textarea = arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['ds_resultado_textarea']:ds_resultado_textarea= "";

                    html += "<div class='row'>";
                    html += "   <div class='col-md-4'>";
                    html += "       &nbsp;";
                    html += "       <input type='hidden' id='pk_campo_"+i+"' name='pk_campo_"+i+"' value="+arrCarregar.data[i]['supervisaoAuditoriasItens'][0]['pk']+">";
                    html += "       <input type='hidden' id='ds_tipo_campo_"+i+"' name='ds_tipo_campo_"+i+"'' value='textarea'>";
                    html += "   </div>";
                    html += "   <div class='col-md-4'>";
                    html += "       <label for='campo_"+i+"'><b>"+arrCarregar.data[i]['ds_categoria_item']+":&nbsp;</b></label>";
                    html += "       <textarea disabled readonly='readonly' tabindex='-1' aria-disabled='true' class='form-control form-control-sm' id='campo_"+i+"' name='campo_"+i+"'>"+ds_resultado_textarea+"</textarea>";
                    html += "   </div>";
                    html += "</div>";
                }
                $( "#auditoria_categoria_form" ).append( html ); 
            }
            $( "#qtd_campos" ).val(i); 
        }else{
            alert('Falhar ao carregar o registro');
        }   
    } 
    
}

function fcCarregarGridDocumentos(supervisao_auditorias_pk){
    var objParametros = {
        "supervisao_auditorias_pk": supervisao_auditorias_pk,
    };     
    
    var arrCarregarDocumentos = carregarController("supervisao_auditoria_documentos", "listarDataTable", objParametros);

    var strRetorno = " ";
    strRetorno+="   <table class='table table-striped' style='width:100%' id='tblDocumentos'>";
    strRetorno+="       <tbody>";
    strRetorno+="           <tr>";
    strRetorno+="             <th width='10%'>Código</th>\n\
                                <th width='10%'>Documento</th>\n\
                                <th width='10%'>Observação</th>\n\
                                <th width='10%'>Nome Original</th>\n\
                                <th width='10%'>Ação</th>";
    strRetorno+="           </tr>";

    for(j=0; j < arrCarregarDocumentos.data.length; j++){
        arrCarregarDocumentos.data[j]['t_pk']!=null? pk = arrCarregarDocumentos.data[j]['t_pk']:pk = "";
        arrCarregarDocumentos.data[j]['t_ds_documento']!=null? ds_documento = arrCarregarDocumentos.data[j]['t_ds_documento']:ds_documento = "";
        arrCarregarDocumentos.data[j]['t_ds_obs']!=null? ds_obs = arrCarregarDocumentos.data[j]['t_ds_obs']:ds_obs = "";
        arrCarregarDocumentos.data[j]['t_ds_nome_original']!=null? ds_nome_original = arrCarregarDocumentos.data[j]['t_ds_nome_original']:ds_nome_original = "";
            
        //Verificações de variaveis 
        strRetorno+="   <tr>";
        strRetorno+="       <td width='10%'>"+pk+"</td>";
        strRetorno+="       <td width='10%'>"+ds_documento+"</td>";
        strRetorno+="       <td width='10%'>"+ds_obs+"</td>";
        strRetorno+="       <td width='10%'>"+ds_nome_original+"</td>";
        strRetorno+="       <td>";
        strRetorno+='          <a title="Download Documentos" onClick="fcDownloadDocumento(&apos;'+arrCarregarDocumentos.data[j]['t_ds_documento']+'&apos;)"><img width=20 height=20 src="../img/download.png"></a>';
        strRetorno+="       </td>";
        strRetorno+="   </tr>";       
            
    }
    strRetorno+="           </tbody>";
    strRetorno+="       </table>";
    
    $("#tbldocs").append(strRetorno); 

}

function fcDownloadDocumento(ds_documento){ 
    var v_url = "../docs/"+ds_documento;
    NewWindow(v_url, '_blank');
}

function fcAbrirJanelaAuditoriaDocumentos(supervisao_auditorias_pk) { 
    $("#tbldocs").html(" ");
    fcCarregarGridDocumentos(supervisao_auditorias_pk); 
    $("#janela_auditoria_documentos").modal();
    
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
  
    $("#ds_supervisor").text(ds_supervisor);
    $("#ds_lead").text(ds_lead);
    $("#dt_cadastro").text(dt_ini+" - "+dt_fim);
    $("#ds_tipos_categorias").text(ds_tipos_categorias);
    $("#ds_categorias").text(ds_categorias);

    //faz a carga inicial do grid.
    fcCarregarGrid();

    $("#tblResultado input").keyup(function(){
        var index = $(this).parent().index();
        var nth = "#tblResultado td:nth-child("+(index+1).toString()+")";
        var valor = $(this).val().toUpperCase();
        $("#tblResultado tbody tr").show();
        $(nth).each(function(){
                if($(this).text().toUpperCase().indexOf(valor) < 0){
                        $(this).parent().hide();
                }
        });
    });
    $("#tblResultado input").blur(function(){
            $(this).val("");
    });	
});


