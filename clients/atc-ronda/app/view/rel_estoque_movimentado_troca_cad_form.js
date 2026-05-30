var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var DtAtual = new Date();
    var strNenhumRegisto = "";
    var strRetorno = "";
        
    var objParametros = {
        "leads_pk": leads_pk,
        "colaboradores_pk": colaboradores_pk,
        "produtos_pk": produtos_pk,
        "categorias_pk": categorias_pk,
        "dt_troca_ini": dt_troca_ini,
        "dt_troca_fim": dt_troca_fim
    };         

    var arrCarregar = carregarController("movimentacao_estoque", "relatorioMovimentacaoEstoqueTroca", objParametros); 
   
    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Categoria</th>";
                    strRetorno+="<th width='20%'>Produto</th>";
                    //strRetorno+="<th width='20%'>Tempo Troca</th>";
                    strRetorno+="<th width='20%'>Dt Movimentação</th>";
                    //strRetorno+="<th width='20%'>Dt Troca</th>";
                    //strRetorno+="<th width='20%'>Status</th>";
                    strRetorno+="<th width='20%'>Lead</th>";
                    strRetorno+="<th width='20%'>Colaborador</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        var dt_compare = arrCarregar.data[i]['t_dt_troca_usa'];
                        var date_comparacao = new Date(dt_compare);
                        if(arrCarregar.data[i]['t_ds_lead']==null){
                            var ds_lead = "";
                        }
                        else{
                            var ds_lead = arrCarregar.data[i]['t_ds_lead'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_ds_categorias_produto']+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_ds_produto']+"</th>";
                        //strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_ds_tempo_troca']+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_dt_movimentacao']+"</th>";
                        //strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_dt_troca']+"</th>";
                       
                        /*if(date_comparacao > DtAtual){
                            strRetorno+="<th width='20%'>No prazo</th>";
                        }
                        else{
                            strRetorno+="<th width='20%'>Trava Vencida</th>";
                        }*/
                        
                        strRetorno+="<th width='20%'>"+ds_lead+"</th>";
                        if(arrCarregar.data[i]['t_ds_colaborador']!=null){
                            strRetorno+="<th width='20%'>"+arrCarregar.data[i]['t_ds_colaborador']+"</th>";
                        }
                        else{
                            strRetorno+="<th width='20%'></th>";
                        }
                        
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

    sendPost("rel_estoque_movimentado_troca_res_form.php", {token: token});
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
    $("#ds_colaborador").text(ds_colaborador);
    $("#ds_produto").text(ds_produto);
    $("#ds_categoria").text(ds_categoria);
    $("#dt_troca").text(dt_troca_ini+" até "+dt_troca_fim);
    
    fcCarregarGrid();

});


