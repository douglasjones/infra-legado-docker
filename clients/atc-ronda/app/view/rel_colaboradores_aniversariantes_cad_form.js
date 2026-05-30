var tblResultado;

function fcCarregarGrid(){
      
    var objParametros = {
        "mes_pk": mes_aniversario_pk
    };         

    var arrCarregar = carregarController("colaborador", "relatorioAniversariantesMes", objParametros);
  
    if (arrCarregar.result == 'success'){
        var strRetorno = "";
        var strNenhumRegisto = "";
        if(arrCarregar.data.length > 0){  
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th>Nome</th>";
                    strRetorno+="<th>Posto de Trabalho</th>";
                    strRetorno+="<th>Dt. de Nascimento</th>";
                    strRetorno+="<th>Escala</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['ds_colaborador']==null){
                            var ds_nome = "";
                        }
                        else{
                            var ds_nome = arrCarregar.data[i]['ds_colaborador'];
                        }
                        if(arrCarregar.data[i]['dt_nascimento']==null){
                            var dt_nascimento = "";
                        }
                        else{
                            var dt_nascimento = arrCarregar.data[i]['dt_nascimento'];
                        }
                        if(arrCarregar.data[i]['ds_lead']==null){
                            var ds_lead = "";
                        }
                        else{
                            var ds_lead = arrCarregar.data[i]['ds_lead'];
                        }
                        if(arrCarregar.data[i]['n_qtde_dias_semana']==null){
                            var n_qtde_dias_semana = "";
                        }
                        else{
                            var n_qtde_dias_semana = arrCarregar.data[i]['n_qtde_dias_semana'];
                        }

                        strRetorno+="<tr>";
                        strRetorno+="<th >"+ds_nome+"</th>";
                        strRetorno+="<th >"+ds_lead+"</th>";
                        strRetorno+="<th >"+dt_nascimento+"</th>";
                        strRetorno+="<th >"+n_qtde_dias_semana+"</th>";
                       
                        strRetorno+="</tr>";
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<br><br><br><br>";
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

    sendPost("rel_colaboradores_aniversariantes_res_form.php", {token: token});
}

function fcExport(){

    var htmlPlanilha = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
    htmlPlanilha += '<head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>PlanilhaTeste</x:Name>';
    htmlPlanilha += '<x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml>';
    htmlPlanilha += '<![endif]--></head><body><table>' + $("#tblResultado").html() + '</table></body></html>';
 
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
    $("#ds_mes").text(ds_mes_aniversario);
    fcCarregarGrid();
    $("#loader").hide();
    $("#exibir").show();
   
    

});


