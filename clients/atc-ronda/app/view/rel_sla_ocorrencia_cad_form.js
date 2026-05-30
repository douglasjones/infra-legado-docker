var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
   
    var objParametros = {
        "leads_pk": leads_pk,
        "equipes_pk": equipes_pk,
        "dt_abertura_ini": dt_abertura_ini,
        "dt_abertura_fim": dt_abertura_fim,
        "dt_execucao_ini": dt_execucao_ini,
        "dt_execucao_fim": dt_execucao_fim,
        "dt_fechamento_ini": dt_fechamento_ini,
        "dt_fechamento_fim": dt_fechamento_fim
    };         

    var arrCarregar = carregarController("ocorrencia", "listarEquipecorrencia", objParametros); 
   
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){
            for(i=0; i < arrCarregar.data.length ;i++){
                
                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                strRetorno+="<tbody>";
                strRetorno+="<tr>";
                strRetorno+="<th width='45%'>"+arrCarregar.data[i]['ds_equipe']+"</th>";
                strRetorno+="<th width='10%'>Atendimentos</th>";
                strRetorno+="<th width='10%'>Executadas</th>";
                strRetorno+="<th width='10%'>Executadas fora do prazo</th>";
                strRetorno+="<th width='10%'>Não Executadas</th>";
                strRetorno+="<th width='10%'>Nota</th>";
                strRetorno+="</tr>";
                
                
                
                var objParametrosRel = {
                    "leads_pk": leads_pk,
                    "equipes_pk": arrCarregar.data[i]['equipes_pk'],
                    "usuario_responsavel_pk": arrCarregar.data[i]['usuario_cadastro_pk'],
                    "dt_abertura_ini": dt_abertura_ini,
                    "dt_abertura_fim": dt_abertura_fim,
                    "dt_execucao_ini": dt_execucao_ini,
                    "dt_execucao_fim": dt_execucao_fim,
                    "dt_fechamento_ini": dt_fechamento_ini,
                    "dt_fechamento_fim": dt_fechamento_fim
                };         

                var arrCarregarRel = carregarController("ocorrencia", "listarSLAOcorrencia", objParametrosRel); 
               
                if (arrCarregarRel.result == 'success'){
                   
                    if(arrCarregarRel.data.length > 0){
                        
                        for(j=0; j < arrCarregarRel.data.length ;j++){
                          
                            strRetorno+="<tr>";
                            strRetorno+="<th width='45%'>"+arrCarregarRel.data[j]['ds_tipo_ocorrencia']+"</th>";
                      
                            strRetorno+="<th width='10%'>"+arrCarregarRel.data[j]['qtde_atendimentos']+"</th>";
                     
                            strRetorno+="<th width='10%'>"+arrCarregarRel.data[j]['qtde_executada']+"</th>";
                          
                            strRetorno+="<th width='10%'>"+arrCarregarRel.data[j]['qtde_executada_atrasado']+"</th>";
                          
                            strRetorno+="<th width='10%'>"+arrCarregarRel.data[j]['qtde_nao_executado']+"</th>";
                          
                            strRetorno+="<th width='10%'>"+arrCarregarRel.data[j]['nota']+"</th>";
                         
                            strRetorno+="</tr>";
                        }
                         
                    }          
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<br><br><br><br>"; 
            }
            $("#grid").html(strRetorno);
        }          
        else{

            strNenhumRegisto+="<div class='row'>";
            strNenhumRegisto+="<div class='col-md-12 text-center'>";
            strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
            strNenhumRegisto+=" </div>";
            strNenhumRegisto+="</div>";
            $("#grid").html(strNenhumRegisto);
        }
    }
    else{
        alert('Falhar ao carregar o registro');
    }
   
}



function fcCancelar(){

    sendPost("rel_sla_ocorrencia_res_form.php", {token: token});
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

    $("#ds_equipe").text(ds_equipe);
   
    $("#dt_abertura").text(dt_abertura_ini+" até "+dt_abertura_fim);

    $("#dt_execucao").text(dt_execucao_ini+" até "+dt_execucao_ini);
  
    $("#dt_fechamento").text(dt_fechamento_ini+" até "+dt_fechamento_ini);
 
    
    fcCarregarGrid();

});


