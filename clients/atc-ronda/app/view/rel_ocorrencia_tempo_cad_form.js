var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
        
    var objParametros = {
        "leads_pk": leads_pk,
        "supervisor_pk": supervisor_pk,
        "tipo_ocorrencia_pk": tipo_ocorrencia_pk,
        "dt_abertura_ini": dt_abertura_ini,
        "dt_abertura_fim": dt_abertura_fim,
        "dt_atendimento_ini": dt_atendimento_ini,
        "dt_atendimento_fim": dt_atendimento_fim
    };         

    var arrCarregar = carregarController("ocorrencia", "RelatorioOcorrenciaTempo", objParametros); 
   
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Lead</th>";
                    strRetorno+="<th width='20%'>Supervisor</th>";
                    strRetorno+="<th width='20%'>Tipo Oc</th>";
                    strRetorno+="<th width='20%'>Dt Abertura</th>";
                    strRetorno+="<th width='20%'>Dt Execução</th>";
                    strRetorno+="<th width='20%'>Qtde Dias Atendimento</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['ds_supervisor']==null){
                            var ds_supervisor = "";
                        }
                        else{
                            var ds_supervisor = arrCarregar.data[i]['ds_supervisor'];
                        }
                        if(arrCarregar.data[i]['dt_prazo_execucao']==null){
                            var dt_prazo_execucao = "";
                        }
                        else{
                            var dt_prazo_execucao = arrCarregar.data[i]['dt_prazo_execucao'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['ds_lead']+"</th>";
                        strRetorno+="<th width='20%'>"+ds_supervisor+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['ds_tipo_oc']+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['dt_cadastro']+"</th>";
                        strRetorno+="<th width='20%'>"+dt_prazo_execucao+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['qtde_dias_atendimento']+"</th>";
                        strRetorno+="</tr>";
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<br><br><br><br>";
                if(strRetorno!=""){
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

    sendPost("rel_ocorrencia_tempo_res_form.php", {token: token});
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
    $("#ds_supervisor").text(ds_supervisor);
    $("#ds_tipo_oc").text(ds_tipo_oc);
    $("#dt_abertura").text(dt_abertura_ini+" até "+dt_abertura_fim);
    $("#dt_atendimento").text(dt_atendimento_fim+" até "+dt_atendimento_fim);
    
    fcCarregarGrid();

});


