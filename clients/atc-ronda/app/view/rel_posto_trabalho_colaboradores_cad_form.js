var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";

    var objParametros = {
        "colaboradores_pk": colaboradores_pk,
        "leads_pk": leads_pk
    };         

    var arrCarregar = carregarController("lead", "relPosto_Colaborador", objParametros); 

    if (arrCarregar.result == 'success'){        
        if(arrCarregar.data.length > 0){  

            strRetorno+="<div class='row'><div class='col-md-12'>";
            strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";
            strRetorno+="<tbody>";
            strRetorno+="<tr>";

            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Posto de Trabalho</th>";
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Colaborador</th>";
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Tipo Escala</th>";
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Função</th>";   
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Dt Inicio Escala</th>";   
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Dt Fim Escala</th>";   
            strRetorno+="<th width='20%' style='text-align: center; font-size: 18px'>Dt Cancelamento</th>";   
            strRetorno+="</tr>";                    
            
                for(i=0; i < arrCarregar.data.length ;i++){

                    if(arrCarregar.data[i]['ds_lead']==null){
                        var ds_lead = "";
                    }else{
                        var ds_lead = arrCarregar.data[i]['ds_lead'];
                    }

                    if(arrCarregar.data[i]['ds_colaborador']==null){
                        var ds_colaborador = "";
                    }else{
                        var ds_colaborador = arrCarregar.data[i]['ds_colaborador'];
                    }

                    if(arrCarregar.data[i]['n_qtde_dias_semana']==null){
                        var tipo_escala = "";
                    }else{
                        var tipo_escala = arrCarregar.data[i]['n_qtde_dias_semana'];
                    }

                    if(arrCarregar.data[i]['ds_produto_servico']==null){
                        var ds_funcao = "";
                    }else{
                        var ds_funcao = arrCarregar.data[i]['ds_produto_servico'];
                    }

                    if(arrCarregar.data[i]['dt_inicio_agenda']==null){
                        var dt_inicio_agenda = "";
                    }else{
                        var dt_inicio_agenda = arrCarregar.data[i]['dt_inicio_agenda'];
                    }

                    if(arrCarregar.data[i]['dt_fim_agenda']==null){
                        var dt_fim_agenda = "";
                    }else{
                        var dt_fim_agenda = arrCarregar.data[i]['dt_fim_agenda'];
                    }

                    if(arrCarregar.data[i]['dt_cancelamento']==null){
                        var dt_cancelamento = "";
                    }else{
                        var dt_cancelamento = arrCarregar.data[i]['dt_cancelamento'];
                    }
                  
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>"+ds_lead+"</th>";
                    strRetorno+="<th width='20%'>"+ds_colaborador+"</th>";        
                    strRetorno+="<th width='20%'>"+tipo_escala+"</th>";
                    strRetorno+="<th width='20%'>"+ds_funcao+"</th>";                    
                    strRetorno+="<th width='20%'>"+dt_inicio_agenda+"</th>";
                    strRetorno+="<th width='20%'>"+dt_fim_agenda+"</th>";
                    strRetorno+="<th width='20%'>"+dt_cancelamento+"</th>";
                    strRetorno+="</tr>";
                    
            }
         
            strRetorno+="</tbody>";
            strRetorno+="</table>";
            strRetorno+="</div>";
            strRetorno+="</div>";
            strRetorno+="<br><br><br><br>";
     
            if(strRetorno!=""){
                $("#grid").html(strRetorno);
            }else{

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

    sendPost("rel_posto_trabalho_colaboradores_res_form.php", {token: token});
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
  
    $("#ds_colaborador").text(ds_colaborador);
    $("#ds_lead").text(ds_lead);
    $("#dt_escala_reserva").text(dt_ini+" até "+dt_fim);
   
    fcCarregarGrid();

});


