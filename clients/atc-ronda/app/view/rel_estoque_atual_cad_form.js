var tblResultado;
var tblResultadoColab;
var click_id = 0;
var arrMes = [];



function fcCarregarGrid(){
    var strNenhumRegisto = "";
    var strRetorno = "";
        
    var objParametros = {
        "categorias_pk": categorias_pk,
        "produtos_pk": produtos_pk
    };         

    var arrCarregar = carregarController("movimentacao_estoque", "RelatorioEstoqueAtual", objParametros); 

    if (arrCarregar.result == 'success'){
        
        if(arrCarregar.data.length > 0){   
            
                    strRetorno+="<div class='row'><div class='col-md-12'>";
                    strRetorno+="<table class='table table-striped table-bordered ' style='width:100%' id='tblResultado'>";

                    strRetorno+="<tbody>";
                    strRetorno+="<tr>";
                    strRetorno+="<th width='20%'>Categoria</th>";
                    strRetorno+="<th width='20%'>Produto</th>";
                    strRetorno+="<th width='20%'>DT Cadastro Estoque</th>";
                    strRetorno+="<th width='20%'>Qtd Inicial</th>";
                    strRetorno+="<th width='20%'>Qtd Movimentada</th>";
                    strRetorno+="<th width='20%'>Qtd Atual</th>";
                    //strRetorno+="<th width='20%'>Qtd Mínima</th>";
                    strRetorno+="</tr>";
                    
                    for(i=0; i < arrCarregar.data.length ;i++){
                        if(arrCarregar.data[i]['qtde_inicial']==null){
                            var qtde_inicial = "";
                        }
                        else{
                            var qtde_inicial = arrCarregar.data[i]['qtde_inicial'];
                        }
                        if(arrCarregar.data[i]['qtde_minima']==null){
                            var qtde_minima = "";
                        }
                        else{
                            var qtde_minima = arrCarregar.data[i]['qtde_minima'];
                        }
                        if(arrCarregar.data[i]['qtde_movimentado']==null){
                            var qtde_movimentado = "";
                        }
                        else{
                            var qtde_movimentado = arrCarregar.data[i]['qtde_movimentado'];
                        }
                        
                        var qtde_atual = (qtde_inicial - qtde_movimentado);

                        strRetorno+="<tr>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['ds_categoria']+"</th>";
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['ds_produto']+"</th>";                        
                        strRetorno+="<th width='20%'>"+arrCarregar.data[i]['dt_cad_estoque']+"</th>";
                        strRetorno+="<th width='20%'>"+qtde_inicial+"</th>";
                        strRetorno+="<th width='20%'>"+qtde_movimentado+"</th>";
                        strRetorno+="<th width='20%'>"+qtde_atual+"</th>";
                        //strRetorno+="<th width='20%'>"+qtde_minima+"</th>";
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

    sendPost("rel_estoque_atual_res_form.php", {token: token});
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
    
    $("#ds_categoria").text(ds_categoria);
    $("#ds_produto").text(ds_produto);
   
    
    fcCarregarGrid();

});


