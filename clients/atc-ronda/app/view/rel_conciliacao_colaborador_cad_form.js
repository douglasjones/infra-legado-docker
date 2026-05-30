var tblResultado;
var click_id = 0;
var arrMes = [];
arrMes['01'] = "Janeiro";
arrMes['02'] = "Fevereiro";
arrMes['03'] = "Março";
arrMes['04'] = "Abril";
arrMes['05'] = "Maio";
arrMes['06'] = "Junho";
arrMes['07'] = "Julho";
arrMes['08'] = "Agosto";
arrMes['09'] = "Setembro";
arrMes['10'] = "Outubro";
arrMes['11'] = "Novembro";
arrMes['12'] = "Dezembro";
function fcCarregarGrid(){
    
    
    var ultimoDiaMes = pegarUltimoDiaMes(ic_mes,ds_ano);
    var data = "";
    var strRetorno = "";
    var strNenhumRegisto = "";
    var dia = "";
    
    
    for(i=0;i< ultimoDiaMes;i++){
        if(i < 9){
            dia = "0"+(i+1);
             data = "0"+(i+1)+"/"+ic_mes+"/"+ds_ano;
        }
        else{
            dia = (i+1);
            data = (i+1)+"/"+ic_mes+"/"+ds_ano;
        }
        var dia_semana = pegarPosicaoDiaSemana(data);
         
        var objParametros = {
            "colaboradores_pk": colaboradores_pk,
            "dt_base": data ,
            "dia_semana": dia_semana
        };         

        var arrCarregar = carregarController("agenda_colaborador_padrao", "relatorioAgendaColaborador", objParametros);  
        
        if (arrCarregar.result == 'success'){
            
            if(arrCarregar.data.length > 0){
                var ds_lead = "";
                var ds_turno = "";
                var ds_dia_semana = "";

                strRetorno+="<div class='row'>";
                strRetorno+="<div class='col-md-12'>";
                strRetorno+="   <h3><b>"+data+"</b></h3>";
                strRetorno+=" </div>";
                strRetorno+="</div>";

                strRetorno+="<div class='row'><div class='col-md-12'>";
                strRetorno+="<table class='table table-striped table-bordered tblResultado' style='width:100%' id='tblResultado'>";
                strRetorno+="<thead><tr>";
                strRetorno+="<th width='33%'>Lead</th><th width='33%'>Turnos</th><th width='33%'>Dias da Semana</th>";
                strRetorno+="</tr></thead>";
                strRetorno+="<tbody>";
                for(j=0; j < arrCarregar.data.length ;j++){

                    ds_lead = arrCarregar.data[j]['t_ds_lead'];
                    ds_turno = arrCarregar.data[j]['t_ds_turno'];
                    ds_dia_semana = arrCarregar.data[j]['t_ds_dia_semana'];

                    strRetorno+="<tr>";
                    strRetorno+="<td width='33%'>"+ds_lead+"</td>";
                    strRetorno+="<td width='33%'>"+ds_turno+"</td>";
                    strRetorno+="<td width='33%'>"+ds_dia_semana+"</td>";
                    strRetorno+="</tr>";
                }
                strRetorno+="</tbody>";
                strRetorno+="</table>";
                strRetorno+="</div>";
                strRetorno+="</div>";
                strRetorno+="<hr><br>";
            }
            
            
        }
        else{
            alert('Falhar ao carregar o registro');
        }
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

pegarUltimoDiaMes = function(year, month){
    var ultimoDia = (new Date(year, month, 0)).getDate();
    return ultimoDia;
};

function pegarPosicaoDiaSemana(data){
    
    var splitData = data.split("/");
    var semana = [0, 1, 2, 3, 4, 5,6];
    var d = new Date(splitData[2], splitData[1] - 1, splitData[0]);
    return semana[d.getDay()];
}

function fcCarregarColaborador(){
    
    var objParametros = {
        "pk": colaboradores_pk
    };      
    
    var arrCarregar = carregarController("colaborador", "listarPk", objParametros); 
    if (arrCarregar.result == 'success'){
        $("#ds_colaborador").text(arrCarregar.data[0]['ds_colaborador']);
    }
        
}

function fcCancelar(){

    sendPost("rel_conciliacao_colaborador_res_form.php", {token: token});
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
    
    
    fcCarregarColaborador();
    
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
    $("#ic_mes").text(arrMes[ic_mes]);
    $("#ds_ano").text(ds_ano);
    fcCarregarGrid();

});


