var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
      
    var objParametros = {
        "colaborador_pk": colaboradores_pk,
        "leads_pk": leads_pk
    };         

    var arrCarregar = carregarController("agenda_colaborador_padrao", "RelatorioPostoTrabalhoXColaborador", objParametros); 
   
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   

                    
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="       <tr>";
                    strRetorno+="            <th><input type='text' id='rxtPostoTrabalho' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFuncao' /></th>";
                    strRetorno+="            <th><input type='text' id='txtRE' /></th>";
                    strRetorno+="            <th><input type='text' id='txtColaborador' /></th>";
                    strRetorno+="            <th><input type='text' id='txtTurno' /></th>";
                    strRetorno+="            <th><input type='text' id='txtFerias' /></th>";
                    strRetorno+="            <th><input type='text' id='txtEscala' /></th>";
                    strRetorno+="            <th><input type='text' id='txtDtEntradaPonto' /></th>";
                    strRetorno+="       </tr>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Posto de Trabalho</th>";
                    strRetorno+="<th width='20%'>Status Posto de Trabalho</th>";
                    strRetorno+="<th width='20%'>R.E</th>";
                    strRetorno+="<th width='20%'>Colaborador</th>";
                    strRetorno+="<th width='20%'>Status Colaborador</th>";
                    strRetorno+="<th width='20%'>Qualificação</th>";
                    strRetorno+="<th width='20%'>Periodo</th>";
                    strRetorno+="<th width='20%'>Escala</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['ds_lead']==null){
                            var ds_lead = "";
                        }
                        else{
                            var ds_lead = arrCarregar.data[i]['ds_lead'];
                        }
                        if(arrCarregar.data[i]['ds_status']==null){
                            var ds_status = "";
                        }
                        else{
                            var ds_status = arrCarregar.data[i]['ds_status'];
                        }
                        if(arrCarregar.data[i]['ds_re']==null){
                            var ds_re = "";
                        }
                        else{
                            var ds_re = arrCarregar.data[i]['ds_re'];
                        }
                        if(arrCarregar.data[i]['ds_colaborador']==null){
                            var ds_colaborador = "";
                        }
                        else{
                            var ds_colaborador = arrCarregar.data[i]['ds_colaborador'];
                        }
                        if(arrCarregar.data[i]['ds_status_colaborador']==null){
                            var ds_status_colaborador = "";
                        }
                        else{
                            var ds_status_colaborador = arrCarregar.data[i]['ds_status_colaborador'];
                        }
                        if(arrCarregar.data[i]['ds_produto_servico']==null){
                            var ds_produto_servico = "";
                        }
                        else{
                            var ds_produto_servico = arrCarregar.data[i]['ds_produto_servico'];
                        }
                        if(arrCarregar.data[i]['periodo']==null){
                            var periodo = "";
                        }
                        else{
                            var periodo = arrCarregar.data[i]['periodo'];
                        }
                        if(arrCarregar.data[i]['n_qtde_dias_semana']==null){
                            var n_qtde_dias_semana = "";
                        }
                        else{
                            var n_qtde_dias_semana = arrCarregar.data[i]['n_qtde_dias_semana'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+ds_lead+"</th>";
                        strRetorno+="<th width='20%'>"+ds_status+"</th>";
                        strRetorno+="<th width='20%'>"+ds_re+"</th>";
                        strRetorno+="<th width='20%'>"+ds_colaborador+"</th>";
                        strRetorno+="<th width='20%'>"+ds_status_colaborador+"</th>";
                        strRetorno+="<th width='20%'>"+ds_produto_servico+"</th>";
                        strRetorno+="<th width='20%'>"+periodo+"</th>";
                        strRetorno+="<th width='20%'>"+n_qtde_dias_semana+"</th>";
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

    sendPost("rel_posto_trabalho_x_colaborador_res_form.php", {token: token});
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
  fcCarregarGrid();
    $("#ds_colaborador").text(ds_colaborador);
    $("#ds_lead").text(ds_lead);
     $("#tabela input").keyup(function(){
            var index = $(this).parent().index();
            var nth = "#tabela td:nth-child("+(index+1).toString()+")";
            var valor = $(this).val().toUpperCase();
            $("#tabela tbody tr").show();
            $(nth).each(function(){
                    if($(this).text().toUpperCase().indexOf(valor) < 0){
                            $(this).parent().hide();
                    }
            });
    });
    $("#tabela input").blur(function(){
            $(this).val("");
    });	
    $("#loader").hide();
    $("#exibir").show();
   
    

});


