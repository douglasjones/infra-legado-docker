
function fcCarregarGrid(){
    
  var strRetorno = "";
  var strNenhumRegisto = "";
        
    var objParametros = {
        "pk":""  
    };         

    var arrCarregar = carregarController("colaborador", "listarTodos", objParametros);  

    if (arrCarregar.result == 'success'){

        if(arrCarregar.data.length >0){

            var ds_colaborador = "";
            var ds_rg = "";
            var ds_cpf = "";
            strRetorno+="<div class='row'><div class='col-md-12'>";
            strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

            strRetorno+="<tbody>";
            strRetorno+="<tr>";
            strRetorno+="<th width='20%'>Colaborador</th><th width='20%'>RG/RE</th><th width='20%'>CPF</th>";
            strRetorno+="</tr>";
            for(j=0; j < arrCarregar.data.length ;j++){
                if(arrCarregar.data[j]['ic_status']=="Ativo"){

                   ds_colaborador = arrCarregar.data[j]['ds_colaborador'];
                   ds_rg = arrCarregar.data[j]['ds_rg'];
                   ds_cpf = arrCarregar.data[j]['ds_cpf'];


                   strRetorno+="<tr>";

                   strRetorno+="<td width='20%'>"+ds_colaborador+"</td>";
                   strRetorno+="<td width='20%'>"+ds_rg+"</td>";
                   strRetorno+="<td width='20%'>"+ds_cpf+"</td>";
                   strRetorno+="</tr>";
                }
           }
           strRetorno+="</tbody>";
           strRetorno+="</table>";
           strRetorno+="</div>";
           strRetorno+="</div>";
           strRetorno+="<hr>";

        }


    }
    else{
        alert('Falhar ao carregar o registro');
    }
    if(strRetorno!=""){
        $("#grid").append(strRetorno);
    }
    else{

        strNenhumRegisto+="<div class='row'>";
        strNenhumRegisto+="<div class='col-md-12 text-center'>";
        strNenhumRegisto+="   <h3><b>Nenhum Registro Encontrado</b></h3>";
        strNenhumRegisto+=" </div>";
        strNenhumRegisto+="</div>";
        $("#grid").append(strNenhumRegisto);
    }
}
function fcCancelar(){

    sendPost("menu_relatorios.php", {token: token});
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
    var arrCarregar = permissao("lista_autorizacao", "cons");        

    if (arrCarregar.result != 'success'){            
        alert('Falhar ao carregar o registro');
        return false;
    }
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

});


